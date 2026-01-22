{{--
version date 18.4.25
    => admin section voir waybill button added opens popup
    => database linked to save the data
--}}

{{--
Latest update 7.3.25 7:02 am
well it works fine need to add databse update upon confirmation
also need to check current date data
--}}


@extends('adminlte::page')


{{-- @php
    $hideSidebar = request()->query('popup') === 'true';
@endphp --}}

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
                    <th colspan="3">Date:
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
                    <th class="no-print-col"> Voir Waybill </th>

                </tr>
            </thead>
            <tbody id="waybillTableBody">
                @foreach($waybills as $waybill)

                    <tr>
                        <td>{{ $waybill->shipper->address ?? 'N/A' }}</td>
                        <td>{{ $waybill->recipient->address ?? 'N/A' }}</td>
                        <td>{{ $waybill->shipper->prefix . str_pad($waybill->soft_id, 6, 0, STR_PAD_LEFT) }}</td>
                        <td class="editable-cell" data-table="waybills" data-column="status" data-id={{$waybill->id}}>
                            @php

                                $status_raw = $waybill->status;
                                if(strtolower($status_raw) == "tomorrow")
                                {

                                    $temp = "Lendemain";
                                }
                                // else if(strtolower($value) == "même jour" || strtolower($value) == "meme jour")
                                else if(strtolower($status_raw) == "same_day")
                                {

                                    $temp = "Même JOUR";

                                }

                                else if(strtolower($status_raw) == "urgent")
                                {

                                    $temp = "urgent";
                                }

                                else if(strtolower($status_raw) == "very_urgent")
                                {

                                    $temp = "TRES urgent";
                                }

                                else if(strtolower($status_raw) == "code_red")
                                {

                                    $temp = "red code";

                                }

                                else if(strtolower($status_raw) == "night")
                                {

                                    $temp = "special night";
                                }
                                // echo $temp;
                            @endphp
                            {{ $temp ?? 'N/A' }}

                        </td>

                        <td class="editable-cell" data-table="waybills" data-column="description" data-id={{$waybill->id}}>
                            {{ $waybill->description ?? 'N/A' }}

                        </td>
                        <td class="editable-cell price-cell" data-table="waybills" data-column="comission_price" data-id={{$waybill->id}} data-field="price">
                            @php
                                $raw_price = isset($waybill->comission_price) ? $waybill->comission_price : "0"; // Fallback to "0" if not set
                                $price = preg_replace('/[^0-9\.\-]/', '', $raw_price);
                            @endphp
                            {{ number_format($price, 2) }} $
                        </td>
                        <td class="no-print-col">
                            {{-- <a href="{{ url('admin/waybill/'. $waybill->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Voir Waybill
                            </a> --}}
                            <button id="btn-open-new-popup" class="btn btn-sm btn-primary" data-url="{{ url('admin/waybill/'. $waybill->id) }}" >Voir Waybill</button>
                        </td>
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
    <div class="overlay-new" id="new-overlay" style="display: none;">
        <div class="popup-new">
            {{-- <div class="header"> --}}

            {{-- </div> --}}
            <div class="body">
                <!-- New popup content will be loaded dynamically here -->
                <iframe id="iframe-popup" width="100%" height="600px"></iframe>
                <button id="btn-close-new-popup">X</button>
            </div>
        </div>
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
                        <td contenteditable="false" class="editable-cell" data-field="status">
                            {{-- {{ $waybill->status ?? 'N/A' }} --}}
                            @php

                                $status_raw = $waybill->status;
                                if(strtolower($status_raw) == "tomorrow")
                                {

                                    $temp = "Lendemain";
                                }
                                // else if(strtolower($value) == "même jour" || strtolower($value) == "meme jour")
                                else if(strtolower($status_raw) == "same_day")
                                {

                                    $temp = "Même JOUR";

                                }

                                else if(strtolower($status_raw) == "urgent")
                                {

                                    $temp = "urgent";
                                }

                                else if(strtolower($status_raw) == "very_urgent")
                                {

                                    $temp = "TRES urgent";
                                }

                                else if(strtolower($status_raw) == "code_red")
                                {

                                    $temp = "red code";

                                }

                                else if(strtolower($status_raw) == "night")
                                {

                                    $temp = "special night";
                                }
                                echo $temp;
                            @endphp
                            {{ $temp ?? 'N/A' }}
                        </td>
                        <td contenteditable="false" class="editable-cell" data-field="description">{{ $waybill->description ?? 'N/A' }}</td>
                        <td contenteditable="false" class="editable-cell price-cell" data-field="price">
                            {{-- {{ number_format($waybill->price, 2) }} $ --}}
                            @php
                                $raw_price = isset($waybill->comission_price) ? $waybill->comission_price : "0"; // Fallback to "0" if not set
                                $price = preg_replace('/[^0-9\.\-]/', '', $raw_price);
                            @endphp
                            {{ number_format($price, 2) }} $
                        </td>
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

