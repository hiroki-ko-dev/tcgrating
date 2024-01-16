<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Decks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Services\Decks\DecksService;
use App\Presenters\Web\Decks\DeckPresenter;
use App\Presenters\Web\Decks\DecksPaginatePresenter;
use App\Presenters\Web\Decks\DeckTagsPresenter;

final class DecksController extends Controller
{
    public function __construct(
        private readonly DecksService $decksService,
        private readonly DecksPaginatePresenter $decksPaginatePresenter,
        private readonly DeckPresenter $deckPresenter,
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
        $decks = $this->decksPaginatePresenter->getResponse(
            $this->decksService->paginateDecks($filters, 20, $page)
        );
        $deckTagFilters = [];
        $deckTags = $this->deckTagsPresenter->getResponse(
            $this->decksService->findAllDeckTags($deckTagFilters)
        );

        return view('decks.index', compact('decks', 'deckTags', 'selectedTagName'));
    }

    public function edit(int $deckId): View
    {
        $deck = $this->deckPresenter->getResponse(
            $this->decksService->findDeck($deckId)
        );
        $deckTags = $this->deckTagsPresenter->getResponse(
            $this->decksService->findAllDeckTags([])
        );

        return view('decks.edit', compact('deck', 'deckTags'));
    }
}
