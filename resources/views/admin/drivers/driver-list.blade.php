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

        body.sidebar-mini.sidebar-collapse .table td:last-child {
    width: 60px !important; /* or adjust as needed */
}
    </style>
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> --}}

@endpush

@section('content_header')
    <h1 class="mb-4" style="margin-left: 70%">{{ ucfirst('Chauffeurs') }}
        @if(\Laratrust::isAbleTo('admin.drivers.create'))
            <!--<a href="{{ route('admin.drivers.create') }}" class="btn btn-lg btn-success">NOUVEAU</a>-->
            <a href="{{ route('admin.users.create') }}" class="btn btn-lg btn-success">NOUVEAU</a>
        @endif
    </h1>
@stop

@section('content')
    @role('admin')
    <div class="container">
        <h1 >Chauffeurs Table</h1>

        <table class="table table-bordered" style="width: 112%;
        margin-left: -2%;
        margin-bottom: 1rem;
        color: #212529;
        background-color: transparent;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->address }}</td>
                        <td >
                            {{-- <div class="d-flex flex-wrap"> --}}
                            <!-- Action Buttons -->
                            {{-- <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a> --}}
                            {{--<a  class="btn btn-sm btn-warning">--}}
                                <a href="{{ url('/admin/users/' . $user->id . '/edit') }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit mr-1 mb-1"></i> Edit
                            </a>
                            {{-- total assigned waybills --}}
                            {{-- <a href="{{ url('/admin/driver-waybill/admin/in-progress/' . $user->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> View
                            </a> --}}
                            {{-- <a  class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> View
                            </a> --}}
                            {{-- hidden features for futuer --}}
                             <a  href="{{ url('/admin/driver-waybill/admin/in-progress/' . $user->id) }}" class="btn btn-sm btn-primary mt-1">
                                <i class="fas fa-shipping-fast"></i> Livraison en cours
                            </a>
                            <a href="{{ url('/admin/driver-waybill/admin/pickedup/' . $user->id) }}" class="btn btn-sm btn-primary mt-1">
                                <i class="fas fa-shipping-fast"></i> Livraison ramassé
                            </a>
                            <a  href="{{ url('/admin/driver-waybill/admin/delivered/' . $user->id) }}" class="btn btn-sm btn-success mt-1">
                                <i class="fas fa-truck"></i> Livraison terminé
                            </a>
                            <a href="{{ url('/admin/driver-summary-table/' . $user->id) }}" class="btn btn-sm btn-info mt-1">
                                <i class="fas fa-clipboard-list"></i> Rapport de commission
                            </a>
                        {{-- </div> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endrole
@stop

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
    {{-- <script>
        $(document).ready(function() {
            $('table').DataTable();
        });
    </script> --}}
@endpush
