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

 }
