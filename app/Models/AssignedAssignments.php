<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Quiz;

class AssignedAssignments extends Model
{

    protected $table = 'assigned_assignments';
    public $timestamps = false;

    protected $fillable = [
        'assignment_id',
        'user_ids',
        'assignment_deadline',
        'status',
        'created_by',
        'created_at',
    ];

    public function assignment()
    {
        return $this->hasOne('App\Models\Quiz', 'id', 'assignment_id');
    }

}
