<?php

namespace App\Repositories;
use App\Models\DuelUserResult;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DuelUserResultRepository
{

    public function create($request)
    {
        $duelUserResult = new DuelUserResult();
        $duelUserResult->fill([
            'duel_user_id' => $request->duel_user_id,
            'games_number' => $request->games_number,
            'result'       => $request->result,
            'ranking'      => $request->ranking,
            'rating'       => $request->rating,
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now()
        ]);
        $duelUserResult->save();

        return $duelUserResult;
    }

    public function find($id){
        return DuelUserResult::find($id);
    }

    /**
     * 決闘結果を作成していいか確認時に使用
     * @param $duel_user_id
     * @return mixed
     */
    public function findAllByDuelUserId($duel_user_id){
        return DuelUserResult::where('duel_user_id',$duel_user_id)->get();
    }



}
