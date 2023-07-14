<?php

namespace App\Repositories;

use App\Models\GameUser;

class GameUserRepository
{
    public function create(array $attrs)
    {
        $gameUser = new GameUser();
        $gameUser->game_id = $attrs['game_id'];
        $gameUser->user_id = $attrs['user_id'];
        if (isset($attrs['discord_name'])) {
            $gameUser->discord_name = $attrs['discord_name'];
        }
        $gameUser->is_mail_send = true;
        $gameUser->rate = 0;
        $gameUser->save();

        return $gameUser;
    }

    public function update(int $id, array $attrs): GameUser
    {
        $gameUser = $this->find($id);
        if (isset($attrs['game_id'])) {
            $gameUser->game_id = $attrs['game_id'];
        }
        if (isset($attrs['user_id'])) {
            $gameUser->user_id = $attrs['user_id'];
        }
        if (isset($attrs['expo_push_token'])) {
            $gameUser->expo_push_token = $attrs['expo_push_token'];
        }
        if (isset($attrs['discord_name'])) {
            $gameUser->discord_name = $attrs['discord_name'];
        }
        if (isset($attrs['is_mail_send'])) {
            $gameUser->is_mail_send = $attrs['is_mail_send'];
        }
        if (isset($attrs['rate'])) {
            $gameUser->rate = $attrs['rate'];
        }
        if (isset($attrs['experience'])) {
            $gameUser->experience = $attrs['experience'];
        }
        if (isset($attrs['area'])) {
            $gameUser->area = $attrs['area'];
        }
        if (isset($attrs['preference'])) {
            $gameUser->preference = $attrs['preference'];
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

    public function composeWhereClause($attrs)
    {
        $query = GameUser::query();
        $query->where('game_id', $attrs->game_id);
        if (isset($attrs->user_id)) {
            $query->where('user_id', $attrs->user_id);
        }

        return $query;
    }

    /**
     * @param $attrs
     * @param $pagination
     * @return mixed
     */
    public function findAll($attrs) {
        $query = $this->composeWhereClause($attrs);
        return $query->get();
    }

    /**
     * @param $attrs
     * @param $pagination
     * @return mixed
     */
    public function findAllByPaginateOrderByRank($attrs, $pagination) {
        $query = $this->composeWhereClause($attrs);
        $query->orderBy('rate','desc');
        $query->orderBy('user_id','asc');


        return $query->paginate($pagination);
    }

    /**
     * @param $attrs
     * @param $paginate
     * @return mixed
     */
    public function findAllByRankForApi($attrs, $paginate) {

        return GameUser::select('id', 'game_id', 'user_id', 'discord_name', 'rate', 'created_at')
            ->where('game_id', $attrs->game_id)
            ->with('user:id,name,twitter_simple_image_url')
            ->orderBy('rate','desc')
            ->orderBy('user_id','asc')
            ->paginate($paginate);
    }
}
