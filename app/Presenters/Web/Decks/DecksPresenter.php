<?php

declare(strict_types=1);

namespace App\Presenters\Web\Decks;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Deck;
use App\Models\DeckTag;
use stdClass;

final class DecksPresenter
{
    public function getResponse(LengthAwarePaginator $decks): LengthAwarePaginator
    {
        // 各デッキデータを変換する
        $transformedData = $decks->getCollection()->map(function (Deck $deck) {
            $deckData = new stdClass();
            $deckData->id = $deck->id;
            $deckData->code = $deck->code;
            $deckData->name = $deck->officialEvent->name;
            $deckData->imageUrl = $deck->image_url;
            $deckData->organizer_name = $deck->officialEvent->organizer_name;
            $deckData->date = $deck->officialEvent->date;
            $deckData->rank = $deck->rank;
            $deckData->tags = $this->getTags($deck->deckTags);
            $deckData->createdAt = $deck->created_at;
            $deckData->updatedAt = $deck->updated_at;
            return $deckData;
        });

        // LengthAwarePaginatorに変換したデータをセット
        $decks->setCollection($transformedData);

        return $decks;
    }

    private function getTags(Collection $deckTags): Collection
    {
        return $deckTags->map(function (DeckTag $deckTag) {
            $tagData = new stdClass();
            $tagData->id = $deckTag->id;
            $tagData->name = $deckTag->name;
            return $tagData;
        });
    }
}

