<?php

namespace App\Repositories;
use App\Models\TransactionUser;

use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionUserRepository
{

    public function composeSaveClause($transactionUser, $request){
        if(isset($request->transaction_id)) {
            $transactionUser->transaction_id = $request->transaction_id;
        }
        if(isset($request->user_id)) {
            $transactionUser->user_id = $request->user_id;
        }
        if(isset($request->email)) {
            $transactionUser->email = $request->email;
        }
        if(isset($request->first_name)) {
            $transactionUser->first_name = $request->first_name;
        }
        if(isset($request->last_name)) {
            $transactionUser->last_name = $request->last_name;
        }
        if(isset($request->email)) {
            $transactionUser->email = $request->email;
        }
        if(isset($request->tel)) {
            $transactionUser->tel = $request->tel;
        }
        if(isset($request->prefecture_id)) {
            $transactionUser->prefecture_id = $request->prefecture_id;
        }
        if(isset($request->post_code)) {
            $transactionUser->post_code = $request->post_code;
        }
        if(isset($request->address1)) {
            $transactionUser->address1 = $request->address1;
        }
        if(isset($request->address2)) {
            $transactionUser->address2 = $request->address2;
        }
        if(isset($request->address3)) {
            $transactionUser->address3 = $request->address3;
        }

        $transactionUser->save();
        return $transactionUser;
    }

    public function create($request)
    {
        $transactionUser = new TransactionUser();
        return $this->composeSaveClause($transactionUser, $request);
    }

    public function update($request)
    {
        $cart = $this->find($request->cart_id);
        return $this->composeSaveClause($cart, $request);
    }


    public function composeWhereClause($request)
    {
        $query = TransactionUser::query();
        if(isset($request->item_id)){
            $query->where('game_id', $request->item_id);
        }
        if(isset($request->user_id)){
            $query->where('user_id', $request->user_id);
        }
        if(isset($request->amount)){
            $query->where('quantity', $request->quantity);
        }

        return $query;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return TransactionUser::find($id);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function findAll($request)
    {
        $query = $this->composeWhereClause($request);
        return $query->get();
    }

}
