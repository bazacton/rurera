<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\QuestionsAttemptController;
use App\Models\QuizzesResult;
use App\Models\QuizzAttempts;
use App\Models\BooksUserReading;
use App\Models\RewardAccounting;
use App\User;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(Request $request, $type = 'all')
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();
        $user_id = $user->id;
        if (auth()->user()->isParent()) {
            $_GET['child'] = isset( $_GET['child'])? $_GET['child'] : 'all';
            $user_id = isset( $_GET['child'] )? $_GET['child'] : $user_id;
        }
        $selected_child = 'Select Student';
        if(isset( $_GET['child'] )){
            $selected_child = User::find($_GET['child']);
            $selected_child = isset( $selected_child->id )? $selected_child->get_full_name() : '';
            $selected_child = ($_GET['child'] == 'all')? 'All Students' : $selected_child;
        }

        $childs = array();
        if (auth()->user()->isParent()) {

            $childs = $user->parentChilds->where('status', 'active');

            if ($childs->count() == 0) {
                return redirect('/' . panelRoute() . '/students');
            }
        }

        $childs_ids = $childs->pluck('user_id')->toArray();

        $user_id = ( $user_id == 'all')? $childs_ids : $user_id;

        $user_id = is_array($user_id )? $user_id : array($user_id);


        //pre($user_id);


        $QuestionsAttemptController = new QuestionsAttemptController();
        $summary_type = '11plus';
        $QuizzResultQuestionsObj = $QuestionsAttemptController->prepare_graph_data($summary_type, $user_id);


        $graphs_array = array();

        $start_date = strtotime('2023-12-18');
        $end_date = strtotime('2023-12-24');
        $custom_dates = array(
            'start' => $start_date,
            'end'   => $end_date,
        );

        $graphs_array['Custom'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'custom', $start_date, $end_date);

        $graphs_array['Year'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'yearly');
        $graphs_array['Month'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'monthly');
        $graphs_array['Week'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'weekly');
        $graphs_array['Day'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'daily');
        $graphs_array['Hour'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'hourly');

        $completedQuests = RewardAccounting::where('user_id', $user->id)->where('status', RewardAccounting::ADDICTION)->where('parent_type', 'quest')->get();

        $userQuests = array();
        if( !empty($completedQuests) ){
            foreach( $completedQuests as $completedQuestObj){
                $userQuests[$completedQuestObj->result_id] = $completedQuestObj;
            }
        }

        $BooksUserReading = BooksUserReading::whereIn('user_id', $user_id)->where('status', 'active')->with([
            'BooksPages.BookData',
        ])->orderBy('created_at', 'desc')->get();

        $BooksUserReading = $BooksUserReading->groupBy(function ($BooksUserReadingQuery) {
            return date('d_m_Y', $BooksUserReadingQuery->created_at);
        });

        $reading_analytics_data = array();
        if (!empty($BooksUserReading)) {

            foreach ($BooksUserReading as $date_str => $readingData) {
                if (!empty($readingData)) {
                    $readingData = $readingData->groupBy(function ($readingDataQuery) {
                        return $readingDataQuery->book_id;
                    });
                    foreach ($readingData as $readingArray) {
                        if (!empty($readingArray)) {
                            $total_read_time = $readingArray->sum('read_time');
                            $pages_list = array();
                            foreach ($readingArray as $readingObj) {
                                $pages_list[] = $readingObj->BooksPages->page_no;
                                $reading_analytics_data[$date_str][$readingObj->BooksPages->BookData->id]['book_title'] = $readingObj->BooksPages->BookData->book_title;
                                $reading_analytics_data[$date_str][$readingObj->BooksPages->BookData->id]['pages_read'][] = $readingObj->BooksPages->page_no;
                                $reading_analytics_data[$date_str][$readingObj->BooksPages->BookData->id]['read_time'] = $total_read_time;
                                $reading_analytics_data[$date_str][$readingObj->BooksPages->BookData->id]['book_slug'] = $readingObj->BooksPages->BookData->book_slug;
                            }
                        }
                    }
                }
            }
        }
        //pre($reading_analytics_data);
        $types_array = array(
            'practice',
            'assessment',
            'book',
            'book_page',
            'sats',
            '11plus',
            'timestables',
            'vocabulary',
            'timestables_assignment',
            'assignment',
        );
        $type_selected = 'all';
        if( $type != 'all'){
            $type_selected = $type;
            $types_array = array($type);
            if( $type == 'tests'){
                $types_array = array(
                    'sats',
                    '11plus',
                );
            }
            if( $type == 'books'){
                $types_array = array(
                    'practice',
                       'assessment',
                       'book',
                       'book_page',
                       'sats',
                       '11plus',
                       'timestables',
                       'vocabulary',
                       'timestables_assignment',
                       'assignment',
                );
            }
        }



        $QuizzesAttempts = QuizzAttempts::whereIn('user_id', $user_id)->whereIn('attempt_type', $types_array)->with([
            'timeConsumed',
            'endSession' => function ($query) {
                $query->orderBy('id', 'desc');
            },
        ])->whereHas('quizzes_results', function ($query) {
            $query->where('status', '!=', 'waiting');
        })->orderBy('created_at', 'desc')->get()->filter(function ($attempt) {
            return $attempt->timeConsumed->sum('time_consumed') > 0;
        });

        $QuizzesAttempts = $QuizzesAttempts->groupBy(function ($QuizzesAttemptsQuery) {
            return date('d_m_Y', $QuizzesAttemptsQuery->created_at);
        });



        $analytics_data = array();

        if (!empty($QuizzesAttempts)) {


            foreach ($QuizzesAttempts as $date_str => $dateObj) {
                if (!empty($dateObj)) {
                    $analytics_data[$date_str]['coins_earned'] = 0;
                    $analytics_data[$date_str]['practice_time'] = 0;
                    $analytics_data[$date_str]['question_answered'] = 0;


                    $read_time_data = 0;
                    $reading_analyticsArray = isset($reading_analytics_data[$date_str]) ? $reading_analytics_data[$date_str] : array();
                    if (!empty($reading_analyticsArray)) {
                        foreach ($reading_analyticsArray as $book_id => $reading_analyticsObj) {
                            $analytics_data[$date_str]['data'][$book_id]['topic_title'] = isset($reading_analyticsObj['book_title']) ? $reading_analyticsObj['book_title'] . ' (Reading)' : '';
                            $read_time = isset($reading_analyticsObj['read_time']) ? $reading_analyticsObj['read_time'] : 0;
                            $read_time = ($read_time > 0) ? round($read_time / 60, 2) : 0;
                            $analytics_data[$date_str]['data'][$book_id]['type'] = 'book_read';

                            $analytics_data[$date_str]['data'][$book_id]['read_time'] = $read_time;
                            $read_time_data = $read_time;
                            $analytics_data[$date_str]['data'][$book_id]['pages_read'] = isset($reading_analyticsObj['pages_read']) ? implode(', ', $reading_analyticsObj['pages_read']) : '';

                            $analytics_data[$date_str]['data'][$book_id]['parent_type'] = 'book_read';
                            $analytics_data[$date_str]['data'][$book_id]['book_slug'] = isset($reading_analyticsObj['book_slug']) ? $reading_analyticsObj['book_slug'] : '';

                            $analytics_data[$date_str]['practice_time'] += $read_time;

                        }
                    }


                    if( $type != 'books') {
                        foreach ($dateObj as $QuizzesAttemptObj) {
                            if ($QuizzesAttemptObj->quizzes_results->status == 'waiting') {
                                continue;
                            }
                            $topic_title = getTopicTitle($QuizzesAttemptObj->parent_type_id, $QuizzesAttemptObj->attempt_type);
                            $questions_list = isset($QuizzesAttemptObj->questions_list) ? json_decode($QuizzesAttemptObj->questions_list) : array();
                            $practice_time = $QuizzesAttemptObj->timeConsumed->sum('time_consumed');
                            $question_answered = $QuizzesAttemptObj->timeConsumed->whereNotIn('status', array('waiting'))->count();
                            $question_correct = $QuizzesAttemptObj->timeConsumed->where('status', 'correct')->count();
                            $question_incorrect = $QuizzesAttemptObj->timeConsumed->where('status', 'incorrect')->count();
                            $coins_earned = $QuizzesAttemptObj->timeConsumed->where('status', 'correct')->sum('quiz_grade');
                            //$last_attempted = $QuizzesAttemptObj->timeConsumed->whereNotIn('status', array('waiting'))->orderBy('name', 'desc')->count();
                            $practice_time = ($QuizzesAttemptObj->attempt_type == 'timestables' || $QuizzesAttemptObj->attempt_type == 'timestables_assignment') ? round(($practice_time / 10), 2) : $practice_time;
                            $practice_time = ($practice_time > 0) ? round($practice_time, 2) : 0;
                            $question_missed = (count($questions_list) - $question_answered);
                            $analytics_data[$date_str]['coins_earned'] += $coins_earned;
                            $analytics_data[$date_str]['practice_time'] += $practice_time;
                            $analytics_data[$date_str]['practice_time'] += isset($read_time_data) ? $read_time_data : 0;
                            $read_time_data = 0;
                            $analytics_data[$date_str]['question_answered'] += $question_answered;

                            $total_percentage = 0;
                            $score_level = 'Emerging';
                            if ($question_answered > 0 && $question_correct > 0) {
                                $total_percentage = ($question_correct * 100) / $question_answered;
                                $total_percentage = round($total_percentage, 2);
                                $score_level = ($total_percentage > 0) ? 'Emerging' : $score_level;
                                $score_level = ($total_percentage > 30) ? 'Expecting' : $score_level;
                                $score_level = ($total_percentage > 60) ? 'Exceeding' : $score_level;
                                $score_level = ($total_percentage > 80) ? 'Expert' : $score_level;
                            }


                            $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['parent_type'] = $QuizzesAttemptObj->attempt_type;
                            $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['parent_type_id'] = $QuizzesAttemptObj->parent_type_id;

                            $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['topic_title'] = $topic_title;
                            $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['user'] = $QuizzesAttemptObj->user;
                            $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['practice_time'] = $practice_time;
                            $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['question_answered'] = $question_answered;
                            $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['question_correct'] = $question_correct;
                            $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['total_questions'] = count($questions_list);
                            $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['question_missed'] = ($question_missed < 0) ? 0 : $question_missed;
                            $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['question_incorrect'] = $question_incorrect;
                            $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['coins_earned'] = $coins_earned;
                            $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['score_percentage'] = $total_percentage;
                            $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['score_level'] = $score_level;
                            $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['result_id'] = $QuizzesAttemptObj->quiz_result_id;
                            $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['start_time'] = $QuizzesAttemptObj->created_at;
                            $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['end_time'] = isset($QuizzesAttemptObj->endSession->created_at) ? $QuizzesAttemptObj->endSession->created_at : '';

                            if ($QuizzesAttemptObj->attempt_type == 'timestables') {
                                $end_date_str = $QuizzesAttemptObj->created_at + ($practice_time * 60);
                                $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['end_time'] = $end_date_str;
                            }
                            $start_time = (int)$analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['start_time'];
                            $end_time = (int)$analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['end_time'];

                            $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['more_than_minute'] = (($end_time - $start_time) > 59) ? 'yes' : 'no';
                            $analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['type'] = '';

                            if( isset( $userQuests[$QuizzesAttemptObj->quiz_result_id])){
                                $userQuestObj = $userQuests[$QuizzesAttemptObj->quiz_result_id];
                                $questObj = $userQuestObj->quest;
                                $quest_icon = '/assets/default/img/types/'.$questObj->quest_topic_type.'.svg';
                                $quest_icon = ( $questObj->quest_icon != '')? $questObj->quest_icon : $quest_icon;


                                $analytics_data[$date_str]['data'][$userQuestObj->id]['parent_type'] = 'quest';
                                $analytics_data[$date_str]['data'][$userQuestObj->id]['topic_title'] = 'Quest ('.$questObj->title.')';
                                $analytics_data[$date_str]['data'][$userQuestObj->id]['coins_earned'] = $userQuestObj->score;
                                $analytics_data[$date_str]['data'][$userQuestObj->id]['user'] = $QuizzesAttemptObj->user;
                                $analytics_data[$date_str]['data'][$userQuestObj->id]['start_time'] = $userQuestObj->created_at;
                                $analytics_data[$date_str]['data'][$userQuestObj->id]['type'] = 'quest';
                                $analytics_data[$date_str]['data'][$userQuestObj->id]['list_icon'] = $quest_icon;
                                $analytics_data[$date_str]['data'][$userQuestObj->id]['list_icon'] = '/assets/default/img/panel-sidebar/coins.svg';

                            }

                            //$analytics_data[$date_str]['data'][$QuizzesAttemptObj->id]['type'] = '';

                        }
                    }
                }

            }
        }

        //pre('test');

        $data['pageTitle'] = 'Analytics';
        $data['analytics_data'] = $analytics_data;
        //$data['user_graph_data'] = $user_graph_data;
        //$data['QuizzResultQuestionsObj']   => $QuizzResultQuestionsObj;
        $data['graphs_array'] = $graphs_array;
        $data['custom_dates'] = $custom_dates;
        $data['summary_type'] = $summary_type;
        $data['childs'] = $childs;
        $data['selected_child'] = $selected_child;
        $data['type_selected'] = $type_selected;
        $data['QuestionsAttemptController'] = $QuestionsAttemptController;
        return view('web.default.panel.analytics.index', $data);
    }

    public function graph_data(Request $request)
    {
        $summary_type = $request->get('graph_type', null);
        $start_date = $request->get('start_date', '2023-09-20');
        $end_date = $request->get('end_date', '2023-09-26');
        $show_types = $request->get('show_types', false);

        $user = auth()->user();

        $QuestionsAttemptController = new QuestionsAttemptController();
        $QuizzResultQuestionsObj = $QuestionsAttemptController->prepare_graph_data(array($summary_type));

        $graphs_array = array();

        $start_date = strtotime($start_date);
        $end_date = strtotime($end_date);
        $custom_dates = array(
            'start' => $start_date,
            'end'   => $end_date,
        );

        $graphs_array['Custom'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'custom', $start_date, $end_date);

        $graphs_array['Year'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'yearly');
        $graphs_array['Month'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'monthly');
        $graphs_array['Week'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'weekly');
        $graphs_array['Day'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'daily');
        $graphs_array['Hour'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'hourly');

        $graph_data_layout = view('web.default.panel.analytics.graph_data', ['show_types'                 => $show_types,
                                                                             'custom_dates'               => $custom_dates,
                                                                             'graphs_array'               => $graphs_array,
                                                                             'summary_type'               => $summary_type,
                                                                             'QuestionsAttemptController' => $QuestionsAttemptController
        ])->render();
        echo $graph_data_layout;
        exit;

    }
}
