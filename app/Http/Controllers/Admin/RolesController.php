<?php
namespace App\Http\Controllers\Admin;

use App\Models\Permission;

class RolesController extends CRUDController {
    public function __construct() {
        parent::__construct();

        $permissions = Permission::pluck('name', 'id');

        $this->inject['permissions'] = $permissions;
        $this->inject['options'] = [];

        $this->sync = ['permissions'];
    }
}
