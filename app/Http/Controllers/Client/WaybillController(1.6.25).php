<?php



namespace App\Http\Controllers\Client;



use App\Http\Controllers\Controller;

use App\Models\Status;

use App\Models\Waybill;

use Illuminate\Http\Request;

use Carbon\Carbon;



class WaybillController extends Controller

{

    public function clientDataTable(Request $request)

    {

        if($request->query('waybill-type') == "true"){

            $type = 0;

        }else{

            $type = 1;

        }

        $result = Waybill::with('recipient','user.client')

            ->where('user_id', \Auth::id())

            ->where('type', $type)

            ->orderByDesc('date');

        return datatables( $result)

            ->editColumn('date', function($row)

            {

                if($row->date != null){

                    return Carbon::parse($row->date)->toFormattedDateString();

                }

            })

            ->editColumn('status', function($row)

            {

                if($row->status == 'night')

                {

                    return __('waybills.status.night');

                }

                elseif ($row->status == 'code_red')

                {

                    return __('waybills.status.code_red');

                }

                elseif ($row->status == 'very_urgent')

                {

                    return __('waybills.status.very_urgent');

                }

                elseif ($row->status == 'urgent')

                {

                    return __('waybills.status.urgent');

                }

                elseif ($row->status == 'same_day')

                {

                    return __('waybills.status.same_day');

                }

                elseif ($row->status == 'tomorrow')

                {

                    return __('waybills.status.tomorrow');

                }

                else{

                    return '';

                }

            })

            ->editColumn('delivery_status', function($row)

            {

                if($row->delivery_status == 2)

                {

                    return '<span class="badge badge-pill" style="width: 6rem; padding: 8px 0; background-color: #808080; color: #ffffff;">Livraison ramassé</span>';

                }

                elseif($row->delivery_status == 3)

                {

                    return '<span class="badge badge-pill" style="width: 6rem; padding: 8px 0; background-color: #808080; color: #ffffff;">Livraison en cours</span>';

                }

                elseif($row->delivery_status == 1)

                {

                    return '<span class="badge badge-pill" style="width: 6rem; padding: 8px 0; background-color: #808080; color: #ffffff;">Livraison terminé</span>';

                }

                return '';

            })

            ->editColumn('soft_id', function ($row){

                if($row->user->client != null){

                    return $row->user->client->prefix . str_pad($row->soft_id, 6, 0, STR_PAD_LEFT);

                }

            })

            ->editColumn('action', function ($row) use($request) {

                $button  = '<div class="btn-group" role="group">';

                if($request->query('waybill-type') && $request->query('waybill-type') == "true"){

                    $button .= '<a class="btn btn-sm btn-primary" style="background-color:#FF5733;" target="_blank" href="' . url('admin/waybills/' . $row->id . '?waybill=' . \request()->query('waybill-type')) . '"><i class="fas fa-file-pdf"></i> Bordereau</a>';

                }

                if($request->query('waybill-type') && $request->query('waybill-type') == "true"){

                    $button .= '<a class="btn btn-sm btn-primary"  target="_blank" href="' . url('admin/waybill/' . $row->id) . '"><i class="fas fa-eye"></i> Voir Waybill</a>';

                }



                if($request->query('waybill-type') && $request->query('waybill-type') == "false"){

                    $button .= '<a class="btn btn-sm btn-primary" style="background-color:#FF5733;" target="_blank" href="' . url('admin/waybills/' . $row->id . '?waybill=' . \request()->query('waybill-type')) . '"><i class="fas fa-file-pdf"></i> soumissions</a>';

                }



                if ($row->price != null && $row->type == 1 && $row->submission_status == null) {

                    $button .= '<a class="btn btn-sm btn-success btn-approve" style="background-color:#37BC9B;" data-waybill-id="' . $row->id . '"><i class="fas fa-check"></i> Approuver</a>';

                }

                if($row->price != null && $row->type == 1 && $row->submission_status !== 0)

                {

                    $button .= '<a class="btn btn-sm btn-danger btn-reject" style="background-color:#FF5733;"  data-waybill-id="' . $row->id . '"><i class="fas fa-times"></i> Rejeter</a>';

                }

                if($row->price != null && $row->type == 1 && $row->submission_status == 0)

                {

                    $button .= '<a class="btn btn-sm btn-danger btn-delete-submission" style="background-color:#FF5733;"  data-waybill-id="' . $row->id . '"><i class="fas fa-trash"></i> Supprimer</a>';

                }

                $button .= '</div>';

                return $button;

            })



            ->rawColumns(['date','soft_id','delivery_status','total','action'])

            ->toJson();

    }



