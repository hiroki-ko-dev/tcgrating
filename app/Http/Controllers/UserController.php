<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Services\User\UserService;
use App\Services\User\UserInfoTwitterService;
use App\Services\User\UserResumeService;
use App\Services\EventService;
use App\Presenters\Web\Resume\ResumePresenter;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly UserInfoTwitterService $userInfoTwitterService,
        private readonly UserResumeService $userResumeService,
        private readonly EventService $eventService,
        private readonly ResumePresenter $resumePresenter,
    ) {
    }

    public function index(): RedirectResponse
    {
        return redirect('/user/' . Auth::id());
    }

    public function show(Request $request, int $userId): View
    {
        $user = $this->userService->findUser($userId);
        $events = $this->eventService->findAllEventByUserId($userId);
        $this->userInfoTwitterService->saveTwitterImage($user);

        return view('user.show', compact('user', 'events'));
    }

    public function edit(Request $request, int $user_id): View | RedirectResponse
    {
        //アカウント認証しているユーザーのみ新規作成可能
        $this->middleware('auth');
        if (Auth::id() <> $user_id) {
            return back();
        }

        $user = $this->userService->findUser($user_id);
        $gameUser = $user->gameUsers->where('game_id', $user->selected_game_id)->first();

        return view('user.edit', compact('user', 'gameUser'));
    }

//    /**
//     * @param Request $request
//     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
//     */
//    public function store(Request $request)
//    {
//        DB::transaction(function () use($request){
//            $this->userService->updateUser($request);
//        });
//
//        return redirect('/user/'.$request->input('id'))->with('flash_message', '保存しました');
//    }

    public function update(Request $request): RedirectResponse
    {
        //アカウント認証しているユーザーのみ新規作成可能
        $this->middleware('auth');
        if (Auth::id() <> $request->id) {
            return back()->with('flash_message', 'アカウントエラーです');
        }

        DB::transaction(function () use ($request) {
            $this->userService->updateUser(Auth::id(), $request->all());
            $gameUser = $this->userService->getGameUserByGameIdAndUserId(Auth::user()->selected_game_id, $request->id);
            $request->merge(['user_id' => $request->id]);
            $request->id = $gameUser->id;
            $gameUser = $this->userService->updateGameUser($gameUser->id, $request->all());
            $request->merge(['game_user_id' => $gameUser->id]);

            $item_ids = array_merge(\App\Models\GameUserCheck::ITEM_ID_REGULATIONS, \App\Models\GameUserCheck::ITEM_ID_PLAY_STYLES);

            if (isset($request->item_ids)) {
                foreach ($item_ids as $item_id) {
                    $request->merge(['item_id' => $item_id]);
                    if (in_array($item_id, $request->item_ids)) {
                        $this->userService->makeGameUserCheck($request);
                    } else {
                        $this->userService->dropGameUserCheck($request);
                    }
                }
            } else {
                $this->userService->dropGameUserCheck($request);
            }
        });
        return redirect('/user/' . $request->input('id'))->with('flash_message', '保存しました');
    }
}
