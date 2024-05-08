<?php
namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\QuestionsAttemptController;
use App\Mixins\RegistrationPackage\UserPackage;
use App\Models\Category;
use App\Models\Classes;
use App\Models\Quiz;
use App\Models\QuizzesQuestionsList;
use App\Models\StudentAssignments;
use App\Models\Subscribe;
use App\Models\Comment;
use App\Models\Gift;
use App\Models\Meeting;
use App\Models\ReserveMeeting;
use App\Models\Sale;
use App\Models\Support;
use App\Models\TimestablesEvents;
use App\Models\Translation\QuizTranslation;
use App\Models\UserAssignedTopics;
use App\Models\Webinar;
use App\Models\ParentsOrders;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SetWorkController extends Controller
{

    public function index()
    {
        $data['pageTitle'] = 'Assignments';

        /*if (auth()->user()->isParent()) {
            $childs = User::where('role_id', 1)
                ->where('parent_type', 'parent')
                ->where('parent_id', auth()->user()->id)
                ->where('status', 'active')
                ->with([
                    'userSubscriptions' => function ($query) {
                        $query->with(['subscribe']);
                    }
                ])
                ->get();
            if ($childs->count() == 0) {
                return redirect('/' . panelRoute() . '/students');
            }
        }*/
        //StudentAssignments::RunCron();
        $query = StudentAssignments::query()->where('status', '=', 'active');
        $query = $query->where('created_by', auth()->user()->id);
        $totalAssignments = deepClone($query)->count();
        $assignments = $query->paginate(2);
        $data['assignments'] = $assignments;

        return view(getTemplate() . '.panel.set_work.index', $data);
    }

    public function create()
    {
       $user = getUser();
       $data['pageTitle'] = 'Create';
       $childs = $user->parentChilds->where('status', 'active');

       $subscribedChilds = $subscribedChildsYears = array();
       if( $childs->count() > 0){
           //userSubscriptions
           foreach( $childs as $childLinkObj){
               $userSubscriptions = $childLinkObj->user->userSubscriptions;
               if( isset( $userSubscriptions->id)){
                   $subscribedChilds[] = $childLinkObj->user->id;
                   $subscribedChildsYears[] = $childLinkObj->user->year_id;
               }
           }
       }
       //$childs = $user->parentChilds->where('status', 'active')->whereIn('user_id', $subscribedChilds);
       //$childs = $user->parentChilds->where('status', 'active');
        $childs = $user->parentChilds->where('status', 'active')->sortBy(function ($child) {
            if( isset( $child->user->userSubscriptions->id )){
                return 0;
            }else{
                return 1;
            }
            //return $child->user->userSubscriptions->count();
        });

       //pre($childs);




       $query = Quiz::where('status', Quiz::ACTIVE)->whereIn('quiz_type', array('sats','11plus','cat4','iseb','independence_exams'))->with('quizQuestionsList');
       $query->whereIn('year_id', $subscribedChildsYears);
       $sats = $query->paginate(100);
       $QuestionsAttemptController = new QuestionsAttemptController();

       $data['childs'] = $childs;
       $data['QuestionsAttemptController'] = $QuestionsAttemptController;
       $data['sats'] = $sats;
       return view(getTemplate() . '.panel.set_work.create', $data);
    }

    public function search(Request $request)
    {
        $assignment_status = $request->get('assignment_status');

        $query = StudentAssignments::query()->where('status', '=', $assignment_status);
        $query = $query->where('created_by', auth()->user()->id);
        $totalAssignments = deepClone($query)->count();
        $assignments = $query->paginate(2);

        $response = '<div class="rurera-tables-list mb-30 ">';
        if ($assignments->count() > 0){
            foreach ($assignments as $assignmentObj) {
                $response .= view('web.default.panel.set_work.list_item', ['assignmentObj' => $assignmentObj])->render();
            }
        }else{
            $no_records_data = '<div class="no-record-found-head mb-20">
                    <ul class="d-flex align-items-center justify-content-between">
                        <li><h6 class="listing-title font-14 font-weight-500">Title</h6></li>
                        <li><h6 class="listing-title font-14 font-weight-500">Student</h6></li>
                        <li><h6 class="listing-title font-14 font-weight-500">Type</h6></li>
                        <li><h6 class="listing-title font-14 font-weight-500">Action</h6></li>
                    </ul>
            </div>';
            $response   .= view('web.default.default.list_no_record', ['no_records_data' => $no_records_data])->render();
        }
        $response   .= '</div><div class="rurera-pagination">'.$assignments->links().'</div>';
        echo $response;exit;
    }

    public function store(Request $request)
    {
        $user = auth()->user();
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

        $topic_ids = isset($data['topic_ids']) ? $data['topic_ids'] : array();
        $assignment_topic_type = isset($data['assignment_topic_type']) ? $data['assignment_topic_type'] : '';
        $topic_id = isset($data['topic_id']) ? $data['topic_id' ] : '';
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

        $topic_ids = is_array($topic_ids)? $topic_ids : array($topic_ids);
        $data['assignment_reviewer'] = isset( $data['assignment_reviewer'] )? $data['assignment_reviewer'] : array();
        $data['assignment_reviewer'] = is_array($data['assignment_reviewer'])? $data['assignment_reviewer'] : array( $data['assignment_reviewer'] );

        $practice_time = isset($data['practice_time']) ? ($data['practice_time']) : 0;
        $time_interval = isset($data['time_interval']) ? ($data['time_interval']) : 0;
        $duration_type = isset($data['duration_type']) ? ($data['duration_type']) : '';
        $duration_type = ( $practice_time == 0 && $time_interval == 0)? 'no_time_limit' : $duration_type;
        $duration_type = ( $practice_time > 0 && $time_interval == 0)? 'total_practice' : $duration_type;
        $duration_type = ( $time_interval > 0)? 'per_question' : $duration_type;

        $target_percentage = isset($data['target_percentage']) ? $data['target_percentage'] : 0;
        $target_average_time = isset($data['target_average_time']) ? $data['target_average_time'] : 0;
        $assignment_method = isset($data['assignment_method']) ? $data['assignment_method'] : 'practice';
        $assignment_method = ($target_percentage > 0 || $target_average_time > 0)? 'target_improvements' : 'practice';


        $StudentAssignments = StudentAssignments::create([
            'parent_id'                  => $user->id,
            'title'                      => isset($data['title']) ? $data['title'] : '',
            'description'                => isset($data['description']) ? $data['description'] : '',
            'assignment_type'            => $assignment_topic_type,
            'tables_no'                  => isset($data['tables_no']) ? json_encode($data['tables_no']) : '',
            'no_of_questions'            => isset($data['no_of_questions']) ? $data['no_of_questions'] : '',
            'duration_type'              => $duration_type,
            'practice_time'              => isset($data['practice_time']) ? ($data['practice_time']) : 0,
            'time_interval'              => isset($data['time_interval']) ? ($data['time_interval']) : 0,
            'assignment_start_date'      => $assignment_start_date,
            'assignment_end_date'        => $assignment_end_date,
            'no_of_attempts'             => isset($data['no_of_attempts']) ? ($data['no_of_attempts']) : 0,
            'recurring_type'             => 'Once',
            'class_ids'                  => (isset($data['class_ids']) && is_array($data['class_ids'])) ? json_encode($data['class_ids']) : '',
            'target_percentage'          => isset($data['target_percentage']) ? $data['target_percentage'] : 0,
            'target_average_time'        => isset($data['target_average_time']) ? $data['target_average_time'] : 0,
            'assignment_reviewer'        => isset($data['assignment_reviewer']) ? json_encode($data['assignment_reviewer']) : array(),
            'assignment_review_due_date' => isset($data['assignment_review_due_date']) ? strtotime($data['assignment_review_due_date']) : 0,
            'assignment_method'          => $assignment_method,
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
                        if( !empty( $topic_ids ) ){
                            foreach( $topic_ids as $topic_id){
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
            return redirect()->route('listSetWork', []);
        }
    }

    public function progress(Request $request, $id)
    {

        $assignmentObj = StudentAssignments::query()->where('id', $id)->where('status', '!=', 'inactive')->first();
        foreach( $assignmentObj->students as $assignmentTopicObj){
            //pre($assignmentTopicObj->count(), false);
        }

        if (empty($assignmentObj)) {
            abort(404);
        }

        $topics_response = array();

        $topic_ids = isset( $assignmentObj->topic_ids )? json_decode($assignmentObj->topic_ids) : array();
        if( !empty( $topic_ids )) {
            $topics_array = Quiz::whereIn('id', $topic_ids)->get();
            if( !empty( $topics_array ) ){
                foreach( $topics_array as $topicObj){
                    $topics_response[] = $topicObj->getTitleAttribute();
                }
            }
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
            'topics_response'   => $topics_response,
        ];

        return view(getTemplate() . '.panel.set_work.progress', $data);
    }

    public function remove(Request $request, $id)
    {

        $assignmentObj = StudentAssignments::query()->where('id', $id)->first();
        $completed_count = $assignmentObj->students->where('status', 'completed')->count();
        if( $completed_count == 0){
            $assignmentObj->update([
                'status' => 'inactive',
                'updated_at' => time(),
            ]);
            $assignedAssignments = UserAssignedTopics::query()->where('status', 'active')->where('student_assignment_id', $assignmentObj->id)->update([
                    'status' => 'inactive',
                    'updated_at' => time(),
                ]
            );
        }
        return redirect('/' . panelRoute() . '/set-work');
    }


}
