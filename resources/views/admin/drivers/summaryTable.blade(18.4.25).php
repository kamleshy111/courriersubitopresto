{{--
Latest update 7.3.25 7:02 am
well it works fine need to add databse update upon confirmation
also need to check current date data
--}}
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
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-primary" onclick="printContent()">Print Report</button>
    </div>

@stop



@section('content')

@role('admin')

    {{--<div class="container">--}}
    <div id="print-section">
        <h1 class="mt-4">COURRIER SUBITO PRESTO ENR.</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th colspan="2">Nom: {{ $driver->name ?? 'Unknown Driver' }}</th>
                    <th colspan="2">Numéro: {{ $driver->id ?? 'N/A' }}</th>
                    <th colspan="2">Date:
                        <input type="date" id="filterDate" value="{{ $currentDate }}">
                    </th>
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
            <tbody id="waybillTableBody">
                @foreach($waybills as $waybill)
                    <tr>
                        <td>{{ $waybill->shipper->address ?? 'N/A' }}</td>
                        <td>{{ $waybill->recipient->address ?? 'N/A' }}</td>
                        <td>{{ $waybill->shipper->prefix . str_pad($waybill->soft_id, 6, 0, STR_PAD_LEFT) }}</td>
                        <td contenteditable="true" class="editable-cell" data-field="status">{{ $waybill->status ?? 'N/A' }}</td>
                        <td contenteditable="true" class="editable-cell" data-field="description">{{ $waybill->description ?? 'N/A' }}</td>
                        <td contenteditable="true" class="editable-cell price-cell" data-field="price">{{ number_format($waybill->dashboard_price, 2) }} $</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align: right; font-weight: bold;">TOTAL:</td>
                    <td style="font-weight: bold;" id="totalPriceCell">{{ number_format($waybills->sum('price'), 2) }} $</td>
                </tr>
            </tfoot>
        </table>

        <p style="margin-top: 10px; font-style: italic;">Respecter vos colonnes s'il vous plaît - La direction</p>


    </div>
    @endrole

    @role('Driver')

    <div id="print-section">
        <h1 class="mt-4">COURRIER SUBITO PRESTO ENR.</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th colspan="2">Nom: {{ $driver->name ?? 'Unknown Driver' }}</th>
                    <th colspan="2">Numéro: {{ $driver->id ?? 'N/A' }}</th>
                    <th colspan="2">Date:
                        <input type="date" id="filterDate" value="{{ $currentDate }}">
                    </th>
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
            <tbody id="waybillTableBody">
                @foreach($waybills as $waybill)
                    <tr>
                        <td>{{ $waybill->shipper->address ?? 'N/A' }}</td>
                        <td>{{ $waybill->recipient->address ?? 'N/A' }}</td>
                        <td>{{ $waybill->shipper->prefix . str_pad($waybill->soft_id, 6, 0, STR_PAD_LEFT) }}</td>
                        <td contenteditable="false" class="editable-cell" data-field="status">{{ $waybill->status ?? 'N/A' }}</td>
                        <td contenteditable="false" class="editable-cell" data-field="description">{{ $waybill->description ?? 'N/A' }}</td>
                        <td contenteditable="false" class="editable-cell price-cell" data-field="price">{{ number_format($waybill->dashboard_price, 2) }} $</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align: right; font-weight: bold;">TOTAL:</td>
                    <td style="font-weight: bold;" id="totalPriceCell">{{ number_format($waybills->sum('price'), 2) }} $</td>
                </tr>
            </tfoot>
        </table>

        <p style="margin-top: 10px; font-style: italic;">Respecter vos colonnes s'il vous plaît - La direction</p>


    </div>

    </div>
    @endrole
@stop
@push('css')
<style>
@media print {
    /* Hide AdminLTE sidebars, headers, footers during print */
    body * {
        visibility: hidden;
    }
    #print-section, #print-section * {
        visibility: visible;
    }
    #print-section {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }
    .main-header, .main-sidebar, .main-footer {
        display: none;
    }
}
</style>
@endpush

@push('js')
<script>
function printContent() {
    window.print();
}
</script>
@endpush

