<?php

declare(strict_types=1);

namespace App\Presenters\Api\Post;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Dto\Http\PaginateResponseDto;
use App\Models\Post;

final class PostPresenter
{
    public function index(LengthAwarePaginator $posts): array
    {
        return [
            'paginate' => new PaginateResponseDto(
                data: $this->getPaginateData($posts),
                currentPage: $posts->currentPage(),
                perPage: $posts->perPage(),
                lastPage: $posts->lastPage(),
                total: $posts->total(),
            ),
        ];
    }

    private function getPaginateData(LengthAwarePaginator $posts): Collection
    {
        return $posts->getCollection()->transform(function (Post $post) {
            return $this->convertPost($post);
        });
    }

    public function show(Post $post): array
    {
        return $this->convertPost($post);
    }

    public function convertPost(Post $post): array
    {
        return [
            'id' => $post->id,
            'userId' => $post->user_id,
            'eventId' => $post->event_id,
            'duelId' => $post->duel_id,
            'title' => $post->title,
            'body' => $post->body,
            'imageUrl' => $post->image_url,
            'createdAt' => $post->created_at,
            'user' => [
                'name' => $post->user->name,
                'profileImagePath' => $post->user->profile_image_path,
            ]
        ];
    }
}
