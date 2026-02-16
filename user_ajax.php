<?php



// Apply the filter to $_POST

$array_special_char = ["\n", "‘", "’", "“", "”", "„" , "(", ")", "<", ">","</","/>","alert","+","from","sleep"] ;
$except_char = ['content'];

foreach ($_POST as $key=>$item) {
    if(!in_array($key , $except_char)){

        $item_after_replace[$key] = str_replace($array_special_char, '', $item);

        $_POST[$key] = $item_after_replace[$key];
    }

}



require 'config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require CONFIG_DIR . 'configBase.php';
require LIBRARY_DIR . 'functions.php';
require CONTROLLERS_DIR . 'dateTimeSetting.php';
require LIBRARY_DIR . 'Load.php';


spl_autoload_register( array( 'Load', 'autoload' ) );
if ( ( isset( $_SERVER["HTTP_HOST"] ) && strpos( $_SERVER["HTTP_HOST"], '192.168.1.100' ) !== false ) || ( isset( $_SERVER["HTTP_HOST"] ) && strpos( $_SERVER["HTTP_HOST"], 'online.1011.ir' ) !== false ) || ( isset( $_SERVER["HTTP_HOST"] ) && strpos( $_SERVER["HTTP_HOST"], '1011.ir' ) !== false ) || ( isset( $_SERVER["HTTP_HOST"] ) && strpos( $_SERVER["HTTP_HOST"], 'localhost' ) !== false ) ) {//local
    $apiAddress = 'http://safar360.com/CoreTestDeveloper';
} else {
    $apiAddress = 'http://safar360.com/Core';

}


/**
 * Register new member in DB
 */
if ( isset( $_POST['flag'] ) && $_POST['flag'] == 'memberRegisterSso' ) {
    /** @var members $controller */
    $controller = Load::controller( 'members' );
    echo $controller->memberInsert( $_POST );
}
if ( isset( $_POST['flag'] ) && $_POST['flag'] == 'memberRegister' ) {

    /** @var members $controller */
    $controller = Load::controller( 'members' );

    //    echo Load::plog($_POST);
    if ( isset( $_POST['FormData']['Type'] ) && $_POST['FormData']['Type'] == 'App' ) {
        $_POST = $_POST['FormData'];
    }

    if(functions::validateMobileOrEmail($_POST['entry'])){
        $data['entry']=functions::checkParamsInput( $_POST['entry']);
    }
    $data['name']        = functions::sanitizeString( trim( filter_var( $_POST['name'], FILTER_SANITIZE_STRING ) ) );
    $data['password']        = $_POST['password'];
    $data['family']      = functions::sanitizeString( trim( filter_var( $_POST['family'], FILTER_SANITIZE_STRING ) ) );
    $data['mobile']      = functions::sanitizeString( trim( trim( filter_var( $_POST['mobile'], FILTER_SANITIZE_NUMBER_INT ), '‌' ) ) );
//	$data['email']       = functions::sanitizeString( trim( trim( filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ), '‌' ) ) );
    $data['reagentCode'] = functions::sanitizeString( trim( filter_var( $_POST['reagentCode'], FILTER_SANITIZE_STRING ) ) );
    $data['TypeOs']      = functions::getOsUser();

    if ( $data['name'] != '' && $data['family'] != '' && $data['entry'] != '' ) {

        if ( isset( $_POST['Type'] ) && $_POST['Type'] == 'App' ) {
            $Result = json_decode($controller->memberInsert( $data ),true);

            if ( $Result['success'] ) {
                $dataResult['ResultRegister']  = 'success';
                $dataResult['MessageRegister'] = $Result['message'];
            } else {
//				$Result                        = explode( ':', $Result );
                $dataResult['ResultRegister']  = 'error';
//				$dataResult['MessageRegister'] = $Result[1];
                $dataResult['MessageRegister'] = 'message';
            }
            echo functions::toJson($dataResult);
//			echo json_encode( $dataResult );
        } else {
            $result_reagent = $controller->checkReagentCode($data);

            if(!empty($data['reagentCode']) && !$result_reagent){
                echo functions::toJson(['success'=>false,'message'=>'کد معرف وارد شده معتبر نمی باشد']);
            }else{
                echo $controller->memberInsert( $data );

            }
        }
    }
    else {
        if ( isset( $_POST['Type'] ) && $_POST['Type'] == 'App' ) {
            $dataResult['ResultRegister']  = 'error';
            $dataResult['MessageRegister'] = functions::Xmlinformation( 'ErrorRegisterByInvalidValue' );
            echo functions::toJson( $dataResult );
        } else {
            echo functions::toJson(['success'=>false,'message'=>functions::Xmlinformation( 'NoUserFoundWithThisProfile' )->__toString()]);
        }

    }
}
/**
 * Login member
 */ elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'memberLogin' ) {


    /** @var members_tb $controller */
    $controller = Load::controller( 'members' );
    if(functions::validateMobileOrEmail($_POST['entry'])){
        $entry=functions::checkParamsInput( $_POST['entry']);
    }

//	$email        = functions::checkParamsInput( functions::sanitizeString( filter_var( $_POST['entry'], FILTER_VALIDATE_EMAIL ) ) );
    $password     = functions::checkParamsInput( functions::sanitizeString( filter_var( $_POST['password'], FILTER_SANITIZE_STRING ) ) );
    $remember     = functions::checkParamsInput( functions::sanitizeString( filter_var( $_POST['remember'], FILTER_SANITIZE_STRING ) ) );
    $coockie      = functions::checkParamsInput( functions::sanitizeString( filter_var( $_POST['setcoockie'], FILTER_SANITIZE_STRING ) ) );
    $organization = isset( $_POST['organization'] ) ? functions::checkParamsInput( functions::sanitizeString( filter_var( $_POST['organization'], FILTER_VALIDATE_INT ) ) ) : '0';

    if ( $entry != '' && $password != '' ) {


        $isEnableClub = IS_ENABLE_CLUB;

        $result       = $controller->memberLogin( $entry, $password, $remember, $organization, $isEnableClub );


        if ( gettype( $result ) == 'string' && $result == 'LimitCount' ) {
            echo 'limitCount';
        }elseif ( gettype( $result ) == 'string' && $result == 'optExpired' ) {
            echo 'optExpired';
        } else {
            if ( $result ) {

                $clientAuth          = Load::library( 'clientAuth' );
                $ticketAuth          = $clientAuth->ticketFlightAuth();
                $reservationTourAuth = $clientAuth->reservationTourAuth();

                if ( isset( $_POST['App'] ) && $_POST['App'] == 'Yes' ) {

                    Session::LoginDoByCookie();
                    $SuccessArray = array(
                        "Status" => "success"
                    );
                    echo json_encode( $SuccessArray );
                } else {
                    if ( $reservationTourAuth == 'True' && functions::TypeUser( Session::getUserId() ) == 'Counter' ) {
                        echo 'success:reservationTourAuth';
                    } elseif ( $reservationTourAuth == 'True' && functions::TypeUser( Session::getUserId() ) != 'Counter' ) {
                        echo 'success:AccessTourWithOutCounter';
                    } else if ( ! empty( $ticketAuth ) ) {
                        echo 'success:ticketAccess';
                    } else {
                        echo 'success:NoTicketAccess';
                    }
                }


            } else {
                if ( isset( $_POST['App'] ) && $_POST['App'] == 'Yes' ) {
                    $SuccessArray = array(
                        "Status" => "error"
                    );
                    echo json_encode( $SuccessArray );
                } else {
                    echo 'error';
                }
            }
        }
    } else {
        if ( isset( $_POST['App'] ) && $_POST['App'] == 'Yes' ) {
            $SuccessArray = array(
                "Status" => "error"
            );
            echo json_encode( $SuccessArray );
        } else {
            echo 'error';
        }

    }

} /**
 * Login agency
 */ elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'agencyLogin' ) {

    $controller = Load::controller( 'agency' );

    $email    = functions::sanitizeString( $_POST['email'] );
    $password = functions::sanitizeString( $_POST['password'] );
    $remember = $_POST['remember'];

    if ( $email != '' && $password != '' ) {
        $result = $controller->login( $email, $password, $remember );
        if ( $result ) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
} /**
 * checkLogin
 * @return true(1) for yes and false()  for NO
 */ elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'checkLogin' ) {
    $result  = Session::IsLogin();
    $result2 = Session::getTypeUser();
    if ( $result and $result2 == 'counter' ) {
        $rel_id             = $_POST['rel_id'];
        $rec_id             = $_POST['rec_id'];
        $com_id             = $_POST['com_id'];
        $price_id           = $_POST['price_id'];
        $dept_airport       = $_POST['dept_airport'];
        $arr_airport        = $_POST['arr_airport'];
        $origin_loc_code    = $_POST['origin_loc_code'];
        $desti_loc_code     = $_POST['desti_loc_code'];
        $dept_elaps         = $_POST['dept_elaps'];
        $dept_booking_class = $_POST['dept_booking_class'];
        $dept_airline_name  = $_POST['dept_airline_name'];
        $dept_flight_no     = $_POST['dept_flight_no'];
        $dept_airline_abb   = $_POST['dept_airline_abb'];
        $dept_iata_code     = $_POST['dept_iata_code'];
        $dept_date          = $_POST['dept_date'];
        $dept_time          = $_POST['dept_time'];
        $arr_date           = $_POST['arr_date'];
        $dept_time_part     = $_POST['dept_time_part'];
        $arr_time           = $_POST['arr_time'];
        $dept_date_j        = $_POST['dept_date_j'];
        $arr_date_j         = $_POST['arr_date_j'];
        $dept_con           = $_POST['dept_con'];
        $ret_booking_class  = $_POST['ret_booking_class'];
        $ret_airline_name   = $_POST['ret_airline_name'];
        $ret_flight_no      = $_POST['ret_flight_no'];
        $ret_airline_abb    = $_POST['ret_airline_abb'];
        $ret_iata_code      = $_POST['ret_iata_code'];
        $ret_dept_date      = $_POST['ret_dept_date'];
        $ret_dept_time      = $_POST['ret_dept_time'];
        $ret_arr_date       = $_POST['ret_arr_date'];
        $ret_time_part      = $_POST['ret_time_part'];
        $ret_arr_time       = $_POST['ret_arr_time'];
        $ret_dept_date_j    = $_POST['ret_dept_date_j'];
        $ret_arr_date_j     = $_POST['ret_arr_date_j'];
        $ret_elaps          = $_POST['ret_elaps'];
        $ret_con            = $_POST['ret_con'];
        $main_adt           = $_POST['main_adt'];
        $final_adt          = $_POST['final_adt'];
        $tax_adt            = $_POST['tax_adt'];
        $soto_adt           = $_POST['soto_adt'];
        $quantity_adt       = $_POST['quantity_adt'];
        $main_chd           = $_POST['main_chd'];
        $final_chd          = $_POST['final_chd'];
        $tax_chd            = $_POST['tax_chd'];
        $soto_chd           = $_POST['soto_chd'];
        $quantity_chd       = $_POST['quantity_chd'];
        $main_inf           = $_POST['main_inf'];
        $final_inf          = $_POST['final_inf'];
        $tax_inf            = $_POST['tax_inf'];
        $soto_inf           = $_POST['soto_inf'];
        $quantity_inf       = $_POST['quantity_inf'];
        $office_name        = $_POST['office_name'];
        $sub_system         = $_POST['sub_system'];
        $address            = $_POST['address'];
        $index              = $_POST['index'];
        $CF                 = $_POST['CF'];
        $uniqID = microtime(TRUE);
        $uniqID             = str_replace( '.', '', $uniqID );

        $model       = Load::model( 'temporary_portal' );
        $temporaryID = $model->insert( $rel_id, $rec_id, $com_id, $price_id, $dept_airport, $arr_airport, $origin_loc_code, $desti_loc_code, $dept_elaps, $dept_booking_class, $dept_airline_name, $dept_flight_no, $dept_airline_abb, $dept_iata_code, $dept_date, $dept_time, $arr_date, $dept_time_part, $arr_time, $dept_date_j, $arr_date_j, $dept_con, $ret_booking_class, $ret_airline_name, $ret_flight_no, $ret_airline_abb, $ret_iata_code, $ret_dept_date, $ret_dept_time, $ret_arr_date, $ret_time_part, $ret_arr_time, $ret_dept_date_j, $ret_arr_date_j, $ret_elaps, $ret_con, $main_adt, $final_adt, $tax_adt, $soto_adt, $quantity_adt, $main_chd, $final_chd, $tax_chd, $soto_chd, $quantity_chd, $main_inf, $final_inf, $tax_inf, $soto_inf, $quantity_inf, $office_name, $sub_system, $address, $index, $CF, $uniqID );
        echo $uniqID;

        //	$idUser=Session::getUserId();
        //	Session::setDetailSession($rel_id,$rec_id,$com_id,$price_id,$address,$CF);
        //	echo true;
    } else {
        echo false;
    }
}


/**
 * checkLoginLocal
 * @return true(1) for yes and false()  for NO
 */
//if ($_POST['flag'] == 'temprory_local') {
//
//
//    $data['OriginAirportIata'] = $_POST['DepartureCode'];
//    $data['OriginCity'] = $_POST['DepartureParentRegionName'];
//    $data['DestiAirportIata'] = $_POST['ArrivalCode'];
//    $data['DestiCity'] = $_POST['ArrivalParentRegionName'];
//    $data['Airline_IATA'] = $_POST['AirlineCode'];
//    $data['AirlineName'] = $_POST['AirlineName'];
//    $data['AircraftCode'] = $_POST['AircraftCode'];
//    $data['FlightNo'] = $_POST['FlightNo'];
//    $data['Date'] = $_POST['PersianDepartureDate'];
//    $data['Time'] = $_POST['DepartureTime'];
//    $data['AdtPrice'] = $_POST['AdtPrice'];
//    $data['ChdPrice'] = $_POST['ChdPrice'];
//    $data['InfPrice'] = $_POST['InfPrice'];
//    $data['SupplierID'] = $_POST['SupplierID'];
//    $data['SupplierName'] = $_POST['SupplierName'];
//    $data['Description'] = $_POST['Description'];
//    $data['SeatClass'] = $_POST['SeatClass'];
//    $data['FlightType'] = $_POST['FlightType'] == "" ? "charter" : "system";
//    $data['SubSystem'] = $_POST['SubSystem'];
//    $data['Capacity'] = $_POST['Capacity'];
//    $data['Adt_qty'] = $_POST['Adt_qty'];
//    $data['Chd_qty'] = $_POST['Chd_qty'];
//    $data['Inf_qty'] = $_POST['Inf_qty'];
//    $data['token_session'] = $_POST['token_session'];
//    $uniqID = microtime(TRUE);
//    $data['uniq_id'] = str_replace('.', '', $uniqID);
//
//    $model = Load::model('temporary_local');
//    $temporaryID = $model->insert_temprory($data);
//
//
//    echo $data['uniq_id'];
//}


