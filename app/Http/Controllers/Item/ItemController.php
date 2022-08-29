<?php

namespace App\Http\Controllers\Item;
use App\Http\Controllers\Controller;
use App\Services\ItemService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use DB;
use Ramsey\Uuid\Type\Integer;

class ItemController extends Controller
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
    public function index(Request $request)
    {
        // 選択しているゲームでフィルタ
        if(Auth::check()) {
            $request->merge(['game_id' => Auth::user()->selected_game_id]);
        }else{
            $request->merge(['game_id' => session('selected_game_id')]);
        }

        $items =  $this->itemService->getItemsByPaginate($request,20);

        return view('item.index',compact('items'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        return view('item.create');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        // 選択しているゲームでフィルタ
        if(!Auth::check() || Auth::id() <> 1) {
            return back()->with('flash_message', '新規投稿を行うにはログインしてください');
        }

        try {
            // 選択しているゲームでフィルタ
            if(Auth::check()) {
                $request->merge(['game_id' => Auth::user()->selected_game_id]);
            }else{
                $request->merge(['game_id' => session('selected_game_id')]);
            }
            $item = DB::transaction(function () use ($request) {
                return $this->itemService->makeItem($request);
            });

            return redirect('/item/' . $item->id)->with('flash_message', '商品を保存しました');

        } catch (\Exception $e) {
            report($e);
            return back()->with('flash_message', $e->getMessage());
        }
    }

    /**
     * @param $item_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($item_id)
    {
        $item = $this->itemService->getItem($item_id);

        return view('item.show', compact('item'));
    }

    /**
     * @param int $item_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($item_id)
    {
        $item = $this->itemService->getItem($item_id);

        return view('item.edit', compact('item'));
    }

    /**
     * @param Request $request
     * @param $item_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $item_id)
    {
        $item = $this->itemService->saveItem($request);

        return redirect('/item/' . $item->id)->with('flash_message', '商品を更新しました');
    }

    /*単発決済用のコード*/
    public function charge(Request $request)
    {
        try {
            Stripe::setApiKey(config('assets.common.stripe.sk_key'));
            Charge::create([
                "amount" => 10000,
                "currency" => "JPY",
                "source" => $request->stripeToken,
                "description" => "テスト中",
            ]);

            return back()->with('flash_message', 'クレジットカード決済を行いました');;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

}
