<?php

namespace App\Repositories;
use App\Models\Team;

use Carbon\Carbon;
use Illuminate\Http\Request;

class TeamRepository
{

    public function create($request)
    {
        return Team::create([
                'name'  => $request->name,
                'body'  => $request->body
            ]);
    }

    /**
     * @param $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function update($request){
        return Team::where('id',$request->id)
                    ->update([
                        'name'  => $request->name,
                        'body'  => $request->body
                    ]);
    }

    /**
     * @param $request
     * @param $paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findAllByRequestAndPaginate($request,$paginate){

        $query = Team::query();

        $query->wherehas('teamUser' , function($q) use($request){
            if($request->has('user_id')){
                $q->where('user_id', $request->query('user_id'));
            }
        });

        return $query->paginate($paginate);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findWithUser($id){
        return Team::with('teamUser')->find($id);
    }

}
