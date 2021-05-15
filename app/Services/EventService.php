<?php

namespace App\Services;
use App\Repositories\EventRepository;
use App\Repositories\EventUserRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class EventService
{
    protected $event_repository;
    protected $event_user_repository;


    public function __construct(EventRepository $event_repository,
                                EventUserRepository $event_user_repository)
    {
        $this->event_repository = $event_repository;
        $this->event_user_repository  = $event_user_repository;
    }

    /**
     * 1対1決闘でのイベントを作成
     * @param $request
     * @return mixed
     */
    public function createEventBySingle($request)
    {
        $event = $this->event_repository->create($request);
        $request->merge(['event_id' => $event->id]);
        $this->event_user_repository->create($request);
        return $event;
    }

    /**
     * イベントユーザーの追加
     * @param $request
     * @return mixed
     */
    public function createUser($request)
    {
        $this->event_user_repository->create($request);
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
        return $this->event_repository->updateStatus($event_id, $status);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function updateEventUser($request)
    {
        $eventUser = $this->event_user_repository->update($request);
        return $eventUser;
    }

    public function findEventWithUserAndDuel($event_id){
        return $this->event_repository->findWithUserAndDuel($event_id);
    }

    /**
     * イベントカテゴリIDによって一覧を取得
     * @param $event_category_id
     * @param $paginate
     * @return mixed
     */
    public function findAllEventAndUserByEventCategoryId($event_category_id,$paginate)
    {
        return $this->event_repository->findAllWithUserByEventCategoryIdAndPaginate($event_category_id,$paginate);
    }

    public function findAllEventByUserId($user_id)
    {
        return $this->event_repository->findAllByUserId($user_id);
    }


}
