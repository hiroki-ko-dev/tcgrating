<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class DeckTag extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function decks(): BelongsToMany
    {
        return $this->belongsToMany(Deck::class, 'deck_tag_deck', 'deck_tag_id', 'deck_id');
    }
}
