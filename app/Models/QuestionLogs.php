<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionLogs extends Model
{

    public $timestamps = false;

    protected $guarded = ['id'];
    
    public function user()
    {
        return $this->belongsTo('App\User', 'action_by', 'id');
    }

}
