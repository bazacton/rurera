<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyPlannerTopics extends Model
{

    protected $table = 'weekly_planner_topics';
    public $timestamps = false;

    protected $fillable = [
        'weekly_planner_id',
        'weekly_planner_item_id',
        'topic_id',
        'status',
        'sort_order',
        'created_at',
    ];

    public function WeeklyPlannerTopicData()
    {
        return $this->belongsTo('App\Models\SubChapters', 'topic_id', 'id');
    }

}
