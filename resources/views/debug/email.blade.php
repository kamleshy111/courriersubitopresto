<!-- resources/views/download.blade.php -->

{{-- @extends('layouts.app') --}}

{{-- @extends('adminlte::auth.login') --}}
@extends('adminlte::page')

@section('title', 'Email Debug')

@section('content')
<div class="container">
   <h1>Email Variables Test</h1>

    <p><strong>TO Email Address:</strong> {{ $toEmailTest }}</p>
    <p><strong>BCC Email Address:</strong> {{ $bccEmailTest }}</p>

    <hr>
    <h2>Debugging Information</h2>
    <p>If the values above are correct, then the `.env` variables are properly loaded. If not, check your `.env` file or cache settings.</p>

    <hr>
    <h2>Log Data</h2>
    <p>The data has also been logged in <code>storage/logs/laravel.log</code> for further debugging.</p>

</div>


@endsection
