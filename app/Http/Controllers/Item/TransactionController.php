<?php

namespace App\Http\Controllers\Item;
use App\Http\Controllers\Controller;
use App\Services\ItemService;
use App\Services\StripeService;

use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use DB;

class TransactionController extends Controller
{
    protected $userService;
    protected $itemService;
    protected $stripeService;

    public function __construct(UserService $userService,
                                ItemService $itemService,
                                StripeService $stripeService)
    {
        $this->userService = $userService;
        $this->itemService = $itemService;
        $this->stripeService = $stripeService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $request->merge(['user_id' => Auth::id()]);
        $transactions = $this->itemService->getTransactionsByPaginate($request, 20);

        return view('item.transaction.index', compact('transactions'));
    }

    /**
     * @param $transaction_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($transaction_id)
    {
        $transaction = $this->itemService->getTransaction($transaction_id);

        return view('item.transaction.show', compact('transaction'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function customer()
    {
        session()->forget('loginAfterRedirectUrl');

        if(Auth::check()){
            $user = Auth::user();
        }else{
            session(['loginAfterRedirectUrl' => env('APP_URL').'/item/transaction/customer']);
            $user = new \App\Models\User();
        }

        return view('item.transaction.customer', compact('user'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function register(Request $request)
    {
        $request->merge(['id' => Auth::id()]);
        $user = DB::transaction(function () use ($request) {
            return $this->userService->updateUser($request);
        });

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
            $transaction = DB::transaction(function () use ($request) {
                $transactionRequest = new Request();
                $transactionRequest->merge(['user_id' => Auth::id()]);
                $transaction = $this->itemService->saveTransactionByCarts($transactionRequest);
                $this->stripeService->settlement($transaction, $request->stripe_token);
                return $transaction;
           });

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
