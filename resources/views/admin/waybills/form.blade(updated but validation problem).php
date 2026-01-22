@role('admin'||'client')

    @if(isset($model) && request()->is('admin/waybills/'.$model->id.'/edit'))

        @if(isset($model->statusModel->color))

            <style>

                .content {

                    background-color: {{ $model->statusModel->color }} !important;

                    opacity: 1;

                }

                .content-header{

                    background-color: {{ $model->statusModel->color }} !important;

                    opacity: 1;

                }

                body{

                    background-color: {{ $model->statusModel->color }} !important;

                    opacity: 1;

                }

            </style>

        @endif

        @for($i=$counter??0; $i <= old('counter', $counter??0); $i++)

            <div class="container">

                <div class="row">

                    <div class="col-sm">

                        <div class="text-center">

                            <img src='{{asset('images/COURRIER.png')}}' style="max-width:100%"/>

                        </div>

                        @php

                            $readonly_shipper = (isset($model->shipper_id) && !is_null($model->shipper_id)) || !is_null(old($i.'.shipper_id'));

                        @endphp

                        <fieldset id="{{ $i }}_shipper" @if($errors->has('shipper_id')) style="border-color:red; color:red;" @endif>


                            <p><u>EXPÉDITEUR</u> <button type="button" class="btn btn-sm btn-danger {{$readonly_shipper?'':'d-none'}}" id="btn-{{$i}}-change-shipper">Changer d'expéditeur</button><span class="badge badge-info {{$readonly_shipper?'d-none':''}}" id="badge-{{$i}}-new-shipper">Un nouveau client sera créé</span></p>



                            {!! Form::hidden('waybill_type', Request::query('waybill')) !!}

                            {!! Form::hidden($i.'.shipper_id') !!}

                            <div class="row">

                                <div class="col-sm-6">

                                    {!! Form::text($i.'.shipper.name')->placeholder('Nom')->autocomplete('chrome-off')->readonly($readonly_shipper) !!}

                                </div>

                                <div class="col-sm-3">

                                    {!! Form::text($i.'.shipper.phone')->placeholder('Téléphone')->readonly($readonly_shipper) !!}

                                </div>

                                <div class="col-sm-3">

                                    {!! Form::text($i.'.shipper.extension')->placeholder('Extension')->readonly($readonly_shipper) !!}

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm">

                                    {!! Form::text($i.'.shipper.address')->placeholder('Adresse')->readonly($readonly_shipper) !!}

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm">

                                    {!! Form::text($i.'.shipper.city_name')->placeholder('ville')->readonly($readonly_shipper) !!}

                                    {{-- {!! Form::hidden($i.'.shipper.city_id') !!}

                                    {!! Form::select($i.'.shipper.city_id')->options($cities)->placeholder('Ville')->disabled($readonly_shipper) !!} --}}

                                </div>

                                <div class="col-sm">


                                    {!! Form::text($i.'.shipper.city_state')->placeholder('Province')->readonly($readonly_shipper) !!}

                                </div>

                                <div class="col-sm">

                                    {!! Form::text($i.'.shipper.postal_code')->placeholder('code postal')->readonly($readonly_shipper) !!}

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm">

                                    {!! Form::text($i.'.shipper.contact')->placeholder('contact') !!}

                                </div>

                            </div>

                            <div class="row">
                                    <div class="col-sm">

                                    {!! Form::text($i.'.shipper_note','Heures d’ouverture + Informations permanentes:')->placeholder('')->readonly($readonly_shipper) !!}

                                    </div>
                                </div>

                        </fieldset>



                        @php

                            $readonly_recipient = (isset($model->recipient_id) && !is_null($model->recipient_id)) || !is_null(old($i.'.recipient_id'));

                        @endphp

                        <fieldset id="{{$i}}_recipient" class="my-3" {!! $errors->has('recipient_id') ? 'style="border-color:red;color:red"' : '' !!}>

                            <p><u>DESTINATAIRE</u> <button type="button" class="btn btn-sm btn-danger {{$readonly_recipient?'':'d-none'}}" id="btn-{{$i}}-change-recipient">Changer de destinataire</button><span class="badge badge-info {{$readonly_recipient?'d-none':''}}" id="badge-{{$i}}-new-recipient">Un nouveau client sera créé</span></p>

                            {!! Form::hidden($i.'.recipient_id') !!}

                            <div class="row">

                                <div class="col-sm-6">

                                    {!! Form::text($i.'.recipient.name')->placeholder('Nom')->readonly($readonly_recipient) !!}

                                </div>

                                <div class="col-sm-3">

                                    {!! Form::text($i.'.recipient.phone')->placeholder('Téléphone')->readonly($readonly_recipient) !!}

                                </div>

                                <div class="col-sm-3">

                                    {!! Form::text($i.'.recipient.extension')->placeholder('Extension')->readonly($readonly_recipient) !!}

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm">

                                    {!! Form::text($i.'.recipient.address')->placeholder('Adresse')->readonly($readonly_recipient) !!}

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm">

                                    {!! Form::text($i.'.recipient.city_name')->placeholder('ville')->readonly($readonly_recipient) !!}

                                    {{-- {!! Form::hidden($i.'.recipient.city_id') !!}

                                    {!! Form::select($i.'.recipient.city_id')->options($cities)->placeholder('Ville')->disabled($readonly_recipient) !!} --}}

                                </div>

                                <div class="col-sm">

                                    {{-- {!! Form::text($i.'.recipient.state', null, 'Québec')->readonly(true) !!} --}}

                                    {!! Form::text($i.'.recipient.city_state')->placeholder('Province')->readonly($readonly_recipient) !!}

                                </div>

                                <div class="col-sm">

                                    {!! Form::text($i.'.recipient.postal_code')->placeholder('code postal')->readonly($readonly_recipient) !!}

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm">

                                    {!! Form::text($i.'.recipient.contact')->placeholder('contact') !!}

                                </div>

                            </div>

                            <div class="row">
                                    <div class="col-sm">

                                    {!! Form::text($i.'.recipient_note', 'Heures d’ouverture + Informations permanentes:')->placeholder('')->readonly($readonly_shipper) !!}

                                    </div>
                                </div>

                        </fieldset>

                        {!! Form::textarea($i.'.note_permanent', 'Notes facultatives (Non permanentes)',null, ['maxlength' => 95])->placeholder("Cubages supplémentaires pour marchandises multiples, #P.O, #Commande, #Référence, etc") !!}



                    </div>

                    <div class="col-sm">

                        <fieldset>

                            <div class="container">

                                <div class="row">

                                    <div class="col-sm-7">

                                        <p><u>DATE</u></p>

                                        {!! Form::date($i.'.date') !!}


                                        {!! Form::text('user_id', null, str_pad(Auth::id(), 4, 0, STR_PAD_LEFT))->disabled(true)->readonly(true)->placeholder('Numéro de client')!!}


                                        {!! Form::textarea($i.'.description')->placeholder('Qu’est-ce que vous envoyez? Colis/Boîte/Palette.') !!}





                                    </div>

                                    <div class="col-sm-5">

                                        <fieldset class="fullinput">

                                            <p><u>PAYÉ PAR</u></p>

                                            {!! Form::radio($i.'.who_pay', 'Expéditeur', 'shipper') !!}

                                            {!! Form::radio($i.'.who_pay', 'Destinataire', 'recipient') !!}

                                            {!! Form::radio($i.'.who_pay', 'Autre', 'other') !!}

                                        </fieldset>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-sm-12">

                                    </div>

                                </div>

                            </div>

                        </fieldset>

                        <fieldset class="fullinput" style="border:0">

                            <div class="row">

                                <div class="col-sm text-right bordered pr-1">

                                    Coût

                                </div>

                            </div>

                            <div class="row bordered">

                                <div class="col-sm-4">Tarif</div>

                                <div class="col-sm-4">{!! Form::text($i.'.cost_1') !!}</div>

                                <div class="col-sm-4">{!! Form::text($i.'.cost_2')->readonly(true) !!}</div>

                            </div>

                            <div class="row bordered">

                                <div class="col-sm-4">Matière dangereuse (Kg)</div>

                                <div class="col-sm-4">{!! Form::text($i.'.hazardous_materials_1') !!}</div>

                                <div class="col-sm-4">{!! Form::text($i.'.hazardous_materials_2')->readonly(true) !!}</div>

                            </div>

                            <div class="row bordered">

                                <div class="col-sm-4">Poids (lbs)</div>

                                <div class="col-sm-4">{!! Form::text($i.'.weight_1') !!}</div>

                                <div class="col-sm-4">{!! Form::text($i.'.weight_2')->readonly(true) !!}</div>

                            </div>

                            <div class="row bordered">

                                <div class="col-sm-4">Cubage</div>

                                <div class="col-sm-4">{!! Form::text($i.'.cubing_1') !!}</div>

                                <div class="col-sm-4">{!! Form::text($i.'.cubing_2')->readonly(true) !!}</div>

                            </div>

                            <div class="row bordered">

                                <div class="col-sm-4">Temps d’attente</div>

                                <div class="col-sm-4">{!! Form::text($i.'.waiting_time_1') !!}</div>

                                <div class="col-sm-4">{!! Form::text($i.'.waiting_time_2')->readonly(true) !!}</div>

                            </div>

                            <div class="row bordered">

                                <div class="col-sm-4">Aller/retour</div>

                                <div class="col-sm-4">{!! Form::checkbox($i.'.round_trip_1', null, 1) !!}</div>

                                <div class="col-sm-4">{!! Form::text($i.'.round_trip_2')->readonly(true) !!}</div>

                            </div>

                            <div class="row bordered">

                                <div class="col-sm-4">Camion</div>

                                <div class="col-sm-4">{!! Form::text($i.'.truck_1') !!}</div>

                                <div class="col-sm-4">{!! Form::text($i.'.truck_2')->readonly(true) !!}</div>

                            </div>
                            
                            <div class="row bordered">

                                <div class="col-sm-4">Tailgate</div>
    
                                <div class="col-sm-4">{!! Form::text($i.'.tailgate_1') !!}</div>
    
                                <div class="col-sm-4">{!! Form::text($i.'.tailgate_2')->readonly(true) !!}</div>

                            </div>

                            <div class="row bordered">

                                <div class="col-sm-8 text-right">TOTAL</div>

                                <div class="col-sm-4">{!! Form::text($i.'.total')->readonly(true) !!}</div>

                            </div>

                            <div class="row bordered">

                                <div class="col-sm-8 text-right">No.</div>

                                <div class="col-sm-4">

                                    @if(isset($model) && $model->user->client->prefix)

                                        {!! Form::text($i.'.soft_id')->value(isset($model) ? $model->user->client->prefix.str_pad($model->soft_id, 6, 0, STR_PAD_LEFT) : (\Auth::user()->client->prefix??"??")."000000")->readonly(true)->disabled(true) !!}


                                    @endif



                                </div>

                            </div>



                            @if($model->type == 1)

                                <div class="row bordered">

                                    <div class="col-sm-8 text-right">Price.</div>

                                    <div class="col-sm-4">

                                        @if(isset($model))

                                            {!! Form::text($i.'.price')  !!}

                                        @else

                                        @endif

                                    </div>

                                </div>

                            @endif





                        </fieldset>

                    </div>

                </div>

                <div class="row m-0">

                    <div class="col-sm text-center bordered">{!! Form::radio($i.'.status', __('waybills.status.night'), 'night') !!}</div>

                    <div class="col-sm text-center bordered">{!! Form::radio($i.'.status', __('waybills.status.code_red'), 'code_red') !!}</div>

                    <div class="col-sm text-center bordered">{!! Form::radio($i.'.status', __('waybills.status.very_urgent'), 'very_urgent') !!}</div>

                    <div class="col-sm text-center bordered">{!! Form::radio($i.'.status', __('waybills.status.urgent'), 'urgent') !!}</div>

                    <div class="col-sm text-center bordered">{!! Form::radio($i.'.status', __('waybills.status.same_day'), 'same_day') !!}</div>

                    <div class="col-sm text-center bordered">{!! Form::radio($i.'.status', __('waybills.status.tomorrow'), 'tomorrow') !!}</div>

                </div>

                <div id="alert-{{$i}}-status" style="display:none" class="my-5 alert alert-warning text-center">Vous devez nous contacter par téléphone pour placer votre envois, mais l'application vous permet d'imprimer le document pour mettre avec votre commande.</div>

                @role('admin')

                <div class="row m- mt-5">

                    <div class="col-3">

                        {!! Form::hidden($i.'.status_id') !!}

                        {!! Form::select($i.'.status_id')->options($statuses)->placeholder('Choisir Statut')!!}

                    </div>

                    <div class="col-3">

                        {!! Form::hidden($i.'.dispatch_id') !!}

                        {!! Form::select($i.'.dispatch_id')->options($dispatches)->placeholder('Choisir Dispatch')!!}

                    </div>



                    <div class="col-3">

                        {!! Form::hidden($i.'.driver_id') !!}

                        {!! Form::select($i.'.driver_id')->options($drivers)->placeholder('Choisir Chauffeur')!!}

                    </div>



                    {{-- <div class="col-3">

                        {!! Form::hidden($i.'.delivery_status') !!}

                        {!! Form::select($i.'.delivery_status')->options([

                          '1' => 'ramassée',

                          '2' => 'en cours',

                          '3' => 'livraison',

                        ])->placeholder('Status livraison')!!}

                    </div> --}}

                </div>

                @endrole

            </div>

            <hr class="my-5" />

        @endfor

