<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyPlannerItems extends Model
{

    protected $table = 'weekly_planner_items';
    public $timestamps = false;

    protected $fillable = [
        'weekly_planner_id',
        'week_no',
        'title',
        'status',
        'sort_order',
        'created_at',
    ];

    public function WeeklyPlannerTopics()
    {
        return $this->hasMany('App\Models\WeeklyPlannerTopics', 'weekly_planner_item_id', 'id')->orderBy('sort_order');
    }

}
