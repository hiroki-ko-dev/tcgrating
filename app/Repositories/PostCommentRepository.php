<?php

namespace App\Repositories;
use App\Models\PostComment;

use Carbon\Carbon;
use Illuminate\Http\Request;

class PostCommentRepository
{

    public function create($request)
    {
        PostComment::insert([
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

    public function find($id){
        return PostComment::find($id);
    }

    public function findAllWithUserByPostIdAndPagination($post_id, $paginate)
    {
        return PostComment::where('post_id', $post_id)->paginate($paginate);
    }

}
