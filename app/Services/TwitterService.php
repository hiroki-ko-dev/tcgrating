<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\TwitterRepository;

class TwitterService
{
    protected $twitterRepository;

    public function __construct(TwitterRepository $twitterRepository)
    {
        $this->twitterRepository = $twitterRepository;
    }
    /**
     * @param Request $event
     */
    public function tweetByMakeEvent($event)
    {
        // Twitterの遊戯王アカウントでTweet
        if($event->game_id == 1 || $event->game_id == 2){
            $apiKeys = config('assets.twitter.yugioh');

        // TwitterのポケモンアカウントでTweet
        }elseif($event->game_id == 3){
            $apiKeys = config('assets.twitter.pokemon');
        }

        if(config('assets.common.appEnv') == 'production'){
            $this->twitterRepository->tweet($apiKeys, $event);
        }
    }


}
