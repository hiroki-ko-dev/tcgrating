<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $guarded = [];

    //定数の定義
    const RECRUIT   = 0;
    const FINISH    = 1;

    const STATUS = [
        'recruit'  => self::RECRUIT,
        'finish'   => self::FINISH,
    ];

    public function teamUser(){
        return $this->hasMany('App\Models\TeamUser','team_id','id');
    }
}
