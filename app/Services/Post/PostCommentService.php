<?php

declare(strict_types=1);

namespace App\Services\Post;

use Exception;
use Illuminate\Support\Facades\Auth;
use App\Services\Post\Dto\ReferralPostOrComment;

final class PostCommentService extends PostService
{
    public function getReferralPostOrComment(?int $postId, ?int $commentId)
    {
        if ($postId) {
            $comment = null;
            $post = $this->findPost($postId);
        } else {
            $post = null;
            $comment = $this->findComment($commentId);
        }
        if (!$post && !$comment) {
            throw new Exception("Post and comment not found", 400);
        }
        return new ReferralPostOrComment(
            post: $post,
            comment: $comment,
        );
    }

    public function makeReplyComment(array $attrs)
    {
        if (!isset($attrs['user_id'])) {
            if (Auth::check()) {
                $attrs['user_id'] = Auth::guard()->user()->id;
            }
        }
        $post = $this->findOrFailPost($attrs['post_id']);
        if (isset($post->postComments)) {
            $number = $post->postComments->count() + 2;
        } else {
            $number = 2;
        }
        $attrs['number'] = $number;

        $postComment = $this->postCommentRepository->create($attrs);
        $this->savePostForUpdated($post->id);
        return $postComment;
    }
}
