<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\User;
use App\Models\QuizzesResult;
use App\Models\QuizzesQuestion;
use App\Models\QuizzesQuestionsAnswer;
use App\Models\QuizzResultQuestions;
use App\Models\QuizzAttempts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Translation\QuizzesQuestionTranslation;

class QuestionsAttemptController extends Controller
{

    /*
     * Create Question Result Log For Attempting
     *
     * @params Array
     * item @ parent_type_id
     * item @ quiz_result_type
     * item @ questions_list [Array]
     *
     * @return Result Data Object
     */
    public function createResultLog($params)
    {
        $user = auth()->user();

        $parent_type_id = isset($params['parent_type_id']) ? $params['parent_type_id'] : 0;
        $quiz_result_type = isset($params['quiz_result_type']) ? $params['quiz_result_type'] : 0;
        $questions_list = isset($params['questions_list']) ? $params['questions_list'] : array();
        $no_of_attempts = isset($params['no_of_attempts']) ? $params['no_of_attempts'] : 0;


        $newQuizStart = QuizzesResult::where('parent_type_id', $parent_type_id)->where('quiz_result_type', $quiz_result_type)->where('user_id', $user->id)->where('status', 'waiting')->first();

        if (empty($newQuizStart) || !isset($newQuizStart->id) || $newQuizStart->count() < 1) {
            $newQuizStart = QuizzesResult::create([
                'user_id'          => $user->id,
                'results'          => '',
                'user_grade'       => 0,
                'status'           => 'waiting',
                'created_at'       => time(),
                'questions_list'   => json_encode($questions_list),
                'parent_type_id'   => $parent_type_id,
                'quiz_result_type' => $quiz_result_type,
                'no_of_attempts'   => $no_of_attempts,
            ]);
        }

        return $newQuizStart;
    }


    /*
     * Create Question Attempt Log For Attempting
     *
     * @$newQuizStart Object
     *
     * @return Attempt Data Object
     */
    public function createAttemptLog($newQuizStart)
    {
        $user = auth()->user();
        $quizAttempt = QuizzAttempts::create([
            'quiz_result_id' => $newQuizStart->id,
            'user_id'        => $user->id,
            'start_grade'    => $newQuizStart->user_grade,
            'end_grade'      => 0,
            'created_at'     => time(),
            'questions_list' => $newQuizStart->questions_list,
            'parent_type_id' => $newQuizStart->parent_type_id,
            'attempt_type'   => $newQuizStart->quiz_result_type,
        ]);
        return $quizAttempt;
    }


