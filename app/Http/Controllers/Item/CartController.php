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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $carts = $this->itemService->getCarts($request);

        return view('item.cart.index',compact('carts'));
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
            if(Auth::check()){
                $cart = DB::transaction(function () use($request) {
                    return $this->itemService->makeCart($request);
                });
                $cart_number = Auth::user()->carts->sum('quantity');
            }else{
                $cart = $this->itemService->sessionMakeCart($request);
                $cart_number = session('carts')->sum('quantity');
            }
            $value['type'] = 'success';
            $value['message'] = '✅カートに追加しました';
            $value['number'] = $cart_number;
        } catch (\Exception $e) {
            report($e);
            $value['type'] = 'error';
            $value['message'] = $e->getMessage();
        }
        return $value;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        try {
            $cart = DB::transaction(function () use($request) {
                return $this->itemService->saveCart($request);
            });
            if(Auth::check()){
                $cart_number = Auth::user()->carts->sum('quantity');
            }else{
                $cart_number = session('carts')->sum('quantity');
            }

            return $cart_number;
        } catch (\Exception $e) {
            report($e);
            return back()->with('flash_message', $e->getMessage());
        }
    }

    public function destroy(Request $request) {

        try {
            DB::transaction(function () use($request) {
                $this->itemService->destroyCart($request->cart_id);
            });
            return true;
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
