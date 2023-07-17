<?php

declare(strict_types=1);

namespace App\Presenters\Api\Rank;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Dto\Http\PaginateResponseDto;
use Exception;

final class RankPresenter
{
    public function ranks(LengthAwarePaginator $gameUsers): array
    {
        return [
            'paginate' => new PaginateResponseDto(
                data: $this->getPaginateData($gameUsers),
                currentPage: $gameUsers->currentPage(),
                perPage: $gameUsers->perPage(),
                lastPage: $gameUsers->lastPage(),
                total: $gameUsers->total(),
            ),
        ];
    }

    private function getPaginateData(LengthAwarePaginator $gameUsers): Collection
    {
        return $gameUsers->getCollection()->transform(function ($gameUser) {
            return [
                'id' => $gameUser->user->id,
                'name' => $gameUser->user->name,
                'profileImagePath' => $gameUser->user->profile_image_path,
                'rate' => $gameUser->rate,
            ];
        });
    }
}
