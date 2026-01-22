<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {


        \DB::table('roles')
           ->delete();

        \DB::table('roles')
           ->insert([
                        [
                            'id'           => 1,
                            'name'         => 'admin',
                            'display_name' => 'Administrateur',
                            'description'  => null,
                            'created_at'   => null,
                            'updated_at'   => null,
                        ]
                    ]);


    }
}
