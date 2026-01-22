<?php



namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;

use App\Models\Driver;

use App\Models\Waybill;

use App\Models\Client;

use App\Models\Dashboard;

use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\User;





class DriverProgressController extends Controller

{

    public function index()

    {

        // $drivers = User::where('role', 3)->get();

        $drivers = User::whereHas('roles', function ($query) {

            $query->where('id', 3);  // Fetch only users with role id = 3

        })->get(['id', 'name', 'phone', 'cheque_note']);  // Get 'id', 'name', and 'note' fields

        // ->pluck('name', 'id');  // Get [id => name] array

        /*$cheque = User::whereHas('roles', function ($query) {

            $query->where('id', 3);  // Fetch only users with role id = 3

        })->pluck('cheque_note', 'id');  // Get [id => name] array*/

        // $waybills = Waybill::with('recipient', 'shipper');

        // $waybills = Waybill::with('recipient', 'shipper')->get();

        

        $dashboardPosition = Dashboard::all();



        $waybills = Waybill::with('recipient', 'shipper')

        ->whereNotNull('driver_id')  // Only get waybills where driver_id is not null

        ->get();



        // debugging

        // $waybills = Waybill::with('recipient', 'shipper')

        // ->latest()  // Order by the latest records (based on created_at)

        // ->take(100)  // Limit to the last 100 records

        // ->get();  // Execute the query and get the results



        // return view('admin.waybills.drivers-progress',compact('drivers',"waybills"));

        return view('admin.waybills.drivers-progress',compact('drivers',"waybills","dashboardPosition"));

    }



    public function getWaybillData($driverId)

{

    // Fetch waybills assigned to the selected driver (you can adjust the query as per your requirements)

    // $waybills = Waybill::where('driver_id', $driverId)->pluck('id');  // Only fetching waybill IDs (adjust as needed)

    $waybills = Waybill::with('recipient', 'shipper')

    // ->WhereNotnull ('driver_id')

    ->where('driver_id', $driverId)

    // $waybills = Waybill::whereNotNull('driver_id')  // Only get waybills where driver_id is not null

    ->get();



    // Return the waybill data in JSON format

    return response()->json([

        'waybills' => $waybills

    ]);

}



// public function assignDriver (Request $request) {

//     // Validate incoming request

//     $validated = $request->validate([

//         'waybill_id' => 'required|integer|exists:waybills,id',

//         'driver_id' => 'required|', // Assuming drivers are stored in the `users` table

//     ]);



//     // Find the waybill and update the driver_id

//     $waybill = Waybill::find($request->waybill_id);

//     // Waybill::where('id', $id)->update(['signature_note' => $signatureNote]);



//     if ($waybill) {

//         // Update the driver_id

//         $waybill->driver_id = $request->driver_id;

//         // $waybill->delivery_status = 3;

//         $waybill->save();



//         // Return success response

//         return response()->json(['success' => true, 'message' => 'Driver ID updated successfully.']);

//     } else {

//         return response()->json(['success' => false, 'message' => 'Waybill not found.']);

//     }

// }









public function assignDriver (Request $request) {

    // Validate incoming request

    $validated = $request->validate([

        'waybill_id' => 'required|integer|exists:waybills,id',

        'driver_id' => 'required|', // Assuming drivers are stored in the `users` table

        'delivery_status' =>'nullable',
        'commission' => 'nullable'


    ]);



    // Find the waybill and update the driver_id

    $waybill = Waybill::find($request->waybill_id);

    // Waybill::where('id', $id)->update(['signature_note' => $signatureNote]);



    if ($waybill && !$request->delivery_status) {

        // Update the driver_id

        $waybill->driver_id = $request->driver_id;

        // $waybill->delivery_status = 3;

        $waybill->save();



        // Return success response

        return response()->json(['success' => true, 'message' => 'Driver ID updated successfully.']);

    }

    else if($waybill && $request->delivery_status){

        $waybill->driver_id = $request->driver_id;

        $waybill->delivery_status = $request->delivery_status;
        // if($request->commission == true)
        if(filter_var($request->commission, FILTER_VALIDATE_BOOLEAN))
        {
            $waybill->drop_time = now();
        }

        $waybill->save();



        // Return success response

        return response()->json(['success' => true, 'message' => 'Driver ID updated successfully.']);



    }

    else {

        return response()->json(['success' => false, 'message' => 'Waybill not found.']);

    }

}







public function driversList()

{

    $drivers = User::whereHas('roles', function ($query) {

        $query->where('id', 3);  // Fetch only users with role id = 3

    })->pluck('name', 'id');

    return response()->json($drivers);



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

        'newValue' => 'required|nullable',

    ]);

        $tableName = $validated['tableName'];

        $columnName = $validated['columnName'];

        $selectedNoteId = $validated['selectedNoteId'];

        $newValue = $validated['newValue'];



        // if($newValue === ""){

        //     $newValue = null;

        // }



        // Whitelist allowed tables and columns

        // $allowedTables = ['waybills', 'clients', 'other_table_2','users']; // Replace with your tables

        // $allowedColumns = ['user_id', 'status', 'phone', 'address', 'city_name', 'postal_code', 'stickyNote_day', 'description' , 'weight_1', 'truck_1', 'waiting_time_1','note_permanent','dashboard_position','cheque_note']; // Replace with your columns

        

        $allowedTables = ['waybills', 'clients', 'other_table_2','users','dashboard']; // Replace with your tables

        $allowedColumns = ['user_id', 'status', 'phone', 'contact', 'address', 'city_name', 'postal_code', 'stickyNote_day', 'description' , 'weight_1', 'truck_1', 'waiting_time_1','note_permanent','dashboard_position','cheque_note','notes','dashboard_price','comission_price', 'shipper_note','receiver_note','shipper_contact', 'recipient_contact']; // Replace with your columns



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







