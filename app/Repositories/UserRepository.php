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

    public function find($id){
        return User::find($id);
    }

}
