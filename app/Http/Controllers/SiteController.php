<?php

namespace App\Http\Controllers;

use Auth;
use DB;

use App\Services\UserService;
use Illuminate\Http\Request;

class SiteController extends Controller
{

    protected $user_service;

    /**
     * UserController constructor.
     * @param UserService $user_service
     */
    public function __construct(UserService $user_service)
    {
        $this->user_service  = $user_service;
    }


    public function administrator()
    {

        return view('site.administrator');
    }

    public function update_selected_game(Request $request)
    {
        //ログインしている場合はuserテーブルのselected_game_idも更新
        if(Auth::check() == true){
            DB::transaction(function () use($request){
                $request->merge(['id'=> Auth::id()]);
                $this->user_service->updateSelectedGameId($request);
            });
        }

        session(['selected_game_id' => $request->input('selected_game_id')]);

        return back()->with('flash_message', '選択しているゲームを変更しました');;
    }

    public function test()
    {
        $data = array(
            "to"  => "ExponentPushToken[KhlJf8PvNsZ5b9wqDQoIPB]",
            "sound" => 'default',
            "title"  => "titleテスト",
            "body" => 'bodyテスト',
        );
        $headers[] = "Content-Type: application/json";

        $curl = curl_init('https://exp.host/--/api/v2/push/send');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $res = curl_exec($curl);

//        $discord =
//            '<@763106044431171594> '. PHP_EOL .
//            '<@ハシム-8498> '. PHP_EOL .
//            '@{{ハシム}} '. PHP_EOL .
//            '<\@ハシム#8498> '. PHP_EOL .
//            '\@ハシム#8498 '. PHP_EOL .
//            '<\@ハシム-8498> '. PHP_EOL .
//            '\@ハシム '. PHP_EOL .
//            '<\@ハシム-#8498> '. PHP_EOL .
//            '\@ハシム-#8498 '. PHP_EOL .
//            'ハシム#8498 '. PHP_EOL .
//            'botのテスト' . PHP_EOL .
//            PHP_EOL ;
//
//        $data = array("content" => $discord, "username" => 'TCGRating');
//        $headers[] = "Content-Type: application/json";
//
//        $curl = curl_init('https://discord.com/api/webhooks/930830014780407819/z4tgtsSgs_mbX1JqN2c1jJvUuoIIChI1JOW4Ui2ud3ObovRnvH7XfQv5VgZ8Kc0I-oZH');
//        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
//        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//
//        $res = curl_exec($curl);
    }
}
