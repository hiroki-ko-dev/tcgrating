<?php

declare(strict_types=1);

namespace App\Presenters\Web\Post;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;
use App\Models\PostComment;
use App\Enums\PostSubCategory;
use App\Repositories\Post\PostAndPaginateComment;
use stdClass;

final class PostAndPaginateCommentPresenter
{
    public function getResponse(PostAndPaginateComment $model): stdClass
    {
        $post = new stdClass();
        $post->id = $model->post->id;
        $post->subCategoryName = PostSubCategory::tryFrom($model->post->sub_category_id)->description();
        $post->eventId = $model->post->event_id;
        $post->duelId = $model->post->duel_id;
        $post->title = $model->post->title;
        $post->body = $model->post->body;
        $post->replyCommentCount = $model->post->replyCommentCount;
        $post->imageUrl = $model->post->image_url;
        $post->createdAt = $model->post->created_at;
        $post->user = $this->getUser($model->post->user);
        $post->comments = $this->getPaginateComments($model->comments);
        return $post;
    }

    private function getPaginateComments(LengthAwarePaginator $postComments): LengthAwarePaginator
    {
        $startNo = ($postComments->currentPage() - 1) * $postComments->perPage() + 1;
        $transformedComments = $postComments->getCollection()->transform(function (PostComment $postComment) use (&$startNo) {
            return json_decode(json_encode([
                'no' => $startNo++,
                'id' => $postComment->id,
                'postId' => $postComment->post_id,
                'number' => $postComment->number,
                'userId' => $postComment->user_id,
                'body' => $postComment->body,
                'imageUrl' => $postComment->image_url,
                'isReferralPost' => $postComment->referral_id === 0,
                'referralComment' => $this->getReferralComment($postComment->referralComment), // この行に注目
                'replyCommentCount' => $postComment->replyComments ? $postComment->replyComments->count() : 0,
                'createdAt' => (string)$postComment->created_at,
                'user' => $this->getUser($postComment->user)
            ]));
        });

        return new LengthAwarePaginator(
            $transformedComments,
            $postComments->total(),
            $postComments->perPage(),
            $postComments->currentPage(),
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => request()->query(),
            ]
        );
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

    private function getReferralComment(?PostComment $comment): ?stdClass
    {
        if (!$comment) {
            return null;
        }
        return json_decode(json_encode([
            'id' => $comment->id,
            'number' => $comment->number,
        ]));
    }
}
