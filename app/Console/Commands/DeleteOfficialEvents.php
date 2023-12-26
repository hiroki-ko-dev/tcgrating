<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OfficialEvent\OfficialEventService;

final class DeleteOfficialEvents extends Command
{
    protected $signature = 'command:deleteOfficialEvents {ids*}';
    protected $description = '公式ポケカ大会の結果とデッキを削除機能';

    public function __construct(
        private readonly OfficialEventService $officialEventService,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {    
        $this->officialEventService->deleteOfficialEvent($this->argument("ids"));
        return 0;
    }
}
