<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\Models\Category;
use App\Models\Page;
use App\Models\Quiz;
use App\Models\UserAssignedTopics;
use App\Models\UserVocabulary;
use App\Models\QuizzesResult;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Route;

class SpellsController extends Controller
{

    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        if (!auth()->user()->isUser()) {
            return redirect('/'.panelRoute());
        }
        $user = getUser();
        $QuestionsAttemptController = new QuestionsAttemptController();
		
		
		/*$QuizzesResult = QuizzesResult::find(2);	
		$results = json_decode($QuizzesResult->results);
		$data_array = array(
			'QuizzesResult' => $QuizzesResult,
			'results'	=> $results,
		);
		return view('web.default.panel.finish_response.spell_finish', $data_array)->render();;
		abort(404);*/
		

        //$QuestionsAttemptController->after_attempt_complete(6);
        $page = Page::where('link', '/spells')->where('status', 'publish')->first();
        //pre(auth()->user()->vocabulary_achieved_levels);


        $UserVocabulary = UserVocabulary::where('user_id', $user->id)->where('status', 'active')->first();
        $mastered_words = isset($UserVocabulary->mastered_words) ? (array)json_decode($UserVocabulary->mastered_words) : array();
        $in_progress_words = isset($UserVocabulary->in_progress_words) ? (array)json_decode($UserVocabulary->in_progress_words) : array();
        $non_mastered_words = isset($UserVocabulary->non_mastered_words) ? (array)json_decode($UserVocabulary->non_mastered_words) : array();



        $year_group = $request->get('year_group', null);
        $subject = $request->get('subject', null);
        $examp_board = $request->get('examp_board', null);
        $year_id = $request->get('year', '');
        $quiz_category = $request->get('quiz_category', '');
        $query = Quiz::where('status', Quiz::ACTIVE)->where('quiz_type', 'vocabulary');
        $year_id = $user->year_id;
        if ($year_id != '') {
            $query->where('year_id', $year_id);
        }
        if ($quiz_category != '' && $quiz_category != 'All') {
            $query->where('quiz_category', $quiz_category);
        }

        if (!empty($year_group) and $year_group !== 'All') {
            $query->where('year_group', $year_group);
        }

        if (!empty($subject) and $subject !== 'All') {
            $query->where('subject', $subject);
        }	

        if (!empty($examp_board) and $examp_board !== 'All') {
            $query->where('examp_board', $examp_board);
        }

        $spellsData = $query->paginate(200);


        $categories = Category::where('parent_id', null)
            ->with('subCategories')->orderBy('order', 'asc')
            ->get();
			
			
		

        if (!empty($spellsData)) {
            $data = [
                'pageTitle'                  => $page->title,
                'pageDescription'            => $page->seo_description,
                'pageRobot'                  => $page->robot ? 'index, follow, all' : 'NOODP, nofollow, noindex',
                'data'                       => $spellsData,
                'QuestionsAttemptController' => $QuestionsAttemptController,
                'user_mastered_words'        => $mastered_words,
                'user_in_progress_words'     => $in_progress_words,
                'user_non_mastered_words'    => $non_mastered_words,
                'categories'                 => $categories,
                'quiz_category' => $quiz_category,
				'user' => $user,
            ];
            return view('web.default.vocabulary.index', $data);
        }

