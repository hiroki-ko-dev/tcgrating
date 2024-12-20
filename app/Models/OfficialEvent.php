<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class OfficialEvent extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function decks(): HasMany
    {
        return $this->hasMany(Deck::class, 'official_event_id', 'id');
    }
}
