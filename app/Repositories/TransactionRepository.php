<?php

namespace App\Repositories;
use App\Models\Transaction;

use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionRepository
{

    public function composeSaveClause($transaction, $request){
        if(isset($request->user_id)) {
            $transaction->user_id = $request->user_id;
        }
        if(isset($request->send_status)) {
            $transaction->send_status = $request->send_status;
        }
        if(isset($request->price)){
            $transaction->price = $request->price;
        }
        if(isset($request->postage)){
            $transaction->postage = $request->postage;
        }
        $transaction->save();
        return $transaction;
    }

    public function create($request)
    {
        $transaction = new Transaction();
        return $this->composeSaveClause($transaction, $request);
    }

    public function update($request)
    {
        $cart = $this->find($request->cart_id);
        return $this->composeSaveClause($cart, $request);
    }


    public function composeWhereClause($request)
    {
        $query = Cart::query();
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
        return Cart::find($id);
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

    /**
     * @param $id
     */
    public function delete($id)
    {
        Cart::destroy($id);
    }


}
