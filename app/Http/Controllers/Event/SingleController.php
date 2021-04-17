<?php

namespace App\Http\Controllers\Event;

use DB;
use Auth;

use App\Http\Controllers\Controller;
use App\Services\EventService;
use App\Services\DuelService;
use App\Services\PostService;

use Illuminate\Http\Request;

class SingleController extends Controller
{

    protected $event_service;
    protected $duel_service;
    protected $post_service;

    public function __construct(EventService $event_service,
                                DuelService $duel_service,
                                PostService $post_service)
    {
        $this->event_service = $event_service ;
        $this->duel_service  = $duel_service ;
        $this->post_service  = $post_service ;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $events = $this->event_service->findAllEventAndUserByEventCategoryId(\App\Models\EventCategory::SINGLE, 20);

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

        //追加
        $request->merge(['event_category_id' => \App\Models\EventCategory::SINGLE]);
        $request->merge(['duel_category_id'  => \App\Models\DuelCategory::SINGLE]);
        $request->merge(['post_category_id'  => \App\Models\PostCategory::EVENT]);
        $request->merge(['user_id'           => Auth::id()]);
        $request->merge(['max_member'        => 2]);
        $request->merge(['title'             => '1vs1決闘']);
        $request->merge(['status'            => \App\Models\EventUser::MASTER]);
        $request->merge(['is_personal'       => 0]);

        DB::transaction(function () use($request) {
            $request = $this->event_service->createEventBySingle($request);
            //event用のpostを作成
            $this->post_service->createPost($request);
            $event_id = $request->event_id;

            $request = $this->duel_service->createSingle($request);
            //duel用のpostを作成
            $request->merge(['event_id'=> null]);
            $this->post_service->createPost($request);
        });

        return redirect('/event/single/'.$request->event_id)->with('flash_message', '新規1vs1決闘を作成しました');
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
        $post     = $this->post_service->findPostWithUserByEventId($event_id);
        $comments = $this->post_service->findAllPostCommentWithUserByPostIdAndPagination($post->id,100);

        return view('event.single.show',compact('event','post','comments'));
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