    /*
    * Get Next Question to Attempt
    *
    * @$quizAttempt Object
    *
    * @return Question Object
    */
    public function nextQuestion($quizAttempt, $exclude_array = array(), $jump_question_id = 0)
    {
        $user = auth()->user();
        $questions_list = ($quizAttempt->questions_list != '') ? json_decode($quizAttempt->questions_list) : array();

        $questions_list = $this->get_questions_list($questions_list, $quizAttempt);

        $QuizzesResult = QuizzesResult::find($quizAttempt->quiz_result_id);
        $question_no = $next_question = $prev_question = 0;
        $questionAttemptAllowed = false;

        $questionObj = $newQuestionResult = array();
        if (!empty($questions_list)) {
            foreach ($questions_list as $question_count => $question_id) {
                $question_count++;
                if (!in_array($question_id, $exclude_array)) {

                    if ($jump_question_id == 0 || $jump_question_id == $question_id) {

                        $check_question_passed = QuizzResultQuestions::where('parent_type_id', $quizAttempt->parent_type_id)->where('quiz_result_type', $quizAttempt->attempt_type)->where('user_id', $user->id)->where('question_id', $question_id)->where('quiz_result_id', $quizAttempt->quiz_result_id)->where('status', '=', 'correct')->count();

                        if ($check_question_passed == 0) {
                            $QuizzResultQuestionsCount = QuizzResultQuestions::where('parent_type_id', $quizAttempt->parent_type_id)->where('quiz_result_type', $quizAttempt->attempt_type)->where('user_id', $user->id)->where('question_id', $question_id)->where('quiz_result_id', $quizAttempt->quiz_result_id)->where('status', '!=', 'waiting')->count();

                            $questionAttemptAllowed = $this->question_attempt_allowed($QuizzesResult, $QuizzResultQuestionsCount);

                            $questionObj = QuizzesQuestion::find($question_id);
                            if ($questionAttemptAllowed == true) {
                                $question_no = $question_count;
                                $prev_question = isset($questions_list[$question_count - 2]) ? $questions_list[$question_count - 2] : 0;
                                $next_question = isset($questions_list[$question_count]) ? $questions_list[$question_count] : 0;
                                $correct_answers = $this->get_question_correct_answers($questionObj);

                                $newQuestionResult = QuizzResultQuestions::create([
                                    'question_id'      => $questionObj->id,
                                    'quiz_result_id'   => $quizAttempt->quiz_result_id,
                                    'quiz_attempt_id'  => $quizAttempt->id,
                                    'user_id'          => $user->id,
                                    'correct_answer'   => json_encode($correct_answers),
                                    'user_answer'      => '',
                                    'quiz_layout'      => $questionObj->question_layout,
                                    'quiz_grade'       => $questionObj->question_score,
                                    'average_time'     => $questionObj->question_average_time,
                                    'time_consumed'    => 0,
                                    'difficulty_level' => $questionObj->question_difficulty_level,
                                    'status'           => 'waiting',
                                    'created_at'       => time(),
                                    'parent_type_id'   => $quizAttempt->parent_type_id,
                                    'quiz_result_type' => $quizAttempt->attempt_type,
                                    'review_required' => $questionObj->review_required,
                                ]);

                                break;
                            } else {
                                $newQuestionResult = QuizzResultQuestions::where('quiz_result_id', $quizAttempt->quiz_result_id)->where('question_id', $questionObj->id)->where('status', '!=', 'waiting')->first();
                            }
                        }
                    }

                }
            }
        }

        return array(
            'questionObj'       => $questionObj,
            'question_no'       => $question_no,
            'newQuestionResult' => $newQuestionResult,
            'prev_question'     => $prev_question,
            'next_question'     => $next_question,
            'QuizzesResult'     => $QuizzesResult,
            'AttemptAllowed'    => $questionAttemptAllowed,
        );

    }


    /*
     * Get Questions LIst
     */

    public function get_questions_list($questions_list, $quizAttempt)
    {

        $questions_list_return = array();
        switch ($quizAttempt->attempt_type) {

            case "practice":
                if (!empty($questions_list)) {
                    foreach ($questions_list as $questions_list_label => $questions_list_value_array) {
                        if (!empty($questions_list_value_array) && is_array($questions_list_value_array)) {
                            foreach ($questions_list_value_array as $questions_list_value) {
                                $questions_list_return[] = $questions_list_value;
                            }
                        }
                    }
                }
                break;

            default:
                $questions_list_return = $questions_list;
                break;
        }

        return $questions_list_return;
    }

    /*
     *
     * Check if question attempt is allowed
     */
    public function question_attempt_allowed($QuizzesResult, $QuizzResultQuestionsCount)
    {

        $is_attempt_allowed = false;
        switch ($QuizzesResult->quiz_result_type) {

            case "book_page":

                if (($QuizzResultQuestionsCount < $QuizzesResult->no_of_attempts) || ($QuizzesResult->no_of_attempts == 0)) {
                    $is_attempt_allowed = true;
                }

                break;

            case "assessment":
                $is_attempt_allowed = true;
                break;

            case "sats":
                if ($QuizzResultQuestionsCount == 0) {
                    $is_attempt_allowed = true;
                }
                break;

            case "practice":

                if ($QuizzResultQuestionsCount == 0) {
                    $is_attempt_allowed = true;
                }
                break;
        }

        return $is_attempt_allowed;
    }

