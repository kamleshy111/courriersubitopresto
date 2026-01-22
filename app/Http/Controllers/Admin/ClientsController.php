<?php


namespace App\Http\Controllers\Admin;


use App\Models\City;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;


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

            /*$this->middleware(function($request, $next) {
                if(\Laratrust::hasRole('admin')) {
                    return $next($request);
                }
                $client = Client::findOrFail($request->route()
                                                       ->parameter('client'));
                // abort_if(!\Laratrust::owns($client), 404);
                abort_if(
                !\Laratrust::hasRole('admin') && !\Laratrust::owns($client),
                403
            );
                return $next($request);
            });*/
            
            // new test
            $this->middleware(function($request, $next) {
    if (\Laratrust::hasRole('admin')) {
        return $next($request);
    }

    $client = Client::findOrFail($request->route()->parameter('client'));

    // User can only access their own client record
    abort_if(
        auth()->user()->client_id !== $client->id,
        403
    );

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
                                  'address_ext',
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

    /*public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
        DB::table('users')
        ->where('id', $userId)
        ->update(['id' => $userId + 50000]);
        Log::info('User deleted: .', ['userID' => $userId]);
    }*/
    
    public function deleteUser($userId)
    {
        function getUniqueUserId($baseUserId, $step = 10000)
        {
            $tempNewUserId = $baseUserId + 50000;

            while (DB::table('users')->where('id', $tempNewUserId)->exists()) {
                $tempNewUserId += $step;
            }

            return $tempNewUserId;
        }

        $newUserId = getUniqueUserId($userId);
        Log::info('Generated new user ID: ' . $newUserId . ' for old user ID: ' . $userId);
        $user = User::findOrFail($userId);
        $user->delete();
        DB::table('users')
        ->where('id', $userId)
        ->update(['id' => $newUserId]);

        DB::table('clients')
        ->where('user_id', $userId)
        ->update(['user_id' => $newUserId]);


        DB::table('waybills')
        ->where('user_id', $userId)
        ->update(['user_id' => $newUserId]);
        // Log::info('user deleted from user function.', $userId);
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
    
//     public function store_pdf(Request $request, $clientId)
// {

//      Log::info('Test log: store_pdf method called');
//     Log::info('PDF File called: ');  // Log the relative path
//     // find client (route model binding not used here)
//     $client = Client::findOrFail($clientId);

public function store_pdf_old_working(Request $request)
{
    Log::info('store_pdf called');

    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'pdf' => 'required|file|mimes:pdf|max:10240',
    ]);

    $client = Client::findOrFail($request->client_id);

    $request->validate([
        'pdf' => 'required|file|mimes:pdf|max:10240', // 10MB
    ]);

    $file = $request->file('pdf');

    if (! $file->isValid()) {
        if ($request->ajax()) {
            return response()->json(['error' => 'Invalid PDF file'], 422);
        }
        return redirect()->back()->withErrors(['pdf' => 'Invalid PDF file']);
    }

    $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
    $folder = "pdfs/{$client->id}";
    $relativePath = $folder . '/' . $filename;

    // store file on public disk
    $file->storeAs($folder, $filename, 'public');

    // remove old file if exists
    if (!empty($client->client_pdf) && Storage::disk('public')->exists($client->client_pdf)) {
        Storage::disk('public')->delete($client->client_pdf);
    }

    $client->client_pdf = $relativePath;
    $client->save();

    // If AJAX request, return JSON with url & filename
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'path' => $relativePath,
            'url' => Storage::disk('public')->url($relativePath),
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    return redirect()->back()->with('message', ['success', 'PDF uploaded']);
}

public function store_pdf(Request $request)
{
    Log::info('store_pdf called');

    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'pdf' => 'required|file|mimes:pdf|max:10240',
    ]);

    $client = Client::findOrFail($request->client_id);
    $file = $request->file('pdf');

    $filename = Str::random(40).'.'.$file->getClientOriginalExtension();
    $folder = "pdfs/{$client->id}";
    $relativePath = "$folder/$filename";

    $file->storeAs($folder, $filename, 'public');

    if ($client->client_pdf && Storage::disk('public')->exists($client->client_pdf)) {
        Storage::disk('public')->delete($client->client_pdf);
    }

    $client->client_pdf = $relativePath;
    $client->save();

    // aLWAYS return JSON for fetch()
    return response()->json([
        'success' => true,
        'path' => $relativePath,
        'url' => Storage::disk('public')->url($relativePath),
        'filename' => $file->getClientOriginalName(),
    ]);
}



public function delete_pdf_old(Request $request, $clientId)
{
    $client = \App\Models\Client::findOrFail($clientId);

    if (!empty($client->client_pdf) && Storage::disk('public')->exists($client->client_pdf)) {
        Storage::disk('public')->delete($client->client_pdf);
    }

    $client->client_pdf = null;
    $client->save();

    if ($request->ajax()) {
        return response()->json(['success' => true]);
    }

    return redirect()->back()->with('message', ['success', 'PDF deleted']);
}

public function delete_pdf(Request $request, $clientId)
{
    // Only admin can delete
    if (!\Laratrust::hasRole('admin')) {
        abort(403, "You don't have permission to delete PDFs.");
    }

    $client = Client::findOrFail($clientId);

    // Delete file if exists
    if ($client->client_pdf && Storage::disk('public')->exists($client->client_pdf)) {
        Storage::disk('public')->delete($client->client_pdf);
    }

    // Remove reference in DB
    $client->client_pdf = null;
    $client->save();

    return response()->json([
        'success' => true,
        'message' => 'PDF deleted successfully'
    ]);
}


public function emailClientPassUpdate()
{
    return response()->json(['ok' => true]);
}






}
