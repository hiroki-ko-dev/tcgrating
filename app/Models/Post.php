<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function postComment(){
        return $this->hasMany('App\Models\PostComment','post_id','id');
    }
}
