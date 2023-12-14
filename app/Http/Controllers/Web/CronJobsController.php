<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\TimestablesAssignments;
use App\Models\TimestablesTournaments;
use App\Models\TimestablesTournamentsEvents;
use Illuminate\Support\Facades\DB;

class CronJobsController extends Controller
{

    public function create_tournaments_events()
    {
        $timestablesTournaments = TimestablesTournaments::where('status', 'active')->orderBy('id', 'asc')->get();


        $total_seconds = 86400; //24 Hours
        $total_seconds = 600; //10 Minutes
        if (!empty($timestablesTournaments)) {
            foreach ($timestablesTournaments as $tournamentObj) {
                $last_time = isset($tournamentObj->TournamentEvents->last()->active_at) ? $tournamentObj->TournamentEvents->last()->active_at : time();
                $recurring_time = $tournamentObj->recurring;
                $total_events = ($total_seconds / $recurring_time);
                $event_counter = 1;
                while ($event_counter <= $total_events) {

                    $last_time = $last_time + $recurring_time;
                    $TimestablesTournamentsEvents = TimestablesTournamentsEvents::create([
                        'tournament_id'  => $tournamentObj->id,
                        'total_time'     => $recurring_time,
                        'time_remaining' => $recurring_time,
                        'status'         => 'pending',
                        'created_at'     => time(),
                        'updated_at'     => time(),
                        'active_at'      => $last_time,
                    ]);

                    $event_counter++;
                }
            }
        }
        pre('done');

        pre($TimestablesTournaments);
    }


}
