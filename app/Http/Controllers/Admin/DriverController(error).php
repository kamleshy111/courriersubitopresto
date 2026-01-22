<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Carbon\Carbon;
use App\Models\Waybill;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mpdf\Mpdf;

class DriverController extends Controller
{

    public function index()
    {
        /*$drivers = User::whereHas('roles', function ($query) {
            $query->where('id', 3);  // Fetch only users with role id = 3
        })->pluck('name', 'id');  // Get [id => name] array

        return view('admin.waybills.drivers-progress',compact('drivers'));*/
        return view('admin.drivers.index');
    }

    // all waybill
    public function adminDriverWaybill($id){
        // public function singleUpload (){
        // old
        /*$waybills = Waybill::where('driver_id', 6)
        ->orderBy('id', 'DESC')
        ->get();*/
        $waybills = Waybill::with('recipient', 'shipper') // Eager load the related shipper (Client) data
        ->where('driver_id', $id)  // Example where clause
        ->orderBy('id', 'DESC')
        ->get();
        // $recipientClient = Client::Where('id',$waybills);
        // return view('admin.drivers.waybill', compact('waybills', 'recipientClient'));
        return view('admin.drivers.waybill', compact('waybills'));
    }


    public function adminDriverWaybillOnProgress($id){

        $waybills = Waybill::with('recipient', 'shipper') // Eager load the related shipper (Client) data
        ->where('driver_id', $id)  // Example where clause
        // ->where('delivery_status', 3)  // Example where clause
        ->where(function($query) {
        $query->where('delivery_status', 3);  // delivery_status == 3
            //   ->orWhereNull('delivery_status');  // OR delivery_status is NULL
        })
        ->orderBy('id', 'DESC')
        ->get();
        // $recipientClient = Client::Where('id',$waybills);
        // return view('admin.drivers.waybill', compact('waybills', 'recipientClient'));
        return view('admin.drivers.waybill', compact('waybills'));
    }

    // pickedup
    public function adminDriverWaybillPickedUp($id){

        $waybills = Waybill::with('recipient', 'shipper') // Eager load the related shipper (Client) data
        ->where('driver_id', $id)  // Example where clause
        ->where('delivery_status', 2)  // Example where clause
        ->orderBy('id', 'DESC')
        ->get();
        // $recipientClient = Client::Where('id',$waybills);
        // return view('admin.drivers.waybill', compact('waybills', 'recipientClient'));
        return view('admin.drivers.waybill', compact('waybills'));
    }

    // delivered
    public function adminDriverWaybillDelivered($id){
        $waybills = Waybill::with('recipient', 'shipper') // Eager load the related shipper (Client) data
        ->where('driver_id', $id)  // Example where clause
        ->where('delivery_status', 1)  // Example where clause
        ->orderBy('id', 'DESC')
        ->get();
        // $recipientClient = Client::Where('id',$waybills);
        // return view('admin.drivers.waybill', compact('waybills', 'recipientClient'));
        return view('admin.drivers.waybill', compact('waybills'));
    }


