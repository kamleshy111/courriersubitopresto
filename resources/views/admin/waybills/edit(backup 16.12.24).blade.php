@extends('adminlte::page')

@if(Request::query('waybill') == "true")
    @section('title', 'Bordereaux' . ': ' . (is_object(@$model) ? 'modification' : 'création'))
@elseif(Request::query('waybill') == "true")
    @section('title', 'Soumissions' . ': ' . (is_object(@$model) ? 'modification' : 'création'))
@else
@endif

@section('content_header')
    @if (is_object(@$model))
        @if(Request::query('waybill') == "true")
            <h1>Bordereaux: <i>{{ $model->name }}</i>
        @else
             <h1>Soumissions: <i>{{ $model->name }}</i>
        @endif

            @if ($readonly)
                <span class="badge badge-danger">LECTURE SEUL</span>
            @else
                <span class="badge badge-warning">ÉDITION</span>
            @endif
        </h1>
    @else
        @if(Request::query('waybill') == "true")
             <h1>Bordereaux: <i>Création</i>
        @else
             <h1>Soumissions: <i>Création</i>
        @endif
    @endif
@stop

@section('content')
    @if (isset($model) && is_object($model) && isset($model->id))
        {!! Form::open()->fill([$model])->route('admin.' . $name . '.update', [$model->id])->method('PUT')->autocomplete('chrome-off')->id('waybills-form') !!}
    @else
        {!! Form::open()->route('admin.' . $name . '.store')->method('POST')->autocomplete('chrome-off')->id('waybills-form') !!}
    @endif

    {!! Form::hidden('counter', 0) !!}

    @include('admin.' . $name . '.form')


    <div class="text-center my-3">
        @if (!isset($model))
            @if(Request::query('waybill') == "true")
                <button class="btn btn-lg btn-info" type="button" id="add_waybills">+ Bordereaux</button>
                <button class="btn btn-lg btn-danger" type="button" id="remove_waybills" style="display:none">Retirer le dernier
                    Waybill</button>
            @else
{{--                <button class="btn btn-lg btn-info" type="button" id="add_waybills">+ soumissions</button>--}}
{{--                <button class="btn btn-lg btn-danger" type="button" id="remove_waybills" style="display:none">Retirer le dernier--}}
{{--                    Waybill</button>--}}
            @endif

        @endif

            @if(Request::query('waybill') == "true")
                {!! Form::submit(is_object(@$model) ? 'Mettre à jour' : 'Sauvegarder et envoyer*')->attrs([
            'class' => 'btn-primary btn-lg',
        ]) !!}
            @else
                {!! Form::submit(is_object(@$model) ? 'Mettre à jour' : 'envoyer pour approbation')->attrs([
            'class' => 'btn-primary btn-lg',
        ]) !!}
            @endif

    </div>
    {!! Form::close() !!}
@stop

@push('js')
    <script>
        jQuery.fn.preventDoubleSubmission = function() {
            $(this).on('submit', function(e) {
                var $form = $(this);

                if ($form.data('submitted') === true) {
                    // Previously submitted - don't submit again
                    e.preventDefault();
                } else {
                    // Mark it so that the next submit can be ignored
                    $form.data('submitted', true);
                }
            });

            // Keep chainability
            return this;
        };
        $('form').preventDoubleSubmission();

        window.laravel = {
            default_client: @json(Auth::user()->client)
        }
    </script>
@endpush
