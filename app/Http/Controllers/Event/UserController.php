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
        $request->merge(['status'  => \App\Models\EventUser::APPROVAL]);

        DB::transaction(function () use($request) {
            $this->event_service->createUser($request) ;
            $this->duel_service->createUser($request) ;

            $event = $this->event_service->findEventWithUserAndDuel($request->event_id);
            if($event->event_category_id === \App\Models\EventCategory::SINGLE){
                $this->event_service->updateEventStatus($request->event_id, \APP\Models\Event::READY);
            }


            // 対戦作成者にtwitterアカウントがあれば通知
            if(!is_null($event->user->twitter_id)){
                $this->twitterService->tweetByMatching($event);
            }

            // メールアドレスがあれば通知
            if(!is_null($event->user->email)){
                Mail::send(new EventSingleJoinRequestMail($event));
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
    public function instant(Request $request)
    {
        // ログインしてこのページに入れたらforgetする
        session()->forget('loginAfterRedirectUrl');

        //追加
        $request->merge(['user_id' => Auth::id()]);
        $request->merge(['status'  => \App\Models\EventUser::APPROVAL]);

        DB::transaction(function () use($request) {
            $this->event_service->createUser($request) ;
            $this->duel_service->createUser($request) ;

            $event = $this->event_service->findEventWithUserAndDuel($request->event_id);
            if($event->event_category_id === \App\Models\EventCategory::SINGLE){
                $this->event_service->updateEventStatus($request->event_id, \APP\Models\Event::READY);
            }

            // 対戦作成者にtwitterアカウントがあれば通知
            if(!is_null($event->user->twitter_id)){
                $this->twitterService->tweetByMatching($event);
            }

            // メールアドレスがあれば通知
            if(!is_null($event->user->email)){
                Mail::send(new EventSingleJoinRequestMail($event));
            }

        });

        return back()->with('flash_message', '対戦申込が完了しました');


    }

}