     public function driverSummaryTable($id, Request $request)
{
    $currentDate = $request->get('date', now()->format('Y-m-d'));

    // Load initial waybills for the current date
    $waybills = Waybill::with(['recipient', 'shipper'])
        ->where('driver_id', $id)
        ->where('delivery_status', 1)
        ->whereDate('drop_time', '=', $currentDate)
        ->orderBy('id', 'DESC')
        ->get();

    $driver = User::find($id);

    // Compact driver, waybills, date and ID to the view
    // return view('admin.drivers.summaryTable', ['waybills' => [], 'drivers' => []]);
    return view('admin.drivers.summaryTable', compact('waybills', 'driver', 'currentDate', 'id'));
}

/*public function getDriverWaybills(Request $request, $id)
{
    $date = $request->get('date', now()->format('Y-m-d'));

    $waybills = Waybill::with(['recipient', 'shipper'])
        ->where('driver_id', $id)
        ->where('delivery_status', 1)
        ->whereDate('drop_time', '=', $date)
        ->orderBy('id', 'DESC')
        ->get();

    $driver = User::find($id);

    return response()->json([
        'waybills' => $waybills->map(function ($waybill) {
            return [
                'shipper_address' => $waybill->shipper->address ?? 'N/A',
                'recipient_address' => $waybill->recipient->address ?? 'N/A',
                'invoice_number' => $waybill->shipper->prefix . str_pad($waybill->soft_id, 6, 0, STR_PAD_LEFT),
                'status' => $waybill->status ?? 'N/A',
                'description' => $waybill->description ?? 'N/A',
                'price' => $waybill->price
            ];
        }),
        'driver_name' => $driver->name ?? 'Unknown Driver',
        'driver_id' => $driver->id ?? 'N/A'
    ]);
}*/

public function getDriverWaybills(Request $request, $id)
{
    $date = $request->get('date', now()->format('Y-m-d'));

    $waybills = Waybill::with(['recipient', 'shipper'])
        ->where('driver_id', $id)
        ->where('delivery_status', 1)
        ->whereDate('drop_time', '=', $date)
        ->orderBy('id', 'DESC')
        ->get();

    $driver = User::find($id);

    if (\Auth::check()) {
        $user = \Auth::user();

        // Use raw query or relationship
        if ($user->roles->contains('id', 1)) { // Ensure roles relationship exists
            $isAdmin = 1;
        }
        else{
            $isAdmin = 0;
        }
    }

    return response()->json([
        'waybills' => $waybills->map(function ($waybill) {
            return [
                'id' => $waybill -> id ?? 'Null',
                'shipper_address' => $waybill->shipper->address ?? 'N/A',
                'recipient_address' => $waybill->recipient->address ?? 'N/A',
                'invoice_number' => $waybill->shipper->prefix . str_pad($waybill->soft_id, 6, 0, STR_PAD_LEFT),
                'status' => $waybill->status ?? 'N/A',
                'description' => $waybill->description ?? 'N/A',
                'price' => $waybill->comission_price
            ];
        }),
        'driver_name' => $driver->name ?? 'Unknown Driver',
        'driver_id' => $driver->id ?? 'N/A',
        'isAdmin' => $isAdmin ?? 'N/A'
    ]);
}



    public function clientDriverWaybill(){
        $userId = null;
        if (\Auth::check()) {
            $user = \Auth::user();

            // Use raw query or relationship
            if ($user->roles->contains('id', 3)) { // Ensure roles relationship exists
                $userId = $user->id;
            }
        }

        $waybills = Waybill::with('recipient', 'shipper') // Eager load the related shipper (Client) data
        ->where('driver_id', $userId)  // Example where clause
        ->orderBy('id', 'DESC')
        ->get();
        // $recipientClient = Client::Where('id',$waybills);
        // return view('admin.drivers.waybill', compact('waybills', 'recipientClient'));
        return view('admin.drivers.waybill', compact('waybills'));
    }

    // onprogress

    public function clientDriverWaybillOnProgress(){
        $userId = null;
        if (\Auth::check()) {
            $user = \Auth::user();

            // Use raw query or relationship
            if ($user->roles->contains('id', 3)) { // Ensure roles relationship exists
                $userId = $user->id;
            }
        }

        $waybills = Waybill::with('recipient', 'shipper') // Eager load the related shipper (Client) data
        ->where('driver_id', $userId)  // Example where clause
        // ->where('delivery_status', 3)  // Example where clause
        ->where(function($query) {
        $query->where('delivery_status', 3);  // delivery_status == 3
            //   ->orWhereNull('delivery_status');  // OR delivery_status is NULL
        })
        ->orderBy('id', 'DESC')
        ->get();
        // $recipientClient = Client::Where('id',$waybills);
        // return view('admin.drivers.waybill', compact('waybills', 'recipientClient'));
        return view('admin.drivers.waybill', compact('waybills'));
    }

