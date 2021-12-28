<?php

namespace App\Services;
use App\Repositories\BlogRepository;
use App\Repositories\BlogCommentRepository;

use Illuminate\Http\Request;

class BlogService
{
    protected $blogRepository;
    protected $post_comment_repository;

    public function __construct(BlogRepository $blogRepository,
                                BlogCommentRepository $blogCommentRepository)
    {
        $this->blogRepository         = $blogRepository;
        $this->blogCommentRepository = $blogCommentRepository;
    }

    public function getBlogByPaginate($request, $paginate)
    {
        return $this->blogCommentRepository->findAllByPaginate($request, $paginate);
    }


}
