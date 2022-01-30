<?php

namespace App\Http\Controllers\Event;


use Carbon\Carbon;
use DB;
use Auth;
use Mail;

use App\Http\Controllers\Controller;
use App\Services\EventService;
use App\Services\DuelService;
use App\Services\UserService;
use App\Services\TwitterService;

use Illuminate\Http\Request;

class SwissController extends Controller
{

    protected $eventService;
    protected $duelService;
    protected $userService;
    protected $twitterService;

    public function __construct(EventService $eventService,
                                DuelService $duelService,
                                UserService $userService,
                                TwitterService $twitterService)
    {
        $this->eventService = $eventService ;
        $this->duelService  = $duelService ;
        $this->userService  = $userService ;
        $this->twitterService = $twitterService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // 選択しているゲームでフィルタ
        if(\Illuminate\Support\Facades\Auth::check()) {
            $request->merge(['game_id' => Auth::user()->selected_game_id]);
        }else{
            $request->merge(['game_id' => session('selected_game_id')]);
        }
        $request->merge(['event_category_id' => \App\Models\EventCategory::CATEGORY_SWISS]);
        $events = $this->eventService->findAllEventByEventCategoryId($request, 50);

        return view('event.swiss.index',compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!(Auth::check() && Auth::user()->id == 1)) {
            return redirect('/');
        }

        session(['loginAfterRedirectUrl' => env('APP_URL').'/event/swiss/create']);
        session(['selected_game_id' => 3]);

        return view('event.swiss.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //アカウント認証しているユーザーのみ新規作成可能
        if(!Auth::check()){
            return back()->with('flash_message', '新規決闘作成を行うにはログインしてください');
        }

        // 選択しているゲームでフィルタ
        $request->merge(['game_id' => Auth::user()->selected_game_id]);
        $request->merge(['event_category_id' => \App\Models\EventCategory::CATEGORY_SWISS]);
        $request->merge(['user_id'           => Auth::id()]);

        $request->merge(['number_of_match'   => $request->number_of_match]);
        $request->merge(['now_match_number'   => 0]);

        $request->merge(['max_member'        => $request->max_member]);
        $request->merge(['status'            => \App\Models\EventUser::STATUS_APPROVAL]);
        $request->merge(['role'              => \App\Models\EventUser::ROLE_ADMIN]);
        $request->merge(['is_personal'       => 0]);

        $event = DB::transaction(function () use($request) {

            $event = $this->eventService->createEvent($request);

            // もしイベント作成ユーザーが選択ゲームでgameUserがなかったら作成
            $this->userService->makeGameUser($request);

            return $event;
        });

        return redirect('/event/swiss/' . $event->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $event_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $event_id)
    {
        $request->merge(['event_id' => $event_id]);
        $request->merge(['user_id' => Auth::id()]);

        DB::transaction(function () use($request) {
            //イベントがキャンセルさせる場合
            if($request->has('ready')) {
                $event = $this->eventService->updateEventStatus($request->event_id, \App\Models\Event::STATUS_READY);
            }elseif($request->has('cancel')){
                $event = $this->eventService->updateEventStatus($request->event_id, \App\Models\Event::STATUS_CANCEL);
                //配信URLを更新する場合
            }elseif($request->has('event_add_user')) {
                $this->eventService->updateEventUserByUserIdAndGameId($request);
            }elseif($request->has('finish')) {
                $event = $this->eventService->updateSwissEventByFinish($request->event_id);
            }
        });

        return redirect('/event/swiss/'.$event_id)->with('flash_message', '保存しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $event_id
     * @return \Illuminate\Http\Response
     */
    public function show($event_id)
    {
        $event = $this->eventService->getEvent($event_id);
        session(['loginAfterRedirectUrl' => env('APP_URL').'/event/swiss/' . $event_id]);

        if(Auth::check()){
            session()->forget('loginAfterRedirectUrl');
        }

        return view('event.swiss.show.show',compact('event'));
    }
}
