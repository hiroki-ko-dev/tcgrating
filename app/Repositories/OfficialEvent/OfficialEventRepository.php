<?php

declare(strict_types=1);

namespace App\Repositories\OfficialEvent;

use App\Models\OfficialEvent;
use App\Models\Deck;
use App\Models\DeckTag;
use App\Models\DeckTagDeck;

class OfficialEventRepository
{
    public function create(array $attrs): OfficialEvent | null
    {
        if ($this->findOfficialEventByOfficialEventId($attrs['official_id']) ){
            return null;
        }
        
        $officialEvent = new OfficialEvent();
        $officialEvent->official_id = $attrs['official_id'];
        $officialEvent->name = $attrs['name'];
        $officialEvent->organizer_name = $attrs['organizer_name'];
        $officialEvent->date = $attrs['date'];
        $officialEvent->save();

        foreach ($attrs['decks'] as $deckAttrs) {
            $deck = new Deck();
            $deck->key = $deckAttrs['key'];
            $deck->image_url = $deckAttrs['image_url'];
            $deck->official_event_id = $officialEvent->id;
            $deck->rank = $deckAttrs['rank'];
            $deck->save();

            foreach ($deckAttrs['deckTags'] as $deckTagAttrs) {
                $deckTag = $this->findDeckTagByName($deckTagAttrs['name']);
                if (is_null($deckTag)) {
                    $deckTag = new DeckTag();
                    $deckTag->name = $deckTagAttrs['name'];
                    $deckTag->save();
                }

                $deckTagDeck = new DeckTagDeck();
                $deckTagDeck->deck_id = $deck->id;
                $deckTagDeck->deck_tag_id = $deckTag->id;
                $deckTagDeck->save();
            }
        }

        return $officialEvent;
    }

    public function findOfficialEventByOfficialEventId(int $officialId): ?OfficialEvent
    {
        return OfficialEvent::where('official_id', $officialId)->first();
    }

    public function findDeckTagByName(string $name): ?DeckTag
    {
        return DeckTag::where('name', $name)->first();
    }
}
