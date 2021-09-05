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

        // イベント作成によるメール文
        $tweet =
            $event->user->name. 'さんが対戦相手を探しています' . PHP_EOL .
            '対戦ゲーム：' . $event->game->name . PHP_EOL .
            '対戦日時' . date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time)) . PHP_EOL .
            PHP_EOL .
            '以下のURLから対戦を受けましょう!' . PHP_EOL .
            'https://hashimu.com/event/single/' . $event->id . '?selected_game_id=' . $event->game_id . ' ';

        if(config('assets.common.appEnv') == 'production'){
            $this->twitterRepository->tweet($apiKeys, $tweet);
        }
    }

    /**
     * @param Request $event
     */
    public function tweetByMatching($event)
    {
        // Twitterの遊戯王アカウントでTweet
        if($event->game_id == 1 || $event->game_id == 2){
            $apiKeys = config('assets.twitter.yugioh');

            // TwitterのポケモンアカウントでTweet
        }elseif($event->game_id == 3){
            $apiKeys = config('assets.twitter.pokemon');
        }

        // 対戦マッチング  によるメール文
        $tweet =
            '@' . $event->user->twitter_nickname . PHP_EOL .
            $event->eventUser[1]->user->name. 'さんと対戦がマッチングしました' . PHP_EOL .
            '対戦ゲーム：' . $event->game->name . PHP_EOL .
            '対戦日時' . date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time)) . PHP_EOL .
            PHP_EOL .
            '対戦の準備をしましょう！' . PHP_EOL .
            'https://hashimu.com/event/single/' . $event->id . '?selected_game_id=' . $event->game_id . ' ';

        if(config('assets.common.appEnv') == 'production'){
            $this->twitterRepository->tweet($apiKeys, $tweet);
        }
    }

}
