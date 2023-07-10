<?php

namespace App\Http\Controllers;


use Auth;
use DB;
use App\Services\User\UserService;
use App\Services\EventService;

use Illuminate\Http\Request;

class ResumeController extends Controller
{

    protected $userService;
    protected $eventService;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param EventService $eventService
     */
    public function __construct(UserService $userService,
                                EventService $eventService)
    {
        $this->userService  = $userService;
        $this->eventService = $eventService;
    }

    /**
     * @param Request $request
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        return redirect('/resume/'.Auth::id());
    }

    /**
     * @param Request $request
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request,$user_id)
    {
        $user   = $this->userService->findUser($user_id);

        $gameUserRequest = new \stdClass();
        $gameUserRequest->user_id = $user_id;

        // 選択しているゲームでフィルタ
        if(Auth::check()) {
            $gameUserRequest->game_id = Auth::user()->selected_game_id;
        }else{
            $gameUserRequest->game_id = session('selected_game_id');
        }
        $gameUserJson = $this->userService->getGameUserJson($gameUserRequest);

        $this->userService->saveTwitterImage($user);
        $rankJson = $this->userService->getGameUserRank($gameUserRequest);

        $events = $this->eventService->findAllEventByUserId($user_id);

        return view('resume.show',compact('user','gameUserJson', 'rankJson', 'events'));
    }

    /**
     * @param Request $request
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Request $request,$user_id)
    {
        //アカウント認証しているユーザーのみ新規作成可能
        $this->middleware('auth');
        if(Auth::id() <> $user_id){
            return back();
        }

        $user = $this->userService->findUser($user_id);
        $gameUser = $user->gameUsers->where('game_id',$user->selected_game_id)->first();

        return view('resume.edit',compact('user','gameUser'));
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
    public function update(Request $request)
    {
        //アカウント認証しているユーザーのみ新規作成可能
        $this->middleware('auth');
        if(Auth::id() <> $request->id){
            return back()->with('flash_message', 'アカウントエラーです');
        }

        DB::transaction(function () use ($request) {
            $this->userService->updateUser(Auth::id(), $request->all());
            $gameUser = $this->userService->getGameUserByGameIdAndUserId(Auth::user()->selected_game_id, $request->id);
            $request->merge(['user_id' => $request->id]);
            $request->id = $gameUser->id;
            $gameUser = $this->userService->updateGameUser($request);
            $request->merge(['game_user_id' => $gameUser->id]);

            $item_ids = array_merge( \App\Models\GameUserCheck::ITEM_ID_REGULATIONS,\App\Models\GameUserCheck::ITEM_ID_PLAY_STYLES);

            if(isset($request->item_ids)){
                foreach ($item_ids as $item_id){
                    $request->merge(['item_id' => $item_id]);
                    if(in_array($item_id,$request->item_ids)) {
                        $this->userService->makeGameUserCheck($request);
                    }else{
                        $this->userService->dropGameUserCheck($request);
                    }
                }
            }else{
                $this->userService->dropGameUserCheck($request);
            }

        });

        return redirect('/resume/'.$request->input('id'))->with('flash_message', '保存しました');
    }
}
