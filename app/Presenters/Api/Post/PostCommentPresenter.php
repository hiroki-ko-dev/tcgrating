<?php

declare(strict_types=1);

namespace App\Presenters\Api\Post;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Dto\Http\PaginateResponseDto;

final class PostCommentPresenter
{
    public function index(LengthAwarePaginator $postComments): array
    {
        return [
            'paginate' => new PaginateResponseDto(
                data: $this->getPaginateData($postComments),
                currentPage: $postComments->currentPage(),
                perPage: $postComments->perPage(),
                lastPage: $postComments->lastPage(),
                total: $postComments->total(),
            ),
        ];
    }

    private function getPaginateData(LengthAwarePaginator $postComments): Collection
    {
        $startNo = ($postComments->currentPage() - 1) * $postComments->perPage() + 1;

        return $postComments->getCollection()->transform(function ($postComment) use (&$startNo) {
            return [
                'no' => $startNo++,
                'id' => $postComment->id,
                'referralId' => $postComment->referral_id,
                'postId' => $postComment->post_id,
                'number' => $postComment->number,
                'userId' => $postComment->user_id,
                'body' => $postComment->body,
                'imageUrl' => $postComment->image_url,
                'createdAt' => $postComment->created_at,
                'user' => [
                    'name' => $postComment->user->name,
                    'profileImagePath' => $postComment->user->profile_image_path,
                ]
            ];
        });
    }
}
