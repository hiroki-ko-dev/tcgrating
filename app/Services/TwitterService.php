<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TwitterRepository;

class TwitterService
{
    protected $userRepository;
    protected $twitterRepository;

    public function __construct(UserRepository $userRepository,
                            TwitterRepository $twitterRepository)
    {
        $this->userRepository = $userRepository;
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
            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ #discordポケカ';
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
//            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ #discordポケカ';
            $hashTag = '';
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

        if($event->rate_type == \App\Models\Event::RATE_TYPE_RATE){
            $table = 'レート対戦';
            $webHook = config('assets.discord.web_hook.rate');
        }else{
            $table = 'エキシビジョン戦';
            $webHook = config('assets.discord.web_hook.exhibition');
        }

        // イベント作成によるメール文
        $discord =
            '@' . $event->user->gameUsers->where('game_id', $event->game_id)->first()->discord_name . ' さんが対戦相手を探しています' . PHP_EOL .
            '対戦チャンネルは　「' . $table . ' ' . $event->eventDuels[0]->duel->room_id . '」　です。' . PHP_EOL .
            'URLから対戦を受けましょう!' . PHP_EOL .
            PHP_EOL .
            env('APP_URL') . '/duel/instant/' . $event->eventDuels[0]->duel_id . '?selected_game_id=' . $event->game_id . ' ';

        if(config('assets.common.appEnv') == 'production'){
            $this->twitterRepository->tweet($apiKeys, $tweet);
            $this->discordPost($discord, $webHook);
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
            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ #discordポケカ';
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
//            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ #discordポケカ';
            $hashTag = '';
        }

        // 対戦マッチング  によるメール文
        $tweet =
            '@' . $duel->user->twitter_nickname . PHP_EOL .
            $duel->duelUsers[1]->user->name. 'さんと対戦がマッチングしました' . PHP_EOL .
            PHP_EOL .
            'https://hashimu.com/duel/instant/' . $duel->id . '?selected_game_id=' . $duel->game_id . ' ' . PHP_EOL .
            '対戦ゲーム：' . $duel->game->name . PHP_EOL .
            '対戦の準備をしましょう！' . PHP_EOL .
            $hashTag;

        if($duel->eventDuel->event->rate_type == \App\Models\Event::RATE_TYPE_RATE){
            $table = 'レート対戦';
            $webHook = config('assets.discord.web_hook.rate');
        }else{
            $table = 'エキシビジョン戦';
            $webHook = config('assets.discord.web_hook.exhibition');
        }

        // イベント作成によるメール文
        $discord =
            '@' . $duel->duelUsers[0]->user->gameUsers->where('game_id', $duel->game_id)->first()->discord_name .
            'さんと @' . $duel->duelUsers[1]->user->gameUsers->where('game_id', $duel->game_id)->first()->discord_name . 'さんの' . PHP_EOL .
            '2名でマッチングが成立しました。対戦を始めましょう!' . PHP_EOL .
            '対戦チャンネルは　「' . $table . ' ' . $duel->room_id . '」　です。' . PHP_EOL .
            '対戦を始めましょう！' . PHP_EOL .
            PHP_EOL .
            'https://hashimu.com/duel/instant/' . $duel->id . '?selected_game_id=' . $duel->game_id . ' ' ;

        if(config('assets.common.appEnv') == 'production'){
            $this->twitterRepository->tweet($apiKeys, $tweet);
            $this->discordPost($discord, $webHook);
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
            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ #discordポケカ';
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
//            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ #discordポケカ';
            $hashTag = '';
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
            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ';
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
            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ';
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
     * @param $blog
     */
    public function tweetByStorePost($blog)
    {
        if(config('assets.common.appEnv') == 'production'){
            $apiKeys = config('assets.twitter.pokeka_info');

            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ';
            $link = 'https://hashimu.com/blog/' . $blog->id . '?selected_game_id=' . $blog->game_id . '&remotopokeka=1';

            // 対戦マッチング  によるメール文
            $tweet =
                '【ポケカ掲示板】' . $blog->title . PHP_EOL .
                PHP_EOL .
                $link . PHP_EOL .
                PHP_EOL .
                $hashTag;

                $this->twitterRepository->tweet($apiKeys, $tweet);

//                $webHook = config('assets.discord.web_hook.deck');
//                $discord =
//                    'ポケカ掲示板に以下のデッキ相談が投稿されました。' . PHP_EOL .
//                    'デッキ構築が上手い人は迷える子羊を救ってあげましょう！' . PHP_EOL .
//                    PHP_EOL .
//                    '【デッキ相談】' . $post->title . PHP_EOL .
//                    PHP_EOL .
//                    $link;

//            $this->discordPost($discord, $webHook);
        }
    }

    /**
     * @param $post
     */
    public function tweetByBlog($post)
    {
        if(config('assets.common.appEnv') == 'production'){
            $apiKeys = config('assets.twitter.pokeka_info');

            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ';
            $link = 'https://hashimu.com/blog/' . $post->id . '?selected_game_id=' . $post->game_id . '&remotopokeka=1';

            // 対戦マッチング  によるメール文
            $tweet =
                '【ポケカ掲示板】【' . \App\Models\Post::SUB_CATEGORY[$post->sub_category_id] .'】' . $post->title . PHP_EOL .
                PHP_EOL .
                $link . PHP_EOL .
                PHP_EOL .
                $hashTag;

            $this->twitterRepository->tweet($apiKeys, $tweet);

            if($post->sub_category_id == \App\Models\Post::SUB_CATEGORY_FREE){
                $webHook = config('assets.discord.web_hook.chat');
                $discord =
                    'ポケカ掲示板に以下のトークが投稿されました。' . PHP_EOL .
                    'みんなでトークを開始しましょう！' . PHP_EOL .
                    PHP_EOL .
                    $post->title . PHP_EOL .
                    PHP_EOL .
                    $link;

            }elseif($post->sub_category_id == \App\Models\Post::SUB_CATEGORY_DECK){
                $webHook = config('assets.discord.web_hook.deck');
                $discord =
                    'ポケカ掲示板に以下のデッキ相談が投稿されました。' . PHP_EOL .
                    'デッキ構築が上手い人は迷える子羊を救ってあげましょう！' . PHP_EOL .
                    PHP_EOL .
                    '【デッキ相談】' . $post->title . PHP_EOL .
                    PHP_EOL .
                    $link;
            }elseif($post->sub_category_id == \App\Models\Post::SUB_CATEGORY_RULE) {
                $webHook = config('assets.discord.web_hook.rule');
                $discord =
                    'ポケカ掲示板に以下のルール質問が投稿されました。' . PHP_EOL .
                    'ルールに詳しい人は迷える子羊を救ってあげましょう！' . PHP_EOL .
                    PHP_EOL .
                    '【ルール質問】' . $post->title . PHP_EOL .
                    PHP_EOL .
                    $link;
            }
            $this->discordPost($discord, $webHook);
        }
    }

    /**
     *
     */
    public function tweetPromotion()
    {
        if(config('assets.common.appEnv') == 'production'){
            $apiKeys = config('assets.twitter.pokemon');

            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ';

            $randKey  =  array_rand(config('assets.tweet.promotion.promotion'));
            $tweet  =  config('assets.tweet.promotion.promotion')[$randKey];

            // 画像付きTweetの場合はこっち
            if($randKey > 1000){
                // 対戦マッチング  によるメール文
                $tweet =
                    $tweet . PHP_EOL .
                    $hashTag
                ;
                $this->twitterRepository->imageTweet($apiKeys, $tweet);

            }else{
                // 対戦マッチング  によるメール文
                $tweet =
                    $tweet .
                    PHP_EOL .
                    $hashTag . PHP_EOL .
                    'https://line.me/ti/g2/Kt5eTJpAKQ9eV-De1_m7jeJA1XLIKaQFypvEZg?utm_source=invitation&utm_medium=link_copy&utm_campaign=default'
                ;

                $this->twitterRepository->tweet($apiKeys, $tweet);
            }

        }
    }

    /**
     * @param $message
     * @param $webHook
     */
    public function discordPost($message, $webHook)
    {
        $data = array("content" => $message, "username" => 'TCGRating');
        $headers[] = "Content-Type: application/json";

        $curl = curl_init($webHook);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $res = curl_exec($curl);
    }
}
