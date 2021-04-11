<?php

namespace App\Repositories;
use App\Models\EventDuel;

use Carbon\Carbon;
use Illuminate\Http\Request;

class EventDuelRepository
{

    public function create($request)
    {
        $eventDuel = new EventDuel();
        $eventDuel->fill([
            'event_id'    => $request->event_id,
            'duel_id'     => $request->duel_id,
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);
        $eventDuel->save();

        return $eventDuel;
    }

    public function find($id){
        return EventDuel::find($id);
    }


}
