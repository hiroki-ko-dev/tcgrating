<?php

namespace App\Console\Commands;

use App\Services\GoogleService;
use App\Services\TwitterService;
use Illuminate\Console\Command;

class TweetSpreadSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:tweetSpreadSheet {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'スプレッドシートから読み込んだ内容をツイートをするバッチ機能';

    protected $googleService;
    protected $twitterService;
    //test

    /**
     * TweetSpreadSheet constructor.
     * @param GoogleService $googleService
     * @param TwitterService $twitterService
     */
    public function __construct(GoogleService $googleService,TwitterService $twitterService)
    {
        parent::__construct();
        $this->googleService = $googleService;
        $this->twitterService = $twitterService;
    }

    /**
     * @return int
     * @throws \Google\Exception
     */
    public function handle()
    {
        $type = $this->argument("type");

        //アフェリエイトツイート
        if($type == 'affiliate'){
            $sheetName = config('assets.google.spread_sheet.sheet_name.yugioh');
            $spreadSheet = $this->googleService->getValue($sheetName);
            $apiKeys = config('assets.twitter.yugioh');
            $this->twitterService->tweetSpreadAffiliate($spreadSheet, $apiKeys);

            $sheetName = config('assets.google.spread_sheet.sheet_name.book');
            $spreadSheet = $this->googleService->getValue($sheetName);
            $apiKeys = config('assets.twitter.best_sale_book');
            $this->twitterService->tweetSpreadAffiliate($spreadSheet, $apiKeys);

            $sheetName = config('assets.google.spread_sheet.sheet_name.gravure');
            $spreadSheet = $this->googleService->getValue($sheetName);
            $apiKeys = config('assets.twitter.gravure');
            $this->twitterService->tweetSpreadAffiliate($spreadSheet, $apiKeys);

        //通常ツイート
        }elseif ($type == 'normal'){
            $sheetName = config('assets.google.spread_sheet.sheet_name.yugioh') . '_通常';
            $spreadSheet = $this->googleService->getValue($sheetName);
            $apiKeys = config('assets.twitter.yugioh');
            $this->twitterService->tweetSpreadNormal($spreadSheet, $apiKeys);

            $sheetName = config('assets.google.spread_sheet.sheet_name.book') . '_通常';
            $spreadSheet = $this->googleService->getValue($sheetName);
            $apiKeys = config('assets.twitter.best_sale_book');
            $this->twitterService->tweetSpreadNormal($spreadSheet, $apiKeys);

            $sheetName = config('assets.google.spread_sheet.sheet_name.gravure') . '_通常';
            $spreadSheet = $this->googleService->getValue($sheetName);
            $apiKeys = config('assets.twitter.gravure');
            $this->twitterService->tweetSpreadNormal($spreadSheet, $apiKeys);
        }

        return 0;
    }
}
