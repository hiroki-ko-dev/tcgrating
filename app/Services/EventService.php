<?php

namespace App\Services;
use App\Repositories\EventRepository;
use Illuminate\Http\Request;

class EventService
{
    protected $event_repository;

    public function __construct(EventRepository $event_repository)
    {
        $this->event_repository = $event_repository;
    }

    public function findAllEventAndUserByEventCategoryId($event_category_id,$paginate)
    {
        return $this->event_repository->findAllWithUserByEventCategoryIdAndPaginate($event_category_id,$paginate);

    }


}
