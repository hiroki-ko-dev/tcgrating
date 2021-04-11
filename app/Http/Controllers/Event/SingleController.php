<?php

namespace App\Http\Controllers\Event;

use DB;
use Auth;

use App\Http\Controllers\Controller;
use App\Services\EventService;
use App\Services\DuelService;
use App\Services\UserService;

use Illuminate\Http\Request;

class SingleController extends Controller
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
        $request->merge(['user_id'           => Auth::id()]);
        $request->merge(['max_member'        => 2]);
        $request->merge(['title'             => '1vs1決闘']);
        $request->merge(['status'            => \App\Models\EventUser::MASTER]);

        DB::transaction(function () use($request) {
            $request = $this->event_service->createEventBySingleAndRequest($request);
            $this->duel_service->createSingleByRequest($request);
        });

        dd('aa');

        return redirect('/event/single')->with('flash_message', '新規チームを作成しました');
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
