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
                <form method="post" action="{{ url('admin/drivers/' . $driver->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="fullName">Nom et prénom</label>
                        <input type="text" class="form-control" name="full_name" id="fullName" value="{{ $driver->full_name }}" required>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="countryCode">Extension</label>
                            <input type="text" class="form-control" id="countryCode" name="extension" value="{{ $driver->extension }}">
                        </div>
                        <div class="col">
                            <label for="phone">téléphone</label>
                            <input type="text" class="form-control" id="phone" value="{{ $driver->phone }}" name="phone">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" value="{{ $driver->email }}" name="email">
                    </div>
                    <div class="form-group">
                        <label for="address">Adresse</label>
                        <textarea class="form-control" id="address" rows="3" name="address">{{ $driver->address }}</textarea>
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
