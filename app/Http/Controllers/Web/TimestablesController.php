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
use Illuminate\Support\Facades\DB;

class TimestablesController extends Controller
{

    public function index(Request $request)
    {
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

        if( auth()->guest()) {
            $total_attempted_questions = QuizzResultQuestions::where('quiz_result_type', 'timestables')->where('status', '!=', 'waiting')->where('user_id', 0)->where('user_ip', getUserIP())->count();
            $total_questions_allowed = getTimestablesLimit();
            $no_of_questions_new = ($total_questions_allowed - $total_attempted_questions);
            if( $no_of_questions_new <= $no_of_questions){
                $no_of_questions = $no_of_questions_new;
            }
            if( $no_of_questions_new < 1){
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
        $current_question_max = 1;
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
        $current_question_max = 1;
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
        $times_tables_data = $this->user_times_tables_data($user_ids, 'x');
        $average_time = isset($times_tables_data['average_time']) ? $times_tables_data['average_time'] : array();
        $first_date = isset($times_tables_data['first_date']) ? $times_tables_data['first_date'] : '';
        $times_tables_data = isset($times_tables_data['tables_array']) ? $times_tables_data['tables_array'] : array();

        $data = [
            'pageTitle'         => 'Timestables Summary',
            'times_tables_data' => $times_tables_data,
            'average_time'      => $average_time,
            'authUser'          => $user,
            'first_date'        => $first_date,
            'user_ids'          => $user_ids,
        ];
        return view('web.default.timestables.summary', $data);
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
        $userPastAssignments = UserAssignedTimestables::where('user_id', $user->id)->where('status', 'completed')->orderBy('created_at', 'asc')
            ->whereHas(
                'timestables_events', function ($query) {
                $query->where('start_at', '<=', time());
            }
            )->get();

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
