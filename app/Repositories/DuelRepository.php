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
            'duel_category_id' => $request->duel_category_id,
            'user_id'          => $request->user_id,
            'status'           => \APP\Models\Duel::RECRUIT,
            'number_of_games'   => $request->number_of_games,
            'max_member'       => $request->max_member,
            'room_id'          => $request->room_id,
            'watching_id'      => $request->watching_id,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);
        $duel->save();

        return $duel;
    }

    public function find($id){
        return Duel::find($id);
    }


}
