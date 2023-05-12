<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Reward;
use App\Models\RewardAccounting;
use App\Models\Role;
use App\Models\Translation\QuizTranslation;
use App\Models\WebinarChapter;
use App\Models\WebinarChapterItem;
use App\User;
use App\Models\Webinar;
use App\Models\QuizzesResult;
use App\Models\QuizzesQuestion;
use App\Models\QuizzesQuestionsAnswer;
use App\Models\QuizzResultQuestions;
use App\Models\QuizzAttempts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Translation\QuizzesQuestionTranslation;

class QuestionsBankController extends Controller {

    public function validation(Request $request) {
        $user = auth()->user();
        $question_id = $request->get('question_id');
        $qresult_id = $request->get('qresult_id');
        $qattempt_id = $request->get('qattempt_id');
        $time_consumed = $request->get('time_consumed');
        $questionObj = QuizzesQuestion::find($question_id);
        $QuizzResultQuestions = QuizzResultQuestions::find($qresult_id);
        $QuizzesResult = QuizzesResult::find($QuizzResultQuestions->quiz_result_id);
        $quizAttempt = QuizzAttempts::find($qattempt_id);
        
        $quiz = Quiz::find($questionObj->quiz_id);

        
        $elements_data = isset($questionObj->elements_data) ? json_decode($questionObj->elements_data) : array();
        $question_response_layout = '';
        $question_data = $request->get('question_data');
        $question_data = json_decode(base64_decode(trim(stripslashes($question_data))), true);
        $questions_data = isset($question_data[0]) ? $question_data[0] : $question_data;
        $incorrect_flag = false;
        $incorrect_array = $correct_array = $user_input_array = array();
        if (!empty($questions_data)) {
            foreach ($questions_data as $q_id => $user_input) {
                $current_question_obj = isset($elements_data->$q_id) ? $elements_data->$q_id : array();
                $question_type = isset($current_question_obj->type) ? $current_question_obj->type : '';
                $question_correct = isset($current_question_obj->correct_answere) ? $current_question_obj->correct_answere : '';
                $data_correct = isset($current_question_obj->{'data-correct'}) ? json_decode($current_question_obj->{'data-correct'}) : '';
                $question_correct = ($question_correct != '') ? $question_correct : $data_correct;
                $question_correct = is_array($question_correct) ? $question_correct : array($question_correct);
                $question_validate_response = $this->get_correct_answere($current_question_obj, $question_correct, $question_type, $user_input);
                $is_question_correct = isset($question_validate_response['is_question_correct']) ? $question_validate_response['is_question_correct'] : true;
                $question_correct = isset($question_validate_response['question_correct']) ? $question_validate_response['question_correct'] : true;
                $user_input = is_array($user_input) ? $user_input : array($user_input);
                if ($is_question_correct == false) {
                    $incorrect_array[$q_id]['correct'] = $question_correct;
                    $incorrect_array[$q_id]['user_input'] = $user_input;
                    $incorrect_flag = true;
                } else {
                    $correct_array[$q_id] = $question_correct;
                }
                $user_input_array[$q_id] = $user_input;
            }
        }

        if ($incorrect_flag == true) {
            $question_answer_status = 'incorrect';
        } else {
            $question_answer_status = 'correct';
        }
        $QuizzResultQuestions->update([
            'status' => $question_answer_status,
            'user_answer' => json_encode($user_input_array),
            'time_consumed' => $time_consumed,
        ]);
        createAttemptLog($quizAttempt->id, 'Answered question: #' . $QuizzResultQuestions->id, 'attempt', $QuizzResultQuestions->id);
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        //$questions_list = json_decode($QuizzesResult->questions_list);
            $questions_list = json_decode($quizAttempt->questions_list);

            $questions_ids_list = array();

            foreach ($questions_list as $key => $question_ids) {
                $questions_ids_list = array_merge($questions_ids_list, $question_ids);
            }


            $question = (object) array();
            $newQuestionResultData = (object) array();
            $j = 1;
            if (!empty($questions_ids_list)) {
                foreach ($questions_ids_list as $question_id) {
                    $questionObj = QuizzesQuestion::find($question_id);
                    
                    $quiz_settings = json_decode($quiz->quiz_settings);
                    $difficulty_level = $questionObj->question_difficulty_level;
                    $question_points = $quiz_settings->$difficulty_level->points;
                    
                    
                    $newQuestionResult = $this->get_question_result_data($questionObj, $questionObj->quiz_id, $qattempt_id);
                    if (!isset($newQuestionResult->id) || $newQuestionResult->id == '') {
                        $newQuestionResult = $this->store_question_result($questionObj, $QuizzesResult, $quizAttempt);
                        $question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($questionObj->question_layout)))));
                        $question_response_layout = '<div class="question-step question-step-' . $questionObj->id . '" data-qattempt="' . $qattempt_id . '" data-start_time="0" data-qresult="' . $newQuestionResult->id . '" data-quiz_result_id="' . $QuizzesResult->id . '">
                            <div class="question-layout-block">
                                            <div class="correct-appriciate" style="display:none"></div>
                                <form class="question-fields" action="javascript:;" data-question_id="' . $questionObj->id . '">
                                    <div class="left-content has-bg">
                                        <h2><span>Q ' . $j . '</span> - ' . $questionObj->question_title . ' <span class="icon-img"><img src="../../assets/default/img/quiz/sound-img.png" alt=""></span> </h2>
                                        <div id="leform-form-1" class="leform-form leform-elements leform-form-input-medium leform-form-icon-inside leform-form-description-bottom ui-sortable" _data-parent="1" _data-parent-col="0" style="display: block;">
                                            <div class="question-layout">
                                                <span class="marks" data-marks="' . $question_points . '">[' . $questionObj->question_score . ']</span>
                                                ' . $question_layout . '
                                            </div>
                                            <div class="form-btn">
                                                <input class="submit-btn" type="button" data-question_no="' . $j . '" value="Submit">
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>';

