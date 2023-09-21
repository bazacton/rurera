<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\WeeklyPlanner;
use App\Models\WeeklyPlannerItems;
use App\Models\WeeklyPlannerTopics;
use App\Models\Webinar;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class WeeklyPlannerController extends Controller
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
            'pageTitle'          => 'Weekly Planner',
            'categories'         => $categories,
            'weeklyPlanners' => $weeklyPlanner,
        ];

        //pre(DB::getQueryLog());
        //DB::disableQueryLog();


        return view('admin.weekly_planner.lists', $data);

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
            'pageTitle'  => 'Weekly Planner',
            'categories' => $categories,
        ];

        return view('admin.weekly_planner.create', $data);
    }

    public function edit(Request $request, $id)
    {
        //$this->authorize('admin_glossary_edit');
        $user = auth()->user();

        $weeklyPlanner = WeeklyPlanner::where('id', $id)
            ->with('WeeklyPlannerItems.WeeklyPlannerTopics.WeeklyPlannerTopicData')
            ->first();


        $categories = Category::where('parent_id', null)
            ->with('subCategories')
            ->get();
        $data = [
            'pageTitle'     => 'Edit Weekly Planner',
            'categories'    => $categories,
            'weeklyPlanner' => $weeklyPlanner,
        ];

        return view('admin.weekly_planner.create', $data);
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

        $weekly_planner_title_array = $request->get('weekly_planner_title');
        $weekly_planner_chapter_topics_array = $request->get('weekly_planner_chapter_topics');

        //$id = 1;
        if ($id != '' && $id > 0) {
            $weeklyPlanner = WeeklyPlanner::findOrFail($id);
            $weeklyPlanner->update([
                'key_stage'  => $category_id,
                'subject_id' => $subject_id,
            ]);
        } else {
            $weeklyPlanner = WeeklyPlanner::create([
                'user_id'         => $user->id,
                'key_stage'       => $category_id,
                'subject_id'      => $subject_id,
                'curriculum_type' => 'national',
                'status'          => 'active',
                'created_at'      => time(),
            ]);
        }

        $national_curriculum_data = array();
        $saved_items_ids = $saved_chapters_ids = $saved_topics_ids = array();

        if (!empty($weekly_planner_title_array)) {
            $item_sort_key = 0;
            foreach ($weekly_planner_title_array as $title_key => $weekly_planner_title) {
                $week_no = isset($weekly_planner_chapter_topics_array[$title_key]['week_no']) ? $weekly_planner_chapter_topics_array[$title_key]['week_no'] : 0;
                $topics_array = isset($weekly_planner_chapter_topics_array[$title_key]['topics']) ? $weekly_planner_chapter_topics_array[$title_key]['topics'] : array();

                $weeklyPlannerItem = WeeklyPlannerItems::find($title_key);
                if (isset($weeklyPlannerItem->id)) {
                    $weeklyPlannerItem->update([
                        'title'      => $weekly_planner_title,
                        'sort_order' => $item_sort_key,
                        'week_no'    => $week_no,
                    ]);

                } else {
                    $weeklyPlannerItem = WeeklyPlannerItems::create([
                        'weekly_planner_id' => $weeklyPlanner->id,
                        'week_no'           => $week_no,
                        'title'             => $weekly_planner_title,
                        'status'            => 'active',
                        'sort_order'        => $item_sort_key,
                        'created_at'        => time(),
                    ]);
                }
                $saved_items_ids[] = $weeklyPlannerItem->id;

                if (!empty($topics_array)) {
                    foreach ($topics_array as $sort_key => $topic_id) {

                        $weeklyPlannerTopic = WeeklyPlannerTopics::where('weekly_planner_item_id', $weeklyPlannerItem->id)
                            ->where('topic_id', $topic_id)
                            ->first();


                        if (isset($weeklyPlannerTopic->id)) {
                            $weeklyPlannerTopic->update([
                                'sort_order' => $sort_key,
                            ]);

                        } else {
                            $weeklyPlannerTopic = WeeklyPlannerTopics::create([
                                'weekly_planner_id'      => $weeklyPlanner->id,
                                'weekly_planner_item_id' => $weeklyPlannerItem->id,
                                'topic_id'               => $topic_id,
                                'status'                 => 'active',
                                'sort_order'             => $sort_key,
                                'created_at'             => time(),
                            ]);
                        }
                        $saved_topics_ids[] = $weeklyPlannerTopic->id;
                    }
                }
                $item_sort_key++;
            }
        }
        if ($id != '' && $id > 0) {
            WeeklyPlannerItems::where('weekly_planner_id', $id)->whereNotIn('id', $saved_items_ids)->delete();
            WeeklyPlannerTopics::where('weekly_planner_id', $id)->whereNotIn('id', $saved_topics_ids)->delete();
        }

        return redirect()->route('adminEditWeeklyPlanner', ['id' => $weeklyPlanner->id]);
    }


    public function weekly_planner_set_layout(Request $request, $data_id = 0)
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
                                            name="weekly_planner_title[<?php echo $data_id; ?>]" type="text" size="50"
                                            value="Title"
                                            class="no-border"></span>
                            </div>
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

                                    <div class="form-group mt-15 ">
                                        <label class="input-label d-block">Week</label>
                                        <select name="weekly_planner_chapter_topics[<?php echo $data_id; ?>][week_no]"
                                                id="week_no<?php echo $data_id; ?>" class="form-control"
                                                data-placeholder="Select Week">
                                            <?php
                                            $week_count = 1;
                                            while ($week_count <= $total_weeks) {
                                                echo '<option value="' . $week_count . '">' . $week_count . '</option>';
                                                $week_count++;
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group mt-15 ">
                                        <label class="input-label d-block">Topics</label>

                                        <select name="weekly_planner_chapter_topics[<?php echo $data_id; ?>][topics][]"
                                                id="topic_ids<?php echo $data_id; ?>" multiple="multiple"
                                                data-search-option="topic_ids"
                                                class="form-control search-topics-select2"
                                                data-placeholder="Search Topic"></select>
                                    </div>

                                    <?php //echo $this->curriculum_item_layout($request, $data_id);
                                    ?>


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

    public function destroy(Request $request, $id)
    {

        //$this->authorize('admin_glossary_delete');

        NationalCurriculum::find($id)->delete();

        removeContentLocale();

        return redirect('/admin/national_curriculum');
    }

}
