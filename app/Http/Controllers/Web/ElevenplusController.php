<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\Models\Quiz;
use App\Models\UserAssignedTopics;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class ElevenplusController extends Controller
{

    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();

        $year_group = $request->get('year_group', null);
        $subject = $request->get('subject', null);
        $examp_board = $request->get('examp_board', null);

        $query = Quiz::with(['quizQuestionsList'])->where('status', Quiz::ACTIVE)->where('quiz_type', '11plus');


        $parent_assignedArray = UserAssignedTopics::where('parent_id', $user->id)->where('status', 'active')->select('id', 'parent_id', 'topic_id', 'assigned_to_id')->get()->toArray();

        $parent_assigned_list = array();
        if (!empty($parent_assignedArray)) {
            foreach ($parent_assignedArray as $parent_assignedObj) {
                $topic_id = isset($parent_assignedObj['topic_id']) ? $parent_assignedObj['topic_id'] : 0;
                $assigned_to_id = isset($parent_assignedObj['assigned_to_id']) ? $parent_assignedObj['assigned_to_id'] : 0;
                $parent_assigned_list[$topic_id][$assigned_to_id] = $parent_assignedObj;
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

        $elevenPlus = $query->paginate(100);

        $QuestionsAttemptController = new QuestionsAttemptController();
        $childs = array();
        if (auth()->user()->isParent()) {
            $childs = User::where('role_id', 1)
                ->where('parent_type', 'parent')
                ->where('parent_id', $user->id)
                ->where('status', 'active')
                ->get();
        }

        if (!empty($elevenPlus)) {
            $data = [
                'pageTitle'                  => '11 Plus',
                'data'                       => $elevenPlus,
                'QuestionsAttemptController' => $QuestionsAttemptController,
                'childs'                     => $childs,
                'parent_assigned_list'       => $parent_assigned_list,
            ];
            return view('web.default.11plus.index', $data);
        }

        abort(404);
    }

    /*
     * Start SAT Quiz
     */
    public function start(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (!auth()->subscription('11plus')) {
            return view('web.default.quizzes.not_subscribed');
        }
        $quiz = Quiz::find($id);

        $QuestionsAttemptController = new QuestionsAttemptController();
        $started_already = $QuestionsAttemptController->started_already($id);

        $started_already = false;
        if ($started_already == true) {
            $QuizController = new QuizController();
            return $QuizController->start($request, $id);
        } else {
            $resultData = $QuestionsAttemptController->get_result_data($id);
            $resultData = $QuestionsAttemptController->prepare_result_array($resultData);
            $is_passed = isset($resultData->is_passed) ? $resultData->is_passed : false;
            $in_progress = isset($resultData->in_progress) ? $resultData->in_progress : false;
            $current_status = isset($resultData->current_status) ? $resultData->current_status : '';
            $data = [
                'pageTitle'  => 'Start',
                'quiz'       => $quiz,
                'resultData' => $resultData
            ];
            return view('web.default.quizzes.start', $data);
        }
    }


}
