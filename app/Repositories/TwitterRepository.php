<?php

namespace App\Repositories;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterRepository
{

    public function tweet($apiKeys, $event)
    {
        $twitter = new TwitterOAuth(
            $apiKeys['API_KEY'],
            $apiKeys['API_SECRET'],
            $apiKeys['API_ACCESS_TOKEN'],
            $apiKeys['API_ACCESS_TOKEN_SECRET']
        );

        $twitter->post("statuses/update", [
            "status" =>
                $event->user->name. 'さんが対戦相手を探しています' . PHP_EOL .
                '対戦ゲーム：' . $event->game->name . PHP_EOL .
                '対戦日時' . date('Y/m/d H:i', strtotime($event->date.' '.$event->start_time)) . PHP_EOL .
                PHP_EOL .
                '以下のURLから対戦を受けましょう!' . PHP_EOL .
                'https://hashimu.com/event/single/' . $event->id . '?selected_game_id=' . $event->game_id . ' '
        ]);

        return $twitter;
    }

}
