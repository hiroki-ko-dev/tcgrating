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

    /**
     * @param $event
     */
    public function duelMatching($event)
    {
        $expo_push_token = $event->user->game_users
                                ->where('game_id',config('assets.site.game_ids.pokemon_card'))
                                ->first()
                                ->expo_push_token;

        if($expo_push_token){
            $data = array(
                "to"  => "ExponentPushToken[KhlJf8PvNsZ5b9wqDQoIPB]",
                "sound" => 'default',
                "title"  => "ポケカ対戦マッチングしました",
                "body" => 'Discordの対戦チャンネルで対戦を開始してください',
            );
            $headers[] = "Content-Type: application/json";

            $curl = curl_init('https://exp.host/--/api/v2/push/send');
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $res = curl_exec($curl);
        }
    }
}
