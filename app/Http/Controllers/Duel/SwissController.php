<?php

namespace App\Http\Controllers\Duel;
use App\Http\Controllers\Controller;

use App\Services\EventService;
use App\Services\DuelService;
use App\Services\PostService;
use App\Services\TwitterService;

use Auth;
use DB;

use Illuminate\Http\Request;

class SwissController extends Controller
{
    protected $eventService;
    protected $duelService;
    protected $postService;
    protected $twitterService;

    public function __construct(EventService $eventService,
                                DuelService $duelService,
                                PostService $postService,
                                TwitterService $twitterService)
    {
        $this->eventService = $eventService ;
        $this->duelService = $duelService ;
        $this->postService = $postService ;
        $this->twitterService = $twitterService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $message = DB::transaction(function () use($request) {
                $event = $this->eventService->getEvent($request->event_id);
                $request->merge(['now_match_number' => ($event->now_match_number + 1)]);
                $event = $this->eventService->updateEvent($request);
                $duels = $this->duelService->makeSwissDuels($request);
                return '対戦を作成しました';
            });

            return redirect('/event/swiss/'.$request->event_id)->with('flash_message', $message);

        } catch (\Exception $e) {
            report($e);
            return back()->with('flash_message', $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param $event_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request,$event_id)
    {
        $request->merge(['event_id' => $event_id]);

        $duels = $this->duelService->getDuels($request);

        return view('duel.swiss.show',compact('duels'));
    }

    /**
     * @param Request $request
     * @param $duel_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function update(Request $request,$duel_id)
    {
        $duels = $this->duelService->getDuels($request);

        return view('duel.swiss.show',compact('duels'));
    }

}
