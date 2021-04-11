<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public function eventUser(){
        return $this->hasMany('App\Models\EventUser','event_id','id');
    }
}
