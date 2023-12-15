<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAssignments extends Model
{

    protected $table = 'student_assignments';
    public $timestamps = false;

    protected $fillable = [
        'parent_id',
        'title',
        'assignment_type',
        'assignment_assign_type',
        'tables_no',
        'no_of_questions',
        'duration_type',
        'practice_time',
        'time_interval',
        'assignment_start_date',
        'assignment_end_date',
        'recurring_type',
        'class_ids',
        'target_percentage',
        'target_average_time',
        'assignment_reviewer',
        'assignment_review_due_date',
        'assignment_method',
        'no_of_attempts',
        'status',
        'created_by',
        'created_at',
        'updated_at',
    ];


}
