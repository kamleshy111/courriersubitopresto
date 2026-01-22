@extends('adminlte::page')

@section('title', ucfirst('Carnet d`adresse'))

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
    </style>
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

@endpush
@section('content_header')
    <h1>{{ucfirst('Liste des destinataires')}}
    </h1>
@stop

@section('content')
    @role('admin')
    <div class="block table-block mb-4" style="margin-top: 20px;">
        <input type="hidden" name="user_id" id="user_id" value="{{ $userId }}">

        <div class="row">
            <div class="table-responsive">
                <table id="user-clients_admin_table_id" class="table row-border hover">
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
                        <th style="width: 20%; text-align: center!important;">Voir</th>
                    </tr>
                    </thead>
                    <tbody style="text-align: center!important;">

                    </tbody>
                </table>
            </div>
        </div>
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
                $(document).ready( function () {
                    const userId = $('#user_id').val();
                    console.log(`User Id : ${userId}`);
                    var table = $('#user-clients_admin_table_id').DataTable({
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
                            "url" : '{{ url("admin/clients-user-clients-index") }}/' + userId,
                        },
                        "columns" : [
                            {
                                "data" : "id"
                            },
                            {
                                "data" : "prefix"
                            },
                            {
                                "data" : "name"
                            },
                            {
                                "data" : "phone"
                            },
                            {
                                "data" : "extension"
                            },
                            {
                                "data" : "address"
                            },
                            {
                                "data" : 'contact'
                            },
                            {
                                "data" : 'note_permanent'
                            },
                            {
                                "data" : 'action',
                                "orderable": false,
                                "searchable": false
                            }
                        ],
                        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
                    });


                    $(document).on('click', '.delete-client-by-admin', function(e) {
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
                                        table.ajax.reload();
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
