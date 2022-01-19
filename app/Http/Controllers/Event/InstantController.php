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

class InstantController extends Controller
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
        $request->merge(['event_category_id' => \App\Models\EventCategory::CATEGORY_SINGLE]);
        $events = $this->eventService->findAllEventByEventCategoryId($request, 50);

        return view('event.instant.index',compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        session(['loginAfterRedirectUrl' => env('APP_URL').'/event/instant/create']);
        session(['selected_game_id' => 3]);

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

        // discord名にバリデーションをかける
        $validated = $request->validate(
            ['discord_name' => 'required|regex:/.+#\d{4}$/|max:255'],
            ['discord_name.regex' => 'ディスコードの名前は「〇〇#数字4桁」の形式にしてください']
        );

        $date = Carbon::now();

        // 選択しているゲームでフィルタ
        $request->merge(['game_id' => Auth::user()->selected_game_id]);
        $request->merge(['event_category_id' => \App\Models\EventCategory::CATEGORY_SINGLE]);
        $request->merge(['duel_category_id'  => \App\Models\DuelCategory::CATEGORY_SINGLE]);
        $request->merge(['post_category_id'  => \App\Models\PostCategory::CATEGORY_EVENT]);
        $request->merge(['user_id'           => Auth::id()]);
        $request->merge(['number_of_match'   => 1]);
        $request->merge(['now_match_number'  => 1]);
        $request->merge(['max_member'        => 2]);
        $request->merge(['title'             => '1vs1対戦']);
        $request->merge(['status'            => \App\Models\EventUser::STATUS_MASTER]);
        $request->merge(['is_personal'       => 1]);

        $request->merge(['body'       => 'LINEからの対戦作成']);
        $request->merge(['date'       => $date]);
        $request->merge(['start_time' => $date]);

        $request->merge(['number_of_games'   => 1]);
        $request->merge(['match_number'      => 1]);

        $duel_id = DB::transaction(function () use($request) {

            $event = $this->eventService->createEvent($request);
            //event用のpostを作成
            $request->merge(['event_id' => $event->id]);

            $request->merge(['status' => \App\Models\Duel::STATUS_READY]);
            $request = $this->duelService->createInstant($request);

            // もしイベント作成ユーザーが選択ゲームでgameUserがなかったら作成
            $gameUser = $this->userService->makeGameUser($request);
            if($gameUser->discord_name <> $request->discord_name){
                $gameUser->discord_name = $request->discord_name;
                // discord_nameを更新
                $gameUser = $this->userService->updateGameUser($gameUser);
            }

            //twitterに投稿
            $this->twitterService->tweetByMakeInstantEvent($event);

            return $request->duel_id;
        });

        return redirect('/duel/instant/'.$duel_id);
    }
}
