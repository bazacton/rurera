<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\QuizzesResult;
use App\Models\QuizzAttempts;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        $user = auth()->user();


        $QuizzesAttempts = QuizzAttempts::where('user_id', $user->id)->with([
                            'timeConsumed',
                            'endSession' => function ($query) {
                                    $query->orderBy('id', 'desc');
                                }
                        ])->orderBy('created_at', 'desc')->get();

        /*$QuizzesResult = QuizzesResult::where('user_id', $user->id)->with([
                            'timeConsumed'
                        ])->where('quiz_result_type', 'book_page')->orderBy('created_at', 'desc')->get();
*/
        $QuizzesAttempts = $QuizzesAttempts->groupBy(function ($QuizzesAttemptsQuery) {
            return date('d_m_Y', $QuizzesAttemptsQuery->created_at);
        });


        $analytics_data = array();

        if( !empty( $QuizzesAttempts ) ){

            foreach( $QuizzesAttempts as $date_str => $dateObj){
                if( !empty( $dateObj )){
                    $analytics_data[$date_str]['practice_time'] = 0;
                    $analytics_data[$date_str]['question_answered'] = 0;
                    foreach( $dateObj as $QuizzesAttemptObj){
                        //pre($QuizzesAttemptObj);
                        $topic_title = getTopicTitle($QuizzesAttemptObj->parent_type_id, $QuizzesAttemptObj->attempt_type);
                        $questions_list = isset( $QuizzesAttemptObj->questions_list )? json_decode($QuizzesAttemptObj->questions_list) : array();
                        $practice_time = $QuizzesAttemptObj->timeConsumed->sum('time_consumed');
                        $question_answered = $QuizzesAttemptObj->timeConsumed->whereNotIn('status', array('waiting'))->count();
                        $question_correct = $QuizzesAttemptObj->timeConsumed->where('status','correct')->count();
                        $question_incorrect = $QuizzesAttemptObj->timeConsumed->where('status','incorrect')->count();
                        //$last_attempted = $QuizzesAttemptObj->timeConsumed->whereNotIn('status', array('waiting'))->orderBy('name', 'desc')->count();
                        $practice_time = ($practice_time > 0)? round($practice_time / 60, 2) : 0;
                        $question_missed = (count($questions_list) - $question_answered);
                        $analytics_data[$date_str]['practice_time'] += $practice_time;
                        $analytics_data[$date_str]['question_answered'] += $question_answered;

                        $total_percentage = 0;
                        $score_level = 'Emerging';
                        if( $question_answered > 0 && $question_correct > 0){
                            $total_percentage = ($question_correct * 100) / $question_answered;
                            $total_percentage = round($total_percentage, 2);
                            $score_level = ($total_percentage > 0)? 'Emerging' : $score_level;
                            $score_level = ($total_percentage > 30)? 'Expecting' : $score_level;
                            $score_level = ($total_percentage > 60)? 'Exceeding' : $score_level;
                            $score_level = ($total_percentage > 80)? 'Expert' : $score_level;
                        }


                        $practice_time = ($QuizzesAttemptObj->attempt_type == 'timestables')? ($practice_time/10) : $practice_time;

                        $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['parent_type'] = $QuizzesAttemptObj->attempt_type;
                        $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['parent_type_id'] = $QuizzesAttemptObj->parent_type_id;

                        $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['topic_title'] = $topic_title;
                        $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['practice_time'] = $practice_time;
                        $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['question_answered'] = $question_answered;
                        $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['question_correct'] = $question_correct;
                        $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['total_questions'] = count($questions_list);
                        $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['question_missed'] = ($question_missed < 0)? 0 : $question_missed;
                        $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['question_incorrect'] = $question_incorrect;
                        $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['score_percentage'] = $total_percentage;
                        $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['score_level'] = $score_level;
                        $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['result_id'] = $QuizzesAttemptObj->quiz_result_id;
                        $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['start_time'] = $QuizzesAttemptObj->created_at;
                        $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['end_time'] = isset( $QuizzesAttemptObj->endSession->created_at )? $QuizzesAttemptObj->endSession->created_at : '';

                    }
                }
            }
        }


        $data['pageTitle']  = 'Analytics';
        $data['analytics_data'] = $analytics_data;
        return view('web.default.panel.analytics.index', $data);
    }
}
