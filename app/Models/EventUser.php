<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getEventRateAttribute()
    {
        if (in_array($this->event->now_match_number, [0,1])) {
            return 0;
        } else {
            $duel_user_ids = DuelUser::whereIn('duel_id', $this->event->eventDuels->pluck('duel_id'))
                                ->where('user_id', $this->user_id)
                                ->pluck('id');

            $rate = DuelUserResult::whereIn('duel_user_id', $duel_user_ids)->sum('rating');
            return $rate;
        }
    }

    public function event()
    {
        return $this->belongsTo('App\Models\Event', 'event_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
