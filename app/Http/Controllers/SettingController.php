<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::where('user_id', Auth::user()->id)->first();
        return view('admin.settings.show', compact('settings'));
    }
    public function store(Request $request)
    {
       Setting::updateOrCreate(
           ['user_id' => Auth::user()->id],
           ['user_id' => Auth::user()->id, 'show_price' => $request->show_price],
       );
        return redirect('admin/settings');
    }

    public function setPermission()
    {
        $users = User::get();

            try {
                foreach ($users as $user) {
                    DB::transaction(function () use($user) {
                        DB::table('permission_user')
                            ->insert([
                                'permission_id' => 47,
                                'user_id' => $user->id,
                                'user_type' => 'App\Models\User'
                            ]);
                        DB::table('permission_user')
                            ->insert([
                                'permission_id' => 48,
                                'user_id' => $user->id,
                                'user_type' => 'App\Models\User'
                            ]);
                        DB::table('permission_user')
                            ->insert([
                                'permission_id' => 49,
                                'user_id' => $user->id,
                                'user_type' => 'App\Models\User'
                            ]);
                        DB::table('permission_user')
                            ->insert([
                                'permission_id' => 50,
                                'user_id' => $user->id,
                                'user_type' => 'App\Models\User'
                            ]);
                    });
                }
            } catch (\Throwable $e) {
            }


    }
}
