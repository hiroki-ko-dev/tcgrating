<?php

namespace App\Http\Controllers\Web\Event;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Mail;
use Illuminate\Http\Request;
use App\Enums\EventStatus;
use App\Enums\EventUserStatus;
use App\Enums\EventUserRole;
use App\Enums\EventUsersAttendance;
use App\Enums\DuelStatus;
use App\Services\EventService;
use App\Services\DuelService;
use App\Services\User\UserService;
use App\Services\Twitter\TwitterService;
use App\Services\ApiService;
use App\Mail\EventSingleJoinRequestMail;

class UserController extends Controller
{
    public function __construct(
        private readonly EventService $eventService,
        private readonly DuelService $duelService,
        private readonly UserService $userService,
        private readonly TwitterService $twitterService,
        private readonly ApiService $apiService
    ) {
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

        DB::transaction(function () use ($request) {

            $event = $this->eventService->findEvent($request->event_id);
            $request->merge(['role'    => EventUserRole::USER->value]);

            if ($event->event_category_id === \App\Models\EventCategory::CATEGORY_SINGLE) {
                // 1vs1対戦ならそのまま対戦も作成
                $request->merge(['status'  => EventUserStatus::APPROVAL->value]);
                $this->eventService->createUser($request) ;
                $this->duelService->createUser($request) ;
                $this->eventService->updateEventStatus($request->event_id, EventStatus::READY->value);
                // 対戦作成者にtwitterアカウントがあれば通知
                if (!is_null($event->user->twitter_id)) {
                    // 更新されたイベントを取得
                    $event = $this->eventService->findEvent($request->event_id);
                    $this->twitterService->tweetByMatching($event);
                }

                // メールアドレスがあれば通知
                if (!is_null($event->user->email)) {
                    Mail::send(new EventSingleJoinRequestMail($event));
                }
            } elseif ($event->event_category_id === \App\Models\EventCategory::CATEGORY_SWISS) {
                // discord名にバリデーションをかける
                $validated = $request->validate(
                    ['discord_name' => 'required|regex:/.+#\d{4}$/|max:255'],
                    ['discord_name.regex' => 'ディスコードの名前は「〇〇#数字4桁」の形式にしてください']
                );

                $request->merge(['game_id'  => $event->game_id]);

                // もしイベント作成ユーザーが選択ゲームでgameUserがなかったら作成
                $gameUser = $this->userService->createGameUser($request->all());
                if ($gameUser->discord_name <> $request->discord_name) {
                    $gameUser->discord_name = $request->discord_name;
                    // discord_nameを更新
                    $gameUser = $this->userService->updateGameUser($event->game_id, $gameUser->toArray());
                }

                $request->merge(['status'  => EventUserStatus::REQUEST->value]);
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

        $message = DB::transaction(function () use ($request) {
            // イベントステータスを変更
            if ($request->has('approval')) {
                $request->merge(['status'  => EventUserStatus::APPROVAL->value]);
                $message = '参加確定にしました';
                $this->eventService->updateEventUserByUserIdAndGameId($request);
            } elseif ($request->has('reject')) {
                $request->merge(['status'  => EventUserStatus::REJECT->value]);
                $message = '参加キャンセルをしました';
                $this->eventService->updateEventUserByUserIdAndGameId($request);
            } elseif ($request->has('attended')) {
                // 出席へステータス変更
                $request->merge(['id' => $request->event_user_id]);
                $request->merge(['attendance' => EventUserAttendance::ATTENDED->value]);
                $message = '出席確定しました';
                $eventUser = $this->eventService->updateEventUser($request);
            }
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
        $request->merge(['status'  => EventUserStatus::APPROVAL->value]);
        $request->merge(['role'    => EventUserRole::USER->value]);

        $message = DB::transaction(function () use ($request) {
            $this->eventService->createUser($request) ;
            $this->duelService->createUser($request) ;

            $event = $this->eventService->findEventWithUserAndDuel($request->event_id);

            // すでにマッチング済ならリダイレクト
            if ($event->status !== EventStatus::RECRUIT->value) {
                return 'すでに別の方がマッチング済です';
            }

            if ($event->event_category_id === \App\Models\EventCategory::CATEGORY_SINGLE) {
                $this->eventService->updateEventStatus($request->event_id, EventStatus::READY->value);
                $this->duelService->updateDuelStatus($event->eventDuels[0]->duel_id, DuelStatus::READY);
            }

            $gameUser = $this->userService->getGameUserByGameIdAndUserId($event->game_id, Auth::id());

            if (is_null($gameUser)) {
                $gameUser = $this->userService->createGameUser($request->all());
            } elseif (isset($gameUser->discord_name) || $gameUser->discord_name <> $request->discord_name) {
                $gameUserAttrs['discord_name'] = $request->discord_name;
                $gameUser = $this->userService->updateGameUser($gameUser->id, $gameUserAttrs);
            }

            // 対戦作成者にtwitterアカウントがあれば通知
            if (!is_null($event->user->twitter_id)) {
                $this->twitterService->tweetByInstantMatching($event->eventDuels[0]->duel);
            }
            // アプリにpush通知を送信
            $this->apiService->duelMatching($event);

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
        $request->merge(['status'  => EventUserStatus::REQUEST->value]);

        if ($request->has('group_id_0')) {
            $request->merge(['group_id' => 0]);
        } elseif ($request->has('group_id_1')) {
            $request->merge(['group_id' => 1]);
        }

        DB::transaction(function () use ($request) {
            $this->eventService->createUser($request) ;
        });

        return back()->with('flash_message', 'イベント参加リクエストを送信しました');
    }
}
