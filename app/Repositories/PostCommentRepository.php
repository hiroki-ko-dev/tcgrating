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
                'post_id'          => $request->post_id,
                'user_id'          => $request->user_id,
                'body'             => $request->body,
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
        return PostComment::with('user:id,name')
                            ->where('post_id', $post_id)
                            ->paginate($paginate);
    }

}
