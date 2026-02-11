@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@if($layoutHelper->isLayoutTopnavEnabled())
    @php($def_container_class = 'container')
@else
    @php($def_container_class = 'container-fluid p-5')
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body', 'hold-transition')

@section('body')

    {{-- ONLY CONTENT (no navbar, no sidebar, no footer) --}}
    <div class="content">
        <div class="{{ config('adminlte.classes_content') ?: $def_container_class }} p-0">
            @yield('content')
        </div>
    </div>

@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop
