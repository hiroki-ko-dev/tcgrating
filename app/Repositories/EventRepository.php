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
            'game_id'           => $request->game_id,
            'event_category_id' => $request->event_category_id,
            'user_id'           => $request->user_id,
            'status'            => \APP\Models\Event::RECRUIT,
            'max_member'        => $request->max_member,
            'title'             => $request->title,
            'body'              => $request->body,
            'date'              => $request->date,
            'start_time'        => $request->start_time,
            'end_time'          => $request->end_time,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now()
        ]);
        $event->save();

        return $event;
    }

    public function updateStatus($id, $status)
    {
        $event = Event::find($id);
        $event->status = $status;
        $event->save();

        return $event;
    }

    public function find($id){
        return Event::find($id);
    }

    public function findWithUserAndDuel($id){
        return Event::with('eventUser.user')
                    ->with('eventDuel.duel.duelUser.duelUserResult')
                    ->find($id);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findAllByUserId($id){
        return Event::wherehas('eventUser.user' , function($query) use($id){
                    $query->where('user_id', $id);
                })->get();
    }


    public function findAllWithUserByEventCategoryIdAndPaginate($event_category_id, $paginate)
    {
        return Event::where('event_category_id', $event_category_id)
                    ->with('eventUser.User')
                    ->OrderBy('id','desc')
                    ->paginate($paginate);
    }

}
