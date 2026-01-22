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




@section('content')

@role('admin')

    <div class="container">
        {{-- <h1 class="mt-4">{{$title}}</h1> --}}
        <h1 class="mt-4">Livraisons Terminées</h1>

<!-- Date Filter -->
 <div class="mb-3 d-flex align-items-center">
    <label for="filterDate" class="me-2">📅 Filtrer par date:</label>
    <input type="date" id="filterDate" class="form-control w-auto" value="{{ $date ?? now()->format('Y-m-d') }}">
</div>
<div class="mb-3 d-flex align-items-center">
    <label for="filterDriver" class="me-2"> Filtrer par chauffeur:</label>
    <select id="filterDriver" class="form-control w-auto">
        <option value="">-- All Drivers --</option>
        @foreach($drivers as $driver)
            {{--<option value="{{ $driver->id }}">{{ $driver->name }}</option>--}}
            
            <option value="{{ $driver->id }}">{{ $driver->name }} - {{ $driver->id }}</option>
        @endforeach
    </select>
</div>


 <table id="waybillTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Nom du client de l'expediteur</th>
            <th>Adresse du client de l'expediteur</th>
            <th>Nom du client destinataire</th>
            <th>Adresse du client destinataire</th>
            <th>Chauffeur assigné</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody id="waybillTableBody">
    @forelse($waybills as $waybill)
        <tr data-driver-id="{{ $waybill->driver_id }}">
            <td>{{ $waybill->shipper->name }}</td>
            <td>{{ $waybill->shipper->address }}</td>
            <td>{{ $waybill->recipient->name }}</td>
            <td>{{ $waybill->recipient->address }}</td>
            <td>
                {{-- {{ $waybill->driver->name ?? 'Non Assigné' }} --}}
                {{ $waybill->driver_id
                    ? ($waybill->driver_id == 99 ? '01' : ($waybill->driver_id == 27 ? '20' : $waybill->driver_id))
                    : 'Non Assigné'
                }}
            </td>
            <td>
                <a href="{{ url('admin/waybill/'. $waybill->id) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-eye"></i> Voir Waybill
                </a>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="text-end fw-bold">
                Total Waybills: {{ $waybills->count() }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center">Aucune livraison trouvée pour cette date</td>
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
            // waybillLink.href = "/#"; // or set to some default link
        @endif
    });
</script>
{{-- <script>
    document.getElementById('filterDate').addEventListener('change', function () {
        const selectedDate = this.value;
        window.location.href = `?date=${selectedDate}`;
    });
</script> --}}

