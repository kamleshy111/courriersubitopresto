@extends('adminlte::page')

@php
    $waybill = Request::query('waybill');
@endphp

@if($waybill === "true")
    @section('title', ucfirst('Bordereaux'))
@elseif($waybill === "false")
    @section('title', ucfirst('Soumissions'))
@else
    @section('title', 'Archives')
@endif

@push('css')
    <style>
        /*    .ribbon-new {
            position: absolute;
            left: -1.5%;
            top: 18%;
            transform: translateY(-50%);
            background-color: #e3342f;
            color: white;
            font-size: 10px;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
            z-index: 1;
        }*/
        
        .ribbon-container {
    position: relative;
}

.ribbon-new {
    position: absolute;
    left: -26%;
    top: -10%;
    transform: translateY(-50%);
    background-color: #e3342f;
    color: white;
    font-size: 10px;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 3px;
    z-index: 10;
}

        .dataTables_wrapper{
            background-color : #f4f6f9!important;
        }
        table.dataTable tbody tr{
            background-color : #f4f6f9!important;
        }
        .content-wrapper > .content{
            margin-top: 50px!important;
            margin-left: 50px!important;
            margin-right: 50px!important;
        }
        .content-header{
            margin-top: 50px!important;
            margin-left: 50px!important;
            margin-right: 50px!important;
        }
        body{
            background-color: #f4f6f9!important;
        }
    </style>
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

@endpush
@section('content_header')
    <h1>
        @if(Request::query('waybill') == "true")
             Bordereaux
            @if(\Laratrust::isAbleTo('admin.'.$name.'.create'))
                <a href="{{ url('admin/waybills/create?waybill=' . Request::query('waybill') ) }}" class="btn btn-lg btn-success">NOUVEAU</a>
            @endif
        @elseif(Request::query('waybill') == "false")
            Soumissions
            @if(\Laratrust::isAbleTo('admin.'.$name.'.create'))
                <a href="{{ url('admin/waybills/create?waybill=' . Request::query('waybill') ) }}" class="btn btn-lg btn-success">NOUVEAU</a>
            @endif
        @else
            Archives
        @endif
    </h1>
@stop

@section('content')
    @role('admin')
        @if(Request::query('waybill') == "true" || Request::query('waybill') == "false" || Request::query('archive') == "true")
            <div class="d-grid gap-10 col-lg-12 mx-auto">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Filter par date</label>
                            <select name="date_filter" id="date_filter" class="form-control">
                                <option selected disabled>Choisir Type</option>
                                <option value="1">Today</option>
                                <option value="2">Semaine</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Clients</label>
                            <select name="client_id" id="client_id" class="form-control">
                                <option selected disabled>Choisir client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
                <div class="block table-block mt-5 mb-4" style="margin-top: 20px;">
                <div class="row">
                    <div class="table-responsive px-3">
                        <table id="admin_table_id" class="table row-border hover">
                            <thead>
                            <tr>
                                <th style="width: 12%; text-align: center!important;">Numéro de facture</th>
                                <th style="width: 13%; text-align: center!important;">Client</th>
                                <th style="width: 13%; text-align: center!important;">Adresse</th>
                                {{--<th style="width: 13%; text-align: center!important;">Statut</th>--}}
                                <th style="width: 13%; text-align: center!important;">Statut de livraison</th>
                                <th style="width: 13%; text-align: center!important;">Date</th>
                                @if(Request::query('waybill') == "false" || Request::query('archive') == "true")
                                    <th>Prix</th>
                                @endif
                                <th style="width: 25%; text-align: center!important;">Actions</th>
                            </tr>
                            </thead>
                            <tbody style="width: 13%; text-align: center!important;">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
       @endif
    @else
        @if(Request::query('waybill') == "true" || Request::query('waybill') == "false" || Request::query('archive') == "true")
            <div class="block table-block mb-4" style="margin-top: 20px;">
            <div class="row">
                <div class="table-responsive">
                    <table id="client_table_id" class="table row-border hover">
                        <thead>
                        <tr>
                            <th style="width: 12%; text-align: center!important;">Numéro de facture</th>
                            <th style="width: 13%; text-align: center!important;">Client</th>
                            <th style="width: 13%; text-align: center!important;">Adresse</th>
                            {{-- <th style="width: 13%; text-align: center!important;">Statut</th>--}}
                            <th style="width: 13%; text-align: center!important;">Statut de livraison</th>
                            <th style="width: 13%; text-align: center!important;">Date</th>
                            @if(Request::query('waybill') == "false" || Request::query('archive') == "true")
                                <th>Prix</th>
                            @endif
                            <th style="width: 13%; text-align: center!important;">Voir</th>
                        </tr>
                        </thead>
                        <tbody style="width: 13%; text-align: center!important;">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    @endrole
