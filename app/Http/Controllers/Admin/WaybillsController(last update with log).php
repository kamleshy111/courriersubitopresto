<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Client;
use App\Models\Dispatch;
use App\Models\Driver;
use App\Models\EmailQueue;
use App\Models\EmailWaybillQueue;
use App\Models\Status;
use App\Models\User;
use App\Models\Waybill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mail;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Log;

class WaybillsController extends CRUDController {

    public function __construct()
    {
        parent::__construct();
        if(!is_null(\request()->route()) && in_array(\Str::of(\request()
                                 ->route()
                                 ->getName())
                        ->afterLast('.'), [
                        'show',
                        'edit',
                        'destroy'
                    ])) {

            $this->middleware(function($request, $next) {
                if(\Laratrust::hasRole('admin')) {
                    return $next($request);
                }
                $waybill = Waybill::findOrFail($request->route()
                                                       ->parameter('waybill'));

                abort_if(!\Laratrust::owns($waybill), 404);
                return $next($request);
            });
        };
        $cities = City::pluck('name', 'id');
        $clients = Client::select('name', 'id')->get();
        // $drivers = Driver::pluck('full_name', 'id');// old
        $drivers = User::whereHas('roles', function ($query) {
            $query->where('id', 3);
        })->pluck('name', 'id');
        $dispatches = Dispatch::pluck('name', 'id');
        $statuses = Status::pluck('name', 'id');
        $this->inject['cities'] = $cities;
        $this->inject['drivers'] = $drivers;
        $this->inject['dispatches'] = $dispatches;
        $this->inject['statuses'] = $statuses;
        $this->inject['clients'] = $clients;
        $this->with = [
            'shipper',
            'recipient'
        ];
    }

