<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\Models\Quiz;
use App\Models\QuizzesResult;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TimestablesController extends Controller
{

    public function index()
    {
        $data = [
            'pageTitle' => 'Times Tables',
        ];
        return view('web.default.timestables.index', $data);
    }

    public function landing()
    {
        $data = [
            'pageTitle' => 'Times Tables',
        ];
        return view('web.default.timestables.landing', $data);
    }

    /*
     * Generate Quiz
     */
    public function genearte(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        if (!auth()->subscription('timestables')) {
            return view('web.default.quizzes.not_subscribed');
        }
        $user = auth()->user();
        $question_type = $request->post('question_type');
        $no_of_questions = $request->post('no_of_questions');
        $tables_numbers = $request->post('question_values');
        $tables_types = [];

        if ($question_type == 'multiplication' || $question_type == 'multiplication_division') {
            $tables_types[] = 'x';
        }
        if ($question_type == 'division' || $question_type == 'multiplication_division') {
            $tables_types[] = '÷';
        }
        $total_questions = $no_of_questions;
        $marks = 5;


        $questions_list = array();

        $questions_count = 1;
        if ($total_questions > 0) {
            while ($questions_count <= $total_questions) {
                $table_no = isset($tables_numbers[array_rand($tables_numbers)]) ? $tables_numbers[array_rand($tables_numbers)] : 0;
                $type = isset($tables_types[array_rand($tables_types)]) ? $tables_types[array_rand($tables_types)] : 0;
                $from_value = $table_no;
                $limit = 12;
                $min = 2;
                $min = ($type == '÷') ? 1 : $min;
                $limit = ($type == '÷') ? $from_value : $limit;
                $to_value = rand($min, $limit);
                $questions_list[] = (object)array(
                    'from'     => $from_value,
                    'to'       => $to_value,
                    'type'     => $type,
                    'table_no' => $table_no,
                    'marks'    => $marks,
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

    /*
     * Timestables Summary
     */
    public function summary()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();

        $times_tables_data = $this->user_times_tables_data($user->id, 'x');
        $average_time = isset($times_tables_data['average_time']) ? $times_tables_data['average_time'] : array();
        $times_tables_data = isset($times_tables_data['tables_array']) ? $times_tables_data['tables_array'] : array();

        $data = [
            'pageTitle'         => 'Timestables Summary',
            'times_tables_data' => $times_tables_data,
            'average_time'      => $average_time,
            'authUser'          => $user,
        ];
        return view('web.default.timestables.summary', $data);
    }

    /*
     * Get User Times Tables
    */
    public function user_times_tables_data($user_id, $data_type = '')
    {
        $times_tables_data = QuizzesResult::where('user_id', $user_id)->where('quiz_result_type', 'timestables')->get();
        $times_tables_data = $times_tables_data->groupBy(function ($times_tables_obj) {
            return date('Y-m-d', $times_tables_obj->created_at);
        });

        $tables_array = $average_time = array();
        if (!empty($times_tables_data)) {
            foreach ($times_tables_data as $date => $times_tables_array) {
                $date = strtotime($date);
                if (!empty($times_tables_array)) {
                    foreach ($times_tables_array as $times_tablesObj) {
                        $results = json_decode($times_tablesObj->other_data);

                        if (!empty($results)) {
                            foreach ($results as $table_no => $table_rows) {

                                $time_consumed = 0;
                                if (!empty($table_rows)) {
                                    foreach ($table_rows as $tableRowObj) {
                                        if ($data_type == '' || $tableRowObj->type == $data_type) {
                                            $time_consumed += ($tableRowObj->time_consumed / 10);

                                            $tables_array[$date][$table_no][$tableRowObj->to]['label'] = $tableRowObj->from . ' ' . $tableRowObj->type . ' ' . $tableRowObj->to;
                                            $tables_array[$date][$table_no][$tableRowObj->to]['time_consumed'] = ($tableRowObj->time_consumed / 10);
                                            $tables_array[$date][$table_no][$tableRowObj->to]['is_correct'] = ($tableRowObj->is_correct == 'true') ? true : false;
                                            $tables_array[$date][$table_no][$tableRowObj->to]['table_to'] = $tableRowObj->to;
                                            $class = ($tableRowObj->is_correct == 'true') ? 'correct' : 'wrong';
                                            $class = ($class == 'correct' && ($tableRowObj->time_consumed / 10) < 2) ? 'correct-fast' : $class;
                                            $tables_array[$date][$table_no][$tableRowObj->to]['class'] = $class;
                                        }
                                    }
                                }
                                $average_time[$table_no]['time_consumed'] = $time_consumed;
                                $average_time[$table_no]['total_records'] = count($table_rows);
                                $average_time[$table_no]['average_time'] = round($time_consumed / count($table_rows), 2);

                            }
                        }
                    }
                }
            }
        }

        return array(
            'average_time' => $average_time,
            'tables_array' => $tables_array
        );
    }


}
