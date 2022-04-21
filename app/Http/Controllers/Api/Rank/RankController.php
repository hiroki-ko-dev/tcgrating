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

            $rates = $this->userService->getGameUsersByRankForApi($request, 200);

        } catch(\Exception $e){
            $events = [
                'result' => false,
                'error' => [
                    'messages' => [$e->getMessage()]
                ],
            ];
            return $this->apiService-resConversionJson($events, $e->getCode());
        }
        return $this->apiService->resConversionJson($rates);
    }
}
