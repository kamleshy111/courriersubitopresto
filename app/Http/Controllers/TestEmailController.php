<?php
// app/Http/Controllers/TestEmailController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestEmailController extends Controller
{
    public function testEmailVars()
    {
        // Get the environment variables
        // $toEmail = env('OWNER_EMAIL_TO_NOTIFICATION');
        $toEmailTest = env('OWNER_EMAIL_TO_NOTIFICATION') ?? "N/A";
        // if($toEmailTest == "")
        // {
        //     $toEmailTest = "N/A";
        // }
        // dd(env('OWNER_EMAIL_TO_NOTIFICATION'));
        // dd(env('OWNER_EMAIL_BCC_NOTIFICATION'));
        

        $bccEmailTest = env('OWNER_EMAIL_BCC_NOTIFICATION') ?? "N/A";
        
        // if($bccEmailTest == "")
        // {
        //     $bccEmailTest = "N/A";
        // }
        // dd(env('OWNER_EMAIL_BCC_NOTIFICATION'));
        
        // $toEmailTest = "tariq@gmail.com";
        // $bccEmailTest = "wid@gmail.com";

        // Log the values for debugging purposes
        // \Log::info('TO Email: ' . $toEmailTest);
        // \Log::info('BCC Email: ' . $bccEmailTest);

        // Return the values to the view
        return view('/debug/email', compact('toEmailTest', 'bccEmailTest'));
        // return view('/debug/email');
    }
}
