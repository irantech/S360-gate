<?php
error_reporting(1);
error_reporting(E_ALL | E_STRICT);
@ini_set('display_errors', 1);
@ini_set('display_errors', 'on');
require '../../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
require LIBRARY_DIR . 'functions.php';
require LIBRARY_DIR . 'Model.php';
require LIBRARY_DIR . 'ModelBase.php';
require LIBRARY_DIR . 'Session.php';
require CONTROLLERS_DIR . 'dateTimeSetting.php';

//require LIBRARY_DIR . 'Jalali.php';

class cronJobsSepehr360
{

    public $FromDate = '';
    public $ToDate = '';
    public $difference;

    public function __construct()
    {


        $this->FromDate = date("Y-m-d", time());
        $this->ToDate = date("Y-m-d", strtotime($this->FromDate . '+ 10 days'));
        $FromDate = $this->FromDate;
        $ToDate = $this->ToDate;


        $DiffDateInt = date_diff(date_create($this->ToDate), date_create($this->FromDate), true)->format('%a');

        $this->difference = $DiffDateInt;


        $data = $this->setDataFlight();

        $this->cache('flights', 600, $data);

        error_log('Set flights in Redis in : ' . date('Y/m/d H:i:s') . ' from : =>' . $FromDate . ' to =>' . $ToDate . " \n", 3, LOGS_DIR . 'log_sepehr360.txt');
    }

