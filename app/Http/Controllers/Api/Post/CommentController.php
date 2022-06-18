<?php

namespace App\Http\Controllers\Api\Post;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\PostService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    protected $postService;
    protected $apiService;

    public function __construct(PostService $postService,
                                ApiService $apiService)
    {
        $this->postService = $postService;
        $this->apiService = $apiService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $comment =  $this->postService->createComment($request);

        } catch(\Exception $e){
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
