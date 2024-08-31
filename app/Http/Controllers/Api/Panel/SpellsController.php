<?php

namespace App\Http\Controllers\Api\Panel;

use App\Http\Controllers\Api\Controller;
use App\User;
use App\Models\Category;
use App\Models\Webinar;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SpellsController extends Controller
{
    public function index(Request $request){
		
		$query = Quiz::where('status', Quiz::ACTIVE)->where('quiz_type', 'vocabulary');
		$spells_list = $query->paginate(200);
		
		$data_array = array();
		$section_id = 0;
		$data_array[$section_id] = array(
			'section_id' => $section_id,
			'section_title' => '',
			'section_data' => array(),
		);
		
		
		if( !empty( $spells_list )){
			foreach( $spells_list as $spellObj){
				$quiz_slug = isset( $spellObj->quizYear->slug )? $spellObj->quizYear->slug : '';
				$quiz_slug .= '/'.$spellObj->quiz_slug.'/spelling-list';
				$data_array[$section_id]['section_data'][] = array(
					'title' => $spellObj->getTitleAttribute(),
					'description' => '',
					'icon' => '',
					'icon_position' => 'right',
					'background' => '',
					'pageTitle' => $spellObj->getTitleAttribute(),
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
					'field_name' => 'spell_type',
					'field_type' => 'dropdown',
					'data_type' => 'text',
					'order' => 0,
					'required' => false,
					'multiple'=> false,
					'label' => 'Spelling Type',
					'icon' => '',
					"data" => array(
						[
							"name" => "spell_type",
							"label" => "Word Lists",
							"value" => "Word Lists"
						],
						[
							"name" => "spell_type",
							"label" => "Spelling Bee",
							"value" => "Spelling Bee"
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
					'target_api' => "/panel/spells",
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
