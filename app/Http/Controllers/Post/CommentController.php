<?php

namespace App\Http\Controllers\Post;
use App\Http\Controllers\Controller;
use App\Services\PostService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;

class CommentController extends Controller
{
    protected $post_service;

    public function __construct(PostService $post_service)
    {
        $this->post_service = $post_service;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        //アカウント認証しているユーザーのみ新規作成可能
        if(!Auth::check()){
            return back()->with('flash_message', '新規投稿を行うにはログインしてください');
        }

        $post_category_id = $request->query('post_category_id');
        return view('post.create', compact('post_category_id'));
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
            return back()->with('flash_message', 'コメントを行うにはログインをしてください');
        }

        //追加
        $request->merge(['user_id' => Auth::guard()->user()->id]);

        DB::transaction(function () use($request) {
            $this->post_service->createComment($request);
        });

        if($request->has('event_id')){
            return redirect('/event/single/'.$request->input('event_id'))->with('flash_message', '新規投稿を行いました');
        }

        return redirect('/post/'.$request->input('post_id'))->with('flash_message', '新規投稿を行いました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $post_id
     * @return \Illuminate\Http\Response
     */
    public function show($post_id)
    {
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
