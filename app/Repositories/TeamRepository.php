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
                'name'    => $request->name,
                'game_id' => $request->game_id,
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
                        'name'             => $request->name,
                        'body'             => $request->body,
                        'recruit_status'   => $request->recruit_status,
                    ]);
    }

    /**
     * マイチームを出す時のメソッド
     * @param $request
     * @param $paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findAllByRequestAndPaginate($request,$paginate){

        $query = Team::query();
        $query->where('game_id', $request->game_id);

        $query->wherehas('teamUser' , function($q) use($request){
            if($request->has('user_id')){
                $q->where('user_id', $request->query('user_id'));
            }
        });

        return $query->OrderBy('id','desc')->paginate($paginate);;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findWithUser($id){
        return Team::with('teamUser.user')->find($id);
    }

}
