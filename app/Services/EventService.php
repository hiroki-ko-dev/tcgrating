<?php

namespace App\Services;
use App\Repositories\EventRepository;
use App\Repositories\EventUserRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class EventService
{
    protected $eventRepository;
    protected $eventUserRepository;


    public function __construct(EventRepository $eventRepository,
                                EventUserRepository $eventUserRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->eventUserRepository  = $eventUserRepository;
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
     * イベントステータスの更新
     * @param $event_id
     * @param $status
     * @return bool
     */
    public function updateEventStatus($event_id, $status)
    {
        return $this->eventRepository->updateStatus($event_id, $status);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function updateEventUserByUserIdAndGameId($request)
    {
        $eventUser = $this->eventUserRepository->update($request);
        return $eventUser;
    }

    public function getEvent($event_id){
        return $this->eventRepository->find($event_id);
    }

    public function findEventWithUserAndDuel($event_id){
        return $this->eventRepository->findWithUserAndDuel($event_id);
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


}
