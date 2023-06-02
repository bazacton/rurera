<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizzesQuestionsList extends Model
{

    protected $table = 'quizzes_questions_list';
    public $timestamps = false;

    protected $fillable = [
        'quiz_id' , 'question_id' , 'status' , 'created_by' , 'created_at'
    ];

    public function QuestionData()
    {
        return $this->hasMany('App\Models\QuizzesQuestion' , 'id' , 'question_id');
    }

}
