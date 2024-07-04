<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\WeeklyPlanner;
use App\Models\WeeklyPlannerItems;
use App\Models\WeeklyPlannerTopics;

use App\Models\LearningJourneys;
use App\Models\LearningJourneyLevels;
use App\Models\LearningJourneyItems;

use App\Models\Webinar;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class LearningJourneyController extends Controller
{

    public function index(Request $request)
    {
        $user = auth()->user();

        $categories = Category::where('parent_id', null)
            ->with('subCategories')
            ->get();

        $weeklyPlanner = WeeklyPlanner::with('WeeklyPlannerKeyStage', 'WeeklyPlannerKeySubject');

        $weeklyPlanner = $this->filters($weeklyPlanner, $request);

        $weeklyPlanner = $weeklyPlanner->paginate(50);
        $data = [
            'pageTitle'          => 'Learning Journey',
            'categories'         => $categories,
            'weeklyPlanners' => $weeklyPlanner,
        ];

        //pre(DB::getQueryLog());
        //DB::disableQueryLog();


        return view('admin.learning_journey.lists', $data);

    }

    /*
     * Create Glossary
     */

    public function create()
    {
        //$this->authorize('admin_glossary_create');
        $categories = Category::where('parent_id', null)
            ->with('subCategories')
            ->get();
        $data = [
            'pageTitle'  => 'Learning Journey',
            'categories' => $categories,
        ];

        return view('admin.learning_journey.create', $data);
    }

    public function edit(Request $request, $id)
    {
        //$this->authorize('admin_glossary_edit');
        $user = auth()->user();

		
        $LearningJourneyObj = LearningJourneys::where('id', $id)->first();
		
		
		
		
		if( isset( $_GET['import'])){
		
		
			$total_sub_chapters = $LearningJourneyObj->subject->webinar_sub_chapters->count();
			
			$treasure_box = array(100,150,200,250,300,350,400,450);
			
			
			$sub_chapters_ids = $LearningJourneyObj->subject->webinar_sub_chapters->pluck('id')->toArray();
			
			$totalElements = count($sub_chapters_ids);
			$partitionSize = intdiv($totalElements, 3);
			$remainder = $totalElements % 3;

			$levels = array();

			$levels[0] = array_slice($sub_chapters_ids, 0, $partitionSize);
			$levels[1] = array_slice($sub_chapters_ids, $partitionSize, $partitionSize);
			$levels[2] = array_slice($sub_chapters_ids, 2 * $partitionSize);

			if ($remainder > 0) {
				$extra = array_splice($levels[2], $partitionSize);
				$levels[2] = array_merge($levels[2], $extra);
			}
			
			foreach ($levels as &$level) {
				$numTreasures = rand(1, 3); // Decide how many treasures to insert
				$insertedIndexes = [];

				for ($i = 0; $i < $numTreasures; $i++) {
					do {
						$insertIndex = rand(2, count($level) - 1); // Choose a random index from 2 to the end of the array
					} while (in_array($insertIndex, $insertedIndexes)); // Ensure no duplicate insert positions

					$treasureIndex = array_rand($treasure_box); // Choose a random index from treasure_box
					array_splice($level, $insertIndex, 0, array(array($treasure_box[$treasureIndex]))); // Insert the treasure value at the chosen index as an array
					$insertedIndexes[] = $insertIndex;
				}
			}		
			
			if( !empty( $levels )){
				$level_count = 0;
				foreach( $levels as $levelData){
					
					$level_count++;
					$LearningJourneyLevels = LearningJourneyLevels::create([
						'learning_journey_id' => $id,
						'level_title' => 'Level '.$level_count,
						'status' => 'active',
						'sort_order' => $level_count,
						'created_by' => $user->id,
						'created_at' => time(),
					]);
					
					if( !empty( $levelData ) ){
						$sort_order_item = 0;
						foreach( $levelData as $level_item){
							$sort_order_item++;
							$item_type = 'topic';
							if( is_array( $level_item )){
								$item_type = 'treasure';
								$level_item = isset( $level_item[0] )? $level_item[0] : 0;

							}
							$LearningJourneyItems = LearningJourneyItems::create([
								'learning_journey_id'	=> $id,
								'learning_journey_level_id'	=> $LearningJourneyLevels->id,
								'item_type' 		=> $item_type,
								'item_value' 		=> $level_item,
								'status'			=> 'active',
								'sort_order' 		=> $sort_order_item,
								'created_by'		=> $user->id,
								'created_at'		=> time(),
							]);
						}
					}
					
				}
			}
			pre('Done');
		}
		
		
		
		
		
		
		


        $categories = Category::where('parent_id', null)
            ->with('subCategories')
            ->get();
        $data = [
            'pageTitle'     => 'Edit Learning Journey',
            'categories'    => $categories,
            'thisObj'    => $this,
            'request'    => $request,
            'LearningJourneyObj' => $LearningJourneyObj,
        ];

        return view('admin.learning_journey.create', $data);
    }

    private function filters($query, $request)
    {
        $key_stage = $request->get('key_stage', null);
        $subject_id = $request->get('subject_id', null);


        if (!empty($key_stage) && $key_stage > 0) {
            $query->where('key_stage', $key_stage);
        }

        if (!empty($subject_id) && $subject_id > 0) {
            $query->where('subject_id', $subject_id);
        }


        return $query;
    }

    public function store(Request $request, $id = '')
    {
        $user = auth()->user();


        $data = $request->all();
        $locale = $request->get('locale', getDefaultLocale());
        $category_id = $request->get('category_id');
        $subject_id = $request->get('subject_id');

		$learning_journey_level = $request->get('learning_journey_level');
		$learning_journey_topic = $request->get('learning_journey_topic');
		$sort_order_level = 0;
		$sort_order_item = 0;
		
		$learning_journey_level = $request->get('learning_journey_level');

        //$id = 1;
        if ($id != '' && $id > 0) {
            $LearningJourneyObj = LearningJourneys::findOrFail($id);
			pre($learning_journey_topic);
			
            
        } else {
			
			
			
			
			$LearningJourney = LearningJourneys::create([
                'year_id'         => $category_id,
                'subject_id'      => $subject_id,
                'status'          => 'active',
                'created_by'      => $user->id,
                'created_at'      => time(),
            ]);
			
			if( !empty( $learning_journey_level ) ){
			foreach( $learning_journey_level as $level_key => $levelData){
				$sort_order_level++;
				$LearningJourneyLevels = LearningJourneyLevels::create([
					'learning_journey_id'	=> $LearningJourney->id,
					'status'			=> 'active',
					'sort_order' 		=> $sort_order_level,
					'created_by'		=> $user->id,
					'created_at'		=> time(),
				]);
				$level_topics = isset( $learning_journey_topic[$level_key] )? $learning_journey_topic[$level_key] : array();
				$level_topics = isset( $level_topics['items'] )? $level_topics['items'] : array();
				if( !empty( $level_topics )){
					foreach( $level_topics as $item_value){
						$sort_order_item++;
						$item_type = 'topic';
						if( is_array( $item_value )){
							$item_type = 'treasure';
							$item_value = isset( $item_value['treasure'] )? $item_value['treasure'] : 0;
						}
						$LearningJourneyItems = LearningJourneyItems::create([
							'learning_journey_id'	=> $LearningJourney->id,
							'learning_journey_level_id'	=> $LearningJourneyLevels->id,
							'item_type' 		=> $item_type,
							'item_value' 		=> $item_value,
							'status'			=> 'active',
							'sort_order' 		=> $sort_order_item,
							'created_by'		=> $user->id,
							'created_at'		=> time(),
						]);
					}
				}
			}
		}
			
        }
        if ($id != '' && $id > 0) {
            WeeklyPlannerItems::where('weekly_planner_id', $id)->whereNotIn('id', $saved_items_ids)->delete();
            WeeklyPlannerTopics::where('weekly_planner_id', $id)->whereNotIn('id', $saved_topics_ids)->delete();
        }

        return redirect()->route('adminEditLearningJourney', ['id' => $LearningJourney->id]);
    }


    public function learning_journey_set_layout(Request $request, $data_id = 0)
    {
        if ($data_id == 0) {
            $data_id = rand(0, 99999);
        }
        $item_id = rand(0, 99999);
        $chapter_id = rand(0, 99999);
        $total_weeks = 32;
        ?>
        <div class="accordion-content-wrapper mt-15" id="chapterAccordion" role="tablist"
             aria-multiselectable="true">
            <ul class="draggable-content-lists  curriculum-set-ul">

                <li data-id="<?php echo $data_id; ?>" data-chapter-order=""
                    class="accordion-row bg-white rounded-sm mt-20 py-15 py-lg-30 px-10 px-lg-20">
                    <div class="d-flex align-items-center justify-content-between " role="tab"
                         id="chapter_<?php echo $data_id; ?>">
                        <div class="d-flex align-items-center collapsed"
                             href="#collapseItems<?php echo $data_id; ?>"
                             aria-controls="collapseItems<?php echo $data_id; ?>"
                             data-parent="#chapterAccordion" role="button"
                             data-toggle="collapse" aria-expanded="false">
                                <span class="chapter-icon mr-10">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         width="24" height="24"
                                         viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor"
                                         stroke-width="2"
                                         stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="feather feather-grid"><rect
                                                x="3"
                                                y="3"
                                                width="7"
                                                height="7"></rect><rect
                                                x="14" y="3" width="7"
                                                height="7"></rect><rect
                                                x="14"
                                                y="14"
                                                width="7"
                                                height="7"></rect><rect
                                                x="3" y="14" width="7"
                                                height="7"></rect></svg>
                                </span>
                            <div class="">
                                <span class="font-weight-bold text-dark-blue d-block cursor-pointer"><input
                                            name="learning_journey_level[<?php echo $data_id; ?>]" type="text" size="50"
                                            value="Title"
                                            class="no-border"></span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">

                            <button type="button" data-data_id="<?php echo $data_id; ?>"
                                    class="add-course-content-btn  add-curriculum-item mr-10"
                                    aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-plus">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
							
                            <button type="button" data-data_id="<?php echo $data_id; ?>"
                                    class="add-course-content-btn  add-treasure-item mr-10"
                                    aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-plus">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg> Box
                            </button>

                            <a href="javascript:;"
                               class="delete-parent-li btn btn-sm btn-transparent text-gray">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round"
                                     class="feather feather-trash-2 mr-10 cursor-pointer">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </a>

                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-move move-icon mr-10 cursor-pointer text-gray ui-sortable-handle">
                                <polyline points="5 9 2 12 5 15"></polyline>
                                <polyline points="9 5 12 2 15 5"></polyline>
                                <polyline points="15 19 12 22 9 19"></polyline>
                                <polyline points="19 9 22 12 19 15"></polyline>
                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                <line x1="12" y1="2" x2="12" y2="22"></line>
                            </svg>

                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-chevron-down collapse-chevron-icon feather-chevron-up text-gray collapsed"
                                 href="#collapseItems<?php echo $data_id; ?>"
                                 aria-controls="collapseItems<?php echo $data_id; ?>"
                                 data-parent="#chapterAccordion" role="button"
                                 data-toggle="collapse" aria-expanded="false">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </div>
                    </div>
					
					<div id="collapseItems<?php echo $data_id; ?>" aria-labelledby="chapter_<?php echo $data_id; ?>"
                         class="curriculum-item-data collapse " role="tabpanel">
                        <div class="panel-collapse text-gray">

                            <div class="accordion-content-wrapper mt-15"
                                 id="chapterContentAccordion<?php echo $data_id; ?>" role="tablist"
                                 aria-multiselectable="true">
                                <ul class="curriculum-item-data-ul draggable-content-lists draggable-lists-chapter-<?php echo $data_id; ?> ui-sortable"
                                    data-drag-class="draggable-lists-chapter-<?php echo $data_id; ?>"
                                    data-order-table="webinar_chapter_items">

                                    


                                </ul>
                            </div>

                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <?php
        exit;
    }
	
	public function learning_journey_topic_layout(Request $request, $data_id = 0, $subject_id = 0, $item_value = '')
    {
        if ($data_id == 0) {
            $data_id = $request->get('data_id', null);
        }
		if ($subject_id == 0) {
            $subject_id = $request->get('subject_id', null);
        }
		$course = Webinar::find($subject_id);

        $item_id = rand(0, 99999);
        $chapter_id = rand(0, 99999);

        ?>
        <li data-id="<?php echo $item_id; ?>"
            class="accordion-row bg-white rounded-sm border border-gray300 mt-20 py-15 py-lg-30 px-10 px-lg-20">
            <div class="d-flex align-items-center justify-content-between "
                 role="tab" id="quiz_<?php echo $item_id; ?>">
                <div class="d-flex align-items-center"
                     href="#collapseItem<?php echo $item_id; ?>"
                     aria-controls="collapseItem<?php echo $item_id; ?>"
                     data-parent="#chapterContentAccordion<?php echo $data_id; ?>"
                     role="button" data-toggle="collapse"
                     aria-expanded="true">

                    <span class="font-weight-bold text-dark-blue d-block cursor-pointer">
					<select class="no-border" name="learning_journey_topic[<?php echo $data_id; ?>][items][<?php echo $item_id; ?>]">
						<option value="">Select Topic</option>
						<?php if( $course->webinar_sub_chapters->count() > 0){
							foreach( $course->webinar_sub_chapters as $subChapter){
								$selected  = ( $item_value == $subChapter->id)? 'selected'  : '';
								echo '<option value="'.$subChapter->id.'" '.$selected.'>'.$subChapter->sub_chapter_title.'</option>';
							}
						}
						?>
					</select>
					</span>
                </div>

                <div class="d-flex align-items-center">

                    
                    <a href="javascript:;"
                       class="delete-parent-li btn btn-sm btn-transparent text-gray">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round"
                             class="feather feather-trash-2 mr-10 cursor-pointer">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </a>

                    <svg xmlns="http://www.w3.org/2000/svg"
                         width="24" height="20" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round"
                         class="feather feather-move move-icon mr-10 cursor-pointer ui-sortable-handle">
                        <polyline points="5 9 2 12 5 15"></polyline>
                        <polyline points="9 5 12 2 15 5"></polyline>
                        <polyline
                                points="15 19 12 22 9 19"></polyline>
                        <polyline
                                points="19 9 22 12 19 15"></polyline>
                        <line x1="2" y1="12" x2="22" y2="12"></line>
                        <line x1="12" y1="2" x2="12" y2="22"></line>
                    </svg>
                </div>
            </div>
        </li>
        <?php
    }
	
	public function learning_journey_treasure_layout(Request $request, $data_id = 0, $item_value = '')
    {
        if ($data_id == 0) {
            $data_id = $request->get('data_id', null);
        }

        $item_id = rand(0, 99999);
        $chapter_id = rand(0, 99999);

        ?>
        <li data-id="<?php echo $item_id; ?>"
            class="accordion-row bg-white rounded-sm border border-gray300 mt-20 py-15 py-lg-30 px-10 px-lg-20">
            <div class="d-flex align-items-center justify-content-between "
                 role="tab" id="quiz_<?php echo $item_id; ?>">
                <div class="d-flex align-items-center"
                     href="#collapseItem<?php echo $item_id; ?>"
                     aria-controls="collapseItem<?php echo $item_id; ?>"
                     data-parent="#chapterContentAccordion<?php echo $data_id; ?>"
                     role="button" data-toggle="collapse"
                     aria-expanded="true">

                    <span class="font-weight-bold text-dark-blue d-block cursor-pointer">
					<input type="number" name="learning_journey_topic[<?php echo $data_id; ?>][items][<?php echo $item_id; ?>][treasure]" value="<?php echo $item_value; ?>" placeholder="Treasure Coins" class="no-border">
					</span>
                </div>

                <div class="d-flex align-items-center">

                    
                    <a href="javascript:;"
                       class="delete-parent-li btn btn-sm btn-transparent text-gray">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round"
                             class="feather feather-trash-2 mr-10 cursor-pointer">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </a>

                    <svg xmlns="http://www.w3.org/2000/svg"
                         width="24" height="20" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round"
                         class="feather feather-move move-icon mr-10 cursor-pointer ui-sortable-handle">
                        <polyline points="5 9 2 12 5 15"></polyline>
                        <polyline points="9 5 12 2 15 5"></polyline>
                        <polyline
                                points="15 19 12 22 9 19"></polyline>
                        <polyline
                                points="19 9 22 12 19 15"></polyline>
                        <line x1="2" y1="12" x2="22" y2="12"></line>
                        <line x1="12" y1="2" x2="12" y2="22"></line>
                    </svg>
                </div>
            </div>
        </li>
        <?php
    }
	

    public function destroy(Request $request, $id)
    {

        //$this->authorize('admin_glossary_delete');

        NationalCurriculum::find($id)->delete();

        removeContentLocale();

        return redirect('/admin/learning_journey');
    }

}
