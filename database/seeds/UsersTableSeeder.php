<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        DB::table('users')->insert([
            'email'             => 'admin@localhost.com',
            'password'          => Hash::make('password'),
        ]);

        DB::table('profiles')->insert([
            'user_id' => 1,
            'type' => 'database',
            'name' => 'Administrator'
        ]);
    }
}
