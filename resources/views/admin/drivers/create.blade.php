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


@section('content')
    @role('admin')
    <div class="container center-form">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1 class="text-center">Driver Registration</h1>
                <form method="post" action="{{ url('admin/drivers') }}">
                    @csrf
                    <div class="form-group">
                        <label for="fullName">Nom et prénom</label>
                        <input type="text" class="form-control" name="full_name" id="fullName" placeholder="Enter your full name" required>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="countryCode">Extension</label>
                            <input type="text" class="form-control" id="countryCode" name="extension" placeholder="e.g., +1">
                        </div>
                        <div class="col">
                            <label for="phone">téléphone</label>
                            <input type="text" class="form-control" id="phone" placeholder="Enter your phone number" name="phone">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter your email address" name="email">
                    </div>
                    <div class="form-group">
                        <label for="address">Adresse</label>
                        <textarea class="form-control" id="address" rows="3" placeholder="Enter your address" name="address"></textarea>
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
