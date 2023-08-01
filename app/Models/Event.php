<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

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
