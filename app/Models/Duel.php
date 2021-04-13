<?php

namespace App\Models;

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

    const STATUS = [
        'recruit'  => self::RECRUIT,
        'ready'    => self::READY,
        'finish'   => self::FINISH,
        'cancel'   => self::CANCEL,
    ];

    public function getGamesNumberAttribute()
    {
        $games_number = 0;
        foreach($this->duelUser as $duelUser){
            foreach($duelUser->duelResult as $duelResult) {
                if ($duelResult > $games_number) {
                    $games_number = $duelResult;
                }
            }
        }
        $games_number = $games_number + 1;

        return $games_number;
    }

    public function duelUser(){
        return $this->hasMany('App\Models\duelUser','duel_id','id');
    }

    public function duelResult(){
        return $this->hasMany('App\Models\duelResult','duel_id','id');
    }
}
