<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\QuizzesResult;
use App\Models\Webinar;
use App\Models\Category;
use App\Models\LearningJourneys;
use App\Models\LearningJourneyItems;
use App\Models\SubChapters;
use App\Models\Quiz;
use App\Models\WebinarChapterItem;
use Illuminate\Support\Facades\Mail;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

class LearningJourneyController extends Controller
{


	public function index($subject_slug = '')
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        if (!auth()->user()->isUser()) {
            return redirect('/'.panelRoute());
        }
        $user = getUser();
		$user_year = $user->year_id;
		
		$LearningJourneys = LearningJourneys::where('status', 'active')->where('year_id',$user_year)->get();
		
		
		//pre($learningJourneyLevels);
		
        $data = [
			'pageTitle'                  => 'Learning Journey',
			'LearningJourneys'           => $LearningJourneys,
			'user'           		 => $user,
		];
		return view('web.default.learning_journey.index', $data);

        abort(404);
    }
	
    public function subject($subject_slug = '')
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        if (!auth()->user()->isUser()) {
            return redirect('/'.panelRoute());
        }
		
        $user = getUser();
		$categoryObj = Category::find($user->year_id);
		$category_slug = $categoryObj->slug;
		//orderBy('sort_order', 'ASC')
		$course = Webinar::where('slug', $subject_slug)->whereJsonContains('category_id', (string) $categoryObj->id)->first();
		$lerningJourney = $course->lerningJourney;
		$student_learning_journey = $this->student_learning_journey($user->id, $lerningJourney->learningJourneyLevels);
		
		$items_data = isset( $student_learning_journey['items_data'] )? $student_learning_journey['items_data'] : array();
		
		$new_added_stages = isset( $student_learning_journey['new_added_stages'] )? $student_learning_journey['new_added_stages'] : array();
		
		//pre($learningJourneyLevels);
		
		$topicCount = 0;
		$treasureCount = 0;

		foreach ($items_data as $items) {
			foreach ($items as $item) {
				if ($item->item_type == 'topic') {
					$topicCount++;
				} elseif ($item->item_type == 'treasure') {
					$treasureCount++;
				}
			}
		}
		
		
        $data = [
			'pageTitle'                  => 'Learning Journey',
			'lerningJourney'			 => $lerningJourney,
			'learningJourneyLevels'		 => $lerningJourney->learningJourneyLevels,
			'student_learning_journey'	 => $student_learning_journey,
			'items_data'		 		=> $items_data,
			'new_added_stages'		 	=> $new_added_stages,
			'category_slug'		 	=> $category_slug,
			'subject_slug'		 	=> $subject_slug,
			'course'		 		=> $course,
			'topicCount'		 		=> $topicCount,
			'treasureCount'		 		=> $treasureCount,
		];
		return view('web.default.learning_journey.subject', $data);

        abort(404);
    }
	
	public function student_learning_journey($user_id, $learningJourneyLevels){
		$userObj = User::find($user_id);
		$studentJourneyItems = $userObj->studentJourneyItems->where('status','completed')->pluck('learning_journey_item_id','result_id')->toArray();
		
		
		$items_data = $new_added_stages = array();
		
		if( !empty( $learningJourneyLevels ) ){
			
			foreach( $learningJourneyLevels  as $levelObj){
				if($levelObj->learningJourneyItems->count() > 0){
					$item_counter = 0;
					foreach( $levelObj->learningJourneyItems->sortBy('sort_order') as $itemObj){
						
						$itemObj->percentage = 0;
						if( $itemObj->item_type == 'topic'){
							$student_journey_ids = $userObj->studentJourneyItems->where('learning_journey_item_id', $itemObj->id)->pluck('id')->toArray();
							$QuizzesResults = QuizzesResult::whereIn('student_journey_id', $student_journey_ids)->where('quiz_result_type', 'learning_journey')->get();
							if( $QuizzesResults->count() > 0){
								foreach( $QuizzesResults as $QuizzesResultObj){
									$quiz_breakdown = json_decode($QuizzesResultObj->quiz_breakdown);
									$total_questions = isset( $quiz_breakdown->{'Emerging'}->questions )? $quiz_breakdown->{'Emerging'}->questions : 0;
									$total_questions += isset( $quiz_breakdown->{'Expected'}->questions )? $quiz_breakdown->{'Expected'}->questions : 0;
									$total_questions += isset( $quiz_breakdown->{'Exceeding'}->questions )? $quiz_breakdown->{'Exceeding'}->questions : 0;
									//$total_questions += isset( $quiz_breakdown->{'Exceeding'}->excess_time_taken )? $quiz_breakdown->{'Exceeding'}->excess_time_taken : 0;								
									$total_correct_answers = $QuizzesResultObj->quizz_result_questions_list->where('status', 'correct')->count();
									$correct_percentage = round(($total_correct_answers * 100) / $total_questions);
									//pre($correct_percentage);
									$itemObj->percentage = ($itemObj->percentage < $correct_percentage)? $correct_percentage : $itemObj->percentage;
								}
							}
						}
						
						$item_counter++;
						$itemObj->is_completed = isset( $studentJourneyItems[$itemObj->id] )? true : false;
						$itemObj->completed_result = isset( $studentJourneyItems[$itemObj->id] )? $studentJourneyItems[$itemObj->id] : 0;
						$items_data[$levelObj->id][$item_counter] = $itemObj;
						
						//$sub_chapter_item->questions_list->count();
						
						
						
						//Check if previous item was not completed but the current is
						if( $itemObj->is_completed == true){
							$previous_counter = $item_counter;
							$previous_counter = $previous_counter - 1;
							$previous_item = isset( $items_data[$levelObj->id][$previous_counter] )? $items_data[$levelObj->id][$previous_counter] : array();
							if( isset( $previous_item->is_completed )){
								if( $previous_item->is_completed == false ){
									$new_added_stages[] = $previous_item;
									unset( $items_data[$levelObj->id][$previous_counter] );
								}
							}
						}
						
					}
				}
			}
			
		}
		
		return array(
			'items_data' => $items_data,
			'new_added_stages' => $new_added_stages,
		);
		
		
		
	}
	
	/*
     * Start Learning Journey
     */
    public function start(Request $request, $subject_slug, $sub_chapter_slug, $journey_item_id)
    {
        if (!auth()->subscription('courses')) {
            return view('web.default.quizzes.not_subscribed');
        }
		

        if (auth()->check() && auth()->user()->isParent()) {
            return redirect('/'.panelRoute());
        }
		


        $SubChapters = SubChapters::where('sub_chapter_slug', $sub_chapter_slug)
                    ->first();
					


        $chapterItem = WebinarChapterItem::where('type', 'quiz')
            ->where('parent_id', $SubChapters->id)
            ->first();
			

        $id = isset($chapterItem->item_id) ? $chapterItem->item_id : 0;

        $quiz = Quiz::find($id);

        $QuestionsAttemptController = new QuestionsAttemptController();
        //$started_already = $QuestionsAttemptController->started_already($id);

        $started_already = false;
        //pre($started_already);
        if ($started_already == true) {
            $data = [
                'pageTitle'  => 'Start',
                'quiz'       => $quiz,
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
                'resultData' => $resultData,
                'learning_journey' => 'yes',
                'journey_item_id' => $journey_item_id,
            ];
            return view('web.default.quizzes.start', $data);
        }
    }


}
