<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Api\Objects\UserObj;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function menu(Request $request){
		
		$navArray = getNavbarLinks();
		
		$menu_array = [];
		
		
		$menu_array = array(
			array(
				'title' => 'Home',
				'icon' => url('/assets/default/img/sidebar').'/home.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Home',
				'target_api' => '/home',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Learn',
				'icon' => url('/assets/default/img/sidebar').'/learn.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Learn',
				'target_api' => '/home',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Timestables',
				'icon' => url('/assets/default/img/sidebar').'/timestable.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Timestables',
				'target_api' => '/timestables',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Word Lists',
				'icon' => url('/assets/default/img/sidebar').'/spell.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Word Lists',
				'target_api' => '/home',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Books',
				'icon' => url('/assets/default/img/sidebar').'/books.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Books',
				'target_api' => '/home',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Test',
				'icon' => url('/assets/default/img/sidebar').'/test.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Test',
				'target_api' => '/home',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Quests',
				'icon' => url('/assets/default/img/sidebar').'/quests.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Quests',
				'target_api' => '/home',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Games',
				'icon' => url('/assets/default/img/sidebar').'/games.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Games',
				'target_api' => '/home',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Shop',
				'icon' => url('/assets/default/img/sidebar').'/shop.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Shop',
				'target_api' => '/home',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Analytics',
				'icon' => url('/assets/default/img/sidebar').'/grarph.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Analytics',
				'target_api' => '/home',
				'target_layout' => 'list',
			),
			array(
				'title' => 'School Zone',
				'icon' => url('/assets/default/svgs').'/school-zone.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'School Zone',
				'target_api' => '/home',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Referrals',
				'icon' => url('/assets/default/img/sidebar').'/referrals.png',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Referrals',
				'target_api' => '/home',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Profile',
				'icon' => url('/assets/default/img/sidebar').'/referrals.png',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Profile',
				'target_api' => '/home',
				'target_layout' => 'list',
			),
			array(
				'title' => 'Logout',
				'icon' => url('/assets/default/img/sidebar').'/logout.svg',
				'icon_position' => 'left',
				'color' => '#FFFFFF',
				'activeColor' => '#FF0000',
				'pageTitle' => 'Logout',
				'target_api' => '/home',
				'target_layout' => 'list',
			),
		);
		
        
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $menu_array);
    }

 }
