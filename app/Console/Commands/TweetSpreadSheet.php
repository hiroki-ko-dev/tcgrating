<?php

namespace App\Console\Commands;

use App\Services\Google\GoogleService;
use App\Services\Twitter\TwitterService;
use Illuminate\Console\Command;
use Exception;

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

    /**
     * TweetSpreadSheet constructor.
     * @param GoogleService $googleService
     * @param TwitterService $twitterService
     */
    public function __construct(GoogleService $googleService, TwitterService $twitterService)
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
        $sheetName = null;
        $spreadSheet = null;
        try {
            $type = $this->argument("type");

            //アフェリエイトツイート
            if ($type == 'affiliate') {
                // $sheetName = config('assets.google.spread_sheet.sheet_name.yugioh');
                // $spreadSheet = $this->googleService->getValue($sheetName);
                // $apiKeys = config('assets.twitter.yugioh');
                // $this->twitterService->tweetSpreadAffiliate($spreadSheet, $apiKeys);

                $sheetName = config('assets.google.spread_sheet.sheet_name.book');
                $spreadSheet = $this->googleService->getValue($sheetName);
                $apiKeys = config('assets.twitter.best_sale_book');
                $this->twitterService->tweetSpreadAffiliate($spreadSheet, $apiKeys);

                $sheetName = config('assets.google.spread_sheet.sheet_name.gravure');
                $spreadSheet = $this->googleService->getValue($sheetName);
                $apiKeys = config('assets.twitter.gravure');
                $this->twitterService->tweetSpreadAffiliate($spreadSheet, $apiKeys);

            //通常ツイート
            } elseif ($type == 'normal') {
                // $sheetName = config('assets.google.spread_sheet.sheet_name.yugioh') . '_通常';
                // $spreadSheet = $this->googleService->getValue($sheetName);
                // $apiKeys = config('assets.twitter.yugioh');
                // $this->twitterService->tweetSpreadNormal($spreadSheet, $apiKeys);

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
        } catch (Exception $e) {
            if ($e->getCode() !== 403) {
                report($e);
            }
            \Log::error([
                "Twitter自動ツイートバグ：Command:TweetSpreadSheet.php@handle",
                [$sheetName, $spreadSheet],
                $e->getMessage(),
            ]);
            abort($e->getCode());
        }
    }
}
