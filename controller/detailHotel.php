<?php


class detailHotel extends ApiHotelCore
{
    public $hotelId, $Stars, $cityId, $startDate;

    public $transactions;

    public function __construct()
    {

        parent::__construct();
//        $this->serviceDiscount['api'] = functions::ServiceDiscount($this->counterId, 'PublicLocalHotel');

        $this->transactions = $this->getModel('transactionsModel');
    }

    public function getSearchRoomsExternal($requestNumber = '')
    {

    }

    public function getTemporaryHotelDetails($factor_number = null)
    {

        if (isset($factor_number) && !$factor_number) {
            return false;
        }
        /** @var temporaryHotelLocalModel $temp_model */
        $temp_model = Load::getModel('temporaryHotelLocalModel');
        $hotel_detail = $temp_model->get(['webservice_type', 'is_internal', 'city_id', 'city_name', 'hotel_id', 'hotel_name', 'hotel_address', 'hotel_telNumber', 'hotel_starCode', 'hotel_entryHour', 'hotel_leaveHour', 'hotel_pictures', 'start_date', 'end_date', 'number_night', 'hotel_location', 'extra_hotel_details', 'extra_bed_price', 'child_price', 'room_count', 'extra_bed_count', 'child_count', 'price_current', 'source_id'])
            ->where('factor_number', $factor_number)
            ->groupBy('hotel_id')->find();

        $hotel_detail['hotel_location'] = json_decode($hotel_detail['hotel_location'], true);

        $hotel_detail['extra_hotel_details'] = (isset($hotel_detail['extra_hotel_details']) &&  $hotel_detail['extra_hotel_details'] ) ? json_decode($hotel_detail['extra_hotel_details'], true) : '';
//		$hotel_detail['total_calculated_price'] = $hotel_detail['room_count'] * $hotel_detail['price_current'] + ($hotel_detail['room_count'] * $hotel_detail['extra_bed_count'] * $hotel_detail['extra_bed_price']) + ($hotel_detail['room_count'] * $hotel_detail['child_price'] * $hotel_detail['child_count']);
//
        if(SOFTWARE_LANG != 'fa') {
            $hotel_detail['start_date'] = functions::ConvertToMiladi($hotel_detail['start_date']) ;
            $hotel_detail['end_date'] = functions::ConvertToMiladi($hotel_detail['end_date']) ;
        }
//        if(  $_SERVER['REMOTE_ADDR']=='5.201.144.255'  ) {
//            echo json_encode($hotel_detail);
//            die;
//        }

        return $hotel_detail;
    }

    public function getEachDayHotelPrices($factor_number = null, $room_id = null)
    {

        if (!$factor_number) {
            return false;
        }
        /** @var temporaryHotelLocalModel $temp_model */
        $temp_model = Load::getModel('temporaryHotelLocalModel');
        $days = $temp_model->get()->where('factor_number', $factor_number)->where('room_id', $room_id)->groupBy('room_id,date_current')->all();

        return $days;
    }

    public function getTemporaryRooms($factor_number)
    {
        if (!$factor_number) {
            return false;
        }
        /** @var temporaryHotelLocalModel $temp_model */
        $temp_model = Load::getModel('temporaryHotelLocalModel');
        $rooms = $temp_model->get()->where('factor_number', $factor_number)->groupBy('room_id')->all();

        if ($rooms && $rooms[0]['is_internal'] == '0') {

            return $this->getPassengersDetailHotelExternal($factor_number, $rooms[0]['start_date'], $rooms[0]['number_night'], $rooms[0]['room_id'], $rooms[0]['search_rooms']);
        }
        if( $rooms[0]['is_internal']=='1' &&  ($rooms[0]['source_id'] !='17' && $rooms[0]['source_id'] !='29')){
            foreach ($rooms as $k => $room) {
                $room_details = $temp_model->get()->where('factor_number', $factor_number)->where('room_id'  ,$room['room_id'] )->all();
                $total_adult_room = 0 ;
                $total_extra_room = 0 ;
                $total_child_room = 0 ;
                foreach ($room_details as $j => $detail) {
                    $total_adult_room += $detail['price_current'] ;
                    $total_extra_room += $detail['extra_bed_price'] ;
                    $total_child_room += $detail['child_price'] ;
                }

//          $total_adult = $rooms[$k]['total_prices']['adult'] = ($room['number_night'] * $room['room_count'] * $room['price_current']);
//          $total_extra = $rooms[$k]['total_prices']['extra_bed'] = ($room['number_night'] * $room['room_count'] * $room['extra_bed_count'] * $room['extra_bed_price']);
//          $total_child = $rooms[$k]['total_prices']['child'] = ($room['number_night'] * $room['room_count'] * $room['child_price'] * $room['child_count']);
                $total_adult = $rooms[$k]['total_prices']['adult'] = ($room['room_count'] * $total_adult_room);
                $total_extra = $rooms[$k]['total_prices']['extra_bed'] = ( $room['room_count'] * $room['extra_bed_count'] * $total_extra_room);
                $total_child = $rooms[$k]['total_prices']['child'] = ( $room['room_count'] * $total_child_room * $room['child_count']);

                $rooms[$k]['final_total'] = ($total_adult + $total_extra + $total_child);

            }
        }else{
            $rooms[0]['final_total'] = ($rooms[0]['number_night']  * $rooms[0]['price_current']);
            if($rooms[0]['source_id'] =='29'){
                $flightio_price = $this->getModel('flightioPriceModel');
                $room_details = $flightio_price->get()->where('factor_number', $factor_number)->all();
                foreach ($rooms as $k => $room) {
                    $rooms[$k]['final_detail_price'] =  $room_details[$k]['price_current'];
                }



            }

        }

        return $rooms;
    }

    public function getPassengersDetailHotelExternal($factorNumber, $startDate, $nights, $bookingToken, $Rooms)
    {
        $temp_model = Load::getModel('temporaryHotelLocalModel');
        $temporaryHotel = $temp_model->get()->where('factor_number', $factorNumber)->limit(0,1)->find();


        $allRooms = json_decode($Rooms, true);

        $Model = Load::library('Model');
        $result = [];
        $bookingToken = explode(",", $bookingToken);


//				echo var_dump($allRooms);exit();

        for ($c = 0; $c < count($allRooms); $c++) {
            $RoomType = explode("-", $bookingToken[0]);
            $price_current = 0;
            $price_foreign_current = 0;
            $price_online_current = 0;
            $price_board_current = 0;
            $agency_commission = 0;
            $price = 0;
            $thisRoomAdultsCount = $allRooms[$c]['Adults'];
            $thisRoomChildrenCount = $allRooms[$c]['Children'];

            for ($n = 0; $n < $nights; $n++) {
                $sDate_miladi = $startDate  ;
                if (substr($startDate, 0, 4) < 2000) {
                    $sDate_miladi = functions::ConvertToMiladi($startDate);
                }
                $sDate_miladi = str_replace("-", "", $sDate_miladi);
                $Sdate_onreq = date('Ymd', strtotime("" . $sDate_miladi . ",+" . $n . " day"));
                $SDate = functions::ConvertToJalali($Sdate_onreq);
                /** @var temporaryHotelLocalModel $temp_model */


                if($temporaryHotel['source_id'] == '29' && $temporaryHotel['is_internal'] == 1 ) {
                    $room_type_final = $RoomType[0].'_'.$c;
                }else{
                    if($temporaryHotel['source_id'] == '29' && $temporaryHotel['is_internal'] == 0 ) {
                        $room_type_flightio = explode('_' , $RoomType[0]);
                        $room_type_final =$room_type_flightio[0].'_'.$room_type_flightio[1].'_'.$c;
                    }else{
                        $room_type_final = $RoomType[0];
                    }

                }

                $room_type_final = str_replace("'" , ''  ,$room_type_final );
//				echo $temp_model->get()->where('factor_number',$factorNumber)->where('room_id',$RoomType[0])->where('date_current',$SDate)->toSql();
                $temproryHotel = $temp_model->get()->where('factor_number', $factorNumber)
                    ->where('room_id',$room_type_final)->where('date_current', $SDate)->find();


//				$sql_check_temprory = " SELECT * FROM temprory_hotel_local_tb WHERE factor_number ='{$factorNumber}'
//                        AND room_id='{$RoomType[0]}' AND date_current='{$SDate}'; ";
//				functions::insertLog( $sql_check_temprory, 'sql_temp' );
//				$temproryHotel = $Model->load( $sql_check_temprory );
                $price = $temproryHotel['price_current'];




//
//				if ( $temproryHotel['type_of_price_change'] == 'increase' && $temproryHotel['agency_commission_price_type'] == 'cost' ) {
//					$price = $temproryHotel['price_current'] + $temproryHotel['agency_commission'];
////
////				} elseif ( $temproryHotel['type_of_price_change'] == 'decrease' && $temproryHotel['agency_commission_price_type'] == 'cost' ) {
////					$price = $temproryHotel['price_current'] - $temproryHotel['agency_commission'];
////
//				} elseif ( $temproryHotel['type_of_price_change'] == 'increase' && $temproryHotel['agency_commission_price_type'] == 'percent' ) {
//					$price = ( $temproryHotel['price_current'] * $temproryHotel['agency_commission'] / 100 ) + $temproryHotel['price_current'];
//
////				} elseif ( $temproryHotel['type_of_price_change'] == 'decrease' && $temproryHotel['agency_commission_price_type'] == 'percent' ) {
////					$price = ( $temproryHotel['price_current'] * $temproryHotel['agency_commission'] / 100 ) - $temproryHotel['price_current'];
//				} else {
//					$price = $temproryHotel['price_current'] * $temproryHotel['room_count'];
//				}
//
//
//				if ( ! empty( $this->serviceDiscount['api'] ) && $this->serviceDiscount['api']['off_percent'] > 0 ) {
//					$price = $price - ( ( $price * $this->serviceDiscount['api']['off_percent'] ) / 100 );
//				}
//				echo $price;
//				echo '-'.$n;
//				die();

                $price_current += $price;
                $price_online_current += $temproryHotel['price_online_current'];
                $price_board_current += $temproryHotel['price_board_current'];
                $price_foreign_current += $temproryHotel['price_foreign_current'];
                $agency_commission += $temproryHotel['agency_commission'];


                if ($n == 0) {
                    $result[$c] = $temproryHotel;

                    if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' || substr($startDate, 0, 4) < 2000) {

                        $result[$c]['start_date'] = functions::ConvertToMiladi($temproryHotel['start_date']);
                        $result[$c]['end_date'] = functions::ConvertToMiladi($temproryHotel['end_date']);
                        $result[$c]['sd'] = $temproryHotel['start_date'];
                        $result[$c]['ed'] = $temproryHotel['end_date'];
                    }
                }
//				echo '<code>'. json_encode($result).'</code>';
            }

            if($temporaryHotel['source_id'] == '29') {

                $result[$c]['price_current'] = $price_current;
            }

            $result[$c]['AdultsCount'] = $thisRoomAdultsCount;
            $result[$c]['RoomIndex'] = $c;
            $result[$c]['ChildCount'] = $thisRoomChildrenCount;
            $result[$c]['price'] = $price;
            $result[$c]['room_price_current'] = $price_current;
            $result[$c]['room_price_online_current'] = $price_online_current;
            $result[$c]['room_price_board_current'] = $price_board_current;
            $result[$c]['room_price_foreign_current'] = $price_foreign_current;
            $result[$c]['room_agency_commission'] = $agency_commission;

        }

        functions::insertLog(json_encode($result, 256 | 64), 'passengersDetail');

