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
        DB::table('users')->insert([
            'email'             => 'admin@localhost.com',
            'password'          => Hash::make('password'),
        ]);

        DB::table('profiles')->insert([
            'user_id' => 1,
            'type' => 'database',
            'name' => 'Administrator'
        ]);

        $faker = Factory::create();

        for($i=0; $i<= 100; $i++)
        {
            $user = DB::table('users')->insertGetId([
                'email'             => $faker->email,
                'password'          => Hash::make('password'),
            ]);

            DB::table('profiles')->insert([
                'user_id' => $user,
                'type' => 'database',
                'name' => $faker->name
            ]);
        }

    }
}
