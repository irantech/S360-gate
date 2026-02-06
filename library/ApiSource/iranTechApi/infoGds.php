<?php

//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************

class infoGds extends baseController {
    protected $content;
    protected $adminController;

    public $transactions;

    public function __construct() {

        $this->transactions = $this->getModel('transactionsModel');

        header( "Content-type: application/json;" );

        if ( $_SERVER['REQUEST_METHOD'] == 'POST' && ( strpos( $_SERVER['CONTENT_TYPE'], 'application/json' ) ) !== false ) {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            $this->content = $data;
            $this->adminController = Load::controller( 'admin' );
            $method = $this->content['method'];
            unset($this->content['method']);
            $params = $this->content;

            echo  $this->$method( $params ); die();

        } else {
            $resultJsonArray = array(
                'Result' => array(
                    'RequestStatus' => 'Error',
                    'Message'       => 'NotValidTypeRequest',
                    'MessageCode'   => 'Error100',
                ),
            );
            echo  json_encode( $resultJsonArray );die();
        }


    }

    public function callSyncDatabase($params) {

        $service=$params['service'];
        unset($params['service']);
        unset($params['method']);

        /** @var syncDatabase $syncDatabase */
        $syncDatabase=Load::controller('syncDatabase');
        return json_encode($syncDatabase->fetchService($service,$params),256|64);
    }

    public function infoClient( $param ) {
        $client = functions::infoClient( $param['clientId'] );

        $data = array(
            'domain'     => $client['Domain'],
            'nameAgency' => $client['AgencyName'],
            'manager'    => $client['Manager'],
        );


        return json_encode( $data );
    }

    public function getUser( $params ) {

        $result = $this->getClientToken( $params['clientToken'] );

        $admin = Load::controller( 'admin' );

        $password   = functions::encryptPassword( $params['password'] );
        $sql        = " SELECT * FROM members_tb WHERE
                                email='{$params['email']}' AND
                                password='{$password}'";
        $clientUser = $admin->ConectDbClient( $sql, $result['client_id'], "Select", "", "", "" );


        if ( ! empty( $clientUser ) ) {
            if ( $clientUser['active'] === 'on' && $clientUser['del'] === 'no' ) {
                if ( $clientUser['is_member'] === '1' ) {
                    $response = $this->getUserArray( $clientUser, $result['client_id'] );
                } else {

                    $response = false;
                }
            } else {

                $response = false;
            }
        } else {

            $sql        = " SELECT * FROM agency_tb WHERE
                                email='{$params['email']}' AND
                                password='{$password}'";
            $clientUser = $admin->ConectDbClient( $sql, $result['client_id'], "Select", "", "", "" );


            if ( ! empty( $clientUser ) ) {
                if ( $clientUser['active'] === 'on' && $clientUser['del'] === 'no' ) {
                    if ( $clientUser['is_member'] === '1' ) {
                        $response = $this->getUserArray( $clientUser, $result['client_id'], 'agency' );
                    } else {
                        $response = false;
                    }
                } else {

                    $response = false;
                }

            } else {
                $response = false;
            }
        }

        return json_encode( $response, true );
    }

    public function registerUser( $params ) {


        $result             = $this->getClientToken( $params['clientToken'] );
        $params['clientId'] = $result['client_id'];
        $params['mobile']   = $params['password'];


        $submitRegisterUser = $this->submitRegisterUser( $params );
        if ( $submitRegisterUser['Result']['RequestStatus'] === 'Success' ) {
            $result = [
                'status' => 'success',
                'user'   => $submitRegisterUser['Result']['user']
            ];
        } else {
            $result = [
                'status' => 'error-submitRegisterUser'
            ];
        }


        return json_encode( $result, true );
    }


    /**
     * @param $params
     *
     * @return array
     */
    public function getClientToken( $params ) {
        $ModelBase = Load::library( 'ModelBase' );
        $sql       = " SELECT client_id FROM login_tb WHERE token='" . $params . "'  ";

        return $ModelBase->load( $sql );
    }

    public function getClientData( $params ) {
        $ModelBase = Load::library( 'ModelBase' );
        $client_id = $this->getClientToken( $params['clientToken'] )['client_id'];

        $clientSql    = " SELECT * FROM clients_tb WHERE id='" . $client_id . "'  ";
        $clientResult = $ModelBase->load( $clientSql );

        return json_encode( $clientResult, true );
    }

    public function getIranCities( $params ) {
        $ModelBase    = Load::library( 'ModelBase' );
        $clientSql    = " SELECT id,user_id,parent,title,sort,PC.long,lat FROM province_cities PC";
        $clientResult = $ModelBase->select( $clientSql );

        return json_encode( $clientResult, true );
    }

    public function getStateCities( $params ) {
        $ModelBase = Load::library( 'ModelBase' );

        $correctSql    = " SELECT PC.long,PC.lat FROM province_cities PC WHERE id = '" . $params['state_id'] . "' ";
        $correctResult = $ModelBase->load( $correctSql );

        $clientSql    = " SELECT id,user_id,parent,title,sort FROM province_cities WHERE parent = '" . $params['state_id'] . "' ";
        $clientResult = $ModelBase->select( $clientSql );

        $resultJsonArray = [
            'title'   => 'انجام شد',
            'message' => 'اطلاعات شهر دریافت شد',
            'long'    => $correctResult['long'],
            'lat'     => $correctResult['lat'],
            'status'  => 'success',
            'data'    => $clientResult,
            'http'    => 200
        ];

        return json_encode( $resultJsonArray, true );
    }

    public function getCity( $params ) {
        $ModelBase    = Load::library( 'ModelBase' );
        $clientSql    = " SELECT id,user_id,parent,title,sort FROM province_cities WHERE id = '" . $params['id'] . "' ";
        $clientResult = $ModelBase->load( $clientSql );

        return json_encode( $clientResult, true );
    }


    public function submitRegisterUser( $param ) {
        if ( ! empty( $param['mobile'] ) && ! empty( $param['email'] ) && ! empty( $param['name'] ) && ! empty( $param['family'] ) ) {


            $email    = strtolower( $param['email'] );
            $password = functions::encryptPassword( $param['mobile'] );

            $data['password']           = $password;
            $data['email']              = $email;
            $data['name']               = $param['name'];
            $data['family']             = $param['family'];
            $data['mobile']             = $param['mobile'];
            $data['TypeOs']             = 'Api';
            $data['fk_counter_type_id'] = '5';
            $data['fk_agency_id']       = '0';
            $data['is_member']          = '1';
            $data['card_number']        = '0';


            $resultInsert = $this->adminController->ConectDbClient( '', $param['clientId'], 'Insert', $data, 'members_tb', '' );

            if ( $resultInsert ) {
                $sql        = " SELECT * FROM members_tb WHERE
                                email='{$email}' AND
                                password='{$password}'";
                $admin      = Load::controller( 'admin' );
                $clientUser = $admin->ConectDbClient( $sql, $param['clientId'], "Select", "", "", "" );
                $user       = $this->getUserArray( $clientUser, $param['clientId'] );

                //token
                $tokenData['user_id']  = $clientUser['id'];
                $tokenData['appToken'] = $param['appToken'];
                $resultTokenInsert     = $this->adminController->ConectDbClient( '', $param['clientId'], 'Insert', $tokenData, 'user_api_token_tb', '' );

                if ( $resultTokenInsert ) {
                    $resultJsonArray = array(
                        'Result' => array(
                            'RequestStatus' => 'Success',
                            'MessageEn'     => 'UserRegistrationSuccessful ',
                            'MessageFa'     => 'ثبت نام با موفقیت انجام شد',
                            'MessageCode'   => 'Success200',
                            'user'          => $user,
                        ),
                    );
                } else {
                    $resultJsonArray = array(
                        'Result' => array(
                            'RequestStatus' => 'user_api_token',
                            'MessageEn'     => 'ErrorInRegister',
                            'MessageFa'     => 'خطا در فرآیند ثبت نام',
                            'MessageCode'   => 'Error100',
                        ),
                    );
                }
            } else {
                $resultJsonArray = array(
                    'Result' => array(
                        'RequestStatus' => 'Error',
                        'MessageEn'     => 'ErrorInRegister',
                        'MessageFa'     => 'خطا در فرآیند ثبت نام',
                        'MessageCode'   => 'Error100',
                    ),
                );
            }

        } else {
            $resultJsonArray = array(
                'RequestStatus' => 'Error',
                'MessageEn'     => 'InfoDataIsInvalid',
                'MessageFa'     => 'مقادیر ارسال شده نامعتبر است',
                'MessageCode'   => 'Error160',
            );
        }

        return ( $resultJsonArray );
    }

    public function updateToken( $param ) {
//        error_reporting(1);
//        error_reporting(E_ALL | E_STRICT);
//        @ini_set('display_errors', 1);
//        @ini_set('display_errors', 'on');

        $result            = $this->getClientToken( $param['clientToken'] );
        $param['clientId'] = $result['client_id'];


        $tokenData['user_id']  = $param['user_id'];
        $tokenData['appToken'] = $param['appToken'];



        $resultTokenInsert     = $this->adminController->ConectDbClient( '', $param['clientId'], 'Insert', $tokenData, 'user_api_token_tb', '' );



        if ( $resultTokenInsert ) {
            $resultJsonArray = [
                'status' => 'success',
            ];
        } else {
            unset( $tokenData['user_id'] );
            $resultTokenInsert = $this->adminController->ConectDbClient( '', $param['clientId'], 'Update', $tokenData, 'user_api_token_tb', "user_id = '" . $param['user_id'] . "'" );

            if ( $resultTokenInsert ) {
                $resultJsonArray = [
                    'status' => 'success',
                ];
            } else {
                $resultJsonArray = [
                    'status' => 'error',
                ];
            }
        }
        echo json_encode( $resultJsonArray );
    }

    /**
     * @param $clientUser
     * @param $client_id
     * @param string $userType
     *
     * @return array
     */
    public function getUserArray( $clientUser, $client_id, $userType = 'member' ) {
        $response = [
            'member_id'     => $clientUser['id'],
            'client_id'     => $client_id,
            'name'          => $clientUser['name'],
            'family'        => $clientUser['family'],
            'mobile'        => $clientUser['mobile'],
            'nationalCode'  => $clientUser['nationalCode'],
            'telephone'     => $clientUser['telephone'],
            'email'         => $clientUser['email'],
            'password'      => $clientUser['password'],
            'gender'        => $clientUser['gender'],
            'birthday'      => $clientUser['birthday'],
            'address'       => $clientUser['address'],
            'register_date' => $clientUser['register_date'],
            'userType'      => $userType,
        ];

        return $response;
    }

    public function orderRequest( $params ) {
        $result             = $this->getClientToken( $params['clientToken'] );
        $params['clientId'] = $result['client_id'];



        $clientUser = $this->getUserByApiToken( $params );



        if ( ! empty( $clientUser ) ) {
            $admin = Load::controller( 'admin' );

            $data['user_api_id']  = $clientUser['id'];
            $data['shipment_id']  = $params['shipment_id'];
            $data['accessStatus'] = 'denied';

            $sql        = " SELECT * FROM postage_tb WHERE
                                user_api_id='{$data['user_api_id']}'
                                AND shipment_id='{$params['shipment_id']}'";
            $clientUser = $admin->ConectDbClient( $sql, $params['clientId'], "Select", "", "", "" );


            if ( ! empty( $clientUser ) ) {
                if ( @$params['accessStatus'] === 'remove' ) {
                    $customMessage = 'درخواست شما حذف شد';
                    $resultInsert  = $this->adminController->ConectDbClient( '', $params['clientId'], 'Delete', '', 'postage_tb', "user_api_id = '" . $data['user_api_id'] . "' AND shipment_id = '" . $params['shipment_id'] . "' " );
                } else {
                    $customMessage = 'درخواست شما ثبت شد';
                    $resultInsert  = $this->adminController->ConectDbClient( '', $params['clientId'], 'Update', $data, 'postage_tb', "user_api_id = '" . $data['user_api_id'] . "' AND shipment_id = '" . $params['shipment_id'] . "' " );
                }
            } else {
                $customMessage = 'درخواست شما ثبت شد';
                $resultInsert  = $this->adminController->ConectDbClient( '', $params['clientId'], 'Insert', $data, 'postage_tb', '' );
            }
            if ( $resultInsert ) {
                $resultJsonArray = [
                    'title'   => 'انجام شد',
                    'message' => $customMessage,
                    'status'  => 'success',
                    'http'    => 200
                ];
            } else {
                $resultJsonArray = [
                    'title'   => 'مشکل سیستمی',
                    'message' => 'خطا در احراز هویت شما',
                    'status'  => 'error',
                    'http'    => 500
                ];
            }
        } else {
            $resultJsonArray = [
                'title'   => 'مشکل امنیتی',
                'message' => 'لطفا دوباره ورود کنید',
                'status'  => 'error',
                'http'    => 401
            ];
        }


        return json_encode( $resultJsonArray, true );
    }

    /**
     * @param $params
     *
     * @return array
     */
    public function getUserByApiToken( $params ) {
        $sql   = " SELECT * FROM user_api_token_tb WHERE
                                appToken='{$params['user_token']}'";
        $admin = Load::controller( 'admin' );

        return $admin->ConectDbClient( $sql, $params['clientId'], "Select", "", "", "" );
    }

    public function webhook( $params = [] ) {

        if ( ! isset( $params['service'] ) || ! isset( $params['action'] ) ) {
            http_response_code( 400 );
            echo json_encode( [ 'error' => true, 'message' => 'service or action not found' ] );
            exit();
        }
        if ( $params['service'] == 'hotel' ) {

            http_response_code( 200 );
            $result = self::hotelWebhook( $params );
            echo json_encode( $result );
            exit();
        }
        echo json_encode( [ 'error' => true, 'message' => 'service not found' ] );
        exit();
    }

