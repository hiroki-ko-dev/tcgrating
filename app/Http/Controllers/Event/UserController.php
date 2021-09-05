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

use App\Mail\EventSingleJoinRequestMail;


class UserController extends Controller
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

        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

            if(!is_null($event->user->email)){
                Mail::send(new EventSingleJoinRequestMail($event));
            }

        });

        return back()->with('flash_message', '対戦申込が完了しました');


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