        return $result;

    }

    /**
     * @param $param
     *
     * @return string
     */
    public function Detail($param)
    {

        /** @var Model $model */
        $admin = Load::controller('admin');
        $currency_controller = Load::controller('currency');
        $apiHotel = json_decode(parent::Detail($param), true);

        if (!isset($apiHotel['Result'])) {
            return $this->showError($apiHotel, $apiHotel['StatusCode']);
        }

        $this->hotelId = $param['hotelIndex'];
        $this->Stars = isset( $apiHotel['Result']['Stars'] ) && $apiHotel['Result']['Stars']  ? $apiHotel['Result']['Stars']  : 0;
        $cityName = isset( $apiHotel['Result']['City']  )  && $apiHotel['Result']['City']  ? $apiHotel['Result']['City'] :  '';

        if (isset($apiHotel['History']) && !$apiHotel['History']['IsInternal']) {
            $apiHotel['History']['IsInternal'] = 0 ;
            $cityNameExternal = self::FindExternalCity($apiHotel['History']['Country'], $apiHotel['History']['City']);
            unset($cityNameExternal['id'], $cityNameExternal['place_id'], $cityNameExternal['airport_en'], $cityNameExternal['airport_fa']);
            $apiHotel['Result']['ExternalCity'] = $cityNameExternal;
        }
        if(isset($apiHotel['History']) &&$apiHotel['History']['IsInternal'] && isset($apiHotel['History']['City']) ) {
            $apiHotel['History']['IsInternal'] = 1 ;
            $internal_city = self::FindInternalCity($apiHotel['History']['City']);

            $apiHotel['Result']['CityId'] = $internal_city['id'];
        }

        $currency_title = functions::infoCurrencyBySessionCode(Session::getCurrency()) ;

        $apiHotel['Result']['CurrencyCode'] = Session::getCurrency();
        $apiHotel['Result']['CurrencyTitle'] = $currency_title['CurrencyTitleEn'];


        if (isset($apiHotel['Result']['Facilities']['Hotel']['Fa']['Base']) && is_array($apiHotel['Result']['Facilities']['Hotel']['Fa']['Base'])) {
            $facilities_base = $apiHotel['Result']['Facilities']['Hotel']['En']['Base'];
            if (SOFTWARE_LANG == 'fa') {
                $facilities_base = $apiHotel['Result']['Facilities']['Hotel']['Fa']['Base'];
            }
            foreach ($facilities_base as $key => $val) {
                $val = str_replace("'", "\'", $val);

                $sql = "SELECT * FROM hotel_facilities_tb WHERE services='Hotel' AND title='$val';";
                $HotelFacility = $this->modelBase->load($sql);
                if (!empty($HotelFacility)) {
                    $apiHotel['Result']['Facilities']['HotelWithIcons'][] = [$HotelFacility['title'], $HotelFacility['icon_class']];
                } else {
                    $apiHotel['Result']['Facilities']['HotelWithIcons'][] = [$val, 'fas fa-check'];
                }
            }
        }

        if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar') {
            $apiHotel['History']['StartDate'] = functions::ConvertToMiladi($apiHotel['History']['StartDate']);
            $apiHotel['History']['EndDate'] = functions::ConvertToMiladi($apiHotel['History']['EndDate']);
        }

        if (isset($apiHotel['Result']['Facilities']['Room']['Fa']['Base']) && is_array($apiHotel['Result']['Facilities']['Room']['Fa']['Base'])) {
            foreach ($apiHotel['Result']['Facilities']['Room']['Fa']['Base'] as $key => $val) {
                $sql = "SELECT * FROM hotel_facilities_tb WHERE services='Room' AND title='{$val}';";
                $HotelFacility = $this->modelBase->load($sql);
                if (!empty($HotelFacility)) {
                    $apiHotel['Result']['Facilities']['RoomWithIcons'][] = [$HotelFacility['title'], $HotelFacility['icon_class']];
                }
            }
        }


        if ($apiHotel['Result']['SourceId'] == 42) {

            // -----------------------
            // کوئری اول: اطلاعات هتل (Rules, Cancellation, Child, id)
            // -----------------------
            $sqlHotel = "SELECT id, rules, cancellation_conditions,
       child_conditions , comment , longitude ,
       latitude , address , tel_number , tel_number,
       entry_hour, leave_hour
                 FROM reservation_hotel_tb 
                 WHERE sepehr_hotel_code='" . $apiHotel['Result']['HotelIndex'] . "' 
                 LIMIT 1";
            $localHotelResult = $this->model->select($sqlHotel);
            $localHotel = isset($localHotelResult[0]) ? $localHotelResult[0] : array();


            // -----------------------
            // Generals
            // -----------------------
            if (
                isset($apiHotel['Result']['ExtraData']['Description']) &&
                ($apiHotel['Result']['ExtraData']['Description'] === "" || $apiHotel['Result']['ExtraData']['Description'] === null)
            ) {
                $apiHotel['Result']['ExtraData']['Description'] = $localHotel['comment'];
            }
            if (
                isset($apiHotel['Result']['ContactInformation']['Location']) &&
                ($apiHotel['Result']['ContactInformation']['Location']['longitude'] == "" || $apiHotel['Result']['ContactInformation']['Location']['longitude'] == null)
            ) {
                $apiHotel['Result']['ContactInformation']['Location']['longitude'] = $localHotel['longitude'];
            }
            if (
                isset($apiHotel['Result']['ContactInformation']['Location']) &&
                ($apiHotel['Result']['ContactInformation']['Location']['latitude'] === "" || $apiHotel['Result']['ContactInformation']['Location']['latitude'] == null)
            ) {
                $apiHotel['Result']['ContactInformation']['Location']['latitude'] = $localHotel['latitude'];
            }
            if (
                isset($apiHotel['Result']['ContactInformation']['Address']) &&
                ($apiHotel['Result']['ContactInformation']['Address'] === "" || $apiHotel['Result']['ContactInformation']['Address'] === null)
            ) {
                $apiHotel['Result']['ContactInformation']['Address'] = $localHotel['address'];
            }
            if (
                isset($apiHotel['Result']['ContactInformation']['Phone']) &&
                ($apiHotel['Result']['ContactInformation']['Phone'] === "" || $apiHotel['Result']['ContactInformation']['Phone'] === null)
            ) {
                $apiHotel['Result']['ContactInformation']['Phone'] = $localHotel['tel_number'];
            }


            // -----------------------
            // Facilities
            // -----------------------
            if( empty($apiHotel['Result']['Facilities']['HotelWithIcons']) || $apiHotel['Result']['Facilities']['HotelWithIcons'] == null){
                $query = "
                        SELECT 
                            F.title,
                            F.icon_class
                        FROM 
                            reservation_hotel_facilities_tb RF
                        INNER JOIN 
                            reservation_facilities_tb F ON RF.id_facilities = F.id
                        WHERE 
                            RF.id_hotel = '{$localHotel['id']}'
                            AND RF.is_del = 'no'
                            AND F.is_del = 'no'
                        ORDER BY 
                            F.id ASC
                    ";
                $res = $this->model->select($query);
                $finalFacilities = [];
                foreach ($res as $row) {
                    $finalFacilities[] = [
                        $row['title'],
                        $row['icon_class']
                    ];
                }
                $apiHotel['Result']['Facilities']['HotelWithIcons'] = $finalFacilities;
            }


            // -----------------------
            // Rules
            // -----------------------
            if (!isset($apiHotel['Result']['Rules']) || empty($apiHotel['Result']['Rules'])) {
                $check_in = isset($localHotel['entry_hour']) ? $localHotel['entry_hour'] : '15:00';
                $check_out = isset($localHotel['leave_hour']) ? $localHotel['leave_hour'] : '12:00';
                $checkInOutCondition = "⏰ تحویل اتاق: {$check_in}  •  🕒 تخلیه اتاق: {$check_out}";
                $rulesText = isset($localHotel['rules']) ? $localHotel['rules'] : '';
                $cancellationText = isset($localHotel['cancellation_conditions']) ? $localHotel['cancellation_conditions'] : '';
                $childConditions = isset($localHotel['child_conditions']) ? $localHotel['child_conditions'] : '';

                $apiHotel['Result']['Rules'] = array();
                $apiHotel['Result']['Rules'][] = array(
                    "Name" => "ورود و خروج",
                    "Description" => $checkInOutCondition
                );


                if (!empty($rulesText)) {
                    $apiHotel['Result']['Rules'][] = array(
                        "Name" => "قوانین عمومی",
                        "Description" => $rulesText
                    );
                }

                if (!empty($cancellationText)) {
                    $apiHotel['Result']['Rules'][] = array(
                        "Name" => "کنسلی",
                        "Description" => $cancellationText
                    );
                }

                if (!empty($childConditions)) {
                    $apiHotel['Result']['Rules'][] = array(
                        "Name" => "شرایط کودک",
                        "Description" => $childConditions,
                        "Category" => "children",
                        "Conditions" => array(
                            "max_infant_age" => 5, // مثال
                            "max_child_age" => 12   // مثال
                        )
                    );
                }
            }

            // -----------------------
            // Pictures
            // -----------------------
            $replacePictures = false;
            if (!isset($apiHotel['Result']['Pictures']) ||
                empty($apiHotel['Result']['Pictures']) ||
                $apiHotel['Result']['Pictures'] === null ||
                (isset($apiHotel['Result']['Pictures'][0]['full']) &&
                    strpos($apiHotel['Result']['Pictures'][0]['full'], 'no-photo') !== false)
            ) {
                $replacePictures = true;
            }

            if ($replacePictures && isset($localHotel['id'])) {
                // کوئری دوم: گالری تصاویر
                $sqlGallery = "
                            SELECT pic 
                            FROM reservation_hotel_gallery_tb 
                            WHERE id_hotel = '" . $localHotel['id'] . "'
                              AND is_del = 'no'
                        ";

                $hotelGallery = $this->model->select($sqlGallery);

                $newPictures = array();
                foreach ($hotelGallery as $row) {
                    if (!empty($row['pic'])) {
                        $localPic = $row['pic'];
                        $fullPath = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . $localPic;
                        $newPictures[] = array(
                            "full" => $fullPath,
                            "medium" => $fullPath,
                            "thumbnail" => $fullPath,
                        );
                    }
                }

                if (!empty($newPictures)) {
                    $apiHotel['Result']['Pictures'] = $newPictures;
                }
            }
        }





        return $this->returnJson($apiHotel);
    }

    public function FindExternalCity($country = '', $city = '')
    {
        /** @var ModelBase $ModelBase */
        $ModelBase = Load::library('ModelBase');
        $sql = "SELECT * FROM external_hotel_city_tb
                  WHERE
                    country_name_en != 'iran'
                    AND (
                    country_name_en = '{$country}'
                    OR country_name_fa = '{$country}')
                    AND (
                    city_name_en = '{$city}'
                    OR city_name_fa = '{$city}'
                    )";
        $city = $ModelBase->load($sql);

        return $city;
    }


    public function FindInternalCity( $city = '')
    {
        /** @var ModelBase $ModelBase */
        $ModelBase = Load::library('ModelBase');
        $sql = "SELECT * FROM hotel_cities_tb
                  WHERE
                    city_name_en = '{$city}'
                    ";

        $city = $ModelBase->load($sql);
        return $city;
    }

    public function DirectDetail($param)
    {

        /** @var Model $model */
        $admin = Load::controller('admin');
        $apiHotel = json_decode(parent::DirectDetail($param), true);
        if (!isset($apiHotel['Result'])) {
            return $this->showError($apiHotel, $apiHotel['StatusCode']);
        }
        $this->hotelId = $param['hotelIndex'];
        $this->Stars = $apiHotel['Result']['Stars'];
        $cityName = $apiHotel['Result']['City'];
        $apiHotel['Result']['CurrencyCode'] = Session::getCurrency();
        if (isset($apiHotel['Result']['Facilities']['Hotel']['Fa']['Base']) && is_array($apiHotel['Result']['Facilities']['Hotel']['Fa']['Base'])) {
            foreach ($apiHotel['Result']['Facilities']['Hotel']['Fa']['Base'] as $key => $val) {
                $sql = "SELECT * FROM hotel_facilities_tb WHERE services='Hotel' AND title='{$val}';";
                $HotelFacility = $this->modelBase->load($sql);
                if (!empty($HotelFacility)) {
                    $apiHotel['Result']['Facilities']['HotelWithIcons'][] = [$HotelFacility['title'], $HotelFacility['icon_class']];
                }
            }
        }
        if (isset($apiHotel['Result']['Facilities']['Room']['Fa']['Base']) && is_array($apiHotel['Result']['Facilities']['Room']['Fa']['Base'])) {
            foreach ($apiHotel['Result']['Facilities']['Room']['Fa']['Base'] as $key => $val) {
                $sql = "SELECT * FROM hotel_facilities_tb WHERE services='Room' AND title='{$val}';";
                $HotelFacility = $this->modelBase->load($sql);
                if (!empty($HotelFacility)) {
                    $apiHotel['Result']['Facilities']['RoomWithIcons'][] = [$HotelFacility['title'], $HotelFacility['icon_class']];
                }
            }
        }

        if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' && $param['StartDate'] > 2000) {
            $apiHotel['History']['StartDate'] = functions::ConvertToMiladi($apiHotel['History']['StartDate']);
            $apiHotel['History']['EndDate'] = functions::ConvertToMiladi($apiHotel['History']['EndDate']);
        }



        return $apiHotel;

    }

    public function getPrices($param){
      
        $checkBool = filter_var($param['check_type_for_price_changes'], FILTER_VALIDATE_BOOLEAN) ;

        $type_application_for_change_price = ($checkBool) ? 'api' : 'externalApi';

        if ($param['typeApplication'] == 'externalApi'  && $param['check_type_for_price_changes']) {

             $sqlCity = "SELECT * FROM `external_hotel_city_tb` WHERE country_name_en='{$param['countryName']}' AND (city_name_fa='{$param['cityName']}' OR city_name_en = '{$param['cityName']}')";
        }else{
            $sqlCity = "SELECT * FROM `hotel_cities_tb` WHERE city_name='{$param['cityName']}' OR city_name_en = '{$param['cityName']}'";
        }


        $getCity = $this->modelBase->load($sqlCity);
        $CityId = $getCity['id'];
        $roomPrices = json_decode(parent::getPrices($param), true);

        functions::insertLog('$roomPrices => '.json_encode($roomPrices),'HOTELLOG');

        if (isset($roomPrices['Result']) && is_array($roomPrices['Result'])) {
            foreach ($roomPrices['Result'] as $key => $room) {
                if (isset($room['Rates'])) {
                    $all_total_prices = array();

                    if ($param['sourceId'] == '18' && $type_application_for_change_price == 'externalApi') {
                        $room['Rates'] = self::calculateTboRoomRates($room['Rates'], $room['Currency']);
                        $roomPrices['Result'][$key]['Rates'] = $room['Rates'];
                    }
                    foreach ($room['Rates'] as $rk => $rate) {

                        $totalCalculatedBoard = 0;
                        $totalCalculatedOnline = 0;
                        $totalAfterChange = 0;


                        foreach ($rate['Prices'] as $p => $price) {
                            if ($param['sourceId'] == '42') {
                                $startDate = $rate['Prices'][0]['Date']; // مثال: 1404-09-12
                                list($jy, $jm, $jd) = explode('-', $startDate);
                                $greg = dateTimeSetting::jalali_to_gregorian($jy, $jm, $jd, '-');
                                $nextGreg = date('Y-m-d', strtotime("$greg +$p day"));
                                list($gy, $gm, $gd) = explode('-', $nextGreg);
                                $newJalali = dateTimeSetting::gregorian_to_jalali($gy, $gm, $gd, '-');
                                $roomPrices['Result'][$key]['Rates'][$rk]['Prices'][$p]['Date'] = $newJalali;
                                $price['Date'] = $newJalali;
                            }

                            $priceChanges = functions::getHotelPriceChange($CityId, $param['stars'], $this->counterId, $price['Date'], $type_application_for_change_price);

                            $calculated = self::calculateRoomPrice($price, $priceChanges, $type_application_for_change_price, $roomPrices['WebServiceType']);

//                            $calculated = functions::calculateHotelPrice($priceChanges,$this->serviceDiscount['api'],['price'=>$price]);
                            functions::insertLog('$roomPrices => ' . json_encode($calculated), 'HOTELLOG');

                            if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar') {
                                $roomPrices['Result'][$key]['Rates'][$rk]['Prices'][$p]['Date'] = functions::ConvertToMiladi($price['Date']);
                            }
//                            echo json_encode($calculated);die();

                            $totalCalculatedBoard = $totalCalculatedBoard + $calculated['Board'];
                            $totalCalculatedOnline = $totalCalculatedOnline + $calculated['Online'];


                            $price_currency = functions::CurrencyCalculate($calculated['Online']);
                            $price_currency_change = functions::CurrencyCalculate($calculated['afterChange']);

                            $totalAfterChange += $calculated['afterChange'];
                            $roomPrices['Result'][$key]['Rates'][$rk]['Prices'][$p]['CalculatedBoard'] = $calculated['Board'];
                            $roomPrices['Result'][$key]['Rates'][$rk]['Prices'][$p]['CalculatedOnline'] = round($price_currency['AmountCurrency'],2);
                            $roomPrices['Result'][$key]['Rates'][$rk]['Prices'][$p]['CalculatedOnlineBefore'] = $calculated['Online'];
                            $roomPrices['Result'][$key]['Rates'][$rk]['Prices'][$p]['afterChange'] = round($price_currency_change['AmountCurrency'],2);
                            $roomPrices['Result'][$key]['Rates'][$rk]['Prices'][$p]['currency'] = $price_currency['TypeCurrency'];
                            $roomPrices['Result'][$key]['Rates'][$rk]['CalculatedDiscount'] = $calculated['Discount'];
                            $roomPrices['Result'][$key]['Rates'][$rk]['calc'] = $calculated;

                        }

                        if($param['sourceId'] == '29'){

                            $rate['SinglePrice']['ExtraBed'] = 0;
                            $rate['SinglePrice']['Child'] = 0;

                            $priceChanges = functions::getHotelPriceChange($CityId, $param['stars'], $this->counterId, $rate['Prices'][0]['Date'], $type_application_for_change_price);

                            $calculated = self::calculateRoomPrice($rate['SinglePrice'], $priceChanges, $type_application_for_change_price, $roomPrices['WebServiceType']);

                            functions::insertLog('flightio each room price => ' . json_encode($calculated), 'HOTELLOG');
                            $price_currency = functions::CurrencyCalculate($calculated['Online']);
                            $price_currency_change = functions::CurrencyCalculate($calculated['afterChange']);
                            $roomPrices['Result'][$key]['Rates'][$rk]['SinglePrice']['CalculatedBoard'] = $calculated['Board'];
                            $roomPrices['Result'][$key]['Rates'][$rk]['SinglePrice']['CalculatedOnline'] = round($price_currency['AmountCurrency'],2);
                            $roomPrices['Result'][$key]['Rates'][$rk]['SinglePrice']['afterChange'] = round($price_currency_change['AmountCurrency'] , 2);
                            $roomPrices['Result'][$key]['Rates'][$rk]['SinglePrice']['currency'] = $price_currency['TypeCurrency'];
                        }

//						$calculatedTotal = self::calculateRoomPrice( $rate['TotalPrices'], ($priceChanges *count($rate['Prices'])));

                        $price_currency = functions::CurrencyCalculate($totalCalculatedOnline);

                        $price_currency_change = functions::CurrencyCalculate($totalAfterChange);
                        $roomPrices['Result'][$key]['Rates'][$rk]['TotalPrices']['CalculatedBoard'] = $totalCalculatedBoard;
                        $roomPrices['Result'][$key]['Rates'][$rk]['TotalPrices']['CalculatedOnline'] = round($price_currency['AmountCurrency'] , 2);
                        $roomPrices['Result'][$key]['Rates'][$rk]['TotalPrices']['afterChange'] = round($price_currency_change['AmountCurrency'] , 2);
                        $roomPrices['Result'][$key]['Rates'][$rk]['TotalPrices']['currency'] = $price_currency['TypeCurrency'];
                        $all_total_prices[] = $totalCalculatedOnline;
                    }
                    array_multisort($all_total_prices, SORT_ASC, $roomPrices['Result'][$key]['Rates']);
                }
            }
        }

        $roomPrices['Discount'] = $this->serviceDiscount;

        return $this->returnJson($roomPrices);
    }

    private function calculateRoomPrice($price = [], $priceChanges = [],$typeApplication = 'api',$webservice_type = 'public')
    {

        if ($price['Board'] != 0) {
            $service_title = functions::TypeServiceHotel($typeApplication,null,$webservice_type);

            $this->serviceDiscount['api'] = functions::ServiceDiscount($this->counterId,$service_title);
            $priceBoardChange1 = functions::calculateHotelPrice($priceChanges, $this->serviceDiscount['api'], $price['Board'], true);
            $priceOnlineAfterChange = functions::calculateHotelPrice($priceChanges, $this->serviceDiscount['api'], $price['Online']);
            $priceOnlineChange = functions::calculateHotelPrice($priceChanges, $this->serviceDiscount['api'], $price['Online'], true);
            $priceChildChange = functions::calculateHotelPrice($priceChanges, $this->serviceDiscount['api'], $price['Child'], true);
            $priceExtraBedChange = functions::calculateHotelPrice($priceChanges, $this->serviceDiscount['api'], $price['ExtraBed'], true);
        } else {
            $priceBoardChange = $price['Board'];
            $priceOnlineChange = $price['Online'];
            $priceChildChange = $price['Child'];
            $priceExtraBedChange = $price['ExtraBed'];
        }


        return [
            'Discount' => $this->serviceDiscount['api'],
            'afterChange' => round($priceOnlineAfterChange['price_with_increase_change']),
            'Board' => $priceBoardChange1,
            'Online' => round($priceOnlineChange),
            'Child' => round($priceChildChange),
            'ExtraBed' => round($priceExtraBedChange)
        ];
    }

    //change tbo prices
    private function calculateTboRoomRates($rates , $currency){

        foreach ($rates as $rk => $rate) {
            foreach ($rate['ReservationState']['Fees'] as $f => $fee) {
                $rate['ReservationState']['Fees'][$f]['Price'] = $this->getController('currencyEquivalent')->calculateEquivalent($currency  ,$fee['Price']) ;
            }
            $rate['TotalPrices']['Board'] = $this->getController('currencyEquivalent')->calculateEquivalent($currency  ,$rate['TotalPrices']['Board']) ;
            $rate['TotalPrices']['Online'] = $this->getController('currencyEquivalent')->calculateEquivalent($currency  ,$rate['TotalPrices']['Online']) ;
            $rate['TotalPrices']['ExtraBed'] = $this->getController('currencyEquivalent')->calculateEquivalent($currency  ,$rate['TotalPrices']['ExtraBed']) ;
            $rate['TotalPrices']['Child'] = $this->getController('currencyEquivalent')->calculateEquivalent($currency  ,$rate['TotalPrices']['Child']) ;

            foreach ($rate['Prices'] as $p => $price) {
                $rate['Prices'][$p]['Board'] = $this->getController('currencyEquivalent')->calculateEquivalent($currency  ,$price['Board']) ;
                $rate['Prices'][$p]['Online'] = $this->getController('currencyEquivalent')->calculateEquivalent($currency  ,$price['Online']) ;
                $rate['Prices'][$p]['ExtraBed'] = $this->getController('currencyEquivalent')->calculateEquivalent($currency  ,$price['ExtraBed']) ;
                $rate['Prices'][$p]['Child'] = $this->getController('currencyEquivalent')->calculateEquivalent($currency  ,$price['Child']) ;
            }
            $rates[$rk] = $rate;
        }

        return $rates ;
    }

    public function getCancellationPolicy($param = [])
    {
        if (!isset($param['RequestNumber']) && !isset($param['RoomToken'])) {
            return $this->returnJson(['error' => 'Wrong request data', 'message' => 'RequestNumber or RoomToken not set']);
        }
        $getCancellationPolicy = json_decode(parent::getCancellationPolicy($param));

        return $this->returnJson($getCancellationPolicy);

    }

    public function insertTemporaryHotel($param)
    {

//      echo json_encode($param,256|64);die();
        $allPrices =json_decode($param['Prices'],true);

//        echo json_encode($allPrices);die();
//        if(  $_SERVER['REMOTE_ADDR']=='5.201.144.255'  ) {
//
//                        echo json_encode($param,256|64);
//            die;
//        }
        $hotelDetail = json_decode($param['HotelDetail'], true);

        $param['Prices'] = $allPrices;
        $param['HotelDetail'] = $hotelDetail;
        functions::insertLog('params for temporary hotel ' . json_encode($param, 256 | 64), 'hotelTemp');

        functions::insertLog(json_encode($allPrices, 256 | 64), 'hotelTemp');
        functions::insertLog(json_encode($hotelDetail, 256 | 64), 'hotelTemp');

        $ResultCityName = $hotelDetail['Result']['City'];
        $source_id = $hotelDetail['Result']['SourceId'];


        $allRooms = $hotelDetail['History']['Rooms'] ? $hotelDetail['History']['Rooms']:  '';
        $search_rooms = json_encode($allRooms);

//        $sqlCity      = "SELECT * FROM `hotel_cities_tb` WHERE city_name='{$ResultCityId}' OR city_name_en = '{$ResultCityId}';";
        $type_application =   (isset($param['TypeApplication']) && $param['TypeApplication']) ? $param['TypeApplication'] : '';

        if (($type_application == 'externalApi' && $param['IsInternal'] != '1') ||
            ($param['IsInternal'] == '1' && ($hotelDetail['Result']['SourceId'] != '17'))) {

            $cities_model = Load::getModel('externalHotelCityModel');
            $getCity = $cities_model->get()->where('city_name_fa', $ResultCityName)->orWhere('city_name_en', $ResultCityName)->find();
            $getCity['city_name'] = $getCity['city_name_en'];
//            $sqlCity      = "SELECT * FROM `external_hotel_city_tb` WHERE city_name_fa='{$ResultCityId}' AS city_name OR city_name_en = '{$ResultCityId}';";
        } else {


            $cities_model = Load::getModel('hotelCitiesModel');
            $getCity = $cities_model->get()->where('city_name', $ResultCityName)->orWhere('city_name_en', $ResultCityName)->find();
        }

//        $getCity      = $this->modelBase->load( $sqlCity );

        $CityId = $getCity['id'] ? $getCity['id']: '';
        $CityName = $getCity['city_name'] ? $getCity['city_name']: '';

        $i = 0;

        $prices = array();
        $eachRoomPrices = array();

        foreach ($allPrices as $key => $room) {

            foreach ($room['Rates'] as $counter => $rate) {
                if($source_id == '29') {
                    $room_name = explode('|' , $room['RoomName']);
                }

                foreach ($rate['Prices'] as $k => $priceItem) {

                    $RoomName = isset($rate['Board']['Name']) ? $room['RoomName'] . ' ' . $rate['Board']['Name'] : $room['RoomName'];
                    if($source_id == '29') {
                        $RoomName = $room_name[$counter] ;
                        $roomIndex = $rate['RoomToken'].'_'.$counter ;
                    }else{
                        $roomIndex = $rate['RoomToken'] ;
                    }
                    $priceItem['StartDate'] = $param['SDate'];
                    $priceItem['EndDate'] = $param['EDate'];

                    if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' && $priceItem['Date'] > 2000) {
                        $priceItem['Date'] = functions::ConvertToJalali($priceItem['Date']);
                        $priceItem['StartDate'] = functions::ConvertToJalali($param['SDate']);
                        $priceItem['EndDate'] = functions::ConvertToJalali($param['EDate']);
                    }
                    $prices[$i]['HotelIndex'] = $hotelDetail['Result']['HotelIndex'];
                    $prices[$i]['RoomIndex'] = $roomIndex;
//                    $prices[$i]['RoomName'] = $RoomName;
                    $prices[$i]['RoomName'] =  $this->sanitizeUnicode($RoomName);

                    $prices[$i]['ReservationState'] = $rate['ReservationState'];
                    $prices[$i]['Date'] = $priceItem['Date'];
                    $prices[$i]['Board'] = $priceItem['Board'];
                    $prices[$i]['CalculatedBoard'] = $priceItem['CalculatedBoard'];
                    $prices[$i]['Online'] = $priceItem['Online'];
                    $prices[$i]['CalculatedOnline'] = $priceItem['CalculatedOnline'];
                    $prices[$i]['PriceChild'] = $priceItem['Child'];
                    $prices[$i]['PriceExtraBed'] = $priceItem['ExtraBed'];
                    $prices[$i]['StartDate'] = $priceItem['StartDate'];
                    $prices[$i]['EndDate'] = $priceItem['EndDate'];

                    $i++;
                }

                if($hotelDetail['Result']['SourceId'] == '29') {
                    $room_name = explode('|' , $room['RoomName']);
                    $RoomName = $room_name[$counter] ;
                    $roomIndex = $rate['RoomToken'].'_'.$counter ;

                    $eachRoomPrices[$key]['RoomIndex'] = $rate['RoomToken'];
                    $eachRoomPrices[$key][$counter] = $rate['SinglePrice'];
                    $eachRoomPrices[$key][$counter]['RoomIndex'] =  $roomIndex;
                    $eachRoomPrices[$key][$counter]['RoomName'] = $RoomName;

                }
            }
        }

        $roomSelected = array();
        $webservice_type = $param['HotelDetail']['WebServiceType'] ? $param['HotelDetail']['WebServiceType'] : ($param['HotelDetail']['Result']['WebServiceType'] ? $param['HotelDetail']['Result']['WebServiceType'] : '');

        if($param['IsInternal'] == 1 && $type_application == 'externalApi'){
            $service_title = functions::TypeServiceHotel('api',null,$webservice_type);
        }else{
            $service_title = functions::TypeServiceHotel($type_application,null,$webservice_type);
        }