   public function adminDataTable(Request $request)

{

    // Fetch all waybills from the database, ordered by 'date' in descending order



    // $waybills = Waybill::orderByDesc('id');



    // Process data for DataTables

    // return datatables($waybills)

    if($request->query('waybill-type') == "true")

        {

            $type = 0;

        }else{

             $type = 1;

        }



    // old starts

    /*$waybills = Waybill::with('recipient', 'user.client')

            ->where('type', $type)

            ->orderByDesc('id');*/

            // old ends



            // new modified



            $waybills = Waybill::with('recipient','shipper')

            ->where('type', $type)

            ->orderByDesc('id');



            // ->get();

            /*if($request->client_id)

            {

                $waybills->where('recipient_id', $request->client_id);

            }*/



    // Process data for DataTables

    return datatables($waybills)

        ->editColumn('date', function ($row) {

            // Format the date column

            return $row->date ? Carbon::parse($row->date)->toFormattedDateString() : null;

        })

        ->editColumn('delivery_status', function ($row) {

            // Render delivery status badge

            $style = 'width: 6rem; padding: 8px 0; background-color: #808080; color: #ffffff;';

            switch ($row->delivery_status) {

                case 1:

                    return '<span class="badge badge-pill" style="' . $style . '">Livraison terminé</span>';

                case 2:

                    return '<span class="badge badge-pill" style="' . $style . '">Livraison ramassé</span>';

                case 3:

                    return '<span class="badge badge-pill" style="' . $style . '">Livraison en cours</span>';

                default:

                    return '';

            }

        })

        // new modified

        ->editColumn('soft_id', function ($row){

            if ($row->shipper) {

                // Generate the soft ID with the shipper's prefix

                return $row->shipper->prefix . str_pad($row->soft_id, 6, '0', STR_PAD_LEFT);

            }



            // If no shipper is associated, return the padded soft_id alone

            return str_pad($row->soft_id, 6, '0', STR_PAD_LEFT);

        })

        ->editColumn('status', function ($row) {

            // Render status badge

            $status = Status::find($row->status_id);

            if ($status) {

                return '<span class="badge badge-pill" style="width: 6rem; padding: 8px 0; background-color: ' . $status->color . '; color: #ffffff;">' . $status->name . '</span>';

            }

            return '';

        })

        /*->editColumn('action', function ($row) {

            // Generate action buttons

            $editUrl = url('admin/waybills/' . $row->id . '/edit');

            $viewUrl = url('admin/waybills/' . $row->id);

            $deleteButton = '<a class="btn btn-sm btn-danger btn-admin-delete-submission" title="Supprimer" style="width: 2rem; padding: 8px 0; margin-right: 3px; margin-left: 3px;" data-waybill-id="' . $row->id . '"><i class="fa fa-trash"></i></a>';

            // <button class="btn-approve" data-id="{{ $waybill->id }}">Approve</button>

            // <button class="btn-reject" data-id="{{ $waybill->id }}">Reject</button>

            $button = '<button class="btn btn-sm btn-success btn-approve-waybill" data-id="{{ $waybill->id }}">Approve</button>';

            $button = '<button class="btn btn-sm btn-danger btn-reject-waybill" data-id="{{ $waybill->id }}">Reject</button>';

            return '<div class="row">

                <div class="col-md-12 col-sm-6">

                    <a class="btn btn-sm btn-info" title="modifier" style="width: 2rem; padding: 8px 0; background-color:#054AFA;" href="' . $editUrl . '"><i class="fa fa-edit"></i></a>

                    <a class="btn btn-sm btn-info" title="voir la feuille de route" style="width: 2rem; padding: 8px 0; margin-right: 3px; margin-left: 3px;" href="' . $viewUrl . '"><i class="fa fa-eye"></i></a>

                    ' . $deleteButton . '

                </div>

            </div>';

        })*/



        ->editColumn('action', function ($row) {

            $button = '<div class="row">';

            $button .= '<div class="col-md-12 col-sm-6">';

            $button .= '<a class="btn btn-sm btn-info" title="modifier" style="width: 2rem; padding: 8px 0; background-color:#054AFA;" href="' . url('admin/waybills/' . $row->id . '/edit?waybill=' . request()->query('waybill-type')) . '"><i class="fa fa-edit"></i></a>';

            $button .= '<a class="btn btn-sm btn-info" title="voir la feuille de route" style="width: 2rem; padding: 8px 0; margin-right: 3px; margin-left: 3px;" href="' . url('admin/waybills/' . $row->id . '?waybill=' . request()->query('waybill-type')) . '"><i class="fa fa-eye"></i></a>';

            // $button .= '<button class="btn btn-sm btn-success btn-approve-waybill" data-id="' . $row->id . '">Approve</button>';

            // $button .= '<button class="btn btn-sm btn-danger btn-reject-waybill" data-id="' . $row->id . '">Reject</button>';

            // $button .= '<button class="btn btn-sm btn-danger reject-waybill data-id="' . $row->id . '">Reject</button>';

            $button .= '<button class="btn btn-sm btn-success approve-waybill" data-status="1" data-id="' . $row->id . '" title="Approve">';

    $button .= '<i class="fa fa-check"></i>'; // Tick icon

    $button .= '</button>';

    $button .= '<button class="btn btn-sm btn-danger reject-waybill" data-status="0" data-id="' . $row->id . '" title="Reject" style="margin-left: 5px;">';

    $button .= '<i class="fa fa-times"></i>'; // Cross icon

    $button .= '</button>';

            if ($row->type == 1) {

                $button .= '<a class="btn btn-sm btn-danger btn-admin-delete-submission" title="Supprimer" style="width: 2rem; padding: 8px 0; margin-right: 3px; margin-left: 3px;" data-waybill-id="' . $row->id . '"><i class="fa fa-trash"></i></a>';

            }

            $button .= '</div></div>';

            return $button;

        })

        ->rawColumns(['date','soft_id', 'status', 'delivery_status', 'action']) // Declare raw HTML columns

        ->toJson(); // Return JSON for DataTables

}





