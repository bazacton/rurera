<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\NationalCurriculum;
use App\Models\NationalCurriculumItems;
use App\Models\NationalCurriculumChapters;
use App\Models\NationalCurriculumTopics;
use App\Models\Webinar;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class NationalCurriculumController extends Controller
{

    public function index(Request $request)
    {
        $user = auth()->user();

        $categories = Category::where('parent_id', null)
                        ->with('subCategories')
                        ->get();

        $nationalCurriculum = NationalCurriculum::with('NationalCurriculumKeyStage', 'NationalCurriculumKeySubject');

        $nationalCurriculum = $this->filters($nationalCurriculum, $request);

        $nationalCurriculum = $nationalCurriculum->paginate(50);
        $data = [
            'pageTitle' => 'National Curriculum',
            'categories' => $categories,
            'nationalCurriculum' => $nationalCurriculum,
        ];

        //pre(DB::getQueryLog());
        //DB::disableQueryLog();



        return view('admin.national_curriculum.lists', $data);

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
            'pageTitle'  => 'National Curriculum',
            'categories' => $categories,
        ];

        return view('admin.national_curriculum.create', $data);
    }

    public function edit(Request $request, $id)
    {
        //$this->authorize('admin_glossary_edit');
        $user = auth()->user();

        $nationalCurriculum = NationalCurriculum::where('id', $id)
                   ->with('NationalCurriculumItems.NationalCurriculumChapters.NationalCurriculumTopics.NationalCurriculumTopicData')
                   ->first();


        $categories = Category::where('parent_id', null)
            ->with('subCategories')
            ->get();
        $data = [
            'pageTitle'  => 'Edit National Curriculum',
            'categories' => $categories,
            'nationalCurriculum'   => $nationalCurriculum,
        ];

        return view('admin.national_curriculum.create', $data);
    }

    private function filters($query, $request)
    {
        $key_stage = $request->get('key_stage', null);
        $subject_id = $request->get('subject_id', null);


        if (!empty($key_stage) && $key_stage > 0) {
            $query->where('key_stage',$key_stage);
        }

        if (!empty($subject_id) && $subject_id > 0) {
            $query->where('subject_id',$subject_id);
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

        $national_curriculum_title_array = $request->get('national_curriculum_title');
        $national_curriculum_item_title_array = $request->get('national_curriculum_item_title');
        $national_curriculum_chapter_title_array = $request->get('national_curriculum_chapter_title');
        $national_curriculum_chapter_topics_array = $request->get('national_curriculum_chapter_topics');

        //$id = 1;
        if ($id != '' && $id > 0) {
            $nationalCurriculum = NationalCurriculum::findOrFail($id);
            $nationalCurriculum->update([
                'key_stage' => $category_id,
                'subject_id' => $subject_id,
            ]);
        } else {
            $nationalCurriculum = NationalCurriculum::create([
                'user_id' => $user->id,
                'key_stage' => $category_id,
                'subject_id' => $subject_id,
                'curriculum_type' => 'national',
                'status'      => 'active',
                'created_at'  => time(),
            ]);
        }

        $national_curriculum_data = array();
        $saved_items_ids = $saved_chapters_ids = $saved_topics_ids = array();

        if( !empty( $national_curriculum_title_array )){
            foreach( $national_curriculum_title_array as $title_key => $national_curriculum_title){
                $items_array = isset( $national_curriculum_item_title_array[$title_key]['items'] )? $national_curriculum_item_title_array[$title_key]['items'] : array();
                if( !empty( $items_array )){
                    $item_sort_key = 0;
                    foreach( $items_array as $item_key => $item_name){
                        $chapters_array = isset( $national_curriculum_chapter_title_array[$title_key][$item_key]['chapters'] )? $national_curriculum_chapter_title_array[$title_key][$item_key]['chapters'] : array();

                        $nationalCurriculumItem = NationalCurriculumItems::find($item_key);
                        if( isset( $nationalCurriculumItem->id )){
                            $nationalCurriculumItem->update([
                                'title'                  => $national_curriculum_title,
                                'sub_title'              => $item_name,
                                'sort_order'             => $item_sort_key,
                            ]);

                        }else {
                            $nationalCurriculumItem = NationalCurriculumItems::create([
                                'national_curriculum_id' => $nationalCurriculum->id,
                                'title'                  => $national_curriculum_title,
                                'sub_title'              => $item_name,
                                'status'                 => 'active',
                                'sort_order'             => $item_sort_key,
                                'created_at'             => time(),
                            ]);
                        }
                        $saved_items_ids[] = $nationalCurriculumItem->id;

                        if( !empty( $chapters_array ) ){
                            $chapter_sort_key = 0;
                            foreach( $chapters_array as $chapter_key => $chapter_name){
                                $topics_array = isset( $national_curriculum_chapter_topics_array[$title_key][$item_key][$chapter_key]['topics'] )? $national_curriculum_chapter_topics_array[$title_key][$item_key][$chapter_key]['topics'] : array();

                                $nationalCurriculumChapter = NationalCurriculumChapters::find($chapter_key);

                                if( isset( $nationalCurriculumChapter->id )){
                                    $nationalCurriculumChapter->update([
                                       'title' => $chapter_name,
                                       'sort_order' => $chapter_sort_key,
                                   ]);

                               }else {
                                    $nationalCurriculumChapter = NationalCurriculumChapters::create([
                                       'national_curriculum_id' => $nationalCurriculum->id,
                                       'national_curriculum_item_id' => $nationalCurriculumItem->id,
                                       'title' => $chapter_name,
                                       'status' => 'active',
                                       'sort_order' => $chapter_sort_key,
                                       'created_at' => time(),
                                   ]);
                               }
                                $saved_chapters_ids[] = $nationalCurriculumChapter->id;


                                if( !empty( $topics_array) ){
                                    foreach( $topics_array as $sort_key => $topic_id){

                                        $nationalCurriculumTopic = NationalCurriculumTopics::where('national_curriculum_chapter_id', $nationalCurriculumChapter->id)
                                            ->where('topic_id', $topic_id)
                                            ->first();


                                        if( isset( $nationalCurriculumTopic->id )){
                                                $nationalCurriculumTopic->update([
                                                   'sort_order' => $sort_key,
                                                ]);

                                           }else {
                                                $nationalCurriculumTopic = NationalCurriculumTopics::create([
                                                   'national_curriculum_id' => $nationalCurriculum->id,
                                                   'national_curriculum_item_id' => $nationalCurriculumItem->id,
                                                   'national_curriculum_chapter_id' => $nationalCurriculumChapter->id,
                                                   'topic_id' => $topic_id,
                                                   'status' => 'active',
                                                   'sort_order' => $sort_key,
                                                   'created_at' => time(),
                                               ]);
                                           }
                                           $saved_topics_ids[] = $nationalCurriculumTopic->id;
                                    }
                                }
                                $chapter_sort_key++;
                            }
                        }
                        $item_sort_key++;
                    }
                }
            }
        }
        if ($id != '' && $id > 0) {
            NationalCurriculumItems::where('national_curriculum_id', $id)->whereNotIn('id', $saved_items_ids)->delete();
            NationalCurriculumChapters::where('national_curriculum_id', $id)->whereNotIn('id', $saved_chapters_ids)->delete();
            NationalCurriculumTopics::where('national_curriculum_id', $id)->whereNotIn('id', $saved_topics_ids)->delete();
        }

        return redirect()->route('adminEditNationalCurriculum', ['id' => $nationalCurriculum->id]);
    }

    public function subjects_by_category(Request $request){
        $category_id = $request->get('category_id');
        $subject_id = $request->get('subject_id');
        $only_field = $request->get('only_field');
        $webinars = Webinar::where('category_id' , $category_id)
                    ->get();
        if( $only_field != 'yes'){
        ?>
        <div class="form-group">

                    <label>Subject</label>
        <?php } ?>
                    <select class="form-control choose-curriculum-subject"
                            name="subject_id">
                        <option value="" class="font-weight-bold">Select Subject</option>
                        <?php if( !empty( $webinars ) ){
                            foreach( $webinars as $webinarsObj){
                                $selected = ($subject_id == $webinarsObj->id)? 'selected' : '';
                                echo '<option value="'.$webinarsObj->id.'" class="font-weight-bold" '.$selected.'>'. $webinarsObj->getTitleAttribute().'</option>';
                            }
                        }
                        ?>
                    </select>
        <?php if( $only_field != 'yes'){ ?>
                </div>
            <?php
            }
        exit;
    }


    public function curriculum_set_layout(Request $request, $data_id  = 0)
    {
        if ($data_id == 0) {
            $data_id = rand(0, 99999);
        }
        $item_id = rand(0, 99999);
        $chapter_id = rand(0, 99999);
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
                                <span class="font-weight-bold text-dark-blue d-block cursor-pointer"><input name="national_curriculum_title[<?php echo $data_id; ?>]" type="text"
                                                                                                            value="Numbers"
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

                                    <?php echo $this->curriculum_item_layout($request, $data_id); ?>


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

    public function curriculum_item_layout(Request $request, $data_id = 0)
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

                    <span class="font-weight-bold text-dark-blue d-block cursor-pointer"><input name="national_curriculum_item_title[<?php echo $data_id; ?>][items][<?php echo $item_id; ?>]" type="text" size="100"
                                                                                                value="Number And Place Value"
                                                                                                class="no-border"></span>
                </div>

                <div class="d-flex align-items-center">

                    <button type="button" data-data_id="<?php echo $data_id; ?>" data-item_id="<?php echo $item_id; ?>"
                            class="add-course-content-btn  add-curriculum-chapter mr-10"
                            aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-plus">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
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


                    <svg xmlns="http://www.w3.org/2000/svg"
                         width="24" height="20" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round"
                         class="feather feather-chevron-down collapse-chevron-icon"
                         href="#collapseItem<?php echo $item_id; ?>"
                         aria-controls="collapseItem<?php echo $item_id; ?>"
                         data-parent="#chapterContentAccordion<?php echo $data_id; ?>"
                         role="button" data-toggle="collapse"
                         aria-expanded="true">
                        <polyline
                                points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
            </div>

            <div id="collapseItem<?php echo $item_id; ?>"
                 aria-labelledby="quiz_<?php echo $item_id; ?>"
                 class=" collapse curriculum-chapter-data" role="tabpanel">
                <div class="panel-collapse text-gray">

                    <div class=" accordion-content-wrapper mt-15"
                         id="chapterContentAccordion<?php echo $item_id; ?>"
                         role="tablist"
                         aria-multiselectable="true">
                        <ul class="draggable-content-lists curriculum-chapter-data-ul draggable-lists-chapter-<?php echo $item_id; ?> ui-sortable"
                            data-drag-class="draggable-lists-chapter-<?php echo $item_id; ?>"
                            data-order-table="webinar_chapter_items">

                            <?php echo $this->curriculum_item_chapter_layout($request, $data_id, $item_id); ?>


                        </ul>
                    </div>


                </div>
            </div>
        </li>
        <?php
    }

    public function curriculum_item_chapter_layout(Request $request, $data_id = 0, $item_id = 0)
    {
        if ($data_id == 0) {
            $data_id = $request->get('data_id', null);
        }
        if ($item_id == 0) {
            $item_id = $request->get('item_id', null);
        }
        $chapter_id = rand(0, 99999);

        ?>
        <li data-id="<?php echo $chapter_id; ?>"
            class="accordion-row bg-white rounded-sm border border-gray300 mt-20 py-15 py-lg-30 px-10 px-lg-20">
            <div class="d-flex align-items-center justify-content-between "
                 role="tab" id="quiz_<?php echo $chapter_id; ?>">
                <div class="d-flex align-items-center"
                     href="#collapseChapter<?php echo $chapter_id; ?>"
                     aria-controls="collapseChapter<?php echo $chapter_id; ?>"
                     data-parent="#chapterContentAccordion<?php echo $item_id; ?>"
                     role="button" data-toggle="collapse"
                     aria-expanded="true">

                    <span class="font-weight-bold text-dark-blue d-block cursor-pointer"><input name="national_curriculum_chapter_title[<?php echo $data_id; ?>][<?php echo $item_id; ?>][chapters][<?php echo $chapter_id; ?>]" type="text" size="150" value="Read, Write, order and compare numbers to at least 1 000 000 and determine the value of each digit" class="no-border"></span>
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


                    <svg xmlns="http://www.w3.org/2000/svg"
                         width="24" height="20" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round"
                         class="feather feather-chevron-down collapse-chevron-icon"
                         href="#collapseChapter<?php echo $chapter_id; ?>"
                         aria-controls="collapseChapter<?php echo $chapter_id; ?>"
                         data-parent="#chapterContentAccordion<?php echo $item_id; ?>"
                         role="button" data-toggle="collapse"
                         aria-expanded="true">
                        <polyline
                                points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
            </div>

            <div id="collapseChapter<?php echo $chapter_id; ?>"
                 aria-labelledby="quiz_<?php echo $chapter_id; ?>"
                 class="collapse show" role="tabpanel" style="">
                <div class="panel-collapse text-gray">

                    <div data-action="/admin/webinars/1174/store_quiz_selection"
                         class="js-content-form quiz-form webinar-form">
                        <section>

                            <div class="row">
                                <div class="col-12 col-md-12">

                                    <div class="form-group mt-15 ">
                                        <label class="input-label d-block">Topics</label>

                                        <select name="national_curriculum_chapter_topics[<?php echo $data_id; ?>][<?php echo $item_id; ?>][<?php echo $chapter_id; ?>][topics][]" id="topic_ids<?php echo $chapter_id; ?>" multiple="multiple" data-search-option="topic_ids"
                                                class="form-control search-topics-select2" data-placeholder="Search Topic"></select>
                                    </div>

                                </div>
                            </div>
                        </section>

                    </div>

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

        return redirect('/admin/national_curriculum');
    }

}
