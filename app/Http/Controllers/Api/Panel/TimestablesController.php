<?php

namespace App\Http\Controllers\Api\Panel;

use App\Http\Controllers\Api\Controller;
use App\Http\Controllers\Web\QuestionsAttemptController;
use App\Http\Controllers\Web\DailyQuestsController;
use App\User;
use App\Models\Category;
use App\Models\Webinar;
use App\Models\ApiCalls;
use App\Models\QuizzesResult;
use App\Models\ShowdownLeaderboards;
use App\Models\StudentAssignments;
use App\Models\RewardAccounting;
use App\Models\TimestablesEvents;
use App\Models\QuizzResultQuestions;
use App\Models\QuizzAttempts;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TimestablesController extends Controller
{
    public function index(Request $request){
		
		$navArray = getNavbarLinks();
		
		$data_array = array();
		$section_id = 0;
		$data_array[$section_id] = array(
			'section_id' => $section_id,
			'section_title' => '',
            'section_description' => '',
			'section_data' => array(),
		);
		
		
		$data_array[$section_id]['section_data'] = array(
			array(
				'title' => 'Freedom Mode',
				'description' => 'Explore multiplication, division, or both at your own pace.',
				'icon' => url('/assets/default/svgs').'/eagle.svg',
				'icon_position' => 'right',
				'background' => '#FFFFFF',
				'pageTitle' => 'Freedom Mode',
				'target_api' => '/panel/timestables/freedom_mode',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Power-Up',
				'description' => 'Conquer questions to turn your heatmap green.',
				'icon' => url('/assets/default/svgs').'/battery-level.svg',
				'icon_position' => 'right',
				'background' => '#FFFFFF',
				'pageTitle' => 'Power-Up',
				'target_api' => '/panel/timestables/powerup_mode',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Trophy Mode',
				'description' => 'Speed trophy badge by playing 10 games.',
				'icon' => url('/assets/default/svgs').'/shuttlecock.svg',
				'icon_position' => 'right',
				'background' => '#FFFFFF',
				'pageTitle' => 'Trophy Mode',
				'target_api' => '/panel/timestables/trophy_mode',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Treasure Mission',
				'description' => 'Journey through times tables practice and discover hidden treasures.',
				'icon' => url('/assets/default/img').'/treasure.png',
				'icon_position' => 'right',
				'background' => '#FFFFFF',
				'pageTitle' => 'Treasure Mission',
				'target_api' => '/panel/timestables/treasure_mission',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Showdown',
				'description' => 'Journey through times tables practice and discover hidden treasures.',
				'icon' => url('/assets/default/img').'/showdown.png',
				'icon_position' => 'right',
				'background' => '#FFFFFF',
				'pageTitle' => 'Showdown',
				'target_api' => '/panel/timestables/showdown_mode',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Heat Map',
				'description' => 'Colours visualization for user data in heatmap',
				'icon' => url('/assets/default/svgs').'/fire.svg',
				'icon_position' => 'right',
				'background' => '#FFFFFF',
				'pageTitle' => 'Heat Map',
				'target_api' => '/panel/heat_map',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Analytics',
				'description' => 'Explore multiplication, division, or both at your own pace.',
				'icon' => url('/assets/default/svgs').'/analytics.svg',
				'icon_position' => 'right',
				'background' => '#FFFFFF',
				'pageTitle' => 'Analytics',
				'target_api' => '/panel/analytics',
				'target_layout' => 'list',
			),
			
		);
		
		$response = array(
			'listData' => $data_array,
			'searchFilters' => [],
		);
        
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }
	
	/*
	* Freedom Mode
	*/
	
	public function freedom_mode(Request $request){
		
		$form_fields = [];
		$user = apiAuth();
		
		$locked_tables = json_decode($user->locked_tables);
        $locked_tables = is_array($locked_tables)? $locked_tables : (array) $locked_tables;
		
		$data_array = array();
		$section_id = 0;
		$data_array[$section_id] = array(
			'section_id' => $section_id,
			'section_title' => '',
            'section_description' => '',
			'section_data' => array(),
		);
		
		$tables_array = array(2,3,4,5,6,7,8,9,10,11,12,13,14,15,16);
		
		
		$table_data = array();
		
		foreach( $tables_array as $table_no){
			$is_locked = in_array( $table_no, $locked_tables)? 'yes' : 'no';
			$table_data[]	= array(
				"key" => $table_no,
				"value" => $table_no,
				"is_disabled" => $is_locked,
			);
		}
		
		$data_array[$section_id]['section_data'] = array(
			array(
				"field_name" => "question_type",
				"field_type" => "choice",
				"element_layout" => "block",
				"label" => "Select Arithmetic Operations",
				"hint" => "",
				"order" => 0,
				"required" => true,
				"multiple" => false,
				"value" => "multiplication",
				"icon" => "",
				"data" => array(
					array(
						"key" => "multiplication_division",
						"value" => "Multiplication and Division",
					),
					array(
						"key" => "multiplication",
						"value" => "Multiplication only",
					),
					array(
						"key" => "division",
						"value" => "Division only",
					),
				)
			),
			array(
				"field_name" => "no_of_questions",
				"field_type" => "choice",
				"element_layout" => "block",
				"order" => 1,
				"required" => true,
				"multiple" => false,
				"label" => "No of Questions",
				"hint" => "",
				"value" => "20",
				"icon" => "",
				"data" => array(
					array(
						"key" => "10",
						"value" => "10 Questions",
					),
					array(
						"key" => "20",
						"value" => "20 Questions",
					),
					array(
						"key" => "30",
						"value" => "30 Questions",
					),
				)
			),
			array(
				"field_name" => "question_values",
				"field_type" => "choice",
				"element_layout" => "tables_selection",
				"label" => "Select Tables",
				"hint" => "",
				"order" => 2,
				"required" => true,
				"multiple" => true,
				"value" => [2,4],
				"icon" => "",
				"data" => $table_data
			),
			
			array(
				'field_name' => 'submit',
				'field_type' => 'button',
				'element_layout' => 'submit',
				'required' => false,
				'label' => 'Play',
				'icon' => '',
				'data' => '',
				'target_api_type' => "POST",
				'target_api' => "/panel/timestables/freedom_mode/play",
			),
		);
		
		$tracks_array = array(
			url('/').'/audios/timestables-bg.mp3', 
			url('/').'/audios/bauchamp.mp3', 
			url('/').'/audios/orange-loops.mp3', 
			url('/').'/audios/powerful-trap.mp3', 
		);
		$user_track = url('/').'/audios/timestables-bg.mp3';
		
		$response = array(
			'tracks_array' => $tracks_array,
			'user_track' => $user_track,
			'message' =>  '<h1>Hello from JSON!</h1><p>This is a paragraph from JSON. <strong>Bold text</strong> and <em>italic text</em> are also supported.</p><h5 style="line-height: 2;"><span style="font-family: terminal, monaco, monospace;"><strong>apple</strong></span></h5>',
			'form' => $data_array,
		);
		
		       
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }
	
	/*
	* Freedom Mode Play
	*/
	
	public function freedom_mode_play(Request $request){
		
		$form_fields = [];
		$user = apiAuth();
		
		ApiCalls::create([
			'user_id' => $user->id,	
			'device_id' => $request->input('device_id', 0),	
			'api_name' => 'freedom_mode_play',
			'api_data' => json_encode($request->all()),
			'updated_at' => time(),
		]);
		$question_type = $request->get('question_type');
		$no_of_questions = $request->get('no_of_questions');
		$tables_numbers = $request->get('question_values');
		$tables_numbers = is_array( $tables_numbers )? $tables_numbers : json_decode($tables_numbers);
		
		$attempt_options = array(
            'question_type' => $question_type,
            'no_of_questions' => $no_of_questions,
            'question_values' => $tables_numbers,
        );
		
		
		
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


        $max_questions = 12;
        $current_question_max = 2;
        $questions_no_array = [];
        while ($current_question_max <= $max_questions) {
            $questions_no_array[$current_question_max] = $current_question_max;
            $current_question_max++;
        }

        $questions_no_array_fixed = $questions_no_array;

        $questions_count = 1;
        if ($total_questions > 0) {
            while ($questions_count <= $total_questions) {
                $table_no = isset($tables_numbers[array_rand($tables_numbers)]) ? $tables_numbers[array_rand($tables_numbers)] : 0;
                $type = isset($tables_types[array_rand($tables_types)]) ? $tables_types[array_rand($tables_types)] : 0;
                if (empty($questions_no_array)) {
                    $questions_no_array = $questions_no_array_fixed;
                }
                $questions_no_array = array_values($questions_no_array);
                shuffle($questions_no_array);
                $dynamic_min = array_keys($questions_no_array, min($questions_no_array))[0];
                $dynamic_max = array_keys($questions_no_array, max($questions_no_array))[0];
                $dynamic_no = rand($dynamic_min, $dynamic_max);
                $questions_no_dynamic = isset($questions_no_array[$dynamic_no]) ? $questions_no_array[$dynamic_no] : 0;
                if (isset($questions_no_array[$dynamic_no])) {
                    unset($questions_no_array[$dynamic_no]);
                    $questions_no_array = array_values($questions_no_array);
                }

                $last_value = ($questions_no_dynamic) * $table_no;
                $from_value = ($type == '÷') ? $last_value : $table_no;
                $limit = 12;
                $min = 2;
                $min = ($type == '÷') ? 1 : $min;
                $limit = ($type == '÷') ? ($table_no * $limit) : $limit;
                //$to_value = rand($min, $limit);
                $to_value = ($type == '÷') ? $table_no : $questions_no_dynamic;


                $questions_array_list[] = (object)array(
                    'from'     => $from_value,
                    'to'       => $to_value,
                    'type'     => $type,
                    'table_no' => $table_no,
                    'marks'    => $marks,
					'game_time' => gameTime('timestables'),
                    'correct_answer'    => getCorrectTimestables($from_value, $to_value, $type),
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
                'quiz_result_type' => 'timestables',
                'no_of_attempts'   => 100,
                'other_data'       => json_encode($questions_list),
                'user_ip'          => getUserIP(),
                'attempt_mode'     => 'freedom_mode',
                'attempt_options' => json_encode($attempt_options),
            ]);

            $QuizzAttempts = QuizzAttempts::create([
                'quiz_result_id' => $QuizzesResult->id,
                'user_id'        => $user->id,
                'start_grade'    => $QuizzesResult->user_grade,
                'end_grade'      => 0,
                'created_at'     => time(),
                'attempt_type'   => $QuizzesResult->quiz_result_type,
                'user_ip'        => getUserIP(),
            ]);
            $attempt_log_id = createAttemptLog($QuizzAttempts->id, 'Session Started', 'started');
        }
		
		$section_id = 0;
		$data_array[$section_id] = array(
			'section_id' => $section_id,
            'background_music' => url('/').'/audios/timestables-bg.mp3',
			'result_id' => $QuizzesResult->id,
			'attempt_id' => $QuizzAttempts->id,
			'time_type' => 'timer',
			'time_start' => 0,
			'time_limit' => 0,
			'questions' => $questions_list,
			'target_api_type' => "POST",
			'target_api' => "/panel/timestables/submit_timestables",
		);
		
		$response = $data_array;
		
        
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }
	
	/*
	* Powerup Mode
	*/
	
	public function powerup_mode(Request $request){
		
		$form_fields = [];
		$user = apiAuth();
		
		$locked_tables = json_decode($user->locked_tables);
        $locked_tables = is_array($locked_tables)? $locked_tables : (array) $locked_tables;
		
		$data_array = array();
		$section_id = 0;
		$data_array[$section_id] = array(
			'section_id' => $section_id,
			'section_title' => '',
            'section_description' => '',
			'section_data' => array(),
		);
		
		$tables_array = array(2,3,4,5,6,7,8,9,10,11,12,13,14,15,16);
		
		$table_data = array();
		
		foreach( $tables_array as $table_no){
			$is_locked = in_array( $table_no, $locked_tables)? 'yes' : 'no';
			$table_data[]	= array(
				"key" => $table_no,
				"value" => $table_no,
				"is_disabled" => $is_locked,
			);
		}
		
		$data_array[$section_id]['section_data'] = array(
			array(
				"field_name" => "practice_level",
				"field_type" => "choice",
				"element_layout" => "block",
				"label" => "Select Table Group",
				"hint" => "",
				"order" => 0,
				"required" => true,
				"multiple" => false,
				"value" => "1-3",
				"icon" => "",
				"data" => array(
					array(
						"key" => "1",
						"value" => "1-3",
					),
					array(
						"key" => "2",
						"value" => "1-6",
					),
					array(
						"key" => "3",
						"value" => "1-9",
					),
					array(
						"key" => "4",
						"value" => "1-12",
					),
					array(
						"key" => "5",
						"value" => "1-15",
					),
					array(
						"key" => "6",
						"value" => "1-18",
					),
				)
			),
			array(
				"field_name" => "practice_time",
				"field_type" => "choice",
				"element_layout" => "block",
				"order" => 1,
				"required" => true,
				"multiple" => false,
				"label" => "Select Practice Duration",
				"hint" => "",
				"value" => "1",
				"icon" => "",
				"data" => array(
					array(
						"key" => "1",
						"value" => "1 Minute",
					),
					array(
						"key" => "3",
						"value" => "3 Minutes",
					),
					array(
						"key" => "5",
						"value" => "5 Minutes",
					),
				)
			),
			array(
				'field_name' => 'submit',
				'field_type' => 'button',
				'element_layout' => 'submit',
				'required' => false,
				'label' => 'Play',
				'icon' => '',
				'data' => '',
				'target_api_type' => "POST",
				'target_api' => "/panel/timestables/powerup_mode/play",
			),
		);
		
		$tracks_array = array(
			url('/').'/audios/timestables-bg.mp3', 
			url('/').'/audios/bauchamp.mp3', 
			url('/').'/audios/orange-loops.mp3', 
			url('/').'/audios/powerful-trap.mp3', 
		);
		$user_track = url('/').'/audios/timestables-bg.mp3';
		
		$response = array(
			'tracks_array' => $tracks_array,
			'user_track' => $user_track,
			'message' =>  '<h1>Hello from JSON!</h1><p>This is a paragraph from JSON. <strong>Bold text</strong> and <em>italic text</em> are also supported.</p><h5 style="line-height: 2;"><span style="font-family: terminal, monaco, monospace;"><strong>apple</strong></span></h5>',
			'form' => $data_array,
		);
		
		       
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }
	
	/*
	* Freedom Mode Play
	*/
	
	public function powerup_mode_play(Request $request){
		
		$form_fields = [];
		$user = apiAuth();
		
		ApiCalls::create([
			'user_id' => $user->id,	
			'device_id' => $request->input('device_id', 0),	
			'api_name' => 'powerup_mode_play',
			'api_data' => json_encode($request->all()),
			'updated_at' => time(),
		]);
		
		
		$practice_level = $request->get('practice_level');
		$practice_time = $request->get('practice_time');
		$WebTimestablesController = new \App\Http\Controllers\Web\TimestablesController();

        $times_tables_data = $WebTimestablesController->user_times_tables_data_single_user(array($user->id), 'x');
        $tables_last_data = isset($times_tables_data['tables_last_data']) ? $times_tables_data['tables_last_data'] : array();
        $timestables_attempted_result = $WebTimestablesController->get_timestables_attempted_result($tables_last_data);
        $tables_numbers = isset($timestables_attempted_result['tables_array']) ? $timestables_attempted_result['tables_array'] : array();
        $incorrect_array = isset($timestables_attempted_result['incorrect_array']) ? $timestables_attempted_result['incorrect_array'] : array();
        $excess_time_array = isset($timestables_attempted_result['excess_time_array']) ? $timestables_attempted_result['excess_time_array'] : array();
        $not_attempted_array = isset($timestables_attempted_result['not_attempted_array']) ? $timestables_attempted_result['not_attempted_array'] : array();
        $improvement_required_array = isset($timestables_attempted_result['improvement_required_array']) ? $timestables_attempted_result['improvement_required_array'] : array();

        $user_timestables_no = isset( $user->timestables_no )? json_decode($user->timestables_no) : array();
        $tables_numbers = array(
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            12
        );

		$tables_numbers = get_powerup_tables($tables_numbers, $practice_level);
        $tables_numbers = empty($user_timestables_no)? $tables_numbers : $user_timestables_no;

        $question_type = 'multiplication';
        $practice_time_seconds = ($practice_time * 60);
        $no_of_questions = ($practice_time_seconds * 2);
        //$practice_time_seconds = 10;

        $tables_types = [];
        $tables_types[] = 'x';

        $total_questions = $no_of_questions;
        $marks = 5;


        $questions_list = $already_exists = $questions_array_list = array();

        if (!empty($improvement_required_array)) {
            foreach ($improvement_required_array as $required_data_key => $required_data_array) {
                if (!empty($required_data_array)) {
                    foreach ($required_data_array as $required_data_from => $required_data_to) {
                        $questions_array_list[] = (object)array(
                            'from'     => $required_data_from,
                            'to'       => $required_data_to,
                            'type'     => 'x',
                            'table_no' => $required_data_from,
                            'marks'    => $marks,
                            'game_time' => gameTime('timestables'),
                            'correct_answer'    => getCorrectTimestables($required_data_from, $required_data_to, 'x'),
                        );
                    }
                }

            }
        }



        $max_questions = 12;
        $current_question_max = 2;
        $questions_no_array = [];
        while ($current_question_max <= $max_questions) {
            $questions_no_array[$current_question_max] = $current_question_max;
            $current_question_max++;
        }

        //pre($questions_no_array);

        $questions_no_array_fixed = $questions_no_array;

        $questions_count = 1;
        if ($total_questions > 0) {
            while ($questions_count <= $total_questions) {
                if( empty( $tables_numbers ) ){
                    continue;
                }
                $table_no = isset($tables_numbers[array_rand($tables_numbers)]) ? $tables_numbers[array_rand($tables_numbers)] : 0;
                $type = isset($tables_types[array_rand($tables_types)]) ? $tables_types[array_rand($tables_types)] : 0;
                if (empty($questions_no_array)) {
                    $questions_no_array = $questions_no_array_fixed;
                }
                $questions_no_array = array_values($questions_no_array);
                shuffle($questions_no_array);
                $dynamic_min = array_keys($questions_no_array, min($questions_no_array))[0];
                $dynamic_max = array_keys($questions_no_array, max($questions_no_array))[0];
                $dynamic_no = rand($dynamic_min, $dynamic_max);
                $questions_no_dynamic = isset($questions_no_array[$dynamic_no]) ? $questions_no_array[$dynamic_no] : 0;
                if (isset($questions_no_array[$dynamic_no])) {
                    unset($questions_no_array[$dynamic_no]);
                    $questions_no_array = array_values($questions_no_array);
                }

                $type = 'x';
                $last_value = ($questions_no_dynamic) * $table_no;
                $from_value = ($type == '÷') ? $last_value : $table_no;
                $limit = 12;
                $min = 2;
                $min = ($type == '÷') ? 1 : $min;
                $limit = ($type == '÷') ? ($table_no * $limit) : $limit;
                //$to_value = rand($min, $limit);
                $to_value = ($type == '÷') ? $table_no : $questions_no_dynamic;


                $questions_array_list[] = (object)array(
                        'from'     => $from_value,
                        'to'       => $to_value,
                        'type'     => $type,
                        'table_no' => $table_no,
                        'marks'    => $marks,
                        'game_time' => gameTime('timestables'),
                        'correct_answer'    => getCorrectTimestables($from_value, $to_value, $type),
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
                'quiz_result_type' => 'timestables',
                'no_of_attempts'   => 100,
                'other_data'       => json_encode($questions_list),
                'user_ip'          => getUserIP(),
                'attempt_mode'     => 'powerup_mode',
            ]);

            $QuizzAttempts = QuizzAttempts::create([
                'quiz_result_id' => $QuizzesResult->id,
                'user_id'        => $user->id,
                'start_grade'    => $QuizzesResult->user_grade,
                'end_grade'      => 0,
                'created_at'     => time(),
                'attempt_type'   => $QuizzesResult->quiz_result_type,
                'user_ip'        => getUserIP(),
            ]);
            $attempt_log_id = createAttemptLog($QuizzAttempts->id, 'Session Started', 'started');
        }
		
		$section_id = 0;
		$data_array[$section_id] = array(
			'section_id' => $section_id,
            'background_music' => url('/').'/audios/timestables-bg.mp3',
			'result_id' => $QuizzesResult->id,
			'attempt_id' => $QuizzAttempts->id,
			'time_type' => 'countdown',
			'time_start' => $practice_time_seconds,
			'time_limit' => 0,
			'questions' => $questions_list,
			'target_api_type' => "POST",
			'target_api' => "/panel/timestables/submit_timestables",
		);
		
		$response = $data_array;
		
        
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }
	
	
	/*
	* Trophy Mode
	*/
	
	public function trophy_mode(Request $request){
		
		$form_fields = [];
		$user = apiAuth();
		
		$locked_tables = json_decode($user->locked_tables);
        $locked_tables = is_array($locked_tables)? $locked_tables : (array) $locked_tables;
		
		$data_array = array();
		$section_id = 0;
		$data_array[$section_id] = array(
			'section_id' => $section_id,
			'section_title' => 'Select Practice Time',
			'section_description' => 'It will be one minute, try to answer the maximum questions.',
			'section_data' => array(),
		);
		$results_data = QuizzesResult::where('user_id', $user->id)->where('quiz_result_type', 'timestables')->where('attempt_mode', 'trophy_mode')->orderBy('created_at', 'desc')->where('status', '!=', 'waiting')->limit(10)->get();
		
		$tables_array = array(2,3,4,5,6,7,8,9,10,11,12,13,14,15,16);
		
		$table_data = array();
		
		foreach( $tables_array as $table_no){
			$is_locked = in_array( $table_no, $locked_tables)? 'yes' : 'no';
			$table_data[]	= array(
				"key" => $table_no,
				"value" => $table_no,
				"is_disabled" => $is_locked,
			);
		}
		
		$data_array[$section_id]['section_data'] = array(
			array(
				'field_name' => 'submit',
				'field_type' => 'button',
				'element_layout' => 'submit',
				'required' => false,
				'label' => 'Play',
				'icon' => '',
				'data' => '',
				'target_api_type' => "POST",
				'target_api' => "/panel/timestables/trophy_mode/play",
			),
		);
		
		$tracks_array = array(
			url('/').'/audios/timestables-bg.mp3', 
			url('/').'/audios/bauchamp.mp3', 
			url('/').'/audios/orange-loops.mp3', 
			url('/').'/audios/powerful-trap.mp3', 
		);
		$user_track = url('/').'/audios/timestables-bg.mp3';
		
		$response = array(
			'tracks_array' => $tracks_array,
			'user_track' => $user_track,
			'badges' => array(
				'Explorer',
				'Junior',
				'Smarty',
				'Brainy',
				'Genius',
				'Creative',
				'Champion',
				'Mastery',
				'Majesty',
				'Expert',
				'Maestro',
			),
			'user_badge' => isset( $user->trophy_badge )? $user->trophy_badge : '',
			'user_atttempts' => $results_data->count(),
			'form' => $data_array,
		);
		
		       
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }
	
	/*
	* Trophy Mode Play
	*/
	
	public function trophy_mode_play(Request $request){
		
		$form_fields = [];
		$user = apiAuth();
		
		ApiCalls::create([
			'user_id' => $user->id,	
			'device_id' => $request->input('device_id', 0),	
			'api_name' => 'trophy_mode_play',
			'api_data' => json_encode($request->all()),
			'updated_at' => time(),
		]);
		
		
		$tables_numbers = array(
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            12
        );

        $question_type = 'multiplication';
        $no_of_questions = 120;
        $practice_time = 1;
        $practice_time_seconds = ($practice_time * 60);

        $tables_types = [];
        $tables_types[] = 'x';

        $total_questions = $no_of_questions;
        $marks = 5;


        $questions_list = $already_exists = $questions_array_list = array();

        $max_questions = 12;
        $current_question_max = 2;
        $questions_no_array = [];
        while ($current_question_max <= $max_questions) {
            $questions_no_array[$current_question_max] = $current_question_max;
            $current_question_max++;
        }

        $questions_no_array_fixed = $questions_no_array;

        $questions_count = 1;
        if ($total_questions > 0) {
            while ($questions_count <= $total_questions) {
                $table_no = isset($tables_numbers[array_rand($tables_numbers)]) ? $tables_numbers[array_rand($tables_numbers)] : 0;
                $type = isset($tables_types[array_rand($tables_types)]) ? $tables_types[array_rand($tables_types)] : 0;
                if (empty($questions_no_array)) {
                    $questions_no_array = $questions_no_array_fixed;
                }
                $questions_no_array = array_values($questions_no_array);
                shuffle($questions_no_array);
                $dynamic_min = array_keys($questions_no_array, min($questions_no_array))[0];
                $dynamic_max = array_keys($questions_no_array, max($questions_no_array))[0];
                $dynamic_no = rand($dynamic_min, $dynamic_max);
                $questions_no_dynamic = isset($questions_no_array[$dynamic_no]) ? $questions_no_array[$dynamic_no] : 0;
                if (isset($questions_no_array[$dynamic_no])) {
                    unset($questions_no_array[$dynamic_no]);
                    $questions_no_array = array_values($questions_no_array);
                }

                $last_value = ($questions_no_dynamic) * $table_no;
                $from_value = ($type == '÷') ? $last_value : $table_no;
                $limit = 12;
                $min = 2;
                $min = ($type == '÷') ? 1 : $min;
                $limit = ($type == '÷') ? ($table_no * $limit) : $limit;
                //$to_value = rand($min, $limit);
                $to_value = ($type == '÷') ? $table_no : $questions_no_dynamic;

                $questions_array_list[] = (object)array(
                    'from'     => $from_value,
                    'to'       => $to_value,
                    'type'     => $type,
                    'table_no' => $table_no,
                    'marks'    => $marks,
                    'game_time' => gameTime('timestables'),
                    'correct_answer'    => getCorrectTimestables($from_value, $to_value, $type),
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
                'quiz_result_type' => 'timestables',
                'no_of_attempts'   => 100,
                'other_data'       => json_encode($questions_list),
                'user_ip'          => getUserIP(),
                'attempt_mode'     => 'trophy_mode',
            ]);

            $QuizzAttempts = QuizzAttempts::create([
                'quiz_result_id' => $QuizzesResult->id,
                'user_id'        => $user->id,
                'start_grade'    => $QuizzesResult->user_grade,
                'end_grade'      => 0,
                'created_at'     => time(),
                'attempt_type'   => $QuizzesResult->quiz_result_type,
                'user_ip'        => getUserIP(),
            ]);
            $attempt_log_id = createAttemptLog($QuizzAttempts->id, 'Session Started', 'started');
        }
		
		$section_id = 0;
		$data_array[$section_id] = array(
			'section_id' => $section_id,
            'background_music' => url('/').'/audios/timestables-bg.mp3',
			'result_id' => $QuizzesResult->id,
			'attempt_id' => $QuizzAttempts->id,
			'time_type' => 'countdown',
			'time_start' => $practice_time_seconds,
			'time_limit' => 0,
			'questions' => $questions_list,
			'target_api_type' => "POST",
			'target_api' => "/panel/timestables/submit_timestables",
		);
		
		$response = $data_array;
		
        
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }
	
	/*
	* Timestables Submit
	*/
	
	public function submit_timestables(Request $request){
		
		$form_fields = [];
		$user = apiAuth();
		$result_id = $request->get('result_id');
		$attempt_id = $request->get('attempt_id');
		$questions = $request->get('questions');
		$timestables_data = is_array( $questions )? $questions : json_decode($questions);
		
		$QuestionsAttemptController = new QuestionsAttemptController();
		
		ApiCalls::create([
			'user_id' => $user->id,	
			'device_id' => $request->input('device_id', 0),	
			'api_name' => 'submit_timestables',
			'api_data' => json_encode($request->all()),
			'updated_at' => time(),
		]);
		
		$QuizzAttempts = QuizzAttempts::find($attempt_id);
		$get_last_results = '';
        $last_time_table_data = QuizzesResult::where('user_id', $user->id)->where('id', '!=', $QuizzAttempts->quiz_result_id)->whereIN('quiz_result_type', array(
			'timestables',
			'timestables_assignment'
		))->where('status', '!=', 'waiting')->orderBy('id', 'DESC')->first();
		$get_last_results = isset($last_time_table_data->other_data) ? $last_time_table_data->other_data : '';

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
				$tableData = (array) $tableData;
				$tableData['score'] = $score;
				$tableData['answer'] = $tableData['user_answer'];
				$tableData['result_id'] = $QuizzesResult->id;
				$correct_answer = isset( $tableData['correct_answer'] )? $tableData['correct_answer'] : 0;
				$user_answer = isset( $tableData['user_answer'] )? $tableData['user_answer'] : 0;
				$tableData['is_correct'] = ($correct_answer == $user_answer)? 'true' : 'false';
				unset($tableData['marks']);
				unset($tableData['user_answer']);
				$results[$tableData['table_no']][] = $tableData;
            }
        }
        //$new_array = $results;//array_merge($get_last_results, $results);
		$new_array = array_merge($get_last_results, $results);
		
        
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
            'no_of_attempts' => 100,
			'other_data'     => json_encode($new_result_data),
        ]);
		

        $attempt_log_id = createAttemptLog($QuizzAttempts->id, 'Session Ends', 'end');

        $total_time_consumed = 0;
        $total_questions_array = $incorrect_array = $not_attempted_array = $correct_array = array();
		$total_coins_earned = 0;
        if (!empty($timestables_data)) {
			
            foreach ($timestables_data as $tableData) {

				$tableData = (array) $tableData;
				$tableData['score'] = $score;
				$tableData['answer'] = $tableData['user_answer'];
				$tableData['result_id'] = $QuizzesResult->id;
				$correct_answer = isset( $tableData['correct_answer'] )? $tableData['correct_answer'] : 0;
				$user_answer = isset( $tableData['user_answer'] )? $tableData['user_answer'] : 0;
				$tableData['is_correct'] = ($correct_answer == $user_answer)? 'true' : 'false';
				unset($tableData['marks']);
				unset($tableData['user_answer']);
			
			
			
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
				$total_questions_array[] = $newQuestionResult->id;
                if($is_correct != 'true' && $question_status != 'not_attempted'){
                    $incorrect_array[] = $newQuestionResult->id;
                }
                if($question_status == 'not_attempted'){
                    $not_attempted_array[] = $newQuestionResult->id;
                }
				if($is_correct == 'true'){
                    $correct_array[] = $newQuestionResult->id;
                }
				
				
				if( $QuizzesResult->attempt_mode == 'treasure_mode') {
					$percentage_correct_answer = $QuestionsAttemptController->get_percetange_corrct_answer($QuizzesResult);
					if( $percentage_correct_answer >= 95){
						$earn_coins = $QuestionsAttemptController->update_reward_points($newQuestionResult, ($is_correct == 'true') ? true : false, $QuizzesResult->parent_type_id);
						$total_coins_earned += ($earn_coins > 0)? $earn_coins : 0;
					}
				}else{
					$earn_coins = $QuestionsAttemptController->update_reward_points($newQuestionResult, ($is_correct == 'true') ? true : false, $QuizzesResult->parent_type_id);
					$total_coins_earned += ($earn_coins > 0)? $earn_coins : 0;
				}

            }
        }

        $QuizzesResult->update([
            'total_questions' => count($total_questions_array),
            'total_attempted' => count($total_questions_array) - count($not_attempted_array),
            'total_correct' => count($correct_array),
            'total_incorrect' => count($incorrect_array),
            'total_not_attempted' => count($not_attempted_array),
            'total_coins_earned' => $total_coins_earned,
            'total_time_consumed'     => ($total_time_consumed > 0)? ($total_time_consumed / 10) : 0,
			'total_game_time' => (count($correct_array) * gameTime($QuizzesResult->quiz_result_type)),
        ]);
		
		$QuizzAttempts->update([
			'total_questions' => count($total_questions_array),
            'total_attempted' => count($total_questions_array) - count($not_attempted_array),
            'total_correct' => count($correct_array),
            'total_incorrect' => count($incorrect_array),
            'total_not_attempted' => count($not_attempted_array),
            'total_coins_earned' => $total_coins_earned,
            'total_time_consumed'     => ($total_time_consumed > 0)? ($total_time_consumed / 10) : 0,
            'total_game_time' => (count($correct_array) * gameTime($QuizzesResult->quiz_result_type)),
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
            $percentage_correct_answer = $QuestionsAttemptController->get_percetange_corrct_answer($QuizzesResult);
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
		$QuestionsAttemptController->resultTimestablesAverage($QuizzesResult->id);
		
		
		
		
		$locked_tables = json_decode($user->locked_tables);
        $locked_tables = is_array($locked_tables)? $locked_tables : (array) $locked_tables;
		$tables_array = array(2,3,4,5,6,7,8,9,10,11,12,13,14,15,16);
		
		$table_data = array();
		
		foreach( $tables_array as $table_no){
			$is_locked = in_array( $table_no, $locked_tables)? 'yes' : 'no';
			$table_data[]	= array(
				"key" => $table_no,
				"value" => $table_no,
				"is_disabled" => $is_locked,
			);
		}
		
		
		
		$section_id = 0;
		$data_array[$section_id] = array(
			'section_id' => $section_id,
			'completed_quests' => $completed_quests,
			'table_data' => $table_data,
		);
		
		$response = $data_array;
		
        
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }

 }