@elseif (request()->is('admin/waybills/create') && request()->query('waybill') == 'true' && request()->query('mode') == 'rapid')


    @for($i=$counter??0; $i <= old('counter', $counter??0); $i++)

        <div class="container">

            <div class="row">

                <div class="col-sm">

                    <div class="text-center">

                        <img src='{{asset('images/COURRIER.png')}}' style="max-width:100%"/>

                    </div>

                    @php

                        $readonly_shipper = (isset($model->shipper_id) && !is_null($model->shipper_id)) || !is_null(old($i.'.shipper_id'));

                    @endphp

                    <fieldset id="{{$i}}_shipper" {!! $errors->has('shipper_id') ? 'style="border-color:red;color:red"' : '' !!}>

                        <p><u>EXPÉDITEUR</u> <button type="button" class="btn btn-sm btn-danger {{$readonly_shipper?'':'d-none'}}" id="btn-{{$i}}-change-shipper">Changer d'expéditeur</button><span class="badge badge-info {{$readonly_shipper?'d-none':''}}" id="badge-{{$i}}-new-shipper">Un nouveau client sera créé</span></p>



                        {!! Form::hidden($i.'.waybill_type', Request::query('waybill')) !!}



                        {!! Form::hidden($i.'.shipper_id') !!}

                        <div class="row">

                            <div class="col-sm-6">

                                {!! Form::text($i.'.shipper.name')->placeholder('Nom')->autocomplete('chrome-off')->readonly($readonly_shipper) !!}

                            </div>

                            <div class="col-sm-3">

                                {!! Form::text($i.'.shipper.phone')->placeholder('Téléphone')->readonly($readonly_shipper) !!}

                            </div>

                            <div class="col-sm-3">

                                {!! Form::text($i.'.shipper.extension')->placeholder('Extension')->readonly($readonly_shipper) !!}

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm">

                                {!! Form::text($i.'.shipper.address')->placeholder('Adresse')->readonly($readonly_shipper) !!}

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm">

                                {!! Form::text($i.'.shipper.city_name')->placeholder('ville')->readonly($readonly_shipper) !!}

                                {{-- {!! Form::hidden($i.'.shipper.city_id') !!}

                                {!! Form::select($i.'.shipper.city_id')->options($cities)->placeholder('Ville')->disabled($readonly_shipper) !!} --}}

                            </div>

                            <div class="col-sm">

                                {!! Form::text($i.'.shipper.city_state')->placeholder('Province')->readonly($readonly_shipper) !!}

                                {{-- {!! Form::text($i.'.shipper.state', null, 'Québec')->readonly(true) !!} --}}

                            </div>

                            <div class="col-sm">

                                {!! Form::text($i.'.shipper.postal_code')->placeholder('code postal')->readonly($readonly_shipper) !!}

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm">

                                {!! Form::text($i.'.shipper.contact')->placeholder('contact') !!}

                            </div>

                        </div>

                        <div class="row">
                                    <div class="col-sm">

                                    {!! Form::text($i.'.shipper_note','Heures d’ouverture + Informations permanentes:')->placeholder('')->readonly($readonly_shipper) !!}

                                    </div>
                                </div>

                    </fieldset>



                    @php

                        $readonly_recipient = (isset($model->recipient_id) && !is_null($model->recipient_id)) || !is_null(old($i.'.recipient_id'));

                    @endphp

                    <fieldset id="{{$i}}_recipient" class="my-3" {!! $errors->has('recipient_id') ? 'style="border-color:red;color:red"' : '' !!}>

                        <p><u>DESTINATAIRE</u> <button type="button" class="btn btn-sm btn-danger {{$readonly_recipient?'':'d-none'}}" id="btn-{{$i}}-change-recipient">Changer de destinataire</button><span class="badge badge-info {{$readonly_recipient?'d-none':''}}" id="badge-{{$i}}-new-recipient">Un nouveau client sera créé</span></p>

                        {!! Form::hidden($i.'.recipient_id') !!}

                        <div class="row">

                            <div class="col-sm-6">

                                {!! Form::text($i.'.recipient.name')->placeholder('Nom')->readonly($readonly_recipient) !!}

                            </div>

                            <div class="col-sm-3">

                                {!! Form::text($i.'.recipient.phone')->placeholder('Téléphone')->readonly($readonly_recipient) !!}

                            </div>

                            <div class="col-sm-3">

                                {!! Form::text($i.'.recipient.extension')->placeholder('Extension')->readonly($readonly_recipient) !!}

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm">

                                {!! Form::text($i.'.recipient.address')->placeholder('Adresse')->readonly($readonly_recipient) !!}

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm">

                                {!! Form::text($i.'.recipient.city_name')->placeholder('ville')->readonly($readonly_recipient) !!}

                                {{-- {!! Form::hidden($i.'.recipient.city_id') !!}

                                {!! Form::select($i.'.recipient.city_id')->options($cities)->placeholder('Ville')->disabled($readonly_recipient) !!} --}}

                            </div>

                            <div class="col-sm">

                                {!! Form::text($i.'.recipient.city_state')->placeholder('Province')->readonly($readonly_recipient) !!}

                                {{-- {!! Form::text($i.'.recipient.state', null, 'Québec')->readonly(true) !!} --}}

                            </div>

                            <div class="col-sm">

                                {!! Form::text($i.'.recipient.postal_code')->placeholder('code postal')->readonly($readonly_recipient) !!}

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm">

                                {!! Form::text($i.'.recipient.contact')->placeholder('contact') !!}

                            </div>

                        </div>

                        <div class="row">
                                    <div class="col-sm">

                                    {!! Form::text($i.'.recipient_note','Heures d’ouverture + Informations permanentes')->placeholder('')->readonly($readonly_shipper) !!}

                                    </div>
                                </div>

                    </fieldset>

