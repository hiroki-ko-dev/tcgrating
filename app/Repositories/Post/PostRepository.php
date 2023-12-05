<?php

namespace App\Repositories\Post;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Post;
use App\Repositories\Post\Dto\PostAndPaginateComment;

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

    public function composeWhereClause(array $attrs): Builder
    {
        $query = Post::query();
        $fields = [
            'game_id',
            'post_category_id',
            'sub_category_id',
            'search',
        ];
        foreach ($fields as $field) {
            if (array_key_exists($field, $attrs)) {
                if (isset($attrs[$field])) {
                    if ($field === 'search') {
                        $words = preg_split('/\s|　/', $attrs[$field]);
                        foreach ($words as $word) {
                            $query->where('title', 'like', "%$word%");
                        }
                    } else {
                        $query->where($field, $attrs[$field]);
                    }
                }
            }
        }
        return $query;
    }

    public function find($id): Post | null
    {
        return Post::find($id);
    }

    public function findOrFail(int $id): Post | ModelNotFoundException
    {
        return Post::findOrFail($id);
    }

    public function findOrFailAndPaginatePostComments(
        int $id,
        int $row,
        int $page,
    ): PostAndPaginateComment | ModelNotFoundException {
        $post = $this->findOrFail($id);
        return new PostAndPaginateComment(
            post: $post,
            comments: $post->postComments()->paginate($row, ['*'], 'page', $page),
        );
    }

    public function findAll(array $attrs): Collection
    {
        $query = $this->composeWhereClause($attrs);
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

    public function paginate(array $filters, int $row, int $page): LengthAwarePaginator
    {
        $query = Post::query();
        foreach ($filters as $key => $value) {
            if ($key === "search") {
                $words = preg_split('/\s|　/', $value);
                foreach ($words as $word) {
                    $query->where('title', 'like', "%$word%");
                }
            } else {
                $query->where($key, $value);
            }
        }
        $query->OrderBy('updated_at', 'desc');

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
