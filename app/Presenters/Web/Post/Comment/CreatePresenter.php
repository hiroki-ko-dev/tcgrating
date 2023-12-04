<?php

declare(strict_types=1);

namespace App\Presenters\Web\Post\Comment;

use App\Models\User;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Support\Collection;
use App\Services\Post\Dto\ReferralPostOrComment;
use stdClass;

final class CreatePresenter
{
    public function getResponse(ReferralPostOrComment $referralPostOrComment): stdClass
    {
        if ($referralPostOrComment->post) {
            $post = $this->convertPost($referralPostOrComment->post);
            $comment = null;
            $postComments = $this->convertReplyComments($referralPostOrComment->post->replyComments);
        } else {
            $post = null;
            $comment = $this->convertComment($referralPostOrComment->comment);
            $postComments = $this->convertReplyComments($referralPostOrComment->comment->replyComments);
        }
        return json_decode(json_encode([
            'post' => $post,
            'comment' => $comment,
            'replyComments' => $postComments,
        ]));
    }

    private function convertPost(?Post $post)
    {
        if (is_null($post)) {
            return $post;
        }
        $post = [
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'imageUrl' => $post->image_url,
            'user' => $this->getUser($post->user),
            'replyCommentCount' => $post->replyCommentCount,
            'createdAt' => $post->created_at,
        ];

        return json_decode(json_encode($post));
    }

    private function convertComment(?PostComment $postComment): ?stdClass
    {
        if (empty($postComment)) {
            return null;
        }
        $comment = [
            'id' => $postComment->id,
            'postId' => $postComment->post_id,
            'number' => $postComment->number,
            'body' => $postComment->body,
            'imageUrl' => $postComment->image_url,
            'isReferralPost' => $postComment->referral_id === 0,
            'referralId' => $postComment->referral_id,
            'referralComment' => $this->convertComment($postComment->referralComment),
            'replyCommentCount' => $postComment->replyComments ? $postComment->replyComments->count() : 0,
            'createdAt' => $postComment->created_at,
            'user' => $this->getUser($postComment->user)
        ];

        return json_decode(json_encode($comment));
    }

    private function getUser(?User $user): stdClass
    {
        $userArray = $user ? [
            'id' => $user->id,
            'name' => $user->name,
            'profileImagePath' => $user->profile_image_path,
        ] : [
            'id' => 0,
            'name' => 'ゲスト',
            'profileImagePath' => '/images/icon/default-icon-mypage.jpg',
        ];

        return json_decode(json_encode($userArray));
    }

    private function convertReplyComments(?Collection $comments): Collection
    {
        if (is_null($comments)) {
            return new Collection();
        }

        return $comments->transform(function (PostComment $postComment) use (&$startNo) {
            return [
                'id' => $postComment->id,
                'postId' => $postComment->post_id,
                'number' => $postComment->number,
                'body' => $postComment->body,
                'imageUrl' => $postComment->image_url,
                'isReferralPost' => $postComment->referral_id === 0,
                'referralId' => $postComment->referral_id,
                'replyCommentCount' => $postComment->replyComments ? $postComment->replyComments->count() : 0,
                'createdAt' => $postComment->created_at,
                'user' => $this->getUser($postComment->user)
            ];
        });
    }
}
