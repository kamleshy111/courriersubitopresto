<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Waybill;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DriverProgressController extends Controller
{
    public function index()
    {
        /*$drivers = User::whereHas('roles', function ($query) {
            $query->where('id', 3);  // Fetch only users with role id = 3
        })->pluck('name', 'id');  // Get [id => name] array

        return view('admin.waybills.drivers-progress',compact('drivers'));*/
        
        $drivers = User::whereHas('roles', function ($query) {
            $query->where('id', 3);  // Fetch only users with role id = 3
        })->pluck('name', 'id');  // Get [id => name] array

        return view('admin.waybills.drivers-progress',compact('drivers'));
        // return view('admin.waybills.drivers-progress');
    }
    
    public function assignDriver (Request $request) {
    // Validate incoming request
    $validated = $request->validate([
        'waybill_id' => 'required|integer|exists:waybills,id',
        'driver_id' => 'required|', // Assuming drivers are stored in the `users` table
    ]);

    // Find the waybill and update the driver_id
    $waybill = Waybill::find($request->waybill_id);
    // Waybill::where('id', $id)->update(['signature_note' => $signatureNote]);

    if ($waybill) {
        // Update the driver_id
        $waybill->driver_id = $request->driver_id;
        $waybill->delivery_status = 3;
        $waybill->save();

        // Return success response
        return response()->json(['success' => true, 'message' => 'Driver ID updated successfully.']);
    } else {
        return response()->json(['success' => false, 'message' => 'Waybill not found.']);
    }
}

    public function drivers()
    {
        $drivers = Driver::all();
        return response()->json($drivers);
    }

    public function getTodayWaybills()
    {
//        $today = Carbon::today(); // very_old
        // $waybills = Waybill::latest()->take(50)->get();
        $waybills = Waybill::where('approval_status', true)
                        ->latest()   // Order by the latest
                        ->take(50)   // Take the first 50
                        ->get();
                        return response()->json($waybills);
        return response()->json($waybills);
    }

    public function clients_api()
{
    $clients_data = Client::all();
    return response()->json($clients_data);
}

public function updateStickyNote(Request $request)
{
    /*$table = $request->input('table');    // E.g., 'waybills'
    $column = $request->input('column'); // E.g., 'user_id'
    $id = $request->input('id');         // Record ID
    $value = $request->input('value');   // New value

    if (!in_array($table, ['waybills', 'other_table_1', 'other_table_2'])) {
        return response()->json(['error' => 'Invalid table'], 400);
    }

    DB::table($table)->where('id', $id)->update([$column => $value]);

    return response()->json(['success' => true]);*/

    $validated = $request->validate([
        'selectedNoteId' => 'required|integer',
        'tableName' => 'required|string',
        'columnName' => 'required|string',
        'newValue' => 'required',
    ]);
        $tableName = $validated['tableName'];
        $columnName = $validated['columnName'];
        $selectedNoteId = $validated['selectedNoteId'];
        $newValue = $validated['newValue'];

        // Whitelist allowed tables and columns
        $allowedTables = ['waybills', 'clients', 'other_table_2']; // Replace with your tables
        $allowedColumns = ['user_id', 'status', 'phone', 'address', 'city_name', 'postal_code']; // Replace with your columns

        if (!in_array($tableName, $allowedTables) || !in_array($columnName, $allowedColumns)) {
            return response()->json(['error' => 'Invalid table or column'], 400);
        }

        // Perform the update
        try {
            DB::table($tableName)
                ->where('id', $selectedNoteId)
                ->update([$columnName => $newValue]);

            return response()->json(['success' => true, 'message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }

}

}
