<?php

namespace App\Services;
use App\Repositories\UserRepository;
use App\Repositories\GameUserRepository;

use Illuminate\Http\Request;

class UserService
{
    protected $userRepository;
    protected $gameUserRepository;

    public function __construct(UserRepository $userRepository,
                                GameUserRepository $gameUserRepository)
    {
        $this->userRepository = $userRepository;
        $this->gameUserRepository = $gameUserRepository;
    }

    public function updateUser($request)
    {
        return $this->userRepository->update($request);
    }

    public function updateSelectedGameId($request)
    {
        return $this->userRepository->updateSelectedGameId($request);
    }

    public function findUser($id)
    {
        return $this->userRepository->find($id);
    }

    public function getRatesWithPaginateOrderByRank($request, $pagination)
    {
        return $this->gameUserRepository->findAllByPaginateOrderByRank($request, $pagination);
    }

    /**
     * 全員にメールを一斉送信する際の処理
     * @param $user_id
     * @return mixed
     */
    public function findAllUserBySendMail($user_id)
    {
        return $this->userRepository->findAllBySendMail($user_id);
    }

}
