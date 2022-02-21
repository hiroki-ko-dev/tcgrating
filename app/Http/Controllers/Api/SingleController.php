<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Services\UserService;
use App\Services\EventService;

use Illuminate\Http\Request;

class SingleController extends Controller
{

    protected $userService;
    protected $event_service;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param EventService $event_service
     */
    public function __construct(UserService $userService,
                                EventService $event_service)
    {
        $this->userService  = $userService;
        $this->event_service = $event_service;
    }

    public function index()
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

    private function resConversionJson($result, $statusCode=200)
    {
        if(empty($statusCode) || $statusCode < 100 || $statusCode >= 600){
            $statusCode = 500;
        }
        return response()->json($result, $statusCode, ['Content-Type' => 'application/json'], JSON_UNESCAPED_SLASHES);
    }

}
