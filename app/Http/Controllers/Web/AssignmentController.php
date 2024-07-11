<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\Models\AssignedAssignments;
use App\Models\Quiz;
use App\Models\QuizzesQuestion;
use App\Models\QuizzResultQuestions;
use App\Models\RewardAccounting;
use App\Models\UserAssignedTopics;
use App\Models\QuizzesResult;
use App\Models\QuizzAttempts;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class AssignmentController extends Controller
{


    public function assignment(Request $request, $assignment_id)
    {
        $UserAssignedTopicsObj = UserAssignedTopics::find($assignment_id);
        $assignment_type = $UserAssignedTopicsObj->StudentAssignmentData->assignment_type;
        if ($assignment_type == 'timestables') {
            return $this->timestablesAssignment($UserAssignedTopicsObj);
        } elseif($assignment_type == 'learning_journey'){
			return $this->learningAssignmentView($UserAssignedTopicsObj);
		}else {
            return $this->assignmentView($UserAssignedTopicsObj);
        }

    }

    public function timestablesAssignment($UserAssignedTopicsObj)
    {

        $user = auth()->user();


        $no_of_attempts = $UserAssignedTopicsObj->StudentAssignmentData->no_of_attempts;
        $total_attempts = QuizzesResult::where('parent_type_id', $UserAssignedTopicsObj->id)->where('user_id', $user->id)->where('status', '!=', 'waiting')->count();

        if ($total_attempts >= $no_of_attempts) {
            return view('web.default.quizzes.unauthorized');
        }

        if ($UserAssignedTopicsObj->StudentAssignmentData->status != 'active' || $UserAssignedTopicsObj->status != 'active') {
            return view('web.default.quizzes.unauthorized');
        }

        $question_type = 'multiplication';
        $no_of_questions = $UserAssignedTopicsObj->StudentAssignmentData->no_of_questions;
        $tables_numbers = json_decode($UserAssignedTopicsObj->StudentAssignmentData->tables_no);
        $tables_types = [];

        if ($question_type == 'multiplication' || $question_type == 'multiplication_division') {
            $tables_types[] = 'x';
        }
        if ($question_type == 'division' || $question_type == 'multiplication_division') {
            $tables_types[] = '÷';
        }
        $total_questions = $no_of_questions;
        $marks = 1;


        $questions_list = $already_exists = array();


        $max_questions = $no_of_questions;//20;
        $current_question_max = 1;
        $questions_no_array = [];
        while ($current_question_max <= $max_questions) {
            $questions_no_array[$current_question_max] = $current_question_max;
            $current_question_max++;
        }

        $questions_count = 1;
        if ($total_questions > 0) {
            while ($questions_count <= $total_questions) {

                $limit = 12;
                $table_no = isset($tables_numbers[array_rand($tables_numbers)]) ? $tables_numbers[array_rand($tables_numbers)] : 0;
                $type = isset($tables_types[array_rand($tables_types)]) ? $tables_types[array_rand($tables_types)] : 0;
                $questions_no_array = array_values($questions_no_array);
                //pre($questions_no_array);
                shuffle($questions_no_array);
                $dynamic_min = array_keys($questions_no_array, min($questions_no_array))[0];
                $dynamic_max = array_keys($questions_no_array, max($questions_no_array))[0];
                $dynamic_max = ($dynamic_max > $limit) ? $limit : $dynamic_max;
                $dynamic_no = rand($dynamic_min, $dynamic_max);
                $questions_no_dynamic = isset($questions_no_array[$dynamic_no]) ? $questions_no_array[$dynamic_no] : 0;
                if (isset($questions_no_array[$dynamic_no])) {
                    unset($questions_no_array[$dynamic_no]);
                    $questions_no_array = array_values($questions_no_array);
                }

                $last_value = ($questions_no_dynamic) * $table_no;
                $from_value = ($type == '÷') ? $last_value : $table_no;
                $min = 2;
                $min = ($type == '÷') ? 1 : $min;
                $limit = ($type == '÷') ? ($table_no * $limit) : $limit;
                //$to_value = rand($min, $limit);
                $to_value = ($type == '÷') ? $table_no : $questions_no_dynamic;
                $to_value = ($to_value > $limit) ? rand($min, $limit) : $to_value;


                $questions_array_list[] = (object)array(
                    'from'     => $from_value,
                    'to'       => $to_value,
                    'type'     => $type,
                    'table_no' => $table_no,
                    'marks'    => $marks,
                );
                $questions_count++;
            }


            shuffle($questions_array_list);

            $question_show_count = 0;

            while ($question_show_count < $no_of_questions) {
                if ($question_show_count < 20) {
                    $questions_list[] = (object)isset($questions_array_list[$question_show_count]) ? $questions_array_list[$question_show_count] : array();
                } else {
                    $question_counter = rand(2, 19);
                    $questions_list[] = (object)isset($questions_array_list[$question_counter]) ? $questions_array_list[$question_counter] : array();
                }
                $question_show_count++;

            }


            $QuizzesResult = QuizzesResult::create([
                'user_id'          => $user->id,
                'results'          => json_encode($questions_list),
                'user_grade'       => 0,
                'status'           => 'waiting',
                'created_at'       => time(),
                'parent_type_id'   => $UserAssignedTopicsObj->id,
                'quiz_result_type' => 'timestables_assignment',
                'no_of_attempts'   => $no_of_attempts,
                'other_data'       => json_encode($questions_list),
            ]);

            $QuizzAttempts = QuizzAttempts::create([
                'quiz_result_id' => $QuizzesResult->id,
                'user_id'        => $user->id,
                'start_grade'    => $QuizzesResult->user_grade,
                'end_grade'      => 0,
                'created_at'     => time(),
                'parent_type_id' => $QuizzesResult->parent_type_id,
                'attempt_type'   => $QuizzesResult->quiz_result_type,
            ]);
            $attempt_log_id = createAttemptLog($QuizzAttempts->id, 'Session Started', 'started');
        }


        $data = [
            'pageTitle'      => 'Start',
            'questions_list' => $questions_list,
            'QuizzAttempts'  => $QuizzAttempts,
            'duration_type'  => $UserAssignedTopicsObj->StudentAssignmentData->duration_type,
            'practice_time'  => ($UserAssignedTopicsObj->StudentAssignmentData->practice_time * 60),
            'time_interval'  => $UserAssignedTopicsObj->StudentAssignmentData->time_interval,
            'total_questions' => $total_questions,
        ];
        return view('web.default.timestables.start', $data);
    }

    /*
     * Start SAT Quiz
     */
    public function assignmentView($UserAssignedTopicsObj)
    {

        if ($UserAssignedTopicsObj->StudentAssignmentData->status != 'active' || $UserAssignedTopicsObj->status != 'active') {
            return view('web.default.quizzes.unauthorized');
        }
        $user = auth()->user();
        $no_of_questions = $UserAssignedTopicsObj->StudentAssignmentData->no_of_questions;
        $quizObj = Quiz::find($UserAssignedTopicsObj->topic_id);
        $quizQuestionsList = isset($quizObj->quizQuestionsList) ? $quizObj->quizQuestionsList->pluck('question_id')->toArray() : array();
        $selectedQuestionsList = array_rand($quizQuestionsList, $no_of_questions);
        $selectedQuestionsList = array_intersect_key($quizQuestionsList, array_flip($selectedQuestionsList));

        $QuestionsAttemptController = new QuestionsAttemptController();

        $resultData = $QuestionsAttemptController->get_result_data($UserAssignedTopicsObj->id);
        $resultData = $QuestionsAttemptController->prepare_result_array($resultData);
        $is_passed = isset($resultData->is_passed) ? $resultData->is_passed : false;
        $in_progress = isset($resultData->in_progress) ? $resultData->in_progress : false;
        $current_status = isset($resultData->current_status) ? $resultData->current_status : '';
        $data = [
            'pageTitle'     => 'Start',
            'title'         => $UserAssignedTopicsObj->StudentAssignmentData->title,
            'assignmentObj' => $UserAssignedTopicsObj,
            'resultData'    => $resultData
        ];
        return view('web.default.quizzes.assignment_start', $data);
    }
	
	public function learningAssignmentView($UserAssignedTopicsObj)
    {

        if ($UserAssignedTopicsObj->StudentAssignmentData->status != 'active' || $UserAssignedTopicsObj->status != 'active') {
            return view('web.default.quizzes.unauthorized');
        }
        $user = auth()->user();
		pre('');
        $no_of_questions = $UserAssignedTopicsObj->StudentAssignmentData->no_of_questions;
        $quizObj = Quiz::find($UserAssignedTopicsObj->topic_id);
        $quizQuestionsList = isset($quizObj->quizQuestionsList) ? $quizObj->quizQuestionsList->pluck('question_id')->toArray() : array();
        $selectedQuestionsList = array_rand($quizQuestionsList, $no_of_questions);
        $selectedQuestionsList = array_intersect_key($quizQuestionsList, array_flip($selectedQuestionsList));

        $QuestionsAttemptController = new QuestionsAttemptController();

        $resultData = $QuestionsAttemptController->get_result_data($UserAssignedTopicsObj->id);
        $resultData = $QuestionsAttemptController->prepare_result_array($resultData);
        $is_passed = isset($resultData->is_passed) ? $resultData->is_passed : false;
        $in_progress = isset($resultData->in_progress) ? $resultData->in_progress : false;
        $current_status = isset($resultData->current_status) ? $resultData->current_status : '';
        $data = [
            'pageTitle'     => 'Start',
            'title'         => $UserAssignedTopicsObj->StudentAssignmentData->title,
            'assignmentObj' => $UserAssignedTopicsObj,
            'resultData'    => $resultData
        ];
        return view('web.default.quizzes.assignment_start', $data);
    }


    public function start(Request $request, $assignment_id)
    {

        $user = auth()->user();

        $UserAssignedTopicsObj = UserAssignedTopics::find($assignment_id);
        $assignment_type = $UserAssignedTopicsObj->StudentAssignmentData->assignment_type;

        $no_of_questions = $UserAssignedTopicsObj->StudentAssignmentData->no_of_questions;
        $no_of_attempts = $UserAssignedTopicsObj->StudentAssignmentData->no_of_attempts;
        $quizObj = Quiz::find($UserAssignedTopicsObj->topic_id);
        $quizQuestionsList = isset($quizObj->quizQuestionsList) ? $quizObj->quizQuestionsList->pluck('question_id')->toArray() : array();
        $selectedQuestionsList = array_rand($quizQuestionsList, $no_of_questions);
        $selectedQuestionsList = array_intersect_key($quizQuestionsList, array_flip($selectedQuestionsList));
        $timer_hide = false;

        /*$total_attempted = QuizzesResult::where('parent_type_id', $quiz->id)->where('user_id', $user->id)->where('status', '!=', 'waiting')->count();
        if ($total_attempted >= $AssignedAssignments->no_of_attempts) {
            $toastData = [
                'title'  => '',
                'msg'    => 'You are not authorized to attempt this assignment',
                'status' => 'error'
            ];
            return back()->with(['toast' => $toastData]);
        }*/

        $newQuizStart = QuizzesResult::where('parent_type_id', $UserAssignedTopicsObj->id)->where('user_id', $user->id)->where('status', 'waiting')->first();


        $selectedQuestionsList = array_values($selectedQuestionsList);
        $questions_list = $selectedQuestionsList;


        if ($UserAssignedTopicsObj) {

            $show_all_questions = true;

            $QuestionsAttemptController = new QuestionsAttemptController();

            $resultLogObj = $QuestionsAttemptController->createResultLog([
                'parent_type_id'   => $UserAssignedTopicsObj->id,
                'quiz_result_type' => 'assignment',
                'questions_list'   => $questions_list,
                'no_of_attempts'   => $no_of_attempts
            ]);
            //$questions_list = json_decode($resultLogObj->questions_list);
            //$questions_list = QuizzResultQuestions::whereIN('id', $questions_list)->pluck('question_id')->toArray();

            $prev_active_question_id = isset($resultLogObj->active_question_id) ? $resultLogObj->active_question_id : 0;

            if ($prev_active_question_id > 0) {
                $prevActiveQuestionObj = QuizzResultQuestions::find($prev_active_question_id);
                $prev_active_question_id = isset($prevActiveQuestionObj->question_id) ? $prevActiveQuestionObj->question_id : 0;
            }




            $attemptLogObj = $QuestionsAttemptController->createAttemptLog($resultLogObj);
            //$attempt_log_id = createAttemptLog($attemptLogObj->id, 'Session Started', 'started');

            $question_points = isset($question->question_score) ? $question->question_score : 0;


            $questions_array = $exclude_array = array();
            //$exclude_array[] = $questionObj->id;
            //$questions_array[] = $questionObj;
            $questions_layout = $results_questions_array = array();
            $active_question_id = $active_actual_question_id = $first_question_id = $question_no = 0;


            if (!empty($questions_list)) {
                $questions_counter = 0;
                foreach ($questions_list as $question_no_index => $question_id) {
                    $question_no = $question_no_index;
                    $prev_question = isset($questions_list[$question_no_index - 2]) ? $questions_list[$question_no_index - 2] : 0;
                    $next_question = isset($questions_list[$question_no_index + 1]) ? $questions_list[$question_no_index + 1] : 0;

                    $nextQuestionArray = $QuestionsAttemptController->nextQuestion($attemptLogObj, $exclude_array, 0, true, $questions_list, $resultLogObj, $question_id, $question_no_index);

                    $questionObj = isset($nextQuestionArray['questionObj']) ? $nextQuestionArray['questionObj'] : array();

                    $newQuestionResult = isset($nextQuestionArray['newQuestionResult']) ? $nextQuestionArray['newQuestionResult'] : array();

                    if ($question_id == $prev_active_question_id) {
                        $active_question_id = $newQuestionResult->id;
                        $active_actual_question_id = $newQuestionResult->question_id;
                    }

                    if (isset($questionObj->id)) {
                        $questions_array[] = $newQuestionResult;
                        $exclude_array[] = $newQuestionResult->id;

                        $question_no = $question_no_index + 1;
                        if ($question_no_index == 0) {
                            $first_question_id = $newQuestionResult->id;
                        }
                        //pre($quiz->quiz_type);

                        $question_response_layout = '';

                        if ($assignment_type == 'vocabulary') {

                            $layout_elements = isset($questionObj->layout_elements) ? json_decode($questionObj->layout_elements) : array();

                            $correct_answer = $audio_file = $audio_text = $audio_sentense = $field_id = '';
                            if (!empty($layout_elements)) {
                                foreach ($layout_elements as $elementData) {
                                    $element_type = isset($elementData->type) ? $elementData->type : '';
                                    $content = isset($elementData->content) ? $elementData->content : '';
                                    $correct_answer = isset($elementData->correct_answer) ? $elementData->correct_answer : $correct_answer;
                                    $audio_text = isset($elementData->audio_text) ? $elementData->audio_text : $audio_text;
                                    $audio_sentense = isset($elementData->audio_sentense) ? $elementData->audio_sentense : $audio_sentense;
                                    $audio_defination = isset($elementData->audio_defination) ? $elementData->audio_defination : $audio_defination;
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
                                'audio_text'       => $audio_text,
                                'audio_sentense'   => $audio_sentense,
                                'audio_defination' => $audio_defination,
                                'audio_file'       => $audio_file,
                                'field_id'         => $field_id,
                            );

                            $total_questions_count = is_array(json_decode($attemptLogObj->questions_list)) ? json_decode($attemptLogObj->questions_list) : array();
                            $total_questions_count = count($total_questions_count);
                            $RewardAccountingObj = RewardAccounting::where('user_id', $user->id)->where('type', 'coins')->where('parent_type', $resultLogObj->quiz_result_type)->first();

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
                                'total_points'          => isset($RewardAccountingObj->score) ? $RewardAccountingObj->score : 0,
                                'disable_next'          => 'true',
                                'disable_prev'          => 'true',
                            ];
                        } else {
                            $results_questions_array[$newQuestionResult->id] = [
                                'question'          => $questionObj,
                                'prev_question'     => $prev_question,
                                'next_question'     => $next_question,
                                'quizAttempt'       => $attemptLogObj,
                                'questionsData'     => rurera_encode($questionObj),
                                'newQuestionResult' => $newQuestionResult,
                                'question_no'       => $question_no,
                                'quizResultObj'     => $resultLogObj,
                                'disable_next'      => 'true',
                                'disable_prev'      => 'true',
                            ];
                        }


                    }
                    $questions_counter++;

                }
            }

            if (!empty($results_questions_array)) {
                $questions_list = array_keys($results_questions_array);
                $resultLogObj->update([
                    'questions_list' => json_encode($questions_list),
                ]);
                $attemptLogObj->update([
                    'questions_list' => json_encode($questions_list),
                ]);
                foreach ($results_questions_array as $resultQuestionID => $resultsQuestionsData) {

                    $resultsQuestionsData['prev_question'] = 0;
                    $resultsQuestionsData['next_question'] = 0;
                    $currentIndex = array_search($resultQuestionID, $questions_list);


                    if ($currentIndex !== false) {
                        // Get the previous index
                        $previousIndex = ($currentIndex > 0) ? $questions_list[$currentIndex - 1] : 0;
                        // Get the next index
                        $nextIndex = ($currentIndex < count($questions_list) - 1) ? $questions_list[$currentIndex + 1] : 0;
                        $resultsQuestionsData['prev_question'] = $previousIndex;
                        $resultsQuestionsData['next_question'] = $nextIndex;

                    }

                    if ($assignment_type == 'vocabulary') {

                        $resultsQuestionsData['duration_type'] = $UserAssignedTopicsObj->StudentAssignmentData->duration_type;
                        $resultsQuestionsData['practice_time'] = $UserAssignedTopicsObj->StudentAssignmentData->practice_time;
                        $resultsQuestionsData['time_interval'] = $UserAssignedTopicsObj->StudentAssignmentData->time_interval;
                        $time_limit = 0;
                        $time_limit = ($UserAssignedTopicsObj->StudentAssignmentData->duration_type == 'total_practice') ? ($UserAssignedTopicsObj->StudentAssignmentData->practice_time * 60) : $time_limit;
                        $time_limit = ($UserAssignedTopicsObj->StudentAssignmentData->duration_type == 'per_question') ? $UserAssignedTopicsObj->StudentAssignmentData->time_interval : $time_limit;
                        $resultsQuestionsData['time_limit'] = $time_limit;
                        $question_response_layout = view('web.default.panel.questions.spell_question_layout', $resultsQuestionsData)->render();
                    } else {
                        $question_layout_file = get_question_layout_file($resultLogObj);
                        $question_response_layout = view('web.default.panel.questions.'.$question_layout_file, $resultsQuestionsData)->render();
                    }
                    $questions_layout[$resultQuestionID] = rurera_encode(stripslashes($question_response_layout));
                }
            }

            $timer_hide = true;
            if ($assignment_type == 'timestables') {
                $timer_hide = false;
            }


            $question = $questions_array;


            $question = rurera_encode($question);


            $questions_status_array = $QuestionsAttemptController->questions_status_array($resultLogObj, $questions_list);

            //pre($active_question_id, false);
            $entrance_exams = array('sats', '11plus','independent_exams','iseb','cat4');
            $show_pagination = in_array($assignment_type, $entrance_exams)? 'yes' : 'no';
            $data = [
                'pageTitle'              => trans('quiz.quiz_start'),
                'questions_list'         => $questions_list,
                'quiz'                   => $quizObj,
                'quizQuestions'          => $quizObj->quizQuestions,
                'attempt_count'          => $resultLogObj->count() + 1,
                'newQuizStart'           => $resultLogObj,
                'quizAttempt'            => $attemptLogObj,
                'question'               => $question,
                'questions_layout'       => $questions_layout,
                'first_question_id'      => $first_question_id,
                'question_no'            => $question_no,
                'prev_question'          => $prev_question,
                'next_question'          => $next_question,
                'question_points'        => $question_points,
                'newQuestionResult'      => $newQuestionResult,
                'questions_status_array' => $questions_status_array,
                'active_question_id'     => $active_question_id,
                'active_actual_question_id' => $active_actual_question_id,
                'duration_type'          => $UserAssignedTopicsObj->StudentAssignmentData->duration_type,
                'practice_time'          => ($UserAssignedTopicsObj->StudentAssignmentData->practice_time * 60),
                'time_interval'          => $UserAssignedTopicsObj->StudentAssignmentData->time_interval,
                'timer_hide'             => $timer_hide,
                'show_pagination'        => $show_pagination
            ];

            if ($assignment_type == 'practice') {
                return view(getTemplate() . '.panel.quizzes.assignment_practice_start', $data);
            } else {
                return view(getTemplate() . '.panel.quizzes.assignment_start', $data);
				//return view(getTemplate() . '.panel.quizzes.spell_start', $data);
				
				
            }
        }
        abort(404);

    }


}
