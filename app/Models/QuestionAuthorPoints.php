<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionAuthorPoints extends Model
{

    public $timestamps = false;

    protected $guarded = ['id'];
    
    public function users()
    {
        return $this->belongsTo('App\User', 'author_id', 'id');
    }
    
    public function questions()
    {
        return $this->belongsTo('App\Models\QuizzesQuestion', 'question_id', 'id');
    }

}
