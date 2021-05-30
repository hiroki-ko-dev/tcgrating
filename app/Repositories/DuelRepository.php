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
        $duel->fill([
            'game_id'          => $request->game_id,
            'duel_category_id' => $request->duel_category_id,
            'user_id'          => $request->user_id,
            'status'           => $request->status,
            'number_of_games'  => $request->number_of_games,
            'max_member'       => $request->max_member,
            'room_id'          => $request->room_id,
            'watching_id'      => $request->watching_id,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);
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
        $duel->room_id     = $request->room_id;
        $duel->watching_id = $request->watching_id;
        $duel->save();

        return $duel;
    }


    public function find($id){
        return Duel::find($id);
    }

    public function findWithUserAndEvent($id){
        return Duel::with('duelUser.user')
            ->with('eventDuel.event')
            ->find($id);
    }

}