{{--                    {!! Form::textarea($i.'.details', 'Détails Qte:')->placeholder('Heures d\'ouverture, PO etc...') !!}--}}

                    {!! Form::textarea($i.'.note_permanent','Notes facultatives (Non permanentes)',null,['maxlength' => 95])->placeholder("Cubages supplémentaires pour marchandises multiples, #P.O, #Commande, #Référence, etc.") !!}



                </div>

                <div class="col-sm">

                    <fieldset>

                        <div class="container">

                            <div class="row">

                                <div class="col-sm-7">

                                    <p><u>DATE</u></p>

                                    {!! Form::date($i.'.date') !!}





    {!! Form::text('user_id',null)->placeholder('Numéro de client') !!}



                                    {!! Form::textarea($i.'.description')->placeholder('Qu’est-ce que vous envoyez? Colis/Boîte/Palette.') !!}





                                </div>

                                <div class="col-sm-5">

                                    <fieldset class="fullinput">

                                        <p><u>PAYÉ PAR</u></p>

                                        {!! Form::radio($i.'.who_pay', 'Expéditeur', 'shipper') !!}

                                        {!! Form::radio($i.'.who_pay', 'Destinataire', 'recipient') !!}

                                        {!! Form::radio($i.'.who_pay', 'Autre', 'other') !!}

                                    </fieldset>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm-12">

                                </div>

                            </div>

                        </div>

                    </fieldset>

                    <fieldset class="fullinput" style="border:0">

                        <div class="row">

                            <div class="col-sm text-right bordered pr-1">

                                Coût

                            </div>

                        </div>

                        <div class="row bordered">

                            <div class="col-sm-4">Tarif</div>

                            <div class="col-sm-4">{!! Form::text($i.'.cost_1') !!}</div>

                            <div class="col-sm-4">{!! Form::text($i.'.cost_2')->readonly(true) !!}</div>

                        </div>

                        <div class="row bordered">

                            <div class="col-sm-4">Matière dangereuse (Kg)</div>

                            <div class="col-sm-4">{!! Form::text($i.'.hazardous_materials_1') !!}</div>

                            <div class="col-sm-4">{!! Form::text($i.'.hazardous_materials_2')->readonly(true) !!}</div>

                        </div>

                        <div class="row bordered">

                            <div class="col-sm-4">Poids (lbs)</div>

                            <div class="col-sm-4">{!! Form::text($i.'.weight_1') !!}</div>

                            <div class="col-sm-4">{!! Form::text($i.'.weight_2')->readonly(true) !!}</div>

                        </div>

                        <div class="row bordered">

                            <div class="col-sm-4">Cubage</div>

                            {{--<div class="col-sm-4">{!! Form::text($i.'.cubing_1') !!}</div>
                            <div class="col-sm-4">{!! Form::textarea($i.'.cubing_1', null, null, ['rows' => 2]) !!}</div>--}}
                            <div class="col-sm-4 position-relative">
                                <textarea
                                    name="{{ $i }}[cubing_1]"
                                    id="inp-{{ $i }}-cubing_1"
                                    class="form-control cubing-input"
                                    rows="2"
                                    style="resize: vertical"
                                    placeholder="Max 2 lines allowed"
                                ></textarea>
                            
                                <div class="line-limit-warning text-danger position-absolute top-0 start-0 bg-white px-2 py-1 d-none" style="z-index: 10; font-size: 12px;">
                                    ⚠️ Max 2 lines allowed
                                </div>
                            </div>


                            <div class="col-sm-4">{!! Form::text($i.'.cubing_2')->readonly(true) !!}</div>

                        </div>

                        <div class="row bordered">

                            <div class="col-sm-4">Temps d’attente</div>

                            <div class="col-sm-4">{!! Form::text($i.'.waiting_time_1') !!}</div>

                            <div class="col-sm-4">{!! Form::text($i.'.waiting_time_2')->readonly(true) !!}</div>

                        </div>

                        <div class="row bordered">

                            <div class="col-sm-4">Aller/retour</div>

                            <div class="col-sm-4">{!! Form::checkbox($i.'.round_trip_1', null, 1) !!}</div>

                            <div class="col-sm-4">{!! Form::text($i.'.round_trip_2')->readonly(true) !!}</div>

                        </div>

                        <div class="row bordered">

                            <div class="col-sm-4">Camion</div>

                            <div class="col-sm-4">{!! Form::text($i.'.truck_1') !!}</div>

                            <div class="col-sm-4">{!! Form::text($i.'.truck_2')->readonly(true) !!}</div>

                        </div>
                        
                        <div class="row bordered">

                            <div class="col-sm-4">Tailgate</div>

                            <div class="col-sm-4">{!! Form::text($i.'.tailgate_1') !!}</div>

                            <div class="col-sm-4">{!! Form::text($i.'.tailgate_2')->readonly(true) !!}</div>

                        </div>

                        <div class="row bordered">

                            <div class="col-sm-8 text-right">TOTAL</div>

                            <div class="col-sm-4">{!! Form::text($i.'.total')->readonly(true) !!}</div>

                        </div>

                        <div class="row bordered">

                            <div class="col-sm-8 text-right">No.</div>

                            <div class="col-sm-4">

                                @if(isset($model) && $model->user->client->prefix)

                                    {!! Form::text($i.'.soft_id')->value(isset($model) ? $model->user->client->prefix.str_pad($model->soft_id, 6, 0, STR_PAD_LEFT) : (\Auth::user()->client->prefix??"??")."000000")->readonly(true)->disabled(true) !!}

                                @else

                                @endif



                            </div>

                        </div>

                    </fieldset>

                </div>

            </div>

            <div class="row m-0">

                <div class="col-sm text-center bordered">{!! Form::radio($i.'.status', __('waybills.status.night'), 'night') !!}</div>

                <div class="col-sm text-center bordered">{!! Form::radio($i.'.status', __('waybills.status.code_red'), 'code_red') !!}</div>

                <div class="col-sm text-center bordered">{!! Form::radio($i.'.status', __('waybills.status.very_urgent'), 'very_urgent') !!}</div>

                <div class="col-sm text-center bordered">{!! Form::radio($i.'.status', __('waybills.status.urgent'), 'urgent') !!}</div>

                <div class="col-sm text-center bordered">{!! Form::radio($i.'.status', __('waybills.status.same_day'), 'same_day') !!}</div>

                <div class="col-sm text-center bordered">{!! Form::radio($i.'.status', __('waybills.status.tomorrow'), 'tomorrow') !!}</div>

            </div>

            <div id="alert-{{$i}}-status" style="display:none" class="my-5 alert alert-warning text-center">Vous devez nous contacter par téléphone pour placer votre envois, mais l'application vous permet d'imprimer le document pour mettre avec votre commande.</div>

            @role('admin')

            <div class="row m-4 mt-5">

                <div class="col-4">

                    {!! Form::hidden($i.'.status_id') !!}

                    {!! Form::select($i.'.status_id')->options($statuses)->placeholder('Choisir Statut')!!}

                </div>

                <div class="col-4">

                    {!! Form::hidden($i.'.dispatch_id') !!}

                    {!! Form::select($i.'.dispatch_id')->options($dispatches)->placeholder('Choisir Dispatch')!!}

                </div>



                <div class="col-4">

                    {!! Form::hidden($i.'.driver_id') !!}

                    {!! Form::select($i.'.driver_id')->options($drivers)->placeholder('Choisir Chauffeur')!!}

                </div>

            </div>

            @endrole

        </div>

        <hr class="my-5" />

    @endfor
