<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\TwitterRepository;

class ApiService
{
    protected $twitterRepository;

    public function __construct(TwitterRepository $twitterRepository)
    {
        $this->twitterRepository = $twitterRepository;
    }

    /**
     * @param $eloquent
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function resConversionJson($eloquent, $statusCode=200)
    {
        if(empty($statusCode) || $statusCode < 100 || $statusCode >= 600){
            $statusCode = 500;
        }
        return response()->json($eloquent, $statusCode, ['Content-Type' => 'application/json'], JSON_UNESCAPED_SLASHES);
    }

}
