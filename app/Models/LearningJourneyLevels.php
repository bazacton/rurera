<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningJourneyLevels extends Model
{

    public $timestamps = false;

    protected $guarded = ['id'];
	
	
	public function learningJourneyItems()
    {
        return $this->hasMany('App\Models\LearningJourneyItems', 'learning_journey_level_id', 'id');
    }
	public function LearningJourneyObjects()
    {
        return $this->hasMany('App\Models\LearningJourneyObjects', 'learning_journey_level_id', 'id');
    }
	
	

}
