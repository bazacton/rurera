<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Quiz;

class UserAssignedTopics extends Model
{

    protected $table = 'user_assigned_topics';
    public $timestamps = false;

    protected $fillable = [
        'assigned_to_id',
        'parent_id',
        'topic_id',
        'topic_type',
        'status',
        'created_at',
        'start_at',
        'deadline_date'
    ];

    public function quizData()
    {
        //return $this->hasOne('App\Models\Quiz', 'id', 'topic_id');
        return $this->belongsTo('App\Models\Quiz', 'topic_id', 'id');
    }

    public function practiceData_bk()
    {
        //return $this->hasOne('App\Models\Quiz', 'id', 'topic_id');
        return $this->belongsTo('App\Models\WebinarChapterItem', 'topic_id', 'parent_id')->where('type', 'quiz');
    }


    public function practiceData()
    {
        return $this->belongsTo('App\Models\SubChapters', 'topic_id', 'id');
    }

    public function TimesTablesEventData()
    {
        return $this->belongsTo('App\Models\TimestablesEvents', 'topic_id', 'id');
    }

}
