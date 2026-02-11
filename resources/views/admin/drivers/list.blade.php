@extends('adminlte::page')

@section('title', ucfirst('Chauffeurs'))

@push('css')
    <style>
        .dataTables_wrapper{
            background-color : #f4f6f9!important;
        }

        table.dataTable tbody tr{
            background-color : #f4f6f9!important;
        }
    </style>
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content_header')
    <h1>{{ ucfirst('Chauffeurs') }}
        @if(\Laratrust::isAbleTo('admin.drivers.create'))
            <a href="{{ route('admin.drivers.create') }}" class="btn btn-lg btn-success">NOUVEAU</a>
        @endif
    </h1>
@stop

@section('content')
    @role('admin' || 'driver')
    <div class="container">
        <h1 class="mt-4">Bordereaux de livraison pour chauffeur</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Waybill ID</th>
                    <th>Ramassage</th>
                    <th>Livraison</th>
                    <th>Signature</th>
                    {{-- <th>Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @forelse($waybillings as $waybill)
                    <tr>
                        <td>{{ $waybill->id }}</td>

                        {{-- Pickup Image Display (single, first image) --}}
                        <td>
                            @php
                                $firstPickupImg = null;
                                if (!empty($waybill->pickup_image)) {
                                    $rawPickup = $waybill->pickup_image;
                                    if (is_string($rawPickup) && substr(trim($rawPickup), 0, 1) === '[') {
                                        $arrPickup = json_decode($rawPickup, true);
                                        $firstPickupImg = is_array($arrPickup) && count($arrPickup) > 0 ? $arrPickup[0] : null;
                                    } else {
                                        $firstPickupImg = $rawPickup;
                                    }
                                }
                                $firstPickupImg = $firstPickupImg
                                    ? ltrim(preg_replace('~/{2,}~', '/', (string) $firstPickupImg), '/')
                                    : null;
                            @endphp
                            @if($firstPickupImg)
                                <img src="{{ asset('storage/' . $firstPickupImg) }}" alt="Pickup Image" class="img-thumbnail" width="80" style="max-height:80px;object-fit:cover;">
                            @else
                                <span>No Image</span>
                            @endif
                        </td>

                        {{-- Drop Image Display (single, first image) --}}
                        <td>
                            @php
                                $firstDropImg = null;
                                if (!empty($waybill->drop_image)) {
                                    $rawDrop = $waybill->drop_image;
                                    if (is_string($rawDrop) && substr(trim($rawDrop), 0, 1) === '[') {
                                        $arrDrop = json_decode($rawDrop, true);
                                        $firstDropImg = is_array($arrDrop) && count($arrDrop) > 0 ? $arrDrop[0] : null;
                                    } else {
                                        $firstDropImg = $rawDrop;
                                    }
                                }
                                $firstDropImg = $firstDropImg
                                    ? ltrim(preg_replace('~/{2,}~', '/', (string) $firstDropImg), '/')
                                    : null;
                            @endphp
                            @if($firstDropImg)
                                <img src="{{ asset('storage/' . $firstDropImg) }}" alt="Drop Image" class="img-thumbnail" width="80" style="max-height:80px;object-fit:cover;">
                            @else
                                <span>No Image</span>
                            @endif
                        </td>

                        {{-- Signature Display --}}
                        <td>
                            @if($waybill->signature)
                                {{-- <img src="{{ $waybill->signature }}" alt="Signature" class="img-thumbnail" width="100"> --}}
                                <img src="{{ asset('storage/' . $waybill->signature)}}" alt="Signature" class="img-thumbnail" width="100">
                            @else
                                <span>No Signature</span>
                            @endif
                        </td>

                        {{-- Action Column --}}
                        {{-- <td>
                             <a href="{{ route('admin.drivers.edit', $waybill->id) }}" class="btn btn-sm btn-info">Edit</a>
                        </td>--}}
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No Waybills Found for Driver</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endrole
@stop

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
    {{-- <script>
        $(document).ready(function() {
            $('table').DataTable();
        });
    </script> --}}
@endpush
