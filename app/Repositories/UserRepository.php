<?php

namespace App\Repositories;
use App\Models\User;

use Carbon\Carbon;
use Illuminate\Http\Request;

class UserRepository
{

    public function create($request)
    {
        $user                   = new User();
        $user->selected_game_id = $request->game_id;
        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->password         = $request->password;
        $user->save();

        return $user;
    }

    public function update($request)
    {
        User::where('id',$request->id)
            ->update([
                'email' => $request->email,
                'name'  => $request->name,
                'body'  => $request->body
            ]);
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

    public function findAllBySendMail($request){
        $query = $this->composeWhereClause($request);

        return $query->whereNotIn('id',[$request->user_id])
                    ->whereHas('gameUsers',  function($query) use($request){
                        $query->where('game_id', $request->game_id);
                        $query->where('is_mail_send', true);
                    })
                    ->where('email', 'not like', '%test@test.jp%')->get();

    }

}
