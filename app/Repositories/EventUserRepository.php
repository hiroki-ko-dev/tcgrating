<?php

namespace App\Repositories;
use App\Models\EventUser;

use Carbon\Carbon;
use Illuminate\Http\Request;

class EventUserRepository
{

    /**
     * @param $request
     * @return EventUser
     */
    public function create($request)
    {
        $eventUser = new EventUser();
        $eventUser->fill([
            'event_id'          => $request->event_id,
            'user_id'           => $request->user_id,
            'status'            => EventUser::MASTER,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now()
        ]);
        $eventUser->save();

        return $eventUser;
    }

    public function find($id){
        return EventUser::find($id);
    }

    public function findAllWithUserByEventCategoryIdAndPaginate($event_category_id, $paginate)
    {
        return Event::where('event_category_id', $event_category_id)
                    ->with('eventUser.User')
                    ->paginate($paginate);
    }

}
