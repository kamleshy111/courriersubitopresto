{{-- production version  --}}
@extends('adminlte::page')

@section('title', ucfirst('Chauffeurs'))

@push('css')
    <style>
        .section-container {
            margin-top: 20px;
        }

        .upload-section {
            margin-bottom: 20px;
        }

        .modal-body {
            padding: 15px;
        }
        .shipper {
            margin-top:20px;
            margin-bottom:40px;
            /* gap: 30px; */
            background-color: #f0f0f0; /* Light gray background for the boxes */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Slight shadow for a 3D effect */
            width: 75%; /*Ensure both boxes take up half of the container width*/
            box-sizing: border-box; /* To include padding in the width calculation */
        }

    .receiver{
            
            margin-bottom:10px;
            background-color: #f0f0f0; /* Light gray background for the boxes */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Slight shadow for a 3D effect */
            width: 75%; /*Ensure both boxes take up half of the container width*/
            box-sizing: border-box; /* To include padding in the width calculation */
        }
    </style>
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content_header')
    <h1>{{ ucfirst('Chauffeurs') }}
        {{-- @if (\Laratrust::isAbleTo('admin.drivers.create'))
            <a href="{{ route('admin.waybills.uploadPickupImage', "2860") }}" class="btn btn-lg btn-success">NOUVEAU</a>
        @endif --}}
    </h1>
@stop

@section('content')
    @role('admin' || 'driver')
    @php
            // $urlSegment = last(request()->segments());
            // echo $urlSegment;
            // var_dump($waybills);
            // echo "hello";
            foreach($waybills as $waybill)
                if ($waybill->delivery_status == 1){ 
                // if($urlSegment == 'pickedup')
                    // echo "here";
                    $title = "Livraison terminé"; 
                //    $title = "Livraison ramassé";
                }
                //    Livraison ramassé (picked up)
                else if ($waybill->delivery_status == 2){
                // else if($urlSegment == 'delivered'){
                    
                    $title = "Livraison ramassé";
                    // Livraison terminé (delivered)
                }
                else if ($waybill->delivery_status == 3 || $waybill->delivery_status == ""){
                // else if($urlSegment == 'in-progress'){
                    $title = "Livraison en cours";
                    // Livraison en cours
                }
            
        // else
        //     $title = "Default Title - Your App Name";
        // endif
        // echo $title;
        
    @endphp
        <div class="container">
            <h1 class="mt-4">{{$title}}</h1>
            {{-- <h1 class="mt-4">Bordereaux de livraison pour chauffeur</h1> --}}

            @forelse($waybills as $waybill)
                <div class="section-container">
                    <div style="display: flex; align-items: center;">
                        {{-- <h3 style="margin-right: 10px;">Waybill ID: {{ $waybill->id }}</h3> --}}
                        <h3 style="margin-right: 10px;">Waybill Number: {{ $waybill->shipper->prefix . str_pad($waybill->soft_id, 6, 0, STR_PAD_LEFT);}}</h3>
                        @if($waybill->delivery_status == 1)
                            <span class="btn btn-lg btn-success">Déjà livré</span>
                        @endif
                    </div>
                    <div class="shipper">
                        {{-- pickup sign note field --}}
                        <div class="note-section">
                            {{-- <h5>Ramassage des signatures</h5> --}}
                            <h5>Signature de l