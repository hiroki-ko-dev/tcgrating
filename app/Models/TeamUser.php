<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamUser extends Model
{
    use HasFactory;

    //定数の定義
    const STATUS_REQUEST        = 0;
    const STATUS_APPROVAL       = 1;
    const STATUS_REJECT         = 2;
    const STATUS_MASTER         = 3;
    const STATUS = [
        'request'        => self::STATUS_REQUEST,
        'approval'       => self::STATUS_APPROVAL,
        'reject'         => self::STATUS_REJECT,
        'master'         => self::STATUS_MASTER,
    ];

    protected $guarded = [];

    public function team(){
        return $this->belongsTo('App\Models\Team','team_id','id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
