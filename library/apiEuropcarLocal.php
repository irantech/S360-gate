<?php


class apiEuropcarLocal extends clientAuth
{
    public $username;
    public $password;
    public $apiLink;
    public $apiSoap;
    public $apiData;
    public $IsLogin;
    public $counterId;
    public $serviceDiscountLocal = array();


    function __construct()
    {


    }

    #region curl_init
    /**
     * This function initializes webservice requirements
     * @author Naime Mousavi
     */
    public function curl_init()
    {
        $this->username = 'irantech';
        $this->password = 'iran123';

        $this->apiLink = 'http://webs.europcar.ir/desktopmodules/carrental/CarRental.asmx?wsdl';
        $this->apiSoap = new SoapClient($this->apiLink);

    }
    #endregion


    public function AccessApiEuropcar(){
        $result = parent::apiEuropcarAuth();
        return $result;
    }


    #region getStationApi
    public function getStationApi()
    {
        try
        {
            $apiData = array(
                'username' => $this->username,
                'password' => $this->password
            );

            $result = $this->convertToArray($this->apiSoap->GetStations($apiData));

            return $result;

        }
        catch(Exception $e) {

            $textError = json_decode($e->getMessage());
            functions::insertLog(date('Y/m/d H:i:s') . ' ' . $textError, 'log_apiEuropcar');
        }

    }
    #endregion

    #region getCarRentalReservationApi
    public function getCarRentalReservationApi($sourceStationId, $destStationId, $getCarDateTime, $returnCarDateTime, $priceType)
    {

        try
        {
            $apiData = array(
                'username' => $this->username,
                'password' => $this->password,
                'sourceStationId' => $sourceStationId,
                'destStationId' => $destStationId,
                'getCarDateTime' => $getCarDateTime,
                'returnCarDateTime' => $returnCarDateTime,
                'priceType' => $priceType
            );

            $result = $this->convertToArray($this->apiSoap->CarRentalReservation($apiData));
            return $result;
        }
        catch(Exception $e) {

            $textError = json_decode($e->getMessage());
            functions::insertLog(date('Y/m/d H:i:s') . ' ' . $textError, 'log_apiEuropcar');
        }

    }
    #endregion


    #region getCarsById
    public function getCarsById($carId)
    {
        try
        {
            $apiData = array(
                'username' => $this->username,
                'password' => $this->password,
                'carId' => $carId
            );

            $result = $this->convertToArray($this->apiSoap->GetCarsById($apiData));
            return  $result;
        }
        catch(Exception $e) {

            $textError = json_decode($e->getMessage());
            functions::insertLog(date('Y/m/d H:i:s') . ' ' . $textError, 'log_apiEuropcar');
        }

    }
    #endregion

    #region getThings
    public function getThings()
    {

        try
        {
            $apiData = array(
                'username' => $this->username,
                'password' => $this->password
            );

            return  $this->convertToArray($this->apiSoap->GetThings($apiData));
        }
        catch(Exception $e) {

            $textError = json_decode($e->getMessage());
            functions::insertLog(date('Y/m/d H:i:s') . ' ' . $textError, 'log_apiEuropcar');
        }

    }
    #endregion


