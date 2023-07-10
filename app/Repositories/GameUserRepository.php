<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\GameUser;

class GameUserRepository
{
    public function create(array $data)
    {
        $gameUser = new GameUser();
        $gameUser->game_id = $data['game_id'];
        $gameUser->user_id = $data['user_id'];
        if (isset($data['discord_name'])) {
            $gameUser->discord_name = $data['discord_name'];
        }
        $gameUser->is_mail_send = true;
        $gameUser->rate = 0;
        $gameUser->save();

        return $gameUser;
    }

    public function update($data)
    {
        $gameUser = $this->find($data->id);
        if (isset($data->game_id)) {
            $gameUser->game_id = $data->game_id;
        }
        if (isset($data->user_id)) {
            $gameUser->user_id = $data->user_id;
        }
        if (isset($data->expo_push_token)) {
            $gameUser->expo_push_token = $data->expo_push_token;
        }
        if (isset($data->discord_name)) {
            $gameUser->discord_name = $data->discord_name;
        }
        if (isset($data->is_mail_send)) {
            $gameUser->is_mail_send = $data->is_mail_send;
        }
        if (isset($data->rate)) {
            $gameUser->rate = $data->rate;
        }
        if (isset($data->experience)) {
            $gameUser->experience = $data->experience;
        }
        if (isset($data->area)) {
            $gameUser->area = $data->area;
        }
        if (isset($data->preference)) {
            $gameUser->preference = $data->preference;
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
        $gameUser->save();

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

    public function composeWhereClause($data)
    {
        $query = GameUser::query();
        $query->where('game_id', $data->game_id);
        if (isset($data->user_id)) {
            $query->where('user_id', $data->user_id);
        }

        return $query;
    }

    /**
     * @param $data
     * @param $pagination
     * @return mixed
     */
    public function findAll($data) {
        $query = $this->composeWhereClause($data);
        return $query->get();
    }

    /**
     * @param $data
     * @param $pagination
     * @return mixed
     */
    public function findAllByPaginateOrderByRank($data, $pagination) {
        $query = $this->composeWhereClause($data);
        $query->orderBy('rate','desc');
        $query->orderBy('user_id','asc');


        return $query->paginate($pagination);
    }

    /**
     * @param $data
     * @param $paginate
     * @return mixed
     */
    public function findAllByRankForApi($data, $paginate) {

        return GameUser::select('id', 'game_id', 'user_id', 'discord_name', 'rate', 'created_at')
            ->where('game_id', $data->game_id)
            ->with('user:id,name,twitter_simple_image_url')
            ->orderBy('rate','desc')
            ->orderBy('user_id','asc')
            ->paginate($paginate);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function findByUserIdAndGameIdForApi($data)
    {
        return GameUser::select(
            'id', 'game_id', 'user_id', 'discord_name', 'rate', 'experience', 'area', 'preference', 'created_at'
        )
            ->where('user_id', $data->user_id)
            ->where('game_id', $data->game_id)
            ->with('user:id,name,gender,twitter_image_url,twitter_simple_image_url,body')
            ->with('gameUserChecks:id,game_user_id,item_id')
            ->first();
    }

}
