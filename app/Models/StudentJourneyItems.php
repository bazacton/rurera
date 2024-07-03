<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentJourneyItems extends Model
{

    public $timestamps = false;

    protected $guarded = ['id'];
	
	
	public function learningJourneyItem()
    {
		return $this->hasOne('App\Models\LearningJourneyItems', 'id', 'learning_journey_item_id');
    }
	
	public function result()
    {
		return $this->belongsTo('App\Models\QuizzesResult', 'result_id', 'id');
    }

}
