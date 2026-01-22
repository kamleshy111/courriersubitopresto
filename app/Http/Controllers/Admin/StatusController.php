<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{

    public function index()
    {
        return view('admin.statuses.index');
    }


    public function indexDataTable()
    {
        $result = Status::query()
            ->orderBy('id', 'DESC')
            ->get();

        return datatables($result)
            ->editColumn('color', function ($row){
                $button  = '<div class="row">';
                $button .= '<div class="col-md-12 col-sm-6">';
                $button .= '<button class="btn btn-sm" style="width: 3rem; padding: 8px 0; background-color:'.$row->color.';" ></button>';
                $button .= '</div></div>';
                return $button;
            })
            ->editColumn('action', function($row)
            {
                $button  = '<div class="row">';
                $button .= '<div class="col-md-12 col-sm-6">';
                $button .= '<a class="btn btn-sm btn-info" title="modifier" style="width: 3rem; padding: 8px 0; background-color:#054AFA;" href="' . url('admin/statuses/' .$row->id . '/edit') . '"><i class="fa fa-edit"></i></a>';
                $button .= '</div></div>';
                return $button;
            })
            ->rawColumns(['color','action'])
            ->toJson();
    }

    public function create()
    {
        return view('admin.statuses.create');
    }


    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'name'    => 'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Status::create([
            'name'     => $request->name,
            'color'    => $request->color
        ]);
        return redirect('admin/statuses');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $status = Status::findOrFail($id);
        return view('admin.statuses.edit', compact('status'));
    }


    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(),[
           'name'     => 'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Status::where('id', $id)
            ->update([
               'name'   => $request->name,
                'color'  => $request->color
            ]);
        return redirect('admin/statuses');
    }


    public function destroy($id)
    {
        //
    }
}
