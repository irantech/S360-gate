<?php

/**
 * Class resultTrainApi
 *
 * @property trainResult $trainResult
 */
//if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}

class trainResult extends trainCore
{

    public $route_train = '';
    public $city = '';
    public $tickets = array(); // Search Results -> tickets
    public $maxPrice = "";  //The most expensive ticket prices
    public $minPrice = "";  //The cheapest ticket prices
    public $activeCompanys = array();
    public $userId;
    public $counterInfo;
    public $code;


    public function __construct()
    {


        parent::__construct();

        $this->userId = !empty($_SESSION['userId']) ? $_SESSION['userId'] : '';
        $this->counterInfo = functions::infoCounterType($this->userId);

        if (isset($_POST['code']) && !empty($_POST['code'])) {
            $this->code = filter_var($_POST['code'], FILTER_SANITIZE_NUMBER_INT);
        }
    }

    public function getTrainResult($multi_way)
    {

        //        if( parent::wbsLogin()) {
        $login = parent::Login();
        if ($login) {
            if (defined('DEP_CITY')) {
                if ($multi_way == 'yes') {
                    $dateJalali = SEARCH_RETURN_DATE;
                } else {
                    $dateJalali = REQUEST_DATE;
                }
                $date = explode('-', $dateJalali);
                $jmktime = dateTimeSetting::jmktime(0, 0, 0, $date[1], $date[2], $date[0]);
                $dateMiladi = date('Y-m-d', $jmktime);
                $originCode = ($multi_way == 'yes' ? ARR_CITY : DEP_CITY);
                $DestCode = ($multi_way == 'yes' ? DEP_CITY : ARR_CITY);
                $DateMove = $dateMiladi;
                $passengerNum = PASSENGER_NUM;
                $result = parent::GetWagonAvaliableSeatCount($originCode, $DestCode, $DateMove, $passengerNum, $this->token);


                if ($result['result_status'] == 'Error') {
                    $this->tickets['result_status'] = 'Error';
                    $this->tickets['result_message'] = $login['result_message'];
                } else {
                    $rv = array_filter($result['NewDataSet']['Table1'], 'is_array');
                    if (count($rv) > 0) {
                        foreach ($result['NewDataSet']['Table1'] as $key => $newarray) {
                            $this->tickets[$key]['RetStatus'] = $newarray['RetStatus'];
                            $this->tickets[$key]['Remain'] = $newarray['Remain'];
                            $this->tickets[$key]['TrainNumber'] = $newarray['TrainNumber'];
                            $this->tickets[$key]['WagonType'] = $newarray['WagonType'];
                            $this->tickets[$key]['WagonName'] = $newarray['WagonName'];
                            $this->tickets[$key]['PathCode'] = $newarray['PathCode'];
                            $this->tickets[$key]['CircularPeriod'] = $newarray['CircularPeriod'];
                            $this->tickets[$key]['MoveDate'] = substr($newarray['MoveDate'], 0, 10);
                            $this->tickets[$key]['ExitDate'] = substr($newarray['ExitDate'], 0, 10);
                            $this->tickets[$key]['ExitTime'] = substr($newarray['ExitTime'], 0, 5);
                            $this->tickets[$key]['Counting'] = $newarray['Counting'];
                            $this->tickets[$key]['SoldCount'] = $newarray['SoldCount'];
                            $this->tickets[$key]['degree'] = $newarray['degree'];
                            $this->tickets[$key]['AvaliableSellCount'] = $newarray['AvaliableSellCount'];
                            $this->tickets[$key]['Cost'] = $newarray['Cost'];
                            $this->tickets[$key]['FullPrice'] = $newarray['FullPrice'];
                            $this->tickets[$key]['CompartmentCapicity'] = $newarray['CompartmentCapicity'];
                            $this->tickets[$key]['IsCompartment'] = $newarray['IsCompartment'];
                            $this->tickets[$key]['CircularNumberSerial'] = $newarray['CircularNumberSerial'];
                            $this->tickets[$key]['CountingAll'] = $newarray['CountingAll'];
                            $this->tickets[$key]['RateCode'] = $newarray['RateCode'];
                            $this->tickets[$key]['AirConditioning'] = $newarray['AirConditioning'];
                            $this->tickets[$key]['Media'] = $newarray['Media'];
                            $this->tickets[$key]['TimeOfArrival'] = $newarray['TimeOfArrival'];
                            $this->tickets[$key]['RationCode'] = $newarray['RationCode'];
                            $this->tickets[$key]['soldcounting'] = $newarray['soldcounting'];
                            $this->tickets[$key]['SeatType'] = $newarray['SeatType'];
                            $this->tickets[$key]['Owner'] = $newarray['Owner'];
                            $this->tickets[$key]['AxleCode'] = $newarray['AxleCode'];
                            $this->tickets[$key]['serviceSessionId'] = $this->token;
                            $price[] = $newarray['Cost'];
                            $this->minPrice = !empty($price) ? min($price) : '0';
                            $this->maxPrice = !empty($price) ? max($price) : '0';
                            $this->activeCompanys[$key]['code'] = $newarray['Owner'];
                        }
                    } else {
                        foreach ($result as $key => $newarray) {
                            $this->tickets[$key]['RetStatus'] = $newarray['Table1']['RetStatus'];
                            $this->tickets[$key]['Remain'] = $newarray['Table1']['Remain'];
                            $this->tickets[$key]['TrainNumber'] = $newarray['Table1']['TrainNumber'];
                            $this->tickets[$key]['WagonType'] = $newarray['Table1']['WagonType'];
                            $this->tickets[$key]['WagonName'] = $newarray['Table1']['WagonName'];
                            $this->tickets[$key]['PathCode'] = $newarray['Table1']['PathCode'];
                            $this->tickets[$key]['CircularPeriod'] = $newarray['Table1']['CircularPeriod'];
                            $this->tickets[$key]['MoveDate'] = substr($newarray['Table1']['MoveDate'], 0, 10);
                            $this->tickets[$key]['ExitDate'] = substr($newarray['Table1']['ExitDate'], 0, 10);
                            $this->tickets[$key]['ExitTime'] = $newarray['Table1']['ExitTime'];
                            $this->tickets[$key]['Counting'] = $newarray['Table1']['Counting'];
                            $this->tickets[$key]['SoldCount'] = $newarray['Table1']['SoldCount'];
                            $this->tickets[$key]['degree'] = $newarray['Table1']['degree'];
                            $this->tickets[$key]['AvaliableSellCount'] = $newarray['Table1']['AvaliableSellCount'];
                            $this->tickets[$key]['Cost'] = $newarray['Table1']['Cost'];
                            $this->tickets[$key]['FullPrice'] = $newarray['Table1']['FullPrice'];
                            $this->tickets[$key]['CompartmentCapicity'] = $newarray['Table1']['CompartmentCapicity'];
                            $this->tickets[$key]['IsCompartment'] = $newarray['Table1']['IsCompartment'];
                            $this->tickets[$key]['CircularNumberSerial'] = $newarray['Table1']['CircularNumberSerial'];
                            $this->tickets[$key]['CountingAll'] = $newarray['Table1']['CountingAll'];
                            $this->tickets[$key]['RateCode'] = $newarray['Table1']['RateCode'];
                            $this->tickets[$key]['AirConditioning'] = $newarray['Table1']['AirConditioning'];
                            $this->tickets[$key]['Media'] = $newarray['Table1']['Media'];
                            $this->tickets[$key]['TimeOfArrival'] = $newarray['Table1']['TimeOfArrival'];
                            $this->tickets[$key]['RationCode'] = $newarray['Table1']['RationCode'];
                            $this->tickets[$key]['soldcounting'] = $newarray['Table1']['soldcounting'];
                            $this->tickets[$key]['SeatType'] = $newarray['Table1']['SeatType'];
                            $this->tickets[$key]['Owner'] = $newarray['Table1']['Owner'];
                            $this->tickets[$key]['AxleCode'] = $newarray['Table1']['AxleCode'];
                            $this->tickets[$key]['serviceSessionId'] = $this->token;
                            $price[] = $newarray['Table1']['Cost'];
                            $this->minPrice = !empty($price) ? min($price) : '0';
                            $this->maxPrice = !empty($price) ? max($price) : '0';
                            $this->activeCompanys[$key]['code'] = $newarray['Table1']['Owner'];
                        }
                    }
                }
            }
        } else {
            $this->tickets['result_status'] = 'Error';
            $this->tickets['result_message'] = $login['result_message'];
        }

        //        }
        return $this->tickets;
    }

