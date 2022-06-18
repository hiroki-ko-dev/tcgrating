<?php

namespace App\Repositories;
use App\Models\PostComment;

use Carbon\Carbon;
use Illuminate\Http\Request;

class PostCommentRepository
{

    public function create($request)
    {
        $comment = new PostComment();
        if(isset($request->referral_id)){
            $comment->referral_id = $request->referral_id;
        }
        $comment->post_id = $request->post_id;
        $comment->number  = $request->number;

        $comment->user_id = $request->user_id;
        $comment->body    = $request->body;
        if(isset($request->image_url)){
            $comment->image_url = $request->image_url;
        }
        $comment->save();

        return $comment;
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
