<?php

namespace Database\Seeders;
use App\Models\DuelCategory;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DuelCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DuelCategory::insert([
            [ 'name' => 'シングル決闘', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            [ 'name' => 'point','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
