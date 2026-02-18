<?php


class reservationBus extends clientAuth
{
    public function __construct()
    {
        parent::__construct();
    }



    public function store($params)
    {


        $dataInsert = [
            'company_id' => "{$params['company']}",
            'origin_city' => "{$params['origin_city']}",
            'origin_terminal' => "{$params['origin_terminal']}",
            'destination_city' => "{$params['destination_city']}",
            'destination_terminal' => "{$params['destination_terminal']}",
            'move_date' => "{$params['move_date']}",
            'move_time' => "{$params['move_time']}",
            //this one is miladi
            'move_timestamp' => strtotime(functions::ConvertToMiladi($params['move_date']) . ' ' . $params['move_time']),
            'duration_time' => "{$params['duration_time']}",
            'chairs_count' => "{$params['chairs_count']}",
            'vehicle_name' => "{$params['vehicle_name']}",
            'description' => "{$params['description']}",
            'price' => "{$params['price']}",
        ];

        $ExtraStationData = [];
        foreach ($params as $key => $param) {
            if (strpos($key, 'ExtraStationData') !== false) {
                $ExtraStationData[] = $param;
            }
        }


        $dataInsert['dropping_points'] = json_encode($ExtraStationData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


        return $this->getModel('reservationBusModel')
            ->insertWithBind($dataInsert);
    }

    public function hasAccessToBusReservation()
    {
        return $this->getModel('clientAuthModel')->checkAccessServiceClient(CLIENT_ID, 'BusReservation');
    }

    public function update($params)
    {

        $dataInsert = [
            'company_id' => "{$params['company']}",
            'origin_city' => "{$params['origin_city']}",
            'origin_terminal' => "{$params['origin_terminal']}",
            'destination_city' => "{$params['destination_city']}",
            'destination_terminal' => "{$params['destination_terminal']}",
            'move_date' => "{$params['move_date']}",
            'move_time' => "{$params['move_time']}",
            //this one is miladi
            'move_timestamp' => strtotime(functions::ConvertToMiladi($params['move_date']) . ' ' . $params['move_time']),
            'duration_time' => "{$params['duration_time']}",
            'chairs_count' => "{$params['chairs_count']}",
            'vehicle_name' => "{$params['vehicle_name']}",
            'description' => "{$params['description']}",
            'price' => "{$params['price']}",
        ];

        $ExtraStationData = [];
        foreach ($params as $key => $param) {
            if (strpos($key, 'ExtraStationData') !== false) {
                $ExtraStationData[] = $param;
            }
        }


        $dataInsert['dropping_points'] = json_encode($ExtraStationData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


        return $this->getModel('reservationBusModel')
            ->updateWithBind($dataInsert,['id'=>$params['id']]);
    }

    public function delete($id)
    {
        $reservation_bus_model = $this->getModel('reservationBusModel');
        return $reservation_bus_model->delete('id = '.$id);
    }
    public function getData($params)
    {


        $base_company_bus = $this->getModel('baseCompanyBusModel');
        $station_model = $this->getModel('stationReservationBusModel');
        $reservation_bus_model = $this->getModel('reservationBusModel');
        $cities_model = $this->getModel('busRouteModel');
        $book_bus_model = $this->getModel('bookBusModel');

        $companies = [];
        foreach ($base_company_bus->get(['id', 'name_fa', 'name_en', 'logo'])->all() as $company) {
            $companies[] = $company;
        }

        $conditions = [
            [
                'index' => 'cityOrigin',
                'query_name' => 'origin_city',
            ],
            [
                'index' => 'cityDestination',
                'query_name' => 'destination_city',
            ],
            [
                'index' => 'id',
                'query_name' => 'reservation_bus_tb.id',
            ],
            [
                'index' => 'dateMove',
                'query_name' => 'move_timestamp',
            ]];

        $buses_data = $reservation_bus_model
            ->get([
                $reservation_bus_model->getTable() . '.*',
                'origin_' . $station_model->getTable() . '.station_name as origin_station_name',
                'destination_' . $station_model->getTable() . '.station_name as destination_station_name',
            ], true)
            ->joinAlias([$station_model->getTable(), 'origin_' . $station_model->getTable()], 'id', 'origin_terminal', 'inner')
            ->joinAlias([$station_model->getTable(), 'destination_' . $station_model->getTable()], 'id', 'destination_terminal', 'inner');
        foreach ($conditions as $condition) {
            if ($params[$condition['index']]) {
                if ($condition['index'] == 'dateMove') {
                    $target_timestamp = strtotime(functions::ConvertToMiladi($params['dateMove']));
                    $buses_data = $buses_data->where('move_timestamp', '', '!=')
                        ->where('move_timestamp', $target_timestamp, '>');
                    continue;
                }
                $buses_data = $buses_data->where($condition['query_name'], $params[$condition['index']]);
            }
        }
        $buses_data = $buses_data->all();
        $buses_result = [];

        foreach ($buses_data as $key => $bus_data) {
            $buses_result[$key] = $bus_data;
            foreach ($companies as $company) {
                if ($company['id'] == $bus_data['company_id']) {
                    $buses_result[$key]['company'] = $company;
                    if ($company['logo'] != '') {
                        $buses_result[$key]['company']['logo'] = ROOT_ADDRESS_WITHOUT_LANG . "/pic/companyBusImages/" . $company['logo'];
                    } else {
                        $buses_result[$key]['company']['logo'] = ROOT_ADDRESS_WITHOUT_LANG . "/pic/companyBusImages/no-photo.png";
                    }
                    break;
                }
            }
            foreach ($cities_model->get(['id', 'name_fa'])->all() as $city) {
                if ($city['id'] == $bus_data['origin_city']) {
                    $buses_result[$key]['origin'] = $city;
                }
                if ($city['id'] == $bus_data['destination_city']) {
                    $buses_result[$key]['destination'] = $city;
                }
            }


            $used_chairs=$book_bus_model->get(['passenger_chairs','passenger_gender'])
                ->where('ServiceCode',$bus_data['id'])
                ->where('status','book')
                ->all();


            $buses_result[$key]['left_chairs_count'] = $bus_data['chairs_count'] - count($used_chairs);

            foreach ($used_chairs as $chair){
                $buses_result[$key]['used_chairs'][$chair['passenger_chairs']]= $chair;
            }
        }

        return $buses_result;
    }
}