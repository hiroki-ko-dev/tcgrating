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
                'user_id'  => $request->user_id
            ]);
    }

}
