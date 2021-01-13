<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FlightsApi;
use App\Models\Resources\FlightGrouping;


class FlightGroupingController extends Controller
{
    function index()
    {
        $address = env('123MILHAS_API_ADDRESS');
        $user = env('123MILHAS_API_USERNAME');
        $password = env('123MILHAS_API_PASSWORD');

        $milhasApi = new FlightsApi($address, $user, $password);

        $flights = json_decode($milhasApi->getFlights());

        return response()->json($flights);
    }

    function grouping()
    {
        $address = env('123MILHAS_API_ADDRESS');
        $user = env('123MILHAS_API_USERNAME');
        $password = env('123MILHAS_API_PASSWORD');

        $milhasApi = new FlightsApi($address, $user, $password);

        $flights = json_decode($milhasApi->getFlights());

        $flightGrouping = new FlightGrouping();

        $flightGroups = $flightGrouping->makeGroups($flights);
        return response($flightGroups, 200);
    }

}
