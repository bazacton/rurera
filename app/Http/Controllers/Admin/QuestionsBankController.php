<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Glossary;
use App\Models\QuizzesQuestion;
use App\Models\Translation\QuizzesQuestionTranslation;
use App\Models\Category;
use App\Models\QuizzesResult;
use App\Models\Translation\QuizTranslation;
use App\Models\Translation\WebinarChapterTranslation;
use App\Models\Webinar;
use App\Models\WebinarChapter;
use App\Models\SubChapters;
use App\Models\WebinarChapterItem;
use App\Models\QuestionLogs;
use App\Models\QuestionAuthorPoints;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Elasticsearch;

class QuestionsBankController extends Controller
{

    function getDirContents($dir, &$results = array()) {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                if (in_array($ext, array('html','htaccess'))) {
                    unlink($path);
                    $results[] = $path;
                }
            } else if ($value != "." && $value != "..") {
                $this->getDirContents($path, $results);
                //$results[] = $path;
            }
        }

        return $results;
    }

    public function index(Request $request)
    {

        //pre($this->getDirContents('New folder/store/'));

        $user = auth()->user();
        $this->authorize('admin_questions_bank');

        removeContentLocale();

        $query = QuizzesQuestion::query();


        $query->where('quizzes_questions.question_status' , '!=' , 'Deleted');

        if (auth()->user()->isReviewer()) {
            $query->where('quizzes_questions.question_status' , '!=' , 'Draft');
            //$query->where('quizzes_questions.question_status', 'Submit for review');
        }

        if (auth()->user()->isAuthor()) {
            $query->where('quizzes_questions.creator_id' , $user->id);
        }


        $totalQuestions = deepClone($query)->count();

        $in_review = clone $query;
        $approved = clone $query;
        $improvement = clone $query;
        $hold_reject = clone $query;

        $in_review->where('quizzes_questions.question_status' , 'Submit for review');
        $totalInReview = deepClone($in_review)->count();

        $approved->whereIn('quizzes_questions.question_status' , array('Offline' , 'Accepted' , 'Published'));
        $totalApproved = deepClone($approved)->count();

        $improvement->where('quizzes_questions.question_status' , 'Improvement required');
        $totalImprovement = deepClone($improvement)->count();

        $hold_reject->whereIn('quizzes_questions.question_status' , array('On hold' , 'Hard reject'));
        $totalHoldReject = deepClone($hold_reject)->count();

        $query = $this->filters($query , $request);


        $questions = $query->with([
            'course' ,
            'category' ,
            'subChapter' ,
        ])->select('*')->paginate(50);

        $foundRecords = deepClone($query)->count();


        $categories = Category::where('parent_id' , null)
            ->with('subCategories')
            ->get();

        $chapters_list = get_chapters_list();

        $data = [
            'pageTitle'           => trans('admin/pages/quiz.admin_quizzes_list') ,
            'questions'           => $questions ,
            'totalQuestions'      => $totalQuestions ,
            'totalInReview'       => $totalInReview ,
            'totalApproved'       => $totalApproved ,
            'totalImprovement'    => $totalImprovement ,
            'totalHoldReject'     => $totalHoldReject ,
            'foundRecords'        => $foundRecords ,
            'totalActiveQuizzes'  => 0 ,
            'totalStudents'       => 0 ,
            'categories'          => $categories ,
            'totalPassedStudents' => 0 ,
            'user'                => $user ,
        ];

        $data['chapters'] = $chapters_list;

        return view('admin.questions_bank.lists' , $data);
    }

    /*
     * Create Question
     */

    public function create()
    {
        $user = auth()->user();
        $this->authorize('admin_questions_bank_create');

        $data = [
            'pageTitle' => trans('quiz.new_question') ,
        ];
        $glossary = Glossary::where('status' , 'active')->orWhere('created_by' , $user->id)
            ->get();

        $categories = Category::where('parent_id' , null)
            ->with('subCategories')
            ->get();

        $chapters_list = get_chapters_list();

        $data['chapters'] = $chapters_list;
        $data['glossary'] = $glossary;
        $data['user'] = $user;
        $data['categories'] = $categories;

        return view('admin.questions_bank.create_question' , $data);
    }

    public function create_sub_chapters_auto(Request $request , $success = '')
    {
        $this->authorize('admin_questions_bank_create');

        $data = [
            'pageTitle' => 'Sub Chapters Auto' ,
        ];

        $lessons = \Illuminate\Support\Facades\DB::table('webinar_chapters')
            ->join('webinar_chapter_translations' , 'webinar_chapter_translations.webinar_chapter_id' , '=' , 'webinar_chapters.id')
            ->select('webinar_chapters.webinar_id' , 'webinar_chapters.id' , 'webinar_chapter_translations.title');

        $lessons = $lessons->get();



        $webinars = \Illuminate\Support\Facades\DB::table('webinars')
                    ->join('webinar_translations' , 'webinar_translations.webinar_id' , '=' , 'webinars.id')
                    ->join('category_translations' , 'category_translations.category_id' , '=' , 'webinars.category_id')
                    ->select('webinars.id' , 'webinar_translations.title', 'category_translations.title as category_title');

        $webinars = $webinars->get();

        $data['webinars'] = $webinars;

        $glossary = Glossary::where('status' , 'active')
            ->get();

        $chapters_list = get_chapters_list();
        $data['chapters'] = $chapters_list;
        $data['glossary'] = $glossary;
        $data['lessons'] = $lessons;
        $data['success'] = isset($_GET['success']) ? $_GET['success'] : '';

        return view('admin.questions_bank.create_sub_chapters_auto' , $data);
    }

    public function store_sub_chapters_auto()
    {
        $quiz_list = explode("\n" , $_POST['quiz_list']);
        $chapter_id = isset($_POST['category_id']) ? $_POST['category_id'] : 0;
        $WebinarChapter = WebinarChapter::find($chapter_id);
        $webinar_id = $WebinarChapter->webinar_id;
        $chapter_settings = '{\"Below\":{\"questions\":\"10\",\"points\":\"10\"},\"Emerging\":{\"questions\":\"20\",\"points\":\"20\"},\"Expected\":{\"questions\":\"30\",\"points\":\"30\"},\"Exceeding\":{\"questions\":\"15\",\"points\":\"20\"},\"Challenge\":{\"questions\":\"10\",\"points\":\"10\"}}';

        if (!empty($quiz_list)) {
            foreach ($quiz_list as $quiz_title) {
                $quiz_title = trim($quiz_title);
                if ($quiz_title != '') {
                    $SubChapterObj = SubChapters::create([
                        'webinar_id'        => $webinar_id ,
                        'chapter_id'        => $chapter_id ,
                        'sub_chapter_title' => $quiz_title ,
                        'chapter_settings'  => $chapter_settings ,
                        'status'            => 'active' ,
                        'created_at'        => time()
                    ]);

                    $WebinarChapterItemObj = WebinarChapterItem::create([
                        'user_id'    => 929 ,
                        'chapter_id' => $chapter_id ,
                        'item_id'    => $SubChapterObj->id ,
                        'type'       => 'sub_chapter' ,
                        'order'      => 1 ,
                        'created_at' => time()
                    ]);

                    $quizObj = Quiz::create([
                        'webinar_id'     => $webinar_id ,
                        'creator_id'     => 929 ,
                        'chapter_id'     => $chapter_id ,
                        'webinar_title'  => 'Maths' ,
                        'time'           => 100 ,
                        'attempt'        => 100 ,
                        'pass_mark'      => 100 ,
                        'certificate'    => 0 ,
                        'status'         => 'active' ,
                        'total_mark'     => 100 ,
                        'created_at'     => time() ,
                        'updated_at'     => time() ,
                        'quiz_type'      => 'auto_builder' ,
                        'sub_chapter_id' => $SubChapterObj->id ,
                        'created_at'     => time()
                    ]);

                    QuizTranslation::updateOrCreate([
                        'quiz_id' => $quizObj->id ,
                        'locale'  => 'en' ,
                    ] , [
                        'title' => $quiz_title ,
                    ]);
                }
            }
        }
        return redirect()->route('adminCreateSubChapteAuto' , ['success' => 'yes']);
    }

    public function create_sections_auto(Request $request , $success = '')
    {
        $this->authorize('admin_quizzes_create');

        $data = [
            'pageTitle' => 'Sections Auto' ,
        ];

        $webinars = \Illuminate\Support\Facades\DB::table('webinars')
            ->join('webinar_translations' , 'webinar_translations.webinar_id' , '=' , 'webinars.id')
            ->join('category_translations' , 'category_translations.category_id' , '=' , 'webinars.category_id')
            ->select('webinars.id' , 'webinar_translations.title', 'category_translations.title as category_title');

        $webinars = $webinars->get();

        $data['webinars'] = $webinars;
        $data['success'] = isset($_GET['success']) ? $_GET['success'] : '';

        return view('admin.questions_bank.create_sections_auto' , $data);
    }

    public function store_sections_auto()
    {
        $chapters_list = explode("\n" , $_POST['chapters_list']);
        $webinar_id = isset($_POST['webinar_id']) ? $_POST['webinar_id'] : 0;
        if (!empty($chapters_list)) {
            foreach ($chapters_list as $chapter_title) {
                $chapter_title = trim($chapter_title);
                if ($chapter_title != '') {
                    $WebinarChapterObj = WebinarChapter::create([
                        'user_id'                 => 929 ,
                        'webinar_id'              => $webinar_id ,
                        'check_all_contents_pass' => 0 ,
                        'status'                  => 'active' ,
                        'created_at'              => time()
                    ]);

                    WebinarChapterTranslation::updateOrCreate([
                        'webinar_chapter_id' => $WebinarChapterObj->id ,
                        'locale'             => 'en' ,
                        'title'              => $chapter_title ,
                    ]);
                }
            }
        }
        return redirect()->route('adminCreateSectionsAuto' , ['success' => 'yes']);
    }

    private function filters($query , $request)
    {
        $from = $request->get('from' , null);
        $to = $request->get('to' , null);
        $title = $request->get('title' , null);
        $sort = $request->get('sort' , null);
        $teacher_ids = $request->get('teacher_ids' , null);
        $webinar_ids = $request->get('webinar_ids' , null);
        $question_status = $request->get('question_status' , null);
        $difficulty_level = $request->get('difficulty_level' , null);
        $review_required = $request->get('review_required' , null);


        $category_id = $request->get('category_id' , '');
        $course_id = $request->get('course_id' , '');
        $chapter_id = $request->get('chapter_id' , '');


        $query = fromAndToDateFilter($from , $to , $query , 'quizzes_questions.created_at');

        if (!empty($title)) {
            $query->whereTranslationLike('title' , '%' . $title . '%')->orWhere('search_tags', 'LIKE' , '%' . $title . '%');
        }

        if (!empty($sort)) {
            switch ($sort) {
                case 'have_certificate':
                    $query->where('certificate' , true);
                    break;
                case 'students_count_asc':
                    $query->join('quizzes_results' , 'quizzes_results.quiz_id' , '=' , 'quizzes.id')
                        ->select('quizzes.*' , 'quizzes_results.quiz_id' , DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count' , 'asc');
                    break;

                case 'students_count_desc':
                    $query->join('quizzes_results' , 'quizzes_results.quiz_id' , '=' , 'quizzes.id')
                        ->select('quizzes.*' , 'quizzes_results.quiz_id' , DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count' , 'desc');
                    break;
                case 'passed_count_asc':
                    $query->join('quizzes_results' , 'quizzes_results.quiz_id' , '=' , 'quizzes.id')
                        ->select('quizzes.*' , 'quizzes_results.quiz_id' , DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->where('quizzes_results.status' , 'passed')
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count' , 'asc');
                    break;

                case 'passed_count_desc':
                    $query->join('quizzes_results' , 'quizzes_results.quiz_id' , '=' , 'quizzes.id')
                        ->select('quizzes.*' , 'quizzes_results.quiz_id' , DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->where('quizzes_results.status' , 'passed')
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count' , 'desc');
                    break;

                case 'grade_avg_asc':
                    $query->join('quizzes_results' , 'quizzes_results.quiz_id' , '=' , 'quizzes.id')
                        ->select('quizzes.*' , 'quizzes_results.quiz_id' , 'quizzes_results.user_grade' , DB::raw('avg(quizzes_results.user_grade) as grade_avg'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('grade_avg' , 'asc');
                    break;

                case 'grade_avg_desc':
                    $query->join('quizzes_results' , 'quizzes_results.quiz_id' , '=' , 'quizzes.id')
                        ->select('quizzes.*' , 'quizzes_results.quiz_id' , 'quizzes_results.user_grade' , DB::raw('avg(quizzes_results.user_grade) as grade_avg'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('grade_avg' , 'desc');
                    break;

                case 'created_at_asc':
                    $query->orderBy('created_at' , 'asc');
                    break;

                case 'created_at_desc':
                    $query->orderBy('created_at' , 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at' , 'desc');
        }

        if (!empty($teacher_ids)) {
            $query->whereIn('creator_id' , $teacher_ids);
        }

        if ($course_id != '') {
            $query->where('quizzes.webinar_id' , $course_id);
        }

        if ($chapter_id != '') {
            $query->where('quizzes_questions.chapter_id' , $chapter_id);
        }

        if ($review_required != '') {
            $query->where('quizzes_questions.review_required' , $review_required);
        }

        if (!empty($question_status) and $question_status !== 'all') {
            $query->where('quizzes_questions.question_status' , $question_status);
        }

        if (!empty($difficulty_level) and $difficulty_level !== 'all') {
            $query->where('quizzes_questions.question_difficulty_level' , $difficulty_level);
        }


        return $query;
    }

    public function store_question()
    {

        $user = auth()->user();
        $this->authorize('admin_questions_bank_create');

        $query = Webinar::query();

        $chapters_list = get_chapters_list();

        $questions_array = $columns_array = $form_pages = $elements_data = $elements_array = array();
        if (array_key_exists('form-elements' , $_POST) && is_array($_POST['form-elements'])) {
            foreach ($_POST['form-elements'] as $encoded_element) {
                $element_options = json_decode(base64_decode(trim(stripslashes($encoded_element))) , true);
                $elements_array[] = json_decode(base64_decode(trim(stripslashes($encoded_element))));
                if (is_array($element_options) && array_key_exists('type' , $element_options)) {

                    if ($element_options['type'] != 'columns') {
                        if ($element_options['type'] == 'signature')
                            $form_options['cross-domain'] = 'off';

                        $parent_id = $element_options['_parent'];
                        $current_id = isset($element_options['id']) ? $element_options['id'] : '';

                        $default_element_options = default_form_options($element_options['type']);

                        $field_type = isset($element_options['type']) ? $element_options['type'] : '';

                        $field_id = isset($element_options['field_id']) ? $element_options['field_id'] : '';
                        $fields_data[$field_id] = $element_options;
                        $elements_data[$field_id] = $element_options;
                        if ($field_type != 'checkbox' && $field_type != 'radio' && $field_type != 'sortable_quiz') {

                            $element_options['elements_data'] = array();

                            $element_options = array_merge($default_element_options , $element_options);

                            $element_content = isset($element_options['content']) ? $element_options['content'] : '';
                            $attrib_arr = ( $element_content != '')? lmsParseTag($element_content , 'editor-field') : array();

                            $fields_data = array();
                            if (!empty($attrib_arr)) {
                                foreach ($attrib_arr as $attribData) {
                                    $id = isset($attribData['data-id']) ? $attribData['data-id'] : '';
                                    if ($id != '') {
                                        $fields_data[$id] = $attribData;
                                        $elements_data[$id] = $attribData;
                                    }
                                }
                            }
                        }
                        $element_options['elements_data'] = $fields_data;


                        $questions_array[$parent_id][] = $element_options;
                    } else {
                        $col_id = isset($element_options['id']) ? $element_options['id'] : '';
                        $columns_array[$col_id] = $element_options;
                    }
                }
            }
        }

        $layout_elements_layout = json_encode($elements_array);
        $form_pages = array();
        $default_page_options = default_form_options("page" , $chapters_list);
        $default_page_confirmation_options = default_form_options("page-confirmation" , $chapters_list);


        $questionData = $_POST;
        $search_tags = (isset( $questionData['search_tags'] ) && $questionData['search_tags'] != '')? explode(',',
            $questionData['search_tags']) : array();
        $search_tags[] = isset($questionData['question_title']) ? $questionData['question_title'] : '';
        $search_tags[] = isset($questionData['difficulty_level']) ? $questionData['difficulty_level'] : '';
        $search_tags = implode(' | ', $search_tags);
        $quiz_id = isset($questionData['chapter_id']) ? $questionData['chapter_id'] : 0;
        $new_glossaries = isset($questionData['new_glossaries']) ? $questionData['new_glossaries'] : array();

        $quiz_id = ($quiz_id > 0) ? $quiz_id : 0;
        $quiz = Quiz::find($quiz_id);
        $quizQuestion = QuizzesQuestion::create([
            'quiz_id'                   => $quiz_id ,
            'creator_id'                => $user->id ,
            'grade'                     => '' ,
            'question_year'             => 0 ,
            'question_score'            => (isset($questionData['question_score']) && $questionData['question_score'] != '') ? $questionData['question_score'] : 1 ,
            'question_average_time'     => (isset($questionData['question_average_time']) && $questionData['question_average_time'] != '') ? $questionData['question_average_time'] : 1 ,
            'question_difficulty_level' => isset($questionData['difficulty_level']) ? $questionData['difficulty_level'] : '' ,
            'question_template_type'    => 'sum_quiz' , //isset( $questionData['type'] )? $questionData['type'] : '',
            'chapter_id'                => (isset($questionData['chapter_id']) && $questionData['chapter_id'] != '') ? $questionData['chapter_id'] : 0 ,
            'question_title'            => isset($questionData['question_title']) ? $questionData['question_title'] : '' ,
            'question_layout'           => isset($_POST['question_layout']) ? $_POST['question_layout'] : '' , //isset( $questionData['content'] )? $questionData['content'] : '',
            'question_solve'            => isset($_POST['question_solve']) ? $_POST['question_solve'] : '' ,
            'glossary_ids'              => isset($_POST['glossary_ids']) ? json_encode($_POST['glossary_ids']) : '' ,
            'elements_data'             => json_encode($elements_data) ,
            'layout_elements'           => $layout_elements_layout ,
            'category_id'               => (isset($questionData['category_id']) && $questionData['category_id'] != '') ? $questionData['category_id'] : 0 ,
            'course_id'                 => (isset($questionData['course_id']) && $questionData['course_id'] != '') ? $questionData['course_id'] : 0 ,
            'sub_chapter_id'            => 0 ,
            'type'                      => 'descriptive' ,
            'created_at'                => time() ,
            'question_status'           => (isset($questionData['question_status']) && $questionData['question_status'] != '') ? $questionData['question_status'] : 'Draft' ,
            'comments_for_reviewer'     => (isset($questionData['comments_for_reviewer']) && $questionData['comments_for_reviewer'] != '') ? $questionData['comments_for_reviewer'] : '',
            'search_tags'              => $search_tags,
            'review_required'              => isset($questionData['review_required']) ? $questionData['review_required'] : 0 ,
        ]);

        if (!empty($quizQuestion)) {
            if (!empty($new_glossaries)) {
                foreach ($new_glossaries as $glossary_id) {
                    $glossary = Glossary::findOrFail($glossary_id);
                    $glossary->update([
                        'question_id' => $quizQuestion->id ,
                    ]);
                }
            }

            QuizzesQuestionTranslation::updateOrCreate([
                'quizzes_question_id' => $quizQuestion->id ,
                'locale'              => 'en' ,
            ] , [
                'title'   => isset($questionData['question_title']) ? $questionData['question_title'] : '' ,
                'correct' => '' ,
            ]);

            QuestionLogs::create([
                'question_id' => $quizQuestion->id ,
                'action_type' => $quizQuestion->question_status ,
                'action_role' => $user->role_name ,
                'log_data'    => (isset($questionData['comments_for_reviewer']) && $questionData['comments_for_reviewer'] != '') ? $questionData['comments_for_reviewer'] : '' ,
                'action_by'   => $user->id ,
                'action_at'   => time()
            ]);
        }
        $redirectUrl = '/admin/questions_bank';
        return response()->json([
            'code'         => 200 ,
            'redirect_url' => $redirectUrl
        ]);
    }

    public function update_question($question_id)
    {

        $user = auth()->user();

        $this->authorize('admin_questions_bank_create');

        $quistionObj = QuizzesQuestion::find($question_id);
        $query = Webinar::query();

        $chapters_list = get_chapters_list();


        $questions_array = $columns_array = $form_pages = $elements_data = $elements_array = array();
        if (array_key_exists('form-elements' , $_POST) && is_array($_POST['form-elements'])) {
            foreach ($_POST['form-elements'] as $encoded_element) {
                $element_options = json_decode(base64_decode(trim(stripslashes($encoded_element))) , true);
                $elements_array[] = json_decode(base64_decode(trim(stripslashes($encoded_element))));
                if (is_array($element_options) && array_key_exists('type' , $element_options)) {

                    if ($element_options['type'] != 'columns') {
                        if ($element_options['type'] == 'signature')
                            $form_options['cross-domain'] = 'off';

                        $parent_id = $element_options['_parent'];
                        $current_id = isset($element_options['id']) ? $element_options['id'] : '';

                        $default_element_options = default_form_options($element_options['type']);

                        $field_type = isset($element_options['type']) ? $element_options['type'] : '';


                        $field_id = isset($element_options['field_id']) ? $element_options['field_id'] : '';
                        $fields_data[$field_id] = $element_options;
                        $elements_data[$field_id] = $element_options;

                        if ($field_type != 'checkbox' && $field_type != 'radio' && $field_type != 'sortable_quiz') {

                            $element_options['elements_data'] = array();

                            $element_options = array_merge($default_element_options , $element_options);

                            $element_content = isset($element_options['content']) ? $element_options['content'] : '';
                            //pre($element_content, false);
                            $attrib_arr = ( $element_content != '')? lmsParseTag($element_content , 'editor-field') : array();


                            $fields_data = array();
                            if (!empty($attrib_arr)) {
                                foreach ($attrib_arr as $attribData) {
                                    $id = isset($attribData['data-id']) ? $attribData['data-id'] : '';
                                    if ($id != '') {
                                        $fields_data[$id] = $attribData;
                                        $elements_data[$id] = $attribData;
                                    }
                                }
                            }
                        }

                        $element_options['elements_data'] = $fields_data;


                        $questions_array[$parent_id][] = $element_options;
                    } else {
                        $col_id = isset($element_options['id']) ? $element_options['id'] : '';
                        $columns_array[$col_id] = $element_options;
                    }
                }
            }
            //pre('test');
        }

        $layout_elements_layout = json_encode($elements_array);
        $form_pages = array();
        $default_page_options = default_form_options("page" , $chapters_list);
        $default_page_confirmation_options = default_form_options("page-confirmation" , $chapters_list);


        $questionData = $_POST;
        $search_tags = (isset( $questionData['search_tags'] ) && $questionData['search_tags'] != '')? explode(',',$questionData['search_tags']) : array();
        $search_tags = implode(' | ', $search_tags);
        $quiz_id = isset($questionData['chapter_id']) ? $questionData['chapter_id'] : 0;
        $new_glossaries = isset($questionData['new_glossaries']) ? $questionData['new_glossaries'] : array();

        if (!empty($new_glossaries)) {
            foreach ($new_glossaries as $glossary_id) {
                $glossary = Glossary::findOrFail($glossary_id);
                $glossary->update([
                    'question_id' => $quistionObj->id ,
                ]);
            }
        }

        $quiz_id = ($quiz_id > 0) ? $quiz_id : 0;

        $quiz = Quiz::find($quiz_id);
        $quizQuestion = $quistionObj->update([
            'quiz_id'                   => $quiz_id ,
            'grade'                     => '' ,
            'question_year'             => 0 ,
            'question_score'            => (isset($questionData['question_score']) && $questionData['question_score'] != '') ? $questionData['question_score'] : 1 ,
            'question_average_time'     => (isset($questionData['question_average_time']) && $questionData['question_average_time'] != '') ? $questionData['question_average_time'] : 1 ,
            'question_difficulty_level' => isset($questionData['difficulty_level']) ? $questionData['difficulty_level'] : '' ,
            'question_template_type'    => 'sum_quiz' , //isset( $questionData['type'] )? $questionData['type'] : '',
            'chapter_id'                => (isset($questionData['chapter_id']) && $questionData['chapter_id'] != '') ? $questionData['chapter_id'] : 0 ,
            'question_title'            => isset($questionData['question_title']) ? $questionData['question_title'] : '' ,
            'question_layout'           => isset($_POST['question_layout']) ? $_POST['question_layout'] : '' , //isset( $questionData['content'] )? $questionData['content'] : '',
            'question_solve'            => isset($questionData['question_solve']) ? $questionData['question_solve'] : '' ,
            'glossary_ids'              => isset($_POST['glossary_ids']) ? json_encode($_POST['glossary_ids']) : '' ,
            'elements_data'             => json_encode($elements_data) ,
            'layout_elements'           => $layout_elements_layout ,
            'category_id'               => (isset($questionData['category_id']) && $questionData['category_id'] != '') ? $questionData['category_id'] : 0 ,
            'course_id'                 => (isset($questionData['course_id']) && $questionData['course_id'] != '') ? $questionData['course_id'] : 0 ,
            'sub_chapter_id'            => 0 ,
            'type'                      => 'descriptive' ,
            'updated_at'                => time() ,
            'question_status'           => (isset($questionData['question_status']) && $questionData['question_status'] != '') ? $questionData['question_status'] : 'Draft' ,
            'comments_for_reviewer'     => (isset($questionData['comments_for_reviewer']) && $questionData['comments_for_reviewer'] != '') ? $questionData['comments_for_reviewer'] : '',
            'search_tags'              => $search_tags,
            'review_required'              => isset($questionData['review_required']) ? $questionData['review_required'] : 0 ,
        ]);

        if (!empty($quizQuestion)) {
            QuizzesQuestionTranslation::updateOrCreate([
                'quizzes_question_id' => $question_id ,
                'locale'              => 'en' ,
            ] , [
                'title'   => isset($questionData['question_title']) ? $questionData['question_title'] : '' ,
                'correct' => '' ,
            ]);

            QuestionLogs::create([
                'question_id' => $quistionObj->id ,
                'action_type' => 'Updated = ' . $quistionObj->question_status ,
                'action_role' => $user->role_name ,
                'log_data'    => (isset($questionData['comments_for_reviewer']) && $questionData['comments_for_reviewer'] != '') ? $questionData['comments_for_reviewer'] : '' ,
                'action_by'   => $user->id ,
                'action_at'   => time()
            ]);
        }
        $redirectUrl = '/admin/questions_bank/' . $question_id . '/edit';
        //$redirectUrl = '/admin/questions_bank/';
        return response()->json([
            'code'         => 200 ,
            'redirect_url' => $redirectUrl
        ]);
    }

    public function question_file_upload(Request $request)
    {
        pre($_FILES);
    }

    public function store(Request $request)
    {
        $this->authorize('admin_questions_bank_create');

        $data = $request->all();
        $locale = $request->get('locale' , getDefaultLocale());

        $rules = [
            'title'      => 'required|max:255' ,
            'webinar_id' => 'required|exists:webinars,id' ,
            'pass_mark'  => 'required' ,
        ];

        if ($request->ajax()) {
            $data = $request->get('ajax');

            $validate = Validator::make($data , $rules);

            if ($validate->fails()) {
                return response()->json([
                    'code'   => 422 ,
                    'errors' => $validate->errors()
                ] , 422);
            }
        } else {
            $this->validate($request , $rules);
        }


        $webinar = Webinar::where('id' , $data['webinar_id'])
            ->first();

        if (!empty($webinar)) {
            $chapter = null;

            if (!empty($data['chapter_id'])) {
                $chapter = WebinarChapter::where('id' , $data['chapter_id'])
                    ->where('webinar_id' , $webinar->id)
                    ->first();
            }

            $quiz = Quiz::create([
                'webinar_id'    => $webinar->id ,
                'chapter_id'    => !empty($chapter) ? $chapter->id : null ,
                'creator_id'    => $webinar->creator_id ,
                'webinar_title' => $webinar->title ,
                'attempt'       => $data['attempt'] ?? null ,
                'pass_mark'     => $data['pass_mark'] ,
                'time'          => $data['time'] ?? null ,
                'status'        => (!empty($data['status']) and $data['status'] == 'on') ? Quiz::ACTIVE : Quiz::INACTIVE ,
                'certificate'   => (!empty($data['certificate']) and $data['certificate'] == 'on') ,
                'created_at'    => time() ,
            ]);

            QuizTranslation::updateOrCreate([
                'quiz_id' => $quiz->id ,
                'locale'  => mb_strtolower($locale) ,
            ] , [
                'title' => $data['title'] ,
            ]);

            if (!empty($quiz->chapter_id)) {
                WebinarChapterItem::makeItem($webinar->creator_id , $quiz->chapter_id , $quiz->id , WebinarChapterItem::$chapterQuiz);
            }

            if ($request->ajax()) {

                $redirectUrl = '';

                if (empty($data['is_webinar_page'])) {
                    $redirectUrl = '/admin/quizzes/' . $quiz->id . '/edit';
                }

                return response()->json([
                    'code'         => 200 ,
                    'redirect_url' => $redirectUrl
                ]);
            } else {
                return redirect()->route('adminEditQuiz' , ['id' => $quiz->id]);
            }
        } else {
            return back()->withErrors([
                'webinar_id' => trans('validation.exists' , ['attribute' => trans('admin/main.course')])
            ]);
        }
    }

    public function edit(Request $request , $id)
    {
        $user = auth()->user();
        $this->authorize('admin_questions_bank_edit');

        $question = QuizzesQuestion::findOrFail($id);

        $questionLogs = QuestionLogs::where('question_id' , $id)->orderBy('id' , 'desc')->with('user')
            ->get();

        $created_at = $question->created_at;

        $time_passed = TimeDifference($created_at , time() , 'minutes');


        if (($question->question_status != 'Draft' && $question->question_status != 'Improvement required') && auth()->user()->isAuthor()) {
            if ($user->id != $question->creator_id || $time_passed > 20 || in_array($question->question_status , array('Submit for review' , 'Improvement required')) == false) {
                $toastData = [
                    'title'  => 'Request not completed' ,
                    'msg'    => 'You dont have permissions to perform this action.' ,
                    'status' => 'error'
                ];
                return redirect()->back()->with(['toast' => $toastData]);
            }
        }

        $query = Webinar::query();

        $chapters_list = get_chapters_list();


        $form_elements = json_decode($question->layout_elements , true);
        if (is_array($form_elements)) {
            foreach ($form_elements as $key => $form_element_raw) {
                //pre($form_element_raw);
                $element_options = $form_element_raw; //json_decode($form_element_raw, true);

                if (is_array($element_options) && array_key_exists('type' , $element_options)) {
                    $default_element_options = default_form_options($element_options['type']);
                    $element_options = array_merge($default_element_options , $element_options);
                    $form_elements[$key] = json_encode($element_options);
                } else
                    unset($form_elements[$key]);
            }
            $form_elements = array_values($form_elements);
        } else
            $form_elements = array();

        if (auth()->user()->isAuthor()) {
            $glossary = Glossary::where('status' , 'active')->orWhere('created_by' , $user->id)
                ->get();
        } else {
            $glossary = Glossary::whereIn('status' , array('active' , 'draft'))
                ->get();
        }

        $glossary_ids = is_array($question->glossary_ids) ? $question->glossary_ids : json_decode($question->glossary_ids);
        $glossary_ids = is_array($glossary_ids) ? $glossary_ids : array($glossary_ids);

        $categories = Category::where('parent_id' , null)
            ->with('subCategories')
            ->get();

        $data = [
            'pageTitle'                 => trans('public.edit') . ' ' . $question->title ,
            'question_difficulty_level' => $question->question_difficulty_level ,
            'question_score'            => $question->question_score ,
            'chapter_db_id'             => $question->chapter_id ,
            'question_title'            => $question->question_title ,
            'question_average_time'     => $question->question_average_time ,
            'question_layout'           => $question->question_layout ,
            'elements_data'             => $question->elements_data ,
            'layout_elements'           => $form_elements ,
            'question_solve'            => $question->question_solve ,
            'glossary_ids'              => $glossary_ids ,
            'chapters'                  => $chapters_list ,
            'categories'                => $categories ,
            'questionObj'               => $question ,
            'questionLogs'              => $questionLogs ,
            'user'                      => $user ,
        ];
        $data['glossary'] = $glossary;

        return view('admin.questions_bank.edit' , $data);
    }

    public function log(Request $request , $id)
    {
        $user = auth()->user();
        $this->authorize('admin_questions_bank_edit');

        $questionObj = QuizzesQuestion::findOrFail($id);

        $questionLogs = QuestionLogs::where('question_id' , $id)->orderBy('id' , 'desc')->with('user')
            ->get();


        $data = [
            'pageTitle'    => 'Logs for ' . $questionObj->title ,
            'questionObj'  => $questionObj ,
            'questionLogs' => $questionLogs ,
            'user'         => $user ,
        ];

        return view('admin.questions_bank.log' , $data);
    }

    public function update(Request $request , $id)
    {
        $rules = [
            'title'      => 'required|max:255' ,
            'webinar_id' => 'required|exists:webinars,id' ,
            'pass_mark'  => 'required' ,
        ];

        $data = $request->all();
        $locale = $request->get('locale' , getDefaultLocale());

        if ($request->ajax()) {
            $data = $request->get('ajax');

            $validate = Validator::make($data , $rules);

            if ($validate->fails()) {
                return response()->json([
                    'code'   => 422 ,
                    'errors' => $validate->errors()
                ] , 422);
            }
        } else {
            $this->validate($request , $rules);
        }

        $quiz = Quiz::find($id);
        $user = $quiz->creator;

        $webinar = null;
        $chapter = null;
        if (!empty($data['webinar_id'])) {
            $webinar = Webinar::where('id' , $data['webinar_id'])
                ->where(function ($query) use ($user) {
                    $query->where('teacher_id' , $user->id)
                        ->orWhere('creator_id' , $user->id);
                })->where('status' , 'active')
                ->first();

            if (!empty($webinar) and !empty($data['chapter_id'])) {
                $chapter = WebinarChapter::where('id' , $data['chapter_id'])
                    ->where('webinar_id' , $webinar->id)
                    ->first();
            }
        }

        $quiz->update([
            'webinar_id'    => !empty($webinar) ? $webinar->id : null ,
            'chapter_id'    => !empty($chapter) ? $chapter->id : null ,
            'webinar_title' => !empty($webinar) ? $webinar->title : null ,
            'attempt'       => $data['attempt'] ?? null ,
            'pass_mark'     => $data['pass_mark'] ,
            'time'          => $data['time'] ?? null ,
            'status'        => (!empty($data['status']) and $data['status'] == 'on') ? Quiz::ACTIVE : Quiz::INACTIVE ,
            'certificate'   => (!empty($data['certificate']) and $data['certificate'] == 'on') ? true : false ,
            'updated_at'    => time() ,
        ]);

        if (!empty($quiz)) {
            QuizTranslation::updateOrCreate([
                'quiz_id' => $quiz->id ,
                'locale'  => mb_strtolower($locale) ,
            ] , [
                'title' => $data['title'] ,
            ]);

            $checkChapterItem = WebinarChapterItem::where('user_id' , $user->id)
                ->where('item_id' , $quiz->id)
                ->where('type' , WebinarChapterItem::$chapterQuiz)
                ->first();

            if (!empty($quiz->chapter_id)) {
                if (empty($checkChapterItem)) {
                    WebinarChapterItem::makeItem($user->id , $quiz->chapter_id , $quiz->id , WebinarChapterItem::$chapterQuiz);
                } elseif ($checkChapterItem->chapter_id != $quiz->chapter_id) {
                    $checkChapterItem->delete(); // remove quiz from old chapter and assign it to new chapter

                    WebinarChapterItem::makeItem($user->id , $quiz->chapter_id , $quiz->id , WebinarChapterItem::$chapterQuiz);
                }
            } else if (!empty($checkChapterItem)) {
                $checkChapterItem->delete();
            }
        }

        removeContentLocale();

        if ($request->ajax()) {
            return response()->json([
                'code' => 200
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function delete(Request $request , $id)
    {
        $user = auth()->user();
        //$this->authorize('admin_questions_bank_delete');

        $questionObj = QuizzesQuestion::findOrFail($id);
        $created_at = $questionObj->created_at;

        $time_passed = TimeDifference($created_at , time() , 'minutes');

        if ($user->id != $questionObj->creator_id || $time_passed > 20) {

            $toastData = [
                'title'  => 'Request not completed' ,
                'msg'    => 'You dont have permissions to perform this action.' ,
                'status' => 'error'
            ];
            return redirect()->back()->with(['toast' => $toastData]);
        } else {
            QuestionLogs::create([
                'question_id' => $id ,
                'action_type' => 'Deleted' ,
                'action_role' => $user->role_name ,
                'action_by'   => $user->id ,
                'action_at'   => time()
            ]);
            $questionObj->update([
                'question_status' => 'Deleted'
            ]);
            return redirect()->back();
        }
    }

    public function question_status_submit(Request $request)
    {
        $user = auth()->user();
        $points_details = array();
        $points = 0;
        $question_id = $request->input('question_id');
        $questionObj = QuizzesQuestion::find($question_id);
        $question_status = $request->input('question_status');
        $publish_question = $request->input('publish_question');
        $status_details = $request->input('status_details');
        $log_storred_data = $status_details;
        $log_data = $status_details;

        $glossary = Glossary::where('question_id' , $question_id)->where('status' , 'draft')->get();


        switch ($request->input('question_status')) {

            case    "Accepted":

                $image_question_points = ($request->input('image_question') == 1) ? 5 : 0;
                $word_problem_points = ($request->input('word_problem') == 1) ? 5 : 0;

                $glossary_points = ($request->input('new_glossary') == 1) ? 5 : 0;
                $glossary_points = ($request->input('glossary_with_illustration') == 1) ? 10 : $glossary_points;

                $solution = $request->input('solution');
                $solution_points = ($solution == 'Appropriate') ? 5 : 0;
                $solution_points = ($solution == 'Aspirational') ? 10 : $solution_points;

                $difficulty_level = $request->input('difficulty_level');
                $difficulty_level_points = ($difficulty_level == 'Medium') ? 5 : 0;
                $difficulty_level_points = ($difficulty_level == 'Expert') ? 10 : $difficulty_level_points;

                $points_details = array(
                    'Image Question'         => $image_question_points ,
                    'Word Problem'           => $word_problem_points ,
                    'New Glossary'           => $glossary_points ,
                    'Solution'               => $solution_points ,
                    'Difficulty Level'       => $difficulty_level_points ,
                    'Solution Label'         => $solution ,
                    'Difficulty Level Label' => $difficulty_level ,
                    'status_details'         => $status_details ,
                );

                $points = 20 + $image_question_points + $word_problem_points + $glossary_points + $solution_points + $difficulty_level_points;
                $log_storred_data = json_encode($points_details);

                QuestionAuthorPoints::create([
                    'question_id'    => $questionObj->id ,
                    'author_id'      => $questionObj->creator_id ,
                    'points_details' => json_encode($points_details) ,
                    'points'         => $points ,
                    'created_by'     => $user->id ,
                    'created_at'     => time()
                ]);

                $userObj = User::find($questionObj->creator_id);
                $userObj->update([
                    'author_points' => $userObj->author_points + $points
                ]);

                $question_status = 'Offline';
                if ($publish_question == 1) {
                    $question_status = 'Published';
                }

                if (!empty($glossary)) {
                    foreach ($glossary as $glossaryObj) {
                        $glossaryObj->update([
                            'status' => 'active'
                        ]);
                    }
                }

                break;
        }

        $questionObj->update([
            'question_status' => $question_status
        ]);


        QuestionLogs::create([
            'question_id'      => $questionObj->id ,
            'action_type'      => 'Status Updated - ' . $question_status ,
            'action_role'      => $user->role_name ,
            'log_data'         => $log_data ,
            'log_storred_data' => $log_storred_data ,
            'action_by'        => $user->id ,
            'action_at'        => time()
        ]);

        $redirectUrl = '/admin/questions_bank';
        return response()->json([
            'code'        => 200 ,
            'redirect_to' => $redirectUrl ,
        ]);
    }

    public function question_status_update(Request $request)
    {
        $user = auth()->user();
        $question_id = $request->input('question_id');
        $question_status = $request->input('question_status');
        $questionObj = QuizzesQuestion::find($question_id);

        $questionObj->update([
            'question_status' => $question_status
        ]);

        QuestionLogs::create([
            'question_id'      => $questionObj->id ,
            'action_type'      => 'Status Updated - ' . $question_status ,
            'action_role'      => $user->role_name ,
            'log_data'         => '' ,
            'log_storred_data' => '' ,
            'action_by'        => $user->id ,
            'action_at'        => time()
        ]);
        return response()->json([
            'code' => 200 ,
        ]);
    }

    public function duplicate(Request $request , $id)
    {
        $question = QuizzesQuestion::findOrFail($id);
        $question_title_new = $question->question_title . ' - Duplicate';
        $question->load('listQuestions');
        $new_question = $question->replicate();
        $new_question->created_at = time();
        $new_question->push();

        foreach ($question->getRelations() as $relation => $items) {
            foreach ($items as $item) {
                unset($item->id);
                $new_question->{$relation}()->create($item->toArray());
            }
        }

        $new_question->update([
            'question_title' => $question_title_new ,
        ]);
        if (!empty($new_question)) {
            QuizzesQuestionTranslation::updateOrCreate([
                'quizzes_question_id' => $new_question->id ,
                'locale'              => 'en' ,
            ] , [
                'title'   => $question_title_new ,
                'correct' => '' ,
            ]);
        }
        //pre($new_question);
        return redirect()->back();
    }

    public function search_bk(Request $request)
    {
        $term = $request->get('term');

        $response = Elasticsearch::search([
           'index' => 'questions',
           'body'  => [
               "size" => 100,
               'query' => [
                   'query_string' => [
                       'query' => $term.'*',
                       'fields' => [
                           'title','difficulty_level','class','course','topic'
                       ]
                   ]
               ]
           ]
       ]);
       $questionIds = array_column($response['hits']['hits'], '_source', '_id');
        //pre($questionIds);
       return response()->json($questionIds , 200);
    }

    public function search(Request $request)
    {
        $term = $request->get('term');

        //DB::enableQueryLog();
        $questionIds = QuizzesQuestion::where('question_title', 'like', '%'.$term.'%')->orWhere('search_tags', 'like', '%'.$term.'%')->get();
        $questions_array = array();
        if( !empty( $questionIds ) ){
            foreach( $questionIds as $questionObj){

                $search_tags = ( isset( $questionObj->search_tags ) && $questionObj->search_tags != '')? explode( ' | ', $questionObj->search_tags) : array();
                $search_keywords = '';
                if( !empty( $search_tags ) ){
                    foreach( $search_tags as $tag_value){
                        $search_keywords .= '<li>'. $tag_value .'</li>';
                    }
                }


                $questions_array[$questionObj->id]  = array(
                    'id' => $questionObj->id,
                    'title' => $questionObj->question_title,
                    'question_difficulty_level' => $questionObj->question_difficulty_level,
                    'search_tags' => $search_keywords,
                );
            }
        }

        //pre(DB::getQueryLog());
        //DB::disableQueryLog();
       return response()->json($questions_array , 200);
    }

    public function get_questions_by_ids(Request $request)
    {
        $questions_ids = $request->get('questions_ids');

        $questions_ids = ($questions_ids != '') ? explode(',' , $questions_ids) : array();


        $questions = QuizzesQuestion::select('id' , 'question_title as text')->whereIn('id' , $questions_ids);

        return response()->json($questions->get() , 200);
    }

    public function results($id)
    {
        $this->authorize('admin_quizzes_results');

        $quizzesResults = QuizzesResult::where('quiz_id' , $id)
            ->with([
                'quiz' => function ($query) {
                    $query->with(['teacher']);
                } ,
                'user'
            ])
            ->orderBy('created_at' , 'desc')
            ->paginate(10);

        $data = [
            'pageTitle'      => trans('admin/pages/quizResults.quiz_result_list_page_title') ,
            'quizzesResults' => $quizzesResults ,
            'quiz_id'        => $id
        ];

        return view('admin.quizzes.results' , $data);
    }

    public function resultsExportExcel($id)
    {
        $this->authorize('admin_quiz_result_export_excel');

        $quizzesResults = QuizzesResult::where('quiz_id' , $id)
            ->with([
                'quiz' => function ($query) {
                    $query->with(['teacher']);
                } ,
                'user'
            ])
            ->orderBy('created_at' , 'desc')
            ->get();

        $export = new QuizResultsExport($quizzesResults);

        return Excel::download($export , 'quiz_result.xlsx');
    }

    public function resultDelete($result_id)
    {
        $this->authorize('admin_quizzes_results_delete');

        $quizzesResults = QuizzesResult::where('id' , $result_id)->first();

        if (!empty($quizzesResults)) {
            $quizzesResults->delete();
        }

        return redirect()->back();
    }

    public function exportExcel(Request $request)
    {
        $this->authorize('admin_quizzes_lists_excel');

        $query = Quiz::query();

        $query = $this->filters($query , $request);

        $quizzes = $query->with([
            'webinar' ,
            'teacher' ,
            'quizQuestions' ,
            'quizResults' ,
        ])->get();

        return Excel::download(new QuizzesAdminExport($quizzes) , trans('quiz.quizzes') . '.xlsx');
    }

    public function sub_chapters_create_cron()
    {
        $query = Quiz::query();

        $quizzes = $query->with([
            'webinar' ,
        ])
            ->join('quiz_translations' , 'quiz_translations.quiz_id' , '=' , 'quizzes.id')
            ->select('quizzes.*' , 'quiz_translations.title')
            ->paginate(200);


        if (!empty($quizzes)) {
            foreach ($quizzes as $quizzData) {
                $quizObj = Quiz::find($quizzData->id);
                $question_title = $quizzData->title;
                $webinar_id = $quizzData->webinar_id;
                $chapter_id = $quizzData->chapter_id;
                $chapter_settings = '{\"Below\":{\"questions\":\"10\",\"points\":\"10\"},\"Emerging\":{\"questions\":\"20\",\"points\":\"20\"},\"Expected\":{\"questions\":\"30\",\"points\":\"30\"},\"Exceeding\":{\"questions\":\"15\",\"points\":\"20\"},\"Challenge\":{\"questions\":\"10\",\"points\":\"10\"}}';

                $SubChapterObj = SubChapters::create([
                    'webinar_id'        => $webinar_id ,
                    'chapter_id'        => $chapter_id ,
                    'sub_chapter_title' => $question_title ,
                    'chapter_settings'  => $chapter_settings ,
                    'status'            => 'active' ,
                    'created_at'        => time()
                ]);

                $WebinarChapterItemObj = WebinarChapterItem::create([
                    'user_id'    => 929 ,
                    'chapter_id' => $chapter_id ,
                    'item_id'    => $SubChapterObj->id ,
                    'type'       => 'sub_chapter' ,
                    'order'      => 1 ,
                    'created_at' => time()
                ]);

                $quizObjNew = $quizObj->update([
                    'sub_chapter_id' => $SubChapterObj->id ,
                ]);
            }
        }
        pre('all done');
    }

}
