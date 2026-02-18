<?php
//
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');

class cip extends clientAuth
{

    protected $uniqueCode;
    protected $InfoSearch;

    private $username;
    private $apiAddress;
    private $model;
    private $modelBase;
    private $logDir = 'cip/';

    public function __construct($url = null)
    {
        parent::__construct();
        $this->init($url);
        $this->model = Load::library('Model');
        $this->modelBase = Load::library('Model');
    }

    public function init($url = null)
    {

        $InfoSources = $this->cipAuth();

        if (!empty($InfoSources)):
            $this->username = $InfoSources['Username'];
        endif;
        $this->apiAddress = functions::UrlSource();
        $this->InfoSearch = functions::configDataRoute(!empty($url) ? $url : $_SERVER['REQUEST_URI']);

    }

    public function UniqueCode($userName)
    {

        $url = $this->apiAddress . "Cip/GetCode/" . $userName;
        $JsonArray = array();
        functions::insertLog('$url: ' . json_encode($url) , '000shojaee');

        $tickets = functions::curlExecution($url, $JsonArray, 'yes');
        functions::insertLog('$tickets: ' . json_encode($tickets) , '000shojaee');
        return $tickets['Result']['Value'];

    }

    public function GetCip($data)
    {
        $dataSearch = $data['dataSearch'];


        $this->UniqueCode = $this->UniqueCode($this->username);
        $url = $this->apiAddress . "Cip/Search/" . $this->UniqueCode;


        $dateMiladi = functions::ConvertToMiladi($dataSearch['date']);
        $d['Date'] = $dateMiladi;
        $d['AirportCode'] = $dataSearch['airport'];
        $d['TripType'] = $dataSearch['trip_type'];
        $d['FlightType'] = $dataSearch['flight_type'];
        $d['UserName'] = $this->username;
        $d['Adult'] = $dataSearch['adult'];
        $d['Child'] = $dataSearch['child'];
        $d['Infant'] = $dataSearch['infant'];

        $JsonArray = json_encode($d);

        functions::insertLog('url is=> ' . $url . '   give time send request With Code =>' . $this->UniqueCode . ' && AirportCode:' . $d['AirportCode'] . ' with data request' . $JsonArray . '\n', 'cip');

        $result = functions::curlExecution($url, $JsonArray, 'yes');


        return json_encode($result['Cip']);
    }


    private function airlineList()
    {
        $airlines = $this->getController('airline')->airLineList();
        $array_airlines = array();
        foreach ($airlines as $airline) {
            $array_airlines[$airline['abbreviation']] = $airline;
        }
        return $array_airlines;
    }

