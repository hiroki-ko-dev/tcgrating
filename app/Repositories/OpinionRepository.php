<?php

namespace App\Repositories;
use App\Models\Opinion;

use Carbon\Carbon;
use Illuminate\Http\Request;

class OpinionRepository
{

    public function composeSaveClause($opinion, $request){
        if(isset($request->game_id)){
            $opinion->game_id = $request->game_id;
        }
        if(isset($request->user_id)) {
            $opinion->user_id = $request->user_id;
        }
        if(isset($request->type)){
            $opinion->type = $request->type;
        }
        if(isset($request->body)){
            $opinion->body = $request->body;
        }
        if(isset($request->line_name)) {
            $opinion->line_name = $request->line_name;
        }
        if(isset($request->twitter_name)) {
            $opinion->twitter_name = $request->twitter_name;
        }
        if(isset($request->discord_name)) {
            $opinion->discord_name = $request->discord_name;
        }
        $opinion->save();
        return $opinion;
    }

    public function create($request)
    {
        $opinion = new Opinion();
        return $this->composeSaveClause($opinion, $request);
    }

    public function find($id)
    {
        return Opinion::find($id);
    }



}
