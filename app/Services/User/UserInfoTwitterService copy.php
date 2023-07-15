<?php

namespace App\Services\User;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

final class UserInfoTwitterService extends UserService
{
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
            $img_downloaded = file_get_contents(env('APP_URL') . '/images/default-icon-mypage.png');
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
}
