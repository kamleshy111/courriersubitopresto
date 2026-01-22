<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {


        \DB::table('users')
           ->delete();

        \DB::table('users')
           ->insert([
                        [
                            'id'             => 1,
                            'name'           => 'Gilbert Paquin',
                            'email'          => 'gilbertpaquin1995@gmail.com',
                            'password'       => bcrypt('a13794682'),
                            'remember_token' => null,
                            'created_at'     => '2017-03-05 15:06:23',
                            'updated_at'     => '2017-11-29 13:50:58',
                        ]
                    ]);


    }
}
