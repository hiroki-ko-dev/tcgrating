<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ApiService;
use App\Services\PostService;
use App\Presenters\Api\Post\PostCommentPresenter;
use App\Dto\Http\ResponseDto;

class PostCommentController extends Controller
{
    public function __construct(
        private readonly PostService $postService,
        private readonly ApiService $apiService,
        private readonly postCommentPresenter $postCommentPresenter,
    ) {
    }

    public function index(Request $request)
    {
        try {
            $postCommentFilters['post_id'] = $request->post_id;
            return response()->json(
                new ResponseDto(
                    data: $this->postCommentPresenter->index(
                        $this->postService->paginatePostComment($postCommentFilters, 50),
                    ),
                    code: 200,
                    message: '',
                )
            );
        } catch (\Exception $e) {
            return response()->json(
                new ResponseDto(
                    data: [],
                    code: $e->getCode(),
                    message: $e->getMessage(),
                )
            );
        }
    }

    public function store(Request $request)
    {
        try {
            $comment =  $this->postService->createComment($request);
        } catch (\Exception $e) {
            $comment = [
                'result' => false,
                'error' => [
                    'messages' => [$e->getMessage()]
                ],
            ];
            return $this->apiService->resConversionJson($comment, $e->getCode());
        }
        return $this->apiService->resConversionJson($comment);
    }
}