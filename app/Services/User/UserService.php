<?php

namespace App\Services\User;

use App\Models\User;
use App\Models\GameUser;
use App\Models\UserInfoDiscord;
use App\Repositories\UserRepository;
use App\Repositories\GameUserRepository;
use App\Repositories\GameUserCheckRepository;
use App\Repositories\UserInfoDiscordRepository;
use DB;
use Auth;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly GameUserRepository $gameUserRepository,
        private readonly GameUserCheckRepository $gameUserCheckRepository,
        private readonly UserInfoDiscordRepository $userDiscordRepository,
    ) {
    }

    public function createUser(array $attrs): User
    {
        return DB::transaction(function () use ($attrs) {
            $user = $this->userRepository->create($attrs);
            $attrs['user_id'] = $user->id;
            $this->gameUserRepository->create($attrs);
            return $user;
        });
    }

    public function createGameUser(array $attrs): GameUser
    {
        return DB::transaction(function () use ($attrs) {
            $gameUser = $this->gameUserRepository->findByGameIdAndUserId($attrs['game_id'], $attrs['user_id']);
            if (is_null($gameUser)) {
                $gameUser = $this->gameUserRepository->create($attrs);
            }
            return $gameUser;
        });
    }

    public function createUserInfoDiscord(array $attrs): UserInfoDiscord
    {
        return DB::transaction(function () use ($attrs) {
            return $this->userInfoDiscordRepository->create($attrs);
        });
    }

    public function makeGameUserCheck($request)
    {
        $gameUserCheck = $this->gameUserCheckRepository->findAll($request);
        if ($gameUserCheck->count() == 0) {
            $gameUserCheck = $this->gameUserCheckRepository->create($request);
        }
        return $gameUserCheck;
    }

    public function findUser($id)
    {
        return $this->userRepository->find($id);
    }

    public function findByUser(string $column, int | string $value)
    {
        return $this->userRepository->findBy($column, $value);
    }

    public function getUserByTwitterId($id)
    {
        return $this->userRepository->findByTwitterId($id);
    }

    public function getUserByAppleCode($appleCode)
    {
        return $this->userRepository->findByAppleCode($appleCode);
    }

    public function getGameUser($id)
    {
        return $this->gameUserRepository->find($id);
    }

    public function getGameUserByGameIdAndUserId(int $game_id, int $user_id): ?GameUser
    {
        return $this->gameUserRepository->findByGameIdAndUserId($game_id, $user_id);
    }

    public function getRatesWithPaginateOrderByRank($request, $pagination)
    {
        return $this->gameUserRepository->findAllByPaginateOrderByRank($request, $pagination);
    }

    public function getGameUsersByRankForApi($request, $paginate)
    {
        return $this->gameUserRepository->findAllByRankForApi($request, $paginate);
    }

    public function getGameUserForApi($request)
    {
        return $this->gameUserRepository->findByUserIdAndGameIdForApi($request);
    }

    public function fetchGameUserRank(GameUser $gameUser)
    {
        return $this->gameUserRepository->fetchRank($gameUser);
    }

    public function getGameUserJson($request)
    {
        $gameUser = $this->getGameUserForApi($request);
        $gameUserJson = json_encode($gameUser);

        return $gameUserJson;
    }

    public function findUserDiscord(int $id): ?UserInfoDiscord
    {
        return $this->userInfoDiscordRepository->find($id);
    }

    /**
     * 全員にメールを一斉送信する際の処理
     * @param $request
     * @return mixed
     */
    public function findAllUserBySendMail($request)
    {
        return $this->userRepository->findAllBySendMail($request);
    }

    public function fetchSelectedGameId()
    {
        if (Auth::check()) {
            $selectedGameId = Auth::user()->selected_game_id;
        } else {
            $selectedGameId = session('selected_game_id');
        }
        return $selectedGameId;
    }

    public function updateGameUser($id, array $attrs): GameUser
    {
        return DB::transaction(function () use ($id, $attrs) {
            return $this->gameUserRepository->update($id, $attrs);
        });
    }

    public function updateUser(int $id, array $attrs): User
    {
        return DB::transaction(function () use ($id, $attrs) {
            return $this->userRepository->update($id, $attrs);
        });
    }

    public function updateSelectedGameId($request)
    {
        return $this->userRepository->updateSelectedGameId($request);
    }

    public function updateUserInfoDiscord(int $id, array $attrs): UserInfoDiscord
    {
        return DB::transaction(function () use ($id, $attrs) {
            return $this->userInfoDiscordRepository->update($id, $attrs);
        });
    }

    public function dropGameUserCheck($request)
    {
        $this->gameUserCheckRepository->delete($request);

        return true;
    }
}
