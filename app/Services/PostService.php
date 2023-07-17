<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Repositories\PostCommentRepository;

class PostService
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly PostCommentRepository $postCommentRepository
    ) {
    }

    public function createPost($request)
    {
        return $this->postRepository->create($request);
    }

    public function createComment($request)
    {
        $post = $this->findPost($request->post_id);
        if (isset($post->postComments)) {
            $number = $post->postComments->count() + 2;
        } else {
            $number = 2;
        }
        $request->merge(['number' => $number]);

        return $this->postCommentRepository->create($request);
    }

    public function savePostForUpdated($post_id)
    {
        return $this->postRepository->updateForUpdated($post_id);
    }

    public function findPost(int $id): ?Post
    {
        return $this->postRepository->find($id);
    }

    public function findOrFailPost(int $id): Post
    {
        return $this->postRepository->findOrFail($id);
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

    public function paginatePosts(array $attrs, int $row): LengthAwarePaginator
    {
        return $this->postRepository->paginate($attrs, $row);
    }

    public function getPostForApi($request, $paginate)
    {
        return $this->postRepository->findForApi($request, $paginate);
    }

    public function getComment($comment_id)
    {
        return $this->postCommentRepository->find($comment_id);
    }

    public function paginatePostComment(array $filters, int $row): LengthAwarePaginator
    {
        return $this->postCommentRepository->paginate($filters, $row);
    }

    public function getPostsForApi($request, $paginate)
    {
        return $this->postRepository->findAllForApi($request, $paginate);
    }
}
