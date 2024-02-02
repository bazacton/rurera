<?php

namespace App\Models;

use App\Http\Controllers\Web\QuestionsAttemptController;
use App\Models\Traits\SequenceContent;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Quiz extends Model implements TranslatableContract
{
    use Translatable;
    use SequenceContent;
    use Sluggable;

    const ACTIVE = 'active';
    const INACTIVE = 'inactive';

    public $timestamps = false;
    protected $table = 'quizzes';
    protected $guarded = ['id'];

    public $translatedAttributes = ['title'];

    public function getTitleAttribute()
    {
        return getTranslateAttributeValue($this , 'title');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return ['quiz_slug' => ['source' => 'title']];
    }

    public static function makeSlug($title, $id = 0)
    {
        $slug = strtolower(SlugService::createSlug(self::class, 'quiz_slug', $title));
        return $slug;
    }
    public static function makeSlug_bk($title, $id = 0)
    {
        $slug = strtolower(SlugService::createSlug(self::class, 'quiz_slug', $title));
        $count = Quiz::where('quiz_slug', $slug);
        if( $id > 0){
            $count = $count->where('id', '!=', $id ?? 0);
        }
        $count = $count->count();
        if ($count > 0) {
            $slug = $slug . '-' . uniqid();
        }
        return $slug;
    }

    public function quizQuestionsList()
    {

        return $this->hasMany('App\Models\QuizzesQuestionsList' , 'quiz_id' , 'id')->where('status', 'active')->orderBy('sort_order', 'ASC');
    }

    public function quizYear()
    {
        return $this->belongsTo('App\Models\Category' , 'year_id' , 'id');
    }

    public function quizQuestions()
    {
        return $this->hasMany('App\Models\QuizzesQuestion' , 'quiz_id' , 'id');
    }

    public function quizResults()
    {
        return $this->hasMany('App\Models\QuizzesResult' , 'quiz_id' , 'id');
    }

    public function parentResults()
    {
        return $this->hasMany('App\Models\QuizzesResult' , 'parent_type_id' , 'id');
    }

    public function parentResultsQuestions()
    {
        return $this->hasMany('App\Models\QuizzResultQuestions', 'parent_type_id', 'id')
            ->where('status', 'correct');
    }

    public function creator()
    {
        return $this->belongsTo('App\User' , 'creator_id' , 'id');
    }

    public function webinar()
    {
        return $this->belongsTo('App\Models\Webinar' , 'webinar_id' , 'id');
    }

    public function teacher()
    {
        return $this->belongsTo('App\User' , 'creator_id' , 'id');
    }

    public function vocabulary_achieved_levels()
    {
        return $this->hasOne('App\Models\UsersAchievedLevels', 'parent_id', 'id')->where('parent_type', 'vocabulary');
    }


    public function certificates()
    {
        return $this->hasMany('App\Models\Certificate' , 'quiz_id' , 'id');
    }

    public function chapter()
    {
        return $this->belongsTo('App\Models\WebinarChapter' , 'chapter_id' , 'id');
    }

    public function topic()
    {
        return $this->belongsTo('App\Models\WebinarChapter' , 'topic_id' , 'id');
    }


    public function increaseTotalMark($grade)
    {
        $total_mark = $this->total_mark + $grade;
        return $this->update(['total_mark' => $total_mark]);
    }

    public function decreaseTotalMark($grade)
    {
        $total_mark = $this->total_mark - $grade;
        return $this->update(['total_mark' => $total_mark]);
    }

    public function getUserCertificate($user , $quiz_result)
    {
        if (!empty($user) and !empty($quiz_result)) {
            return Certificate::where('quiz_id' , $this->id)->where('student_id' , $user->id)->where('quiz_result_id' , $quiz_result->id)->first();
        }

        return null;
    }

    static function getQuizPercentage($SubChapterID, $all_data = false)
    {
        $user = auth()->user();
        $chapterItem = WebinarChapterItem::where('type', 'quiz')
            ->where('parent_id', $SubChapterID)
            ->first();

        $id = isset($chapterItem->item_id) ? $chapterItem->item_id : 0;

        $quizObj = Quiz::find($id);

        $quizResults = isset( $quizObj->parentResults )? $quizObj->parentResults : array();
        $quiz_percentage = 0;
        $total_questions_count = $total_correct_questions = 0;

        if( !empty( $quizResults ) ){
            foreach( $quizResults as $resultObj){
                $total_questions = count(json_decode($resultObj->questions_list));
                $correct_questions = $resultObj->quizz_result_questions_list->where('status','correct')->where('user_id',$user->id)->count();
                $total_questions_count += $total_questions;
                $total_correct_questions += $correct_questions;
                $percentage = ($correct_questions * 100)/$total_questions;
                $quiz_percentage = ($quiz_percentage <= $percentage)? round($percentage) : $quiz_percentage;
            }
        }
        if( $all_data == true){
            return array(
                'total_questions_count' => $total_questions_count,
                'total_correct_questions' => $total_correct_questions,
            );
        }else {
            return $quiz_percentage;
        }
    }
}
