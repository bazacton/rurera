<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class QuizzesQuestion extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'quizzes_questions';
    public $timestamps = false;
    protected $guarded = ['id'];

    static $multiple = 'multiple';
    static $descriptive = 'descriptive';

    public $translatedAttributes = ['title' , 'correct'];

    public function getTitleAttribute()
    {
        return getTranslateAttributeValue($this , 'title');
    }

    public function getCorrectAttribute()
    {
        return getTranslateAttributeValue($this , 'correct');
    }


    public function quizzesQuestionsAnswers()
    {
        return $this->hasMany('App\Models\QuizzesQuestionsAnswer' , 'question_id' , 'id');
    }

    public function listQuestions()
    {
        return $this->hasMany('App\Models\Translation\QuizzesQuestionTranslation' , 'quizzes_question_id' , 'id');
    }

    public function teacher()
    {
        return $this->belongsTo('App\User' , 'creator_id' , 'id');
    }

    public function course()
    {
        return $this->belongsTo('App\Models\Webinar' , 'course_id' , 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category' , 'category_id' , 'id');
    }

    public function subChapter()
    {
        return $this->belongsTo('App\Models\SubChapters' , 'sub_chapter_id' , 'id');
    }
}
