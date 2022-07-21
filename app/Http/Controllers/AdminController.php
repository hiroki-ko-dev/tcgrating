<?php

namespace App\Http\Controllers;
use Auth;
use DB;
use Log;
use App\Services\DuelService;

use Illuminate\Http\Request;

class AdminController extends Controller
{

    protected $duelService;

    /**
     * AdminController constructor.
     * @param DuelService $duelService
     */
    public function __construct(DuelService $duelService)
    {
        $this->duelService = $duelService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // 選択しているゲームでフィルタ
        if(!Auth::check() || Auth::user()->role <> 1){
            return back();
        }

        if(!($request->has('event_id'))){
            $request->merge(['event_id'=> 0]);
        }

        $duels = $this->duelService->getDuels($request);

        return view('admin.index',compact('duels'));
    }

    /**
     *
     */
    public function show()
    {
        Log::debug('admin/showを実行');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function postRequest(Request $request)
    {
        return view('admin.post_request');
    }
}
