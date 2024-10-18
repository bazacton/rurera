<?php

namespace App\Http\Controllers\Api\Panel;

use App\Http\Controllers\Api\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\User;
use App\Models\Category;
use App\Models\Webinar;


use App\Models\SubChapters;
use App\Models\WebinarChapterItem;
use App\Models\Quiz;
use App\Models\QuizzesQuestion;
use App\Models\ApiCalls;

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
							'target_layout' => 'learn_practice',
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
	
	public function start(Request $request, $category_slug, $slug, $sub_chapter_slug)
    {
		$user = apiAuth();
		$SubChapters = SubChapters::where('sub_chapter_slug', $sub_chapter_slug)
                    ->first();
					
		
		


        $chapterItem = WebinarChapterItem::where('type', 'quiz')
            ->where('parent_id', $SubChapters->id)
            ->first();
			

        $id = isset($chapterItem->item_id) ? $chapterItem->item_id : 0;
		
		
        $quiz = Quiz::find($id);
		
		
		$data_array = array();
		
		$QuizController = new QuizController();
		$quiz_response = $QuizController->get_learn_quiz_data($quiz, 'easy', 'no', [], 'yes', '', 0);
		
		
		
		
		$questions_list_data = isset( $quiz_response['questions_list_data'] )? $quiz_response['questions_list_data'] : array();
		$section_id = 0;
		$question_serial = 1;
		if( !empty( $questions_list_data ) ){
			foreach( $questions_list_data as $questionResultObj){
				$data_array[$section_id] = array(
					'question_serial' => $question_serial,
					'coins' => 1,
					'game_time' => 25,
					'attempt_question_id' => $questionResultObj->id,
					'question_id' => $questionResultObj->question_id,
					'difficulty_level' => $questionResultObj->difficulty_level,
					'question_elements' => array(),
					'solution' => array(),
					'glossary' => array(),
					'is_review_required' => false,
				);
				
				
				$layout_elements	= isset( $questionResultObj->layout_elements )? json_decode($questionResultObj->layout_elements): array();
				usort($layout_elements, function($a, $b) {
					return $a->_seq <=> $b->_seq;
				});
				$layout_elements = $layout_elements;
				
				$data_array[$section_id]['question_elements'] = array();
				
				if( !empty( $layout_elements ) ){
					foreach( $layout_elements as $elementObj){
						
						$elementObj->type = ($elementObj->type == 'question_label_true_false')? 'question_label' : $elementObj->type;
						$elementObj->type = ($elementObj->type == 'question_label_multichoice_template')? 'question_label' : $elementObj->type;
						$elementObj->type = ($elementObj->type == 'question_label_sequence_template')? 'question_label' : $elementObj->type;
						$elementObj->type = ($elementObj->type == 'question_label_select_template')? 'question_label' : $elementObj->type;
						$elementObj->type = ($elementObj->type == 'question_label_matching_template')? 'question_label' : $elementObj->type;
						$elementObj->type = ($elementObj->type == 'question_label_paragraph')? 'paragraph_quiz' : $elementObj->type;
						$elementObj->type = ($elementObj->type == 'paragraph_multichoice_template')? 'paragraph_quiz' : $elementObj->type;
						unset($elementObj->elements_data);
						unset($elementObj->resize);
						unset($elementObj->height);
						if( isset( $elementObj->content ) ){
							//$elementObj->content = strip_tags($elementObj->content);
						}
						unset($elementObj->elements_data);
						
						if( isset( $elementObj->options )){
							foreach ($elementObj->options as $key => $option) {
								if (!isset($option->label)) {
									unset($elementObj->options[$key]);
								}
							}
						}
						
						if( isset( $elementObj->sortable_options )){
							foreach ($elementObj->sortable_options as $key => $option) {
								if (!isset($option->label)) {
									unset($elementObj->sortable_options[$key]);
								}
							}
						}
						
						
						if( $elementObj->type == 'draggable_question'){							
						
						
							$elementObj->dragarea_answers = array(
								'1' => $elementObj->dragarea1_answer,
								'2' => $elementObj->dragarea2_answer,
								'3' => $elementObj->dragarea3_answer,
								'4' => $elementObj->dragarea4_answer,
								'5' => $elementObj->dragarea5_answer,
							);
							unset($elementObj->dragarea1_answer);
							unset($elementObj->dragarea2_answer);
							unset($elementObj->dragarea3_answer);
							unset($elementObj->dragarea4_answer);
							unset($elementObj->dragarea5_answer);
						
							foreach ($elementObj->options as $key => $option) {
								if (isset($option->default)) {
									unset($option->default);
								}
								
								if (empty((array)$option)) {
									unset($elementObj->options[$key]);
								}
							}
						}
						
						
						if( $elementObj->type == 'drop_and_text'){							
						
						
							$elementObj->inputfield_answers = array(
								'1' => $elementObj->inner_field1,
								'2' => $elementObj->inner_field2,
								'3' => $elementObj->inner_field3,
								'4' => $elementObj->inner_field4,
								'5' => $elementObj->inner_field5,
							);
							unset($elementObj->inner_field1);
							unset($elementObj->inner_field2);
							unset($elementObj->inner_field3);
							unset($elementObj->inner_field4);
							unset($elementObj->inner_field5);
						}
						
						if( $elementObj->type == 'image_quiz'){
							$elementObj->content = ($elementObj->content != '')? url('/').$elementObj->content : $elementObj->content;
						}
						
						$data_array[$section_id]['question_elements'][] = $elementObj;
					}
				}
				
				
				$question_serial++;
				$section_id++;
			}
		}
		
		
		$response = array(
			'questions' => $data_array,
			'settings' => array(
				'target_score' => 80,
			)
		);
		
		ApiCalls::create([
			'user_id' => $user->id,	
			'device_id' => $request->input('device_id', 0),	
			'api_name' => 'learn_subject_quiz',
			'api_data' => json_encode($request->all()),
			'api_response' => json_encode($response),
			'updated_at' => time(),
		]);
		
		
		return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
		
		//pre($id);

		
	}
	
}