<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\FlightsApi;
use App\Models\Resources\FlightGrouping;


class GroupingTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testFlightsApiCommunication()
    {
        $address = env('123MILHAS_API_ADDRESS');
        $user = env('123MILHAS_API_USERNAME');
        $password = env('123MILHAS_API_PASSWORD');

        $milhasApi = new FlightsApi($address, $user, $password);

        $flights = json_decode($milhasApi->getFlights());
        
        $this->assertTrue(gettype($flights) == "array");
    }

    public function testGrouping()
    {
        $address = env('123MILHAS_API_ADDRESS');
        $user = env('123MILHAS_API_USERNAME');
        $password = env('123MILHAS_API_PASSWORD');

        $milhasApi = new FlightsApi($address, $user, $password);

        $flights = json_decode($milhasApi->getFlights());

        $flightGrouping = new FlightGrouping();

        $result = $flightGrouping->makeGroups($flights);

        $this->assertTrue(gettype($result) == "object");
    }
}
