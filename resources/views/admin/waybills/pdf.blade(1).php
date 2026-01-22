@section('col1')
    @php
        if ($status == 'tomorrow') {
        $color = '#8fdefb';
        } 
        elseif ($status == 'same_day') {
            $color = '#a6f4ee';
        } 
        elseif ($status == 'urgent') {
            $color = '#FEFBC0';
        } 
        elseif ($status == 'code_red') {
            $color = '#E8A7BF';
        }
        elseif ($status == 'very_urgent') {
            $color = '#F09286';
        }
        elseif ($status == 'night') {
            $color = '#E8A7BF';
        }  
        else {
            $color = '';
        }
        
    @endphp
    
    @role('admin')
    
    {{-- remove color from admin
    <div style="opacity: 45%; background-color: {{ $color }}"> --}}
    <div> 
    @else
    <div>
    @endrole
        <table width="100%">
            <tr>
                <td align="center">
                    <img src="data:image/png;base64,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" />
                </td>
            </tr>
            <tr>
                <td align="center">
                    (NIR): R5608402
                </td>
            </tr>
            <tr>
                <td style="border: 1mm solid black; padding: 10px; ">
                    <p><u>EXPÉDITEUR</u></p>
                    <table width="100%">
                        <tr>
                            <td><p>{{$shipper['name']}}</p></td>
                            <td><p>{{preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $shipper['phone']).(is_null($shipper['extension']) ? '' : 'x'.$shipper['extension'])}}</p></td>
                        </tr>
                        <tr>
                            <td colspan="2"><p>{{$shipper['address']}}</p></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table width="100%">
                                    <tr>
                                        <td align="left"><p>{{$shipper['city_name']}}</p></td>
                                        <td align="center"><p>{{$shipper['city_state']}}</p></td>
                                        <td align="right"><p>{{$shipper['postal_code']}}</p></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><p>{{$shipper_contact??$shipper['contact']??'Aucune information de contact supplémentaire'}}</p></td>
                        </tr>
                         <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                        <td colspan="2">
            
                                <p><b>Heures d’ouverture + Informations permanentes</b></p>
            
                                <p style="font-size:14px;" >{{$shipper_note??$shipper_note??'N/D'}}</p>
            
                            </td>
                         </tr>
                          {{--<tr>
                            <td>&nbsp;</td>
                        </tr>--}}   
                        {{--<tr>
                            <td colspan="2"><p>&nbsp;</p><p>&nbsp;</p></td>
                        </tr>--}}
                        <tr>
                            <td colspan="2"><p>Signature: _____________________________________ Heure: ____________</p></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td style="border: 1mm solid black; padding: 10px">
                    <p><u>DESTINATAIRE</u></p>
                    <table width="100%">
                        <tr>
                            <td><p>{{$recipient['name']}}</p></td>
                            <td><p>{{preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $recipient['phone']).(is_null($recipient['extension']) ? '' : 'x'.$recipient['extension'])}}</p></td>
                        </tr>
                        <tr>
                            <td colspan="2"><p>{{$recipient['address']}}</p></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table width="100%">
                                    <tr>
                                        <td align="left"><p>{{$recipient['city_name']}}</p></td>
                                        <td align="center"><p>{{$recipient['city_state']}}</p></td>
                                        <td align="right"><p>{{$recipient['postal_code']}}</p></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><p>{{$recipient_contact??$recipient['contact']??'Aucune information de contact supplémentaire'}}</p></td>
                        </tr>
                         <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                        <td colspan="2">
            
                                <p><b>Heures d’ouverture + Informations permanentes</b></p>
            
                                <p style="font-size:14px;">{{$recipient_note??$recipient_note??'N/D'}} </p>
            
                            </td>
                        </tr>
                         {{--<tr>
                            <td>&nbsp;</td>
                        </tr>--}}
                        {{--<tr>
                            <td colspan="2"><p>&nbsp;</p><p>&nbsp;</p></td>
                        </tr>--}}
                        <tr>
                            <td colspan="2"><p>Signature: _____________________________________ Heure: ____________</p></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding-top:20px;">
                    <p><b>Notes facultatives (Non permanentes)</b></p>
                    <p style="background: {{ isset($note_permanent) ? 'yellow' : 'white'}};font-size:4mm;">{{$note_permanent??'N/D'}}</p>
                </td>
            </tr>
        </table>
    </div>

@endsection

