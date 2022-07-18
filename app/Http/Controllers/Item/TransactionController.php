<?php

namespace App\Http\Controllers\Item;
use App\Http\Controllers\Controller;
use App\Mail\TransactionPurchaseMail;
use App\Services\ItemService;
use App\Services\StripeService;

use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use DB;
use Mail;
use Validator;

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
     * @throws \Exception
     */
    public function register(Request $request)
    {

        // regex：フィールドが指定された正規表現にマッチすることをバリデートする
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name'  => 'required',
            'email' => 'required|regex:/.+@+./',
            'tel' => 'required|regex:/.+#\d{4}$/|max:255',
            'post_code' => 'required|regex:/.+#\d{4}$/|max:255',
            'prefecture' => 'required',
            'address1' => 'required',
            'address2' => 'required',
        ]);

        // discordNameがおかしかったらエラーで返す
        if ($validator->fails()){
            $gameUser = $this->userService->getGameUserForApi($request);
            return $this->apiService->resConversionJson($gameUser);
        }

        if(Auth::check()){
            $request->merge(['id' => Auth::id()]);
            $user = DB::transaction(function () use ($request) {
                return $this->userService->updateUser($request);
            });
        }else{
            $user = new \App\Models\User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->tel = $request->tel;
            $user->post_code = $request->post_code;
            $user->prefecture_id = $request->prefecture_id;
            $user->address1 = $request->address1;
            $user->address2 = $request->address2;
            $user->address3 = $request->address3;
        }
        $carts = $this->itemService->getCarts($request);
        $totalPrice = $this->itemService->getCartTotalPrice($carts);

        return view('item.transaction.register', compact('carts','user', 'totalPrice'));
    }

    /**
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        try {
            $transaction = DB::transaction(function () use ($request) {
                $transaction = $this->itemService->saveTransactionByCarts($request);
                $this->stripeService->settlement($transaction, $request->stripe_token);
                Mail::send(new TransactionPurchaseMail($transaction));
                $request->session()->forget('carts');
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
