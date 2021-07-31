<?php

namespace App\Repositories;
use App\Models\User;
use App\Models\GameUser;

use Carbon\Carbon;
use Illuminate\Http\Request;

class GameUserRepository
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
        $gameUser = GameUser::where('game_id', $game_id)
                    ->where('user_id', $user_id)
                    ->first();

        // 存在しないならここで新規作成
        if(is_null($gameUser)){
            $gameUser = new GameUser();
            $gameUser->game_id = $game_id;
            $gameUser->user_id = $user_id;
        }

        $gameUser->rate = $gameUser->rate + $add_rate ;
        $gameUser->save() ;

        return $gameUser ;
    }

    public function composeWhereClause($request)
    {
        $query = GameUser::query();
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
