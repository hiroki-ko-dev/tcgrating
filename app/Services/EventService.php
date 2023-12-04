<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Enums\EventStatus;
use App\Enums\EventUserStatus;
use App\Enums\EventUsersAttendance;
use App\Repositories\EventRepository;
use App\Repositories\EventUserRepository;
use App\Repositories\GameUserRepository;

class EventService
{
    public function __construct(
        private readonly GameUserRepository $gameUserRepository,
        private readonly EventRepository $eventRepository,
        private readonly EventUserRepository $eventUserRepository
    ) {
    }

    /**
     * 1対1決闘でのイベントを作成
     * @param $request
     * @return mixed
     */
    public function createEvent($request)
    {
        $event = $this->eventRepository->create($request);
        $request->merge(['event_id' => $event->id]);
        $this->eventUserRepository->create($request);
        return $event;
    }

    /**
     * イベントユーザーの追加
     * @param $request
     * @return mixed
     */
    public function createUser($request)
    {
        $this->eventUserRepository->create($request);
        return $request;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function updateEvent($request)
    {
        return $this->eventRepository->update($request);
    }

    /**
     * イベントステータスの更新
     * @param $event_id
     * @param $status
     * @return mixed
     */
    public function updateEventStatus($event_id, $status)
    {
        return $this->eventRepository->updateStatus($event_id, $status);
    }

    /**
     * イベントステータスの更新
     * @param $event_id
     * @return mixed
     */
    public function updateSwissEventByFinish($event_id)
    {
        // イベントのステータスを完了に更新
        $event = $this->updateEventStatus($event_id, EventStatus::FINISH->value);
        // 大会レートを本レートに反映
        $eventUsers = $event->eventUsers->where('status', EventUserStatus::APPROVAL->value);
        foreach ($eventUsers as $eventUser) {
            $rate = $eventUser->user->rate + $eventUser->event_rate;
            if ($rate < 0) {
                $rate = 0;
            }
            $gameUser = $this->gameUserRepository->findByGameIdAndUserId($event->game_id, $eventUser->user_id);
            $gameUser->rate = $rate;
            $gameUser = $this->gameUserRepository->update($gameUser->id,);

            return $gameUser;
        }

        return $event;
    }

    /**
     * @param $request
     * @return \App\Models\Event
     */
    public function updateEventUser($request)
    {
        return $this->eventUserRepository->update($request);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function updateEventUserByUserIdAndGameId($request)
    {
        $eventUser = $this->eventUserRepository->updateByEventIdAndUserId($request);
        return $eventUser;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function updateSwissEventUsersAttendance($request)
    {
        $beforeEventUsers = $this->findEvent($request->event_id)->eventUsers;
        $afterEventUsers = [];

        foreach ($beforeEventUsers as $eventUser) {
            $eventUserRequest = new \stdClass();
            $eventUserRequest->id = $eventUser->id;
            $eventUserRequest->attendance = $request->attendance;

            if ($eventUser->status == EventUserStatus::APPROVAL->value) {
                if ($request->attendance == EventUserAttendance::READY->value) {
                    // 出欠取り始めの処理
                    if ($eventUser->attendance == EventUserAttendance::PREPARING->value) {
                        // 出欠準備のユーザーだけ更新
                        $afterEventUsers[] = $this->updateEventUser($eventUserRequest);
                    }
                } elseif ($request->attendance == EventUserAttendance::ABSENT->value) {
                    // 出欠終了の処理
                    if ($eventUser->attendance == EventUserAttendance::READY->value) {
                        // 出欠準備のユーザーだけ更新
                        $afterEventUsers[] = $this->updateEventUser($eventUserRequest);
                    }
                }
            }
        }
        return $afterEventUsers;
    }

    public function findEvent($event_id)
    {
        return $this->eventRepository->find($event_id);
    }

    public function findAllEvents(array $filters): Collection
    {
        return $this->eventRepository->findAll($filters);
    }

    public function findEventWithUserAndDuel($event_id) {
        return $this->eventRepository->findWithUserAndDuel($event_id);
    }

    public function getEventsJsonsForFullCalendar($request)
    {
        $events = $this->findAllEvents($request);

        $json_events = '[';
        foreach ($events as $i => $event) {
            if ($i > 0) {
                $json_events = $json_events . ',';
            }

            // jsonの本体部分を追加
            $json_events = $json_events .
              '{' .
              '"url":"/supplier/bookings/' . $event->id . '/edit",' .
              '"id":"' . $event->id . '",' .
              '"title":"' . '大会ID：' . $event->id . '",' .
              '"date":"' . $event->date . '"' .
//              '"day":"' . date('d', strtotime($event->date)) . '"' .
//              '"start":"'.$event->starts_at->format('Y-m-d').'T'.$event->starts_at->format('H:i:s').'",' .
//              '"end":"'.$event->ends_at->format('Y-m-d').'T'.$event->ends_at->format('H:i:s').'"'.
              '}';
        }
        $json_events = $json_events . ']';

        return $json_events;
    }

    /**
     * イベントカテゴリIDによって一覧を取得
     * @param $request
     * @param $paginate
     * @return mixed
     */
    public function findAllEventByEventCategoryId($request, $paginate)
    {
        return $this->eventRepository->findAllByEventCategoryIdAndPaginate($request, $paginate);
    }

    public function findAllEventByUserId($user_id)
    {
        return $this->eventRepository->findAllByUserId($user_id);
    }

    public function paginateEvents($filters, $row)
    {
        return $this->eventRepository->paginate($filters, $row);
    }

    public function getEventsByIndexForApi($request, $paginate)
    {
        return $this->eventRepository->findAllForApi($request, $paginate);
    }

    public function getEventForApi($id)
    {
        return $this->eventRepository->findForApi($id);
    }
}
