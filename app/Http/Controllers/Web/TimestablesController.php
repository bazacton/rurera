<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\Models\Page;
use App\Models\Quiz;
use App\Models\QuizzAttempts;
use App\Models\QuizzesResult;
use App\Models\QuizzResultQuestions;
use App\Models\UserAssignedTopics;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\TimestablesAssignments;
use App\Models\UserAssignedTimestables;
use App\Models\TimestablesTournaments;
use App\Models\TimestablesTournamentsEvents;
use App\Models\ShowdownLeaderboards;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TimestablesController extends Controller
{

    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();

        $trophyLeaderboard = User::where('trophy_average', '>', 0)
            ->orderBy('trophy_average', 'asc')
        ->get();

        //pre($trophyLeaderboard);

        $page = Page::where('link', '/timestables-practice')->where('status', 'publish')->first();
        $childs = array();
        if (auth()->check() && auth()->user()->isParent()) {
            $childs = User::where('role_id', 1)
                ->where('parent_type', 'parent')
                ->where('parent_id', auth()->user()->id)
                ->where('status', 'active')
                ->get();
        }
        $data = [
            'pageTitle'       => $page->title,
            'pageDescription' => $page->seo_description,
            'pageRobot'       => $page->robot ? 'index, follow, all' : 'NOODP, nofollow, noindex',
            'childs'          => $childs,
            //'pageTitle' => 'Multiplication Practices and challenges to Master TimesTables and win rewards | Rurera',
        ];
        return view('web.default.timestables.index', $data);
    }

    public function landing()
    {
        $page = Page::where('link', '/timestables')->where('status', 'publish')->first();
        $data = [
            'pageTitle'       => $page->title,
            'pageDescription' => $page->seo_description,
            'pageRobot'       => $page->robot ? 'index, follow, all' : 'NOODP, nofollow, noindex',
            //'pageTitle'       => 'Multiplication Practices and challenges to Master TimesTables and win rewards | Rurera',
            //'pageDescription' => 'Rurera provide interactive ways for students to learn and memorize timetables starting from 15GBP while having fun.',
            //'pageRobot'       => 'noindex',
        ];
        return view('web.default.timestables.landing', $data);
    }

    /*
     * Generate Quiz
     */
    public function genearte(Request $request)
    {
        if (!auth()->check()) {
            //return redirect('/login');
        }
        /*if (!auth()->subscription('timestables')) {
            return view('web.default.quizzes.not_subscribed');
        }*/
        $user = getUser();

        $question_type = $request->post('question_type');
        $no_of_questions = $request->post('no_of_questions');
        $tables_numbers = $request->post('question_values');

        $attempt_options = array(
            'question_type' => $question_type,
            'no_of_questions' => $no_of_questions,
            'question_values' => $tables_numbers,
        );

        if (auth()->guest()) {
            $total_attempted_questions = QuizzResultQuestions::where('quiz_result_type', 'timestables')->where('status', '!=', 'waiting')->where('user_id', 0)->where('user_ip', getUserIP())->count();
            $total_questions_allowed = getTimestablesLimit();
            $no_of_questions_new = ($total_questions_allowed - $total_attempted_questions);
            if ($no_of_questions_new <= $no_of_questions) {
                $no_of_questions = $no_of_questions_new;
            }
            if ($no_of_questions_new < 1) {
                $no_of_questions = $no_of_questions_new;
                return view('web.default.quizzes.limit_reached');
            }
        }

        $tables_types = [];

        if ($question_type == 'multiplication' || $question_type == 'multiplication_division') {
            $tables_types[] = 'x';
        }
        if ($question_type == 'division' || $question_type == 'multiplication_division') {
            $tables_types[] = '÷';
        }
        $total_questions = $no_of_questions;
        $marks = 5;


        $questions_list = $already_exists = array();


        $max_questions = 12;
        $current_question_max = 2;
        $questions_no_array = [];
        while ($current_question_max <= $max_questions) {
            $questions_no_array[$current_question_max] = $current_question_max;
            $current_question_max++;
        }

        $questions_no_array_fixed = $questions_no_array;

        $questions_count = 1;
        if ($total_questions > 0) {
            while ($questions_count <= $total_questions) {
                $table_no = isset($tables_numbers[array_rand($tables_numbers)]) ? $tables_numbers[array_rand($tables_numbers)] : 0;
                $type = isset($tables_types[array_rand($tables_types)]) ? $tables_types[array_rand($tables_types)] : 0;
                if (empty($questions_no_array)) {
                    $questions_no_array = $questions_no_array_fixed;
                }
                $questions_no_array = array_values($questions_no_array);
                shuffle($questions_no_array);
                $dynamic_min = array_keys($questions_no_array, min($questions_no_array))[0];
                $dynamic_max = array_keys($questions_no_array, max($questions_no_array))[0];
                $dynamic_no = rand($dynamic_min, $dynamic_max);
                $questions_no_dynamic = isset($questions_no_array[$dynamic_no]) ? $questions_no_array[$dynamic_no] : 0;
                if (isset($questions_no_array[$dynamic_no])) {
                    unset($questions_no_array[$dynamic_no]);
                    $questions_no_array = array_values($questions_no_array);
                }

                $last_value = ($questions_no_dynamic) * $table_no;
                $from_value = ($type == '÷') ? $last_value : $table_no;
                $limit = 12;
                $min = 2;
                $min = ($type == '÷') ? 1 : $min;
                $limit = ($type == '÷') ? ($table_no * $limit) : $limit;
                //$to_value = rand($min, $limit);
                $to_value = ($type == '÷') ? $table_no : $questions_no_dynamic;


                $questions_array_list[] = (object)array(
                    'from'     => $from_value,
                    'to'       => $to_value,
                    'type'     => $type,
                    'table_no' => $table_no,
                    'marks'    => $marks,
                );
                $questions_count++;
            }

            shuffle($questions_array_list);

            $question_show_count = 0;

            while ($question_show_count < $no_of_questions) {
                if ($question_show_count < 20) {
                    $questions_list[] = (object)isset($questions_array_list[$question_show_count]) ? $questions_array_list[$question_show_count] : array();
                } else {
                    $question_counter = rand(2, 19);
                    $questions_list[] = (object)isset($questions_array_list[$question_counter]) ? $questions_array_list[$question_counter] : array();
                }
                $question_show_count++;

            }


            $QuizzesResult = QuizzesResult::create([
                'user_id'          => $user->id,
                'results'          => json_encode($questions_list),
                'user_grade'       => 0,
                'status'           => 'waiting',
                'created_at'       => time(),
                'quiz_result_type' => 'timestables',
                'no_of_attempts'   => 100,
                'other_data'       => json_encode($questions_list),
                'user_ip'          => getUserIP(),
                'attempt_mode'     => 'freedom_mode',
                'attempt_options' => json_encode($attempt_options),
            ]);

            $QuizzAttempts = QuizzAttempts::create([
                'quiz_result_id' => $QuizzesResult->id,
                'user_id'        => $user->id,
                'start_grade'    => $QuizzesResult->user_grade,
                'end_grade'      => 0,
                'created_at'     => time(),
                'attempt_type'   => $QuizzesResult->quiz_result_type,
                'user_ip'        => getUserIP(),
            ]);
            $attempt_log_id = createAttemptLog($QuizzAttempts->id, 'Session Started', 'started');
        }


        $data = [
            'pageTitle'       => 'Start',
            'questions_list'  => $questions_list,
            'QuizzAttempts'   => $QuizzAttempts,
            'duration_type'   => 'no_time_limit',
            'time_interval'   => 0,
            'practice_time'   => 0,
            'total_questions' => $total_questions,
        ];
        return view('web.default.timestables.start', $data);
    }

    /*
     * Generate Quiz
     */
    public function assignment(Request $request, $assignment_id)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        if (!auth()->subscription('timestables')) {
            //return view('web.default.quizzes.not_subscribed');
        }

        $UserAssignmentObj = UserAssignedTimestables::findOrFail($assignment_id);
        if ($UserAssignmentObj->status != 'active') {
            return view('web.default.quizzes.unauthorized');
        }
        $assignments = $UserAssignmentObj->assignments;
        $user = auth()->user();
        $question_type = 'multiplication';
        $no_of_questions = $assignments->no_of_questions;
        $tables_numbers = json_decode($assignments->tables_no);
        $tables_types = [];

        if ($question_type == 'multiplication' || $question_type == 'multiplication_division') {
            $tables_types[] = 'x';
        }
        if ($question_type == 'division' || $question_type == 'multiplication_division') {
            $tables_types[] = '÷';
        }
        $total_questions = $no_of_questions;
        $marks = 1;


        $questions_list = $already_exists = array();


        $max_questions = $no_of_questions;//20;
        $current_question_max = 2;
        $questions_no_array = [];
        while ($current_question_max <= $max_questions) {
            $questions_no_array[$current_question_max] = $current_question_max;
            $current_question_max++;
        }

        $questions_count = 1;
        if ($total_questions > 0) {
            while ($questions_count <= $total_questions) {

                $limit = 20;
                $table_no = isset($tables_numbers[array_rand($tables_numbers)]) ? $tables_numbers[array_rand($tables_numbers)] : 0;
                $type = isset($tables_types[array_rand($tables_types)]) ? $tables_types[array_rand($tables_types)] : 0;
                $questions_no_array = array_values($questions_no_array);
                //pre($questions_no_array);
                shuffle($questions_no_array);
                $dynamic_min = array_keys($questions_no_array, min($questions_no_array))[0];
                $dynamic_max = array_keys($questions_no_array, max($questions_no_array))[0];
                $dynamic_max = ($dynamic_max > $limit) ? $limit : $dynamic_max;
                $dynamic_no = rand($dynamic_min, $dynamic_max);
                $questions_no_dynamic = isset($questions_no_array[$dynamic_no]) ? $questions_no_array[$dynamic_no] : 0;
                if (isset($questions_no_array[$dynamic_no])) {
                    unset($questions_no_array[$dynamic_no]);
                    $questions_no_array = array_values($questions_no_array);
                }

                $last_value = ($questions_no_dynamic) * $table_no;
                $from_value = ($type == '÷') ? $last_value : $table_no;
                $min = 2;
                $min = ($type == '÷') ? 1 : $min;
                $limit = ($type == '÷') ? ($table_no * $limit) : $limit;
                //$to_value = rand($min, $limit);
                $to_value = ($type == '÷') ? $table_no : $questions_no_dynamic;
                $to_value = ($to_value > $limit) ? rand($min, $limit) : $to_value;


                $questions_array_list[] = (object)array(
                    'from'     => $from_value,
                    'to'       => $to_value,
                    'type'     => $type,
                    'table_no' => $table_no,
                    'marks'    => $marks,
                );
                $questions_count++;
            }

            shuffle($questions_array_list);

            $question_show_count = 0;

            while ($question_show_count < $no_of_questions) {
                if ($question_show_count < 20) {
                    $questions_list[] = (object)isset($questions_array_list[$question_show_count]) ? $questions_array_list[$question_show_count] : array();
                } else {
                    $question_counter = rand(2, 19);
                    $questions_list[] = (object)isset($questions_array_list[$question_counter]) ? $questions_array_list[$question_counter] : array();
                }
                $question_show_count++;

            }


            $QuizzesResult = QuizzesResult::create([
                'user_id'          => $user->id,
                'results'          => json_encode($questions_list),
                'user_grade'       => 0,
                'status'           => 'waiting',
                'created_at'       => time(),
                'parent_type_id'   => $UserAssignmentObj->id,
                'quiz_result_type' => 'timestables_assignment',
                'no_of_attempts'   => 100,
                'other_data'       => json_encode($questions_list),
            ]);

            $QuizzAttempts = QuizzAttempts::create([
                'quiz_result_id' => $QuizzesResult->id,
                'user_id'        => $user->id,
                'start_grade'    => $QuizzesResult->user_grade,
                'end_grade'      => 0,
                'created_at'     => time(),
                'parent_type_id' => $QuizzesResult->parent_type_id,
                'attempt_type'   => $QuizzesResult->quiz_result_type,
            ]);
            $attempt_log_id = createAttemptLog($QuizzAttempts->id, 'Session Started', 'started');
        }


        $data = [
            'pageTitle'      => 'Start',
            'questions_list' => $questions_list,
            'QuizzAttempts'  => $QuizzAttempts,
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
        $user_ids = $user->id;

        if (auth()->user()->isParent()) {
            $user_ids = User::where('role_id', 1)
                ->where('parent_type', 'parent')
                ->where('parent_id', $user->id)
                ->where('status', 'active')->pluck('id')->toArray();
        }
        //$times_tables_data = $this->user_times_tables_data($user_ids, 'x');
        $times_tables_data = $this->user_times_tables_data_single_user($user_ids, 'x');
        $average_time = isset($times_tables_data['average_time']) ? $times_tables_data['average_time'] : array();
        $first_date = isset($times_tables_data['first_date']) ? $times_tables_data['first_date'] : '';
        $times_tables_data = isset($times_tables_data['tables_array']) ? $times_tables_data['tables_array'] : array();

        if( empty( $times_tables_data )) {
            $times_tables_data['is_empty'] = 'yes';
        }
        $data = [
            'pageTitle'         => 'Timestables Summary',
            'times_tables_data' => $times_tables_data,
            'average_time'      => $average_time,
            'authUser'          => $user,
            'first_date'        => $first_date,
            'user_ids'          => $user_ids,
        ];
        //return view('web.default.timestables.summary', $data);
        return view('web.default.timestables.summary_bk', $data);
    }

    /*
     * Get User Times Tables
    */
    public function user_times_tables_data($user_id, $data_type = '')
    {
        $user_ids = is_array($user_id) ? $user_id : array($user_id);
        //DB::enableQueryLog();
        $times_tables_data = QuizzesResult::whereIn('user_id', $user_ids)->where('quiz_result_type', 'timestables')->orderBy('created_at', 'asc')->get();
        $times_tables_data = $times_tables_data->groupBy(function ($times_tables_obj) {
            return date('Y-m-d', $times_tables_obj->created_at);
        });
        //pre(DB::getQueryLog());
        //DB::disableQueryLog();
        $tables_array = $average_time = $total_average_time = array();
        $first_date = '';
        if (!empty($times_tables_data)) {
            foreach ($times_tables_data as $date => $times_tables_array) {
                if ($first_date == '') {
                    $first_date = date("d F Y", strtotime($date));
                }
                $date = strtotime($date);
                if (!empty($times_tables_array)) {
                    foreach ($times_tables_array as $times_tablesObj) {
                        $current_user_id = $times_tablesObj->user->full_name;//$times_tablesObj->user_id;
                        $results = json_decode($times_tablesObj->other_data);

                        if (!empty($results)) {
                            foreach ($results as $table_no => $table_rows) {
                                $time_consumed = 0;
                                $timeTables_type = 'x';
                                if (!empty($table_rows)) {
                                    foreach ($table_rows as $tableRowObj) {
                                        if (!isset($tableRowObj->type) || $tableRowObj->type != 'x') {
                                            $timeTables_type = '÷';
                                            continue;
                                        }
                                        if ($data_type == '' || $tableRowObj->type == $data_type) {
                                            $time_consumed += ($tableRowObj->time_consumed / 10);

                                            $tables_array[$date][$current_user_id][$table_no][$tableRowObj->to]['label'] = $tableRowObj->from . ' ' . $tableRowObj->type . ' ' . $tableRowObj->to;
                                            $tables_array[$date][$current_user_id][$table_no][$tableRowObj->to]['time_consumed'] = ($tableRowObj->time_consumed / 10);
                                            $tables_array[$date][$current_user_id][$table_no][$tableRowObj->to]['is_correct'] = ($tableRowObj->is_correct == 'true') ? true : false;
                                            $tables_array[$date][$current_user_id][$table_no][$tableRowObj->to]['table_to'] = $tableRowObj->to;
                                            $class = ($tableRowObj->is_correct == 'true') ? 'correct' : 'wrong';
                                            $class = ($class == 'correct' && ($tableRowObj->time_consumed / 10) < 2) ? 'correct-fast' : $class;
                                            $tables_array[$date][$current_user_id][$table_no][$tableRowObj->to]['class'] = $class;
                                        }
                                    }
                                }
                                if ($timeTables_type == 'x') {
                                    $average_time[$current_user_id][$table_no]['time_consumed'] = $time_consumed;
                                    $table_rows_count = is_array($table_rows) ? count($table_rows) : 0;
                                    $average_time[$current_user_id][$table_no]['total_records'] = $table_rows_count;
                                    $average_time[$current_user_id][$table_no]['average_time'] = ($table_rows_count > 0) ? round($time_consumed / $table_rows_count, 2) : 0;
                                    $average_time_str = ($table_rows_count > 0) ? round($time_consumed / $table_rows_count, 2) : 0;


                                    $total_average_time[$table_no]['time_consumed'] = isset($total_average_time[$table_no]['time_consumed']) ? $total_average_time[$table_no]['time_consumed'] + $time_consumed : $time_consumed;
                                    $total_average_time[$table_no]['total_records'] = isset($total_average_time[$table_no]['total_records']) ? $total_average_time[$table_no]['total_records'] + $table_rows_count : $table_rows_count;
                                    $total_average_time[$table_no]['average_time'] = isset($total_average_time[$table_no]['average_time']) ? $total_average_time[$table_no]['average_time'] + $average_time_str : $average_time_str;

                                }

                            }
                        }
                    }
                }
            }
        }

        $tables_array_final = [];
        if (!empty($tables_array)) {
            foreach ($tables_array as $datestr => $userData) {

                if (!empty($user_ids)) {
                    foreach ($user_ids as $user_id) {
                        $user_full_name = User::where('id', $user_id)->value('full_name');
                        $tables_array_final[$datestr][$user_full_name] = isset($userData[$user_full_name]) ? $userData[$user_full_name] : array();
                    }
                }
            }
        }

        return array(
            'average_time' => $total_average_time,
            'tables_array' => $tables_array_final,
            'first_date'   => $first_date,
        );
    }

    public function user_times_tables_data_single_user($user_id, $data_type = '')
    {
        $user_ids = is_array($user_id) ? $user_id : array($user_id);
        //DB::enableQueryLog();
        $times_tables_data = QuizzesResult::whereIn('user_id', $user_ids)->whereIN('quiz_result_type', array('timestables','timestables_assignment'))->orderBy('created_at', 'asc')->get();
        $times_tables_data = $times_tables_data->groupBy(function ($times_tables_obj) {
            return date('Y-m-d', $times_tables_obj->created_at);
        });


        //pre(DB::getQueryLog());
        //DB::disableQueryLog();
        $tables_array = $average_time = $total_average_time = array();
        $already_Exists = $savedData = array();
        $first_date = '';
        if (!empty($times_tables_data)) {
            foreach ($times_tables_data as $date => $times_tables_array) {
                if ($first_date == '') {
                    $first_date = date("d F Y", strtotime($date));
                }
                $date = strtotime($date);
                if (!empty($times_tables_array)) {
                    foreach ($times_tables_array as $times_tablesObj) {
                        $current_user_id = $times_tablesObj->user->full_name;//$times_tablesObj->user_id;
                        $results = json_decode($times_tablesObj->other_data);

                        if (!empty($results)) {
                            foreach ($results as $table_no => $table_rows) {
                                $time_consumed = 0;
                                $timeTables_type = 'x';
                                if (!empty($table_rows)) {
                                    foreach ($table_rows as $tableRowObj) {
                                        if (!isset($tableRowObj->type) || $tableRowObj->type != 'x') {
                                            $timeTables_type = '÷';
                                            continue;
                                        }
                                        if ($data_type == '' || $tableRowObj->type == $data_type) {
                                            $time_consumed += ($tableRowObj->time_consumed / 10);

                                            $tables_array[$date][$table_no][$tableRowObj->to]['label'] = $tableRowObj->from . ' ' . $tableRowObj->type . ' ' . $tableRowObj->to;
                                            $tables_array[$date][$table_no][$tableRowObj->to]['time_consumed'] = ($tableRowObj->time_consumed / 10);
                                            $tables_array[$date][$table_no][$tableRowObj->to]['average_time'] = ($tableRowObj->time_consumed / 10);
                                            $tables_array[$date][$table_no][$tableRowObj->to]['is_correct'] = ($tableRowObj->is_correct == 'true') ? true : false;
                                            $tables_array[$date][$table_no][$tableRowObj->to]['table_to'] = $tableRowObj->to;

                                            $savedData[$table_no][$tableRowObj->to][] =  $tables_array[$date][$table_no][$tableRowObj->to];

                                            $class = ($tableRowObj->is_correct == 'true') ? 'correct' : 'wrong';
                                            $class = ($class == 'correct' && ($tableRowObj->time_consumed / 10) < 2) ? 'correct-fast' : $class;
                                            $tables_array[$date][$table_no][$tableRowObj->to]['class'] = '';
                                            $tables_array[$date][$table_no][$tableRowObj->to]['class'] = $class;
                                            if( isset( $already_Exists[$table_no][$tableRowObj->to])){
                                                $average_time_consumed = $time_consumed_event = 0;
                                                foreach( $savedData[$table_no][$tableRowObj->to] as $alreadyData){
                                                    $time_consumed_event = ($alreadyData['is_correct'] == true)? $alreadyData['average_time'] : 10;
                                                }
                                                $average_time_consumed = ($time_consumed_event*100)/(count($savedData[$table_no][$tableRowObj->to])*10);
                                                $tables_array[$date][$table_no][$tableRowObj->to]['average_time'] = $average_time_consumed;
                                                $tables_array[$date][$table_no][$tableRowObj->to]['attempts'] = isset( $tables_array[$date][$table_no][$tableRowObj->to]['attempts'] )? $tables_array[$date][$table_no][$tableRowObj->to]['attempts']+1 : 1;
                                                $tables_array[$date][$table_no][$tableRowObj->to]['class'] = 'average_'.intval(floor($average_time_consumed / 10));
                                            }else{
                                                $tables_array[$date][$table_no][$tableRowObj->to]['attempts'] = 1;
                                                //$tables_array[$date][$table_no][$tableRowObj->to]['class'] = '';
                                            }
                                            $already_Exists[$table_no][$tableRowObj->to] = $tableRowObj->to;
                                        }
                                    }
                                }
                                if ($timeTables_type == 'x') {
                                    $average_time[$table_no]['time_consumed'] = $time_consumed;
                                    $table_rows_count = is_array($table_rows) ? count($table_rows) : 0;
                                    $average_time[$table_no]['total_records'] = $table_rows_count;
                                    $average_time[$table_no]['average_time'] = ($table_rows_count > 0) ? round($time_consumed / $table_rows_count, 2) : 0;
                                    $average_time_str = ($table_rows_count > 0) ? round($time_consumed / $table_rows_count, 2) : 0;


                                    $total_average_time[$table_no]['time_consumed'] = isset($total_average_time[$table_no]['time_consumed']) ? $total_average_time[$table_no]['time_consumed'] + $time_consumed : $time_consumed;
                                    $total_average_time[$table_no]['total_records'] = isset($total_average_time[$table_no]['total_records']) ? $total_average_time[$table_no]['total_records'] + $table_rows_count : $table_rows_count;
                                    $total_average_time[$table_no]['average_time'] = isset($total_average_time[$table_no]['average_time']) ? $total_average_time[$table_no]['average_time'] + $average_time_str : $average_time_str;

                                }

                            }
                        }
                    }
                }
            }
        }

        //pre($tables_array);
        //pre($tables_array);
        $tables_array_final = $tables_last_data = [];
        if (!empty($tables_array)) {
            foreach ($tables_array as $datestr => $userData) {

                if (!empty($user_ids)) {
                    foreach ($user_ids as $user_id) {
                        $user_full_name = User::where('id', $user_id)->value('full_name');
                        $tables_array_final[$datestr] = isset($userData) ? $userData : array();
                        $tables_last_data = isset($userData) ? $userData : array();
                    }
                }
            }
        }
        return array(
            'average_time'     => $total_average_time,
            'tables_array'     => $tables_array_final,
            'tables_last_data' => $tables_last_data,
            'first_date'       => $first_date,
        );
    }

    /*
     * Get Timestables Result Data
     * @return the Incorrect / Excess Time taken / Not Attempted
     * @It only check the numbers those attempted by User e.g if User attempted the table 2, 3, 5 It will only get records for these not others
     *
     * @return - Array
     */
    public function get_timestables_attempted_result($tables_last_data)
    {

        $user = getUser();
        $user_timestables_no = isset( $user->timestables_no )? json_decode($user->timestables_no) : array();
        $incorrect_array = $excess_time_array = $not_attempted_array = $tables_array = $improvement_required_array = array();

        if (!empty($tables_last_data)) {
            foreach ($tables_last_data as $table_no => $table_data) {
                if (!in_array($table_no, $user_timestables_no)){
                    continue;
                }
                $tables_array[] = $table_no;

                $multiply_with_counter = 12;
                $counter = 1;
                while ($counter <= $multiply_with_counter) {
                    $is_attempted = isset($table_data[$counter]) ? true : false;

                    //Not Attempted
                    if ($is_attempted == false) {
                        $not_attempted_array[][$table_no] = $counter;
                        $improvement_required_array[][$table_no] = $counter;

                    }
                    $counter++;
                }

                if (!empty($table_data)) {
                    foreach ($table_data as $table_to => $table_conducted_data) {

                        $is_correct = (isset($table_conducted_data['is_correct']) && $table_conducted_data['is_correct'] == 1) ? true : false;
                        $is_excess_time = (isset($table_conducted_data['time_consumed']) && $table_conducted_data['time_consumed'] > 1) ? true : false;

                        //Incorrect
                        if ($is_correct == false) {
                            $incorrect_array[][$table_no] = $table_to;
                            $improvement_required_array[][$table_no] = $table_to;
                        }

                        //Excess Time
                        if ($is_excess_time == true) {
                            $excess_time_array[][$table_no] = $table_to;
                            $improvement_required_array[][$table_no] = $table_to;
                        }
                    }
                }


            }
        }

        return array(
            'incorrect_array'            => $incorrect_array,
            'excess_time_array'          => $excess_time_array,
            'not_attempted_array'        => $not_attempted_array,
            'improvement_required_array' => $improvement_required_array,
            'tables_array'               => $tables_array,
        );
    }


    /*
     * TimesTables Assignments Create
     */
    public function assignment_create(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        if (!auth()->user()->isParent()) {
            return redirect('/login');
        }
        $user = auth()->user();
        $time_interval = $request->post('time_interval');
        $no_of_questions = $request->post('no_of_questions');
        $users_array = $request->post('users');
        $question_tables = $request->post('question_tables');


        $TimestablesAssignment = TimestablesAssignments::create([
            'tables_no'       => json_encode($question_tables),
            'no_of_questions' => $no_of_questions,
            'time_interval'   => $time_interval,
            'assignment_date' => time(),
            'status'          => 'active',
            'created_by'      => $user->id,
            'created_at'      => time(),
        ]);

        if (!empty($users_array)) {
            /*foreach ($users_array as $user_id) {

                $UserAssignedTimestables = UserAssignedTopics::create([
                   'assigned_to_id' => $user_id,
                   'parent_id'      => $user->id,
                   'topic_id'       => $TimestablesEvents->id,
                   'topic_type'     => 'timestables',
                   'status'         => 'active',
                   'created_at'     => time(),
                   'start_at'     => $eventDate['start'],
                   'deadline_date'     => $eventDate['end'],
               ]);

            }*/
        }
        return view('web.default.timestables.start', $data);
    }

    /*
     * TimesTables Assignments Chase Layout
     */
    public function assignment_chase(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();
        //DB::enableQueryLog();
        $userActiveAssignments = UserAssignedTimestables::where('user_id', $user->id)->where('status', 'active')->orderBy('created_at', 'asc')
            ->whereHas(
                'timestables_events', function ($query) {
                $query->where('start_at', '<=', time());
            }
            )
            ->get();
        //pre(DB::getQueryLog());
        //DB::disableQueryLog();

        //pre($userActiveAssignments);


        $rendered_view = view('web.default.timestables.assignment_chase', ['user_active_assignments' => $userActiveAssignments])->render();
        echo $rendered_view;
        die();
    }

    /*
     * TimesTables Assignments Past Assignments
     */
    public function past_assignments(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();

        $userPastAssignments = UserAssignedTopics::where('assigned_to_id', $user->id)
                        ->where('status', 'completed')
                        ->with([
                            'StudentAssignmentData',
                        ])
                        ->get();

        $respose = '';
        if (!empty($userPastAssignments) && count($userPastAssignments) > 0) {
            foreach ($userPastAssignments as $assignmentObj) {
                $respose .= '<tr>
                            <td>
                                <strong>' . $assignmentObj->assignments->title . '</strong>
                            </td>
                            <td>
                                ' . dateTimeFormat($assignmentObj->conducted_results->created_at, 'd/m/Y') . ' <br/>
                                <span class="time">' . dateTimeFormat($assignmentObj->conducted_results->created_at, 'h:s') . '</span>
                            </td>
                            <td>' . $assignmentObj->conducted_results->quizz_result_questions_list->count() . '</td>
                            <td>
                                <span class="table-icon">
                                    <img src="/assets/default/svgs/coin-earn.svg" height="15" width="15" alt="#">
                                </span>
                                <span class="coin-nub">' . $assignmentObj->conducted_results->quizz_result_questions_list->where('status', 'correct')->sum('quiz_grade') . '</span>
                            </td>
                            <td>
                                <a href="panel/results/' . $assignmentObj->conducted_results->id . '/timetables" class="play-btn">Results</a>
                            </td>
                        </tr>';
            }
        } else {
            $respose .= '<tr>
                            <td colspan="4">No Records Found</td>
                        </tr>';
        }
        echo $respose;
        die();
    }


    /*
     * Generate Power-up Quiz
     */
    public function generate_powerup(Request $request)
    {
        if (!auth()->check()) {
            //return redirect('/login');
        }
        /*if (!auth()->subscription('timestables')) {
            return view('web.default.quizzes.not_subscribed');
        }*/
        $user = getUser();

        $times_tables_data = $this->user_times_tables_data_single_user(array($user->id), 'x');
        $tables_last_data = isset($times_tables_data['tables_last_data']) ? $times_tables_data['tables_last_data'] : array();
        $timestables_attempted_result = $this->get_timestables_attempted_result($tables_last_data);
        $tables_numbers = isset($timestables_attempted_result['tables_array']) ? $timestables_attempted_result['tables_array'] : array();
        $incorrect_array = isset($timestables_attempted_result['incorrect_array']) ? $timestables_attempted_result['incorrect_array'] : array();
        $excess_time_array = isset($timestables_attempted_result['excess_time_array']) ? $timestables_attempted_result['excess_time_array'] : array();
        $not_attempted_array = isset($timestables_attempted_result['not_attempted_array']) ? $timestables_attempted_result['not_attempted_array'] : array();
        $improvement_required_array = isset($timestables_attempted_result['improvement_required_array']) ? $timestables_attempted_result['improvement_required_array'] : array();

        $user_timestables_no = isset( $user->timestables_no )? json_decode($user->timestables_no) : array();
        $tables_numbers = array(
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            12
        );

        $tables_numbers = $user_timestables_no;

        $question_type = 'multiplication';
        $no_of_questions = 400;
        $practice_time = $request->post('practice_time');
        $practice_time_seconds = ($practice_time * 60);
        $practice_time_seconds = 10;
        //pre($practice_time_seconds);

        $tables_types = [];
        $tables_types[] = 'x';

        $total_questions = $no_of_questions;
        $marks = 5;


        $questions_list = $already_exists = $questions_array_list = array();

        if (!empty($improvement_required_array)) {
            foreach ($improvement_required_array as $required_data_key => $required_data_array) {
                if (!empty($required_data_array)) {
                    foreach ($required_data_array as $required_data_from => $required_data_to) {
                        $questions_array_list[] = (object)array(
                            'from'     => $required_data_from,
                            'to'       => $required_data_to,
                            'type'     => 'x',
                            'table_no' => $required_data_from,
                            'marks'    => $marks,
                        );
                    }
                }

            }
        }



        $max_questions = 12;
        $current_question_max = 2;
        $questions_no_array = [];
        while ($current_question_max <= $max_questions) {
            $questions_no_array[$current_question_max] = $current_question_max;
            $current_question_max++;
        }

        //pre($questions_no_array);

        $questions_no_array_fixed = $questions_no_array;

        $questions_count = 1;
        if ($total_questions > 0) {
            while ($questions_count <= $total_questions) {
                $table_no = isset($tables_numbers[array_rand($tables_numbers)]) ? $tables_numbers[array_rand($tables_numbers)] : 0;
                $type = isset($tables_types[array_rand($tables_types)]) ? $tables_types[array_rand($tables_types)] : 0;
                if (empty($questions_no_array)) {
                    $questions_no_array = $questions_no_array_fixed;
                }
                $questions_no_array = array_values($questions_no_array);
                shuffle($questions_no_array);
                $dynamic_min = array_keys($questions_no_array, min($questions_no_array))[0];
                $dynamic_max = array_keys($questions_no_array, max($questions_no_array))[0];
                $dynamic_no = rand($dynamic_min, $dynamic_max);
                $questions_no_dynamic = isset($questions_no_array[$dynamic_no]) ? $questions_no_array[$dynamic_no] : 0;
                if (isset($questions_no_array[$dynamic_no])) {
                    unset($questions_no_array[$dynamic_no]);
                    $questions_no_array = array_values($questions_no_array);
                }

                $last_value = ($questions_no_dynamic) * $table_no;
                $from_value = ($type == '÷') ? $last_value : $table_no;
                $limit = 12;
                $min = 2;
                $min = ($type == '÷') ? 1 : $min;
                $limit = ($type == '÷') ? ($table_no * $limit) : $limit;
                //$to_value = rand($min, $limit);
                $to_value = ($type == '÷') ? $table_no : $questions_no_dynamic;


                $questions_array_list[] = (object)array(
                    'from'     => $from_value,
                    'to'       => $to_value,
                    'type'     => $type,
                    'table_no' => $table_no,
                    'marks'    => $marks,
                );
                $questions_count++;
            }

            shuffle($questions_array_list);


            $question_show_count = 0;

            while ($question_show_count < $no_of_questions) {
                if ($question_show_count < 20) {
                    $questions_list[] = (object)isset($questions_array_list[$question_show_count]) ? $questions_array_list[$question_show_count] : array();
                } else {
                    $question_counter = rand(2, 19);
                    $questions_list[] = (object)isset($questions_array_list[$question_counter]) ? $questions_array_list[$question_counter] : array();
                }
                $question_show_count++;

            }

            $QuizzesResult = QuizzesResult::create([
                'user_id'          => $user->id,
                'results'          => json_encode($questions_list),
                'user_grade'       => 0,
                'status'           => 'waiting',
                'created_at'       => time(),
                'quiz_result_type' => 'timestables',
                'no_of_attempts'   => 100,
                'other_data'       => json_encode($questions_list),
                'user_ip'          => getUserIP(),
                'attempt_mode'     => 'powerup_mode',
            ]);

            $QuizzAttempts = QuizzAttempts::create([
                'quiz_result_id' => $QuizzesResult->id,
                'user_id'        => $user->id,
                'start_grade'    => $QuizzesResult->user_grade,
                'end_grade'      => 0,
                'created_at'     => time(),
                'attempt_type'   => $QuizzesResult->quiz_result_type,
                'user_ip'        => getUserIP(),
            ]);
            $attempt_log_id = createAttemptLog($QuizzAttempts->id, 'Session Started', 'started');
        }


        $data = [
            'pageTitle'       => 'Start',
            'questions_list'  => $questions_list,
            'QuizzAttempts'   => $QuizzAttempts,
            'duration_type'   => 'total_practice',
            'time_interval'   => 0,
            'practice_time'   => $practice_time_seconds,
            'total_questions' => $total_questions,
        ];
        //return view('web.default.timestables.start', $data);
        return view('web.default.timestables.start_powerup_mode', $data);
    }

    /*
     * Generate Power-up Quiz
     */
    public function generate_trophymode(Request $request)
    {
        if (!auth()->check()) {
            //return redirect('/login');
        }
        /*if (!auth()->subscription('timestables')) {
            return view('web.default.quizzes.not_subscribed');
        }*/
        $user = getUser();

        $tables_numbers = array(
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            12
        );

        $question_type = 'multiplication';
        $no_of_questions = 400;
        $practice_time = 1;
        $practice_time_seconds = ($practice_time * 60);
        //pre($practice_time_seconds);

        $tables_types = [];
        $tables_types[] = 'x';

        $total_questions = $no_of_questions;
        $marks = 5;


        $questions_list = $already_exists = $questions_array_list = array();

        $max_questions = 12;
        $current_question_max = 2;
        $questions_no_array = [];
        while ($current_question_max <= $max_questions) {
            $questions_no_array[$current_question_max] = $current_question_max;
            $current_question_max++;
        }

        //pre($questions_no_array);

        $questions_no_array_fixed = $questions_no_array;

        $questions_count = 1;
        if ($total_questions > 0) {
            while ($questions_count <= $total_questions) {
                $table_no = isset($tables_numbers[array_rand($tables_numbers)]) ? $tables_numbers[array_rand($tables_numbers)] : 0;
                $type = isset($tables_types[array_rand($tables_types)]) ? $tables_types[array_rand($tables_types)] : 0;
                if (empty($questions_no_array)) {
                    $questions_no_array = $questions_no_array_fixed;
                }
                $questions_no_array = array_values($questions_no_array);
                shuffle($questions_no_array);
                $dynamic_min = array_keys($questions_no_array, min($questions_no_array))[0];
                $dynamic_max = array_keys($questions_no_array, max($questions_no_array))[0];
                $dynamic_no = rand($dynamic_min, $dynamic_max);
                $questions_no_dynamic = isset($questions_no_array[$dynamic_no]) ? $questions_no_array[$dynamic_no] : 0;
                if (isset($questions_no_array[$dynamic_no])) {
                    unset($questions_no_array[$dynamic_no]);
                    $questions_no_array = array_values($questions_no_array);
                }

                $last_value = ($questions_no_dynamic) * $table_no;
                $from_value = ($type == '÷') ? $last_value : $table_no;
                $limit = 12;
                $min = 2;
                $min = ($type == '÷') ? 1 : $min;
                $limit = ($type == '÷') ? ($table_no * $limit) : $limit;
                //$to_value = rand($min, $limit);
                $to_value = ($type == '÷') ? $table_no : $questions_no_dynamic;


                $questions_array_list[] = (object)array(
                    'from'     => $from_value,
                    'to'       => $to_value,
                    'type'     => $type,
                    'table_no' => $table_no,
                    'marks'    => $marks,
                );
                $questions_count++;
            }

            shuffle($questions_array_list);


            $question_show_count = 0;

            while ($question_show_count < $no_of_questions) {
                if ($question_show_count < 20) {
                    $questions_list[] = (object)isset($questions_array_list[$question_show_count]) ? $questions_array_list[$question_show_count] : array();
                } else {
                    $question_counter = rand(2, 19);
                    $questions_list[] = (object)isset($questions_array_list[$question_counter]) ? $questions_array_list[$question_counter] : array();
                }
                $question_show_count++;

            }


            $QuizzesResult = QuizzesResult::create([
                'user_id'          => $user->id,
                'results'          => json_encode($questions_list),
                'user_grade'       => 0,
                'status'           => 'waiting',
                'created_at'       => time(),
                'quiz_result_type' => 'timestables',
                'no_of_attempts'   => 100,
                'other_data'       => json_encode($questions_list),
                'user_ip'          => getUserIP(),
                'attempt_mode'     => 'trophy_mode',
            ]);

            $QuizzAttempts = QuizzAttempts::create([
                'quiz_result_id' => $QuizzesResult->id,
                'user_id'        => $user->id,
                'start_grade'    => $QuizzesResult->user_grade,
                'end_grade'      => 0,
                'created_at'     => time(),
                'attempt_type'   => $QuizzesResult->quiz_result_type,
                'user_ip'        => getUserIP(),
            ]);
            $attempt_log_id = createAttemptLog($QuizzAttempts->id, 'Session Started', 'started');
        }


        $data = [
            'pageTitle'       => 'Start',
            'questions_list'  => $questions_list,
            'QuizzAttempts'   => $QuizzAttempts,
            'duration_type'   => 'total_practice',
            'time_interval'   => 0,
            'practice_time'   => $practice_time_seconds,
            'total_questions' => $total_questions,
        ];
        //return view('web.default.timestables.start', $data);
        return view('web.default.timestables.start_trophy_mode', $data);
    }

    /*
     * Generate Treasure Mission Stage
     */
    public function generate_treasure_mission(Request $request)
    {
        if (!auth()->check()) {
            //return redirect('/login');
        }
        /*if (!auth()->subscription('timestables')) {
            return view('web.default.quizzes.not_subscribed');
        }*/
        $user = getUser();



        $nugget_id = $request->post('nugget_id');
        $treasure_mission_data = get_treasure_mission_data();
        $nugget_data = searchNuggetByID($treasure_mission_data,'id', $nugget_id);
        $levelData = isset( $nugget_data['levelData'] )? $nugget_data['levelData'] : array();
        $tables_data = isset( $nugget_data['tables'] )? $nugget_data['tables'] : array();
        $previous_tables = isset( $nugget_data['previous_tables'] )? $nugget_data['previous_tables'] : array();
        $prev_no_questions = isset( $nugget_data['prev_no_questions'] )? $nugget_data['prev_no_questions'] : 0;
        $time_interval = isset( $levelData['time_interval'] )? $levelData['time_interval'] : 0;
        $life_lines = isset( $levelData['life_lines'] )? $levelData['life_lines'] : 0;
        $life_lines = $user->user_life_lines;
        $questions_array_list = array();


        $tables_types = [];
        $tables_types[] = 'x';
        $marks = 5;
        $max_questions = 12;
        $current_question_max = 2;

        $questions_no_array = [];
        while ($current_question_max <= $max_questions) {
            $questions_no_array[$current_question_max] = $current_question_max;
            $current_question_max++;
        }
        $questions_no_array_fixed = $questions_no_array;

        $excess_time = 70; //7 Seconds

        $type = isset($tables_types[array_rand($tables_types)]) ? $tables_types[array_rand($tables_types)] : 0;

        $table_questions_counter = 0;


        $incorrect_list = array();
        if( !empty( $previous_tables ) ) {
            foreach ($previous_tables as $table_no) {
                if( $table_no != 3){
                    continue;
                }
                $incorrect_list[$table_no] = QuizzResultQuestions::where('parent_type_id', $table_no)->where('quiz_result_type', 'timestables')->where('attempt_mode', 'treasure_mode')->where('status', 'incorrect')->pluck('child_type_id')->toArray();
                $excess_time_list[$table_no] = QuizzResultQuestions::where('parent_type_id', $table_no)->where('quiz_result_type', 'timestables')->where('attempt_mode', 'treasure_mode')->where('status', 'correct')->where('time_consumed', '>', $excess_time)->pluck('child_type_id')->toArray();
                $correct_list[$table_no] = QuizzResultQuestions::where('parent_type_id', $table_no)->where('quiz_result_type', 'timestables')->where('attempt_mode', 'treasure_mode')->where('status', 'correct')->where('time_consumed', '<=', $excess_time)->pluck('child_type_id')->toArray();

                $correct_list[$table_no] = array_unique($correct_list[$table_no]);
                $incorrect_list[$table_no] = array_unique(array_diff($incorrect_list[$table_no], $correct_list[$table_no]));
                $excess_time_list[$table_no] = array_unique(array_diff($excess_time_list[$table_no], $correct_list[$table_no]));
            }
        }


        if( !empty( $incorrect_list ) ){
            foreach( $incorrect_list as $incorrect_table => $incorrect_no_array){
                if( !empty( $incorrect_no_array ) ){
                    foreach( $incorrect_no_array as $incorrect_no){
                        $questions_array_list[] = (object)array(
                            'from'     => $incorrect_table,
                            'to'       => $incorrect_no,
                            'type'     => $type,
                            'table_no' => $incorrect_table,
                            'marks'    => $marks,
                        );
                        $table_questions_counter++;
                    }
                }
            }
        }

        if( !empty( $excess_time_list ) ){
            foreach( $excess_time_list as $excess_time_table => $excess_time_no_array){
                if( !empty( $excess_time_no_array ) ) {
                    foreach ($excess_time_no_array as $excess_time_no) {
                        $questions_array_list[] = (object)array(
                            'from'     => $excess_time_table,
                            'to'       => $excess_time_no,
                            'type'     => $type,
                            'table_no' => $excess_time_table,
                            'marks'    => $marks,
                        );
                        $table_questions_counter++;
                    }
                }
            }
        }

        $questions_count = $table_questions_counter;

        if ($prev_no_questions > 0 && !empty( $previous_tables )) {
            while ($questions_count < $prev_no_questions) {
                $table_no = isset($previous_tables[array_rand($previous_tables)]) ? $previous_tables[array_rand($previous_tables)] : 0;
                if (empty($questions_no_array)) {
                    $questions_no_array = $questions_no_array_fixed;
                }
                $questions_no_array = array_values($questions_no_array);
                shuffle($questions_no_array);
                $dynamic_min = array_keys($questions_no_array, min($questions_no_array))[0];
                $dynamic_max = array_keys($questions_no_array, max($questions_no_array))[0];
                $dynamic_no = rand($dynamic_min, $dynamic_max);
                $questions_no_dynamic = isset($questions_no_array[$dynamic_no]) ? $questions_no_array[$dynamic_no] : 0;
                if (isset($questions_no_array[$dynamic_no])) {
                    unset($questions_no_array[$dynamic_no]);
                    $questions_no_array = array_values($questions_no_array);
                }

                $last_value = ($questions_no_dynamic) * $table_no;
                $from_value = ($type == '÷') ? $last_value : $table_no;
                $limit = 12;
                $min = 2;
                $min = ($type == '÷') ? 1 : $min;
                $limit = ($type == '÷') ? ($table_no * $limit) : $limit;
                //$to_value = rand($min, $limit);
                $to_value = ($type == '÷') ? $table_no : $questions_no_dynamic;


                $questions_array_list[] = (object)array(
                    'from'     => $from_value,
                    'to'       => $to_value,
                    'type'     => $type,
                    'table_no' => $table_no,
                    'marks'    => $marks,
                );
                $questions_count++;
            }
        }
        if( !empty( $tables_data ) ) {
            foreach ($tables_data as $table_no => $table_no_of_questions) {
                $questions_count = 0;
                if ($table_no_of_questions > 0) {
                    while ($questions_count < $table_no_of_questions) {
                        if (empty($questions_no_array)) {
                            $questions_no_array = $questions_no_array_fixed;
                        }
                        $questions_no_array = array_values($questions_no_array);
                        shuffle($questions_no_array);
                        $dynamic_min = array_keys($questions_no_array, min($questions_no_array))[0];
                        $dynamic_max = array_keys($questions_no_array, max($questions_no_array))[0];
                        $dynamic_no = rand($dynamic_min, $dynamic_max);
                        $questions_no_dynamic = isset($questions_no_array[$dynamic_no]) ? $questions_no_array[$dynamic_no] : 0;
                        if (isset($questions_no_array[$dynamic_no])) {
                            unset($questions_no_array[$dynamic_no]);
                            $questions_no_array = array_values($questions_no_array);
                        }

                        $last_value = ($questions_no_dynamic) * $table_no;
                        $from_value = ($type == '÷') ? $last_value : $table_no;
                        $limit = 12;
                        $min = 2;
                        $min = ($type == '÷') ? 1 : $min;
                        $limit = ($type == '÷') ? ($table_no * $limit) : $limit;
                        //$to_value = rand($min, $limit);
                        $to_value = ($type == '÷') ? $table_no : $questions_no_dynamic;


                        $questions_array_list[] = (object)array(
                            'from'     => $from_value,
                            'to'       => $to_value,
                            'type'     => $type,
                            'table_no' => $table_no,
                            'marks'    => $marks,
                        );
                        $questions_count++;
                    }
                }

            }
        }


        shuffle($questions_array_list);
        $questions_list = $questions_array_list;

        $QuizzesResult = QuizzesResult::create([
            'user_id'          => $user->id,
            'results'          => json_encode($questions_list),
            'user_grade'       => 0,
            'status'           => 'waiting',
            'created_at'       => time(),
            'quiz_result_type' => 'timestables',
            'no_of_attempts'   => 100,
            'other_data'       => json_encode($questions_list),
            'user_ip'          => getUserIP(),
            'attempt_mode'     => 'treasure_mode',
            'nugget_id'        => $nugget_id,
        ]);

        $QuizzAttempts = QuizzAttempts::create([
            'quiz_result_id' => $QuizzesResult->id,
            'user_id'        => $user->id,
            'start_grade'    => $QuizzesResult->user_grade,
            'end_grade'      => 0,
            'created_at'     => time(),
            'attempt_type'   => $QuizzesResult->quiz_result_type,
            'user_ip'        => getUserIP(),
        ]);
        $attempt_log_id = createAttemptLog($QuizzAttempts->id, 'Session Started', 'started');


        $stageData = array();
        if( isset( $nugget_data['stageData']['id'] ) ){
            $stageData = searchNuggetByID($treasure_mission_data,'id', $nugget_data['stageData']['id']);
        }
        $user_timetables_levels = json_decode($user->user_timetables_levels);
        $user_timetables_levels = is_array( $user_timetables_levels ) ? $user_timetables_levels : array();

        if( $life_lines <= 0){
            $data['unauthorized_text'] = 'You dont have any life line, please come again tomorrow!';
            $data['unauthorized_link'] = '/timestables-practice';
            return view('web.default.quizzes.unauthorized_landing', $data);
        }
        //pre($life_lines);
        $data = [
            'pageTitle'       => 'Start',
            'questions_list'  => $questions_list,
            'QuizzAttempts'   => $QuizzAttempts,
            'duration_type'   => 'per_question',
            'time_interval'   => $time_interval,
            'life_lines'      => $life_lines,
            'nugget_data'    => $nugget_data,
            'levelData'      => $levelData,
            'stageObj'     => $stageData,
            'user_timetables_levels' => $user_timetables_levels,
            'practice_time'   => 0,
            'total_questions' => count($questions_array_list),
        ];
        return view('web.default.timestables.start_treasure_mode', $data);
    }


    /*
     * Generate Showdown Mode Stage
     */
    public function generate_showdown_mode(Request $request)
    {
        if (!auth()->check()) {
            //return redirect('/login');
        }
        /*if (!auth()->subscription('timestables')) {
            return view('web.default.quizzes.not_subscribed');
        }*/
        $user = getUser();
        $tables_data = array(
            '2' => 6,
            '3' => 10,
            '4' => 10,
            '5' => 7,
            '6' => 10,
            '7' => 10,
            '8' => 10,
            '9' => 10,
            '10' => 7,
            '11' => 10,
            '12' => 10,
        );

        $previous_tables = isset( $nugget_data['previous_tables'] )? $nugget_data['previous_tables'] : array();
        $practice_time_seconds = (5 * 60);
        $questions_array_list = array();


        $tables_types = [];
        $tables_types[] = 'x';
        $marks = 5;
        $max_questions = 12;
        $current_question_max = 2;

        $questions_no_array = [];
        while ($current_question_max <= $max_questions) {
            $questions_no_array[$current_question_max] = $current_question_max;
            $current_question_max++;
        }
        $questions_no_array_fixed = $questions_no_array;

        $type = isset($tables_types[array_rand($tables_types)]) ? $tables_types[array_rand($tables_types)] : 0;

        $table_questions_counter = 0;


        $questions_count = $table_questions_counter;


        if( !empty( $tables_data ) ) {
            foreach ($tables_data as $table_no => $table_no_of_questions) {
                $questions_count = 0;
                if ($table_no_of_questions > 0) {
                    while ($questions_count < $table_no_of_questions) {
                        if (empty($questions_no_array)) {
                            $questions_no_array = $questions_no_array_fixed;
                        }
                        $questions_no_array = array_values($questions_no_array);
                        shuffle($questions_no_array);
                        $dynamic_min = array_keys($questions_no_array, min($questions_no_array))[0];
                        $dynamic_max = array_keys($questions_no_array, max($questions_no_array))[0];
                        $dynamic_no = rand($dynamic_min, $dynamic_max);
                        $questions_no_dynamic = isset($questions_no_array[$dynamic_no]) ? $questions_no_array[$dynamic_no] : 0;
                        if (isset($questions_no_array[$dynamic_no])) {
                            unset($questions_no_array[$dynamic_no]);
                            $questions_no_array = array_values($questions_no_array);
                        }

                        $last_value = ($questions_no_dynamic) * $table_no;
                        $from_value = ($type == '÷') ? $last_value : $table_no;
                        $limit = 12;
                        $min = 2;
                        $min = ($type == '÷') ? 1 : $min;
                        $limit = ($type == '÷') ? ($table_no * $limit) : $limit;
                        //$to_value = rand($min, $limit);
                        $to_value = ($type == '÷') ? $table_no : $questions_no_dynamic;


                        $questions_array_list[] = (object)array(
                            'from'     => $from_value,
                            'to'       => $to_value,
                            'type'     => $type,
                            'table_no' => $table_no,
                            'marks'    => $marks,
                        );
                        $questions_count++;
                    }
                }

            }
        }


        shuffle($questions_array_list);
        $questions_list = $questions_array_list;

        $QuizzesResult = QuizzesResult::create([
            'user_id'          => $user->id,
            'results'          => json_encode($questions_list),
            'user_grade'       => 0,
            'status'           => 'waiting',
            'created_at'       => time(),
            'quiz_result_type' => 'timestables',
            'no_of_attempts'   => 100,
            'other_data'       => json_encode($questions_list),
            'user_ip'          => getUserIP(),
            'attempt_mode'     => 'showdown_mode',
            'nugget_id'        => 0,
        ]);

        $QuizzAttempts = QuizzAttempts::create([
            'quiz_result_id' => $QuizzesResult->id,
            'user_id'        => $user->id,
            'start_grade'    => $QuizzesResult->user_grade,
            'end_grade'      => 0,
            'created_at'     => time(),
            'attempt_type'   => $QuizzesResult->quiz_result_type,
            'user_ip'        => getUserIP(),
        ]);
        $attempt_log_id = createAttemptLog($QuizzAttempts->id, 'Session Started', 'started');


        $data = [
            'pageTitle'       => 'Start',
            'questions_list'  => $questions_list,
            'QuizzAttempts'   => $QuizzAttempts,
            'duration_type'   => 'total_practice',
            'time_interval'   => 0,
            'practice_time'   => $practice_time_seconds,
            'total_questions' => count($questions_array_list),
        ];
        return view('web.default.timestables.start_showdown_mode', $data);
    }

    /*
    * TimesTables Global Arena
    */
    public function global_arena(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();
        //DB::enableQueryLog();
        $TournamentsPendingEvents = TimestablesTournamentsEvents::where('status', 'pending')->where('active_at', '<=', time())->orderBy('time_remaining', 'asc')->get();

        pre($TournamentsPendingEvents);

        $TimestablesTournamentsEvents = TimestablesTournamentsEvents::where('status', 'active')->where('active_at', '<=', time())->orderBy('time_remaining', 'asc')->get();
        pre($TimestablesTournamentsEvents);
        //pre(DB::getQueryLog());
        //DB::disableQueryLog();


        $rendered_view = view('web.default.timestables.global_arena', ['timestablesTournamentsEvents' => $TimestablesTournamentsEvents])->render();
        echo $rendered_view;
        die();
    }

    /*
    * TimesTables Freedom Mode Layout
    */
    public function freedom_mode(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();

        $results_data = QuizzesResult::where('user_id', $user->id)->where('quiz_result_type', 'timestables')->where('attempt_mode', 'freedom_mode')->orderBy('created_at', 'desc')->limit(10)->get();
        $attempts_array = $attempts_labels = $attempts_values = array();
        if (!empty($results_data)) {
            foreach ($results_data as $resultObj) {
                $created_at = dateTimeFormat($resultObj->created_at, 'j M y');
                $attempts_array[$created_at] = $resultObj->quizz_result_questions_list->where('status', '=', 'correct')->count();
                $attempts_labels[] = $created_at;
                $attempts_values[] = $resultObj->quizz_result_questions_list->where('status', '=', 'correct')->count();
            }
        }
        $attempts_array = array_reverse($attempts_array);
        $attempts_labels = array_reverse($attempts_labels);
        $attempts_values = array_reverse($attempts_values);

        $rendered_view = view('web.default.timestables.freedom_mode', ['results_data'    => $results_data])->render();
        echo $rendered_view;
        die();
    }

    /*
    * TimesTables Power-up Mode Layout
    */
    public function powerup_mode(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();
        $results_data = QuizzesResult::where('user_id', $user->id)->where('quiz_result_type', 'timestables')->where('attempt_mode', 'powerup_mode')->orderBy('created_at', 'desc')->limit(10)->get();
        $attempts_array = $attempts_labels = $attempts_values = array();
        if (!empty($results_data)) {
            foreach ($results_data as $resultObj) {
                $created_at = dateTimeFormat($resultObj->created_at, 'j M y');
                $attempts_array[$created_at] = $resultObj->quizz_result_questions_list->where('status', '=', 'correct')->count();
                $attempts_labels[] = $created_at;
                $attempts_values[] = $resultObj->quizz_result_questions_list->where('status', '=', 'correct')->count();
            }
        }
        $attempts_array = array_reverse($attempts_array);
        $attempts_labels = array_reverse($attempts_labels);
        $attempts_values = array_reverse($attempts_values);

        $times_tables_data = $this->user_times_tables_data_single_user($user->id, 'x');
        $average_time = isset($times_tables_data['average_time']) ? $times_tables_data['average_time'] : array();
        $first_date = isset($times_tables_data['first_date']) ? $times_tables_data['first_date'] : '';
        $times_tables_data = isset($times_tables_data['tables_array']) ? $times_tables_data['tables_array'] : array();

        if( empty( $times_tables_data )) {
            $times_tables_data['is_empty'] = 'yes';
        }


        $rendered_view = view('web.default.timestables.powerup_mode', [
            'results_data'    => $results_data,
            'attempts_array'  => $attempts_array,
            'attempts_labels' => $attempts_labels,
            'attempts_values' => $attempts_values,
            'times_tables_data' => $times_tables_data,
            'first_date' => $first_date,
        ])->render();
        echo $rendered_view;
        die();
    }


    /*
    * TimesTables Trophy Mode Layout
    */
    public function trophy_mode(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();
        $results_data = QuizzesResult::where('user_id', $user->id)->where('quiz_result_type', 'timestables')->where('attempt_mode', 'trophy_mode')->orderBy('created_at', 'desc')->limit(10)->get();
        $attempts_array = $attempts_labels = $attempts_values = array();
        if (!empty($results_data)) {
            foreach ($results_data as $resultObj) {
                $created_at = dateTimeFormat($resultObj->created_at, 'j M y');
                $attempts_array[$created_at] = $resultObj->quizz_result_questions_list->where('status', '=', 'correct')->count();
                $attempts_labels[] = $created_at;
                $attempts_values[] = $resultObj->quizz_result_questions_list->where('status', '=', 'correct')->count();
            }
        }
        $attempts_array = array_reverse($attempts_array);
        $attempts_labels = array_reverse($attempts_labels);
        $attempts_values = array_reverse($attempts_values);


        $rendered_view = view('web.default.timestables.trophy_mode', [
            'results_data'    => $results_data,
            'attempts_array'  => $attempts_array,
            'attempts_labels' => $attempts_labels,
            'attempts_values' => $attempts_values,
        ])->render();
        echo $rendered_view;
        die();
    }

    /*
    * TimesTables Treasure Mission Layout
    */
    public function treasure_mission(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();
        $user_timetables_levels = json_decode($user->user_timetables_levels);
        $user_timetables_levels = is_array( $user_timetables_levels ) ? $user_timetables_levels : array();
        $treasure_mission_data = get_treasure_mission_data();

        $rendered_view = view('web.default.timestables.treasure_mission', ['treasure_mission_data' => $treasure_mission_data, 'user_timetables_levels' => $user_timetables_levels])->render();
        echo $rendered_view;
        die();
    }

    /*
    * TimesTables Showdown Mode Layout
    */
    public function showdown_mode(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();
        $weekNumber = $request->get('weekNumber', 0);
        /*$usersList = User::where('role_id', 1)->where('showdown_time_consumed', '>', 0)
            ->orderByDesc('showdown_correct')
            ->orderBy('showdown_time_consumed', 'asc')
            ->pluck('id')->toArray();
        $user_rank = array_search($user->id, $usersList);
        $user_rank = ( $user_rank !== false)? $user_rank+1 : $user_rank;
        */


        $currentDate = Carbon::now();
        $currentWeek = $currentDate->weekOfYear;
        if( $weekNumber > 0){
            $currentDate = Carbon::now()->setISODate(date('Y'), $weekNumber, 1);
        }
        $currentWeekStartDate = $currentDate->clone()->startOfWeek();
        $currentWeekEndDate = $currentDate->clone()->endOfWeek();

        $selectedWeek = $currentDate->weekOfYear;

        $previousWeek = ($selectedWeek-1);


        $lastMonday = $currentWeekStartDate->toDateString();
        $lastMonday .= ' 00:00:00';

        $nextSunday = $currentWeekEndDate->toDateString();
        $nextSunday .= ' 23:59:59';

        $lastMonday = strtotime($lastMonday);
        $nextSunday = strtotime($nextSunday);

        $leaderboardResults = ShowdownLeaderboards::where('showdown_time_consumed', '>', 0)->whereBetween('created_at', [$lastMonday, $nextSunday])
            ->orderByDesc('showdown_correct')
            ->orderBy('showdown_time_consumed', 'asc')
        ->get();

        $alreadyAttempt = $leaderboardResults->contains('user_id', $user->id);

        if( $selectedWeek != $currentWeek){
            $alreadyAttempt = true;
        }


        $rendered_view = view('web.default.timestables.showdown_mode', ['alreadyAttempt' => $alreadyAttempt, 'leaderboardResults' => $leaderboardResults, 'selectedWeek' => $selectedWeek, 'currentWeek'=>$currentWeek, 'previousWeek'=>$previousWeek, 'lastMonday' => $lastMonday,'nextSunday' => $nextSunday ])->render();
        echo $rendered_view;
        die();
    }

    /*
    * TimesTables School Zone Mode Layout
    */
    public function school_zone_mode(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();

        $yearStudents = User::where('role_id', 1)
            ->where('year_id', $user->year_id)
            ->where('status', 'active')
            ->get();
        $classStudents = User::where('role_id', 1)
            ->where('year_id', $user->year_id)
            ->where('class_id', $user->class_id)
            ->where('status', 'active')
            ->get();

        $rendered_view = view('web.default.timestables.school_zone_mode', ['yearStudents' => $yearStudents, 'classStudents' => $classStudents])->render();
        echo $rendered_view;
        die();
    }


    /*
     * Update Tournament Event
     */
    public function update_tournament_event(Request $request)
    {
        $tournament_event_id = $request->post('tournament_event_id');
        $TimestablesEventObj = TimestablesTournamentsEvents::find($tournament_event_id);
        $seconds_count = $request->post('seconds_count');
        $eventData = array(
            'time_remaining' => $seconds_count,
            'updated_at'     => time(),
        );
        $response = '';
        if ($seconds_count < 1) {
            $eventData['status'] = 'archived';

            $timestablesEventNewObj = $TimestablesEventObj->replicate();
            $timestablesEventNewObj->time_remaining = $timestablesEventNewObj->total_time;
            $timestablesEventNewObj->created_at = time();
            $timestablesEventNewObj->updated_at = time();
            $timestablesEventNewObj->status = 'active';
            $timestablesEventNewObj->save();

            $response = '<div class="swiper-slide">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="deals-card" style="background:{{$timestablesEventNewObj>tournament->bg_color}}">
                                                        <div class="card">
                                                            <div class="card-timer">
                                                                <p id="timer" data-id="{{$timestablesEventNewObj->id}}" class="tournament-timer" data-timer="{{$timestablesEventNewObj->time_remaining}}">{{$timestablesEventNewObj->time_remaining}}</p>
                                                            </div>
                                                            <a href="#">
                                                                <h5>{{$timestablesEventNewObj->tournament->title}}</h5>
                                                                <p>$265,200 <span>{{$timestablesEventNewObj->tournament->sub_title}}</span></p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <ul>
                                                        <li>
                                                            <div class="card-btn">
                                                                <a href="#"><i>&#x207A;</i> Join tournament</a>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <a href="#">
                                                                        <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                        <div class="text">
                                                                            <h6>Emma Thompson</h6>
                                                                            <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 98,321 <span>Whiz</span></p>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <a href="#">
                                                                        <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                                        <div class="text">
                                                                            <h6>Liam Parker</h6>
                                                                            <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 75,092 <span>Enthusiast</span></p>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>';


        }
        $TimestablesEventObj->update($eventData);
        echo $response;
        exit;

    }


}
