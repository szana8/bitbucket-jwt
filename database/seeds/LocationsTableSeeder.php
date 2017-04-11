<?php

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Test data
        $faker = \Faker\Factory::create();

        for ( $i = 0; $i <= 100; $i++ )
        {
            DB::table('locations')->insert([
                'location_code' => $faker->unique()->countryCode,
                'description' => $faker->realText($maxNbChars = 100, $indexSize = 1),
                'address_line_1' => $faker->address,
                'address_line_2' => $faker->address,
                'address_line_3' => $faker->address,
                'town_or_city' => $faker->city,
                'country' => $faker->country,
                'postal_code' => $faker->postcode,
                'region' => $faker->state,
                'region_2' => $faker->state,
                'region_3' => $faker->state,
                'phone_number' => $faker->phoneNumber,
                'phone_number_2' => $faker->phoneNumber,
                'phone_number_3' => $faker->phoneNumber,
                'ship_to_site_flag' => $faker->boolean,
                'bill_to_site_flag' => $faker->boolean,
                'office_site_flag' => $faker->boolean,

            ]);
        }

    }
}
