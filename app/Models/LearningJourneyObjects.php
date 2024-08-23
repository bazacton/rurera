<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningJourneyObjects extends Model
{

    public $timestamps = false;

    protected $guarded = ['id'];
	
	

    public function topic()
    {
        return $this->hasOne('App\Models\SubChapters', 'id', 'item_value');
    }

}