    public function adminArchivedSubmissionDataTable(Request $request)

    {

        if($request->query('archive') == "true")

        {

            $currentDate = Carbon::today();

            $waybills = Waybill::with('recipient', 'user.client')

                ->whereIn('submission_status', [0,1])

                ->orderByDesc('date');





            if($request->date_type == 1)

            {

                $waybills->whereDate('created_at', '=', $currentDate);

            }



            if($request->date_type == 2)

            {

                $waybills->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(),

                    Carbon::now()->subWeek()->endOfWeek()

                ]);

            }

            if($request->client_id)

            {

                $waybills->where('recipient_id', $request->client_id);

            }





            return datatables( $waybills)

                ->editColumn('date', function($row)

                {

                    if($row->date != null){

                        return Carbon::parse($row->date)->toFormattedDateString();

                    }

                })

                ->editColumn('delivery_status', function($row)

                {

                    if($row->delivery_status == 1)

                    {

                        return '<span class="badge badge-pill" style="width: 6rem; padding: 8px 0; background-color: #808080; color: #ffffff;">ramassée</span>';

                    }

                    elseif($row->delivery_status == 2)

                    {

                        return '<span class="badge badge-pill" style="width: 6rem; padding: 8px 0; background-color: #808080; color: #ffffff;">en cours</span>';

                    }

                    elseif($row->delivery_status == 3)

                    {

                        return '<span class="badge badge-pill" style="width: 6rem; padding: 8px 0; background-color: #808080; color: #ffffff;">livraison</span>';

                    }

                    return '';

                })

                ->editColumn('soft_id', function ($row){

                    if($row->user->client != null){

                        return $row->user->client->prefix . str_pad($row->soft_id, 6, 0, STR_PAD_LEFT);

                    }

                })

                ->editColumn('status', function($row)

                {

                    $status = Status::where('id', $row->status_id)->first();

                    if($status)

                    {

                        return '<span class="badge badge-pill" style="width: 6rem; padding: 8px 0; background-color: '.$status->color.'; color: #ffffff;">'.$status->name.'</span>';

                    }

                })