    public function store(Request $request)
    {
        $waybillType = "true";
        $new = $request->all();
        for($i = 0; $i <= $request->input('counter', 0); $i++) {
            if($request->has($i.'.shipper.phone'))
                $new[$i]['shipper']['phone'] = preg_replace("/[^0-9]+/", "", $request->input($i.'.shipper.phone'));
            if($request->has($i.'.recipient.phone'))
                $new[$i]['recipient']['phone'] = preg_replace("/[^0-9]+/", "", $request->input($i.'.recipient.phone'));

            if($request->has($i.'.shipper.postal_code'))
                $new[$i]['shipper']['postal_code'] = strtoupper($request->input($i.'.shipper.postal_code'));
            if($request->has($i.'.recipient.postal_code'))
                $new[$i]['recipient']['postal_code'] = strtoupper($request->input($i.'.recipient.postal_code'));

            if($request->has($i.'.shipper.contact'))
                $new[$i]["shipper_contact"] = $request->input($i.'.shipper.contact');
            if($request->has($i.'.recipient.contact'))
                $new[$i]["recipient_contact"] = $request->input($i.'.recipient.contact');

            if($request->input($i.'.waybill_type') == "false"){
                $waybillType = "false";
            }
        }

        $request->replace($new);

        $validator = Validator::make($request->except(['counter']), (new $this->model())->rules);

        if ($validator->fails()) {
            return redirect( url('admin/waybills/create?waybill=' . $waybillType))
                ->withErrors($validator)
                ->withInput($request->input());
        } else {
            $waybillsToSend = [];
            $waybillsToPrint = [];
            for($i = 0; $i <= $request->get('counter', 0); $i++) {
                // store
                $model = new $this->model();
                $model->fill($request->input($i));

                if(is_null($model->shipper_id) && $request->has($i.'.shipper')) {
                    $client = Client::updateOrCreate(
                        [
                            'phone' => $request->input($i.'.shipper.phone')
                        ],
                        [
                            'name'         => $request->input($i.'.shipper.name'),
                            'phone'        => $request->input($i.'.shipper.phone'),
                            'extension'    => $request->input($i.'.shipper.extension'),
                            'address'      => $request->input($i.'.shipper.address'),
                            // 'city_id'      => $request->input($i.'.shipper.city_id'),
                            'city_name'      => $request->input($i.'.shipper.city_name'),
                            // 'state'        => $request->input($i.'.shipper.state'),
                            'city_state'        => $request->input($i.'.shipper.city_state'),
                            'postal_code'  => $request->input($i.'.shipper.postal_code'),
                            'contact'      => $request->input($i.'.shipper.contact'),
                        ]
                    );
                    $model->shipper_id = $client->id;
                }

                if(is_null($model->recipient_id) && $request->has($i.'.recipient')) {
                    $client = Client::updateOrCreate(
                        [
                            'phone' => $request->input($i.'.recipient.phone')
                        ],
                        [
                            'name'         => $request->input($i.'.recipient.name'),
                            'phone'        => $request->input($i.'.recipient.phone'),
                            'extension'    => $request->input($i.'.recipient.extension'),
                            'address'      => $request->input($i.'.recipient.address'),
                            // 'city_id'      => $request->input($i.'.recipient.city_id'),
                            'city_name'      => $request->input($i.'.recipient.city_name'),
                            // 'state'        => $request->input($i.'.recipient.state'),
                            'city_state'        => $request->input($i.'.recipient.city_state'),
                            'postal_code'  => $request->input($i.'.recipient.postal_code'),
                            'contact'      => $request->input($i.'.recipient.contact'),
                        ]
                    );
                    $model->recipient_id = $client->id;
                }

                if ($request->has($i . '.driver_id')) {
                    $model->driver_id = $request->input($i . '.driver_id');
                }


                $model->soft_id = \Auth::user()->waybills()
                        ->withTrashed()
                        ->count() + 1;

                $model->save();
                if($request->input($i.'.waybill_type') == "false"){
                    $model->update([
                        'type'   => 1
                    ]);
                    $waybillType = "false";
                }
                if(in_array($model->status, ["same_day", "tomorrow","urgent"])) {
                    $waybillsToSend[] = $model->id;
                }
                $waybillsToPrint[] = $model->id;
            }

            if(!empty($waybillsToSend)) {
                if($waybillType == "true") {
                    $pdf = $this->emailPdf(Waybill::with('user.client', 'shipper', 'recipient')->whereIn('id', $waybillsToSend)->get(), true, 1, false);
                    Log::info('PDF generated successfully', ['waybills' => $waybillsToSend]);

                    try {Mail::html('Voir pièce jointe.', function ($message) use ($pdf) {
                        // Log values for debugging
                        $toAddress = env('OWNER_EMAIL_TO_NOTIFICATION');
                        $bccAddress = env('OWNER_EMAIL_BCC_NOTIFICATION');
                        $fromAddress = env('MAIL_FROM_ADDRESS');
                        Log::info('To Address: ' . env('OWNER_EMAIL_TO_NOTIFICATION'));
                        Log::info('BCC Address: ' . env('OWNER_EMAIL_BCC_NOTIFICATION'));
                        Log::info('From Address: ' . $fromAddress);
                    
                        if (empty($toAddress) || empty($bccAddress) || empty($fromAddress)) {
                            Log::error('Invalid email address(es) detected!');
                        }
                        $message->to('danybergeron@courriersubitopresto.com')
                            ->bcc('widmaertelisma@gmail.com')
                            ->subject('Nouveau Waybill de ' . \Auth::user()->name)
                            ->attachData($pdf, 'Waybills.pdf', [
                                'mime' => 'application/pdf',
                            ]);
                    });
                    }catch (\Exception $e) {
    Log::error('Error sending email', ['error' => $e->getMessage()]);
                }
                }


                if($waybillType == "false")
                {
                    $pdf = $this->emailPdf(Waybill::with('user.client', 'shipper', 'recipient')->whereIn('id', $waybillsToSend)->get(), true, 1, false);
                    Log::info('PDF generated successfully', ['waybills' => $waybillsToSend]);

                    Mail::html('Voir pièce jointe.', function ($message) use ($pdf) {
                        $message->to(env('OWNER_EMAIL_TO_NOTIFICATION'))
                            ->bcc(env('OWNER_EMAIL_BCC_NOTIFICATION'))
                            ->subject('Nouveau soumissions de ' . \Auth::user()->name)
                            ->attachData($pdf, 'Soumissions.pdf', [
                                'mime' => 'application/pdf',
                            ]);
                    });
                }
            }

            $data = [
                'waybills' => $waybillsToPrint,
                'type' => $waybillType,
            ];
            session()->put('waybills_last_created', $data);

            $request->session()->flash('message', ['success', $i . " bordereaux ont été sauvegarder <a href='".route('admin.waybills.last_created')."' target='_blank' class='btn btn-lg btn-info'>Imprimer mes bordereaux</a>"]);
            return redirect($this->getRedirectUrl() ?? url('admin/waybills?waybill=' . $waybillType));
        }
    }