    public function ViewPriceTicket($params)
    {
        $result = parent::ViewPriceTicket($params);
        if ($result['Success'] && $result['StatusCode'] == 200) {
            return $result['Result'];
        }

        return false;
    }

    public function getTrainResultReturn($multi_way)
    {
        if (defined('DEP_CITY')) {
            if ($multi_way == 'yes') {
                $dateJalali = SEARCH_RETURN_DATE;
            } else {
                $dateJalali = REQUEST_DATE;
            }
            $date = explode('-', $dateJalali);
            $jmktime = dateTimeSetting::jmktime(0, 0, 0, $date[1], $date[2], $date[0]);
            $dateMiladi = date('Y-m-d', $jmktime);
            $origincode = ($multi_way == 'yes' ? ARR_CITY : DEP_CITY);
            $DestCode = ($multi_way == 'yes' ? DEP_CITY : ARR_CITY);
            $DateMove = $dateMiladi;
            $passengerNum = PASSENGER_NUM;
            $result = parent::GetWagonAvaliableSeatCount($origincode, $DestCode, $DateMove, $passengerNum, $this->token);


            if (isset($result['result_status']) && $result['result_status'] == 'Error') {
                $this->tickets['result_status'] = $result['result_status'];
                $this->tickets['result_message'] = $result['result_message'];

                return $this->tickets;
            } else {
                $rv = array_filter($result['NewDataSet']['Table1'], 'is_array');
                if (count($rv) > 0) {
                    foreach ($result['NewDataSet']['Table1'] as $key => $newarray) {
                        $this->tickets[$key]['RetStatus'] = $newarray['RetStatus'];
                        $this->tickets[$key]['Remain'] = $newarray['Remain'];
                        $this->tickets[$key]['TrainNumber'] = $newarray['TrainNumber'];
                        $this->tickets[$key]['WagonType'] = $newarray['WagonType'];
                        $this->tickets[$key]['WagonName'] = $newarray['WagonName'];
                        $this->tickets[$key]['PathCode'] = $newarray['PathCode'];
                        $this->tickets[$key]['CircularPeriod'] = $newarray['CircularPeriod'];
                        $this->tickets[$key]['MoveDate'] = substr($newarray['MoveDate'], 0, 10);
                        $this->tickets[$key]['ExitDate'] = substr($newarray['ExitDate'], 0, 10);
                        $this->tickets[$key]['ExitTime'] = $newarray['ExitTime'];
                        $this->tickets[$key]['Counting'] = $newarray['Counting'];
                        $this->tickets[$key]['SoldCount'] = $newarray['SoldCount'];
                        $this->tickets[$key]['degree'] = $newarray['degree'];
                        $this->tickets[$key]['AvaliableSellCount'] = $newarray['AvaliableSellCount'];
                        $this->tickets[$key]['Cost'] = $newarray['Cost'];
                        $this->tickets[$key]['FullPrice'] = $newarray['FullPrice'];
                        $this->tickets[$key]['CompartmentCapicity'] = $newarray['CompartmentCapicity'];
                        $this->tickets[$key]['IsCompartment'] = $newarray['IsCompartment'];
                        $this->tickets[$key]['CircularNumberSerial'] = $newarray['CircularNumberSerial'];
                        $this->tickets[$key]['CountingAll'] = $newarray['CountingAll'];
                        $this->tickets[$key]['RateCode'] = $newarray['RateCode'];
                        $this->tickets[$key]['AirConditioning'] = $newarray['AirConditioning'];
                        $this->tickets[$key]['Media'] = $newarray['Media'];
                        $this->tickets[$key]['TimeOfArrival'] = $newarray['TimeOfArrival'];
                        $this->tickets[$key]['RationCode'] = $newarray['RationCode'];
                        $this->tickets[$key]['soldcounting'] = $newarray['soldcounting'];
                        $this->tickets[$key]['SeatType'] = $newarray['SeatType'];
                        $this->tickets[$key]['Owner'] = $newarray['Owner'];
                        $this->tickets[$key]['AxleCode'] = $newarray['AxleCode'];
                        ['AxleCode'];
                        $this->tickets[$key]['serviceSessionId'] = $this->token;

                    }
                } else {
                    foreach ($result as $key => $newarray) {
                        $this->tickets[$key]['RetStatus'] = $newarray['Table1']['RetStatus'];
                        $this->tickets[$key]['Remain'] = $newarray['Table1']['Remain'];
                        $this->tickets[$key]['TrainNumber'] = $newarray['Table1']['TrainNumber'];
                        $this->tickets[$key]['WagonType'] = $newarray['Table1']['WagonType'];
                        $this->tickets[$key]['WagonName'] = $newarray['Table1']['WagonName'];
                        $this->tickets[$key]['PathCode'] = $newarray['Table1']['PathCode'];
                        $this->tickets[$key]['CircularPeriod'] = $newarray['Table1']['CircularPeriod'];
                        $this->tickets[$key]['MoveDate'] = substr($newarray['Table1']['MoveDate'], 0, 10);
                        $this->tickets[$key]['ExitDate'] = substr($newarray['Table1']['ExitDate'], 0, 10);
                        $this->tickets[$key]['ExitTime'] = $newarray['Table1']['ExitTime'];
                        $this->tickets[$key]['Counting'] = $newarray['Table1']['Counting'];
                        $this->tickets[$key]['SoldCount'] = $newarray['Table1']['SoldCount'];
                        $this->tickets[$key]['degree'] = $newarray['Table1']['degree'];
                        $this->tickets[$key]['AvaliableSellCount'] = $newarray['Table1']['AvaliableSellCount'];
                        $this->tickets[$key]['Cost'] = $newarray['Table1']['Cost'];
                        $this->tickets[$key]['FullPrice'] = $newarray['Table1']['FullPrice'];
                        $this->tickets[$key]['CompartmentCapicity'] = $newarray['Table1']['CompartmentCapicity'];
                        $this->tickets[$key]['IsCompartment'] = $newarray['Table1']['IsCompartment'];
                        $this->tickets[$key]['CircularNumberSerial'] = $newarray['Table1']['CircularNumberSerial'];
                        $this->tickets[$key]['CountingAll'] = $newarray['Table1']['CountingAll'];
                        $this->tickets[$key]['RateCode'] = $newarray['Table1']['RateCode'];
                        $this->tickets[$key]['AirConditioning'] = $newarray['Table1']['AirConditioning'];
                        $this->tickets[$key]['Media'] = $newarray['Table1']['Media'];
                        $this->tickets[$key]['TimeOfArrival'] = $newarray['Table1']['TimeOfArrival'];
                        $this->tickets[$key]['RationCode'] = $newarray['Table1']['RationCode'];
                        $this->tickets[$key]['soldcounting'] = $newarray['Table1']['soldcounting'];
                        $this->tickets[$key]['SeatType'] = $newarray['Table1']['SeatType'];
                        $this->tickets[$key]['Owner'] = $newarray['Table1']['Owner'];
                        $this->tickets[$key]['AxleCode'] = $newarray['Table1']['AxleCode'];
                        $this->tickets[$key]['serviceSessionId'] = $this->token;

                    }
                }

                return $this->tickets;
            }


        }


    }


