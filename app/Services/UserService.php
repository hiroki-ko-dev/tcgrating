<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Models\GameUserCheck;
use App\Repositories\UserRepository;
use App\Repositories\GameUserRepository;
use App\Repositories\GameUserCheckRepository;
use App\Repositories\UserDiscordRepository;
use App\Dto\Auth\DiscordAuthResponseDto;
use Hash;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly GameUserRepository $gameUserRepository,
        private readonly GameUserCheckRepository $gameUserCheckRepository,
        private readonly UserDiscordRepository $userDiscordRepository,
    ) {
    }

    public function createUser(array $data)
    {
        $user = $this->userRepository->create($data);
        $data['user_id'] = $user->id;
        $this->gameUserRepository->create($data);
        return $user;
    }

    public function createGameUser(array $data)
    {
        $gameUser = $this->gameUserRepository->findByGameIdAndUserId($data['game_id'], $data['user_id']);
        if (is_null($gameUser)) {
            $gameUser = $this->gameUserRepository->create($data);
        }

        return $gameUser;
    }

    public function makeGameUserCheck($request)
    {
        $gameUserCheck = $this->gameUserCheckRepository->findAll($request);
        if ($gameUserCheck->count() == 0) {
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

    // public function discordLogin(DiscordAuthResponseDto $discordAuthInfoDto)
    // {
    //     $userData['selected_game_id'] = config('assets.site.game_ids.pokemon_card');
    //     $userData['name'] = $discordAuthInfoDto->name;
    //     $userData['email'] = $discordAuthInfoDto->email;
    //     $user = $this->userDiscordRepository->find($discordAuthInfoDto->id);
    //     if (is_null($user)) {
    //         $userData['password'] = Hash::make($discordAuthInfoDto->id . 'hash_pass');
    //         $user = $this->createUser($userData);
    //         $user = $this->discordUserRepository->create($userData);
    //     } else {
    //         if ($user->userDiscord) {
    //             $this->updateUser($userData);
    //         }
    //                 // TwitterIDが存在しない場合の処理
    //                 if(is_null($user)){
    //                     // Twitter情報からユーザーアカウントを作成
    //                     $request             = new Request();
    //                     $request->twitter_id = $twitterUser->id;
    //                     $request->twitter_nickname  = $twitterUser->nickname;
    //                     $request->twitter_image_url = $twitterUser->avatar_original;
    //                     $request->twitter_simple_image_url = $twitterUser->user['profile_image_url_https'];
    
    //                     // すでにログイン中なら、ログインアカウントにTwitter情報を追加
    //                     if(Auth::check()){
    //                         // ログインユーザーにTwitter情報をアップデート
    //                         $user = DB::transaction(function () use($request) {
    //                             $request->user_id = Auth::id();
    //                             return $this->userService->updateUser($request);
    //                         });
    //                         Auth::login($user, true);
        
    //                     // ログインしていないなら、新規アカウントを作成
    //                     }else{
    //                         $game_id = config('assets.site.game_ids.pokemon_card');
    //                         if(session('selected_game_id')){
    //                             $game_id = session('selected_game_id');
    //                         }
    //                         $request->game_id    = $game_id;
    //                         $request->name       = $twitterUser->name;
    //                         $request->email      = $twitterUser->email;
    //                         $request->password   = Hash::make($twitterUser->id.'hash_pass');
    //                         $request->body       = $twitterUser->user['description'];
        
    //                         // 新規ユーザー作成
    //                         $user = DB::transaction(function () use($request) {
    //                             return $this->userService->makeUser($request);
    //                         });
    //                         Auth::login($user, true);
    //                     }
        
    //                 }else{
    //                     $user->twitter_nickname  = $twitterUser->nickname;
    //                     $user->twitter_image_url = $twitterUser->avatar_original;
    //                     $user->twitter_simple_image_url = $twitterUser->user['profile_image_url_https'];
    //                     $user->save();
        
    //                     Auth::login($user, true);
    //                 }
        
    //             } catch (\Exception $e) {
        
    //                 if(session('api')){
    //                     session()->forget('api');
    //                     $loginId = 0;
    //                     return view('auth.api_logined',compact('loginId'));
    //                 }
    //                 return redirect('/login')->with('flash_message', 'エラーが発生しました');
    //             }
    //         }
    // }
}
