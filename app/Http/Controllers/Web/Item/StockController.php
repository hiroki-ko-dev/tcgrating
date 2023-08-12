<?php

namespace App\Http\Controllers\Web\Item;

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
     * @param $item_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create($item_id)
    {
        $item = $this->itemService->getItem($item_id);
        return view('item.stock.create',compact('item'));
    }

    /**
     * @param Request $request
     * @param $item_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, $item_id)
    {
        // 選択しているゲームでフィルタ
        if(!Auth::check() || Auth::user()->role <> \App\Models\User::ROLE_ADMIN) {
            return back()->with('flash_message', '新規投稿を行うにはログインしてください');
        }

        try {
            $itemStock = DB::transaction(function () use ($request, $item_id) {
                $request->merge(['item_id' => $item_id]);
                $itemStock = $this->itemService->makeItemStock($request);
                $item = $this->itemService->saveItemQuantity($request);

                return $itemStock;
            });

            return redirect('/item/' . $item_id)->with('flash_message', '在庫を追加しました');

        } catch (\Exception $e) {
            report($e);
            return back()->with('flash_message', $e->getMessage());
        }
    }

}
