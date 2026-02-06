<?php

date_default_timezone_set('Asia/Tehran');

class resultSearchExternalHotel extends clientAuth
{
  public $IsLogin ;
  public $counterId ;
    public function __construct(){
      parent::__construct();
//      if(CLIENT_ID == '251'){
//          error_reporting( 1 );
//          error_reporting( E_ALL | E_STRICT );
//          @ini_set( 'display_errors', 1 );
//          @ini_set( 'display_errors', 'on' );
//      }
        $this->IsLogin = Session::IsLogin();
        if ( $this->IsLogin ) {
            $this->counterId  = functions::getCounterTypeId( $_SESSION['userId'] );
        } else {
            $this->counterId = '5';
        }
    }

    public function getHotels($param)
    {



        functions::insertLog(CLIENT_NAME. ' ' .CLIENT_ID . ' => '.json_encode($param), 'times', 'yes');
        $t1 = microtime(true);

        /** @var resultExternalHotel $objExternalHotel */
        $objExternalHotel = Load::controller('resultExternalHotel');


//        functions::insertLog(CLIENT_NAME. ' ' .CLIENT_ID . ' => after resultExternalHotel Loaded', 'times', 'yes');
        $logs = '';
        $arrayHotelsByType = [];
        $hotelsRoomFreeBreakfast = [];
        $hotelsFacilities = [];
        $arrayFacilities = [];
        $cityId = '';
        $cityNameFa = '';
        $countryNameFa = '';
        $return = [];


        if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' || substr($param['startDate'], "0", "4") >= date('Y', time())) {
            //$sDateJalali = functions::ConvertToJalali($param['startDate']);
            $sDateMiladi = $param['startDate'];
        } else {
            //$sDateJalali = $param['startDate'];
            $sDateMiladi = functions::ConvertToMiladi($param['startDate']);
        }

        // واکشی اطلاعات کامل هتل های رزرواسیون و امکانات هتل های خارجی //

        $resultHotelDB = $objExternalHotel->getHotelsFromDB($param['countryNameEn'], $param['cityNameEn'], $param['startDate'], $param['nights'] , $param['rooms']);



        $t2 = microtime(true);
//        functions::insertLog(CLIENT_NAME. ' ' .CLIENT_ID . ' => after getHotelsFromDb', 'times', 'yes');
        if (!empty($resultHotelDB)) {
            $cityNameFa = $resultHotelDB[0]['city_persian_name'];
            $countryNameFa = $resultHotelDB[0]['country_persian_name'];
            foreach ($resultHotelDB as $key => $val) {
                if($val['minimum_room_price'] > 0 || $val['currency_price'] > 0) {
                    if ($val['type_app'] == 'reservation') {
                        $arrayHotelsByType['reservation'][$key]['HotelIndex'] = $val['hotel_index'];
                        $arrayHotelsByType['reservation'][$key]['HotelPersianName'] = $val['hotel_persian_name'];
                        $arrayHotelsByType['reservation'][$key]['HotelName'] = $val['hotel_name'];
                        $arrayHotelsByType['reservation'][$key]['hotel_name_en'] = $val['hotel_name'];
                        $arrayHotelsByType['reservation'][$key]['ImageURL'] = $val['image_url'];
                        $arrayHotelsByType['reservation'][$key]['ImageURLInSize300'] = $val['image_url'];
                        $arrayHotelsByType['reservation'][$key]['BreifingDetail'] = '';
                        $arrayHotelsByType['reservation'][$key]['HotelStars'] = $val['hotel_stars'];
                        $arrayHotelsByType['reservation'][$key]['HotelAddress'] = $val['hotel_address'];
                        $arrayHotelsByType['reservation'][$key]['MapLang'] = isset($val['longitude']) ? $val['longitude'] : 0;
                        $arrayHotelsByType['reservation'][$key]['MapLat'] = isset($val['latitude']) ? $val['latitude'] : 0;
                        if($val['currency_price'] > 0 ) {


                            $currency_amount_without_com = functions::CalculateCurrencyPrice([
                                'price' => $val['currency_price'],
                                'currency_type' => $val['currency_type']
                            ]);

                            // ذخیره نرخ بدون کمیسیون (هر شب + مجموع)
                            $arrayHotelsByType['reservation'][$key]['MinimumRoomPriceEachNightWithOutCom'] =
                                floatval($val['minimum_room_price'] + $currency_amount_without_com['AmountCurrency']);

                            $arrayHotelsByType['reservation'][$key]['MinimumRoomPriceWithOutCom'] =
                                $arrayHotelsByType['reservation'][$key]['MinimumRoomPriceEachNightWithOutCom'] * $param['nights'];


                            // 2) اگر کمیسیون وجود دارد → محاسبه قیمت بعد از کمیسیون
                            if(isset($val['commissionDiscount']) && $val['commissionDiscount'] != 0) {

                                $currencyPriceWithDiscount =
                                    $val['currency_price'] * (100 - $val['commissionDiscount']) / 100;

                                $currency_amount_with_discount = functions::CalculateCurrencyPrice([
                                    'price' => $currencyPriceWithDiscount,
                                    'currency_type' => $val['currency_type']
                                ]);

                                $arrayHotelsByType['reservation'][$key]['MinimumRoomPriceEachNight'] =
                                    floatval($val['minimum_room_price'] + $currency_amount_with_discount['AmountCurrency']);

                                $arrayHotelsByType['reservation'][$key]['MinimumRoomPrice'] =
                                    $arrayHotelsByType['reservation'][$key]['MinimumRoomPriceEachNight'] * $param['nights'];

                                $arrayHotelsByType['reservation'][$key]['commissionPercent'] =
                                    isset($val['commissionDiscount']) ? floatval($val['commissionDiscount']) : 0;

                            } else {

                                $arrayHotelsByType['reservation'][$key]['MinimumRoomPriceEachNight'] =
                                    $arrayHotelsByType['reservation'][$key]['MinimumRoomPriceEachNightWithOutCom'];

                                $arrayHotelsByType['reservation'][$key]['MinimumRoomPrice'] =
                                    $arrayHotelsByType['reservation'][$key]['MinimumRoomPriceWithOutCom'];


                            }

                        } else {

                            $arrayHotelsByType['reservation'][$key]['MinimumRoomPriceEachNight'] = isset($val['minimum_room_price']) ? floatval($val['minimum_room_price']) : 0;
                            if(isset($param['rooms']) && !empty($param['rooms']) &&       $arrayHotelsByType['reservation'][$key]['MinimumRoomPriceEachNight']!= 0 ) {
                                $MinimumRoomPriceEachNight = $this->calculateRoomPriceEachNight($val['hotel_index'] , $param['rooms'] , $val['minimum_room_price'] , $param['startDate']);
                                $arrayHotelsByType['reservation'][$key]['MinimumRoomPriceEachNight']  = floatval($MinimumRoomPriceEachNight);
                            }
                            $arrayHotelsByType['reservation'][$key]['MinimumRoomPrice'] = $arrayHotelsByType['reservation'][$key]['MinimumRoomPriceEachNight'] * $param['nights'] ;
                        }


                    $arrayHotelsByType['reservation'][$key]['FreeBreakfast'] = $val['free_breakfast'];
                    $arrayHotelsByType['reservation'][$key]['Facilities'] = $val['facilities'];
                    if(isset($val['flag_special']) && !empty($val['flag_special'])) {
                        $arrayHotelsByType['reservation'][$key]['isSpecial'] = $val['flag_special'];
                    }else {
                        $arrayHotelsByType['reservation'][$key]['isSpecial'] = 'no';
                    }


                }

                elseif ($val['type_app'] == 'externalApi' && $cityId == '') {
                    $cityId = $val['city_id'];
                }

                $hotelsRoomFreeBreakfast[$val['type_app']][$val['hotel_index']] = $val['free_breakfast'];
                $hotelsFacilities[$val['type_app']][$val['hotel_index']] = $val['facilities'];
                }
            }

        } else {
            $return = [
                'error' => $objExternalHotel->error,
                'message' => $objExternalHotel->errorMessage,
            ];
        }
        $t3 = microtime(true);
        //		$showApiResult = functions::isTestServer(['online.iran-tech.com','192.168']);
        //		if($showApiResult) {
        // واکشی اطلاعات کامل هتل های وب سرویس //
        /** @var apiExternalHotel $objApiExternalHotel */
//        functions::insertLog(CLIENT_NAME. ' ' .CLIENT_ID . ' => before apiExternalLibrary', 'times', 'yes');
        $objApiExternalHotel = Load::library('apiExternalHotel');
     
