<?php


namespace App\Http\Controllers\Admin;


use App\Models\Client;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class UsersController extends CRUDController {
    public function __construct(Request $request) {
        parent::__construct();

        $permissions = Permission::pluck('name', 'id');
        $roles       = Role::pluck('name', 'id');

        $this->inject['permissions'] = $permissions;
        $this->inject['roles']       = $roles;

        $this->sync = [
            'permissions',
            'roles'
        ];

        if($request->input('password')) {
            $inputs = $request->input();
            $inputs['password'] = \Hash::make($request->input('password'));
            $request->replace($inputs);
        }
    }

    public function create() {
        $this->inject['clients'] = Client::where('user_id', \Auth::id())->pluck('name', 'id');
        return parent::create();
    }

    public function edit($id, $readonly = false) {

        $this->inject['clients'] = Client::where('user_id', \Auth::id())->pluck('name', 'id');
        return parent::edit($id, $readonly);
    }
}
