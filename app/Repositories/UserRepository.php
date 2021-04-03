<?php

namespace App\Repositories;
use App\Models\User;

use Carbon\Carbon;
use Illuminate\Http\Request;

class UserRepository
{

    public function update($request)
    {
        Post::insert([
            [
                'post_category_id' => $request->post_category_id,
                'user_id'          => $request->user_id,
                'title'            => $request->title,
                'body'             => $request->body,
                'is_personal'      => $request->is_personal,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now()
            ],
        ]);
    }

    public function find($id){
        return User::find($id);
    }

    public function findAllDuelWithUserByDuelCategoryIdAndPagination($duel_category_id, $paginate)
    {
        return User::where('duel_category_id', $duel_category_id)
                    ->with('DuelUser.User')
                    ->paginate($paginate);
    }

}
