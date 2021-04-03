<?php

namespace App\Http\Controllers;

use Auth;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if(empty($request->query('user_id'))){
            $this->middleware('auth');
            $user_id = Auth::id();
        }else{
            $user_id = $request->query('user_id');
        }

        $user = $this->user_service->findUser($user_id);

        return view('user.index',compact('user'));
    }
}
