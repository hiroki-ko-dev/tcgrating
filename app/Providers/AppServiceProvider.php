<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Yasumi\Yasumi;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::macro('isHoliday', function () {
            $holidays = Yasumi::create('Japan', $this->year);
            return $holidays->isHoliday($this->toDateTime());
        });
    }
}
