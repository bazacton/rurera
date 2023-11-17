<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAssignedTimestables extends Model
{

    protected $table = 'user_assigned_timestables';
    public $timestamps = false;

    protected $fillable = [
        'assignment_id',
        'user_id',
        'status',
        'created_at',
        'updated_at',
    ];


}
