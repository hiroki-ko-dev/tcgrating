<?php

namespace App\Dto\Http;

use Illuminate\Support\Collection;

class PaginateResponseDto
{
    public function __construct(
        public readonly Collection $data,
        public readonly int $currentPage,
        public readonly int $perPage,
        public readonly int $lastPage,
        public readonly int $total,
    ) {
    }
}