    public function getTrainService($requestData)
    {
        $services_optional = array();

        $result = parent::GetOptionalService($requestData);
        if ($result['Success'] && $result['StatusCode'] == 200 && !empty($result['Result'])) {
            foreach ($result['Result'] as $i => $newarray) {
                $services_optional[$i]['ServiceTypeCode'] = $newarray['ServiceTypeCode'];
                $services_optional[$i]['ServiceTypeName'] = $newarray['ServiceTypeName'];
                $services_optional[$i]['Value'] = $newarray['Value'];
                $services_optional[$i]['Total'] = $newarray['Total'];
                $services_optional[$i]['ShowMoney'] = $newarray['ShowMoney'];
                $services_optional[$i]['Description'] = $newarray['Description'];
                $services_optional[$i]['Active'] = $newarray['Active'];
            }
        }

        return $services_optional;
    }
    public function getFreeServices($requestData)
    {

        $services_free_optional = array();

        $result = parent::GetFreePassengerServices($requestData);

        if ($result['Success'] && $result['StatusCode'] == 200 && !empty($result['Result'])) {
          if($result['Result']){
              $services_free_optional[0]['ServiceTypeCode'] = $result['Result']['Code'];
              $services_free_optional[0]['ServiceTypeName'] = $result['Result']['Name'];
          }

//            foreach ($result['Result'] as $i => $newarray) {
//                $services_optional[$i]['ServiceTypeCode'] = $newarray['ServiceTypeCode'];
//                $services_optional[$i]['ServiceTypeName'] = $newarray['ServiceTypeName'];
//                $services_optional[$i]['Value'] = $newarray['Value'];
//                $services_optional[$i]['Total'] = $newarray['Total'];
//                $services_optional[$i]['ShowMoney'] = $newarray['ShowMoney'];
//                $services_optional[$i]['Description'] = $newarray['Description'];
//                $services_optional[$i]['Active'] = $newarray['Active'];
//            }
        }

        return $services_free_optional;
    }


