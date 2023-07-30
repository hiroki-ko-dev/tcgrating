<?php

namespace App\Services\User;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

    public function getGameUserByGameIdAndUserId(int $gameId, int $userId): ?GameUser
    {
        return $this->gameUserRepository->findByGameIdAndUserId($gameId, $userId);
    }

    public function getRatesWithPaginateOrderByRank(array $filters, $row): LengthAwarePaginator
    {
        return $this->gameUserRepository->findAllByPaginateOrderByRank($filters, $row);
    }

    public function paginateGameUser(array $filters, int $row): LengthAwarePaginator
    {
        return $this->gameUserRepository->paginate($filters, $row);
    }

    public function getGameUserForApi($request)
    {
        return $this->gameUserRepository->findByUserIdAndGameIdForApi($request);
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

    public function fetchSelectedGameId(): int
    {
        if (Auth::check()) {
            $selectedGameId = (int)Auth::user()->selected_game_id;
        } else {
            if (session('selected_game_id')) {
                $selectedGameId = (int)session('selected_game_id');
            } else {
                $selectedGameId = config('assets.site.game_ids.pokemon_card');
            }

        }
        return $selectedGameId;
    }

    public function updateGameUser(int $id, array $attrs): GameUser
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