    public function hotelWebhook( $params = [] ) {

        functions::insertLog('webhook log'. json_encode($params,256|64),'webhook_requests');
        $result = [ 'message' => 'no message', 'error' => true ];
        if ( isset( $params['action'] ) && $params['action'] == 'reserve_change' ) {

            $reserve_data   = $params['reserve_data'];
            $request_number = $reserve_data['request_number'];
            $status         = $reserve_data['status'];
            $confirmation_code         = $reserve_data['reserve_detail']['confirmation_code'];
            $price_session_id         = $reserve_data['price_session_id'];


//			$sql            = "SELECT * FROM `report_hotel_tb` WHERE request_number = '{$request_number}';";
            /** @var reportHotelModel $report_model */
            $report_model = Load::getModel('reportHotelModel');
            $smsController = Load::controller('smsServices');
            $objSms = $smsController->initService('0');

            $hotel_report = $report_model->get()->where('request_number',$request_number);

            if($price_session_id){
                $hotel_report = $hotel_report->where('price_session_id',$price_session_id);
            }
//            if($confirmation_code){
//                $hotel_report = $hotel_report->where('pnr',$confirmation_code);
//            }
            $hotel_report = $hotel_report->all();

//			/** @var ModelBase $ModelBase */
//			$ModelBase    = Load::library( 'ModelBase' );
//			$hotel_report = $ModelBase->select( $sql );
            if ( $hotel_report ) {

                $client_id = $hotel_report[0]['client_id'];
                /** @var admin $admin */
                $admin     = Load::controller( 'admin' );
                $condition = "request_number = '{$request_number}' ";
                if($price_session_id){
                    $condition = $condition ." AND price_session_id = '{$price_session_id}' ";
                }

                if ( $status == 'booking' ) {
                    $updateArray = [ 'status' => 'PreReserve', 'admin_checked' => '1' ];

//                    $ModelBase->setTable( 'report_hotel_tb' );
                    $res1 = $report_model->update( $updateArray, $condition );
                    $res2 = $admin->ConectDbClient( '', $client_id, 'Update', $updateArray, 'book_hotel_local_tb', $condition );
                    if ( $res1 && $res2 ) {
                        $result['message'] = 'update success';
                        $result['error']   = false;
                    }

                    $webhook_price = $reserve_data['reserve_detail']['total_sales_price'];
                    $report_price_api = $hotel_report[0]['total_price_api'];

                    if($webhook_price > $report_price_api){

                        $insert_price_change_array = array(
                            'factor_number'=>$hotel_report[0]['factor_number'],
                            'old_price'=>$report_price_api,
                            'new_price'=>$webhook_price,
                            'change_type'=>'webhook',
                            'client_id'=>$client_id,
                            'created_at'=>date('Y-m-d H:i:s'),
                        );

                        /** @var webhookPriceChangesModel $price_change */
                        $price_change = Load::getModel('webhookPriceChangesModel');
//                        $ModelBase->setTable( 'webhook_price_changes_tb' );
                        $price_change_insert = $price_change->insertWithBind($insert_price_change_array);
//                        $price_change_insert = $price_change->insertWithBind($insert_price_change_array);

                        unset($insert_price_change_array['client_id']);
                        $res2 = $admin->ConectDbClient( '', $client_id, 'Insert', $insert_price_change_array, 'webhook_price_changes_tb', $condition );
                    }


                    if ($objSms) {
                        if (!empty(   $hotel_report[0]['member_mobile'])) {
                            $mobile = $hotel_report[0]['member_mobile'];
                            $name = $hotel_report[0]['member_name'];
                        } else {
                            $mobile = $hotel_report[0]['passenger_leader_room'];
                            $name = $hotel_report[0]['passenger_leader_room_fullName'];
                        }

                        $confirm_requested_hotel =   $smsController->getPattern('confirm_requested_hotel');

                        if($confirm_requested_hotel) {
                            $smsController->smsByPattern($confirm_requested_hotel['pattern'], array($mobile), array('passenger_name' => $name  , 'factor_number' => $hotel_report[0]['factor_number'] ));
                        }
                        else {
                            $messageVariables = array(
                                'sms_name' => $name,
                                'sms_service' => 'هتل',
                                'sms_factor_number' => $hotel_report[0]['factor_number'],
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
                                'memberID' => (!empty($hotel_report[0]['member_id']) ? $hotel_report[0]['member_id'] : ''),
                                'receiverName' => $messageVariables['sms_name'],
                            );
                            $smsController->sendSMS($smsArray);
                        }
                    }


                }
                if ( $status == 'rejected' ) {
                    $updateArray = [ 'status' => 'Cancelled', 'admin_checked' => '1' ];
                    functions::insertLog('before report update','webhook_requests');
                    $res1 = $report_model->update($updateArray,$condition);
//					$ModelBase->setTable( 'report_hotel_tb' );
//					$res1 = $ModelBase->update( $updateArray, $condition );
                    functions::insertLog('after report update '.json_encode([$updateArray,$condition]),'webhook_requests');
                    $res2 = $admin->ConectDbClient( '', $client_id, 'Update', $updateArray, 'book_hotel_local_tb', $condition );
                    functions::insertLog('after res2 update','webhook_requests');
                    $update_transaction = ['PaymentStatus'=>'pending'];
                    $transaction_condition = "FactorNumber='{$hotel_report[0]['factor_number']}'";
                    $res_transaction = $admin->ConectDbClient('',$client_id,'Update',$update_transaction,'transaction_tb',$transaction_condition);

                    $update_transaction['clientID'] = $client_id;
                    $this->transactions->updateTransaction($update_transaction,$transaction_condition);

                    functions::insertLog('after res_transaction update '.json_encode([$update_transaction,$transaction_condition]),'webhook_requests');
                    if ( $res1 && $res2 ) {
                        $result['message'] = 'Reject Success';
                        $result['data'] = [$res1,$res2,$res_transaction];
                        $result['error']   = false;
                    }
                }
                if ( $status == 'definite' ) {

                    $updateArray = [ 'status' => 'BookedSuccessfully' , 'pnr' => $confirmation_code ];
//					$ModelBase->setTable( 'report_hotel_tb' );
//					$res1 = $ModelBase->update( $updateArray, $condition );
                    $res1 = $report_model->update($updateArray,$condition);
                    $res2 = $admin->ConectDbClient( '', $client_id, 'Update', $updateArray, 'book_hotel_local_tb', $condition );
                    $data_transaction['PaymentStatus']='success';
                    $data_transaction['PriceDate']=date("Y-m-d H:i:s");
                    $data_transaction['BankTrackingCode']='';
                    $condition_transaction="FactorNumber = '{$hotel_report[0]['factor_number']}'";

                    $res3 = $admin->ConectDbClient('', $client_id, 'Update', $data_transaction, 'transaction_tb', $condition_transaction);

                    $data_transaction['clientID'] = $client_id;
                    $this->transactions->updateTransaction($data_transaction,$condition_transaction);

                    if ( $res1 && $res2 && $condition_transaction) {
                        $result['message'] = 'Book Success';
                        $result['error']   = false;
                    }
                }
                if ( $status == 'pending' ) {
                    $updateArray = [ 'status' => 'OnRequest' ];
//					$ModelBase->setTable( 'report_hotel_tb' );
//					$res1 = $ModelBase->update( $updateArray, $condition );
                    $res1 = $report_model->update($updateArray,$condition);
                    $res2 = $admin->ConectDbClient( '', $client_id, 'Update', $updateArray, 'book_hotel_local_tb', $condition );
                    if ( $res1 && $res2 ) {
                        $result['message'] = 'pending Success';
                        $result['error']   = false;
                    }
                }
            }

        }
        functions::insertLog('webhook result '. json_encode($result,256|64),'webhook_requests');
        return $result;
    }

    public function getBusRouteCities( $params ) {

        return json_encode( functions::searchBusCities( $params ), true );
    }

    public function getAllBusRouteCities( $params ) {
        return json_encode( functions::getRoutes( $params ), true );
    }

    public function valueHandler( $params, $defaultValue ) {
        $params['operator'] = ( isset( $params['operator'] ) ? $params['operator'] : '=' );
        $params['value']    = ( isset( $params['value'] ) ? $params['value'] : $defaultValue );

        return $params;
    }

    public function tourApi( $params ) {
        $whereQuery = '1=1 ';

        if ( isset( $params['is_del'] ) ) {
            $params['is_del'] = $this->valueHandler( $params['is_del'], 'no' );
            $whereQuery       .= "AND tour.is_del " . $params['is_del']['operator'] . " '" . $params['is_del']['value'] . "' ";
        }

        if ( isset( $params['is_show'] ) ) {
            $params['is_show'] = $this->valueHandler( $params['is_show'], 'yes' );
            $whereQuery        .= "AND tour.is_show " . $params['is_show']['operator'] . " '" . $params['is_show']['value'] . "' ";
        }

        if ( isset( $params['language'] ) ) {
            $params['language'] = $this->valueHandler( $params['language'], 'en' );
            $whereQuery         .= "AND tour.LANGUAGE " . $params['language']['operator'] . " '" . $params['language']['value'] . "' ";
        }

        if ( isset( $params['start_date'] ) ) {
            $params['start_date'] = $this->valueHandler( $params['start_date'], '' );
            $whereQuery           .= "AND tour.start_date " . $params['start_date']['operator'] . " '" . $params['start_date']['value'] . "' ";
        }


        if ( isset( $params['destination_country_id'] ) ) {
            $params['destination_country_id'] = $this->valueHandler( $params['destination_country_id'], '1' );
            $whereQuery                       .= "AND tourRout.destination_country_id " . $params['destination_country_id']['operator'] . " '" . $params['destination_country_id']['value'] . "' ";
        }

        if ( isset( $params['tour_title'] ) ) {
            $params['tour_title'] = $this->valueHandler( $params['tour_title'], 'dept' );
            $whereQuery           .= "AND tourRout.tour_title " . $params['tour_title']['operator'] . " '" . $params['tour_title']['value'] . "' ";
        }
        $limit = '';
        if ( isset( $params['limit'] ) ) {
            $limit = "LIMIT 0," . $params['limit'];
        }


        $sql = "SELECT
                    tour.id,
                    tour.id_same,
                    tour.tour_name_en,
                    tour.tour_name,
                    tour.night,
                    tour.start_date,
                    tour.tour_pic,
                    tour.tour_type_id,
                    tour.is_special,
                    tour.description
                FROM
                    reservation_tour_tb AS tour
                    INNER JOIN reservation_tour_rout_tb AS tourRout ON tourRout.fk_tour_id = tour.id
                WHERE
                    {$whereQuery}
                GROUP BY
                    tour.id_same
                ORDER BY
                    tour.id DESC
                {$limit}
                    ";

        $Model  = Load::library( 'Model' );
        $result = $Model->select( $sql );

        return json_encode( $result, true );
    }


    //Todo create a func for get hotel webservice cities.
    public function getHotelCities($params)
    {
        $ModelBase = Load::library( 'ModelBase' );
        $sqlReservationCities = " SELECT id AS city_id,city_name AS city_name, city_name_en AS city_name_en FROM hotel_cities_tb ";
        return json_encode( $ModelBase->select( $sqlReservationCities ) );
    }

    public function searchboxHotels( $params ) {

        $name      = urldecode( $params['inputValue'] );
        $result    = [];
        $hotelHtml = '';
        $i         = 0;

        //		echo CLIENT_DOMAIN ;
        //		$sqlReservationCities = "
        //		SELECT id AS city_id,city_name AS city_name, city_name_en AS city_name_en FROM hotel_cities_tb WHERE city_name LIKE '{$name}%' OR city_name_en LIKE '{$name}%' OR city_iata LIKE '{$name}%'
        //		";

        /** @var hotelCitiesModel $hotel_cities */
        $hotel_cities = Load::getModel('hotelCitiesModel');
        if(!$name){
            $result['Cities'] = [];
            $result['ApiHotels'] = [];
            $result['ReservationHotels'] = [];

            echo functions::clearJsonHiddenCharacters( json_encode( $result ) );
            exit();
        }
        $cities = $hotel_cities->get(['id AS city_id','city_name','city_name_en'])
            ->like('city_name',"{$name}%","LEFT")
            ->like('city_name_en',"{$name}%","LEFT")
            ->like('city_iata',"{$name}%","LEFT")
            ->all();

        $Model                = Load::library( 'Model' );
        if ( count( $cities ) > 0 ) {
            $result['Cities'] = [];
            foreach ( $cities as $city ) {
                $cityItem = [
                    'CityId'     => $city['city_id'],
                    'CityName'   => $city['city_name'],
                    'CityNameEn' => $city['city_name_en'],
                ];

                $result['Cities'][] = $cityItem;
            }
        }

        $sqlReservationHotel = "
		SELECT
	reservation_hotel_tb.`id` AS hotel_id,
	reservation_hotel_tb.`name` AS hotel_name,
	reservation_hotel_tb.`name_en` AS hotel_name_en,
	reservation_hotel_tb.`city` AS city_id,
	reservation_hotel_tb.`priority` AS hotel_priority,
	reservation_hotel_tb.`discount`,
	'roomHotelLocal' AS page,
	'reservation' AS typeApp,
	reservation_city_tb.`name` AS city_name
FROM
	reservation_hotel_tb
	INNER JOIN reservation_city_tb ON reservation_hotel_tb.city = reservation_city_tb.id
    INNER JOIN reservation_hotel_room_prices_tb HR ON reservation_hotel_tb.id = HR.id_hotel
WHERE

    reservation_hotel_tb.`is_del` = 'no' AND
	reservation_hotel_tb.`name` LIKE '%{$name}%'
	OR reservation_hotel_tb.`name_en` LIKE '%{$name}%' AND
    reservation_hotel_tb.`country` != 1
    AND HR.flat_type = 'DBL'
    AND HR.is_del = 'no'
    AND HR.online_price > 0
    GROUP BY reservation_hotel_tb.`id`";
        $reservationHotels   = $Model->select( $sqlReservationHotel );

        $labelReservation = "no";

        if ( count( $reservationHotels ) > 0 ) {
            foreach ( $reservationHotels as $hotel ) {
                $i ++;
                //				$ReservationHotel = [];
                $hotelNameEn = trim( strtolower( $hotel['hotel_name_en'] ) );
                $hotelNameEn = str_replace( "  ", " ", $hotelNameEn );
                $hotelNameEn = str_replace( " ", "-", $hotelNameEn );

                $ReservationHotel = [
                    'HotelId'     => trim( $hotel['hotel_id'] ),
                    'HotelName'   => join(' ', [trim( $hotel['hotel_name'] ),trim( $hotel['city_name'] )]),
                    'HotelNameEn' => $hotelNameEn,
                    'CityName'    => trim( $hotel['city_name'] ),
                    'CityId'      => $hotel['city_id'],
                ];

                $result['ReservationHotels'][] = $ReservationHotel;
            }
        }
        /*get data from api */
        Load::library( 'ApiHotelCore' );
        $ApiHotelCore = new ApiHotelCore();
        $apiResult    = $ApiHotelCore->GetHotelsByName( $name );
        functions::insertLog(json_encode(['res'=>$apiResult]),'Hotels/GetHotelsByName');

        if ( is_array( $apiResult ) && count( $apiResult ) > 0 ) {
            foreach ( $apiResult as $hotel ) {
                $i ++;
                $hotelNameEn = strtolower( trim( urldecode( $hotel['NameEn'] ) ) );
                $hotelNameEn = str_replace( "  ", " ", $hotelNameEn );
                $hotelNameEn = str_replace( " ", "-", $hotelNameEn );
                $ApiHotel    = [
                    'HotelId'     => $hotel['Id'],
                    'HotelName'   => $hotel['Name'],
                    'HotelNameEn' => $hotelNameEn,
                    'CityName'    => $hotel['CityName'],
                    'CityId'      => $hotel['CityId'],
                ];

                $result['ApiHotels'][] = $ApiHotel;

            }
        }

        echo functions::clearJsonHiddenCharacters( json_encode( $result ) );
        exit();
    }



    public function popularLocalHotelCities($params ) {
        $params['limit'] = ($params['limit']) ? : 10;
        /** @var hotelCitiesModel $hotel_cities */
        $hotel_cities = Load::getModel('hotelCitiesModel');
        $cities = $hotel_cities->get(['id','city_name','city_name_en'])->orderBy('position','desc')->limit(0,$params['limit'])->all();
        return functions::withSuccess($cities,200,'popular local hotel cities list');

    }

