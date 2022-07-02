<?php

namespace App\Http\Controllers;

use Auth;
use DB;

use App\Services\OpinionService;
use Illuminate\Http\Request;

class OpinionController extends Controller
{

    protected $opinionService;

    /**
     * OpinionController constructor.
     * @param OpinionService $opinionService
     */
    public function __construct(OpinionService $opinionService)
    {
        $this->opinionService = $opinionService;
    }

    public function index(Request $request)
    {
        $opinions = $this->opinionService->getOpinionsOfPagination($request, 20);

        return view('opinion.index', compact('opinions'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        session(['loginAfterRedirectUrl' => env('APP_URL').'/opinion/create']);
        session(['selected_game_id' => 3]);

        return view('opinion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge(['user_id'=> Auth::id()]);
        $request->merge(['game_id'=> Auth::user()->selected_game_id]);

        $this->opinionService->makeOpinion($request);

        return view('opinion.store');
    }

    /**
     * @param $opinion_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($opinion_id)
    {
        $opinion = $this->opinionService->getOpinion($opinion_id);

        return view('opinion.show', compact('opinion'));
    }

}
