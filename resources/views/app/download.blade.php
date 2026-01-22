<!-- resources/views/download.blade.php -->

{{-- @extends('layouts.app') --}}

{{-- @extends('adminlte::auth.login') --}}
@extends('adminlte::page')

@section('title', 'Download APK')

@section('content')
<div class="container">
    <h1>{{__('translations.Telechargez') }} notre application Android</h1>
    {{--<p>Cliquez sur l'image ci-dessous pour {{__('translations.telecharger') }} le fichier:</p>--}}
    
    <p><strong style="background-color: yellow; padding: 2px 4px;">Nouvelle version disponible !</strong> Cliquez sur l'image ci-dessous pour <strong>{{ __('translations.telecharger') }}</strong> la nouvelle application APK :</p>


    <!-- Link to the APK file stored on the server with an image -->
    {{-- old 
    <a href="{{ url('app/CourrierSubito Presto V1.2.apk') }}" class="btn btn-primary" download>--}}
        {{-- <a href="{{ url('app/CourrierSubito Presto_V2.2.0.apk') }}" class="btn btn-primary" download> --}}
        <a href="{{ url('app/CourrierSubito Presto_V2.3.1.apk') }}" class="btn btn-primary" download>
        <img src="{{ asset('images/Google_Play_Store_badge_FR.png') }}" alt="Download APK" class="img-fluid">
    </a>

    <!-- Optional: Add more content -->
   <h5>**Remarque : assurez-vous d'activer "Installer a partir de sources inconnues" sur votre appareil Android si vous rencontrez des {{__('translations.problemes') }} lors de l'installation.</h5>


</div>


@endsection
