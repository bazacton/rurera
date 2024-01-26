<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShowdownLeaderboards extends Model
{

    public $timestamps = false;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\user', 'user_id', 'id');
    }

}
