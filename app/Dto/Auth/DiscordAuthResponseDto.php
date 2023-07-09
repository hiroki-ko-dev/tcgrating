<?php

namespace App\Dto\Auth;

class DiscordAuthResponseDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $nickname,
        public readonly string $email,
        public readonly string $profileImagePath,
    ) {
    }
}
