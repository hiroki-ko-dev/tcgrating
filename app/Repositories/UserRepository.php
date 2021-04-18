<?php

namespace App\Repositories;
use App\Models\User;

use Carbon\Carbon;
use Illuminate\Http\Request;

class UserRepository
{

    public function update($request)
    {
        User::where('id',$request->id)
            ->update([
                'email' => $request->email,
                'name'  => $request->name,
                'body'  => $request->body
            ]);
    }

    /**
     * ユーザーrateが変動があった時の操作
     * @param $id
     * @param $rate
     * @return mixed
     */
    public function updateRate($id, $rate)
    {
        $user = User::find($id);
        $user->rate = $user->rate + $rate ;
        $user->save() ;

        return $user ;
    }

    public function find($id){
        return User::find($id);
    }

    public function findAllByPaginateOrderByRank($pagination){
        return User::OrderBy('rate','desc')->paginate($pagination);
    }

}
