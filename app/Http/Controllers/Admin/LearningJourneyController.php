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
use App\Models\LearningJourneyObjects;


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

        $LearningJourneys = LearningJourneys::where('status', 'active');

        $LearningJourneys = $this->filters($LearningJourneys, $request);

        $LearningJourneys = $LearningJourneys->paginate(50);
        $data = [
            'pageTitle'          => 'Learning Journey',
            'categories'         => $categories,
            'LearningJourneys' => $LearningJourneys,
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
			$treasure_box = array(100, 150, 200, 250, 300, 350, 400, 450);

			$sub_chapters_ids = $LearningJourneyObj->subject->webinar_sub_chapters->pluck('id')->toArray();

			$totalElements = count($sub_chapters_ids);
			$levels = array();
			$levels[0] = $sub_chapters_ids;

			$insertIndex = 0;
			while ($insertIndex < count($levels[0])) {
				$insertAfter = rand(3, 5); // Choose a random number between 3 and 5
				$insertIndex += $insertAfter;
				if ($insertIndex < count($levels[0])) {
					$treasureIndex = array_rand($treasure_box); // Choose a random index from treasure_box
					array_splice($levels[0], $insertIndex, 0, array(array($treasure_box[$treasureIndex]))); // Insert the treasure value at the chosen index as an array
					$insertIndex++; // Move to the next position after the inserted treasure
				}
			}

			if (!empty($levels)) {
				$level_count = 0;
				foreach ($levels as $levelData) {
					$level_count++;
					$LearningJourneyLevels = LearningJourneyLevels::create([
						'learning_journey_id' => $id,
						'level_title' => 'Level 1',
						'status' => 'active',
						'sort_order' => 1,
						'created_by' => $user->id,
						'created_at' => time(),
					]);

					if (!empty($levelData)) {
						$sort_order_item = 0;
						foreach ($levelData as $level_item) {
							$sort_order_item++;
							$item_type = 'topic';
							if (is_array($level_item)) {
								$item_type = 'treasure';
								$level_item = isset($level_item[0]) ? $level_item[0] : 0;
							}
							$LearningJourneyItems = LearningJourneyItems::create([
								'learning_journey_id' => $id,
								'learning_journey_level_id' => $LearningJourneyLevels->id,
								'item_type' => $item_type,
								'item_value' => $level_item,
								'status' => 'active',
								'sort_order' => $sort_order_item,
								'created_by' => $user->id,
								'created_at' => time(),
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
        $year_id = $request->get('key_stage', null);
        $subject_id = $request->get('subject_id', null);


        if (!empty($year_id) && $year_id > 0) {
            $query->where('year_id', $year_id);
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
		$posted_data = $request->get('posted_data');
		$posted_data = json_decode($posted_data);
		$level_data_values = $posted_data->levels;
		$level_data_values = (array) $level_data_values;
		unset( $posted_data->levels);
		$levels_objects = array();
		if( !empty( $posted_data ) ){
			foreach( $posted_data as $postedObj){
				$level_id = isset( $postedObj->level_id)? $postedObj->level_id : 0;
				$levels_objects[$level_id][] = $postedObj;
			}
		};
		

        //$id = 1;
        if ($id != '' && $id > 0) {
            $LearningJourney = LearningJourneys::findOrFail($id);
			
			if( !empty( $learning_journey_level ) ){
				foreach( $learning_journey_level as $level_key => $levelData){
					$sort_order_level++;
					$LearningJourneyLevels = LearningJourneyLevels::findOrFail($level_key);
					if( !isset( $LearningJourneyLevels->id)){
						$LearningJourneyLevels = LearningJourneyLevels::create([
							'learning_journey_id'	=> $LearningJourney->id,
							'status'			=> 'active',
							'sort_order' 		=> $sort_order_level,
							'created_by'		=> $user->id,
							'created_at'		=> time(),
							'data_values'		=> isset( $level_data_values[$level_key] )? json_encode($level_data_values[$level_key]) : '',
						]);
					}else{
						$LearningJourneyLevels->update([
							'data_values'		=> isset( $level_data_values[$level_key] )? json_encode($level_data_values[$level_key]) : '',
						]);
					}
					$objectData = isset( $levels_objects[$level_key] )? $levels_objects[$level_key] : array();
					$objects_array = [];
					if( !empty( $objectData )){
						foreach( $objectData as $objectData){
							$is_new = $objectData->is_new;
							if( $is_new == 'yes'){
								$LearningJourneyObjects = LearningJourneyObjects::create([
									'learning_journey_id'	=> $LearningJourney->id,
									'learning_journey_level_id'	=> $LearningJourneyLevels->id,
									'item_type' 		=> $objectData->field_type,
									'item_slug' 		=> $objectData->item_type,
									'item_title' 		=> isset( $objectData->item_title )? $objectData->item_title : '',
									'item_path' 		=> $objectData->item_path,
									'field_style' 		=> $objectData->field_style,
									'data_values' 		=> isset( $objectData->data_values )? json_encode($objectData->data_values) : '',
									'status'			=> 'active',
									'sort_order' 		=> $sort_order_item,
									'created_by'		=> $user->id,
									'created_at'		=> time(),
								]);
								
								$objects_array[] = $LearningJourneyObjects->id;
							}else{
								$objects_array[] = $objectData->unique_id;
								$LearningJourneyObjects = LearningJourneyObjects::find($objectData->unique_id)->update([
									'learning_journey_id'	=> $LearningJourney->id,
									'learning_journey_level_id'	=> $LearningJourneyLevels->id,
									'item_type' 		=> $objectData->field_type,
									'item_slug' 		=> $objectData->item_type,
									'item_title' 		=> isset( $objectData->item_title )? $objectData->item_title : '',
									'item_path' 		=> $objectData->item_path,
									'field_style' 		=> $objectData->field_style,
									'data_values' 		=> isset( $objectData->data_values )? json_encode($objectData->data_values) : '',
									'status'			=> 'active',
									'sort_order' 		=> $sort_order_item,
									'created_by'		=> $user->id,
									'created_at'		=> time(),
								]);
							}
						}
					}
					LearningJourneyObjects::where('learning_journey_id', $LearningJourney->id)->where('learning_journey_level_id', $LearningJourneyLevels->id)->whereNotIn('id', $objects_array)->update(['status' => 'archived']);
				}
			}
			
            
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
					'data_values'		=> isset( $level_data_values[$level_key] )? json_encode($level_data_values[$level_key]) : '',
				]);
				
				$objectData = isset( $levels_objects[$level_key] )? $levels_objects[$level_key] : array();
				if( !empty( $objectData )){
					foreach( $objectData as $objectData){
						$LearningJourneyObjects = LearningJourneyObjects::create([
							'learning_journey_id'	=> $LearningJourney->id,
							'learning_journey_level_id'	=> $LearningJourneyLevels->id,
							'item_type' 		=> $objectData->field_type,
							'item_slug' 		=> $objectData->item_type,
							'item_title' 		=> isset( $objectData->item_title )? $objectData->item_title : '',
							'item_path' 		=> $objectData->item_path,
							'field_style' 		=> $objectData->field_style,
							'data_values' 		=> isset( $objectData->data_values )? json_encode($objectData->data_values) : '',
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
            //WeeklyPlannerItems::where('weekly_planner_id', $id)->whereNotIn('id', $saved_items_ids)->delete();
            //WeeklyPlannerTopics::where('weekly_planner_id', $id)->whereNotIn('id', $saved_topics_ids)->delete();
        }

        return redirect()->route('adminEditLearningJourney', ['id' => $LearningJourney->id]);
    }


    public function learning_journey_set_layout(Request $request, $data_id = 0, $is_exit = true, $is_saved = false, $itemObj = array())
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
								 
								 
								 
								 
								 <div class="editor-zone" style="position:relative;width: fit-content;">
									<div class="field-options"></div>
									<?php $data_values = isset( $itemObj->data_values )? json_decode($itemObj->data_values) : array();?>
									<div class="book-dropzone active page_settings saved-item-class" data-trigger_class="page-settings-fields" data-page_graph="<?php echo isset( $data_values->page_graph )? $data_values->page_graph : '0'; ?>" data-page_background="<?php echo isset( $data_values->background )? $data_values->background : '#ffffff'; ?>" data-page_height="<?php echo isset( $data_values->height )? str_replace('px', '', $data_values->height) : '800'; ?>" style="background:#ffffff" data-level_id="<?php echo $data_id; ?>">
										<?php
										
											if( $is_saved == true){
												if( !empty( $itemObj->LearningJourneyObjects->where('status', 'active') )){
													foreach( $itemObj->LearningJourneyObjects->where('status', 'active') as $learningJourneyItemObj){
														$item_type = isset( $learningJourneyItemObj->item_type ) ?  $learningJourneyItemObj->item_type : '';
														$item_path_folder = '';
														$item_path_folder = ($item_type == 'stage' )? 'stages' : $item_path_folder;
														$item_path_folder = ($item_type == 'stage_objects' )? 'objects' : $item_path_folder;
														$item_path_folder = ($item_type == 'path' )? 'paths' : $item_path_folder;
														
														$data_attributes_array = isset( $learningJourneyItemObj->data_values )? json_decode($learningJourneyItemObj->data_values ) : array();
														
														$data_attributes = '';
														
														if( !empty( $data_attributes_array ) ){
															foreach( $data_attributes_array as $data_attribute_key => $data_attribute_value){
																$data_attributes .= 'data-'.$data_attribute_key.'="'.$data_attribute_value.'" ';
															}
														}

														
														
														$item_path = isset( $learningJourneyItemObj->item_path ) ?  $learningJourneyItemObj->item_path : '';
														$item_path = 'assets/editor/'.$item_path_folder.'/'.$item_path;
														$svgCode = getFileContent($item_path);
														echo '<div style="'.$learningJourneyItemObj->field_style.'" data-is_new="no" data-item_title="'.$learningJourneyItemObj->item_title.'" data-unique_id="'.$learningJourneyItemObj->id.'" class="saved-item-class drop-item form-group draggablecl field_settings draggable_field_rand_'.$learningJourneyItemObj->id.'" data-id="rand_'.$learningJourneyItemObj->id.'" data-item_path="'.$learningJourneyItemObj->item_path.'" data-field_type="'.$learningJourneyItemObj->item_type.'" data-trigger_class="infobox-'.$learningJourneyItemObj->item_slug.'-fields" data-item_type="'.$learningJourneyItemObj->item_slug.'" data-paragraph_value="Test text here..." '.$data_attributes.'><div class="field-data">'.$svgCode.'</div><a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a></div>';
														
													}
												}
												
											}
										?>
										
									</div>
									
									
									
									<?php echo view('admin.learning_journey.includes.editor_controls', ['data_id' => $data_id, 'itemObj' => $itemObj])->render() ?>
									
									
								 </div>
								 
								 
								 
								 
								 
								 
								 
								 
								 
								 
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
		if( $is_exit == true){
			exit;
		}
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
