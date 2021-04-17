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
            'duel_id'          => $request->duel_id,
            'team_id'          => $request->team_id,
            'title'            => $request->title,
            'body'             => $request->body,
            'is_personal'      => $request->is_personal,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        $post->save();
        return $post;
    }

    public function findWithUser($id){
        return Post::with('user')->find($id);
    }

    public function findWithUserByEventId($id){
        return Post::where('event_id',$id)->with('user')->first();
    }

    public function findWithUserByDuelId($id){
        return Post::where('event_id',$id)->with('user')->first();
    }

    public function findWithByPostCategoryTeam($team){
        return Post::where('team_id',$team)->where('post_category_id', \App\Models\PostCategory::TEAM)->with('user')->first();
    }

    public function findAllAndCommentCountByPostCategoryIdAndPaginate($post_category_id, $paginate)
    {
        return Post::where('post_category_id', $post_category_id)
                    ->withCount('postComment')
                    ->withCount('postComment')
                    ->OrderBy('id','desc')
                    ->paginate($paginate);
    }

}
