<?php

namespace App\Http\Controllers\Api\Rank;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Services\UserService;
use App\Services\ApiService;

use Illuminate\Http\Request;

class RankController extends Controller
{

    protected $userService;
    protected $apiService;

    /**
     * SingleController constructor.
     * @param UserService $userService
     * @param ApiService $apiService
     */
    public function __construct(UserService $userService,
                                ApiService $apiService)
    {
        $this->userService = $userService;
        $this->apiService = $apiService;
    }

    public function index()
    {
        try {
            // 選択しているゲームでフィルタ
            $request = new Request();
            $request->merge(['game_id' => config('assets.site.game_ids.pokemon_card')]);;

            $rates = $this->userService->getGameUsersByRankForApi($request, 50);

        } catch(\Exception $e){
            $events = [
                'result' => false,
                'error' => [
                    'messages' => [$e->getMessage()]
                ],
            ];
            return $this->resConversionJson($events, $e->getCode());
        }
        return $this->resConversionJson($rates);
    }

    private function resConversionJson($eloquent, $statusCode=200)
    {
        if(empty($statusCode) || $statusCode < 100 || $statusCode >= 600){
            $statusCode = 500;
        }
        return response()->json($eloquent, $statusCode, ['Content-Type' => 'application/json'], JSON_UNESCAPED_SLASHES);
    }

}
