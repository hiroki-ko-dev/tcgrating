<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Controller;
use Auth;
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

            Log::debug($request->event_users_user_id);

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

                // すでにマッチング済ならリダイレクト
                if($event->status <> \App\Models\Event::STATUS_RECRUIT){
                    return 'すでに別の方がマッチング済です';
                }

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
