<?php

namespace App\Models;

use Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duel extends Model
{
    use HasFactory;
    protected $guarded = [];

    //定数の定義
    const STATUS_RECRUIT   = 0;
    const STATUS_READY     = 1;
    const STATUS_FINISH    = 2;
    const STATUS_CANCEL    = 3;
    const STATUS_INVALID   = 4;

    const STATUS = [
        'recruit'  => self::STATUS_RECRUIT,
        'ready'    => self::STATUS_READY,
        'finish'   => self::STATUS_FINISH,
        'cancel'   => self::STATUS_CANCEL,
        'invalid'  => self::STATUS_INVALID,
    ];


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

        foreach($this->duelUsers as $duelUser) {
            foreach ($duelUser->duelUserResults as $duelUserResult) {
                if ($duelUserResult->games_number > $games_number) {
                    $games_number = $duelUserResult->games_number;
                }
            }
        }
        $games_number = $games_number + 1;

        return $games_number;
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function duelUsers(){
        return $this->hasMany('App\Models\DuelUser','duel_id','id');
    }

    public function eventDuel(){
        return $this->belongsTo('App\Models\EventDuel','id','duel_id');
    }

    public function game(){
        return $this->belongsTo('App\Models\Game','game_id','id');
    }
}
