{{--


-> feature mira client waybill move to mira client will assign from bottom box to direct mira terminer
bug fixed
=> driver 49 context menu double mira terminer above mira terminer it should be only terminer it's fixed now

--}}

{{-- version 5.6.12  production version--}}
{{--
dashboard client section saving bug fixed
    linked both contact for waybills table shipper_contact & clients table contacts
--}}

{{--
    global position save done for cheque & absent
    may create conflict for automation (status) & new waybill approval fixed
--}}

{{--
-> rapid waybills added
-> new popup for rapid waybills creation
-> added iframe on the button of rapid waybills
--}}

{{--

    version 5.6.8 local copied
    -> driver_flag added
    -> check driver module delivery_status update
    -> automate the movement of waybills from cells depending on status
    -> popup menu changig cells of waybills remove instantly bug fixed
--}}

{{--
    in production version debugging like alert is turned off
    Terminer function added
    driver id updates in the front end instantly
    new hour time set
    sticky note name & number switched position
    refresh button works fine
--}}

{{--
version 5.6.5 editaion:
multiple lines in notes
dashboard bug fixed:
-> waybill count fixed
-> custom text editable along side with waybill

--}}

{{--
version 5.6.6 editaion:
multiple lines in notes
dashboard bug fixed:
-> waybill count fixed
-> custom text editable along side with waybill
-> popup delete & bottom stickynote delete fixed
--}}

{{-- version 5.6.7 edition

-> only admin can view the dashboard user restriction added
-> driver delivery_status updated for pcikedup & delivered option manually from context menu (sub menu under each driver)

--}}



@extends('adminlte::page')

@section('title', ucfirst('Voir/Cacher prix'))

@section('content_header')
    <!-- <h1>Sticky Notes with Bootstrap Table</h1> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
@endsection

@section('content')
@role('admin')
@php

$guest_driver_name = $drivers->where('id', "99")->first()->name ?? "Guest Driver";
$guest_driver_phone = $drivers->where('id', "99")->first()->phone ?? "(???) ???-????";
// dump($guest_driver_phone);
if($guest_driver_phone == 'N/A'){
    $formatted_phone = $guest_driver_phone;
}
else
{
        $formatted_phone = preg_replace('/(\d{3})-(\d{3})-(\d{4})/', '($1) $2-$3', $guest_driver_phone);
}

// else{
//     $formatted_phone = $guest_driver_phone;
// }
// dump($formatted_phone);

// $formatted_phone = preg_replace('/(\d{3})-(\d{3})-(\d{4})/', '($1) $2-$3', $waybill->guest_phone);

$guest_cheque   = $drivers->where('id', "99")->first()->cheque_note  ?? "Add Custom Note";
$eric_cheque    = $drivers->where('id', "10")->first()->cheque_note  ?? "Add Custom Note";
$jorge_cheque   = $drivers->where('id', "27")->first()->cheque_note ?? "Add Custom Note";
$andre_cheque   = $drivers->where('id', "43")->first()->cheque_note ?? "Add Custom Note";
$raymond_cheque = $drivers->where('id', "49")->first()->cheque_note ?? "Add Custom Note";
$arnaud_cheque  = $drivers->where('id', "51")->first()->cheque_note ?? "Add Custom Note";
$achraf_cheque  = $drivers->where('id', "55")->first()->cheque_note ?? "Add Custom Note";
$sylvain_cheque = $drivers->where('id', "64")->first()->cheque_note ?? "Add Custom Note";
for($i = 60; $i <=71; $i++){
    // $cell60_note    = $dashboardPosition->where('id', "60")->first()->notes ?? "Custom Note not found";
    ${'cell' . $i. "_note"} = $dashboardPosition->where('id', $i)->first()->notes ?? "Custom Note not found";
    // echo "success!";
}
// $noteContent  = $dashboardPosition->where('id', "60")->first()->notes ?? "Custom Note not found";
// $cell60_note    = $dashboardPosition->where('id', "60")->first()->notes ?? "Custom Note not found";
// $cell61_note    = $dashboardPosition->where('id', "61")->first()->notes ?? "Custom Note not found";
// echo $eric_cheque ?? $eric_cheque : "hi";
// echo $jorge_cheque;
// var_dump($drivers);
// var_dump($cell61_note);

function getDriverInfo($drivers, $id, $defaultName = "pas disponible", $defaultPhone = "(???) ???-????") {
    $driver = $drivers->where('id', $id)->first();

    $name = $driver->name ?? $defaultName;
    $phone = $driver->phone ?? $defaultPhone;

    // Format phone if it's not N/A
    if ($phone !== 'N/A') {
        $phone = preg_replace('/(\d{3})-(\d{3})-(\d{4})/', '($1) $2-$3', $phone);
    }

    return [
        'id' => $id,
        'name' => $name,
        'phone' => $phone,
    ];
}

$guestDriver =  getDriverInfo($drivers,99);
$Driver_10 =  getDriverInfo($drivers,10);
$Driver_27 =  getDriverInfo($drivers,27);
$Driver_43 =  getDriverInfo($drivers,43);
$Driver_49 =  getDriverInfo($drivers,49);
$Driver_51 =  getDriverInfo($drivers,51);
$Driver_55 =  getDriverInfo($drivers,55);
$Driver_64 =  getDriverInfo($drivers,64);
//dump($guestDriver_test);


@endphp
<div class="container mt-4" style="margin: 0px; padding-left:0px; padding-rigth:0px; ">

        <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        {{-- <div class="mb-4" id="#table-title"> --}}
        <h1>Bordereaux</h1>
        {{-- <button id="refreshButton">Refresh Content</button> --}}
        {{-- <a href="https://dev.courriesubito.wbmsites.com/admin/waybills/create?waybill=true" class="btn btn-lg btn-success">NOUVEAU</a> --}}
        {{-- <button id="btn-open-new-popup" class="btn btn-lg btn-success" >NOUVEAU</button>--}}
        {{--  working old link --}}
        <button id="btn-open-new-popup" class="btn btn-lg btn-success" style="display: none" >Bordereaux Rapide</button>
    </div>