        $searchParams = [];
        $requestNumber = '';
        if ($objApiExternalHotel->apiHotelAuth() == 'True') {
            $searchParams['city'] = str_replace('-', ' ', $param['cityNameEn']);

//            $startDate = str_replace( [ "/", "-" ], "", $param['startDate'] );
            $searchParams['startDate'] = $param['startDate'];
            functions::insertLog(serialize(substr( $param['startDate'], "0", "4" ) > 2000), 'times', 'yes');
//            $param['lang'] == 'en' || $param['lang'] == 'ar' ||
            if ( substr( $param['startDate'], "0", "4" ) > 2000 ) {
                functions::insertLog(' must be gregorian => '.json_encode($param), 'times', 'yes');
                $searchParams['calendarType'] = 'gregorian';
//            $startDate = functions::ConvertToJalali( $param['startDate'] );
//            $endDate   = functions::ConvertToJalali( $param['endDate'] );
                $startDateInt = strtotime($param['startDate']);
                $endInt = strtotime("{$param['startDate']} +{$param['nights']}Day");
                $searchParams['endDate'] = date('Y-m-d', $endInt);
            }else{
                $searchParams['calendarType'] = 'jalali';
                $startInt = functions::ConvertToMiladi($param['startDate'], '-');
                $endInt = strtotime("{$startInt} +{$param['nights']}Day");
                $searchParams['endDate'] = dateTimeSetting::jdate('Y-m-d', $endInt, '', '', 'en');
            }
            $searchParams['rooms'] = $param['rooms'];
            $searchParams['countryNameEn'] = str_replace('-', ' ', $param['countryNameEn']);
            $finalChildCount = $finalAdultCount = [];
            if ($cityNameFa == '') {
                $cityNameFa = $searchParams['city'];
            }
            if ($countryNameFa == '') {
                $countryNameFa = $searchParams['countryNameEn'];
            }
            $searchParams['nationality'] = (isset($param['nationality']) && $param['nationality'] != '') ? $param['nationality'] : '';
//			functions::insertLog( 'Action searchHotel Start', '00001-checkExternalHotel' );

            //				if ( functions::isTestServer('online.iran-tech.com') ) {
            $t4 = microtime(true);

            $data_get_city_external = array(
                'country' =>  $searchParams['countryNameEn'],
                'city' =>  $searchParams['city'],
            );
            $city = $this->getCityNameBySearchParams($data_get_city_external);
//            functions::insertLog(CLIENT_NAME. ' ' .CLIENT_ID . ' => before searchHotel', 'times', 'yes');
            functions::insertLog(CLIENT_NAME. '  searchParams = '.json_encode($searchParams), 'times', 'yes');
            $resultApi = $objApiExternalHotel->searchHotel($searchParams);
            functions::insertLog(CLIENT_NAME. '  searchParams = '.json_encode($resultApi), 'times', 'yes');
//            functions::insertLog(CLIENT_NAME. ' ' .CLIENT_ID . ' => after searchHotel', 'times', 'yes');
            $t5 = microtime(true);
//            functions::insertLog(CLIENT_NAME. ' ' .CLIENT_ID . ' => '.json_encode($searchParams), 'times', 'yes');

//			functions::insertLog( 'Action searchHotel End', '00001-checkExternalHotel' );
            $resultApi = functions::clearJsonHiddenCharacters($resultApi);

//			functions::insertLog( 'response :' . PHP_EOL . $resultApi, 'hotel-api-response' );
            $ApiResult = json_decode($resultApi, true);

            $requestNumber = $ApiResult['RequestNumber'];

            $t6 = microtime(true);
            if (isset($ApiResult['Success']) && ($ApiResult['Success'] == true) && isset($ApiResult['Result']) && !empty($ApiResult['Result'])) {
//				functions::insertLog( 'Action Find Result before Foreach', '00001-checkExternalHotel' );
                $searchIdApi = $ApiResult['RequestNumber'];
                $hotelItem = [];
             
                functions::insertLog('getHotels before foreach result ' . microtime(true), 'times');
                foreach ($ApiResult['Result'] as $apiKey => $apiHotel) {
                    if($apiHotel['SourceId'] == '18') {
                        $final_price = $this->getController('currencyEquivalent')->calculateEquivalent($apiHotel['Currency']  ,$apiHotel['MinPrice']) ;
                        $hotelItem[$apiKey]['MinimumRoomPrice'] = $final_price;
                    }else {

                        $hotelItem[$apiKey]['MinimumRoomPrice'] = $apiHotel['MinPrice'];
                    }



                    $hotelItem[$apiKey]['HotelName'] = $apiHotel['HotelName'];
                    $hotelItem[$apiKey]['CountryName'] = $apiHotel['CountryName'];
                    $hotelItem[$apiKey]['SourceId'] = $apiHotel['SourceId'];
                    $hotelItem[$apiKey]['WebServiceType'] = $apiHotel['WebServiceType'] ?  $apiHotel['WebServiceType'] : '';
                    $hotelItem[$apiKey]['CityName'] = $apiHotel['CityName'];
                    $hotelItem[$apiKey]['HotelIndex'] = $apiHotel['HotelIndex'];
                    $hotelItem[$apiKey]['HotelPersianName'] = $apiHotel['HotelName'];
                    $hotelItem[$apiKey]['HotelStars'] = $apiHotel['HotelStars'];
                    $hotelItem[$apiKey]['ImageURL'] = $apiHotel['FeaturedPicture'];
                    $hotelItem[$apiKey]['facilities'] = array_map(function($facility){
                      return $facility['name_en'];
                    },$apiHotel['Facilities']);

                    $hotelItem[$apiKey]['MapLang'] = $apiHotel['ContactInformation']['Location']['latitude'];
                    $hotelItem[$apiKey]['MapLat'] = $apiHotel['ContactInformation']['Location']['longitude'];
                    $hotelItem[$apiKey]['HotelAddress'] = isset($apiHotel['ContactInformation']['Address']) ? $apiHotel['ContactInformation']['Address'] : '---';
                    $hotelItem[$apiKey]['city_id'] = $city['id'];
                    $hotelItem[$apiKey]['isSpecial'] ='no';
                }
              
                functions::insertLog('getHotels after foreach ' . microtime(true), 'times');
                $t7 = microtime(true);
//				functions::insertLog( 'Action Find Result After Foreach', '00001-checkExternalHotel' );
                $arrayHotelsByType['externalApi'] = $hotelItem;

//                $arrayFacilities = ['MINIBAR', 'TV', 'WI-FI', 'ROOM SERVICE'];
            }
        }
        //		}

//		functions::insertLog( 'Action after Auth check', '00001-checkExternalHotel' );


//        functions::getConfigContentByTitle('external_hotel_search_advertise');

