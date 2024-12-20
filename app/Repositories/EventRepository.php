<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Event;
use App\Enums\EventStatus;

class EventRepository
{
    /**
     * @param Event $event
     * @param $request
     */
    public function composeSaveClause(Event $event, $request)
    {
        if (isset($request->status)) {
            $event->status = $request->status;
        }
        if (isset($request->number_of_match)) {
            $event->number_of_match = $request->number_of_match;
        }
        if (isset($request->now_match_number)) {
            $event->now_match_number = $request->now_match_number;
        }
        if (isset($request->max_member)) {
            $event->max_member = $request->max_member;
        }
        if (isset($request->title)) {
            $event->title = $request->title;
        }
        if (isset($request->body)) {
            $event->body = $request->body;
        }
        if (isset($request->date)) {
            $event->date = $request->date;
        }
        if (isset($request->start_time)) {
            $event->start_time = $request->start_time;
        }
        if (isset($request->end_time)) {
            $event->end_time = $request->end_time;
        }
        if (isset($request->image_url)) {
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
        $event->status            = EventStatus::RECRUIT->value;
        if (isset($request->number_of_match)) {
            $event->number_of_match = $request->number_of_match;
        }
        if (isset($request->now_match_number)) {
            $event->now_match_number = $request->now_match_number;
        }
        $event->max_member = $request->max_member;
        if (isset($request->rate_type)) {
            $event->rate_type = $request->rate_type;
        }
        if (isset($request->regulation_type)) {
            $event->regulation_type = $request->regulation_type;
        }
        if (isset($request->card_type)) {
            $event->card_type = $request->card_type;
        }

        $event->title             = $request->title;
        $event->body              = $request->body;
        $event->date              = $request->date;
        $event->start_time        = $request->start_time;
        $event->end_time          = $request->end_time;
        if (isset($request->image_url)) {
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

    public function find($id) {
        return Event::find($id);
    }

    public function findWithUserAndDuel($id) {
        return Event::with('eventUsers.user')
                    ->with('eventDuels.duel.duelUsers.duelUserResults')
                    ->find($id);
    }

    public function composeWhereClause(array $filters): Builder
    {
        $query = Event::query();
        if (isset($filters['event_category_id'])) {
            $query->where('event_category_id', $filters['event_category_id']);
        }
        if (isset($filters['game_id'])) {
            $query->where('game_id', $filters['game_id']);
        }
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (isset($filters['statuses'])) {
            $query->whereIn('status', $filters['statuses']);
        }
        if (isset($filters['eventUsers'])) {
            $query->whereHas('eventUsers', function ($q) use ($filters) {
                if (isset($filters['eventUsers']['user_id'])) {
                    $q->where('user_id', $filters['eventUsers']['user_id']);
                }
            });
        }
        if (isset($filters['start_date'])) {
            $query->where('date', '>=', $filters['start_date']);
        }
        if (isset($filters['end_date'])) {
            $query->where('date', '<=', $filters['end_date']);
        }
        return $query;
    }

    public function findAll(array $filters): Collection
    {
        return $this->composeWhereClause($filters)->get();
    }

    public function findAllByUserId(int $id)
    {
        return Event::wherehas('eventUsers.user', function ($query) use ($id) {
                    $query->where('user_id', $id);
                })->get();
    }

    public function findAllByEventCategoryIdAndPaginate($request, $paginate)
    {
        return Event::where('event_category_id', $request->event_category_id)
                    ->where('game_id', $request->game_id)
                    ->with('eventUsers.User')
                    ->orderBy('id', 'desc')
                    ->paginate($paginate);
    }

    public function findAllForApi($request, $paginate)
    {
        $query = Event::query();
        $query->select('id', 'user_id','status','rate_type','regulation_type','card_type','created_at')
            ->where('game_id', $request->game_id)
            ->where('event_category_id', $request->event_category_id);
        if (isset($request->status)) {
            $query->where('status', $request->status);
        }

        $query->with('eventUsers', function($q) use ($request) {
            $q->with('user:id,name,twitter_image_url,twitter_simple_image_url');
        });
        // ユーザーIDで絞る
        if (isset($request->event_users_user_id)) {
            $query->whereHas('eventUsers', function($q) use ($request) {
                return $q->where('user_id',$request->event_users_user_id);
            })->get();
        }

        $query->with('eventDuels', function($q_eventDuel) {
            $q_eventDuel->with('duel', function($q_duel) {
                $q_duel->with('duelUsers', function($q_duelUser) {
                    $q_duelUser->with('user:id,name,twitter_image_url,twitter_simple_image_url');
                    $q_duelUser->with('duelUserResults');
                });
            });
        });

        $query->orderBy('id', 'desc');

        return $query->paginate($paginate);
    }

    public function findForApi($id)
    {
        return Event::select('id', 'user_id', 'status', 'rate_type', 'regulation_type', 'card_type', 'created_at')
            ->where('id', $id)
            ->with('eventDuels', function ($q_eventDuel) {
                $q_eventDuel->with('duel', function ($q_duel) {
                    $q_duel->with('duelUsers', function ($q_duelUser) {
                        $q_duelUser->with('user:id,name,twitter_image_url,twitter_simple_image_url');
                        $q_duelUser->with('duelUserResults');
                    });
                });
            })
            ->first();
    }

    public function paginate(array $filters, int $row): LengthAwarePaginator
    {
        return $this->composeWhereClause($filters)->paginate($row);
    }
}
