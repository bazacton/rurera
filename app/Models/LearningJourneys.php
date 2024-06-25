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
	
	public function learningJourneyStages()
    {
        return $this->hasMany('App\Models\learningJourneyItems', 'learning_journey_id', 'id');
    }
	
	public function subject()
    {
        return $this->belongsTo('App\Models\Webinar', 'subject_id', 'id');
    }

}
