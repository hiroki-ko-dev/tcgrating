<?php

declare(strict_types=1);

namespace App\Services\Blogs;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Blog;
use App\Repositories\BlogRepository;
use App\Repositories\BlogCommentRepository;

class BlogsService
{
    public function __construct(
        protected readonly BlogRepository $blogRepository,
        protected readonly BlogCommentRepository $blogCommentRepository,
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

    public function findAllBlogs(array $filters): Collection
    {
        return $this->blogRepository->findAll($filters);
    }

    public function getPreviewBlog($blogId): Blog
    {
        return $this->blogRepository->findByPreview($blogId);
    }

    public function getNextBlog($blogId): ?Blog
    {
        return $this->blogRepository->findByNext($blogId);
    }

    public function paginateBlogs(array $filters, int $row): LengthAwarePaginator
    {
        return $this->blogRepository->paginate($filters, $row);
    }

    public function deleteBlog(int $blogId): void
    {
        $this->blogRepository->delete($blogId);
    }
}
