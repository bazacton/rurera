<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class ElevenplusController extends Controller
{

    public function index()
    {

        $query = Quiz::where('status', Quiz::ACTIVE)->where('quiz_type', '11plus');
        $elevenPlus = $query->paginate(8);

        //pre($sats);

        $QuestionsAttemptController = new QuestionsAttemptController();

        if (!empty($elevenPlus)) {
            $data = [
                'pageTitle'                  => '11 Plus',
                'data'                       => $elevenPlus,
                'QuestionsAttemptController' => $QuestionsAttemptController
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
