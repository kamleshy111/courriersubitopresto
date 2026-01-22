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


     #filterName::placeholder {
    font-size: 0.75rem; /* Adjust as needed */
    color: #999; /* Optional: lighter color */



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

<!-- Date Filter old working-->
{{-- <div class="mb-3 d-flex align-items-center">
    <label for="filterDate" class="me-2">📅 Recherche par date:</label>
    <input type="date" id="filterDate" class="form-control w-auto" value="{{ $date ?? now()->format('Y-m-d') }}">
</div>
--}}

{{-- new with name filter--}}

@if ($urlSegment == 'delivered')
 <div class="mb-3 d-flex align-items-center">
        <label for="filterDate" class="me-2">📅 Recherche par date:</label>
        <input type="date" id="filterDate" class="form-control w-auto" value="{{ $date ?? now()->format('Y-m-d') }}">
    </div>
    <div class="mb-3 d-flex flex-wrap gap-3 align-items-center">
       {{-- <label for="filterName" class="me-2">🔍 Chercher par nom:</label>
        <input type="text" id="filterName" class="form-control w-auto" placeholder="Nom d’expéditeur ou destinataire">

        <button id="searchByNameButton" class="btn btn-primary">🔎 Chercher par nom</button>--}}
        
        <label for="filterName" class="me-2">🔍 Chercher par nom:</label>
<input type="text" id="filterName" class="form-control w-auto" placeholder="Nom d’expéditeur ou destinataire">

{{--<div id="nameSuggestions" class="list-group position-absolute" style="z-index: 1000; width: auto;"></div>--}}
<ul id="nameSuggestions" class="list-group" style="display: none; position: absolute; z-index: 1000; width: auto;"></ul>

<button id="searchByNameButton" class="btn btn-primary mt-2">🔎 Chercher par nom</button>


    </div>

    <div class="mb-3 d-flex flex-wrap gap-3 align-items-center">
        {{-- <label for="filterId" class="me-2">🆔 Chercher par ID:</label> --}}
        <label for="filterId" class="me-2">Rechercher par bordereau</label>
        <input type="text" id="filterId" class="form-control w-auto" placeholder="bordereaux ID de livraison">
        {{-- <button id="searchByIdButton" class="btn btn-info">🔎 Chercher par ID</button> --}}
        <button id="searchByIdButton" class="btn btn-info">🔎 Rechercher par bordereau</button>
         <div class="ms-auto">
            <button id="resetButton" class="btn btn-secondary">♻️ Réinitialiser</button>
         </div>
    </div>
@else
    <div class="mb-3 d-flex align-items-center">
        <label for="filterDate" class="me-2">📅 Recherche par date:</label>
        <input type="date" id="filterDate" class="form-control w-auto" value="{{ $date ?? now()->format('Y-m-d') }}">
    </div>
@endif


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
document.addEventListener('DOMContentLoaded', function () {
        // Find the anchor tag inside the li
        let clientProfileUpdate = document.querySelector('#dynamic-client-profile a');
        if (!clientProfileUpdate) return;
        @if(auth()->check() && auth()->user()->roles->contains('id', 2))
            clientProfileUpdate.href = "{{ url('admin/users/' . auth()->id()) .'/edit' }}";
            
        @else
            // Optionally, set a fallback URL for non-drivers (or leave as is)
            // waybillLink.href = "/#"; // or set to some default link
        @endif
})
</script>

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
            /* waybillLink.href = "/#"; // or set to some default link */
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

    /*document.getElementById('filterName').addEventListener('input', function() {
    let query = this.value;

    if (query.length < 3) {
        document.getElementById('nameSuggestions').innerHTML = '';
        return;
    }

    fetch(`/admin/clients/search?q=${query}`)
        .then(response => response.json())
        .then(data => {
            let suggestions = document.getElementById('nameSuggestions');
            suggestions.innerHTML = '';

            if (data.length === 0) {
                suggestions.innerHTML = '<div class="list-group-item">Aucun résultat trouvé</div>';
                return;
            }

            data.forEach(client => {
                let item = document.createElement('button');
                item.type = "button";
                item.classList.add('list-group-item', 'list-group-item-action');
                item.innerText = client.name;

                item.addEventListener('click', function() {
                    document.getElementById('filterName').value = client.name;
                    suggestions.innerHTML = ''; // clear dropdown
                });

                suggestions.appendChild(item);
            });
        })
        .catch(error => console.error('Erreur:', error));
});*/

// new

const filterNameInput = document.getElementById('filterName');
const suggestionsBox = document.getElementById('nameSuggestions');

