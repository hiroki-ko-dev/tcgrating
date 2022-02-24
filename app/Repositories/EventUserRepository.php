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
        $eventUser->event_id = $request->event_id;
        $eventUser->user_id  = $request->user_id;
        $eventUser->status   = $request->status;
        if(isset($request->group_id)){
            $eventUser->group_id = $request->group_id;
        }
        $eventUser->role = $request->role;
        $eventUser->save();

        return $eventUser;
    }

    public function update($request)
    {
        $eventUser = EventUser::where('event_id',$request->event_id)
                                ->where('user_id',$request->user_id)
                                ->first();

        if(isset($request->status)){
            $eventUser->status = $request->status;
        }
        if(isset($request->stream_url)){
            $eventUser->stream_url = $request->stream_url;
        }

        $eventUser->save();

        return $eventUser;
    }

    public function find($id){
        return EventUser::find($id);
    }

    public function findAll($request){
        $query =  EventUser::query();
        $query->where('event_id',$request->event_id);
        $query->whereNotIn('user_id',$request->not_user_ids);
        $query->where('status',$request->status);
        return $query->get();
    }

    /**
     * @param $user_id
     * @param $event_id
     * @return mixed
     */
    public function findEventUserByUserIdAndEventId($user_id,$event_id){
        return EventUser::where('user_id',$user_id)->where('event_id',$event_id)->first();
    }

    public function findAllWithUserByEventCategoryIdAndPaginate($event_category_id, $paginate)
    {
        return Event::where('event_category_id', $event_category_id)
                    ->with('eventUsers.User')
                    ->paginate($paginate);
    }

}
