<?php

namespace App\Repositories;
use App\Models\Event;

use Carbon\Carbon;
use Illuminate\Http\Request;

class EventRepository
{
    /**
     * @param Event $event
     * @param $request
     */
    public function composeSaveClause(Event $event, $request)
    {
        if(isset($request->status)) {
            $event->status = $request->status;
        }
        if(isset($request->number_of_match)){
            $event->number_of_match = $request->number_of_match;
        }
        if(isset($request->now_match_number)){
            $event->now_match_number = $request->now_match_number;
        }
        if(isset($request->max_member)) {
            $event->max_member = $request->max_member;
        }
        if(isset($request->title)) {
            $event->title = $request->title;
        }
        if(isset($request->body)) {
            $event->body = $request->body;
        }
        if(isset($request->date)) {
            $event->date = $request->date;
        }
        if(isset($request->start_time)) {
            $event->start_time = $request->start_time;
        }
        if(isset($request->end_time)) {
            $event->end_time = $request->end_time;
        }
        if(isset($request->image_url)){
            $event->image_url = $request->image_url;
        }
        return $event;
    }

    public function create($request)
    {
        $event = new Event();
        $event->game_id           = $request->game_id;
        $event->event_category_id = $request->event_category_id;
        $event->user_id           = $request->user_id;
        $event->status            = \APP\Models\Event::STATUS_RECRUIT;
        if(isset($request->number_of_match)){
            $event->number_of_match = $request->number_of_match;
        }
        if(isset($request->now_match_number)){
            $event->now_match_number = $request->now_match_number;
        }
        $event->max_member        = $request->max_member;
        $event->title             = $request->title;
        $event->body              = $request->body;
        $event->date              = $request->date;
        $event->start_time        = $request->start_time;
        $event->end_time          = $request->end_time;
        if(isset($request->image_url)){
            $event->image_url = $request->image_url;
        }
        $event->save();

        return $event;
    }

    public function update($request)
    {
        $event = Event::find($request->event_id);
        $event = $this->composeSaveClause($event, $request);
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
        return Event::with('eventUsers.user')
                    ->with('eventDuels.duel.duelUsers.duelUserResults')
                    ->find($id);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findAllByUserId($id){
        return Event::wherehas('eventUsers.user' , function($query) use($id){
                    $query->where('user_id', $id);
                })->get();
    }


    public function findAllByEventCategoryIdAndPaginate($request, $paginate)
    {
        return Event::where('event_category_id', $request->event_category_id)
                    ->where('game_id', $request->game_id)
                    ->with('eventUsers.User')
                    ->OrderBy('id','desc')
                    ->paginate($paginate);
    }

    public function findAllByIndexForApi($request, $paginate)
    {
        return Event::select('id', 'user_id','status','is_rated','created_at')
                    ->where('game_id', $request->game_id)
                    ->whereIn('status', $request->status)
                    ->where('event_category_id', $request->event_category_id)
                    ->with('eventUsers', function($query) {
                        $query->with('user:id,name,twitter_simple_image_url');
                    })
                    ->paginate($paginate);
    }

    public function findForApi($id)
    {
        return Event::select('id', 'user_id','status','is_rated','created_at')
            ->where('id', $id)
            ->with('eventUsers', function($query) {
                $query->with('user:id,name,twitter_simple_image_url');
            })
            ->first();
    }
}
