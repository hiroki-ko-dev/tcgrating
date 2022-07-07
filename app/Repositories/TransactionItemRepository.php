<?php

namespace App\Repositories;
use App\Models\TransactionItem;

use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionItemRepository
{

    public function composeSaveClause($transaction, $request){
        if(isset($request->transaction_id)) {
            $transaction->transaction_id = $request->transaction_id;
        }
        if(isset($request->item_id)) {
            $transaction->item_id = $request->item_id;
        }
        if(isset($request->quantity)) {
            $transaction->quantity = $request->quantity;
        }
        if(isset($request->price)){
            $transaction->price = $request->price;
        }
        $transaction->save();
        return $transaction;
    }

    public function create($request)
    {
        $transaction = new TransactionItem();
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
