<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\QuestionsAttemptController;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\QuizzesQuestion;
use App\Models\AssignmentsQuestions;
use App\Models\QuizzesResult;
use App\Models\QuizzesQuestionsList;
use App\Models\Translation\QuizTranslation;
use App\Models\Webinar;
use App\Models\WebinarChapter;
use App\Models\SubChapters;
use App\Models\WebinarChapterItem;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Translation\QuizzesQuestionTranslation;

class AssignmentsController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('admin_assignments');

        removeContentLocale();
        //DB::enableQueryLog();

        $query = Quiz::query()->where('quiz_type', 'assignment');

        if (auth()->user()->isTeacher()) {
            //$query = $query->where('creator_id', auth()->user()->id);
        }
        $totalAssignments = deepClone($query)->count();

        $query = $this->filters($query, $request);


        $quizzes = $query->with([
            'webinar',
            'teacher',
            'quizQuestionsList' => function ($query) {
                $query->withCount([
                    'teacher_review_questions',
                    'development_review_questions',
                ]);
            },
            'quizResults',
        ])->paginate(100);

        //pre($quizzes);

        //pre(DB::getQueryLog());
        //DB::disableQueryLog();

        $data = [
            'pageTitle'        => 'Assignments',
            'quizzes'          => $quizzes,
            'totalAssignments' => $totalAssignments,
        ];

        $teacher_ids = $request->get('teacher_ids');
        $webinar_ids = $request->get('webinar_ids');

        if (!empty($teacher_ids)) {
            $data['teachers'] = User::select('id', 'full_name')
                ->whereIn('id', $teacher_ids)->get();
        }

        if (!empty($webinar_ids)) {
            $data['webinars'] = Webinar::select('id')
                ->whereIn('id', $webinar_ids)->get();
        }

        return view('admin.assignments.lists', $data);
    }

    private function filters($query, $request)
    {
        $from = $request->get('from', null);
        $to = $request->get('to', null);
        $title = $request->get('title', null);
        $sort = $request->get('sort', null);
        $teacher_ids = $request->get('teacher_ids', null);
        $webinar_ids = $request->get('webinar_ids', null);
        $status = $request->get('status', null);
        $year_group = $request->get('year_group', null);
        $subject = $request->get('subject', null);
        $examp_board = $request->get('examp_board', null);

        $query = fromAndToDateFilter($from, $to, $query, 'created_at');

        if (!empty($title)) {
            $query->whereTranslationLike('title', '%' . $title . '%');
        }

        if (!empty($sort)) {
            switch ($sort) {
                case 'have_certificate':
                    $query->where('certificate', true);
                    break;
                case 'students_count_asc':
                    $query->join('quizzes_results', 'quizzes_results.quiz_id', '=', 'quizzes.id')
                        ->select('quizzes.*', 'quizzes_results.quiz_id', DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count', 'asc');
                    break;

                case 'students_count_desc':
                    $query->join('quizzes_results', 'quizzes_results.quiz_id', '=', 'quizzes.id')
                        ->select('quizzes.*', 'quizzes_results.quiz_id', DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count', 'desc');
                    break;
                case 'passed_count_asc':
                    $query->join('quizzes_results', 'quizzes_results.quiz_id', '=', 'quizzes.id')
                        ->select('quizzes.*', 'quizzes_results.quiz_id', DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->where('quizzes_results.status', 'passed')
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count', 'asc');
                    break;

                case 'passed_count_desc':
                    $query->join('quizzes_results', 'quizzes_results.quiz_id', '=', 'quizzes.id')
                        ->select('quizzes.*', 'quizzes_results.quiz_id', DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->where('quizzes_results.status', 'passed')
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count', 'desc');
                    break;

                case 'grade_avg_asc':
                    $query->join('quizzes_results', 'quizzes_results.quiz_id', '=', 'quizzes.id')
                        ->select('quizzes.*', 'quizzes_results.quiz_id', 'quizzes_results.user_grade', DB::raw('avg(quizzes_results.user_grade) as grade_avg'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('grade_avg', 'asc');
                    break;

                case 'grade_avg_desc':
                    $query->join('quizzes_results', 'quizzes_results.quiz_id', '=', 'quizzes.id')
                        ->select('quizzes.*', 'quizzes_results.quiz_id', 'quizzes_results.user_grade', DB::raw('avg(quizzes_results.user_grade) as grade_avg'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('grade_avg', 'desc');
                    break;

                case 'created_at_asc':
                    $query->orderBy('created_at', 'asc');
                    break;

                case 'created_at_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        if (!empty($teacher_ids)) {
            $query->whereIn('creator_id', $teacher_ids);
        }

        if (!empty($webinar_ids)) {
            $query->whereIn('webinar_id', $webinar_ids);
        }

        if (!empty($status) and $status !== 'all') {
            $query->where('status', strtolower($status));
        }

        if (!empty($year_group) and $year_group !== 'All') {
            $query->where('year_group', $year_group);
        }

        if (!empty($subject) and $subject !== 'All') {
            $query->where('subject', $subject);
        }

        if (!empty($examp_board) and $examp_board !== 'All') {
            $query->where('examp_board', $examp_board);
        }

        return $query;
    }

    public function assign(Request $request, $id)
    {
        $this->authorize('admin_assignments_create');

        $assignment = Quiz::query()->findOrFail($id);
        $categories = Category::where('parent_id', null)
            ->with('subCategories')->orderBy('order', 'asc')
            ->get();

        $data = [
            'pageTitle'  => 'Assign Assignment',
            'categories' => $categories,
            'assignment' => $assignment,
        ];

        return view('admin.assignments.assign', $data);
    }

    public function create()
    {
        $this->authorize('admin_assignments_create');

        $categories = Category::where('parent_id', null)
            ->with('subCategories')->orderBy('order', 'asc')
            ->get();

        $QuestionsAttemptController = new QuestionsAttemptController();

        $data = [
            'pageTitle'  => 'Create Assignment',
            'categories' => $categories,
        ];

        return view('admin.assignments.create', $data);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $this->authorize('admin_quizzes_create');
        $data = $request->get('ajax')['new'];
        $locale = $data['locale'] ?? getDefaultLocale();

        $rules = [
            //'title' => 'required|max:255',
            //'webinar_id' => 'required|exists:webinars,id',
            //'pass_mark' => 'required',
        ];

        if ($request->ajax()) {

            $validate = Validator::make($data, $rules);

            if ($validate->fails()) {
                return response()->json([
                    'code'   => 422,
                    'errors' => $validate->errors()
                ], 422);
            }
        } else {
            $this->validate($request, $rules);
        }


        $question_list_ids = isset($data['question_list_ids']) ? $data['question_list_ids'] : array();


        $quiz = Quiz::create([
            'quiz_slug'                   => (isset($data['quiz_slug']) && $data['quiz_slug'] != '') ? $data['quiz_slug'] : Quiz::makeSlug($data['title']),
            'webinar_id'                  => isset($webinar->id) ? $webinar->id : 0,
            'chapter_id'                  => !empty($chapter) ? $chapter->id : null,
            'creator_id'                  => $user->id,
            'webinar_title'               => '',
            'attempt'                     => (isset($data['attempt']) && $data['attempt'] > 0) ? $data['attempt'] : 100,
            'quiz_type'                   => 'assignment',
            'sub_chapter_id'              => 0,
            'pass_mark'                   => 1,
            'time'                        => 100,
            'display_number_of_questions' => 0,
            'status'                      => 'draft',
            'certificate'                 => 1,
            'created_at'                  => time(),
            'quiz_settings'               => json_encode(array()),
            'mastery_points'              => 0,
            'show_all_questions'          => 0,
            'sub_title'                   => '',
            'quiz_image'                  => '',
            'quiz_pdf'                    => '',
            'quiz_instructions'           => '',
            'year_group'                  => '',
            'subject'                     => '',
            'year_id'                     => (isset($data['year_id']) && $data['year_id'] > 0) ? $data['year_id'] : 100,
            'subject_id'                  => (isset($data['subject_id']) && $data['subject_id'] > 0) ? $data['subject_id'] : 100,
        ]);

        QuizTranslation::updateOrCreate([
            'quiz_id' => $quiz->id,
            'locale'  => mb_strtolower($locale),
        ], [
            'title' => $data['title'],
        ]);

        if (!empty($question_list_ids)) {
            foreach ($question_list_ids as $sort_order => $question_id) {
                $QuizzesQuestion = QuizzesQuestion::findOrFail($question_id);
                $questionObj = $QuizzesQuestion->replicate();
                $questionObj->reference_question_id = $question_id;
                $AassignmentQuestion = AssignmentsQuestions::firstOrCreate($questionObj);

                QuizzesQuestionsList::create([
                    'quiz_id'     => $quiz->id,
                    'question_id' => $AassignmentQuestion,
                    'status'      => 'active',
                    'sort_order'  => $sort_order,
                    'created_by'  => $user->id,
                    'created_at'  => time()
                ]);
            }
        }
        if ($request->ajax()) {

            $redirectUrl = '';

            if (empty($data['is_webinar_page'])) {
                $redirectUrl = getAdminPanelUrl('/quizzes/' . $quiz->id . '/edit');
            }

            return response()->json([
                'code'         => 200,
                'redirect_url' => $redirectUrl
            ]);
        } else {
            return redirect()->route('adminEditAssignment', ['id' => $quiz->id]);
        }
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('admin_quizzes_edit');

        $quiz = Quiz::query()->where('id', $id)
            ->with([
                'quizQuestions'     => function ($query) {
                    $query->orderBy('order', 'asc');
                    $query->with('quizzesQuestionsAnswers');
                },
                'quizQuestionsList' => function ($query) {
                    $query->where('status', 'active');
                    $query->orderBy('sort_order', 'asc');
                    $query->with('QuestionData');
                },
            ])
            ->first();

        if( $quiz->status == 'active'){
            $toastData = [
                'title' => 'Request not completed',
                'msg' => 'You dont have permissions to perform this action.',
                'status' => 'error'
            ];
            return redirect()->back()->with(['toast' => $toastData]);
        }


        if (empty($quiz)) {
            abort(404);
        }

        $creator = $quiz->creator;

        $webinars = Webinar::where('status', 'active')
            ->where(function ($query) use ($creator) {
                $query->where('teacher_id', $creator->id)
                    ->orWhere('creator_id', $creator->id);
            })->get();

        $locale = $request->get('locale', app()->getLocale());
        if (empty($locale)) {
            $locale = app()->getLocale();
        }
        storeContentLocale($locale, $quiz->getTable(), $quiz->id);

        $quiz->title = $quiz->getTitleAttribute();
        $quiz->locale = mb_strtoupper($locale);

        $chapters = collect();

        if (!empty($quiz->webinar)) {
            $chapters = $quiz->webinar->chapters;
        }

        $categories = Category::where('parent_id', null)
            ->with('subCategories')->orderBy('order', 'asc')
            ->get();


        $topics_subtopics_layout = $this->topics_subtopics_by_subject($request, $quiz->subject_id, false, $quiz->topic_id, $quiz->subtopic_id);


        $data = [
            'pageTitle'               => trans('public.edit') . ' ' . $quiz->title,
            'webinars'                => $webinars,
            'assignment'              => $quiz,
            'quizQuestions'           => $quiz->quizQuestions,
            'creator'                 => $creator,
            'chapters'                => $chapters,
            'categories'              => $categories,
            'topics_subtopics_layout' => $topics_subtopics_layout,
            'locale'                  => mb_strtolower($locale),
            'defaultLocale'           => getDefaultLocale(),
        ];

        $query = Webinar::query();

        $webinars = DB::table('webinars')
            ->join('webinar_translations', 'webinar_translations.webinar_id', '=', 'webinars.id')
            ->join('webinar_chapters', 'webinar_chapters.webinar_id', '=', 'webinars.id')
            ->join('webinar_chapter_translations', 'webinar_chapter_translations.webinar_chapter_id', '=', 'webinar_chapters.id')
            ->select('webinars.id', 'webinar_translations.title', 'webinar_chapters.id as chapter_id', 'webinar_chapter_translations.title as chapter_title')
            ->get();

        $chapters_list = array();
        if (!empty($webinars)) {
            foreach ($webinars as $webinarData) {
                $webinar_id = isset($webinarData->id) ? $webinarData->id : '';
                $webinar_title = isset($webinarData->title) ? $webinarData->title : '';
                $chapter_id = isset($webinarData->chapter_id) ? $webinarData->chapter_id : '';
                $chapter_title = isset($webinarData->chapter_title) ? $webinarData->chapter_title : '';
                $chapters_list[$webinar_id]['title'] = $webinar_title;
                $chapters_list[$webinar_id]['chapters'][$chapter_id] = $chapter_title;
            }
        }
        $data['chapters'] = $chapters_list;

        return view('admin.assignments.edit', $data);
    }


    public function update_question(Request $request)
    {
        $user = auth()->user();
        $question_ids = $request->get('questions_ids', null);
        $assignment_id = $request->get('assignment_id', null);
        $action = $request->get('action', null);


        $assignmentObj = Quiz::query()->findOrFail($assignment_id);

        $quizQuestionsListArray = $assignmentObj->quizQuestionsList->pluck('question_id')->toArray();

        $quiz_question_ids = array();
        //if( $action == 'add') {
        if (!empty($question_ids)) {
            $sort_order = 0;
            foreach ($question_ids as $question_id) {
                $quiz_question_ids[]    = $question_id;
                if (in_array($question_id, $quizQuestionsListArray)) {
                    $questionListObj = QuizzesQuestionsList::query()->where('quiz_id', $assignment_id)->where('question_id',
                        $question_id)->update([
                        'sort_order' => $sort_order,
                    ]);
                } else {

                    $QuizzesQuestion = QuizzesQuestion::findOrFail($question_id);
                    $questionObj = $QuizzesQuestion->replicate();
                    $questionObj->reference_question_id = $question_id;
                    $questionObj->created_at = time();
                    $questionObj->quiz_id = $assignment_id;
                    $questionObj = $questionObj->toArray();
                    unset($questionObj['title']);
                    unset($questionObj['correct']);
                    unset($questionObj['translations']);
                    $AassignmentQuestion = AssignmentsQuestions::firstOrCreate($questionObj);
                    QuizzesQuestionsList::create([
                        'quiz_id'     => $assignment_id,
                        'question_id' => $question_id,
                        'status'      => 'active',
                        'sort_order'  => $sort_order,
                        'created_by'  => $user->id,
                        'created_at'  => time(),
                        'reference_question_id' => $AassignmentQuestion->id,
                    ]);
                }
                $sort_order++;
            }
        }
        QuizzesQuestionsList::where('quiz_id', $assignment_id)->whereNotIn('question_id', $quiz_question_ids)->delete();
        AssignmentsQuestions::where('quiz_id', $assignment_id)->whereNotIn('reference_question_id', $quiz_question_ids)->delete();
        //}
        pre('Done');
    }
    
    public function publish_assignment(Request $request)
    {
        $user = auth()->user();
        $assignment_id = $request->get('assignment_id', null);
        $assignmentObj = Quiz::query()->findOrFail($assignment_id);
        $assignmentObj->update([
            'status'    => 'active',
            'updated_at' => time(),
        ]);
        pre('Done');
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::query()->findOrFail($id);
        $user = $quiz->creator;

        $quizQuestionsCount = $quiz->quizQuestions->count();
        $quizQuestionsListArray = $quiz->quizQuestionsList->pluck('question_id')->toArray();


        //QuizzesQuestionsList::whereNotIn('id' , $quizQuestionsListArray)->update(array('status' => 'inactive'));


        $data = $request->get('ajax')[$id];

        pre($data);
        $locale = $data['locale'] ?? getDefaultLocale();


        $rules = [
            'title' => 'required|max:255',
            //'webinar_id' => 'required|exists:webinars,id' ,
            //'pass_mark' => 'required',
            //'display_number_of_questions' => 'required_if:display_limited_questions,on|nullable|between:1,' . $quizQuestionsCount
        ];

        $validate = Validator::make($data, $rules);

        $question_list_ids = isset($data['question_list_ids']) ? $data['question_list_ids'] : array();


        if ($validate->fails()) {
            return response()->json([
                'code'   => 422,
                'errors' => $validate->errors()
            ], 422);
        }

        $user = $quiz->creator;
        $webinar = null;
        $chapter = null;


        $quiz->update([
            //'webinar_id' => !empty($webinar) ? $webinar->id : null,
            //'chapter_id' => !empty($chapter) ? $chapter->id : null,
            //'webinar_id'     => isset($data['webinar_id']) ? $data['webinar_id'] : 0 ,
            'quiz_slug'          => (isset($data['quiz_slug']) && $data['quiz_slug'] != '') ? $data['quiz_slug'] : Quiz::makeSlug($data['title']),
            'attempt'            => 100,
            'pass_mark'          => 1,
            'time'               => 20,
            'quiz_type'          => 'assignment',
            'status'             => Quiz::ACTIVE,
            'certificate'        => (!empty($data['certificate']) and $data['certificate'] == 'on') ? true : false,
            'updated_at'         => time(),
            'quiz_settings'      => json_encode(array()),
            'mastery_points'     => 0,
            'show_all_questions' => 0,
            'sub_title'          => '',
            'quiz_image'         => '',
            'quiz_pdf'           => '',
            'quiz_instructions'  => '',
            'year_group'         => '',
            'subject'            => '',
            'year_id'            => (isset($data['year_id']) && $data['year_id'] > 0) ? $data['year_id'] : 100,
            'subject_id'         => (isset($data['subject_id']) && $data['subject_id'] > 0) ? $data['subject_id'] : 100,
        ]);

        if (!empty($quiz)) {


            $quiz_question_ids = array();
            if (!empty($question_list_ids)) {
                foreach ($question_list_ids as $sort_order => $question_id) {
                    $quiz_question_ids[] = $question_id;
                    if (in_array($question_id, $quizQuestionsListArray)) {
                        $questionListObj = QuizzesQuestionsList::query()->where('quiz_id', $id)->where('question_id',
                            $question_id)->update([
                            'sort_order' => $sort_order,
                        ]);
                    } else {
                        QuizzesQuestionsList::create([
                            'quiz_id'     => $quiz->id,
                            'question_id' => $question_id,
                            'status'      => 'active',
                            'sort_order'  => $sort_order,
                            'created_by'  => $user->id,
                            'created_at'  => time()
                        ]);
                    }
                }
            }
            QuizzesQuestionsList::where('quiz_id', $id)->whereNotIn('question_id', $quiz_question_ids)->update(array('status' => 'inactive'));

            QuizTranslation::updateOrCreate([
                'quiz_id' => $quiz->id,
                'locale'  => mb_strtolower($locale),
            ], [
                'title' => $data['title'],
            ]);
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

    public function delete(Request $request, $id)
    {
        $this->authorize('admin_quizzes_delete');

        $quiz = Quiz::findOrFail($id);

        $quiz->delete();

        $checkChapterItem = WebinarChapterItem::where('item_id', $id)
            ->where('type', WebinarChapterItem::$chapterQuiz)
            ->first();

        if (!empty($checkChapterItem)) {
            $checkChapterItem->delete();
        }

        if ($request->ajax()) {
            return response()->json([
                'code' => 200
            ], 200);
        }

        return redirect()->back();
    }


    public function subjects_by_year(Request $request)
    {
        $year_id = $request->get('year_id', null);
        $webinars = Webinar::where('category_id', $year_id)
            ->get();


        if (!empty($webinars)) {
            echo '<div class="col-lg-12 col-md-12 col-sm-6 col-12 subjects-group populated-data">
            <div class="row">';
            foreach ($webinars as $webinarObj) {
                ?>

                <div class="col-lg-4 col-md-4 col-sm-6 col-12 subject-group-select"
                     data-subject_id=" <?php echo $webinarObj->id; ?>">
                    <div class="card card-medium-icons">
                        <div class="card-icon bg-primary text-white p-30 text-center">
                            <?php echo $webinarObj->getTitleAttribute(); ?>
                        </div>
                    </div>
                </div>
                <?php
            }
            echo '</div></div>';
        }
        exit;
    }

    public function topics_subtopics_by_subject(Request $request, $subject_id = 0, $is_exit = true, $default_chapter = 0, $default_subchapter = 0)
    {
        if ($subject_id == 0) {
            $subject_id = $request->get('subject_id', null);
        }
        $WebinarChapter = WebinarChapter::where('webinar_id', $subject_id)->with('subChapters')->get();
        //pre($WebinarChapter);


        $response = '';
        if (!empty($WebinarChapter) && count($WebinarChapter) > 0) {
            $response .= '<div class="col-lg-12 col-md-12 col-sm-12 col-12 populated-data">';
            $response .= '<div class="col-lg-12 col-md-12 col-sm-6 col-12 card chapters-group accordion" id="chaptersAccordion"><div class="row">';
            foreach ($WebinarChapter as $WebinarChapter) {
                $response .= '<div class="col-lg-12 col-md-12 col-sm-12 col-12 card">
                    <div class="card-header collapsed mb-0" id="headingOne" type="button"
                         data-toggle="collapse"
                         data-target="#chapter_' . $WebinarChapter->id . '" aria-expanded="true"
                         aria-controls="chapter_' . $WebinarChapter->id . '">
                        <span>' . $WebinarChapter->getTitleAttribute() . '</span>
                    </div>';
                if (!empty($WebinarChapter->subChapters)) {
                    $response .= '<div id="chapter_' . $WebinarChapter->id . '" class="collapse"
                             aria-labelledby="headingOne"
                             data-parent="#chaptersAccordion">
                            <div class="card-body">
                                <ul class="subchapter-group-select">';
                    foreach ($WebinarChapter->subChapters as $subChapterObj) {

                        $selected = ($subChapterObj->id == $default_subchapter) ? 'default-active' : '';
                        $response .= '<li class="' . $selected . '" data-chapter_id="' . $WebinarChapter->id . '" data-subchapter_id="' . $subChapterObj->id . '">' . $subChapterObj->sub_chapter_title . '</li>';

                    }
                    $response .= '</ul>
                            </div>
                        </div>';
                }
                $response .= '</div>';
            }
            $response .= '</div></div>';
            $response .= '</div>';
        }

        /*echo '<div class="col-lg-6 col-md-6 col-sm-4 col-12 card questions-group populated-data">';
        echo '<div class="search-field-box search-field-box"><div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-4 col-12">
                      <input type="text" id="search-questions" class="form-control search-questions mt-10">
                    </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                      <label>Custom Questions</label><div class="custom-control custom-switch">
            
                          <input type="checkbox" name="search_question_bank" class="search_question_bank custom-control-input" id="search_question_bank">
                          <label class="custom-control-label" for="search_question_bank"></label>
                      </div>
                </div>
                    </div>
                    </div><div class="questions-populate-area"></div>';
        echo '</div>';*/

        if ($is_exit == true) {
            echo $response;
            exit;
        } else {
            return $response;
        }
    }

    public function questions_by_subchapter(Request $request)
    {
        $subchapter_id = $request->get('subchapter_id', null);
        $chapter_id = $request->get('chapter_id', null);
        $assignment_id = $request->get('assignment_id', null);

        $assignmentObj = Quiz::query()->find($assignment_id);

        $quizQuestionsListArray = $assignmentObj->quizQuestionsList->pluck('question_id')->toArray();

        $assignmentObj->update([
            'topic_id'    => $chapter_id,
            'subtopic_id' => $subchapter_id,
        ]);

        $subChapter = SubChapters::find($subchapter_id);
        $chapter_title = $subChapter->chapter->getTitleAttribute();

        $WebinarChapterItem = WebinarChapterItem::where('parent_id', $subchapter_id)->where('type', 'quiz')->first();
        $quiz_id = isset($WebinarChapterItem->item_id) ? $WebinarChapterItem->item_id : 0;
        $QuizObj = (object)array();
        if ($quiz_id > 0) {
            $QuizObj = Quiz::with(['quizQuestionsList.SingleQuestionData'])->where('status', 'active')->where('id', $quiz_id)->first();
        }


        echo '<div class="col-lg-12 col-md-12 col-sm-4 col-12 questions-group populated-data">
        ';
        echo '<div class="search-field-box search-field-box"><div class="row">
                       <div class="col-lg-8 col-md-8 col-sm-4 col-12">
                         <input type="text" id="search-questions" class="form-control search-questions mt-10">
                       </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                         <label>Custom Questions</label><div class="custom-control custom-switch">
               
                             <input type="checkbox" name="search_question_bank" class="search_question_bank custom-control-input" id="search_question_bank">
                             <label class="custom-control-label" for="search_question_bank"></label>
                         </div>
                   </div>
                       </div>
                       </div><div class="questions-populate-area">';

        if (isset($QuizObj->quizQuestionsList)) {
            echo '<ul class="questions-group-select" id="questions-group-select">';
            foreach ($QuizObj->quizQuestionsList as $questionObj) {
                if (isset($questionObj->SingleQuestionData->id)) {

                    $already_added_btn = in_array($questionObj->SingleQuestionData->id, $quizQuestionsListArray)? '<a href="javascript:;" class="questions-rm-list">Remove</a>' : '<a href="javascript:;" class="add-to-list-btn">Add</a>';
                    $review_required_title = ($questionObj->SingleQuestionData->review_required > 0)? '<span class="topic-title review-required">Review Required</span>' : '';

                    echo '<li data-question_id="' . $questionObj->SingleQuestionData->id . '">
                        <div class="question-list-item" id="question-list-item">
                        <span class="question-title">' . $questionObj->SingleQuestionData->question_title . '</span>
                        <span class="topic-title">' . $chapter_title . '</span>
                        '.$review_required_title.'
                        <span class="difficulty-level">' . $questionObj->SingleQuestionData->question_difficulty_level . '</span>
                        <span class="question-id">ID:# ' . $questionObj->SingleQuestionData->id . '</span>
                        <span class="question-marks">Marks: ' . $questionObj->SingleQuestionData->question_score . '</span>
                        <span class="list-buttons">
                            '.$already_added_btn.'
                        </span>
                        </div>
                    </li>';


                    //echo '<li data-question_id="' . $questionObj->SingleQuestionData->id . '"><a href="javascript:;">' . $questionObj->SingleQuestionData->id . ' | ' . $questionObj->SingleQuestionData->question_title . ' | ' . $questionObj->SingleQuestionData->question_difficulty_level . '</a></li>';
                }
            }
            echo '</ul>';
        }

        echo '</div>';
        echo '</div>';


        exit;

    }

    public function questions_by_keyword(Request $request)
    {
        $user = auth()->user();
        $keyword = $request->get('keyword', null);
        $year_id = $request->get('year_id', null);
        $subject_id = $request->get('subject_id', null);

        $questionIds = QuizzesQuestion::where(function ($query) use ($keyword) {
            $query->where('question_title', 'like', '%' . $keyword . '%')->orWhere('search_tags', 'like', '%' . $keyword . '%')->orWhere('question_difficulty_level', 'like', '%' . $keyword . '%');
        })->where('creator_id', $user->id)->where('category_id', $year_id)->where('course_id', $subject_id)->get();

        $questions_array = array();
        if (!empty($questionIds)) {
            foreach ($questionIds as $questionObj) {
                echo '<li data-question_id="' . $questionObj->id . '"><a href="javascript:;">' . $questionObj->id . ' | ' . $questionObj->question_title . ' | ' . $questionObj->question_difficulty_level . '</a></li>';
            }
        }
        exit;

    }

    public function assignment_preview(Request $request)
    {
        $user = auth()->user();
        $questions_ids = $request->get('questions_ids', null);
        $assignment_title = $request->get('assignment_title', null);


        $question_response_layout = '<section class="quiz-topbar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5 col-md-6 col-sm-12">
                        <div class="quiz-top-info"><p>' . $assignment_title . '</p>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12">
                        <div class="topbar-right">
                            <div class="quiz-pagination">
                                <div class="swiper-container">
                                    <ul class="swiper-wrapper">';

        $question_count = 1;
        foreach ($questions_ids as $question_id) {
            $active_class = ($question_count == 1) ? 'active' : '';
            $question_response_layout .= '<li data-question_id="' . $question_id . '" class="swiper-slide waiting ' . $active_class . '"><a href="javascript:;">' . $question_count . '</a></li>';
            $question_count++;
        }
        $question_response_layout .= '</ul>
                                </div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>';

        $question_count = 1;

        foreach ($questions_ids as $question_id) {
            $questionObj = QuizzesQuestion::find($question_id);
            $question_class = ($question_count == 1) ? '' : 'rurera-hide';
            $question_response_layout .= '<div data-question_id="' . $question_id . '" class="question-block ' . $question_class . '">';
            $question_response_layout .= view('admin.questions_bank.preview', [
                'question'       => $questionObj,
                'prev_question'  => 0,
                'next_question'  => 0,
                'disable_submit' => 'false',
                'disable_finish' => 'false',
                'disable_prev'   => 'false',
                'disable_next'   => 'false',
                'class'          => 'disable-div',
                'question_count' => $question_count,
                'total_questions' => count($questions_ids),
                'submit_class' => 'disable-click',
                'rev_btn_class' => 'disable-click',
            ])->render();
            $question_response_layout .= '</div>';
            $question_count++;
        }

        echo $question_response_layout;
        exit;

    }

    public function single_question_preview(Request $request)
    {
        $user = auth()->user();
        $question_id = $request->get('question_id', null);

        $assignment_title = $request->get('assignment_title', null);


        $question_response_layout = '<section class="quiz-topbar">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-5 col-md-6 col-sm-12">
                                <div class="quiz-top-info"><p>' . $assignment_title . '</p>
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12">
                                <div class="topbar-right">
                                    <div class="quiz-pagination">
                                        <div class="swiper-container">
                                            <ul class="swiper-wrapper">';

        $question_count = 1;
        $question_response_layout .= '<li data-question_id="' . $question_id . '" class="swiper-slide waiting active"><a href="javascript:;">' . $question_count . '</a></li>';
        $question_response_layout .= '</ul>
                                        </div>
                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-button-next"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>';

        $question_count = 1;

        $questionObj = QuizzesQuestion::find($question_id);
        $question_class = ($question_count == 1) ? '' : 'rurera-hide';
        $question_response_layout .= '<div data-question_id="' . $question_id . '" class="question-block ' . $question_class . '">';
        $question_response_layout .= view('admin.questions_bank.preview', [
            'question'       => $questionObj,
            'prev_question'  => 0,
            'next_question'  => 0,
            'disable_submit' => 'false',
            'disable_finish' => 'false',
            'disable_prev'   => 'false',
            'disable_next'   => 'false',
            'class'          => 'disable-div',
            'question_count' => $question_count,
            'total_questions' => 1,
            'prev_btn_class' => 'disable-click',
            'next_btn_class' => 'disable-click',
            'submit_class' => 'disable-click',
            'rev_btn_class' => 'disable-click',
        ])->render();
        $question_response_layout .= '</div>';

        echo $question_response_layout;
        exit;

    }


}
