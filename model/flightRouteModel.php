<?php


class flightRouteModel extends ModelBase
{
    protected $table = 'flight_route_tb';
    protected $pk = 'id';

    /**
     * @param null $params
     * @return array
     * @throws Exception
     */
    public function getFlightRoutInternal($params = null)
    {
        $searched_converted_params = functions::switchAlphabet($params['value']);
        $searched_params = $params['value'];

        $result = $this->get([
            'Departure_Code',
            'Departure_City',
            'Departure_City as Departure_CityFa',
            'Departure_CityEn',
            'priorityDeparture'
        ])->where('local_portal', '0');

        if (isset($params['value']) && $params['value']) {
            $result = $result->openParentheses();
            $result = $result->like('Departure_City', $searched_params);
            $result = $result->like('Departure_City', $searched_converted_params);
            $result = $result->like('Departure_CityEn', $searched_params);
            $result = $result->like('Departure_CityEn', $searched_converted_params);
            $result = $result->like('Departure_Code', $searched_params);
            $result = $result->closeParentheses();
        }

        // FIX: correct groupBy
        $result = $result->groupBy('Departure_Code')
            ->orderBy('priorityDeparture=0,priorityDeparture', 'ASC');

            if (isset($params['limit']) && $params['limit']) {
                $result = $result->limit(0, $params['limit']);
            }

        return $result->all();
    }



    /**
     * @throws Exception
     */
    public function getLocalStations($params = null)
    {
        $result = $this->get([
            'Departure_Code as value',
            'Departure_City as title',
            'Departure_CityEn as title_en',
        ])->where('local_portal', '0');

        if ($params['value']) {

            $result = $result->openParentheses();
            $result = $result->like('Departure_City', $params['value']);
            $result = $result->like('Departure_CityEn', $params['value']);
            $result = $result->like('Departure_code', $params['value']);
            $result = $result->closeParentheses();

        }

        $result = $result->groupBy('Departure_code');

        if ($params['limit']) {
            $result = $result->limit(0, $params['limit']);
        }
        return $result->all();
    }


}