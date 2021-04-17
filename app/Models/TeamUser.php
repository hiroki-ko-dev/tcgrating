<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamUser extends Model
{
    use HasFactory;

    //定数の定義
    const REQUEST        = 0;
    const APPROVAL       = 1;
    const REJECT         = 2;
    const MASTER         = 3;
    const STATUS = [
        'request'        => self::REQUEST,
        'approval'       => self::APPROVAL,
        'reject'         => self::REJECT,
        'master'         => self::MASTER,
    ];

    protected $guarded = [];

    public function team(){
        return $this->belongsTo('App\Models\Team','team_id','id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
