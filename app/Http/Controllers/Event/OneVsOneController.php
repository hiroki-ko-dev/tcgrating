<?php

namespace App\Http\Controllers\Event;

use Auth;

use App\Http\Controllers\Controller;
use App\Services\EventService;

use Illuminate\Http\Request;

class OneVsOneController extends Controller
{

    protected $event_service;

    public function __construct(EventService $event_service)
    {
        $this->event_service = $event_service;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $events = $this->event_service->findAllEventAndUserByEventCategoryId(\App\Models\EventCategory::ONE_VS_ONE, 20);

        return view('event.one_vs_one.index',compact('events'));
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

        return view('event.one_vs_one.create');
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
        $request->merge(['user_id' => Auth::id()]);
        DB::transaction(function () use($request) {
            $this->event_service->createEventByOneVsOneAndRequest($request);
        });

        return redirect('/event/one_vs_one')->with('flash_message', '新規チームを作成しました');
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
