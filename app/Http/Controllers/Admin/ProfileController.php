<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index');
    }

    public function account()
    {
        return view('admin.account.index');
    }

    public function updateInfo(Request $request)
    {
        $validator = \Validator::make($request->all(), [
           'email'   => 'required'
        ]);
        User::where('id', auth()->user()->id)
            ->update([
               'name'   => $request->name,
               'email'   => $request->email,
               'address'   => $request->address,
               'cellular'   => $request->cellular,
               'phone'   => $request->phone,
            ]);
        return redirect('admin/profile');
    }
}
