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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
                if(\Laratrust::hasRole('admin' || 'Driver')) {
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
        Log::info('Store request data:', $request->all());
        $waybillType = "true";
        $new = $request->all();

        if ($request->boolean('save_and_preview')) {
            $request->validate(['label_count' => 'required|integer|min:1|max:100']);
        }
        $labelCount = max(1, min(100, (int) $request->input('label_count', 1)));

        for($i = 0; $i <= $request->input('counter', 0); $i++) {
            // if (isset($request[$i]['round_trip_1']) && $request[$i]['round_trip_1'] == '1')
            //     {
            //         Log::info("round_trip_1 is checked — creating reverse waybill");
            //     }
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

        // new addition

        $request->replace($new);

        $model = new $this->model();
        $rules = $model->rules;

        if ($request->filled('user_id')) {
    $validator_checker = false; // manually skipping validation in this case
    Log::info('Received user_id for quick waybill', [
        'user_id' => $request->input('user_id')
    ]);
} else {

    unset($rules['user_id']); // make sure it's not required
    $validator = Validator::make($request->except(['counter', 'save_and_preview', 'label_count']), (new $this->model())->rules);
    $validator_checker = $validator->fails();
    // Fix Log line
    Log::info('Validation checker:', ['value' => $validator_checker]);
    Log::info('user_id for regular waybill', [
        'user_id' => $request->input('user_id')
    ]);
}

        if ($validator_checker) {
            if ($request->filled('user_id'))
                {return redirect( url('admin/waybills/create?waybill=' . $waybillType .'&mode=rapid'))
                    ->withErrors($validator)
                    ->withInput($request->input());
                }
                else{
                    return redirect( url('admin/waybills/create?waybill=' . $waybillType))
                    ->withErrors($validator)
                    ->withInput($request->input());
                }
        }

        else {
            Log::info('validated.');
            $waybillsToSend = [];
            $waybillsToPrint = [];
            $saveAndPreview = $request->boolean('save_and_preview');
            $firstWaybillId = null;
            for($i = 0; $i <= $request->get('counter', 0); $i++) {
                // store
                $model = new $this->model();
                $model->fill($request->input($i));



                if(is_null($model->shipper_id) && $request->has($i.'.shipper')) {
                    Log::info('shipper section user_id:', [
        'user_id' => $request->input('user_id')
    ]);

                    if ($request->filled('user_id')) {
                        $client = Client::updateOrCreate(
                        [
                            'phone' => $request->input($i.'.shipper.phone')
                        ],
                        [
                            'user_id'      => $request->input('user_id'),
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
                            'note_permanent'        => $request->input($i.'.shipper_note'),
                        ]
                    );

                    }
                    else{
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
                            'note_permanent'        => $request->input($i.'.shipper_note'),
                        ]
                    );

                    }
                    $model->shipper_id = $client->id;
                }

                if(is_null($model->recipient_id) && $request->has($i.'.recipient')) {
                    Log::info('Recipient section user_id', [
        'user_id' => $request->input('user_id')
    ]);

                    if ($request->filled('user_id')) {
                        $client = Client::updateOrCreate(
                        [
                            'phone' => $request->input($i.'.recipient.phone')
                        ],
                        [
                            'user_id' => $request->input('user_id'),
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
                            'note_permanent' => $request->input($i.'.recipient_note'),
                        ]
                    );
                    }
                    else{
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
                            'note_permanent' => $request->input($i.'.recipient_note'),
                        ]
                    );
                    }

                    $model->recipient_id = $client->id;
                }


                if ($request->has($i . '.driver_id')) {
                    $model->driver_id = $request->input($i . '.driver_id');
                }

                // Opening hours + Permanent information: sync to waybill and to client note_permanent
                if ($request->has($i . '.shipper_note')) {
                    $model->shipper_note = $request->input($i . '.shipper_note');
                    if ($model->shipper_id) {
                        $shipper = Client::find($model->shipper_id);
                        if ($shipper) {
                            $shipper->note_permanent = $request->input($i . '.shipper_note');
                            $shipper->save();
                        }
                    }
                }
                if ($request->has($i . '.recipient_note')) {
                    $model->recipient_note = $request->input($i . '.recipient_note');
                    if ($model->recipient_id) {
                        $recipient = Client::find($model->recipient_id);
                        if ($recipient) {
                            $recipient->note_permanent = $request->input($i . '.recipient_note');
                            $recipient->save();
                        }
                    }
                }

                // shipper address extension test

                if ($request->has($i . '.shipper.address_ext')) {

                    // Assign it to the current model
                    // $model->shipper_address_ext = $request->input($i . '.shipper.address_ext');

                    // Handle saving into Client table (for permanent record)
                    if (is_null($model->shipper_id)) {
                        // In case shipper_id not yet set but $client is available
                        if (isset($client) && isset($client->id)) {
                            $shipper = Client::find($client->id);
                            if ($shipper) {
                                $shipper->address_ext = $request->input($i . '.shipper.address_ext');
                                $shipper->save();
                            }
                        }
                    }
                    else {
                        // For already existing shipper
                        Log::info("Updating address_ext for existing shipper ID: " . $model->shipper_id);
                        $shipper = Client::find($model->shipper_id);
                        if ($shipper) {
                            $shipper->address_ext = $request->input($i . '.shipper.address_ext');
                            $shipper->save();
                        }
                    }
                }

                // recipient address ext


                if ($request->has($i . '.recipient.address_ext')) {

                // Attach to waybill model (if you want to use it later)
                // $model->recipient_address_ext = $request->input($i . '.recipient.address_ext');

                // If recipient not yet stored but client created above
                if (is_null($model->recipient_id)) {
                    if (isset($client) && isset($client->id)) {
                        $recipient = Client::find($client->id);
                        if ($recipient) {
                            $recipient->address_ext = $request->input($i . '.recipient.address_ext');
                            $recipient->save();
                        }
                    }
                } else {
                    // Update for existing recipient
                    Log::info("Updating address_ext for existing recipient ID: " . $model->recipient_id);
                    $recipient = Client::find($model->recipient_id);
                    if ($recipient) {
                        $recipient->address_ext = $request->input($i . '.recipient.address_ext');
                        $recipient->save();
                    }
                }
            }


                if ($request->has('recipient_note')) {
                    $model->recipient_note = $request->input('recipient_note');
                }

                if ($request->has('tailgate_1')) {
                    $model->tailgate_1 = $request->input('tailgate_1');
                }

                if ($request->has('tailgate_2')) {
                    $model->tailgate_2 = $request->input('tailgate_2');
                }


                if ($request->filled('user_id')) {
                    Log::info('ID is present:', ['user_id' => $request->input('user_id')]);
                    $model->user_id = $request->input('user_id');
                } else {
                    Log::warning('ID is missing from the request.');
                }
                if (!empty($model->user_id)) {
                    Log::warning('rapid bill found in model condition');
                    $model->soft_id = User::find($model->user_id)
                        ->waybills()
                        ->withTrashed()
                        ->count() + 1;
                }else{

                $model->soft_id = \Auth::user()->waybills()
                        ->withTrashed()
                        ->count() + 1;
                }
                $model->is_new = 1;

                $model->save();

                // new reversal waybill

                // ✅ STEP 1: If round_trip_1 is checked, create reversed waybill
