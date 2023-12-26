<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\TweetPromotion::class,
        Commands\TweetSpreadSheet::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // 本紹介 & 遊戯王アフェリエイトの宣伝ツイート
        $schedule->command('command:tweetSpreadSheet affiliate')->dailyAt('08:00');
        $schedule->command('command:tweetSpreadSheet affiliate')->dailyAt('12:00');
        $schedule->command('command:tweetSpreadSheet affiliate')->dailyAt('18:00');
        $schedule->command('command:tweetSpreadSheet affiliate')->dailyAt('20:00');
        $schedule->command('command:tweetSpreadSheet affiliate')->dailyAt('23:00');

        // イベントステータスを自動で正常にする
        $schedule->command('command:eventFinishCommand')->dailyAt('04:00');

        // 通常ツイート
        $schedule->command('command:tweetSpreadSheet normal')->dailyAt('19:00');

        // リモートポケカアカウントの宣伝ツイート
        $schedule->command('command:tweetPromotion')->dailyAt('23:00');

        // ポケカ公式大会の結果ツイート
        $schedule->command('command:tweetOfficialEventResult')->dailyAt('22:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
