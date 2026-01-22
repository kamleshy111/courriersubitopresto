<?php


namespace App\Http\Controllers\Admin;


use App\Models\Client;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UsersController extends CRUDController {
    /*public function __construct(Request $request) {
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
    }*/

    public function __construct(Request $request)
{
    parent::__construct();

    $permissions = Permission::pluck('name', 'id');
    $roles = Role::pluck('name', 'id');

    $this->inject['permissions'] = $permissions;
    $this->inject['roles'] = $roles;

    $this->sync = ['permissions', 'roles'];

    
    if ($request->filled('password')) {
        $inputs = $request->all();
        $inputs['password'] = \Hash::make($request->input('password'));
        $request->replace($inputs);
    }
}


    public function create() {
        $this->inject['clients'] = Client::where('user_id', \Auth::id())->pluck('name', 'id');
        $this->inject['isCreate'] = true;
        return parent::create();
    }

    /*public function edit($id, $readonly = false) {

        $this->inject['clients'] = Client::where('user_id', \Auth::id())->pluck('name', 'id');
        return parent::edit($id, $readonly);
    }*/

    public function edit($id, $readonly = false)
{
    $user = \App\Models\User::findOrFail($id);
    $authUser = \Auth::user();


    if (!$authUser->hasRole('admin') && $authUser->id !== $user->id) {
        abort(403, 'Unauthorized action.');
    }

    
    $this->inject['clients'] = \App\Models\Client::where('user_id', $authUser->id)->pluck('name', 'id');

    
    if ($authUser->hasRole('admin')) {
        $this->inject['roles'] = \App\Models\Role::pluck('name', 'id');
        $this->inject['permissions'] = \App\Models\Permission::pluck('name', 'id');
    } else {
        // Hide roles/permissions from non-admins
        $this->inject['roles'] = collect(); // empty collection
        $this->inject['permissions'] = collect();
    }
    
    $this->inject['isCreate'] = false;

    return parent::edit($id, $readonly);
}

public function update(Request $request, $id)
{
    $request->request->remove('id'); 
    
    $authUser = \Auth::user();

    if (!$authUser->hasRole('admin')) {
        // Strip out sensitive fields for normal users
        $request->request->remove('roles');
        $request->request->remove('permissions');
    }

    return parent::update($request, $id);
}

function getRedirectUrl()
{
    $authUser = \Auth::user();

    if (!$authUser) {
        // fallback
        return route('login');
    }

    if (!$authUser->hasRole('admin')) {
        return url('/admin'); // redirect normal users
    }

    // admin default
    return parent::getRedirectUrl();
}



}
