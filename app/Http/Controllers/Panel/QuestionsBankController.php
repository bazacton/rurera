<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Reward;
use App\Models\RewardAccounting;
use App\Models\Role;
use App\Models\Translation\QuizTranslation;
use App\Http\Controllers\Web\QuestionsAttemptController;
use App\Models\WebinarChapter;
use App\Models\WebinarChapterItem;
use App\User;
use App\Models\Webinar;
use App\Models\QuizzesResult;
use App\Models\QuizzesQuestion;
use App\Models\QuizzesQuestionsAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Translation\QuizzesQuestionTranslation;

class QuestionsBankController extends Controller {

    public function start(Request $request, $id) {
        $question = QuizzesQuestion::where('id', $id)->first();
		$QuestionsAttemptController = new QuestionsAttemptController();
		
		//$question_layout = $QuestionsAttemptController->get_question_layout($question);
		//pre($question_layout);
        $quiz = Quiz::find($question->quiz_id);
		
		$layout_elements = json_decode($question->layout_elements);

        if ($question) {
            $data = [
                'pageTitle' => trans('quiz.quiz_start'),
                'question' => $question,
                'QuestionsAttemptController' => $QuestionsAttemptController,
                'quiz' => $quiz
            ];
            return view(getTemplate() . '.panel.questions.start', $data);
        }
        abort(404);
    }

    public function fail(Request $request, $id) {
        $question = QuizzesQuestion::where('id', $id)->first();

        if ($question) {
            $data = [
                'pageTitle' => 'Fail',
                'question' => $question
            ];
            return view(getTemplate() . '.panel.questions.fail', $data);
        }
        abort(404);
    }

}
