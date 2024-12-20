<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function blog(){
        return $this->belongsTo('App\Models\Blog','blog_id','id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
