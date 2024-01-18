<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Blogs\BlogsNewPackService;

final class CreateBlogNewPack extends Command
{
    // url例：　https://pokecabook.com/archives/80826
    protected $signature = 'command:createBlogNewPack {url}';
    protected $description = 'ポケカの発売前最新PackをBlogに取り込む';

    public function __construct(
        private readonly BlogsNewPackService $blogsNewPackService,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->blogsNewPackService->createBlogsNewPack($this->argument("url"));
        return 0;
    }
}
