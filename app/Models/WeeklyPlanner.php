<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyPlanner extends Model
{

    protected $table = 'weekly_planner';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'key_stage',
        'subject_id',
        'status',
        'created_at',
    ];

    public function WeeklyPlannerItems()
    {
        return $this->hasMany('App\Models\WeeklyPlannerItems', 'weekly_planner_id', 'id');
    }

    public function WeeklyPlannerKeyStage()
    {
        return $this->belongsTo('App\Models\Category', 'key_stage', 'id');
    }

    public function WeeklyPlannerKeySubject()
    {
        return $this->belongsTo('App\Models\Webinar', 'subject_id', 'id');
    }

}
