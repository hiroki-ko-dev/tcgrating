<?php

namespace Database\Seeders;
use App\Models\PostCategory;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PostCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PostCategory::insert([
            [ 'name' => 'free',          'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            [ 'name' => 'direct_massage','created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            [ 'name' => 'team',          'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            [ 'name' => 'team_wanted',   'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            [ 'name' => 'event',         'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            [ 'name' => 'personal',      'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
    }
}
