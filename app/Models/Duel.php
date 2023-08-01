<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duel extends Model
{
    use HasFactory;

    protected $guarded = [];

    //定数の定義
    const TOOL_TCG_DISCORD = 1;
    const TOOL = [
        'tcg_discord'  => self::TOOL_TCG_DISCORD,
    ];

    /**
     * 現在が何試合目かをduelにカラムとして持たせる
     * @return int
     */
    public function getGamesNumberAttribute()
    {
        $games_number = 0;

        foreach ($this->duelUsers as $duelUser) {
            foreach ($duelUser->duelUserResults as $duelUserResult) {
                if ($duelUserResult->games_number > $games_number) {
                    $games_number = $duelUserResult->games_number;
                }
            }
        }
        $games_number = $games_number + 1;

        return $games_number;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function duelUsers()
    {
        return $this->hasMany('App\Models\DuelUser', 'duel_id', 'id');
    }

    public function eventDuel()
    {
        return $this->belongsTo('App\Models\EventDuel', 'id', 'duel_id');
    }

    public function game()
    {
        return $this->belongsTo('App\Models\Game', 'game_id', 'id');
    }
}