</div>

        <!-- <div class="sticky-notes-container" id="sticky-notes-container">
        </div> -->
        <!-- <table class="table table-bordered" id="sticky-table"> -->
        <table id="maintable" class="table table-bordered" style="width: 115%; margin-bottom: 1rem;">

            <!-- <thead>
               <tr id="table-header-row">
                </tr>
            </thead>
            <tbody id="table-body">
            </tbody> -->

            <tr>
                <th rowspan="2"></th>
                <th rowspan="2"></th>
                {{--<th rowspan="2" id="guest"> {{$guest_driver_name}} <br> {{$formatted_phone}} <br>12 pieds </th>
                <th rowspan="2">Ricardo 10 <br>(438)-867-1105 <br>20 pieds tailgate </th>
                <th rowspan="2">Jorge 27 <br>(514) 792-7169<br>26 pieds Tailgate</th>
                <th rowspan="2">André 43 <br> (514)-829-1298 <br>22 pied tailgate</th>
                <th rowspan="2">Raymond 49 <br> (514) 863-8082 <br>caravane </th>
                <th rowspan="2">Arnaud 51 <br> (514) 880-9690 <br> 22pieds </th>
                <th rowspan="2">Achraf 55 <br>(438) 467-7732 <br> 20 pieds tailgate</th>
                <th rowspan="3">Sylvain 64<br>(438) 334-9216<br>20 pieds tailgate</th>--}}
                
                <th rowspan="2" id="guest"> {{$guestDriver['name']}} <br> {{ $guestDriver['phone'] }} <br>12 pieds </th>
                <th rowspan="2">{{$Driver_10['name']}} <br> {{$Driver_10['phone']}} <br>20 pieds tailgate </th>
                <th rowspan="2">{{$Driver_27['name']}} <br> {{$Driver_27['phone']}} <br>26 pieds Tailgate</th>
                <th rowspan="2">{{$Driver_43['name']}} <br> {{$Driver_43['phone']}} <br>22 pied tailgate</th>
                <th rowspan="2">{{$Driver_49['name']}} <br> {{$Driver_49['phone']}} <br>caravane </th>
                <th rowspan="2">{{$Driver_51['name']}} <br> {{$Driver_51['phone']}} <br> 22pieds </th>
                <th rowspan="2">{{$Driver_55['name']}} <br> {{$Driver_55['phone']}} <br> 20 pieds tailgate</th>
                <th rowspan="3">{{$Driver_64['name']}}<br>  {{$Driver_64['phone']}} <br>20 pieds tailgate</th>
                <th rowspam="2"></th>
                <th rowspam="2"></th>
                <!-- <th rowspan="2">Cheque</th> -->
            </tr>
            <!-- <tr>
                        <th>55 </th>
                        <th>64</th>
                    </tr> -->
            </thead>
            <tbody id="table-body">
                <tr class="mira-row">
                    <td>
                        <table class="inside-table">
                            <div class="side-header">Lundi</div>
                            <td class="note-container side-note" id="cell0">
                            </td>
                        </table>
                    </td>
                    <td>
                        <table class="inside-table">
                            <div class="side-header" >Mira</div>
                            <td class="note-container side-note" id="cell1"></td>
                        </table>
                    </td>

                    {{-- guest driver 1st row --}}

                    <td class="note-container" id="cell72">
                        {{-- <div class="cheque hidden" >Cheque</div> --}}
                        <div class="cheque hidden" >
                           <span>Cheque</span>
                           <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="99">{{$guest_cheque?? 'custom-text'}}</div>
                           {{-- <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="10">custom-text</div> --}}
                        </div>
                        <div class="absent hidden">Absent</div>
                    </td>

                    <!-- <td colspan="6">Livraison Empilable à gauche voir tout les papiers</td> -->
                    <td class="note-container" id="cell2">
                        {{-- <div class="cheque hidden" >Cheque</div> --}}
                        <div class="cheque hidden" >
                           <span>Cheque</span>
                           <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="10">{{$eric_cheque?? 'custom-text'}}</div>
                           {{-- <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="10">custom-text</div> --}}
                        </div>
                        <div class="absent hidden">Absent</div>
                    </td>

                    <td class="note-container" id="cell3">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="27">{{$jorge_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell4">
                        <div class="cheque hidden" >
                            <span>Cheque</span>

                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="43">{{$andre_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell5">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="49">{{$raymond_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell6">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="51">{{$arnaud_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell7">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="55">{{$achraf_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell8">

                    {{-- </td>
                    <td class="note-container">

                    </td>
                    <td class="note-container"> --}}
                        <div class="cheque hidden">
                            {{-- {{$cell60_note}} --}}
                            {{-- @php
                            {{ $dashboadPositions->where('id', "60")->first()->notes ?? "Custom Note not found";}}
                            @endphp --}}
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="64">{{$sylvain_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td>
                        <table class="inside-table">
                            <div class="side-header miraSP">Mira semaine terminer</div>
                            <td class="note-container side-note" id="cell78">
                            </td>
                        </table>

                        {{-- <div class="absent cornerSpecialNote" id="absent">ABS</div> --}}
                        {{-- <div class="note-editable" data-table="dashboard" data-column="notes" data-id="60"> --}}

                            {{-- {{$cell60_note}}                        --}}

                            {{-- <ul id="note-list" class="note-editable" data-table="dashboard" data-column="notes" data-id="60"> --}}

                            {{-- <ul class="note-editable" id="note-list-60"  data-table="dashboard" data-column="notes" data-id="60">
                                {!! $cell60_note !!}
                            </ul> --}}

                    </td>
                    <td id="cell61">
                        {{-- <div class="cheque" id="cheque">Cheque</div> --}}
                        {{-- <div class="note-editable" data-table="dashboard" data-column="notes" data-id="61">
                            {{$cell61_note}}</div> --}}

                            <ul id="note-list-61" class="note-editable break-word-cell" data-table="dashboard" data-column="notes" data-id="61">
                                {!! $cell61_note !!}
                            </ul>

                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="inside-table">
                            <div class="side-header">Mardi</div>
                            <td class="note-container side-note" id="cell9"></td>
                        </table>
                    </td>
                    <td>
                        <table class="inside-table">
                            <div class="side-header" id="Dany">Dany</div>
                            <td class="note-container side-note" id="cell10"></td>
                        </table>
                    </td>

                    <td class="note-container" id="cell73">
                        {{-- <div class="cheque hidden" >Cheque</div> --}}
                        <div class="cheque hidden" >
                           <span>Cheque</span>
                           <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="99">{{$guest_cheque?? 'custom-text'}}</div>
                           {{-- <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="10">custom-text</div> --}}
                        </div>
                        <div class="absent hidden">Absent</div>
                    </td>

                    <td class="note-container" id="cell11">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            {{-- <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="10">HelloCustom Text</div> --}}
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="10">{{$eric_cheque?? 'custom-text'}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell12">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="27">{{$jorge_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell13">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="43">{{$andre_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell14">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="49">{{$raymond_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell15">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="51">{{$arnaud_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell16">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="55">{{$achraf_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell17">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="64">{{$sylvain_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    {{-- <td class="note-container"></td>
                    <td class="note-container"></td> --}}

                    <!-- <td colspan="6">Livraison Empilable à gauche voir tout les papiers</td> -->
                    {{-- <td> --}}
                        {{-- <div class="absent" id="absent">ABS</div> --}}

                    {{-- </td> --}}
                    {{-- <td class="note-container side-note" id="cell18"> --}}
                    <td>
                        <table class="inside-table">
                            <div class="side-header">Mira MTL</div>
                            <td class="note-container side-note" id="cell60">
                            </td>
                        </table>

                        {{-- <div  class="note-editable" data-table="dashboard" data-column="notes" data-id="62"> {{$cell62_note}}</div> --}}

                            {{-- <ul id="note-list-62" class="note-editable" data-table="dashboard" data-column="notes" data-id="62">
                                {!! $cell62_note !!}
                            </ul> --}}
                    </td>
                    {{-- <td class="note-container side-note" id="cell19"></td> --}}
                    <td id="cell63">
                        {{-- <div  class="note-editable" data-table="dashboard" data-column="notes" data-id="63"> {{$cell63_note}}</div> --}}

                            <ul id="note-list-63" class="note-editable break-word-cell" data-table="dashboard" data-column="notes" data-id="63">
                                {!! $cell63_note !!}
                            </ul>
                    </td>

                </tr>
                <tr>
                    <td>
                        <table class="inside-table">
                            <div class="side-header">Mercredi</div>
                            <td class="note-container side-note" id="cell20"></td>
                        </table>
                    </td>
                    <td>
                        <table class="inside-table">
                            <div class="side-header" >Donner</div>
                            <td class="note-container side-note" id="cell21"></td>
                        </table>
                    </td>

                    <td class="note-container" id="cell74">
                        {{-- <div class="cheque hidden" >Cheque</div> --}}
                        <div class="cheque hidden" >
                           <span>Cheque</span>
                           <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="99">{{$guest_cheque?? 'custom-text'}}</div>
                           {{-- <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="10">custom-text</div> --}}
                        </div>
                        <div class="absent hidden">Absent</div>
                    </td>
                    <!-- <td>1</td> -->
                    <!-- <td colspan="6">à la fois</td> -->
                    <td class="note-container" id="cell22">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            {{-- <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="10">HelloCustom Text</div> --}}
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="10">{{$eric_cheque?? 'custom-text'}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell23">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="27">{{$jorge_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell24">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="43">{{$andre_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell25">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="49">{{$raymond_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell26">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="51">{{$arnaud_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell27">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="55">{{$achraf_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell28">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="64">{{$sylvain_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    {{-- <td class="note-container"></td>
                    <td class="note-container"></td> --}}
                    <td>
                        <table class="inside-table">
                            <div class="side-header">Mira R-S</div>
                            <td class="note-container side-note" id="cell62">
                            </td>
                        </table>


                        {{-- <div  class="note-editable" data-table="dashboard" data-column="notes" data-id="64"> {{$cell64_note}}</div> --}}

                            {{-- <ul id="note-list-64" class="note-editable" data-table="dashboard" data-column="notes" data-id="64">
                                {!! $cell64_note !!}
                            </ul> --}}
                    </td>
                    <td id="cell65">
                        {{-- <div  class="note-editable" data-table="dashboard" data-column="notes" data-id="65"> {{$cell65_note}}</div> --}}
                        <div>
                            <ul id="note-list-65" class="note-editable break-word-cell" data-table="dashboard" data-column="notes" data-id="65">
                                {!! $cell65_note !!}
                            </ul>
                            </div>
                    </td>

                    {{-- <td class="note-container side-note" id="cell29"></td> --}}

                </tr>
                <tr>
                    <td>
                        <table class="inside-table">
                            <div class="side-header">Jeudi</div>
                            <td class="note-container side-note" id="cell30"></td>
                        </table>
                    </td>
                    <td>
                        <table class="inside-table">
                            <div class="side-header">Donner1</div>
                            <td class="note-container side-note" id="cell31"></td>
                        </table>
                    </td>

                    <td class="note-container" id="cell75">
                        {{-- <div class="cheque hidden" >Cheque</div> --}}
                        <div class="cheque hidden" >
                           <span>Cheque</span>
                           <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="99">{{$guest_cheque?? 'custom-text'}}</div>
                           {{-- <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="10">custom-text</div> --}}
                        </div>
                        <div class="absent hidden">Absent</div>
                    </td>

                    <td class="note-container" id="cell32">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            {{-- <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="10">HelloCustom Text</div> --}}
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="10">{{$eric_cheque?? 'custom-text'}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell33">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="27">{{$jorge_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell34">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="43">{{$andre_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell35">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="49">{{$raymond_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell36">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="51">{{$arnaud_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell37">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="55">{{$achraf_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell38">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="64">{{$sylvain_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    {{-- <td class="note-container"></td>
                    <td class="note-container"></td> --}}

                    {{-- <td>Envoi</td> --}}
                    <!-- <td colspan="2">1</td> -->
                    <!-- <td colspan="4">à la fois</td> -->
                    <!-- <td rowspan="2">Jeudi</td> -->
                    <!-- <td rowspan="2">5 PM</td> -->
                    {{-- <td class="note-container side-note" id="cell39"></td> --}}

                    <td>
                        <table class="inside-table">
                            <div class="side-header">Mira R-N</div>
                            <td class="note-container side-note" id="cell64">
                            </td>
                        </table>


                        {{-- <div  class="note-editable" data-table="dashboard" data-column="notes" data-id="66"> {{$cell66_note}}</div> --}}

                            {{-- <ul id="note-list-66" class="note-editable" data-table="dashboard" data-column="notes" data-id="66">
                                {!! $cell66_note !!}
                            </ul> --}}

                    </td>
                    <td id="cell67">
                        {{-- <div  class="note-editable" data-table="dashboard" data-column="notes" data-id="67"> {{$cell67_note}}</div> --}}

                            <ul id="note-list-67" class="note-editable break-word-cell" data-table="dashboard" data-column="notes" data-id="67">
                                {!! $cell67_note !!}
                            </ul>

                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="inside-table">
                            <div class="side-header">Vendredi</div>
                            <td class="note-container side-note" id="cell40"></td>
                        </table>
                    </td>
                    <td>
                        <table class="inside-table">
                            <div class="side-header" >Ramasser</div>
                            <td class="note-container side-note" id="cell41"></td>
                        </table>
                    </td>

                    <td class="note-container" id="cell76">
                        {{-- <div class="cheque hidden" >Cheque</div> --}}
                        <div class="cheque hidden" >
                           <span>Cheque</span>
                           <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="99">{{$guest_cheque?? 'custom-text'}}</div>
                           {{-- <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="10">custom-text</div> --}}
                        </div>
                        <div class="absent hidden">Absent</div>
                    </td>

                    <td class="note-container" id="cell42">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            {{-- <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="10">HelloCustom Text</div> --}}
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="10">{{$eric_cheque?? 'custom-text'}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell43">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="27">{{$jorge_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell44">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="43">{{$andre_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell45">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="49">{{$raymond_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell46">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="51">{{$arnaud_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell47">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="55">{{$achraf_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    <td class="note-container" id="cell48">
                        <div class="cheque hidden" >
                            <span>Cheque</span>
                            <div class="cheque-editable" data-table="users" data-column="cheque_note" data-id="64">{{$sylvain_cheque}}</div>
                         </div>
                         <div class="absent hidden">Absent</div>
                    </td>
                    {{-- <td class="note-container"></td>
                    <td class="note-container"></td> --}}

                    <!-- <td colspan="5">Livraison Empilable à gauche souri voir tout.</td> -->

                    {{-- <td>Deschamps</td> --}}
                    {{-- <td class="note-container side-note" id="cell49"></td> --}}

                    <td id="cell68">
                        <table class="inside-table">
                            <div class="side-header">Mira Lanaudière</div>
                            <td class="note-container side-note" id="cell66">
                            </td>
                        </table>
                        {{-- <div  class="note-editable" data-table="dashboard" data-column="notes" data-id="68"> {{$cell68_note}}</div> --}}

                            {{-- <ul id="note-list-68" class="note-editable" data-table="dashboard" data-column="notes" data-id="68">
                                {!! $cell68_note !!}
                            </ul> --}}

                    </td>
                    <td id="cell69">
                        {{-- <div  class="note-editable" data-table="dashboard" data-column="notes" data-id="69"> {{$cell69_note}}</div> --}}

                            <ul id="note-list-69" class="note-editable break-word-cell" data-table="dashboard" data-column="notes" data-id="69">
                                {!! $cell69_note !!}
                            </ul>

                    </td>

                </tr>
                <tr class="target-row">
                    <td>
                        <table class="inside-table">
                            <div class="side-header">A venir</div>
                            <td class="note-container side-note" id="cell50"></td>
                        </table>
                    </td>
                    <td>
                        <table class="inside-table">
                            <div class="side-header">Terminer</div>
                            <td class="note-container side-note" id="cell51"></td>
                        </table>
                    </td>
                    <td class="note-container" id="cell77"></td>
                    <td class="note-container" id="cell52"></td>
                    <td class="note-container" id="cell53"></td>
                    <td class="note-container" id="cell54"></td>
                    <td class="note-container" id="cell55"></td>
                    <td class="note-container" id="cell56"></td>
                    <td class="note-container" id="cell57"></td>
                    <td class="note-container" id="cell58"></td>
                    {{-- <td></td>
                    <td></td> --}}
                    {{-- <td></td> --}}
                    <!-- <td colspan="5">Cumulatif de la journée envoyé vers feuille de commission avec Web</td> -->
                    <!-- <td></td> -->

                    {{-- <td>Bureau</td> --}}
                    {{-- <td class="note-container side-note" id="cell59"></td> --}}

                    <td id="cell70">
                        {{-- <div  class="note-editable" data-table="dashboard" data-column="notes" data-id="71"> {{$cell71_note}}</div> --}}
                        {{-- <div>
                            <ul id="note-list-70" class="note-editable" data-table="dashboard" data-column="notes" data-id="70">
                                {!! $cell70_note !!}
                            </ul>
                            </div> --}}
                    </td>
                    <td id="cell71">
                        {{-- <div  class="note-editable" data-table="dashboard" data-column="notes" data-id="71"> {{$cell71_note}}</div> --}}

                            <ul id="note-list-71" class="note-editable break-word-cell" data-table="dashboard" data-column="notes" data-id="71">
                                {!! $cell71_note !!}
                            </ul>

                    </td>
                </tr>
            </tbody>
        </table>
        <h1 class="mb-4" id="bottom-heading">Bordereaux en cours</h1>
        <div class="sticky-notes-container" id="sticky-notes-container">
    </div>
    <div clas="bottom-sticky-notes-container" id="bottom-sticky-notes-container"></div>
        </div>
    </div>
    <div class="overlay">
        <div class="popup">
            <div class="header">
                <h2>All Deliveries</h2>
                <button id="btn-close-popup">X</button>
            </div>
            <div class="body">
            </div>
        </div>
    </div>

    <div class="overlay-new" id="new-overlay" style="display: none;">
        <div class="popup-new">
            {{-- <div class="header"> --}}

            {{-- </div> --}}
            <div class="body">
                <!-- New popup content will be loaded dynamically here -->
                <!--<<iframe id="iframe-popup" src="http://127.0.0.1:8000/admin/waybills/create?waybill=true" width="100%" height="600px"></iframe>-->
                <<iframe id="iframe-popup" src="" width="100%" height="600px"></iframe>
                <button id="btn-close-new-popup">X</button>--}}
            </div>
        </div>
    </div>
    {{-- <div id="contextMenu" class="custom-context-menu" style="display: none;">
        <button id="moveToLundi">Move to Lundi</button>
        <button id="moveToMardi">Move to Mardi</button>
        <button id="moveToMercredi">Move to Mercredi</button>
        <button id="moveToJeudi">Move to Jeudi</button>
        <button id="moveToVendredi">Move to Vendredi</button>
        <button id="moveTovenir">Move to Livraison a venir</button>

    </div> --}}

    {{-- <div id="contextMenu" class="custom-context-menu" style="display: none;">
        <ul class="main-menu">
            <li class="menu-item">
                Drivers
                <ul class="sub-menu">
                    <li>1</li>
                    <li>2</li>
                    <li>3</li>
                    <li>4</li>
                    <li>5</li>
                    <li>6</li>
                    <li>7</li>
                    <li>8</li>
                </ul>
            </li>
            <li class="menu-item">
                Clients
                <ul class="sub-menu">
                    <li>A</li>
                    <li>B</li>
                    <li>C</li>
                    <li>D</li>
                </ul>
            </li>
            <li class="menu-item">
                Days
                <ul class="sub-menu">
                    <li id="moveToLundi">Lundi</li>
                    <li id="moveToMardi">Mardi </li>
                    <li id="moveToMercredi">Mercredi</li>
                    <li id="moveToJeudi">Jeudi</li>
                    <li id="moveToVendredi">Vendredi</li>
                    <li>Samedi</li>
                    <li>Dimanche</li>
                </ul>
            </li>
        </ul>
    </div> --}}

    <div id="TablecontextMenu" class="context-menu">
        <button id="toggleTextVisibilityBtn">Hide/Show Cheque</button>
        <button id="absentBtn">Hide/Show Absent</button>
        <button id="deleteTerminer">Supprimer tout les waybill dans Terminer</button>
        <button id="deleteMiraWeeklyTerminer">Livraison québec</button>
        {{-- <button id="deleteMiraWeeklyTerminer">Effacer Mira case</button> --}}
      </div>

    <div id="contextMenu" class="custom-context-menu">
        <!-- Main Menu -->
        <div id= "chaufferMenu"class="menu-item">
            Chauffeur




                {{-- <button id="Raymond 49">Raymond 49</button> --}}

            <div class="sub-menu-item" id="G99">{{$guestDriver['name']}}
                <div class="sub-menu1">
                <button id="G99Mira">Mira</button>
                <button id="G99Donner">Donner</button>
                <button id="G99Donner1">Donner</button>
                <button id="G99Ramasser">Ramasser</button>
                <button id="G99Terminer">Terminer</button>
                <button id="G99MiraTerminer">Mira Terminer</button>
                <button class="MiraWeeklyTerminer">Mira semaine terminer</button>
                {{-- <button id="Dany">Dany</button> --}}
                {{-- <button id="Dany">Dany</button> --}}
            </div>
            </div>
            <div class="sub-menu-item" id="Eric 10">{{$Driver_10['name']}} {{ $Driver_10['id']}}
                <div class="sub-menu1">
                    <button id="E10Mira">Mira</button>
                    <button id="E10Donner">Donner</button>
                    <button id="E10Donner1">Donner</button>
                    <button id="E10Ramasser">Ramasser</button>
                    <button id="E10Terminer">Terminer</button>
                    <button id="E10MiraTerminer">Mira Terminer</button>
                    <button class="MiraWeeklyTerminer">Mira semaine terminer</button>
                    {{-- <button id="Dany">Dany</button> --}}
                    {{-- <button id="Dany">Dany</button> --}}
                </div>
            </div>
            {{-- <div class="sub-menu-item" id="Jorge 27">{{$Driver_27['name']}} {{ $Driver_27['id']}} --}}
            <div class="sub-menu-item" id="Jorge 27">{{$Driver_27['name']}} 20
                <div class="sub-menu1">
                    <button id="27Mira">Mira</button>
                    <button id="27Donner">Donner</button>
                    <button id="27Donner1">Donner</button>
                    <button id="27Ramasser">Ramasser</button>
                    <button id="27Terminer">Terminer</button>
                    <button id="27MiraTerminer">Mira Terminer</button>
                    <button class="MiraWeeklyTerminer">Mira semaine terminer</button>
                    {{-- <button id="Dany">Dany</button> --}}
                </div>
            </div>
            <div class="sub-menu-item" id="André 43">{{$Driver_43['name']}} {{ $Driver_43['id']}}
                <div class="sub-menu1">
                    <button id="43Mira">Mira</button>
                    <button id="43Donner">Donner</button>
                    <button id="43Donner1">Donner</button>
                    <button id="43Ramasser">Ramasser</button>
                    <button id="43Terminer">Terminer</button>
                    <button id="43MiraTerminer">Mira Terminer</button>
                    <button class="MiraWeeklyTerminer">Mira semaine terminer</button>
                    {{-- <button id="Dany">Dany</button> --}}
                    {{-- <button id="Dany">Dany</button> --}}
                </div>
                </div>
            <div class="sub-menu-item" id="Raymond 49">{{$Driver_49['name']}} {{ $Driver_49['id']}}
                <div class="sub-menu1">
                    <button id="49Mira">Mira</button>
                    <button id="49Donner">Donner</button>
                    <button id="49Donner1">Donner</button>
                    <button id="49Ramasser">Ramasser</button>
                    <button id="49Terminer">Terminer</button>
                    <button id="49MiraTerminer">Mira Terminer</button>
                    <button class="MiraWeeklyTerminer">Mira semaine terminer</button>
                    {{-- <button id="Dany">Dany</button> --}}
                    {{-- <button id="Dany">Dany</button> --}}
                </div>
            </div>
            <div class="sub-menu-item" id="Arnaud 51">{{$Driver_51['name']}} {{ $Driver_51['id']}}
                {{-- <button id="Arnaud 52">Arnaud 52</button> --}}
                <div class="sub-menu1">
                    <button id="51Mira">Mira</button>
                    <button id="51Donner">Donner</button>
                    <button id="51Donner1">Donner</button>
                    <button id="51Ramasser">Ramasser</button>
                    <button id="51Terminer">Terminer</button>
                    <button id="51MiraTerminer">Mira Terminer</button>
                    <button class="MiraWeeklyTerminer">Mira semaine terminer</button>
                    {{-- <button id="Dany">Dany</button> --}}
                    {{-- <button id="Dany">Dany</button> --}}
                </div>
            </div>
            <div class="sub-menu-item" id="Achraf 55">{{$Driver_55['name']}} {{ $Driver_55['id']}}
                <div class="sub-menu1">
                    <button id="55Mira">Mira</button>
                    <button id="55Donner">Donner</button>
                    <button id="55Donner1">Donner</button>
                    <button id="55Ramasser">Ramasser</button>
                    <button id="55Terminer">Terminer</button>
                    <button id="55MiraTerminer">Mira Terminer</button>
                    <button class="MiraWeeklyTerminer">Mira semaine terminer</button>
                    {{-- <button id="Dany">Dany</button> --}}
                    {{-- <button id="Dany">Dany</button> --}}
                </div>
            </div>
            <div class="sub-menu-item" id="Sylvain 64">{{$Driver_64['name']}} {{ $Driver_64['id']}}
                {{-- <button id="Sylvain 64">Sylvain 64</button> --}}
            <div class="sub-menu1">
                    <button id="64Mira">Mira</button>
                    <button id="64Donner">Donner</button>
                    <button id="64Donner1">Donner</button>
                    <button id="64Ramasser">Ramasser</button>
                    <button id="64Terminer">Terminer</button>
                    <button id="64MiraTerminer">Mira Terminer</button>
                    <button class="MiraWeeklyTerminer">Mira semaine terminer</button>
                    {{-- <button id="Dany">Dany</button> --}}
                    {{-- <button id="Dany">Dany</button> --}}
            </div>
            </div>
            {{-- <div class="sub-menu-item" id="Chauffeur 1">Chauffeur 1
                <div class="sub-menu1">
                    <button id="Ch01Donner">Donner</button>
                    <button id="Ch01Donner1">Donner</button>
                    <button id="Ch01Ramasser">Ramasser</button>

                </div>
            </div>
            <div class="sub-menu-item" id="Chauffeur 2">Chauffeur 2
                <div class="sub-menu1">
                    <button id="Ch02Donner">Donner</button>
                    <button id="Ch02Donner1">Donner</button>
                    <button id="Ch02Ramasser">Ramasser</button>


                </div>
            </div> --}}
        </div>



        {{-- </div> --}}
        {{-- <div class="sub-menu"> --}}
        <div class="menu-item">
            Clients
            <div class="sub-menu">
                <button id="Mira">Mira</button>
                <button id="Dany">Dany</button>
                <button id="Donner">Donner</button>
                <button id="Donner1">Donner1</button>
                <button id="Ramasser">Ramasser</button>
                <button id="Terminer">Terminer</button>
                {{-- <button id="Dany">Dany</button> --}}
            </div>
        </div>
        <div class="menu-item">
            Journée
            <div class="sub-menu">
                <button id="moveToLundi">Move to Lundi</button>
                <button id="moveToMardi">Move to Mardi</button>
                <button id="moveToMercredi">Move to Mercredi</button>
                <button id="moveToJeudi">Move to Jeudi</button>
                <button id="moveToVendredi">Move to Vendredi</button>
                <button id="moveTovenir">Move to Livraison a venir</button>
                <button id="moveToMiraMTL">Move to Mira MTL</button>
                <button id="moveToMiraR-S">Move to Mira R-S</button>
                <button id="moveToMiraR-N">Move to Mira R-N</button>
                <button id="moveToMiraLa">Mira Lanaudière</button>

            </div>
        </div>
        {{-- <div class="menu-item"> --}}
        <div class="menu-item" id="delete">
            {{-- <button id="delete">Delete Waybill</button>
            Delete Waybill--}}

            Supprimer waybill
        </div>

    </div>

@endrole
@endsection


@push('css')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

<style>
body{
    font-family: Arial, sans-serif;
    margin: 0;
    padding-left: 15px;
    font-size: 11.5px; /* font size*/
    font-weight: 400px;
}
#hidden{
    display: none;
}

#maintable{
    margin-left:5px;
}

/* styles.css */
#table-title {
  display: flex;
  justify-content: space-between;
  align-items: center; /* Vertically aligns the heading and button */
}

#table-title h1 {
  margin: 0; /* Remove default margin to prevent spacing issues */
}

#table-title a {
  text-decoration: none; /* Optional, in case you don't want the link to have an underline */
}


.side-header{
    font-weight: bold;
}
#bottom-heading{
    margin-left: 40px;
}
.bottom-sticky-note {
    background-color: #d6e8d3;
    /* Ensure width has units, e.g., px */
    /* max-width:: 200px; */
    /* width: 215px; */
    width: 250px;
    /* max-height: 270px; */
    padding: 1px;
    border: 2px solid #000;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow-x: hidden;
    cursor: move;
    /* This will handle both vertical and horizontal scrolling */
    /* overflow: auto;  */
    /*Ensure horizontal scrolling is enabled if needed*/
    /* overflow-x: auto; */
    /* Ensure vertical scrolling is enabled if needed */
    /* overflow-y: auto;  */
}

.bottom-sticky-note-piled {
    background-color: #d6e8d3;
    /* Ensure width has units, e.g., px */
    /* max-width: 293px; //old */
    max-width: 208px;
    /* max-height: 270px; */
    padding: 1px;
    border: 2px solid #000;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    /* This will handle both vertical and horizontal scrolling */
    /* overflow: auto;  */
    /*Ensure horizontal scrolling is enabled if needed*/
    /* overflow-x: auto; */
    /* Ensure vertical scrolling is enabled if needed */
    /* overflow-y: auto;  */
}


/* below two is to show short sticky notes */
.note-container .bottom-sticky-note {
    width: 340px;
    max-height: 230px;
    overflow: hidden;
}
/*.sticky-notes-container .bottom-sticky-note {
    width: 340px;
    max-height: 230px;
    overflow: hidden;
}*/

.multiple-notes .bottom-sticky-note {
    /* show only the first 2 rows */
    max-height: 15.5rem;
    margin-bottom: 0.5rem;
    width: 20rem;
}
/* n+3 note container  */
.note-container .bottom-sticky-note:nth-child(n)
{
    display: none;

}
/* display sigle  */
/* .note-container .bottom-sticky-note:nth-child:nth-child(n+1)
{
    display: block;

} */

/*.note-container .bottom-sticky-note:nth-child(n+2)
{
    display: block;

}*/

.multiple-divNotes{
    max-height: 10.30rem;
    /* width: 100%;   */
    /* height: 50%;   */
    overflow: hidden;  /* Hide the content that goes beyond the specified height */
    /* background-color: lightblue; */

}
.bottom-sticky-notes-container .multiple-divNotes:nth-child(n+6) {
    display: none; /* Hide divs 6 to 10 */
}

.bottom-sticky-notes-container .multiple-divNotes:nth-child(-n+5) {
    display: block; /* Ensure divs 1 to 5 are visible */
}

.bottom-note-table .bottom-table{
    /* width: 200px; */
    width: 100%;
    /* max-width: 215px; */

}
.bottom-note-table th,
.bottom-note-table td {
    border: 1px solid #000 !important;
    text-align: center;
    padding: 1px;
    font-size: 11.5px; /* font*/
    /* font-weight: bold; */
    border-collapse: collapse;
}

.bottom-note-body {
    font-size: 10px;
    width: 100%;
    /* width: 212px; */
    /* margin-top: 5px; */
}

.bottom-section-title {
    font-weight: bold;
    /* margin-bottom: 2px; */
    font-size: 12px; /* font size*/
}

.bottom-note-section {
    background: white;
    border: 1.5px solid #000;
    padding: 1px;
    text-align: center;
    font-style: italic;
    font-size: 10px;
    justify-content: center;
    align-items: center;
    /* margin-bottom:10px */
}

.bottom-from-to-section {
    text-align: left;
    /* display: flex; */
    justify-content: space-between;
    /* margin-bottom: 2px; */
}

/*.bottom-from-section, .bottom-to-section {
    width: 48%;
}*/

.bottom-from-section p,
.bottom-to-section p {
    margin: 0;
    font-size: 12px;
}

#bottom-special-Note {
    margin-bottom: 0;
    padding: 1px;
    font-size: 12px;
    /* width: 1px; */
}

/* new update by val */
/* .table-bordered {
    border-collapse: separate;
} */

.sticky-notes-container {
    /* previously it was 1200px */
    width: 1315px;
    max-width: 1330px
    /*width: 1275px;*/
    /* max-width: 1200px; */
    /*max-width: 1300px;*/
    /*margin-left: 40px;*/
    margin-left: 0px;
    margin-bottom: 20px;
    padding: 10px;
    border: 2px dashed #ddd;
    position: relative;
    /* height: 200px; */
    overflow: auto;
    display: flex;
    flex-wrap: wrap;
    /*gap: 20px;*/
    gap: 10px;
}

.sticky-note {
    border: 1px solid #f0c340;
    border-radius: 4px;
    padding: 10px;
    cursor: move;
    position: relative;
    width: 200px;
    height: auto;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    word-wrap: break-word;
    z-index: 1000;
}

.status-tomorrow {
    background-color: #8fdefb;
    /* background-color: #28a745; */
    color: black;
}

.status-today {
    background-color: #a6f4ee;
    /* background-color:#A7F4F0; */
    /* background-color: #28a745; */
    /* background-color: #f9f79f; */
    color: black;
    /* color: white; */
}

.status-urgent {
    /*background-color: #e3342f;*/
    background-color: #e3342f;
    color: white;
}

.status-urgent {
    /*background-color: #e3342f;*/
    background-color: #FEFBC0;
    color: black;
}

.status-code_red{
    background-color: #E8A7BF;
    color: black;

}
.status-tres_urgent {
    background-color: #F09286;
    color: black;
}
.status-special_night{
    background-color: #E8A7BF;
    color: black;
}


.status-default {
    background-color: #B089F8;
    color: black;
}

.table-bordered {
    border: 2px solid #818181;
    border-collapse: collapse;
    background-color: #e7f3fa;
}

.table-bordered thead {
    background-color: #cbdefa;

}

.table-bordered th {
    border: 2px solid #818181;
    padding: 12px;
}


.table-bordered td {
    border: 2px solid #818181;
    padding: 4px;

    vertical-align: middle;
    text-align: center;
}

.table-bordered table {
    width: 100%;
}

.drag-over {
    border: 3px dashed #000 !important;
}

.table-header {
    vertical-align: top;
    text-transform: capitalize;
    /* vertical-align: top; */
}

.header-bold {
    font-weight: bold;
}

.note-container .side-note {
    height: 50px;
    width: 75px;
}

/*.bottom-note-table .bottom-table{
            border: 100px solid white;
        }*/
.corner-container {
    display: flex;
    justify-content: space-between;
    margin-bottom: 2px;
    font-size: 12px; /* font size*/
}

.left-text {
    font-weight: bold;
}

.right-text {
    font-weight: bold;
}

.name-left-text {
    font-weight: bold;
    max-width: 250px;
}

.container .container-fluid {
    margin: 0px;
    padding-left: 65px;
    padding-right: 20px;

}

.container mt-4 {
    margin: 0px;
    padding: 0px;
}

.table {
    /* margin-left:100px; */
}

.overlay {
    display: none;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    /* left: 0; */
    left: 42px;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(16px);
    z-index: 1000;
}

.overlay-new {
    display: none;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 42px;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(16px);
    z-index: 1000;
}


.popup {
    display: flex;
    flex-direction: column;
    height: 40rem;
    width: 75rem;
    background-color: white;
    border-radius: 1rem;
    border: 1px solid #ddd;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.popup-new {
    display: flex;
    flex-direction: column;
    height: 50rem;
    width: 75rem;
    background-color: white;
    border-radius: 1rem;
    border: 1px solid #ddd;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.popup .header {
    padding: 1rem;
    border-bottom: 1px solid #ddd;
    display: flex;
    gap: 1rem;
    align-items: center;
}

#btn-save-waybill {
    height: fit-content;
}

#btn-close-popup {
    margin-left: auto;
    background-color: transparent;
    border: none;
    cursor: pointer;
    font-size: 1.5rem;
}

#btn-close-new-popup {
    position: absolute; /* Absolutely position the button within the popup */
  top: 58px; /* Distance from the top of the popup */
  right: 122px; /* Distance from the right edge of the popup */
    margin-left: auto;
    background-color: red;
    border: none;
    cursor: pointer;
    font-size: 1.05rem;
}

.popup .body {
    margin-top: 15px;
    display: flex;
    flex-wrap: wrap;
    gap: 100px;
    padding: 1.25rem;
    /* height: 100%; //earlier */
    width: 100%;
    overflow: auto;
    justify-content: center;
}

.popup-new .body {
    margin-top: 15px;
    display: flex;
    flex-wrap: wrap;
    gap: 100px;
    padding: 1.25rem;
    /* height: 100%; //earlier */
    width: 100%;
    overflow: hidden;
    justify-content: center;
}

.popup .body .sticky-note {
    overflow: unset;
    height: auto;
}

.absent {
    display: flex;
    justify-content: center;
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    border-radius: 5px;
    padding: 5px;
    margin: 5px;
}

.absent span {
    margin: auto;
}

.cheque {
    /* display: flex; */
    justify-content: center;
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    border-radius: 5px;
    padding: 5px;
    margin: 5px;
}

.hidden{
    display:none;
}

/* turned off for bubble */
.wrapper-div{
    position: relative;
}
.waybill-text{
    display: flex;
    justify-content: center;
    background-color: #8fdefb;
    color: black;
    border: 1px solid #c3e6cb;
    border-radius: 5px;
    padding: 5px;
    margin: 5px;

}

.count-bubble-number {
  position: absolute;
  top: -14px;
  right: -5px;
  background-color: #f00;    /* Red background (common for notifications) */
  color: #fff;               /* White text color */
  font-size: 12px;           /* Font size for the number */
  width: 20px;               /* Width of the bubble */
  height: 20px;              /* Height of the bubble (equal to width for a perfect circle) */
  border-radius: 50%;        /* Makes the bubble round */
  display: flex;             /* Flexbox for centering text */
  justify-content: center;   /* Center horizontally */
  align-items: center;       /* Center vertically */
  font-weight: bold;         /* Optional: makes the number stand out more */
  text-align: center;        /* Ensures text is centered */
}

.note-count span{
    flex-grow: 1;
}*/

.cheque span {
    flex-grow: 1;
}

.two-line{
  text-align: center;  /* Center the content horizontally within the container */
  /* margin-bottom: 5px; */
  font-size: 12px; /* font size*/
  /* padding: 20px;  Optional: Add some padding */
}

.contact-info{
    display: flex;
    justify-content: flex-end;  /* This moves the elements to the right */
  align-items: center;        /* Vertically centers the items */
    text-align: center;  /* Center the content horizontally within the container */
  /* margin-bottom: 5px; */
  font-size: 12px; /* font size*/
  width: 77%;
}
.contact-name{
    font-weight: bold;
}
.name-center {
    display: block;
    text-align: center;
    font-weight: bold;
    /* margin-bottom: 5px; */
    /* display: inline-block;  //Make span behave like a block */
    word-wrap: break-word;  /* Ensure words break when too long */
    overflow-wrap: break-word;  /* Alias for word-wrap */
    max-width: 100%;  /* Ensure the span doesn't overflow */

}
.phone-center{
    /* display: block; */
    /* text-align: center; */
    margin-right: 5px; /* Space between the phone number and store name */
    font-weight: bold;
    /* margin-bottom: 5px */
}

.address-center{
    display: inline-block;  /* Make span behave like a block */
    word-wrap: break-word;  /* Ensure words break when too long */
    overflow-wrap: break-word;  /* Alias for word-wrap */
    max-width: 100%;  /* Ensure the span doesn't overflow */
}


#bottom-sticky-notes-container {
    /* previously it was 1200px */
    width: 1150px; /* old value 1650*/
    max-width: 1200px; /* old value 1650*/
    margin-left: 40px;
    margin-bottom: 20px;
    padding: 10px;
    border: 2px dashed #ddd;
    position: relative;
    /* height: 200px; */
    overflow: auto;
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.side-note{
    height: 45px;
}

/* Style for the entire table cell */
.note-container {
  position: relative;        /* Allows positioning of the notification bubble */
  padding-left: 30px;        /* Space for the notification bubble on the left side */
}

/* Style for the notification bubble */
 /*.note-container div {
  position: absolute;
  top: 0;
  right: 0;
  background-color: #f00;    Red background (common for notifications)
  color: #fff;               White text color
  font-size: 12px;           Font size for the number
  width: 18px;               Width of the bubble
  height: 18px;              Height of the bubble
  border-radius: 50%;        Makes the bubble round
  display: flex;             Flexbox for centering text
  justify-content: center;   Center horizontally
  align-items: center;       Center vertically
}*/

/* Optional: Style for when the number is '0' */
/*.note-container div:empty {
  display: none;             /* Hide the bubble if the number is 0 */
/* } */

/* context design */
/* old design */
/*.custom-context-menu {
    display: flex;
    flex-direction: column;
    gap: 10px;
    position: absolute;
    background-color: #ffffff;
    border: 1px solid #ccc;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    padding: 8px;
    z-index: 1000;
}
.custom-context-menu button {
    background: none;
    border: none;
    color: #007bff;
    cursor: pointer;
    padding: 5px;
    font-size: 14px;
}
.custom-context-menu button:hover {
    color: #0056b3;
}*/
/* just turned off for sub menu */
/*.custom-context-menu {
            display: flex;
            flex-direction: column;  Stack buttons vertically
            gap: 10px; /* Space between buttons
            background-color: white;
            border: 1px solid #ccc;
            position: absolute;
            padding: 10px;
            width: 200px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: none;
            z-index: 1000;
        }


        .custom-context-menu button {
            padding: 8px;
            font-size: 14px;
            cursor: pointer;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }


        .custom-context-menu button:hover {
            background-color: #e0e0e0;
        }*/




        .inside-table td{
            border: none;
        }

/*.custom-context-menu {
    position: absolute;
    background-color: white;
    border: 1px solid #ccc;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    width: 200px;
    padding: 0;
    margin: 0;
    display: none;
}

.main-menu,
.sub-menu {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.menu-item {
    position: relative;
    padding: 8px 12px;
    cursor: pointer;
    border-bottom: 1px solid #ccc;
    background-color: #f9f9f9;
}

.menu-item:hover {
    background-color: #eaeaea;
}

.sub-menu {
    display: none;
    position: absolute;
    left: 100%;
    top: 0;
    background-color: white;
    border: 1px solid #ccc;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.menu-item:hover .sub-menu {
    display: block;
    z-index: 1001;
}*/

/* menu context working */
/*.custom-context-menu {
    display: flex;
    flex-direction: column;
    gap: 10px;
    background-color: white;
    border: 1px solid #ccc;
    position: absolute;
    padding: 10px;
    width: 200px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: none;
    z-index: 1000;
}

.menu-item {
    position: relative;
    cursor: pointer;
    padding: 8px;
    background-color: #f5f5f5;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.menu-item:hover {
    background-color: #e0e0e0;
}

.sub-menu {
    display: none;
    flex-direction: column;
    gap: 5px;
    position: absolute;
    top: 0;
    left: 210px;
    background-color: white;
    border: 1px solid #ccc;
    padding: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1001;
}

.menu-item:hover .sub-menu {
    display: flex;
}

.sub-menu button {
    padding: 8px;
    font-size: 14px;
    cursor: pointer;
    background-color: #f5f5f5;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.sub-menu button:hover {
    background-color: #e0e0e0;
}*/
/* Main context menu styling */
/* last working */
.custom-context-menu {
    display: flex;
    flex-direction: column;
    background-color: white;
    border: 1px solid #ccc;
    position: absolute;
    padding: 10px;
    width: 200px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: none;
    z-index: 1000;
}

/* // Styling for individual menu items in the main menu */
.menu-item {
    height: 35px;
    position: relative;
    flex-direction: column;
    cursor: pointer;
    padding: 8px;
    background-color: #f5f5f5;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.menu-item:hover {
    background-color: #e0e0e0;
}

/* Second-level submenu (sub-menu) styling */
.sub-menu {
    display: none;
    flex-direction: column;
    gap: 0;
    position: absolute;
    top: 0;
    left: 175px;
    background-color: white;
    border: 1px solid #ccc;
    padding: 10px;
    width: 200px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1001;
}

.sub-menu-item{
    display: none;
    flex-direction: column;
    gap: 0;
    position: relative;
    top: -35px;
    left: 165px;
    background-color: white;
    border: 1px solid #ccc;
    padding: 10px;
    width: 200px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1005;
}

.sub-menu1{
    display: none;
    flex-direction: column;
    gap: 0;
    position: absolute;
    top: 0;
    left: 198px;
    background-color: white;
    border: 1px solid #ccc;
    padding: 10px;
    width: 200px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1002;
}

.sub-menu1.flip-submenu {
    left: auto;
    right: 198px;
}

.sub-menu.flip-submenu {
    left: auto;
    right: 175px;
}

.sub-menu-item.flip-submenu {
    left: auto;
    right: 198px;
}

/* .custom-context-menu.flip-submenu {
    left: auto !important;
    right: 10px;
} */

.custom-context-menu.flip-submenu {
    transform: translateX(-100%);
}
/* Prevent menu items from wrapping */
.menu-item button {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
    text-align: left;
}

/* Show second-level submenu when hovering over a menu item */
.menu-item:hover .sub-menu {
    display: flex; /* Show submenu on hover */
}
/*.sub-menu:hover .sub-menu-item{
    display: flex;
}*/

/*#chaufferMenu.menu-item:hover .sub-menu-item{
    display: flex;
}*/
.sub-menu-item:hover .sub-menu1{
    display: flex;
}

/*#chaufferMenu.menu-item:hover .sub-menu{
    display: none;
}*/

#chaufferMenu.menu-item:hover .sub-menu-item{
    display: flex;
}



/* Third-level submenu (sub-menu1) styling */

/* Show third-level submenu when hovering over a button in the second-level submenu */
.sub-menu button {
    position: relative;
}


/* Show sub-menu1 when hovering over the button in sub-menu */



/* Styling for buttons in submenus */
.sub-menu button, .sub-menu1 button {
    padding: 8px;
    font-size: 14px;
    cursor: pointer;
    background-color: #f5f5f5;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

/* Hover effect for buttons in submenus */
.sub-menu button:hover, .sub-menu1 button:hover {
    background-color: #e0e0e0;
}

/* Optional: Add unique hover effect for sub-menu1 buttons */
.sub-menu1 button:hover {
    background-color: #df1717; /* Unique hover effect for sub-menu1 buttons */
}


/* Main context menu styling */
/* Main context menu styling */




.note-close-button {
    background-color: red;
    color: white;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    cursor: pointer;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/*.note-remove-button {
    background-color: transparent;
    color: red;
    border: none;
    border-radius: 50%;
    width: 400px;
    height: 20px;
    cursor: pointer;
    /* font: 16 & width: 20
    font-size: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.note-remove-button:hover {
    background-color: rgba(255, 0, 0, 0.1);
}*/


.note-wrapper {
    position: relative;
    margin-bottom: 10px;
}

.note-remove-button {
    margin-top:-22px;
    position: absolute;
    top: 0px;
    right: 0px;
    background-color: transparent;
    color: red;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    cursor: pointer;
    font-size: 35px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
}

.note-remove-button:hover {
    background-color: rgba(255, 0, 0, 0.1);
}

/* Basic editable style */
.editable {
  /* background-color: #f9f9f9;   Light gray background */
  /*border: 1px solid #ddd;*/      /* Subtle border around editable areas */
  padding: 5px 10px;           /* Padding for comfortable text editing */
  text-align: right;          /* Center text in the editable cells */
  cursor: pointer;            /* Change cursor to indicate it’s clickable */
  transition: background-color 0.3s ease, border-color 0.3s ease; /* Smooth transitions for interactivity */
}

/* On hover: change background to indicate that it's editable */
.editable:hover {
  background-color: #e6f7ff;  /* Light blue background on hover */
  border-color: #66b3ff;      /* Light blue border */
}

/* When the cell is in contenteditable mode (actively being edited) */
.editable[contenteditable="true"] {
  /* background-color: #fff;     White background for active editing */
  border-color: #007bff;      /* Blue border for active editing */
  outline: none;              /* Remove the default outline for focus */
}

/* Focus state when the user starts editing (for better visual feedback) */
.editable[contenteditable="true"]:focus {
  border-color: #0056b3;      /* Darker blue border when focused */
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Optional: add a subtle glow effect on focus */
}

/* Optional: Style for invalid input (if you want to highlight invalid entries) */
.editable.invalid {
  background-color: #ffcccc;  /* Light red background for invalid input */
  border-color: #ff0000;      /* Red border to indicate an issue */
}

/* Basic editable style */
.client-editable {
  /* background-color: #f9f9f9;   Light gray background */
  /* border: 1px solid #ddd;      Subtle border around editable areas */
  /* padding: 5px 10px;           Padding for comfortable text editing */
  text-align: center;          /* Center text in the editable cells */
  cursor: pointer;            /* Change cursor to indicate it’s clickable */
  transition: background-color 0.3s ease, border-color 0.3s ease; /* Smooth transitions for interactivity */
}

/* On hover: change background to indicate that it's editable */
.client-editable:hover {
  background-color: #e6f7ff;  /* Light blue background on hover */
  border-color: #66b3ff;      /* Light blue border */
}

/* When the cell is in contenteditable mode (actively being edited) */
.client-editable[contenteditable="true"] {
  background-color: #fff;     /* White background for active editing */
  border-color: #007bff;      /* Blue border for active editing */
  outline: none;              /* Remove the default outline for focus */
}

/* Focus state when the user starts editing (for better visual feedback) */
.client-editable[contenteditable="true"]:focus {
  border-color: #0056b3;      /* Darker blue border when focused */
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Optional: add a subtle glow effect on focus */
}

/* Optional: Style for invalid input (if you want to highlight invalid entries) */
.client-editable.invalid {
  /* background-color: #ffcccc;  Light red background for invalid input */
  border-color: #ff0000;      /* Red border to indicate an issue */
}
.minimized-note
{
    max-height: 11.8rem;
    overflow: hidden;
}
.custom-line {
        border: 0;
        border-top: 2px solid #050505; /* Line color */
         width: 100%;                   /*Line width */
         margin: 2px auto;            /*Spacing above and below the line */
        /* opacity: 0.5;                 Line opacity */
    }

  /* Table Context menu styling */
  .context-menu {
    position: absolute;
    background-color: white;
    border: 1px solid #ccc;
    display: none;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    padding: 10px;
    width: 150px;
  }

  .context-menu button {
    width: 100%;
    padding: 8px;
    margin: 5px 0;
    border: none;
    background-color: #f0f0f0;
    cursor: pointer;
  }

  .context-menu button:hover {
    background-color: #ddd;
  }

  /* Active and Inactive styling for buttons */
  .active {
    background-color: #4CAF50;
    color: white;
  }

  .inactive {
    background-color: #f44336;
    color: white;
  }
  .cheque-editable{
    color:red;
  /* background-color: #f9f9f9;   Light gray background */
  border: 1px solid #ddd;      /* Subtle border around editable areas */
  padding: 5px 10px;           /* Padding for comfortable text editing */
  text-align: center;          /* Center text in the editable cells */
  cursor: pointer;            /* Change cursor to indicate it’s clickable */
  transition: background-color 0.3s ease, border-color 0.3s ease; /* Smooth transitions for interactivity */
}

/* On hover: change background to indicate that it's editable */
.cheque-editable:hover {
  background-color: #e6f7ff;  /* Light blue background on hover */
  border-color: #66b3ff;      /* Light blue border */
}

/* When the cell is in contenteditable mode (actively being edited) */
.cheque-editable[contenteditable="true"] {
  /* background-color: #fff;     White background for active editing */
  border-color: #007bff;      /* Blue border for active editing */
  outline: none;              /* Remove the default outline for focus */
}

/* Focus state when the user starts editing (for better visual feedback) */
.cheque-editable[contenteditable="true"]:focus {
  border-color: #0056b3;      /* Darker blue border when focused */
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Optional: add a subtle glow effect on focus */
}

/* Optional: Style for invalid input (if you want to highlight invalid entries) */
.cheque-editable.invalid {
  background-color: #ffcccc;  /* Light red background for invalid input */
  border-color: #ff0000;      /* Red border to indicate an issue */
}



.note-editable{
    color:rgb(8, 8, 8);
  background-color: #fbffc0;  /* Light gray background*/
  border: 1px solid #ddd;      /* Subtle border around editable areas */
  padding: 5px 10px;           /* Padding for comfortable text editing */
  text-align: center;          /* Center text in the editable cells */
  cursor: pointer;            /* Change cursor to indicate it’s clickable */
  transition: background-color 0.3s ease, border-color 0.3s ease; /* Smooth transitions for interactivity */
}

/* On hover: change background to indicate that it's editable */
.note-editable:hover {
  background-color: #e6f7ff;  /* Light blue background on hover */
  border-color: #66b3ff;      /* Light blue border */
}

/* When the cell is in contenteditable mode (actively being edited) */
.note-editable[contenteditable="true"] {
  /* background-color: #fff;     White background for active editing */
  border-color: #007bff;      /* Blue border for active editing */
  outline: none;              /* Remove the default outline for focus */
}

/* Focus state when the user starts editing (for better visual feedback) */
.note-editable[contenteditable="true"]:focus {
  border-color: #0056b3;      /* Darker blue border when focused */
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Optional: add a subtle glow effect on focus */
}

/* Optional: Style for invalid input (if you want to highlight invalid entries) */
.note-editable.invalid {
  background-color: #ffcccc;  /* Light red background for invalid input */
  border-color: #ff0000;      /* Red border to indicate an issue */
}

.fixed-width-cell {
    width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.break-word-cell {
    width: 100px;            /* Set a fixed width */
    word-wrap: break-word;   /* Allow long words to break */
    word-break: break-word;  /* Break words at any character if necessary */
    white-space: normal;     /* Allow text to wrap onto the next line */
}

/* .bottom-special-Note{
    max-width: 100px;
    word-wrap: break-word;
    word-break: break-word;
    white-space: normal;

} */

</style>
@endpush

@push('js')

{{-- one time clearing cache --}}
{{-- <script>
    // Check if the user has already visited
    if (!localStorage.getItem("data_cleared_once")) {
        // Clear storage and cookies
        localStorage.clear();
        sessionStorage.clear();
        document.cookie.split(";").forEach(function(c) {
            document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/");
        });

        // Set a flag so this doesn't run again
        localStorage.setItem("data_cleared_once", "true");
    }
</script>
--}}


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>


document.addEventListener('DOMContentLoaded', () => {
    var flag = 0;
    const stickyNotesContainer = document.querySelector('#sticky-notes-container');
    const bottomStickyNotesContainer = document.querySelector('#bottom-sticky-notes-container');
    const tableBody = document.querySelector('#table-body');
    const tableHeaderRow = document.querySelector('#table-header-row');
    const waybillContainer = document.querySelector(".waybill-container");
    let selectedStickyNote = null;;

     // New Popup Elements
     const newPopupOverlay = document.getElementById('new-overlay');
    const popupBodyNew = newPopupOverlay.querySelector('.popup .body');
    const btnCloseNewPopup = document.getElementById('btn-close-new-popup');
    const btnOpenNewPopup = document.getElementById('btn-open-new-popup');
    const iframe = document.getElementById('iframe-popup');

    var chequeAbsentStatus = @json($dashboardPosition);
    // console.log(`object test: ${JSON.stringify(chequeAbsentStatus)}`);

    btnOpenNewPopup.addEventListener('click', function () {
        newPopupOverlay.style.display = 'block';

        iframe.src = ''; // Clear the content in iframe
        iframe.style.display = 'none'; // Hide the iframe initially

        localUrl= "http://127.0.0.1:8000/admin/waybills/create?waybill=true";
        productionUrl= "https://app.courriersubitopresto.com/admin/waybills/create?waybill=true";
        staggingUrl= "https://courriesubito.wbmsites.com/admin/waybills/create?waybill=true";

        setTimeout(() => {
        iframe.src = staggingUrl; // Set the new URL in the iframe
        iframe.style.display = 'block'; // Show the iframe
    }, 200);
        // Dynamically load content in the new popup (e.g., from a Laravel route)
        /*fetch('/admin/waybills/create?waybill=true') // Replace with your new route
            .then(response => response.text())
            .then(data => {
                popupBodyNew.innerHTML = data; // Load the content into the new popup's body
            })
            .catch(error => {
                console.error('Error loading route:', error);
                popupBodyNew.innerHTML = '<p>There was an error loading the content.</p>';
            });*/
    });

    // Close new popup
    btnCloseNewPopup.addEventListener('click', function () {
        newPopupOverlay.style.display = 'none';
        // loadExternalCSS();
    });

    newPopupOverlay.addEventListener('click', function (e) {
        if (e.target === newPopupOverlay) {
            newPopupOverlay.style.display = 'none';
            // loadExternalCSS();
        }
    });

    async function fetchNotes() {
        let notes; // Replace with your API endpoint
        // return fetch('/Html Template for dashboard/dashboard/dev stagging module/devsimplified/Data/waybills.json') // Replace with your API endpoint
        return fetch('/admin/waybills/today') // Replace with your API endpoint
            .then(response => {notes = response.json(); return notes;})
            .catch(error => {
                console.error('Error fetching notes data:', error);
            });
    }

    /*async function saveNote(noteid, JSONdata){
        let notes = await fetchNotes();
        //replace the note (identified by id) with the new data
        let index = notes.findIndex(note => note.id === noteid);
        if(index !== -1){
            notes[index] = JSONdata;
        }
        //save
        localStorage.setItem('notes', JSON.stringify(notes));

    }
    saveNote();*/

    function fetchDriverData() {
        // return fetch('https://dev.courriesubito.wbmsites.com/admin/list-drivers',{
        return fetch('/admin/driversList',{
        // return fetch('/Html Template for dashboard/dashboard/dev stagging module/devsimplified/Data/drivers.json', {
            // return fetch('{list-drivers.json') }}',{
            method: 'GET',
            headers: {
                'Authorization': 'Bearer your-token',
                'Content-Type': 'application/json'
            }
        }) // Replace with your driver's API endpoint
            .then(response => response.json())
            .catch(error => {
                console.error('Error fetching driver data:', error);
            });
    }


    function fetchAdditionalData() {
        return fetch('/admin/api/clients') // Replace with your new API endpoint
        // return fetch('/Html Template for dashboard/dashboard/dev stagging module/devsimplified/Data/clients.json') // Replace with your new API endpoint
            .then(response => response.json())
            .catch(error => {
                console.error('Error fetching additional data:', error);
            });
    }

    function waybillCreation(value, length, padChar, prefix) {
        const str = String(value); // Convert the value to a string if it's not already
        const paddedValue = str.padStart(length, padChar); // Pad the value
        return prefix + paddedValue; // Add the prefix and return the result
    }


    function generateTopStickyNotes(notes, additionalData,drivers,refresh=false) {
        // alert("GTSN runs");
        // alert(`refresh value in generatetopsticky notes: ${refresh}`);
        flag = 0;
        if(refresh==false){
            // alert("flase & putting waybills into cells");
        addDragAndDropToCells();
        }
        const stickyNotesContainer = document.querySelector('.sticky-notes-container');
        const contextMenu = document.getElementById("contextMenu");
        const mainTable = document.querySelector("#main-table"); // Replace with your table's actual ID
        const driver = drivers;
        // let selectedStickyNote = null;

    // Clear the existing notes
    stickyNotesContainer.innerHTML = '';

    // const topNotes = notes.slice(0, 10);
    // addDragAndDropToCells();
        // var flag = 0;
            stickyNotesContainer.innerHTML = '';
        // topNotes.forEach(note => {
        notes.forEach((note,index) => {
            flag = 1;
            // const waybillDiv = document.createElement('div');
            // waybillDiv.className = 'waybill-container';

            // var dispacherId = note.recipient_id;


            const waybillDiv = document.createElement('div');
            waybillDiv.className = 'waybill-container';

            const noteDiv = document.createElement('div');
            noteDiv.className = 'bottom-sticky-note';
            noteDiv.draggable = true;
            noteDiv.dataset.id = note.id;
            noteDiv.dataset.popupOrder = note.popup_position;


            var driverId = note.driver_id;
            var dispacherId = note.shipper_id;

            var description = note.description;
            var sortDescription = (description && typeof description === 'string')
    ? description.substring(0, 10)
    : 'Null';
    console.log(`note ID: ${note.id}, shortDescription: ${sortDescription} `);
            // var sortDescription = description.substring(0, 10);
            // var price = note.price;
            // var raw_price = (note.dashboard_price).raw.replace(/[^0-9.-]/g, "");
            // old working
            var raw = note?.dashboard_price ?? "0"; // Fallback to "0" if null or undefined
            // console.log(raw);
            var cleanedPrice = raw.replace(/[^0-9.-]/g, "");
            // var price = Number(note.dashboard_price).toFixed(2);
            var price = Number(cleanedPrice).toFixed(2);

            // price for both . & , EN & both

            var raw = note?.dashboard_price ?? "0";

            // Step 1: Trim spaces
            raw = raw.trim();

            // Step 2: If it contains a comma and NOT a dot, assume comma is decimal separator
            if (raw.includes(",") && !raw.includes(".")) {
                raw = raw.replace(",", ".");
            }

            // Step 3: Remove all non-numeric characters except . and -
            var cleanedPrice = raw.replace(/[^0-9.-]/g, "");

            // Step 4: Convert to number and format
            var price = Number(cleanedPrice).toFixed(2);

            // var clientID = note.
            // console.log("dispacher ID(soft_ID): ")
            // console.log(additionalData[0]);
            const additionalInfo = additionalData.find(data => data.id === dispacherId); // Replace `key` with the actual key name
            console.log('additional Info: ');
            console.log(additionalInfo);
            // if(additionalData.find(data => data.id == dispacherId))
            // {
            var dispacherIndexNumber = additionalData.findIndex(data => data.id == dispacherId)
            var prefix = additionalData[dispacherIndexNumber].prefix;
            // console.log('prefix: ' +prefix);

            // soft_id is the number of waybill
            var waybillSoftId = note.soft_id;

            // user_id is the client identity number
            var clientID = note.user_id;


            // console.log('waybill: ' + waybill);
            var updateDate = note.date;
            var createdTime = note.created_at;
            console.log(updateDate);

            var inputDate = "2024-10-12 04:09:10";

            // Create a new Date object from the input string
            var dateObj = new Date(updateDate);
            var createDateObject = new Date(createdTime);
            var creationHour = createDateObject.getHours();
            var createdMinutes = createDateObject.getMinutes();

            const formatCreationHour = `${creationHour}:${createdMinutes < 10 ? '0' + createdMinutes : createdMinutes}`;
            // Get the day, month, and year from the Date object
            var day = dateObj.getDate(); // Returns the day of the month (1-31)
            var month = dateObj.getMonth() + 1; // Months are zero-based, so we add 1
            var year = dateObj.getFullYear(); // Returns the full year (e.g., 2024)

            const daysOfWeekInFrench = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];

            // Get the day of the week (0-6, where 0 is Sunday and 6 is Saturday)


            // Format the date as 'dd-mm-yyyy'
            var formattedDate = (day < 10 ? '0' + day : day) + '-' + (month < 10 ? '0' + month : month) + '-' + year;

            const day_french = daysOfWeekInFrench[dateObj.getDay()];
            const day_db = note.stickyNote_day; // Example value, replace with your actual value

            // Choose either day_french or day_db, or an empty string if neither exists
            let dayToDisplay = day_db || day_french || ""; // Will use day_french if it exists, otherwise day_db, or "" if both are falsy


            var dispacherName = additionalData[dispacherIndexNumber].name;
            var dispacherPhone = additionalData[dispacherIndexNumber].phone;
            var dispacherContact = additionalData[dispacherIndexNumber].contact;
            // var dispacherPhoneExtension = additionalData[dispacherIndexNumber].extension;
            var dispacherPhoneExtension = additionalData[dispacherIndexNumber]?.extension || "";
            // var dispacherContact = note.shipper_contact;
            var dispacherPostalCode = additionalData[dispacherIndexNumber].postal_code;
            var dispacherStreetAddress = additionalData[dispacherIndexNumber].address;
            var dispacherStreetAddressExt = additionalData[dispacherIndexNumber]?.address_ext || '';
            var dispacherCityName = additionalData[dispacherIndexNumber].city_name;
            var dispacherNote = note.shipper_note;
            // receiver details:

            var receiverID = note.recipient_id


            var receiverIndexNumber = additionalData.findIndex(data => data.id == receiverID)

            // var prefix = additionalData[receiverIndexNumber].prefix;
            var waybill = waybillCreation(waybillSoftId, 6, 0, prefix);
            var receiverName = additionalData[receiverIndexNumber].name;
            var receiverPhone = additionalData[receiverIndexNumber].phone;
            var receiverContact = additionalData[receiverIndexNumber].contact;
            var receiverPhoneExtension = additionalData[receiverIndexNumber]?.extension || '';
            // var receiverContact = note.recipient_contact;
            var receiverPostalCode = additionalData[receiverIndexNumber].postal_code;
            var receiverStreetAddress = additionalData[receiverIndexNumber].address;
            var receiverStreetAddressExt = additionalData[receiverIndexNumber]?.address_ext || '';
            var receiverCityName = additionalData[receiverIndexNumber].city_name;
            var receiverNote = note.recipient_note;

            var statusTranslated =  updateNoteStatus(note,noteDiv)
            // <span class="right-text">${dispacherPhone}</span>

            noteDiv.innerHTML = `

                <table class="bottom-note-table bottom-table" style="width:100%";>
                            <tbody>
                            <tr>
                                <th class="editable" data-table="waybills" data-column="stickyNote_day" data-id=${note.id}>${dayToDisplay ? dayToDisplay.toUpperCase() : "&nbsp;"}</th>
                                <td colspan="2" contenteditable="false">${formattedDate}</td>
                            </tr>
                                <tr>
                                    <th>HEURE</th>
                                    <th>SERVICE</th>
                                    <th>CHAUFFEUR</th>
                                </tr>
                                <tr>
                                    <td contenteditable="false">${formatCreationHour?formatCreationHour: "&nbsp;"}</td>
                                    <td class="editable" data-table="waybills" data-column="status" data-id=${note.id}>${statusTranslated.toUpperCase()}</td>
                                    {{-- <td >${driver[driverId]? driver[driverId] : ""} ${driverId? driverId : "&nbsp;" } </td> --}}
                                    <td>${driverId ? (driverId == 99 ? '01' : (driverId == 27 ? '20' : driverId)) : "&nbsp;" } </td>
                                </tr>
                                <tr>

                                    <th>N° CLIENT</th>
                                    <th>DIVERS</th>
                                    <th>PRIX</th>
                                </tr>
                                <tr>
                                    {{--<td class="editable" data-table="waybills" data-column="user_id" data-id=${note.id}>${clientID}</td>--}}
                                    <td>${clientID}</td>
                                    <td class="editable" data-table="waybills" data-column="description" data-id=${note.id}>${description}</td>
                                    <td class="editable" data-table="waybills" data-column="dashboard_price" data-id=${note.id}>${price}<span> $</span></td>

                                </tr>
                                <tr>
                                    <td  data-table="waybills" data-column="truck_1" data-id=${note.id}>${note.truck_1? "CAMION" : "&nbsp;"}</td>
                                    <td ><span class="editable" data-table="waybills" data-column="weight_1" data-id=${note.id}>${note.weight_1? note.weight_1: "&nbsp;"} </span> </td>
                                    {{--<td ><span class="editable" data-table="waybills" data-column="weight_1" data-id=${note.id}>${note.weight_1? note.weight_1: "&nbsp;"} ${note.weight_1? `<span> lbs</span>` : " &nbsp;" }</span> </td>--}}
                                    <td class="editable" data-table="waybills" data-column="hazardous_materials_1" data-id=${note.id}>${note.hazardous_materials_1? note.hazardous_materials_1 : "&nbsp;" }</td>
                                </tr>

                                <tr>

                                    <td  data-table="waybills" data-column="tailgate_1" data-id=${note.id}>${note.tailgate_1? "TAILGATE" : "&nbsp;"}</td>
                                    <td class="editable" data-table="waybills" data-column="cubing_1" data-id=${note.id}>${note.cubing_1? note.cubing_1 : "&nbsp;" }</td>
                                    <td class="editable" data-table="waybills" data-column="hazardous_materials_2" data-id=${note.id}>${note.hazardous_materials_2? note.hazardous_materials_2 : "&nbsp;" }</td>
                                    {{-- <td class="editable" data-table="waybills" data-column="note_permanent" data-id=${note.id}>${note.note_permanent? note.note_permanent : ""}</td> --}}

                                </tr>
                            </tbody>
                        </table>

                        <div class="bottom-note-body" >
                            <div class="bottom-from-to-section">
                                <div class="bottom-from-section">
                                    <div class="bottom-section-title">DE:</div>
                                    <div class="two-line">
                                    <span class="name-center" >${dispacherName.toUpperCase()}</span>
                                    </div>
                                    <div class="contact-info">
                                    <span class="contact-name client-editable" data-table="clients" data-column="contact" data-sipper_contact=${note.id} data-id=${dispacherId} style="margin-right: 10px;"> ${dispacherContact? dispacherContact : "Not found"}</span>
                                    <span class="phone-center client-editable" data-table="clients" data-column="phone" data-id=${dispacherId}> ${dispacherPhone} </span>
                                    <span class="phone-center " data-table="clients" data-column="extension" data-id=${dispacherId}> ${dispacherPhoneExtension} </span>
                                    </div>
                                    <div class="two-line">
                                    <span class="address-center client-editable" data-table="clients" data-column="address" data-id=${dispacherId}>${dispacherStreetAddress.toUpperCase()}</span>
                                    </div>
                                    <div class="two-line">
                                    <span class="address-center client-editable" data-table="clients" data-column="address_ext" data-id=${dispacherId}>${dispacherStreetAddressExt.toUpperCase()}</span>
                                    </div>
                                    <div class="bottom-note-section">
                            <p class="bottom-special-Note" data-table="waybills" data-column="shipper_note" data-id=${note.id}>${dispacherNote || 'NOTES'}</p>
                        </div>

                                    <div class="corner-container">
                                        <span class="left-text client-editable" data-table="clients" data-column="city_name" data-id=${dispacherId}>${dispacherCityName.toUpperCase()}</span>
                                        <span class="right-text client-editable" data-table="clients" data-column="postal_code" data-id=${dispacherId}>${dispacherPostalCode.substring(0, 3)}</span>
                                    </div>

                                </div>
                                <div class="bottom-to-section">
                                    <hr class="custom-line">
                                    <div class="bottom-section-title">À:</div>
                                    <div class="two-line">
                                        <div class="two-line">
                                    <span class="name-center" >${receiverName.toUpperCase()}</span>
                                    </div>
                                    <div class="contact-info">
                                    <span class="contact-name client-editable" data-table="clients" data-column="contact" data-recipient_contact=${note.id} data-id=${receiverID} style="margin-right: 10px;"> ${receiverContact ? receiverContact : "Not found "}</span>
                                    <span class="phone-center client-editable" data-table="clients" data-column="phone" data-id=${receiverID}> ${receiverPhone}</span>
                                    <span class="phone-center " data-table="clients" data-column="extension" data-id=${receiverID}> ${receiverPhoneExtension} </span>
                                    </div>
                                    <div class="two-line">
                                    <span class="address-center client-editable" data-table="clients" data-column="address" data-id=${receiverID}>${receiverStreetAddress.toUpperCase()}</span>
                                    </div>
                                    </div>
                                    <div class="two-line">
                                    <span class="address-center client-editable" data-table="clients" data-column="address_ext" data-id=${receiverID}>${receiverStreetAddressExt.toUpperCase()}</span>
                                    </div>
                                    {{---<div class="two-line">
                                    <span class="address-center client-editable" data-table="clients" data-column="address" data-id=${receiverID}>${receiverStreetAddress.toUpperCase()}</span>
                                    </div>
                                    <span class="name-center" >${receiverName.toUpperCase()} </span>
                                    <span class= "phone-center client-editable" data-table="clients" data-column="phone" data-id=${receiverID}> ${receiverPhone}</span>
                                    <span class="address-center client-editable" data-table="clients" data-column="address" data-id=${receiverID}>${receiverStreetAddress.toUpperCase()}</span>
                                    </div>--}}
                                    <div class="bottom-note-section">
                            <p class="bottom-special-Note" data-table="waybills" data-column="recipient_note" data-id=${note.id}>${receiverNote || 'NOTES'}</p>
                        </div>

                                    <div class="corner-container">
                                        {{-- <span class="left-text client-editable" data-table="clients" data-column="city_name" data-id=${receiverID}>${receiverCityName}</span>--}}
                                        <span class="left-text client-editable" data-table="clients" data-column="city_name" data-id=${receiverID}>${receiverCityName ? receiverCityName.toUpperCase() : 'Null'}</span>
                                        <span class="right-text client-editable" data-table="clients" data-column="postal_code" data-id=${receiverID}>${receiverPostalCode.substring(0, 3)}</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    `;


        // Add note to container
        // stickyNotesContainer.appendChild(noteDiv);


        if(index>=10)
        {
            // short note turned off
            // noteDiv.classList.add('minimized-note');
            // console.log(noteDiv.id);

            // showBottomPopUp(note.id);
        }
        const savedPosition = (note.dashboard_position);
        console.log(`saved Poisition data: ${savedPosition}`);
        console.log(`saved position variable datatype: ${typeof(savedPosition)}`);

            if (savedPosition != null) {
                console.log(`output saved position: ${savedPosition}`);
                // insertNoteInCell(noteDiv, savedPosition.cellId);
                if(refresh == false){
                insertNoteInCell(noteDiv, savedPosition);
                }
            } else {
                // Otherwise, place it in the sticky notes container
                stickyNotesContainer.appendChild(noteDiv);
            }


        // Add context menu event to each note
        // noteDiv.addEventListener("contextmenu", function (event) {
        //     var is_popup = false;
        //     event.preventDefault();
        //     selectedStickyNote = noteDiv;
        //     console.log(selectedStickyNote);
        //     // Show and position context menu
        //     contextMenu.style.display = "block";
        //     contextMenu.style.left = `${event.pageX}px`;
        //     contextMenu.style.top = `${event.pageY}px`;
        // });

        /*noteDiv.addEventListener("contextmenu", function (event) {
            var is_popup = false;
        event.preventDefault();
        selectedStickyNote = noteDiv;

        const menuWidth = contextMenu.offsetWidth;
        const menuHeight = contextMenu.offsetHeight;
        const screenWidth = window.innerWidth;
        const screenHeight = window.innerHeight;

        let posX = event.pageX;
        let posY = event.pageY;

        // If near right edge, show to the left
        if (event.pageX + menuWidth > screenWidth) {
            posX = event.pageX - menuWidth;
        }

        // If near bottom edge, move up to fit
        if (event.pageY + menuHeight > screenHeight) {
            posY = event.pageY - menuHeight;
        }

        // Show and position context menu
        contextMenu.style.display = "block";
        contextMenu.style.left = `${posX}px`;
        contextMenu.style.top = `${posY}px`;
    });*/

    /*noteDiv.addEventListener("contextmenu", function (event) {
    event.preventDefault();

    const contextMenu = document.getElementById("contextMenu");
    const subMenu = contextMenu.querySelector(".sub-menu1");
    const subMenuItem = contextMenu.querySelector(".sub-menu-item");
    const subMenu2 = contextMenu.querySelector(".sub-menu"); // assuming `.sub-menu` is the 2nd level

    const screenWidth = window.innerWidth;
    const spaceRight = screenWidth - event.pageX;

    let posX = event.pageX;
    let posY = event.pageY;

    // Flip everything to the left if not enough space
    const shouldFlip = spaceRight < 750;

    if (shouldFlip) {
        posX = event.pageX - contextMenu.offsetWidth;
        contextMenu.classList.add("flip-submenu");
        subMenu?.classList.add("flip-submenu");
        subMenu1?.classList.add("flip-submenu");
        subMenuItem?.classList.add("flip-submenu");
    } else {
        contextMenu.classList.remove("flip-submenu");
        subMenu?.classList.remove("flip-submenu");
        subMenu1?.classList.remove("flip-submenu");
        subMenuItem?.classList.remove("flip-submenu");
    }

    contextMenu.style.left = `${posX}px`;
    contextMenu.style.top = `${posY}px`;
    contextMenu.style.display = "flex";
});



    document.querySelectorAll(".sub-menu button").forEach((button) => {
    button.addEventListener("click", function () {
        // alert(`Selected: ${this.textContent}`);
        const contextMenu = document.getElementById("contextMenu");
        contextMenu.style.display = "none"; // Hide menu after selection
    });


    });

    document.querySelectorAll(".sub-menu1 button").forEach((button) => {
    button.addEventListener("click", function () {
        // alert(`Selected: ${this.textContent}`);
        const contextMenu = document.getElementById("contextMenu");
        contextMenu.style.display = "none"; // Hide menu after selection
    });
    });
*/

// new test

/*noteDiv.addEventListener("contextmenu", function (event) {
    event.preventDefault();

    const contextMenu = document.getElementById("contextMenu");
    const subMenu = contextMenu.querySelector(".sub-menu");
    const subMenu1 = contextMenu.querySelector(".sub-menu1");
    const subMenuItem = contextMenu.querySelector(".sub-menu-item");

    const screenWidth = window.innerWidth;
    const spaceRight = screenWidth - event.pageX;

    let posX = event.pageX;
    let posY = event.pageY;

    const shouldFlip = spaceRight < 750;

    if (shouldFlip) {
        posX = event.pageX - contextMenu.offsetWidth;
        contextMenu.classList.add("flip-submenu");
        subMenu?.classList.add("flip-submenu");
        subMenu1?.classList.add("flip-submenu");
        subMenuItem?.classList.add("flip-submenu");
    } else {
        contextMenu.classList.remove("flip-submenu");
        subMenu?.classList.remove("flip-submenu");
        subMenu1?.classList.remove("flip-submenu");
        subMenuItem?.classList.remove("flip-submenu");
    }

    contextMenu.style.left = `${posX}px`;
    contextMenu.style.top = `${posY}px`;
    contextMenu.style.display = "flex";
});*/


/*noteDiv.addEventListener("contextmenu", function (event) {
    event.preventDefault();

    const contextMenu = document.getElementById("contextMenu");
    const subMenu = contextMenu.querySelector(".sub-menu");
    const subMenu1 = contextMenu.querySelector(".sub-menu1");
    const subMenuItem = contextMenu.querySelector(".sub-menu-item");

    const screenWidth = window.innerWidth;
    const spaceRight = screenWidth - event.pageX;
    const shouldFlip = spaceRight < 750;

    // Position X
    const posX = shouldFlip
        ? event.pageX - contextMenu.offsetWidth
        : event.pageX;

    // Position Y (safe vertical fallback)
    const menuHeight = contextMenu.offsetHeight;
    const screenHeight = window.innerHeight;
    let posY = event.pageY;
    // if (event.pageY + menuHeight > screenHeight) {
    //     posY = screenHeight - menuHeight - 10;
    // }

    // Toggle flip classes
    const toggleFlip = (el, flip) => {
        if (!el) return;
        el.classList.toggle("flip-submenu", flip);
    };

    toggleFlip(contextMenu, shouldFlip);
    toggleFlip(subMenu, shouldFlip);
    toggleFlip(subMenu1, shouldFlip);
    toggleFlip(subMenuItem, shouldFlip);

    contextMenu.style.left = `${posX}px`;
    contextMenu.style.top = `${posY}px`;
    contextMenu.style.display = "flex";
});*/



    // const noteDiv = document.getElementById('noteDiv'); // Replace with your target div ID

    /*noteDiv.addEventListener("contextmenu", function (event) {
        event.preventDefault();

        const contextMenu = document.getElementById("contextMenu");

        const screenWidth = window.innerWidth;
        const spaceRight = screenWidth - event.pageX;
        const shouldFlip = spaceRight < 750;

        const posX = shouldFlip
            ? event.pageX - contextMenu.offsetWidth
            : event.pageX;

        const menuHeight = contextMenu.offsetHeight;
        const screenHeight = window.innerHeight;
        let posY = event.pageY;

        // Flip classes only on elements that matter
        contextMenu.classList.toggle("flip-submenu", shouldFlip);

        const subMenus = contextMenu.querySelectorAll(".sub-menu");
        subMenus.forEach(sub => sub.classList.toggle("flip-submenu", shouldFlip));

        const subSubMenus = contextMenu.querySelectorAll(".sub-menu1");
        subSubMenus.forEach(sub => sub.classList.toggle("flip-submenu", shouldFlip));

        contextMenu.style.left = `${posX}px`;
        contextMenu.style.top = `${posY}px`;
        contextMenu.style.display = "flex";
    });

    // Hide context menu on outside click or submenu click
    document.addEventListener("click", function (e) {
        const contextMenu = document.getElementById("contextMenu");

        if (!contextMenu.contains(e.target)) {
            contextMenu.style.display = "none";
        }
    });

    document.getElementById("contextMenu").addEventListener("click", function (e) {
        if (e.target.matches(".sub-menu1 button")) {
            this.style.display = "none";
        }
    });*/





   noteDiv.addEventListener("contextmenu", function (event) {
    var is_popup = false;
        //     event.preventDefault();
        selectedStickyNote = noteDiv;
        console.log(selectedStickyNote);
    event.preventDefault();

    const contextMenu = document.getElementById("contextMenu");
    const allSubMenus = contextMenu.querySelectorAll(".sub-menu, .sub-menu1, .sub-menu-item");

    const screenWidth = window.innerWidth;
    const spaceRight = screenWidth - event.pageX;
    const shouldFlip = spaceRight < 750;

    // Position X
    const posX = shouldFlip
        ? event.pageX - contextMenu.offsetWidth
        : event.pageX;

    // Position Y (safe vertical fallback)
    const menuHeight = contextMenu.offsetHeight;
    const screenHeight = window.innerHeight;
    let posY = event.pageY;

    // Apply flip classes to all relevant elements
    const toggleFlip = (el, flip) => {
        if (!el) return;
        el.classList.toggle("flip-submenu", flip);
    };

    // Apply to main menu and all submenus
    toggleFlip(contextMenu, shouldFlip);
    allSubMenus.forEach(menu => toggleFlip(menu, shouldFlip));

    contextMenu.style.left = `${posX}px`;
    contextMenu.style.top = `${posY}px`;
    contextMenu.style.display = "flex";
});

// Show submenus on hover
document.querySelectorAll('.menu-item').forEach(item => {
    item.addEventListener('mouseenter', function() {
        const subMenu = this.querySelector('.sub-menu-item');
        if (subMenu) {
            subMenu.style.display = 'flex';
        }
    });

    item.addEventListener('mouseleave', function() {
        const subMenu = this.querySelector('.sub-menu-item');
        if (subMenu) {
            subMenu.style.display = 'none';
        }
    });
});

// Show deeper submenus on hover
document.querySelectorAll('.sub-menu-item').forEach(item => {
    item.addEventListener('mouseenter', function() {
        const subMenu1 = this.querySelector('.sub-menu1');
        if (subMenu1) {
            subMenu1.style.display = 'flex';
        }
    });

    item.addEventListener('mouseleave', function() {
        const subMenu1 = this.querySelector('.sub-menu1');
        if (subMenu1) {
            subMenu1.style.display = 'none';
        }
    });
});

// / Show sub-menu1 with proper flip state
document.querySelectorAll('.sub-menu-item').forEach(item => {
    item.addEventListener('mouseenter', function() {
        const subMenu1 = this.querySelector('.sub-menu1');
        if (subMenu1) {
            // Inherit flip state from parent sub-menu-item
            const shouldFlip = this.classList.contains("flip-submenu");
            subMenu1.style.display = 'flex';
        }
    });

    item.addEventListener('mouseleave', function() {
        const subMenu1 = this.querySelector('.sub-menu1');
        if (subMenu1) subMenu1.style.display = 'none';
    });
});

// Click handling
document.getElementById("contextMenu").addEventListener("click", function (e) {
    if (e.target.matches("button")) {
        this.style.display = "none";
    }
});

document.addEventListener("click", function (e) {
    const contextMenu = document.getElementById("contextMenu");
    if (contextMenu && !contextMenu.contains(e.target)) {
        contextMenu.style.display = "none";
    }
});






// Rest of your existing click handlers remain the same
/*
document.getElementById("contextMenu").addEventListener("click", function (e) {
    if (e.target.matches(".sub-menu button, .sub-menu1 button, .sub-menu-item button")) {
        // Hide the context menu after any submenu item is clicked
        this.style.display = "none";

        // Optional: log selected value
        // alert(`Selected: ${e.target.textContent}`);
    }
});
document.addEventListener("click", function (e) {
    const contextMenu = document.getElementById("contextMenu");
    if (contextMenu && !contextMenu.contains(e.target)) {
        contextMenu.style.display = "none";
    }
});
*/





        // addDragAndDropToCells();
        // Drag and Drop event listeners
        // old container drag
        // noteDiv.addEventListener('dragstart', (e) => {
        //     // alert("drag found!");
        //     e.dataTransfer.setData('text/plain', e.target.dataset.id);
        //     e.dataTransfer.effectAllowed = 'move';
        //     e.target.style.zIndex = 1000;
        // });

        // noteDiv.addEventListener('dragend', (e) => {
        //     e.target.style.zIndex = '';
        // });

        new Sortable(document.getElementById('sticky-notes-container'), {
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: function () {
                saveNewOrder();
            }
        });

    });

    function saveNewOrder() {
        const container = document.getElementById('sticky-notes-container');
        const noteIds = Array.from(container.children).map((noteDiv, index) => {
            return {
                id: noteDiv.dataset.id,
                order: index + 1 // Use 1-based index
            };
        });

        fetch('/admin/waybills/update-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ orders: noteIds })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Order saved:', data);
        })
        .catch(error => {
            console.error('Error saving new order:', error);
        });
    }

    flag = 0;
    if(refresh==false){
    showAllNotes();
    }
    refresh = false;
    // Move selected sticky note to cell 0 when context menu option is clicked
    /*document.getElementById("moveToLundi").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const destinationCell = document.querySelector("#cell0");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });*/

    // Move to Mardi
    // week days!!





    /*document.getElementById("moveTovenir").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const destinationCell = document.querySelector("#cell60");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });*/

    // input data on the cell


    /*document.getElementById("").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const destinationCell = document.querySelector("#cell0");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });*/

    // Hide context menu on outside click
    document.addEventListener("click", function (event) {
        if (!event.target.closest(".custom-context-menu")) {
            contextMenu.style.display = "none";
        }
    });

    // bottom sticky notes

    const bottomPilledNotes = document.querySelectorAll('.minimized-note');

        // Ensure bottomStickyNotesContainer is not empty
        // if (bottomStickyNotesContainer1.length > 0) {
            bottomPilledNotes.forEach(div => {
                // Add click event listener to each div

                div.addEventListener('click', function() {
                    // alert("identified!");
                    // debug
                    // console.log(`Clicked on div with data-id: ${dataId}`);
                    // const innderDivData = document.querySelector(`div[data-id="${dataId}"]`);
                    // console.log(innderDivData);
                    const dataId = div.getAttribute('data-id');
                    showNewBottomPopUp(dataId);
                });
            });

    // addDragAndDropToCells();
    // refresh=false;
    is_initial = false;
}


function updateNoteStatus(note, noteDiv) {
    let statusTranslated;

    // Clear any existing status classes
    noteDiv.classList.remove(
        'status-tomorrow', 'status-today', 'status-urgent', 'status-tres_urgent',
        'status-code_red', 'status-special_night', 'status-default'
    );

    // Check the note's status and assign classes and translated status
    switch(note.status) {
        case 'tomorrow':
            noteDiv.classList.add('status-tomorrow');
            statusTranslated = 'Lendemain';
            break;
        case 'same_day':
            noteDiv.classList.add('status-today');
            statusTranslated = 'Même Jour';
            break;
        case 'urgent':
            noteDiv.classList.add('status-urgent');
            statusTranslated = 'urgent';
            break;
        case 'very_urgent':
            noteDiv.classList.add('status-tres_urgent');
            statusTranslated = 'TRES urgent';
            break;
        case 'code_red':
            noteDiv.classList.add('status-code_red');
            statusTranslated = 'Code Rouge';
            break;
        case 'night':
            noteDiv.classList.add('status-special_night');
            statusTranslated = 'SPECIAL NIGHT';
            break;
        default:
            noteDiv.classList.add('status-default');
            statusTranslated = 'Invalide';
            break;
    }

    // You can return the translated status if needed
    return statusTranslated;
}


function generateBottomStickyNotes(notes, additionalData) {
        //we setup the table and the sticky notes container
        const bottomNotes = notes.slice(10);
        // addDragAndDropToCells();

        bottomStickyNotesContainer.innerHTML = '';
        bottomNotes.forEach(note => {
            const waybillDiv = document.createElement('div');
            waybillDiv.className = 'multiple-divNotes';
            waybillDiv.dataset.waybill = note.id;
            var dispacherId = note.shipper_id;
            // var dispacherId = note.recipient_id;
            var description = note.description;
            var sortDescription = description.substring(0, 10);
            // var clientID = note.
            // console.log("dispacher ID(soft_ID): ")
            // console.log(additionalData[0]);
            const additionalInfo = additionalData.find(data => data.id === dispacherId); // Replace `key` with the actual key name
            console.log('additional Info: ');
            console.log(additionalInfo);
            // if(additionalData.find(data => data.id == dispacherId))
            // {
            var dispacherIndexNumber = additionalData.findIndex(data => data.id == dispacherId)
            var prefix = additionalData[dispacherIndexNumber].prefix;
            // console.log('prefix: ' +prefix);

            // soft_id is the number of waybill
            var waybillSoftId = note.soft_id;
            var price  = note.price;
            // user_id is the client identity number
            var clientID = note.user_id;


            // console.log('waybill: ' + waybill);

            var dispacherName = additionalData[dispacherIndexNumber].name;
            var dispacherPhone = additionalData[dispacherIndexNumber].phone;
            var dispacherPostalCode = additionalData[dispacherIndexNumber].postal_code;
            var dispacherStreetAddress = additionalData[dispacherIndexNumber].address;
            var dispacherCityName = additionalData[dispacherIndexNumber].city_name;

            // receiver details:

            var receiverID = note.recipient_id


            var receiverIndexNumber = additionalData.findIndex(data => data.id == receiverID)

            // var prefix = additionalData[receiverIndexNumber].prefix;
            var waybill = waybillCreation(waybillSoftId, 6, 0, prefix);
            var receiverName = additionalData[receiverIndexNumber].name;
            var receiverPhone = additionalData[receiverIndexNumber].phone;
            var receiverPostalCode = additionalData[receiverIndexNumber].postal_code;
            var receiverStreetAddress = additionalData[receiverIndexNumber].address;
            var receiverCityName = additionalData[receiverIndexNumber].city_name;

            // <p class="address">${dispacherStreetAddress}</p>
            // <p class="address">${receiverStreetAddress}</p>

            // <div class="bottom-sticky-note">


            /*<tr>
                                <td>Marchandise</td>
                                <td>Poids</td>
                                <td>Grandeur Camion</td>
                            </tr>*/


            // <td class="header-bold">N° CLIENT</td>
            //     <td class="header-bold">DIVERS</td>
            //     <td class="header-bold">PRIX</td>

            // <p class="company">${dispacherName}</p>
            // <p class="contact">${dispacherPhone}</p>
            const noteDiv = document.createElement('div');
            noteDiv.className = 'bottom-sticky-note-piled';
            noteDiv.draggable = true;
            noteDiv.dataset.id = note.id;

            if (note.status === 'tomorrow') {
                noteDiv.classList.add('status-tomorrow');
                var statusTranslated = 'Lendemain';
            }
            else if (note.status === 'same_day') {
                noteDiv.classList.add('status-today');
                var statusTranslated = 'Même Jour';

            }

            else if (note.status === 'urgent') {
                noteDiv.classList.add('status-urgent');
                var statusTranslated = 'urgent';
            }
            else if (note.status === 'very_urgent') {
                noteDiv.classList.add('status-tres_urgent');
                var statusTranslated = 'TRES urgent';
            }
            else if (note.status === 'code_red') {
                noteDiv.classList.add('status-code_red');
                var statusTranslated = 'Code Rouge';
            }

            else if (note.status === 'special_night') {
                noteDiv.classList.add('status-special_night');
                var statusTranslated = 'SPECIAL NIGHT';
            }



            else {
                noteDiv.classList.add('status-default');
                var statusTranslated = 'Invalide';
            }

            // <span class="right-text">${dispacherPhone}</span>

            noteDiv.innerHTML = `

                <table class="bottom-note-table bottom-table">
                            <tbody>
                            <tr>
                                <th>JOUR</th>
                                <td colspan="2">05-09-2024</td>
                            </tr>
                                <tr>
                                    <th>HEURE</th>
                                    <th>SERVICE</th>
                                    <th>CHAUFFEUR</th>
                                </tr>
                                <tr>
                                    <td >8:00</td>
                                    <td >${statusTranslated.toUpperCase()}</td>
                                    <td >08</td>
                                </tr>
                                <tr>

                                    <th>N° CLIENT</th>
                                    <th>DIVERS</th>
                                    <th>PRIX</th>
                                </tr>
                                <tr>
                                    <td >${clientID}</td>
                                    <td >${waybill}</td>
                                    <td >${price?price:""}</td>
                                </tr>
                                <tr>
                                    <td >AUTRES</td>
                                    <td >POIDS</td>
                                    <td ></td>
                                </tr>

                                <tr>
                                    <td ></td>
                                    <td >TRUCK SIZE</td>
                                    <td ></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="bottom-note-body">
                            <div class="bottom-from-to-section">
                                <div class="bottom-from-section">
                                    <div class="bottom-section-title">DE:</div>
                                    <div class="two-line">
                                    <span class="name-center" >${dispacherName.toUpperCase()}</span>
                                    <span class="phone-center"> ${dispacherPhone}</span>
                                    <span class="address-center" >${dispacherStreetAddress.toUpperCase()}</span>
                                    </div>
                                    <div class="bottom-note-section">
                            <p id="bottom-special-Note">${note.note || 'NOTES'}</p>
                        </div>

                                    <div class="corner-container">
                                        <span class="left-text">${dispacherCityName.toUpperCase()}</span>
                                        <span class="right-text" >${dispacherPostalCode.substring(0, 3)}</span>
                                    </div>

                                </div>
                                <div class="bottom-to-section">
                                    <div class="bottom-section-title">À:</div>
                                    <div class="two-line">
                                    <span class="name-center">${receiverName.toUpperCase()} </span>
                                    <span class= "phone-center"> ${receiverPhone}</span>
                                    <span class="address-center" >${receiverStreetAddress.toUpperCase()}</span>
                                    </div>
                                    <div class="bottom-note-section">
                            <p id="bottom-special-Note">${note.note || 'NOTES'}</p>
                        </div>

                                    <div class="corner-container">
                                        <span class="left-text">${receiverCityName.toUpperCase()}</span>
                                        <span class="right-text" >${receiverPostalCode.substring(0, 3)}</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    `;


            // <strong>Additional Info:</strong> ${additionalInfo ? additionalInfo.value : 'N/A'}<br>
            // <strong>Recipient_Name:</strong> ${note.recipient_contact}<br></br>
            /*if (note.status === 'tomorrow') {
                noteDiv.classList.add('status-tomorrow');
                var statusTranslated = 'Demain';
            }
            else if (note.status === 'same_day')  {
                noteDiv.classList.add('status-today');
                var statusTranslated = 'aujourd’hui';

            }

            else if (note.status === 'urgent')  {
                noteDiv.classList.add('status-urgent');
                var statusTranslated = 'urgent';
            }

            else {
                noteDiv.classList.add('status-default');
                var statusTranslated = 'défaut';
            }*/


            // val new test start

            console.log("appending " + note.id + " to sticky notes container");
            // Otherwise, place it in the sticky notes container
            bottomStickyNotesContainer.appendChild(waybillDiv);
            waybillDiv.appendChild(noteDiv);

            // Add event listeners for drag and drop
            noteDiv.addEventListener('dragstart', (e) => {
                e.dataTransfer.setData('text/plain', e.target.dataset.id);
                e.dataTransfer.effectAllowed = 'move';
                e.target.style.zIndex = 1000;
            });

            noteDiv.addEventListener('dragend', (e) => {
                e.target.style.zIndex = '';
            });



            // open in new tab the waybill
            /*noteDiv.addEventListener('contextmenu', (e) => {
                       e.preventDefault(); // Prevent the default context menu from appearing
                       const noteId = noteDiv.dataset.id;
                       const url = `https://app.courriersubitopresto.com/admin/waybills/${note.id}/edit?waybill=true/`; // Replace with your actual URL pattern
                       window.open(url, '_blank');
                   });*/
        });

        const bottomPilledNotes = document.querySelectorAll('.bottom-sticky-note-piled');

        // Ensure bottomStickyNotesContainer is not empty
        // if (bottomStickyNotesContainer1.length > 0) {
            bottomPilledNotes.forEach(div => {
                // Add click event listener to each div

                div.addEventListener('click', function() {
                    // debug
                    // console.log(`Clicked on div with data-id: ${dataId}`);
                    // const innderDivData = document.querySelector(`div[data-id="${dataId}"]`);
                    // console.log(innderDivData);
                    const dataId = div.getAttribute('data-id');
                    showNewBottomPopUp(dataId);
                });
            });


    }

// Function to translate note status into a human-readable format
function translateStatus(status) {
    if (status === 'tomorrow') return 'Lendemain';
    if (status === 'same_day') return 'Même Jour';
    if (status === 'urgent') return 'Urgent';

    return 'Invalide';
}

let previousNotesData = null;
    let is_initial =true;
    isDriverflag = false;
    function fetchAndGenerateNotes(refresh) {
        Promise.all([fetchNotes(), fetchDriverData(), fetchAdditionalData()])
            .then(([notes, drivers, additionalData]) => {
                if (notes || drivers || additionalData) {
                    // generateTable(drivers);

                    // testing note flag value


                    console.log(`initial value: ${is_initial}`);
                    if(is_initial == false) {
                        // console.log(`previousData: ${previousNotesData}`);
                        // console.log(`notes: ${notes}`);

                        notes.forEach((newNote, index) => {
                        let oldNote = previousNotesData[index];

                        // If the 'flag' value has changed, update the UI
                        if (oldNote && oldNote.driver_flag !== newNote.driver_flag) {
                            // Update the UI with the new flag value
                            // is_initial =
                            // isDriverflag = true;
                            // alert(`driver flag change detected, flag vlue: ${isDriverflag}`);
                            moveWaybill = document.querySelector(`.bottom-sticky-note[data-id="${newNote.id}"]`);
                            newPosition = newNote.dashboard_position;
                            console.log(`new position: ${newPosition}`);
                            console.log(moveWaybill);
                            if(newPosition != null){
                                insertNoteInCell(moveWaybill,newPosition);
                            }
                            // alert(`driver flag change detected, flag vlue: ${isDriverflag}`);
                            }
                        });

                        if ((JSON.stringify(notes) !== JSON.stringify(previousNotesData))  ) {
                        // alert("refresh run");
                    console.dir(notes);
                    console.log(drivers);
                    // alert(`in fetch & genereate function: ${refresh}`);
                    generateTopStickyNotes(notes, additionalData,drivers,refresh=true);
                    // generateBottomStickyNotes(notes, additionalData);

                    previousNotesData = notes;
                    }



                    /*if(isDriverflag){
                        isDriverflag = false;
                        const is_initial  = true;
                        // document.querySelector(`.bottom-sticky-note[data-id="${noteId}"]`);
                        // generateTopStickyNotes(notes, additionalData,drivers,refresh=false);
                    }*/


                }
                else if(is_initial == true){
                    const is_initial  = false;
                    // alert("initial run");
                    // if ((JSON.stringify(notes) !== JSON.stringify(previousNotesData))  ) {
                    console.dir(notes);
                    console.log(drivers);
                    // alert(`in fetch & genereate function: ${refresh}`);
                    generateTopStickyNotes(notes, additionalData,drivers,refresh=false);
                    // generateBottomStickyNotes(notes, additionalData);
                    previousNotesData = notes;
                    console.log(`initial after 1st load: ${is_initial}`);
                    // is_initial  = false;
                    // }
                }

                }
                else {
                    console.log("fetch error");
                }
            });
    }





    /*let previousNotesData = null;
    let is_initial =true;
    isDriverflag = false;
    function fetchAndGenerateNotes(refresh) {
        Promise.all([fetchNotes(), fetchDriverData(), fetchAdditionalData()])
            .then(([notes, drivers, additionalData]) => {
                if (notes || drivers || additionalData) {
                    // generateTable(drivers);

                    // testing note flag value


                    console.log(`initial value: ${is_initial}`);
                    if(is_initial != true){

                        notes.forEach((newNote, index) => {
                        const oldNote = previousNotesData[index];

                        // If the 'flag' value has changed, update the UI
                        if (oldNote && oldNote.driver_flag !== newNote.driver_flag) {
                            // Update the UI with the new flag value
                            // is_initial =
                            // isDriverflag = true;
                            // alert(`driver flag change detected, flag vlue: ${isDriverflag}`);
                            moveWaybill = document.querySelector(`.bottom-sticky-note[data-id="${newNote.id}"]`);
                            newPosition = newNote.dashboard_position;
                            console.log(`new position: ${newPosition}`);
                            console.log(moveWaybill);
                            insertNoteInCell(moveWaybill,newPosition);
                            // alert(`driver flag change detected, flag vlue: ${isDriverflag}`);
                            }
                        });

                    // if(isDriverflag){
                        // isDriverflag = false;
                        // const is_initial  = true;
                        // document.querySelector(`.bottom-sticky-note[data-id="${noteId}"]`);
                        // generateTopStickyNotes(notes, additionalData,drivers,refresh=false);
                    // }

                    if ((JSON.stringify(notes) !== JSON.stringify(previousNotesData))  ) {
                        // alert("refresh run");
                    console.dir(notes);
                    console.log(drivers);
                    // alert(`in fetch & genereate function: ${refresh}`);
                    generateTopStickyNotes(notes, additionalData,drivers,refresh=true);
                    // generateBottomStickyNotes(notes, additionalData);

                    previousNotesData = notes;
                    }
                }
                else if(is_initial == true){
                    // is_initial  = false;
                    // alert("initial run");
                    // if ((JSON.stringify(notes) !== JSON.stringify(previousNotesData))  ) {
                    console.dir(notes);
                    console.log(drivers);
                    // alert(`in fetch & genereate function: ${refresh}`);
                    generateTopStickyNotes(notes, additionalData,drivers,refresh=false);
                    // generateBottomStickyNotes(notes, additionalData);
                    previousNotesData = notes;
                    console.log(`initial after 1st load: ${is_initial}`);

                    // is_initial  = false;
                    // }
                }

                }
                else {
                    console.log("fetch error");
                }
            });
    }*/

    function extractId(cellIdString) {
    // Use a regular expression to extract digits from the string
    return parseInt(cellIdString.replace(/\D/g, ''));  // Remove all non-digit characters and convert to number
}

function getDashboardColumns(cellIdString) {
    // Convert "cell1" to 1 using extractId()
    var  id = extractId(cellIdString);

    // Find the user with the extracted userId
    var chequeAbsentStatusData = chequeAbsentStatus.find(function(chequeAbsentStatusData) {
        return chequeAbsentStatusData.id == id;
    });

    // If user is found, return their column values
    if (chequeAbsentStatusData) {
        console.log(`active_cheque:: ${chequeAbsentStatusData.active_cheque}`);
        console.log(`active_absent:: ${chequeAbsentStatusData.active_absent}`);
        return {
            cheque: chequeAbsentStatusData.active_cheque,
            absent: chequeAbsentStatusData.active_absent
        };
    } else {
        // If user is not found, return null
        return null;
    }
}


    async function driverAssignment(waybillId,driverId,delivery_status=false,commission=false){
    console.log(waybillId);
    console.log(driverId)
    console.log(delivery_status);
        // newDriverId = "6";


        const response = await fetch('/admin/update-driver-id', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // CSRF token for protection
        },
        body: JSON.stringify({
            waybill_id: waybillId, // Send the waybill ID
            driver_id: driverId, // Send the new driver ID
            delivery_status: delivery_status,
            commission: commission
        })
    })
    const data = await response.json();
    // .then( response => response.json())
    // .then(data => {
        // Handle the response here (optional)
        if (data.success) {
            console.log('Driver ID updated successfully');
            // updateAssignedWaybill();
            // Optionally update the UI or give feedback
        } else {
            console.log('Error updating driver ID');
        }
    // })
    // .catch(error => {
    //     console.error('Error:', error);
    // });
}

// Helper function to map driver IDs
function mapDriverId(driverId) {
    if (!driverId || driverId === "") {
        return "&nbsp;";
    }
    const id = parseInt(driverId);
    if (id == 99) {
        return '01';
    } else if (id == 27) {
        return '20';
    } else {
        return driverId;
    }
}

function updateTableCell(selectedNoteId, newValue) {
        // alert("function runs!");
        console.log(`within function selectedNoteId: ${selectedNoteId}`);
        // Use the dynamic value to target the correct div by data-id
        const table = document.querySelector(`div[data-id="${selectedNoteId}"] table`);

        if (!table) {
            console.error("Table not found for data-id:", selectedNoteId);
            return;
        }

        // Find the row that contains the value '10' (assume it's in the 3rd column)
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            const cells = row.querySelectorAll('td');
            // alert(`cells length: ${index}`);
            // if (cells.length > 2 && cells[2].textContent == '10') {
            // if (cells.length >2 ) {
            if (index == 2){
            // if (cells.length == 2 ) {
                // Update the 3rd cell (index 2) with the new value
                // Apply driver ID mapping for CHAUFFEUR column
                const mappedValue = mapDriverId(newValue);
                cells[2].textContent = mappedValue;
                // alert(cells[2].textContent);

            }
        });
        /*const rows = table.querySelectorAll('tbody tr');

    // Check if the second row exists
    if (rows.length > 2) {
        const secondRow = rows[1]; // Target the 2nd row (index 1)
        const cells = secondRow.querySelectorAll('td'); // Get all cells in the 2nd row

        // Check if the row has at least 3 cells (so we can target the 3rd cell)
        if (cells.length <= 2) {
            // Update the 3rd cell (index 2) with the new value
            console.log("function console starts! old & after update");
            console.log(cells[2]);
            // console.log({newValue);
            cells[2].textContent = newValue;
            console.log(cells[2]);
        } else {
            console.log('The second row does not have enough cells.');
        }
    } else {
        console.log('There are not enough rows in the table.');
    }*/

    }

    function addDragAndDropToCells() {
        console.log("dragAnddrop function runs!");
        const tableCells = document.querySelectorAll('.note-container');
        const cornerspeicalNote = document.querySelectorAll(".cornerSpecialNote") ;
        // let cellId = 0;
        console.log(cornerspeicalNote);

        tableCells.forEach(cell => {
            // cell.id = `cell${cellId++}`;
            console.log(cell.id);
            // cell.addEventListener('contextmenu', (e) => updateNoteCount(e));
            // cell.addEventListener('click', (e) => showPopUp(e));
            cell.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.target.classList.add('drag-over');
                // showNoteCount(cell.id);
            });

            cell.addEventListener('dragleave', (e) => {
                e.target.classList.remove('drag-over');
                // showNoteCount(cell.id);
            });

            cell.addEventListener('drop', (e) => {
                e.preventDefault();
                e.target.classList.remove('drag-over');

                const noteId = e.dataTransfer.getData('text/plain');
                let note = document.querySelector(`.bottom-sticky-note[data-id="${noteId}"]`);

                if (note) {
                    console.log(e.currentTarget.id);
                    insertNoteInCell(note, e.currentTarget.id);

                }
                /*else if(cornerspeicalNote){
                    insertNoteInCell(cornerspeicalNote, e.currentTarget.id);
                    // note = e.dataTransfer.getData('text/html');
                    // console.log(note);
                    // note = document.querySelector(`#${note}`);
                    // insertNoteInCell(note, e.currentTarget.id, true);
                }*/
                else{
                    note = e.dataTransfer.getData('text/html');
                    console.log(note);
                    note = document.querySelector(`#${note}`);
                    insertNoteInCell(note, e.currentTarget.id, true);
                }
                // updateNoteCount(e.currentTarget);
                // showNoteCount(cell.id);
            });
            console.log(cell);
            // showNoteCount(cell.id,cell);
            // showNoteCount(cell.id); // was active
            if(flag == 1){
            showAllNotes();
            }
            // updateAllNoteCounts();
            // showNewNoteCount()
        });

        stickyNotesContainer.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.target.classList.add('drag-over');
        });

        stickyNotesContainer.addEventListener('dragleave', (e) => {
            e.target.classList.remove('drag-over');
        });

        stickyNotesContainer.addEventListener('drop', (e) => {
            e.preventDefault();
            e.target.classList.remove('drag-over');

            const noteId = e.dataTransfer.getData('text/plain');
            const note = document.querySelector(`.bottom-sticky-note[data-id="${noteId}"]`);

            if (note && e.target.id === stickyNotesContainer.id) {

                // newly turned off for val update

                /*note.style.position = 'relative';
                note.style.left = '0';
                note.style.top = '0';
                // note.style.width = '200px';
                // note.style.height = '200px';
                */
                stickyNotesContainer.appendChild(note);
                removeNotePosition(noteId);
            }

        });
    }

    /*function updateNoteCount(cell) {
    const noteCount = cell.querySelectorAll('.bottom-sticky-note').length;
    console.log(`Notes: ${noteCount}`);
    /*let countDisplay = cell.querySelector('.note-count');

    if (!countDisplay) {
        countDisplay = document.createElement('span');
        countDisplay.classList.add('note-count');
        cell.appendChild(countDisplay);
    }
    countDisplay.textContent = `Notes: ${noteCount}`;
}*/

function showAllNotes() {

    // Now, cellId is directly passed to the function

    // for(i=0;i<=58;i++)
    for(i=0;i<=78;i++)
    {
        if(i == 18 || i == 19 || i == 29 || i == 39 || i == 49 || i==59 || i == 61 || i == 63 || i == 65 || i == 67 || i == 68 || i == 69 || i == 70 || i == 71   ){
            continue;
        }
        // if(i==1){
        //     continue;
        // }
    // console.log(`i: ${i}`);
    cellId = `cell${i}`
    // debug 01
    // console.log("Cell ID:", cellId);
    const stickyNotes = document.querySelectorAll(`#${cellId} .bottom-sticky-note`);
    // stickyNotes.forEach(note => note.style.display = 'none');

    // Get the count of sticky notes
    const noteCount = stickyNotes.length;
    // if(noteCount==0)
    // {
    //     break;
    // }
    // console.log(`Notes: ${noteCount}`);
    const cell = document.getElementById(cellId);
    // console.log(`show count cell details: ${cell}`);

    /*if (cell) {
    // Log the details of the cell
    console.log('Cell ID:', cell.id); // Logs the ID of the cell
    console.log('Cell Content:', cell.innerHTML); // Logs the content inside the cell
    console.log('Cell Class List:', cell.classList); // Logs any classes assigned to the cell
    console.log('Cell Attributes:', cell.attributes); // Logs all attributes of the cell
    console.log('Cell Outer HTML:', cell.outerHTML); // Logs the HTML code of the cell including its tag
} else {
    console.log(`No cell found with ID: ${cellId}`);
}*/
    // if(cellId == "cell1"||)
    /*if (cellId === "cell0" ||
    cellId === "cell1" ||
    cellId === "cell11" ||
    cellId === "cell12" ||
    cellId === "cell22" ||
    cellId === "cell23" ||
    cellId === "cell24" ||
    cellId === "cell34" ||
    cellId === "cell35" ||
    cellId === "cell36" ||
    cellId === "cell46" ||
    cellId === "cell47" ||
    cellId === "cell48" ||
    cellId === "cell58" ||
    cellId === "cell59" ||
    cellId === "cell60") */


    if(cellId)
    {

        // <div class="cheque" id="cheque">Cheque</div>

        // console.log(cellId);
        // stickyNotes.forEach(note => note.style.display = 'none');
        let countDisplay = cell.querySelector('.count-bubble-number');
        // let cheque = cell.querySelector(".cheque");
        // console.log("test");
        // debug 02
        // console.log(`countDisplay: ${countDisplay}`);


        let waybillText = cell.querySelector('.waybill-text');
        /*if (!countDisplay) {
            // console.log("created!");
            countDisplay = document.createElement('div');
            countDisplay.classList.add('count-bubble-number');
            cell.appendChild(countDisplay);
        }

        if (!waybillText) {
            waybillText = document.createElement('div');
            waybillText.classList.add('waybill-text');
            cell.appendChild(waybillText);
        }*/

        const existingDiv = cell.querySelector('.cheque');
        if (!countDisplay || !waybillText) {
            // Create a new parent div to wrap both elements
            let wrapperDiv = document.createElement('div');
            wrapperDiv.classList.add('wrapper-div'); // Optionally add a class for styling purposes

            // Create the count-bubble-number div if it doesn't exist
            if (!countDisplay) {
                countDisplay = document.createElement('div');
                countDisplay.classList.add('count-bubble-number');
                wrapperDiv.appendChild(countDisplay); // Append to the wrapper div
            }

            // Create the waybill-text div if it doesn't exist
            if (!waybillText) {
                waybillText = document.createElement('div');
                waybillText.classList.add('waybill-text');
                wrapperDiv.appendChild(waybillText); // Append to the wrapper div
                // popupadded previously it was in adddrag function for all table cells => cell.addEventListener('click', (e) => showPopUp(e));
                waybillText.addEventListener('click', (e) => showPopUp(e));
            }
            // cell.appendChild(wrapperDiv);
            cell.insertBefore(wrapperDiv, existingDiv);

        }

        /*if(!cheque){
            alert("hi!");
            chequeText = document.createElement('div');
            chequeText.classList.add('hidden',  'cheque');
            // chequeText.classList.add('hidden');
            // chequeText.id = "cheque";
            chequeText.textContent = "Cheque";
            chequeText.contentEditable = "true";
            // chequeText.id = "hidden";
            // cell.appendChild(chequeText);
            if(cellId == "cell2"){
            cell.prepend(chequeText);
            }
            else{
                cell.appendChild(chequeText);
            }
        }*/
        // <div class="cheque" id="cheque">Cheque</div>







        /*countDisplay.textContent = `Notes: ${noteCount}`;*/
        // countDisplay.textContent = `Notes: ${noteCount}`;
        const wrapperDiv = cell.querySelector('.wrapper-div');
        // const noteCountElement = wrapperDiv ? wrapperDiv.querySelector('.count-bubble-number') : null;
        const noteCountElement = wrapperDiv.querySelector('.count-bubble-number');
        // const noteCountElement = cell.querySelector('.count-bubble-number');
            if(noteCount ==0 ){
            // {   alert("here1!");
            // noteCountElement.classList.add('hidden');
            noteCountElement.textContent = `Waybills: ${noteCount}`;
            noteCountElement.style.display = '';
            noteCountElement.removeAttribute('id');
            noteCountElement.id = 'hidden';

            waybillText.textContent = "Waybills:";
            waybillText.style.display = '';
            waybillText.removeAttribute('id');
            waybillText.id = 'hidden';


                // noteCountElement.style.display = 'none';
            }
            else if(noteCount ==1 )
            {
                waybillText.removeAttribute('id');
                // noteCountElement.textContent = `Waybills: ${noteCount}`;
                waybillText.textContent = "Waybill";
                waybillText.style.display = 'flex';

                // Update the note count dynamically
                noteCountElement.removeAttribute('id');
                // noteCountElement.textContent = `Waybills: ${noteCount}`;
                noteCountElement.textContent = `${noteCount}`;
                noteCountElement.style.display = 'flex';
                // noteCountElement.textContent = `lettre de transport: ${noteCount}`;
                // element.style.display = 'none';
                // debug 03
                // console.log("text updated!");
            }
            else {
            // else (noteCountElement) {

                // cell text

                waybillText.removeAttribute('id');
                // noteCountElement.textContent = `Waybills: ${noteCount}`;
                waybillText.textContent = "Waybills";
                waybillText.style.display = 'flex';

                // Update the note count dynamically
                noteCountElement.removeAttribute('id');
                // noteCountElement.textContent = `Waybills: ${noteCount}`;
                noteCountElement.textContent = `${noteCount}`;
                noteCountElement.style.display = 'flex';
                // noteCountElement.textContent = `lettre de transport: ${noteCount}`;
                // element.style.display = 'none';
                // debug
                // console.log("text updated!");
            }

        // alert(`is_initial value: ${is_initial}`);
        if(is_initial == true){
            var tdElement = document.getElementById(cellId);

            // If the td exists and contains a div with the given class
            if (tdElement) {
            // Find the div inside the td element
                var cheque_checker = tdElement.querySelector('div.' + "cheque");
                if(cheque_checker){
                    console.log("cheque value function initial true");
                    const cellChequeContentDiv = cell.querySelector('.cheque');
                    const cellAbsentContentDiv = cell.querySelector('.absent');
                    // const cellId = cell.id;
                    // cellId
                    // Retrieve the saved visibility state from localStorage
                    // let localData = JSON.parse(localStorage.getItem(cellId));
                    // console.log(JSON.stringify(localData));

                    let columnData = getDashboardColumns(cellId);
                    if(columnData !=null){

                    // }
                    // if(localData !=null){

                        // alert("localdata found!");
                        console.log("localdata found!");
                        const chequesavedState = columnData.cheque;
                        const absentSavedState = columnData.absent;
                        // console.log(`localData: ${localData}`);
                        // console.dir(localData);

                        // const absentSavedState = localStorage.getItem("absent");
                        // console.log(`cell ID: ${cellId}`);
                        // console.log(`absent: ${absentSavedState}`);
                        // console.log(`absent query selector: ${cellAbsentContentDiv}`);

                        // If saved state is 'visible', ensure the cell is visible
                        if (absentSavedState == 1){
                            cellAbsentContentDiv.classList.remove('hidden');
                        }
                        else if (absentSavedState == 0 ){
                            cellAbsentContentDiv.classList.add('hidden');
                        }
                    //    if (cellId == "cell0" || cellId == "cell1" || cellId == "cell" || cellId == "cell9" || cellId == "cell10" || cellId == "cell18" || cellId == "cell19" || cellId == "cell20" || cellId == "cell21" || cellId == "cell29" || cellId == "cell30" || cellId == "cell31" || cellId == "cell39" ||)
                        if (chequesavedState === 1) {
                            cellChequeContentDiv.classList.remove('hidden');
                        }
                        else if (chequesavedState === 0){
                            cellChequeContentDiv.classList.add('hidden');
                            // if (!cellContentDiv.classList.contains('hidden')) {
                            // cellContentDiv.classList.add('hidden');
                        }
                    }
                }


            }
        }
        // }



    }

}
console.log("show all function run completed!");
// isStarting =0;
}

function showNoteCount(cellId) {
    // Now, cellId is directly passed to the function
    console.log("Cell ID:", cellId);
    const stickyNotes = document.querySelectorAll(`#${cellId} .bottom-sticky-note`);
    // stickyNotes.forEach(note => note.style.display = 'none');

    // Get the count of sticky notes
    const noteCount = stickyNotes.length;
    // console.log(`Notes: ${noteCount}`);
    console.log(`lettre de transport ${noteCount}`);
    const cell = document.getElementById(cellId);

    /*if (cell) {
    // Log the details of the cell
    console.log('Cell ID:', cell.id); // Logs the ID of the cell
    console.log('Cell Content:', cell.innerHTML); // Logs the content inside the cell
    console.log('Cell Class List:', cell.classList); // Logs any classes assigned to the cell
    console.log('Cell Attributes:', cell.attributes); // Logs all attributes of the cell
    console.log('Cell Outer HTML:', cell.outerHTML); // Logs the HTML code of the cell including its tag
} else {
    console.log(`No cell found with ID: ${cellId}`);
}*/
    // if(cellId == "cell1"||)
    /*if (cellId === "cell0" ||
    cellId === "cell1" ||
    cellId === "cell11" ||
    cellId === "cell12" ||
    cellId === "cell22" ||
    cellId === "cell23" ||
    cellId === "cell24" ||
    cellId === "cell34" ||
    cellId === "cell35" ||
    cellId === "cell36" ||
    cellId === "cell46" ||
    cellId === "cell47" ||
    cellId === "cell48" ||
    cellId === "cell58" ||
    cellId === "cell59" ||
    cellId === "cell60") */
    /*if(cellId)
    {
        stickyNotes.forEach(note => note.style.display = 'none');
        let countDisplay = cell.querySelector('.note-count');
        if (!countDisplay) {
            countDisplay = document.createElement('div');
            countDisplay.classList.add('note-count');
            cell.appendChild(countDisplay);
        }
        // countDisplay.textContent = `Notes: ${noteCount}`;
        // countDisplay.textContent = `Notes: ${noteCount}`;
        const noteCountElement = cell.querySelector('.note-count');
        if(noteCount == 0)
        {
            noteCountElement.id = 'hidden';
        }
            // if (noteCountElement) {
            else{
                // Update the note count dynamically
                noteCountElement.textContent = `Waybills: ${noteCount}`;
                noteCountElement.style.display = 'block';
                // noteCountElement.textContent = `lettre de transport: ${noteCount}`;
                console.log("text updated!");
            }
    }*/

    if(cellId)
    {
        // stickyNotes.forEach(note => note.style.display = 'none');
        let countDisplay = cell.querySelector('.count-bubble-number');
        console.log(`countDisplay: ${countDisplay}`);
        let waybillText = cell.querySelector('.waybill-text');
        if (!countDisplay) {
            // console.log("created!");
            countDisplay = document.createElement('div');
            countDisplay.classList.add('count-bubble-number');
            cell.appendChild(countDisplay);
        }

        if (!waybillText) {
            waybillText = document.createElement('div');
            waybillText.classList.add('waybill-text');
            cell.appendChild(waybillText);
        }







        /*countDisplay.textContent = `Notes: ${noteCount}`;*/
        // countDisplay.textContent = `Notes: ${noteCount}`;
        const noteCountElement = cell.querySelector('.count-bubble-number');
            if(noteCount ==0 ){
            // {   alert("here1!");
            // noteCountElement.classList.add('hidden');
            noteCountElement.textContent = `Waybills: ${noteCount}`;
            noteCountElement.style.display = '';
            noteCountElement.removeAttribute('id');
            noteCountElement.id = 'hidden';

            waybillText.textContent = "Waybills:";
            waybillText.style.display = '';
            waybillText.removeAttribute('id');
            waybillText.id = 'hidden';


                // noteCountElement.style.display = 'none';
            }
            else if(noteCount ==1 )
            {
                waybillText.removeAttribute('id');
                // noteCountElement.textContent = `Waybills: ${noteCount}`;
                waybillText.textContent = "Waybill";
                waybillText.style.display = 'block';

                // Update the note count dynamically
                noteCountElement.removeAttribute('id');
                // noteCountElement.textContent = `Waybills: ${noteCount}`;
                noteCountElement.textContent = `${noteCount}`;
                noteCountElement.style.display = 'block';
                // noteCountElement.textContent = `lettre de transport: ${noteCount}`;
                // element.style.display = 'none';

                console.log("text updated!");
            }
            else {
            // else (noteCountElement) {

                // cell text

                waybillText.removeAttribute('id');
                // noteCountElement.textContent = `Waybills: ${noteCount}`;
                waybillText.textContent = "Waybills";
                waybillText.style.display = 'block';

                // Update the note count dynamically
                noteCountElement.removeAttribute('id');
                // noteCountElement.textContent = `Waybills: ${noteCount}`;
                noteCountElement.textContent = `${noteCount}`;
                noteCountElement.style.display = 'block';
                // noteCountElement.textContent = `lettre de transport: ${noteCount}`;
                // element.style.display = 'none';

                console.log("text updated!");
            }
    }

}


    // stop for val function edit

    /*function insertNoteInCell(note, cellId, copy) {
        //we use data-id to identify the note, but id property is used to identify the cell

        const cell = document.querySelector(`#${cellId}`);
        const table = document.querySelector('#table-body');
        const tableRows = table.querySelectorAll(':scope > tr');

        const existingNote = cell.querySelector('.bottom-sticky-note');
        if (existingNote) {
            const firstRow = tableRows[0];
            const fourthRow = tableRows[3];
            if (cell.parentElement !== firstRow && cell.parentElement !== fourthRow && !cell.classList.contains('side-note')) {
                //we return any existing note to the sticky notes container
                stickyNotesContainer.appendChild(existingNote);
                removePosition(existingNote.dataset.id);
            }
            else {
                cell.classList.add('multiple-notes');
            }
        }
        else{
            cell.classList.remove('multiple-notes');
        }
        if (copy) {
            cell.appendChild(note.cloneNode(true));
        }
        else{
            cell.appendChild(note);
        }
        savePosition(note.dataset.id, cellId);
        showNoteCount(cellId);
    }*/

        function insertNoteInCell(element, cellId, copy=false) {
            console.log("insertnotecell function runs!");
            console.log(`cellId datatype: ${typeof(cellId)}`);
            //we use data-id to identify the note, but id property is used to identify the cell
            console.log(typeof(cellId));
            const cell = document.querySelector(`#${cellId}`);
            const table = document.querySelector('#table-body');
            const tableRows = table.querySelectorAll(':scope > tr');

            /*const existingNote = cell.querySelector('.bottom-sticky-note');
            if (existingNote) {
                const firstRow = tableRows[0];
                const fourthRow = tableRows[3];
                if (cell.parentElement !== firstRow && cell.parentElement !== fourthRow && !cell.classList.contains('side-note')) {
                    //we return any existing note to the sticky notes container
                    stickyNotesContainer.appendChild(existingNote);
                    // removePosition(existingNote.dataset.id);
                    removeNotePosition(existingNote.dataset.id); //new test old one remove
                }
                else {
                    cell.classList.add('multiple-notes');
                }
            }
            else {
                cell.classList.remove('multiple-notes');
            }*/
            /*if (copy) {
            cell.appendChild(note.cloneNode(true));
        }*/
            console.log(copy);
            if (copy==true) {
                /*// alert("here copy starts!");
                const clonedNote = element.cloneNode(true);
                //add a remove button to the cloned note
                const removeButton = document.createElement('button');
                removeButton.textContent = 'X';
                removeButton.className = 'btn-close-popup';
                removeButton.style.marginLeft = 'auto';
                removeButton.addEventListener('click', (e) => {
                    console.log("click detected!");
                    e.stopPropagation();
                    clonedNote.remove();
                    // removePosition(clonedNote.id);
                    removeNotePosition(clonedNote.id);
                });
                clonedNote.appendChild(removeButton);
                cell.appendChild(clonedNote);
                // alert("ends here!");
                // return;*/
            }
            else {
                console.log(`Element type & details: ${element}`);
                cell.appendChild(element);
            }
            console.log(`insert function flag value: ${flag}`);
            console.log(`Element Dataset Id:  ${element.dataset.id}`);
            if(flag != 1){
                console.log(`saved position flag value: ${flag}`);
            savePosition(element.dataset.id, cellId);
            }
            // showNoteCount(cellId); // was active
            // showAllNotes();
            if(flag == 0){
                showAllNotes();
            }
            // showNewNoteCount();
        }


    // mine old function
    /*function removePosition(id) {
        console.log("removing position", id);
        const savedPositions = JSON.parse(localStorage.getItem('notePositions') || '{}');
        delete savedPositions[id];
        showNoteCount(cellId);
        localStorage.setItem('notePositions', JSON.stringify(savedPositions));
    }*/

    // new update of val function

    function removePosition(id) {
        console.log("removing position", id);
        const savedPositions = JSON.parse(localStorage.getItem('notePositions') || '[]');
        console.log(`saved positions: ${savedPositions}`)
        const positionIndex = savedPositions.findIndex(position => position.noteId === id);
        if (positionIndex !== -1) {
            savedPositions.splice(positionIndex, 1);
        }
        localStorage.setItem('notePositions', JSON.stringify(savedPositions));
    }



    // stopped for val function
    /*function savePosition(noteId, cellId) {
        let positions = JSON.parse(localStorage.getItem('notePositions')) || {};
        positions[noteId] = { cellId };
        localStorage.setItem('notePositions', JSON.stringify(positions));
    }*/

    /*function savePosition(noteId, cellId) {
        let positions = JSON.parse(localStorage.getItem('notePositions')) || [];
        // [ {noteId, cellId} ]
        const existingPosition = positions.find(position => position.noteId === noteId);
        if (existingPosition && existingPosition.noteId != "absent" && existingPosition.noteId != "cheque") {
            existingPosition.cellId = cellId;
        }
        else {
            positions.push({ noteId, cellId });
        }
        localStorage.setItem('notePositions', JSON.stringify(positions));
    }*/

    function savePosition(noteId, cellId) {
        /*let positions = JSON.parse(localStorage.getItem('notePositions')) || {};
        positions[noteId] = { cellId };
        localStorage.setItem('notePositions', JSON.stringify(positions));*/
        // function saveEditedData(selectedNoteId, columnName , tableName, newValue,dashboardCellId=false,selectedClientId=false) {
        const waybillColumn = "dashboard_position";
        const waybillTable = "waybills";
        var position =  cellId;
        var waybillNumber = noteId;
        updatePosition(noteId,waybillColumn,waybillTable,position);
    }

    function getSavedPosition(noteId) {
        const positions = JSON.parse(localStorage.getItem('notePositions'));
        return positions ? positions[noteId] : null;
        // showAllNotes();
    }

    function removeNotePosition(noteId) {

        // function saveEditedData(selectedNoteId, columnName , tableName, newValue,dashboardCellId=false,selectedClientId=false) {
        const waybillColumn = "dashboard_position";
        const waybillTable = "waybills";
        var position =  "";
        var waybillNumber = noteId;
        removePositionDB(noteId,waybillColumn,waybillTable,position);

        // old data
        /*let positions = JSON.parse(localStorage.getItem('notePositions')) || {};
        delete positions[noteId];
        localStorage.setItem('notePositions', JSON.stringify(positions));*/
    }

    /*function showPopUp(eventInitiator) {
        //we take into consideration event bubbling. we need the cell that holds the sticky notes
        let cellElement = eventInitiator.target;
        let cellId = cellElement.id;
        while (cellElement && !cellElement.classList.contains('note-container')) {
            cellElement = cellElement.parentElement;
        }
        if (cellElement && cellElement.classList.contains('note-container')) {
            cellId = cellElement.id;
            // Continue with your logic using cellId
        } else {
            console.log("No <td> element found in the parent chain.");
        }

        //check if the cell has no notes
        if (!cellElement.querySelector(`.bottom-sticky-note`)) {
            return;
        }

        const closePopupButton = document.querySelector('#btn-close-popup');
        const overlay = document.querySelector('.overlay');
        closePopupButton.addEventListener('click', () => {
            overlay.style.display = 'none';
        });
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.style.display = 'none';
            }
        });
        overlay.style.display = 'flex';



        //get all the notes in the cell
        const notes = document.querySelectorAll(`#${cellId} .bottom-sticky-note`);
        console.log(`#${cellId}`);
        console.log(notes.length);
        console.log(notes);
        const popupBody = document.querySelector('.popup .body');
        popupBody.innerHTML = '';
        notes.forEach(note => {
            const clonedNode = note.cloneNode(true);
            clonedNode.style.display = 'block';
            popupBody.appendChild(clonedNode);
            //make all the table cells in the note editable
            const tableCells = clonedNode.querySelectorAll('td');
            tableCells.forEach(cell => {
                cell.contentEditable = true;
            });
        });
    }*/

    // semi done

    /*function showPopUp(eventInitiator) {
    let cellElement = eventInitiator.target;

    // Find the note container in the parent chain
    while (cellElement && !cellElement.classList.contains('note-container')) {
        cellElement = cellElement.parentElement;
    }
    if (!cellElement) {
        console.log("No note container found.");
        return;
    }

    // Check if the cell has no notes
    if (!cellElement.querySelector(`.bottom-sticky-note`)) {
        return;
    }


    const closePopupButton = document.querySelector('#btn-close-popup');
        const overlay = document.querySelector('.overlay');
        closePopupButton.addEventListener('click', () => {
            overlay.style.display = 'none';
        });
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.style.display = 'none';
            }
        });
        overlay.style.display = 'flex';

    // const overlay = document.querySelector('.overlay');
    const popupBody = document.querySelector('.popup .body');

    // Clear the popup body
    popupBody.innerHTML = '';

    // Get all the sticky notes in the cell
    const notes = cellElement.querySelectorAll('.bottom-sticky-note');

    notes.forEach(note => {
        const clonedNote = note.cloneNode(true);
        clonedNote.style.display = 'block';

        // Add a close button to the note
        const closeButton = document.createElement('button');
        closeButton.textContent = 'X';
        closeButton.classList.add('note-close-button');
        closeButton.style.position = 'absolute';
        closeButton.style.top = '5px';
        closeButton.style.right = '5px';

        // Handle the close button click
        closeButton.addEventListener('click', () => {
            // Move the note back to the sticky notes container
            const noteId = clonedNote.dataset.id; // Ensure notes have a unique data-id
            const originalNote = document.querySelector(`.bottom-sticky-note[data-id="${noteId}"]`);

            if (originalNote) {
                stickyNotesContainer.appendChild(originalNote);
            }

            // Remove the cloned note from the popup
            clonedNote.remove();
            showAllNotes();
        });

        clonedNote.appendChild(closeButton);
        popupBody.appendChild(clonedNote);

        // Make the note content editable
        const tableCells = clonedNote.querySelectorAll('td');
        tableCells.forEach(cell => {
            cell.contentEditable = true;
        });
    });

    // Show the popup overlay
    overlay.style.display = 'flex';
    }*/
                // old working stopped 28.11.24 12:30 am
    /*function showPopUp(eventInitiator) {
    let cellElement = eventInitiator.target;

    // Find the note container in the parent chain
    while (cellElement && !cellElement.classList.contains('note-container')) {
        cellElement = cellElement.parentElement;
    }

    if (!cellElement) {
        console.log("No note container found.");
        return;
    }

    // Check if the cell has no notes
    if (!cellElement.querySelector(`.bottom-sticky-note`)) {
        return;
    }

    const closePopupButton = document.querySelector('#btn-close-popup');
    const overlay = document.querySelector('.overlay');

    closePopupButton.addEventListener('click', () => {
        overlay.style.display = 'none';
    });

    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            overlay.style.display = 'none';
        }
    });

    overlay.style.display = 'flex';

    const popupBody = document.querySelector('.popup .body');

    // Clear the popup body
    popupBody.innerHTML = '';

    // Get all the sticky notes in the cell
    const notes = cellElement.querySelectorAll('.bottom-sticky-note');

    notes.forEach(note => {
        console.log(note);
        const noteWrapper = document.createElement('div');
        noteWrapper.classList.add('note-wrapper');
        noteWrapper.style.position = 'relative';
        // noteWrapper.appendChild(note);
        const clonedNote = note.cloneNode(true);

        // remove a class
        clonedNote.classList.remove('minimized-note');

        clonedNote.style.display = 'block';

        // Add a remove button to the top-right corner
        const removeButton = document.createElement('button');
        removeButton.textContent = '-';
        removeButton.classList.add('note-remove-button');

        // Handle the remove button click
        removeButton.addEventListener('click', () => {
            // Move the note back to the sticky notes container
            const noteId = clonedNote.dataset.id; // Ensure notes have a unique data-id
            console.log(`noteID from popup remove postion: ${noteId}`);
            const originalNote = document.querySelector(`.bottom-sticky-note[data-id="${noteId}"]`);
            removeNotePosition(noteId);
            if (originalNote) {
                stickyNotesContainer.appendChild(originalNote);
            }

            // Remove the cloned note from the popup
            noteWrapper.remove();
            showAllNotes();
        });

        // Append the button and the note to the wrapper
        noteWrapper.appendChild(removeButton);
        noteWrapper.appendChild(clonedNote);
        popupBody.appendChild(noteWrapper);

        clonedNote.addEventListener("contextmenu", function (event) {
            console.log(note);
            console.dir(note);
            // selectedStickyNote = note;

            console.log("popup click detected!");
            event.preventDefault();
            selectedStickyNote = note;
            console.log(selectedStickyNote);
            // Show and position context menu
            contextMenu.style.display = "block";
            contextMenu.style.left = `${event.pageX}px`;
            contextMenu.style.top = `${event.pageY}px`;
        });
        // if (window.opener && window.opener.document) {
        //     alert("window opener!");
        document.getElementById("moveToLundi").addEventListener("click", function () {
        if (selectedStickyNote) {
            console.log("Moving sticky note to Lundi...");

            // Check if window.opener is available (main window)
            if (window.opener) {
                // Access the main window's #cell0 element
                const destinationCell = window.opener.document.querySelector("#cell0");
                if (destinationCell) {
                    console.log(`Moving sticky note to ${destinationCell}`);
                    // Move the selected sticky note to the target cell
                    destinationCell.appendChild(selectedStickyNote);
                    showAllNotes();
                    selectedStickyNote = null; // Clear selection after move
                } else {
                    console.error('Destination cell not found in the parent window.');
                }
            } else {
                console.error('window.opener is null. Ensure the popup is opened correctly.');
            }

            // Hide the context menu after moving
            contextMenu.style.display = "none"; // Hide context menu after move
        } else {
            console.log('No sticky note selected.');
        }
    });
        // Make the note content editable
        /*const tableCells = clonedNote.querySelectorAll('td');
        // tableCells.forEach(cell => {
        //     cell.contentEditable = true;
        // });
// }
    });

    // Show the popup overlay
    overlay.style.display = 'flex';
}*/


/*function showPopUp(eventInitiator) {
    let cellElement = eventInitiator.target;

    // Find the note container in the parent chain
    while (cellElement && !cellElement.classList.contains('note-container')) {
        cellElement = cellElement.parentElement;
    }

    if (!cellElement) {
        console.log("No note container found.");
        return;
    }

    // Check if the cell has no notes
    if (!cellElement.querySelector(`.bottom-sticky-note`)) {
        return;
    }

    const closePopupButton = document.querySelector('#btn-close-popup');
    const overlay = document.querySelector('.overlay');

    closePopupButton.addEventListener('click', () => {
        overlay.style.display = 'none';
    });

    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            overlay.style.display = 'none';
        }
    });

    overlay.style.display = 'flex';

    const popupBody = document.querySelector('.popup .body');

    // Clear the popup body
    popupBody.innerHTML = '';

    // Get all the sticky notes in the cell
    const notes = cellElement.querySelectorAll('.bottom-sticky-note');

    notes.forEach(note => {
        console.log(note);
        const noteWrapper = document.createElement('div');
        noteWrapper.classList.add('note-wrapper');
        noteWrapper.style.position = 'relative';
        // noteWrapper.appendChild(note);
        const clonedNote = note.cloneNode(true);

        // remove a class
        clonedNote.classList.remove('minimized-note');

        clonedNote.style.display = 'block';

        // Add a remove button to the top-right corner
        const removeButton = document.createElement('button');
        removeButton.textContent = '-';
        removeButton.classList.add('note-remove-button');

        // Handle the remove button click
        removeButton.addEventListener('click', () => {
            // Move the note back to the sticky notes container
            const noteId = clonedNote.dataset.id; // Ensure notes have a unique data-id
            console.log(`noteID from popup remove postion: ${noteId}`);
            const originalNote = document.querySelector(`.bottom-sticky-note[data-id="${noteId}"]`);
            removeNotePosition(noteId);
            if (originalNote) {
                stickyNotesContainer.appendChild(originalNote);
            }

            // Remove the cloned note from the popup
            noteWrapper.remove();
            showAllNotes();
        });




    function showNewBottomPopUp(dataId){

        const closePopupButton = document.querySelector('#btn-close-popup');
        const overlay = document.querySelector('.overlay');
        closePopupButton.addEventListener('click', () => {
            overlay.style.display = 'none';
        });
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.style.display = 'none';
            }
        });
        overlay.style.display = 'flex';



        //get all the notes in the cell
        // const notes = document.querySelectorAll(`.bottom-sticky-note-piled`);
        // get only specific note
        // const element2 = document.querySelector('.bottom-sticky-note-piled');

// Get the value of the data-id attribute
        const note = document.querySelector(`div[data-id="${dataId}"]`);
        // const notes = event.target.getAttribute('data-info');
        // document.querySelector(`div[data-id="${dataId}"]`);

        console.log(note);
        // console.log(`#${cellId}`);
        // console.log(notes.length);
        // console.log(notes);
        const popupBody = document.querySelector('.popup .body');
        popupBody.innerHTML = '';

        const clonedNode = note.cloneNode(true);
            clonedNode.style.display = 'block';
            popupBody.appendChild(clonedNode);
            // remove a class
        clonedNode.classList.remove('minimized-note');
            //make all the table cells in the note editable
            const tableCells = clonedNode.querySelectorAll('td');
            tableCells.forEach(cell => {
                cell.contentEditable = true;
            });
        /*notes.forEach(note => {
            const clonedNode = note.cloneNode(true);
            // clonedNode.style.display = 'block';
            popupBody.appendChild(clonedNode);
            //make all the table cells in the note editable
            const tableCells = clonedNode.querySelectorAll('td');
            tableCells.forEach(cell => {
                cell.contentEditable = true;
            });
        });

    }*/

    async function fetchPopupPositions() {
        const response = await fetch('/admin/waybills/get-popup-order');
        return await response.json(); // returns [{id: 101, popup_position: 1}, ...]
    }

    async function showPopUp(eventInitiator) {
        // alert("showPopUp function called!");
        const popupPositions = await fetchPopupPositions()
        // generateTopStickyNotes();
        // fetchAndGenerateNotes(refresh=true);
        var is_popup = true;
    let cellElement = eventInitiator.target;

    // Find the note container in the parent chain
    while (cellElement && !cellElement.classList.contains('note-container')) {
        cellElement = cellElement.parentElement;
    }

    if (!cellElement) {
        console.log("No note container found.");
        return;
    }

    // Check if the cell has no notes
    if (!cellElement.querySelector(`.bottom-sticky-note`)) {
        return;
    }

    const closePopupButton = document.querySelector('#btn-close-popup');
    const overlay = document.querySelector('.overlay');

    closePopupButton.addEventListener('click', () => {
        overlay.style.display = 'none';
    });

    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            overlay.style.display = 'none';
        }
    });

    overlay.style.display = 'flex';

    const popupBody = document.querySelector('.popup .body');

    // Clear the popup body
    popupBody.innerHTML = '';

    // Get all the sticky notes in the cell
    // old
    // const notes = cellElement.querySelectorAll('.bottom-sticky-note');




    // notes.sort((a, b) => {
    //     const aOrder = savedOrder.find(o => o.id === a.dataset.id)?.order ?? 9999;
    //     const bOrder = savedOrder.find(o => o.id === b.dataset.id)?.order ?? 9999;
    //     return aOrder - bOrder;
    // });


    // notes.sort((a, b) => {
    // const aOrder = parseInt(a.dataset.popupPosition) || 9999;
    // const bOrder = parseInt(b.dataset.popupPosition) || 9999;
    // return aOrder - bOrder;
    // });


    // const allNotes = await fetchNotes();

    // if (!allNotes || !Array.isArray(allNotes)) {
    //     console.error('No notes fetched or invalid format.');
    //     return;
    // }

    /*const notes = Array.from(cellElement.querySelectorAll('.bottom-sticky-note'));
    notes.sort((a, b) => {
    const aOrder = parseInt(a.dataset.popupOrder) || 9999;
    const bOrder = parseInt(b.dataset.popupOrder) || 9999;
    return aOrder - bOrder;
});*/
    const notes = Array.from(cellElement.querySelectorAll('.bottom-sticky-note'));

    notes.sort((a, b) => {
    const aId = parseInt(a.dataset.id);
    const bId = parseInt(b.dataset.id);

    const aPos = popupPositions.find(n => n.id === aId)?.popup_position ?? 9999;
    const bPos = popupPositions.find(n => n.id === bId)?.popup_position ?? 9999;

    return aPos - bPos;
});

/*const sortedNotes = allNotes.sort((a, b) => {
    const aOrder = parseInt(a.popupOrder) || 9999;
    const bOrder = parseInt(b.popupOrder) || 9999;
    return aOrder - bOrder;
});*/

    // ✅ OPTIONAL: get some identifier from cellElement to filter relevant notes
    // const cellId = cellElement.dataset.id; // Or driver ID, etc.
    // const notes = allNotes.filter(note => note.cellId == cellId); // adapt as needed

    // ✅ Sort by popupOrder
    // notes.sort((a, b) => (a.popupOrder ?? 9999) - (b.popupOrder ?? 9999));


    console.log("popup notes: ");
    console.log(notes);

    notes.forEach(note => {
        console.log(note);
        const noteWrapper = document.createElement('div');
        noteWrapper.classList.add('note-wrapper');
        noteWrapper.style.position = 'relative';
        // noteWrapper.appendChild(note);
        const clonedNote = note.cloneNode(true);

        // remove a class
        clonedNote.classList.remove('minimized-note');
        // clonedNote.classList.remove('note-container');

        clonedNote.style.display = 'block';

        // Add a remove button to the top-right corner
        const removeButton = document.createElement('button');
        removeButton.textContent = '-';
        removeButton.classList.add('note-remove-button');

        // Handle the remove button click
        removeButton.addEventListener('click', () => {
            // Move the note back to the sticky notes container
            const noteId = clonedNote.dataset.id; // Ensure notes have a unique data-id
            console.log(`noteID from popup remove postion: ${noteId}`);
            const originalNote = document.querySelector(`.bottom-sticky-note[data-id="${noteId}"]`);
            status = 1;
            deleteWaybill(noteId, status,selectedWaybill=false);
            updateTableCell(noteId,driverId="");
            removeNotePosition(noteId);
            if (originalNote) {
                stickyNotesContainer.appendChild(originalNote);

            }

            // Remove the cloned note from the popup
            noteWrapper.remove();
            showAllNotes();
        });

        // Append the button and the note to the wrapper
        noteWrapper.appendChild(removeButton);
        noteWrapper.appendChild(clonedNote);
        popupBody.appendChild(noteWrapper);

        clonedNote.addEventListener("contextmenu", function (event) {

            console.log(`log for conednote context: ${note}`);
            console.dir(`dir for context: ${note}`);

            const stcikyNoteId = clonedNote.dataset.id; // Ensure notes have a unique data-id
            console.log(`selected sticky noteID from popup: ${stcikyNoteId}`);
            const actualNote = document.querySelector(`.bottom-sticky-note[data-id="${stcikyNoteId}"]`);

            // selectedStickyNote = note;

            console.log("popup click detected!");
            // alert("popup click detected!");
            event.preventDefault();
            selectedStickyNote = actualNote;
            console.dir(selectedStickyNote);
            // Show and position context menu
            // contextMenu.style.display = "block";
            // contextMenu.style.left = `${event.pageX}px`;
            // contextMenu.style.top = `${event.pageY}px`;

            const contextMenu = document.getElementById("contextMenu");
            const allSubMenus = contextMenu.querySelectorAll(".sub-menu, .sub-menu1, .sub-menu-item");

            const screenWidth = window.innerWidth;
            const spaceRight = screenWidth - event.pageX;
            const shouldFlip = spaceRight < 450;

            // Position X
            const posX = shouldFlip
                ? event.pageX - contextMenu.offsetWidth
                : event.pageX;

            // Position Y (safe vertical fallback)
            const menuHeight = contextMenu.offsetHeight;
            const screenHeight = window.innerHeight;
            let posY = event.pageY;

            // Apply flip classes to all relevant elements
            const toggleFlip = (el, flip) => {
                if (!el) return;
                el.classList.toggle("flip-submenu", flip);
            };

            // Apply to main menu and all submenus
            toggleFlip(contextMenu, shouldFlip);
            allSubMenus.forEach(menu => toggleFlip(menu, shouldFlip));

            contextMenu.style.left = `${posX}px`;
            contextMenu.style.top = `${posY}px`;
            contextMenu.style.display = "flex";

            contextMenu.addEventListener("click", function (event) {
                const clickedElement = event.target;

                // Check if the clicked element is the #delete item, and skip it if so
                if (clickedElement.id !== 'delete') {
                    // Check if the clicked item is inside the popup
                    if (popupBody.contains(noteWrapper)) {
                        // Handle clicks on context menu items inside the popup window
                        // handleClickInsidePopup(clickedElement);
                        noteWrapper.remove(stcikyNoteId);
                    } else {
                        // Handle clicks on context menu items outside the popup window
                        // handleClickOutsidePopup(clickedElement);
                    }
                }
            });

            contextMenu.querySelector('#delete').addEventListener("click", function () {
                // Only remove the note if it's inside the popup
                if (popupBody.contains(noteWrapper)) {
                    // Remove the noteWrapper from the popup
                    const removeStickyNote = document.querySelector(`.bottom-sticky-note[data-id="${stcikyNoteId}"]`);
                    console.log(stcikyNoteId);
                    removeNotePosition(stcikyNoteId);
                    removeStickyNote.remove();
                    // deleteWaybill(stcikyNoteId,status,selectedStickyNote=false);
                    console.log(`delete section, selected note: ${stcikyNoteId}`);
                    noteWrapper.remove(stcikyNoteId);
                    // Optionally, remove from sticky notes container (if needed)
                    // removeNotePosition(noteId);

                    // var selectedwaybillId = selectedStickyNote.getAttribute('data-id');
                    // var status = 0;
                    // console.log(`delete section, selected note: ${selectedStickyNote.getAttribute('data-id')}`);
                    // console.log(`delete section, selected note: ${selectedwaybillId}`);
                    // removeNotePosition(selectedwaybillId);




                    // showAllNotes();
                }
                contextMenu.style.display = "none"; // Hide context menu after deleting
                // showAllNotes();
            });


        });






        // if (window.opener && window.opener.document) {
        //     alert("window opener!");
        /*document.getElementById("moveToLundi").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const destinationCell = document.querySelector("#cell1");
        console.log(`selected cellID from popup: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });*/
    // });
        // Make the note content editable
        /*const tableCells = clonedNote.querySelectorAll('td');
        tableCells.forEach(cell => {
            cell.contentEditable = true;
        });*/
// }
    });

    new Sortable(popupBody, {
        animation: 150,
        ghostClass: 'sortable-ghost',
        handle: '.bottom-sticky-note',
        onEnd: function () {
        //     saveNewPopupOrder();
        saveNewPopupOrder();
        }
    });
    // var is_popup = false;
    // Show the popup overlay
    overlay.style.display = 'flex';
}

function saveNewPopupOrder() {
    const popupContainer = document.querySelector('.popup .body');

    const popupNoteIds = Array.from(popupContainer.children).map((noteWrapper, index) => {
        const noteDiv = noteWrapper.querySelector('.bottom-sticky-note');

        return {
            id: noteDiv.dataset.id,
            popup_position: index + 1 // Use 1-based index
        };
    });

    // 🔍 Console log for testing
    console.log('📝 New popup order to be saved:', popupNoteIds);

    // 🚀 Send to server
    fetch('/admin/waybills/update-popup-order', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ orders: popupNoteIds })
    })
    .then(response => response.json())
    .then(data => {
        console.log('✅ Popup order saved:', data);
    })
    .catch(error => {
        console.error('❌ Error saving popup order:', error);
    });
}


    function showBottomPopUp(eventInitiator) {
        //we take into consideration event bubbling. we need the cell that holds the sticky notes
        let bottomPopElement = eventInitiator.target;
        let cellElement = eventInitiator.target;




        const closePopupButton = document.querySelector('#btn-close-popup');
        const overlay = document.querySelector('.overlay');
        closePopupButton.addEventListener('click', () => {
            overlay.style.display = 'none';
        });
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.style.display = 'none';
            }
        });
        overlay.style.display = 'flex';



        //get all the notes in the cell
        const notes = document.querySelectorAll(`.bottom-sticky-note-piled`);
        // console.log(`#${cellId}`);
        console.log(notes.length);
        console.log(notes);
        const popupBody = document.querySelector('.popup .body');
        popupBody.innerHTML = '';
        notes.forEach(note => {
            const clonedNode = note.cloneNode(true);
            // clonedNode.style.display = 'block';
            popupBody.appendChild(clonedNode);
            //make all the table cells in the note editable
            const tableCells = clonedNode.querySelectorAll('td');
            tableCells.forEach(cell => {
                cell.contentEditable = true;
            });
        });
    }

    // Prevent dropping within another sticky note
    document.addEventListener('dragover', (e) => {
        if (e.target.classList.contains('bottom-sticky-note')) {
            e.preventDefault();
        }
    });

    document.addEventListener('drop', (e) => {
        if (e.target.classList.contains('bottom-sticky-note')) {
            e.preventDefault();
        }
    });

    // prevent on special note

    document.addEventListener('dragover', (e) => {
        if (e.target.classList.contains('bottom-note-section')) {
            e.preventDefault();
        }
    });

    document.addEventListener('drop', (e) => {
        if (e.target.classList.contains('bottom-note-section')) {
            e.preventDefault();
        }
    });

    fetchAndGenerateNotes(refresh=false);
    setInterval(() => {
        is_initial =false;
        console.log("checking for update");
    fetchAndGenerateNotes(refresh=true);  // Call it every 10 seconds (adjust interval as needed)
}, 120000); // 1,000 ms = 1 seconds


    // refresh turned off
    // function updateContents(){
    //     refresh = true;
    //     fetchAndGenerateNotes(refresh);
    // }
    // document.getElementById('refreshButton').addEventListener('click', updateContents);
    const specialNotes = [];
    // specialNotes.push( document.querySelector('#cheque'));
    // specialNotes.push( document.querySelector('#absent'));

    // for(const specialNote of specialNotes){
    //     specialNote.draggable = true;
    //     // specialNote.addEventListener('dragstart', dragStart);
    //     specialNote.addEventListener('dragstart', (e) => {
    //         e.dataTransfer.setData('text/html', e.target.id);
    //         e.dataTransfer.effectAllowed = 'move';
    //     });
    //     // break;
    // }


    // event listeners

    document.getElementById("delete").addEventListener("click", function () {
        // console.log("click detected!");
        // console.log(`delete section, selected note: ${selectedStickyNote}`);
        // const is_popupFound = document.querySelectorAll('.note-wrapper');
        // alert(is_popup);
        // if(is_popupFound){

        // }
        console.log(selectedStickyNote);
        var selectedwaybillId = selectedStickyNote.getAttribute('data-id');
         var status = 0;
        // console.log(`delete section, selected note: ${selectedStickyNote.getAttribute('data-id')}`);
        console.log(`delete section, selected note: ${selectedwaybillId}`);
        // removeNotePosition(selectedwaybillId);
        deleteWaybill(selectedwaybillId,status,selectedStickyNote);
        contextMenu.style.display = "none"; // Hide context menu after move

    });

    // delete all terminer waybills

    document.getElementById("deleteTerminer").addEventListener("click", function () {

                const dataIds = [];

        // Get the last row of the table
        // const lastRow = document.querySelector('#table-body tr:last-child');
        const lastRow = document.querySelector('tr.target-row');
        console.log("last row: ");
        console.log(lastRow);

        // Select only <td> with the class 'target-cell' inside that row
        const targetTds = lastRow.querySelectorAll('td.note-container');
        console.log(targetTds);

        // For each target td, find div[data-id] and extract the value
        targetTds.forEach(td => {

            const divs = td.querySelectorAll('div[data-id]');
            divs.forEach(div => {
            dataIds.push(div.getAttribute('data-id'));
            });
        });

        console.log(dataIds); // Output: ["301", "302"]
        // var popupNoteWrapper = document.querySelector(`div.note-wrapper[data-id="${dataIds[0]}"]`);
        // popupNoteWrapper.remove();
        for (var deleteCount=0; deleteCount<dataIds.length;deleteCount++){

                    var removeStickyNote = document.querySelector(`.bottom-sticky-note[data-id="${dataIds[deleteCount]}"]`);
                    console.log(dataIds[deleteCount]);
                    removeNotePosition(dataIds[deleteCount]);
                    removeStickyNote.remove();
                    // deleteWaybill(stcikyNoteId,status,selectedStickyNote=false);
                    console.log(`delete section, selected note: ${dataIds[deleteCount]}`);
                    var selectedwaybillId = dataIds[deleteCount];
                    var status = 0;
                    deleteWaybill(selectedwaybillId,status);
                    showAllNotes();

                contextMenu.style.display = "none"; // Hide context menu after deleting
    }


    });

    /*document.getElementById("deleteMiraTerminer").addEventListener("click", function () {

                const miraDataIds = [];

        // Get the last row of the table
        // const lastRow = document.querySelector('#table-body tr:last-child');
        const firstRow = document.querySelector('tr.mira-row');
        console.log("mira row: ");
        console.log(firstRow);

        // Select only <td> with the class 'target-cell' inside that row
        const targetTds = firstRow.querySelectorAll('td.note-container');
        console.log(targetTds);

        // For each target td, find div[data-id] and extract the value
        // targetTds.forEach(td => {

        //     const miradivs = td.querySelectorAll('div[data-id]');
        //     miradivs.forEach(div => {
        //     miraDataIds.push(div.getAttribute('data-id'));
        //     });
        // });

   /*         targetTds.forEach(td => {
        const miradivs = td.querySelectorAll('div[data-id]');
        miradivs.forEach(div => {
            if ( (!div.classList.contains('cheque-editable')) && (!div.classList.contains('miraSP')) ) {
                miraDataIds.push(div.getAttribute('data-id'));
            }
        });
    // });

    targetTds.forEach(td => {
    const miradivs = td.querySelectorAll('div[data-id]');

            miradivs.forEach(div => {

                if (div.closest('table.inside-table')) {
                    return;
                }


                if (
                    !div.classList.contains('cheque-editable')
                ) {
                    miraDataIds.push(div.getAttribute('data-id'));
                }
            });
        });



        console.log(miraDataIds); // Output: ["301", "302"]
        // var popupNoteWrapper = document.querySelector(`div.note-wrapper[data-id="${dataIds[0]}"]`);
        // popupNoteWrapper.remove();
        for (var deleteCount=0; deleteCount<miraDataIds.length;deleteCount++){

                    var removeStickyNote = document.querySelector(`.bottom-sticky-note[data-id="${miraDataIds[deleteCount]}"]`);
                    console.log(miraDataIds[deleteCount]);
                    removeNotePosition(miraDataIds[deleteCount]);
                    removeStickyNote.remove();
                    // deleteWaybill(stcikyNoteId,status,selectedStickyNote=false);
                    console.log(`delete section, selected note: ${miraDataIds[deleteCount]}`);
                    var selectedwaybillId = miraDataIds[deleteCount];
                    var status = 0;
                    deleteWaybill(selectedwaybillId,status);
                    showAllNotes();

                contextMenu.style.display = "none"; // Hide context menu after deleting
    }


    });*/

    // clear waybills from mira row (1st row) of the dashboard table
    document.getElementById("deleteMiraWeeklyTerminer").addEventListener("click", function () {

                const miraDataIds = [];
        const targetTd = document.getElementById('cell78');

        if (targetTd) {
            const miradivs = targetTd.querySelectorAll('div[data-id]');
            miradivs.forEach(div => {
                if (!div.classList.contains('cheque-editable')) {
                    miraDataIds.push(div.getAttribute('data-id'));
                }
            });
        } else {
            console.warn("No <td> found with id 'cell78'");
        }

        for (var deleteCount=0; deleteCount<miraDataIds.length;deleteCount++){

                    var removeStickyNote = document.querySelector(`.bottom-sticky-note[data-id="${miraDataIds[deleteCount]}"]`);
                    console.log(miraDataIds[deleteCount]);
                    removeNotePosition(miraDataIds[deleteCount]);
                    removeStickyNote.remove();
                    // deleteWaybill(stcikyNoteId,status,selectedStickyNote=false);
                    console.log(`delete section, selected note: ${miraDataIds[deleteCount]}`);
                    var selectedwaybillId = miraDataIds[deleteCount];
                    var status = 0;
                    deleteWaybill(selectedwaybillId,status);
                    showAllNotes();

                contextMenu.style.display = "none"; // Hide context menu after deleting
    }


    });

    document.getElementById("moveToLundi").addEventListener("click", function () {
        // alert(`refresh value: ${refresh}`);
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell11");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell0");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("moveToMardi").addEventListener("click", function () {
        console.log(selectedStickyNote);
        insertNoteInCell(selectedStickyNote,"cell9");

        /*const destinationCell = document.querySelector("#cell9");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();*/
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // move To Mercredi

    document.getElementById("moveToMercredi").addEventListener("click", function () {
        console.log(selectedStickyNote);
        insertNoteInCell(selectedStickyNote,"cell20");

        /*const destinationCell = document.querySelector("#cell20");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();*/
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });


    document.getElementById("moveToJeudi").addEventListener("click", function () {
        console.log(selectedStickyNote);
        insertNoteInCell(selectedStickyNote,"cell30");

        /*const destinationCell = document.querySelector("#cell30");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();*/
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("moveToVendredi").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell48");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell40");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("moveTovenir").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell48");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell50");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });


    document.getElementById("moveToMiraMTL").addEventListener("click", function () {
        // alert(`refresh value: ${refresh}`);
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell11");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell60");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });


    document.getElementById("moveToMiraR-S").addEventListener("click", function () {
        // alert(`refresh value: ${refresh}`);
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell11");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell62");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("moveToMiraR-N").addEventListener("click", function () {
        // alert(`refresh value: ${refresh}`);
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell11");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell64");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("moveToMiraLa").addEventListener("click", function () {
        // alert(`refresh value: ${refresh}`);
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell11");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell66");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });




    // clients

    document.getElementById("Mira").addEventListener("click", function () {
        console.log(selectedStickyNote);
        insertNoteInCell(selectedStickyNote,"cell1");

        /*const destinationCell = document.querySelector("#cell1");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();*/
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Dany").addEventListener("click", function () {
        console.log(selectedStickyNote);
        insertNoteInCell(selectedStickyNote,"cell10");

        /*const destinationCell = document.querySelector("#cell10");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();*/
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        insertNoteInCell(selectedStickyNote,"cell21");

        /*const destinationCell = document.querySelector("#cell21");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();*/
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });
    document.getElementById("Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        insertNoteInCell(selectedStickyNote,"cell31");

        /*const destinationCell = document.querySelector("#cell31");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();*/
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Ramasser").addEventListener("click", function () {
        console.log(selectedStickyNote);
        insertNoteInCell(selectedStickyNote,"cel41");

        /*const destinationCell = document.querySelector("#cell41");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();*/
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Terminer").addEventListener("click", function () {
        console.log(selectedStickyNote);
        insertNoteInCell(selectedStickyNote,"cell51");

        /*const destinationCell = document.querySelector("#cell51");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();*/
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });




    // drivers context menus

    // Guest Driver

    /*document.getElementById("G99").addEventListener("click", function () {
        // alert("found!");
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell8");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "99";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell72");
        // driverAssignment(waybillId,driverId);
        // delivery_status = 3;
        is_mira = 1;
        is_mira_update(waybillId,is_mira);

        // driverAssignment(waybillId,driverId,delivery_status);

        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });*/


    document.getElementById("G99Mira").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell8");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "99";
        updateTableCell(waybillId,driverId);
        // insertNoteInCell(selectedStickyNote,"cell72");
        // driverAssignment(waybillId,driverId);
        // delivery_status = 3;
        // driverAssignment(waybillId,driverId,delivery_status);

        is_mira = 1;
        is_mira_update(waybillId,is_mira);
        insertNoteInCell(selectedStickyNote,"cell74");
        // driverAssignment(waybillId,driverId);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);

        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // sub menu
    document.getElementById("G99Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell32");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "99";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell74");
        // driverAssignment(waybillId,driverId);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("G99Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell44");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "99";

        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell75");
        // driverAssignment(waybillId,driverId);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("G99Ramasser").addEventListener("click", function () {
        // alert("bug!");
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell56");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "99";
        // delivery_status == 1 => delivered | 2=> pickedup | 3=> in-progress
        delivery_status = 2;
        driverAssignment(waybillId,driverId,delivery_status);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell76");

        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("G99Terminer").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell51");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "99";
        delivery_status = 1;
        driverAssignment(waybillId,driverId,delivery_status,commission=true);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell77");
        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("G99MiraTerminer").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const note = selectedStickyNote;
        // const destinationCell = document.querySelector("#cell51");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');

        // fetch & cehck

        fetch(`/admin/waybills/${waybillId}/mira-driver-status`)
    .then(response => response.json())
    .then(data => {
        const assign_driver_id = data.driver_id;
        const mira_status = data.is_mira;
        const existing_delivery_status = data.delivery_status;

        // console.log(`Driver assigned: ${assign_driver_id}`);
        // console.log(`Waybill status: ${delivery_status}`);
        console.log(`Waybill status: ${mira_status}`);

        if (assign_driver_id !=null && mira_status ==1 ) {
            insertNoteInCell(note,"cell72");
            driverAssignment(waybillId,assign_driver_id,delivery_status=1,commission=true);
            // Show confirmation or take another action
        } else {

            is_mira = 1;
        is_mira_update(waybillId,is_mira);
        driverId = "99";
        delivery_status = 1;
        driverAssignment(waybillId,driverId,delivery_status,commission=true);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(note,"cell72");

        }
    })
    .catch(error => {
        console.error('Error fetching waybill data:', error);
    });


        // console.log(`waybillId check: ${waybillId}`);

        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // 1st driver

    document.getElementById("E10Mira").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell8");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);

        driverId = "10";
        // delivery_status = 3;
        // driverAssignment(waybillId,driverId,delivery_status);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell22");
        is_mira = 1;
        is_mira_update(waybillId,is_mira);

        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);
        // driverAssignment(waybillId,driverId);

        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // sub menu
    document.getElementById("E10Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell32");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "10";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell22");
        // driverAssignment(waybillId,driverId);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);

        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("E10Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell44");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "10";

        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell32");
        // driverAssignment(waybillId,driverId);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("E10Ramasser").addEventListener("click", function () {
        // alert("bug!");
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell56");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "10";
        // delivery_status == 1 => delivered | 2=> pickedup | 3=> in-progress
        delivery_status = 2;
        driverAssignment(waybillId,driverId,delivery_status);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell42");

        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("E10Terminer").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell51");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "10";
        delivery_status = 1;
        driverAssignment(waybillId,driverId,delivery_status,commission=true);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell52");
        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("E10MiraTerminer").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const note = selectedStickyNote;
        // const destinationCell = document.querySelector("#cell51");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
         fetch(`/admin/waybills/${waybillId}/mira-driver-status`)
    .then(response => response.json())
    .then(data => {
        const assign_driver_id = data.driver_id;
        const mira_status = data.is_mira;
        const existing_delivery_status = data.delivery_status;

        // console.log(`Driver assigned: ${assign_driver_id}`);
        // console.log(`Waybill status: ${delivery_status}`);
        console.log(`Waybill status: ${mira_status}`);

        if (assign_driver_id !=null && mira_status ==1 ) {
            insertNoteInCell(note,"cell2");
            driverAssignment(waybillId,assign_driver_id,delivery_status=1,commission=true);
            // Show confirmation or take another action
        } else {
             is_mira = 1;
            is_mira_update(waybillId,is_mira);
            driverId = "10";
            delivery_status = 1;
            driverAssignment(waybillId,driverId,delivery_status,commission=true);
            updateTableCell(waybillId,driverId);
            insertNoteInCell(note,"cell2");

        }
    })
    .catch(error => {
        console.error('Error fetching waybill data:', error);
    });

        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // 2nd driver Jorge

    /*document.getElementById("Jorge 27").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell7");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "27";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell3");
        // driverAssignment(waybillId,driverId);
        // delivery_status = 3;
        // driverAssignment(waybillId,driverId,delivery_status);

        is_mira = 1;
        is_mira_update(waybillId,is_mira);

        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });*/

    document.getElementById("27Mira").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell7");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "27";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell23");
        // driverAssignment(waybillId,driverId);
        // delivery_status = 3;
        // driverAssignment(waybillId,driverId,delivery_status);

        is_mira = 1;
        is_mira_update(waybillId,is_mira);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // sub menu
    document.getElementById("27Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell31");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "27";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell23");
        // driverAssignment(waybillId,driverId);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("27Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell43");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "27";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell33");
        // driverAssignment(waybillId,driverId);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("27Ramasser").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell55");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "27";
        delivery_status = 2;
        driverAssignment(waybillId,driverId,delivery_status);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell43");
        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("27Terminer").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell51");
        // console.log(`selected cellID: ${destinationCell}`);

        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "27";
        delivery_status = 1;
        driverAssignment(waybillId,driverId,delivery_status,commission=true);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell53");
        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("27MiraTerminer").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const note = selectedStickyNote;
        // const destinationCell = document.querySelector("#cell51");
        // console.log(`selected cellID: ${destinationCell}`);

        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);

         fetch(`/admin/waybills/${waybillId}/mira-driver-status`)
    .then(response => response.json())
    .then(data => {
        const assign_driver_id = data.driver_id;
        const mira_status = data.is_mira;
        const existing_delivery_status = data.delivery_status;

        // console.log(`Driver assigned: ${assign_driver_id}`);
        // console.log(`Waybill status: ${delivery_status}`);
        console.log(`Waybill status: ${mira_status}`);
        // console.log(`selected element: ${note}`);
        if (assign_driver_id !=null && mira_status ==1 ) {
            insertNoteInCell(note,"cell3");
            driverAssignment(waybillId,assign_driver_id,delivery_status=1,commission=true);
            // Show confirmation or take another action
        } else {

            is_mira = 1;
        is_mira_update(waybillId,is_mira);
      driverId = "27";
        delivery_status = 1;
        driverAssignment(waybillId,driverId,delivery_status,commission=true);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(note,"cell3");

        }
    })
    .catch(error => {
        console.error('Error fetching waybill data:', error);
    });

        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });


    /*document.getElementById("André 43").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell6");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "43";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell4");
        // driverAssignment(waybillId,driverId);
        // delivery_status = 3;
        // driverAssignment(waybillId,driverId,delivery_status);

        is_mira = 1;
        is_mira_update(waybillId,is_mira);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });*/

    document.getElementById("43Mira").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell6");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "43";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell24");
        // driverAssignment(waybillId,driverId);
        // delivery_status = 3;
        // driverAssignment(waybillId,driverId,delivery_status);
        is_mira = 1;
        is_mira_update(waybillId,is_mira);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // sub menu
    document.getElementById("43Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell30");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "43";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell24");
        // driverAssignment(waybillId,driverId);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("43Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell42");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "43";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell34");
        // driverAssignment(waybillId,driverId);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("43Ramasser").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell54");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "43";
        delivery_status = 2;
        driverAssignment(waybillId,driverId,delivery_status);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell44");
        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("43Terminer").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell51");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "43";
        delivery_status = 1;
        driverAssignment(waybillId,driverId,delivery_status,commission=true);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell54");
        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("43MiraTerminer").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const note = selectedStickyNote;
        // const destinationCell = document.querySelector("#cell51");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);

        fetch(`/admin/waybills/${waybillId}/mira-driver-status`)
        .then(response => response.json())
        .then(data => {
        const assign_driver_id = data.driver_id;
        const mira_status = data.is_mira;
        const existing_delivery_status = data.delivery_status;

        // console.log(`Driver assigned: ${assign_driver_id}`);
        // console.log(`Waybill status: ${delivery_status}`);
        console.log(`Waybill status: ${mira_status}`);

        if (assign_driver_id !=null && mira_status ==1 ) {
            insertNoteInCell(note,"cell4");
            driverAssignment(waybillId,assign_driver_id,delivery_status=1,commission=true);
            // Show confirmation or take another action
        } else {

            is_mira = 1;
        is_mira_update(waybillId,is_mira);
         driverId = "43";
        delivery_status = 1;
        driverAssignment(waybillId,driverId,delivery_status,commission=true);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(note,"cell4");

        }
    })
    .catch(error => {
        console.error('Error fetching waybill data:', error);
    });

        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });


    /*document.getElementById("Raymond 49").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell5");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "49";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell5");
        // driverAssignment(waybillId,driverId);
        // delivery_status = 3;
        // driverAssignment(waybillId,driverId,delivery_status);

        is_mira = 1;
        is_mira_update(waybillId,is_mira);

        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });*/

    document.getElementById("49Mira").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell5");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "49";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell25");
        // driverAssignment(waybillId,driverId);
        // delivery_status = 3;
        // driverAssignment(waybillId,driverId,delivery_status);

        is_mira = 1;
        is_mira_update(waybillId,is_mira);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);

        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });


    // sub menu
    document.getElementById("49Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell29");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "49";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell25");
        // driverAssignment(waybillId,driverId);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("49Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell41");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "49";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell35");
        // driverAssignment(waybillId,driverId);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("49Ramasser").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell53");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "49";
        delivery_status = 2;
        driverAssignment(waybillId,driverId,delivery_status);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell45");
        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("49Terminer").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell51");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "49";
        delivery_status = 1;
        driverAssignment(waybillId,driverId,delivery_status,commission=true);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell55");
        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("49MiraTerminer").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const note = selectedStickyNote;
        // const destinationCell = document.querySelector("#cell51");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);

        fetch(`/admin/waybills/${waybillId}/mira-driver-status`)
        .then(response => response.json())
        .then(data => {
        const assign_driver_id = data.driver_id;
        const mira_status = data.is_mira;
        const existing_delivery_status = data.delivery_status;

        // console.log(`Driver assigned: ${assign_driver_id}`);
        // console.log(`Waybill status: ${delivery_status}`);
        console.log(`Waybill status: ${mira_status}`);

        if (assign_driver_id !=null && mira_status ==1 ) {
            insertNoteInCell(note,"cell5");
            driverAssignment(waybillId,assign_driver_id,delivery_status=1,commission=true);
            // Show confirmation or take another action
        } else {

            is_mira = 1;
        is_mira_update(waybillId,is_mira);
        driverId = "49";
        delivery_status = 1;
        driverAssignment(waybillId,driverId,delivery_status,commission=true);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(note,"cell5");
        }
    })
    .catch(error => {
        console.error('Error fetching waybill data:', error);
    });


        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });


    /*document.getElementById("Arnaud 51").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell3");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "51";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell6");
        // driverAssignment(waybillId,driverId);
        // delivery_status = 3;
        // driverAssignment(waybillId,driverId,delivery_status);

        is_mira = 1;
        is_mira_update(waybillId,is_mira);

        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });*/

    document.getElementById("51Mira").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell3");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "51";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell26");
        // driverAssignment(waybillId,driverId);
        // delivery_status = 3;
        // driverAssignment(waybillId,driverId,delivery_status);

        is_mira = 1;
        is_mira_update(waybillId,is_mira);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);

        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // sub menu
    document.getElementById("51Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell27");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "51";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell26");
        // driverAssignment(waybillId,driverId);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("51Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell39");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "51";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell36");
        // driverAssignment(waybillId,driverId);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("51Ramasser").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell51");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "51";
        delivery_status = 2;
        driverAssignment(waybillId,driverId,delivery_status);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell46");
        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });


    document.getElementById("51Terminer").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell51");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "51";
        delivery_status = 1;
        driverAssignment(waybillId,driverId,delivery_status,commission=true);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell56");
        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("51MiraTerminer").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const note = selectedStickyNote;
        // const destinationCell = document.querySelector("#cell51");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);

        fetch(`/admin/waybills/${waybillId}/mira-driver-status`)
        .then(response => response.json())
        .then(data => {
        const assign_driver_id = data.driver_id;
        const mira_status = data.is_mira;
        const existing_delivery_status = data.delivery_status;

        // console.log(`Driver assigned: ${assign_driver_id}`);
        // console.log(`Waybill status: ${delivery_status}`);
        console.log(`Waybill status: ${mira_status}`);

        if (assign_driver_id !=null && mira_status ==1 ) {
            insertNoteInCell(note,"cell6");
            driverAssignment(waybillId,assign_driver_id,delivery_status=1,commission=true);
            // Show confirmation or take another action
        } else {

            is_mira = 1;
            is_mira_update(waybillId,is_mira);
        driverId = "51";
        delivery_status = 1;
        driverAssignment(waybillId,driverId,delivery_status,commission=true);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(note,"cell6");
        }
    })
    .catch(error => {
        console.error('Error fetching waybill data:', error);
    });


        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });


    /*document.getElementById("Achraf 55").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell4");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "55";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell7");
        // driverAssignment(waybillId,driverId);
        // delivery_status = 3;
        // driverAssignment(waybillId,driverId,delivery_status);

        is_mira = 1;
        is_mira_update(waybillId,is_mira);

        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });*/

    document.getElementById("55Mira").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell4");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "55";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell27");
        // driverAssignment(waybillId,driverId);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);

        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // sub menu
    document.getElementById("55Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell28");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "55";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell27");
        // driverAssignment(waybillId,driverId);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("55Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell40");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "55";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell37");
        // driverAssignment(waybillId,driverId);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("55Ramasser").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell52");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "55";
        delivery_status = 2;
        driverAssignment(waybillId,driverId,delivery_status);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell47");
        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("55Terminer").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell51");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "55";
        delivery_status = 1;
        driverAssignment(waybillId,driverId,delivery_status,commission=true);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell57");
        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("55MiraTerminer").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const note = selectedStickyNote;
        // const destinationCell = document.querySelector("#cell51");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);

        fetch(`/admin/waybills/${waybillId}/mira-driver-status`)
        .then(response => response.json())
        .then(data => {
        const assign_driver_id = data.driver_id;
        const mira_status = data.is_mira;
        const existing_delivery_status = data.delivery_status;

        // console.log(`Driver assigned: ${assign_driver_id}`);
        // console.log(`Waybill status: ${delivery_status}`);
        console.log(`Waybill status: ${mira_status}`);

        if (assign_driver_id !=null && mira_status ==1 ) {
            insertNoteInCell(note,"cell7");
            driverAssignment(waybillId,assign_driver_id,delivery_status=1,commission=true);
            // Show confirmation or take another action
        } else {

            is_mira = 1;
            is_mira_update(waybillId,is_mira);
        driverId = "55";
        delivery_status = 1;
        driverAssignment(waybillId,driverId,delivery_status,commission=true);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(note,"cell7");
        }
    })
    .catch(error => {
        console.error('Error fetching waybill data:', error);
    });


        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });


    /*document.getElementById("Sylvain 64").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell2");
        // console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "64";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell8");
        // driverAssignment(waybillId,driverId);
        // delivery_status = 3;
        // driverAssignment(waybillId,driverId,delivery_status);

        is_mira = 1;
        is_mira_update(waybillId,is_mira);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });*/

    document.getElementById("64Mira").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell2");
        // console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "64";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell28");
        // driverAssignment(waybillId,driverId);
        // delivery_status = 3;
        // driverAssignment(waybillId,driverId,delivery_status);

        is_mira = 1;
        is_mira_update(waybillId,is_mira);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // submenu 01

    document.getElementById("64Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell26");
        // console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "64";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell28");
        // driverAssignment(waybillId,driverId);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("64Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell38");
        // console.log(`selected cellID: ${destinationCell}`);
        // const cell = document.querySelector(`#${cellId}`);
        // const targetCellId = "cell38";
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "64";
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell38");
        // driverAssignment(waybillId,driverId);
        delivery_status = 3;
        driverAssignment(waybillId,driverId,delivery_status);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("64Ramasser").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell50");
        // console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "64";
        delivery_status = 2;
        driverAssignment(waybillId,driverId,delivery_status);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell48");
        // driverAssignment(waybillId,driverId);
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("64Terminer").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell51");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        driverId = "64";
        delivery_status = 1;
        driverAssignment(waybillId,driverId,delivery_status,commission=true);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(selectedStickyNote,"cell58");
        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("64MiraTerminer").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const note = selectedStickyNote;
        // const destinationCell = document.querySelector("#cell51");
        // console.log(`selected cellID: ${destinationCell}`);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);


        fetch(`/admin/waybills/${waybillId}/mira-driver-status`)
        .then(response => response.json())
        .then(data => {
        const assign_driver_id = data.driver_id;
        const mira_status = data.is_mira;
        const existing_delivery_status = data.delivery_status;

        // console.log(`Driver assigned: ${assign_driver_id}`);
        // console.log(`Waybill status: ${delivery_status}`);
        console.log(`Waybill status: ${mira_status}`);

        if (assign_driver_id !=null && mira_status ==1 ) {
            insertNoteInCell(note,"cell8");
            driverAssignment(waybillId,assign_driver_id,delivery_status=1,commission=true);
            // Show confirmation or take another action
        } else {

            is_mira = 1;
            is_mira_update(waybillId,is_mira);
        driverId = "64";
        delivery_status = 1;
        driverAssignment(waybillId,driverId,delivery_status,commission=true);
        updateTableCell(waybillId,driverId);
        insertNoteInCell(note,"cell8");
        }
    })
    .catch(error => {
        console.error('Error fetching waybill data:', error);
    });


        // driverAssignment(waybillId,driverId);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // document.getElementById("MiraWeeklyTerminer").addEventListener("click", function () {
    document.querySelectorAll(".MiraWeeklyTerminer").forEach(function(button) {
    button.addEventListener("click", function () {
        console.log("weekly terminer found!");
        console.log(selectedStickyNote);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        insertNoteInCell(selectedStickyNote,"cell78");

        selectedStickyNote = null; // Clear selection

        contextMenu.style.display = "none"; // Hide context menu after move
    });
});


        /*console.log("weekly terminer found!");
        console.log(selectedStickyNote);
        waybillId = selectedStickyNote.getAttribute('data-id');
        console.log(`waybillId check: ${waybillId}`);
        insertNoteInCell(selectedStickyNote,"cell78");

        selectedStickyNote = null; // Clear selection

        contextMenu.style.display = "none"; // Hide context menu after move
    });*/

    /*document.getElementById("Chauffeur 1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell9");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell9");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // sub menu
    document.getElementById("Ch01Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell33");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell33");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Ch01Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell45");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell45");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Ch01Ramasser").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell57");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell57");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Chauffeur 2").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell10");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell10");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // sub menu
    document.getElementById("Ch02Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell34");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell34");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Ch02Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell46");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell46");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Ch02Ramasser").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell58");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell58");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });*/






    document.body.addEventListener('dblclick', function (event) {
        // Check if the clicked element has the 'editable' class
        // alert("selected!");
        if (event.target.classList.contains('editable') || event.target.classList.contains('bottom-special-Note')) {
            // alert("detected!");
            const cell = event.target;

            const tableName = cell.dataset.table;    // "waybills"
            const columnName = cell.dataset.column;  // "user_id"
            const compValue = columnName.toLowerCase();
            console.log(tableName);
            // const recordId = cell.dataset.id;        // "12345"
            const dashboardCellId = cell.id;

            // Make the cell content editable
            cell.setAttribute('contenteditable', 'true');
            cell.focus(); // Automatically focus on the cell to start editing

            // Store the original value when the cell is focused
            cell.addEventListener('focus', function () {
                if (!this.dataset.originalValue) {
                    this.dataset.originalValue = this.innerText.trim();
                }
            });

            // Handle keydown event for saving on Enter
            cell.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' && !event.shiftKey) {
                    event.preventDefault(); // Prevent adding a new line in the contenteditable element
                    this.blur(); // Trigger the blur event to save the data
                }
            });

            // Save the data when the user finishes editing (blur or Enter)
            cell.addEventListener('blur', function () {
                const selectedNoteId = this.closest('.bottom-sticky-note').dataset.id; // Get the sticky note ID
                const newValue = this.innerText.trim(); // Get the edited value
                if(compValue == 'status')
                {
                    const translatedNewValue = statusConvertion(newValue);
                    if (newValue !== this.dataset.originalValue) {
                    saveEditedData(selectedNoteId, columnName , tableName,translatedNewValue,dashboardCellId); // Custom function to handle saving
                    }
                }
                else{
                // const datacolumn = this.getAttribute('data-column')
                // Ensure the value is changed before sending it to the backend
                if (newValue !== this.dataset.originalValue) {
                    saveEditedData(selectedNoteId, columnName , tableName,newValue,dashboardCellId); // Custom function to handle saving
                }
            }

                // Remove contenteditable attribute after editing
                this.setAttribute('contenteditable', 'false');
                this.removeAttribute('data-original-value'); // Clean up temporary data
            });
        }
        else if (event.target.classList.contains('cheque-editable')) {
            const cell = event.target;

            const tableName = cell.dataset.table;    // "waybills"
            const columnName = cell.dataset.column;  // "user_id"
            const selectedDriver = cell.dataset.id;
            const compValue = columnName.toLowerCase();
            console.log(tableName);
            // const recordId = cell.dataset.id;        // "12345"
            // const dashboardCellId = cell.id;

            // Make the cell content editable
            cell.setAttribute('contenteditable', 'true');
            cell.focus(); // Automatically focus on the cell to start editing

            // Store the original value when the cell is focused
            cell.addEventListener('focus', function () {
                if (!this.dataset.originalValue) {
                    this.dataset.originalValue = this.innerText.trim();
                }
            });

            // Handle keydown event for saving on Enter
            cell.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); // Prevent adding a new line in the contenteditable element
                    this.blur(); // Trigger the blur event to save the data
                }
            });

            cell.addEventListener('blur', function () {
                // const selectedNoteId = this.closest('.bottom-sticky-note').dataset.id; // Get the sticky note ID
                const newValue = this.innerText.trim(); // Get the edited value
                /*if(compValue == 'status')
                {
                    const translatedNewValue = statusConvertion(newValue);
                    if (newValue !== this.dataset.originalValue) {
                    saveEditedData(selectedNoteId, columnName , tableName,translatedNewValue,dashboardCellId); // Custom function to handle saving
                }
                }
                else{*/
                // const datacolumn = this.getAttribute('data-column')
                // Ensure the value is changed before sending it to the backend
                if (newValue !== this.dataset.originalValue) {
                    // saveEditedData(selectedDriver, columnName , tableName,newValue,dashboardCellId); // Custom function to handle saving
                    saveEditedData(selectedDriver, columnName , tableName,newValue); // Custom function to handle saving
                }
            // }

                // Remove contenteditable attribute after editing
                this.setAttribute('contenteditable', 'false');
                this.removeAttribute('data-original-value'); // Clean up temporary data
            });

        }



        else if (event.target.classList.contains('note-editable')) {
            // alert("note editable found!");
            console.log("note editable found!");
            const cell = event.target;

            const tableName = cell.dataset.table;    // "waybills"
            const columnName = cell.dataset.column;  // "user_id"
            const id = cell.dataset.id;
            const compValue = columnName.toLowerCase();
            console.log(tableName);
            console.log(columnName);
            console.log(id);
            // const recordId = cell.dataset.id;        // "12345"
            // const dashboardCellId = cell.id;

            // Make the cell content editable
            cell.setAttribute('contenteditable', 'true');
            cell.focus(); // Automatically focus on the cell to start editing

            // Store the original value when the cell is focused
            cell.addEventListener('focus', function () {
                if (!this.dataset.originalValue) {
                    this.dataset.originalValue = this.innerText.trim();
                }
            });

            // Handle keydown event for saving on Enter
            cell.addEventListener('keydown', function (event) {
            // document.getElementById("note-list").addEventListener('keydown', function (event) {
                if (event.key === "Enter" && event.shiftKey) {
                event.preventDefault(); // Prevent default behavior (line break)

                // Create a new list item
                // let newLi = document.createElement("li");
                // newLi.textContent = ""; // Initially, the new li is empty

                // Append the new list item to the ul
                // document.getElementById("note-list").appendChild(newLi);
                const noteList = document.querySelector(`#note-list-${id}`);
                // alert(noteList);
                if (noteList) {
                // Set the cursor inside the new list item
                /*let selection = window.getSelection();
                let range = document.createRange();
                range.selectNodeContents(newLi);
                selection.removeAllRanges();
                selection.addRange(range);*/

                let newLi = document.createElement("li");
                    newLi.textContent = ""; // Initially, the new li is empty

                    // Append the new list item to the corresponding ul
                    noteList.appendChild(newLi);
                    // newLi.classList.add('note-editable');

                    // Set the cursor inside the new list item (so the user can start typing)
                    newLi.focus();

                    // Wait for the new list item to be added to the DOM
                    setTimeout(() => {
                        let selection = window.getSelection();
                        let range = document.createRange();

                        range.selectNodeContents(newLi);
                        selection.removeAllRanges();
                        selection.addRange(range);
                    }, 0);
                }
            }

                else if (event.key === 'Enter' && !event.shiftKey) {
                    event.preventDefault(); // Prevent adding a new line in the contenteditable element
                    this.blur(); // Trigger the blur event to save the data
                }
            });

            cell.addEventListener('blur', function () {
                // const selectedNoteId = this.closest('.bottom-sticky-note').dataset.id; // Get the sticky note ID
                // const newValue = this.innerText.trim(); // Get the edited value
                // const newValue = document.getElementById("note-list").innerHTML.trim();
                const newValue = this.innerHTML.trim();
                console.log(newValue);
                /*if(compValue == 'status')
                {
                    const translatedNewValue = statusConvertion(newValue);
                    if (newValue !== this.dataset.originalValue) {
                    saveEditedData(selectedNoteId, columnName , tableName,translatedNewValue,dashboardCellId); // Custom function to handle saving
                }
                }
                else{*/
                // const datacolumn = this.getAttribute('data-column')
                // Ensure the value is changed before sending it to the backend
                if (newValue !== this.dataset.originalValue) {
                    saveEditedData(id, columnName , tableName,newValue,dashboardNotes=true); // Custom function to handle saving
                    // saveEditedData(id, columnName , tableName,newValue,dashboardNotes=true); // Custom function to handle saving
                    dashboardNotes = false;
                }
            // }

                // Remove contenteditable attribute after editing
                this.setAttribute('contenteditable', 'false');
                this.removeAttribute('data-original-value'); // Clean up temporary data
            });

        }


    });



