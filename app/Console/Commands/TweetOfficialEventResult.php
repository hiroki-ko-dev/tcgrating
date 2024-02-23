<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OfficialEvent\OfficialEventService;
use App\Services\Twitter\TwitterOfficialEventService;

final class TweetOfficialEventResult extends Command
{
    protected $signature = 'command:tweetOfficialEventResult';
    protected $description = '公式ポケカ大会の結果とデッキをツイートするバッチ機能';

    public function __construct(
        private readonly OfficialEventService $officialEventService,
        private readonly TwitterOfficialEventService $twitterOfficialEventService,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->twitterOfficialEventService->tweetResult(
            $this->officialEventService->saveResult()
        );
        return 0;
    }
}
