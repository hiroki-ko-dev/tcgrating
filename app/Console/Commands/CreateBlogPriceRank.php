<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Blogs\BlogsPriceRankService;

final class CreateBlogPriceRank extends Command
{
    protected $signature = 'command:createBlogPriceRank {url}';
    protected $description = 'ポケカの価格相場をBlogに取り込む';

    public function __construct(
        private readonly BlogsPriceRankService $blogsPriceRankService,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->blogsPriceRankService->createBlogsPriceRank($this->argument("url"));
        return 0;
    }
}
