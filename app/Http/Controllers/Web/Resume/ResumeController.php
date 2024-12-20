<?php

namespace App\Http\Controllers\Web\Resume;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Auth;
use DB;
use App\Services\User\UserService;
use App\Services\User\UserInfoTwitterService;
use App\Services\User\UserResumeService;
use App\Services\EventService;
use App\Presenters\Web\Resume\ResumePresenter;
use Exception;

class ResumeController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly UserInfoTwitterService $userInfoTwitterService,
        private readonly UserResumeService $userResumeService,
        private readonly EventService $eventService,
        private readonly ResumePresenter $resumePresenter,
    ) {
    }

    public function index()
    {
        return redirect('/resume/' . Auth::id());
    }

    public function show(Request $request, int $userId): View | RedirectResponse
    {
        try {
            $gameUser = $this->userResumeService->show($userId);
            $resumeJson = $this->resumePresenter->resume($gameUser);
            $eventFilters['eventUsers']['user_id'] = $userId;
            $events = $this->eventService->findAllEvents($eventFilters);
            $user = $gameUser->user;
            $this->userInfoTwitterService->saveTwitterImage($user);

            return view('resume.show', compact('user', 'resumeJson', 'events'));
        } catch (Exception $e) {
            if ($e->getCode() !== 403) {
                report($e);
                abort($e->getCode());
            }
            \Log::error([
                "ポケカ履歴書表示ResumeController.php@show UserId:" . $userId,
                'IP Address' => $request->ip(),
                'Headers' => $request->header('User-Agent'),
            ]);
            return back()->with('flash_message', '表示できないページです');
        }
    }

    public function edit(Request $request, $user_id): View | RedirectResponse
    {
        //アカウント認証しているユーザーのみ新規作成可能
        $this->middleware('auth');
        if (Auth::id() <> $user_id) {
            return back();
        }

        $user = $this->userService->findUser($user_id);
        $gameUser = $user->gameUsers->where('game_id', $user->selected_game_id)->first();

        return view('resume.edit', compact('user', 'gameUser'));
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
//        return redirect('/resume/'.$request->input('id'))->with('flash_message', '保存しました');
//    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function update(Request $request): View | RedirectResponse
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

        return redirect('/resume/' . $request->input('id'))->with('flash_message', '保存しました');
    }
}
