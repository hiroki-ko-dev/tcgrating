<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Video;
use Carbon\Carbon;

class VideoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<10;$i++){
            Video::insert([
                'game_id'   => 3,
                'title'    => '動画のタイトル',
                'thumbnail_image_url' => 'https://pbs.twimg.com/media/FJERxyLVUAER4T6?format=jpg&name=large',
                'url'     => 'https://youtu.be/8JcpOitXWHQ',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
