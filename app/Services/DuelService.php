<?php

namespace App\Services;
use App\Repositories\DuelRepository;
use App\Repositories\DuelUserRepository;
use App\Repositories\DuelResultRepository;
use App\Repositories\EventDuelRepository;
use Illuminate\Http\Request;

class DuelService
{
    protected $duel_repository;
    protected $duel_user_repository;
    protected $duel_result_repository;
    protected $event_duel_repository;

    public function __construct(DuelRepository $duel_repository,
                                DuelUserRepository $duel_user_repository,
                                DuelResultRepository $duel_result_repository,
                                EventDuelRepository $event_duel_repository)
    {
        $this->duel_repository       = $duel_repository;
        $this->duel_user_repository  = $duel_user_repository;
        $this->duel_result_repository  = $duel_result_repository;
        $this->event_duel_repository = $event_duel_repository;
    }

    /**
     * シングル決闘の際のduel系作成
     * @param $request
     * @return mixed
     */
    public function createSingleByRequest($request)
    {
        $duel = $this->duel_repository->create($request);
        $request->merge(['duel_id' => $duel->id]);
        $this->duel_user_repository->create($request);
        $this->event_duel_repository->create($request);
        return $request;
    }

    public function createUser($request)
    {
        $this->duel_user_repository->create($request);
        return $request;
    }

    /**
     * シングル決闘の際のduel系作成
     * @param $event_id
     * @return mixed
     */
    public function findDuelWithUser($event_id)
    {
        return $this->duel_repository->findDuelWithUser($event_id);
    }

}
