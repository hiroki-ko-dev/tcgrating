<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    //定数の定義
    const SUB_CATEGORY_FREE = 1;
    const SUB_CATEGORY_DECK = 2;
    const SUB_CATEGORY_RULE = 3;

    const SUB_CATEGORY = [
        self::SUB_CATEGORY_FREE  => '雑談',
        self::SUB_CATEGORY_DECK  => 'デッキ相談',
        self::SUB_CATEGORY_RULE  => 'ルール質問',
    ];

    public function postComments()
    {
        return $this->hasMany('App\Models\PostComment', 'post_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function team()
    {
        return $this->belongsTo('App\Models\Team', 'team_id', 'id');
    }

    public function getAttributeReplyCommentCount()
    {
        return $this->postComments->where('referral_id', 0)->whereNotNull('referral_id')->count();
    }
}