    #region getReservePaymentPrice
    public function getReservePaymentPrice($factorNumber)
    {

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $sql = "SELECT * FROM book_europcar_local_tb WHERE factor_number='{$factorNumber}'";
        $book = $Model->load($sql);

        if (!empty($book)) {

            $getDate = explode("T", $book['get_car_date_time']);
            $returnDate = explode("T", $book['return_car_date_time']);
            $StartDateTime = functions::ConvertToMiladi($getDate[0]) . 'T' . $getDate[1];
            $EndDateTime = functions::ConvertToMiladi($returnDate[0]) . 'T' . $returnDate[1];

            $thingData = array();
            if ($book['reserve_car_thing_info'] != ''){
                $thingInfo = json_decode($book['reserve_car_thing_info'], true);
                foreach ($thingInfo as $k=>$thing){
                    $thingData[$k]['ThingId'] = $thing['thingsId'];
                    $thingData[$k]['Count'] = $thing['countThings'];
                    $thingData[$k]['TotalPrice'] = $thing['priceThings'];
                }
            }


            if ((isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], '192.168.1.100') !== false)
                || (isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], 'online.1011.ir') !== false)
                || (isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], 'test.1011.ir') !== false)) {//local && test


                $apiData = array(
                    'username' => $this->username,
                    'password' => $this->password,
                    'reserveCarInfoDetail' => array(
                        'UserFirstName' => 'تست ایران تکنولوژی',
                        'UserLastName' => 'تست ایران تکنولوژی',
                        'Mobile' => $book['passenger_mobile'],
                        'Tell' => $book['passenger_telephone'],
                        'Email' => $book['passenger_email'],
                        'Address' => 'تست ایران تکنولوژی',
                        'RefundType' => $book['refund_type'],
                        'DrivingCrimesType' => $book['driving_crimes_type'],
                        'SourceStationId' => $book['source_station_id'],
                        'DestStationId' => $book['dest_station_id'],
                        'StartDateTime' => $StartDateTime,
                        'EndDateTime' => $EndDateTime,
                        'CarId' => $book['car_id'],
                        'HasSourceStationReturnCost' => $book['has_source_station_return_cost'],
                        'HasDestStationReturnCost' => $book['has_dest_station_return_cost']
                    ),
                    'reserveCarThingInfo' => array(
                        'ReserveCarThingInfo' => $thingData
                    ),
                    'priceType' => '1'
                );


            } else {

                $apiData = array(
                    'username' => $this->username,
                    'password' => $this->password,
                    'reserveCarInfoDetail' => array(
                        'UserFirstName' => $book['passenger_name'],
                        'UserLastName' => $book['passenger_family'],
                        'Mobile' => $book['passenger_mobile'],
                        'Tell' => $book['passenger_telephone'],
                        'Email' => $book['passenger_email'],
                        'Address' => $book['passenger_address'],
                        'RefundType' => $book['refund_type'],
                        'DrivingCrimesType' => $book['driving_crimes_type'],
                        'SourceStationId' => $book['source_station_id'],
                        'DestStationId' => $book['dest_station_id'],
                        'StartDateTime' => $StartDateTime,
                        'EndDateTime' => $EndDateTime,
                        'CarId' => $book['car_id'],
                        'HasSourceStationReturnCost' => $book['has_source_station_return_cost'],
                        'HasDestStationReturnCost' => $book['has_dest_station_return_cost']
                    ),
                    'reserveCarThingInfo' => array(
                        'ReserveCarThingInfo' => $thingData
                    ),
                    'priceType' => '1'
                );

            }

            try
            {
                $result = $this->convertToArray($this->apiSoap->CalculateReserveCarPrice($apiData));

                if ($result['CalculateReserveCarPriceResult']['ReserveTotalPrice'] > 0){

                    $price = $result['CalculateReserveCarPriceResult']['ReserveTotalPrice'];

                    $d['price'] = $price;

                    $this->IsLogin = Session::IsLogin();
                    if ($this->IsLogin){
                        $this->counterId = functions::getCounterTypeId($_SESSION['userId']);
                        $this->serviceDiscountLocal = functions::ServiceDiscount($this->counterId, 'LocalEuropcar');
                        if ($this->serviceDiscountLocal['off_percent']>0){
                            $price = $price - (($price * $this->serviceDiscountLocal['off_percent']) / 100);
                        }
                    }

                    $d['total_price'] = $price;
                    $Condition = "factor_number='{$factorNumber}' ";

                    $Model->setTable("book_europcar_local_tb");
                    $res = $Model->update($d, $Condition);

                    $ModelBase->setTable("report_europcar_tb");
                    $res_report = $ModelBase->update($d, $Condition);

                    if ($res && $res_report){
                        $totalAmount = functions::CurrencyCalculate($price, $book['currency_code'], $book['currency_equivalent']);

                        $output['status'] = true;
                        $output['price'] = $totalAmount['AmountCurrency'];
                        $output['unit'] = $totalAmount['TypeCurrency'];

                    } else {
                        $output['status'] = false;
                        $output['message'] = 'متاسفانه مشکلی در فرآیند رزرو شما پیش آمده است';
                    }

                } else {
                    $output['status'] = false;
                    $output['message'] = $result['CalculateReserveCarPriceResult']['Message'];
                }

            }
            catch(Exception $e) {
                $textError = json_decode($e->getMessage());
                functions::insertLog(date('Y/m/d H:i:s') . ' ' . $textError, 'log_apiEuropcar');
                $output['status'] = false;
                $output['message'] = $e->getMessage();
            }

        } else {

            $output['status'] = false;
            $output['message'] = 'متاسفانه مشکلی در فرآیند رزرو شما پیش آمده است';

        }

        return $output;
    }
    #endregion



    #region getNewReserveCar
    public function getNewReserveCar($factorNumber)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $sql = "SELECT * FROM book_europcar_local_tb WHERE factor_number='{$factorNumber}'";
        $book = $Model->load($sql);

        if (!empty($book)) {

            $getDate = explode("T", $book['get_car_date_time']);
            $returnDate = explode("T", $book['return_car_date_time']);
            $StartDateTime = functions::ConvertToMiladi($getDate[0]) . 'T' . $getDate[1];
            $EndDateTime = functions::ConvertToMiladi($returnDate[0]) . 'T' . $returnDate[1];

            $thingData = array();
            if ($book['reserve_car_thing_info'] != ''){
                $thingInfo = json_decode($book['reserve_car_thing_info'], true);
                foreach ($thingInfo as $k=>$thing){
                    $thingData[$k]['ThingId'] = $thing['thingsId'];
                    $thingData[$k]['Count'] = $thing['countThings'];
                    $thingData[$k]['TotalPrice'] = $thing['priceThings'];
                }
            }

            $pathIdentity = PIC_ROOT . 'europcar/' . $book['identity_file'];
            $typeIdentity = pathinfo($pathIdentity, PATHINFO_EXTENSION);
            $dataIdentity = file_get_contents($pathIdentity);
            $base64Identity = 'data:image/' . $typeIdentity . ';base64,' . base64_encode($dataIdentity);

            $pathHabitation = PIC_ROOT . 'europcar/' . $book['habitation_file'];
            $typeHabitation = pathinfo($pathHabitation, PATHINFO_EXTENSION);
            $dataHabitation = file_get_contents($pathHabitation);
            $base64Habitation = 'data:image/' . $typeHabitation . ';base64,' . base64_encode($dataHabitation);

            $pathJob = PIC_ROOT . 'europcar/' . $book['job_file'];
            $typeJob = pathinfo($pathJob, PATHINFO_EXTENSION);
            $dataJob = file_get_contents($pathJob);
            $base64Job = 'data:image/' . $typeJob . ';base64,' . base64_encode($dataJob);

            if ((isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], '192.168.1.100') !== false)
                || (isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], 'online.1011.ir') !== false)
                || (isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], 'test.1011.ir') !== false)) {//local && test

                $apiData = array(
                    'username' => $this->username,
                    'password' => $this->password,
                    'reserveCarInfoDetail' => array(
                        'UserFirstName' => 'تست ایران تکنولوژی',
                        'UserLastName' => 'تست ایران تکنولوژی',
                        'Mobile' => $book['passenger_mobile'],
                        'Tell' => $book['passenger_telephone'],
                        'Email' => $book['passenger_email'],
                        'Address' => 'تست ایران تکنولوژی',
                        'RefundType' => $book['refund_type'],
                        'DrivingCrimesType' => $book['driving_crimes_type'],
                        'SourceStationId' => $book['source_station_id'],
                        'DestStationId' => $book['dest_station_id'],
                        'StartDateTime' => $StartDateTime,
                        'EndDateTime' => $EndDateTime,
                        'CarId' => $book['car_id'],
                        'HasSourceStationReturnCost' => $book['has_source_station_return_cost'],
                        'HasDestStationReturnCost' => $book['has_dest_station_return_cost']
                    ),
                    'reserveCarThingInfo' => array(
                        'ReserveCarThingInfo' => $thingData
                    ),
                    'identityFiles' => array(
                        'IdentityFileInfo' => array(
                            'IdentityFileType' => $book['identity_file_type'],
                            'IdentityFile' => $base64Identity,
                            'IdentityFileExtension' => '.' . $book['identity_file_extension']
                        )
                    ),
                    'habitationFiles' => array(
                        'HabitationFileTypeInfo' => array(
                            'HabitationFileType' => $book['habitation_file_type'],
                            'HabitationFile' => $base64Habitation,
                            'HabitationFileExtension' => '.' . $book['habitation_file_extension']
                        )
                    ),
                    'jobFiles' => array(
                        'JobFileTypeInfo' => array(
                            'JobFileType' => $book['job_file_type'],
                            'JobFile' => $base64Job,
                            'JobFileExtension' => '.' . $book['job_file_extension']
                        )
                    ),
                    'priceType' => $book['total_price']
                );





            } else {

                $apiData = array(
                    'username' => $this->username,
                    'password' => $this->password,
                    'reserveCarInfoDetail' => array(
                        'UserFirstName' => $book['passenger_name'],
                        'UserLastName' => $book['passenger_family'],
                        'Mobile' => $book['passenger_mobile'],
                        'Tell' => $book['passenger_telephone'],
                        'Email' => $book['passenger_email'],
                        'Address' => $book['passenger_address'],
                        'RefundType' => $book['refund_type'],
                        'DrivingCrimesType' => $book['driving_crimes_type'],
                        'SourceStationId' => $book['source_station_id'],
                        'DestStationId' => $book['dest_station_id'],
                        'StartDateTime' => $StartDateTime,
                        'EndDateTime' => $EndDateTime,
                        'CarId' => $book['car_id'],
                        'HasSourceStationReturnCost' => $book['has_source_station_return_cost'],
                        'HasDestStationReturnCost' => $book['has_dest_station_return_cost']
                    ),
                    'reserveCarThingInfo' => array(
                        'ReserveCarThingInfo' => $thingData
                    ),
                    'identityFiles' => array(
                        'IdentityFileInfo' => array(
                            'IdentityFileType' => $book['identity_file_type'],
                            'IdentityFile' => $base64Identity,
                            'IdentityFileExtension' => '.' . $book['identity_file_extension']
                        )
                    ),
                    'habitationFiles' => array(
                        'HabitationFileTypeInfo' => array(
                            'HabitationFileType' => $book['habitation_file_type'],
                            'HabitationFile' => $base64Habitation,
                            'HabitationFileExtension' => '.' . $book['habitation_file_extension']
                        )
                    ),
                    'jobFiles' => array(
                        'JobFileTypeInfo' => array(
                            'JobFileType' => $book['job_file_type'],
                            'JobFile' => $base64Job,
                            'JobFileExtension' => '.' . $book['job_file_extension']
                        )
                    ),
                    'priceType' => $book['total_price']
                );

            }

            try
            {
                $result = $this->convertToArray($this->apiSoap->NewReserveCar($apiData));
                functions::insertLog(date('Y/m/d H:i:s') . ' ' . 'NewReserveCar:  ' . $result, 'log_apiEuropcar');

                return $result;

            }
            catch(Exception $e) {
                $textError = json_decode($e->getMessage());
                functions::insertLog(date('Y/m/d H:i:s') . ' ' . $textError, 'log_apiEuropcar');
                return 'error';
            }


        } else {

            return 'error';

        }


    }
    #endregion


    #region convertToArray
    public function convertToArray($object){

        return json_decode(json_encode($object), true);

    }
    #endregion


}