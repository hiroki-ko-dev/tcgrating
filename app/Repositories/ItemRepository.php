<?php

namespace App\Repositories;
use App\Models\Item;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ItemRepository
{

    public function composeSaveClause($item, $request){
        if(isset($request->game_id)){
            $item->game_id = $request->game_id;
        }
        if(isset($request->name)) {
            $item->name = $request->name;
        }
        if(isset($request->body)) {
            $item->body    = $request->body;
        }
        if(isset($request->image_url)) {
            $item->image_url = $request->image_url;
        }
        if(isset($request->price)) {
            $item->price = $request->price;
        }
        if(isset($request->is_released)) {
            $item->is_released = $request->is_released;
        }
        $item->save();
        return $item;
    }

    public function create($request)
    {
        $item = new Item();
        return $this->composeSaveClause($item, $request);
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

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return Item::find($id);
    }

    public function composeWhereClause($request)
    {
        $query = Item::query();
        $query->where('game_id', $request->game_id);
        if(isset($request->search)){
            $query->where('name', 'like', "%$request->search%");
        }
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
