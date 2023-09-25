<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\WeeklyPlanner;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class WeeklyPlannerController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $weeklyPlanner = WeeklyPlanner::where('id', 1)
            ->with('WeeklyPlannerItems.WeeklyPlannerTopics.WeeklyPlannerTopicData')
            ->first();

        //pre($nationalCurriculum);
        $categories = Category::where('parent_id', null)
            ->with('subCategories')
            ->get();
        $data = [
            'pageTitle'          => 'Weekly Planner',
            'weeklyPlanner' => $weeklyPlanner,
            'categories'         => $categories,
        ];
        return view('web.default.weekly_planner.index', $data);

        abort(404);
    }


    public function weekly_planner_by_subject(Request $request){
        $category_id = $request->get('category_id', null);
        $subject_id = $request->get('subject_id', null);

        $weeklyPlanner = WeeklyPlanner::where('key_stage', $category_id)->where('subject_id', $subject_id)
            ->with('WeeklyPlannerItems.WeeklyPlannerTopics.WeeklyPlannerTopicData')
                    ->first();

        //pre($category_id, false);
        //pre($subject_id);

        $response_layout = view('web.default.weekly_planner.single_weekly_planner',['weeklyPlanner'=> $weeklyPlanner])->render();
        echo $response_layout;exit;

    }



}
