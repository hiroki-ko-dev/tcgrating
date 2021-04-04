<?php

namespace App\Services;
use App\Repositories\TeamRepository;
use App\Repositories\TeamUserRepository;

use Illuminate\Http\Request;

class TeamService
{
    protected $team_repository;
    protected $team_user_repository;

    public function __construct(TeamRepository $team_repository,TeamUserRepository $team_user_repository)
    {
        $this->team_repository      = $team_repository;
        $this->team_user_repository = $team_user_repository;
    }

    /**
     * @param $request
     * @param $paginage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findAllTeamByRequestAndPaginate($request, $paginage)
    {
        return $this->team_repository->findAllByRequestAndPaginate($request, $paginage);
    }

    public function createTeamByRequest($request)
    {
        $team = $this->team_repository->create($request);
        //追加
        $request->merge(['team_id' => $team->id]);
        $this->team_user_repository->create($request);
    }
}
