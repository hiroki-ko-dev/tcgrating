<?php

namespace App\Http\Controllers\Web\Item;

use App\Http\Controllers\Controller;
use App\Mail\TransactionPurchaseMail;
use App\Services\ItemService;
use App\Services\StripeService;
use App\Services\User\UserService;
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
     * @param $transaction_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $transaction_id)
    {
        $request->merge(['transaction_id' => $transaction_id]);
        $transaction = $this->itemService->saveTransaction($request);

        return back()->with('flash_message', '更新しました');
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
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
   * @throws \Exception
   */
    public function register(Request $request)
    {
        // regex：フィールドが指定された正規表現にマッチすることをバリデートする
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name'  => 'required',
            'post_code' => 'required|regex:/^[0-9]{7}$/',
            'prefecture_id' => 'required',
            'address1' => 'required',
            'address2' => 'required',
            'tel' => 'required|numeric|digits_between:10,20',
            'email' => 'required|email:rfc,dns',
            'email_confirmation' => 'required|email:rfc,dns|same:email',
          ],
          [
            'first_name.required' => '苗字を入力してください',
            'last_name.required' => '名前で入力してください',
            'post_code.required' => '郵便番号を入力してください',
            'post_code.regex' => '郵便番号は数字7桁ハイフン無しで入力してください',
            'prefecture_id.required' => '整数で入力してください',
            'address1.required' => '整数で入力してください',
            'address2.required' => '整数で入力してください',
            'tel.required' => '整数で入力してください',
            'tel.numeric' => '整数で入力してください',
            'tel.digits_between' => '郵便番号は数字ハイフン無しで入力してください',
            'email.required' => 'emailの入力は必須です',
            'email.email' => '@マークを入れた文字列で入力してください',
            'email_confirmation.required' => 'emailの入力は必須です',
            'email_confirmation.email' => '@マークを入れた文字列で入力してください',
            'email_confirmation.same' => 'メールアドレスと違う文字列が入力されています',
          ]
        );

        // discordNameがおかしかったらエラーで返す
        if ($validator->fails()) {
          return redirect('/item/transaction/customer')
            ->withErrors($validator)
            ->withInput();
        }

        if (Auth::check()) {
            $user = DB::transaction(function () use ($request) {
                return $this->userService->updateUser(Auth::id(), $request->all());
            });
        } else {
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
