<?php

namespace App\Services;
use App\Repositories\PostRepository;
use App\Repositories\PostCommentRepository;

use Illuminate\Http\Request;

class PostService
{
    protected $post_repository;
    protected $post_comment_repository;

    public function __construct(PostRepository $post_repository,
                                PostCommentRepository $post_comment_repository)
    {
        $this->post_repository         = $post_repository;
        $this->post_comment_repository = $post_comment_repository;
    }

    public function createPost($request)
    {
        return $this->post_repository->create($request);
    }

    public function findPost($id)
    {
        return $this->post_repository->find($id);
    }

    public function findAllByPostCommentWithUserByPostIdAndPagination($post_id, $paginate)
    {
        return $this->post_comment_repository->findAllWithUserByPostIdAndPagination($post_id, $paginate);
    }

    public function getPostsByPostCategoryAndPagination($post_category_id, $paginate)
    {
        return $this->post_repository->findAllByPostCategoryIdAndPagination($post_category_id, $paginate);
    }

}
