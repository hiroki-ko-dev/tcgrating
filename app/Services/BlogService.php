<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Blog;
use App\Repositories\BlogRepository;
use App\Repositories\BlogCommentRepository;

class BlogService
{
    public function __construct(
        protected readonly BlogRepository $blogRepository,
        protected readonly BlogCommentRepository $blogCommentRepository
    ) {
    }

    public function makeBlog($request): Blog
    {
        return $this->blogRepository->create($request);
    }

    public function saveBlog($request): Blog
    {
        return $this->blogRepository->update($request);
    }

    public function getBlog(int $blogId): ?Blog
    {
        return $this->blogRepository->find($blogId);
    }

    public function getPreviewBlog($blog_id)
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
}
