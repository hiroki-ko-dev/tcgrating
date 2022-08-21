<?php

namespace App\Repositories;
use App\Models\ItemStock;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ItemStockRepository
{

    public function composeSaveClause($itemStock, $request){
        if(isset($request->item_id)){
            $itemStock->item_id = $request->item_id;
        }
        if(isset($request->quantity)) {
            $itemStock->quantity = $request->quantity;
        }
        if(isset($request->cost)) {
            $itemStock->cost = $request->cost;
        }
        $itemStock->save();
        return $itemStock;
    }

    public function create($request)
    {
        $itemStock = new ItemStock();
        return $this->composeSaveClause($itemStock, $request);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function update($request)
    {
        $blog = $this->find($request->id);

        return $this->composeSaveClause($blog, $request);
    }

    public function composeWhereClause($request)
    {
        $query = Item::query();
        $query->where('game_id', $request->game_id);
        return $query;
    }

    /**
     * @param $request
     * @param $paginate
     * @return mixed
     */
    public function findAllByPaginate($request, $paginate)
    {
        $query = $this->composeWhereClause($request);
        return $query->OrderBy('id','desc')
                    ->paginate($paginate);
    }

}
