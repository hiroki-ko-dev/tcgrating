<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $guarded = [];

    //定数の定義
    const STATUS_RECRUIT   = 0;
    const STATUS_FINISH    = 1;

    const STATUS = [
        'recruit'  => self::STATUS_RECRUIT,
        'finish'   => self::STATUS_FINISH,
    ];

    public function teamUser(){
        return $this->hasMany('App\Models\TeamUser','team_id','id');
    }
}
