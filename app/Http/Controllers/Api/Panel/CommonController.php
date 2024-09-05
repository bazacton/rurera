<?php

namespace App\Http\Controllers\Api\Panel;

use App\Http\Controllers\Api\Controller;
use App\User;
use App\Models\Category;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CommonController extends Controller
{
    public function menu(Request $request){
		
		$user = apiAuth();
		
		$navArray = getNavbarLinks();
		
		$data_array = array();
		$section_id = 0;
		$data_array[$section_id] = array(
			'section_id' => $section_id,
			'section_title' => '',
			'section_data' => array(),
		);
		
		$menu_array = array(
			array(
				'title' => 'Home',
				'icon' => url('/assets/default/img/sidebar').'/home.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Home',
				'target_api' => '/panel/home',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Learn',
				'icon' => url('/assets/default/img/sidebar').'/learn.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Learn',
				'target_api' => '/panel/learn',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Timestables',
				'icon' => url('/assets/default/img/sidebar').'/timestable.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Timestables',
				'target_api' => '/panel/timestables',
				'target_layout' => 'list2',
			),
			array(
				'title' => 'Word Lists',
				'icon' => url('/assets/default/img/sidebar').'/spell.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Word Lists',
				'target_api' => '/panel/spells',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Books',
				'icon' => url('/assets/default/img/sidebar').'/books.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Books',
				'target_api' => '/panel/books',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Test',
				'icon' => url('/assets/default/img/sidebar').'/test.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Test',
				'target_api' => '/panel/test',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Quests',
				'icon' => url('/assets/default/img/sidebar').'/quests.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Quests',
				'target_api' => '/panel/quests',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Games',
				'icon' => url('/assets/default/img/sidebar').'/games.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Games',
				'target_api' => '/panel/games',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Shop',
				'icon' => url('/assets/default/img/sidebar').'/shop.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Shop',
				'target_api' => '/panel/shop',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Analytics',
				'icon' => url('/assets/default/img/sidebar').'/grarph.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Analytics',
				'target_api' => '/panel/analytics',
				'target_layout' => 'list',
			),
			array(
				'title' => 'School Zone',
				'icon' => url('/assets/default/svgs').'/school-zone.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'School Zone',
				'target_api' => '/panel/school-zone',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Referrals',
				'icon' => url('/assets/default/img/sidebar').'/referrals.png',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Referrals',
				'target_api' => '/panel/referrals',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Profile',
				'icon' => url('/assets/default/img/sidebar').'/referrals.png',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Profile',
				'target_api' => '/panel/setting',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Logout',
				'icon' => url('/assets/default/img/sidebar').'/logout.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Logout',
				'target_api' => '/panel/logout',
				'target_layout' => 'list',
			),
		);
		
		if( $user->role_id == 9){
			$menu_array = array(
				array(
					'title' => 'Home',
					'icon' => url('/assets/default/img/sidebar').'/home.svg',
					'icon_position' => 'left',
					'color' => '#FFFFFF',
					'activeColor' => '#FF0000',
					'pageTitle' => 'Home',
					'target_api' => '/panel/home',
					'target_layout' => 'list',
				),
				array(
					'title' => 'Set Work',
					'icon' => url('/assets/default/img/sidebar').'/learn.svg',
					'icon_position' => 'left',
					'color' => '#FFFFFF',
					'activeColor' => '#FF0000',
					'pageTitle' => 'Set Work',
					'target_api' => '/panel/set-work',
					'target_layout' => 'list',
				),
				array(
					'title' => 'Analytics',
					'icon' => url('/assets/default/img/sidebar').'/grarph.svg',
					'icon_position' => 'left',
					'color' => '#FFFFFF',
					'activeColor' => '#FF0000',
					'pageTitle' => 'Analytics',
					'target_api' => '/panel/analytics',
					'target_layout' => 'list',
				),
				
				array(
					'title' => 'Referrals',
					'icon' => url('/assets/default/img/sidebar').'/referrals.png',
					'icon_position' => 'left',
					'color' => '#FFFFFF',
					'activeColor' => '#FF0000',
					'pageTitle' => 'Referrals',
					'target_api' => '/panel/referrals',
					'target_layout' => 'list',
				),
				array(
					'title' => 'Students',
					'icon' => url('/assets/default/img/sidebar').'/members.png',
					'icon_position' => 'left',
					'color' => '#FFFFFF',
					'activeColor' => '#FF0000',
					'pageTitle' => 'Students',
					'target_api' => '/panel/students',
					'target_layout' => 'list',
				),
				array(
					'title' => 'Profile',
					'icon' => url('/assets/default/img/sidebar').'/referrals.png',
					'icon_position' => 'left',
					'color' => '#FFFFFF',
					'activeColor' => '#FF0000',
					'pageTitle' => 'Profile',
					'target_api' => '/panel/setting',
					'target_layout' => 'list',
				),
				array(
					'title' => 'Logout',
					'icon' => url('/assets/default/img/sidebar').'/logout.svg',
					'icon_position' => 'left',
					'color' => '#FFFFFF',
					'activeColor' => '#FF0000',
					'pageTitle' => 'Logout',
					'target_api' => '/panel/logout',
					'target_layout' => 'list',
				),
			);
		}
		
		
		$data_array[$section_id]['section_data'] = $menu_array;
		
		$response = array(
			'listData' => $data_array,
			'searchFilters' => [],
		);
		
        
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }

 }
