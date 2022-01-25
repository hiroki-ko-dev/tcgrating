<?php

namespace App\Http\Controllers\Event;

use DB;
use Auth;
use Mail;

use App\Http\Controllers\Controller;
use App\Services\EventService;
use App\Services\DuelService;
use App\Services\PostService;
use App\Services\UserService;
use App\Services\TwitterService;

//use App\Mail\AdminNoticeCreateEventSingleMail;
use App\Mail\EventSingleCreateMail;

use Illuminate\Http\Request;

class SingleController extends Controller
{

    protected $event_service;
    protected $duel_service;
    protected $post_service;
    protected $user_service;
    protected $twitterService;

    public function __construct(EventService $event_service,
                                DuelService $duel_service,
                                PostService $post_service,
                                UserService $user_service,
                                TwitterService $twitterService)
    {
        $this->event_service = $event_service ;
        $this->duel_service  = $duel_service ;
        $this->post_service  = $post_service ;
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
        $request->merge(['not_body' => 'LINEからの対戦作成']);
        $request->merge(['event_category_id' => \App\Models\EventCategory::CATEGORY_SINGLE]);
        $events = $this->event_service->findAllEventByEventCategoryId($request, 50);

        return view('event.single.index',compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //アカウント認証しているユーザーのみ新規作成可能
        if(!Auth::check()){
            return back()->with('flash_message', '新規決闘作成を行うにはログインしてください');
        }

        if(Auth::user()->selected_game_id == config('assets.site.game_ids.pokemon_card')) {
            return redirect('/event/instant/create');
        }

        return view('event.single.create');
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

        if(Auth::user()->selected_game_id == config('assets.site.game_ids.pokemon_card')) {
            return redirect('/event/instant/create');
        }

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
        $request->merge(['status'            => \App\Models\EventUser::STATUS_APPROVAL]);
        $request->merge(['role'              => \App\Models\EventUser::ROLE_ADMIN]);
        $request->merge(['is_personal'       => 0]);

        $request->merge(['match_number'      => 1]);

        $event_id = DB::transaction(function () use($request) {

            $event = $this->event_service->createEvent($request);
            //event用のpostを作成
            $request->merge(['event_id' => $event->id]);

            $request->merge(['body' => '1vs1対戦に関する質問・雑談をコメントしましょう']);
            $this->post_service->createPost($request);
            $event_id = $request->event_id;

            $request->merge(['status' => \App\Models\Duel::STATUS_READY]);
            $request = $this->duel_service->createSingle($request);
            //duel用のpostを作成
            $request->merge(['post_category_id'  => \App\Models\PostCategory::CATEGORY_DUEL]);
            $request->merge(['event_id' => null]);
            $request->merge(['body' => 'この掲示板は自分と対戦相手のみ見えます。対戦についてコミュニケーションをとりましょう']);
            $this->post_service->createPost($request);
//            Mail::send(new AdminNoticeCreateEventSingleMail('/event/single/'.$event_id));

            // もしイベント作成ユーザーが選択ゲームでgameUserがなかったら作成
            $this->user_service->makeGameUser($request);

            //twitterに投稿
            $this->twitterService->tweetByMakeEvent($event);

            $users = $this->user_service->findAllUserBySendMail($request);
            Mail::send(new EventSingleCreateMail($event, $users));
            return $event_id;
        });

        return redirect('/event/single/'.$event_id)->with('flash_message', '新規1vs1対戦を作成しました');
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

        //アカウント認証しているユーザーのみ新規作成可能
        if($event->game_id == config('assets.site.game_ids.pokemon_card')) {
            return redirect('/duel/instant/'.$event->eventDuels[0]->duel_id);
        }

        $post     = $this->post_service->findPostWithUserByEventId($event_id);
        $comments = $this->post_service->findAllPostCommentWithUserByPostIdAndPagination($post->id,100);

        return view('event.single.show',compact('event','post','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $event_id
     * @return \Illuminate\Http\Response
     */
    public function edit($event_id)
    {
        $event = $this->event_service->findEventWithUserAndDuel($event_id);

        return view('event.single.edit',compact('event'));
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
            if($request->has('event_cancel')){
                $event = $this->event_service->updateEventStatus($request->event_id, \App\Models\Event::STATUS_CANCEL);
                $this->duel_service->updateDuelStatus($event->eventDuels[0]->duel_id, \App\Models\Duel::STATUS_CANCEL);
            //配信URLを更新する場合
            }elseif($request->has('event_add_user')) {
                $this->event_service->updateEventUserByUserIdAndGameId($request);
            }
        });

        return redirect('/event/single/'.$event_id)->with('flash_message', '保存しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