public function removePosition(Request $request)

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

        // 'newValue' => 'required|string|nullable',

    ]);

        $tableName = $validated['tableName'];

        $columnName = $validated['columnName'];

        $selectedNoteId = $validated['selectedNoteId'];

        // $newValue = $validated['newValue'];

        // $newValue =  $request->input('newValue',null);



        // if($newValue === ""){

        //     $newValue = null;

        // }



        // Whitelist allowed tables and columns

        $allowedTables = ['waybills']; // Replace with your tables

        $allowedColumns = ['dashboard_position']; // Replace with your columns



        if (!in_array($tableName, $allowedTables) || !in_array($columnName, $allowedColumns)) {

            return response()->json(['error' => 'Invalid table or column'], 400);

        }



        // Perform the update

        try {

            DB::table($tableName)

                ->where('id', $selectedNoteId)

                ->update([$columnName => null]);



            return response()->json(['success' => true, 'message' => 'Data updated successfully']);

        } catch (\Exception $e) {

            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);

        }



}



public function updatChequeStatus(Request $request){

    $validated = $request->validate([

        'cellId' => 'required|string',

        'tableName' => 'required|string',

        'cheque_status' => 'required|integer',

        'absent_status' => 'required|integer'



    ]);

        $tableName = $validated['tableName'];

        $cellId = $validated['cellId'];

        // $id = preg_replace("/cell\d*/", "", $cellId);

        // $id = preg_replace("/^cell\d*/", "", $cellId);

        $id = preg_replace("/cell/", "", $cellId);

        $cheque_status = $validated['cheque_status'];

        $absent_status = $validated['absent_status'];





        $chequeColumn = "active_cheque";

        $absentColumn = "active_absent";

        // if($newValue === ""){

        //     $newValue = null;

        // }

        /*Log::info('cheque & absent status update called!', [

            'cellId' => $cellId,

            'id' => $id,  // Corrected from $id to $waybillId

            'tableName' => $tableName,

            'cheque_status' => $cheque_status,

            'absent_status' => $absent_status,

        ]);*/

        // Whitelist allowed tables and columns

        $allowedTables = ['dashboard']; // Replace with your tables

        $allowedColumns = ['active_cheque', 'active_absent']; // Replace with your columns



        if (!in_array($tableName, $allowedTables) || !in_array($chequeColumn, $allowedColumns)) {

            return response()->json(['error' => 'Invalid table or column'], 400);

        }



        // Perform the update

        try {

            DB::table($tableName)

                ->where('id', $id)

                ->update([

                    $chequeColumn => $cheque_status,

                    $absentColumn => $absent_status,



                ]);



            return response()->json(['success' => true, 'message' => 'Data updated successfully']);

        } catch (\Exception $e) {

            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);

        }

}



}

