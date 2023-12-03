<?php

namespace App\Services\Post\Dto;

use App\Models\Post;
use App\Models\PostComment;

class ReferralPostOrComment
{
    public function __construct(
        public readonly ?Post $post,
        public readonly ?PostComment $comment,
    ) {
    }
}
