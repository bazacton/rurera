<?php

namespace App\Http\Controllers\Api\Panel;

use App\Http\Controllers\Api\Controller;
use App\User;
use App\Models\Category;
use App\Models\Webinar;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TestsController extends Controller
{
    public function index(Request $request){
		
		$user = apiAuth();
		
		$query = Quiz::where('status', Quiz::ACTIVE)->whereIn('quiz_type', ['sats', '11plus', 'cat4', 'iseb', 'independence_exams'])->with('quizQuestionsList');
		if (auth()->check() && auth()->user()->isUser()) {
			$query->where(function ($subQuery) use ($user) {
				$subQuery->whereIn('quiz_type', array('sats', '11plus'))->orWhere('year_id', $user->year_id);	
			});
		}
		$sats = $query->paginate(100);
		
		
		$data_array = array();
		$section_id = 0;
		$data_array[$section_id] = array(
			'section_id' => $section_id,
			'section_title' => '',
			'section_data' => array(),
		);
		
		
		if( !empty( $sats )){
			foreach( $sats as $satsObj){
				$quiz_slug = isset( $satsObj->quizYear->slug )? $satsObj->quizYear->slug : '';
				$quiz_slug .= '/sats/'.$satsObj->quiz_slug;
				$data_array[$section_id]['section_data'][] = array(
					'title' => $satsObj->getTitleAttribute(),
					'description' => '',
					'icon' => isset( $satsObj->quiz_image )? $satsObj->quiz_image : '',
					'icon_position' => 'left',
					'no_of_questions' => $satsObj->no_of_questions,
					'quiz_type' => getQuizTypeTitle($satsObj->quiz_type),
					'quiz_time' => $satsObj->time.'m',
					'background' => '',
					'pageTitle' => $satsObj->getTitleAttribute(),
					'target_api' => '/panel/'.$quiz_slug,
					'target_layout' => 'list',
				);
				
			}
		}
		
		$search_filters = array(
			'section_id' => 0,
			'section_title' => '',
			'section_data' => array(
				array(
					'field_name' => 'test_type',
					'field_type' => 'dropdown',
					'data_type' => 'text',
					'order' => 0,
					'required' => false,
					'multiple'=> false,
					'label' => 'Test Type',
					'icon' => '',
					"data" => array(
						[
							"name" => "test_type",
							"label" => "Sats",
							"value" => "sats"
						],
						[
							"name" => "test_type",
							"label" => "11Plus",
							"value" => "11plus"
						],
						[
							"name" => "test_type",
							"label" => "ISEB",
							"value" => "iseb"
						],
						[
							"name" => "test_type",
							"label" => "CAT 4",
							"value" => "cat4"
						],
						[
							"name" => "test_type",
							"label" => "Independent Exams",
							"value" => "independent_exams"
						],
						[
							"name" => "test_type",
							"label" => "11Plus",
							"value" => "11plus"
						],
						[
							"name" => "test_type",
							"label" => "11Plus",
							"value" => "11plus"
						],
					)
				),
				array(
					'field_name' => 'submit',
					'field_type' => 'button',
					'data_type' => 'submit',
					'order' => 1,
					'required' => false,
					'label' => 'Submit',
					'icon' => '',
					'data' => [],
					'target_api' => "/panel/tests",
				),
			)
		);
		
		
        $response = array(
			'listData' => $data_array,
			'searchFilters' => $search_filters,
		);
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }

 }
