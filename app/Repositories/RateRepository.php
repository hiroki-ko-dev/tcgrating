<?php

namespace App\Repositories;
use App\Models\User;
use App\Models\Rate;

use Carbon\Carbon;
use Illuminate\Http\Request;

class RateRepository
{

    /**
     * @param $game_id
     * @param $user_id
     * @param $add_rate
     * @return mixed
     */
    public function updateRate($game_id, $user_id, $add_rate)
    {
        // rateレコードがすでに存在するなら抽出
        $rate = Rate::where('game_id', $game_id)
                    ->where('user_id', $user_id)
                    ->first();

        // 存在しないならここで新規作成
        if(is_null($rate)){
            $rate = new Rate();
            $rate->game_id = $game_id;
            $rate->user_id = $user_id;
        }

        $rate->rate = $rate->rate + $add_rate ;
        $rate->save() ;

        return $rate ;
    }

    public function composeWhereClause($request)
    {
        $query = Rate::query();
        $query->where('game_id', $request->game_id);
        return $query;
    }

    /**
     * @param $request
     * @param $pagination
     * @return mixed
     */
    public function findAllByPaginateOrderByRank($request, $pagination){
        $query = $this->composeWhereClause($request);
        $query->orderBy('rate','desc');
        return $query->paginate($pagination);
    }

    public function findAllBySendMail($id){
        return User::whereNotIn('id',[$id])->where('email', 'not like', '%test@test.jp%')->get();
    }

}
