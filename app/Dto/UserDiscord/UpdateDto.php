<?php

namespace App\Dto\User;

class UpdateDto
{
    public function __construct(
        public readonly array $data,
    ) {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }
        if (isset($data['user_id'])) {
            $this->user_id = $data['user_id'];
        }
        if (isset($data['discord_id'])) {
            $this->discord_id = $data['discord_id'];
        }
        if (isset($data['name'])) {
            $this->name = $data['name'];
        }
        if (isset($data['nickname'])) {
            $this->name = $data['nickname'];
        }
        if (isset($data['email'])) {
            $this->email = $data['email'];
        }
    }
}