    #region getOriginCitiesFromDB
    public function getRouteFromDB()
    {

        $ModelBase = Load::library('ModelBase');
        //        $sql = " SELECT DISTINCTROW Departure_City,Departure_City_IataCode FROM bus_route_tb ORDER BY  priorityDeparture=0,priorityDeparture";/*WHERE $Condition*/
        $sql = " SELECT DISTINCTROW Code,Name,EnglishName,TelCode FROM train_route_tb ORDER BY  Code ASC";/*WHERE $Condition*/

        $departures = $ModelBase->select($sql);

        $this->route_train = $departures;

    }
    #endregion

    #region GetNameDeparture
    public function GetNameCity($param)
    {

        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT DISTINCT Name  FROM train_route_tb WHERE Code ='{$param}' ";

        $city = $ModelBase->load($sql);

        return $city['Name'];
    }
    #endregion

    #region DateJalali
    public function DateJalali($param)
    {
        $explode_date = explode('-', $param);
        if ($explode_date[0] > 1450) {
            $paramMiladi = functions::ConvertToJalali($param);
            $explode_date_miladi = explode('-', $paramMiladi);
            $jmktime = dateTimeSetting::jmktime('0', '0', '0', $explode_date_miladi[1], $explode_date_miladi['2'], $explode_date_miladi[0]);
        } else {
            $jmktime = dateTimeSetting::jmktime(0, 0, 0, $explode_date[1], $explode_date[2], $explode_date[0]);
        }


        $this->date_now = dateTimeSetting::jdate(" j F Y", $jmktime);

        $this->DateJalaliRequest = dateTimeSetting::jdate("Y-m-d", $jmktime, '', '', 'en');

        $this->day = dateTimeSetting::jdate("l", $jmktime);
    }
    #endregion

    #region indate
    public function indate($param)
    {
        $timenow = time();
        $explode = explode('-', $param);
        if ($explode[0] > 1450) {
            $jmktime = mktime('0', '0', '0', $explode[1], $explode['2'], $explode[0]);
        } else {
            $jmktime = dateTimeSetting::jmktime(0, 0, 0, $explode[1], $explode[2], $explode[0]);
        }

        if ($jmktime > $timenow) {
            return true;
        } else {
            return false;
        }
    }
    #endregion

    #region DatePrev
    public function DatePrev($param)
    {
        $explode = explode('-', $param);
        if ($explode[0] > 1450) {
            $jmktime = mktime('0', '0', '0', $explode[1], $explode['2'], $explode[0]);
        } else {
            $jmktime = dateTimeSetting::jmktime(0, 0, 0, $explode[1], $explode[2], $explode[0]);
        }

        return dateTimeSetting::jstrftime("%Y-%m-%d", $jmktime - (24 * 60 * 60), '', '', 'en');
    }
    #endregion

    #region DateNext
    public function DateNext($param)
    {
        $explode = explode('-', $param);

        if ($explode[0] > 1450) {
            $jmktime = mktime('0', '0', '0', $explode[1], $explode['2'], $explode[0]);
        } else {
            $jmktime = dateTimeSetting::jmktime(0, 0, 0, $explode[1], $explode[2], $explode[0]);
        }

        return dateTimeSetting::jstrftime("%Y-%m-%d", $jmktime + (24 * 60 * 60), '', '', 'en');
    }
    #endregion

