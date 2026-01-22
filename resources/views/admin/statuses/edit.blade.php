@extends('adminlte::page')

@section('title', ucfirst('Statuses'))

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
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.css">


@endpush


@section('content')
    @role('admin')
    <div class="container center-form">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1 class="text-center">Status Edit</h1>
                <form method="post" action="{{ url('admin/statuses/' . $status->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="fullName">Nom</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $status->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="colorPicker">Color</label>
                        <input type="text" value="{{ $status->color }}" class="form-control" id="colorPicker" name="color"/>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    @endrole
@stop
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#colorPicker').spectrum({
                preferredFormat: "hex",
                showInput: true,
                showInitial: true,
                showPalette: true,
                palette: [
                    ["#ff0000", "#00ff00", "#0000ff"],
                    ["#ff00ff", "#ffff00", "#00ffff"]
                ],
            });
        });
    </script>
@endpush
