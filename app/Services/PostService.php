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

    public function findPostWithUser($id)
    {
        return $this->post_repository->findWithUser($id);
    }

    public function findPostWithUserByEventId($event_id)
    {
        return $this->post_repository->findWithUserByEventId($event_id);
    }

    public function findPostWithUserByDuelId($duel_id)
    {
        return $this->post_repository->findWithUserByDuelId($duel_id);
    }

    public function findPostWithByPostCategoryTeam($team_id)
    {
        return $this->post_repository->findWithByPostCategoryTeam($team_id);
    }

    public function findAllPostCommentWithUserByPostIdAndPagination($post_id, $paginate)
    {
        return $this->post_comment_repository->findAllWithUserByPostIdAndPagination($post_id, $paginate);
    }

    public function getPostAndCommentCountWithPagination($request, $paginate)
    {
        return $this->post_repository->findAllAndCommentCountWithPagination($request, $paginate);
    }

}
