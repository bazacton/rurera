<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class ElevenplusController extends Controller
{

    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $year_group = $request->get('year_group', null);
        $subject = $request->get('subject', null);
        $examp_board = $request->get('examp_board', null);

        $query = Quiz::with(['quizQuestionsList'])->where('status', Quiz::ACTIVE)->where('quiz_type', '11plus');

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
        if (!auth()->check()) {
            return redirect('/login');
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
