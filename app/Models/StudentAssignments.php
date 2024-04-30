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
        'description',
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
        'topic_ids',
    ];

    public function students()
    {
        return $this->hasMany('App\Models\UserAssignedTopics', 'student_assignment_id', 'id');
    }

    static function RunCron(){
        $StudentAssignments = StudentAssignments::query()->where('status', 'active')->get();

        if( $StudentAssignments->count() > 0){
            foreach( $StudentAssignments as $StudentAssignmentObj){
                $status = 'active';
                $non_completed_count = $StudentAssignmentObj->students->where('status', '!=', 'completed')->count();
                $status = ($non_completed_count == 0)? 'completed' : $status;

                if( $StudentAssignmentObj->assignment_end_date < time()){
                    $status = 'expired';
                }

                if( $status != 'active'){
                    $StudentAssignmentObj->update([
                        'status' => $status,
                        'updated_at' => time(),
                    ]);
                }
            }
        }
        pre('test');
    }


}