{{--<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.getElementById('filterDate');
        const tableBody = document.getElementById('waybillTable');
        console.log("here");
        // console.log(`${date}`);
        function fetchWaybills(date) {
            console.log("📅 Fetching waybills for date:", date);
            // fetch(`/admin/summary-table/by-date?date=${date}`)
            fetch(`/admin/summary-table/by-date?date=${date}`)

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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const driverSelect = document.getElementById('filterDriver');
    const rows = document.querySelectorAll('#waybillTable tr');

    driverSelect.addEventListener('change', function () {
        const selectedDriverId = this.value;

        rows.forEach(row => {
            const rowDriverId = row.getAttribute('data-driver-id');

            if (!selectedDriverId || rowDriverId === selectedDriverId) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
--}}

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

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const dateInput = document.getElementById('filterDate');
        const driverSelect = document.getElementById('filterDriver');
        const tableBody = document.getElementById('waybillTableBody');
         const tableFooter = document.getElementById('waybillFooter');
        let cachedWaybills = [];

    //     function renderWaybills(filteredWaybills) {

    //         tableBody.innerHTML = '';
    //         tableFooter.innerHTML = '';

    //         if (filteredWaybills.length === 0) {
    //             tableBody.innerHTML = `<tr><td colspan="6" class="text-center">Aucune livraison trouvée</td></tr>`;
    //             return;
    //         }

    //         filteredWaybills.forEach(wb => {
    //             const row = `
    //                 <tr data-driver-id="${wb.driver_id}">
    //                     <td>${wb.shipper_name}</td>
    //                     <td>${wb.shipper_address}</td>
    //                     <td>${wb.recipient_name}</td>
    //                     <td>${wb.recipient_address}</td>
    //                     <td>${wb.driver_name ?? 'Non assigné'}</td>
    //                     <td>
    //                         <a href="/admin/waybill/${wb.id}" class="btn btn-sm btn-primary">
    //                             <i class="fas fa-eye"></i> Voir Waybill
    //                         </a>
    //                     </td>
    //                 </tr>`;
    //             tableBody.insertAdjacentHTML('beforeend', row);
    //         });

    //         // ✅ Add footer with total count
    // tableFooter.innerHTML = `<tr><td colspan="6" class="text-end fw-bold">Total Waybills: ${filteredWaybills.length}</td></tr>`;
    //     }

    /*function renderWaybills(filteredWaybills) {
    const tableFooter = document.getElementById('waybillFooter');
    tableBody.innerHTML = '';
    // tableFooter.innerHTML = ''; // Always clear footer

    if (filteredWaybills.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="6" class="text-center">Aucune livraison trouvée</td></tr>`;
        tableFooter.innerHTML = `<tr><td colspan="6" class="text-end fw-bold">Total Waybills: 0</td></tr>`;
        return;
    }

    filteredWaybills.forEach(wb => {
        const row = `
            <tr data-driver-id="${wb.driver_id}">
                <td>${wb.shipper_name}</td>
                <td>${wb.shipper_address}</td>
                <td>${wb.recipient_name}</td>
                <td>${wb.recipient_address}</td>
                <td>${wb.driver_name ?? 'Non assigné'}</td>
                <td>
                    <a href="/admin/waybill/${wb.id}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i> Voir Waybill
                    </a>
                </td>
            </tr>`;
        tableBody.insertAdjacentHTML('beforeend', row);
    });

    // ✅ Always update footer
    tableFooter.innerHTML = `<tr><td colspan="6" class="text-end fw-bold">Total Waybills: ${filteredWaybills.length}</td></tr>`;
}*/

// function renderWaybills(filteredWaybills) {
//     const tableFooter = document.getElementById('waybillFooter');
//     tableBody.innerHTML = '';

//     if (tableFooter) {
//         tableFooter.innerHTML = ''; // Clear footer if exists
//     }

//     if (filteredWaybills.length === 0) {
//         tableBody.innerHTML = `<tr><td colspan="6" class="text-center">Aucune livraison trouvée</td></tr>`;
//         if (tableFooter) {
//             tableFooter.innerHTML = `<tr><td colspan="6" class="text-end fw-bold">Total Waybills: 0</td></tr>`;
//         }
//         return;
//     }

//     filteredWaybills.forEach(wb => {
//         const row = `
//             <tr data-driver-id="${wb.driver_id}">
//                 <td>${wb.shipper_name}</td>
//                 <td>${wb.shipper_address}</td>
//                 <td>${wb.recipient_name}</td>
//                 <td>${wb.recipient_address}</td>
//                 <td>${wb.driver_name ?? 'Non assigné'}</td>
//                 <td>
//                     <a href="/admin/waybill/${wb.id}" class="btn btn-sm btn-primary">
//                         <i class="fas fa-eye"></i> Voir Waybill
//                     </a>
//                 </td>
//             </tr>`;
//         tableBody.insertAdjacentHTML('beforeend', row);
//     });

//     if (tableFooter) {
//         tableFooter.innerHTML = `<tr><td colspan="6" class="text-end fw-bold">Total Waybills: ${filteredWaybills.length}</td></tr>`;
//     }
// }

function renderWaybills(filteredWaybills) {
    tableBody.innerHTML = '';

    if (filteredWaybills.length === 0) {
        tableBody.innerHTML = `
            <tr><td colspan="6" class="text-center">Aucune livraison trouvée</td></tr>
            <tr><td colspan="6" class="text-end fw-bold">Total Waybills: 0</td></tr>`;
        return;
    }

    filteredWaybills.forEach(wb => {
        const row = `
            <tr data-driver-id="${wb.driver_id}">
                <td>${wb.shipper_name}</td>
                <td>${wb.shipper_address}</td>
                <td>${wb.recipient_name}</td>
                <td>${wb.recipient_address}</td>
                {{--<td>${wb.driver_name ?? 'Non assigné'}</td> --}}
                <td>${wb.driver_name ? `${wb.driver_name} - ${wb.driver_id}` : 'Non assigné'}</td>

                <td>
                    <a href="/admin/waybill/${wb.id}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i> Voir Waybill
                    </a>
                </td>
            </tr>`;
        tableBody.insertAdjacentHTML('beforeend', row);
    });

    // Add Total Row as last <tr> in tbody
    const totalRow = `
        <tr>
            <td colspan="6" class="text-end fw-bold">Total Waybills: ${filteredWaybills.length}</td>
        </tr>`;
    tableBody.insertAdjacentHTML('beforeend', totalRow);
}






        function filterByDriver(driverId) {
            if (!driverId) {
                renderWaybills(cachedWaybills);
            } else {
                const filtered = cachedWaybills.filter(wb => wb.driver_id == driverId);
                renderWaybills(filtered);
            }
        }

        function fetchWaybills(date) {
            fetch(`/admin/summary-table/by-date?date=${date}`)
                .then(response => response.json())
                .then(data => {
                    cachedWaybills = data.waybills || [];
                    filterByDriver(driverSelect.value);
                })
                .catch(err => {
                    console.error(err);
                    tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">Erreur lors du chargement.</td></tr>`;
                    if (tableFooter) {
        tableFooter.innerHTML = `<tr><td colspan="6" class="text-end fw-bold">Total Waybills: 0</td></tr>`;
    }
                });
        }

        // Initial load
        fetchWaybills(dateInput.value);

        // Event: Change date
        dateInput.addEventListener('change', function () {
            fetchWaybills(this.value);
        });

        // Event: Change driver filter
        driverSelect.addEventListener('change', function () {
            filterByDriver(this.value);
        });
    });
</script>


    @endpush




