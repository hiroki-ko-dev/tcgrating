<?php

namespace Database\Seeders;
use App\Models\Game;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class GameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Game::insert([
            [
                'name' => '遊戯王デュエルリンクス',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
