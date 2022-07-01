<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    use HasFactory;
    protected $guarded = [];

    //定数の定義
    const TYPE_REQUEST = 0;
    const TYPE_REPORT  = 1;

    const TYPE = [
        self::TYPE_REQUEST  => '要望',
        self::TYPE_REPORT   => '通報',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function game(){
        return $this->belongsTo('App\Models\Game','game_id','id');
    }

}
