


@extends('adminlte::page')

@section('title', 'Votre compte')

@section('content_header')
@role('Driver')
    <h1>Votre compte</h1>
@else
    <h1>Votre compte</h1>
@endrole
@stop

@section('content')

    <div class="container">
        @role('Driver')
        <div class="row">

            {{-- in progress --}}
            <div class="col-md-4">
                <a href="{{ auth()->check() && auth()->user()->roles->contains('id', 3) ? url('admin/driver-waybill/' . auth()->id() . '/in-progress') : '#' }}">

                    <div class="card" style="border-radius: 14px; background-color: #e2c53d; width: 100%; height: 134px;">

                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg value" style="color: #ffffff;">Livraison en cours</span>

                                    <span class="label"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- picked up --}}
            <div class="col-md-4">
                <a href="{{ auth()->check() && auth()->user()->roles->contains('id', 3) ? url('admin/driver-waybill/' . auth()->id() . '/pickedup') : '#' }}">

                    <div class="card" style="border-radius: 14px; background-color: #de7d55; width: 100%; height: 134px;">

                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg value" style="color: #ffffff;">Livraison ramassé</span>

                                    <span class="label"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Delivered --}}
            <div class="col-md-">
                <a href="{{ auth()->check() && auth()->user()->roles->contains('id', 3) ? url('admin/driver-waybill/' . auth()->id() . '/delivered') : '#' }}">

                    <div class="card" style="border-radius: 14px; background-color: #003482; width: 100%; height: 134px;">

                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg value" style="color: #ffffff;">Livraison terminé</span>

                                    <span class="label"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Summary --}}
            <div class="col-md-4">
                <a href="{{ auth()->check() && auth()->user()->roles->contains('id', 3) ? url('admin/driver-summary-table/' . auth()->id()) : '#' }}">

                    <div class="card" style="border-radius: 14px; background-color: #34495e; width: 100%; height: 134px;">

                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg value" style="color: #ffffff;">Rapport de commission</span>

                                    <span class="label"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            @endrole
        </div>
    @php
        $user = auth()->user();
    @endphp
    @if( ($user && $user->roles->contains('id', 1)) || ($user && $user->roles->contains('id', 2)))
        <p>Bienvenue sur le tableau de bord de votre compte.</p>

        <div class="container">
            <div class="row">

                <div class="col-md-6">

                    <a href="{{ route('admin.profile.index')}}">
                        <div class="card" style="border-radius: 14px; background-color: #de7d55; width: 100%; height: 134px;">

                            <div class="card-body">

                                <div class="d-flex">

                                    <p class="d-flex flex-column">

                                        <span class="text-bold text-lg value" style="color: #ffffff;">Votre compte</span>

                                        <span class="label"></span>

                                    </p>

                                </div>

                            </div>

                        </div>
                    </a>

                </div>

                <div class="col-md-6">

                    <a href="{{ url('admin/my-account')}}">
                        <div class="card" style="border-radius: 14px; background-color: #de5555; width: 100%; height: 134px;">

                            <div class="card-body">

                                <div class="d-flex">

                                    <p class="d-flex flex-column">

                                        <span class="text-bold text-lg value" style="color: #ffffff;"> Modifier mon mot de passe </span>

                                        <span class="label"></span>

                                    </p>

                                </div>

                            </div>

                        </div>
                    </a>

                </div>

            </div>
        </div>

    @endif
@stop

@push('js')

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.62.0/codemirror.js"></script>
