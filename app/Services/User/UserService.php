<?php

namespace App\Services\User;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\GameUser;
use App\Models\UserInfoDiscord;
use App\Repositories\UserRepository;
use App\Repositories\GameUserRepository;
use App\Repositories\GameUserCheckRepository;
use App\Repositories\UserInfoDiscordRepository;
use DB;

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

    public function getGameUserByGameIdAndUserId($game_id, $user_id)
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

    public function saveTwitterImage($user)
    {
        try {
            //画像のURL
            $url = $user->twitter_image_url;
            //URLからファイル名を取得 ここはお好きな方法でファイル名を決めてください。
            $file_name = 'twitter_game_3_user_' . $user->id . '.jpg';
            //URLからファイル取得
            $img_downloaded = file_get_contents($url);
            //一時ファイル作成
            $tmp = tmpfile();
            //一時ファイルに画像を書き込み
            fwrite($tmp, $img_downloaded);
            //一時ファイルのパスを取得
            $tmp_path = stream_get_meta_data($tmp)['uri'];
            //storageに保存。
            Storage::putFileAs('/public/images/temp', new File($tmp_path), $file_name);
            //一時ファイル削除
            fclose($tmp);
        } catch (\Exception $e) {
            //URLからファイル名を取得 ここはお好きな方法でファイル名を決めてください。
            $file_name = 'twitter_game_3_user_' . $user->id . '.jpg';
            //URLからファイル取得
            $img_downloaded = file_get_contents(env('APP_URL').'/images/default-icon-mypage.png');
            //一時ファイル作成
            $tmp = tmpfile();
            //一時ファイルに画像を書き込み
            fwrite($tmp, $img_downloaded);
            //一時ファイルのパスを取得
            $tmp_path = stream_get_meta_data($tmp)['uri'];
            //storageに保存。
            Storage::putFileAs('/public/images/temp', new File($tmp_path), $file_name);
            //一時ファイル削除
            fclose($tmp);
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getGameUserRank($request)
    {
        $gameUserRequest = new \stdClass();
        $gameUserRequest->game_id = $request->game_id;

        $gameUsers = $this->gameUserRepository->findAll($gameUserRequest);
        $rank['parameter'] = $gameUsers->count();
        if (isset($gameUsers->where('user_id', $request->user_id)->first()->rate)) {
            $rate = $gameUsers->where('user_id', $request->user_id)->first()->rate;
        } else {
            $rate = 0;
        }
        $rank['ranking'] = $gameUsers->where('rate', '>', $rate)->count() + 1;

        $rankJson = json_encode($rank);

        return $rankJson;
    }
}