/*if (isset($request[$i]['round_trip_1']) && $request[$i]['round_trip_1'] == '1') {
    Log::info("round_trip_1 is checked — creating reverse waybill");

    $reverseWaybill = $model->replicate(); // Clone the original model

    // Swap shipper and recipient
    $reverseWaybill->shipper_id = $model->recipient_id;
    $reverseWaybill->recipient_id = $model->shipper_id;

    // Optionally swap notes (if relevant)
    $reverseWaybill->shipper_note = $model->recipient_note;
    $reverseWaybill->recipient_note = $model->shipper_note;

    // Set soft_id like original
    if (!empty($reverseWaybill->user_id)) {
        $reverseWaybill->soft_id = User::find($reverseWaybill->user_id)
            ->waybills()
            ->withTrashed()
            ->count() + 1;
    } else {
        $reverseWaybill->soft_id = \Auth::user()->waybills()
            ->withTrashed()
            ->count() + 1;
    }

    $reverseWaybill->is_new = 1;
    $reverseWaybill->save();

    // $waybillsToPrint[] = $reverseWaybill->id; //this will also add waybill in the last created one
    // Only add to send array, not print array
    $waybillsToSend[] = $reverseWaybill->id;

    Log::info("Reverse waybill created with ID: " . $reverseWaybill->id);
}*/
                if($request->input($i.'.waybill_type') == "false"){
                    $model->update([
                        'type'   => 1
                    ]);
                    $waybillType = "false";
                }
                if(in_array($model->status, ["same_day", "tomorrow","urgent","code_red","night","very_urgent"])) {
                    $waybillsToSend[] = $model->id;
                    Log::info('Waybill ID added to send email', ['id' => $model->id]);

                }
                $waybillsToPrint[] = $model->id;
                if ($saveAndPreview && $firstWaybillId === null) {
                    $firstWaybillId = $model->id;
                }
            }

            if ($saveAndPreview && $firstWaybillId) {
                return redirect()->route('admin.waybill.label-preview', ['id' => $firstWaybillId, 'label_count' => $labelCount]);
            }

            if(!empty($waybillsToSend)) {
                if($waybillType == "true") {
                    $pdf = $this->emailPdf(Waybill::with('user.client', 'shipper', 'recipient')->whereIn('id', $waybillsToSend)->get(), true, 1, false);
                    Log::info('PDF generated successfully', ['waybills' => $waybillsToSend]);

                    try {Mail::html('Voir pièce jointe.', function ($message) use ($pdf) {
                        // Log values for debugging
                        $toAddress = env('OWNER_EMAIL_TO_NOTIFICATION');
                        $bccAddress = env('OWNER_EMAIL_BCC_NOTIFICATION');
                        // $bccAddress = 'ali2015333061@gmail.com';  // <- replace with your testing email
                        $fromAddress = env('MAIL_FROM_ADDRESS');
                        Log::info('To Address: ' . env('OWNER_EMAIL_TO_NOTIFICATION'));
                        Log::info('BCC Address: ' . env('OWNER_EMAIL_BCC_NOTIFICATION'));
                        Log::info('From Address: ' . $fromAddress);

                        if (empty($toAddress) || empty($bccAddress) || empty($fromAddress)) {
                            Log::error('Invalid email address(es) detected!');
                        }
                        // $message->to('danybergeron@courriersubitopresto.com')
                        //     ->bcc('widmaertelisma@gmail.com')
                            $message->to(env('OWNER_EMAIL_TO_NOTIFICATION'))
                            ->bcc(env('OWNER_EMAIL_BCC_NOTIFICATION'))
                            // ->bcc(env('ali2015333061@gmail.com'))
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

        // new added
        $shipper_id = $waybill->shipper_id;
        $client_shipper = Client::find($shipper_id);
        $recipeint_id = $waybill->recipient_id;
        $client_recipient = Client::find($recipeint_id);

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

        if ($request->has('0.shipper.contact')) {
            $client_shipper->contact = $request->input('0.shipper.contact');
            $client_shipper->save();
            $waybill->shipper_contact = $request->input('0.shipper.contact');
            $waybill->save();

        }

        if ($request->has('0.recipient.contact')) {
                $client_recipient->contact = $request->input('0.recipient.contact');
                $client_recipient->save();
                $waybill->recipient_contact = $request->input('0.recipient.contact');
                $waybill->save();

        }

        if ($request->has('driver_id')) {
            $waybill->driver_id = $request->input('driver_id');
        }

        $shipperNote = $request->input('shipper_note') ?? $request->input('0.shipper_note');
        $recipientNote = $request->input('recipient_note') ?? $request->input('0.recipient_note');
        if ($shipperNote !== null) {
            $waybill->shipper_note = $shipperNote;
            // Sync Opening hours + Permanent information to client table
            if ($waybill->shipper_id && $client_shipper) {
                $client_shipper->note_permanent = $shipperNote;
                $client_shipper->save();
            }
        }
        if ($recipientNote !== null) {
            $waybill->recipient_note = $recipientNote;
            // Sync Opening hours + Permanent information to client table
            if ($waybill->recipient_id && $client_recipient) {
                $client_recipient->note_permanent = $recipientNote;
                $client_recipient->save();
            }
        }

        if ($request->has('tailgate_1')) {
                $waybill->tailgate_1 = $request->input('tailgate_1');
            }

        if ($request->has('tailgate_2')) {
            $waybill->tailgate_2 = $request->input('tailgate_2');
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

    // old working
    /*public function show($id)
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

    }*/

    public function show($id)
{
    $waybill = Waybill::with('user.client', 'shipper', 'recipient')
        ->findOrFail($id);

    $type = request()->query('waybill');
    $archive = request()->boolean('archive');

    // Merge into request so pdf() and the view can use request()->boolean('archive')
    request()->merge(['archive' => $archive]);

    if ($type === "false") {
        return $this->pdf($waybill, false, 1, true);
    }

    if ($type === "true") {
        return $this->pdf($waybill, false, 3, true);
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
                'type'             => 0,
                // 'submission_approval_date' => date('Y-m-d')
                'submission_approval_date' => now()->toDateString(),  // ✔ correct for DATE
                // 'date' => now()->toDateString(),  // ✔ correct for DATE

            ]);
            EmailWaybillQueue::create([
                'email_to'               => env('OWNER_EMAIL_TO_NOTIFICATION'),
                'email_bcc'              => env('OWNER_EMAIL_BCC_NOTIFICATION'),

                // 'email_to'                 => 'ali2015333061@gmail.com',
                // 'email_bcc'             => 'Widmaer.telisma@wboitemedia.com',
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
    //     Log::info("Reject function called for waybill ID: $id");

    //     Log::info("Waybill found in reject function", [
    //     'id' => $waybill->id,
    //     'type' => $waybill->type,
    //     'price' => $waybill->price,
    //     'submission_status' => $waybill->submission_status
    // ]);

        if($waybill->type == 1 && $waybill->price != null && $waybill->submission_status == 0)
        {
            $waybill->update([
                'submission_status' => 3,
                'type'             => 1
            ]);
            // EmailQueue::create([
            EmailWaybillQueue::create([
                'email_to'       => env('OWNER_EMAIL_TO_NOTIFICATION'),
                'email_bcc'   => env('OWNER_EMAIL_BCC_NOTIFICATION'),
                // 'email_to'       => 'ali2015333061@gmail.com',
                // 'email_bcc'     => 'Widmaer.telisma@wboitemedia.com',
                'subject'     => 'Le numéro de soumission  a été refusé',
                'content'     => 'Le numéro de soumission  a été refusé',
                'user_name'   => \Auth::user()->name,
                'pdf_type'               => 1,
                'pdf_ids'                => $id,
                'attach_data_extension'  => 'Soumissions.pdf',
                // 'type'        => 3
            ]);

        //      Log::info("EmailQueue entry created for soumission rejection", [
        //     'user_name'    => \Auth::user()->name,
        //     'pdf_url'      => url('admin/waybills/' . $id . '?waybill=true')
        // ]);

            return response()->json(['message' => 'Soumission rejetée avec succès','pdf_url' => url('admin/waybills/' . $id . '?waybill=true')]);
        }else{
            return response()->json(['error' => 'La soumission ne peut pas être rejetée'], 400);
        }
    }

    /**
     * Soft delete waybill (corbeille). Waybill model uses SoftDeletes so delete() sets deleted_at.
     * Returns JSON for AJAX requests.
     */
    public function destroy($id)
    {
        $waybill = Waybill::findOrFail($id);
        $waybill->delete(); // soft delete

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Bordereau supprimé (corbeille) avec succès.']);
        }
        return "true";
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
    // Log::info('updateApprovalStatus called', [
    //     'waybillId' => $request->input('waybillId', null),
    //     'status' => $request->input('status', null),
    // ]);

    // Extract request data
    $waybillId = $request->input('waybillId');
    $status = $request->input('status');
    $isMira = $request->input('is_mira');

    // Log extracted values
    // Log::info('Extracted values from request', [
    //     'waybillId' => $waybillId,
    //     'status' => $status,
    // ]);

    // Validate inputs (optional but recommended for robust handling)
    /*if (!is_numeric($waybillId) || !in_array($status, [0, 1], true)) {
        Log::error('Validation failed', [
            'waybillId' => $waybillId,
            'status' => $status,
        ]);
        return response()->json(['success' => false, 'message' => 'Invalid data provided'], 400);
    }*/

    // Define table and column
    $tableName = "waybills";
    $columnName = "approval_status,driver_id,delivery_status,is_mira";

    try {
        if (!is_null($isMira)) {
            $updated = DB::table($tableName)
            ->where('id', $waybillId)
            ->update([
                'is_mira' =>1
            ]);
    // this block will NOT run
    }

         else if($status == 0){
             $delivery_status = "";
        $updated = DB::table($tableName)
            ->where('id', $waybillId)
            // ->update([$columnName => $status]);
            ->update([
                'approval_status' => $status,  // Update the dynamic column with the status
                // delete from client delivery & driver
                // 'driver_id' => null,           // Set the 'd_id' column to null (you can use "" for empty string)
                // 'delivery_status' => null
                'dashboard_soft_delete' =>1,
                'order' => null,
                'popup_position' => null
            ]);
        }
            else if($status == 1){
                $updated = DB::table($tableName)
            ->where('id', $waybillId)
            // ->update([$columnName => $status]);
            ->update([  'approval_status' => $status,
                        'driver_id' => null,
                        'delivery_status' => null,
                        'order' => null,
                        'popup_position' => null
                        ]);

            }
        // Update the database
        /*$updated = DB::table($tableName)
            ->where('id', $waybillId)
            ->update([$columnName => $status]);*/

        /*if ($updated) {
            Log::info('Database updated successfully', [
                'waybillId' => $waybillId,
                'status' => $status,
            ]);

            return response()->json(['success' => true, 'message' => 'Approval status updated successfully']);
        } else {
            Log::warning('No rows updated', ['waybillId' => $waybillId]);
            return response()->json(['success' => false, 'message' => 'No matching record found'], 404);
        }*/
        return response()->json(['success' => true, 'message' => 'Approval status updated successfully']);
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
        Waybill::where('id', $id)->update([
            'pickup_image' => $path,
            'pickup_time' => now(), // Store the current timestamp
            'delivery_status' => 2
            // 'driver_flag' => 2
            ]);

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


/*public function uploadPickupImageUpdated(Request $request, $waybillId)
{
    $request->validate([
        'pickup_image' => 'required|string',  // Ensure the image data is provided
    ]);

    try {
        // Get the Base64 encoded image from the request
        $imageData = $request->input('pickup_image');

        // Extract the image data part (the actual image, excluding the data URL header)
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);

        // Decode the Base64 image data
        $image = base64_decode($imageData);

        // Generate a unique name for the image file
        $imageName = 'pickup_image_' . time() . '.jpg';

        // Define the path where the image will be saved
        $path = 'pickup_images/' . $imageName;

        // Log the image upload details
        Log::info('Upload Pickup Image called!', [
            'waybillId' => $waybillId,  // Corrected from $id to $waybillId
            'imageName' => $imageName,
            'imagePath' => $path,
        ]);

        // Save the image to the storage directory (e.g., storage/app/public/pickup_images)
        Storage::disk('public')->put($path, $image);

        // Save the path to the database
        // $waybill = Waybill::findOrFail($waybillId);
        // $waybill->delivery_status => 2;
        // $waybill->save();

        Waybill::where('id', $waybillId)->update([
            'pickup_image' => $path,
            // 'pickuptime' => Carbon::now(), // Store the current timestamp
            'pickup_time' => now(), // Store the current timestamp
            'delivery_status' => 2]);

        // Return success response
        return response()->json(['success' => true, 'path' => $path]);

    } catch (\Exception $e) {
        // Handle errors and log the exception
        Log::error('Error uploading pickup image', [
            'waybillId' => $waybillId,
            'error' => $e->getMessage(),
        ]);
        return response()->json(['success' => false, 'message' => 'Error saving image: ' . $e->getMessage()]);
    }
}

*/


// old working
/*public function uploadPickupImageUpdated(Request $request, $waybillId)
{
    $request->validate([
        'pickup_image' => 'required|string',  // Ensure the image data is provided
    ]);

    try {
        // Get the Base64 encoded image from the request
        $imageData = $request->input('pickup_image');

        // Extract the image data part (the actual image, excluding the data URL header)
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);

        // Decode the Base64 image data
        $image = base64_decode($imageData);

        // Generate a unique name for the image file
        $imageName = 'pickup_image_' . time() . '.jpg';

        // Define the path where the image will be saved
        $path = 'pickup_images/' . $imageName;
        // $userId = Auth::id();  // Or use auth()->user()->id
        $loggedUser = Auth::user(); // Get the authenticated user object

        // Access the user ID
        $loggedUserId = $loggedUser->id;

        if ($loggedUserId == 99){
            $waybillPosition = "cell75";
        }

        if ($loggedUserId == 10){
            $waybillPosition = "cell42";
        }
        else if ($loggedUserId == 27){
            $waybillPosition = "cell43";
        }
        else if ($loggedUserId == 43){
            $waybillPosition = "cell44";
        }
        else if ($loggedUserId == 49){
            $waybillPosition = "cell45";
        }
        else if ($loggedUserId == 51){
            $waybillPosition = "cell46";
        }
        else if ($loggedUserId == 55){
            $waybillPosition = "cell47";
        }
        else if ($loggedUserId == 64){
            $waybillPosition = "cell48";
        }

        // Log the image upload details
        /*Log::info('Upload Pickup Image called!', [
            'waybillId' => $waybillId,  // Corrected from $id to $waybillId
            'imageName' => $imageName,
            'imagePath' => $path,
            'userId'    => $loggedUserId,
        ]);*/


        // Save the image to the storage directory (e.g., storage/app/public/pickup_images)
        // Storage::disk('public')->put($path, $image);

        // Save the path to the database
        /*$waybill = Waybill::findOrFail($waybillId);
        $waybill->pickup_image = $path;
        $waybill->pickup_time => now(); // Store the current timestamp
        $waybill->delivery_status => 2;
        $waybill->save();*/

        /*Waybill::where('id', $waybillId)->update([
            'pickup_image' => $path,
            // 'pickuptime' => Carbon::now(), // Store the current timestamp
            'pickup_time' => now(), // Store the current timestamp
            'dashboard_position' => $waybillPosition,
            'delivery_status' => 2,
            'driver_flag' => 2]);

        // Return success response
        return response()->json(['success' => true, 'path' => $path]);

    } catch (\Exception $e) {
        // Handle errors and log the exception
        Log::error('Error uploading pickup image', [
            'waybillId' => $waybillId,
            'error' => $e->getMessage(),
        ]);
        return response()->json(['success' => false, 'message' => 'Error saving image: ' . $e->getMessage()]);
    }
}*/

// old working 22.925
/*public function uploadPickupImageUpdated(Request $request, $waybillId)
{
    $request->validate([
    'pickup_image' => 'required|string',
    'is_mira' => 'nullable|string'
]);

    try {
        // Get the Base64 encoded image from the request
        $imageData = $request->input('pickup_image');
        $is_mira = $request->input('is_mira');

        // Extract the image data part (the actual image, excluding the data URL header)
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);

        // Decode the Base64 image data
        $image = base64_decode($imageData);

        // Generate a unique name for the image file
        $imageName = 'pickup_image_' . time() . '.jpg';

        // Define the path where the image will be saved
        $path = 'pickup_images/' . $imageName;
        // $userId = Auth::id();  // Or use auth()->user()->id
        $loggedUser = Auth::user(); // Get the authenticated user object

        // Access the user ID
        $loggedUserId = $loggedUser->id;

        if($is_mira == "1"){

            if ($loggedUserId == 99){
                $waybillPosition = "cell72";
            }

            if ($loggedUserId == 10){
                $waybillPosition = "cell2";
            }
            else if ($loggedUserId == 27){
                $waybillPosition = "cell3";
            }
            else if ($loggedUserId == 43){
                $waybillPosition = "cell4";
            }
            else if ($loggedUserId == 49){
                $waybillPosition = "cell5";
            }
            else if ($loggedUserId == 51){
                $waybillPosition = "cell6";
            }
            else if ($loggedUserId == 55){
                $waybillPosition = "cell7";
            }
            else if ($loggedUserId == 64){
                $waybillPosition = "cell8";
            }

            // Log the image upload details
            /*Log::info('Upload Pickup Image called!', [
                'waybillId' => $waybillId,  // Corrected from $id to $waybillId
                'imageName' => $imageName,
                'imagePath' => $path,
                'userId'    => $loggedUserId,
            ]);


            // Save the image to the storage directory (e.g., storage/app/public/pickup_images)
            Storage::disk('public')->put($path, $image);
            // Storage::disk('public')->put($path, $image);
            // Save the path to the database
            /*$waybill = Waybill::findOrFail($waybillId);
            $waybill->pickup_image = $path;
            $waybill->pickup_time => now(); // Store the current timestamp
            $waybill->delivery_status => 2;
            $waybill->save();

            Waybill::where('id', $waybillId)->update([
                'pickup_image' => $path,
                // 'pickuptime' => Carbon::now(), // Store the current timestamp
                'driver_assign_time' => now(),
                'drop_time' => now(), // Store the current timestamp
                'dashboard_position' => $waybillPosition,
                'delivery_status' => 1,
                'driver_flag' =>1,
                'popup_position' => null
                ]);

            // Return success response
            return response()->json(['success' => true, 'path' => $path]);

        }
        else{

        if ($loggedUserId == 99){
            $waybillPosition = "cell75";
        }

        if ($loggedUserId == 10){
            $waybillPosition = "cell42";
        }
        else if ($loggedUserId == 27){
            $waybillPosition = "cell43";
        }
        else if ($loggedUserId == 43){
            $waybillPosition = "cell44";
        }
        else if ($loggedUserId == 49){
            $waybillPosition = "cell45";
        }
        else if ($loggedUserId == 51){
            $waybillPosition = "cell46";
        }
        else if ($loggedUserId == 55){
            $waybillPosition = "cell47";
        }
        else if ($loggedUserId == 64){
            $waybillPosition = "cell48";
        }

        // Log the image upload details
        /*Log::info('Upload Pickup Image called!', [
            'waybillId' => $waybillId,  // Corrected from $id to $waybillId
            'imageName' => $imageName,
            'imagePath' => $path,
            'userId'    => $loggedUserId,
        ]);


        // Save the image to the storage directory (e.g., storage/app/public/pickup_images)
        Storage::disk('public')->put($path, $image);

        // Save the path to the database
        /*$waybill = Waybill::findOrFail($waybillId);
        $waybill->pickup_image = $path;
        $waybill->pickup_time => now(); // Store the current timestamp
        $waybill->delivery_status => 2;
        $waybill->save();

        Waybill::where('id', $waybillId)->update([
            'pickup_image' => $path,
            // 'pickuptime' => Carbon::now(), // Store the current timestamp
            'pickup_time' => now(), // Store the current timestamp
            'dashboard_position' => $waybillPosition,
            'delivery_status' => 2,
            'driver_flag' => 2]);

        // Return success response
        return response()->json(['success' => true, 'path' => $path]);
        }

    } catch (\Exception $e) {
        // Handle errors and log the exception
        Log::error('Error uploading pickup image', [
            'waybillId' => $waybillId,
            'error' => $e->getMessage(),
        ]);
        return response()->json(['success' => false, 'message' => 'Error saving image: ' . $e->getMessage()]);
    }
}
*/

public function uploadPickupImageUpdated(Request $request, $waybillId)
{
     Log::info('Upload Pickup Image Request called!');
    /*$loggedUser = Auth::user(); // Get the authenticated user object
    $loggedUserId = $loggedUser->id;

    // Determine position based on user ID
    $positionMap = [
        99 => "cell75",
        10 => "cell42",
        27 => "cell43",
        43 => "cell44",
        49 => "cell45",
        52 => "cell46",
        55 => "cell47",
        64 => "cell48",
    ];
    $waybillPosition = $positionMap[$loggedUserId] ?? null;*/


    /*$request->validate([
        'pickup_image' => 'required|string',
        'is_mira' => 'nullable|string',
    ]);*/

    // Allow single file, multiple files (pickup_image[]), or base64 string
    $hasFiles = $request->hasFile('pickup_image');
    $files = $hasFiles ? $request->file('pickup_image') : null;
    if ($files && !is_array($files)) {
        $files = [$files];
    }
    if ($files && count($files) > 5) {
        return response()->json(['success' => false, 'message' => 'Maximum 5 images allowed.']);
    }
    if (!$hasFiles && !$request->has('pickup_image')) {
        return response()->json(['success' => false, 'message' => 'No image provided.']);
    }
    if ($files) {
        // Single file (camera/one file) vs multiple (pickup_image[])
        if (is_array($request->file('pickup_image'))) {
            $request->validate([
                'pickup_image' => 'array',
                'pickup_image.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
                'is_mira' => 'nullable|string',
            ]);
        } else {
            $request->validate([
                'pickup_image' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:10240',
                'is_mira' => 'nullable|string',
            ]);
        }
    } else {
        $request->validate([
            'pickup_image' => 'required|string',
            'is_mira' => 'nullable|string',
        ]);
    }

    $is_mira = $request->input('is_mira');
    $loggedUserId = Auth::id();

     Log::info('Upload Pickup Image Request', [
        'waybill_id' => $waybillId,
        'is_mira' => $is_mira,
        'user_id' => $loggedUserId,
    ]);

    // Define mappings for both cases
    $positionMapDefault = [
        99 => "cell75",
        10 => "cell42",
        27 => "cell43",
        43 => "cell44",
        49 => "cell45",
        51 => "cell46",
        55 => "cell47",
        64 => "cell48",
    ];

    $positionMapMira = [
        99 => "cell72",
        10 => "cell2",
        27 => "cell3",
        43 => "cell4",
        49 => "cell5",
        51 => "cell6",
        55 => "cell7",
        64 => "cell8",
    ];

    // Use the appropriate map based on is_mira
    $positionMap = ($is_mira == "1") ? $positionMapMira : $positionMapDefault;

    $waybillPosition = $positionMap[$loggedUserId] ?? null;

    Log::info('Calculated Waybill Position', [
        'selected_map' => ($is_mira === "1") ? 'mira' : 'default',
        'waybill_position' => $waybillPosition,
    ]);


    try {
        $path = null;
        $paths = [];

        // ✅ Multiple files (pickup_image[])
        if ($files && count($files) > 0) {
            foreach ($files as $file) {
                if ($file->isValid()) {
                    $paths[] = $file->store('pickup_images', 'public');
                }
            }
            if (empty($paths)) {
                return response()->json(['success' => false, 'message' => 'No valid image(s) provided.']);
            }
        }
        // ✅ Single base64 image
        elseif ($request->has('pickup_image') && is_string($request->pickup_image)) {
            $imageData = $request->pickup_image;
            $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);
            $image = base64_decode($imageData);
            if (!$image) {
                return response()->json(['success' => false, 'message' => 'Invalid base64 image.']);
            }
            $imageName = 'pickup_image_' . time() . '.jpg';
            $path = 'pickup_images/' . $imageName;
            Storage::disk('public')->put($path, $image);
        }
        // ✅ Single file (backward compat)
        elseif ($request->hasFile('pickup_image') && $request->file('pickup_image')->isValid()) {
            $file = $request->file('pickup_image');
            $path = $file->store('pickup_images', 'public');
        } else {
            return response()->json(['success' => false, 'message' => 'No image provided.']);
        }

        $pickupImageValue = count($paths) > 0 ? json_encode($paths) : $path;

        if($is_mira == "1" ){
            Waybill::where('id', $waybillId)->update([
                'pickup_image' => $pickupImageValue,
                // 'pickuptime' => Carbon::now(), // Store the current timestamp
                'driver_assign_time' => now(),
                'drop_time' => now(), // Store the current timestamp
                'dashboard_position' => $waybillPosition,
                'delivery_status' => 1,
                'driver_flag' =>1,
                'popup_position' => null
                ]);

        }
        else{
             Waybill::where('id', $waybillId)->update([
            'pickup_image' => $pickupImageValue,
            'pickup_time' => now(),
            'dashboard_position' => $waybillPosition,
            'delivery_status' => 2,
            'driver_flag' => 2
        ]);
        }
        // Update DB
        /*Waybill::where('id', $waybillId)->update([
            'pickup_image' => $path,
            'pickup_time' => now(),
            'dashboard_position' => $waybillPosition,
            'delivery_status' => 2,
            'driver_flag' => 2
        ]);*/

        $count = count($paths) > 0 ? count($paths) : ($path ? 1 : 0);
        return response()->json(['success' => true, 'path' => count($paths) ? $paths[0] : $path, 'count' => $count]);

    } catch (\Exception $e) {
        Log::error('Pickup image upload error', [
            'waybillId' => $waybillId,
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Error saving image: ' . $e->getMessage()
        ]);
    }
}



/*public function uploadDropImageUpdated(Request $request, $waybillId)
{
    $request->validate([
        'drop_image' => 'required|string',  // Ensure the image data is provided
    ]);

    try {
        // Get the Base64 encoded image from the request
        $imageData = $request->input('drop_image');

        // Extract the image data part (the actual image, excluding the data URL header)
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);

        // Decode the Base64 image data
        $image = base64_decode($imageData);

        // Generate a unique name for the image file
        $imageName = 'drop_image_' . time() . '.jpg';

        // Define the path where the image will be saved
        $path = 'drop_images/' . $imageName;
        /*Log::info('Upload drop Image called!', [
            'waybillId' => $waybillId,  // Corrected from $id to $waybillId
            'imageData' => $imageData,
            'imageName' => $imageName,
            'imagePath' => $path,
        ]);
        // $userId = Auth::id();  // Or use auth()->user()->id
        $loggedUser = Auth::user(); // Get the authenticated user object

        // Access the user ID
        $loggedUserId = $loggedUser->id;

        if ($loggedUserId == 99){
            $waybillPosition = "cell76";
        }

        if ($loggedUserId == 10){
            $waybillPosition = "cell52";
        }
        else if ($loggedUserId == 27){
            $waybillPosition = "cell53";
        }
        else if ($loggedUserId == 43){
            $waybillPosition = "cell54";
        }
        else if ($loggedUserId == 49){
            $waybillPosition = "cell55";
        }
        else if ($loggedUserId == 51){
            $waybillPosition = "cell56";
        }
        else if ($loggedUserId == 55){
            $waybillPosition = "cell57";
        }
        else if ($loggedUserId == 64){
            $waybillPosition = "cell58";
        }

        // Log the image upload details
        /*Log::info('Upload drop Image called!', [
            'waybillId' => $waybillId,  // Corrected from $id to $waybillId
            'imageName' => $imageName,
            'imagePath' => $path,
            'waybillPosition' => $waybillPosition,
            'userId'    => $loggedUserId,
        ]);


        // Save the image to the storage directory (e.g., storage/app/public/pickup_images)
        Storage::disk('public')->put($path, $image);

        Waybill::where('id', $waybillId)->update([
            'drop_image' => $path,
            // 'pickuptime' => Carbon::now(), // Store the current timestamp
            'drop_time' => now(), // Store the current timestamp
            'dashboard_position' => $waybillPosition,
            'delivery_status' => 1,
            'driver_flag' => 1,
            'popup_position' => null
            ]);

        // Return success response
        return response()->json(['success' => true, 'path' => $path]);

    } catch (\Exception $e) {
        // Handle errors and log the exception
        Log::error('Error uploading pickup image', [
            'waybillId' => $waybillId,
            'error' => $e->getMessage(),
        ]);
        return response()->json(['success' => false, 'message' => 'Error saving image: ' . $e->getMessage()]);
    }
}*/

public function uploadDropImageUpdated(Request $request, $waybillId)
{
    $loggedUser = Auth::user();
    $loggedUserId = $loggedUser->id;

    // Map of user IDs to dashboard positions
    $positionMap = [
        99 => "cell76",
        10 => "cell52",
        27 => "cell53",
        43 => "cell54",
        49 => "cell55",
        51 => "cell56",
        55 => "cell57",
        64 => "cell58",
    ];

    $waybillPosition = $positionMap[$loggedUserId] ?? null;

    try {
        $path = null;

        // ✅ If base64 image is provided
        if ($request->has('drop_image') && is_string($request->drop_image)) {
            $imageData = $request->drop_image;

            // Clean and decode base64 string
            $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);
            $image = base64_decode($imageData);

            if (!$image) {
                return response()->json(['success' => false, 'message' => 'Invalid base64 image.']);
            }

            $imageName = 'drop_image_' . time() . '.jpg';
            $path = 'drop_images/' . $imageName;
            Storage::disk('public')->put($path, $image);
        }

        // ✅ If file uploaded (e.g. via FormData)
        elseif ($request->hasFile('drop_image') && $request->file('drop_image')->isValid()) {
            $file = $request->file('drop_image');
            $path = $file->store('drop_images', 'public');
        }

        else {
            return response()->json(['success' => false, 'message' => 'No image provided.']);
        }

        // ✅ Update database
        Waybill::where('id', $waybillId)->update([
            'drop_image' => $path,
            'drop_time' => now(),
            'dashboard_position' => $waybillPosition,
            'delivery_status' => 1,
            'driver_flag' => 1,
            'popup_position' => null
        ]);

        return response()->json(['success' => true, 'path' => $path]);

    } catch (\Exception $e) {
        Log::error('Drop image upload error', [
            'waybillId' => $waybillId,
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Error saving image: ' . $e->getMessage()
        ]);
    }
}


public function uploadDropImage(Request $request, $id)
{
    // $request->validate(['drop_image' => 'required|image|max:2048']);
    $path = $request->file('drop_image')->store('drop_images', 'public');
    Waybill::where('id', $id)->update(['drop_image' => $path,'drop_time' => now()]);
    return back()->with('success', 'Drop image uploaded successfully.');
}

/*public function uploadSignatureNote_old(Request $request, $id)
{
    // Uncomment and improve validation for the signature note
    $request->validate([
        'signature-note' => 'string|max:1000', // Ensures it's a string and within the length limit
    ]);


    // Handle the text input
    if ($request->has('signature-note')) {
        $signatureNote = $request->input('signature-note'); // Retrieve the note text


        // Update the waybill record with the signature note
        Waybill::where('id', $id)->update(['signature_note' => $signatureNote]);

        return back()->with('success', 'Signature note uploaded successfully.');
    }

    // If no signature note is provided, return an error message
    return back()->with('error', 'No signature note provided.');
}*/

public function uploadSignatureNote(Request $request, $id)
{
    // Uncomment and improve validation for the signature note
    $request->validate([
        'sender_textSignature' => 'string|max:255|nullable', // Ensures it's a string and within the length limit
        'receiver_textSignature' => 'string|max:255|nullable'
    ]);

    Log::info('Upload Signature Note called!', [
        'waybillId' => $id,
        'details' => $request
    ]);

    // Handle the text input
    if ($request->has('receiver_textSignature')) {
        $receiver_textSignature = $request->input('receiver_textSignature'); // Retrieve the note text

        Log::info('receiver Signature Note Text:', [
            'waybillId' => $id,
            'receiver_textSignature' => $receiver_textSignature,
        ]);

        // Update the waybill record with the signature note
        Waybill::where('id', $id)->update(['receiver_textSignature' => $receiver_textSignature]);

        return response()->json(['success' => true, 'message' => 'Signature note uploaded successfully.']);
    }

    if ($request->has('sender_textSignature')) {
        $sender_textSignature = $request->input('sender_textSignature'); // Retrieve the note text

        Log::info('Signature Note Text:', [
            'waybillId' => $id,
            'sender_textSignature' => $sender_textSignature,
        ]);

        // Update the waybill record with the signature note
        Waybill::where('id', $id)->update(['sender_textSignature' => $sender_textSignature]);

        return response()->json(['success' => true, 'message' => 'Signature note uploaded successfully.']);
    }
    else{

    // If no signature note is provided, return an error message
    return back()->with('error', 'No signature note provided.');
    }
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

// public function waybillLabelPreview($id)
// {
//     $waybill = Waybill::with(['shipper', 'recipient', 'user.client'])->findOrFail($id);
//     $shipper = $waybill->shipper;
//     $recipient = $waybill->recipient;
//     return view('admin.waybills.waybillLabelPreview', compact('waybill', 'shipper', 'recipient'));
// }

public function waybillLabelPreview(Request $request, $id)
{
    $waybill = Waybill::with(['shipper', 'recipient', 'user.client'])->findOrFail($id);
    $shipper = $waybill->shipper;
    $recipient = $waybill->recipient;

    $labelCount = max(1, min(100, (int) $request->query('label_count', 1)));
    $labels = range(1, $labelCount);

    return view('admin.waybills.waybillLabelPreview', compact('waybill', 'shipper', 'recipient', 'labels'));
}


public function labelPreviewPdf(Request $request, $id)
{
    $waybill = Waybill::with(['shipper', 'recipient', 'user.client'])->findOrFail($id);
    $shipper = $waybill->shipper;
    $recipient = $waybill->recipient;
    $labelCount = max(1, min(100, (int) $request->query('label_count', 1)));

    // $html = view('admin.waybills.waybillLabelPdf', compact('waybill', 'shipper', 'recipient'))->render();

    $pdf = new Mpdf([
        'format' => [101.6, 152.4],
        'margin_left' => 3,
        'margin_right' => 3,
        'margin_top' => 3,
        'margin_bottom' => 3,
    ]);

    for ($i = 1; $i <= $labelCount; $i++) {
        $pdf->AddPage();
        $html = view(
            'admin.waybills.waybillLabelPdf',
            [
                'waybill'   => $waybill,
                'shipper'   => $shipper,
                'recipient' => $recipient,
                'pageNo'    => $i,
                'totalPage' => $labelCount,
            ]
        )->render();
        $pdf->WriteHTML($html);
    }

    $pdf->SetTitle('Bordereau #' . $waybill->id);
    $pdf->SetDisplayMode('fullpage');

    $filename = 'bordereau_' . str_pad($waybill->id, 7, '0', STR_PAD_LEFT) . '.pdf';
    return response($pdf->Output('', 'S'), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . $filename . '"',
    ]);
}

public function waybillPageView($waybillNumber) {
    // Fetch the waybill with its related shipper and recipient
    $waybill = Waybill::with(['shipper', 'recipient', 'driver'])->where('id', $waybillNumber)->first();
    // Check if the waybill exists
    if (!$waybill) {
        return 'This waybill does not exist';
    }

    // Extract shipper and recipient details
    $shipper = $waybill->shipper;
    $recipient = $waybill->recipient;
    $status = $waybill->status;

    // Log the shipper and recipient data
    Log::info('Waybill Info:', [
        'waybill_number' => $waybill->id,
        'shipper' => $shipper ? $shipper->toArray() : 'No shipper available',
        'recipient' => $recipient ? $recipient->toArray() : 'No recipient available',
    ]);

    // Pass all variables to the view
    return view('admin/waybills/waybillPageView', compact('waybill', 'shipper', 'recipient', 'status'));
    // return view('waybill', compact('waybill', 'shipper', 'recipient'));
    // return view('waybill');
    // return 'This waybill exists';
}

public function adminDeliveryCompleted(Request $request)
    {
        $date = $request->query('date', now()->format('Y-m-d'));
        /*$waybills = Waybill::with('recipient', 'shipper') // Eager load the related shipper (Client) data
        // ->where('user_id', \Auth::id())
        // ->where(function($query) {
        //     $query->where('delivery_status', 1);  // delivery_status == 3
        // })
        ->where('delivery_status', 1)
         ->whereDate('drop_time', $date)
        ->orderBy('drop_time', 'ASC')
        ->get();*/
        // return view('admin/waybills/deliverySummary', compact('waybills','date'));


         $waybills = Waybill::with(['recipient', 'shipper', 'driver']) // Include driver for name
        ->where('delivery_status', 1)
        ->whereDate('drop_time', $date)
        ->orderBy('driver_id', 'ASC')         // Group by driver
        ->orderBy('drop_time', 'ASC')         // Sort by delivery time within driver
        ->get();

         // driver details
        $drivers = User::whereHas('roles', function ($query) {
            $query->where('id', 3);  // Fetch only users with role id = 3
        })->get(['id', 'name']);
        return view('admin/waybills/deliverySummary', compact('waybills','date','drivers'));
    }

    public function adminWaybillsByDate(Request $request)
{
    $date = $request->query('date', now()->format('Y-m-d'));

    /*$waybills = Waybill::with(['recipient', 'shipper'])
        // ->where('user_id', auth()->id())
        // ->where('user_id', \Auth::id())
        // ->where('delivery_status', 1)
        // ->where(function($query) {
        //     $query->where('delivery_status', 1);  // delivery_status == 3
        // })
        ->where('delivery_status', 1)
        ->whereDate('drop_time', $date)
        ->orderBy('drop_time', 'ASC')
        ->get();*/


     $waybills = Waybill::with(['recipient', 'shipper', 'driver']) // Include driver for name
        ->where('delivery_status', 1)
        ->whereDate('drop_time', $date)
        ->orderBy('driver_id', 'ASC')         // Group by driver
        ->orderBy('drop_time', 'ASC')         // Sort by delivery time within driver
        ->get();


    // return response()->json([
    //     'waybills' => $waybills->map(function ($wb) {
    //         return [
    //             'id' => $wb->id,
    //             'shipper_name' => $wb->shipper->name ?? 'N/A',
    //             'shipper_address' => $wb->shipper->address ?? 'N/A',
    //             'recipient_name' => $wb->recipient->name ?? 'N/A',
    //             'recipient_address' => $wb->recipient->address ?? 'N/A',
    //         ];
    //     })
    // ]);

    return response()->json([
    'waybills' => $waybills->map(function ($wb) {
        $driverId = $wb->driver_id ?? null;
        $mappedDriverId = $driverId ? ($driverId == 99 ? '01' : ($driverId == 27 ? '20' : $driverId)) : null;
        return [
            'id' => $wb->id,
            'shipper_name' => $wb->shipper->name ?? 'N/A',
            'shipper_address' => $wb->shipper->address ?? 'N/A',
            'recipient_name' => $wb->recipient->name ?? 'N/A',
            'recipient_address' => $wb->recipient->address ?? 'N/A',
            'driver_id' => $mappedDriverId ?? null,
            'driver_name' => $wb->driver->name ?? 'Non assigné',
        ];
    // ])
    })
]);

}

public function markAsViewed($id)
{
    $waybill = Waybill::findOrFail($id);
    $waybill->is_new = 0;
    $waybill->save();

    return response()->json(['success' => true]);
}



/*public function adminByWaybillID(Request $request)
{
    Log::info('adminwaybill id search called');
    // $date = $request->query('date', now()->format('Y-m-d'));
    $soft_id = $request->input('id');

    $waybills = Waybill::with(['recipient', 'shipper'])
        // ->where('user_id', \Auth::id())
        ->where('soft_id',$soft_id)
        ->orderBy('date', 'desc')
        ->get();
    // Log::info('admin waybill search by id', $waybills);
    Log::info('admin waybill search by id', $waybills->toArray());

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
}*/
// new test
/*public function adminByWaybillID(Request $request)
{
    Log::info('adminwaybill id search called');

    $inputId = $request->input('id');

    // If user passes a prefixed id like ABC000123, extract the numeric suffix as soft_id
    if (preg_match('/(\d+)$/', $inputId, $matches)) {
        $soft_id = (int) $matches[1];
    } else {
        // fallback: try raw numeric input
        $soft_id = (int) $inputId;
    }

    $waybills = Waybill::with(['recipient', 'shipper', 'status'])
        ->where('soft_id', $soft_id)
        ->orderBy('date', 'desc')
        ->get();

    Log::info('admin waybill search by id', $waybills->toArray());

    return response()->json([
        'waybills' => $waybills->map(function ($wb) {
            // compute the displayed soft id (prefix + padded number)
            $prefix = $wb->shipper->prefix ?? ($wb->user->client->prefix ?? '');
            $formatted_soft_id = $prefix . str_pad($wb->soft_id, 6, '0', STR_PAD_LEFT);

            return [
                'id' => $wb->id,
                'soft_id' => $wb->soft_id,
                'formatted_soft_id' => $formatted_soft_id,
                'shipper_name' => $wb->shipper->name ?? 'N/A',
                'shipper_address' => $wb->shipper->address ?? 'N/A',
                'recipient_name' => $wb->recipient->name ?? 'N/A',
                'recipient_address' => $wb->recipient->address ?? 'N/A',
                'status_id' => $wb->status_id,
                'status_name' => optional($wb->status)->name ?? '',
                'status_color' => optional($wb->status)->color ?? '#808080',
                'delivery_status' => $wb->delivery_status,
                'date' => $wb->date ? \Carbon\Carbon::parse($wb->date)->toFormattedDateString() : null,
                'type' => $wb->type,
            ];
        })
    ]);
}*/

// update v2.0

public function adminByWaybillID_Old_working(Request $request)
{
    Log::info("==== adminByWaybillID CALLED ====");

    try {

        Log::info("Raw request input:", $request->all());

        $rawId = $request->input('id');
        Log::info("Raw ID received: " . $rawId);

        // Extract digits from something like ABC000123
        if (preg_match('/(\d+)$/', $rawId, $matches)) {
            $soft_id = (int) $matches[1];
        } else {
            $soft_id = (int) $rawId;
        }

        Log::info("Extracted soft_id = " . $soft_id);

        // Query
        $waybills = Waybill::with(['recipient', 'shipper', 'user.client'])
            ->where('soft_id', $soft_id)
            ->orderBy('date', 'desc')
            ->get();

        Log::info("Waybills found: " . $waybills->count());

        // If no results found
        if ($waybills->count() === 0) {
            Log::warning("No waybills found for soft_id: " . $soft_id);
        }

        $result = $waybills->map(function ($wb) {

            Log::info("Processing waybill ID: {$wb->id}");

            // SAFE PREFIX HANDLING
            $prefix = '';
            if ($wb->shipper && !empty($wb->shipper->prefix)) {
                $prefix = $wb->shipper->prefix;
            } elseif ($wb->user && $wb->user->client && !empty($wb->user->client->prefix)) {
                $prefix = $wb->user->client->prefix;
            }

            Log::info("Prefix for WB {$wb->id}: " . $prefix);

            $formatted_soft_id = $prefix . str_pad($wb->soft_id, 6, '0', STR_PAD_LEFT);

            // SAFE STATUS
            // $status_name = $wb->status->name ?? null;
            // $status_color = $wb->status->color ?? '#808080';

            /*Log::info("Status for WB {$wb->id}: " . json_encode([
                'name' => $status_name,
                'color' => $status_color
            ]));*/


            return [
                'id' => $wb->id,
                'soft_id' => $wb->soft_id,
                'formatted_soft_id' => $formatted_soft_id,
                'recipient_name' => $wb->recipient->name ?? 'N/A',
                'recipient_address' => $wb->recipient->address ?? 'N/A',
                'shipper_name' => $wb->shipper->name ?? 'N/A',
                'shipper_address' => $wb->shipper->address ?? 'N/A',
                'date' => $wb->date ? $wb->date->format('Y-m-d') : null,
                'delivery_status' => $wb->delivery_status,
                // 'status_name' => $status_name,
                // 'status_color' => $status_color,
                'type' => $wb->type,
            ];
        });

        Log::info("Final response:", $result->toArray());

        return response()->json([
            'success' => true,
            'waybills' => $result
        ]);

    } catch (\Throwable $e) {

        Log::error("ERROR in adminByWaybillID: " . $e->getMessage(), [
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}

// version 3.0

public function adminByWaybillID(Request $request)
{
    \Log::info("==== adminByWaybillID CALLED ====");

    try {
        \Log::info("Raw request input:", $request->all());

        $rawId = trim((string) $request->input('id', ''));
        \Log::info("Raw ID received: " . $rawId);

        // Normalize: remove non-alphanumeric except keep letters and digits
        $normalized = preg_replace('/[^A-Za-z0-9]/', '', $rawId);

        // Attempt to extract prefix (letters) and digits (soft id). Examples:
        // SP000657 -> prefix=SP, digits=000657 -> soft_id = 657
        // 000657   -> prefix=null, digits=000657 -> soft_id = 657
        // SP657    -> prefix=SP, digits=657
        $prefix = null;
        $soft_id = null;

        if (preg_match('/^([A-Za-z]+)?0*([0-9]+)$/', $normalized, $m)) {
            // m[1] may be set (letters), m[2] is digits (with leading zeros removed by cast)
            $prefix = isset($m[1]) && $m[1] !== '' ? strtoupper($m[1]) : null;
            $soft_id = isset($m[2]) && $m[2] !== '' ? (int) $m[2] : null;
        } else {
            // fallback: look for any trailing digits and leading letters
            if (preg_match('/([A-Za-z]+)(\d+)$/', $normalized, $m2)) {
                $prefix = strtoupper($m2[1]);
                $soft_id = (int) $m2[2];
            } elseif (preg_match('/(\d+)$/', $normalized, $m3)) {
                $soft_id = (int) $m3[1];
            } elseif (preg_match('/^([A-Za-z]+)$/', $normalized, $m4)) {
                // only prefix given (no digits)
                $prefix = strtoupper($m4[1]);
            }
        }

        \Log::info("Parsed search - prefix: " . ($prefix ?? 'NULL') . " soft_id: " . ($soft_id ?? 'NULL'));

        // Build query
        $query = \App\Models\Waybill::with(['recipient', 'shipper', 'user.client'])
            ->orderBy('updated_at', 'desc');

        // If a numeric soft_id exists, filter by it
        if (!is_null($soft_id)) {
            $query->where('soft_id', $soft_id);

            // If a prefix is present, also require that shipper.prefix OR user.client.prefix matches it
            if (!is_null($prefix)) {
                $query->where(function ($q) use ($prefix) {
                    // case-insensitive match; use UPPER() for portability
                    $q->whereHas('shipper', function ($s) use ($prefix) {
                        $s->whereRaw('UPPER(prefix) = ?', [$prefix]);
                    })->orWhereHas('user.client', function ($c) use ($prefix) {
                        $c->whereRaw('UPPER(prefix) = ?', [$prefix]);
                    });
                });
            }
        } else {
            // No digits found
            if (!is_null($prefix)) {
                // Option A: return all waybills with this prefix (uncomment if desired)
                // $query->where(function ($q) use ($prefix) {
                //     $q->whereHas('shipper', function ($s) use ($prefix) {
                //         $s->whereRaw('UPPER(prefix) = ?', [$prefix]);
                //     })->orWhereHas('user.client', function ($c) use ($prefix) {
                //         $c->whereRaw('UPPER(prefix) = ?', [$prefix]);
                //     });
                // });

                // For now, if no soft_id provided, return empty collection (safer)
                \Log::warning("No soft_id digits found in input and only prefix provided. Returning empty result by default.");
                $waybills = collect([]);
                $result = collect([]);
                return response()->json(['success' => true, 'waybills' => $result]);
            } else {
                // nothing meaningful => empty result
                \Log::warning("No digits or prefix found in input: " . $rawId);
                return response()->json(['success' => true, 'waybills' => []]);
            }
        }

        $waybills = $query->get();
        \Log::info("Waybills matched: " . $waybills->count());

        // Map and format for response
        $result = $waybills->map(function ($wb) {
            // Determine prefix to display (shipper > user.client)
            $prefix = '';
            /*if ($wb->shipper && !empty($wb->shipper->prefix)) {
                $prefix = $wb->shipper->prefix;
            } elseif ($wb->user && $wb->user->client && !empty($wb->user->client->prefix)) {
                $prefix = $wb->user->client->prefix;
            }*/
            if ($wb->user && $wb->user->client && !empty($wb->user->client->prefix)) {
                $prefix = $wb->user->client->prefix;
            }
            $formatted_soft_id = $prefix . str_pad($wb->soft_id, 6, '0', STR_PAD_LEFT);

            // delivery_status: return raw value (frontend will render) or you can format it here
            return [
                'id' => $wb->id,
                'soft_id' => $wb->soft_id,
                'formatted_soft_id' => $formatted_soft_id,
                'recipient_name' => $wb->recipient->name ?? 'N/A',
                'recipient_address' => $wb->recipient->address ?? 'N/A',
                'shipper_name' => $wb->shipper->name ?? 'N/A',
                'shipper_address' => $wb->shipper->address ?? 'N/A',
                'date' => $wb->date ? \Carbon\Carbon::parse($wb->date)->toFormattedDateString() : null,
                'updated_at' => $wb->updated_at ? \Carbon\Carbon::parse($wb->updated_at)->toFormattedDateString() : null,
                'delivery_status' => $wb->delivery_status,
                'type' => $wb->type,
            ];
        });

        \Log::info("Final response count: " . $result->count());

        return response()->json(['success' => true, 'waybills' => $result]);
    } catch (\Throwable $e) {
        \Log::error("ERROR in adminByWaybillID: " . $e->getMessage(), [
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
    }
}





}
