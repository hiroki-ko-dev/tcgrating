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
            $hashTag = '#遊戯王デュエルリンクス ';

        // TwitterのポケモンアカウントでTweet
        }elseif($event->game_id == 3){
            $apiKeys = config('assets.twitter.pokemon');
            $hashTag = '#ポケモンカード #リモートポケカ ';
        }

        // イベント作成によるメール文
        $tweet =
            $event->user->name. 'さんが対戦相手を探しています' . PHP_EOL .
            '対戦ゲーム：' . $event->game->name . PHP_EOL .
            '対戦日時' . date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time)) . PHP_EOL .
            PHP_EOL .
            '以下のURLから対戦を受けましょう!' . PHP_EOL .
            'https://hashimu.com/event/single/' . $event->id . '?selected_game_id=' . $event->game_id . ' ' . PHP_EOL .
            $hashTag;

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
            $hashTag = '#遊戯王デュエルリンクス ';

            // TwitterのポケモンアカウントでTweet
        }elseif($event->game_id == 3){
            $apiKeys = config('assets.twitter.pokemon');
            $hashTag = '#ポケモンカード #リモートポケカ ';
        }

        // 対戦マッチング  によるメール文
        $tweet =
            '@' . $event->user->twitter_nickname . PHP_EOL .
            $event->eventUsers[1]->user->name. 'さんと対戦がマッチングしました' . PHP_EOL .
            '対戦ゲーム：' . $event->game->name . PHP_EOL .
            '対戦日時' . date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time)) . PHP_EOL .
            PHP_EOL .
            '対戦の準備をしましょう！' . PHP_EOL .
            'https://hashimu.com/event/single/' . $event->id . '?selected_game_id=' . $event->game_id . ' ' . PHP_EOL .
            $hashTag;

        if(config('assets.common.appEnv') == 'production'){
            $this->twitterRepository->tweet($apiKeys, $tweet);
        }
    }

    public function tweetByInstantMatching($duel)
    {
        // Twitterの遊戯王アカウントでTweet
        if($duel->game_id == 1 || $duel->game_id == 2){
            $apiKeys = config('assets.twitter.yugioh');
            $hashTag = '#遊戯王デュエルリンクス ';

            // TwitterのポケモンアカウントでTweet
        }elseif($duel->game_id == 3){
            $apiKeys = config('assets.twitter.pokemon');
            $hashTag = '#ポケモンカード #リモートポケカ ';
        }

        // 対戦マッチング  によるメール文
        $tweet =
            '@' . $duel->user->twitter_nickname . PHP_EOL .
            $duel->eventUsers[1]->user->name. 'さんと対戦がマッチングしました' . PHP_EOL .
            '対戦ゲーム：' . $duel->game->name . PHP_EOL .
            '対戦の準備をしましょう！' . PHP_EOL .
            'https://hashimu.com/duel/instant/' . $duel->id . '?selected_game_id=' . $duel->game_id . ' ' . PHP_EOL .
            $hashTag;

        if(config('assets.common.appEnv') == 'production'){
            $this->twitterRepository->tweet($apiKeys, $tweet);
        }
    }

    public function tweetByDuelFinish($duel)
    {
        // Twitterの遊戯王アカウントでTweet
        if($duel->game_id == 1 || $duel->game_id == 2){
            $apiKeys = config('assets.twitter.yugioh');
            $hashTag = '#遊戯王デュエルリンクス ';

            // TwitterのポケモンアカウントでTweet
        }elseif($duel->game_id == 3){
            $apiKeys = config('assets.twitter.pokemon');
            $hashTag = '#ポケモンカード #リモートポケカ ';
        }

        if($duel->duelUsers[0]->duelUserResults->sum('rating') > $duel->duelUsers[1]->duelUserResults->sum('rating')){
            $result = $duel->duelUsers[0]->user->name . 'さんの勝利です。' . PHP_EOL;
        }elseif($duel->duelUsers[0]->duelUserResults->sum('rating') < $duel->duelUsers[1]->duelUserResults->sum('rating')){
            $result = $duel->duelUsers[1]->user->name . 'さんの勝利です。' . PHP_EOL;
        }else{
            $result = 'ドローです。' . PHP_EOL;
        }

        // 対戦マッチング  によるメール文
        $tweet =
            '対戦が完了いたしました！' . PHP_EOL .
            '勝負の結果は'. $result . PHP_EOL .
            'お疲れ様でした！' . PHP_EOL .
             PHP_EOL .
            '対戦ゲーム：' . $duel->game->name . PHP_EOL .
            '対戦日時' . date('Y/m/d H:i', strtotime($duel->eventDuel->event->date.' '. $duel->eventDuel->event->start_time)) . PHP_EOL .
            'https://hashimu.com/event/single/' . $duel->eventDuel->event->id . '?selected_game_id=' . $duel->game_id . ' ' . PHP_EOL .
            $hashTag;

        if(config('assets.common.appEnv') == 'production'){
            $this->twitterRepository->tweet($apiKeys, $tweet);
        }
    }

    /**
     * @param $event
     * @param $users
     */
    public function tweetByEventPostNotice($event, $users)
    {
        // Twitterの遊戯王アカウントでTweet
        if($event->game_id == 1 || $event->game_id == 2){
            $apiKeys = config('assets.twitter.yugioh');
            $hashTag = '#遊戯王デュエルリンクス ';

            // TwitterのポケモンアカウントでTweet
        }elseif($event->game_id == 3){
            $apiKeys = config('assets.twitter.pokemon');
            $hashTag = '#ポケモンカード #リモートポケカ ';
        }

        foreach ($users as $user){
            // 対戦マッチング  によるメール文
            $tweet =
                '@' . $user->twitter_nickname . PHP_EOL .
                '参加しているイベント受付掲示板が更新されました。確認しましょう。' . PHP_EOL .
                PHP_EOL .
                '対戦ゲーム：' . $event->game->name . PHP_EOL .
                '対戦日時' . date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time)) . PHP_EOL .
                'https://hashimu.com/event/single/' . $event->id . '?selected_game_id=' . $event->game_id . ' ' . PHP_EOL .
                $hashTag;
            if(config('assets.common.appEnv') == 'production'){
                $this->twitterRepository->tweet($apiKeys, $tweet);
            }
        }
    }

    /**
     * @param $duel
     * @param $user
     */
    public function tweetByDuelPostNotice($duel, $users)
    {
        // Twitterの遊戯王アカウントでTweet
        if($duel->game_id == 1 || $duel->game_id == 2){
            $apiKeys = config('assets.twitter.yugioh');
            $hashTag = '#遊戯王デュエルリンクス ';

            // TwitterのポケモンアカウントでTweet
        }elseif($duel->game_id == 3){
            $apiKeys = config('assets.twitter.pokemon');
            $hashTag = '#ポケモンカード #リモートポケカ ';
        }

        foreach ($users as $user) {

            // 対戦マッチング  によるメール文
            $tweet =
                '@' . $user->twitter_nickname . PHP_EOL .
                '参加している対戦掲示板が更新されました。確認しましょう。' . PHP_EOL .
                PHP_EOL .
                '対戦ゲーム：' . $duel->game->name . PHP_EOL .
                '対戦日時' . date('Y/m/d H:i', strtotime($duel->eventDuel->event->date . ' ' . $duel->eventDuel->event->start_time)) . PHP_EOL .
                'https://hashimu.com/duel/single/' . $duel->id . '?selected_game_id=' . $duel->game_id . ' ' . PHP_EOL .
                $hashTag;

            if(config('assets.common.appEnv') == 'production'){
                $this->twitterRepository->tweet($apiKeys, $tweet);
            }
        }
    }

}
