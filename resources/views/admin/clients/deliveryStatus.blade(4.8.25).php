{{--
updated at 27.3.25
translate dynamically
update buttons & table field according instructions
--}}
@extends('adminlte::page')







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



        @if(\Laratrust::isAbleTo('admin.drivers.create'))

            {{-- <a href="{{route('admin.drivers.create')}}" class="btn btn-lg btn-success">NOUVEAU</a> --}}
            <a href="{{route('admin.waybills.uploadPickupImage' , "2860")}}" class="btn btn-lg btn-success">NOUVEAU</a>


        @endif

    </h1>

@stop



@section('content')

    @role('client')
    @php
            $urlSegment = last(request()->segments());
            // echo $urlSegment;


        if($urlSegment == 'pickedup')
           $title = "Livraison ramassé";
        //    Livraison ramassé (picked up)
        else if($urlSegment == 'delivered'){
            $title = "Livraison terminé";
            // Livraison terminé (delivered)
        }
        else if($urlSegment == 'in-progress'){
            $title = "Livraison en cours";
            // Livraison en cours
        }

        @endphp

    <div class="container">
        <h1 class="mt-4">{{$title}}</h1>
        {{-- <h1 class="mt-4">Livraisons Terminées</h1> --}}

<!-- Date Filter -->
 <div class="mb-3 d-flex align-items-center">
    <label for="filterDate" class="me-2">📅 Filter by Date:</label>
    <input type="date" id="filterDate" class="form-control w-auto" value="{{ $date ?? now()->format('Y-m-d') }}">
</div>

{{-- <input type="date" id="filterDate" class="form-control" value="{{ $date ?? now()->format('Y-m-d') }}">

<table class="table">
    <thead>
        <!-- headings -->
    </thead>
    <tbody id="waybillTable">
        @forelse($waybills as $waybill)
            <tr>
                <td>{{ $waybill->shipper->name }}</td>
                <td>{{ $waybill->shipper->address }}</td>
                <td>{{ $waybill->recipient->name }}</td>
                <td>{{ $waybill->recipient->address }}</td>
                <td>
                    <a href="{{ url('admin/waybill/'. $waybill->id) }}" class="btn btn-primary btn-sm">Voir</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Aucune livraison trouvée</td>
            </tr>
        @endforelse
    </tbody>
</table> --}}

 <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Nom du client de l'expediteur</th>
            <th>Adresse du client de l'expediteur</th>
            <th>Nom du client destinataire</th>
            <th>Adresse du client destinataire</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="waybillTable">
        @forelse($waybills as $waybill)
            <tr>
                <td>{{ $waybill->shipper->name }}</td>
                <td>{{ $waybill->shipper->address }}</td>
                <td>{{ $waybill->recipient->name }}</td>
                <td>{{ $waybill->recipient->address }}</td>
                <td>
                    <a href="{{ url('admin/waybill/'. $waybill->id) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i> Voir Waybill
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Aucune livraison trouvée pour cette date</td>
            </tr>
        @endforelse
    </tbody>
</table>
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
        let waybillInprogress = document.querySelector('#dynamic-waybill-inprogress a');
        let waybillPickedup = document.querySelector('#dynamic-waybill-pickedup a');
        let waybillDelivered = document.querySelector('#dynamic-waybill-delivered a');
        // Check if the user is logged in and has the 'driver' role
        @if(auth()->check() && auth()->user()->roles->contains('id', 3))
            // Set the dynamic URL for drivers
            // waybillLink.href = "{{ url('admin/driver-waybill/' . auth()->id()) }}";
            waybillLink.href = "{{ url('admin/driver-summary-table/' . auth()->id()) }}";
            waybillInprogress.href = "{{ url('admin/driver-waybill/' . auth()->id()) .'/in-progress'}}";
            waybillPickedup.href = "{{ url('admin/driver-waybill/' . auth()->id()) .'/pickedup'}}";
            waybillDelivered.href = "{{ url('admin/driver-waybill/' . auth()->id()) .'/delivered'}}";
        @else
            // Optionally, set a fallback URL for non-drivers (or leave as is)
            waybillLink.href = "/#"; // or set to some default link
        @endif
    });
</script>
{{-- <script>
    document.getElementById('filterDate').addEventListener('change', function () {
        const selectedDate = this.value;
        window.location.href = `?date=${selectedDate}`;
    });
</script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.getElementById('filterDate');
        const tableBody = document.getElementById('waybillTable');

        function fetchWaybills(date) {
            fetch(`/admin/client/waybills/by-date?date=${date}`)
                .then(response => response.json())
                .then(data => {
                    const waybills = data.waybills;
                    tableBody.innerHTML = '';

                    if (waybills.length === 0) {
                        tableBody.innerHTML = `<tr><td colspan="5" class="text-center">Aucune livraison trouvée pour cette date</td></tr>`;
                        return;
                    }

                    waybills.forEach(wb => {
                        const row = `
                            <tr>
                                <td>${wb.shipper_name}</td>
                                <td>${wb.shipper_address}</td>
                                <td>${wb.recipient_name}</td>
                                <td>${wb.recipient_address}</td>
                                <td>
                                    <a href="/admin/waybill/${wb.id}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Voir Waybill
                                    </a>
                                </td>
                            </tr>`;
                        tableBody.insertAdjacentHTML('beforeend', row);
                    });
                })
                .catch(err => {
                    console.error(err);
                    tableBody.innerHTML = `<tr><td colspan="5" class="text-center text-danger">Erreur lors du chargement.</td></tr>`;
                });
        }

        // Initial load
        fetchWaybills(dateInput.value);

        // Filter on date change
        dateInput.addEventListener('change', function () {
            fetchWaybills(this.value);
        });
    });
</script>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.getElementById('filterDate');
        const tableBody = document.getElementById('waybillTable');

        dateInput.addEventListener('change', function () {
            const selectedDate = this.value;

            fetch(`/admin/client/waybills/by-date?date=${selectedDate}`)
                .then(res => res.json())
                .then(data => {
                    const waybills = data.waybills;
                    tableBody.innerHTML = '';

                    if (waybills.length === 0) {
                        tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Aucune livraison trouvée</td></tr>';
                        return;
                    }

                    waybills.forEach(wb => {
                        const row = `
                            <tr>
                                <td>${wb.shipper_name}</td>
                                <td>${wb.shipper_address}</td>
                                <td>${wb.recipient_name}</td>
                                <td>${wb.recipient_address}</td>
                                <td><a href="/admin/waybill/${wb.id}" class="btn btn-sm btn-primary">Voir</a></td>
                            </tr>`;
                        tableBody.insertAdjacentHTML('beforeend', row);
                    });
                });
        });
    });
</script> --}}


@endpush




