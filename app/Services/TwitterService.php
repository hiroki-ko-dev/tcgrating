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
            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ ';
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
    public function tweetByMakeInstantEvent($event)
    {
        // Twitterの遊戯王アカウントでTweet
        if($event->game_id == 1 || $event->game_id == 2){
            $apiKeys = config('assets.twitter.yugioh');
            $hashTag = '#遊戯王デュエルリンクス ';

            // TwitterのポケモンアカウントでTweet
        }elseif($event->game_id == 3){
            $apiKeys = config('assets.twitter.pokemon');
            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ ';
        }

        // イベント作成によるメール文
        $tweet =
            $event->user->name. 'さんが対戦相手を探しています' . PHP_EOL .
            '対戦ゲーム：' . $event->game->name . PHP_EOL .
            '対戦日時' . date('Y/m/d H:i', strtotime($event->date)) . PHP_EOL .
            PHP_EOL .
            'https://hashimu.com/duel/instant/' . $event->eventDuels[0]->duel_id . '?selected_game_id=' . $event->game_id . ' ' . PHP_EOL .
            'URLから対戦を受けましょう!' . PHP_EOL .
            $hashTag;

        // イベント作成によるメール文
        $discord =
            '@' . $event->user->gameUsers->where('game_id', $event->game_id)->first()->discord_name . ' さんが対戦相手を探しています' . PHP_EOL .
            'URLから対戦を受けましょう!' . PHP_EOL .
            PHP_EOL .
            env('APP_URL') . '/duel/instant/' . $event->eventDuels[0]->duel_id . '?selected_game_id=' . $event->game_id . ' ';

        if(config('assets.common.appEnv') == 'production'){
            $this->twitterRepository->tweet($apiKeys, $tweet);
            $this->discordPost($discord);
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
            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ ';
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
            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ ';
        }

        // 対戦マッチング  によるメール文
        $tweet =
            '@' . $duel->user->twitter_nickname . PHP_EOL .
            $duel->eventUsers[1]->user->name. 'さんと対戦がマッチングしました' . PHP_EOL .
            PHP_EOL .
            'https://hashimu.com/duel/instant/' . $duel->id . '?selected_game_id=' . $duel->game_id . ' ' . PHP_EOL .
            '対戦ゲーム：' . $duel->game->name . PHP_EOL .
            '対戦の準備をしましょう！' . PHP_EOL .
            $hashTag;

        // イベント作成によるメール文
        $discord =
            '@' . $duel->eventUsers[0]->user->gameUsers->where('game_id', $duel->game_id)->first()->discord_name .
            'さんと @' . $duel->eventUsers[1]->user->gameUsers->where('game_id', $duel->game_id)->first()->discord_name . 'さんの' . PHP_EOL .
            '2名でマッチングが成立しました。対戦を始めましょう!' . PHP_EOL .
            PHP_EOL .
            'https://hashimu.com/duel/instant/' . $duel->id . '?selected_game_id=' . $duel->game_id . ' ' ;

        if(config('assets.common.appEnv') == 'production'){
            $this->twitterRepository->tweet($apiKeys, $tweet);
            $this->discordPost($discord);
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
            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ ';
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

    public function tweetByInstantDuelFinish($duel)
    {
        // Twitterの遊戯王アカウントでTweet
        if($duel->game_id == 1 || $duel->game_id == 2){
            $apiKeys = config('assets.twitter.yugioh');
            $hashTag = '#遊戯王デュエルリンクス ';

            // TwitterのポケモンアカウントでTweet
        }elseif($duel->game_id == 3){
            $apiKeys = config('assets.twitter.pokemon');
            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ ';
        }

        if($duel->duelUsers[0]->duelUserResults->sum('rating') > $duel->duelUsers[1]->duelUserResults->sum('rating')){
            $result = $duel->duelUsers[0]->user->name . 'さんの勝利です。' . PHP_EOL;
            $rate = $duel->duelUsers[0]->duelUserResults->sum('rating');
        }elseif($duel->duelUsers[0]->duelUserResults->sum('rating') < $duel->duelUsers[1]->duelUserResults->sum('rating')){
            $result = $duel->duelUsers[1]->user->name . 'さんの勝利です。' . PHP_EOL;
            $rate = $duel->duelUsers[1]->duelUserResults->sum('rating');
        }else{
            $result = 'ドローです。' . PHP_EOL;
            $rate = 0;
        }

        // 対戦マッチング  によるメール文
        $tweet =
            '対戦が完了いたしました！' . PHP_EOL .
            '勝負の結果は'. $result . PHP_EOL .
            'レートが' . $rate . 'ポイント上昇します。' . PHP_EOL .
            'お疲れ様でした！' . PHP_EOL .
            PHP_EOL .
            'https://hashimu.com/duel/instant/' . $duel->id . '?selected_game_id=' . $duel->game_id . ' ' . PHP_EOL .
            '対戦ゲーム：' . $duel->game->name . PHP_EOL .
            '対戦日時' . date('Y/m/d H:i', strtotime($duel->eventDuel->event->date.' '. $duel->eventDuel->event->start_time)) . PHP_EOL .
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
            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ ';
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
            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ ';
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

    /**
     * @param $message
     */
    public function discordPost($message)
    {
        $data = array("content" => $message, "username" => 'TCGRating');
        $headers[] = "Content-Type: application/json";

        $curl = curl_init('https://discord.com/api/webhooks/928304082303729675/QTibeNnkLzZMrJgYqf6MDeaEmX9BAoZQc22a_wLN85UexqcoqDhNEl2SoA4qtcgbyAJb');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $res = curl_exec($curl);
    }

}
