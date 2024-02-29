<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyQuests extends Model
{

    public $timestamps = false;
    protected $guarded = ['id'];


    public function students()
    {
        return $this->hasMany('App\Models\UserAssignedTopics', 'student_assignment_id', 'id');
    }

    public function QuestRewardsCount()
    {
        return $this->hasMany('App\Models\RewardAccounting', 'parent_id', 'id')->where('parent_type', '=', 'quest');
    }
}
