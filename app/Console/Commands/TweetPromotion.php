<?php

namespace App\Console\Commands;

use App\Services\TwitterService;
use Illuminate\Console\Command;

class TweetPromotion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:tweetPromotion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'リモートポケカについて宣伝ツイートをするバッチ機能';

    protected $twitterService;

    /**
     * Create a new command instance.
     *
     * @param TwitterService $twitterService
     */
    public function __construct(TwitterService $twitterService)
    {
        parent::__construct();
        $this->twitterService = $twitterService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->twitterService->tweetPromotion();
        return 0;
    }
}
