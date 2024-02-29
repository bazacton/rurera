<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\Models\DailyQuests;
use App\Models\QuizzesResult;
use App\Models\RewardAccounting;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use thiagoalessio\TesseractOCR\TesseractOCR;

class DailyQuestsController extends Controller
{

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

        $quests = DailyQuests::where('quest_topic_type', $QuizzesResult->quiz_result_type)
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



        $QuizzesResults = QuizzesResult::where('user_id', $user->id)
        ->where('quiz_result_type', $questObj->quest_topic_type)
        ->where('status', '!=', 'waiting');
        if( $questObj->quest_topic_type == 'timestables'){
            $QuizzesResults->where('attempt_mode', $questObj->timestables_mode);
        }

        if( $recurring_type == 'Daily'){
            $QuizzesResults->where('created_at' ,'>=', strtotime(date('Y-m-d 00:00:00')));
            $QuizzesResults->where('created_at' ,'<=', strtotime(date('Y-m-d 23:59:59')));
        }

        $QuizzesResults = $QuizzesResults->get();
        if( $quest_method == 'lessons_score'){
            $QuizzesResults = $QuizzesResults->filter(function ($result) use ($lessons_score) {
                return $result->quizz_result_percentage() >= $lessons_score;
            });
        }

        if( $quest_method == 'correct_answers'){
            $QuizzesResults = $QuizzesResults->filter(function ($result) use ($no_of_answers) {
                return $result->quizz_result_points->count() >= $no_of_answers;
            });
        }
        //$QuizzesResults = $QuizzesResults->get();

        $completion_percentage = 0;
        if( $QuizzesResults->count() >  0){
            $completion_percentage = ($QuizzesResults->count() * 100) / $no_of_practices;
        }
        $questScore = $questObj->no_of_coins;
        if ($questObj->coins_type == 'percentage') {
            $questScore = $questObj->coins_percentage.'x';
        }

        $quest_bar_label = $completion_percentage.'%';
        if( $quest_method == 'lessons_score'){
            $quest_bar_label = $QuizzesResults->count().' / '.$no_of_practices;
        }

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


}
