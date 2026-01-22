<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Carbon\Carbon;
use App\Models\Waybill;
use Illuminate\Http\Request;

class DriverController extends Controller
{

    public function index()
    {
        return view('admin.drivers.index');
    }

    public function driverWaybill(){
        
        // $waybills = Waybill::where('driver_id', 6) //old one
        $waybills = Waybill::with('recipient', 'shipper')
        ->where('driver_id', 6)
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.drivers.waybill', compact('waybills'));
    }
     public function driverWaybillList(){
        $waybillings = Waybill::where('driver_id', 6)
        ->orderBy('id', 'DESC')
        ->get();

    // Return view with waybills data
    return view('admin.drivers.list', compact('waybillings'));
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
