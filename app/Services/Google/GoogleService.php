<?php

namespace App\Services\Google;

use Google_Client;
use Google_Service_Sheets;

class GoogleService
{
    public static function getValue($sheetName): array
    {
        // google spread sheetと接続するためのkey
        $credentials_path = storage_path('app/json/credentials.json');
        // 接続の際のクライアントのインスタンスを作成
        $client = new Google_Client();
        // keyをセット
        $client->setAuthConfig($credentials_path);
        // spread sheetに接続することを宣言
        $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);

        // スプレッドシートのIDをセット
        $sheet_id = config('assets.google.spread_sheet.best_sale_bot.sheet_id');
        // スプレッドシート名とレンジをセット
        $range = $sheetName . '!B3:H100';
        $sheet = new Google_Service_Sheets($client);
        // スプレッドシートの値を取得
        $response = $sheet->spreadsheets_values->get($sheet_id, $range);

        return $response->getValues();

    }



}