    public function setDataFlight()
    {
//        $ArrCitys = array(array('THR', 'MHD'),array('MHD', 'THR'),array('THR', 'KIH'), array('KIH', 'THR'),array('ADU', 'MHD'),array('GBT', 'MHD'),array('IIL', 'THR'),array('KIH', 'AWZ'),array('MHD', 'ABD'),array('THR', 'ABD'),array('THR', 'RAS'),array('RAS', 'THR'),array('SYZ', 'THR'),array('THR', 'SYZ'),array('THR', 'AZD'),array('AZD', 'THR'),array('AWZ', 'THR'),array('THR', 'AWZ'),array('ABD', 'THR'),array('BND', 'THR'),array('THR', 'BND'),array('BUZ', 'THR'),array('THR', 'BUZ'),array('PGU', 'THR'),array('THR', 'PGU'),array('GSM', 'THR'),array('THR', 'GSM'),array('TBZ', 'THR'),array('THR', 'TBZ'),array('IFN', 'THR'),array('THR', 'IFN'),array('ZAH', 'THR'),array('THR', 'ZAH'),array('ZBR', 'THR'),array('THR', 'ZBR'),array('THR', 'IIL'),array('GBT', 'THR'),array('THR', 'GBT'),array('SRY', 'THR'),array('THR', 'SRY'),array('ADU', 'THR'),array('THR', 'ADU'),array('KER', 'THR'),array('THR', 'KER'),array('KSH', 'THR'),array('THR', 'KSH'),array('RAS', 'MHD'),array('MHD', 'RAS'),array('MHD', 'KIH'),array('KIH', 'MHD'),array('MHD', 'SYZ'),array('SYZ', 'MHD'),array('AZD', 'MHD'),array('MHD', 'AZD'),array('AWZ', 'MHD'),array('MHD', 'AWZ'),array('ABD', 'MHD'),array('BND', 'MHD'),array('MHD', 'BND'),array('BUZ', 'MHD'),array('MHD', 'BUZ'),array('PGU', 'MHD'),array('MHD', 'BGU'),array('MHD', 'GSM'),array('GSM', 'MHD'),array('MHD', 'TBZ'),array('MHD', 'IFN'),array('IFN', 'MHD'),array('MHD', 'ZAH'),array('ZAH', 'MHD'),array('MHD', 'ZBR'),array('ZBR', 'MHD'),array('MHD', 'IIL'),array('IIL', 'MHD'),array('MHD', 'GBT'),array('MHD', 'SRY'),array('SRY', 'MHD'),array('MHD', 'ADU'),array('KER', 'MHD'),array('MHD', 'KER'),array('KSH', 'MHD'),array('KIH', 'RAS'),array('RAS', 'KIH'),array('KIH', 'SYZ'),array('SYZ', 'KIH'),array('KIH', 'AZD'),array('AZD', 'KIH'),array('AWZ', 'KIH'),array('KIH', 'ABD'),array('ABD', 'KIH'),array('KIH', 'BND'),array('BND', 'KIH'),array('KIH', 'BUZ'),array('BUZ', 'KIH'),array('KIH', 'PGU'),array('PGU', 'KIH'),array('KIH', 'GSM'),array('GSM', 'KIH'),array('TBZ', 'KIH'),array('KIH', 'TBZ'),array('IFN', 'KIH'),array('KIH', 'IFN'),array('KIH', 'ZAH'),array('ZAH', 'KIH'),array('KIH', 'ZBR'),array('ZBR', 'KIH'),array('KIH', 'IIL'),array('IIL', 'KIH'),array('KIH', 'GBT'),array('GBT', 'KIH'),array('KIH', 'SRY'),array('SRY', 'KIH'),array('ADU', 'KIH'),array('KIH', 'ADU'),array('KIH', 'KER'),array('KER', 'KIH'),array('KIH', 'KSH'),array('KSH', 'KIH'));
        $ArrCities = array(array('THR', 'MHD'), array('MHD', 'THR'), array('THR', 'KIH'), array('KIH', 'THR'));
        $difference = $this->difference;

        for ($i = 0; $i <= $difference; $i++) {

            foreach ($ArrCities as $arrCity) {
                $FromDateInt = functions::ConvertToDateJalaliInt($this->FromDate);
                $FromDate = dateTimeSetting::jdate("Y-m-d", $FromDateInt, '', '', 'en');

                $requestInfo['DepartureDate'] = $FromDate ;
                $requestInfo['Origin'] =  $arrCity[0] ;
                $requestInfo['Destination'] = $arrCity[1] ;

                $data = $this->search($requestInfo);

                if (isset($data['Result']) && $data['Result']== 'true') {
                    $count = count($data['Data']);
                    for ($j = 0; $j < $count; $j++) {
                        if (strtolower($data['Data'][$j]['type']) == 'system' && $data['Data'][$j]['capacity'] > 0) {
                            $Response['OriginIataCode'] = $data['Data'][$j]['from'];
                            $Response['DestinationIataCode'] = $data['Data'][$j]['to'];
                            $Response['DepartureDateTime'] = $data['Data'][$j]['date_flight'] . 'T' . $data['Data'][$j]['time_flight'];
                            $Response['DepartureDate'] = $data['Data'][$j]['date_flight'];

                            $ArrivalTime = functions::format_hour_arrival($Response['OriginIataCode'], $Response['DestinationIataCode'], $data['Data'][$j]['time_flight']);
                            $departureDate =  $data['Data'][$j]['date_flight'];
                            $ArrivalDate = functions::Date_arrival($Response['OriginIataCode'], $Response['DestinationIataCode'], $data['Data'][$j]['time_flight'], $departureDate);
                            $ArrivalDateArray = explode('/', $ArrivalDate);
                            $ArrivalDate = dateTimeSetting::jalali_to_gregorian($ArrivalDateArray[0], $ArrivalDateArray[1], $ArrivalDateArray[2], '-');
                            $Response['ArrivalDateTime'] = $ArrivalDate . 'T' . $ArrivalTime . ':00';
                            $HourDuration = functions::LongTimeFlightHours($Response['OriginIataCode'], $Response['DestinationIataCode']);
                            $Response['FlightDuration'] = ($HourDuration['Hour'] * 60) + $HourDuration['Minutes'];
                            $Response['FlightNumber'] = $data['Data'][$j]['number_flight'];
                            $Response['AirlineIataCode'] = $data['Data'][$j]['IATA_code'];
                            $Response['IsFlightCharter'] = false;
                            $Response['AircraftName'] = $data['Data'][$j]['carrier'];

                            $Response['TotalFareAdult'] = $data['Data'][$j]['price_final'];
                            $Response['TotalFareChild'] = $data['Data'][$j]['price_final_chd'];
                            $Response['TotalFareInfant'] = $data['Data'][$j]['price_final_inf'];
                            $Response['CurrencyCode'] = 'IRR';
                            $Response['BookingCode'] = $data['Data'][$j]['cabinclass'];

                            if ($data['Data'][$j]['type_flight'] != 'Economy') {
                                $Response['CabinType'] = 'Business';
                            } else {
                                $Response['CabinType'] = 'Economy';
                            }

                            $Response['FareBasisName'] = $data['Data'][$j]['cabinclass'] . $data['Data'][$j]['from'] . $data['Data'][$j]['to'];
                            $Response['AvailableSeatCount'] = $data['Data'][$j]['capacity'];
                            $PersianDate = functions::ConvertToDateJalaliInt(substr($data['Data'][$j]['date_flight'], 0, 10));
                            $PersianDate = dateTimeSetting::jdate("Y-m-d", $PersianDate, '', '', 'en');
                            $Response['RedirectionLink'] = $_SERVER['HTTP_HOST'] . '/gds/local/1/' . strtoupper($data['Data'][$j]['from']) . '-' . strtoupper($data['Data'][$j]['to']) . '/' . $PersianDate . '/Y/1-0-0/' . $Response['FlightNumber'];

                            $InfoData[] = $Response;

                        }
                    }
                }
            }
            $this->FromDate = date('Y-m-d', strtotime($this->FromDate . '+ 1 days'));
        }


        foreach ($InfoData as $k => $ticket) {

            $sort['DepartureDate'][$k] = $ticket['DepartureDate'];
            $sort['FlightNumber'][$k] = $ticket['FlightNumber'];
            $sort['AirlineIataCode'][$k] = $ticket['AirlineIataCode'];
            $sort['TotalFareAdult'][$k] = $ticket['TotalFareAdult'];
        }

        array_multisort($sort['DepartureDate'], SORT_ASC, $sort['FlightNumber'], SORT_ASC, $sort['AirlineIataCode'], SORT_ASC, $sort['TotalFareAdult'], SORT_ASC, $InfoData);
        $count1 = count($InfoData);
        $i = 0;
        $j = 0;

        for ($key = 0; $key < $count1; $key++) {


            if ($key > 0 && (strcmp($InfoData[$key - 1]['FlightNumber'], $InfoData[$key]['FlightNumber']) == 0) && (strcmp($InfoData[$key - 1]['AirlineIataCode'], $InfoData[$key]['AirlineIataCode']) == 0) && (strcmp($InfoData[$key - 1]['DepartureDate'], $InfoData[$key]['DepartureDate']) == 0)) {
//                $j++;
            } else {
                if ($key > 0) { // not when $key == 0
                    $i++;
//                    $j = 0;
                }
                $tickets[$i]['OriginIataCode'] = $InfoData[$key]['OriginIataCode'];
                $tickets[$i]['DestinationIataCode'] = $InfoData[$key]['DestinationIataCode'];
                $tickets[$i]['DepartureDateTime'] = $InfoData[$key]['DepartureDateTime'];
                $tickets[$i]['ArrivalDateTime'] = $InfoData[$key]['ArrivalDateTime'];
                $tickets[$i]['FlightDuration'] = $InfoData[$key]['FlightDuration'];
                $tickets[$i]['FlightNumber'] = $InfoData[$key]['FlightNumber'];
                $tickets[$i]['AirlineIataCode'] = $InfoData[$key]['AirlineIataCode'];
                $tickets[$i]['IsFlightCharter'] = $InfoData[$key]['IsFlightCharter'];
                $tickets[$i]['AircraftName'] = $InfoData[$key]['AircraftName'];
                $tickets[$i]['TotalFareAdult'] = ($InfoData[$key]['TotalFareAdult']) * 10;
                $tickets[$i]['TotalFareChild'] = ($InfoData[$key]['TotalFareChild']) * 10;
                $tickets[$i]['TotalFareInfant'] = ($InfoData[$key]['TotalFareInfant']) * 10;
                $tickets[$i]['CurrencyCode'] = $InfoData[$key]['CurrencyCode'];
                $tickets[$i]['BookingCode'] = $InfoData[$key]['BookingCode'];
                $tickets[$i]['CabinType'] = $InfoData[$key]['CabinType'];
                $tickets[$i]['FareBasisName'] = $InfoData[$key]['FareBasisName'];
                $tickets[$i]['AvailableSeatCount'] = $InfoData[$key]['AvailableSeatCount'];
                $tickets[$i]['RedirectionLink'] = $InfoData[$key]['RedirectionLink'];
//                error_log('flight Sort : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_sepehr361.txt');
            }

        }

        return $tickets;
    }

