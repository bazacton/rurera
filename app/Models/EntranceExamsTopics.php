<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntranceExamsTopics extends Model
{

    protected $guarded = ['id'];

    public function main_subtopics()
    {
        return $this->hasMany('App\Models\EntranceExamsTopics', 'parent_id', 'id');
    }

    public function topics()
    {
        return $this->hasMany('App\Models\EntranceExamsTopics', 'parent_id', 'id');
    }

    public function subtopics()
    {
        return $this->hasMany('App\Models\EntranceExamsTopics', 'parent_id', 'id');
    }




}