    public function searchboxExternalHotels( $params ) {

        /** @var ModelBase $ModelBase */
        $city = trim( urldecode( $params['city'] ) );

        $request = [];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }

        $ModelBase = Load::library( 'ModelBase' );
        $city = functions::arabicToPersian($city);
        $city2 = $city;
        $pos = strpos($city, 'ا');
        if ($pos === 0) {
            $city2 = 'آ'. mb_substr($city,1);
        }

        $clientSql = "SELECT * FROM external_hotel_city_tb
                  WHERE
                    country_name_en != 'iran'
                    AND (
                    country_name_en LIKE '{$city}%'
                    OR country_name_fa LIKE '{$city}%'
                    OR country_name_fa LIKE '{$city2}%'
                    OR city_name_en LIKE '{$city}%'
                    OR city_name_fa LIKE '{$city}%'
                    OR city_name_fa LIKE '{$city2}%'
                    )
                    GROUP BY country_name_en,city_name_en
                    ";
        //		return json_encode($clientSql);


        return json_encode( $ModelBase->select( $clientSql ) );

    }



    public function searchboxReservationExternalHotels( $params ) {


        /** @var ModelBase $ModelBase */
        $name = trim( urldecode( $params['inputValue'] ) );


        if(!$name){
            $result['Cities'] = [];
            $result['ApiHotels'] = [];
            $result['ReservationHotels'] = [];

            echo functions::clearJsonHiddenCharacters( json_encode( $result ) );
            exit();
        }


        $ModelBase = Load::library( 'ModelBase' );
        $city = functions::arabicToPersian($name);
        $city2 = $city;
        $pos = strpos($city, 'ا');
        if ($pos === 0) {
            $city2 = 'آ'. mb_substr($city,1);
        }

        $clientSql = "SELECT * FROM external_hotel_city_tb
                  WHERE
                    country_name_en != 'iran'
                    AND (
                    country_name_en LIKE '{$city}%'
                    OR country_name_fa LIKE '{$city}%'
                    OR country_name_fa LIKE '{$city2}%'
                    OR city_name_en LIKE '{$city}%'
                    OR city_name_fa LIKE '{$city}%'
                    OR city_name_fa LIKE '{$city2}%'
                    )
                    GROUP BY country_name_en,city_name_en
                    ";

        $cities = $ModelBase->select( $clientSql ) ;

        if ( count( $cities ) > 0 ) {
            $result['Cities'] = [];
            foreach ( $cities as $city ) {

                $cityItem = [
                    'CityId'        => $city['id'],
                    'CityName'      => $city['city_name_fa'],
                    'CityNameEn'    => $city['city_name_en'],
                    'countryId'     => $city['country_id'],
                    'countryNameEn' => $city['country_name_en'],
                    'countryNameFa' => $city['country_name_fa'],
                ];

                $result['Cities'][] = $cityItem;
            }
        }


        $Model                = Load::library( 'Model' );

        $sqlReservationHotel = "
		SELECT
            reservation_hotel_tb.`id` AS hotel_id,
            reservation_hotel_tb.`name` AS hotel_name,
            reservation_hotel_tb.`name_en` AS hotel_name_en,
            reservation_hotel_tb.`city` AS city_id,
            reservation_hotel_tb.`priority` AS hotel_priority,
            reservation_hotel_tb.`discount`,
            'roomHotelLocal' AS page,
            'reservation' AS typeApp,
            reservation_city_tb.`name` AS city_name
        FROM
            reservation_hotel_tb
            INNER JOIN reservation_city_tb ON reservation_hotel_tb.city = reservation_city_tb.id
            INNER JOIN reservation_hotel_room_prices_tb HR ON reservation_hotel_tb.id = HR.id_hotel
        WHERE
            reservation_hotel_tb.`country` != '1' AND
            reservation_hotel_tb.`is_del` = 'no' AND
            reservation_hotel_tb.`name` LIKE '%{$name}%'
            OR reservation_hotel_tb.`name_en` LIKE '%{$name}%' 
            AND HR.flat_type = 'DBL'
            AND HR.is_del = 'no'
            AND HR.online_price > 0
        GROUP BY reservation_hotel_tb.`id`";

        $reservationHotels   = $Model->select( $sqlReservationHotel );

        $labelReservation = "no";

        if ( count( $reservationHotels ) > 0 ) {
            foreach ( $reservationHotels as $hotel ) {
                $i ++;
                //				$ReservationHotel = [];
                $hotelNameEn = trim( strtolower( $hotel['hotel_name_en'] ) );
                $hotelNameEn = str_replace( "  ", " ", $hotelNameEn );
                $hotelNameEn = str_replace( " ", "-", $hotelNameEn );

                $ReservationHotel = [
                    'HotelId'     => trim( $hotel['hotel_id'] ),
                    'HotelName'   => join(' ', [trim( $hotel['hotel_name'] ),trim( $hotel['city_name'] )]),
                    'HotelNameEn' => $hotelNameEn,
                    'CityName'    => trim( $hotel['city_name'] ),
                    'CityId'      => $hotel['city_id'],
                ];

                $result['ReservationHotels'][] = $ReservationHotel;
            }
        }

        echo functions::clearJsonHiddenCharacters( json_encode( $result ) );
        exit();

    }

    public function getVisaById( $params ) {
        $Model       = Load::library( 'Model' );
        $correctDate = date( 'Y-m-d H:i:s' );
        $query       = "SELECT visa.*,
                    visaType.title as visaTypeName,
                    country.name as countryName,
                    country.name_en as countryName_en,
                    (
                    SELECT
                        agency.name_fa
                    FROM
                        agency_tb AS agency
                        LEFT JOIN members_tb AS member ON member.fk_agency_id = agency.id
                    WHERE
                        member.id = visa.agency_id
                    ) AS agency_name_fa ,
                   (
                    SELECT
                        agency.phone
                    FROM
                        agency_tb AS agency
                        LEFT JOIN members_tb AS member ON member.fk_agency_id = agency.id
                    WHERE
                        member.id = visa.agency_id
                    ) AS agency_phone
                    

                    FROM visa_tb as visa
                    LEFT JOIN visa_type_tb as visaType ON visa.visaTypeID=visaType.id
                    LEFT JOIN reservation_country_tb as country ON visa.countryCode=country.abbreviation
                    LEFT JOIN visa_expiration_tb as Expiration ON Expiration.visa_id=visa.id

                    WHERE
                          CASE
		
                                WHEN visa.agency_id = '0' THEN
                                1 ELSE Expiration.expired_at
                            END >
                        CASE
                            WHEN visa.agency_id = '0' THEN
                                0 ELSE '{$correctDate}'
                            END
                            AND visa.isActive =
                            CASE WHEN visa.agency_id = '0' THEN visa.isActive  ELSE 'yes' END
                            
                          
                          AND visa.isDell = 'no'
                    AND visa.id = '{$params['id']}'
                    AND visa.validate = 'granted'
                    ORDER BY visa.id desc";

        $clientResult = $Model->select( $query );

        if ( ! empty( $clientResult ) ) {
            if ( $clientResult[0]['currencyType'] == 0 ) {
                $clientResult[0]['currencyData'] = [ 'id' => 0, "CurrencyTitle" => 'تومان' ];
            } else {
                $currency                        = Load::controller( 'currency' );
                $clientResult[0]['currencyData'] = $currency->ShowInfo( $clientResult[0]['currencyType'] );
            }
        }

        return json_encode( $clientResult, true );
    }

    public function getAllVisa( $params ) {
        $Model = Load::library( 'Model' );

        $correctDate = date( 'Y-m-d H:i:s' );
        $where       = '';
        $limit       = '';
        if ( isset( $params['limit'] ) ) {
            $limit = "LIMIT 0," . $params['limit'];
        }
        if ( isset( $params['country'] ) ) {
            if ( ! isset( $params['country']['operator'] ) ) {
                $params['country']['operator'] = '=';
            }
            $where = "AND visa.countryCode " . $params['country']['operator'] . " '" . $params['country']['value'] . "'";
        }
        $query = "SELECT visa.*,
                    visaType.title as visaTypeName,
                    country.name as countryName,
                    country.name_en as countryName_en ,
                    (
                    SELECT
                        agency.name_fa
                    FROM
                        agency_tb AS agency
                        LEFT JOIN members_tb AS member ON member.fk_agency_id = agency.id
                    WHERE
                        member.id = visa.agency_id
                    ) AS agency_name_fa

                    FROM visa_tb as visa
                    LEFT JOIN visa_type_tb as visaType ON visa.visaTypeID=visaType.id
                    LEFT JOIN reservation_country_tb as country ON visa.countryCode=country.abbreviation
                    LEFT JOIN visa_expiration_tb as Expiration ON Expiration.visa_id=visa.id


                    WHERE
                          CASE
		
                                WHEN visa.agency_id = '0' THEN
                                1 ELSE Expiration.expired_at
                            END >
                        CASE
                            WHEN visa.agency_id = '0' THEN
                                0 ELSE '{$correctDate}'
                            END
                            AND visa.isActive =
                            CASE WHEN visa.agency_id = '0' THEN visa.isActive  ELSE 'yes' END
                            
                          $where
                          AND visa.isDell = 'no'
                
                    AND visa.validate = 'granted'
                    ORDER BY visa.id desc
                    $limit";

        $clientResult = $Model->select( $query );
        $currency     = Load::controller( 'currency' );
        foreach ( $clientResult as $item ) {
            if ( $item['currencyType'] == 0 ) {
                $item['currencyData'] = [ 'id' => 0, "CurrencyTitle" => 'تومان' ];
            } else {
                $item['currencyData'] = $currency->ShowInfo( $item['currencyType'] );
            }
            $finalResult[] = $item;
        }

        return json_encode( $finalResult, true );
    }

    public function getVisaAgencyDetail( $params ) {
        $agency      = Load::controller( 'agency' );
        $agency_name = $agency->AgencyInfoByIdMember( $params['agency_id'] )['name_fa'];
        if ( empty( $agency_name ) ) {
            $agency_name = CLIENT_NAME;
        }

        return json_encode( $agency_name, true );
    }

    public function getVisaTypeMoreDetail( $params ) {


        $Model             = Load::library( 'Model' );
        $condition         = '';
        $countryController = Load::controller( 'country' );
        $countryID         = $countryController->getCountryByCode( $params['country_id'] )['countryID'];

        if ( isset( $countryID ) && $countryID != '' ) {
            $condition .= " AND country_id= '" . $countryID . "'";
        }
        if ( isset( $params['type_id'] ) && $params['type_id'] != '' ) {
            $condition .= " AND type_id= '" . $params['type_id'] . "'";
        }

        $query = "SELECT * FROM visa_type_more_detail_tb
                WHERE 1=1
                {$condition} ";

        $clientResult = $Model->load( $query );

        return json_encode( $clientResult, true );
    }

    public function packageRoutesSearchDeparture( $params ) {

        $result = [];
        /** @var ModelBase $ModelBase */
        $ModelBase = Load::library( 'ModelBase' );
        $departure = $params['search_input'];
        $sqlLocal  = "SELECT Departure_Code AS departure_code,
                       Departure_CityEn AS city_nameEn,
                       Departure_City AS city_nameFa,
                       '' AS airport_nameEn,
                       '' AS airport_nameFa,
                       'Iran' AS country_nameEn,
                       'ایران' AS country_nameFa,
                       'local' AS route_type
                    FROM flight_route_tb WHERE `local_portal` = '0' AND
                                               (
                                                   `Departure_Code` LIKE '%{$departure}%'
                                                    OR `Departure_CityEn` LIKE '%{$departure}%'
                                                    OR `Departure_City` LIKE '%{$departure}%'
                                                   )
                                                        GROUP BY Departure_Code";

        $sqlPortal = "SELECT DepartureCode AS departure_code,
                           DepartureCityEn AS city_nameEn,
                            DepartureCityFa AS city_nameFa,
                           AirportEn AS airport_nameEn,
                           AirportFa AS airport_nameFa,
                           CountryEn AS country_nameEn,
                           CountryFa AS country_nameFa,
                           'portal' AS route_type
                    FROM `flight_portal_tb` WHERE
                                                  `DepartureCode` LIKE '%{$departure}%'
                                               OR `DepartureCityEn` LIKE '%{$departure}%'
                                               OR `DepartureCityFa` LIKE '%{$departure}%'
                                               OR `AirportEn` LIKE '%{$departure}%'
                                               OR `AirportFa` LIKE '%{$departure}%'
                                               OR `CountryEn` LIKE '%{$departure}%'
                                               OR `CountryFa` LIKE '%{$departure}%'
                                            ORDER BY FIELD(DepartureCode,'{$departure}') DESC ";

        $resultLocal  = $ModelBase->select( $sqlLocal );
        $resultPortal = $ModelBase->select( $sqlPortal );
        foreach ( $resultLocal as $resultItem ) {
            $result[] = $resultItem;
        }
        foreach ( $resultPortal as $resultItem ) {
            $result[] = $resultItem;
        }
        if ( count( $result ) > 0 ) {
            return json_encode( [ 'success' => true, 'result' => $result ], 256 );
        }

        return json_encode( [ 'success' => false, 'result' => $result ], 256 );
    }

    public function packageRoutesSearchArrival( $params ) {
        $departureCode = $params['departure_code'];
        $arrival       = $params['search_input'];
        $routeType     = $params['route_type'];

        if ( $routeType == 'local' ) {
            $sql = "SELECT Arrival_Code AS arrival_code,
                   Arrival_CityEn AS city_nameEn,
                   Arrival_City AS city_nameFa,
                   '' AS airport_nameEn,
                   '' AS airport_nameFa,
                   'Iran' AS country_nameEn,
                   'ایران' AS country_nameFa,
                   'local' AS route_type
            FROM flight_route_tb WHERE
                           `local_portal` = '0' AND Departure_Code = '{$departureCode}' AND(
                               Arrival_Code LIKE '%{$arrival}%'
                                   OR Arrival_CityEn LIKE '%{$arrival}%'
                                   OR Arrival_City LIKE '%{$arrival}%'
                               )";
        } elseif ( $routeType == 'portal' ) {
            $sql = "SELECT DepartureCode AS arrival_code,
       DepartureCityEn AS city_nameEn,
       DepartureCityFa AS city_nameFa,
       AirportEn AS airport_nameEn,
       AirportFa AS airport_nameFa,
       CountryEn AS country_nameEn,
       CountryFa AS country_nameFa,
       'portal' AS route_type
       
FROM `flight_portal_tb` WHERE `DepartureCode` LIKE '%{$arrival}%'
                           OR `DepartureCityEn` LIKE '%{$arrival}%'
                           OR `DepartureCityFa` LIKE '%{$arrival}%'
                           OR `AirportEn` LIKE '%{$arrival}%'
                           OR `AirportFa` LIKE '%{$arrival}%'
                           OR `CountryEn` LIKE '%{$arrival}%'
                           OR `CountryFa` LIKE '%{$arrival}%'
ORDER BY FIELD(DepartureCode,'{$arrival}'
    ) DESC ";
        } else {
            return json_encode( [ 'success' => false, 'result' => [] ] );
        }
        /** @var ModelBase $ModelBase */
        $ModelBase = Load::library( 'ModelBase' );
        $result    = $ModelBase->select( $sql );
        if ( $result ) {
            return json_encode( [ 'success' => true, 'result' => $result ] );
        }

        return json_encode( [ 'success' => false, 'result' => $result ] );

    }

    public function flightRoutesSearchDeparture( $params ) {
        $result = [];
        /** @var ModelBase $ModelBase */
        $departure = $params['search_input'];
        /** @var flightRouteModel $local_route */
        $local_route  = Load::getModel('flightRouteModel');
        /** @var flightPortalModel $portal_route */
        $portal_route  = Load::getModel('flightPortalModel');
        $local_fields  = array(
            "Departure_Code AS departure_code",
            "Departure_CityEn AS city_nameEn",
            "Departure_City AS city_nameFa",
            "Departure_CityAr AS city_nameAr",
            "'' AS airport_nameEn",
            "'' AS airport_nameFa",
            "'' AS airport_nameAr",
            "'Iran' AS country_nameEn",
            "'ایران' AS country_nameAr",
            "'ایران' AS country_nameFa",
            "'local' AS route_type"
        );

        $portal_fields = array(
            "DepartureCode AS departure_code",
            "DepartureCityEn AS city_nameEn",
            "DepartureCityFa AS city_nameFa",
            "DepartureCityAr AS city_nameAr",
            "AirportEn AS airport_nameEn",
            "AirportFa AS airport_nameFa",
            "AirportAr AS airport_nameAr",
            "CountryEn AS country_nameEn",
            "CountryFa AS country_nameFa",
            "CountryAr AS country_nameAr",
            "'portal' AS route_type",
            "DepartureCityAr AS city_nameAr",
            "AirportAr AS airport_nameAr",
        );

        $result_local = $local_route
            ->get($local_fields)
            ->where('local_portal',0)
            ->openParentheses()
            ->like('Departure_Code',$departure)
            ->like('Departure_CityEn',$departure)
            ->like('Departure_City',$departure);
        if(isset($params['lang']) && $params['lang'] == 'ar' || SOFTWARE_LANG == 'ar'){
            $result_local = $result_local->like('Departure_CityAr',$departure);
        }
        $result_local = $result_local->closeParentheses()
            ->groupBy('Departure_Code')->all();

        $result_portal = $portal_route
            ->get($portal_fields)
            ->like('DepartureCode',$departure)
            ->like('DepartureCityEn',$departure)
            ->like('DepartureCityFa',$departure)
            ->like('AirportEn',$departure)
            ->like('AirportFa',$departure)
            ->like('CountryEn',$departure)
            ->like('CountryFa',$departure);
        if(isset($params['lang']) && $params['lang'] == 'ar' || SOFTWARE_LANG == 'ar'){
            $result_portal = $result_portal->like('DepartureCityAr',$departure);
        }
        $result_portal = $result_portal->orderBy("FIELD(DepartureCode,'{$departure}')")->all();
        foreach ( $result_local as $resultItem ) {
            $result[] = $resultItem;
        }
        foreach ( $result_portal as $resultItem ) {
            $result[] = $resultItem;
        }
        if ( count( $result ) > 0 ) {
            return json_encode( [ 'success' => true, 'result' => $result ], 256 );
        }

        return json_encode( [ 'success' => false, 'result' => $result ], 256 );
    }

    public function flightRoutesSearchArrival( $params ) {
        $departureCode = $params['departure_code'];
        $arrival       = $params['search_input'];
        $routeType     = $params['route_type'];
        $result = array();
        if ( $routeType == 'local' ) {
            /** @var flightRouteModel $local_route */
            $local_route = Load::getModel('flightRouteModel');

            $local_fields = array(
                "Arrival_Code AS arrival_code",
                "Arrival_CityEn AS city_nameEn",
                "Arrival_CityAr AS city_nameAr",
                "Arrival_City AS city_nameFa",
                "'' AS airport_nameEn",
                "'' AS airport_nameFa",
                "'' AS airport_nameAr",
                "'Iran' AS country_nameEn",
                "'ایران' AS country_nameFa",
                "'ایران' AS country_nameAr",
                "'local' AS route_type"
            );

            $result = $local_route->get($local_fields)
                ->where('local_portal',0)
                ->where('Departure_Code',$departureCode)
                ->openParentheses()
                ->like('Arrival_Code',$arrival)
                ->like('Arrival_CityEn',$arrival)
                ->like('Arrival_City',$arrival);
            if(isset($params['lang']) && $params['lang'] == 'ar' || SOFTWARE_LANG == 'ar'){
                $result = $result->like('Arrival_CityAr',$arrival);
            }
            $result = $result->closeParentheses()
                ->all();

        } elseif ( $routeType == 'portal' ) {
            $portal_fields = array(
                "DepartureCode AS arrival_code",
                "DepartureCityEn AS city_nameEn",
                "DepartureCityFa AS city_nameFa",
                "DepartureCityAr AS city_nameAr",
                "AirportEn AS airport_nameEn",
                "AirportAr AS airport_nameAr",
                "AirportFa AS airport_nameFa",
                "CountryEn AS country_nameEn",
                "CountryFa AS country_nameFa",
                "CountryAr AS country_nameAr",
                "'portal' AS route_type"
            );

            /** @var flightPortalModel $portal_route */
            $portal_route = Load::getModel('flightPortalModel');
            $result = $portal_route->get($portal_fields)
                ->like('DepartureCode',$arrival)
                ->like('DepartureCityEn',$arrival)
                ->like('DepartureCityFa',$arrival)
                ->like('AirportEn',$arrival)
                ->like('AirportFa',$arrival)
                ->like('CountryEn',$arrival)
                ->like('CountryFa',$arrival);
            if(isset($params['lang']) && $params['lang'] == 'ar' || SOFTWARE_LANG == 'ar'){
                $result = $result
                    ->like('AirportAr',$arrival)
                    ->like('DepartureCityAr',$arrival)
                    ->like('CountryAr',$arrival);
            }

            $result = $result->orderBy("FIELD(DepartureCode,'{$arrival}')")->all();

        } else {
            return json_encode( [ 'success' => false, 'result' => [] ] );
        }
        //		/** @var ModelBase $ModelBase */
        //		$ModelBase = Load::library( 'ModelBase' );
        //		$result    = $ModelBase->select( $sql );

        if ( $result ) {
            return json_encode( [ 'success' => true, 'result' => $result ] );
        }

        return json_encode( [ 'success' => false, 'result' => $result ] );

    }

    public function flightInternalRoutesDep( $params ) {

        /** @var ModelBase $ModelBase */


        $request = [];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $filter_condition='';
        if ( isset( $request['filter'] ) && $request['filter'] != '' ) {
            $filter_condition="AND Departure_Code= '".$request['filter']."' ";
        }

        if ( isset( $request['self_Db'] ) && $request['self_Db'] == true ) {

            $ModelBase = Load::library( 'ModelBase' );
            $clientSql = " SELECT DISTINCTROW Departure_Code, Departure_City, Departure_CityEn FROM flight_route_tb WHERE local_portal ='0' ".$filter_condition."
                        GROUP BY Departure_Code";

            return json_encode( $ModelBase->select( $clientSql ) );
        } else {

            $ModelBase = Load::library( 'Model' );
            $clientSql = "SELECT DISTINCTROW Departure_Code, Departure_City, Departure_CityEn FROM flight_route_tb WHERE Local_portal ='0' ".$filter_condition." GROUP BY  Departure_Code ORDER BY priorityDeparture=0, priorityDeparture ASC";

            return json_encode( $ModelBase->select( $clientSql ) );
        }


    }

    public function flightInternalRoutesRandom( $params ) {

        /** @var ModelBase $ModelBase */


        $request = [];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }

        if ( isset( $request['self_Db'] ) && $request['self_Db'] != true ) {

            $ModelBase = Load::library( 'ModelBase' );
            $clientSql = "SELECT DISTINCTROW Departure_Code, Departure_City, Departure_CityEn FROM flight_route_tb WHERE Local_portal ='0'  GROUP BY  Departure_Code ORDER BY priorityDeparture=0, priorityDeparture ASC";

            return json_encode( $ModelBase->select( $clientSql ) );
        } else {

            $ModelBase = Load::library( 'Model' );
            $clientSql = "SELECT DISTINCTROW Departure_Code, Departure_City, Departure_CityEn FROM flight_route_tb WHERE Local_portal ='0'  GROUP BY  Departure_Code ORDER BY priorityDeparture=0, priorityDeparture ASC";

            return json_encode( $ModelBase->select( $clientSql ) );
        }


    }

    public function flightInternalRoutesArrival( $params ) {


        /** @var ModelBase $ModelBase */

        $request = [];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }
        if ( isset( $request['self_Db'] ) && $request['self_Db'] == true ) {

            $ModelBase = Load::library( 'ModelBase' );
            $clientSql = "SELECT Arrival_Code,Arrival_City,Arrival_CityEn FROM flight_route_tb WHERE Departure_Code='{$request['filter']}'
                                AND Local_Portal='0'
                                ORDER BY priorityArrival=0,priorityArrival ASC";

            return json_encode( $ModelBase->select( $clientSql ) );
        } else {

            $ModelBase = Load::library( 'Model' );
            $clientSql = "SELECT Arrival_Code,Arrival_City,Arrival_CityEn FROM flight_route_tb WHERE Departure_Code='{$request['filter']}'
                                AND Local_Portal='0'
                                ORDER BY priorityArrival=0,priorityArrival ASC";

            return json_encode( $ModelBase->select( $clientSql ) );
        }


    }

    public function flightExternalRoutes( $params ) {

        /** @var ModelBase $ModelBase */

        $request = [];
        $filter  = $params['filter'];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }

        if ( isset( $request['self_Db'] ) && $request['self_Db'] != true ) {

            $ModelBase = Load::library( 'ModelBase' );
            $clientSql = "SELECT *  FROM flight_portal_tb WHERE DepartureCode='{$filter}'
                                   OR CountryEn Like '%{$filter}%'
                                   OR DepartureCityEn Like '%{$filter}%'
                                   OR AirportFa Like '%{$filter}%'
                                   OR AirportEn Like '%{$filter}%'
                                   OR CountryFa Like '%{$filter}%'
                                   OR DepartureCityFa Like '%{$filter}%'
                                    ORDER BY FIELD(DepartureCode,'{$filter}') DESC ";

            return json_encode( $ModelBase->select( $clientSql ) );
        } else {

            $ModelBase = Load::library( 'Model' );
            $clientSql = "SELECT *  FROM flight_portal_tb WHERE DepartureCode='{$filter}'
                                   OR CountryEn Like '%{$filter}%'
                                   OR DepartureCityEn Like '%{$filter}%'
                                   OR AirportFa Like '%{$filter}%'
                                   OR AirportEn Like '%{$filter}%'
                                   OR CountryFa Like '%{$filter}%'
                                   OR DepartureCityFa Like '%{$filter}%'
                                    ORDER BY FIELD(DepartureCode,'{$filter}') DESC ";

            return json_encode( $ModelBase->select( $clientSql ) );
        }


    }

    public function flightExternalRoutesDefault( $params ) {

        /** @var ModelBase $ModelBase */

        $request = [];

        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }

        if ( isset( $request['self_Db'] ) && $request['self_Db'] != true ) {

            $ModelBase = Load::library( 'ModelBase' );
            $clientSql = "SELECT DepartureCode,DepartureCityEn,DepartureCityFa,AirportFa,AirportEn,CountryFa,CountryEn  FROM flight_portal_tb";

            return json_encode( $ModelBase->select( $clientSql ) );
        } else {

            $Model = Load::library( 'Model' );
            $clientSql = "SELECT DepartureCode,DepartureCityEn,DepartureCityFa,AirportFa,AirportEn,CountryFa,CountryEn  FROM flight_portal_tb";

            return json_encode( $Model->select( $clientSql ) );
        }


    }

    public function tourReservationFullyData( $params ) {


        /** @var ModelBase $ModelBase */
        $conditionType    = "";
        $conditionSpecial = "";
        $conditionCountry = "";
        $leftJoinCountry  = "";
        $innerJoinType = "" ;
        $multiple_tour = 2 ;
        $one_day_tour = 1 ;
        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $type    = $request['type'];
        $country = $request['country'];
        $date    = $request['dateNow'];
        $limit   = $request['limit'];
        if ( ! empty( $type ) && is_numeric( $type ) ) {
            $innerJoinType = "INNER JOIN reservation_tour_tourType_tb AS tourType ON tour.id_same=tourType.fk_tour_id_same ";
            $conditionType = " AND tourType.fk_tour_type_id = '{$type}' ";
        } elseif ( ! empty( $type ) && $type == 'discount' ) {
            $conditionType = " AND tour.discount > 0 ";
        } elseif ( ! empty( $type ) && $type == 'special' ) {

            $conditionSpecial = " AND tour.is_special = 'yes' ";
        } elseif ( ! empty( $type ) && $type == '!special' ) {
            $conditionSpecial = " AND tour.is_special = '' ";
        }

        if ( ! empty( $country ) ) {
            if ( $country == 'internal' ) {
                $country = '=1';
            } elseif ( $country == 'external' ) {
                $country = '!=1';
            }else {
                $country = "={$country}";
            }
            $conditionCountry = "AND tourRout.destination_country_id  $country  AND tourRout.tour_title = 'dept' ";
        }
        if (isset($request['type_id']) && !empty($request['type_id'])) {
            $type_id_kind = 'like';
            if ( isset($request['type_id_kind']) && !empty($request['type_id_kind']) && $request['type_id_kind'] == 'not_like') {
                $type_id_kind = 'not like';
            }
            $conditionCategory = "   AND tour.tour_type_id {$type_id_kind} '%" . '"' . $request['type_id'] . '"' . "%' ";
        }


        $Model     = Load::library( 'Model' );
        $clientSql = "SELECT tour.id,
                               (SELECT sum( Rate.VALUE )  / count( * )
                                  FROM master_rate_tb as Rate
                               WHERE Rate.section = 'reservation_tour_tb' AND item_id=tour.id_same ) as rate_average,
                                tour.id_same,
                                tour.tour_name_en,
                                tour.tour_name,
                                tour.night,
                                tour.start_date,
                                tour.tour_pic,
                                tour.tour_type_id,
                                tour.is_special,
                                tour.change_price,
                                package.currency_type,
                                tour.change_price,
                                tour.adult_price_one_day_tour_r,
                                tour.adult_price_one_day_tour_a,
                                tour.currency_type_one_day_tour ,
                                tourRout.airline_name ,
                                tourRout.type_vehicle_name ,
                                tourRout.type_vehicle_id ,
                                tourRout.airline_name 
            FROM reservation_tour_tb AS tour
              INNER JOIN reservation_tour_rout_tb AS tourRout ON tourRout.fk_tour_id = tour.id
            INNER JOIN reservation_city_tb AS City ON City.id = tourRout.destination_city_id
            LEFT JOIN reservation_tour_package_tb AS package ON tour.id = package.fk_tour_id
          ";

        $clientSql .= ( $leftJoinCountry != "" ) ? $leftJoinCountry : '';
        $clientSql .= ( $innerJoinType != "" ) ? $innerJoinType : '';

        $clientSql .= " WHERE tour.is_del = 'no' AND tour.is_show = 'yes' AND (tour.tour_type_id LIKE '%" . '"' . $one_day_tour . '"' . "%' OR (tour.tour_type_id LIKE '%" . '"' . $multiple_tour . '"' . "%' AND package.is_del = 'no'))  AND tour. language != 'en'  AND tour.start_date > '{$date}'
             {$conditionType}
             {$conditionSpecial}
             {$conditionCountry}
             {$conditionCategory}
           AND (tourRout.is_route_fake = '1' OR tourRout.is_route_fake IS NULL) 
           GROUP BY tour.id_same  ORDER BY tour.priority=0 {$limit} ";



        $tours=$Model->select( $clientSql );
        $resultTourLocal=$this->getController('resultTourLocal');
        foreach ($tours as $key=>$tour) {
            $result[$key]=$tour;
            $arrayTourType = json_decode( $tour['tour_type_id'] );
            if ( in_array( '1', $arrayTourType ) ) {
                $oneDayTour = 'yes';
            } else {
                $oneDayTour = 'no';
            }
            $minPrice = $resultTourLocal->minPriceHotelByIdTourR( $tour['id'], $oneDayTour );

            $result[$key]['min_price_r'] = $minPrice['minPriceR'];
            $result[$key]['min_price_a'] = $minPrice['minPriceA'];
        }
        return json_encode($result);

    }

    public function tourReservationEnFullyData( $params ) {

        $reservation_tour = Load::controller( 'reservationTour' );
        $master_rate = Load::controller( 'masterRate' );
        $commentController = Load::controller( 'comments' );
        /** @var ModelBase $ModelBase */
        $conditionType    = "";
        $conditionSpecial = "";
        $conditionCountry = "";
        $leftJoinCountry  = "";
        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $type    = $request['type'];
        $country = $request['country'];
        $date    = $request['dateNow'];
        $limit   = $request['limit'];

        if ( ! empty( $type ) && is_numeric( $type ) ) {
            $conditionType = " AND tourType.fk_tour_type_id = '{$type}' ";
        } elseif ( ! empty( $type ) && $type == 'discount' ) {
            $conditionType = " AND tour.discount > 0 ";
        } elseif ( ! empty( $type ) && $type == 'special' ) {
            $conditionSpecial = " AND tour.is_special = 'yes' ";
        }
        if ( ! empty( $country ) ) {
            if ( $country == 'internal' ) {
                $country = '=1';
            } elseif ( $country == 'external' ) {
                $country = '!=1';
            }
            $conditionCountry = "AND tourRout.destination_country_id" . $country . " ";
            $leftJoinCountry  = "INNER JOIN safar360_iran_tech.reservation_tour_rout_tb AS tourRout ON tourRout.fk_tour_id = tour.id";
        }

        $Model     = Load::library( 'Model' );
        $clientSql = "SELECT tour.id,tour.id_same,tour.tour_name_en,tour.tour_name,tour.night,tour.start_date,tour.tour_pic,tour.tour_type_id,tour.is_special
          FROM reservation_tour_tb AS tour";

        $clientSql .= ( $leftJoinCountry != "" ) ? $leftJoinCountry : '';

        $clientSql .= " WHERE tour.is_del = 'no' AND tour.is_show = 'yes' AND tour. language = 'en'  AND tour.start_date > '{$date}'
             {$conditionType}
             {$conditionSpecial}
             {$conditionCountry}
           GROUP BY tour.id_same  ORDER BY tour.priority=0,tour.priority {$limit} ";
        $result = $Model->select( $clientSql ) ;
        $counter =  0 ;
        foreach ($result as $tour) {
            $data = $reservation_tour->getTourRouteData($tour['id']);
            $last_route = end($data['destinations']) ;
            $rate = $master_rate->getRateAverage($tour['id_same'] , 'tour');
            $comment = $commentController->getComments($tour['id_same'] , 'tour');

            $result[$counter]['rate_average'] = $rate['average'];
            $result[$counter]['comments'] = count($comment);
            $result[$counter]['type_vehicle_id'] = $last_route['type_vehicle_id'];
            $result[$counter]['type_vehicle_name'] = $last_route['type_vehicle_name'];


            $counter++;

        }

        return json_encode( $result );

    }

    public function infoTourRoutEn( $params ) {
        /** @var ModelBase $ModelBase */
        $conditionType    = "";
        $conditionSpecial = "";
        $conditionCountry = "";
        $leftJoinCountry  = "";
        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $type      = $request['type'];
        $date      = $request['dateNow'];
        $Model     = Load::library( 'Model' );
        $clientSql = " SELECT DISTINCT(Rout.destination_country_id),country.* FROM reservation_tour_rout_tb AS Rout
                    INNER JOIN reservation_tour_tb AS Tour ON Tour.id = Rout.fk_tour_id
                    INNER JOIN reservation_country_tb AS country ON country.id = Rout.destination_country_id
                    WHERE
                 Rout.is_del = 'no'
              AND Tour.is_del = 'no'
              AND Tour.is_show = 'yes'
              AND Tour.language = 'en'
              AND Tour.start_date > '{$date}' LIMIT 8";

        return json_encode( $Model->select( $clientSql ) );

    }

    public function infoTourRoutByCityEn( $params ) {
        /** @var ModelBase $ModelBase */

        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $CityId = $request['cityid'];
        $date   = $request['dateNow'];
        $limit  = $request['limit'];
        if ( ! empty( $limit ) ) {
            $limit = 'LIMIT ' . $limit;
        } else {
            $limit = '';
        }
        $Model     = Load::library( 'Model' );
        $clientSql = " SELECT ( T.id_same ),T.id AS Tid,T.tour_type_id,T.change_price,T.night,T.tour_pic,T.tour_name,T.tour_name_en
                    FROM reservation_tour_tb AS T
                    INNER JOIN reservation_tour_rout_tb AS TR ON TR.destination_city_id = '" . $CityId . "'
                    WHERE
                    T.is_del = 'no'
                    AND T.is_show = 'yes'
                    AND TR.fk_tour_id = T.id
                    AND TR.tour_title = 'dept'
                    AND T.language = 'en'
                    AND T.start_date > '{$date}'
                    GROUP BY T.id_same
                    ORDER BY T.priority=0,T.priority
                    " . $limit . "
                    ";

        return json_encode( $Model->select( $clientSql ) );

    }

    public function infoTourRoutCityEn( $params ) {
        /** @var ModelBase $ModelBase */

        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $CityId = $request['cityid'];
        $date   = $request['dateNow'];
        $limit  = $request['limit'];
        if ( ! empty( $limit ) ) {
            $limit = 'LIMIT ' . $limit;
        } else {
            $limit = '';
        }
        $Model     = Load::library( 'Model' );
        $clientSql = " SELECT C.id,C.id_country,T.id as Tid, C.name, C.name_en ,T.change_price,T.night,T.tour_pic
                    FROM reservation_city_tb AS C
                    INNER JOIN reservation_tour_rout_tb AS TR ON C.id=TR.destination_city_id
                    INNER JOIN reservation_tour_tb AS T ON TR.fk_tour_id=T.id
            
                    WHERE
                
                    
                    C.id in (16,32,6,2)
                    AND T.is_del = 'no'
                    AND TR.fk_tour_id = T.id
                    AND TR.tour_title = 'dept'
                    AND T.language = 'en'
                    AND T.start_date >= '{$date}'
                    
                    
                  GROUP BY C.NAME ORDER BY C.id Limit 0,4";

        return json_encode( $Model->select( $clientSql ) );
    }

    public function infoReservationHotelCitiesEn( $params ) {
        /** @var ModelBase $ModelBase */
        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $countryId = $request['countryid'];
        $date      = $request['dateNow'];
        $limit     = $request['limit'];
        if ( ! empty( $countryId ) ) {
            $countryId = "RC.id_country='" . $countryId . "' AND";
        }
        $Model     = Load::library( 'Model' );
        $clientSql = " SELECT
                    DISTINCT (RC.id),
                    RC.name_en AS name_city_en,
                    RC.name AS name_city
                    FROM reservation_hotel_room_prices_tb AS RP
                    INNER JOIN reservation_hotel_tb as H ON RP.id_hotel=H.id
                    LEFT JOIN reservation_city_tb AS RC ON H.city=RC.id
                    WHERE
                    {$countryId}
                    RP.user_type='5' AND
                    RP.flat_type='DBL' AND
                    RP.is_del='no'
                  GROUP BY H.id ORDER BY
                    H.star_code  DESC, H.name ASC, H.discount DESC LIMIT 0,4";

        return json_encode( $Model->select( $clientSql ) );
    }

    public function infoReservationHotelByCityEn( $params ) {
        /** @var ModelBase $ModelBase */

        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $CityId = $request['cityid'];
        $date   = $request['dateNow'];
        $type   = $request['type'];

        $Model     = Load::library( 'Model' );
        $clientSql = " SELECT H.name,
                    H.name_en,
                    H.discount,
                    H.star_code,
                    H.id,
                    H.logo,
                    H.address,
                    H.city,
                    RC.name AS name_city,
                    RC.name_en AS name_city_en
                    FROM reservation_hotel_room_prices_tb AS RP
                    INNER JOIN reservation_hotel_tb as H ON RP.id_hotel=H.id
                    LEFT JOIN reservation_city_tb AS RC ON H.city=RC.id
                    WHERE
                    RC.id='" . $CityId . "' AND
                    RP.user_type='5' AND
                    RP.flat_type='DBL' AND
                    RP.is_del='no'
                  GROUP BY H.id ORDER BY
                    H.star_code  DESC, H.name ASC, H.discount  DESC";

        return json_encode( $Model->select( $clientSql ) );

    }

    public function ReservationHotelCities( $params ) {
        /** @var ModelBase $ModelBase */
        $request = [];
        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }

        $countryCondition = '';
        if ( $request['CountryId'] != null ) {
            $countryCondition = "AND H.country = {$request['CountryId']}";
        }
        $QueryLimit = '';
        if ( $request['Limit'] != null ) {
            $QueryLimit = " LIMIT {$request['Limit']}";
        }

        $threeDaysAgo = time() + ( 1 * 24 * 60 * 60 );
        $date         = dateTimeSetting::jdate( "Ymd", "", "", "", "en" );
        $Enddate      = dateTimeSetting::jdate( "Ymd", $threeDaysAgo, "", "", "en" );


        $sql = "SELECT DISTINCT ( RC.NAME ), RC.id AS City_id, RC.pic,