/**
 * selectPassenger
 * @param idPass : Passenger ID
 * @return array include information about the passenger , this array send like string
 */ elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'selectPassengerLocal' ) {
    $controller  = Load::controller( 'members' );
    $idPassenger = functions::checkParamsInput( $_POST['idPass'] );



    if ( $idPassenger != '' ) {
        $result = $controller->getInfoPassenger( $idPassenger );

        echo json_encode( $result );
    }
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'getBankData' ) {
    $controller = Load::controller( 'factor' );
    $result     = $controller->getBankData( $_POST['temporaryID'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'signout' || isset( $_GET['flag'] ) && $_GET['flag'] == 'signout') {


    echo $sessionTemplate = Session::getSessionTemplate();
    unset( $_COOKIE['LoginPanel'] );
    Session::Logout();
    Session::setSessionTemplate( $sessionTemplate );


    if ( isset( $_POST['Type'] ) && $_POST['Type'] == 'App' || isset( $_GET['Type'] ) && $_GET['Type'] == 'App') {

        unset( $_COOKIE['Login'] );

        setcookie( 'Login', null, - 1, '/' );
        $Data['LogOut'] = 'Yes';
        echo json_encode( $Data );
    } else {
        return 'success';
    }
    //            echo '<pre>' . print_r($_COOKIE, True) . '</pre>';
} /**
 * ارسال ایمیل فراموشی کلمه عبور
 */ elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'forgetPass' ) {

    $controller = Load::controller( 'members' );

    $email = $_POST['email'];

    if ( $email != '' ) {
        $register = $controller->forgetPassword( $email );
        if ( $register == 'noExist' ) {
            echo functions::Xmlinformation( 'NotExistEmail' );
        } elseif ( $register == 'sendEmail' ) {
            echo functions::Xmlinformation( 'SendLinkEmailRecovery' );
        } else {
            echo functions::Xmlinformation( 'ErrorWhenSendEmail' );
        }
    }
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'PreReserve' ) {

    $controller = Load::library( 'apiLocal' );
    $model      = Load::model( 'temporary_local' );

    $uniq_id       = functions::checkParamsInput( $_POST['uniq_id'] );
    $records       = $model->get( $uniq_id );
    $factor_number = substr( time(), 0, 5 ) . mt_rand( 000, 999 ) . substr( time(), 5, 10 );
    foreach ( $records as $direction => $rec ) {

        $result[ $direction ] = $controller->PreReserveFlight( $rec['token_session'], $direction, $factor_number );

    }

    //    print_r($result);
    if ( isset( $result['dept']['result_status'] ) && $result['dept']['result_status'] == 'PreReserve' && ( empty( $records['return'] ) || ( ! empty( $records['return'] ) && $result['return']['result_status'] == 'PreReserve' ) ) ) {

        $result['total_status'] = 'success';

    } elseif ( isset( $result['TwoWay']['result_status'] ) && $result['TwoWay']['result_status'] == 'PreReserve' ) {
        $result['total_status'] = 'success';
    }elseif ( isset( $result['multi_destination']['result_status'] ) && $result['multi_destination']['result_status'] == 'PreReserve' ) {
        $result['total_status'] = 'success';
    } else {
        $result['total_status']   = 'error';
        $result['result_message'] = $result['result_message'];
    }

    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == "register_memeber" ) {

    $Local = Load::autoload( 'apiLocal' );
    $Local = new apiLocal;
    $Local->registerPassengerOnline();
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'bookFlight' ) {

    $controller = Load::library( 'apiLocal' );
    //    if (isset($_POST['Type']) && $_POST['Type'] == 'App') {

    $jsonRequestNumber = json_decode( functions::clearJsonHiddenCharacters( $_POST['RequestNumber'] ), true );
    $jsonSourceId      = json_decode( functions::clearJsonHiddenCharacters( $_POST['SourceId'] ), true );

    $_POST['RequestNumber'] = $jsonRequestNumber;
    $_POST['SourceId']      = $jsonSourceId;
    //    }


    foreach ( $_POST['RequestNumber'] as $direction => $request_number ) {
        if ( $direction == 'dept' && ($_POST['SourceId'][ $direction ] == '8' || $_POST['SourceId'][ $direction ] == '12') ) {
            $CaptchaCode = $_POST['CaptchaCode'];
        } elseif ( $direction == 'return' && ($_POST['SourceId'][ $direction ] == '8' || $_POST['SourceId'][ $direction ] == '12')) {
            $CaptchaCode = $_POST['CaptchaReturnCode'];
        }elseif($_POST['SourceId'][ $direction ] == '16') {
            $CaptchaCode[0]= $_POST['CaptchaCode'];
            $CaptchaCode[1]= $_POST['CaptchaReturnCode'];
        }

        $result[ $direction ] = $controller->bookFlightPassenger( $request_number, $_POST['IdMember'], ( ! empty( $_POST['SourceId'][ $direction ] ) ? $_POST['SourceId'][ $direction ] : '' ), $CaptchaCode );

    }
    if ( isset( $result['dept']['result_status'] ) && $result['dept']['result_status'] == 'SuccessMethodBook' && ( empty( $_POST['RequestNumber']['return'] ) || ( ! empty( $_POST['RequestNumber']['return'] ) && $result['return']['result_status'] == 'SuccessMethodBook' ) ) ) {
        $result['total_status'] = 'success';

    }
    elseif ( isset( $result['TwoWay'] ) && $result['TwoWay']['result_status'] == 'SuccessMethodBook' ) {
        $result['total_status'] = 'success';
    }
    elseif ( isset( $result['multi_destination'] ) && $result['multi_destination']['result_status'] == 'SuccessMethodBook' ) {
        $result['total_status'] = 'success';
    }
    else {
        $result['total_status'] = 'error';
    }

    $result = functions::clearJsonHiddenCharacters( json_encode( $result ) );

    echo $result;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == "revalidate_Fight" ) {

    $Local = Load::library( 'apiLocal' );

    echo $Local->Revalidate();
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'delete_agency' ) {
    $agency = Load::controller( 'agency' );
    echo $agency->delete_agency( $_POST['id'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insert_agency' ) {

    unset( $_POST['flag'] );
    unset( $_POST['confirmPass'] );

    $agency = Load::controller( 'agency' );
    echo $agency->insert_agency( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'update_agency' ) {
    unset( $_POST['flag'] );

    /** @var agency $agency */
    $agency = Load::controller( 'agency' );
    echo $agency->edit_agency($_POST);
    exit();
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'agencyAdd' ) {

    unset( $_POST['flag'] );
    unset( $_POST['confirmPass'] );
    unset( $_POST['logoText'] );
    unset( $_POST['licenseText'] );
    unset( $_POST['newspaperText'] );
    unset( $_POST['heck_list1'] );

    $name   = $_POST['managerName'];
    $family = $_POST['managerFamily'];

    unset( $_POST['managerName'] );
    unset( $_POST['managerFamily'] );

    $agencyData  = $_POST;
    $counterData = $_POST;

    $agencyData['payment'] = 'cash';
    $agencyData['manager'] = $name . ' ' . $family;
    $agencyData['bank_data'] = json_encode($_POST['bank_data']);
    $agencyData['hasSite'] = 0;
    $agencyData['isColleague'] = 1;
    $agencyData['type_payment'] = 1;
    $agencyData['language'] = 'fa';
    /**@var $agency agency*/
    $agency          = Load::controller( 'agency' );
    /**@var $agency agency*/
    $agency_model         = Load::model( 'agency' );
    $agencyAddResult = $agency->insert_agency( $agencyData );

    if ( $agencyAddResult ) {

        $agencyID = $agency_model->getLastId();

        $counterData['name']        = $name;
        $counterData['family']      = $family;
        $counterData['typeCounter'] = '1';
        $counterData['agency_id']   = $agencyID;

        $members          = Load::controller( 'members' );
        $counterAddResult = $members->addCounter( $counterData );

        if ( strpos( $counterAddResult, 'success' ) !== false ) {

            $login = $members->memberLogin( $counterData['email'], $counterData['password'], 'off' , 0 , false );
            echo 'success:' . functions::Xmlinformation( 'SuccessRegisterUser' );

        } else {

            $agencyController = Load::controller( 'agency' );
            $agencyController->delete_agency( $agencyID );

            echo $counterAddResult;
        }

    } else {
        echo $agencyAddResult;
    }
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insert_credit' ) {

    unset( $_POST['flag'] );
    $credit_detail = Load::controller( 'creditDetail' );
    $credit_detail->insert_credit( $_POST );
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insert_user_wallet' ) {

    unset( $_POST['flag'] );
    $credit_detail = Load::controller( 'memberCredit' );
    $credit_detail->insert_user_wallet( $_POST );
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insert_countre_type' ) {
    unset( $_POST['flag'] );
    $credit_detail = Load::controller( 'counterType' );

    $credit_detail->insert( $_POST['name'] );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'EditCounterType' ) {
    unset( $_POST['flag'] );
    $credit_detail = Load::controller( 'counterType' );

    $credit_detail->update( $_POST );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'delete_counter' ) {
    $members = Load::controller( 'members' );
    $members->delete_counter( $_POST['id'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'convert_counter' ) {
    $members = Load::controller( 'members' );
    $res     = $members->convert_counter( $_POST['id'] );

    if ( $res ) {
        echo 'success : تغییر وضعیت کانتر به مسافر آنلاین با موفقیت انجام شد';
    } else {
        echo 'error :  خطا در تغییر وضعیت کانتر به مسافر آنلاین ';

    }
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'delete_user_list' ) {
    $members = Load::controller( 'members' );
    $members->delete_user_list( $_POST['id'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insert_counter' ) {
    unset( $_POST['flag'] );
    /** @var members $members */
    $members = Load::controller( 'members' );
    echo $members->addCounter( $_POST );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'update_counter' ) {
    unset( $_POST['flag'] );
    /** @var members $members */
    $members = Load::controller( 'members' );
    echo $members->updateCounter( $_POST );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'update_counter_bank_detail' ) {
    unset( $_POST['flag'] );
    $members = Load::controller( 'members' );
    $members->updateBankCounter( $_POST );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insert_user' ) {
    unset( $_POST['flag'] );
    $members = Load::controller( 'members' );
    $members->addUser( $_POST );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'update_user' ) {
    unset( $_POST['flag'] );
    $members = Load::controller( 'members' );
    $members->editUser( $_POST );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'update_user_bank_detail' ) {
    unset( $_POST['flag'] );
    $members = Load::controller( 'members' );
    $members->editUserBankDetail( $_POST );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'active_counter' ) {
    $members = Load::controller( 'members' );
    $members->active_counter( $_POST['id'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'active_user' ) {
    $members = Load::controller( 'members' );
    $members->active_user( $_POST['id'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'ActiveAsCounter' ) {
    unset( $_POST['flag'] );
    $members = Load::controller( 'members' );
    echo $members->ActiveAsCounter( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'delete_passenger' ) {
    $passenger = Load::controller( 'passengers' );
    $passenger->delete_passenger( $_POST['id'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'PassengersUpdate' ) {
    unset( $_POST['flag'] );
    $passengerController = Load::controller( 'passengers' );
    $result              = $passengerController->update( $_POST );
    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'PassengersUpdateModal' ) {
    unset( $_POST['flag'] );
    $passengerController = Load::controller( 'passengers' );
    $result              = $passengerController->clientUpdate( $_POST ['data'] );
    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'PassengersAdd' ) {
    unset( $_POST['flag'] );

    $passengerController = Load::controller( 'passengers' );
    $result              = $passengerController->insert( $_POST );
    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'UpdateUser' ) {
    unset( $_POST['flag'] );
    $UserController = Load::controller( 'user' );
    $result         = $UserController->UpdateUser( $_POST );
    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'SubmitNewComment' ) {
    unset( $_POST['flag'] );
    $passengerController = Load::controller( 'comments' );
    $result              = $passengerController->insertComment( $_POST );
    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'GetOneComment' ) {
    unset( $_POST['flag'] );
    $passengerController = Load::controller( 'comments' );
    $result              = $passengerController->getOneComment( $_POST );
    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'EditCommentValidate' ) {
    unset( $_POST['flag'] );
    $passengerController = Load::controller( 'comments' );
    $result              = $passengerController->EditCommentValidate( $_POST );
    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insert_accountcharge' ) {
    $insert_accountcharge = Load::controller( 'accountcharge' );
    $data['Price'] = str_replace(',', '', $_POST['Price']);
    $data['Comment']      = $_POST['Comment'];
    $data['Reason']       = $_POST['Reason'];

    if ( $data['Reason'] == "charge" || $data['Reason'] == "increase" || $data['Reason'] == "diff_price" ) {
        $data['Status'] = '1';
    } else if ( $data['Reason'] == "decrease" || $data['Reason'] == "indemnity_edit_ticket" ) {
        $data['Status'] = '2';
    }

    echo $insert_accountcharge->insert( $data, $_POST['ClientId'] );

}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insert_providercharge' ) {

    $insert_accountcharge = Load::controller( 'transactions' );
    $data['Price'] = str_replace(',', '', $_POST['Price']);
    $data['Comment']      = $_POST['Comment'];
    $data['Reason']       = $_POST['Reason'];
    $data['sourceType']       = $_POST['sourceType'];

    if ( $data['Reason'] == "charge" || $data['Reason'] == "increase" || $data['Reason'] == "diff_price" ) {
        $data['Status'] = '1';
    } else if ( $data['Reason'] == "decrease" || $data['Reason'] == "indemnity_edit_ticket" ) {
        $data['Status'] = '2';
    }

    echo $insert_accountcharge->insertProviderTransaction( $data, $_POST['api_id'] );

}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'check_credit' ) {


    unset( $_POST['flag'] );

    $apiLocal          = Load::library( 'apiLocal' );
    $bookLocal         = Load::model( 'book_local' );
    /** @var transaction $objTransaction */
    $objTransaction    = Load::controller( 'transaction' );
    $checkBankIranTech = functions::CheckGetWayIranTech( CLIENT_ID );


    if ( isset( $_POST['type'] ) && $_POST['type'] == 'App' ) {
        if ( isset( $_POST['RequestNumberDept'] ) && ! empty( $_POST['RequestNumberDept'] ) ) {
            $_POST['RequestNumber']['dept'] = $_POST['RequestNumberDept'];
        }

        if ( isset( $_POST['RequestNumberReturn'] ) && ! empty( $_POST['RequestNumberReturn'] ) ) {
            $_POST['RequestNumber']['return'] = $_POST['RequestNumberReturn'];
        }

        if ( isset( $_POST['RequestNumberTwoWay'] ) && ! empty( $_POST['RequestNumberTwoWay'] ) ) {
            $_POST['RequestNumber']['TwoWay'] = $_POST['RequestNumberTwoWay'];
        }


        if ( isset( $_POST['RequestNumberTwoWay'] ) && ! empty( $_POST['RequestNumberTwoWay'] ) ) {
            $_POST['RequestNumber']['multi_destination'] = $_POST['RequestNumbermulti_destination'];
        }

        if ( isset( $_POST['ServiceTypeDept'] ) && ! empty( $_POST['ServiceTypeDept'] ) ) {
            $_POST['ServiceTyp']['dept'] = $_POST['ServiceTypeDept'];
        }

        if ( isset( $_POST['ServiceTypeReturn'] ) && ! empty( $_POST['ServiceTypeReturn'] ) ) {
            $_POST['ServiceTyp']['return'] = $_POST['ServiceTypeReturn'];
        }
        if ( isset( $_POST['RequestNumberTwoWay'] ) && ! empty( $_POST['RequestNumberTwoWay'] ) ) {
            $_POST['ServiceTyp']['TwoWay'] = $_POST['RequestNumberTwoWay'];
        }

        if ( isset( $_POST['RequestNumbermulti_destination'] ) && ! empty( $_POST['RequestNumbermulti_destination'] ) ) {
            $_POST['ServiceTyp']['multi_destination'] = $_POST['RequestNumbermulti_destination'];
        }
    }

    $total_price           = 0;
    $TicketPriceBank       = 0;
    $comment               = '';
    $factorNumber          = '';
    $commentIranTechCharge = '';
    foreach ( $_POST['RequestNumber'] as $direction => $request_number ) {

        $reserveInfo  = $bookLocal->GetInfoBookLocal( $request_number );
        $factorNumber = $reserveInfo['factor_number'];


        $prices = $objTransaction->calculateTransactionPrice( $request_number );

        functions::insertLog( 'exist $prices=> ' . $request_number .' request_number ' .  json_encode($prices, 256 | 64)  , 'error_transaction' );

        if($direction=='multi_destination'){
            $count_direction = 'چند مسیره';
        }
        elseif(count($_POST['RequestNumber']) > 1){
            $count_direction = 'دو طرفه';
        }
        else{
            $count_direction="";
        }
        if ( $direction == 'dept' || $direction == 'TwoWay'  || $direction=='multi_destination') {
            $comment = "خرید" . " " . $reserveInfo['count_id'] . " عدد بلیط " . $count_direction . " هواپیما از" . " " . $reserveInfo['origin_city'] . " به" . " " . $reserveInfo['desti_city'] . " " . "به شماره رزرو ";
        }
        if ( $checkBankIranTech && isset($_POST['selectedBank']) && $_POST['selectedBank'] == 'publicBank') {
            $TicketPriceBank += functions::CalculateDiscount( $request_number, 'yes');

            $commentIranTechCharge .= ' ' . $request_number . $prices['pidTitle'];
        }


        $total_price += $prices['transactionPrice'];
        $comment     .= ' ' . $request_number . $prices['pidTitle'];


    }
    functions::insertLog( 'exist transaction=> ' . $factorNumber .PHP_EOL, 'error_transaction' );

    $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );

    functions::insertLog( 'exist transaction=> ' . json_encode($existTransaction, 256 | 64) .PHP_EOL, 'error_transaction' );


    if ( empty( $existTransaction ) ) {
        // Caution: اعتبارسنجی صاحب سیستم
        $check = $objTransaction->checkCreditNew( $total_price, 'online' ,'',$TicketPriceBank , $_POST['selectedBank']);
        if ( $check['status'] == 'TRUE' || ( isset( $_POST['privateGetWayCharter724'] ) && ! empty( $_POST['privateGetWayCharter724'] ) ) ) {

            $reason = 'buy';
            if ( $checkBankIranTech && isset($_POST['selectedBank']) && $_POST['selectedBank'] == 'publicBank' && ( ( ! isset( $_POST['privateGetWayCharter724'] ) && empty( $_POST['privateGetWayCharter724'] ) ) ) ) {

                $commentIranTech = 'شارژ درگاه سفر360 برای خرید به شماره رزرو ' . $commentIranTechCharge . 'از این درگاه ';
                functions::insertLog( 'in GetWayIranTech With factorNumber=>' . $factorNumber . ' has Amount Ticket=>' . $TicketPriceBank, 'iranTechGetWayBuy' );
                // در صورتی که از درگاه ایران تک استفاده میشد،یک رکورد بابت شارژ به اندازه هزینه بلیط زده میشه به صورت موقت و در برگشت از بانک در صورت موفقیت اوکی میشه
                $objTransaction->InsertChargeThrowIranTechGetWay( $TicketPriceBank, $factorNumber, $commentIranTech );
                sleep( 1 );
            }
            // Caution: کاهش اعتبار موقت صاحب سیستم
            $reduceTransaction = $objTransaction->decreasePendingCredit( $total_price, $factorNumber, $comment, $reason );

            if ( $reduceTransaction ) {
                $output = 'TRUE';
            } else {
                $output = 'FALSE';
            }

        } else {

            $output = $check['status'].'-'.json_encode($check);
        }

    } else {
        $output = 'Empty Transaction FALSE';
    }

    if ( isset( $_POST['type'] ) && $_POST['type'] == 'App' ) {
        $result['creditStatus'] = $output;
        $resultCredit           = functions::clearJsonHiddenCharacters( json_encode( $result, true ) );
        echo $resultCredit;
    } else {

        echo $output;
    }
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'check_credit_exclusive_tour' ) {
    unset( $_POST['flag'] );

    $bookModel = Load::getModel('exclusiveTourModel');
    $objTransaction    = Load::controller( 'transaction' );

    $total_price           = 0;
    $TicketPriceBank       = 0;
    $comment               = '';
    $factorNumber          = '';
    $request_number = $_POST['requestNumber'];


    $reserveInfo  = $bookModel->getOneByReq($request_number);
    $factorNumber = $reserveInfo[0]['factor_number'];

    $prices = $reserveInfo[0]['total_price'];

    $comment = "خرید تور از " . $reserveInfo[0]['origin_city'] . " به" . " " . $reserveInfo[0]['desti_city'] . " " . "به شماره رزرو ";

    $total_price += $prices;
    $comment     .= ' ' . $request_number;

    $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );


    if ( empty( $existTransaction ) ) {
        // Caution: اعتبارسنجی صاحب سیستم
        $check = $objTransaction->checkCreditNew( $total_price, 'online' ,'', $total_price , $_POST['selectedBank']);
        if ( $check['status'] == 'TRUE' ) {

            $reason = 'buy';
            // Caution: کاهش اعتبار موقت صاحب سیستم
            $reduceTransaction = $objTransaction->decreasePendingCredit( $total_price, $factorNumber, $comment, $reason );

            if ( $reduceTransaction ) {
                $output = 'TRUE';
            } else {
                $output = 'FALSE';
            }

        } else {

            $output = $check['status'].'-'.json_encode($check);
        }

    } else {
        $output = 'Empty Transaction FALSE';
    }

    if ( isset( $_POST['type'] ) && $_POST['type'] == 'App' ) {
        $result['creditStatus'] = $output;
        $resultCredit           = functions::clearJsonHiddenCharacters( json_encode( $result, true ) );
        echo $resultCredit;
    } else {
        echo $output;
    }
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'check_credit_cip' ) {
    unset( $_POST['flag'] );

    $bookModel = Load::getModel('cipModel');
    $objTransaction    = Load::controller( 'transaction' );

    $total_price           = 0;
    $TicketPriceBank       = 0;
    $comment               = '';
    $factorNumber          = '';
    $request_number = $_POST['requestNumber'];


    $reserveInfo  = $bookModel->getOneByReq($request_number);
    $factorNumber = $reserveInfo[0]['factor_number'];


    $prices = $reserveInfo[0]['total_price'];

    $comment = "خرید تشریفات فرودگاه "
        . $reserveInfo[0]['cip_name']
        . " به شماره رزرو "
        . $reserveInfo[0]['reserve_number'];

    $total_price += $prices;
    $comment     .= ' ' . $request_number;

    $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );



    if ( empty( $existTransaction ) ) {
        // Caution: اعتبارسنجی صاحب سیستم
        $check = $objTransaction->checkCreditNew( $total_price, 'online' ,'', $total_price , $_POST['selectedBank']);
        if ( $check['status'] == 'TRUE' ) {

            $reason = 'buy';
            // Caution: کاهش اعتبار موقت صاحب سیستم
            $reduceTransaction = $objTransaction->decreasePendingCredit( $total_price, $factorNumber, $comment, $reason );


            if ( $reduceTransaction ) {
                $output = 'TRUE';
            } else {
                $output = 'FALSE';
            }

        } else {

            $output = $check['status'].'-'.json_encode($check);
        }

    } else {
        $output = 'Empty Transaction FALSE';
    }

    if ( isset( $_POST['type'] ) && $_POST['type'] == 'App' ) {
        $result['creditStatus'] = $output;
        $resultCredit           = functions::clearJsonHiddenCharacters( json_encode( $result, true ) );
        echo $resultCredit;
    } else {
        echo $output;
    }


}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'buyByCreditLocal' ) {


    $Model                 = Load::library( 'Model' );
    $apiLocal              = load::library( 'apiLocal' );
    $bookLocal             = Load::model( 'book_local' );
    /** @var transaction $objTransaction */
    $objTransaction        = Load::controller( 'transaction' );
    $objMember             = Load::controller( 'members' );
    $privateCharterSources = functions::privateCharterFlights();
    $info_member           = functions::infoAgencyByMemberId(Session::getUserId());
    // Caution: اعتبار همکار(آژانس همکار با صاحب پنل ) که ممکنه  خود صاحب سیستم باشد یا همکار دیگری که کانتری که خرید میکند شامل این همکار است
    $counterCredit = $objMember->getCredit();

    $total_amount = 0;
    $total_amount_counter = array();


    foreach ( $_POST['RequestNumber'] as $direction => $request_number ) {

        $amount[ $direction ] = functions::CalculateDiscount( $request_number, 'yes' );
        $total_amount         += $amount[ $direction ];
        $total_amount_counter[$direction]        = $amount[ $direction ];
    }

    if($info_member['type_payment'] == 'currency')
    {
        $amount_currency = functions::CurrencyCalculate($total_amount);
        $total_amount = $amount_currency['AmountCurrency'] ;
    }



    // Caution: اعتبارسنجی اعتبار کانتر
    if ( $counterCredit > $total_amount ) {
        $total_price = 0;
        foreach ( $_POST['RequestNumber'] as $direction => $request_number ) {
            $reserveInfo[ $direction ] = $bookLocal->GetInfoBookLocal( $request_number );

            if ( $direction == 'dept' || $direction == 'TwoWay' || $direction == 'multi_destination' ) {
                $factorNumber = $reserveInfo[ $direction ]['factor_number'];
                $comment      = "خرید" . " " . $reserveInfo[ $direction ]['count_id'] . " عدد بلیط " . ( count( $_POST['RequestNumber'] ) > 1 ? "دو طرفه" : "" ) . " هواپیما از" . " " . $reserveInfo[ $direction ]['origin_city'] . " به" . " " . $reserveInfo[ $direction ]['desti_city'] . " " . "به شماره رزرو ";
            }

            $prices = $objTransaction->calculateTransactionPrice( $request_number );

            $total_price += $prices['transactionPrice'];

            $comment     .= ' ' . $request_number . $prices['pidTitle'];
            if($info_member['type_payment'] == 'currency')
            {
                $amount_currency_counter = functions::CurrencyCalculate($total_amount_counter[$direction]);
                $total_amount_counter[$direction] = $amount_currency_counter['AmountCurrency'] ;
            }
//            echo "1";
//            echo "<br>";
//        var_dump($total_amount_counter[$direction]);
//        echo "2";
//            echo "<br>";
//        var_dump($request_number);
//        echo "3";
//            echo "<br>";
//        var_dump($reserveInfo[ $direction ]);
//        var_dump('ggg');
//        die;
            // Caution: کاهش اعتبار کانتر
            $objMember->decreaseCounterCredit( $total_amount_counter[$direction], $request_number, $reserveInfo[ $direction ], '' );

        }

        $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );
        if ( empty( $existTransaction ) ) {
            // Caution: اعتبارسنجی صاحب سیستم
            $check = $objTransaction->checkCredit( $total_price );
            if ( $check['status'] == 'TRUE' ) {

                //set buy status to credit
                $bookLocal->updateToCredit( $factorNumber );

                // Caution: کاهش اعتبار صاحب سیستم
                $reduceTransaction = $objTransaction->decreaseSuccessCredit( $total_price, $factorNumber, $comment, 'buy' );

                if ( $reduceTransaction ) {
                    echo 'success:' . $total_amount;
                } else {
                    echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCredit' );
                }

            } else {
                echo 'error:' . functions::Xmlinformation( 'ChargeRialSystem' );
            }

        } else {
            echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCreditByFactorNumber' );
        }
    }
    else {
        echo 'error: ' . functions::Xmlinformation( 'EndCreditAgency' );
    }
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'buyByCreditExclusiveTour' ) {


    $bookModel = Load::getModel('exclusiveTourModel');
    $objTransaction        = Load::controller( 'transaction' );
    $objMember             = Load::controller( 'members' );
    $info_member           = functions::infoAgencyByMemberId(Session::getUserId());
    // Caution: اعتبار همکار(آژانس همکار با صاحب پنل ) که ممکنه  خود صاحب سیستم باشد یا همکار دیگری که کانتری که خرید میکند شامل این همکار است
    $counterCredit = $objMember->getCredit();

    $request_number = $_POST['requestNumber'];
    $reserveInfo  = $bookModel->getOneByReq($request_number);
    $factorNumber = $reserveInfo[0]['factor_number'];




    $total_amount = $reserveInfo[0]['total_price'];

    // Caution: اعتبارسنجی اعتبار کانتر
    if ( $counterCredit > $total_amount ) {

        $comment = "خرید تور از " . $reserveInfo[0]['origin_city'] . " به" . " " . $reserveInfo[0]['desti_city'] . " " . "به شماره رزرو ";
        $comment     .= ' ' . $request_number;

        // Caution: کاهش اعتبار کانتر
        $objMember->decreaseCounterCredit( $total_amount, $request_number, $reserveInfo, 'exclusiveTour' );


        $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );
        if ( empty( $existTransaction ) ) {
            // Caution: اعتبارسنجی صاحب سیستم
            $check = $objTransaction->checkCredit( $total_amount );
            if ( $check['status'] == 'TRUE' ) {

                //set buy status to credit
                $bookModel->updateToCredit( $factorNumber );

                // Caution: کاهش اعتبار صاحب سیستم
                $reduceTransaction = $objTransaction->decreaseSuccessCredit( $total_amount, $factorNumber, $comment, 'buy' );

                if ( $reduceTransaction ) {
                    echo 'success:' . $total_amount;
                } else {
                    echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCredit' );
                }

            } else {
                echo 'error:' . functions::Xmlinformation( 'ChargeRialSystem' );
            }

        } else {
            echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCreditByFactorNumber' );
        }
    }
    else {
        echo 'error: ' . functions::Xmlinformation( 'EndCreditAgency' );
    }
}

elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'buyByCip' ) {


    $bookModel = Load::getModel('cipModel');
    $objTransaction        = Load::controller( 'transaction' );
    $objMember             = Load::controller( 'members' );
    $info_member           = functions::infoAgencyByMemberId(Session::getUserId());
    // Caution: اعتبار همکار(آژانس همکار با صاحب پنل ) که ممکنه  خود صاحب سیستم باشد یا همکار دیگری که کانتری که خرید میکند شامل این همکار است
    $counterCredit = $objMember->getCredit();

    $request_number = $_POST['requestNumber'];
    $reserveInfo  = $bookModel->getOneByReq($request_number);
    $factorNumber = $reserveInfo[0]['factor_number'];




    $total_amount = $reserveInfo[0]['total_price'];

    // Caution: اعتبارسنجی اعتبار کانتر
    if ( $counterCredit > $total_amount ) {

        $comment = "خرید تشریفات فرودگاه "
            . $reserveInfo[0]['cip_name']
            . " به شماره رزرو "
            . $reserveInfo[0]['reserve_number'];
        $comment     .= ' ' . $request_number;

        // Caution: کاهش اعتبار کانتر
        $objMember->decreaseCounterCredit( $total_amount, $request_number, $reserveInfo, 'cip' );


        $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );
        if ( empty( $existTransaction ) ) {
            // Caution: اعتبارسنجی صاحب سیستم
            $check = $objTransaction->checkCredit( $total_amount );
            if ( $check['status'] == 'TRUE' ) {

                //set buy status to credit
                $bookModel->updateToCredit( $factorNumber );

                // Caution: کاهش اعتبار صاحب سیستم
                $reduceTransaction = $objTransaction->decreaseSuccessCredit( $total_amount, $factorNumber, $comment, 'buy_cip' );

                if ( $reduceTransaction ) {
                    echo 'success:' . $total_amount;
                } else {
                    echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCredit' );
                }

            } else {
                echo 'error:' . functions::Xmlinformation( 'ChargeRialSystem' );
            }

        } else {
            echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCreditByFactorNumber' );
        }
    }
    else {
        echo 'error: ' . functions::Xmlinformation( 'EndCreditAgency' );
    }
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == "select_Airport" ) {
    $Local    = load::library( 'apiLocal' );
    $airports = $Local->getAirport( $_POST['Departure'] );

    echo '<option value="">' . functions::Xmlinformation( 'SelectChoseOption' ) . '</option>';

    $airport_arival_name='Arrival_City';
    if((isset($_POST['language']) && !empty($_POST['language'])) && $_POST['language'] != 'fa'){
        $airport_arival_name='Arrival_CityEn';
    }

    foreach ( $airports as $airport_arival ) {
        echo '<option value="' . $airport_arival['Arrival_Code'] . '">' . $airport_arival[$airport_arival_name] . '(' . $airport_arival['Arrival_Code'] . ')</option>';
    }
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'bank_active' ) {
    $bankList = Load::controller( 'bankList' );
    echo $bankList->bankActive( $_POST );
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'bank360_active' ) {
    $bankList = Load::controller( 'bankList' );
    echo $bankList->bank360Active( $_POST );
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'logoute' ) {

    $logoute = Load::controller( 'admin' );
    echo $logoute->logoute();
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insert_bank' ) {
    $bankList = Load::controller( 'bankList' );
    unset( $_POST['flag'] );

    echo $bankList->InsertInfoBank( $_POST );

}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'editBank' ) {
    $bankList = Load::controller( 'bankList' );
    unset( $_POST['flag'] );
    echo $bankList->UpdateInfoBank( $_POST );

}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insert_client' ) {


    $partner = Load::controller( 'partner' );
    unset( $_POST['flag'] );
    echo $partner->InsertClient( $_POST );

}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'client_flight_data' ) {

    unset( $_POST['flag'] );
    if($_POST['type'] == 'flight') {
        $controller = Load::library( 'apiLocal' );
        echo $controller->clientFlightData( $_POST );
    }else if($_POST['type'] == 'hotel') {
        $controller = Load::library( 'ApiHotelCore' );
        echo $controller->clientHotelData( $_POST );
    }else if($_POST['type'] == 'bus') {
        $controller = Load::library( 'apiBus' );
        echo $controller->clientBusData( $_POST );
    }


} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'update_client' ) {

    $partner = Load::controller( 'partner' );
    unset( $_POST['flag'] );
    echo $partner->UpdateClient( $_POST );

}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'updateDocs' ) {

    $visa = Load::controller( 'visa' );
    unset( $_POST['flag'] );
    echo $visa->UpdateDocs( $_POST );

}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'updateStep' ) {

    $visa = Load::controller( 'visa' );
    unset( $_POST['flag'] );
    echo $visa->updateStep( $_POST );

}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insert_airline' ) {
    $airline = Load::controller( 'airline' );
    unset( $_POST['flag'] );

    echo $airline->InsertAirline( $_POST );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'update_airline' ) {
    $airline = Load::controller( 'airline' );
    unset( $_POST['flag'] );
    echo $airline->UpdateAirline( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'StatusAirline' ) {

    $airline = Load::controller( 'airline' );
    unset( $_POST['flag'] );
    echo $airline->ChangeStatus( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'bankAccountCharge' ) {

    $amount = filter_var( $_POST['amount'], FILTER_SANITIZE_NUMBER_INT );
    //    functions::goToBankPasargadIranTech(CLIENT_NAME);
    if ( $amount >= '20000000' ) {
        functions::goToBankPasargadIranTech( CLIENT_NAME );
    } else {
        echo 'Error##@@مبلغ شارژ کمتر از 20,000,0000  ریال نمی تواند باشد';
    }

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'delete_price_change' ) {

    $PriceChange = Load::controller( 'PriceChange' );
    echo $PriceChange->DeletePriceChange( $_POST['id'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insert_change_price' ) {

    $PriceChange = Load::controller( 'PriceChange' );
    unset( $_POST['flag'] );
    echo $PriceChange->InsertChangePrice( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'PriceChangeStatus' ) {

    $PriceChange = Load::controller( 'PriceChange' );
    echo $PriceChange->UpdateStatus( $_POST['id'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'ChangePassword' ) {

    unset( $_POST['flag'] );
    $admin = Load::controller( 'admin' );
    echo $admin->changePassword( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'ChangePass' ) {

    unset( $_POST['flag'] );
    $controller = Load::controller( 'user' );
    echo $controller->changePassword( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'changeSort' ) {

    unset( $_POST['flag'] );
    $resultLocal = Load::controller( 'resultLocal' );
    echo $resultLocal->getTicketList( $_POST['sort_val'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insert_identity' ) {
    $Identity = Load::controller( 'Identity' );


    unset( $_POST['flag'] );

    echo $Identity->IdentityInsert( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'StatusPid' ) {

    $airline = Load::controller( 'airline' );
    unset( $_POST['flag'] );
    echo $airline->changeStatusPid( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'trackingInfo' ) {

    //    functions::displayErrorLog('online.railtour.ir');
    unset( $_POST['flag'] );
    /*if ($_POST['typeSearch'] == 'flight') {
        $bookshow = Load::controller('bookshow');
        echo $bookshow->TrackingInfo($_POST);
    } elseif ($_POST['typeSearch'] == 'hotel') {
        $bookshow = Load::controller('bookhotelshow');
        echo $bookshow->hotelInfoTracking($_POST['request_number']);
    } elseif ($_POST['typeSearch'] == 'europcar') {
        $bookshow = Load::controller('bookEuropcarShow');
        echo $bookshow->bookInfoTracking($_POST['request_number']);
    } elseif ($_POST['typeSearch'] == 'insurance') {
        $bookshow = Load::controller('bookingInsurance');
        echo $bookshow->insuranceInfoTracking($_POST['request_number']);
    } elseif ($_POST['typeSearch'] == 'tour') {
        $bookshow = Load::controller('bookTourShow');
        echo $bookshow->tourInfoTracking($_POST['request_number']);
    } elseif ($_POST['typeSearch'] == 'visa') {
        $bookshow = Load::controller('bookingVisa');
        echo $bookshow->visaInfoTracking($_POST['request_number']);
    }*/

    switch ( $_POST['typeSearch'] ) {

        case 'flight':
            /** @var \bookshow $bookshow */
            $bookshow = Load::controller( 'bookshow' );
            $result   = trim($bookshow->TrackingInfo( $_POST ));
            break;
        case 'hotel':
            /** @var \bookhotelshow $bookhotelshow */
            $bookhotelshow = Load::controller( 'bookhotelshow' );
            $result        = $bookhotelshow->hotelInfoTracking( $_POST['request_number'] );
            break;
        case 'europcar':
            /** @var \bookEuropcarShow $bookEuropcarShow */
//			$bookEuropcarShow = Load::controller( 'bookEuropcarShow' );
//			$result           = $bookEuropcarShow->bookInfoTracking( $_POST['request_number'] );
            $rentCar = Load::controller( 'rentCar' );
            $result = $rentCar->rentCarTracking( $_POST['request_number'] );
            break;
        case 'insurance':
            $bookshow = Load::controller( 'bookingInsurance' );
            $result   = $bookshow->insuranceInfoTracking( $_POST['request_number'] );
            break;
        case 'tour':
            /** @var \bookTourShow $bookTourShow */
            $bookTourShow = Load::controller( 'bookTourShow' );
            $result       = $bookTourShow->tourInfoTracking( $_POST['request_number'] );
            break;
        case 'visa':
            /** @var \bookingVisa $bookingVisa */
            $bookingVisa = Load::controller( 'bookingVisa' );
            $result   = $bookingVisa->visaInfoTracking( $_POST['request_number'] );
            break;
        case 'bus':
            /** @var \bookingBusShow $bookingBusShow */
            $bookingBusShow = Load::controller( 'bookingBusShow' );
            $result   = $bookingBusShow->busInfoTracking( $_POST['request_number'] );
            break;
        case 'entertainment':
            /** @var \entertainment $entertainment */
            $entertainment = Load::controller( 'entertainment' );
            $result   = $entertainment->entertainmentInfoTracking( $_POST['request_number'] );
            break;
        case 'train':
            /** @var \trainBooking $trainBooking */
            $trainBooking = Load::controller( 'trainBooking' );
            $result   = $trainBooking->infoTrainTicket( $_POST['request_number'] );
            break;
        default:
            $result = '';
            break;
    }

    echo   !empty($result) ? trim($result) : '';


} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'RecoveryPass' ) {

    /** @var members $members */
    $members = Load::controller( 'members' );
    unset( $_POST['flag'] );
    echo $members->forgetPassword( $_POST['email'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'RecoveryPassCheckCode' ) {

    $members = Load::controller( 'members' );
    unset( $_POST['flag'] );
    echo $members->forgetPassCheckCode( $_POST['code'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'ChangePassRecovery' ) {
    $members = Load::controller( 'members' );
    unset( $_POST['flag'] );
    echo $members->recoverPass( $_POST['key'], $_POST['new_pass'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'SendEmailForOther' ) {
    $members = Load::controller( 'members' );
    unset( $_POST['flag'] );
    $result = $members->SendEmailForOther( $_POST['email'], $_POST['request_number'], $_POST['ClientID'] );
    echo $result;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'SendTrainEmailForOther' ) {
    $members = Load::controller( 'members' );
    unset( $_POST['flag'] );
    echo $members->SendTrainEmailForOther( $_POST['email'], $_POST['request_number'], $_POST['ClientID'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'RequestCancelUser' ) {
    $listCancel = Load::controller( 'listCancel' );
    unset( $_POST['flag'] );
    echo $listCancel->SetRequestCancelUser( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'ConfirmCancelByAgency' ) {
    $listCancel = Load::controller( 'listCancelUser' );
    unset( $_POST['flag'] );
    echo $listCancel->ConfirmCancelByAgency( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'FailedCancelByAgency' ) {
    $listCancel = Load::controller( 'listCancelUser' );
    unset( $_POST['flag'] );
    echo $listCancel->FailedCancelByAgency( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'SendPercentForAgency' ) {

    $listCancel = Load::controller( 'listCancel' );
    unset( $_POST['flag'] );
    echo $listCancel->SendPercentForAgency( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'UserSendPercentForAgency' ) {

    $listCancel = Load::controller( 'listCancelUser' );
    unset( $_POST['flag'] );
    echo $listCancel->UserSendPercentForAgency( $_POST );
}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'setTicketClose' ) {

    $listCancel = Load::controller( 'listCancel' );
    unset( $_POST['flag'] );
    echo $listCancel->setTicketClose( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'ConfirmAgencyForPercent' ) {

    /** @var listCancelUser $listCancel */
    $listCancel = Load::controller( 'listCancelUser' );
    unset( $_POST['flag'] );
    echo $listCancel->ConfirmAgencyForPercent( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'FailedAgencyForPercent' ) {

    /** @var listCancelUser $listCancel */
    $listCancel = Load::controller( 'listCancelUser' );
    unset( $_POST['flag'] );
    echo $listCancel->FailedAgencyForPercent( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'SendPriceForCalculate' ) {
    /** @var listCancel $listCancel */
    $listCancel = Load::controller( 'listCancel' );
    unset( $_POST['flag'] );
    echo $listCancel->SendPriceForCalculate( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'ConfirmPercentAndPricePrivate' ) {

    /** @var listCancelUser $listCancelUser */
    $listCancelUser = Load::controller( 'listCancelUser' );
    unset( $_POST['flag'] );
    echo $listCancelUser->ConfirmPercentAndPricePrivate( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'done_private' ) {

    /** @var bookshow $bookshow */
    $bookshow = Load::controller( 'bookshow' );
    unset( $_POST['flag'] );
    echo $bookshow->done_private( $_POST['RequestNumber'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insert_point_club' ) {

    /** @var pointClub $PointClub */
    $PointClub = Load::controller( 'pointClub' );
    unset( $_POST['flag'] );
    echo $PointClub->insertPointClub( $_POST );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'deletePointClub' ) {

    unset( $_POST['flag'] );

    /** @var pointClub $PointClub */
    $PointClub = Load::controller( 'pointClub' );
    echo $PointClub->deletePointClub( $_POST );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'deletePercentTrain' ) {

    unset( $_POST['flag'] );

    /** @var pointClub $PointClub */
    $PercentTrain = Load::controller( 'discount' );
    echo $PercentTrain->deletePercentTrain( $_POST );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'pointClubEdit' ) {

    unset( $_POST['flag'] );

    /** @var pointClub $PointClub */
    $PointClub = Load::controller( 'pointClub' );
    echo $PointClub->pointClubEdit( $_POST );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'CountUnreadMessage' ) {

    /** @var message $message */
    $message = Load::controller( 'message' );
    unset( $_POST['flag'] );
    echo $message->CountUnreadMessage();
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'delMessageUser' ) {

    /** @var message $message */
    $message = Load::controller( 'message' );
    unset( $_POST['flag'] );
    echo $message->delMessageUser( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'sendMessage' ) {

    /** @var message $message */
    $message = Load::controller( 'message' );
    unset( $_POST['flag'] );
    echo $message->sendMessage( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'changeFlagBuyPrivate' ) {

    /** @var bookshow $bookshow */
    $bookshow = Load::controller( 'bookshow' );
    unset( $_POST['flag'] );
    echo $bookshow->changeFlagBuyPrivate( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'changeFlagBuyPublicSystem' ) {

    /** @var bookshow $bookshow */
    $bookshow = Load::controller( 'bookshow' );
    unset( $_POST['flag'] );
    echo $bookshow->changeFlagBuyPublicSystem( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'changeFlagBuyPrivateToPublic' ) {

    /** @var bookshow $bookshow */
    $bookshow = Load::controller( 'bookshow' );
    unset( $_POST['flag'] );
    echo $bookshow->changeFlagBuyPrivateToPublic( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'mainTicketHistory' ) {


    /** @var bookshowTest $bookshow */
    $bookshow = Load::controller( 'bookshowTest' );
    unset( $_POST['flag'] );
    echo $bookshow->MainTicketHistory( $_POST );
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'historyTestWebService' ) {

    /** @var bookshowTest $bookshow */
    $bookshow = Load::controller('bookshowTest');
    unset($_POST['flag']);

    echo $bookshow->historyTestWebService($_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'showPriceInfant' ) {

    foreach ( $_POST['RequestNumber'] as $direction => $request_number ) {

        $result[ $direction ] = functions::ShowPrice( $request_number );

    }

    if ( ! empty( $_POST['RequestNumber']['return'] ) && $result['dept']['result_status'] == $result['return']['result_status'] ) {

        echo $result['dept']['result_message'];

    } elseif ( ! empty( $_POST['RequestNumber']['return'] ) && $result['dept']['result_status'] != $result['return']['result_status'] ) {

        echo $result['dept']['result_message'] . ' ' . $result['return']['result_message'];

    } else {

        echo $result['dept']['result_message'];

    }
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insert_change_price_hotel' ) {

    $PriceHotelChange = Load::controller( 'PriceHotelChange' );
    unset( $_POST['flag'] );
    echo $PriceHotelChange->InsertChangePriceHotel( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'delete_change_price_hotel' ) {

    $PriceChange = Load::controller( 'PriceHotelChange' );
    echo $PriceChange->DeleteChangePriceHotel( $_POST['id'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'selectColor' ) {

    $selectColor = Load::controller( 'selectColor' );
    unset( $_POST['flag'] );
    echo $selectColor->SaveChangeColor( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'preReserveBuy' ) {
    $bookshow = Load::controller( 'bookshow' );
    unset( $_POST['flag'] );
    echo $bookshow->preReserveBuy( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'CancellationFeeSetting' ) {
    $Result = Load::controller( 'cancellationFeeSetting' );
    unset( $_POST['flag'] );
    echo $Result->CancellationFeeSettingAdd( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'CancellationFeeSettingEdit' ) {

    $Result = Load::controller( 'cancellationFeeSetting' );
    unset( $_POST['flag'] );
    echo $Result->CancellationFeeSettingEdit( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'SendSmsForUser' ) {

    $ModelBase = Load::library( 'ModelBase' );

    $arg      = array(
        'RequestNumber' => FILTER_SANITIZE_STRING,
        'contentSms'    => FILTER_SANITIZE_STRING,
        'Reason'        => FILTER_SANITIZE_STRING
    );
    $dataPost = filter_var_array( $_POST, $arg );

    $Sql = "SELECT * FROM report_tb WHERE request_number='{$dataPost['RequestNumber']}'";
    $res = $ModelBase->load( $Sql );

    if ( ! empty( $res ) ) {
        $Client = functions::infoClient( $res['client_id'] );

        /** @var smsServices $smsController */
        $smsController = Load::controller( 'smsServices' );
        $objSms        = $smsController->initService( '1' );
        if ( $objSms ) {
            $sms       = $dataPost['contentSms'];
            $cellArray = array(
                'buyer'   => $res['mobile_buyer'],
                'member'  => $res['member_mobile'],
                'manager' => $Client['Mobile'],
            );
            foreach ( $cellArray as $cellNumber ) {
                $smsArray = array(
                    'smsMessage' => $sms,
                    'cellNumber' => $cellNumber,
                    'sendType'=>'manual',
                    'request_number' => $dataPost['RequestNumber']
                );
                $smsController->sendSMS( $smsArray );

                //insert log in db
                $data['ClientId']        = $res['client_id'];
                $data['Content']         = $sms;
                $data['Mobile']          = $cellNumber;
                $data['Reason']          = $dataPost['Reason'];
                $data['RequestNumber']   = $res['request_number'];
                $data['CreationDateInt'] = time();

                $ModelBase->setTable( 'log_sms_tb' );
                $ModelBase->insertLocal( $data );

            }
        }

        echo "success : پیام شما با موفقیت ارسال شد";
    } else {
        echo "error : درخواست معتبر نمی باشد";
    }
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'uploadProof' ) {

    $reservation_proof_model = Load::controller( 'reservationProof' );
    $insert_data = $reservation_proof_model->uploadProof($_POST , $_FILES);

    if ( ! empty( $insert_data ) && $insert_data['type'] == 'success') {
        echo "success : پیام شما با موفقیت ارسال شد";
    } else {
        echo "error : " . $insert_data['data'];
    }

}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'MinimumPriceFlight' ) {

    unset( $_POST['flag'] );
    echo functions::ShowContentMinimumPrice( $_POST['Departure_Code'], $_POST['Arrival_Code'], $_POST['dateRequest'], $_POST['adult'], $_POST['child'], $_POST['infant'], $_POST['typeSelect'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'AccessActive' ) {

    $Setting = Load::controller( 'settingAccessUserClientList' );
    unset( $_POST['flag'] );
    echo $Setting->AccessActive( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'SelectServiceForSource' ) {

    $Setting = Load::controller( 'settingAccessUserClientList' );
    unset( $_POST['flag'] );
    echo $Setting->SourceList( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insertAccessNew' ) {

    $Setting = Load::controller( 'settingAccessUserClientList' );
    unset( $_POST['flag'] );
    echo $Setting->insertAccessNew( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'EditAccessNew' ) {

    $Setting = Load::controller( 'settingAccessUserClientList' );
    unset( $_POST['flag'] );
    echo $Setting->EditAccessNew( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'getResultTicketLocal' ) {
    error_log( 'first user_ajax Internal : ' . date( 'Y/m/d H:i:s' ) . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt' );
    $resultLocal = Load::controller( 'resultLocal' );
    unset( $_POST['flag'] );
    $ResultLocal = $resultLocal->getTicketList( $_POST );
    error_log( 'End user_ajax Internal : ' . date( 'Y/m/d H:i:s' ) . " \n*****************************\n", 3, LOGS_DIR . 'log_Request_send_search.txt' );
    echo $ResultLocal;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'getResultTicketFake' ) {

    $resultLocal = Load::controller( 'resultLocal' );
    unset( $_POST['flag'] );
    $ResultLocal = $resultLocal->ResultFakeFlight( $_POST );

    echo $ResultLocal;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'getResultTicketPortal' ) {
    functions::insertLog( 'first  user_ajax Foreign ', 'log_Request_send_search_Foreign' );

    $resultLocal = Load::controller( 'resultLocal' );
    unset( $_POST['flag'] );
    $ResultForeign = $resultLocal->getTicketForeign( $_POST );

    functions::insertLog( 'End user_ajax Foreign ' . " \n" . '*********************************************', 'log_Request_send_search_Foreign' );


    echo $ResultForeign;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'FlightOfTwoWeek' ) {

    $resultLocal = Load::controller( 'resultLocal' );
    unset( $_POST['flag'] );
    echo $resultLocal->FlightOfTwoWeek( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'check_user_login' ) {
    unset( $_POST['flag'] );
    echo Session::IsLogin();
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == "register_memeber_insurance" ) {

    $booking = Load::controller( 'bookingInsurance' );
    echo $booking->registerPassengerOnline();
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insurance_choose' ) {

    $insurance = Load::controller( 'insurance' );
    unset( $_POST['flag'] );
    echo $insurance->saveSelectedPlan( $_POST );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insurancePreReserve' ) {

    $insurance = Load::controller( 'insurance' );
    unset( $_POST['flag'] );
    $factorNumber = filter_var( $_POST['factorNumber'], FILTER_SANITIZE_NUMBER_INT );
    $result = $insurance->preReservePlan( $factorNumber );

    echo $result;

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'check_credit_insurance' ) {

    $factorNumber = filter_var( $_POST['factorNumber'], FILTER_SANITIZE_NUMBER_INT );
    if ( $factorNumber != '' ) {

        $Model          = Load::library( 'Model' );
        $insurance      = Load::controller( 'insurance' );
        $objTransaction = Load::controller( 'transaction' );

        $queryReserveInfo = "SELECT source_name, source_name_fa, destination, COUNT(id) AS reserveCount FROM book_insurance_tb WHERE factor_number = '{$factorNumber}'";
        $reserveInfo      = $Model->load( $queryReserveInfo );

        $insuranceObj = $insurance->getSourceInfo( $reserveInfo['source_name'] );

        $checkBankIranTech = functions::CheckGetWayIranTech( CLIENT_ID );
        $prices            = $insurance->getTotalPriceByFactorNumber( $factorNumber );


        $comment = " رزرو " . " " . $reserveInfo['reserveCount'] . " عدد " . " " . $reserveInfo['source_name_fa'] . " به مقصد " . " " . $reserveInfo['destination'] . " " . "به شماره فاکتور " . " " . $factorNumber . ( $insuranceObj->publicPrivate == 'private' ? ' اختصاصی ' : ' اشتراکی ' );

        if ( $insuranceObj->publicPrivate == 'public' ) {

            $prices      = $insurance->getTotalPriceByFactorNumber( $factorNumber );
            $total_price = ( $prices['totalPriceIncreased'] - $prices['totalAgencyCommission'] ) + $prices['irantech_commission'];
        } else {
            $total_price = 0 + $prices['irantech_commission'];
        }


        // Caution: اعتبارسنجی صاحب سیستم
        $check = $objTransaction->checkCreditNew( $total_price, 'online','',$total_price , $_POST['selectedBank']);

        if ( $check['status'] == 'TRUE' ) {

            $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );
            if ( empty( $existTransaction ) ) {
                if ( $checkBankIranTech && isset($_POST['selectedBank']) && $_POST['selectedBank'] == 'publicBank') {
                    $commentIranTech = 'شارژ درگاه سفر360 برای خرید بیمه به شماره فاکتور ' . $factorNumber . 'از این درگاه ';
                    functions::insertLog( 'in GetWayIranTech Toure With factorNumber=>' . $factorNumber . ' has Amount Ticket=>' . $prices['totalPrice'], 'iranTechGetWayBuy' );
                    // در صورتی که از درگاه ایران تک استفاده میشد،یک رکورد بابت شارژ به اندازه هزینه بلیط زده میشه به صورت موقت و در برگشت از بانک در صورت موفقیت اوکی میشه
                    $objTransaction->InsertChargeThrowIranTechGetWay( $prices['totalPrice'], $factorNumber, $commentIranTech );
                    sleep( 1 );
                }
                // Caution: کاهش اعتبار موقت صاحب سیستم
                //                $reduceTransaction = $objTransaction->decreasePendingCredit($total_price, $factorNumber, $comment, 'buy_insurance');
                $reason = 'buy_insurance';

                // Caution: کاهش اعتبار موقت صاحب سیستم
                $reduceTransaction = $objTransaction->decreasePendingCredit( $total_price, $factorNumber, $comment, $reason, $checkBankIranTech );


                if ( $reduceTransaction ) {
                    echo 'TRUE';
                } else {
                    echo 'FALSE';
                }

            } else {
                echo 'FALSE';
            }

        } else {
            echo 'FALSE';
        }

    } else {
        echo 'FALSE';
    }

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'buyByCreditInsurance' ) {

    $Model          = Load::library( 'Model' );
    $insurance      = Load::controller( 'insurance' );
    $objTransaction = Load::controller( 'transaction' );
    $objMember      = Load::controller( 'members' );

    // Caution: اعتبار همکار(آژانس همکار با صاحب پنل ) که ممکنه  خود صاحب سیستم باشد یا همکار دیگری که کانتری که خرید میکند شامل این همکار است
    $counterCredit = $objMember->getCredit();

    $factorNumber = filter_var( $_POST['factorNumber'], FILTER_SANITIZE_NUMBER_INT );
    $prices       = $insurance->getTotalPriceByFactorNumber( $factorNumber );

    $queryReserveInfo = "SELECT *, COUNT(id) AS reserveCount FROM book_insurance_tb WHERE factor_number = '{$factorNumber}'";
    $reserveInfo      = $Model->load( $queryReserveInfo );

    $insuranceObj = $insurance->getSourceInfo( $reserveInfo['source_name'] );

    // Caution: اعتبارسنجی اعتبار کانتر
    if ( $counterCredit > $prices['totalPriceIncreased'] ) {

        // Caution: کاهش اعتبار کانتر

        $objMember->decreaseCounterCredit( $prices['totalPrice'], $factorNumber, $reserveInfo, 'Insurance' );

        $comment = " رزرو " . " " . $reserveInfo['reserveCount'] . " عدد " . " " . $reserveInfo['source_name_fa'] . " به مقصد " . " " . $reserveInfo['destination'] . " " . "به شماره فاکتور " . " " . $factorNumber . ( $insuranceObj->publicPrivate == 'private' ? ' اختصاصی ' : ' اشتراکی ' );
        if ( $insuranceObj->publicPrivate == 'public' ) {

            $total_price = ( $prices['totalPriceIncreased'] - $prices['totalAgencyCommission'] ) + $prices['irantech_commission'];

        } else {
            $total_price = 0;
        }

        // Caution: اعتبارسنجی صاحب پنل
        $check = $objTransaction->checkCredit( $total_price );

        if ( $check['status'] == 'TRUE' ) {

            $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );
            if ( empty( $existTransaction ) ) {

                // Caution: کاهش اعتبار صاحب سیستم
                $reduceTransaction = $objTransaction->decreaseSuccessCredit( $total_price, $factorNumber, $comment, 'buy_insurance' );

                if ( $reduceTransaction ) {
                    echo 'success:' . $prices['totalPriceIncreased'];
                } else {
                    echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCredit' );
                }

            } else {
                echo 'error:' . functions::Xmlinformation( 'ChargeRialSystem' );
            }

        } else {
            echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCreditByFactorNumber' );
        }

    } else {
        echo 'error:' . functions::Xmlinformation( 'EndCreditAgency' );
    }

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'SendInsuranceEmailForOther' ) {
    $members = Load::controller( 'members' );
    unset( $_POST['flag'] );
    echo $members->SendInsuranceEmailForOther( $_POST['email'], $_POST['request_number'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'liveSearchDestination' ) {
    $resultLocals = Load::controller( 'resultLocal' );
    unset( $_POST['flag'] );
    echo $resultLocals->liveSearchDestination( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'flightPriceChanges' ) {

    $priceChanges = Load::controller( 'priceChanges' );
    unset( $_POST['flag'] );
    echo $priceChanges->updatePrice( $_POST );
} elseif ( isset( $_POST['flag'] ) && ( $_POST['flag'] == 'localFlightPriceChangesAll' || $_POST['flag'] == 'internationalFlightPriceChangesAll' ) ) {

    if ( $_POST['flag'] == 'localFlightPriceChangesAll' ) {
        $input['priceChangesAll'] = $_POST['localPriceChangesAll'];
        $input['changeTypeAll']   = $_POST['localChangeTypeAll'];
        $input['locality']        = 'local';
    } elseif ( $_POST['flag'] == 'internationalFlightPriceChangesAll' ) {
        $input['priceChangesAll'] = $_POST['internationalPriceChangesAll'];
        $input['changeTypeAll']   = $_POST['internationalChangeTypeAll'];
        $input['locality']        = 'international';
    }

    unset( $_POST['flag'] );
    $priceChanges = Load::controller( 'priceChanges' );
    echo $priceChanges->setPriceForAll( $input );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'resetFlightPriceChanges' ) {

    $priceChanges = Load::controller( 'priceChanges' );
    unset( $_POST['flag'] );
    echo $priceChanges->resetAll( $_POST['locality'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'servicesDiscount' ) {

    $servicesDiscount = Load::controller( 'servicesDiscount' );
    unset( $_POST['flag'] );
    echo $servicesDiscount->update( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'serviceOrderChange' ) {

    $service_order = Load::controller( 'searchService' );
    unset( $_POST['flag'] );
    echo $service_order->update_service_order( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'servicesDiscountAll' ) {

    $servicesDiscount = Load::controller( 'servicesDiscount' );
    unset( $_POST['flag'] );
    echo $servicesDiscount->setDiscountForAll( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'resetServicesDiscount' ) {

    $servicesDiscount = Load::controller( 'servicesDiscount' );
    unset( $_POST['flag'] );
    echo $servicesDiscount->resetAll();
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'irantechCommissionChange' ) {

    $irantechCommission = Load::controller( 'irantechCommission' );
    unset( $_POST['flag'] );
    echo $irantechCommission->update( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insurancePriceChanges' ) {

    $priceChanges = Load::controller( 'insurancePriceChanges' );
    unset( $_POST['flag'] );
    echo $priceChanges->update( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'CheckLogged' ) {

    if ( Session::IsLogin() ) {
        echo 'SuccessLogging';
    } else {
        echo 'ErrorLogging';
    }
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'DiscountCodesAdd' ) {
    /** @var discountCodes $controller */
    $controller = Load::controller( 'discountCodes' );
    unset( $_POST['flag'] );
    echo $controller->DiscountCodesAdd( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'DiscountCodesEdit' ) {

    $controller = Load::controller( 'discountCodes' );
    unset( $_POST['flag'] );
    echo $controller->DiscountCodesEdit( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'discountCodeDelete' ) {

    $controller = Load::controller( 'discountCodes' );
    unset( $_POST['flag'] );
    echo $controller->DiscountCodesDelete( $_POST['id'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'ActivateDiscountCode' ) {
    $controller = Load::controller( 'discountCodes' );
    unset( $_POST['flag'] );
    echo $controller->ActivateDiscountCode( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'checkDiscountCode' ) {
    unset( $_POST['flag'] );

    $controller = Load::controller( 'discountCodes' );
    $currencyCode = ( ! empty( $_POST['currencyCode'] ) ? filter_var( $_POST['currencyCode'], FILTER_VALIDATE_INT ) : 0 );
    if ( Session::IsLogin() ) {
        $result = $controller->CheckDiscountCode( $_POST['discountCode'], Session::getUserId(), $_POST['serviceType'], $currencyCode );
    } else {
        $result['result_status'] = 'error';
        if ( isset( $_POST['Type'] ) && $_POST['Type'] == 'App' ) {
            $result['result_message'] = 'متاسفانه کد تخفیف به شما تعلق نمی گیرد';
        } else {
            $result['result_message'] = functions::Xmlinformation( 'ErrorDiscountCode' );
        }

    }

    echo functions::clearJsonHiddenCharacters( json_encode( $result ) );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'ReagentPointAdd' ) {
    $controller = Load::controller( 'reagentPoint' );
    unset( $_POST['flag'] );

    $arg      = array(
        'Amount' => FILTER_VALIDATE_INT
    );
    $dataPost = filter_var_array( $_POST, $arg );

    echo $controller->InsertReagentPoint( $dataPost );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'checkReagentCode' ) {
    $controller = Load::controller( 'reagentPoint' );
    unset( $_POST['flag'] );

    $arg      = array(
        'reagentCode' => FILTER_SANITIZE_STRING
    );
    $dataPost = filter_var_array( $_POST, $arg );

    $result = $controller->checkReagentCode( $dataPost['reagentCode'] );
    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'checkTicketDiscountPrice' ) {
    unset( $_POST['flag'] );
    $arg      = array(
        'AirlineCode'    => FILTER_SANITIZE_STRING,
        'FlightType'     => FILTER_SANITIZE_STRING,
        'Price'          => FILTER_VALIDATE_INT,
        'TypeZoneFlight' => FILTER_SANITIZE_STRING,
        'SourceId' => FILTER_SANITIZE_STRING
    );
    $dataPost = filter_var_array( $_POST, $arg );

    $UserId       = Session::getUserId();
    $UserInfo     = functions::infoMember( $UserId );
    $CounterInfo  = functions::infoCounterType( $UserInfo['fk_counter_type_id'], CLIENT_ID );
    $checkPrivate = functions::checkConfigPid( $dataPost['AirlineCode'], ( ( $dataPost['TypeZoneFlight'] == 'Local' ) ? 'internal' : 'external' ), $dataPost['FlightType'] ,$dataPost['SourceId']);
    $TypeService  = functions::TypeService( $dataPost['FlightType'], $dataPost['TypeZoneFlight'], strtolower( $dataPost['FlightType'] ) == 'system' ? '' : 'public', $checkPrivate, $dataPost['AirlineCode'] );
    $Discount     = functions::ServiceDiscount( $CounterInfo['id'], $TypeService );

    echo $dataPost['Price'] . ':' . ( $Discount['off_percent'] > 0 ? 'YES' : 'No' );

}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'checkMemberCredit' ) {

    $objTransaction    = Load::controller( 'transaction' );
    unset( $_POST['flag'] );



    $arg      = array(
        'priceToPay' => FILTER_VALIDATE_INT,
        'creditUse'  => FILTER_SANITIZE_STRING
    );



    $dataPost = filter_var_array( $_POST, $arg );

    if ( $dataPost['creditUse'] == 'member_credit' ) {
        $member = Load::controller( 'members' );
        $member->get();

        if ( Session::IsLogin() && $member->list['fk_counter_type_id'] == '5' ) {
            $credit = $member->getMemberCredit();

            $check = $objTransaction->checkCredit( $dataPost['priceToPay'] );



            if ( $check['status'] != 'TRUE' ) {
                $result['result_status']  = 'none_credit';
                $result['result_message'] = functions::Xmlinformation( 'ZeroCredit' );
            }elseif ( $credit > 0 && ( intval( $credit ) < intval( $dataPost['priceToPay'] ) ) ) {
                $result['result_status']  = 'half_credit';
                $credit                   = number_format( $dataPost['priceToPay'] - $credit );
                $result['result_message'] = functions::StrReplaceInXml( [ "@@creditPayment@@" => $credit ], "MessagePaymentByCreditUser" );
            } elseif ( $credit > 0 && ( intval( $credit ) > intval( $dataPost['priceToPay'] ) ) ) {
                $result['result_status']  = 'full_credit';
                $result['result_message'] = functions::Xmlinformation( 'CompletePayment' );
            } else {
                $result['result_status']  = 'none_credit';
                $result['result_order']  = '1';
                $result['result_message'] = functions::Xmlinformation( 'ZeroCredit' );
            }
        } else {
            $result['result_status']  = 'none_credit';
            $result['result_order']  = '2';
            $result['result_message'] = functions::Xmlinformation( 'AccessDenied' );
        }
    } else {
        $result['result_status']  = 'none_credit';
        $result['result_order']  = '3';
        $result['result_message'] = '';
    }

    echo json_encode( $result );
}
else if ( isset($_POST['flag']) && $_POST['flag'] == 'EditInfoPassenger' ) {
    unset($_POST['flag']);
    $airline = filter_var( $_POST['airline'], FILTER_SANITIZE_STRING );
    $airline = explode( '|', $airline );

    $hour   = isset($_POST['flightHour']) ? sprintf('%02d', $_POST['flightHour']) : "00";
    $minute = isset($_POST['flightMinute']) ? sprintf('%02d', $_POST['flightMinute']) : "00";
    $flight_time = $hour . ':' . $minute;

    $flightDateJalali = filter_var($_POST['flightDate'], FILTER_SANITIZE_STRING);
    if (!empty($flightDateJalali)) {
        // فرض: تاریخ به شکل 1403-06-15 میاد
        $parts = explode('-', $flightDateJalali);
        if (count($parts) === 3) {
            $gregorianFlightDate = dateTimeSetting::jalali_to_gregorian($parts[0], $parts[1], $parts[2], '-');
        } else {
            $gregorianFlightDate = $flightDateJalali; // fallback
        }
    } else {
        $gregorianFlightDate = null;
    }

    $data = array(
        "ClientID"           => filter_var($_POST['ClientID'], FILTER_SANITIZE_STRING),
        "RequestNumber"      => filter_var($_POST['RequestNumber'], FILTER_SANITIZE_STRING),
        "flight_time"        => $flight_time,
        "flight_date"        => $gregorianFlightDate,
        "airline_iata"       => $airline[0],
        "airline_name"       => $airline[1],
        "passengerNameFa"    => filter_var_array($_POST['passengerNameFa'], FILTER_SANITIZE_STRING),
        "passengerFamilyFa"  => filter_var_array($_POST['passengerFamilyFa'], FILTER_SANITIZE_STRING),
        "passengerNameEn"    => filter_var_array($_POST['passengerNameEn'], FILTER_SANITIZE_STRING),
        "passengerFamilyEn"  => filter_var_array($_POST['passengerFamilyEn'], FILTER_SANITIZE_STRING),
        "nationalCode"       => filter_var_array($_POST['nationalCode'], FILTER_SANITIZE_STRING),
    );

    /** @var bookshow $bookshow */
    $bookshow = Load::controller('bookshow');
    $UpdatePassenger = $bookshow->UpdatePassengerInfo($data);

    echo $UpdatePassenger;
}

elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'AddPnr' ) {
    unset( $_POST['flag'] );

    $airline = filter_var( $_POST['airline'], FILTER_SANITIZE_STRING );
    $airline = explode( '|', $airline );

    $data = Array(
        "ClientID"      => filter_var( $_POST['ClientID'], FILTER_SANITIZE_STRING ),
        "RequestNumber" => filter_var( $_POST['RequestNumber'], FILTER_SANITIZE_STRING ),
        "pnr"           => filter_var( $_POST['pnr'], FILTER_SANITIZE_STRING ),
        "airline_iata"  => $airline[0],
        "airline_name"  => $airline[1],
        "flight_number" => filter_var( $_POST['flightNo'], FILTER_SANITIZE_STRING ),
        "seat_class"    => filter_var( $_POST['flightClass'], FILTER_SANITIZE_STRING ),
        "time_flight"   => filter_var( $_POST['flightTime'], FILTER_SANITIZE_STRING ),
        "nationalCode"  => filter_var_array( $_POST['nationalCode'], FILTER_SANITIZE_STRING ),
        "eTicketNumber" => filter_var_array( $_POST['eTicketNumber'], FILTER_SANITIZE_STRING )
    );

    /** @var bookshow $bookshow */
    $bookshow  = Load::controller( 'bookshow' );
    $InsertPnr = $bookshow->InsertPnrToDB( $data );

    echo $InsertPnr;
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'AddHotelPnr' ) {
    unset( $_POST['flag'] );


    $data = Array(
        "ClientID"      => filter_var( $_POST['ClientID'], FILTER_SANITIZE_STRING ),
        "RequestNumber" => filter_var( $_POST['RequestNumber'], FILTER_SANITIZE_STRING ),
        "pnr"           => filter_var( $_POST['pnr'], FILTER_SANITIZE_STRING ),
        "voucher_number"    => filter_var( $_POST['voucher_No'], FILTER_SANITIZE_STRING )
    );

    $hotelController = Load::controller( 'detailHotel' );

    $InsertPnr = $hotelController->InsertHotelPnrToDB( $data );

    echo $InsertPnr;
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'bookPendingHotel' ) {

    unset( $_POST['flag'] );

    $data = Array(
        "ClientID"      => filter_var( $_POST['ClientID'], FILTER_SANITIZE_STRING ),
        "factorNumber" => filter_var( $_POST['factorNumber'], FILTER_SANITIZE_STRING ),
        "pnr"           => filter_var( $_POST['pnr'], FILTER_SANITIZE_STRING ),
        "voucher_number"    => filter_var( $_POST['voucher_No'], FILTER_SANITIZE_STRING )
    );

    $hotelController = Load::controller( 'detailHotel' );

    $changeStatus = $hotelController->handleForceReserve( $data );

    echo $changeStatus;
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'check_credit_hotel' ) {

    $factorNumber    = trim( $_POST['factorNumber'] );
    $typeApplication = trim( $_POST['typeApplication'] );
    /** @var transaction $objTransaction */
    $objTransaction = Load::controller( 'transaction' );

    $reserveInfo = functions::GetInfoHotel( $factorNumber );



    $checkBankIranTech = functions::CheckGetWayIranTech( CLIENT_ID );


    $comment   = " رزرو " . " " . $reserveInfo['room_count'] . " باب اتاق در شهر " . " " . $reserveInfo['city_name'] . " در " . " " . $reserveInfo['hotel_name'] . " " . "به شماره رزرو " . " " . $reserveInfo['factor_number'];
    $totalBank = $reserveInfo['totalPriceTransaction'];

    if ( $typeApplication == 'api' || $typeApplication == 'api_app' ) {
        $total_price = $reserveInfo['totalPriceTransaction'];
        $reason      = 'buy_hotel';
        if ( isset( $reserveInfo['irantech_commission'] ) && $reserveInfo['irantech_commission'] > 0 ) {
            $total_price += $reserveInfo['irantech_commission'] * $reserveInfo['countPassengers'];
        }

    } elseif ( $typeApplication == 'reservation' || $typeApplication == 'reservation_app' ) {
        $total_price = 0;
        $reason      = 'buy_reservation_hotel';
//		if ( isset( $reserveInfo['irantech_commission'] ) && $reserveInfo['irantech_commission'] > 0 ) {
//			$total_price += $reserveInfo['irantech_commission'] * $reserveInfo['countPassengers'];
//		}

    } elseif ( $typeApplication == 'externalApi' ) {
        $total_price = $reserveInfo['totalPriceTransaction'];
        $reason      = 'buy_external_hotel';

        if ( isset( $reserveInfo['irantech_commission'] ) && $reserveInfo['irantech_commission'] > 0 ) {
            $total_price += $reserveInfo['irantech_commission'] * $reserveInfo['countPassengers'];
        }
    }

    if($typeApplication != 'reservation'  && ($reserveInfo['serviceTitle'] == 'PrivatePortalHotel' ||$reserveInfo['serviceTitle'] == 'PrivateLocalHotel')){
        $total_price = $reserveInfo['irantech_commission'];
    }

    // Caution: اعتبارسنجی صاحب سیستم



    $check = $objTransaction->checkCreditNew( $total_price, 'online','',$total_price , $_POST['selectedBank'] );

    if ( $check['status'] == 'TRUE' ) {

        $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );

        if ( empty( $existTransaction ) || $reserveInfo['status']==='RequestAccepted' ) {
            if ( $checkBankIranTech && isset($_POST['selectedBank']) && $_POST['selectedBank'] == 'publicBank') {
                $commentIranTech = 'شارژ درگاه سفر360 برای خرید هتل به شماره فاکتور ' . $factorNumber . 'از این درگاه ';
                functions::insertLog( 'in GetWayIranTech With factorNumber=>' . $factorNumber . ' has Amount Ticket=>' . $total_price, 'iranTechGetWayBuy' );
                // در صورتی که از درگاه ایران تک استفاده میشد،یک رکورد بابت شارژ به اندازه هزینه بلیط زده میشه به صورت موقت و در برگشت از بانک در صورت موفقیت اوکی میشه
                $payed_price = $reserveInfo['total_price'];

                $objTransaction->InsertChargeThrowIranTechGetWay( $payed_price, $factorNumber, $commentIranTech );
                sleep( 1 );
            }


            // Caution: کاهش اعتبار موقت صاحب سیستم
            $reduceTransaction = $objTransaction->decreasePendingCredit( $total_price, $factorNumber, $comment, $reason, $checkBankIranTech );


            if ( $reduceTransaction ) {
                $output = 'TRUE';
            } else {
                $output = 'FALSE 3';
            }

        } else {
            usleep(200);
            $output = 'FALSE 2';
        }

    }
    else {
        $output = 'FALSE '.$check['status']. $check['extra_info'] .' --> '.$total_price.' - '.$bank_amount;
    }

    if ( $typeApplication == 'reservation_app' || $typeApplication == 'api_app' ) {
        $result['creditStatus'] = $output;
        $resultCredit           = functions::clearJsonHiddenCharacters( json_encode( $result, true ) );
        echo $resultCredit;


    } else {


        echo $output;
    }

}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'buyByCreditHotelLocal' ) {

    unset( $_POST['flag'] );
    $factorNumber    = trim( $_POST['factorNumber'] );
    $typeApplication = trim( $_POST['typeApplication'] );

    /** @var members $objMember */
    /** @var transaction $objTransaction */
    $objMember      = Load::controller( 'members' );
    $objTransaction = Load::controller( 'transaction' );

    // Caution: اعتبار همکار(آژانس همکار با صاحب پنل ) که ممکنه  خود صاحب سیستم باشد یا همکار دیگری که کانتری که خرید میکند شامل این همکار است
    $counterCredit = $objMember->getCredit();
    $reserveInfo   = functions::GetInfoHotel( $factorNumber );
    if ($reserveInfo['hotel_payments_price']>0) {
        $amount        = $reserveInfo['hotel_payments_price'];


    }else{
        $amount        = $reserveInfo['total_price'];

    }
    if ( $_POST['paymentStatus'] == 'prePayment' ) {
        $comment = ' پیش رزرو هتل ';
    } else {
        $comment     = 'رزرو قطعی هتل ';
    }
    $totalPriceBank = $reserveInfo['hotel_payments_price'];
    // Caution: اعتبارسنجی اعتبار کانتر
    if ( $counterCredit > $amount ) {
        $reserveInfo['payment_status'] = $_POST['paymentStatus'];
        $comment = " رزرو " . " " . $reserveInfo['room_count'] . " باب اتاق در شهر " . " " . $reserveInfo['city_name'] . "به شماره رزرو " . " " . $reserveInfo['factor_number'];
        if ( $typeApplication == 'api' || $typeApplication == 'externalApi' ) {

            $checkRepeat = 'yes';
            if ( $reserveInfo['serviceTitle'] == 'PrivateLocalHotel' || $reserveInfo['serviceTitle']=='PrivatePortalHotel' ) {

                $total_price = 0;
                $comment     .= " - اختصاصی";
            } else {
                $total_price = $reserveInfo['totalPriceTransaction'];
                $comment     .= " - اشتراکی";
            }

            $reason = 'buy_hotel';

            if ( isset( $reserveInfo['irantech_commission'] ) && $reserveInfo['irantech_commission'] > 0 ) {
                $total_price += $reserveInfo['irantech_commission'];
//				$total_price += ($reserveInfo['irantech_commission'] * $reserveInfo['countPassengers']);
            }

        } elseif ( $typeApplication == 'reservation' ) {
            $checkRepeat = 'no';
            $total_price = 0;
            $reason      = 'buy_reservation_hotel';
        } elseif ( $typeApplication == 'externalApi' ) {
            $roomCount = count( json_decode( $reserveInfo['search_rooms'] ) );

            $comment     = " رزرو " . " " . $roomCount . " باب اتاق در شهر " . " " . $reserveInfo['city_name'] . " در " . " " . $reserveInfo['hotel_name'] . " " . "به شماره رزرو " . " " . $reserveInfo['factor_number'];
            $checkRepeat = 'yes';
            $total_price = $reserveInfo['totalPriceTransaction'];
            $reason      = 'buy_foreign_hotel';

            if ( isset( $reserveInfo['irantech_commission'] ) && $reserveInfo['irantech_commission'] > 0 ) {
                $total_price += $reserveInfo['irantech_commission'] * $reserveInfo['countPassengers'];
            }
        }

        // Caution: کاهش اعتبار کانتر
        $objMember->decreaseCounterCredit( $amount, $factorNumber, $reserveInfo, 'Hotel', $checkRepeat );


        // Caution: اعتبارسنجی صاحب پنل
        $check = $objTransaction->checkCredit( $total_price );

        if ( $check['status'] == 'TRUE' ) {

            $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );
            if ( empty( $existTransaction ) || $typeApplication == 'reservation' ) {

                // Caution: کاهش اعتبار صاحب سیستم
                $reduceTransaction = $objTransaction->decreaseSuccessCredit( $total_price, $factorNumber, $comment, $reason );
                if ( $reduceTransaction ) {
                    echo 'success:' . $amount;
                } else {
                    echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCredit' );
                }

            } else {
                echo 'error:' . functions::Xmlinformation( 'ChargeRialSystem' );
            }

        } else {
            echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCreditByFactorNumber' );
        }

    } else {
        echo 'error: ' . functions::Xmlinformation( 'EndCreditAgency' );
    }


}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'check_credit_car' ) {

    unset( $_POST['flag'] );
    $factorNumber   = trim( $_POST['factorNumber'] );
    $objTransaction = Load::controller( 'transaction' );

    $reserveInfo = functions::GetInfoEuropcar( $factorNumber );

    $total_price_transaction = $total_price = $reserveInfo['total_price'];
    $comment                 = 'اجاره خودرو ' . $reserveInfo['car_name'] . ' در ایستگاه تحویل: ' . $reserveInfo['source_station_name'] . ' تاریخ و ساعت تحویل: ' . $reserveInfo['get_car_date_time'] . ' و ایستگاه بازگشت: ' . $reserveInfo['dest_station_name'] . ' تاریخ و ساعت و بازگشت: ' . $reserveInfo['return_car_date_time'] . ' به شماره فاکتور: ' . $reserveInfo['factor_number'];

    if ( isset( $reserveInfo['irantech_commission'] ) && $reserveInfo['irantech_commission'] > 0 ) {
        $total_price_transaction += $reserveInfo['irantech_commission'] * $reserveInfo['CountId'];
    }

    // Caution: اعتبارسنجی صاحب سیستم
    $check = $objTransaction->checkCredit( $total_price_transaction );

    if ( $check['status'] == 'TRUE' ) {

        $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );
        if ( empty( $existTransaction ) ) {

            // Caution: کاهش اعتبار موقت صاحب سیستم
            $reduceTransaction = $objTransaction->decreasePendingCredit( $total_price_transaction, $factorNumber, $comment, 'buy_Europcar' );
            if ( $reduceTransaction ) {
                echo 'TRUE';
            } else {
                echo 'FALSE';
            }

        } else {
            echo 'FALSE';
        }

    } else {
        echo 'FALSE';
    }
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'buyByCreditCarLocal' ) {

    unset( $_POST['flag'] );
    $factorNumber   = trim( $_POST['factorNumber'] );
    $objMember      = Load::controller( 'members' );
    $objTransaction = Load::controller( 'transaction' );

    // Caution: اعتبار همکار(آژانس همکار با صاحب پنل ) که ممکنه  خود صاحب سیستم باشد یا همکار دیگری که کانتری که خرید میکند شامل این همکار است
    $counterCredit = $objMember->getCredit();

    $reserveInfo = functions::GetInfoEuropcar( $factorNumber );

    $total_price_transaction = $total_price = $reserveInfo['total_price'];
    $comment                 = 'اجاره خودرو ' . $reserveInfo['car_name'] . ' در ایستگاه تحویل: ' . $reserveInfo['source_station_name'] . ' تاریخ و ساعت تحویل: ' . $reserveInfo['get_car_date_time'] . ' و ایستگاه بازگشت: ' . $reserveInfo['dest_station_name'] . ' تاریخ و ساعت و بازگشت: ' . $reserveInfo['return_car_date_time'] . ' به شماره فاکتور: ' . $reserveInfo['factor_number'];

    if ( isset( $reserveInfo['irantech_commission'] ) && $reserveInfo['irantech_commission'] > 0 ) {
        $total_price_transaction += $reserveInfo['irantech_commission'] * $reserveInfo['CountId'];
    }

    // Caution: اعتبارسنجی اعتبار کانتر
    if ( $counterCredit > $total_price ) {

        // Caution: کاهش اعتبار کانتر
        $objMember->decreaseCounterCredit( $total_price, $factorNumber, $reserveInfo, 'Europcar' );

        // Caution: اعتبارسنجی صاحب سیستم
        $check = $objTransaction->checkCredit( $total_price_transaction );
        if ( $check['status'] == 'TRUE' ) {

            $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );
            if ( empty( $existTransaction ) ) {

                // Caution: کاهش اعتبار صاحب سیستم
                $reduceTransaction = $objTransaction->decreaseSuccessCredit( $total_price_transaction, $factorNumber, $comment, 'buy_Europcar' );
                if ( $reduceTransaction ) {
                    echo 'success:' . $total_price;
                } else {
                    echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCredit' );
                }

            } else {
                echo 'error:' . functions::Xmlinformation( 'ChargeRialSystem' );
            }

        } else {
            echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCreditByFactorNumber' );
        }

    } else {
        echo 'error: ' . functions::Xmlinformation( 'EndCreditAgency' );
    }
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'check_credit_tour' ) {

    unset( $_POST['flag'] );
    $factorNumber   = trim( $_POST['factorNumber'] );
    $objTransaction = Load::controller( 'transaction' );

    $reserveInfo = functions::GetInfoTour( $factorNumber );
    $total_price = 0;

    $checkBankIranTech = functions::CheckGetWayIranTech( CLIENT_ID );


    if ( $_POST['paymentStatus'] == 'prePayment' ) {
        $comment = ' پیش رزرو تور ';
//		if ( isset( $reserveInfo['irantech_commission'] ) && $reserveInfo['irantech_commission'] > 0 ) {
//			$total_price += $reserveInfo['irantech_commission'] * $reserveInfo['CountId'];
//		}

    } else {
//		$total_price += $reserveInfo['irantech_commission'] * $reserveInfo['CountId'];
        $comment     = 'رزرو قطعی تور ';
    }

    $totalPriceBank = $reserveInfo['tour_payments_price'];


    $comment .= $reserveInfo['tour_name'] . ' ' . $reserveInfo['tour_code'] . ' از تاریخ: ' . $reserveInfo['tour_start_date'] . ' تا تاریخ: ' . $reserveInfo['tour_end_date'];
    if ( $reserveInfo['tour_night'] > 0 ) {
        $comment .= " به مدت: " . $reserveInfo['tour_night'] . " شب " . $infoBook['tour_day'] . " روز ";
    } else {
        $comment .= " به مدت: " . $reserveInfo['tour_day'] . " روز ";
    }
    $comment .= ' به مقصد: ' . $reserveInfo['tour_cities'] . '  شماره فاکتور: ' . $reserveInfo['factor_number'];


    // Caution: اعتبارسنجی صاحب سیستم
    $check = $objTransaction->checkCredit( $total_price,'online' );

    if ( $check['status'] == 'TRUE' ) {
        if ( $checkBankIranTech ) {
            $commentIranTech = 'شارژ درگاه سفر360 برای خرید تور به شماره فاکتور ' . $factorNumber . 'از این درگاه ';
            functions::insertLog( 'in GetWayIranTech Tour With factorNumber=>' . $factorNumber . ' has Amount Ticket=>' . $totalPriceBank, 'iranTechGetWayBuy' );
            // در صورتی که از درگاه ایران تک استفاده میشد،یک رکورد بابت شارژ به اندازه هزینه بلیط زده میشه به صورت موقت و در برگشت از بانک در صورت موفقیت اوکی میشه
            $objTransaction->InsertChargeThrowIranTechGetWay( $totalPriceBank, $factorNumber, $commentIranTech );
            sleep( 1 );
        }
        // Caution: کاهش اعتبار موقت صاحب سیستم
        $reduceTransaction = $objTransaction->decreasePendingCredit( $total_price, $factorNumber, $comment, 'buy_reservation_tour', $checkBankIranTech );

        if ( $reduceTransaction ) {
            echo 'TRUE';
        } else {
            echo 'FALSE';
        }

    } else {
        echo 'FALSE :' . functions::Xmlinformation( 'ChargeRialSystem' );
    }

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'check_credit_entertainment' ) {


    unset( $_POST['flag'] );
    $factorNumber           = trim( $_POST['factorNumber'] );
    $objFactorEntertainment = Load::controller( 'entertainment' );
    $objTransaction         = Load::controller( 'transaction' );
    $reserveInfo            = $objFactorEntertainment->GetInfoEntertainment( $factorNumber );
    $checkBankIranTech      = functions::CheckGetWayIranTech( CLIENT_ID );
    if ( $checkBankIranTech ) {
        $TicketPrice = $reserveInfo['DiscountPrice'];
        $total_price = 0 + ( $reserveInfo['irantech_commission'] * $reserveInfo['CountPeople'] );
        $comment     = 'رزرو تفریحات به شماره رزرو : ' . $reserveInfo['requestNumber'] . ' از طریق درگاه بانکی سفر 360 ';
    } else {
        $total_price = 0 + ( $reserveInfo['irantech_commission'] * $reserveInfo['CountPeople'] );
        $comment     = 'رزرو تفریحات به شماره رزرو : ' . $reserveInfo['requestNumber'];
    }

    $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );

    if ( empty( $existTransaction ) ) {
        $check = $objTransaction->checkCredit( $total_price, 'online' );
        if ( $check['status'] == 'TRUE' ) {
            if ( $checkBankIranTech ) {
                $commentIranTech = 'شارژ درگاه سفر360 برای خرید به شماره رزرو ' . $reserveInfo['requestNumber'] . 'از این درگاه ';
                functions::insertLog( 'in GetWayIranTech With factorNumber=>' . $factorNumber . ' has Amount Ticket=>' . $TicketPrice, 'iranTechGetWayBuy' );
                // در صورتی که از درگاه ایران تک استفاده میشد،یک رکورد بابت شارژ به اندازه هزینه بلیط زده میشه به صورت موقت و در برگشت از بانک در صورت موفقیت اوکی میشه
                $objTransaction->InsertChargeThrowIranTechGetWay( $TicketPrice, $factorNumber, $commentIranTech );
                sleep( 1 );
            }
            // Caution: کاهش اعتبار موقت صاحب سیستم
            $reduceTransaction = $objTransaction->decreasePendingCredit( $total_price, $factorNumber, $comment, 'buy_entertainment', $checkBankIranTech );
            if ( $reduceTransaction ) {
                $objFactorEntertainment->updateSuccessfull( $factorNumber, 'bank' );
                echo 'TRUE';
            } else {
                echo 'FALSE';
            }

        } else {
            echo 'FALSE';
        }

    } else {
        echo 'FALSE';
    }

}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'buyByCreditTourLocal' ) {

//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');

    unset( $_POST['flag'] );
    $factorNumber   = trim( $_POST['factorNumber'] );
    /** @var members $objMember*/
    $objMember      = Load::controller( 'members' );
    $objTransaction = Load::controller( 'transaction' );

    // Caution: اعتبار همکار(آژانس همکار با صاحب پنل ) که ممکنه  خود صاحب سیستم باشد یا همکار دیگری که کانتری که خرید میکند شامل این همکار است
    $counterCredit = $objMember->getCredit();

    $reserveInfo = functions::GetInfoTour( $factorNumber );

    $amount = $reserveInfo['total_price'];

    /*	if($reserveInfo['serviceTitle'] == 'PrivateLocalTour' || $reserveInfo['serviceTitle'] == 'PrivatePortalTour' ){

        }*/
    $total_price = 0;// تور همواره اختصاصی هست پس هزینه ایی از صاحب سیستم کسر نمیشود

    if ( $_POST['paymentStatus'] == 'prePayment' ) {
        $comment = ' پیش رزرو تور ';
        /*if (isset($reserveInfo['irantech_commission']) && $reserveInfo['irantech_commission'] > 0){
            $total_price += $reserveInfo['irantech_commission'] * $reserveInfo['CountId'];
        }*/
        $status='PreReserve';
    } else {
        $comment = 'رزرو قطعی تور ';
        $status='BookedSuccessfully';
    }




    $comment .= $reserveInfo['tour_name'] . ' ' . $reserveInfo['tour_code'] . ' از تاریخ: ' . $reserveInfo['tour_start_date'] . ' تا تاریخ: ' . $reserveInfo['tour_end_date'];
    if ( $reserveInfo['tour_night'] > 0 ) {
        $comment .= " به مدت: " . $reserveInfo['tour_night'] . " شب " . $reserveInfo['tour_day'] . " روز ";
    } else {
        $comment .= " به مدت: " . $reserveInfo['tour_day'] . " روز ";
    }
    $comment .= ' به مقصد: ' . $reserveInfo['tour_cities'] . '  شماره فاکتور: ' . $reserveInfo['factor_number'];


    // Caution: اعتبارسنجی اعتبار کانتر
    if ( $counterCredit > $amount ) {

        // Caution: کاهش اعتبار کانتر


        $reservation_tour=new reservationTour();
        $tour_status_changer=$reservation_tour->tourBookChanger($factorNumber,[
            //                'status'=>$status,
            'payment_status'=>$_POST['paymentStatus']
        ]);


        $objMember->decreaseCounterCredit( $amount, $factorNumber, $reserveInfo, 'reservationTour', 'no' );

        // Caution: اعتبارسنجی صاحب سیستم
        $check = $objTransaction->checkCredit( $total_price );
        if ( $check['status'] == 'TRUE' ) {



            // Caution: کاهش اعتبار صاحب سیستم
            $reduceTransaction = $objTransaction->decreaseSuccessCredit( $total_price, $factorNumber, $comment, 'buy_reservation_tour' );

            if ( $reduceTransaction ) {

                echo 'success:' . $total_price;
            } else {
                echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCredit' );
            }

        } else {
            echo 'error :' . functions::Xmlinformation( 'ChargeRialSystem' );
        }


    } else {
        echo 'error :' . functions::Xmlinformation( 'EndCreditAgency' );
    }
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'buyByCreditEntertainment' ) {

    unset( $_POST['flag'] );
    $factorNumber     = trim( $_POST['factorNumber'] );
    $objEntertainment = Load::controller( 'entertainment' );
    $objTransaction   = Load::controller( 'transaction' );
    $objMember        = Load::controller( 'members' );

    // Caution: اعتبار همکار(آژانس همکار با صاحب پنل ) که ممکنه  خود صاحب سیستم باشد یا همکار دیگری که کانتری که خرید میکند شامل این همکار است
    $counterCredit = $objMember->getCredit();


    $reserveInfo   = $objEntertainment->GetInfoEntertainment( $factorNumber );
    $CounterAmount = $reserveInfo['DiscountPrice'];
    $AgencyPrice   = 0 + ( $reserveInfo['irantech_commission'] * $reserveInfo['CountPeople'] );
    $total_price   = $reserveInfo['DiscountPrice'];
    // Caution: اعتبارسنجی اعتبار کانتر
    if ( $counterCredit > $CounterAmount ) {


        // Caution: اعتبارسنجی صاحب سیستم
        $check = $objTransaction->checkCredit( $AgencyPrice );


        if ( $check['status'] == 'TRUE' ) {
            // Caution: کاهش اعتبار کانتر
            $objMember->decreaseCounterCredit( $total_price, $reserveInfo['requestNumber'], $reserveInfo, 'yes' );
            $comment = 'رزرو تفریحات به شماره واچر : ' . $reserveInfo['requestNumber'];
            // Caution: کاهش اعتبار صاحب سیستم
            $reduceTransaction = $objTransaction->decreaseSuccessCredit( $AgencyPrice, $factorNumber, $comment, 'buy_entertainment' );

            if ( $reduceTransaction ) {
                echo 'success:' . $total_price;
            } else {
                echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCredit' );
            }

        } else {
            echo 'error :' . functions::Xmlinformation( 'ChargeRialSystem' );
        }


    } else {
        echo 'error :' . functions::Xmlinformation( 'EndCreditAgency' );
    }
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'check_credit_reservation_ticket' ) {

    unset( $_POST['flag'] );
    $amount         = $paymentPrice = trim( $_POST['paymentPrice'] );
    $factorNumber   = trim( $_POST['factorNumber'] );
    $objTransaction = Load::controller( 'transaction' );

    $reserveInfo       = functions::GetInfoReservationTicket( $factorNumber );
    $checkBankIranTech = functions::CheckGetWayIranTech( CLIENT_ID );
    if ( $checkBankIranTech ) {
        // مبلغ تراکنش برای صاحب پنل 10000 ریال (آقای افشار گفتن) //
        $total_price = $reserveInfo['total_price'] - ( 10000 * $reserveInfo['countPassengers'] );
        $comment     = '  سود ناشی از خرید بلیط  ' . $reserveInfo['typeReservation'] . ' رزرواسیون ' . $reserveInfo['multiWay'] . ' ' . $reserveInfo['origin_city'] . " - " . $reserveInfo['desti_city'] . " " . "به شماره رزرو " . " " . $reserveInfo['factor_number'] . 'از طریق درگاه سفر360';

    } else {
        // مبلغ تراکنش برای صاحب پنل 10000 ریال (آقای افشار گفتن) //
        $total_price = 10000 * $reserveInfo['countPassengers'];
        $comment     = ' خرید بلیط ' . $reserveInfo['typeReservation'] . ' رزرواسیون ' . $reserveInfo['multiWay'] . ' ' . $reserveInfo['origin_city'] . " - " . $reserveInfo['desti_city'] . " " . "به شماره رزرو " . " " . $reserveInfo['factor_number'];

    }

    $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );
    if ( empty( $existTransaction ) ) {

        // Caution: کاهش اعتبار موقت صاحب سیستم
        $reduceTransaction = $objTransaction->decreasePendingCredit( $total_price, $factorNumber, $comment, 'buy_reservation_ticket', $checkBankIranTech );

        if ( $reduceTransaction ) {
            echo 'TRUE';
        } else {
            echo 'FALSE';
        }

    } else {
        echo 'FALSE';
    }
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'buyByCreditReservationTicket' ) {

    unset( $_POST['flag'] );
    $factorNumber = trim( $_POST['factorNumber'] );
    $amount       = trim( $_POST['paymentPrice'] );

    $objMember      = Load::controller( 'members' );
    $objTransaction = Load::controller( 'transaction' );

    // Caution: اعتبار همکار(آژانس همکار با صاحب پنل ) که ممکنه  خود صاحب سیستم باشد یا همکار دیگری که کانتری که خرید میکند شامل این همکار است
    $counterCredit = $objMember->getCredit();

    $reserveInfo = functions::GetInfoReservationTicket( $factorNumber );

    // Caution: اعتبارسنجی اعتبار کانتر
    if ( $counterCredit > $amount ) {

        // Caution: کاهش اعتبار کانتر
        $objMember->decreaseCounterCredit( $amount, $factorNumber, $reserveInfo, 'ReservationTicket' );

        // مبلغ تراکنش برای صاحب پنل 10000 ریال (آقای افشار گفتن) //
        $total_price = 10000 * $reserveInfo['countPassengers'];
        $comment     = ' خرید بلیط ' . $reserveInfo['typeReservation'] . ' رزرواسیون ' . $reserveInfo['multiWay'] . ' ' . $reserveInfo['origin_city'] . " - " . $reserveInfo['desti_city'] . " " . "به شماره رزرو " . " " . $reserveInfo['factor_number'];

        $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );
        if ( empty( $existTransaction ) ) {

            // Caution: کاهش اعتبار صاحب سیستم
            $reduceTransaction = $objTransaction->decreaseSuccessCredit( $total_price, $factorNumber, $comment, 'buy_reservation_ticket' );

            if ( $reduceTransaction ) {
                echo 'success:' . $amount;
            } else {
                echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCredit' );
            }

        } else {
            echo 'error:' . functions::Xmlinformation( 'ChargeRialSystem' );
        }

    } else {
        echo 'error :' . functions::Xmlinformation( 'EndCreditAgency' );
    }
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'check_credit_visa' ) {

    unset( $_POST['flag'] );
    $factorNumber   = trim( $_POST['factorNumber'] );
    $objFactorVisa  = Load::controller( 'factorVisa' );
    $objTransaction = Load::controller( 'transaction' );

    $reserveInfo = $objFactorVisa->getVisaInfoByFactorNumber( $factorNumber );

    $checkBankIranTech = functions::CheckGetWayIranTech( CLIENT_ID );
    if ( $checkBankIranTech ) {
        $total_price = $reserveInfo['visa_prepayment_cost'] - ( $reserveInfo['irantech_commission'] * $reserveCount['reserveCount'] );
        $comment     = 'سود ناشی از رزرو ویزا: ' . $reserveInfo['visa_title'] . ' (' . $reserveInfo['visa_type'] . ') ' . ' به مقصد ' . $reserveInfo['visa_destination'] . ' به شماره فاکتور: ' . $reserveInfo['factor_number'] . 'از طریق درگاه بانکی سفر360';

    } else {
        $total_price = 0;
        $comment     = 'رزرو ویزا: ' . $reserveInfo['visa_title'] . ' (' . $reserveInfo['visa_type'] . ') ' . ' به مقصد ' . $reserveInfo['visa_destination'] . ' به شماره فاکتور: ' . $reserveInfo['factor_number'];

    }

    $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );
    if ( empty( $existTransaction ) ) {

        // Caution: کاهش اعتبار موقت صاحب سیستم
        $reduceTransaction = $objTransaction->decreasePendingCredit( $total_price, $factorNumber, $comment, 'buy_reservation_visa', $checkBankIranTech );

        if ( $reduceTransaction ) {
            echo 'TRUE';
        } else {
            echo 'FALSE';
        }

    } else {
        echo 'FALSE';
    }
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'buyByCreditVisa' ) {

    unset( $_POST['flag'] );
    $factorNumber = trim( $_POST['factorNumber'] );

    $objMember      = Load::controller( 'members' );
    $objFactorVisa  = Load::controller( 'factorVisa' );
    $objTransaction = Load::controller( 'transaction' );

    // Caution: اعتبار همکار(آژانس همکار با صاحب پنل ) که ممکنه  خود صاحب سیستم باشد یا همکار دیگری که کانتری که خرید میکند شامل این همکار است
    $counterCredit = $objMember->getCredit();

    $reserveInfo = $objFactorVisa->getVisaInfoByFactorNumber( $factorNumber );
    $amount      = $reserveInfo['visa_prepayment_cost'] * $reserveInfo['reserveCount'];

    // Caution: اعتبارسنجی اعتبار کانتر
    if ( $counterCredit > $amount ) {

        // Caution: کاهش اعتبار کانتر
        $objMember->decreaseCounterCredit( $amount, $factorNumber, $reserveInfo, 'reservationVisa' );

        $total_price = 0;
        $comment     = 'رزرو ویزا: ' . $reserveInfo['visa_title'] . ' (' . $reserveInfo['visa_type'] . ') ' . ' به مقصد ' . $reserveInfo['visa_destination'] . ' به شماره فاکتور: ' . $reserveInfo['factor_number'];

        $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );
        if ( empty( $existTransaction ) ) {

            // Caution: کاهش اعتبار صاحب سیستم
            $reduceTransaction = $objTransaction->decreaseSuccessCredit( $total_price, $factorNumber, $comment, 'buy_reservation_visa' );

            if ( $reduceTransaction ) {
                echo 'success:' . $amount;
            } else {
                echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCredit' );
            }

        } else {
            echo 'error:' . functions::Xmlinformation( 'ChargeRialSystem' );
        }

    } else {
        echo 'error :' . functions::Xmlinformation( 'EndCreditAgency' );
    }
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'ChangePriorityDeparture' ) {
    $routeFlight = Load::controller( 'routeFlight' );
    unset( $_POST['flag'] );
    echo $routeFlight->SetPriorityParentDeparture( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'ChangePriorityHotel' ) {
    $routeFlight = Load::controller( 'resultHotelLocal' );
    unset( $_POST['flag'] );
    echo $routeFlight->SetPriorityParentDeparture( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'changeHotelSepehrGlobalId' ) {
    $routeFlight = Load::controller( 'resultHotelLocal' );
    unset( $_POST['flag'] );
    echo $routeFlight->SetHotelSepehrGlobalId( $_POST );
}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'ChangePriorityTour' ) {
    $routeFlight = Load::controller( 'resultTourLocal' );
    unset( $_POST['flag'] );
    echo $routeFlight->SetPriorityParentDeparture( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'ChangePriorityArrival' ) {
    $routeFlight = Load::controller( 'routeFlight' );
    unset( $_POST['flag'] );
    echo $routeFlight->SetPriorityArrival( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'InsertCurrency' ) {
    $currency = Load::controller( 'currency' );
    unset( $_POST['flag'] );
    echo $currency->InsertCurrency( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'EditCurrency' ) {
    $currency = Load::controller( 'currency' );
    unset( $_POST['flag'] );
    echo $currency->EditCurrency( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'StatusCurrency' ) {
    $currency = Load::controller( 'currency' );
    unset( $_POST['flag'] );
    echo $currency->StatusCurrency( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'UpdatePriceGdsCurrency' ) {
    $currency = Load::controller( 'currency' );
    unset( $_POST['flag'] );
    echo $currency->UpdatePriceGdsCurrency( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'UpdatePriceCustomerCurrency' ) {
    $currency = Load::controller( 'currencyEquivalent' );
    unset( $_POST['flag'] );
    echo $currency->UpdatePriceCustomerCurrency( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'StatusCurrencyEquivalent' ) {
    $currency = Load::controller( 'currencyEquivalent' );
    unset( $_POST['flag'] );
    echo $currency->StatusCurrencyEquivalent( $_POST );
}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'StatusCurrencyCustomer' ) {
    $currency = Load::controller( 'currencyEquivalent' );
    unset( $_POST['flag'] );
    echo $currency->StatusCurrencyCustomer( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'DefaultCurrencyEquivalent' ) {
    $currency = Load::controller( 'currencyEquivalent' );
    unset( $_POST['flag'] );
    echo $currency->DefaultCurrencyEquivalent( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'DefaultCurrencyCustomer' ) {
    $currency = Load::controller( 'currencyEquivalent' );
    unset( $_POST['flag'] );
    echo $currency->DefaultCurrencyCustomer( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'CurrencyEquivalent' ) {
    $currency = Load::controller( 'currencyEquivalent' );
    unset( $_POST['flag'] );
    $result = $currency->CurrencyEquivalent( $_POST['ValCurrency'] );

    echo json_encode( $result );
}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'ListCurrencyEquivalent' ) {
    $currency = Load::controller( 'currencyEquivalent' );
    unset( $_POST['flag'] );
    $result = $currency->ListCurrencyEquivalent();

    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'interactiveOffCodesAdd' ) {

    $controller = Load::controller( 'interactiveOffCodes' );
    unset( $_POST['flag'] );
    $result = $controller->interactiveOffCodesAdd( $_POST );

    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'interactiveOffCodesEdit' ) {

    $controller = Load::controller( 'interactiveOffCodes' );
    unset( $_POST['flag'] );
    $result = $controller->interactiveOffCodesEdit( $_POST );

    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'reSendInteractiveSms' ) {

    $controller = Load::controller( 'interactiveOffCodes' );
    unset( $_POST['flag'] );
    $result = $controller->reSendOffCode( $_POST );

    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'AmountAdded' ) {

    $parvazBookingLocal = Load::controller( 'parvazBookingLocal' );
    unset( $_POST['flag'] );
    $result = $parvazBookingLocal->AmountAdded( $_POST );

    echo $result;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'currencyPayment' ) {

    unset( $_POST['flag'] );

    $memberId                = Session::getUserId();
    $arg                     = array(
        'factorNumber'    => FILTER_SANITIZE_NUMBER_INT,
        'cardNumber'      => FILTER_SANITIZE_NUMBER_INT,
        'cardExpireMonth' => FILTER_SANITIZE_NUMBER_INT,
        'cardExpireYear'  => FILTER_SANITIZE_NUMBER_INT,
        'cardCVC'         => FILTER_SANITIZE_NUMBER_INT,
        'amount'          => FILTER_SANITIZE_STRING,
        'currencyCode'    => FILTER_VALIDATE_INT,
        'discountCode'    => FILTER_SANITIZE_STRING,
    );
    $dataPost                = filter_var_array( $_POST, $arg );
    $dataPost['serviceType'] = $_POST['serviceType']; //serviceType can be string or array, and this is why i didnt filter it

    #region discount code
    if ( $dataPost['discountCode'] != '' ) {

        $discountCodes      = Load::controller( 'discountCodes' );
        $dataPost['amount'] = $discountCodes->reduceAmountViaDiscountCode( $dataPost['amount'], $dataPost['factorNumber'], $memberId, $dataPost['discountCode'], $dataPost['serviceType'], $dataPost['currencyCode'] );

    }
    #endregion

    $apiStripe = Load::library( 'apiStripe' );
    $apiStripe->init();
    $resultToken = $apiStripe->createCardToken( $dataPost );

    if ( $resultToken['status'] ) {

        //update fields related to bank in bookings
        functions::setBankToBookByService( $dataPost['serviceType'], $apiStripe->bankDir, $dataPost['factorNumber'] );

        $currency     = Load::controller( 'currencyEquivalent' );

        $currencyInfo = $currency->InfoCurrency( $dataPost['currencyCode'] );

        $dataPayment = array(
            'amount'       => $dataPost['amount'],
            'currency'     => $currencyInfo['CurrencyTitleEn'],
            'token'        => $resultToken['token'],
            'factorNumber' => $dataPost['factorNumber'],
            'description'  => 'Purchase of factor number: ' . $dataPost['factorNumber'],
        );

        $result = $apiStripe->chargeByToken( $dataPayment );

        if ( $result['status'] ) {

            $output['result_status']  = 'success';
            $output['result_message'] = $result['result'];

        } else {
            $output['result_status']  = 'error';
            $output['result_message'] = $result['message'];
        }

    } else {
        $output['result_status']  = 'error';
        $output['result_message'] = $resultToken['message'];
    }

    echo json_encode( $output );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'FlightZone' ) {
    $FlightZone = functions::InfoRouteApp( $_POST['Code'], $_POST['Type'] );
    echo json_encode( $FlightZone );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'getResultTicketLocalApp' ) {

    $TicketInternalApp = Load::controller( 'TicketInternalApp' );
    unset( $_POST['flag'] );
    $ResultTicketApp = $TicketInternalApp->ShowUiTicket( $_POST );
    echo json_encode( $ResultTicketApp );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'getResultTicketForeignApp' ) {

    $TicketInternalApp = Load::controller( 'TicketForeignApp' );

    unset( $_POST['flag'] );
    $ResultTicketApp = $TicketInternalApp->ShowUiTicket( $_POST );
    echo json_encode( $ResultTicketApp );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'CountryCodeApp' ) {

    $ResultTicketApp = functions::ChoosCountryPassenger( $_POST['Code'], $_POST['Type'] );
    echo json_encode( $ResultTicketApp );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insertPassenger' ) {

    $TicketInternalApp = Load::controller( 'factorLocal' );
    unset( $_POST['flag'] );
    echo $TicketInternalApp->getSpecific( $_POST );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'GoToBankApp' ) {


    $data = json_decode( $_POST['formData'], true );

    echo Load::plog( $data );

    $ParvazBookingLocalController = Load::controller( 'parvazBookingLocal' );
    $BankController               = Load::controller( 'bank' );

    if ( $data['bankType'] != 'credit' ) {
        $ParvazBookingLocalController->setPortBank( $data['bankType'], $data['RequestNumber'] );
    }
    $BankController->initBankParams( $data['bankType'] );
    $BankController->calculateAmount( 'local', $data['RequestNumber'] );
    $BankController->executeBank( 'go' );

    if ( $BankController->failMessage == '' ) {
        $BankController->sendUserToBank( $BankController->factorNumber );
    }

    ?>
    <script language="javascript" type="text/javascript">
        function sendForm(link, inputs) {
            var form = document.createElement("form");
            form.setAttribute("method", "POST");
            form.setAttribute("action", link);

            var decodedInputs = $.parseJSON(inputs);
            $.each(decodedInputs, function (i, item) {
                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("name", i);
                hiddenField.setAttribute("value", item);
                form.appendChild(hiddenField);
            });

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
    </script>

    <?php


} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'DateSelectedApp' ) {
    unset( $_POST['flag'] );

    $Date                         = functions::OtherFormatDate( $_POST['DateSelected'] );
    $DateSelected['DateSelected'] = $Date['LetterDay'] . ' ' . $Date['NowDay'];
    $DateSelected['DateNext']     = functions::DateNext( $_POST['DateSelected'] );
    $DateSelected['DatePrev']     = functions::DatePrev( $_POST['DateSelected'] );
    echo json_encode( $DateSelected );
} //ZOMOROD
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'UpdateCounterDetail' ) {
    unset( $_POST['flag'] );

    $EmeraldController = Load::controller( 'Emerald' );
    $result            = $EmeraldController->UpdateUserDetail( $_POST );

    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'RequestZomorod' ) {
    unset( $_POST['flag'] );

    $EmeraldController = Load::controller( 'Emerald' );
    $result            = $EmeraldController->RequestZomorod( $_POST );

    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'VerifyRequestEmerald' ) {
    unset( $_POST['flag'] );

    $EmeraldController = Load::controller( 'Emerald' );
    $result            = $EmeraldController->VerifyRequestZomorod( $_POST );

    echo $result;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'convertJalaliToGregorian' ) {
    unset( $_POST['flag'] );

    $jalaliDate = str_replace( '/', '-', $_POST['jDate'] );
    $gregDate   = functions::ConvertToMiladi( $jalaliDate );
    $gregDate   = str_replace( '-', '/', $gregDate );

    echo $gregDate;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'organizationAdd' ) {

    unset( $_POST['flag'] );
    $controller = Load::controller( 'organizationLevel' );
    $result     = $controller->organizationAdd( $_POST );

    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'organizationEdit' ) {

    unset( $_POST['flag'] );
    $controller = Load::controller( 'organizationLevel' );
    $result     = $controller->organizationEdit( $_POST );

    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'organizationDelete' ) {

    unset( $_POST['flag'] );
    $controller = Load::controller( 'organizationLevel' );

    echo $controller->organizationDelete( $_POST['id'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'RequestTicketOffline' ) {

    unset( $_POST['flag'] );
    $controller = Load::controller( 'RequestTicketOffline' );
    echo $controller->RequestTicketOffline( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'ChangeSourceStatus' ) {

    $controller = Load::controller( 'source' );
    unset( $_POST['flag'] );
    echo $controller->changeFlightSourceStatus( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'PassengerOld' ) {
    unset( $_POST['flag'] );

    $passengerController = Load::controller( 'passengers' );
    $result              = $passengerController->SelectPassengerOld();

    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'SendMessageClient' ) {
    unset( $_POST['flag'] );

    $MessageController = Load::controller( 'messageClientOnline' );
    $result            = $MessageController->insertMessage( $_POST );

    echo $result;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'DeleteMessageClientOnline' ) {
    unset( $_POST['flag'] );

    $MessageController = Load::controller( 'messageClientOnline' );
    $result            = $MessageController->DeleteMessage( $_POST['id'] );

    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'get_routs' ) {
    unset( $_POST['flag'] );

    $AirportArrival = Load::controller( 'resultLocal' );
    $result         = $AirportArrival->getAirportArrival( $_POST['departure'] );

    echo '<option value="0"> ' . functions::Xmlinformation( 'ChoseOption' ) . '  </option>';
    foreach ( $result as $rout ) {
        echo '<option value="' . $rout['Arrival_Code'] . '">' . $rout['Arrival_City'] . ' (' . $rout['Arrival_Code'] . ')</span></option>';
    }
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'infoSourceTrust' ) {
    unset( $_POST['flag'] );
    $MessageController = Load::controller( 'infoSourceTrust' );
    echo $MessageController->InsertInfoSourceTrust( $_POST );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'check_credit_gasht' ) {

    $factorNumber = filter_var( $_POST['factorNumber'], FILTER_SANITIZE_NUMBER_INT );
    if ( $factorNumber != '' ) {

        $Model = Load::library( 'Model' );

        $objTransaction = Load::controller( 'transaction' );

        $queryReserveInfo = "SELECT * FROM book_gasht_local_tb WHERE passenger_factor_num = '{$factorNumber}'";
        $reserveInfo      = $Model->load( $queryReserveInfo );


        $total_price = $reserveInfo['passenger_servicePrice'] * $reserveInfo['passenger_number'];
        $comment     = " رزرو " . " " . $reserveInfo['passenger_number'] . " عدد " . " " . $reserveInfo['passenger_serviceName'] . " به مقصد " . " " . $reserveInfo['passenger_serviceCityName'] . " " . "به شماره فاکتور " . " " . $factorNumber;
        if ( isset( $reserveInfo['irantech_commission'] ) && $reserveInfo['irantech_commission'] > 0 ) {
            $total_price += $reserveInfo['irantech_commission'] * $reserveInfo['passenger_number'];
        }
        // Caution: اعتبارسنجی صاحب سیستم
        $check = $objTransaction->checkCredit( $total_price );

        if ( $check['status'] == 'TRUE' ) {

            $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );
            if ( empty( $existTransaction ) ) {

                // Caution: کاهش اعتبار موقت صاحب سیستم
                $reduceTransaction = $objTransaction->decreasePendingCredit( $total_price, $factorNumber, $comment, 'buy_gasht_transfer' );

                if ( $reduceTransaction ) {
                    echo 'TRUE';
                } else {
                    echo 'FALSE';
                }

            } else {
                echo 'FALSE';
            }

        } else {
            echo 'FALSE';
        }

    } else {
        echo 'FALSE';
    }

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'buyByCreditGasht' ) {

    $Model          = Load::library( 'Model' );
    $objTransaction = Load::controller( 'transaction' );
    $objMember      = Load::controller( 'members' );

    // Caution: اعتبار همکار(آژانس همکار با صاحب پنل ) که ممکنه  خود صاحب سیستم باشد یا همکار دیگری که کانتری که خرید میکند شامل این همکار است
    $counterCredit = $objMember->getCredit();

    $factorNumber     = filter_var( $_POST['factorNumber'], FILTER_SANITIZE_NUMBER_INT );
    $queryReserveInfo = "SELECT * FROM book_gasht_local_tb WHERE passenger_factor_num = '{$factorNumber}'";
    $reserveInfo      = $Model->load( $queryReserveInfo );


    $total_price         = $reserveInfo['passenger_servicePrice'] * $reserveInfo['passenger_number'];
    $total_price_counter = $reserveInfo['passenger_servicePriceAfterOff'] * $reserveInfo['passenger_number'];
    $comment             = " رزرو " . " " . $reserveInfo['passenger_number'] . " عدد " . " " . $reserveInfo['passenger_serviceName'] . " به مقصد " . " " . $reserveInfo['passenger_serviceCityName'] . " " . "به شماره فاکتور " . " " . $factorNumber;

    // Caution: اعتبارسنجی اعتبار کانتر
    if ( $counterCredit > $total_price_counter ) {

        // Caution: کاهش اعتبار کانتر
        $objMember->decreaseCounterCredit( $total_price_counter, $factorNumber, $reserveInfo, 'gasht' );


        if ( isset( $reserveInfo['irantech_commission'] ) && $reserveInfo['irantech_commission'] > 0 ) {
            $total_price += $reserveInfo['irantech_commission'] * $reserveInfo['passenger_number'];
        }

        // Caution: اعتبارسنجی صاحب پنل
        $check = $objTransaction->checkCredit( $total_price );

        if ( $check['status'] == 'TRUE' ) {

            $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );
            if ( empty( $existTransaction ) ) {

                // Caution: کاهش اعتبار صاحب سیستم
                $reduceTransaction = $objTransaction->decreaseSuccessCredit( $total_price, $factorNumber, $comment, 'buy_gasht_transfer' );

                if ( $reduceTransaction ) {
                    echo 'success:' . $total_price_counter;
                } else {
                    echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCredit' );
                }

            } else {
                echo 'error:' . functions::Xmlinformation( 'ChargeRialSystem' );
            }

        } else {
            echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCreditByFactorNumber' );
        }

    } else {
        echo 'error:' . functions::Xmlinformation( 'EndCreditAgency' );
    }

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'SendGashtEmailForOther' ) {
    unset( $_POST['flag'] );
    $members = Load::controller( 'members' );
    $result  = $members->SendGashtEmailForOther( $_POST['email'], $_POST['request_number'] );

    echo $result;

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'check_credit_bus' ) {
    unset( $_POST['flag'] );

    $factorNumber      = trim( $_POST['factorNumber'] );
    /** @var transaction $objTransaction */
    $objTransaction    = Load::controller( 'transaction' );
    $reserveInfo       = functions::GetInfoBus( $factorNumber );
    $checkBankIranTech = functions::CheckGetWayIranTech( CLIENT_ID );


    $comment = " رزرو بلیط اتوبوس " . $reserveInfo['OriginCity'] . " - " . $reserveInfo['DestinationCity'] . " (" . $reserveInfo['CompanyName'] . ")، تاریخ حرکت: " . $reserveInfo['DateMove'] . " - ساعت حرکت: " . $reserveInfo['TimeMove'] . " به شماره فاکتور: " . $reserveInfo['passenger_factor_num'];
    $reason  = 'buy_bus';
    if ( $reserveInfo['WebServiceType'] == 'private' ) {
        $total_price_transaction = 0;
    } else {
        $total_price_transaction = $reserveInfo['price_api'];
    }


    if ( isset( $reserveInfo['irantech_commission'] ) && $reserveInfo['irantech_commission'] > 0 ) {
//		$total_price_transaction += $reserveInfo['irantech_commission'] * $reserveInfo['CountId'];
    }

    if ( $reserveInfo['WebServiceType'] == 'private' ) {
        //privet


        //اندازه ای که به درگاه میره شارژ میکنیم
        $priceIranTechCharge = $reserveInfo['total_price'];


        //اندازه ای که باید ازش کم کنیم
        if ( isset( $reserveInfo['irantech_commission'] ) && $reserveInfo['irantech_commission'] > 0 ) {
//			$priceIranTechDecrease = ( $reserveInfo['irantech_commission'] * $reserveInfo['CountId'] );
            $priceIranTechDecrease = 0;

        } else {
            $priceIranTechDecrease = 0;
        }


    } else {
        //public

        //اندازه ای که به درگاه میره شارژ میکنیم
        $priceIranTechCharge = $reserveInfo['total_price'];

        //اندازه ای که باید ازش کم کنیم
        /*if ( isset( $reserveInfo['irantech_commission'] ) && $reserveInfo['irantech_commission'] > 0 ) {
            $priceIranTechDecrease = $reserveInfo['total_price'] + ( $reserveInfo['irantech_commission'] * $reserveInfo['CountId'] );
        } else {
            $priceIranTechDecrease = $reserveInfo['total_price'];
        }*/

        $total_price_transaction=$total_price_transaction-functions::calculatePercentage($total_price_transaction,0);


    }

    $priceIranTechCharge = ( round( $priceIranTechCharge ) );

    //    $priceIranTechDecrease=(round($priceIranTechDecrease,-4));
    //    $total_price_transaction=(round($total_price_transaction,-4));


    // Caution: اعتبارسنجی صاحب سیستم
    $check = $objTransaction->checkCredit( $total_price_transaction, 'online','', $priceIranTechCharge);

    echo json_encode($check,256);

    if ( $check['status'] == 'TRUE' ) {


        sleep(1);
        $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );
        if ( empty( $existTransaction ) ) {

            if ( $checkBankIranTech ) {
                $commentIranTech = 'شارژ درگاه سفر360 برای خرید اتوبوس  به شماره رزرو ' . $factorNumber . 'از این درگاه ';
                functions::insertLog( 'in GetWayIranTech With factorNumber=>' . $factorNumber . ' has Amount Ticket=>' . $priceIranTechCharge, 'iranTechGetWayBuy' );
                // در صورتی که از درگاه ایران تک استفاده میشد،یک رکورد بابت شارژ به اندازه هزینه بلیط زده میشه به صورت موقت و در برگشت از بانک در صورت موفقیت اوکی میشه
                $objTransaction->InsertChargeThrowIranTechGetWay( $priceIranTechCharge, $factorNumber, $commentIranTech );
                sleep( 1 );
            }

            // Caution: کاهش اعتبار موقت صاحب سیستم
            $reduceTransaction = $objTransaction->decreasePendingCredit( $total_price_transaction, $factorNumber, $comment, $reason );
            if ( $reduceTransaction ) {
                $output = 'TRUE';
            } else {
                $output = 'FALSE';
            }

        } else {
            $output = 'FALSE';
        }

    } else {
        $output = 'FALSE';
    }
    echo $output;


} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'buyByCreditBus' ) {
    unset( $_POST['flag'] );

    $factorNumber = trim( $_POST['factorNumber'] );

    //    functions::insertLog($factorNumber,'factornumberr');


    $objMember      = Load::controller( 'members' );
    $objTransaction = Load::controller( 'transaction' );

    // Caution: اعتبار همکار(آژانس همکار با صاحب پنل ) که ممکنه  خود صاحب سیستم باشد یا همکار دیگری که کانتری که خرید میکند شامل این همکار است
    $counterCredit = $objMember->getCredit();

    $reserveInfo = functions::GetInfoBus( $factorNumber );

    // Caution: اعتبارسنجی اعتبار کانتر
    if ( $counterCredit > $reserveInfo['total_price'] ) {


        $comment = " رزرو بلیط اتوبوس " . $reserveInfo['OriginCity'] . " - " . $reserveInfo['DestinationCity'] . " (" . $reserveInfo['CompanyName'] . ")، تاریخ حرکت: " . $reserveInfo['DateMove'] . " - ساعت حرکت: " . $reserveInfo['TimeMove'] . " به شماره فاکتور: " . $reserveInfo['passenger_factor_num'];
        if ( $reserveInfo['WebServiceType'] == 'private' ) {
            $total_price_transaction = 0;
        } else {
            $total_price_transaction = $reserveInfo['price_api'];
        }
        $reason      = 'buy_bus';
        $checkRepeat = 'yes';
        if ($reserveInfo['WebServiceType'] != 'private') {
//          if (isset($reserveInfo['irantech_commission']) && $reserveInfo['irantech_commission'] > 0) {
//              $total_price_transaction += $reserveInfo['irantech_commission'] * $reserveInfo['CountId'];
//          }
            $total_price_transaction=$total_price_transaction-functions::calculatePercentage($total_price_transaction,0);
        }

        // Caution: کاهش اعتبار کانتر
        $objMember->decreaseCounterCredit($reserveInfo['total_price'], $factorNumber, $reserveInfo, 'Bus', $checkRepeat);

        // Caution: اعتبارسنجی صاحب پنل
        $check = $objTransaction->checkCredit( $total_price_transaction );

        if ( $check['status'] == 'TRUE' ) {
            sleep(1);
            $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );
            if ( empty( $existTransaction ) ) {

                // Caution: کاهش اعتبار صاحب سیستم
                $reduceTransaction = $objTransaction->decreaseSuccessCredit( $total_price_transaction, $factorNumber, $comment, $reason );


                if ( $reduceTransaction ) {
                    echo 'success:' . $reserveInfo['total_price'];
                } else {
                    echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCredit' );
                }

            } else {
                echo 'error:' . functions::Xmlinformation( 'ChargeRialSystem' );
            }

        } else {
            echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCreditByFactorNumber' );
        }

    } else {
        echo 'error: ' . functions::Xmlinformation( 'EndCreditAgency' );
    }


} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'SendBusEmailForOther' ) {
    unset( $_POST['flag'] );
    $members = Load::controller( 'members' );
    $result  = $members->SendBusEmailForOther( $_POST['email'], $_POST['request_number'] );

    echo $result;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'nextPageTicketForeign' ) {
    unset( $_POST['flag'] );
    $resultLocal = Load::controller( 'resultLocal' );
    $result      = $resultLocal->getTicketForeign( $_POST['nameFile'], $_POST['optionPage'] );

    echo $result;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'detailTicketForeign' ) {
    unset( $_POST['flag'] );
    $flightForeign       = Load::controller( 'flightForeign' );
    $flightForeignResult = $flightForeign->detailTicketForeign( $_POST );

    echo $flightForeignResult;

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'createExcelFile' ) {
    unset( $_POST['flag'] );

    $objBookShow = Load::controller( 'bookshow' );
    $_POST['report_for_excel'] = true;
    $result      = $objBookShow->createExcelFile( $_POST );

    echo $result;

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'newsLetterExcelForm' ) {
    unset( $_POST['flag'] );

    $objNewsLetterShow = Load::controller( 'newsLetter' );
    $_POST['report_for_excel'] = true;
    $result      = $objNewsLetterShow->createNewsLetterExcel( $_POST );

    echo $result;

}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'createExcelFileForInsurance' ) {
    unset( $_POST['flag'] );

    $objBookShow = Load::controller( 'bookingInsurance' );
    $result      = $objBookShow->createExcelFile( $_POST );

    echo $result;

}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'createExcelForRavisFlight' ) {
    unset( $_POST['flag'] );

    $objBookShow = Load::controller( 'bookshow' );
    $result      = $objBookShow->createExcelForRavisFlight( $_POST );

    echo $result;

}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'createExcelForRavisHotel' ) {
    unset( $_POST['flag'] );

    $objBookShow = Load::controller( 'bookshow' );
    $result      = $objBookShow->createExcelForRavisHotel( $_POST );

    echo $result;

}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'createExcelFileForTransactionUser' ) {
    unset( $_POST['flag'] );

    $objBookShow = Load::controller( 'accountcharge' );
    $result      = $objBookShow->createExcelFile( $_POST );

    echo $result;

}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'newCreateExcelFileForTransactionUser' ) {
//   error_reporting( 1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
    unset( $_POST['flag'] );

    $objBookShow = Load::controller( 'accountcharge' );
    $result      = $objBookShow->createNewExcelFile( $_POST );

    echo $result;

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'createExcelFileForMainUserBuy' ) {
    unset( $_POST['flag'] );

    $objBookShow = Load::controller( 'memberReportBuy' );
    $result      = $objBookShow->createExcelFile( $_POST );

    echo $result;

}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'InsertAgencyCore' ) {
    unset( $_POST['flag'] );

    $data = json_encode( $_POST );

    $url = $apiAddress . "/baseFile/agency/";

    $resultSendData = functions::curlExecution( $url, $data, 'yes' );

    echo json_encode( $resultSendData );
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insertSourceAgency' ) {
    unset( $_POST['flag'] );

    $data = json_encode( $_POST );

    $url = $apiAddress . "/baseFile/sourceUser/";

    $resultSendData = functions::curlExecution( $url, $data, 'yes' );

    echo json_encode( $resultSendData );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'changeStatusSource' ) {
    unset( $_POST['flag'] );

    $data = json_encode( $_POST );

    $url = $apiAddress . "/baseFile/source/";

    $resultSendData = functions::curlExecution( $url, $data, 'yes' );

    echo json_encode( $resultSendData );
}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'changeStatusCore' ) {
    unset( $_POST['flag'] );

    $data = json_encode( $_POST );

    $url = $apiAddress . "/baseFile/source/";

    $resultSendData = functions::curlExecution( $url, $data, 'yes' );

    echo json_encode( $resultSendData );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'changeStatusSourceAgencyInternal' ) {
    unset( $_POST['flag'] );

    $data = json_encode( $_POST );

    $url = $apiAddress . "/baseFile/sourceUser/";

    $resultSendData = functions::curlExecution( $url, $data, 'yes' );

    echo json_encode( $resultSendData );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'changeStatusSourceAgencyExternal' ) {
    unset( $_POST['flag'] );

    $data = json_encode( $_POST );

    $url = $apiAddress . "/baseFile/sourceUser/";

    $resultSendData = functions::curlExecution( $url, $data, 'yes' );

    echo json_encode( $resultSendData );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'editSourceAgency' ) {
    unset( $_POST['flag'] );

    $data = json_encode( $_POST );

    $url = $apiAddress . "/baseFile/sourceUser/";

    $resultSendData = functions::curlExecution( $url, $data, 'yes' );

    echo json_encode( $resultSendData );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'detailRulCancelTicket' ) {
    unset( $_POST['flag'] );

    $data = json_decode( $_POST['param'], true );

    $flightForeignResult = functions::cancelingRules( $data );

    echo $flightForeignResult;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'buyByCreditTrain' ) {

    $Model          = Load::library( 'Model' );
    $objTransaction = Load::controller( 'transaction' );
    $objMember      = Load::controller( 'members' );

    // Caution: اعتبار همکار(آژانس همکار با صاحب پنل ) که ممکنه  خود صاحب سیستم باشد یا همکار دیگری که کانتری که خرید میکند شامل این همکار است
    $counterCredit    = $objMember->getCredit();
    $factorNumber     = filter_var( $_POST['factorNumber'], FILTER_SANITIZE_NUMBER_INT );
    $query_totalprice = "SELECT (sum(Cost)-sum(IFNULL(discount_inf_price,0))) + sum( IFNULL(service_price,0) ) AS total_price FROM book_train_tb WHERE factor_number = '{$factorNumber}'";
    $totalPrice       = $Model->load( $query_totalprice );
    $queryReserveInfo = "SELECT * FROM book_train_tb WHERE factor_number = '{$factorNumber}'";
    $reserveInfo      = $Model->select( $queryReserveInfo );


    //    $total_price = $reserveInfo['Price'] * $reserveInfo['passenger_number'];
    //    $total_price_counter = $reserveInfo['servicePriceAfterOff'] * $reserveInfo['passenger_number'];
    $comment = " رزرو " . " " . count( $reserveInfo ) . " عدد " . " بلیط قطار از" . $reserveInfo[0]['Departure_City'] . " به  " . " " . $reserveInfo[0]['Arrival_City'] . " در تاریخ " . " " . $reserveInfo[0]['MoveDate'] . "به شماره فاکتور " . " " . $factorNumber;

    // Caution: اعتبارسنجی اعتبار کانتر
    if ( $counterCredit > $totalPrice['total_price'] ) {

        // Caution: کاهش اعتبار کانتر

        $objMember->decreaseCounterCredit( $totalPrice['total_price'], $factorNumber, $reserveInfo, 'Train' );


        if ( isset( $reserveInfo[0]['irantech_commission'] ) && $reserveInfo[0]['irantech_commission'] > 0 ) {
            $total_price += $reserveInfo[0]['irantech_commission'] * count( $reserveInfo );
        }

        // Caution: اعتبارسنجی صاحب پنل
        $check = $objTransaction->checkCredit( $total_price );

        if ( $check['status'] == 'TRUE' ) {

            $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );
            if ( empty( $existTransaction ) ) {

                // Caution: کاهش اعتبار صاحب سیستم
                $reduceTransaction = $objTransaction->decreaseSuccessCredit( $total_price, $factorNumber, $comment, 'buy_Train_transfer' );

                if ( $reduceTransaction ) {
                    echo 'success:1000';
                } else {
                    echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCredit' );
                }

            } else {
                echo 'error:' . functions::Xmlinformation( 'ChargeRialSystem' );
            }

        } else {
            echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCreditByFactorNumber' );
        }

    } else {
        echo 'error:' . functions::Xmlinformation( 'EndCreditAgency' );
    }
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'check_credit_train' ) {

    $factorNumber = filter_var( $_POST['factorNumber'], FILTER_SANITIZE_NUMBER_INT );
    if ( $factorNumber != '' ) {

        $Model = Load::library( 'Model' );

        $objTransaction = Load::controller( 'transaction' );
        //        $query_totalprice = "SELECT sum(Cost) + sum( IFNULL(service_price,0) ) AS total_price FROM book_train_tb WHERE factor_number = '{$factorNumber}'";
        //        $total_price = $Model->load($query_totalprice);
        $queryReserveInfo = "SELECT * FROM book_train_tb WHERE factor_number = '{$factorNumber}'";
        $reserveInfo      = $Model->select( $queryReserveInfo );

        $checkBankIranTech = functions::CheckGetWayIranTech( CLIENT_ID );

        if ( $checkBankIranTech ) {
            $total_price = 0;
            //        $total_price = $reserveInfo['passenger_servicePrice'] * $reserveInfo['passenger_number'];
            $comment = " رزرو " . " " . count( $reserveInfo ) . " عدد " . " بلیط قطار از" . $reserveInfo[0]['Departure_City'] . " به  " . " " . $reserveInfo[0]['Arrival_City'] . " در تاریخ " . " " . $reserveInfo[0]['MoveDate'] . "به شماره فاکتور " . " " . $factorNumber;
            if ( isset( $reserveInfo[0]['irantech_commission'] ) && $reserveInfo[0]['irantech_commission'] > 0 ) {
                $total_price += $reserveInfo[0]['irantech_commission'] * count( $reserveInfo );
            }
        } else {
            $total_price = 0;
            //        $total_price = $reserveInfo['passenger_servicePrice'] * $reserveInfo['passenger_number'];
            $comment = " رزرو " . " " . count( $reserveInfo ) . " عدد " . " بلیط قطار از" . $reserveInfo[0]['Departure_City'] . " به  " . " " . $reserveInfo[0]['Arrival_City'] . " در تاریخ " . " " . $reserveInfo[0]['MoveDate'] . "به شماره فاکتور " . " " . $factorNumber;
            if ( isset( $reserveInfo[0]['irantech_commission'] ) && $reserveInfo[0]['irantech_commission'] > 0 ) {
                $total_price += $reserveInfo[0]['irantech_commission'] * count( $reserveInfo );
            }
        }

        /*        $total_price = 0;
//        $total_price = $reserveInfo['passenger_servicePrice'] * $reserveInfo['passenger_number'];
        $comment = " رزرو " . " " . count($reserveInfo) . " عدد " . " بلیط قطار از" . $reserveInfo[0]['Departure_City'] . " به  " . " " . $reserveInfo[0]['Arrival_City'] . " در تاریخ " . " " . $reserveInfo[0]['MoveDate'] . "به شماره فاکتور " . " " . $factorNumber;
        if (isset($reserveInfo[0]['irantech_commission']) && $reserveInfo[0]['irantech_commission'] > 0) {
            $total_price += $reserveInfo[0]['irantech_commission'] * count($reserveInfo);
        }*/
        // Caution: اعتبارسنجی صاحب سیستم
        $check = $objTransaction->checkCredit( $total_price, 'online' );

        if ( $check['status'] == 'TRUE' ) {

            $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );
            if ( empty( $existTransaction ) ) {

                // Caution: کاهش اعتبار موقت صاحب سیستم
                $reduceTransaction = $objTransaction->decreasePendingCredit( $total_price, $factorNumber, $comment, 'buy_train' );

                if ( $reduceTransaction ) {
                    echo 'TRUE';
                } else {
                    echo 'FALSE';
                }

            } else {
                echo 'FALSE';
            }

        } else {
            echo 'FALSE';
        }

    } else {
        echo 'FALSE';
    }

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'OnlineSearchTourCity' ) {
    unset( $_POST['flag'] );

    $objFunction = Load::controller( 'reservationBasicInformation' );
    $result      = $objFunction->GetTourCityOnlineSearch( $_POST );

    echo $result;

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'convertToBook' ) {
    unset( $_POST['flag'] );

    $data = Array(
        "ClientID"      => filter_var( $_POST['ClientID'], FILTER_SANITIZE_STRING ),
        "RequestNumber" => filter_var( $_POST['RequestNumber'], FILTER_SANITIZE_STRING ),
        "pnr"           => filter_var( $_POST['pnr'], FILTER_SANITIZE_STRING ),
        "nationalCode"  => filter_var_array( $_POST['nationalCode'], FILTER_SANITIZE_STRING ),
        "eTicketNumber" => filter_var_array( $_POST['eTicketNumber'], FILTER_SANITIZE_STRING )
    );

    $bookshow  = Load::controller( 'bookshow' );
    $InsertPnr = $bookshow->FlightConvertToBook( $data );


    echo $InsertPnr;


} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'getUerBuy' ) {
    unset( $_POST['flag'] );
    $objUserBuy = Load::controller( 'userBuy' );
    $methodName = 'get' . ucfirst( $_POST['appType'] ) . 'BuyList';

    echo $objUserBuy->$methodName( $_POST );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'getUserBook' ) {
    unset( $_POST['flag'] );
    $objUserBuy = Load::controller( 'userBuy' );
    $methodName = 'getBuyBookMember';

    echo $objUserBuy->$methodName( $_POST );

}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'memberResultSearch' ) {
//   var_dump('cccccc');
//   die;
    unset( $_POST['flag'] );
    $objUserBuy = Load::controller( 'userBuy' );
    echo $objUserBuy->getBuyBookMember( $_POST );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'chooseAirport' ) {
    unset( $_POST['flag'] );
    $routeFlight = Load::controller( 'routeFlight' );

    echo $routeFlight->addOrderToRouteFlightForeign( $_POST );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'deleteSortRouteFlightForeign' ) {
    unset( $_POST['flag'] );
    $routeFlight = Load::controller( 'routeFlight' );

    echo $routeFlight->deleteSortRouteFlightForeign( $_POST );


}
//elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'flagRequestCancel' ) {
//	unset( $_POST['flag'] );
//	$controller = Load::controller( 'cancelBuy' );
//	echo $controller->setRequestCancel( $_POST );
//
//}


elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'flagRequestCancelUser' ) {

    unset( $_POST['flag'] );
    $controller = Load::controller( 'cancelBuy' );
    echo $controller->setCancelRequestUser( $_POST );

}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'createExcelFileForCancelReportBuy' ) {
    unset( $_POST['flag'] );

    $controller = Load::controller( 'cancelBuy' );
    $result     = $controller->createExcelFile( $_POST );

    echo $result;

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'flagRejectCancelRequest' ) {
    unset( $_POST['flag'] );

    $controller = Load::controller( 'cancelBuy' );
    $result     = $controller->rejectCancelRequest( $_POST['id'], $_POST['descriptionClient'], $_POST['clientId'] );

    echo $result;

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'flagConfirmCancel' ) {
    unset( $_POST['flag'] );

    $controller = Load::controller( 'cancelBuy' );
    $result     = $controller->confirmCancel( $_POST );

    echo $result;


} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'getUerCancelBuy' ) {
    unset( $_POST['flag'] );

    $objUserBuy = Load::controller( 'userCancelBuy' );
    if ( $_POST['appType'] == 'flight' || $_POST['appType'] == 'train' || $_POST['appType'] == 'bus' ) {
        echo $objUserBuy->getFlightBuyCancelList( $_POST );
    } else {
        echo $objUserBuy->getOtherServiceBuyCancelList( $_POST );
    }


} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'flagRegisterCancelBuy' ) {
    unset( $_POST['flag'] );

    $objUserBuy = Load::controller( 'cancelBuy' );
    echo $objUserBuy->registerCancelBuy( $_POST );


} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'pointClubRegister' ) {
    unset( $_POST['flag'] );

    $PointClub = Load::controller( 'pointClub' );
    echo $PointClub->insertPointClub( $_POST );

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'updateMembersClub' ) {
    unset( $_POST['flag'] );

    $members = Load::controller( 'members' );
    echo $members->updateMembersClub();
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'fifteenFlight' ) {
    unset( $_POST['flag'] );
    $data = json_encode( $_POST );

    $url = $apiAddress . "/V-1/Flight/flightFifteenDay";

    $resultSendData = functions::curlExecution( $url, $data, 'yes' );

    if ( $resultSendData['result'] == 'true' && ! empty( $resultSendData['data'] ) ) {

        foreach ( $resultSendData['data'] as $key => $getPrice ) {
            if($getPrice['price_final'] != 0 )
                $price[] = $getPrice['price_final'];
        }

        $minPrice       = min( $price );
        $typePageSearch = $_POST['type'] != 'Local' ? 'searchFlight' : 'local';
        foreach ( $resultSendData['data'] as $key => $dataFlight ) {


            if ( SOFTWARE_LANG == 'fa' ) {
                $timeDate      = functions::ConvertToDateJalaliInt( $dataFlight['date_flight'] );
                $dateToday     = dateTimeSetting::jdate( "j F Y", $timeDate );
                $dateTodayLink = dateTimeSetting::jdate( "Y-m-d", $timeDate, '', '', 'en' );
                $nameToday     = dateTimeSetting::jdate( "l", $timeDate );
            } else {
                $dateToday     = date( 'Y F d', strtotime( $dataFlight['date_flight'] ) );
                $dateTodayLink = $dataFlight['date_flight'];
                $nameToday     = date( "l", $timeDate );
            }


            $flightType = ( $dataFlight['DisplayLable'] == 'سیستمی' ) ? 'system' : 'charter';
            $isPrivate  = ( functions::checkConfigPid( $dataFlight['IATA_code'], 'internal', $flightType,'8' ) == 'private' ) ? 'private' : 'public';
            ob_start();
            ?>
            <div class="col_t_price <?php echo ( $dataFlight['price_final'] == $minPrice ) ? 'active_col_today' : '' ?> <?php echo (($dataFlight['price_final'] == 0) ? 'complete-flight': '') ?>">
                <div>
                    <a href="<?php echo SERVER_HTTP . CLIENT_DOMAIN . DIRECTORY_SEPARATOR . 'gds' . DIRECTORY_SEPARATOR . SOFTWARE_LANG . DIRECTORY_SEPARATOR . $typePageSearch . DIRECTORY_SEPARATOR . '1' . DIRECTORY_SEPARATOR . $_POST['Origin'] . '-' . $_POST['Destination'] . DIRECTORY_SEPARATOR . $dateTodayLink . DIRECTORY_SEPARATOR . 'Y' . DIRECTORY_SEPARATOR . '1-0-0' ?>">
                        <div class="lowest-date">
                            <span class="ld-d"><?php echo $dateToday ?></span>
                            <span class="ld-dn"><?php echo $nameToday ?></span>
                        </div>
                        <span class="s_price"><?php
                            $fare              = ( $dataFlight['price_final'] - ( ( $dataFlight['price_final'] * 4573 ) / 100000 ) );
                            $priceCalculated   = functions::setPriceChanges( $dataFlight['IATA_code'], $flightType, $dataFlight['price_final'], $fare, 'Local', $isPrivate,'8' );
                            $priceCalculated   = explode( ':', $priceCalculated );
                            $PriceWithDiscount = functions::CurrencyCalculate( $priceCalculated[1] );
                            if ($dataFlight['price_final'] == 0) {
                                echo functions::Xmlinformation('FullCapacity');
                            } else {
                                echo number_format($PriceWithDiscount['AmountCurrency']) . ' ' . $PriceWithDiscount['TypeCurrency'] ;
                            }
                            ?>
                        </span>
                    </a>
                </div>
            </div>
            <?php
        }
        echo $PrintTicket = ob_get_clean();
    } else {

        return false;
    }

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'fifteenFlightModalView' ) {
    unset( $_POST['flag'] );
    $data = array( "Origin" => $_POST['Origin'], "Destination" => $_POST['Destination'] );
    $data = json_encode( $data );

    $url = $apiAddress . "/V-1/Flight/flightFifteenDay";

    $resultSendData = functions::curlExecution( $url, $data, 'yes' );

    ?>

    <div class="modal-header">
        <h5 class="_100 text-right modal-title" id="exampleModalScrollableTitle">
            <?php echo functions::StrReplaceInXml( [
                '@@origin@@'      => functions::NameCity( $_POST['Origin'] ),
                '@@destination@@' => functions::NameCity( $_POST['Destination'] )
            ], 'MessageLowestPrice' ); ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body flight-prices">
        <div id="loadbox"></div>
        <div class="row">

            <?php


            $i = 1;

            if ( ! empty( $resultSendData['data'] ) ) {
                foreach ( $resultSendData['data'] as $dataFlight ) {
                    if ($i  < 16) {


                        $convert_data = explode('-', $dataFlight['date_flight']);
                        //                    print_r($dataFlight['date_flight']);
//                if (empty($dataFlight['date_flight'])) {
//
//
//                    $text_price_field = '<span class="void-space flitght-price-price-info"></span>';
//                    $price_field = '<div class="flitght-price-date flitght-price-price-info">' . functions::Xmlinformation('CompletionCapacity') . '</div>';
//                } else {
//                    $text_price_field = '<span class=" flitght-price-price-info">' . functions::Xmlinformation('Startprice') . '</span>';
//                    $price_field = '<div class="flitght-price-date flitght-price-price-info">' . number_format($dataFlight['price_final']) . ' ' . functions::Xmlinformation('Rial') . '</div>';
//                }

                        echo '

                  <div class="flight-modal-items">
                    <a href="http://' . str_replace('www.', '', $_SERVER["HTTP_HOST"]) . '/gds/' . SOFTWARE_LANG . '/' . $_POST['searchType'] . '/1/' . $_POST['Origin'] . '-' . $_POST['Destination'] . '/' . functions::ConvertDateByLanguage(SOFTWARE_LANG, $dataFlight['date_flight'], '-', 'Miladi', true) . '/Y/1-0-0"
                    class="flight-price-item flight-price-item-tag-a">
                    
                      <div class="flitght-price-price">
                        <span class=" ">' . functions::ConvertDateByLanguage(SOFTWARE_LANG, $dataFlight['date_flight'], '-', 'Miladi', true) . '</span>
                        ' . $text_price_field . $price_field . '
                        
                      </div>
                    </a>
                  </div>
              ';

                        $i++;

                    }
                }
            } else {

                for ( $k = 0; $k < 15; $k ++ ) {
                    echo '
					<div class="flight-modal-items">
						<a href="javascript:;" class="flight-price-item flight-price-item-disable flight-price-item-tag-a">
							
							<div class="flitght-price-price">
								<span class="void-space"></span>
								<span class="void-space flitght-price-price-info"></span>
								<div class="flitght-price-date flitght-price-price-info">نامـوجود</div>
							</div>
						</a>
					</div>


        ';
                }

            }
            ?>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" aria-hidden="true" class="btn btn-primary" data-dismiss="modal" aria-label="Close">بستن
        </button>


    </div>
    <?php
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'flagGetBaseCompany' ) {

    $objController = load::controller( 'reservationPublicFunctions' );
    $result        = $objController->getBaseCompany( $_POST );

    echo $result;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'addMenuAdmin' ) {

    $objController = load::controller( 'admin' );
    $result        = $objController->addMenuAdmin( $_POST );

    echo $result;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'StatusMenuCounter' ) {

    $objController = load::controller( 'admin' );
    $result        = $objController->StatusMenuCounter( $_POST['idMenu'], $_POST['idMember'] );

    echo $result;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'setUserPermissions' ) {
    $objController = load::controller( 'userPermissions' );
    $result        = $objController->setUserPermissions($_POST['user_id'], $_POST['can_insert'],$_POST['can_update'],$_POST['can_delete'],$_POST['role']);

    echo $result;
}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'changePercentIndemnity' ) {

    $objController = load::controller( 'listCancel' );
    $result        = $objController->changePercentIndemnity( $_POST );

    echo $result;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'changeStatusPaymentManual' ) {

    $objController = load::controller( 'accountcharge' );
    $result        = $objController->changeStatusPaymentManual( $_POST );

    echo $result;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'configPidAirline' ) {
    unset( $_POST['flag'] );
    $objController = load::controller( 'airline' );
    $result        = $objController->configPidAirline( $_POST );

    echo $result;
}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'configPidAllAirlines' ) {
    unset( $_POST['flag'] );
    $objController = load::controller( 'airline' );
    $result        = $objController->configPidAllAirlines( $_POST );

    echo $result;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'selectServer' ) {
    unset( $_POST['flag'] );
    $objController = load::controller( 'airline' );
    $result        = $objController->selectServer( $_POST );

    echo $result;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'selectAllServers' ) {
    unset( $_POST['flag'] );
    $objController = load::controller( 'airline' );
    $result        = $objController->selectAllServers( $_POST );

    echo $result;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'checkExistSessionHistoryPassenger' ) {
    unset( $_POST['flag'] );
    Session::init();
    $passengerController = Load::controller( 'passengers' );
    $Passengers          = Session::getSessionHistoryPassenger();

    $timeSession  = Session::getTimePassengerHistory();
    $checkTimeOld = ( time() - $timeSession ) < 1800;
    if ( $_POST['checkExist'] == 'yes' ) {
        if ( ! empty( $Passengers ) && $checkTimeOld ) {
            echo true;
        } else {
            echo false;
        }

    } else {
        $passengerAll = array();
        foreach ( $Passengers as $key => $passenger ) {
            $passengerAll[ $key ] = $passengerController->get( $passenger );
        }
        echo json_encode( $passengerAll );

    }

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'sendDataToClub' ) {

    $user = Load::controller( 'members' );
    $user->sendDataToClub();
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'changeStatusMemberCredit' ) {
    unset( $_POST['flag'] );
    $user = Load::controller( 'user' );
    echo $user->changeStatusMemberCredit( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'increaseCreditAgency' ) {
    unset( $_POST['flag'] );
    $agencyController      = Load::controller( 'agency' );
    $agencyInfo            = $agencyController->AgencyInfoByIdMember( $_POST['idMemberLoginToAdmin'] );
    $transaction           = Load::controller( 'transaction' );
    $bank                  = Load::controller( 'bank' );
    $insertTransaction     = $transaction->addTransactionToClientANDAgency( $_POST );
    $_POST['factorNumber'] = $insertTransaction;

    if ( isset( $_POST['typeCredit'] ) && $_POST['typeCredit'] == 'fast' ) {
        functions::goToBankPasargadIranTech();
    } elseif ( isset( $_POST['typeCredit'] ) && $_POST['typeCredit'] == 'slow' ) {
        $bank->initBankParams( $_POST['bank'] );
        $bank->calculateAmount( 'increaseCreditAgency' );
        $bank->executeBank( 'go' );
        ?>
        <script language="javascript" type="text/javascript">
            function sendForm(link, inputs) {
                var form = document.createElement("form");
                form.setAttribute("method", "POST");
                form.setAttribute("action", link);

                var decodedInputs = $.parseJSON(inputs);
                $.each(decodedInputs, function (i, item) {
                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("name", i);
                    hiddenField.setAttribute("value", item);
                    form.appendChild(hiddenField);
                });

                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            }
        </script>

        <?php

    } else {
        echo 'error: لطفا نوع پرداخت رو انتخاب کنید';
    }

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'getRuleFlightForeign' ) {

    $user = Load::controller( 'members' );

    $url  = $apiAddress . '/V-1/Flight/getRuleFlightForeign/' . $_POST['requestNumber'];
    $data = array(
        "Rph"    => $_POST['flightId'],
        "Adult"  => $_POST['adult'],
        "Child"  => $_POST['child'],
        "Infant" => $_POST['infant']
    );

    $dataJson = json_encode( $data );

    $result = functions::curlExecution( $url, $dataJson, 'yes' );


    $resultConditions = $result['data']['fareRuleConditionses'];

    $arrayFinal = array();

    if ( ! empty( $resultConditions ) ) {

        $str = '';
        foreach ( $resultConditions[0]['conditionBlocks'] as $key => $condition ) {

            echo $str = '
            <div class="accordion-item ">
                <button id="accordion-button-1" aria-expanded="false">
                <span class="accordion-title-roul site-main-text-color">
                                    ' . $condition['title'] . '
                 </span><span class="icon" aria-hidden="true"></span></button>
                <div class="accordion-content">';


            if ( empty( $condition['conditions'] ) && $condition['isHtml'] ) {
                echo $condition['htmlFareRule'];
            } else {
                echo $str = '<p><ul>';
                foreach ( $condition['conditions'] as $jey => $rulse ) {

                    echo '<li>' . $rulse . '</li>';

                }
                echo $str = ' </ul></p>';
            }

            echo $str = '</div>
            </div>';

        }

    } else {
        echo $str = '
                <div class="accordion-item ">
                     <button id="accordion-button-1" aria-expanded="false">
                            <span class="accordion-title-roul site-main-text-color">
                               <p>متاسفانه برای این پرواز ،قوانین در دسترس نیستند،برای اطلاع از قوانین با پشتیبانی سایت تماس حاصل نمائید</p>
                            </span>
                     </button>
                </div>';
    }

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'checkCreditSeven' ) {

    $credit = functions::getChargeCharter724( 'irantechTest' );
    echo number_format(round( $credit['data']['child_charge'] ) ) . ' ' . 'ریال';
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'AddSpecialDiscountTrain' ) {

    $discountTrain = Load::controller( 'discount' );
    echo $discountTrain->discountSpecialTrain( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'searchSourceApi' ) {

//	$url  = "http://safar360.com/Core/Flight/findFile/" . $_POST['code'];
    $url  = "http://safar360.com/Core/Flight/findFile/" . $_POST['code'];
    $data = array();

    echo json_encode( functions::curlExecution( $url, $data, 'yes' ) );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'adminAddArticle' ) {
    //	echo Load::plog($_POST);die();
    /** @var articles $articles */
    $articles = Load::controller( 'articles' );
    echo $articles->InsertArticle( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'adminAddArticle' ) {
    //	echo Load::plog($_POST);die();
    /** @var lottery $lottery */
    $lottery = Load::controller( 'lottery' );
    echo $lottery->InsertLottery( $_POST );
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'adminEditArticle' ) {
    /** @var articles $articles */
    $articles = Load::controller( 'articles' );
    echo $articles->UpdateArticle( $_POST,$_POST['article_id']);
}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'adminEditArticle' ) {
    /** @var lottery $lottery */
    $lottery = Load::controller( 'lottery' );
    echo $lottery->UpdateLottery( $_POST,$_POST['lottery_id']);
}  elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'deleteArticle' ) {
    /** @var articles $articles */
    $articles = Load::controller( 'articles' );
    echo $articles->DeleteArticle( $_POST );
}  elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'deleteLottery' ) {
    /** @var lottery $lottereis */
    $lottereis = Load::controller( 'lottery' );
    echo $lottereis->DeleteLottery( $_POST );
}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'showOnResult' ) {
    /** @var articles $articles */
    $articles = Load::controller( 'articles' );
    echo $articles->ShowOnResult( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'articlesList' ) {
    /** @var articles $articles */
    $articles = Load::controller( 'articles' );
    echo $articles->GetListArticles( $_POST['service_group'], $_POST['position'] );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'new_master_rate' ) {
    unset( $_POST['flag'] );
    $newMasterRate = Load::controller( 'admin' );
    echo $newMasterRate->newMasterRate( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'get_master_rate' ) {
    unset( $_POST['flag'] );
    $newMasterRate = Load::controller( 'admin' );
    echo $newMasterRate->getMasterRate( $_POST );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'PreReservePackage' ) {

    $controller = Load::library( 'apiLocal' );
    $model      = Load::model( 'temporary_local' );

    $uniq_id       = functions::checkParamsInput( $_POST['uniq_id'] );
    $records       = $model->get( $uniq_id );
    $factor_number = $_POST['factorNumber'];
    foreach ( $records as $direction => $rec ) {

        $result[ $direction ] = $controller->PreReserveFlight( $rec['token_session'], $direction, $factor_number );

    }

    if ( isset( $result['TwoWay'] ) && $result['TwoWay']['result_status'] == 'PreReserve' ) {
        $result['total_status'] = 'success';
    }
    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'prereserveHotel' ) {

    $packageController = Load::controller( 'package' );

    echo $packageController->PerReserveHotel( $_POST['formData'] );


} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'bookHotel' ) {


    $packageController = Load::controller( 'detailHotel' );

    echo $packageController->HotelReserveNew( $_POST );


}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'check_credit_package' ) {
    unset( $_POST['flag'] );

    $apiLocal          = Load::library( 'apiLocal' );
    $bookLocal         = Load::model( 'book_local' );
    $objTransaction    = Load::controller( 'transaction' );
    $checkBankIranTech = functions::CheckGetWayIranTech( CLIENT_ID );

    $total_price_flight    = 0;
    $total_price_hotel     = 0;
    $TicketPriceFlightBank = 0;
    $TicketPriceHotelBank  = 0;
    $TotalPriceBank        = 0;
    $comment               = '';
    $factorNumber          = $_POST['factorNumberHotel'];
    $commentIranTechCharge = '';

    $reserveInfoFlight = $bookLocal->GetInfoBookLocal( $_POST['requestNumberFlight'] );;
    $pricesFlight       = $objTransaction->calculateTransactionPrice( $_POST['requestNumberFlight'] );
    $commentFlight      = "خرید" . " " . $reserveInfoFlight['count_id'] . " عدد بلیط دو طرفه هواپیما(پرواز + هتل) از" . " " . $reserveHotelInfo['origin_city'] . " به" . " " . $reserveInfo['desti_city'] . " " . "به شماره رزرو ";
    $total_price_flight += $pricesFlight['transactionPrice'];
    $commentFlight      .= ' ' . $_POST['requestNumberFlight'];


    //hotel
    $reserveHotelInfo  = functions::GetInfoHotel( $factorNumber );
    $commentHotel      = " رزرو " . " " . $reserveHotelInfo['room_count'] . " باب اتاق(پرواز+هتل) در شهر " . " " . $reserveHotelInfo['city_name'] . " در " . " " . $reserveInfo['hotel_name'] . " " . "به شماره رزرو " . " " . $reserveInfo['factor_number'];
    $total_price_hotel = $reserveHotelInfo['totalPriceTransaction'];

    if ( $reserveHotelInfo['typeApplication'] == 'api' ) {
        if ( isset( $reserveHotelInfo['irantech_commission'] ) && $reserveHotelInfo['irantech_commission'] > 0 ) {
            $total_price_hotel += $reserveHotelInfo['irantech_commission'] * $reserveHotelInfo['countPassengers'];
        }
    } elseif ( $reserveHotelInfo['typeApplication'] == 'externalApi' ) {
        if ( isset( $reserveHotelInfo['irantech_commission'] ) && $reserveHotelInfo['irantech_commission'] > 0 ) {
            $total_price_hotel += $reserveHotelInfo['irantech_commission'] * $reserveHotelInfo['countPassengers'];
        }
    }


    $priceFinal = $total_price_flight + $total_price_hotel;

    if ( $checkBankIranTech ) {
        $TicketPriceFlightBank += functions::CalculateDiscount( $_POST['requestNumberFlight'], 'yes' );
        $TotalPriceHotelBank   += $reserveHotelInfo['totalPriceTransaction'];

        $TotalPriceBank += intval( $TicketPriceFlightBank ) + intval( $TotalPriceHotelBank );

        $commentIranTechChargeFlight .= ' ' . $_POST['requestNumberFlight'];
        $commentIranTechChargeHotel  .= ' ' . $reserveHotelInfo['request_number'];
    }


    $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );


    if ( empty( $existTransaction ) ) {
        // Caution: اعتبارسنجی صاحب سیستم
        $check = $objTransaction->checkCredit( $priceFinal, 'online' );
        if ( $check['status'] == 'TRUE' ) {
            $reason = 'buy_package';
            if ( $checkBankIranTech ) {
                $commentIranTech = 'شارژ درگاه سفر360 برای خرید (پرواز+هتل) به شماره رزرو ' . $commentIranTechChargeFlight . '-' . $commentIranTechChargeHotel . 'از این درگاه ';
                functions::insertLog( 'in GetWayIranTech With factorNumber=>' . $factorNumber . ' has Amount Ticket=>' . $TotalPriceBank, 'iranTechGetWayBuy' );
                // در صورتی که از درگاه ایران تک استفاده میشد،یک رکورد بابت شارژ به اندازه هزینه بلیط زده میشه به صورت موقت و در برگشت از بانک در صورت موفقیت اوکی میشه
                $objTransaction->InsertChargeThrowIranTechGetWay( $TotalPriceBank, $factorNumber, $commentIranTech );


                sleep( 1 );
            }
            // Caution: کاهش اعتبار موقت صاحب سیستم
            $reduceTransactionFlight = $objTransaction->decreasePendingCredit( $total_price_flight, $factorNumber, $commentFlight, $reason );
            $reduceTransactionHotel  = $objTransaction->decreasePendingCredit( $total_price_hotel, $factorNumber, $commentHotel, $reason );

            if ( $reduceTransactionFlight && $reduceTransactionHotel ) {
                $output = 'TRUE';
            } else {
                $output = 'FALSE';
            }

        } else {
            $output = 'FALSE';
        }

    } else {
        $output = 'Empty Transaction FALSE';
    }
    echo $output;
}
elseif ( ( isset( $_POST['flag'] ) && $_POST['flag'] == 'buyByCreditPackage' ) ) {
    unset( $_POST['flag'] );

    $apiLocal              = Load::library( 'apiLocal' );
    $bookLocal             = Load::model( 'book_local' );
    $objTransaction        = Load::controller( 'transaction' );
    $checkBankIranTech     = functions::CheckGetWayIranTech( CLIENT_ID );
    $objMember             = Load::controller( 'members' );
    $total_price_flight    = 0;
    $total_price_hotel     = 0;
    $TicketPriceFlightBank = 0;
    $TicketPriceHotelBank  = 0;
    $TotalPriceBank        = 0;
    $comment               = '';
    $factorNumber          = $_POST['factorNumber'];
    $commentIranTechCharge = '';

    $reserveInfoFlight  = $bookLocal->GetInfoBookLocal( $_POST['requestNumberFlight'] );
    $pricesFlight       = $objTransaction->calculateTransactionPrice( $_POST['requestNumberFlight'] );
    $commentFlight      = "خرید" . " " . $reserveInfoFlight['count_id'] . " عدد بلیط دو طرفه هواپیما(پرواز + هتل) از" . " " . $reserveInfoFlight['origin_city'] . " به" . " " . $reserveInfoFlight['desti_city'] . " " . "به شماره رزرو ";
    $total_price_flight += $pricesFlight['transactionPrice'];
    $commentFlight      .= ' ' . $_POST['requestNumberFlight'];


    //hotel
    $reserveHotelInfo  = functions::GetInfoHotel( $factorNumber );
    $commentHotel      = " رزرو " . " " . $reserveHotelInfo['room_count'] . " باب اتاق(پرواز+هتل) در شهر " . " " . $reserveHotelInfo['city_name'] . " در " . " " . $reserveInfo['hotel_name'] . " " . "به شماره رزرو " . " " . $reserveInfo['factor_number'];
    $total_price_hotel = $reserveHotelInfo['totalPriceTransaction'];

    $priceFinal = $total_price_flight + $total_price_hotel;

    $TicketPriceFlightBank += functions::CalculateDiscount( $_POST['requestNumberFlight'], 'yes' );
    $TotalPriceHotelBank   += $reserveHotelInfo['totalPriceTransaction'];

    $counterCredit = $objMember->getCredit();

    $total_amount = $TicketPriceFlightBank + $TotalPriceHotelBank;
    // Caution: اعتبارسنجی اعتبار کانتر
    if ( $counterCredit > $total_amount ) {
        $reserveInfo = $bookLocal->GetInfoBookLocal( $_POST['requestNumberFlight'] );
        $comment     = "خرید" . " " . $reserveInfo[ $direction ]['count_id'] . " عدد بلیط دو طرفه هواپیما(پرواز + هتل) از" . " " . $reserveInfo['origin_city'] . " به" . " " . $reserveInfo['desti_city'] . " " . "به شماره رزرو ";

        $prices = $objTransaction->calculateTransactionPrice( $_POST['requestNumberFlight'] );

        $total_price += $prices['transactionPrice'];
        $comment     .= ' ' . $_POST['requestNumberFlight'];
        // Caution: کاهش اعتبار کانتر
        $objMember->decreaseCounterCredit( $TicketPriceFlightBank, $_POST['requestNumberFlight'], $reserveInfoFlight );
        $objMember->decreaseCounterCredit( $TotalPriceHotelBank, $factorNumber, $reserveHotelInfo );
        $existTransaction = $objTransaction->getTransactionByFactorNumber( $factorNumber );
        if ( empty( $existTransaction ) ) {

            // Caution: اعتبارسنجی صاحب سیستم;
            $check = $objTransaction->checkCredit( $priceFinal );
            if ( $check['status'] == 'TRUE' ) {

                //set buy status to credit
                $bookLocal->updateToCredit( $factorNumber );

                // Caution: کاهش اعتبار صاحب سیستم
                $reduceTransaction = $objTransaction->decreaseSuccessCredit( $total_price_flight, $factorNumber, $commentFlight, 'buy_package' );
                $reduceTransaction = $objTransaction->decreaseSuccessCredit( $total_price_hotel, $factorNumber, $commentHotel, 'buy_package' );

                if ( $reduceTransaction ) {
                    echo 'success:' . $priceFinal;
                } else {
                    echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCredit' );
                }

            } else {
                echo 'error:' . functions::Xmlinformation( 'ChargeRialSystem' );
            }

        } else {
            echo 'error:' . functions::Xmlinformation( 'ErrorDecreaseCreditByFactorNumber' );
        }
    } else {
        echo 'error: ' . functions::Xmlinformation( 'EndCreditAgency' );
    }
} elseif ( ( isset( $_POST['flag'] ) && $_POST['flag'] == 'checkDuplicate724' ) ) {

    unset($_POST['flag']);
    $apiLocal  = Load::library( 'apiLocal' );
    $books     = functions::info_flight_directions( $_POST['factorNumber'] );
    $duplicate = 'no';

    foreach ( $books as $book ) {
        if ( $book['api_id'] == '8' ) {
            $result = $apiLocal->checkDuplicate724( $book['request_number'] );
            if ( $result ) {
                $duplicate = 'yes';
            }
        }
    }

    echo $duplicate;

}elseif ( ( isset( $_POST['flag'] ) && $_POST['flag'] == 'cancelAltrabo' ) ) {

    $user       = Load::controller( 'user' );
    $infoFlight = functions::InfoFlight( $_POST['requestNumber'] );


    if ( $infoFlight['api_id'] == '10' ) {
        $infoCancelFlight = $user->InfoModalTicketCancel( $_POST['requestNumber'], $_POST['transportType'], $infoFlight['client_id'] );

        $apiFlight = Load::library( 'apiLocal' );
        $caseTitle = '';
        switch ( $infoCancelFlight[0]['ReasonMember'] ) {
            case 'CancelByAirline':
                $caseTitle = 1;
                break;
            case 'PersonalReason':
                $caseTitle = 2;
                break;
            case 'DelayTwoHours':
                $caseTitle = 3;
                break;
        }
        $dataCancel['Type']              = 1;
        $dataCancel['ReasonType']        = $caseTitle;
        $dataCancel['Reasondescription'] = 'لطفا پیگیری شود';
        foreach ( $infoCancelFlight as $passenger ) {
            $dataCancel['passportNumber'][] = $passenger['passportNumber'];
        }


        $viewCancel = $apiFlight->getRefuandAltrabo( $_POST['requestNumber'], $dataCancel );
    }

    $dataCancelView['responseSuccessfull'] = ( $viewCancel['response']['successful'] ) ? true : false;
    $dataCancelView['penaltyAmount']       = ( $viewCancel['data']['penaltyPassengers'][0]['crcnType'] == 'Value' ) ? $viewCancel['data']['totalPenaltyAmount'] . ' ' . 'ریال' : $viewCancel['data']['totalPenaltyAmount'] . ' ' . 'درصد';
    $dataCancelView['totalPayAmount']      = $viewCancel['data']['totalPayAmount'];
    $dataCancelView['totalAmount']         = $viewCancel['data']['totalAmount'];

    $dataMessage            = array();
    $dataMessage['status']  = false;
    $dataMessage['message'] = '';
    if ( $dataCancelView['responseSuccessfull'] ) {
        $dataMessage['status']  = true;
        $dataMessage['message'] = 'درخواست کنسلی با موفقیت ارسال شد،برای پیگیری به پنل پروایدر مراجعه کنید';
    }
    echo json_encode( $dataMessage );
    exit();

}elseif ( ( isset( $_POST['flag'] ) && $_POST['flag'] == 'changeConfigurationStatus' ) ) {
    $result = array( 'status' => 'error', 'Message' => '' );
    /** @var configurations $configurations */
    $configurations = Load::controller( 'configurations' );
    $action         = $configurations->changeConfigurationStatus( $_POST['configuration_id'] );
    if ( $action ) {
        $result['status']  = 'success';
        $result['Message'] = 'تغییر وضعیت با موفقیت انجام شد.';
    }
    echo json_encode( $result );
    exit();
} elseif ( ( isset( $_POST['flag'] ) && $_POST['flag'] == 'changeConfigurationEdit' ) ) {
    $result = array( 'status' => 'error', 'Message' => '' );
    /** @var configurations $configurations */
    $configurations = Load::controller( 'configurations' );
    $action         = $configurations->changeConfigurationEdit( $_POST['configuration_id'] );
    if ( $action ) {
        $result['status']  = 'success';
        $result['Message'] = 'تغییر وضعیت با موفقیت انجام شد.';
    }
    echo json_encode( $result );
    exit();
} elseif ( ( isset( $_POST['flag'] ) && $_POST['flag'] == 'setClientConfigStatus' ) ) {
    unset( $_POST['flag'] );
    $result = array( 'status' => 'error', 'Message' => '' );
    /** @var configurations $configurations */
    $configurations = Load::controller( 'configurations' );
    $action         = $configurations->setClientConfigStatus( $_POST['configuration_id'], $_POST['client_id'], $_POST['action'] );
    if ( $action ) {
        $result['status']  = 'success';
        $result['Message'] = 'تغییر وضعیت با موفقیت انجام شد.';
    }
    echo json_encode( $result );
    exit();

} elseif ( ( isset( $_POST['flag'] ) && $_POST['flag'] == 'addNewConfiguration' ) ) {
    unset( $_POST['flag'] );
    $result = array( 'status' => 'error', 'Message' => '' );
    /** @var configurations $configurations */
    $configurations = Load::controller( 'configurations' );
    $action         = $configurations->addNewConfiguration( $_POST );
    if ( $action ) {
        $result['status']  = 'success';
        $result['Message'] = 'کانفیگ جدید با موفقیت اضافه شد';
    }
    echo json_encode( $result );
    exit();
} elseif ( ( isset( $_POST['flag'] ) && $_POST['flag'] == 'editConfiguration' ) ) {
    unset( $_POST['flag'] );
    $result = array( 'status' => 'error', 'Message' => '' );
    /** @var configurations $configurations */
    $configurations = Load::controller( 'configurations' );
    $action         = $configurations->editConfiguration( $_POST );
    if ( $action ) {
        $result['status']  = 'success';
        $result['Message'] = 'کانفیگ جدید با موفقیت اضافه شد';
    }
    echo json_encode( $result );
    exit();
} elseif ( ( isset( $_POST['flag'] ) && $_POST['flag'] == 'addNewClientContent' ) ) {
    unset( $_POST['flag'] );
    $result = array( 'status' => 'error', 'Message' => '' );
    /** @var configurations $configurations */
    $configurations = Load::controller( 'configurations' );
    $dataInsert     = array(
        'configuration_id' => $_POST['configuration_id'],
        'title'            => $_POST['title'],
        'content_type'     => $_POST['content_type'],
        'content'          => $_POST['content'],
        'is_active'        => isset( $_POST['is_active'] ) ? $_POST['is_active'] : 1,
    );
    $action         = $configurations->addNewClientContent( $dataInsert );
    if ( $action ) {
        $result['status']  = 'success';
        $result['Message'] = 'محتوای جدید با موفقیت اضافه شد';
    }
    echo json_encode( $result );
    exit();
} elseif ( ( isset( $_POST['flag'] ) && $_POST['flag'] == 'editClientContent' ) ) {
    unset( $_POST['flag'] );
    $result = array( 'status' => 'error', 'Message' => '' );
    /** @var configurations $configurations */
    $configurations = Load::controller( 'configurations' );
    $dataInsert     = array(
        'configuration_id' => $_POST['configuration_id'],
        'title'            => $_POST['title'],
        'content_type'     => $_POST['content_type'],
        'content'          => $_POST['content'],
        'is_active'        => isset( $_POST['is_active'] ) ? $_POST['is_active'] : 1,
    );
    $action         = $configurations->editClientContent($_POST['id'], $dataInsert );
    if ( $action ) {
        $result['status']  = 'success';
        $result['Message'] = 'محتوای تبلیغات با موفقیت ویرایش شد';
    }
    echo json_encode( $result );
    exit();
} elseif ( ( isset( $_POST['flag'] ) && $_POST['flag'] == 'deleteClientContent' ) ) {
    unset( $_POST['flag'] );
    $result = array( 'status' => 'error', 'Message' => '' );
    /** @var configurations $configurations */
    $configurations = Load::controller( 'configurations' );
    $action         = $configurations->deleteClientContent($_POST['id'] );
    if ( $action ) {
        $result['status']  = 'success';
        $result['Message'] = 'محتوای تبلیغات با موفقیت حذف شد';
    }
    echo json_encode( $result );
    exit();
}elseif ( ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insertAdvertiseAccess' ) ) {
    unset( $_POST['flag'] );
    $result = array( 'status' => 'error', 'Message' => '' );
    /** @var configurations $configurations */
    $configurations = Load::controller( 'configurations' );
    $action         = $configurations->insertAdvertiseAccess($_POST['id'] );
    if ( $action ) {
        $result['status']  = 'success';
        $result['Message'] = 'محتوای تبلیغات با موفقیت حذف شد';
    }
    echo json_encode( $result );
    exit();
}elseif((isset($_POST['flag']) && $_POST['flag'] == 'changeStatusAgency')){
    unset( $_POST['flag'] );
    $agencyController = Load::controller('agency');

    echo $agencyController->changeStatusAgency($_POST['id']);
}elseif((isset($_POST['flag']) && $_POST['flag'] == 'changeStatusServiceAgency')){
    unset( $_POST['flag'] );
    $agencyController = Load::controller('agency');

    echo $agencyController->changeStatusServiceAgency($_POST);
}elseif((isset($_POST['flag']) && $_POST['flag'] == 'acceptSubAgencyWhiteLabel')){
    unset( $_POST['flag'] );
    $agencyController = Load::controller('agency');

    echo $agencyController->acceptSubAgencyWhiteLabel($_POST);
}
elseif((isset($_POST['flag']) && $_POST['flag'] == 'loginAgency')){
    unset( $_POST['flag'] );
    $controller = Load::controller('agency');
//	$email = functions::checkParamsInput(functions::sanitizeString(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)));
    $email = functions::checkParamsInput(functions::sanitizeString($_POST['email']));
    $password = functions::checkParamsInput(functions::sanitizeString(filter_var($_POST['password'], FILTER_SANITIZE_STRING)));

    if ($email != '' && $password != '') {
        $isEnableClub = IS_ENABLE_CLUB ;
        $result = $controller->login($email, $password, $remember);
        if (!empty($result)) {
            echo 'success';
        } else {
            echo 'error in login process';
        }
    } else {
        echo $email;
    }
}elseif((isset($_POST['flag']) && $_POST['flag'] == 'agencyReport')){
    unset( $_POST['flag'] );
    $controllerClass = Load::controller('bookshow');

    echo $controllerClass->reportHistoryBuyAgency($_POST['typeService']);
}elseif((isset($_POST['flag']) && $_POST['flag'] == 'membersAgency')){

    unset( $_POST['flag'] );
    /** @var members $controllerClass */
    $controllerClass = Load::controller('members');

    $agencyId = SUB_AGENCY_ID > 0 ? SUB_AGENCY_ID : Session::getAgencyId();

    echo $controllerClass->listMembersAgency($agencyId);
}elseif((isset($_POST['flag']) && $_POST['flag'] == 'cancelAgency')){
    unset( $_POST['flag'] );
    /** @var listCancelUser $controllerClass */
    $controllerClass = Load::controller('listCancelUser');

    $agencyId = SUB_AGENCY_ID > 0 ? SUB_AGENCY_ID : Session::getAgencyId();

    echo $controllerClass->getReportCancelAgency($agencyId);
}elseif((isset($_POST['flag']) && $_POST['flag'] == 'agencyCreditReport')){
    unset( $_POST['flag'] );
    /** @var agency $controllerClass */
    $controllerClass = Load::controller('agency');
    echo $controllerClass->getReportCreditAgency();
}elseif((isset($_POST['flag']) && $_POST['flag'] == 'contactUs')){
    unset( $_POST['flag'] );
    /** @var contactUs $controllerClass */
    $controllerClass = Load::controller('contactUs');
    echo $controllerClass->insertContactInfo($_POST);
}elseif((isset($_POST['flag']) && $_POST['flag'] == 'contactDetailData')){

    /** @var contactUs $controllerClass */
    $controllerClass = Load::controller('contactUs');
    echo $controllerClass->GetContact($_POST['id'] , true);
}elseif((isset($_POST['flag']) && $_POST['flag'] == 'newRulesCategory')){
    unset( $_POST['flag'] );
    /** @var rulesCategory $controller */
    $controller = Load::controller('rulesCategory');
    echo $controller->addCategory($_POST);

}elseif(isset($_POST['flag']) && $_POST['flag'] == 'addRule'){
    unset( $_POST['flag'] );
    /** @var rules $controller */
    $controller = Load::controller('rules');
    echo $controller->addRule($_POST);

}elseif(isset($_POST['flag']) && $_POST['flag'] == 'editRule'){
    unset( $_POST['flag'] );
    /** @var rules $controller */
    $controller = Load::controller('rules');
    echo $controller->editRule($_POST);

}elseif(isset($_POST['flag']) && $_POST['flag'] == 'editRuleCategory'){
    unset( $_POST['flag'] );
    /** @var rules $controller */
    $controller = Load::controller('rules');
    echo $controller->editRuleCategory($_POST);

}elseif (isset($_POST['flag']) && $_POST['flag'] == 'sendToBookTicketFlight'){
    unset($_POST['flag']);
    $data = $_POST['data'] ;
    /** @var bookTicketFlight $controllerBookTicket */
    $controllerBookTicket = Load::controller('bookTicketFlight');
    echo $controllerBookTicket->bookFlight($data);

}elseif(isset($_POST['flag']) && $_POST['flag'] == 'resultTourLocalList'){
    unset($_POST['flag']);
    /** @var resultTourLocal $resultTourLocal */
    $resultTourLocal = Load::controller('resultTourLocal');
    echo $resultTourLocal->showListTour();
    exit();

}elseif(isset($_POST['flag']) && $_POST['flag'] == 'agencyUploadAttachments'){
    unset($_POST['flag']);
    /** @var agency $agency */
    $agency = Load::controller('agency');
    $agency_id = Session::getAgencyId();
    $profile = $agency->getAgency(Session::getAgencyId());
    if ($profile['hasSite'] == '1'){
        $agency_id = SUB_AGENCY_ID;
    }
    $_POST['agency_id'] = $agency_id;
    echo $agency->agencyUploadAttachments($_POST);
    exit();
}elseif(isset($_POST['flag']) && $_POST['flag'] == 'agencyRemoveAttachments'){
    unset($_POST['flag']);
    /** @var agency $agency */
    $agency = Load::controller('agency');
    echo $agency->agencyRemoveAttachments($_POST);
    exit();
}elseif(isset($_POST['flag']) && $_POST['flag'] == 'adminGetMainUser'){

    unset($_POST['flag']);
    /** @var members $members */
    $members = Load::controller('members');
    echo $members->getUsersListJson($_POST);
    exit();
}elseif (isset($_POST['flag']) && $_POST['flag'] == 'TicketReserve') {

    $obj_reservation_flight = Load::controller('resultReservationTicket');
    unset($_POST['flag']);
    echo $obj_reservation_flight->ticketReserve($_POST);
}elseif (isset($_POST['flag']) && $_POST['flag'] == 'add_slider') {

    /** @var sliders $sliders_controller */
    $sliders_controller = Load::controller('sliders');
    unset($_POST['flag']);
    echo $sliders_controller->addSlider($_POST);
}elseif((isset($_POST['flag']) && $_POST['flag'] == 'appointment')){
    unset( $_POST['flag'] );
    /** @var contactUs $controllerClass */
    $controllerClass = Load::controller('appointments');
    echo $controllerClass->insertAppointment($_POST);
}elseif((isset($_POST['flag']) && $_POST['flag'] == 'employment')){
    unset( $_POST['flag'] );
    /** @var contactUs $controllerClass */
    $controllerClass = Load::controller('employment');
    echo $controllerClass->insertEmployment($_POST);

}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'convertDateJalali' ) {
    unset( $_POST['flag'] );
    $result   = functions::ConvertToMiladi( $_POST['date_jalali']);
    echo $result;
}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'convertDateMiladi' ) {
    unset( $_POST['flag'] );
    $result   = functions::ConvertToJalali( $_POST['date_miladi']);
    echo $result;
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'trackingRequestInfo' ) {

    unset( $_POST['flag'] );
    switch ( $_POST['typeSearchRequest'] ) {
        case 'employment':
            /** @var \employment $employment */
            $employment = Load::controller( 'employment' );
            $result   = $employment->infoEmployment( $_POST['request_service_number'] );
            break;
        case 'contactUs':
            /** @var \contactUs $contactUs */
            $contactUs = Load::controller( 'contactUs' );
            $result   = $contactUs->infoContactUs( $_POST );
            break;
        case 'feedback':
            /** @var \contactUs $contactUs */
            $contactUs = Load::controller( 'contactUs' );
            $_POST['type'] = 'feedback';
            $result   = $contactUs->infoContactUs( $_POST );
            break;
        case 'lastMinute':
            /** @var \contactUs $contactUs */
            $contactUs = Load::controller( 'contactUs' );
            $_POST['type'] = 'lastMinute';
            $result   = $contactUs->infoContactUs( $_POST );
            break;
        case 'orderServices':
            /** @var \orderServices $orderServices */
            $orderServices = Load::controller( 'orderServices' );
            $result   = $orderServices->infoOrderServicesTracking( $_POST['request_service_number'] );
            break;
        case 'orderIranVisa':
            /** @var \iranVisa $iranVisa */
            $orderIranVisa = Load::controller( 'iranVisa' );
            $result   = $orderIranVisa->infoIranVisaTracking( $_POST['request_service_number'] );
            break;
        case 'representatives':
            /** @var \representatives $representatives */
            $orderIranVisa = Load::controller( 'representatives' );
            $result   = $orderIranVisa->infoRepresentatives( $_POST['request_service_number'] );
            break;
        case 'sendDocuments':
            /** @var \sendDocuments $sendDocuments */
            $orderSendDocuments = Load::controller( 'sendDocuments' );
            $result   = $orderSendDocuments->infoSendDocumentsTracking( $_POST['request_service_number'] );
            break;
        case 'appointment':
            /** @var \appointment $appointment */
            $orderAppointment = Load::controller( 'appointments' );
            $result   = $orderAppointment->infoAppointmentTracking( $_POST['request_service_number'] );
            break;
        default:
            $result = '';
            break;
    }
    echo $result;
}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'trackingRequestAllInfo' ) {
    unset( $_POST['flag'] );
    /** @var \employment $employment */
    $employment = Load::controller( 'employment' );
    $result   = $employment->infoEmploymentAll( $_POST['request_service_number'] );
    echo $result;
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'orderServicesAdd' ) {
    unset($_POST['flag']);
    unset($_POST['fileText']);
    $orderServicesData = $_POST;
    $orderServicesData['language'] = 'fa';
    $orderServices = Load::controller( 'orderServices' );
    $result   = $orderServices->insertOrderServicesArray( $orderServicesData);
    echo $result;

}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'insert_jacket_customer' ) {
    $customer = Load::controller( 'jacketCustomer' );
    unset( $_POST['flag'] );
    echo $customer->insertCustomer( $_POST );

}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'checkGRSCredit' ) {

    $credit = functions::getGrsCharge('irantechTest');
    echo number_format(round( $credit['total'] ) ) . ' ' . 'ریال';

} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'answerVoteUser' ) {

    unset($_POST['flag']);
    $voteData = $_POST;
    $voteData['language'] = 'fa';
    $vote = Load::controller( 'vote' );
    $result   = $vote->answerVoteUser( $voteData);
    echo $result;
}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'UpdateUserProfile' ) {
    unset( $_POST['flag'] );
    $UserController = Load::controller( 'user' );
    $result         = $UserController->UpdateUserProfile( $_POST );
    echo json_encode( $result );
}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'PassengersUpdateModalData' ) {
    unset( $_POST['flag'] );
    $passengerController = Load::controller( 'passengers' );
    $result              = $passengerController->clientUpdateData( $_POST ['data'] );
    echo json_encode( $result );
}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'PassengersAddModalData' ) {
    unset( $_POST['flag'] );
    $passengerController = Load::controller( 'passengers' );
    $result              = $passengerController->clientAddData( $_POST ['data'] );
    echo json_encode( $result );
}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'PassengersDeleteModal' ) {
    unset( $_POST['flag'] );
    $passengerController = Load::controller( 'passengers' );
    $result              = $passengerController->clientDeletePassenger( $_POST ['data'] );
    echo json_encode( $result );
}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'uploadImageProfileUserProfile' ) {
    unset( $_POST['flag'] );
    $memberController = Load::controller( 'members' );
    $result              = $memberController->uploadImageProfile( $_POST ['data'] );
    echo json_encode( $result );
} elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'onlinePaymentAdd' ) {
    unset($_POST['flag']);
    $onlinePaymentData = $_POST;

    $onlinePaymentData['language'] = 'fa';
    $onlinePayment = Load::controller( 'onlinePayment' );
    $result   = $onlinePayment->insertOnlinePaymentArray( $onlinePaymentData);
    echo json_encode( $result );

}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'check_credit_online_pay' ) {

    $factorNumber = filter_var( $_POST['requestNumber'], FILTER_SANITIZE_NUMBER_INT );

    if ( $factorNumber != '' ) {

        $objPay = Load::controller( 'onlinePayment' );
        echo 'TRUE';
        $payInfo = $objPay->findOnlinePaymentByCode($factorNumber);

        $checkBankIranTech = functions::CheckGetWayIranTech( CLIENT_ID );
        $prices            = $payInfo['amount'];
        $total_price       = $payInfo['amount'];
        if ( $checkBankIranTech ) {
            $commentIranTech = 'شارژ درگاه سفر360 برای خرید بیمه به شماره فاکتور ' . $factorNumber . 'از این درگاه ';
            functions::insertLog( 'in GetWayIranTech Toure With factorNumber=>' . $factorNumber . ' has Amount Ticket=>' . $prices['totalPrice'], 'iranTechGetWayBuy' );
            // در صورتی که از درگاه ایران تک استفاده میشد،یک رکورد بابت شارژ به اندازه هزینه بلیط زده میشه به صورت موقت و در برگشت از بانک در صورت موفقیت اوکی میشه

        }
    } else {
        echo 'FALSE';
    }

}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'deleteRequestOffline' ) {
    /** @var articles $articles */
    $articles = Load::controller( 'requestOffline' );
    echo $articles->DeleteRequestOffline( $_POST );

}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'UserCreditWithdrawal' ) {

    unset( $_POST['flag'] );
    $controller = Load::controller( 'memberCredit' );
    echo $controller->DecreaseMoneyMember( $_POST );
}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'ConfirmRequestedMemberByAdmin' ) {
    $member_credit= Load::controller( 'memberCredit' );
    unset( $_POST['flag'] );
    echo $member_credit->confirmRequested( $_POST );
}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'RejectRequestedMemberByAdmin' ) {
    $member_credit= Load::controller( 'memberCredit' );
    unset( $_POST['flag'] );
    echo $member_credit->RejectRequested( $_POST );
}
//elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'ConfirmRequestedReturnToWallet' ) {
//    $member_credit= Load::controller( 'memberCredit' );
//    unset( $_POST['flag'] );
//    echo $member_credit->ReturnAdminToWalletUser(  $_POST['RequestId'] ,  $_POST['ItemId'],  $_POST['Price'] ,  $_POST['MemberId']);
//}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'BackWallet' ) {
    unset( $_POST['flag'] );

    $data = Array(
        "ClientID"      => filter_var( $_POST['ClientID'], FILTER_SANITIZE_STRING ),
        "RequestNumber" => filter_var( $_POST['RequestNumber'], FILTER_SANITIZE_STRING ),
        "ParamId"       => filter_var( $_POST['ParamId'], FILTER_SANITIZE_STRING ),
        "priceBack"     => filter_var( $_POST['priceBack'], FILTER_SANITIZE_STRING )
    );

    /** @var memberCredit $memberCredit */
    $memberCredit  = Load::controller( 'memberCredit' );
    $InsertPrice = $memberCredit->ReturnAdminToWalletUser( $data );
    echo $InsertPrice;
}

elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'ConfirmReturnBankUser' ) {
    unset( $_POST['flag'] );

    $data = Array(
        "ClientID"      => filter_var( $_POST['memberId'], FILTER_SANITIZE_STRING ),
        "RequestNumber" => filter_var( $_POST['RequestNumber'], FILTER_SANITIZE_STRING ),
        "ParamId"       => filter_var( $_POST['ParamId'], FILTER_SANITIZE_STRING ),
        "TypeCancel"       => filter_var( $_POST['TypeCancel'], FILTER_SANITIZE_STRING )
    );
    /** @var memberCredit $memberCredit */
    $memberCredit  = Load::controller( 'memberCredit' );
    $sendParameters = $memberCredit->ConfirmReturnBankUser( $data );
    echo $sendParameters;
}
elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'GuestUpdateUsers' ) {
    /** @var members $controller */
    $controller = Load::controller( 'members' );
    if(functions::validateMobileOrEmail($_POST['entry'])){

        $data['entry']=functions::checkParamsInput( $_POST['entry']);
    }

    $data = Array(
        "name"        => functions::sanitizeString( trim( filter_var( $_POST['name'], FILTER_SANITIZE_STRING ) ) ),
        "family"      => functions::sanitizeString( trim( filter_var( $_POST['family'], FILTER_SANITIZE_STRING ) ) ),
        "mobile"      => functions::sanitizeString( trim( trim( filter_var( $_POST['mobile'], FILTER_SANITIZE_NUMBER_INT ), '‌' ) ) ),
        "email"       => functions::sanitizeString( trim( trim( filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ), '‌' ) ) ),
        "is_member"   => 1,
        "TypeOs"      => functions::getOsUser()
    );

    /** @var members $controller */
    $controller  = Load::controller( 'members' );
    $sendParameters = $controller->UpdateGuestUsers( $data );
    echo $sendParameters;
}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'processExcelRaja') {
    unset($_POST['flag']);

    $objController = Load::controller('rajaTransactions');
    $result = $objController->processExcel($_POST['trackingCode']);

    echo $result;

}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'deleteExcelRaja') {
    unset($_POST['flag']);
    $objController = Load::controller('rajaTransactions');
    $result = $objController->deleteExcel($_POST['trackingCode']);
    echo $result;

}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'DirectCancellationFlightAdmin') {
    unset($_POST['flag']);
    $objController = Load::controller('listCancelUser');
    $result = $objController->DirectCancellationFlightAdmin($_POST);
    echo $result;

}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'DirectCancellationHotelAdmin') {
    unset($_POST['flag']);

    $objController = Load::controller('listCancelUser');
    $result = $objController->DirectCancellationHotelAdmin($_POST);

    echo $result;

}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'airlineCloseTime') {
    unset($_POST['flag']);

    $objController = Load::controller('airlineCloseTime');
    $result = $objController->insertTime($_POST);

    echo $result;

}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'deleteCloseTime') {
    unset($_POST['flag']);

    $airlineId = $_POST['airlineId'];

    $objController = Load::controller('airlineCloseTime');
    $result = $objController->deleteCloseTime($airlineId);

    echo $result;

}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'saveAgencyCloseTime') {
    unset($_POST['flag']);

    $objController = Load::controller('manifestController');
    $result = $objController->saveAgencyCloseTime($_POST);

    echo json_encode($result);

}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'deleteAgencyCloseTime') {
    unset($_POST['flag']);

    $objController = Load::controller('manifestController');
    $result = $objController->deleteAgencyCloseTime($_POST);

    echo json_encode($result);

}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'getAgencyCloseTimeData') {
    unset($_POST['flag']);

    $objController = Load::controller('manifestController');
    $result = $objController->getAgencyCloseTimeData($_POST);

    echo json_encode($result);

}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'generateTxtContent') {
    unset($_POST['flag']);

    $type = $_POST['type'];
    $id = $_POST['id'];
    $method = $_POST['method'];
    $type_search = $_POST['type_search'];

    $filename = "{$type_search}-{$type}-{$method}-{$id}.txt";
    $content = $_POST['content'];
    if (is_array($content)) {
        $content = json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    } else {
        $content = html_entity_decode($content);
    }

    echo json_encode([
        'filename' => $filename,
        'content' => $content
    ]);
    exit;
}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'UpdateCommissionAirline') {
    unset($_POST['flag']);

    $objController = Load::controller('airline');
    $result = $objController->UpdateCommissionAirline($_POST);

    echo $result;

}elseif (isset($_POST['flag']) && $_POST['flag'] == 'UpdateTerminalAirline') {
    unset($_POST['flag']);

    $objController = Load::controller('airline');
    $result = $objController->UpdateTerminalAirline($_POST);

    echo $result;

}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'UpdatecommissionSources') {
    unset($_POST['flag']);

    $objController = Load::controller('commissionSources');
    $result = $objController->updateCom($_POST);

    echo $result;

}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'UpdateFareStatusSources') {
    unset($_POST['flag']);

    $objController = Load::controller('commissionSources');
    $result = $objController->updateFareStatus($_POST);

    echo $result;

}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'UpdateAmadeusStatusAirline') {
    unset($_POST['flag']);

    $objController = Load::controller('airline');
    $result = $objController->UpdateAmadeusStatusAirline($_POST);

    echo $result;

}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'isSafar360') {
    unset($_POST['flag']);

    return functions::isSafar360();

}elseif(isset($_POST['flag']) && $_POST['flag'] == 'userBookmarks'){
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    $obj = Load::controller('userBookmarks');

    switch ($action) {
        case 'add':
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $url = isset($_POST['url']) ? $_POST['url'] : '';
            $result = $obj->addBookmark($title, $url);
            echo json_encode($result);
            break;

        case 'delete':
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            $result = $obj->deleteBookmark($id);
            echo json_encode($result);
            break;

        default:
            echo json_encode(array('success' => false, 'message' => 'عملیات نامعتبر'));
    }
}elseif(isset($_POST['flag']) && $_POST['flag'] == 'insert_flight_limitation'){
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $obj = Load::controller('reportAgenciesSearch');
    $params = [];
    $params ['client_id'] = $_POST['client_id'];
    $params ['internal_search_limit'] = isset($_POST['internal_search_limit']) ? $_POST['internal_search_limit'] : '';
    $params ['international_search_limit'] = isset($_POST['international_search_limit']) ? $_POST['international_search_limit'] : '';
    $result = $obj->addFlightLimitation($params);
    echo json_encode($result);
}elseif(isset($_POST['flag']) && $_POST['flag'] == 'remove_agency_search_limit'){
    $obj = Load::controller('reportAgenciesSearch');
    $params = [];
    if(!$_POST['agency_id']){
        return false;
    }
    $params['agency_id'] = $_POST['agency_id'];
    $result = $obj->removeFlightLimitation($params);
    echo json_encode($result);
}
elseif(isset($_POST['flag']) && $_POST['flag'] == 'add_airlineIata'){
    $obj = Load::controller('airline');
    $params = [];
    if(!($_POST['airline_iata'] &&  $_POST['airline_name'])){
        return false;
    }
    unset($_POST['flag']);

    $result = $obj->add_airlineIata($_POST);
    echo json_encode($result);
}
elseif(isset($_POST['flag']) && $_POST['flag'] == 'remove_airlineIata'){

    $obj = Load::controller('airline');
    if(!($_POST['id'])){
        return false;
    }
    unset($_POST['flag']);

    $result = $obj->remove_airlineIata($_POST);
    echo json_encode($result);
}
elseif(isset($_POST['flag']) && $_POST['flag'] == 'UpdateAirlineiata'){

    $obj = Load::controller('airline');
    if(!($_POST['iata_id'] && $_POST['airline_id'])){
        return false;
    }
    unset($_POST['flag']);

    $result = $obj->update_airlineIata($_POST);
    echo json_encode($result);
}
elseif(isset($_POST['flag']) && $_POST['flag'] == 'add_airlineFareClass'){

    $obj = Load::controller('airline');
    if(!($_POST['class_name'])){
        return false;
    }
    unset($_POST['flag']);

    $result = $obj->add_airlineFareClass($_POST);
    echo json_encode($result);
}
elseif(isset($_POST['flag']) && $_POST['flag'] == 'remove_airlineFareClass'){
    $obj = Load::controller('airline');
    if(!($_POST['id'])){
        return false;
    }
    unset($_POST['flag']);
    $result = $obj->remove_airlineFareClass($_POST);
    echo json_encode($result);
}
elseif(isset($_POST['flag']) && $_POST['flag'] == 'fineAdd'){
    $obj = Load::controller('airLineFineController');
    unset($_POST['flag']);
    $result = $obj->add_airlineFine($_POST);
    echo $result;
}
elseif(isset($_POST['flag']) && $_POST['flag'] == 'fineEdit'){
    $obj = Load::controller('airLineFineController');
    unset($_POST['flag']);
    if(!$_POST['package_id']){
        return false;
    }
    $result = $obj->edit_airlineFine($_POST);
    echo $result;
}
elseif(isset($_POST['flag']) && $_POST['flag'] == 'remove_airlineFine'){
    $obj = Load::controller('airLineFineController');
    unset($_POST['flag']);
    if(!$_POST['id']){
        return false;
    }
    $result = $obj->remove_airlineFine($_POST);
    echo $result;
}

