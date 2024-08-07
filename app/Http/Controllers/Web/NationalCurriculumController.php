<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\NationalCurriculum;
use App\Models\Page;
use App\Models\Webinar;
use App\Models\LearningJourneys;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class NationalCurriculumController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $nationalCurriculum = NationalCurriculum::where('id', 6)
            ->with('NationalCurriculumItems.NationalCurriculumChapters.NationalCurriculumTopics.NationalCurriculumTopicData')
            ->first();
        $page = Page::where('link', '/national-curriculum')->where('status', 'publish')->first();

        //pre($nationalCurriculum);
        $categories = Category::where('parent_id', null)
            ->with('subCategories')
            ->get();
        $data = [
            'pageTitle'       => $page->title,
            'pageDescription' => $page->seo_description,
            'pageRobot'       => $page->robot ? 'index, follow, all' : 'NOODP, nofollow, noindex',
            'nationalCurriculum' => $nationalCurriculum,
            'categories'         => $categories,
        ];
        return view('web.default.national_curriculum.index', $data);

        abort(404);
    }


    public function curriculum_by_subject(Request $request)
    {
        $category_id = $request->get('category_id', null);
        $subject_id = $request->get('subject_id', null);

        $nationalCurriculum = NationalCurriculum::where('key_stage', $category_id)->where('subject_id', $subject_id)
            ->with('NationalCurriculumItems.NationalCurriculumChapters.NationalCurriculumTopics.NationalCurriculumTopicData')
            ->first();
        $response_layout = view('web.default.national_curriculum.single_curriculum', ['nationalCurriculum' => $nationalCurriculum])->render();
        echo $response_layout;
        exit;

    }

    public function subjects_by_category(Request $request)
    {
        $category_id = $request->get('category_id');
        $subject_id = $request->get('subject_id');
        $only_field = $request->get('only_field');
        $learning_journey = $request->get('learning_journey', 'no');
		$daily_quests = $request->get('daily_quests', 'no');
		$learning_journey_id = $request->get('learning_journey_id', 0);
		
		
        $webinars = Webinar::WhereJsonContains('category_id', (string) $category_id);
		if( $learning_journey == 'yes'){
			$LearningJourneysSubjects = LearningJourneys::where('year_id', $category_id)->where('id', '!=', $learning_journey_id)->pluck('subject_id')->toArray();
			$webinars = $webinars->whereNotIn('id', $LearningJourneysSubjects);
		}
		if( $daily_quests == 'yes'){
			$LearningJourneysSubjects = LearningJourneys::where('year_id', $category_id)->where('id', '!=', $learning_journey_id)->pluck('subject_id')->toArray();
			$webinars = $webinars->whereIn('id', $LearningJourneysSubjects);
		}
		$webinars = $webinars->get();
        if ($only_field != 'yes') {
            ?>
            <div class="form-group">

            <label>Subject</label>
        <?php } ?>
        <select class="form-control choose-curriculum-subject"
                name="subject_id">
            <option value="" class="font-weight-bold">Select Subject</option>
            <?php if (!empty($webinars)) {
                foreach ($webinars as $webinarsObj) {
                    $selected = ($subject_id == $webinarsObj->id) ? 'selected' : '';
                    echo '<option value="' . $webinarsObj->id . '" class="font-weight-bold" ' . $selected . '>' . $webinarsObj->getTitleAttribute() . '</option>';
                }
            }
            ?>
        </select>
        <?php if ($only_field != 'yes') { ?>
        </div>
        <?php
    }
        exit;
    }

    public function subjects_by_category_frontend(Request $request)
    {
        $category_id = $request->get('category_id');
        $subject_id = $request->get('subject_id');
        $only_field = $request->get('only_field');
        $webinars = Webinar::where('category_id', $category_id)
            ->get();
        if (!empty($webinars)) {
            echo ' <h5>Select Subject</h5><ul class="choose-curriculum-subject">';
                foreach ($webinars as $webinarsObj) {
                $checked = ($subject_id == $webinarsObj->id) ? 'checked' : '';
                echo '<li><input type="radio" value="'.$webinarsObj->id.'" name="subject" id="' . $webinarsObj->id . '" '.$checked.'><label for="' . $webinarsObj->id . '">' . $webinarsObj->getTitleAttribute() . '</label></li>';
            }
            echo '</ul>';
        }
        exit;
    }


}
