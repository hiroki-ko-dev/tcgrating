<?php

namespace App\Repositories;
use App\Models\DuelResult;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DuelResultRepository
{

    public function create($request)
    {
        $duelResult = new DuelResult();
        $duelResult->fill([
            'duel_id'           => $request->duel_id,
            'user_id'           => $request->user_id,
            'status'            => DuelUser::MASTER,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now()
        ]);
        $duelResult->save();

        return $duelResult;
    }

    public function find($id){
        return DuelResult::find($id);
    }


}
