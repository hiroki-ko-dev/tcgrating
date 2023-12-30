<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Decks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Services\Decks\DecksService;
use App\Presenters\Web\Decks\IndexPresenter;

final class DecksController extends Controller
{
    public function __construct(
        private readonly DecksService $decksService,
        private readonly IndexPresenter $indexPresenter,
    ) {
    }

    public function index(Request $request): View
    {
        $page = $request->get('page', 1);
        $filters = [];
        $tagName = null;
        if ($request->has('deck_tag_id')) {
            $filters['deckTag']['id'] = (int)$request->deck_tag_id;
            $tagName = $this->decksService->findDeckTag($filters['deckTag']['id'])->name;
        }
        $decks = $this->indexPresenter->getResponse(
            $this->decksService->paginateDecks($filters, 20, $page)
        );

        return view('decks.index', compact('decks', 'tagName'));
    }
}
