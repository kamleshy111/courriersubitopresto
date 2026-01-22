<?php


namespace App\Http\Controllers\Admin;


use App\Models\City;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClientsController extends CRUDController {
    public function __construct() {
        parent::__construct();

        if(!is_null(\request()->route()) && in_array(\Str::of(\request()
                                                                  ->route()
                                                                  ->getName())
                                                         ->afterLast('.'), [
                                                         'show',
                                                         'edit',
                                                         'destroy'
                                                     ])) {

            $this->middleware(function($request, $next) {
                if(\Laratrust::hasRole('admin')) {
                    return $next($request);
                }
                $client = Client::findOrFail($request->route()
                                                       ->parameter('client'));
                abort_if(!\Laratrust::owns($client), 404);
                return $next($request);
            });

        }

        $this->inject['cities'] = City::pluck('name', 'id');
    }

    public function autocomplete(Request $request) {
        $client = Client::where('name', 'LIKE', '%' . $request->get('term') . '%')
                     ->select([
                                  'id',
                                  \DB::raw('CONCAT(name, " [", phone, "]") as label'),
                                  'name as value',
                                  'phone',
                                  'extension',
                                  'address',
                                  'city_name',
                                  'city_id',
                                  'city_state',
                                  'postal_code',
                                  'contact',
                                  'note_permanent'
                              ]);
        if(!\Laratrust::hasRole('admin')) {
            $client->where('user_id', \Auth::id());
        }
        return $client->get();
    }

    public function userClients($userId)
    {
        return view('admin.clients.user-clients.index', compact('userId'));
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
        DB::table('users')
        ->where('id', $userId)
        ->update(['id' => $userId + 50000]);
        Log::info('User deleted: .', ['userID' => $userId]);
    }

    public function deleteClient($clientId)
    {
        $client = Client::findOrFail($clientId);
        $client->delete();
        DB::table('users')
        ->where('id', $clientId)
        ->update(['id' => $clientId + 50000]);
        Log::info('Client deleted: .', ['clientId' => $clientId]);
        //  Log::info('user deleted from client function.', $clientId);
    }
}
