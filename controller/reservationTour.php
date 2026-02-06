<?php
/**
 * Class reservationTour
 * @property reservationTour $reservationTour
 */
//if(  $_SERVER['REMOTE_ADDR']=='93.118.161.174'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}


//ini_set('memory_limit', '-1');

class reservationTour extends clientAuth
{

    public $id;
    public $countInsertTour = 0;
    public $sqlInsertTour = '';
    public $countInsertTourRout = 0;
    public $sqlInsertTourRout = '';
    public $countInsertTourPackage = 0;
    public $sqlInsertTourPackage = '';
    public $countInsertTourHotel = 0;
    public $sqlInsertTourHotel = '';
    public $reservation_tour_model;
    public $reservation_tour_route_model;
    public $reservation_tour_package_model;
    public $reservation_tour_hotel_model;

    public $reservation_tour_change_price_package_model;
    public $reservation_tour_type_model;
    public $reservation_country_model;
    public $reservation_city_model;
    public $reservation_region_model;
    public $reservation_tour_discount_model;
    public $reservation_hotel_facilities_model;
    public $reservation_hotel_gallery_model;
    public $reservation_facilities_model;
    public $counter_types = array();

    public $book_tour_local_model;
    public $report_tour_local_model;

    public $api ;
    public $noPhotoUrl ;

    public function __construct() {
        parent::__construct();
        $this->noPhotoUrl = 'project_files/images/no-photo.png';
        $this->reservation_tour_model = $this->getModel('reservationTourModel');
        $this->reservation_tour_route_model = $this->getModel('reservationTourRoutModel');
        $this->reservation_tour_package_model = $this->getModel('reservationTourPackageModel');
        $this->reservation_tour_hotel_model = $this->getModel('reservationTourHotelModel');
        $this->reservation_tour_change_price_package_model = $this->getModel('reservationTourChangePricePackageModel');
        $this->reservation_hotel_model = $this->getModel('reservationHotelModel');
        $this->reservation_country_model = $this->getModel('reservationCountryModel');
        $this->reservation_city_model = $this->getModel('reservationCityModel');
        $this->reservation_region_model = $this->getModel('reservationRegionModel');
        $this->reservation_tour_discount_model = $this->getModel('reservationTourDiscountModel');
        $this->reservation_hotel_facilities_model = $this->getModel('reservationHotelFacilitiesModel');
        $this->reservation_hotel_gallery_model = $this->getModel('reservationHotelGalleryModel');
        $this->reservation_facilities_model = $this->getModel('reservationFacilitiesModel');
        $this->book_tour_local_model = $this->getModel('bookTourLocalModel');
        $this->report_tour_local_model = $this->getModel('reportTourModel');
        $this->reservation_tour_type_model = $this->getModel('reservationTourTypeModel');
        $this->master_rate_model = $this->getModel('masterRateModel');

        $info_api = $this->getAccessTourWebService();

        if ($info_api) {
            $this->api = new tourApi($info_api);
        }
    }



    public function infoSiteMap($table) {
        $model = $this->getModel('reservationTourModel');
        $table = $model->getTable();
        $result = $model
            ->get([
                $table . '.*',
            ], true);
        $result = $result
            ->where($table . '.is_del', 'no');
        $result = $result
            ->where($table . '.language', SOFTWARE_LANG);
        $result = $result->groupBy($table . '.id_same')->orderBy($table . '.id_same');
        $result = $result->all(false);


        $result_city = $model
            ->get([
                $table . '.*',
            ], true);
        $result_city = $result_city
            ->where($table . '.is_del', 'no');
        $result_city = $result_city
            ->where($table . '.language', SOFTWARE_LANG);
        $result_city = $result_city->groupBy($table . '.origin_city_id')->orderBy($table . '.id');
        $result_city = $result_city->all(false);


        $result_country = $model
            ->get([
                $table . '.*',
            ], true);
        $result_country = $result_country
            ->where($table . '.is_del', 'no');
        $result_country = $result_country
            ->where($table . '.language', SOFTWARE_LANG);
        $result_country = $result_country->groupBy($table . '.origin_country_id')->orderBy($table . '.id')->limit(20);
        $result_country = $result_country->all(false);

        $data_url_tour_all['loc'] = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/resultTourLocal/1-all/1-all/all/all/0';
        $data_url_tour_all['priority'] = '0.5';
        $data_url_tour_all['lastmodJalali'] = dateTimeSetting::jdate("Y-m-d",time(),'','','en');
        $data_url_tour_all['lastmod'] = functions::ConvertToMiladi($data_url_tour_all['lastmodJalali'], '-');

        $tour_link[] = $data_url_tour_all;
        foreach ($result_country as $key => $item) {
                $url = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/resultTourLocal/1-all/1-' . $item['origin_country_id'] . '/all/all';
                $data_url_country['loc'] = $url;
                $data_url_country['priority'] = '0.5';
                $data_url_country['lastmodJalali'] = $item['create_date_in'];
                $data_url_country['lastmod'] = functions::ConvertToMiladi($data_url_country['lastmodJalali'], '-');

            $data_url_country_all[] = $data_url_country;
        }
        foreach ($result_city as $key => $item) {
                $url = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/resultTourLocal/1-all/' . $item['origin_city_id'] . '-all/all/all';
                $data_url_city['loc'] = $url;
                $data_url_city['priority'] = '0.5';
                $data_url_city['lastmodJalali'] = $item['create_date_in'];
                $data_url_city['lastmod'] = functions::ConvertToMiladi($data_url_city['lastmodJalali'], '-');

            $result_final_city_all[] = $data_url_city;
        }
        foreach ($result as $key => $item) {
            if ($item['tour_name_en']  != '') {
            $tour_slug = str_replace(" ", "-",$item['tour_name_en']);
            $url = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/detailTour/' . $item['id'] . '/' . $tour_slug;
            $data_add_gds_switch['loc'] = $url;
            $data_add_gds_switch['priority'] = '0.5';
            $data_add_gds_switch['lastmodJalali'] = $item['create_date_in'];
            $data_add_gds_switch['lastmod'] = functions::ConvertToMiladi($data_add_gds_switch['lastmodJalali'], '-');

                $result_final[] = $data_add_gds_switch;
        }
        }

//        return [$tour_link , $data_url_country_all, $result_final_city_all , $result_final];
        return [$tour_link ,$data_url_country_all  , $result_final];
    }

    public function getFullDetail($params) {

        $date = explode('|', $params['selectDate']);
        return $this->infoTourByDate($params['tourCode'], $date[0]);
    }

    public function registerBookRecord($params) {


        /** @var factorTourLocal $factorController */
        $factorController = $this->getController('factorTourLocal');

        $_POST = $params;
        $factorController->registerPassengers();
        return $params['factorNumber'];
    }

    public function changeStatus($factorNumber, $status) {

        $book_detail = $this->getModel('bookTourLocalModel')->get(['*'])
            ->where('factor_number' , $factorNumber)->find();
      
        $book_update = $this->getModel('bookTourLocalModel')->updateWithBind([
            'status' => $status
        ], [
            'factor_number' => $factorNumber
        ]);

        $report_update = $this->report_tour_local_model->updateWithBind([
            'status' => $status
        ], [
            'factor_number' => $factorNumber
        ]);
        if($status == 'RequestAccepted') {
//            $sms = 'درخواست رزرو تور '. $book_detail['tour_name'] .' شما توسط ادمین تایید شد.' ;
            $sms = 'درخواست رزرو تور '. $book_detail['tour_name'] .' شما توسط '. CLIENT_NAME .' تایید شد. لطفا در بخش سوابق خرید خود از طریق کد پیگیری ادامه فرایند رزرو را انجام دهید. کد پیگیری: '. $factorNumber .'  با تشکر: '. CLIENT_NAME .'' ;

        }else{
            $sms = 'درخواست رزرو تور '. $book_detail['tour_name'] .' شما توسط ادمین رد شد.' ;
        }


        $smsController = Load::controller('smsServices');
        $objSms = $smsController->initService('0');
        if($objSms) {
            $UserProfileMobile = $book_detail['member_mobile'];

            $smsArray = array(
                'smsMessage' => $sms,
                'cellNumber' => $UserProfileMobile);

            $result = $smsController->sendSMS($smsArray);
        }
        return ($book_update && $report_update);
    }

    public function getRequestPriceChanged($factorNumber) {

        $requestReservationController = $this->getController('requestReservation');
        $request = $requestReservationController->getRequest('tour', $factorNumber);
        if (!$request)
            return 0;
        return $request['price_change'];
    }


    #region daysWeek
    public function daysWeek($daysWeek) {

        $expDaysWeek = explode(",", $daysWeek);
        foreach ($expDaysWeek as $k => $val) {
            $resultDaysWeek['sh' . $val] = $val;
        }

        return $resultDaysWeek;
    }
    #endregion


    #region getDaysWeek
    public function getDaysWeek($idSame) {
        $Model = Load::library('Model');
        $sql = " SELECT start_date
                 FROM reservation_tour_tb 
                 WHERE id_same='{$idSame}' AND is_del='no'
                 ";
        $resultTour = $Model->select($sql);
        $result = array();
        foreach ($resultTour as $val) {
            $y = substr($val['start_date'], 0, 4);
            $m = substr($val['start_date'], 4, 2);
            $d = substr($val['start_date'], 6, 2);
            $jmktime = dateTimeSetting::jmktime(0, 0, 0, $m, $d, $y);
            $nameDay = dateTimeSetting::jdate("w", $jmktime, "", "", "en");
            $result[$nameDay] = $nameDay;
        }
        sort($result);

        return $result;

    }
    #endregion


    //تخصیص کد یکسان برای درج تورها//
    #region getIdSame
    public function getIdSame() {
        $Model = Load::library('Model');
        $sql = "select max(id_same) from reservation_tour_tb ";
        $result = $Model->load($sql);
        if (empty($result)) {
            $id_same = 1;
        } else {
            $id_same = $result['max(id_same)'] + 1;
        }

        return $id_same;
    }
    #endregion

//    جدا کردن فایل های گالری در برنامه سفر
    #region arrayMapMultiFile
    public function arrayMapMultiFile($indexItem, $TargetFileName, $file, $param) {
        foreach ($param['day'] as $keyDay => $Day) {
            foreach ($Day['gallery'] as $keyDaysGallery => $DaysGallery) {
                foreach ($indexItem as $index) {
                    if (!empty($file[$TargetFileName][$index]['day'][$keyDay]['gallery'][$keyDaysGallery]['file'])) {
                        $param['day'][$keyDay]['gallery'][$keyDaysGallery]['file'][$index] = $file[$TargetFileName][$index]['day'][$keyDay]['gallery'][$keyDaysGallery]['file'];
                    }
                }
            }
        }
        return $param;
    }

    #endregion

    public function changeNameUpload($fileName) {
        $ext = explode(".", $fileName);
        $fileName = date("sB") . "-" . rand(10, 10000);
        $ext = strtolower($ext[count($ext) - 1]);
        $fileName = $fileName . "." . $ext;
        return $fileName;
    }

    public function checkTourParams($params, $indexes) {
        foreach ($indexes as $index) {
            if (empty($params[$index[0]])) {
                return [
                    'message' => (empty($index[1]) ? $index[0] : $index[1]) . ' ' . functions::Xmlinformation('Needed')
                ];
            }
        }
        return true;
    }

