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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SingleController extends Controller
{

    protected $userService;
    protected $eventService;
    protected $duelService;
    protected $apiService;

    /**
     * SingleController constructor.
     * @param UserService $userService
     * @param EventService $eventService
     * @param DuelService $duelService
     * @param ApiService $apiService
     */
    public function __construct(UserService $userService,
                                EventService $eventService,
                                DuelService $duelService,
                                ApiService $apiService)
    {
        $this->userService  = $userService;
        $this->eventService = $eventService;
        $this->duelService = $duelService;
        $this->apiService = $apiService;
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

    public function update(Request $request)
    {
        try {
            $event = DB::transaction(function () use($request) {

                $event = $this->eventService->updateEventStatus($request->event_id, $request->status);
                $request->merge(['duel_id'  => $event->eventDuels[0]->duel_id]);
                $this->duelService->updateDuelStatus($request->duel_id, $request->status);

                if($request->status == \APP\Models\Event::STATUS_READY){
                    // 対戦申し込みの処理の場合はメンバー追加
                    //追加
                    $request->merge(['status'  => \App\Models\EventUser::STATUS_APPROVAL]);
                    $request->merge(['role'    => \App\Models\EventUser::ROLE_USER]);
                    $this->eventService->createUser($request) ;
                    $event = $this->eventService->findEventWithUserAndDuel($request->event_id);

                    $this->duelService->createUser($request) ;
                }

                return $event;
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

        $event = $this->eventService->getEventsForApi($request->event_id);

        return $this->apiService->resConversionJson($event);
    }

    public function join(Request $request)
    {
        try {
            //追加
            $request->merge(['status'  => \App\Models\EventUser::STATUS_APPROVAL]);
            $request->merge(['role'    => \App\Models\EventUser::ROLE_USER]);

            $event = DB::transaction(function () use($request) {

                $this->eventService->createUser($request) ;
                $event = $this->eventService->findEventWithUserAndDuel($request->event_id);

                $request->merge(['duel_id'  => $event->eventDuels[0]->duel_id]);

                $this->duelService->createUser($request) ;

                $this->eventService->updateEventStatus($request->event_id, \APP\Models\Event::STATUS_READY);

                return $event;

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

        return $this->apiService->resConversionJson($event);
    }

}
