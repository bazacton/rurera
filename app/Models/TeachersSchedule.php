<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeachersSchedule extends Model
{

    protected $table = 'teachers_schedule';
    public $timestamps = false;
    protected $fillable = [
        'teacher_id',
        'schedule_data',
        'status',
        'created_by',
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

}
