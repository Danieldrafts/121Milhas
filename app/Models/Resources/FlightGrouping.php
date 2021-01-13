<?php
namespace App\Models\Resources;
use App\Models\Resources\Group;


class FlightGrouping
{
    public function makeGroups($flights)
    {
        $flightsCollection = collect($flights);

        //separar por tarifas
        $flightsByFares = $flightsCollection->groupBy('fare');

        //separar também por tipo (ida e volta)
        $flightsByFares = $this->groupByInboundOrOutbound($flightsByFares);

        //encontrar preços iguais e combinar voos
        $combinedFlights = collect();

        foreach($flightsByFares as $flightsByFare)
        {
            $groupedOutbounds = $this->findEqualItems($flightsByFare[0], 'price');
            $groupedinounds = $this->findEqualItems($flightsByFare[1], 'price');

            $combinedFlights->push($this->combineFlights($groupedOutbounds, $groupedinounds));
        }

        //formatar dados para apresentação
        $combinedFlightsOutput = $this->formatOutput($combinedFlights);

        $combinedFlightsOutput['flights'] = $flightsCollection;
        $combinedFlightsOutput['groups'] = $combinedFlightsOutput['groups']->sortBy('totalPrice');

        return $combinedFlightsOutput;
    }

    function findEqualItems($items, $field)
    {
        $equalItems = collect();
        foreach($items as $item)
        {
            $equal = $items->where($field,$item->{$field});
            if($equal->isNotEmpty())
            {
                $equalItems->push($equal);

                foreach($equal as $item)
                    $items = $items->reject($item, function($collectionItem,$item){
                    return $collectionItem->{$field} == $item->{$field};
                });

                $equal = null;
            }
        }

        return $equalItems;
    }

    function combineFlights($idas, $voltas)
    {
        $groups = collect();
        
        foreach($idas as $keyIda => $ida)
        {
            
            foreach($voltas as $keyVolta => $volta)
            {        
                $group = new Group();       
                $group->outbound = $ida;
                $group->inbound = $volta;
                $group->getTotalPrice();
                $groups = $groups->push($group);
            }  
        }

        return $groups;
    }

    function formatOutput($combinedFlights)
    {
        $combinedFlightsOutput = collect();
        $combinedFlightsOutput['flights'] = null;
        $combinedFlightsOutput['groups'] =  collect();
        $combinedFlightsOutput['totalGroups'] = 0; // quantidade total de grupos
        $combinedFlightsOutput['totalFlights'] = 0; // quantidade total de voos únicos
        $combinedFlightsOutput['cheapestPrice'] = 0.0; // preço do grupo mais barato
        $combinedFlightsOutput['cheapestGroup'] = null; // id único do grupo mais barato

        foreach($combinedFlights as $combinedFlight)
        {
            $combinedFlightsOutput['totalGroups'] += $combinedFlight->count();
            foreach($combinedFlight as $combinedFlightGroup)
            {
                $combinedFlightsOutput['groups']->push($combinedFlightGroup);

                if(($combinedFlightGroup->outbound->count() == 1) && ($combinedFlightGroup->inbound->count() == 1))
                {
                    $combinedFlightsOutput['totalFlights'] += 1;
                }

            }
        }

        $combinedFlightsOutput['cheapestPrice'] = $combinedFlightsOutput['groups']->min('totalPrice');
        $combinedFlightsOutput['cheapestGroup'] = $combinedFlightsOutput['groups']
                                                   ->where(
                                                       'totalPrice', $combinedFlightsOutput['cheapestPrice']
                                                    )[0]
                                                   ->uniqueId;
        return $combinedFlightsOutput;
    }
    
    function groupByInboundOrOutbound($flights)
    {
        foreach($flights as $key => $flight)
        {
            $flights[$key] = $flights[$key]->groupBy('inbound');
        }

        return $flights;
    }

}

?>