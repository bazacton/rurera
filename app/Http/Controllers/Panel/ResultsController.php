<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\QuizzesResult;
use App\Models\QuizzAttempts;
use Illuminate\Http\Request;

class ResultsController extends Controller
{

    public function results(Request $request, $result_type, $result_id)
    {
        $QuizzesResult = QuizzesResult::find($result_id);
        $results = json_decode($QuizzesResult->results);
        $other_data = json_decode($QuizzesResult->other_data);
        $data = [
            'pageTitle' => 'Answers',
            'results' => $results,
            'QuizzesResult' => $QuizzesResult,
        ];
        return view(getTemplate() . '.panel.results.'.$result_type, $data);
    }

}
