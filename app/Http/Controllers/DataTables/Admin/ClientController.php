<?php

namespace App\Http\Controllers\DataTables\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    /**
     * All clients as address book (same columns as client-side). Used when admin views Carnet d'adresse.
     */
    public function addressIndex()
    {
        $result = Client::query()
            ->orderByDesc('id');

        return datatables($result)
            ->editColumn('action', function ($row) {
                $button  = '<div class="row">';
                $button .= '<div class="col-md-12 col-sm-6">';
                $button .= '<a class="btn btn-sm btn-secondary" style="margin-right:3px; margin-bottom:2px;" href="' . url('admin/clients/' . $row->id . '/edit') . '"><i class="fa fa-edit"></i></a>';
                $button .= '<a class="btn btn-sm btn-info" href="' . url('admin/clients/' . $row->id) . '"><i class="fa fa-eye"></i></a>';
                $button .= '<button class="btn btn-sm btn-danger user-delete-client" data-client_id="' . $row->id . '"><i class="fa fa-trash"></i></button>';
                $button .= '</div></div>';
                return $button;
            })
            ->editColumn('note_permanent', function ($row) {
                if ($row->note_permanent != null) {
                    return Str::limit($row->note_permanent, 20, '...');
                }
                return '';
            })
            ->rawColumns(['action', 'note_permanent'])
            ->toJson();
    }

    public function index()
    {
        $result = User::query()
            ->where('id', '!=', auth()->user()->id)
            ->orderByDesc('id');
            
        return datatables($result)
            ->editColumn('action', function($row)
            {

                $button  = '<div class="row">';
                $button .= '<div class="col-md-12 col-sm-6">';
                $button .= '<div class="btn-group" role="group" aria-label="Client Actions">';
                $button .= '<a class="btn btn-sm btn-secondary mr-2 mb-2" href="' . url('admin/clients/' .$row->client_id . '/edit') . '"><i class="fa fa-edit"></i></a>';
                $button .= '<a class="btn btn-sm btn-info mr-2 mb-2" href="' . url('admin/clients/' .$row->client_id) . '"><i class="fa fa-eye"></i></a>';
                $button .= '<button class="btn btn-sm btn-danger delete-user mr-2 mb-2" data-user_id="'.$row->id.'"><i class="fa fa-trash"></i></button>';

                $button .= '<a class="btn btn-sm btn-success mr-2 mb-2" href="'. url('admin/clients/' . $row->id . '/user-clients') .'" target="_blank" title="Carnet d`adresse"><i class="fas fa-user-friends"></i></a>';
                $button .= '</div>';
                $button .= '</div>';
                $button .= '</div>';

                return $button;

            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function userClientsDataTable($userId)
    {
        $result = Client::query()
            ->where('user_id', $userId)
            ->orderByDesc('id');
        return datatables($result)
            ->editColumn('note_permanent', function ($row){
                if($row->note_permanent != null){
                   return Str::limit($row->note_permanent, 20, '...');
                }
                return '';
            })
            ->editColumn('user_name', function ($row){
                if($row->user_id != null){
                    if(isset($row->user->name)){
                        return $row->user->name;
                    }
                    else{
                        return '';
                    }
                }
            })
            ->editColumn('action', function($row)
            {
                $button  = '<div class="row">';
                $button .= '<div class="col-md-12 col-sm-6">';
                $button .= '<div class="btn-group" role="group" aria-label="Client Actions">';
                $button .= '<a class="btn btn-sm btn-secondary mr-2 mb-2" href="' . url('admin/clients/' .$row->id . '/edit') . '"><i class="fa fa-edit"></i></a>';
                $button .= '<a class="btn btn-sm btn-info mr-2 mb-2" href="' . url('admin/clients/' .$row->id) . '"><i class="fa fa-eye"></i></a>';
                $button .= '<button class="btn btn-sm btn-danger delete-client-by-admin mr-2 mb-2" data-client_id="'.$row->id.'"><i class="fa fa-trash"></i></button>';
                $button .= '</div>';
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['user_name','note_permanent','action'])
            ->toJson();
    }
}
