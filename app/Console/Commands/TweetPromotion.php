<?php

namespace App\Console\Commands;

use App\Services\TwitterService;
use Illuminate\Console\Command;

class TweetPromotion extends Command
{
    protected $signature = 'command:tweetPromotion';
    protected $description = 'リモートポケカについて宣伝ツイートをするバッチ機能';

    public function __construct(
        private readonly TwitterService $twitterService
    ) {
        parent::__construct();
    }

    public function handle()
    {
        $this->twitterService->tweetPromotion();
        return 0;
    }
}
