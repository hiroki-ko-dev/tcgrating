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
    protected $postService;
    protected $twitterService;

    public function __construct(DuelService $duelService,
                                PostService $postService,
                                TwitterService $twitterService)
    {
        $this->duelService = $duelService ;
        $this->postService = $postService ;
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
        $duel     = $this->duelService->findDuelWithUserAndEvent($duel_id);
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

            $message = DB::transaction(function () use($request) {
                $duel = $this->duelService->findDuelWithUserAndEvent($request->duel_id);
                $request->merge(['duel'=> $duel]);
                $request->merge(['event_id'=> $duel->eventDuel->event->id]);

                // 対戦が完了したらステータスを更新
                if($request->has('finish')){
                    $this->duelService->updateDuelByFinish($request);
                    $message = '試合が完了しました';
                }else {
                    // 対戦完了ボタンでなければレートを更新
                    $this->duelService->createInstantResult($request);
                    $message = '連続で試合ができます。対戦完了の場合はボタンを押してください';
                }

                return $message;
            });

            return redirect('/duel/instant/'.$request->duel_id)->with('flash_message', $message);


        } catch (\Exception $e) {
            report($e);
            return back()->with('flash_message', $e->getMessage());
        }
    }

}
