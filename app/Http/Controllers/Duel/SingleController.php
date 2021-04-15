<?php

namespace App\Http\Controllers\Duel;
use App\Http\Controllers\Controller;

use App\Services\DuelService;
use App\Services\PostService;

use Auth;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $duel     = $this->duel_service->findDuelWithUser($id);
        $post     = $this->post_service->findPostByDuelId($duel->id);
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
