<?php

//require '/home/safar360/public_html/vendor/autoload.php';
//
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;

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

        $tickets = functions::curlExecution($url, $JsonArray, 'yes');

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

//        functions::insertLog('$result: ' . json_encode($result['Cip']) , '000shojaee');

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

    public function PreReserve($data)
    {

        $d = $data['Books'];
        $service_json = null;
        $url = $this->apiAddress . "Cip/PreReserve/" . $data['RequestNumber'];
        $d['UserName'] = $this->username;
        $d['subAgencyId'] = '';
        $agencyInfo = $this->getController('agency')->subAgencyInfo();
        if ($agencyInfo != null && !empty($agencyInfo['sepehr_username']) && !empty($agencyInfo['sepehr_password'])) {
            $d['subAgencyId'] = $agencyInfo['id'];
        }
        $books = array();
        $sessionID = isset($data['SessionID']) ? $data['SessionID'] : null;

        foreach ($d as $key => $passenger) {

            // فقط کلیدهای عددی = مسافر
            if (!is_numeric($key) || !is_array($passenger)) {
                continue;
            }

            // استخراج ساعت از DateTime
            $time = null;
            if (!empty($passenger['DateTime'])) {
                $dt = explode(' ', $passenger['DateTime']);
                $time = isset($dt[1]) ? $dt[1] : null;
            }

            $books[] = array(
                'FirstName' => isset($passenger['FirstName']) ? $passenger['FirstName'] : null,
                'LastName' => isset($passenger['LastName']) ? $passenger['LastName'] : null,
                'PassportNumber' => isset($passenger['PassportNumber']) ? $passenger['PassportNumber'] : null,
                'DateOfBirth' => isset($passenger['DateOfBirth']) ? $passenger['DateOfBirth'] : null,
                'PassengerTitle' => isset($passenger['PassengerTitle']) ? $passenger['PassengerTitle'] : null,
                'PassportExpireDate' => isset($passenger['PassportExpireDate']) ? $passenger['PassportExpireDate'] : null,
                'Nationality' => isset($passenger['Nationality']) ? $passenger['Nationality'] : null,
                'NationalCode' => isset($passenger['NationalCode']) ? $passenger['NationalCode'] : null,
                'PassengerType' => isset($passenger['PassengerType']) ? $passenger['PassengerType'] : null,
                'Services' => isset($passenger['Services']) ? $passenger['Services'] : null,
                'AirlineIata' => isset($passenger['AirlineIata']) ? trim($passenger['AirlineIata']) : null,
                'FlightNumber' => isset($passenger['FlightNumber']) ? $passenger['FlightNumber'] : null,
                'Time' => $time,
            );
        }

        $output = array(
            'Books' => $books,
            'SessionID' => $sessionID
        );

        $JsonArray = json_encode($output);
        functions::insertLog('$output: ' . $JsonArray, '000shojaee');

        $result = functions::curlExecution($url, $JsonArray, 'yes');
        functions::insertLog('$result: ' . json_encode($result), '000shojaee');




//        $result['entertainments'] = $ent;
//        $adtCount = count(array_filter($result['Passengers'], function ($p) {
//            return strtolower($p['PassengerType']) === 'adt';
//        }));
//
//        $chdCount = count(array_filter($result['Passengers'], function ($p) {
//            return strtolower($p['PassengerType']) === 'chd';
//        }));
//
//        if (Session::IsLogin()) {
//            $userId = Session::getUserId();
//        }
//
//        $user = $this->getModel('membersModel')->getMemberById($userId);
//
//        $model = Load::library('Model');
//        $checkSubAgency = functions::checkExistSubAgency();
//        if ($user['fk_agency_id'] > 0 || $checkSubAgency) {
//            $agencyId = ($checkSubAgency) ? SUB_AGENCY_ID : $user['fk_agency_id'];
//            $sql_agency = " SELECT * FROM agency_tb WHERE id='{$agencyId}'";
//            $agency = $model->load($sql_agency);
//        }
//
//
//        $cipData = [
//            'member_id' => $user['id'],
//            'member_name' => $user['name'] . ' ' . $user['family'],
//            'member_mobile' => $user['mobile'],
//            'member_phone' => $user['telephone'],
//            'member_email' => $user['email'],
//            'agency_id' => $agency['id'],
//            'agency_name' => $agency['name_fa'],
//            'agency_accountant' => $agency['accountant'],
//            'agency_manager' => $agency['manager'],
//            'agency_mobile' => $agency['mobile'],
//            'total_price' => $result['FlightTotalPrice'] + $result['HotelTotalPrice'],
//            'adt_qty' => $adtCount,
//            'chd_qty' => $chdCount,
//            'request_number' => $data['requestNumber'],
//            'factor_number' => substr(time(), 0, 5) . mt_rand(000, 999) . substr(time(), 5, 10),
//            'api_id' => $result['SourceId'],
//            'successfull' => 'lock',
//            'del' => 'no',
//            'creation_date' => date('Y-m-d'),
//            'creation_date_int' => time(),
//            'request_cancel' => 'none',
//            'type_app' => 'Web',
//            'currency_code' => 0,
//            'currency_equivalent' => 0,
//            'flight_number' => $result['Routes']['Output'][0]['FlightNo'],
////            'airline_iata' => $addData['Routes']['Output'][0]['airlineIata'],
//            'check_in' => $result['CheckinDate'],
//            'check_out' => $result['CheckoutDate'],
//            'entertainment_data_json' => $ent_json,
//            'entertainment_ids' => $ent_ids,
//
//        ];
//
//        $book_exclusive_tour_tb = $this->getModel('exclusiveTourModel');
//        $report_exclusive_tour_tb = $this->getModel('exclusiveTourBaseModel');
//
//        foreach ($result['Passengers'] as $p) {
//            $passengerData = array(
//                'passenger_name' => $p['FirstName'],
//                'passenger_family' => $p['LastName'],
//                'passenger_birthday' => $p['DateOfBirth'],
//                'passenger_national_code' => $p['NationalCode'],
//                'passportCountry' => $p['Nationality'],
//                'passportNumber' => $p['PassportNumber'],
//                'passenger_age' => $p['PassengerType']
//            );
//
//            $insert_book = $book_exclusive_tour_tb->insertWithBind(array_merge($cipData, $passengerData));
//
//            if ($insert_book) {
//                $cipData['client_id'] = CLIENT_ID;
//                $insert_report = $report_exclusive_tour_tb->insertWithBind(array_merge($cipData, $passengerData));
//                unset($cipData['client_id']);
//            }
//        }
        return json_encode($result);
    }

    public function Book($data)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $url = $this->apiAddress . "Tour/Book/" . $data['request_number'];

        $d['UserName'] = $this->username;
        $d['SourceId'] = $data['api_id'];

        $d['subAgencyId'] = '';
        $agencyInfo = $this->getController('agency')->subAgencyInfo();
        if ($agencyInfo != null && !empty($agencyInfo['sepehr_username']) && !empty($agencyInfo['sepehr_password'])) {
            $d['subAgencyId'] = $agencyInfo['id'];
        }


        $JsonArray = json_encode($d);

        $result = functions::curlExecution($url, $JsonArray, 'yes');
        if (!empty($result) && $result['curl_error'] == false && !empty($result['Pnr'])) {

            $BookFlight['successfull'] = 'book';
            $BookFlight['provider_ref'] = $result['Pnr'];
            $condition = "request_number='{$data['request_number']}'";
            $Model->setTable("book_exclusive_tour_tb");
            $res = $Model->update($BookFlight, $condition);
            if ($res) {
                $ModelBase->setTable("report_exclusive_tour_tb");
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
            $data_error['origin'] = $data['origin_city'];
            $data_error['destination'] = $data['desti_city'];
            $data_error['action'] = 'Book';
            $data_error['creation_date_int'] = time();
            $this->getController('logErrorExclusiveTour')->insertLogErrorExclusiveTour($data_error);

            $BookFlight['successfull'] = 'error';
            $condition = "request_number='{$data['request_number']}'";
            $Model->setTable("book_exclusive_tour_tb");
            $res = $Model->update($BookFlight, $condition);
            if ($res) {
                $ModelBase->setTable("report_exclusive_tour_tb");
                $ModelBase->update($BookFlight, $condition);
            }

            return false;
        }

    }


}