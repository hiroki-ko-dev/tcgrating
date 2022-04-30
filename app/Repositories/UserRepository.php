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
        if(isset($request->twitter_id)){
            $user->twitter_id = $request->twitter_id;
        }
        if(isset($request->apple_code)){
            $user->apple_code = $request->apple_code;
        }
        $user->selected_game_id = $request->game_id;
        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->password         = $request->password;
        if(isset($request->body)){
            $user->body         = $request->body;
        }
        if(isset($request->twitter_nickname)){
            $user->twitter_nickname = $request->twitter_nickname;
        }
        if(isset($request->twitter_image_url)){
            $user->twitter_image_url = $request->twitter_image_url;
        }
        if(isset($request->twitter_simple_image_url)){
            $user->twitter_simple_image_url = $request->twitter_simple_image_url;
        }
        $user->save();

        return $user;
    }

    public function update($request)
    {
        $user = User::find($request->id);
        if(isset($request->email)) {
            $user->email = $request->email;
        }
        if(isset($request->name)) {
            $user->name = $request->name;
        }
        if(isset($request->body)) {
            $user->body = $request->body;
        }
        if(isset($request->twitter_id)){
            $user->twitter_id = $request->twitter_id;
        }
        if(isset($request->twitter_nickname)){
            $user->twitter_nickname = $request->twitter_nickname;
        }
        if(isset($request->twitter_image_url)){
            $user->twitter_image_url = $request->twitter_image_url;
        }
        if(isset($request->apple_code)){
            $user->apple_code = $request->apple_code;
        }
        if(isset($request->twitter_simple_image_url)){
            $user->twitter_simple_image_url = $request->twitter_simple_image_url;
        }
        $user->save();

        return $user;
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

    public function findAll($request){
        $query = User::query();
        if(isset($request->not_null_twitter_id)){
            $query->whereNotNull('twitter_id');
        }
        return $query->get();
    }

    public function findByTwitterId($id){
        return User::where('twitter_id',$id)->first();
    }

    public function findByAppleCode($code){
        return User::where('apple_code',$code)->first();
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
                    ->where('email', 'not like', '%test@test.jp%')
                    ->whereNotNull('email')
                    ->get();

    }

}
