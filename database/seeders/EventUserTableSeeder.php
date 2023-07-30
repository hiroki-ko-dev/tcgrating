<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventUser;
use App\Enums\EventUserStatus;
use Carbon\Carbon;

class EventUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $event_id = 847;
        $user_id = 2;

        for ($i = 0; $i < 10; $i++) {
            EventUser::insert([
                'event_id'   => $event_id,
                'user_id'    => $user_id + $i,
                'status'     => EventUserStatus::REQUEST->value,
                'rating'     => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
