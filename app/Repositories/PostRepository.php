<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use ModelNotFoundException;
use App\Models\Post;

class PostRepository
{
    public function create($request)
    {
        $post = new Post();
        if (isset($request->game_id)) {
            $post->game_id = $request->game_id;
        }
        if (isset($request->post_category_id)) {
            $post->post_category_id = $request->post_category_id;
        }
        if (isset($request->sub_category_id)) {
            $post->sub_category_id = $request->sub_category_id;
        }
        if (isset($request->user_id)) {
            $post->user_id = $request->user_id;
        }
        if (isset($request->duel_id)) {
            $post->duel_id = $request->duel_id;
        }
        if (isset($request->team_id)) {
            $post->team_id = $request->team_id;
        }
        if (isset($request->event_id)) {
            $post->event_id = $request->event_id;
        }
        if (isset($request->title)) {
            $post->title = $request->title;
        }
        if (isset($request->body)) {
            $post->body = $request->body;
        }
        if (isset($request->image_url)) {
            $post->image_url = $request->image_url;
        }
        if (isset($request->is_personal)) {
            $post->is_personal = $request->is_personal;
        }
        $post->save();

        return $post;
    }

    public function updateForUpdated($id)
    {
        $this->find($id)->touch();
    }

    public function composeWhereClause($request)
    {
        $query = Post::query();
        $query->where('game_id', $request->game_id);
        $query->where('post_category_id', $request->post_category_id);
        if (isset($request->sub_category_id) && $request->sub_category_id > 0) {
            $query->where('sub_category_id', $request->sub_category_id);
        }
        // 検索ワードでフィルタ
        if (isset($request->search)) {
            $words = preg_split('/\s|　/', $request->search);
            foreach ($words as $word) {
                $query->where('title', 'like', "%$word%");
            }
        }
        return $query;
    }

    public function find($id)
    {
        return Post::find($id);
    }

    public function findOrFail(int $id): Post
    {
        return Post::findOrFail($id);
    }

    public function findAll($request)
    {
        $query = $this->composeWhereClause($request);
        return $query->get();
    }

    public function findWithUser($id)
    {
        return Post::with('user')->find($id);
    }

    public function findWithUserByEventId($id)
    {
        return Post::where('event_id', $id)->with('user')->first();
    }

    public function findWithUserByDuelId($id)
    {
        return Post::where('duel_id', $id)->with('user')->first();
    }

    public function findWithByPostCategoryTeam($team)
    {
        return Post::where('team_id', $team)->where('post_category_id', \App\Models\PostCategory::CATEGORY_TEAM)->with('user')->first();
    }

    public function findAllAndCommentCountWithPagination($request, $paginate)
    {
        $query = $this->composeWhereClause($request);
        return $query->withCount('postComments')
                    ->OrderBy('updated_at', 'desc')
                    ->paginate($paginate);
    }


    public function updateForApi($request, $paginate)
    {
        $query = Post::query();
        $query->select('id', 'user_id', 'event_id', 'duel_id', 'title', 'body', 'created_at');
        $query->where('game_id', $request->game_id);
        $query->where('post_category_id', $request->post_category_id);
        if (isset($request->duel_id)) {
            $query->where('duel_id', $request->duel_id);
        }
        $query->with('user:id,name,twitter_simple_image_url');
        $query->OrderBy('id', 'desc');

        return $query->paginate($paginate);
    }

    public function paginate(array $filters, int $row): LengthAwarePaginator
    {
        $query = Post::query();
        foreach ($filters as $key => $filter) {
            $query->where($key, $filter);
        }
        $query->OrderBy('id', 'desc');

        return $query->paginate($row);
    }

    public function findForApi($request)
    {
        $query = Post::query();
        $query->select('id', 'user_id', 'event_id', 'duel_id', 'title', 'image_url', 'body', 'created_at');
        $query->where('id', $request->id);
        $query->with('user:id,name,twitter_simple_image_url');
        $query->with('postComments', function ($q) {
            $q->with('user:id,name,twitter_simple_image_url');
        });
        $query->with('user:id,name,twitter_simple_image_url');

        return $query->first();
    }

    public function findAllForApi($request, $paginate)
    {
        $query = Post::query();
        $query->select('id', 'user_id', 'event_id', 'duel_id', 'title', 'body', 'image_url', 'created_at');
        $query->where('game_id', $request->game_id);
        $query->where('post_category_id', $request->post_category_id);
        if (isset($request->duel_id)) {
            $query->where('duel_id', $request->duel_id);
        }
        $query->with('user:id,name,twitter_simple_image_url');
        $query->OrderBy('id', 'desc');

        return $query->paginate($paginate);
    }

}
