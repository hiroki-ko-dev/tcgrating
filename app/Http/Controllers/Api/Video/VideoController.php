<?php

namespace App\Http\Controllers\Api\Video;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Services\VideoService;
use App\Services\ApiService;

use Illuminate\Http\Request;

class VideoController extends Controller
{

    protected $videoService;
    protected $apiService;

    /**
     * SingleController constructor.
     * @param VideoService $videoService
     * @param ApiService $apiService
     */
    public function __construct(VideoService $videoService,
                                ApiService $apiService)
    {
        $this->videoService = $videoService;
        $this->apiService = $apiService;
    }

    public function index()
    {
        try {
            // 選択しているゲームでフィルタ
            $request = new Request();
            $request->merge(['game_id' => config('assets.site.game_ids.pokemon_card')]);;

            $videos = $this->videoService->getVideosByPaginate($request, 50);

        } catch(\Exception $e){
            $videos = [
                'result' => false,
                'error' => [
                    'messages' => [$e->getMessage()]
                ],
            ];
            return $this->apiService->resConversionJson($videos, $e->getCode());
        }
        return $this->apiService->resConversionJson($videos);
    }
}
