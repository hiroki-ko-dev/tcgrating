<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function post(){
        return $this->belongsTo('App\Models\Post','post_id','id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function replyComments(){
        return $this->hasMany('App\Models\PostComment','referral_id','id');
    }

    public function referralComment(){
        return $this->hasOne('App\Models\PostComment','id','referral_id');
    }
}
