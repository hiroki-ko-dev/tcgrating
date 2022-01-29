<?php

namespace App\Services;
use App\Repositories\EventRepository;
use App\Repositories\EventUserRepository;
use App\Repositories\GameUserRepository;
use Illuminate\Http\Request;

class EventService
{
    protected $gameUserRepository;
    protected $eventRepository;
    protected $eventUserRepository;


    public function __construct(GameUserRepository $gameUserRepository,
                                EventRepository $eventRepository,
                                EventUserRepository $eventUserRepository)
    {
        $this->gameUserRepository = $gameUserRepository;
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
     * @return bool
     */
    public function updateEventStatus($event_id, $status)
    {
        return $this->eventRepository->updateStatus($event_id, $status);
    }

    /**
     * イベントステータスの更新
     * @param $event_id
     * @return bool
     */
    public function updateSwissEventByFinish($event_id)
    {
        // イベントのステータスを完了に更新
        $event = $this->updateEventStatus($event_id, \App\Models\Event::STATUS_FINISH);
        // 大会レートを本レートに反映
        $eventUsers = $event->eventUsers->where('status', \App\Models\EventUser::STATUS_APPROVAL);
        foreach($eventUsers as $eventUser){
            $rate = $eventUser->user->rate + $eventUser->event_rate;
            if($rate < 0){
                $rate = 0;
            }
            $gameUser = $this->gameUserRepository->findByGameIdAndUserId($event->game_id, $eventUser->user_id);
            $gameUser->rate = $rate;
            $gameUser = $this->gameUserRepository->update($gameUser);

            return $gameUser;
        }

        return $event;
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