    public function cache($key, $sec, $value){
        require 'searchEngineApi/predis/src/Autoloader.php';
        Predis\Autoloader::register();
        $redis = new Predis\Client();
        $redis->setex($key, $sec, json_encode($value));
        $redis->disconnect();
    }


    private function getToken()
    {
        $url = "http://172.charter725.ir/APi/Login";
        $options = array(
            'Content-Type: application/json',
            'charset=utf-8'
        );
        $dataLogin['UserPassBase64'] = 'Basic' . ' ' ./*base64_encode('demo:demo' )*/ base64_encode('charteryesmoj:1qaSDF45rew' );
        $data = json_encode($dataLogin);
        $token = $this->curlExecution($url, $data, $options);
        return $token;

    }

    private function search($dataSearch)
    {
        $token = $this->getToken();
        $departureDate = functions::ConvertToMiladi($dataSearch['DepartureDate']);
        $url = "http://172.charter725.ir/APi/WebService/Available";
        $request = array(
            "date_flight" => $departureDate,
            "from_flight" => $this->mapIataCode($dataSearch['Origin']),
            "to_flight" => $this->mapIataCode($dataSearch['Destination'])
        );
        $data = json_encode($request);
        $options = array(
            'Content-Type: application/json',
            'charset=utf-8',
            'Authorization:' . $token['Data']['token_type'] . ' ' . $token['Data']['access_token']
        );

        $resultFlight = $this->curlExecution($url,$data,$options);

        return $resultFlight ;
    }

    public  function curlExecution($url, $data, $options = null)
    {
        $url = str_replace(" ", '', $url);
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($handle, CURLOPT_ENCODING, 'gzip');
        if (!empty($options)) {
            curl_setopt($handle, CURLOPT_HTTPHEADER, $options);
        }

        $result = curl_exec($handle);
        return json_decode($result, true);
    }

    public static function mapIataCode($Iata)
    {

        $Number = array('IKA', 'MAC');
        $Letter = array('THR', 'IMQ');

        if (in_array($Iata, $Number)) {
            $replaceIata = str_replace($Number, $Letter, $Iata);
        } else {
            $replaceIata = $Iata;

        }

        return $replaceIata;

    }

}

new cronJobsSepehr360();


