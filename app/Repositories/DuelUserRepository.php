<?php

namespace App\Repositories;
use App\Models\DuelUser;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DuelUserRepository
{

    public function create($request)
    {
        $duelUser = new DuelUser();
        $duelUser->fill([
            'duel_id'           => $request->duel_id,
            'user_id'           => $request->user_id,
            'status'            => $request->status,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now()
        ]);
        $duelUser->save();

        return $duelUser;
    }

    public function find($id){
        return DuelUser::find($id);
    }


}
