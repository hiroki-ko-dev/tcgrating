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
    protected $signature = 'command:tweetSpreadSheet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'スプレッドシートから読み込んだ内容をツイートをするバッチ機能';

    protected $googleService;
    protected $twitterService;


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
        $sheetName = config('assets.google.spread_sheet.sheet_name.yugioh');
        $spreadSheet = $this->googleService->getValue($sheetName);
        $apiKeys = config('assets.twitter.yugioh');
        $this->twitterService->tweetSpreadSheet($spreadSheet, $apiKeys);

        $sheetName = config('assets.google.spread_sheet.sheet_name.book');
        $spreadSheet = $this->googleService->getValue($sheetName);
        $apiKeys = config('assets.twitter.best_sale_book');
        $this->twitterService->tweetSpreadSheet($spreadSheet, $apiKeys);

//        $sheetName = config('assets.google.spread_sheet.sheet_name.pokeka');
//        $spreadSheet = $this->googleService->getValue($sheetName);
//        $apiKeys = config('assets.twitter.pokeka_sales');
//        $this->twitterService->tweetSpreadSheet($spreadSheet, $apiKeys);

        return 0;
    }
}
