<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Services\UserService;
use App\Services\EventService;

use Illuminate\Http\Request;

class SingleController extends Controller
{

    protected $userService;
    protected $eventService;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param EventService $eventService
     */
    public function __construct(UserService $userService,
                                EventService $eventService)
    {
        $this->userService  = $userService;
        $this->eventService = $eventService;
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
//        try {
            $request = new Request();
            $request->merge(['game_id' => config('assets.site.game_ids.pokemon_card')]);
            $request->merge(['event_category_id' => \App\Models\EventCategory::CATEGORY_SINGLE]);

            $events = $this->eventService->getEventsByIndexForApi($request, 10);

//        } catch(\Exception $e){
//            $events = [
//                'result' => false,
//                'error' => [
//                    'messages' => [$e->getMessage()]
//                ],
//            ];
//            return $this->resConversionJson($events, $e->getCode());
//        }
        return $this->resConversionJson($events);
    }

    private function resConversionJson($eloquent, $statusCode=200)
    {
        if(empty($statusCode) || $statusCode < 100 || $statusCode >= 600){
            $statusCode = 500;
        }
        return response()->json($eloquent, $statusCode, ['Content-Type' => 'application/json'], JSON_UNESCAPED_SLASHES);
    }

}
