<?php

namespace App\Repositories;
use App\Models\Post;

use Carbon\Carbon;
use Illuminate\Http\Request;

class PostRepository
{

    public function create($request)
    {

        $post = new Post();
        $post->fill([
            'post_category_id' => $request->post_category_id,
            'user_id'          => $request->user_id,
            'event_id'         => $request->event_id,
            'title'            => $request->title,
            'body'             => $request->body,
            'is_personal'      => $request->is_personal,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        $post->save();
        return $post;
    }

    public function find($id){
        return Post::find($id);
    }

    public function findByEventId($id){
        return Post::where('event_id',$id)->first();
    }

    public function findAllAndCommentCountByPostCategoryIdAndPagination($post_category_id, $paginate)
    {
        return Post::where('post_category_id', $post_category_id)
                    ->withCount('postComment')
                    ->OrderBy('id','desc')
                    ->paginate($paginate);;
    }

}
