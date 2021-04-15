<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuelUser extends Model
{
    use HasFactory;
    protected $guarded = [];

    //定数の定義
    const REQUEST   = 1;
    const APPROVAL  = 2;
    const REJECT    = 3;
    const MASTER    = 4;

    const STATUS = [
        'request'  => self::REQUEST,
        'approval' => self::APPROVAL,
        'reject'   => self::REJECT,
        'master'   => self::MASTER,
    ];

    public function duel(){
        return $this->belongsTo('App\Models\Duel','duel_id','id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function duelUserResult(){
        return $this->hasMany('App\Models\DuelUserResult','duel_user_id','id');
    }
}