@stop
@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.min.js"></script>


    <script>
        $(document).ready( function () {

            // Get the query string part of the URL
            var queryString = window.location.search;

            var searchParams = new URLSearchParams(queryString);

            var waybillType = searchParams.get('waybill');

            var submissionType = searchParams.get('archive');

            if(waybillType && (waybillType === "false" || waybillType === "true")){
                // Client DataTable
                $('#client_table_id').DataTable({
                    processing   : true,
                    serverSide   : true,
                    responsive   : true,
                    sorting      : false,
                    lengthChange : true,
                    autoWidth    : false,
                    pageLength   : 5,
                    searching    : true,
                    dom:'lBfrtip',

                    "ajax" : '{{ url("admin/waybills-client-index?waybill-type=" ) }}' + waybillType,
                    "columns" : [

                        {
                            "data" : "soft_id",
                            searchable: true
                        },
                        
                        {
                            "data" : "recipient.name",
                            "defaultContent": "N/A"
                        },
                        {
                            "data" : "recipient.address",
                            "defaultContent": "N/A"
                        },
                        {
                            "data" : "status"
                        },
                        {
                            "data" : "delivery_status"
                        },
                        {
                            "data" : "date"
                        },
                            @if(Request::query('waybill') == "false")
                        { data: 'price' },
                            @endif
                        {
                            "data" : 'action',
                            "orderable": false,
                            "searchable": false
                        }
                    ],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json',
                    },
                    buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
                });

                // Admin dataTable
                var table = $('#admin_table_id').DataTable({

processing   : true,

serverSide   : true,

responsive   : true,

sorting      : false,

lengthChange : true,

autoWidth    : false,

pageLength   : 7,

searching    : true,

dom:'lBfrtip',

"ajax" : {

    "url" : '{{ url("admin/waybills-admin-index?waybill-type=" ) }}' + waybillType,

    "data": function (d) {

        d.date_type = $('#date_filter').val();

        d.client_id = $('#client_id').val();

        d.waybill_number = $('#waybill_number').val();

    }

},

"columns" : [



    /*{

        "data" : "id",

        searchable: true

    },*/
    
    // new modified 9.12.24
    {
        "data" : "soft_id",
        searchable: true
    },

    {

        "data" : "recipient.name",

        "defaultContent": ""

    },

    {

        "data" : "recipient.address",

        "defaultContent": ""

    },

    // {

    //     "data" : "status"

    // },

    {

        "data" : "delivery_status"

    },

    {

        "data" : "date"

    },

        @if(Request::query('waybill') == "false")

    { data: 'price' },

        @endif

    {

        "data" : 'action',

        "orderable": false,

        "searchable": false

    }

],

/*
columnDefs: [
    {
        targets: 0, // First column (soft_id)
        render: function (data, type, row, meta) {
            if (row.is_new == 1) {
                return `<span class="ribbon-new">Nouveau</span> ` + data;
            }
            return data;
        }
    }
],

*/

columnDefs: [
    {
        targets: 0, // Column index (soft_id is 0 here)
        render: function (data, type, row, meta) {
            const ribbon = row.is_new == 1 ? `<span class="ribbon-new">Nouveau</span>` : '';
            return `<div class="ribbon-container">${ribbon}${data}</div>`;
        }
    }
],



language: {

    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json',

},

buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]

});


$(document).on('click', '.view-waybill-btn, .waybill-edit, .approve-waybill, .reject-waybill, .wabill-pageview', function(e) {
    // OPTIONAL: Delay navigation to show visual update
    e.preventDefault();

    const waybillId = $(this).data('id');
    const row = $(this).closest('tr');
    const url = $(this).attr('href');

    // Remove the ribbon visually
    row.find('.ribbon-new').remove();
    row.removeClass('highlight-new-row');

    // Optional: show loader or feedback

    // Send Ajax to mark as viewed (set is_new = 0)
    fetch('/admin/waybills/mark-as-viewed/' + waybillId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({})
    })
    .then(response => {
        if (response.ok) {
            // Redirect after a short delay
            setTimeout(() => {
                window.location.href = url;
            }, 200);
        } else {
            console.error('Failed to mark as viewed');
            window.location.href = url; // Still navigate
        }
    })
    .catch(error => {
        console.error('Error:', error);
        window.location.href = url; // Still navigate
    });
});


