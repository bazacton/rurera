<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserParentLink extends Model
{

    public $timestamps = false;
    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function studentParent()
    {
        return $this->belongsTo('App\User', 'parent_id', 'id');
    }
}