@push('js')
<script>
    /*document.getElementById('filterDate').addEventListener('change', function() {
        let selectedDate = this.value;

        fetch(`/get-waybills?date=${selectedDate}`)
            .then(response => response.json())
            .then(data => {
                let tableBody = document.getElementById('waybillTableBody');
                let totalPrice = 0;

                tableBody.innerHTML = ''; // Clear existing rows

                if (data.waybills.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="6">Aucune donnée trouvée pour cette date.</td></tr>';
                } else {
                    data.waybills.forEach(waybill => {
                        totalPrice += parseFloat(waybill.price);

                        tableBody.innerHTML += `
                            <tr>
                                <td>${waybill.shipper_address ?? 'N/A'}</td>
                                <td>${waybill.recipient_address ?? 'N/A'}</td>
                                <td>${waybill.invoice_number}</td>
                                <td contenteditable="true">${waybill.status ?? 'N/A'}</td>
                                <td contenteditable="true">${waybill.description ?? 'N/A'}</td>
                                <td contenteditable="true">${parseFloat(waybill.price).toFixed(2)}</td>
                            </tr>
                        `;
                    });

                    // Update driver information
                    document.getElementById('driverNameHeader').innerText = `Nom: ${data.driver_name}`;
                    document.getElementById('driverNumberHeader').innerText = `Numéro: ${data.driver_id}`;
                }

                // Update Total Price
                document.getElementById('totalPriceCell').innerText = totalPrice.toFixed(2);
            })
            .catch(err => {
                console.error('Error fetching waybills:', err);
            });
    });*/

    /*function attachEditableListeners() {
    const editableCells = document.querySelectorAll('.editable-cell');

    editableCells.forEach(cell => {
        cell.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Prevent new line
                cell.blur();
                saveFrontendWaybillField(this); // This only updates the frontend
            }
        });

        if (cell.classList.contains('price-cell')) {
            cell.addEventListener('blur', updateTotalPrice); // Recalculate total on blur for price cells
        }
    });
}*/
function attachEditableListeners() {
    const editableCells = document.querySelectorAll('.editable-cell');

    editableCells.forEach(cell => {
        cell.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Prevent new line
                cell.blur(); // Simulate save
                saveFrontendWaybillField(this); // This only updates frontend
            }
        });

        if (cell.classList.contains('price-cell')) {
            cell.addEventListener('blur', updateTotalPrice); // Recalculate total on blur for price cells
        }
    });
}


// This just simulates a "save" by making the cell visually non-editable
function saveFrontendWaybillField(cell) {
    cell.blur(); // Remove focus

    // Optional: Add a class to show it's "saved" (could add grey background, etc.)
    cell.classList.add('saved-field');

    // Optionally remove contenteditable if you want to lock it
    // cell.removeAttribute('contenteditable');

    // Optionally show a small checkmark or saved message (just an example)
    showTemporaryMessage(cell, '✔️ updated');
}

// Optional: Show a small saved message
function showTemporaryMessage(cell, message) {
    const msg = document.createElement('span');
    msg.innerText = message;
    msg.style.color = 'green';
    msg.style.marginLeft = '10px';
    msg.style.fontSize = '0.8em';

    cell.parentNode.appendChild(msg);

    setTimeout(() => {
        msg.remove();
    }, 2000); // Remove message after 2 seconds
}

// later for database update
/*function attachEditableListeners() {
    const editableCells = document.querySelectorAll('.editable-cell');
    editableCells.forEach(cell => {
        cell.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Prevent new line in contenteditable
                // saveWaybillField(this); // for database update
            }
        });

        if (cell.classList.contains('price-cell')) {
            cell.addEventListener('blur', updateTotalPrice); // Recalculate total on blur
        }
    });
}*/


// Recalculate total price based on editable prices
function updateTotalPrice() {
    let total = 0;
    const priceCells = document.querySelectorAll('.price-cell');
    priceCells.forEach(cell => {
        let price = parseFloat(cell.innerText) || 0;
        total += price;
    });
    document.getElementById('totalPriceCell').innerText =  total.toFixed(2) + ' $';
}

document.addEventListener('DOMContentLoaded', function() {
    attachEditableListeners();
    updateTotalPrice(); // In case the initial data has prices
});
    document.getElementById('filterDate').addEventListener('change', function() {
        let selectedDate = this.value;
        let driverId = {{ $id }}; // Injected from PHP
        // /driver/{id}/summaryTable
        // fetch(`/driver/${driverId}/summaryTableUpdate?date=${selectedDate}`)
        fetch(`/admin/driver/${driverId}/summaryTable?date=${selectedDate}`)
        .then(response => response.json())
        // .then(response => response.json())
.then(data => {
    let tableBody = document.getElementById('waybillTableBody');
    let totalPriceCell = document.getElementById('totalPriceCell');

    tableBody.innerHTML = ''; // Clear old rows

    let totalPrice = 0;

    if (data.waybills.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center;">Aucune donnée trouvée pour cette date.</td></tr>';
        totalPriceCell.innerText = '0.00 $';
    } else {
        data.waybills.forEach(waybill => {
            let price = parseFloat(waybill.price) || 0;
            totalPrice += price;

            let row = document.createElement('tr');
            row.setAttribute('data-waybill-id', waybill.id); // store waybill ID for updates
            row.innerHTML = `
                <td>${waybill.shipper_address}</td>
                <td>${waybill.recipient_address}</td>
                <td>${waybill.invoice_number}</td>
                <td contenteditable="true" class="editable-cell" data-field="status">${waybill.status}</td>
                <td contenteditable="true" class="editable-cell" data-field="description">${waybill.description}</td>
                <td contenteditable="true" class="editable-cell price-cell" data-field="price">${price.toFixed(2)} $</td>
            `;
            tableBody.appendChild(row);
        });

        totalPriceCell.innerText = totalPrice.toFixed(2) + ' $';
        attachEditableListeners();
    }
})

/*.then(data => {
    let tableBody = document.getElementById('waybillTableBody');
    let totalPriceCell = document.getElementById('totalPriceCell');

    // Clear old rows
    tableBody.innerHTML = '';

    let totalPrice = 0; // Initialize total price

    if (data.waybills.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center;">Aucune donnée trouvée pour cette date.</td></tr>';
        totalPriceCell.innerText = '0.00';
    } else {
        data.waybills.forEach(waybill => {
            let price = parseFloat(waybill.price) || 0;  // Ensure numeric price
            totalPrice += price;

            let row = document.createElement('tr');
            row.innerHTML = `
                <td>${waybill.shipper_address}</td>
                <td>${waybill.recipient_address}</td>
                <td>${waybill.invoice_number}</td>
                <td contenteditable="true" class="editable-cell" data-field="status">${waybill.status}</td>
                <td contenteditable="true" class="editable-cell" data-field="description">${waybill.description}</td>
                <td contenteditable="true" class="editable-cell price-cell" data-field="price" >${price.toFixed(2)}</td>
            `;
            tableBody.appendChild(row);
        });

        // Initial total price
        totalPriceCell.innerText = totalPrice.toFixed(2);

        // Attach event listener to all price cells
        attachPriceCellListeners();
    }
})*/
.catch(error => {
    console.error('Error loading waybills:', error);
});

// Attach listeners to update total when price is edited
/*function attachPriceCellListeners() {
    const priceCells = document.querySelectorAll('.price-cell');
    priceCells.forEach(cell => {
        cell.addEventListener('blur', updateTotalPrice); // Trigger on losing focus
    });
}*/

function attachEditableListeners() {
    const editableCells = document.querySelectorAll('.editable-cell');

    editableCells.forEach(cell => {
        cell.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Prevent new line
                cell.blur();
                saveFrontendWaybillField(this); // This only updates the frontend
            }
        });

        if (cell.classList.contains('price-cell')) {
            cell.addEventListener('blur', updateTotalPrice); // Recalculate total on blur for price cells
        }
    });
}

