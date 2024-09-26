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
	
	/*
	* Spelling List
	*/
	public function spelling_list(Request $request, $category_slug, $spell_slug){
		$user = apiAuth();
        $categoryObj = Category::where('slug', $category_slug)->first();
        $mastered_words = $in_progress_words = $non_mastered_words = array();
        $spellQuiz = Quiz::where('quiz_slug', $spell_slug)->where('year_id', $categoryObj->id)->first();
		$data_array = array();
		$section_id = 0;
		$data_array[$section_id] = array(
			'section_id' => $section_id,
			'section_title' => '',
			'section_data' => array(),
		);
		$mastered_words_list = isset($UserVocabulary->mastered_words) ? (array)json_decode($UserVocabulary->mastered_words) : array();
        $in_progress_words_list = isset($UserVocabulary->in_progress_words) ? (array)json_decode($UserVocabulary->in_progress_words) : array();
        $non_mastered_words_list = isset($UserVocabulary->non_mastered_words) ? (array)json_decode($UserVocabulary->non_mastered_words) : array();
        $words_response = '';
        if (!empty($spellQuiz->quizQuestionsList)) {
            foreach ($spellQuiz->quizQuestionsList as $questionsListData) {
                $SingleQuestionData = $questionsListData->SingleQuestionData;
                if (isset($mastered_words_list[$SingleQuestionData->id])) {
                    $mastered_words[$SingleQuestionData->id] = $mastered_words_list[$SingleQuestionData->id];
                }
                if (isset($in_progress_words_list[$SingleQuestionData->id])) {
                    $in_progress_words[$SingleQuestionData->id] = $in_progress_words_list[$SingleQuestionData->id];
                }
                if (isset($non_mastered_words_list[$SingleQuestionData->id])) {
                    $non_mastered_words[$SingleQuestionData->id] = $non_mastered_words_list[$SingleQuestionData->id];
                }
                //pre($SingleQuestionData->id);
                $layout_elements = isset($SingleQuestionData->layout_elements) ? json_decode($SingleQuestionData->layout_elements) : array();
                $correct_answer = $audio_file = $word_audio_file = $audio_text = $audio_sentense = $audio_defination = '';
                if (!empty($layout_elements)) {
                    foreach ($layout_elements as $elementData) {
                        $element_type = isset($elementData->type) ? $elementData->type : '';
                        $content = isset($elementData->content) ? $elementData->content : '';
                        $word_audio = isset($elementData->word_audio) ? $elementData->word_audio : '';
                        $correct_answer = isset($elementData->correct_answer) ? $elementData->correct_answer : $correct_answer;
                        $audio_text = isset($elementData->audio_text) ? $elementData->audio_text : $audio_text;
                        $audio_sentense = isset($elementData->audio_sentense) ? $elementData->audio_sentense : $audio_sentense;
                        $audio_defination = isset($elementData->audio_defination) ? $elementData->audio_defination : $audio_defination;
                        if ($element_type == 'audio_file') {
                            $audio_file = $content;
                            $word_audio_file = $word_audio;
                            $audio_text = $audio_text;
                            $audio_sentense = $audio_sentense;
                            $audio_defination = $audio_defination;
                        }
                        if ($element_type == 'textfield_quiz') {
                            $correct_answer = $correct_answer;
                        }
                    }
                }
                /*pre('Correct Answere: '.$correct_answer, false);
                pre('Audio File: '.$audio_file, false);
                pre('Aaudio Text: '.$audio_text, false);
                pre('Aaudio Sentense: '.$audio_sentense, false);
                pre('<br><br><br>', false);*/
                $audio_sentense = str_replace($audio_text, '<strong>' . $audio_text . '</strong>', $audio_sentense);
                $audio_sentense = str_replace(strtolower($audio_text), '<strong>' . strtolower($audio_text) . '</strong>', $audio_sentense);

                $phonics_sounds = '';
				$phonics_data = array();
                $phonics_array = get_words_phonics($audio_text);
                $phonics_counter = 1;
                if( !empty( $phonics_array ) ){
                    foreach( $phonics_array as $phonic_data){
						$phonics_data[] = array(
							'letter' => isset( $phonic_data['letter'] )? $phonic_data['letter'] : '',
							'audio' => isset( $phonic_data['sound'] )? url('/').'/phonics/'.$phonic_data['sound'] : '',
						);
						
                        $phonics_counter++;
                    }
                }
                $words_list[] = array(
                    'audio_text'      => $audio_text,
                    'audio_sentense'  => $audio_sentense,
                    'audio_file'      => url('/').$audio_file,
                    'word_audio_file' => url('/').$word_audio_file,
                    'phonics'      => $phonics_data,
                );

            }
        }
		$data_array[$section_id]['section_data'] = $words_list;
		
		
		
        $response = array(
			'listData' => $data_array,
		);
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }
 }