    #region insertTour
    public function insertTour($param, $file) {


        $custom_file_fields = '';


        if (!empty($param['custom_file_fields'])) {
            $custom_file_fields = json_encode($param['custom_file_fields'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }


        if (isset($param['is_request']) && $param['is_request'] == 'true') {
            $isRequest = 1;
        } else {
            $isRequest = 0;
        }


        $checkTourParams = $this->checkTourParams($param, [
            [
                'destinationCountry1',
                functions::Xmlinformation('Destinationcountry')
            ],
            [
                'destinationCity1',
                functions::Xmlinformation('Destinationcity')
            ],
            [
                'typeVehicle1',
                functions::Xmlinformation('Vehicletype')
            ],
            [
                'airline1',
                functions::Xmlinformation('Shippingcompany')
            ]
        ]);

        if ($checkTourParams !== true) {

            return 'error : ' . $checkTourParams['message'];

        }

        $objController = Load::controller('reservationPublicFunctions');

        $Model = Load::library('Model');

        $sql = " SELECT 
                      id 
                 FROM 
                      reservation_tour_tb 
                 WHERE 
                      tour_code = '{$param['tourCode']}'
                      AND is_del = 'no' ";
        $tour = $Model->load($sql);



        if (empty($tour) && ($param['destinationCountry1'] != '' || $param['destinationCity1'] != '')) {


            $dateNow = dateTimeSetting::jtoday();
            $idSame = $this->getIdSame();
            if (!file_exists(LOGS_DIR . 'EditTour/' . CLIENT_ID . '/')) {
                mkdir(LOGS_DIR . 'EditTour/' . CLIENT_ID . '/', 0777, true);
            }

            $log_name = 'EditTour/' . CLIENT_ID . '/insert_' . $idSame;

            functions::insertLog('******************Start Of the Story*******************', $log_name);
            $config = Load::Config('application');
            $config->pathFile('reservationTour/');
            $objController = Load::controller('reservationPublicFunctions');

            $check_start_date = str_replace("-", "", $param['startDate']);
            $check_end_date = str_replace("-", "", $param['endDate']);
            //////////لیست نام هفته، انتخاب شده///////////
            $days_Week = [];
            for ($sh = 0; $sh <= 6; $sh++) {
                if (isset($param['sh' . $sh]) && $param['sh' . $sh] != '') {
                    $days_Week [] = $param['sh' . $sh];
                }
            }

            $array_check_Days = [];
            $not_array_check_Days = [];

            while ($check_start_date <= $check_end_date) {

                $nameDay_check = $objController->nameDay($check_start_date);

                $day_check = $param['day'] - 1;
                $day_check = ' + ' . $day_check;
                $check_data['end_date'] = $objController->dateNextFewDays($check_start_date, $day_check);
                functions::insertLog('day start end =>' . json_encode([$nameDay_check['numberDay'], $param['day'], $day_check, $check_start_date, $check_data['end_date']], 256), $log_name);

//todo create a boolean var to check if this condition blew has been initiated.
                if (in_array($nameDay_check['numberDay'], $days_Week)) {
                    $filteredArray = [];

                    foreach ($days_Week as $element) {
                        if ($element !== $nameDay_check['numberDay']) {
                            $filteredArray[] = $element;
                        }
                    }
                    $days_Week = array_values($filteredArray);
                    functions::insertLog('after in_array =>' . json_encode([$check_start_date, $days_Week, $nameDay_check['numberDay']], 256), $log_name);
                    if ($check_data['end_date'] <= $check_end_date) {
                        functions::insertLog('in if check =>' . json_encode([$check_start_date, $days_Week, $nameDay_check['numberDay']], 256), $log_name);
                        $array_check_Days[] = true;
                    } else {
                        $array_check_Days[] = false;
                    }
                } else {
                    $not_array_check_Days = $days_Week;
                }
                $check_start_date = $objController->dateNextFewDays($check_start_date, ' + 1');
            }
            functions::insertLog('$not_array_check_Days =>' . json_encode($not_array_check_Days, 256), $log_name);
            functions::insertLog('check day exist =>' . json_encode($array_check_Days, 256), $log_name);

            if (empty($not_array_check_Days) && !in_array(false, $array_check_Days)) {
                if (isset($file['tourPic']) && $file['tourPic'] != "") {
                    $_FILES['tourPic']['name'] = self::changeNameUpload($_FILES['tourPic']['name']);
                    $success = $config->UploadFile("", "tourPic", "");
                    $exp_name_pic = explode(':', $success);
                    if ($exp_name_pic[0] == "done") {
                        $data['tour_pic'] = $exp_name_pic[1];

                    } else {
                        $data['tour_pic'] = '';
                    }

                } else {
                    $data['tour_pic'] = '';
                }

                if (isset($file['tourCover']) && $file['tourCover'] != "") {
                    $_FILES['tourCover']['name'] = self::changeNameUpload($_FILES['tourCover']['name']);
                    $success = $config->UploadFile("pic", "tourCover", "2097152");
                    $exp_name_pic = explode(':', $success);
                    if ($exp_name_pic[0] == "done") {
                        $data['tour_cover'] = $exp_name_pic[1];

                    } else {
                        $data['tour_cover'] = '';
                    }

                } else {
                    $data['tour_cover'] = '';
                }

                if (isset($file['tourFile']) && $file['tourFile'] != "") {

                    $_FILES['tourFile']['name'] = self::changeNameUpload($_FILES['tourFile']['name']);
                    $success = $config->UploadFile("", "tourFile", "");
                    $exp_name_pic = explode(':', $success);
                    if ($exp_name_pic[0] == "done") {
                        $data['tour_file'] = $exp_name_pic[1];

                    } else {
                        $data['tour_file'] = '';
                    }

                } else {
                    $data['tour_file'] = '';
                }


                $fileIndexes = array(
                    'name',
                    'type',
                    'tmp_name',
                    'error',
                    'size');
                $file['TourTravelProgramEdited'] = $this->arrayMapMultiFile($fileIndexes, 'TourTravelProgram', $file, $param['TourTravelProgram']);
                foreach ($file['TourTravelProgramEdited']['day'] as $keyTourTravelProgramDay => $TourTravelProgramDay) {
                    foreach ($TourTravelProgramDay['gallery'] as $keyTourTravelProgramDaysGallery => $TourTravelProgramDaysGallery) {
                        $_FILES['TourTravelProgramForeach'] = @$TourTravelProgramDaysGallery['file'];

                        if (!empty($TourTravelProgramDaysGallery['file']['name'])) {
                            $_FILES['TourTravelProgramForeach']['name'] = self::changeNameUpload($_FILES['TourTravelProgramForeach']['name']);
                            $success = $config->UploadFile("", "TourTravelProgramForeach", "");
                            $exp_name_pic = explode(':', $success);
                            if ($exp_name_pic[0] == "done") {
                                $param['TourTravelProgram']['day'][$keyTourTravelProgramDay]['gallery'][$keyTourTravelProgramDaysGallery]['file'] = $exp_name_pic[1];
                            } else {
                                $param['TourTravelProgram']['day'][$keyTourTravelProgramDay]['gallery'][$keyTourTravelProgramDaysGallery]['file'] = $param['TourTravelProgramEdited']['day'][$keyTourTravelProgramDay]['gallery'][$keyTourTravelProgramDaysGallery]['file_hidden'];
                            }
                        } elseif (!empty($param['TourTravelProgram']['day'][$keyTourTravelProgramDay]['gallery'][$keyTourTravelProgramDaysGallery]['file_hidden'])) {
                            $param['TourTravelProgram']['day'][$keyTourTravelProgramDay]['gallery'][$keyTourTravelProgramDaysGallery]['file'] = $param['TourTravelProgram']['day'][$keyTourTravelProgramDay]['gallery'][$keyTourTravelProgramDaysGallery]['file_hidden'];
                        } else {
                            $param['TourTravelProgram']['day'][$keyTourTravelProgramDay]['gallery'][$keyTourTravelProgramDaysGallery]['file'] = '';
                        }


                    }
                }


                //if (!empty($param['tourTypeId']) && in_array('1', $param['tourTypeId'])) {

                if (!empty($param['id_one_day_only']) && $param['id_one_day_only'] == '1') {
                    $flagOneDayTour = 'yes';
                    $data['night'] = '0';
                    $data['day'] = '1';
                    $param['TourTypes'][] = '1';
                } else {
                    $flagOneDayTour = 'no';
                    $data['night'] = $param['night'];
                    $data['day'] = $param['day'];
                    $param['TourTypes'][] = '2';
                }


                $data['user_id'] = $param['userId'];
                $arrayInfoAgency = functions::infoAgencyByMemberId($param['userId']);
                $country_name = $objController->ShowName('reservation_country_tb', $param['originCountry1']);
                $city_name = $objController->ShowName('reservation_city_tb', $param['originCity1']);
                $region_name = $objController->ShowName('reservation_region_tb', $param['originRegion1']);
                $TourServicesCount = (isset($param['TourServices']) && $param['TourServices']) ? count($param['TourServices']) : 0;
                $result_tour_local_controller = $this->getController('resultTourLocal');
                $TourServicesAll = $result_tour_local_controller->getTourServices();
                $res_diff = array_diff($TourServicesAll, $param['TourServices']);
                $res_diff_count = count($res_diff);

                $TourServices = ($TourServicesCount > 0) ? implode(',', $param['TourServices']) : '';
                $TourServicesNoSelect = ($res_diff_count > 0) ? implode(',', $res_diff) : '';


                $age_categories = array();
                $array_age_categories = array(
                    'AgeCategories_Young',
                    'AgeCategories_Children',
                    'AgeCategories_Teenager',
                    'AgeCategories_Adult',
                    'AgeCategories_UltraAdult');
                foreach ($array_age_categories as $age_category) {
                    if (isset($param[$age_category]) && $param[$age_category] != '') {
                        $age_categories = array_merge($age_categories, array($age_category));
                    }
                }
                $age_categories = (!empty($age_categories) ? json_encode($age_categories) : '');


                $data['agency_id'] = $arrayInfoAgency['fk_agency_id'];
                $data['agency_name'] = isset($arrayInfoAgency['name_fa']) ? $arrayInfoAgency['name_fa'] : '';
                $data['tour_name'] = isset($param['tourName']) ? $param['tourName'] : '';
                $tour_slug = preg_replace('/\s+/', ' ', $param['tourNameEn']);
                $data['tour_name_en'] = $tour_slug;
                $data['tour_code'] = $param['tourCode'];
                $data['tour_video'] = $param['tourVideo'];
                $data['tour_reason'] = $param['tourReason'];
                $data['stop_time_reserve'] = isset($param['stopTimeReserve']) ? $param['stopTimeReserve'] : '';
                $data['stop_time_cancel'] = isset($param['stopTimeCancel']) ? $param['stopTimeCancel'] : '';
                $data['start_time_last_minute_tour'] = '';
                $data['free'] = $param['free'];
                $data['prepayment_percentage'] = $isRequest == 1 ? 0 : (isset($param['prepaymentPercentage']) ? $param['prepaymentPercentage'] : 0);


                $data['visa'] = $param['visa'];
                $data['insurance'] = $param['insurance'];
                $data['description'] = $param['description'];
                $data['required_documents'] = $param['requiredDocuments'];
                $data['rules'] = $param['rules'];
                $data['cancellation_rules'] = $param['cancellationRules'];
                $data['origin_continent_id'] = $param['originContinent1'];
                $data['origin_country_id'] = $param['originCountry1'];
                $data['origin_country_name'] = $country_name;
                $data['origin_city_id'] = $param['originCity1'];
                $data['origin_city_name'] = $city_name;
                $data['origin_region_id'] = $param['originRegion1'];
                $data['origin_region_name'] = $region_name;

//                $data['travel_program'] = $param['travelProgram'];
                $data['create_date_in'] = $dateNow;
                $data['create_time_in'] = date('H:i:s');
                $data['is_show'] = '';
                $data['is_del'] = 'no';
                $data['id_same'] = $idSame;
                $data['tour_status'] = $param['TourStatus'];
                $data['language'] = $param['softwareLanguage'];
                $data['tour_services'] = $TourServices;
                $data['tour_services_not_selected'] = $TourServicesNoSelect;
                $data['tour_difficulties'] = $param['TourDifficulties'];
                $data['age_categories'] = $age_categories;
                $data['suggested'] = '0';
                $data['tour_leader_language'] = $param['TourLeaderLanguage'];
                $data['is_request'] = (isset($param['is_request']) && $param['is_request'] == 'true') ? 1 : 0;
                functions::insertLog('data for insert is ==> ' . json_encode($data, 256 | 64), $log_name);


                //////////لیست نام هفته، انتخاب شده///////////
                $daysWeek = 'NaN,';
                for ($sh = 0; $sh <= 6; $sh++) {
                    if (isset($param['sh' . $sh]) && $param['sh' . $sh] != '') {
                        $daysWeek .= $param['sh' . $sh] . ',';
                    }
                }

                $this->countInsertTour = 0;
                $this->sqlInsertTour = " INSERT INTO reservation_tour_tb VALUES";
                functions::insertLog('first SQl =>' . $this->sqlInsertTour . '=>', $log_name);


                $startDate = str_replace("-", "", $param['startDate']);
                $endDate = str_replace("-", "", $param['endDate']);


                while ($startDate <= $endDate) {
                    $nameDay = $objController->nameDay($startDate);
                    if (strpos($daysWeek, ',' . $nameDay['numberDay'] . ',') > 0) {// اگر این روز انتخاب شده بود//


                        $data['start_date'] = $startDate;
                        $day = $data['day'] - 1;
                        $day = ' + ' . $day;
                        $data['end_date'] = $endDateTour = $objController->dateNextFewDays($startDate, $day);

                        if ($data['end_date'] <= $endDate) {

                            $Model->setTable('reservation_tour_tb');
//                            $res[] = $resTour = $Model->insertLocal($data);
                            $fk_tour_id = $Model->getLastId();
                            $this->countInsertTour++;
                            if ($this->countInsertTour % 100 == 0) {
                                $this->sqlInsertTour = substr($this->sqlInsertTour, 0, -1);
                                $res[] = $Model->execQuery($this->sqlInsertTour);
                                $this->sqlInsertTour = " INSERT INTO reservation_tour_tb VALUES";
                            }
                            $name_fa = isset($arrayInfoAgency['name_fa']) ? $arrayInfoAgency['name_fa'] : "";
                            $this->sqlInsertTour .= "(
                        '',
                        '" . $idSame . "',
                        '" . $param['userId'] . "',
                        '" . $arrayInfoAgency['fk_agency_id'] . "',
                        '" . $name_fa . "',
                        '" . $data['tour_name'] . "',
                        '" . $param['tourNameEn'] . "',
                        '',
                        '',
                        '" . $param['tourCode'] . "',
                        '" . $param['tourReason'] . "',
                        '" . $data['stop_time_reserve'] . "',
                        '" . $data['stop_time_cancel'] . "',
                        '',
                        '" . $param['free'] . "',
                        '" . $startDate . "',
                        '" . $endDateTour . "',
                        '" . $data['night'] . "',
                        '" . $data['day'] . "',
                        '',
                        '" . $data['prepayment_percentage'] . "',
                        '" . $param['visa'] . "',
                        '" . $param['insurance'] . "',
                        '" . $data['tour_pic'] . "',
                        '" . $data['tour_cover'] . "',
                        '" . $data['tour_file'] . "',
                        '" . $param['description'] . "',
                        '" . $param['requiredDocuments'] . "',
                        '" . $param['rules'] . "',
                        '" . $param['cancellationRules'] . "',
                        '" . $param['originContinent1'] . "',
                        '" . $param['originCountry1'] . "',
                        '" . $country_name . "',
                        '" . $param['originCity1'] . "',
                        '" . $city_name . "',
                        '" . $param['originRegion1'] . "',
                        '" . $region_name . "',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '" . $dateNow . "',
                        '" . date('H:i:s') . "',
                        '',
                        '',
                        '',
                        'no',
                        '" . $param['softwareLanguage'] . "',
                        '" . $data['tour_status'] . "',
                        '" . $data['tour_services'] . "',
                        '" . $data['tour_services_not_selected'] . "',
                        '0',
                        '" . $data['tour_difficulties'] . "',
                        '" . $data['age_categories'] . "',
                        '0',
                        '" . $data['tour_leader_language'] . "',
                        '" . $custom_file_fields . "',
                        '" . $isRequest . "',
                         '" . $param['tourVideo'] . "'
                        ),";
                        }


                    }

                    // روز بعدی //
                    $startDate = $objController->dateNextFewDays($startDate, ' + 1');

                }//end while startDate<=endDate


                //ثبت تعداد رکورد کمتر از 100 تا اینجا اتفاق میفتد
                if ($this->sqlInsertTour != '' && $this->countInsertTour > 0) {

                    $this->sqlInsertTour = substr($this->sqlInsertTour, 0, -1);
                    functions::insertLog('sql lt 100 recorde==> ' . $this->sqlInsertTour, $log_name);
                    $res[] = $Model->execQuery($this->sqlInsertTour);

                } else {
                    return 'error : ' . functions::Xmlinformation('NoValidDateForTourEntries');
                }


                $lastTourId = $this->getIdSame() - 1;
                $TourTravelProgramData['tour_id'] = $lastTourId;
                $TourTravelProgramData['data'] = json_encode($param['TourTravelProgram'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT | JSON_HEX_APOS);


                Load::autoload('Model');
                $TourTravelProgramModel = new Model();
                $TourTravelProgramModel->setTable('tourtravelprogram_tb');
                $TourTravelProgramModel->insertLocal($TourTravelProgramData);


                // insert route
                $res[] = $this->registrationRout($param, $idSame);


                // tour type
                $res[] = $this->registrationTourType($idSame, $param['TourTypes']);

                functions::insertLog('after registration tour type==> ' . json_encode($res, 256 | 64), $log_name);

                if (in_array('0', $res)) {
                    functions::insertLog('********************End Of Story IN Error**********************=>' . json_encode($res, 256), $log_name);

                    return 'error :' . functions::Xmlinformation('ErrorChanges');
                }
                functions::insertLog('********************End Of Story IN Success**********************=>' . json_encode($res, 256), $log_name);

                return 'success : ' . functions::Xmlinformation('TourEntrySuccessfullyCompleted') . ' :' . $flagOneDayTour . ':' . '' . ':' . $idSame;

            }else{
                return 'error : ' .functions::Xmlinformation('errorInDateSelect');

            }
            functions::insertLog('********************End Of Story IN Error Finally**********************', $log_name);

            return 'error : ' . functions::Xmlinformation('RepetitiveTourCode');

        }

        return 'error : ' . functions::Xmlinformation('RepetitiveTourCode');

    }
    #endregion


    #region registrationTourType
    public function registrationTourType($idSame, $arrayTypeTour) {


        $type_array = [];
        $reservationTourTypeModel = $this->getModel('reservationTourTypeModel');
        foreach ($arrayTypeTour as $key => $type) {

            if (is_numeric((int)$type) && (int)$type !== 0) {
                $type_result = $reservationTourTypeModel->get()
                    ->where('id', $type)
                    ->find();
                $type_array[] = [
                    'id' => $type_result['id'],
                    'name' => $type_result['tour_type']
                ];
            } else {
                $type_result = $reservationTourTypeModel->get()
                    ->where('tour_type', $type)
                    ->orWhere('tour_type_en', $type)
                    ->find();
                if ($type_result) {
                    $type_result = $type_result['id'];
                } else {
                    $type_result = $reservationTourTypeModel
                        ->insertWithBind([
                            'tour_type' => $type,
                            'member_id' => Session::getUserId(),
                            'is_del' => 'no',
                            'is_approved' => '0',
                        ]);
                }

                $type_array[] = [
                    'id' => $type_result,
                    'name' => $type
                ];
            }
        }


        $type_id_array = [];
        $type_name_array = [];
        $reservationTourTourtypeModel = $this->getModel('reservationTourTourtypeModel');
        $reservationTourTourtypeModel->delete([
            'fk_tour_id_same' => $idSame,
        ]);
        foreach ($type_array as $type) {
            $type_id_array[] = $type['id'];
            $type_name_array[] = $type['name'];
            $reservationTourTourtypeModel
                ->insertWithBind([
                    'is_del' => 'no',
                    'fk_tour_id_same' => $idSame,
                    'fk_tour_type_id' => $type['id'],
                    'fk_tour_type_name' => $type['name'],
                ]);
        }


        return $this->getModel('reservationTourModel')
            ->updateWithBind([
                'tour_type_id' => json_encode($type_id_array, 256),
                'tour_type' => implode('-', $type_name_array),
            ], ['id_same' => $idSame]);


    }


    #region registrationRout
    public function registrationRout($param, $idSame) {


        $objController = Load::controller('reservationPublicFunctions');
        $Model = Load::library('Model');

        $sql = "SELECT id FROM reservation_tour_tb WHERE id_same = '{$idSame}'";
        $resultTour = $Model->select($sql);
        if (!empty($resultTour)) {


            $this->countInsertTourRout = 0;
            $this->sqlInsertTourRout = " INSERT INTO reservation_tour_rout_tb VALUES";


            foreach ($resultTour as $k => $tour) {
                for ($row_counter = 1; $row_counter <= $param['countRowAnyRout']; $row_counter++) {


                    $type_vehicle_name = '';
                    $airline_name = '';
                    $country_name = '';
                    $city_name = '';
                    $region_name = '';
                    if (isset($param['destinationCountry' . $row_counter]) && $param['destinationCountry' . $row_counter] != '') {

                        $type_vehicle_name = $objController->ShowName('reservation_type_of_vehicle_tb', $param['typeVehicle' . $row_counter]);
                        if ($type_vehicle_name == 'هواپیما') {
                            $airline_name = $objController->ShowNameBase('airline_tb', 'name_fa', $param['airline' . $row_counter]);
                        } else {
                            $airline_name = $objController->ShowName('reservation_transport_companies_tb', $param['airline' . $row_counter]);
                        }

                        $country_name = $objController->ShowName('reservation_country_tb', $param['destinationCountry' . $row_counter]);
                        $city_name = $objController->ShowName('reservation_city_tb', $param['destinationCity' . $row_counter]);
                        if (isset($param['destinationRegion' . $row_counter]) && $param['destinationRegion' . $row_counter] != '') {
                            $region_name = $objController->ShowName('reservation_region_tb', $param['destinationRegion' . $row_counter]);
                        }

                        $night = (!empty($param['night' . $row_counter])) ? $param['night' . $row_counter] : 0;
                        $day = (!empty($param['day' . $row_counter])) ? $param['day' . $row_counter] : 0;


                        /*$dataRout['tour_title'] = $param['tourTitle' . $i];
                        $dataRout['night'] = $night;
                        $dataRout['day'] = $day;
                        $dataRout['destination_continent_id'] = $param['destinationContinent' . $i];
                        $dataRout['destination_country_id'] = $param['destinationCountry' . $i];
                        $dataRout['destination_country_name'] = $country_name;
                        $dataRout['destination_city_id'] = $param['destinationCity' . $i];
                        $dataRout['destination_city_name'] = $city_name;
                        $dataRout['destination_region_id'] = $param['destinationRegion' . $i];
                        $dataRout['destination_region_name'] = $region_name;
                        $dataRout['type_vehicle_id'] = $param['typeVehicle' . $i];
                        $dataRout['type_vehicle_name'] = $type_vehicle_name;
                        $dataRout['airline_id'] = $param['airline' . $i];
                        $dataRout['airline_name'] = $airline_name;
                        $dataRout['class'] = $param['class' . $i];
                        $dataRout['exit_hours'] = $param['exitHours' . $i] . ':' . $param['exitMinutes' . $i];
                        $dataRout['hours'] = $param['hours' . $i] . ':' . $param['minutes' . $i];
                        $dataRout['is_del'] = 'no';
                        $dataRout['fk_tour_id'] = $tour['id'];

                        $Model->setTable('reservation_tour_rout_tb');
                        $res[] = $Model->insertLocal($dataRout);*/

                        $this->countInsertTourRout++;

                        if ($this->countInsertTourRout % 100 == 0) {
                            $this->sqlInsertTourRout = substr($this->sqlInsertTourRout, 0, -1);
                            $res[] = $Model->execQuery($this->sqlInsertTourRout);
                            $this->sqlInsertTourRout = " INSERT INTO reservation_tour_rout_tb VALUES";
                        }

                        $is_route_fake = isset($param['is_route_fake' . $row_counter]) ? $param['is_route_fake' . $row_counter] : 1;
                        $this->sqlInsertTourRout .= "(
                            '',
                            '" . $tour['id'] . "',
                            '" . $param['tourTitle' . $row_counter] . "',
                            '" . $row_counter . "',
                            '" . $night . "',
                            '" . $day . "',
                            '" . $param['destinationContinent' . $row_counter] . "',
                            '" . $param['destinationCountry' . $row_counter] . "',
                            '" . $country_name . "',
                            '" . $param['destinationCity' . $row_counter] . "',
                            '" . $city_name . "',
                            '" . $param['destinationRegion' . $row_counter] . "',
                            '" . $region_name . "',
                            '" . $param['typeVehicle' . $row_counter] . "',
                            '" . $type_vehicle_name . "',
                            '" . $param['airline' . $row_counter] . "',
                            '" . $airline_name . "',
                            '" . $param['class' . $row_counter] . "',
                            '" . $param['exitHours' . $row_counter] . ':' . $param['exitMinutes' . $row_counter] . "',
                            '" . $param['hours' . $row_counter] . ':' . $param['minutes' . $row_counter] . "',
                            'no',
                            '" . $is_route_fake . "'
                            ),";

                    }

                }

            }


            //ثبت تعداد رکورد کمتر از 100 تا اینجا اتفاق میفتد
            if ($this->sqlInsertTourRout != '' && $this->countInsertTourRout > 0) {
                $this->sqlInsertTourRout = substr($this->sqlInsertTourRout, 0, -1);


                $res[] = $Model->execQuery($this->sqlInsertTourRout);
            }

        }

        if (isset($res) && in_array('0', $res)) {
            return false;
        } else {
            return true;
        }

    }
    #endregion


    #region insertPackageTour
    public function insertPackageTour($param) {

        functions::insertLog('first function ==>' . json_encode($param, 256), 'check_discount_counter');

        $temp_array_edit_tour = [];
        foreach ($param['data'] as $edit_tour) {

            $temp_array_edit_tour[$edit_tour['name']] = $edit_tour['value'];
        }


        $param = $temp_array_edit_tour;


        $result_tour_local_controller = $this->getController('resultTourLocal');
        $counter_type_controller = $this->getController('counterType');
        $counter_types = $counter_type_controller->getAll('all');
        $counter_types = $counter_type_controller->list;
        $objController = Load::controller('reservationPublicFunctions');
        $Model = Load::library('Model');

        $sql = " SELECT id  FROM reservation_tour_tb WHERE id_same = '{$param['id_same']}' ";
        $resultTour = $Model->select($sql);
        if (!empty($resultTour)) {

            $this->countInsertTourPackage = 0;
            $this->sqlInsertTourPackage = " INSERT INTO reservation_tour_package_tb VALUES";

            foreach ($resultTour as $k => $tour) {

                $fk_tour_id = $tour['id'];
                for ($countPackage = 1; $countPackage <= $param['countPackage']; $countPackage++) {

                    if (isset($param['doubleRoomPriceR' . $countPackage]) && $param['doubleRoomPriceR' . $countPackage] != '') {

                        $dataPackage['three_room_price_r'] = str_ireplace(",", "", $param['threeRoomPriceR' . $countPackage]);
                        $dataPackage['three_room_price_a'] = str_ireplace(",", "", $param['threeRoomPriceA' . $countPackage]);
                        $dataPackage['double_room_price_r'] = str_ireplace(",", "", $param['doubleRoomPriceR' . $countPackage]);
                        $dataPackage['double_room_price_a'] = str_ireplace(",", "", $param['doubleRoomPriceA' . $countPackage]);
                        $dataPackage['single_room_price_r'] = str_ireplace(",", "", $param['singleRoomPriceR' . $countPackage]);
                        $dataPackage['single_room_price_a'] = str_ireplace(",", "", $param['singleRoomPriceA' . $countPackage]);
                        $dataPackage['child_with_bed_price_r'] = str_ireplace(",", "", $param['childWithBedPriceR' . $countPackage]);
                        $dataPackage['child_with_bed_price_a'] = str_ireplace(",", "", $param['childWithBedPriceA' . $countPackage]);
                        $dataPackage['infant_without_bed_price_r'] = str_ireplace(",", "", $param['infantWithoutBedPriceR' . $countPackage]);
                        $dataPackage['infant_without_bed_price_a'] = str_ireplace(",", "", $param['infantWithoutBedPriceA' . $countPackage]);
                        $dataPackage['infant_without_chair_price_r'] = str_ireplace(",", "", $param['infantWithoutChairPriceR' . $countPackage]);
                        $dataPackage['infant_without_chair_price_a'] = str_ireplace(",", "", $param['infantWithoutChairPriceA' . $countPackage]);
                        $dataPackage['three_room_capacity'] = ($param['threeRoomCapacity' . $countPackage] >= 0) ? $param['threeRoomCapacity' . $countPackage] : 9;
                        $dataPackage['double_room_capacity'] = ($param['doubleRoomCapacity' . $countPackage] >= 0) ? $param['doubleRoomCapacity' . $countPackage] : 9;
                        $dataPackage['single_room_capacity'] = ($param['singleRoomCapacity' . $countPackage] >= 0) ? $param['singleRoomCapacity' . $countPackage] : 9;
                        $dataPackage['child_with_bed_capacity'] = ($param['childWithBedCapacity' . $countPackage] >= 0) ? $param['childWithBedCapacity' . $countPackage] : 9;
                        $dataPackage['infant_without_bed_capacity'] = ($param['infantWithoutBedCapacity' . $countPackage] >= 0) ? $param['infantWithoutBedCapacity' . $countPackage] : 9;
                        $dataPackage['infant_without_chair_capacity'] = ($param['infantWithoutChairCapacity' . $countPackage] >= 0) ? $param['infantWithoutChairCapacity' . $countPackage] : 9;
                        $custom_room = [];

                        if (isset($param['fourRoomPriceR' . $countPackage]) || isset($param['fourRoomPriceA' . $countPackage])) {
                            $custom_room[]['fourRoom'] = [
                                'price_r' => str_ireplace(",", "", $param['fourRoomPriceR' . $countPackage]),
                                'price_a' => str_ireplace(",", "", $param['fourRoomPriceA' . $countPackage]),
                                'capacity' => ($param['fourRoomCapacity' . $countPackage] >= 0) ? $param['fourRoomCapacity' . $countPackage] : 9
                            ];
                        }
                        if (isset($param['fiveRoomPriceR' . $countPackage]) || isset($param['fiveRoomPriceA' . $countPackage])) {
                            $custom_room[]['fiveRoom'] = [
                                'price_r' => str_ireplace(",", "", $param['fiveRoomPriceR' . $countPackage]),
                                'price_a' => str_ireplace(",", "", $param['fiveRoomPriceA' . $countPackage]),
                                'capacity' => ($param['fiveRoomCapacity' . $countPackage] >= 0) ? $param['fiveRoomCapacity' . $countPackage] : 9
                            ];

                        }
                        if (isset($param['sixRoomPriceR' . $countPackage]) || isset($param['sixRoomPriceA' . $countPackage])) {

                            $custom_room[]['sixRoom'] = [
                                'price_r' => str_ireplace(",", "", $param['sixRoomPriceR' . $countPackage]),
                                'price_a' => str_ireplace(",", "", $param['sixRoomPriceA' . $countPackage]),
                                'capacity' => ($param['sixRoomCapacity' . $countPackage] >= 0) ? $param['sixRoomCapacity' . $countPackage] : 9
                            ];
                        }


                        $objCurrency = Load::controller('currencyEquivalent');
                        $infoCurrency = isset($param['currencyType' . $countPackage]) ? $objCurrency->InfoCurrency($param['currencyType' . $countPackage]) : null;
                        $dataPackage['currency_type'] = (isset($infoCurrency['CurrencyTitleFa']) && $infoCurrency['CurrencyTitleFa'] != '') ? $infoCurrency['CurrencyTitleFa'] : '';

                        $dataPackage['number_package'] = $countPackage;
                        $dataPackage['is_del'] = 'no';


                        /*$dataPackage['fk_tour_id'] = $fk_tour_id;
                        $Model->setTable('reservation_tour_package_tb');
                        $res[] = $Model->insertLocal($dataPackage);*/

                        /*$fk_tour_package_id = $Model->getLastId();
                        for ($countHotel = 0; $countHotel <= $param['countHotel' . $countPackage]; $countHotel++) {
                            if (isset($param['hotelId' . $countPackage . $countHotel]) && $param['hotelId' . $countPackage . $countHotel] != '') {
                                $hotel_name = $objController->ShowName('reservation_hotel_tb', $param['hotelId' . $countPackage . $countHotel]);

                                $dataHotel['fk_city_id'] = $param['cityId' . $countPackage . $countHotel];
                                $dataHotel['city_name'] = $param['cityName' . $countPackage . $countHotel];
                                $dataHotel['fk_hotel_id'] = $param['hotelId' . $countPackage . $countHotel];
                                $dataHotel['hotel_name'] = $hotel_name;
                                $dataHotel['room_service'] = $param['roomService' . $countPackage . $countHotel];
                                $dataHotel['room_type'] = $param['roomType' . $countPackage . $countHotel];
                                $dataHotel['is_del'] = 'no';

                                $dataHotel['fk_tour_id'] = $fk_tour_id;
                                $dataHotel['fk_tour_package_id'] = $fk_tour_package_id;
                                $Model->setTable('reservation_tour_hotel_tb');
                                $res[] = $Model->insertLocal($dataHotel);

                            }
                        }*/

                        $this->countInsertTourPackage++;
                        if ($this->countInsertTourPackage % 100 == 0) {
                            $this->sqlInsertTourPackage = substr($this->sqlInsertTourPackage, 0, -1);

                            $res[] = $Model->execQuery($this->sqlInsertTourPackage);
                            $this->sqlInsertTourPackage = " INSERT INTO reservation_tour_package_tb VALUES";
                        }

                        $this->sqlInsertTourPackage .= "(
                            '',
                            '" . $fk_tour_id . "',
                            '" . $dataPackage['three_room_price_r'] . "',
                            '" . $dataPackage['three_room_price_a'] . "',
                            '" . $dataPackage['double_room_price_r'] . "',
                            '" . $dataPackage['double_room_price_a'] . "',
                            '" . $dataPackage['single_room_price_r'] . "',
                            '" . $dataPackage['single_room_price_a'] . "',
                            '" . $dataPackage['child_with_bed_price_r'] . "',
                            '" . $dataPackage['child_with_bed_price_a'] . "',
                            '" . $dataPackage['infant_without_bed_price_r'] . "',
                            '" . $dataPackage['infant_without_bed_price_a'] . "',
                            '" . $dataPackage['infant_without_chair_price_r'] . "',
                            '" . $dataPackage['infant_without_chair_price_a'] . "',
                            '" . $dataPackage['currency_type'] . "',
                            '" . $dataPackage['three_room_capacity'] . "',
                            '" . $dataPackage['double_room_capacity'] . "',
                            '" . $dataPackage['single_room_capacity'] . "',
                            '" . $dataPackage['child_with_bed_capacity'] . "',
                            '" . $dataPackage['infant_without_bed_capacity'] . "',
                            '" . $dataPackage['infant_without_chair_capacity'] . "',
                            '" . $dataPackage['number_package'] . "',
                            '" . json_encode($custom_room, 256) . "',
                            'no'
                            ),";


                    }
                }

            }
            //ثبت تعداد رکورد کمتر از 100 تا اینجا اتفاق میفتد
            if ($this->sqlInsertTourPackage != '' && $this->countInsertTourPackage > 0) {
                $this->sqlInsertTourPackage = substr($this->sqlInsertTourPackage, 0, -1);
                $res[] = $Model->execQuery($this->sqlInsertTourPackage);
            }


            foreach ($resultTour as $k => $tour) {
                $sqlTourPackage = "SELECT id FROM reservation_tour_package_tb WHERE fk_tour_id = '{$tour['id']}'";
                $resultTourPackage = $Model->select($sqlTourPackage);
                if (!empty($resultTourPackage)) {

                    $this->countInsertTourHotel = 0;
                    $this->sqlInsertTourHotel = " INSERT INTO reservation_tour_hotel_tb VALUES";

                    $count = 0;
                    foreach ($resultTourPackage as $tourPackage) {
                        $count++;
                        for ($countHotel = 0; $countHotel <= $param['countHotel' . $count]; $countHotel++) {
                            if (isset($param['hotelId' . $count . $countHotel]) && $param['hotelId' . $count . $countHotel] != '') {
                                $hotel_name = $objController->ShowName('reservation_hotel_tb', $param['hotelId' . $count . $countHotel]);

                                /*$dataHotel['fk_city_id'] = $param['cityId' . $count . $countHotel];
                                $dataHotel['city_name'] = $param['cityName' . $count . $countHotel];
                                $dataHotel['fk_hotel_id'] = $param['hotelId' . $count . $countHotel];
                                $dataHotel['hotel_name'] = $hotel_name;
                                $dataHotel['room_service'] = $param['roomService' . $count . $countHotel];
                                $dataHotel['room_type'] = $param['roomType' . $count . $countHotel];
                                $dataHotel['is_del'] = 'no';

                                $dataHotel['fk_tour_id'] = $tour['id'];
                                $dataHotel['fk_tour_package_id'] = $tourPackage['id'];
                                $Model->setTable('reservation_tour_hotel_tb');
                                $res[] = $Model->insertLocal($dataHotel);*/

                                $this->countInsertTourHotel++;
                                if ($this->countInsertTourHotel % 100 == 0) {
                                    $this->sqlInsertTourHotel = substr($this->sqlInsertTourHotel, 0, -1);
                                    $res[] = $Model->execQuery($this->sqlInsertTourHotel);
                                    $this->sqlInsertTourHotel = " INSERT INTO reservation_tour_hotel_tb VALUES";
                                }
                                $this->sqlInsertTourHotel .= "(
                                    '',
                                    '" . $tour['id'] . "',
                                    '" . $tourPackage['id'] . "',
                                    '" . $param['cityId' . $count . $countHotel] . "',
                                    '" . $param['cityName' . $count . $countHotel] . "',
                                    '" . $param['hotelId' . $count . $countHotel] . "',
                                    '" . $hotel_name . "',
                                    '" . $param['roomService' . $count . $countHotel] . "',
                                    '" . $param['roomType' . $count . $countHotel] . "',
                                    'no'
                                    ),";

                            }
                        }
                    }

                    //ثبت تعداد رکورد کمتر از 100 تا اینجا اتفاق میفتد
                    if ($this->sqlInsertTourHotel != '' && $this->countInsertTourHotel > 0) {
                        $this->sqlInsertTourHotel = substr($this->sqlInsertTourHotel, 0, -1);
                        $res[] = $Model->execQuery($this->sqlInsertTourHotel);


                        $this->reservation_tour_discount_model->delete([
                            'tour_package_id' => $tourPackage['id']
                        ]);

                        foreach ($counter_types as $type_key => $type) {
                            $discount_params = [];
                            foreach ($result_tour_local_controller->tourDiscountFieldsIndex() as $discount_index_key => $discount_index) {

                                functions::insertLog('count=>' . $count . 'params==>' . json_encode($param, 256), 'check_discount_counter');

                                $discount_params[$discount_index['index']] = str_replace(',', '', $param[$discount_index['index'] . $count . $type_key]);
                            }
                            $reservation_tour_discount_data = [
                                'tour_id' => $tour['id'],
                                'tour_package_id' => $tourPackage['id'],
                                'counter_type_id' => $type['id'],
                            ];
                            $reservation_tour_discount_data = array_merge($reservation_tour_discount_data, $discount_params);
                            $this->reservation_tour_discount_model->insertWithBind($reservation_tour_discount_data);
                        }

                    }

                }
            }


        } else {

            return functions::withError(null, 401, functions::Xmlinformation('ErrorChanges')->__toString());
        }