    #region DateJalali
    public function DateJalali2($param)
    {
        $explode_date = explode('/', $param);

        if ($explode_date[0] > 1450) {
            $jmktime = mktime('0', '0', '0', $explode_date[1], $explode_date['2'], $explode_date[0]);
        } else {
            $jmktime = dateTimeSetting::jmktime(0, 0, 0, $explode_date[1], $explode_date[2], $explode_date[0]);
        }


        $this->date_now = dateTimeSetting::jdate(" j F Y", $jmktime);

        $this->DateJalaliRequest = dateTimeSetting::jdate("Y-m-d", $jmktime, '', '', 'en');

        $this->day = dateTimeSetting::jdate("l", $jmktime);
    }

    #endregion

    public function saveSelectedTrain($input)
    {
        $data['PassengerNum'] = $input['PassengerNum'];
        $data['ServiceCode'] = $input['ServiceCode'];
        $data['CompanyName'] = $input['CompanyName'];
        $data['RetStatus'] = $input['RetStatus'];
        $data['Remain'] = $input['Remain'];
        $data['TrainNumber'] = $input['TrainNumber'];
        $data['WagonType'] = $input['WagonType'];
        $data['WagonName'] = $input['WagonName'];
        $data['PathCode'] = $input['PathCode'];
        $data['CircularPeriod'] = $input['CircularPeriod'];
        $data['MoveDate'] = $input['MoveDate'];
        $data['ExitDate'] = $input['ExitDate'];
        $data['ExitTime'] = $input['ExitTime'];
        $data['Counting'] = $input['Counting'];
        $data['SoldCount'] = $input['SoldCount'];
        $data['degree'] = $input['degree'];
        $data['AvaliableSellCount'] = $input['AvaliableSellCount'];
        $data['Cost'] = $input['Cost'];
        $data['FullPrice'] = $input['FullPrice'];
        $data['CompartmentCapicity'] = $input['CompartmentCapicity'];
        $data['IsCompartment'] = $input['IsCompartment'];
        $data['CircularNumberSerial'] = $input['CircularNumberSerial'];
        $data['CountingAll'] = $input['CountingAll'];
        $data['RateCode'] = $input['RateCode'];
        $data['AirConditioning'] = $input['AirConditioning'];
        $data['Media'] = $input['Media'];
        $data['TimeOfArrival'] = $input['TimeOfArrival'];
        $data['RationCode'] = $input['RationCode'];
        $data['soldcounting'] = $input['soldcounting'];
        $data['SeatType'] = $input['SeatType'];
        $data['Owner'] = $input['Owner'];
        $data['AxleCode'] = $input['AxleCode'];
        $data['Departure_City'] = $input['Departure_City'];
        $data['Arrival_City'] = $input['Arrival_City'];
        $data['Dep_Code'] = $input['Dep_Code'];
        $data['Arr_Code'] = $input['Arr_Code'];
        $data['Adult'] = $input['ADULT'];
        $data['Child'] = $input['CHILD'];
        $data['Infant'] = $input['INFANT'];
        $data['ServiceSessionId'] = $input['ServiceSessionId'];
        $data['Route_type'] = $input['Route_type'];
        $data['SourceId'] = $input['SourceId'];
        $data['UniqueId'] = $input['UniqueId'];
        $data['code'] = $input['RequestNumber'];

        /** @var temporaryTrainModel $temp_model */
        $temp_model = Load::getModel('temporaryTrainModel');

        //		$Model = Load::library( 'Model' );
        //		$Model->setTable( 'temporary_train_tb' );
        //		$result = $Model->insertLocal( $data );

        $result = $temp_model->insertWithBind($data);
        if ($result) {
            return $temp_model->getLastId();
        }

        return false;
    }

    public function set_session()
    {

        $_SESSION['PostData'] = md5(uniqid(rand(), true));

        return $_SESSION['PostData'];
    }

    public function getDiscount($price, $percent)
    {
        /*  $result = $this->discountTrain($service);
          $percent = ($price * $result['off_percent']) / 100;
          return $percent;*/

        $percent = ($price * $percent) / 100;

        return $percent;

    }

    public function CalculateDiscount($discountType, $owner, $price, $trainNumber=null, $MoveDate=null)
    {
        $counterId = Session::getCounterTypeId();
        $idCompany = functions::getIdCompanyTrainByCode($owner);
        $discountInfo = functions::getDiscountSpecialTrain($discountType, $idCompany, $trainNumber, $counterId, $MoveDate);


        $priceDiscount = ($price * $discountInfo['percent']) / 100;
        $data['percent'] = $discountInfo['percent'];
        $data['costOff'] = $priceDiscount;

        return $data;
    }

