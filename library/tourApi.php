<?php

class tourApi extends baseController
{

    public $info_api;
    public $url_api;

    public function __construct($info_api) {
        $this->info_api = $info_api;
        $this->url_api = "http://api.apitech.ir/gds/apiTour";
    }

    public function search($data_search) {

        $headers = [
            'Username:' . $this->info_api['Username'],
            'Password:' . $this->info_api['Password'],
            'Content-Type: application/json'
        ];


        $data = json_encode([
            "origin_country_id" => $data_search['origin_country_id'],
            "origin_city_id" => $data_search['origin_city_id'],
            "destination_country_id" => $data_search['destination_country_id'],
            "destination_city_id" => $data_search['destination_city_id'],
            "start_date" => $data_search['start_date'],
            "tourTypeId" => $data_search['tourTypeId'],
            "language" => $data_search['language'],
            "destination_type" => $data_search['destination_type'],
            "is_special" => $data_search['is_special']
        ], 256 | 64);


        $tours = functions::curlExecution($this->url_api . '/search', $data, $headers);


        if ($tours['status'] == 'success' && $tours['code'] == 200) {

            return $this->setObjectSearch($tours['data']);
        }
        return false;
    }

    private function setObjectSearch($tours) {
        $final_tours = [];


        foreach ($tours as $tour) {

            if ($tour['start_price']['price'] > 0) {
                $types_id = [];
                if (!empty($tour['tour_type'])) {
                    foreach ($tour['tour_type'] as $item) {
                        $types_id[] = $item['id'];
                    }
                }
                $final_tours[] = [
                    'id' => $tour['id'],
                    'id_same' => $tour['id_same'],
                    'tour_name' => $tour['tour_name'],
                    'tour_name_en' => $tour['tour_name_en'],
                    'tour_type_id' => $types_id,
                    'tour_code' => $tour['tour_code'],
                    'start_date' => str_replace('-', '', $tour['start_date']),
                    'end_date' => str_replace('-', '', $tour['end_date']),
                    'night' => $tour['night'],
                    'day' => $tour['day'],
                    'tour_pic' => $tour['tour_pic'],
                    'is_special' => $tour['is_special'],
                    'origin_country_id' => $tour['origin_country_id'],
                    'origin_city_name' => $tour['origin_city_name'],
                    'origin_city_name_en' => $tour['origin_city_name_en'],
                    'origin_city_id' => $tour['origin_city_id'],
                    'origin_region_name' => $tour['origin_region_name'],
                    'destination_country_id' => $tour['destination_country_id'],
                    'destination_country_name' => $tour['destination_country_name'],
                    'destination_city_name' => $tour['destination_city_name'],
                    'destination_city_name_en' => $tour['destination_city_name_en'],
                    'destination_region_name' => $tour['destination_region_name'],
                    'airline_name' => $tour['vehicle_name'],
                    'type_vehicle_name' => $tour['type_vehicle_name'],
                    'airline_id' => $tour['vehicle_id'],
                    'type_vehicle_id' => $tour['type_vehicle_id'],
                    'arrayTypeVehicle' => $tour['vehicles'],
                    'infoTourRout' => $tour ['info_tour_rout'],
                    'is_api' => true,
                    'min_price_r' => $tour['start_price']['price'],
                    'min_price_a' => $tour['start_price']['price_currency'],
                    'currency_title_fa' => $tour['start_price']['Currency_title'],

                ];
            }
        }

        return $final_tours;

    }


    public function detail($tour_id) {
        
        $headers = [
            'Username:' . $this->info_api['Username'],
            'Password:' . $this->info_api['Password'],
            'Content-Type: application/json'
        ];


        $data = json_encode([
            'tour_id' => $tour_id
        ], 256 | 64);


        $tours = functions::curlExecution($this->url_api . '/detail', $data, $headers);
        if ($tours['status'] == 'success' && $tours['code'] == 200) {

            return $tours['data'];
        }
        return false;
    }


    public function packages($params) {
        $headers = [
            'Username:' . $this->info_api['Username'],
            'Password:' . $this->info_api['Password'],
            'Content-Type: application/json'
        ];
        $data_request_search = [
            "tour_id" => $params['tour_id'],
            "start_date" => $params['start_date'],
            "end_date" => $params['end_date'],
            "one_day" => $params['one_day']
        ];

         return functions::curlExecution($this->url_api . '/packages', json_encode($data_request_search,256|64), $headers);
    }

    public function getDataHotelTourPackage($package_id) {
        $headers = [
            'Username:' . $this->info_api['Username'],
            'Password:' . $this->info_api['Password'],
            'Content-Type: application/json'
        ];
        $data_request_search = [
            "package_id" => $package_id,
        ];


        return functions::curlExecution($this->url_api . '/hotelsPackages', json_encode($data_request_search,256|64), $headers);
    }


    public function getDataInformationHotel($hotel_id) {
        $headers = [
            'Username:' . $this->info_api['Username'],
            'Password:' . $this->info_api['Password'],
            'Content-Type: application/json'
        ];
        $data_request_search = [
            "hotel_id" => $hotel_id,
        ];

        return functions::curlExecution($this->url_api . '/informationsHotel', json_encode($data_request_search,256|64), $headers);
    }

