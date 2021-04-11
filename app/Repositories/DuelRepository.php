<?php

namespace App\Repositories;
use App\Models\Duel;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DuelRepository
{

    public function create($request)
    {
        $duel = new Duel();
        $duel->fill([
            'post_category_id' => $request->post_category_id,
            'user_id'          => $request->user_id,
            'title'            => $request->title,
            'body'             => $request->body,
            'is_personal'      => $request->is_personal,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);
        $duel->save();

        return $duel;
    }

    public function find($id){
        return Duel::find($id);
    }


}
