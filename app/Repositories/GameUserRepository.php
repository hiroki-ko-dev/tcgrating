<?php

namespace App\Repositories;
use App\Models\User;
use App\Models\GameUser;

use Carbon\Carbon;
use Illuminate\Http\Request;

class GameUserRepository
{

    public function create($request)
    {
        $gameUser               = new GameUser();
        $gameUser->game_id      = $request->game_id;
        $gameUser->user_id      = $request->user_id;
        if(isset($request->discord_name)){
            $gameUser->discord_name = $request->discord_name;
        }
        $gameUser->is_mail_send = true;
        $gameUser->rate    = 0;
        $gameUser->save();

        return $gameUser;
    }

    public function update($request)
    {
        $gameUser = $this->find($request->id);
        if(isset($request->game_id)){
            $gameUser->game_id      = $request->game_id;
        }
        if(isset($request->user_id)){
            $gameUser->user_id      = $request->user_id;
        }
        if(isset($request->discord_name)){
            $gameUser->discord_name = $request->discord_name;
        }
        if(isset($request->is_mail_send)) {
            $gameUser->is_mail_send = $request->is_mail_send;
        }
        if(isset($gameUser->rate)) {
            $gameUser->rate         = $request->rate;
        }
        $gameUser->save();

        return $gameUser;
    }


    /**
     * @param $id
     * @param $user_id
     * @param $add_rate
     * @return mixed
     */
    public function updateRate($id, $add_rate)
    {
        // rateレコードがすでに存在するなら抽出
        $gameUser = $this->find($id);

        $gameUser->rate = $gameUser->rate + $add_rate ;
        $gameUser->save() ;

        return $gameUser ;
    }

    public function find($id)
    {
        return GameUser::find($id);
    }

    public function findByGameIdAndUserId($game_id, $user_id)
    {
        return GameUser::where('game_id', $game_id)
                        ->where('user_id', $user_id)
                        ->first();
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
        $query->orderBy('user_id','asc');


        return $query->paginate($pagination);
    }

    /**
     * @param $request
     * @param $paginate
     * @return mixed
     */
    public function findAllByRankForApi($request, $paginate){

        return GameUser::select('id', 'game_id', 'user_id', 'discord_name', 'rate', 'created_at')
            ->where('game_id', $request->game_id)
            ->with('user:id,name')
            ->orderBy('rate','desc')
            ->orderBy('user_id','asc')
            ->paginate($paginate);
    }

}
