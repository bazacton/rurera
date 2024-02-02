<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\Models\Quiz;
use App\Models\UserAssignedTopics;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class IsebController extends Controller
{

    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();
        $QuestionsAttemptController = new QuestionsAttemptController();
        $summary_type = 'iseb';
        $QuizzResultQuestionsObj = $QuestionsAttemptController->prepare_graph_data($summary_type);

        $graphs_array = array();

        $start_date = strtotime('2023-09-20');
        $end_date = strtotime('2023-09-26');

        $custom_dates = array(
            'start' => $start_date,
            'end' => $end_date,
        );

        $graphs_array['Custom'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'custom', $start_date, $end_date);

        $graphs_array['Year'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'yearly');
        $graphs_array['Month'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'monthly');
        $graphs_array['Week'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'weekly');
        $graphs_array['Day'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'daily');
        $graphs_array['Hour'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'hourly');


        $year_group = $request->get('year_group', null);
        $subject = $request->get('subject', null);
        $examp_board = $request->get('examp_board', null);

        $query = Quiz::with(['quizQuestionsList'])->where('status', Quiz::ACTIVE)->where('quiz_type', 'iseb');


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


        if (!empty($year_group) and $year_group !== 'All') {
            $query->where('year_group', $year_group);
        }

        if (!empty($subject) and $subject !== 'All') {
            $query->where('subject', $subject);
        }

        if (!empty($examp_board) and $examp_board !== 'All') {
            $query->where('examp_board', $examp_board);
        }

        $isebData = $query->paginate(100);


        $childs = array();
        if (auth()->user()->isParent()) {
            $childs = User::where('role_id', 1)
                ->where('parent_type', 'parent')
                ->where('parent_id', $user->id)
                ->where('status', 'active')
                ->get();
        }

        if (auth()->user()->isTeacher()) {
            $childs = User::where('role_id', 1)
                ->where('parent_type', 'teacher')
                ->where('parent_id', $user->id)
                ->where('status', 'active')
                ->get();
        }

        if (!empty($isebData)) {
            $data = [
                'pageTitle'                  => 'ISEB',
                'data'                       => $isebData,
                'QuestionsAttemptController' => $QuestionsAttemptController,
                'childs'                     => $childs,
                'parent_assigned_list'       => $parent_assigned_list,
                'graphs_array'               => $graphs_array,
                'summary_type'               => $summary_type,
                'custom_dates' => $custom_dates,
            ];
            return view('web.default.iseb.index', $data);
        }

        abort(404);
    }

    /*
     * Start SAT Quiz
     */
    public function start(Request $request, $quiz_slug)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (!auth()->subscription('11plus')) {
            return view('web.default.quizzes.not_subscribed');
        }
        $quiz = Quiz::where('quiz_slug', $quiz_slug)->first();
        $id = $quiz->id;
        //$quiz = Quiz::find($id);

        $QuestionsAttemptController = new QuestionsAttemptController();
        //$started_already = $QuestionsAttemptController->started_already($id);

        $started_already = false;
        if ($started_already == true) {
            $data = [
                'pageTitle'  => 'Start',
                'quiz'       => $quiz,
            ];
            return view('web.default.quizzes.auto_load', $data);
            //$QuizController = new QuizController();
            //return $QuizController->start($request, $id);
        } else {
            //$resultData = $QuestionsAttemptController->get_result_data($id);
            //$resultData = $QuestionsAttemptController->prepare_result_array($resultData);
            //$is_passed = isset($resultData->is_passed) ? $resultData->is_passed : false;
            //$in_progress = isset($resultData->in_progress) ? $resultData->in_progress : false;
            //$current_status = isset($resultData->current_status) ? $resultData->current_status : '';
            $resultData = array();
            $data = [
                'pageTitle'  => 'Start',
                'quiz'       => $quiz,
                'resultData' => $resultData
            ];
            return view('web.default.quizzes.start', $data);
        }
    }


}
