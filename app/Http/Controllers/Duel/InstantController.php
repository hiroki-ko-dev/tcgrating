<?php

namespace App\Http\Controllers\Duel;
use App\Http\Controllers\Controller;

use App\Services\DuelService;
use App\Services\PostService;
use App\Services\TwitterService;

use Auth;
use DB;

use Illuminate\Http\Request;

class InstantController extends Controller
{

    protected $duel_service;
    protected $post_service;
    protected $twitterService;

    public function __construct(DuelService $duel_service,
                                PostService $post_service,
                                TwitterService $twitterService)
    {
        $this->duel_service = $duel_service ;
        $this->post_service = $post_service ;
        $this->twitterService = $twitterService;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $duel_id
     * @return \Illuminate\Http\Response
     */
    public function show($duel_id)
    {
        $duel     = $this->duel_service->findDuelWithUserAndEvent($duel_id);
        session(['loginAfterRedirectUrl' => env('APP_URL').'/duel/instant/'.$duel_id]);

        return view('duel.instant.show',compact('duel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->merge(['user_id'=> Auth::id()]);

            $duel = DB::transaction(function () use($request) {
                $duel = $this->duel_service->findDuelWithUserAndEvent($request->duel_id);

                // すでにステータス変更されていたらreturnする
                if($duel->status <> \App\Models\Duel::READY){
                    return back()->with('flash_message','すでに試合終了報告されています');
                }

                $request->merge(['duel'=> $duel]);
                $request->merge(['event_id'=> $duel->eventDuel->event->id]);
                $this->duel_service->createInstantResult($request);

                //updateSingleDuelByFinishでcreateSingleResultを反映したduelが欲しいので再取得
                $duel = $this->duel_service->findDuelWithUserAndEvent($request->duel_id);
                $request->merge(['duel'=> $duel]);
                $this->duel_service->updateSingleDuelByFinish($request);
                return $duel;
            });

            return redirect('/duel/instant/'.$duel->id)->with('flash_message', '試合が完了しました');


        } catch (\Exception $e) {
            report($e);
            return back()->with('flash_message', $e->getMessage());
        }
    }

}
