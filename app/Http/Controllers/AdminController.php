<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Log;
use App\Services\DuelService;
use App\Services\ItemService;

use Illuminate\Http\Request;

class AdminController extends Controller
{

    protected $duelService;
    protected $itemService;

    /**
     * AdminController constructor.
     * @param DuelService $duelService
     * @param ItemService $itemService
     */
    public function __construct(DuelService $duelService,
                                ItemService $itemService)
    {
        $this->duelService = $duelService;
        $this->itemService = $itemService;
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function itemTransaction(Request $request)
    {
        // 選択しているゲームでフィルタ
        if(!Auth::check() || Auth::user()->role <> 1){
            return back();
        }

        $transactions = $this->itemService->getTransactionsByPaginate($request, 20);

        return view('admin.item.transaction.index',compact('transactions'));
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
