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
    protected $description = '本について宣伝ツイートをするバッチ機能';

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
        $spreadSheet = $this->googleService->getValue();
        $this->twitterService->tweetSpreadSheet($spreadSheet);
        return 0;
    }
}
