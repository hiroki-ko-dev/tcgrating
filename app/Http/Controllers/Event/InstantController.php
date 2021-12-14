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

use Illuminate\Http\Request;

class InstantController extends Controller
{

    protected $event_service;
    protected $duel_service;
    protected $user_service;

    public function __construct(EventService $event_service,
                                DuelService $duel_service,
                                UserService $user_service)
    {
        $this->event_service = $event_service ;
        $this->duel_service  = $duel_service ;
        $this->user_service  = $user_service ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        session(['loginAfterRedirectUrl' => env('APP_URL').'/event/instant/create']);

        return view('event.instant.create');
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

        $date = Carbon::now();

        // 選択しているゲームでフィルタ
        $request->merge(['game_id' => Auth::user()->selected_game_id]);
        $request->merge(['event_category_id' => \App\Models\EventCategory::SINGLE]);
        $request->merge(['duel_category_id'  => \App\Models\DuelCategory::SINGLE]);
        $request->merge(['post_category_id'  => \App\Models\PostCategory::EVENT]);
        $request->merge(['user_id'           => Auth::id()]);
        $request->merge(['max_member'        => 2]);
        $request->merge(['title'             => '1vs1対戦']);
        $request->merge(['status'            => \App\Models\EventUser::MASTER]);
        $request->merge(['is_personal'       => 1]);

        $request->merge(['body'       => 'LINEからの対戦作成']);
        $request->merge(['date'       => $date]);
        $request->merge(['start_time' => $date]);

        $request->merge(['number_of_games' => 1]);

        $duel_id = DB::transaction(function () use($request) {

            $event = $this->event_service->createEventBySingle($request);
            //event用のpostを作成
            $request->merge(['event_id' => $event->id]);

            $request->merge(['status' => \App\Models\Duel::READY]);
            $request = $this->duel_service->createSingle($request);

            // もしイベント作成ユーザーが選択ゲームでgameUserがなかったら作成
            $this->user_service->makeGameUser($request);
            return $request->duel_id;
        });

        return redirect('/duel/instant/'.$duel_id);
    }
}
