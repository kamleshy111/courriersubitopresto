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
        
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;  /* use percentage instead of 100vw */
            height: 100%; /* use percentage instead of 100vh */
            background-color: rgba(0, 0, 0, 0.7);
            display: none; /* Hidden by default */
            justify-content: center;
            align-items: center;
            z-index: 9999;
            flex-direction: column;
            display: flex; /* Needed for flex alignment */
            pointer-events: all;
        }

/* full screen delay loading */

        .overlay-content {
            color: white;
            font-size: 18px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        /* Spinner style */
        .spinner {
            border: 4px solid #f3f3f3; /* Light gray */
            border-top: 4px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 50px; /* Adjust size */
            height: 50px; /* Adjust size */
            animation: spin 1s linear infinite;
            margin-bottom: 10px; /* Space between spinner and text */
        }

        /* Keyframe for spinning animation */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
<div id="overlay" style="display: none;">
        <div class="overlay-content">
            <div class="spinner"></div> <!-- Spinner -->
            <span>Processing...</span>
        </div>
    </div>
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
            {{-- <div class="mb-3 d-flex flex-wrap gap-3 align-items-center">
        <label for="filterId" class="me-2">Rechercher par bordereau</label>
        <input type="text" id="filterId" class="form-control w-auto" placeholder="bordereaux ID de livraison">
        <button id="searchByIdButton" class="btn btn-info">🔎 Rechercher par bordereau</button>
         <div class="ms-auto">
            <button id="resetButton" class="btn btn-secondary">♻️ Réinitialiser</button>
         </div>
    </div> --}}
    
    <div class="row mb-3">
  <div class="col-md-4">
    <div class="input-group">
      <input id="waybill-search-input" type="text" class="form-control" placeholder="Rechercher par bordereau (ex: ABC000123)">
      <div class="input-group-append">
        <button id="waybill-search-btn" class="btn btn-primary" type="button">Rechercher</button>
        <button id="waybill-reset-btn" class="btn btn-secondary" type="button">Reset</button>
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
                            <tbody id="waybillTable" style="width: 13%; text-align: center!important;">

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
document.addEventListener('DOMContentLoaded', function () {
        // Find the anchor tag inside the li
        let clientProfileUpdate = document.querySelector('#dynamic-client-profile a');
        
        @if(auth()->check() && auth()->user()->roles->contains('id', 2))
            clientProfileUpdate.href = "{{ url('admin/users/' . auth()->id()) .'/edit' }}";
            
        @else
            // Optionally, set a fallback URL for non-drivers (or leave as is)
            // waybillLink.href = "/#"; // or set to some default link
        @endif
})
</script>
<script>
/*(function () {
    // Blade helpers: adjust these if your route names/URLs differ
    var datatablesUrl = "{{ url('admin/waybills/datatables') }}"; // adminDataTable endpoint (server-side)
    var searchUrl = "{{ route('admin.waybills.search-by-id') }}"; // named route for adminByWaybillID
    var csrfToken = "{{ csrf_token() }}";

    // Ensure a table element exists with this id in your blade:
    // <table id="waybills-table">...</table>
    var $table = $('#waybills-table');

    // Initialize DataTable if not already initialized
    var table;
    if ($.fn.dataTable.isDataTable($table)) {
        table = $table.DataTable();
    } else {
        table = $table.DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: datatablesUrl,
                type: 'GET',
                data: function (d) {
                    // preserve waybill-type query param if exists in current page URL
                    d['waybill-type'] = "{{ request()->query('waybill-type') }}";
                }
            },
            columns: [
                { data: 'date', name: 'date' },
                { data: 'soft_id', name: 'soft_id' },
                { data: 'recipient_name', name: 'recipient_name', orderable: false, searchable: false },
                { data: 'recipient_address', name: 'recipient_address', orderable: false, searchable: false },
                // { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'delivery_status', name: 'delivery_status', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            // allow raw HTML in these columns (server returned HTML)
            columnDefs: [
                { targets: [1,4,5,6], orderable: false }
            ],
            language: {
                // optional: you can customize strings here
            }
        });
    }

    // Utility: build action buttons matching your controller HTML
    function makeActionButtons(row) {
        var html = '<div class="row"><div class="col-md-12 col-sm-6">';
        html += '<a class="btn btn-sm btn-info" title="modifier" style="width: 2rem; padding: 8px 0; background-color:#054AFA;" href="/admin/waybills/' + row.id + '/edit?waybill={{ request()->query("waybill-type") }}"><i class="fa fa-edit"></i></a> ';
        html += '<a class="btn btn-sm btn-info view-waybill-btn" title="voir la feuille de route" style="width: 2rem; padding: 8px 0; margin-right:3px; margin-left:3px;" href="/admin/waybills/' + row.id + '?waybill={{ request()->query("waybill-type") }}"><i class="fa fa-eye"></i></a> ';
        html += '<button class="btn btn-sm btn-success approve-waybill" data-status="1" data-id="' + row.id + '" title="Approve"><i class="fa fa-check"></i></button> ';
        html += '<button class="btn btn-sm btn-danger reject-waybill" data-status="0" data-id="' + row.id + '" title="Reject" style="margin-left:5px;"><i class="fa fa-times"></i></button> ';
        html += '<a class="btn btn-sm btn-primary" target="_blank" href="/admin/waybill/' + row.id + '"><i class="fas fa-eye"></i> Voir Waybill</a> ';
        if (row.type == 1) {
            html += '<a class="btn btn-sm btn-danger btn-admin-delete-submission" title="Supprimer" style="width: 2rem; padding: 8px 0; margin-right: 3px; margin-left: 3px;" data-waybill-id="' + row.id + '"><i class="fa fa-trash"></i></a>';
        }
        html += '</div></div>';
        return html;
    }

    // Utility: build status badge (server may already send HTML; this is fallback)
    function makeStatusBadge(name, color) {
        if (!name) return '';
        color = color || '#808080';
        return '<span class="badge badge-pill" style="width: 6rem; padding: 8px 0; background-color: ' + color + '; color: #ffffff;">' + name + '</span>';
    }

    // When Rechercher clicked (POST to server)
    $('#waybill-search-btn').on('click', function () {
        var raw = $('#waybill-search-input').val().trim();
        if (!raw) {
            // show message or just focus
            $('#waybill-search-input').focus();
            return;
        }

        // Send POST with CSRF token. Server will parse numeric soft_id from string like ABC000123
        $.ajax({
            url: searchUrl,
            type: 'POST',
            data: {
                id: raw,
                _token: csrfToken
            },
            beforeSend: function () {
                // optional: show loading state
                $('#waybill-search-btn').prop('disabled', true).text('Recherche...');
            },
            success: function (res) {
                $('#waybill-search-btn').prop('disabled', false).text('Rechercher');

                if (!res || !Array.isArray(res.waybills) || res.waybills.length === 0) {
                    // no results: clear table and show a single "no results" row
                    table.clear().draw();
                    // Insert a single row with "Aucun résultat" spanning columns
                    var colspan = $table.find('thead th').length || 7;
                    var $noRow = $('<tr><td colspan="' + colspan + '" class="text-center">Aucun résultat trouvé pour "' + $('<div>').text(raw).html() + '"</td></tr>');
                    $table.find('tbody').html($noRow);
                    return;
                }

                // Map server waybills to DataTables rows
                var newRows = res.waybills.map(function (wb) {
                    // try to use formatted_soft_id if server provided it; otherwise pad numeric
                    var displayedId = wb.formatted_soft_id || (wb.shipper_prefix ? (wb.shipper_prefix + String(wb.soft_id).padStart(6, '0')) : String(wb.soft_id).padStart(6, '0'));

                    return {
                        id: wb.id,
                        date: wb.date || '',
                        soft_id: displayedId,
                        recipient_name: wb.recipient_name || '',
                        recipient_address: wb.recipient_address || '',
                        status: wb.status_name ? makeStatusBadge(wb.status_name, wb.status_color) : (wb.status_html || ''),
                        delivery_status: (function() {
                            // If server returned delivery_status numeric you can convert to badge here.
                            if (!wb.delivery_status) return '';
                            var s = '';
                            var style = 'width: 6rem; padding: 8px 0; background-color: #808080; color: #ffffff;';
                            switch (wb.delivery_status) {
                                case 1: s = '<span class="badge badge-pill" style="' + style + '">Livraison terminé</span>'; break;
                                case 2: s = '<span class="badge badge-pill" style="' + style + '">Livraison ramassé</span>'; break;
                                case 3: s = '<span class="badge badge-pill" style="' + style + '">Livraison en cours</span>'; break;
                                default: s = ''; break;
                            }
                            return s;
                        })(),
                        action: makeActionButtons(wb),
                        type: wb.type || 0
                    };
                });

                // Replace DataTable contents with the new rows
                table.clear();
                table.rows.add(newRows).draw();
            },
            error: function (xhr, status, err) {
                $('#waybill-search-btn').prop('disabled', false).text('Rechercher');
                console.error('Waybill search error:', xhr, status, err);
                var msg = 'Erreur lors de la recherche. Vérifiez la console pour plus de détails.';
                if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                alert(msg);
            }
        });
    });

    // Allow Enter key in input to trigger search
    $('#waybill-search-input').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#waybill-search-btn').click();
        }
    });

    // Reset: restore original server-side DataTable content
    $('#waybill-reset-btn').on('click', function () {
        $('#waybill-search-input').val('');
        // If table is serverSide, reload original data from server
        table.ajax.reload();
    });

    // Delegated handlers for dynamic action buttons (approve/reject/delete)
    $table.on('click', '.approve-waybill', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        // implement your approve AJAX call here; example placeholder:
        console.log('Approve requested for', id);
        // Example:
        // $.post('/admin/waybills/' + id + '/approve', {_token: csrfToken}, function(res){ table.ajax.reload(); });
    });

    $table.on('click', '.reject-waybill', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        console.log('Reject requested for', id);
        // implement your reject AJAX call
    });

    $table.on('click', '.btn-admin-delete-submission', function (e) {
        e.preventDefault();
        var id = $(this).data('waybill-id');
        if (!confirm('Voulez-vous vraiment supprimer ce waybill ?')) return;
        console.log('Delete requested for', id);
        // implement your delete AJAX call:
        // $.ajax({ url: '/admin/waybills/' + id, type: 'DELETE', data: {_token: csrfToken}, success: function(){ table.ajax.reload(); } });
    });

})();
*/
</script>

<script>
(function () {
    // Blade endpoints
    var datatablesUrl = "{{ url('admin/waybills/datatables') }}";
    var searchUrl = "{{ route('admin.waybills.search-by-id') }}";
    var csrfToken = "{{ csrf_token() }}";

    // Helper: create delivery status HTML or empty string when null
    function makeDeliveryStatusHtml(ds) {
        if (ds === null || ds === undefined || ds === "") return '';
        var style = 'width:6rem;padding:8px 0;background-color:#808080;color:#ffffff;';
        switch (parseInt(ds)) {
            case 1: return '<span class="badge badge-pill" style="' + style + '">Livraison terminé</span>';
            case 2: return '<span class="badge badge-pill" style="' + style + '">Livraison ramassé</span>';
            case 3: return '<span class="badge badge-pill" style="' + style + '">Livraison en cours</span>';
            default: return '';
        }
    }

    // Helper: build action column HTML
    function makeActionHtml(wb) {
        var html = '<div class="row"><div class="col-md-12 col-sm-6">';
        html += '<a class="btn btn-sm btn-info" title="modifier" style="width:2rem;padding:8px 0;background-color:#054AFA;" href="/admin/waybills/' + wb.id + '/edit?waybill={{ request()->query("waybill-type") }}"><i class="fa fa-edit"></i></a> ';
        html += '<a class="btn btn-sm btn-info view-waybill-btn" title="voir" style="width:2rem;padding:8px 0;margin:0 3px;" href="/admin/waybills/' + wb.id + '?waybill={{ request()->query("waybill-type") }}"><i class="fa fa-eye"></i></a> ';
        html += '<button class="btn btn-sm btn-success approve-waybill" data-status="1" data-id="' + wb.id + '"><i class="fa fa-check"></i></button> ';
        html += '<button class="btn btn-sm btn-danger reject-waybill" data-status="0" data-id="' + wb.id + '" style="margin-left:5px;"><i class="fa fa-times"></i></button> ';
        html += '<a class="btn btn-sm btn-primary" target="_blank" href="/admin/waybill/' + wb.id + '"><i class="fas fa-eye"></i> Voir Waybill</a> ';
        if (wb.type == 1) html += '<a class="btn btn-sm btn-danger btn-admin-delete-submission" data-waybill-id="' + wb.id + '" style="width:2rem;padding:8px 0;margin:0 3px;"><i class="fa fa-trash"></i></a>';
        html += '</div></div>';
        return html;
    }

    // Detect which table exists on the page (admin preferred)
    function detectTargetTable() {
        if ($('#admin_table_id').length) return $('#admin_table_id');
        if ($('#waybills-table').length) return $('#waybills-table');
        if ($('#client_table_id').length) return $('#client_table_id');
        return null;
    }

    // When search button clicked
    $('#waybill-search-btn').on('click', function () {
        var raw = $('#waybill-search-input').val().trim();
        if (!raw) { $('#waybill-search-input').focus(); return; }

        var $btn = $(this);
        $btn.prop('disabled', true).text('Recherche...');

        $.ajax({
            url: searchUrl,
            type: 'POST',
            dataType: 'json',
            data: { id: raw, _token: csrfToken },
            /*success: function (res) {
                $btn.prop('disabled', false).text('Rechercher');

                if (!res || !Array.isArray(res.waybills) || res.waybills.length === 0) {
                    // show no-results on detected table
                    var $t = detectTargetTable();
                    if ($t && $t.length) {
                        if ($.fn.dataTable.isDataTable($t)) $t.DataTable().clear().draw();
                        var colspan = $t.find('thead th').length || 6;
                        $t.find('tbody').html('<tr><td colspan="' + colspan + '" class="text-center">Aucun résultat trouvé pour "' + $('<div>').text(raw).html() + '"</td></tr>');
                    }
                    return;
                }

                // Build arrays matching expected column order:
                // [ soft_id, recipient_name, recipient_address, delivery_status_html, date, (price?), action_html ]
                var arrays = res.waybills.map(function (wb) {
                    var soft = wb.formatted_soft_id || (wb.soft_id ? String(wb.soft_id).padStart(6, '0') : '');
                    var dsHtml = makeDeliveryStatusHtml(wb.delivery_status); // blank if null
                    var action = makeActionHtml(wb);
                    var row = [ soft, (wb.recipient_name || ''), (wb.recipient_address || ''), (dsHtml || ''), (wb.date || '') ];
                    if (typeof wb.price !== 'undefined') row.push(wb.price);
                    row.push(action);
                    return row;
                });

                var $target = detectTargetTable();
                if (!$target || !$target.length) { console.warn('No table to render results'); return; }

                // If DataTable exists
                if ($.fn.dataTable.isDataTable($target)) {
                    var dt = $target.DataTable();
                    // If serverSide is true, avoid adding arrays into a server-side-only DT by reiniting to client mode
                    var isServerSide = !!(dt.settings && dt.settings()[0] && dt.settings()[0].oInit && dt.settings()[0].oInit.serverSide);
                    if (isServerSide) {
                        // Destroy and reinit in client mode with simple columns to accept arrays
                        try {
                            var originalSettings = dt.settings()[0].oInit || {};
                            dt.destroy();
                            $target.find('tbody').empty();

                            // Build columns based on header count (titles from thead th)
                            var headerCount = $target.find('thead th').length || (arrays[0] ? arrays[0].length : 7);
                            var simpleCols = [];
                            for (var i = 0; i < headerCount; i++) {
                                simpleCols.push({ title: $target.find('thead th').eq(i).text() || '', orderable: false, searchable: false });
                            }

                            // Merge original settings but force client-side data mode
                            var newInit = $.extend(true, {}, originalSettings, {
                                serverSide: false,
                                processing: false,
                                ajax: null,
                                data: arrays,
                                columns: simpleCols
                            });

                            // Initialize new DataTable (client-side)
                            var newDt = $target.DataTable(newInit);
                            // if initialising with data didn't populate columns properly, add rows explicitly
                            try {
                                if (!newDt.data().count()) {
                                    newDt.clear();
                                    newDt.rows.add(arrays).draw(false);
                                }
                            } catch (eInner) {
                                console.warn('Second attempt to populate new DataTable failed:', eInner);
                            }
                            console.log('Reinitialized server-side table as client-side and loaded arrays.');
                            return;
                        } catch (err) {
                            console.error('Reinit fallback failed:', err);
                            alert('Impossible d’afficher les résultats (voir console).');
                            return;
                        }
                    } else {
                        // table is client-side — safe to add arrays
                        try {
                            dt.clear();
                            dt.rows.add(arrays).draw(false);
                            console.log('Successfully added arrays to DataTable.');
                            return;
                        } catch (e) {
                            console.warn('Failed to add arrays directly, attempting reinit fallback:', e);
                            // fallback: destroy + reinit with arrays
                            try {
                                var settings2 = dt.settings()[0].oInit || {};
                                dt.destroy();
                                $target.find('tbody').empty();

                                var headerCount2 = $target.find('thead th').length || (arrays[0] ? arrays[0].length : 7);
                                var cols2 = [];
                                for (var j = 0; j < headerCount2; j++) cols2.push({ title: $target.find('thead th').eq(j).text() || '', orderable: false, searchable: false });

                                var reDt = $target.DataTable($.extend(true, {}, settings2, {
                                    serverSide: false,
                                    processing: false,
                                    data: arrays,
                                    columns: cols2
                                }));

                                if (!reDt.data().count()) {
                                    reDt.clear();
                                    reDt.rows.add(arrays).draw(false);
                                }
                                console.log('Reinitialized DataTable (client-side) and populated rows.');
                                return;
                            } catch (err2) {
                                console.error('Final reinit fallback failed:', err2);
                                alert('Impossible d’afficher les résultats (voir console).');
                                return;
                            }
                        }
                    }
                } else {
                    // Not a DataTable — plain table fallback
                    var html = '';
                    arrays.forEach(function (cols) {
                        html += '<tr>';
                        cols.forEach(function (c) { html += '<td>' + (c || '') + '</td>'; });
                        html += '</tr>';
                    });
                    $target.find('tbody').html(html);
                }
            },*/
            success: function (res) {
    console.log('Search response:', res);
    if (!res || !Array.isArray(res.waybills)) return;

    // Helper to render delivery_status as HTML or empty string
    function dsHtmlFor(ds) {
        if (ds === null || ds === undefined || ds === '') return '';
        var style = 'width:6rem;padding:8px 0;background-color:#808080;color:#ffffff;';
        switch (parseInt(ds)) {
            case 1: return '<span class="badge badge-pill" style="' + style + '">Livraison terminé</span>';
            case 2: return '<span class="badge badge-pill" style="' + style + '">Livraison ramassé</span>';
            case 3: return '<span class="badge badge-pill" style="' + style + '">Livraison en cours</span>';
            default: return '';
        }
    }

    function makeAction(wb) {
        var html = '<div class="row"><div class="col-md-12 col-sm-6">';
        html += '<a class="btn btn-sm btn-info" title="modifier" style="width:2rem;padding:8px 0;background-color:#054AFA;" href="/admin/waybills/' + wb.id + '/edit?waybill={{ request()->query("waybill-type") }}"><i class="fa fa-edit"></i></a> ';
        html += '<a class="btn btn-sm btn-info view-waybill-btn" title="voir" style="width:2rem;padding:8px 0;margin:0 3px;" href="/admin/waybills/' + wb.id + '?waybill={{ request()->query("waybill-type") }}"><i class="fa fa-eye"></i></a> ';
        html += '<button class="btn btn-sm btn-success approve-waybill" data-status="1" data-id="' + wb.id + '"><i class="fa fa-check"></i></button> ';
        html += '<button class="btn btn-sm btn-danger reject-waybill" data-status="0" data-id="' + wb.id + '" style="margin-left:5px;"><i class="fa fa-times"></i></button> ';
        html += '<a class="btn btn-sm btn-primary" target="_blank" href="/admin/waybill/' + wb.id + '"><i class="fas fa-eye"></i> Voir Waybill</a> ';
        if (wb.type == 1) html += '<a class="btn btn-sm btn-danger btn-admin-delete-submission" data-waybill-id="' + wb.id + '" style="width:2rem;padding:8px 0;margin:0 3px;"><i class="fa fa-trash"></i></a>';
        html += '</div></div>';
        return html;
    }

    // Build objects keyed to your DataTable columns (admin_table_id expects these)
    var objects = res.waybills.map(function (wb) {
        return {
            // top-level fields expected by your DataTable columns
            soft_id: wb.formatted_soft_id || (wb.soft_id ? String(wb.soft_id).padStart(6, '0') : ''),
            // DataTables uses `recipient.name` and `recipient.address` — supply nested object
            recipient: {
                name: wb.recipient_name || '',
                address: wb.recipient_address || ''
            },
            delivery_status: dsHtmlFor(wb.delivery_status), // either HTML or ''
            date: wb.date || '',
            // include price if present
            price: (typeof wb.price !== 'undefined') ? wb.price : '',
            // the action column that the table expects (server returned HTML as well in previous flow)
            action: makeAction(wb),
            // keep id available for handlers (even if not displayed)
            id: wb.id,
            // type used by action rendering if needed
            type: wb.type || 0
        };
    });

    // Determine target table — prefer admin_table_id
    var $target = $('#admin_table_id').length ? $('#admin_table_id') : ($('#waybills-table').length ? $('#waybills-table') : $('#client_table_id'));
    if (!$target || !$target.length) {
        console.warn('No target table found to render search results.');
        return;
    }

    // If DataTable exists, add objects (DataTables will use columns.data names)
    if ($.fn.dataTable.isDataTable($target)) {
        var dt = $target.DataTable();

        try {
            // Clear and add objects — DataTables will map object properties to columns.data
            dt.clear();
            dt.rows.add(objects).draw(false);
            console.log('DataTable updated with', objects.length, 'object rows');
            return;
        } catch (e) {
            console.error('Failed to add object rows to DataTable:', e);
            alert('Impossible d’afficher les résultats — voir console.');
            return;
        }
    }

    // Plain table fallback (build markup using the same order)
    var html = '';
    objects.forEach(function (o) {
        html += '<tr>';
        html += '<td>' + (o.soft_id || '') + '</td>';
        html += '<td>' + (o.recipient.name || '') + '</td>';
        html += '<td>' + (o.recipient.address || '') + '</td>';
        html += '<td>' + (o.delivery_status || '') + '</td>';
        html += '<td>' + (o.date || '') + '</td>';
        if (typeof o.price !== 'undefined') html += '<td>' + o.price + '</td>';
        html += '<td>' + (o.action || '') + '</td>';
        html += '</tr>';
    });
    $target.find('tbody').html(html);
},

            error: function (xhr) {
                $btn.prop('disabled', false).text('Rechercher');
                console.error('Waybill search error:', xhr.status, xhr.responseText || xhr.responseJSON);
                var msg = 'Erreur lors de la recherche. Vérifiez la console pour plus de détails.';
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    var messages = [];
                    Object.values(xhr.responseJSON.errors).forEach(function (arr) { messages = messages.concat(arr); });
                    msg = 'Validation error: ' + messages.join(' / ');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                } else if (xhr.status === 401 || xhr.status === 403) {
                    msg = 'Non autorisé. Vérifiez votre session.';
                } else if (xhr.status >= 500) {
                    msg = 'Erreur serveur (HTTP ' + xhr.status + '). Vérifiez les logs.';
                }
                alert(msg);
            }
        });
    });

    // Enter triggers search
    $('#waybill-search-input').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#waybill-search-btn').click();
        }
    });

    // Reset: restore original server-side DataTable (reinitialize if necessary)
    $('#waybill-reset-btn').on('click', function () {
        $('#waybill-search-input').val('');
        var $target = detectTargetTable();
        if ($target && $.fn.dataTable.isDataTable($target)) {
            // If we reinitialized to client mode earlier, prefer reloading via original ajax URL
            // Try to reload if ajax exists, otherwise destroy and re-init using original config if available on page
            var dt = $target.DataTable();
            var originalAjax = (dt.settings && dt.settings()[0] && dt.settings()[0].oInit && dt.settings()[0].oInit.ajax) ? dt.settings()[0].oInit.ajax : null;
            if (originalAjax) {
                // if ajax is a string or object, use DataTables reload
                try { $target.DataTable().ajax.reload(); return; } catch (e) { /* fallthrough */ }
            }
            // fallback: destroy and reload page to restore original server-side behaviour
            try { dt.destroy(); } catch (e) { /* ignore */ }
            location.reload();
        } else {
            // plain table fallback: clear tbody
            if ($target) $target.find('tbody').empty();
        }
    });

    // Delegated action handlers (approve/reject/delete) — reload table on success
    $(document).on('click', '.approve-waybill', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        if (!id || !confirm('Confirmer approbation ?')) return;
        $.post('/admin/waybills/approve/' + id, { _token: csrfToken })
            .done(function () {
                var $t = detectTargetTable();
                if ($t && $.fn.dataTable.isDataTable($t)) $t.DataTable().ajax.reload();
            }).fail(function (xhr) { alert('Erreur lors de l\'approbation'); console.error(xhr); });
    });

    $(document).on('click', '.reject-waybill', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        if (!id || !confirm('Confirmer rejet ?')) return;
        $.post('/admin/waybills/reject/' + id, { _token: csrfToken })
            .done(function () {
                var $t = detectTargetTable();
                if ($t && $.fn.dataTable.isDataTable($t)) $t.DataTable().ajax.reload();
            }).fail(function (xhr) { alert('Erreur lors du rejet'); console.error(xhr); });
    });

    $(document).on('click', '.btn-admin-delete-submission', function (e) {
        e.preventDefault();
        var id = $(this).data('waybill-id');
        if (!id || !confirm('Voulez-vous vraiment supprimer ce waybill ?')) return;
        $.post('/admin/waybills/delete-by-admin/' + id, { _token: csrfToken })
            .done(function () {
                var $t = detectTargetTable();
                if ($t && $.fn.dataTable.isDataTable($t)) $t.DataTable().ajax.reload();
            }).fail(function (xhr) { alert('Erreur lors de la suppression'); console.error(xhr); });
    });

})();
</script>




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
                
                $(document).on('click', '.prix', function (e) {
                    e.preventDefault();

                    const id = $(this).data('id');
                    // console.log(id);
                    // alert(id);
                    
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    if (!id) {
                        alert('No ID available.');
                        return;
                    }

                    document.getElementById('overlay').style.display = 'flex';

                    fetch('/admin/send-price-dispute-email', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ id: id }) // sending actual DB ID
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('overlay').style.display = 'none';
                        Swal.fire({
                            icon: 'success',
                            title: 'Envoyé',
                            text: 'Un courriel a été envoyé pour discuter du prix.',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    })
                    .catch(error => {
                        document.getElementById('overlay').style.display = 'none';
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Échec de l’envoi de l’email.',
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    });
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
        
    // data: waybillType === "true" ? "date" : "submission_approval_date"
    
     /*data: submissionType === "true"
        ? "submission_approval_date"
        : "date",
    render: function (data) {
        return data ?? ""; // avoid showing null or undefined
    }*/



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



$(document).on('click', '.view-waybill-btn, .waybill-edit, .wabill-pageview', function(e) {
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


/*$(document).on('click', '.approve-waybill',
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
});*/

$(document).on('click', '.approve-waybill, .reject-waybill', function (e) {
    e.preventDefault();

    const button = $(this);
    const waybillId = button.data('id');
    const status = button.data('status'); // 1 = approve, 0 = reject
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    const row = button.closest('tr');

    // UI cleanup
    row.find('.ribbon-new').remove();
    row.removeClass('highlight-new-row');

    // Optional: disable button to prevent double clicks
    button.prop('disabled', true);

    // ✅ First: mark as viewed
    fetch('/admin/waybills/mark-as-viewed/' + waybillId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({})
    })
    .then(() => {
        // ✅ Then: send approval/rejection
        return fetch('admin/update-approval-status', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ waybillId, status })
        });
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // ✅ Update UI
            /*if (status === 1) {
                button.removeClass('btn-danger').addClass('btn-success').text('Approved');
            } else {
                button.removeClass('btn-success').addClass('btn-danger').text('Rejected');
            }*/
             if (status === 1) {
                // Update UI for approve
                $('[data-id="'+waybillId+'"]').removeClass('btn-danger').addClass('btn-success');
            } else {
                // Update UI for reject
                $('[data-id="'+waybillId+'"]').removeClass('btn-success').addClass('btn-danger');
            }

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Waybill updated successfully!',
                timer: 1500,
                showConfirmButton: false
            });
        } else {
            throw new Error(data.message || 'Approval failed.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong. Please try again.',
            showConfirmButton: true
        });
    })
    .finally(() => {
        button.prop('disabled', false);
    });
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
                            // "data" : "date"
                            "data" : "submission_approval_date"
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
