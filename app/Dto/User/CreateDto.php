<?php

namespace App\Dto\User;

class CreateDto
{
    public function __construct(
        public readonly array $data,
    ) {
    }
}
