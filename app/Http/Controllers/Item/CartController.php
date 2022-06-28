<?php

namespace App\Http\Controllers\Item;
use App\Http\Controllers\Controller;

use App\Services\ItemService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use DB;

class CartController extends Controller
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

        $carts = $this->itemService->getCarts($request);

        return view('item.index',compact('items','carts'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        // 選択しているゲームでフィルタ
        if(Auth::check()) {
            $request->merge(['game_id' => Auth::user()->selected_game_id]);
        }else{
            $request->merge(['game_id' => session('selected_game_id')]);
        }


        return view('item.create');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        try {
            $cart = DB::transaction(function () use($request) {
                return $this->itemService->makeCart($request);
            });

            return $cart;

        } catch (\Exception $e) {
            report($e);
            return back()->with('flash_message', $e->getMessage());
        }
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
