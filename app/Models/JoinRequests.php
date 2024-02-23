<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoinRequests extends Model
{

    public $timestamps = false;
    protected $guarded = ['id'];

    public function student()
    {
        return $this->belongsTo('App\user', 'user_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo('App\Models\Classes', 'section_id', 'id');
    }

}
