<?php

namespace App\Repositories;

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

}
