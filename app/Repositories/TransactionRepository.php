<?php

namespace App\Repositories;
use App\Models\Transaction;

use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionRepository
{

    public function composeSaveClause($transaction, $request){
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
        $query = Transaction::query();
        if(isset($request->item_id)){
            $query->where('game_id', $request->item_id);
        }
        if(isset($request->amount)){
            $query->where('quantity', $request->quantity);
        }
        // ユーザーIDで絞る
        if(isset($request->user_id)){
            $query->whereHas('transactionUsers', function($q) use($request){
                return $q->where('user_id',$request->user_id);
            });
        }

        return $query;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return Transaction::find($id);
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
     * @param $request
     * @param $paginate
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findAllByPaginate($request, $paginate)
    {
        $query = $this->composeWhereClause($request);
        $query->orderBy('id', 'desc');

        return $query->paginate($paginate);
    }




}
