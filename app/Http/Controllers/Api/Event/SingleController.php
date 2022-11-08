<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use DB;
use App\Services\UserService;
use App\Services\EventService;
use App\Services\DuelService;
use App\Services\ApiService;
use App\Services\TwitterService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SingleController extends Controller
{

    protected $userService;
    protected $eventService;
    protected $duelService;
    protected $apiService;
    protected $twitterService;

    /**
     * SingleController constructor.
     * @param UserService $userService
     * @param EventService $eventService
     * @param DuelService $duelService
     * @param ApiService $apiService
     * @param TwitterService $twitterService
     */
    public function __construct(UserService $userService,
                                EventService $eventService,
                                DuelService $duelService,
                                ApiService $apiService,
                                TwitterService $twitterService)
    {
        $this->userService  = $userService;
        $this->eventService = $eventService;
        $this->duelService = $duelService;
        $this->apiService = $apiService;
        $this->twitterService = $twitterService;
    }

    public function test()
    {
        try {
            $user = $this->userService->findUser(1);
            $result = [
                'result'      => true,
                'id'     => $user->id,
                'name'   => $user->name
            ];
        } catch(\Exception $e){
            $result = [
                'result' => false,
                'error' => [
                    'messages' => [$e->getMessage()]
                ],
            ];
            return $this->resConversionJson($result, $e->getCode());
        }
        return $this->resConversionJson($result);
    }

    public function index(Request $request)
    {
        try {
            $request->merge(['game_id' => config('assets.site.game_ids.pokemon_card')]);
            $request->merge(['event_category_id' => \App\Models\EventCategory::CATEGORY_SINGLE]);

            $events = $this->eventService->getEventsByIndexForApi($request, 10);

        } catch(\Exception $e){
            $events = [
                'result' => false,
                'error' => [
                    'messages' => [$e->getMessage()]
                ],
            ];
            return $this->apiService->resConversionJson($events, $e->getCode());
        }

        return $this->apiService->resConversionJson($events);
    }

    public function store(Request $request)
    {
        try {
            $date = Carbon::now();

            // 選択しているゲームでフィルタ
            $request->merge(['game_id' => config('assets.site.game_ids.pokemon_card')]);
            $request->merge(['event_category_id' => \App\Models\EventCategory::CATEGORY_SINGLE]);
            $request->merge(['duel_category_id'  => \App\Models\DuelCategory::CATEGORY_SINGLE]);
            $request->merge(['post_category_id'  => \App\Models\PostCategory::CATEGORY_EVENT]);
            $request->merge(['user_id'           => $request->user_id]);
            $request->merge(['number_of_match'   => 1]);
            $request->merge(['now_match_number'  => 1]);
            $request->merge(['max_member'        => 2]);
            $request->merge(['title'             => '1vs1対戦']);
            $request->merge(['status'            => \App\Models\EventUser::STATUS_APPROVAL]);
            $request->merge(['role'              => \App\Models\EventUser::ROLE_ADMIN]);
            $request->merge(['is_personal'       => 1]);

            $request->merge(['body'       => 'LINEからの対戦作成']);
            $request->merge(['date'       => $date]);
            $request->merge(['start_time' => $date]);

            $request->merge(['number_of_games'   => 1]);
            $request->merge(['match_number'      => 1]);
            $request->merge(['rate_type'      => $request->rate_type]);

            DB::transaction(function () use($request) {

                $event = $this->eventService->createEvent($request);
                //event用のpostを作成
                $request->merge(['event_id' => $event->id]);

                $request->merge(['status' => \App\Models\Duel::STATUS_RECRUIT]);
                $this->duelService->createInstant($request);
                //twitterに投稿
                $this->twitterService->tweetByMakeInstantEvent($event);
            });

        } catch(\Exception $e){
            $event = [
                'result' => false,
                'error' => [
                    'messages' => [$e->getMessage()]
                ],
            ];
            return $this->apiService->resConversionJson($event, $e->getCode());
        }

        $events = $this->eventService->getEventsByIndexForApi($request, 10);

        return $this->apiService->resConversionJson($events);
    }

    public function show($event_id)
    {
        try {
            // 勝利報告処理
            // 対戦完了ボタンでなければレートを更新
            $event = $this->eventService->getEventForApi($event_id);

        } catch(\Exception $e){
            $event = [
                'error' => [
                    'messages' => [$e->getMessage()]
                ],
            ];
            return $this->apiService->resConversionJson($event, $e->getCode());
        }

        return $this->apiService->resConversionJson($event);
    }

    public function update(Request $request)
    {
        try {
            $event = DB::transaction(function () use($request) {

                $event = $this->eventService->getEvent($request->event_id);

                // 勝利報告処理
                if($request->status == 11){
                    // 対戦完了ボタンでなければレートを更新
                    if($event->status <> \App\Models\Event::STATUS_READY){
                        throw new \Exception('すでに対戦が終了しています');
                    }

                    $request->merge(['duel'  => $event->eventDuels[0]->duel]);
                    $request->merge(['win'  => true]);
                    $this->duelService->createInstantResult($request);
                }else{
                    if($request->status == \App\Models\Event::STATUS_READY) {
                        if ($event->status <> \App\Models\Event::STATUS_RECRUIT) {
                            throw new \Exception('すでに対戦相手が決定しています');
                        }
                    }elseif($request->status == \App\Models\Event::STATUS_FINISH){
                        if ($event->status <> \App\Models\Event::STATUS_READY) {
                            throw new \Exception('すでに対戦が終了しています');
                        }
                    }
                    // 対戦完了ボタンでなければレートを更新
                    $event = $this->eventService->updateEventStatus($request->event_id, $request->status);
                    $duel = $this->duelService->updateDuelStatus($event->eventDuels[0]->duel_id, $request->status);

                    if($request->status == \APP\Models\Event::STATUS_READY){

                        $request->merge(['duel_id'  => $event->eventDuels[0]->duel_id]);
                        // 対戦申し込みの処理の場合はメンバー追加
                        $request->merge(['status'  => \App\Models\EventUser::STATUS_APPROVAL]);
                        $request->merge(['role'    => \App\Models\EventUser::ROLE_USER]);
                        $this->eventService->createUser($request) ;

                        $this->duelService->createUser($request) ;

                        // 送信
                        $this->apiService->duelMatching($event);
                        //twitterに投稿
                        $this->twitterService->tweetByInstantMatching($event->eventDuels[0]->duel);
                        // API用に変更
                        $event = $this->eventService->findEventWithUserAndDuel($request->event_id);
                    }
                    return $event;
                }
            });

        } catch(\Exception $e){
            $event = [
                'error' => [
                    'messages' => [$e->getMessage()]
                ],
            ];
            return $this->apiService->resConversionJson($event, $e->getCode());
        }

        $event = $this->eventService->getEventForApi($request->event_id);

        return $this->apiService->resConversionJson($event);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function badge(Request $request)
    {

        try {
            $request->merge(['status'  => \App\Models\Event::STATUS_READY]);
            $events = $this->eventService->getEvents($request);
        } catch(\Exception $e){
            $event = [
                'error' => [
                    'messages' => [$e->getMessage()]
                ],
            ];
            return $this->apiService->resConversionJson($event, $e->getCode());
        }

        return $this->apiService->resConversionJson($events);
    }

}