//     document.body.addEventListener('dblclick', function (event) {


// });

    // client editable
    document.body.addEventListener('dblclick', function (event) {
        // Check if the clicked element has the 'editable' class
        if (event.target.classList.contains('client-editable')) {
            // alert("detected!");
            const cell = event.target;

            const tableName = cell.dataset.table;    // "waybills"
            const columnName = cell.dataset.column;  // "user_id"
            // const recordId = cell.dataset.id;        // "12345"
            const dashboardCellId = cell.id;
            const selectedClientId = cell.dataset.id;
            const shipper_contact = cell.dataset.sipper_contact;
            const recipient_contact = cell.dataset.recipient_contact;



            // Make the cell content editable
            cell.setAttribute('contenteditable', 'true');
            cell.focus(); // Automatically focus on the cell to start editing

            // Store the original value when the cell is focused
            cell.addEventListener('focus', function () {
                // if (!this.dataset.originalValue) {
                    this.dataset.originalValue = this.innerText.trim();
                    const oldValue = this.dataset.originalValue;
                    console.log(`original value: ${this.dataset.originalValue}`);
                    console.log(`old value: ${oldValue}`);
                // }
            });

            // Handle keydown event for saving on Enter
            cell.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); // Prevent adding a new line in the contenteditable element
                    this.blur(); // Trigger the blur event to save the data
                }
            });

            // Save the data when the user finishes editing (blur or Enter)
            cell.addEventListener('blur', function () {
                // const selectedNoteId = this.closest('.bottom-sticky-note').dataset.id; // Get the sticky note ID
                const selectedNoteId = selectedClientId;
                const newValue = this.innerText.trim(); // Get the edited value
                const intNewValue = +newValue;
                // const datacolumn = this.getAttribute('data-column')
                // Ensure the value is changed before sending it to the backend
                if (newValue !== this.dataset.originalValue) {
                    // saveEditedData(selectedNoteId, columnName , tableName,intNewValue,dashboardCellId,selectedClientId); // Custom function to handle saving
                    saveEditedData(selectedNoteId, columnName , tableName,newValue,dashboardCellId); // Custom function to handle saving
                    if(shipper_contact){
                        // selectedNoteId = shipper_contact;
                        var tableNamenew = "waybills";
                        var columnNamenew = "shipper_contact";
                        saveEditedData(shipper_contact, columnNamenew , tableNamenew,newValue);

                    }
                    else if(recipient_contact)
                    {
                        // selectedNoteId = recipient_contact;
                        var tableNamenew = "waybills";
                        var columnNamenew = "recipient_contact";
                        saveEditedData(recipient_contact, columnNamenew , tableNamenew,newValue);
                    }
                }

                // Remove contenteditable attribute after editing
                this.setAttribute('contenteditable', 'false');
                this.removeAttribute('data-original-value'); // Clean up temporary data
            });
        }
    });

    // Get the context menu and button elements
