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
    const RECRUIT   = 1;
    const READY     = 2;
    const FINISH    = 3;
    const CANCEL    = 4;
    const INVALID   = 5;

    const STATUS = [
        'recruit'  => self::RECRUIT,
        'ready'    => self::READY,
        'finish'   => self::FINISH,
        'cancel'   => self::CANCEL,
        'invalid'  => self::INVALID,
    ];

    /**
     * 現在が何試合目かをduelにカラムとして持たせる
     * @return int
     */
    public function getGamesNumberAttribute()
    {
        $games_number = 0;

        foreach($this->duelUser->where('user_id',Auth::id())->first()->duelUserResult as $duelUserResult) {
            if ($duelUserResult->games_number > $games_number) {
                $games_number = $duelUserResult->games_number;
            }
        }
        $games_number = $games_number + 1;

        return $games_number;
    }

    public function duelUser(){
        return $this->hasMany('App\Models\duelUser','duel_id','id');
    }

    public function eventDuel(){
        return $this->belongsTo('App\Models\EventDuel','id','duel_id');
    }
}
