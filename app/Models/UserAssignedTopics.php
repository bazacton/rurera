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
        'assigned_by_id',
        'student_assignment_id',
        'topic_id',
        'status',
        'created_at',
        'start_at',
        'deadline_date',
        'updated_at'
    ];

    public function quizData()
    {
        //return $this->hasOne('App\Models\Quiz', 'id', 'topic_id');
        return $this->belongsTo('App\Models\Quiz', 'topic_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'assigned_to_id', 'id');
    }

    public function practiceData()
    {
        return $this->belongsTo('App\Models\SubChapters', 'topic_id', 'id');
    }

    public function StudentAssignmentData()
    {
        return $this->belongsTo('App\Models\StudentAssignments', 'student_assignment_id', 'id');
    }

    public function AssignmentResults()
    {
        return $this->hasMany('App\Models\QuizzesResult', 'parent_type_id', 'id')->whereIN('quiz_result_type', array('timestables_assignment'))->where('status', '!=', 'waiting');
    }

    public function TimesTablesEventData()
    {
        return $this->belongsTo('App\Models\TimestablesEvents', 'topic_id', 'id');
    }

}
