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

        $twitter->post("statuses/update", [
            "status" => $tweet
        ]);

        return $twitter;
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
        $imageId = $twitter->upload('media/upload', ['media' => env('APP_URL') . '/images/site/user/pokeka-resume.png']);

        $twitter->post("statuses/update", [
            "status" => $tweet,
            'media_ids' => implode(',', [  // 画像の指定
                $imageId->media_id_string
            ])
        ]);

        return $twitter;
    }

}
