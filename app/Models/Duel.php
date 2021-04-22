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
    const RECRUIT   = 0;
    const READY     = 1;
    const FINISH    = 2;
    const CANCEL    = 3;
    const INVALID   = 4;

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

        foreach($this->duelUser as $duelUser) {
            foreach ($duelUser->duelUserResult as $duelUserResult) {
                if ($duelUserResult->games_number > $games_number) {
                    $games_number = $duelUserResult->games_number;
                }
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
