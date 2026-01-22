<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {


        \DB::table('permission_role')
           ->delete();

        $permission_role = \DB::table('permissions')->get('id')->map(function($permission) {
            return [
                'permission_id' => $permission->id,
                'role_id' => 1
            ];
        })->toArray();

        \DB::table('permission_role')
           ->insert($permission_role);


    }
}
