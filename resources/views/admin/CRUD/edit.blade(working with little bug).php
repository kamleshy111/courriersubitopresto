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

    <div class="text-center my-3">
        {!! Form::submit((is_object(@$model) ? 'Mettre à jour' : 'Sauvegarder'))->attrs(['class' => 'btn-primary btn-lg']) !!}
    </div>

    {!! Form::close() !!}


    {{-- ⬇⬇⬇ ADD YOUR PDF UPLOAD FORM HERE (NOT INSIDE main form!) ⬇⬇⬇ --}}
    @if(isset($model) && isset($model->id))
        <hr>

        <div class="card mt-4">
            <div class="card-header">
                <h4>Upload Client PDF</h4>
            </div>

            <div class="card-body">
                <form id="clientPdfForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="client_id" name="client_id" value="{{ $model->id }}">

                    <div class="mb-3">
                        <label class="form-label">Téléverser un PDF</label>
                        <input id="pdfFile" type="file" name="pdf" class="form-control" accept="application/pdf">
                        <div id="pdfError" class="text-danger small mt-1" style="display:none;"></div>
                    </div>

                    <button id="uploadPdfBtn" type="submit" class="btn btn-primary">Upload PDF</button>
                </form>

                @if(!empty($model->client_pdf))
                    <div id="pdfPreview" class="mt-3">
                        <strong>Current PDF:</strong>
                        <a id="currentPdfLink"
                           href="{{ Storage::disk('public')->url($model->client_pdf) }}"
                           target="_blank">
                           {{ basename($model->client_pdf) }}
                        </a>
                    </div>
                @else
                    <div id="pdfPreview" style="display:none;"></div>
                @endif
            </div>
        </div>
    @endif
@stop
