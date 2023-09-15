<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\QuizzesResult;
use App\Models\QuizzAttempts;
use Illuminate\Http\Request;

class ResultsController extends Controller
{

    public function results(Request $request, $result_id, $result_type)
    {
        $QuizzesResult = QuizzesResult::find($result_id);
        $results = json_decode($QuizzesResult->results);
        $other_data = json_decode($QuizzesResult->other_data);
        //pre($results, false);
        //pre($results);
        //pre($QuizzesResult);
        //pre($result_type);
        $data = [
            'pageTitle' => 'Answers',
            'results' => $results,
        ];
        return view(getTemplate() . '.panel.results.'.$result_type, $data);
    }

}
