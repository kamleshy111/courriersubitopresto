<?php

namespace App\Http\Controllers\DataTables\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientController extends Controller
{

    public function index()
    {
        $result = Client::query()
            ->where('user_id', \Auth::id())
            ->orderByDesc('id');

        return datatables($result)
            ->editColumn('action', function($row)
            {
                $button  = '<div class="row">';
                $button .= '<div class="col-md-12 col-sm-6">';
                $button .= '<a class="btn btn-sm btn-secondary" style="margin-right:3px; margin-bottom:2px;" href="' . url('admin/clients/' .$row->id . '/edit') . '"><i class="fa fa-edit"></i></a>';
                $button .= '<a class="btn btn-sm btn-info" href="' . url('admin/clients/' .$row->id) . '"><i class="fa fa-eye"></i></a>';
                $button .= '<button class="btn btn-sm btn-danger user-delete-client" data-client_id="'.$row->id.'"><i class="fa fa-trash"></i></button>';

                $button .= '</div></div>';
                return $button;
            })
            ->editColumn('note_permanent', function ($row){
                if($row->note_permanent != null){
                    return Str::limit($row->note_permanent, 20, '...');
                }
                return '';
            })
            ->rawColumns(['action','note_permanent'])
            ->toJson();
    }
}
