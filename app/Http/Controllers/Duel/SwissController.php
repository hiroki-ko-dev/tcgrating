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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

}
