<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
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

    public function eventUser(){
        return $this->hasMany('App\Models\EventUser','event_id','id');
    }

    public function eventDuel(){
        return $this->hasMany('App\Models\EventDuel','event_id','id');
    }
}
