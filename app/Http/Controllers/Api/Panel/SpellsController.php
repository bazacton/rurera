<?php

namespace App\Http\Controllers\Api\Panel;

use App\Http\Controllers\Api\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\User;
use App\Models\Category;
use App\Models\Webinar;
use App\Models\ApiCalls;
use App\Models\Quiz;
use App\Models\QuizzesResult;
use App\Models\QuizzAttempts;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class SpellsController extends Controller
{
    public function index(Request $request){
		
		$user = apiAuth();
		$query = Quiz::where('status', Quiz::ACTIVE)->where('quiz_type', 'vocabulary')->where('year_id', $user->year_id);

		
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
				$quiz_slug .= '/'.$spellObj->quiz_slug;
				$data_array[$section_id]['section_data'][] = array(
					'title' => $spellObj->getTitleAttribute(),
					'description' => '',
					'icon' => '',
					'icon_position' => 'right',
					'background' => '',
					'pageTitle' => $spellObj->getTitleAttribute(),
					'target_api' => '/panel/'.$quiz_slug.'/spelling-list',
					'target_layout' => 'list',
					'test' => $spellObj->id,
					'buttons' => array(
						array(
							'title' => 'Practice',
							'position' => 'left',
							'icon' => '',
							'target_api' => '/panel/'.$quiz_slug.'/practice',
							'target_layout' => 'list',
						),
						array(
							'title' => 'Take Test',
							'position' => 'left',
							'icon' => '',
							'target_api' => '/panel/'.$quiz_slug.'/take-test',
							'target_layout' => 'list',
						),
					),
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
	* Practice Form
	*/
	
	public function practice(Request $request, $year_slug, $spell_slug){
		
		$form_fields = [];
		$user = apiAuth();
		
		$categoryObj = Category::where('slug', $year_slug)->first();
		$spellQuiz = Quiz::where('quiz_slug', $spell_slug)->where('year_id', $categoryObj->id)->first();
		$quiz_slug = isset( $spellQuiz->quizYear->slug )? $spellQuiz->quizYear->slug : '';
		$quiz_slug .= '/'.$spellQuiz->quiz_slug;
		$words_list = array();
		if (!empty($spellQuiz->quizQuestionsList)) {
            foreach ($spellQuiz->quizQuestionsList as $questionsListData) {
                $SingleQuestionData = $questionsListData->SingleQuestionData;
				if( !isset( $SingleQuestionData->id ) ){
					continue;
				}
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
                            'letter_pronounce' => isset( $phonic_data['word'] )? '/'.$phonic_data['word'].'/' : '',
							'audio' => isset( $phonic_data['sound'] )? url('/').'/phonics/'.$phonic_data['sound'] : '',
						);
                        $phonics_counter++;
                    }
                }
				
                $words_list[] = array(
						"key" => $SingleQuestionData->id,
						"value" => $audio_text,
						'audio_text'      => $audio_text,
						'audio_sentense'  => $audio_sentense,
						'defination' => $audio_defination,
						'audio_file'      => url('/').$audio_file,
						'word_audio_file' => url('/').$word_audio_file,
						'phonics'    => $phonics_data,
                );
            }

        }
		
		
		$data_array = array();
		$section_id = 0;
		$data_array[$section_id] = array(
			'section_id' => $section_id,
			'section_title' => '',
            'section_description' => '',
			'section_data' => array(),
		);
		
		$data_array[$section_id]['section_data'] = array(
			array(
				"field_name" => "practice_type",
				"field_type" => "choice",
				"element_layout" => "block",
				"label" => "Choose Practice Type",
				"hint" => "",
				"order" => 0,
				"required" => true,
				"multiple" => false,
				"value" => "word-hunts",
				"icon" => "",
				"data" => array(
					array(
						"key" => "word-hunts",
						"value" => "Word Hunts",
					),
					array(
						"key" => "word-search",
						"value" => "Word Search",
					),
					array(
						"key" => "word-cloud",
						"value" => "Word Cloud",
					),
					array(
						"key" => "word-missing",
						"value" => "Practice Test",
					),
				)
			),
			array(
				"field_name" => "spell_words",
				"field_type" => "spell_choice",
				"element_layout" => "block",
				"order" => 1,
				"required" => false,
				"multiple" => true,
				"label" => "Choosen Words (Default All Selected)",
				"hint" => "",
				"value" => "",
				"icon" => "",
				"data" => $words_list
			),
			
			array(
				'field_name' => 'submit',
				'field_type' => 'button',
				'element_layout' => 'submit',
				'required' => false,
				'label' => 'Play',
				'icon' => '',
				'data' => '',
				'target_api_type' => "POST",
				'target_api' => '/panel/'.$quiz_slug.'/practice/play',
			),
		);
		
		$response = array(
			'form' => $data_array,
		);
		
		       
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }
	
	/*
	* Practice Play
	*/
	
	public function practice_play(Request $request, $year_slug, $spell_slug){
		
		$form_fields = [];
		$user = apiAuth();
		
		ApiCalls::create([
			'user_id' => $user->id,	
			'device_id' => $request->input('device_id', 0),	
			'api_name' => 'practice_play',
			'api_data' => json_encode($request->all()),
			'updated_at' => time(),
		]);
		$categoryObj = Category::where('slug', $year_slug)->first();
		$spellQuiz = Quiz::where('quiz_slug', $spell_slug)->where('year_id', $categoryObj->id)->first();
		
		$quiz_slug = isset( $spellQuiz->quizYear->slug )? $spellQuiz->quizYear->slug : '';
		$quiz_slug .= '/'.$spellQuiz->quiz_slug;
		
		$practice_type = $request->get('practice_type');
		$spell_words = $request->get('spell_words');
		$spell_words = is_array( $spell_words )? $spell_words : json_decode($spell_words);
		$questions_array_list = array();
		$question_serial = 1;
		
		
		$QuizController = new QuizController();
		$quiz_response = $QuizController->get_learn_quiz_data($spellQuiz, 'easy', 'no', $spell_words, 'yes', $practice_type, 'no', '');
		$resultLogObj = isset( $quiz_response['resultLogObj'] )? $quiz_response['resultLogObj']  : array();
		$attemptLogObj = isset( $quiz_response['attemptLogObj'] )? $quiz_response['attemptLogObj']  : array();
		$questions_list = isset( $quiz_response['questions_list'] )? $quiz_response['questions_list']  : array();
		$spells_questions_array = isset( $quiz_response['results_questions_array'] )? $quiz_response['results_questions_array']  : array();
		if( !empty( $spells_questions_array ) ){
			foreach( $spells_questions_array as $question_attempt_id => $spell_data){
				$questionObj = isset($spell_data['question'])? $spell_data['question'] : array();
				$question_id = isset( $questionObj->id )? $questionObj->id : 0;
				$word_data = isset($spell_data['word_data'])? $spell_data['word_data'] : array();
				$correct_answer = isset( $word_data['audio_text'] )? $word_data['audio_text'] : '';
				//pre($spell_data['word_data'], false);
				
				$correct_chars = $filled_chars = $fillable_chars = $chars_array = array();
				$hidden_indexes = getRandomIndexes($correct_answer);
				foreach( $hidden_indexes as $index_no){
					$fillable_chars[] = substr($correct_answer, $index_no,1);
				}
				for ($i = 0; $i < strlen($correct_answer); $i++) {
					$chars_array[] = array(
						'char' => $correct_answer[$i],
						'isFilled' => !in_array($i, $hidden_indexes)? true : false,
						'isClickable' => !in_array($i, $hidden_indexes)? false : true,
					);
				}

				
				$correct_chars = $fillable_chars;
				$random_characters = getRandomCharacters($fillable_chars);
				$fillable_chars = array_merge($fillable_chars, $random_characters);
				shuffle($fillable_chars);
				
				$questions_array_list[] = array(
					'question_serial' => $question_serial,
					'coins' => 1,
					'game_time' => 25,
					'attempt_question_id' => $question_attempt_id,
					'question_id' => $question_id,
                    'correct_answer'     => $correct_answer,
                    'sentence'       => isset( $word_data['audio_sentense'] )? $word_data['audio_sentense'] : '',
                    'definition'     => isset( $word_data['audio_defination'] )? $word_data['audio_defination'] : '',
                    'sentence_audio' => isset( $word_data['audio_file'] )? url('/').$word_data['audio_file'] : '',
                    'text_audio'    => isset( $word_data['word_audio'] )? url('/').$word_data['word_audio'] : '',
                    'filledCharacters'    => $chars_array,
                    'fillableCharacters'    => $fillable_chars,
                );
				
				$question_serial++;
			}
		}
		
		
		$section_id = 0;
		$data_array[$section_id] = array(
			'section_id' => $section_id,
			'result_id' => isset( $resultLogObj->id )? $resultLogObj->id  : 0,
			'attempt_id' => isset( $attemptLogObj->id )? $attemptLogObj->id  : 0,
			'questions' => $questions_array_list,
			'target_api_type' => "POST",
			'target_api' => '/panel/'.$quiz_slug.'/submit_spell',
		);
		
		$response = $data_array;
		
        
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
                            'letter_pronounce' => isset( $phonic_data['word'] )? '/'.$phonic_data['word'].'/' : '',
							'audio' => isset( $phonic_data['sound'] )? url('/').'/phonics/'.$phonic_data['sound'] : '',
						);
						
                        $phonics_counter++;
                    }
                }
                $words_list[] = array(
                    'audio_text'      => $audio_text,
                    'audio_sentense'  => $audio_sentense,
                    'defination' => $audio_defination,
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
	
	
	
	
	/*
	* Spell Submit
	*/
	
	public function submit_spell(Request $request){
		
		$form_fields = [];
		$user = apiAuth();
		$result_id = $request->get('result_id');
		$attempt_id = $request->get('attempt_id');
		$questions = $request->get('questions');
		$spells_data = is_array( $questions )? $questions : json_decode($questions);
		
		$QuestionsAttemptController = new QuestionsAttemptController();
		
		ApiCalls::create([
			'user_id' => $user->id,	
			'device_id' => $request->input('device_id', 0),	
			'api_name' => 'submit_spell',
			'api_data' => json_encode($request->all()),
			'updated_at' => time(),
		]);
		
		
		$section_id = 0;
		$data_array[$section_id] = array(
			'section_id' => $section_id,
			'completed_quests' => [],
		);
		
		$response = $data_array;
		
        
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }
 }