@else

@for($i=$counter??0; $i <= old('counter', $counter??0); $i++)

        <div class="container">

            <div class="row">

                <div class="col-sm">

                    <div class="text-center">

                        <img src='{{asset('images/COURRIER.png')}}' style="max-width:100%"/>

                    </div>

                    @php

                        $readonly_shipper = (isset($model->shipper_id) && !is_null($model->shipper_id)) || !is_null(old($i.'.shipper_id'));

                    @endphp

                    <fieldset id="{{$i}}_shipper" {!! $errors->has('shipper_id') ? 'style="border-color:red;color:red"' : '' !!}>

                        <p><u>EXPÉDITEUR</u> <button type="button" class="btn btn-sm btn-danger {{$readonly_shipper?'':'d-none'}}" id="btn-{{$i}}-change-shipper">Changer d'expéditeur</button><span class="badge badge-info {{$readonly_shipper?'d-none':''}}" id="badge-{{$i}}-new-shipper">Un nouveau client sera créé</span></p>



                        {!! Form::hidden($i.'.waybill_type', Request::query('waybill')) !!}



                        {!! Form::hidden($i.'.shipper_id') !!}

                        <div class="row">

                            <div class="col-sm-6">

                                {!! Form::text($i.'.shipper.name')->placeholder('Nom')->autocomplete('chrome-off')->readonly($readonly_shipper) !!}

                            </div>

                            <div class="col-sm-3">

                                {!! Form::text($i.'.shipper.phone')->placeholder('Téléphone')->readonly($readonly_shipper) !!}

                            </div>

                            <div class="col-sm-3">

                                {!! Form::text($i.'.shipper.extension')->placeholder('Extension')->readonly($readonly_shipper) !!}

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm">

                                {!! Form::text($i.'.shipper.address')->placeholder('Adresse')->readonly($readonly_shipper) !!}

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm">

                                {!! Form::text($i.'.shipper.city_name')->placeholder('ville')->readonly($readonly_shipper) !!}

                                {{-- {!! Form::hidden($i.'.shipper.city_id') !!}

                                {!! Form::select($i.'.shipper.city_id')->options($cities)->placeholder('Ville')->disabled($readonly_shipper) !!} --}}

                            </div>

                            <div class="col-sm">

                                {!! Form::text($i.'.shipper.city_state')->placeholder('Province')->readonly($readonly_shipper) !!}

                                {{-- {!! Form::text($i.'.shipper.state', null, 'Québec')->readonly(true) !!} --}}

                            </div>

                            <div class="col-sm">

                                {!! Form::text($i.'.shipper.postal_code')->placeholder('code postal')->readonly($readonly_shipper) !!}

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm">

                                {!! Form::text($i.'.shipper.contact')->placeholder('contact') !!}

                            </div>

                        </div>

                        <div class="row">
                                    <div class="col-sm">

                                    {!! Form::text($i.'.shipper_note','Heures d’ouverture + Informations permanentes:')->placeholder('')->readonly($readonly_shipper) !!}

                                    </div>
                                </div>

                    </fieldset>



                    @php

                        $readonly_recipient = (isset($model->recipient_id) && !is_null($model->recipient_id)) || !is_null(old($i.'.recipient_id'));

                    @endphp

                    <fieldset id="{{$i}}_recipient" class="my-3" {!! $errors->has('recipient_id') ? 'style="border-color:red;color:red"' : '' !!}>

                        <p><u>DESTINATAIRE</u> <button type="button" class="btn btn-sm btn-danger {{$readonly_recipient?'':'d-none'}}" id="btn-{{$i}}-change-recipient">Changer de destinataire</button><span class="badge badge-info {{$readonly_recipient?'d-none':''}}" id="badge-{{$i}}-new-recipient">Un nouveau client sera créé</span></p>

                        {!! Form::hidden($i.'.recipient_id') !!}

                        <div class="row">

                            <div class="col-sm-6">

                                {!! Form::text($i.'.recipient.name')->placeholder('Nom')->readonly($readonly_recipient) !!}

                            </div>

                            <div class="col-sm-3">

                                {!! Form::text($i.'.recipient.phone')->placeholder('Téléphone')->readonly($readonly_recipient) !!}

                            </div>

                            <div class="col-sm-3">

                                {!! Form::text($i.'.recipient.extension')->placeholder('Extension')->readonly($readonly_recipient) !!}

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm">

                                {!! Form::text($i.'.recipient.address')->placeholder('Adresse')->readonly($readonly_recipient) !!}

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm">

                                {!! Form::text($i.'.recipient.city_name')->placeholder('ville')->readonly($readonly_recipient) !!}

                                {{-- {!! Form::hidden($i.'.recipient.city_id') !!}

                                {!! Form::select($i.'.recipient.city_id')->options($cities)->placeholder('Ville')->disabled($readonly_recipient) !!} --}}

                            </div>

                            <div class="col-sm">

                                {!! Form::text($i.'.recipient.city_state')->placeholder('Province')->readonly($readonly_recipient) !!}

                                {{-- {!! Form::text($i.'.recipient.state', null, 'Québec')->readonly(true) !!} --}}

                            </div>

                            <div class="col-sm">

                                {!! Form::text($i.'.recipient.postal_code')->placeholder('code postal')->readonly($readonly_recipient) !!}

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm">

                                {!! Form::text($i.'.recipient.contact')->placeholder('contact') !!}

                            </div>

                        </div>

                        <div class="row">
                                    <div class="col-sm">

                                    {!! Form::text($i.'.recipient_note','Heures d’ouverture + Informations permanentes')->placeholder('')->readonly($readonly_shipper) !!}

                                    </div>
                                </div>

                    </fieldset>

