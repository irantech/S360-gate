<?php


class flightRouteCustomerModel extends Model {
	protected $table = 'flight_route_tb';
	protected $pk = 'id';
	
	public function getFlightRoutInternal( $params ) {

        $searched_converted_params =  functions::switchAlphabet($params['value']);
        $searched_params = $params['value'] ;

		$result = $this->get( [
			'Departure_Code',
			'Departure_City',
			'Departure_City AS Departure_CityFa',
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

		if(isset($params['is_group']) && $params['is_group']){
            $result = $result->groupBy('Departure_code')
                ->orderBy('priorityDeparture=0,priorityDeparture', 'ASC');
        }


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

        $result = $result->orderBy('priorityDeparture=0,priorityDeparture', 'ASC');

        if ($params['limit']) {
            $result = $result->limit(0, $params['limit']);
        }
        return $result->all();
    }




}