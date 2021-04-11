<?php

namespace App\Repositories;
use App\Models\Event;

use Carbon\Carbon;
use Illuminate\Http\Request;

class EventRepository
{

    public function create($request)
    {
        Event::insert([
            [
                'post_category_id' => $request->post_category_id,
                'user_id'          => $request->user_id,
                'title'            => $request->title,
                'body'             => $request->body,
                'is_personal'      => $request->is_personal,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now()
            ],
        ]);
    }

    public function find($id){
        return Event::find($id);
    }

    public function findAllWithUserByEventCategoryIdAndPaginate($event_category_id, $paginate)
    {
        return Event::where('event_category_id', $event_category_id)
                    ->with('eventUser.User')
                    ->paginate($paginate);
    }

}