    public function update(Request $request, $id)
    {
        $new = $request->all()[0];
        unset($new['soft_id']);
        $waybillType = "true";
        $waybill = Waybill::find($id);
        if($waybill->type == 1){
            $waybillType = "false";
        }
        if($request->has('shipper.phone'))
            $new['shipper']['phone'] = preg_replace("/[^0-9]+/", "", $request->input('shipper.phone'));
        if($request->has('recipient.phone'))
            $new['recipient']['phone'] = preg_replace("/[^0-9]+/", "", $request->input('recipient.phone'));

        if($request->has('shipper.postal_code'))
            $new['shipper']['postal_code'] = strtoupper($request->input('shipper.postal_code'));
        if($request->has('recipient.postal_code'))
            $new['recipient']['postal_code'] = strtoupper($request->input('recipient.postal_code'));

        if($request->has('.shipper.contact'))
            $new["shipper_contact"] = $request->input('.shipper.contact');
        if($request->has('.recipient.contact'))
            $new["recipient_contact"] = $request->input('.recipient.contact');

            if ($request->has('driver_id')) {
                $waybill->driver_id = $request->input('driver_id');
            }

            /*if ($request->has('signature')) {

                $signatureData = $request->input('signature'); // Get the Base64 signature data

                // Decode and save the signature image
                $signatureData = explode(',', $signatureData)[1]; // Remove the base64 header
                $signaturePath = 'signatures/' . uniqid() . '.png'; // Generate a unique name for the signature

                // Save the image to the public disk
                \Storage::disk('public')->put($signaturePath, base64_decode($signatureData)); // Save it as a PNG file
                Log::info('update function upload Signature called!', [
                    'waybillId' => $signaturePath,
                    // 'signature' => explode(',', $request->signature)[1]),
                ]);
                // Update the waybill's signature field with the saved file path
                $waybill->signature = $signaturePath;
            }*/

        $request->replace($new);

        session()->flash('redirectUrl', url('admin/waybills?waybill=' . $waybillType));

        $soft = Waybill::query()
            ->where('id', $id)
            ->with('user.client')
            ->first();

        if($waybill->type == 1 && $request->input('price') != null)
        {
            $user = User::where('id', $waybill->user_id)->first();
            if($user){
//                Mail::html('Votre soumission la soumission est prête to admin', function ($message) use($id, $user) {
//                    $message->to($user->email)
//                        ->subject('Votre soumission la soumission est prête to admin');
//                });

                EmailQueue::create([
                    'email' => $user->email,
                    'subject' => 'Votre soumission est prête',
                    'content' => 'Votre soumission est prête',
                    'type'    => 1
                ]);
            }
        }

        return parent::update($request, $id);
    }

    public function show($id)
    {
        $waybill = Waybill::with('user.client', 'shipper', 'recipient')
            ->findOrFail($id);
        $type = \request()->query('waybill');
       if ($type == "false")
       {
           return $this->pdf($waybill,false,1, true);
       }
       if($type == "true")
       {
           return $this->pdf($waybill,false,3, true);
       }

       abort(403);

    }

