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

    public function createTeam($request)
    {
        $team = $this->team_repository->create($request);
        //追加
        $request->merge(['team_id' => $team->id]);
        $request->merge(['status'  => \App\Models\TeamUser::MASTER]);
        $this->team_user_repository->create($request);
    }

    public function createUser($request)
    {
        $this->team_user_repository->create($request);
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

    /**
     * @param $request
     * @param $paginage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findAllTeamAndUserByTeamId($team_id)
    {
        return $this->team_repository->findWithUser($team_id);
    }

    /**
     * チームページからeditにより編集
     * @param $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function updateTeam($request)
    {
        return $this->team_repository->update($request);
    }

    /**
     * チームページからリクエストユーザーのステータスを更新
     * @param $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function updateUserStatus($request)
    {
        return $this->team_user_repository->updateStatus($request);
    }

}
