<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {


        \DB::table('permissions')
           ->delete();

        $permissions = [
            ['name' => "admin.dashboard.index"]
        ];
        $cruds = ["admin.users", "admin.permissions", "admin.roles", "admin.waybills", "admin.clients"];
        $actions = ["index", "create", "show", "edit", "destroy"];
        foreach($cruds as $crud)
            foreach($actions as $action)
                $permissions[] = ['name' => $crud.'.'.$action];

        \DB::table('permissions')
           ->insert($permissions);


    }
}