    public function show_last_created()
    {
        if (session()->has('waybills_last_created')) {
//            $waybillsLastCreated = session()->pull('waybills_last_created', []);
            $waybillsLastCreated = session()->get('waybills_last_created', []);
            if (!is_array($waybillsLastCreated['waybills'])) {
                abort(404, 'Invalid waybill data');
            }

            if (empty($waybillsLastCreated['waybills'])) {
                abort(404, 'No waybills found');
            }

            $waybills = Waybill::with('user.client', 'shipper', 'recipient')
                ->whereIn('id', $waybillsLastCreated['waybills'])
                ->get();

            if ($waybills->isEmpty()) {
                abort(404, 'No waybills found in database');
            }

            if ($waybillsLastCreated['type'] == "false")
            {
                return $this->pdf($waybills,false,1, true);
            }
            if($waybillsLastCreated['type'] == "true")
            {
                return $this->pdf($waybills,false,3, true);
            }
        } else {
            return redirect('admin/waybills?waybill=true');
        }
    }


    public function formHelper(int $counter) {
        $cities = City::pluck('name', 'id');

        // $drivers = Driver::pluck('full_name', 'id');
        $drivers = User::whereHas('roles', function ($query) {
            $query->where('id', 3);
        })->pluck('name', 'id');
        $dispatches = Dispatch::pluck('name', 'id');
        $statuses = Status::pluck('name', 'id');
        return view('admin.waybills.form', compact('counter', 'cities','drivers','dispatches','statuses'));
    }

    public function pdf($waybills, $return = false, $copies = 3, $print = true)
    {
        if($waybills instanceof Waybill)
        {
            $waybills = collect([$waybills]);
        }

        $pdf = new Mpdf([
                            'orientation'   => 'L',
                            'margin_left'   => 15/2,
                            'margin_right'  => 15/2,
                            'margin_top'    => 16/2,
                            'margin_bottom' => 16/2,
                            'margin_header' => 9/2,
                            'margin_footer' => 9/2
                        ]);

        $pdf->SetDisplayMode('fullpage');
        $pdf->SetTitle("Waybills (".implode(',', $waybills->pluck('soft_id')->toArray()).")");
        $pdf->shrink_tables_to_fit = 1;


        $lastWaybill = count($waybills)-1;

        foreach($waybills as $k => $waybill) {

            $view = view('admin.waybills.pdf', $waybill)->renderSections(); //old
            // $view = view('admin.waybills.pdf', $waybill)->render();

            for($i = 1; $i <= $copies; $i++) {
                $pdf->SetColumns(2);

                $pdf->WriteHTML($view["col1"]);
                $pdf->AddColumn();
                $pdf->WriteHTML($view["col2"]);

                if(!($i === $copies && $lastWaybill === $k))
                    $pdf->AddPage();
            }

        }

        $pdf->WriteHTML($print);

        return $return ? $pdf->Output('', 'S') : response($pdf->Output('', 'S'))->header('Content-Type', 'application/pdf');
    }

    public function emailPdf($waybills, $return = false, $copies = 3, $print = true) {
        //echo "SIVA"; exit();
        if($waybills instanceof Waybill) {
            $waybills = collect([$waybills]);
        }

        $pdf = new Mpdf([
            'orientation'   => 'L',
            'margin_left'   => 15/2,
            'margin_right'  => 15/2,
            'margin_top'    => 16/2,
            'margin_bottom' => 16/2,
            'margin_header' => 9/2,
            'margin_footer' => 9/2
        ]);
        $pdf->SetDisplayMode('fullpage');
        $pdf->SetTitle("Waybills (".implode(',', $waybills->pluck('soft_id')->toArray()).")");
        $pdf->shrink_tables_to_fit = 1;


        $lastWaybill = count($waybills)-1;
        foreach($waybills as $k => $waybill) {
            $view = view('admin.waybills.email-pdf', $waybill)->renderSections(); //old
            // $view = view('admin.waybills.email-pdf', $waybill)->render();

            for($i = 1; $i <= $copies; $i++) {
                $pdf->SetColumns(2);

                $pdf->WriteHTML($view["col1"]);
                $pdf->AddColumn();
                $pdf->WriteHTML($view["col2"]);

                if(!($i === $copies && $lastWaybill === $k))
                    $pdf->AddPage();
            }
        }

        $pdf->WriteHTML($print);

        return $return ? $pdf->Output('', 'S') : response($pdf->Output('', 'S'))->header('Content-Type', 'application/pdf');
    }

