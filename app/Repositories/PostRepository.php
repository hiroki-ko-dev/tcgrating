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
            'game_id'          => $request->game_id,
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

    public function composeWhereClause($request)
    {
        $query = Post::query();
        $query->where('game_id', $request->game_id);
        $query->where('post_category_id', $request->post_category_id);
        return $query;
    }

    public function findAll($request)
    {
        $query = $this->composeWhereClause($request);
        return $query->get();
    }

    public function findWithUser($id){
        return Post::with('user')->find($id);
    }

    public function findWithUserByEventId($id){
        return Post::where('event_id',$id)->with('user')->first();
    }

    public function findWithUserByDuelId($id){
        return Post::where('duel_id',$id)->with('user')->first();
    }

    public function findWithByPostCategoryTeam($team){
        return Post::where('team_id',$team)->where('post_category_id', \App\Models\PostCategory::CATEGORY_TEAM)->with('user')->first();
    }

    public function findAllAndCommentCountWithPagination($request, $paginate)
    {
        $query = $this->composeWhereClause($request);
        return $query->withCount('postComments')
                    ->OrderBy('id','desc')
                    ->paginate($paginate);
    }

    public function findForApi($request)
    {
        $query = Post::query();
        $query->select('id', 'user_id', 'event_id', 'duel_id', 'title', 'body', 'created_at');
        $query->where('id', $request->id);
        $query->with('user:id,name,twitter_simple_image_url');
        $query->with('postComments', function($q) {
            $q->with('user:id,name,twitter_simple_image_url');
        });
        $query->with('user:id,name,twitter_simple_image_url');

        return $query->first();
    }

    public function findAllForApi($request, $paginate)
    {
        $query = Post::query();
        $query->select('id', 'user_id', 'event_id', 'duel_id', 'title', 'body', 'created_at');
        $query->where('game_id', $request->game_id);
        $query->where('post_category_id', $request->post_category_id);
        if(isset($request->duel_id)){
            $query->where('duel_id', $request->duel_id);
        }
        $query->with('user:id,name,twitter_simple_image_url');
        $query->OrderBy('id','desc');

        return $query->paginate($paginate);;
    }

}
