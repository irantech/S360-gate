<?php

class apiAccounting extends clientAuth
{

    protected $access_api;

    public function __construct() {
        parent::__construct();

        $this->access_api = $this->getAccessAccounting();

        if(!empty($this->access_api['PinAllowAccountant'])){
            functions::insertLog(json_encode($this->access_api,256),'0_check_accountant');
        }

    }

    public function sendDataFlight($params) {
        if (!empty($this->access_api['PinAllowAccountant'])) {
            $user_name = $this->access_api['PinAllowAccountant'];
            $data_request = $this->setDataFlight($params, $user_name);
            if (!file_exists(LOGS_DIR . 'accounting/'.$user_name.'/')) {
                mkdir(LOGS_DIR . 'accounting/'.$user_name.'/', 0777, true);
            }
            functions::insertLog(json_encode([$user_name,$data_request]),'accounting/'.$user_name.'/'.$params['factor_number']);
        }
    }

    public function setDataFlight($params, $user_name) {


        $passengers = [];
        $basic_information = [];
        $flights = [];
        $prices = [];
        $data_bank = [];
        $age = '';
        $adult = 0;
        $child = 0;
        $infant = 0;

        $info_flights = $this->getDataFlight($params['factor_number']);


        $first_data = $info_flights[0];
        functions::insertLog(json_encode($first_data,256),'accounting/'.$user_name.'/'.$first_data['factor_number']);

        $is_credit = ($first_data['payment_type'] == 'credit') ;

        if($is_credit){
            $data_bank = $this->getDataBank($first_data,$user_name);
        }
        if ($first_data['passenger_age'] == 'Adt') {
            $age = 'ADL';
            $adult = $adult + $first_data['adt_qty'];
        } elseif ($first_data['passenger_age'] == 'Chd') {
            $age = 'CHD';
            $child = $child + $first_data['chd_qty'];
        } elseif ($first_data['passenger_age'] == 'Inf') {
            $age = 'INF';
            $infant = $infant + $first_data['adt_qty'];
        }
        foreach ($info_flights as $param) {

            $passengers[] = [
                'NameEn' => $param['passenger_name_en'],
                'SurnameEn' => $param['passenger_family_en'],
                'DateOfBirthFa' => $param['IsInternal'] ? str_replace('-', '', $param['passenger_birthday']) : str_replace('-', '', $param['passenger_birthday_en']),
                'PassportNo' => $param['passportNumber'],
                'Gender' => $param['passenger_gender'] == 'Male' ? 'MR' : 'MRS',
                'Age' => $age,
                'NationalCode' => $param['passenger_national_code'],
            ];

            $prices[] = [
                'NationalCode' => $param['passenger_national_code'],
                'TicketNumber' => $param['eticket_number'],
                'PNR' => $param['pnr'],
                'TaxRial' => $param['adt_tax'],
                'FareRial' => $param['adt_fare'],
                'TotalRial' => $param['adt_price'],
            ];
        }

        $flights = $this->getDetailFlight($info_flights, $prices);

        $data_send_request = [
            'method' => 'NewRepresentative',
            'ShortNameSafar360' => $user_name,
            'Buyer' => [
                'Mobile' => $first_data['mobile_buyer'],
                'Email' => $first_data['email_buyer']
            ],
            'ListPassenger' => $passengers,
            'BasicContractInformation' => [
                'ContractType' => $first_data['IsInternal'] ? 'DomesticFlight' : 'internationalFlight',
                'Vehicle' => $first_data['flight_type'] == 'charter' ? 'charter' : 'system',
                'CountADL' => $adult,
                'CountCHL' => $child,
                'CountINF' => $infant,
                'isCredit' => $is_credit,
                'TitleEnBank' => !$is_credit ? $data_bank['TitleEnBank'] : '',
                'TerminalCode' =>  !$is_credit ? $data_bank['TerminalCode'] : ''
            ],
            'TransportationInformation' => $flights
        ];
        functions::insertLog(json_encode($data_send_request,256),'accounting/'.$user_name.'/'.$first_data['factor_number']);

        $url = "https://www.iran-tech.com/accounting_new_version/parvaz_at/Api360/ReceivingInformation.php";

            $result = functions::curlExecution($url,json_encode($data_send_request),'yes');
            



            functions::insertLog(json_encode($result,256),'accounting/'.$user_name.'/'.$first_data['factor_number']);

            return [
                'data_request'=> $data_send_request,
                'result' => $result
            ];
    }


    public function getDataFlight($factor_number) {
        return $this->getModel('reportModel')->get()->where('factor_number', $factor_number)->all();
    }

    public function getDetailFlight($info_flights, $prices) {
        $is_internal = $info_flights[0]['IsInternal'];

        $airports = $this->getController('airports')->getAirPorts();
        $countries = $this->getController('country')->getCountryCodes();

        $details = [];
        if ($is_internal== '1') {
            foreach ($info_flights as $flight) {
                $details[] = [
                    'Company' => $flight['airline_iata'],
                    'Number' => $flight['flight_number'],
                    'Degree' => $flight['cabin_type'],
                    'Free' => '20',
                    'PNR' => $flight['pnr'],
                    'OriginCountry' => $countries[$airports[$flight['origin_airport_iata']]['CountryEn']]['code'],
                    'OriginCity' => $flight['origin_airport_iata'],
                    'DestinationCountry' => $countries[$airports[$flight['desti_airport_iata']]['CountryEn']]['code'],
                    'DestinationCity' => $flight['desti_airport_iata'],
                    'DateDeparture' =>  str_replace('-','',functions::ConvertToJalali($flight['date_flight'])),
                    'DepartureTime' =>  str_replace(':','',$flight['time_flight']),
                    'ListPassengersThisRoute' => $prices
                ];
            }

        } else {
            $routes = $this->getModel('reportRoutesModel')->get()->where('RequestNumber', $info_flights[0]['request_number'])->all();
            foreach ($routes as $route) {
                $details[] = [
                    'Company' => $route['Airline_IATA'],
                    'Number' => $route['FlightNumber'],
                    'Degree' => $route['CabinType'],
                    'Free' => $route['Baggage'],
                    'PNR' => $info_flights[0]['pnr'],
                    'OriginCountry' => $airports[$route['OriginAirportIata']]['CountryEn'],
                    'OriginCity' => $route['OriginAirportIata'],
                    'DestinationCountry' => $airports[$route['DestinationAirportIata']]['CountryEn'],
                    'DestinationCity' => $route['DestinationAirportIata'],
                    'DateDeparture' => str_replace('-','',functions::ConvertToJalali($route['DepartureDate'])),
                    'DepartureTime' => str_replace(':','',$route['DepartureTime']),
                    'ListPassengersThisRoute' => $prices
                ];
            }
        }

        return $details;
    }

    public function getDataBank($name_bank,$user_name) {

        $data_bank = [];
        $data_send_request = json_encode([
            "method" => "ListBankForSafar360",
            "ShortNameSafar360" => $user_name
        ],256);
        $url = "https://www.iran-tech.com/accounting_new_version/parvaz_at/Api360/ReceivingInformation.php";

        $results = functions::curlExecution($url,$data_send_request,'yes');



        foreach ($results as $result) {

            if($result['TitleEnBank'] == $name_bank){
                $data_bank = $result;
            }
        }
        return $data_bank ;
    }
}

new apiAccounting();