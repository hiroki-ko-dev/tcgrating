<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;

use App\Mail\AdminNoticeCreateEventSingleMail;
use DB;
use Auth;
use Mail;

use App\Services\DuelService;
use App\Services\EventService;
use App\Services\PostService;
use Illuminate\Http\Request;

class PointController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = $this->event_service->findAllEventAndUserByEventCategoryId(\App\Models\EventCategory::POINT, 20);

        return view('event.point.index',compact('events'));
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

        return view('event.point.create');
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
        $request->merge(['event_category_id' => \App\Models\EventCategory::POINT]);
        $request->merge(['duel_category_id'  => \App\Models\DuelCategory::POINT]);
        $request->merge(['post_category_id'  => \App\Models\PostCategory::EVENT]);
        $request->merge(['user_id'           => Auth::id()]);
        $request->merge(['number_of_games'   => 1]);
        $request->merge(['title'             => 'ポイントバトル決闘']);
        $request->merge(['status'            => \App\Models\EventUser::MASTER]);
        $request->merge(['is_personal'       => 0]);

        $event_id = DB::transaction(function () use($request) {
            $request = $this->event_service->createEventBySingle($request);
            //event用のpostを作成
            $request->merge(['body' => 'ポイントバトル決闘に関する質問・雑談をコメントしましょう']);
            $this->post_service->createPost($request);
            $event_id = $request->event_id;

            $request->merge(['status' => \App\Models\Duel::READY]);
            $request = $this->duel_service->createSingle($request);
            //duel用のpostを作成
            $request->merge(['event_id' => null]);
            $request->merge(['body' => 'この掲示板は自分と対戦相手のみ見えます。対戦についてコミュニケーションをとりましょう']);
            $this->post_service->createPost($request);
            Mail::send(new AdminNoticeCreateEventSingleMail('/event/point/'.$event_id));
            return $event_id;
        });

        return redirect('/event/point/'.$event_id)->with('flash_message', '新規ポイントバトル決闘を作成しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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