    public function checkLogin()
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!Session::IsLogin()) {
            echo json_encode([
                'data' => [
                    'statusCode' => 403,
                    'messageFa'  => 'لطفا ابتدا لاگین کنید'
                ]
            ]);
            exit;
        }

        $userId = Session::getUserId();
        $user   = $this->getController('members')->findUser($userId);

        if (!$user) {
            echo json_encode([
                'data' => [
                    'statusCode' => 403,
                    'messageFa'  => 'لطفا ابتدا لاگین کنید'
                ]
            ]);
            exit;
        }

        echo json_encode([
            'data' => [
                'statusCode' => 200,
                'messageFa'  => 'با موفقیت وارد شدید'
            ]
        ]);
        exit;
    }


    public function PreReserve($data)
    {

        functions::insertLog('data: ' . json_encode($data) , 'shojaee');
        $url = $this->apiAddress . "Cip/PreReserve/" . $data['RequestNumber'];

        // اطلاعات آژانس
        $agencyInfo = $this->getController('agency')->subAgencyInfo();
        $subAgencyId = '';

        if ($agencyInfo && !empty($agencyInfo['sepehr_username']) && !empty($agencyInfo['sepehr_password'])) {
            $subAgencyId = $agencyInfo['id'];
        }

        // لیست مسافرها
        $passengers = (isset($data['Books']) && is_array($data['Books'])) ? $data['Books'] : array();
        $books = array();
        $adultCount = 0;


        foreach ($passengers as $passenger) {

            if (!is_array($passenger)) {
                continue;
            }

            // استخراج ساعت
            $time = null;
            if (!empty($passenger['DateTime'])) {
                $dt = explode(' ', $passenger['DateTime']);
                $time = isset($dt[1]) ? $dt[1] : null;
            } elseif (!empty($passenger['Time'])) {
                $time = $passenger['Time'];
            }

            $books[] = array(
                'FirstName'          => isset($passenger['FirstName']) ? $passenger['FirstName'] : null,
                'LastName'           => isset($passenger['LastName']) ? $passenger['LastName'] : null,
                'PassportNumber'     => isset($passenger['PassportNumber']) ? $passenger['PassportNumber'] : null,
                'DateOfBirth'        => isset($passenger['DateOfBirth']) ? $passenger['DateOfBirth'] : null,
                'PassengerTitle'     => isset($passenger['PassengerTitle']) ? $passenger['PassengerTitle'] : null,
                'PassportExpireDate' => isset($passenger['PassportExpireDate']) ? $passenger['PassportExpireDate'] : null,
                'Nationality'        => isset($passenger['Nationality']) ? $passenger['Nationality'] : null,
                'NationalCode'       => isset($passenger['NationalCode']) ? $passenger['NationalCode'] : null,
                'PassengerType'      => isset($passenger['PassengerType']) ? $passenger['PassengerType'] : null,
                'Services'           => isset($passenger['Services']) ? $passenger['Services'] : array(),
                'AirlineIata'        => isset($passenger['AirlineIata']) ? trim($passenger['AirlineIata']) : null,
                'FlightNumber'       => isset($passenger['FlightNumber']) ? $passenger['FlightNumber'] : null,
                'Time'               => $time,
            );
        }

        // خروجی نهایی
        $output = array(
            'UserName'    => $this->username,
            'Mobile'    => $data['Mobile'],
            'Email'    =>  $data['Email'],
            'subAgencyId' => $subAgencyId,
            'Books'       => $books,
            'SessionID'   => isset($data['SessionID']) ? $data['SessionID'] : null
        );
        foreach ($books as $b) {
            if (isset($b['PassengerType']) && $b['PassengerType'] == 'Adt') {
                $adultCount++;
            }
        }


        $json = json_encode($output);
        $result = functions::curlExecution($url, $json, 'yes');
        if (!empty($result) && isset($result['Result']['ProviderStatus']) && $result['Result']['ProviderStatus'] === 'Success') {

        // اطلاعات کاربر لاگین شده
        $userId = 0;
        if (Session::IsLogin()) {
            $userId = Session::getUserId();
        }

        $user = $this->getModel('membersModel')->getMemberById($userId);

        // اطلاعات آژانس
        $agency = array();
        $model = Load::library('Model');
        $checkSubAgency = functions::checkExistSubAgency();
        if ($user['fk_agency_id'] > 0 || $checkSubAgency) {
            $agencyId = ($checkSubAgency) ? SUB_AGENCY_ID : $user['fk_agency_id'];
            $sql_agency = " SELECT * FROM agency_tb WHERE id='" . intval($agencyId) . "'";
            $agency = $model->load($sql_agency);
        }

        // شمارش تعداد بزرگسال و کودک
        $chdCount = 0;
        foreach ($books as $b) {
            if (isset($b['PassengerType']) && $b['PassengerType'] == 'Chd') {
                $chdCount++;
            }
        }

            $infCount = 0;
            foreach ($books as $b) {
                if (isset($b['PassengerType']) && $b['PassengerType'] == 'Inf') {
                    $infCount++;
                }
            }



            // استخراج اطلاعات پرواز از اولین مسافر
        $firstBook = !empty($books) ? $books[0] : array();
        $airlineIata = isset($firstBook['AirlineIata']) ? $firstBook['AirlineIata'] : '';
        $flightNumber = isset($firstBook['FlightNumber']) ? $firstBook['FlightNumber'] : '';
        $airportCode = isset($data['Books'][0]['AirportCode']) ? $data['Books'][0]['AirportCode'] : '';
        $dateTime = isset($firstBook['Time']) ? $firstBook['Time'] : '';

        // قیمت کل از پاسخ API
        $totalPrice = isset($data['TotalPrice']) ? intval($data['TotalPrice']) : 0;

        // نام سرویس CIP
        $cipName = isset($data['CipName']) ? $data['CipName'] : '';

        // SourceId از پاسخ API
        $apiId = isset($result['Result']['SourceId']) ? intval($result['Result']['SourceId']) : 0;

        // شماره فاکتور رندم
        $factorNumber = substr(time(), 0, 5) . mt_rand(100, 999) . substr(time(), 5, 10);

            $flightType = isset($data['FlightType']) ? $data['FlightType'] : '';

            $cipData = [
            'member_id'           => isset($user['id']) ? $user['id'] : 0,
            'member_name'         => isset($user['name']) ? $user['name'] . ' ' . $user['family'] : '',
            'member_mobile'       => isset($user['mobile']) ? $user['mobile'] : '',
            'member_phone'        => isset($user['telephone']) ? $user['telephone'] : '',
            'member_email'        => isset($user['email']) ? $user['email'] : '',
            'agency_id'           => isset($agency['id']) ? $agency['id'] : 0,
            'agency_name'         => isset($agency['name_fa']) ? $agency['name_fa'] : '',
            'agency_accountant'   => isset($agency['accountant']) ? $agency['accountant'] : '',
            'agency_manager'      => isset($agency['manager']) ? $agency['manager'] : '',
            'agency_mobile'       => isset($agency['mobile']) ? $agency['mobile'] : '',
            'cip_name'            => $cipName,
            'airport_code'        => $airportCode,
            'airline_iata'        => $airlineIata,
            'flight_type'         => $flightType,
            'airport_code_cip'         => isset($data['AirportCodeCip']) ? $data['AirportCodeCip'] : '',
            'date_time'           => $dateTime,
            'flight_number'       => $flightNumber,
            'total_price'         => $totalPrice,
            'adt_qty'             => $adultCount,
            'chd_qty'             => $chdCount,
            'inf_qty'             => $infCount,
            'request_number'      => isset($data['RequestNumber']) ? $data['RequestNumber'] : '',
            'provider_ref'        => '',
            'factor_number'       => $factorNumber,
            'api_id'              => $apiId,
            'successfull'         => 'prereserve',
            'trip_type'         => '',
            'payment_date'        => '',
            'payment_type'        => 'cash',
            'name_bank_port'      => '',
            'number_bank_port'    => '',
            'tracking_code_bank'  => '',
            'del'                 => 'no',
            'creation_date'       => date('Y-m-d'),
            'creation_date_int'   => time(),
            'request_cancel'      => 'none',
            'type_app'            => 'Web',
            'IsInternal'          => null,
            'currency_code'       => 0,
            'currency_equivalent' => 0,
            'session_id' => $data['SessionID'],
            'airline_name'        => $data['AirlineName'],
            'check_in'            => isset($result['CheckinDate']) ? $result['CheckinDate'] : '',
            'check_out'           => isset($result['CheckoutDate']) ? $result['CheckoutDate'] : '',
            'service_data_json'   => null,
        ];

        $reserve_cip_tb = $this->getModel('cipModel');
        $report_cip_tb = $this->getModel('cipBaseModel');

        // ذخیره تک تک مسافران در دیتابیس
        foreach ($books as $b) {
            // سرویس‌های جانبی هر مسافر
            $serviceJson = (!empty($b['Services'])) ? json_encode($b['Services']) : null;

            $passengerData = array(
                'passenger_name'          => isset($b['FirstName']) ? $b['FirstName'] : '',
                'passenger_family'        => isset($b['LastName']) ? $b['LastName'] : '',
                'passenger_birthday'      => isset($b['DateOfBirth']) ? $b['DateOfBirth'] : '',
                'passenger_national_code' => isset($b['NationalCode']) ? $b['NationalCode'] : '',
                'passportCountry'         => isset($b['Nationality']) ? $b['Nationality'] : '',
                'passportNumber'          => isset($b['PassportNumber']) ? $b['PassportNumber'] : '',
                'passenger_age'           => isset($b['PassengerType']) ? $b['PassengerType'] : 'Adt',
                'passportExpire'           => isset($b['PassportExpireDate']) ? $b['PassportExpireDate'] : '',
                'PassengerTitle'           => isset($b['PassengerTitle']) ? $b['PassengerTitle'] : '',
                'service_data_json'       => $serviceJson,
            );

            $insert_book = $reserve_cip_tb->insertWithBind(array_merge($cipData, $passengerData));

            if ($insert_book) {
                $cipData['client_id'] = CLIENT_ID;
                $insert_report = $report_cip_tb->insertWithBind(array_merge($cipData, $passengerData));
                unset($cipData['client_id']);
            }
        }

        } // end if ProviderStatus === Success

        return json_encode($result);
    }

    public function Book($data)
    {

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $url = $this->apiAddress . "Cip/Book/" . $data['request_number'];

        $d['UserName'] = $this->username;
        $d['SourceId'] = $data['api_id'];
        $d['SessionID'] = $data['session_id'];

        $d['subAgencyId'] = '';
        $agencyInfo = $this->getController('agency')->subAgencyInfo();
        if ($agencyInfo != null && !empty($agencyInfo['sepehr_username']) && !empty($agencyInfo['sepehr_password'])) {
            $d['subAgencyId'] = $agencyInfo['id'];
        }


        $JsonArray = json_encode($d);

        $result = functions::curlExecution($url, $JsonArray, 'yes');

        if (!empty($result) && $result['curl_error'] == false && !empty($result['Pnr'])) {
//        if (!empty($result) && $result['curl_error'] == false) {

            $BookFlight['successfull'] = 'book';
            $BookFlight['provider_ref'] = $result['Pnr'];
//            $BookFlight['provider_ref'] = '';
            $condition = "request_number='{$data['request_number']}'";
            $Model->setTable("book_cip_tb");
            $res = $Model->update($BookFlight, $condition);
            if ($res) {
                $ModelBase->setTable("report_cip_tb");
                $ModelBase->update($BookFlight, $condition);
            }

            return $result;
        } else {

            $MessageError = functions::ShowError($result['Messages']['errorCode']);

            $data_error['message'] = str_replace('\'', '', $result['Messages']['errorMessage']);
            $data_error['message_fa'] = $MessageError;
            $data_error['client_id'] = CLIENT_ID;
            $data_error['messageCode'] = $result['Messages']['errorCode'];
            $data_error['request_number'] = $data['request_number'];
            $data_error['airport_code'] = $data['airport_code'];
            $data_error['airline_iata'] = $data['airline_iata'];
            $data_error['action'] = 'Book';
            $data_error['creation_date_int'] = time();
            $this->getController('logErrorCip')->insertLogErrorCip($data_error);

            $BookFlight['successfull'] = 'error';
            $condition = "request_number='{$data['request_number']}'";
            $Model->setTable("book_cip_tb");
            $res = $Model->update($BookFlight, $condition);
            if ($res) {
                $ModelBase->setTable("report_cip_tb");
                $ModelBase->update($BookFlight, $condition);
            }

            return false;
        }

    }


}