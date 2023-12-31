<?php

declare(strict_types=1);

namespace App\Services\Blogs;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Blog;
use App\Repositories\BlogRepository;
use App\Repositories\BlogCommentRepository;

class BlogsService
{
    public function __construct(
        protected readonly BlogRepository $blogRepository,
        protected readonly BlogCommentRepository $blogCommentRepository
    ) {
    }

    public function createBlog(array $attrs): Blog
    {
        return $this->blogRepository->create($attrs);
    }

    public function saveBlog(int $blogId, array $attrs): Blog
    {
        return $this->blogRepository->update($blogId, $attrs);
    }

    public function getBlog(int $blogId): ?Blog
    {
        return $this->blogRepository->find($blogId);
    }

    public function getPreviewBlog($blog_id): Blog
    {
        return $this->blogRepository->findByPreview($blog_id);
    }

    public function getNextBlog($blog_id): ?Blog
    {
        return $this->blogRepository->findByNext($blog_id);
    }

    public function getBlogByPaginate($request, $paginate): LengthAwarePaginator
    {
        return $this->blogRepository->findAllByPaginate($request, $paginate);
    }

    public function deleteBlog(int $blogId): void
    {
        $this->blogRepository->delete($blogId);
    }
}
