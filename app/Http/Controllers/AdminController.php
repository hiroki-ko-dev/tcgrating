<?php

namespace App\Http\Controllers;
use Auth;
use DB;
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
        //
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