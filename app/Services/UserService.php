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

    /**
     * 新規ユーザーの作成処理
     * @param $request
     * @return mixed
     */
    public function makeUser($request)
    {
        $user = $this->userRepository->create($request);
        $request->merge(['user_id' => $user->id]);
        $gameUser = $this->gameUserRepository->create($request);

        return $user;
    }

    /**
     * イベント作成時にgameUserがなかったら作成する
     * @param $request
     * @return mixed
     */
    public function makeGameUser($request)
    {
        $gameUser = $this->gameUserRepository->findByGameIdAndUserId($request->game_id, $request->user_id);
        if(is_null($gameUser)){
            $gameUser = $this->gameUserRepository->create($request);
        }

        return $gameUser;
    }

    public function updateGameUser($request)
    {
        return $this->gameUserRepository->update($request);
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

    public function getUserByTwitterId($id)
    {
        return $this->userRepository->findByTwitterId($id);
    }

    public function getRatesWithPaginateOrderByRank($request, $pagination)
    {
        return $this->gameUserRepository->findAllByPaginateOrderByRank($request, $pagination);
    }

    public function getGameUserByUserIdAndGameId($user_id, $game_id)
    {
        return $this->gameUserRepository->findByGameIdAndUserId($game_id, $user_id);
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


    public function getGameUsersByRankForApi($request, $paginate)
    {
        return $this->gameUserRepository->findAllByRankForApi($request, $paginate);
    }

}
