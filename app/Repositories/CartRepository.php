<?php

namespace App\Repositories;
use App\Models\Cart;

use Carbon\Carbon;
use Illuminate\Http\Request;

class CartRepository
{

    public function composeSaveClause($cart, $request){
        $cart->item_id = $request->item_id;
        $cart->user_id = $request->user_id;
        $cart->quantity = $request->quantity;
        $cart->save();
        return $cart;
    }

    public function create($request)
    {
        $item = new Cart();
        return $this->composeSaveClause($item, $request);
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


}
