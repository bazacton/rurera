<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimestablesTournaments extends Model
{

    protected $table = 'timestables_tournaments';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'sub_title',
        'bg_color',
        'recurring',
        'status',
        'created_at',
        'updated_at',
    ];

    public function TournamentEvents()
    {
        return $this->hasMany('App\Models\TimestablesTournamentsEvents', 'tournament_id', 'id');
    }

}
