<?php
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
require './config/bootstrap.php';
require CONFIG_DIR . 'config.php';
//require LIBRARY_DIR . 'Load.php';
//require LIBRARY_DIR . 'Jalali.php';
spl_autoload_register(array('Load', 'autoload'));

class sepehr360
{

    public $FromDate = '';
    public $ToDate = '';
    public $difference;

    public function __construct()
    {

        $this->FromDate = $_GET['FromDate'];

        $this->ToDate = $_GET['ToDate'];

        // in massiro bbaz kon
        $this->getDataFlight();
    }

    public function getDataFlight()
    {
        require 'predis/src/Autoloader.php';
        Predis\Autoloader::register();

        $redis = new Predis\Client();


        $redisValue = $redis->get('flights');

        $value = json_decode($redisValue, true);


        $redis->disconnect();

        $InfoData = array();

        $Fdate = strtotime($this->FromDate);

        $Tdate = strtotime($this->ToDate);

        $airlineNotshowArray = array('B9', 'sepehran');


        foreach ($value as $data) {
            $depDate = substr($data['DepartureDateTime'], 0, 10);

            $depDate = strtotime($depDate);

            if ($depDate <= $Tdate && $depDate >= $Fdate && (!in_array($data['AirlineIataCode'], $airlineNotshowArray))) {
                $tickets['OriginIataCode'] = strtoupper($data['OriginIataCode']);
                $tickets['DestinationIataCode'] = strtoupper($data['DestinationIataCode']);
                $tickets['DepartureDateTime'] = $data['DepartureDateTime'];
                $tickets['ArrivalDateTime'] = $data['ArrivalDateTime'];
                $tickets['FlightDuration'] = $data['FlightDuration'];
                $tickets['FlightNumber'] = $data['FlightNumber'];/*str_replace($data['AirlineIataCode'],'',$data['FlightNumber']);*/
                $tickets['AirlineIataCode'] = $data['AirlineIataCode'];
                $tickets['IsFlightCharter'] = $data['IsFlightCharter'];
                $tickets['AircraftName'] = $data['AircraftName'];
                $FlightType = $data['IsFlightCharter'] == false ? 'system' : 'charter';

                /*        $AdtPrice = functions::setPriceChanges($data['AirlineIataCode'], $FlightType, $data['TotalFareAdult'], 'Local', strtolower($FlightType) == 'system' ? '' : 'public');
                        $ChdPrice = functions::setPriceChanges($data['AirlineIataCode'], $FlightType, $data['TotalFareChild'], 'Local', strtolower($FlightType) == 'system' ? '' : 'public');
                        $InfPrice = functions::setPriceChanges($data['AirlineIataCode'], $FlightType, $data['TotalFareInfant'], 'Local', strtolower($FlightType) == 'system' ? '' : 'public');


                        $AdtPrice = explode(':', $AdtPrice);
                        $ChdPrice = explode(':', $ChdPrice);
                        $InfPrice = explode(':', $InfPrice);

                        if ($FlightType == 'system') {
                            $tickets['TotalFareAdult'] = ($AdtPrice[2] == 'Yes') ? ($AdtPrice[1]/10) : ($AdtPrice[0]/10);
                            $tickets['TotalFareChild'] = ($ChdPrice[2] == 'Yes') ? ($ChdPrice[1]/10) : ($ChdPrice[0]/10);
                            $tickets['TotalFareInfant'] = ($InfPrice[2] == 'Yes') ? ($InfPrice[1]/10) : ($InfPrice[0]/10);
                        }*/

                $tickets['TotalFareAdult'] = ($data['TotalFareAdult']/10);
                $tickets['TotalFareChild'] = ($data['TotalFareChild']/10);
                $tickets['TotalFareInfant'] =($data['TotalFareInfant']/10);


                $tickets['CurrencyCode'] = $data['CurrencyCode'];
                $tickets['BookingCode'] = $data['BookingCode'];
                $tickets['CabinType'] = $data['CabinType'];
                $tickets['FareBasisName'] = strtoupper($data['FareBasisName']);
                $tickets['AvailableSeatCount'] = $data['AvailableSeatCount'];
                $tickets['RedirectionLink'] = str_replace('online.indobare.com', 'https://' . CLIENT_DOMAIN, $data['RedirectionLink']);
                $InfoData[] = $tickets;
            }


        }
        // $InfoData[] =$data;


        ob_start('ob_gzhandler');
        $dataJSon = json_encode($InfoData);
        $dataJSon = functions::clearJsonHiddenCharacters($dataJSon);
        echo $dataJSon;
    }

}

new sepehr360();


