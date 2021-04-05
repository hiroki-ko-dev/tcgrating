<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Services\UserService;

use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $user_service;

    /**
     * UserController constructor.
     * @param UserService $user_service
     */
    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    /**
     * @param Request $request
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request,$user_id)
    {

        $user = $this->user_service->findUser($user_id);

        return view('user.show',compact('user'));
    }

    /**
     * @param Request $request
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Request $request,$user_id)
    {

        $user = $this->user_service->findUser($user_id);

        return view('user.edit',compact('user'));
    }

//    /**
//     * @param Request $request
//     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
//     */
//    public function store(Request $request)
//    {
//        DB::transaction(function () use($request){
//            $this->user_service->updateUser($request);
//        });
//
//        return redirect('/user/'.$request->input('id'))->with('flash_message', '保存しました');
//    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function update(Request $request)
    {
        DB::transaction(function () use($request){
            $this->user_service->updateUser($request);
        });

        return redirect('/user/'.$request->input('id'))->with('flash_message', '保存しました');
    }
}
