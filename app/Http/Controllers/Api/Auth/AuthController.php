<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Support\Facades\Log;
use Validator;
use App\Services\UserService;
use App\Services\ApiService;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
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

    public function login()
    {
        if(Auth::check()){
            return redirect('/user/' . Auth::user()->id);
        }else{
            return Socialite::driver('twitter')->redirect();
        }
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();
        $json = [
            'result' => 'logout',
        ];
        return $this->apiService->resConversionJson($json);
    }

    public function index($user_id)
    {
        try {
            // 選択しているゲームでフィルタ
            $request = new Request();
            $request->merge(['user_id' => $user_id]);
            $request->merge(['game_id' => config('assets.site.game_ids.pokemon_card')]);

            $rates = $this->userService->getGameUserForApi($request);

        } catch(\Exception $e){
            $events = [
                'result' => false,
                'error' => [
                    'messages' => [$e->getMessage()]
                ],
            ];
            return $this->apiService->resConversionJson($events, $e->getCode());
        }
        return $this->apiService->resConversionJson($rates);
    }

    public function discordName(Request $request)
    {
        try {

            // discord名にバリデーションをかける
            $validator = Validator::make($request->all(), [
                'discord_name' => 'required|regex:/.+#\d{4}$/|max:255',
                'discord_name.regex' => 'ディスコードの名前は「〇〇#数字4桁」の形式にしてください',
            ]);

            // discordNameがおかしかったらエラーで返す
            if ($validator->fails()) {
                $gameUser = $this->userService->getGameUserForApi($request);
                return $this->apiService->resConversionJson($gameUser);
            }

            $gameUser = $this->userService->updateGameUser($request);
        } catch(\Exception $e){
            $gameUser = [
                'result' => false,
                'error' => [
                    'messages' => [$e->getMessage()]
                ],
            ];
            return $this->apiService->resConversionJson($gameUser, $e->getCode());
        }

        return $this->apiService->resConversionJson($gameUser);
    }
}
