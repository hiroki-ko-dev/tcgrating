<?php

namespace App\Http\Controllers\Api\Post;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use App\Services\PostService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
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
     * @return mixed
     */
    public function index()
    {
        try {
            $request = new Request();
            $request->merge(['game_id' => config('assets.site.game_ids.pokemon_card')]);
            $request->merge(['post_category_id' => \App\Models\PostCategory::CATEGORY_FREE]);

            $posts =  $this->postService->getPostsForApi($request,20);

        } catch(\Exception $e){
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $posts = DB::transaction(function () use($request) {

                $request->merge(['game_id' => config('assets.site.game_ids.pokemon_card')]);
                $request->merge(['post_category_id' => \App\Models\PostCategory::CATEGORY_FREE]);

                $this->postService->createPost($request);

                return $this->postService->getPostsForApi($request,20);
            });

        } catch(\Exception $e){
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

    /**
     * @param $post_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($post_id)
    {
        try {
            $request = new Request();
            $request->merge(['id' => $post_id]);
            $posts =  $this->postService->getPostForApi($request,20);

        } catch(\Exception $e){
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
}
