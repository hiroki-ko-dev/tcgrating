<?php

namespace App\Http\Controllers\Web\Blog;

use App\Http\Controllers\Controller;
use App\Services\Post\PostService;
use App\Services\EventService;
use App\Services\DuelService;
use App\Services\User\UserService;
use App\Services\Twitter\TwitterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use Mail;
use App\Mail\PostCommentEventMail;
use App\Mail\PostCommentDuelMail;

class CommentsController extends Controller
{
    protected $post_service;
    protected $event_service;
    protected $duel_service;
    protected $user_service;
    protected $twitterService;

    public function __construct(PostService $post_service,
                                EventService $event_service,
                                DuelService $duel_service,
                                UserService $user_service,
                                TwitterService $twitterService)
    {
        $this->post_service  = $post_service;
        $this->event_service = $event_service ;
        $this->duel_service  = $duel_service ;
        $this->user_service  = $user_service ;
        $this->twitterService = $twitterService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        //アカウント認証しているユーザーのみ新規作成可能
        if(!Auth::check()){
            return back()->with('flash_message', '新規投稿を行うにはログインしてください');
        }

        $post_category_id = $request->query('post_category_id');
        return view('post.create', compact('post_category_id'));
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
            return back()->with('flash_message', 'コメントを行うにはログインをしてください');
        }

        //追加
        $request->merge(['user_id' => Auth::guard()->user()->id]);

        DB::transaction(function () use ($request) {
            $comment = $this->post_service->createComment($request->all());

            $post = $this->post_service->findPostWithUser($request->post_id);

            //書き込みがイベント掲示板ならコメントがついたことをコメント者以外にメール通知
            if($post->post_category_id == \App\Models\PostCategory::CATEGORY_EVENT) {
                $event = $this->event_service->findEventWithUserAndDuel($post->event_id);
                //コメントをした本人以外に通知を送る
                $eventUsers = $event->eventUsers->whereNotIn('user_id', [Auth::id()]);
                $emails = [];
                $usersForTweet  = [];
                foreach ($eventUsers as $eventUser) {
                    if(!is_null($eventUser->user->email)) {
                        $emails[] = $eventUser->user->email;
                    }
                    if(!is_null($event->user->twitter_id)) {
                        $usersForTweet[] = $eventUser->user;
                    }
                }

                // 対戦作成者にtwitterアカウントがあれば通知
                if(!is_null($usersForTweet)){
                    $this->twitterService->tweetByEventPostNotice($event, $usersForTweet);
                }

                if(!empty($emails)) {
                    Mail::send(new PostCommentEventMail($emails, $post, $comment));
                }
            //書き込みが決闘掲示板ならコメントがついたことをコメント者以外にメール通知
            }elseif($post->post_category_id == \App\Models\PostCategory::CATEGORY_DUEL){
                $duel = $this->duel_service->getDuel($post->duel_id);
                //コメントをした本人以外に通知を送る
                $duelUsers = $duel->duelUsers->whereNotIn('user_id',[Auth::id()]);
                $emails = [];
                $usersForTweet  = [];
                foreach($duelUsers as $duelUser){
                    if(!is_null($duelUser->user->email)){
                        $emails[] = $duelUser->user->email;
                    }
                    if(!is_null($duelUser->user->twitter_id)) {
                        $usersForTweet[] = $duelUser->user;
                    }
                }

                // 対戦作成者にtwitterアカウントがあれば通知
                if(!is_null($usersForTweet)){
                    $this->twitterService->tweetByDuelPostNotice($duel, $usersForTweet);
                }

                if(!empty($emails)) {
                    Mail::send(new PostCommentDuelMail($emails, $post, $comment));
                }
            }
        });

        return back()->with('flash_message', '新規投稿を行いました');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $post_id
     * @return \Illuminate\Http\Response
     */
    public function show($post_id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