    /*
    	* Get Question Correct Answers
    	*/
    public function get_question_correct_answers($questionObj)
    {
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
                                if (isset($optionData->default) && $optionData->default == 'on') {
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

    /*
     * Question Validation on Attempt
     *
     * @params Array
     *
     * @return Next Question ( along with layout )
     */
    public function validation(Request $request)
    {
        $user = auth()->user();
        $question_id = $request->get('question_id');
        $qresult_id = $request->get('qresult_id');
        $qattempt_id = $request->get('qattempt_id');
        $time_consumed = $request->get('time_consumed');
        $user_question_layout = $request->get('user_question_layout');


        $questionObj = QuizzesQuestion::find($question_id);
        $QuizzResultQuestions = QuizzResultQuestions::find($qresult_id);
        $QuizzesResult = QuizzesResult::find($QuizzResultQuestions->quiz_result_id);
        $quizAttempt = QuizzAttempts::find($qattempt_id);

        $review_required = $questionObj->review_required;
        $review_required = ( $review_required == 1)? true : false;

        $attempt_type = $quizAttempt->attempt_type;


        $elements_data = isset($questionObj->elements_data) ? json_decode($questionObj->elements_data) : array();
        $question_response_layout = '';
        $question_data = $request->get('question_data');
        $question_data = json_decode(base64_decode(trim(stripslashes($question_data))), true);

        $questions_data = isset($question_data[0]) ? $question_data[0] : $question_data;

        $field_type = isset($questions_data['type']) ? $questions_data['type'] : '';
        if ($field_type == 'insert_into_sentense') {
            //pre('test');
        }
        $incorrect_flag = false;
        $show_fail_message = true;

        if ($quizAttempt->attempt_type == 'sats') {
            $show_fail_message = false;
        }

        $incorrect_array = $correct_array = $user_input_array = array();
        if (!empty($questions_data)) {
            foreach ($questions_data as $q_id => $user_input) {

                $current_question_obj = isset($elements_data->$q_id) ? $elements_data->$q_id : array();
                $question_type = isset($current_question_obj->type) ? $current_question_obj->type : '';
                $question_correct = isset($current_question_obj->correct_answere) ? $current_question_obj->correct_answere : '';
                $data_correct = isset($current_question_obj->{'data-correct'}) ? json_decode($current_question_obj->{'data-correct'}) : '';
                $question_correct = ($question_correct != '') ? $question_correct : $data_correct;
                $question_correct = is_array($question_correct) ? $question_correct : array($question_correct);
                $question_validate_response = $this->validate_correct_answere($current_question_obj, $question_correct, $question_type, $user_input);
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

        $question_answer_status = ($review_required == true)? 'in_review' : $question_answer_status;

        $QuizzResultQuestions->update([
            'status'               => $question_answer_status,
            'user_answer'          => json_encode($user_input_array),
            'time_consumed'        => ($time_consumed > 0) ? $time_consumed : 0,
            'user_question_layout' => $user_question_layout
        ]);
        createAttemptLog($quizAttempt->id, 'Answered question: #' . $QuizzResultQuestions->id, 'attempt', $QuizzResultQuestions->id);

        $questions_list = json_decode($quizAttempt->questions_list);


        $QuestionsAttemptController = new QuestionsAttemptController();

        $resultLogObj = $QuestionsAttemptController->createResultLog([
            'parent_type_id'   => $quizAttempt->parent_type_id,
            'quiz_result_type' => $quizAttempt->attempt_type,
            'questions_list'   => $questions_list,
        ]);

        $attemptLogObj = $quizAttempt;
        $attempt_log_id = createAttemptLog($attemptLogObj->id, 'Session Started', 'started');
        $nextQuestionArray = $QuestionsAttemptController->nextQuestion($attemptLogObj);
        $questionObj = isset($nextQuestionArray['questionObj']) ? $nextQuestionArray['questionObj'] : (object)array();
        $question_no = isset($nextQuestionArray['question_no']) ? $nextQuestionArray['question_no'] : 0;
        $prev_question = isset($nextQuestionArray['prev_question']) ? $nextQuestionArray['prev_question'] : 0;
        $next_question = isset($nextQuestionArray['next_question']) ? $nextQuestionArray['next_question'] : 0;
        $newQuestionResult = isset($nextQuestionArray['newQuestionResult']) ? $nextQuestionArray['newQuestionResult'] : (object)array();
        $QuizzesResult = isset($nextQuestionArray['QuizzesResult']) ? $nextQuestionArray['QuizzesResult'] : (object)array();


        if ($incorrect_flag == false || $show_fail_message == false) {

            if (isset($questionObj->id)) {
                $question_response_layout = view('web.default.panel.questions.question_layout', [
                    'question'          => $questionObj,
                    'prev_question'     => $prev_question,
                    'next_question'     => $next_question,
                    'quizAttempt'       => $quizAttempt,
                    'newQuestionResult' => $newQuestionResult,
                    'question_no'       => $question_no,
                    'quizResultObj'     => $QuizzesResult
                ])->render();
            }

        } else {
            if (isset($questionObj->id)) {

                $questions_list = json_decode($quizAttempt->questions_list);
                $questions_ids_list = $questions_list;


                if ($quizAttempt->attempt_type == 'practice') {
                    $questions_ids_list = array();
                    foreach ($questions_list as $key => $question_ids) {
                        $questions_ids_list = array_merge($questions_ids_list, $question_ids);
                    }
                }

                $question_difficulty_level = strtolower($questionObj->question_difficulty_level);
                if ($quizAttempt->attempt_type == 'practice') {

                    $practice_question = QuizzesQuestion::where('quiz_id', $questionObj->quiz_id)->where('question_difficulty_level', $questionObj->question_difficulty_level)->whereNotIn('id', $questions_ids_list)->first();

                    if (isset($practice_question->id)) {
                        $questions_list->$question_difficulty_level = array_merge($questions_list->$question_difficulty_level, array($practice_question->id));
                    }
                    $quizAttempt->update(['questions_list' => json_encode($questions_list),]);
                    $QuizzesResult->update(['questions_list' => json_encode($questions_list),]);

                }

                $question_response_layout = view('web.default.panel.questions.question_layout', [
                    'question'          => $questionObj,
                    'prev_question'     => $prev_question,
                    'next_question'     => $next_question,
                    'quizAttempt'       => $quizAttempt,
                    'newQuestionResult' => $newQuestionResult,
                    'question_no'       => $question_no,
                    'quizResultObj'     => $QuizzesResult
                ])->render();

            }
        }
        $question = $questionObj;


        $response = array(
            'show_fail_message'        => $show_fail_message,
            'incorrect_array'          => $incorrect_array,
            'correct_array'            => $correct_array,
            'incorrect_flag'           => $incorrect_flag,
            'question'                 => $question,
            'question_response_layout' => $question_response_layout,
            'newQuestionResult'        => $newQuestionResult,
            'question_result_id'       => isset($newQuestionResult->id) ? $newQuestionResult->id : '',
        );
        echo json_encode($response);
        exit;
    }

    function validate_correct_answere($current_question_obj, $question_correct, $question_type, $user_input)
    {
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

            if ($question_type == 'paragraph') {
                $user_input = strip_tags($user_input);
                $user_input = str_replace('&nbsp;', '', $user_input);
            }

            if (!in_array($user_input, $question_correct)) {
                $is_question_correct = false;
            } else {
                $is_question_correct = true;
            }
        }
        $question_correct = is_array($question_correct) ? $question_correct : array($question_correct);

        return $response = array(
            'is_question_correct' => $is_question_correct,
            'question_correct'    => $question_correct,
        );
    }


    public function test_complete(Request $request)
    {
        $quiz_user_data = $request->get('quiz_user_data');
        $question_result_id = $request->get('question_result_id');
        $attempt_id = $request->get('attempt_id');
        $quizAttempt = QuizzAttempts::find($attempt_id);
        createAttemptLog($attempt_id, 'Session End', 'end');
        $QuizzesResult = QuizzesResult::find($quizAttempt->quiz_result_id);
        $QuizzesResult->update(['status' => 'passed',]);

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

    public function get_question_complete_layout($question_id, $questionData)
    {
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

                $question_validate_response = $this->validate_correct_answere($current_question_obj, $question_correct, $question_type, $user_input);
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

    /*
         * GET Result Data
         */
    public function get_result_data($parent_id, $q_result_id = 0)
    {
        $user = auth()->user();
        if( !isset( $user->id)){
            return array();
        }

        $userQuizDone = QuizzesResult::where('parent_type_id', $parent_id)->with([
            'attempts' => function ($query) {
                $query->with('quizz_result_questions');
            }
        ])->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();


        $result_status = '';
        $resultCount = $resultsData = array();
        $is_passed = $in_progress = false;
        $current_status = '';
        if (!empty($userQuizDone)) {
            foreach ($userQuizDone as $userQuizObj) {

                if ($q_result_id > 0 && $userQuizObj->id != $q_result_id) {
                    return;
                }

                if ($userQuizObj->status == 'waiting') {
                    $in_progress = true;
                }

                if ($userQuizObj->status == 'passed') {
                    $is_passed = true;
                }

                $resultsData[$userQuizObj->id]['resultObjData'] = $userQuizObj;
                $resultCount[$userQuizObj->id]['waiting'] = 0;
                $resultCount[$userQuizObj->id]['incorrect'] = 0;
                $resultCount[$userQuizObj->id]['correct'] = 0;
                if (!empty($userQuizObj->attempts)) {
                    foreach ($userQuizObj->attempts as $attemptObj) {
                        $resultCount[$userQuizObj->id]['waiting'] += $attemptObj->quizz_result_questions->where('status', 'waiting')->count();
                        $resultCount[$userQuizObj->id]['incorrect'] += $attemptObj->quizz_result_questions->where('status', 'incorrect')->count();
                        $resultCount[$userQuizObj->id]['correct'] += $attemptObj->quizz_result_questions->where('status', 'correct')->count();

                    }
                }
            }
        }

        $current_status = ($in_progress == true) ? 'waiting' : $current_status;
        $current_status = ($is_passed == true) ? 'passed' : $current_status;
        $response = (object)array(
            'resultsObj'     => $userQuizDone,
            'resultsData'    => $resultsData,
            'resultCount'    => $resultCount,
            'is_passed'      => $is_passed,
            'in_progress'    => $in_progress,
            'current_status' => $current_status
        );

        return $response;
    }

    /*
     * Check if Started Already
     */
    public function started_already($parent_id)
    {
        $user = auth()->user();
        $QuizzesResult = QuizzesResult::where('parent_type_id', $parent_id)->where('user_id', $user->id)->where('status', 'waiting')->first();
        return (isset($QuizzesResult->id)) ? true : false;
    }


    /*
     * Flagg a Question
     */
    public function flag_question(Request $request)
    {
        $user = auth()->user();
        $question_id = $request->get('question_id');
        $qresult_id = $request->get('qresult_id');
        $flag_type = $request->get('flag_type');
        $QuizzesResult = QuizzesResult::find($qresult_id);
        if ($user->id != $QuizzesResult->user_id) {
            return;
        }
        $already_flagged = ($QuizzesResult->flagged_questions != '') ? json_decode($QuizzesResult->flagged_questions) : array();

        if ($flag_type == 'flag') {
            if (!in_array($question_id, $already_flagged)) {
                $already_flagged[] = $question_id;
            }
        }
        if ($flag_type == 'unflag') {
            if (($key = array_search($question_id, $already_flagged)) !== false) {
                unset($already_flagged[$key]);
            }
        }

        $QuizzesResult->update(['flagged_questions' => json_encode($already_flagged)]);

    }

    /*
     * Jump Question
     */
    public function jump_question(Request $request)
    {
        $user = auth()->user();
        $question_id = $request->get('question_id');
        $qattempt_id = $request->get('qattempt_id');
        $attemptLogObj = QuizzAttempts::find($qattempt_id);

        $QuestionsAttemptController = new QuestionsAttemptController();

        $nextQuestionArray = $QuestionsAttemptController->nextQuestion($attemptLogObj, array(), $question_id);
        $questionObj = isset($nextQuestionArray['questionObj']) ? $nextQuestionArray['questionObj'] : (object)array();
        $question_no = isset($nextQuestionArray['question_no']) ? $nextQuestionArray['question_no'] : 0;
        $prev_question = isset($nextQuestionArray['prev_question']) ? $nextQuestionArray['prev_question'] : 0;
        $next_question = isset($nextQuestionArray['next_question']) ? $nextQuestionArray['next_question'] : 0;
        $newQuestionResult = isset($nextQuestionArray['newQuestionResult']) ? $nextQuestionArray['newQuestionResult'] : (object)array();
        $QuizzesResult = isset($nextQuestionArray['QuizzesResult']) ? $nextQuestionArray['QuizzesResult'] : (object)array();
        $AttemptAllowed = isset($nextQuestionArray['AttemptAllowed']) ? $nextQuestionArray['AttemptAllowed'] : false;


        if ($AttemptAllowed == true) {
            $question_response_layout = view('web.default.panel.questions.question_layout', [
                'question'          => $questionObj,
                'prev_question'     => $prev_question,
                'next_question'     => $next_question,
                'quizAttempt'       => $attemptLogObj,
                'newQuestionResult' => $newQuestionResult,
                'question_no'       => $question_no,
                'quizResultObj'     => $QuizzesResult
            ])->render();
        } else {
            $question_response_layout = $this->get_question_result_layout($newQuestionResult->id);
        }

        $response = array('question_response_layout' => $question_response_layout);
        echo json_encode($response);
        exit;

    }

    /*
     * Jump To Review
     */
    public function jump_review(Request $request)
    {
        $user = auth()->user();
        $QuestionsAttemptController = new QuestionsAttemptController();

        $qattempt_id = $request->get('qattempt_id');
        $quizAttempt = QuizzAttempts::find($qattempt_id);

        createAttemptLog($qattempt_id, 'Session End', 'end');
        $QuizzesResult = QuizzesResult::find($quizAttempt->quiz_result_id);
        $QuizzesResult->update(['status' => 'passed',]);

        $resultData = $QuestionsAttemptController->get_result_data($QuizzesResult->parent_type_id, $QuizzesResult->id);
        $resultsDataArray = isset($resultData->resultsData) ? $resultData->resultsData : array();
        $resultObj = isset($resultsDataArray[$QuizzesResult->id]['resultObjData']) ? $resultsDataArray[$QuizzesResult->id]['resultObjData'] : array();


        $resultAttempts = isset($resultObj->attempts) ? $resultObj->attempts : array();
        $question_response_layout = '';

        if (!empty($resultAttempts)) {

            foreach ($resultAttempts as $resultAttemptObj) {
                $attemptsQuestions = $resultAttemptObj->quizz_result_questions->get();
                if (!empty($attemptsQuestions)) {
                    foreach ($attemptsQuestions as $resultQuestionObj) {
                        $question_response_layout .= $this->get_question_result_layout($resultQuestionObj->id);
                    }
                }
            }
        }
        $response = array('question_response_layout' => $question_response_layout);
        echo json_encode($response);
        exit;

    }


    public function get_question_result_layout($result_question_id)
    {

        $resultQuestionObj = QuizzResultQuestions::find($result_question_id);
        if ($resultQuestionObj->status == 'waiting') {
            return;
        }
        $questionObj = QuizzesQuestion::find($resultQuestionObj->question_id);
        $elements_data = isset($questionObj->elements_data) ? json_decode($questionObj->elements_data) : array();

        $correct_answers = ($resultQuestionObj->correct_answer != '') ? json_decode($resultQuestionObj->correct_answer) : array();
        $user_answers = ($resultQuestionObj->user_answer != '') ? json_decode($resultQuestionObj->user_answer) : array();


        $question_answers_array = array();
        if (!empty($elements_data)) {
            foreach ($elements_data as $field_key => $elementData) {
                $value = isset($correct_answers->$field_key) ? $correct_answers->$field_key : array();
                $value = is_array($value) ? $value : array($value);
                $user_value = isset($user_answers->$field_key) ? $user_answers->$field_key : array();
                $user_value = is_array($user_value) ? $user_value : array($user_value);
                $question_answers_array[$field_key]['type'] = $elementData->type;
                $question_answers_array[$field_key]['correct_value'] = $value;
                $question_answers_array[$field_key]['user_value'] = $user_value;
            }
        }


        $script = '';
        if (!empty($question_answers_array)) {
            foreach ($question_answers_array as $field_key => $question_answer_data) {
                $field_type = isset($question_answer_data['type']) ? $question_answer_data['type'] : '';
                $user_values = isset($question_answer_data['user_value']) ? $question_answer_data['user_value'] : array();
                $correct_values = isset($question_answer_data['correct_value']) ? $question_answer_data['correct_value'] : array();

                switch ($field_type) {

                    case "radio":

                        if (!empty($user_values)) {
                            foreach ($user_values as $user_selected_key => $user_selected_value) {
                                $correct_value = isset($correct_values[$user_selected_key]) ? $correct_values[$user_selected_key] : '';
                                $script .= view('web.default.panel.questions.question_script', [
                                    'field_key'           => $field_key,
                                    'user_selected_value' => $user_selected_value,
                                    'correct_value'       => $correct_value,
                                ])->render();
                            }
                        }


                        break;

                    case "checkbox":
                        if (!empty($user_values)) {
                            foreach ($user_values as $user_selected_key => $user_selected_value) {
                                $correct_value = isset($correct_values[$user_selected_key]) ? $correct_values[$user_selected_key] : '';
                                $script .= view('web.default.panel.questions.question_script', [
                                    'field_key'           => $field_key,
                                    'user_selected_value' => $user_selected_value,
                                    'correct_value'       => $correct_value,
                                ])->render();
                            }
                        }
                        break;
                }
            }
        }


        $question_layout = '<div class="question-area"><div class="question-step question-step-' . $resultQuestionObj->question_id . '" data-elapsed="0" data-qattempt="' . $resultQuestionObj->quiz_attempt_id . '"
                 data-start_time="0" data-qresult="' . $resultQuestionObj->id . '"
                 data-quiz_result_id="' . $resultQuestionObj->quiz_result_id . '">';
        //$question_layout .= $script;
        $question_layout .= html_entity_decode(json_decode(base64_decode(trim(stripslashes($questionObj->question_layout)))));
        //$question_layout .= html_entity_decode(json_decode(base64_decode(trim(stripslashes($resultQuestionObj->user_question_layout)))));
        $user_input_response = '';
        $correct_answer_response = '';
        $label_class = ($resultQuestionObj->status == 'incorrect') ? 'wrong' : 'correct';


        if (!empty($correct_answers)) {
            foreach ($correct_answers as $field_id => $correct_answer_array) {
                if (!empty($correct_answer_array)) {
                    foreach ($correct_answer_array as $correct_answer) {
                        $correct_answer_response .= '<li><label class="lms-question-label" for="radio2"><span>' . $correct_answer . '</span></label></li>';
                    }
                }
            }
        }

        if (!empty($user_answers)) {
            foreach ($user_answers as $field_id => $user_input_data_array) {
                if (!empty($user_input_data_array)) {
                    foreach ($user_input_data_array as $user_input_data) {
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


        $question_layout .= '</div></div>';
        return $question_layout;
    }

    /*
     * Questions Status Array
     */
    public function questions_status_array($QuizzesResult, $questions_list)
    {
        $questions_status_array = QuizzResultQuestions::where('quiz_result_id', $QuizzesResult->id)->whereIn('question_id', $questions_list)->pluck('status', 'question_id')->toArray();;
        return $questions_status_array;
    }

    /*
     * Prepare Result Array to display results layout
     */

    public function prepare_result_array($resultData)
    {
        $resultsData = isset($resultData->resultsData) ? $resultData->resultsData : array();
        $response_data = array();
        if (!empty($resultsData)) {

            foreach ($resultsData as $q_result_id => $resultsObj) {
                $resultObjData = isset($resultsObj['resultObjData']) ? $resultsObj['resultObjData'] : (object)array();
                $questions_list = isset($resultObjData->questions_list) ? json_decode($resultObjData->questions_list) : array();
                $response_data[$q_result_id]['total_questions'] = count($questions_list);
                $response_data[$q_result_id]['correct'] = 0;
                $response_data[$q_result_id]['incorrect'] = 0;
                $response_data[$q_result_id]['unanswered'] = 0;
                $response_data[$q_result_id]['in_review'] = 0;
                $response_data[$q_result_id]['time_consumed'] = 0;
                $response_data[$q_result_id]['average_time'] = 0;
                $response_data[$q_result_id]['status'] = $resultObjData->status;
                $response_data[$q_result_id]['created_at'] = $resultObjData->created_at;
                $response_data[$q_result_id]['attempted'] = 0;

                if (!empty($resultObjData->attempts)) {
                    foreach ($resultObjData->attempts as $attemptObj) {
                        if (!empty($attemptObj->quizz_result_questions)) {
                            foreach ($attemptObj->quizz_result_questions as $resultQuestionObj) {
                                $response_data[$q_result_id]['attempted'] += ($resultQuestionObj->status != 'waiting') ? 1 : 0;
                                $response_data[$q_result_id]['correct'] += ($resultQuestionObj->status == 'correct') ? 1 : 0;
                                $response_data[$q_result_id]['incorrect'] += ($resultQuestionObj->status == 'incorrect') ? 1 : 0;
                                $response_data[$q_result_id]['in_review'] += ($resultQuestionObj->status == 'in_review') ? 1 : 0;
                                $response_data[$q_result_id]['time_consumed'] += $resultQuestionObj->time_consumed;
                                $response_data[$q_result_id]['average_time'] += $resultQuestionObj->average_time;
                            }
                        }
                    }
                }
                $response_data[$q_result_id]['unanswered'] = count($questions_list) - $response_data[$q_result_id]['attempted'];
                $response_data[$q_result_id]['percentage'] = ($response_data[$q_result_id]['correct'] > 0 )? ($response_data[$q_result_id]['correct'] * 100) / $response_data[$q_result_id]['attempted'] : 0;
                $response_data[$q_result_id]['time_consumed'] = gmdate("i:s", $response_data[$q_result_id]['time_consumed']);
                $response_data[$q_result_id]['average_time'] = gmdate("i:s", $response_data[$q_result_id]['average_time']);
                $response_data[$q_result_id] = (object) $response_data[$q_result_id];


            }
        }

        return (object)$response_data;
    }

}