const tableMenu = document.getElementById('TablecontextMenu');
const toggleTextVisibilityBtn = document.getElementById('toggleTextVisibilityBtn');
const absentButton = document.getElementById('absentBtn');
let targetCell = null;  // This will store the clicked cell



// Show the context menu when right-clicking on a table cell
document.querySelectorAll('.note-container').forEach(cell => {
  cell.addEventListener('contextmenu', (e) => {
    e.preventDefault();  // Prevent the default right-click menu

    // Store the clicked cell for later reference
    targetCell = e.currentTarget;  // Use currentTarget to ensure we target the <td>

    // Position the context menu at the mouse position
    tableMenu.style.left = `${e.pageX}px`;
    tableMenu.style.top = `${e.pageY}px`;
    tableMenu.style.display = 'block';
  });
});

// Hide the context menu when clicking anywhere else
document.addEventListener('click', () => {
    tableMenu.style.display = 'none';
});

// Toggle the visibility of the content inside the target cell when the button is clicked
/*toggleTextVisibilityBtn.addEventListener('click', () => {
  // Check if the target cell contains the div with class 'cell-content'
  const cellContentDiv = targetCell.querySelector('.cheque');

  if (cellContentDiv) {

    // Toggle the visibility of the div (which contains the text)
    // const currentDisplay = cellContentDiv.style.display;
    if (cellContentDiv.classList.contains('hidden')) {
      // If it exists, remove the 'hidden' class
      cellContentDiv.classList.remove('hidden');
    } else {
      // If it does not exist, add the 'hidden' class
      cellContentDiv.classList.add('hidden');
    }
    // if (currentDisplay === 'none') {
    //   cellContentDiv.style.display = 'block';  // Show the content
    // } else {
    //   cellContentDiv.style.display = 'none';  // Hide the content
    // }
  }

  // Close the context menu after performing the action
  contextMenu.style.display = 'none';
});*/
// new comment
/*if (cellContentDiv) {
    const cellId = targetCell.id;  // Assuming each target cell has a unique ID, otherwise you can use a different unique key
    const isHidden = cellContentDiv.classList.contains('hidden');
    console.log(cellId);

    // Toggle visibility
    if (isHidden) {
      cellContentDiv.classList.remove('hidden');
    } else {
      cellContentDiv.classList.add('hidden');
    }

    // Store the visibility state in localStorage
    localStorage.setItem(cellId, !isHidden);

    // Optionally: Log the state to check if it’s saved correctly
    console.log(`Saved state for cell ${cellId}: ${!isHidden ? 'visible' : 'hidden'}`);
  }

  // Close the context menu
  contextMenu.style.display = 'none';
});

// On page load, apply saved visibility states
window.addEventListener('load', () => {
  const cells = document.querySelectorAll('.target-cell');  // Assuming all target cells have the class 'target-cell'

  cells.forEach(cell => {
    const cellContentDiv = cell.querySelector('.cheque');
    const cellId = cell.id;

    // Retrieve the visibility state from localStorage
    const chequesavedState = localStorage.getItem(cellId);

    // If a state is saved, apply it
    if (chequesavedState !== null) {
      if (chequesavedState === 'false') {
        cellContentDiv.classList.add('hidden');
      } else {
        cellContentDiv.classList.remove('hidden');
      }
    }
  });
});

*/

