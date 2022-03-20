<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Services\UserService;
use App\Services\EventService;
use App\Services\ApiService;

use Illuminate\Http\Request;

class SingleController extends Controller
{

    protected $userService;
    protected $eventService;
    protected $apiService;

    /**
     * SingleController constructor.
     * @param UserService $userService
     * @param EventService $eventService
     * @param ApiService $apiService
     */
    public function __construct(UserService $userService,
                                EventService $eventService,
                                ApiService $apiService)
    {
        $this->userService  = $userService;
        $this->eventService = $eventService;
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

    public function index()
    {
        try {
            $request = new Request();
            $request->merge(['game_id' => config('assets.site.game_ids.pokemon_card')]);
            $request->merge(['event_category_id' => \App\Models\EventCategory::CATEGORY_SINGLE]);
            $request->merge(['status' => [\App\Models\Event::STATUS_RECRUIT]]);

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



}
