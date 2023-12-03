<?php

namespace App\Http\Controllers\Web\Team;

use DB;
use App\Http\Controllers\Controller;
use App\Services\TeamService;
use App\Services\Post\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    protected $team_service;
    protected $post_service;

    public function __construct(TeamService $team_service,
                                PostService $post_service)
    {
        $this->team_service = $team_service;
        $this->post_service = $post_service;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // 選択しているゲームでフィルタ
        if(Auth::check()) {
            $request->merge(['game_id' => Auth::user()->selected_game_id]);
        }else{
            $request->merge(['game_id' => session('selected_game_id')]);
        }
        $teams = $this->team_service->findAllTeamByRequestAndPaginate($request, 20);

        return view('team.index',compact('teams'));
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
            return back()->with('flash_message', '新規チーム作成を行うにはログインしてください');
        }

        return view('team.create');
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
            return back()->with('flash_message', '新規チーム作成を行うにはログインしてください');
        }

        //追加
        $request->merge(['user_id' => Auth::id()]);
        DB::transaction(function () use($request) {
            $request->merge(['status'  => \App\Models\TeamUser::REQUEST]);
            // 選択しているゲームでフィルタ
            $request->merge(['game_id' => Auth::user()->selected_game_id]);

            $team = $this->team_service->createTeam($request);

            $request->merge(['post_category_id'  => \App\Models\PostCategory::CATEGORY_TEAM]);
            $request->merge(['user_id'           => Auth::id()]);
            $request->merge(['team_id'           => $team->id]);
            $request->merge(['title'             => 'チーム掲示板']);
            $request->merge(['body'              => 'チームへの質問・雑談を話しましょう']);
            $request->merge(['is_personal'       => 0]);
            $this->post_service->createPost($request->all());
        });

        return redirect('/team?user_id='.Auth::id())->with('flash_message', '新規チームを作成しました');
    }

    /**
     * @param Request $request
     * @param $team_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, $team_id)
    {
        $team     = $this->team_service->findAllTeamAndUserByTeamId($team_id);
        $post     = $this->post_service->findPostWithByPostCategoryTeam($team->id);
        $comments = $this->post_service->findAllPostCommentWithUserByPostIdAndPagination($post->id, 20);

        return view('team.show',compact('team', 'post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = $this->team_service->findAllTeamAndUserByTeamId($id);

        return view('team.edit',compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::transaction(function () use($request) {
            $this->team_service->updateTeam($request);
        });

        return redirect('/team/'.$request->input('id'))->with('flash_message', 'チーム情報を更新しました');
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