let localData = {
    cheque: '',
    absent: ''
};
let cheque_status = 0;
let absent_status = 0;
// Get the button and target cell
absentButton.addEventListener('click', () => {
  const cellAbsentContentDiv = targetCell.querySelector('.absent');
  const cellChequeContentDiv = targetCell.querySelector('.cheque');
  console.log(`cellChequeContentDiv value: ${cellChequeContentDiv}`);

  if (cellAbsentContentDiv) {
    const cellId = targetCell.id;  // Assuming each target cell has a unique ID

    // Check if the content is hidden
    const isHiddenAbsent = cellAbsentContentDiv.classList.contains('hidden');
    const isHiddenCheque = cellChequeContentDiv.classList.contains('hidden');


    if (isHiddenCheque && isHiddenAbsent ) {
      // Save the state that it's visible

      localData.cheque = "hidden";
      localData.absent = "visible";



    //   localStorage.setItem(cellId, 'visible');
    console.log(`absent value(visible) : ${localData.absent} `);
    console.log(`cheque value(visible) : ${localData.cheque} `);
    //   localStorage.setItem(cellId, JSON.stringify(localData));
    //   database update
      cheque_status = 0;
      absent_status = 1;
      ChequeAbsentUpdate(cellId,cheque_status,absent_status);

      cellChequeContentDiv.classList.add('hidden');
        cellAbsentContentDiv.classList.remove('hidden');
      console.log(`Saved state for cell ${cellId}: visible`);
    }

    else if(isHiddenCheque && !isHiddenAbsent ) {
      // Save the state that it's visible
      localData.cheque = "hidden";
      localData.absent = "hidden";

    //   localStorage.setItem(cellId, 'visible');
    console.log(`absent value(visible) : ${localData.absent} `);
    console.log(`cheque value(visible) : ${localData.cheque} `);
    //   localStorage.setItem(cellId, JSON.stringify(localData));
      //   database update
      cheque_status = 0;
      absent_status = 0;
      ChequeAbsentUpdate(cellId,cheque_status,absent_status);
      cellChequeContentDiv.classList.add('hidden');
        cellAbsentContentDiv.classList.add('hidden');

    }

    else if (!isHiddenCheque && isHiddenAbsent ) {
      // Save the state that it's visible
      localData.cheque = "hidden";
      localData.absent = "visible";

    //   localStorage.setItem(cellId, 'visible');
    console.log(`absent value(visible) : ${localData.absent} `);
    console.log(`cheque value(visible) : ${localData.cheque} `);
      localStorage.setItem(cellId, JSON.stringify(localData));
      //   database update
      cheque_status = 0;
      absent_status = 1;
      ChequeAbsentUpdate(cellId,cheque_status,absent_status);
      cellChequeContentDiv.classList.add('hidden');
        cellAbsentContentDiv.classList.remove('hidden');

    }


  }

  // Close the context menu
  contextMenu.style.display = 'none';
});


