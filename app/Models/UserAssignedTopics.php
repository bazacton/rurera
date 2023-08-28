<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAssignedTopics extends Model
{

    protected $table = 'user_assigned_topics';
    public $timestamps = false;

    protected $fillable = [
        'assigned_to_id',
        'parent_id',
        'topic_id',
        'topic_type',
        'status',
        'created_at'
    ];

}
