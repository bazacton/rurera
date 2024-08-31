<?php

namespace App\Http\Controllers\Api\Panel;

use App\Http\Controllers\Api\Controller;
use App\User;
use App\Models\Category;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class LearnController extends Controller
{
    public function index(Request $request)
    {
		$user = apiAuth();
		
		$hide_subjects = json_decode($user->hide_subjects);
		$hide_subjects = is_array($hide_subjects)? $hide_subjects : array();
		

        $categoryObj = Category::where('id', $user->year_id)->first();
        $courses_list = Webinar::whereJsonContains('category_id', (string) $categoryObj->id);
		$courses_list = $courses_list->whereNotIn('id', $hide_subjects);
		$courses_list = $courses_list->where('status', 'active')->get();
		
		$data_array = array();
		$section_id = 0;
		$data_array[$section_id] = array(
			'section_id' => $section_id,
			'section_title' => '',
			'section_data' => array(),
		);
		
		if( !empty( $courses_list )){
			foreach( $courses_list as $courseObj){
				$title = $courseObj->getTitleAttribute();
				$description = $courseObj->chapters->count().' Units and '.$courseObj->webinar_sub_chapters->count().' Lessons';
				$course_icon = isset( $courseObj->thumbnail )? url('/').$courseObj->thumbnail : '';
				$background_color = isset( $courseObj->background_color )? $courseObj->background_color : '#FFFFFF';
				
				$data_array[$section_id]['section_data'][] = array(
					'title' => $title,
					'description' => $description,
					'icon' => $course_icon,
					'icon_position' => 'top',
					'background' => $background_color,
					'pageTitle' => $title,
					'target_api' => '/panel/learn/'.$categoryObj->slug.'/'.$courseObj->slug,
					'target_layout' => 'list',
				);
				
			}
		}
		
		$response = array(
			'listData' => $data_array,
			'searchFilters' => [],
		);
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }
	
	public function subject_data(Request $request, $category_slug, $slug)
    {
        $categoryObj = Category::where('slug', $category_slug)->first();

        $course = Webinar::where('slug', $slug)->whereJsonContains('category_id', (string) $categoryObj->id)
            ->where('status', 'active')
            ->first();
			
			
		$data_array = array();
		$section_id = 0;
		
			
		if($course->chapters->count() > 0){	
			foreach($course->chapters as $chapter){
				
				$data_array[$section_id] = array(
					'section_id' => $section_id,
					'section_title' => isset( $chapter->title )? $chapter->title : '',
					'section_data' => array(),
				);	
				
				if( $chapter->subChapters->count() > 0){
					foreach( $chapter->subChapters as $subChapterObj){
						$data_array[$section_id]['section_data'][] = array(
							'title' => $subChapterObj->sub_chapter_title,
							'description' => '',
							'icon' => '',
							'icon_position' => '',
							'background' => '',
							'pageTitle' => $subChapterObj->sub_chapter_title,
							'target_api' => '/panel/learn/'.$category_slug.'/'.$slug.'/'.$subChapterObj->sub_chapter_slug,
							'target_layout' => 'list',
						);
					}
				}
				
				$section_id++;
			}
		}
		
		$response = array(
			'listData' => $data_array,
			'searchFilters' => [],
		);
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
	}
}