( SELECT MIN( HHR.online_price ) FROM reservation_hotel_tb HH INNER JOIN reservation_hotel_room_prices_tb HHR ON HH.id = HHR.id_hotel WHERE
            HHR.user_type = '5'
            AND HH.city = City_id
            AND HHR.date = '{$date}'
            AND HHR.flat_type = 'DBL'
            AND HHR.is_del = 'no'
            ) AS minPrice
        FROM
            reservation_city_tb AS RC
            INNER JOIN reservation_hotel_tb AS H ON H.city = RC.id
            LEFT JOIN reservation_hotel_room_prices_tb AS RP ON RP.id_hotel = H.id
        WHERE
            RP.user_type = '5'
          
            AND RP.flat_type = 'DBL'
            AND RP.date = '{$date}'
            AND RP.is_del = 'no'
            AND H.is_del = 'no'
            {$countryCondition}
        GROUP BY
            H.id
        ORDER BY
            H.priority=0,H.priority ASC,
            H.star_code DESC,
            H.NAME ASC,
            H.discount DESC
            {$QueryLimit} ";

        $Model  = Load::library( 'Model' );
        $result = $Model->select( $sql );
        $i      = 0;
        $return = [];
        foreach ( $result as $key => $value ) {
            $return[ $key ]['id']       = $value['City_id'];
            $return[ $key ]['hotel_id'] = $value['hotel_id'];
            $return[ $key ]['minPrice'] = $value['minPrice'];
            $return[ $key ]['name']     = $value['NAME'];
            $return[ $key ]['pic']      = $value['pic'];
        }

        return json_encode( $return, 256 );
    }

    public function ReservationHotelCountries( $params ) {
        /** @var Model $Model */
        $Model = Load::library( 'Model' );
        $date  = dateTimeSetting::jdate( "Ymd", "", "", "", "en" );
        if ( $params['Country'] != null && $params['CountryOperation'] != null) {
            $countryCondition = "AND RC.id {$params['CountryOperation']} {$params['Country']}";
        }

        $sql = "SELECT DISTINCT
                ( RC.id ),
                RC.name AS name_country,
                RC.id
                FROM
                    reservation_country_tb AS RC
                    INNER JOIN reservation_hotel_tb AS RH ON RC.id = RH.country
                    LEFT JOIN reservation_hotel_room_prices_tb AS RP ON RP.id_hotel = RH.id
                WHERE
                RH.is_del = 'no'
                AND RP.user_type = '5'
                AND RP.flat_type = 'DBL'
                AND RP.date = '{$date}'
                AND RP.is_del = 'no'
                {$countryCondition}
                  GROUP BY
            RH.id
        ORDER BY
            RH.priority=0,RH.priority ASC,
            RH.star_code DESC,
            RH.NAME ASC,
            RH.discount DESC
            ";

        $result = $Model->select( $sql );
        $return = [];
        foreach ( $result as $key => $item ) {
            $return[ $key ]['name']       = $item['name_country'];
            $return[ $key ]['id_country'] = $item['id'];
        }

        return json_encode( $return, 256 );
    }


    public function infoMinPriceTour( $params ) {
        /** @var ModelBase $ModelBase */

        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $oneDayTour = $request['onedaytour'];
        $date       = $request['dateNow'];
        $id         = $request['id'];

        $Model = Load::library( 'Model' );
        if ( $oneDayTour == 'yes' ) {
            $clientSql = "
            SELECT
                change_price, adult_price_one_day_tour_r, adult_price_one_day_tour_a, currency_type_one_day_tour
            FROM
                reservation_tour_tb
            WHERE
                id = '{$id}'
            ";
            $Result =$Model->select( $clientSql );
            $Data = [];
            foreach ($Result as  $value){
                $Data['minPriceR'] = $value['adult_price_one_day_tour_r'] + $value['change_price'];
                $Data['minPriceA'] = 0;
                $Data['CurrencyTitleFa'] = '';
                $Data[]=$value;
            }
            return json_encode($Data);
        }else{
            $clientSql = "SELECT
                T.change_price, min( P.double_room_price_r ) as min_price_r,  min( P.double_room_price_a ) as min_price_a, P.currency_type
            FROM
                reservation_tour_tb AS T
                LEFT JOIN reservation_tour_package_tb AS P ON T.id = P.fk_tour_id
            WHERE
                T.id = '{$id}'
            ";
            $Result    = $Model->select( $clientSql );
            $Data      = [];
            foreach ( $Result as $value ) {
                $Data['minPriceR']       = $value['min_price_r'] + $value['change_price'];
                $Data['minPriceA']       = $value['min_price_a'];
                $Data['CurrencyTitleFa'] = $value['currency_type'];

            }

            return json_encode( $Data );
        }


    }

    public function infoMinPriceHotel( $params ) {
        /** @var ModelBase $ModelBase */

        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $date    = $request['dateNow'];
        $idHotel = $request['idhotel'];

        $Model = Load::library( 'Model' );

        $clientSql = "SELECT
          RP.online_price
        FROM
            reservation_hotel_room_prices_tb as RP
            INNER JOIN reservation_hotel_tb as H ON RP.id_hotel=H.id
        WHERE
            RP.user_type='5' AND
            RP.date='{$date}' AND
            RP.flat_type='DBL' AND
            H.id='{$idHotel}' AND
            RP.is_del='no'
        ";
        $Result    = $Model->select( $clientSql );
        $Data      = [];
        $i         = 0;
        foreach ( $Result as $value ) {
            if ( $i == 0 ) {
                $min = $value['online_price'];
            }
            if ( $value['online_price'] <= $min ) {
                $min = $value['online_price'];
            }

            $i ++;
        }

        return json_encode( $min );

    }

    public function infoGetCitiesTour( $params ) {
        /** @var ModelBase $ModelBase */

        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $idTour = $request['idtour'];
        $type   = $request['type'];

        $Model     = Load::library( 'Model' );
        $clientSql = " SELECT destination_city_name
                 FROM reservation_tour_rout_tb
                 WHERE fk_tour_id = '{$idTour}' AND is_del = 'no' AND tour_title='dept' AND night > 0
             ORDER BY id";

        return json_encode( $Model->select( $clientSql ) );


    }

    public function hotelReservationFullyData( $params ) {
        /** @var ModelBase $ModelBase */
        $limit             = "";
        $conditionSpecial  = "";
        $conditionDiscount = "";
        $conditionCountry  = "";
        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $special  = $request['special'];
        $discount = $request['discount'];
        $date     = $request['dateNow'];
        $limit    = $request['limit'];
        $country  = $request['country'];
        if ( isset( $limit ) && $limit != "" ) {
            $LIMIT = " LIMIT " . $limit . " ";
        }
        if ( isset( $special ) && $special != "" ) {
            $conditionSpecial = " and H.flag_special='yes' ";
        }
        if ( isset( $special ) && $special == false ) {
            $conditionSpecial = " and H.flag_special !='yes' ";
        }
        if ( isset( $discount ) && $discount != "" ) {
            $conditionDiscount = " and H.flag_discount ='yes' ";
        }
        if ( ! empty( $country ) ) {
            if ( $country == 'internal' ) {
                $country = '=1';
            } elseif ( $country == 'external' ) {
                $country = '!=1';
            }
            $conditionCountry = " AND H.country " . $country . " ";
        }
        $price_date_today = dateTimeSetting::jtoday('');
        $Model     = Load::library( 'Model' );
        $clientSql = "SELECT
                    H.name,
                    H.name_en,
                    H.discount,
                    H.star_code,
                    H.id,
                    H.logo,
                    H.address,
                    H.city,
                    RC.name AS name_city,
                    RC.name_en AS name_city_en
            FROM
                    reservation_hotel_room_prices_tb AS RP
                    INNER JOIN reservation_hotel_tb AS H ON RP.id_hotel=H.id
                    LEFT JOIN
                reservation_city_tb AS RC
                ON
               H.city=RC.id
            WHERE
                    RP.user_type='5' AND
                    H.is_del = 'no' AND
                    RP.flat_type='DBL' AND
                    RP.date >= '{$price_date_today}' AND
                    RP.is_del='no'
                    
                    
                    {$conditionSpecial}
                    {$conditionDiscount}
                    {$conditionCountry}
            GROUP BY
                    H.id
            ORDER BY
                    H.priority  ASC , H.star_code  DESC, H.name ASC, H.discount  DESC
            {$LIMIT}
			   ";

        return json_encode( $Model->select( $clientSql ) );

    }

    public function hotelWebServiceFullData( $params ) {
        /** @var ModelBase $ModelBase */
        $limit             = "";
        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $date     = $request['dateNow'];
        $limit    = $request['limit'];
        if ( isset( $limit ) && $limit != "" ) {
            $LIMIT = " LIMIT " . $limit . " ";
        }
        $price_date_today = dateTimeSetting::jtoday('');
        $Model     = Load::library( 'ModelBase' );

        $clientSql = "SELECT
                    H.hotel_name,
                    H.hotel_name_en,
                    H.discount,
                    H.star_code,
                    H.address,
                    H.pic,
                    H.info_rooms,
                    H.hotel_id,
                    HC.city_name_en As CityNameEn
            FROM
                    hotel_room_prices_tb AS H
            INNER JOIN hotel_cities_tb AS HC ON HC.city_code=H.city_id
            WHERE (H.star_code = '5' OR H.star_code = '4')
            GROUP BY
                    H.hotel_id
            {$LIMIT}
			   ";


        return json_encode( $Model->select( $clientSql ) );

    }

    public function hotelPopularCities($params){
        Load::library( 'ApiHotelCore' );
        $ApiHotelCore = new ApiHotelCore();

        $result = $ApiHotelCore->MostVisitedCities( $params );

        return $result;
    }

    public function tourInternalCity( $params ) {

        /** @var ModelBase $ModelBase */
        $isSpecial = [];
        $idCountry = [];
        $request   = [];

        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }


        $islang    = $request['lang'];
        $isSpecial = $request['special'];
        $idCountry = $request['idCountry'];
        $dateNow   = $request['dateNow'];
        $route     = $request['route'];
        if ( isset( $islang ) ) {
            $lang = $islang;
        } else {
            $lang = 'fa';
        }
        if ( $isSpecial == true ) {
            $special = "AND T.is_special = 'yes' ";
        } else {
            $special = '';
        }
        $type = '';

        if (isset($params['type_id']) && !empty($params['type_id'])) {

            $type_id_kind = 'like';
            if ( isset($request['type_id_kind']) && !empty($request['type_id_kind']) && $request['type_id_kind'] == 'not_like') {
                $type_id_kind = 'not like';
            }
            if(is_array($params['type_id'])){
                foreach ($params['type_id'] as $typeId){
                    $type .= "   AND T.tour_type_id {$type_id_kind} '%" . '"' . $typeId . '"' . "%' ";
                }

            }else{
                $type .= "   AND T.tour_type_id {$type_id_kind} '%" . '"' . $params['type_id'] . '"' . "%' ";

            }
        }



        if ( $route == 'dept' ) {
            $clientSql = " SELECT
                      C.id, C.name,C.abbreviation,C.name_en , T.start_date 
                  FROM
                     reservation_tour_tb AS T
                     INNER JOIN reservation_city_tb AS C ON C.id = T.origin_city_id 
                     INNER JOIN reservation_tour_rout_tb AS TR ON C.id = TR.destination_city_id
                  WHERE
                      C.id_country = {$idCountry}
                      AND T.is_del = 'no'
                      AND T.is_show = 'yes'
                      AND T.language = '{$lang}'
                      AND T.start_date > '{$dateNow}' 
                      AND (TR.is_route_fake = '1' OR TR.is_route_fake IS NULL) 
                      {$special}
                      {$type}
                  GROUP BY C.id
                  ORDER BY T.id DESC
                  ";
        } elseif ( $route == 'return' ) {
            $clientSql = " SELECT
                      C.id, C.name, C.name_en, T.start_date 
                  FROM
                      reservation_city_tb AS C
                      INNER JOIN reservation_tour_rout_tb AS TR ON C.id=TR.destination_city_id
                      INNER JOIN reservation_tour_tb AS T ON T.id = TR.fk_tour_id
                  WHERE
                      C.id_country = {$idCountry}
                      AND T.is_del = 'no'
                       AND T.is_show = 'yes'
                      AND T.language = '{$lang}'
                      AND T.start_date > '{$dateNow}'
                      AND TR.tour_title = 'dept'
                      AND (TR.is_route_fake = '1' OR TR.is_route_fake IS NULL) 
                      {$special}
                      {$type}
                  GROUP BY C.id
                  ORDER BY TR.id DESC";
        }



        $Model = Load::library( 'Model' );

        return json_encode( $Model->select( $clientSql ) );


    }

    public function tourExternalEnCountry( $params ) {
        /** @var ModelBase $ModelBase */

        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }


        $dateNow = $request['dateNow'];

        $clientSql = "SELECT C.id,C.name ,C.name_en
            FROM
                reservation_country_tb AS C
                    INNER JOIN reservation_tour_tb AS T ON T.origin_country_id = C.id
                  INNER JOIN reservation_tour_rout_tb AS TR ON T.id = TR.fk_tour_id
            WHERE
                TR.is_del = 'no'
                AND T.language = 'en'
                AND T.start_date > '{$dateNow}'
            GROUP BY
                C.id
            ORDER BY
                T.id DESC";


        $Model = Load::library( 'Model' );

        return json_encode( $Model->select( $clientSql ) );


    }

    public function tourExternalEnCountryDestination( $params ) {
        /** @var ModelBase $ModelBase */

        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }

        $idCountry            = $request['idCountry'];
        $idCity               = $request['idCity'];
        $idDestinationCountry = $request['idDestinationCountry'];
        $dateNow              = $request['dateNow'];

        $clientSql = " SELECT
                  C.id, C.name,C.name_en
              FROM
                  reservation_city_tb AS C
                  INNER JOIN reservation_tour_rout_tb AS TR ON C.id=TR.destination_city_id
                  INNER JOIN reservation_tour_tb AS T ON T.id = TR.fk_tour_id
              WHERE
                  T.origin_country_id = {$idCountry} AND
                  T.origin_city_id = {$idCity} AND
                  TR.destination_country_id = {$idDestinationCountry} AND
                  TR.is_del = 'no' AND
                  T.language = 'en' AND
                   T.start_date > '{$dateNow}'
              GROUP BY C.id
              ORDER BY T.id DESC
              ";


        $Model = Load::library( 'Model' );

        return json_encode( $Model->select( $clientSql ) );


    }


    public function tourExternalContinent( $params ) {
        /** @var ModelBase $ModelBase */
        $request = [];
        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }


        $continents=$this->getModel('continentCodesModel')->get(['titleFa','titleEn','id']);
        $continents=$continents->all();

        $is_external = $request['external'];
        $dateNow     = $request['dateNow'];
        $clientSql   = " SELECT
              C.id, C.name,C.id_continent
          FROM
              reservation_country_tb AS C
              INNER JOIN reservation_tour_rout_tb AS TR ON C.id=TR.destination_country_id
              INNER JOIN reservation_tour_tb AS T ON T.id = TR.fk_tour_id
             
          ";
        if ( isset( $is_external ) && $is_external == 'yes' ) {
            $clientSql .= " WHERE C.id != '1' AND TR.is_del = 'no' AND T.language = 'fa' AND T.start_date > '{$dateNow}' AND T.is_show = 'yes' AND TR.tour_title = 'dept'  GROUP BY C.id ";
        }
        $clientSql .= "
          ORDER BY T.id DESC
          ";


        $Model = Load::library( 'Model' );
        $countries=$Model->select( $clientSql );


        $continents_array = array();
        foreach ($continents as $continent) {
            $country_array = [];
            foreach ($countries as $country) {
                if ($country['id_continent'] == $continent['id']) {
                    if (!in_array($country, $country_array))
                        $country_array[] = $country;
                }
            }
            if ($country_array) {
                $continent['countries'] = $country_array;
                $continents_array[] = $continent;
            }
        }
        return json_encode($continents_array, 256);

    }


    public function tourExternalCountry( $params ) {

        /** @var ModelBase $ModelBase */
        $request = [];
        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $is_external = $request['external'];
        $dateNow     = $request['dateNow'];
        $special     = $request['special'];

        $clientSql   = " SELECT
              C.id, C.name
          FROM
              reservation_country_tb AS C
              INNER JOIN reservation_tour_rout_tb AS TR ON C.id=TR.destination_country_id
              INNER JOIN reservation_tour_tb AS T ON T.id = TR.fk_tour_id
              WHERE T.is_show = 'yes'
          ";



        if (isset($request['type_id']) && !empty($request['type_id'])) {
            $type_id_kind = 'like';
            if ( isset($request['type_id_kind']) && !empty($request['type_id_kind']) && $request['type_id_kind'] == 'not_like') {
                $type_id_kind = 'not like';
            }
            $clientSql .= "   AND T.tour_type_id {$type_id_kind} '%" . '"' . $request['type_id'] . '"' . "%' ";
        }


        if(isset( $special ) && $special == 'yes'){
            $clientSql .= "  AND T.is_special = 'yes' ";
        }
        if ( isset( $is_external ) && $is_external == 'yes' ) {
            $clientSql .= " AND C.id != '1' AND TR.is_del = 'no' AND T.language = 'fa' AND T.start_date > '{$dateNow}'  AND TR.tour_title = 'dept'  GROUP BY C.id ";
        }else{
            $clientSql .= " AND TR.is_del = 'no' AND T.language = 'fa' AND T.start_date > '{$dateNow}'  AND TR.tour_title = 'dept'  GROUP BY C.id ";
        }


        $clientSql .= "
          ORDER BY T.id DESC
          ";
        $Model = Load::library( 'Model' );

        return json_encode( $Model->select( $clientSql ) );

    }

    public function tourExternalCountryCity( $params ) {
        /** @var ModelBase $ModelBase */
        $request = [];
        $categoryWhere = '';
        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $idCountry = $request['idCountry'];
        $idCity    = $request['idCity'];
        $typeApp   = $request['typeApp'];
        if(isset($request['type_id'])) {
            $categoryWhere = 'And R.tour_type_id like "%'.$request['type_id'].'%"';
        }
        if ( isset( $typeApp ) && $typeApp == 'reservationTour' ) {
            $clientSql = " SELECT
                  C.id, C.name,C.name_en
              FROM
                  reservation_city_tb AS C
                  INNER JOIN reservation_tour_rout_tb AS T ON C.id=T.destination_city_id
                  INNER JOIN reservation_tour_tb AS R ON T.fk_tour_id =R.id  
              WHERE
                  C.id_country = {$idCountry}
                  AND R.origin_city_id = {$idCity}
                  {$categoryWhere}
              GROUP BY C.id
              ORDER BY T.id DESC
              ";


        } else {

            $clientSql = " SELECT id, name  FROM reservation_city_tb WHERE id_country = {$idCountry} AND is_del='no' ";
        }


        $Model = Load::library( 'Model' );

        return json_encode( $Model->select( $clientSql ) );
    }

    public function trainRoutes( $params ) {

        /** @var ModelBase $ModelBase */


        $request = [];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $type = $request['type'];
        if ( isset( $request['self_Db'] ) && $request['self_Db'] != true ) {

            $ModelBase = Load::library( 'ModelBase' );
            $clientSql = "SELECT DISTINCTROW Code,Name,EnglishName FROM train_route_tb group by train_route_tb.Code";

            return json_encode( $ModelBase->select( $clientSql ) );
        } else {
            $typePriority = ( $type == 'destination' ) ? 'priorityDestination' : 'priority';
            $ModelBase    = Load::library( 'Model' );
            $clientSql    = "SELECT DISTINCTROW Code,Name,EnglishName FROM train_route_tb group by train_route_tb.Code ORDER By {$typePriority}=0,$typePriority ASC ";
            return json_encode( $ModelBase->select( $clientSql ) );
        }


    }


    public function entertainmentCategories( $params ) {

        /** @var ModelBase $ModelBase */


        $request = [];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $parent_id = $request['parent_id'];
        $id        = $request['id'];
        $Condition = '';
        if ( $parent_id != '' ) {
            if ( $parent_id != 'sub' ) {
                $Condition .= "AND ECategory.parent_id='{$parent_id}'";
            } else {
                $Condition .= "AND ECategory.parent_id !='0'";
            }
        }
        if ( $id != '' ) {
            $Condition .= "AND ECategory.id='{$id}'";
        }

        $clientSql = "SELECT ECategory.id AS CategoryId,
                ECategory.parent_id AS CategoryParentId,
                    ECategory.title AS CategoryTitle,
                ECategory.validate AS CategoryValidate
             FROM entertainment_category_tb AS ECategory
             WHERE ECategory.validate='1' " . $Condition;

        $Model = Load::library( 'Model' );

        return json_encode( $Model->select( $clientSql ) );
    }

    public function allContinents( $params ) {
        /** @var ModelBase $ModelBase */
        $request = [];
        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }

        $clientSql = "SELECT id,code,titleFa FROM continent_codes_tb ORDER BY titleFa";

        $ModelBase = Load::library( 'ModelBase' );

        return json_encode( $ModelBase->select( $clientSql ) );
    }

    public function allCountriesByContinent( $params ) {
        /** @var ModelBase $ModelBase */
        $request = [];
        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $correctDate = $request['correctDate'];
        $continentID = $request['continentID'];

        $clientSql = "SELECT DISTINCT(Visa.countryCode) FROM visa_tb AS Visa
                LEFT JOIN visa_expiration_tb as expiration ON expiration.visa_id=Visa.id
                 WHERE
                       CASE
		
                                WHEN Visa.agency_id = '0' THEN
                                1 ELSE expiration.expired_at
                            END >
                        CASE
                                
                                WHEN Visa.agency_id = '0' THEN
                                0 ELSE '{$correctDate}'
                            END
                       AND Visa.isActive = 'yes'
                  AND Visa.isDell = 'no'
                  
                  AND Visa.validate = 'granted'
                  ";

        $Model = Load::library( 'Model' );

        $availableVisa = $Model->select( $clientSql );
        $Visa          = [];
        foreach ( $availableVisa as $itemVisa ) {
            $Visa[] =strtoupper($itemVisa['countryCode']);
        }
        $Sql = "SELECT `code`, `titleFa`, `titleEn` FROM `country_codes_tb` WHERE continent_code = '{$continentID}' ORDER BY `titleFa`";

        $ModelBase  = Load::library( 'ModelBase' );
        $ResultBase = $ModelBase->select( $Sql );

        $FinalResult = [];
        foreach ( $ResultBase as $itemBase ) {
            if ( in_array( strtoupper($itemBase['code']), $Visa ) ) {
                $FinalResult[] = $itemBase;
            }
        }

        return json_encode( $FinalResult );

    }

    public function allVisaTypes( $params ) {
        /** @var ModelBase $ModelBase */


        $request = [];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }

        $Model     = Load::library( 'Model' );
        $clientSql = "SELECT id, title  FROM visa_type_tb";

        return json_encode( $Model->select( $clientSql ) );

    }

    public function allCountryVisaTypes( $params ) {
        /** @var ModelBase $ModelBase */


        $request = [];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }

        $correctDate = date( 'Y-m-d H:i:s' );

        $Model     = Load::library( 'Model' );
        $clientSql = "
         SELECT
	visaType.id,
	visaType.title
