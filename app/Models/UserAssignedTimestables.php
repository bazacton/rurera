<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAssignedTimestables extends Model
{

    protected $table = 'user_assigned_timestables';
    public $timestamps = false;

    protected $fillable = [
        'assignment_id',
        'assignment_event_id',
        'user_id',
        'status',
        'created_at',
        'updated_at',
    ];

    public function assignments()
    {
        return $this->belongsTo('App\Models\TimestablesAssignments', 'assignment_id', 'id');
    }

    public function timestables_events()
    {
        return $this->belongsTo('App\Models\TimestablesEvents', 'assignment_event_id', 'id');
    }

    public function conducted_results()
    {
        return $this->hasOne('App\Models\QuizzesResult', 'parent_type_id', 'id');
    }


}
