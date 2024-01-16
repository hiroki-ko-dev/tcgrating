<?php

declare(strict_types=1);

namespace App\Services\Decks;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Repositories\Deck\DeckRepository;
use App\Models\Deck;
use App\Models\DeckTag;
use App\Models\DeckTagDeck;

class DecksService
{
    public function __construct(
        protected readonly DeckRepository $deckRepository,
    ) {
    }

    public function createDeckTagDeck(array $attrs): void
    {
        $this->deckRepository->createDeckTagDeck($attrs);
    }

    public function findDeck(int $deckId): Deck
    {
        return $this->deckRepository->findDeck($deckId);
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

    public function updateDeckTagDeck(int $deckId, int $deckTagId, array $attrs): void
    {
        $this->deckRepository->updateDeckTagDeck($deckId, $deckTagId, $attrs);
    }

    public function deleteDeckTagDeck(int $deckId, int $deckTagId): void
    {
        $this->deckRepository->deleteDeckTagDeck($deckId, $deckTagId);
    }
}
