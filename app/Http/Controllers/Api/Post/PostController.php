<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\PostCategory;
use App\Services\PostService;
use App\Presenters\Api\Post\PostPresenter;
use App\Dto\Http\ResponseDto;
use DB;

class PostController extends Controller
{
    public function __construct(
        private readonly PostService $postService,
        private readonly postPresenter $postPresenter
    ) {
    }

    public function index()
    {
        try {
            $postFilters['post_category_id'] = PostCategory::CATEGORY_FREE;
            $postFilters['game_id'] = config('assets.site.game_ids.pokemon_card');
            return response()->json(
                new ResponseDto(
                    data: $this->postPresenter->index(
                        $this->postService->paginatePosts($postFilters, 20),
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
            $posts = DB::transaction(function () use ($request) {

                $request->merge(['game_id' => config('assets.site.game_ids.pokemon_card')]);
                $request->merge(['post_category_id' => \App\Models\PostCategory::CATEGORY_FREE]);

                $this->postService->createPost($request);

                return $this->postService->getPostsForApi($request, 20);
            });
        } catch (\Exception $e) {
            $posts = [
                'result' => false,
                'error' => [
                    'messages' => [$e->getMessage()]
                ],
            ];
            return $this->apiService->resConversionJson($posts, $e->getCode());
        }
        return $this->apiService->resConversionJson($posts);
    }

    public function show(int $postId)
    {
        try {
            return response()->json(
                new ResponseDto(
                    data: $this->postPresenter->show(
                        $this->postService->findOrFailPost($postId),
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
}