// This just simulates a "save" by making the cell visually non-editable
function saveFrontendWaybillField(cell) {
    cell.blur(); // Remove focus

    // Optional: Add a class to show it's "saved" (could add grey background, etc.)
    cell.classList.add('saved-field');

    // Optionally remove contenteditable if you want to lock it
    // cell.removeAttribute('contenteditable');

    // Optionally show a small checkmark or saved message (just an example)
    showTemporaryMessage(cell, '✔️ updated');
}

// Optional: Show a small saved message
function showTemporaryMessage(cell, message) {
    const msg = document.createElement('span');
    msg.innerText = message;
    msg.style.color = 'green';
    msg.style.marginLeft = '10px';
    msg.style.fontSize = '0.8em';

    cell.parentNode.appendChild(msg);

    setTimeout(() => {
        msg.remove();
    }, 2000); // Remove message after 2 seconds
}

// later for database update
/*function attachEditableListeners() {
    const editableCells = document.querySelectorAll('.editable-cell');
    editableCells.forEach(cell => {
        cell.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Prevent new line in contenteditable
                // saveWaybillField(this); // for database update
            }
        });

        if (cell.classList.contains('price-cell')) {
            cell.addEventListener('blur', updateTotalPrice); // Recalculate total on blur
        }
    });
}*/


// Recalculate total price based on editable prices
function updateTotalPrice() {
    let total = 0;
    const priceCells = document.querySelectorAll('.price-cell');
    priceCells.forEach(cell => {
        let price = parseFloat(cell.innerText) || 0;
        total += price;
    });
    document.getElementById('totalPriceCell').innerText =  total.toFixed(2) + ' $';
}


    });
    //         .then(response => response.json())
    //         .then(data => {
    //             let tableBody = document.getElementById('waybillTableBody');
    //             let totalPriceCell = document.getElementById('totalPriceCell');

    //             // Clear old rows
    //             tableBody.innerHTML = '';

    //             if (data.waybills.length === 0) {
    //                 tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center;">Aucune donnée trouvée pour cette date.</td></tr>';
    //                 totalPriceCell.innerText = '0.00';
    //             } else {
    //                 data.waybills.forEach(waybill => {
    //                     tableBody.innerHTML += `
    //                         <tr>
    //                             <td>${waybill.shipper_address}</td>
    //                             <td>${waybill.recipient_address}</td>
    //                             <td>${waybill.invoice_number}</td>
    //                             <td contenteditable="true">${waybill.status}</td>
    //                             <td contenteditable="true">${waybill.description}</td>
    //                             <td contenteditable="true">${waybill.price ? parseFloat(waybill.price).toFixed(2) : '0.00'}</td>

    //                         </tr>`;
    //                 });

    //                 // Update total price
    //                 totalPriceCell.innerText = data.total_price;
    //             }
    //         })
    //         .catch(error => {
    //             console.error('Error loading waybills:', error);
    //         });
    // });

</script>

@endpush

@push('js')
{{-- <script>
document.addEventListener('DOMContentLoaded', function() {
    const filterDate = document.getElementById('filterDate');

    if (filterDate) {
        alert('filterDate found!');

        filterDate.addEventListener('change', function() {
            alert('Date changed to: ' + filterDate.value);
        });
    } else {
        alert('filterDate not found!');
    }
});
</script> --}}
@endpush
