<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\PostCategory;
use App\Services\Post\PostService;
use App\Presenters\Api\Post\PostPresenter;
use App\Dto\Http\ResponseDto;
use App\Http\Requests\Api\Post\SaveRequest;

class PostController extends Controller
{
    public function __construct(
        private readonly PostService $postService,
        private readonly postPresenter $postPresenter
    ) {
    }

    public function index(Request $request)
    {
        try {
            $postFilters['post_category_id'] = PostCategory::CATEGORY_FREE;
            $postFilters['game_id'] = config('assets.site.game_ids.pokemon_card');
            $page = $request->get('page', 1);
            return response()->json(
                new ResponseDto(
                    data: $this->postPresenter->index(
                        $this->postService->paginatePosts($postFilters, 20, $page),
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

    public function store(saveRequest $request)
    {
        try {
            $postAttrs = $request->all();
            $postAttrs['game_id'] = config('assets.site.game_ids.pokemon_card');
            $postAttrs['post_category_id'] = \App\Models\PostCategory::CATEGORY_FREE;
            $post = $this->postService->createPost($postAttrs);
            return response()->json(
                new ResponseDto(
                    data: ['postId' => $post->id],
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