filterNameInput.addEventListener('keyup', function () {
    let query = this.value.trim();

    if (query.length < 3) {
        suggestionsBox.style.display = 'none';
        return;
    }

    fetch(`/admin/clients/search?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            suggestionsBox.innerHTML = '';
            if (data.length > 0) {
                data.forEach(client => {
                    let li = document.createElement('li');
                    li.classList.add('list-group-item', 'list-group-item-action');
                    li.textContent = client.name;
                    li.style.cursor = 'pointer';

                    li.addEventListener('click', function () {
                        filterNameInput.value = client.name;
                        suggestionsBox.style.display = 'none';
                    });

                    suggestionsBox.appendChild(li);
                });

                // Position dropdown under input
                let inputRect = filterNameInput.getBoundingClientRect();
                suggestionsBox.style.left = inputRect.left + 'px';
                suggestionsBox.style.top = inputRect.bottom + window.scrollY + 'px';
                suggestionsBox.style.width = inputRect.width + 'px';
                suggestionsBox.style.display = 'block';
            } else {
                suggestionsBox.style.display = 'none';
            }
        });
});

// Hide suggestions when clicking outside
document.addEventListener('click', function (e) {
    if (!filterNameInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
        suggestionsBox.style.display = 'none';
    }
});


</script>




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

<script>
    function fetchWaybillsByName(name) {
    const params = new URLSearchParams({ name });

    fetch(`/admin/client/waybills-by-name?${params}`)
        .then(response => response.json())
        .then(data => {
            let rows = '';
            if (data.waybills.length > 0) {
                data.waybills.forEach(wb => {
                    rows += `
                        <tr>
                            <td>${wb.shipper_name}</td>
                            <td>${wb.shipper_address}</td>
                            <td>${wb.recipient_name}</td>
                            <td>${wb.recipient_address}</td>
                            <td>
                                <a href="/admin/waybill/${wb.id}" class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
                    `;
                });
            } else {
                rows = '<tr><td colspan="5" class="text-center">No results found</td></tr>';
            }
            waybillTable.innerHTML = rows;
        })
        .catch(error => {
            console.error('Error searching waybills by name:', error);
        });
}

document.getElementById('searchByNameButton').addEventListener('click', function () {
    // debug input name
    // alert(document.getElementById('filterName').value);
    fetchWaybillsByName(document.getElementById('filterName').value);
});

/* filter by waybill id  */

/*function fetchWaybillById(id) {

    fetch(`/admin/client/waybill-by-id?id=${id}`)
        .then(response => response.json())
        .then(data => {
            let rows = '';
            if (data.waybill) {
                const wb = data.waybill;
                rows += `
                    <tr>
                        <td>${wb.shipper_name}</td>
                        <td>${wb.shipper_address}</td>
                        <td>${wb.recipient_name}</td>
                        <td>${wb.recipient_address}</td>
                        <td>
                            <a href="/waybills/${wb.id}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                `;
            } else {
                rows = '<tr><td colspan="5" class="text-center">Aucune livraison trouvée avec cet ID</td></tr>';
            }
            waybillTable.innerHTML = rows;
        })
        .catch(error => {
            console.error('Error searching waybill by ID:', error);
        });
}*/

function fetchWaybillById(id) {
    fetch('/admin/client/waybills/waybill-by-id', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ id: id }) // ✅ use the `id` passed into the function
    })
    .then(response => response.json())
    .then(data => {
        /* let rows = '';
        if (data.waybill) {
            const wb = data.waybill;
            rows += `
                <tr>
                    <td>${wb.shipper_name}</td>
                    <td>${wb.shipper_address}</td>
                    <td>${wb.recipient_name}</td>
                    <td>${wb.recipient_address}</td>
                    <td>
                        <a href="/waybills/${wb.id}" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>
            `;
        } else {
            rows = '<tr><td colspan="5" class="text-center">Aucune livraison trouvée avec cet ID</td></tr>';
        }
        waybillTable.innerHTML = rows; */

        let rows = '';
            if (data.waybills.length > 0) {
                data.waybills.forEach(wb => {
                    rows += `
                        <tr>
                            <td>${wb.shipper_name}</td>
                            <td>${wb.shipper_address}</td>
                            <td>${wb.recipient_name}</td>
                            <td>${wb.recipient_address}</td>
                            <td>
                                <a href="/admin/waybill/${wb.id}" class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
                    `;
                });
            } else {
                rows = '<tr><td colspan="5" class="text-center">No results found</td></tr>';
            }
            waybillTable.innerHTML = rows;
    })
    .catch(error => {
        console.error('Error searching waybill by ID:', error);
    });
}


document.getElementById('searchByIdButton').addEventListener('click', function () {
    const rawId = document.getElementById('filterId').value;
    /*if (id) {
        fetchWaybillById(id);
    }*/
    let numericId = rawId.replace(/\D/g, ''); // Removes all non-digit characters

    if (numericId) {
        fetchWaybillById(numericId);
    } else {
        alert('Veuillez entrer un ID valide.');
    }
});



// reset button
document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('filterDate');
    const nameInput = document.getElementById('filterName'); // ✅ This was missing
    const idInput = document.getElementById('filterId'); // newly added for id filter
    const searchButton = document.getElementById('searchByNameButton');
    const resetButton = document.getElementById('resetButton');
    const waybillTable = document.getElementById('waybillTable');

    resetButton.addEventListener('click', function () {
    // Clear the name input
    nameInput.value = '';
    idInput.value = '';

    // Get today's date in YYYY-MM-DD format
    const today = new Date().toISOString().split('T')[0];

    // Optional: update a hidden date input if you want to show it
    if (document.getElementById('filterDate')) {
        document.getElementById('filterDate').value = today;
    }

    // Fetch waybills by date (today)
    // fetch(`/admin/client/waybills-by-date?date=${today}`)
    fetch(`/admin/client/waybills/by-date?date=${today}`)
        .then(response => response.json())
        .then(data => {
            let rows = '';
            if (data.waybills.length > 0) {
                data.waybills.forEach(wb => {
                    rows += `
                        <tr>
                            <td>${wb.shipper_name}</td>
                            <td>${wb.shipper_address}</td>
                            <td>${wb.recipient_name}</td>
                            <td>${wb.recipient_address}</td>
                            <td>
                                <a href="/waybills/${wb.id}" class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
                    `;
                });
            } else {
                rows = '<tr><td colspan="5" class="text-center">Aucune livraison trouvée pour cette date</td></tr>';
            }
            waybillTable.innerHTML = rows;
        })
        .catch(error => {
            console.error('Error resetting to today\'s data:', error);
        });
});
});

</script>



@endpush




