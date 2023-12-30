<?php

declare(strict_types=1);

namespace App\Repositories\Deck;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Deck;
use App\Models\DeckTag;

final class DeckRepository
{
    public function findDeckTag(int $deckTagId): ?DeckTag
    {
        return DeckTag::find($deckTagId);
    }

    public function paginate(array $filters, int $row, int $page): LengthAwarePaginator
    {
        return Deck::query()
            ->when(isset($filters['deckTag']), function ($query) use ($filters) {
                $query->whereHas('deckTags', function($query) use ($filters) {
                    $query->when(isset($filters['deckTag']['id']), function($query) use ($filters) {
                        $query->where('id', $filters['deckTag']['id']);
                    });
                });
            })
            ->OrderBy('updated_at', 'desc')
            ->paginate($row, ['*'], 'page', $page);
    }
}
