{{--
updated at 27.3.25
translate dynamically
update buttons & table field according instructions
--}}
@extends('adminlte::page')



@section('title', ucfirst('Chauffeurs'))



@push('css')

    <style>
    .body{
        font-size: 0.8rem;
    }

    .container, .container-fluid, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
    --bs-gutter-x: 0rem;  /* Set the gutter space */
    /* max-width: 100%;         Set the max width for containers */
    /* padding-left: 15px;      Custom padding */
    /* padding-right: 15px;     Custom padding */
}


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

    <h1>{{ucfirst('Chauffeurs')}}

        @if(\Laratrust::isAbleTo('admin.drivers.create'))

            {{-- <a href="{{route('admin.drivers.create')}}" class="btn btn-lg btn-success">NOUVEAU</a> --}}
            <a href="{{route('admin.waybills.uploadPickupImage' , "2860")}}" class="btn btn-lg btn-success">NOUVEAU</a>


        @endif

    </h1>

@stop



@section('content')

    @role('admin' || 'driver')
    @php
            $urlSegment = last(request()->segments());
            // echo $urlSegment;


        if($urlSegment == 'pickedup')
           $title = "Livraison " . __('translations.ramasse') ;
        //    Livraison ramassé (picked up)
        else if($urlSegment == 'delivered'){
            $title = "Livraison " . __('translations.termine');
            // Livraison terminé (delivered)
        }
        else if($urlSegment == 'in-progress'){
            $title = "Livraison en cours";
            // Livraison en cours
            //{{__('translations.Livraison en cours') }}
        }
         else
             $title = " ";
        // endif
        
        @endphp

    <div class="container">
        {{-- <h1 class="mt-4">Bordereaux de livraison pour chauffeur</h1> --}}

        <h1 class="mt-4">{!! $title !!}</h1>
        <table class="table table-bordered table-striped">
            {{--<thead>
                <tr>
                    <th class="col-2">{{__('translations.Expediteur')}}</th>
                    <th class="col-2">Adresse</th>
                    <th class="col-2">Destinataire</th>
                    <th class="col-2">Adresse</th>


                    <th class="col-4">Action</th>
                    
                    <th class="col-2">Nom du client de l'expediteur</th>
                    <th class="col-12 col-sm-1">Adresse du client de l'{{__('translations.expediteur')}}</th>
                    <th class="col-12 col-sm-3">Nom du client destinataire</th>
                    <th class="col-12 col-sm-2">Adresse du client destinataire</th>
                    <th class="col-12 col-sm-4">Action</th>
                </tr>
            </thead>--}}

             <thead>
      <tr>
          
                    <th class="col-2">{{__('translations.Expediteur')}}</th>
                    <th class="col-2">Adresse</th>
                    <th class="col-2">Destinataire</th>
                    <th class="col-2">Adresse</th>
                    <th class="col-4">Action</th>
        {{--<th class="col-12 col-sm-1">Waybill Number</th>
        <th class="col-12 col-sm-3">Client</th>
        <th class="col-12 col-sm-2">Address</th>
        <th class="col-12 col-sm-2">Date</th>
        <th class="col-12 col-sm-4">Action</th>--}}
      </tr>
    </thead>
    <tbody>
        @forelse($waybills as $waybill)
            <tr>
                {{-- <td>{{ $waybill->soft_id }}</td> --}}
                {{-- <td>{{ $waybill->shipper->prefix . str_pad($waybill->soft_id, 6, 0, STR_PAD_LEFT);}}</td> --}}
                <td> {{ $waybill->shipper->name }}</td>
                <td> {{ $waybill->shipper->address }}</td>
                {{-- <td>hello</td> --}}

                {{-- Pickup Image Upload --}}
                <td>
                    {{-- <form action="{{ route('admin.waybills.uploadPickupImage', $waybill->id) }}" method="POST" enctype="multipart/form-data"> --}}
                        {{-- below two lines was previously turned off! --}}
                        {{-- <form action="{{ route('admin.waybills.uploadPickupImage', $waybill->id) }}" method="POST" enctype="multipart/form-data">  --}}
                    {{-- <input type="file" name="pickup_image" class="form-control mb-2" disabled> --}}
                    {{-- <input type="file" name="pickup_image" class="form-control mb-2"> --}}
                    {{-- <button type="submit" class="btn btn-sm btn-primary">Upload</button> --}}
                    {{-- </form> --}}
                    {{ $waybill->recipient->name }}
                </td>

                {{-- Drop Image Upload --}}
                <td>
                    {{-- <form action="{{ route('admin.waybills.uploadDropImage', $waybill->id) }}" method="POST" enctype="multipart/form-data">
                    <input type="file" name="drop_image" class="form-control mb-2" disabled> old disabled
                    <input type="file" name="drop_image" class="form-control mb-2">
                    <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                    </form> --}}
                    {{ $waybill->recipient->address }}
                </td>

                {{-- Signature Pad --}}


                {{-- Delivery Status Update (Removed action) --}}
                {{-- {{-- <td> --}}
                    {{-- <td>
                    <select name="delivery_status" class="form-control mb-2">
                        <option value="on_the_way" {{ $waybill->delivery_status == 'on_the_way' ? 'selected' : '' }}>On the Way</option>
                        <option value="order_complete" {{ $waybill->delivery_status == 'order_complete' ? 'selected' : '' }}>Order Complete</option>
                    </select>
                </td> --}}
                <td>
                    {{-- <button type="submit" class="btn btn-sm btn-success">Update</button> --}}
                    {{-- <a href="{{ url("admin/waybills-client-index?waybill-type=" ) }}' + waybillType ['id' => $driver->id]) }}" class="btn btn-sm btn-success">
                        <i class="fas fa-edit"></i> signature
                    </a> --}}
                    @if(auth()->check() && auth()->user()->roles->contains('id', 3))
                    <a href="{{ url('/admin/drivers/single-waybill/' . $waybill->id) }}" class="btn btn-sm btn-success">
                        <i class="fas fa-edit"></i> signature
                    </a>
                    @endif
                    {{-- <a href="{{ url('/admin/drivers/single-waybill-image-view/' . $waybill->id) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i> Details
                    </a>

                    <a href="{{ url('/admin/waybills/'. $waybill->id.'?waybill=true') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i> view
                    </a> --}}
                    {{-- http://127.0.0.1:8000/admin/waybills/25221?waybill=true --}}

                    {{--<a href="{{ url('/admin/drivers/single-waybill-image-view/' . $waybill->id) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-info-circle"></i> Details
                    </a>--}}

                    {{--<a href="{{ url('/admin/waybills/'. $waybill->id.'?waybill=true') }}" class="btn btn-sm btn-primary" target="_blank">
                        <i class="fas fa-eye"></i> View
                    </a>
                    <iframe src="https://app.courriersubitopresto.com/admin/waybills/24557?waybill=true" width="100%" height="1000px"></iframe>--}}
                    {{-- google doc mode --}}
                     {{--<a href="{{ url('https://docs.google.com/gview?url=https://app.courriersubitopresto.com/pdf/view') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i> View--}}
                    </a>

                    {{--<a href="{{ url('/pdf/view') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i> View
                    </a>

                    <a href="{{ url('/waybill/'. $waybill->id) }}" class="btn btn-sm btn-primary" target="_blank">
                        <i class="fas fa-eye"></i> View--}}
                    {{-- final --}}
                    <a href="{{ url('admin/waybill/'. $waybill->id) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i> Voir Waybill

                    </a>

                </td>
                {{-- <td><!-- In your Blade template --> --}}
                    {{-- @foreach (Route::getRoutes() as $route)
    <p>{{ $route->getName() }}</p>
@endforeach --}}
                    {{-- </td> --}}
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">Aucune Bordereaux {{__('translations.trouve')}}</td>
            </tr>
        @endforelse
    </tbody>
        </table>
</div>

    {{-- Signature Modal --}}
    <div class="modal fade" id="signatureModal" tabindex="-1" aria-labelledby="signatureModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {{-- <form id="signatureForm" method="POST" action="{{ route('admin/waybills/upload-signature') }}"> --}}
                    <form id="signatureForm" action="{{ route('admin.waybills.uploadSignature') }}" method="POST">

                    <form id="signatureForm">
                        @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="signatureModalLabel">Add Signature</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <canvas id="signaturePad" style="border: 1px solid #ddd; width: 100%; height: 200px;"></canvas>
                        <input type="hidden" name="signature" id="signatureInput">
                        <input type="hidden" name="waybill_id" id="waybillIdInput">
                        <button type="button" class="btn btn-secondary mt-2" onclick="clearSignature()">Clear</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="submitSignature()">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endrole
    @stop
    {{-- @endsection --}}
    {{-- @section('scripts') --}}
    @push('js')
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Bundle JS (includes Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        let signaturePad, canvas;

        function openSignatureModal(waybillId) {

            // Open the modal
            console.log(waybillId);
            const modal = new bootstrap.Modal(document.getElementById('signatureModal'));
            modal.show();

            // Set waybill ID
            document.getElementById('waybillIdInput').value = waybillId;
            alert(waybillId);

            // Initialize signature pad
            canvas = document.getElementById('signaturePad');
            signaturePad = new SignaturePad(canvas);
        }

        function clearSignature() {
            signaturePad.clear();
        }

        function submitSignature() {
            if (!signaturePad.isEmpty()) {
                // Get signature as base64 image
                const dataUrl = signaturePad.toDataURL();
                document.getElementById('signatureInput').value = dataUrl;

                // Submit the form
                document.getElementById('signatureForm').submit();
            } else {
                alert('Please add a signature before submitting.');
            }
        }
    </script>


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




