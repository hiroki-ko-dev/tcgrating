<?php

namespace App\Services;
use App\Models\GameUserCheck;
use App\Repositories\UserRepository;
use App\Repositories\GameUserRepository;
use App\Repositories\GameUserCheckRepository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class UserService
{
    protected $userRepository;
    protected $gameUserRepository;
    protected $gameUserCheckRepository;

    public function __construct(UserRepository $userRepository,
                                GameUserRepository $gameUserRepository,
                                GameUserCheckRepository $gameUserCheckRepository)
    {
        $this->userRepository = $userRepository;
        $this->gameUserRepository = $gameUserRepository;
        $this->gameUserCheckRepository = $gameUserCheckRepository;
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

    /**
     * イベント作成時にgameUserChecksがなかったら作成する
     * @param $request
     * @return mixed
     */
    public function makeGameUserCheck($request)
    {
        $gameUserCheck = $this->gameUserCheckRepository->findAll($request);
        if($gameUserCheck->count() == 0){
            $gameUserCheck = $this->gameUserCheckRepository->create($request);
        }
        return $gameUserCheck;
    }

    public function dropGameUserCheck($request)
    {
        $this->gameUserCheckRepository->delete($request);

        return true;
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

    public function getGameUser($id)
    {
        return $this->gameUserRepository->find($id);
    }

    public function getUserByTwitterId($id)
    {
        return $this->userRepository->findByTwitterId($id);
    }

    public function getUserByAppleCode($appleCode)
    {
        return $this->userRepository->findByAppleCode($appleCode);
    }

    public function getRatesWithPaginateOrderByRank($request, $pagination)
    {
        return $this->gameUserRepository->findAllByPaginateOrderByRank($request, $pagination);
    }

    public function getGameUserByGameIdAndUserId($game_id, $user_id)
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

    public function getGameUserForApi($request)
    {
        return $this->gameUserRepository->findByUserIdAndGameIdForApi($request);
    }

    /**
     * @param $request
     * @return false|string
     */
    public function getGameUserJson($request)
    {
        $gameUser = $this->getGameUserForApi($request);
        $gameUserJson = json_encode($gameUser);

        return $gameUserJson;
    }

    public function saveTwitterImage($user)
    {
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
        $rate = $gameUsers->where('user_id',$request->user_id)->first()->rate;
        $rank['ranking'] = $gameUsers->where('rate','>',$rate)->count() + 1;

        $rankJson = json_encode($rank);

        return $rankJson;
    }

}
