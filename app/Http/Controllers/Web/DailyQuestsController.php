<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\Models\DailyQuests;
use App\Models\QuizzesResult;
use App\Models\Page;
use App\Models\RewardAccounting;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use thiagoalessio\TesseractOCR\TesseractOCR;

class DailyQuestsController extends Controller
{

    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        if (!auth()->user()->isUser()) {
            return redirect('/panel');
        }
        $user = auth()->user();

        $quests = $user->getUserQuests();
        $page = Page::where('link', '/quests')->where('status', 'publish')->first();

        $data = [
            'pageTitle'       => isset( $page->title )? $page->title : '',
            'pageDescription' => isset( $page->seo_description )? $page->seo_description : '',
            'pageRobot'       => isset( $page->robot ) ? 'index, follow, all' : 'NOODP, nofollow, noindex',
            'quests'          => $quests,
        ];
        return view('web.default.quests.index', $data);
    }

    public function questCompletionCheck($QuizzesResult)
    {

        $questObj = array();
        switch ($QuizzesResult->quiz_result_type) {

            case    "timestables":
                $questObj = $this->timestablesQuestCheck($QuizzesResult);
                break;
        }
    }


    public function timestablesQuestCheck($QuizzesResult)
    {

        $user = auth()->user();
        //$quests = DailyQuests::where('quest_topic_type', $QuizzesResult->quiz_result_type)->where('timestables_mode', $QuizzesResult->attempt_mode)->where('status', 'active')->get();


        $todayStartTimestamp = Carbon::now()->startOfDay()->timestamp;
        $todayEndTimestamp = Carbon::now()->endOfDay()->timestamp;

        $quests = $user->getUserQuests();

        /*
         * $quests = DailyQuests::where('quest_topic_type', $QuizzesResult->quiz_result_type)
                     ->where('timestables_mode', $QuizzesResult->attempt_mode)
                     ->where('status', 'active')
                     ->where('quest_end_date' ,'>=', strtotime(date('Y-m-d 00:00:00')))
                     ->withCount([
                         'QuestRewardsCount as rewards_count' => function ($query) {
                             $query->where('parent_type', '=', 'quest');
                         }
                     ])
                     ->having('rewards_count', '=', 0)
                     ->get();
         */

        foreach ($quests as $questObj) {

            $quest_method = $questObj->quest_method;
            $recurring_type = $questObj->recurring_type;

            $QuestUserData = $this->getQuestUserData($questObj);
            $is_completed = isset( $QuestUserData['is_completed'] )? $QuestUserData['is_completed'] : false;

            if( $is_completed != true){
                continue;
            }


            $questScore = $questObj->no_of_coins;


            if ($questObj->coins_type == 'percentage') {
                $quizzResultPoints = $QuizzesResult->quizz_result_points->count();
                $questScore = ($quizzResultPoints * $questObj->coins_percentage) / $quizzResultPoints;
            }
            RewardAccounting::create([
                'user_id'       => $user->id,
                'item_id'       => 0,
                'type'          => 'coins',
                'score'         => $questScore,
                'status'        => 'addiction',
                'created_at'    => time(),
                'parent_id'     => $questObj->id,
                'parent_type'   => 'quest',
                'full_data'     => '',
                'updated_at'    => time(),
                'assignment_id' => 0,
                'result_id'     => $QuizzesResult->id,
            ]);

        }


    }

    /*
    * Get User Quest Data
    */
    public function getQuestUserData($questObj)
    {
        $user = auth()->user();
        $quest_method = $questObj->quest_method;
        $recurring_type = $questObj->recurring_type;
        $no_of_practices = $questObj->no_of_practices;
        $lessons_score = $questObj->lessons_score;
        $no_of_answers = $questObj->no_of_answers;
        $screen_time = $questObj->screen_time;



        $QuizzesResults = QuizzesResult::where('user_id', $user->id)
        ->where('quiz_result_type', $questObj->quest_topic_type)
        ->where('status', '!=', 'waiting');
        if( $questObj->quest_topic_type == 'timestables'){
            $QuizzesResults->where('attempt_mode', $questObj->timestables_mode);
        }


        //pre(date('Y-m-d 00:00:00'));
        //pre(date('Y-m-d 00:00:00'), false);
        //pre(date('Y-m-d 23:59:59'));
        $QuizzesResults->where('created_at' ,'>=', strtotime(date('Y-m-d 00:00:00')));
        $QuizzesResults->where('created_at' ,'<=', strtotime(date('Y-m-d 23:59:59')));

        $QuizzesResults = $QuizzesResults->get();

        $questScore = $questObj->no_of_coins;
        if ($questObj->coins_type == 'percentage') {
            $questScore = $questObj->coins_percentage.'x';
        }

        $total_time_consumed = $completion_percentage = 0;
        $attemptPercentage = $attemptCorrect = $attemptInRowCorrect = array();
        $quest_bar_label = '';

        if( $quest_method == 'screen_time'){
            $total_time_consumed = ($QuizzesResults->sum('total_time_consumed') > 0) ? ($QuizzesResults->sum('total_time_consumed') / 60) : 0;
            $completion_percentage = ($total_time_consumed * 100) / $screen_time;
            $completion_percentage = ($completion_percentage > 0)? round($completion_percentage, 2) : 0;
            $completion_percentage = ($completion_percentage > 100)? 100 : $completion_percentage;
            $completion_percentage = ($completion_percentage < 0)? 0 : $completion_percentage;
            $quest_bar_label = $completion_percentage.'%';
        }

        if( $quest_method == 'lessons_score'){
            foreach( $QuizzesResults as $QuizzesResultObj) {
                $attemptPercentage[$QuizzesResultObj->id] = $QuizzesResultObj->quizz_result_percentage();
                $attemptCorrect[$QuizzesResultObj->id] = $QuizzesResultObj->quizz_result_points->count();
            }
            //pre($attemptPercentage);
            $attemptedEligible = array_filter($attemptPercentage, function($value) use ($lessons_score) {
                return $value >= $lessons_score;
            });

            $attempts_count = count($attemptedEligible);
            $attempts_count = ($attempts_count > $no_of_practices)? $no_of_practices : $attempts_count;

            $quest_bar_label = $attempts_count.' / '. $no_of_practices;
            $completion_percentage = ($attempts_count * 100) / $no_of_practices;
        }

        if( $quest_method == 'correct_answers'){
            foreach( $QuizzesResults as $QuizzesResultObj) {
                $attemptCorrect[$QuizzesResultObj->id] = $QuizzesResultObj->quizz_result_points->count();
            }
            $totalCorrected = array_sum($attemptCorrect);
            $completion_percentage = ($totalCorrected * 100) / $no_of_answers;
            $completion_percentage = ($completion_percentage > 0)? round($completion_percentage, 2) : 0;
            $completion_percentage = ($completion_percentage > 100)? 100 : $completion_percentage;
            $completion_percentage = ($completion_percentage < 0)? 0 : $completion_percentage;
            $quest_bar_label = $completion_percentage.'%';
        }

        if( $quest_method == 'correct_answers_in_row'){

            foreach( $QuizzesResults as $QuizzesResultObj) {
                $attemptInRowCorrect[$QuizzesResultObj->id] = $this->checkConsecutiveValues($QuizzesResultObj->quizz_result_questions_list->pluck('status')->toArray(), 3, 'correct');
            }
            $is_in_row = 1;
            $attemptedEligible = array_filter($attemptInRowCorrect, function($value) use ($is_in_row) {
                return $value >= $is_in_row;
            });
            $attempts_count = count($attemptedEligible);
            $attempts_count = ($attempts_count > $no_of_practices)? $no_of_practices : $attempts_count;
            $quest_bar_label = $attempts_count.' / '. $no_of_practices;
            $completion_percentage = ($attempts_count * 100) / $no_of_practices;
            $completion_percentage = ($completion_percentage > 0)? round($completion_percentage, 2) : 0;
        }


        $completion_percentage = ($completion_percentage > 100)? 100 : $completion_percentage;
        $completion_percentage = ($completion_percentage < 0)? 0 : $completion_percentage;



        $response = array(
            'is_completed' => ($completion_percentage == 100)? true : false,
            'no_of_practices' => $no_of_practices,
            'user_practices' => $QuizzesResults->count(),
            'quest_bar_label' => $quest_bar_label,
            'completion_percentage' => $completion_percentage,
            'questScore' => $questScore,
        );

        return $response;

    }

    public function checkConsecutiveValues($array, $numConsecutive, $checkValue) {
        $count = 0;

        foreach ($array as $value) {
            if ($value === $checkValue) {
                $count++;
                if ($count === $numConsecutive) {
                    return true;
                }
            } else {
                $count = 0;
            }
        }

        return false;
    }


}