    public function tourRoutesApi($params) {
        $headers = [
            'Username:' . $this->info_api['Username'],
            'Password:' . $this->info_api['Password'],
            'Content-Type: application/json'
        ];
        $data_request_search = [
            "package_id" => $params['package_id'],
            "city_id" => $params['city_id'],
        ];

        return functions::curlExecution($this->url_api . '/tourRoutes', json_encode($data_request_search,256|64), $headers);
    }


    public function infoTourByDateApi($params) {
        $headers = [
            'Username:' . $this->info_api['Username'],
            'Password:' . $this->info_api['Password'],
            'Content-Type: application/json'
        ];
        $data_request_search = [
            'tour_code'=> $params['tour_code'],
            'start_date'=> $params['start_date'],
            'type_tour'=>$params['type_tour']
        ];

        return functions::curlExecution($this->url_api . '/infoTourByDate', json_encode($data_request_search,256|64), $headers);
    }


    public function packageOfTour($params) {
        $headers = [
            'Username:' . $this->info_api['Username'],
            'Password:' . $this->info_api['Password'],
            'Content-Type: application/json'
        ];
        $data_request_search = [
            'package_id'=> $params['package_id'],
        ];

        return functions::curlExecution($this->url_api . '/packageOfTour', json_encode($data_request_search,256|64), $headers);
    }

    public function getListTourTravelProgramApi($params) {
        $headers = [
            'Username:' . $this->info_api['Username'],
            'Password:' . $this->info_api['Password'],
            'Content-Type: application/json'
        ];
        $data_request_search = [
            'id_same'=> $params['id_same'],
        ];

        return functions::curlExecution($this->url_api . '/listTourTravelProgram', json_encode($data_request_search,256|64), $headers);
    }



    public function infoSpecialHotel($params) {
        $headers = [
            'Username:' . $this->info_api['Username'],
            'Password:' . $this->info_api['Password'],
            'Content-Type: application/json'
        ];
        $data_request_search = [
            'hotel_id'=> $params['hotel_id'],
        ];

        return functions::curlExecution($this->url_api . '/infoSpecialHotel', json_encode($data_request_search,256|64), $headers);
    }

    public function getInfoTour($params) {
        $headers = [
            'Username:' . $this->info_api['Username'],
            'Password:' . $this->info_api['Password'],
            'Content-Type: application/json'
        ];
        $data_request_search = [
            'tour_id'=> $params['tour_id'],
        ];

        return functions::curlExecution($this->url_api . '/getInfoTour', json_encode($data_request_search,256|64), $headers);
    }


    public function infoTourRoutByIdTour($params) {
        $headers = [
            'Username:' . $this->info_api['Username'],
            'Password:' . $this->info_api['Password'],
            'Content-Type: application/json'
        ];
        $data_request_search = [
            'tour_id'=> $params['tour_id'],
        ];

        return functions::curlExecution($this->url_api . '/getInfoTourRoutByIdTour', json_encode($data_request_search,256|64), $headers);
    }

    public function typeVehicleApi($params) {
        $headers = [
            'Username:' . $this->info_api['Username'],
            'Password:' . $this->info_api['Password'],
            'Content-Type: application/json'
        ];
        $data_request_search = [
            'tour_id'=> $params['tour_id'],
        ];

        return functions::curlExecution($this->url_api . '/getTypeVehicleApi', json_encode($data_request_search,256|64), $headers);
    }


    public function getOriginCity($params) {

        $headers = [
            'Username:' . $this->info_api['Username'],
            'Password:' . $this->info_api['Password'],
            'Content-Type: application/json'
        ];
        $data_request_search = $params ;

        return functions::curlExecution($this->url_api . '/getOriginCities', json_encode($data_request_search,256|64), $headers);
    }


    public function getOriginCitiesExternal($params) {

        $headers = [
            'Username:' . $this->info_api['Username'],
            'Password:' . $this->info_api['Password'],
            'Content-Type: application/json'
        ];
        $data_request_search = $params ;

        return functions::curlExecution($this->url_api . '/getOriginCitiesExternal', json_encode($data_request_search,256|64), $headers);
    }


    public function getCountryDestination($params) {

        $headers = [
            'Username:' . $this->info_api['Username'],
            'Password:' . $this->info_api['Password'],
            'Content-Type: application/json'
        ];
        $data_request_search = $params ;

        return functions::curlExecution($this->url_api . '/getCountryDestination', json_encode($data_request_search,256|64), $headers);
    }


    public function getCityDestinationExternal($params) {

        $headers = [
            'Username:' . $this->info_api['Username'],
            'Password:' . $this->info_api['Password'],
            'Content-Type: application/json'
        ];

        return functions::curlExecution($this->url_api . '/getCityDestinationExternal', json_encode($params,256|64), $headers);
    }

    public function getAllTypeTour($params) {

        $headers = [
            'Username:' . $this->info_api['Username'],
            'Password:' . $this->info_api['Password'],
            'Content-Type: application/json'
        ];

        return functions::curlExecution($this->url_api . '/getAllTypeTour', json_encode([],256|64), $headers);
    }
}