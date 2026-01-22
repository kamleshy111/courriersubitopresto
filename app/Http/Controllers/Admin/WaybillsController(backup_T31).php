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
        $drivers = Driver::pluck('full_name', 'id');
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
                            'city_id'      => $request->input($i.'.shipper.city_id'),
                            'state'        => $request->input($i.'.shipper.state'),
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
                            'city_id'      => $request->input($i.'.recipient.city_id'),
                            'state'        => $request->input($i.'.recipient.state'),
                            'postal_code'  => $request->input($i.'.recipient.postal_code'),
                            'contact'      => $request->input($i.'.recipient.contact'),
                        ]
                    );
                    $model->recipient_id = $client->id;
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
                if(in_array($model->status, ["same_day", "tomorrow"])) {
                    $waybillsToSend[] = $model->id;
                }
                $waybillsToPrint[] = $model->id;
            }

            if(!empty($waybillsToSend)) {
                if($waybillType == "true") {
                    $pdf = $this->emailPdf(Waybill::with('user.client', 'shipper', 'recipient', 'shipper.city', 'recipient.city')->whereIn('id', $waybillsToSend)->get(), true, 1, false);
                    Mail::html('Voir pièce jointe.', function ($message) use ($pdf) {
                        $message->to(env('OWNER_EMAIL_TO_NOTIFICATION'))
                            ->bcc(env('OWNER_EMAIL_BCC_NOTIFICATION'))
                            ->subject('Nouveau Waybill de ' . \Auth::user()->name)
                            ->attachData($pdf, 'Waybills.pdf', [
                                'mime' => 'application/pdf',
                            ]);
                    });
                }


                if($waybillType == "false")
                {
                    $pdf = $this->emailPdf(Waybill::with('user.client', 'shipper', 'recipient', 'shipper.city', 'recipient.city')->whereIn('id', $waybillsToSend)->get(), true, 1, false);
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
                    'subject' => 'Votre soumission la soumission est prête to admin',
                    'content' => 'Votre soumission la soumission est prête to admin',
                    'type'    => 1
                ]);
            }
        }

        return parent::update($request, $id);
    }

    public function show($id)
    {
        $waybill = Waybill::with('user.client', 'shipper', 'recipient', 'shipper.city', 'recipient.city')
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

            $waybills = Waybill::with('user.client', 'shipper', 'recipient', 'shipper.city', 'recipient.city')
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

        $drivers = Driver::pluck('full_name', 'id');
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

            $view = view('admin.waybills.pdf', $waybill)->renderSections();

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
            $view = view('admin.waybills.email-pdf', $waybill)->renderSections();

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
}
