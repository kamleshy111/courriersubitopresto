@extends('adminlte::page')

@section('title', ucfirst('Vos informations'))
@push('css')
    <style>

        .nav-sidebar .menu-open > .nav-link svg.right,
        .nav-sidebar .menu-open > .nav-link i.right,
        .nav-sidebar .menu-is-opening > .nav-link svg.right,
        .nav-sidebar .menu-is-opening > .nav-link i.right {
            -webkit-transform: rotate(-90deg);
            transform: rotate(-90deg);
        }
    </style>


@endpush
@section('content_header')

@stop


@section('content')

<div class="row justify-content-center">
            <div class="col-md-3 mb-4" style="top: 80px; right: 150px; height: 400px; border: 1px #C5B6B6 solid">
                <div class="card-header">
                    <h5 class="card-title">Modifier</h5>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/profile') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <input type="text" placeholder="Nom" name="name" class="form-control" id="nom" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" placeholder="Téléphone" name="phone" class="form-control" id="telephone">
                        </div>
                        <div class="mb-3">
                            <input type="text" placeholder="Cellulaire" name="cellular" class="form-control" id="cellulaire">
                        </div>
                        <div class="mb-3">
                            <input type="text" placeholder="Adresse" name="address"  class="form-control" id="adresse">
                        </div>
                        <div class="mb-3">
                            <input type="email" placeholder="Courriel" name="email" class="form-control" id="courriel" required>
                        </div>
                        <div class="mb-3">
                            <button type="submit" style="color: #FFF; background: #43A00A; border-radius: 5px; display: flex;">Sauvegarder et envoyer</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-3 align-items-center" style="height: 600px; background: rgba(196, 196, 196, 0.2)">
                <div class="mb-3 ml-4 mt-3">
                    <h4 class="fw-bold" style="color: #000;font-family: Inter;font-size: 20px;font-style: normal;font-weight: 800;line-height: normal;">Vos informations</h4>
                </div>
                <div class="mb-3 ml-4">
                    <label class="fw-bold" style="color: #000;">Nom</label>
                    <p class="mb-0">{{ auth()->user()->name }}</p>
                </div>
                <div class="mb-3 ml-4">
                    <label class="fw-bold" style="color: #000;">Adresse</label>
                    <p class="mb-0">{{ auth()->user()->address }}</p>
                </div>
                <div class="mb-3 ml-4">
                    <label class="fw-bold" style="color: #000;">Courriel</label>
                    <p class="mb-0">{{ auth()->user()->email }}</p>
                </div>
                <div class="mb-3 ml-4">
                    <label class="fw-bold" style="color: #000;">Téléphone</label>
                    <p class="mb-0">{{ auth()->user()->phone }}</p>
                </div>
                <div class="mb-3 ml-4">
                    <label class="fw-bold" style="color: #000;">Cellulaire</label>
                    <p class="mb-0">{{ auth()->user()->cellular }}</p>
                </div>
                <div class="mb-3 ml-4">
                    <label class="fw-bold" style="color: #000;">Heure d’ouverture</label>
                    <p class="mb-0">{{ auth()->user()->name }}</p>
                </div>
            </div>
</div>







{{--<div class="row justify-content-center">--}}
{{--        <div class="col-md-3" style="top: 80px; height: 400px; border: 1px #C5B6B6 solid">--}}
{{--            <div class="card-header">--}}
{{--                <h5 class="card-title">Modifier</h5>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--                    <form action="{{ url('admin/profile') }}" method="post">--}}
{{--                        @csrf--}}
{{--                        <div class="mb-3">--}}
{{--                            <input type="text" placeholder="Nom" name="name" value="{{ auth()->user()->name }}" class="form-control" id="nom" required>--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <input type="text" placeholder="Téléphone" name="phone" value="{{ auth()->user()->phone }}" class="form-control" id="telephone">--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <input type="text" placeholder="Cellulaire" name="cellular" class="form-control" value="{{ auth()->user()->cellular }}" id="cellulaire">--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <input type="text" placeholder="Adresse" name="address" value="{{ auth()->user()->address }}" class="form-control" id="adresse">--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <input type="email" placeholder="Courriel" name="email" value="{{ auth()->user()->email }}" class="form-control" id="courriel" required>--}}
{{--                        </div>--}}

{{--                        <div class="mb-">--}}
{{--                            <button type="submit" style="color: #FFF; background: #43A00A; border-radius: 5px; display: flex;">Sauvegarder et envoyer</button>--}}
{{--                        </div>--}}

{{--                    </form>--}}
{{--                </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-6 col-lg-4" style="background: rgba(196, 196, 196, 0.2)">--}}
{{--                    <div class="mb-3">--}}
{{--                        <h5 class="fw-bold">Vos informations</h5>--}}
{{--                    </div>--}}
{{--                    <div class="mb-3">--}}
{{--                        <label class="fw-bold">Nom</label>--}}
{{--                        <p class="mb-0">Sabrina Bergeron Allard</p>--}}
{{--                    </div>--}}
{{--                    <div class="mb-3">--}}
{{--                        <label class="fw-bold">Adresse</label>--}}
{{--                        <p class="mb-0">321 Lavaltrie</p>--}}
{{--                    </div>--}}
{{--                    <div class="mb-3">--}}
{{--                        <label class="fw-bold">Ville</label>--}}
{{--                        <p class="mb-0">Montreal</p>--}}
{{--                    </div>--}}
{{--                    <div class="mb-3">--}}
{{--                        <label class="fw-bold">Code postal</label>--}}
{{--                        <p class="mb-0">H1H 1H1</p>--}}
{{--                    </div>--}}
{{--                    <div class="mb-3">--}}
{{--                        <label class="fw-bold">Téléphone</label>--}}
{{--                        <p class="mb-0">514-865-1515</p>--}}
{{--                    </div>--}}
{{--                    <div class="mb-3">--}}
{{--                        <label class="fw-bold">Cellulaire</label>--}}
{{--                        <p class="mb-0">514-555-5555</p>--}}
{{--                    </div>--}}
{{--                    <div class="mb-3">--}}
{{--                        <label class="fw-bold">Heure d’ouverture</label>--}}
{{--                        <p class="mb-0">8:00 AM - 5:00 PM</p>--}}
{{--                    </div>--}}
{{--                    <div class="mb-3">--}}
{{--                        <label class="fw-bold">Email</label>--}}
{{--                        <p class="mb-0">info@example.com</p>--}}
{{--                    </div>--}}
{{--                    <div class="mb-3">--}}
{{--                        <label class="fw-bold">Site web</label>--}}
{{--                        <p class="mb-0">www.example.com</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--</div>--}}









@stop


@push('js')

@endpush
