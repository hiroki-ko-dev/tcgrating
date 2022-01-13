<?php

namespace App\Repositories;
use App\Models\Duel;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DuelRepository
{

    public function create($request)
    {
        $duel = new Duel();
        $duel->game_id          = $request->game_id;
        $duel->duel_category_id = $request->duel_category_id;
        $duel->user_id          = $request->user_id;
        $duel->status           = $request->status;
        if(isset($request->match_number)) {
            $duel->match_number = $request->match_number;
        }
        $duel->number_of_games  = $request->number_of_games;
        $duel->max_member       = $request->max_member;
        if(isset($request->room_id)) {
            $duel->room_id = $request->room_id;
        }
        if(isset($request->watching_id)) {
            $duel->watching_id = $request->watching_id;
        }
        if(isset($request->tool_id)) {
            $duel->tool_id = $request->tool_id;
        }
        if(isset($request->tool_code)) {
            $duel->tool_code = $request->tool_code;
        }
        $duel->save();

        return $duel;
    }

    /**
     *
     * @param $id
     * @param $next_status
     * @return Duel
     */
    public function updateStatus($id, $next_status)
    {
        $duel = Duel::find($id);
        $duel->status = $next_status;
        $duel->save();

        return $duel;
    }

    /**
     * 今のところroom_idとwatching_idの編集
     * @param $request
     * @return mixed
     */
    public function update($request)
    {
        $duel = Duel::find($request->id);
        if(isset($request->room_id)) {
            $duel->room_id = $request->room_id;
        }
        if(isset($request->watching_id)) {
            $duel->watching_id = $request->watching_id;
        }
        if(isset($request->tool_id)) {
            $duel->tool_id = $request->tool_id;
        }
        if(isset($request->tool_code)) {
            $duel->tool_code = $request->tool_code;
        }
        if(isset($request->number_of_games)) {
            $duel->number_of_games = $request->number_of_games;
        }
        if(isset($request->number_of_games)) {
            $duel->number_of_games = $request->number_of_games;
        }
        $duel->save();

        return $duel;
    }

    public function composeWhereClause($request)
    {
        $query = Duel::query();
        $query->where('match_number', $request->match_number);
        if (isset($request->event_id)) {
            $event_id = $request->event_id;
            $query->whereHas('eventDuel', function ($q) use ($event_id) {
                $q->where('event_id', $event_id);
            });
        }
        return $query;
    }


    public function find($id){
        return Duel::find($id);
    }



    public function findAll($request){
        return $this->composeWhereClause($request)->get();
    }

    public function findWithUserAndEvent($id){
        return Duel::with('duelUsers.user')
            ->with('eventDuel.event')
            ->find($id);
    }

}
