<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Waybill;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RouteChauffeurController extends Controller
{
    public function index()
    {
        // return view('admin.waybills.route-chauffeur');
    }

    /*public function drivers()
    {
        $drivers = Driver::all();
        return response()->json($drivers);
    }

    public function getTodayWaybills()
    {
//        $today = Carbon::today();
        $waybills = Waybill::latest()->take(10)->get();
        return response()->json($waybills);
    }*/

    /*public function clients_api()
{
    $clients_data = Client::all();
    return response()->json($clients_data);
}*/
}
