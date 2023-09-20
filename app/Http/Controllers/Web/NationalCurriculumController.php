<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\NationalCurriculum;
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

        //pre($nationalCurriculum);
        $categories = Category::where('parent_id', null)
            ->with('subCategories')
            ->get();
        $data = [
            'pageTitle'          => 'National Curriculum',
            'nationalCurriculum' => $nationalCurriculum,
            'categories'         => $categories,
        ];
        return view('web.default.national_curriculum.index', $data);

        abort(404);
    }


    public function curriculum_by_subject(Request $request){
        $category_id = $request->get('category_id', null);
        $subject_id = $request->get('subject_id', null);

        $nationalCurriculum = NationalCurriculum::where('key_stage', $category_id)->where('subject_id', $subject_id)
                    ->with('NationalCurriculumItems.NationalCurriculumChapters.NationalCurriculumTopics.NationalCurriculumTopicData')
                    ->first();
        $response_layout = view('web.default.national_curriculum.single_curriculum', ['nationalCurriculum'  => $nationalCurriculum])->render();
        echo $response_layout;exit;

    }



}
