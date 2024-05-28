<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentLinkRequests extends Model
{

    public $timestamps = false;

    protected $guarded = ['id'];
	
    public function student()
    {
        return $this->hasOne('App\User', 'id', 'student_id');
    }
	
    public function requestBy()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

}
