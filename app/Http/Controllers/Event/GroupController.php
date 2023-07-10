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

class GroupController extends Controller
{

    protected $event_service;
    protected $duel_service;
    protected $user_service;
    protected $twitterService;

    public function __construct(EventService $event_service,
                                DuelService $duel_service,
                                UserService $user_service,
                                TwitterService $twitterService)
    {
        $this->event_service = $event_service ;
        $this->duel_service  = $duel_service ;
        $this->user_service  = $user_service ;
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
        $request->merge(['event_category_id' => \App\Models\EventCategory::CATEGORY_SINGLE]);
        $events = $this->event_service->findAllEventByEventCategoryId($request, 50);

        return view('event.instant.index',compact('events'));
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

        session(['loginAfterRedirectUrl' => env('APP_URL').'/event/group/create']);
        session(['selected_game_id' => 3]);

        return view('event.group.create');
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
        $request->merge(['event_category_id' => \App\Models\EventCategory::CATEGORY_GROUP]);
        $request->merge(['duel_category_id'  => \App\Models\DuelCategory::CATEGORY_SINGLE]);
        $request->merge(['post_category_id'  => \App\Models\PostCategory::CATEGORY_EVENT]);
        $request->merge(['user_id'           => Auth::id()]);
        $request->merge(['number_of_games'   => $request->number_of_games]);
        $request->merge(['max_member'        => $request->max_member]);
        $request->merge(['status'            => \App\Models\EventUser::STATUS_MASTER]);
        $request->merge(['is_personal'       => 0]);

        $event = DB::transaction(function () use($request) {

            $event = $this->event_service->createEvent($request);

            // もしイベント作成ユーザーが選択ゲームでgameUserがなかったら作成
            $this->user_service->createGameUser($request->all());

            return $event;
        });

        return redirect('/event/group/' . $event->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $event_id
     * @return \Illuminate\Http\Response
     */
    public function show($event_id)
    {
        $event = $this->event_service->findEventWithUserAndDuel($event_id);

        return view('event.group.show.show',compact('event'));
    }
}