        if (!empty($arrayHotelsByType)) {
            functions::insertLog('start of arrayHotelsByType ' . microtime(true), 'times');
            //امتیاز باشگاه//
            $pointClub = [];
            if (Session::IsLogin()) {
                $counterId = functions::getCounterTypeId($_SESSION['userId']);
                $param['service'] = 'PublicPortalHotel';
                $param['baseCompany'] = 'all';
                $param['company'] = 'all';
                $param['counterId'] = $counterId;
                $pointClub['externalApi'] = functions::pointClub($param);

                $param['service'] = 'PrivatePortalHotel';
                $param['baseCompany'] = 'all';
                $param['company'] = 'all';
                $param['counterId'] = $counterId;
                $pointClub['reservation'] = functions::pointClub($param);
            }

            $arrayPrice = [];
            $arrayHotel = [];
            $countHotels = 0;
            $t8 = microtime(true);
            foreach ($arrayHotelsByType as $typeApp => $hotels) {
                if (!empty($hotels)) {
                    $t9 = microtime(true);
                    foreach ($hotels as $k => $hotel) {

                        $star = $hotel['HotelStars'] > 0 ? $hotel['HotelStars'] : 0;
                        $nameEnUrl = $objExternalHotel->convertStringForUrl($hotel['HotelName']);

                        if ($typeApp == 'externalApi' && isset($hotel['ImageURL']) && $hotel['ImageURL'] != '') {

//                            $nameImages300 = $nameEnUrl . 'x300.jpg';

                            $countryName = str_replace(" ", "-", strtolower($hotel['CountryName']));

                            $cityName = str_replace(" ", "-", strtolower($hotel['CityName']));

                            $urlPicInSize300 = isset($hotel['ImageURLInSize300']) ? $hotel['ImageURLInSize300'] : $hotel['ImageURL'];

                        } elseif ($typeApp == 'reservation') {
                            $urlPicInSize300 = $hotel['ImageURL'];
                        } else {
                            $urlPicInSize300 = ROOT_ADDRESS_WITHOUT_LANG . '/pic/hotel-nophoto.jpg';
                        }

                        $MinimumRoomPriceEachNight = 0;
                        $service_type = $hotel['WebServiceType'] ? $hotel['WebServiceType'] : '';
                        $city_id = $hotel['city_id'] ? $hotel['city_id']: '';
                        $hotel_price_change = functions::getHotelPriceChange($city_id, $star, $this->counterId, $param['startDate'], $typeApp);
                        $hotel_service_title = functions::TypeServiceHotel($typeApp,'',$service_type);
                        $discount_hotel = functions::ServiceDiscount($this->counterId,$hotel_service_title);

                        $external_hotel_calculate_price = functions::calculateHotelPrice($hotel_price_change,$discount_hotel,$hotel['MinimumRoomPrice']);

                        $minimumRoomPrice = $external_hotel_calculate_price['calculated_price'];
                        $minimumRoomPriceEachNight = ceil($minimumRoomPrice / $param['nights']);

                        if ($minimumRoomPrice > 0) {
                            $arrayPrice[] = $minimumRoomPrice;
                        }
                        $hotelFacilities = '';
                        if (!empty($hotel['facilities'])) {
                            $hotelFacilities = implode('|',$hotel['facilities']);
                        } elseif ($typeApp == 'reservation') {
                            $hotelFacilities = $hotel['Facilities'];
                        } else {
//                            $hotelFacilities = "MINIBAR|TV|WI-FI|ROOM SERVICE|SATELLITE TV";
                        }

                        if ($typeApp == 'externalApi' && isset($hotelsRoomFreeBreakfast[$typeApp][$hotel['HotelIndex']]) && $hotelsRoomFreeBreakfast[$typeApp][$hotel['HotelIndex']] != '') {
                            $hotelRoomFreeBreakfast = $hotelsRoomFreeBreakfast[$typeApp][$hotel['HotelIndex']];
                        } elseif ($typeApp == 'reservation') {
                            $hotelRoomFreeBreakfast = $hotel['FreeBreakfast'];
                        } else {
                            $hotelRoomFreeBreakfast = "";
                        }
                        $t11 = microtime(true);
                        $arrayHotel[$countHotels] = $hotel;
                        $arrayHotel[$countHotels]['MinimumRoomPriceWithOutCom'] =
                            isset($hotel['MinimumRoomPriceWithOutCom'])
                                ? round($hotel['MinimumRoomPriceWithOutCom'])
                                : 0;

                        $arrayHotel[$countHotels]['MinimumRoomPriceEachNightWithOutCom'] =
                            isset($hotel['MinimumRoomPriceEachNightWithOutCom'])
                                ? round($hotel['MinimumRoomPriceEachNightWithOutCom'])
                                : 0;

                        $arrayHotel[$countHotels]['commissionPercent'] =
                            isset($hotel['commissionPercent'])
                                ? floatval($hotel['commissionPercent'])
                                : 0;



                        $arrayHotel[$countHotels]['RequestNumber'] = $searchIdApi;
                        $arrayHotel[$countHotels]['typeApp'] = $typeApp;
                        $arrayHotel[$countHotels]['nameEnUrl'] = $nameEnUrl;
                        $arrayHotel[$countHotels]['hotelIndex'] = $hotel['HotelIndex'];
                        $arrayHotel[$countHotels]['hotelStars'] = $star;
                        $arrayHotel[$countHotels]['freeBreakfast'] = $hotelRoomFreeBreakfast;
                        $arrayHotel[$countHotels]['hotelFacilities'] = $hotelFacilities;
                        $facilities_list = [];

                        if (isset($hotelFacilities)) {
                            $expHotelsFacilities = explode("|", $hotelFacilities);
                            $countCh = 0;
                            foreach ($expHotelsFacilities as $facilities) {
                                if (!in_array($facilities, $arrayFacilities) && !empty($facilities)) {
                                    $arrayFacilities[] = $facilities;
                                }
//                                if ($countCh + strlen($facilities) <= 50) {
//                                    $countCh = $countCh + strlen($facilities);
                                    $facilities_list[] = $facilities;
//                                }

                            }

                        } else {
                            $facilities_list[] = 'MINIBAR | TV | WI-FI | ROOM SERVICE | SATELLITE TV |...';
//                            $facilities_list[] = ['MINIBAR', 'TV', 'WI-FI', 'ROOM SERVICE', 'SATELLITE TV', '...'];
                        }

                        $arrayHotel[$countHotels]['facilitiesList'] = $facilities_list;


                        $arrayHotel[$countHotels]['has_discount'] = ($discount_hotel['off_percent'] > 0) ? true: false;
                        $arrayHotel[$countHotels]['discount'] = ($discount_hotel['off_percent'] > 0) ? number_format($discount_hotel['off_percent'])  : '';
                        $arrayHotel[$countHotels]['priceWithoutDiscount'] = round($external_hotel_calculate_price['price_with_increase_change']);
                        $arrayHotel[$countHotels]['priceWithoutDiscountCurrency'] = functions::CurrencyCalculate($external_hotel_calculate_price['price_with_increase_change']);
                        $arrayHotel[$countHotels]['priceWithoutDiscountCurrency']['AmountCurrency'] = round( $arrayHotel[$countHotels]['priceWithoutDiscountCurrency']['AmountCurrency']);
                        $arrayHotel[$countHotels]['mainCurrency'] = functions::CurrencyCalculate($minimumRoomPrice);
                        $arrayHotel[$countHotels]['mainCurrency']['AmountCurrency'] = round( $arrayHotel[$countHotels]['mainCurrency']['AmountCurrency'] );
                        $arrayHotel[$countHotels]['mainCurrencyEachNight'] = functions::CurrencyCalculate($minimumRoomPriceEachNight);
                        $arrayHotel[$countHotels]['mainCurrencyEachNight']['AmountCurrency'] = round( $arrayHotel[$countHotels]['mainCurrencyEachNight']['AmountCurrency'] );

                        $arrayHotel[$countHotels]['minimumRoomPrice'] =  round($minimumRoomPrice);
                        $arrayHotel[$countHotels]['minimumRoomPriceEachNight'] =  round($minimumRoomPriceEachNight);
		        $arrayHotel[$countHotels]['amountCurrency'] =  round($arrayHotel[$countHotels]['mainCurrency']['AmountCurrency']);



                        $arrayHotel[$countHotels]['calculatePoint'] = 0;
                        if (isset($pointClub[$typeApp]) && $pointClub[$typeApp]['limitPrice'] > 0) {
                            $calculatePoint = ceil($minimumRoomPrice / $pointClub[$typeApp]['limitPrice']);
                            $arrayHotel[$countHotels]['calculatePoint'] = $calculatePoint;
                        }
                        $arrayHotel[$countHotels]['pictureUrl'] = $urlPicInSize300;
//						$arrayHotel[ $countHotels ]['htmlHotel']      = $htmlHotel;

                        $countHotels++;
                    }
                    $t10 = microtime(true);
                }
            }

            functions::insertLog('after foreach arrayHotelsByType ' . microtime(true), 'times');

            if (!empty($arrayPrice)) {
                $minPrice = min($arrayPrice);
                $maxPrice = max($arrayPrice);
            } else {
                $minPrice = 0;
                $maxPrice = 0;
            }



            ob_start();
            ?>
            <div class="filtertip-searchbox filtertip-searchbox filtertip-searchbox-external-hotel">
            <span class="filter-title"><?php echo functions::Xmlinformation('PossibilitiesHotel'); ?></span>
            <div class="filter-content padb10 padt10">
<!--              <p class="raste-item all_hotels__externall">-->
<!--                <input type="checkbox" class="FilterHoteltype ShowAllFacilities"-->
<!--                       id="check_list_all" name="check_list_all" value="all" checked>-->
<!--                <label class="FilterHoteltypeName site-main-text-color-a"-->
<!--                       for="check_list_all">--><?php //echo functions::Xmlinformation('All'); ?><!--</label>-->
<!--              </p>-->
                <?php
                foreach ($arrayFacilities as $val) {
                    ?>
                  <p class="raste-item">
                    <input type="checkbox" class="FilterHoteltype ShowByFiltersFacilities"
                           id="check_list<?php echo $val; ?>" name="heck_list<?php echo $val; ?>"
                           value="<?php echo $val; ?>">
                    <label class="FilterHoteltypeName site-main-text-color-a"
                           for="check_list<?php echo $val; ?>"><?php echo $val; ?></label>
                  </p>
                    <?php
                }
                ?>
            </div>
              <script>
                $(document).ready(function () {
                  $(".ShowByFiltersFacilities").click(() => {
                    var hotelList = $('.hotel-result-item')
                    var isCheck = 0
                    let countHotels = 0
                    hotelList.hide()
                    $('input:checkbox.ShowByFiltersFacilities').each(function() {
                      var check = $(this).prop('checked')
                      var val = $(this).val()
                      if (check == true) {
                        isCheck++
                        var Check = $(this).val()
                        hotelList.filter(function() {
                          var hotelType = $(this).data('facilities')
                          if (hotelType.indexOf(Check) !== -1) {
                            countHotels++
                            return true
                          }
                          return hotelType == Check
                        }).show()
                      }
                      $('#countHotelHtml').html(countHotels)
                    })
                    if (isCheck == 0) {
                      hotelList.show()
                    }
                    $('html, body').animate({
                      scrollTop: $('.sort-by-section').offset().top,
                    }, 'slow')
                  })
                })
              </script>
          </div>
            <?php


            $htmlFacilitiesPage = ob_get_clean();
            $return = [
                'error' => false,
                'prices' => $arrayPrice,
                'requestNumber' => $requestNumber,
                'minPrice' => $minPrice,
                'maxPrice' => $maxPrice,
                'loginIdApi' => isset($loginIdApi) ? $loginIdApi : '',
                'searchIdApi' => isset($searchIdApi) ? $searchIdApi : '',
                'cityNameFa' => $cityNameFa,
                'countryNameFa' => $countryNameFa,
                'hotels' => $arrayHotel,
                'countHotel' => count($arrayHotel),
                'htmlFacilitiesPage' => $htmlFacilitiesPage,
                //				'htmlPage'           => $htmlPage,
                'times' => [
                    't1' => ($t2 - $t1),
                    't2' => ($t3 - $t2),
                    't3' => ($t4 - $t3),
                    't4' => ($t5 - $t4),
                    't5' => ($t6 - $t5),
                    't6' => ($t7 - $t6),
                    't7' => ($t8 - $t7),
                    't8' => ($t9 - $t8),
                    't9' => ($t10 - $t9),
                    't10' => ($t11 - $t10),
                ],
                'logs' => $logs,
                'advertises' => functions::getConfigContentByTitle('external_hotel_search_advertise'),
            ];

        } else {
            $return = [
                'error' => true,
                'requestNumber' => $requestNumber,
                'message' => functions::Xmlinformation('Nohotel'),
            ];
        }
   
