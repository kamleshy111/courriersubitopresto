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




@section('content')

@role('admin')

    <div class="container">
        <h1 class="mt-4">COURRIER SUBITO PRESTO ENR.</h1>
        {{-- <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px;"> --}}
        {{-- <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th colspan="2" style="text-align: left; padding: 5px;">Nom: DSP</th>
                <th colspan="2" style="text-align: left; padding: 5px;">Numéro: 43</th>
                <th colspan="2" style="text-align: left; padding: 5px;">Date: 21/11/25</th>
            </tr>
            <tr style="background-color: #f0f0f0;">
                <th style="border: 1px solid black; padding: 5px;">Ramassage</th>
                <th style="border: 1px solid black; padding: 5px;">Livraison</th>
                <th style="border: 1px solid black; padding: 5px;">Facture</th>
                <th style="border: 1px solid black; padding: 5px;">Code</th>
                <th style="border: 1px solid black; padding: 5px;">Explication</th>
                <th style="border: 1px solid black; padding: 5px;">Prix</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border: 1px solid black; padding: 5px;">Brigdeview</td>
                <td style="border: 1px solid black; padding: 5px;">15000 Transcanada</td>
                <td style="border: 1px solid black; padding: 5px;">B000132</td>
                <td style="border: 1px solid black; padding: 5px;">LENO</td>
                <td style="border: 1px solid black; padding: 5px;">18E</td>
                <td style="border: 1px solid black; padding: 5px;">18.00</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px;">999 Ave de Liesse</td>
                <td style="border: 1px solid black; padding: 5px;">Mira</td>
                <td style="border: 1px solid black; padding: 5px;">Auto</td>
                <td style="border: 1px solid black; padding: 5px;">LENO</td>
                <td style="border: 1px solid black; padding: 5px;">30E</td>
                <td style="border: 1px solid black; padding: 5px;">30.00</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px;">Chipe</td>
                <td style="border: 1px solid black; padding: 5px;">38 Hickson</td>
                <td style="border: 1px solid black; padding: 5px;">B000133</td>
                <td style="border: 1px solid black; padding: 5px;">LENO</td>
                <td style="border: 1px solid black; padding: 5px;">15E</td>
                <td style="border: 1px solid black; padding: 5px;">15.00</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px;">Courval</td>
                <td style="border: 1px solid black; padding: 5px;">3120 P.L.W.</td>
                <td style="border: 1px solid black; padding: 5px;">B000134</td>
                <td style="border: 1px solid black; padding: 5px;">LENO</td>
                <td style="border: 1px solid black; padding: 5px;">18E</td>
                <td style="border: 1px solid black; padding: 5px;">18.00</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px;">100 la Canetiere</td>
                <td style="border: 1px solid black; padding: 5px;">Mira</td>
                <td style="border: 1px solid black; padding: 5px;">Semi</td>
                <td style="border: 1px solid black; padding: 5px;">LENO</td>
                <td style="border: 1px solid black; padding: 5px;">15E</td>
                <td style="border: 1px solid black; padding: 5px;">15.00</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px;">...</td>
                <td style="border: 1px solid black; padding: 5px;">410 McGill</td>
                <td style="border: 1px solid black; padding: 5px;">Semi</td>
                <td style="border: 1px solid black; padding: 5px;">LENO</td>
                <td style="border: 1px solid black; padding: 5px;">15E</td>
                <td style="border: 1px solid black; padding: 5px;">15.00</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px;">...</td>
                <td style="border: 1px solid black; padding: 5px;">Systalk</td>
                <td style="border: 1px solid black; padding: 5px;">1247773</td>
                <td style="border: 1px solid black; padding: 5px;">LENO</td>
                <td style="border: 1px solid black; padding: 5px;">5BTE</td>
                <td style="border: 1px solid black; padding: 5px;">5.00</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px;">Plastique Chareau</td>
                <td style="border: 1px solid black; padding: 5px;">Annabella</td>
                <td style="border: 1px solid black; padding: 5px;">N000042</td>
                <td style="border: 1px solid black; padding: 5px;">LENO</td>
                <td style="border: 1px solid black; padding: 5px;">29E</td>
                <td style="border: 1px solid black; padding: 5px;">29.00</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="text-align: right; padding: 5px; font-weight: bold;">TOTAL:</td>
                <td style="border: 1px solid black; padding: 5px; font-weight: bold;">145.00</td>
            </tr>
        </tfoot>
    </table>

<p style="margin-top: 10px; font-style: italic;">Respecter vos colonnes s'il vous plaît - La direction</p> --}}

{{-- <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th colspan="2">Nom: DSP</th>
            <th colspan="2">Numéro: 43</th>
            <th colspan="2">Date: 21/11/25</th>
        </tr>
        <tr>
            <th>Ramassage</th>
            <th>Livraison</th>
            <th>Facture</th>
            <th>Code</th>
            <th>Explication</th>
            <th>Prix</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $waybills->id ?? 'Unknown Driver' }}</td>
            <td>15000 Transcanada</td>
            <td>B000132</td>
            <td>LENO</td>
            <td>18E</td>
            <td>18.00</td>
        </tr>
        <tr>
            <td>999 Ave de Liesse</td>
            <td>Mira</td>
            <td>Auto</td>
            <td>LENO</td>
            <td>30E</td>
            <td>30.00</td>
        </tr>
        <tr>
            <td>Chipe</td>
            <td>38 Hickson</td>
            <td>B000133</td>
            <td>LENO</td>
            <td>15E</td>
            <td>15.00</td>
        </tr>
        <tr>
            <td>Courval</td>
            <td>3120 P.L.W.</td>
            <td>B000134</td>
            <td>LENO</td>
            <td>18E</td>
            <td>18.00</td>
        </tr>
        <tr>
            <td>100 la Canetiere</td>
            <td>Mira</td>
            <td>Semi</td>
            <td>LENO</td>
            <td>15E</td>
            <td>15.00</td>
        </tr>
        <tr>
            <td>...</td>
            <td>410 McGill</td>
            <td>Semi</td>
            <td>LENO</td>
            <td>15E</td>
            <td>15.00</td>
        </tr>
        <tr>
            <td>...</td>
            <td>Systalk</td>
            <td>1247773</td>
            <td>LENO</td>
            <td>5BTE</td>
            <td>5.00</td>
        </tr>
        <tr>
            <td>Plastique Chareau</td>
            <td>Annabella</td>
            <td>N000042</td>
            <td>LENO</td>
            <td>29E</td>
            <td>29.00</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="text-align: right; font-weight: bold;">TOTAL:</td>
            <td style="font-weight: bold;">145.00</td>
        </tr>
    </tfoot>
</table> --}}


<table class="table table-bordered table-striped">
    <thead>
        <tr>
            {{-- <th colspan="2">Nom: {{ $waybill->driver->name ?? 'Unknown Driver' }}</th> --}}
            {{-- <th colspan="2">Nom: {{ $user->name ?? 'Unknown Driver' }}</th> --}}
            <th colspan="2">Nom: {{ $drivers[$waybills->first()->driver_id]->name ?? 'Unknown Driver' }}</th>

            <th colspan="2">Numéro: {{ $waybills->first()->driver_id ?? 'N/A' }}</th>
            <th colspan="2">Date: {{ now()->format('d/m/y') }}</th>
        </tr>
        <tr>
            <th>Ramassage</th>
            <th>Livraison</th>
            <th>Facture</th>
            <th>Code</th>
            <th>Explication</th>
            <th>Prix</th>
        </tr>
    </thead>
    <tbody>
        @php $totalPrice = 0; @endphp

        @foreach($waybills as $waybill)
            <tr>
                {{-- <td>{{ $waybill->pickup_address ?? 'N/A' }}</td> --}}
                <td>{{ $waybill->shipper->address ?? 'N/A' }}</td>
                <td>{{ $waybill->recipient->address ?? 'N/A' }}</td>
                {{-- <td>{{ $waybill->delivery_address ?? 'N/A' }}</td> --}}
                {{-- <td>{{ $waybill->invoice_number ?? 'N/A' }}</td> --}}
                <td>{{ $waybill->shipper->prefix . str_pad($waybill->soft_id, 6, 0, STR_PAD_LEFT) }}</td>
                {{-- <td>{{ $waybill->code ?? 'N/A' }}</td> --}}
                <td contenteditable="true">{{ $waybill->status ?? 'N/A' }}</td>
                <td contenteditable="true">{{ $waybill->description ?? 'N/A' }}</td>
                <td contenteditable="true">{{ number_format($waybill->price, 2) }}</td>
            </tr>
            @php $totalPrice += $waybill->price; @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="text-align: right; font-weight: bold;">TOTAL:</td>
            <td style="font-weight: bold;" contenteditable="true">{{ number_format($totalPrice, 2) }}</td>
        </tr>
    </tfoot>
</table>


    {{-- <thead>
        <tr>
            <th>Waybill Number</th>
            <th>Recipient</th>
            <th>Shipper</th>
            <th>Driver Name</th>
            <th>Delivery Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($waybills as $waybill)
            <tr>
                <td>{{ $waybill->shipper->prefix . str_pad($waybill->soft_id, 6, 0, STR_PAD_LEFT) }}</td>
                <td>{{ $waybill->recipient->name ?? 'N/A' }}</td>
                <td>{{ $waybill->shipper->name ?? 'N/A' }}</td>
                <td>{{ $waybill->driver->name ?? 'Unknown Driver' }}</td>
                <td>Delivered</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No Delivered Waybills Found</td>
            </tr>
        @endforelse
    </tbody>
</table> --}}
<p style="margin-top: 10px; font-style: italic;">Respecter vos colonnes s'il vous plaît - La direction</p>
    </div>
    @endrole
@endsection

