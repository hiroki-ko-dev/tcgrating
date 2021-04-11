<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $guarded = [];

    //定数の定義
    const RECRUIT   = 1;
    const READY     = 2;
    const FINISH    = 3;

    const STATUS = [
        'recruit'  => self::RECRUIT,
        'ready'    => self::READY,
        'finish'   => self::FINISH,
    ];

    public function eventUser(){
        return $this->hasMany('App\Models\EventUser','event_id','id');
    }
}