//        if($webservice_type == 'public'){
//            if($type_application == 'api'){
//                $service_title = 'PublicLocalHotel';
//            }elseif($type_application == 'externalApi'){
//                $service_title = 'PublicPortalHotel';
//            }
//        }elseif($webservice_type == 'private'){
//            if($type_application == 'api'){
//                $service_title = 'PrivateLocalHotel';
//            }elseif($type_application == 'externalApi'){
//                $service_title = 'PrivatePortalHotel';
//            }
//        }

        functions::insertLog('service_title ' . serialize($service_title), 'hotelTemp');
        functions::insertLog('IsInternal ' . serialize($param['IsInternal']), 'hotelTemp');
        $this->serviceDiscount['api'] = functions::ServiceDiscount($this->counterId,$service_title);



        if ($param['IsInternal'] && $param['IsInternal'] != '0' && $param['IsInternal'] != 'false'
            && ($source_id != '17') && ($source_id != '29')) {


            $expRooms = explode(',', $param['TotalNumberRoom_Reserve']);
            $expExtra = explode(',', $param['TotalNumberExtraBed_Reserve']);

            foreach ($expRooms as $rk => $ri) {

                if (!empty($ri)) {
                    $Index = 0;
                    $explode = explode('-', $ri);

                    foreach ($prices as $k => $priceItem) {

                        $ChildArr = [];
                        $ChildCount = 0;

                        if ($priceItem['RoomIndex'] == $explode[0]) {


                            if (isset($param['roomChildArr']) && is_array($param['roomChildArr'])) {
                                $roomChildArr = $param['roomChildArr'];
                                $ChildArr = [];
                                $ChildCount = 0;
                                foreach ($roomChildArr[$explode[0]] as $key => $childArray) {
                                    $ChildArr[] = $childArray['arr'];
                                    $ChildCount += $childArray['count'];
                                }
                            }
                            $exCount = 0;
                            foreach ($expExtra as $ebk => $ebi) {
                                $ExExtra = explode('-', $ebi);
                                if ($explode[0] == $ExExtra[0]) {
                                    $exCount = $ExExtra[1];
                                } else {
                                    continue;
                                }
                            }

                            $prices[$k]['Index'] = $Index;
                            $prices[$k]['Count'] = $explode[1];
                            $prices[$k]['ExCount'] = $exCount;
                            $prices[$k]['ChildCount'] = $ChildCount;
                            $prices[$k]['ChildArr'] = $ChildArr;


                            $roomSelected[] = $prices[$k];
                            $Index++;
                        }
                    }


                }

            }

        }
        else {


            $explode = explode('-', $param['TotalNumberRoom_Reserve']);

//            			echo Load::plog($allRooms);exit();

            //			$requestedRooms = functions::numberOfRoomsExternalHotelRequested( $selectedRooms['rooms'] );
            //			$roomCount = $selectedRooms['adultCount'] + $selectedRooms['childrenCount'];
            //			return json_encode($requestedRooms);
            //			foreach ( $selectedRooms as $roomKey => $room ) {

            $roomIndex = 0;
            $final_each_room = array();
            foreach ($allRooms as $roomKey => $roomItem) {

                for ($AdultCount = 0; $AdultCount < $roomItem['Adults']; $AdultCount++) {

                    foreach ($prices as $k => $priceItem) {

                        if($source_id == '29') {
                            $flightio_room_index = explode('_', $priceItem['RoomIndex']);
                            $final_room_index = $flightio_room_index[0].'_'.$flightio_room_index[1];
                        }else{
                            $final_room_index = $priceItem['RoomIndex'];
                        }
                        $room_reserve_select   = str_replace("'" , "" , $explode[0] );

                        if ($final_room_index == $room_reserve_select) {

                            $roomIndex++;

                            $prices[$k]['Index'] = $roomKey;
                            $prices[$k]['Count'] = $explode[1];
                            $prices[$k]['ExCount'] = 0;
                            $prices[$k]['ChildCount'] = 0;
                            $prices[$k]['ChildArr'] = [];
                            $roomSelected[] = $prices[$k];

                        }
                    }
                }

                for ($ChildCount = 0; $ChildCount < $roomItem['Children']; $ChildCount++) {
                    foreach ($prices as $k => $priceItem) {


                        if ($priceItem['RoomIndex'] == $explode[0]) {
                            $roomIndex++;

                            $prices[$k]['Index'] = $roomKey;
                            $prices[$k]['Count'] = $explode[1];
                            $prices[$k]['ExCount'] = 0;
                            $prices[$k]['ChildCount'] = 0;
                            $prices[$k]['ChildArr'] = [];
                            $roomSelected[] = $prices[$k];
                        }
                    }
                }
            }


            if($hotelDetail['Result']['SourceId'] == '29') {
                foreach ($eachRoomPrices as $roomKey => $roomItem){

                    $room_reserve_select   = str_replace("'" , "" , $explode[0] );
                    $flightio_room_index = explode('_', $roomItem['RoomIndex']);
                    $final_room_index = $flightio_room_index[0].'_'.$flightio_room_index[1];

                    if ($final_room_index == $room_reserve_select) {
                        $final_each_room = $roomItem;
                    }
                }

            }
            $count_room_external = count($param['HotelDetail']['History']['Rooms']);
            functions::insertLog('this only external and parto internal 0000==>'. $count_room_external,'Hotels/valiagepeydakonam');

        }

        functions::insertLog('$roomSelected'.json_encode($roomSelected,256),'HOTELLOG');
        $factorNumber = (isset($param['factorNumber']) && !empty($param['factorNumber'])) ? $param['factorNumber'] : self::generateFactorNumber();

        $res = false;



        for ($room = 0; $room < count($roomSelected); $room++) {
//            functions::insertLog('this only external and parto internal ==>'.$room.'==>'. $count_room_external,'Hotels/valiagepeydakonam');
            $count =(($param['IsInternal'] && $source_id != '17')  || ($param['IsInternal'] && $source_id != '29'))?  $roomSelected[$room]['Count'] : $count_room_external;

            $extraBedCount = $roomSelected[$room]['ExCount'];
            $extraBedPrice = $roomSelected[$room]['PriceExtraBed'];
            $childPrice = $roomSelected[$room]['PriceChild'];
            $CountChild = $roomSelected[$room]['ChildCount'];
            $childArray = $roomSelected[$room]['ChildArr'];
            if (isset($childArray[0])) {
                $childArray = $childArray[0];
            } else {
                $childArray = "{}";
            }
            if ($this->serviceDiscount['api']['off_percent'] > 0) {
                $d['services_discount'] = $this->serviceDiscount['api']['off_percent'];
            }

            $d['is_internal'] = $param['IsInternal'] ? 1 : 0 ;
            functions::insertLog('IsInternal dd' . $param['IsInternal'], 'hotelTemp');
            $d['source_id'] = $source_id;
            $d['hotel_location'] = json_encode(str_replace("'", "", $hotelDetail['Result']['ContactInformation']['Location']));
            $d['extra_hotel_details'] = json_encode(str_replace("'", "", $hotelDetail['Result']['ExtraData']));
            $d['webservice_type'] = $webservice_type;
            $d['extra_bed_count'] = $extraBedCount;
            $d['extra_bed_price'] = $extraBedPrice;

            //			$roomPrice = $allPrices;
            //			return json_encode($roomPrice[0]);

            $d['factor_number'] = $factorNumber;
            $d['city_id'] = $CityId;// $City['Code'];
            $d['city_name'] = $CityName;//'';//$City['Name'];
            $d['hotel_id'] = $param['IdHotel'];
//            $d['hotel_name'] = str_replace("'", "", $hotelDetail['Result']['Name']);//'';//$Hotel['Name'];
            $d['hotel_name'] = $this->sanitizeUnicode($hotelDetail['Result']['Name']);
//            $d['hotel_name_en'] = isset($hotelDetail['Result']['NameEn']) ? $hotelDetail['Result']['NameEn'] : '';//$Hotel['NameEn'];
            $d['hotel_name_en'] =  $this->sanitizeUnicode($hotelDetail['Result']['NameEn']);
            $d['hotel_address'] = str_replace("'", "", $hotelDetail['Result']['ContactInformation']['Address']);// $Hotel['AddressInfo']['Address'];
            $d['hotel_address_en'] = isset($hotelDetail['Result']['ContactInformation']['AddressEn']) ? str_replace("'", "\'", $hotelDetail['Result']['ContactInformation']['AddressEn']) : '';//$Hotel['AddressInfo']['AddressEn'];
            $d['hotel_telNumber'] = $hotelDetail['Result']['ContactInformation']['Phone'];//$Hotel['TelNumber'];
            $d['hotel_starCode'] = $hotelDetail['Result']['Stars'];//$Hotel['StarCode'];
            $d['hotel_entryHour'] = $hotelDetail['Result']['CheckTimes']['In'];//$Hotel['EntryHour'];
            $d['hotel_leaveHour'] = $hotelDetail['Result']['CheckTimes']['Out'];//$Hotel['LeaveHour'];
//            $default_image = 'http://safar360.com/gds/pic/hotel-nophoto.jpg';
            $default_image = 'http://safar360.chartertech.ir/gds/pic/hotel-nophoto.jpg';
            $d['hotel_pictures'] = $hotelDetail['Result']['Pictures'][0]['full'] ? $hotelDetail['Result']['Pictures'][0]['full']: ($hotelDetail['Result']['Pictures'][0]['thumbnail'] ? $hotelDetail['Result']['Pictures'][0]['thumbnail'] : ($hotelDetail['Result']['Pictures'][0]['medium'] ? $hotelDetail['Result']['Pictures'][0]['medium']  :  $default_image));
            $d['bed_type'] = "main_bed";
            $d['room_id'] = $roomSelected[$room]['RoomIndex'];
            $d['search_rooms'] = $search_rooms;
            $d['room_index'] = $roomSelected[$room]['Index'];
//            $d['room_name'] = $roomSelected[$room]['RoomName'];
            $d['room_name'] = $this->sanitizeUnicode($roomSelected[$room]['RoomName']);
            $d['child_count'] = $CountChild;
            $d['child_price'] = $childPrice;
            $d['child_array'] = $childArray;
            //			$d['room_name_en'] = $roomSelected[$room];
            //			$d['max_capacity_count_room'] = $roomSelected[$room]['MaxCapacity'];
            //			$d['remaining_capacity'] = $item['RemainingCapacity'];

            $d['start_date'] = $roomSelected[$room]['StartDate'];
            $d['end_date'] = $roomSelected[$room]['EndDate'];
            $d['number_night'] = $param['Nights'];

            $d['price_session_id'] = $param['PriceSessionId'];
            $d['date_current'] = $roomSelected[$room]['Date'];
            $price = functions::CurrencyToRial($roomSelected[$room]['CalculatedOnline']);
            $d['price_current'] = round($price['AmountRial']);
            $d['price_Board_current'] = $roomSelected[$room]['Board'];
            $d['price_online_current'] = $roomSelected[$room]['Online'];
//			$d['price_foreign_current'] = $roomSelected[$room]['PriceForeign'];
//			$d['rules'] = $hotelDetail['Result']['CancelConditions'];
            $d['room_count'] = $count;
            $d['agency_commission'] = 0;
            $d['agency_commission_price_type'] = '';
            $d['type_of_price_change'] = '';

            $stars = $hotelDetail['Result']['Stars'] > 0 ? $hotelDetail['Result']['Stars'] : 'all';
            functions::insertLog('dataaaaaa insert temprory agency_commission==>'.  json_encode([$CityId, $stars, $this->counterId, $roomSelected[$room]['Date'], $type_application],256),'Hotels/valiagepeydakonam');

            if($param['IsInternal'] == '1' && ($hotelDetail['Result']['SourceId'] == '17' || $hotelDetail['Result']['SourceId'] == '29') ){
                $type_application = 'api';
            }
            $res_agency_commission = functions::getHotelPriceChange($CityId, $stars, $this->counterId, $roomSelected[$room]['Date'], $type_application);

            functions::insertLog('insert temprory agency_commission==>'.  json_encode($res_agency_commission,256),'Hotels/valiagepeydakonam');

            if ($res_agency_commission) {
                $d['agency_commission'] = $res_agency_commission['price'];
                $d['agency_commission_price_type'] = $res_agency_commission['price_type'];
                $d['type_of_price_change'] = $res_agency_commission['change_type'];
            }

//			$res[] = $d;
            //			echo json_encode($d);exit();
//			$this->model->setTable( 'temprory_hotel_local_tb' );
            $temp = $this->getModel('temporaryHotelLocalModel');
//            functions::insertLog('temp_insert '.json_encode($d,256),'HOTELLOG');

            $res[] = $temp->insertWithBind($d);

            //			$res[] = $d;

        }

        if($hotelDetail['Result']['SourceId'] == '29') {

            $flightio_price_detail_result = $this->storeFlightioRoomPrices($factorNumber ,$final_each_room ) ;
            if (!is_array($flightio_price_detail_result) || !$flightio_price_detail_result) {
                return 'error_NextStepReserveHotel : ' . var_dump($flightio_price_detail_result) . 'ssss' . json_encode($final_each_room);
            }
        }

        if (isset($param['type']) && $param['type'] == 'package') {
            if (!is_array($res) || !$res) {
                $message['Status'] = 'error';
                $message['message'] = 'error_NextStepReserveHotel';

            } else {
                $message['Status'] = 'success';
                $message['message'] = $factorNumber;
            }

            return json_encode($message);
        }
        else {
            if (!is_array($res) || !$res) {
                return 'error_NextStepReserveHotel : ' . var_dump($res, $roomSelected) . 'ssss' . json_encode($prices);
            } else {
                return 'success_NextStepReserveHotel:' . $factorNumber;
            }
        }
    }




    private function sanitizeUnicode($data) {
        // اگر ورودی رشته نباشد، تبدیل به رشته خالی
        if (!is_string($data)) {
            return '';
        }

        // تبدیل به UTF-8 و حذف کاراکترهای نامعتبر
        $data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        $data = iconv('UTF-8', 'UTF-8//IGNORE', $data);

        // جایگزینی کاراکترهای /, +, \ با کاما
        $data = str_replace(['/', '+', '\\'], ',', $data);

        // حذف تگ‌های فونت
        $data = preg_replace('/<font[^>]*>(.*?)<\/font>/ius', '', $data);

        // تبدیل کاراکترهای بولد یونیکد به معادل معمولی
        $boldMap = [
            '𝐀' => 'A', '𝐁' => 'B', '𝐂' => 'C', '𝐃' => 'D', '𝐄' => 'E',
            '𝐅' => 'F', '𝐆' => 'G', '𝐇' => 'H', '𝐈' => 'I', '𝐉' => 'J',
            '𝐊' => 'K', '𝐋' => 'L', '𝐌' => 'M', '𝐍' => 'N', '𝐎' => 'O',
            '𝐏' => 'P', '𝐐' => 'Q', '𝐑' => 'R', '𝐒' => 'S', '𝐓' => 'T',
            '𝐔' => 'U', '𝐕' => 'V', '𝐖' => 'W', '𝐗' => 'X', '𝐘' => 'Y',
            '𝐙' => 'Z',
            '𝐚' => 'a', '𝐛' => 'b', '𝐜' => 'c', '𝐝' => 'd', '𝐞' => 'e',
            '𝐟' => 'f', '𝐠' => 'g', '𝐡' => 'h', '𝐢' => 'i', '𝐣' => 'j',
            '𝐤' => 'k', '𝐥' => 'l', '𝐦' => 'm', '𝐧' => 'n', '𝐨' => 'o',
            '𝐩' => 'p', '𝐪' => 'q', '𝐫' => 'r', '𝐬' => 's', '𝐭' => 't',
            '𝐮' => 'u', '𝐯' => 'v', '𝐰' => 'w', '𝐱' => 'x', '𝐲' => 'y',
            '𝐳' => 'z'
        ];
        $data = strtr($data, $boldMap);

        // حذف کاراکترهای کنترل
        $data = preg_replace('/[\x00-\x1F\x7F]/u', '', $data);

        // نرمال‌سازی فضاهای خالی
        $data = preg_replace('/\s+/u', ' ', $data);
        $data = trim($data);

        // حذف کاماهای تکراری
        $data = preg_replace('/,+/u', ',', $data);
        $data = trim($data, ',');
//        if(  $_SERVER['REMOTE_ADDR']=='5.201.144.255'  ) {
//            var_dump($data);
//            die;
//        }
        return $data;
    }
    private function generateFactorNumber()
    {
        return substr(time(), 0, 5) . mt_rand(000, 999) . substr(time(), 5, 10);
    }

    public function getPassengersDetailHotelLocal($factorNumber, $startDate, $nights, $TotalNumberRoom_Reserve)
    {

        /** @var Model $Model */
        $Model = Load::library('Model');

        $result = [];
        $TotalNumberRoom = explode(",", $TotalNumberRoom_Reserve);

        for ($c = 0; $c < count($TotalNumberRoom); $c++) {
            $RoomType = explode("-", $TotalNumberRoom[$c]);
            $price_current = 0;
            $price_foreign_current = 0;
            $price_online_current = 0;
            $price_board_current = 0;
            $agency_commission = 0;
            $price = 0;
            $price_array = array();
            $price_change_params = array();
            for ($n = 0; $n < $nights; $n++) {
                $year = explode('-', $startDate)[0];
                $sDate_miladi = functions::ConvertToMiladi($startDate);
                $sDate_miladi = str_replace("-", "", $sDate_miladi);
                if (SOFTWARE_LANG != 'fa' && $year > 2000) {
                    $sDate_miladi = date('Ymd', strtotime($startDate));
                }
                $Sdate_onreq = date('Ymd', strtotime("" . $sDate_miladi . ",+" . $n . " day"));
                $SDate = functions::ConvertToJalali($Sdate_onreq);

                $sql_check_temprory = " SELECT * FROM temprory_hotel_local_tb WHERE factor_number ='{$factorNumber}' AND room_id='{$RoomType[0]}' AND date_current='{$SDate}' ";
//				functions::insertLog( $sql_check_temprory, 'sql_temp' );
                $temproryHotel = $Model->load($sql_check_temprory, 'assoc');
//                if(  $_SERVER['REMOTE_ADDR']=='5.201.144.255'  ) {
//                    echo $sql_check_temprory;
////            echo json_encode($temproryHotel);
////                    var_dump($factorNumber, $startDate, $nights, $TotalNumberRoom_Reserve);
//                    die;
//                }

                $service_discount = $this->serviceDiscount['api'];
                $base_price = $temproryHotel['price_current'];
//                $type_application = $temproryHotel['is_internal'] ? 'api' : 'externalApi';
//                $price_change_params = array($temproryHotel['city_id'], $temproryHotel['hotel_starCode'], $this->counterId, $SDate,$type_application );
//                $priceChanges = functions::getHotelPriceChange( $temproryHotel['city_id'], $temproryHotel['hotel_starCode'], $this->counterId, $SDate,$type_application );


//                $price_array = functions::calculateHotelPrice($priceChanges,$service_discount,$base_price);
                $price = $temproryHotel['price_current'];

//				if ( $temproryHotel['type_of_price_change'] == 'increase' && $temproryHotel['agency_commission_price_type'] == 'cost' ) {
//					$price = $temproryHotel['price_current'] + $temproryHotel['agency_commission'];
//
//				} elseif ( $temproryHotel['type_of_price_change'] == 'decrease' && $temproryHotel['agency_commission_price_type'] == 'cost' ) {
//					$price = $temproryHotel['price_current'] - $temproryHotel['agency_commission'];
//
//				} elseif ( $temproryHotel['type_of_price_change'] == 'increase' && $temproryHotel['agency_commission_price_type'] == 'percent' ) {
//					$price = ( $temproryHotel['price_current'] * $temproryHotel['agency_commission'] / 100 ) + $temproryHotel['price_current'];
//
//				} elseif ( $temproryHotel['type_of_price_change'] == 'decrease' && $temproryHotel['agency_commission_price_type'] == 'percent' ) {
//					$price = ( $temproryHotel['price_current'] * $temproryHotel['agency_commission'] / 100 ) - $temproryHotel['price_current'];
//
//				} else {
//					$price = $temproryHotel['price_current'] * $temproryHotel['room_count'];
//				}
//
//				if ( ! empty( $this->serviceDiscount['api'] ) && $this->serviceDiscount['api']['off_percent'] > 0 ) {
//					$price = $price - ( ( $price * $this->serviceDiscount['api']['off_percent'] ) / 100 );
//				}

                $price_current += $price;
                $price_online_current += $temproryHotel['price_online_current'];
                $price_board_current += $temproryHotel['price_board_current'];
                $price_foreign_current += $temproryHotel['price_foreign_current'];
                $agency_commission += $temproryHotel['agency_commission'];

                if ($n == 0) {
                    $result[$c] = $temproryHotel;
                    if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' || substr($startDate, "0", "4") > 2000) {
                        $result[$c]['start_date'] = functions::ConvertToMiladi($temproryHotel['start_date']);
                        $result[$c]['end_date'] = functions::ConvertToMiladi($temproryHotel['end_date']);
                    }
                }

            }

            $result[$c]['count'] = $temproryHotel['room_count'];
            $result[$c]['price'] = $price;
//            $result[$c]['price_array'] = $price_array;
//            $result[$c]['price_change_params'] = $price_change_params;
            $result[$c]['room_price_current'] = $price_current;
            $result[$c]['room_price_online_current'] = $price_online_current;
            $result[$c]['room_price_board_current'] = $price_board_current;
            $result[$c]['room_price_foreign_current'] = $price_foreign_current;
            $result[$c]['room_agency_commission'] = $agency_commission;


        }

        functions::insertLog(json_encode($result, 256 | 64), 'passengersDetail');

        return $result;

    }

    public function CounterRoomReserve($idRoom)
    {
        functions::insertLog('POST ITEMS SERIALIZED- ' . serialize($_POST),'HOTELLOG');
        if ($_POST['RoomCount-' . $idRoom] > 0) {
            functions::insertLog('RoomCount - ' . $_POST['RoomCount-'.$idRoom],'HOTELLOG');
            return $_POST['RoomCount-' . $idRoom];
        } else {
            functions::insertLog('RoomCount_Reserve - ' .$_POST['RoomCount_Reserve-'.$idRoom],'HOTELLOG');
            return $_POST['RoomCount_Reserve-' . $idRoom];
        }
    }

    public function registerPassengerOnline()
    {

        $login_user = Session::IsLogin();
        $members_model = Load::model('members');

        if ($login_user) {
            $IdMember = $_SESSION["userId"];
        } else {

            $data['mobile'] = $_POST['mobile'];
            $data['telephone'] = $_POST['telephone'];
            $data['email'] = $_POST['Email'];
            $data['password'] = $members_model->encryptPassword($_POST['mobile']);
            $data['is_member'] = '0';

            $members = $this->login_members_online($data['email']);

            if (!$members) {
                $Model = Load::library('Model');
                $Model->setTable("members_tb");
                $Model->insertLocal($data);
                $IdMember = $Model->getLastId();
            } else {
                $IdMember = $members['id'];
            }
        }

        if (!empty($IdMember)) {
            echo $IdMember;
        } else {
            echo null;
        }
    }

    public function login_members_online($email)
    {
        $Model = Load::library('Model');
        $sql = "SELECT * FROM members_tb WHERE email='{$email}'";

        return $Model->load($sql);
    }

    public function FirstBookHotel($param, $IdMember, $factorNumber, $typeApplication, $it_commission, $index = null)
    {

//		functions::insertLog(json_encode($param,256|64),'Hotels/FirstBookHotel');
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        //		$WHERE = ! empty( $param['NationalCode'] ) ? "passenger_national_code='{$param['NationalCode']}' " : "passportNumber='{$param['passportNumber']}'";

        $book_check = $this->getModel('bookHotelLocalModel')->get()->where('factor_number', $factorNumber);
//		->where('member_id',$IdMember)->where('passenger_gender',$param['gender'])->where('type_application',$typeApplication);

        if (!empty($param['NationalCode'])) {
            $book_check = $book_check->where('passenger_national_code', $param['NationalCode']);
        } else {
            $book_check = $book_check->where('passportNumber', $param['passportNumber']);
        }
//		echo $book_check->toSql();
        $book_check = $book_check->find();

        $sql = " SELECT * FROM members_tb WHERE id='{$IdMember}'";
        $user = $Model->load($sql);

        if (!empty($user)) {
            $checkSubAgency = functions::checkExistSubAgency();

            if ($user['fk_agency_id'] > 0 || $checkSubAgency) {
                $agencyId = ($checkSubAgency) ? SUB_AGENCY_ID : $user['fk_agency_id'];
                $sql = " SELECT * FROM agency_tb WHERE id='{$agencyId}'";
                $agency = $Model->load($sql);
            }
        }
        $ageCategory = '';
        if (empty($book_check)) {

            if (!empty($param['birthday_fa'])) {
                $explode_br_fa = explode('-', $param['birthday_fa']);
                $date_miladi = dateTimeSetting::jalali_to_gregorian($explode_br_fa[0], $explode_br_fa[1], $explode_br_fa[2], '-');
                $ageCategory = $this->type_passengers($date_miladi);
            }elseif(!empty($param['passenger_age'])){
                $ageCategory = $param['passenger_age'];
            }
        }


        $sql = " SELECT * FROM temprory_hotel_local_tb WHERE factor_number='{$factorNumber}' AND room_id='{$param['Id_Select_Room']}'";

        $temprory_hotel = $Model->load($sql);


        $d['passenger_national_code'] = !empty($param['NationalCode']) ? $param['NationalCode'] : '0000000000';
        //		error_log( 'birthday is : ' . ( $param['birthday_fa'] ?: $date_miladi ), 3, LOGS_DIR . '11111.txt' );
        $d['passenger_age'] = $ageCategory;
        $d['request_number'] = $param['request_number'];
        $d['passenger_gender'] = $param['gender'];
        $d['passenger_name'] = $param['name'];
        $d['passenger_name_en'] = $param['name_en'];
        $d['passenger_family'] = $param['family'];
        $d['passenger_family_en'] = $param['family_en'];
        $d['passenger_birthday'] = (isset($param['birthday_fa']) && $param['birthday_fa'] != '') ? $param['birthday_fa'] : '';
        $d['passenger_birthday_en'] = (isset($param['birthday']) && $param['birthday'] != '') ? $param['birthday'] : '';
        $d['passenger_national_code'] = $param['NationalCode'];
        $d['passportCountry'] = $param['passportCountry'];
        $d['passportNumber'] = $param['passportNumber'];
        $d['passportExpire'] = $param['passportExpire'];
        $d['member_id'] = $user['id'];
        $d['member_name'] = $user['name'] . ' ' . $user['family'];
        $d['member_mobile'] = $user['mobile'];
        $d['member_phone'] = $user['telephone'];
        $d['member_email'] = $user['email'];
        $d['search_rooms'] = $temprory_hotel['search_rooms'];
        if (!empty($agency)) {
            $d['agency_id'] = $agency['id'];
            $d['agency_name'] = $agency['name_fa'];
            $d['agency_accountant'] = $agency['accountant'];
            $d['agency_manager'] = $agency['manager'];
            $d['agency_mobile'] = $agency['mobile'];
        }
        $d['factor_number'] = $factorNumber;
        $d['room_index'] = $param['room_index'];

        if (isset($param['time_entering_room'])) {
            $d['time_entering_room'] = $param['time_entering_room'];
        }
        $d['bed_type'] = $param['BedType'];
        $d['extra_bed_count'] = isset($temprory_hotel['extra_bed_count']) ? $temprory_hotel['extra_bed_count'] : 0;
        $d['extra_bed_price'] = isset($temprory_hotel['extra_bed_price']) ? $temprory_hotel['extra_bed_price'] : 0;
        $d['child_price'] = isset($temprory_hotel['child_price']) ? $temprory_hotel['child_price'] : 0;
        $d['child_count'] = isset($temprory_hotel['child_count']) ? $temprory_hotel['child_count'] : 0;
        $d['child_array'] = isset($temprory_hotel['child_array']) ? $temprory_hotel['child_array'] : 0;
        $d['passenger_leader_room'] = $param['passenger_leader_room'];
        $d['passenger_leader_room_fullName'] = $param['passenger_leader_room_fullName'];
        $d['agency_commission'] = $temprory_hotel['agency_commission'];
        $d['agency_commission_price_type'] = $temprory_hotel['agency_commission_price_type'];
        $d['type_of_price_change'] = $temprory_hotel['type_of_price_change'];
        $d['room_price'] = $param['room_price'];
        $d['room_bord_price'] = $param['room_bord_price'];
        $d['room_online_price'] = $param['room_online_price'];

        $d['city_id'] = $temprory_hotel['city_id'];
        $d['city_name'] = $temprory_hotel['city_name'];
        $d['hotel_id'] = $temprory_hotel['hotel_id'];
        $d['hotel_name'] = $temprory_hotel['hotel_name'];
        $d['hotel_name_en'] = $temprory_hotel['hotel_name_en'];
        $d['hotel_address'] = $temprory_hotel['hotel_address'];
        $d['hotel_address_en'] = $temprory_hotel['hotel_address_en'];
        $d['hotel_telNumber'] = $temprory_hotel['hotel_telNumber'];
        $d['hotel_starCode'] = $temprory_hotel['hotel_starCode'];
        $d['hotel_entryHour'] = $temprory_hotel['hotel_entryHour'];
        $d['hotel_leaveHour'] = $temprory_hotel['hotel_leaveHour'];
        $d['hotel_pictures'] = $temprory_hotel['hotel_pictures'];
        $d['hotel_rules'] = $temprory_hotel['rules'] ?: '';
        $d['room_id'] = $temprory_hotel['room_id'];
        $d['room_name'] = $temprory_hotel['room_name'];
        $d['room_name_en'] = $temprory_hotel['room_name_en'];
        $d['room_count'] = $temprory_hotel['room_count'];
        $d['max_capacity_count_room'] = $temprory_hotel['max_capacity_count_room'];
        $d['remaining_capacity'] = $temprory_hotel['remaining_capacity'];
        $d['start_date'] = $temprory_hotel['start_date'];
        $d['end_date'] = $temprory_hotel['end_date'];
        $d['number_night'] = $temprory_hotel['number_night'];
        $d['date_current'] = $temprory_hotel['date_current'];
        $d['extra_hotel_details'] = str_replace("'", "\'", $temprory_hotel['extra_hotel_details']);
        $d['hotel_location'] = str_replace("'", "\'", $temprory_hotel['hotel_location']);

//
//		if ( $temprory_hotel['type_of_price_change'] == 'increase' && $temprory_hotel['agency_commission_price_type'] == 'cost' ) {
//			$price_current = $temprory_hotel['price_current'] + $temprory_hotel['agency_commission'];
//
//		} elseif ( $temprory_hotel['type_of_price_change'] == 'decrease' && $temprory_hotel['agency_commission_price_type'] == 'cost' ) {
//			$price_current = $temprory_hotel['price_current'] - $temprory_hotel['agency_commission'];
//
//		} elseif ( $temprory_hotel['type_of_price_change'] == 'increase' && $temprory_hotel['agency_commission_price_type'] == 'percent' ) {
//			$price_current = ( $temprory_hotel['price_current'] * $temprory_hotel['agency_commission'] / 100 ) + $temprory_hotel['price_current'];
//
//		} elseif ( $temprory_hotel['type_of_price_change'] == 'decrease' && $temprory_hotel['agency_commission_price_type'] == 'percent' ) {
//			$price_current = ( $temprory_hotel['price_current'] * $temprory_hotel['agency_commission'] / 100 ) - $temprory_hotel['price_current'];
//
//		} else {
        $price_current = $temprory_hotel['price_current'];
//		}
        $d['price_current'] = $price_current;
        $d['source_id'] = $temprory_hotel['source_id'];
        $d['price_session_id'] = $temprory_hotel['price_session_id'];
        $d['isInternal'] = $temprory_hotel['is_internal'];

        if($temprory_hotel['is_internal'] == '0' || ($temprory_hotel['is_internal'] == '1' && ($temprory_hotel['source_id'] =='17' || $temprory_hotel['source_id'] =='29')) ){
            $d['total_price_api'] = $temprory_hotel['price_online_current'];
            functions::insertLog('in condition external 1==>'.  $d['total_price_api'],'Hotels/valiagepeydakonam');
        }else{
            $d['total_price_api'] = self::calculateApiTotalPrice($factorNumber);
            functions::insertLog('in condition internal 1==>'.  $d['total_price_api'],'Hotels/valiagepeydakonam');
        }
        functions::insertLog('is_internal ? = '.$temprory_hotel['is_internal'].' & total_price_api is '. $d['total_price_api'],'Hotels/calculateApiTotalPrice');
        functions::insertLog('price_current is '. $price_current,'Hotels/calculateApiTotalPrice');
        $d['currency_code'] = $param['currency_code'];
        $d['currency_equivalent'] = $param['currency_equivalent'];

        $d['type_application'] = ($temprory_hotel['is_internal'] == '1' && ($temprory_hotel['source_id'] == '17' || $temprory_hotel['source_id'] == '29')) ? 'api' : $typeApplication;
        $d['serviceTitle'] = functions::TypeServiceHotel($d['type_application'], null, $temprory_hotel['webservice_type']);

        $d['irantech_commission'] = $it_commission;
        $price_changes = functions::getHotelPriceChange($temprory_hotel['city_id'], $temprory_hotel['hotel_starCode'], $this->counterId, $temprory_hotel['start_date'], $temprory_hotel['type_application']);
        $services_discount =functions::ServiceDiscount($this->counterId,$d['serviceTitle']);
        if ($services_discount['off_percent'] > 0) {
            $d['services_discount'] = $services_discount['off_percent'];
        }else{
            $d['services_discount'] = '0';
        }

        functions::insertLog('first book_hotel_local insert ' . json_encode($d, 256 | 64), 'hotel_report');

        if (empty($book_check)) {
            $Model->setTable('book_hotel_local_tb');
            $resultBook = $Model->insertWithBind($d);

            $ModelBase->setTable('report_hotel_tb');
            $d['client_id'] = CLIENT_ID;

            return $resultReport = $ModelBase->insertWithBind($d);
        }
        return false;
    }

    private function type_passengers($birthday)
    {

        $date_two = date("Y-m-d", strtotime("-3 year"));
        $date_twelve = date("Y-m-d", strtotime("-12 year"));

        if (strcmp($birthday, $date_two) > 0) {
            return "Inf";
        } elseif (strcmp($birthday, $date_two) <= 0 && strcmp($birthday, $date_twelve) > 0) {
            return "Chd";
        } else {
            return "Adt";
        }
    }

    /**
     * @param null $factor_number
     *
     * @return bool|int
     */
    public function calculateApiTotalPrice($factor_number = null)
    {
        if (!$factor_number) {
            return false;
        }
        $total_api_price = 0;
        $total_price = 0;
        $total_extra_price = 0;
        $total_child_price = 0;

        /** @var temporaryHotelLocalModel $temp_model */
        $temp_model = Load::getModel('temporaryHotelLocalModel');

        $all_rows = $temp_model->get()->where('factor_number', $factor_number)->all();

        foreach ($all_rows as $temp_row) {
            $room_count = $temp_row['room_count'];
            $extra_bed_count = $temp_row['extra_bed_count'];
            $child_count = $temp_row['child_count'];
            $online_api = $temp_row['price_online_current'];
            $price_current = $temp_row['price_current'];
            $extra = $temp_row['extra_bed_price'];
            $child = $temp_row['child_price'];
            functions::insertLog(json_encode($temp_row,256|64),'Hotels/calculateApiTotalPrice');
            $total_api_price = $total_api_price + ($online_api * $room_count);
            $total_extra_price = $total_extra_price + ($extra_bed_count * $extra);
            $total_child_price = $total_child_price + ($child_count * $child);
        }
        $total_price = $total_child_price + $total_extra_price + $total_api_price;

        return $total_price;
    }

    public function HotelReserveNew($params)
    {

        $factor_number = trim($params['factorNumber']);
        $type_application = trim($params['typeApplication']);

        /** @var Model $Model */
        /** @var ModelBase $ModelBase */
        /** @var smsServices $smsController */
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $smsController = Load::controller('smsServices');
        $statusRequestWebService = array();

        $checkLogin = Session::IsLogin();
        if ($checkLogin) {
            $counter_type_id = functions::getCounterTypeId($_SESSION['userId']);
        } else {
            $counter_type_id = '5';
        }


        // api or reservation
        if ($type_application == 'api' || $type_application == 'externalApi' || $type_application == 'api_app') {

            /** @var bookHotelLocalModel $book_model */
            $book_model = $this->getModel('bookHotelLocalModel');
            /** @var reportHotelModel $report_model */
            $report_model = $this->getModel('reportHotelModel');
            $book_hotel = $book_model->get()->where('factor_number', $factor_number);
            $hotel_source = $book_hotel->find();

            if($hotel_source['source_id'] != '17' &&  $hotel_source['source_id'] != '29') {
                if ($type_application == 'api' && (substr($params['hotel_id'], 0, 2) != '17') || (substr($params['hotel_id'], 0, 2) != '29') || $type_application == 'api_app') {
                    $book_hotel = $book_hotel->groupBy('room_id');
                }
            }

            $book_hotel = $book_hotel->all();

            if($hotel_source['source_id'] == '29'){
                $book_room_hotel = $book_model->get()->where('factor_number', $factor_number)->groupBy('room_id')->all();
            }

//			echo json_encode($book_hotel,256|64); die();


            //			$sql        = " SELECT * FROM book_hotel_local_tb WHERE factor_number='{$factor_number}' GROUP BY room_id";
            //			if ( $type_application == 'externalApi' ) {
            //				$sql = " SELECT * FROM book_hotel_local_tb WHERE factor_number='{$factor_number}'";
            //			}
            //			$book_hotel = $Model->select( $sql );

            if (!empty($book_hotel)) {

                $hotel_id = $book_hotel[0]['hotel_id'];
                $nights = $book_hotel[0]['number_night'];
                $start_date = $book_hotel[0]['start_date'];
                $total_price = $book_hotel[0]['total_price'];
                $total_price_api = $book_hotel[0]['total_price_api'];
                $price_session_id = $book_hotel[0]['price_session_id'];

                $roomsArray = $passengersArray = $buyerArray = [];

                foreach ($book_hotel as $rk => $room) {
                    if ($type_application == 'externalApi' /*||( $book_hotel[0]['is_internal'] == '1' && substr($book_hotel[0]['hotel_id'],0,2) == '17') */) {
                        $roomsArray = [
                            [
                                'RoomCode' => $room['room_id'],
                                'RoomCount' => $room['room_count'],
                                'ExtraBed' => $room['extra_bed_count']
                            ]
                        ];
                    }
                    else {


                        $thisRoomArray = [
                            'RoomCode' => $room['room_id'],
                            'RoomCount' => $room['room_count'],
                            'ExtraBed' => $room['extra_bed_count'],
                        ];

                        //						echo $room['child_array'];

                        $child_array = json_decode($room['child_array'], true);
                        //						echo Load::plog($child_array);die();
                        if (isset($child_array[$room['room_index']])) {
                            $thisRoomArray['ChildrenAges'] = $child_array[$rk];
                        }
                        $roomsArray[] = $thisRoomArray;
                    }
                    if($room['source_id'] == '29') {
                        if($room['passenger_age'] == 'Adt') {
                            $birthday = $this->generateBirthdayDate();
                        }else{
                            $birthday = $this->generateYoungerBirthdayDate();
                        }

                    }else{
                        $birthday = ($room['passenger_birthday_en']) ? $room['passenger_birthday_en'] : dateTimeSetting::jalali_to_gregorian(explode('-', $room['passenger_birthday'])[0], explode('-', $room['passenger_birthday'])[1], explode('-', $room['passenger_birthday'])[2], '-');
                    }
                    $passengersArray[] = [
                        'Gender' => $room['passenger_gender'],
                        'FirstName' => $room['passenger_name'],
                        'FirstNameEn' => $room['passenger_name_en'],
                        'LastName' => $room['passenger_family'],
                        'LastNameEn' => $room['passenger_family_en'],
                        'Birthday' => $room['passenger_birthday'],
                        'RoomIndex' => ($room['room_index'] + 1),
                        'Country' => isset($room['passportCountry']) ? $room['passportCountry'] : '',
                        'BirthdayEn' => $birthday,
                    ];

                    //					$buyerArray = [
                    //						'FirstName' => $room['member_name'],
                    //						'LastName'  => $room['member_name'],
                    //						'Mobile'    => $room['member_mobile'],
                    //						'Email'     => $room['member_email'],
                    //					];
                    $buyerArray = [
                        'FirstName' => 'Abazar',
                        'LastName' => 'Afshar',
                        'Mobile' => '09057078341',
                        'Email' => 'info@iran-tech.com',
                    ];
                }

                if($hotel_source['source_id'] == '29'){
                    foreach ($book_room_hotel as $rk => $room) {
                        $roomsArray = [
                            [
                                'RoomCode' => $room['room_id'],
                                'RoomCount' => $room['room_count'],
                                'ExtraBed' => $room['extra_bed_count']
                            ]
                        ];
                    }
                }

                $requestArray = [
                    'FactorNumber' => $factor_number,
                    'RequestNumber' => $params['requestNumber'],
                    'PriceSessionId' => $price_session_id,
                    'Rooms' => $roomsArray,
                    'Passengers' => $passengersArray,
                    'Buyer' => $buyerArray,
                ];

                $HotelReserveRoom = json_decode($this->Book($requestArray), true);

                if (isset($HotelReserveRoom['Success']) &&  $HotelReserveRoom['Success'] == true) {
                    if ($HotelReserveRoom['Success']) {

                        if(isset($HotelReserveRoom['Result']['Status']) && $HotelReserveRoom['Result']['Status'] == 'pending'){
                            $statusRequestWebService = $this->setOnRequestHotel($factor_number ,$counter_type_id ,  $HotelReserveRoom , $type_application);
                        }
                        else {
                            if($hotel_source['source_id'] == '29'){
                                if(isset($HotelReserveRoom['Result']['change_price']) && $HotelReserveRoom['Result']['change_price'] == true) {
                                    if(isset($HotelReserveRoom['Result']['change_price_detail']) && !empty($HotelReserveRoom['Result']['change_price_detail']) ){
                                        $old_price = $HotelReserveRoom['Result']['change_price_detail']['OldHoteRoomInfo'];
                                        $new_price = $HotelReserveRoom['Result']['change_price_detail']['NewHoteRoomInfo'];

                                        if($old_price[0]['TotalFare'] != $new_price[0]['TotalFare']) {
                                            $total_new_price = 0 ; 
                                            $total_old_price = 0 ;
                                            foreach ($old_price as $price) {
                                                $total_old_price += $price['TotalFare'];
                                            }
                                            foreach ($new_price as $price) {
                                                $total_new_price += $price['TotalFare'];
                                            }
                                            $insert_price_change_array = array(
                                                'factor_number'=>$book_hotel[0]['factor_number'],
                                                'old_price'=> $total_old_price,
                                                'new_price'=> $total_new_price,
                                                'change_type'=>'change_price',
                                                'client_id'=>CLIENT_ID,
                                                'created_at'=>date('Y-m-d H:i:s'),
                                            );

                                            /** @var webhookPriceChangesModel $price_change */
                                            $price_change = Load::getModel('webhookPriceChangesModel');
                                            $admin     = Load::controller( 'admin' );

                                            $price_change_insert = $price_change->insertWithBind($insert_price_change_array);
                                            unset($insert_price_change_array['client_id']);
                                            $res2 = $admin->ConectDbClient( '', CLIENT_ID, 'Insert', $insert_price_change_array, 'webhook_price_changes_tb', $condition );
                                        }
                                    }
                                }
                            }
                            foreach ($HotelReserveRoom['Result']['ReservationDetails'] as $key => $room) {
                                $d['remarks'] = $room['Remarks'];
                            }
                            $d['request_number'] = $params['requestNumber'];
                            //						$d['pnr']               = $HotelReserveRoom['RequestPNR'];
                            $d['status'] = "PreReserve";

                            $d['creation_date_int'] = time();
                            $d['payment_date'] = date('Y-m-d H:i:s');

                            $Condition = "factor_number='{$factor_number}' ";
                            $Model->setTable("book_hotel_local_tb");
                            functions::insertLog('first book_hotel_local update ' . json_encode($d, 256 | 64), 'hotel_report');
                            $res = $book_model->updateWithBind($d, $Condition);

                            $res_report = $report_model->updateWithBind($d, $Condition);

//						$ModelBase->setTable( "report_hotel_tb" );
//						$res_report = $ModelBase->update( $d, $Condition );

                            if ($res && $res_report) {

                                $statusRequestWebService['type_application'] = $type_application;
                                $statusRequestWebService['book'] = "yes";
                                $statusRequestWebService['factor_number'] = $factor_number;
                                $statusRequestWebService['total_price'] = $total_price;
                                $statusRequestWebService['RequestNumber'] = $params['requestNumber'];
                                $statusRequestWebService['StatusCode'] = $HotelReserveRoom['StatusCode'];

                            }

                        }


                    }
                    else {
                      
                        $statusRequestWebService['book'] = "NoReserve";
                        $statusRequestWebService['factor_number'] = $factor_number;
                    }

                }
                else {

                    /*$d['request_number'] = '';
                    $d['pnr'] = '';
                    $d['status'] = 'NoReserve';
                    $d['creation_date_int'] = time();

                    $Condition = "factor_number='{$factor_number}' ";
                    $Model->setTable("book_hotel_local_tb");
                    $res = $Model->update($d, $Condition);

                    $ModelBase->setTable("report_hotel_tb");
                    $res_report = $ModelBase->update($d, $Condition);

                    $statusRequestWebService['book'] = "no";
                    $statusRequestWebService['factor_number'] = $factor_number;*/

                    if ($type_application == 'api' && $HotelReserveRoom['Result']['Error']['Code'] == 'BK-417') {
                        $statusRequestWebService = $this->setOnRequestHotel($factor_number , $counter_type_id ,  $HotelReserveRoom , $type_application);
                    } else {

                        $d['status'] = 'NoReserve';
                        $d['creation_date_int'] = time();

                        $Condition = "factor_number='{$factor_number}' ";
                        functions::insertLog('first book_hotel_local externalApi update 2 ' . json_encode($d, 256 | 64), 'hotel_report');
                        $res = $book_model->updateWithBind($d, $Condition);
                        $res_report = $report_model->updateWithBind($d, $Condition);
//						$Model->setTable( "book_hotel_local_tb" );
//						$res = $Model->update( $d, $Condition );
//						$ModelBase->setTable( "report_hotel_tb" );
//						$res_report = $ModelBase->update( $d, $Condition );

                        $statusRequestWebService['book'] = "no";
                        $statusRequestWebService['factor_number'] = $factor_number;
                        $statusRequestWebService['StatusCode'] = $HotelReserveRoom['StatusCode'];
                    }
                }
            }
            else {

                $statusRequestWebService['book'] = "no";
                $statusRequestWebService['factor_number'] = $factor_number;
                $statusRequestWebService['StatusCode'] = "400";
            }
        }

        return $this->returnJson($statusRequestWebService, $statusRequestWebService['StatusCode']);
    }

    public function Book($requestArray = null)
    {
        if (!$requestArray['RequestNumber']) {
            return $this->returnJson('شماره پیگیری الزامی است', 400);
        }
        $factor_number = $requestArray['FactorNumber'];
        //		unset( $requestArray['FactorNumber'] );
        functions::insertLog(PHP_EOL . 'request with factor number ' . $factor_number . ' AND data ' . json_encode($requestArray, 256 | 64) . ' => ', 'log_hotel_preReserve');
        $HotelReserveRoom = json_decode(parent::Book($requestArray), true);

        functions::insertLog(PHP_EOL . 'response with factor number ' . $factor_number . ' => ' . json_encode($HotelReserveRoom, 256 | 64), 'log_hotel_preReserve');

        if (!isset($HotelReserveRoom['Result'])) {
            return $this->showError('خطا در رزرو هتل. ', 400, $HotelReserveRoom);
        }
        if (isset($HotelReserveRoom['Result']['Error']) && !empty($HotelReserveRoom['Result']['Error'] ) && $HotelReserveRoom['Result']['Error']['Code'] != 'BK-417') {
            $Model = Load::library('Model');

            $MessageError = functions::ShowHotelError($HotelReserveRoom['Result']['Error']['Code']);

            $data['message'] = $HotelReserveRoom['Result']['Error']['Message'];
            $data['messageFa'] = $MessageError;
            $data['clientId'] = CLIENT_ID;
            $data['messageCode'] = $HotelReserveRoom['Result']['Error']['Code'];
            $data['request_number'] = $requestArray['RequestNumber'];
            $data['factor_number'] = $factor_number;

            $data['action'] = 'Book';
            $data['creation_date_int'] = time();

            $this->getController('logErrorsHotels')->insertLogErrorHotels($data);

            return $this->showError('خطا در رزرو هتل. ', 400, $HotelReserveRoom);
        }

        return $this->returnJson($HotelReserveRoom, 200);
    }

    public function GetDataFromReport($params)
    {
        functions::insertLog('start ==>'.json_encode($params , 256),'Hotels/smsHotel');

        $checkLogin = Session::IsLogin();
        if ($checkLogin) {
            $counter_type_id = functions::getCounterTypeId($_SESSION['userId']);
        } else {
            $counter_type_id = '5';
        }
        /** @var Model $Model */
//		$Model                                    = Load::library( 'Model' );
        $book_model = $this->getModel('bookHotelLocalModel');


        $data = $book_model->get()->where('factor_number', $params['factorNumber'])->find();

        if (!empty($data['member_mobile'])) {
            $mobile = $data['member_mobile'];
            $name = $data['member_name'];
        } else {
            $mobile = $data['passenger_leader_room'];
            $name = $data['passenger_leader_room_fullName'];
        }

        $service_discount = functions::ServiceDiscount($this->counterId,$data['serviceTitle']);
        functions::insertLog('discount price hotel with serviceTile'. $data['serviceTitle'] .'===>'.json_encode($service_discount),'HOTELLOG');
        functions::insertLog('increase price with counter id==>'.$this->counterId.' and with data===>'.json_encode($data),'HOTELLOG');
        $price_changes = functions::getHotelPriceChange($data['city_id'], $data['hotel_starCode'], $this->counterId, $data['start_date'], $data['type_application']);
        functions::insertLog('increase price hotel===>'.json_encode($price_changes),'HOTELLOG');

        $statusRequestWebService['book'] = $data['status'];

        $statusRequestWebService['factor_number'] = $data['factor_number'];
        $statusRequestWebService['admin_checked'] = $data['admin_checked'];
        $statusRequestWebService['total_price'] = $data['total_price'];
        $statusRequestWebService['member_name'] =$name;
        $statusRequestWebService['member_mobile'] = $mobile;
        $statusRequestWebService['price_changed'] = false;

        $price_change_model = $this->getModel('webhookPriceChangesModel');
        $webhook_price_change = $price_change_model->get()->where('factor_number',$data['factor_number'])->orderBy('id','DESC')->find();

        $new_total_price = functions::calculateHotelPrice($price_changes,$service_discount,$data['total_price_api'],true);
        $statusRequestWebService['total_payment_price'] = $new_total_price;

        functions::insertLog('before new price ==>'.json_encode($params , 256),'Hotels/smsHotel');

        if(is_array($webhook_price_change) && $webhook_price_change['new_price'] > 0){
            $new_total_price = functions::calculateHotelPrice($price_changes,$service_discount,$webhook_price_change['new_price'],true);
            $Condition = "request_number = '{$data['request_number']}'";
            $update_book = $book_model->update(
                array(
                    'total_price_api'=>$webhook_price_change['new_price'],
                    'total_price'=>$new_total_price,
                ),$Condition
            );

            $update_report = $this->getModel('reportHotelModel')->update(array('total_price_api'=>$webhook_price_change['new_price'],'total_price'=>$new_total_price),$Condition);
            $statusRequestWebService['price_changed'] = true;
            $statusRequestWebService['total_payment_price'] = functions::calculateHotelPrice($price_changes,$service_discount,$webhook_price_change['new_price'],true);
        }

        $statusRequestWebService['user_type'] = $counter_type_id;
        //		$statusRequestWebService['api_result']    = $HotelReserveRoom;
        //		$statusRequestWebService['StatusCode']    = $HotelReserveRoom['StatusCode'];

        functions::insertLog('before status ==>'.json_encode($data['status'] , 256),'Hotels/smsHotel');
        if ($data['status'] == 'OnRequest' && $data['type_application'] != 'reservation' || $data['source_id'] == '12') {
            if(isset($params['first_check']) && $params['first_check'] === '1') {

                functions::insertLog('repeating sms'. $data['serviceTitle'] .'===>'.$params['factorNumber'],'Hotels/smsHotel');

                //sms to our supports
                $smsController = Load::controller('smsServices');
                $objSms = $smsController->initService('1');
                if ($objSms) {
                    $cellArray = array(
                        'fanipoor' => '09129409530',
                        'afrazeh' => '09916211232',
                        'araste' => '09211559872',
                        'amirabbas' => '09057078341',
                    );
                    functions::insertLog('before sms pattern'. $data['serviceTitle'] .'===>'.$params['factorNumber'],'Hotels/smsHotel');

                    $smsController->smsByPattern('zqfwjy0y27', $cellArray, ['name' => CLIENT_NAME]);
                    functions::insertLog('after sms pattern'. $data['serviceTitle'] .'===>'.$params['factorNumber'],'Hotels/smsHotel');

                }
            }
        }
        functions::insertLog('finish'. $data['serviceTitle'] .'===>'.$params['factorNumber'],'Hotels/smsHotel');
        if($data['status'] == 'NoReserve' && SOFTWARE_LANG == 'fa') {
            $data_error = $this->getController('logErrorsHotels')->getErrorMessage($data['request_number'] , $data['factor_number'],CLIENT_ID);
            if($data_error) {
                if($data_error['messageCode'] == 'BK-420' ||
                    $data_error['messageCode'] == 'Reserve-408' ||
                    $data_error['messageCode'] == 'Book-408' ||
                    $data_error['messageCode'] == 'Bk-406') {
                    $statusRequestWebService['error_comment'] = $data_error['messageFa'];
                }
            }
        }
        return $this->returnJson($statusRequestWebService, 200);
    }

    public function Reserve($hotel_details = [])
    {
        $requestNumber = isset($hotel_details['request_number']) ? $hotel_details['request_number'] : null;
        $session_id = isset($hotel_details['price_session_id']) ? $hotel_details['price_session_id'] : null;
        if (!$requestNumber) {
            return $this->returnJson('شماره پیگیری الزامی است', 400);
        }

        if ($hotel_details['serviceTitle'] == 'PublicPortalHotel' && strpos($hotel_details['room_id'], '12_') !== false) {
            $hotel_details['is_itours'] = true;
            return $this->fakeReserveSuccess($hotel_details);
        }
        //		return $this->fakeReserveSuccess($hotel_details);
        //
        $reserve_params = ['RequestNumber' => $requestNumber,'PriceSessionId'=>$session_id];
        $Reserve = json_decode(parent::Reserve($reserve_params), true);

        if (!isset($Reserve['Result'])) {
            return $this->showError('خطا در رزرو اتاق. ', 400, $Reserve);
        }

        if (isset($Reserve['Result']['Error']) && !empty($Reserve['Result']['Error'] ) && $Reserve['Result']['Error']['Code'] != 'BK-417') {
            $Model = Load::library('Model');

            $MessageError = functions::ShowHotelError($Reserve['Result']['Error']['Code']);

            $data['message'] = $Reserve['Result']['Error']['Message'];
            $data['messageFa'] = $MessageError;
            $data['clientId'] = CLIENT_ID;
            $data['messageCode'] = $Reserve['Result']['Error']['Code'];
            $data['request_number'] = $requestNumber;
            $data['factor_number'] = $hotel_details['factor_number'];

            $data['action'] = 'Reserve';
            $data['creation_date_int'] = time();

            $this->getController('logErrorsHotels')->insertLogErrorHotels($data);


        }

        $data_update = [
            'pnr' => isset($Reserve['Result']['PNR']) ? $Reserve['Result']['PNR'] : '',
        ];

        $update_book = $this->getModel('bookHotelLocalModel')->updateWithBind($data_update, ['request_number' => $hotel_details['request_number']]);
        $update_report = $this->getModel('reportHotelModel')->updateWithBind($data_update, ['request_number' => $hotel_details['request_number']]);

        return $this->returnJson($Reserve, $Reserve['StatusCode']);
    }

    private function fakeReserveSuccess($details = [])
    {

        functions::insertLog('Fake Details : ' . json_encode($details, 256 | 64), "Hotels/{$details['request_number']}");

        $reserve_array = array();

        $reserve_array['Success'] = true;
        $reserve_array['RequestNumber'] = $details['request_number'];
        $reserve_array['Result'] = [
            'ManualBook' => true,
            'VouchersDetails' => [
                'VoucherNumber' => $details['factor_number'],
                'RoomCode' => $details['room_id'],
                'Price' => $details['room_price'],
            ]
        ];
        functions::insertLog('Reserve array : ' . json_encode($reserve_array, 256 | 64), "Hotels/{$details['request_number']}");

        $smsController = Load::controller('smsServices');
        $objSms = $smsController->initService('1');
        if ($objSms) {
            $cellArray = array(

                //				'afshar'   => '09123493154',
                'afraze'   => '09916211232',
                'fanipor'  => '09129409530',
                'araste'   => '09211559872',
                'amirabas' => '09057078341'
            );

            foreach ($cellArray as $cellNumber) {
//                $smsArray = array(
//                    'data' => ['serverId' => 'Ù‡ØªÙ„ Ø®Ø§Ø±Ø¬ÛŒ Ø¢ÛŒ ØªÙˆØ±Ø²'],
//                    'cellNumber' => $cellNumber,
//                    'code' => 'b4pma2p4tz',
//                );
                $smsArray = array(
                    'data' => [],
                    'cellNumber' => $cellNumber,
                    'code' => 'alyop00wd1k068f',
                );
                $smsController->smsSendPattern($smsArray);
            }
        }


        return $this->returnJson($reserve_array, 200);


    }

    public function ForceReserve($param = [])
    {
        /** @var bookHotelLocalModel $book_model */
        /** @var reportHotelModel $report_model */

        $book_model = Load::getModel('bookHotelLocalModel');
        $report_model = Load::getModel('reportHotelModel');
        $smsController = Load::controller('smsServices');


        $report_result = $report_model->get(['client_id' , 'price_session_id' , 'request_number'])->where('factor_number', $param['RequestNumber'])->find();

        $Hotel = $book_model
            ->get()
            ->where('factor_number',$param['RequestNumber'])
            ->where('status','pending')
            ->groupBy('factor_number')
            ->find();

        $client_id = $report_result['client_id'];

        /** @var ModelBase $model_base */
        $model_base = Load::library('ModelBase');

        $sql_auth_hotel = "SELECT AUTH.id, AUTH.Username,AUTH.Password, SOURCE.id as SourceId
                  FROM client_auth_tb AS AUTH
                  INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                  INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                  WHERE AUTH.ClientId = '" . $client_id . "' AND (SERVICE.Service = 'HotelLocal' OR SERVICE.Service = 'HotelPortal') AND AUTH.IsActive='Active' ";

        $arrayAuth = $model_base->load($sql_auth_hotel);

        $param['ForceReserve'] = true;
        $param['RequestNumber'] = $report_result['request_number'];
        $param['PriceSessionId'] =  $report_result['price_session_id'];
        //		return functions::withSuccess($param);
        //		return $this->returnJson($param);

        //		$this->arrayAuth['Username'] = '';
        //		$this->arrayAuth['Password'] = '';
        $authStr = base64_encode("{$arrayAuth['Username']}:{$arrayAuth['Password']}");

        $headers = array(
            'Authorization: Basic ' . $authStr,
            'Content-Type: application/json',
        );


//		$resultHotel = functions::curlExecution( $this->urlApi.'Reserve/', json_encode( $param ), $headers );
        $resultHotel = parent::Reserve($param);

        $response = json_decode($resultHotel, true);
        functions::insertLog('result booking hotel itours  ' . json_encode($resultHotel, 256 | 64), 'ForceReserve');

        if ($response['StatusCode'] == 200) {
            $result = $response['Result'];
            $voucher_number = $result['VouchersDetails'][0]['VoucherNumber'] ?: $result['PNR'];
            $update_array = array('manual_book' => 0, 'pnr' => $voucher_number , 'status' => 'BookedSuccessfully');

//            $book_model->updateWithBind($update_array, "request_number='{$param['RequestNumber']}'");
//            $report_model->updateWithBind($update_array);
            $objSms = $smsController->initService('0');
            if ($objSms) {
                if (!empty($Hotel['member_mobile'])) {
                    $mobile = $Hotel['member_mobile'];
                    $name = $Hotel['member_name'];
                } else {
                    $mobile = $Hotel['passenger_leader_room'];
                    $name = $Hotel['passenger_leader_room_fullName'];
                }
                $messageVariables = array(
                    'sms_name' => $name,
                    'sms_service' => 'هتل',
                    'sms_factor_number' => $Hotel['factor_number'],
                    'sms_cost' => $Hotel['total_price'],
                    'sms_destination' => $Hotel['city_name'],
                    'sms_hotel_name' => $Hotel['hotel_name'],
                    'sms_hotel_in' => $Hotel['start_date'],
                    'sms_hotel_out' => $Hotel['end_date'],
                    'sms_hotel_night' => $Hotel['number_night'],
                    'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=BookingHotelLocal&id=" . $Hotel['factor_number'],
                    'sms_pdf_en' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=bookhotelshow&id=" . $Hotel['factor_number'],
                    'sms_agency' => CLIENT_NAME,
                    'sms_agency_mobile' => CLIENT_MOBILE,
                    'sms_agency_phone' => CLIENT_PHONE,
                    'sms_agency_email' => CLIENT_EMAIL,
                    'sms_agency_address' => CLIENT_ADDRESS,
                );
                error_log(PHP_EOL . date('Y/m/d H:i:s') . " before smsArray ", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
                $smsArray = array(
                    'smsMessage' => $smsController->getUsableMessage('afterHotelReserve', $messageVariables),
                    'cellNumber' => $mobile,
                    'smsMessageTitle' => 'afterHotelReserve',
                    'memberID' => (!empty($Hotel['member_id']) ? $Hotel['member_id'] : ''),
                    'receiverName' => $messageVariables['sms_name'],
                );
                error_log(PHP_EOL . date('Y/m/d H:i:s') . "smsArray ".json_encode($smsArray,256|64), 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
                $sms_result = $smsController->sendSMS($smsArray);
                error_log(PHP_EOL . date('Y/m/d H:i:s') . "smsArray ".json_encode($sms_result,256|64), 3, LOGS_DIR . 'log_method_ReserveHotel.txt');

            }
            return $this->returnJson($resultHotel, $resultHotel['StatusCode']);
        } else {
            $update_array = array('manual_book' => '-1', 'pnr' => null , 'status' => 'NoReserve');
            $book_model->updateWithBind($update_array, "request_number='{$param['RequestNumber']}'");
            $report_model->updateWithBind($update_array);
            return $this->returnJson($resultHotel, $resultHotel['StatusCode']);
        }

    }
    public function handleForceReserve($param = [])
    {


        /** @var bookHotelLocalModel $book_model */
        /** @var reportHotelModel $report_model */

        $book_model = Load::getModel('bookHotelLocalModel');
        $report_model = Load::getModel('reportHotelModel');
        $smsController = Load::controller('smsServices');


        $report_result = $report_model->get(['client_id' , 'price_session_id' , 'request_number'])
            ->where('factor_number', $param['factorNumber'])->find();

        $Hotel = $report_model->get()
            ->get()
            ->where('factor_number',$param['factorNumber'])
            ->where('status','pending')
            ->groupBy('factor_number')
            ->find();

        if($Hotel) {
            $client_id = $report_result['client_id'];



            $param['ForceReserve'] = true;
            $param['RequestNumber'] = $report_result['request_number'];
            $param['PriceSessionId'] =  $report_result['price_session_id'];

            $voucher_number = $param['pnr'];
            $update_array = array('manual_book' => 0, 'pnr' => $voucher_number , 'status' => 'BookedSuccessfully');

            $book_model->updateWithBind($update_array, "factor_number='{$param['factorNumber']}'");
            $report_model->updateWithBind($update_array, "factor_number='{$param['factorNumber']}'");
            $objSms = $smsController->initService('0');
            if ($objSms) {
                if (!empty($Hotel['member_mobile'])) {
                    $mobile = $Hotel['member_mobile'];
                    $name = $Hotel['member_name'];
                } else {
                    $mobile = $Hotel['passenger_leader_room'];
                    $name = $Hotel['passenger_leader_room_fullName'];
                }
                $messageVariables = array(
                    'sms_name' => $name,
                    'sms_service' => 'هتل',
                    'sms_factor_number' => $Hotel['factor_number'],
                    'sms_cost' => $Hotel['total_price'],
                    'sms_destination' => $Hotel['city_name'],
                    'sms_hotel_name' => $Hotel['hotel_name'],
                    'sms_hotel_in' => $Hotel['start_date'],
                    'sms_hotel_out' => $Hotel['end_date'],
                    'sms_hotel_night' => $Hotel['number_night'],
                    'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=BookingHotelLocal&id=" . $Hotel['factor_number'],
                    'sms_pdf_en' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=bookhotelshow&id=" . $Hotel['factor_number'],
                    'sms_agency' => CLIENT_NAME,
                    'sms_agency_mobile' => CLIENT_MOBILE,
                    'sms_agency_phone' => CLIENT_PHONE,
                    'sms_agency_email' => CLIENT_EMAIL,
                    'sms_agency_address' => CLIENT_ADDRESS,
                );
                error_log(PHP_EOL . date('Y/m/d H:i:s') . " before smsArray ", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
                $smsArray = array(
                    'smsMessage' => $smsController->getUsableMessage('afterHotelReserve', $messageVariables),
                    'cellNumber' => $mobile,
                    'smsMessageTitle' => 'afterHotelReserve',
                    'memberID' => (!empty($Hotel['member_id']) ? $Hotel['member_id'] : ''),
                    'receiverName' => $messageVariables['sms_name'],
                );
                error_log(PHP_EOL . date('Y/m/d H:i:s') . "smsArray ".json_encode($smsArray,256|64), 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
                $sms_result = $smsController->sendSMS($smsArray);
                error_log(PHP_EOL . date('Y/m/d H:i:s') . "smsArray ".json_encode($sms_result,256|64), 3, LOGS_DIR . 'log_method_ReserveHotel.txt');

            }
            echo 'Success : عملیات با موفقیت انجام شد';
        }else{
            echo 'Error : عملیات با خطا مواجه ';
        }

    }
    public function ForceCancelReserve($param = [])
    {


        /** @var bookHotelLocalModel $book_model */
        /** @var reportHotelModel $report_model */

        $book_model = Load::getModel('bookHotelLocalModel');
        $report_model = Load::getModel('reportHotelModel');
        $smsController = Load::controller('smsServices');


        $report_result = $report_model->get(['client_id' , 'price_session_id' , 'request_number'])
            ->where('factor_number', $param['factorNumber'])->find();

        $Hotel = $book_model
            ->get()
            ->where('factor_number',$param['factorNumber'])
            ->where('status','pending')
            ->groupBy('factor_number')
            ->find();
        if($Hotel) {
            $client_id = $report_result['client_id'];

            $update_array = array('manual_book' => 0, 'status' => 'NoReserve');

            $book_model->updateWithBind($update_array, "factor_number='{$param['factorNumber']}'");
            $report_model->updateWithBind($update_array, "factor_number='{$param['factorNumber']}'");
            echo 'Success : عملیات با موفقیت انجام شد';
        }else{
            echo 'Error : عملیات با خطا مواجه ';
        }

    }

    public function checkOfflineStatus($requestNumber)
    {
        $data = ['RequestNumber' => $requestNumber];
        $result = json_decode(parent::checkOfflineStatus($data), true);

        //		return json_encode($result);
        return $this->returnJson($result, $result['StatusCode']);
    }

    public function RandomHotelList($requestNumber)
    {
        $data = [];
        $result = json_decode(parent::RandomHotelList($data), true);

        //		return json_encode($result);
        return $this->returnJson($result, $result['StatusCode']);
    }

    public function updateOfflineReserve($params)
    {

        /** @var bookHotelLocalModel $bookHotelLocalModel */
        /** @var reportHotelModel $reportHotelModel */
        $bookHotelLocalModel = Load::getModel('bookHotelLocalModel');
        $reportHotelModel = Load::getModel('reportHotelModel');
        /** @var Model $Model */
        /** @var ModelBase $ModelBase */
//        $Model = Load::library('Model');
//        $ModelBase = Load::library('ModelBase');
//        $sql = "SELECT * FROM report_hotel_tb WHERE factor_number = '{$params['factor_number']}' GROUP BY room_id";
        $book = $reportHotelModel->get()->where('factor_number',$params['factor_number'])->groupBy('room_id')->find();

//        $book = $ModelBase->select($sql);
        if (!$book) {
            return 'error | خطا شماره فاکتور';
        }

        $type_application = $book['type_application'];

        if($type_application == 'reservation' || $type_application == 'reservation_app'){
            $data['status'] = 'PreReserve';
            $data['creation_date_int'] = time();
            $Condition = " factor_number='{$params['factor_number']}' ";

            $res2 = $bookHotelLocalModel->updateWithBind($data, $Condition);
            $res1 = $reportHotelModel->updateWithBind($data, $Condition);

            if ($res1 && $res2) { 
                $smsController = Load::controller('smsServices');
                $objSms = $smsController->initService('0');
                if ($objSms) {
                    if (!empty(  $book['member_mobile'])) {
                        $mobile = $book['member_mobile'];
                        $name = $book['member_name'];
                    } else {
                        $mobile = $book['passenger_leader_room'];
                        $name = $book['passenger_leader_room_fullName'];
                    }
                    $confirm_request_hotel_pattern =   $smsController->getPattern('confirm_on_request_hotel');
                    if($confirm_request_hotel_pattern) {
                        $smsController->smsByPattern($confirm_request_hotel_pattern['pattern'], array($mobile), array('customer_name' => CLIENT_NAME , 'factor_number' => $book['factor_number']));
                    }else {
                        $messageVariables = array(
                            'sms_name' => $name,
                        'sms_service' => 'Ù‡ØªÙ„',
                        'sms_factor_number' => $book['factor_number'],
                        'sms_cost' => $book['total_price'],
                        'sms_destination' => $book['city_name'],
                        'sms_hotel_name' => $book['hotel_name'],
                        'sms_hotel_in' => $book['start_date'],
                        'sms_hotel_out' => $book['end_date'],
                        'sms_hotel_night' => $book['number_night'],
                        'sms_agency' => CLIENT_NAME,
                        'sms_agency_mobile' => CLIENT_MOBILE,
                        'sms_agency_phone' => CLIENT_PHONE,
                        'sms_agency_email' => CLIENT_EMAIL,
                        'sms_agency_address' => CLIENT_ADDRESS,
                    );

                        $smsArray = array(
                            'smsMessage' => $smsController->getUsableMessage('onRequestConfirm', $messageVariables),
                            'cellNumber' => $mobile,
                            'smsMessageTitle' => 'onRequestConfirm',
                            'memberID' => (!empty($book['member_id']) ? $book['member_id'] : ''),
                            'receiverName' => $messageVariables['sms_name'],
                        );
                        $smsController->sendSMS($smsArray);
                    }
                }
                
		return 'success |  تغییرات با موفقیت انجام شد';
            } else {
                return 'error | خطا در  تغییرات';
            }
        }
        $RequestNumber = $book['request_number'];
        $UpdateStatus = json_decode(parent::checkOfflineStatus(['RequestNumber' => $RequestNumber]), true);

        //		$d['pnr'] = $hotelReserveRoom['RequestPNR'];
        if (!$UpdateStatus['Success']) {
            return 'error | خطا. اطلاعات ارسال شده صحیح نیست ' . json_encode($params);
            //			return $this->showError('خطا در ارسال درخواست رزرو ',400,$UpdateStatus);
        }
        $d['pnr'] = $UpdateStatus['Result']['ReserveNumber'];
        $d['status'] = "PreReserve";
        $d['creation_date_int'] = time();
        $d['payment_date'] = date('Y-m-d H:i:s');
        $client_id = $book[0]['client_id'];
        $Condition = "factor_number='{$params['factor_number']}' ";
//        $ModelBase->setTable("report_hotel_tb");
        $resReport = $reportHotelModel->update($d, $Condition);
        /** @var admin $admin */
//        $admin = Load::controller('admin');
//        $res = $admin->ConectDbClient('', $client_id, 'Update', $d, 'book_hotel_local_tb', $Condition);
        $res = $bookHotelLocalModel->updateWithBind($d, $Condition);
        if ($res && $resReport) {
            return 'success |  تغییرات با موفقیت انجام شد';
        }

        return 'error | خطا در  تغییرات';
    }

    public function adminCheckedStatus($params)
    {
        $Condition = "factor_number='{$params['factor_number']}' ";
        $ModelBase = Load::library('ModelBase');
        $ModelBase->setTable("report_hotel_tb");
        $sql = "SELECT * FROM report_hotel_tb WHERE factor_number = '{$params['factor_number']}' GROUP BY room_id";
        $book = $ModelBase->select($sql);
        if (!$book) {
            return 'error | خطا شماره فاکتور';
        }
        $client_id = $book[0]['client_id'];
        $admin_checked = $book[0]['admin_checked'];
        $d['admin_checked'] = ($admin_checked == 1) ? 0 : 1;
        $ModelBase->update($d, $Condition);
        /** @var admin $admin */
        $admin = Load::controller('admin');
        $res = $admin->ConectDbClient('', $client_id, 'Update', $d, 'book_hotel_local_tb', $Condition);
        $result = [
            'status' => 200,
            'message' => 'بروزرسانی انجام شد'
        ];

        return json_encode($result);
    }

    public function generateResearchAddress()
    {
        
        $factor_number = $_POST['factorNumber'] ? $_POST['factorNumber'] : null;
        if(GDS_SWITCH == 'searchHotel' || GDS_SWITCH == 'resultExternalHotel'){
            $base_url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];
            return $url = $base_url . $_SERVER["REQUEST_URI"];
        }
        if(GDS_SWITCH == 'detailHotel'){

            $req = REQUEST_NUMBER;
            $hotel_id = HOTEL_INDEX;
            $type_application = TYPE_APPLICATION;
            $hotel_detail = self::Detail(['requestNumber'=>$req,'hotelIndex'=>$hotel_id]);
            $detail = json_decode($hotel_detail,true);
            $history = $detail['History'];
            //&type=new&city=65&startDate=1401-07-15&nights=2&rooms=R:1-0-0
            $rooms = $history['Rooms'];
            $rooms_string = 'R:1-0-0';
            if(!empty($rooms)){
                $rooms_string = '';
                foreach ($rooms as $room) {
                    $ages = intval(implode($room['Ages']));
                    $rooms_string .= 'R:'.$room['Adults'].'-'.$room['Children'].'-'.$ages;
                }
            }
            $start_date = $history['StartDate'];
            $end_date = $history['EndDate'];
            $nights = strcmp(functions::ConvertToMiladi($end_date),functions::ConvertToMiladi($start_date));
            $get_city = $this->getModel('hotelCitiesModel')->get()->where('city_name',$history['City'])->orWhere('city_name_en',$history['City'])->find();
            if($history['IsInternal']){
                $params = http_build_query([
                    'type'=>'new',
                    'city'=>$get_city['id'],
                    'startDate' => $history['StartDate'],
                    'nights'=>$nights,
                    'rooms'=>$rooms_string
                ]);
                return ROOT_ADDRESS.'/searchHotel?'.$params;
            }else{
                $params = http_build_query([
                    'type'=>'new',
                    'nationality'=>'IR',
                    'country'=> str_replace(' ', '-',$history['Country']),
                    'city'=> str_replace(' ', '-',$history['City']),
                    'start_date'=>$history['StartDate'],
                    'end_date'=>$history['EndDate'],
                    'nights'=>$nights,
                    'rooms'=>$rooms_string
                ]);

                //resultExternalHotel?type=new&&nationality=IR&country=united-arab-emirates&city=dubai-desert-conservation-reserve&start_date=1401-07-11&end_date=1401-07-12&nights=1&rooms=R:1-0-0
                return ROOT_ADDRESS.'/resultExternalHotel?'.$params;
            }
        }
        if(!$factor_number){
            return false;
        }

        /** @var temporaryHotelLocalModel $model */
        $model = $this->getModel('temporaryHotelLocalModel');
        $temp_detail = $model->get(['city_id','is_internal','search_rooms','start_date','end_date','number_night'])
            ->where('factor_number',$factor_number)->find();
        if(!$temp_detail){
            return false;
        }
        $rooms = json_decode($temp_detail['search_rooms'],true);

        $rooms_string = 'R:1-0-0';
        if(!empty($rooms)){
            $rooms_string = '';
            foreach ($rooms as $room) {
                $ages = intval(implode($room['Ages']));
                $rooms_string .= 'R:'.$room['Adults'].'-'.$room['Children'].'-'.$ages;
            }
        }
        if($temp_detail['is_internal'] == '1'){
            $params = http_build_query([
                'type'=>'new',
                'city'=>$temp_detail['city_id'],
                'startDate'=>$temp_detail['start_date'],
                'nights'=>$temp_detail['number_night'],
                'rooms'=>$rooms_string
            ]);
            return $url = ROOT_ADDRESS.'/searchHotel?'.$params;
        }else{

            $get_city = $this->getModel('externalHotelCityModel')->get(['city_name_en','country_name_en'])
                ->where('id',$temp_detail['city_id'])->find();
            $params = http_build_query([
                'type'=>'new',
                'nationality'=>'IR',
                'country'=> str_replace(' ', '-',$get_city['country_name_en']),
                'city'=> str_replace(' ', '-',$get_city['city_name_en']),
                'start_date'=>$temp_detail['start_date'],
                'end_date'=>$temp_detail['end_date'],
                'nights'=>$temp_detail['number_night'],
                'rooms'=>$rooms_string
            ]);

            //resultExternalHotel?type=new&&nationality=IR&country=united-arab-emirates&city=dubai-desert-conservation-reserve&start_date=1401-07-11&end_date=1401-07-12&nights=1&rooms=R:1-0-0
            return $url = ROOT_ADDRESS.'/resultExternalHotel?'.$params;
        }
    }

    public function setOnRequestHotel($factor_number , $counter_type_id ,  $HotelReserveRoom , $type_application){

        /** @var bookHotelLocalModel $book_model */
        $book_model = $this->getModel('bookHotelLocalModel');
        /** @var reportHotelModel $report_model */
        $report_model = $this->getModel('reportHotelModel');
        $book_hotel = $book_model->get()->where('factor_number', $factor_number);
        $hotel_source = $book_hotel->find();

        if($hotel_source['source_id'] != '17' || $hotel_source['source_id'] != '29' ) {
            if ($type_application == 'api'  || $type_application == 'api_app') {
                $book_hotel = $book_hotel->groupBy('room_id');
            }
        }
        $book_hotel = $book_hotel->all();
        $smsController = Load::controller('smsServices') ;

        $d['status'] = 'OnRequest';
        $d['creation_date_int'] = time();

        $Condition = "factor_number='{$factor_number}' ";
        functions::insertLog('first book_hotel_local update api  ' . json_encode($d, 256 | 64), 'hotel_report');
        $res = $book_model->updateWithBind($d, $Condition);
        $res_report = $report_model->updateWithBind($d, $Condition);

        $statusRequestWebService = array();

        $statusRequestWebService['book'] = "OnRequest";
        $statusRequestWebService['factor_number'] = $factor_number;
        $statusRequestWebService['total_price'] = $book_hotel[0]['total_price'];
        $statusRequestWebService['user_type'] = $counter_type_id;
        $statusRequestWebService['api_result'] = $HotelReserveRoom;
        $statusRequestWebService['StatusCode'] = $HotelReserveRoom['StatusCode'];


        //sms to buyer

        $objSms = $smsController->initService('0');
        if ($objSms) {
            if (!empty($book_hotel[0]['member_mobile'])) {
                $mobile = $book_hotel[0]['member_mobile'];
                $name = $book_hotel[0]['member_name'];
            } else {
                $mobile = $book_hotel[0]['passenger_leader_room'];
                $name = $book_hotel[0]['passenger_leader_room_fullName'];
            }

            $on_request_hotel_pattern =   $smsController->getPattern('on_request_hotel');
            if($on_request_hotel_pattern) {
                $smsController->smsByPattern($on_request_hotel_pattern['pattern'], array($mobile), array('customer_name' => CLIENT_NAME , 'hotel_name' => $book_hotel[0]['hotel_name']));
            }else {
                $messageVariables = array(
                    'sms_name' => $name,
                    'sms_service' => 'Ù‡ØªÙ„',
                    'sms_factor_number' => $factor_number,
                    'sms_cost' => $book_hotel[0]['total_price'],
                    'sms_destination' => $book_hotel[0]['city_name'],
                    'sms_hotel_name' => $book_hotel[0]['hotel_name'],
                    'sms_hotel_in' => $book_hotel[0]['start_date'],
                    'sms_hotel_out' => $book_hotel[0]['end_date'],
                    'sms_hotel_night' => $book_hotel[0]['number_night'],
                    'sms_agency' => CLIENT_NAME,
                    'sms_agency_mobile' => CLIENT_MOBILE,
                    'sms_agency_phone' => CLIENT_PHONE,
                    'sms_agency_email' => CLIENT_EMAIL,
                    'sms_agency_address' => CLIENT_ADDRESS,
                );
                $smsArray = array(
                    'smsMessage' => $smsController->getUsableMessage('onRequestHotel', $messageVariables),
                    'cellNumber' => $mobile,
                    'smsMessageTitle' => 'onRequestHotel',
                    'memberID' => $book_hotel[0]['member_id'],
                    'receiverName' => $messageVariables['sms_name'],
                );
                $smsController->sendSMS($smsArray);
            }
        }

        return $statusRequestWebService;
    }

    public function getProfile($param) {
        $result = parent::getProfile($param);
      
        $result = json_decode($result , true);

        return $result; // TODO: Change the autogenerated stub
    }


    public function InsertHotelPnrToDB($data)
    {

        $admin = Load::controller('admin');
        $ModelBase = Load::library('ModelBase');

        $report = '';
        $bookLocal = '';
        $SQl = "SELECT * FROM report_hotel_tb WHERE request_Number='{$data['RequestNumber']}'";

        $Client = $ModelBase->load($SQl);
        $passengers = $ModelBase->select($SQl);


        if (!empty($Client)) {
            foreach ($passengers as $i => $result) {

                $dataPnr['pnr'] = $data['pnr'];


                if (!empty($data['voucher_number'])) {
                    $dataPnr['voucher_number'] = $data['voucher_number'];
                }


                $ClientID = $data['ClientID'];

                $passenger_national_code = $result['passenger_national_code'] ? $result['passenger_national_code'] : $result['passportNumber'];

                $Condition = "request_number='{$data['RequestNumber']}' AND (passportNumber='{$passenger_national_code}' OR passenger_national_code='{$passenger_national_code}')";

                $ModelBase->setTable('report_hotel_tb');
                $report = $ModelBase->update($dataPnr, $Condition);

                $bookLocal = $admin->ConectDbClient("", $ClientID, "Update", $dataPnr, "book_hotel_local_tb", $Condition);


            }

            if ($report && $bookLocal) {
                $this->HotelConvertToBook($data);
                echo 'Success : Ã˜Â¹Ã™â€¦Ã™â€žÃ›Å’Ã˜Â§Ã˜Âª Ã˜Â¨Ã˜Â§ Ã™â€¦Ã™Ë†Ã™ÂÃ™â€šÃ›Å’Ã˜Âª Ã˜Â§Ã™â€ Ã˜Â¬Ã˜Â§Ã™â€¦ Ã˜Â´Ã˜Â¯';
            } else {
                echo 'Error : Ã˜Â®Ã˜Â·Ã˜Â§ Ã˜Â¯Ã˜Â± Ã˜Â§Ã™â€ Ã˜Â¬Ã˜Â§Ã™â€¦ Ã˜Â¹Ã™â€¦Ã™â€žÃ›Å’Ã˜Â§Ã˜Âª';
            }
        } else {
            echo 'Ã˜Â®Ã˜Â·Ã˜Â§ Ã˜Â¯Ã˜Â± Ã˜Â«Ã˜Â¨Ã˜Âª Ã˜Â§Ã˜Â·Ã™â€žÃ˜Â§Ã˜Â¹Ã˜Â§Ã˜Âª';
        }


    }


    public function HotelConvertToBook($data)
    {

        $admin = Load::controller('admin');
        $ModelBase = Load::library('ModelBase');

        $report = '';
        $bookLocal = '';
        $SQl = "SELECT * FROM report_hotel_tb WHERE request_number='{$data['RequestNumber']}'";
        $Hotel = $ModelBase->load($SQl);

        $passengers = $ModelBase->select($SQl);


        error_log('try show result method PnrOfAdmin in : ' . date('Y/m/d H:i:s') . '  array eqaul in => : ' . json_encode($data, true) . " \n", 3, LOGS_DIR . 'PnrOfAdmin.txt');


        if (!empty($Hotel)) {
            foreach ($passengers as $i => $result) {
                $ClientID = $data['ClientID'];
                $dataToBook['payment_type'] = ($Hotel['status'] == 'bank') ? 'cash' : 'credit';
                $dataToBook['status'] = 'BookedSuccessfully';
                $passenger_national_code = $result['passenger_national_code'] ? $result['passenger_national_code'] : $result['passportNumber'];

                $Condition = "request_number='{$data['RequestNumber']}' AND (passportNumber='{$passenger_national_code}' OR passenger_national_code='{$passenger_national_code}')";
                $bookLocal = $admin->ConectDbClient("", $ClientID, "Update", $dataToBook, "book_hotel_local_tb", $Condition);

                $ModelBase->setTable('report_hotel_tb');
                $report = $ModelBase->update($dataToBook, $Condition);

            }

            if ($report && $bookLocal) {

                $dataTransaction['PaymentStatus'] = 'success';
                $Condition = "FactorNumber='{$Hotel['factor_number']}' ";
                $admin->ConectDbClient("", $ClientID, "Update", $dataTransaction, "transaction_tb", $Condition);

                //for admin panel , transaction table
                $dataTransaction['clientID'] = $ClientID;
                $this->transactions->updateTransaction($dataTransaction, $Condition);
            } else {
                echo 'Error : خطا در انجام عملیات';
            }
        } else {
            echo 'خطا در ثبت اطلاعات';
        }
    }
    private function generateBirthdayDate() {
        // Get today's date
        $today = new DateTime();

        // Calculate the maximum year to ensure the person is at least 12 years old
        $maxYear = $today->format('Y') - 12;

        // Generate a random year between 1900 and $maxYear
        $randomYear = rand(1900, $maxYear);

        // Generate a random month and day
        $randomMonth = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
        $randomDay = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT); // Assuming February 28th for simplicity

        // Construct the birthday date string
        return $randomYear . '-' . $randomMonth . '-' . $randomDay;

    }

    private function generateYoungerBirthdayDate() {
        // Get today's date
        $today = new DateTime();

        // Calculate the minimum year to ensure the person is younger than 12 years old
        $minYear = $today->format('Y') - 12 - 1; // Subtracting 1 to ensure the person is not exactly 12 years old

        // Generate a random year between $minYear and the current year
        $randomYear = rand($minYear, $today->format('Y'));

        // Generate a random month and day
        $randomMonth = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
        $randomDay = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT); // Assuming February 28th for simplicity

        // Construct the birthday date string
        return $randomYear . '-' . $randomMonth . '-' . $randomDay;

    }

    private function storeFlightioRoomPrices($factor_number , $priceDetail){
        $result = [] ;
        if(count($priceDetail) > 0  &&  $factor_number) {
           unset($priceDetail['RoomIndex']);
            foreach ($priceDetail as $key => $price) {
                $data_insert['factor_number'] =  $factor_number ;
                $data_insert['room_id'] =  $price['RoomIndex'] ;
                $data_insert['room_index'] =  $key ;
                $data_insert['room_name'] =  $price['RoomName'] ;
                $data_insert['price_current'] =  $price['CalculatedOnline']  ;
                $data_insert['price_online_current'] =  $price['Board'] ;
                $data_insert['price_board_current'] =  $price['Online']  ;

                $flightio_price = $this->getModel('flightioPriceModel');
                $result[] = $flightio_price->insertWithBind($data_insert);
            }

        }
        return $result  ;
    }



}