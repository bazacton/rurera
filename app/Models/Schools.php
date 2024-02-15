<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schools extends Model
{

    public $timestamps = false;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\user', 'created_by', 'id');
    }

}
