@extends('adminlte::page')

@section('title', ucfirst($name).': '.(is_object(@$model) ? 'modification' : 'création'))

@section('content_header')
    @if(is_object(@$model))
        <h1>{{ucfirst($name)}}: <i>{{$model->name}}</i>
            @if($readonly)<span class="badge badge-danger">LECTURE SEUL</span> @else <span class="badge badge-warning">ÉDITION</span>@endif
        </h1>
    @else
        <h1>{{ucfirst($name)}}: <i>Création</i></h1>
    @endif
@stop

@section('content')
    @if(isset($model) && is_object($model) && isset($model->id))
        {!! Form::open()->fill($model)->route('admin.'.$name.'.update', [$model->id])->method('PUT')->autocomplete('chrome-off') !!}
    @else
        {!! Form::open()->route('admin.'.$name.'.store')->method('POST')->autocomplete('chrome-off') !!}
    @endif

    @include('admin.'.$name.'.form')

    <div class="text-center my-3">
        {!! Form::submit((is_object(@$model) ? 'Mettre à jour' : 'Sauvegarder'))->attrs(['class' => 'btn-primary btn-lg']) !!}
    </div>
    {!! Form::close() !!}
@stop
