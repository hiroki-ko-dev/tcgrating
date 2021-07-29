<?php

namespace Database\Seeders;

use App\Models\Rate;
use Illuminate\Database\Seeder;

class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::get();
        foreach ($users as $user) {
            $rate = new Rate();
            $rate->game_id = 1;
            $rate->user_id =$user->id;
            $rate->rate = $user->rate_yugioh_links;
            $rate->save();

            $rate = new Rate();
            $rate->game_id = 2;
            $rate->user_id =$user->id;
            $rate->rate = 0;
            $rate->save();

            $rate = new Rate();
            $rate->game_id = 3;
            $rate->user_id =$user->id;
            $rate->rate = 0;
            $rate->save();
        }

    }
}
