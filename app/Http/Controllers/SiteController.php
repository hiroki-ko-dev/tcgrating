<?php

namespace App\Http\Controllers;

use Auth;
use DB;

use App\Services\UserService;
use Illuminate\Http\Request;

class SiteController extends Controller
{

    protected $user_service;

    /**
     * UserController constructor.
     * @param UserService $user_service
     */
    public function __construct(UserService $user_service)
    {
        $this->user_service  = $user_service;
    }


    public function administrator()
    {

        return view('site.administrator');
    }

    public function update_selected_game(Request $request)
    {
        //ログインしている場合はuserテーブルのselected_game_idも更新
        if(Auth::check() == true){
            DB::transaction(function () use($request){
                $request->merge(['id'=> Auth::id()]);
                $this->user_service->updateSelectedGameId($request);
            });
        }

        session(['selected_game_id' => $request->input('selected_game_id')]);

        return back()->with('flash_message', '選択しているゲームを変更しました');;
    }
}
