<?php

namespace App\Services;

use Illuminate\Http\Request;

use App\Repositories\UserRepository;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Auth;

class StripeService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * @param $transaction
     * @param $stripeToken
     * @return mixed
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function settlement($transaction, $stripeToken)
    {
        Stripe::setApiKey(config('assets.common.stripe.sk_key'));

        $stripeCustomer = Customer::create([
            'source' => $stripeToken,
            'email' => $transaction->transactionUsers[0]->email,
            'name' => $transaction->transactionUsers[0]->first_name . ' ' . $transaction->transactionUsers[0]->last_name,
            'description' => 'user_id:' . $transaction->transactionUsers[0]->id . ' transaction_id:' . $transaction->id,
        ]);

        Charge::create([
            'customer' => $stripeCustomer->id,
            "amount" => $transaction->price,
            "currency" => "JPY",
            "description" => $transaction->id,
        ]);

        return true;
    }


}
