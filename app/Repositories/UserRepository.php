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
        $user->rate_yugioh_links = $user->rate_yugioh_links + $rate ;
        $user->save() ;

        return $user ;
    }

    public function updateSelectedGameId($request)
    {
        $user = User::find($request->id);
        $user->selected_game_id = $request->selected_game_id;
        $user->save();

        return $user;
    }

    public function find($id){
        return User::find($id);
    }

    public function composeWhereClause($request)
    {
        $query = User::query();
        return $query;
    }

    public function findAllBySendMail($id){
        return User::whereNotIn('id',[$id])->where('email', 'not like', '%test@test.jp%')->get();
    }

}