                        $question = $questionObj;
                        $newQuestionResultData = $newQuestionResult;
                        break;
                    }
                    $j++;
                }
            }
        
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
        
        
        
        if ($incorrect_flag == false) {

            
        } else {
            
            $questions_list = json_decode($quizAttempt->questions_list);
            $questions_ids_list = array();
            foreach( $questions_list as $key => $question_ids){
                $questions_ids_list = array_merge($questions_ids_list, $question_ids);
            }

            $question_difficulty_level = strtolower($questionObj->question_difficulty_level);
            $practice_question = QuizzesQuestion::where('quiz_id', $questionObj->quiz_id)
                    ->where('question_difficulty_level', $questionObj->question_difficulty_level)
                    ->whereNotIn('id', $questions_ids_list)
                    ->first();

            if( isset( $practice_question->id ) ){
                $questions_list->$question_difficulty_level = array_merge($questions_list->$question_difficulty_level, array($practice_question->id));
            }

            $quizAttempt->update([
                'questions_list' => json_encode($questions_list),
            ]);

            $QuizzesResult->update([
                'questions_list' => json_encode($questions_list),
            ]);
            
            $newQuestionResult = $this->store_question_result($questionObj, $QuizzesResult, $quizAttempt);
            $newQuestionResultData = $newQuestionResult;
            $question = $questionObj;
        }



        $response = array(
            'incorrect_array' => $incorrect_array,
            'correct_array' => $correct_array,
            'incorrect_flag' => $incorrect_flag,
            'question' => $question,
            'question_response_layout' => $question_response_layout,
            'newQuestionResultData' => $newQuestionResultData,
            'question_result_id' => isset($newQuestionResultData->id) ? $newQuestionResultData->id : '',
        );
        echo json_encode($response);
        exit;
    }

    public function store_question_result($questionObj, $newQuizStart, $quizAttempt) {
        $user = auth()->user();
        $newQuestionResult = QuizzResultQuestions::where('quiz_id', $newQuizStart->quiz_id)
                ->where('user_id', $user->id)
                ->where('question_id', $questionObj->id)
                ->where('status', 'waiting')
                ->first();
        if (!isset($newQuestionResult->id) || $newQuestionResult->id != '') {
            $correct_answers = $this->get_question_correct_answers($questionObj);

            $newQuestionResult = QuizzResultQuestions::create([
                        'quiz_id' => $newQuizStart->quiz_id,
                        'question_id' => $questionObj->id,
                        'quiz_result_id' => $newQuizStart->id,
                        'quiz_attempt_id' => $quizAttempt->id,
                        'user_id' => $user->id,
                        'correct_answer' => json_encode($correct_answers),
                        'user_answer' => '',
                        'quiz_layout' => $questionObj->question_layout,
                        'quiz_grade' => $questionObj->question_score,
                        'average_time' => $questionObj->question_average_time,
                        'time_consumed' => 0,
                        'difficulty_level' => $questionObj->question_difficulty_level,
                        'status' => 'waiting',
                        'created_at' => time()
            ]);
        } else {
            $newQuestionResult = $newQuestionResult->replicate();
            $newQuestionResult->update([
                'quiz_attempt_id' => $quizAttempt->id,
                'created_at' => time()
            ]);
        }

        createAttemptLog($quizAttempt->id, 'Viewed (and possibly read) question #' . $newQuestionResult->id, 'viewed', $newQuestionResult->id);

        return $newQuestionResult;
    }

    function get_correct_answere($current_question_obj, $question_correct, $question_type, $user_input) {
        $is_question_correct = true;
        if ($question_type == 'checkbox' || $question_type == 'radio') {
            $question_correct = array();
            $options_array = $current_question_obj->options;
            if (!empty($options_array)) {
                foreach ($options_array as $optionData) {
                    if ($optionData->default == 'on') {
                        $question_correct[] = $optionData->value;
                    }
                }
            }
            $is_question_correct = ($question_correct != $user_input) ? false : $is_question_correct;
        } else {

            if (!in_array($user_input, $question_correct)) {
                $is_question_correct = false;
            } else {
                $is_question_correct = true;
            }
        }
        $question_correct = is_array($question_correct) ? $question_correct : array($question_correct);
        return $response = array(
            'is_question_correct' => $is_question_correct,
            'question_correct' => $question_correct,
        );
    }

    public function test_complete(Request $request) {
        $quiz_user_data = $request->get('quiz_user_data');
        $quiz_result_id = $request->get('quiz_result_id');
        $attempt_id = $request->get('attempt_id');
        createAttemptLog($attempt_id, 'Session End', 'end');

        $QuizzesResult = QuizzesResult::find($quiz_result_id);

        $QuizzesResult->update([
            'status' => 'passed',
        ]);

        $quiz_user_data = json_decode(base64_decode(trim(stripslashes($quiz_user_data))), true);
        $quiz_user_data = isset($quiz_user_data[0]) ? $quiz_user_data[0] : $quiz_user_data;
        $attempted_questions = isset($quiz_user_data['attempt']) ? $quiz_user_data['attempt'] : array();
        $incorrect_questions = isset($quiz_user_data['incorrect']) ? $quiz_user_data['incorrect'] : array();
        $correct_questions = isset($quiz_user_data['correct']) ? $quiz_user_data['correct'] : array();
        $question_layout = '';
        if (!empty($attempted_questions)) {
            foreach ($attempted_questions as $question_id => $questionData) {
                //$question_layout .= $this->get_question_complete_layout($question_id, $questionData);
            }
        }

        if (!empty($incorrect_questions)) {
            $question_layout .= '<h2>Wrong Answer</h2>';
            foreach ($incorrect_questions as $question_id => $questionData) {
                $question_layout .= $this->get_question_complete_layout($question_id, $questionData);
            }
        }

        if (!empty($correct_questions)) {
            $question_layout .= '<br><br><h2>Correct Answer</h2>';
            foreach ($correct_questions as $question_id => $questionData) {
                $question_layout .= $this->get_question_complete_layout($question_id, $questionData);
            }
        }



        echo $question_layout;
        exit;
    }

    public function get_question_complete_layout($question_id, $questionData) {
        $questionData = isset($questionData[0]) ? $questionData[0] : $questionData;
        $questionObj = QuizzesQuestion::find($question_id);
        $elements_data = isset($questionObj->elements_data) ? json_decode($questionObj->elements_data) : array();
        $question_layout = '';
        $question_layout .= html_entity_decode(json_decode(base64_decode(trim(stripslashes($questionObj->question_layout)))));
        $user_input_response = '';
        $correct_answer_response = '';
        if (!empty($questionData)) {
            foreach ($questionData as $user_input_key => $user_input) {
                $current_question_obj = isset($elements_data->$user_input_key) ? $elements_data->$user_input_key : array();
                $question_type = isset($current_question_obj->type) ? $current_question_obj->type : '';
                $question_correct = isset($current_question_obj->correct_answere) ? $current_question_obj->correct_answere : '';
                $data_correct = isset($current_question_obj->{'data-correct'}) ? json_decode($current_question_obj->{'data-correct'}) : '';
                $question_correct = ($question_correct != '') ? $question_correct : $data_correct;
                $question_correct = is_array($question_correct) ? $question_correct : array($question_correct);

                $question_validate_response = $this->get_correct_answere($current_question_obj, $question_correct, $question_type, $user_input);
                $is_question_correct = isset($question_validate_response['is_question_correct']) ? $question_validate_response['is_question_correct'] : true;
                $correct_answers = isset($question_validate_response['question_correct']) ? $question_validate_response['question_correct'] : array();
                if (!empty($question_validate_response['question_correct'])) {
                    foreach ($correct_answers as $correct_answer) {
                        $correct_answer_response .= '<li><label class="lms-question-label" for="radio2"><span>' . $correct_answer . '</span></label></li>';
                    }
                }

                $label_class = ($is_question_correct == false) ? 'wrong' : 'correct';
                $user_input = is_array($user_input) ? $user_input : array($user_input);
                if (!empty($user_input)) {
                    foreach ($user_input as $user_input_data) {
                        $user_input_response .= '<li><label class="lms-question-label ' . $label_class . '" for="radio2"><span>' . $user_input_data . '</span></label></li>';
                    }
                }
            }
        }

        $question_layout .= '<div class="lms-radio-lists">
					<span class="list-title">Correct answer:</span>
					<ul class="lms-radio-btn-group lms-user-answer-block">' . $correct_answer_response . '</ul>
					<span class="list-title">You answered:</span>
					<ul class="lms-radio-btn-group lms-user-answer-block">' . $user_input_response . '</ul>
			</div><hr>';
        return $question_layout;
    }

    public function get_question_result_data($questionObj, $quiz_id, $qattempt_id) {
        $user = auth()->user();
        $newQuestionResult = QuizzResultQuestions::where('quiz_id', $quiz_id)
                ->where('user_id', $user->id)
                ->where('question_id', $questionObj->id)
                ->where('quiz_attempt_id', $qattempt_id)
                ->first();
        return $newQuestionResult;
    }

    /*
     * Get Question Correct Answers
     */

    public function get_question_correct_answers($questionObj) {
        $elements_data = isset($questionObj->elements_data) ? json_decode($questionObj->elements_data) : array();
        $correct_answers = array();
        if (!empty($elements_data)) {
            foreach ($elements_data as $field_key => $elementData) {
                if ($field_key > 0) {
                    $question_type = isset($elementData->type) ? $elementData->type : '';
                    $question_correct = isset($elementData->correct_answere) ? $elementData->correct_answere : '';
                    $data_correct = isset($elementData->{'data-correct'}) ? json_decode($elementData->{'data-correct'}) : '';
                    $question_correct = ($question_correct != '') ? $question_correct : $data_correct;
                    $question_correct = is_array($question_correct) ? $question_correct : array($question_correct);

                    if ($question_type == 'checkbox' || $question_type == 'radio') {
                        $question_correct = array();
                        $options_array = isset($elementData->options) ? $elementData->options : array();
                        if (!empty($options_array)) {
                            foreach ($options_array as $optionData) {
                                if ($optionData->default == 'on') {
                                    $question_correct[] = $optionData->value;
                                }
                            }
                        }
                    }
                    $correct_answers[$field_key] = $question_correct;
                }
            }
        }
        return $correct_answers;
    }

}
