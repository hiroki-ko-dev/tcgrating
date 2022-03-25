<?php

namespace App\Services;
use App\Repositories\PostRepository;
use App\Repositories\PostCommentRepository;

use Illuminate\Http\Request;

class PostService
{
    protected $postRepository;
    protected $postCommentRepository;

    public function __construct(PostRepository $postRepository,
                                PostCommentRepository $postCommentRepository)
    {
        $this->postRepository         = $postRepository;
        $this->postCommentRepository = $postCommentRepository;
    }

    public function createPost($request)
    {
        return $this->postRepository->create($request);
    }

    public function createComment($request)
    {
        return $this->postCommentRepository->create($request);
    }

    public function findPostWithUser($id)
    {
        return $this->postRepository->findWithUser($id);
    }

    public function findPostWithUserByEventId($event_id)
    {
        return $this->postRepository->findWithUserByEventId($event_id);
    }

    public function findPostWithUserByDuelId($duel_id)
    {
        return $this->postRepository->findWithUserByDuelId($duel_id);
    }

    public function findPostWithByPostCategoryTeam($team_id)
    {
        return $this->postRepository->findWithByPostCategoryTeam($team_id);
    }

    public function findAllPostCommentWithUserByPostIdAndPagination($post_id, $paginate)
    {
        return $this->postCommentRepository->findAllWithUserByPostIdAndPagination($post_id, $paginate);
    }

    public function getPostAndCommentCountWithPagination($request, $paginate)
    {
        return $this->postRepository->findAllAndCommentCountWithPagination($request, $paginate);
    }

    public function getPostForApi($request, $paginate)
    {
        return $this->postRepository->findForApi($request, $paginate);
    }

    public function getPostsForApi($request, $paginate)
    {
        return $this->postRepository->findAllForApi($request, $paginate);
    }
}
