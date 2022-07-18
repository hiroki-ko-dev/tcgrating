<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    //定数の定義
    const SEND_STATUS_BEFORE_SENDING = 0;
    const SEND_STATUS_AFTER_SENDING = 1;
    const SEND_STATUS_BEFORE_RETURN = 2;
    const SEND_STATUS_AFTER_RETURN = 3;

    const SEND_STATUSES = [
        self::SEND_STATUS_BEFORE_SENDING  => '送付前',
        self::SEND_STATUS_AFTER_SENDING   => '送付後',
        self::SEND_STATUS_BEFORE_RETURN   => '返送前',
        self::SEND_STATUS_AFTER_RETURN    => '返送後',
    ];

    public function game(){
        return $this->belongsTo('App\Models\Game','game_id','id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function transactionItems(){
        return $this->hasMany('App\Models\TransactionItem','transaction_id','id');
    }

    public function transactionUsers(){
        return $this->hasMany('App\Models\TransactionUser','transaction_id','id');
    }
}
