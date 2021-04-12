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

    public function createComment($request)
    {
        return $this->post_comment_repository->create($request);
    }

    public function findPost($id)
    {
        return $this->post_repository->find($id);
    }

    public function findPostByEventId($event_id)
    {
        return $this->post_repository->findByEventId($event_id);
    }


    public function findAllPostCommentWithUserByPostIdAndPagination($post_id, $paginate)
    {
        return $this->post_comment_repository->findAllWithUserByPostIdAndPagination($post_id, $paginate);
    }

    public function getPostsByPostCategoryAndPagination($post_category_id, $paginate)
    {
        return $this->post_repository->findAllAndCommentCountByPostCategoryIdAndPagination($post_category_id, $paginate);
    }

}
