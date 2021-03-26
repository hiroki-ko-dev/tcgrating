<?php

namespace App\Repositories;
use App\Models\Post;

use Illuminate\Http\Request;

class PostRepository
{

    public function findAllByPostCategoryIdAndPagination($post_category_id, $paginate)
    {
        return Post::where('post_category_id', $post_category_id)->paginate($paginate);
    }

}
