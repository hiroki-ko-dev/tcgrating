<?php

namespace Database\Seeders;
use App\Models\EventCategory;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EventCategory::insert([
            [ 'name' => '1vs1決闘', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
