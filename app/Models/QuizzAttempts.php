<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizzAttempts extends Model
{

    public $timestamps = false;

    protected $guarded = ['id'];

    public function quizzes_results()
    {
        return $this->belongsTo('App\Models\QuizzesResult' , 'quiz_result_id' , 'id');
    }

    public function quizz_result_questions()
    {
        return $this->belongsTo('App\Models\QuizzResultQuestions' , 'id' , 'quiz_attempt_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User' , 'user_id' , 'id');
    }

}
