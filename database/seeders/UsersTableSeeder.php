<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name' => 'free',
                'email' => 'hashimu01.mail@gmail.com',
                'password' => '$2y$10$rm4/Iepb2vKHpj1Sl091zusD8mY.x1rsUbrvqun83HVaZhASPyyqC',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
