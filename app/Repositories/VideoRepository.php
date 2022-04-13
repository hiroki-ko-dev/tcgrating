<?php

namespace App\Repositories;
use App\Models\Video;

use Carbon\Carbon;
use Illuminate\Http\Request;

class VideoRepository
{

    public function composeWhereClause($request)
    {
        $query = Video::query();
        $query->where('game_id', $request->game_id);
        return $query;
    }

    public function findAllByPaginate($request, $paginate)
    {
        $query = $this->composeWhereClause($request);
        return $query->OrderBy('id','desc')
                    ->paginate($paginate);
    }

}
