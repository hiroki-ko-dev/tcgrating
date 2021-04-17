<?php

namespace App\Repositories;
use App\Models\TeamUser;

use Carbon\Carbon;
use Illuminate\Http\Request;

class TeamUserRepository
{

    public function create($request)
    {
        return TeamUser::create([
                'team_id'  => $request->team_id,
                'user_id'  => $request->user_id,
                'status'   => $request->status
            ]);
    }

    public function updateStatus($request)
    {
        return TeamUser::where('user_id', $request->user_id)
                        ->where('team_id', $request->team_id)
                        ->update([
                            'status'  => $request->status,
                            'user_id'  => $request->user_id
                        ]);
    }

}
