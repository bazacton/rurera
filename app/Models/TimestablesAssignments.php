<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimestablesAssignments extends Model
{

    protected $table = 'assignments';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'assignment_type',
        'tables_no',
        'no_of_questions',
        'duration_type',
        'practice_time',
        'time_interval',
        'assignment_start_date',
        'assignment_end_date',
        'recurring_type',
        'class_ids',
        'status',
        'created_by',
        'created_at',
    ];


}
