<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\Models\Quiz;
use App\Models\UserAssignedTopics;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class AssignmentController extends Controller
{
    /*
     * Start SAT Quiz
     */
    public function start(Request $request, $quiz_slug)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        //$quiz = Quiz::find($id);
        $quiz = Quiz::where('quiz_slug', $quiz_slug)->first();
        $id = $quiz->id;
        if (!auth()->assginment('assignment', $id)) {
            //return view('web.default.quizzes.not_subscribed');
        }

        $QuestionsAttemptController = new QuestionsAttemptController();
        $started_already = $QuestionsAttemptController->started_already($id);

        //$started_already = false;
        if ($started_already == true) {
            $data = [
                'pageTitle'  => 'Start',
                'quiz'       => $quiz,
            ];
            return view('web.default.quizzes.auto_load', $data);
            //$QuizController = new QuizController();
            //return $QuizController->start($request, $id);
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