$(document).on('click', '.approve-waybill',
 function() {
    // alert("clicked!");
    var waybillId = $(this).data('id');
    var status = $(this).data('status');

    // Use Fetch to send the approval request
    updateApprovalStatus1(waybillId, status);
});

// Reject button click handler
$(document).on('click', '.reject-waybill',
 function() {
    var waybillId = $(this).data('id');
    var status = $(this).data('status');

    // Use Fetch to send the rejection request
    updateApprovalStatus1(waybillId, status);
});

// Function to update approval status using Fetch
function updateApprovalStatus1(waybillId, status) {
    // var csrfToken = "OHbGRCkYbXcBc4rWXjZ5kNvh9VrGoOp0CV3aMbMj";
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    // alert(csrfToken);
    // var  selectedNoteId = "22582";
    //  var columnName = "user_id";
    //  var tableName = "waybills"
    //  var newValue = "9090";

    fetch('admin/update-approval-status', {
        // fetch('admin/update-sticky-note-', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            // 'X-CSRF-TOKEN': csrfToken  // CSRF Token from meta tag
            // 'X-CSRF-TOKEN': csrfToken,
        },
        // body: JSON.stringify({ selectedNoteId, columnName,tableName, newValue }),
        body: JSON.stringify({
            waybillId,
            status
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Approval status updated successfully!');
            // Optionally update the UI
            if (status === 1) {
                // Update UI for approve
                $('[data-id="'+waybillId+'"]').removeClass('btn-danger').addClass('btn-success');
            } else {
                // Update UI for reject
                $('[data-id="'+waybillId+'"]').removeClass('btn-success').addClass('btn-danger');
            }
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.log(`Error:, ${error}`);
        alert('Failed to update approval status.');
    });
}



                $('#date_filter').change(function () {
                    table.draw();
                });

                $('#client_id').change(function () {
                    table.draw();
                });

                $('#waybill_number').change(function () {
                    table.draw();
                });


                $('body').on('click', '.btn-approve', function () {
                    var waybillId = $(this).data('waybill-id');

                    Swal.fire({
                        title: 'Confirmation',
                        // text: 'Êtes-vous sur vouloir approuver cette soumission.',
                        text: `Si vous souhaitez conserver une copie de votre soumission avec le prix qui y est attaché, nous vous suggérons d'imprimer ou de sauvegarder le PDF pour vos dossiers, car une fois que vous aurez approuvé la soumission, le prix sera supprimé de la facture.`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Oui',
                        cancelButtonText: 'Non',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // User confirmed, send an AJAX request
                            $.ajax({
                                url: '/admin/waybills/approve/' + waybillId,
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                },
                                success: function (response) {
                                    Swal.fire({
                                        title: 'Succès',
                                        text: response.message,
                                        icon: 'success',
                                        showCancelButton: false,
                                        confirmButtonText: 'Imprimer PDF',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            if (response.pdf_url) {
                                                window.open(response.pdf_url, '_blank');
                                            } else {
                                                Swal.fire({
                                                    title: 'Error',
                                                    text: 'PDF URL not found in the response.',
                                                    icon: 'error',
                                                });
                                            }
                                        }
                                    });

                                    $('#client_table_id').DataTable().ajax.reload();
                                },
                                error: function (xhr, status, error) {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'An error occurred while approving the waybill.',
                                        icon: 'error',
                                    });
                                },
                            });
                        }
                    });
                });


                $('body').on('click', '.btn-reject', function () {
                    var waybillId = $(this).data('waybill-id');

                    Swal.fire({
                        title: 'Confirmation',
                        text: 'Êtes-vous sur de vouloir rejeter cette soumission',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Oui',
                        cancelButtonText: 'Non',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/admin/waybills/reject/' + waybillId,
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                },
                                success: function (response) {
                                    Swal.fire({
                                        title: 'Succès',
                                        text: response.message,
                                        icon: 'success',
                                    });

                                    $('#client_table_id').DataTable().ajax.reload();
                                },
                                error: function (xhr, status, error) {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'An error occurred while rejecting the waybill.',
                                        icon: 'error',
                                    });
                                },
                            });
                        }
                    });
                });


                $('body').on('click', '.btn-delete-submission', function () {
                    var waybillId = $(this).data('waybill-id');

                    Swal.fire({
                        title: 'Confirmation',
                        text: 'Êtes-vous sûr de bien vouloir supprimer cet envoi?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Oui',
                        cancelButtonText: 'Non',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // User confirmed, send an AJAX request
                            $.ajax({
                                url: '/admin/waybills/delete/' + waybillId,
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                },
                                success: function (response) {
                                    Swal.fire({
                                        title: 'Succès',
                                        text: response.message,
                                        icon: 'success',
                                    });

                                    $('#client_table_id').DataTable().ajax.reload();
                                },
                                error: function (xhr, status, error) {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'An error occurred while deleting the waybill.',
                                        icon: 'error',
                                    });
                                },
                            });
                        }
                    });
                });


                $('body').on('click', '.btn-admin-delete-submission', function () {
                    var waybillId = $(this).data('waybill-id');

                    Swal.fire({
                        title: 'Confirmation',
                        text: 'Êtes-vous sûr de bien vouloir supprimer cet envoi?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Oui',
                        cancelButtonText: 'Non',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // User confirmed, send an AJAX request
                            $.ajax({
                                url: '/admin/waybills/delete-by-admin/' + waybillId,
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                },
                                success: function (response) {
                                    Swal.fire({
                                        title: 'Succès',
                                        text: response.message,
                                        icon: 'success',
                                    });

                                    $('#admin_table_id').DataTable().ajax.reload();
                                },
                                error: function (xhr, status, error) {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'An error occurred while deleting the waybill.',
                                        icon: 'error',
                                    });
                                },
                            });
                        }
                    });
                });
            }

            if(submissionType && submissionType === "true")
            {
                $('#client_table_id').DataTable({
                    processing   : true,
                    serverSide   : true,
                    responsive   : true,
                    sorting      : false,
                    lengthChange : true,
                    autoWidth    : false,
                    pageLength   : 5,
                    searching    : true,
                    dom:'lBfrtip',

                    "ajax" : '{{ url("admin/client-submission-archive-index?archive=" ) }}' + submissionType,
                    "columns" : [
                        {"data" : "soft_id", searchable: true},
                        {"data" : "recipient.name", "defaultContent": "N/A"},
                        {"data" : "recipient.address", "defaultContent": "N/A"},
                        {"data" : "status"},
                        {"data" : "delivery_status"},
                        {"data" : "date"},
                        { data: 'price' },
                        {"data" : 'action', "orderable": false, "searchable": false}
                    ],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json',
                    },
                    buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
                });

                // Admin dataTable
                var archivedSubmissionAdmin = $('#admin_table_id').DataTable({
                    processing   : true,
                    serverSide   : true,
                    responsive   : true,
                    sorting      : false,
                    lengthChange : true,
                    autoWidth    : false,
                    pageLength   : 7,
                    searching    : true,
                    dom:'lBfrtip',
                    "ajax" : {
                        "url" : '{{ url("admin/admin-submission-archive-index?archive=" ) }}' + submissionType,
                        "data": function (d) {
                            d.date_type = $('#date_filter').val();
                            d.client_id = $('#client_id').val();
                            d.waybill_number = $('#waybill_number').val();
                        }
                    },
                    "columns" : [

                        {
                            "data" : "soft_id",
                            searchable: true
                        },
                        {
                            "data" : "recipient.name",
                            "defaultContent": "N/A"
                        },
                        {
                            "data" : "recipient.address",
                            "defaultContent": "N/A"
                        },
                        // {
                        //     "data" : "status"
                        // },
                        {
                            "data" : "delivery_status"
                        },
                        {
                            "data" : "date"
                        },
                        { data: 'price' },

                        {
                            "data" : 'action',
                            "orderable": false,
                            "searchable": false
                        }
                    ],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json',
                    },
                    buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
                });

                $('#date_filter').change(function () {
                    archivedSubmissionAdmin.draw();
                });

                $('#client_id').change(function () {
                    archivedSubmissionAdmin.draw();
                });

                $('#waybill_number').change(function () {
                    archivedSubmissionAdmin.draw();
                });
            }

        });

    </script>
@endpush
