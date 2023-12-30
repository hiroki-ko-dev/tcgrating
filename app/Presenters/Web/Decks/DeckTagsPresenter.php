<?php

declare(strict_types=1);

namespace App\Presenters\Web\Decks;

use Illuminate\Support\Collection;
use App\Models\DeckTag;
use stdClass;

final class DeckTagsPresenter
{
    public function getResponse(Collection $deckTags): Collection
    {
        return $deckTags->map(function (DeckTag $deckTag) {
            $tagData = new stdClass();
            $tagData->id = $deckTag->id;
            $tagData->name = $deckTag->name;
            return $tagData;
        });
    }
}
