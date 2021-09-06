<?php

namespace App\Http\Controllers\Duel;
use App\Http\Controllers\Controller;

use App\Services\DuelService;
use App\Services\PostService;
use App\Services\TwitterService;

use Auth;
use DB;

use Illuminate\Http\Request;

class SingleController extends Controller
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

        //アカウント認証しているユーザーのみ新規作成可能
        $this->middleware('auth');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $request->merge(['user_id'=> Auth::id()]);
            $duel = DB::transaction(function () use($request) {
                $duel = $this->duel_service->findDuelWithUserAndEvent($request->duel_id);
                $request->merge(['duel'=> $duel]);
                $request->merge(['event_id'=> $duel->eventDuel->event->id]);
                $this->duel_service->createSingleResult($request);

                //updateSingleDuelByFinishでcreateSingleResultを反映したduelが欲しいので再取得
                $duel = $this->duel_service->findDuelWithUserAndEvent($request->duel_id);
                $request->merge(['duel'=> $duel]);
                $this->duel_service->updateSingleDuelByFinish($request);
                return $duel;
            });

            //試合が終了したらイベントページに戻す
            if($request->has('message')){
                // twitterで試合が終了したことを通知
                if($request->message == '試合が終了しました'){
                    $this->twitterService->tweetByDuelFinish($duel);
                }

                return redirect('/event/single/'.$request->event_id)->with('flash_message', $request->message);
            }

            //次の試合のため、決闘ページへ
            return back()->with('flash_message', '次の試合を初めてください');

        } catch (\Exception $e) {
            report($e);
            return back()->with('flash_message', $e->getMessage());
        }

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
        $post     = $this->post_service->findPostWithUserByDuelId($duel->id);
        $comments = $this->post_service->findAllPostCommentWithUserByPostIdAndPagination($post->id,100);

        if(empty($duel->duelUsers->where('user_id',Auth::id())->first()->id)){
            return back()->with('flash_message', '決闘ページへ行けるのは対戦を行うユーザーのみです');
        }

        return view('duel.single.show',compact('duel','post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $duel = $this->duel_service->findDuelWithUserAndEvent($id);

        return view('duel.single.edit',compact('duel'));
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
        $this->duel_service->updateDuel($request);
        $duel = $this->duel_service->findDuelWithUserAndEvent($id);

        return redirect('event/single/'.$duel->eventDuel->event_id)->with('flash_message', '保存しました');
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
