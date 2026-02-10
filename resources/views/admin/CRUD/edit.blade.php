@extends('adminlte::page')

@section('title', ucfirst($name).': '.(is_object(@$model) ? 'modification' : 'création'))

@section('content_header')
    @if(is_object(@$model))
        <h1>{{ucfirst($name)}}: <i>{{$model->name}}</i>
            @if($readonly)<span class="badge badge-danger">LECTURE SEUL</span>
            @else <span class="badge badge-warning">ÉDITION</span>@endif
        </h1>
    @else
        <h1>{{ucfirst($name)}}: <i>Création</i></h1>
    @endif
@stop

@section('content')
   @if(isset($model) && is_object($model) && isset($model->id))
        {!! Form::open()
                ->fill($model)
                ->route('admin.'.$name.'.update', [$model->id])
                ->method('PUT')
                ->autocomplete('chrome-off')
                ->attrs(['enctype' => 'multipart/form-data'])
        !!}
   @else
        {!! Form::open()
                ->route('admin.'.$name.'.store')
                ->method('POST')
                ->autocomplete('chrome-off')
                ->attrs(['enctype' => 'multipart/form-data'])
        !!}
   @endif

    @include('admin.'.$name.'.form')



    @if(\Laratrust::hasRole('admin'))
    <div class="text-center my-3">
        {!! Form::submit((is_object(@$model) ? 'Mettre à jour' : 'Sauvegarder'))->attrs(['class' => 'btn-primary btn-lg']) !!}
    </div>
@endif

    {!! Form::close() !!}

@php
    // Allow non-admin users (e.g. clients, drivers) to use the
    // "request-password-update" button when it is rendered.
    $canRequestPasswordUpdate = auth()->check() && !auth()->user()->hasRole('admin');
@endphp

@if($canRequestPasswordUpdate)
    <script>
        (function () {
            var btn = document.getElementById('request-password-update');
            if (!btn) return;

            function loadSweetAlert(callback) {
                if (window.Swal) {
                    callback();
                    return;
                }

                var script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
                script.onload = callback;
                document.head.appendChild(script);
            }

            function getErrorDiv(input, id) {
                let div = document.getElementById(id);
                if (!div) {
                    div = document.createElement('div');
                    div.id = id;
                    div.className = 'text-danger small mt-1';
                    input.parentNode.appendChild(div);
                }
                return div;
            }

            btn.addEventListener('click', function () {
                loadSweetAlert(function () {

                    var form = btn.closest('form');
                    if (!form) return;

                    var passwordInput = form.querySelector('input[name="password"]');
                    var confirmInput  = form.querySelector('input[name="password_confirmation"]');
                    var password = passwordInput ? passwordInput.value.trim() : '';
                    var confirm  = confirmInput ? confirmInput.value.trim() : '';
                    var passwordError = passwordInput ? getErrorDiv(passwordInput, 'password-error') : null;
                    var confirmError = confirmInput ? getErrorDiv(confirmInput, 'password-confirm-error') : null;

                    if (passwordError) passwordError.textContent = '';
                    if (confirmError) confirmError.textContent = '';

                    let hasError = false;
                    if (!password) {
                        passwordError.textContent = 'Le mot de passe est obligatoire';
                        hasError = true;
                    }
                    if (password && password.length < 6) {
                        passwordError.textContent = 'Le mot de passe doit contenir au moins 6 caractères';
                        hasError = true;
                    }
                    if (confirmInput && !confirm) {
                        confirmError.textContent = 'La confirmation du mot de passe est obligatoire';
                        hasError = true;
                    }
                    if (password && confirm && password !== confirm) {
                        confirmError.textContent = 'Les mots de passe ne correspondent pas';
                        hasError = true;
                    }
                    if (hasError) return;

                    Swal.fire({
                        title: 'Confirmer',
                        text: 'Voulez-vous changer votre mot de passe ?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Oui, mettre à jour',
                        cancelButtonText: 'Annuler'
                    }).then(function (result) {
                        if (!result.isConfirmed) return;

                        var form = btn.closest('form');
                        var passwordInput = form ? form.querySelector('input[name="password"]') : null;
                        var passwordValue = (passwordInput && passwordInput.value && passwordInput.value.trim()) ? passwordInput.value.trim() : '';

                        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        var body = { _token: csrfToken };
                        if (passwordValue) body.suggested_password = passwordValue;

                        fetch(btn.dataset.url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(body)
                        })
                        .then(function (r) { return r.json(); })
                        .then(function (data) {
                            Swal.fire(
                                data.success ? 'Demande envoyee' : 'Erreur',
                                data.success ? 'L administrateur a recu votre demande.' : (data.message || 'Erreur lors de l envoi'),
                                data.success ? 'success' : 'error'
                            );
                        })
                        .catch(function () {
                            Swal.fire('Erreur', 'Impossible de contacter le serveur', 'error');
                        });
                    });
                });
            });
        })();
    </script>
@endif



    {{-- ⬇⬇⬇ ADD YOUR PDF UPLOAD FORM HERE (NOT INSIDE main form!) ⬇⬇⬇ --}}
  @php
    $isAdmin  = \Laratrust::hasRole('admin');
    $isClient = \Laratrust::hasRole('client');
@endphp



{{-- Only admin + client can see this block --}}
@if(($isAdmin || $isClient) && $name === 'clients' && isset($model) && $model->id)

    <hr>

    <div class="card mt-4">
        <div class="card-header">
            <h4>Document</h4>
        </div>

        <div class="card-body">

            {{-- SHOW EXISTING PDF FOR ADMIN + CLIENT --}}
         @if(isset($model) && !empty($model->id))

    @if(!empty($model->client_pdf))
        <div class="d-flex align-items-center mt-2">

            <a id="currentPdfLink"
               href="{{ Storage::disk('public')->url($model->client_pdf) }}"
               target="_blank"
               class="btn btn-primary btn-sm">
                📄 View PDF
            </a>

            @if($isAdmin)
                <button id="deletePdfBtn" class="btn btn-danger btn-sm ml-2">
                    🗑 Delete PDF
                </button>
            @endif

        </div>
    @endif

@endif




            {{-- ADMIN ONLY: PDF UPLOAD FORM --}}
            @if($isAdmin)
                <form id="clientPdfForm" method="post" enctype="multipart/form-data" class="mt-4">
                    @csrf
                    <input type="hidden" id="client_id" name="client_id" value="{{ $model->id }}">

                    <div class="mb-3">
                        <label class="form-label">Upload a new PDF</label>
                        <input id="pdfFile" type="file" name="pdf" class="form-control" accept="application/pdf">
                        <div id="pdfError" class="text-danger small mt-1" style="display:none;"></div>
                    </div>

                    <button id="uploadPdfBtn" type="submit" class="btn btn-primary">
                        Upload PDF
                    </button>
                </form>
            @endif

            {{-- CLIENT ROLE: No upload --}}
            @if($isClient)
                <!--<p class="text-muted mt-2">You do not have permission to upload PDFs.</p>-->
            @endif

        </div>
    </div>
@endif
@stop
