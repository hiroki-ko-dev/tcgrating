<?php

namespace App\Http\Controllers\Event;

use Carbon\Carbon;
use DB;
use Auth;
use Mail;
use App\Http\Controllers\Controller;
use App\Enums\EventStatus;
use App\Enums\EventUserStatus;
use App\Enums\EventUserRole;
use App\Enums\EventUsersAttendance;
use App\Services\EventService;
use App\Services\DuelService;
use App\Services\User\UserService;
use App\Services\TwitterService;
use Illuminate\Http\Request;

class SwissController extends Controller
{
    public function __construct(
        private readonly EventService $eventService,
        private readonly DuelService $duelService,
        private readonly UserService $userService,
        private readonly TwitterService $twitterService
    ) {
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

        $event = new \App\Models\Event();

        //大会概要文
        $event->body =
          'リモートポケカでスイスドロー大会を開催したいと思います。' . PHP_EOL .
          '■参加方法' . PHP_EOL .
          '・参加希望者は下の申し込みボタンから参加申し込みをお願いします。' . PHP_EOL .
          '・参加者の最終決定は○月○日 ○時ごろDiscordの「大会連絡用」チャンネルに通知予定です' . PHP_EOL .
          PHP_EOL .
          '■運営方法' . PHP_EOL .
          '・参加確定者は本サイト専用Discordの「大会連絡用」チャンネルにてご連絡させていただきます。' . PHP_EOL .
          PHP_EOL .
          '■スケジュール' . PHP_EOL .
          '・○月○日 ○時　参加申し込み締め切り　※Discord大会連絡用チャンネルで詳細連絡' . PHP_EOL .
          '・○月○日（当日）' . PHP_EOL .
          '　- 19:00〜19:05 1回線組合せ発表' . PHP_EOL .
          '　- 19:05〜19:45 1回線' . PHP_EOL .
          '　- 19:45〜19:50 2回線組合せ発表' . PHP_EOL .
          '　- 19:50〜20:30 2回線' . PHP_EOL .
          '　- 20:30〜20:35 3回線組合せ発表' . PHP_EOL .
          '　- 20:35〜21:15 3回線';

        $request = new Request();
        $request->merge(['start_date' => Carbon::now()->startOfMonth()->toDateString()]);
        $request->merge(['end_date' => Carbon::now()->endOfMonth()->toDateString()]);
        $eventsJson = $this->eventService->getEventsJsonsForFullCalendar($request);

        return view('event.swiss.create', compact('event','eventsJson'));
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
        if (!Auth::check()) {
            return back()->with('flash_message', '新規決闘作成を行うにはログインしてください');
        }

        // 選択しているゲームでフィルタ
        $request->merge(['game_id' => Auth::user()->selected_game_id]);
        $request->merge(['event_category_id' => \App\Models\EventCategory::CATEGORY_SWISS]);
        $request->merge(['user_id'           => Auth::id()]);

        $request->merge(['number_of_match'   => $request->number_of_match]);
        $request->merge(['now_match_number'   => 0]);

        $request->merge(['max_member'        => $request->max_member]);
        $request->merge(['status'            => EventUserStatus::APPROVAL->value]);
        $request->merge(['role'              => EventUserRole::ADMIN->value]);
        $request->merge(['is_personal'       => 0]);

        $event = DB::transaction(function () use($request) {

            $event = $this->eventService->createEvent($request);

            // もしイベント作成ユーザーが選択ゲームでgameUserがなかったら作成
            $this->userService->createGameUser($request->all());

            //twitterに投稿
            $this->twitterService->tweetBySwissEvent($event, 'create');

            return $event;
        });

        return redirect('/event/swiss/' . $event->id);
    }

    /**
     * @param $event_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function edit($event_id)
    {
        $event = $this->eventService->getEvent($event_id);

        //ログインしていないとリダイレクト
        if(!Auth::user()->can('eventRole',$event_id)) {
            return redirect('/');
        }

        $request = new Request();
        $request->merge(['start_date' => Carbon::now()->startOfMonth()->toDateString()]);
        $request->merge(['end_date' => Carbon::now()->endOfMonth()->toDateString()]);
        $eventsJson = $this->eventService->getEventsJsonsForFullCalendar($request);

        return view('event.swiss.edit', compact('event', 'eventsJson'));
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
            if($request->has('save')){
                // イベント編集時
                $event = $this->eventService->updateEvent($request);
            }elseif($request->has('ready')) {
                // 参加締め切りする場合
                $event = $this->eventService->updateEventStatus($request->event_id, EventStatus::READY->value);

            }elseif($request->has('cancel')){
                // イベントがキャンセルさせる場合
                $event = $this->eventService->updateEventStatus($request->event_id, EventStatus::CANCEL->value);

            }elseif($request->has('finish')) {
                // イベント完了時
                $event = $this->eventService->updateSwissEventByFinish($request->event_id);
                $this->twitterService->tweetBySwissEvent($event, 'finish');

            }elseif($request->has('event_add_user')) {
                // 参加者からの参加申し込み
                $this->eventService->updateEventUserByUserIdAndGameId($request);

            }elseif($request->has('start_attendance')) {
                // 出席取り開始
                $request->merge(['attendance' => EventUserAttendance::READY->value]);
                $eventUsers = $this->eventService->updateSwissEventUsersAttendance($request);
                $this->twitterService->tweetBySwissEvent($eventUsers[0]->event, 'attendance');

            }elseif($request->has('end_attendance')) {
                // 出席取り終了
                $request->merge(['attendance' => EventUserAttendance::ABSENT->value]);
                $eventUsers = $this->eventService->updateSwissEventUsersAttendance($request);
            }elseif($request->has('finish')) {
                // イベント完了時
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
