<?php

namespace App\Http\Controllers\Item;
use App\Http\Controllers\Controller;
use App\Services\ItemService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

use DB;

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