{{--                    {!! Form::textarea($i.'.details', 'Détails Qte:')->placeholder('Heures d\'ouverture, PO etc...') !!}--}}

                    {!! Form::textarea($i.'.note_permanent','Notes facultatives (Non permanentes)',null,['maxlength' => 95])->placeholder("Cubages supplémentaires pour marchandises multiples, #P.O, #Commande, #Référence, etc.") !!}



                </div>

                <div class="col-sm">

                    <fieldset>

                        <div class="container">

                            <div class="row">

                                <div class="col-sm-7">

                                    <p><u>DATE</u></p>

                                    {!! Form::date($i.'.date') !!}

                                    {!! Form::text('user_id', null, str_pad(Auth::id(), 4, 0, STR_PAD_LEFT))->disabled(true)->readonly(true)->placeholder('Numéro de client')!!}



                                    {!! Form::textarea($i.'.description')->placeholder('Qu’est-ce que vous envoyez? Colis/Boîte/Palette.') !!}





                                </div>

                                <div class="col-sm-5">

                                    <fieldset class="fullinput">

                                        <p><u>PAYÉ PAR</u></p>

                                        {!! Form::radio($i.'.who_pay', 'Expéditeur', 'shipper') !!}

                                        {!! Form::radio($i.'.who_pay', 'Destinataire', 'recipient') !!}

                                        {!! Form::radio($i.'.who_pay', 'Autre', 'other') !!}

                                    </fieldset>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm-12">

                                </div>

                            </div>

                        </div>

                    </fieldset>

                    <fieldset class="fullinput" style="border:0">

                        <div class="row">

                            <div class="col-sm text-right bordered pr-1">

                                Coût

                            </div>

                        </div>

                        <div class="row bordered">

                            <div class="col-sm-4">Tarif</div>

                            <div class="col-sm-4">{!! Form::text($i.'.cost_1') !!}</div>

                            <div class="col-sm-4">{!! Form::text($i.'.cost_2')->readonly(true) !!}</div>

                        </div>

                        <div class="row bordered">

                            <div class="col-sm-4">Matière dangereuse (Kg)</div>

                            <div class="col-sm-4">{!! Form::text($i.'.hazardous_materials_1') !!}</div>

                            <div class="col-sm-4">{!! Form::text($i.'.hazardous_materials_2')->readonly(true) !!}</div>

                        </div>

                        <div class="row bordered">

                            <div class="col-sm-4">Poids (lbs)</div>

                            <div class="col-sm-4">{!! Form::text($i.'.weight_1') !!}</div>

                            <div class="col-sm-4">{!! Form::text($i.'.weight_2')->readonly(true) !!}</div>

                        </div>

                        <div class="row bordered">

                            <div class="col-sm-4">Cubage</div>

                            {{--<div class="col-sm-4">{!! Form::text($i.'.cubing_1') !!}</div>
                            <div class="col-sm-4">{!! Form::textarea($i.'.cubing_1', null, null, ['rows' => 2]) !!}</div>--}}
                            <div class="col-sm-4 position-relative">
                                <textarea
                                    name="{{ $i }}[cubing_1]"
                                    id="inp-{{ $i }}-cubing_1"
                                    class="form-control cubing-input"
                                    rows="2"
                                    style="resize: vertical"
                                    placeholder="Max 2 lines allowed"
                                ></textarea>
                            
                                <div class="line-limit-warning text-danger position-absolute top-0 start-0 bg-white px-2 py-1 d-none" style="z-index: 10; font-size: 12px;">
                                    ⚠️ Max 2 lines allowed
                                </div>
                            </div>


                            <div class="col-sm-4">{!! Form::text($i.'.cubing_2')->readonly(true) !!}</div>

                        </div>

                        <div class="row bordered">

                            <div class="col-sm-4">Temps d’attente</div>

                            <div class="col-sm-4">{!! Form::text($i.'.waiting_time_1') !!}</div>

                            <div class="col-sm-4">{!! Form::text($i.'.waiting_time_2')->readonly(true) !!}</div>

                        </div>

                        <div class="row bordered">

                            <div class="col-sm-4">Aller/retour</div>

                            <div class="col-sm-4">{!! Form::checkbox($i.'.round_trip_1', null, 1) !!}</div>

                            <div class="col-sm-4">{!! Form::text($i.'.round_trip_2')->readonly(true) !!}</div>

                        </div>

                        <div class="row bordered">

                            <div class="col-sm-4">Camion</div>

                            <div class="col-sm-4">{!! Form::text($i.'.truck_1') !!}</div>

                            <div class="col-sm-4">{!! Form::text($i.'.truck_2')->readonly(true) !!}</div>

                        </div>
                        
                        <div class="row bordered">

                            <div class="col-sm-4">Tailgate</div>

                            <div class="col-sm-4">{!! Form::text($i.'.tailgate_1') !!}</div>

                            <div class="col-sm-4">{!! Form::text($i.'.tailgate_2')->readonly(true) !!}</div>

                        </div>

                        <div class="row bordered">

                            <div class="col-sm-8 text-right">TOTAL</div>

                            <div class="col-sm-4">{!! Form::text($i.'.total')->readonly(true) !!}</div>

                        </div>

                        <div class="row bordered">

                            <div class="col-sm-8 text-right">No.</div>

                            <div class="col-sm-4">

                                @if(isset($model) && $model->user->client->prefix)

                                    {!! Form::text($i.'.soft_id')->value(isset($model) ? $model->user->client->prefix.str_pad($model->soft_id, 6, 0, STR_PAD_LEFT) : (\Auth::user()->client->prefix??"??")."000000")->readonly(true)->disabled(true) !!}

                                @else

                                @endif



                            </div>

                        </div>

                    </fieldset>

                </div>

            </div>

            <div class="row m-0">

                <div class="col-sm text-center bordered">{!! Form::radio($i.'.status', __('waybills.status.night'), 'night') !!}</div>

                <div class="col-sm text-center bordered">{!! Form::radio($i.'.status', __('waybills.status.code_red'), 'code_red') !!}</div>

                <div class="col-sm text-center bordered">{!! Form::radio($i.'.status', __('waybills.status.very_urgent'), 'very_urgent') !!}</div>

                <div class="col-sm text-center bordered">{!! Form::radio($i.'.status', __('waybills.status.urgent'), 'urgent') !!}</div>

                <div class="col-sm text-center bordered">{!! Form::radio($i.'.status', __('waybills.status.same_day'), 'same_day') !!}</div>

                <div class="col-sm text-center bordered">{!! Form::radio($i.'.status', __('waybills.status.tomorrow'), 'tomorrow') !!}</div>

            </div>

            <div id="alert-{{$i}}-status" style="display:none" class="my-5 alert alert-warning text-center">Vous devez nous contacter par téléphone pour placer votre envois, mais l'application vous permet d'imprimer le document pour mettre avec votre commande.</div>

            @role('admin')

            <div class="row m-4 mt-5">

                <div class="col-4">

                    {!! Form::hidden($i.'.status_id') !!}

                    {!! Form::select($i.'.status_id')->options($statuses)->placeholder('Choisir Statut')!!}

                </div>

                <div class="col-4">

                    {!! Form::hidden($i.'.dispatch_id') !!}

                    {!! Form::select($i.'.dispatch_id')->options($dispatches)->placeholder('Choisir Dispatch')!!}

                </div>



                <div class="col-4">

                    {!! Form::hidden($i.'.driver_id') !!}

                    {!! Form::select($i.'.driver_id')->options($drivers)->placeholder('Choisir Chauffeur')!!}

                </div>

            </div>

            @endrole

        </div>

        <hr class="my-5" />

    @endfor


    @endif

@endrole

@push('js')

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.cubing-input').forEach(textarea => {
        const wrapper = textarea.closest('.position-relative');
        const warning = wrapper.querySelector('.line-limit-warning');
        let hideTimer;

        textarea.addEventListener('input', () => {
            let lines = textarea.value.split('\n');

            if (lines.length > 2) {
                textarea.value = lines.slice(0, 2).join('\n');
                warning.classList.remove('d-none');

                // Reset any previous timer
                clearTimeout(hideTimer);

                // Hide after 2 seconds
                hideTimer = setTimeout(() => {
                    warning.classList.add('d-none');
                }, 2000);
            } else {
                warning.classList.add('d-none');
            }
        });
    });
});
</script>

@endpush

