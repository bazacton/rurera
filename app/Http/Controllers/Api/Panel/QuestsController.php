<?php

namespace App\Http\Controllers\Api\Panel;
use App\Http\Controllers\Web\DailyQuestsController;
use App\Http\Controllers\Api\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class QuestsController extends Controller
{
    public function index(Request $request){
		
		$user = apiAuth();
		
		$DailyQuestsController = new DailyQuestsController();
		
		$quests = $user->getUserQuests();
		
		
		$data_array = array();
		$section_id = 0;
		$data_array[$section_id] = array(
			'section_id' => $section_id,
			'section_title' => '',
			'section_data' => array(),
		);
		
		
		if( !empty( $quests )){
			foreach( $quests as $questObj){
				
				$questUserData = $DailyQuestsController->getQuestUserData($questObj);
				$quest_icon = '/assets/default/img/types/'.$questObj->quest_topic_type.'.svg';
				$quest_icon = ( $questObj->quest_icon != '')? $questObj->quest_icon : $quest_icon;
				$data_array[$section_id]['section_data'][] = array(
					'title' => $questObj->title,
					'description' => '',
					'icon' => url('/').$quest_icon,
					'icon_position' => 'left',
					'completion_percentage' => isset( $questUserData['completion_percentage'] )? $questUserData['completion_percentage'].'%' : '0%',
					'completion_label' => isset( $questUserData['quest_bar_label'] )? $questUserData['quest_bar_label'] : '',
					'quest_score' => isset( $questUserData['questScore'] )? $questUserData['questScore'] : 0,
					'background' => '',
					'pageTitle' => $questObj->title,
				);
				
			}
		}
		
		
		
        $response = array(
			'listData' => $data_array,
			'searchFilters' => array(),
		);
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }

 }