@media print {
    .no-print-col {
        display: none !important;
    }
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
{{-- for notification --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

function printContent() {
    window.print();
}
</script>
<script>

/*function attachEditableListeners() {
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
}*/


// This just simulates a "save" by making the cell visually non-editable
/*function saveFrontendWaybillField(cell) {
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
}*/

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

function statusUpdate(value)
{
    var temp;

    if(value.toLowerCase() == "tomorrow")
    {

        temp = "Lendemain";
    }

    else if(value.toLowerCase() == "same_day")
    {
        temp = "Même JOUR";

    }

    else if(value.toLowerCase() == "urgent")
    {
        temp = "urgent";
    }

    else if(value.toLowerCase() == "very_urgent")
    {
        temp = "TRES urgent";
    }

    else if(value.toLowerCase() == "code_red")
    {
        temp = "red code";

    }

    else if(value.toLowerCase() == "night")
    {
        temp = "special night";
    }
    // else
    //         }
    return temp;

}

// save into database convertion status value

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

    else if (givenStr === 'red code') {
        convetedStr = 'code_red';
    }
    else if (givenStr === 'special night') {
        convetedStr = 'night';
    }

    else if (givenStr === 'urgent') {
        convetedStr = 'urgent';
    }
    else{
        convetedStr = "error";
    }

    /*else {
        convetedStr = givenStr;
    }*/

    return convetedStr;
}

// save data into database

function saveEditedData(selectedNoteId, columnName , tableName, newValue, dashboardNotes=false) {
    console.log(`Saving data for Note ID: ${selectedNoteId}, data-Table: ${tableName},data-column: ${columnName}, New Value: ${newValue}`) ;
    console.log(typeof newValue);
    console.log(newValue.length);
    // Example AJAX call to send the updated data to the backend
    // fetch('admin/update-sticky-note', {
    fetch('/admin/admin/update-sticky-note', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ selectedNoteId, columnName,tableName, newValue }),
    })
        .then(response => response.json())
        .then(data => {
        if (data.success) {
            if(columnName == "comission_price")
            {
                // saveFrontendWaybillField();
                updateTotalPrice();
            }
            /*if(dashboardNotes == false)
            {
                updateNoteDiv(selectedNoteId, columnName, newValue);
            }
            else{
                console.log("note updated!");
            }*/
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

document.addEventListener('DOMContentLoaded', function() {


    // document.body.addEventListener('dblclick',function(event){
    //     // attachEditableListeners(event);
    //     alert("dbl click detected!");
    // });
    // alert("here");
    // if (document.body) {
        document.body.addEventListener("dblclick", function (event) {
            // alert("dbl click detected!");
            attachEditableListeners(event);
        });
    // }
     /*else {
        // Fallback: wait a tick if body isn't there yet
        window.setTimeout(function () {
            document.body.addEventListener("dblclick", function (event) {
                alert("dbl click detected!");
            });
        }, 0);
    }*/

    updateTotalPrice(); // In case the initial data has prices

    const newPopupOverlay = document.getElementById('new-overlay');
    const popupBodyNew = newPopupOverlay.querySelector('.popup .body');
    const btnCloseNewPopup = document.getElementById('btn-close-new-popup');
    const btnOpenNewPopup = document.getElementById('btn-open-new-popup');
    const iframe = document.getElementById('iframe-popup');

    btnOpenNewPopup.addEventListener('click', function () {

        newPopupOverlay.style.display = 'block';
        const baseUrl = this.dataset.url;
        const url = baseUrl + '?popup=true';
        // alert(url);
        iframe.src = ''; // Clear the content in iframe
        iframe.style.display = 'none'; // Hide the iframe initially

        setTimeout(() => {
            // alert("working!..");
        iframe.src = url; // Set the new URL in the iframe
        iframe.style.display = 'block'; // Show the iframe
    }, 1200);

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
});

    document.getElementById('filterDate').addEventListener('change', function() {
        let selectedDate = this.value;
        // alert(selectedDate);
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
        // alert(data.isAdmin);
        if(data.isAdmin == 1){
            if (data.waybills.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="7" style="text-align: center;">Aucune donnée trouvée pour cette date.</td></tr>';
                totalPriceCell.innerText = '0.00 $';
            } else {
                data.waybills.forEach(waybill => {
                    // let price = parseFloat(waybill.dashboard_price) || 0;
                    var raw_price = waybill?.price ?? "0"; // Fallback to "0" if null or undefined
                    var cleanedPrice = raw_price.replace(/[^0-9.-]/g, "");
                    var price = Number(cleanedPrice);
                    console.log(raw_price);
                    console.log(price);
                    totalPrice += price;
                    var status = statusUpdate(waybill.status);
                    // alert(waybill.id);
                    let row = document.createElement('tr');
                    row.setAttribute('data-waybill-id', waybill.id); // store waybill ID for updates
                    row.innerHTML = `
                        <td>${waybill.shipper_address}</td>
                        <td>${waybill.recipient_address}</td>
                        <td>${waybill.invoice_number}</td>
                        {{--<td contenteditable="true" class="editable-cell" data-table="waybills" data-column="status" data-id=${waybill.id}>${waybill.status}</td>--}}
                        <td  class="editable-cell" data-table="waybills" data-column="status" data-id=${waybill.id}>${status}</td>
                        <td  class="editable-cell" data-table="waybills" data-column="description" data-id=${waybill.id}>${waybill.description}</td>
                        <td  class="editable-cell price-cell" data-table="waybills" data-column="comission_price" data-id=${waybill.id} >${price.toFixed(2)} $</td>
                        <td class="no-print-col" ><button id="btn-open-new-popup" class="btn btn-sm btn-primary" data-url="/admin/waybill/${waybill.id}">Voir Waybill</button></td>
                    `;
                    tableBody.appendChild(row);
                });

                totalPriceCell.innerText = totalPrice.toFixed(2) + ' $';
                // attachEditableListeners();

                const newPopupOverlay = document.getElementById('new-overlay');
                const popupBodyNew = newPopupOverlay.querySelector('.popup .body');
                const btnCloseNewPopup = document.getElementById('btn-close-new-popup');
                const btnOpenNewPopup = document.getElementById('btn-open-new-popup');
                const iframe = document.getElementById('iframe-popup');

                btnOpenNewPopup.addEventListener('click', function () {
                    // alert("clicked");

                // const urlParams = new URLSearchParams(window.location.search);
                // if (urlParams.get('popup') === 'true') {
                    // document.body.classList.add('sidebar-collapse');
                // }
                // alert("starting!..");
                newPopupOverlay.style.display = 'block';
                const baseUrl = this.dataset.url;
                const url = baseUrl + '?popup=true';
                // alert(url);
                iframe.src = ''; // Clear the content in iframe
                iframe.style.display = 'none'; // Hide the iframe initially

                setTimeout(() => {
                    // alert("working!..");
                iframe.src = url; // Set the new URL in the iframe
                iframe.style.display = 'block'; // Show the iframe

                // if (window !== window.parent) {
                //     alert("TESTING...");
                // We're inside an iframe
                // document.addEventListener('DOMContentLoaded', function () {
                    // const sidebar = document.querySelector('.main-sidebar');
                    // if (sidebar) sidebar.style.display = 'none';

                    // const body = document.querySelector('body');
                // }
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
        // });

        }
        }
        else{

        if (data.waybills.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center;">Aucune donnée trouvée pour cette date.</td></tr>';
            totalPriceCell.innerText = '0.00 $';
        } else {
            // alert("generating list");
            data.waybills.forEach(waybill => {
                // let price = parseFloat(waybill.dashboard_price) || 0;
                var raw_price = waybill?.price ?? "0"; // Fallback to "0" if null or undefined
                var cleanedPrice = raw_price.replace(/[^0-9.-]/g, "");
                var price = Number(cleanedPrice);
                totalPrice += price;
                var status = statusUpdate(waybill.status);
                // alert(waybill.id);
                let row = document.createElement('tr');
                row.setAttribute('data-waybill-id', waybill.id); // store waybill ID for updates
                row.innerHTML = `
                    <td>${waybill.shipper_address}</td>
                    <td>${waybill.recipient_address}</td>
                    <td>${waybill.invoice_number}</td>
                    <td  class="editable-cell" data-field="status">${status}</td>
                    <td  class="editable-cell" data-field="description">${waybill.description}</td>
                    <td  class="editable-cell price-cell" data-field="price">${price.toFixed(2)} $</td>

                `;
                tableBody.appendChild(row);
            });

            totalPriceCell.innerText = totalPrice.toFixed(2) + ' $';
            attachEditableListeners();

    // });

        }

    }
})
.catch(error => {
    console.error('Error loading waybills:', error);
});
    });

// Attach listeners to update total when price is edited
/*function attachPriceCellListeners() {
    const priceCells = document.querySelectorAll('.price-cell');
    priceCells.forEach(cell => {
        cell.addEventListener('blur', updateTotalPrice); // Trigger on losing focus
    });
}*/

function attachEditableListeners(event) {
    console.log("attachEditableListeners function detected");
    const editableCells = document.querySelectorAll('.editable-cell');

    // editableCells.forEach(cell => {
        // cell.addEventListener('keydown', function (e) {
            /*if (e.key === 'Enter') {
                e.preventDefault(); // Prevent new line
                cell.blur();
                saveFrontendWaybillField(this); // This only updates the frontend
            }*/
            if (event.target.classList.contains('editable-cell')) {
            // if (cell.classList.contains('editable-cell')) {
                console.log("inside condition!");


                const cell = event.target;

                const tableName = cell.dataset.table;    // "waybills"
                const columnName = cell.dataset.column;  // "user_id"
                // if(columnName){
                    const compValue = columnName.toLowerCase();
                // }

                const waybillId = cell.dataset.id;
                console.log(tableName);
                console.log(columnName);
                console.log(waybillId);
                // console.log()
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

                // Save the data when the user finishes editing (blur or Enter)
                cell.addEventListener('blur', function () {
                    // const selectedNoteId = this.closest('.bottom-sticky-note').dataset.id; // Get the sticky note ID
                    const newValue = this.innerText.trim(); // Get the edited value
                    if(compValue == 'status')
                    {
                        const translatedNewValue = statusConvertion(newValue);
                        if (newValue !== this.dataset.originalValue) {
                        saveEditedData(waybillId, columnName , tableName,translatedNewValue); // Custom function to handle saving
                        }
                    }
                    else{
                    // const datacolumn = this.getAttribute('data-column')
                    // Ensure the value is changed before sending it to the backend
                    if (newValue !== this.dataset.originalValue) {
                        saveEditedData(waybillId, columnName , tableName,newValue); // Custom function to handle saving
                    }
                }

                    // Remove contenteditable attribute after editing
                    this.setAttribute('contenteditable', 'false');
                    this.removeAttribute('data-original-value'); // Clean up temporary data
                });
        // }

        // });
            }

        // if (cell.classList.contains('price-cell')) {
        //     cell.addEventListener('blur', updateTotalPrice); // Recalculate total on blur for price cells
        // }
    // });
}

// This just simulates a "save" by making the cell visually non-editable
function saveFrontendWaybillField(cell) {
    // cell.blur(); // Remove focus

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


    // });

</script>

@endpush
