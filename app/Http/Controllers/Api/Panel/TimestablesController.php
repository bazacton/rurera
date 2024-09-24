<?php

namespace App\Http\Controllers\Api\Panel;

use App\Http\Controllers\Api\Controller;
use App\User;
use App\Models\Category;
use App\Models\Webinar;
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
				'order' => 3,
				'required' => false,
				'label' => 'Play',
				'icon' => '',
				'data' => '',
				'target_api_type' => "POST",
				'target_api' => "/panel/timestables/freedom_mode/play",
			),
		);
		
		$response = array(
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
		
		$locked_tables = json_decode($user->locked_tables);
        $locked_tables = is_array($locked_tables)? $locked_tables : (array) $locked_tables;
		
		$data_array = array();
		$section_id = 0;
		$data_array[$section_id] = array(
			'section_id' => $section_id,
			'section_title' => 'Select Arithmetic Operations',
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
				'order' => 3,
				'required' => false,
				'label' => 'Play',
				'icon' => '',
				'data' => '',
				'target_api_type' => "POST",
				'target_api' => "/panel/timestables/freedom_mode/play",
			),
		);
		
		$response = array(
			'form' => $data_array,
		);
		
        
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }

 }
