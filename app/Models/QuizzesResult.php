<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizzesResult extends Model
{
    static $passed = 'passed';
    static $failed = 'failed';
    static $waiting = 'waiting';

    public $timestamps = false;

    protected $guarded = ['id'];

    public function quiz()
    {
        return $this->belongsTo('App\Models\Quiz', 'quiz_id', 'id');
    }

    public function parentQuiz()
    {
        return $this->belongsTo('App\Models\Quiz', 'parent_type_id', 'id');
    }
	
	public function sameParent()
    {
        return $this->belongsTo('App\Models\QuizzesResult', 'parent_type_id', 'parent_type_id');
    }

    public function assignment()
    {
        return $this->belongsTo('App\Models\UserAssignedTopics', 'parent_type_id', 'id');
    }

    public function quizz_result_questions()
    {
        return $this->belongsTo('App\Models\QuizzResultQuestions', 'id', 'quiz_result_id');
    }

    public function quizz_result_questions_list()
    {
        return $this->hasMany('App\Models\QuizzResultQuestions', 'quiz_result_id', 'id');
    }

    public function quizz_result_points()
    {
        return $this->hasMany('App\Models\QuizzResultQuestions', 'quiz_result_id', 'id')->where('status', '=', 'correct');
    }

    public function quizz_result_timestables_grouped()
    {
        return $this->hasMany('App\Models\QuizzResultQuestions', 'quiz_result_id', 'id');
    }

    public function quizz_result_percentage()
    {
        $totalQuestions = $this->quizz_result_questions_list()->count();
        $correctPoints = $this->quizz_result_points()->count();

        if ($totalQuestions > 0) {
            $percentage = ($correctPoints / $totalQuestions) * 100;
        } else {
            $percentage = 0; // Handle division by zero
        }

        return $percentage;
    }

    public function quizz_result_reward_points()
    {
        return $this->belongsTo('App\Models\QuizzResultQuestions', 'id', 'quiz_result_id')->where('status', '=', 'correct');
    }

    public function attempts()
    {
        return $this->hasMany('App\Models\QuizzAttempts', 'quiz_result_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function timeConsumed()
    {
        return $this->hasMany('App\Models\QuizzResultQuestions', 'quiz_result_id', 'id');
    }


    public function getQuestions()
    {
        $quiz = $this->quiz;

        if ($quiz->display_limited_questions and !empty($quiz->display_number_of_questions)) {

            $results = json_decode($this->results, true);
            $quizQuestionIds = [];

            if (!empty($results)) {
                foreach ($results as $id => $v) {
                    if (is_numeric($id)) {
                        $quizQuestionIds[] = $id;
                    }
                }
            }

            $quizQuestions = $quiz->quizQuestions()->whereIn('id', $quizQuestionIds)->get();
        } else {
            $quizQuestions = $quiz->quizQuestions;
        }

        return $quizQuestions;
    }
}