    // pickedup
    public function clientDriverWaybillPickedUp(){
        $userId = null;
        if (\Auth::check()) {
            $user = \Auth::user();

            // Use raw query or relationship
            if ($user->roles->contains('id', 3)) { // Ensure roles relationship exists
                $userId = $user->id;
            }
        }

        $waybills = Waybill::with('recipient', 'shipper') // Eager load the related shipper (Client) data
        ->where('driver_id', $userId)  // Example where clause
        ->where('delivery_status', 2)  // Example where clause
        ->orderBy('id', 'DESC')
        ->get();
        // $recipientClient = Client::Where('id',$waybills);
        // return view('admin.drivers.waybill', compact('waybills', 'recipientClient'));
        return view('admin.drivers.waybill', compact('waybills'));
    }

    // delivered
    public function clientDriverWaybillDelivered(){
        $userId = null;
        if (\Auth::check()) {
            $user = \Auth::user();

            // Use raw query or relationship
            if ($user->roles->contains('id', 3)) { // Ensure roles relationship exists
                $userId = $user->id;
            }
        }

        $waybills = Waybill::with('recipient', 'shipper') // Eager load the related shipper (Client) data
        ->where('driver_id', $userId)  // Example where clause
        ->where('delivery_status', 1)  // Example where clause
        ->orderBy('id', 'DESC')
        ->get();
        // $recipientClient = Client::Where('id',$waybills);
        // return view('admin.drivers.waybill', compact('waybills', 'recipientClient'));
        return view('admin.drivers.waybill', compact('waybills'));
    }

    public function driverWaybillList(){
        $waybillings = Waybill::where('driver_id', 6)
        ->orderBy('id', 'DESC')
        ->get();

    // Return view with waybills data
    return view('admin.drivers.list', compact('waybillings'));
    }

    public function singleUpload1($id){
        // $waybills = Waybill::where('driver_id', 6)
        // ->orderBy('id', 'DESC')
        // ->get();
        return view('admin.drivers.single', compact('id'));
        // return view('admin.drivers.single');
    }



    // it's working good
    public function singleUpload2($id){
        // public function singleUpload (){
        $waybills = Waybill::where('id', $id)
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.drivers.waybill', compact('waybills'));
    }


    public function singleUpload($id){
        // public function singleUpload (){
        $waybills = Waybill::where('id', $id)
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.drivers.single', compact('waybills'));
    }

    public function singleImageView($id){
        // public function singleUpload (){
        $waybills = Waybill::where('id', $id)
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.drivers.singleImageView', compact('waybills'));
    }

