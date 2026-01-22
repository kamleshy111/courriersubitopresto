<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Carbon\Carbon;
use App\Models\Waybill;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class DriverController extends Controller
{

    public function index()
    {
        return view('admin.drivers.index');
    }

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
        ->where('delivery_status', 3)  // Example where clause
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
}
