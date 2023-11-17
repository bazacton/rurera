<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\Models\Category;
use App\Models\Page;
use App\Models\Quiz;
use App\Models\UserAssignedTopics;
use App\Models\UserVocabulary;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class SpellsController extends Controller
{

    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();
        $QuestionsAttemptController = new QuestionsAttemptController();
        $summary_type = 'vocabulary';
        $QuizzResultQuestionsObj = $QuestionsAttemptController->prepare_graph_data($summary_type);
        $page = Page::where('link', '/spells')->where('status', 'publish')->first();


        $UserVocabulary = UserVocabulary::where('user_id', $user->id)->where('status', 'active')->first();
        $mastered_words = isset( $UserVocabulary->mastered_words )? (array) json_decode($UserVocabulary->mastered_words) : array();
        $in_progress_words = isset( $UserVocabulary->in_progress_words )? (array) json_decode($UserVocabulary->in_progress_words) : array();
        $non_mastered_words = isset( $UserVocabulary->non_mastered_words )? (array) json_decode($UserVocabulary->non_mastered_words) : array();


        $graphs_array = array();

        $start_date = strtotime('2023-09-20');
        $end_date = strtotime('2023-09-26');

        $custom_dates = array(
            'start' => $start_date,
            'end' => $end_date,
        );

        $graphs_array['Custom'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'custom', $start_date, $end_date);

        $graphs_array['Year'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'yearly');
        $graphs_array['Month'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'monthly');
        $graphs_array['Week'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'weekly');
        $graphs_array['Day'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'daily');
        $graphs_array['Hour'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'hourly');



        $year_group = $request->get('year_group', null);
        $subject = $request->get('subject', null);
        $examp_board = $request->get('examp_board', null);
        $year_id = $request->get('year', '');
        $quiz_category = $request->get('quiz_category', '');

        $query = Quiz::with(['quizQuestionsList'])->where('status', Quiz::ACTIVE)->where('quiz_type', 'vocabulary');
        if( $year_id != ''){
            $query->where('year_id', $year_id);
        }
        if( $quiz_category != '' && $quiz_category != 'All'){
            $query->where('quiz_category', $quiz_category);
        }


        $parent_assignedArray = UserAssignedTopics::where('parent_id', $user->id)->where('status', 'active')->select('id', 'parent_id', 'topic_id', 'assigned_to_id', 'deadline_date')->get()->toArray();
        $parent_assigned_list = array();
        if (!empty($parent_assignedArray)) {
            foreach ($parent_assignedArray as $parent_assignedObj) {
                $topic_id = isset($parent_assignedObj['topic_id']) ? $parent_assignedObj['topic_id'] : 0;
                $assigned_to_id = isset($parent_assignedObj['assigned_to_id']) ? $parent_assignedObj['assigned_to_id'] : 0;
                $deadline_date = isset($parent_assignedObj['deadline_date']) ? $parent_assignedObj['deadline_date'] : 0;
                $parent_assigned_list[$topic_id][$assigned_to_id] = $parent_assignedObj;
                $parent_assigned_list[$topic_id]['deadline_date'] = $deadline_date;
            }
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

        $spellsData = $query->paginate(100);


        $childs = array();
        if (auth()->user()->isParent()) {
            $childs = User::where('role_id', 1)
                ->where('parent_type', 'parent')
                ->where('parent_id', $user->id)
                ->where('status', 'active')
                ->get();
        }

        if (auth()->user()->isTeacher()) {
            $childs = User::where('role_id', 1)
                ->where('parent_type', 'teacher')
                ->where('parent_id', $user->id)
                ->where('status', 'active')
                ->get();
        }
        $categories = Category::where('parent_id', null)
                            ->with('subCategories')->orderBy('order', 'asc')
                            ->get();

        if (!empty($spellsData)) {
            $data = [
                'pageTitle'       => $page->title,
                'pageDescription' => $page->seo_description,
                'pageRobot'       => $page->robot ? 'index, follow, all' : 'NOODP, nofollow, noindex',
                'data'                       => $spellsData,
                'QuestionsAttemptController' => $QuestionsAttemptController,
                'childs'                     => $childs,
                'parent_assigned_list'       => $parent_assigned_list,
                'graphs_array'  => $graphs_array,
                'summary_type'  => $summary_type,
                'custom_dates' => $custom_dates,
                'user_mastered_words' => $mastered_words,
                'user_in_progress_words' => $in_progress_words,
                'user_non_mastered_words' => $non_mastered_words,
                'categories' => $categories,
            ];
            return view('web.default.vocabulary.index', $data);
        }

        abort(404);
    }

    public function words_list(Request $request, $quiz_slug)
    {

        $spellQuiz = Quiz::where('quiz_slug', $quiz_slug)->first();
        $words_response = '';
        if( !empty( $spellQuiz->quizQuestionsList ) ){
           foreach( $spellQuiz->quizQuestionsList as $questionsListData){
               $SingleQuestionData = $questionsListData->SingleQuestionData;
               $layout_elements = isset( $SingleQuestionData->layout_elements )? json_decode($SingleQuestionData->layout_elements) : array();
               $correct_answer = $audio_file = $word_audio_file = $audio_text = $audio_sentense = $audio_defination = '';
               if( !empty( $layout_elements ) ){
                   foreach( $layout_elements as $elementData){
                       $element_type = isset( $elementData->type )? $elementData->type : '';
                       $content = isset( $elementData->content )? $elementData->content : '';
                       $word_audio = isset( $elementData->word_audio )? $elementData->word_audio : '';
                       $correct_answer = isset( $elementData->correct_answer )? $elementData->correct_answer : $correct_answer;
                       $audio_text = isset( $elementData->audio_text )? $elementData->audio_text : $audio_text;
                       $audio_sentense = isset( $elementData->audio_sentense )? $elementData->audio_sentense : $audio_sentense;
                       $audio_defination = isset( $elementData->audio_defination )? $elementData->audio_defination : $audio_defination;
                       if( $element_type == 'audio_file'){
                           $audio_file = $content;
                           $word_audio_file = $word_audio;
                           $audio_text = $audio_text;
                           $audio_sentense = $audio_sentense;
                           $audio_defination = $audio_defination;
                       }
                       if( $element_type == 'textfield_quiz'){
                           $correct_answer = $correct_answer;
                       }
                   }
               }
               /*pre('Correct Answere: '.$correct_answer, false);
               pre('Audio File: '.$audio_file, false);
               pre('Aaudio Text: '.$audio_text, false);
               pre('Aaudio Sentense: '.$audio_sentense, false);
               pre('<br><br><br>', false);*/
              $audio_sentense = str_replace($audio_text, '<strong>'.$audio_text.'</strong>', $audio_sentense);
              $audio_sentense = str_replace(strtolower($audio_text), '<strong>'.strtolower($audio_text).'</strong>', $audio_sentense);
               $words_list[] = array(
                   'audio_text' => $audio_text,
                   'audio_sentense' => $audio_sentense,
                   'audio_file' => $audio_file,
                   'word_audio_file' => $word_audio_file,
               );

               $words_response .= '<tr>
                   <td>
                   <a href="javascript:;" class="play-btn" data-id="player-'.$SingleQuestionData->id.'">
                       <img class="play-icon" src="/assets/default/svgs/play-circle.svg" alt="" height="20" width="20">
                       <img class="pause-icon" src="/assets/default/svgs/pause-circle.svg" alt="" height="20" width="20">
                   <div class="player-box">
                   <audio class="player-box-audio" id="player-'.$SingleQuestionData->id.'" src="'.$word_audio_file.'"> </audio>
                   </div>
                   </a>
                   </td>
                   <td>'.$audio_text.'</td>
                   <td>
                  <p>'.$audio_defination.'</p>
                  </td>
                   <td>
                   <p>'.$audio_sentense.'</p>
                   </td>
               </tr>';
           }
       }

        if (!empty($spellQuiz)) {
            $data = [
                'pageTitle'                  => 'Words List',
                'spellQuiz'                       => $spellQuiz,
                'words_response'             => $words_response,

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
       if( !empty( $spellQuiz->quizQuestionsList ) ){
           foreach( $spellQuiz->quizQuestionsList as $questionsListData){
               $SingleQuestionData = $questionsListData->SingleQuestionData;
               $layout_elements = isset( $SingleQuestionData->layout_elements )? json_decode($SingleQuestionData->layout_elements) : array();
               $correct_answer = $audio_file = $audio_text = $audio_sentense = '';
               if( !empty( $layout_elements ) ){
                   foreach( $layout_elements as $elementData){
                       $element_type = isset( $elementData->type )? $elementData->type : '';
                       $content = isset( $elementData->content )? $elementData->content : '';
                       $correct_answer = isset( $elementData->correct_answer )? $elementData->correct_answer : $correct_answer;
                       $audio_text = isset( $elementData->audio_text )? $elementData->audio_text : $audio_text;
                       $audio_sentense = isset( $elementData->audio_sentense )? $elementData->audio_sentense : $audio_sentense;
                       if( $element_type == 'audio_file'){
                           $audio_file = $content;
                           $audio_text = $audio_text;
                           $audio_sentense = $audio_sentense;
                       }
                       if( $element_type == 'textfield_quiz'){
                           $correct_answer = $correct_answer;
                       }
                   }
               }



               $audio_sentense = str_replace($audio_text, '<strong>'.$audio_text.'</strong>', $audio_sentense);
               $audio_sentense = str_replace(strtolower($audio_text), '<strong>'.strtolower($audio_text).'</strong>', $audio_sentense);
               $words_list[] = array(
                   'audio_text' => $audio_text,
                   'audio_sentense' => $audio_sentense,
                   'audio_file' => $audio_file,
               );

               $words_response .= '<tr>
                   <td>
                   <a href="javascript:;" class="play-btn" data-id="player-'.$SingleQuestionData->id.'">
                       <img class="play-icon" src="../assets/default/svgs/play-circle.svg" alt="" height="20" width="20">
                       <img class="pause-icon" src="../assets/default/svgs/pause-circle.svg" alt="" height="20" width="20">
                   <div class="player-box">
                   <audio class="player-box-audio" id="player-'.$SingleQuestionData->id.'" src="'.$audio_file.'"> </audio>
                   </div>
                   </a>
                   </td>
                   <td>'.$audio_text.'</td>
                   <td>
                   <p>'.$audio_sentense.'</p>
                   </td>
               </tr>';
           }
       }

       echo $words_response;exit;
   }

    /*
     * Start SAT Quiz
     */
    public function start(Request $request, $quiz_slug)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        /*if (!auth()->subscription('vocabulary')) {
            return view('web.default.quizzes.not_subscribed');
        }*/
        $quiz = Quiz::where('quiz_slug', $quiz_slug)->first();
        $id = $quiz->id;
        //$quiz = Quiz::find($id);

        $QuestionsAttemptController = new QuestionsAttemptController();

        //$started_already = $QuestionsAttemptController->started_already($id);

        $started_already = false;
        if ($started_already == true) {
            $data = [
                'pageTitle'  => 'Start',
                'quiz'       => $quiz,
            ];
            return view('web.default.quizzes.auto_load', $data);
            //$QuizController = new QuizController();
            //return $QuizController->start($request, $id);
        } else {
            $resultData = $QuestionsAttemptController->get_result_data($id);
            $resultData = $QuestionsAttemptController->prepare_result_array($resultData);
            $is_passed = isset($resultData->is_passed) ? $resultData->is_passed : false;
            $in_progress = isset($resultData->in_progress) ? $resultData->in_progress : false;
            $current_status = isset($resultData->current_status) ? $resultData->current_status : '';
            $data = [
                'pageTitle'  => 'Start',
                'quiz'       => $quiz,
                'resultData' => $resultData
            ];
            return view('web.default.quizzes.start', $data);
        }
    }


}
