<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use ModelNotFoundException;
use App\Models\Post;

class PostRepository
{
    public function create(array $attrs)
    {
        $post = new Post();

        $fields = [
            'game_id',
            'post_category_id',
            'sub_category_id',
            'user_id',
            'duel_id',
            'team_id',
            'event_id',
            'title',
            'body',
            'image_url',
            'is_personal',
        ];

        foreach ($fields as $field) {
            if (array_key_exists($field, $attrs)) {
                $post->$field = $attrs[$field];
            }
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

    public function paginate(array $filters, int $row, int $page): LengthAwarePaginator
    {
        $query = Post::query();
        foreach ($filters as $key => $filter) {
            $query->where($key, $filter);
        }
        $query->OrderBy('id', 'desc');

        return $query->paginate($row, ['*'], 'page', $page);
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
