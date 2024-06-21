<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\Webinar;
use App\Models\Category;
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
		$category_slug = substr(collect(Route::getCurrentRoute()->action['prefix'])->last(), 1);
        $category_slug = substr(collect(Route::getCurrentRoute()->action['prefix'])->last(), 1);
        $categoryObj = Category::where('slug', $category_slug)->first();
		
		$course = Webinar::where('slug', $subject_slug)->whereJsonContains('category_id', (string) $categoryObj->id)->first();
		$lerningJourney = $course->lerningJourney;
		$student_learning_journey = $this->student_learning_journey($user->id, $lerningJourney->learningJourneyLevels);
		$items_data = isset( $student_learning_journey['items_data'] )? $student_learning_journey['items_data'] : array();
		$new_added_stages = isset( $student_learning_journey['new_added_stages'] )? $student_learning_journey['new_added_stages'] : array();
		
		//pre($learningJourneyLevels);
		
		

        $data = [
			'pageTitle'                  => 'Learning Journey',
			'lerningJourney'			 => $lerningJourney,
			'learningJourneyLevels'		 => $lerningJourney->learningJourneyLevels,
			'student_learning_journey'	 => $student_learning_journey,
			'items_data'		 		=> $items_data,
			'new_added_stages'		 	=> $new_added_stages,
		];
		return view('web.default.learning_journey.index', $data);

        abort(404);
    }
	
	public function student_learning_journey($user_id, $learningJourneyLevels){
		$userObj = User::find($user_id);
		$studentJourneyItems = $userObj->studentJourneyItems->pluck('learning_journey_item_id')->toArray();
		
		$items_data = $new_added_stages = array();
		
		if( !empty( $learningJourneyLevels ) ){
			
			foreach( $learningJourneyLevels  as $levelObj){
				if($levelObj->learningJourneyItems->count() > 0){
					$item_counter = 0;
					foreach( $levelObj->learningJourneyItems as $itemObj){
						$item_counter++;
						$itemObj->is_completed = in_array($itemObj->id, $studentJourneyItems)? true : false;
						$items_data[$levelObj->id][$item_counter] = $itemObj;
						
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


}