    public function getResultTrain($params)
    {

    //this is the updating times from raja and Fadak
        $times_array = [
            ['00:00:00','00:15:00'],
            ['06:30:00','06:45:00'],
            ['13:30:00','13:45:00'],
            ['19:30:00','19:45:00'],
//            ['00:00:00','23:59:59'] //this is just a temporary time to show disabled result todo: don't forget to remove this line after raja became stable
        ];
        $timezone = new DateTimeZone('Asia/Tehran');
        $date = new DateTime('now',$timezone );
         $time = $date->format('H:i:s');

//	    foreach ( $times_array as $times ) {
//            if($times[1] >= $time && $time >= $times[0]){
//
//                $html = '<div class="userProfileInfo-messge ">' .
//                    $html.=  '<div class="messge-login BoxErrorSearch">' .
//                        '<div style="float: right;"><i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>' .
//                        '</div>' .
//                        '<div class="TextBoxErrorSearch">';
//	            $html .= '<h6 class="p-2">'.functions::Xmlinformation("RajaBackupErrorMessage").'</h6>';
//                $html .='</div></div></div>';
//                return $html;
//            }
//        }

        if (isset($params['ReturnDate']) && !empty($params['ReturnDate'])) {
            $params['directions'] = 'TwoWay';
        } else {
            $params['directions'] = 'OneWay';
        }

        $dataSendToApi['MoveDate'] = functions::ConvertToMiladi($params['DepartureDate']);
        $dataSendToApi['FromStation'] = $params['DepartureCity'];
        $dataSendToApi['ToStation'] = $params['ArrivalCity'];
        $dataSendToApi['TypePassenger'] = $params['PassengerNumber'];
        $dataSendToApi['ReturnDate'] = functions::ConvertToMiladi($params['ReturnDate']);
        $dataSendToApi['AdultCount'] = $params['AdultCount'];
        $dataSendToApi['ChildCount'] = $params['ChildCount'];
        $dataSendToApi['InfantCount'] = $params['InfantsCount'];
        $dataSendToApi['Type'] = 'dept';

        $result['dept'] = parent::search($dataSendToApi);


      
       
        if (isset($params['ReturnDate']) && !empty($params['ReturnDate'])) {
            $dataSendToApi['Type'] = 'return';
            $dataSendToApi['MoveDate'] = functions::ConvertToMiladi($params['ReturnDate']);
            $result['return'] = parent::search($dataSendToApi);
            if (empty($result['return']['Result'])) {
                $result['dept']['Result'] = array();
            }
        }
        if (isset($result['dept']['Success']) && $result['dept']['Success'] == false || !is_array($result['dept']['Result'])) {


            ob_start();
            $full_capacity_controller = $this->getController('fullCapacity');
            $get_full_capacity = $full_capacity_controller->getFullCapacitySite(1);
            if ($get_full_capacity['pic_url']) {
              $pic_not_resule = "<img src='".$get_full_capacity['pic_url'] ."' alt='".$get_full_capacity['pic_title'] ."'>";
            }else{
              $pic_not_resule = " <img src='".ROOT_ADDRESS_WITHOUT_LANG."/view/" . FOLDER_CLIENT . "/assets/images/fullCapacity.png' alt='fullCapacity'>";
            }
            echo '<code style="display:none">'.json_encode([$result,$dataSendToApi],256|64).'</code>';
            ?>
<!--            <div class="userProfileInfo-messge ">-->
<!--                <div class="messge-login BoxErrorSearch">-->
<!--                    <div style="float: right;"><i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>-->
<!--                    </div>-->
<!--                    <div class="TextBoxErrorSearch">-->
<!--                        --><?php //echo functions::Xmlinformation('Noresult') ?><!--<br/>-->
<!--                        --><?php //echo functions::Xmlinformation('Changeserach') ?>
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

                <div id='show_offline_request' >
                  <div class='fullCapacity_div'>
                      <?php echo $pic_not_resule ?>
                    <h2>  <?php echo functions::Xmlinformation('Noresult') ?></h2>
                  </div>
                </div>

            <?php
            return json_encode([
                'data'   => $PrintPrivateTicket = ob_get_clean(),
                'company_list' => []
            ]);
        } else {
            $company_list = [] ;
            if ((isset($result['dept']['Success']) && $result['dept']['Success'] == true && is_array($result['dept']['Result']))
                || (isset($result['return']['Success']) && $result['return']['Success'] == true && is_array($result['return']['Result']))) {

                $sort = array();
                $sortReturn = array();

                foreach ($result['dept']['Result'] as $k => $ticket) {
                    $check_time_past = functions::compareTimeTrainForShowList($ticket['ExitTime'],substr($ticket['MoveDate'], 0, 10),substr($ticket['ExitDate'], 0, 10));
                    $ticket['check_time'] = $check_time_past ;
                    if (round($ticket['Counting']) > 0 && $check_time_past) {
                        $sort[] = $ticket;
                    } else {
                         $ticket['Counting'] =  0 ;
                         $sort_zero[] = $ticket;
                    }
                }

                $main_sort = array();
                foreach ($sort as $key_main_sort => $item_sort) {
                    $main_sort['RationCode'][$key_main_sort] = $item_sort['RationCode'];
                    $main_sort['Counting'][$key_main_sort] = $item_sort['Counting'];
                    $main_sort['FullPrice'][$key_main_sort] = $item_sort['FullPrice'];
                }
               


                if (!empty($main_sort)) {
                    array_multisort($main_sort['FullPrice'], SORT_ASC,$main_sort['Counting'], SORT_ASC, $main_sort['RationCode'], SORT_ASC,  $sort);
                }


                if (!empty($sort) && !empty($sort_zero)) {
                    $result['dept']['Result'] = array_merge($sort, $sort_zero);
                } elseif (empty($sort) && !empty($sort_zero)) {
                    $result['dept']['Result'] = $sort_zero;
                } else {
                    $result['dept']['Result'] = $sort;
                }



                if ((isset($result['return']['Result']) && !empty($result['return']['Result']))) {



                    foreach ($result['return']['Result'] as $k => $ticket) {
                        $check_time_past = functions::compareTimeTrainForShowList($ticket['ExitTime'],substr($ticket['MoveDate'], 0, 10),substr($ticket['ExitDate'], 0, 10));
                        $ticket['check_time'] = $check_time_past ;
                        if (round($ticket['Counting']) > 0 && $check_time_past) {
                            $sortReturn[] = $ticket;
                        } else {
                            $ticket['Counting'] =  0 ;
                            $sortReturn_zero[] = $ticket;
                        }
                    }

                    foreach ($sortReturn as $key => $ticketReturn) {

                        $main_sort_return['RationCode'][$key] = $ticketReturn['RationCode'];
                        $main_sort_return['Counting'][$key] =  $ticketReturn['Counting'];
                        $main_sort_return['FullPrice'][$key] = $ticketReturn['FullPrice'];
                    }

                    if (!empty($main_sort_return)) {
                        array_multisort($main_sort_return['FullPrice'], SORT_ASC,$main_sort_return['Counting'], SORT_ASC, $main_sort_return['RationCode'], SORT_ASC,  $sortReturn);
                    }

                    if (!empty($sortReturn) && !empty($sortReturn_zero)) {
                        $result['return']['Result'] = array_merge($sortReturn, $sortReturn_zero);
                    } elseif (empty($sortReturn) && !empty($sortReturn_zero)) {
                        $result['return']['Result'] = $sortReturn_zero;
                    } else {
                        $result['return']['Result'] = $sortReturn;
                    }

                }

                foreach ($result as $direction => $arrayDir) {
                    if (!empty($arrayDir['Result'])) {
                        $RequestNumber = $arrayDir['RequestNumber'];
//                        $revers = array_reverse($arrayDir['Result']);
                        foreach ($arrayDir['Result'] as $key => $newarray) {
                            if(!in_array($newarray['Owner'] , $company_list)) {
                                $company_list[] = $newarray['Owner'] ;
                            }
                            $typeTrain = ($newarray['RationCode'] == '58') ? 'PrivateTrain' : 'Train';
                            $idCompany = functions::getIdCompanyTrainByCode($newarray['Owner']);
                            $discountInfo = functions::getDiscountSpecialTrain($typeTrain, $idCompany, $newarray['TrainNumber'], $this->counterInfo['id'], $params['DepartureDate']);

                            $this->tickets[$direction][$key]['AdultCount'] = $params['AdultCount'];
                            $this->tickets[$direction][$key]['ChildCount'] = $params['ChildCount'];
                            $this->tickets[$direction][$key]['InfantsCount'] = $params['InfantsCount'];
                            $this->tickets[$direction][$key]['RetStatus'] = $newarray['RetStatus'];
                            $this->tickets[$direction][$key]['Remain'] = $newarray['Remain'];
                            $this->tickets[$direction][$key]['TrainNumber'] = $newarray['TrainNumber'];
                            $this->tickets[$direction][$key]['WagonType'] = $newarray['WagonType'];
                            $this->tickets[$direction][$key]['WagonName'] = $newarray['WagonName'];
                            $this->tickets[$direction][$key]['PathCode'] = $newarray['PathCode'];
                            $this->tickets[$direction][$key]['CircularPeriod'] = $newarray['CircularPeriod'];
                            $this->tickets[$direction][$key]['IsBetweenWay'] = (str_replace('-', '', $newarray['MoveDate']) < str_replace('-', '', $newarray['ExitDate'])) ? '1' : '0';
                            $this->tickets[$direction][$key]['MoveDate'] = substr($newarray['MoveDate'], 0, 10);
                            $this->tickets[$direction][$key]['ExitDate'] = substr($newarray['ExitDate'], 0, 10);
                            $this->tickets[$direction][$key]['ExitTime'] = substr($newarray['ExitTime'], 0, 5);
                            $this->tickets[$direction][$key]['Counting'] =  $newarray['Counting'];
                            $this->tickets[$direction][$key]['SoldCount'] = $newarray['SoldCount'];
                            $this->tickets[$direction][$key]['degree'] = $newarray['degree'];
                            $this->tickets[$direction][$key]['AvaliableSellCount'] = $newarray['AvaliableSellCount'];
                            $this->tickets[$direction][$key]['Cost'] = $newarray['Cost'];
                            $this->tickets[$direction][$key]['FullPrice'] = $newarray['FullPrice'];
                            $this->tickets[$direction][$key]['CompartmentCapicity'] = $newarray['CompartmentCapicity'];
                            $this->tickets[$direction][$key]['IsCompartment'] = $newarray['IsCompartment'];
                            $this->tickets[$direction][$key]['CircularNumberSerial'] = $newarray['CircularNumberSerial'];
                            $this->tickets[$direction][$key]['CountingAll'] = $newarray['CountingAll'];
                            $this->tickets[$direction][$key]['RateCode'] = $newarray['RateCode'];
                            $this->tickets[$direction][$key]['AirConditioning'] = $newarray['AirConditioning'];
                            $this->tickets[$direction][$key]['Media'] = $newarray['Media'];
                            $this->tickets[$direction][$key]['TimeOfArrival'] = $newarray['TimeOfArrival'];
                            $this->tickets[$direction][$key]['RationCode'] = $newarray['RationCode'];
                            $this->tickets[$direction][$key]['soldcounting'] = $newarray['soldcounting'];
                            $this->tickets[$direction][$key]['SeatType'] = $newarray['SeatType'];
                            $this->tickets[$direction][$key]['Owner'] = $newarray['Owner'];
                            $this->tickets[$direction][$key]['AxleCode'] = $newarray['AxleCode'];
                            $this->tickets[$direction][$key]['Owner'] = $newarray['Owner'];
                            $this->tickets[$direction][$key]['serviceSessionId'] = $arrayDir['token'];
                            $this->tickets[$direction][$key]['RequestNumber'] = $RequestNumber;
                            $this->tickets[$direction][$key]['TypeRoute'] = $direction;
                            $this->tickets[$direction][$key]['isSpecific'] = ($newarray['RationCode'] == '58') ? true : false;
                            $this->tickets[$direction][$key]['UniqueId'] = $newarray['UniqueId'];
                            $this->tickets[$direction][$key]['SourceId'] = $newarray['SourceId'];
                            $this->tickets[$direction][$key]['Hint'] = $newarray['Hint'];
                            $priceTrain = round(($newarray['Cost'] - ($discountInfo ?
                                    ($this->getDiscount($newarray['Cost'], $discountInfo['percent'])) : '0')));
                            $price[$direction][] = $priceTrain;
                        }

                    }
                }

                $params['minPrice'] = $this->minPrice = !empty($price[$direction]) ? min($price[$direction]) : '0';
                $params['maxPrice'] = $this->maxPrice = !empty($price[$direction]) ? max($price[$direction]) : '0';
            }

            $params['DepartureCityCode'] = $params['DepartureCity'];
            $params['ArrivalCityCode'] = $params['ArrivalCity'];

            $params['DepartureCity'] = $this->GetNameCity($params['DepartureCity']);
            $params['ArrivalCity'] = $this->GetNameCity($params['ArrivalCity']);

            if(count($company_list) > 0 ) {
                $company_bus_model = $this->getModel('baseCompanyBusModel');
                $request_params['type'] = 'train' ;
                $request_params['list'] = $company_list ;
                $company_list = $company_bus_model->getSpecialCompanyBus($request_params) ;
            }


            $params['company_list'] = $company_list ;
            $params['result'] = $this->tickets;
       


            /** @var trainViewResult $trainViewResult */
            $trainViewResult = Load::controller('trainViewResult');
//            if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//                var_dump(json_encode($trainViewResult->dataAjaxTrain($params)));
//                var_dump($params);
//                die();
//            }

//            if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
              return json_encode([
                'data'   => $trainViewResult->dataAjaxTrain($params) ,
                  'company_list' => $company_list
              ]);
//            }

//            return $trainViewResult->dataAjaxTrain($params);

        }

    }