toggleTextVisibilityBtn.addEventListener('click', () => {
  const cellChequeContentDiv = targetCell.querySelector('.cheque');
  const cellAbsentContentDiv = targetCell.querySelector('.absent');


  if (cellChequeContentDiv) {
    const cellId = targetCell.id;  // Assuming each target cell has a unique ID

    // Check if the content is hidden
    const isHiddenCheque = cellChequeContentDiv.classList.contains('hidden');
    const isHiddenAbsent = cellAbsentContentDiv.classList.contains('hidden');

    // Only store in localStorage if the cell is NOT hidden (i.e., visible)
    if (isHiddenCheque && isHiddenAbsent ) {
      // Save the state that it's visible
      localData.cheque = "visible";
      localData.absent = "hidden";

    //   localStorage.setItem(cellId, 'visible');
    console.log(`absent value(visible) : ${localData.absent} `);
    console.log(`cheque value(visible) : ${localData.cheque} `);
    //   localStorage.setItem(cellId, JSON.stringify(localData));

        //   database update
      cheque_status = 1;
      absent_status = 0;
      ChequeAbsentUpdate(cellId,cheque_status,absent_status);

      cellChequeContentDiv.classList.remove('hidden');
        cellAbsentContentDiv.classList.add('hidden');
    //   localData.cheque = "";
    //   localData.absent = "";
      console.log(`Saved state for cell ${cellId}: visible`);
    }

    else if(isHiddenCheque && !isHiddenAbsent ) {
      // Save the state that it's visible
        localData.cheque = "visible";
        localData.absent = "hidden";

    //   localStorage.setItem(cellId, 'visible');
        console.log(`absent value(visible) : ${localData.absent} `);
        console.log(`cheque value(visible) : ${localData.cheque} `);
    //   localStorage.setItem(cellId, JSON.stringify(localData));
    //   database update
        cheque_status = 1;
        absent_status = 0;
        ChequeAbsentUpdate(cellId,cheque_status,absent_status);
        cellChequeContentDiv.classList.remove('hidden');
        cellAbsentContentDiv.classList.add('hidden');
    //   localData.cheque = "";
    //   localData.absent = "";
    //   console.log(`Saved state for cell ${cellId}: visible`);
    }

    else if (!isHiddenCheque && isHiddenAbsent ) {
      // Save the state that it's visible
      localData.cheque = "hidden";
      localData.absent = "hidden";

        //   localStorage.setItem(cellId, 'visible');
        console.log(`absent value(visible) : ${localData.absent} `);
        console.log(`cheque value(visible) : ${localData.cheque} `);
        //   localStorage.setItem(cellId, JSON.stringify(localData));
        //   database update
        cheque_status = 0;
        absent_status = 0;
        ChequeAbsentUpdate(cellId,cheque_status,absent_status);
        cellChequeContentDiv.classList.add('hidden');
        cellAbsentContentDiv.classList.add('hidden');

    }


  }

  // Close the context menu
  contextMenu.style.display = 'none';
});

