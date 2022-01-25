<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Mail;

use Illuminate\Http\Request;

use App\Services\EventService;
use App\Services\DuelService;
use App\Services\UserService;
use App\Services\TwitterService;

use App\Mail\EventSingleJoinRequestMail;


class UserController extends Controller
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

        session(['loginAfterRedirectUrl' => url()->previous()]);
        $this->middleware('auth');
    }

    /**
     * 対戦申込に対して、対戦相手が現れたら作成
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ログインしてこのページに入れたらforgetする
        session()->forget('loginAfterRedirectUrl');

        //追加
        $request->merge(['user_id' => Auth::id()]);

        DB::transaction(function () use($request) {

            $event = $this->eventService->getEvent($request->event_id);
            $request->merge(['role'    => \App\Models\EventUser::ROLE_USER]);

            if($event->event_category_id === \App\Models\EventCategory::CATEGORY_SINGLE){
                // 1vs1対戦ならそのまま対戦も作成
                $request->merge(['status'  => \App\Models\EventUser::STATUS_APPROVAL]);
                $this->eventService->createUser($request) ;
                $this->duelService->createUser($request) ;
                $this->eventService->updateEventStatus($request->event_id, \APP\Models\Event::STATUS_READY);
                // 対戦作成者にtwitterアカウントがあれば通知
                if(!is_null($event->user->twitter_id)){
                    // 更新されたイベントを取得
                    $event = $this->eventService->getEvent($request->event_id);
                    $this->twitterService->tweetByMatching($event);
                }

                // メールアドレスがあれば通知
                if(!is_null($event->user->email)){
                    Mail::send(new EventSingleJoinRequestMail($event));
                }

            }elseif($event->event_category_id === \App\Models\EventCategory::CATEGORY_SWISS){

                // discord名にバリデーションをかける
                $validated = $request->validate(
                    ['discord_name' => 'required|regex:/.+#\d{4}$/|max:255'],
                    ['discord_name.regex' => 'ディスコードの名前は「〇〇#数字4桁」の形式にしてください']
                );

                $request->merge(['game_id'  => $event->game_id]);

                // もしイベント作成ユーザーが選択ゲームでgameUserがなかったら作成
                $gameUser = $this->userService->makeGameUser($request);
                if($gameUser->discord_name <> $request->discord_name){
                    $gameUser->discord_name = $request->discord_name;
                    // discord_nameを更新
                    $gameUser = $this->userService->updateGameUser($gameUser);
                }

                $request->merge(['status'  => \App\Models\EventUser::STATUS_REQUEST]);
                $this->eventService->createUser($request) ;
            }

        });

        return back()->with('flash_message', '対戦申込が完了しました');
    }

    /**
     * 対戦申込に対して、対戦相手が現れたら作成
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $event_id)
    {
        // ログインしてこのページに入れたらforgetする
        session()->forget('loginAfterRedirectUrl');
        $request->merge(['event_id' => $event_id]);

        $message = DB::transaction(function () use($request) {
            // イベントステータスを変更
            if($request->has('approval')){
                $request->merge(['status'  => \App\Models\EventUser::STATUS_APPROVAL]);
                $message = '参加確定にしました';
            }elseif($request->has('reject')){
                $request->merge(['status'  => \App\Models\EventUser::STATUS_REJECT]);
                $message = '参加キャンセルをしました';
            }
            $this->eventService->updateEventUserByUserIdAndGameId($request);
            return $message;
        });

        return back()->with('flash_message', $message);
    }

    /**
     * 対戦申込に対して、対戦相手が現れたら作成
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function instant(Request $request)
    {
        // ログインしてこのページに入れたらforgetする
        session()->forget('loginAfterRedirectUrl');

        // バリデーションを設定
        $validated = $request->validate(
            ['discord_name' => 'required|regex:/.+#\d{4}$/|max:255'],
            ['discord_name.regex' => 'ディスコードの名前は「〇〇#数字4桁」の形式にしてください']
        );

        //追加
        $request->merge(['user_id' => Auth::id()]);
        $request->merge(['status'  => \App\Models\EventUser::STATUS_APPROVAL]);
        $request->merge(['role'    => \App\Models\EventUser::ROLE_USER]);

        $message = DB::transaction(function () use($request) {
            $this->eventService->createUser($request) ;
            $this->duelService->createUser($request) ;

            $event = $this->eventService->findEventWithUserAndDuel($request->event_id);

            // すでにマッチング済ならリダイレクト
            if($event->status <> \App\Models\Event::STATUS_RECRUIT){
                return 'すでに別の方がマッチング済です';
            }

            if($event->event_category_id === \App\Models\EventCategory::CATEGORY_SINGLE){
                $this->eventService->updateEventStatus($request->event_id, \APP\Models\Event::STATUS_READY);
            }

            $gameUser = $this->userService->getGameUserByUserIdAndGameId(Auth::id(), $event->game_id);

            if(is_null($gameUser)){
                $request->merge(['game_id'  => $event->game_id]);
                $request->merge(['discord_name' => $request->discord_name]);
                $gameUser = $this->userService->makeGameUser($request);
            }elseif(isset($gameUser->discord_name) || $gameUser->discord_name <> $request->discord_name){
                // もしイベント作成ユーザーが選択ゲームでgameUserがなかったら作成
                $gameUser->discord_name = $request->discord_name;
                // discord_nameを更新
                $gameUser = $this->userService->updateGameUser($gameUser);
            }

            // 対戦作成者にtwitterアカウントがあれば通知
            if(!is_null($event->user->twitter_id)){
                $this->twitterService->tweetByInstantMatching($event->eventDuels[0]->duel);
            }

            return '対戦申込が完了しました';

        });

        return back()->with('flash_message', $message);

    }

    /**
     * イベントへの参加リクエストを送信
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function joinRequest(Request $request)
    {
        // ログインしてこのページに入れたらforgetする
        session()->forget('loginAfterRedirectUrl');

        //追加
        $request->merge(['user_id' => Auth::id()]);
        $request->merge(['status'  => \App\Models\EventUser::STATUS_REQUEST]);

        if($request->has('group_id_0')){
            $request->merge(['group_id' => 0]);
        }elseif($request->has('group_id_1')){
            $request->merge(['group_id' => 1]);
        }

        DB::transaction(function () use($request) {
            $this->eventService->createUser($request) ;
        });

        return back()->with('flash_message', 'イベント参加リクエストを送信しました');
    }

}
