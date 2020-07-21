<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('users')->insert(['id' => 1, 'name' => '山田太郎', 'email' => 'sute1@example.com', 'password' => bcrypt('password')]);
        DB::table('users')->insert(['id' => 2, 'name' => '畠山俊二', 'email' => 'sute2@example.com', 'password' => bcrypt('password')]);
        DB::table('users')->insert(['id' => 3, 'name' => '伊藤あきら', 'email' => 'sute3@example.com', 'password' => bcrypt('password')]);
        DB::table('users')->insert(['id' => 4, 'name' => '財条浩二', 'email' => 'sute4@example.com', 'password' => bcrypt('password')]);
    }
}
