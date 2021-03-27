<?php

namespace App\Repositories;
use App\Models\Post;

use Carbon\Carbon;
use Illuminate\Http\Request;

class PostRepository
{

    public function create($request)
    {
        Post::insert([
            [
                'post_category_id' => $request->post_category_id,
                'user_id'          => $request->user_id,
                'title'            => $request->title,
                'body'             => $request->body,
                'is_personal'      => $request->is_personal,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now()
            ],
        ]);
    }

    public function findAllByPostCategoryIdAndPagination($post_category_id, $paginate)
    {
        return Post::where('post_category_id', $post_category_id)->paginate($paginate);
    }

}
