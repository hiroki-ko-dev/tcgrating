<?php

namespace App\Dto\Http;

class ResponseDto
{
    public function __construct(
        public readonly array $data,
        public readonly int $code,
        public readonly string $message,
    ) {
    }
}
