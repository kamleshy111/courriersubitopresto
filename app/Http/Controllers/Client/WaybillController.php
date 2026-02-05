<?php



namespace App\Http\Controllers\Client;



use App\Http\Controllers\Controller;

use App\Models\Status;

use App\Models\Waybill;
use App\Models\Client;
use Illuminate\Support\Facades\Mail;
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

            ->when($type == 1, function ($query) {
    $query->where(function ($q) {
        $q->where('submission_status', '!=', 3)
          ->orWhereNull('submission_status');
    });
})


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

                    $button .= '<a class="btn btn-sm btn-primary" style="background-color:#FF7404;" target="_blank" href="' . url('admin/waybills/' . $row->id . '?waybill=' . \request()->query('waybill-type')) . '"><i class="fas fa-file-pdf"></i> soumissions</a>';
                    // $button .= '<a class="btn btn-sm btn-primary prix" data-id="' . $row->id . '" style="background-color:#FFD700; color: black;" ><i class="fas fa-dollar-sign"></i> discuter du prix</a>';


                }



                if ($row->price != null && $row->type == 1 && $row->submission_status == null) {

                    $button .= '<a class="btn btn-sm btn-success btn-approve" style="background-color:#37BC9B;" data-waybill-id="' . $row->id . '"><i class="fas fa-check"></i> Approuver</a>';

                }

                if($row->price != null && $row->type == 1 && $row->submission_status !== 0)
                {

                    $button .= '<a class="btn btn-sm btn-primary prix" data-id="' . $row->id . '" style="background-color:#FFD700; color: black;" ><i class="fas fa-dollar-sign"></i> discuter du prix</a>';

                }


                if($row->price != null && $row->type == 1 && $row->submission_status !== 0)

                {

                    $button .= '<a class="btn btn-sm btn-danger btn-reject" style="background-color:#d72e0a;"  data-waybill-id="' . $row->id . '"><i class="fas fa-times"></i> Supprimer </a>';

                }


                /*if($row->price != null && $row->type == 1 && $row->submission_status == 0)

                {

                    $button .= '<a class="btn btn-sm btn-danger btn-delete-submission" style="background-color:#FF5733;"  data-waybill-id="' . $row->id . '"><i class="fas fa-trash"></i> Supprimer</a>';

                }*/

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
                ->withoutTrashed();

            // Filter by date type (1 = today, 2 = this week)
            if ($request->filled('date_type')) {
                if ($request->date_type == 1) {
                    $waybills->whereDate('date', Carbon::today());
                }
                if ($request->date_type == 2) {
                    $waybills->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                }
            }

            // Filter by client (recipient)
            if ($request->filled('client_id')) {
                $waybills->where('recipient_id', $request->client_id);
            }

            // Filter by slip number (formatted: prefix + padded soft_id, from user->client)
            $waybillNumber = trim((string) $request->waybill_number);
            if ($waybillNumber !== '') {
                $waybills->whereExists(function ($q) use ($waybillNumber) {
                    $q->select(\DB::raw(1))
                        ->from('users')
                        ->join('clients', 'users.client_id', '=', 'clients.id')
                        ->whereColumn('users.id', 'waybills.user_id')
                        ->whereRaw("CONCAT(clients.prefix, LPAD(waybills.soft_id, 6, '0')) LIKE ?", ['%' . $waybillNumber . '%']);
                });
            }

    // Process data for DataTables

    return datatables($waybills)
        ->orderColumn('soft_id', 'waybills.soft_id $1')
        ->orderColumn('recipient.name', 'clients.name $1')
        ->orderColumn('recipient.address', 'clients.address $1')
        ->orderColumn('delivery_status', 'waybills.delivery_status $1')
        ->orderColumn('date', 'waybills.date $1')
        ->orderColumn('updated_at', 'waybills.updated_at $1')
        ->editColumn('date', function ($row) {

            // Format the date column

            return $row->date ? Carbon::parse($row->date)->toFormattedDateString() : null;

        })
        // ->editColumn('created_at', function ($row) {

        //     // Same format as "date" column (e.g. Jan 22, 2026)

        //     return $row->created_at ? Carbon::parse($row->created_at)->toFormattedDateString() : null;

        // })
        ->editColumn('updated_at', function ($row) {

            return $row->updated_at ? Carbon::parse($row->updated_at)->toFormattedDateString() : null;

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

        /*->editColumn('soft_id', function ($row){

            if ($row->shipper) {

                // Generate the soft ID with the shipper's prefix

                return $row->shipper->prefix . str_pad($row->soft_id, 6, '0', STR_PAD_LEFT);

            }



            // If no shipper is associated, return the padded soft_id alone

            return str_pad($row->soft_id, 6, '0', STR_PAD_LEFT);

        })*/

        // ->editColumn('soft_id', function ($row) {
        //     return $row->user->client
        //         ? $row->user->client->prefix . str_pad($row->soft_id, 6, '0', STR_PAD_LEFT)
        //         : '';
        // })

                ->editColumn('soft_id', function ($row) {
            if ($row->user && $row->user->client) {
                return $row->user->client->prefix . str_pad($row->soft_id, 6, '0', STR_PAD_LEFT);
            }

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

            $button .= '<a class="btn btn-sm btn-info waybill-edit" title="modifier" style="width: 2rem; background-color:#054AFA;" href="' . url('admin/waybills/' . $row->id . '/edit?waybill=' . request()->query('waybill-type')) . '"><i class="fa fa-edit"></i></a>';

            $button .= '<a class="btn btn-sm btn-info view-waybill-btn" title="voir la feuille de route" style="width: 2rem; margin-left: 3px;" href="' . url('admin/waybills/' . $row->id . '?waybill=' . request()->query('waybill-type')) . '"><i class="fa fa-eye"></i></a>';

            // $button .= '<button class="btn btn-sm btn-success btn-approve-waybill" data-id="' . $row->id . '">Approve</button>';

            // $button .= '<button class="btn btn-sm btn-danger btn-reject-waybill" data-id="' . $row->id . '">Reject</button>';

            // $button .= '<button class="btn btn-sm btn-danger reject-waybill data-id="' . $row->id . '">Reject</button>';

            $button .= '<button class="btn btn-sm btn-success approve-waybill" data-status="1" data-id="' . $row->id . '" title="Approve" style="width: 2rem; margin-left: 3px;">';
            // $button .= '<a class="btn btn-sm btn-info view-waybill-btn" title="voir la feuille de route" style="width: 2rem; padding: 8px 0; margin-right: 3px; margin-left: 3px;" href="' . url('admin/waybills/' . $row->id . '?waybill=' . request()->query('waybill-type')) . '"><i class="fa fa-eye"></i></a>';
            // $button .= '<a class="btn btn-sm btn-primary" style="background-color:#FFD700; color: black;" ><i class="fas fa-euro-sign"></i> prix</a>';


    $button .= '<i class="fa fa-check"></i>'; // Tick icon

    $button .= '</button>';

    $button .= '<button class="btn btn-sm btn-danger reject-waybill" data-status="0" data-id="' . $row->id . '" title="Reject" style="width: 2rem; margin-left: 3px;">';

    $button .= '<i class="fa fa-times"></i>'; // Cross icon

    $button .= '</button>';
    if ($row->type != 1) {
        // Soft delete (corbeille) — for all waybills/submissions
        $button .= '<button type="button" class="btn btn-sm btn-warning btn-soft-delete-waybill" title="Supprimer" style="min-width: 2rem; margin-left: 3px;" data-waybill-id="' . $row->id . '"><i class="fa fa-trash"></i></button>';
    }
    $button .= '<a class="btn btn-sm btn-primary wabill-pageview"  target="_blank" title="Voir waybill" href="' . url('admin/waybill/' . $row->id) . '" style="margin-left: 3px;"><i class="fas fa-file-alt"></i></a>';

    $button .= '<button type="button" class="btn btn-sm btn-secondary btn-view-box-waybill" title="voir l`étiquette" style="min-width: 2rem; margin-left: 3px;" data-waybill-id="' . $row->id . '"><i class="fa fa-print"></i></button>';

            if ($row->type == 1) {

                $button .= '<a class="btn btn-sm btn-danger btn-admin-delete-submission" title="Supprimer" style="width: 2rem; margin-left: 3px;" data-waybill-id="' . $row->id . '"><i class="fa fa-trash"></i></a>';
                // $button .= '<a class="btn btn-sm btn-primary prix" data-id="' . $row->id . '" style="background-color:#FFD700; color: black;" ><i class="fas fa-dollar-sign"></i> prix</a>';

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
                // ->where('submission_status', [0,1])

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

            // Filter by slip number (formatted: prefix + padded soft_id)
            $waybillNumber = trim((string) $request->waybill_number);
            if ($waybillNumber !== '') {
                $waybills->whereExists(function ($q) use ($waybillNumber) {
                    $q->select(\DB::raw(1))
                        ->from('users')
                        ->join('clients', 'users.client_id', '=', 'clients.id')
                        ->whereColumn('users.id', 'waybills.user_id')
                        ->whereRaw("CONCAT(clients.prefix, LPAD(waybills.soft_id, 6, '0')) LIKE ?", ['%' . $waybillNumber . '%']);
                });
            }

            return datatables( $waybills)

                ->editColumn('date', function($row)

                {

                    if($row->date != null){

                        return Carbon::parse($row->date)->toFormattedDateString();

                    }

                })

                ->editColumn('created_at', function($row)

                {

                    if($row->created_at != null){

                        return Carbon::parse($row->created_at)->toFormattedDateString();

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

                    $button .= '<a class="btn btn-sm btn-info" title="voir la feuille de route" style="width: 2rem; padding: 8px 0; margin-right: 3px; margin-left: 3px;" href="' . url('admin/waybills/' .$row->id . '?waybill=true&archive=true') . '"><i class="fa fa-eye"></i></a>';

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

                // ->whereIn('submission_status', [0,1])
                // old working good
                // ->where('submission_status', 3)
                ->where('submission_status', 1)

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



                    $button .= '<a class="btn btn-sm btn-primary" style="background-color:#FF5733;" target="_blank" href="' . url('admin/waybills/' . $row->id . '?waybill=true&archive=true') . '"><i class="fas fa-file-pdf"></i> soumissions</a>';



                    $button .= '</div>';

                    return $button;

                })


                 ->setRowClass(function ($row) {
                return $row->submission_status == 3 ? 'row-red' : '';
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
        // ->where(function($query) {
        //     $query->where('delivery_status', 2);  // delivery_status == 3
        // })
        ->where('delivery_status', 2)
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.clients.deliveryStatus', compact('waybills'));
    }

        public function clientDeliveryCompleted(Request $request)
    {
        $date = $request->query('date', now()->format('Y-m-d'));
        $waybills = Waybill::with('recipient', 'shipper') // Eager load the related shipper (Client) data
        ->where('user_id', \Auth::id())
        ->where(function($query) {
            $query->where('delivery_status', 1);  // delivery_status == 3
        })
         ->whereDate('drop_time', $date)
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.clients.deliveryStatus', compact('waybills','date'));
    }

    public function clientWaybillsByDate(Request $request)
{
    $date = $request->query('date', now()->format('Y-m-d'));

    $waybills = Waybill::with(['recipient', 'shipper'])
        // ->where('user_id', auth()->id())
        ->where('user_id', \Auth::id())
        // ->where('delivery_status', 1)
        ->where(function($query) {
            $query->where('delivery_status', 1);  // delivery_status == 3
        })
        ->whereDate('drop_time', $date)
        ->orderBy('id', 'DESC')
        ->get();

    return response()->json([
        'waybills' => $waybills->map(function ($wb) {
            return [
                'id' => $wb->id,
                'shipper_name' => $wb->shipper->name ?? 'N/A',
                'shipper_address' => $wb->shipper->address ?? 'N/A',
                'recipient_name' => $wb->recipient->name ?? 'N/A',
                'recipient_address' => $wb->recipient->address ?? 'N/A',
            ];
        })
    ]);
}

// new waybill id(dynamic) filter

public function clientByWaybillID(Request $request)
{
    // $date = $request->query('date', now()->format('Y-m-d'));
    $soft_id = $request->input('id');

    $waybills = Waybill::with(['recipient', 'shipper'])
        ->where('user_id', \Auth::id())
        ->where('soft_id',$soft_id)
        ->get();

    return response()->json([
        'waybills' => $waybills->map(function ($wb) {
            return [
                'id' => $wb->id,
                'shipper_name' => $wb->shipper->name ?? 'N/A',
                'shipper_address' => $wb->shipper->address ?? 'N/A',
                'recipient_name' => $wb->recipient->name ?? 'N/A',
                'recipient_address' => $wb->recipient->address ?? 'N/A',
            ];
        })
    ]);
}


// client name dropdown menu

public function clientNameSearch(Request $request)
{
    $query = $request->get('q', '');

    if (strlen($query) < 3) {
        return response()->json([]);
    }

    $clients = Client::where('user_id', auth()->id()) // filter by current user
        ->where('name', 'like', '%' . $query . '%')   // match by name
        ->limit(10)
        ->get(['id', 'name']);

    return response()->json($clients);
}

// new name filter

public function clientWaybillsByName(Request $request)
{
    $name = $request->query('name');

    $query = Waybill::with(['recipient', 'shipper'])
        ->where('user_id', \Auth::id())
        ->where(function($q) {
            $q->where('delivery_status', 1);
        });

    if ($name) {
        $query->where(function ($q) use ($name) {
            $q->whereHas('shipper', function ($sq) use ($name) {
                $sq->where('name', 'like', '%' . $name . '%');
            })->orWhereHas('recipient', function ($rq) use ($name) {
                $rq->where('name', 'like', '%' . $name . '%');
            });
        });
    }

    $waybills = $query->orderBy('id', 'DESC')->get();

    return response()->json([
        'waybills' => $waybills->map(function ($wb) {
            return [
                'id' => $wb->id,
                'shipper_name' => $wb->shipper->name ?? 'N/A',
                'shipper_address' => $wb->shipper->address ?? 'N/A',
                'recipient_name' => $wb->recipient->name ?? 'N/A',
                'recipient_address' => $wb->recipient->address ?? 'N/A',
            ];
        })
    ]);
}

public function disputeEmail(Request $request){

    $id = $request->input('id');
    $submissionUrl = url("/admin/waybills/{$id}?waybill=false");

    try {
        Mail::send([], [], function ($message) use ($submissionUrl) {
            $message->to('danybergeron@courriersubitopresto.com')
                    ->bcc('ali2015333061@gmail.com')
                    ->subject('Demande de discussion sur le prix')
                    ->setBody(
                        "<p>J’aimerais disputer du prix.</p>
                         <p>Consultez la soumission ici :
                         <a href=\"{$submissionUrl}\">{$submissionUrl}</a></p>",
                        'text/html'
                    );
        });

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        \Log::error('Email sending failed', ['error' => $e->getMessage()]);
        return response()->json(['success' => false], 500);
    }
}

// public function store_pdf(Request $request, $clientId)
// {

//      Log::info('Test log: store_pdf method called');
//     Log::info('PDF File called: ');  // Log the relative path
//     // find client (route model binding not used here)
//     $client = Client::findOrFail($clientId);

public function store_pdf(Request $request)
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

public function delete_pdf(Request $request, $clientId)
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


}

