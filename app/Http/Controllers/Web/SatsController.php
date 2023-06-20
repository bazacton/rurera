<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class SatsController extends Controller
{

    public function index()
    {

        $query = Quiz::where('status' , Quiz::ACTIVE)->where('quiz_type' , 'sats');
        $sats = $query->paginate(9);

        //pre($sats);

        $QuestionsAttemptController = new QuestionsAttemptController();

        if (!empty($sats)) {
            $data = ['pageTitle' => 'SATs' , 'sats' => $sats , 'QuestionsAttemptController' => $QuestionsAttemptController];
            return view('web.default.sats.index' , $data);
        }

        abort(404);
    }

    /*
     * Start SAT Quiz
     */
    public function start(Request $request , $id)
    {
        $quiz = Quiz::find($id);
        $data = ['pageTitle' => 'Start', 'quiz' => $quiz];
        return view('web.default.quizzes.start' , $data);
    }


}
