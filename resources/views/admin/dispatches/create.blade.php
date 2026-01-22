@extends('adminlte::page')

@section('title', ucfirst('Dispatches'))

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


@section('content')
    @role('admin')
    <div class="container center-form">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1 class="text-center">Dispatch Registration</h1>
                <form method="post" action="{{ url('admin/dispatches') }}">
                    @csrf
                    <div class="form-group">
                        <label for="fullName">Nom</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    @endrole
@stop
@push('js')
@endpush
