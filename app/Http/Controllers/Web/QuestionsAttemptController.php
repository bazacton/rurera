<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\StudentAssignments;
use App\Models\UserAssignedTimestables;
use App\Models\UserAssignedTopics;
use App\User;
use App\Models\Quiz;
use App\Models\QuizzesResult;
use App\Models\QuizzesQuestion;
use App\Models\QuizzesQuestionsAnswer;
use App\Models\QuizzResultQuestions;
use App\Models\AssignmentsQuestions;
use App\Models\StudentJourneyItems;
use App\Models\LearningJourneyItems;
use App\Models\TimestablesEvents;
use App\Models\QuizzAttempts;
use App\Models\RewardAccounting;
use App\Models\UserVocabulary;
use App\Models\UsersAchievedLevels;
use App\Models\ShowdownLeaderboards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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
        $user = getUser();

        $parent_type_id = isset($params['parent_type_id']) ? $params['parent_type_id'] : 0;
        $quiz_result_type = isset($params['quiz_result_type']) ? $params['quiz_result_type'] : 0;
        $questions_list = isset($params['questions_list']) ? $params['questions_list'] : array();
        $no_of_attempts = isset($params['no_of_attempts']) ? $params['no_of_attempts'] : 0;
        $other_data = isset($params['other_data']) ? $params['other_data'] : '';
        $quiz_breakdown = isset($params['quiz_breakdown']) ? $params['quiz_breakdown'] : '';
        $quiz_level = isset($params['quiz_level']) ? $params['quiz_level'] : 'easy';
		$journey_item_id = isset($params['journey_item_id']) ? $params['journey_item_id'] : 0;
		$attempt_mode = isset($params['attempt_mode']) ? $params['attempt_mode'] : '';
		


        $newQuizStart = QuizzesResult::where('parent_type_id', $parent_type_id)->where('quiz_result_type', $quiz_result_type)->where('user_id', $user->id)->where('status', 'waiting')->first();
		if( $quiz_result_type == 'vocabulary'){
			$newQuizStart = (object) array();
		}

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
                'other_data'       => $other_data,
                'user_ip'          => getUserIP(),
                'quiz_breakdown'   => $quiz_breakdown,
                'quiz_level'       => $quiz_level,
                'attempt_mode'     => $attempt_mode,
            ]);
			
			if( $quiz_result_type == 'learning_journey'){	
				$LearningJourneyItems = LearningJourneyItems::find($journey_item_id);
				$StudentJourneyItems = StudentJourneyItems::create([
					'student_id'          => $user->id,
					'learning_journey_item_id'	=> $journey_item_id,
					'status'           => 'waiting',
					'item_type'        => $LearningJourneyItems->item_type,
					'item_value'       => $LearningJourneyItems->item_value,
					'created_at'       => time(),
					'result_id'       => $newQuizStart->id,
				]);
				
				$newQuizStart->update(['student_journey_id' => $StudentJourneyItems->id]);
			}
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
        $user = getUser();
        $quizAttempt = QuizzAttempts::create([
            'quiz_result_id' => $newQuizStart->id,
            'user_id'        => $user->id,
            'start_grade'    => $newQuizStart->user_grade,
            'end_grade'      => 0,
            'created_at'     => time(),
            'questions_list' => $newQuizStart->questions_list,
            'parent_type_id' => $newQuizStart->parent_type_id,
            'attempt_type'   => $newQuizStart->quiz_result_type,
            'user_ip'        => getUserIP(),
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
    public function nextQuestion($quizAttempt, $exclude_array = array(), $jump_question_id = 0, $attempted_questions = false, $questions_list = array(), $QuizzesResult = array(), $question_id = 0, $question_count = 0, $failed_check = false)
    {
        $user = getUser();
        $questionAttemptAllowed = false;

		$check_question_failed = 0;
        $check_question_passed = QuizzResultQuestions::where('parent_type_id', $quizAttempt->parent_type_id)->where('quiz_result_type', $quizAttempt->attempt_type)->where('user_id', $user->id)->where('question_id', $question_id)->where('quiz_result_id', $quizAttempt->quiz_result_id)->where('status', '=', 'correct')->count();
		if( $failed_check == true){
			$check_question_failed = QuizzResultQuestions::where('parent_type_id', $quizAttempt->parent_type_id)->where('quiz_result_type', $quizAttempt->attempt_type)->where('user_id', $user->id)->where('question_id', $question_id)->where('quiz_result_id', $quizAttempt->quiz_result_id)->where('status', '=', 'incorrect')->count();
		}
		

		
        $question_no = $question_count;
        if (empty($QuizzesResult)) {
            $QuizzesResult = QuizzesResult::find($quizAttempt->quiz_result_id);
        }
		



        if ($check_question_passed == 0 && $check_question_failed == 0) {
            $QuizzResultQuestionsCount = QuizzResultQuestions::where('parent_type_id', $quizAttempt->parent_type_id)->where('quiz_result_type', $quizAttempt->attempt_type)->where('user_id', $user->id)->where('question_id', $question_id)->where('quiz_result_id', $quizAttempt->quiz_result_id)->where('status', '!=', 'waiting')->count();
            $questionAttemptAllowed = $this->question_attempt_allowed($QuizzesResult, $QuizzResultQuestionsCount);

            $questionObj = QuizzesQuestion::find($question_id);

            if ($questionAttemptAllowed == true && isset( $questionObj->id)) {	
                $correct_answers = $this->get_question_correct_answers($questionObj);

                $newQuestionResult = QuizzResultQuestions::create([
                    'question_id'      => $questionObj->id,
                    'quiz_result_id'   => $quizAttempt->quiz_result_id,
                    'quiz_attempt_id'  => $quizAttempt->id,
                    'user_id'          => $user->id,
                    'correct_answer'   => json_encode($correct_answers),
                    'user_answer'      => '',
                    'quiz_layout'      => $questionObj->question_layout,
                    'quiz_grade'       => 1,
                    'average_time'     => $questionObj->question_average_time,
                    'time_consumed'    => 0,
                    'difficulty_level' => $questionObj->question_difficulty_level,
                    'status'           => 'waiting',
                    'created_at'       => time(),
                    'parent_type_id'   => $quizAttempt->parent_type_id,
                    'quiz_result_type' => $quizAttempt->attempt_type,
                    'review_required'  => $questionObj->review_required,
                    'is_active'        => ($QuizzesResult->active_question_id == $questionObj->id)? 1 : 0,
                    'user_ip'          => getUserIP(),
                    'quiz_level'       => $QuizzesResult->quiz_level,
                ]);

                //break;
            } else {
				if( !isset( $questionObj->id)){
					$newQuestionResult = QuizzResultQuestions::find($question_id);
				}else{
					$newQuestionResult = QuizzResultQuestions::where('quiz_result_id', $quizAttempt->quiz_result_id)->where('question_id', $questionObj->id)->where('status', '!=', 'waiting')->first();
				}
                //break;
                //continue;
            }
        } else {
            if ($attempted_questions == true) {
                $questionObj = QuizzesQuestion::find($question_id);
                $newQuestionResult = QuizzResultQuestions::where('quiz_result_id', $quizAttempt->quiz_result_id)->where('question_id', $questionObj->id)->where('status', '!=', 'waiting')->first();
                //break;
            }
        }

        return array(
            'questionObj'       => $questionObj,
            'newQuestionResult' => $newQuestionResult,
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

            case "practice1":
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
                if ($QuizzResultQuestionsCount == 0) {
                    $is_attempt_allowed = true;
                }
                break;

            case "sats":
                if ($QuizzResultQuestionsCount == 0) {
                    $is_attempt_allowed = true;
                }
                break;

            case "iseb":
                if ($QuizzResultQuestionsCount == 0) {
                    $is_attempt_allowed = true;
                }
                break;

            case "cat4":
                if ($QuizzResultQuestionsCount == 0) {
                    $is_attempt_allowed = true;
                }
                break;
            case "independent_exams":
                if ($QuizzResultQuestionsCount == 0) {
                    $is_attempt_allowed = true;
                }
                break;

            case "11plus":
                if ($QuizzResultQuestionsCount == 0) {
                    $is_attempt_allowed = true;
                }
                break;

            case "practice":

                if ($QuizzResultQuestionsCount == 0) {
                    $is_attempt_allowed = true;
                }
                $is_attempt_allowed = true;
                break;

            case "assignment":

                if ($QuizzResultQuestionsCount == 0) {
                    $is_attempt_allowed = true;
                }
                $is_attempt_allowed = true;
                break;

            case "vocabulary":
                if ($QuizzResultQuestionsCount == 0) {
                    $is_attempt_allowed = true;
                }
                $is_attempt_allowed = true;
                break;

            case "learning_journey":

                if ($QuizzResultQuestionsCount == 0) {
                    $is_attempt_allowed = true;
                }
                $is_attempt_allowed = true;
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
                $question_type = isset($elementData->type) ? $elementData->type : '';
                if ($field_key > 0) {
                    $question_correct = isset($elementData->correct_answere) ? $elementData->correct_answere : '';
                    $question_correct2 = isset($elementData->correct_answer) ? $elementData->correct_answer : '';
                    $question_correct = ($question_correct == '') ? $question_correct2 : $question_correct;
                    $data_correct = isset($elementData->{'data-correct'}) ? json_decode($elementData->{'data-correct'}) : '';
                    $question_correct = ($question_correct != '') ? $question_correct : $data_correct;
                    $question_correct = is_array($question_correct) ? $question_correct : array($question_correct);

                    if ($question_type == 'match_quiz') {

                        $question_correct = array();
                        $options_array = isset($elementData->options2) ? $elementData->options2 : array();
                        if (!empty($options_array)) {
                            foreach ($options_array as $question_key => $optionData) {
                                $question_correct[] = $optionData->value;
                            }
                        }
                    }

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
                        $correct_answers[$field_key] = $question_correct;
                    }

                    $data_field_type = isset($elementData->{'data-field_type'}) ? $elementData->{'data-field_type'} : '';
                    if ($data_field_type == 'select') {
                        $question_correct = array();
                        $data_correct = isset($elementData->{'data-correct'}) ? $elementData->{'data-correct'} : '';
                        $data_correct = html_entity_decode(base64_decode(trim(stripslashes($data_correct))));
                        $question_correct = isset($data_correct) ? json_decode($data_correct) : '';
                        //pre($question_correct);
                        //$data_selected_option = $elementData->{'data-select_option'};
                        //$question_correct[] = $question_correct;
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
        $user = getUser();
        $question_id = $request->get('question_id');
        $qresult_id = $request->get('qresult_id');
        $qattempt_id = $request->get('qattempt_id');
        $time_consumed = $request->get('time_consumed');
        $user_question_layout = $request->get('user_question_layout');


        $group_questions_list[] = $qresult_id;
        $QuizzResultQuestions = QuizzResultQuestions::find($qresult_id);
        $quizAttempt = QuizzAttempts::find($qattempt_id);
        $quizResultObj = QuizzesResult::find($quizAttempt->quiz_result_id);


        $questionObj = QuizzesQuestion::find($question_id);


        $review_required = $questionObj->review_required;
        $review_required = ($review_required == 1) ? true : false;

        $attempt_type = $quizAttempt->attempt_type;


        $elements_data = isset($questionObj->elements_data) ? json_decode($questionObj->elements_data) : array();

        $found_resonse = isKeyValueFoundInMultiArray((array)$elements_data, 'type', 'questions_group');

        if ($found_resonse['is_found'] == true) {
            $group_questions_list = QuizzResultQuestions::where('parent_question_id', $qresult_id)->pluck('id')->toArray();
            $group_questions_list[] = $qresult_id;
        }
        //pre('test');
        $question_response_layout = '';
        $question_data = $request->get('question_data');
        $question_data = json_decode(base64_decode(trim(stripslashes($question_data))), true);


        $questions_data = isset($question_data[0]) ? $question_data[0] : $question_data;


        if (!empty($group_questions_list)) {
            foreach ($group_questions_list as $group_question_id) {
                //$child_question_validation = $this->group_question_validation($group_question_id, $questions_data);
                //pre($child_question_validation);
            }
        }

        $field_type = isset($questions_data['type']) ? $questions_data['type'] : '';
        if ($field_type == 'insert_into_sentense') {
            //pre('test');
        }
        $incorrect_flag = false;
        $show_fail_message = true;
        $is_complete = false;

        if ($quizAttempt->attempt_type == 'sats' || $quizAttempt->attempt_type == '11plus') {
            $show_fail_message = false;
        }
        $single_question_layout = $updated_questions_layout = '';


        $next_question_id = 0;
        if (!empty($group_questions_list)) {
            foreach ($group_questions_list as $group_question_id) {
                $incorrect_array = $correct_array = $user_input_array = array();
                $question_user_input = '';
                if (!empty($questions_data)) {
                    foreach ($questions_data as $q_id => $user_input) {
                        $QuizzResultQuestions = QuizzResultQuestions::find($group_question_id);
                        $questionObj = QuizzesQuestion::find($QuizzResultQuestions->question_id);
                        $elements_data = isset($questionObj->elements_data) ? json_decode($questionObj->elements_data) : array();

                        $q_index = $q_id;
                        $sub_index = '';
                        if (strpos($q_id, "-")) {
                            $q_index = explode('-', $q_index);
                            $q_id = isset($q_index[0]) ? $q_index[0] : '';
                            $sub_index = isset($q_index[1]) ? $q_index[1] : $sub_index;
                        }

                        $current_question_obj = isset($elements_data->$q_id) ? $elements_data->$q_id : array();
                        $question_type = isset($current_question_obj->type) ? $current_question_obj->type : '';
                        $question_correct = isset($current_question_obj->correct_answere) ? $current_question_obj->correct_answere : '';
                        $question_correct2 = isset($current_question_obj->correct_answer) ? $current_question_obj->correct_answer : '';
                        $question_correct = ($question_correct == '') ? $question_correct2 : $question_correct;
                        $data_correct = isset($current_question_obj->{'data-correct'}) ? json_decode($current_question_obj->{'data-correct'}) : '';
                        $question_correct = ($question_correct != '') ? $question_correct : $data_correct;
                        $question_correct = is_array($question_correct) ? $question_correct : array($question_correct);
                        $question_user_input = $user_input;
                        $question_validate_response = $this->validate_correct_answere($current_question_obj, $question_correct, $question_type, $user_input, $sub_index);
                        $is_question_correct = isset($question_validate_response['is_question_correct']) ? $question_validate_response['is_question_correct'] : true;

                        $this->update_reward_points($QuizzResultQuestions, $is_question_correct);
                        //$this->update_vocabulary_list($QuizzResultQuestions, $is_question_correct);
                        $question_correct = isset($question_validate_response['question_correct']) ? $question_validate_response['question_correct'] : array();
                        //pre($question_correct, false);
                        if (empty($question_correct) || (isset($question_correct[0]) && $question_correct[0] == '')) {
                            continue;
                        }
                        $user_input = is_array($user_input) ? $user_input : array($user_input);
                        if ($is_question_correct == false) {

							if (in_array($quizAttempt->attempt_type, array('practice','learning_journey'))) {	
                                /*
                                * Practice Quiz Incorrect attempt add another Question
                                * @Start
                                */
                                $other_data = isset($quizResultObj->other_data) ? json_decode($quizResultObj->other_data) : array();
								($qresult_id);
                                $return_search_data = find_array_index_by_value($other_data, $qresult_id);
                                $main_index = isset($return_search_data['main_index']) ? $return_search_data['main_index'] : '';
                                $parent_index = isset($return_search_data['parent_index']) ? $return_search_data['parent_index'] : '';
                                $value_index = isset($return_search_data['value_index']) ? $return_search_data['value_index'] : 0;

                                $quizObj = Quiz::find($quizResultObj->parent_type_id);
                                $questions_list = array();
                                if (!empty($quizObj->quizQuestionsList)) {
                                    foreach ($quizObj->quizQuestionsList as $questionlistData) {
                                        $questions_list[] = $questionlistData->question_id;
                                    }
                                }

                                //DB::enableQueryLog();
                                //pre(DB::getQueryLog());
                                //DB::disableQueryLog();
                                $new_question_id = QuizzesQuestion::leftJoin('quizz_result_questions', 'quizzes_questions.id', '=', 'quizz_result_questions.question_id')->whereIN('quizzes_questions.id', $questions_list)->where('quizzes_questions.question_type', $parent_index)->where('quizzes_questions.question_difficulty_level', $main_index)->whereNull('quizz_result_questions.question_id')->limit(1)->pluck('quizzes_questions.id')->toArray();

                                $new_question_id = isset($new_question_id[0]) ? $new_question_id[0] : 0;
                                if ($new_question_id == 0) {
                                    $new_question_id = QuizzesQuestion::leftJoin('quizz_result_questions', 'quizzes_questions.id', '=', 'quizz_result_questions.question_id')->whereIN('quizzes_questions.id', $questions_list)->where('quizzes_questions.question_type', $parent_index)->where('quizzes_questions.question_difficulty_level', $main_index)->where('quizz_result_questions.status', 'incorrect')->limit(1)->pluck('quizzes_questions.id')->toArray();
                                    $new_question_id = isset($new_question_id[0]) ? $new_question_id[0] : 0;
                                    if ($new_question_id == 0) {
                                        $new_question_id = QuizzesQuestion::leftJoin('quizz_result_questions', 'quizzes_questions.id', '=', 'quizz_result_questions.question_id')->whereIN('quizzes_questions.id', $questions_list)->where('quizzes_questions.question_type', $parent_index)->where('quizzes_questions.question_difficulty_level', $main_index)->where('quizz_result_questions.status', 'correct')->limit(1)->pluck('quizzes_questions.id')->toArray();
                                        $new_question_id = isset($new_question_id[0]) ? $new_question_id[0] : 0;
                                    }
                                }
                                if ($new_question_id > 0) {
                                    $nextQuestionArray = $this->nextQuestion($quizAttempt, array(), 0, true, array(), $quizResultObj, $new_question_id);
                                    $newQuestionResult = isset($nextQuestionArray['newQuestionResult']) ? $nextQuestionArray['newQuestionResult'] : array();

                                    $other_data->{$main_index}->{$parent_index}[] = $newQuestionResult->id;

                                    $updated_questions_list = array();
                                    foreach ($other_data as $difficulty_level => $question_type) {
                                        foreach ($question_type as $q_id_array) {
                                            foreach ($q_id_array as $q_id) {
                                                $updated_questions_list[] = $q_id;
                                            }
                                        }
                                    }
                                    $questions_list = $updated_questions_list;

                                    $quizResultObj->update([
                                        'questions_list' => json_encode($questions_list),
                                        'other_data'     => json_encode($other_data),
                                    ]);
                                    $quizAttempt->update([
                                        'questions_list' => json_encode($questions_list),
                                    ]);
									
									

                                    $questions_layout_response = $this->practice_questions_layout_update($questions_list, $quizAttempt, $quizResultObj, array());
                                    $questions_layout = isset($questions_layout_response['questions_layout']) ? $questions_layout_response['questions_layout'] : '';
                                    $next_question_id = isset($questions_layout_response['next_question_id']) ? $questions_layout_response['next_question_id'] : 0;
                                    $updated_questions_layout = json_encode($questions_layout);
                                }

                                /*
                                 * Practice Quiz Incorrect attempt add another Question
                                 * @Ends
                                 */
                            }
							
							
							
							if (in_array($quizAttempt->attempt_type, array('vocabulary'))) {	
                                /*
                                * Practice Quiz Incorrect attempt add another Question
                                * @Start
                                */
                                $other_data = isset($quizResultObj->other_data) ? json_decode($quizResultObj->other_data) : array();
                               
								
								
								$questions_list = json_decode($quizResultObj->questions_list);
								
								if( $other_data == ''){
									$quizResultObj->update([
										'other_data' => json_encode($questions_list),
									]);
								}
								
								
								$incorrectQuestionObj = QuizzResultQuestions::find($group_question_id);
                                $incorrectQuestionObjNew = $incorrectQuestionObj->replicate();
                                $incorrectQuestionObjNew->user_answer = '';
                                $incorrectQuestionObjNew->status = 'waiting';
                                $incorrectQuestionObjNew->created_at = time();
                                $incorrectQuestionObjNew->push();
								$new_question_id = $incorrectQuestionObjNew->id;
								
								
								$current_index = array_search($group_question_id, $questions_list);

								if ($current_index !== false) {
									array_splice($questions_list, $current_index + 1, 0, $new_question_id);
								}
								
								
								$quizResultObj->update([
									'questions_list' => json_encode($questions_list),
								]);
								$quizAttempt->update([
									'questions_list' => json_encode($questions_list),
								]);
								
								$questions_layout_response = $this->spell_questions_layout_update($questions_list, $quizAttempt, $quizResultObj, $new_question_id, array());
								$questions_layout = isset($questions_layout_response['questions_layout']) ? $questions_layout_response['questions_layout'] : '';
								$next_question_id = isset($questions_layout_response['next_question_id']) ? $questions_layout_response['next_question_id'] : 0;
								$updated_questions_layout = json_encode($questions_layout);
								
                                /*
                                 * Practice Quiz Incorrect attempt add another Question
                                 * @Ends
                                 */
                            }
							


                            if ($sub_index != '') {
                                $incorrect_array[$q_id][$sub_index]['correct'] = $question_correct;
                                $incorrect_array[$q_id][$sub_index]['user_input'] = $user_input;
                            } else {
                                $incorrect_array[$q_id]['correct'] = $question_correct;
                                $incorrect_array[$q_id]['user_input'] = $user_input;
                            }
                            $incorrect_flag = true;

                        } else {
                            if ($sub_index != '') {
                                $correct_array[$q_id][$sub_index] = $question_correct;
                            } else {
                                $correct_array[$q_id] = $question_correct;
                            }
                        }
                        if ($sub_index != '') {
                            $user_input_array[$q_id][$sub_index] = $user_input;
                        } else {
                            $user_input_array[$q_id] = $user_input;
                        }

                    }
                }

                if ($incorrect_flag == true) {
                    $question_answer_status = 'incorrect';
                } else {
                    $question_answer_status = 'correct';
                }

                $question_answer_status = ($review_required == true) ? 'in_review' : $question_answer_status;

                $QuizzResultQuestions->update([
                    'status'               => $question_answer_status,
                    'user_answer'          => json_encode($user_input_array),
                    'time_consumed'        => ($time_consumed > 0) ? $time_consumed : 0,
                    'user_question_layout' => $user_question_layout,
                    'attempted_at'         => time(),
                ]);
            }
        }


        createAttemptLog($quizAttempt->id, 'Answered question: #' . $QuizzResultQuestions->id, 'attempt', $QuizzResultQuestions->id);

		if( empty( $questions_list )) {
			$questions_list = json_decode($quizAttempt->questions_list);
		}

        $currentIndex = array_search($qresult_id, $questions_list);
        $is_complete = ($currentIndex < count($questions_list) - 1) ? false : true;


        $QuestionsAttemptController = new QuestionsAttemptController();
		
		if (!in_array($quizAttempt->attempt_type, array('vocabulary'))) {	

			$resultLogObj = $QuestionsAttemptController->createResultLog([
				'parent_type_id'   => $quizAttempt->parent_type_id,
				'quiz_result_type' => $quizAttempt->attempt_type,
				'questions_list'   => $questions_list,
			]);
		}


        $question_correct_answere = '';
        $total_points = '';
        if ($quizAttempt->attempt_type == 'assignment') {

            $parent_type_id = $resultLogObj->parent_type_id;
            $UserAssignedTopicsObj = UserAssignedTopics::find($parent_type_id);
            $assignment_type = $UserAssignedTopicsObj->StudentAssignmentData->assignment_type;
            if ($assignment_type == 'vocabulary') {
                $correct_answeres = json_decode($QuizzResultQuestions->correct_answer);
                if (!empty($correct_answeres)) {
                    foreach ($correct_answeres as $correct_answer_array) {
                        foreach ($correct_answer_array as $correct_answer) {
                            $question_correct_answere .= $correct_answer;
                        }
                    }
                }
                $RewardAccountingObj = RewardAccounting::where('user_id', $user->id)->where('type', 'coins')->where('parent_type', $quizAttempt->attempt_type)->first();
                $total_points = isset($RewardAccountingObj->score) ? $RewardAccountingObj->score : 0;
            }
        } else {
            if ($quizAttempt->attempt_type == 'vocabulary') {
                $correct_answeres = json_decode($QuizzResultQuestions->correct_answer);
                if (!empty($correct_answeres)) {
                    foreach ($correct_answeres as $correct_answer_array) {
                        foreach ($correct_answer_array as $correct_answer) {
                            $question_correct_answere .= $correct_answer;
                        }
                    }
                }
            }
        }


        if ($quizAttempt->attempt_type == 'assignment') {
            if ($is_complete == true) {
                $QuizzesResult = QuizzesResult::find($resultLogObj->id);
                $QuizzesResult->update(['status' => 'passed']);

                $UserAssignedTopicsObj = UserAssignedTopics::find($parent_type_id);
                $assignment_method = $UserAssignedTopicsObj->StudentAssignmentData->assignment_method;
                $no_of_attempts = $UserAssignedTopicsObj->StudentAssignmentData->no_of_attempts;

                $resultData = $QuestionsAttemptController->get_result_data($UserAssignedTopicsObj->id);
                $resultData = $QuestionsAttemptController->prepare_result_array($resultData);
                $total_attempts = count((array)$resultData);
                if ($total_attempts >= $no_of_attempts) {
                    $StudentAssignments = StudentAssignments::find($UserAssignedTopicsObj->student_assignment_id);
                    $StudentAssignments->update([
                        'status'     => 'completed',
                        'updated_at' => time(),
                    ]);
                    $UserAssignedTopicsObj->update([
                        'status'     => 'completed',
                        'updated_at' => time(),
                    ]);
                }
                if ($assignment_method == 'target_improvements') {
                    $resultData = isset($resultData->{$resultLogObj->id}) ? $resultData->{$resultLogObj->id} : array();
                    $total_percentage = isset($resultData->total_percentage) ? $resultData->total_percentage : 0;
                    $time_consumed_correct_average = isset($resultData->time_consumed_correct_average) ? $resultData->time_consumed_correct_average : 0;

                    $target_percentage = $UserAssignedTopicsObj->StudentAssignmentData->target_percentage;
                    $target_average_time = $UserAssignedTopicsObj->StudentAssignmentData->target_average_time;

                    if ($total_percentage >= $target_percentage && $time_consumed_correct_average <= $target_average_time) {
                        $StudentAssignments = StudentAssignments::find($UserAssignedTopicsObj->student_assignment_id);
                        $StudentAssignments->update([
                            'status'     => 'completed',
                            'updated_at' => time(),
                        ]);
                        $UserAssignedTopicsObj->update([
                            'status'     => 'completed',
                            'updated_at' => time(),
                        ]);
                    }
                }
            }
        }

        $test = $newQuestionsArray = array();

        if (in_array($quizAttempt->attempt_type, array('practice','learning_journey'))) {
            if ($is_complete == true) {

                $is_questions_added = isset($resultLogObj->temp_data) ? $resultLogObj->temp_data : 0;
                if ($is_questions_added != 1) {
                    $resultLogObj->update([
                        'temp_data' => 1,
                    ]);
                    $quizObj = Quiz::find($resultLogObj->parent_type_id);
                    $quiz_settings = json_decode($quizObj->quiz_settings);
                    $incorrect_attempts = isset($quiz_settings->Exceeding->incorrect_attempts) ? $quiz_settings->Exceeding->incorrect_attempts : 0;
                    $excess_time_taken = isset($quiz_settings->Exceeding->excess_time_taken) ? $quiz_settings->Exceeding->excess_time_taken : 0;
					$incorrect_attempts = 0;
                    if ($incorrect_attempts > 0) {

                        /*$newQuestionResult = $newQuestionResult->replicate();
                        $newQuestionResult->update([
                            'quiz_attempt_id' => $quizAttempt->id,
                            'created_at'      => time()
                        ]);*/
                        $ResultIncorrectQuestions = QuizzResultQuestions::where('quiz_result_id', $resultLogObj->id)->where('status', '=', 'incorrect')->limit($incorrect_attempts)->get();
                        if (!empty($ResultIncorrectQuestions)) {
                            foreach ($ResultIncorrectQuestions as $incorrectQuestionObj) {
                                $incorrectQuestionObj = QuizzResultQuestions::find($incorrectQuestionObj->id);
                                $incorrectQuestionObjNew = $incorrectQuestionObj->replicate();
                                $incorrectQuestionObjNew->user_answer = '';
                                $incorrectQuestionObjNew->status = 'waiting';
                                $incorrectQuestionObjNew->created_at = time();
                                $incorrectQuestionObjNew->push();
                                $newQuestionsArray[] = $incorrectQuestionObjNew->id;
                                //$test[] = $incorrectQuestionObjNew->id;
                            }
                        }
						
						
						//$new_array = array_merge(json_decode($resultLogObj->questions_list), $newQuestionsArray);
						$new_array = array_merge(json_decode($resultLogObj->questions_list), $newQuestionsArray);
						$resultLogObj->update([
							'questions_list' => json_encode($new_array),
						]);

						$quizAttempt->update([
							'questions_list' => json_encode($new_array),
						]);

						if (!empty($newQuestionsArray)) {
							$questions_layout_response = $this->practice_questions_layout_update($new_array, $quizAttempt, $resultLogObj, $newQuestionsArray);
							$questions_layout = isset($questions_layout_response['questions_layout']) ? $questions_layout_response['questions_layout'] : '';
							$next_question_id = isset($questions_layout_response['next_question_id']) ? $questions_layout_response['next_question_id'] : 0;
							$updated_questions_layout = json_encode($questions_layout);
							//pre($new_array, false);
							//pre($previous_questions_list, false);
							//pre($questions_layout);
						}

						$is_complete = false;
                    }
					

                    

                }
            }
        }

        $quiz_type = (isset($assignment_type) && $assignment_type != '') ? $assignment_type : $quizAttempt->attempt_type;
		$finish_reponse =  '';
        if ($is_complete == true) {
			$resultLogObj = isset( $resultLogObj->id)? $resultLogObj : $quizResultObj;
            $QuizzesResult = QuizzesResult::find($resultLogObj->id);
            $QuizzesResult->update(['status' => 'passed', 'total_time_consumed' => $QuizzesResult->quizz_result_questions_list()->sum('time_consumed')]);
			$finish_reponse = $this->get_finish_layout($QuizzesResult, $quiz_type, $incorrect_flag, $correct_array, $incorrect_array, $question_correct_answere, $question_user_input);
            $this->after_attempt_complete($QuizzesResult);
        }


        //pre($questionObj, false);
        //pre($question_response_layout);


        $populated_response = $this->get_populated_layout($quiz_type, $incorrect_flag, $correct_array, $incorrect_array, $question_correct_answere, $question_user_input);

        $response = array(
            'show_fail_message'        => $show_fail_message,
            'is_complete'              => $is_complete,
            //($question_response_layout == '') ? true : $is_complete,
            'incorrect_array'          => $incorrect_array,
            'correct_array'            => $correct_array,
            'incorrect_flag'           => $incorrect_flag,
            'question_correct_answere' => $question_correct_answere,
            'question_user_input'      => $question_user_input,
            //'question'                 => $question,
            //'question_response_layout' => $question_response_layout,
            //'newQuestionResult'        => $newQuestionResult,
            'quiz_type'                => $quiz_type,
            'question_result_id'       => isset($newQuestionResult->id) ? $newQuestionResult->id : '',
            'total_points'             => $total_points,
            'populated_response'       => $populated_response,
            'single_question_layout'   => $single_question_layout,
            'updated_questions_layout' => $updated_questions_layout,
            'finish_reponse' 			=> $finish_reponse,
            'question_solution'        => isset($questionObj->question_solve) ? '<div class="question-solution">' . $questionObj->question_solve . '</div>' : '',
            'test'                     => $test,
            'next_question_id'         => $next_question_id,
        );
        echo json_encode($response);
        exit;
    }
	
	/*
	* Get Populated Response for Attempt
	*/
	public function get_populated_layout($quiz_type, $incorrect_flag, $correct_array, $incorrect_array, $question_correct_answere, $question_user_input){
		$populated_layout = '';
		$data_array = array(
			'quiz_type'	=> $quiz_type,
			'incorrect_flag'	=> $incorrect_flag,
			'correct_array'	=> $correct_array,
			'incorrect_array'	=> $incorrect_array,
			'question_correct_answere'	=> $question_correct_answere,
			'question_user_input'	=> $question_user_input,
		);
		if( $quiz_type == 'vocabulary'){
			$populated_layout = view('web.default.panel.attempt_response.spell_response', $data_array)->render();
		}
		
		return $populated_layout;
	}
	
	/*
	* Get Finish Response for Attempt
	*/
	public function get_finish_layout($QuizzesResult, $quiz_type, $incorrect_flag, $correct_array, $incorrect_array, $question_correct_answere, $question_user_input){
		$finish_layout = '';
		$data_array = array(
			'QuizzesResult' => $QuizzesResult,
			'quiz_type'	=> $quiz_type,
			'incorrect_flag'	=> $incorrect_flag,
			'correct_array'	=> $correct_array,
			'incorrect_array'	=> $incorrect_array,
			'question_correct_answere'	=> $question_correct_answere,
			'question_user_input'	=> $question_user_input,
		);
		if( $quiz_type == 'vocabulary'){
			$finish_layout = view('web.default.panel.finish_response.spell_finish', $data_array)->render();
		}
		
		return $finish_layout;
	}

    /*
     * Get Group Question Validation
     */
    public function group_question_validation($group_question_id, $questions_data)
    {

        $QuizzResultQuestionObj = QuizzResultQuestions::find($group_question_id);
        $questionObj = QuizzesQuestion::find($QuizzResultQuestionObj->question_id);
        pre($questionObj);
    }

    public function practice_questions_layout_update($questions_list, $attemptLogObj, $resultLogObj, $newQuestionsArray)
    {
        $exclude_array = $questions_layout = $results_questions_array = array();
        $QuestionsAttemptController = new QuestionsAttemptController();
        $next_question_id = 0;
        if (!empty($questions_list)) {
            $questions_counter = 0;
            foreach ($questions_list as $question_no_index => $result_question_id) {
                $question_no = $question_no_index;
                $resultQuestionObj = QuizzResultQuestions::find($result_question_id);
                $question_id = isset($resultQuestionObj->question_id) ? $resultQuestionObj->question_id : 0;
                $prev_question = isset($questions_list[$question_no_index - 2]) ? $questions_list[$question_no_index - 2] : 0;
                $next_question = isset($questions_list[$question_no_index + 1]) ? $questions_list[$question_no_index + 1] : 0;

                if (in_array($result_question_id, $newQuestionsArray)) {
                    $nextQuestionArray = $QuestionsAttemptController->nextQuestion($attemptLogObj, $exclude_array, 0, true, $questions_list, $resultLogObj, $question_id, $question_no_index);
                } else {
                    $nextQuestionArray['questionObj'] = QuizzesQuestion::find($question_id);
                    $nextQuestionArray['newQuestionResult'] = $resultQuestionObj;
                }

                $questionObj = isset($nextQuestionArray['questionObj']) ? $nextQuestionArray['questionObj'] : array();

                $newQuestionResult = isset($nextQuestionArray['newQuestionResult']) ? $nextQuestionArray['newQuestionResult'] : array();
                if (isset($newQuestionResult->is_active) && $newQuestionResult->is_active == 1) {
                    $active_question_id = $newQuestionResult->question_id;
                }

                if (in_array($result_question_id, $newQuestionsArray)) {
                    $next_question_id = ($next_question_id == 0) ? $newQuestionResult->id : $next_question_id;
                }

                if (isset($questionObj->id)) {
                    $questions_array[] = $newQuestionResult;
                    $exclude_array[] = $newQuestionResult->id;

                    $question_no = $question_no_index + 1;

                    $results_questions_array[$newQuestionResult->id] = [
                        'question'          => $questionObj,
                        'prev_question'     => $prev_question,
                        'next_question'     => $next_question,
                        'quizAttempt'       => $attemptLogObj,
                        'questionsData'     => rurera_encode($questionObj),
                        'newQuestionResult' => $newQuestionResult,
                        'question_no'       => $question_no,
                        'quizResultObj'     => $resultLogObj
                    ];

                }
                $questions_counter++;

            }

            if (!empty($results_questions_array)) {
                $array_keys = array_keys($results_questions_array);
                $resultLogObj->update([
                    'questions_list' => json_encode($array_keys),
                ]);
                $attemptLogObj->update([
                    'questions_list' => json_encode($array_keys),
                ]);
                foreach ($results_questions_array as $resultQuestionID => $resultsQuestionsData) {

                    $resultsQuestionsData['prev_question'] = 0;
                    $resultsQuestionsData['next_question'] = 0;
                    $currentIndex = array_search($resultQuestionID, $array_keys);


                    if ($currentIndex !== false) {
                        // Get the previous index
                        $previousIndex = ($currentIndex > 0) ? $array_keys[$currentIndex - 1] : 0;
                        // Get the next index
                        $nextIndex = ($currentIndex < count($array_keys) - 1) ? $array_keys[$currentIndex + 1] : 0;
                        $resultsQuestionsData['prev_question'] = $previousIndex;
                        $resultsQuestionsData['next_question'] = $nextIndex;

                    }


                    $question_response_layout = view('web.default.panel.questions.question_layout', $resultsQuestionsData)->render();
                    $questions_layout[$resultQuestionID] = rurera_encode(stripslashes($question_response_layout));
                }
            }
        }
        return array(
            'questions_layout' => $questions_layout,
            'next_question_id' => $next_question_id,
        );

    }
	
	public function spell_questions_layout_update($questions_list, $attemptLogObj, $resultLogObj, $new_question_id, $newQuestionsArray)
    {
		$user = getUser();
        $exclude_array = $questions_layout = $results_questions_array = array();
        $QuestionsAttemptController = new QuestionsAttemptController();
		$quiz_level = 'easy';
		$already_added_question = [];
        if (!empty($questions_list)) {
            $questions_counter = 0;
            foreach ($questions_list as $question_no_index => $result_question_id) {
				$layout_data = '';
                if( !isset( $question_no )){
					$question_no = $question_no_index;
				}
                $resultQuestionObj = QuizzResultQuestions::find($result_question_id);
                $question_id = isset($resultQuestionObj->question_id) ? $resultQuestionObj->question_id : 0;
				
                $prev_question = isset($questions_list[$question_no_index - 2]) ? $questions_list[$question_no_index - 2] : 0;
                $next_question = isset($questions_list[$question_no_index + 1]) ? $questions_list[$question_no_index + 1] : 0;

                if (in_array($result_question_id, $newQuestionsArray)) {
                    $nextQuestionArray = $QuestionsAttemptController->nextQuestion($attemptLogObj, $exclude_array, 0, true, $questions_list, $resultLogObj, $question_id, $question_no_index);
                } else {
                    $nextQuestionArray['questionObj'] = QuizzesQuestion::find($question_id);
                    $nextQuestionArray['newQuestionResult'] = $resultQuestionObj;
                }

                $questionObj = isset($nextQuestionArray['questionObj']) ? $nextQuestionArray['questionObj'] : array();

                $newQuestionResult = isset($nextQuestionArray['newQuestionResult']) ? $nextQuestionArray['newQuestionResult'] : array();
                if (isset($newQuestionResult->is_active) && $newQuestionResult->is_active == 1) {
                    $active_question_id = $newQuestionResult->question_id;
                }


                if (isset($questionObj->id)) {
                    $questions_array[] = $newQuestionResult;
                    $exclude_array[] = $newQuestionResult->id;

					if( !in_array($question_id, $already_added_question)){
						$question_no = $question_no + 1;
					}
					$already_added_question[] = $question_id;
					$count_values = array_count_values($already_added_question);
					$occurrences = isset($count_values[$question_id]) ? $count_values[$question_id] : 0;
					//pre($already_added_question, false);
					//pre($occurrences, false);
					//pre($question_no, false);
					if( $occurrences > 1){
						$layout_data  = '<div class="question-count"><span>Attempt '.$occurrences.'</span></div>';
					}
					
					
					$layout_elements = isset($questionObj->layout_elements) ? json_decode($questionObj->layout_elements) : array();

					$correct_answer = $audio_file = $word_audio = $audio_text = $audio_sentense = $field_id = $words_options = '';
					$exam_sentenses = array();
					if (!empty($layout_elements)) {
						foreach ($layout_elements as $elementData) {
							$element_type = isset($elementData->type) ? $elementData->type : '';
							$content = isset($elementData->content) ? $elementData->content : '';
							$correct_answer = isset($elementData->correct_answer) ? $elementData->correct_answer : $correct_answer;
							$audio_text = isset($elementData->audio_text) ? $elementData->audio_text : $audio_text;
							$audio_sentense = isset($elementData->audio_sentense) ? $elementData->audio_sentense : $audio_sentense;
							
							$audio_defination = isset($elementData->audio_defination) ? $elementData->audio_defination : $audio_defination;
							$words_options = isset($elementData->words_options) ? $elementData->words_options : $words_options;
							if ($element_type == 'audio_file') {
								$audio_file = $content;
								$word_audio = isset($elementData->word_audio) ? $elementData->word_audio : $word_audio;
								$options = isset($elementData->options) ? $elementData->options : array();
								$audio_text = $audio_text;
								$audio_sentense = $audio_sentense;
								if( !empty( $options ) ){
									foreach( $options as $optionData){
										$exam_sentenses[] = $optionData->label;
									}
								}
							}
							if ($element_type == 'textfield_quiz') {
								$correct_answer = $correct_answer;
								$field_id = isset($elementData->field_id) ? $elementData->field_id : '';
							}
							$elementsData[] = $elementData;
						}
					}

					$audio_file = ($quiz_level == 'hard')? $word_audio : $audio_file;
					$words_options = explode(',', $words_options);
					$words_options = is_array( $words_options )? $words_options : array();
					$words_options[] = $correct_answer;
					shuffle($words_options);
					$word_data = array(
						'audio_text'       => $audio_text,
						'audio_sentense'   => $audio_sentense,
						'audio_defination' => $audio_defination,
						'audio_file'       => $audio_file,
						'field_id'         => $field_id,
						'word_audio'       => $word_audio,
						'exam_sentenses'     => $exam_sentenses,
						'words_options' => $words_options,
					);

					$total_questions_count = is_array(json_decode($attemptLogObj->questions_list)) ? json_decode($attemptLogObj->questions_list) : array();
					$total_questions_count = count($total_questions_count);
					$total_questions_count = count(json_decode($resultLogObj->other_data));
					
					$RewardAccountingObj = RewardAccounting::where('user_id', $user->id)->where('type', 'coins')->where('result_id', $resultLogObj->id)->first();

					$results_questions_array[$newQuestionResult->id] = [
						'question'              => $questionObj,
						'prev_question'         => $prev_question,
						'next_question'         => $next_question,
						'quizAttempt'           => $attemptLogObj,
						'questionsData'         => rurera_encode($questionObj),
						'newQuestionResult'     => $newQuestionResult,
						'question_no'           => $question_no,
						'quizResultObj'         => $resultLogObj,
						'word_data'             => $word_data,
						'total_questions_count' => $total_questions_count,
						'field_id'              => $field_id,
						'correct_answer'        => $correct_answer,
						'layout_data'        => $layout_data,
						'disable_next'          => 'true',
						'disable_prev'          => 'true',
						'total_points'          => isset($RewardAccountingObj->score) ? $RewardAccountingObj->score : 0,
					];
					
					$actual_question_ids[$newQuestionResult->id] = $questionObj->id;

                }
                $questions_counter++;

            }

            if (!empty($results_questions_array)) {
                $array_keys = array_keys($results_questions_array);
                $resultLogObj->update([
                    'questions_list' => json_encode($array_keys),
                ]);
                $attemptLogObj->update([
                    'questions_list' => json_encode($array_keys),
                ]);
                foreach ($results_questions_array as $resultQuestionID => $resultsQuestionsData) {
					
					

                    $resultsQuestionsData['prev_question'] = 0;
                    $resultsQuestionsData['next_question'] = 0;
                    $currentIndex = array_search($resultQuestionID, $array_keys);


                    if ($currentIndex !== false) {
                        // Get the previous index
                        $previousIndex = ($currentIndex > 0) ? $array_keys[$currentIndex - 1] : 0;
                        // Get the next index
                        $nextIndex = ($currentIndex < count($array_keys) - 1) ? $array_keys[$currentIndex + 1] : 0;
                        $resultsQuestionsData['prev_question'] = $previousIndex;
                        $resultsQuestionsData['next_question'] = $nextIndex;


                    }
					
					//$quiz_level = 'medium';
					//$quiz_level = 'hard';
					$time_interval = 0;
					$duration_type = 'per_question';
					$correct_answer = isset( $resultsQuestionsData['correct_answer'] )? $resultsQuestionsData['correct_answer'] : '';
					$word_characters = strlen($correct_answer);
					if( $quiz_level == 'easy'){
						$duration_type = 'no_time_limit';
					}
					$resultsQuestionsData['quiz_level'] = $quiz_level;
					$resultsQuestionsData['time_limit'] = $time_interval;
					$resultsQuestionsData['time_interval'] = $time_interval;
					$resultsQuestionsData['duration_type'] = $duration_type;
					$resultsQuestionsData['exam_sentenses'] = $resultsQuestionsData['word_data']['exam_sentenses'];
					$resultsQuestionsData['words_options'] = $resultsQuestionsData['word_data']['words_options'];
					
					//print
					//pre($resultsQuestionsData['word_data']['exam_sentenses']);
					
					$newQuestionResult = isset( $resultsQuestionsData['newQuestionResult'] )? $resultsQuestionsData['newQuestionResult'] : array();

					$test_type_file = get_test_type_file($resultLogObj->attempt_mode);
					
					
					
					$resultsQuestionsData['no_of_questions_fixed'] = isset( $resultLogObj->other_data )? $resultLogObj->other_data : array();
					
					if( $test_type_file == ''){
						$question_response_layout = view('web.default.panel.questions.spell_question_layout', $resultsQuestionsData)->render();
					}else{
						$question_response_layout = view('web.default.panel.questions.spell_'.$test_type_file.'_question_layout', $resultsQuestionsData)->render();
					}
					if( isset( $newQuestionResult->id)){
						$newQuestionResult->update(['quiz_layout' => htmlentities(base64_encode(json_encode($question_response_layout)))]);
					}
                    $questions_layout[$resultQuestionID] = rurera_encode(stripslashes($question_response_layout));
                }
            }
        }
        return array(
            'questions_layout' => $questions_layout,
            'next_question_id' => $new_question_id,
        );

    }

    function validate_correct_answere($current_question_obj, $question_correct, $question_type, $user_input, $sub_index = 0)
    {
        $is_question_correct = true;
        $user_input = is_array($user_input) ? $user_input : strtolower($user_input);
        $user_input = is_array($user_input) ? $user_input : ucfirst($user_input);
        $field_type = isset($current_question_obj->{'data-field_type'}) ? $current_question_obj->{'data-field_type'} : '';
        if ($field_type == 'select') {
            $data_correct = isset($current_question_obj->{'data-correct'}) ? $current_question_obj->{'data-correct'} : '';
            $data_correct = html_entity_decode(base64_decode(trim(stripslashes($data_correct))));
            $question_correct = isset($data_correct) ? json_decode($data_correct) : '';
        }


        //pre($question_type);

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
        } else if ($question_type == 'match_quiz') {
            $question_correct = array();
            $options_array = $current_question_obj->options;
            $question_value = isset($options_array[$sub_index]->value) ? $options_array[$sub_index]->value : '';

            $question_correct[] = $question_value;
            $is_question_correct = ($question_value != $user_input) ? false : $is_question_correct;
        } else {

            if ($question_type == 'paragraph') {
                $user_input = strip_tags($user_input);
                $user_input = str_replace('&nbsp;', '', $user_input);
            }

            $question_correct = array_map('strtolower', $question_correct);
            $question_correct = array_map('ucfirst', $question_correct);
			if( is_array( $user_input)){
				$user_input = array_map('ucfirst', $user_input);
			}else{
				$user_input = ucfirst($user_input);
			}
            if (!in_array($user_input, $question_correct)) {
                $is_question_correct = false;
            } else {
                $is_question_correct = true;
            }
        }
        $question_correct = is_array($question_correct) ? $question_correct : array($question_correct);

        //$this->update_reward_points($current_question_obj, $is_question_correct);

        //RewardAccounting

        return $response = array(
            'is_question_correct' => $is_question_correct,
            'question_correct'    => $question_correct,
        );
    }

    /*
     * Update Rewards Points if Answere is correct
     */
    public function update_reward_points($QuizzResultQuestions, $is_question_correct, $result_parent_type_id = 0)
    {
        if ($is_question_correct != true || !auth()->check()) {
            return;
        }
        $user = auth()->user();
        $question_score = isset($QuizzResultQuestions->quiz_grade) ? $QuizzResultQuestions->quiz_grade : 0;
        $parent_id = isset($QuizzResultQuestions->parent_type_id) ? $QuizzResultQuestions->parent_type_id : 0;
        $question_id = isset($QuizzResultQuestions->question_id) ? $QuizzResultQuestions->question_id : 0;
        $parent_type = isset($QuizzResultQuestions->quiz_result_type) ? $QuizzResultQuestions->quiz_result_type : 0;
        $assignment_id = 0;
        if ($parent_type == 'timestables' || $parent_type == 'timestables_assignment') {
            $question_id = $QuizzResultQuestions->id;
            $assignment_id = $result_parent_type_id;
        }

        if ($parent_type == 'vocabulary') {
            $UserVocabulary = UserVocabulary::where('user_id', $user->id)->where('status', 'active')->first();
            $mastered_words = isset($UserVocabulary->mastered_words) ? (array)json_decode($UserVocabulary->mastered_words) : array();
            $in_progress_words = isset($UserVocabulary->in_progress_words) ? (array)json_decode($UserVocabulary->in_progress_words) : array();
            $non_mastered_words = isset($UserVocabulary->non_mastered_words) ? (array)json_decode($UserVocabulary->non_mastered_words) : array();
            //$question_score = 5;
            if (!isset($in_progress_words[$question_id])) {
                //return;
            }
        }

        $RewardAccountingObj = RewardAccounting::where('user_id', $user->id)->where('type', 'coins')->where('parent_id', $parent_id)->where('parent_type', $parent_type)->first();
        $score = isset($RewardAccountingObj->score) ? json_decode($RewardAccountingObj->score) : 0;
        $score += $question_score;
        $full_data = isset($RewardAccountingObj->full_data) ? (array)json_decode($RewardAccountingObj->full_data) : array();

        $is_exists = (isset($full_data[$question_id]) && $full_data[$question_id] != '') ? true : false;
        $is_exists = ($is_exists == true && $is_exists == 0) ? false : $is_exists;
        if ($is_exists == true) {
            return;
        }
        $full_data[$question_id]['question_score'] = $question_score;
        $full_data = json_encode($full_data);;

        if (isset($RewardAccountingObj->id)) {

            $RewardAccountingObj->update([
                'score'      => $score,
                'full_data'  => $full_data,
                'updated_at' => time(),
            ]);
            $this->afterQuestionCorrect($parent_type);

        } else {


            RewardAccounting::create([
                'user_id'       => $user->id,
                'item_id'       => 0,
                'type'          => 'coins',
                'score'         => $score,
                'status'        => 'addiction',
                'created_at'    => time(),
                'parent_id'     => $parent_id,
                'parent_type'   => $parent_type,
                'full_data'     => $full_data,
                'updated_at'    => time(),
                'assignment_id' => $assignment_id,
                'result_id'     => $QuizzResultQuestions->quiz_result_id,
            ]);
            
            $this->afterQuestionCorrect($parent_type);
        }

    }

    /*
     * Update Vocabulary List of User based on the answere
     */
    public function update_vocabulary_list($QuizzResultQuestions, $is_question_correct)
    {
        if (!auth()->check()) {
            return;
        }
        $parent_type = isset($QuizzResultQuestions->quiz_result_type) ? $QuizzResultQuestions->quiz_result_type : 0;
        if ($parent_type != 'vocabulary') {
            return;
        }
        $dataArray = array(
            'question_result_id' => $QuizzResultQuestions->id,
            'question_id'        => $QuizzResultQuestions->question_id,
            'is_correct'         => $is_question_correct,
        );
        $user = auth()->user();
        $UserVocabulary = UserVocabulary::where('user_id', $user->id)->where('status', 'active')->first();
        $mastered_words = isset($UserVocabulary->mastered_words) ? (array)json_decode($UserVocabulary->mastered_words) : array();
        $in_progress_words = isset($UserVocabulary->in_progress_words) ? (array)json_decode($UserVocabulary->in_progress_words) : array();
        $non_mastered_words = isset($UserVocabulary->non_mastered_words) ? (array)json_decode($UserVocabulary->non_mastered_words) : array();

        $is_mastered = false;
        if (isset($mastered_words[$QuizzResultQuestions->question_id])) {
            $is_mastered = true;
            if ($is_question_correct == false) {
                unset($mastered_words[$QuizzResultQuestions->question_id]);
            }
        }
        if ($is_mastered == false && $is_question_correct == true) {

            /*$is_progress_data = isset( $in_progress_words[$QuizzResultQuestions->question_id] )? $in_progress_words[$QuizzResultQuestions->question_id] : array();

            if(empty( $is_progress_data ) ){
                $in_progress_words[$QuizzResultQuestions->question_id] = $dataArray;

            }else{
                unset($in_progress_words[$QuizzResultQuestions->question_id]);
                $mastered_words[$QuizzResultQuestions->question_id] = $dataArray;
            }*/
            $mastered_words[$QuizzResultQuestions->question_id] = $dataArray;
        }
        if ($is_question_correct == false) {
            if (isset($in_progress_words[$QuizzResultQuestions->question_id])) {
                unset($in_progress_words[$QuizzResultQuestions->question_id]);
            }
            $non_mastered_words[$QuizzResultQuestions->question_id] = $dataArray;
        } else {
            if (isset($non_mastered_words[$QuizzResultQuestions->question_id])) {
                unset($non_mastered_words[$QuizzResultQuestions->question_id]);
            }
        }

        $in_progress_words = json_encode($in_progress_words);
        $mastered_words = json_encode($mastered_words);
        $non_mastered_words = json_encode($non_mastered_words);


        if (isset($UserVocabulary->id)) {

            $UserVocabulary->update([
                'mastered_words'     => $mastered_words,
                'in_progress_words'  => $in_progress_words,
                'non_mastered_words' => $non_mastered_words,
                'updated_at'         => time(),
            ]);

        } else {
            UserVocabulary::create([
                'user_id'            => $user->id,
                'mastered_words'     => $mastered_words,
                'in_progress_words'  => $in_progress_words,
                'non_mastered_words' => $non_mastered_words,
                'status'             => 'active',
                'created_by'         => $user->id,
                'created_at'         => time(),
                'updated_at'         => time(),
            ]);
        }

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
                $question_layout .= $this->get_question_complete_layout($question_id, $questionData);
            }
        }

        if (!empty($incorrect_questions)) {
            $question_layout .= '<h2>Wrong Answer</h2>';
            foreach ($incorrect_questions as $question_id => $questionData) {
                //$question_layout .= $this->get_question_complete_layout($question_id, $questionData, $quizAttempt);
            }
        }

        if (!empty($correct_questions)) {
            $question_layout .= '<br><br><h2>Correct Answer</h2>';
            foreach ($correct_questions as $question_id => $questionData) {
                //$question_layout .= $this->get_question_complete_layout($question_id, $questionData, $quizAttempt);
            }
        }


        echo $question_layout;
        exit;
    }

    public function get_question_complete_layout($question_id, $questionData, $quizAttempt = array())
    {
        $questionData = isset($questionData[0]) ? $questionData[0] : $questionData;
        if (isset($quizAttempt->attempt_type) && $quizAttempt->attempt_type == 'assignment') {
            $questionObj = AssignmentsQuestions::find($question_id);
        } else {
            $questionObj = QuizzesQuestion::find($question_id);
        }
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
                $question_correct2 = isset($current_question_obj->correct_answer) ? $current_question_obj->correct_answer : '';
                $question_correct = ($question_correct == '') ? $question_correct2 : $question_correct;
                $data_correct = isset($current_question_obj->{'data-correct'}) ? json_decode($current_question_obj->{'data-correct'}) : '';
                $question_correct = ($question_correct != '') ? $question_correct : $data_correct;
                $question_correct = is_array($question_correct) ? $question_correct : array($question_correct);

                $question_validate_response = $this->validate_correct_answere($current_question_obj, $question_correct, $question_type, $user_input, 0);
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
    public function get_result_data($parent_id, $q_result_id = 0, $parent_type = 'id')
    {
        $user = getUser();
        if (!isset($user->id)) {
            return array();
        }
        $column_name = ($parent_type == 'id') ? 'parent_type_id' : '';
        $column_name = ($parent_type == 'type') ? 'quiz_result_type' : $column_name;

        $userQuizDone = QuizzesResult::where($column_name, $parent_id)->with([
            'attempts' => function ($query) {
                $query->with('quizz_result_questions');
            }
        ])->where('user_id', $user->id);
        if (auth()->guest()) {
            $userQuizDone->where('user_ip', getUserIP());
        }
        $userQuizDone = $userQuizDone->orderBy('created_at', 'desc')->get();


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
    public function started_already($parent_id, $full_data = false)
    {
        $user = auth()->user();
        $QuizzesResult = QuizzesResult::where('parent_type_id', $parent_id)->where('user_id', $user->id)->where('status', 'waiting')->first();
		if( $full_data == true){
			return array(
				'started_already' => (isset($QuizzesResult->id)) ? true : false,
				'resultObj' => $QuizzesResult,
			);
		}else{
			return (isset($QuizzesResult->id)) ? true : false;
		}
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
        $user = getUser();
        $question_id = $request->get('question_id');
        $qattempt_id = $request->get('qattempt_id');
        $attemptLogObj = QuizzAttempts::find($qattempt_id);

        $QuestionsAttemptController = new QuestionsAttemptController();
		

        $nextQuestionArray = $QuestionsAttemptController->nextQuestion($attemptLogObj, array(), $question_id, true);
        $questionObj = isset($nextQuestionArray['questionObj']) ? $nextQuestionArray['questionObj'] : (object)array();
        $question_no = isset($nextQuestionArray['question_no']) ? $nextQuestionArray['question_no'] : 0;
        $prev_question = isset($nextQuestionArray['prev_question']) ? $nextQuestionArray['prev_question'] : 0;
        $next_question = isset($nextQuestionArray['next_question']) ? $nextQuestionArray['next_question'] : 0;
        $newQuestionResult = isset($nextQuestionArray['newQuestionResult']) ? $nextQuestionArray['newQuestionResult'] : (object)array();
        $QuizzesResult = isset($nextQuestionArray['QuizzesResult']) ? $nextQuestionArray['QuizzesResult'] : (object)array();
        $AttemptAllowed = isset($nextQuestionArray['AttemptAllowed']) ? $nextQuestionArray['AttemptAllowed'] : false;

        //$AttemptAllowed = false;

        if ($QuizzesResult->quiz_result_type == 'vocabulary') {

            $layout_elements = isset($questionObj->layout_elements) ? json_decode($questionObj->layout_elements) : array();

            $correct_answer = $audio_file = $audio_text = $audio_sentense = $field_id = '';
            if (!empty($layout_elements)) {
                foreach ($layout_elements as $elementData) {
                    $element_type = isset($elementData->type) ? $elementData->type : '';
                    $content = isset($elementData->content) ? $elementData->content : '';
                    $correct_answer = isset($elementData->correct_answer) ? $elementData->correct_answer : $correct_answer;
                    $audio_text = isset($elementData->audio_text) ? $elementData->audio_text : $audio_text;
                    $audio_sentense = isset($elementData->audio_sentense) ? $elementData->audio_sentense : $audio_sentense;
                    if ($element_type == 'audio_file') {
                        $audio_file = $content;
                        $audio_text = $audio_text;
                        $audio_sentense = $audio_sentense;
                    }
                    if ($element_type == 'textfield_quiz') {
                        $correct_answer = $correct_answer;
                        $field_id = isset($elementData->field_id) ? $elementData->field_id : '';
                    }
                }
            }
            $word_data = array(
                'audio_text'     => $audio_text,
                'audio_sentense' => $audio_sentense,
                'audio_file'     => $audio_file,
                'field_id'       => $field_id,
            );

            if ($AttemptAllowed == true) {

                $RewardAccountingObj = RewardAccounting::where('user_id', $user->id)->where('type', 'coins')->where('parent_type', $QuizzesResult->quiz_result_type)->first();

                $question_layout = view('web.default.panel.questions.spell_question_layout', [
                    'question'          => $questionObj,
                    'prev_question'     => $prev_question,
                    'next_question'     => $next_question,
                    'quizAttempt'       => $attemptLogObj,
                    'questionsData'     => rurera_encode($questionObj),
                    'newQuestionResult' => $newQuestionResult,
                    'question_no'       => $question_no,
                    'quizResultObj'     => $QuizzesResult,
                    'word_data'         => $word_data,
                    'field_id'          => $field_id,
                    'correct_answer'    => $correct_answer,
                    'total_points'      => $RewardAccountingObj->score,
                ])->render();
                $question_layout = '';

            } else {

                $newQuestionResult = QuizzResultQuestions::where('quiz_result_id', $attemptLogObj->quiz_result_id)->where('question_id', $questionObj->id)->where('status', '!=', 'waiting')->first();
                $user_answers = ($newQuestionResult->user_answer != '') ? (array)json_decode($newQuestionResult->user_answer) : array();

                $user_answer = isset($user_answers[$field_id][0]) ? $user_answers[$field_id][0] : '';

                $question_layout = view('web.default.panel.questions.spell_question_result_layout', [
                    'question'          => $questionObj,
                    'prev_question'     => $prev_question,
                    'next_question'     => $next_question,
                    'quizAttempt'       => $attemptLogObj,
                    'questionsData'     => rurera_encode($questionObj),
                    'newQuestionResult' => $newQuestionResult,
                    'question_no'       => $question_no,
                    'quizResultObj'     => $QuizzesResult,
                    'word_data'         => $word_data,
                    'field_id'          => $field_id,
                    'correct_answer'    => $correct_answer,
                    'user_answer'       => $user_answer,
                ])->render();
            }

            $response = array('question_response_layout' => $question_layout);
            echo json_encode($response);
            exit;
        }


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
            $question_response_layout = view('web.default.panel.questions.question_layout', [
                'question'          => $questionObj,
                'prev_question'     => $prev_question,
                'next_question'     => $next_question,
                'quizAttempt'       => $attemptLogObj,
                'newQuestionResult' => $newQuestionResult,
                'question_no'       => $question_no,
                'quizResultObj'     => $QuizzesResult,
                'disable_submit'    => 'true',
                'class'             => 'disable-div',
            ])->render();
            $question_response_layout .= $this->get_question_result_layout($newQuestionResult->id);
        }

        $response = array('question_response_layout' => $question_response_layout);
        echo json_encode($response);
        exit;

    }

    /*
     * Mark as Active
     */
    public function mark_as_active(Request $request)
    {
        $question_id = $request->get('question_id');
        $qattempt_id = $request->get('qattempt_id');
        $actual_question_id = $request->get('actual_question_id');
        $attemptLogObj = QuizzAttempts::find($qattempt_id);
        $QuizzResultQuestions = QuizzResultQuestions::where('quiz_result_id', $attemptLogObj->quiz_result_id)->update(array('is_active' => 0));
        $QuizzResultQuestions = QuizzResultQuestions::where('id', $question_id)->where('quiz_result_id', $attemptLogObj->quiz_result_id)->update(array('is_active' => 1));

        $QuizzesResult = QuizzesResult::where('id', $attemptLogObj->quiz_result_id)->update(array('active_question_id' => $actual_question_id));
    }
	
	
	 /*
     * Update time for Result
     */
    public function update_time(Request $request)
    {
        $quiz_result_id = $request->get('quiz_result_id');
        $time_consumed = $request->get('time_consumed');
        $QuizzesResult = QuizzesResult::where('id', $quiz_result_id)->update(array('total_time_consumed' => $time_consumed));

        
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
		$attempted_questions = $QuizzesResult->quizz_result_questions->where('status', '!=', 'waiting' )->count();
		if( $attempted_questions == 0){
			echo json_encode(array('status' => 'no_questions_attempted'));
			exit;
		}
        $QuizzesResult->update(['status' => 'passed',]);
		$QuizzesResult->quizz_result_questions->where('status', 'waiting' )->update(['status' => 'not_attempted']);

        $resultData = $QuestionsAttemptController->get_result_data($QuizzesResult->parent_type_id, $QuizzesResult->id);
        $resultsDataArray = isset($resultData->resultsData) ? $resultData->resultsData : array();
        $resultObj = isset($resultsDataArray[$QuizzesResult->id]['resultObjData']) ? $resultsDataArray[$QuizzesResult->id]['resultObjData'] : array();

        $resultAttempts = isset($resultObj->attempts) ? $resultObj->attempts : array();
        $question_response_layout = '';

        if (!empty($resultAttempts)) {

            foreach ($resultAttempts as $resultAttemptObj) {
                //$attemptsQuestions = $resultAttemptObj->quizz_result_questions->get();
                $attemptsQuestions = $resultAttemptObj->quizz_result_questions;
                if (!empty($attemptsQuestions)) {
                    foreach ($attemptsQuestions as $resultQuestionObj) {
                        $question_response_layout .= $this->get_question_result_layout($resultQuestionObj->id);
                    }
                }
            }
        }
        $this->after_attempt_complete($QuizzesResult);
        $response = array('question_response_layout' => $question_response_layout);
        echo json_encode($response);
        exit;

    }

    /*
     * Submit TableTimes Results
     */
    public function timestables_submit(Request $request)
    {
        $timestables_data = $request->get('timestables_data');
        $attempt_id = $request->get('attempt_id');

        //$user = auth()->user();
        $user = getUser();
		
        $QuizzAttempts = QuizzAttempts::find($attempt_id);

        $get_last_results = '';
        if ($user->id > 0) {
            $last_time_table_data = QuizzesResult::where('user_id', $user->id)->where('id', '!=', $QuizzAttempts->quiz_result_id)->whereIN('quiz_result_type', array(
                'timestables',
                'timestables_assignment'
            ))->where('status', '!=', 'waiting')->orderBy('id', 'DESC')->first();
            $get_last_results = isset($last_time_table_data->other_data) ? $last_time_table_data->other_data : '';
        }

        $get_last_results = (array)json_decode($get_last_results);

        $results = array();
		
		$QuizzAttempts = QuizzAttempts::find($attempt_id);
        $QuizzesResult = QuizzesResult::find($QuizzAttempts->quiz_result_id);
		$score = 1;
		if( $QuizzesResult->attempt_mode == 'treasure_mode') {
			$treasure_mission_data = get_treasure_mission_data();
			$nugget_data = searchNuggetByID($treasure_mission_data,'id', $QuizzesResult->nugget_id);
			$levelData = isset( $nugget_data['levelData'] )? $nugget_data['levelData'] : array();
			$score = isset( $levelData['coins'] )? $levelData['coins'] : $score;
		}

        if (!empty($timestables_data)) {
            foreach ($timestables_data as $tableData) {
				$tableData['score'] = $score;
				$results[$tableData['table_no']][] = $tableData;
            }
        }
        $new_array = $results;//array_merge($get_last_results, $results);


        
        $new_result_data = array();
        if (!empty($new_array)) {
            foreach ($new_array as $array_data) {
                if (!empty($array_data)) {
                    foreach ($array_data as $key => $arrayDataObj) {
                        $arrayDataObj = (array)$arrayDataObj;
						$arrayDataObj['score'] = $score;
                        $new_result_data[$arrayDataObj['from']][] = $arrayDataObj;
                    }
                }
            }
        }

        $QuizzesResult->update([
            'user_id'        => $user->id,
            'results'        => json_encode($results),
            'user_grade'     => 0,
            'status'         => 'passed',
            //'quiz_result_type' => 'timestables',
            'no_of_attempts' => 100,
            'other_data'     => json_encode($new_result_data),
        ]);

        $attempt_log_id = createAttemptLog($QuizzAttempts->id, 'Session Ends', 'end');

        $total_time_consumed = 0;
        $incorrect_array = $correct_array = array();
        if (!empty($timestables_data)) {
			
            foreach ($timestables_data as $tableData) {

                $correct_answers = isset($tableData['correct_answer']) ? $tableData['correct_answer'] : '';
                $user_answer = isset($tableData['answer']) ? $tableData['answer'] : '';
                $from = isset($tableData['from']) ? $tableData['from'] : '';
                $to = isset($tableData['to']) ? $tableData['to'] : '';
                $type = isset($tableData['type']) ? $tableData['type'] : '';
                $time_consumed = isset($tableData['time_consumed']) ? $tableData['time_consumed'] : '';
                $table_no = isset($tableData['table_no']) ? $tableData['table_no'] : '';
                $is_correct = isset($tableData['is_correct']) ? $tableData['is_correct'] : '';
				$question_status = ($is_correct == 'true') ? 'correct' : 'incorrect';
				$question_status = ($time_consumed > 0)? $question_status : 'not_attempted';
                $total_time_consumed += $time_consumed;
                $newQuestionResult = QuizzResultQuestions::create([
                    'question_id'      => 0,
                    'quiz_result_id'   => $QuizzesResult->id,
                    'quiz_attempt_id'  => $QuizzAttempts->id,
                    'user_id'          => $user->id,
                    'correct_answer'   => $correct_answers,
                    'user_answer'      => $user_answer,
                    'quiz_layout'      => json_encode($tableData),
                    'quiz_grade'       => $score,
                    'average_time'     => 0,
                    'time_consumed'    => $time_consumed,
                    'difficulty_level' => 'Expected',
                    'status'           => $question_status,
                    'created_at'       => time(),
                    'parent_type_id'   => $table_no,
                    'quiz_result_type' => $QuizzAttempts->attempt_type,
                    'review_required'  => 0,
                    'attempted_at'     => time(),
                    'user_ip'          => getUserIP(),
                    'quiz_level'       => $QuizzesResult->quiz_level,
                    'attempt_mode'     => $QuizzesResult->attempt_mode,
                    'child_type_id'   => $to,
                ]);
                if($is_correct != 'true' && $question_status != 'not_attempted'){
                    $incorrect_array[] = $newQuestionResult->id;
                }
                if($is_correct == 'true'){
                    $correct_array[] = $newQuestionResult->id;
                }
				
				
				if( $QuizzesResult->attempt_mode == 'treasure_mode') {
					$percentage_correct_answer = $this->get_percetange_corrct_answer($QuizzesResult);
					if( $percentage_correct_answer >= 95){
						$this->update_reward_points($newQuestionResult, ($is_correct == 'true') ? true : false, $QuizzesResult->parent_type_id);
					}
				}else{
					$this->update_reward_points($newQuestionResult, ($is_correct == 'true') ? true : false, $QuizzesResult->parent_type_id);
				}

            }
        }

        $QuizzesResult->update([
            'total_correct' => count($correct_array),
            'total_time_consumed'     => ($total_time_consumed > 0)? ($total_time_consumed / 10) : 0,
        ]);

        if( $QuizzesResult->attempt_mode == 'showdown_mode') {
            $user->update([
                'showdown_correct' => count($correct_array),
                'showdown_time_consumed' => ($total_time_consumed > 0)? ($total_time_consumed / 10) : 0,
            ]);

            ShowdownLeaderboards::create([
                'user_id'           => $user->id,
                'result_id'         => $QuizzesResult->id,
                'showdown_correct'  => count($correct_array),
                'showdown_time_consumed'         => ($total_time_consumed > 0)? ($total_time_consumed / 10) : 0,
                'status'            => 'active',
                'created_at'        => time(),
                'created_by'        => $user->id,
            ]);

        }

        if( $QuizzesResult->attempt_mode == 'treasure_mode') {
            $user_life_lines = $user->user_life_lines;

            $user_data = array();
            if (count($incorrect_array) > 0) {
                $user_life_lines = $user_life_lines - count($incorrect_array);
                $user_data['user_life_lines'] = $user_life_lines;
            }
            $percentage_correct_answer = $this->get_percetange_corrct_answer($QuizzesResult);
            $user_timetables_levels = json_decode($user->user_timetables_levels);
            $user_timetables_levels = is_array($user_timetables_levels)? $user_timetables_levels : array();
            $user_timetables_levels[] = $QuizzesResult->nugget_id;
            if( $percentage_correct_answer >= 95){

                //Check for Treasure Box

                $treasure_mission_data = get_treasure_mission_data();
                $nugget_data = searchNuggetByID($treasure_mission_data,'id', $QuizzesResult->nugget_id);
                $treasure_box = isset( $nugget_data['treasure_box'] )? $nugget_data['treasure_box'] : 0;
                if( $treasure_box > 0){
                    RewardAccounting::create([
                        'user_id'       => $user->id,
                        'item_id'       => 0,
                        'type'          => 'coins',
                        'score'         => $treasure_box,
                        'status'        => 'addiction',
                        'created_at'    => time(),
                        'parent_id'     => $QuizzesResult->id,
                        'parent_type'   => 'timestables_treasure',
                        'full_data'     => $QuizzesResult->nugget_id,
                        'updated_at'    => time(),
                        'assignment_id' => 0,
                        'result_id'     => $QuizzesResult->id,
                    ]);
                }


                $user_data['user_timetables_levels'] = json_encode($user_timetables_levels);

            }
            if( !empty( $user_data ) ) {
                $user->update($user_data);
            }
        }


        if ($QuizzesResult->quiz_result_type == 'timestables_assignment') {
            $UserAssignedTopics = UserAssignedTopics::find($QuizzesResult->parent_type_id);
            $no_of_attempts = $UserAssignedTopics->StudentAssignmentData->no_of_attempts;
            $total_attempts = QuizzesResult::where('parent_type_id', $UserAssignedTopics->id)->where('user_id', $user->id)->where('status', '!=', 'waiting')->count();

            $UserAssignedTopics->update([
                'updated_at' => time(),
            ]);

            if ($total_attempts >= $no_of_attempts) {
                $TimestablesEvents = TimestablesEvents::find($UserAssignedTopics->topic_id);
				if( isset( $TimestablesEvents->id ) ){
					$TimestablesEvents->update([
						'status'     => 'completed',
						'updated_at' => time(),
					]);
				}
                $StudentAssignments = StudentAssignments::find($UserAssignedTopics->student_assignment_id);
				if( isset( $StudentAssignments->id ) ){
					$StudentAssignments->update([
						'status'     => 'completed',
						'updated_at' => time(),
					]);
				}
				if( isset( $UserAssignedTopics->id ) ){
					$UserAssignedTopics->update([
						'status'     => 'completed',
						'updated_at' => time(),
					]);
				}
            }

            $assignment_method = $UserAssignedTopics->StudentAssignmentData->assignment_method;

            $QuestionsAttemptController = new QuestionsAttemptController();
            $resultData = $QuestionsAttemptController->get_result_data($UserAssignedTopics->id);
            $resultData = $QuestionsAttemptController->prepare_result_array($resultData);

            if ($assignment_method == 'target_improvements') {
                $resultData = isset($resultData->{$QuizzesResult->id}) ? $resultData->{$QuizzesResult->id} : array();
                $total_percentage = isset($resultData->total_percentage) ? $resultData->total_percentage : 0;
                $time_consumed_correct_average = isset($resultData->time_consumed_correct_average) ? $resultData->time_consumed_correct_average : 0;

                $target_percentage = $UserAssignedTopics->StudentAssignmentData->target_percentage;
                $target_average_time = $UserAssignedTopics->StudentAssignmentData->target_average_time;

                if ($total_percentage >= $target_percentage && $time_consumed_correct_average <= $target_average_time) {
                    $StudentAssignments = StudentAssignments::find($UserAssignedTopics->student_assignment_id);
                    $StudentAssignments->update([
                        'status'     => 'completed',
                        'updated_at' => time(),
                    ]);
                    $UserAssignedTopics->update([
                        'status'     => 'completed',
                        'updated_at' => time(),
                    ]);
                }
            }
        }

        $return_layout = '';
		
		
		$DailyQuestsController = new DailyQuestsController();
        $completed_quests = $DailyQuestsController->questCompletionCheck($QuizzesResult);

		$hide_class = '';
		if( !empty( $completed_quests )){
			foreach( $completed_quests as $complete_response){
				$questObj = isset( $complete_response['questObj'] )? $complete_response['questObj'] : (object) array();
				$RewardAccounting = isset( $complete_response['RewardAccounting'] )? $complete_response['RewardAccounting'] : (object) array();
				$QuizzesResult = isset( $complete_response['QuizzesResult'] )? $complete_response['QuizzesResult'] : (object) array();
				$hide_class = 'rurera-hide';
				$return_layout .= view('web.default.quests.quest_completed', ['questObj' => $questObj, 'RewardAccounting' => $RewardAccounting, 'QuizzesResult' => $QuizzesResult])->render();
			}
		}
        
		
		
		
        if ($QuizzesResult->quiz_result_type == 'timestables' && $QuizzesResult->attempt_mode == 'treasure_mode') {
 
            $treasure_mission_data = get_treasure_mission_data();
            if( $percentage_correct_answer >= 95) {
                $nuggetObj = getNextNuggetByCurrentID($treasure_mission_data, 'id', $QuizzesResult->nugget_id);
            }else{
                $nuggetObj = searchNuggetByID($treasure_mission_data, 'id', $QuizzesResult->nugget_id);
            }
			
			$return_layout .= '<div class="finish-steps '.$hide_class.'">';
				$return_layout .= view('web.default.timestables.finish_treasure_mode', ['QuizzesResult' => $QuizzesResult, 'nuggetObj' => $nuggetObj, 'percentage_correct_answer' => $percentage_correct_answer])->render();
			$return_layout .= '</div>';
        }
        
        if ($QuizzesResult->quiz_result_type == 'timestables' && $QuizzesResult->attempt_mode == 'freedom_mode') {
            $results = json_decode($QuizzesResult->results);
			$return_layout .= '<div class="finish-steps '.$hide_class.'">';
				$return_layout .= view('web.default.timestables.finish_timestables', ['QuizzesResult' => $QuizzesResult, 'results' => $results])->render();
			$return_layout .= '</div>';
        }
        if ($QuizzesResult->quiz_result_type == 'timestables_assignment') {
            $results = json_decode($QuizzesResult->results);
			$return_layout .= '<div class="finish-steps '.$hide_class.'">';
				$return_layout .= view('web.default.timestables.finish_timestables', ['QuizzesResult' => $QuizzesResult, 'results' => $results])->render();
			$return_layout .= '</div>';
        }
		
		if ($QuizzesResult->quiz_result_type == 'timestables' && $QuizzesResult->attempt_mode == 'powerup_mode') {
            $results = json_decode($QuizzesResult->results);
			$return_layout .= '<div class="finish-steps '.$hide_class.'">';
				$return_layout .= view('web.default.timestables.finish_powerup_mode', ['QuizzesResult' => $QuizzesResult, 'results' => $results])->render();
			$return_layout .= '</div>';
        }

        $this->resultTimestablesAverage($QuizzesResult->id);
        
        
        if ($QuizzesResult->quiz_result_type == 'timestables' && $QuizzesResult->attempt_mode == 'trophy_mode') {
            $trophyDetails = QuizzesResult::where('user_id', $user->id)
                        ->where('quiz_result_type', 'timestables')
                        ->where('attempt_mode', 'trophy_mode')
                        ->where('status', '!=', 'waiting');
            $total_counts = $trophyDetails->count();
            $total_correct = $trophyDetails->sum('total_correct');
            if( $total_counts > 4){
                $average_questions = ($total_counts*60) / $total_correct;
                $average_questions = round($average_questions, 1);
                $user->update([
                    'trophy_badge' => get_trophy_badge($average_questions),
                    'trophy_average'   => $average_questions,
                ]);
            }
            $results = json_decode($QuizzesResult->results);
			$return_layout .= '<div class="finish-steps '.$hide_class.'">';
				$return_layout .= view('web.default.timestables.finish_timestables', ['QuizzesResult' => $QuizzesResult, 'results' => $results])->render();
			$return_layout .= '</div>';
        }

        $response = array(
            'return_layout' => $return_layout
        );

        echo json_encode($response);
        exit;
    }

    public function get_question_result_layout($result_question_id, $is_result_question = true)
    {


        $resultQuestionObj = QuizzResultQuestions::find($result_question_id);
        if ($resultQuestionObj->status == 'waiting') {
            return;
        }
        $questionObj = QuizzesQuestion::find($resultQuestionObj->question_id);
        $elements_data = isset($questionObj->elements_data) ? json_decode($questionObj->elements_data) : array();

        $correct_answers = ($resultQuestionObj->correct_answer != '') ? json_decode($resultQuestionObj->correct_answer) : array();
        $user_answers = ($resultQuestionObj->user_answer != '') ? json_decode($resultQuestionObj->user_answer) : array();

        //pre($elements_data);
        $question_answers_array = array();
        if (!empty($elements_data)) {
            foreach ($elements_data as $field_key => $elementData) {
                $value = isset($correct_answers->$field_key) ? $correct_answers->$field_key : array();
                $value = is_array($value) ? $value : array($value);
                $user_value = isset($user_answers->$field_key) ? $user_answers->$field_key : array();
                $user_value = is_array($user_value) ? $user_value : array($user_value);
                $question_answers_array[$field_key]['type'] = isset($elementData->type) ? $elementData->type : '';
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
                                    'field_type'          => $field_type,
                                    'field_key'           => $field_key,
                                    'user_selected_key'   => $user_selected_key,
                                    'user_selected_value' => $user_selected_value,
                                    'correct_value'       => $correct_value,
                                    'is_result_question'	=> $is_result_question,
                                ])->render();
                            }
                        }


                        break;

                    case "checkbox":
                        if (!empty($user_values)) {
                            foreach ($user_values as $user_selected_key => $user_selected_value) {
                                $correct_value = isset($correct_values[$user_selected_key]) ? $correct_values[$user_selected_key] : '';
                                $script .= view('web.default.panel.questions.question_script', [
                                    'field_type'          => $field_type,
                                    'field_key'           => $field_key,
                                    'user_selected_key'   => $user_selected_key,
                                    'user_selected_value' => $user_selected_value,
                                    'correct_value'       => $correct_value,
                                    'is_result_question'	=> $is_result_question,
                                ])->render();
                            }
                        }
                        break;

                    case "text":

                        if (!empty($user_values)) {
                            foreach ($user_values as $user_selected_key => $user_selected_value) {
                                $correct_value = isset($correct_values[$user_selected_key]) ? $correct_values[$user_selected_key] : '';
                                $script .= view('web.default.panel.questions.question_script', [
                                    'field_type'          => $field_type,
                                    'field_key'           => $field_key,
                                    'user_selected_key'   => $user_selected_key,
                                    'user_selected_value' => $user_selected_value,
                                    'correct_value'       => $correct_value,
                                    'is_result_question'	=> $is_result_question,
                                ])->render();
                            }
                        }

                    default:

                        if (!empty($user_values)) {
                            foreach ($user_values as $user_selected_key => $user_selected_value) {
                                $correct_value = isset($correct_values[$user_selected_key]) ? $correct_values[$user_selected_key] : '';
                                $script .= view('web.default.panel.questions.question_script', [
                                    'field_type'          => $field_type,
                                    'field_key'           => $field_key,
                                    'user_selected_key'   => $user_selected_key,
                                    'user_selected_value' => $user_selected_value,
                                    'correct_value'       => $correct_value,
                                    'is_result_question'	=> $is_result_question,
                                ])->render();
                            }
                        }

                        /*if (!empty($correct_values)) {
                            foreach ($correct_values as $user_correct_key => $correct_value) {
                                $user_selected_value = isset($user_values[$user_correct_key]) ? $user_values[$user_correct_key] : '';
                                $script .= view('web.default.panel.questions.question_script', [
                                    'field_type'          => $field_type,
                                    'field_key'           => $field_key,
                                    'user_selected_key'   => $user_correct_key,
                                    'user_selected_value' => $user_selected_value,
                                    'correct_value'       => $correct_value,
                                ])->render();
                            }
                        }*/

                        break;
                }
            }
        }

		$question_layout = '';
		if($is_result_question == true){
			$question_layout .= '<div class="question-area"><div class="question-step question-step-' . $resultQuestionObj->question_id . '" data-elapsed="0" data-qattempt="' . $resultQuestionObj->quiz_attempt_id . '"
                     data-start_time="0" data-qresult="' . $resultQuestionObj->id . '"
                     data-quiz_result_id="' . $resultQuestionObj->quiz_result_id . '">';
		}

        //$question_layout .= html_entity_decode(json_decode(base64_decode(trim(stripslashes($questionObj->question_layout)))));
        //$question_layout .= html_entity_decode(json_decode(base64_decode(trim(stripslashes($resultQuestionObj->user_question_layout)))));


        $question_layout .= $script;

        $user_input_response = '';
        $correct_answer_response = '';
        $label_class = ($resultQuestionObj->status == 'incorrect') ? 'wrong' : 'correct';

        $user = getUser();
        $full_name = isset($user->id) ? $user->get_full_name() : 'Guest';
        if (!empty($correct_answers)) {
            foreach ($correct_answers as $field_id => $correct_answer_array) {
                if (!empty($correct_answer_array)) {
                    foreach ($correct_answer_array as $correct_answer) {
                        if ($correct_answer != '') {
                            $correct_answer_response .= '<li><label class="lms-question-label" for="radio2"><span>' . $correct_answer . '</span></label></li>';
                        }
                    }
                }
            }
        }

        if (!empty($user_answers)) {
            foreach ($user_answers as $field_id => $user_input_data_array) {
                if (!empty($user_input_data_array)) {
                    foreach ($user_input_data_array as $user_input_data) {
                        $user_input_data = is_array($user_input_data) ? $user_input_data[0] : $user_input_data;
                        $user_input_response .= '<li><label class="lms-question-label ' . $label_class . '" for="radio2"><span>' . $user_input_data . '</span></label></li>';
                    }
                }
            }
        }

		if($is_result_question == true){
			$question_layout .= '<div class="lms-radio-lists">
									<span class="list-title">Correct answer:</span>
									<ul class="lms-radio-btn-group lms-user-answer-block">' . $correct_answer_response . '</ul>
									<span class="list-title">' . $full_name . ' answered:</span>
									<ul class="lms-radio-btn-group lms-user-answer-block">' . $user_input_response . '</ul>
							</div><hr>';


			$question_layout .= '</div></div>';
		}
        return $question_layout;
    }

    public function get_example_question_layout($question_id)
    {

        $questionObj = QuizzesQuestion::find($question_id);
        $elements_data = isset($questionObj->elements_data) ? json_decode($questionObj->elements_data) : array();

        $correct_answers = $this->get_question_correct_answers($questionObj);
        $user_answers = array();

        $question_answers_array = array();
        if (!empty($elements_data)) {
            foreach ($elements_data as $field_key => $elementData) {
                $value = isset($correct_answers->$field_key) ? $correct_answers->$field_key : array();
                $value = is_array($value) ? $value : array($value);
                $user_value = isset($user_answers->$field_key) ? $user_answers->$field_key : array();
                $user_value = is_array($user_value) ? $user_value : array($user_value);
                $question_answers_array[$field_key]['type'] = isset($elementData->type) ? $elementData->type : '';
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
                                    'field_type'          => $field_type,
                                    'field_key'           => $field_key,
                                    'user_selected_key'   => $user_selected_key,
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
                                    'field_type'          => $field_type,
                                    'field_key'           => $field_key,
                                    'user_selected_key'   => $user_selected_key,
                                    'user_selected_value' => $user_selected_value,
                                    'correct_value'       => $correct_value,
                                ])->render();
                            }
                        }
                        break;

                    case "text":

                        if (!empty($user_values)) {
                            foreach ($user_values as $user_selected_key => $user_selected_value) {
                                $correct_value = isset($correct_values[$user_selected_key]) ? $correct_values[$user_selected_key] : '';
                                $script .= view('web.default.panel.questions.question_script', [
                                    'field_type'          => $field_type,
                                    'field_key'           => $field_key,
                                    'user_selected_key'   => $user_selected_key,
                                    'user_selected_value' => $user_selected_value,
                                    'correct_value'       => $correct_value,
                                ])->render();
                            }
                        }

                        break;
                }
            }
        }


        //$resultQuestionObj
        $question_layout = '<div class="question-area"><div class="question-step question-step-' . $question_id . '" data-elapsed="0" data-qattempt="' . $question_id . '"
                     data-start_time="0" data-qresult="' . $question_id . '"
                     data-quiz_result_id="' . $question_id . '">';

        //$question_layout .= html_entity_decode(json_decode(base64_decode(trim(stripslashes($questionObj->question_layout)))));
        //$question_layout .= html_entity_decode(json_decode(base64_decode(trim(stripslashes($resultQuestionObj->user_question_layout)))));


        $question_layout .= $script;

        $user_input_response = '';
        $correct_answer_response = '';
        $label_class = 'correct';

        $user = getUser();
        $full_name = isset($user->id) ? $user->get_full_name() : 'Guest';
        if (!empty($correct_answers)) {
            foreach ($correct_answers as $field_id => $correct_answer_array) {
                if (!empty($correct_answer_array)) {
                    foreach ($correct_answer_array as $correct_answer) {
                        if ($correct_answer != '') {
                            $correct_answer_response .= '<li><label class="lms-question-label" for="radio2"><span>' . $correct_answer . '</span></label></li>';
                        }
                    }
                }
            }
        }

        if (!empty($user_answers)) {
            foreach ($user_answers as $field_id => $user_input_data_array) {
                if (!empty($user_input_data_array)) {
                    foreach ($user_input_data_array as $user_input_data) {
                        $user_input_data = is_array($user_input_data) ? $user_input_data[0] : $user_input_data;
                        $user_input_response .= '<li><label class="lms-question-label ' . $label_class . '" for="radio2"><span>' . $user_input_data . '</span></label></li>';
                    }
                }
            }
        }

        $question_layout .= '<div class="lms-radio-lists">
                                <span class="list-title">Correct answer:</span>
                                <ul class="lms-radio-btn-group lms-user-answer-block">' . $correct_answer_response . '</ul>
                        </div><hr>';


        $question_layout .= '</div></div>';
        return $question_layout;
    }

    /*
     * Questions Status Array
     */
    public function questions_status_array($QuizzesResult, $questions_list)
    {
        $questions_status_array = QuizzResultQuestions::where('quiz_result_id', $QuizzesResult->id)->whereIn('id', $questions_list)->pluck('status', 'id')->toArray();;
        return $questions_status_array;
    }
	
	public function questions_status_array_bk($QuizzesResult, $questions_list)
    {
        $questions_status_array = QuizzResultQuestions::where('quiz_result_id', $QuizzesResult->id)->whereIn('question_id', $questions_list)->pluck('status', 'question_id')->toArray();;
        return $questions_status_array;
    }

    /*
     * Prepare Result Array to display results layout
     */

    public function prepare_result_array($resultData)
    {
        $user = getUser();
        $resultsData = isset($resultData->resultsData) ? $resultData->resultsData : array();
        $response_data = array();
        if (!empty($resultsData)) {

            $UserVocabulary = UserVocabulary::where('user_id', $user->id)->where('status', 'active')->first();
            $user_mastered_words = isset($UserVocabulary->mastered_words) ? (array)json_decode($UserVocabulary->mastered_words) : array();
            $user_in_progress_words = isset($UserVocabulary->in_progress_words) ? (array)json_decode($UserVocabulary->in_progress_words) : array();
            $user_non_mastered_words = isset($UserVocabulary->non_mastered_words) ? (array)json_decode($UserVocabulary->non_mastered_words) : array();

            $questions_ids = array();
            foreach ($resultsData as $q_result_id => $resultsObj) {
                $resultObjData = isset($resultsObj['resultObjData']) ? $resultsObj['resultObjData'] : (object)array();
                $questions_list = isset($resultObjData->questions_list) ? json_decode($resultObjData->questions_list) : array();
                $response_data[$q_result_id]['total_questions'] = count($questions_list);
                $response_data[$q_result_id]['correct'] = 0;
                $response_data[$q_result_id]['incorrect'] = 0;
                $response_data[$q_result_id]['unanswered'] = 0;
                $response_data[$q_result_id]['in_review'] = 0;
                $response_data[$q_result_id]['time_consumed'] = 0;
                $response_data[$q_result_id]['time_consumed_corrected'] = 0;
                $response_data[$q_result_id]['average_time'] = 0;
                $response_data[$q_result_id]['mastered_words'] = 0;
                $response_data[$q_result_id]['in_progress_words'] = 0;
                $response_data[$q_result_id]['non_mastered_words'] = 0;
                $response_data[$q_result_id]['result_id'] = $resultObjData->id;
                $response_data[$q_result_id]['status'] = $resultObjData->status;
                $response_data[$q_result_id]['created_at'] = $resultObjData->created_at;
                $response_data[$q_result_id]['attempted'] = 0;
                if ($resultObjData->quiz_result_type == 'timestables_assignment') {
                    $results = json_decode($resultObjData->results);
                    $response_data[$q_result_id]['total_questions'] = countSubItemsOnly($results);
                }


                if (!empty($resultObjData->attempts)) {
                    foreach ($resultObjData->attempts as $attemptObj) {
                        if (!empty($attemptObj->quizz_result_questions)) {
                            foreach ($attemptObj->quizz_result_questions as $resultQuestionObj) {
                                $response_data[$q_result_id]['attempted'] += ($resultQuestionObj->status != 'waiting') ? 1 : 0;
                                $response_data[$q_result_id]['correct'] += ($resultQuestionObj->status == 'correct') ? 1 : 0;
                                $response_data[$q_result_id]['incorrect'] += ($resultQuestionObj->status == 'incorrect') ? 1 : 0;
                                $response_data[$q_result_id]['in_review'] += ($resultQuestionObj->status == 'in_review') ? 1 : 0;
                                $resultQuestionObj->time_consumed = $resultQuestionObj->time_consumed;
                                if ($resultObjData->quiz_result_type == 'timestables_assignment') {
                                    $resultQuestionObj->time_consumed = ($resultQuestionObj->time_consumed / 10);
                                }
                                $response_data[$q_result_id]['time_consumed'] += $resultQuestionObj->time_consumed;
                                if ($resultQuestionObj->status == 'correct') {
                                    $response_data[$q_result_id]['time_consumed_corrected'] += $resultQuestionObj->time_consumed;
                                }
                                $response_data[$q_result_id]['average_time'] += $resultQuestionObj->average_time;
                                if (isset($user_mastered_words[$resultQuestionObj->question_id])) {
                                    if (!isset($questions_ids[$resultQuestionObj->question_id])) {
                                        $response_data[$q_result_id]['mastered_words'] += 1;
                                        $questions_ids[$resultQuestionObj->question_id] = $resultQuestionObj->question_id;
                                    }
                                }
                                if (isset($user_in_progress_words[$resultQuestionObj->question_id])) {
                                    if (!isset($questions_ids[$resultQuestionObj->question_id])) {
                                        $response_data[$q_result_id]['in_progress_words'] += 1;
                                        $questions_ids[$resultQuestionObj->question_id] = $resultQuestionObj->question_id;
                                    }
                                }
                                if (isset($user_non_mastered_words[$resultQuestionObj->question_id])) {
                                    if (!isset($questions_ids[$resultQuestionObj->question_id])) {
                                        $response_data[$q_result_id]['non_mastered_words'] += 1;
                                        $questions_ids[$resultQuestionObj->question_id] = $resultQuestionObj->question_id;
                                    }
                                }
                            }
                        }
                    }
                }
                $response_data[$q_result_id]['unanswered'] = count($questions_list) - $response_data[$q_result_id]['attempted'];
                $percentage = ($response_data[$q_result_id]['correct'] > 0) ? ($response_data[$q_result_id]['correct'] * 100) / $response_data[$q_result_id]['attempted'] : 0;
                $response_data[$q_result_id]['percentage'] = round($percentage, 2);

                $total_percentage = ($response_data[$q_result_id]['correct'] > 0) ? ($response_data[$q_result_id]['correct'] * 100) / $response_data[$q_result_id]['total_questions'] : 0;
                $response_data[$q_result_id]['total_percentage'] = round($total_percentage, 2);


                $time_consumed_correct_average = ($response_data[$q_result_id]['time_consumed_corrected'] > 0) ? ($response_data[$q_result_id]['time_consumed_corrected']) / $response_data[$q_result_id]['correct'] : 0;
                $response_data[$q_result_id]['time_consumed_correct_average'] = round($time_consumed_correct_average, 2);


                $time_consumed = isset($response_data[$q_result_id]['time_consumed']) ? $response_data[$q_result_id]['time_consumed'] : 0;
                //$time_consumed = ( $time_consumed > 0)? ($time_consumed/60) : 0;
                $average_time = isset($response_data[$q_result_id]['average_time']) ? $response_data[$q_result_id]['average_time'] : 0;
                $average_time = $average_time * 60;
                $response_data[$q_result_id]['time_consumed'] = gmdate("i:s", $time_consumed);
                $response_data[$q_result_id]['average_time'] = gmdate("i:s", $average_time);
                $response_data[$q_result_id] = (object)$response_data[$q_result_id];


            }
        }

        return (object)$response_data;
    }

    /*
     * Graph Data
     */

    public function prepare_graph_data($result_type, $user_id = 0)
    {
        if( $user_id == 0) {
            $user = getUser();
            $user_id = $user->id;
        }
        $user_id = is_array( $user_id )? $user_id : array($user_id);
        $QuizzResultQuestions = QuizzResultQuestions::where('quiz_result_type', $result_type)->where('status', '!=', 'waiting');
        $QuizzResultQuestions   = $QuizzResultQuestions->whereIn('user_id', $user_id);
        $QuizzResultQuestions = $QuizzResultQuestions->get();
        return $QuizzResultQuestions;
    }

    public function user_graph_data($QuizzResultQuestions, $return_type, $start_date = '', $end_date = '',$user_id = 0)
    {

        if( $user_id == 0) {
           $user = getUser();
           $user_id = $user->id;
       }

        /*$year = 2023;
        $QuizzResultQuestions = $QuizzResultQuestions->filter(function ($QuizzResultQuestions) use ($year) {
            $createdAt = Carbon::parse($QuizzResultQuestions->attempted_at);
            return $createdAt->year == $year;
        });*/
        $group_by_string = '';

        if ($return_type == 'weekly') {
            $start_date = strtotime('monday this week');
            $end_date = strtotime('sunday this week');
            $QuizzResultQuestions = $QuizzResultQuestions->whereBetween('attempted_at', [
                $start_date,
                $end_date
            ]);
            $group_by_string = 'l';
        }
        if ($return_type == 'monthly') {
            $start_date = strtotime('january this year');
            $end_date = strtotime('december this week');
            $QuizzResultQuestions = $QuizzResultQuestions->whereBetween('attempted_at', [
                $start_date,
                $end_date
            ]);
            $group_by_string = 'F';
        }
        if ($return_type == 'yearly') {
            $group_by_string = 'Y';

        }
        if ($return_type == 'hourly') {
            $date = date('Y-m-d');
            $start_date = strtotime(date('Y-m-d', strtotime($date . ' -1 day')));
            $end_date = strtotime(date('Y-m-d', strtotime($date . ' +1 day')));

            $QuizzResultQuestions = $QuizzResultQuestions->where('attempted_at', '>', $start_date)->where('attempted_at', '<', $end_date);
            $group_by_string = 'h';

        }
        if ($return_type == 'daily') {
            $date = strtotime(date('Y-m-d'));
            $start_date = strtotime(date('Y-m-01 00:00:00', $date));
            $end_date = strtotime(date('Y-m-t 12:59:59', $date));
            $QuizzResultQuestions = $QuizzResultQuestions->whereBetween('attempted_at', [
                $start_date,
                $end_date
            ]);
            $group_by_string = 'd';
        }

        if ($return_type == 'custom') {
            $QuizzResultQuestions = $QuizzResultQuestions->whereBetween('attempted_at', [
                $start_date,
                $end_date
            ]);
            $dates_difference = $this->dates_difference($start_date, $end_date);
            //pre($dates_difference);
            if ($dates_difference->years > 0) {
                $group_by_string = 'Y';
                $return_type = 'yearly';
            }
            if ($dates_difference->years == 0 && $dates_difference->months > 0) {
                $group_by_string = 'F';
                $return_type = 'monthly';
            }
            if ($dates_difference->years == 0 && $dates_difference->months == 0 && $dates_difference->days > 0) {
                $group_by_string = 'd';
                $return_type = 'daily';
            }
            if ($dates_difference->years == 0 && $dates_difference->months == 0 && $dates_difference->days == 0) {
                $group_by_string = 'h';
                $return_type = 'hourly';
            }
        }

        $QuizzResultQuestions = $QuizzResultQuestions->groupBy(function ($QuizzResultQuestionsQuery) use ($group_by_string) {
            return date($group_by_string, $QuizzResultQuestionsQuery->attempted_at);
        });


        $QuizzResultQuestionsResults = $QuizzResultQuestions;

        $prepare_result = $keys_array = array();
        if (!empty($QuizzResultQuestionsResults)) {
            foreach ($QuizzResultQuestionsResults as $data_key => $QuizzResultQuestionsObj) {
                $questions_attempted = $QuizzResultQuestionsObj->count();
                $coins_earned = $QuizzResultQuestionsObj->where('status', 'correct')->sum('quiz_grade');
                $keys_array[] = $data_key;
                $prepare_result[$data_key] = array(
                    'questions_attempted' => $questions_attempted,
                    'coins_earned'        => $coins_earned,
                );
            }
        }
        //pre($prepare_result);
        if ($return_type == 'weekly') {
            $keys_array = array(
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
                'Sunday'
            );
        }

        if ($return_type == 'monthly') {
            $keys_array = array(
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            );
        }

        if ($return_type == 'hourly') {
            $keys_array = array(
                '01',
                '02',
                '03',
                '04',
                '05',
                '06',
                '07',
                '08',
                '09',
                '10',
                '11',
                '12',
                '13',
                '14',
                '15',
                '16',
                '17',
                '18',
                '19',
                '20',
                '21',
                '22',
                '23',
                '24',
            );
        }

        if ($return_type == 'daily') {
            $keys_array = array(
                '01',
                '02',
                '03',
                '04',
                '05',
                '06',
                '07',
                '08',
                '09',
                '10',
                '11',
                '12',
                '13',
                '14',
                '15',
                '16',
                '17',
                '18',
                '19',
                '20',
                '21',
                '22',
                '23',
                '24',
                '25',
                '26',
                '27',
                '28',
                '29',
                '30',
            );
        }

        $options_array = $questions_attempted_array = $coins_earned_array = array();
        if (!empty($keys_array)) {
            foreach ($keys_array as $key_index) {
                $final_results[$key_index] = isset($prepare_result[$key_index]) ? $prepare_result[$key_index] : array(
                    'questions_attempted' => 0,
                    'coins_earned'        => 0
                );
                $options_array[] = $key_index;
                $questions_attempted_array[] = $final_results[$key_index]['questions_attempted'];
                $coins_earned_array[] = $final_results[$key_index]['coins_earned'];

            }
        }

        //pre($options_array);
        $options_values = json_encode($options_array);
        $questions_attempted_values = json_encode($questions_attempted_array);
        $coins_earned_values = json_encode($coins_earned_array);
        return (object)array(
            'options_values'             => $options_values,
            'questions_attempted_values' => $questions_attempted_values,
            'coins_earned_values'        => $coins_earned_values,
        );
    }


    public function dates_difference($date1, $date2)
    {

        $diff = abs($date2 - $date1);

        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        return (object)array(
            'years'  => $years,
            'months' => $months,
            'days'   => $days,
        );
    }


    /*
     * After Attempt is completed
     *
     * @params Result OBj
     * item @ quizResult Obj
     *
     */
    public function after_attempt_complete($resultLogObj)
    {
        $user = getUser();
        $quiz_result_type = $resultLogObj->quiz_result_type;

        /*
         * Vocabulary Quiz Test Completion Start
         */
        if ($quiz_result_type == 'vocabulary') {
            $quizObj = $resultLogObj->parentQuiz;
            $treasure_after = isset( $quizObj->treasure_after )? $quizObj->treasure_after : 'no_treasure';
            $treasure_coins = isset( $quizObj->treasure_coins )? $quizObj->treasure_coins : 'treasure_coins';
            $total_quiz_questions = isset( $quizObj->quizQuestionsList )? count($quizObj->quizQuestionsList) : 0;

            $total_questions = isset($resultLogObj->questions_list) ? json_decode($resultLogObj->questions_list) : array();

            $total_attempted_questions = $quizObj->parentResultsQuestions->where('quiz_level', $resultLogObj->quiz_level)->count();
            $correct_percentage = ($total_attempted_questions > 0)? round(($total_attempted_questions *100) / $total_quiz_questions) : 0;

            if ($correct_percentage >= 80) {

                $UsersAchievedLevelsObj = UsersAchievedLevels::where('parent_id', $resultLogObj->parent_type_id)->where('parent_type', $resultLogObj->quiz_result_type)->first();
                if (isset($UsersAchievedLevelsObj->id)) {
                    $quiz_level = $resultLogObj->quiz_level;
                    $level_easy = ($quiz_level == 'easy') ? 1 : $UsersAchievedLevelsObj->level_easy;
                    $level_medium = ($quiz_level == 'medium') ? 1 : $UsersAchievedLevelsObj->level_medium;
                    $level_hard = ($quiz_level == 'hard') ? 1 : $UsersAchievedLevelsObj->level_hard;
                    $UsersAchievedLevelsObj->update([
                        'level_easy'   => $level_easy,
                        'level_medium' => $level_medium,
                        'level_hard'   => $level_hard,
                        'updated_at'   => time(),
                    ]);

                } else {
                    $quiz_level = $resultLogObj->quiz_level;
                    $level_easy = ($quiz_level == 'easy') ? 1 : 0;
                    $level_medium = ($quiz_level == 'medium') ? 1 : 0;
                    $level_hard = ($quiz_level == 'hard') ? 1 : 0;
                    $UsersAchievedLevelsObj = UsersAchievedLevels::create([
                        'user_id'      => $user->id,
                        'parent_id'    => $resultLogObj->parent_type_id,
                        'parent_type'  => $resultLogObj->quiz_result_type,
                        'level_easy'   => $level_easy,
                        'level_medium' => $level_medium,
                        'level_hard'   => $level_hard,
                        'updated_at'   => time(),
                        'created_at'   => time(),
                    ]);
                    $treasure_after_level = '';
                    $treasure_after_level = ($treasure_after == 'after_easy')? 'easy' : $treasure_after_level;
                    $treasure_after_level = ($treasure_after == 'after_medium')? 'medium' : $treasure_after_level;
                    $treasure_after_level = ($treasure_after == 'after_hard')? 'hard' : $treasure_after_level;
                    if( $treasure_after_level == $quiz_level) {
                        RewardAccounting::create([
                            'user_id'       => $user->id,
                            'item_id'       => 0,
                            'type'          => 'coins',
                            'score'         => $treasure_coins,
                            'status'        => 'addiction',
                            'created_at'    => time(),
                            'parent_id'     => $quizObj->id,
                            'parent_type'   => 'vocabulary_treasure',
                            'full_data'     => '',
                            'updated_at'    => time(),
                            'assignment_id' => 0,
                            'result_id'     => $resultLogObj->id,
                        ]);
                    }
                }
            }
        }

        /*
        * Vocabulary Quiz Test Completion End
        */
		
		if ($quiz_result_type == 'learning_journey') {
			$StudentJourneyItem = StudentJourneyItems::where('result_id', $resultLogObj->id)->where('student_id', $user->id)->where('status','waiting')->first();
			$StudentJourneyItem->update(['status' => 'completed', 'completed_at' => time()]);
			
			
			$currentItem = LearningJourneyItems::find($StudentJourneyItem->learning_journey_item_id);
			$sortedItems = LearningJourneyItems::get();

			$nextItem = null;
			foreach ($sortedItems as $index => $item) {
				if ($item->id == $currentItem->id) {
					if (isset($sortedItems[$index + 1])) {
						$nextItem = $sortedItems[$index + 1];
					}
					break;
				}
			}
			if( isset( $nextItem->item_type ) && $nextItem->item_type == 'treasure'){
				$StudentJourneyItems = StudentJourneyItems::create([
					'student_id'          => $user->id,
					'learning_journey_item_id'	=> $nextItem->id,
					'status'           => 'completed',
					'item_type'        => $nextItem->item_type,
					'item_value'       => $nextItem->item_value,
					'created_at'       => time(),
					'completed_at'       => time(),
					'result_id'       => $resultLogObj->id,
				]);
				RewardAccounting::create([
					'user_id'       => $user->id,
					'item_id'       => 0,
					'type'          => 'coins',
					'score'         => $nextItem->item_value,
					'status'        => 'addiction',
					'created_at'    => time(),
					'parent_id'     => $nextItem->id,
					'parent_type'   => 'journey_treasure',
					'full_data'     => '',
					'updated_at'    => time(),
					'assignment_id' => 0,
					'result_id'     => $resultLogObj->id,
				]);
			}
			
		}
		
		$DailyQuestsController = new DailyQuestsController();
        $DailyQuestsController->questCompletionCheck($resultLogObj);
    }

    /*
     * Get Result Correct Questions Percentage
     *
     *
     */
    public function get_percetange_corrct_answer($resultLogObj)
    {
        $user = getUser();
        $total_questions = $resultLogObj->quizz_result_questions_list->count();
        $total_correct_answers = $resultLogObj->quizz_result_questions_list->where('status', 'correct')->count();
        $correct_percentage = round(($total_correct_answers * 100) / $total_questions);
        return $correct_percentage;
    }


    /*
     * Returns the Questions List based on type and not attempted / incorrect
     *
     * @params Array
     * item @ quiz Obj
     * @calling sub functions to return the specific data based on type
     *
     * @return questions_list Array
     */
    public function getQuizQuestionsList($quiz, $quiz_level = '', $learning_journey = 'no', $assignment_id = 0, $include_question_ids = array(), $is_new = 'no')
    {

        $entrance_exams = array(
            'sats',
            '11plus',
            'independent_exams',
            'iseb',
            'cat4'
        );
        $QuizzesResultID = 0;
        $questions_list = array();
        if (!empty($quiz->quizQuestionsList)) {
            foreach ($quiz->quizQuestionsList as $questionlistData) {
                $question_id = ($quiz->quiz_type == 'assignment') ? $questionlistData->reference_question_id : $questionlistData->question_id;
				if( !empty( $include_question_ids )){
					if( in_array( $question_id, $include_question_ids)){
						$questions_list[] = $question_id;
					}
				}else{
					$questions_list[] = $question_id;
				}
                
            }
        }

        if (in_array($quiz->quiz_type, $entrance_exams) && $quiz->mock_type == 'mock_practice') {
            $questions_list_data_array = $this->get_mock_practice_questions_list($quiz, $questions_list);
            $questions_list = isset($questions_list_data_array['questions_list']) ? $questions_list_data_array['questions_list'] : array();
            $other_data = isset($questions_list_data_array['other_data']) ? $questions_list_data_array['other_data'] : '';
        }

        if ($quiz->quiz_type == 'practice') {
			if( $learning_journey == 'yes'){
				$questions_list_data_array = $this->get_learning_jounrney_questions_list($quiz, $questions_list);
			}else{
				$questions_list_data_array = $this->get_course_practice_questions_list($quiz, $questions_list);
			}
            $QuizzesResultID = isset($questions_list_data_array['QuizzesResultID']) ? $questions_list_data_array['QuizzesResultID'] : 0;
            $questions_list = isset($questions_list_data_array['questions_list']) ? $questions_list_data_array['questions_list'] : array();
            $other_data = isset($questions_list_data_array['other_data']) ? $questions_list_data_array['other_data'] : '';
            $quiz_breakdown = isset($questions_list_data_array['quiz_breakdown']) ? $questions_list_data_array['quiz_breakdown'] : '';
        }
		
		if ($quiz->quiz_type == 'vocabulary') {
            $questions_list_data_array = $this->get_vocabulary_questions_list($quiz, $questions_list, $quiz_level, $assignment_id, $is_new);
			$QuizzesResultID = isset($questions_list_data_array['QuizzesResultID']) ? $questions_list_data_array['QuizzesResultID'] : 0;
            $questions_list = isset($questions_list_data_array['questions_list']) ? $questions_list_data_array['questions_list'] : array();
            $other_data = isset($questions_list_data_array['other_data']) ? $questions_list_data_array['other_data'] : '';
            $quiz_breakdown = isset($questions_list_data_array['quiz_breakdown']) ? $questions_list_data_array['quiz_breakdown'] : '';

        }

        return array(
            'questions_list' => $questions_list,
            'other_data'     => isset($other_data) ? $other_data : '',
            'quiz_breakdown' => isset($quiz_breakdown) ? $quiz_breakdown : '',
            'QuizzesResultID' => $QuizzesResultID,
        );

    }

    /*
     * Returns the Mock Practice questions List (Quiz Type is Entrance Exam and Type is Mock Practice)
     *
     * @params Array
     * item @ quiz Obj
     *
     * @return questions_list Array
     */
    public function get_mock_practice_questions_list($quiz, $questions_list)
    {

		$user = getUser();
        $newQuizStart = QuizzesResult::where('parent_type_id', $quiz->id)->where('user_id', $user->id)->where('status', 'waiting')->first();
        if( isset( $newQuizStart->id)){
            $other_data = json_decode($newQuizStart->other_data);
            $questions_list = QuizzResultQuestions::whereIn('id', json_decode($newQuizStart->questions_list))->pluck('question_id')->toArray();
            return array(
                'questions_list' => $questions_list,
            );
        }
        $quizQuestionsList = array();

        $mock_exam_settings = json_decode($quiz->mock_exam_settings);
        $mock_exam_settings = (array)$mock_exam_settings;
		

        if (!empty($mock_exam_settings)) {
            foreach ($mock_exam_settings as $sub_chapter_id => $no_of_test_questions) {
                $questions_list_array = QuizzesQuestion::where('sub_chapter_id', $sub_chapter_id)->pluck('id')->toArray();
                $corrected_list = QuizzResultQuestions::whereIN('question_id', $questions_list_array)->where('parent_type_id', $quiz->id)->where('status', 'correct')->pluck('question_id')->toArray();
                $questions_list_array = array_diff($questions_list_array, $corrected_list);
                if (count($questions_list_array) < $no_of_test_questions) {
                    $extra_questions_count = ($no_of_test_questions - count($questions_list_array));
                    $correctedQuestionsList = !empty( $corrected_list )? array_limit_length($corrected_list, $extra_questions_count) : array();
                    $questions_list_array = array_merge($questions_list_array, $correctedQuestionsList);
                }
				
                $questions_list_array = array_limit_length($questions_list_array, $no_of_test_questions);
                $quizQuestionsList = array_merge($quizQuestionsList, $questions_list_array);
            }
        }
        $questions_list = $quizQuestionsList;
		
        return array(
            'questions_list' => $questions_list,
        );

    }

    /*
     * Returns the Quiz / Course Practice questions List (Quiz Type is Practice and it is assigned in course)
     *
     * @params Array
     * item @ quiz Obj
     *
     * @return questions_list Array
     */
    public function get_course_practice_questions_list($quiz, $questions_list)
    {

        $user = getUser();
        $newQuizStart = QuizzesResult::where('parent_type_id', $quiz->id)->where('quiz_result_type', 'practice')->where('user_id', $user->id)->where('status', 'waiting')->first();
		$result_questions = isset( $newQuizStart->questions_list)? json_decode($newQuizStart->questions_list) : array();
        $other_data = array();
        $quiz_settings = json_decode($quiz->quiz_settings);
        $quiz_breakdown = $quiz->quiz_settings;
        if( isset( $newQuizStart->id) && !empty( $result_questions )){
            $other_data = json_decode($newQuizStart->other_data);
            $questions_list = QuizzResultQuestions::whereIn('id', json_decode($newQuizStart->questions_list))->pluck('question_id')->toArray();
            return array(
                'questions_list' => $questions_list,
                'other_data'     => $newQuizStart->other_data,
                'quiz_breakdown' => $quiz_breakdown,
                'QuizzesResultID' => $newQuizStart->id,
            );
        }
		if( isset( $newQuizStart->id) && empty( $result_questions )){
			$newQuizStart->delete();
		}
        $questions_limit = array();
        $questions_limit['emerging'] = isset($quiz_settings->Emerging->questions) ? $quiz_settings->Emerging->questions : 0;
        $questions_limit['expected'] = isset($quiz_settings->Expected->questions) ? $quiz_settings->Expected->questions : 0;
        $questions_limit['exceeding'] = isset($quiz_settings->Exceeding->questions) ? $quiz_settings->Exceeding->questions : 0;


        $difficulty_level_array = [
            'emerging'  => 'Emerging',
            'expected'  => 'Expected',
            'exceeding' => 'Exceeding',
        ];

        $questions_list_ids = $questions_list;
		//pre($questions_list_ids);


        $attempted_questions_list = QuizzResultQuestions::whereIn('question_id', $questions_list_ids)->where('parent_type_id', $quiz->id)->where('user_id', $user->id)->where('status', '!=', 'waiting')->pluck('question_id')->toArray();

		$notattempted_questions_list = array_diff($questions_list_ids, $attempted_questions_list);
		

        //working here
        //pre($notattempted_questions_list);


        $questions_list = $practice_breakdown = array();
        if (!empty($difficulty_level_array)) {
            foreach ($difficulty_level_array as $difficulty_level_key => $difficulty_level_label) {

                $breakdown_array = isset($quiz_settings->{$difficulty_level_label}->breakdown) ? $quiz_settings->{$difficulty_level_label}->breakdown : array();

                $breakdown_array = is_array($breakdown_array) ? $breakdown_array : (array)$breakdown_array;
                if (!empty($breakdown_array)) {
                    foreach ($breakdown_array as $question_type => $questions_count) {
                        $questions_count = isset( $other_data->{$difficulty_level_label}->{$question_type})? count($other_data->{$difficulty_level_label}->{$question_type}) : $questions_count;
                        //$questions_list[$difficulty_level_key][$question_type] = QuizzesQuestion::whereIn('id', $questions_list_ids)->where('question_type', $question_type)->where('question_difficulty_level', $difficulty_level_label)->limit($questions_count)->pluck('id')->toArray();
                        $questions_array = QuizzesQuestion::whereIn('id', $questions_list_ids)->where('question_type', $question_type)->where('question_difficulty_level', $difficulty_level_label)->inRandomOrder()->limit($questions_count)->pluck('id')->toArray();
                        if (!empty($questions_array)) {
                            foreach ($questions_array as $questionID) {

                                $resultQuestionObj = QuizzResultQuestions::where('question_id', $questionID)->where('parent_type_id', $quiz->id)->where('user_id', $user->id)->where('status','waiting')->first();
                                if( isset($resultQuestionObj->id)){
                                    $questionOBJ = QuizzesQuestion::where('id','!=', $questionID)->whereNotIn('id', $questions_list)->whereIn('id', $questions_list_ids)->where('question_type', $question_type)->where('question_difficulty_level', $difficulty_level_label)->first();
                                    $questionID = isset( $questionOBJ->id)? $questionOBJ->id : $questionID;
                                }
                                $practice_breakdown[$difficulty_level_label][$question_type][] = $questionID;
                                $questions_list[] = $questionID;
                            }
                        }
                    }
                }
            }
        }
		
        $other_data = json_encode($practice_breakdown);

        return array(
            'questions_list' => $questions_list,
            'other_data'     => $other_data,
            'quiz_breakdown' => $quiz_breakdown,
        );
    }
	
	/*
     * Returns the Quiz / Course Practice questions List (Quiz Type is Practice and it is assigned in course)
     *
     * @params Array
     * item @ quiz Obj
     *
     * @return questions_list Array
     */
    public function get_learning_jounrney_questions_list($quiz, $questions_list)
    {

        $user = getUser();
        $newQuizStart = QuizzesResult::where('parent_type_id', $quiz->id)->where('quiz_result_type', 'learning_journey')->where('user_id', $user->id)->where('status', 'waiting')->first();
		$result_questions = isset( $newQuizStart->questions_list)? json_decode($newQuizStart->questions_list) : array();
        $other_data = array();
        $quiz_settings = json_decode($quiz->quiz_settings);
        $quiz_breakdown = $quiz->quiz_settings;
        if( isset( $newQuizStart->id) && !empty( $result_questions )){
            $other_data = json_decode($newQuizStart->other_data);
			$questions_list = json_decode($newQuizStart->questions_list);
			$questions_list = QuizzResultQuestions::whereIn('id', $questions_list)
				->orderByRaw(\DB::raw("FIELD(id, " . implode(',', $questions_list) . ")"))
				->pluck('question_id')
				->toArray();
			
            return array(
                'questions_list' => $questions_list,
                'other_data'     => $newQuizStart->other_data,
                'quiz_breakdown' => $quiz_breakdown,
                'QuizzesResultID' => $newQuizStart->id,
            );
        }
		if( isset( $newQuizStart->id) && empty( $result_questions )){
			$newQuizStart->delete();
		}
        $questions_limit = array();
        $questions_limit['emerging'] = isset($quiz_settings->Emerging->questions) ? $quiz_settings->Emerging->questions : 0;
        $questions_limit['expected'] = isset($quiz_settings->Expected->questions) ? $quiz_settings->Expected->questions : 0;
        $questions_limit['exceeding'] = isset($quiz_settings->Exceeding->questions) ? $quiz_settings->Exceeding->questions : 0;


        $difficulty_level_array = [
            'emerging'  => 'Emerging',
            'expected'  => 'Expected',
            'exceeding' => 'Exceeding',
        ];

        $questions_list_ids = $questions_list;


        $attempted_questions_list = QuizzResultQuestions::whereIn('question_id', $questions_list_ids)->where('parent_type_id', $quiz->id)->where('user_id', $user->id)->where('status', '!=', 'waiting')->pluck('question_id')->toArray();

		$notattempted_questions_list = array_diff($questions_list_ids, $attempted_questions_list);
		

        //working here
        //pre($notattempted_questions_list);


        $questions_list = $practice_breakdown = array();
        if (!empty($difficulty_level_array)) {
            foreach ($difficulty_level_array as $difficulty_level_key => $difficulty_level_label) {

                $breakdown_array = isset($quiz_settings->{$difficulty_level_label}->breakdown) ? $quiz_settings->{$difficulty_level_label}->breakdown : array();

                $breakdown_array = is_array($breakdown_array) ? $breakdown_array : (array)$breakdown_array;
                if (!empty($breakdown_array)) {
                    foreach ($breakdown_array as $question_type => $questions_count) {
                        $questions_count = isset( $other_data->{$difficulty_level_label}->{$question_type})? count($other_data->{$difficulty_level_label}->{$question_type}) : $questions_count;
                        //$questions_list[$difficulty_level_key][$question_type] = QuizzesQuestion::whereIn('id', $questions_list_ids)->where('question_type', $question_type)->where('question_difficulty_level', $difficulty_level_label)->limit($questions_count)->pluck('id')->toArray();
                        $questions_array = QuizzesQuestion::whereIn('id', $questions_list_ids)->where('question_type', $question_type)->where('question_difficulty_level', $difficulty_level_label)->inRandomOrder()->limit($questions_count)->pluck('id')->toArray();
                        if (!empty($questions_array)) {
                            foreach ($questions_array as $questionID) {

                                $resultQuestionObj = QuizzResultQuestions::where('question_id', $questionID)->where('parent_type_id', $quiz->id)->where('user_id', $user->id)->where('status','waiting')->first();
                                if( isset($resultQuestionObj->id)){
                                    $questionOBJ = QuizzesQuestion::where('id','!=', $questionID)->whereNotIn('id', $questions_list)->whereIn('id', $questions_list_ids)->where('question_type', $question_type)->where('question_difficulty_level', $difficulty_level_label)->first();
                                    $questionID = isset( $questionOBJ->id)? $questionOBJ->id : $questionID;
                                }
                                $practice_breakdown[$difficulty_level_label][$question_type][] = $questionID;
                                $questions_list[] = $questionID;
                            }
                        }
                    }
                }
            }
        }
        $other_data = json_encode($practice_breakdown);

        return array(
            'questions_list' => $questions_list,
            'other_data'     => $other_data,
            'quiz_breakdown' => $quiz_breakdown,
        );
    }

    /*
     * Returns the Vocabulary questions List (Quiz Type is Vocabulary)
     *
     * @params Array
     * item @ quiz Obj
     *
     * @return questions_list Array
     */
    public function get_vocabulary_questions_list($quiz, $questions_list, $quiz_level, $assignment_id = 0, $is_new = 'no')
    {
		$user = getUser();
		$parent_type_id = ($assignment_id > 0)? $assignment_id : $quiz->id;
		$newQuizStart = QuizzesResult::where('parent_type_id', $parent_type_id)->where('quiz_level', $quiz_level)->where('user_id', $user->id)->where('status', 'waiting')->first();
		if( $is_new == 'yes'){
			$newQuizStart = (object) array();
		}
		if( isset( $newQuizStart->id)){
			$questions_list = json_decode($newQuizStart->questions_list);
			$questions_list = QuizzResultQuestions::whereIn('id', $questions_list)	
				->orderByRaw(\DB::raw("FIELD(id, " . implode(',', $questions_list) . ")"))
				->pluck('question_id')
				->toArray();
		}else{
			shuffle($questions_list);
			$corrected_list = QuizzResultQuestions::whereIN('question_id', $questions_list)->where('parent_type_id', $quiz->id)->where('quiz_level', $quiz_level)->where('status', 'correct')->pluck('question_id')->toArray();
			$incorrect_list = QuizzResultQuestions::whereIN('question_id', $questions_list)->whereNotIn('question_id', $corrected_list)->where('quiz_level', $quiz_level)->where('parent_type_id', $quiz->id)->where('status', 'incorrect')->pluck('question_id')->toArray();
			$excludedValues = array_merge($corrected_list, $incorrect_list);

			$not_attempted_list = array_diff($questions_list, $excludedValues);
			$corrected_list = array_diff($corrected_list, $incorrect_list);
			$incorrect_list = array_diff($incorrect_list, $corrected_list);

			$questions_list = array_merge($not_attempted_list, $incorrect_list, $corrected_list);

		}

        return array(
            'questions_list' => $questions_list,
			'QuizzesResultID' => isset( $newQuizStart->id )? $newQuizStart->id : 0,
        );
    }


    public function resultTimestablesAverage($result_id){
        $user = getUser();
        $user = User::find($user->id);

        $timestables_data = json_decode($user->timestables_data);
        $timestables_data = is_array($timestables_data) ? $timestables_data : $this->convertToArrayRecursive($timestables_data);
        $timestables_data = is_array($timestables_data)? $timestables_data : array();
        $locked_tables = json_decode($user->locked_tables);
        $locked_tables = is_array($locked_tables) ? $locked_tables : $this->convertToArrayRecursive($locked_tables);
        $locked_tables = is_array($locked_tables)? $locked_tables : array();

        $resultObj = QuizzesResult::find($result_id);

        $groupedResults = $resultObj->quizz_result_timestables_grouped->groupBy('parent_type_id');

        // Define an array to store the processed data
        $processedData = [];

        foreach ($groupedResults as $parentTypeId => $group) {
            // Count total records
            $totalRecords = $group->count();

            // Count correct and incorrect statuses
            $correctCount = $group->where('status', 'correct')->count();
            $incorrectCount = $group->where('status', 'incorrect')->count();

            $totalTimeConsumed = $group->sum('time_consumed');

            $totalTimeConsumed += $incorrectCount * 100;

            $totalTimeConsumed = $totalTimeConsumed / 10;

            // Calculate average time consumed in seconds
            $averageTimeConsumed = $totalTimeConsumed / ($totalRecords); // Convert milliseconds to seconds

            $averageTimeConsumed = round($averageTimeConsumed, 2);

            // Store the processed data
            $processedData[$parentTypeId] = [
                'table_no'              => $parentTypeId,
                'total_records'         => $totalRecords,
                'corrected'             => $correctCount,
                'average_time_consumed' => $averageTimeConsumed,
            ];
        }

        $timestables_data = json_decode($user->timestables_data);
        $timestables_data = is_array($timestables_data) ? $timestables_data : $this->convertToArrayRecursive($timestables_data);
        $timestables_data_updated = $timestables_data;

        $unlocked_tables = array();

        if (!empty($processedData)) {
            foreach ($processedData as $table_no => $tableData) {

                $previous_total_records = isset($timestables_data[$table_no]['total_records']) ? $timestables_data[$table_no]['total_records'] : 0;
                $new_total_records = isset($tableData['total_records']) ? $tableData['total_records'] : 0;

                $previous_corrected = isset($timestables_data[$table_no]['corrected']) ? $timestables_data[$table_no]['corrected'] : 0;
                $new_corrected = isset($tableData['corrected']) ? $tableData['corrected'] : 0;

                $previous_average = isset($timestables_data[$table_no]['average_time_consumed']) ? $timestables_data[$table_no]['average_time_consumed'] : 0;
                $new_average = isset($tableData['average_time_consumed']) ? $tableData['average_time_consumed'] : 0;

                $total_sum = ($previous_total_records * $previous_average) + ($new_total_records * $new_average);

                $total_records = $previous_total_records + $new_total_records;
                $timestables_data_updated[$table_no]['total_records'] = $previous_total_records + $new_total_records;
                $timestables_data_updated[$table_no]['corrected'] = $previous_corrected + $new_corrected;

                $latest_average = $total_sum / $total_records;
                // Calculate the total average
                $timestables_data_updated[$table_no]['average_time_consumed'] = $latest_average;
                if ($total_records < 500) {
                    continue;
                }
                if ($latest_average <= 3) {
                    if (!in_array($table_no, $locked_tables)) {
                        $locked_tables[] = $table_no;
                    }
                }
                if ($latest_average >= 3) {
                    if (in_array($table_no, $locked_tables)) {
                        $unlocked_tables[] = $table_no;
                    }
                }
            }
        }
        $user_locked_tables = array_diff($locked_tables, $unlocked_tables);
        $user_locked_tables = array_values($user_locked_tables);
        $user_locked_tables = array_map('intval', $user_locked_tables);

        //pre($timestables_data_updated, false);
        $user->update(['timestables_data'=> json_encode($timestables_data_updated), 'locked_tables'=> json_encode($user_locked_tables, JSON_UNESCAPED_SLASHES)]);

    }

    public function convertToArrayRecursive($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->convertToArrayRecursive($value);
            }
            return $data;
        } elseif (is_object($data)) {
            $data = (array)$data;
            foreach ($data as $key => $value) {
                $data[$key] = $this->convertToArrayRecursive($value);
            }
            return $data;
        } else {
            return $data;
        }
    }
    
    public function afterQuestionCorrect($parent_type){
        $user = auth()->user();
        $current_game_time = $user->game_time;
        $alloted_game_time = gameTime($parent_type);
        $user->update(['game_time'=> $current_game_time+$alloted_game_time]);
    }
	
	public function get_questions_results($vocabulary_words, $quiz_result_type = '', $attempt_mode = ''){
		$questionIDs = array_keys($vocabulary_words);
        $user = auth()->user();
		$results = QuizzResultQuestions::whereIn('question_id', $questionIDs)
			->where('quiz_result_type', $quiz_result_type)
			->where('user_id', $user->id)
			->get();

		$response = [];
		foreach ($questionIDs as $questionID) {
			$response[$questionID]['total_attempts'] = $results->where('question_id', $questionID)->where('status', '!=', 'waiting')->count();
			$response[$questionID]['correct_attempts'] = $results->where('question_id', $questionID)->where('status', 'correct')->count();
			$response[$questionID]['incorrect_attempts'] = $results->where('question_id', $questionID)->where('status', 'wrong')->count();
		}
        return $response;
    }
	
	
	


}
