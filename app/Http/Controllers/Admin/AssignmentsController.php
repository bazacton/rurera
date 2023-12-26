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
use App\Models\StudentAssignments;
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

class AssignmentsController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('admin_assignments');

        removeContentLocale();
        //DB::enableQueryLog();

        $query = StudentAssignments::query()->where('status', '!=', 'inactive');

        if (auth()->user()->isTeacher()) {
            $query = $query->where('created_by', auth()->user()->id);
        }
        $totalAssignments = deepClone($query)->count();

        $query = $this->filters($query, $request);


        $assignments = $query->paginate(100);

        //pre($quizzes);

        //pre(DB::getQueryLog());
        //DB::disableQueryLog();

        $data = [
            'pageTitle'        => 'Assignments',
            'assignments'      => $assignments,
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


    public function create()
    {
        $this->authorize('admin_assignments_create');

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
            'pageTitle'  => 'Create Assignment',
            'categories' => $categories,
            'sections'   => $sections,
            'classes'    => $classes,
            'teachers'   => $teachers,
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

        $topic_ids = isset($data['topic_ids']) ? $data['topic_ids'] : array();
        $assignment_topic_type = isset($data['assignment_topic_type']) ? $data['assignment_topic_type'] : '';
        $topic_id = isset($data['topic_id']) ? $data['topic_id'] : '';
        if( $assignment_topic_type == 'practice'){
            $question_list_ids = QuizzesQuestionsList::whereIn('quiz_id', $topic_ids)->where('status', 'active')->pluck('question_id')->toArray();

            $assignment_title = isset($data['title']) ? $data['title'] : '';

            $practiceQuiz = Quiz::create([
                'quiz_slug'                   => Quiz::makeSlug($assignment_title),
                'webinar_id'                  => 0,
                'chapter_id'                  => 0,
                'creator_id'                  => $user->id,
                'webinar_title'               => '',
                'attempt'                     => 100,
                'quiz_type'                   => 'practice',//isset($data['quiz_type']) ? $data['quiz_type'] : '',
                'sub_chapter_id'              => 0,
                'pass_mark'                   => 1,
                'time'                        => 100,
                'display_number_of_questions' => 0,
                'status'                      => Quiz::ACTIVE,
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
                'examp_board'                 => '',
                'year_id'                     => isset($data['year_id']) ? $data['year_id'] : 0,
                'quiz_category'               => '',

            ]);

            QuizTranslation::updateOrCreate([
                'quiz_id' => $practiceQuiz->id,
                'locale'  => mb_strtolower($locale),
            ], [
                'title' => $assignment_title,
            ]);

            if (!empty($question_list_ids)) {
                foreach ($question_list_ids as $sort_order => $question_id) {
                    QuizzesQuestionsList::create([
                        'quiz_id'     => $practiceQuiz->id,
                        'question_id' => $question_id,
                        'status'      => 'active',
                        'sort_order'  => $sort_order,
                        'created_by'  => $user->id,
                        'created_at'  => time()
                    ]);
                }
            }
            $topic_id = $practiceQuiz->id;
        }

        $assignment_start_date = isset($data['assignment_start_date']) ? strtotime($data['assignment_start_date']) : '';
        $assignment_end_date = isset($data['assignment_end_date']) ? strtotime($data['assignment_end_date']) : '';
        $assignment_end_date = ($assignment_end_date != '') ? $assignment_end_date : $assignment_start_date;
        $recurring_type = 'Once';

        $dates_difference = dates_difference($assignment_end_date, $assignment_start_date);
        $total_days = isset($dates_difference->days) ? $dates_difference->days : 0;
        $total_days = 1;
        $assignment_events_dates = array();
        switch ($recurring_type) {
            case "Once":
                $total_days = 1;
                if ($total_days > 0) {
                    $counter = 1;
                    $last_event_date = date('Y-m-d', $assignment_start_date);
                    $last_event_date = $last_event_date . ' 00:00:00';

                    $last_event_date_end = date('Y-m-d', $assignment_end_date);
                    $last_event_date_end = $last_event_date_end . ' 23:59:59';

                    $assignment_events_dates[] = array(
                        'start' => strtotime($last_event_date),
                        'end'   => strtotime($last_event_date_end),
                    );
                }

                break;

                break;

            case "Weekly":
                break;
            case "Monthly":
                break;
        }

        $StudentAssignments = StudentAssignments::create([
            'parent_id'                  => $user->id,
            'title'                      => isset($data['title']) ? $data['title'] : '',
            'description'                => isset($data['description']) ? $data['description'] : '',
            'assignment_type'            => $assignment_topic_type,
            'tables_no'                  => isset($data['tables_no']) ? json_encode($data['tables_no']) : '',
            'no_of_questions'            => isset($data['no_of_questions']) ? $data['no_of_questions'] : '',
            'duration_type'              => isset($data['duration_type']) ? ($data['duration_type']) : '',
            'practice_time'              => isset($data['practice_time']) ? ($data['practice_time']) : 0,
            'time_interval'              => isset($data['time_interval']) ? ($data['time_interval']) : 0,
            'assignment_start_date'      => $assignment_start_date,
            'assignment_end_date'        => $assignment_end_date,
            'no_of_attempts'             => isset($data['no_of_attempts']) ? ($data['no_of_attempts']) : 0,
            'recurring_type'             => 'Once',
            'class_ids'                  => isset($data['class_ids']) ? json_encode($data['class_ids']) : '',
            'target_percentage'          => isset($data['target_percentage']) ? $data['target_percentage'] : 0,
            'target_average_time'        => isset($data['target_average_time']) ? $data['target_average_time'] : 0,
            'assignment_reviewer'        => isset($data['assignment_reviewer']) ? json_encode($data['assignment_reviewer']) : array(),
            'assignment_review_due_date' => isset($data['assignment_review_due_date']) ? strtotime($data['assignment_review_due_date']) : 0,
            'assignment_method'          => isset($data['assignment_method']) ? $data['assignment_method'] : 'practice',
            'status'                     => 'active',
            'created_by'                 => $user->id,
            'created_at'                 => time(),
            'topic_ids'                  => json_encode($topic_ids),
        ]);

        $users_array = isset($data['assignment_users']) ? $data['assignment_users'] : array();
        if (!empty($assignment_events_dates)) {
            foreach ($assignment_events_dates as $eventDate) {
                if ($assignment_topic_type == 'timestables') {
                    $TimestablesEvents = TimestablesEvents::create([
                        'parent_type' => 'assignment',
                        'parent_id'   => $StudentAssignments->id,
                        'status'      => 'pending',
                        'created_by'  => $user->id,
                        'created_at'  => time(),
                        'start_at'    => $eventDate['start'],
                        'expired_at'  => $eventDate['end'],
                        'updated_at'  => time(),
                    ]);
                    $topic_id = $TimestablesEvents->id;
                }

                if (!empty($users_array)) {
                    foreach ($users_array as $user_id) {
                        $UserAssignedTimestables = UserAssignedTopics::create([
                            'assigned_to_id'        => $user_id,
                            'assigned_by_id'        => $user->id,
                            'student_assignment_id' => $StudentAssignments->id,
                            'topic_id'              => $topic_id,
                            'status'                => 'active',
                            'created_at'            => time(),
                            'start_at'              => $eventDate['start'],
                            'deadline_date'         => $eventDate['end'],
                        ]);
                    }
                }

            }
        }

        if ($request->ajax()) {

            $redirectUrl = '';

            if (empty($data['is_webinar_page'])) {
                $redirectUrl = getAdminPanelUrl('/assignments');
            }

            return response()->json([
                'code'         => 200,
                'redirect_url' => $redirectUrl
            ]);
        } else {
            return redirect()->route('adminListAssignment', []);
        }
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('admin_quizzes_edit');


        $assignmentObj = StudentAssignments::query()->where('id', $id)->where('status', '!=', 'inactive')->first();

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
