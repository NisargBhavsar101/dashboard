<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Torann\GeoIP\Facades\GeoIP;

class TrafficController extends Controller
{
    public function index()
    {
        // $location = GeoIP::getLocation();

        return view('traffic.index');
    }
}
