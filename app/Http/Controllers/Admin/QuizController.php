<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\QuizzesQuestion;
use App\Models\QuizzesResult;
use App\Models\QuizzesQuestionsList;
use App\Models\Translation\QuizTranslation;
use App\Models\Webinar;
use App\Models\WebinarChapter;
use App\Models\WebinarChapterItem;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Translation\QuizzesQuestionTranslation;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('admin_quizzes_list');

        removeContentLocale();
        //DB::enableQueryLog();

        $query = Quiz::query();

        if (auth()->user()->isTeacher()) {
            //$query = $query->where('creator_id', auth()->user()->id);
        }
        $totalQuizzes = deepClone($query)->count();
        $totalActiveQuizzes = deepClone($query)->where('status', 'active')->count();
        $totalStudents = QuizzesResult::groupBy('user_id')->count();
        $totalPassedStudents = QuizzesResult::where('status', 'passed')->groupBy('user_id')->count();


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
            'pageTitle'           => trans('admin/pages/quiz.admin_quizzes_list'),
            'quizzes'             => $quizzes,
            'totalQuizzes'        => $totalQuizzes,
            'totalActiveQuizzes'  => $totalActiveQuizzes,
            'totalStudents'       => $totalStudents,
            'totalPassedStudents' => $totalPassedStudents,
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

        return view('admin.quizzes.lists', $data);
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

    public function create()
    {
        $this->authorize('admin_quizzes_create');

        $data = [
            'pageTitle' => trans('quiz.new_quiz'),
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

        $categories = Category::where('parent_id', null)
            ->with('subCategories')->orderBy('order', 'asc')
            ->get();
        $data['chapters'] = $chapters_list;
        $data['categories'] = $categories;

        return view('admin.quizzes.create', $data);
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


        $webinar = (object)array();
        if (isset($data['webinar_id'])) {
            $webinar = Webinar::where('id', $data['webinar_id'])
                ->first();
        }

        $chapter = null;

        if (!empty($data['chapter_id'])) {
            $chapter = WebinarChapter::where('id', $data['chapter_id'])
                ->where('webinar_id', $webinar->id)
                ->first();
        }

        $mastery_points = isset($data['mastery_points']) ? $data['mastery_points'] : 0;


        $Emerging_questions = isset($data['Emerging']) ? $data['Emerging'] : array();
        $Expected_questions = isset($data['Expected']) ? $data['Expected'] : array();
        $Exceeding_questions = isset($data['Exceeding']) ? $data['Exceeding'] : array();

        $quiz_settings = array(
            'Emerging'  => array(
                'questions' => isset($data['Emerging']) ? sumNestedArrayValues($data['Emerging']) : '',
                'breakdown' => isset($data['Emerging']) ? $data['Emerging'] : '',
            ),
            'Expected'  => array(
                'questions' => isset($data['Expected']) ? sumNestedArrayValues($data['Expected']) : '',
                'breakdown' => isset($data['Expected']) ? $data['Expected'] : '',
            ),
            'Exceeding' => array(
                'questions' => isset($data['Exceeding']) ? sumNestedArrayValues($data['Exceeding']) : '',
                'breakdown' => isset($data['Exceeding']) ? $data['Exceeding'] : '',
                'incorrect_attempts' => isset($data['incorrect_attempts']) ? $data['incorrect_attempts'] : 0,
                'excess_time_taken' => isset($data['excess_time_taken']) ? $data['excess_time_taken'] : 0,
            ),

        );

        $quiz = Quiz::create([
            'quiz_slug'                   => (isset($data['quiz_slug']) && $data['quiz_slug'] != '') ? $data['quiz_slug'] : Quiz::makeSlug($data['title']),
            'webinar_id'                  => isset($webinar->id) ? $webinar->id : 0,
            'chapter_id'                  => !empty($chapter) ? $chapter->id : null,
            'creator_id'                  => isset($webinar->creator_id) ? $webinar->creator_id : $user->id,
            'webinar_title'               => isset($webinar->title) ? $webinar->title : '',
            'attempt'                     => (isset($data['attempt']) && $data['attempt'] > 0) ? $data['attempt'] : 100,
            'quiz_type'                   => 'practice',//isset($data['quiz_type']) ? $data['quiz_type'] : '',
            'sub_chapter_id'              => isset($data['sub_chapter_id']) ? $data['sub_chapter_id'] : 0,
            'pass_mark'                   => 1,
            'time'                        => (isset($data['time']) && $data['time'] > 0) ? $data['time'] : 100,
            'display_number_of_questions' => (isset($data['display_number_of_questions']) && $data['display_number_of_questions'] > 0) ? $data['display_number_of_questions'] : 0,
            'status'                      => Quiz::ACTIVE,
            'certificate'                 => 1,
            'created_at'                  => time(),
            'quiz_settings'               => json_encode($quiz_settings),
            'mastery_points'              => isset($data['mastery_points']) ? $data['mastery_points'] : 0,
            'show_all_questions'          => isset($data['show_all_questions']) ? $data['show_all_questions'] : 0,
            'sub_title'                   => isset($data['sub_title']) ? $data['sub_title'] : '',
            'quiz_image'                  => isset($data['quiz_image']) ? $data['quiz_image'] : '',
            'quiz_pdf'                    => isset($data['quiz_pdf']) ? $data['quiz_pdf'] : '',
            'quiz_instructions'           => isset($data['quiz_instructions']) ? $data['quiz_instructions'] : '',
            'year_group'                  => isset($data['year_group']) ? $data['year_group'] : '',
            'subject'                     => isset($data['subject']) ? $data['subject'] : '',
            'examp_board'                 => isset($data['examp_board']) ? $data['examp_board'] : '',
            'year_id'                     => isset($data['year_id']) ? $data['year_id'] : 0,
            'quiz_category'               => isset($data['quiz_category']) ? $data['quiz_category'] : '',

        ]);

        QuizTranslation::updateOrCreate([
            'quiz_id' => $quiz->id,
            'locale'  => mb_strtolower($locale),
        ], [
            'title' => $data['title'],
        ]);

        if (!empty($question_list_ids)) {
            foreach ($question_list_ids as $sort_order => $question_id) {
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

        if (!empty($quiz->chapter_id)) {
            WebinarChapterItem::makeItem($webinar->creator_id, $quiz->chapter_id, $quiz->id, WebinarChapterItem::$chapterQuiz);
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
            return redirect()->route('adminEditQuiz', ['id' => $quiz->id]);
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

        $data = [
            'pageTitle'     => trans('public.edit') . ' ' . $quiz->title,
            'webinars'      => $webinars,
            'quiz'          => $quiz,
            'quizQuestions' => $quiz->quizQuestions,
            'creator'       => $creator,
            'chapters'      => $chapters,
            'locale'        => mb_strtolower($locale),
            'categories'    => $categories,
            'defaultLocale' => getDefaultLocale(),
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

        return view('admin.quizzes.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::query()->findOrFail($id);
        $user = $quiz->creator;

        $quizQuestionsCount = $quiz->quizQuestions->count();
        $quizQuestionsListArray = $quiz->quizQuestionsList->pluck('question_id')->toArray();


        //QuizzesQuestionsList::whereNotIn('id' , $quizQuestionsListArray)->update(array('status' => 'inactive'));


        $data = $request->get('ajax')[$id];
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

        if (!empty($data['webinar_id'])) {
            $webinar = Webinar::where('id', $data['webinar_id'])->first();

            if (!empty($webinar) and !empty($data['chapter_id'])) {
                $chapter = WebinarChapter::where('id', $data['chapter_id'])
                    ->where('webinar_id', $webinar->id)
                    ->first();
            }
        }

        $mastery_points = isset($data['mastery_points']) ? $data['mastery_points'] : 0;

        $Below_points = isset($data['Below_points']) ? $data['Below_points'] : 0;
        $Emerging_points = isset($data['Emerging_points']) ? $data['Emerging_points'] : 0;
        $Expected_points = isset($data['Expected_points']) ? $data['Expected_points'] : 0;
        $Exceeding_points = isset($data['Exceeding_points']) ? $data['Exceeding_points'] : 0;
        $Challenge_points = isset($data['Challenge_points']) ? $data['Challenge_points'] : 0;

        $Below_questions = isset($data['Below']) ? $data['Below'] : 0;
        $Emerging_questions = isset($data['Emerging']) ? $data['Emerging'] : 0;
        $Expected_questions = isset($data['Expected']) ? $data['Expected'] : 0;
        $Exceeding_questions = isset($data['Exceeding']) ? $data['Exceeding'] : 0;
        $Challenge_questions = isset($data['Challenge']) ? $data['Challenge'] : 0;

        $quiz_settings = array(
            'Below'     => array(
                'questions'         => isset($data['Below']) ? $data['Below'] : '',
                'points_percentage' => isset($data['Below_points']) ? $data['Below_points'] : '',
                'points'            => 0,
            ),
            'Emerging'  => array(
                'questions'         => isset($data['Emerging']) ? $data['Emerging'] : '',
                'points_percentage' => isset($data['Emerging_points']) ? $data['Emerging_points'] : '',
                'points'            => 0,
            ),
            'Expected'  => array(
                'questions'         => isset($data['Expected']) ? $data['Expected'] : '',
                'points_percentage' => isset($data['Expected_points']) ? $data['Expected_points'] : '',
                'points'            => 0,
            ),
            'Exceeding' => array(
                'questions'         => isset($data['Exceeding']) ? $data['Exceeding'] : '',
                'points_percentage' => isset($data['Exceeding_points']) ? $data['Exceeding_points'] : '',
                'points'            => 0,
            ),
            'Challenge' => array(
                'questions'         => isset($data['Challenge']) ? $data['Challenge'] : '',
                'points_percentage' => isset($data['Challenge_points']) ? $data['Challenge_points'] : '',
                'points'            => 0,
            )
        );

        $quiz->update([
            //'webinar_id' => !empty($webinar) ? $webinar->id : null,
            //'chapter_id' => !empty($chapter) ? $chapter->id : null,
            //'webinar_id'     => isset($data['webinar_id']) ? $data['webinar_id'] : 0 ,
            'quiz_slug'          => (isset($data['quiz_slug']) && $data['quiz_slug'] != '') ? $data['quiz_slug'] : Quiz::makeSlug($data['title']),
            'attempt'            => 100,
            'pass_mark'          => isset($data['pass_mark']) ? $data['pass_mark'] : 1,
            'time'               => 20,
            'quiz_type'          => isset($data['quiz_type']) ? $data['quiz_type'] : '',
            'status'             => Quiz::ACTIVE,
            'certificate'        => (!empty($data['certificate']) and $data['certificate'] == 'on') ? true : false,
            'updated_at'         => time(),
            'quiz_settings'      => json_encode($quiz_settings),
            'mastery_points'     => $mastery_points,
            'show_all_questions' => isset($data['show_all_questions']) ? $data['show_all_questions'] : 0,
            'sub_title'          => isset($data['sub_title']) ? $data['sub_title'] : '',
            'quiz_image'         => isset($data['quiz_image']) ? $data['quiz_image'] : '',
            'quiz_pdf'           => isset($data['quiz_pdf']) ? $data['quiz_pdf'] : '',
            'quiz_instructions'  => isset($data['quiz_instructions']) ? $data['quiz_instructions'] : '',
            'year_group'         => isset($data['year_group']) ? $data['year_group'] : '',
            'subject'            => isset($data['subject']) ? $data['subject'] : '',
            'examp_board'        => isset($data['examp_board']) ? $data['examp_board'] : '',
            'year_id'            => isset($data['year_id']) ? $data['year_id'] : 0,
            'quiz_category'      => isset($data['quiz_category']) ? $data['quiz_category'] : '',
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

    public function results($id)
    {
        $this->authorize('admin_quizzes_results');

        $quizzesResults = QuizzesResult::where('quiz_id', $id)
            ->with([
                'quiz' => function ($query) {
                    $query->with(['teacher']);
                },
                'user'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $data = [
            'pageTitle'      => trans('admin/pages/quizResults.quiz_result_list_page_title'),
            'quizzesResults' => $quizzesResults,
            'quiz_id'        => $id
        ];

        return view('admin.quizzes.results', $data);
    }

    public function search_quiz(Request $request)
    {
        $term = $request->get('term');
        //$option = $request->get('option');

        $quizzes = DB::table('quiz_translations')
            ->select('quiz_id', 'title as name')
            ->where('title', 'like', '%' . $term . '%');

        return response()->json($quizzes->get(), 200);
    }

    public function resultsExportExcel($id)
    {
        $this->authorize('admin_quiz_result_export_excel');

        $quizzesResults = QuizzesResult::where('quiz_id', $id)
            ->with([
                'quiz' => function ($query) {
                    $query->with(['teacher']);
                },
                'user'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $export = new QuizResultsExport($quizzesResults);

        return Excel::download($export, 'quiz_result.xlsx');
    }

    public function resultDelete($result_id)
    {
        $this->authorize('admin_quizzes_results_delete');

        $quizzesResults = QuizzesResult::where('id', $result_id)->first();

        if (!empty($quizzesResults)) {
            $quizzesResults->delete();
        }

        return redirect()->back();
    }

    public function exportExcel(Request $request)
    {
        $this->authorize('admin_quizzes_lists_excel');

        $query = Quiz::query();

        $query = $this->filters($query, $request);

        $quizzes = $query->with([
            'webinar',
            'teacher',
            'quizQuestions',
            'quizResults',
        ])->get();

        return Excel::download(new QuizzesAdminExport($quizzes), trans('quiz.quizzes') . '.xlsx');
    }

    public function orderItems(Request $request, $quizId)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'items' => 'required',
            'table' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'code'   => 422,
                'errors' => $validator->errors(),
            ], 422);
        }

        $quiz = Quiz::query()->where('id', $quizId)->first();

        if (!empty($quiz)) {
            $tableName = $data['table'];
            $itemIds = explode(',', $data['items']);

            if (!is_array($itemIds) and !empty($itemIds)) {
                $itemIds = [$itemIds];
            }

            if (!empty($itemIds) and is_array($itemIds) and count($itemIds)) {
                switch ($tableName) {
                    case 'quizzes_questions':
                        foreach ($itemIds as $order => $id) {
                            QuizzesQuestion::where('id', $id)
                                ->where('quiz_id', $quiz->id)
                                ->update(['order' => ($order + 1)]);
                        }
                        break;
                }
            }
        }

        return response()->json([
            'title' => trans('public.request_success'),
            'msg'   => trans('update.items_sorted_successful')
        ]);
    }
}
