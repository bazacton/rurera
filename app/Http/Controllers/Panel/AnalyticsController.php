<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\QuizzesResult;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $QuizzesResult = QuizzesResult::where('user_id', $user->id)->with([
                    'timeConsumed'
                ])->orderBy('created_at', 'desc')->get();

        /*$QuizzesResult = QuizzesResult::where('user_id', $user->id)->with([
                            'timeConsumed'
                        ])->where('quiz_result_type', 'book_page')->orderBy('created_at', 'desc')->get();
*/
        $QuizzesResult = $QuizzesResult->groupBy(function ($QuizzesResultQuery) {
            return date('d_m_Y', $QuizzesResultQuery->created_at);
        });


        $analytics_data = array();

        if( !empty( $QuizzesResult ) ){

            foreach( $QuizzesResult as $date_str => $dateObj){
                if( !empty( $dateObj )){
                    $analytics_data[$date_str]['practice_time'] = 0;
                    $analytics_data[$date_str]['question_answered'] = 0;
                    foreach( $dateObj as $QuizzesResultObj){
                        //pre($QuizzesResultObj);
                        $topic_title = getTopicTitle($QuizzesResultObj->parent_type_id, $QuizzesResultObj->quiz_result_type);
                        $questions_list = isset( $QuizzesResultObj->questions_list )? json_decode($QuizzesResultObj->questions_list) : array();
                        $practice_time = $QuizzesResultObj->timeConsumed->sum('time_consumed');
                        $question_answered = $QuizzesResultObj->timeConsumed->whereNotIn('status', array('waiting', 'in_review'))->count();
                        $question_correct = $QuizzesResultObj->timeConsumed->where('status','correct')->count();
                        $question_incorrect = $QuizzesResultObj->timeConsumed->where('status','incorrect')->count();
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


                        $analytics_data[$date_str]['data'][$QuizzesResultObj->id]['parent_type'] = $QuizzesResultObj->quiz_result_type;
                        $analytics_data[$date_str]['data'][$QuizzesResultObj->id]['parent_type_id'] = $QuizzesResultObj->parent_type_id;



                        $analytics_data[$date_str]['data'][$QuizzesResultObj->id]['topic_title'] = $topic_title;
                        $analytics_data[$date_str]['data'][$QuizzesResultObj->id]['practice_time'] = $practice_time;
                        $analytics_data[$date_str]['data'][$QuizzesResultObj->id]['question_answered'] = $question_answered;
                        $analytics_data[$date_str]['data'][$QuizzesResultObj->id]['question_correct'] = $question_correct;
                        $analytics_data[$date_str]['data'][$QuizzesResultObj->id]['total_questions'] = count($questions_list);
                        $analytics_data[$date_str]['data'][$QuizzesResultObj->id]['question_missed'] = ($question_missed < 0)? 0 : $question_missed;
                        $analytics_data[$date_str]['data'][$QuizzesResultObj->id]['question_incorrect'] = $question_incorrect;
                        $analytics_data[$date_str]['data'][$QuizzesResultObj->id]['score_percentage'] = $total_percentage;
                        $analytics_data[$date_str]['data'][$QuizzesResultObj->id]['score_level'] = $score_level;



                    }
                }
            }
        }

        //pre($analytics_data);

        $data['pageTitle']  = 'Analytics';
        $data['analytics_data'] = $analytics_data;
        return view('web.default.panel.analytics.index', $data);
    }
}
