<?php

namespace App\Services;

use Illuminate\Http\Request;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

class StripeService
{
//    protected $userRepository;
//
//    public function __construct(UserRepository $userRepository)
//    {
//        $this->userRepository = $userRepository;
//    }


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
//            'description' => $transaction->user->id,
            'email' => 'majikarubanana22@yahoo.co.jp'
        ]);

//            $this->userRepository->update();


        Charge::create([
            'customer' => $stripeCustomer->id,
            "amount" => $transaction->price,
            "currency" => "JPY",
//            "source" => $stripeToken,
            "description" => $transaction->id,
        ]);

        return true;
    }


}
