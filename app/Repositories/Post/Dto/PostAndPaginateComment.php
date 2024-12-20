<?php

namespace App\Repositories\Post\Dto;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Post;

class PostAndPaginateComment
{
    public function __construct(
        public readonly Post $post,
        public readonly LengthAwarePaginator $comments,
    ) {
    }
}
