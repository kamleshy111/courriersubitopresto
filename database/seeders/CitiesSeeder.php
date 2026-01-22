<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        \DB::table('cities')
           ->delete();

        $cities = array_map(function($city) { return ["name" => $city]; } , explode("\n", file_get_contents(base_path("database/seeders/cities.csv"))));

        \DB::table('cities')
           ->insert($cities);
    }
}
