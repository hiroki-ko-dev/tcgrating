<?php

namespace App\Http\Controllers\Duel;
use App\Http\Controllers\Controller;

use App\Services\DuelService;
use App\Services\PostService;

use Auth;
use DB;

use Illuminate\Http\Request;

class SingleController extends Controller
{

    protected $duel_service;
    protected $post_service;

    public function __construct(DuelService $duel_service,
                                PostService $post_service)
    {
        $this->duel_service = $duel_service ;
        $this->post_service = $post_service ;

        //アカウント認証しているユーザーのみ新規作成可能
        $this->middleware('auth');
    }


    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
//        try {
            $request->merge(['user_id'=> Auth::id()]);
            DB::transaction(function () use($request) {
                $duel = $this->duel_service->findDuelWithUserAndEvent($request->duel_id);
                $request->merge(['duel'=> $duel]);
                $request->merge(['event_id'=> $duel->eventDuel->event->id]);
                $this->duel_service->createSingleResult($request);

                //updateSingleDuelByFinishでcreateSingleResultを反映したduelが欲しいので再取得
                $duel = $this->duel_service->findDuelWithUserAndEvent($request->duel_id);
                $request->merge(['duel'=> $duel]);
                $this->duel_service->updateSingleDuelByFinish($request);
            });

            //試合が終了したらイベントページに戻す
            if($request->has('message')){
                return redirect('/event/single/'.$request->event_id)->with('flash_message', $request->message);
            }

            //次の試合のため、決闘ページへ
            return back()->with('flash_message', '次の試合を初めてください');

//        } catch (\Exception $e) {
//            report($e);
//            return back()->with('flash_message', $e->getMessage());
//        }

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

        if(empty($duel->duelUser->where('user_id',Auth::id())->first()->id)){
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
