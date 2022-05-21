<?php

namespace App\Repositories;
use App\Models\GameUserCheck;

use Carbon\Carbon;
use Illuminate\Http\Request;

class GameUserCheckRepository
{
    public function create($request)
    {
        $gameUserCheck               = new GameUserCheck();
        $gameUserCheck->game_user_id = $request->game_user_id;
        $gameUserCheck->item_id = $request->item_id;
        $gameUserCheck->save();

        return $gameUserCheck;
    }

    /**
     * @param $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function composeSaveClause($request)
    {
        $query = GameUserCheck::query();
        if(isset($request->game_user_id)){
            $query->where('game_user_id',$request->game_user_id);
        }
        if(isset($request->item_id)) {
            $query->where('item_id', $request->item_id);
        }
        return $query;
    }

    /**
     * @param $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findAll($request)
    {
        $query = $this->composeSaveClause($request);
        return $query->get();
    }

    /**
     * @param $request
     * @return bool
     */
    public function delete($request)
    {
        $query = $this->composeSaveClause($request);
        return $query->delete();
    }


}
