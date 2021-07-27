<?php

namespace App\Http\Controllers\Post;
use App\Http\Controllers\Controller;
use App\Services\PostService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;

class PostController extends Controller
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
        // 選択しているゲームでフィルタ
        if(Auth::check()) {
            $request->merge(['game_id' => Auth::user()->selected_game_id]);
        }else{
            $request->merge(['game_id' => session('selected_game_id')]);
        }

        $request->merge(['post_category_id' => $request->query('post_category_id')]);

        $posts =  $this->post_service->getPostAndCommentCountWithPagination($request,20);
        $post_category_id = $request->query('post_category_id');

        return view('post.index',compact('posts','post_category_id'));
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

        //チーム募集掲示板の処理
        if(\App\Models\PostCategory::TEAM_WANTED == $request->post_category_id){
            $team_id = $request->query('team_id');
        }else{
            $team_id = null;
        }

        $post_category_id = $request->query('post_category_id');
        return view('post.create', compact('post_category_id', 'team_id'));
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
        $this->middleware('auth');

        //追加
        // 選択しているゲームでフィルタ
        $request->merge(['game_id' => Auth::user()->selected_game_id]);

        $request->merge(['user_id' => Auth::id()]);
        $request->merge(['is_personal' => 0]);
        //チーム募集掲示板の処理
        $request->merge(['team_id' => $request->team_id]);

        DB::transaction(function () use($request){
            $this->post_service->createPost($request);
        });

        return redirect('/post?post_category_id='.$request->input('post_category_id'))->with('flash_message', '新規投稿を行いました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $post_id
     * @return \Illuminate\Http\Response
     */
    public function show($post_id)
    {
        $post     = $this->post_service->findPostWithUser($post_id);
        $comments = $this->post_service->findAllPostCommentWithUserByPostIdAndPagination($post_id,100);
        return view('post.show',compact('post','comments'));
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