        if (isset($res) && in_array('0', $res)) {
            return functions::withError(null, 401, functions::Xmlinformation('ErrorChanges')->__toString());

        } else {
            return functions::withSuccess($param['id_same'], 200, functions::Xmlinformation('TourEntrySuccessfullyCompleted')->__toString());

        }

    }
    #endregion


    #region insertOneDayTour
    public function insertOneDayTour($param) {
        $Model = Load::library('Model');

        $temp_array_one_day_tour = [];
        foreach ($param['data'] as $one_day_tour) {

            $temp_array_one_day_tour[$one_day_tour['name']] = $one_day_tour['value'];
        }


        $param = $temp_array_one_day_tour;


        $data['adult_price_one_day_tour_r'] = str_ireplace(",", "", $param['adultPriceOneDayTourR']);
        $data['child_price_one_day_tour_r'] = str_ireplace(",", "", $param['childPriceOneDayTourR']);
        $data['infant_price_one_day_tour_r'] = str_ireplace(",", "", $param['infantPriceOneDayTourR']);
        $data['adult_price_one_day_tour_a'] = str_ireplace(",", "", $param['adultPriceOneDayTourA']);
        $data['child_price_one_day_tour_a'] = str_ireplace(",", "", $param['childPriceOneDayTourA']);
        $data['infant_price_one_day_tour_a'] = str_ireplace(",", "", $param['infantPriceOneDayTourA']);

        if (isset($param['currencyTypeOneDayTour']) && $param['currencyTypeOneDayTour'] != '') {
            $objCurrency = Load::controller('currencyEquivalent');
            $infoCurrency = $objCurrency->InfoCurrency($param['currencyTypeOneDayTour']);
            $data['currency_type_one_day_tour'] = $infoCurrency['CurrencyTitleFa'];
        } else {
            $data['currency_type_one_day_tour'] = '';
        }


        $condition = "id_same={$param['id_same']}";
        $Model->setTable('reservation_tour_tb');
        $res = $Model->update($data, $condition);

        if ($res) {
            $result_tour_local_controller = $this->getController('resultTourLocal');
            $counter_type_controller = $this->getController('counterType');
            $counter_types = $counter_type_controller->listCounterType();
            $this->reservation_tour_discount_model->delete([
                'tour_id' => $param['id_same']
            ]);

            foreach ($counter_types as $type_key => $type) {
                $discounts = $result_tour_local_controller->tourDiscountFieldsIndex();

                $reservation_tour_discount_data = [
                    'tour_id' => $param['id_same'],
                    'tour_package_id' => 0,
                    'counter_type_id' => $type['id'],
                ];

                foreach ($discounts as $discount_index_key => $discount_index) {
                    functions::insertLog('first function ==>' . json_encode($param, $param[$discount_index['index'] . $type_key], 256), 'check_discount_counter');
                    $reservation_tour_discount_data[$discount_index['index']] = str_replace(',', '', $param[$discount_index['index'] . $type_key]);
                }


                $this->reservation_tour_discount_model->insertWithBind($reservation_tour_discount_data);
            }

            return functions::withSuccess($param['id_same'], 200, functions::Xmlinformation('TourEntrySuccessfullyCompleted')->__toString());

        } else {
            return functions::withError(null, 401, functions::Xmlinformation('ErrorChanges')->__toString());
        }

    }
    #endregion


    #region editTour
    public function editTour($param, $file) {

        try {

            $infoTourById = $this->infoTourById($param['tourId']);

            $Model = Load::library('Model');


            $config = Load::Config('application');
            $config->pathFile('reservationTour/');
            /*if (isset($file['tourPic']) && $file['tourPic'] != "") {

                $success = $config->UploadFile("", "tourPic", "");
                $exp_name_pic = explode(':', $success);
                if ($exp_name_pic[0] == "done") {
                    $data['tour_pic'] = $exp_name_pic[1];

                }

            }*/
            if (isset($file['tourFile']) && $file['tourFile'] != "") {
                $_FILES['tourFile']['name'] = self::changeNameUpload($_FILES['tourFile']['name']);
                $success = $config->UploadFile("", "tourFile", "");
                $exp_name_pic = explode(':', $success);
                if ($exp_name_pic[0] == "done") {
                    $data['tour_file'] = $exp_name_pic[1];

                }

            }

            if (isset($param['is_request']) && $param['is_request'] == 'true') {
                $isRequest = 1;
            } else {
                $isRequest = 0;
            }


            $dateNow = dateTimeSetting::jtoday();
            $idSame = $infoTourById['id_same'];

            if (isset($param['flagOneDayTour']) && $param['flagOneDayTour'] == 'yes') {
                //array_push($param['tourTypeId'], "1");
                $param['tourTypeId'] = ['0' => '1'];
                $data['night'] = '0';
                $data['day'] = '1';
            } else {

                if(isset($infoTourById['tour_type_id'])) {
                    $tour_type_list = json_decode($infoTourById['tour_type_id']);
                    foreach ($tour_type_list as $key => $tour_type) {
                        $tour_types[$key] = $tour_type;
                     }

                    $param['tourTypeId'] = $tour_types;
                }else{
                    $param['tourTypeId'] = ['0' => '2'];
                }

                $data['night'] = $param['night'];
                $data['day'] = $param['day'];
            }

            $data['id_same'] = $idSame;
            $data['tour_name'] = $param['tourName'];
            $data['tour_video'] = $param['tourVideo'];
            $tour_slug = preg_replace('/\s+/', ' ', $param['tourNameEn']);
            $data['tour_name_en'] = $tour_slug;
//        $data['tour_name_en'] = $param['tourNameEn'];
            $data['tour_reason'] = $param['tourReason'];
            $data['stop_time_reserve'] = $param['stopTimeReserve'];
            $data['stop_time_cancel'] = $param['stopTimeCancel'];
            $data['start_time_last_minute_tour'] = '';
            $data['start_date'] = str_replace("-", "", $param['startDate']);
            $data['end_date'] = str_replace("-", "", $param['endDate']);
            $data['prepayment_percentage'] = $isRequest == 1 ? 0 : $param['prepaymentPercentage'];

            $data['visa'] = $param['visa'];
            $data['insurance'] = $param['insurance'];
            $data['description'] = $param['description'];
            $data['required_documents'] = $param['requiredDocuments'];
            $data['rules'] = $param['rules'];
            $data['cancellation_rules'] = $param['cancellationRules'];
            $data['travel_program'] = $param['travelProgram'];
            $data['change_price'] = '';
            $data['comment_cancel'] = '';
            $data['create_date_in'] = $dateNow;
            $data['create_time_in'] = date('H:i:s');

//                $data['is_show'] = '';
            $data['is_del'] = 'no';


            $condition = "id={$param['tourId']}";
            $Model->setTable('reservation_tour_tb');

            $res[] = $resTour = $Model->update($data, $condition);

            if ($resTour) {
                $res[] = $this->editRout($param);
            }

         
            if (!empty($param['tourTypeId'])) {
                // tour type
                $res[] = $this->registrationTourType($idSame, $param['tourTypeId']);
            }
            return 'success : ' . functions::Xmlinformation('TourEntrySuccessfullyCompleted') . ' ' . ':' . $idSame;

        } catch (PDOException $e) {
            return 'error ' . functions::Xmlinformation('ErrorChanges');
        }
    }
    #endregion


    #region editPackageTour
    public function editPackageTour($param) {


        $objController = Load::controller('reservationPublicFunctions');
        $Model = Load::library('Model');


        // اگر تغییر قیمت داشت لاگ در جدول ثبت بشه //
        $this->checkForPricesChange($param);

        for ($countPackage = 1; $countPackage <= $param['countPackage']; $countPackage++) {
            if (isset($param['doubleRoomPriceR' . $countPackage]) && $param['doubleRoomPriceR' . $countPackage] != '') {

                $dataPackage['three_room_price_r'] = str_ireplace(",", "", $param['threeRoomPriceR' . $countPackage]);
                $dataPackage['three_room_price_a'] = str_ireplace(",", "", $param['threeRoomPriceA' . $countPackage]);
                $dataPackage['double_room_price_r'] = str_ireplace(",", "", $param['doubleRoomPriceR' . $countPackage]);
                $dataPackage['double_room_price_a'] = str_ireplace(",", "", $param['doubleRoomPriceA' . $countPackage]);
                $dataPackage['single_room_price_r'] = str_ireplace(",", "", $param['singleRoomPriceR' . $countPackage]);
                $dataPackage['single_room_price_a'] = str_ireplace(",", "", $param['singleRoomPriceA' . $countPackage]);
                $dataPackage['child_with_bed_price_r'] = str_ireplace(",", "", $param['childWithBedPriceR' . $countPackage]);
                $dataPackage['child_with_bed_price_a'] = str_ireplace(",", "", $param['childWithBedPriceA' . $countPackage]);
                $dataPackage['infant_without_bed_price_r'] = str_ireplace(",", "", $param['infantWithoutBedPriceR' . $countPackage]);
                $dataPackage['infant_without_bed_price_a'] = str_ireplace(",", "", $param['infantWithoutBedPriceA' . $countPackage]);
                $dataPackage['infant_without_chair_price_r'] = str_ireplace(",", "", $param['infantWithoutChairPriceR' . $countPackage]);
                $dataPackage['infant_without_chair_price_a'] = str_ireplace(",", "", $param['infantWithoutChairPriceA' . $countPackage]);
                $dataPackage['three_room_capacity'] = ($param['threeRoomCapacity' . $countPackage] >= 0) ? $param['threeRoomCapacity' . $countPackage] : 9;
                $dataPackage['double_room_capacity'] = ($param['doubleRoomCapacity' . $countPackage] >= 0) ? $param['doubleRoomCapacity' . $countPackage] : 9;
                $dataPackage['single_room_capacity'] = ($param['singleRoomCapacity' . $countPackage] >= 0) ? $param['singleRoomCapacity' . $countPackage] : 9;
                $dataPackage['child_with_bed_capacity'] = ($param['childWithBedCapacity' . $countPackage] >= 0) ? $param['childWithBedCapacity' . $countPackage] : 9;
                $dataPackage['infant_without_bed_capacity'] = ($param['infantWithoutBedCapacity' . $countPackage] >= 0) ? $param['infantWithoutBedCapacity' . $countPackage] : 9;
                $dataPackage['infant_without_chair_capacity'] = ($param['infantWithoutChairCapacity' . $countPackage] >= 0) ? $param['infantWithoutChairCapacity' . $countPackage] : 9;


                $objCurrency = Load::controller('currencyEquivalent');
                $infoCurrency = $objCurrency->InfoCurrency($param['currencyType' . $countPackage]);
                $dataPackage['currency_type'] = $infoCurrency['CurrencyTitleFa'];

                $dataPackage['number_package'] = $countPackage;
                $dataPackage['is_del'] = 'no';


                if (isset($param['packageId' . $countPackage]) && $param['packageId' . $countPackage] != '') {

                    $condition = "id={$param['packageId' . $countPackage]}";
                    $Model->setTable('reservation_tour_package_tb');
                    $res[] = $Model->update($dataPackage, $condition);
                    $fk_tour_package_id = '';

                } else {

                    $dataPackage['fk_tour_id'] = $param['fk_tour_id'];
                    $Model->setTable('reservation_tour_package_tb');
                    $res[] = $Model->insertLocal($dataPackage);
                    $fk_tour_package_id = $Model->getLastId();
                }


                for ($countHotel = 0; $countHotel <= $param['countHotel' . $countPackage]; $countHotel++) {
                    if (isset($param['hotelId' . $countPackage . $countHotel]) && $param['hotelId' . $countPackage . $countHotel] != '') {

                        $hotel_name = $objController->ShowName('reservation_hotel_tb', $param['hotelId' . $countPackage . $countHotel]);

                        $dataHotel['fk_city_id'] = $param['cityId' . $countPackage . $countHotel];
                        $dataHotel['city_name'] = $param['cityName' . $countPackage . $countHotel];
                        $dataHotel['fk_hotel_id'] = $param['hotelId' . $countPackage . $countHotel];
                        $dataHotel['hotel_name'] = $hotel_name;
                        $dataHotel['room_service'] = $param['roomService' . $countPackage . $countHotel];
                        $dataHotel['room_type'] = $param['roomType' . $countPackage . $countHotel];
                        $dataHotel['is_del'] = 'no';

                        if ($fk_tour_package_id == '') {

                            $condition = "id={$param['hotelId' . $countPackage . $countHotel]}";
                            $Model->setTable('reservation_tour_hotel_tb');
                            $res[] = $Model->update($dataHotel, $condition);

                        } else {

                            $dataHotel['fk_tour_id'] = $param['fk_tour_id'];
                            $dataHotel['fk_tour_package_id'] = $fk_tour_package_id;
                            $Model->setTable('reservation_tour_hotel_tb');
                            $res[] = $Model->insertLocal($dataHotel);
                        }

                    }
                }

            }
        }


        if (isset($res) && in_array('0', $res)) {
            return 'error : ' . functions::Xmlinformation("ErrorChanges");
        }

        return 'success :' . functions::Xmlinformation("TourEntrySuccessfullyCompleted") . ':' . $param['id_same'];


    }
    #endregion


    #region editOneDayTour
    public function editOneDayTour($param) {
        $Model = Load::library('Model');
        $dateNow = dateTimeSetting::jtoday();
        $temp_array_edit_one_day_tour = [];
        foreach ($param['data'] as $one_day_tour) {

            $temp_array_edit_one_day_tour[$one_day_tour['name']] = $one_day_tour['value'];
        }


        $param = $temp_array_edit_one_day_tour;
        $data['adult_price_one_day_tour_r'] = str_ireplace(",", "", $param['adultPriceOneDayTourR']);
        $data['child_price_one_day_tour_r'] = str_ireplace(",", "", $param['childPriceOneDayTourR']);
        $data['infant_price_one_day_tour_r'] = str_ireplace(",", "", $param['infantPriceOneDayTourR']);
        $data['adult_price_one_day_tour_a'] = str_ireplace(",", "", $param['adultPriceOneDayTourA']);
        $data['child_price_one_day_tour_a'] = str_ireplace(",", "", $param['childPriceOneDayTourA']);
        $data['infant_price_one_day_tour_a'] = str_ireplace(",", "", $param['infantPriceOneDayTourA']);


        $sql = "SELECT 
                    adult_price_one_day_tour_r, child_price_one_day_tour_r, infant_price_one_day_tour_r,
                    adult_price_one_day_tour_a, child_price_one_day_tour_a, infant_price_one_day_tour_a,
                    tour_name, tour_code
                FROM reservation_tour_tb 
                WHERE 
                  id={$param['fk_tour_id']}
                  AND is_del = 'no'
                  AND ( 
                  adult_price_one_day_tour_r != '{$data['adult_price_one_day_tour_r']}'
                  OR child_price_one_day_tour_r != '{$data['child_price_one_day_tour_r']}'
                  OR infant_price_one_day_tour_r != '{$data['infant_price_one_day_tour_r']}'
                  OR adult_price_one_day_tour_a != '{$data['adult_price_one_day_tour_a']}'
                  OR adult_price_one_day_tour_a != '{$data['adult_price_one_day_tour_a']}'
                  OR adult_price_one_day_tour_a != '{$data['adult_price_one_day_tour_a']}'
                  OR child_price_one_day_tour_a != '{$data['child_price_one_day_tour_a']}'
                  OR infant_price_one_day_tour_a != '{$data['infant_price_one_day_tour_a']}'
                  )
                  ";
        $resultTour = $Model->load($sql, 'assoc');

        $dataLogs = [];
        if (!empty($resultTour)) {

            $dataLogs['fk_tour_id'] = (!empty($param['fk_tour_id'])) ? $param['fk_tour_id'] : '';
            $dataLogs['fk_tour_id_same'] = (!empty($param['id_same'])) ? $param['id_same'] : '';
            $dataLogs['tour_name'] = $resultTour['tour_name'];
            $dataLogs['tour_code'] = $resultTour['tour_code'];
            $dataLogs['flag_one_day_tour'] = 'yes';
            unset($resultTour['tour_name']);
            unset($resultTour['tour_code']);
            $dataLogs['old_price'] = json_encode($resultTour);
            $dataLogs['new_price'] = json_encode($data);
            $dataLogs['number_package'] = '';
            $dataLogs['create_date_in'] = $dateNow;
            $dataLogs['create_time_in'] = date('H:i:s');

            $Model->setTable('reservation_change_tour_prices_logs');
            $Model->insertLocal($dataLogs);
        }

        if (isset($param['currencyTypeOneDayTour']) && $param['currencyTypeOneDayTour'] != '') {
            $objCurrency = Load::controller('currencyEquivalent');
            $infoCurrency = $objCurrency->InfoCurrency($param['currencyTypeOneDayTour']);
            $data['currency_type_one_day_tour'] = $infoCurrency['CurrencyTitleFa'];
        } else {
            $data['currency_type_one_day_tour'] = '';
        }

        $condition = "id={$param['fk_tour_id']}";
        $Model->setTable('reservation_tour_tb');
        $res = $Model->update($data, $condition);

        if ($res) {
            return 'success : ' . functions::Xmlinformation('ChangesSuccessfullyCompleted') . ':' . $param['id_same'];
        } else {
            return 'error ' . functions::Xmlinformation('ErrorChanges');
        }

    }
    #endregion


    #region editRout
    public function editRout($param) {
        $objController = Load::controller('reservationPublicFunctions');
        $Model = Load::library('Model');

        for ($i = 1; $i <= $param['countRowAnyRout']; $i++) {

            $type_vehicle_name = '';
            $airline_name = '';
            if (isset($param['tourRoutId' . $i]) && $param['tourRoutId' . $i] != '') {

                $type_vehicle_name = $objController->ShowName('reservation_type_of_vehicle_tb', $param['typeVehicle' . $i]);
                if ($type_vehicle_name == 'هواپیما') {
                    $airline_name = $objController->ShowNameBase('airline_tb', 'name_fa', $param['airline' . $i]);
                } else {
                    $airline_name = $objController->ShowName('reservation_transport_companies_tb', $param['airline' . $i]);
                }

                $dataRout['tour_title'] = $param['tourTitle' . $i];
                $dataRout['type_vehicle_id'] = $param['typeVehicle' . $i];
                $dataRout['type_vehicle_name'] = $type_vehicle_name;
                $dataRout['airline_id'] = $param['airline' . $i];
                $dataRout['airline_name'] = $airline_name;
                $dataRout['class'] = $param['class' . $i];
                $dataRout['exit_hours'] = $param['exitHours' . $i] . ':' . $param['exitMinutes' . $i];
                $dataRout['hours'] = $param['hours' . $i] . ':' . $param['minutes' . $i];
                $dataRout['is_del'] = 'no';

                $condition = "id={$param['tourRoutId' . $i]}";
                $Model->setTable('reservation_tour_rout_tb');
                $res[] = $updateRout[] = $Model->update($dataRout, $condition);

                /*$infoTourRout = $this->infoTourRoutById($param['tourRoutId' . $i]);
                if (!empty($infoTourRout)) {

                    $condition = "id={$param['tourRoutId' . $i]}";
                    $Model->setTable('reservation_tour_rout_tb');
                    $res[] = $updateRout[] = $Model->update($dataRout, $condition);

                } else {
                    $dataRout['fk_tour_id'] = $param['tourId'];
                    $Model->setTable('reservation_tour_rout_tb');
                    $res[] = $Model->insertLocal($dataRout);
                }*/

            }


        }

        if (isset($res) && in_array('0', $res)) {
            return false;
        } else {
            return true;
        }

    }
    #endregion


    #region getDaysWeekAnyTour
    public function getDaysWeekAnyTour($idSame) {

        $Model = Load::library('Model');
        $sql = " SELECT start_date FROM reservation_tour_tb WHERE id_same='{$idSame}' AND is_del='no' ";
        $resultTicket = $Model->select($sql);
        $result = array();
        foreach ($resultTicket as $val) {
            $y = substr($val['start_date'], 0, 4);
            $m = substr($val['start_date'], 4, 2);
            $d = substr($val['start_date'], 6, 2);
            $jmktime = dateTimeSetting::jmktime(0, 0, 0, $m, $d, $y);
            $nameDay = dateTimeSetting::jdate("w", $jmktime, "", "", "en");
            $result[$nameDay] = $nameDay;
        }
        sort($result);

        return $result;

    }
    #endregion


    #region editTourWithIdSame
    public function editTourWithIdSame($param, $file) {


        if(Session::IsLogin()) {

            $Model = Load::library('Model');


            if (!file_exists(LOGS_DIR . 'EditTour/' . CLIENT_ID . '/')) {
                mkdir(LOGS_DIR . 'EditTour/' . CLIENT_ID . '/', 0777, true);
            }

            $log_name = 'EditTour/' . CLIENT_ID . '/' . $param['tourIdSame'];

            functions::insertLog('******************Start Of the Story*******************', $log_name);

            /** @var reservationPublicFunctions $objController */
            $objController = Load::controller('reservationPublicFunctions');

            $check_start_date = str_replace("-", "", $param['startDate']);
            $check_end_date = str_replace("-", "", $param['endDate']);
            //////////لیست نام هفته، انتخاب شده///////////
            $days_Week = [];
            for ($sh = 0; $sh <= 6; $sh++) {
                if (isset($param['sh' . $sh]) && $param['sh' . $sh] != '') {
                    $days_Week []= $param['sh' . $sh];
                }
            }

            $array_check_Days = [];
            $not_array_check_Days = [];

            while ($check_start_date <= $check_end_date) {

                $nameDay_check = $objController->nameDay($check_start_date);

                $day_check = $param['day'] - 1;
                $day_check = ' + ' . $day_check;
                $check_data['end_date'] = $objController->dateNextFewDays($check_start_date, $day_check);
                functions::insertLog('day start end =>' . json_encode([$nameDay_check['numberDay'],$param['day'], $day_check, $check_start_date, $check_data['end_date']], 256), $log_name);

//todo create a boolean var to check if this condition blew has been initiated.
                if (in_array($nameDay_check['numberDay'], $days_Week)) {
                    $filteredArray = [];

                    foreach ($days_Week as $element) {
                        if ($element !== $nameDay_check['numberDay']) {
                            $filteredArray[] = $element;
                        }
                    }
                    $days_Week = array_values($filteredArray);
                    functions::insertLog('after in_array =>' . json_encode([$check_start_date, $days_Week, $nameDay_check['numberDay']], 256), $log_name);
                    if ($check_data['end_date'] <= $check_end_date) {
                        functions::insertLog('in if check =>' . json_encode([$check_start_date, $days_Week, $nameDay_check['numberDay']], 256), $log_name);
                        $array_check_Days[] = true;
                    }else{
                        $array_check_Days[] = false;
                    }
                }else{
                    $not_array_check_Days= $days_Week;
                }
                $check_start_date = $objController->dateNextFewDays($check_start_date, ' + 1');
            }
            functions::insertLog('$not_array_check_Days =>' . json_encode($not_array_check_Days, 256), $log_name);
            functions::insertLog('check day exist =>' . json_encode($array_check_Days, 256), $log_name);



            if (empty($not_array_check_Days) && !in_array(false,$array_check_Days)) {

                $custom_file_fields = '';
                if (!empty($param['custom_file_fields'])) {
                    $custom_file_fields = json_encode($param['custom_file_fields'], 256 | 64);
                }

                $checkTourParams = $this->checkTourParams($param, [
                    [
                        'destinationCountry1',
                        functions::Xmlinformation('Destinationcountry')
                    ],
                    [
                        'destinationCity1',
                        functions::Xmlinformation('Destinationcity')
                    ],
                    [
                        'typeVehicle1',
                        functions::Xmlinformation('Vehicletype')
                    ],
                    [
                        'airline1',
                        functions::Xmlinformation('Shippingcompany')
                    ]
                ]);
                if ($checkTourParams !== true) {

                    return 'error : ' . $checkTourParams['message'];

                }

                $dateNow = dateTimeSetting::jtoday();

                $idSame = $param['tourIdSame'];
                $userId = $param['userId'];
                $tourCode = $param['tourCode'];


                $config = Load::Config('application');
                $config->pathFile('reservationTour/');
                if (isset($file['tourPic']) && $file['tourPic'] != "") {
                    $_FILES['tourPic']['name'] = self::changeNameUpload($_FILES['tourPic']['name']);

                    $success = $config->UploadFile("", "tourPic", "");
                    $exp_name_pic = explode(':', $success);
                    if ($exp_name_pic[0] == "done") {
                        $data['tour_pic'] = $exp_name_pic[1];
                    } else {
                        $data['tour_pic'] = $param['pic'];
                    }

                } else {
                    $data['tour_pic'] = $param['pic'];
                }


                if (isset($file['tourCover']) && $file['tourCover'] != "") {
                    $_FILES['tourCover']['name'] = self::changeNameUpload($_FILES['tourCover']['name']);
                    $success = $config->UploadFile("pic", "tourCover", "2097152");
                    $exp_name_pic = explode(':', $success);
                    if ($exp_name_pic[0] == "done") {
                        $data['tour_cover'] = $exp_name_pic[1];
                    } else {
                        $data['tour_cover'] = $param['cover'];
                    }

                } else {
                    $data['tour_cover'] = $param['cover'];
                }


                if (isset($file['tourFile']) && $file['tourFile'] != "") {
                    $_FILES['tourFile']['name'] = self::changeNameUpload($_FILES['tourFile']['name']);

                    $success = $config->UploadFile("", "tourFile", "");
                    $exp_name_pic = explode(':', $success);
                    if ($exp_name_pic[0] == "done") {
                        $data['tour_file'] = $exp_name_pic[1];
                    } else {
                        $data['tour_file'] = $param['file'];
                    }

                } else {
                    $data['tour_file'] = $param['file'];
                }


                $fileIndexes = array(
                    'name',
                    'type',
                    'tmp_name',
                    'error',
                    'size');
                $file['TourTravelProgramEdited'] = $this->arrayMapMultiFile($fileIndexes, 'TourTravelProgram', $file, $param['TourTravelProgram']);

                foreach ($file['TourTravelProgramEdited']['day'] as $keyTourTravelProgramDay => $TourTravelProgramDay) {
                    foreach ($TourTravelProgramDay['gallery'] as $keyTourTravelProgramDaysGallery => $TourTravelProgramDaysGallery) {
                        $_FILES['TourTravelProgramForeach'] = $TourTravelProgramDaysGallery['file'];

                        if (!empty($TourTravelProgramDaysGallery['file']['name'])) {

                            $_FILES['TourTravelProgramForeach']['name'] = self::changeNameUpload($_FILES['TourTravelProgramForeach']['name']);
                            $success = $config->UploadFile("", "TourTravelProgramForeach", "");
                            $exp_name_pic = explode(':', $success);
                            if ($exp_name_pic[0] == "done") {
                                $param['TourTravelProgram']['day'][$keyTourTravelProgramDay]['gallery'][$keyTourTravelProgramDaysGallery]['file'] = $exp_name_pic[1];
                            } else {
                                $param['TourTravelProgram']['day'][$keyTourTravelProgramDay]['gallery'][$keyTourTravelProgramDaysGallery]['file'] = $param['TourTravelProgramEdited']['day'][$keyTourTravelProgramDay]['gallery'][$keyTourTravelProgramDaysGallery]['file_hidden'];
                            }
                        }
                        else {

                            $param['TourTravelProgram']['day'][$keyTourTravelProgramDay]['gallery'][$keyTourTravelProgramDaysGallery]['file'] = $param['TourTravelProgram']['day'][$keyTourTravelProgramDay]['gallery'][$keyTourTravelProgramDaysGallery]['file_hidden'];
                        }


                    }
                }


                if (!empty($param['id_one_day_only']) && $param['id_one_day_only'] == '1') {
                    $flagOneDayTour = 'yes';
                    $data['night'] = '0';
                    $data['day'] = '1';
                    $param['TourTypes'][] = '1';
                } else {
                    $flagOneDayTour = 'no';
                    $data['night'] = $param['night'];
                    $data['day'] = $param['day'];
                    $param['TourTypes'][] = '2';
                }


                $TourServicesCount = count($param['TourServices']);
                $TourServices = implode(',', $param['TourServices']);


                $result_tour_local_controller = $this->getController('resultTourLocal');
                $TourServicesAll = $result_tour_local_controller->getTourServices();
                $res_diff = array_diff($TourServicesAll, $param['TourServices']);
                $res_diff_count = count($res_diff);
                $TourServicesNoSelect = ($res_diff_count > 0) ? implode(',', $res_diff) : '';



                $age_categories = array();
                $array_age_categories = array(
                    'AgeCategories_Young',
                    'AgeCategories_Children',
                    'AgeCategories_Teenager',
                    'AgeCategories_Adult',
                    'AgeCategories_UltraAdult');
                foreach ($array_age_categories as $age_category) {
                    if (isset($param[$age_category]) && $param[$age_category] != '') {
                        $age_categories = array_merge($age_categories, array($age_category));
                    }
                }
                (!empty($age_categories) ? $age_categories = json_encode($age_categories) : $age_categories = '');

                if (isset($param['is_request']) && $param['is_request'] == 'true') {
                    $isRequest = 1;
                } else {
                    $isRequest = 0;
                }

                $data['id_same'] = $idSame;
                $data['user_id'] = $userId;
                $data['tour_code'] = $tourCode;
                $data['agency_id'] = $param['agencyId'];
                $data['is_request'] = $isRequest;
                $data['agency_name'] = $param['agencyName'];
                $data['tour_name'] = $param['tourName'];
                $data['tour_video'] = $param['tourVideo'];
                $tourNameEn = preg_replace('/\s+/', ' ', $param['tourNameEn']);
                $data['tour_name_en'] = $tourNameEn;
                $data['tour_reason'] = $param['tourReason'];
                $data['stop_time_reserve'] = $param['stopTimeReserve'];
                $data['stop_time_cancel'] = $param['stopTimeCancel'];
                $data['start_time_last_minute_tour'] = '';
                $data['free'] = $param['free'];
                $data['prepayment_percentage'] = $isRequest == 1 ? 0 : $param['prepaymentPercentage'];

                $data['visa'] = $param['visa'];
                $data['insurance'] = $param['insurance'];
                $data['description'] = $param['description'];
                $data['required_documents'] = $param['requiredDocuments'];
                $data['rules'] = $param['rules'];
                $data['cancellation_rules'] = $param['cancellationRules'];
                $data['travel_program'] = @$param['travelProgram'];

                $data['origin_continent_id'] = $param['originContinent1'];
                $data['origin_country_id'] = $param['originCountry1'];

                $country_name = $this->reservation_country_model->get('name')->where('id', $param['originCountry1'])->find();
                $param['originCountryName1'] = $country_name['name'];


                $data['origin_country_name'] = $param['originCountryName1'];;
                $data['origin_city_id'] = $param['originCity1'];

                $city_name = $this->reservation_city_model->get('name')->where('id', $param['originCity1'])->find();
                $param['originCityName1'] = $city_name['name'];


                $data['origin_city_name'] = $param['originCityName1'];
                $data['origin_region_id'] = $param['originRegion1'];


                $region_name = $this->reservation_region_model->get('name')->where('id', $param['originRegion1'])->find();
                $param['originRegionName1'] = $region_name['name'];


                $data['origin_region_name'] = $param['originRegionName1'];

                $data['change_price'] = '';
                $data['comment_cancel'] = '';
                $data['create_date_in'] = $dateNow;
                $data['create_time_in'] = date('H:i:s');
                $data['is_show'] = '';
                $data['is_del'] = 'no';
                $data['language'] = $param['softwareLanguage'];
                $data['tour_status'] = $param['TourStatus'];
                $data['tour_services'] = $TourServices ?: null;
                $data['tour_services_not_selected'] = $TourServicesNoSelect ?: null;
                $data['tour_difficulties'] = $param['TourDifficulties'];
                $data['age_categories'] = $age_categories;
                $data['suggested'] = '0';
                $data['tour_leader_language'] = $param['TourLeaderLanguage'];
                $data['custom_file_fields'] = $custom_file_fields;

                $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
//        $sqlCheck = " SELECT id, start_date, end_date FROM reservation_tour_tb
//                          WHERE id_same='{$idSame}'";
//        $resultCheck = $Model->select($sqlCheck);

                $all_tours_by_id_same = $this->reservation_tour_model->get(['id', 'start_date', 'end_date', 'adult_price_one_day_tour_r',
                    'child_price_one_day_tour_r', 'infant_price_one_day_tour_r', 'adult_price_one_day_tour_a',
                    'child_price_one_day_tour_a', 'infant_price_one_day_tour_a', 'currency_type_one_day_tour'])
                    ->where('id_same', $idSame)
                    ->all();

                foreach ($all_tours_by_id_same as $k => $val) {
                    if ($k == 0) {
                        $dateStartDelete = $val['start_date'];
                    }
                    $dateEndDelete = $val['end_date'];
                    $check[$val['start_date']] = $val['id'];
                }


                $data['adult_price_one_day_tour_r'] = $all_tours_by_id_same[0]['adult_price_one_day_tour_r'];
                $data['child_price_one_day_tour_r'] = $all_tours_by_id_same[0]['child_price_one_day_tour_r'];
                $data['infant_price_one_day_tour_r'] = $all_tours_by_id_same[0]['infant_price_one_day_tour_r'];
                $data['adult_price_one_day_tour_a'] = $all_tours_by_id_same[0]['adult_price_one_day_tour_a'];
                $data['child_price_one_day_tour_a'] = $all_tours_by_id_same[0]['child_price_one_day_tour_a'];
                $data['infant_price_one_day_tour_a'] = $all_tours_by_id_same[0]['infant_price_one_day_tour_a'];
                $data['currency_type_one_day_tour'] = $all_tours_by_id_same[0]['currency_type_one_day_tour'];

//        if ($startDate > $dateStartDelete){
////                echo '1delete --> ' . $dateStartDelete . ' taa ' . $startDate . '<br>  ';
//            $dateDelete['is_del'] = 'yes';
//            $conditionDelete = " id_same='{$idSame}' AND (start_date BETWEEN '{$dateStartDelete}' AND '{$startDate}') ";
//            $Model->setTable('reservation_tour_tb');
////            $res[] = $Model->update($dateDelete, $conditionDelete);
//            $res[] = $Model->delete($conditionDelete);
//        }

//        if ($endDate < $dateEndDelete){
////                echo '2delete --> ' . $endDate . ' taa ' . $dateEndDelete . '<br>  ';
//            $dateDelete['is_del'] = 'yes';
//            $conditionDelete = " id_same='{$idSame}' AND (start_date BETWEEN '{$endDate}' AND '{$dateEndDelete}') ";
//            $Model->setTable('reservation_tour_tb');
////            $res[] = $Model->update($dateDelete, $conditionDelete);
//            $res[] = $Model->delete($conditionDelete);
//        }


                // remove all tour table by ID SAME


                $destination_index = [];
                for ($i = 1; $i <= $param['countRowAnyRout']; $i++) {

                    if ($param['tourTitle' . $i] !== 'return') {
                        $destination_index[] = $param['destinationCity' . $i];
                    }
                }


                $all_package_items = [];
                functions::insertLog('before foreach for delete and again insert=>' . json_encode($all_tours_by_id_same, 256), $log_name);

                foreach ($all_tours_by_id_same as $tour) {
                    functions::insertLog('first in loop foreach for delete each tour=>' . json_encode($tour, 256), $log_name);
                    $this->reservation_tour_route_model->delete([
                        'fk_tour_id' => $tour['id']
                    ]);
                    functions::insertLog(' in loop check change route=>' . json_encode($param['is_routes_changed'], 256), $log_name);

                    if ($param['is_routes_changed'] === '0') {
                        if (empty($last_package_item)) {
                            $last_package_items = $this->reservation_tour_package_model->get()
                                ->where('fk_tour_id', $tour['id'])
                                ->all();
                            functions::insertLog('in loop last package items=>' . json_encode($last_package_items, 256), $log_name);

                            foreach ($last_package_items as $key => $package) {

                                $last_package_hotel_item = $this->reservation_tour_hotel_model->get()
                                    ->where('fk_tour_id', $tour['id'])
                                    ->where('fk_tour_package_id', $package['id'])
                                    ->whereIn('fk_city_id', $destination_index)
                                    ->all();
                                functions::insertLog('in loop last package items=>' . $key . '=>' . json_encode($last_package_items, 256), $log_name);

                                $package['package_hotel_items'] = $last_package_hotel_item;

                                $last_package_discount_item = $this->reservation_tour_discount_model->get()
                                    ->where('tour_id', $tour['id'])
                                    ->where('tour_package_id', $package['id'])
                                    ->all();
                                functions::insertLog('in loop  last package discount item=>' . $key . '=>' . json_encode($last_package_discount_item, 256), $log_name);


                                $package['package_discount_items'] = $last_package_discount_item;

                                $all_package_items[$key] = $package;
                            }

                        }
                        functions::insertLog('in loop all package items=>' . json_encode($all_package_items, 256), $log_name);
                    }


                    $this->reservation_tour_package_model->delete([
                        'fk_tour_id' => $tour['id']
                    ]);
                    $this->reservation_tour_hotel_model->delete([
                        'fk_tour_id' => $tour['id']
                    ]);
                }


                $this->reservation_tour_model->delete([
                    'id_same' => $idSame
                ]);

                // check travel programs
                $resultTourTravel = $this->getModel('tourTravelProgramModel')->get()
                    ->where('tour_id', $idSame)
                    ->find();

                  foreach($param['TourTravelProgram']['day'] as $counter => $day) {
                      foreach($day['gallery'] as $i => $gallery){
                            if(empty($gallery['file']) || $gallery['file'] == ''){
                                unset($param['TourTravelProgram']['day'][$counter]['gallery'][$i]);
                            }
                      }
                  }
                if (empty($resultTourTravel)) {
                    $TourTravelProgramData['tour_id'] = $idSame;
                    $TourTravelProgramData['data'] = json_encode($param['TourTravelProgram'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT | JSON_HEX_APOS);
                    $this->getModel('tourTravelProgramModel')->insertWithBind($TourTravelProgramData);
                } else {
                    $TourTravelProgramModelUpdate['data'] = json_encode($param['TourTravelProgram'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT | JSON_HEX_APOS);
                    $this->getModel('tourTravelProgramModel')->updateWithBind($TourTravelProgramModelUpdate, [
                        'tour_id' => $idSame
                    ]);
                }

                //

                $startDate = str_replace("-", "", $param['startDate']);
                $endDate = str_replace("-", "", $param['endDate']);
                //////////لیست نام هفته، انتخاب شده///////////
                $daysWeek = 'NaN,';
                for ($sh = 0; $sh <= 6; $sh++) {
                    if (isset($param['sh' . $sh]) && $param['sh' . $sh] != '') {
                        $daysWeek .= $param['sh' . $sh] . ',';
                    }
                }
                $counter = 0;


                while ($startDate <= $endDate) {
                    $nameDay = $objController->nameDay($startDate);

                    $type = 'insert';
                    $data['start_date'] = $startDate;
                    $day = $param['day'] - 1;
                    $day = ' + ' . $day;
                    $data['end_date'] = $objController->dateNextFewDays($startDate, $day);
                    functions::insertLog('before while end=>' . json_encode(['starts=>'.$startDate,'data end date'.$data['end_date'],'$endDate=>'.$endDate], 256), $log_name);
                    //todo create a boolean var to check if this condition blew has been initiated.
                    if ($data['end_date'] <= $endDate) {
                        $Model->setTable('reservation_tour_tb');
                        functions::insertLog('before while end=>' . json_encode([$daysWeek,$nameDay['numberDay']], 256), $log_name);
                        if (strpos($daysWeek, ',' . $nameDay['numberDay'] . ',') > 0) {
                            functions::insertLog('in loop while daysWeek=>' . json_encode($data, 256), $log_name);
                            $res[] = $resTour = $Model->insertLocal($data);

                            if ($resTour) {
                                $fk_tour_id = $Model->getLastId();
                                functions::insertLog('in loop while editRoutWithIdSame=>' . json_encode([$param, $fk_tour_id, $type], 256), $log_name);
                                $res[] = $this->editRoutWithIdSame($param, $fk_tour_id, $type);

                                if ($all_package_items) {


                                    foreach ($all_package_items as $package_key => $package_item) {
                                        $package_item['fk_tour_id'] = $fk_tour_id;


                                        $hotel_items = [];

                                        if (isset($package_item['package_hotel_items'])) {
                                            $hotel_items = $package_item['package_hotel_items'];
                                            unset($package_item['package_hotel_items']);
                                        }

                                        $discount_items = [];
                                        if (isset($package_item['package_discount_items'])) {
                                            $discount_items = $package_item['package_discount_items'];
                                            unset($package_item['package_discount_items']);
                                        }
                                        $data_package_item = $package_item;

                                        if (isset($data_package_item['id'])) {
                                            unset($data_package_item['id']);
                                        }
                                        if (!empty($hotel_items)) {
                                            functions::insertLog('in while check if it hotel items not empty =>' . json_encode($hotel_items, 256), $log_name);
                                            $last_package_id = $this->reservation_tour_package_model->insertWithBind($data_package_item);

                                        }
                                        foreach ($hotel_items as $hotel_item) {
                                            $hotel_item['fk_tour_package_id'] = $last_package_id;
                                            $hotel_item['fk_tour_id'] = $fk_tour_id;
                                            if (isset($hotel_item['id'])) {
                                                unset($hotel_item['id']);
                                            }
                                            functions::insertLog('in while- in foreach for each item  =>' . json_encode($hotel_item, 256), $log_name);
                                            $this->reservation_tour_hotel_model->insertWithBind($hotel_item);
                                        }


                                        foreach ($discount_items as $discount_item) {
                                            $discount_item['tour_package_id'] = $last_package_id;
                                            $discount_item['tour_id'] = $fk_tour_id;
                                            if (isset($discount_item['id'])) {
                                                unset($discount_item['id']);
                                            }
                                            functions::insertLog('in while- in foreach for each discount item  =>' . json_encode($hotel_item, 256), $log_name);
                                            $this->reservation_tour_discount_model->insertWithBind($discount_item);
                                        }


                                    }


                                }
                            }
                        }
                    }
                    $startDate = $objController->dateNextFewDays($startDate, ' + 1');
                    $counter++;
                }

//        while ($startDate <= $endDate) {
//
//            $type = '';
//            $nameDay = $objController->nameDay($startDate);
//
//
//
//            $type = 'insert';
//            $data['start_date'] = $startDate;
//            $day = $param['day'] - 1;
//            $day = ' + ' . $day;
//            $data['end_date'] = $objController->dateNextFewDays($startDate, $day);
//
//
//            if ($data['end_date'] <= $endDate){
//                $Model->setTable('reservation_tour_tb');
//
//
//                if (strpos($daysWeek, ',' . $nameDay['numberDay'] . ',') > 0) {
//
//                    $res[] = $resTour = $Model->insertLocal($data);
//                    if ($resTour) {
//                        $fk_tour_id = $Model->getLastId();
//                        $res[] = $this->editRoutWithIdSame($param, $fk_tour_id, $type);
//                    }
//                }
//
//
//
//            }
//
//            /*if (strpos($daysWeek, ',' . $nameDay['numberDay'] . ',') > 0 && (isset($check[$startDate]) && $check[$startDate] != '')) {
////                echo 'update ---> ' . $startDate . ' <br>';
//                $type = 'update';
//                $data['start_date'] = $startDate;
//                $day = $param['day'] - 1;
//                $day = ' + ' . $day;
//
//                $data['end_date'] = $objController->dateNextFewDays($startDate, $day);
//                if ($data['end_date'] <= $endDate){
//                    $condition = " id='{$check[$startDate]}' ";
//                    $Model->setTable('reservation_tour_tb');
//                    $res[] = $resTour = $Model->update($data, $condition);
//                    if ($resTour) {
//                        $fk_tour_id = $check[$startDate];
//                        $res[] = $this->editRoutWithIdSame($param, $fk_tour_id, $type);
//                    }
//                }
//
//            } elseif (strpos($daysWeek, ',' . $nameDay['numberDay'] . ',') > 0 && !(isset($check[$startDate]) && $check[$startDate] != '')) {
////                    echo 'insert ---> ' . $startDate . ' <br>';
//                $type = 'insert';
//                $data['start_date'] = $startDate;
//                $day = $param['day'] - 1;
//                $day = ' + ' . $day;
//                $data['end_date'] = $objController->dateNextFewDays($startDate, $day);
//
//                if ($data['end_date'] <= $endDate){
//                    $Model->setTable('reservation_tour_tb');
//
//
//
//                    $res[] = $resTour = $Model->insertLocal($data);
//                    if ($resTour) {
//                        $fk_tour_id = $Model->getLastId();
//                        $res[] = $this->editRoutWithIdSame($param, $fk_tour_id, $type);
//                    }
//                }
//
//            } elseif (isset($check[$startDate]) && $check[$startDate] != '') {
//
//
////                echo 'delete ---> ' . $startDate . ' <br>';
//
//                $dateUpdate = $data;
//                $conditionUpdate = " id='{$data['id_same']}' ";
//                $Model->setTable('reservation_tour_tb');
//                $Model->update($dateUpdate, $conditionUpdate);
//
//
//                $type = 'delete';
//                $dateDelete['is_del']='yes';
//                $conditionDelete = " id='{$check[$startDate]}' ";
//                $Model->setTable('reservation_tour_tb');
//                $res[] = $Model->update($dateDelete, $conditionDelete);
//            }*/
//
//
//            // روز بعدی //
//            $startDate = $objController->dateNextFewDays($startDate, ' + 1');
//
//        }//end while startDate<=endDate




                // tour type
                $res[] = $this->registrationTourType($idSame, $param['TourTypes']);
                functions::insertLog('after  registrationTourType =>' . json_encode($res, 256), $log_name);


                if (in_array('0', $res)) {
                    functions::insertLog('********************End Of Story IN Error**********************=>' . json_encode($res, 256), $log_name);

                    return 'error :' . functions::Xmlinformation('ErrorChanges');
                } else {
//                    if (CLIENT_ID != '292') {
//                        $smsController = Load::controller('smsServices');
//                        $UserSession = Load::library('Session');
//                        $UserController = Load::controller('user');
//                        $objSms = $smsController->initService('1');
//                        $UserProfile = $UserController->getProfile($UserSession->getUserId());
//                        $UserProfileMobile = $UserProfile['mobile'];
//                        $ClientMobile = CLIENT_MOBILE;
//                        $sms = "مدیریت محترم " . CLIENT_NAME . " تور " . $data['tour_name'] . " ویرایش شد و میتوانید آن را در پنل مدیریت خود مشاهده کنید ";
//                        $smsArray = array(
//                            'smsMessage' => $sms,
//                            'cellNumber' => $ClientMobile);
////                        $smsController->sendSMS($smsArray);
//                        if ($ClientMobile != $UserProfileMobile) {
//                            $sms = " ویرایشات شما برای تور '" . $data['tour_name'] . "' ثبت شد و پس از تایید مدیریت در ساید به نمایش در خواهد آمد. ";
//                            $smsArray = array(
//                                'smsMessage' => $sms,
//                                'cellNumber' => $UserProfileMobile);
//                            $smsController->sendSMS($smsArray);
//                        }
//                    }

                    functions::insertLog('********************End Of Story IN Success**********************=>' . json_encode($res, 256), $log_name);
                    return 'success : ' . functions::Xmlinformation('TourEntrySuccessfullyCompleted') . ' :' . $flagOneDayTour;
                }

            }
            return 'error :' .functions::Xmlinformation('errorInDateSelect');
        }
        return 'error :  برای ویرایش باید وارد شوید' ;

    }
    #endregion


    #region editTourTypeWithIdSame
    public function editTourTypeWithIdSame($idSame, $arrayTypeTour = null) {

        $Model = Load::library('Model');

        $dataDelete['is_del'] = 'yes';
        $condition = "fk_tour_id_same={$idSame}";
        $Model->setTable('reservation_tour_tourType_tb');
        $res[] = $Model->update($dataDelete, $condition);

        if (!empty($arrayTypeTour)) {

            $objController = Load::controller('reservationPublicFunctions');
            $tourType = '';
            foreach ($arrayTypeTour as $id) {
                $tourTypeName = $objController->ShowName('reservation_tour_type_tb', $id, 'tour_type');

                $sql = " SELECT id FROM reservation_tour_tourType_tb
                         WHERE fk_tour_id_same = '{$idSame}' AND fk_tour_type_id = '{$id}' ";
                $result = $Model->load($sql);
                if (empty($result)) {
                    $data['is_del'] = 'no';
                    $data['fk_tour_id_same'] = $idSame;
                    $data['fk_tour_type_id'] = $id;
                    $data['fk_tour_type_name'] = $tourTypeName;
                    $Model->setTable('reservation_tour_tourType_tb');
                    $res[] = $Model->insertLocal($data);

                } else {
                    $dataUpdate['is_del'] = 'no';
                    $condition = "fk_tour_id_same = '{$idSame}' AND fk_tour_type_id = '{$id}'";
                    $Model->setTable('reservation_tour_tourType_tb');
                    $res[] = $Model->update($dataUpdate, $condition);
                }


                $tourType .= $tourTypeName . '-';
            }
            $tourType = substr($tourType, 0, -1);

            if (in_array('0', $res)) {
                return 'error';
            } else {

                $dataTour['tour_type_id'] = json_encode($arrayTypeTour);
                $dataTour['tour_type'] = $tourType;

                $condition = "id_same={$idSame}";
                $Model->setTable('reservation_tour_tb');
                $res[] = $Model->update($dataTour, $condition);

            }
        }

        if (in_array('0', $res)) {
            return false;
        } else {
            return true;
        }


    }


    #region editRoutWithIdSame
    public function editRoutWithIdSame($param, $fk_tour_id, $type) {
        $objController = Load::controller('reservationPublicFunctions');
        $Model = Load::library('Model');


        for ($i = 1; $i <= $param['countRowAnyRout']; $i++) {

            $type_vehicle_name = '';
            $airline_name = '';
            if (isset($param['destinationCountry' . $i]) && $param['destinationCountry' . $i] != '') {

                $type_vehicle_name = $objController->ShowName('reservation_type_of_vehicle_tb', $param['typeVehicle' . $i]);
                if ($type_vehicle_name == 'هواپیما') {
                    $airline_name = $objController->ShowNameBase('airline_tb', 'name_fa', $param['airline' . $i]);
                } else {
                    $airline_name = $objController->ShowName('reservation_transport_companies_tb', $param['airline' . $i]);
                }


                $dataRout['type_vehicle_id'] = $param['typeVehicle' . $i];
                $dataRout['type_vehicle_name'] = $type_vehicle_name;
                $dataRout['airline_id'] = $param['airline' . $i];
                $dataRout['airline_name'] = $airline_name;
                $dataRout['class'] = $param['class' . $i];
                $dataRout['exit_hours'] = $param['exitHours' . $i] . ':' . $param['exitMinutes' . $i];
                $dataRout['hours'] = $param['hours' . $i] . ':' . $param['minutes' . $i];
                $dataRout['is_del'] = 'no';
                $dataRout['is_route_fake'] = isset($param['is_route_fake' . $i]) ? $param['is_route_fake' . $i] : 1;

                if ($type == 'insert') {

                    $dataRout['tour_title'] = $param['tourTitle' . $i];
                    $dataRout['number_rout'] = $i;
                    $dataRout['night'] = (!empty($param['night' . $i])) ? $param['night' . $i] : 0;
                    $dataRout['day'] = (!empty($param['day' . $i])) ? $param['day' . $i] : 0;
                    $dataRout['destination_continent_id'] = $param['destinationContinent' . $i];
                    $dataRout['destination_country_id'] = $param['destinationCountry' . $i];

                    $country_name = $this->reservation_country_model->get('name')->where('id', $dataRout['destination_country_id'])->find();

                    $param['destinationCountryName' . $i] = $country_name['name'];

                    $dataRout['destination_country_name'] = $param['destinationCountryName' . $i];
                    $dataRout['destination_city_id'] = $param['destinationCity' . $i];

                    $city_name = $this->reservation_city_model->get('name')->where('id', $dataRout['destination_city_id'])->find();

                    $param['destinationCityName' . $i] = $city_name['name'];

                    $dataRout['destination_city_name'] = $param['destinationCityName' . $i];
                    $dataRout['destination_region_id'] = $param['destinationRegion' . $i];

                    $region_name = $this->reservation_region_model->get('name')->where('id', $dataRout['destination_region_id'])->find();

                    $param['destinationRegionName' . $i] = $region_name['name'];

                    $dataRout['destination_region_name'] = $param['destinationRegionName' . $i];

                    $dataRout['fk_tour_id'] = $fk_tour_id;
                    $Model->setTable('reservation_tour_rout_tb');
                    $res[] = $Model->insertLocal($dataRout);


                } elseif ($type == 'update') {

                    $condition = " fk_tour_id='{$fk_tour_id}' AND tour_title='{$param['tourTitle' . $i]}' 
                                    AND destination_country_id='{$param['destinationCountry' . $i]}' 
                                    AND destination_city_id='{$param['destinationCity' . $i]}'
                                    AND number_rout='{$i}' ";
                    if (isset($param['destinationRegion' . $i]) && $param['destinationRegion' . $i] > 0) {
                        $condition .= " AND destination_region_id='{$param['destinationRegion' . $i]}' ";
                    }
                    $Model->setTable('reservation_tour_rout_tb');
                    $res[] = $Model->update($dataRout, $condition);

                }

            }


        }

        if (isset($res) && in_array('0', $res)) {
            return false;
        } else {
            return true;
        }

    }

    #endregion

    public function checkForPricesChange($param) {


        $Model = Load::library('Model');
        $dateNow = dateTimeSetting::jtoday();
        if (!empty($param['fk_tour_id'])) {
            $fieldName = 'id';
            $fieldValue = $param['fk_tour_id'];
        } else {
            $fieldName = 'id_same';
            $fieldValue = $param['id_same'];
        }
        $newPrice = [];
        for ($countPackage = 1; $countPackage <= $param['countPackage']; $countPackage++) {

            $newPrice['three_room_price_r'] = str_ireplace(",", "", $param['threeRoomPriceR' . $countPackage]);
            $newPrice['three_room_price_a'] = str_ireplace(",", "", $param['threeRoomPriceA' . $countPackage]);
            $newPrice['double_room_price_r'] = str_ireplace(",", "", $param['doubleRoomPriceR' . $countPackage]);
            $newPrice['double_room_price_a'] = str_ireplace(",", "", $param['doubleRoomPriceA' . $countPackage]);
            $newPrice['single_room_price_r'] = str_ireplace(",", "", $param['singleRoomPriceR' . $countPackage]);
            $newPrice['single_room_price_a'] = str_ireplace(",", "", $param['singleRoomPriceA' . $countPackage]);
            $newPrice['child_with_bed_price_r'] = str_ireplace(",", "", $param['childWithBedPriceR' . $countPackage]);
            $newPrice['child_with_bed_price_a'] = str_ireplace(",", "", $param['childWithBedPriceA' . $countPackage]);
            $newPrice['infant_without_bed_price_r'] = str_ireplace(",", "", $param['infantWithoutBedPriceR' . $countPackage]);
            $newPrice['infant_without_bed_price_a'] = str_ireplace(",", "", $param['infantWithoutBedPriceA' . $countPackage]);
            $newPrice['infant_without_chair_price_r'] = str_ireplace(",", "", $param['infantWithoutChairPriceR' . $countPackage]);
            $newPrice['infant_without_chair_price_a'] = str_ireplace(",", "", $param['infantWithoutChairPriceA' . $countPackage]);

            $sql = "
            SELECT
                package.three_room_price_r,
                package.three_room_price_a,
                package.double_room_price_r,
                package.double_room_price_a,
                package.single_room_price_r,
                package.single_room_price_a,
                package.child_with_bed_price_r,
                package.child_with_bed_price_a,
                package.infant_without_bed_price_r,
                package.infant_without_bed_price_a,
                package.infant_without_chair_price_r,
                package.infant_without_chair_price_a,
                tour.tour_name,
                tour.tour_code 
            FROM
                reservation_tour_tb AS tour
                LEFT JOIN reservation_tour_package_tb AS package ON tour.id = package.fk_tour_id 
            WHERE
                tour.{$fieldName} = '{$fieldValue}' 
                AND package.number_package = '{$countPackage}' 
                AND package.is_del = 'no'
                AND (
                package.three_room_price_r != '{$newPrice['three_room_price_r']}' 
                OR package.three_room_price_a != '{$newPrice['three_room_price_a']}' 
                OR package.double_room_price_r != '{$newPrice['double_room_price_r']}' 
                OR package.double_room_price_a != '{$newPrice['double_room_price_a']}' 
                OR package.single_room_price_r != '{$newPrice['single_room_price_r']}' 
                OR package.single_room_price_a != '{$newPrice['single_room_price_a']}' 
                OR package.child_with_bed_price_r != '{$newPrice['child_with_bed_price_r']}' 
                OR package.child_with_bed_price_a != '{$newPrice['child_with_bed_price_a']}' 
                OR package.infant_without_bed_price_r != '{$newPrice['infant_without_bed_price_r']}' 
                OR package.infant_without_bed_price_a != '{$newPrice['infant_without_bed_price_a']}' 
                OR package.infant_without_chair_price_r != '{$newPrice['infant_without_chair_price_r']}' 
                OR package.infant_without_chair_price_a != '{$newPrice['infant_without_chair_price_a']}' 
                )
            ";
            $result = $Model->select($sql, 'assoc');
            $dataLogs = [];
            if (!empty($result)) {

                $dataLogs['fk_tour_id'] = (!empty($param['fk_tour_id'])) ? $param['fk_tour_id'] : '';
                $dataLogs['fk_tour_id_same'] = (!empty($param['id_same'])) ? $param['id_same'] : '';
                $dataLogs['tour_name'] = $result[0]['tour_name'];
                $dataLogs['tour_code'] = $result[0]['tour_code'];
                $dataLogs['flag_one_day_tour'] = 'no';
                unset($result[0]['tour_name']);
                unset($result[0]['tour_code']);
                $dataLogs['old_price'] = json_encode($result[0]);
                $dataLogs['new_price'] = json_encode($newPrice);
                $dataLogs['number_package'] = $countPackage;
                $dataLogs['create_date_in'] = $dateNow;
                $dataLogs['create_time_in'] = date('H:i:s');

                $Model->setTable('reservation_change_tour_prices_logs');
                $Model->insertLocal($dataLogs);
            }

        }

    }


    #region editPackageTourWithIdSame
    public function editPackageTourWithIdSame($param) {
        $temp_array_edit_tour = [];
        foreach ($param['data'] as $edit_tour) {

            $temp_array_edit_tour[$edit_tour['name']] = $edit_tour['value'];
        }


        $param = $temp_array_edit_tour;


        $result_tour_local_controller = $this->getController('resultTourLocal');
        $counter_type_controller = $this->getController('counterType');
        $counter_types = $counter_type_controller->getAll('all');
        $counter_types = $counter_type_controller->list;


        $objController = Load::controller('reservationPublicFunctions');
        $Model = Load::library('Model');

        // اگر تغییر قیمت داشت لاگ در جدول ثبت بشه //
        $this->checkForPricesChange($param);
        if($param['flag'] == 'tourPackageEdit') {
            $sql = " SELECT id  FROM reservation_tour_tb WHERE id_same = '{$param['id_same']}' AND id = '{$param['fk_tour_id']}'  AND is_del = 'no' ";
        }else{
            $sql = " SELECT id  FROM reservation_tour_tb WHERE id_same = '{$param['id_same']}' AND is_del = 'no' ";
        }

        $resultTour = $Model->select($sql);

        if (!empty($resultTour)) {

            foreach ($resultTour as $k => $tour) {

                $sqlPackage = " SELECT id, fk_tour_id  FROM reservation_tour_package_tb WHERE fk_tour_id = '{$tour['id']}' AND is_del = 'no' ";
                $resultPackage = $Model->select($sqlPackage);

                $arrayPackage = array();
                foreach ($resultPackage as $k => $package) {
                    $arrayPackage[$package['fk_tour_id']][$k + 1] = $package['id'];
                }

                for ($countPackage = 1; $countPackage <= $param['countPackage']; $countPackage++) {

                    //if (isset($param['doubleRoomPriceR' . $countPackage]) && $param['doubleRoomPriceR' . $countPackage] != '') {}
                    $dataPackage[$countPackage]['three_room_price_r'] = str_ireplace(",", "", $param['threeRoomPriceR' . $countPackage]);
                    $dataPackage[$countPackage]['three_room_price_a'] = str_ireplace(",", "", $param['threeRoomPriceA' . $countPackage]);
                    $dataPackage[$countPackage]['double_room_price_r'] = str_ireplace(",", "", $param['doubleRoomPriceR' . $countPackage]);
                    $dataPackage[$countPackage]['double_room_price_a'] = str_ireplace(",", "", $param['doubleRoomPriceA' . $countPackage]);
                    $dataPackage[$countPackage]['single_room_price_r'] = str_ireplace(",", "", $param['singleRoomPriceR' . $countPackage]);
                    $dataPackage[$countPackage]['single_room_price_a'] = str_ireplace(",", "", $param['singleRoomPriceA' . $countPackage]);
                    $dataPackage[$countPackage]['child_with_bed_price_r'] = str_ireplace(",", "", $param['childWithBedPriceR' . $countPackage]);
                    $dataPackage[$countPackage]['child_with_bed_price_a'] = str_ireplace(",", "", $param['childWithBedPriceA' . $countPackage]);
                    $dataPackage[$countPackage]['infant_without_bed_price_r'] = str_ireplace(",", "", $param['infantWithoutBedPriceR' . $countPackage]);
                    $dataPackage[$countPackage]['infant_without_bed_price_a'] = str_ireplace(",", "", $param['infantWithoutBedPriceA' . $countPackage]);
                    $dataPackage[$countPackage]['infant_without_chair_price_r'] = str_ireplace(",", "", $param['infantWithoutChairPriceR' . $countPackage]);
                    $dataPackage[$countPackage]['infant_without_chair_price_a'] = str_ireplace(",", "", $param['infantWithoutChairPriceA' . $countPackage]);
                    $dataPackage[$countPackage]['three_room_capacity'] = ($param['threeRoomCapacity' . $countPackage] >= 0) ? $param['threeRoomCapacity' . $countPackage] : 9;
                    $dataPackage[$countPackage]['double_room_capacity'] = ($param['doubleRoomCapacity' . $countPackage] >= 0) ? $param['doubleRoomCapacity' . $countPackage] : 9;
                    $dataPackage[$countPackage]['single_room_capacity'] = ($param['singleRoomCapacity' . $countPackage] >= 0) ? $param['singleRoomCapacity' . $countPackage] : 9;
                    $dataPackage[$countPackage]['child_with_bed_capacity'] = ($param['childWithBedCapacity' . $countPackage] >= 0) ? $param['childWithBedCapacity' . $countPackage] : 9;
                    $dataPackage[$countPackage]['infant_without_bed_capacity'] = ($param['infantWithoutBedCapacity' . $countPackage] >= 0) ? $param['infantWithoutBedCapacity' . $countPackage] : 9;
                    $dataPackage[$countPackage]['infant_without_chair_capacity'] = ($param['infantWithoutChairCapacity' . $countPackage] >= 0) ? $param['infantWithoutChairCapacity' . $countPackage] : 9;


                    $objCurrency = Load::controller('currencyEquivalent');
                    $infoCurrency = $objCurrency->InfoCurrency($param['currencyType' . $countPackage]);
                    $dataPackage[$countPackage]['currency_type'] = $infoCurrency['CurrencyTitle'];

                    $dataPackage[$countPackage]['number_package'] = $countPackage;
                    $dataPackage[$countPackage]['is_del'] = 'no';

                    $dataPackage[$countPackage]['fk_tour_id'] = $tour['id'];
                    $custom_room = [];

                    if (isset($param['fourRoomPriceR' . $countPackage]) || isset($param['fourRoomPriceA' . $countPackage])) {
                        $custom_room[]['fourRoom'] = [
                            'price_r' => str_ireplace(",", "", $param['fourRoomPriceR' . $countPackage]),
                            'price_a' => str_ireplace(",", "", $param['fourRoomPriceA' . $countPackage]),
                            'capacity' => ($param['fourRoomCapacity' . $countPackage] >= 0) ? $param['fourRoomCapacity' . $countPackage] : 9
                        ];
                    }
                    if (isset($param['fiveRoomPriceR' . $countPackage]) || isset($param['fiveRoomPriceA' . $countPackage])) {
                        $custom_room[]['fiveRoom'] = [
                            'price_r' => str_ireplace(",", "", $param['fiveRoomPriceR' . $countPackage]),
                            'price_a' => str_ireplace(",", "", $param['fiveRoomPriceA' . $countPackage]),
                            'capacity' => ($param['fiveRoomCapacity' . $countPackage] >= 0) ? $param['fiveRoomCapacity' . $countPackage] : 9
                        ];

                    }
                    if (isset($param['sixRoomPriceR' . $countPackage]) || isset($param['sixRoomPriceA' . $countPackage])) {

                        $custom_room[]['sixRoom'] = [
                            'price_r' => str_ireplace(",", "", $param['sixRoomPriceR' . $countPackage]),
                            'price_a' => str_ireplace(",", "", $param['sixRoomPriceA' . $countPackage]),
                            'capacity' => ($param['sixRoomCapacity' . $countPackage] >= 0) ? $param['sixRoomCapacity' . $countPackage] : 9
                        ];
                    }

                    $dataPackage[$countPackage]['custom_room'] = json_encode($custom_room, 256);
                    if (isset($arrayPackage[$tour['id']][$countPackage]) && $arrayPackage[$tour['id']][$countPackage] != '') {
                        //echo ' update: ' . $tour['id'] . ' ' . $arrayPackage[$tour['id']][$countPackage] . ' ----- ';


                        $condition = " id='{$arrayPackage[$tour['id']][$countPackage]}' ";
                        $Model->setTable('reservation_tour_package_tb');

                        $res[] = $Model->update($dataPackage[$countPackage], $condition);

                        $sqlHotel = " SELECT id  FROM reservation_tour_hotel_tb WHERE fk_tour_package_id = '{$arrayPackage[$tour['id']][$countPackage]}' ";
                        $resultHotel = $Model->select($sqlHotel);
                        $arrayHotel = array();
                        foreach ($resultHotel as $hotel) {
                            $arrayHotel[] = $hotel['id'];
                        }


                        for ($countHotel = 0; $countHotel <= $param['countHotel' . $countPackage]; $countHotel++) {
                            //echo ' hotel: ' . $arrayHotel[$countHotel] . ' ----- ';

                            $hotel_name = $objController->ShowName('reservation_hotel_tb', $param['hotelId' . $countPackage . $countHotel]);

                            $dataHotel[$countPackage . $countHotel]['fk_city_id'] = $param['cityId' . $countPackage . $countHotel];
                            $dataHotel[$countPackage . $countHotel]['city_name'] = $param['cityName' . $countPackage . $countHotel];
                            $dataHotel[$countPackage . $countHotel]['fk_hotel_id'] = $param['hotelId' . $countPackage . $countHotel];
                            $dataHotel[$countPackage . $countHotel]['hotel_name'] = $hotel_name;
                            $dataHotel[$countPackage . $countHotel]['room_service'] = $param['roomService' . $countPackage . $countHotel];
                            $dataHotel[$countPackage . $countHotel]['room_type'] = $param['roomType' . $countPackage . $countHotel];
                            $dataHotel[$countPackage . $countHotel]['is_del'] = 'no';
                            $dataHotel[$countPackage . $countHotel]['fk_tour_id'] = $tour['id'];
                            $dataHotel[$countPackage . $countHotel]['fk_tour_package_id'] = $arrayPackage[$tour['id']][$countPackage];

                            $condition = " id='{$arrayHotel[$countHotel]}' ";
                            $Model->setTable('reservation_tour_hotel_tb');
                            $res[] = $Model->update($dataHotel[$countPackage . $countHotel], $condition);

                            $this->reservation_tour_discount_model->delete([
                                'tour_package_id' => $arrayPackage[$tour['id']][$countPackage]
                            ]);

                            foreach ($counter_types as $type_key => $type) {
                                $discount_params = [];
                                foreach ($result_tour_local_controller->tourDiscountFieldsIndex() as $discount_index_key => $discount_index) {

                                    $discount_params[$discount_index['index']] = str_replace(',', '', $param[$discount_index['index'] . $countPackage . $type_key]);
                                }
                                $reservation_tour_discount_data = [
                                    'tour_id' => $tour['id'],
                                    'tour_package_id' => $arrayPackage[$tour['id']][$countPackage],
                                    'counter_type_id' => $type['id'],
                                ];
                                $reservation_tour_discount_data = array_merge($reservation_tour_discount_data, $discount_params);
                                $this->reservation_tour_discount_model->insertWithBind($reservation_tour_discount_data);
                            }


                        }


                    }
                    else {
                        //echo ' insert: ' . $tour['id'] . ' ----- ';


                        $Model->setTable('reservation_tour_package_tb');
                        $res[] = $Model->insertLocal($dataPackage[$countPackage]);
                        $fk_tour_package_id = $Model->getLastId();

                        for ($countHotel = 0; $countHotel <= $param['countHotel' . $countPackage]; $countHotel++) {
                            if (isset($param['hotelId' . $countPackage . $countHotel]) && $param['hotelId' . $countPackage . $countHotel] != '') {
                                //echo ' hotel: ' . $fk_tour_package_id . ' ----- ';

                                $hotel_name = $objController->ShowName('reservation_hotel_tb', $param['hotelId' . $countPackage . $countHotel]);

                                $dataHotel[$countPackage . $countHotel]['fk_city_id'] = $param['cityId' . $countPackage . $countHotel];
                                $dataHotel[$countPackage . $countHotel]['city_name'] = $param['cityName' . $countPackage . $countHotel];
                                $dataHotel[$countPackage . $countHotel]['fk_hotel_id'] = $param['hotelId' . $countPackage . $countHotel];
                                $dataHotel[$countPackage . $countHotel]['hotel_name'] = $hotel_name;
                                $dataHotel[$countPackage . $countHotel]['room_service'] = $param['roomService' . $countPackage . $countHotel];
                                $dataHotel[$countPackage . $countHotel]['room_type'] = $param['roomType' . $countPackage . $countHotel];
                                $dataHotel[$countPackage . $countHotel]['is_del'] = 'no';
                                $dataHotel[$countPackage . $countHotel]['fk_tour_id'] = $tour['id'];
                                $dataHotel[$countPackage . $countHotel]['fk_tour_package_id'] = $fk_tour_package_id;

                                $Model->setTable('reservation_tour_hotel_tb');
                                $res[] = $Model->insertLocal($dataHotel[$countPackage . $countHotel]);


                                $this->reservation_tour_discount_model->delete([
                                    'tour_package_id' => $arrayPackage[$tour['id']][$countPackage]
                                ]);

                                foreach ($counter_types as $type_key => $type) {
                                    $discount_params = [];
                                    foreach ($result_tour_local_controller->tourDiscountFieldsIndex() as $discount_index_key => $discount_index) {
                                        $discount_params[$discount_index['index']] = str_replace(',', '', param[$discount_index['index'] . $countPackage . $type_key]);
                                    }
                                    $reservation_tour_discount_data = [
                                        'tour_id' => $tour['id'],
                                        'tour_package_id' => $fk_tour_package_id,
                                        'counter_type_id' => $type['id'],
                                    ];
                                    $reservation_tour_discount_data = array_merge($reservation_tour_discount_data, $discount_params);
                                    $this->reservation_tour_discount_model->insertWithBind($reservation_tour_discount_data);
                                }


                            }
                        }

                    }


                }


            }

        } else {
            return functions::withError(null, 401, functions::Xmlinformation('ErrorChanges')->__toString());
        }


        if (isset($res) && in_array('0', $res)) {
            return functions::withError(null, 401, functions::Xmlinformation('ErrorChanges')->__toString());
        } else {
            return functions::withSuccess($param['id_same'], 200, functions::Xmlinformation('TourEntrySuccessfullyCompleted')->__toString());

        }

    }
    #endregion


    #region editOneDayTourWithIdSame
    public function editOneDayTourWithIdSame($param) {
        $Model = Load::library('Model');
        $dateNow = dateTimeSetting::jtoday();
        $temp_array_edit_tour = [];
        foreach ($param['data'] as $edit_tour) {

            $temp_array_edit_tour[$edit_tour['name']] = $edit_tour['value'];
        }


        $param = $temp_array_edit_tour;

        $data['adult_price_one_day_tour_r'] = str_ireplace(",", "", $param['adultPriceOneDayTourR']);
        $data['child_price_one_day_tour_r'] = str_ireplace(",", "", $param['childPriceOneDayTourR']);
        $data['infant_price_one_day_tour_r'] = str_ireplace(",", "", $param['infantPriceOneDayTourR']);
        $data['adult_price_one_day_tour_a'] = str_ireplace(",", "", $param['adultPriceOneDayTourA']);
        $data['child_price_one_day_tour_a'] = str_ireplace(",", "", $param['childPriceOneDayTourA']);
        $data['infant_price_one_day_tour_a'] = str_ireplace(",", "", $param['infantPriceOneDayTourA']);


        $sql = "SELECT 
                    adult_price_one_day_tour_r, child_price_one_day_tour_r, infant_price_one_day_tour_r,
                    adult_price_one_day_tour_a, child_price_one_day_tour_a, infant_price_one_day_tour_a,
                    tour_name, tour_code
                FROM reservation_tour_tb 
                WHERE 
                  id_same={$param['id_same']}
                  AND is_del = 'no'
                  AND ( 
                  adult_price_one_day_tour_r != '{$data['adult_price_one_day_tour_r']}'
                  OR child_price_one_day_tour_r != '{$data['child_price_one_day_tour_r']}'
                  OR infant_price_one_day_tour_r != '{$data['infant_price_one_day_tour_r']}'
                  OR adult_price_one_day_tour_a != '{$data['adult_price_one_day_tour_a']}'
                  OR adult_price_one_day_tour_a != '{$data['adult_price_one_day_tour_a']}'
                  OR adult_price_one_day_tour_a != '{$data['adult_price_one_day_tour_a']}'
                  OR child_price_one_day_tour_a != '{$data['child_price_one_day_tour_a']}'
                  OR infant_price_one_day_tour_a != '{$data['infant_price_one_day_tour_a']}'
                  )
                  ";
        $resultTour = $Model->load($sql, 'assoc');

        $dataLogs = [];
        if (!empty($resultTour)) {

            $dataLogs['fk_tour_id'] = (!empty($param['fk_tour_id'])) ? $param['fk_tour_id'] : '';
            $dataLogs['fk_tour_id_same'] = (!empty($param['id_same'])) ? $param['id_same'] : '';
            $dataLogs['tour_name'] = $resultTour['tour_name'];
            $dataLogs['tour_code'] = $resultTour['tour_code'];
            $dataLogs['flag_one_day_tour'] = 'yes';
            unset($resultTour['tour_name']);
            unset($resultTour['tour_code']);
            $dataLogs['old_price'] = json_encode($resultTour);
            $dataLogs['new_price'] = json_encode($data);
            $dataLogs['number_package'] = '';
            $dataLogs['create_date_in'] = $dateNow;
            $dataLogs['create_time_in'] = date('H:i:s');

            $Model->setTable('reservation_change_tour_prices_logs');
            $Model->insertLocal($dataLogs);
        }

        if (isset($param['currencyTypeOneDayTour']) && $param['currencyTypeOneDayTour'] != '') {
            $objCurrency = Load::controller('currencyEquivalent');
            $infoCurrency = $objCurrency->InfoCurrency($param['currencyTypeOneDayTour']);
            $data['currency_type_one_day_tour'] = $infoCurrency['CurrencyTitle'];
        } else {
            $data['currency_type_one_day_tour'] = '';
        }

        $condition = "id_same={$param['id_same']}";
        $Model->setTable('reservation_tour_tb');
        $res = $Model->update($data, $condition);

        if ($res) {
            $result_tour_local_controller = $this->getController('resultTourLocal');
            $counter_type_controller = $this->getController('counterType');
            $counter_types = $counter_type_controller->listCounterType();

            $this->reservation_tour_discount_model->delete([
                'tour_id' => $param['id_same']
            ]);

            foreach ($counter_types as $type_key => $type) {
                $discounts = $result_tour_local_controller->tourDiscountFieldsIndex();

                $reservation_tour_discount_data = [
                    'tour_id' => $param['id_same'],
                    'tour_package_id' => 0,
                    'counter_type_id' => $type['id'],
                ];

                foreach ($discounts as $discount_index_key => $discount_index) {
                    functions::insertLog('first function ==>' . json_encode($param, $param[$discount_index['index'] . $type_key], 256), 'check_discount_counter');

                    $reservation_tour_discount_data[$discount_index['index']] = str_replace(',', '', $param[$discount_index['index'] . $type_key]);
                }

                $this->reservation_tour_discount_model->insertWithBind($reservation_tour_discount_data);
            }
            return functions::withSuccess($param['id_same'], 200, functions::Xmlinformation('TourEntrySuccessfullyCompleted')->__toString());
        } else {
            return functions::withError(null, 401, functions::Xmlinformation('ErrorChanges')->__toString());
        }

    }
    #endregion


    #region reportTour
    public function reportTour($userId = null, $adminView = false) {
        $userIdSubQuery = '';
        if (isset($userId) && $userId != '') {
            $userIdSubQuery = " AND subQueryReservation.user_id = '{$userId}'";
            $userId = " WHERE T.user_id = '{$userId}' ";
        }

        $Model = Load::library('Model');
        if (SOFTWARE_LANG == 'fa') {
            $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        } else {
            $dateNow = date("Ymd");
        }
        /*
            ( SELECT min( start_date ) FROM reservation_tour_tb WHERE start_date >= '{$dateNow}' AND is_del = 'no' AND id_same = T.id_same  ) AS minDate,
                    ( SELECT max( end_date ) FROM reservation_tour_tb WHERE start_date >= '{$dateNow}' AND is_del = 'no' AND id_same = T.id_same ) AS maxDate,
                    ( SELECT max( id ) FROM reservation_change_tour_prices_logs WHERE fk_tour_id_same = T.id_same ) AS changeTourPrices,
                    T.*
        */

        $sql = "SELECT   	
                    (SELECT min(subQueryReservation.start_date) FROM reservation_tour_tb as subQueryReservation
                 	   WHERE subQueryReservation.is_del = 'no'   {$userIdSubQuery} AND subQueryReservation.id_same = T.id_same
                    GROUP BY subQueryReservation.id_same  
                    ORDER BY subQueryReservation.id_same DESC)  AS minDate,
                    (SELECT max(subQueryReservation.end_date) FROM reservation_tour_tb as subQueryReservation
                 	 WHERE subQueryReservation.is_del = 'no'  {$userIdSubQuery} AND subQueryReservation.id_same = T.id_same
                    GROUP BY subQueryReservation.id_same  
                    ORDER BY subQueryReservation.id_same DESC)  AS maxDate,
                    T.id,
                    T.tour_type_id,
                    T.user_id,
                    T.discount_type,
                    T.is_show,
                    T.is_del,
                    T.tour_name,
                    T.tour_name_en,
                    T.priority,
                    T.tour_code,
                    T.night,
                    T.`day`,
                    T.`create_date_in`,
                    T.`create_time_in`,
                    T.`discount`,
                    T.`language`,
                    T.`id_same`,
                    T.`suggested`,
                    T.`is_special`,
                    TR.destination_country_name,
                    TR.destination_country_id,
                    TR.destination_city_id,
                    TR.destination_city_name
                FROM
                    reservation_tour_tb as T 
                INNER JOIN reservation_tour_rout_tb AS TR ON T.id=TR.fk_tour_id

               
                    {$userId} 
                GROUP BY T.id_same 
                ORDER BY T.id_same
                  
               
                 DESC ";


        $tour = $Model->select($sql);
        echo '<span style="display:none;">' . $sql . '</span>';

        return $tour;
    }
    #endregion


    #region infoTourById
    public function infoTourById($id) {

        $Model = Load::library('Model');
        $sql = " SELECT T.*,RC.name,RC.name_en,RCOUNTRY.name as country_name,RCOUNTRY.name_en as country_name_en 
                 FROM reservation_tour_tb T
                INNER JOIN reservation_city_tb RC ON T.origin_city_id=RC.id
                INNER JOIN reservation_country_tb RCOUNTRY ON T.origin_country_id=RCOUNTRY.id
                                                                                 
                WHERE T.id = '{$id}' AND T.is_del = 'no' ";
        $tour = $Model->load($sql);
        if ($tour) {
            if (empty($tour['tour_cover'])) {
                $tour['tour_cover'] = $tour['tour_pic'];
            }
        }

        return $tour;
    }
    #endregion

    #region infoTourById
    public function infoTourByIdSameDetail($id) {

        if (SOFTWARE_LANG == 'fa') {
            $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        } else {
            $dateNow = date("Ymd");
        }
        $Model = Load::library('Model');
        $sql = " SELECT T.*,RC.name,RC.name_en,RCOUNTRY.name as country_name,RCOUNTRY.name_en as country_name_en 
                 FROM reservation_tour_tb T
                INNER JOIN reservation_city_tb RC ON T.origin_city_id=RC.id
                INNER JOIN reservation_country_tb RCOUNTRY ON T.origin_country_id=RCOUNTRY.id
                                                                                 
                WHERE T.id_same = '{$id}' AND T.start_date >= '{$dateNow}'   AND T.is_del = 'no' ORDER BY id asc LIMIT 0,1 ";
        $tour = $Model->load($sql);
        if ($tour) {
            if (empty($tour['tour_cover'])) {
                $tour['tour_cover'] = $tour['tour_pic'];
            }
        }

        return $tour;
    }
    #endregion
        #region infoTourByDateApi
    public function infoTourByDateApi($params) {
        if ($this->api) {
            return $this->api->infoTourByDateApi($params);
        }
        return false ;
    }
        #endregion
    #region infoTourByDate
    public function infoTourByDate($tour_code, $start_date, $type_tour = null) {
        $start_date = str_replace('-', '', $start_date);
        $start_date = str_replace('/', '', $start_date);
        if ($type_tour == 'oneDayTour') {
            return $this->reservation_tour_model
                ->get()
                ->where('start_date', $start_date)
                ->where('tour_code', $tour_code)
                ->where('is_show', 'yes')
                ->where('is_del', 'no')
                ->find();
        }


        $reservation_package_table_name = $this->reservation_tour_package_model->getTable();
        $reservation_tour_hotel_table_name = $this->reservation_tour_hotel_model->getTable();
        $reservation_tour_table_name = $this->reservation_tour_model->getTable();

        return $this->reservation_tour_model->get([$reservation_package_table_name . '.* ', $reservation_tour_table_name . '.* '], true)
            ->join($reservation_package_table_name, 'fk_tour_id', 'id')
            ->join($reservation_tour_hotel_table_name, 'fk_tour_id', 'id')
            ->where($reservation_tour_table_name . '.start_date', $start_date)
            ->where($reservation_tour_table_name . '.tour_code', $tour_code)
            ->where($reservation_tour_table_name . '.is_show', 'yes')
            ->where($reservation_tour_table_name . '.is_del', 'no')
            ->where($reservation_package_table_name . '.is_del', 'no')
            ->find();
    }
    #endregion

    #region infoTourByIdSame
    public function infoTourByIdSame($id, $adminView = false) {
        if (SOFTWARE_LANG == 'fa') {
            $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        } else {
            $dateNow = date("Ymd");
        }
        $Model = Load::library('Model');
        $isDel = "AND T.is_del = 'no'";
        $isDelSubQuery = " AND is_del='no'";
        if ($adminView) {
            $isDel = '';
        }
        $sql = "SELECT
                    ( SELECT min(start_date) FROM reservation_tour_tb WHERE  id_same = T.id_same {$isDelSubQuery} ) AS minDate,
                    ( SELECT max(end_date) FROM reservation_tour_tb WHERE    id_same = T.id_same {$isDelSubQuery} ) AS maxDate,
                    T.* 
                FROM
                    reservation_tour_tb as T
                WHERE
                    T.id_same = '{$id}'
                    {$isDel}
                    ORDER BY id DESC LIMIT 0,1 ";
        $tour = $Model->load($sql);

        $tour['dateNow'] = $dateNow;

        $dateYearMinDate  = substr(  $tour['minDate'], 0, 4 );
        $dateMonthMinDate = substr(  $tour['minDate'], 4, 2 );
        $dateDayMinDate   = substr(  $tour['minDate'], 6, 2 );
        $tour['minDateChange'] = ($dateYearMinDate.'/'.$dateMonthMinDate.'/'.$dateDayMinDate);

        $dateYearMaxDate  = substr(  $tour['maxDate'], 0, 4 );
        $dateMonthMaxDate = substr(  $tour['maxDate'], 4, 2 );
        $dateDayMaxDate   = substr(  $tour['maxDate'], 6, 2 );
        $tour['maxDateChange'] = ($dateYearMaxDate.'/'.$dateMonthMaxDate.'/'.$dateDayMaxDate);

        return $tour;
    }

    public function infoTourByIdSameForEdit($id, $adminView = false) {
        if (SOFTWARE_LANG == 'fa') {
            $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        } else {
            $dateNow = date("Ymd");
        }
        $Model = Load::library('Model');
        $isDel = "AND T.is_del = 'no'";
        $isDelSubQuery = " AND is_del='no'";
        if ($adminView) {
            $isDel = '';
        }
        $sql = "SELECT
                    bookTour.id as bookTourId,
                    ( SELECT min(start_date) FROM reservation_tour_tb WHERE  id_same = T.id_same {$isDelSubQuery} ) AS minDate,
                    ( SELECT max(end_date) FROM reservation_tour_tb WHERE    id_same = T.id_same {$isDelSubQuery} ) AS maxDate,
                    T.* 
                FROM
                    reservation_tour_tb as T
                    LEFT JOIN book_tour_local_tb as bookTour ON bookTour.tour_id=T.id AND (bookTour.status='BookedSuccessfully' OR  bookTour.status='PreReserve')
                WHERE
                    T.id_same = '{$id}'
                    {$isDel}
                    ORDER BY id DESC";
        $tours = $Model->select($sql);


        foreach ($tours as $tour) {
//            $tour['is_request']
//            var_dump($tour['bookTourId']);
            if (!empty($tour['bookTourId']) && $tour['is_request']==0 ) {
//                return [
//                    'queryStatus' => false
//                ];
            }
            $result = $tour;
        }

        $result['queryStatus'] = true;
        $result['dateNow'] = $dateNow;
        return $result;
    }


    /*public function infoTourByIdSame($id)
    {
        $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        $Model = Load::library('Model');
        echo $sql = "SELECT
                    ( SELECT min( start_date ) FROM reservation_tour_tb WHERE start_date >= '{$dateNow}' AND id_same = T.id_same ) AS minDate,
                    ( SELECT max( end_date ) FROM reservation_tour_tb WHERE start_date >= '{$dateNow}' AND id_same = T.id_same ) AS maxDate,
                    T.*
                FROM
                    reservation_tour_tb as T
                WHERE
                    T.id_same = '{$id}'
                    AND T.start_date >= '{$dateNow}'
                    AND T.is_del = 'no'
            ";
        $tour = $Model->load($sql);
        return $tour;
    }*/
    #endregion

    #region getListTourDates
    public function getListTourDates($id) {
        $Model = Load::library('Model');
//        $sql = " SELECT * FROM reservation_tour_tb WHERE id_same = '{$id}' AND is_del = 'no' ORDER BY start_date";
        $sql = " SELECT * FROM reservation_tour_tb WHERE id_same = '{$id}' ORDER BY start_date";
        $tour = $Model->select($sql);
        return $tour;
    }
    #endregion

    #region infoTourRoutById
    public function infoTourRoutById($id) {
        $Model = Load::library('Model');
        $sql = " SELECT * FROM reservation_tour_rout_tb WHERE id = '{$id}' AND is_del = 'no' ";
        $tour = $Model->select($sql);
        return $tour;
    }
    #endregion

    #region infoTourSuggestedByTourId
    public function infoTourSuggestedByTourId($tourId, $cityId) {
        if (SOFTWARE_LANG === 'fa') {
            $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        } else {
            $dateNow = date("Ymd", time());
        }

        $WHERE = " AND T.start_date >= '{$dateNow}' ";

        if (is_array($tourId)) {

            $tourCount = count($tourId) - 1;
            $availableToursId = '(';
            foreach ($tourId as $k => $tourIdItem) {

                $availableToursId .= $tourIdItem . ($k === $tourCount ? ')' : ',');
            }
            $WHERE .= " AND T.id_same NOT IN {$availableToursId} ";
        } else {
            $WHERE .= " AND T.id_same != '{$tourId}' ";
        }


        $Model = Load::library('Model');
        $sql = " SELECT T.id , T.id_same,T.tour_name,T.tour_name_en,T.tour_type_id,
                        T.tour_code,T.start_date,T.end_date,T.night,T.`day`,T.tour_pic,
                        T.origin_continent_id,T.origin_country_id,T.is_show,T.is_special,T.is_del,
                        T.`language`,
                        T.origin_city_name,
                        T.origin_region_name,
                        T.origin_country_name,
                        TR.destination_country_name,
                        TR.destination_city_name,
                        TR.destination_region_name,
                        TR.airline_name,
                        TR.type_vehicle_name,
                        TR.exit_hours,
                        TR.airline_id,
                        TR.type_vehicle_id,
                        TR.tour_title,
                        TR.destination_country_id,
                        TR.id AS idRout
                        FROM reservation_tour_tb AS T
                        INNER JOIN reservation_tour_rout_tb AS TR ON T.id=TR.fk_tour_id
                        WHERE T.is_del = 'no'
                      AND T.is_show = 'yes' 
                      AND TR.tour_title='dept' 
                      AND T.suggested = '1' 
                      AND T.origin_city_id = '{$cityId}'
                    
                      {$WHERE}
                      GROUP BY T.tour_code
                      ORDER BY T.priority=0,T.priority ASC";

        return $Model->select($sql);
    }
    #endregion

    #region infoTourRoutByIdTour
    public function infoTourRoutByIdTour($id, $type = null ) {
        $Model = Load::library('Model');
        $sql = " SELECT TR.*,RC.name,RC.name_en,RCOUNTRY.name as country_name,RCOUNTRY.name_en as country_name_en FROM reservation_tour_rout_tb TR
                INNER JOIN reservation_city_tb RC ON TR.destination_city_id=RC.id
                INNER JOIN reservation_country_tb RCOUNTRY ON TR.destination_country_id=RCOUNTRY.id
                WHERE TR.fk_tour_id = '{$id}' AND TR.is_del = 'no'  ";
        if ($type == 'dept') {
            $sql .= " AND TR.tour_title='dept' ";
        } elseif ($type == 'return') {
            $sql .= " AND TR.tour_title='return' ";
        }
        $sql .= " ORDER BY TR.tour_title ";

        $tour = $Model->select($sql);
        return $tour;
    }
    #endregion

    #region infoTourPackageById
    public function infoTourPackageById($id) {
        $Model = Load::library('Model');
        $sql = " SELECT * FROM reservation_tour_package_tb WHERE id = '{$id}' AND is_del = 'no' ";
        $tour = $Model->load($sql);
        return $tour;
    }
    #endregion

    #region infoTourPackageByIdTour
    public function infoTourPackageByIdTour($id) {
        $result = $this->reservation_tour_package_model->get()
            ->where('fk_tour_id', $id)
            ->where('is_del', 'no')
            ->all();

        return $result;
    }
    #endregion


    #region infoTourRoutHotelById
    public function infoTourHotelById($id) {
        $Model = Load::library('Model');
        $sql = " SELECT * FROM reservation_tour_hotel_tb WHERE id = '{$id}' AND is_del = 'no' ";
        $tour = $Model->select($sql);
        return $tour;
    }
    #endregion


    //////  کشور/////
    public function FindCountry($id) {
        $Model = Load::library('Model');

        $sql = " SELECT * FROM reservation_country_tb WHERE id='{$id}'";
        $country = $Model->select($sql);

        return $country[0];
    }

    public function FindCity($id) {
        $Model = Load::library('Model');

        $sql = " SELECT * FROM reservation_city_tb WHERE id='{$id}'";
        $city = $Model->select($sql);

        return $city[0];
    }

    #region infoTourHotelByIdTour
    public function infoTourHotelByIdPackage($id,$is_api=null) {

        if($is_api){

            return $this->getInfoHotelPackagesApi($id);
        }


        $hotel_table = $this->reservation_tour_hotel_model->getTable();
        $city_table = $this->reservation_city_model->getTable();
        return $this->reservation_tour_hotel_model->get([
            $hotel_table . '.*',
            $city_table . '.name',
            $city_table . '.name_en as city_name_en'
        ], true)
            ->join($city_table, 'id', 'fk_city_id', 'inner')
            ->where($hotel_table . '.fk_tour_package_id', $id)
            ->where($hotel_table . '.is_del', 'no')
            ->all();
    }
    #endregion

    #region infoTourHotelByIdTour
    public function infoTourRoutByIdPackage($PackageId, $CityId,$api=false) {

        if($api){
            return $this->infoTourRoutByIdPackageApi($PackageId,$CityId);
        }
        $Model = Load::library('Model');
        $sql = "SELECT
                    * 
                FROM
                    reservation_tour_hotel_tb AS TourHotel
                    LEFT JOIN reservation_tour_rout_tb AS Rout ON Rout.fk_tour_id = TourHotel.fk_tour_id
                WHERE
                    TourHotel.fk_tour_package_id = '{$PackageId}' 
                    AND Rout.destination_city_id = '{$CityId}'
                    AND TourHotel.fk_city_id = '{$CityId}'
                    AND TourHotel.is_del = 'no'
                    AND Rout.is_del = 'no'";

        $tour = $Model->select($sql);
        return $tour;
    }
    #endregion

    #region infoTourHotelByIdTourPackage
    public function infoTourHotelByIdTourPackage($id) {
        return $this->reservation_tour_hotel_model->get()
            ->where('fk_tour_package_id', $id)
            ->where('is_del', 'no')
            ->all();
    }

    #endregion

    public function getTourDiscountByPackageId($package_id) {
        return $this->reservation_tour_discount_model->get()
            ->where('tour_package_id', $package_id)
            ->all();
    }

    public function getTourDiscountByIdSame($id_same) {
        return $this->reservation_tour_discount_model->get()
            ->where('tour_id', $id_same)
            ->all();
    }

    #region registerIsShowTour
    public function registerIsShowTour($id, $isShow, $detail) {


        $Model = Load::library('Model');

        $tour = $this->reservation_tour_model->get()
            ->where('id_same', $id)
            ->find();

        if ($isShow == 'yes') {
            $data['change_price'] = str_ireplace(",", "", $detail);
            $data['comment_cancel'] = '';
            $data['is_del'] = 'no';
            $sms = 'تور '. $tour['tour_name'] .' شما توسط مدیریت تایید شد.' ;
        } elseif ($isShow == 'no') {
            $data['comment_cancel'] = $detail;
            $data['change_price'] = 0;
            $sms = 'تور '.$tour['tour_name'].' شما به دلیل '.$detail.' توسط مدیریت رد شد.' ;
        }

        $data['is_show'] = $isShow;


        $types = json_decode($tour['tour_type_id'], true);
        foreach ($types as $type) {
            $this->getModel('reservationTourTypeModel')->updateWithBind([
                'is_approved' => 1
            ], [
                'id' => $type
            ]);
        }

        $res = $this->reservation_tour_model->updateWithBind($data, [
            'id_same' => $tour['id_same']
        ]);

       $smsController = Load::controller('smsServices');
       $UserController = Load::controller('user');
       $objSms = $smsController->initService('1');
       $UserProfile = $UserController->getProfile($tour['user_id']);
       $UserProfileMobile = $UserProfile['mobile'];
       $smsArray = array(
            'smsMessage' => $sms,
            'cellNumber' => $UserProfileMobile);
       $smsController->sendSMS($smsArray);

        return "success: " . functions::Xmlinformation('ChangesSuccessfullyCompleted');
        /*   if ($res) {
               return "success: ".functions::Xmlinformation('ChangesSuccessfullyCompleted');
           } else {
               return "error: اشکالی در فرایند رخ داده است، لطفا مجددا تلاش کنید.";
           }*/

    }
    #endregion

    #region deletionPackage
    public function deletionPackage($id) {
        $Model = Load::library('Model');
        $data['is_del'] = 'yes';
        $Condition = "id='{$id}' ";
        $Model->setTable("reservation_tour_package_tb");
        $res[] = $Model->update($data, $Condition);

        $conditionHotel = "fk_tour_package_id='{$id}'";
        $Model->setTable('reservation_tour_hotel_tb');
        $res[] = $Model->update($data, $conditionHotel);

        if (in_array('0', $res)) {
            return "error: اشکالی در فرایند رخ داده است، لطفا مجددا تلاش کنید.";
        } else {
            return "success: " . functions::Xmlinformation('ChangesSuccessfullyCompleted');;
        }

    }
    #endregion

    #region deletionGroupPackage
    public function deletionGroupPackage($idSame, $numberPackage) {


        $tours = $this->reservation_tour_model->get()
            ->where('id_same', $idSame)
            ->all();
        foreach ($tours as $tour) {
            $packages = $this->reservation_tour_package_model->get()
                ->where('fk_tour_id', $tour['id'])
                ->where('number_package', $numberPackage)
                ->all();
            foreach ($packages as $package) {
                $this->reservation_tour_package_model->delete([
                    'id' => $package['id']
                ]);

                $this->reservation_tour_hotel_model->delete([
                    'fk_tour_package_id' => $package['id']
                ]);

                $this->reservation_tour_discount_model->delete([
                    'tour_package_id' => $package['id']
                ]);
            }
        }

        return "success: " . functions::Xmlinformation('ChangesSuccessfullyCompleted');
    }

    public function deletionGroupPackageByTourId($tour_id, $numberPackage) {
        $tour = $this->reservation_tour_model->get()
            ->where('id', $tour_id)
            ->find();

        $packages = $this->reservation_tour_package_model->get()
            ->where('fk_tour_id', $tour['id'])
            ->where('number_package', $numberPackage)
            ->all();
        foreach ($packages as $package) {
            $this->reservation_tour_package_model->delete([
                'id' => $package['id']
            ]);

            $this->reservation_tour_hotel_model->delete([
                'fk_tour_package_id' => $package['id']
            ]);

            $this->reservation_tour_discount_model->delete([
                'tour_package_id' => $package['id']
            ]);
        }


        return "success: " . functions::Xmlinformation('ChangesSuccessfullyCompleted');
    }
    #endregion


    #region deletionRout
    public function deletionRout($id) {
        $Model = Load::library('Model');
        $data['is_del'] = 'yes';
        $Condition = "id='{$id}' ";
        $Model->setTable("reservation_tour_rout_tb");
        $res = $Model->update($data, $Condition);
        if ($res) {
            return "success: " . functions::Xmlinformation('ChangesSuccessfullyCompleted');
        } else {
            return "error: اشکالی در فرایند رخ داده است، لطفا مجددا تلاش کنید.";
        }

    }
    #endregion


    #region pageShowUserComments
    public function getAllUserComments() {
        $Model = Load::library('Model');
        $sql = "
        SELECT
            comments.*,
            tour.id AS tourId,
            tour.tour_name AS tourName,
            tour.tour_code AS tourCode,
            tour.id_same AS tourIdSame
        FROM
            user_comments_tb AS comments
            INNER JOIN reservation_tour_tb AS tour ON comments.fk_id_page = tour.id_same 
        WHERE
            comments.page = 'reservationTour' AND tour.is_del = 'no'
        GROUP BY
            comments.id 
        ORDER BY
            comments.id 
        ";
        $result = $Model->select($sql);

        return $result;

    }
    #endregion


    #region registerIsShowUserComments
    public function registerIsShowUserComments($id, $isShow) {
        $Model = Load::library('Model');
        $data['is_show'] = $isShow;
        $Condition = "id='{$id}' ";
        $Model->setTable("user_comments_tb");
        $res = $Model->update($data, $Condition);
        if ($res) {
            return "success: " . functions::Xmlinformation('ChangesSuccessfullyCompleted');
        } else {
            return "error: اشکالی در فرایند رخ داده است، لطفا مجددا تلاش کنید.";
        }

    }
    #endregion


    #region insertTourGallery
    public function insertTourGallery($param, $file) {


        $Model = Load::library('Model');

        $config = Load::Config('application');
        $config->pathFile('reservationTour/');
        if (isset($file['pic']) && $file['pic'] != "") {
            $_FILES['pic']['name'] = self::changeNameUpload($_FILES['pic']['name']);
            $success = $config->UploadFile("", "pic", "");
            $exp_name_pic = explode(':', $success);
            if ($exp_name_pic[0] == "done") {

                $data['pic_name'] = $exp_name_pic[1];
                $data['pic_title'] = $param['picTitle'];
                $data['fk_tour_id_same'] = $param['tourIdSame'];
                $data['is_del'] = 'no';

                $Model->setTable('reservation_tour_gallery_tb');
                $res = $Model->insertLocal($data);

                if ($res) {
                    return "success: " . functions::Xmlinformation("ChangesSuccessfullyCompleted");
                } else {
                    return "error: " . functions::Xmlinformation("BugProcessOccurredTryAgain");
                }


            } else {
                return "error: " . functions::Xmlinformation("BugProcessOccurredTryAgain");
            }

        } else {
            return "error: " . functions::Xmlinformation("BugProcessOccurredTryAgain");
        }


    }
    #endregion


    #region isEditor
    public function isEditor($title= 'editor' , $service = 'tour') {
        $reservationSettingController = $this->getController('reservationSetting');
        return $reservationSettingController->getReservationSettingByTitleService($title , $service);
    }
    #endregion

    #region isEditorActive
    public function isEditorActive($id) {
        $reservationSettingController = $this->getController('reservationSetting');
        $res = $reservationSettingController->changeEnable($id);
        if ($res) {
            return 'success : ' . functions::Xmlinformation('ChangesSuccessfullyCompleted');
        } else {
            return 'error ' . functions::Xmlinformation('ErrorChanges');
        }

    }
    #endregion

    #region isSpecialTour
    public function isSpecialTour($idSame) {
        $Model = Load::library('Model');

        $sql = " SELECT is_special FROM reservation_tour_tb WHERE id_same='{$idSame}'";
        $result = $Model->load($sql);

        if ($result['is_special'] == 'yes') {
            $data['is_special'] = 'no';
        } else {
            $data['is_special'] = 'yes';
        }
        $condition = "id_same='{$idSame}' ";
        $Model->setTable("reservation_tour_tb");
        $res = $Model->update($data, $condition);

        if ($res) {
            return 'success : ' . functions::Xmlinformation('ChangesSuccessfullyCompleted');
        } else {
            return 'error ' . functions::Xmlinformation('ErrorChanges');
        }

    }
    #endregion

    #region changeSuggestedStatus
    public function changeSuggestedStatus($idSame) {
        $Model = Load::library('Model');

        $sql = " SELECT suggested FROM reservation_tour_tb WHERE id_same='{$idSame}'";
        $result = $Model->load($sql);

        if ($result['suggested'] == '1') {
            $data['suggested'] = '0';
        } else {
            $data['suggested'] = '1';
        }
        $condition = "id_same='{$idSame}' ";
        $Model->setTable("reservation_tour_tb");
        $res = $Model->update($data, $condition);

        if ($res) {
            return 'success : ' . functions::Xmlinformation('ChangesSuccessfullyCompleted');
        } else {
            return 'error ' . functions::Xmlinformation('ErrorChanges');
        }

    }
    #endregion

    #region isFirstTour
    public function isFirstTour($idSame) {
        $Model = Load::library('Model');

        $sql = " SELECT is_first FROM reservation_tour_tb WHERE id_same='{$idSame}'";
        $result = $Model->load($sql);

        if ($result['is_first'] == 'yes') {
            $data['is_first'] = 'no';
        } else {

            $dataAll['is_first'] = 'no';
            $Model->setTable("reservation_tour_tb");
            $Model->update($dataAll, '');

            $data['is_first'] = 'yes';
        }
        $condition = "id_same='{$idSame}' ";
        $Model->setTable("reservation_tour_tb");
        $res = $Model->update($data, $condition);

        if ($res) {
            return 'success : ' . functions::Xmlinformation('ChangesSuccessfullyCompleted');
        } else {
            return 'error ' . functions::Xmlinformation('ErrorChanges');
        }

    }
    #endregion


    #region setStartTimeLastMinuteTour
    public function setStartTimeLastMinuteTour($idSame, $startTimeLastMinuteTour) {
        $Model = Load::library('Model');

        $data['start_time_last_minute_tour'] = $startTimeLastMinuteTour;

        $condition = "id_same='{$idSame}' ";
        $Model->setTable("reservation_tour_tb");
        $res = $Model->update($data, $condition);

        if ($res) {
            return 'success : ' . functions::Xmlinformation('ChangesSuccessfullyCompleted');
        } else {
            return 'error ' . functions::Xmlinformation('ErrorChanges');
        }

    }
    #endregion


    #region logicalDeletion
    public function logicalDeletion($id, $type) {

        $Model = Load::library('Model');

        $tourDetail = $this->getModel('reservationTourModel')
            ->get(['is_del'], false)
            ->where($type, $id)
            ->all();
        $data['is_del'] = $tourDetail[0]['is_del'] == 'yes' ? 'no' : 'yes';
    

        


        $condition = "{$type}='{$id}'";
        $Model->setTable('reservation_tour_tb');
        $res[] = $Model->update($data, $condition);

        if ($type == 'id') {

            $condition = "fk_tour_id='{$id}'";

            $Model->setTable('reservation_tour_rout_tb');
            $res[] = $Model->update($data, $condition);

            $Model->setTable('reservation_tour_package_tb');
            $res[] = $Model->update($data, $condition);

            $Model->setTable('reservation_tour_hotel_tb');
            $res[] = $Model->update($data, $condition);
        }


        if (in_array('0', $res)) {
            return 'error : ' . functions::Xmlinformation('ErrorRemovingChanges');
        } else {
            return 'success : ' . functions::Xmlinformation('SuccessRemove');
        }
    }
    #endregion

    #region logicalDeletionGalleryTour
    public function logicalDeletionGalleryTour($id) {
        $Model = Load::library('Model');

        $data['is_del'] = 'yes';

        $condition = "id='{$id}'";
        $Model->setTable('reservation_tour_gallery_tb');
        $res = $Model->update($data, $condition);

        if ($res) {
            return 'success ' . functions::Xmlinformation('SuccessRemove');
        } else {
            return 'error : ' . functions::Xmlinformation('ErrorRemovingChanges');
        }
    }
    #endregion


    #region getHotelByCityId
    public function getHotelByCityId($id) {

        $Model = Load::library('Model');
        $sql = "select id, name from reservation_hotel_tb where city='{$id}' AND is_del='no'";
        $result = $Model->select($sql);

        return $result;

    }

    #endregion

    public function getRoomsTypeHotelPackageTour($data_get_hotel) {

        $result_rooms = $this->getController('reservationBasicInformation')->ListHotelRoom($data_get_hotel['hotel_id']);

        if (isset($data_get_hotel['is_json']) && $data_get_hotel['is_json']) {
            return functions::withSuccess($result_rooms, 200, 'اطلاعات با موفقیت دریافت شد');
        }
        return $result_rooms;
    }


    #region textNumber
    public function textNumber($number) {
        switch ($number) {
            case '1':
                $textNumber = functions::Xmlinformation('First');
                break;
            case '2':
                $textNumber = functions::Xmlinformation('Second');
                break;
            case '3':
                $textNumber = functions::Xmlinformation('Third');
                break;
            case '4':
                $textNumber = functions::Xmlinformation('Fourth');
                break;
            case '5':
                $textNumber = functions::Xmlinformation('Fifth');
                break;
            case '6':
                $textNumber = functions::Xmlinformation('Sixth');
                break;
            case '7':
                $textNumber = functions::Xmlinformation('Seventh');
                break;
            case '8':
                $textNumber = functions::Xmlinformation('Eighth');
                break;
            case '9':
                $textNumber = functions::Xmlinformation('ninth');
                break;
            default:
                $textNumber = '';
                break;
        }

        return $textNumber;

    }
    #endregion


    #region archiveReportTour
    public function archiveReportTour($userId = null) {
        if (isset($userId) && $userId != '') {
            $userId = " AND user_id = '{$userId}' ";
        }
        $Model = Load::library('Model');
        $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        $sql = "SELECT
                    ( SELECT min( start_date ) FROM reservation_tour_tb WHERE start_date < '{$dateNow}' AND id_same = T.id_same ) AS minDate,
                    ( SELECT max( end_date ) FROM reservation_tour_tb WHERE start_date < '{$dateNow}' AND id_same = T.id_same ) AS maxDate,
                    T.* 
                FROM
                    reservation_tour_tb as T
                WHERE
                    T.is_del = 'no'
                    AND T.start_date < '{$dateNow}'
                    {$userId} 
                GROUP BY T.id_same 
                ORDER BY T.id_same DESC";
        $tour = $Model->select($sql);
        return $tour;
    }
    #endregion


    #region archiveTourByIdSame
    public function archiveTourByIdSame($id) {
        $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        $Model = Load::library('Model');
        $sql = "SELECT
                    ( SELECT min( start_date ) FROM reservation_tour_tb WHERE start_date < '{$dateNow}' AND id_same = T.id_same ) AS minDate,
                    ( SELECT max( end_date ) FROM reservation_tour_tb WHERE start_date < '{$dateNow}' AND id_same = T.id_same ) AS maxDate,
                    T.* 
                FROM
                    reservation_tour_tb as T
                WHERE
                    T.id_same = '{$id}'
                    AND T.start_date < '{$dateNow}'
                    AND T.is_del = 'no'
            ";
        $tour = $Model->load($sql);
        return $tour;
    }
    #endregion


    #region getChangeTourPricesLogs
    public function getChangeTourPricesLogs($idSame) {
        $Model = Load::library('Model');
        $sql = "select * from reservation_change_tour_prices_logs where fk_tour_id_same='{$idSame}' order by id DESC";
        $result = $Model->select($sql, 'assoc');

        return $result;

    }
    #endregion


    #region setDiscountTour
    public function setDiscountTour($param) {
        $Model = Load::library('Model');
        $dataUpdate['discount_type'] = $param['discountType'];
        $dataUpdate['discount'] = $param['discount'];
        $dataUpdate['is_show'] = '';
        $condition = " id_same = '{$param['idSameTour']}' ";
        $Model->setTable('reservation_tour_tb');
        $resultUpdate = $Model->update($dataUpdate, $condition);

        if ($resultUpdate) {
            return 'success : ' . functions::Xmlinformation('SubmittedTourEdit');
        } else {
            return 'error ' . functions::Xmlinformation('ErrorChanges');
        }

    }

    #endregion


    public function orderTour() {

        $Model = Load::library('Model');
        $sql = " SELECT * FROM reservation_tour_setting_tb WHERE is_del='no' ORDER BY id ASC ";
        $res = $Model->select($sql);
        return $res;

    }

    public function orderTourActive($id) {

        $Model = Load::library('Model');

        $sql = " SELECT enable FROM reservation_tour_setting_tb WHERE id='{$id}' AND is_del='no' ";
        $orderHotel = $Model->load($sql);

        if ($orderHotel['enable'] == '1') {
            $d['enable'] = '0';
            $data['enable'] = '1';
        } else {
            $d['enable'] = '1';
            $data['enable'] = '0';
        }
        $Condition = "id='{$id}' ";
        $Model->setTable("reservation_tour_setting_tb");
        $res1 = $Model->update($d, $Condition);

        $Condition = "id!='{$id}' ";
        $Model->setTable("reservation_tour_setting_tb");
        $res2 = $Model->update($data, $Condition);

        if ($res1 && $res2) {
            return 'success :  تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در  تغییرات';
        }

    }


    public function tourBookChanger($factorNumber, array $array) {
        $condition = "factor_number='{$factorNumber}' ";

        $data = [];

        foreach ($array as $key => $item) {
          
            $data[$key] = $item;
           
        }

        $Model = Load::library('Model');
        $Model->setTable("book_tour_local_tb");
        $res1 = $Model->update($data, $condition);

        $ModelBase = Load::library('ModelBase');
        $ModelBase->setTable("report_tour_tb");
        $res2 = $ModelBase->update($data, $condition);

        if (!$res1 || !$res2) {
            return false;
        }
        return true;
    }

    public function callGetTourPackage($params) {
        functions::insertLog('start', 'slow_package');

        if($params['is_api']){
            $params['one_day'] = false ;
            return $this->getPackagesApi($params);
        }


        $result  = $this->getTourPackage($params['tour_id'], $params['start_date'], $params['end_date']);
        functions::insertLog('end', 'slow_package');
        return json_encode($result, 256);
    }

    public function getTourPackage($tour_id, $start_date, $end_date) {

//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');

        $string_start_date = str_replace(['/', '-', ' '], '', $start_date);
        functions::insertLog('******************Start Of the Story*******************', 'slow_package');
        $tour_table = $this->reservation_tour_model->getTable();
        $hotel_table = $this->reservation_tour_hotel_model->getTable();
        $package_table = $this->reservation_tour_package_model->getTable();
        $packages = $this->reservation_tour_package_model->get([
            $tour_table . '.tour_code',
            $tour_table . '.start_date',
            $tour_table . '.change_price',
            $tour_table . '.discount_type',
            $tour_table . '.discount',
            $tour_table . '.prepayment_percentage',
            $tour_table . '.adult_price_one_day_tour_r',
            $tour_table . '.child_price_one_day_tour_r',
            $tour_table . '.infant_price_one_day_tour_r',
            $package_table . '.*'
        ], true)
            ->join($tour_table, 'id', 'fk_tour_id', 'INNER')
            ->join($tour_table, 'fk_tour_id', 'id', 'INNER', $hotel_table)
            ->where($tour_table . '.id', $tour_id)
            ->where($tour_table . '.start_date', $string_start_date)
            ->where($tour_table . '.is_show', 'yes')
            ->where($tour_table . '.is_del', 'no')
            ->where($package_table . '.is_del', 'no')
            ->groupBy($package_table . '.id')
            ->orderBy($package_table . '.double_room_price_r')
            ->all();

        functions::insertLog('******************package one*******************', 'slow_package');
        $room_types = [
            "OneBed" => [
                'name' => (array)functions::Xmlinformation('OneBed')->__toString(),
                'packagePriceName' => 'single_room_price_r',
                'packageCurrencyPriceName' => 'single_room_price_a',
                'capacityValue' => 'single_room_capacity',
                'order'   => 1 ,
                'coefficient' => 1,
                'index' => 'oneBed',
                'type' => 'adult'],
            "TwoBed" => [
                'name' => (array)functions::Xmlinformation('TwoBed'),
                'packagePriceName' => 'double_room_price_r',
                'packageCurrencyPriceName' => 'double_room_price_a',
                'capacityValue' => 'double_room_capacity',
                'order'   => 2 ,
                'coefficient' => 2,
                'index' => 'twoBed',
                'type' => 'adult'],
            "ThreeBed" => [
                'name' => (array)functions::Xmlinformation('ThreeBed'),
                'packagePriceName' => 'three_room_price_r',
                'packageCurrencyPriceName' => 'three_room_price_a',
                'capacityValue' => 'three_room_capacity',
                'order'   => 3 ,
                'coefficient' => 3,
                'index' => 'threeBed',
                'type' => 'adult'],
            "Childwithbed" => [
                'name' => (array)functions::Xmlinformation('Childwithbed'),
                'packagePriceName' => 'child_with_bed_price_r',
                'packageCurrencyPriceName' => 'child_with_bed_price_a',
                'capacityValue' => 'child_with_bed_capacity',
                'order'   => 7 ,
                'coefficient' => 1,
                'index' => 'childwithbed',
                'type' => 'child'],
            "Babywithoutbed" => [
                'name' => (array)functions::Xmlinformation('Babywithoutbed'),
                'packagePriceName' => 'infant_without_bed_price_r',
                'packageCurrencyPriceName' => 'infant_without_bed_price_a',
                'capacityValue' => 'infant_without_bed_capacity',
                'order'   => 8 ,
                'coefficient' => 1,
                'index' => 'babywithoutbed',
                'type' => 'infant'],
            "Babywithoutchair" => [
                'name' => (array)functions::Xmlinformation('Babywithoutchair'),
                'packagePriceName' => 'infant_without_chair_price_r',
                'packageCurrencyPriceName' => 'infant_without_chair_price_a',
                'capacityValue' => 'infant_without_chair_capacity',
                'order'   => 9 ,
                'coefficient' => 1,
                'index' => 'babywithoutchair',
                'type' => 'infant']];

        $package_id = [];

        foreach ($packages as $package_key => $package) {
            $package_id[] = $package['id'];
        }
        functions::insertLog('******************tour number 2*******************', 'slow_package');
        $hotel_information_list = $this->getPackageHotelInfo($package_id);

        functions::insertLog('******************tour number 3*******************', 'slow_package');

        $tour_discount_package_list = $this->calculateAllPackageDiscount($package_id , $tour_id , $packages, $room_types);

        functions::insertLog('******************tour number 4*******************', 'slow_package');

        foreach ($packages as $package_key => $package) {

              $packages[$package_key]['hotels'] =  $hotel_information_list[$package['id']]['hotels'] ;

//            $hotels = $this->infoTourHotelByIdPackage($package['id']);
//
//            foreach ($hotels as $hotel_key => $hotel) {
//                $hotel_information = $this->getHotelInformation($hotel['fk_hotel_id']);
//
//                $tour_route_information = $this->infoTourRoutByIdPackage($package['id'], $hotel['fk_city_id']);
//
//                $packages[$package_key]['hotels'][$hotel_key] = $hotel_information;
//                $packages[$package_key]['hotels'][$hotel_key]['night'] = $tour_route_information[0]['night'];
//                $packages[$package_key]['hotels'][$hotel_key]['room_service'] = $tour_route_information[0]['room_service'];
//            }

//            $packages[$package_key]['rooms']=$room_types;

            foreach ($room_types as $room_key => $room_type) {

                if (SOFTWARE_LANG == 'fa') {
                    $package_currency_name = $package['currency_type'];
                } else {

                    if ($package['currency_type']) {
                        $package_currency_name = functions::changeCurrencyName($package['currency_type']);
                    } else {
                        $package_currency_name = '';
                    }
                }


//                $do_discount = ($reservationTourController->calculateDiscount($tour_id, ['minPriceR' => $package[$room_type['packagePriceName']]], $package['id'], $room_type['type']));
//
//                if (empty($do_discount['discountedMinPriceR'])) {
//                    $price_change = $this->doPriceChange($package[$room_type['packagePriceName']], $package['change_price']);
//                    if(functions::isEnableSetting('toman')) {
//                        $final_price = round($price_change / 10) ;
//                    }else{
//                        $final_price = $price_change ;
//                    }
//                } else {
//                    $price_change = $this->doPriceChange($do_discount['discountedMinPriceR'], $package['change_price']);
//                    if(functions::isEnableSetting('toman')) {
//                        $final_price = round($price_change / 10) ;
//                    }else{
//                        $final_price = $price_change ;
//                    }
//
//                }
                $room_key_index = $room_type['index'];

                $objResultTour = Load::controller('resultTourLocal');
                $discountVal = $tour_discount_package_list[$package['id']][$room_key_index]['discountedMinPriceR'];
                if (!isset($discountVal) || $discountVal === '' || $discountVal === null) {
                    // no discount
                    $price_change = $this->doPriceChange($package[$room_type['packagePriceName']], $package['change_price']);
                    $discountedPrice = $price_change;
                } else {
                    // discount exists
                    $price_change = $this->doPriceChange($discountVal, $package['change_price']);
                    $discountedPrice = $price_change;
                }
                if(functions::isEnableSetting('toman')) {
                    $final_price = round($discountedPrice / 10) ;
                } else {
                    $final_price = $discountedPrice ;
                }



//                $prepaymentPercentageValue = $reservationTourController->prePaymentCalculate($final_price, $package['prepayment_percentage']);



                if (number_format($package[$room_type['packageCurrencyPriceName']]) == 0) {
                    $package[$room_type['packageCurrencyPriceName']] = '';
                    $package_currency_name = '';
                } else {
                    $package[$room_type['packageCurrencyPriceName']] = intval($package[$room_type['packageCurrencyPriceName']]);
                }

                $show_price = intval($this->doPriceChange($package[$room_type['packagePriceName']], $package['change_price'])) ;

                if(functions::isEnableSetting('toman')) {
                    $price = round($show_price/10) ;
                }else{
                    $price = $show_price ;
                }

                $packages[$package_key]['rooms'][] = [
                    'name' => $room_type['name'][0],
                    'price' => $price,
                    'currency_price' => $package[$room_type['packageCurrencyPriceName']],
                    'currency_name' => $package_currency_name,
                    'coefficient' => $room_type['coefficient'],
                    'index' => $room_type['index'],
                    'order' => $room_type['order'],
                    'type' => $room_type['type'],
                    'final_price' => $final_price,
                    'capacity' => $package[$room_type['capacityValue']],
                ];



            }
            functions::insertLog('******************tour number 5*******************', 'slow_package');

            $custom_rooms = json_decode($packages[$package_key]['custom_room'], 256);


            if (isset($custom_rooms) && !empty($custom_rooms)) {

                if (SOFTWARE_LANG == 'fa') {
                    $package_currency_name = $package['currency_type'];
                } else {

                    if ($package['currency_type']) {
                        $package_currency_name = functions::changeCurrencyName($package['currency_type']);
                    } else {
                        $package_currency_name = '';
                    }
                }
                foreach ($custom_rooms as $room_key => $custom_room) {

                    $room_type = array_keys($custom_room)[0];

                    switch ($room_type) {
                        case 'fourRoom':
                            $number_bed = 4;
                            $index = 'fourBed';
                            $order = 4;
                            break;
                        case 'fiveRoom':
                            $number_bed = 5;
                            $index = 'fiveBed';
                            $order = 5;
                            break;
                        case 'sixRoom':
                            $number_bed = 6;
                            $index = 'sixBed';
                            $order = 6;
                            break;
                    }
                    $reservationTourController = $this->getController('resultTourLocal');

                    $do_discount = ($reservationTourController->calculateDiscount($tour_id, ['minPriceR' => $custom_room[$room_type]['price_r']], $package['id'], $room_type));
                    if (empty($do_discount['discountedMinPriceR'])) {
                        $price_change = $this->doPriceChange($package[$room_type['packagePriceName']], $package['change_price']);
                         if(functions::isEnableSetting('toman')) {
                             $final_price = round($price_change/10) ;
                         }else{
                             $final_price = $price_change ;
                         }


                    } else {
                        $price_change = $this->doPriceChange($do_discount['discountedMinPriceR'], $package['change_price']);
                        if(functions::isEnableSetting('toman')) {
                            $final_price = round($price_change/10) ;
                        }else{
                            $final_price = $price_change ;
                        }
                    }

                    if ($custom_room[$room_type]['price_a'] == "") {
                        $package_currency_name = '';
                    }

                    $show_price =intval($this->doPriceChange($custom_room[$room_type]['price_r'], $package['change_price']));

                      if(functions::isEnableSetting('toman')) {
                          $price = round($show_price/10);
                      }else{
                          $price = $show_price;
                      }
                    $packages[$package_key]['rooms'][] = [

                        'name' => functions::Xmlinformation($room_type)->__toString(),
                        'price' => $price,
                        'currency_price' => $custom_room[$room_type]['price_a'],
                        'currency_name' => $package_currency_name,
                        'order' => $order,
                        'coefficient' => $number_bed,
                        'index' => $index,
                        'type' => 'adult',
                        'final_price' => $final_price,
                        'capacity' => $custom_room[$room_type]['capacity']
                    ];
                }

              
                usort($packages[$package_key]['rooms'], function($a, $b)
                {
                    if ($a["order"] == $b["order"])
                        return (0);
                    return (($a["order"] < $b["order"]) ? -1 : 1);
                });
            }



            $start_date = explode('/', functions::dateFormatSpecialJalali($start_date, 'd/F/Y'));
            $start_date = ($start_date[0] > 9 ? $start_date[0] : str_replace('0', '', $start_date[0])) . '/' . $start_date[1] . '/' . $start_date[2];

            $end_date = explode('/', functions::dateFormatSpecialJalali($end_date, 'd/F/Y'));
            $end_date = ($end_date[0] > 9 ? $end_date[0] : str_replace('0', '', $end_date[0])) . '/' . $end_date[1] . '/' . $end_date[2];

            $packages[$package_key]['start_date_human_string'] = $start_date;
            $packages[$package_key]['start_date_week'] = functions::dateFormatSpecialJalali($start_date, 'l');
            $packages[$package_key]['end_date_human_string'] = $end_date;
            $packages[$package_key]['end_date_week'] = functions::dateFormatSpecialJalali($end_date, 'l');

            functions::insertLog('******************tour number 6*******************', 'slow_package');

        }
//        array_values($packages);


        $sort_package = [];
        $array_have_value_package = [];
        $array_have_no_value_package = [];

        foreach ($packages as $key => $package) {

            if ($package['rooms'][1]['price'] > 0) {
                $sort_package['rooms'][1]['price'][$key] = $package['rooms'][1]['price'];
                $array_have_value_package[] = $package;
            } else {
                $array_have_no_value_package [] = $package;
            }
        }

        array_multisort($sort_package['rooms'][1]['price'], SORT_ASC, $array_have_value_package);

        if ($array_have_no_value_package) {
            $array_have_value_package = array_merge($array_have_value_package, $array_have_no_value_package);
        }
        functions::insertLog('******************tour number 7*******************', 'slow_package');

        return $array_have_value_package;
    }

    public function doPriceChange($price, $price_change) {
        if ($price > 0) {
            return $price + $price_change;
        }
        return $price;
    }

    public function getHotelInformation($idHotel,$api=false) {

//        check hotel id is not empty

        if($api){
            return $this->getInformationHotelApi($idHotel);
        }
        $hotel_table = $this->reservation_hotel_model->getTable();
        $city_table = $this->reservation_city_model->getTable();
        $hotel = $this->reservation_hotel_model->get([
            $hotel_table . '.id',
            $hotel_table . '.name',
            $hotel_table . '.name_en',
            $hotel_table . '.trip_advisor',
            $hotel_table . '.star_code',
            $hotel_table . '.logo',
            $hotel_table . '.region',
            $hotel_table . '.type_code',
            $city_table . '.name as city_name',
            $city_table . '.name_en as city_name_en'
        ], true)
            ->join($city_table, 'id', 'city', 'inner')
            ->where($hotel_table . '.id', $idHotel)
            ->find();


        $hotel['logo'] = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . $hotel['logo'];


        $hotel['facilities'] = $this->getHotelFacilitiesById($hotel['id']);
        $hotel['gallery'] = $this->getHotelGalleryById($hotel['id']);
        if (empty($hotel['gallery']) && $hotel['logo']) {
            $hotel['gallery'] = [
                [
                    'pic_address' => $hotel['logo']
                ],
            ];
        }


        return $hotel;


    }

    public function getHotelFacilitiesById($hotel_id) {
        $hotel_facilities = $this->reservation_hotel_facilities_model->get()
            ->where('id_hotel', $hotel_id)
            ->all();


        $facilities_id = [];
        foreach ($hotel_facilities as $facility) {
            $facilities_id[] = $facility['id_facilities'];
        }


        return $this->reservation_facilities_model->get([
            'id', 'title', 'icon_class'
        ])
            ->where('is_del', 'no')
            ->whereIn('id', $facilities_id)
            ->all();
    }

    public function getHotelGalleryById($hotel_id) {
        $gallery = $this->reservation_hotel_gallery_model->get()
            ->where('id_hotel', $hotel_id)
            ->where('is_del', 'no')
            ->all();
        $result = [];
        foreach ($gallery as $key => $item) {
            $result[$key] = $item;
            $result[$key]['pic_address'] = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . $item['pic'];
        }
        return $result;
    }

    public function getTourRouteData($tour_id) {
        $reservationPublicFunctions = $this->getController('reservationPublicFunctions');

        $tour_route_table = $this->reservation_tour_route_model->getTable();
        $tour_table = $this->reservation_tour_model->getTable();
        $city_table = $this->reservation_city_model->getTable();
        $country_table = $this->reservation_country_model->getTable();

        $origin_route = $this->reservation_tour_model
            ->get([

                $city_table . '.name as city_id',
                $city_table . '.name as city_name',
                $city_table . '.name_en as city_name_en',
                $city_table . '.abbreviation as abbreviationOrg',
                $country_table . '.id as country_id',
                $country_table . '.name as country_name',
                $country_table . '.name_en as country_name_en',
            ], true)
            ->join($city_table, 'id', 'origin_city_id', 'inner')
            ->join($country_table, 'id', 'origin_country_id', 'inner')
            ->where($tour_table . '.id', $tour_id)
            ->find();

        $destination_route = $this->reservation_tour_route_model->get()
            ->get([
                $tour_route_table . '.*',
                $city_table . '.name as city_id',
                $city_table . '.name as city_name',
                $city_table . '.name_en as city_name_en',
                $city_table . '.abbreviation as abbreviationDEs',
                $country_table . '.id as country_id',
                $country_table . '.name as country_name',
                $country_table . '.name_en as country_name_en',
            ], true)
            ->join($city_table, 'id', 'destination_city_id', 'inner')
            ->join($country_table, 'id', 'destination_country_id', 'inner')
            ->where($tour_route_table . '.fk_tour_id', $tour_id)->orderBy($tour_route_table .'.id' , 'asc')->all();

        $destinations = [];

        $airlineModel = $this->getModel('airlineModel');
        $reservationTransportCompaniesModel = $this->getModel('reservationTransportCompaniesModel');
        $reservationTransportCompaniesTable = $reservationTransportCompaniesModel->getTable();

        $reservationTypeOfVehicleModel = $this->getModel('reservationTypeOfVehicleModel');
        $reservationTypeOfVehicleTable = $reservationTypeOfVehicleModel->getTable();

        foreach ($destination_route as $route_key => $route) {
            $destinations[$route_key] = $route;
            if ($route['type_vehicle_name'] == 'هواپیما') {

                $airline_name = $airlineModel
                    ->get([
                        'id',
                        'name_fa as name',
                        'name_en',
                        'photo as logo',
                    ])
                    ->where('name_fa', $route['airline_name'])
                    ->find();
                $airline_name['icon'] = 'custom-plane-bg-svg';
                $airline_name['src'] = ROOT_ADDRESS_WITHOUT_LANG . "/pic/airline/" . $airline_name['logo'];
            } else {
                $airline_name = $reservationTransportCompaniesModel
                    ->get([
                        $reservationTransportCompaniesTable . '.id',
                        $reservationTransportCompaniesTable . '.name',
                        $reservationTransportCompaniesTable . '.name_en',
                        $reservationTransportCompaniesTable . '.pic as logo',
                        $reservationTransportCompaniesTable . '.pic as logo',
                        $reservationTypeOfVehicleTable . '.name as vehicle_name',
                        $reservationTypeOfVehicleTable . '.type as vehicle_type',

                    ], true)
                    ->join($reservationTypeOfVehicleTable, 'id', 'fk_id_type_of_vehicle', 'INNER')
                    ->where($reservationTransportCompaniesTable . '.id', $route['airline_id'])
                    ->find();
                $airline_name['vehicle_name_en'] = functions::vehicleEnName($airline_name['vehicle_name']);
                $airline_name['vehicle_type_en'] = $airline_name['vehicle_type'];
                if ($airline_name['vehicle_type_en']){
                    $airline_name['icon'] = 'custom-' . $airline_name['vehicle_type_en'] . '-bg-svg';
                } else {
                    $airline_name['icon'] = 'custom-' . $airline_name['vehicle_name_en'] . '-bg-svg';
                }

                if($airline_name['logo']) {
                    $airline_name['src'] = ROOT_ADDRESS_WITHOUT_LANG . "/pic/" . $airline_name['logo'];
                }else{
                    $airline_name['src'] = $this->noPhotoUrl;
                }


            }
            $destinations[$route_key]['vehicle'] = $airline_name;
        }


        return [
            'origin' => $origin_route,
            'destinations' => $destinations,
        ];
    }

    public function getTourById($param) {

        if($param['is_api']){
            $param['one_day'] = true ;
            return $this->getPackagesApi($param);
        }
        $result_get_tour = $this->reservation_tour_model->get()->where('id', $param['tour_id'])->find();
        

        $final_array = [];
        $room_types = [
            "OneBed" => [
                'name' => (array)functions::Xmlinformation('Adt'),
                'packagePriceName' => 'adult_price_one_day_tour_r',
                'packageCurrencyPriceName' => 'adult_price_one_day_tour_a',
                'coefficient' => 1,
                'type' => 'adult'],
            "TwoBed" => [
                'name' => (array)functions::Xmlinformation('Chd'),
                'packagePriceName' => 'child_price_one_day_tour_r',
                'packageCurrencyPriceName' => 'child_price_one_day_tour_a',
                'coefficient' => 1,
                'type' => 'child'],
            "ThreeBed" => [
                'name' => (array)functions::Xmlinformation('Inf'),
                'packagePriceName' => 'infant_price_one_day_tour_r',
                'packageCurrencyPriceName' => 'infant_price_one_day_tour_a',
                'coefficient' => 1,
                'type' => 'infant'
            ]
        ];


        $resultTourLocalController = $this->getController('resultTourLocal');
        $final_array[0]['hotels'] = [];

        foreach ($room_types as $room_key => $room_type) {

            $do_discount = ($resultTourLocalController->doDiscount($result_get_tour['id_same'], ['minPriceR' => $result_get_tour[$room_type['packagePriceName']]]));

//            if (empty($do_discount['discountedMinPriceR'])) {
//                $final_price = $result_get_tour[$room_type['packagePriceName']] + $result_get_tour['change_price'];
//            } else {
//                $final_price = $do_discount['discountedMinPriceR'] + $result_get_tour['change_price'];
//            }

//var_dump($do_discount['discountedMinPriceR']);
//die;


            if (empty($do_discount['discountedMinPriceR'])) {

                if(functions::isEnableSetting('toman')) {
                    $final_price_change = $result_get_tour[$room_type['packagePriceName']] + $result_get_tour['change_price'];
                    $final_price = round($final_price_change / 10) ;
                }else{
                    $final_price = $result_get_tour[$room_type['packagePriceName']] + $result_get_tour['change_price'];
                }
            } else {
                if(functions::isEnableSetting('toman')) {
                    $final_price_discount = $do_discount['discountedMinPriceR'] + $result_get_tour['change_price'];
                    $final_price = round($final_price_discount / 10) ;
                }else{
                    $final_price = $do_discount['discountedMinPriceR'] + $result_get_tour['change_price'];
                }
            }




            if ($result_get_tour[$room_type['packageCurrencyPriceName']] == 0) {
                $final_array[0][$room_type['packageCurrencyPriceName']] = '';
            } else {
                $final_array[0][$room_type['packageCurrencyPriceName']] = '+' . intval($result_get_tour[$room_type['packageCurrencyPriceName']]);

            }



            if(functions::isEnableSetting('toman')) {
                $price_room_1 = $result_get_tour[$room_type['packagePriceName']] + $result_get_tour['change_price'];
                $price_room = $price_room_1 / 10;
            }else{
                $price_room = $result_get_tour[$room_type['packagePriceName']] + $result_get_tour['change_price'];
            }


//if(  $_SERVER['REMOTE_ADDR']=='93.118.161.174'  ) {
//    var_dump($price_room);
//    gettype($price_room);
//    die;
//
//}


            $final_array[0]['rooms'][] = [
                'name' => $room_type['name'][0],
                'price' => intval($price_room),
                'currency_price' => $final_array[0][$room_type['packageCurrencyPriceName']],
                'currency_name' => $result_get_tour['currency_type_one_day_tour'],
                'coefficient' => $room_type['coefficient'],
                'index' => $room_type['index'],
                'type' => $room_type['type'],
                'final_price' => $final_price,
                'capacity' => 20,
            ];


            $final_array[0]['start_date_human_string'] = functions::dateFormatSpecialJalali($param['start_date'], 'd/F/Y');
            $final_array[0]['start_date_week'] = functions::dateFormatSpecialJalali($param['start_date'], 'l');
            $final_array[0]['end_date_human_string'] = functions::dateFormatSpecialJalali($param['end_date'], 'd/F/Y');
            $final_array[0]['end_date_week'] = functions::dateFormatSpecialJalali($param['end_date'], 'l');
        }

        return json_encode($final_array, JSON_NUMERIC_CHECK);


    }


    public function getTourReservationData($params) {
        $multiple_tour = 2 ;
        $one_day_tour = 1 ;
        /** @var resultTourLocal $result_tour_local_controller */
        $result_tour_local_controller = $this->getController('resultTourLocal');
        $reservation_tour_table = $this->reservation_tour_model->getTable();
        $reservation_tour_package_table = $this->reservation_tour_package_model->getTable();
        $reservation_tour_route_table = $this->reservation_tour_route_model->getTable();
        $reservation_city_table = $this->reservation_city_model->getTable();
        $reservation_tour_type_table = $this->reservation_tour_type_model->getTable();
        $reservation_master_rate_table = $this->master_rate_model->getTable();
        $airlineModel = $this->getModel('airlineModel');
        $reservationTransportCompaniesModel = $this->getModel('reservationTransportCompaniesModel');
        $reservationTransportCompaniesTable = $reservationTransportCompaniesModel->getTable();
        $reservationTypeOfVehicleModel = $this->getModel('reservationTypeOfVehicleModel');
        $reservationTypeOfVehicleTable = $reservationTypeOfVehicleModel->getTable();
        foreach ($params as $key => $param) {
            $request[$key] = functions::checkParamsInput($param);
        }
        $type = $request['type'];
        $country = $request['country'];
        $date = $request['dateNow'];
        $limit = $request['limit'];

        $reservationTourList = $this->reservation_tour_model
            ->get([
                $reservation_tour_table . '.id',
                $reservation_tour_table . '.id_same',
                $reservation_tour_table . '.tour_name_en',
                $reservation_tour_table . '.tour_name',
                $reservation_tour_table . '.tour_video',
                $reservation_tour_table . '.description',
                $reservation_tour_table . '.night',
                $reservation_tour_table . '.start_date',
                $reservation_tour_table . '.tour_pic',
                $reservation_tour_table . '.tour_type_id',
                $reservation_tour_table . '.is_special',
                $reservation_tour_table . '.change_price',
                $reservation_tour_table . '.tour_file',
                $reservation_tour_table . '.adult_price_one_day_tour_r',
                $reservation_tour_table . '.adult_price_one_day_tour_a',
                $reservation_tour_table . '.currency_type_one_day_tour',
                $reservation_tour_route_table . '.airline_id',
                $reservation_tour_route_table . '.airline_name',
                $reservation_tour_route_table . '.destination_city_name',
                $reservation_tour_route_table . '.type_vehicle_name',
                $reservation_tour_route_table . '.type_vehicle_id'
//                '(SELECT  count( * )
//                                  FROM master_rate_tb as Rate
//                               WHERE Rate.section = "reservation_tour_tb" AND item_id='.$reservation_tour_table.'.id_same ) as rate_count',
//                '(SELECT sum( Rate.VALUE )  / count( * )
//                                  FROM master_rate_tb as Rate
//                               WHERE Rate.section = "reservation_tour_tb" AND item_id='.$reservation_tour_table.'.id_same ) as rate_average'
            ], true)
            ->join($reservation_tour_route_table, 'fk_tour_id', 'id', 'INNER')
            ->join($reservation_tour_route_table, 'id', 'destination_city_id', 'INNER', $reservation_city_table)
            ->join($reservation_tour_package_table, 'fk_tour_id', 'id', 'LEFT');


        // فیلترها
        // ===========================
        if (!empty($type) && is_numeric($type)) {
            $reservationTourList = $reservationTourList->join($reservation_tour_type_table, 'fk_tour_id_same', 'tourType');
            $reservationTourList = $reservationTourList->where($reservation_tour_type_table . '.fk_tour_type_id', $type);
        } elseif (!empty($type) && $type == 'discount') {
            $reservationTourList = $reservationTourList->where($reservation_tour_table . '.discount', '0', '>');
        } elseif (!empty($type) && $type == 'special') {
            $reservationTourList = $reservationTourList->where($reservation_tour_table . '.is_special', 'yes', '=');
        }


        if (!empty($country)) {
            if ($country == 'internal') {
                $reservationTourList = $reservationTourList->where($reservation_tour_route_table . '.destination_country_id', '1', '=');
            } elseif ($country == 'external') {
                $reservationTourList = $reservationTourList->where($reservation_tour_route_table . '.destination_country_id', '1', '!=');
            } else {
                $reservationTourList = $reservationTourList->where($reservation_tour_route_table . '.destination_country_id', $country, '=');
            }
            $reservationTourList = $reservationTourList->where($reservation_tour_route_table . '.tour_title', 'dept', '=');
        }
        if (!empty($request['city'])) {

            $reservationTourList = $reservationTourList->where($reservation_tour_route_table . '.destination_city_id', $request['city'], '=');
        }

        $one_day_tour = '"1"';
        $multiple_tour = '"2"';
        $reservationTourList = $reservationTourList
            ->where($reservation_tour_table . '.is_del', 'no', '=')
            ->openParentheses()
            ->openParentheses('')
            ->like('tour_type_id',"%{$multiple_tour}%")
            ->where($reservation_tour_package_table . '.is_del' , 'no')
            ->closeParentheses()
            ->like('tour_type_id',"%{$one_day_tour}%")
            ->closeParentheses()
            ->where($reservation_tour_table . '.is_show', 'yes', '=')
            ->where($reservation_tour_table . '.start_date', $date, '>')
            ->openParentheses()
            ->where($reservation_tour_route_table . '.is_route_fake', '1', '=')
            ->orWhereNull($reservation_tour_route_table . '.is_route_fake')
            ->closeParentheses();



        if (isset($request['category']) && !empty($request['category'])) {
            $category = '"' . $request['category'] . '"';
            $reservationTourList = $reservationTourList->where($reservation_tour_table . '.tour_type_id', "%$category%", 'like');
        }
        if(SOFTWARE_LANG == 'fa') {
            $reservationTourList = $reservationTourList->where($reservation_tour_table . '.language', 'en', '!=');

        }
        $reservationTourList = $reservationTourList->groupBy($reservation_tour_table . '.id_same')
            ->orderBy($reservation_tour_table . '.priority=0')->orderBy($reservation_tour_table . '.id' ,'DESC')->limit(0, $limit);
//        $reservationTourList = $reservationTourList->toSqlDie();

//        if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//            $reservationTourList = $reservationTourList->toSqlDie();
//            var_dump($request['category']);
//            die();


//        }
        $reservationTourList = $reservationTourList->all();


        $result = [];


        $airlines = $airlineModel
            ->get(['id','name_fa as name','name_en','photo as logo'])
            ->all();
        $airlinesMap = [];
        foreach ($airlines as $airline) {
            $airlinesMap[$airline['name']] = $airline;
        }

        $transportCompanies = $reservationTransportCompaniesModel
            ->get([
                $reservationTransportCompaniesTable . '.id',
                $reservationTransportCompaniesTable . '.name',
                $reservationTransportCompaniesTable . '.name_en',
                $reservationTransportCompaniesTable . '.pic as logo',
                $reservationTypeOfVehicleTable . '.name as vehicle_name',
                $reservationTypeOfVehicleTable . '.type as vehicle_type',
            ], true)
            ->join($reservationTypeOfVehicleTable, 'id', 'fk_id_type_of_vehicle', 'INNER')
            ->all();

        $transportCompaniesMap = [];
        foreach ($transportCompanies as $tc) {
            $transportCompaniesMap[$tc['id']] = $tc;
        }
//        if(  $_SERVER['REMOTE_ADDR']=='93.118.161.174'  ) {
//        }
        $tourIds = array_column($reservationTourList, 'id');
//        $minPrices = $result_tour_local_controller->minPriceHotelByIdsTourR(["31503","31457","31416","31409"], 'no');


        $airlines = $airlineModel
            ->get(['id','name_fa as name','name_en','photo as logo'])
            ->all();
        $airlinesMap = [];
        foreach ($airlines as $airline) {
            $airlinesMap[$airline['name']] = $airline;
        }

        $transportCompanies = $reservationTransportCompaniesModel
            ->get([
                $reservationTransportCompaniesTable . '.id',
                $reservationTransportCompaniesTable . '.name',
                $reservationTransportCompaniesTable . '.name_en',
                $reservationTransportCompaniesTable . '.pic as logo',
                $reservationTypeOfVehicleTable . '.name as vehicle_name',
                $reservationTypeOfVehicleTable . '.type as vehicle_type',
            ], true)
            ->join($reservationTypeOfVehicleTable, 'id', 'fk_id_type_of_vehicle', 'INNER')
            ->all();

        $transportCompaniesMap = [];
        foreach ($transportCompanies as $tc) {
            $transportCompaniesMap[$tc['id']] = $tc;
        }

     

        foreach ($reservationTourList as $key => $item) {
            if ($item['type_vehicle_name'] == 'هواپیما') {
                functions::insertLog(json_encode($item['airline_name']),'00000arash00000');

                $airline_name = $airlineModel
                    ->get([
                        'id',
                        'name_fa as name',
                        'name_en',
                        'photo as logo',
                    ])
                    ->where('id', $item['airline_id'])
                    ->find();
                functions::insertLog(json_encode($airline_name['airline_name']),'00000arash00001');
                $item['icon_transport'] = 'custom-plane-bg-svg';
                $item['logo_transport'] = ROOT_ADDRESS_WITHOUT_LANG . "/pic/airline/" . $airline_name['logo'];
            }else{
                $airline_name = $reservationTransportCompaniesModel
                    ->get([
                        $reservationTransportCompaniesTable . '.id',
                        $reservationTransportCompaniesTable . '.name',
                        $reservationTransportCompaniesTable . '.name_en',
                        $reservationTransportCompaniesTable . '.pic as logo',
                        $reservationTypeOfVehicleTable . '.name as vehicle_name',
                        $reservationTypeOfVehicleTable . '.type as vehicle_type',

                    ], true)
                    ->join($reservationTypeOfVehicleTable, 'id', 'fk_id_type_of_vehicle', 'INNER')
                    ->where($reservationTransportCompaniesTable . '.id', $item['airline_id'])
                    ->find();
                $item['vehicle_name_en'] = functions::vehicleEnName($airline_name['vehicle_name']);
                $item['vehicle_type_en'] = $airline_name['vehicle_type'];
                if ($airline_name['vehicle_type_en']){
                    $item['icon_transport'] = 'custom-' . $item['vehicle_type_en'] . '-bg-svg';
                } else {
                    $item['icon_transport'] = 'custom-' . $item['vehicle_name_en'] . '-bg-svg';
                }
                $item['logo_transport'] = ROOT_ADDRESS_WITHOUT_LANG . "/pic/" . $airline_name['logo'];
            }




            $one_day_tour = 'no';

            if (strpos($item['tour_type_id'], '"1"') !== false) {
                $one_day_tour = 'yes';
            }
            $min_price = $result_tour_local_controller->minPriceHotelByIdTourR($item['id'], $one_day_tour);
            $result[$key] = $item;
            $result[$key]['tour_slug'] = str_replace(' ', '-', $item['tour_name_en']);
            $result[$key]['min_price'] = $min_price;
            $result[$key]['min_price_r'] = $min_price['minPriceR'];
            $result[$key]['min_price_a'] = $min_price['minPriceA'];
            $result[$key]['currency_type'] = $min_price['CurrencyTitleFa'];
            if(isset($request['rate']) && $request['rate'] == 'yes') {
                $reservationRateList = $this->master_rate_model
                    ->get([
                        'id' ,
                        'count(*) as rate_count',
                        'sum(VALUE)/count(*) as rate_average'
                    ])->where('section' , 'reservation_tour_tb' , '=')
                    ->where('item_id' , $item['id_same'])->find();
                $result[$key]['rate_count'] = $reservationRateList['rate_count'];
                $result[$key]['rate_average'] = $reservationRateList['rate_average'];
            }
        }

        return $result;
    }

    public function reservationTourCount(){

        $Model = Load::library('Model');
        $sql = " SELECT COUNT(*) as total_tours_count
                FROM (
                    SELECT id_same, COUNT(*) as tour_count
                    FROM reservation_tour_tb
                    WHERE is_show = 'yes'
                    GROUP BY id_same
                ) AS subquery
                 ";
        $resultCountTour = $Model->select($sql);
        return $resultCountTour;
    }

    /**
     * @param $params
     * @author alizade
     * @date 5/7/2024
     * @time 2:28 PM
     */
    private function getPackagesApi($params) {

        if ($this->api) {
            $data_request_search = [
                "tour_id" => $params['tour_id'],
                "start_date" => $params['start_date'],
                "end_date" => $params['end_date'],
                "one_day" => $params['one_day']
            ];

            $result = $this->api->packages($data_request_search);
            return json_encode($result,256|64);
        }

        return false ;
    }
    private function getInfoHotelPackagesApi($package_id) {
        if ($this->api) {
            return $this->api->getDataHotelTourPackage($package_id);
        }
        return false ;
    }


    private function getInformationHotelApi($hotel_id) {
        if ($this->api) {
            return $this->api->getDataInformationHotel($hotel_id);
        }
        return false ;
    }

    private function infoTourRoutByIdPackageApi($package_id,$city_id) {
        if ($this->api) {
            $data=[
                'package_id'=>$package_id,
                'city_id'=>$city_id
            ];

            return $this->api->tourRoutesApi($data);
        }
        return false ;
    }


    public function detailOnDayTour($params) {

        $data=[
            'tour_code'=> $params['tourCode'],
            'start_date' => explode('|',$params['selectDate'])[0],
            'type_tour'=>$params['typeTourReserve']
        ];
        return $this->api->infoTourByDateApi($data);
    }
    public function getCitiesWithTour($params) {
        $result = [];
        $dateNow = dateTimeSetting::jdate("Ymd", "", "", "", "en");
        if($params['type'] == 'internal') {
            $cities = $this->getController('reservationBasicInformation')->ReservationTourCities('=1', 'return');
            $city_param = ['type'=>'','limit'=> $params['limit'] ,'dateNow' => $dateNow, 'country' =>'internal'];
            foreach ($cities as $key => $city) {
                $city_param['city'] = $city['id'];
                $result[$key]['city'] = $city ;
                $result[$key]['tour_list'] = $this->getTourReservationData($city_param) ;

            }
            return $result;
        }else{

            $countries = $this->getController('reservationBasicInformation')->ReservationTourCountries('yes');

            $country_params = ['type'=>'','limit'=> $params['limit'] ,'dateNow' => $dateNow, 'country' =>'external'];
            foreach ($countries as $key => $country) {

                $country_params['country'] = $country['id'];
                $result[$key]['country'] = $country;
                $result[$key]['tour_list'] = $this->getTourReservationData($country_params) ;
            }

            return $result;
        }

    }
    
    public function getPackageHotelInfo($package_id_list) {

        $tour_hotel_table = $this->reservation_tour_hotel_model->getTable();
        $city_table = $this->reservation_city_model->getTable();
        $hotel_table = $this->reservation_hotel_model->getTable();

        $hotel_list =  $this->reservation_tour_hotel_model->get([
            $tour_hotel_table . '.*',
            $hotel_table . '.id',
            $hotel_table . '.name',
            $hotel_table . '.name_en',
            $hotel_table . '.trip_advisor',
            $hotel_table . '.star_code',
            $hotel_table . '.logo',
            $hotel_table . '.region',
            $hotel_table . '.type_code',
            $city_table . '.name',
            $city_table . '.name_en as city_name_en'
        ], true)
            ->join($city_table, 'id', 'fk_city_id', 'inner')
            ->join($hotel_table, 'id', 'fk_hotel_id', 'inner')
            ->whereIn($tour_hotel_table . '.fk_tour_package_id', $package_id_list)
            ->where($tour_hotel_table . '.is_del', 'no')
            ->all();



        $result_hotel = [];
        foreach($package_id_list as $package ) {
            $counter = 0 ;
            foreach($hotel_list as $hotel ) {
                if($package == $hotel['fk_tour_package_id']) {

                    $info = $hotel ;
                    $info['name'] = $hotel['hotel_name'];
                    $info['logo'] = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . $hotel['logo'];


                    $info['facilities'] = $this->getHotelFacilitiesById($hotel['id']);
                    $info['gallery'] = $this->getHotelGalleryById($hotel['id']);



                    if (empty($info['gallery']) && $info['logo']) {
                        $info['gallery'] = [
                            [
                                'pic_address' => $info['logo']
                            ],
                        ];
                    }
                  
                    $tour_route_information = $this->infoTourRoutByIdPackage($hotel['fk_tour_package_id'], $hotel['fk_city_id']);

                    $result_hotel[$hotel['fk_tour_package_id']]['hotels'][$counter] = $info;
                    $result_hotel[$hotel['fk_tour_package_id']]['hotels'][$counter]['night'] = $tour_route_information[0]['night'];
                    $result_hotel[$hotel['fk_tour_package_id']]['hotels'][$counter]['room_service'] = $tour_route_information[0]['room_service'];
                    $counter ++ ;
                }
            }
        }

        return $result_hotel ;
    }
    
    public function calculateAllPackageDiscount($package_id_list , $tour_id , $packages , $room_types){


        if(!$this->counter_types){

            $counter_type_controller=$this->getController('counterType');
            $counter_type_controller->getAll('all');

            $this->counter_types=$counter_type_controller->list;
        }


        if($_SESSION["Login"] && $_SESSION['Login'] == 'success'){

            $counter_type_id = $_SESSION["counterTypeId"];

        }else{
            $counter_type_id='5';
        }


        $discount_list = $this->getModel('reservationTourDiscountModel')
            ->get(['*'])
            ->whereIn('tour_package_id', $package_id_list)
            ->where('tour_id', $tour_id)
            ->where('counter_type_id', $counter_type_id)
            ->all();

        $result = [] ;
        foreach($packages as $package ) {

            foreach ($discount_list  as $discount) {

                if($package['id'] == $discount['tour_package_id']) {
                    foreach ($room_types  as $type) {


                        $field_name ='adult_amount';
                        switch ($type['type']){
                            case 'adult':
                                $field_name ='adult_amount';
                                break;
                            case 'child':
                                $field_name ='child_amount';
                                break;
                            case 'infant':
                                $field_name ='infant_amount';
                                break;
                        }

                        $price = $package[$type['packagePriceName']];

                        $discount_result = $discount[$field_name];
                        if($price > $discount_result){
                            $price = $price - $discount_result;
                        }
                        $result[$package['id']][$type['index']]['discountedMinPriceR'] = $price;
                    }
                }

            }
        }

        return $result;
    }

    public function infoTourType($id) {
        $Model = Load::library('Model');
        $sql = " SELECT * from reservation_tour_type_tb where id = '{$id}' AND is_del = 'no'  ";
        return $Model->load($sql);
    }

    public function getInfoSearchedData($idSameTour) {
       $tour      = $this->infoTourByIdSameDetail( $idSameTour );
       $tour_type = $tour['tour_type_id'];
       $tour_type = str_replace('"' , '' , $tour_type) ;
       $tour_type = str_replace('[' , '' , $tour_type) ;
       $tour_type = str_replace(']' , '' , $tour_type) ;
       $tour_type = explode(',' , $tour_type);
       foreach($tour_type as $type){
           if($type != '1' && $type != '2'){
               $tour_type = $type;
               break;
           }
       }
       $tour_type      = $this->infoTourType( $tour_type );

       $tour_id = $tour['id'];
       $tour_route = $this->infoNotFakeTourRoutByIdTour( $tour_id  , 'dept');

       if(SOFTWARE_LANG == 'fa') {
           if($tour_type && $tour_type['tour_type']) {
               $result['type']['heading'] = $tour_type['tour_type'] ;
//               $result['type']['heading'] = functions::Xmlinformation('Tours') . ' ' .$tour_type['tour_type'] ;
           }

           if($tour_route['destination_country_id'] != 1) {
               $result['country']['heading'] = functions::Xmlinformation('Tours') . ' ' .$tour_route['country_name'] ;
           }
           $result['city']['heading'] = functions::Xmlinformation('Tours') . ' ' .$tour_route['name'] ;
       }else{
           if($tour_type && $tour_type['tour_type_en']) {
               $result['type']['heading'] = functions::Xmlinformation('Tours') . ' ' .$tour_type['tour_type_en'] ;
           }


           if($tour_route['destination_country_id'] != 1) {
               $result['country']['heading'] = functions::Xmlinformation('Tours') . ' ' .$tour_route['country_name_en'] ;
           }
           $result['city']['heading'] = functions::Xmlinformation('Tours') . ' ' .$tour_route['name_en'] ;
       }
       if($tour_type) {
           $result['type']['link'] = ROOT_ADDRESS . '/resultTourLocal/all-all/' . 'all-all/all/' . $tour_type['id'] ;
       }
        if($tour_route['destination_country_id'] != 1) {
            $result['country']['link'] = ROOT_ADDRESS . '/resultTourLocal/all-all/'.$tour_route['destination_country_id'] .'-all'  . '/all/all';
        }
        $result['city']['link'] =  ROOT_ADDRESS . '/resultTourLocal/all-all/'.$tour_route['destination_country_id'] .'-' . $tour_route['destination_city_id'] . '/all/all';

        return $result ;
    }

    public function infoNotFakeTourRoutByIdTour($id, $type) {
        $Model = Load::library('Model');
        $sql = " SELECT TR.*,RC.name,RC.name_en,RCOUNTRY.name as country_name,RCOUNTRY.name_en as country_name_en FROM reservation_tour_rout_tb TR
                INNER JOIN reservation_city_tb RC ON TR.destination_city_id=RC.id
                INNER JOIN reservation_country_tb RCOUNTRY ON TR.destination_country_id=RCOUNTRY.id
                WHERE TR.fk_tour_id = '{$id}' AND TR.is_route_fake = '1' AND TR.is_del = 'no'  ";


        if ($type == 'dept') {
            $sql .= " AND TR.tour_title='dept' ";
        } elseif ($type == 'return') {
            $sql .= " AND TR.tour_title='return' ";
        }
        $sql .= " ORDER BY TR.tour_title ";
       
        $tour = $Model->load($sql);
        return $tour;
    }




    public function getFilePackageByIdTour_old($params) {

        $query = $this->reservation_tour_model->get()
            ->where('id', $params['tour_id'])
            ->all();

            $item = $query[0];
//            $item['tour_file_package'] = ROOT_ADDRESS_WITHOUT_LANG . '/pic/reservationTour/' . $item['tour_file'];
            $item['tour_file_package'] =  $item['tour_file'];
            return [$item]; // چون جاوااسکریپت منتظر آرایه‌ست



    }

    public function getFilePackageByIdTour($params) {
        $query = $this->reservation_tour_model->get()
            ->where('id', $params['tour_id'])
            ->all();

        if (!empty($query[0])) {
            $item = $query[0];

            if (!empty($item['tour_file'])) {
                $item['tour_file_package'] = ROOT_ADDRESS_WITHOUT_LANG . '/pic/reservationTour/' . $item['tour_file'];
            } else {
                $item['tour_file_package'] = null; // یا این خطو می‌تونی حذف کنی
            }

            return json_encode([$item]);
        } else {
            return json_encode([]); // مهم! json_encode کن
        }
    }












    public function changeTourPackagePrices_ld($param) {


        $Model = Load::library('Model');
        $sqlTourPackage = "SELECT * FROM reservation_tour_package_tb WHERE fk_tour_id = '{$param['itemId']}'";
        $resultTourPackage = $Model->select($sqlTourPackage);

        if (empty($resultTourPackage)) {
            return 'error:' . functions::Xmlinformation('NoRecordsFound');
        }

        // بررسی اینکه حداقل یک فیلد برای تغییر پر شده است
        $hasChanges = false;
        $fieldsToCheck = [
            'threeRoomPriceR', 'doubleRoomPriceR', 'singleRoomPriceR',
            'childWithBedPriceR', 'infantWithoutBedPriceR', 'infantWithoutChairPriceR'
        ];

        foreach ($fieldsToCheck as $field) {
            if (!empty($param[$field.'_change']) && !empty($param[$field])) {
                $numericValue = str_ireplace(",", "", $param[$field]);
                if ($numericValue > 0) {
                    $hasChanges = true;
                    break;
                }
            }
        }

        if (!$hasChanges) {
            return 'error:' . functions::Xmlinformation('AtLeastOneFieldMustContainAmount');
        }

        $updateCount = 0;
        $insertSuccess = false;
        $firstRecord = true; // فلگ برای شناسایی اولین رکورد

        foreach ($resultTourPackage as $item) {
            $updateData = array();

            // پردازش threeRoomPriceR
            if (!empty($param['threeRoomPriceR_change']) && !empty($param['threeRoomPriceR'])) {
                $numericValue = str_ireplace(",", "", $param['threeRoomPriceR']);
                if ($numericValue > 0) {
                    $currentValue = $item['three_room_price_r'];

                    if ($param['threeRoomPriceR_change'] === 'increase') {
                        $updateData['three_room_price_r'] = $currentValue + $numericValue;
                    } elseif ($param['threeRoomPriceR_change'] === 'decrease') {
                        $updateData['three_room_price_r'] = max(0, $currentValue - $numericValue);
                    }
                }
            }

            // پردازش doubleRoomPriceR
            if (!empty($param['doubleRoomPriceR_change']) && !empty($param['doubleRoomPriceR'])) {
                $numericValue = str_ireplace(",", "", $param['doubleRoomPriceR']);
                if ($numericValue > 0) {
                    $currentValue = $item['double_room_price_r'];

                    if ($param['doubleRoomPriceR_change'] === 'increase') {
                        $updateData['double_room_price_r'] = $currentValue + $numericValue;
                    } elseif ($param['doubleRoomPriceR_change'] === 'decrease') {
                        $updateData['double_room_price_r'] = max(0, $currentValue - $numericValue);
                    }
                }
            }

            // پردازش singleRoomPriceR
            if (!empty($param['singleRoomPriceR_change']) && !empty($param['singleRoomPriceR'])) {
                $numericValue = str_ireplace(",", "", $param['singleRoomPriceR']);
                if ($numericValue > 0) {
                    $currentValue = $item['single_room_price_r'];

                    if ($param['singleRoomPriceR_change'] === 'increase') {
                        $updateData['single_room_price_r'] = $currentValue + $numericValue;
                    } elseif ($param['singleRoomPriceR_change'] === 'decrease') {
                        $updateData['single_room_price_r'] = max(0, $currentValue - $numericValue);
                    }
                }
            }

            // پردازش childWithBedPriceR
            if (!empty($param['childWithBedPriceR_change']) && !empty($param['childWithBedPriceR'])) {
                $numericValue = str_ireplace(",", "", $param['childWithBedPriceR']);
                if ($numericValue > 0) {
                    $currentValue = $item['child_with_bed_price_r'];

                    if ($param['childWithBedPriceR_change'] === 'increase') {
                        $updateData['child_with_bed_price_r'] = $currentValue + $numericValue;
                    } elseif ($param['childWithBedPriceR_change'] === 'decrease') {
                        $updateData['child_with_bed_price_r'] = max(0, $currentValue - $numericValue);
                    }
                }
            }

            // پردازش infantWithoutBedPriceR
            if (!empty($param['infantWithoutBedPriceR_change']) && !empty($param['infantWithoutBedPriceR'])) {
                $numericValue = str_ireplace(",", "", $param['infantWithoutBedPriceR']);
                if ($numericValue > 0) {
                    $currentValue = $item['infant_without_bed_price_r'];

                    if ($param['infantWithoutBedPriceR_change'] === 'increase') {
                        $updateData['infant_without_bed_price_r'] = $currentValue + $numericValue;
                    } elseif ($param['infantWithoutBedPriceR_change'] === 'decrease') {
                        $updateData['infant_without_bed_price_r'] = max(0, $currentValue - $numericValue);
                    }
                }
            }

            // پردازش infantWithoutChairPriceR
            if (!empty($param['infantWithoutChairPriceR_change']) && !empty($param['infantWithoutChairPriceR'])) {
                $numericValue = str_ireplace(",", "", $param['infantWithoutChairPriceR']);
                if ($numericValue > 0) {
                    $currentValue = $item['infant_without_chair_price_r'];

                    if ($param['infantWithoutChairPriceR_change'] === 'increase') {
                        $updateData['infant_without_chair_price_r'] = $currentValue + $numericValue;
                    } elseif ($param['infantWithoutChairPriceR_change'] === 'decrease') {
                        $updateData['infant_without_chair_price_r'] = max(0, $currentValue - $numericValue);
                    }
                }
            }

            // فقط اگر داده‌ای برای آپدیت وجود دارد
            if (!empty($updateData)) {
                $condition = "id='{$item['id']}'";
                $Model->setTable('reservation_tour_package_tb');
                $updateResult = $Model->update($updateData, $condition);

                if ($updateResult) {
                    $updateCount++;

                    // آماده سازی داده‌ها برای درج در جدول تغییرات
                    $dataChange = [
                        'fk_tour_id' => $param['itemId'],
                        'tourId' => $param['tourId'],
                        'userId' => $param['userId'],
                        'created_at' => date('Y-m-d H:i:s', time()),
                        'view' => $firstRecord ? 1 : 0
                    ];

                    if (!empty($param['threeRoomPriceR_change']) && !empty($param['threeRoomPriceR'])) {
                        $numericValue = str_ireplace(",", "", $param['threeRoomPriceR']);
                        if ($numericValue > 0) {
                            $dataChange['three_room_price_r'] = ($param['threeRoomPriceR_change'] === 'increase') ? "+" . $numericValue : "-" . $numericValue;
                        }
                    }

                    if (!empty($param['doubleRoomPriceR_change']) && !empty($param['doubleRoomPriceR'])) {
                        $numericValue = str_ireplace(",", "", $param['doubleRoomPriceR']);
                        if ($numericValue > 0) {
                            $dataChange['double_room_price_r'] = ($param['doubleRoomPriceR_change'] === 'increase') ? "+" . $numericValue : "-" . $numericValue;
                        }
                    }

                    if (!empty($param['singleRoomPriceR_change']) && !empty($param['singleRoomPriceR'])) {
                        $numericValue = str_ireplace(",", "", $param['singleRoomPriceR']);
                        if ($numericValue > 0) {
                            $dataChange['single_room_price_r'] = ($param['singleRoomPriceR_change'] === 'increase') ? "+" . $numericValue : "-" . $numericValue;
                        }
                    }

                    if (!empty($param['childWithBedPriceR_change']) && !empty($param['childWithBedPriceR'])) {
                        $numericValue = str_ireplace(",", "", $param['childWithBedPriceR']);
                        if ($numericValue > 0) {
                            $dataChange['child_with_bed_price_r'] = ($param['childWithBedPriceR_change'] === 'increase') ? "+" . $numericValue : "-" . $numericValue;
                        }
                    }

                    if (!empty($param['infantWithoutBedPriceR_change']) && !empty($param['infantWithoutBedPriceR'])) {
                        $numericValue = str_ireplace(",", "", $param['infantWithoutBedPriceR']);
                        if ($numericValue > 0) {
                            $dataChange['infant_without_bed_price_r'] = ($param['infantWithoutBedPriceR_change'] === 'increase') ? "+" . $numericValue : "-" . $numericValue;
                        }
                    }

                    if (!empty($param['infantWithoutChairPriceR_change']) && !empty($param['infantWithoutChairPriceR'])) {
                        $numericValue = str_ireplace(",", "", $param['infantWithoutChairPriceR']);
                        if ($numericValue > 0) {
                            $dataChange['infant_without_chair_price_r'] = ($param['infantWithoutChairPriceR_change'] === 'increase') ? "+" . $numericValue : "-" . $numericValue;
                        }
                    }

                    $insert = $this->getModel('reservationTourChangePricePackageModel')->insertWithBind($dataChange);
                    $insertSuccess = $insert || $insertSuccess;
                    // بعد از اولین رکورد، فلگ را به false تغییر دهید
                    if ($firstRecord) {
                        $firstRecord = false;
                    }
                }
            }
        }


//        var_dump('55555');
//        var_dump($insertSuccess);
//        var_dump('33333');
//        die;
        if ($updateCount > 0 ) {
            return 'success:' . functions::Xmlinformation('PriceChangeSuccessful');
        } else {
            return 'error:' . functions::Xmlinformation('ErrorChanges');
        }
    }


    public function changeTourPackagePrices($param) {
        $Model = Load::library('Model');
        $sqlTourPackage = "SELECT * FROM reservation_tour_package_tb WHERE fk_tour_id = '{$param['itemId']}'";
        $resultTourPackage = $Model->select($sqlTourPackage);

        if (empty($resultTourPackage)) {
            return json_encode([
                'status'  => 'error',
                'message' => functions::Xmlinformation('NoRecordsFound')
            ]);
        }

        // بررسی اینکه حداقل یک فیلد برای تغییر پر شده است
        $hasChanges = false;
        $fieldsToCheck = [
            'threeRoomPriceR', 'doubleRoomPriceR', 'singleRoomPriceR',
            'childWithBedPriceR', 'infantWithoutBedPriceR', 'infantWithoutChairPriceR'
        ];

        foreach ($fieldsToCheck as $field) {
            if (!empty($param[$field.'_change']) && !empty($param[$field])) {
                $numericValue = str_ireplace(",", "", $param[$field]);
                if ($numericValue > 0) {
                    $hasChanges = true;
                    break;
                }
            }
        }

        if (!$hasChanges) {
            return json_encode([
                'status'  => 'error',
                'message' => functions::Xmlinformation('AtLeastOneFieldMustContainAmount')
            ]);
        }

        $updateCount   = 0;
        $insertSuccess = false;
        $firstRecord   = true; // فلگ برای شناسایی اولین رکورد

        foreach ($resultTourPackage as $item) {
            $updateData = array();

            // پردازش همه‌ی فیلدها
            $mapping = [
                'threeRoomPriceR'       => 'three_room_price_r',
                'doubleRoomPriceR'      => 'double_room_price_r',
                'singleRoomPriceR'      => 'single_room_price_r',
                'childWithBedPriceR'    => 'child_with_bed_price_r',
                'infantWithoutBedPriceR'=> 'infant_without_bed_price_r',
                'infantWithoutChairPriceR' => 'infant_without_chair_price_r'
            ];

            foreach ($mapping as $paramKey => $dbField) {
                if (!empty($param[$paramKey.'_change']) && !empty($param[$paramKey])) {
                    $numericValue = str_ireplace(",", "", $param[$paramKey]);
                    if ($numericValue > 0) {
                        $currentValue = $item[$dbField];

                        if ($param[$paramKey.'_change'] === 'increase') {
                            $updateData[$dbField] = $currentValue + $numericValue;
                        } elseif ($param[$paramKey.'_change'] === 'decrease') {
                            $updateData[$dbField] = max(0, $currentValue - $numericValue);
                        }
                    }
                }
            }

            // فقط اگر داده‌ای برای آپدیت وجود دارد
            if (!empty($updateData)) {
                $condition = "id='{$item['id']}'";
                $Model->setTable('reservation_tour_package_tb');
                $updateResult = $Model->update($updateData, $condition);

                if ($updateResult) {
                    $updateCount++;

                    // آماده سازی داده‌ها برای درج در جدول تغییرات
                    $dataChange = [
                        'fk_tour_id' => $param['itemId'],
                        'tourId'     => $param['tourId'],
                        'userId'     => $param['userId'],
                        'created_at' => date('Y-m-d H:i:s', time()),
                        'view'       => $firstRecord ? 1 : 0
                    ];

                    foreach ($mapping as $paramKey => $dbField) {
                        if (!empty($param[$paramKey.'_change']) && !empty($param[$paramKey])) {
                            $numericValue = str_ireplace(",", "", $param[$paramKey]);
                            if ($numericValue > 0) {
                                $dataChange[$dbField] = ($param[$paramKey.'_change'] === 'increase') ? "+" . $numericValue : "-" . $numericValue;
                            }
                        }
                    }

                    $insert = $this->getModel('reservationTourChangePricePackageModel')->insertWithBind($dataChange);
                    $insertSuccess = $insert || $insertSuccess;

                    // بعد از اولین رکورد، فلگ را به false تغییر دهید
                    if ($firstRecord) {
                        $firstRecord = false;
                    }
                }
            }
        }

        if ($updateCount > 0) {
            return json_encode([
                'status'  => 'success',
                'message' => functions::Xmlinformation('PriceChangeSuccessful')
            ]);
        } else {
            return json_encode([
                'status'  => 'error',
                'message' => functions::Xmlinformation('ErrorChanges')
            ]);
        }
    }



    public function getListChangePricePackage($itemId , $tourId) {
        $result = $this->reservation_tour_change_price_package_model->get()
            ->where('fk_tour_id', $itemId)
            ->where('tourId', $tourId)
            ->where('view', 1)
            ->orderBy('created_at', 'DESC')
            ->orderBy('id', 'ASC')
            ->all();

        foreach ($result as $key => $value) {
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", strtotime($value['created_at']));

            // جایگزینی مقادیر خالی با ---
            $fields = [
                'three_room_price_r', 'double_room_price_r', 'single_room_price_r',
                'child_with_bed_price_r', 'infant_without_bed_price_r', 'infant_without_chair_price_r'
            ];

            foreach ($fields as $field) {
                if (empty($value[$field])) {
                    $result[$key][$field] = '---';
                }
            }
        }
        return $result;
    }
    public function getTourBookingCountPanel($tourCode)
    {
        if (empty($tourCode)) {
            return 0;
        }
        $Model = Load::library('Model');
        $sql = "SELECT COUNT(*) AS total 
            FROM book_tour_local_tb 
            WHERE tour_code = '{$tourCode}' 
            AND ( 
                status = 'BookedSuccessfully' 
                OR 
                (status = 'RequestAccepted' AND payment_status = 'fullPayment')
            )";
        $result = $Model->select($sql);
        if (!empty($result[0]['total'])) {
            return (int)$result[0]['total'];
        }
        return 0;
    }
}


?>
