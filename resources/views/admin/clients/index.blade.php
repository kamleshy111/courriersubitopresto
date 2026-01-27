@extends('adminlte::page')

@section('title', ucfirst('Carnet d´adresse'))

@push('css')
    <style>
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
        /*table.dataTable.no-footer {*/
        /*    border-bottom: -1px solid #f4f6f9!important;*/
        /*}*/
    </style>
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

@endpush
@section('content_header')
    <h1>{{ucfirst('Carnet d´adresse')}}
        @if(\Laratrust::isAbleTo('admin.'.$name.'.create'))
            <a href="{{route('admin.'.$name.'.create')}}" class="btn btn-lg btn-success">NOUVEAU</a>
        @endif

    </h1>
@stop

@section('content')
    {{-- Same address book (Carnet d'adresse) for both admin and client. Admin sees all addresses, client sees own. --}}
    <div class="block table-block mb-4" style="margin-top: 20px;">
        <div class="row">
            <div class="table-responsive">
                <table id="client_table_id" class="table row-border hover">
                    <thead>
                    <tr>
                        <th style="width: 12%; text-align: center!important;">Numéro de facture</th>
                        <th style="width: 13%; text-align: center!important;">Préfixe</th>
                        <th style="width: 13%; text-align: center!important;">Nom</th>
                        <th style="width: 13%; text-align: center!important;">Téléphone</th>
                        <th style="width: 13%; text-align: center!important;">Extension</th>
                        <th style="width: 13%; text-align: center!important;">Adresse</th>
                        <th style="width: 13%; text-align: center!important;">Contact</th>
                        <th style="width: 13%; text-align: center!important;">Note permanente</th>
                        <th style="width: 13%; text-align: center!important;">Voir</th>
                    </tr>
                    </thead>
                    <tbody style="width: 13%; text-align: center!important;">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @role('admin')
    {{-- Legacy: admin user list (kept, not displayed). Uses clients-admin-index. --}}
    <div style="display:none;" aria-hidden="true">
        <table id="admin_table_id" class="table row-border hover">
            <thead>
            <tr>
                <th style="width: 12%; text-align: center!important;">ID de l´utilisateur</th>
                <th style="width: 12%; text-align: center!important;">Nom et prénom</th>
                <th style="width: 13%; text-align: center!important;">E-mail</th>
                <th style="width: 20%; text-align: center!important;">Voir</th>
            </tr>
            </thead>
            <tbody style="text-align: center!important;"></tbody>
        </table>
    </div>
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
        $(document).ready( function () {
            // Same address-book table for both admin and client. Admin sees all addresses, client sees own.
            var addressTableUrl = @json(\Laratrust::hasRole('admin') ? url('admin/clients-admin-address-index') : url('admin/clients-client-index'));
            var userTable = $('#client_table_id').DataTable({
                processing   : true,
                serverSide   : true,
                responsive   : true,
                sorting      : false,
                lengthChange : true,
                autoWidth    : false,
                pageLength   : 7,
                searching:   true,
                dom:'lBfrtip',
                "ajax" : {
                    "url" : addressTableUrl,
                },
                "columns" : [
                    { "data" : "id" },
                    { "data" : "prefix" },
                    { "data" : "name" },
                    { "data" : "phone" },
                    { "data" : "extension" },
                    { "data" : "address" },
                    { "data" : 'contact' },
                    { "data" : 'note_permanent' },
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

            // Legacy admin user list (kept). Only init when element exists.
            var table;
            if ($('#admin_table_id').length) {
                table = $('#admin_table_id').DataTable({
                    processing   : true,
                    serverSide   : true,
                    responsive   : true,
                    sorting      : false,
                    lengthChange : true,
                    autoWidth    : false,
                    pageLength   : 7,
                    searching:   true,
                    dom:'lBfrtip',
                    "ajax" : { "url" : '{{ url("admin/clients-admin-index") }}' },
                    "columns" : [
                        { "data" : "id" },
                        { "data" : "name" },
                        { "data" : "email" },
                        { "data" : 'action', "orderable": false, "searchable": false }
                    ],
                    language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json' },
                    buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
                });
            }

            $(document).on('click', '.delete-user', function(e) {
                e.preventDefault();
                var userId = $(this).data('user_id');
                Swal.fire({
                    title: 'Confirmation',
                    text: 'Voulez-vous vraiment effectuée la suppression?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ url("admin/clients/delete-user") }}/' + userId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}',
                            },
                            success: function (response) {
                                Swal.fire({
                                    title: 'Succès',
                                    text: 'Supprimé avec succès',
                                    icon: 'success',
                                });
                                if (typeof table !== 'undefined' && table) table.ajax.reload();
                            },
                            error: function (xhr, status, error) {
                                Swal.fire({
                                    title: 'Error',
                                    text: `Une erreur s'est produite lors de la suppression de l'utilisateur.`,
                                    icon: 'error',
                                });
                            },
                        });
                    }
                });
            });

            $(document).on('click', '.user-delete-client', function(e) {
                e.preventDefault();
                var clientId = $(this).data('client_id');

                Swal.fire({
                    title: 'Confirmation',
                    text: 'Voulez-vous vraiment effectuée la suppression?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ url("admin/clients/delete-client") }}/' + clientId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}',
                            },
                            success: function (response) {
                                Swal.fire({
                                    title: 'Succès',
                                    text: 'Supprimé avec succès',
                                    icon: 'success',
                                });
                                userTable.ajax.reload();
                            },
                            error: function (xhr, status, error) {
                                Swal.fire({
                                    title: 'Error',
                                    text: `Une erreur s'est produite lors de la suppression de l'utilisateur.`,
                                    icon: 'error',
                                });
                            },
                        });
                    }
                });
            });
        });
    </script>
@endpush
