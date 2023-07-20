<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Services\User\UserService;
use App\Services\GoogleService;
use App\Services\TwitterService;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly GoogleService $googleService,
        private readonly TwitterService $twitterService
    ) {
    }

    public function administrator()
    {
        return view('site.administrator');
    }

    public function updateSelectedGame(Request $request)
    {
        //ログインしている場合はuserテーブルのselected_game_idも更新
        if (Auth::check() == true) {
            DB::transaction(function () use ($request) {
                $request->merge(['id'=> Auth::id()]);
                $this->userService->updateSelectedGameId($request);
            });
        }

        session(['selected_game_id' => $request->input('selected_game_id')]);

        return back()->with('flash_message', '選択しているゲームを変更しました');
    }

    public function resume(Request $request)
    {
        //ログインしている場合はuserテーブルのselected_game_idも更新
        if (Auth::check() == true) {
            return redirect('/resume/' . Auth::user()->id);
        }

        session(['loginAfterRedirectUrl' => env('APP_URL') . '/resume']);
        session(['selected_game_id' => $request->input('selected_game_id')]);

        return view('site.landing.resume');
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