    public function client_bulk(Client $client) {
        abort_if(!\Laratrust::hasRole('admin'), 404);

        $waybills = $client->waybills()
                           ->with('user.client','shipper', 'recipient', 'shipper.city', 'recipient.city')
                           ->where('created_at', '>=', date('Y-m-d'))
                           ->get();
        if($waybills->count() === 0) {
            return redirect()
                ->route('admin.dashboard.index')
                ->with('message', [
                    'info',
                    'Aucun waybills'
                ]);
        }
        return $this->pdf($waybills);
    }


    public function approve($id)
    {

        $waybill = Waybill::with('user.client', 'shipper', 'recipient', 'shipper.city', 'recipient.city')
            ->findOrFail($id);
        if($waybill->type == 1 && $waybill->price != null && $waybill->submission_status == 0)
        {
            $waybill->update([
                'submission_status' => 1,
                'type'             => 0
            ]);
            EmailWaybillQueue::create([
                'email_to'               => env('OWNER_EMAIL_TO_NOTIFICATION'),
                'email_bcc'              => env('OWNER_EMAIL_BCC_NOTIFICATION'),
                'subject'                => 'Le numéro de soumission  a été approuvé',
                'content'                => 'Le numéro de soumission  a été approuvé',
                'user_name'              => \Auth::user()->name,
                'pdf_type'               => 1,
                'pdf_ids'                => $id,
                'attach_data_extension'  => 'Soumissions.pdf',
            ]);
            return response()->json([
                'message' => 'La soumission a été approuvée avec succès',
                'pdf_url' => url('admin/waybills/' . $id . '?waybill=true')
            ]);
        }else{
            return response()->json(['error' => 'La soumission ne peut pas être approuvée'], 400);
        }
    }
    public function reject($id)
    {
        $waybill = Waybill::find($id);
        if($waybill->type == 1 && $waybill->price != null && $waybill->submission_status == 0)
        {
            $waybill->update([
                'submission_status' => 0,
                'type'             => 1
            ]);
            EmailQueue::create([
                'email'       => env('OWNER_EMAIL_TO_NOTIFICATION'),
                'email_bcc'   => env('OWNER_EMAIL_BCC_NOTIFICATION'),
                'subject'     => 'Le numéro de soumission  a été refusé',
                'content'     => 'Le numéro de soumission  a été refusé',
                'type'        => 3
            ]);
            return response()->json(['message' => 'Soumission rejetée avec succès']);
        }else{
            return response()->json(['error' => 'La soumission ne peut pas être rejetée'], 400);
        }
    }

    public function deleteRejectedSubmission($id)
    {
        $waybill = Waybill::find($id);
        if($waybill->type == 1 && $waybill->price != null && $waybill->submission_status == 0)
        {
            $waybill->delete();
            return response()->json(['message' => 'Soumission supprimée avec succès']);
        }else{
            return response()->json(['error' => 'La soumission ne peut pas être supprimée'], 400);
        }
    }

    public function deleteSubmissionByAdmin($id)
    {
        if(\Laratrust::hasRole('admin')) {
            $waybill = Waybill::find($id);
            if($waybill->type == 1)
            {
                $waybill->delete();
                return response()->json(['message' => 'Soumission supprimée avec succès']);
            }else{
                return response()->json(['error' => 'La soumission ne peut pas être supprimée'], 400);
            }
        }else{
            return response()->json(['error' => 'La soumission ne peut pas être supprimée'], 400);
        }
    }

