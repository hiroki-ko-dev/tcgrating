<?php

namespace App\Http\Controllers\Item;
use App\Http\Controllers\Controller;
use App\Services\ItemService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use DB;

class StockController extends Controller
{
    protected $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }



    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        // 選択しているゲームでフィルタ
        if(!Auth::check() || Auth::user()->role <> \App\Models\User::ROLE_ADMIN) {
            return back()->with('flash_message', '新規投稿を行うにはログインしてください');
        }

        try {
            $itemStock = DB::transaction(function () use ($request) {
                return $this->itemService->makeItemStock($request);
            });

            return redirect('/item/' . $itemStock->item->id)->with('flash_message', '在庫を追加しました');

        } catch (\Exception $e) {
            report($e);
            return back()->with('flash_message', $e->getMessage());
        }
    }

}
