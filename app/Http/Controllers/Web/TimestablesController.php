<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TimestablesController extends Controller
{

    public function index()
    {
        $data = [
            'pageTitle' => '11 Plus',
        ];
        return view('web.default.11plus.index', $data);
    }

    /*
     * Start SAT Quiz
     */
    //public function genearte(Request $request, $id)
    public function genearte()
    {
        $tables_numbers = array(
            1,
            2,
            3
        );
        $tables_types = [
            '*',
            '-',
            '+',
        ];
        $total_questions = 10;
        $marks = 5;


        $questions_list = array();

        $questions_count = 1;
        if ($total_questions > 0) {
            while ($questions_count <= $total_questions) {
                $from_value = isset($tables_numbers[array_rand($tables_numbers)]) ? $tables_numbers[array_rand($tables_numbers)] : 0;
                $to_value = rand(0, 20);
                $type = isset($tables_types[array_rand($tables_types)]) ? $tables_types[array_rand($tables_types)] : 0;
                $questions_list[] = (object) array(
                    'from'  => $from_value,
                    'to'    => $to_value,
                    'type'  => $type,
                    'table_no'  => $from_value,
                    'marks' => $marks,
                );
                $questions_count++;
            }
        }

        $data = [
            'pageTitle'      => 'Start',
            'questions_list' => $questions_list,
        ];
        return view('web.default.timestables.start', $data);
    }


}
