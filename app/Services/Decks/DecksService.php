<?php

declare(strict_types=1);

namespace App\Services\Decks;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Repositories\Deck\DeckRepository;
use App\Models\DeckTag;

class DecksService
{
    public function __construct(
        protected readonly DeckRepository $deckRepository,
    ) {
    }

    public function findDeckTag(int $deckTagId): ?DeckTag
    {
        return $this->deckRepository->findDeckTag($deckTagId);
    }

    public function findAllDeckTags(array $filters): Collection
    {
        return $this->deckRepository->findAllDeckTags($filters);
    }

    public function paginateDecks(array $filters, int $row, int $page): LengthAwarePaginator
    {
        return $this->deckRepository->paginate($filters, $row, $page);
    }
}
