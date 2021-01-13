<?php
namespace App\Services;


class FlightsApi
{
    private $apiAddress;
    private $token;

    function __construct($apiAddress, $userName, $userPassword)
    {
        $this->apiAddress = $apiAddress;
        //username e passwords poderão ser utilizados caso a API exija no futuro.
    }

    public function getFlights($id = "")
    {
        $route = '/api/flights/'.$id;
        $curlUrl = curl_init($this->apiAddress.$route);

        curl_setopt_array(
            $curlUrl,
            [
                CURLOPT_RETURNTRANSFER => true,
            ]
        );

        $apiResponse = curl_exec($curlUrl);

        return $apiResponse;
    }

}




?>