// On page load, apply saved visibility states
window.addEventListener('load', () => {
  const cells = document.querySelectorAll('.target-cell');  // Assuming all target cells have the class 'target-cell'

  cells.forEach(cell => {
    const cellContentDiv = cell.querySelector('.cheque');
    const cellId = cell.id;

    // Retrieve the saved visibility state from localStorage
    const chequesavedState = localStorage.getItem(cellId);

    // If saved state is 'visible', ensure the cell is visible
    if (chequesavedState === 'visible') {
      cellContentDiv.classList.remove('hidden');
    }
  });
});




// Function to handle saving edited data
function saveEditedData(selectedNoteId, columnName , tableName, newValue, dashboardNotes=false) {
    console.log(`Saving data for Note ID: ${selectedNoteId}, data-Table: ${tableName},data-column: ${columnName}, New Value: ${newValue}`) ;
    console.log(typeof newValue);
    console.log(newValue.length);
    // Example AJAX call to send the updated data to the backend
    fetch('/admin/update-sticky-note', {
        // fetch('/update-sticky-note', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ selectedNoteId, columnName,tableName, newValue }),
    })
        .then(response => response.json())
        // .then(data => {
        //     console.log('Data saved successfully:', data);
        // })
        // .catch(error => {
        //     console.error('Error saving data:', error);
        // });

        .then(data => {
        if (data.success) {
            // showAllNotes();
            if(dashboardNotes == false)
            {
                updateNoteDiv(selectedNoteId, columnName, newValue);
            }
            else{
                console.log("note updated!");
            }
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Data updated successfully!',
                showConfirmButton: false, // No button
                timer: 1500, // Notification will disappear in 3 seconds
                timerProgressBar: true, // Show progress bar

            });


        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.error || 'Failed to update data!',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while updating data.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    });
}


