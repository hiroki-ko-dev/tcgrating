<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamUser extends Model
{
    use HasFactory;

    //定数の定義
    const NOT_SET        = 0;
    const APPROVAL       = 1;
    const REJECT         = 2;
    const STATUS = [
        'not_set'        => self::NOT_SET,
        'approval'       => self::APPROVAL,
        'reject'         => self::REJECT,
    ];

    protected $guarded = [];

    public function team(){
        return $this->belongsTo('App\Models\Team','team_id','id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