                ->editColumn('action', function($row)

                {

                    $button  = '<div class="row">';

                    $button .= '<div class="col-md-12 col-sm-6">';

                    $button .= '<a class="btn btn-sm btn-info" title="voir la feuille de route" style="width: 2rem; padding: 8px 0; margin-right: 3px; margin-left: 3px;" href="' . url('admin/waybills/' .$row->id . '?waybill=true') . '"><i class="fa fa-eye"></i></a>';

                    $button .= '</div></div>';

                    return $button;

                })

                ->rawColumns(['soft_id','date','status','delivery_status','total','action'])

                ->toJson();

        }

    }



    public function clientArchivedSubmissionDataTable(Request $request)

    {

        if($request->query('archive') == "true")

        {

            $result = Waybill::with('recipient','user.client')

                ->where('user_id', \Auth::id())

                ->whereIn('submission_status', [0,1])

                ->orderByDesc('date');





            return datatables( $result)

                ->editColumn('date', function($row)

                {

                    if($row->date != null){

                        return Carbon::parse($row->date)->toFormattedDateString();

                    }

                })

                ->editColumn('status', function($row)

                {

                    if($row->status == 'night')

                    {

                        return __('waybills.status.night');

                    }

                    elseif ($row->status == 'code_red')

                    {

                        return __('waybills.status.code_red');

                    }

                    elseif ($row->status == 'very_urgent')

                    {

                        return __('waybills.status.very_urgent');

                    }

                    elseif ($row->status == 'urgent')

                    {

                        return __('waybills.status.urgent');

                    }

                    elseif ($row->status == 'same_day')

                    {

                        return __('waybills.status.same_day');

                    }

                    elseif ($row->status == 'tomorrow')

                    {

                        return __('waybills.status.tomorrow');

                    }

                    else{

                        return '';

                    }

                })

                ->editColumn('delivery_status', function($row)

                {

                    if($row->delivery_status == 1)

                    {

                        return '<span class="badge badge-pill" style="width: 6rem; padding: 8px 0; background-color: #808080; color: #ffffff;">ramassée</span>';

                    }

                    elseif($row->delivery_status == 2)

                    {

                        return '<span class="badge badge-pill" style="width: 6rem; padding: 8px 0; background-color: #808080; color: #ffffff;">en cours</span>';

                    }

                    elseif($row->delivery_status == 3)

                    {

                        return '<span class="badge badge-pill" style="width: 6rem; padding: 8px 0; background-color: #808080; color: #ffffff;">livraison</span>';

                    }

                    return '';

                })

                ->editColumn('soft_id', function ($row){

                    if($row->user->client != null){

                        return $row->user->client->prefix . str_pad($row->soft_id, 6, 0, STR_PAD_LEFT);

                    }

                })

                ->editColumn('action', function ($row) use($request) {

                    $button  = '<div class="btn-group" role="group">';



                    $button .= '<a class="btn btn-sm btn-primary" style="background-color:#FF5733;" target="_blank" href="' . url('admin/waybills/' . $row->id . '?waybill=true') . '"><i class="fas fa-file-pdf"></i> soumissions</a>';



                    $button .= '</div>';

                    return $button;

                })



                ->rawColumns(['date','soft_id','delivery_status','total','action'])

                ->toJson();

        }

    }

    public function clientDeliveryInprogress()
    {



        $waybills = Waybill::with('recipient', 'shipper') // Eager load the related shipper (Client) data
        ->where('user_id', \Auth::id())
        ->where(function($query) {
            $query->where('delivery_status', 3);  // delivery_status == 3
                //   ->orWhereNull('delivery_status');  // OR delivery_status is NULL
        })
        // ->where('driver_id', $userId)  // Example where clause
        ->orderBy('id', 'DESC')
        ->get();

        return view('admin.clients.deliveryStatus', compact('waybills'));
    }

    public function clientDeliveryPickedup()
    {



        $waybills = Waybill::with('recipient', 'shipper') // Eager load the related shipper (Client) data
        ->where('user_id', \Auth::id())
        ->where(function($query) {
            $query->where('delivery_status', 2);  // delivery_status == 3
        })
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.clients.deliveryStatus', compact('waybills'));
    }

    public function clientDeliveryCompleted()
    {



        $waybills = Waybill::with('recipient', 'shipper') // Eager load the related shipper (Client) data
        ->where('user_id', \Auth::id())
        ->where(function($query) {
            $query->where('delivery_status', 1);  // delivery_status == 3
        })
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.clients.deliveryStatus', compact('waybills'));
    }

}

