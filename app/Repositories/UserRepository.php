<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;

final class UserRepository
{
    public function create(array $data)
    {
        $user = new User();
        if (isset($data['twitter_id'])) {
            $user->twitter_id = $data['twitter_id'];
        }
        if (isset($data['apple_code'])) {
            $user->apple_code = $data['apple_code'];
        }
        $user->selected_game_id = $data['game_id'];
        $user->name             = $data['name'];
        $user->email            = $data['email'];
        $user->password         = $data['password'];
        if (isset($data['body'])) {
            $user->body         = $data['body'];
        }
        if (isset($data['twitter_nickname'])) {
            $user->twitter_nickname = $data['twitter_nickname'];
        }
        if (isset($data['twitter_image_url'])) {
            $user->twitter_image_url = $data['twitter_image_url'];
        }
        if (isset($data['twitter_simple_image_url'])) {
            $user->twitter_simple_image_url = $data['twitter_simple_image_url'];
        }
        $user->save();

        return $user;
    }

    public function update(int $id, array $data): User
    {
        $user = User::find($id);
        if (isset($data['name'])) {
            $user->name = $data['name'];
        }
        if (isset($data['first_name'])) {
            $user->first_name = $data['first_name'];
        }
        if (isset($data['last_name'])) {
            $user->last_name = $data['last_name'];
        }
        if (isset($data['email'])) {
            $user->email = $data['email'];
        }
        if (isset($data['tel'])) {
            $user->tel = $data['tel'];
        }
        if (isset($data['post_code'])) {
            $user->post_code = $data['post_code'];
        }
        if (isset($data['prefecture_id'])) {
            $user->prefecture_id = $data['prefecture_id'];
        }
        if (isset($data['address1'])) {
            $user->address1 = $data['address1'];
        }
        if (isset($data['address2'])) {
            $user->address2 = $data['address2'];
        }
        if (isset($data['address3'])) {
            $user->address3 = $data['address3'];
        }
        if (isset($data['body'])) {
            $user->body = $data['body'];
        }
        if (isset($data['gender'])) {
            $user->gender = $data['gender'];
        }
        if (isset($data['twitter_id'])) {
            $user->twitter_id = $data['twitter_id'];
        }
        if (isset($data['twitter_nickname'])) {
            $user->twitter_nickname = $data['twitter_nickname'];
        }
        if (isset($data['twitter_image_url'])) {
            $user->twitter_image_url = $data['twitter_image_url'];
        }
        if (isset($data['apple_code'])) {
            $user->apple_code = $data['apple_code'];
        }
        if (isset($data['twitter_simple_image_url'])) {
            $user->twitter_simple_image_url = $data['twitter_simple_image_url'];
        }
        if (isset($data['stripe_id'])) {
            $user->stripe_id = $data['stripe_id'];
        }
        $user->save();

        return $user;
    }

    public function updateSelectedGameId($data)
    {
        $user = User::find($data->id);
        $user->selected_game_id = $data->selected_game_id;
        $user->save();

        return $user;
    }

    public function find($id) {
        return User::find($id);
    }

    public function findAll($data) {
        $query = User::query();
        if (isset($data->not_null_twitter_id)) {
            $query->whereNotNull('twitter_id');
        }
        return $query->get();
    }

    public function findByTwitterId($id)
    {
        return User::where('twitter_id', $id)->first();
    }

    public function findByAppleCode($code) {
        return User::where('apple_code', $code)->first();
    }

    public function composeWhereClause($data)
    {
        $query = User::query();
        return $query;
    }

    public function findAllBySendMail($data) {
        $query = $this->composeWhereClause($data);

        return $query->whereNotIn('id', [$data->user_id])
                  ->whereHas('gameUsers', function ($query) use ($data) {
                      $query->where('game_id', $data->game_id);
                      $query->where('is_mail_send', true);
                  })
                  ->where('email', 'not like', '%test@test.jp%')
                  ->whereNotNull('email')
                  ->get();

    }

}
