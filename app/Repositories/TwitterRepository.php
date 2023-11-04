<?php

namespace App\Repositories;

require_once "vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterRepository
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
        \Log::debug(print_r($httpCode, true));
        // 成功した場合、HTTPステータスコードは200になります
        if ($httpCode == 200) {
            // ツイートが成功した
            return true;
        } else {
            // エラーが発生した場合、詳細を取得
            $error = $twitter->getLastBody();

            // エラーメッセージをログに記録するか、適切に処理する
            // error_log(print_r($error, true)); // PHPのerror_logを使う場合
            // Laravelの場合はLogファサードを使用できます:
            \Log::debug(print_r($error, true));

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

}
