<?php

use Illuminate\Database\Seeder;

class LovTableSeeder extends Seeder
{

    /**
     * @var array
     */
    protected $_lovs = [
        [
            "name"         => "User List",
            "datatype"         => 1,
            "table_name" => 'users with profiles',
            "column"  => 'email, name and bla bla bla bla',
            "condition" => 'where profiles exists and bla bla bla bla'
        ],
        [
            "name"         => "SQL",
            "datatype"         => 2,
            "table_name" => NULL,
            "column"  => NULL,
            "condition" => NULL
        ],
        [
            "name"         => "Operations",
            "datatype"         => 2,
            "table_name" => NULL,
            "column"  => NULL,
            "condition" => NULL
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->_lovs as $lov) {
            DB::table('list_of_values')->insert($lov);
        }
    }
}
