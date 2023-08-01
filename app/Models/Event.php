<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    //定数の定義
    const CARD_TYPE_NORMAL = 0;
    const CARD_TYPE_PROXY = 1;

    const CARD_TYPE = [
        'normal'  => self::CARD_TYPE_NORMAL,
        'proxy' => self::CARD_TYPE_PROXY,
    ];

    const CARD_TYPE_STR = [
        self::CARD_TYPE_NORMAL  => 'なし',
        self::CARD_TYPE_PROXY  => 'あり',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function eventUsers()
    {
        return $this->hasMany('App\Models\EventUser', 'event_id', 'id');
    }

    public function eventDuels()
    {
        return $this->hasMany('App\Models\EventDuel', 'event_id', 'id');
    }

    public function game()
    {
        return $this->belongsTo('App\Models\Game', 'game_id', 'id');
    }
}
