@extends('adminlte::page')

@section('title', ucfirst('Voir/Cacher prix'))

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

    <div class="container center-form">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1 class="text-center">Voir / Cacher prix</h1>
                <form method="post" action="{{ url('admin/settings') }}">
                    @csrf
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="hidden" name="show_price" value="0">
                        <input class="form-check-input" type="checkbox" id="showPricesCheckbox" name="show_price" value="1" {{ isset($settings->show_price) && $settings->show_price == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="showPrices">Montrer les prix</label>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Soumettre</button>
                </form>
            </div>
        </div>
    </div>

@stop
@push('js')

@endpush
