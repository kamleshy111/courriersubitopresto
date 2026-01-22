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
    <h1>{{ucfirst('Chauffeurs')}}
        @if(\Laratrust::isAbleTo('admin.drivers.create'))
            <a href="{{route('admin.drivers.create')}}" class="btn btn-lg btn-success">NOUVEAU</a>
        @endif
    </h1>
@stop

@section('content')
    @role('admin')
    <div class="block table-block mb-4" style="margin-top: 20px;">
        <div class="row">
            <div class="table-responsive px-3">
                <table id="drivers_table_id" class="table row-border hover">
                    <thead>
                    <tr>
                        <th>Numéro de Chauffeurs</th>
                        <th>Nom et prénom</th>
                        <th>Extension</th>
                        <th>téléphone</th>
                        <th>E-mail</th>
                        <th>Adresse</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>

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
            <script>
                $(document).ready( function () {

                    // Client DataTable
                    $('#drivers_table_id').DataTable({
                        processing   : true,
                        serverSide   : true,
                        responsive   : true,
                        sorting      : false,
                        lengthChange : true,
                        autoWidth    : false,
                        pageLength   : 5,
                        searching:   true,
                        dom:'lBfrtip',
                        "ajax" : '{{ url("admin/drivers-index") }}',
                        "columns" : [
                            {
                                "data" : "id"
                            },
                            {
                                "data" : "full_name"
                            },
                            {
                                "data" : "extension"
                            },
                            {
                                "data" : "phone"
                            },
                            {
                                "data" : "email"
                            },
                            {
                                "data" : "address"
                            },
                            {
                                "data" : 'action'
                            }
                        ],
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json',
                        },
                        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
                    });
                });


            </script>
        @endpush
