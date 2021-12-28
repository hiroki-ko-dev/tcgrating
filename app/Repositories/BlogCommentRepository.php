<?php

namespace App\Repositories;
use App\Models\BlogComment;

use Carbon\Carbon;
use Illuminate\Http\Request;

class BlogCommentRepository
{

    public function create($request)
    {
        $comment = new PostComment();
        $comment->fill([
            'post_id'          => $request->post_id,
            'user_id'          => $request->user_id,
            'body'             => $request->body,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);
        $comment->save();

        return $comment ;
    }

    public function find($id){
        return PostComment::find($id);
    }

    public function findAllWithUserByPostIdAndPagination($post_id, $paginate)
    {
        return PostComment::with('user:id,name,twitter_simple_image_url')
                            ->where('post_id', $post_id)
                            ->paginate($paginate);
    }

}
