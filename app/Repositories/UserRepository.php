<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;

final class UserRepository
{
    public function create(array $attrs)
    {
        $user = new User();
        if (isset($attrs['twitter_id'])) {
            $user->twitter_id = $attrs['twitter_id'];
        }
        if (isset($attrs['apple_code'])) {
            $user->apple_code = $attrs['apple_code'];
        }
        $user->selected_game_id = $attrs['selected_game_id'];
        $user->name             = $attrs['name'];
        $user->email            = $attrs['email'];
        $user->password         = $attrs['password'];
        if (isset($attrs['body'])) {
            $user->body         = $attrs['body'];
        }
        if (isset($attrs['twitter_nickname'])) {
            $user->twitter_nickname = $attrs['twitter_nickname'];
        }
        if (isset($attrs['twitter_image_url'])) {
            $user->twitter_image_url = $attrs['twitter_image_url'];
        }
        if (isset($attrs['twitter_simple_image_url'])) {
            $user->twitter_simple_image_url = $attrs['twitter_simple_image_url'];
        }
        $user->save();

        return $user;
    }

    public function update(int $id, array $attrs): User
    {
        $user = User::find($id);
        if (isset($attrs['name'])) {
            $user->name = $attrs['name'];
        }
        if (isset($attrs['first_name'])) {
            $user->first_name = $attrs['first_name'];
        }
        if (isset($attrs['last_name'])) {
            $user->last_name = $attrs['last_name'];
        }
        if (isset($attrs['email'])) {
            $user->email = $attrs['email'];
        }
        if (isset($attrs['tel'])) {
            $user->tel = $attrs['tel'];
        }
        if (isset($attrs['post_code'])) {
            $user->post_code = $attrs['post_code'];
        }
        if (isset($attrs['prefecture_id'])) {
            $user->prefecture_id = $attrs['prefecture_id'];
        }
        if (isset($attrs['address1'])) {
            $user->address1 = $attrs['address1'];
        }
        if (isset($attrs['address2'])) {
            $user->address2 = $attrs['address2'];
        }
        if (isset($attrs['address3'])) {
            $user->address3 = $attrs['address3'];
        }
        if (isset($attrs['body'])) {
            $user->body = $attrs['body'];
        }
        if (isset($attrs['gender'])) {
            $user->gender = $attrs['gender'];
        }
        if (isset($attrs['twitter_id'])) {
            $user->twitter_id = $attrs['twitter_id'];
        }
        if (isset($attrs['twitter_nickname'])) {
            $user->twitter_nickname = $attrs['twitter_nickname'];
        }
        if (isset($attrs['twitter_image_url'])) {
            $user->twitter_image_url = $attrs['twitter_image_url'];
        }
        if (isset($attrs['apple_code'])) {
            $user->apple_code = $attrs['apple_code'];
        }
        if (isset($attrs['twitter_simple_image_url'])) {
            $user->twitter_simple_image_url = $attrs['twitter_simple_image_url'];
        }
        if (isset($attrs['stripe_id'])) {
            $user->stripe_id = $attrs['stripe_id'];
        }
        $user->save();

        return $user;
    }

    public function updateSelectedGameId($attrs)
    {
        $user = User::find($attrs->id);
        $user->selected_game_id = $attrs->selected_game_id;
        $user->save();

        return $user;
    }

    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function findAll($attrs)
    {
        $query = User::query();
        if (isset($attrs->not_null_twitter_id)) {
            $query->whereNotNull('twitter_id');
        }
        return $query->get();
    }

    public function findBy(string $column, int | string $value)
    {
        return User::where($column, $value)->first();
    }

    public function findByTwitterId($id)
    {
        return User::where('twitter_id', $id)->first();
    }

    public function composeWhereClause($attrs)
    {
        $query = User::query();
        return $query;
    }

    public function findAllBySendMail($attrs) {
        $query = $this->composeWhereClause($attrs);

        return $query->whereNotIn('id', [$attrs->user_id])
                  ->whereHas('gameUsers', function ($query) use ($attrs) {
                      $query->where('game_id', $attrs->game_id);
                      $query->where('is_mail_send', true);
                  })
                  ->where('email', 'not like', '%test@test.jp%')
                  ->whereNotNull('email')
                  ->get();
    }
}
