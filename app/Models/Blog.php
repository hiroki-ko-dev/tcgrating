<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function blogComment(){
        return $this->hasMany('App\Models\BlogComment','blog_id','id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

}
