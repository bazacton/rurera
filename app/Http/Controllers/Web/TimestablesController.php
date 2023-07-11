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
            4,
            6,
            8
        );
        $tables_types = [
            'x',
            '÷',
        ];
        $total_questions = 10;
        $marks = 5;


        $questions_list = array();

        $questions_count = 1;
        if ($total_questions > 0) {
            while ($questions_count <= $total_questions) {
                $table_no = isset($tables_numbers[array_rand($tables_numbers)]) ? $tables_numbers[array_rand($tables_numbers)] : 0;
                $type = isset($tables_types[array_rand($tables_types)]) ? $tables_types[array_rand($tables_types)] : 0;
                $from_value = $table_no;
                $limit = 20;
                $min = 0;
                $min = ($type == '÷')? 1 :$min;
                $limit = ($type == '÷')? $from_value :$limit;
                $to_value = rand($min, $limit);
                $questions_list[] = (object) array(
                    'from'  => $from_value,
                    'to'    => $to_value,
                    'type'  => $type,
                    'table_no'  => $table_no,
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
