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
    public function createEventByOneVsOneAndRequest($request)
    {
        $event = $this->event_repository->create($request);
        $request->merge(['event_id' => $event->id]);
        $this->event_user_repository->create($request);
        return $request;
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


}
