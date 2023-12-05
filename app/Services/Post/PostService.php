<?php

declare(strict_types=1);

namespace App\Services\Post;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Post;
use App\Repositories\Post\PostRepository;
use App\Repositories\Post\Dto\PostAndPaginateComment;
use App\Repositories\Post\PostCommentRepository;
use DB;

class PostService
{
    public function __construct(
        protected readonly PostRepository $postRepository,
        protected readonly PostCommentRepository $postCommentRepository
    ) {
    }

    public function createPost(array $attrs)
    {
        return $this->postRepository->create($attrs);
    }

    public function createComment($attrs)
    {
        return DB::transaction(function () use ($attrs) {
            $post = $this->findOrFailPost($attrs['post_id']);
            if (isset($post->postComments)) {
                $number = $post->postComments->count() + 2;
            } else {
                $number = 2;
            }
            $attrs['number'] = $number;

            return $this->postCommentRepository->create($attrs);
        });
    }

    public function savePostForUpdated($post_id)
    {
        return $this->postRepository->updateForUpdated($post_id);
    }

    public function findPost(int $id): ?Post
    {
        return $this->postRepository->find($id);
    }

    public function findPostAndPaginatePostComments(int $id, int $row, int $page): PostAndPaginateComment
    {
        return $this->postRepository->findOrFailAndPaginatePostComments($id, $row, $page);
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

    public function findAllPosts(array $attrs): Collection
    {
        return $this->postRepository->findAll($attrs);
    }

    public function findAllPostCommentWithUserByPostIdAndPagination($post_id, $paginate)
    {
        return $this->postCommentRepository->findAllWithUserByPostIdAndPagination($post_id, $paginate);
    }

    public function paginatePosts(array $attrs, int $row, int $page): LengthAwarePaginator
    {
        return $this->postRepository->paginate($attrs, $row, $page);
    }

    public function findComment($comment_id)
    {
        return $this->postCommentRepository->find($comment_id);
    }

    public function paginatePostComment(array $filters, int $row): LengthAwarePaginator
    {
        return $this->postCommentRepository->paginate($filters, $row);
    }
}
