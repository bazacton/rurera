<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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
        $data = [
            'pageTitle'          => 'National Curriculum',
            'nationalCurriculum' => $nationalCurriculum,
        ];
        return view('web.default.national_curriculum.index', $data);

        abort(404);
    }


}
