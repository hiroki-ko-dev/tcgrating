<?php

namespace App\Http\Controllers\Web\Duel;

use App\Http\Controllers\Controller;
use App\Enums\EventStatus;
use App\Enums\DuelStatus;
use App\Services\EventService;
use App\Services\DuelService;
use App\Services\PostService;
use App\Services\TwitterService;
use Auth;
use DB;
use Illuminate\Http\Request;

class InstantController extends Controller
{
    public function __construct(
        private readonly EventService $eventService,
        private readonly DuelService $duelService,
        private readonly PostService $postService,
        private readonly TwitterService $twitterService
    ) {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $duel_id
     * @return \Illuminate\Http\Response
     */
    public function show($duel_id)
    {
        $duel     = $this->duelService->findDuelWithUserAndEvent($duel_id);
        session(['loginAfterRedirectUrl' => env('APP_URL') . '/duel/instant/' . $duel_id]);

        return view('duel.instant.show', compact('duel'));
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
            $request->merge(['user_id'=> Auth::id()]);

            $message = DB::transaction(function () use ($request) {
                $duel = $this->duelService->findDuelWithUserAndEvent($request->duel_id);

                // すでに対戦が終了していたら、何もせずに完了にする
                if ($duel->status <> DuelStatus::READY->value) {
                    return '終了した試合です';
                }

                $request->merge(['duel' => $duel]);
                $request->merge(['event_id' => $duel->eventDuel->event->id]);

                // レートを更新
                $this->duelService->createInstantResult($request);
                // 対戦完了ステータスを更新
                $this->eventService->updateEventStatus($duel->eventDuel->event->id, EventStatus::FINISH->value);
                $this->duelService->updateDuelStatus($duel->id, DuelStatus::FINISH->value);
                $this->twitterService->tweetByInstantDuelFinish($duel);
                $message = '試合が完了しました';

                return $message;
            });

            return redirect('/duel/instant/' . $request->duel_id)->with('flash_message', $message);
        } catch (\Exception $e) {
            report($e);
            return back()->with('flash_message', $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param $duel_id
     */
    public function update(Request $request, $duel_id)
    {
        try {
            if ($request->event_cancel == 1) {
                DB::transaction(function () use ($request, $duel_id) {
                    $duel = $this->duelService->findDuelWithUserAndEvent($duel_id);
                    $this->eventService->updateEventStatus($duel->eventDuel->event->id, EventStatus::CANCEL->value);
                    $this->duelService->updateDuelStatus($duel_id, DuelStatus::CANCEL->value);
                });
            }
            return back()->with('flash_message', '対戦をキャンセルしました');

        } catch (\Exception $e) {
            report($e);
            return back()->with('flash_message', $e->getMessage());
        }
    }

}
