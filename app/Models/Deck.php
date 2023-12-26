<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\hasMany;

final class Deck extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function officialEvent(): BelongsTo
    {
        return $this->belongsTo(OfficialEvent::class, 'official_event_id', 'id');
    }

    public function deckTags(): BelongsToMany
    {
        return $this->belongsToMany(DeckTag::class, 'deck_tag_deck', 'deck_id', 'deck_tag_id');
    }

    public function deckTagDecks(): hasMany
    {
        return $this->hasMany(DeckTagDeck::class, 'id', 'deck_id');
    }
    
}
