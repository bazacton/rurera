<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\Models\Quiz;
use App\Models\UserAssignedTopics;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class SatsController extends Controller
{

    public function sats_landing()
    {
        $data = [
            'pageTitle'                  => 'SATs',
        ];
        return view('web.default.sats.sats_landing', $data);

        abort(404);
    }

    public function index()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();

        $query = Quiz::where('status', Quiz::ACTIVE)->where('quiz_type', 'sats');
        $sats = $query->paginate(100);

        $parent_assignedArray = UserAssignedTopics::where('parent_id', $user->id)->where('status', 'active')->select('id', 'parent_id', 'topic_id', 'assigned_to_id')->get()->toArray();
        $parent_assigned_list = array();
        if (!empty($parent_assignedArray)) {
            foreach ($parent_assignedArray as $parent_assignedObj) {
                $topic_id = isset($parent_assignedObj['topic_id']) ? $parent_assignedObj['topic_id'] : 0;
                $assigned_to_id = isset($parent_assignedObj['assigned_to_id']) ? $parent_assignedObj['assigned_to_id'] : 0;
                $parent_assigned_list[$topic_id][$assigned_to_id] = $parent_assignedObj;
            }
        }

        $childs = array();
        if (auth()->user()->isParent()) {
            $childs = User::where('role_id', 1)
                ->where('parent_type', 'parent')
                ->where('parent_id', $user->id)
                ->where('status', 'active')
                ->get();
        }

        $QuestionsAttemptController = new QuestionsAttemptController();

        if (!empty($sats)) {
            $data = [
                'pageTitle'                  => 'SATs',
                'sats'                       => $sats,
                'QuestionsAttemptController' => $QuestionsAttemptController,
                'childs'                     => $childs,
                'parent_assigned_list'       => $parent_assigned_list,
            ];
            return view('web.default.sats.index', $data);
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
        if (!auth()->subscription('sats')) {
            return view('web.default.quizzes.not_subscribed');
        }
        //$quiz = Quiz::find($id);
        $quiz = Quiz::where('quiz_slug', $quiz_slug)->first();
        $id = $quiz->id;

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