function saveEditableNotes(selectedNoteId, columnName , tableName, newValue,dashboardCellId=false,selectedClientId=false,dashboardNotes = false) {
    console.log(`Saving data for Note ID: ${selectedNoteId}, data-Table: ${tableName},data-column: ${columnName}, New Value: ${newValue},dashboard Cell ID: ${dashboardCellId}`) ;
    console.log(typeof newValue);
    // Example AJAX call to send the updated data to the backend
    fetch('/update-editable-notes', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ selectedNoteId, columnName,tableName, newValue }),
    })
        .then(response => response.json())
        // .then(data => {
        //     console.log('Data saved successfully:', data);
        // })
        // .catch(error => {
        //     console.error('Error saving data:', error);
        // });

        .then(data => {
        if (data.success) {
            // showAllNotes();
            if(dashboardNotes == false)
            {
                updateNoteDiv(selectedNoteId, columnName, newValue);
            }
            else{
                console.log("note updated!");
            }
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Data updated successfully!',
                showConfirmButton: false, // No button
                timer: 1500, // Notification will disappear in 3 seconds
                timerProgressBar: true, // Show progress bar

            });


        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.error || 'Failed to update data!',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while updating data.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    });
}



function updatePosition(selectedNoteId, columnName , tableName, newValue,dashboardCellId=false,selectedClientId=false) {
    console.log(`Saving data for Note ID: ${selectedNoteId}, data-Table: ${tableName},data-column: ${columnName}, New Value: ${newValue},dashboard Cell ID: ${dashboardCellId}`) ;
    console.log(typeof newValue);
    // Example AJAX call to send the updated data to the backend
    // fetch('admin/update-sticky-note-position', {
    fetch('/admin/update-sticky-note', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ selectedNoteId, columnName,tableName, newValue }),
    })
        .then(response => response.json())
        // .then(data => {
        //     console.log('Data saved successfully:', data);
        // })
        // .catch(error => {
        //     console.error('Error saving data:', error);
        // });

        .then(data => {
        if (data.success) {
            // showAllNotes();
            updateNoteDiv(selectedNoteId, columnName, newValue);
            /*Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Data updated successfully!',
                showConfirmButton: false, // No button
                timer: 1500, // Notification will disappear in 3 seconds
                timerProgressBar: true, // Show progress bar

            });*/


        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.error || 'Failed to update data!',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while updating data.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    });
}


function removePositionDB(selectedNoteId, columnName , tableName, newValue=false,dashboardCellId=false,selectedClientId=false) {


    // Example AJAX call to send the updated data to the backend

    fetch('/admin/remove-sticky-note-position', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ selectedNoteId, columnName,tableName}),
    })
        .then(response => response.json())
        // .then(data => {
        //     console.log('Data saved successfully:', data);
        // })
        // .catch(error => {
        //     console.error('Error saving data:', error);
        // });

        .then(data => {
        if (data.success) {
            // showAllNotes();
            // updateNoteDiv(selectedNoteId, columnName, newValue);
            console.log("position removed successfully!");
            /*Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Data updated successfully!',
                showConfirmButton: false, // No button
                timer: 1500, // Notification will disappear in 3 seconds
                timerProgressBar: true, // Show progress bar

            });*/


        } else {

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.error || 'Failed to update data!',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while updating data.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    });
}


// Update the note div with the new value on the front-end
function updateNoteDiv(noteId, columnName, newValue) {
    // Find the note div by its ID
    const noteDiv = document.querySelector(`[data-id="${noteId}"]`);

    if (noteDiv) {
        // Depending on the columnName, update the corresponding part of the note
        /*if (columnName === 'status') {
            const statusElement = noteDiv.querySelector('[data-column="status"]');
            if (statusElement) {
                statusElement.innerText = newValue;  // Update status
            }
        }*/

        /*if (columnName === 'user_id') {
            const userIdElement = noteDiv.querySelector('[data-column="user_id"]');
            if (userIdElement) {
                userIdElement.innerText = newValue;  // Update client ID
                // alert("updated!");
            }
        }

        if (columnName === 'dashboard_price') {
            const userIdElement = noteDiv.querySelector('[data-column="dashboard_price"]');
            if (userIdElement) {
                userIdElement.innerText = newValue;  // Update client ID
                // alert("updated!");
            }
        }*/

        if (columnName === 'status') {
            const statusElement = noteDiv.querySelector('[data-column="status"]');
            // alert(`given new value: ${newValue}`);
            if (statusElement) {

                newValue = statusUpdate(newValue,noteDiv);
                // alert(`translated new value: ${newValue}`);
                statusElement.innerText = newValue.toUpperCase();  // Update status
                // alert(newValue);
                // statusUpdate(newValue,noteDiv);
                // alert("status updated!");
            }
        }


        else if (columnName) {
            const userIdElement = noteDiv.querySelector(`[data-column="${columnName}"]`);
            if (userIdElement) {
                userIdElement.innerText = newValue;  // Update client ID
                // alert("updated!");
            }
        }





        // Add more conditions if there are other editable columns
        // For example:
        // else if (columnName === 'phone') { ... }
    }
}
function statusUpdate(value,statusElement)
{
    var temp;
    statusElement.classList.remove(
        'status-tomorrow', 'status-today', 'status-urgent', 'status-tres_urgent',
        'status-code_red', 'status-special_night', 'status-default'
    );

    if(value.toLowerCase() == "tomorrow")
    {
        statusElement.classList.add('status-tomorrow');
        temp = "Lendemain";
    }
    // else if(value.toLowerCase() == "même jour" || value.toLowerCase() == "meme jour")
    else if(value.toLowerCase() == "same_day")
    {
        statusElement.classList.add('status-today');
        temp = "Même JOUR";

    }

    else if(value.toLowerCase() == "urgent")
    {
        statusElement.classList.add('status-urgent');
        temp = "urgent";
    }

    else if(value.toLowerCase() == "very_urgent")
    {
        statusElement.classList.add('status-tres_urgent');
        temp = "TRES urgent";
    }

    else if(value.toLowerCase() == "code_red")
    {
        statusElement.classList.add('status-code_red');
        temp = "Code Rouge";

    }

    else if(value.toLowerCase() == "night")
    {
        statusElement.classList.add('status-special_night');
        temp = "special night";
    }
    // else {
    //     statusElement.classList.add('status-default');
    //         }
    return temp;

}

function deleteWaybill(waybillId, status,selectedWaybill=false) {
    // var csrfToken = "OHbGRCkYbXcBc4rWXjZ5kNvh9VrGoOp0CV3aMbMj";
    // alert("delete waybill function called");
    console.log(waybillId);

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    // alert(csrfToken);
    // var  selectedNoteId = "22582";
    //  var columnName = "user_id";
    //  var tableName = "waybills"
    //  var newValue = "9090";

    fetch('admin/update-approval-status', {
        // fetch('admin/update-sticky-note-', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            // 'X-CSRF-TOKEN': csrfToken  // CSRF Token from meta tag
            // 'X-CSRF-TOKEN': csrfToken,
        },
        // body: JSON.stringify({ selectedNoteId, columnName,tableName, newValue }),
        body: JSON.stringify({
            waybillId,
            status
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // alert('Approval status updated successfully!');
            // Optionally update the UI
            /*if (status === 1) {
                // Update UI for approve
                $('[data-id="'+waybillId+'"]').removeClass('btn-danger').addClass('btn-success');
            } else {
                // Update UI for reject
                $('[data-id="'+waybillId+'"]').removeClass('btn-success').addClass('btn-danger');
            }*/
           if(selectedWaybill)
        {
            // selectedWaybill.classList.add('hidden');
            selectedWaybill.remove();
            // alert("show all note will run!");
                showAllNotes();
        }
            else if(selectedWaybill == false)
            {
                // alert("show all note will run!");
                showAllNotes();
            }
            // showAllNotes();
            console.log("deleted waybill from dashboard successfully!");
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.log(`Error:, ${error}`);
        // alert('Failed to update approval status.');
    });
}

function is_mira_update(waybillId, is_mira) {

    console.log(waybillId);

    var csrfToken = $('meta[name="csrf-token"]').attr('content');


    fetch('admin/update-approval-status', {
        // fetch('admin/update-sticky-note-', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',

        },

        body: JSON.stringify({
            waybillId,
            is_mira
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // showAllNotes();
            console.log("mira waybill assigned ");
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.log(`Error:, ${error}`);
        // alert('Failed to update approval status.');
    });
}


function ChequeAbsentUpdate(cellId,cheque_status,absent_status) {
    // var csrfToken = "OHbGRCkYbXcBc4rWXjZ5kNvh9VrGoOp0CV3aMbMj";
    // alert("delete waybill function called");
    tableName = "dashboard";

    console.log(cellId);
    console.log(`cheque: ${cheque_status}`);
    console.log(`absent: ${absent_status}`);

    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    fetch('/admin/update-cheque-absent', {
        // fetch('admin/update-sticky-note-', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',

        },
        // body: JSON.stringify({ selectedNoteId, columnName,tableName, newValue }),
        body: JSON.stringify({
            cellId,
            tableName,
            cheque_status,
            absent_status
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {

            console.log("cheque-absent status updated in database!");
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.log(`Error:, ${error}`);
        // alert('Failed to update approval status.');
    });
}

// Function to save data into Laravel
function saveData(cell) {
    const newValue = cell.textContent.trim(); // Get the edited value
    const datacolumn = cell.getAttribute('data-column'); // The column name (e.g., 'jour', 'heure', etc.)
    const dataIdCell = cell.getAttribute('data-id'); // The ID of the note (e.g., 22860)
    alert("here!");
}

function statusConvertion(givenStr) {
    var convetedStr;

    // Convert the input string to lowercase for case-insensitive comparison
    givenStr = givenStr.toLowerCase();

    if (givenStr === 'lendemain') {
        convetedStr = 'tomorrow';
    }
    // Uncomment and modify for other cases if needed
    /*else if (givenStr === 'same_day') {
        convetedStr = 'aujourd’hui'
    }*/

    else if (givenStr === 'même jour' || givenStr === 'meme jour') {
        convetedStr = 'same_day';
    }

    else if (givenStr === 'tres urgent') {
        convetedStr = 'very_urgent';
    }

    else if (givenStr === 'code rouge') {
        convetedStr = 'code_red';
    }
    else if (givenStr === 'special night') {
        convetedStr = 'night';
    }

    else if (givenStr === 'urgent') {
        convetedStr = 'urgent';
    }

    /*else {
        convetedStr = givenStr;
    }*/

    return convetedStr;
}



});

</script>

@endpush
