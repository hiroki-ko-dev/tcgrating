<?php

namespace App\Repositories;
use App\Models\Event;

use Carbon\Carbon;
use Illuminate\Http\Request;

class EventRepository
{

    public function create($request)
    {
        $event = new Event();
        $event->fill([
            'event_category_id' => $request->event_category_id,
            'user_id'           => $request->user_id,
            'status'            => \APP\Models\Event::RECRUIT,
            'max_member'        => $request->max_member,
            'title'             => $request->title,
            'body'              => $request->body,
            'date'              => $request->date,
            'time'              => $request->time,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now()
        ]);
        $event->save();

        return $event;
    }

    public function find($id){
        return Event::find($id);
    }

    public function findWithUserAndDuel($id){
        return Event::with('eventUser.user')
                    ->with('eventDuel.duel')
                    ->find($id);
    }

    public function findAllWithUserByEventCategoryIdAndPaginate($event_category_id, $paginate)
    {
        return Event::where('event_category_id', $event_category_id)
                    ->with('eventUser.User')
                    ->OrderBy('id','desc')
                    ->paginate($paginate);
    }

}
