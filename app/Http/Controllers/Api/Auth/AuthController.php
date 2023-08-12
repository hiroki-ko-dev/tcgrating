<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use App\Presenters\Api\Auth\MobilePresenter;
use App\Dto\Http\ResponseDto;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly MobilePresenter $mobilePresenter,
    ) {
    }

    public function login(Request $request)
    {
        \Log::debug([$request->game_id, $request->user_id]);

        try {
            $gameUser = $this->userService->getGameUserByGameIdAndUserId($request->game_id, $request->user_id);
            // 選択しているゲームでフィルタ
            // $gameUserAttrs['expo_push_token'] = $request->expo_push_token;
            $gameUserAttrs['game_id'] = config('assets.site.game_ids.pokemon_card');
            $gameUser = $this->userService->updateGameUser($gameUser->id, $gameUserAttrs);
            return response()->json(
                new ResponseDto(
                    data: $this->mobilePresenter->login($gameUser),
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

    public function logout()
    {
        try {
            Auth::guard()->logout();
            return response()->json(
                new ResponseDto(
                    data: [],
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

    public function index($user_id)
    {
        try {
            // 選択しているゲームでフィルタ
            $request = new Request();
            $request->merge(['user_id' => $user_id]);
            $request->merge(['game_id' => config('assets.site.game_ids.pokemon_card')]);
            return response()->json(
                new ResponseDto(
                    data: $this->userService->getGameUserForApi($request),
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
