<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\Models\Page;
use App\Models\Quiz;
use App\Models\QuizzesQuestion;
use App\Models\UserAssignedTopics;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Mail;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Facades\Session;

class TestsController extends Controller
{

    public function index()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        if (!auth()->user()->isUser()) {
            return redirect('/panel');
        }
        if( auth()->user()->id != 1133) {
            return view('web.default.panel.unauthorized_landing', array(
                'title'             => 'Unauthorized',
                'unauthorized_text' => 'You are not authorize for this page',
                'unauthorized_link' => '/panel',
            ));
        }
        $user = getUser();

        $switchUserObj = (object) array();
        if( $user->selected_user > 0) {
            $switchUserObj = User::find($user->selected_user);
        }

        $QuestionsAttemptController = new QuestionsAttemptController();

        $summary_type = 'sats';
        $QuizzResultQuestionsObj = $QuestionsAttemptController->prepare_graph_data($summary_type);

        $graphs_array = array();

        $start_date = strtotime('2023-09-20');
        $end_date = strtotime('2023-09-26');

        $custom_dates = array(
            'start' => $start_date,
            'end'   => $end_date,
        );

        $graphs_array['Custom'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'custom', $start_date, $end_date);

        $graphs_array['Year'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'yearly');
        $graphs_array['Month'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'monthly');
        $graphs_array['Week'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'weekly');
        $graphs_array['Day'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'daily');
        $graphs_array['Hour'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'hourly');

        $query = Quiz::where('status', Quiz::ACTIVE)->whereIn('quiz_type', array('sats','11plus','cat4','iseb','independence_exams'))->with('quizQuestionsList');
        if (auth()->check() && auth()->user()->isUser()) {
            $query->where('year_id', $user->year_id);
        }
        $sats = $query->paginate(100);

        $parent_assignedArray = UserAssignedTopics::where('assigned_by_id', $user->id)->where('status', 'active')->select('id', 'assigned_by_id', 'topic_id', 'assigned_to_id', 'deadline_date')->get()->toArray();
        $parent_assigned_list = array();
        if (!empty($parent_assignedArray)) {
            foreach ($parent_assignedArray as $parent_assignedObj) {
                $topic_id = isset($parent_assignedObj['topic_id']) ? $parent_assignedObj['topic_id'] : 0;
                $assigned_to_id = isset($parent_assignedObj['assigned_to_id']) ? $parent_assignedObj['assigned_to_id'] : 0;
                $deadline_date = isset($parent_assignedObj['deadline_date']) ? $parent_assignedObj['deadline_date'] : 0;
                $parent_assigned_list[$topic_id][$assigned_to_id] = $parent_assignedObj;
                $parent_assigned_list[$topic_id]['deadline_date'] = $deadline_date;
            }
        }

        $childs = array();
        
        if (auth()->check() && auth()->user()->isParent()) {
            $childs = User::where('role_id', 1)
                ->where('parent_type', 'parent')
                ->where('parent_id', $user->id)
                ->where('status', 'active')
                ->get();
        }
        
        if (auth()->check() && auth()->user()->isTeacher()) {
            $childs = User::where('role_id', 1)
                ->where('parent_type', 'teacher')
                ->where('parent_id', $user->id)
                ->where('status', 'active')
                ->get();
        }

        $QuestionsAttemptController = new QuestionsAttemptController();

        if (!empty($sats)) {
            $data = [
                'pageTitle'                  => 'Tests',
                'sats'                       => $sats,
                'QuestionsAttemptController' => $QuestionsAttemptController,
                'childs'                     => $childs,
                'switchUserObj'              => $switchUserObj,
                'parent_assigned_list'       => $parent_assigned_list,
                'graphs_array'               => $graphs_array,
                'summary_type'               => $summary_type,
                'custom_dates'               => $custom_dates,
            ];
            return view('web.default.tests.index', $data);
        }

        abort(404);
    }

    public function search_tests(Request $request)
    {
        $user = getUser();
        $QuestionsAttemptController = new QuestionsAttemptController();
        $counter = 0;
        $search_keyword = $request->get('search_keyword', '');
        $quiz_type = $request->get('quiz_type', '');

        $switch_user = $user->selected_user;


        $query = Quiz::where('status', Quiz::ACTIVE);
        if ($quiz_type != '' && $quiz_type != 'all') {
            $query->where('quiz_type', $quiz_type);
        }else{
            $query-> whereIn('quiz_type', array('sats','11plus','cat4','iseb','independence_exams'));
        }
        $query->with('quizQuestionsList');
        if ($search_keyword != '') {
            $query->whereTranslationLike('title', '%' . $search_keyword . '%')->orWhere('quiz_type', 'like', "%$search_keyword%");
        }

        if( $switch_user > 0){
            $switchUserObj = User::find($switch_user);
            $query->where('year_id', $switchUserObj->year_id);
        }
        if (auth()->check() && auth()->user()->isUser()) {
            $query->where('year_id', $user->year_id);
        }


        $tests = $query->paginate(100);

        $response_layout = '';
        if (!empty($tests)) {
            foreach ($tests as $rowObj) {
                $response_layout .= view('web.default.tests.single_item', [
                    'rowObj'                     => $rowObj,
                    'QuestionsAttemptController' => $QuestionsAttemptController,
                    'counter'                    => $counter
                ])->render();
            }
        }

        $response_layout .= '<script>$(".total-tests").html("Total Tests: '.$tests->count().'")</script>';
        echo $response_layout;
        exit;

    }

    public function switch_user(Request $request)
    {
        $user = getUser();
        $switch_user = $request->get('switch_user', '');
        $user->update(['selected_user' => $switch_user]);
        exit;

    }


    public function custom_html(Request $request)
    {
        $data = [
            'pageTitle'                  => 'Custom HTML',
        ];
        return view('web.default.custom_html.index', $data);

    }


}
