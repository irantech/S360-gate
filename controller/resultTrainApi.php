<?php
/**
 * Class resultTrainApi
 * @property resultTrainApi $resultTrainApi
 */
class resultTrainApi extends newApiTrain
{
    public $route_train = '';
    public $city = '';
    public $tickets = array(); // Search Results -> tickets
    public $maxPrice = "";  //The most expensive ticket prices
    public $minPrice = "";  //The cheapest ticket prices
    public $activeCompanys = array();
    public $userId ;
    public $counterInfo ;
    public $code;


    public function __construct()
    {
      

        parent::__construct();

        $this->userId = !empty($_SESSION['userId']) ? $_SESSION['userId'] : '' ;
        $this->counterInfo = functions::infoCounterType($this->userId);

        if(isset($_POST['code']) && !empty($_POST['code']))
        {
            $this->code = filter_var($_POST['code'],FILTER_SANITIZE_NUMBER_INT);
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
                        foreach ($result['NewDataSet']['Table1'] AS $key => $newarray) {
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
                        foreach ($result AS $key => $newarray) {
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
                    foreach ($result['NewDataSet']['Table1'] AS $key => $newarray) {
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
                    foreach ($result AS $key => $newarray) {
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


    public function getTrainService($data,$code)
    {


        $result = parent::GetOptionalService($data, $code);

        if (isset($result['result_status']) && $result['result_status'] == 'Error') {
            $services_optional['result_status'] = 'Error';
            $services_optional['result_message'] = $result['result_message'];
        }
        if(empty($result)){
            $result = array();
        }
        foreach ($result as $i => $newarray) {
            $services_optional[$i]['ServiceTypeCode'] = $newarray['ServiceTypeCode'];
            $services_optional[$i]['ServiceTypeName'] = $newarray['ServiceTypeName'];
            $services_optional[$i]['Value'] = $newarray['Value'];
            $services_optional[$i]['Total'] = $newarray['Total'];
            $services_optional[$i]['ShowMoney'] = $newarray['ShowMoney'];
            $services_optional[$i]['Description'] = $newarray['Description'];
            $services_optional[$i]['Active'] = $newarray['Active'];

        }
        return $services_optional;
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


        $Model = Load::library('Model');
        $Model->setTable('temporary_train_tb');
        $result = $Model->insertLocal($data);

        if ($result) {
            return $Model->getLastId();
        }
    }

    public function set_session()
    {

        $_SESSION['PostData'] = md5(uniqid(rand(), true));

        return $_SESSION['PostData'];
    }


    public function getDiscount($price,$percent)
    {
      /*  $result = $this->discountTrain($service);
        $percent = ($price * $result['off_percent']) / 100;
        return $percent;*/

       $percent = ($price * $percent) / 100;
       return $percent;

    }



    public function CalculateDiscount($discountType,$owner,$price,$trainNumber,$MoveDate)
    {
        $counterId = Session::getCounterTypeId();
        $idCompany = functions::getIdCompanyTrainByCode($owner);
        $discountInfo = functions::getDiscountSpecialTrain($discountType,$idCompany,$trainNumber,$counterId,$MoveDate);



        $priceDiscount = ($price * $discountInfo['percent']) / 100;
        $data['percent'] = $discountInfo['percent'];
        $data['costOff'] = $priceDiscount;
        return $data;
    }



    public function getResultTrain($params)
    {


        if (isset($params['ArrivalDate']) && !empty($params['ArrivalDate'])) {
            $params['directions'] = 'TwoWay';
        } else {
            $params['directions'] = 'OneWay';
        }


            $dataSendToApi['dateMove'] =  functions::ConvertToMiladi($params['DepartureDate']);
            $dataSendToApi['fromStation'] = $params['DepartureCity'];
            $dataSendToApi['toStation'] = $params['ArrivalCity'];
            $dataSendToApi['typePassenger'] = $params['PassengerNumber'];
            $dataSendToApi['type'] ='dept';
            $result['dept'] = parent::search($dataSendToApi);

            if (isset($params['ArrivalDate']) && !empty($params['ArrivalDate'])) {
                $dataSendToApi['type'] ='return';
                $dataSendToApi['dateMove'] =  functions::ConvertToMiladi($params['ArrivalDate']);
                $result['return'] = parent::search($dataSendToApi);

                if(empty($result['return']['Result'])){
                    $result['dept']['Result'] = array();
                }
            }
            if ((isset($result['dept']['result_status']) && $result['dept']['result_status'] == 'Error') || (isset($result['return']['result_status']) && $result['return']['result_status'] == 'Error')) {
                ob_start();
                ?>
                <div class="userProfileInfo-messge ">
                    <div class="messge-login BoxErrorSearch">
                        <div style="float: right;"><i  class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
                        </div>
                        <div class="TextBoxErrorSearch">

                            <?php echo functions::Xmlinformation('Noresult') ?><br/>
                            <?php echo functions::Xmlinformation('Changeserach') ?>


                        </div>
                    </div>
                </div>
                <?php
                return $PrintPrivateTicket = ob_get_clean();
            } else {
                if ((isset($result['dept']['Result']) && !empty($result['dept']['Result']))
                    || (isset($result['return']['Result']) && !empty($result['return']['Result']))) {

                    $sort = array();
                    $sortReturn = array();
                    foreach ($result['dept']['Result'] as $k => $ticket) {
                        $sort['RationCode'][$k] = $ticket['RationCode'];
                        $sort['Counting'][$k] = $ticket['Counting'];
                        $sort['FullPrice'][$k] = $ticket['FullPrice'];
                    }
                    if (!empty($sort)) {
                        array_multisort($sort['FullPrice'], SORT_ASC,$sort['Counting'], SORT_ASC, $sort['RationCode'], SORT_ASC,  $result['dept']['Result']);
                    }

                    if((isset($result['return']['Result']) && !empty($result['return']['Result']))){
                        foreach ($result['return']['Result'] as $key => $ticketReturn) {
                            $sortReturn['RationCode'][$key] = $ticketReturn['RationCode'];
                            $sortReturn['Counting'][$key] = $ticketReturn['Counting'];
                            $sortReturn['FullPrice'][$key] = $ticketReturn['FullPrice'];
                        }
                        if (!empty($sort)) {
                            array_multisort($sortReturn['RationCode'], SORT_ASC, $sortReturn['Counting'],SORT_ASC,$sortReturn['FullPrice'], SORT_DESC, $result['return']['Result']);
                        }
                    }



                            foreach ($result AS $direction => $arrayDir) {
                                if(!empty($arrayDir['Result']))
                                {
                                    $revers = array_reverse($arrayDir['Result']);
                                    foreach ($revers as $key=>$newarray)
                                    {
                                        $typeTrain = ($newarray['RationCode']=='58') ? 'PrivateTrain': 'Train' ;
                                        $idCompany = functions::getIdCompanyTrainByCode($newarray['Owner']);
                                        $discountInfo = functions::getDiscountSpecialTrain($typeTrain,$idCompany, $newarray['TrainNumber'],$this->counterInfo['id'],$params['DepartureDate']);


                                        $this->tickets[$direction][$key]['RetStatus'] = $newarray['RetStatus'];
                                        $this->tickets[$direction][$key]['Remain'] = $newarray['Remain'];
                                        $this->tickets[$direction][$key]['TrainNumber'] = $newarray['TrainNumber'];
                                        $this->tickets[$direction][$key]['WagonType'] = $newarray['WagonType'];
                                        $this->tickets[$direction][$key]['WagonName'] = $newarray['WagonName'];
                                        $this->tickets[$direction][$key]['PathCode'] = $newarray['PathCode'];
                                        $this->tickets[$direction][$key]['CircularPeriod'] = $newarray['CircularPeriod'];
                                        $this->tickets[$direction][$key]['MoveDate'] = substr($newarray['MoveDate'], 0, 10);
                                        $this->tickets[$direction][$key]['ExitDate'] = substr($newarray['ExitDate'], 0, 10);
                                        $this->tickets[$direction][$key]['IsBetweenWay'] = (str_replace('-','', $newarray['MoveDate']) < str_replace('-','', $newarray['ExitDate'])) ? '1' : '0';
                                        $this->tickets[$direction][$key]['ExitTime'] =  substr($newarray['ExitTime'], 0, 5);
                                        $this->tickets[$direction][$key]['Counting'] = $newarray['Counting'];
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
                                        $this->tickets[$direction][$key]['code'] = $arrayDir['code'];
                                        $this->tickets[$direction][$key]['TypeRoute'] = $direction ;
                                        $this->tickets[$direction][$key]['SourceId'] = $arrayDir['sourceId'] ;
                                        $this->tickets[$direction][$key]['isSpecific'] = ($newarray['RationCode']=='58') ? true: false ;
                                        $priceTrain = round(($newarray['Cost'] - ($discountInfo ? ($this->getDiscount($newarray['Cost'],$discountInfo['percent'])): '0')));
                                        $price[$direction][] =$priceTrain;
                                    }

                                }
                            }

                            $params['minPrice'] = $this->minPrice  = !empty($price[$direction]) ? min($price[$direction]) : '0';
                            $params['maxPrice'] =  $this->maxPrice = !empty($price[$direction]) ? max($price[$direction]) : '0';
                    }

                    $params['DepartureCityCode'] =$params['DepartureCity'];
                    $params['ArrivalCityCode'] = $params['ArrivalCity'];

                    $params['DepartureCity'] = $this->GetNameCity($params['DepartureCity']);
                    $params['ArrivalCity'] = $this->GetNameCity($params['ArrivalCity']);



                    $params['result'] = $this->tickets;


                    $viewControllerTrain = Load::controller('viewResultTrain');

                    return $viewControllerTrain->dataAjaxTrain($params);

                }

    }

    /**
     * @param $service
     * @param $id
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

