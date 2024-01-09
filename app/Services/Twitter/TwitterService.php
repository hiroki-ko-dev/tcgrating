<?php

namespace App\Services\Twitter;

use App\Enums\EventRateType;
use App\Enums\PostSubCategory;
use Illuminate\Support\Str;
use Yasumi\Yasumi;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterService
{
    public function tweet($apiKeys, $tweet)
    {
        $twitter = new TwitterOAuth(
            $apiKeys['API_KEY'],
            $apiKeys['API_SECRET'],
            $apiKeys['API_ACCESS_TOKEN'],
            $apiKeys['API_ACCESS_TOKEN_SECRET']
        );
        // $twitter->setBearer($apiKeys['BEARER_TOKEN']);
        $twitter->setApiVersion("2");
        $twitter->post(
            'tweets',
            [
                "text" => $tweet
            ],
            true
        );

        // HTTPステータスコードを取得
        $httpCode = $twitter->getLastHttpCode();
        // 成功した場合、HTTPステータスコードは200になります
        if ($httpCode == 200) {
            // ツイートが成功した
            return true;
        } else {
            // エラーが発生した場合、詳細を取得
            $error = $twitter->getLastBody();
            // エラーの内容を返すか、例外を投げる
            return $error;
        }
    }

    public function imageTweet($apiKeys, $tweet)
    {
        $twitter = new TwitterOAuth(
            $apiKeys['API_KEY'],
            $apiKeys['API_SECRET'],
            $apiKeys['API_ACCESS_TOKEN'],
            $apiKeys['API_ACCESS_TOKEN_SECRET']
        );

        // ④画像をアップロードし、画像のIDを取得
        $imageId = $twitter->upload('media/upload', ['media' => 'public/images/site/resume/pokeka-resume.png']);
        $twitter->setBearer($apiKeys['BEARER_TOKEN']);
        $twitter->setApiVersion("2");
        $twitter->post("statuses/update", [
            "status" => $tweet,
            'media_ids' => implode(',', [  // 画像の指定
                $imageId->media_id_string
            ])
        ]);

        return $twitter;
    }

    public function imagesTweet(array $apiKeys, string $tweet, array $images, ?string $replyToTweetId): string
    {
        $twitter = new TwitterOAuth(
            $apiKeys['API_KEY'],
            $apiKeys['API_SECRET'],
            $apiKeys['API_ACCESS_TOKEN'],
            $apiKeys['API_ACCESS_TOKEN_SECRET']
        );

        $mediaIds = [];
        foreach ($images as $imagePath) {
            // 画像をアップロードし、各画像のIDを取得
            $uploadedMedia = $twitter->upload('media/upload', ['media' => $imagePath]);
            if (isset($uploadedMedia->media_id_string)) {
                $mediaIds[] = $uploadedMedia->media_id_string;
            }
        }

        $postData = [
            'text' => $tweet,
            'media' => [
                'media_ids' => $mediaIds
            ]
        ];
        if ($replyToTweetId) {
            $postData['reply'] =  [
                'in_reply_to_tweet_id' => $replyToTweetId
            ];
        }

        $tweetId = null;
        if (!empty($mediaIds)) {
            // 画像のIDを使ってツイートを投稿
            $twitter->setApiVersion("2");
            $response = $twitter->post("tweets", $postData, true);
            if (isset($response->data) && isset($response->data->id)) {
                $tweetId = $response->data->id;
                \Log::debug("Tweet ID: " . $tweetId);
            } else {
                \Log::error(print_r($response, true));
                \Log::error("Tweet ID not found in the response");
            }
        }

        // // HTTPステータスコードを取得
        // $httpCode = $twitter->getLastHttpCode();
        // // 成功した場合、HTTPステータスコードは200になります
        // if ($httpCode !== 200) {
        //     // エラーが発生した場合、詳細を取得
        //     $error = $twitter->getLastBody();
        //     // エラーの内容を返すか、例外を投げる
        //     return $error;
        // }

        return (string)$tweetId;
    }

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

    public function tweetByMakeEvent($event)
    {
        // Twitterの遊戯王アカウントでTweet
        if ($event->game_id == 1 || $event->game_id == 2) {
            $apiKeys = config('assets.twitter.yugioh');
            $hashTag = '#遊戯王デュエルリンクス ';

        // TwitterのポケモンアカウントでTweet
        } elseif ($event->game_id == 3) {
            $apiKeys = config('assets.twitter.pokemon');
            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ #discordポケカ';
        }

        // イベント作成によるメール文
        $tweet =
            $event->user->name . 'さんが対戦相手を探しています' . PHP_EOL .
            '対戦ゲーム：' . $event->game->name . PHP_EOL .
            '対戦日時' . date('Y/m/d H:i', strtotime($event->date . ' ' . $event->start_time)) . PHP_EOL .
            PHP_EOL .
            '以下のURLから対戦を受けましょう!' . PHP_EOL .
            'https://hashimu.com/event/single/' . $event->id . '?selected_game_id=' . $event->game_id . ' ' . PHP_EOL .
            $hashTag;

        if (config('assets.common.appEnv') == 'production') {
            $this->tweet($apiKeys, $tweet);
        }
    }

    public function tweetByMakeInstantEvent($event)
    {
        // Twitterの遊戯王アカウントでTweet
        if ($event->game_id == 1 || $event->game_id == 2) {
            $apiKeys = config('assets.twitter.yugioh');
            $hashTag = '#遊戯王デュエルリンクス ';

            // TwitterのポケモンアカウントでTweet
        } elseif ($event->game_id == 3) {
            $apiKeys = config('assets.twitter.pokemon');
//            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ #discordポケカ';
            $hashTag = '';
        }

        // イベント作成によるメール文
        $tweet =
            $event->user->name . 'さんが対戦相手を探しています' . PHP_EOL .
            '対戦ゲーム：' . $event->game->name . PHP_EOL .
            '対戦日時' . date('Y/m/d H:i', strtotime($event->date)) . PHP_EOL .
            PHP_EOL .
            'https://hashimu.com/duel/instant/' . $event->eventDuels[0]->duel_id . '?selected_game_id=' . $event->game_id . ' ' . PHP_EOL .
            'URLから対戦を受けましょう!' . PHP_EOL .
            $hashTag;

        if ($event->rate_type == EventRateType::RATE->value) {
            $table = 'レート対戦';
            $webHook = config('assets.discord.web_hook.rate');
        } else {
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

        if (config('assets.common.appEnv') == 'production') {
            $this->tweet($apiKeys, $tweet);
            $this->discordPost($discord, $webHook);
        }
    }

    public function tweetByMatching($event)
    {
        // Twitterの遊戯王アカウントでTweet
        if ($event->game_id == 1 || $event->game_id == 2) {
            $apiKeys = config('assets.twitter.yugioh');
            $hashTag = '#遊戯王デュエルリンクス ';

            // TwitterのポケモンアカウントでTweet
        } elseif ($event->game_id == 3) {
            $apiKeys = config('assets.twitter.pokemon');
            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ #discordポケカ';
        }

        // 対戦マッチング  によるメール文
        $tweet =
            '@' . $event->user->twitter_nickname . PHP_EOL .
            $event->eventUsers[1]->user->name . 'さんと対戦がマッチングしました' . PHP_EOL .
            '対戦ゲーム：' . $event->game->name . PHP_EOL .
            '対戦日時' . date('Y/m/d H:i', strtotime($event->date . ' ' . $event->start_time)) . PHP_EOL .
            PHP_EOL .
            '対戦の準備をしましょう！' . PHP_EOL .
            'https://hashimu.com/event/single/' . $event->id . '?selected_game_id=' . $event->game_id . ' ' . PHP_EOL .
            $hashTag;

        if (config('assets.common.appEnv') == 'production') {
            $this->tweet($apiKeys, $tweet);
        }
    }

    public function tweetByInstantMatching($duel)
    {
        // Twitterの遊戯王アカウントでTweet
        if ($duel->game_id == 1 || $duel->game_id == 2) {
            $apiKeys = config('assets.twitter.yugioh');
            $hashTag = '#遊戯王デュエルリンクス ';

            // TwitterのポケモンアカウントでTweet
        } elseif ($duel->game_id == 3) {
            $apiKeys = config('assets.twitter.pokemon');
//            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ #discordポケカ';
            $hashTag = '';
        }

        // 対戦マッチング  によるメール文
        $tweet =
            '@' . $duel->user->twitter_nickname . PHP_EOL .
            $duel->duelUsers[1]->user->name . 'さんと対戦がマッチングしました' . PHP_EOL .
            PHP_EOL .
            'https://hashimu.com/duel/instant/' . $duel->id . '?selected_game_id=' . $duel->game_id . ' ' . PHP_EOL .
            '対戦ゲーム：' . $duel->game->name . PHP_EOL .
            '対戦の準備をしましょう！' . PHP_EOL .
            $hashTag;

        if ($duel->eventDuel->event->rate_type == EventRateType::RATE->value) {
            $table = 'レート対戦';
            $webHook = config('assets.discord.web_hook.rate');
        } else {
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

        if (config('assets.common.appEnv') == 'production') {
            $this->tweet($apiKeys, $tweet);
            $this->discordPost($discord, $webHook);
        }
    }

    public function tweetByDuelFinish($duel)
    {
        // Twitterの遊戯王アカウントでTweet
        if ($duel->game_id == 1 || $duel->game_id == 2) {
            $apiKeys = config('assets.twitter.yugioh');
            $hashTag = '#遊戯王デュエルリンクス ';

            // TwitterのポケモンアカウントでTweet
        } elseif ($duel->game_id == 3) {
            $apiKeys = config('assets.twitter.pokemon');
            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ #discordポケカ';
        }

        if ($duel->duelUsers[0]->duelUserResults->sum('rating') > $duel->duelUsers[1]->duelUserResults->sum('rating')) {
            $result = $duel->duelUsers[0]->user->name . 'さんの勝利です。' . PHP_EOL;
        } elseif ($duel->duelUsers[0]->duelUserResults->sum('rating') < $duel->duelUsers[1]->duelUserResults->sum('rating')) {
            $result = $duel->duelUsers[1]->user->name . 'さんの勝利です。' . PHP_EOL;
        } else {
            $result = 'ドローです。' . PHP_EOL;
        }

        // 対戦マッチング  によるメール文
        $tweet =
            '対戦が完了いたしました！' . PHP_EOL .
            '勝負の結果は' . $result . PHP_EOL .
            'お疲れ様でした！' . PHP_EOL .
             PHP_EOL .
            '対戦ゲーム：' . $duel->game->name . PHP_EOL .
            '対戦日時' . date('Y/m/d H:i', strtotime($duel->eventDuel->event->date . ' ' . $duel->eventDuel->event->start_time)) . PHP_EOL .
            'https://hashimu.com/event/single/' . $duel->eventDuel->event->id . '?selected_game_id=' . $duel->game_id . ' ' . PHP_EOL .
            $hashTag;

        if (config('assets.common.appEnv') == 'production') {
            $this->tweet($apiKeys, $tweet);
        }
    }

    public function tweetByInstantDuelFinish($duel)
    {
        // Twitterの遊戯王アカウントでTweet
        if ($duel->game_id == 1 || $duel->game_id == 2) {
            $apiKeys = config('assets.twitter.yugioh');
            $hashTag = '#遊戯王デュエルリンクス ';

            // TwitterのポケモンアカウントでTweet
        } elseif ($duel->game_id == 3) {
            $apiKeys = config('assets.twitter.pokemon');
//            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ #discordポケカ';
            $hashTag = '';
        }

        if ($duel->duelUsers[0]->duelUserResults->sum('rating') > $duel->duelUsers[1]->duelUserResults->sum('rating')) {
            $result = $duel->duelUsers[0]->user->name . 'さんの勝利です。' . PHP_EOL;
            $rate = $duel->duelUsers[0]->duelUserResults->sum('rating');
        } elseif ($duel->duelUsers[0]->duelUserResults->sum('rating') < $duel->duelUsers[1]->duelUserResults->sum('rating')) {
            $result = $duel->duelUsers[1]->user->name . 'さんの勝利です。' . PHP_EOL;
            $rate = $duel->duelUsers[1]->duelUserResults->sum('rating');
        } else {
            $result = 'ドローです。' . PHP_EOL;
            $rate = 0;
        }

        // 対戦マッチング  によるメール文
        $tweet =
            '対戦が完了いたしました！' . PHP_EOL .
            '勝負の結果は' . $result . PHP_EOL .
            'レートが' . $rate . 'ポイント上昇します。' . PHP_EOL .
            'お疲れ様でした！' . PHP_EOL .
            PHP_EOL .
            'https://hashimu.com/duel/instant/' . $duel->id . '?selected_game_id=' . $duel->game_id . ' ' . PHP_EOL .
            '対戦ゲーム：' . $duel->game->name . PHP_EOL .
            '対戦日時' . date('Y/m/d H:i', strtotime($duel->eventDuel->event->date . ' ' . $duel->eventDuel->event->start_time)) . PHP_EOL .
            $hashTag;

        if (config('assets.common.appEnv') == 'production') {
            $this->tweet($apiKeys, $tweet);
        }
    }

    public function tweetByEventPostNotice($event, $users)
    {
        // Twitterの遊戯王アカウントでTweet
        if ($event->game_id == 1 || $event->game_id == 2) {
            $apiKeys = config('assets.twitter.yugioh');
            $hashTag = '#遊戯王デュエルリンクス ';

        // TwitterのポケモンアカウントでTweet
        } elseif ($event->game_id == 3) {
            $apiKeys = config('assets.twitter.pokemon');
            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ';
        }

        foreach ($users as $user) {
            // 対戦マッチング  によるメール文
            $tweet =
                '@' . $user->twitter_nickname . PHP_EOL .
                '参加しているイベント受付掲示板が更新されました。確認しましょう。' . PHP_EOL .
                PHP_EOL .
                '対戦ゲーム：' . $event->game->name . PHP_EOL .
                '対戦日時' . date('Y/m/d H:i', strtotime($event->date . ' ' . $event->start_time)) . PHP_EOL .
                'https://hashimu.com/event/single/' . $event->id . '?selected_game_id=' . $event->game_id . ' ' . PHP_EOL .
                $hashTag;
            if(config('assets.common.appEnv') == 'production') {
                $this->tweet($apiKeys, $tweet);
            }
        }
    }

    public function tweetByDuelPostNotice($duel, $users)
    {
        // Twitterの遊戯王アカウントでTweet
        if ($duel->game_id == 1 || $duel->game_id == 2) {
            $apiKeys = config('assets.twitter.yugioh');
            $hashTag = '#遊戯王デュエルリンクス ';

            // TwitterのポケモンアカウントでTweet
        } elseif ($duel->game_id == 3) {
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

            if (config('assets.common.appEnv') == 'production') {
                $this->tweet($apiKeys, $tweet);
            }
        }
    }

    public function tweetBySwissEvent($event, $phase)
    {
        $apiKeys = config('assets.twitter.pokemon');
        $hashTag = '#ポケモンカード #ポケカ #リモートポケカ #discordポケカ';
        $webHook = config('assets.discord.web_hook.tournament');

        // 大会が開催された時の告知
        if ($phase == 'create') {
            $content = 'https://hashimu.com/event/swiss/' . $event->id . PHP_EOL;
            $content = $content . PHP_EOL .
              'スイスドロー3戦の大会が開催されます。' . PHP_EOL .
              'URLから参加申し込みをしましょう！' . PHP_EOL .
               PHP_EOL .
              '対戦日時' . date('Y/m/d H:i', strtotime($event->date . ' ' . $event->start_time . ' ~ ' . $event->end_time));
        } elseif ($phase == 'attendance') {
            $content = 'https://hashimu.com/event/swiss/' . $event->id . PHP_EOL;
            $content = $content . PHP_EOL .
              '大会の出欠をとります。' . PHP_EOL .
              '参加者はURLより出席ボタンを押してください。' . PHP_EOL .
              '開始までに出席ボタンを幼かった場合、参加できませんので注意してください。';

        } elseif ($phase == 'duel') {
            $content = 'https://hashimu.com/event/swiss/' . $event->id . '?match_number=1' . PHP_EOL;
            $content = $content . PHP_EOL .
              '1回線の組み合わせが決まりました' . PHP_EOL .
              'URLから1回線の対戦場所を確認し、対戦を始めましょう！' . PHP_EOL .
              '・対戦相手がそろったら開始' . PHP_EOL .
              '・5分以内に相手が来なければ不戦勝' . PHP_EOL .
              '・試合が終わったら勝利者が「勝利」ボタンを押す';
        } elseif ($phase == 'finish') {
            $content = 'https://hashimu.com/event/swiss/' . $event->id . PHP_EOL;
            $content = $content . PHP_EOL .
              '大会が終了いたしました。' . PHP_EOL .
              '結果はURLをご確認ください。' . PHP_EOL .
              'お疲れ様でした！';
        }

        if (config('assets.common.appEnv') == 'production') {
            $this->discordPost($content, $webHook);
            $content = $content . PHP_EOL . $hashTag;
            $this->tweet($apiKeys, $content);
        }
    }

    public function tweetByStorePost($post)
    {
        if (config('assets.common.appEnv') == 'production') {
            $apiKeys = config('assets.twitter.pokeka_info');

            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ';
            $link = 'https://hashimu.com/posts/' . $post->id . '?selected_game_id=' . $post->game_id . '&remotopokeka=1';

            // 対戦マッチング  によるメール文
            $tweet =
                '【ポケカ掲示板】【' . PostSubCategory::from($post->sub_category_id)->description() . '】' . $post->title . PHP_EOL .
                PHP_EOL .
                $link . PHP_EOL .
                PHP_EOL .
                $hashTag;

            $this->tweet($apiKeys, $tweet);

            if ($post->sub_category_id === PostSubCategory::FREE->value) {
                $webHook = config('assets.discord.web_hook.chat');
                $discord =
                    'ポケカ掲示板に以下のトークが投稿されました。' . PHP_EOL .
                    'みんなでトークを開始しましょう！' . PHP_EOL .
                    PHP_EOL .
                    $post->title . PHP_EOL .
                    PHP_EOL .
                    $link;
            } elseif ($post->sub_category_id === PostSubCategory::DECK->value) {
                $webHook = config('assets.discord.web_hook.deck');
                $discord =
                    'ポケカ掲示板に以下のデッキ相談が投稿されました。' . PHP_EOL .
                    'デッキ構築が上手い人は迷える子羊を救ってあげましょう！' . PHP_EOL .
                    PHP_EOL .
                    '【デッキ相談】' . $post->title . PHP_EOL .
                    PHP_EOL .
                    $link;
            } elseif ($post->sub_category_id === PostSubCategory::RULE->value) {
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

    public function tweetByBlog($blog)
    {
        if (config('assets.common.appEnv') == 'production') {
            $apiKeys = config('assets.twitter.pokeka_info');

            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ';
            $link = 'https://hashimu.com/blogs/' . $blog->id . '?selected_game_id=' . $blog->game_id . '&remotopokeka=1';

            // 対戦マッチング  によるメール文
            $tweet =
                '【ポケカ記事】' . $blog->title . PHP_EOL .
                PHP_EOL .
                $link . PHP_EOL .
                PHP_EOL .
                $hashTag;

            $this->tweet($apiKeys, $tweet);

                $webHook = config('assets.discord.web_hook.blog');
                $discord =
                    'ポケカ記事が更新されました。' . PHP_EOL .
                    '最新情報をチェックしましょう！！' . PHP_EOL .
                    PHP_EOL .
                    '【ポケカ記事】' . $blog->title . PHP_EOL .
                    PHP_EOL .
                    $link;

            $this->discordPost($discord, $webHook);
        }
    }

    public function tweetByAffiliate($blog)
    {
        if (config('assets.common.appEnv') == 'production') {

            $hashTag = '#ポケモンカード #ポケカ #リモートポケカ';

            $blog->body = str_replace('<p>', '', $blog->body);
            $blog->body = str_replace('</p>', '', $blog->body);

            // Twitter投稿
            $content =
                $blog->title . PHP_EOL .
                PHP_EOL .
                $blog->affiliate_url . PHP_EOL .
                PHP_EOL .
                $hashTag . PHP_EOL .
                PHP_EOL .
                $blog->body;
            $tweet = Str::limit($content, 135, '...');

            // remotoPokeka
            $apiKeys = config('assets.twitter.pokemon');
            $this->tweet($apiKeys, $tweet);
            // pokekaInfo
            $apiKeys = config('assets.twitter.pokeka_info');
            $this->tweet($apiKeys, $tweet);

            // discord投稿
            $webHook = config('assets.discord.web_hook.affiliate');
            $content =
                $blog->title . PHP_EOL .
                PHP_EOL .
                'https://hashimu.com/blogs/' . $blog->id . PHP_EOL .
                PHP_EOL .
                $blog->body;
            $discord = Str::limit($content, 200, '...');

            $this->discordPost($discord, $webHook);
        }
    }

    public function tweetPromotion()
    {
        if (config('assets.common.appEnv') == 'production') {
            $apiKeys = config('assets.twitter.pokeka_battle');

            $now = now();
            $holidays = Yasumi::create('Japan', $now->year);

            $dayOfWeek = date('w');
            // 月曜日は1、日曜日は0
            if ($dayOfWeek > 0 && $dayOfWeek < 6 && !$holidays->isHoliday($now)) { // 月曜日から金曜日の場合
                $number = rand(110, 160);
            } else { // 土曜日または日曜日の場合
                $number = rand(200, 260);
            }
            $tweet = "本日はリモートポケカの対戦が" . $number . "戦ありました";
            $this->tweet($apiKeys, $tweet);

            // $hashTag = '#ポケモンカード #ポケカ #リモートポケカ';
            // $randKey  =  array_rand(config('assets.tweet.promotion.promotion'));
            // $tweet  =  config('assets.tweet.promotion.promotion')[$randKey];

            // 画像付きTweetの場合はこっち
            // if ($randKey > 1000) {
            //     // 対戦マッチング  によるメール文
            //     $tweet =
            //         $tweet . PHP_EOL .
            //         $hashTag
            //     ;
            //     $this->imageTweet($apiKeys, $tweet);
            // } else {
            //     // 対戦マッチング  によるメール文
            //     $tweet =
            //         $tweet .
            //         PHP_EOL .
            //         $hashTag . PHP_EOL .
            //         'https://line.me/ti/g2/Kt5eTJpAKQ9eV-De1_m7jeJA1XLIKaQFypvEZg?utm_source=invitation&utm_medium=link_copy&utm_campaign=default'
            //     ;

            //     $this->tweet($apiKeys, $tweet);
            // }
        }
    }

    public function tweetSpreadAffiliate($spreadSheet, $apiKeys)
    {
        if (config('assets.common.appEnv') == 'production') {

            $randKey  =  array_rand($spreadSheet);

            if (!isset($spreadSheet[$randKey][0], $spreadSheet[$randKey][1], $spreadSheet[$randKey][2], $spreadSheet[$randKey][4])) {
                throw new \Exception("スプレッドシートのデータエラー: " . print_r($spreadSheet[$randKey], true), 403);
            }
            $title = $spreadSheet[$randKey][0];
            $url = $spreadSheet[$randKey][1];
            $content = $spreadSheet[$randKey][2];
            // $no = $spreadSheet[$randKey][3];
            $hashTag = $spreadSheet[$randKey][4];

            // メール文
            $tweet =
                $title . PHP_EOL .
                PHP_EOL .
                $hashTag . PHP_EOL .
                $url . PHP_EOL .
                PHP_EOL .
                $content
            ;

            $tweet = Str::limit($tweet, 250, '...');
            $this->tweet($apiKeys, $tweet);
        }
    }

    public function tweetSpreadNormal($spreadSheet, $apiKeys)
    {

        if (config('assets.common.appEnv') == 'production') {

            $randKey  =  array_rand($spreadSheet);

            $content = $spreadSheet[$randKey][0];
            $no = $spreadSheet[$randKey][1];

            $tweet = $content;

            $tweet = Str::limit($tweet, 250, '...');
            $this->tweet($apiKeys, $tweet);
        }
    }
}
