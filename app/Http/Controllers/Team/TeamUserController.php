<?php

namespace App\Http\Controllers\Team;
use DB;
use App\Http\Controllers\Controller;
use App\Services\TeamService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamUserController extends Controller
{

    protected $team_service;

    public function __construct(TeamService $team_service)
    {
        $this->team_service = $team_service;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
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
    }

    /**
     * Store a newly created resource in storage.
     * チームに参加希望リクエストを加える処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        DB::transaction(function () use($request){

            $team = $this->team_service->findAllTeamAndUserByTeamId($request->team_id);
            //すでにチームにリクエストを送付済なら追加せずにリターン
            if(!$team->teamUser->where('user_id',Auth::id())->isNotEmpty()){
                return back();
            }

            $request->merge(['user_id' => Auth::id()]);
            $request->merge(['status'  => \App\Models\TeamUser::REQUEST]);
            $this->team_service->createUser($request);
        });

        return back()->with('flash_message', 'チーム参加リクエストを出しました');

    }

    /**
     * @param Request $request
     * @param $team_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, $team_id)
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
    }

    /**
     * @param Request $request
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $user_id)
    {
        $message = null;
        if($request->has('status')){
            DB::transaction(function () use($request){
                $this->team_service->updateUserStatus($request);
            });
            if($request->input('status') == \App\Models\TeamUser::APPROVAL){
                $message = 'ユーザーリクエストを承認しました';
            }elseif($request->input('status') == \App\Models\TeamUser::REJECT){
                $message = 'ユーザーリクエストを却下しました';
            }
        }

        return back()->with('flash_message', $message);
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
