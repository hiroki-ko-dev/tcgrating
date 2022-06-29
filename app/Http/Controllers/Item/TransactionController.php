<?php

namespace App\Http\Controllers\Item;
use App\Http\Controllers\Controller;
use App\Services\ItemService;
use App\Services\StripeService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use DB;

class TransactionController extends Controller
{
    protected $itemService;
    protected $stripeService;

    public function __construct(ItemService $itemService,
                                StripeService $stripeService)
    {
        $this->itemService = $itemService;
        $this->stripeService = $stripeService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function register()
    {
        $request = new Request();
        $request->merge(['user_id' => Auth::id()]);
        $carts = $this->itemService->getCarts($request);
        $totalPrice = $this->itemService->getCartTotalPrice($carts);

        return view('item.transaction.register', compact('carts','totalPrice'));
    }

    /**
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        try {
            $transactionRequest = new Request();
            $transactionRequest->merge(['user_id' => Auth::id()]);
            $transaction = $this->itemService->saveTransactionByCarts($transactionRequest);
            $this->stripeService->settlement($transaction, $request->stripe_token);

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }

        return redirect('/item/transaction/completion');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function completion(Request $request)
    {
        return view('item.transaction.completion');
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
