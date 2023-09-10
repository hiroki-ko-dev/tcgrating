<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\PostComment;

class PostCommentRepository
{
    public function create(array $attrs): PostComment
    {
        $postComment = new PostComment();

        if (isset($attrs['referral_id'])) {
            $postComment->referral_id = $attrs['referral_id'];
        }
        $postComment->post_id = $attrs['post_id'];
        $postComment->number  = $attrs['number'];
        $postComment->user_id = $attrs['user_id'];
        $postComment->body    = $attrs['body'];
        if (isset($attrs['image_url'])) {
            $postComment->image_url = $attrs['image_url'];
        }
        $postComment->save();

        return $postComment;
    }

    public function find($id): ?PostComment
    {
        return PostComment::find($id);
    }

    public function paginate(array $filters, int $row): LengthAwarePaginator
    {
        $query = PostComment::query();
        foreach ($filters as $key => $filter) {
            $query->where($key, $filter);
        }
        $query->OrderBy('id', 'asc');

        return $query->paginate($row);
    }

    public function findAllWithUserByPostIdAndPagination($post_id, $paginate)
    {
        return PostComment::with('user:id,name,twitter_simple_image_url')
                            ->where('post_id', $post_id)
                            ->paginate($paginate);
    }

}