@section('col2')
                @php
                    /*if ($status == 'tomorrow') {
                    $color = '#8fdefb';
                    } 
                    elseif ($status == 'same_day') {
                        $color = '#a6f4ee';
                    } 
                    elseif ($status == 'urgent') {
                        $color = '#FDFD96';
                    } 
                    elseif ($status == 'code_red') {
                        $color = '#e3342f';
                    } 
                    else {
                        $color = '';
                    }*/

                    if ($status == 'tomorrow') {
        $color = '#8fdefb';
        } 
        elseif ($status == 'same_day') {
            $color = '#a6f4ee';
        } 
        elseif ($status == 'urgent') {
            $color = '#FEFBC0';
        } 
        elseif ($status == 'code_red') {
            $color = '#E8A7BF';
        }
        elseif ($status == 'very_urgent') {
            $color = '#F09286';
        }
        elseif ($status == 'night') {
            $color = '#E8A7BF';
        }  
        else {
            $color = '';
        }
                    
                @endphp
                @role('admin')
                {{-- it's color to admin view <div style="opacity: 45%; background-color: {{ $color }}"> --}}
                <div>
                    @else
                        <div>
                            @endrole
                            <table width="100%">
                                <tr>
                                    <td style="border: 1mm solid black; padding-right: 10px;">
                                        <table width="100%" >
                                            <tr>
                                                <td>
                                                    <p><u>DATE</u></p>
                                                    <p>{{ Carbon\Carbon::parse($date)->format('Y-m-d') }}</p>

                                                    <p>No. Client: {{str_pad($user['id'], 4, 0, STR_PAD_LEFT)}}</p>
                                                </td>
                                                <td valign="top">
                                                    <p><u>PAYÉ PAR:</u> <b>{{__('waybills.who_pay.'.$who_pay)}}</b></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <p>{{$description??'Aucune description'}}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 30px">
                                        <table width="100%" cellpadding="5" cellspacing="5" style="border: 1mm solid black; padding: 10px;">
                                            <tr>
                                                <td style="border: 0.5mm solid black;" colspan="3" align="right">Coût</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 0.5mm solid black;" width="50%">Tarif</td>
                                                  @php
                                                    $formattedPrice = str_replace(',', '.', $price);
//                                                @endphp
{{--                                                @php--}}
{{--                                                    $setting = \App\Models\Setting::where('user_id', $user_id)->first();--}}
{{--                                                @endphp--}}
                                                <td style="border: 0.5mm solid black;" width="25%">
                                                    @role('admin')
                                                         {{ number_format(floatval($formattedPrice), 2) }} $
                                                    @else
                                                        @if($submission_status == 0 && $price != null)
                                                            {{ number_format(floatval($formattedPrice), 2) }} $
                                                        @endif
                                                    @endrole

                                                </td>
{{--                                                @if(isset($setting) && $setting->show_price)--}}
{{--                                                    <td style="border: 0.5mm solid black;" width="25%">{{$cost_2}}</td>--}}
{{--                                                @else--}}
{{--                                                    <td style="border: 0.5mm solid black;" width="25%"></td>--}}
{{--                                                @endif--}}

                                                @role('admin')
                                                    <td style="border: 0.5mm solid black;" width="25%">{{$cost_2}}</td>
                                                @else
                                                    @if($submission_status == 0)
                                                        <td style="border: 0.5mm solid black;" width="25%"></td>
                                                    @endif
                                                @endrole

                                            </tr>
                                            <tr>
                                                <td style="border: 0.5mm solid black;">Matière dangereuse</td>
                                                <td style="border: 0.5mm solid black;">{{$hazardous_materials_1}}</td>
                                                <td style="border: 0.5mm solid black;">{{$hazardous_materials_2}}</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 0.5mm solid black;">Poids (lbs)</td>
                                                <td style="border: 0.5mm solid black;">{{$weight_1}}</td>
                                                <td style="border: 0.5mm solid black;">{{$weight_2}}</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 0.5mm solid black;">Cubage</td>
                                                <td style="border: 0.5mm solid black;">{{$cubing_1}}</td>
                                                <td style="border: 0.5mm solid black;">{{$cubing_2}}</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 0.5mm solid black;">Aller/retour</td>
                                                <td style="border: 0.5mm solid black;">{{$waiting_time_1}}</td>
                                                <td style="border: 0.5mm solid black;">{{$waiting_time_2}}</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 0.5mm solid black;">Temps d’attente</td>
                                                <td style="border: 0.5mm solid black;">{{$round_trip_1}}</td>
                                                <td style="border: 0.5mm solid black;">{{$round_trip_2}}</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 0.5mm solid black;">Camion</td>
                                                <td style="border: 0.5mm solid black;">{{$truck_1}}</td>
                                                <td style="border: 0.5mm solid black;">{{$truck_2}}</td>
                                            </tr>
                                            
                                            <tr>
                                                <td style="border: 0.5mm solid black;">Tailgate</td>
                                                <td style="border: 0.5mm solid black;">{{$tailgate_1 ?? " "}}</td>
                                                <td style="border: 0.5mm solid black;">{{$tailgate_2 ?? " "}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="right">Total</td>
                                                <td style="border: 0.5mm solid black;">{{$total}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="right">No.</td>
                                                <td style="border: 0.5mm solid black;">{{$user["client"]["prefix"].str_pad($soft_id, 6, 0, STR_PAD_LEFT)}}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p style="font-size: 9mm;">Type d’envoi : <b style="background:yellow"><u>{{__("waybills.status.$status")}}</u></b></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 5px">
                                        <p>Chauffeur: ________________________________ </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td  style="padding-bottom: 5px;">
                                        <p>Chauffeur: ________________________________  Date: ______________</p>
                                    </td>
                                </tr>

                            </table>
                        </div>
                </div>
@endsection
