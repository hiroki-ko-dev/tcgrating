<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function postComments(){
        return $this->hasMany('App\Models\PostComment','post_id','id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function team(){
        return $this->belongsTo('App\Models\Team','team_id','id');
    }
}
