<?php

namespace App\Dto\Http;

class DiscordAuthResponseDto
{
    public function __construct(
        public readonly array $data,
        public readonly int $code,
        public readonly string $message,
    ) {
    }
}
