@extends('adminlte::page')

@section('title', ucfirst('Chauffeurs'))
@section('content_header')

<meta charset="UTF-8">


@endsection

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
        <div class="container">
            <h1 class="mt-4">Bordereaux de livraison pour chauffeur</h1>
            {{-- debug {{ app()->getLocale() }} --}}
            @forelse($waybills as $waybill)
                <div class="section-container">
                    <div style="display: flex; align-items: center;">
                        {{-- <h3 style="margin-right: 10px;">Waybill ID: {{ $waybill->id }}</h3> --}}
                        <h3 style="margin-right: 10px;">Waybill Number: {{ $waybill->shipper->prefix . str_pad($waybill->soft_id, 6, 0, STR_PAD_LEFT);}}</h3>
                        @if($waybill->delivery_status == 1)
                            <span class="btn btn-lg btn-success">Already Delivered</span>
                        @endif
                    </div>


                    <!-- Pickup Image Upload -->
                    <div class="upload-section">
                        <h5>{{ __('translations.televerser') }} image pour ramassage</h5>
                        @php
                            $pickupImages = [];
                            if (!empty($waybill->pickup_image)) {
                                $rawPickup = $waybill->pickup_image;
                                if (is_string($rawPickup) && substr(trim($rawPickup), 0, 1) === '[') {
                                    $arrPickup = json_decode($rawPickup, true);
                                    $pickupImages = is_array($arrPickup) ? $arrPickup : [];
                                } else {
                                    $pickupImages = [$rawPickup];
                                }
                            }
                        @endphp
                        @forelse($pickupImages as $img)
                            @php
                                $normalizedImg = $img
                                    ? ltrim(preg_replace('~/{2,}~', '/', (string) $img), '/')
                                    : null;
                            @endphp
                            @if($normalizedImg)
                                <img src="{{ asset('storage/' . $normalizedImg) }}" alt="Pickup Image" class="img-thumbnail mr-1 mb-1" width="120" style="max-height:120px;object-fit:cover;">
                            @endif
                        @empty
                            <span>No Image</span>
                        @endforelse
                    </div>

                    <!-- Drop Image Upload -->
                    <div class="upload-section">
                        <h5>{{ __('translations.televerser') }}  image pour livraison</h5>
                        @php
                            $dropImages = [];
                            if (!empty($waybill->drop_image)) {
                                $rawDrop = $waybill->drop_image;
                                if (is_string($rawDrop) && substr(trim($rawDrop), 0, 1) === '[') {
                                    $arrDrop = json_decode($rawDrop, true);
                                    $dropImages = is_array($arrDrop) ? $arrDrop : [];
                                } else {
                                    $dropImages = [$rawDrop];
                                }
                            }
                        @endphp
                        @forelse($dropImages as $img)
                            @php
                                $normalizedImg = $img
                                    ? ltrim(preg_replace('~/{2,}~', '/', (string) $img), '/')
                                    : null;
                            @endphp
                            @if($normalizedImg)
                                <img src="{{ asset('storage/' . $normalizedImg) }}" alt="Drop Image" class="img-thumbnail mr-1 mb-1" width="120" style="max-height:120px;object-fit:cover;">
                            @endif
                        @empty
                            <span>No Image</span>
                        @endforelse
                    </div>
                    
                     {{-- signature note --}}
                    <div class="note-section">
                        <h5>Signature</h5>

                        @if($waybill->signature_note)
                            <h6><strong>{{ $waybill->signature_note }}</strong></h6>
                        @else
                            <span>No Signature Note</span>
                        @endif
                    </div>

                    <!-- Signature Pad -->
                    <div class="upload-section">
                    <h5>signature</h5>
                        @if($waybill->signature)
                        {{-- <img src="{{ $waybill->signature }}" alt="Signature" class="img-thumbnail" width="100"> --}}
                        <img src="{{ asset('storage/' . $waybill->signature)}}" alt="Signature" class="img-thumbnail" width="500">
                    @else
                        <span>No Signature</span>
                    @endif
                    </div>

                    <!-- Delivered Button -->


                </div>
                {{-- @endforelse --}}
                @empty
                <div class="text-center">No Waybills Found for Driver</div>
            @endforelse
        </div>


    @endrole
@stop

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Find the anchor tag inside the li
        let waybillLink = document.querySelector('#dynamic-waybill-link a');

        // Check if the user is logged in and has the 'driver' role
        @if(auth()->check() && auth()->user()->roles->contains('id', 3))
            // Set the dynamic URL for drivers
            waybillLink.href = "{{ url('admin/driver-waybill/' . auth()->id()) }}";
        @else
            // Optionally, set a fallback URL for non-drivers (or leave as is)
            waybillLink.href = "/#"; // or set to some default link
        @endif
    });
</script>
@endpush

