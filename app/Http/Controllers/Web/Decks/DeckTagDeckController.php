<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Decks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Decks\DecksService;

final class DeckTagDeckController extends Controller
{
    public function __construct(
        private readonly DecksService $decksService,
    ) {
    }

    public function store(Request $request)
    {
        $attrs['deck_id'] = (int)$request->deck_id;
        $attrs['deck_tag_id'] = (int)$request->deck_tag_id;
        $this->decksService->createDeckTagDeck($attrs);

        // 更新完了後のリダイレクト（例：デッキの詳細ページへ）
        return redirect('/decks/' . (int)$request->deck_id . '/edit')->with('flash_message', 'デッキのタグを新規作成しました');
    }

    public function update(Request $request, int $deckId, int $deckTagId)
    {
        $attrs['deck_tag_id'] = $request->deck_tag_id;
        $this->decksService->updateDeckTagDeck($deckId, $deckTagId, $attrs);

        // 更新完了後のリダイレクト（例：デッキの詳細ページへ）
        return redirect('/decks/' . $deckId . '/edit')->with('flash_message', 'デッキのタグが更新されました');
    }

    public function destroy(int $deckId, int $deckTagId)
    {
        $this->decksService->deleteDeckTagDeck($deckId, $deckTagId);

        // 更新完了後のリダイレクト（例：デッキの詳細ページへ）
        return redirect('/decks/' . $deckId . '/edit')->with('flash_message', 'デッキのタグを削除しました');
    }
}