FROM
	visa_type_tb visaType
	INNER JOIN visa_tb AS visa ON visa.visaTypeID = visaType.id
	INNER JOIN reservation_country_tb AS country ON visa.countryCode = country.abbreviation
	LEFT JOIN visa_expiration_tb AS Expiration ON Expiration.visa_id = visa.id
WHERE
CASE
		
		WHEN visa.agency_id = '0' THEN
		1 ELSE Expiration.expired_at
	END >
CASE
		
		WHEN visa.agency_id = '0' THEN
		0 ELSE '{$correctDate}'
	END
		AND visa.isActive =
	CASE
			
			WHEN visa.agency_id = '0' THEN
			visa.isActive ELSE 'yes'
		END
			AND visa.isDell = 'no'
		AND visa.countryCode ='{$params['country_id']}'
	AND visa.validate = 'granted'
	
	GROUP BY visaType.id


";


        return json_encode( $Model->select( $clientSql ) );

    }

    public function gashtAndTransferCites( $params ) {
        /** @var ModelBase $ModelBase */

        $request = [];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }

        $ModelBase = Load::library( 'ModelBase' );
        $clientSql = "SELECT * FROM  gashtotransfer_cities_tb ORDER BY city_name";

        return json_encode( $ModelBase->select( $clientSql ) );

    }

    public function insuranceCountry( $params ) {
        /** @var ModelBase $ModelBase */


        $request = [];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }


        $clientSql = "SELECT `abbr`, `persian_name` FROM `insurance_country_tb`
    WHERE `abbr` != '' GROUP BY `abbr` ORDER BY `persian_name`";
        $ModelBase = Load::library( 'ModelBase' );

        return json_encode( $ModelBase->select( $clientSql ) );

    }

    public function RandomHotelList( $params ) {
        Load::library( 'ApiHotelCore' );
        $ApiHotelCore = new ApiHotelCore();

        $result = $ApiHotelCore->RandomHotelList( $params );

        return $result;
    }

    public function getMasterRate( $params ) {
        $data['record_id']  = $params['record_id'];
        $data['table_name'] = $params['table_name'];

        return $this->adminController->getMasterRate( $data );
    }


    public function tourList($params)
    {


        unset($params['method']);

        $conditions= [
            array(
                "index" => "is_show",
                "table" => "reservation_tour_tb",
                "value" => "yes"
            ),
            array(
                "index" => "is_del",
                "table" => "reservation_tour_tb",
                "value" => "no"
            )
        ];

        $params['conditions']=array_merge($conditions,$params['conditions']);

//        // prevent from select reservation_city_tb and then join reservation_city_tb again! cause error
//        foreach ($params['conditions'] as $key => $condition) {
//            if ($condition["table"] === "reservation_city_tb") {
//                unset($params["conditions"][$key]);
//            }
//        }
//        $params["conditions"] = array_values($params["conditions"]);



        if(empty($params['limit'])){
            $params['limit']=10;
        }




        /**
         * @var $main_tour mainTour
         */
        $main_tour = Load::controller( 'mainTour' );

        return $main_tour->getTourList($params);
    }



    public function tourCities($params)
    {
        unset($params['method']);


        $conditions= array(
            array(
                "index" => "is_show",
                "table" => "reservation_tour_tb",
                "value" => "yes"
            ),
            array(
                "index" => "is_del",
                "table" => "reservation_city_tb",
                "value" => "no"
            ),
            array(
                "index" => "is_del",
                "table" => "reservation_tour_tb",
                "value" => "no"
            )
        );


        $params['conditions']=array_merge($conditions,$params['conditions']);

        if(empty($params['limit'])){
            $params['limit']=10;
        }

        /**
         * @var $main_tour mainTour
         */
        $main_tour = Load::controller( 'mainTour' );
        return $main_tour->getCityList($params);
    }

    public function getExternalCities($params)
    {
        /**
         * @var $main_tour mainTour
         */
        $main_tour = Load::controller( 'mainTour' );
        return $main_tour->getExternalCities($params);
    }
    public function getExternalCountries($params)
    {
        /**
         * @var $main_tour mainTour
         */
        $main_tour = Load::controller( 'mainTour' );
        return $main_tour->getCountry($params);
    }


    public function getCountryCodes()
    {
//        $data=functions::CountryCodes();
        $data= $this->getModel('countryCodesModel')->get()->all();
        return json_encode($data,256);
    }


    public function getCurrencyData()
    {
        /** @var currencyEquivalent $currency_controller */
        $currency_controller=Load::controller('currencyEquivalent');
        return $currency_controller->ListCurrencyEquivalentObj(true);
    }

    public function getTourTypeList(){

        /** @var mainTour $tour_controller */
        $tour_controller = Load::controller('mainTour');
        return $tour_controller->getTourTypeList();
    }

    public function searchAirports($params)
    {
        /** @var airports $airports */
        $airports = $this->getController('airports');
        if(isset($params['origin'])){
            return $airports->findDestination($params);
        }
        return $airports->findOrigin($params);
    }

    public function checkDefaultDb(){
        return json_encode(['status' => DEFAULT_DB]);
    }

    public function getEntertainmentCountries()
    {
        $entertainment = Load::controller('entertainment');
        return json_encode($entertainment->getCountries(),256);
    }

    public function getEntertainmentCities($params)
    {
        $entertainment = Load::controller('entertainment');
        return json_encode($entertainment->getCities(['country_id'=>$params['country_id']]),256);
    }
    public function getDailyQuote($params)
    {
        $quotes = $this->getController('dailyQuote')->listDailyQuote($params);
        if (isset($quotes) && !empty($quotes)) {
            return json_encode($quotes,256);
        }
        return null;
    }
    public function getEntertainmentCategories($params)
    {
        $entertainment = Load::controller('entertainment');

        $params['parent_id'] =0;
        return json_encode($entertainment->getCategories($params),256);
    }
    public function getEntertainmentSubCategories($params)
    {
        $entertainment = Load::controller('entertainment');
        return json_encode($entertainment->getSubCategories($params),256);
    }

    public function getAllUserCurrencies($params) {
        return functions::getAllUserCurrencies();
    }