    public function indexDataTable()
    {
        $result = Driver::query()
            ->orderBy('id', 'DESC')
            ->get();

        return datatables($result)

            ->editColumn('action', function($row)
            {
                $button  = '<div class="row">';
                $button .= '<div class="col-md-12 col-sm-6">';
                $button .= '<a class="btn btn-sm btn-info" title="modifier" style="width: 3rem; padding: 8px 0; background-color:#054AFA;" href="' . url('admin/drivers/' .$row->id . '/edit') . '"><i class="fa fa-edit"></i></a>';
                $button .= '</div></div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function driversList3() {
        $userId = null;

        if (\Auth::check()) {
            $user = \Auth::user();

            // Use raw query or relationship
            if ($user->roles->contains('id', 3)) { // Ensure roles relationship exists
                $userId = $user->id;
            }
        }

        // Fetch users from the database
        $users = User::all(); // Adjust the query based on your requirements

        return view('admin.drivers.driver-list', compact('userId', 'users'));
        // return view('admin.drivers.driver-list');
    }

    public function driversList2() {
        $userId = null;

        if (\Auth::check()) {
            $user = \Auth::user();

            // Use raw query or relationship
            if ($user->roles->contains('id', 3)) { // Ensure roles relationship exists
                $userId = $user->id;
            }
        }

        // Fetch users from the database
        $users = User::all(); // Adjust the query based on your requirements

        return view('admin.drivers.driver-list', compact('userId', 'users'));
        // return view('admin.drivers.driver-list');
    }

    public function driversList() {
        // admin chk
        /*if (!\Auth::check()) {
            // Redirect to login page if not authenticated
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        $user = \Auth::user();

        // Check if the logged-in user is an admin
        if (!$user->roles->contains('id', 1)) { // Assuming role ID `1` is for admin
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }*/
        // Fetch users who have the role with id = 3
        $users = User::whereHas('roles', function ($query) {
            $query->where('id', 3);
        })->get();

        return view('admin.drivers.driver-list', compact('users'));
    }

    public function create()
    {
        return view('admin.drivers.create');
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(),[
           'phone'     => 'nullable|digits:10',
            'email'    => 'nullable|unique:drivers'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Driver::create([
            'full_name'     => $request->full_name,
            'extension'     => $request->extension,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'address'       => $request->address,
        ]);
        return redirect('admin/drivers');
    }


    public function show($id)
    {

    }


    public function edit($id)
    {
        $driver = Driver::findOrFail($id);
        return view('admin.drivers.edit', compact('driver'));
    }


    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(),[
            'email'    => 'nullable|unique:drivers,email, '.$id.',id'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Driver::where('id', $id)->update([
            'full_name'     => $request->full_name,
            'extension'     => $request->extension,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'address'       => $request->address,
        ]);
        return redirect('admin/drivers');
    }


    public function destroy($id)
    {
        //
    }

    public function driverWaybillUpdate(Request $request)
{


    $validated = $request->validate([
        // 'selectedNoteId' => 'required|integer',
        'table' => 'required|string',
        'column' => 'required|string',
        'new_value' => 'required',
        'id' => 'required'
    ]);
        $table = $validated['table'];
        $column = $validated['column'];
        // $selectedNoteId = $validated['selectedNoteId'];
        $id = $validated['id'];
        $newValue = $validated['new_value'];



        // Whitelist allowed tables and columns
        // $allowedTables = ['waybills', 'clients', 'other_table_2']; // Replace with your tables
        // $allowableTables = ['waybills']; // Replace with your tables
        // $allowableColumns = ['weight_1', 'status', 'phone', 'address', 'city_name', 'postal_code']; // Replace with your columns
        // $allowableColumns = ['weight_1']; // Replace with your columns

        /*if (!in_array($table, $allowableTables) || !in_array($column, $allowableColumns)) {
            return response()->json(['error' => 'Invalid table or column'], 400);
        }*/

        // Perform the update
        try {
            DB::table($table)
                ->where('id', $id)
                ->update([$column => $newValue]);

            return response()->json(['success' => true, 'message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }

}


public function emailReport(Request $request){
    // it works fine
    /*Mail::html('<h1>Hello, World!</h1>', function ($message) {
    $message->to('ali2015333061@gmail.com')
            ->subject('Simple HTML Email');
});*/
    $waybillsToSend = $request->input('reportData');
    // $waybillsToSend = [28212, 27938, 28210];
    if(!empty($waybillsToSend)) {
                
                    $pdf = $this->emailSummaryPdf(Waybill::with('user.client', 'shipper', 'recipient')->whereIn('id', $waybillsToSend)->get(), true, 1, false);
                    Log::info('PDF generated successfully', ['waybills' => $waybillsToSend]);

                    $pdf = $this->emailPdf(Waybill::with('user.client', 'shipper', 'recipient')->whereIn('id', $waybillsToSend)->get(), true, 1, false);
                    Log::info('PDF generated successfully', ['waybills' => $waybillsToSend]);

                    try {Mail::html('Voir pièce jointe.', function ($message) use ($pdf) {
                        // Log values for debugging
                        
                        // $message->to('danybergeron@courriersubitopresto.com')
                        //     ->bcc('widmaertelisma@gmail.com')
                            $message->to('ali2015333061@gmail.com')
                                ->bcc('widmaertelisma@gmail.com')
                            ->subject('Fin de journée du chauffeur 