        functions::insertLog('end getHotels', '00000-checkExternalHotel', 'yes');

//		functions::insertLog( json_encode($arrayHotelsByType), 'tttt', 'yes' );
//		functions::insertLog( json_encode($ApiResult), 'api', 'yes' );

        return json_encode($return, 256 | 64);
    }

    public function searchDetails($params)
    {

        $result = $this->getCityNameBySearchParams($params);


        if ( substr( $params['start_date'], "0", "4" ) > 2000 ) {
          $params['calendarType'] = 'gregorian';
        }else{
          $params['calendarType'] = 'jalali';
        }

        $response['id'] = $result['id'];
        if(SOFTWARE_LANG == 'en') {
            $response['City'] = $result['city_name_en'] ?: $result['city_name_en'];
        }else {
            $response['City'] = $result['city_name_fa'] ?: $result['city_name_en'];
        }

        $response['Country'] = $result['country_name_fa'] ?: $result['country_name_en'];
        $response['Nights'] = $params['nights'];
        $response['Nationality'] = $params['nationality'];
        if ($params['calendarType'] ==  'gregorian') {
            $response['StartDate'] = date('j F', strtotime($params['start_date']));
            $endInt = strtotime("{$params['start_date']} +{$params['nights']}Day");
            $response['EndDate'] = date('j F', $endInt);
        } else {
            $startInt = functions::ConvertToMiladi($params['start_date'], '-');
            $response['StartDate'] = dateTimeSetting::jdate('j F', strtotime($startInt), '', '', 'en');
            $endInt = strtotime("{$startInt} +{$params['nights']}Day");
            $response['EndDate'] = dateTimeSetting::jdate('j F', $endInt, '', '', 'en');
        }
//        $response['EndDate'] = $params['end_date'];
//        $response['sql'] = $sql;
        $response['calendarType'] = $params['calendarType'];
        $response['Rooms'] = $params['rooms'];

        return functions::toJson($response);
    }


    public function getCityNameBySearchParams($params)
    {
        return $this->getModel('externalHotelCityModel')->get()
            ->where('country_name_en', 'iran', '!=')
            ->where('country_name_en', trim(str_replace('-', ' ', $params['country'])))
            ->where('city_name_en', trim(str_replace('-', ' ', $params['city'])))
            ->find();
    }

    public function calculateRoomPriceEachNight($hotel_id , $passengers , $roomPrice , $sDate){

        $model = Load::library( 'Model' );
        if ( SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' || substr( $sDate, "0", "4" ) > 2000 ) {
            $sDatePersian = functions::ConvertToJalali( $sDate );
        } else {
            $sDatePersian = $sDate;
        }

        $sDatePersian = str_replace( "-", "", $sDatePersian );
        $sDatePersian = str_replace( "/", "", $sDatePersian );

        $sql = " SELECT
                       *
                    FROM
                        reservation_hotel_room_prices_tb AS reservationHotelPrice 
                    WHERE
                        reservationHotelPrice.id_hotel = '" . $hotel_id . "'
                        AND reservationHotelPrice.date = '" . $sDatePersian . "' 
                        AND reservationHotelPrice.user_type = '" . $this->counterId . "' 
                        AND reservationHotelPrice.flat_type = 'ECHD' 
                        AND reservationHotelPrice.is_del = 'no' 
                        LIMIT 1 ";

        $extra_child_room = $model->select( $sql, 'assoc' );

        $sql_free = " SELECT
                       *
                    FROM
                        reservation_hotel_room_prices_tb AS reservationHotelPrice 
                    WHERE
                        reservationHotelPrice.id_hotel = '" . $hotel_id . "'
                        AND reservationHotelPrice.date = '" . $sDatePersian . "' 
                        AND reservationHotelPrice.user_type = '" . $this->counterId . "' 
                        AND reservationHotelPrice.flat_type = 'CHD' 
                        AND reservationHotelPrice.is_del = 'no' 
                        LIMIT 1 ";
        $extra_free_child_room = $model->select( $sql_free, 'assoc' );

        $sql_free = " SELECT
                       *
                    FROM
                        reservation_hotel_room_prices_tb AS reservationHotelPrice 
                    WHERE
                        reservationHotelPrice.id_hotel = '" . $hotel_id . "'
                        AND reservationHotelPrice.date = '" . $sDatePersian . "' 
                        AND reservationHotelPrice.user_type = '" . $this->counterId . "' 
                        AND reservationHotelPrice.flat_type = 'EXT' 
                        AND reservationHotelPrice.is_del = 'no' 
                        LIMIT 1 ";
        $extra_adult_room = $model->select( $sql_free, 'assoc' );

        $price = 0 ;

        $passengers = json_decode($passengers , true) ;

        foreach ($passengers as $passenger) {
            $children = array() ;
            $adult = array() ;
            foreach ($passenger as $pass) {

                if ($pass['PassengerAge'] <= 12) {
                    array_push($children, $pass);
                } else {
                    array_push($adult, $pass);
                }
            }
            $price = $price  + $roomPrice ;

            if(count($children) !=  0 ) {
                foreach ($children as $child) {
                    $age = $child['PassengerAge'];
                    if(($age >= $extra_child_room[0]['fromAge'] && $age <= $extra_child_room[0]['toAge']) || (($extra_child_room[0]['fromAge'] - $extra_free_child_room[0]['toAge']) > 1)){
                        $price =$price + $extra_child_room[0]['online_price'];
                    }
                }
            }

        }

        return $price;

    }

    public function getHotelsJson(){

        return '{"RequestNumber":"14020421112412784130934364","Result":[{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12105295","HotelCode":"192507","SourceId":12,"HotelName":"Hotel Diplomat","HotelNameEn":"Hotel Diplomat","MinPrice":22306076,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":"9.95323E+11","Fax":null,"Address":"Bolo Agmarti Street 4, 0105 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6898803711,"longitude":44.7898254395}},"Facilities":[{"name_en":"Car Park"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/256457.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"105295"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12704579","HotelCode":"885774","SourceId":12,"HotelName":"Tiflis House","HotelNameEn":"Tiflis House","MinPrice":23647000,"Currency":null,"HotelType":"","CancelConditions":true,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Tsavkisi 2 Turn","AddressEn":"","Location":{"latitude":41.6898956299,"longitude":44.7899551392}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/709444.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"704579"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12193783","HotelCode":"281324","SourceId":12,"HotelName":"Hotel Epic","HotelNameEn":"Hotel Epic","MinPrice":24538000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Samreklo Street 26, 0103 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6980247498,"longitude":44.8136024475}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/449571.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"193783"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12676555","HotelCode":"857710","SourceId":12,"HotelName":"Vista Hotel","HotelNameEn":"Vista Hotel","MinPrice":24538000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":null,"Fax":null,"Address":"P. Kakabadze","AddressEn":"","Location":{"latitude":41.6988639832,"longitude":44.7907371521}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/1087254.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"676555"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12237939","HotelCode":"325603","SourceId":12,"HotelName":"Tbilisi Inn","HotelNameEn":"Tbilisi Inn","MinPrice":24777000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Metekhi street 20, 0103 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6916427612,"longitude":44.8142166138}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/542499.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"237939"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12217766","HotelCode":"305360","SourceId":12,"HotelName":"Hotel Shine on Rustaveli","HotelNameEn":"Hotel Shine on Rustaveli","MinPrice":24943412,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":"995-32-277 91 00","Fax":null,"Address":"Zaldastanishvili Street 7, close to Rustaveli Avenue, Mtatsminda , 0114 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.7020645142,"longitude":44.7891845703}},"Facilities":[{"name_en":"Car Park"},{"name_en":"Internet access"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/498923.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"217766"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12537827","HotelCode":"633305","SourceId":12,"HotelName":"Orien Tbilisi","HotelNameEn":"Orien Tbilisi","MinPrice":27593000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":"9.95323E+11","Fax":null,"Address":"Napareuli Street 5, Vake, 0179 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.7085762024,"longitude":44.7766952515}},"Facilities":[{"name_en":"Car Park"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/409586.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"537827"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12548840","HotelCode":"644332","SourceId":12,"HotelName":"Rustaveli Palace","HotelNameEn":"Rustaveli Palace","MinPrice":29531000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":"+995322931141,+995322931149","Fax":null,"Address":"Ekaterine Gabashvili Street 10, near Rustaveli Square, Mtatsminda , 0108 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.7027397156,"longitude":44.7900619507}},"Facilities":[{"name_en":"Car Park"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/425718.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"548840"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12522119","HotelCode":"617581","SourceId":12,"HotelName":"Iveria Inn Hotel","HotelNameEn":"Iveria Inn Hotel","MinPrice":30654000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":"9.95322E+11","Fax":null,"Address":"Tsulukidze St. 6, 0108 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.689655304,"longitude":44.8669319153}},"Facilities":[{"name_en":"Car Park"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/464076.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"522119"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12633919","HotelCode":"815016","SourceId":12,"HotelName":"Hotel Pushkin","HotelNameEn":"Hotel Pushkin","MinPrice":30672000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":"9.95322E+11","Fax":null,"Address":"Bochorma Street","AddressEn":"","Location":{"latitude":41.6873207092,"longitude":44.8241844177}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/681354.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"633919"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12647494","HotelCode":"828611","SourceId":12,"HotelName":"ibis Tbilisi Stadium","HotelNameEn":"ibis Tbilisi Stadium","MinPrice":30935840,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":"99515102019","Fax":null,"Address":"Aghmashenebeli Avenue","AddressEn":"","Location":{"latitude":41.7204017639,"longitude":44.7888526917}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":null,"Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"647494"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12888755","HotelCode":"1070152","SourceId":12,"HotelName":"Rikhe Kopala Hotel","HotelNameEn":"Rikhe Kopala Hotel","MinPrice":31285000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":"+995322775580,+995322775520","Fax":null,"Address":"Europe Square","AddressEn":"","Location":{"latitude":41.6918296814,"longitude":44.8117218018}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/450828.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"888755"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12525193","HotelCode":"620660","SourceId":12,"HotelName":"L.M Club Hotel","HotelNameEn":"L.M Club Hotel","MinPrice":31720364,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Kote Marjanishvili Street #29, Chugureti, 0102 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.7096176147,"longitude":44.7976531982}},"Facilities":[{"name_en":"Indoor Pool"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/728642.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"525193"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12524330","HotelCode":"619795","SourceId":12,"HotelName":"KMM Hotel","HotelNameEn":"KMM Hotel","MinPrice":31848336,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Metekhi Turn Street 10, 0103 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6905632019,"longitude":44.8133201599}},"Facilities":[{"name_en":"Car Park"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/431238.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"524330"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12118979","HotelCode":"206222","SourceId":12,"HotelName":"Hotel Shine Palace","HotelNameEn":"Hotel Shine Palace","MinPrice":32101000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":"00995 32265 4535","Fax":null,"Address":"Guramishvili Avenue 59, 0197 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.7852172852,"longitude":44.8007392883}},"Facilities":[{"name_en":"Car Park"},{"name_en":"Internet access"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/288231.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"118979"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12489214","HotelCode":"584639","SourceId":12,"HotelName":"Citrus Hotel","HotelNameEn":"Citrus Hotel","MinPrice":32349096,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":"9.95323E+11","Fax":null,"Address":"3, 9 Aprili street, Mtatsminda , 0108 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6957893372,"longitude":44.7967071533}},"Facilities":[{"name_en":"Car Park"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/464094.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"489214"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12238231","HotelCode":"325897","SourceId":12,"HotelName":"Hotel Tiflis","HotelNameEn":"Hotel Tiflis","MinPrice":32512000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":null,"Fax":null,"Address":"29 B Marjanishvili Street, Chugureti, 0102 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.709854126,"longitude":44.798034668}},"Facilities":[{"name_en":"Car Park"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/543147.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"238231"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12557337","HotelCode":"652843","SourceId":12,"HotelName":"Tbiliseli Hotel","HotelNameEn":"Tbiliseli Hotel","MinPrice":32849856,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":"9.95322E+11","Fax":null,"Address":"Anton Katalikosi Street 12, 0105 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6930427551,"longitude":44.8051643372}},"Facilities":[{"name_en":"Car Park"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/449576.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"557337"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12194095","HotelCode":"281637","SourceId":12,"HotelName":"Hotel Astoria Tbilisi","HotelNameEn":"Hotel Astoria Tbilisi","MinPrice":33439640,"Currency":null,"HotelType":"","CancelConditions":true,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Shota Chitadze Street 12, Mtatsminda , 0108 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6942596436,"longitude":44.7935829163}},"Facilities":[{"name_en":"Car Park"},{"name_en":"Internet access"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/450205.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"194095"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12593864","HotelCode":"774926","SourceId":12,"HotelName":"Imperial House","HotelNameEn":"Imperial House","MinPrice":34414000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Kalistrate Tsintsandze Street","AddressEn":"","Location":{"latitude":41.6941833496,"longitude":44.8035240173}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/849144.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"593864"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12272390","HotelCode":"360226","SourceId":12,"HotelName":"Hotel Marlyn","HotelNameEn":"Hotel Marlyn","MinPrice":34788000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Kote Apkhazi (Leselidze street) N3, 0105 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6928253174,"longitude":44.8025245667}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/617493.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"272390"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12289537","HotelCode":"377444","SourceId":12,"HotelName":"Gallery Palace","HotelNameEn":"Gallery Palace","MinPrice":34917000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":null,"Fax":null,"Address":"5 Pavle Ingorokva Street, 0105 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6933250427,"longitude":44.798034668}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/653411.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"289537"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12672456","HotelCode":"853606","SourceId":12,"HotelName":"Sole Palace","HotelNameEn":"Sole Palace","MinPrice":34966000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Iakob Tsurtaveli Street","AddressEn":"","Location":{"latitude":41.686580658,"longitude":44.8150787354}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/1083247.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"672456"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12802278","HotelCode":"983582","SourceId":12,"HotelName":"Royal Inn","HotelNameEn":"Royal Inn","MinPrice":34966000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Z Kurdiani","AddressEn":"","Location":{"latitude":41.7038459778,"longitude":44.8034667969}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/1170046.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"802278"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12483793","HotelCode":"579210","SourceId":12,"HotelName":"Best Western Tbilisi Art Hotel","HotelNameEn":"Best Western Tbilisi Art Hotel","MinPrice":35170044,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":"9.95322E+11","Fax":null,"Address":"Apakidze Street 11, Saburtalo, 0171 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.7198371887,"longitude":44.780292511}},"Facilities":[{"name_en":"Car Park"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/411652.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"483793"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"121010192","HotelCode":"1191739","SourceId":12,"HotelName":"Tbilisi Laerton","HotelNameEn":"Tbilisi Laerton","MinPrice":35874000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":"9.95323E+11","Fax":null,"Address":"Iliko Kurkhuli Street","AddressEn":"","Location":{"latitude":41.6902389526,"longitude":44.8212585449}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/433764.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"1010192"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12306602","HotelCode":"394559","SourceId":12,"HotelName":"The Grove Design Hotel","HotelNameEn":"The Grove Design Hotel","MinPrice":36561000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Kvinitadze Street 8, Chugureti, 0112 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.7175178528,"longitude":44.7897987366}},"Facilities":[{"name_en":"Internet access"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/689021.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"306602"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12478840","HotelCode":"574243","SourceId":12,"HotelName":"Astoria","HotelNameEn":"Astoria","MinPrice":36776000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":"2922246","Fax":null,"Address":"Agmashenebeli Avenue 189A, Chugureti, 0112 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.7852134705,"longitude":44.7698669434}},"Facilities":[{"name_en":"Car Park"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/363968.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"478840"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12492113","HotelCode":"587541","SourceId":12,"HotelName":"Costé Hotel","HotelNameEn":"Costé Hotel","MinPrice":37040000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":"+995322191111,+995322191111","Fax":null,"Address":"Kostava Street 45A, 0179 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.70885849,"longitude":44.7853775024}},"Facilities":[{"name_en":"Car Park"},{"name_en":"Internet access"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/439908.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"492113"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12330166","HotelCode":"418201","SourceId":12,"HotelName":"Ameri Plaza Hotel","HotelNameEn":"Ameri Plaza Hotel","MinPrice":38647000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":null,"Fax":null,"Address":null,"AddressEn":"","Location":{"latitude":41.7232894897,"longitude":44.7766914368}},"Facilities":[{"name_en":"Car Park"},{"name_en":"Breakfast Buffet"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/737367.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"330166"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12398090","HotelCode":"486248","SourceId":12,"HotelName":"New Tiflis Hotel","HotelNameEn":"New Tiflis Hotel","MinPrice":38853412,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":null,"Fax":null,"Address":"75 Davit Aghmashenebeli Avenue, Chugureti, 0102 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.7081451416,"longitude":44.798576355}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/875619.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"398090"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12298039","HotelCode":"385969","SourceId":12,"HotelName":"Shota@Rustaveli Boutique hotel","HotelNameEn":"Shota@Rustaveli Boutique hotel","MinPrice":38855000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Shevchenko str. 1, Mtatsminda , 0108 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6970252991,"longitude":44.7974052429}},"Facilities":[{"name_en":"Internet access"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/671131.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"298039"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12971117","HotelCode":"1152623","SourceId":12,"HotelName":"Just Inn Tbilisi","HotelNameEn":"Just Inn Tbilisi","MinPrice":40327872,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Noe Jordania Bank","AddressEn":"","Location":{"latitude":41.7017669678,"longitude":44.8059883118}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/908746.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"971117"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12200131","HotelCode":"287680","SourceId":12,"HotelName":"Urban Boutique","HotelNameEn":"Urban Boutique","MinPrice":41101000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Gogebashvili street 9, 0108 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.7023963928,"longitude":44.7855377197}},"Facilities":[{"name_en":"Car Park"},{"name_en":"Internet access"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/462471.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"200131"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12521087","HotelCode":"616547","SourceId":12,"HotelName":"ILiani","HotelNameEn":"ILiani","MinPrice":41714000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":"+995322234086,+995322335711,+9","Fax":null,"Address":"Anjaparidze Street 1, 0179 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.7109985352,"longitude":44.7833061218}},"Facilities":[{"name_en":"Car Park"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/134868.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"521087"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12428397","HotelCode":"516611","SourceId":12,"HotelName":"Folk Boutique Hotel","HotelNameEn":"Folk Boutique Hotel","MinPrice":42814980,"Currency":null,"HotelType":"","CancelConditions":true,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":null,"Fax":null,"Address":"56, Grishashvili street, 0105, 0105 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6853103638,"longitude":44.8198509216}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/937109.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"428397"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12493550","HotelCode":"588981","SourceId":12,"HotelName":"Cruise","HotelNameEn":"Cruise","MinPrice":43649580,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":"+99532541103,+99532541104,+995","Fax":null,"Address":"Beliashvili Street 75, 0159 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.768699646,"longitude":44.7798194885}},"Facilities":[{"name_en":"Car Park"},{"name_en":"Internet access"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/228046.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"493550"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12489102","HotelCode":"584527","SourceId":12,"HotelName":"Citadines Freedom Square Tbilisi","HotelNameEn":"Citadines Freedom Square Tbilisi","MinPrice":44168000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":"9.95323E+11","Fax":null,"Address":"Freedom Square 4 Bld.2A, 0105 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6931037903,"longitude":44.8009147644}},"Facilities":[{"name_en":"Car Park"},{"name_en":"Internet access"},{"name_en":"Breakfast Buffet"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/238254.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"489102"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12235984","HotelCode":"323641","SourceId":12,"HotelName":"Light House - Old City","HotelNameEn":"Light House - Old City","MinPrice":45008000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Samreklo Street 8, 0179 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6969184875,"longitude":44.8128471375}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/538059.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"235984"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12105297","HotelCode":"192509","SourceId":12,"HotelName":"River Side","HotelNameEn":"River Side","MinPrice":45113000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":"9.95322E+11","Fax":null,"Address":"Right Side of Mtkvari, The Brosse Turn, Mtatsminda , 0110 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.701877594,"longitude":44.7999000549}},"Facilities":[{"name_en":"Car Park"},{"name_en":"Outdoor Pool(s)"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/256461.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"105297"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12414312","HotelCode":"502511","SourceId":12,"HotelName":"Boho Tiflis Hotel","HotelNameEn":"Boho Tiflis Hotel","MinPrice":45524000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Zviad Gamsakhurdia Named Right Bank 6, 0114 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.7083969116,"longitude":44.7898521423}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/908727.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"414312"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12747426","HotelCode":"928660","SourceId":12,"HotelName":"Radius Hotel Tbilisi","HotelNameEn":"Radius Hotel Tbilisi","MinPrice":46008000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Shota Rustaveli Avenue","AddressEn":"","Location":{"latitude":41.6943817139,"longitude":44.799911499}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/1115662.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"747426"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12475355","HotelCode":"570748","SourceId":12,"HotelName":"Amante Narikala Hotel","HotelNameEn":"Amante Narikala Hotel","MinPrice":46570680,"Currency":null,"HotelType":"","CancelConditions":true,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":null,"Fax":null,"Address":"#1 Gomi Street, 500 metres uphill from Sulfur Baths, 0105 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.68907547,"longitude":44.8058204651}},"Facilities":[{"name_en":"Car Park"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/741114.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"475355"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12781773","HotelCode":"963055","SourceId":12,"HotelName":"Old Meidan","HotelNameEn":"Old Meidan","MinPrice":46622000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":"9.95323E+11","Fax":null,"Address":"Samghebro Street","AddressEn":"","Location":{"latitude":41.6894874573,"longitude":44.8090934753}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/589976.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"781773"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12557338","HotelCode":"652844","SourceId":12,"HotelName":"Tbilisi Park Hotel","HotelNameEn":"Tbilisi Park Hotel","MinPrice":46714000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":null,"Fax":null,"Address":"73 David Aghmashenebeli avenue, Chugureti, 0102 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.7084274292,"longitude":44.7997970581}},"Facilities":[{"name_en":"Car Park"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/858276.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"557338"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12310302","HotelCode":"398270","SourceId":12,"HotelName":"Kisi Hotel","HotelNameEn":"Kisi Hotel","MinPrice":46893392,"Currency":null,"HotelType":"","CancelConditions":true,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Botanikuri Street 17, 0105 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6874885559,"longitude":44.8101463318}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/696561.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"310302"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"1252584","HotelCode":"139714","SourceId":12,"HotelName":"Kopala","HotelNameEn":"Kopala","MinPrice":48070000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Chekhov Street 8/10, 0103 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6908149719,"longitude":44.8124313354}},"Facilities":[{"name_en":"Internet access"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/135721.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"52584"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12194100","HotelCode":"281642","SourceId":12,"HotelName":"Hotels & Preference Hualing Tbilisi","HotelNameEn":"Hotels & Preference Hualing Tbilisi","MinPrice":48554000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":5,"ContactInformation":{"Phone":"00995 (0)599083945","Fax":null,"Address":"Jozef Pilsudski Avenue, Tbilisi Sea New City, 0152 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.715511322,"longitude":44.8736228943}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/450215.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"194100"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12532115","HotelCode":"627591","SourceId":12,"HotelName":"Mercure Tbilisi Old Town","HotelNameEn":"Mercure Tbilisi Old Town","MinPrice":49057000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":"9.95322E+11","Fax":null,"Address":"Vakhtang Gorgasali Street 9, 0105 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6885299683,"longitude":44.8134307861}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/431756.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"532115"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12446619","HotelCode":"534898","SourceId":12,"HotelName":"Adamo Hotel","HotelNameEn":"Adamo Hotel","MinPrice":49689000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":null,"Fax":null,"Address":"4 P. Kakabadze Str., Mtatsminda , 0105 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6995811462,"longitude":44.7894897461}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/974145.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"446619"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12186217","HotelCode":"273741","SourceId":12,"HotelName":"The Terrace Boutique Hotel","HotelNameEn":"The Terrace Boutique Hotel","MinPrice":50057000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Polikarpe Kakabadze Street 7 , Mtatsminda , 0105 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6983146667,"longitude":44.7908477783}},"Facilities":[{"name_en":"Car Park"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/433763.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"186217"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12482708","HotelCode":"578120","SourceId":12,"HotelName":"Best Western Hotel Tbilisi City Center","HotelNameEn":"Best Western Hotel Tbilisi City Center","MinPrice":50302000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":"9.95322E+11","Fax":null,"Address":"92 Barnovi Street Tbilisi, Vake, 0179 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.7071800232,"longitude":44.7761573792}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/884482.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"482708"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12943531","HotelCode":"1124995","SourceId":12,"HotelName":"Moxy Tbilisi","HotelNameEn":"Moxy Tbilisi","MinPrice":51529000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":"9.95323E+11","Fax":null,"Address":"Saarbruecken Square","AddressEn":"","Location":{"latitude":41.7025985718,"longitude":44.804901123}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/716466.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"943531"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"1299648","HotelCode":"186853","SourceId":12,"HotelName":"Holiday Inn Tbilisi","HotelNameEn":"Holiday Inn Tbilisi","MinPrice":52732000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":"995-32-2300099","Fax":null,"Address":"26 May Square 1, Saburtalo, 0171 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.7189826965,"longitude":44.7778663635}},"Facilities":[{"name_en":"Car Park"},{"name_en":"Outdoor Pool(s)"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/243815.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"99648"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12300118","HotelCode":"388056","SourceId":12,"HotelName":"ibis Styles Tbilisi Center","HotelNameEn":"ibis Styles Tbilisi Center","MinPrice":53258608,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":null,"Fax":null,"Address":null,"AddressEn":"","Location":{"latitude":41.6920204163,"longitude":44.8013420105}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://fs.itours.no/images/accommodations/675435/a798342-320x240.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"300118"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12622448","HotelCode":"803535","SourceId":12,"HotelName":"City Avenue","HotelNameEn":"City Avenue","MinPrice":53725984,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":"9.95322E+11","Fax":null,"Address":"Davit Aghmashenebeli","AddressEn":"","Location":{"latitude":41.7137527466,"longitude":44.7938690186}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/594360.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"622448"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12962511","HotelCode":"1144006","SourceId":12,"HotelName":"Lermonts Boutique Hotel Tbilisi Center","HotelNameEn":"Lermonts Boutique Hotel Tbilisi Center","MinPrice":53983000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Mikheil Lermontovi Street","AddressEn":"","Location":{"latitude":41.7010993958,"longitude":44.8018989563}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/1093852.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"962511"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12871051","HotelCode":"1052430","SourceId":12,"HotelName":"Museum Hotel Orbeliani","HotelNameEn":"Museum Hotel Orbeliani","MinPrice":58755840,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Vakhtang Orbeliani Street","AddressEn":"","Location":{"latitude":41.6994819641,"longitude":44.8035774231}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/677994.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"871051"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12181388","HotelCode":"268899","SourceId":12,"HotelName":"Tiflis Palace","HotelNameEn":"Tiflis Palace","MinPrice":60686548,"Currency":null,"HotelType":"","CancelConditions":true,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":"9.95323E+11","Fax":null,"Address":"V. Gorgasali Street 3, 0105 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6885948181,"longitude":44.8114433289}},"Facilities":[{"name_en":"Car Park"},{"name_en":"Indoor Pool"},{"name_en":"Outdoor Pool(s)"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/423479.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"181388"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12551420","HotelCode":"646918","SourceId":12,"HotelName":"Sharden Villa","HotelNameEn":"Sharden Villa","MinPrice":79024000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":"+995322753000,+995322724614,+9","Fax":null,"Address":"Leselidze Avenue 42, 0160 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6902313232,"longitude":44.8084220886}},"Facilities":[{"name_en":"Car Park"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/274698.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"551420"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12194354","HotelCode":"281897","SourceId":12,"HotelName":"Old Tiflis Boutique Hotel","HotelNameEn":"Old Tiflis Boutique Hotel","MinPrice":80969000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":"9.95322E+11","Fax":null,"Address":"3/9 Grishashvili Street, 0105 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.688243866,"longitude":44.811290741}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/450725.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"194354"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"1237154","HotelCode":"124245","SourceId":12,"HotelName":"Sheraton Metechi Palace","HotelNameEn":"Sheraton Metechi Palace","MinPrice":85429656,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":5,"ContactInformation":{"Phone":"99532922246","Fax":null,"Address":"Telavi Street 20, 0103 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6885375977,"longitude":44.8230857849}},"Facilities":[{"name_en":"Car Park"},{"name_en":"Internet access"},{"name_en":"Breakfast Buffet"},{"name_en":"Indoor Pool"},{"name_en":"Outdoor Pool(s)"},{"name_en":"Childrens Pool"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/96975.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"37154"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12789091","HotelCode":"970378","SourceId":12,"HotelName":"Wyndham Grand Tbilisi","HotelNameEn":"Wyndham Grand Tbilisi","MinPrice":85711000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":"9.95322E+11","Fax":null,"Address":"Lado Gudiashvili Street","AddressEn":"","Location":{"latitude":41.6963844299,"longitude":44.801109314}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/1075089.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"789091"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12530962","HotelCode":"626437","SourceId":12,"HotelName":"Marriott Tbilisi","HotelNameEn":"Marriott Tbilisi","MinPrice":111003000,"Currency":null,"HotelType":"","CancelConditions":true,"WebServiceType":"public","HotelStars":5,"ContactInformation":{"Phone":"9.95323E+11","Fax":null,"Address":"Rustaveli Avenue 13 , Mtatsminda , 0108 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6990242004,"longitude":44.7981643677}},"Facilities":[{"name_en":"Car Park"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/96976.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"530962"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12335765","HotelCode":"423812","SourceId":12,"HotelName":"Boutique Hotel Tekla Palace","HotelNameEn":"Boutique Hotel Tekla Palace","MinPrice":111445000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Erekle II square 10, 0105 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6942901611,"longitude":44.8060646057}},"Facilities":[{"name_en":"Car Park"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/748859.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"335765"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12927886","HotelCode":"1109332","SourceId":12,"HotelName":"The Biltmore Hotel Tbilisi","HotelNameEn":"The Biltmore Hotel Tbilisi","MinPrice":111721000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":"9.95323E+11","Fax":null,"Address":"Rustaveli Avenue","AddressEn":"","Location":{"latitude":41.7021026611,"longitude":44.7942733765}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/597590.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"927886"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12475546","HotelCode":"570940","SourceId":12,"HotelName":"Ambassadori Hotel","HotelNameEn":"Ambassadori Hotel","MinPrice":113488000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":4,"ContactInformation":{"Phone":"9.95322E+11","Fax":null,"Address":"Shavteli Street N17, 0105 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.6961021423,"longitude":44.8067512512}},"Facilities":[{"name_en":"Car Park"},{"name_en":"Internet access"}],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/256452.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"475546"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12699926","HotelCode":"881120","SourceId":12,"HotelName":"Rooms Hotel Tbilisi","HotelNameEn":"Rooms Hotel Tbilisi","MinPrice":125395000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":"9.95322E+11","Fax":null,"Address":"Merab Kostava Street","AddressEn":"","Location":{"latitude":41.7057037354,"longitude":44.7875061035}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/946124.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"699926"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12816385","HotelCode":"997705","SourceId":12,"HotelName":"King David Hotel","HotelNameEn":"King David Hotel","MinPrice":317583000,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":"+995322952002,+995322952032","Fax":null,"Address":"Aghmashenebeli Avenue","AddressEn":"","Location":{"latitude":41.7147521973,"longitude":44.7933197021}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/797110.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"816385"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12902759","HotelCode":"1084171","SourceId":12,"HotelName":"Mariam R","HotelNameEn":"Mariam R","MinPrice":475505004,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Gamziri Khandzteli","AddressEn":"","Location":{"latitude":41.691444397,"longitude":44.8061256409}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/1104273.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"902759"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12193573","HotelCode":"281114","SourceId":12,"HotelName":"Darchi Hotel","HotelNameEn":"Darchi Hotel","MinPrice":521764100,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":3,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Marjanishvili Street 42, Chugureti, 0102 Tbilisi, Georgia","AddressEn":"","Location":{"latitude":41.7119941711,"longitude":44.8028411865}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/449145.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"193573"},{"CountryName":"Georgia","CountryNameEn":"","CityName":"Tbilisi","CityNameEn":"","HotelIndex":"12593938","HotelCode":"775000","SourceId":12,"HotelName":"Easy Hotel Tbilisi","HotelNameEn":"Easy Hotel Tbilisi","MinPrice":521764100,"Currency":null,"HotelType":"","CancelConditions":false,"WebServiceType":"public","HotelStars":0,"ContactInformation":{"Phone":null,"Fax":null,"Address":"Amaghleba Street","AddressEn":"","Location":{"latitude":41.6895637512,"longitude":44.7914276123}},"Facilities":[],"Capacity":{"Room":null,"Bed":null,"Floor":null,"Parking":null},"FeaturedPicture":"https://hotel.imt.as/intro/0-200m/985594.jpg","Pictures":[{"full":"https://s360online.iran-tech.com/hotelImages/external/no-photo.jpg","thumbnail":"https://s360online.iran-tech.com/hotelImages/external/no-photo-thumb.jpg","medium":"https://s360online.iran-tech.com/hotelImages/external/no-photo-medium.jpg"}],"CityCode":23962,"IsInternal":false,"index":"593938"}],"Count":72,"History":{"CalendarType":"jalali","City":"tbilisi","Country":"georgia","StartDate":"1402-04-22","EndDate":"1402-04-23","IsInternal":false,"with_foreign":false,"Rooms":[{"Adults":2,"Children":0,"Ages":[]}],"Nationality":"IR","RequestNumber":"14020421112412784130934364"},"Success":true,"StatusCode":200,"Message":"Success"}';
    }
}