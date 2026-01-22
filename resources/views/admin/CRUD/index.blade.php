@extends('adminlte::page')

@section('title', ucfirst($name))

@section('content_header')
    <h1>{{ucfirst($name)}} @if(\Laratrust::isAbleTo('admin.'.$name.'.create'))<a href="{{route('admin.'.$name.'.create')}}" class="btn btn-lg btn-success">NOUVEAU</a>@endif</h1>
@stop

@section('content')
    <livewire:data-tables.base model="{{$model}}" />
@stop
