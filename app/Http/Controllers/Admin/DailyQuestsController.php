<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\QuestionsAttemptController;
use App\Models\Category;
use App\Models\Classes;
use App\Models\Quiz;
use App\Models\QuizzesQuestion;
use App\Models\AssignmentsQuestions;
use App\Models\QuizzesResult;
use App\Models\QuizzesQuestionsList;
use App\Models\DailyQuests;
use App\Models\Translation\QuizTranslation;
use App\Models\UserAssignedTimestables;
use App\Models\TimestablesEvents;
use App\Models\UserAssignedTopics;
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
use Illuminate\Support\Carbon;

class DailyQuestsController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $user_id = $user->id;

        $class_id = $user->class_id;
        //$this->authorize('admin_assignments');

        removeContentLocale();
        //DB::enableQueryLog();
        $today_date = strtotime(date('Y-m-d'));

        $query = DailyQuests::query()->where('status', '!=', 'inactive');

        if (auth()->user()->isTeacher()) {
            $query = $query->where('created_by', auth()->user()->id);
        }
        $totalQuests = deepClone($query)->count();

        $query = $this->filters($query, $request);


        $quests = $query->paginate(100);

        //pre($quizzes);

        //pre(DB::getQueryLog());
        //DB::disableQueryLog();

        $data = [
            'pageTitle'        => 'Daily Quests',
            'quests'      => $quests,
            'totalQuests' => $totalQuests,
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

        return view('admin.daily_quests.lists', $data);
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
        //$this->authorize('admin_assignments_create');

        $categories = Category::where('parent_id', null)
            ->with('subCategories')->orderBy('order', 'asc')
            ->get();


        //pre('test');


        $QuestionsAttemptController = new QuestionsAttemptController();

        $classes_query = Classes::where('parent_id', '=', 0)->where('status', 'active');

        $sections_query = Classes::where('parent_id', '>', 0)->where('status', 'active')->with([
            'users'
        ]);

        if (auth()->user()->isTeacher()) {
            //$sections_query = $sections_query->where('created_by', $user->id);
        }

        $sections = $sections_query->get();

        $classes = $classes_query->get();

        $teachers_query = User::where('role_id', '=', 7)->where('status', 'active');
        $teachers = $teachers_query->get();

        $data = [
            'pageTitle'  => 'Create Quest',
            'categories' => $categories,
            'sections'   => $sections,
            'classes'    => $classes,
            'teachers'   => $teachers,
        ];

        return view('admin.daily_quests.create', $data);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $this->authorize('admin_quizzes_create');
        $data = $request->get('ajax')['new'];
        $locale = $data['locale'] ?? getDefaultLocale();

        $rules = [
            //'title' => 'required|max:255',
            //'assignment_start_date' => 'required',
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

        $quest_topic_type = isset($data['quest_topic_type']) ? $data['quest_topic_type'] : '';
        $timestables_mode = isset($data['timestables_mode']) ? $data['timestables_mode'] : '';
        $title = isset($data['title']) ? $data['title'] : '';
        $description = isset($data['description']) ? $data['description'] : '';
        $quest_method = isset($data['quest_method']) ? $data['quest_method'] : '';
        $no_of_answers = isset($data['no_of_answers']) ? $data['no_of_answers'] : '';
        $no_of_practices = isset($data['no_of_practices']) ? $data['no_of_practices'] : '';
        $lessons_score = isset($data['lessons_score']) ? $data['lessons_score'] : '';
        $screen_time = isset($data['screen_time']) ? $data['screen_time'] : '';
        $recurring_type = isset($data['recurring_type']) ? $data['recurring_type'] : 'Once';
        $quest_assign_type = isset($data['quest_assign_type']) ? $data['quest_assign_type'] : '';


        $quest_dates = isset($data['quest_dates']) ? explode(',', $data['quest_dates']) : array();
        $quest_start_date = isset($data['quest_start_date']) ? strtotime($data['quest_start_date']) : '';
        $quest_end_date = isset($data['quest_end_date']) ? strtotime($data['quest_end_date']) : '';

        $coins_type = isset($data['coins_type']) ? $data['coins_type'] : 'custom';
        $no_of_coins = isset($data['no_of_coins']) ? $data['no_of_coins'] : 0;
        $coins_percentage = isset($data['coins_percentage']) ? $data['coins_percentage'] : 0;
        $quest_icon = isset($data['quest_icon']) ? $data['quest_icon'] : '';
        $users_array = isset($data['assignment_users']) ? $data['assignment_users'] : array();
        $section_id = isset($data['section_id']) ? array($data['section_id']) : array();


        $quest_dates = array_map(function($date) {
            return strtotime(trim($date));
        }, $quest_dates);
        $quest_dates = json_encode($quest_dates, JSON_UNESCAPED_SLASHES);
        $quest_users = json_encode($users_array, JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
        $section_id = array_map('intval', $section_id);
        $section_id = json_encode($section_id, JSON_UNESCAPED_SLASHES);



        $DailyQuests = DailyQuests::create([
            'parent_id'                 => $user->id,
            'title'                     => isset($data['title']) ? $data['title'] : '',
            'description'               => isset($data['description']) ? $data['description'] : '',
            'quest_topic_type'          => $quest_topic_type,
            'quest_assign_type'         => $quest_assign_type,
            'no_of_practices'           => $no_of_practices,
            'lessons_score'             => $lessons_score,
            'screen_time'               => $screen_time,
            'no_of_answers'             => $no_of_answers,
            'quest_method'              => $quest_method,
            'recurring_type'            => $recurring_type,
            'class_ids'                 => $section_id,
            'status'                    => 'active',
            'created_by'                => $user->id,
            'created_at'                => time(),
            'timestables_mode'          => $timestables_mode,
            'coins_type'                => $coins_type,
            'no_of_coins'               => $no_of_coins,
            'coins_percentage'          => $coins_percentage,
            'quest_icon'                => $quest_icon,
            'quest_dates'                => $quest_dates,
            'quest_users'                => $quest_users,
        ]);

       return redirect()->route('adminListDailyQuests', []);
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('admin_quizzes_edit');


        $assignmentObj = DailyQuests::query()->where('id', $id)->where('status', '!=', 'inactive')->first();

        if (empty($assignmentObj)) {
            abort(404);
        }

        $categories = Category::where('parent_id', null)
            ->with('subCategories')->orderBy('order', 'asc')
            ->get();


        $sections_query = Classes::where('parent_id', '>', 0)->where('status', 'active')->with([
            'users'
        ]);

        $sections = $sections_query->get();

        $data = [
            'pageTitle'  => trans('public.edit') . ' ' . $assignmentObj->title,
            'assignment' => $assignmentObj,
            'categories' => $categories,
            'sections'   => $sections,
        ];

        return view('admin.assignments.create', $data);
    }

    public function progress(Request $request, $id)
    {
        $this->authorize('admin_quizzes_edit');


        $assignmentObj = DailyQuests::query()->where('id', $id)->where('status', '!=', 'inactive')->first();
        foreach( $assignmentObj->students as $assignmentTopicObj){
            //pre($assignmentTopicObj->count(), false);
        }

        if (empty($assignmentObj)) {
            abort(404);
        }

        $categories = Category::where('parent_id', null)
            ->with('subCategories')->orderBy('order', 'asc')
            ->get();


        $sections_query = Classes::where('parent_id', '>', 0)->where('status', 'active')->with([
            'users'
        ]);

        $sections = $sections_query->get();

        $data = [
            'pageTitle'  => 'Progress',
            'assignmentObj' => $assignmentObj,
            'categories' => $categories,
            'sections'   => $sections,
        ];

        return view('admin.assignments.progress', $data);
    }

    public function update_dates(Request $request)
    {
        $quest_id = $request->get('quest_id');
        $quest_dates = $request->get('dates_string');
        $quest_dates = isset($quest_dates) ? explode(',', $quest_dates) : array();
        $quest_dates = array_map(function($date) {
            return strtotime(trim($date));
        }, $quest_dates);
        $quest_dates = json_encode($quest_dates, JSON_UNESCAPED_SLASHES);

        $questObj = DailyQuests::find($quest_id);

        $questObj->update(['quest_dates' => $quest_dates]);
        pre('done');

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


}
