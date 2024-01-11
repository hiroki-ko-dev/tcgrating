<?php

declare(strict_types=1);

namespace App\Presenters\Web\Blogs;

use App\Models\Blog;
use Illuminate\Support\Collection;

final class BlogsLatestPresenter
{
    public function getResponse(Collection $blogs): Collection
    {
        return $this->convertBlogs($blogs);
    }

    private function convertBlogs(Collection $blogs): Collection
    {
        return $blogs->sortByDesc('updated_at')
            ->take(10)
            ->transform(function (Blog $blog) {
                return (object)[
                    'id' => $blog->id,
                    'title' => $blog->title,
                ];
            });
    }
}
