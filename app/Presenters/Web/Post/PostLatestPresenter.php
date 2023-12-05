<?php

declare(strict_types=1);

namespace App\Presenters\Web\Post;

use App\Models\Post;
use Illuminate\Support\Collection;

final class PostLatestPresenter
{
    public function getResponse(Collection $posts): Collection
    {
        return $this->convertPosts($posts);
    }

    private function convertPosts(Collection $posts): Collection
    {
        return $posts->sortByDesc('updated_at')
            ->take(10)
            ->transform(function (Post $post) {
                return (object)[
                    'id' => $post->id,
                    'title' => $post->title,
                ];
            });
    }
}
