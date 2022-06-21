<?php

namespace App\Repositories;
use App\Models\Item;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ItemRepository
{

    public function composeSaveClause($blog, $request){
        if(isset($request->game_id)){
            $blog->game_id = $request->game_id;
        }
        if(isset($request->user_id)) {
            $blog->user_id = $request->user_id;
        }
        $blog->title   = $request->title;
        $blog->thumbnail_image_url    = $request->thumbnail_image_url;
        $blog->body    = $request->body;
        $blog->is_released = $request->is_released;
        $blog->save();
        return $blog;
    }

    public function create($request)
    {
        $blog = new Blog();
        return $this->composeSaveClause($blog, $request);
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
