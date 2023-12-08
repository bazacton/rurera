<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimestablesEvents extends Model
{

    protected $table = 'timestables_events';
    public $timestamps = false;

    protected $fillable = [
        'parent_type',
        'parent_id',
        'status',
        'created_by',
        'created_at',
        'start_at',
        'expired_at',
        'updated_at',
    ];

    public function TimesTablesAssignmentData()
    {
        return $this->belongsTo('App\Models\TimestablesAssignments', 'parent_id', 'id');
    }


}
