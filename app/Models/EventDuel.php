<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventDuel extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function event(){
        return $this->belongsTo('App\Models\Event','event_id','id');
    }

    public function duel(){
        return $this->belongsTo('App\Models\Duel','duel_id','id');
    }
}