    public function updateApprovalStatus10(Request $request)
    {
        /*$waybill = Waybill::find($request->id); // Find the waybill by ID


        if ($waybill) {
            $waybill->approval_status = $request->is_approved; // Update the is_approved column
            $waybill->save(); // Save the changes
            return response()->json(['success' => true, 'message' => 'Waybill status updated successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Waybill not found']);*/

        if($request){

        }
    try {
        $waybill = Waybill::find($request->id); // Find the waybill by ID

        if (!$waybill) {
            return response()->json(['success' => false, 'message' => 'Waybill not found']);
        }

        $waybill->approval_status = $request->is_approved; // Update the `is_approved` column
        $waybill->save(); // Save the change

        return response()->json(['success' => true, 'message' => 'Waybill status updated successfully']);
    } catch (\Exception $e) {
        // Catch errors and log them
        \Log::error('Error updating waybill approval status: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'An error occurred.']);
    }


    }


//     public function updateWaybill(Request $request)
// {
//     // Retrieve the waybill by ID from the request
//     $waybillId = $request->input('id');  // Get the 'id' parameter
//     $isApproved = $request->input('is_approved');  // Get the 'is_approved' value
//     return response()->json(['id' => $waybillId, 'is_approved' => 1]);
//     // Find the waybill record by its ID
//     /*$waybill = Waybill::find($waybillId);

//     // Check if the waybill exists
//     if (!$waybill) {
//         // If not found, return a 404 error response
//         return response()->json(['error' => 'Waybill not found'], 404);
//     }

//     // Update the 'is_approved' field
//     $waybill->approval_status = $isApproved;

//     // Save the updated waybill
//     if ($waybill->save()) {
//         // Return a success response
//         return response()->json(['message' => 'Waybill updated successfully', 'waybill' => $waybill], 200);
//     } else {
//         // If there was an error saving the waybill, return an error response
//         return response()->json(['error' => 'Failed to update waybill'], 500);
//     }*/
// }


/*public function updateApprovalStatus(Request $request)
{
    // Log incoming data
    \Log::info('Incoming Approval Request', $request->all());

     $waybillId = $request->input('waybillId');
     \Log::info("variable waybill: ",$waybillId);

    // Check if `id` and `is_approved` exist in the request
    if (!$request->has('id') || !$request->has('is_approved')) {
        \Log::error('Missing required parameters', $request->all());
        return response()->json(['success' => false, 'message' => 'Missing required parameters.'], 400);
    }

    // Validate `is_approved` to ensure it's boolean (0 or 1)
    if (!in_array($request->is_approved, [0, 1], true)) {
        \Log::error('Invalid is_approved value', ['is_approved' => $request->is_approved]);
        return response()->json(['success' => false, 'message' => 'Invalid is_approved value.'], 400);
    }

    // Find the waybill
    $waybill = Waybill::find($request->id);

    if (!$waybill) {
        \Log::error('Waybill not found', ['id' => $request->id]);
        return response()->json(['success' => false, 'message' => 'Waybill not found.'], 404);
    }

    // Update the approval status
    $waybill->approval_status = $request->is_approved;

    // Save and check the result
    if ($waybill->save()) {
        \Log::info('Waybill updated successfully', ['id' => $request->id, 'is_approved' => $request->is_approved]);
        return response()->json(['success' => true, 'message' => 'Approval status updated successfully.']);
    } else {
        \Log::error('Failed to save waybill', ['id' => $request->id]);
        return response()->json(['success' => false, 'message' => 'Failed to update approval status.'], 500);
    }
}*/

/*public function updateApprovalStatus(Request $request)
{
    Log::info('updateApprovalStatus called', [
        'waybillId' => $request->waybillId ?? null,
        'approved' => $request->status ?? null,
    ]);

    $waybillId = $request->input('waybillId');  // Access waybillId
    $status = $request->input('status');        // Access status

    Log::info('value retrive', [
        'waybillId' => $waybillId ?? null,
        'approved' => $status ?? null,
    ]);

    // Validate incoming request
    // $validatedData = $request->validate([
    //     'waybillId' => 'required|integer|exists:waybills,id', // Ensures the waybill exists in the database
    //     'approved' => 'required|boolean', // Ensures approved is either 0 or 1
    // ]);

    Log::info('Request validated successfully', $waybillId);
    $tableName = "waybills";
    $columnName = "approval_status";
    try {
        DB::table($tableName)
            ->where('id', $waybillId)
            ->update([$columnName => $status]);

        return response()->json(['success' => true, 'message' => 'Data updated successfully']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    }

    try {
        // Retrieve the Waybill by ID
        $waybill = Waybill::findOrFail($waybillId);

        Log::info('Waybill retrieved successfully', ['waybill' => $waybillId]);

        // Update the approval status
        $waybill->approval_status = $status;
        $waybill->save();

        Log::info('Waybill approval status updated successfully', [
            'waybillId' => $waybillId,
            'is_approved' => $status,
        ]);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Approval status updated successfully!',
        ], 200);
    } catch (\Exception $e) {
        // Log the error details
        Log::error('Error occurred while updating approval status', [
            'error_message' => $e->getMessage(),
            'stack_trace' => $e->getTraceAsString(),
        ]);

        // Handle any unexpected errors
        return response()->json([
            'success' => false,
            'message' => 'Failed to update approval status.',
            'error' => $e->getMessage(),
        ], 500);
    }
}*/

public function updateApprovalStatus(Request $request)
{
    // Log initial function call
    Log::info('updateApprovalStatus called', [
        'waybillId' => $request->input('waybillId', null),
        'status' => $request->input('status', null),
    ]);

    // Extract request data
    $waybillId = $request->input('waybillId');
    $status = $request->input('status');

    // Log extracted values
    Log::info('Extracted values from request', [
        'waybillId' => $waybillId,
        'status' => $status,
    ]);

    // Validate inputs (optional but recommended for robust handling)
    if (!is_numeric($waybillId) || !in_array($status, [0, 1], true)) {
        Log::error('Validation failed', [
            'waybillId' => $waybillId,
            'status' => $status,
        ]);
        return response()->json(['success' => false, 'message' => 'Invalid data provided'], 400);
    }

    // Define table and column
    $tableName = "waybills";
    $columnName = "approval_status";

    try {
        // Update the database
        $updated = DB::table($tableName)
            ->where('id', $waybillId)
            ->update([$columnName => $status]);

        if ($updated) {
            Log::info('Database updated successfully', [
                'waybillId' => $waybillId,
                'status' => $status,
            ]);

            return response()->json(['success' => true, 'message' => 'Approval status updated successfully']);
        } else {
            Log::warning('No rows updated', ['waybillId' => $waybillId]);
            return response()->json(['success' => false, 'message' => 'No matching record found'], 404);
        }
    } catch (\Exception $e) {
        // Log error details
        Log::error('Error occurred during database update', [
            'error_message' => $e->getMessage(),
            'stack_trace' => $e->getTraceAsString(),
        ]);

        return response()->json(['success' => false, 'message' => 'Failed to update data'], 500);
    }
}

public function uploadSignature(Request $request)
{
    /*$request->validate([
        'waybill_id' => 'required|exists:waybills,id',
        'signature'  => 'required',
    ]);*/

    $waybill = Waybill::findOrFail($request->waybill_id);

    // Decode Base64 signature and save as image
    $signatureData = explode(',', $request->signature)[1];
    $signaturePath = 'signatures/' . uniqid() . '.png';
    Log::info('upload Signature called!', [
        'waybillId' => $waybill,
        $signaturePath,
        // 'signature' => explode(',', $request->signature)[1]),
    ]);
    \Storage::disk('public')->put($signaturePath, base64_decode($signatureData));

    // Update waybill record with the signature path
    // $waybill->update(['signature' => $signaturePath]);
    $waybill->signature = $signaturePath;
    $waybill->save();

    return redirect()->back()->with('success', 'Signature uploaded successfully.');
}

public function uploadSignature1(Request $request)
{
    dd($request->all());
    // if($request)
    // return response()->json(['message' => 'Route is working']);
}

// public function uploadPickupImage(Request $request, $id)
// {
//     // $request->validate(['pickup_image' => 'required|image|max:2048']);

//     $path = $request->file('pickup_image')->store('pickup_images', 'public');
//     Log::info('upload pickup Image called!', [
//         'waybillId' =>  $path,
//         // 'signature' => explode(',', $request->signature)[1]),
//     ]);
//     Waybill::where('id', $id)->update(['pickup_image' => $path]);
//     return back()->with('success', 'Pickup image uploaded successfully.');
// }

public function uploadPickupImage(Request $request, $id)
{
    // Uncomment and improve validation for the pickup image

    /*$request->validate([
        'pickup_image' => 'required|image|max:2048', // Ensures it is an image and under 2MB
    ]);*/
    Log::info('Upload Pickup Image called!', [
        'waybillId' => $id,
        // 'imagePath' => $path,
    ]);

    // Handle the file upload
    if ($request->hasFile('pickup_image')) {
        Log::info('Upload Pickup Image called!', [
            'waybillId' => $id,
            // 'imagePath' => $path,
        ]);

        // Store the file in the 'pickup_images' folder within the public disk
        $path = $request->file('pickup_image')->store('pickup_images', 'public');
        Log::info('Upload Pickup Image called!', [
            'waybillId' => $id,
            'imagePath' => $path,
        ]);

        // Update the waybill record with the file path
        Waybill::where('id', $id)->update(['pickup_image' => $path]);

        // Update delivery status to "delivered" if not already set
    // if ($waybill->delivery_status !== 'delivered') {
    //     $waybill->delivery_status = 'delivered';
    // }

    // $waybill->save();
        return back()->with('success', 'Pickup image uploaded successfully.');
    }

    // If no file is uploaded, return an error message
    return back()->with('error', 'No pickup image uploaded.');
}


public function uploadDropImage(Request $request, $id)
{
    // $request->validate(['drop_image' => 'required|image|max:2048']);
    $path = $request->file('drop_image')->store('drop_images', 'public');
    Waybill::where('id', $id)->update(['drop_image' => $path]);
    return back()->with('success', 'Drop image uploaded successfully.');
}

public function updateDeliveryStatus(Request $request, $id)
{
    /*$request->validate([
        'delivery_status' => 'required|in:on_the_way,order_complete',
    ]);*/

    $waybill = Waybill::findOrFail($id);

    // Update delivery_status
    $waybill->update([
        'delivery_status' => $request->delivery_status,
    ]);

    return redirect()->back()->with('success', 'Delivery status updated successfully.');
}

// In WaybillController
// debug
public function markDeliveredDebug($id)
{
    // $waybill = Waybill::findOrFail($id);
    // Update the status to "delivered" or perform any other action
    // $waybill->delivery_status = 'delivered';
    // $waybill->delivery_status = 'delivered';
    // $waybill->save();
    // $value = "delivered";
    // Waybill::where('id', $id)->update(['delivery_status' => $value]);
    // return redirect()->back()->with('success', 'Waybill marked as delivered');

}

public function markDelivered($id)
{
    // Find the Waybill by its ID
    $waybill = Waybill::findOrFail($id);

    // Update the delivery status to 'delivered'
    // $waybill->delivery_status = 'delivered';
    $waybill->delivery_status = '1';
    $waybill->save(); // Save the changes

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Waybill marked as delivered');
}


}