    public function getApiTrains($params)
    {
        if (isset($params['ReturnDate']) && !empty($params['ReturnDate'])) {
            $params['directions'] = 'TwoWay';
        } else {
            $params['directions'] = 'OneWay';
        }

        $dataSendToApi['MoveDate'] = functions::ConvertToMiladi($params['DepartureDate']);
        $dataSendToApi['FromStation'] = $params['DepartureCity'];
        $dataSendToApi['ToStation'] = $params['ArrivalCity'];
        $dataSendToApi['TypePassenger'] = $params['PassengerNumber'];
        $dataSendToApi['ReturnDate'] = functions::ConvertToMiladi($params['ReturnDate']);
        $dataSendToApi['AdultCount'] = $params['AdultCount'];
        $dataSendToApi['ChildCount'] = $params['ChildCount'];
        $dataSendToApi['InfantCount'] = $params['InfantsCount'];
        $dataSendToApi['Type'] = 'dept';
        $result['dept'] = parent::search($dataSendToApi);
        if (isset($params['ReturnDate']) && !empty($params['ReturnDate'])) {
            $dataSendToApi['type'] = 'return';
            $dataSendToApi['MoveDate'] = functions::ConvertToMiladi($params['ReturnDate']);
            $result['return'] = parent::search($dataSendToApi);
            if (empty($result['return']['Result'])) {
                $result['dept']['Result'] = array();
            }
        }
        if ($result['dept']['Success'] == true) {
            return functions::withSuccess($result);
        }

        return functions::withError($result, $result['dept']['StatusCode'], $result['dept']['Message']);

    }

    /**
     * @param $service
     * @param $id
     *
     * @return mixed
     */
    public function discountTrain($service)
    {
        if (Session::IsLogin()) {
            $id = Session::getCounterTypeId();
        } else {
            $id = 5;
        }
        $Model = Load::library('Model');
        $query = "SELECT * FROM services_discount_tb WHERE service_title='{$service}' AND counter_id ='{$id}'";
        $result = $Model->load($query);

        return $result;
    }


}

