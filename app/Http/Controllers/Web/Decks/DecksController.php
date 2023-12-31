<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Decks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Services\Decks\DecksService;
use App\Presenters\Web\Decks\DecksPresenter;
use App\Presenters\Web\Decks\DeckTagsPresenter;

final class DecksController extends Controller
{
    public function __construct(
        private readonly DecksService $decksService,
        private readonly DecksPresenter $decksPresenter,
        private readonly DeckTagsPresenter $deckTagsPresenter,
    ) {
    }

    public function index(Request $request): View
    {
        $page = (int)$request->get('page', 1);
        $filters = [];
        $selectedTagName = null;
        if ($request->has('deck_tag_id')) {
            $filters['deckTag']['id'] = (int)$request->deck_tag_id;
            $selectedTagName = $this->decksService->findDeckTag($filters['deckTag']['id'])->name;
        }
        $decks = $this->decksPresenter->getResponse(
            $this->decksService->paginateDecks($filters, 2, $page)
        );
        $deckTagFilters = [];
        $deckTags = $this->deckTagsPresenter->getResponse(
            $this->decksService->findAllDeckTags($deckTagFilters)
        );

        return view('decks.index', compact('decks', 'deckTags', 'selectedTagName'));
    }
}
