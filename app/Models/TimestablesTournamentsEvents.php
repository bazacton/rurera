<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimestablesTournamentsEvents extends Model
{

    protected $table = 'timestables_tournaments_events';
    public $timestamps = false;

    protected $fillable = [
        'tournament_id',
        'total_time',
        'time_remaining',
        'status',
        'created_at',
        'updated_at',
        'active_at',
    ];

    public function tournament()
    {
        return $this->belongsTo('App\Models\TimestablesTournaments', 'tournament_id', 'id');
    }

}
