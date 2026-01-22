<?php


// app/Http/Controllers/DownloadController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function index()
    {
        return view('/app/download');  // This will refer to the 'resources/views/download.blade.php' view
    }
}