//    get train origin cities with search
    public function searchTrainOriginCity( $params ) {

        $train = Load::controller('routeTrain');
        return json_encode($train->getTrainRoutes($params,$params['self_db']),256);

    }

    public function getArticle( $params ) {

        $article = Load::controller('articles');

        return json_encode($article->getArticlesPosition($params),256);

    }

    public function getRouteInfo($Code){
        return json_encode(functions::InfoRoute($Code['iata']),256);
    }

    public function checkJacketCustomer($params) {

        if(isset($params['domainName']) && !empty($params['domainName'])) {

        }
    }

    public function jacketCustomerInfo($params) {

        $jacketCustomer = $this->getController('jacketCustomer');
        $result =  $jacketCustomer->getJacketCustomerInfo($params['data']);
        $result = [
            'result' => $result
        ];
        return json_encode($result);
    }
    public function popularCityForInternalHotel() {

        $result = Load::controller('searchHotel');
        $result =  $result->popularInternalHotelCities();
        return json_encode($result);
    }

    public function testWhySlow() {
        $result = [
            'result' => 'hello gds'
        ];
        return json_encode($result);
    }

    public function checkActiveCustomer($params) {
        $partner = Load::model('partner');
        $client_info = $partner->getClient(['domain' => $params['domain']]);

        $jacket = Load::controller('jacketCustomer') ;
        $jacket_customer_info = $jacket->checkActivate(['clientId' => $client_info[0]['id']]);

        $data = array(
            'userName' => $client_info[0]['Email'] ,
            'password' => $jacket_customer_info['password'] ,
            'link' => $client_info[0]['Domain'].'/gds/itadmin/login' ,
            'isActive' => $jacket_customer_info['isActive'] ,
        );


        $result = [
            'status' => 200 ,
            'data'  => $data,
            'success' => true
        ];
        return  json_encode($result , 256);

    }

    /**
     * @return array
     */
    public function getLastRecordeReportTb() {

        return  json_encode($this->getModel('reportModel')->get(['request_number','creation_date_int'])->orderBy('creation_date_int')->limit(0,1)->find(),256);
    }

    public function getPopUp( $params ) {
        unset($params['method']);
        if (strpos($_SERVER['HTTP_HOST'], '192.168.') === false) {
            $url = 'http://online.indobare.com/gds/pic/popUp/';
        } else{
            $url = 'http://192.168.1.100/gds/pic/popUp/';
        }
        $ModelBase    = Load::library( 'ModelBase' );
        $popSql    = " SELECT * FROM pop_up_tb WHERE is_active = '1'  ";
        $Result = $ModelBase->load( $popSql );
        $Result['alt'] = $Result['title'] ?: '';
        $Result['title'] = $Result['title'] ?: '';
        $Result['description'] = $Result['description'] ?: '';
        $Result['is_active'] = $Result['is_active'] ?: '';
        if (!empty($Result['pic'])) {
            $Result['pic'] = $url. CLIENT_ID . '/'. $Result['pic'];
        }else{
            $Result['pic'] = '';
        }
        if (!empty($Result['pic_mobile'])) {
            $Result['pic_mobile'] = $url . CLIENT_ID . '/'. $Result['pic_mobile'];
        }else{
            $Result['pic_mobile'] = '';
        }
        if (!empty($Result['pic_sample'])) {
            $Result['pic_sample'] = $url . CLIENT_ID . '/'. $Result['pic_sample'];
        }else{
            $Result['pic_sample'] = '';
        }
        return json_encode( $Result, true );
    }


    public function getVisas() {
        $continents = $this->allContinents();
        $continents = json_decode($continents , true);

        $dateNow = dateTimeSetting::jdate("Ymd", "", "", "", "en");
        $countries = [];
        foreach ($continents as $key=>$continent) {

            $params = [
                'continentID'  => $continent['id'] ,
                'correctDate' => $dateNow
            ] ;
            $result = json_decode($this->allCountriesByContinent($params));

            $countries['continent'][] = $continent;
            $countries['countries'][$continent['id']][] = $result;
        }


        return json_encode( $countries, true ) ;
    }

    public function getCitiesWithTour($params) {
        $cities = $this->tourCities($params) ;

        $dateNow = dateTimeSetting::jdate("Ymd", "", "", "", "en");
        $tour_list = [] ;
        $cities = json_decode($cities , true);

        foreach ($cities['data'] as $key=>$city) {

            $conditions = array(
                array(
                    'index'=>'id_country',
                    'table'=>'reservation_city_tb',
                    'operator'=>'=',
                    'value'=>'1',
                ),
                array(
                    'index'=>'origin_country_id',
                    'table'=>'reservation_tour_tb',
                    'operator'=>'=',
                    'value'=>'1',
                ),
                array(
                    'index'=>'destination_country_id',
                    'table'=>'reservation_tour_rout_tb',
                    'operator'=>'=',
                    'value'=>'1',
                ),
                array(
                    'index'=>'number_rout',
                    'table'=>'reservation_tour_rout_tb',
                    'operator'=>'=',
                    'value'=>'1',
                ),
                array(
                    'index'=>'destination_city_id',
                    'table'=>'reservation_tour_rout_tb',
                    'operator'=>'=',
                    'value'=> $city['id'],
                ),
                array(
                    'index'=>'tour_title',
                    'table'=>'reservation_tour_rout_tb',
                    'operator'=>'=',
                    'value'=>'dept',
                ),
                array(
                    'index'=>'start_date',
                    'table'=>'reservation_tour_tb',
                    'operator'=>'>',
                    'value'=>$dateNow,
                ),
                array(
                    'index'=>'start_date',
                    'table'=>'reservation_tour_tb',
                    'operator'=>'<',
                    'value'=>'20000101',
                ),
            );
            $tour_params = [
                'limit'  => 3 ,
                'conditions' => $conditions
            ] ;
            $tour= json_decode($this->tourList($tour_params) , true);
            $tour_list['cities'][] = $city;
            $tour_list['tourlist'][$city['id']][] = $tour['data'];

        }

        return $tour_list ;
    }

    public function getExternalCoutryWithTour($params) {
        $countries = $this->tourExternalCountry($params) ;

        $dateNow = dateTimeSetting::jdate("Ymd", "", "", "", "en");
        $tour_list = [] ;
        $countries = json_decode($countries , true);

        foreach ($countries as $key=>$country) {

            $conditions = array(
                array(
                    'index'=>'destination_city_id',
                    'table'=>'reservation_tour_rout_tb',
                    'operator'=>'!=',
                    'value'=> $country['id'],
                ),
                array(
                    'index'=>'destination_country_id',
                    'table'=>'reservation_tour_rout_tb',
                    'operator'=>'=',
                    'value'=> $country['id'],
                ),
                array(
                    'index'=>'tour_title',
                    'table'=>'reservation_tour_rout_tb',
                    'operator'=>'=',
                    'value'=>'dept',
                ),
                array(
                    'index'=>'start_date',
                    'table'=>'reservation_tour_tb',
                    'operator'=>'>',
                    'value'=>$dateNow,
                ),
                array(
                    'index'=>'start_date',
                    'table'=>'reservation_tour_tb',
                    'operator'=>'<',
                    'value'=>'20000101',
                ),
            );
            $tour_params = [
                'limit'  => 3 ,
                'conditions' => $conditions
            ] ;
            $tour= json_decode($this->tourList($tour_params) , true);

            $tour_list['countries'][] = $countries;
            $tour_list['tourlist'][$country['id']][] = $tour['data'];

        }

        return $tour_list ;
    }

    public function getAllData($params) {
        $final_result = [];



        foreach ($params['services'] as $key=>$each_method) {
            $name = $key ;
            if($key == 'tourInternalDeptCity'){
                $key = 'tourInternalCity';
            }
            if($key == 'externalTourList'){
                $key = 'tourList';
            }
            if($key == 'externalTourReservationFullyData' || $key == 'specialTourReservationFullyData') {
                $key = 'tourReservationFullyData';
            }
            if($key == 'tourReservationInternalFullyData2' || $key == 'tourReservationInternalFullyData4' ||
                $key == 'tourReservationInternalFullyData5' || $key == 'tourReservationExternalFullyData2' ||
                $key == 'tourReservationExternalFullyData4' || $key == 'tourReservationExternalFullyData5' ) {
                $key = 'tourReservationFullyData';
            }
            $final_result[$name] = json_decode($this->$key($each_method) , true);

        }
//        if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//          echo json_encode($final_result);
//            die();
//        }
        return json_encode($final_result) ;
    }

    public function ReservationTourCountries($params) {
        $params['is_external']=isset($params['is_external'])?$params['is_external']:false;
        $params['isSpecial']=isset($params['isSpecial'])?$params['isSpecial']:false;
        $params['type_id']=isset($params['type_id'])?$params['type_id']:null;
        $params['type_kind']=isset($params['type_kind'])?$params['type_kind']:'like';

        $result = $this->getController('reservationBasicInformation')->ReservationTourCountries(
            $params['is_external'],
            $params['isSpecial'],
            $params['type_id'],
            $params['type_kind']
        ) ;
        return json_encode($result,256|64) ;

    }

    public function payaneCity() {
        $ModelBase = Load::library( 'ModelBase' );


        $clientSql    = " SELECT * FROM bus_route_tb WHERE iataCode = ''; ";
        $payaneCity = $ModelBase->select( $clientSql );

        foreach ($payaneCity as $payane) {
            $data['name_fa'] = "'" .$payane['name'] ."'";
            $data['code'] = $payane['code'];
            $ModelBase->setTable('bus_route_tb');
            $payaneResult =  $ModelBase->insert( $data );

        }
    }

    public function payaneCompany() {
        $ModelBase = Load::library( 'ModelBase' );

//        $clientSql    = " SELECT * FROM payane_company_tb where iata NOT IN (
//     SELECT distinct iata_code FROM base_company_bus_tb where iata_code !=  ''
// ) group by iata ";
//        var_dump($clientSql);
//        die();
        $clientSql    = " SELECT * FROM payane_company_tb group by iata ";
        $payaneCity = $ModelBase->select( $clientSql );

        foreach ($payaneCity as $payane) {
            if($payane['iata'] != '0' ) {
                $clientSql    = " SELECT * FROM payane_company_tb where iata = '{$payane['iata']}' ";

                $payaneCompany = $ModelBase->select( $clientSql );


                $clientSql    = " SELECT * FROM base_company_bus_tb where iata_code = '{$payane['iata']}' ";

                $payaneCityiata = $ModelBase->select( $clientSql );

                foreach ($payaneCompany as $company) {

                    $data['id_base_company'] = $payaneCityiata[0]['id'];
                    $data['name_fa'] = "'" .$company['name'] ."'";
                    $data['is_del'] = "'no'";

                    $ModelBase->setTable('company_bus_tb');

                    $payaneResult =  $ModelBase->insert( $data );

                }
            }

        }
    }

    public function getDataReports($params) {

        $results = $this->getModel('reportGashtModel')->get()->where('creation_date_int','1690290049','>')->whereNotIn('client_id',['44','186'])->all() ;
        return json_encode($results,256|64);
    }


    public function setDataToDb() {

        $data_item =[];
        $url  = "http://safar360.com/gds/infoGds";

        $data['method'] = 'getDataReports' ;

        $result_get = functions::curlExecution($url,json_encode($data),'yes');

        $results = $this->getModel('reportGashtModel')->get(['requestNumber'],true)->where('creation_date_int','1690290049','>')->whereNotIn('client_id',['44','186'])->all() ;

        foreach ($results as $item) {
            $data_item[] = $item['RequestNumber'] ;
        }
        $data_group = [];

        foreach ($result_get as $result) {
            if(!in_array($result['requestNumber'],$data_item)){

                $data_final[] = $result ;
                $data_group[$result['client_id']][]=$result;
            }

        }


//       if(!empty($data_final)) {
//           foreach ($data_final as $key=>$item_final) {
//
//               unset($item_final['id']);
//
//                $item_final['database_source'] = 'german';
//
//                $this->getModel('reportGashtModel')->insertLocal($item_final);
//
//           }
//       }

        echo json_encode($data_group,256|64); die();

    }


    public function getBackGround() {

        $image_info =  $this->getController('bannerBackground')->getLastImageBackGround();

        $data['url'] =  SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/bannerBackground' . '/'.$image_info['pic'];
        return json_encode($data,256|64);
    }

    public function checkLogin() {

        return json_encode(Session::IsLogin(),256|64);
    }
    public function sendSamanKishData($data) {
        var_dump($data );
        die;
//        $result =  $this->getController('bank')->executeSamanKish();
//        $bankUrl  = 'https://sep.shaparak.ir/MobilePG/MobilePayment';
//        $result = functions::curlExecution($bankUrl,json_encode($data,256),'json');

        return $result;
    }

    public function saveAirlineLogo() {

        $Model     = Load::library( 'ModelBase' );
        $clientSql = "SELECT * from airline_tb" ;

        $airline_list =$Model->select( $clientSql );
        $FATEME = [];

        $saveDirectory = __DIR__ . '/pic/airlines/';

        foreach ($airline_list as $key => $airline) {
            $savePath = $saveDirectory .$airline['abbreviation'].'.png';
            if(file_exists($savePath)){
                unset($airline_list[$key]);
            }
        }

        foreach ($airline_list as $airline) {

            $imageUrl = 'https://store.snapptrip.com/assets/airlines/48x48/'.$airline['abbreviation'].'.png';

            // Define the directory where the image will be saved


// Ensure the directory exists
            if (!is_dir($saveDirectory)) {
                if (!mkdir($saveDirectory, 0777, true)) {
                    die("Failed to create directory: $saveDirectory");
                }
            }

// Define the full path for the image
            $savePath = $saveDirectory .$airline['abbreviation'].'.png';
            // Use file_get_contents to fetch the image
            $imageData = file_get_contents($imageUrl);

            if ($imageData !== false && !file_exists($savePath)) {

                $ch = curl_init($imageUrl);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response instead of outputting it
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects if any

                $imageData = curl_exec($ch);

                if (curl_errno($ch)) {
                    echo 'cURL error: ' . curl_error($ch);
                    curl_close($ch);
                    exit;
                }

                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                curl_close($ch);

                if ($httpCode === 200 && $imageData !== false) {
                    // Save the image to the specified path
                    if (file_put_contents($savePath, $imageData)) {
//                        echo "sacee to save the image to $savePath.";
//                        die();
                    } else {

                        $FATEME[] = $airline['abbreviation'];
                        echo "Failed to save the image to $savePath.";
                    }
                } else {
                    $FATEME[] = $airline['abbreviation'];
//                    echo "Failed to download the image. HTTP Code: $httpCode";
                }


            } else {
                if(!file_exists($savePath)) {
                    $FATEME[] = $airline['abbreviation'];
                }

//                echo "Failed to download the image.";
            }
        }
        var_dump($FATEME);
        die();
    }

    public function insertClientTransactions()
    {
        $transactions      = Load::controller( 'transactions' );
        $transactions->index();
    }




    public function getSepehrInfoGds($data)
    {
        $specialId = $data['params']['HotelIndex'];
        $hotelInfo = $this->getController('resultHotelLocal')->getSepehrHotelInfo($specialId);


        // بررسی وجود نتایج
        if (empty($hotelInfo)) {
            $data['error'] = 'هتلی با این کد یافت نشد';
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        // دسترسی به اولین نتیجه
        $firstHotel = $hotelInfo[0];

        // بررسی وجود لوگو
        if (empty($firstHotel['logo'])) {
            $data['error'] = 'لوگوی هتل یافت نشد';
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        // ساخت URL
        $noPhotoUrl = '/project_files/images/logo.png';
        if ($firstHotel['logo']) {
            $data['url'] = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/' . $firstHotel['logo'];
        }else{
            $data['url'] = SERVER_HTTP . CLIENT_DOMAIN . $noPhotoUrl;
        }
        // پردازش امکانات هتل
        $facilitiesArray = [];
        if (!empty($firstHotel['facilities_titles'])) {
            $titles = explode('||', $firstHotel['facilities_titles']);
            $icons = explode('||', $firstHotel['facilities_icons']);

            foreach ($titles as $index => $title) {
                $facilitiesArray[] = [
                    'title' => $title,
                    'icon_class' => $icons[$index] ? $icons[$index] : null
                ];
            }
        }
        // اضافه کردن اطلاعات آدرس هتل
        $data['hotel_info'] = [
            'address' => $firstHotel['address'] ? $firstHotel['address'] : '',
            'city' => $firstHotel['city'] ? $firstHotel['city'] : '',
            'star_code' => $firstHotel['star_code'] ? $firstHotel['star_code'] : '',
            'region' => $firstHotel['region'] ? $firstHotel['region'] : '',
            'country' => $firstHotel['country'] ? $firstHotel['country'] : '',
            'phone' => $firstHotel['tel_number'] ? $firstHotel['tel_number'] : '',
            'facilities' => $facilitiesArray
        ];

        // دیباگ: نمایش URL نهایی
//        echo "<pre>Final URL: " . $data['url'] . "</pre>";

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }


    public function getSepehrInfoDetailGds($data)
    {
        $specialId = $data['params']['HotelIndex'];
        $hotelInfo = $this->getController('resultHotelLocal')->getSepehrHotelDetailInfo($specialId);

        if (empty($hotelInfo)) {
            $data['error'] = 'هتلی با این کد یافت نشد';
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        $firstHotel = $hotelInfo[0];

        // ساخت URL تصویر
        $noPhotoUrl = '/project_files/images/logo.png';
        $data['url'] = $firstHotel['logo'] ?
            SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/' . $firstHotel['logo'] :
            SERVER_HTTP . CLIENT_DOMAIN . $noPhotoUrl;

        // پردازش امکانات هتل
        $facilitiesArray = [];
        if (!empty($firstHotel['facilities_titles'])) {
            $titles = explode('||', $firstHotel['facilities_titles']);
            $icons = explode('||', $firstHotel['facilities_icons']);

            foreach ($titles as $index => $title) {
                $facilitiesArray[] = [
                    'title' => $title,
                    'icon_class' => $icons[$index] ? $icons[$index] : null
                ];
            }
        }
        // پردازش گالری عکس‌ها
        $galleryArray = [];
        if (!empty($firstHotel['gallery'])) {
            foreach ($firstHotel['gallery'] as $image) {
                $imageUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/' . $image['pic'];
                $galleryArray[] = [
                    'url' => $imageUrl,
                    'title' => $image['name'] ? $image['name'] : '',
                    'description' => $image['comment'] ? $image['comment'] : ''
                ];
            }
        }
        // اطلاعات کامل هتل
        $data['hotel_info'] = [
            'address' => $firstHotel['address'] ? $firstHotel['address'] : '',
            'city' => $firstHotel['city'] ? $firstHotel['city'] : '',
            'star_code' => $firstHotel['star_code'] ? $firstHotel['star_code'] : '',
            'region' => $firstHotel['region'] ? $firstHotel['region'] : '',
            'country' => $firstHotel['country'] ? $firstHotel['country'] : '',
            'phone' => $firstHotel['tel_number'] ? $firstHotel['tel_number'] : '',
            'rules_cancel' => $firstHotel['rules'] ? $firstHotel['rules'] : '',
            'cancellation_conditions' => $firstHotel['cancellation_conditions'] ? $firstHotel['cancellation_conditions'] : '',
            'child_conditions' => $firstHotel['child_conditions'] ? $firstHotel['child_conditions'] : '',
            'facilities' => $facilitiesArray,
            'description' => $firstHotel['comment'] ? $firstHotel['comment'] : '',
            'location' => [
                'lat' => !empty($firstHotel['latitude']) ? (float)$firstHotel['latitude'] : null,
                'lon' => !empty($firstHotel['longitude']) ? (float)$firstHotel['longitude'] : null
            ],
            'rules' => $firstHotel['rules'] ? $firstHotel['rules'] : '',
            'cancellation_conditions' => $firstHotel['cancellation_conditions'] ? $firstHotel['cancellation_conditions'] : '',
            'gallery' => $galleryArray
        ];

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

}

new infoGds();