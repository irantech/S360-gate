<?php

class newApiFlight extends clientAuth
{

    //region [Variable]
    protected $UniqueCode;
    protected $adult;
    protected $child;
    protected $infant;
    protected $origin;
    protected $destination;
    protected $departureDate;
    protected $arrivalDate;
    protected $foreign;
    protected $page;
    protected $count;
    protected $time;
    protected $tickets;
    protected $MultiWay;
    protected $softWareLang;
    protected $InfoSearch;
    protected $originName;
    protected $destinationName;
    protected $typeSearch;
    protected $isInternal;
    protected $privateSearch;
    protected $prices;
    protected $date_now;
    protected $day;
    protected $multi_destination;
    private $IsLogin;
    private $CounterId;
    private $getCounterTypeId;
    private $username;
    private $apiAddress;


    //endregion

    //region [__construct]

    /**
     * @var array
     */

    public function __construct($url = null) {

        parent::__construct();
        $this->init($url);
    }
    //endregion

    //region [init]
    public function init($url = null) {

        $InfoSources = $this->ticketFlightAuth();

        if (!empty($InfoSources)):
            $this->username = $InfoSources['Username'];
        endif;

        $this->apiAddress = functions::UrlSource();

//        $this->apiAddress = 'https://safar360.com/Core/V-1/';

        $this->IsLogin = Session::IsLogin();
        $this->CounterId = Session::getUserId();
        $this->getCounterTypeId = ($this->IsLogin ? Session::getCounterTypeId() : '5');
        $this->softWareLang = (SOFTWARE_LANG == 'fa');
        $this->multi_destination = is_array($url);
        $this->InfoSearch = functions::configDataRoute(!empty($url) ? $url : $_SERVER['REQUEST_URI']);

        $this->origin = ($this->multi_destination) ? $this->InfoSearch['info_city'][0]['Origin'] : $this->InfoSearch['origin'];
        $this->destination = ($this->multi_destination) ? $this->InfoSearch['info_city'][0]['Destination'] : $this->InfoSearch['destination'];

        $this->departureDate = functions::forceDateSearchToJalali($this->InfoSearch['departureDate']);
        $this->arrivalDate = functions::forceDateSearchToJalali($this->InfoSearch['arrivalDate']);
        $this->adult = $this->InfoSearch['adult'];
        $this->child = $this->InfoSearch['child'];
        $this->infant = $this->InfoSearch['infant'];
        $this->typeSearch = $this->InfoSearch['typeSearch'];
        $this->privateSearch = isset($this->InfoSearch['privateSearch']) ? $this->InfoSearch['privateSearch'] : '';
        $this->MultiWay = $this->InfoSearch['MultiWay'];
        $this->InfoSearch['software_lang'] = SOFTWARE_LANG == 'ru' ? 'en' : SOFTWARE_LANG;
        $this->InfoSearch['is_currency'] = ISCURRENCY;
        $this->isInternal = $this->InfoSearch['isInternal'];




        if (($this->typeSearch == 'searchPackage' && $this->isInternal) || in_array($this->typeSearch, ['search-flight', 'searchFlight'])) {

            $originCity = functions::CityInternal($this->origin);



            $destinationCity = functions::CityInternal($this->destination);

            if ($this->typeSearch == 'search-flight') {
                $this->InfoSearch['name_departure'] = ($this->softWareLang ? $originCity['Departure_City'] : $originCity['Departure_CityEn']);
                $this->InfoSearch['name_arrival'] = ($this->softWareLang ? $destinationCity['Departure_City'] : $destinationCity['Departure_CityEn']);
                $this->originName = $this->InfoSearch['name_departure'];
                $this->destinationName = $this->InfoSearch['name_arrival'];
            } else {
                $this->InfoSearch['NameDeparture'] = ($this->softWareLang ? $originCity['Departure_City'] : $originCity['Departure_CityEn']);
                $this->InfoSearch['NameArrival'] = ($this->softWareLang ? $destinationCity['Departure_City'] : $destinationCity['Departure_CityEn']);
                $this->originName = $this->InfoSearch['NameDeparture'];
                $this->destinationName = $this->InfoSearch['NameArrival'];
            }


        } else {
            $originCity = functions::NameCityForeign($this->origin);
            $destinationCity = functions::NameCityForeign($this->destination);

            $this->InfoSearch['name_departure'] = ($this->softWareLang ? $originCity['DepartureCityFa'] : $originCity['DepartureCityEn']);
            $this->InfoSearch['airport_departure'] = ($this->softWareLang ? $originCity['AirportFa'] : $originCity['AirportEn']);
            $this->InfoSearch['country_departure'] = ($this->softWareLang ? $originCity['CountryFa'] : $originCity['CountryEn']);
            $this->InfoSearch['name_arrival'] = ($this->softWareLang ? $destinationCity['DepartureCityFa'] : $destinationCity['DepartureCityEn']);
            $this->InfoSearch['airport_arrival'] = ($this->softWareLang ? $destinationCity['AirportFa'] : $destinationCity['AirportEn']);
            $this->InfoSearch['country_arrival'] = ($this->softWareLang ? $destinationCity['CountryFa'] : $destinationCity['CountryEn']);
            $this->InfoSearch['software_lang_check'] = ($this->InfoSearch['departureDate'] > 1450 && SOFTWARE_LANG == 'fa') ? false : $this->softWareLang;
            $this->InfoSearch['current_currency'] = Session::getCurrency();
            $this->originName = $this->InfoSearch['name_departure'];
            $this->destinationName = $this->InfoSearch['name_arrival'];
            $this->InfoSearch['NameDeparture'] = $this->InfoSearch['name_departure'];
            $this->InfoSearch['NameArrival'] = $this->InfoSearch['name_arrival'];
        }

    }
    //endregion

    //region [initialInformation]
    public function initialInformation() {
        return json_encode($this->InfoSearch);
    }
    //endregion

    //region [dateRout]
    public function dateRout() {

        $initialInformation['dataSearch'] = $this->isInternal ? $this->InfoSearch : $this->infoSearchFlight($this->InfoSearch);
        $initialInformation['dataSearch']['DateFlightWithName'] = SOFTWARE_LANG == 'fa' ? functions::DateWithName($this->InfoSearch['departureDate']) : functions::DateWithName($this->InfoSearch['departure_date_en']);
        $initialInformation['dataSearch']['DateFlightReturnWithName'] = ($this->InfoSearch['MultiWay']=='TwoWay') ?SOFTWARE_LANG == 'fa' ? functions::DateWithName($this->InfoSearch['arrivalDate']) : functions::DateWithName($this->InfoSearch['arrival_date_en']) : null;
        $initialInformation['MultiWay'] = $this->InfoSearch['MultiWay'];
        $initialInformation['Advertises'] = (array)functions::getConfigContentByTitle($this->isInternal ? 'local_flight_search_advertise' : 'external_flight_search_advertise');
        $initialInformation['next'] = functions::DateNext($this->InfoSearch['departureDate']);
        $initialInformation['prev'] = functions::DatePrev($this->InfoSearch['departureDate']);

        // Add classFlight to dataSearch only if it exists in URL
        if(isset($this->InfoSearch['classFlight']) && !empty($this->InfoSearch['classFlight'])) {
            $initialInformation['dataSearch']['classFlight'] = $this->InfoSearch['classFlight'];
        }

        return json_encode($initialInformation);
    }
    //endregion

    #region [UniqueCode]

    /**
     * @param $info_search
     * @return mixed
     * @author alizade
     * @date 12/20/2022
     * @time 9:57 AM
     */
    private function infoSearchFlight($info_search) {

        $airPort = $this->airportPortalList();
        $data_search = $info_search;
        if (isset($info_search['info_city'])) {
            foreach ($info_search['info_city'] as $key => $info) {
                $data_search['info'][$key]['origin'] = $info['Origin'];
                $data_search['info'][$key]['destination'] = $info['Destination'];
                $data_search['info'][$key]['departureDate'] = $info['DepartureDate'];
                $data_search['info'][$key]['departure_date_en'] = functions::forceDateSearchToMiladi($info_search['departureDate']);
                $data_search['info'][$key]['name_departure'] = $airPort[$info['Origin']]['DepartureCity' . ucfirst($info_search['software_lang'])];
                $data_search['info'][$key]['airport_departure'] = $airPort[$info['Origin']]['Airport' . ucfirst($info_search['software_lang'])];
                $data_search['info'][$key]['country_departure'] = $airPort[$info['Origin']]['Country' . ucfirst($info_search['software_lang'])];
                $data_search['info'][$key]['name_arrival'] = $airPort[$info['Destination']]['DepartureCity' . ucfirst($info_search['software_lang'])];
                $data_search['info'][$key]['airport_arrival'] = $airPort[$info['Destination']]['Airport' . ucfirst($info_search['software_lang'])];
                $data_search['info'][$key]['country_arrival'] = $airPort[$info['Destination']]['Country' . ucfirst($info_search['software_lang'])];
                if(SOFTWARE_LANG == 'en') {
                    $data_search['info'][$key]['count_path'] = functions::ConvertNumberToAlphabet($key + 1, 'App') . functions::Xmlinformation("Route") ;
                }else {
                    $data_search['info'][$key]['count_path'] = functions::Xmlinformation("Route") . functions::ConvertNumberToAlphabet($key + 1, 'App');
                }
            }
        } else {
            $data_search['info'][0]['origin'] = $info_search['origin'];
            $data_search['info'][0]['destination'] = $info_search['destination'];
            $data_search['info'][0]['departureDate'] = $info_search['departureDate'];
            $data_search['info'][0]['departure_date_en'] = functions::forceDateSearchToMiladi($info_search['departureDate']);
            $data_search['info'][0]['arrivalDate'] = $info_search['arrivalDate'];
            $data_search['info'][0]['arrival_date_en'] = functions::forceDateSearchToMiladi($info_search['arrivalDate']);
            $data_search['info'][0]['name_departure'] = $airPort[$info_search['origin']]['DepartureCity' . ucfirst($info_search['software_lang'])];
            $data_search['info'][0]['airport_departure'] = $airPort[$info_search['origin']]['Airport' . ucfirst($info_search['software_lang'])];
            $data_search['info'][0]['country_departure'] = $airPort[$info_search['origin']]['Country' . ucfirst($info_search['software_lang'])];
            $data_search['info'][0]['name_arrival'] = $airPort[$info_search['destination']]['DepartureCity' . ucfirst($info_search['software_lang'])];
            $data_search['info'][0]['airport_arrival'] = $airPort[$info_search['destination']]['Airport' . ucfirst($info_search['software_lang'])];
            $data_search['info'][0]['country_arrival'] = $airPort[$info_search['destination']]['Country' . ucfirst($info_search['software_lang'])];
        }

        unset($info_search['info_city']);

        return $data_search;

    }
    #endregion

    #region [findTicketInSearch]

    private function airportPortalList() {
        $airports = $this->getController('routeFlight')->getInfoAirportPortal();
        $array_airports = array();
        foreach ($airports as $airport) {
            $array_airports[$airport['DepartureCode']] = $airport;
        }
        return $array_airports;

    }
    #endregion

    #region [getTicketList]

    public function getTicketList() {


        /** @var airportModel $airportModel */
        $airportModel = $this->getModel('airportModel');
        $originCheck = $airportModel->get()->where('DepartureCode', $this->origin)->where('IsInternal', 1)->find();
        $destinationCheck = $airportModel->get()->where('DepartureCode', $this->destination)->where('IsInternal', 1)->find();
        if (!$originCheck || !$destinationCheck) {
            return functions::toJson(array());
        }

        if ($originCheck['DepartureCode'] == 'IKA' || $destinationCheck['DepartureCode'] == 'IKA') {
            return functions::toJson(array());
        }

        $dataSearch = json_decode($this->findTicketInSearch(), true);

        error_log('first  getTicketInternal  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');
        $list_config_airline = $this->listConfigAirline(true);
        $price_change_list = $this->flightPriceChangeList('local');
        $discount_list = $this->discountList();
        $airlines_name = $this->airlineList();
        $airports = $this->airportPortalList();
        $translateVariable = $this->dataTranslate();
        $info_currency = functions::infoCurrencyBySessionCode(Session::getCurrency());


        $data_param_set_change_price['list_config_airline'] = $list_config_airline;
        $data_param_set_change_price['price_change_list'] = $price_change_list;
        $data_param_set_change_price['discount_list'] = $discount_list;
        $data_param_set_change_price['airlines_name'] = $airlines_name;
        $data_param_set_change_price['info_currency'] = $info_currency;
        $data_param_set_change_price['data_translate'] = $translateVariable;

        $BusinessType = $translateVariable['business_type'];
        $EconomicsType = $translateVariable['economics_type'];
        $systemFlight = $translateVariable['system_flight'];
        $charterFlight = $translateVariable['charter_flight'];
        $Morning = $translateVariable['morning'];
        $Day = $translateVariable['day'];
        $Evening = $translateVariable['evening'];
        $Night = $translateVariable['night'];
        $Chair = $translateVariable['Chair'];
        //return flights in dept And return


        if (isset($dataSearch['return']['Flights']) && $dataSearch['return']['Flights'] != '' && !empty($dataSearch['dept']) && $this->arrivalDate != "") {
            $this->MultiWay = 'TwoWay';
            //در صورتیکه جستجو دوطرفه بود و پرواز برگشت نداشت، پروازهای رفت هم خالی میکنیم تا نمایش ندهد
            if (empty($dataSearch['return']['Flights'])) {
                $dataSearch['dept'] = array();
                $dataSearch['return'] = array();
            }

        } else {
            $this->MultiWay = 'OneWay';
        }

        $LongTime = functions::LongTimeFlightHours($this->origin, $this->destination);


        $airlines = array();
        $this->tickets['timeFilter']['Morning']['name'] = 'early';
        $this->tickets['timeFilter']['Morning']['time'] = $Morning;
        $this->tickets['timeFilter']['Morning']['value'] = '0-8';
        $this->tickets['timeFilter']['Day']['name'] = 'morning';
        $this->tickets['timeFilter']['Day']['time'] = $Day;
        $this->tickets['timeFilter']['Day']['value'] = '8-12';
        $this->tickets['timeFilter']['Evening']['name'] = 'afternoon';
        $this->tickets['timeFilter']['Evening']['time'] = $Evening;
        $this->tickets['timeFilter']['Evening']['value'] = '12-18';
        $this->tickets['timeFilter']['Night']['name'] = 'night';
        $this->tickets['timeFilter']['Night']['time'] = $Night;
        $this->tickets['timeFilter']['Night']['value'] = '18-24';

        $this->tickets['typeFlightFilter']['system']['name'] = $systemFlight;
        $this->tickets['typeFlightFilter']['system']['EnName'] = 'system';
        $this->tickets['typeFlightFilter']['charter']['name'] = $charterFlight;
        $this->tickets['typeFlightFilter']['charter']['EnName'] = 'charter';


        $this->tickets['seatClassFilter']['economy']['name_fa'] = $EconomicsType;
        $this->tickets['seatClassFilter']['economy']['name_en'] = 'economy';
        $this->tickets['seatClassFilter']['premium_economy']['name_fa'] = functions::Xmlinformation("premiumEconomy")->__toString();
        $this->tickets['seatClassFilter']['premium_economy']['name_en'] = 'premium_economy';
        $this->tickets['seatClassFilter']['business']['name_fa'] = $BusinessType;
        $this->tickets['seatClassFilter']['business']['name_en'] = 'business';

        $this->tickets['NameDeparture'] = $this->originName;
        $this->tickets['NameArrival'] = $this->destinationName;

        foreach ($dataSearch as $direction => $arrayFlight) {
            error_log('next go to DataAjaxSearch  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search_foreach.txt');
            $i = 0;
            $count = count($dataSearch[$direction]['Flights']);
            $newarray = $arrayFlight['Flights'];
            $arrayAirlines[$direction] = array();

            $cityNameDeparture = ($direction == 'dept') ? $this->originName : $this->destinationName;
            $cityNameArrival = ($direction == 'dept') ? $this->destinationName : $this->originName;

            for ($key = 0; $key < $count; $key++) {


                $ArrivalTime = functions::CalculateArrivalTime(($LongTime['Hour'] . ':' . $LongTime['Minutes'] . ':00'), $newarray[$key]['OutputRoutes'][0]['DepartureTime']);
                $is_internal = $newarray[$key]['IsInternal'];
                $type_zone = 'Local';
                $type_flight = (($newarray[$key]['SeatClass'] == 'C' || $newarray[$key]['SeatClass'] == 'B') ? 'business' : 'economy');
                $source_id = $newarray[$key]['SourceId'];
                $airlineIata = $newarray[$key]['OutputRoutes'][0]['Airline']['Code'];


                $data_change_price = array(
                    'airlineIata' => $airlineIata,
                    'FlightType' => strtolower($newarray[$key]['FlightType']),
                    'typeZone' => $type_zone,
                    'typeFlight' => $type_flight,
                    'sourceId' => $source_id,
                    'isInternal' => $is_internal,
                    'price' => array(
                        'adult' => array(
                            'TotalPrice' => $newarray[$key]['PassengerDatas'][0]['TotalPrice'],
                            'BasePrice' => $newarray[$key]['PassengerDatas'][0]['BasePrice'],
                        ),
                        'child' => array(
                            'TotalPrice' => isset($newarray[$key]['PassengerDatas'][1]['TotalPrice']) ? $newarray[$key]['PassengerDatas'][1]['TotalPrice'] : 0,
                            'BasePrice' => isset($newarray[$key]['PassengerDatas'][1]['BasePrice']) ? $newarray[$key]['PassengerDatas'][1]['BasePrice'] : 0,
                        ),
                        'infant' => array(
                            'TotalPrice' => isset($newarray[$key]['PassengerDatas'][2]['TotalPrice']) ? $newarray[$key]['PassengerDatas'][2]['TotalPrice'] : 0,
                            'BasePrice' => isset($newarray[$key]['PassengerDatas'][2]['BasePrice']) ? $newarray[$key]['PassengerDatas'][2]['BasePrice'] : 0,
                        ),
                    )
                );

                $priceChangeCalculate = $this->getController('priceChanges')->setPriceChangesFlight($data_change_price, $data_param_set_change_price);


                //adult
                $Price['Adult']['TotalPrice'] = $this->softWareLang != 'fa' ? functions::numberFormat($priceChangeCalculate['adult']['TotalPrice']) : round($priceChangeCalculate['adult']['TotalPrice']);
                $Price['Adult']['BasePrice'] = $this->softWareLang != 'fa' ? functions::numberFormat($priceChangeCalculate['adult']['BasePrice']) : round($priceChangeCalculate['adult']['BasePrice']);
                $Price['Adult']['TotalWithDiscount'] = $this->softWareLang != 'fa' ? functions::numberFormat($priceChangeCalculate['adult']['TotalPriceWithDiscount']) : round($priceChangeCalculate['adult']['TotalPriceWithDiscount']);
                $Price['Adult']['hasDiscount'] = $priceChangeCalculate['adult']['has_discount'];
                $Price['Adult']['typeCurrency'] = $priceChangeCalculate['adult']['type_currency'];
                $Price['Adult']['priceWithOutCurrency'] = $priceChangeCalculate['adult']['price_with_out_currency'];
                $Price['Adult']['priceDiscountWithOutCurrency'] = $priceChangeCalculate['adult']['price_discount_with_out_currency'];
                //child
                $Price['child']['TotalPrice'] = $this->softWareLang != 'fa' ? functions::numberFormat($priceChangeCalculate['child']['TotalPrice']) : round($priceChangeCalculate['child']['TotalPrice']);
                $Price['child']['BasePrice'] = $this->softWareLang != 'fa' ? functions::numberFormat($priceChangeCalculate['child']['BasePrice']) : round($priceChangeCalculate['child']['BasePrice']);
                $Price['child']['TotalWithDiscount'] = $this->softWareLang != 'fa' ? functions::numberFormat($priceChangeCalculate['child']['TotalPriceWithDiscount']) : round($priceChangeCalculate['child']['TotalPriceWithDiscount']);
                $Price['child']['hasDiscount'] = $priceChangeCalculate['child']['has_discount'];
                $Price['child']['typeCurrency'] = $priceChangeCalculate['child']['type_currency'];
                $Price['child']['priceWithOutCurrency'] = $priceChangeCalculate['child']['price_with_out_currency'];
                $Price['child']['priceDiscountWithOutCurrency'] = $priceChangeCalculate['child']['price_discount_with_out_currency'];

                //infant
                $Price['infant']['TotalPrice'] = $this->softWareLang != 'fa' ? functions::numberFormat($priceChangeCalculate['infant']['TotalPrice']) : round($priceChangeCalculate['infant']['TotalPrice']);
                $Price['infant']['BasePrice'] = $this->softWareLang != 'fa' ? functions::numberFormat($priceChangeCalculate['infant']['BasePrice']) : round($priceChangeCalculate['infant']['BasePrice']);
                $Price['infant']['TotalWithDiscount'] = $this->softWareLang != 'fa' ? functions::numberFormat($priceChangeCalculate['infant']['TotalPriceWithDiscount']) : round($priceChangeCalculate['infant']['TotalPriceWithDiscount']);
                $Price['infant']['hasDiscount'] = $priceChangeCalculate['infant']['has_discount'];
                $Price['infant']['typeCurrency'] = $priceChangeCalculate['infant']['type_currency'];
                $Price['infant']['priceWithOutCurrency'] = $priceChangeCalculate['infant']['price_with_out_currency'];
                $Price['infant']['priceDiscountWithOutCurrency'] = $priceChangeCalculate['infant']['price_discount_with_out_currency'];

                if (!in_array($airlineIata, $arrayAirlines[$direction])) {
                    $airlines[] = $airlineIata;
                }

                foreach ($airlines as $airline) {
                    if ($airline == $airlineIata && round($Price['Adult']['TotalPrice']) > 0) {
                        $price[$airlineIata][] = ($priceChangeCalculate['hasDiscount'] == 'No') ? $priceChangeCalculate['adult']['TotalPrice'] : $priceChangeCalculate['adult']['TotalPriceWithDiscount'];
                        $price_currency_min = min($price[$airlineIata]);
                        $this->tickets[$direction]['MinPriceAirline'][$airlineIata]['EnName'] = strtoupper($airlineIata);
                        $this->tickets[$direction]['MinPriceAirline'][$airlineIata]['price'] = functions::numberFormat($price_currency_min);
                        $this->tickets[$direction]['MinPriceAirline'][$airlineIata]['name'] = functions::AirlineName($airlineIata);
                    }
                }
                unset($price[$airlineIata]);
                if ($Price['Adult']['TotalPrice'] > 0) {
                    if ($priceChangeCalculate['hasDiscount'] == 'No') {
                        $price_range[$direction][] = $Price['Adult']['TotalPrice'];
                    } else {
                        $price_range[$direction][] = $Price['Adult']['TotalWithDiscount'];
                    }
                }


                $departureDate = (SOFTWARE_LANG == 'fa') ? functions::convertDateFlight($newarray[$key]['OutputRoutes'][0]['DepartureDate']) : $newarray[$key]['OutputRoutes'][0]['DepartureDate'];


                $this->tickets[$direction]['resultFlight'][$i]['FlightNo'] = $newarray[$key]['OutputRoutes'][0]['FlightNo'];
                $this->tickets[$direction]['resultFlight'][$i]['FlightNumberFilter'] = preg_replace("/[^0-9]/", '', $newarray[$key]['OutputRoutes'][0]['FlightNo']);
                $this->tickets[$direction]['resultFlight'][$i]['Airline'] = $newarray[$key]['OutputRoutes'][0]['Airline']['Code'];
                $this->tickets[$direction]['resultFlight'][$i]['AirlineName'] = functions::AirlineName($newarray[$key]['OutputRoutes'][0]['Airline']['Code']);
                $this->tickets[$direction]['resultFlight'][$i]['DepartureDate'] = str_replace('/', '-', $departureDate);
                $this->tickets[$direction]['resultFlight'][$i]['DepartureDateWithNameDay'] = str_replace('/', '-', $departureDate);
                $this->tickets[$direction]['resultFlight'][$i]['SourceId'] = $newarray[$key]['SourceId'];
                $this->tickets[$direction]['resultFlight'][$i]['ArrivalDate'] = str_replace('/', '-', functions::Date_arrival($this->origin, $this->destination, $newarray[$key]['OutputRoutes'][0]['DepartureTime'], $newarray[$key]['OutputRoutes'][0]['DepartureDate']));
                $this->tickets[$direction]['resultFlight'][$i]['DepartureParentRegionName'] = functions::DateWithName($departureDate);
                $this->tickets[$direction]['resultFlight'][$i]['DepartureCode'] = strtoupper($newarray[$key]['OutputRoutes'][0]['Departure']['Code']);
                $this->tickets[$direction]['resultFlight'][$i]['DepartureCity'] = $cityNameDeparture;
                $this->tickets[$direction]['resultFlight'][$i]['ArrivalParentRegionName'] = $newarray[$key]['OutputRoutes'][0]['Arrival']['ParentRegionName'];
                $this->tickets[$direction]['resultFlight'][$i]['ArrivalCode'] = strtoupper($newarray[$key]['OutputRoutes'][0]['Arrival']['Code']);
                $this->tickets[$direction]['resultFlight'][$i]['ArrivalCity'] = $cityNameArrival;
                $this->tickets[$direction]['resultFlight'][$i]['Aircraft'] = $newarray[$key]['OutputRoutes'][0]['Aircraft']['Manufacturer'];
                $this->tickets[$direction]['resultFlight'][$i]['FlightType'] = (strtolower($newarray[$key]['FlightType']) == 'system') ? $systemFlight : $charterFlight;
                $this->tickets[$direction]['resultFlight'][$i]['FlightType_li'] = (strtolower($newarray[$key]['FlightType']) == 'system') ? 'system' : 'charter';
                $this->tickets[$direction]['resultFlight'][$i]['DepartureTime'] = substr($newarray[$key]['OutputRoutes'][0]['DepartureTime'], 0, 5);
                $this->tickets[$direction]['resultFlight'][$i]['ArrivalTime'] = substr($ArrivalTime['time'], 0, 5);
                $this->tickets[$direction]['resultFlight'][$i]['SeatClass'] = ($type_flight == 'business') ? $BusinessType : $EconomicsType;
                $this->tickets[$direction]['resultFlight'][$i]['SeatClassEn'] = $type_flight;
                $this->tickets[$direction]['resultFlight'][$i]['CabinType'] = $newarray[$key]['OutputRoutes'][0]['CabinType'];
                $this->tickets[$direction]['resultFlight'][$i]['FlightTypeKidding'] = (strpos($newarray[$key]['Description'], 'اتباع') !== false) ? functions::titleFlightTypeKidding(strtolower($newarray[$key]['FlightType'])) : null;
                //adt price
                $this->tickets[$direction]['resultFlight'][$i]['AdtPrice'] = $Price['Adult']['TotalPrice'];
                $this->tickets[$direction]['resultFlight'][$i]['AdtFare'] = $Price['Adult']['BasePrice'];
                $this->tickets[$direction]['resultFlight'][$i]['AdtWithDiscount'] = $Price['Adult']['TotalWithDiscount'];
                $this->tickets[$direction]['resultFlight'][$i]['hasDiscount'] = $Price['Adult']['hasDiscount'];
                $this->tickets[$direction]['resultFlight'][$i]['typeCurrency'] = $Price['Adult']['typeCurrency'];
                $this->tickets[$direction]['resultFlight'][$i]['priceWithOutCurrency'] = $Price['Adult']['priceWithOutCurrency'];
                $this->tickets[$direction]['resultFlight'][$i]['priceDiscountWithOutCurrency'] = $Price['Adult']['priceDiscountWithOutCurrency'];
                //chd price
                $this->tickets[$direction]['resultFlight'][$i]['chdPrice'] = $Price['child']['TotalPrice'];
                $this->tickets[$direction]['resultFlight'][$i]['chdFare'] = $Price['child']['BasePrice'];
                $this->tickets[$direction]['resultFlight'][$i]['chdWithDiscount'] = $Price['child']['TotalWithDiscount'];
                $this->tickets[$direction]['resultFlight'][$i]['hasDiscount'] = $Price['child']['hasDiscount'];
                $this->tickets[$direction]['resultFlight'][$i]['typeCurrency'] = $Price['child']['typeCurrency'];
                //inf price
                $this->tickets[$direction]['resultFlight'][$i]['infantPrice'] = $Price['infant']['TotalPrice'];
                $this->tickets[$direction]['resultFlight'][$i]['infantFare'] = $Price['infant']['BasePrice'];
                $this->tickets[$direction]['resultFlight'][$i]['infantWithDiscount'] = $Price['infant']['TotalWithDiscount'];
                $this->tickets[$direction]['resultFlight'][$i]['hasDiscount'] = $Price['infant']['hasDiscount'];
                $this->tickets[$direction]['resultFlight'][$i]['typeCurrency'] = $Price['infant']['typeCurrency'];

                $this->tickets[$direction]['resultFlight'][$i]['Baggage'] = '20';

                $this->tickets[$direction]['resultFlight'][$i]['Capacity'] = ($newarray[$key]['SourceId'] != '1' && CLIENT_ID != "223") ? $newarray[$key]['Capacity'] . $Chair : '';
                $this->tickets[$direction]['resultFlight'][$i]['Supplier'] = $newarray[$key]['Supplier']['Name'];
                $this->tickets[$direction]['resultFlight'][$i]['UserId'] = !empty($newarray[$key]['UserId']) ? $newarray[$key]['UserId'] : '';
                $this->tickets[$direction]['resultFlight'][$i]['UserName'] = !empty($newarray[$key]['UserName']) ? $newarray[$key]['UserName'] : '';
                $this->tickets[$direction]['resultFlight'][$i]['SourceId'] = $source_id;
                $this->tickets[$direction]['resultFlight'][$i]['SourceName'] = !empty($newarray[$key]['SourceName']) ? $newarray[$key]['SourceName'] : '';
                $this->tickets[$direction]['resultFlight'][$i]['UniqueCode'] = $newarray[$key]['Code'];
                $this->tickets[$direction]['resultFlight'][$i]['IsInternal'] = $newarray[$key]['IsInternal'];
                $this->tickets[$direction]['resultFlight'][$i]['Reservable'] = $newarray[$key]['Reservable'];
                $this->tickets[$direction]['resultFlight'][$i]['FlightID'] = $newarray[$key]['FlightID'];
                $this->tickets[$direction]['resultFlight'][$i]['ReturnFlightID'] = $newarray[$key]['ReturnFlightID'];
                $this->tickets[$direction]['resultFlight'][$i]['LongTime'] = $LongTime;
                $this->tickets[$direction]['resultFlight'][$i]['Lang'] = $this->softWareLang;
                $this->tickets[$direction]['resultFlight'][$i]['DirectionFlight'] = $direction;
                $this->tickets[$direction]['resultFlight'][$i]['is_complete'] = ($newarray[$key]['Capacity'] <= 0 && $source_id != '14') ? true : false;


                $i++;
//                error_log('next go to DataAjaxSearch  : ' . date('Y/m/d H:i:s') . '<hr/>' . " \n", 3, LOGS_DIR . 'log_Request_send_search_foreach.txt');


            }

            $price_currency_min = min($price_range[$direction]);
            $price_currency_max = max($price_range[$direction]);
            $this->tickets[$direction]['minPrice'] = $price_currency_min;
            $this->tickets[$direction]['maxPrice'] = $price_currency_max;


            $this->tickets['beforeFilter'] = $this->tickets[$direction]['resultFlight'];


            $this->tickets[$direction]['resultFlight'] = $this->getController('resultLocal')->deleteInactiveAirline($this->tickets[$direction]['resultFlight'], 'isInternal', $data_param_set_change_price);
            $sort = array();
            $sort_zero = array();
            foreach ($this->tickets[$direction]['resultFlight'] as $keySort => $arraySort) {
                if (round($arraySort['AdtPrice']) > 0) {
                    $sort[$direction][] = $arraySort;
                } else {
                    $sort_zero[$direction][] = $arraySort;
                }
            }

            $main_sort = array();
            foreach ($sort[$direction] as $key_main_sort => $item_sort) {
                $main_sort['AdtPrice'][] = $item_sort['AdtPrice'];
            }


            if (!empty($main_sort)) {
                array_multisort($main_sort['AdtPrice'], SORT_ASC, SORT_NUMERIC, $sort[$direction]);
            }


            if (!empty($sort[$direction]) && !empty($sort_zero[$direction])) {
                $this->tickets[$direction]['resultFlight'] = array_merge($sort[$direction], $sort_zero[$direction]);
            } elseif (empty($sort[$direction]) && !empty($sort_zero[$direction])) {
                $this->tickets[$direction]['resultFlight'] = $sort_zero[$direction];
            } else {
                $this->tickets[$direction]['resultFlight'] = $sort[$direction];
            }

        }


        return json_encode($this->tickets);

    }
    #endregion

    #region [dataSearch]

    public function findTicketInSearch($type = null) {
        $searchTicket = array();
        if ($type == '') {
            $searchTicket['dept'] = $this->dataSearch('dept');

            if (!empty($this->arrivalDate)) {

                if ($this->isInternal) {
                    $searchTicket['return'] = $this->dataSearch('return');
                    if(CLIENT_ID ==  '359'){
                        $searchTicket['twoWay'] = $this->dataSearch('twoWay');
                    }

                } else {
                    $searchTicket['twoWay'] = $this->dataSearch('twoWay');
                }
            }
        } elseif ($type == 'twoWay') {
            $searchTicket['twoWay'] = $this->dataSearch('twoWay');
        }


        return json_encode($searchTicket);


    }
    #endregion

    #region [arrayFilterByValue]

    /**
     * @param $direction
     * @return mixed
     */
    public function dataSearch($direction) {


        error_log('first  dataSearch  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');


        $this->UniqueCode = $this->UniqueCodeOfSourceFive($this->username);



        $url = $this->apiAddress . "Flight/Search/" . $this->UniqueCode;
        $d['Adult'] = (is_numeric($this->adult) && !empty($this->adult) && $this->adult > 0) ? $this->adult : '1';
        $d['Child'] = (is_numeric($this->child) && !empty($this->child) && $this->child > 0) ? $this->child : '0';
        $d['Infant'] = (is_numeric($this->infant) && !empty($this->infant) && $this->infant > 0) ? $this->infant : '0';
        $d['UserName'] = $this->username;
        if ($this->privateSearch) {
            $d['privateSearch'] = $this->privateSearch;
        }

        if ($this->multi_destination) {
            $d['info_city'] = $this->InfoSearch['info_city'];
            $d['is_multi_route'] = true;
        } else {
            $d['Origin'] = ($direction != 'return') ? $this->origin : $this->destination;
            $d['Destination'] = ($direction != 'return') ? $this->destination : $this->origin;
            $d['DepartureDate'] = ($direction != 'return') ? $this->departureDate : $this->arrivalDate;
            $d['ArrivalDate'] = ($direction == 'twoWay') ? $this->arrivalDate : '';
        }
        if(functions::isTestServer()){

            $airportModel = $this->getModel('airportModel');
            $originCheck = $airportModel->get()->where('DepartureCode', $this->origin)->where('IsInternal','1')->find();
            $destinationCheck = $airportModel->get()->where('DepartureCode', $this->destination)->where('IsInternal','1')->find();
            $d['IsInternal'] = ($originCheck && $destinationCheck && ($direction == 'twoWay') && ($this->typeSearch=='international')) || ($this->typeSearch == 'searchFlight' || $this->typeSearch == 'search-flight' || $this->typeSearch == 'domestic-flight' || ($this->typeSearch == 'searchPackage' && $this->isInternal)) ? true : false;
        }
        else{
            $d['IsInternal'] = ($this->typeSearch == 'searchFlight' || $this->typeSearch == 'search-flight' ||
                $this->typeSearch == 'domestic-flight' || ($this->typeSearch == 'searchPackage' && $this->isInternal)) ? true : false;
        }

        if($this->typeSearch == 'searchPackage') {
            $d['getPackage']  = true;
//            $d['privateSearch'] = true;
        }

        $d['subAgencyId'] = '';
        $agencyInfo = $this->getController('agency')->subAgencyInfo();
        if ($agencyInfo != null && !empty($agencyInfo['sepehr_username']) && !empty($agencyInfo['sepehr_password'])) {
            $d['subAgencyId'] = $agencyInfo['id'];
        }


        $JsonArray = json_encode($d);

        error_log('start Search in GDS ==> ' . date('Y/m/d H:i:s') . " \n", 3, dirname(dirname(dirname(__FILE__))) . '/Core/assets/logFile/flight_international/' . $this->UniqueCode . '.txt');
        error_log('first  start Search in  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');



        functions::insertLog('url is=> ' . $url . '   give time send request With Code =>' . $this->UniqueCode . ' && Origin:' . $d['Origin'] . ' &&destination:' . $d['Destination'] . 'with data request' . $JsonArray . '\n', 'newApiFlight');

        $result = functions::curlExecution($url, $JsonArray, 'yes');
        
        error_log('End Search in  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');

        error_log('End Receive Data Search in GDS  ==> ' . date('Y/m/d H:i:s') . " \n", 3, dirname(dirname(dirname(__FILE__))) . '/Core/assets/logFile/flight_international/' . $this->UniqueCode . '.txt');

        functions::insertLog('result is =>' . json_encode($result, 256 | 64) . '\n', 'newApiFlight');
        functions::insertLog('*******************************' . '\n', 'newApiFlight');

        return $result;
    }
    #endregion

    //region [checkTypeFlightAirline]

    public function UniqueCodeOfSourceFive($userName) {

        error_log('first UniqueCodeOfSourceFive : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');
        $url = $this->apiAddress . "Flight/GetCode/" . $userName;
        $JsonArray = array();

        $tickets = functions::curlExecution($url, $JsonArray, 'yes');

        error_log('End UniqueCodeOfSourceFive : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');
        return $tickets['Result']['Value'];


    }
    //endregion

    //region [setPriceChanges]

    /**
     * @param $rec
     * @param $type
     * @param $airline
     * @return mixed
     */
    private function listConfigAirline($type) {
        return $this->getController('airline')->listConfigAirline($type);
    }
    //endregion

    //region [setPriceChangesFlightForeign]

    private function flightPriceChangeList($type) {
        return $this->getController('priceChanges')->flightPriceChangeList($type);

    }
    //endregion

    //region [DateJalali]

    public function discountList() {
        return $this->getController('servicesDiscount')->getDiscountListSortByCounterAndServiceTitle();
    }
    //endregion

    //region [airlineList]

    private function airlineList() {
        $airlines = $this->getController('airline')->airLineList();
        $array_airlines = array();
        foreach ($airlines as $airline) {
            $array_airlines[$airline['abbreviation']] = $airline;
        }
        return $array_airlines;
    }
    //endregion

    //region [getDataPackage]

    public function dataTranslate() {
        $data['business_type'] = functions::Xmlinformation("BusinessType")->__toString();
        $data['economics_type'] = functions::Xmlinformation("EconomicsType")->__toString();
        $data['premium_economy_type'] = functions::Xmlinformation("premiumEconomy")->__toString();
        $data['system_flight'] = functions::Xmlinformation("SystemType")->__toString();
        $data['charter_flight'] = functions::Xmlinformation("CharterType")->__toString();
        $data['morning'] = functions::Xmlinformation("Morning")->__toString();
        $data['day'] = functions::Xmlinformation("Day")->__toString();
        $data['evening'] = functions::Xmlinformation("Evening")->__toString();
        $data['night'] = functions::Xmlinformation("Night")->__toString();
        $data['no_interrupt'] = functions::Xmlinformation("Nostop")->__toString();
        $data['one_interrupt'] = functions::Xmlinformation("Onestop")->__toString();
        $data['two_interrupt'] = functions::Xmlinformation("Twostop")->__toString();
        $data['Time_morning'] = functions::Xmlinformation("Timemorning")->__toString();
        $data['day_text'] = functions::Xmlinformation('Day')->__toString();
        $data['hour_text'] = functions::Xmlinformation('Hour')->__toString();
        $data['and_text'] = functions::Xmlinformation('And')->__toString();
        $data['minutes_text'] = functions::Xmlinformation('Minutes')->__toString();
        $data['no_baggage'] = functions::Xmlinformation('NoBaggage')->__toString();
        $data['kg'] = functions::Xmlinformation('Kg')->__toString();
        $data['amount_baggage'] = functions::Xmlinformation('AmountBaggage')->__toString();
        $data['minutes_text'] = functions::Xmlinformation('Minutes')->__toString();
        $data['rial'] = functions::Xmlinformation('Rial')->__toString();
        $data['chair'] = functions::Xmlinformation('Chair')->__toString();
        $data['Call'] = functions::Xmlinformation('Call')->__toString();
        $data['withInquire'] = functions::Xmlinformation('withInquire')->__toString();
        $data['maximum'] = functions::Xmlinformation('maximum')->__toString();
        $data['minimum'] = functions::Xmlinformation('minimum')->__toString();
        $data['baggage_to_more'] = functions::Xmlinformation('baggage_to_more')->__toString();
        $data['baggage_to_low'] = functions::Xmlinformation('baggage_to_low')->__toString();
        $data['Hour'] = functions::Xmlinformation('Hour')->__toString();
        $data['Minutes'] = functions::Xmlinformation('Minutes')->__toString();
        $data['And'] = functions::Xmlinformation('And')->__toString();

        return $data;
    }
    //endregion

    #region [setPriceChangesFlightForeign]

    public function setPriceChangesFlightForeign($data, $data_info = null) {

        $flight_type = strtolower($data['FlightType']);
        $source_id = $data['sourceId'];
        $counter_type_id = $this->getCounterTypeId;
        $check_private = ($data_info['list_config_airline'][$flight_type][$data['airlineIata']]['isPublic'] == '0') ? 'private' : 'public';
        $info_price_change = $data_info['price_change_list'][$data['airlineIata']][$counter_type_id];
        $calculate_price_change['changeType'] = $info_price_change['changeType'];
        $calculate_price_change['price'] = $info_price_change['price'];
        $type_ticket = strtolower($flight_type) == 'system' ? '' : 'public';
        $type_service = functions::TypeService($flight_type, $data['typeZone'], $type_ticket, $check_private, $data['airlineIata']);

        $discount['off_percent'] = $data_info['discount_list'][$counter_type_id][$type_service]['off_percent'];
        $add_on_price = 0;
        $it_commission = 0;
        $price['adult']['TotalPrice'] = $data['price']['adult']['TotalPrice'];
        $price['adult']['TotalPriceWithDiscount'] = 0;
        $price['adult']['BasePrice'] = $data['price']['adult']['BasePrice'];
        $price['child']['TotalPrice'] = $data['price']['child']['TotalPrice'];
        $price['child']['TotalPriceWithDiscount'] = 0;
        $price['child']['BasePrice'] = $data['price']['child']['BasePrice'];
        $price['infant']['TotalPrice'] = $data['price']['infant']['TotalPrice'];
        $price['infant']['TotalPriceWithDiscount'] = 0;
        $price['infant']['BasePrice'] = $data['price']['infant']['BasePrice'];
        $price['hasDiscount'] = 'No';
        $change_price = false;

        foreach ($data['price'] as $key => $price_type) {
            $price[$key]['has_discount'] = 'No';
            $price[$key]['type_currency'] = $data_info['data_translate']['rial'];
            $price_type['TotalPrice'] = $this->ShowPriceTicket($flight_type, $price[$key]['TotalPrice'], $data['sourceId']);
            $price_type['BasePrice'] = $this->ShowPriceTicket($flight_type, $price[$key]['BasePrice'], $data['sourceId']);
            if ($calculate_price_change['price'] > 0 && ($flight_type == 'charter' || $data['typeZone'] == 'Portal') && $price_type['TotalPrice'] > 0) {
                if ($calculate_price_change['changeType'] == 'cost') {
                    $change_price = true;
                    $add_on_price = $calculate_price_change['price'];
                } elseif ($calculate_price_change['changeType'] == 'percent') {
                    $change_price = true;
                    $add_on_price = (($price_type['TotalPrice'] * $calculate_price_change['price']) / 100);
                }
                $price[$key]['TotalPrice'] = $price_type['TotalPrice'];

                $price[$key]['TotalPrice'] += $add_on_price;

                if ($data['typeZone'] == 'Local') {
                    $it_commission = $this->getController('irantechCommission')->getFlightCommission($type_service, $source_id);

                    $price[$key]['TotalPrice'] += $it_commission;
                }


            } else {
                $price[$key]['TotalPrice'] = $price_type['TotalPrice'];
            }


            if ((($data['typeZone'] == 'Portal' && $change_price) || ($data['typeZone'] != 'Portal' && $flight_type == 'charter')) && $discount['off_percent'] > 0 && $price_type['TotalPrice'] > 0) {
                $price[$key]['has_discount'] = 'yes';
                //                $price = $price - (($price * $discount['off_percent']) / 100);
                if ((!empty($calculate_price_change) && $flight_type == 'charter') || ($data['typeZone'] == 'Portal')) {
                    $price[$key]['TotalPriceWithDiscount'] = round($price[$key]['TotalPrice'] - (($add_on_price * $discount['off_percent']) / 100));
                } else if ($check_private == 'public' && $flight_type == 'system') {
                    $price[$key]['TotalPriceWithDiscount'] = round($price[$key]['TotalPrice'] - ($price_type['BasePrice'] * ($discount['off_percent'] / 200)));
                } else if ($check_private == 'private' && $flight_type == 'system') {
                    $price[$key]['TotalPriceWithDiscount'] = round($price[$key]['TotalPrice'] - ($price_type['BasePrice'] * ($discount['off_percent'] / 100)));
                }
            }
            $origin_price_total_after_change = $price[$key]['TotalPrice'];
            $origin_price_discount_total_after_change = $price[$key]['TotalPriceWithDiscount'];
            if (SOFTWARE_LANG != 'fa') {
                $base_price_currency = functions::CurrencyCalculate($price[$key]['BasePrice'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn']);
                $total_price_currency = functions::CurrencyCalculate($price[$key]['TotalPrice'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn']);
                $total_price_with_discount = functions::CurrencyCalculate($price[$key]['TotalPriceWithDiscount'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn']);
                $price[$key]['BasePrice'] = $base_price_currency['AmountCurrency'];
                $price[$key]['TotalPrice'] = $total_price_currency['AmountCurrency'];
                $price[$key]['TotalPriceWithDiscount'] = $total_price_with_discount['AmountCurrency'];
                $price[$key]['type_currency'] = $total_price_currency['TypeCurrency'];
            }
            $price[$key]['price_with_out_currency'] = $origin_price_total_after_change;
            $price[$key]['price_discount_with_out_currency'] = $origin_price_discount_total_after_change;

        }
        return $price;

    }

    #endregion

    #region [ShowPriceTicket]

    /**
     * @param $type
     * @param $price
     * @param $SourceId
     * @return float|int
     */
    public function ShowPriceTicket($type, $price, $SourceId) {
        if ($_SERVER['REMOTE_ADDR'] == '178.131.170.57') {
//            var_dump(['$type'=>$type,'$price',$price,['$SourceId',$SourceId]]);

        }
        switch ($SourceId) {
            case '13':
                if ($type == 'charter') {
                    return (functions::convert_toman_rial(($price + 1500)));
                } elseif ($type == 'system') {
                    return functions::convert_toman_rial($price);
                }
                break;
            case '10':
            case '15':
            case '17':
            case '18':
            case '19':
            case '20':
            case '22':
                return $price;

            /* case '1':
             case '11':
             case '8':
             case '12':
             case '14':
             case '16':
             case '5':*/
            default:
                return (functions::convert_toman_rial($price));
                break;

        }
    }

    #endregion

    #region [dataTranslate]

    public function DateJalali($param, $type = null) {
        $explode_date = explode('-', $param);

        if ($explode_date[0] > 1450) {

            $jmktime = mktime('0', '0', '0', $explode_date[1], $explode_date['2'], $explode_date[0]);
            $this->date_now = date(" j F Y", $jmktime);
            if (empty($type)) {
                $this->DateJalaliRequest = date("Y-m-d", $jmktime);
            } else if ($type == 'TwoWay') {
                $this->DateJalaliRequestReturn = date("Y-m-d", $jmktime);
            }
            $this->day = date("l", $jmktime);
        } else {

            if (SOFTWARE_LANG != 'fa') {
                $jmktime = mktime('0', '0', '0', $explode_date[1], $explode_date['2'], $explode_date[0]);
                $this->date_now = date(" j F Y", $jmktime);
                if (empty($type)) {
                    $this->DateJalaliRequest = date("Y-m-d", $jmktime);
                } else if ($type == 'TwoWay') {
                    $this->DateJalaliRequestReturn = date("Y-m-d", $jmktime);
                }
                $this->day = date("l", $jmktime);
            } else {
                $jmktime = dateTimeSetting::jmktime(0, 0, 0, $explode_date[1], $explode_date[2], $explode_date[0]);
                $this->date_now = dateTimeSetting::jdate(" j F Y", $jmktime);
                if (empty($type)) {
                    $this->DateJalaliRequest = dateTimeSetting::jdate("Y-m-d", $jmktime, '', '', 'en');
                } else if ($type == 'TwoWay') {
                    $this->DateJalaliRequestReturn = dateTimeSetting::jdate("Y-m-d", $jmktime, '', '', 'en');
                }
                $this->day = dateTimeSetting::jdate("l", $jmktime);
            }
        }
    }
    #endregion

    #region [getDataPackage]

    public function getDataPackage3() {
        functions::insertLog('before flight Ticket','package_log');
        $dataSearch = json_decode($this->findTicketInSearch('twoWay'), true);
        functions::insertLog('after flight Ticket','package_log');


        $flightFiltered = array();
        foreach ($dataSearch['twoWay']['Flights'] as $flight) {
            if ($flight['SourceId'] == '11' || $flight['SourceId'] == '10' || $flight['SourceId'] == '17') {
                $flightFiltered[] = $flight;
            }
        }

        $dataSearch['twoWay']['Flights'] = $flightFiltered;


        error_log('first  getTicketInternal  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');
        $BusinessType = strip_tags(functions::Xmlinformation("BusinessType"));
        $EconomicsType = strip_tags(functions::Xmlinformation("EconomicsType"));
        $systemFlight = strip_tags(functions::Xmlinformation("SystemType"));
        $charterFlight = strip_tags(functions::Xmlinformation("CharterType"));
        $Morning = strip_tags(functions::Xmlinformation("Morning"));
        $Day = strip_tags(functions::Xmlinformation("Day"));
        $Evening = strip_tags(functions::Xmlinformation("Evening"));
        $Night = strip_tags(functions::Xmlinformation("Night"));

        $LongTime = array();
        if ($this->isInternal) {
            $LongTime = functions::LongTimeFlightHours($this->origin, $this->destination);
        }


        $this->tickets['NameDeparture'] = $this->originName;
        $this->tickets['NameArrival'] = $this->destinationName;

        $airlines = array();
        $this->tickets['MultiWay'] = 'twoWay';
        $this->tickets['timeFilter']['Morning']['name'] = 'early';
        $this->tickets['timeFilter']['Morning']['time'] = $Morning;
        $this->tickets['timeFilter']['Morning']['value'] = '0-8';
        $this->tickets['timeFilter']['Day']['name'] = 'morning';
        $this->tickets['timeFilter']['Day']['time'] = $Day;
        $this->tickets['timeFilter']['Day']['value'] = '8-12';
        $this->tickets['timeFilter']['Evening']['name'] = 'afternoon';
        $this->tickets['timeFilter']['Evening']['time'] = $Evening;
        $this->tickets['timeFilter']['Evening']['value'] = '12-18';
        $this->tickets['timeFilter']['Night']['name'] = 'night';
        $this->tickets['timeFilter']['Night']['time'] = $Night;
        $this->tickets['timeFilter']['Night']['value'] = '18-24';

        $this->tickets['typeFlightFilter']['system']['name'] = $systemFlight;
        $this->tickets['typeFlightFilter']['system']['EnName'] = 'system';
        $this->tickets['typeFlightFilter']['charter']['name'] = $charterFlight;
        $this->tickets['typeFlightFilter']['charter']['EnName'] = 'charter';


        $this->tickets['seatClassFilter']['economy']['name_fa'] = $EconomicsType;
        $this->tickets['seatClassFilter']['economy']['name_en'] = 'economy';
        $this->tickets['seatClassFilter']['premium_economy']['name_fa'] = functions::Xmlinformation("premiumEconomy")->__toString();
        $this->tickets['seatClassFilter']['premium_economy']['name_en'] = 'premium_economy';
        $this->tickets['seatClassFilter']['business']['name_fa'] = $BusinessType;
        $this->tickets['seatClassFilter']['business']['name_en'] = 'business';

        error_log('next go to DataAjaxSearch  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search_foreach.txt');
        $i = 0;
        $count = count($dataSearch['twoWay']['Flights']);
        $newarray = $dataSearch['twoWay']['Flights'];
        $timeCompare = array();


        $arrayAirlines = array();

        functions::insertLog('before foreach hotel package','package_log');
        for ($key = 0; $key < $count; $key++) {

            if($key < 200){

                if ($this->isInternal) {
                    $ArrivalTimeDept = functions::CalculateArrivalTime(($LongTime['Hour'] . ':' . $LongTime['Minutes'] . ':00'), $newarray[$key]['OutputRoutes'][0]['DepartureTime']);
                    $ArrivalTimeReturn = functions::CalculateArrivalTime(($LongTime['Hour'] . ':' . $LongTime['Minutes'] . ':00'), $newarray[$key]['ReturnRoutes'][0]['DepartureTime']);
                }
                $countArrayDept = count($newarray[$key]['OutputRoutes']);
                $countArrayReturn = count($newarray[$key]['ReturnRoutes']);

                $isInternal = $newarray[$key]['IsInternal'];
                $typeZone = ($isInternal) ? 'local' : 'international';
                $typeFlight = (($newarray[$key]['SeatClass'] == 'C' || $newarray[$key]['SeatClass'] == 'B') ? 'business' : 'economy');
                $sourceId = $newarray[$key]['SourceId'];

                $dataChangePrice['price']['adult']['TotalPrice'] = $newarray[$key]['PassengerDatas'][0]['TotalPrice'];
                $dataChangePrice['price']['adult']['BasePrice'] = $newarray[$key]['PassengerDatas'][0]['BasePrice'];

                $dataChangePrice['price']['child']['TotalPrice'] = $newarray[$key]['PassengerDatas'][1]['TotalPrice'];
                $dataChangePrice['price']['child']['BasePrice'] = $newarray[$key]['PassengerDatas'][1]['BasePrice'];

                $dataChangePrice['price']['infant']['TotalPrice'] = $newarray[$key]['PassengerDatas'][2]['TotalPrice'];
                $dataChangePrice['price']['infant']['BasePrice'] = $newarray[$key]['PassengerDatas'][2]['BasePrice'];

                $dataChangePrice['airlineIata'] = $newarray[$key]['OutputRoutes'][0]['Airline']['Code'];
                $dataChangePrice['FlightType'] = strtolower($newarray[$key]['FlightType']);
                $dataChangePrice['isInternal'] = $isInternal;
                $dataChangePrice['typeZone'] = $typeZone;
                $dataChangePrice['IsInternal'] = $newarray[$key]['IsInternal'];
                $dataChangePrice['typeFlight'] = $typeFlight;
                $dataChangePrice['sourceId'] = $sourceId;

                $priceChangeCalculate = $this->setPriceChanges($dataChangePrice);
                $airlineIata = $newarray[$key]['OutputRoutes'][0]['Airline']['Code'];


                $Price['Adult']['TotalPrice'] = round($priceChangeCalculate['adult']['TotalPrice']);
                $Price['Adult']['BasePrice'] = round($priceChangeCalculate['adult']['BasePrice']);
                $Price['Adult']['TotalWithDiscount'] = round($priceChangeCalculate['adult']['TotalPriceWithDiscount']);
                //child
                $Price['child']['TotalPrice'] = round($priceChangeCalculate['child']['TotalPrice']);
                $Price['child']['BasePrice'] = round($priceChangeCalculate['child']['BasePrice']);
                $Price['child']['TotalWithDiscount'] = round($priceChangeCalculate['child']['TotalPriceWithDiscount']);

                //infant
                $Price['infant']['TotalPrice'] = round($priceChangeCalculate['infant']['TotalPrice']);
                $Price['infant']['BasePrice'] = round($priceChangeCalculate['infant']['BasePrice']);
                $Price['infant']['TotalWithDiscount'] = round($priceChangeCalculate['infant']['TotalPriceWithDiscount']);

                if (!in_array($airlineIata, $arrayAirlines)) {
                    $airlines[] = $airlineIata;
                }

                foreach ($airlines as $airline) {
                    if ($airline == $airlineIata && round($Price['Adult']['TotalPrice']) > 0) {
                        $price[$airlineIata][] = round($priceChangeCalculate['adult']['TotalPrice']);
                        $this->tickets['MinPriceAirline'][$airlineIata]['EnName'] = strtoupper($airlineIata);
                        $this->tickets['MinPriceAirline'][$airlineIata]['price'] = number_format(round(min($price[$airlineIata])));
                        $this->tickets['MinPriceAirline'][$airlineIata]['name'] = functions::AirlineName($airlineIata);
                    }
                }



                if (!empty($newarray[$key]['OutputRoutes'])) {
                    foreach ($newarray[$key]['OutputRoutes'] as $keyOutPut => $flightOutPut) {
                        $timeIntFlight = strtotime($flightOutPut['DepartureTime']);

                        if (!in_array($timeIntFlight, $timeCompare)) {

                            $timeCompare[] = $timeIntFlight;
                        }
                        if (!$this->isInternal) {
                            $ArrivalTime['time'] = $flightOutPut['ArrivalTime'];
                        }
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['FlightNo'] = $flightOutPut['FlightNo'];
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['Airline'] = $flightOutPut['Airline']['Code'];
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['AirlineName'] = functions::AirlineName($flightOutPut['Airline']['Code']);
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['AirlineLogo'] = functions::getAirlinePhoto($flightOutPut['Airline']['Code']);
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['DepartureDate'] = str_replace('/', '-', functions::convertDateFlight($flightOutPut['DepartureDate']));
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['ArrivalDate'] = $this->isInternal ? str_replace('/', '-', functions::Date_arrival($this->origin, $this->destination, $flightOutPut['DepartureTime'], $flightOutPut['DepartureDate'])) : functions::ConvertToJalali($flightOutPut['ArrivalDate']);
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['DepartureParentRegionName'] = functions::DateWithName(functions::convertDateFlight($flightOutPut['DepartureDate']));
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['DepartureCode'] = strtoupper($flightOutPut['Departure']['Code']);
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['DepartureCity'] = $this->originName;
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['ArrivalParentRegionName'] = $flightOutPut['Arrival']['ParentRegionName'];
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['ArrivalCode'] = strtoupper($flightOutPut['Arrival']['Code']);
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['ArrivalCity'] = $this->destinationName;
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['Aircraft'] = $flightOutPut['Aircraft']['Manufacturer'];
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['DepartureTime'] = $flightOutPut['DepartureTime'];
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['ArrivalTime'] = $ArrivalTimeDept['time'];
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['SeatClass'] = ($typeFlight == 'business') ? $BusinessType : $EconomicsType;
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['SeatClassEn'] = $typeFlight;
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['CabinType'] = $flightOutPut['CabinType'];
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['Baggage'] = $this->isInternal ? '20' : $flightOutPut['Baggage'][0]['Charge'];
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['BaggageType'] = $this->isInternal ? '20' : $flightOutPut['Baggage'][0]['Code'];
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['SourceName'] = !empty($newarray[$key]['SourceName']) ? $newarray[$key]['SourceName'] : '';
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['TotalOutputFlightDuration'] = ($this->isInternal) ? ($LongTime['Hour'] . ':' . $LongTime['Minutes']) : isset($flightOutPut['TotalOutputFlightDuration']) ? $flightOutPut['TotalOutputFlightDuration'] : '';;
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut]['TotalOutputStopDuration'] = isset($flightOutPut['TotalOutputStopDuration']) ? $flightOutPut['TotalOutputStopDuration'] : '';
                    }
                }

                if (!empty($newarray[$key]['ReturnRoutes'])) {
                    foreach ($newarray[$key]['ReturnRoutes'] as $keyReturnPut => $flightReturnRoutes) {
                        if (!$this->isInternal) {
                            $ArrivalTime['time'] = $flightReturnRoutes['ArrivalTime'];
                        }
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['FlightNo'] = $flightReturnRoutes['FlightNo'];
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['Airline'] = $flightReturnRoutes['Airline']['Code'];
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['AirlineName'] = functions::AirlineName($flightReturnRoutes['Airline']['Code']);
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['AirlineLogo'] = functions::getAirlinePhoto($flightOutPut['Airline']['Code']);
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['DepartureDate'] = str_replace('/', '-', $flightReturnRoutes['DepartureDate']);
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['ArrivalDate'] = $this->isInternal ? str_replace('/', '-', functions::Date_arrival($this->origin, $this->destination, $flightReturnRoutes['DepartureTime'], $flightReturnRoutes['DepartureDate'])) : $flightReturnRoutes['ArrivalDate'];
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['DepartureParentRegionName'] = functions::DateWithName(functions::convertDateFlight($flightReturnRoutes['DepartureDate']));
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['DepartureCode'] = strtoupper($flightReturnRoutes['Departure']['Code']);
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['DepartureCity'] = $this->destinationName;
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['ArrivalParentRegionName'] = $flightReturnRoutes['Arrival']['ParentRegionName'];
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['ArrivalCode'] = strtoupper($flightReturnRoutes['Arrival']['Code']);
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['ArrivalCity'] = $this->originName;
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['Aircraft'] = $flightReturnRoutes['Aircraft']['Manufacturer'];
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['DepartureTime'] = $flightReturnRoutes['DepartureTime'];
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['ArrivalTime'] = $ArrivalTimeReturn['time'];
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['SeatClass'] = ($typeFlight == 'business') ? $BusinessType : $EconomicsType;
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['SeatClassEn'] = $typeFlight;
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['CabinType'] = $flightReturnRoutes['CabinType'];
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['Baggage'] = $this->isInternal ? '20' : $flightReturnRoutes['Baggage'][0]['Charge'];
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['BaggageType'] = $this->isInternal ? '20' : $flightReturnRoutes['Baggage'][0]['Code'];
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['SourceName'] = !empty($newarray[$key]['SourceName']) ? $newarray[$key]['SourceName'] : '';
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['TotalOutputFlightDuration'] = ($this->isInternal) ? ($LongTime['Hour'] . ':' . $LongTime['Minutes']) : isset($flightReturnRoutes['TotalOutputFlightDuration']) ? $flightReturnRoutes['TotalOutputFlightDuration'] : '';
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut]['TotalOutputStopDuration'] = isset($flightReturnRoutes['TotalOutputStopDuration']) ? $flightReturnRoutes['TotalOutputStopDuration'] : '';

                    }
                }

                $this->tickets['resultFlight'][$i]['DepartureTimeDept'] = $newarray[$key]['OutputRoutes'][0]['DepartureTime'];
                $this->tickets['resultFlight'][$i]['ArrivalTimeDept'] = $this->isInternal ? $ArrivalTimeDept['time'] : $newarray[$key]['OutputRoutes'][count($newarray[$key]['OutputRoutes']) - 1]['ArrivalTime'];
                $this->tickets['resultFlight'][$i]['DepartureTimeReturn'] = $newarray[$key]['ReturnRoutes'][0]['DepartureTime'];
                $this->tickets['resultFlight'][$i]['ArrivalTimeReturn'] = $this->isInternal ? $ArrivalTimeDept['time'] : $newarray[$key]['ReturnRoutes'][count($newarray[$key]['ReturnRoutes']) - 1]['ArrivalTime'];;

                //adt price
                $this->tickets['resultFlight'][$i]['AdtPrice'] = $Price['Adult']['TotalPrice'];
                $this->tickets['resultFlight'][$i]['AdtFare'] = $Price['Adult']['BasePrice'];
                $this->tickets['resultFlight'][$i]['AdtWithDiscount'] = $Price['Adult']['TotalWithDiscount'];
                //chd price
                $this->tickets['resultFlight'][$i]['chdPrice'] = $Price['child']['TotalPrice'];
                $this->tickets['resultFlight'][$i]['chdFare'] = $Price['child']['BasePrice'];
                $this->tickets['resultFlight'][$i]['chdWithDiscount'] = $Price['child']['TotalWithDiscount'];
                //inf price
                $this->tickets['resultFlight'][$i]['infantPrice'] = $Price['infant']['TotalPrice'];
                $this->tickets['resultFlight'][$i]['infantFare'] = $Price['infant']['BasePrice'];
                $this->tickets['resultFlight'][$i]['infantWithDiscount'] = $Price['infant']['TotalWithDiscount'];

                $this->tickets['resultFlight'][$i]['Capacity'] = $newarray[$key]['Capacity'];
                $this->tickets['resultFlight'][$i]['FlightType'] = (strtolower($newarray[$key]['FlightType']) == 'system') ? $systemFlight : $charterFlight;
                $this->tickets['resultFlight'][$i]['FlightID'] = $newarray[$key]['FlightID'];
                $this->tickets['resultFlight'][$i]['ReturnFlightID'] = $newarray[$key]['ReturnFlightID'];
                $this->tickets['resultFlight'][$i]['DirectionFlight'] = 'twoWay';
                $this->tickets['resultFlight'][$i]['UniqueCode'] = $newarray[$key]['Code'];
                $this->tickets['resultFlight'][$i]['IsInternal'] = $newarray[$key]['IsInternal'];
                $this->tickets['resultFlight'][$i]['Reservable'] = $newarray[$key]['Reservable'];
                $this->tickets['resultFlight'][$i]['SourceId'] = $newarray[$key]['SourceId'];
                $this->tickets['resultFlight'][$i]['Adult'] = $this->adult;
                $this->tickets['resultFlight'][$i]['Child'] = $this->child;
                $this->tickets['resultFlight'][$i]['Infant'] = $this->infant;
                $this->tickets['resultFlight'][$i]['UserName'] = $this->username;

                $i++;
                error_log('next go to DataAjaxSearch  : ' . date('Y/m/d H:i:s') . '<hr/>' . " \n", 3, LOGS_DIR . 'log_Request_send_search_foreach.txt');
            }
        }
        functions::insertLog('afetr foreach flight package','package_log');
        $this->tickets['minTime'] = min($timeCompare);
        $this->tickets['Lang'] = $this->softWareLang;
        return json_encode($this->tickets);

    }
    #endregion

    public function getDataPackage($is_internal) {

        $info_currency = functions::infoCurrencyBySessionCode(Session::getCurrency());

        functions::insertLog('before flight Ticket','package_log');
        $this->isInternal = $is_internal ;
        $dataSearch = json_decode($this->findTicketInSearch('twoWay'), true);
        functions::insertLog('after flight Ticket ' . json_encode($dataSearch),'package_log');




        $flightFiltered = array();
        foreach ($dataSearch['twoWay']['Flights'] as $flight) {
            if ($flight['SourceId'] == '11' || $flight['SourceId'] == '10' || $flight['SourceId'] == '17' || $flight['SourceId'] == '21' || $flight['SourceId'] == '43') {
                $flightFiltered[] = $flight;
            }
        }

        $dataSearch['twoWay']['Flights'] = $flightFiltered;


        error_log('first  getTicketInternal  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');
        $BusinessType = strip_tags(functions::Xmlinformation("BusinessType"));
        $EconomicsType = strip_tags(functions::Xmlinformation("EconomicsType"));
        $systemFlight = strip_tags(functions::Xmlinformation("SystemType"));
        $charterFlight = strip_tags(functions::Xmlinformation("CharterType"));


        $airlines = array();
        $list_config_airline = $this->listConfigAirline(true);
        $price_change_list = $this->flightPriceChangeList('local');
        $discount_list = $this->discountList();
        $airlines_name = $this->airlineList();
        $translateVariable = $this->dataTranslate();
        $type_zone = 'Local';
        $prices = array();

        $data_param_set_change_price['list_config_airline'] = $list_config_airline;
        $data_param_set_change_price['price_change_list'] = $price_change_list;
        $data_param_set_change_price['discount_list'] = $discount_list;
        $data_param_set_change_price['info_currency'] = $info_currency;
        $data_param_set_change_price['data_translate'] = $translateVariable;


        $LongTime = array();
        if ($this->isInternal) {
            $LongTime = functions::LongTimeFlightHours($this->origin, $this->destination);
        }


        $this->tickets['NameDeparture'] = $this->originName;
        $this->tickets['NameArrival'] = $this->destinationName;

        $info_route = $this->getLongTimeFlightInternal($this->origin, $this->destination, $translateVariable);
        $this->tickets = $this->filterInternationalFlight($translateVariable);

        $this->tickets['MinPriceAirline'] = array();

        $this->tickets['price'] = array();

        $airlines = array();
        $this->tickets['MultiWay'] = 'twoWay';

        error_log('next go to DataAjaxSearch  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search_foreach.txt');
        $i = 0;
        $count = count($dataSearch['twoWay']['Flights']);
        $newarray = $dataSearch['twoWay']['Flights'];

        $timeCompare = array();
        $arrayAirlines = array();

        functions::insertLog('before foreach flight package','package_log');
        for ($key = 0; $key < $count; $key++) {

            if($key < 10){
                $flight = $newarray[$key] ;
                if ($this->isInternal) {
                    $ArrivalTimeDept = functions::CalculateArrivalTime(($LongTime['Hour'] . ':' . $LongTime['Minutes'] . ':00'), $flight['OutputRoutes'][0]['DepartureTime']);
                    $ArrivalTimeReturn = functions::CalculateArrivalTime(($LongTime['Hour'] . ':' . $LongTime['Minutes'] . ':00'), $flight['ReturnRoutes'][0]['DepartureTime']);
                }
                $countArrayDept = count($flight['OutputRoutes']);
                $countArrayReturn = count($flight['ReturnRoutes']);

                $isInternal = $flight['IsInternal'];
                $type_zone = ($isInternal) ? 'local' : 'international';
                $type_flight = (($flight['SeatClass'] == 'C' || $flight['SeatClass'] == 'J' || $flight['SeatClass'] == 'D' || $flight['SeatClass'] == 'I' || $flight['SeatClass'] == 'Z') ? 'business' : 'economy');
                $source_id = $flight['SourceId'];
                $data_change_price = array(
                    'airlineIata' => $flight['OutputRoutes'][0]['Airline']['Code'],
                    'FlightType' => strtolower($flight['FlightType']),
                    'typeZone' => $type_zone,
                    'typeFlight' => $type_flight,
                    'sourceId' => $source_id,
                    'isInternal' => true,
                    'price' => array(
                        'adult' => array(
                            'TotalPrice' => $flight['PassengerDatas'][0]['TotalPrice'],
                            'BasePrice' => $flight['PassengerDatas'][0]['BasePrice'],
                        ),
                        'child' => array(
                            'TotalPrice' => isset($flight['PassengerDatas'][1]['TotalPrice']) ? $flight['PassengerDatas'][1]['TotalPrice'] : 0,
                            'BasePrice' => isset($flight['PassengerDatas'][1]['BasePrice']) ? $flight['PassengerDatas'][1]['BasePrice'] : 0,
                        ),
                        'infant' => array(
                            'TotalPrice' => isset($flight['PassengerDatas'][2]['TotalPrice']) ? $flight['PassengerDatas'][2]['TotalPrice'] : 0,
                            'BasePrice' => isset($flight['PassengerDatas'][2]['BasePrice']) ? $flight['PassengerDatas'][2]['BasePrice'] : 0,
                        ),
                    )
                );

//            $priceChangeCalculate = $this->setPriceChanges($dataChangePrice);
                $price_change_calculate = $this->getController('priceChanges')->setPriceChangesFlight($data_change_price, $data_param_set_change_price);
                $Price = [
                    'Adult'  => [
                        'TotalPrice' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $price_change_calculate['adult']['TotalPrice'] : round($price_change_calculate['adult']['TotalPrice']),
                        'BasePrice' => round($price_change_calculate['adult']['BasePrice']),
                        'TotalWithDiscount' => round($price_change_calculate['adult']['TotalPriceWithDiscount']),
                    ],
                    'Child'   => [
                        'TotalPrice' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $price_change_calculate['child']['TotalPrice'] : round($price_change_calculate['child']['TotalPrice']),
                        'BasePrice' => round($price_change_calculate['child']['BasePrice']),
                        'TotalWithDiscount' => round($price_change_calculate['child']['TotalPriceWithDiscount']),
                    ],
                    'infant'   => [
                        'TotalPrice' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $price_change_calculate['infant']['TotalPrice'] : round($price_change_calculate['infant']['TotalPrice']),
                        'BasePrice' => round($price_change_calculate['infant']['BasePrice']),
                        'TotalWithDiscount' => round($price_change_calculate['infant']['TotalPriceWithDiscount']),
                    ],
                ];

                $airline_iata = $flight['OutputRoutes'][0]['Airline']['Code'];

//            if ($price_change_calculate['adult']['TotalPrice'] > 0) {
//                $this->tickets['prices'][$direction][] = $price_change_calculate['adult']['TotalPrice'];
//            }

//                if (!in_array($airline_iata, $airlines)) {
//
//                    $airlines[] = $airline_iata;
//                    foreach ($airlines as $airline) {
//
//                        if ($airline == $airline_iata && round($price_change_calculate['adult']['TotalPrice']) > 0) {
//                            $aireline_Price[$airline_iata][] = $price_change_calculate['adult']['TotalPrice'];
//
//                            $price_currency_min = min($aireline_Price[$airline_iata]);
//                            $this->tickets['MinPriceAirline'][$airline_iata] = array(
//                                'EnName' => $airline_iata,
//                                'price' => functions::numberFormat($price_currency_min),
//                                'name' => $airlines_name[$airline_iata][functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa')],
//                            );
//                        }
//                    }
//                }


                if (!empty($flight['OutputRoutes'])) {
                    foreach ($flight['OutputRoutes'] as $keyOutPut => $flightOutPut) {
                        $dept_arrival_date = ($flight['OutputRoutes'][0]['ArrivalDate'] !="") ?  $flight['OutputRoutes'][0]['ArrivalDate'] : functions::Date_arrival($flight['OutputRoutes'][0]['Departure']['Code'], $flight['OutputRoutes'][0]['Arrival']['Code'], $flight['OutputRoutes'][0]['DepartureTime'], $flight['OutputRoutes'][0]['DepartureDate']);

                        $ArrivalTime = ($flight['OutputRoutes'][0]['ArrivalTime'] !="") ? substr($flight['OutputRoutes'][0]['ArrivalTime'],0,5) : functions::CalculateArrivalTime(($info_route['Hour'] . ':' . $info_route['Minutes'] . ':00'), $flight['OutputRoutes'][0]['DepartureTime'])['time'];
                        $timeIntFlight = strtotime($flightOutPut['DepartureTime']);

                        if (!in_array($timeIntFlight, $timeCompare)) {

                            $timeCompare[] = $timeIntFlight;
                        }
                        if (!$this->isInternal) {
                            $ArrivalTime['time'] = $flightOutPut['ArrivalTime'];
                        }
                        $this->tickets['resultFlight'][$i]['dept'][$keyOutPut] = [
                            'FlightNo' => $flightOutPut['FlightNo'],
                            'Airline' => $airline_iata,
                            'AirlineLogo' => functions::getAirlinePhoto($airline_iata),
                            'AirlineName' => $airlines_name[$airline_iata][functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa')],
                            'DepartureDate' => functions::ConvertDateByLanguage(SOFTWARE_LANG, $flightOutPut['DepartureDate'], '/', (SOFTWARE_LANG != 'fa' ? 'Miladi' : 'Jalali'), (SOFTWARE_LANG != 'fa' ? 'false' : 'true')),
                            'departureTime' => $flightOutPut['DepartureTime'],
                            'ArrivalDate' =>   $dept_arrival_date,
                            'ArrivalTime' => $ArrivalTime,
                            'DepartureCode' => $flightOutPut['Departure']['Code'],
                            'DepartureCity' => $this->originName,
                            'ArrivalCode' =>  strtoupper($flightOutPut['Arrival']['Code']),
                            'ArrivalCity' =>  $this->destinationName,
                            'ArrivalParentRegionName' => $flightOutPut['Arrival']['ParentRegionName'],
                            'Aircraft' =>  $flightOutPut['Aircraft']['Manufacturer'],
                            'SeatClass' => (($type_flight == 'C' || $type_flight == 'B') ? $translateVariable['business_type'] : $translateVariable['economics_type']),
                            'SeatClassEn' => (($type_flight == 'C' || $type_flight == 'B') ? 'business' : 'economy'),
                            'CabinType' => $flightOutPut['CabinType'],
                            'SourceName' => !empty($newarray[$key]['SourceName']) ? $newarray[$key]['SourceName'] : '',
                            'Baggage' => $this->isInternal ? '20' : $flightOutPut['Baggage'][0]['Charge'],
                            'BaggageType' => $this->isInternal ? '20' : $flightOutPut['Baggage'][0]['Code'],
                            'TotalOutputFlightDuration' =>($this->isInternal) ? ($LongTime['Hour'] . ':' . $LongTime['Minutes']) : isset($flightReturnRoutes['TotalOutputFlightDuration']) ? $flightReturnRoutes['TotalOutputFlightDuration'] : '',
                            'TotalOutputStopDuration' => isset($flightReturnRoutes['TotalOutputStopDuration']) ? $flightReturnRoutes['TotalOutputStopDuration'] : '',
                        ];
                    }
                }

                if (!empty($flight['ReturnRoutes'])) {
                    foreach ($flight['ReturnRoutes'] as $keyReturnPut => $flightReturnRoutes) {
                        if (!$this->isInternal) {
                            $ArrivalTime['time'] = $flightReturnRoutes['ArrivalTime'];
                        }
                        $this->tickets['resultFlight'][$i]['return'][$keyReturnPut] = [
                            'FlightNo' => $flightReturnRoutes['FlightNo'],
                            'Airline' => $flightReturnRoutes['Airline']['Code'],
                            'AirlineLogo' => functions::getAirlinePhoto($flightReturnRoutes['Airline']['Code']),
                            'AirlineName' => $airlines_name[$flightReturnRoutes['Airline']['Code']][functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa')],
                            'DepartureDate' => str_replace('/', '-', $flightReturnRoutes['DepartureDate']),
                            'departureTime' => $flightReturnRoutes['DepartureTime'],
                            'ArrivalDate' =>   $this->isInternal ? str_replace('/', '-', functions::Date_arrival($this->origin, $this->destination, $flightReturnRoutes['DepartureTime'], $flightReturnRoutes['DepartureDate'])) : $flightReturnRoutes['ArrivalDate'],
                            'ArrivalTime' => $ArrivalTimeReturn['time'],
                            'DepartureCode' => strtoupper($flightReturnRoutes['Departure']['Code']),
                            'DepartureCity' => $this->destinationName,
                            'ArrivalCode' =>  strtoupper($flightReturnRoutes['Arrival']['Code']),
                            'ArrivalCity' =>  $this->originName,
                            'ArrivalParentRegionName' => $flightReturnRoutes['Arrival']['ParentRegionName'],
                            'Aircraft' =>  $flightReturnRoutes['Aircraft']['Manufacturer'],
                            'SeatClass' => ($type_flight == 'business') ? $BusinessType : $EconomicsType,
                            'SeatClassEn' => $type_flight,
                            'CabinType' => $flightReturnRoutes['CabinType'],
                            'source_id' => !empty($flight['SourceId']) ? $flight['SourceId'] : '',
                            'SourceName' => !empty($flight['SourceName']) ? $flight['SourceName'] : '',
                            'unique_code' => $flight['Code'],
                            'Baggage' => $this->isInternal ? '20' : $flightOutPut['Baggage'][0]['Charge'],
                            'BaggageType' => $this->isInternal ? '20' : $flightOutPut['Baggage'][0]['Code'],
                            'TotalOutputFlightDuration' =>($this->isInternal) ? ($LongTime['Hour'] . ':' . $LongTime['Minutes']) : isset($flightReturnRoutes['TotalOutputFlightDuration']) ? $flightReturnRoutes['TotalOutputFlightDuration'] : '',
                            'TotalOutputStopDuration' => isset($flightReturnRoutes['TotalOutputStopDuration']) ? $flightReturnRoutes['TotalOutputStopDuration'] : '',
                        ];
                    }
                }

                $this->tickets['resultFlight'][$i]['DepartureTimeDept'] = $newarray[$key]['OutputRoutes'][0]['DepartureTime'];
                $this->tickets['resultFlight'][$i]['ArrivalTimeDept'] = $this->isInternal ? $ArrivalTimeDept['time'] : $newarray[$key]['OutputRoutes'][count($newarray[$key]['OutputRoutes']) - 1]['ArrivalTime'];
                $this->tickets['resultFlight'][$i]['DepartureTimeReturn'] = $newarray[$key]['ReturnRoutes'][0]['DepartureTime'];
                $this->tickets['resultFlight'][$i]['ArrivalTimeReturn'] = $this->isInternal ? $ArrivalTimeDept['time'] : $newarray[$key]['ReturnRoutes'][count($newarray[$key]['ReturnRoutes']) - 1]['ArrivalTime'];;

                //adt price
                $this->tickets['resultFlight'][$i]['AdtPrice'] = $Price['Adult']['TotalPrice'];
                $this->tickets['resultFlight'][$i]['AdtFare'] = $Price['Adult']['BasePrice'];
                $this->tickets['resultFlight'][$i]['AdtWithDiscount'] = $Price['Adult']['TotalWithDiscount'];
                //chd price
                $this->tickets['resultFlight'][$i]['chdPrice'] = $Price['child']['TotalPrice'];
                $this->tickets['resultFlight'][$i]['chdFare'] = $Price['child']['BasePrice'];
                $this->tickets['resultFlight'][$i]['chdWithDiscount'] = $Price['child']['TotalWithDiscount'];
                //inf price
                $this->tickets['resultFlight'][$i]['infantPrice'] = $Price['infant']['TotalPrice'];
                $this->tickets['resultFlight'][$i]['infantFare'] = $Price['infant']['BasePrice'];
                $this->tickets['resultFlight'][$i]['infantWithDiscount'] = $Price['infant']['TotalWithDiscount'];

                $this->tickets['resultFlight'][$i]['Capacity'] = $newarray[$key]['Capacity'];
                $this->tickets['resultFlight'][$i]['FlightType'] = (strtolower($newarray[$key]['FlightType']) == 'system') ? $systemFlight : $charterFlight;
                $this->tickets['resultFlight'][$i]['FlightID'] = $newarray[$key]['FlightID'];
                $this->tickets['resultFlight'][$i]['ReturnFlightID'] = $newarray[$key]['ReturnFlightID'];
                $this->tickets['resultFlight'][$i]['DirectionFlight'] = 'twoWay';
                $this->tickets['resultFlight'][$i]['UniqueCode'] = $newarray[$key]['Code'];
                $this->tickets['resultFlight'][$i]['IsInternal'] = $newarray[$key]['IsInternal'];
                $this->tickets['resultFlight'][$i]['Reservable'] = $newarray[$key]['Reservable'];
                $this->tickets['resultFlight'][$i]['SourceId'] = $newarray[$key]['SourceId'];
                $this->tickets['resultFlight'][$i]['Adult'] = $this->adult;
                $this->tickets['resultFlight'][$i]['Child'] = $this->child;
                $this->tickets['resultFlight'][$i]['Infant'] = $this->infant;
                $this->tickets['resultFlight'][$i]['UserName'] = $this->username;

                $i++;
                error_log('next go to DataAjaxSearch  : '.$i. '  ' . date('Y/m/d H:i:s') . '<hr/>' . " \n", 3, LOGS_DIR . 'log_Request_send_search_foreach.txt');

            }
        }

        functions::insertLog('afetr foreach fliht package','package_log');
        $this->tickets['minTime'] = min($timeCompare);
        $this->tickets['Lang'] = $this->softWareLang;
        return json_encode($this->tickets);

    }
    #endregion

    #region [pointClub]

    public function setPriceChanges($data) {

        /** @var irantechCommission $iranTechCommission */
        $iranTechCommission = Load::controller('irantechCommission');
        $FlightType = strtolower($data['FlightType']);
        $counterTypeId = ($this->IsLogin) ? $this->getCounterTypeId : '5';
        $isInternal = (ucfirst($data['typeZone']) == 'Local') ? 'internal' : 'external';


        $checkPrivate = (functions::checkConfigPid($data['airlineIata'], $isInternal, $FlightType, $data['sourceId']));
        $CalculatePriceChange = functions::getAmountChangePrice($counterTypeId, $data['airlineIata'], (($data['typeZone'] == 'local') ? 'local' : 'international'));

        $TypeTicket = strtolower($FlightType) == 'system' ? '' : 'public';
        $TypeService = functions::TypeService($FlightType, ucfirst($data['typeZone']), $TypeTicket, $checkPrivate, $data['airlineIata']);
        $Discount = functions::ServiceDiscount($counterTypeId, $TypeService);
        $itCommission = $iranTechCommission->getFlightCommission($TypeService, $data['sourceId']);
        $AddOnPrice = '0';
        $Price['adult']['TotalPrice'] = $data['price']['adult']['TotalPrice'];
        $Price['adult']['TotalPriceWithDiscount'] = 0;
        $Price['adult']['BasePrice'] = $data['price']['adult']['BasePrice'];
        $Price['child']['TotalPrice'] = $data['price']['child']['TotalPrice'];
        $Price['child']['TotalPriceWithDiscount'] = 0;
        $Price['child']['BasePrice'] = $data['price']['child']['BasePrice'];
        $Price['infant']['TotalPrice'] = $data['price']['infant']['TotalPrice'];
        $Price['infant']['TotalPriceWithDiscount'] = 0;
        $Price['infant']['BasePrice'] = $data['price']['infant']['BasePrice'];
        $Price['hasDiscount'] = 'No';

        $arraySourceIncreasePriceFlightSystem = functions::sourceIncreasePriceFlightSystem();
        foreach ($data['price'] as $key => $PriceType) {
            $Price[$key]['has_discount'] = 'No';
            $Price[$key]['type_currency'] = functions::Xmlinformation('Rial')->__toString();
            $PriceType['TotalPrice'] = $this->ShowPriceTicket($FlightType, $Price[$key]['TotalPrice'], $data['sourceId']);
            $PriceType['BasePrice'] = $this->ShowPriceTicket($FlightType, $Price[$key]['BasePrice'], $data['sourceId']);
            if (!empty($CalculatePriceChange) && ($FlightType == 'charter' || ($data['typeZone'] == 'Portal') || in_array($data['sourceId'], $arraySourceIncreasePriceFlightSystem)) && $PriceType['TotalPrice'] > 0) {
                if ($CalculatePriceChange['changeType'] == 'cost') {
                    $AddOnPrice = $CalculatePriceChange['price'];
                } elseif ($CalculatePriceChange['changeType'] == 'percent') {
                    $AddOnPrice = (($PriceType['TotalPrice'] * $CalculatePriceChange['price']) / 100);
                }
                $Price[$key]['TotalPrice'] = $PriceType['TotalPrice'];
                $Price[$key]['TotalPrice'] += $AddOnPrice;
                if ($FlightType == 'charter') {
                    $Price[$key]['TotalPrice'] += $itCommission;
                }

            } else {
                $Price[$key]['TotalPrice'] = $PriceType['TotalPrice'];

                // این تیکه کد مربوط به سیاست قدیمی قیمت گذاری پرواز ها میباشد ، کامن شد به جاش سیست جدید که به صورت داینامیک هست نوشته شده است

                //                سیستمی های داخلی فلایتو 3 درصد FARE افزایش دارند
//                if($FlightType == 'system' && $data['sourceId'] =='17' && $data['typeZone'] == 'Local'){
//                    $Price[$key]['TotalPrice'] += (($PriceType['BasePrice'] * 3) / 100);
//                }
            }

            if ($Discount['off_percent'] > 0 && $PriceType['TotalPrice'] > 0) {
                $Price[$key]['hasDiscount'] = 'yes';
                //                $Price = $Price - (($Price * $Discount['off_percent']) / 100);
                if (!empty($CalculatePriceChange) && ($FlightType == 'charter' || ($data['typeZone'] == 'Portal') || in_array($data['sourceId'], $arraySourceIncreasePriceFlightSystem))) {
                    $Price[$key]['TotalPriceWithDiscount'] = round($Price[$key]['TotalPrice'] - (($AddOnPrice * $Discount['off_percent']) / 100));
                } else if ($checkPrivate == 'public' && $FlightType == 'system' && !in_array($data['sourceId'], $arraySourceIncreasePriceFlightSystem)) {
                    $Price[$key]['TotalPriceWithDiscount'] = round($PriceType['TotalPrice'] - ($PriceType['BasePrice'] * ($Discount['off_percent'] / 200)));
                } else if ($checkPrivate == 'private' && $FlightType == 'system' && !in_array($data['sourceId'], $arraySourceIncreasePriceFlightSystem)) {
                    $Price[$key]['TotalPriceWithDiscount'] = round($PriceType['TotalPrice'] - ($PriceType['BasePrice'] * ($Discount['off_percent'] / 100)));
                }
            }


        }

        return $Price;

    }
    #endregion

    #region [airlineList]

    public function flightInternational() {


        $start_function = date('H:i:s',time());
        $isCounter = $this->getController('login')->isCounter();
        $isCounter = json_decode($isCounter);
        $isSafar360 = functions::isSafar360();
        /** @var airportModel $airportModel */
        $airportModel = $this->getModel('airportModel');

        $date_now = dateTimeSetting::jdate("Y-m-d", time(), '', '', 'en');
        if (!$this->multi_destination) {
            $originCheck = $airportModel->get()->where('DepartureCode', $this->origin)->find();
            $destinationCheck = $airportModel->get()->where('DepartureCode', $this->destination)->find();

            if(!functions::isTestServer())
            {
                if (!$originCheck || !$destinationCheck) {
                    return functions::withError([], 400, 'you search with wrong city codes');
                }
                if ($originCheck['IsInternal'] == '1' && $destinationCheck['IsInternal'] == '1') {
                    return functions::withError([], 400, 'you search with wrong city codes');
                }

                if ($originCheck['DepartureCode'] == 'THR' || $destinationCheck['DepartureCode'] == 'THR') {
                    return functions::withError([], 400, 'you search with wrong city codes');
                }
            }



        }
        $after_check_validate_route = date('H:i:s',time());

//        return functions::withError([$originCheck,$destinationCheck],400,'you search with wrong city codes');

        $info_currency = functions::infoCurrencyBySessionCode(Session::getCurrency());

        $type_search = ($this->MultiWay == 'TwoWay') ? 'twoWay' : '';

        $check_currency = date('H:i:s',time());

        $data_search_flight = json_decode($this->findTicketInSearch($type_search), true);


        $request_numbers = [];
        foreach ($data_search_flight as $direction => $arrayFlight) {
            $request_numbers[$direction] = $arrayFlight['Code'] ;
        }

        $direction = ($type_search == "") ? 'dept' : 'twoWay';
//        $data_search_flight[$direction] = $this->setDataFakeFlight();

        $after_receive = date('H:i:s',time());
        error_log('Start Process Data Search in GDS  ==> ' . date('Y/m/d H:i:s') . " \n", 3, dirname(dirname(dirname(__FILE__))) . '/Core/assets/logFile/flight_international/' . $data_search_flight[$direction]['Flights'][0]['Code'] . '.txt');
        $flights_search = $data_search_flight[$direction]['Flights'];

//        if( CLIENT_ID =='327' && !$flights_search[0]['IsInternal']){// به طور موقت و برای خوابیدن صدای مشتری(هتلاتو)
//
//            $params=[
//                'type_search'=> $type_search,
//                'airline_local_list'=>['I3','AK','EP','IR','B9','W5','PY','HH','ZV','IRZ','NV','FP','QB','J1','IV','Y9','VR'],
//                'data_search' => $flights_search,
//
//            ];
//           $special_flight = $this->configHotelatoFlightInternational($params);
//
//            $flights_search=[];
//            $flights_search = $special_flight ;
//        }

        $airlines = [];
        $search_prices = [];
        $before_list_config_airline_time = date('H:i:s',time());
        $list_config_airline = $this->listConfigAirline(false);

        $list_config_airline_time = date('H:i:s',time());
        $price_change_list = $this->flightPriceChangeList('international');
        $price_change_list_time = date('H:i:s',time());
        $discount_list = $this->discountList();
        $discount_list_time = date('H:i:s',time());
        $airlines_name = $this->airlineList();
        $airlines_name_time = date('H:i:s',time());
        $airports = $this->airportPortalList();
        $translateVariable = $this->dataTranslate();
        $translateVariable_time = date('H:i:s',time());
        $type_zone = 'Portal';
        $this->prices = array();


        $data_param_set_change_price['list_config_airline'] = $list_config_airline;
        $data_param_set_change_price['price_change_list'] = $price_change_list;
        $data_param_set_change_price['discount_list'] = $discount_list;
        $data_param_set_change_price['airlines_name'] = $airlines_name;
        $data_param_set_change_price['info_currency'] = $info_currency;
        $data_param_set_change_price['data_translate'] = $translateVariable;

        $after_arrays = date('H:i:s',time());

        if (!empty($flights_search)) {

            if (!$this->multi_destination) {
                // کامنت کردن این خط که مربوط به تنظیمات ایرلاین های پرواز های خارجی بود ، در یک زمانی در صفحه https://admin.chartertech.ir/gds/itadmin/ticket/airlineClinetNewForeign&id=166 تنظیم میکردیم که سرویس دهنده ای اول نمایش دهد و در صورتی که پرواز مشابه این نبود از سرویس دهنده دوم نمایش دهد ، کامنت کردیم تا همه تامین کنندگان را نمایش دهد هر چند تا تامین کننده که داشته باشه و وصل باشه

                // اگر روزی خواستیم این رو برگردونیم تا فیلتر ها اعمال بشه خط اول که کامنت شده رو از کامنتی در میاریم خط بعد رو کامنت میکنیم

                $flights = $this->filterFlight($flights_search, $list_config_airline);
//                $flights = $flights_search;
            } else {
                $flights = $flights_search;
            }


            $check_test_parto=  (($this->MultiWay == 'TwoWay') && functions::isTestServer() && $flights[0]['IsInternal']) ;


            $this->count = count($flights);

            $after_count = date('H:i:s',time());

            $data_param_set_change_price['airports'] = $airports;



            $this->tickets = $this->filterInternationalFlight($translateVariable);



            $this->tickets['beforeFilter'] = $flights_search;
            $this->tickets['time'] = array();
            $this->tickets['time']['start_function'] = $start_function ;
            $this->tickets['time']['after_check_validate_route'] = $after_check_validate_route ;
            $this->tickets['time']['check_currency'] = $check_currency ;
            $this->tickets['time']['after_receive'] = $after_receive ;
            $this->tickets['time']['after_arrays'] = $after_arrays ;
            $this->tickets['time']['before_list_config_airline_time'] = $before_list_config_airline_time ;
            $this->tickets['time']['list_config_airline_time'] = $list_config_airline_time ;
            $this->tickets['time']['price_change_list_time'] = $price_change_list_time ;
            $this->tickets['time']['discount_list_time'] = $discount_list_time ;
            $this->tickets['time']['airlines_name_time'] = $airlines_name_time ;
            $this->tickets['time']['translateVariable_time'] = $translateVariable_time ;
            $this->tickets['time']['first'] = date('H:i:s',time());
            functions::insertLog('before foreach==>'.json_encode($flights,256),'final_ticket_foreign');
            $request_number_flight = $flights[0]['Code'] ;

            // بهینه سازی: گرفتن controller ها یک بار قبل از حلقه
            $commissionController = $this->getController('commissionSources');
            $priceChangesController = $this->getController('priceChanges');

            // بهینه سازی: Cache برای توابع تکراری
            $airportFieldNames = array(
                'Airport' => functions::changeFieldNameByLanguage('Airport'),
                'DepartureCity' => functions::changeFieldNameByLanguage('DepartureCity'),
                'Country' => functions::changeFieldNameByLanguage('Country')
            );
            // OPTIMIZATION: Cache field names in simple variables (avoid 12+ array lookups per segment)
            $airportField = $airportFieldNames['Airport'];
            $departureCityField = $airportFieldNames['DepartureCity'];
            $countryField = $airportFieldNames['Country'];
            $mapIataCodeCache = array();
            $softwareLang = SOFTWARE_LANG;
            $languageNameField = functions::ChangeIndexNameByLanguage($softwareLang, 'name', '_fa');
            $langFieldIndexEn = functions::ChangeIndexNameByLanguage($softwareLang, 'name', '_en');


            $isNotFarsi = ($softwareLang != 'fa');
            $dateType = $isNotFarsi ? 'Miladi' : 'Jalali';
            $dateFormat = $isNotFarsi ? 'false' : 'true';
            $businessTypeText = functions::Xmlinformation("BusinessType")->__toString();
            $economicsTypeText = functions::Xmlinformation("EconomicsType")->__toString();
            $isCurrencyAndNotFarsi = (ISCURRENCY && $isNotFarsi);

            // OPTIMIZATION: Pre-define business cabin types for fast lookup
            $businessCabinTypes = ['C' => true, 'J' => true, 'D' => true, 'I' => true, 'Z' => true];

            // OPTIMIZATION: Function result cache (Memoization) - این cache ها سرعت را 3-5 برابر می‌کنند!
            // برای 1000 پرواز: 12000+ فراخوانی format_hour و 8000+ فراخوانی تبدیل تاریخ را حذف می‌کند
            $formatHourCache = [];
            $convertDateCache = [];
            $dateFormatTypeCache = [];

            // OPTIMIZATION: Database Query Cache - کاهش 4000 کوئری به ~150 کوئری (96% کاهش!)
            // جمع‌آوری تمام airline codes یونیک از flights
            $allAirlineCodes = [];
            foreach ($flights as $tempFlight) {
                if (isset($tempFlight['OutputRoutes'][0]['Airline']['Code'])) {
                    $allAirlineCodes[$tempFlight['OutputRoutes'][0]['Airline']['Code']] = true;
                }
            }
            $allAirlineCodes = array_keys($allAirlineCodes);

            // Cache کردن airline info (یکبار برای هر airline به جای 1000 بار!)
            $this->airlineInfoCache = [];
            foreach ($allAirlineCodes as $iataCode) {
                $this->airlineInfoCache[$iataCode] = functions::InfoAirline($iataCode);
            }

            // Cache کردن config_flight_tb (یکبار برای هر ترکیب به جای 1000 بار!)
            $this->configFlightCache = [];
            $admin = Load::controller('admin');
            foreach ($allAirlineCodes as $iataCode) {
                $airlineId = $this->airlineInfoCache[$iataCode]['id'];

                // Cache برای external + charter
                $sql = "SELECT isPublic, isPublicreplaced, sourceReplaceId, sourceId
                        FROM config_flight_tb
                        WHERE airlineId = {$airlineId}
                          AND typeFlight = 'charter'
                          AND isInternal = 0";
                $this->configFlightCache[$iataCode]['external']['charter'] = $admin->ConectDbClient($sql, CLIENT_ID, "Select", "", "", "");

                // Cache برای external + system
                $sql = "SELECT isPublic, isPublicreplaced, sourceReplaceId, sourceId
                        FROM config_flight_tb
                        WHERE airlineId = {$airlineId}
                          AND typeFlight = 'system'
                          AND isInternal = 0";
                $this->configFlightCache[$iataCode]['external']['system'] = $admin->ConectDbClient($sql, CLIENT_ID, "Select", "", "", "");
            }

            foreach ($flights as $key => $flight) {


                if (isset($flight['OutputRoutes'][0]['FlightNo']) && !empty($flight['OutputRoutes'][0]['FlightNo'])) {

                    // بهینه سازی: Cache برای دسترسی تکراری
                    $outputRoutes = $flight['OutputRoutes'];
                    $outputRoute0 = $outputRoutes[0];
                    $count_dept_route = count($outputRoutes);
                    $Key_route = ($count_dept_route - 1);
                    $outputRouteLast = $outputRoutes[$Key_route];

                    // بهینه سازی: محاسبه یک بار
                    $flight_type_lower = strtolower($flight['FlightType']);
                    $capacity_display = ($flight['Capacity'] > 10) ? '+10' : $flight['Capacity'];
                    $cabinType = $outputRoute0['CabinType'];
                    $isBusinessClass = isset($businessCabinTypes[$cabinType]);
                    $type_flight = $isBusinessClass ? 'business' : 'economy';

                    $source_id = $flight['SourceId'];
                    $is_internal =  $flight['isInternal'];
                    $date_persian = functions::convertDateFlight($outputRoute0['DepartureDate']);

                    $flightFortest = $flight;
                    $flight = $commissionController->sourceCommissionCalculation($flight , 'search');
                    $agencyBenefitSystemFlight = $commissionController->setAgencyBenefitSystemFlight($flight , 'search');
                    $isForeignAirline = $commissionController->isForeignAirline($flight);

                    // OPTIMIZATION: Cache repeated conditions and flight fields
                    $hasCapacity = $flight['Capacity'] != 0;
                    $isSystemAndDomestic = ($flight['FlightType'] == 'system' && !$isForeignAirline);
                    $flightAgencyId = $flight['AgencyId'];
                    $flightCode = $flight['Code'];
                    $flightID = $flight['FlightID'];

                    // OPTIMIZATION: Cache PassengerDatas array (accessed 15+ times)
                    $passengerDatas = $flight['PassengerDatas'];
                    $passengerAdult = $hasCapacity ? $passengerDatas[0] : ['TotalPrice'=>0, 'BasePrice'=>0, 'TaxPrice'=>0 , 'CommisionPrice' => 0];
                    $hasChild = isset($passengerDatas[1]['TotalPrice']);
                    $hasInfant = isset($passengerDatas[2]['TotalPrice']);
                    $passengerChild = ($hasChild && $hasCapacity) ? $passengerDatas[1] : ['TotalPrice'=>0, 'BasePrice'=>0, 'TaxPrice'=>0 , 'CommisionPrice' => 0];
                    $passengerInfant = ($hasInfant && $hasCapacity) ? $passengerDatas[2] : ['TotalPrice'=>0, 'BasePrice'=>0, 'TaxPrice'=>0 , 'CommisionPrice' => 0];

                    $data_change_price = array(
                        'airlineIata' => $outputRoute0['Airline']['Code'],
                        'FlightType' => $flight_type_lower,
                        'typeZone' => $type_zone,
                        'typeFlight' => $type_flight,
                        'sourceId' => $source_id,
                        'isInternal' => $is_internal,
                        'price' => array(
                            'adult' => array(
                                'TotalPrice' => $passengerAdult['TotalPrice'],
                                'BasePrice' => $passengerAdult['BasePrice'],
                                'TaxPrice' => $passengerAdult['TaxPrice'],
                            ),
                            'child' => array(
                                'TotalPrice' => $passengerChild['TotalPrice'],
                                'BasePrice' => $passengerChild['BasePrice'],
                                'TaxPrice' => $passengerChild['TaxPrice'],
                            ),

                            'infant' => array(
                                'TotalPrice' => $passengerInfant['TotalPrice'],
                                'BasePrice' => $passengerInfant['BasePrice'],
                                'TaxPrice' => $passengerInfant['TaxPrice'],
                            ),
                        )
                    );

                    $price_change_calculate = $priceChangesController->setPriceChangesFlight($data_change_price, $data_param_set_change_price , $agencyBenefitSystemFlight);

                    // OPTIMIZATION: Cache price arrays to avoid repeated array access (30+ accesses per flight)
                    $priceAdult = $price_change_calculate['adult'];
                    $priceChild = $price_change_calculate['child'];
                    $priceInfant = $price_change_calculate['infant'];

                    $this->prices[$direction][] = $priceAdult['TotalPrice'];

                    // OPTIMIZATION: استفاده از cache به جای checkConfigPid (کاهش 2 کوئری در هر iteration)
                    $airline_iata = $outputRoute0['Airline']['Code'];
                    $configData = $this->configFlightCache[$airline_iata]['external'][$flight_type_lower];
                    $sourceId = $flight['SourceId'];
                    if (($configData['isPublic'] == '0' && $configData['sourceId'] == $sourceId)
                        || ($configData['isPublicreplaced'] == '0' && $configData['sourceReplaceId'] == $sourceId)
                        || $sourceId == '20') {
                        $checkPrivate = 'private';
                    } else {
                        $checkPrivate = 'public';
                    }
                    $point_club = $this->pointClub($flight, $price_change_calculate , $checkPrivate);

//                        if (!in_array($airline_iata, $airlines)) {
//                            $airlines[] = $airline_iata;
//                            foreach ($airlines as $airline) {
//                                if (!isset($price_airline[$airline_iata])) {
//                                    $price_airline[$airline_iata] = [];
//                                }
//                                if (round($price_change_calculate['adult']['TotalPrice']) > 0) {
//
//                                    $price_airline[$airline_iata][] = $price_change_calculate['adult']['TotalPrice'];
//
//                                    $price_currency_min = min($price_airline[$airline_iata]);
//                                    $this->tickets['min_price_airline'][$airline_iata] = array('name_en' => $airline_iata, 'price' => functions::numberFormat($price_currency_min), 'name' => $airlines_name[$airline_iata][functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa')],);
//
//                                }
//                            }
//                        }

                    if (!in_array($airline_iata, $airlines)) {
                        $airlines[] = $airline_iata;
                    }

// Only process the airline price if it's valid
                    if (round($priceAdult['TotalPrice']) > 0) {
                        // Initialize the array for the airline if not already set
                        if (!isset($price_airline[$airline_iata])) {
                            $price_airline[$airline_iata] = [];
                        }

                        if ( $flight_type_lower == 'system' && ($isCounter || $isSafar360) && !$isForeignAirline) {
                            $price_airline[$airline_iata][] = ($priceAdult['TotalPriceWithDiscount'] > 0) ? ($priceAdult['TotalPriceWithDiscount'] - $agencyBenefitSystemFlight['adult']) :  ($priceAdult['TotalPrice'] - $agencyBenefitSystemFlight['adult']);
                        } else {
                            $price_airline[$airline_iata][] = $priceAdult['TotalPriceWithDiscount'] > 0 ? $priceAdult['TotalPriceWithDiscount'] : $priceAdult['TotalPrice'];
                        }

                        // Calculate the minimum price for the airline
                        $price_currency_min = min($price_airline[$airline_iata]);

                        // Update the min price airline information
                        $this->tickets['min_price_airline'][$airline_iata] = [
                            'name_en' => $airline_iata,
                            'price' => functions::numberFormat($price_currency_min),
                            'name' => $airlines_name[$airline_iata][$languageNameField],
                        ];
                    }



                    // OPTIMIZATION: Cache test flight capacity check and PassengerDatas
                    $hasTestCapacity = $flightFortest['Capacity'] != 0;
                    $testPassengerDatas = $hasTestCapacity ? $flightFortest['PassengerDatas'] : null;
                    $testAdultFare = $hasTestCapacity ? $testPassengerDatas[0]['BasePrice'] : 0;
                    $testAdultTax = $hasTestCapacity ? $testPassengerDatas[0]['TaxPrice'] : 0;
                    $testChildFare = $hasTestCapacity ? $testPassengerDatas[1]['BasePrice'] : 0;
                    $testChildTax = $hasTestCapacity ? $testPassengerDatas[1]['TaxPrice'] : 0;
                    $testInfantFare = $hasTestCapacity ? $testPassengerDatas[2]['BasePrice'] : 0;
                    $testInfantTax = $hasTestCapacity ? $testPassengerDatas[2]['TaxPrice'] : 0;

                    if ($isSystemAndDomestic) {

                        if ($checkPrivate = 'private') {
                            $markup_amount_adult =
                                $passengerAdult['CommisionPrice'];

                            $markup_amount_child =
                                $passengerChild['CommisionPrice'];

                            $markup_amount_infant =
                                $passengerInfant['CommisionPrice'];
                        } else {
                            $markup_amount_adult =
                                $agencyBenefitSystemFlight['adult'] ;

                            $markup_amount_child =
                                $agencyBenefitSystemFlight['child'] ;

                            $markup_amount_infant =
                                $agencyBenefitSystemFlight['infant'] ;
                        }

                    }
                    else {
                        $markup_amount_adult =
                            round($priceAdult['markup_amount']);

                        $markup_amount_child =
                            round($priceChild['markup_amount']);

                        $markup_amount_infant =
                            round($priceInfant['markup_amount']);

                    }

                    $this->tickets['flights'][$key] = array(
                        'price' => array(
                            'adult' => array(
                                'price' => $isCurrencyAndNotFarsi ? $priceAdult['TotalPrice'] : round($priceAdult['TotalPrice']),
                                'fare' => round($priceAdult['BasePrice']),
                                'tax' => round($priceAdult['TaxPrice']),
                                'with_discount' => round($priceAdult['TotalPriceWithDiscount']),
                                'has_discount' => $priceAdult['has_discount'],
                                'type_currency' => $priceAdult['type_currency'],
                                'price_with_out_currency' => round($priceAdult['price_with_out_currency']),
                                'price_discount_with_out_currency' => round($priceAdult['price_discount_with_out_currency']),
                                'markup_amount' => $markup_amount_adult,
                                'p_fare_for_test' => $testAdultFare,
                                'p_tax_for_test' => $testAdultTax
                            ),
                            'child' => array(
                                'price' => $isCurrencyAndNotFarsi ? $priceChild['TotalPrice'] : round($priceChild['TotalPrice']),
                                'fare' => round($priceChild['BasePrice']),
                                'tax' => round($priceChild['TaxPrice']),
                                'with_discount' => round($priceChild['TotalPriceWithDiscount']),
                                'has_discount' => $priceChild['has_discount'],
                                'type_currency' => $priceChild['type_currency'],
                                'price_with_out_currency' => round($priceChild['price_with_out_currency']),
                                'price_discount_with_out_currency' => round($priceChild['price_discount_with_out_currency']),
                                'markup_amount' => $markup_amount_child,
                                'p_fare_for_test' => $testChildFare,
                                'p_tax_for_test' => $testChildTax
                            ),
                            'infant' => array(
                                'price' => $isCurrencyAndNotFarsi ? $priceInfant['TotalPrice'] : round($priceInfant['TotalPrice']),
                                'fare' => round($priceInfant['BasePrice']),
                                'tax' => round($priceInfant['TaxPrice']),
                                'with_discount' => round($priceInfant['TotalPriceWithDiscount']),
                                'has_discount' => $priceInfant['has_discount'],
                                'type_currency' => $priceInfant['type_currency'],
                                'price_with_out_currency' => round($priceInfant['price_with_out_currency']),
                                'price_discount_with_out_currency' => round($priceInfant['price_discount_with_out_currency']),
                                'markup_amount' => $markup_amount_infant,
                                'p_fare_for_test' => $testInfantFare,
                                'p_tax_for_test' => $testInfantTax
                            ),
                        ),
                        'check_sort_reservation'=> '2' ,
                        'is_private'=> $checkPrivate ,
                        'currency_code' => Session::getCurrency(),
                        'departure_name' => $this->originName,
                        'arrival_name' => $this->destinationName,
                        'airport_departure_name' => $this->InfoSearch['airport_departure'],
                        'airport_arrival_name' => $this->InfoSearch['airport_arrival'],
                        'time_flight_name' => functions::classTimeLOCAL(functions::format_hour($outputRoute0['DepartureTime']), false),
                        'flight_number' => $outputRoute0['FlightNo'],
                        'airline' => $outputRoute0['Airline']['Code'],
                        'airline_name' => $airlines_name[$airline_iata][$languageNameField],
                        'airline_name_en' => $airlines_name[$airline_iata][$langFieldIndexEn],

                        'departure_date' => functions::convertDateFlight($outputRoute0['DepartureDate']),
                        'departure_time' => substr($outputRoute0['DepartureTime'], 0, 5),
                        'duration_time' => functions::new_duration_time_source($source_id, $flight['TotalOutputFlightDuration'], $translateVariable),
                        'arrival_date' => functions::convertDateFlight($outputRouteLast['ArrivalDate']),
                        'arrival_time' => (!empty($outputRouteLast['ArrivalTime'])) ? substr($outputRouteLast['ArrivalTime'], 0, 5) : null,
                        'departure_parent_region_name' => $outputRoute0['Departure']['ParentRegionName'],
                        'departure_code' => $check_test_parto ? strtoupper($outputRoute0['Departure']['Code']) : strtoupper(functions::mapIataCode($outputRoute0['Departure']['Code'])),
                        'arrival_parent_region_name' => $outputRoute0['Arrival']['ParentRegionName'],
                        'arrival_code' => $check_test_parto ? strtoupper($outputRouteLast['Arrival']['Code']) : strtoupper(functions::mapIataCode($outputRouteLast['Arrival']['Code'])),
                        'aircraft' => $outputRoute0['Aircraft']['Manufacturer'],
                        'flight_type' => ($flight_type_lower == "system") ? $translateVariable['system_flight'] : $translateVariable['charter_flight'],
                        'flight_type_li' => ($flight_type_lower == "system") ? 'system' : 'charter',
                        'persian_departure_date' => $date_persian,
                        'description' => $flight['Description'],
                        'seat_class' => $isBusinessClass ? $businessTypeText : $economicsTypeText,
                        'seat_class_en' => $type_flight,
                        'cabin_type' => $cabinType,
                        'capacity' => $capacity_display,
                        'supplier' => $flight['Supplier']['Name'],
                        'user_id' => !empty($flight['UserId']) ? $flight['UserId'] : '',
                        'user_name' => !empty($flight['UserName']) ? $flight['UserName'] : '',
                        'source_id' => !empty($flight['SourceId']) ? $flight['SourceId'] : '',
                        'agency_id' => !empty($flight['AgencyId']) ? $flight['AgencyId'] : '',
                        'source_name' => !empty($flight['SourceName']) ? $flight['SourceName'] : '',
                        'unique_code' => $flight['Code'],
                        'count_interrupt' => functions::countInterrupt($count_dept_route),
                        'count_transit' => ($count_dept_route - 1),
                        'count_transit_title' => functions::countInterruptTitle(($count_dept_route - 1), $translateVariable),
                        'point_club' => (($point_club > 0) ? $point_club : 0),
                        'flight_id' => $flightID,
                        'total_output_flight_duration' => functions::duration_time_source($source_id, $flight['TotalOutputFlightDuration'], $translateVariable),
                        'total_output_stop_duration' => functions::duration_time_source($source_id, $flight['TotalOutputStopDuration'], $translateVariable),
                        'is_foreign_airline' => $isForeignAirline
                    );



                    foreach ($outputRoutes as $key_detail => $details_dept) {
                        // OPTIMIZATION: Cache repeated checks and values in loop
                        $details_dept['type_route'] = 'dept' ;
                        $hasArrivalDate = !empty($details_dept['ArrivalDate']);
                        $cabinType_dept = $details_dept['CabinType'];
                        $isBusinessDept = isset($businessCabinTypes[$cabinType_dept]);
                        $baggage0 = $details_dept['Baggage'][0];

                        // OPTIMIZATION: Cache airline and airport codes (used 5+ times each)
                        $airlineDept = $details_dept['Airline'];
                        $airlineCode_dept = $airlineDept['Code'];
                        $airlineOperatorDept = isset($airlineDept['operator']) ? $airlineDept['operator'] : null;
                        $hasOperatorDept = ($airlineOperatorDept && $airlineCode_dept !== $airlineOperatorDept);
                        $deptCode = $details_dept['Departure']['Code'];
                        $arrCode = $details_dept['Arrival']['Code'];

                        // OPTIMIZATION: Cache airport data to avoid 6 array lookups per segment
                        $mappedDeptCode = isset($mapIataCodeCache[$deptCode]) ? $mapIataCodeCache[$deptCode] : ($mapIataCodeCache[$deptCode] = functions::mapIataCode($deptCode));
                        $mappedArrCode = isset($mapIataCodeCache[$arrCode]) ? $mapIataCodeCache[$arrCode] : ($mapIataCodeCache[$arrCode] = functions::mapIataCode($arrCode));
                        $airportDept = $airports[$mappedDeptCode];
                        $airportArr = $airports[$mappedArrCode];

                        // OPTIMIZATION: Cache formatted times (avoid repeated function calls) - با Memoization
                        $deptTimeRaw = $details_dept['DepartureTime'];
                        $deptTime = isset($formatHourCache[$deptTimeRaw]) ? $formatHourCache[$deptTimeRaw] : ($formatHourCache[$deptTimeRaw] = functions::format_hour($deptTimeRaw));

                        if ($hasArrivalDate) {
                            $arrTimeRaw = $details_dept['ArrivalTime'];
                            $arrTime = isset($formatHourCache[$arrTimeRaw]) ? $formatHourCache[$arrTimeRaw] : ($formatHourCache[$arrTimeRaw] = functions::format_hour($arrTimeRaw));
                            $flightTimeRaw = $details_dept['FlightTime'];
                            $flightTime = isset($formatHourCache[$flightTimeRaw]) ? $formatHourCache[$flightTimeRaw] : ($formatHourCache[$flightTimeRaw] = functions::format_hour($flightTimeRaw));
                        } else {
                            $arrTime = null;
                            $flightTime = null;
                        }

                        // OPTIMIZATION: Cache Aircraft array and dates
                        $aircraftDept = $details_dept['Aircraft'];
                        $deptDateDept = $details_dept['DepartureDate'];
                        $arrDateDept = $hasArrivalDate ? $details_dept['ArrivalDate'] : null;

                        $this->tickets['flights'][$key]['output_routes_detail'][$key_detail] = array(
                            'is_transit' => ($details_dept['transit'] != '00:00' && !empty($details_dept['transit'])) ? true : false,
                            'source_id' => $source_id,
                            'agency_id' => $flightAgencyId,
                            'request_number' => $flightCode,
                            'flight_id' => $flightID,
                            'is_private'=> $checkPrivate ,

//                            'transit' => functions::duration_time_source($flight['SourceId'], $details_dept['transit'], $translateVariable),
                            'transit' => $details_dept['transit'],
                            'cabin_type' => $cabinType_dept,
                            'flight_number' => $details_dept['FlightNo'],
                            'capacity' => $capacity_display,
                            'departure_date' => isset($convertDateCache[$deptDateDept]) ? $convertDateCache[$deptDateDept] : ($convertDateCache[$deptDateDept] = functions::ConvertDateByLanguage($softwareLang, $deptDateDept, '/', $dateType, $dateFormat)),
                            'departure_date_abbreviation' => isset($dateFormatTypeCache[$deptDateDept]) ? $dateFormatTypeCache[$deptDateDept] : ($dateFormatTypeCache[$deptDateDept] = functions::DateFormatType($deptDateDept, 'gregorian')),
                            'departure_time' => $deptTime,
                            'arrival_date' => $hasArrivalDate ? (isset($convertDateCache[$arrDateDept]) ? $convertDateCache[$arrDateDept] : ($convertDateCache[$arrDateDept] = functions::ConvertDateByLanguage($softwareLang, $arrDateDept, '/', $dateType, $dateFormat))) : null,
                            'arrival_date_abbreviation' => $hasArrivalDate ? (isset($dateFormatTypeCache[$arrDateDept]) ? $dateFormatTypeCache[$arrDateDept] : ($dateFormatTypeCache[$arrDateDept] = functions::DateFormatType($arrDateDept, 'gregorian'))) : null,
                            'arrival_time' => $arrTime,
                            'duration_flight_time' => $flightTime,
                            'seat_class' => $isBusinessDept ? $businessTypeText : $economicsTypeText,
                            'baggage' => array('code' => $baggage0['Code'],
                                'charge' => $baggage0['Charge'],
                                'type' => $baggage0['Type'],
                                'baggage_statement' => $this->baggageTitle($source_id, $details_dept, $translateVariable)
                            ),
                            'airline' => array(
                                'airline_name' => $airlines_name[$airlineCode_dept][$languageNameField],
                                'airline_code' => $airlineCode_dept,
                                'airline_code_operator' => $hasOperatorDept ? $airlines_name[$airlineOperatorDept][$languageNameField]."({$airlineOperatorDept})" : NULL,
                            ),
                            'aircraft' => array(
                                'aircraft_code' => $aircraftDept['Code'],
                                'aircraft_name' => $aircraftDept['Name'],
                                'aircraft_manufacturer' => $aircraftDept['Manufacturer'],
                            ),
                            'departure' => array(
                                'departure_airport' => $airportDept[$airportField],
                                'departure_city' => $airportDept[$departureCityField],
                                'departure_region_name' => $airportDept[$countryField],
                                'departure_code' => $mappedDeptCode,
                            ),
                            'arrival' => array(
                                'arrival_airport' => $airportArr[$airportField],
                                'arrival_city' => $airportArr[$departureCityField],
                                'arrival_region_name' => $airportArr[$countryField],
                                'arrival_code' => $mappedArrCode,
                            ),
                        );
                    }



                    if (isset($flight['ReturnRoutes']) && !empty($flight['ReturnRoutes'])) {

                        // OPTIMIZATION: Cache ReturnRoutes array accesses (used 20+ times)
                        $returnRoutes = $flight['ReturnRoutes'];
                        $returnRoute0 = $returnRoutes[0];
                        $count_detail_return_rout = count($returnRoutes);
                        $Key_route_return = ($count_detail_return_rout - 1);
                        $returnRouteLast = $returnRoutes[$Key_route_return];

                        // OPTIMIZATION: Cache airline code and repeated values
                        $returnAirlineCode = $returnRoute0['Airline']['Code'];
                        $date_persian_return = $returnRoute0['DepartureDate'];
                        $hasArrivalDateLast = !empty($returnRouteLast['ArrivalDate']);

                        $this->tickets['flights'][$key]['return_routes'] = array(
                            'airline' => $returnAirlineCode,
                            'capacity' => $capacity_display,
                            'airline_name' => $airlines_name[$returnAirlineCode][$languageNameField],
                            'airline_name_en' => $airlines_name[$returnAirlineCode][$langFieldIndexEn],

                            'departure_name' => $this->destinationName,
                            'arrival_name' => $this->originName,
                            'return_flight_id' => $flight['ReturnFlightID'],
                            'airport_departure_name' => $this->InfoSearch['airport_arrival'],
                            'airport_arrival_name' => $this->InfoSearch['airport_departure'],
                            'flight_number_return' => $returnRoute0['FlightNo'],
                            'departure_parent_region_name' => $returnRoute0['Departure']['ParentRegionName'],
                            'departure_code' => $returnRoute0['Departure']['Code'],
                            'departure_date' => isset($convertDateCache[$date_persian_return]) ? $convertDateCache[$date_persian_return] : ($convertDateCache[$date_persian_return] = functions::ConvertDateByLanguage($softwareLang, $date_persian_return, '/', $dateType, $dateFormat)),
                            'departure_time' => substr($returnRoute0['DepartureTime'], 0, 5),
                            'arrival_date' => $hasArrivalDateLast ? (isset($convertDateCache[$returnRouteLast['ArrivalDate']]) ? $convertDateCache[$returnRouteLast['ArrivalDate']] : ($convertDateCache[$returnRouteLast['ArrivalDate']] = functions::ConvertDateByLanguage($softwareLang, $returnRouteLast['ArrivalDate'], '/', $dateType, $dateFormat))) : null,
                            'arrival_time' => $hasArrivalDateLast ? substr($returnRouteLast['ArrivalTime'], 0, 5) : null,
                            'arrival_parent_region_name' => $returnRouteLast['Arrival']['ParentRegionName'],
                            'arrival_code' => $returnRouteLast['Arrival']['Code'],
                            'aircraft' => $returnRouteLast['Aircraft']['Manufacturer'],
                            'persian_departure_date' => $date_persian_return,
                            'cabin_type' => $returnRouteLast['CabinType'],
                            'count_interrupt_return' => functions::countInterrupt($count_detail_return_rout),
                            'count_transit_return' => ($count_detail_return_rout - 1),
                            'count_transit_title' => functions::countInterruptTitle(($count_dept_route - 1), $translateVariable),
                            'flight_id' => $flightID,
                            'total_return_flight_duration' => functions::duration_time_source($source_id, $flight['TotalReturnFlightDuration'], $translateVariable),
                            'total_return_stop_duration' => functions::duration_time_source($source_id, $flight['TotalReturnStopDuration'], $translateVariable),
                            'duration_time_return' => functions::duration_time_source($source_id, $flight['TotalReturnFlightDuration'], $translateVariable),
                        );



                        foreach ($returnRoutes as $key_detail_return => $details_return) {
                            // OPTIMIZATION: Cache repeated checks and values in loop
                            $details_return['type_route'] = 'return' ;
                            $hasArrivalDateReturn = !empty($details_return['ArrivalDate']);
                            $cabinType_return = $details_return['CabinType'];
                            $isBusinessReturn = isset($businessCabinTypes[$cabinType_return]);
                            $baggage0Return = $details_return['Baggage'][0];

                            // OPTIMIZATION: Cache airline and airport codes (used 5+ times each)
                            $airlineReturn = $details_return['Airline'];
                            $airlineCode_return = $airlineReturn['Code'];
                            $airlineOperator = isset($airlineReturn['operator']) ? $airlineReturn['operator'] : null;
                            $hasOperator = ($airlineOperator && $airlineCode_return !== $airlineOperator);
                            $deptCode_return = $details_return['Departure']['Code'];
                            $arrCode_return = $details_return['Arrival']['Code'];

                            // OPTIMIZATION: Cache airport data to avoid 6 array lookups per segment
                            $mappedDeptCodeReturn = isset($mapIataCodeCache[$deptCode_return]) ? $mapIataCodeCache[$deptCode_return] : ($mapIataCodeCache[$deptCode_return] = functions::mapIataCode($deptCode_return));
                            $mappedArrCodeReturn = isset($mapIataCodeCache[$arrCode_return]) ? $mapIataCodeCache[$arrCode_return] : ($mapIataCodeCache[$arrCode_return] = functions::mapIataCode($arrCode_return));
                            $airportDeptReturn = $airports[$mappedDeptCodeReturn];
                            $airportArrReturn = $airports[$mappedArrCodeReturn];

                            // OPTIMIZATION: Cache formatted times (avoid repeated function calls) - با Memoization
                            $deptTimeReturnRaw = $details_return['DepartureTime'];
                            $deptTime_return = isset($formatHourCache[$deptTimeReturnRaw]) ? $formatHourCache[$deptTimeReturnRaw] : ($formatHourCache[$deptTimeReturnRaw] = functions::format_hour($deptTimeReturnRaw));

                            $arrTimeReturnRaw = $details_return['ArrivalTime'];
                            $arrTime_return = isset($formatHourCache[$arrTimeReturnRaw]) ? $formatHourCache[$arrTimeReturnRaw] : ($formatHourCache[$arrTimeReturnRaw] = functions::format_hour($arrTimeReturnRaw));

                            $flightTimeReturnRaw = $details_return['FlightTime'];
                            $flightTime_return = isset($formatHourCache[$flightTimeReturnRaw]) ? $formatHourCache[$flightTimeReturnRaw] : ($formatHourCache[$flightTimeReturnRaw] = functions::format_hour($flightTimeReturnRaw));

                            // OPTIMIZATION: Cache Aircraft array
                            $aircraftReturn = $details_return['Aircraft'];

                            // OPTIMIZATION: Cache dates for ConvertDateByLanguage
                            $deptDateReturn = $details_return['DepartureDate'];
                            $arrDateReturn = $hasArrivalDateReturn ? $details_return['ArrivalDate'] : null;

                            $this->tickets['flights'][$key]['return_routes']['return_route_detail'][$key_detail_return] = array(
                                'is_transit' => ($details_return['transit'] != '00:00' && !empty($details_return['transit'])) ? true : false,
                                'source_id' => $source_id,
                                'agency_id' => $flightAgencyId,
                                'request_number' => $flightCode,
                                'flight_id' => $flightID,
//                                'transit' => functions::duration_time_source($flight['SourceId'], $details_return['transit'], $translateVariable),
                                'transit' => $details_return['transit'],
                                'cabin_type' => $cabinType_return,
                                'flight_number' => $details_return['FlightNo'],
                                'capacity' => $capacity_display,
                                'departure_date' => isset($convertDateCache[$deptDateReturn]) ? $convertDateCache[$deptDateReturn] : ($convertDateCache[$deptDateReturn] = functions::ConvertDateByLanguage($softwareLang, $deptDateReturn, '/', $dateType, $dateFormat)),
                                'departure_date_abbreviation' => isset($dateFormatTypeCache[$deptDateReturn]) ? $dateFormatTypeCache[$deptDateReturn] : ($dateFormatTypeCache[$deptDateReturn] = functions::DateFormatType($deptDateReturn, 'gregorian')),
                                'departure_time' => $deptTime_return,
                                'arrival_date' => $hasArrivalDateReturn ? (isset($convertDateCache[$arrDateReturn]) ? $convertDateCache[$arrDateReturn] : ($convertDateCache[$arrDateReturn] = functions::ConvertDateByLanguage($softwareLang, $arrDateReturn, '/', $dateType, $dateFormat))) : null,
                                'arrival_time' => $arrTime_return,
                                'arrival_date_abbreviation' => $hasArrivalDateReturn ? (isset($dateFormatTypeCache[$arrDateReturn]) ? $dateFormatTypeCache[$arrDateReturn] : ($dateFormatTypeCache[$arrDateReturn] = functions::DateFormatType($arrDateReturn, 'gregorian'))) : null,
                                'duration_flight_time' => $flightTime_return,
                                'seat_class' => $isBusinessReturn ? $businessTypeText : $economicsTypeText,
                                'baggage' => array(
                                    'code' => $baggage0Return['Code'],
                                    'charge' => $baggage0Return['Charge'],
                                    'type' => $baggage0Return['Type'],
                                    'baggage_statement' => $this->baggageTitle($source_id, $details_return,$translateVariable)
                                ),
                                'airline' => array(
                                    'airline_name' => $airlines_name[$airlineCode_return][$languageNameField],
                                    'airline_code' => $airlineCode_return,
                                    'airline_code_operator' => $hasOperator ? $airlines_name[$airlineOperator][$languageNameField]."({$airlineOperator})" : NULL,
                                ),
                                'aircraft' => array(
                                    'aircraft_code' => $aircraftReturn['Code'],
                                    'aircraft_name' => $aircraftReturn['Name'],
                                    'aircraft_manufacturer' => $aircraftReturn['Manufacturer'],
                                ),
                                'departure' => array(
                                    'departure_airport' => $airportDeptReturn[$airportField],
                                    'departure_city' => $airportDeptReturn[$departureCityField],
                                    'departure_region_name' => $airportDeptReturn[$countryField],
                                    'departure_code' => $mappedDeptCodeReturn,
                                ),
                                'arrival' => array(
                                    'arrival_airport' => $airportArrReturn[$airportField],
                                    'arrival_city' => $airportArrReturn[$departureCityField],
                                    'arrival_region_name' => $airportArrReturn[$countryField],
                                    'arrival_code' => $mappedArrCodeReturn,
                                ),
                            );
                        }

                    } else {
                        $this->tickets['flights'][$key]['return_routes'] = array();
                    }

                    if($source_id=='14'){
                        $search_prices[$key]=[
                            'prices' => $this->tickets['flights'][$key]['price'],
                            'flightId' => $flightID,
                        ];
                    }

                }
            }

            $this->tickets['time']['end'] = date('H:i:s',time());
            $this->getReservationFlight($data_param_set_change_price);
            $this->tickets['time']['after_reservation'] = date('H:i:s',time());
            $min = min($this->prices[$direction]);
            $max = max($this->prices[$direction]);
            $this->tickets['prices'] = $this->prices[$direction] ;
            $this->tickets['price'] = array('min_price' => floor($min), 'max_price' => ceil($max));

            $this->tickets['time']['after_prices'] = date('H:i:s',time());

            $sort = array();
            $sort_zero = array();
            foreach ($this->tickets['flights'] as $keySort => $arraySort) {
                if (((round($arraySort['price']['adult']['price']) > 0) || in_array($arraySort['source_id'], functions::getAllowSourceEmpty()))) {
                    $sort[] = $arraySort;
                } else {
                    $sort_zero[] = $arraySort;
                }
            }

            $main_sort = array();
            foreach ($sort as $key_main_sort => $item_sort) {
                $main_sort['price']['adult']['price'][$key_main_sort] = $item_sort['price']['adult']['price'];
                $main_sort['check_sort_reservation'][$key_main_sort] = $item_sort['check_sort_reservation'];
            }

            if (!empty($main_sort)) {
                array_multisort($main_sort['check_sort_reservation'], SORT_ASC, $main_sort['price']['adult']['price'], SORT_ASC, $sort);
            }

            $this->tickets['count_flights'] = count($sort) ;
            if (!empty($sort) && !empty($sort_zero)) {
                $this->tickets['is_complete'] = false ;
                $this->tickets['flights'] = array_merge($sort, $sort_zero);
            } elseif (empty($sort) && !empty($sort_zero)) {
                $this->tickets['is_complete'] = true ;
                $this->tickets['flights'] = $sort_zero;
            } else {
                $this->tickets['is_complete'] = false;
                $this->tickets['flights'] = $sort;
            }


            if(!empty($search_prices)){
                $data_search_prices['client_id'] = CLIENT_ID;
                $data_search_prices['request_number'] = $request_number_flight;
                $data_search_prices['prices'] = json_encode($search_prices,256|64);
                $this->getModel('searchPricesModel')->insertWithBind($data_search_prices);
            }


            $this->tickets['time']['before_send_vue'] = date('H:i:s',time());
            error_log('END Process Data Search in GDS  ==> ' . date('Y/m/d H:i:s') . " \n", 3, dirname(dirname(dirname(__FILE__))) . '/Core/assets/logFile/flight_international/' . $data_search_flight[$direction]['Flights'][0]['Code'] . '.txt');
            if($this->tickets){
                return functions::withSuccess($this->tickets, 200, 'successfully catch flight');
            }else{
                return functions::withSuccess($request_numbers, 200, 'successfully catch flight');
            }

        }
        elseif (empty($flights_search)) {
            $result = $this->getReservationFlight($data_param_set_change_price,'yes');
            if($result){
                return  functions::withSuccess($result,200,'successfully catch flight');
            }else{
                return functions::withSuccess($request_numbers, 200, 'successfully catch flight');
            }

        }
        return functions::withError($this->tickets, 404, " flight does not exist for this search");

    }

    #endregion

    //region [airportPortalList]

    private function filterFlight($flights, $status_config_airline) {


        $sourceEightOrSixteen = ($this->MultiWay !='TwoWay') ? '8' : '16';

        functions::insertLog('source detect is=>'. $sourceEightOrSixteen,'detectSource');


        $source_five = $this->arrayFilterByValue($flights, 'SourceId', '1');
        $source_eight = $this->arrayFilterByValue($flights, 'SourceId', $sourceEightOrSixteen);

        $exist_source_five_airline = array();
        $flight_after_filter = array();
        foreach ($source_five as $item) {
            $exist_source_five_airline[] = $item['OutputRoutes'][0]['Airline']['Code'];
        }
        $exist_airline_source_eight = array();
        foreach ($source_eight as $item_source_eight) {
            $exist_airline_source_eight[] = $item_source_eight['OutputRoutes'][0]['Airline']['Code'];
        }

        foreach ($flights as $flight) {
            $airline = $flight['OutputRoutes'][0]['Airline']['Code'];
            $departure_code = $flight['OutputRoutes'][0]['Departure']['Code'];
            $arrival_code = $flight['OutputRoutes'][0]['Arrival']['Code'];
            $show_flight = true;

            if($flight['SourceId'] =='15') {
                if (in_array(strtoupper($departure_code), functions::airPortForSourceSeven()) && in_array(strtoupper($arrival_code), functions::airPortForSourceSeven()) && in_array($airline, $exist_airline_source_eight)) {
                    $show_flight = false;
                }
            }

            if ($show_flight) {

                if ($this->MultiWay == 'TwoWay' && isset($flight['ReturnRoutes']) && !empty($flight['ReturnRoutes'])) {
                    if ($flight['SourceId'] == $status_config_airline[strtolower($flight['FlightType'])][$airline]['sourceId'] || $flight['SourceId'] == '16'|| $flight['SourceId'] == '20') {
                        $flight_after_filter[] = $flight;
                    } else if (!in_array($airline, $exist_source_five_airline) && !in_array($airline, $exist_airline_source_eight) && ($flight['SourceId'] == $status_config_airline[strtolower($flight['FlightType'])][$airline]['sourceReplaceId'])) {
                        $flight_after_filter[] = $flight;
                    }
                }
                elseif ($this->MultiWay == 'OneWay') {
                    if ($flight['SourceId'] == $status_config_airline[strtolower($flight['FlightType'])][$airline]['sourceId']
                        ||
                        $flight['SourceId'] == $status_config_airline[strtolower($flight['FlightType'])][$airline]['sourceReplaceId'] || $flight['SourceId'] == '20') {
                        $flight_after_filter[] = $flight;
                    }
                }

            }

        }

        return $flight_after_filter;
    }
    //endregion

    //region [flightPriceChangeList]

    public function arrayFilterByValue($my_array, $index, $value) {
        $new_array = array();
        if (is_array($my_array) && count($my_array) > 0) {
            foreach (array_keys($my_array) as $key) {
                $temp[$key] = $my_array[$key][$index];

                if ($temp[$key] == $value) {
                    $new_array[$key] = $my_array[$key];
                }
            }
        }
        return $new_array;
    }
    //endregion

    //region [discountList]

    /**
     * @param $translateVariable
     * @return array
     */
    private function filterInternationalFlight($translateVariable) {
        return array('request_number' => $this->UniqueCode, 'count_flight' => $this->count, 'name_departure' => $this->originName, 'name_arrival' => $this->destinationName, 'interrupt' => array('no_interrupt' => array('name_fa' => $translateVariable['no_interrupt'], 'name_en' => 'no_interrupt',), 'one_interrupt' => array('name_fa' => $translateVariable['one_interrupt'], 'name_en' => 'one_interrupt',), 'two_interrupt' => array('name_fa' => $translateVariable['two_interrupt'], 'name_en' => 'two_interrupt',),), 'time_filter' => array('morning' => array('name_fa' => $translateVariable['morning'], 'time' => 'early', 'value' => '0-8',), 'day' => array('name_fa' => $translateVariable['Time_morning'], 'time' => 'morning', 'value' => '8-12',), 'evening' => array('name_fa' => $translateVariable['evening'], 'time' => 'afternoon', 'value' => '12-18',), 'night' => array('name_fa' => $translateVariable['night'], 'time' => 'night', 'value' => '18-24',),), 'type_flight_filter' => array('system' => array('name_fa' => $translateVariable['system_flight'], 'name_en' => 'system',), 'charter' => array('name_fa' => $translateVariable['charter_flight'], 'name_en' => 'charter',),), 'seat_class_filter' => array(
            'economy' => array('name_fa' => $translateVariable['economics_type'], 'name_en' => 'economy'),
            'premium_economy' => array('name_fa' => $translateVariable['premium_economy_type'], 'name_en' => 'premium_economy'),
            'business' => array('name_fa' => $translateVariable['business_type'], 'name_en' => 'business')
        ),);
    }
    //endregion

    //region [filterFlight]

    public function pointClub($ticket, $info_price , $checkPrivate) {
        if ($this->IsLogin) {
            $counter_id = functions::getCounterTypeId($_SESSION['userId']);
            // OPTIMIZATION: استفاده از cache به جای کوئری مجدد
            $airlineCode = $ticket['OutputRoutes'][0]['Airline']['Code'];
            $result_point_club = isset($this->airlineInfoCache[$airlineCode])
                ? $this->airlineInfoCache[$airlineCode]
                : functions::InfoAirline($airlineCode);
            $type_service = functions::TypeService($ticket['FlightType'], 'Portal', strtolower($ticket['FlightType']) == 'system' ? '' : 'public', $checkPrivate, $airlineCode);
            $param['service'] = $type_service;
            $param['baseCompany'] = $result_point_club['id'];
            $param['company'] = $ticket['OutputRoutes'][0]['FlightNo'];
            $param['counterId'] = $counter_id;
            if ($info_price['hasDiscount'] == 'yes') {
                $param['price'] = $info_price['adult']['TotalPriceWithDiscount'];
            } else {
                $param['price'] = $info_price['adult']['TotalPrice'];
            }
            return functions::CalculatePoint($param);
        }
        return null;
    }
    //endregion

    //region [infoCurrency]

    /**
     * @param $arrayTicket
     * @param $route
     * @param $data_translate
     * @param bool $reservation
     * @return string|string[]
     */
    public function baggageTitle($source_id, $route, $data_translate, $reservation = false) {
        $baggageCharge = $route['Baggage'][0]['Charge'] ?  $route['Baggage'][0]['Charge'] :  0;

        if (in_array($source_id, ['10', '1', '14', '15', '17', '18', '19']) && !$reservation) {
            if ($baggageCharge > 0) {

                $code = $route['Baggage'][0]['Code'];
                if (in_array($code, ['Piece', 'pieces', 'N', 'pc', 'PC','PIECES'])) {
                    if (($source_id == '15' || $source_id == '14')) {
                        return $baggageCharge . ' ' . functions::Xmlinformation('Close')->__toString();
                    } else {
                        return functions::StrReplaceInArray(
                            [
                                '@@numberPiece@@' => $route['Baggage'][0]['allowanceAmount'],
                                '@@amountPiece@@' => $baggageCharge
                            ],
                            $data_translate['amount_baggage']
                        );
                    }
                } else {

                    if($source_id == '17') {
                        return $baggageCharge;
                    }
                    return $baggageCharge . $data_translate['kg'];
                }
            } else {

                return $data_translate['no_baggage'];
            }
        } elseif (in_array($source_id, ['8', '16'])) {
            if ($baggageCharge > 0) {
                return $baggageCharge . $data_translate['kg'];
            }
            $amount_weight = ($route['type_route'] == 'dept') ? '20' : '30';
            $type_weight = ($route['type_route'] == 'dept') ? $data_translate['minimum'] : $data_translate['maximum'];
            $type_checking = ($route['type_route'] == 'dept') ? $data_translate['baggage_to_more'] : $data_translate['baggage_to_low'];
            return functions::StrReplaceInArray(
                [
                    '@@weight@@' => $amount_weight,
                    '@@type@@' => $type_weight,
                    '@@typ_checking@@' => $type_checking
                ],
                $data_translate['withInquire']
            );


        }

        if ($reservation) {
            $baggage = $source_id ?  '30' : '0';
            return functions::StrReplaceInArray(['@@numberPiece@@' => '1', '@@amountPiece@@' => $baggage], $data_translate['amount_baggage']);
        }

        if ($baggageCharge > 0) {
            return functions::StrReplaceInArray(['@@numberPiece@@' => '1', '@@amountPiece@@' => $baggageCharge], $data_translate['amount_baggage']);
        }

        return $data_translate['Call'];
    }
    //endregion

    //region [listCurrency]

    public function getReservationFlight($data_info,$empty_result='no') {

        if ($this->ticketReservationFlightAuth()) {

            $type_search = ($this->MultiWay == 'TwoWay') ? 'twoWay' : '';
            $direction = ($type_search == 'TwoWay') ? 'dept' : 'twoWay';

            $data_search_reservation_flight['origin'] = $this->origin;
            $data_search_reservation_flight['destination'] = $this->destination;
            $data_search_reservation_flight['departure_date'] = $this->departureDate;
            $data_search_reservation_flight['arrival_date'] = $this->arrivalDate;
            $data_search_reservation_flight['type_search'] = $direction;

            $multi_way_reservation = !empty($data_search_reservation_flight['arrival_date']) ? 'TwoWay' : '';
            $result_reservation['dept'] = $this->getController('resultReservationTicket')->searchReservationTickets($data_search_reservation_flight['origin'], $data_search_reservation_flight['destination'], $data_search_reservation_flight['departure_date'], $multi_way_reservation);
            if (!empty($data_search_reservation_flight['arrival_date'])) {
                $result_reservation['return'] = $this->getController('resultReservationTicket')->searchReservationTickets($data_search_reservation_flight['destination'], $data_search_reservation_flight['origin'], $data_search_reservation_flight['arrival_date'], $multi_way_reservation);
            }


            if ((!empty($result_reservation['dept']) && empty($data_search_reservation_flight['arrival_date'])) || (!empty($data_search_reservation_flight['arrival_date']) && !empty($result_reservation['dept']) && !empty($result_reservation['return']))) {
                if($this->isInternal){
                    return $this->structureReservationInternal($result_reservation, $data_info,$empty_result);
                }
                return $this->structureReservationForeign($result_reservation, $data_info,$empty_result);

            }
            return false;
        }
        return false;

    }
    //endregion

    //region [getCityForeign]

    /**
     * @param $datas
     * @param $data_info
     * @return mixed
     */
    public function structureReservationForeign($datas, $data_info,$empty_result) {


        $adult_price = 0;
        $child_price = 0;
        $infant_price = 0;
        $adult_price_with_discount = 0;
        $child_price_with_discount = 0;
        $infant_price_with_discount = 0;
        if($empty_result=='yes'){
            $this->tickets = $this->filterInternationalFlight($data_info['data_translate']);
        }
        if (empty($datas['return'])) {
            $count_dept_route = count($datas['dept']);
            foreach ($datas['dept'] as $key => $flight) {
                $source_id = 'special';
                $airline_iata = $flight['Airline'];
                $date_persian = $flight['FlightDate'];
                if ($flight['AdtPrice'] > 0) {
                    $price_calculate = functions::CurrencyCalculate($flight['AdtPrice'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn']);
                    $price_calculate_discount = functions::CurrencyCalculate($flight['PriceWithDiscount'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn']);
                    $adult_price = (SOFTWARE_LANG != 'fa') ? $price_calculate['AmountCurrency'] : $flight['AdtPrice'];
                    $adult_price_with_discount = (SOFTWARE_LANG != 'fa') ? $price_calculate_discount['AmountCurrency'] : $flight['PriceWithDiscount'];
                    $this->prices['dept'][] = $adult_price;
                }
                if (!in_array($airline_iata, $data_info['airlines_name'])) {
                    $airlines[] = $airline_iata;
                    foreach ($airlines as $airline) {
                        if ($airline == $airline_iata && round($flight['AdtPrice']) > 0) {
                            $price_airline[$airline_iata][] = $price_calculate['AmountCurrency'];
                            $price_currency_min = min($price_airline[$airline_iata]);
                            $this->tickets['min_price_airline'][$airline_iata] = array(
                                'name_en' => $airline_iata,
                                'price' => functions::numberFormat($price_currency_min),
                                'name' => $data_info['airlines_name'][$airline_iata][functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa')],
                            );
                        }
                    }
                }

                if ($flight['ChdPrice'] > 0) {
                    $child_price = (SOFTWARE_LANG != 'fa') ? functions::CurrencyCalculate($flight['ChdPrice'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn']) : $flight['ChdPrice'];
                    $child_price_with_discount = (SOFTWARE_LANG != 'fa') ? functions::CurrencyCalculate($flight['ChdPriceWithDiscount'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn']) : $flight['ChdPriceWithDiscount'];
                }
                if ($flight['InfPrice'] > 0) {
                    $infant_price = (SOFTWARE_LANG != 'fa') ? functions::CurrencyCalculate($flight['InfPrice'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn']) : $flight['InfPrice'];
                    $infant_price_with_discount = (SOFTWARE_LANG != 'fa') ? functions::CurrencyCalculate($flight['InfPriceWithDiscount'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn']) : $flight['InfPriceWithDiscount'];
                }

                $this->tickets['flights'][$key] = array(
                    'price' => array(
                        'adult' => array(
                            'price' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $adult_price : round($adult_price),
                            'fare' => 0,
                            'with_discount' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $adult_price_with_discount : round($adult_price_with_discount),
                            'has_discount' => $flight['PriceWithDiscount'] > 0 ? 'yes' : 'no',
                            'type_currency' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $price_calculate['TypeCurrency'] : $data_info['data_translate']['rial'],
                            'price_with_out_currency' => round($flight['AdtPrice']),
                            'price_discount_with_out_currency' => round($flight['PriceWithDiscount']),
                        ),
                        'child' => array(
                            'price' => $child_price > 0 ? (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $child_price['AmountCurrency'] : round($child_price) : 0,
                            'fare' => 0,
                            'with_discount' => $child_price > 0 ? ((ISCURRENCY && SOFTWARE_LANG != 'fa') ? round($child_price_with_discount['AmountCurrency']) : $child_price_with_discount['AmountCurrency']) : 0,
                            'has_discount' => $flight['ChdPriceWithDiscount'] > 0 ? 'yes' : 'no',
                            'type_currency' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $child_price['TypeCurrency'] : $data_info['data_translate']['rial'],
                            'price_with_out_currency' => $flight['ChdPrice'],
                            'price_discount_with_out_currency' => round($flight['ChdPriceWithDiscount']),
                        ),
                        'infant' => array(
                            'price' => $infant_price > 0 ?
                                (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $infant_price['AmountCurrency'] : round($infant_price) : 0,
                            'fare' => 0,
                            'with_discount' => $infant_price > 0 ? ((ISCURRENCY && SOFTWARE_LANG != 'fa') ? round($infant_price_with_discount['AmountCurrency']) : $infant_price_with_discount['AmountCurrency']) : 0,
                            'has_discount' => $flight['InfPriceWithDiscount'] > 0 ? 'yes' : 'no',
                            'type_currency' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $infant_price['TypeCurrency'] : $data_info['data_translate']['rial'],
                            'price_with_out_currency' => round($infant_price['InfPrice']),
                            'price_discount_with_out_currency' => round($flight['InfPriceWithDiscount']),
                        ),
                    ),
                    'check_sort_reservation' => '1',
                    'currency_code' => Session::getCurrency(),
                    'departure_name' => $this->originName,
                    'arrival_name' => $this->destinationName,
                    'airport_departure_name' => $this->InfoSearch['airport_departure'],
                    'airport_arrival_name' => $this->InfoSearch['airport_arrival'],
                    'time_flight_name' => functions::classTimeLOCAL(functions::format_hour($flight['DepartureTime']), false),
                    'flight_number' => $flight['FlightNumber'],
                    'airline' => $airline_iata,
                    'airline_name' => $data_info['airlines_name'][$airline_iata][functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa')],
                    'departure_date' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? functions::ConvertToMiladi($flight['OFlightDate']) : str_replace('/', '-', $flight['FlightDate']),
                    'departure_time' => $flight['DepartureTime'],
                    'duration_time' => $flight['Hour'] . ':' . $flight['Minutes'],
                    'arrival_date' => '',
                    'arrival_time' => '',
                    'departure_parent_region_name' => '',
                    'departure_code' => $flight['OriginAirport'],
                    'arrival_parent_region_name' => '',
                    'arrival_code' => $flight['DestinationAirport'],
                    'aircraft' => $flight['TypeVehicle'],
                    'flight_type' => (strtolower($flight['FlightType']) == "system") ? $data_info['data_translate']['system_flight'] : $data_info['data_translate']['charter_flight'],
                    'flight_type_li' => (strtolower($flight['FlightType']) == "system") ? 'system' : 'charter',
                    'persian_departure_date' => $date_persian,
                    'description' => '',
                    'seat_class' => (($flight['SeatClass'] == 'C' || $flight['SeatClass'] == 'J' || $flight['SeatClass'] == 'D' || $flight['SeatClass'] == 'I' || $flight['SeatClass'] == 'Z') ? $data_info['data_translate']['business_type'] : $data_info['data_translate']['economics_type']),
                    'seat_class_en' => (($flight['SeatClass'] == 'C' || $flight['SeatClass'] == 'J' || $flight['SeatClass'] == 'D' || $flight['SeatClass'] == 'I' || $flight['SeatClass'] == 'Z') ? 'business' : 'economy'),
                    'cabin_type' => $flight['CabinType'],
                    'capacity' => ($flight['Capacity'] > 10) ? '+10' : $flight['Capacity'],
                    'supplier' => '',
                    'user_id' => !empty($flight['UserId']) ? $flight['UserId'] : '',
                    'user_name' => !empty($flight['UserName']) ? $flight['UserName'] : '',
                    'source_id' => $source_id,
                    'source_name' => !empty($flight['SourceName']) ? $flight['SourceName'] : '',
                    'unique_code' => '',
                    'count_interrupt' => functions::countInterrupt($count_dept_route),
                    'count_transit' => ($count_dept_route - 1),
                    'count_transit_title' => functions::countInterruptTitle(($count_dept_route - 1), $data_info['data_translate']),
                    'point_club' => '',
                    'flight_id' => $flight['ID'],
                    'flight_id_return' => '',
                    'total_output_flight_duration' => $flight['Hour'] . ':' . $flight['Minutes'],
                    'total_output_stop_duration' => $flight['Hour'] . ':' . $flight['Minutes'],
                );

                $this->tickets['flights'][$key]['output_routes_detail'] = array(
                    array(
                        'is_transit' => false,
                        'transit' => '',
                        'cabin_type' => $flight['CabinType'],
                        'flight_number' => $flight['FlightNumber'],
                        'capacity' => ($flight['Capacity'] > 10) ? '+10' : $flight['Capacity'],
                        'departure_date' => functions::ConvertDateByLanguage(SOFTWARE_LANG, str_replace('/', '-', $flight['FlightDate']), '/', (SOFTWARE_LANG != 'fa' ? 'Miladi' : 'Jalali'), (SOFTWARE_LANG != 'fa' ? true : false)),
                        'departure_date_abbreviation' => functions::DateFormatType(str_replace('/', '-', $flight['FlightDate']), 'gregorian'),
                        'departure_time' => functions::format_hour($flight['DepartureTime']),
                        'arrival_date' => null,
                        'arrival_date_abbreviation' => null,
                        'arrival_time' => null,
                        'duration_flight_time' => $flight['Hour'] . ':' . $flight['Minutes'],
                        'seat_class' => (($flight['SeatClass'] == 'C' || $flight['SeatClass'] == 'J' || $flight['SeatClass'] == 'D' || $flight['SeatClass'] == 'I' || $flight['SeatClass'] == 'Z') ? $data_info['data_translate']['business_type'] : $data_info['data_translate']['economics_type']),
                        'baggage' => array(
                            'code' => 'pieces',
                            'charge' => $flight['Weight'],
                            'type' => '',
                            'baggage_statement' => $this->baggageTitle($flight['Weight'], '', $data_info['data_translate'], true)
                        ),
                        'airline' => array(
                            'airline_name' => $data_info['airlines_name'][$airline_iata][functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa')],
                            'airline_code' => $airline_iata,
                        ),
                        'aircraft' => array(
                            'aircraft_code' => $flight['TypeVehicle'],
                            'aircraft_name' => $flight['TypeVehicle'],
                            'aircraft_manufacturer' => $flight['TypeVehicle'],
                        ),
                        'departure' => array(
                            'departure_airport' => $data_info['airports'][functions::mapIataCode($flight['OriginAirport'])][functions::changeFieldNameByLanguage('Airport')],
                            'departure_city' => $data_info['airports'][functions::mapIataCode($flight['OriginAirport'])][functions::changeFieldNameByLanguage('DepartureCity')],
                            'departure_region_name' => $data_info['airports'][functions::mapIataCode($flight['OriginAirport'])][functions::changeFieldNameByLanguage('Country')],
                            'departure_code' => functions::mapIataCode($flight['OriginAirport']),
                        ),
                        'arrival' => array(
                            'arrival_airport' => $data_info['airports'][functions::mapIataCode($flight['DestinationAirport'])][functions::changeFieldNameByLanguage('Airport')],
                            'arrival_city' => $data_info['airports'][functions::mapIataCode($flight['DestinationAirport'])][functions::changeFieldNameByLanguage('DepartureCity')],
                            'arrival_region_name' => $data_info['airports'][functions::mapIataCode($flight['DestinationAirport'])][functions::changeFieldNameByLanguage('Country')],
                            'arrival_code' => functions::mapIataCode($flight['DestinationAirport']),
                        ),
                    )
                );
                $this->tickets['flights'][$key]['return_routes'][0] = array();


            }

        } elseif (!empty($datas['return'])) {
            $count_dept_route = count($datas['dept']);
            $count_return_route = count($datas['return']);
            foreach ($datas['dept'] as $key_dept => $flight_dept) {
                foreach ($datas['return'] as $key_return => $flight_return) {
                    $source_id = 'special';
                    $airline_iata = $flight_dept['Airline'];
                    $date_persian = $flight_dept['FlightDate'];
                    $date_persian_return = $flight_return['FlightDate'];
                    if ($flight_dept['AdtPrice'] > 0) {
                        $price_adult_dept = functions::CurrencyCalculate($flight_dept['AdtPrice'], $data_info['info_currency']['CurrencyCode'],$data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn']);
                        $price_adult_return = functions::CurrencyCalculate($flight_return['AdtPrice'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn']) ;
                        $adult_price = (SOFTWARE_LANG != 'fa') ?  ($price_adult_dept['AmountCurrency'] + $price_adult_return['AmountCurrency']) : ($flight_dept['AdtPrice'] + $flight_return['AdtPrice']);
                        $price_adult_discount_dept = functions::CurrencyCalculate($flight_dept['PriceWithDiscount'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn']);
                        $price_adult_discount_return = functions::CurrencyCalculate($flight_return['PriceWithDiscount'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn']);
                        $adult_price_with_discount =
                            (SOFTWARE_LANG != 'fa') ? ( $price_adult_discount_dept['AmountCurrency'] + $price_adult_discount_return['AmountCurrency']) : ($flight_dept['PriceWithDiscount'] + $flight_return['PriceWithDiscount']);
                        $this->prices['TwoWay'][] = (SOFTWARE_LANG != 'fa') ? $adult_price : round($adult_price);
                    }
                    if (!in_array($airline_iata, $data_info['airlines_name'])) {
                        $airlines[] = $airline_iata;
                        foreach ($airlines as $airline) {
                            if ($airline == $airline_iata && round($flight_dept['AdtPrice']) > 0) {
                                $price_airline[$airline_iata][] = $adult_price;
                                $price_currency_min = min($price_airline[$airline_iata]);
                                $this->tickets['min_price_airline'][$airline_iata] = array(
                                    'name_en' => $airline_iata,
                                    'price' => functions::numberFormat($price_currency_min),
                                    'name' => $data_info['airlines_name'][$airline_iata][functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa')],
                                );
                            }
                        }
                    }

                    if ($flight_dept['ChdPrice'] > 0) {
                        $price_dept_child = functions::CurrencyCalculate($flight_dept['ChdPrice'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn'])  ;
                        $price_return_child = functions::CurrencyCalculate($flight_return['ChdPrice'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn'])  ;

                        $child_price = (SOFTWARE_LANG != 'fa') ?  ($price_dept_child['AmountCurrency'] + $price_return_child['AmountCurrency']) : ($flight_dept['ChdPrice'] + $flight_return['ChdPrice']);

                        $price_dept_child_discount = functions::CurrencyCalculate($flight_dept['ChdPriceWithDiscount'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn'])  ;
                        $price_return_child_discount = functions::CurrencyCalculate($flight_return['ChdPriceWithDiscount'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn'])  ;

                        $child_price_with_discount = (SOFTWARE_LANG != 'fa') ? ($price_dept_child_discount['AmountCurrency']+$price_return_child_discount['AmountCurrency']) : ($flight_dept['ChdPriceWithDiscount'] + $flight_return['ChdPriceWithDiscount']);
                    }
                    if ($flight_dept['InfPrice'] > 0) {
                        $price_dept_Infant = functions::CurrencyCalculate($flight_dept['InfPrice'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn'])  ;
                        $price_return_Infant = functions::CurrencyCalculate($flight_return['InfPrice'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn'])  ;


                        $infant_price = (SOFTWARE_LANG != 'fa') ? ($price_dept_Infant['AmountCurrency'] + $price_return_Infant['AmountCurrency']) : ($flight_dept['InfPrice'] + $flight_return['InfPrice']);


                        $price_dept_infant_discount = functions::CurrencyCalculate($flight_dept['ChdPriceWithDiscount'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn'])  ;
                        $price_return_infant_discount = functions::CurrencyCalculate($flight_return['ChdPriceWithDiscount'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn'])  ;

                        $infant_price_with_discount = (SOFTWARE_LANG != 'fa') ? ($price_dept_infant_discount['AmountCurrency'] + $price_return_infant_discount['AmountCurrency']) : ($flight_dept['InfPriceWithDiscount'] + $flight_return['InfPriceWithDiscount']);
                    }

                    $this->tickets['flights'][$key_dept] = array(
                        'price' => array(
                            'adult' => array(
                                'price' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $adult_price : round($adult_price),
                                'fare' => 0,
                                'with_discount' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $adult_price_with_discount : round($adult_price_with_discount),
                                'has_discount' => $flight_dept['PriceWithDiscount'] > 0 ? 'yes' : 'no',
                                'type_currency' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $price_adult_dept['TypeCurrency'] : $data_info['data_translate']['rial'],
                                'price_with_out_currency' => round($flight_dept['AdtPrice']),
                                'price_discount_with_out_currency' => round($flight_dept['PriceWithDiscount']),
                            ),
                            'child' => array(
                                'price' => $child_price > 0 ? (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $child_price : round($child_price) : 0,
                                'fare' => 0,
                                'with_discount' => $child_price > 0 ? ((ISCURRENCY && SOFTWARE_LANG != 'fa') ? round($child_price_with_discount['AmountCurrency']) : $child_price_with_discount['AmountCurrency']) : 0,
                                'has_discount' => $flight_dept['ChdPriceWithDiscount'] > 0 ? 'yes' : 'no',
                                'type_currency' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $child_price['TypeCurrency'] : $data_info['data_translate']['rial'],
                                'price_with_out_currency' => $flight_dept['ChdPrice'],
                                'price_discount_with_out_currency' => round($flight_dept['ChdPriceWithDiscount']),
                            ),
                            'infant' => array(
                                'price' => $infant_price > 0 ?
                                    (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $infant_price : round($infant_price) : 0,
                                'fare' => 0,
                                'with_discount' => $infant_price > 0 ? ((ISCURRENCY && SOFTWARE_LANG != 'fa') ? round($infant_price_with_discount['AmountCurrency']) : $infant_price_with_discount['AmountCurrency']) : 0,
                                'has_discount' => $flight_dept['InfPriceWithDiscount'] > 0 ? 'yes' : 'no',
                                'type_currency' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $infant_price['TypeCurrency'] : $data_info['data_translate']['rial'],
                                'price_with_out_currency' => round($infant_price['InfPrice']),
                                'price_discount_with_out_currency' => round($flight_dept['InfPriceWithDiscount']),
                            ),
                        ),
                        'currency_code' => Session::getCurrency(),
                        'departure_name' => $this->originName,
                        'arrival_name' => $this->destinationName,
                        'airport_departure_name' => $this->InfoSearch['airport_departure'],
                        'airport_arrival_name' => $this->InfoSearch['airport_arrival'],
                        'time_flight_name' => functions::classTimeLOCAL(functions::format_hour($flight_dept['DepartureTime']), false),
                        'flight_number' => $flight_dept['FlightNumber'],
                        'airline' => $airline_iata,
                        'airline_name' => $data_info['airlines_name'][$airline_iata][functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa')],
                        'departure_date' => (SOFTWARE_LANG != 'fa') ? functions::ConvertToMiladi($flight_dept['FlightDate']) : str_replace('/', '-', $flight_dept['FlightDate']),
                        'departure_time' => $flight_dept['DepartureTime'],
                        'duration_time' => $flight_dept['Hour'] . ':' . $flight_dept['Minutes'],
                        'arrival_date' => '',
                        'arrival_time' => '',
                        'departure_parent_region_name' => '',
                        'departure_code' => $flight_dept['OriginAirport'],
                        'arrival_parent_region_name' => '',
                        'arrival_code' => $flight_dept['DestinationAirport'],
                        'aircraft' => $flight_dept['TypeVehicle'],
                        'flight_type' => (strtolower($flight_dept['FlightType']) == "system") ? $data_info['data_translate']['system_flight'] : $data_info['data_translate']['charter_flight'],
                        'flight_type_li' => (strtolower($flight_dept['FlightType']) == "system") ? 'system' : 'charter',
                        'persian_departure_date' => $date_persian,
                        'description' => '',
                        'seat_class' => (($flight_dept['SeatClass'] == 'C') ? $data_info['data_translate']['business_type'] : $data_info['data_translate']['economics_type']),
                        'seat_class_en' => (($flight_dept['SeatClass'] == 'C') ? 'business' : 'economy'),
                        'cabin_type' => $flight_dept['CabinType'],
                        'capacity' => ($flight_dept['Capacity'] > 10) ? '+10' : $flight_dept['Capacity'],
                        'supplier' => '',
                        'user_id' => !empty($flight_dept['UserId']) ? $flight_dept['UserId'] : '',
                        'user_name' => !empty($flight_dept['UserName']) ? $flight_dept['UserName'] : '',
                        'source_id' => $source_id,
                        'source_name' => !empty($flight_dept['SourceName']) ? $flight_dept['SourceName'] : '',
                        'unique_code' => '',
                        'count_interrupt' => functions::countInterrupt($count_dept_route),
                        'count_transit' => ($count_dept_route - 1),
                        'count_transit_title' => functions::countInterruptTitle(($count_dept_route - 1), $data_info['data_translate']),
                        'point_club' => '',
                        'flight_id' => $flight_dept['ID'],
                        'flight_id_return' => $flight_return['ID'],
                        'total_output_flight_duration' => $flight_dept['Hour'] . ':' . $flight_dept['Minutes'],
                        'total_output_stop_duration' => $flight_dept['Hour'] . ':' . $flight_dept['Minutes'],
                    );

                    $this->tickets['flights'][$key_dept]['output_routes_detail'] = array(
                        array(
                            'is_transit' => false,
                            'transit' => '',
                            'cabin_type' => $flight_dept['CabinType'],
                            'flight_number' => $flight_dept['FlightNumber'],
                            'capacity' => ($flight_dept['Capacity'] > 10) ? '+10' : $flight_dept['Capacity'],
                            'departure_date' => functions::ConvertDateByLanguage(SOFTWARE_LANG, str_replace('/', '-', $flight_dept['FlightDate']), '/', (SOFTWARE_LANG != 'fa' ? 'Miladi' : 'Jalali'), (SOFTWARE_LANG != 'fa' ? true : false)),
                            'departure_date_abbreviation' => functions::DateFormatType(str_replace('/', '-', $flight_dept['FlightDate']), 'gregorian'),
                            'departure_time' => functions::format_hour($flight_dept['DepartureTime']),
                            'arrival_date' => null,
                            'arrival_date_abbreviation' => null,
                            'arrival_time' => null,
                            'duration_flight_time' => $flight_dept['Hour'] . ':' . $flight_dept['Minutes'],
                            'seat_class' => (($flight_dept['SeatClass'] == 'C') ? $data_info['data_translate']['business_type'] : $data_info['data_translate']['economics_type']),
                            'baggage' => array(
                                'code' => 'pieces',
                                'charge' => $flight_dept['Weight'],
                                'type' => '',
                                'baggage_statement' => $this->baggageTitle($flight_dept['Weight'], '', $data_info['data_translate'], true)
                            ),
                            'airline' => array(
                                'airline_name' => $data_info['airlines_name'][$airline_iata][functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa')],
                                'airline_code' => $airline_iata,
                            ),
                            'aircraft' => array(
                                'aircraft_code' => $flight_dept['TypeVehicle'],
                                'aircraft_name' => $flight_dept['TypeVehicle'],
                                'aircraft_manufacturer' => $flight_dept['TypeVehicle'],
                            ),
                            'departure' => array(
                                'departure_airport' => $data_info['airports'][functions::mapIataCode($flight_dept['OriginAirport'])][functions::changeFieldNameByLanguage('Airport')],
                                'departure_city' => $data_info['airports'][functions::mapIataCode($flight_dept['OriginAirport'])][functions::changeFieldNameByLanguage('DepartureCity')],
                                'departure_region_name' => $data_info['airports'][functions::mapIataCode($flight_dept['OriginAirport'])][functions::changeFieldNameByLanguage('Country')],
                                'departure_code' => functions::mapIataCode($flight_dept['OriginAirport']),
                            ),
                            'arrival' => array(
                                'arrival_airport' => $data_info['airports'][functions::mapIataCode($flight_dept['DestinationAirport'])][functions::changeFieldNameByLanguage('Airport')],
                                'arrival_city' => $data_info['airports'][functions::mapIataCode($flight_dept['DestinationAirport'])][functions::changeFieldNameByLanguage('DepartureCity')],
                                'arrival_region_name' => $data_info['airports'][functions::mapIataCode($flight_dept['DestinationAirport'])][functions::changeFieldNameByLanguage('Country')],
                                'arrival_code' => functions::mapIataCode($flight_dept['DestinationAirport']),
                            ),
                        )
                    );
                    $this->tickets['flights'][$key_dept]['return_routes'] = array(
                        'airline' => $flight_return['ReturnRoutes'][0]['Airline']['Code'],
                        'airline_name' => $data_info['airlines_name'][$flight_return['Airline']][functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa')],
                        'departure_name' => $this->destinationName,
                        'arrival_name' => $this->originName,
                        'return_flight_id' => $flight_return['ReturnFlightID'],
                        'airport_departure_name' => $this->InfoSearch['airport_arrival'],
                        'airport_arrival_name' => $this->InfoSearch['airport_departure'],
                        'flight_number_return' => $flight_return['FlightNumber'],
                        'departure_code' => $flight_return['DestinationAirport'],
                        'departure_date' => functions::ConvertDateByLanguage($flight_return['ReturnRoutes'][0]['DepartureDate'], '/', (SOFTWARE_LANG != 'fa' ? 'Miladi' : 'Jalali'), (SOFTWARE_LANG != 'fa' ? 'false' : 'true')),
                        'departure_time' => $flight_dept['Hour'] . ':' . $flight_dept['Minutes'],
                        'arrival_date' => '',
                        'arrival_time' => '',
                        'arrival_code' => $flight_return['OriginAirport'],
                        'aircraft' => $flight_return['TypeVehicle'],
                        'persian_departure_date' => $date_persian_return,
                        'cabin_type' => $flight_return['CabinType'],
                        'count_interrupt_return' => functions::countInterrupt($count_return_route),
                        'count_transit_return' => ($count_return_route - 1),
                        'flight_id' => $flight_return['ID'],
                        'total_return_flight_duration' => $flight_return['Hour'] . ':' . $flight_return['Minutes'],
                        'total_return_stop_duration' => '',
                    );

                    $this->tickets['flights'][$key_dept]['return_routes']['return_route_detail'] = array(
                        array(
                            'is_transit' => false,
                            'transit' => '',
                            'cabin_type' => $flight_return['CabinType'],
                            'flight_number' => $flight_return['FlightNumber'],
                            'capacity' => ($flight_return['Capacity'] > 10) ? '+10' : $flight_return['Capacity'],
                            'departure_date' => functions::ConvertDateByLanguage(SOFTWARE_LANG, str_replace('/', '-', $flight_return['FlightDate']), '/', (SOFTWARE_LANG != 'fa' ? 'Miladi' : 'Jalali'), (SOFTWARE_LANG != 'fa' ? true : false)),
                            'departure_date_abbreviation' => functions::DateFormatType($flight_return['DepartureDate'], 'gregorian'),
                            'departure_time' => $flight_return['DepartureTime'],
                            'arrival_date' => null,
                            'arrival_time' => null,
                            'arrival_date_abbreviation' => null,
                            'duration_flight_time' => $flight_return['Hour'] . ':' . $flight_return['Minutes'],
                            'seat_class' => (($flight_return['SeatClass'] == 'C') ? $data_info['data_translate']['business_type'] : $data_info['data_translate']['economics_type']),
                            'baggage' => array(
                                'code' => 'pieces',
                                'charge' => $flight_return['Weight'],
                                'type' => '',
                                'baggage_statement' => $this->baggageTitle($flight_dept['Weight'], '', $data_info['data_translate'], true)
                            ),
                            'airline' => array(
                                'airline_name' => $data_info['airlines_name'][$flight_return['Airline']][functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa')],
                                'airline_code' => $flight_return['Airline'],
                            ),
                            'aircraft' => array(
                                'aircraft_code' => $flight_return['TypeVehicle'],
                                'aircraft_name' => $flight_return['TypeVehicle'],
                                'aircraft_manufacturer' => $flight_return['TypeVehicle'],
                            ),
                            'departure' => array(
                                'departure_airport' => $data_info['airports'][functions::mapIataCode($flight_return['DestinationAirport'])][functions::changeFieldNameByLanguage('Airport')],
                                'departure_city' => $data_info['airports'][functions::mapIataCode($flight_return['DestinationAirport'])][functions::changeFieldNameByLanguage('DepartureCity')],
                                'departure_region_name' => $data_info['airports'][functions::mapIataCode($flight_return['DestinationAirport'])][functions::changeFieldNameByLanguage('Country')],
                                'departure_code' => functions::mapIataCode($flight_return['Departure']['Code'])),
                            'arrival' => array(
                                'arrival_airport' => $data_info['airports'][functions::mapIataCode($flight_return['OriginAirport'])][functions::changeFieldNameByLanguage('Airport')],
                                'arrival_city' => $data_info['airports'][functions::mapIataCode($flight_return['OriginAirport'])][functions::changeFieldNameByLanguage('DepartureCity')],
                                'arrival_region_name' => $data_info['airports'][functions::mapIataCode($flight_return['OriginAirport'])][functions::changeFieldNameByLanguage('Country')],
                                'arrival_code' => functions::mapIataCode($flight_return['OriginAirport']),
                            ),
                        )
                    );


                }
            }
        }

        if($empty_result=='yes'){
            $direction = empty($datas['return']) ? 'dept' : 'TwoWay' ;

            $min = min($this->prices[$direction]);
            $max = max($this->prices[$direction]);
            $this->tickets['prices'] = $this->prices[$direction];
            $this->tickets['price'] = array('min_price' => floor($min), 'max_price' => ceil($max));


        }
        return $this->tickets;

    }
    //endregion


    public function structureReservationInternal($datas, $data_info,$empty_result) {


        $adult_price = 0;
        $child_price = 0;
        $infant_price = 0;
        $adult_price_with_discount = 0;
        $child_price_with_discount = 0;
        $infant_price_with_discount = 0;
        $prices=[];
        if($empty_result=='yes'){
            $this->tickets = $this->filterInternationalFlight($data_info['data_translate']);
        }

        $count_dept_route = count($datas['dept']);
        foreach ($datas['dept'] as $key => $flight) {
            $source_id = 'special';
            $airline_iata = $flight['Airline'];
            $date_persian = $flight['FlightDate'];
            if ($flight['AdtPrice'] > 0) {
                $price_calculate = functions::CurrencyCalculate($flight['AdtPrice'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn']);
                $price_calculate_discount = functions::CurrencyCalculate($flight['PriceWithDiscount'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn']);
                $adult_price = (SOFTWARE_LANG != 'fa') ? $price_calculate['AmountCurrency'] : $flight['AdtPrice'];
                $adult_price_with_discount = (SOFTWARE_LANG != 'fa') ? $price_calculate_discount['AmountCurrency'] : $flight['PriceWithDiscount'];
                $prices[] = intval($adult_price);
            }
            if (!in_array($airline_iata, $data_info['airlines_name'])) {
                $airlines[] = $airline_iata;
                foreach ($airlines as $airline) {
                    if ($airline == $airline_iata && round($flight['AdtPrice']) > 0) {
                        $price_airline[$airline_iata][] = $price_calculate['AmountCurrency'];
                        $price_currency_min = min($price_airline[$airline_iata]);
                        $this->tickets['min_price_airline']['dept'][$airline_iata] = array(
                            'name_en' => $airline_iata,
                            'price' => functions::numberFormat($price_currency_min),
                            'name' => $data_info['airlines_name'][$airline_iata][functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa')],
                        );
                    }
                }
            }

            if ($flight['ChdPrice'] > 0) {
                $child_price = (SOFTWARE_LANG != 'fa') ? functions::CurrencyCalculate($flight['ChdPrice'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn']) : $flight['ChdPrice'];
                $child_price_with_discount = (SOFTWARE_LANG != 'fa') ? functions::CurrencyCalculate($flight['ChdPriceWithDiscount'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn']) : $flight['ChdPriceWithDiscount'];
            }
            if ($flight['InfPrice'] > 0) {
                $infant_price = (SOFTWARE_LANG != 'fa') ? functions::CurrencyCalculate($flight['InfPrice'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn']) : $flight['InfPrice'];
                $infant_price_with_discount = (SOFTWARE_LANG != 'fa') ? functions::CurrencyCalculate($flight['InfPriceWithDiscount'], $data_info['info_currency']['CurrencyCode'], $data_info['info_currency']['EqAmount'], $data_info['info_currency']['CurrencyTitleEn']) : $flight['InfPriceWithDiscount'];
            }

            $this->tickets['flights']['dept'][] = array(
                'price' => array(
                    'adult' => array(
                        'price' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $adult_price : round($adult_price),
                        'fare' => 0,
                        'with_discount' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $adult_price_with_discount : round($adult_price_with_discount),
                        'has_discount' => $flight['PriceWithDiscount'] > 0 ? 'yes' : 'no',
                        'type_currency' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $price_calculate['TypeCurrency'] : $data_info['data_translate']['rial'],
                        'price_with_out_currency' => round($flight['AdtPrice']),
                        'price_discount_with_out_currency' => round($flight['PriceWithDiscount']),
                        'originalPrice'=>$flight['AdtPrice']
                    ),
                    'child' => array(
                        'price' => $child_price > 0 ? (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $child_price['AmountCurrency'] : round($child_price) : 0,
                        'fare' => 0,
                        'with_discount' => $child_price > 0 ? ((ISCURRENCY && SOFTWARE_LANG != 'fa') ? round($child_price_with_discount['AmountCurrency']) : $child_price_with_discount['AmountCurrency']) : 0,
                        'has_discount' => $flight['ChdPriceWithDiscount'] > 0 ? 'yes' : 'no',
                        'type_currency' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $child_price['TypeCurrency'] : $data_info['data_translate']['rial'],
                        'price_with_out_currency' => $flight['ChdPrice'],
                        'price_discount_with_out_currency' => round($flight['ChdPriceWithDiscount']),
                        'originalPrice'=>$flight['ChdPrice']
                    ),
                    'infant' => array(
                        'price' => $infant_price > 0 ?
                            (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $infant_price['AmountCurrency'] : round($infant_price) : 0,
                        'fare' => 0,
                        'with_discount' => $infant_price > 0 ? ((ISCURRENCY && SOFTWARE_LANG != 'fa') ? round($infant_price_with_discount['AmountCurrency']) : $infant_price_with_discount['AmountCurrency']) : 0,
                        'has_discount' => $flight['InfPriceWithDiscount'] > 0 ? 'yes' : 'no',
                        'type_currency' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $infant_price['TypeCurrency'] : $data_info['data_translate']['rial'],
                        'price_with_out_currency' => round($infant_price['InfPrice']),
                        'price_discount_with_out_currency' => round($flight['InfPriceWithDiscount']),
                        'originalPrice'=>$flight['InfPrice']
                    ),
                ),
                'check_sort_reservation' => '1',
                'currency_code' => Session::getCurrency(),
                'departure_name' => $this->originName,
                'arrival_name' => $this->destinationName,
                'airport_departure_name' => $this->InfoSearch['airport_departure'],
                'airport_arrival_name' => $this->InfoSearch['airport_arrival'],
                'time_flight_name' => functions::classTimeLOCAL(functions::format_hour($flight['DepartureTime']), false),
                'flight_number' => $flight['FlightNumber'],
                'airline' => $airline_iata,
                'airline_name' => $data_info['airlines_name'][$airline_iata][functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa')],
                'departure_date' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? functions::ConvertToMiladi($flight['OFlightDate']) : str_replace('/', '-', $flight['FlightDate']),
                'departure_time' => $flight['DepartureTime'],
                'duration_time' => $flight['Hour'] . ':' . $flight['Minutes'],
                'arrival_date' => '',
                'arrival_time' => '',
                'departure_parent_region_name' => '',
                'departure_code' => $flight['OriginAirport'],
                'arrival_parent_region_name' => '',
                'arrival_code' => $flight['DestinationAirport'],
                'aircraft' => $flight['TypeVehicle'],
                'flight_type' => (strtolower($flight['FlightType']) == "system") ? $data_info['data_translate']['system_flight'] : $data_info['data_translate']['charter_flight'],
                'flight_type_li' => (strtolower($flight['FlightType']) == "system") ? 'system' : 'charter',
                'persian_departure_date' => $date_persian,
                'description' => '',
                'seat_class' => (($flight['SeatClass'] == 'C' || $flight['SeatClass'] == 'J' || $flight['SeatClass'] == 'D' || $flight['SeatClass'] == 'I' || $flight['SeatClass'] == 'Z') ? $data_info['data_translate']['business_type'] : $data_info['data_translate']['economics_type']),
                'seat_class_en' => (($flight['SeatClass'] == 'C' || $flight['SeatClass'] == 'J' || $flight['SeatClass'] == 'D' || $flight['SeatClass'] == 'I' || $flight['SeatClass'] == 'Z') ? 'business' : 'economy'),
                'cabin_type' => $flight['CabinType'],
                'capacity' => ($flight['Capacity'] > 10) ? '+10' : $flight['Capacity'],
                'supplier' => '',
                'user_id' => !empty($flight['UserId']) ? $flight['UserId'] : '',
                'user_name' => !empty($flight['UserName']) ? $flight['UserName'] : '',
                'source_id' => $source_id,
                'source_name' => !empty($flight['SourceName']) ? $flight['SourceName'] : '',
                'unique_code' => '',
                'point_club' => '',
                'flight_id' => $flight['ID'],
                'baggage' => 20,
                'flight_id_return' => '',
                'total_output_flight_duration' => $flight['Hour'] . ':' . $flight['Minutes'],
                'total_output_stop_duration' => $flight['Hour'] . ':' . $flight['Minutes'],
            );




        }

        foreach ($prices as $price) {
            $this->tickets['prices']['dept'][] = $price;
        }
        if($empty_result=='yes'){
            $direction = empty($datas['return']) ? 'dept' : 'TwoWay' ;

            $min = min($this->prices[$direction]);
            $max = max($this->prices[$direction]);
            $this->tickets['prices'] = $this->prices[$direction];
            $this->tickets['price']['dept'] = array('min_price' => floor($min), 'max_price' => ceil($max));


        }

        return $this->tickets;
    }

    //region [filterPriceSort]

    public function checkTodayDate($data) {
        $check_date = functions::indate($data['dateSearch']);
        return functions::withSuccess($check_date, 200, 'successfully fetch');
    }
    //endregion

    //region [getCityForeign]

    public function infoCurrency() {


        $result_current_currency = $this->getController('currencyEquivalent')->InfoCurrency(Session::getCurrency());
        if (!empty($result_current_currency)) {
            return functions::withSuccess($result_current_currency, 200, 'data fetch successfully');
        }
        return functions::withSuccess('', 200, 'no found match currency');
    }

    //endregion

    public function listCurrency() {
        /** @var currencyEquivalent $currency_equivalent_controller */
        $currency_equivalent_controller = Load::controller('currencyEquivalent');
        $result_current_currency = $currency_equivalent_controller->ListCurrencyEquivalent();
        if (!empty($result_current_currency)) {
            return functions::withSuccess($result_current_currency, 200, 'data fetch successfully');
        }
        return functions::withSuccess('', 200, 'no found match currency');
    }


    #region [filterInternationalFlight]

    public function getCityForeign($data) {

        $list_search = $this->getController('routeFlight')->searchListCityByIata($data['iata_city']);
        return functions::withSuccess($list_search, 200, 'data fetch successfully');

    }
    #endregion

    #region [getLongTimeFlightInternal]

    /**
     * @param $flights
     * @param $resultLocal
     * @return array
     */
    public function filterPriceSort($flights, $resultLocal) {
        $final_flights = array();
        foreach ($flights as $flight) {
            $final_flights[$flight['SourceId']] = $flight;

        }
        return $final_flights;
    }
    #endregion

    #region [getCitiesFlightInternal]

    /**
     * @param $params
     * @return array
     * @throws Exception
     */
    public function getPortalStation($params) {
        $data = $this->getModel('flightPortalModel')->get([
            'DepartureCode as value',
            'DepartureCityFa as title',
            'DepartureCityEn as title_en',
            'AirportFa as airport',
            'AirportEn as airport_en',
            'CountryFa as country',
            'CountryEn as country_en',
        ]);
        if ($params['value']) {
            $data = $data->where('DepartureCityFa', '%' . $params['value'] . '%', 'LIKE');
            $data = $data->orWhere('DepartureCode', '%' . $params['value'] . '%', 'LIKE');
            $data = $data->orWhere('AirportFa', '%' . $params['value'] . '%', 'LIKE');
            $data = $data->orWhere('CountryFa', '%' . $params['value'] . '%', 'LIKE');
            $data = $data->orWhere('AirportEn', '%' . $params['value'] . '%', 'LIKE');
            $data = $data->orWhere('DepartureCityEn', '%' . $params['value'] . '%', 'LIKE');
            $data = $data->orWhere('CountryEn', '%' . $params['value'] . '%', 'LIKE');
        }


        if ($params['limit']) {
            $data = $data->limit(0, $params['limit']);
        }
        return $data->all();
    }
    #endregion

    #region [getLowestPriceFlight]

    public function getCustomPortalStation($params) {

        $data = $this->getModel('defaultFlightPortalModel')->get([
            'DepartureCode as value',
            'DepartureCityFa as title',
            'DepartureCityEn as title_en',
            'AirportFa as airport',
            'AirportEn as airport_en',
            'CountryFa as country',
            'CountryEn as country_en',
        ]);
        if ($params['value']) {
            $data = $data->where('DepartureCityFa', '%' . $params['value'] . '%', 'LIKE');
            $data = $data->orWhere('DepartureCode', '%' . $params['value'] . '%', 'LIKE');
            $data = $data->orWhere('AirportFa', '%' . $params['value'] . '%', 'LIKE');
            $data = $data->orWhere('CountryFa', '%' . $params['value'] . '%', 'LIKE');
            $data = $data->orWhere('AirportEn', '%' . $params['value'] . '%', 'LIKE');
            $data = $data->orWhere('DepartureCityEn', '%' . $params['value'] . '%', 'LIKE');
            $data = $data->orWhere('CountryEn', '%' . $params['value'] . '%', 'LIKE');
        }


        if ($params['limit']) {
            $data = $data->limit(0, $params['limit']);
        }

        return $data->all();
    }
    #endregion

    #region [flightInternal]

    public function getCitiesFlightInternal($data_search = null) {
        $lang = ($data_search['language'] != 'fa') ? ucfirst($data_search['language']) : '';
        $cities = $this->getModel('flightRouteModel')->get(['Departure_Code', 'Arrival_Code', 'Departure_City' . $lang, 'Arrival_City' . $lang])
            ->where('local_portal', 0);
        if (isset($data_search['iata_city']) && !empty($data_search['iata_city'])) {
            $cities = $cities->where('Departure_Code', $data_search['iata_city'])->all();
        } else {
            $cities = $cities->groupBy('Departure_Code')->all();
        }

        return functions::withSuccess($cities, 200, 'cities data fetch successfully');

    }
    #endregion


    #region [searchCitiesFlightInternal]

    public function searchCitiesFlightInternal($data_search = null) {

        $cities = $this->getController('routeFlight')->flightRouteInternal($data_search);

//        var_dump($data_search);
//        die;
        return functions::withSuccess($cities, 200, 'cities data fetch successfully');
    }
    #endregion

    #region [getReservationFlight]

    public function getLowestPriceFlight($params) {

        $info_currency = functions::infoCurrencyBySessionCode(Session::getCurrency());
        $list_config_airline = $this->listConfigAirline(true);
        $price_change_list = $this->flightPriceChangeList('local');
        $discount_list = $this->discountList();
        $translateVariable = $this->dataTranslate();


        $data_param_set_change_price['list_config_airline'] = $list_config_airline;
        $data_param_set_change_price['price_change_list'] = $price_change_list;
        $data_param_set_change_price['discount_list'] = $discount_list;
        $data_param_set_change_price['info_currency'] = $info_currency;
        $data_param_set_change_price['data_translate'] = $translateVariable;

        $url = $this->apiAddress . "Flight/flightFifteenDay";
        $data = array("Origin" => $params['origin'], "Destination" => $params['destination']);
        $result_send_data = functions::curlExecution($url, json_encode($data), 'yes');

        $data_lowest = array();
        $price = array();

        if ($result_send_data['result'] == 'true' && !empty($result_send_data['data'])) {
            foreach ($result_send_data['data'] as $key => $get_price) {
                $price[] = $get_price['price_final'];
                if($get_price['price_final'] != 0 ) {
                    $min_price_list[] = $get_price['price_final'];
                }
            }
            if($min_price_list && count($min_price_list) > 0) {
                $min_price = min($min_price_list);
            }else{
                $min_price = 0 ;
            }


            foreach ($result_send_data['data'] as $key => $data_flight) {
                if($key != 15) {
                    $flight_type = ($data_flight['displayLable'] == 'سیستمی') ? 'system' : 'charter';
                    $fare = ($data_flight['price_final'] - (($data_flight['price_final'] * 4573) / 100000));
                    $data_change_price = array(
                        'airlineIata' => $data_flight['iatA_code'],
                        'FlightType' => strtolower($flight_type),
                        'typeZone' => 'local',
                        'typeFlight' => 'economy',
                        'sourceId' => '8',
                        'isInternal' => true,
                        'price' => array(
                            'adult' => array(
                                'TotalPrice' => ($data_flight['price_final'] / 10),
                                'BasePrice' => $fare,
                            ),
                            'child' => array(
                                'TotalPrice' => 0,
                                'BasePrice' => 0,
                            ),
                            'infant' => array(
                                'TotalPrice' => 0,
                                'BasePrice' => 0,
                            ),
                        )
                    );
                    if (SOFTWARE_LANG == 'fa') {
                        $time_date = functions::ConvertToDateJalaliInt($data_flight['date_flight']);
                        $date_to_day = dateTimeSetting::jdate("j F Y", $time_date);
                        $date_to_day_link = dateTimeSetting::jdate("Y-m-d", $time_date, '', '', 'en');
                        $name_to_day = dateTimeSetting::jdate("l", $time_date);
                    } else {
                        $date_to_day = date('Y F d', strtotime($data_flight['date_flight']));
                        $date_to_day_link = $data_flight['date_flight'];
                        $name_to_day = date("l", strtotime($data_flight['date_flight']));
                    }


                    $price_final = $this->getController('priceChanges')->setPriceChangesFlight($data_change_price, $data_param_set_change_price);

                    if (isset($params['origin_name']) && $params['origin_name']) {
                        $info_route = $this->getController('routeFlight')->getRouteInternal($params);

                        if (SOFTWARE_LANG == 'fa') {
                            $data_lowest[$key]['origin_name'] = $info_route['Departure_City'];
                            $data_lowest[$key]['destination_name'] = $info_route['Arrival_City'];
                        } else {
                            $data_lowest[$key]['origin_name'] = $info_route['Departure_CityEn'];
                            $data_lowest[$key]['destination_name'] = $info_route['Arrival_CityEn'];
                        }

                    }
                    $passengers = '1-0-0';
                    if (isset($params['passengers']) && $params['passengers']) {
                        $passengers = $params['passengers'];
                    }

                    $data_lowest[$key]['date_for_show'] = $date_to_day;
                    $data_lowest[$key]['name_date'] = $name_to_day;
                    $data_lowest[$key]['price_final'] = $price_final['adult']['TotalPrice'] > 0 ? (((ISCURRENCY && SOFTWARE_LANG != 'fa') ? number_format(floatval($price_final['adult']['TotalPrice']),2) : number_format($price_final['adult']['TotalPrice'])) . $price_final['adult']['type_currency']) : functions::Xmlinformation("FullCapacity")->__toString();
                    $data_lowest[$key]['class_min_price'] = ($data_flight['price_final'] == $min_price && $data_flight['price_final'] > 0) ? 'active_col_today' : '';
                    $data_lowest[$key]['url'] = ROOT_ADDRESS . '/search-flight/1/' . $params['origin'] . '-' . $params['destination'] . '/' . $date_to_day_link . '/' . 'Y' . '/' . $passengers;
                }
            }

            return functions::withSuccess($data_lowest, 200, 'data lowest fetch successfully');
        }
        if (isset($params['origin_name']) && $params['origin_name']) {
            for ($i = 0; $i < 15; $i++) {
                if (SOFTWARE_LANG == 'fa') {
                    $time_date = date('Y-m-d');
                    $time_date = date('Y-m-d', strtotime('+'.$i.' day', strtotime($time_date)));
                    $time_date = functions::ConvertToDateJalaliInt($time_date);
                    $date_to_day = dateTimeSetting::jdate("j F Y", $time_date);
                    $date_to_day_link = dateTimeSetting::jdate("Y-m-d", $time_date, '', '', 'en');
                } else {
                    $date_to_day = date('Y F d', time());
                }

                $info_route = $this->getController('routeFlight')->getRouteInternal($params);
                $data_lowest[$i]['origin_name'] = $info_route['Departure_City'];
                $data_lowest[$i]['destination_name'] = $info_route['Arrival_City'];
                $data_lowest[$i]['date_for_show'] = $date_to_day;
                $data_lowest[$i]['price_final'] = '';
                $data_lowest[$i]['link'] = ROOT_ADDRESS . '/search-flight/1/' . $params['origin'] . '-' . $params['destination'] . '/' . $date_to_day_link . '/' . 'Y' . '/1-0-0' ;
            }

        }
        return functions::withError($data_lowest, 400, 'data not found');
    }

    public function getOfflinePriceFlight($params) {
        $data_lowest = array();

        // Generate dates for the next 15 days
        $dates = [];
        for ($i = 0; $i < 15; $i++) {
            $timestamp = strtotime("+$i days");

            if (SOFTWARE_LANG == 'fa') {
                $time_date = functions::ConvertToDateJalaliInt(date('Y-m-d', $timestamp));
                $date_to_day = dateTimeSetting::jdate("j F Y", $time_date);
                $date_to_day_link = dateTimeSetting::jdate("Y-m-d", $time_date, '', '', 'en');
                $name_to_day = dateTimeSetting::jdate("l", $time_date);
            } else {
                $date_to_day = date('Y F d', $timestamp);
                $date_to_day_link = date('Y-m-d', $timestamp);
                $name_to_day = date("l", $timestamp);
            }

            $dates[] = [
                'date_for_show' => $date_to_day,
                'name_date' => $name_to_day,
                'date_link' => $date_to_day_link
            ];
        }

        // Get route information if available
        $origin_name = '';
        $destination_name = '';
        if (isset($params['origin_name']) && $params['origin_name']) {
            $info_route = $this->getController('routeFlight')->getRouteInternal($params);

            if (SOFTWARE_LANG == 'fa') {
                $origin_name = $info_route['Departure_City'];
                $destination_name = $info_route['Arrival_City'];
            } else {
                $origin_name = $info_route['Departure_CityEn'];
                $destination_name = $info_route['Arrival_CityEn'];
            }
        }

        // Set passengers parameter
        $passengers = '1-0-0';
        if (isset($params['passengers']) && $params['passengers']) {
            $passengers = $params['passengers'];
        }

        // Generate data for each date
        foreach ($dates as $key => $date) {
            if ($key != 15) { // Keep the original condition (though it seems unnecessary as we're already limiting to 15 items)
                $data_lowest[$key]['date_for_show'] = $date['date_for_show'];
                $data_lowest[$key]['name_date'] = $date['name_date'];

                // Add origin/destination names if available
                if ($origin_name && $destination_name) {
                    $data_lowest[$key]['origin_name'] = $origin_name;
                    $data_lowest[$key]['destination_name'] = $destination_name;
                }

                // Create URL without price information
                $data_lowest[$key]['link'] = ROOT_ADDRESS . '/search-flight/1/' . $params['origin'] . '-' . $params['destination'] . '/' . $date['date_link'] . '/' . 'Y' . '/' . $passengers;

                // No price information since we're not making API calls
                $data_lowest[$key]['price_final'] = '';
                $data_lowest[$key]['class_min_price'] = '';
            }
        }

        return functions::withSuccess($data_lowest, 200, 'Links created successfully');
    }

    #endregion

    #region [structureReservationForeign]

    /**
     * @return bool|mixed|string
     */
    public function flightInternal() {

        /*
         ersale request be api va daryafte natije
         */


        $start_function = date('H:i:s',time());
        $isCounter = $this->getController('login')->isCounter();
        $isCounter = json_decode($isCounter);
        $isSafar360 = functions::isSafar360();

//        error_log('start  flightInternal  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');

        /** @var airportModel $airportModel */
        $airportModel = $this->getModel('airportModel');
        $originCheck = $airportModel->get()->where('DepartureCode', $this->origin)->where('IsInternal', 1)->find();


        $destinationCheck = $airportModel->get()->where('DepartureCode', $this->destination)->where('IsInternal', 1)->find();

        $after_check = date('H:i:s',time());
        if (!$originCheck || !$destinationCheck) {
            return functions::withError([], 400, 'you search with wrong city codes');
        }

        if ($originCheck['DepartureCode'] == 'IKA' || $destinationCheck['DepartureCode'] == 'IKA') {
            return functions::withError([], 400, 'you search with wrong city codes');
        }

        $info_currency = functions::infoCurrencyBySessionCode(Session::getCurrency());

        $after_info_currency = date('H:i:s',time());
//        error_log('first  getTicketInternal  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');

        $flights = json_decode($this->findTicketInSearch(), true);

        $request_numbers = [];
        foreach ($flights as $direction => $arrayFlight) {
            $request_numbers[$direction] = $arrayFlight['Code'] ;
        }


        $count_search = intval($this->adult) + intval($this->child) + intval($this->infant) ;
        $after_receive = date('H:i:s',time());

//        error_log('after   findTicketInSearch  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');
//        error_log('*******************************'. " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');

        if ((empty($this->arrivalDate) && !empty($flights['dept']['Flights']))
            || (!empty($this->arrivalDate) && !empty($flights['dept']['Flights'])
                && !empty($flights['return']['Flights']))) {

            $airlines = array();
            $before_list_config_airline_time = date('H:i:s',time());
            $list_config_airline = $this->listConfigAirline(true);

            $list_config_airline_time = date('H:i:s',time());
            $price_change_list = $this->flightPriceChangeList('local');
            $price_change_list_time = date('H:i:s',time());
            $discount_list = $this->discountList();
            $discount_list_time = date('H:i:s',time());
            $airlines_name = $this->airlineList();
            $airlines_name_time = date('H:i:s',time());

            $translateVariable = $this->dataTranslate();
            $translateVariable_time = date('H:i:s',time());
            $type_zone = 'Local';
            $prices = array();

            $after_arrays = date('H:i:s',time());

            $data_param_set_change_price['list_config_airline'] = $list_config_airline;
            $data_param_set_change_price['price_change_list'] = $price_change_list;
            $data_param_set_change_price['discount_list'] = $discount_list;
            $data_param_set_change_price['info_currency'] = $info_currency;
            $data_param_set_change_price['data_translate'] = $translateVariable;

            $info_route = $this->getLongTimeFlightInternal($this->origin, $this->destination, $translateVariable);
            $this->tickets = $this->filterInternationalFlight($translateVariable);

            $this->tickets['min_price_airline'] = array();
            $this->tickets['flights'] = array();
            $this->tickets['price'] = array();
            $this->tickets['time'] = array();
            $this->tickets['time']['start_function'] = $start_function ;
            $this->tickets['time']['after_check'] = $after_check ;
            $this->tickets['time']['after_info_currency'] = $after_info_currency ;
            $this->tickets['time']['after_receive'] = $after_receive ;
            $this->tickets['time']['after_arrays'] = $after_arrays ;
            $this->tickets['time']['before_list_config_airline_time'] = $before_list_config_airline_time ;
            $this->tickets['time']['list_config_airline_time'] = $list_config_airline_time ;
            $this->tickets['time']['price_change_list_time'] = $price_change_list_time ;
            $this->tickets['time']['discount_list_time'] = $discount_list_time ;
            $this->tickets['time']['airlines_name_time'] = $airlines_name_time ;
            $this->tickets['time']['translateVariable_time'] = $translateVariable_time ;
            $this->tickets['time']['first'] = date('H:i:s',time());

            // OPTIMIZATION: Cache controller instances outside loop
            $commissionController = $this->getController('commissionSources');
            $priceChangesController = $this->getController('priceChanges');

            // OPTIMIZATION: Pre-compute commonly used values
            $langFieldIndex = functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa');
            $langFieldIndexEn = functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_en');
            $isEnglish = SOFTWARE_LANG != 'fa';
            $dateFormat = $isEnglish ? 'Miladi' : 'Jalali';
            $dateBoolStr = $isEnglish ? 'false' : 'true';

            // OPTIMIZATION: Pre-compute seat class translations
            $seatClassBusinessText = $translateVariable['business_type'];
            $seatClassEconomyText = $translateVariable['economics_type'];
            $seatClassBusinessXml = functions::Xmlinformation("BusinessType")->__toString();
            $seatClassEconomyXml = functions::Xmlinformation("EconomicsType")->__toString();

            // OPTIMIZATION: Cache airline info برای هر دو direction (رفت و برگشت)
            // جمع‌آوری تمام airline codes یونیک
            $allAirlineCodes = [];
            foreach ($flights as $tempDirection => $tempArrayFlight) {
                if (isset($tempArrayFlight['Flights'])) {
                    foreach ($tempArrayFlight['Flights'] as $tempFlight) {
                        if (isset($tempFlight['OutputRoutes'][0]['Airline']['Code'])) {
                            $allAirlineCodes[strtoupper($tempFlight['OutputRoutes'][0]['Airline']['Code'])] = true;
                        }
                    }
                }
            }
            $allAirlineCodes = array_keys($allAirlineCodes);

            // Cache کردن InfoAirline فقط (برای استفاده در pointClub)
            $this->airlineInfoCache = [];
            foreach ($allAirlineCodes as $iataCode) {
                $this->airlineInfoCache[$iataCode] = functions::InfoAirline($iataCode);
            }

            foreach ($flights as $direction => $arrayFlight) {

                $start = microtime(true);
                $this->count = count($flights);
                $flights_direction = $arrayFlight['Flights'];
                $arrayAirlines[$direction] = array();
                $airlines = array();
                $airlines_info = array(); // برای ذخیره نام ایرلاین‌ها

                // OPTIMIZATION: Pre-calculate checkConfigPid for all unique airlines
                $checkPrivateCache = [];
                $dateConversionCache = [];
                $convertedDateCache = []; // Cache for ConvertDateByLanguage results

                // OPTIMIZATION: Helper function for cached date conversion
                $getConvertedDate = function($date) use (&$convertedDateCache, $dateFormat, $dateBoolStr) {
                    if (!isset($convertedDateCache[$date])) {
                        $convertedDateCache[$date] = functions::ConvertDateByLanguage(SOFTWARE_LANG, $date, '/', $dateFormat, $dateBoolStr);
                    }
                    return $convertedDateCache[$date];
                };

                foreach ($flights_direction as $key => $flight) {

                    // OPTIMIZATION: Cache OutputRoutes[0] (accessed 10+ times)
                    $outputRoute0 = $flight['OutputRoutes'][0];
                    $airline_iata = strtoupper($outputRoute0['Airline']['Code']);
                    $this->tickets['time'][$key] = [
                        'iata'=>$airline_iata,
                        'time' => (((microtime(true)-$start)*1000)/1000)
                    ];

                    if($outputRoute0['ArrivalTime'] !="") {
                        $ArrivalTime = substr($outputRoute0['ArrivalTime'],0,5) ;
                    }else{
                        $calculate_time = functions::CalculateArrivalTime(($info_route['Hour'] . ':' . $info_route['Minutes'] . ':00'), $outputRoute0['DepartureTime']);
                        $ArrivalTime = $calculate_time['time'];
                    }


                    $this->tickets['time'][$key]['arrival_time']= (((microtime(true)-$start)*1000)/1000);

                    // OPTIMIZATION: Use business cabin types lookup
                    $cabinType = $outputRoute0['CabinType'];
                    $businessCabinTypes = ['C' => true, 'J' => true, 'D' => true, 'I' => true, 'Z' => true];
                    $type_flight = isset($businessCabinTypes[$cabinType]) ? 'business' : 'economy';
                    $source_id = $flight['SourceId'];

                    // OPTIMIZATION: Cache date conversions
                    $departure_date = $outputRoute0['DepartureDate'];
                    if (!isset($dateConversionCache[$departure_date])) {
                        $dateConversionCache[$departure_date] = functions::convertDateFlight($departure_date);
                    }
                    $date_persian = $dateConversionCache[$departure_date];

                    $this->tickets['time'][$key]['date_persian']= (((microtime(true)-$start)*1000)/1000);
                    $origin_name = ($direction == 'dept') ? $this->originName : $this->destinationName;
                    $destination_name = ($direction == 'dept') ? $this->destinationName : $this->originName;

                    $flightFortest = $flight;

                    // OPTIMIZATION: Use cached controller instances
                    $flight = $commissionController->sourceCommissionCalculation($flight , 'search');
                    $agencyBenefitSystemFlight = $commissionController->setAgencyBenefitSystemFlight($flight , 'search');

                    // OPTIMIZATION: Cache PassengerDatas array (accessed 15+ times)
                    $hasCapacity = $flight['Capacity'] != 0;
                    $passengerDatas = $hasCapacity ? $flight['PassengerDatas'] : null;
                    $hasChild = $hasCapacity && isset($flight['PassengerDatas'][1]['TotalPrice']);
                    $hasInfant = $hasCapacity && isset($flight['PassengerDatas'][2]['TotalPrice']);

                    $passengerAdult = $hasCapacity ? $passengerDatas[0] : ['TotalPrice' => 0, 'BasePrice' => 0, 'TaxPrice' => 0, 'CommisionPrice' => 0];
                    $passengerChild = $hasChild ? $passengerDatas[1] : ['TotalPrice' => 0, 'BasePrice' => 0, 'TaxPrice' => 0, 'CommisionPrice' => 0];
                    $passengerInfant = $hasInfant ? $passengerDatas[2] : ['TotalPrice' => 0, 'BasePrice' => 0, 'TaxPrice' => 0, 'CommisionPrice' => 0];

                    // OPTIMIZATION: Cache flight type
                    $flightTypeLowerCase = strtolower($flight['FlightType']);

                    $data_change_price = array(
                        'airlineIata' => $outputRoute0['Airline']['Code'],
                        'FlightType' => $flightTypeLowerCase,
                        'typeZone' => $type_zone,
                        'typeFlight' => $type_flight,
                        'sourceId' => $source_id,
                        'isInternal' => true,
                        'price' => array(
                            'adult' => array(
                                'TotalPrice' => $passengerAdult['TotalPrice'],
                                'BasePrice' => $passengerAdult['BasePrice'],
                                'TaxPrice' => $passengerAdult['TaxPrice']
                            ),
                            'child' => array(
                                'TotalPrice' => $passengerChild['TotalPrice'],
                                'BasePrice' => $passengerChild['BasePrice'],
                                'TaxPrice' => $passengerChild['TaxPrice']
                            ),
                            'infant' => array(
                                'TotalPrice' => $passengerInfant['TotalPrice'],
                                'BasePrice' => $passengerInfant['BasePrice'],
                                'TaxPrice' => $passengerInfant['TaxPrice'],
                            ),
                        )
                    );


                    $price_change_calculate = $priceChangesController->setPriceChangesFlight($data_change_price, $data_param_set_change_price, $agencyBenefitSystemFlight);




                    $this->tickets['time'][$key]['price_change_calculate'] = (((microtime(true)-$start)*1000)/1000);
                    if ($price_change_calculate['adult']['TotalPrice'] > 0) {
                        $this->tickets['prices'][$direction][] = $price_change_calculate['adult']['TotalPrice'];
                    }


                    $this->tickets['time'][$key]['point_club ']= (((microtime(true)-$start)*1000)/1000);



                    // جمع‌آوری قیمت‌های همه پروازها برای هر ایرلاین
                    if (round($price_change_calculate['adult']['TotalPrice']) > 0) {
                        if ($flightTypeLowerCase == 'system' && ($isCounter || $isSafar360)) {
                            $price_airline[$direction][$airline_iata][] = ($price_change_calculate['adult']['TotalPriceWithDiscount'] > 0) ?
                                ($price_change_calculate['adult']['TotalPriceWithDiscount'] - $agencyBenefitSystemFlight['adult']) :
                                ($price_change_calculate['adult']['TotalPrice'] - $agencyBenefitSystemFlight['adult']);
                        } else {
                            $price_airline[$direction][$airline_iata][] = $price_change_calculate['adult']['TotalPriceWithDiscount'] > 0 ?
                                $price_change_calculate['adult']['TotalPriceWithDiscount'] :
                                $price_change_calculate['adult']['TotalPrice'];
                        }

                        // ذخیره نام ایرلاین برای استفاده در محاسبه نهایی
                        if (!isset($airlines_info[$airline_iata])) {
                            $airlines_info[$airline_iata] = $airlines_name[$airline_iata][$langFieldIndex];
                        }
                    }



                    $dept_arrival_date = ($flight['OutputRoutes'][0]['ArrivalDate'] !="") ?  $flight['OutputRoutes'][0]['ArrivalDate'] : functions::Date_arrival($flight['OutputRoutes'][0]['Departure']['Code'], $flight['OutputRoutes'][0]['Arrival']['Code'], $flight['OutputRoutes'][0]['DepartureTime'], $flight['OutputRoutes'][0]['DepartureDate']);
                    $this->tickets['time'][$key]['dept_arrival_date']= (((microtime(true)-$start)*1000)/1000);




                    // OPTIMIZATION: Cache checkConfigPid results با کلید ساده‌تر (بدون sourceId)
                    $checkPrivateCacheKey = $airline_iata . '_' . $flightTypeLowerCase;

                    if (!isset($checkPrivateCache[$checkPrivateCacheKey])) {
                        $checkPrivateCache[$checkPrivateCacheKey] = functions::checkConfigPid($airline_iata, 'internal', $flightTypeLowerCase, $flight['SourceId']);
                    }
                    $checkPrivate = $checkPrivateCache[$checkPrivateCacheKey];
                    $point_club = $this->pointClub($flight, $price_change_calculate , $checkPrivate);

                    if ($flight['FlightType'] == 'system') {

                        if ($checkPrivate = 'private') {
                            $markup_amount_adult =
                                $passengerAdult['CommisionPrice'];

                            $markup_amount_child =
                                $passengerChild['CommisionPrice'];

                            $markup_amount_infant =
                                $passengerInfant['CommisionPrice'];
                        } else {
                            $markup_amount_adult =
                                $agencyBenefitSystemFlight['adult'] ;

                            $markup_amount_child =
                                $agencyBenefitSystemFlight['child'] ;

                            $markup_amount_infant =
                                $agencyBenefitSystemFlight['infant'] ;
                        }

                    }
                    else {
                        $markup_amount_adult =
                            round($price_change_calculate['adult']['markup_amount']);

                        $markup_amount_child =
                            round($price_change_calculate['child']['markup_amount']);

                        $markup_amount_infant =
                            round($price_change_calculate['infant']['markup_amount']);

                    }

                    $this->tickets['flights'][$direction][$key] = [
                        'price' => [
                            'adult' => [
                                'price' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $price_change_calculate['adult']['TotalPrice'] : round($price_change_calculate['adult']['TotalPrice']),
                                'fare' => round($price_change_calculate['adult']['BasePrice']),
                                'tax' => round($price_change_calculate['adult']['TaxPrice']),
                                'with_discount' => round($price_change_calculate['adult']['TotalPriceWithDiscount']),
                                'has_discount' => $price_change_calculate['adult']['has_discount'],
                                'type_currency' => $price_change_calculate['adult']['type_currency'],
                                'price_with_out_currency' => round($price_change_calculate['adult']['price_with_out_currency']),
                                'price_discount_with_out_currency' => round($price_change_calculate['adult']['price_discount_with_out_currency']),
                                'originalPrice' =>  $flight['PassengerDatas'][0]['TotalPrice'],
                                'markup_amount' => $markup_amount_adult,
                                'p_fare_for_test' =>  $flightFortest['Capacity'] != 0 ? $flightFortest['PassengerDatas'][0]['BasePrice'] : 0 ,
                                'p_tax_for_test' =>  $flightFortest['Capacity'] != 0 ? $flightFortest['PassengerDatas'][0]['TaxPrice'] : 0
                            ],
                            'child' => [
                                'price' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $price_change_calculate['child']['TotalPrice'] : round($price_change_calculate['child']['TotalPrice']),
                                'fare' => round($price_change_calculate['child']['BasePrice']),
                                'tax' => round($price_change_calculate['child']['TaxPrice']),
                                'with_discount' => round($price_change_calculate['child']['TotalPriceWithDiscount']),
                                'has_discount' => $price_change_calculate['child']['has_discount'],
                                'type_currency' => $price_change_calculate['child']['type_currency'],
                                'price_with_out_currency' => round($price_change_calculate['child']['price_with_out_currency']),
                                'price_discount_with_out_currency' => round($price_change_calculate['child']['price_discount_with_out_currency']),
                                'markup_amount' => $markup_amount_child,
                                'p_fare_for_test' =>  $flightFortest['Capacity'] != 0 ? $flightFortest['PassengerDatas'][1]['BasePrice'] : 0 ,
                                'p_tax_for_test' =>  $flightFortest['Capacity'] != 0 ? $flightFortest['PassengerDatas'][1]['TaxPrice'] : 0
                            ],
                            'infant' => [
                                'price' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $price_change_calculate['infant']['TotalPrice'] : round($price_change_calculate['infant']['TotalPrice']),
                                'fare' => round($price_change_calculate['infant']['BasePrice']),
                                'tax' => round($price_change_calculate['infant']['TaxPrice']),
                                'with_discount' => round($price_change_calculate['infant']['TotalPriceWithDiscount']),
                                'has_discount' => $price_change_calculate['infant']['has_discount'],
                                'type_currency' => $price_change_calculate['infant']['type_currency'],
                                'price_with_out_currency' => round($price_change_calculate['infant']['price_with_out_currency']),
                                'price_discount_with_out_currency' => round($price_change_calculate['infant']['price_discount_with_out_currency']),
                                'markup_amount' => $markup_amount_infant,
                                'p_fare_for_test' =>  $flightFortest['Capacity'] != 0 ? $flightFortest['PassengerDatas'][2]['BasePrice'] : 0 ,
                                'p_tax_for_test' =>  $flightFortest['Capacity'] != 0 ? $flightFortest['PassengerDatas'][2]['TaxPrice'] : 0
                            ],
                        ],
                        'is_low_capacity'=> ($flight['Capacity'] > 0) ? !(($flight['Capacity'] < $count_search)) : true,
                        'is_private'=> $checkPrivate ,
                        'check_sort_reservation'=>'2',
                        'currency_code' => Session::getCurrency(),
                        'departure_name' => $origin_name,
                        'arrival_name' => $destination_name,
                        'time_flight_name' => ($flight['OutputRoutes'][0]['FlightTime'] !="")  ? functions::classTimeLOCAL($flight['OutputRoutes'][0]['FlightTime'],false)  : functions::classTimeLOCAL(functions::format_hour($flight['OutputRoutes'][0]['DepartureTime']), false),
                        'flight_number' => $flight['OutputRoutes'][0]['FlightNo'],
                        'airline' => $airline_iata,
                        'airline_name' => $airlines_name[$airline_iata][$langFieldIndex],
                        'airline_name_en' => $airlines_name[$airline_iata][$langFieldIndexEn],
                        'departure_date' => $getConvertedDate($flight['OutputRoutes'][0]['DepartureDate']),
                        'departure_time' => substr($flight['OutputRoutes'][0]['DepartureTime'], 0, 5),
                        'duration_time' =>  ($flight['OutputRoutes'][0]['FlightTime'] !="") ?  $flight['OutputRoutes'][0]['FlightTime'] : $info_route['Hour'] . ':' . $info_route['Minutes'],
                        'arrival_date' =>   $dept_arrival_date,
                        'arrival_time' => $ArrivalTime,
                        'departure_code' => $flight['OutputRoutes'][0]['Departure']['Code'],
                        'arrival_code' => $flight['OutputRoutes'][0]['Arrival']['Code'],
                        'aircraft' => $flight['OutputRoutes'][0]['Aircraft']['Manufacturer'],
                        'flight_type' => (strtolower($flight['FlightType']) == "system") ? $translateVariable['system_flight'] : $translateVariable['charter_flight'],
                        'flight_type_li' => (strtolower($flight['FlightType']) == "system") ? 'system' : 'charter',
                        'persian_departure_date' => $date_persian,
                        'description' => $flight['Description'],
                        'seat_class' => (
                        ($flight['OutputRoutes'][0]['CabinType'] == 'C' || $flight['OutputRoutes'][0]['CabinType'] == 'J' || $flight['OutputRoutes'][0]['CabinType'] == 'D' || $flight['OutputRoutes'][0]['CabinType'] == 'I' || $flight['OutputRoutes'][0]['CabinType'] == 'Z') ? $seatClassBusinessText :
                            (($flight['OutputRoutes'][0]['CabinType'] == 'PY' || $flight['OutputRoutes'][0]['CabinType'] == 'W' || $flight['OutputRoutes'][0]['CabinType'] == 'P' || $flight['OutputRoutes'][0]['CabinType'] == 'R') ? 'پریمیوم' : $seatClassEconomyText)
                        ),
                        'seat_class_en' => (
                        ($flight['OutputRoutes'][0]['CabinType'] == 'C' || $flight['OutputRoutes'][0]['CabinType'] == 'J' || $flight['OutputRoutes'][0]['CabinType'] == 'D' || $flight['OutputRoutes'][0]['CabinType'] == 'I' || $flight['OutputRoutes'][0]['CabinType'] == 'Z') ? 'business' :
                            (($flight['OutputRoutes'][0]['CabinType'] == 'PY' || $flight['OutputRoutes'][0]['CabinType'] == 'W' || $flight['OutputRoutes'][0]['CabinType'] == 'P' || $flight['OutputRoutes'][0]['CabinType'] == 'R') ? 'premium_economy' : 'economy')
                        ),
                        'cabin_type' => $flight['OutputRoutes'][0]['CabinType'],
                        'capacity' => ($flight['Capacity'] > 10) ? 9 : $flight['Capacity'],
                        'source_id' => !empty($flight['SourceId']) ? $flight['SourceId'] : '',
                        'source_name' => !empty($flight['SourceName']) ? $flight['SourceName'] : '',
                        'unique_code' => $flight['Code'],
                        'point_club' => (($point_club > 0) ? $point_club : 0),
                        'flight_id' => $flight['FlightID'],
                        'baggage' => ($flight['OutputRoutes'][0]['Baggage']['Code'] > 0) ? $this->baggageTitle($flight['SourceId'],$flight['OutputRoutes'][0],$translateVariable):'20',
                    ];

                    if($direction == 'twoWay') {


                        foreach ($flight['OutputRoutes'] as $key_detail => $details_dept) {
                            $details_dept['type_route'] = 'dept' ;
                            $this->tickets['flights'][$direction][$key]['output_routes_detail'][$key_detail] = array(
                                'is_transit' => ($key_detail > 0) ? true : false,
                                'source_id' => $source_id,
                                'agency_id' => $flight['AgencyId'],
                                'request_number' => $flight['Code'],
                                'flight_id' => $flight['FlightID'],
                                'transit' => functions::duration_time_source($flight['SourceId'], $details_dept['transit'], $translateVariable),
                                'cabin_type' => $details_dept['CabinType'],
                                'flight_number' => $details_dept['FlightNo'],
                                'capacity' => ($flight['Capacity'] > 10) ? '+10' : $flight['Capacity'],
                                'departure_date' => $getConvertedDate($details_dept['DepartureDate']),
                                'departure_date_abbreviation' => functions::DateFormatType($details_dept['DepartureDate'], 'gregorian'),
                                'departure_time' => functions::format_hour($details_dept['DepartureTime']),
                                'arrival_date' => (!empty($details_dept['ArrivalDate'])) ? $getConvertedDate($details_dept['ArrivalDate']) : null,
                                'arrival_date_abbreviation' => (!empty($details_dept['ArrivalDate'])) ? functions::DateFormatType($details_dept['ArrivalDate'], 'gregorian') : null,
                                'arrival_time' => (!empty($details_dept['ArrivalDate'])) ? functions::format_hour($details_dept['ArrivalTime']) : null,
                                'duration_flight_time' => (!empty($details_dept['ArrivalDate'])) ? functions::format_hour($details_dept['FlightTime']) : null,
                                'seat_class' => (($details_dept['CabinType'] == 'C' || $details_dept['CabinType'] == 'J' || $details_dept['CabinType'] == 'D' || $details_dept['CabinType'] == 'I' || $details_dept['CabinType'] == 'Z') ? $seatClassBusinessText : $seatClassEconomyText),
                                'baggage' => array('code' => $details_dept['Baggage'][0]['Code'],
                                    'charge' => $details_dept['Baggage'][0]['Charge'],
                                    'type' => $details_dept['Baggage'][0]['Type'],
                                    'baggage_statement' => $this->baggageTitle($source_id, $details_dept, $translateVariable)
                                ),
                                'airline' => array(
                                    'airline_name' => $airlines_name[$details_dept['Airline']['Code']][$langFieldIndex],
                                    'airline_code' => $details_dept['Airline']['Code'],
                                    'airline_code_operator' => (isset($details_dept['Airline']['operator']) && $details_dept['Airline']['Code']  !== $details_dept['Airline']['operator']) ? $airlines_name[$details_dept['Airline']['operator']][$langFieldIndex]."({$details_dept['Airline']['operator']})" : NULL,
                                ),
                                'aircraft' => array(
                                    'aircraft_code' => $details_dept['Aircraft']['Code'],
                                    'aircraft_name' => $details_dept['Aircraft']['Name'],
                                    'aircraft_manufacturer' => $details_dept['Aircraft']['Manufacturer'],
                                ),
                                'departure' => array(
//                                    'departure_airport' => $airports[functions::mapIataCode($details_dept['Departure']['Code'])][functions::changeFieldNameByLanguage('Airport')],
//                                    'departure_city' => $airports[functions::mapIataCode($details_dept['Departure']['Code'])][functions::changeFieldNameByLanguage('DepartureCity')],
//                                    'departure_region_name' => $airports[functions::mapIataCode($details_dept['Departure']['Code'])][functions::changeFieldNameByLanguage('Country')],
//                                    'departure_code' => functions::mapIataCode($details_dept['Departure']['Code']),
                                ),
                                'arrival' => array(
//                                    'arrival_airport' => $airports[functions::mapIataCode($details_dept['Arrival']['Code'])][functions::changeFieldNameByLanguage('Airport')],
//                                    'arrival_city' => $airports[functions::mapIataCode($details_dept['Arrival']['Code'])][functions::changeFieldNameByLanguage('DepartureCity')],
//                                    'arrival_region_name' => $airports[functions::mapIataCode($details_dept['Arrival']['Code'])][functions::changeFieldNameByLanguage('Country')],
//                                    'arrival_code' => functions::mapIataCode($details_dept['Arrival']['Code']),
                                ),
                            );
                        }
                        // OPTIMIZATION: Reuse cached checkConfigPid result
                        // $checkPrivate is already calculated above, no need to recalculate


                        if (!empty($flight['ReturnRoutes'])) {

                            $date_persian_return = $flight['ReturnRoutes'][0]['DepartureDate'];
                            $count_detail_return_rout = count($flight['ReturnRoutes']);
                            $Key_route_return = ($count_detail_return_rout - 1);

                            $this->tickets['flights'][$direction][$key]['return_routes'] = array(
                                'airline' => $flight['ReturnRoutes'][0]['Airline']['Code'],
                                'capacity' => ($flight['Capacity'] > 10) ? '+10' : $flight['Capacity'],
                                'is_private'=> $checkPrivate ,
                                'airline_name' => $airlines_name[$flight['ReturnRoutes'][0]['Airline']['Code']][$langFieldIndex],
                                'airline_name_en' => $airlines_name[$flight['ReturnRoutes'][0]['Airline']['Code']][$langFieldIndexEn],
                                'departure_name' => $this->destinationName,
                                'arrival_name' => $this->originName,
                                'return_flight_id' => $flight['ReturnFlightID'],
                                'airport_departure_name' => $this->InfoSearch['airport_arrival'],
                                'airport_arrival_name' => $this->InfoSearch['airport_departure'],
                                'flight_number_return' => $flight['ReturnRoutes'][0]['FlightNo'],
                                'departure_parent_region_name' => $flight['ReturnRoutes'][0]['Departure']['ParentRegionName'],
                                'departure_code' => $flight['ReturnRoutes'][0]['Departure']['Code'],
                                'departure_date' => $getConvertedDate($flight['ReturnRoutes'][0]['DepartureDate']),
                                'departure_time' => substr($flight['ReturnRoutes'][0]['DepartureTime'], 0, 5),
                                'arrival_date' => !empty($details_return['ArrivalDate']) ? $getConvertedDate($flight['ReturnRoutes'][$Key_route_return]['ArrivalDate']) : null,
                                'arrival_time' => !empty($flight['ReturnRoutes'][$Key_route_return]['ArrivalTime']) ? substr($flight['ReturnRoutes'][$Key_route_return]['ArrivalTime'], 0, 5) : null,
                                'arrival_parent_region_name' => $flight['ReturnRoutes'][$Key_route_return]['Arrival']['ParentRegionName'],
                                'arrival_code' => $flight['ReturnRoutes'][$Key_route_return]['Arrival']['Code'],
                                'aircraft' => $flight['ReturnRoutes'][$Key_route_return]['Aircraft']['Manufacturer'],
                                'persian_departure_date' => $date_persian_return,
                                'cabin_type' => $flight['ReturnRoutes'][$Key_route_return]['CabinType'],
                                'count_interrupt_return' => functions::countInterrupt($count_detail_return_rout),
                                'count_transit_return' => ($count_detail_return_rout - 1),
                                'count_transit_title' => 0,
                                'flight_id' => $flight['FlightID'],
                                'total_return_flight_duration' => functions::duration_time_source($flight['SourceId'], $flight['TotalReturnFlightDuration'], $translateVariable),
                                'total_return_stop_duration' => functions::duration_time_source($flight['SourceId'], $flight['TotalReturnStopDuration'], $translateVariable),
                                'duration_time_return' => functions::duration_time_source($flight['SourceId'], $flight['TotalReturnFlightDuration'], $translateVariable),
                            );

                            foreach ($flight['ReturnRoutes'] as $key_detail_return => $details_return) {
                                $details_return['type_route'] = 'return' ;
                                $this->tickets['flights'][$direction][$key]['return_routes']['return_route_detail'][$key_detail_return] = array(
                                    'is_transit' => $key_detail_return > 0,
                                    'source_id' => $source_id,
                                    'agency_id' => $flight['AgencyId'],
                                    'request_number' => $flight['Code'],
                                    'flight_id' => $flight['FlightID'],
                                    'transit' => functions::duration_time_source($flight['SourceId'], $details_return['transit'], $translateVariable),
                                    'cabin_type' => $details_return['CabinType'], 'flight_number' => $details_return['FlightNo'],
                                    'capacity' => ($flight['Capacity'] > 10) ? '+10' : $flight['Capacity'],
                                    'departure_date' => $getConvertedDate($details_return['DepartureDate']),
                                    'departure_date_abbreviation' => functions::DateFormatType($details_return['DepartureDate'], 'gregorian'),
                                    'departure_time' => functions::format_hour($details_return['DepartureTime']),
                                    'arrival_date' => (!empty($details_return['ArrivalDate'])) ? $getConvertedDate($details_return['ArrivalDate']) : null,
                                    'arrival_time' => functions::format_hour($details_return['ArrivalTime']),
                                    'arrival_date_abbreviation' => (!empty($details_return['ArrivalDate'])) ? functions::DateFormatType($details_return['ArrivalDate'], 'gregorian') : null,
                                    'duration_flight_time' => functions::format_hour($details_return['FlightTime']),
                                    'seat_class' => (($details_return['CabinType'] == 'C' || $details_return['CabinType'] == 'J' || $details_return['CabinType'] == 'D' || $details_return['CabinType'] == 'I' || $details_return['CabinType'] == 'Z') ? $seatClassBusinessXml : $seatClassEconomyXml),
                                    'baggage' => array(
                                        'code' => $details_return['Baggage'][0]['Code'],
                                        'charge' => $details_return['Baggage'][0]['Charge'],
                                        'type' => $details_return['Baggage'][0]['Type'],
                                        'baggage_statement' => $this->baggageTitle($source_id, $details_return,$translateVariable)
                                    ),
                                    'airline' => array(
                                        'airline_name' => $airlines_name[$details_return['Airline']['Code']][$langFieldIndex],
                                        'airline_code' => $details_return['Airline']['Code'],
                                        'airline_code_operator' => (($details_return['Airline']['Code']  !== $details_return['Airline']['operator']) && isset($details_return['Airline']['operator'])) ? $airlines_name[$details_return['Airline']['operator']][$langFieldIndex]."({$details_return['Airline']['operator']})" : NULL,
                                    ),
                                    'aircraft' => array(
                                        'aircraft_code' => $details_return['Aircraft']['Code'],
                                        'aircraft_name' => $details_return['Aircraft']['Name'],
                                        'aircraft_manufacturer' => $details_return['Aircraft']['Manufacturer'],
                                    ),
                                    'departure' => array(
//                                        'departure_airport' => $airports[functions::mapIataCode($details_return['Departure']['Code'])][functions::changeFieldNameByLanguage('Airport')],
//                                        'departure_city' => $airports[functions::mapIataCode($details_return['Departure']['Code'])][functions::changeFieldNameByLanguage('DepartureCity')],
//                                        'departure_region_name' => $airports[functions::mapIataCode($details_return['Departure']['Code'])][functions::changeFieldNameByLanguage('Country')],
//                                        'departure_code' => functions::mapIataCode($details_return['Departure']['Code']),
                                    ),
                                    'arrival' => array(
//                                        'arrival_airport' => $airports[functions::mapIataCode($details_return['Arrival']['Code'])][functions::changeFieldNameByLanguage('Airport')],
//                                        'arrival_city' => $airports[functions::mapIataCode($details_return['Arrival']['Code'])][functions::changeFieldNameByLanguage('DepartureCity')],
//                                        'arrival_region_name' => $airports[functions::mapIataCode($details_return['Arrival']['Code'])][functions::changeFieldNameByLanguage('Country')],
//                                        'arrival_code' => functions::mapIataCode($details_return['Arrival']['Code']),
                                    ),
                                );
                            }

                        } else {
                            $this->tickets['flights'][$key]['return_routes'] = array();
                        }
                    }

                    $this->tickets['time'][$key]['end_time']= (((microtime(true)-$start)*1000)/1000);

                }



                // محاسبه کمترین قیمت برای هر ایرلاین (بعد از پردازش همه پروازها)
                if (isset($price_airline[$direction]) && is_array($price_airline[$direction])) {
                    foreach ($price_airline[$direction] as $airline_iata => $prices) {
                        if (!empty($prices)) {
                            $price_currency_min = min($prices);
                            $this->tickets['min_price_airline'][$direction][$airline_iata] = array(
                                'name_en' => $airline_iata,
                                'price' => functions::numberFormat($price_currency_min),
                                'name' => isset($airlines_info[$airline_iata]) ? $airlines_info[$airline_iata] : '',
                            );
                        }
                    }
                }


                $this->tickets['time']['end'] = date('H:i:s',time());


                $this->tickets['before'][$direction] = $this->tickets['flights'][$direction];
                $this->tickets['time']['first_inactive'] = date('H:i:s',time());

                //مربوط به تنظیمات ایرلاین های پرواز های داخلی بود ، در یک زمانی در صفحه  https://admin.chartertech.ir/gds/itadmin/ticket/airlineClinetNewDomestic&id=378 تنظیم میکردیم که سرویس دهنده ای اول نمایش دهد و در صورتی که پرواز مشابه این نبود از سرویس دهنده دوم نمایش دهد ، کامنت کردیم تا همه تامین کنندگان را نمایش دهد هر چند تا تامین کننده که داشته باشه و وصل باشه

                $this->tickets['flights'][$direction] = $this->getController('resultLocal')->deleteInactiveAirline($this->tickets['flights'][$direction], 'isInternal', $data_param_set_change_price, 'new');


                $this->tickets['time']['end_inactive'] = date('H:i:s',time());
                $this->getReservationFlight($data_param_set_change_price);
                $this->tickets['time']['after_reservation'] = date('H:i:s',time());
                if (!empty($this->tickets['flights'])) {
                    $min = min($this->tickets['prices'][$direction]);
                    $max = max($this->tickets['prices'][$direction]);
                    $this->tickets['price'][$direction] = array(
                        'min_price' => floor($min),
                        'max_price' => ceil($max)
                    );

                }

                $sort = array();
                /*  foreach ($this->tickets['flights'][$direction] as $keySort => $arraySort) {
                      if ($arraySort['price']['adult']['price'] > 0) {
                          $sort['flights'][$direction]['price']['adult']['price'][$keySort] = $arraySort['price']['adult']['price'];
                      }
                  }

                  if (!empty($sort)) {
                      array_multisort($sort['flights'][$direction]['price']['adult']['price'], SORT_ASC, $this->tickets['flights'][$direction]);
                  }*/


                $sort = array();
                $sort_zero = array();

                foreach ($this->tickets['flights'][$direction] as $keySort => $arraySort) {
                    if ($arraySort['price']['adult']['price'] > 0 ) {
                        $sort[$direction][] = $arraySort;
                    } else {
                        $sort_zero[$direction][] = $arraySort;
                    }
                }

                $main_sort = array();
                foreach ($sort[$direction] as $key_main_sort => $item_sort)
                {
                    $main_sort['flights'][$direction]['price']['adult']['price'][$key_main_sort] = $item_sort['price']['adult']['price'];
                    $main_sort['check_sort_reservation'][$key_main_sort] = $item_sort['check_sort_reservation'];
                }


                if (!empty($main_sort)) {
                    array_multisort($main_sort['check_sort_reservation'], SORT_ASC, $main_sort['flights'][$direction]['price']['adult']['price'], SORT_ASC, $sort[$direction]);
                }



                $this->tickets['sortable']['main'] = $main_sort ;
                $this->tickets['sortable']['sort'] = $sort[$direction] ;
//                if ($_SERVER['REMOTE_ADDR'] == '178.131.184.101') {
//                    var_dump($direction,$sort);
//                    die();
//                }
                $this->tickets['count_flights'] = count($sort[$direction]) ;
                if (!empty($sort[$direction]) && !empty($sort_zero[$direction])) {
                    $this->tickets[$direction]['is_complete'] = false ;
                    $this->tickets['flights'][$direction] = array_merge($sort[$direction], $sort_zero[$direction]);
                } elseif (empty($sort[$direction]) && !empty($sort_zero[$direction])) {
                    $this->tickets[$direction]['is_complete'] = true ;
                    $this->tickets['flights'][$direction] = $sort_zero[$direction];
                } else {
                    $this->tickets[$direction]['is_complete'] = false ;
                    $this->tickets['flights'][$direction] = $sort[$direction];
                }
            }

            $this->tickets['time']['end_direction'] = date('H:i:s',time());
            functions::insertLog(json_encode($this->tickets,256|64),'a_check_flight');

            functions::insertLog('***************************************','a_check_flight');


            if (!empty($this->tickets['flights']['dept'])) {
                return functions::withSuccess($this->tickets, 200, ' data flight fetch  successfully');
            } elseif (empty($flights)) {
                $this->getReservationFlight($data_param_set_change_price, 'yes') ;
                return functions::withSuccess($this->tickets, 200, 'successfully catch flight');
            }
            return functions::withError($request_numbers, 404, "there aren't flight for this search ss");

        }

        return functions::withError($request_numbers, 404, "there aren't flight for this search");

    }
    #endregion

    #region revalidateFlight

    public function getLongTimeFlightInternal($param1, $param2, $data_translate) {

        $flight_route = $this->getModel('flightRouteModel')->get()->where('Departure_Code', $param1)->where('Arrival_Code', $param2)->find();
        if (!empty($flight_route['TimeLongFlight'])) {
            $explode_date = explode(':', $flight_route['TimeLongFlight']);
            $jmktime = dateTimeSetting::jmktime($explode_date[0], $explode_date[1], $explode_date[2]);

            $data['Hour'] = dateTimeSetting::jdate("H", $jmktime, '', '', 'en');
            $data['Minutes'] = dateTimeSetting::jdate("i", $jmktime, '', '', 'en');

            return $data;
        }
        return $data_translate['Unknown'];

    }

    #endregion

    public function revalidateFlight($params) {

        $result = json_decode($this->getLibrary('apiLocal')->revalidate($params), true);
        if ($result['result_status'] == 'Error') {
            return functions::withError($result, 405, 'data wrong');
        }
        return functions::withSuccess($result, 200, 'data fetch successfully');
    }

    public function getInfoBaggage($params) {

        $airports = $this->airportPortalList();

        $result_baggage_info = array();
        $lang = SOFTWARE_LANG != 'fa' ? 'en' : 'fa';

        $url = $this->apiAddress . 'Flight/getAirBaggage/' . $params['request_number'];
        $data_request = json_encode($params, 256 | 64);
        $results = functions::curlExecution($url, $data_request, 'json');

        if (!empty($results)) {
            foreach ($results['BaggageInfoes'] as $result) {
                $result_baggage_info[] = array(
                    'origin' => $airports[$result['Departure']]['DepartureCity' . ucfirst($lang)],
                    'destination' => $airports[$result['Arrival']]['DepartureCity' . ucfirst($lang)],
                    'amount_baggage' => !empty($result['Baggage']) ? $result['Baggage'] : functions::Xmlinformation('NoBaggage')->__toString(),
                );
            }
            return functions::withSuccess($result_baggage_info, 200, 'data is fetch successfully');
        }

        return functions::withError($result_baggage_info, 400, '');

    }

    public function getInfoRulesFlight($params) {
        $url = $this->apiAddress . 'Flight/getAirRules/' . $params['request_number'];
        unset($params['request_number']);
        $data_request = json_encode($params, 256 | 64);
        $results = functions::curlExecution($url, $data_request, 'json');
        return functions::withSuccess($results, 200, 'data is fetch successfully');


    }

    public function getFeeCancel($params) {

        return $this->getController('cancellationFeeSetting')->feeByAirlineAndCabinType($params);
    }

    public function getPopularInternationalFlight($params) {
        $result = $this->getController('routeFlight')->getPopularInternationFlight($params);
        return functions::withSuccess($result, 200, 'data is fetch successfully');
    }

    public function getSourceClient() {

        $result = $this->getController('settingCore')->getInfoAgencySource($this->username);

        functions::insertLog('data source with user name==>' . $this->username . ' and result=====>' . json_encode($result, 256), 'source_each_client');

        return functions::withSuccess($result, 200, 'data is fetch successfully');
    }

    /**
     * @param $typeRoutForeign
     * @param $rec
     * @param array $existSource8Airline
     * @return bool
     */
    private function checkSourceRoute($typeRoutForeign, $rec, $existSource8Airline) {
        $check_source = (($typeRoutForeign != 'Return' && $rec['SourceId'] =='8') || ($typeRoutForeign == 'Return' && $rec['SourceId'] =='16')) ;
        return
            $check_source && (
            (
                in_array(strtoupper($rec['DepartureCode']), functions::airPortForSourceSeven())
                &&
                in_array(strtoupper($rec['ArrivalCode']), functions::airPortForSourceSeven())
            )
            );
    }


    public function getRangePriceFlight($params) {

        $cities = functions::getIataMinPriceParto();


        $dataCacheAverageController =  $this->getController('cacheAveragePriceFlight');

        $dataCacheAverage =  $dataCacheAverageController->getLastDataCacheAveragePriceFlight($params);

//        $user_names = ['ozhangasht','flymurshid','versagasht','myna','safarcenter'];
        if(empty($dataCacheAverage) || ($dataCacheAverage['creation_date_int'] < (time() - 3600)))
        {
            /*$user_name_selected = array_rand($user_names);
            $cacheUserNameUsedController = $this->getController('cacheUserNameUsed');
            $check_used = $cacheUserNameUsedController->getCacheUserNameUsed($user_names[$user_name_selected]);

            while ($check_used['creation_date_int'] > (time() - (3600 *5))) {
                $user_name_selected = array_rand($user_names);
                functions::insertLog('in_while==>' . $user_names[$user_name_selected], 'check_cache_userName_used');
                $check_used = $this->getController('cacheUserNameUsed')->getCacheUserNameUsed($user_names[$user_name_selected]);
            }

            functions::insertLog('after while==>' . $user_names[$user_name_selected], 'check_cache_userName_used');

            $cacheUserNameUsedController->insertCacheUserNameUsed($user_names[$user_name_selected]);*/
            if(in_array($params['origin'],$cities) && in_array($params['destination'],$cities)){

                $url = /*$this->apiAddress .*/'https://safar360.com/Core/V-1/Flight/getAveragePriceParto/flymurshid' ;//. $user_names[$user_name_selected]

                $time_now = time();

                $from_date = dateTimeSetting::jdate("Y-m-d", $time_now, '', '', 'en');

                $end_day_of_next_month = functions::getLastDateJalaliOfNextMonth();

                $data_json = json_encode([
                    'origin' => $params['origin'],
                    'destination' => $params['destination'],
                    'from_date' => $from_date,
                    'to_date' => $end_day_of_next_month,
                ], 256 | 64);


                $results = functions::curlExecution($url, $data_json, 'yes');

                functions::insertLog($data_json,'bCalender');
                functions::insertLog(json_encode($results,256|64),'bCalender');
                functions::insertLog('*******************','bCalender');
            }else{

                $results = [] ;
                $params['origin'] = str_replace('ALL','',$params['origin']);
                $params['destination'] = str_replace('ALL','',$params['destination']);
                $url = /*$this->apiAddress .*/ "http://safar360.com/Core/V-1/Flight/flightFifteenDay";
                $data_json =json_encode( array("Origin" => $params['origin'], "Destination" => $params['destination']));
                $results_charter = functions::curlExecution($url, $data_json, 'yes');
                functions::insertLog($data_json,'bCharterCalender');
                functions::insertLog(json_encode($results_charter,256|64),'bCharterCalender');
                functions::insertLog('*******************','bCharterCalender');

                if($results_charter['result']){

                    $results['status'] = $results_charter['result'] ;
                    $results['data']['Result'] = null ;
                    $results['data']['Success'] = true ;

                    $i = 0 ;
                    foreach ($results_charter['data'] as $key => $get_price) {
                        if($get_price['price_final'] > 0){
                            $results['data']['Result'][$i]['TravelDate'] = $get_price['date_flight'].'T00:00:00';
                            $results['data']['Result'][$i]['MinimumPrice'] = $get_price['price_final'];
                            $results['data']['Result'][$i]['AveragePrice'] = $get_price['price_final'];
                            $results['data']['Result'][$i]['MaximumPrice'] = $get_price['price_final'];
                            $results['data']['Result'][$i]['AirlineMinPrice'] =$get_price['iatA_code'];
                            $results['data']['Result'][$i]['AirlineMaxPrice'] = $get_price['iatA_code'];
                            $i++;
                        }
                    }
                }else{
                    $results['data']['Result'] = [];
                }
            }


            if ($results['status'] && !empty($results['data']['Result']) && empty($results['data']['Error'])) {
                $data_cache_average['origin'] = $params['origin'];
                $data_cache_average['destination'] = $params['destination'];
                $data_cache_average['results'] = $results;

                $dataCacheAverageController->insertDataCacheAveragePrice($data_cache_average);
            }
        }else{
            $results = json_decode($dataCacheAverage['data_price'],ture) ;
        }

        if($results['status'] && !empty($results['data']['Result']) && empty($results['data']['Error'])){

            $prices = [];
            $data_process = [];
            $airlines = $this->airlineList();
            foreach ($results['data']['Result'] as $key => $item) {
                $date = explode('T', $item['TravelDate']);
                if($params['language'] =='fa'){
                    $date_items = functions::ConvertToJalaliOfDateGregorian($date[0], "Y-m-d");
                }else{
                    $date_items = $date[0] ;
                }

                $explode_date = explode('-', $date_items);

                $data_process[$key]['year'] = $explode_date[0];
                $data_process[$key]['month'] = $explode_date[1] < 10 ? str_replace('0','', $explode_date[1]) :  $explode_date[1];
                $data_process[$key]['day'] = $explode_date[2] < 10 ? str_replace('0','', $explode_date[2]) : $explode_date[2]  ;
                $data_process[$key]['min_price'] =round( $item['MinimumPrice']/10000);
                $data_process[$key]['max_price'] = round($item['MaximumPrice']/10000);
                $data_process[$key]['price_average'] = round( $item['AveragePrice']/10000);

                $airline_codes_min = explode(',', $item['AirlineMinPrice']);
                $airline_codes_max = explode(',', $item['AirlineMaxPrice']);

                foreach ($airline_codes_min as $key_min_code => $item_min) {
                    $data_process[$key]['min_name_airlines'][] = isset($airlines[trim($item_min)]['name_fa']) ? $airlines[trim($item_min)]['name_fa'] : trim($item_min);
                }

                foreach ($airline_codes_max as $key_max_code => $item_max) {
                    $data_process[$key]['max_name_airlines'][] = isset($airlines[trim($item_max)]['name_fa']) ? $airlines[trim($item_max)]['name_fa'] : trim($item_max);
                }
            }

            return functions::withSuccess($data_process,200,$results['message']);
        }

        return functions::withError([],404,'عدم دریافت نتیجه');
    }

    public function configHotelatoFlightInternational($params) {//برای هتلاتو فقط انجام میشه و برای بقیه همون روند عادیه

        $flights=[];
        if($params['type_search']=='twoWay'){
            foreach ($params['data_search'] as $data_search) {
                /* if(strtolower($data_search['FlightType'])=='system'){
                     if(!in_array($data_search['OutputRoutes'][0]['Airline']['Code'],$params['airline_local_list'])){
                         $flights[]= $data_search;
                     }
                 }else*/if($data_search['SourceId']=='14'){
                    $flights[]= $data_search;
                }
            }
        }else {
            foreach ($params['data_search'] as $data_search) {
                if (strtolower($data_search['FlightType']) == 'system') {
                    if (in_array($data_search['OutputRoutes'][0]['Airline']['Code'], $params['airline_local_list'])) {
                        functions::insertLog($data_search['OutputRoutes'][0]['Airline']['Code'],'000000');
                        if ($data_search['SourceId'] == '8') {
                            $flights[] = $data_search;
                        }
                    } else {
                        $flights[] = $data_search;
                    }
                } else {
                    $flights[] = $data_search;
                }
            }
        }

        return $flights ;
    }

    public static function setDataFakeFlight() {
        return json_decode('{"Messages":[],"ResultCount":"","ResultDuration":"52202 Millisecond","Flights":[{"Messages":[],"IsInternal":false,"id":2,"FlightID":"30626565353130346233353634386537626461663062366132383936346365372638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":17839500,"TaxPrice":1416520,"CommisionPrice":"0","TotalPrice":19256020}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"980","DepartureDate":"2024-05-04T18:20:00","PersianDepartureDate":"","DepartureTime":"18:20:00","ArrivalTime":"21:10:00","ArrivalDate":"2024-05-04T21:10:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:11:10","CabinType":"","FlightNo":"237","DepartureDate":"2024-05-05T08:20:00","PersianDepartureDate":"","DepartureTime":"08:20:00","ArrivalTime":"14:10:00","ArrivalDate":"2024-05-05T14:10:00","FlightTime":"13:50","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"BOS","ParentRegionName":""}},{"transit":"0:05:30","CabinType":"","FlightNo":"5797","DepartureDate":"2024-05-05T19:40:00","PersianDepartureDate":"","DepartureTime":"19:40:00","ArrivalTime":"21:35:00","ArrivalDate":"2024-05-05T21:35:00","FlightTime":"01:55","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"BOS","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:18:05","TotalOutputStopDuration":"0:16:40","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"63633638643565396437393034626365383863363962613130343831333765352638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":19646340,"TaxPrice":1472520,"CommisionPrice":"0","TotalPrice":21118860}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"978","DepartureDate":"2024-05-04T04:30:00","PersianDepartureDate":"","DepartureTime":"04:30:00","ArrivalTime":"07:20:00","ArrivalDate":"2024-05-04T07:20:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:01:00","CabinType":"","FlightNo":"237","DepartureDate":"2024-05-04T08:20:00","PersianDepartureDate":"","DepartureTime":"08:20:00","ArrivalTime":"14:10:00","ArrivalDate":"2024-05-04T14:10:00","FlightTime":"13:50","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"BOS","ParentRegionName":""}},{"transit":"0:05:30","CabinType":"","FlightNo":"5797","DepartureDate":"2024-05-04T19:40:00","PersianDepartureDate":"","DepartureTime":"19:40:00","ArrivalTime":"21:35:00","ArrivalDate":"2024-05-04T21:35:00","FlightTime":"01:55","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"BOS","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:18:05","TotalOutputStopDuration":"0:06:30","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"61303332643632383933393234643062613036363838373538343639656630372638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":19646340,"TaxPrice":1518160,"CommisionPrice":"0","TotalPrice":21164500}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"2491","DepartureDate":"2024-05-04T00:45:00","PersianDepartureDate":"","DepartureTime":"00:45:00","ArrivalTime":"03:25:00","ArrivalDate":"2024-05-04T03:25:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:04:55","CabinType":"","FlightNo":"237","DepartureDate":"2024-05-04T08:20:00","PersianDepartureDate":"","DepartureTime":"08:20:00","ArrivalTime":"14:10:00","ArrivalDate":"2024-05-04T14:10:00","FlightTime":"13:50","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"BOS","ParentRegionName":""}},{"transit":"0:05:30","CabinType":"","FlightNo":"5797","DepartureDate":"2024-05-04T19:40:00","PersianDepartureDate":"","DepartureTime":"19:40:00","ArrivalTime":"21:35:00","ArrivalDate":"2024-05-04T21:35:00","FlightTime":"01:55","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"BOS","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:55","TotalOutputStopDuration":"0:10:25","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"38303037373632396532353334323134386435353933343533363033643839662638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":19639620,"TaxPrice":5842760,"CommisionPrice":"0","TotalPrice":25482380}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"491","DepartureDate":"2024-05-04T05:10:00","PersianDepartureDate":"","DepartureTime":"05:10:00","ArrivalTime":"06:45:00","ArrivalDate":"2024-05-04T06:45:00","FlightTime":"02:05","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""}},{"transit":"0:01:20","CabinType":"","FlightNo":"701","DepartureDate":"2024-05-04T08:05:00","PersianDepartureDate":"","DepartureTime":"08:05:00","ArrivalTime":"15:20:00","ArrivalDate":"2024-05-04T15:20:00","FlightTime":"14:15","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"JFK","ParentRegionName":""}},{"transit":"0:04:24","CabinType":"","FlightNo":"9049","DepartureDate":"2024-05-04T19:44:00","PersianDepartureDate":"","DepartureTime":"19:44:00","ArrivalTime":"21:40:00","ArrivalDate":"2024-05-04T21:40:00","FlightTime":"01:56","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AA","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"JFK","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:18:16","TotalOutputStopDuration":"0:05:44","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"31663831616531353765623634653761623765623236663532643661323636372638392634383831303334","ReturnFlightID":"","Capacity":7,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":23502360,"TaxPrice":5143600,"CommisionPrice":"0","TotalPrice":28645960}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"491","DepartureDate":"2024-05-04T05:10:00","PersianDepartureDate":"","DepartureTime":"05:10:00","ArrivalTime":"06:45:00","ArrivalDate":"2024-05-04T06:45:00","FlightTime":"02:05","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""}},{"transit":"0:01:35","CabinType":"","FlightNo":"763","DepartureDate":"2024-05-04T08:20:00","PersianDepartureDate":"","DepartureTime":"08:20:00","ArrivalTime":"14:25:00","ArrivalDate":"2024-05-04T14:25:00","FlightTime":"13:05","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:03:05","CabinType":"","FlightNo":"2478","DepartureDate":"2024-05-04T17:30:00","PersianDepartureDate":"","DepartureTime":"17:30:00","ArrivalTime":"18:56:00","ArrivalDate":"2024-05-04T18:56:00","FlightTime":"01:26","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"PD","Logo":"","operator":"PD"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:36","TotalOutputStopDuration":"0:04:40","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"32633137353830653734393734303830386535346364303765636438626463342638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":30335900,"TaxPrice":1216740,"CommisionPrice":"0","TotalPrice":31552640}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"980","DepartureDate":"2024-05-04T18:20:00","PersianDepartureDate":"","DepartureTime":"18:20:00","ArrivalTime":"21:10:00","ArrivalDate":"2024-05-04T21:10:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:05:20","CabinType":"","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:9","TotalOutputStopDuration":"0:07:50","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"33623035323930623635356334666237616635636632383732633362623637642638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":30335900,"TaxPrice":1262380,"CommisionPrice":"0","TotalPrice":31598280}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"2303","DepartureDate":"2024-05-04T15:20:00","PersianDepartureDate":"","DepartureTime":"15:20:00","ArrivalTime":"17:55:00","ArrivalDate":"2024-05-04T17:55:00","FlightTime":"02:05","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:08:35","CabinType":"","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:54","TotalOutputStopDuration":"0:11:05","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3063363237666364326361663466653138396130303265396538633139326266263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":32899200,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":33413250}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"B","FlightNo":"978","DepartureDate":"2024-05-04T04:30:00","PersianDepartureDate":"","DepartureTime":"04:30:00","ArrivalTime":"07:20:00","ArrivalDate":"2024-05-04T07:20:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77W","Manufacturer":"77W","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:19:10","CabinType":"B","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"B","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QK","Logo":"","operator":"EK"},"Aircraft":{"Code":"DH4","Manufacturer":"DH4","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:9","TotalOutputStopDuration":"0:21:40","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3930656663356138333436643465613261306535643535636661376437623836263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":32899200,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":33413250}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"B","FlightNo":"978","DepartureDate":"2024-05-04T04:30:00","PersianDepartureDate":"","DepartureTime":"04:30:00","ArrivalTime":"07:20:00","ArrivalDate":"2024-05-04T07:20:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77W","Manufacturer":"77W","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:19:10","CabinType":"B","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:03:00","CabinType":"B","FlightNo":"5809","DepartureDate":"2024-05-05T11:00:00","PersianDepartureDate":"","DepartureTime":"11:00:00","ArrivalTime":"12:23:00","ArrivalDate":"2024-05-05T12:23:00","FlightTime":"01:23","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":"223","Manufacturer":"223","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:13","TotalOutputStopDuration":"0:22:10","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3037316563346563306461313438306261613633663233636337306463393933263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":32899200,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":33413250}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"B","FlightNo":"972","DepartureDate":"2024-05-04T10:40:00","PersianDepartureDate":"","DepartureTime":"10:40:00","ArrivalTime":"13:20:00","ArrivalDate":"2024-05-04T13:20:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77W","Manufacturer":"77W","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:13:10","CabinType":"B","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:03:00","CabinType":"B","FlightNo":"5809","DepartureDate":"2024-05-05T11:00:00","PersianDepartureDate":"","DepartureTime":"11:00:00","ArrivalTime":"12:23:00","ArrivalDate":"2024-05-05T12:23:00","FlightTime":"01:23","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":"223","Manufacturer":"223","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:03","TotalOutputStopDuration":"0:16:10","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"6164626563346634623365313432653161366338316135663732303938373730263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":32899200,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":33413250}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"B","FlightNo":"972","DepartureDate":"2024-05-04T10:40:00","PersianDepartureDate":"","DepartureTime":"10:40:00","ArrivalTime":"13:20:00","ArrivalDate":"2024-05-04T13:20:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77W","Manufacturer":"77W","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:13:10","CabinType":"B","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"B","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QK","Logo":"","operator":"EK"},"Aircraft":{"Code":"DH4","Manufacturer":"DH4","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:59","TotalOutputStopDuration":"0:15:40","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"6537376462376430626266363465343561633234643138646436393137353830263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":32899200,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":33413250}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"B","FlightNo":"980","DepartureDate":"2024-05-04T18:20:00","PersianDepartureDate":"","DepartureTime":"18:20:00","ArrivalTime":"21:10:00","ArrivalDate":"2024-05-04T21:10:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:05:20","CabinType":"B","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"B","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QK","Logo":"","operator":"EK"},"Aircraft":{"Code":"DH4","Manufacturer":"DH4","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:9","TotalOutputStopDuration":"0:07:50","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3364333139356134663732373466343038626534316566366535346365323937263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":32899200,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":33413250}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"B","FlightNo":"980","DepartureDate":"2024-05-04T18:20:00","PersianDepartureDate":"","DepartureTime":"18:20:00","ArrivalTime":"21:10:00","ArrivalDate":"2024-05-04T21:10:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:05:20","CabinType":"B","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:03:00","CabinType":"B","FlightNo":"5809","DepartureDate":"2024-05-05T11:00:00","PersianDepartureDate":"","DepartureTime":"11:00:00","ArrivalTime":"12:23:00","ArrivalDate":"2024-05-05T12:23:00","FlightTime":"01:23","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":"223","Manufacturer":"223","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:13","TotalOutputStopDuration":"0:08:20","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"6231383839643361306261643433303639653532623638616239333264383434263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":32899200,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":33481790}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"B","FlightNo":"2491","DepartureDate":"2024-05-04T00:45:00","PersianDepartureDate":"","DepartureTime":"00:45:00","ArrivalTime":"03:25:00","ArrivalDate":"2024-05-04T03:25:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:23:05","CabinType":"B","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"B","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QK","Logo":"","operator":"EK"},"Aircraft":{"Code":"DH4","Manufacturer":"DH4","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:59","TotalOutputStopDuration":"1:01:35","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3337336231393539633334313430346462363836316133353165343962326563263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":32899200,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":33481790}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"B","FlightNo":"2491","DepartureDate":"2024-05-04T00:45:00","PersianDepartureDate":"","DepartureTime":"00:45:00","ArrivalTime":"03:25:00","ArrivalDate":"2024-05-04T03:25:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:23:05","CabinType":"B","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:03:00","CabinType":"B","FlightNo":"5809","DepartureDate":"2024-05-05T11:00:00","PersianDepartureDate":"","DepartureTime":"11:00:00","ArrivalTime":"12:23:00","ArrivalDate":"2024-05-05T12:23:00","FlightTime":"01:23","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":"223","Manufacturer":"223","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:03","TotalOutputStopDuration":"1:02:05","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3730653266643437316564303463323961306334333631636261626439636163263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":32899200,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":33481790}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"B","FlightNo":"2374","DepartureDate":"2024-05-04T09:45:00","PersianDepartureDate":"","DepartureTime":"09:45:00","ArrivalTime":"12:25:00","ArrivalDate":"2024-05-04T12:25:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:14:05","CabinType":"B","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"B","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QK","Logo":"","operator":"EK"},"Aircraft":{"Code":"DH4","Manufacturer":"DH4","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:59","TotalOutputStopDuration":"0:16:35","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"6535353263333037313738633462343239623163316462613236303265633639263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":32899200,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":33481790}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"B","FlightNo":"2374","DepartureDate":"2024-05-04T09:45:00","PersianDepartureDate":"","DepartureTime":"09:45:00","ArrivalTime":"12:25:00","ArrivalDate":"2024-05-04T12:25:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:14:05","CabinType":"B","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:03:00","CabinType":"B","FlightNo":"5809","DepartureDate":"2024-05-05T11:00:00","PersianDepartureDate":"","DepartureTime":"11:00:00","ArrivalTime":"12:23:00","ArrivalDate":"2024-05-05T12:23:00","FlightTime":"01:23","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":"223","Manufacturer":"223","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:03","TotalOutputStopDuration":"0:17:05","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"6464303666373335313565343438343639386630663661633963616233363861263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":32899200,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":33481790}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"B","FlightNo":"2303","DepartureDate":"2024-05-04T15:10:00","PersianDepartureDate":"","DepartureTime":"15:10:00","ArrivalTime":"17:50:00","ArrivalDate":"2024-05-04T17:50:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:08:40","CabinType":"B","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:03:00","CabinType":"B","FlightNo":"5809","DepartureDate":"2024-05-05T11:00:00","PersianDepartureDate":"","DepartureTime":"11:00:00","ArrivalTime":"12:23:00","ArrivalDate":"2024-05-05T12:23:00","FlightTime":"01:23","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":"223","Manufacturer":"223","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:03","TotalOutputStopDuration":"0:11:40","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"6235313630323732386331303462636539663139313038343830623931376664263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":32899200,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":33481790}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"B","FlightNo":"2303","DepartureDate":"2024-05-04T15:10:00","PersianDepartureDate":"","DepartureTime":"15:10:00","ArrivalTime":"17:50:00","ArrivalDate":"2024-05-04T17:50:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:08:40","CabinType":"B","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"B","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QK","Logo":"","operator":"EK"},"Aircraft":{"Code":"DH4","Manufacturer":"DH4","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:59","TotalOutputStopDuration":"0:11:10","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3235333465363439643731313437303461323833336665653738613536616437263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":33516060,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":34030110}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"U","FlightNo":"978","DepartureDate":"2024-05-04T04:30:00","PersianDepartureDate":"","DepartureTime":"04:30:00","ArrivalTime":"07:20:00","ArrivalDate":"2024-05-04T07:20:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77W","Manufacturer":"77W","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:20:10","CabinType":"U","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"388","Manufacturer":"388","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:20","TotalOutputStopDuration":"0:20:10","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3137353836333761663135353436386461383937666135306261333730666262263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":33516060,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":34030110}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"U","FlightNo":"972","DepartureDate":"2024-05-04T10:40:00","PersianDepartureDate":"","DepartureTime":"10:40:00","ArrivalTime":"13:20:00","ArrivalDate":"2024-05-04T13:20:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77W","Manufacturer":"77W","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:14:10","CabinType":"U","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"388","Manufacturer":"388","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:10","TotalOutputStopDuration":"0:14:10","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3436663534633165366430633432616638393432663136666534383532303831263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":33516060,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":34030110}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"U","FlightNo":"980","DepartureDate":"2024-05-04T18:20:00","PersianDepartureDate":"","DepartureTime":"18:20:00","ArrivalTime":"21:10:00","ArrivalDate":"2024-05-04T21:10:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:06:20","CabinType":"U","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"388","Manufacturer":"388","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:20","TotalOutputStopDuration":"0:06:20","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3464386433363537396166393436346539373135663237363132336235303033263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":36189120,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":36771710}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"B","FlightNo":"2374","DepartureDate":"2024-05-04T09:45:00","PersianDepartureDate":"","DepartureTime":"09:45:00","ArrivalTime":"12:25:00","ArrivalDate":"2024-05-04T12:25:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:15:05","CabinType":"B","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"388","Manufacturer":"388","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:10","TotalOutputStopDuration":"0:15:05","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"6539346438376631363738303462346461373032376630326338316664326234263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":36189120,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":36771710}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"B","FlightNo":"2303","DepartureDate":"2024-05-04T15:10:00","PersianDepartureDate":"","DepartureTime":"15:10:00","ArrivalTime":"17:50:00","ArrivalDate":"2024-05-04T17:50:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:9:40","CabinType":"B","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"388","Manufacturer":"388","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:10","TotalOutputStopDuration":"0:9:40","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"32653361396530383036353934336535613532333065633064666234653438302638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":38442740,"TaxPrice":1535940,"CommisionPrice":"0","TotalPrice":39978680}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"978","DepartureDate":"2024-05-04T04:30:00","PersianDepartureDate":"","DepartureTime":"04:30:00","ArrivalTime":"07:20:00","ArrivalDate":"2024-05-04T07:20:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:20:10","CabinType":"","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:20","TotalOutputStopDuration":"0:20:10","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"38636166306338613231356534363935396139623766613634623432663435322638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":38442740,"TaxPrice":1535940,"CommisionPrice":"0","TotalPrice":39978680}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"972","DepartureDate":"2024-05-04T10:40:00","PersianDepartureDate":"","DepartureTime":"10:40:00","ArrivalTime":"13:20:00","ArrivalDate":"2024-05-04T13:20:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:14:10","CabinType":"","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:10","TotalOutputStopDuration":"0:14:10","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"39636263373466396665356134323633613764333561393639393363356138652638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":38442740,"TaxPrice":1535940,"CommisionPrice":"0","TotalPrice":39978680}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"980","DepartureDate":"2024-05-04T18:20:00","PersianDepartureDate":"","DepartureTime":"18:20:00","ArrivalTime":"21:10:00","ArrivalDate":"2024-05-04T21:10:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:06:20","CabinType":"","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:20","TotalOutputStopDuration":"0:06:20","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3862383934633363663134323438366538623239653630333362626236656461263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":45647640,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":46161690}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"X","FlightNo":"978","DepartureDate":"2024-05-04T04:30:00","PersianDepartureDate":"","DepartureTime":"04:30:00","ArrivalTime":"07:20:00","ArrivalDate":"2024-05-04T07:20:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77W","Manufacturer":"77W","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:19:10","CabinType":"X","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:03:00","CabinType":"X","FlightNo":"5809","DepartureDate":"2024-05-05T11:00:00","PersianDepartureDate":"","DepartureTime":"11:00:00","ArrivalTime":"12:23:00","ArrivalDate":"2024-05-05T12:23:00","FlightTime":"01:23","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":"223","Manufacturer":"223","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:13","TotalOutputStopDuration":"0:22:10","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3339313635353831316663393466393338383638306331343637663665633766263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":45647640,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":46161690}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"X","FlightNo":"978","DepartureDate":"2024-05-04T04:30:00","PersianDepartureDate":"","DepartureTime":"04:30:00","ArrivalTime":"07:20:00","ArrivalDate":"2024-05-04T07:20:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77W","Manufacturer":"77W","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:19:10","CabinType":"X","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"X","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QK","Logo":"","operator":"EK"},"Aircraft":{"Code":"DH4","Manufacturer":"DH4","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:9","TotalOutputStopDuration":"0:21:40","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3032656136363664663064363434383961376361613531323563626362626565263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":45647640,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":46161690}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"X","FlightNo":"972","DepartureDate":"2024-05-04T10:40:00","PersianDepartureDate":"","DepartureTime":"10:40:00","ArrivalTime":"13:20:00","ArrivalDate":"2024-05-04T13:20:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77W","Manufacturer":"77W","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:13:10","CabinType":"X","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"X","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QK","Logo":"","operator":"EK"},"Aircraft":{"Code":"DH4","Manufacturer":"DH4","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:59","TotalOutputStopDuration":"0:15:40","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"6438353661626132333066343439363261636432306263356339646130303964263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":45647640,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":46161690}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"X","FlightNo":"972","DepartureDate":"2024-05-04T10:40:00","PersianDepartureDate":"","DepartureTime":"10:40:00","ArrivalTime":"13:20:00","ArrivalDate":"2024-05-04T13:20:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77W","Manufacturer":"77W","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:13:10","CabinType":"X","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:03:00","CabinType":"X","FlightNo":"5809","DepartureDate":"2024-05-05T11:00:00","PersianDepartureDate":"","DepartureTime":"11:00:00","ArrivalTime":"12:23:00","ArrivalDate":"2024-05-05T12:23:00","FlightTime":"01:23","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":"223","Manufacturer":"223","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:03","TotalOutputStopDuration":"0:16:10","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3739383731343439663764663436663639636661326638303233376130373631263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":45647640,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":46161690}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"X","FlightNo":"980","DepartureDate":"2024-05-04T18:20:00","PersianDepartureDate":"","DepartureTime":"18:20:00","ArrivalTime":"21:10:00","ArrivalDate":"2024-05-04T21:10:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:05:20","CabinType":"X","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:03:00","CabinType":"X","FlightNo":"5809","DepartureDate":"2024-05-05T11:00:00","PersianDepartureDate":"","DepartureTime":"11:00:00","ArrivalTime":"12:23:00","ArrivalDate":"2024-05-05T12:23:00","FlightTime":"01:23","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":"223","Manufacturer":"223","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:13","TotalOutputStopDuration":"0:08:20","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3233393737363663613134343437656461346361626232353030326165643431263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":45647640,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":46161690}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"X","FlightNo":"980","DepartureDate":"2024-05-04T18:20:00","PersianDepartureDate":"","DepartureTime":"18:20:00","ArrivalTime":"21:10:00","ArrivalDate":"2024-05-04T21:10:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:05:20","CabinType":"X","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"X","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QK","Logo":"","operator":"EK"},"Aircraft":{"Code":"DH4","Manufacturer":"DH4","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:9","TotalOutputStopDuration":"0:07:50","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"6262666138653839643936303436363462386139623139653534633234386338263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":47498220,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":48012270}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"X","FlightNo":"978","DepartureDate":"2024-05-04T04:30:00","PersianDepartureDate":"","DepartureTime":"04:30:00","ArrivalTime":"07:20:00","ArrivalDate":"2024-05-04T07:20:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77W","Manufacturer":"77W","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:20:10","CabinType":"X","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"388","Manufacturer":"388","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:20","TotalOutputStopDuration":"0:20:10","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"6435373964373938386138623433326161366462376137363637653333376634263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":47498220,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":48012270}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"X","FlightNo":"972","DepartureDate":"2024-05-04T10:40:00","PersianDepartureDate":"","DepartureTime":"10:40:00","ArrivalTime":"13:20:00","ArrivalDate":"2024-05-04T13:20:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77W","Manufacturer":"77W","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:14:10","CabinType":"X","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"388","Manufacturer":"388","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:10","TotalOutputStopDuration":"0:14:10","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3164653032333239396137373461636662326564623165626161643832316664263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":47498220,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":48012270}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"X","FlightNo":"980","DepartureDate":"2024-05-04T18:20:00","PersianDepartureDate":"","DepartureTime":"18:20:00","ArrivalTime":"21:10:00","ArrivalDate":"2024-05-04T21:10:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:06:20","CabinType":"X","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"388","Manufacturer":"388","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:20","TotalOutputStopDuration":"0:06:20","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"31316530306462343862353734613531616264353738666364316463346662622638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":50678880,"TaxPrice":1961120,"CommisionPrice":"0","TotalPrice":52640000}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"2374","DepartureDate":"2024-05-04T09:45:00","PersianDepartureDate":"","DepartureTime":"09:45:00","ArrivalTime":"12:25:00","ArrivalDate":"2024-05-04T12:25:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:15:05","CabinType":"","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:10","TotalOutputStopDuration":"0:15:05","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"30653137663239666262386634353162616266303532653633386263616238332638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":50678880,"TaxPrice":1961120,"CommisionPrice":"0","TotalPrice":52640000}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"2303","DepartureDate":"2024-05-04T15:20:00","PersianDepartureDate":"","DepartureTime":"15:20:00","ArrivalTime":"17:55:00","ArrivalDate":"2024-05-04T17:55:00","FlightTime":"02:05","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:9:35","CabinType":"","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:05","TotalOutputStopDuration":"0:9:35","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3161353037646665303036663430306139383866303133333133383933356432263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":60726440,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":61309030}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"X","FlightNo":"2491","DepartureDate":"2024-05-04T00:45:00","PersianDepartureDate":"","DepartureTime":"00:45:00","ArrivalTime":"03:25:00","ArrivalDate":"2024-05-04T03:25:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:23:05","CabinType":"X","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:03:00","CabinType":"X","FlightNo":"5809","DepartureDate":"2024-05-05T11:00:00","PersianDepartureDate":"","DepartureTime":"11:00:00","ArrivalTime":"12:23:00","ArrivalDate":"2024-05-05T12:23:00","FlightTime":"01:23","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":"223","Manufacturer":"223","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:03","TotalOutputStopDuration":"1:02:05","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3437343537613563623336663461363961613865646566323834626338376338263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":60726440,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":61309030}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"X","FlightNo":"2491","DepartureDate":"2024-05-04T00:45:00","PersianDepartureDate":"","DepartureTime":"00:45:00","ArrivalTime":"03:25:00","ArrivalDate":"2024-05-04T03:25:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:23:05","CabinType":"X","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"X","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QK","Logo":"","operator":"EK"},"Aircraft":{"Code":"DH4","Manufacturer":"DH4","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:59","TotalOutputStopDuration":"1:01:35","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3538656262383838316465633437346661333831326239353466643162303032263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":60726440,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":61309030}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"X","FlightNo":"2374","DepartureDate":"2024-05-04T09:45:00","PersianDepartureDate":"","DepartureTime":"09:45:00","ArrivalTime":"12:25:00","ArrivalDate":"2024-05-04T12:25:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:14:05","CabinType":"X","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"X","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QK","Logo":"","operator":"EK"},"Aircraft":{"Code":"DH4","Manufacturer":"DH4","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:59","TotalOutputStopDuration":"0:16:35","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3436643866643164343737313433303838613532393661353539363061623039263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":60726440,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":61309030}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"X","FlightNo":"2374","DepartureDate":"2024-05-04T09:45:00","PersianDepartureDate":"","DepartureTime":"09:45:00","ArrivalTime":"12:25:00","ArrivalDate":"2024-05-04T12:25:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:14:05","CabinType":"X","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:03:00","CabinType":"X","FlightNo":"5809","DepartureDate":"2024-05-05T11:00:00","PersianDepartureDate":"","DepartureTime":"11:00:00","ArrivalTime":"12:23:00","ArrivalDate":"2024-05-05T12:23:00","FlightTime":"01:23","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":"223","Manufacturer":"223","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:03","TotalOutputStopDuration":"0:17:05","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"6164356337643736656132633439363962653961643339353463626539356365263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":60726440,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":61309030}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"X","FlightNo":"2303","DepartureDate":"2024-05-04T15:10:00","PersianDepartureDate":"","DepartureTime":"15:10:00","ArrivalTime":"17:50:00","ArrivalDate":"2024-05-04T17:50:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:08:40","CabinType":"X","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"X","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QK","Logo":"","operator":"EK"},"Aircraft":{"Code":"DH4","Manufacturer":"DH4","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:59","TotalOutputStopDuration":"0:11:10","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"6563633835643637336637613434306238663066313765346437303637613439263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":60726440,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":61309030}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"X","FlightNo":"2303","DepartureDate":"2024-05-04T15:10:00","PersianDepartureDate":"","DepartureTime":"15:10:00","ArrivalTime":"17:50:00","ArrivalDate":"2024-05-04T17:50:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:08:40","CabinType":"X","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:03:00","CabinType":"X","FlightNo":"5809","DepartureDate":"2024-05-05T11:00:00","PersianDepartureDate":"","DepartureTime":"11:00:00","ArrivalTime":"12:23:00","ArrivalDate":"2024-05-05T12:23:00","FlightTime":"01:23","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":"223","Manufacturer":"223","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:03","TotalOutputStopDuration":"0:11:40","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"6631363134656139663964393439353539326561333463663135396537613231263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":62577020,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":63159610}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"X","FlightNo":"2374","DepartureDate":"2024-05-04T09:45:00","PersianDepartureDate":"","DepartureTime":"09:45:00","ArrivalTime":"12:25:00","ArrivalDate":"2024-05-04T12:25:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:15:05","CabinType":"X","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"388","Manufacturer":"388","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:10","TotalOutputStopDuration":"0:15:05","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"6530653762306635336131623463613938366338333338663962633033336136263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":62577020,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":63159610}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"X","FlightNo":"2303","DepartureDate":"2024-05-04T15:10:00","PersianDepartureDate":"","DepartureTime":"15:10:00","ArrivalTime":"17:50:00","ArrivalDate":"2024-05-04T17:50:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:9:40","CabinType":"X","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"388","Manufacturer":"388","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:10","TotalOutputStopDuration":"0:9:40","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"33326363386431323266373734323234386366353362636363653731303261652638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":61810560,"TaxPrice":7356020,"CommisionPrice":"0","TotalPrice":69166580}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"491","DepartureDate":"2024-05-04T05:10:00","PersianDepartureDate":"","DepartureTime":"05:10:00","ArrivalTime":"06:45:00","ArrivalDate":"2024-05-04T06:45:00","FlightTime":"02:05","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""}},{"transit":"0:01:15","CabinType":"","FlightNo":"3","DepartureDate":"2024-05-04T08:00:00","PersianDepartureDate":"","DepartureTime":"08:00:00","ArrivalTime":"13:15:00","ArrivalDate":"2024-05-04T13:15:00","FlightTime":"07:15","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"LHR","ParentRegionName":""}},{"transit":"0:03:50","CabinType":"","FlightNo":"6299","DepartureDate":"2024-05-04T17:05:00","PersianDepartureDate":"","DepartureTime":"17:05:00","ArrivalTime":"19:55:00","ArrivalDate":"2024-05-04T19:55:00","FlightTime":"07:50","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"BA","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"LHR","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:10","TotalOutputStopDuration":"0:05:05","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"32366231376339646336313134343664623263383863316337366337656139312638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":61810560,"TaxPrice":7356020,"CommisionPrice":"0","TotalPrice":69166580}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"491","DepartureDate":"2024-05-04T05:10:00","PersianDepartureDate":"","DepartureTime":"05:10:00","ArrivalTime":"06:45:00","ArrivalDate":"2024-05-04T06:45:00","FlightTime":"02:05","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""}},{"transit":"0:02:10","CabinType":"","FlightNo":"7","DepartureDate":"2024-05-04T08:55:00","PersianDepartureDate":"","DepartureTime":"08:55:00","ArrivalTime":"14:10:00","ArrivalDate":"2024-05-04T14:10:00","FlightTime":"07:15","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"LHR","ParentRegionName":""}},{"transit":"0:02:55","CabinType":"","FlightNo":"6299","DepartureDate":"2024-05-04T17:05:00","PersianDepartureDate":"","DepartureTime":"17:05:00","ArrivalTime":"19:55:00","ArrivalDate":"2024-05-04T19:55:00","FlightTime":"07:50","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"BA","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"LHR","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:10","TotalOutputStopDuration":"0:05:05","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"63663966383966323137653534313564626463346564643332363339353635632638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":61810560,"TaxPrice":7356020,"CommisionPrice":"0","TotalPrice":69166580}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"499","DepartureDate":"2024-05-04T22:45:00","PersianDepartureDate":"","DepartureTime":"22:45:00","ArrivalTime":"00:20:00","ArrivalDate":"2024-05-05T00:20:00","FlightTime":"02:05","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""}},{"transit":"0:01:55","CabinType":"","FlightNo":"107","DepartureDate":"2024-05-05T02:15:00","PersianDepartureDate":"","DepartureTime":"02:15:00","ArrivalTime":"07:30:00","ArrivalDate":"2024-05-05T07:30:00","FlightTime":"07:15","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"LHR","ParentRegionName":""}},{"transit":"0:9:35","CabinType":"","FlightNo":"6299","DepartureDate":"2024-05-05T17:05:00","PersianDepartureDate":"","DepartureTime":"17:05:00","ArrivalTime":"19:55:00","ArrivalDate":"2024-05-05T19:55:00","FlightTime":"07:50","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"BA","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"LHR","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:10","TotalOutputStopDuration":"0:11:30","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"33613330356634343330363234613236613636323638303264633634353330632638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":61810560,"TaxPrice":7356020,"CommisionPrice":"0","TotalPrice":69166580}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"499","DepartureDate":"2024-05-04T22:45:00","PersianDepartureDate":"","DepartureTime":"22:45:00","ArrivalTime":"00:20:00","ArrivalDate":"2024-05-05T00:20:00","FlightTime":"02:05","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""}},{"transit":"0:07:10","CabinType":"","FlightNo":"9709","DepartureDate":"2024-05-05T07:30:00","PersianDepartureDate":"","DepartureTime":"07:30:00","ArrivalTime":"13:00:00","ArrivalDate":"2024-05-05T13:00:00","FlightTime":"07:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"BA","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"LHR","ParentRegionName":""}},{"transit":"0:04:05","CabinType":"","FlightNo":"6299","DepartureDate":"2024-05-05T17:05:00","PersianDepartureDate":"","DepartureTime":"17:05:00","ArrivalTime":"19:55:00","ArrivalDate":"2024-05-05T19:55:00","FlightTime":"07:50","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"BA","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"LHR","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:25","TotalOutputStopDuration":"0:11:15","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"65353133363766393239346534326638623736313738336631626331333231362638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":61810560,"TaxPrice":7356020,"CommisionPrice":"0","TotalPrice":69166580}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"499","DepartureDate":"2024-05-04T22:45:00","PersianDepartureDate":"","DepartureTime":"22:45:00","ArrivalTime":"00:20:00","ArrivalDate":"2024-05-05T00:20:00","FlightTime":"02:05","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""}},{"transit":"0:07:40","CabinType":"","FlightNo":"3","DepartureDate":"2024-05-05T08:00:00","PersianDepartureDate":"","DepartureTime":"08:00:00","ArrivalTime":"13:15:00","ArrivalDate":"2024-05-05T13:15:00","FlightTime":"07:15","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"LHR","ParentRegionName":""}},{"transit":"0:03:50","CabinType":"","FlightNo":"6299","DepartureDate":"2024-05-05T17:05:00","PersianDepartureDate":"","DepartureTime":"17:05:00","ArrivalTime":"19:55:00","ArrivalDate":"2024-05-05T19:55:00","FlightTime":"07:50","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"BA","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"LHR","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:10","TotalOutputStopDuration":"0:11:30","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"37663636343835666536643334643666393966376138616630643832663264372638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":61810560,"TaxPrice":7356020,"CommisionPrice":"0","TotalPrice":69166580}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"499","DepartureDate":"2024-05-04T22:45:00","PersianDepartureDate":"","DepartureTime":"22:45:00","ArrivalTime":"00:20:00","ArrivalDate":"2024-05-05T00:20:00","FlightTime":"02:05","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""}},{"transit":"0:00:50","CabinType":"","FlightNo":"11","DepartureDate":"2024-05-05T01:10:00","PersianDepartureDate":"","DepartureTime":"01:10:00","ArrivalTime":"06:25:00","ArrivalDate":"2024-05-05T06:25:00","FlightTime":"07:15","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"LHR","ParentRegionName":""}},{"transit":"0:10:40","CabinType":"","FlightNo":"6299","DepartureDate":"2024-05-05T17:05:00","PersianDepartureDate":"","DepartureTime":"17:05:00","ArrivalTime":"19:55:00","ArrivalDate":"2024-05-05T19:55:00","FlightTime":"07:50","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"BA","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"LHR","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:10","TotalOutputStopDuration":"0:11:30","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"39613562303666303363316434323266613464373039663434303434393231332638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":61810560,"TaxPrice":7356020,"CommisionPrice":"0","TotalPrice":69166580}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"499","DepartureDate":"2024-05-04T22:45:00","PersianDepartureDate":"","DepartureTime":"22:45:00","ArrivalTime":"00:20:00","ArrivalDate":"2024-05-05T00:20:00","FlightTime":"02:05","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""}},{"transit":"0:08:35","CabinType":"","FlightNo":"7","DepartureDate":"2024-05-05T08:55:00","PersianDepartureDate":"","DepartureTime":"08:55:00","ArrivalTime":"14:10:00","ArrivalDate":"2024-05-05T14:10:00","FlightTime":"07:15","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"LHR","ParentRegionName":""}},{"transit":"0:02:55","CabinType":"","FlightNo":"6299","DepartureDate":"2024-05-05T17:05:00","PersianDepartureDate":"","DepartureTime":"17:05:00","ArrivalTime":"19:55:00","ArrivalDate":"2024-05-05T19:55:00","FlightTime":"07:50","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"BA","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"LHR","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:10","TotalOutputStopDuration":"0:11:30","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"39333866643964663338656434643134383736316334316438633837646136342638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":61810560,"TaxPrice":7356020,"CommisionPrice":"0","TotalPrice":69166580}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"499","DepartureDate":"2024-05-04T22:45:00","PersianDepartureDate":"","DepartureTime":"22:45:00","ArrivalTime":"00:20:00","ArrivalDate":"2024-05-05T00:20:00","FlightTime":"02:05","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""}},{"transit":"0:01:55","CabinType":"","FlightNo":"107","DepartureDate":"2024-05-05T02:15:00","PersianDepartureDate":"","DepartureTime":"02:15:00","ArrivalTime":"07:30:00","ArrivalDate":"2024-05-05T07:30:00","FlightTime":"07:15","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"LHR","ParentRegionName":""}},{"transit":"0:05:50","CabinType":"","FlightNo":"5883","DepartureDate":"2024-05-05T13:20:00","PersianDepartureDate":"","DepartureTime":"13:20:00","ArrivalTime":"16:10:00","ArrivalDate":"2024-05-05T16:10:00","FlightTime":"07:50","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"BA","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"LHR","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:10","TotalOutputStopDuration":"0:07:45","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"64313234316635633337396434363662623435333663653934326265303133612638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":61810560,"TaxPrice":7356020,"CommisionPrice":"0","TotalPrice":69166580}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"499","DepartureDate":"2024-05-04T22:45:00","PersianDepartureDate":"","DepartureTime":"22:45:00","ArrivalTime":"00:20:00","ArrivalDate":"2024-05-05T00:20:00","FlightTime":"02:05","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""}},{"transit":"0:00:50","CabinType":"","FlightNo":"11","DepartureDate":"2024-05-05T01:10:00","PersianDepartureDate":"","DepartureTime":"01:10:00","ArrivalTime":"06:25:00","ArrivalDate":"2024-05-05T06:25:00","FlightTime":"07:15","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QR","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DOH","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"LHR","ParentRegionName":""}},{"transit":"0:06:55","CabinType":"","FlightNo":"5883","DepartureDate":"2024-05-05T13:20:00","PersianDepartureDate":"","DepartureTime":"13:20:00","ArrivalTime":"16:10:00","ArrivalDate":"2024-05-05T16:10:00","FlightTime":"07:50","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"BA","Logo":"","operator":"QR"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"LHR","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:10","TotalOutputStopDuration":"0:07:45","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"34396137336633646664313034663634616638316363363666356665653061362638392634383831303334","ReturnFlightID":"","Capacity":7,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":72725100,"TaxPrice":2684360,"CommisionPrice":"0","TotalPrice":75409460}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"972","DepartureDate":"2024-05-04T10:40:00","PersianDepartureDate":"","DepartureTime":"10:40:00","ArrivalTime":"13:20:00","ArrivalDate":"2024-05-04T13:20:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:05:40","CabinType":"","FlightNo":"906","DepartureDate":"2024-05-04T19:00:00","PersianDepartureDate":"","DepartureTime":"19:00:00","ArrivalTime":"21:45:00","ArrivalDate":"2024-05-04T21:45:00","FlightTime":"03:45","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"MS","Logo":"","operator":"MS"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"CAI","ParentRegionName":""}},{"transit":"0:05:05","CabinType":"","FlightNo":"995","DepartureDate":"2024-05-05T02:50:00","PersianDepartureDate":"","DepartureTime":"02:50:00","ArrivalTime":"07:25:00","ArrivalDate":"2024-05-05T07:25:00","FlightTime":"11:35","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"MS","Logo":"","operator":"MS"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"CAI","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:30","TotalOutputStopDuration":"0:10:45","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"31653630326366653237373734653261623561343031343462393635393138352638392634383831303334","ReturnFlightID":"","Capacity":7,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":72725100,"TaxPrice":2700320,"CommisionPrice":"0","TotalPrice":75425420}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"972","DepartureDate":"2024-05-04T10:40:00","PersianDepartureDate":"","DepartureTime":"10:40:00","ArrivalTime":"13:20:00","ArrivalDate":"2024-05-04T13:20:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:03:00","CabinType":"","FlightNo":"913","DepartureDate":"2024-05-04T16:20:00","PersianDepartureDate":"","DepartureTime":"16:20:00","ArrivalTime":"19:05:00","ArrivalDate":"2024-05-04T19:05:00","FlightTime":"03:45","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"MS","Logo":"","operator":"MS"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"CAI","ParentRegionName":""}},{"transit":"0:07:45","CabinType":"","FlightNo":"995","DepartureDate":"2024-05-05T02:50:00","PersianDepartureDate":"","DepartureTime":"02:50:00","ArrivalTime":"07:25:00","ArrivalDate":"2024-05-05T07:25:00","FlightTime":"11:35","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"MS","Logo":"","operator":"MS"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"CAI","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:30","TotalOutputStopDuration":"0:10:45","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3134373063336334633738343461336239653661343962613237383434333331263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":76422100,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":76936150}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"C","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"O","FlightNo":"978","DepartureDate":"2024-05-04T04:30:00","PersianDepartureDate":"","DepartureTime":"04:30:00","ArrivalTime":"07:20:00","ArrivalDate":"2024-05-04T07:20:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77W","Manufacturer":"77W","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:20:10","CabinType":"O","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"388","Manufacturer":"388","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:20","TotalOutputStopDuration":"0:20:10","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3062653965663934356162653463363661373432336464353263333732373463263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":76422100,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":76936150}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"C","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"O","FlightNo":"972","DepartureDate":"2024-05-04T10:40:00","PersianDepartureDate":"","DepartureTime":"10:40:00","ArrivalTime":"13:20:00","ArrivalDate":"2024-05-04T13:20:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77W","Manufacturer":"77W","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:14:10","CabinType":"O","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"388","Manufacturer":"388","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:10","TotalOutputStopDuration":"0:14:10","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3832343737663031633937643462393038326631366561386230336261636165263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":76422100,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":76936150}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"C","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"O","FlightNo":"980","DepartureDate":"2024-05-04T18:20:00","PersianDepartureDate":"","DepartureTime":"18:20:00","ArrivalTime":"21:10:00","ArrivalDate":"2024-05-04T21:10:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:06:20","CabinType":"O","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"388","Manufacturer":"388","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:20","TotalOutputStopDuration":"0:06:20","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3936323630306430366265343464376638383062616564633030613532333462263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":76422100,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":77004690}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"C","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"O","FlightNo":"2374","DepartureDate":"2024-05-04T09:45:00","PersianDepartureDate":"","DepartureTime":"09:45:00","ArrivalTime":"12:25:00","ArrivalDate":"2024-05-04T12:25:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:15:05","CabinType":"O","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"388","Manufacturer":"388","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:10","TotalOutputStopDuration":"0:15:05","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3665666434626533396634643461323038346530633831666562626336633239263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":76422100,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":77004690}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"C","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"O","FlightNo":"2303","DepartureDate":"2024-05-04T15:10:00","PersianDepartureDate":"","DepartureTime":"15:10:00","ArrivalTime":"17:50:00","ArrivalDate":"2024-05-04T17:50:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:9:40","CabinType":"O","FlightNo":"241","DepartureDate":"2024-05-05T03:30:00","PersianDepartureDate":"","DepartureTime":"03:30:00","ArrivalTime":"09:30:00","ArrivalDate":"2024-05-05T09:30:00","FlightTime":"14:00","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"388","Manufacturer":"388","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:10","TotalOutputStopDuration":"0:9:40","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3936373230333533353837383435343739383635623431346636376239373234263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":77381660,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":77895710}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"C","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"O","FlightNo":"978","DepartureDate":"2024-05-04T04:30:00","PersianDepartureDate":"","DepartureTime":"04:30:00","ArrivalTime":"07:20:00","ArrivalDate":"2024-05-04T07:20:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77W","Manufacturer":"77W","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:19:10","CabinType":"O","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"Y","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QK","Logo":"","operator":"EK"},"Aircraft":{"Code":"DH4","Manufacturer":"DH4","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:9","TotalOutputStopDuration":"0:21:40","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"6165336637313739356465303435623261336138306339613566313730386536263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":77381660,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":77895710}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"C","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"O","FlightNo":"978","DepartureDate":"2024-05-04T04:30:00","PersianDepartureDate":"","DepartureTime":"04:30:00","ArrivalTime":"07:20:00","ArrivalDate":"2024-05-04T07:20:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77W","Manufacturer":"77W","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:19:10","CabinType":"O","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:03:00","CabinType":"O","FlightNo":"5809","DepartureDate":"2024-05-05T11:00:00","PersianDepartureDate":"","DepartureTime":"11:00:00","ArrivalTime":"12:23:00","ArrivalDate":"2024-05-05T12:23:00","FlightTime":"01:23","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":"223","Manufacturer":"223","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:13","TotalOutputStopDuration":"0:22:10","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3563326432383165643635333430633661333639343535336133336238306339263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":77381660,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":77895710}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"C","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"O","FlightNo":"972","DepartureDate":"2024-05-04T10:40:00","PersianDepartureDate":"","DepartureTime":"10:40:00","ArrivalTime":"13:20:00","ArrivalDate":"2024-05-04T13:20:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77W","Manufacturer":"77W","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:13:10","CabinType":"O","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"Y","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QK","Logo":"","operator":"EK"},"Aircraft":{"Code":"DH4","Manufacturer":"DH4","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:59","TotalOutputStopDuration":"0:15:40","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3930366237333834396531363435353439336361616635636166646131366237263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":77381660,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":77895710}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"C","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"O","FlightNo":"972","DepartureDate":"2024-05-04T10:40:00","PersianDepartureDate":"","DepartureTime":"10:40:00","ArrivalTime":"13:20:00","ArrivalDate":"2024-05-04T13:20:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77W","Manufacturer":"77W","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:13:10","CabinType":"O","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:03:00","CabinType":"O","FlightNo":"5809","DepartureDate":"2024-05-05T11:00:00","PersianDepartureDate":"","DepartureTime":"11:00:00","ArrivalTime":"12:23:00","ArrivalDate":"2024-05-05T12:23:00","FlightTime":"01:23","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":"223","Manufacturer":"223","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:03","TotalOutputStopDuration":"0:16:10","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3662326334353233333530383434383561643565613966316435313235363739263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":77381660,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":77895710}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"C","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"O","FlightNo":"980","DepartureDate":"2024-05-04T18:20:00","PersianDepartureDate":"","DepartureTime":"18:20:00","ArrivalTime":"21:10:00","ArrivalDate":"2024-05-04T21:10:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:05:20","CabinType":"O","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"Y","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QK","Logo":"","operator":"EK"},"Aircraft":{"Code":"DH4","Manufacturer":"DH4","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:9","TotalOutputStopDuration":"0:07:50","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"6539336131613664323436323439636239386337353237346339336533626464263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":77381660,"TaxPrice":514050,"CommisionPrice":"0","TotalPrice":77895710}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"C","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"O","FlightNo":"980","DepartureDate":"2024-05-04T18:20:00","PersianDepartureDate":"","DepartureTime":"18:20:00","ArrivalTime":"21:10:00","ArrivalDate":"2024-05-04T21:10:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:05:20","CabinType":"O","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:03:00","CabinType":"O","FlightNo":"5809","DepartureDate":"2024-05-05T11:00:00","PersianDepartureDate":"","DepartureTime":"11:00:00","ArrivalTime":"12:23:00","ArrivalDate":"2024-05-05T12:23:00","FlightTime":"01:23","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":"223","Manufacturer":"223","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:13","TotalOutputStopDuration":"0:08:20","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3963396132643438656137313464396361663432393532653838373932643233263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":77381660,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":77964250}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"C","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"O","FlightNo":"2491","DepartureDate":"2024-05-04T00:45:00","PersianDepartureDate":"","DepartureTime":"00:45:00","ArrivalTime":"03:25:00","ArrivalDate":"2024-05-04T03:25:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:23:05","CabinType":"O","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:03:00","CabinType":"O","FlightNo":"5809","DepartureDate":"2024-05-05T11:00:00","PersianDepartureDate":"","DepartureTime":"11:00:00","ArrivalTime":"12:23:00","ArrivalDate":"2024-05-05T12:23:00","FlightTime":"01:23","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":"223","Manufacturer":"223","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:03","TotalOutputStopDuration":"1:02:05","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"6665323361616231623135323465633161633661376337613535663530663034263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":77381660,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":77964250}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"C","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"O","FlightNo":"2491","DepartureDate":"2024-05-04T00:45:00","PersianDepartureDate":"","DepartureTime":"00:45:00","ArrivalTime":"03:25:00","ArrivalDate":"2024-05-04T03:25:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:23:05","CabinType":"O","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"Y","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QK","Logo":"","operator":"EK"},"Aircraft":{"Code":"DH4","Manufacturer":"DH4","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:59","TotalOutputStopDuration":"1:01:35","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"6438376534393633393261653463386538646563353462393634646534343661263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":77381660,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":77964250}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"C","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"O","FlightNo":"2374","DepartureDate":"2024-05-04T09:45:00","PersianDepartureDate":"","DepartureTime":"09:45:00","ArrivalTime":"12:25:00","ArrivalDate":"2024-05-04T12:25:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:14:05","CabinType":"O","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"Y","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QK","Logo":"","operator":"EK"},"Aircraft":{"Code":"DH4","Manufacturer":"DH4","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:59","TotalOutputStopDuration":"0:16:35","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3963336436393136333764343464363639656436373566333739373539323738263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":77381660,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":77964250}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"C","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"O","FlightNo":"2374","DepartureDate":"2024-05-04T09:45:00","PersianDepartureDate":"","DepartureTime":"09:45:00","ArrivalTime":"12:25:00","ArrivalDate":"2024-05-04T12:25:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:14:05","CabinType":"O","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:03:00","CabinType":"O","FlightNo":"5809","DepartureDate":"2024-05-05T11:00:00","PersianDepartureDate":"","DepartureTime":"11:00:00","ArrivalTime":"12:23:00","ArrivalDate":"2024-05-05T12:23:00","FlightTime":"01:23","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":"223","Manufacturer":"223","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:03","TotalOutputStopDuration":"0:17:05","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"3032663865616434396466383462373538623763336334393366393062313264263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":77381660,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":77964250}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"C","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"O","FlightNo":"2303","DepartureDate":"2024-05-04T15:10:00","PersianDepartureDate":"","DepartureTime":"15:10:00","ArrivalTime":"17:50:00","ArrivalDate":"2024-05-04T17:50:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:08:40","CabinType":"O","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:30","CabinType":"Y","FlightNo":"5803","DepartureDate":"2024-05-05T10:30:00","PersianDepartureDate":"","DepartureTime":"10:30:00","ArrivalTime":"11:49:00","ArrivalDate":"2024-05-05T11:49:00","FlightTime":"01:19","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"QK","Logo":"","operator":"EK"},"Aircraft":{"Code":"DH4","Manufacturer":"DH4","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:16:59","TotalOutputStopDuration":"0:11:10","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":1,"FlightID":"6131663536323835326665653434333661386363623533633062383831633431263130312634383831303334","ReturnFlightID":"","Capacity":0,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":77381660,"TaxPrice":582590,"CommisionPrice":"0","TotalPrice":77964250}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"C","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"O","FlightNo":"2303","DepartureDate":"2024-05-04T15:10:00","PersianDepartureDate":"","DepartureTime":"15:10:00","ArrivalTime":"17:50:00","ArrivalDate":"2024-05-04T17:50:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":"7M8","Manufacturer":"7M8","Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:08:40","CabinType":"O","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":"77L","Manufacturer":"77L","Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:03:00","CabinType":"O","FlightNo":"5809","DepartureDate":"2024-05-05T11:00:00","PersianDepartureDate":"","DepartureTime":"11:00:00","ArrivalTime":"12:23:00","ArrivalDate":"2024-05-05T12:23:00","FlightTime":"01:23","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"AC","Logo":"","operator":"EK"},"Aircraft":{"Code":"223","Manufacturer":"223","Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:03","TotalOutputStopDuration":"0:11:40","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"33653738326462303362356134366333393436643136313434653035396466382638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":79189320,"TaxPrice":2731120,"CommisionPrice":"0","TotalPrice":81920440}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"980","DepartureDate":"2024-05-04T18:20:00","PersianDepartureDate":"","DepartureTime":"18:20:00","ArrivalTime":"21:10:00","ArrivalDate":"2024-05-04T21:10:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:05:20","CabinType":"","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:55","CabinType":"","FlightNo":"114","DepartureDate":"2024-05-05T10:55:00","PersianDepartureDate":"","DepartureTime":"10:55:00","ArrivalTime":"12:19:00","ArrivalDate":"2024-05-05T12:19:00","FlightTime":"01:24","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"PD","Logo":"","operator":"PD"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YYZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:14","TotalOutputStopDuration":"0:08:15","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"37336163626464373863656134383438616332343466383234653136366232392638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":79189320,"TaxPrice":2731120,"CommisionPrice":"0","TotalPrice":81920440}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"980","DepartureDate":"2024-05-04T18:20:00","PersianDepartureDate":"","DepartureTime":"18:20:00","ArrivalTime":"21:10:00","ArrivalDate":"2024-05-04T21:10:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:05:20","CabinType":"","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:40","CabinType":"","FlightNo":"2460","DepartureDate":"2024-05-05T10:40:00","PersianDepartureDate":"","DepartureTime":"10:40:00","ArrivalTime":"12:06:00","ArrivalDate":"2024-05-05T12:06:00","FlightTime":"01:26","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"PD","Logo":"","operator":"PD"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:16","TotalOutputStopDuration":"0:08:00","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"61663636396261393966666134373730616136633665393633386165326466332638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":83145720,"TaxPrice":3372740,"CommisionPrice":"0","TotalPrice":86518460}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"978","DepartureDate":"2024-05-04T04:30:00","PersianDepartureDate":"","DepartureTime":"04:30:00","ArrivalTime":"07:20:00","ArrivalDate":"2024-05-04T07:20:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:03:30","CabinType":"","FlightNo":"209","DepartureDate":"2024-05-04T10:50:00","PersianDepartureDate":"","DepartureTime":"10:50:00","ArrivalTime":"15:00:00","ArrivalDate":"2024-05-04T15:00:00","FlightTime":"05:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"ATH","ParentRegionName":""}},{"transit":"0:02:35","CabinType":"","FlightNo":"209","DepartureDate":"2024-05-04T17:35:00","PersianDepartureDate":"","DepartureTime":"17:35:00","ArrivalTime":"21:20:00","ArrivalDate":"2024-05-04T21:20:00","FlightTime":"10:45","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"ATH","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"EWR","ParentRegionName":""}},{"transit":"0:11:35","CabinType":"","FlightNo":"2122","DepartureDate":"2024-05-05T08:55:00","PersianDepartureDate":"","DepartureTime":"08:55:00","ArrivalTime":"10:40:00","ArrivalDate":"2024-05-05T10:40:00","FlightTime":"01:45","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"PD","Logo":"","operator":"PD"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"EWR","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:20:00","TotalOutputStopDuration":"0:17:40","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"33316566306638323438326534633131626166373161616366383763323934372638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":83145720,"TaxPrice":3440920,"CommisionPrice":"0","TotalPrice":86586640}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"978","DepartureDate":"2024-05-04T04:30:00","PersianDepartureDate":"","DepartureTime":"04:30:00","ArrivalTime":"07:20:00","ArrivalDate":"2024-05-04T07:20:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:01:00","CabinType":"","FlightNo":"237","DepartureDate":"2024-05-04T08:20:00","PersianDepartureDate":"","DepartureTime":"08:20:00","ArrivalTime":"14:10:00","ArrivalDate":"2024-05-04T14:10:00","FlightTime":"13:50","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"BOS","ParentRegionName":""}},{"transit":"0:01:45","CabinType":"","FlightNo":"2944","DepartureDate":"2024-05-04T15:55:00","PersianDepartureDate":"","DepartureTime":"15:55:00","ArrivalTime":"17:48:00","ArrivalDate":"2024-05-04T17:48:00","FlightTime":"01:53","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"PD","Logo":"","operator":"PD"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"BOS","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:18:03","TotalOutputStopDuration":"0:02:45","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"63366331626635666331383334643663616439663138373439326235323061622638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":91425460,"TaxPrice":3156160,"CommisionPrice":"0","TotalPrice":94581620}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"2303","DepartureDate":"2024-05-04T15:20:00","PersianDepartureDate":"","DepartureTime":"15:20:00","ArrivalTime":"17:55:00","ArrivalDate":"2024-05-04T17:55:00","FlightTime":"02:05","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:08:35","CabinType":"","FlightNo":"243","DepartureDate":"2024-05-05T02:30:00","PersianDepartureDate":"","DepartureTime":"02:30:00","ArrivalTime":"08:00:00","ArrivalDate":"2024-05-05T08:00:00","FlightTime":"13:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""}},{"transit":"0:02:40","CabinType":"","FlightNo":"2460","DepartureDate":"2024-05-05T10:40:00","PersianDepartureDate":"","DepartureTime":"10:40:00","ArrivalTime":"12:06:00","ArrivalDate":"2024-05-05T12:06:00","FlightTime":"01:26","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"PD","Logo":"","operator":"PD"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"YUL","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:01","TotalOutputStopDuration":"0:11:15","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"32346364393164623338333134363934393961303230326139386533313061312638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":95381860,"TaxPrice":3797920,"CommisionPrice":"0","TotalPrice":99179780}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"2491","DepartureDate":"2024-05-04T00:45:00","PersianDepartureDate":"","DepartureTime":"00:45:00","ArrivalTime":"03:25:00","ArrivalDate":"2024-05-04T03:25:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:07:25","CabinType":"","FlightNo":"209","DepartureDate":"2024-05-04T10:50:00","PersianDepartureDate":"","DepartureTime":"10:50:00","ArrivalTime":"15:00:00","ArrivalDate":"2024-05-04T15:00:00","FlightTime":"05:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"ATH","ParentRegionName":""}},{"transit":"0:02:35","CabinType":"","FlightNo":"209","DepartureDate":"2024-05-04T17:35:00","PersianDepartureDate":"","DepartureTime":"17:35:00","ArrivalTime":"21:20:00","ArrivalDate":"2024-05-04T21:20:00","FlightTime":"10:45","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"ATH","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"EWR","ParentRegionName":""}},{"transit":"0:11:35","CabinType":"","FlightNo":"2122","DepartureDate":"2024-05-05T08:55:00","PersianDepartureDate":"","DepartureTime":"08:55:00","ArrivalTime":"10:40:00","ArrivalDate":"2024-05-05T10:40:00","FlightTime":"01:45","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"PD","Logo":"","operator":"PD"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"EWR","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:19:50","TotalOutputStopDuration":"0:21:35","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"34316164383137633734323034323634616130303062303963383566373565332638392634383831303334","ReturnFlightID":"","Capacity":9,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":95381860,"TaxPrice":3865960,"CommisionPrice":"0","TotalPrice":99247820}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"2491","DepartureDate":"2024-05-04T00:45:00","PersianDepartureDate":"","DepartureTime":"00:45:00","ArrivalTime":"03:25:00","ArrivalDate":"2024-05-04T03:25:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:04:55","CabinType":"","FlightNo":"237","DepartureDate":"2024-05-04T08:20:00","PersianDepartureDate":"","DepartureTime":"08:20:00","ArrivalTime":"14:10:00","ArrivalDate":"2024-05-04T14:10:00","FlightTime":"13:50","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"BOS","ParentRegionName":""}},{"transit":"0:01:45","CabinType":"","FlightNo":"2944","DepartureDate":"2024-05-04T15:55:00","PersianDepartureDate":"","DepartureTime":"15:55:00","ArrivalTime":"17:48:00","ArrivalDate":"2024-05-04T17:48:00","FlightTime":"01:53","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"PD","Logo":"","operator":"PD"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"BOS","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:53","TotalOutputStopDuration":"0:06:40","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"31346436616539666464336634396438626564353532353061643939643637612638392634383831303334","ReturnFlightID":"","Capacity":7,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":214114040,"TaxPrice":7390600,"CommisionPrice":"0","TotalPrice":221504640}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"972","DepartureDate":"2024-05-04T10:40:00","PersianDepartureDate":"","DepartureTime":"10:40:00","ArrivalTime":"13:20:00","ArrivalDate":"2024-05-04T13:20:00","FlightTime":"02:10","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:13:00","CabinType":"","FlightNo":"231","DepartureDate":"2024-05-05T02:20:00","PersianDepartureDate":"","DepartureTime":"02:20:00","ArrivalTime":"08:40:00","ArrivalDate":"2024-05-05T08:40:00","FlightTime":"14:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"IAD","ParentRegionName":""}},{"transit":"0:04:50","CabinType":"","FlightNo":"2722","DepartureDate":"2024-05-05T13:30:00","PersianDepartureDate":"","DepartureTime":"13:30:00","ArrivalTime":"15:00:00","ArrivalDate":"2024-05-05T15:00:00","FlightTime":"01:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"PD","Logo":"","operator":"PD"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IAD","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:18:00","TotalOutputStopDuration":"0:17:50","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"37656238326132643761313834353135623537303632323930313165633266662638392634383831303334","ReturnFlightID":"","Capacity":7,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":214114040,"TaxPrice":7390600,"CommisionPrice":"0","TotalPrice":221504640}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"980","DepartureDate":"2024-05-04T18:20:00","PersianDepartureDate":"","DepartureTime":"18:20:00","ArrivalTime":"21:10:00","ArrivalDate":"2024-05-04T21:10:00","FlightTime":"02:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:05:10","CabinType":"","FlightNo":"231","DepartureDate":"2024-05-05T02:20:00","PersianDepartureDate":"","DepartureTime":"02:20:00","ArrivalTime":"08:40:00","ArrivalDate":"2024-05-05T08:40:00","FlightTime":"14:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"IAD","ParentRegionName":""}},{"transit":"0:04:50","CabinType":"","FlightNo":"2722","DepartureDate":"2024-05-05T13:30:00","PersianDepartureDate":"","DepartureTime":"13:30:00","ArrivalTime":"15:00:00","ArrivalDate":"2024-05-05T15:00:00","FlightTime":"01:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"PD","Logo":"","operator":"PD"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IAD","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:18:10","TotalOutputStopDuration":"0:10:00","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"},{"Messages":[],"IsInternal":false,"id":2,"FlightID":"35643966376264643465376334623334383462653830316230663739616532652638392634383831303334","ReturnFlightID":"","Capacity":7,"PassengerDatas":[{"PassengerType":"ADT","BasePrice":214114040,"TaxPrice":7436240,"CommisionPrice":"0","TotalPrice":221550280}],"BasePrice":"","TaxPrice":"","CommisionPrice":"","TotalPrice":"","Description":"","FlightType":"System","SeatClass":"Y","Reservable":true,"DisplayMode":"","Manufacturer":"","OutputRoutes":[{"transit":"00:00","CabinType":"","FlightNo":"2303","DepartureDate":"2024-05-04T15:20:00","PersianDepartureDate":"","DepartureTime":"15:20:00","ArrivalTime":"17:55:00","ArrivalDate":"2024-05-04T17:55:00","FlightTime":"02:05","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"FZ","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IKA","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""}},{"transit":"0:08:25","CabinType":"","FlightNo":"231","DepartureDate":"2024-05-05T02:20:00","PersianDepartureDate":"","DepartureTime":"02:20:00","ArrivalTime":"08:40:00","ArrivalDate":"2024-05-05T08:40:00","FlightTime":"14:20","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"EK","Logo":"","operator":"EK"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"DXB","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"IAD","ParentRegionName":""}},{"transit":"0:04:50","CabinType":"","FlightNo":"2722","DepartureDate":"2024-05-05T13:30:00","PersianDepartureDate":"","DepartureTime":"13:30:00","ArrivalTime":"15:00:00","ArrivalDate":"2024-05-05T15:00:00","FlightTime":"01:30","Baggage":{"Code":"PC","Charge":"2","allowanceAmount":1},"Airline":{"Name":"","Code":"PD","Logo":"","operator":"PD"},"Aircraft":{"Code":null,"Manufacturer":null,"Name":""},"Departure":{"City":"","RegionName":"","Code":"IAD","ParentRegionName":""},"Arrival":{"City":"","RegionName":"","Code":"YTZ","ParentRegionName":""}}],"Supplier":{"SupplierID":"","Name":"","Logo":"","Website":""},"TotalOutputFlightDuration":"0:17:55","TotalOutputStopDuration":"0:13:15","TotalReturnFlightDuration":"","TotalReturnStopDuration":"","ProviderStatus":"Success","ImportantLink":"","SourceId":14,"AgencyId":24,"SourceName":"Source14","UserName":"Api","Code":"TE14030121162407652164258095"}],"ProviderStatus":"Success","InportantLink":"","SourceId":"","AgencyId":"","SourceName":"","UserName":"","Code":"TE14030121162407652164258095"}',true);
    }


    public function flightInternalV1() {
        /*
         ersale request be api va daryafte natije
         */


        $start_function = date('H:i:s',time());

//        error_log('start  flightInternal  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');

        /** @var airportModel $airportModel */
        $airportModel = $this->getModel('airportModel');
        $originCheck = $airportModel->get()->where('DepartureCode', $this->origin)->where('IsInternal', 1)->find();


        $destinationCheck = $airportModel->get()->where('DepartureCode', $this->destination)->where('IsInternal', 1)->find();

        $after_check = date('H:i:s',time());
        if (!$originCheck || !$destinationCheck) {
            return functions::withError([], 400, 'you search with wrong city codes');
        }

        if ($originCheck['DepartureCode'] == 'IKA' || $destinationCheck['DepartureCode'] == 'IKA') {
            return functions::withError([], 400, 'you search with wrong city codes');
        }

        $info_currency = functions::infoCurrencyBySessionCode(Session::getCurrency());

        $after_info_currency = date('H:i:s',time());
//        error_log('first  getTicketInternal  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');
        $flights = json_decode($this->findTicketInSearch(), true);

        $count_search = intval($this->adult) + intval($this->child) + intval($this->infant) ;
        $after_receive = date('H:i:s',time());

//        error_log('after   findTicketInSearch  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');
//        error_log('*******************************'. " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');
        if ((empty($this->arrivalDate) && !empty($flights['dept']['Flights']))
            || (!empty($this->arrivalDate) && !empty($flights['dept']['Flights'])
                && !empty($flights['return']['Flights']))) {

            $airlines = array();
            $before_list_config_airline_time = date('H:i:s',time());
            $list_config_airline = $this->listConfigAirline(true);
            $list_config_airline_time = date('H:i:s',time());
            $price_change_list = $this->flightPriceChangeList('local');
            $price_change_list_time = date('H:i:s',time());
            $discount_list = $this->discountList();
            $discount_list_time = date('H:i:s',time());
            $airlines_name = $this->airlineList();
            $airlines_name_time = date('H:i:s',time());
            $translateVariable = $this->dataTranslate();
            $translateVariable_time = date('H:i:s',time());
            $type_zone = 'Local';
            $prices = array();

            $after_arrays = date('H:i:s',time());

            $data_param_set_change_price['list_config_airline'] = $list_config_airline;
            $data_param_set_change_price['price_change_list'] = $price_change_list;
            $data_param_set_change_price['discount_list'] = $discount_list;
            $data_param_set_change_price['info_currency'] = $info_currency;
            $data_param_set_change_price['data_translate'] = $translateVariable;

            $info_route = $this->getLongTimeFlightInternal($this->origin, $this->destination, $translateVariable);
            $this->tickets = $this->filterInternationalFlight($translateVariable);

            $this->tickets['min_price_airline'] = array();
            $this->tickets['flights'] = array();
            $this->tickets['price'] = array();
            $this->tickets['time'] = array();
            $this->tickets['time']['start_function'] = $start_function ;
            $this->tickets['time']['after_check'] = $after_check ;
            $this->tickets['time']['after_info_currency'] = $after_info_currency ;
            $this->tickets['time']['after_receive'] = $after_receive ;
            $this->tickets['time']['after_arrays'] = $after_arrays ;
            $this->tickets['time']['before_list_config_airline_time'] = $before_list_config_airline_time ;
            $this->tickets['time']['list_config_airline_time'] = $list_config_airline_time ;
            $this->tickets['time']['price_change_list_time'] = $price_change_list_time ;
            $this->tickets['time']['discount_list_time'] = $discount_list_time ;
            $this->tickets['time']['airlines_name_time'] = $airlines_name_time ;
            $this->tickets['time']['translateVariable_time'] = $translateVariable_time ;
            $this->tickets['time']['first'] = date('H:i:s',time());

            foreach ($flights as $direction => $arrayFlight) {

                $start = microtime(true);
                $this->count = count($flights);
                $flights_direction = $arrayFlight['Flights'];
                $arrayAirlines[$direction] = array();
                $airlines = array();
                foreach ($flights_direction as $key => $flight) {
                    $airline_iata = strtoupper($flight['OutputRoutes'][0]['Airline']['Code']);
                    $this->tickets['time'][$key] = [
                        'iata'=>$airline_iata,
                        'time' => (((microtime(true)-$start)*1000)/1000)
                    ];

                    $ArrivalTime = ($flight['OutputRoutes'][0]['ArrivalTime'] !="") ? substr($flight['OutputRoutes'][0]['ArrivalTime'],0,5) : functions::CalculateArrivalTime(($info_route['Hour'] . ':' . $info_route['Minutes'] . ':00'), $flight['OutputRoutes'][0]['DepartureTime'])['time'];

                    $this->tickets['time'][$key]['arrival_time']= (((microtime(true)-$start)*1000)/1000);
                    $type_flight = (($flight['SeatClass'] == 'C' || $flight['SeatClass'] == 'J' || $flight['SeatClass'] == 'D' || $flight['SeatClass'] == 'I' || $flight['SeatClass'] == 'Z') ? 'business' : 'economy');
                    $source_id = $flight['SourceId'];
                    $date_persian = functions::convertDateFlight($flight['OutputRoutes'][0]['DepartureDate']);
                    $this->tickets['time'][$key]['date_persian']= (((microtime(true)-$start)*1000)/1000);
                    $origin_name = ($direction == 'dept') ? $this->originName : $this->destinationName;
                    $destination_name = ($direction == 'dept') ? $this->destinationName : $this->originName;
                    $data_change_price = array(
                        'airlineIata' => $flight['OutputRoutes'][0]['Airline']['Code'],
                        'FlightType' => strtolower($flight['FlightType']),
                        'typeZone' => $type_zone,
                        'typeFlight' => $type_flight,
                        'sourceId' => $source_id,
                        'isInternal' => true,
                        'price' => array(
                            'adult' => array(
                                'TotalPrice' => $flight['PassengerDatas'][0]['TotalPrice'],
                                'BasePrice' => $flight['PassengerDatas'][0]['BasePrice'],
                            ),
                            'child' => array(
                                'TotalPrice' => isset($flight['PassengerDatas'][1]['TotalPrice']) ? $flight['PassengerDatas'][1]['TotalPrice'] : 0,
                                'BasePrice' => isset($flight['PassengerDatas'][1]['BasePrice']) ? $flight['PassengerDatas'][1]['BasePrice'] : 0,
                            ),
                            'infant' => array(
                                'TotalPrice' => isset($flight['PassengerDatas'][2]['TotalPrice']) ? $flight['PassengerDatas'][2]['TotalPrice'] : 0,
                                'BasePrice' => isset($flight['PassengerDatas'][2]['BasePrice']) ? $flight['PassengerDatas'][2]['BasePrice'] : 0,
                            ),
                        )
                    );

                    $price_change_calculate = $this->getController('priceChanges')->setPriceChangesFlight($data_change_price, $data_param_set_change_price);
                    $this->tickets['time'][$key]['price_change_calculate'] = (((microtime(true)-$start)*1000)/1000);
                    if ($price_change_calculate['adult']['TotalPrice'] > 0) {
                        $this->tickets['prices'][$direction][] = $price_change_calculate['adult']['TotalPrice'];
                    }

                    $point_club = $this->pointClub($flight, $price_change_calculate);
                    $this->tickets['time'][$key]['point_club ']= (((microtime(true)-$start)*1000)/1000);


                    if (!in_array($airline_iata, $airlines)) {

                        $airlines[] = $airline_iata;
                        foreach ($airlines as $airline) {

                            if ($airline == $airline_iata && round($price_change_calculate['adult']['TotalPrice']) > 0) {
                                $price_airline[$direction][$airline_iata][] = $price_change_calculate['adult']['TotalPrice'];
                                $price_currency_min = min($price_airline[$direction][$airline_iata]);
                                $this->tickets['min_price_airline'][$direction][$airline_iata] = array(
                                    'name_en' => $airline_iata,
                                    'price' => functions::numberFormat($price_currency_min),
                                    'name' => $airlines_name[$airline_iata][functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa')],
                                );
                            }
                        }
                    }
                    $dept_arrival_date = ($flight['OutputRoutes'][0]['ArrivalDate'] !="") ?  $flight['OutputRoutes'][0]['ArrivalDate'] : functions::Date_arrival($flight['OutputRoutes'][0]['Departure']['Code'], $flight['OutputRoutes'][0]['Arrival']['Code'], $flight['OutputRoutes'][0]['DepartureTime'], $flight['OutputRoutes'][0]['DepartureDate']);
                    $this->tickets['time'][$key]['dept_arrival_date']= (((microtime(true)-$start)*1000)/1000);

                    $this->tickets['flights'][$direction][$key] = [
                        'price' => [
                            'adult' => [
                                'price' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $price_change_calculate['adult']['TotalPrice'] : round($price_change_calculate['adult']['TotalPrice']),
                                'fare' => round($price_change_calculate['adult']['BasePrice']),
                                'with_discount' => round($price_change_calculate['adult']['TotalPriceWithDiscount']),
                                'has_discount' => $price_change_calculate['adult']['has_discount'],
                                'type_currency' => $price_change_calculate['adult']['type_currency'],
                                'price_with_out_currency' => round($price_change_calculate['adult']['price_with_out_currency']),
                                'price_discount_with_out_currency' => round($price_change_calculate['adult']['price_discount_with_out_currency']),
                                'originalPrice' =>  $flight['PassengerDatas'][0]['TotalPrice'],
                            ],
                            'child' => [
                                'price' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $price_change_calculate['child']['TotalPrice'] : round($price_change_calculate['child']['TotalPrice']),
                                'fare' => round($price_change_calculate['child']['BasePrice']),
                                'with_discount' => round($price_change_calculate['child']['TotalPriceWithDiscount']),
                                'has_discount' => $price_change_calculate['child']['has_discount'],
                                'type_currency' => $price_change_calculate['child']['type_currency'],
                                'price_with_out_currency' => round($price_change_calculate['child']['price_with_out_currency']),
                                'price_discount_with_out_currency' => round($price_change_calculate['child']['price_discount_with_out_currency']),
                            ],
                            'infant' => [
                                'price' => (ISCURRENCY && SOFTWARE_LANG != 'fa') ? $price_change_calculate['infant']['TotalPrice'] : round($price_change_calculate['infant']['TotalPrice']),
                                'fare' => round($price_change_calculate['infant']['BasePrice']),
                                'with_discount' => round($price_change_calculate['infant']['TotalPriceWithDiscount']),
                                'has_discount' => $price_change_calculate['infant']['has_discount'],
                                'type_currency' => $price_change_calculate['infant']['type_currency'],
                                'price_with_out_currency' => round($price_change_calculate['infant']['price_with_out_currency']),
                                'price_discount_with_out_currency' => round($price_change_calculate['infant']['price_discount_with_out_currency']),
                            ],
                        ],
                        'is_low_capacity'=> ($flight['Capacity'] > 0) ? !(($flight['Capacity'] < $count_search)) : true,
                        'check_sort_reservation'=>'2',
                        'currency_code' => Session::getCurrency(),
                        'departure_name' => $origin_name,
                        'arrival_name' => $destination_name,
                        'time_flight_name' => ($flight['OutputRoutes'][0]['FlightTime'] !="")  ? functions::classTimeLOCAL($flight['OutputRoutes'][0]['FlightTime'],false)  : functions::classTimeLOCAL(functions::format_hour($flight['OutputRoutes'][0]['DepartureTime']), false),
                        'flight_number' => $flight['OutputRoutes'][0]['FlightNo'],
                        'airline' => $airline_iata,
                        'airline_name' => $airlines_name[$airline_iata][functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa')],
                        'departure_date' => functions::ConvertDateByLanguage(SOFTWARE_LANG, $flight['OutputRoutes'][0]['DepartureDate'], '/', (SOFTWARE_LANG != 'fa' ? 'Miladi' : 'Jalali'), (SOFTWARE_LANG != 'fa' ? 'false' : 'true')),//functions::convertDateFlight($flight['OutputRoutes'][0]['DepartureDate']),
                        'departure_time' => substr($flight['OutputRoutes'][0]['DepartureTime'], 0, 5),
                        'duration_time' =>  ($flight['OutputRoutes'][0]['FlightTime'] !="") ?  $flight['OutputRoutes'][0]['FlightTime'] :
                            $info_route['Hour'] . $translateVariable['Hour'].' '.$translateVariable['And']  .' '. $info_route['Minutes'] .' '. $translateVariable['Minutes'] ,
                        'arrival_date' =>   $dept_arrival_date,
                        'arrival_time' => $ArrivalTime,
                        'departure_code' => $flight['OutputRoutes'][0]['Departure']['Code'],
                        'arrival_code' => $flight['OutputRoutes'][0]['Arrival']['Code'],
                        'aircraft' => $flight['OutputRoutes'][0]['Aircraft']['Manufacturer'],
                        'flight_type' => (strtolower($flight['FlightType']) == "system") ? $translateVariable['system_flight'] : $translateVariable['charter_flight'],
                        'flight_type_li' => (strtolower($flight['FlightType']) == "system") ? 'system' : 'charter',
                        'persian_departure_date' => $date_persian,
                        'description' => $flight['Description'],
                        'seat_class' => (($flight['SeatClass'] == 'C' || $flight['SeatClass'] == 'J' || $flight['SeatClass'] == 'D' || $flight['SeatClass'] == 'I' || $flight['SeatClass'] == 'Z') ? $translateVariable['business_type'] : $translateVariable['economics_type']),
                        'seat_class_en' => (($flight['SeatClass'] == 'C' || $flight['SeatClass'] == 'J' || $flight['SeatClass'] == 'D' || $flight['SeatClass'] == 'I' || $flight['SeatClass'] == 'Z') ? 'business' : 'economy'),
                        'cabin_type' => $flight['OutputRoutes'][0]['CabinType'],
                        'capacity' => ($flight['Capacity'] > 10) ? 9 : $flight['Capacity'],
                        'source_id' => !empty($flight['SourceId']) ? $flight['SourceId'] : '',
                        'source_name' => !empty($flight['SourceName']) ? $flight['SourceName'] : '',
                        'unique_code' => $flight['Code'],
                        'point_club' => (($point_club > 0) ? $point_club : 0),
                        'flight_id' => $flight['FlightID'],
                        'baggage' => ($flight['OutputRoutes'][0]['Baggage']['Code'] > 0) ? $this->baggageTitle($flight['SourceId'],$flight['OutputRoutes'][0],$translateVariable):'20',
                    ];

                    $this->tickets['time'][$key]['end_time']= (((microtime(true)-$start)*1000)/1000);



                }
                $this->tickets['time']['end'] = date('H:i:s',time());


                $this->tickets['before'][$direction] = $this->tickets['flights'][$direction];
                $this->tickets['time']['first_inactive'] = date('H:i:s',time());

                //این خط کد برای فیلتر نمایش پرواز ها بر اساس سیاست های شرکت میباشد
                $this->tickets['flights'][$direction] = $this->getController('resultLocal')->deleteInactiveAirline($this->tickets['flights'][$direction], 'isInternal', $data_param_set_change_price, 'new');
                $this->tickets['time']['end_inactive'] = date('H:i:s',time());
                $this->getReservationFlight($data_param_set_change_price);
                $this->tickets['time']['after_reservation'] = date('H:i:s',time());
                if (!empty($this->tickets['flights'])) {
                    $min = min($this->tickets['prices'][$direction]);
                    $max = max($this->tickets['prices'][$direction]);
                    $this->tickets['price'][$direction] = array(
                        'min_price' => floor($min),
                        'max_price' => ceil($max)
                    );

                }

                $sort = array();
                /*  foreach ($this->tickets['flights'][$direction] as $keySort => $arraySort) {
                      if ($arraySort['price']['adult']['price'] > 0) {
                          $sort['flights'][$direction]['price']['adult']['price'][$keySort] = $arraySort['price']['adult']['price'];
                      }
                  }

                  if (!empty($sort)) {
                      array_multisort($sort['flights'][$direction]['price']['adult']['price'], SORT_ASC, $this->tickets['flights'][$direction]);
                  }*/


                $sort = array();
                $sort_zero = array();
                $this->tickets['seat_class_filter']['economy']['count'] = 0 ;
                $this->tickets['seat_class_filter']['business']['count'] = 0 ;
                $this->tickets['seat_class_filter']['premium_economy']['count'] = 0 ;
                $this->tickets['type_flight_filter']['system']['count'] = 0 ;
                $this->tickets['type_flight_filter']['charter']['count'] = 0 ;
                foreach ($this->tickets['flights'][$direction] as $keySort => $arraySort) {

                    if ($arraySort['price']['adult']['price'] > 0) {
                        $sort[$direction][] = $arraySort;
                    } else {
                        $sort_zero[$direction][] = $arraySort;
                    }
                    if($arraySort['flight_type_li'] == 'system') {
                        ++$this->tickets['type_flight_filter']['system']['count'] ;
                    }else{
                        ++$this->tickets['type_flight_filter']['charter']['count'] ;
                    }

                    if($arraySort['seat_class_en'] == 'economy') {
                        ++$this->tickets['seat_class_filter']['economy']['count'] ;
                    }elseif ($arraySort['seat_class_en'] == 'premium_economy'){
                        ++$this->tickets['seat_class_filter']['premium_economy']['count'] ;
                    }else{
                        ++$this->tickets['seat_class_filter']['business']['count'] ;
                    }

                }


                $main_sort = array();
                foreach ($sort[$direction] as $key_main_sort => $item_sort)
                {
                    $main_sort['flights'][$direction]['price']['adult']['price'][$key_main_sort] = $item_sort['price']['adult']['price'];
                    $main_sort['check_sort_reservation'][$key_main_sort] = $item_sort['check_sort_reservation'];
                }


                if (!empty($main_sort)) {
                    array_multisort($main_sort['check_sort_reservation'], SORT_ASC, $main_sort['flights'][$direction]['price']['adult']['price'], SORT_ASC, $sort[$direction]);
                }




                $this->tickets['sortable']['main'] = $main_sort ;
                $this->tickets['sortable']['sort'] = $sort[$direction] ;
                $this->tickets['count_flights'] = count($sort[$direction]) ;
                if (!empty($sort[$direction]) && !empty($sort_zero[$direction])) {
                    $this->tickets[$direction]['is_complete'] = false ;
                    $this->tickets['flights'][$direction] = array_merge($sort[$direction], $sort_zero[$direction]);
                } elseif (empty($sort[$direction]) && !empty($sort_zero[$direction])) {
                    $this->tickets[$direction]['is_complete'] = true ;
                    $this->tickets['flights'][$direction] = $sort_zero[$direction];
                } else {
                    $this->tickets[$direction]['is_complete'] = false ;
                    $this->tickets['flights'][$direction] = $sort[$direction];
                }
            }

            $this->tickets['time']['end_direction'] = date('H:i:s',time());
            functions::insertLog(json_encode($this->tickets,256|64),'a_check_flight');

            functions::insertLog('***************************************','a_check_flight');
            if (!empty($this->tickets['flights']['dept'])) {
                return functions::withSuccess($this->tickets, 200, ' data flight fetch  successfully');
            }elseif (empty($flights)) {
                $this->getReservationFlight($data_param_set_change_price, 'yes') ;
                return functions::withSuccess($this->tickets, 200, 'successfully catch flight');
            }
            return functions::withError(null, 404, "there aren't flight for this search ss");

        }

        return functions::withError(null, 404, "there aren't flight for this search");

    }
    public function getLowestPriceFlightV1($params) {
        $info_currency = functions::infoCurrencyBySessionCode(Session::getCurrency());
        $list_config_airline = $this->listConfigAirline(true);
        $price_change_list = $this->flightPriceChangeList('local');
        $discount_list = $this->discountList();
        $translateVariable = $this->dataTranslate();


        $data_param_set_change_price['list_config_airline'] = $list_config_airline;
        $data_param_set_change_price['price_change_list'] = $price_change_list;
        $data_param_set_change_price['discount_list'] = $discount_list;
        $data_param_set_change_price['info_currency'] = $info_currency;
        $data_param_set_change_price['data_translate'] = $translateVariable;

        $url = $this->apiAddress . "Flight/flightFifteenDay";
        $data = array("Origin" => $params['origin'], "Destination" => $params['destination']);
        $result_send_data = functions::curlExecution($url, json_encode($data), 'yes');

        $data_lowest = array();
        $price = array();

        if ($result_send_data['result'] == 'true' && !empty($result_send_data['data'])) {
            foreach ($result_send_data['data'] as $key => $get_price) {
                $price[] = $get_price['price_final'];
                if($get_price['price_final'] != 0 ) {
                    $min_price_list[] = $get_price['price_final'];
                }
            }
            if($min_price_list && count($min_price_list) > 0) {
                $min_price = min($min_price_list);
            }else{
                $min_price = 0 ;
            }

            foreach ($result_send_data['data'] as $key => $data_flight) {

                if($key != 15) {
                    $flight_type = ($data_flight['displayLable'] == 'سیستمی') ? 'system' : 'charter';
                    $fare = ($data_flight['price_final'] - (($data_flight['price_final'] * 4573) / 100000));
                    $data_change_price = array(
                        'airlineIata' => $data_flight['iatA_code'],
                        'FlightType' => strtolower($flight_type),
                        'typeZone' => 'local',
                        'typeFlight' => 'economy',
                        'sourceId' => '8',
                        'isInternal' => true,
                        'price' => array(
                            'adult' => array(
                                'TotalPrice' => ($data_flight['price_final'] / 10),
                                'BasePrice' => $fare,
                            ),
                            'child' => array(
                                'TotalPrice' => 0,
                                'BasePrice' => 0,
                            ),
                            'infant' => array(
                                'TotalPrice' => 0,
                                'BasePrice' => 0,
                            ),
                        )
                    );
                    if (SOFTWARE_LANG == 'fa') {
                        $time_date = functions::ConvertToDateJalaliInt($data_flight['date_flight']);
                        $date_to_day = dateTimeSetting::jdate("m/j", $time_date);
                        $date_to_day_link = dateTimeSetting::jdate("Y-m-d", $time_date, '', '', 'en');
                        $name_to_day = dateTimeSetting::jdate("l", $time_date);
                    } else {
                        $date_to_day = date('Y F d', strtotime($data_flight['date_flight']));
                        $date_to_day_link = $data_flight['date_flight'];
                        $name_to_day = date("l", strtotime($data_flight['date_flight']));
                    }

                    $price_final = $this->getController('priceChanges')->setPriceChangesFlight($data_change_price, $data_param_set_change_price);

                    if (isset($params['origin_name']) && $params['origin_name']) {
                        $info_route = $this->getController('routeFlight')->getRouteInternal($params);
                        $data_lowest[$key]['origin_name'] = $info_route['Departure_City'];
                        $data_lowest[$key]['destination_name'] = $info_route['Arrival_City'];
                    }
                    $passengers = '1-0-0';
                    if (isset($params['passengers']) && $params['passengers']) {
                        $passengers = $params['passengers'];
                    }
                    $fa_price = functions::convert_rial_toman($price_final['adult']['TotalPrice']);
                    $fa_price = ($fa_price/1000);

                    $data_lowest[$key]['date_for_show'] = $date_to_day;
                    $data_lowest[$key]['name_date'] = $name_to_day;
                    $data_lowest[$key]['search_date'] = $date_to_day_link;
                    $data_lowest[$key]['price_final'] = $price_final['adult']['TotalPrice'] > 0 ? (((ISCURRENCY && SOFTWARE_LANG != 'fa') ? number_format(floatval($price_final['adult']['TotalPrice']),2) : number_format($fa_price))) : functions::Xmlinformation("FullCapacity")->__toString();
                    $data_lowest[$key]['class_min_price'] = ($data_flight['price_final'] == $min_price && $data_flight['price_final'] > 0) ? 'active_col_today' : '';
                    $data_lowest[$key]['url'] = ROOT_ADDRESS . '/domestic-flight/1/' . $params['origin'] . '-' . $params['destination'] . '/' . $date_to_day_link . '/' . 'Y' . '/' . $passengers;
                }
            }

            return functions::withSuccess($data_lowest, 200, 'data lowest fetch successfully');
        }
        if (isset($params['origin_name']) && $params['origin_name']) {
            for ($i = 0; $i < 15; $i++) {
                if (SOFTWARE_LANG == 'fa') {
                    $time_date = functions::ConvertToDateJalaliInt(date('Y-m-d', time()));
                    $date_to_day = dateTimeSetting::jdate("j F Y", $time_date);
                } else {
                    $date_to_day = date('Y F d', time());
                }

                $info_route = $this->getController('routeFlight')->getRouteInternal($params);
                $data_lowest[$i]['origin_name'] = $info_route['Departure_City'];
                $data_lowest[$i]['destination_name'] = $info_route['Arrival_City'];
                $data_lowest[$i]['date_for_show'] = $date_to_day;
                $data_lowest[$i]['date_for_show'] = $date_to_day;
                $data_lowest[$i]['price_final'] = '';
            }

        }
        return functions::withError($data_lowest, 400, 'data not found');
    }

}


/*new newApiFlight();*/

