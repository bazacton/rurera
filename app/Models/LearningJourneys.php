<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class LearningJourneys extends Model
{

    public $timestamps = false;

    protected $guarded = ['id'];
	
	
	public function learningJourneyLevels()
    {
        return $this->hasMany('App\Models\LearningJourneyLevels', 'learning_journey_id', 'id');
    }

}