        abort(404);
    }

    public function words_list(Request $request, $quiz_slug)
    {

        $category_slug = substr(collect(Route::getCurrentRoute()->action['prefix'])->last(), 1);
        $categoryObj = Category::where('slug', $category_slug)->first();
        $mastered_words = $in_progress_words = $non_mastered_words = array();
        $spellQuiz = Quiz::where('quiz_slug', $quiz_slug)->where('year_id', $categoryObj->id)->first();
        $UserVocabulary = array();
        if (auth()->check()) {
            $user = auth()->user();
            $UserVocabulary = UserVocabulary::where('user_id', $user->id)->where('status', 'active')->first();
        }
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

                $phonics_text = $phonics_sounds = '';
                $phonics_array = get_words_phonics($audio_text);
                $phonics_counter = 1;
                if( !empty( $phonics_array ) ){
                    foreach( $phonics_array as $phonic_data){
						$phonics_text .= '<div class="word-char">';
						$phonics_text .= '<span class="pronounce-letter">';
                        $phonics_text .= isset( $phonic_data['letter'] )? $phonic_data['letter']: '';
						$phonics_text .= '</span><span class="pronounce-word">';
                        $phonics_text .= isset( $phonic_data['word'] )? '/'.$phonic_data['word'].'/': '';
						$phonics_text .= '</span><span class="pronounce-audio">';
                        $phonicSound = isset( $phonic_data['sound'] )? $phonic_data['sound'] : '';
						$phonics_text .= '<a href="javascript:;" class="play-btn" data-id="player-phonics-' . $SingleQuestionData->id . '-'.$phonics_counter.'">
						   <img class="play-icon" src="/assets/default/svgs/play-circle.svg" alt="" height="20" width="20">
						   <img class="pause-icon" src="/assets/default/svgs/pause-circle.svg" alt="" height="20" width="20">
						   <div class="player-box">
						   <audio class="player-box-audio" id="player-phonics-' . $SingleQuestionData->id . '-'.$phonics_counter.'" src="/phonics/'.$phonicSound.'"></audio>
						   </div>
					   </a></span>';
						$phonics_text .= '</div>';
                        $phonics_counter++;
                    }
                }
                $words_list[] = array(
                    'audio_text'      => $audio_text,
                    'audio_sentense'  => $audio_sentense,
                    'audio_file'      => $audio_file,
                    'word_audio_file' => $word_audio_file,
                    'phonics'      => $phonics_text,
                );

                $words_response .= '<tr>
                   <td>
                   <a href="javascript:;" class="play-btn" data-id="player-' . $SingleQuestionData->id . '">
                       <img class="play-icon" src="/assets/default/svgs/play-circle.svg" alt="" height="20" width="20">
                       <img class="pause-icon" src="/assets/default/svgs/pause-circle.svg" alt="" height="20" width="20">
                   <div class="player-box">
                   <audio class="player-box-audio" id="player-' . $SingleQuestionData->id . '" src="' . $word_audio_file . '"> </audio>
                   </div>
                   </a>
                   </td>
                   <td>' . $audio_text . '<br>
                   '.$phonics_text.'
                   <a href="javascript:;" class="phonics-btn" data-id="player-phonics-' . $SingleQuestionData->id . '">
                                          <img class="play-icon" src="/assets/default/svgs/play-circle.svg" alt="" height="20" width="20">
                                          <img class="pause-icon" src="/assets/default/svgs/pause-circle.svg" alt="" height="20" width="20">
                                      <div class="player-box">
                                      '.$phonics_sounds.'
                                      </div>
                                      </a>
                   </td>
                   <td>
                  <p>' . $audio_defination . '</p>
                  </td>
                   <td>
                   <p>' . $audio_sentense . '</p>
                   </td>
               </tr>';
            }

        }
        $total_questions = isset($spellQuiz->quizQuestionsList) ? count($spellQuiz->quizQuestionsList) : 0;
        $non_used_words = ($total_questions - count($mastered_words) - count($in_progress_words) - count($non_mastered_words));


        if (!empty($spellQuiz)) {
            $data = [
                'pageTitle'           => 'Words List',
                'spellQuiz'           => $spellQuiz,
                'words_response'      => $words_response,
                'user_mastered_words' => $mastered_words,
                'in_progress_words'   => $in_progress_words,
                'user_non_mastered_words'  => $non_mastered_words,
                'non_used_words'      => $non_used_words,

            ];
            return view('web.default.vocabulary.words_list', $data);
        }

        abort(404);
    }

    /*
    * Words List by Quiz ID
    */
    public function words_list_bk(Request $request)
    {
        $quiz_id = $request->get('quiz_id', null);
        $words_list = array();
        $words_response = '';
        $spellQuiz = Quiz::find($quiz_id);
        if (!empty($spellQuiz->quizQuestionsList)) {
            foreach ($spellQuiz->quizQuestionsList as $questionsListData) {
                $SingleQuestionData = $questionsListData->SingleQuestionData;
                $layout_elements = isset($SingleQuestionData->layout_elements) ? json_decode($SingleQuestionData->layout_elements) : array();
                $correct_answer = $audio_file = $audio_text = $audio_sentense = '';
                if (!empty($layout_elements)) {
                    foreach ($layout_elements as $elementData) {
                        $element_type = isset($elementData->type) ? $elementData->type : '';
                        $content = isset($elementData->content) ? $elementData->content : '';
                        $correct_answer = isset($elementData->correct_answer) ? $elementData->correct_answer : $correct_answer;
                        $audio_text = isset($elementData->audio_text) ? $elementData->audio_text : $audio_text;
                        $audio_sentense = isset($elementData->audio_sentense) ? $elementData->audio_sentense : $audio_sentense;
                        if ($element_type == 'audio_file') {
                            $audio_file = $content;
                            $audio_text = $audio_text;
                            $audio_sentense = $audio_sentense;
                        }
                        if ($element_type == 'textfield_quiz') {
                            $correct_answer = $correct_answer;
                        }
                    }
                }


                $audio_sentense = str_replace($audio_text, '<strong>' . $audio_text . '</strong>', $audio_sentense);
                $audio_sentense = str_replace(strtolower($audio_text), '<strong>' . strtolower($audio_text) . '</strong>', $audio_sentense);
                $words_list[] = array(
                    'audio_text'     => $audio_text,
                    'audio_sentense' => $audio_sentense,
                    'audio_file'     => $audio_file,
                );

                $words_response .= '<tr>
                   <td>
                   <a href="javascript:;" class="play-btn" data-id="player-' . $SingleQuestionData->id . '">
                       <img class="play-icon" src="../assets/default/svgs/play-circle.svg" alt="" height="20" width="20">
                       <img class="pause-icon" src="../assets/default/svgs/pause-circle.svg" alt="" height="20" width="20">
                   <div class="player-box">
                   <audio class="player-box-audio" id="player-' . $SingleQuestionData->id . '" src="' . $audio_file . '"> </audio>
                   </div>
                   </a>
                   </td>
                   <td>' . $audio_text . '</td>
                   <td>
                   <p>' . $audio_sentense . '</p>
                   </td>
               </tr>';
            }
        }

        echo $words_response;
        exit;
    }

    /*
     * Start SAT Quiz
     */
    public function start(Request $request, $category_slug, $quiz_slug, $test_type = '')
    {
        if (!auth()->check()) {
            //return redirect('/login');
        }
        if (auth()->check() && auth()->user()->isParent()) {
            return redirect('/'.panelRoute());
        }
		$question_ids = $request->get('spell_words', []);
		$is_new = $request->get('is_new', 'no');

        /*if (!auth()->subscription('vocabulary')) {
            return view('web.default.quizzes.not_subscribed');
        }*/
		
        $categoryObj = Category::where('slug', $category_slug)->first();
		$quiz = Quiz::where('quiz_slug', $quiz_slug)->where('year_id', $categoryObj->id)->with([
            'quizQuestionsList' => function ($query) {
                $query->where('status', 'active');
            },
        ])->first();
        $id = $quiz->id;
		
        //$quiz = Quiz::find($id);

        $QuestionsAttemptController = new QuestionsAttemptController();

        //$started_already = $QuestionsAttemptController->started_already($id);

        $started_already = false;
        if ($started_already == true) {
            $data = [
                'pageTitle' => 'Start',
                'quiz'      => $quiz,
            ];
            return view('web.default.quizzes.auto_load', $data);
            //$QuizController = new QuizController();
            //return $QuizController->start($request, $id);
        } else {
            //$resultData = $QuestionsAttemptController->get_result_data($id);
            //$resultData = $QuestionsAttemptController->prepare_result_array($resultData);
            //$is_passed = isset($resultData->is_passed) ? $resultData->is_passed : false;
            //$in_progress = isset($resultData->in_progress) ? $resultData->in_progress : false;
            //$current_status = isset($resultData->current_status) ? $resultData->current_status : '';
            $resultData = array();
            $data = [
                'pageTitle'  => 'Start',
                'quiz'       => $quiz,
                'test_type'  => $test_type,
                'resultData' => $resultData,
                'question_ids'  => $question_ids,
                'is_new'  => $is_new,
            ];
            return view('web.default.quizzes.start', $data);
        }
    }


    public function search(Request $request)
    {
        $year_id = $request->get('year_id', '');
        $quiz_category = $request->get('quiz_category', '');
        $query = Quiz::with(['quizQuestionsList'])->where('status', Quiz::ACTIVE)->where('quiz_type', 'vocabulary');
        if ($year_id != '') {
            $query->where('year_id', $year_id);
        }
        if ($quiz_category != '' && $quiz_category != 'all') {
            $query->where('quiz_category', $quiz_category);
        }

        $spellsData = $query->paginate(200);
        $QuestionsAttemptController = new QuestionsAttemptController();
        $counter = 0;
        $response_layout = '<h4 class="total-tests has-border font-22 mt-20 mb-20">Total Lists: '.$spellsData->count().'</h4>';
		$response_layout = '';
        if (!empty($spellsData)) {
            foreach ($spellsData as $rowObj) {
                $view_file = 'single_item_assignment';
                $response_layout .= view('web.default.tests.'.$view_file, [
                    'rowObj'                     => $rowObj,
                    'QuestionsAttemptController' => $QuestionsAttemptController,
                    'counter'                    => $counter
                ])->render();
            }
        }
        echo $response_layout;
        exit;
    }
	
	public function words_data(Request $request)
    {
        $spell_id = $request->get('spell_id', null);
		$spell_type = $request->get('spell_type', null);
		$sort_by = $request->get('sort_by', 'alphabetically');
		$search_word = $request->get('search_word', '');
		
		$spellData = Quiz::find($spell_id);
		$vocabulary_response = $spellData->vocabulary_words();
		$vocabulary_words = isset( $vocabulary_response['words_list'] )? $vocabulary_response['words_list'] : array();
		$word_details_array = isset( $vocabulary_response['words_response'] )? $vocabulary_response['words_response'] : array();
		$QuestionsAttemptController = new QuestionsAttemptController();
		
		$questionResults = $QuestionsAttemptController->get_questions_results($vocabulary_words, 'vocabulary', '');
		$response = '';
		$words_list  = array();
		if( !empty( $vocabulary_words ) ){
			foreach( $vocabulary_words as $question_id => $word){
				if ($search_word != '') {
					if(stripos($word, $search_word) === false){
						continue;
					}
				}
				$no_of_attempts = isset( $questionResults[$question_id]['total_attempts'] )? $questionResults[$question_id]['total_attempts'] : 0;
				$correct_attempts = isset( $questionResults[$question_id]['correct_attempts'] )? $questionResults[$question_id]['correct_attempts'] : 0;
				$incorrect_attempts = isset( $questionResults[$question_id]['incorrect_attempts'] )? $questionResults[$question_id]['incorrect_attempts'] : 0;
				$words_list[$question_id] = array(
					'no_of_attempts' => $no_of_attempts,
					'correct_attempts' => $correct_attempts,
					'incorrect_attempts' => $incorrect_attempts,
					'word' => $word,
				);
			}
		}
		if( $sort_by == 'alphabetically'){
			uasort($words_list, function($a, $b) {
				return strcmp($a['word'], $b['word']);
			});
		}
		if( $sort_by == 'attempts'){
			usort($words_list, function($a, $b) {
				return $b['no_of_attempts'] - $a['no_of_attempts'];
			});
		}
		
		if( !empty( $words_list ) ){
			$response .= '<div class="word-block-inner">';
			$counter = 0;
			foreach( $words_list as $question_id => $wordData){
				$no_of_attempts = isset( $wordData['no_of_attempts'] )? $wordData['no_of_attempts'] : 0;
				$correct_attempts = isset( $wordData['correct_attempts'] )? $wordData['correct_attempts'] : 0;
				$incorrect_attempts = isset( $wordData['incorrect_attempts'] )? $wordData['incorrect_attempts'] : 0;
				$word = isset( $wordData['word'] )? $wordData['word'] : 0;
				$counter++;
				if( $counter > 3){
					$response .= '<div class="word-block-inner-data"></div>';
					$response .= '</div><div class="word-block-inner">';
					$counter = 1;
				}
				//pre($questionResults->count());
				$response .= '<div class="word-block">';
				$response .= '  <label class="collapsed" for="checkbox-'.$question_id.'" data-toggle="collapses" data-target="#word-details-'.$question_id.'" aria-expanded="false">'.$word.' ('.$correct_attempts.') <span class="down-arrow"></spam></label>';
				$response .= '  <input type="checkbox" class="spell_checkbox hide1" id="checkbox-'.$question_id.'" name="spell_words[]" value="'.$question_id.'">';
				$response .= '<div class="word-details collapse" id="word-details-'.$question_id.'" aria-labelledby="word-details-'.$question_id.'" data-parent="#accordion"><button class="close-btn" type="button">&#10005;</button>';
				$response .= isset( $word_details_array[$question_id] )? $word_details_array[$question_id] : '';
				$response .= '</div>';

				
				$response .= '</div>';
			}
			$response .= '</div>';
		}
		echo $response;exit;
		
	}
	


}
