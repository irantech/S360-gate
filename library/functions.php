<?php

class functions {


    #region url source
    /*
     *
     *
     *
    لطفا توجه شود ، به هیچ عنوان این فانکش تغییر داده نشود و موقع آپلود کاملا دقت شود
     * در محیط تست s360_test حتما چک شود که این فانکشن روی ادرس تست باشد
     *
     *
     *
     */
    public static function UrlSource() {

        $apiAddress = '';
        $isTest     = self::isTestServer();
        $apiAddress = 'http://safar360.com/Core/V-1/';
        if ( $isTest ) {//local

//            $apiAddress = 'http://safar360.com/CoreTestDeveloper/V-1/';
            $apiAddress = 'http://192.168.1.100/CoreTestDeveloper/V-1/';
        }
        return $apiAddress;
    }
    #endregion
    #region curlExecution
    public static function sanitizeString( $var ) {
        $var = strip_tags( $var );
        $var = htmlentities( $var, ENT_COMPAT, 'UTF-8' );
        $var = stripslashes( $var );
        $var = str_replace( '&zwnj;', '', $var );

        return $var;
    }

    #endregion

    #region stringStartsWith
    /**
     * this function is checking if a string starts with $needle string or not
     *
     * @param string $string
     * @param string $needle
     * @param bool   $case_senitive
     *
     * @return bool
     */
    public static function stringStartsWith( $string = '', $needle = '', $case_senitive = false ) {
        if ( $case_senitive ) {
            return strpos( $string, $needle, 0 ) === 0;
        }

        return stripos( $string, $needle, 0 ) === 0;
    }
    #endregion

    #region stringEndsWith
    /**
     * this function is checking if a string ends with $needle string or not
     *
     * @param string $string
     * @param string $needle
     * @param bool   $case_senitive
     *
     * @return bool
     */
    public static function stringEndsWith( $string = '', $needle = '', $case_senitive = false ) {
        //	    if(is_array($needle)){
        //		    foreach ( $needle as $item ) {
        //                return self::stringEndsWith($string,$item,$case_senitive);
        //	        }
        //        }
        $expectedPosition = strlen( $string ) - strlen( $needle );
        if ( $case_senitive ) {
            return strrpos( $string, $needle, 0 ) === $expectedPosition;
        }

        return strripos( $string, $needle, 0 ) === $expectedPosition;
    }
    #endregion

    #region curlExecution_Get

    public static function summarize_text( $text, $size ) {
        $new_text  = self::strip_html_tags( str_replace( '&zwnj;', ' ', $text ) );
        $show_text = substr( $new_text, 0, $size );

        if ( strlen( $show_text ) >= $size ) {
            $end_text = strpos( $new_text, ' ', strlen( $show_text ) );
            if ( $end_text > 0 ) {
                $show_text = substr( $new_text, 0, $end_text );
            }
            $show_text .= "...";
        }

        return $show_text;
    }

    #endregion

    #region sanitizeString

    public static function strip_html_tags( $text ) {
        $text = preg_replace( array(// Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            /** @lang text */
            "@<style[^>]*?>.*?</style>@siu",
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',
            // Add line breaks before and after blocks
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
        ), array(
            ' ',
            ' ',
            ' ',
            ' ',
            ' ',
            ' ',
            ' ',
            ' ',
            ' ',
            "\n\$0",
            "\n\$0",
            "\n\$0",
            "\n\$0",
            "\n\$0",
            "\n\$0",
            "\n\$0",
            "\n\$0",
        ), $text );

        return strip_tags( $text );
    }
    #endregion

    #region summarize_text

    public static function HashKey( $string, $action ) {

        $output         = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key     = md5( date( 'NztWL' ) );
        $secret_iv      = $secret_key;
        // hash
        $key = hash( 'sha256', $secret_key );

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt( $string, $encrypt_method, $key, 0, $iv );
            $output = base64_encode( $output );
        } else if ( $action == 'decrypt' ) {
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }

        return $output;

    }

    #endregion

    #region strip_html_tags

    public static function detectFlight( $origin, $destination ) {
        Load::autoload( 'ModelBase' );
        $ModelBase = new ModelBase();
        $sql       = " SELECT * FROM flight_route_tb WHERE Departure_Code='{$origin}' AND Arrival_Code='{$destination}'";

        $res = $ModelBase->load( $sql );

        if ( $res['local_portal'] == '0' ) {
            return '0';
        } else if ( $res['local_portal'] == '1' ) {
            return '1';
        }

    }
    #endregion

    #region HashKey

    public static function CalculatePricePoint( $param ) {
        /*$Model =  Load::library('Model');
        $sql = " SELECT * FROM point_club_tb WHERE type_service='{$param['service']}' AND is_enable='1' AND counterTypeId='{$param['counterId']}'";
        $res = $Model->load($sql);*/
        if ( $param['price'] > 0 ) {
            $res = self::getPointClub( $param['service'], $param['baseCompany'], $param['company'], $param['counterId'] );
            if ( ! empty( $res ) ) {
                return ( $res['pointToPrice'] * ( ceil( ( $param['price'] / $res['limitPrice'] ) * $res['limitPoint'] ) ) );
            } else {
                return 0;
            }
        } else {
            return 0;
        }

    }

    #endregion

    #region detectFlight

    public static function getPointClub( $service, $baseCompany, $company, $counterId ) {
        $Model = Load::library( 'Model' );
        try {
            $query  = ( "CALL sp_point_club_tb(:service,:baseCompany,:company,:counterId)" );
            $params = array(
                ':service'     => $service,
                ':baseCompany' => $baseCompany,
                ':company'     => $company,
                ':counterId'   => $counterId,
            );
           return $Model->runSP( $query, $params );

        }
        catch ( PDOException $ex ) {
            return false;
        }
    }

    #endregion
    #region getDiscountSpecialTrain

    public static function getDiscountSpecialTrain( $service, $baseCompany, $company, $counterId, $moveDate ) {
        $Model = Load::library( 'Model' );
        try {
            $counterId = ( $counterId == "" ) ? '5' : $counterId;
            $query     = ( "CALL sp_discount_private_train_tb(:service,:baseCompany,:company,:counterId,:moveDate)" );
            $params    = array(
                ':service'     => $service,
                ':baseCompany' => $baseCompany,
                ':company'     => $company,
                ':counterId'   => $counterId,
                ':moveDate'    => $moveDate,
            );
            $result    = $Model->runSP( $query, $params );

            return $result;
        }
        catch ( PDOException $ex ) {
            return false;
        }
    }

    #endregion

    #region CalculatePricePoint

    public static function CalculatePoint( $param ) {
        if ( $param['price'] > 0 ) {
            /*$Model =  Load::library('Model');
            $sql = " SELECT * FROM point_club_tb WHERE type_service='{$param['service']}' AND is_enable='1'  AND counterTypeId='{$param['counterId']}'";
            $res = $Model->load($sql);*/
            $res = self::getPointClub( $param['service'], $param['baseCompany'], $param['company'], $param['counterId'] );
            if ( ! empty( $res ) ) {
                return ceil( ( $param['price'] / $res['limitPrice'] ) * $res['pointToPrice'] );
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    #endregion

    #region pointClub
    public static function pointClub( $param ) {
        $res = self::getPointClub( $param['service'], $param['baseCompany'], $param['company'], $param['counterId'] );
        if ( ! empty( $res ) ) {
            return $res;
        } else {
            return 0;
        }
    }
    #endregion

    #region calculateChargeUser
    public static function calculateChargeUser( $id ) {
        $time         = time() - ( 600 );
        $admin        = Load::controller( 'admin' );
        $sql_charge   = "SELECT sum(Price) AS total_charge FROM transaction_tb WHERE Status='1' AND PaymentStatus = 'success'";
        $charge       = $admin->ConectDbClient( $sql_charge, $id, "Select", "", "", "" );
        $total_charge = $charge['total_charge'];

        $sql_buy   = "SELECT SUM(Price) AS total_buy FROM transaction_tb WHERE Status='2' AND" . " ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')) ";
        $buy       = $admin->ConectDbClient( $sql_buy, $id, "Select", "", "", "" );
        $total_buy = $buy['total_buy'];

        $TotalCharge = number_format( $total_charge - $total_buy );
        $TextType    = '';
        if ( $TotalCharge > 0 ) {
            $TextType = 'بستانکار';
        } else if ( $TotalCharge < 0 ) {
            $TextType = 'بدهکار';
        } else if ( $TotalCharge == 0 ) {
            $TextType = 'تسویه';
        }

        return $TotalCharge . ' ' . 'ریال' . '(' . $TextType . ')';
    }

    public static function calculateChargeUserPrice($id)
    {
        $time = time() - 600;
        $admin = Load::controller('admin');


        $sql_charge = "SELECT sum(Price) AS total_charge FROM transaction_tb WHERE Status='1' AND PaymentStatus = 'success'";
        $charge = $admin->ConectDbClient($sql_charge, $id, "Select", "", "", "");
        $TotalCharge=0;
        if($charge){


        $total_charge = $charge['total_charge'];



        $sql_buy = "SELECT SUM(Price) AS total_buy FROM transaction_tb WHERE Status='2' AND ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}'))";
        $buy = $admin->ConectDbClient($sql_buy, $id, "Select", "", "", "");
        $total_buy = $buy['total_buy'];

        $TotalCharge = $total_charge - $total_buy;
        }
        return $TotalCharge;
    }

    public static function generateChargeUserString($totalCharge)
    {
        $formattedCharge = number_format($totalCharge);
        $textType = '';

        if ($totalCharge > 0) {
            $textType = 'بستانکار';
        } else if ($totalCharge < 0) {
            $textType = 'بدهکار';
        } else if ($totalCharge == 0) {
            $textType = 'تسویه';
        }

        return  '(' . $textType . ')';
    }


    #endregion

    #region calculateChargeUser

    public static function ClientName( $id ) {

        Load::autoload( 'ModelBase' );
        $ModelBase = new ModelBase();

        $sql = " SELECT * FROM clients_tb WHERE id='{$id}'";
        $res = $ModelBase->load( $sql );

        return $res['AgencyName'];
    }

    #endregion

    #region ClientName

    public static function clients() {

        $ModelBase = Load::library( 'ModelBase' );


        $sql = " SELECT * FROM clients_tb ";
        $res = $ModelBase->select( $sql );

        return $res;
    }


    #endregion

    #region mapIataCode
    public static function mapIataCode( $Iata ) {
        $IataNeeded = array( 'IKA', 'MAC' );
        $IataExist  = array( 'THR', 'IMQ' );

        if ( in_array( strtoupper( $Iata ), $IataExist ) ) {
            $replaceIata = str_replace( $IataExist, $IataNeeded, strtoupper( $Iata ) );
        } else {
            $replaceIata = $Iata;
        }

        return $replaceIata;
    }
    #endregion

    #region clients

    public static function infoClient( $id ) {
        $ModelBase = Load::library( 'ModelBase' );
        $sql       = " SELECT * FROM clients_tb WHERE id='{$id}' ";
        $res       = $ModelBase->load( $sql );

        return $res;
    }

    #endregion

    #region infoClient

    public static function infoClientByDomain( $domainName ) {
        $ModelBase = Load::library( 'ModelBase' );
        $sql       = "SELECT * FROM clients_tb WHERE MainDomain LIKE '%{$domainName}%'";
        $res       = $ModelBase->load( $sql );

        return $res;
    }

    #endregion

    #region infoClient

    public static function LogInfo() {
        $Model = Load::library( 'Model' );

        $ip = $_SERVER['REMOTE_ADDR'];
        //        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));


        $d['ip']                = $ip;
        $d['browser']           = $_SERVER['HTTP_USER_AGENT'];
        $d['zone']              = '';//$details->city;
        $d['city']              = '';//$details->region;
        $d['location']          = ''; //$details->country;
        $d['country']           = '';//$details->loc;
        $d['isp']               = '';//$details->org;
        $d['creation_date_int'] = time();

        $Model->setTable( 'log_view_tb' );
        $Model->insertLocal( $d );

    }

    #endregion

    #region LogInfo

    public static function dateArray() {
        $date = array();

        $jdate = dateTimeSetting::jdate( "Y/m/d", time() );
        $ex    = explode( "/", $jdate );
        for ( $i = 11; $i >= 0; $i -- ) {
            $Timenow = dateTimeSetting::jmktime( 0, 0, 0, $ex[1], $ex[2], $ex[0] ) - ( ( $i ) * ( 24 * 60 * 60 ) );

            $date[] = dateTimeSetting::jdate( "l", $Timenow ) . '<br/>' . dateTimeSetting::jdate( "m-d", $Timenow );
        }

        return $date;
    }

    #endregion

    #region CalculateCredit

    public static function CalculateCredit( $id=null) {

        $Model = Load::library( 'Model' );

        $id = ($id > 0) ? $id : Session::getUserId();

        $info_member = self::infoAgencyByMemberId($id);

        $agency_id = !empty($info_member) ? $info_member['fk_agency_id'] : (Session::getAgencyId()) ;

        $sql_charge   = "SELECT sum(credit) AS total_charge FROM credit_detail_tb WHERE type='increase' AND fk_agency_id='{$agency_id} '  AND (PaymentStatus='success' OR PaymentStatus IS NULL)";
        $charge       = $Model->load( $sql_charge );
        $total_charge = $charge['total_charge'];

        $sql_buy   = "SELECT sum(credit) AS total_buy FROM credit_detail_tb WHERE type='decrease' AND fk_agency_id='{$agency_id}'  AND (PaymentStatus='success' OR PaymentStatus IS NULL)";
        $buy       = $Model->load( $sql_buy );
        $total_buy = $buy['total_buy'];

        $total_transaction = $total_charge - $total_buy;


        $total_transaction = ($info_member['payment']=='credit' && $info_member['limit_credit'] > 0 && (time() <= $info_member['time_limit_credit'])) ? ($total_transaction + $info_member['limit_credit']) : $total_transaction ;


        if($info_member['type_payment'] == 'currency')
        {
            /** @var currencyEquivalent $currency_controller */
            $currency_controller = Load::controller('currencyEquivalent');
            $info_currency = $currency_controller->InfoCurrency($info_member['type_currency']);
            return number_format($total_transaction).' '. $info_currency['CurrencyTitleEn'];
        }

        return number_format($total_transaction) .' '. self::Xmlinformation('Rial');
    }

    #endregion


    #region TypeUser

    public static function TypeUser( $id ) {

        $Model = Load::library( 'Model' );
        $SqlMember = "SELECT * FROM members_tb WHERE id='{$id}'";
        $member = $Model->load( $SqlMember );

        return ( $member['fk_counter_type_id'] >= 1 && $member['fk_counter_type_id'] < 5 ) ? 'Counter' : 'Ponline';
    }

    #endregion
    
    #region compareDate

    public static function compareDate( $DepartureDate, $DepartureTime, $Type24H = null ) {
        //        if (!empty($Type24H) && $Type24H == 'yes') {
        //            $Date4Hours = time() + (24 * 60 * 60);
        //        } else {
        $Date4Hours = time() + ( 3 * 60 * 60 );
        //        }

        $date = explode( 'T', $DepartureDate );

        $date_expl = explode( '-', $date[0] );
        $hour      = '';
        $min       = '';
        if ( isset( $date[1] ) && ! empty( $date[1] ) ) {
            $time_expl = explode( ':', $date[1] );
            $hour      = $time_expl[0];
            $min       = $time_expl[1];
        } else {
            if ( ! empty( $DepartureTime ) ) {
                $time_exp_time = explode( ':', $DepartureTime );
                $hour          = $time_exp_time[0];
                $min           = $time_exp_time[1];
            } else {
                $hour = '0';
                $min  = '0';
            }


        }


        $Flight_Time = dateTimeSetting::jmktime( $hour, $min, 0, $date_expl[1], $date_expl[2], $date_expl[0] );

        if ( $Flight_Time > $Date4Hours ) {
            return 'true';
        } else {
            return 'false';
        }
    }

    #endregion

    #region compareDate

    public static function DateJalali( $param ) {
        $timeStamp = self::ConvertToDateJalaliInt( $param );

        $date = dateTimeSetting::jdate( "Y-m-d", $timeStamp, '', '', 'en' );

        return $date;
    }

    #endregion

    #region ConvertToDateJalaliInt

    public static function ConvertToDateJalaliInt( $param ) {
        $exMiladi = explode( '-', $param );

        $date = dateTimeSetting::gregorian_to_jalali( $exMiladi[0], $exMiladi[1], $exMiladi[2] );

        return dateTimeSetting::jmktime( 0, 0, 0, $date[1], $date[2], $date[0] );
    }

    #endregion

    #region DateJalali

    public static function AdultCount( $requestNumber ) {

        Load::autoload( 'ModelBase' );

        $ModelBase = new ModelBase();

        $SqlAdult = "SELECT Count(id) AS AdultCount FROM report_tb WHERE request_number='{$requestNumber}' AND passenger_age='Adt'";

        $ResultAdult = $ModelBase->load( $SqlAdult );


        return $ResultAdult['AdultCount'];

    }
    #endregion

    #region AdultCount

    public static function ChildCount( $requestNumber ) {

        Load::autoload( 'ModelBase' );

        $ModelBase = new ModelBase();

        $SqlChild = "SELECT Count(id) AS ChildCount FROM report_tb WHERE request_number='{$requestNumber}' AND passenger_age='Chd'";

        $ResultChild = $ModelBase->load( $SqlChild );


        return $ResultChild['ChildCount'];

    }

    #endregion

    #region ChildCount

    public static function InfantCount( $requestNumber ) {

        Load::autoload( 'ModelBase' );

        $ModelBase = new ModelBase();

        $SqlInfant = "SELECT Count(id) AS InfantCount FROM report_tb WHERE request_number='{$requestNumber}' AND passenger_age='Inf'";

        $ResultInfant = $ModelBase->load( $SqlInfant );


        return $ResultInfant['InfantCount'];

    }

    #endregion

    #region InfantCount

    public static function UserNameApi( $clientID ) {
        Load::autoload( 'ModelBase' );

        $ModelBase = new ModelBase();

        $SqlClientUser = "SELECT * FROM client_api_tb WHERE ClientID='{$clientID}' ";

        $ResultClientUser = $ModelBase->load( $SqlClientUser );

        return $ResultClientUser['UserName'];

    }

    #endregion

    #region convertDate

    public static function convertDate( $param  , $type = '-') {
        $dateYear  = substr( $param, 0, 4 );
        $dateMonth = substr( $param, 4, 2 );
        $dateDay   = substr( $param, 6, 2 );

        return $dateYear . $type . $dateMonth . $type . $dateDay;
    }

    #endregion

    #region checkPrivateAirlineForeign

    public static function checkPrivateAirlineForeign( $iata, $clientId = null ) {
        if ( $clientId != null ) {
            $clientId = $clientId;
        } else {
            $clientId = CLIENT_ID;
        }

        $admin = Load::controller( 'admin' );
        $sql   = " SELECT foreignAirline AS PrivateAirline FROM airline_client_tb WHERE  airline_iata ='{$iata}' ";
        $pid   = $admin->ConectDbClient( $sql, $clientId, "Select", "", "", "" );
        if ( $pid['PrivateAirline'] == 'active' ) {
            return 'private';
        } else {
            return 'public';
        }
    }

    #endregion

    #region check_pid

    public static function GetInfoBus( $factorNumber ) {
        $factorNumber = trim( $factorNumber );

        if ( TYPE_ADMIN == '1' ) {
            $ModelBase = Load::library( 'ModelBase' );

            $sql    = "select *,
                 (SELECT COUNT(id) FROM report_bus_tb WHERE passenger_factor_num='$factorNumber') AS CountId
                 from report_bus_tb  where passenger_factor_num='$factorNumber'  ";
            $result = $ModelBase->load( $sql );
        } else {
            Load::autoload( 'Model' );
            $Model = new Model();

            $sql    = "select *,
                (SELECT COUNT(id) FROM book_bus_tb WHERE passenger_factor_num='$factorNumber') AS CountId
                from book_bus_tb  where passenger_factor_num='$factorNumber' ";
            $result = $Model->load( $sql );
        }

        return $result;

    }


    #endregion


    #region GetInfoHotel

    public static function GetInfoHotel( $factorNumber ) {
        $factorNumber = trim( $factorNumber );
//		$Model        = Load::library( 'Model' );
//		$sql = " SELECT * FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}' ";
//		$sql = "
//         SELECT
//            ( SELECT COUNT(id) FROM book_hotel_local_tb WHERE factor_number = '{$factorNumber}' ) as countPassengers,
//            BH.*
//        FROM
//            book_hotel_local_tb AS BH
//        WHERE
//            BH.factor_number = '{$factorNumber}'
//            ";
//		$rec = $Model->select( $sql, 'assoc' );

        /** @var bookHotelLocalModel $book_model */
        $book_model = Load::getModel('bookHotelLocalModel');
        $records = $book_model->get()->where('factor_number',$factorNumber)->all();

        $total_child_price = $total_extra_bed_price = $total_online_price = $agency_commission = $total_price_transaction = 0;
        $type_of_price_change = '';
        if(count($records) <= 0){
            return false;
        }
        foreach ($records as $key => $record) {
            if ( $key == '0' ) {
                $infoHotel = $record;
            }
            $total_online_price = $record['total_price_api'];
            $agency_commission += $record['agency_commission'];
            $total_child_price += $record['child_price'] * $record['child_count'];
            $total_extra_bed_price += $record['extra_bed_price'] * $record['extra_bed_count'];
            $total_price_transaction = $total_online_price;

        }
        $type_of_price_change = $records[0]['type_of_price_change'];

//		$agency_commission    = 0;
//		$type_of_price_change = '';
//    $total_price_transaction = $rec[0]['room_online_price'];
//		foreach ( $rec as $k => $val ) {
//			if ( $k == '0' ) {
//				$infoHotel = $val;
//			}
//      $total_price_transaction = ($total_price_transaction +
//          ($rec['child_price'] * $rec['child_count']) +
//          ($rec['extra_bed_price'] * $rec['extra_bed_count']));
//			$agency_commission    += $val['agency_commission'];
//			$type_of_price_change = $val['type_of_price_change'];
//		}

        $infoHotel['typePriceChange']  = $type_of_price_change;
        $infoHotel['agencyCommission'] = $agency_commission;
        $infoHotel['countPassengers'] = count($records);


        //		if ($rec[0]['type_application'] == 'api' || $rec[0]['type_application'] == 'api_app' || $rec[0]['type_application'] == 'externalApi') {
        //			$infoHotel['totalPriceTransaction'] = $rec[0]['total_price_api'];
        //		} else {
        //			$infoHotel['totalPriceTransaction'] = $rec[0]['total_price'];
        //		}


        $infoHotel['totalPriceTransaction'] = $total_price_transaction;

        self::insertLog(json_encode($infoHotel,256|64),'infoHotel');

        return $infoHotel;
    }
    #endregion


    #region GetInfoBus

    public static function GetInfoReservationTicket( $factorNumber ) {
        Load::autoload( 'Model' );
        $Model = new Model();

        $factorNumber = trim( $factorNumber );
        $sql          = " SELECT
                     *,
                     (SELECT SUM(adt_qty) + SUM(chd_qty) + SUM(inf_qty) FROM book_local_tb WHERE factor_number='{$factorNumber}') as countPassengers
                     FROM book_local_tb WHERE factor_number='{$factorNumber}' GROUP BY direction";
        $rec          = $Model->select( $sql );
        $book         = $rec[0];
        if ( isset( $rec[1]['direction'] ) && $rec[1]['direction'] = 'return' ) {
            $book['multiWay'] = 'دو طرفه';
        } else {
            $book['multiWay'] = 'یک طرفه';
        }
        $resultReservationTicket = Load::controller( 'resultReservationTicket' );
        $book['typeReservation'] = $resultReservationTicket->getTypeVehicleByTicketId( $rec[0]['fk_id_ticket'] );

        return $book;
    }
    #endregion

    #region infoAgencyByMemberId
    public static function infoAgencyByMemberId( $id, $ClientId = null ) {


        $sql = " SELECT members.*,
                  agency.name_fa as name_fa,
                  agency.name_en as name_en,
                  agency.logo as logo,
                  agency.address_fa as address_fa,
                  agency.address_en as address_en,
                  agency.domain as domain,
                  agency.phone as phone,
                  agency.type_payment as type_payment ,agency.type_currency as type_currency,agency.limit_credit as limit_credit,agency.time_limit_credit as time_limit_credit , agency.payment as payment
                  FROM
                      members_tb AS members
                      LEFT JOIN agency_tb AS agency ON members.fk_agency_id=agency.id
                  WHERE
                      members.id='{$id}' ";

        if (TYPE_ADMIN == '1') {
            /** @var admin $admin */
            $admin = Load::controller('admin');
            $ClientId = !empty($ClientId) ? $ClientId : CLIENT_ID;
            return $admin->ConectDbClient($sql, $ClientId, "Select", "", "", "");
        } else {
            $model = Load::library( 'Model' );
            return $model->load($sql);

        }

    }

    #endregion

    /*#region CalculatePercent

    public static function CalculatePercent($id, $price, $iata, $flightType)
    {

        Load::autoload('Model');

        $Model = new Model();

        $SqlCounterType = "SELECT * FROM counter_type_tb WHERE id='{$id}'";

        $CounterType = $Model->load($SqlCounterType);

        if ($flightType == "system" && self::check_pid($iata) == 'private' && $CounterType['discount_system_private'] > 0) {
            return number_format($price - (($price * $CounterType['discount_system_private']) / 100));
        } else if ($flightType == "system" && self::check_pid($iata) == 'public' && $CounterType['discount_system_public'] > 0) {
            return number_format($price - (($price * $CounterType['discount_system_public']) / 100));
        } else if ($flightType == "charter" && $CounterType['discount_charter'] > 0) {
            return number_format($price - (($price * $CounterType['discount_charter']) / 100));
        } else {

            return number_format($price);
        }

    }
    #endregion*/


    #region check_pid
    //فعلا تا تکمیل شدن تنظیمات اختصاصی و اشتراکی فعال می باشد،یعنی فانکشن پایین
    public static function check_pid( $iata, $clientId = null ) {
        if ( $clientId == null ) {
            $clientId = CLIENT_ID;
        }

        /** @var admin $admin */
        $admin = Load::controller( 'admin' );
        $sql   = " SELECT * FROM airline_client_tb WHERE  airline_iata ='{$iata}' ";
        $pid   = $admin->ConectDbClient( $sql, $clientId, "Select", "", "", "" );
        if ( $pid['pid_private'] == '1' ) {
            return 'private';
        } else {
            return 'public';
        }
    }
    #endregion

    #region check_pid
    /**
     * @param $iata
     * @param $isInternal
     * @param $typeFlight
     * @param $sourceId
     * @param null $clientId
     * @return string
     */
    public static function checkConfigPid($iata=null, $isInternal=null, $typeFlight=null, $sourceId=null, $clientId = null ) {
        if ( empty( $clientId ) ) {
            $clientId = CLIENT_ID;
        }

        $isInternal = ( $isInternal == 'internal' ) ? '1' : '0';

        $airlineInfo = self::InfoAirline( $iata );

        $admin = Load::controller( 'admin' );
        $sql   = " SELECT isPublic ,isPublicreplaced,sourceReplaceId,sourceId FROM config_flight_tb WHERE  airlineId ='{$airlineInfo['id']}' AND typeFlight='{$typeFlight}' AND isInternal='{$isInternal}'";
        $pid   = $admin->ConectDbClient( $sql, $clientId, "Select", "", "", "" );
        if ( ($pid['isPublic'] == '0' && $pid['sourceId']==$sourceId ) || ($pid['isPublicreplaced'] == '0' && $pid['sourceReplaceId']==$sourceId )) {
            return 'private';
        } else {
            return 'public';
        }
    }
    #endregion


    #region infoMember

    public static function ShowPrice( $RequestNumber ) {
        Load::autoload( 'Model' );

        $Model = new Model();

        $SqlBookLocal = "SELECT *,SUM(inf_price) AS InfPrice FROM book_local_tb WHERE request_number='{$RequestNumber}'";

        $BookLocal = $Model->load( $SqlBookLocal );

        $inf  = $BookLocal['InfPrice'] + $BookLocal['api_commission'];
        $inf  = $BookLocal['flight_type'] == "charter" ? $inf + $BookLocal['price_change'] : $inf;
        $text = '';
        if ( $inf > 550000 ) {
            $result['result_status']  = 'markup';
            $result['result_message'] = functions::StrReplaceInXml( [ '@@infant@@' => $inf ], 'PriceInfantInc' );
        } elseif ( $inf < 550000 ) {
            $result['result_status']  = 'markdown';
            $result['result_message'] = functions::StrReplaceInXml( [ '@@infant@@' => $inf ], 'PriceInfantDec' );
        }
        return $result;
    }
    #endregion


    #region StrReplaceInXml

    public static function StrReplaceInXml( $param, $tagname ) {

        $string  = self::Xmlinformation( $tagname );

        $search  = array_keys( $param );
        $replace = array_values( $param );

        return str_replace( $search, $replace, $string );
    }

    #endregion

    #region StrReplaceInArray

    public static function StrReplaceInArray( $param, $data_translate ) {
        $search  = array_keys( $param );
        $replace = array_values( $param );
        return str_replace( $search, $replace, $data_translate );
    }

    #endregion

    #region Xmlinformation

    public static function Xmlinformation( $tagname ) {
     
        $xmldata = simplexml_load_file( SITE_ROOT . "/langs/" . SOFTWARE_LANG . "_frontMaster.xml" );

        return  empty( $xmldata->$tagname ) ? "" : $xmldata->$tagname;

    }

    #endregion

    #region ShowPrice

    public static function CountryCodes() {
        $ModelBase = Load::library( 'ModelBase' );

        $SqlCountryCodes = "SELECT * FROM country_codes_tb ";

        if(CLIENT_ID != 200 || CLIENT_ID != 358 || CLIENT_ID != 368 )
        {
            $SqlCountryCodes .= " WHERE (code_two_letter !='IR' OR code !='IRN')" ;
        }

        $CountryCodes = $ModelBase->select( $SqlCountryCodes );

        return $CountryCodes;

    }

    #endregion

    #region ChoosCountryPassenger

    public static function ChoosCountryPassenger( $code, $Type = null ) {
        Load::autoload( 'ModelBase' );

        $ModelBase = new ModelBase();

        if ( $Type == 'AppMulti' || $Type == 'AppSingle' ) {

            $SqlCountryCodes = "SELECT * FROM country_codes_tb WHERE code='{$code}' OR titleFa LIKE '%{$code}%' OR titleEn LIKE '%{$code}%'";
            if ( $Type == 'AppSingle' ) {
                $CountryCodes = $ModelBase->Load( $SqlCountryCodes );
            } else if ( $Type == 'AppMulti' ) {
                $CountryCodes = $ModelBase->select( $SqlCountryCodes );
            }

        } else {
            $SqlCountryCodes = "SELECT * FROM country_codes_tb WHERE code='{$code}'";
            $CountryCodes    = $ModelBase->load( $SqlCountryCodes );
        }


        return $CountryCodes;
    }

    #endregion


    #region Calculate infoMember

    public static function infoMember( $id, $ClientId = null ) {

        $admin     = Load::controller( 'admin' );
        $SqlMember = "SELECT * FROM members_tb WHERE id='{$id}'";
        //        $Member = $Model->load($SqlMember);
        $ClientId = ! empty( $ClientId ) ? $ClientId : CLIENT_ID;
        
        if ( TYPE_ADMIN == '1' ):
            $Member = $admin->ConectDbClient( $SqlMember, $ClientId, "Select", "", "", "" );
        else:
            $Member = $admin->ConectDbClient( $SqlMember, CLIENT_ID, "Select", "", "", "" );
        endif;
      
        return $Member;
    }
    #endregion

    #region infoCounterType

    public static function infoCounterType( $id = null, $ClientId = null ) {
        if ( $id == '' ) {
            $id = '5';
        }

        $admin          = Load::controller( 'admin' );
        $SqlCounterType = "SELECT * FROM counter_type_tb WHERE id='{$id}'";

        $ClientId = ! empty( $ClientId ) ? $ClientId : CLIENT_ID;
        if ( TYPE_ADMIN == '1' ):
            $CounterType = $admin->ConectDbClient( $SqlCounterType, $ClientId, "Select", "", "", "" );
        else:
            $CounterType = $admin->ConectDbClient( $SqlCounterType, CLIENT_ID, "Select", "", "", "" );
        endif;

        return $CounterType;

    }

    #endregion

    #region CalculateDiscount

    public static function CalculateDiscount( $RequestNumber, $FlagPriceChange = 'yes',$special_calculate=true ) {
        //yes means nesesary calculate  price changes
        $modelBase = Load::library( 'ModelBase' );

        $Sql = "SELECT * FROM report_tb WHERE (request_number='{$RequestNumber}' OR factor_number='{$RequestNumber}')";

        $rec    = $modelBase->select( $Sql );


        $amount = 0;


        foreach ( $rec as $each ) {

            //در هر رکورد فقط یکی از قیمت ها با توجه به سن مقدار دارد و دوتای دیگر صفر هستند
            if ( strtolower( $each['flight_type'] ) == 'system' ) {

               $isCounter = Load::controller( 'login' )->isCounter();
                $isCounter = json_decode($isCounter);
               $isSafar360 = self::isSafar360();

                // اگر میخواهید تخفیف برای منبع درست کار کند مانند شرط زیر برای منبع مورد نظر هم یک شرط بزارید-

                if ( ($each['IsInternal'] == '1' && $each['api_id'] != '14') || ($each['api_id'] != '10' && $each['api_id'] != '15' && $each['api_id'] != '17' && $each['api_id'] != '14' && $each['api_id'] != '8' && $each['api_id'] != '43' && $each['api_id'] != '21' && $each['api_id'] != '20') ) {



                    if ( $each['percent_discount'] > 0 ) {
                        if ( $each['pid_private'] == '0' ) {

                            if (isset($each['adt_price']) && $each['adt_price'] != '0') {
                                $amount += $each['adt_price'] - ($each['system_flight_commission'] * ($each['percent_discount'] / 100));
                            }
                            if (isset($each['chd_price']) && $each['chd_price'] != '0') {
                                $amount += $each['chd_price'] - ($each['system_flight_commission'] * ($each['percent_discount'] / 100));
                            }
                            if (isset($each['inf_price']) && $each['inf_price'] != '0') {
                                $amount += $each['inf_price'] - ($each['system_flight_commission'] * ($each['percent_discount'] / 100));
                            }

                        } elseif ( $each['pid_private'] == '1' ) {
                           if ($isCounter || $isSafar360) {
                              $amount += ($each['adt_price'] - $each['adt_com']) - ( $each['adt_com'] * ( $each['percent_discount'] / 100 ) );
                              $amount += ($each['chd_price'] - $each['chd_com']) - ( $each['chd_com'] * ( $each['percent_discount'] / 100 ) );
                              $amount += ($each['inf_price'] - $each['inf_com']) - ( $each['inf_com'] * ( $each['percent_discount'] / 100 ) );
                           } else {
                              $amount += $each['adt_price'] - ( $each['adt_com'] * ( $each['percent_discount'] / 100 ) );
                              $amount += $each['chd_price'] - ( $each['chd_com'] * ( $each['percent_discount'] / 100 ) );
                              $amount += $each['inf_price'] - ( $each['inf_com'] * ( $each['percent_discount'] / 100 ) );
                           }

                        }
                    }
                    else {
                       if ($each['pid_private'] == '0') {
                          $amount += $each['adt_price'] + $each['chd_price'] + $each['inf_price'];
                       } elseif ($each['pid_private'] == '1') {
                          if ($isCounter || $isSafar360) {
                             $amount += ($each['adt_price'] - $each['adt_com']) + ($each['chd_price'] - $each['chd_com']) + ($each['inf_price'] - $each['inf_com']);
                          } else {
                             $amount += $each['adt_price'] + $each['chd_price'] + $each['inf_price'];
                          }
                       }
                    }
                }
                else {
                    if ( $each['IsInternal'] == '0' || $each['api_id'] == '14') {

                       $airlineModel = Load::getModel('airlineModel');
                       $airlineForCom = $airlineModel->get(['abbreviation','foreignAirline','amadeusStatus'], true)->where('abbreviation', $each['airline_iata'])->all();
                       if (!isset($airlineForCom[0]['foreignAirline'])) {
                          $foreignAirline = null;
                       }
                       if ($airlineForCom[0]['foreignAirline'] == 'active' || $airlineForCom[0]['foreignAirline'] == null || empty($airlineForCom[0]['foreignAirline']) ) {
                          $foreignAirline = true;
                       } else {
                          $foreignAirline = false;
                       }

                            if (!$foreignAirline) {
                                if ( $each['pid_private'] == '0' ) {

                                    if (isset($each['adt_price']) && $each['adt_price'] > 0) {
                                        $amount += $each['adt_price'] - ($each['system_flight_commission'] * ($each['percent_discount'] / 100));
                                    }
                                    if (isset($each['chd_price']) && $each['chd_price'] > 0) {
                                        $amount += $each['chd_price'] - ($each['system_flight_commission'] * ($each['percent_discount'] / 100));
                                    }
                                    if (isset($each['inf_price']) && $each['inf_price'] > 0) {
                                        $amount += $each['inf_price'] - ($each['system_flight_commission'] * ($each['percent_discount'] / 100));
                                    }

                                }
                                elseif ( $each['pid_private'] == '1' ) {

                                   if ($isCounter || $isSafar360) {
                                      $amount += ($each['adt_price'] - $each['adt_com']) - ( $each['adt_com'] * ( $each['percent_discount'] / 100 ) );
                                      $amount += ($each['chd_price'] - $each['chd_com']) - ( $each['chd_com'] * ( $each['percent_discount'] / 100 ) );
                                      $amount += ($each['inf_price'] - $each['inf_com']) - ( $each['inf_com'] * ( $each['percent_discount'] / 100 ) );
                                   } else {
                                      $amount += $each['adt_price'] - ( $each['adt_com'] * ( $each['percent_discount'] / 100 ) );
                                      $amount += $each['chd_price'] - ( $each['chd_com'] * ( $each['percent_discount'] / 100 ) );
                                      $amount += $each['inf_price'] - ( $each['inf_com'] * ( $each['percent_discount'] / 100 ) );
                                   }
                                }
                            }
                            else {

                            $everyAmount = $each['api_commission'] + $each['adt_price'] + $each['chd_price'] + $each['inf_price'];






                        if ( $each['price_change'] > 0 && $each['price_change_type'] == 'percent' ) {

                          if($each['IsInternal'] == '1' &&  $each['api_id'] == '14'){
                              $everyAmountFake = $each['api_commission'] + $each['adt_fare'] + $each['chd_fare'] + $each['inf_fare'];
                          }
                          else{
                              $everyAmountFake = $each['api_commission'] + $each['adt_price'] + $each['chd_price'] + $each['inf_price'];

                          }

                          $ChangeAmount    = $everyAmountFake * ( $each['price_change'] / 100 );


                           
                          $everyAmount     += $ChangeAmount;

                          $amount          += $everyAmount - ( ( $ChangeAmount * $each['percent_discount'] ) / 100 );


                        }
                        else if ( $each['price_change'] > 0 && $each['price_change_type'] == 'cost' ) {
                            $ChangeAmount = $each['price_change'];
                            $everyAmount  += $ChangeAmount;
                            $amount       += $everyAmount - ( ( $ChangeAmount * $each['percent_discount'] ) / 100 );
                        }
                        else {
                            $amount += $everyAmount;
                        }
                            }
                    }
                }
            }
            else {


                $everyAmount = $each['api_commission'] + $each['adt_price'] + $each['chd_price'] + $each['inf_price'];

                if ( $each['price_change'] > 0 && $each['price_change_type'] == 'cost' ) {
                    $everyAmount  += $each['irantech_commission'];
                    $ChangeAmount = $each['price_change'];
                    $everyAmount  += $ChangeAmount;
                    if ( $each['passenger_age'] == 'Adt' || $each['passenger_age'] == 'Chd' ) {
                        $amount += $everyAmount - ( ( $ChangeAmount * $each['percent_discount'] ) / 100 );
                    } else if ( $each['passenger_age'] == 'Inf' ) {
                        $amount += $everyAmount;
                    }
                }
                elseif ( $each['price_change'] > 0 && $each['price_change_type'] == 'percent' ) {
                    $everyAmountFake = $each['api_commission'] + $each['adt_price'] + $each['chd_price'] + $each['inf_price'];
                    $ChangeAmount    = $everyAmountFake * ( $each['price_change'] / 100 );

                    $everyAmount += $ChangeAmount;
                    $everyAmount += $each['irantech_commission'];


                    if ( $each['passenger_age'] == 'Adt' || $each['passenger_age'] == 'Chd' ) {
                        $amount += $everyAmount - ( ( $ChangeAmount * $each['percent_discount'] ) / 100 );
                    } else if ( $each['passenger_age'] == 'Inf' ) {
                        $amount += $everyAmount;
                    }
                } else {
                    if ( $each['passenger_age'] == 'Adt' || $each['passenger_age'] == 'Chd' ) {
                        $ChangeAmount = 0;
                        $everyAmount  += $each['irantech_commission'];
                        $amount       += $everyAmount - ( ( $ChangeAmount * $each['percent_discount'] ) / 100 );
                    } else if ( $each['passenger_age'] == 'Inf' ) {
                        $everyAmount += $each['irantech_commission'];
                        $amount      += $everyAmount;
                    }
                }
            }
        }

        $amount_special_discount = $amount - (self::calculateSpecialDiscount($rec[0]['special_discount_type'],$rec[0]['special_discount_amount'],$amount)) ;
        $amount = ($rec[0]['special_discount_type'] !="" && $rec[0]['special_discount_amount'] > 0 && $special_calculate) ? $amount_special_discount : $amount;

        return round( $amount );
    }
    #endregion

    #region calculateFare

   public static function CalculateDiscountOnePerson( $RequestNumber, $nationalCode, $FlagPriceChange = 'yes' ) {

      //yes means nesesary calculate  price changes
      $modelBase = Load::library( 'Model' );



      $Sql = "SELECT *  FROM book_local_tb WHERE (request_number='{$RequestNumber}' OR factor_number='{$RequestNumber}') AND (passenger_national_code='{$nationalCode}' OR passportNumber='{$nationalCode}')";

      $rec = $modelBase->load( $Sql );


      $amount     = 0;
      $isInternal = ( $rec['IsInternal'] == '1' ) ? 'internal' : 'external';
      if ( strtolower( $rec['flight_type'] ) == 'system' ) {

         $isCounter = Load::controller( 'login' )->isCounter();
         $isCounter = json_decode($isCounter);
         $isSafar360 = self::isSafar360();

         // اگر میخواهید تخفیف برای منبع درست کار کند مانند شرط زیر برای منبع مورد نظر هم یک شرط بزارید-

         if ( ($rec['IsInternal'] == '1' && $rec['api_id'] != '14') || ($rec['api_id'] != '10' && $rec['api_id'] != '15' && $rec['api_id'] != '17' && $rec['api_id'] != '14' && $rec['api_id'] != '8' && $rec['api_id'] != '43' && $rec['api_id'] != '21' && $rec['api_id'] != '20') ) {



            if ( $rec['percent_discount'] > 0 ) {
               if ( $rec['pid_private'] == '0' ) {

                  if (isset($rec['adt_price']) && $rec['adt_price'] != '0') {
                     $amount += $rec['adt_price'] - ($rec['system_flight_commission'] * ($rec['percent_discount'] / 100));
                  }
                  if (isset($rec['chd_price']) && $rec['chd_price'] != '0') {
                     $amount += $rec['chd_price'] - ($rec['system_flight_commission'] * ($rec['percent_discount'] / 100));
                  }
                  if (isset($rec['inf_price']) && $rec['inf_price'] != '0') {
                     $amount += $rec['inf_price'] - ($rec['system_flight_commission'] * ($rec['percent_discount'] / 100));
                  }

               } elseif ( $rec['pid_private'] == '1' ) {
                  if ($isCounter || $isSafar360) {
                     $amount += ($rec['adt_price'] - $rec['adt_com']) - ( $rec['adt_com'] * ( $rec['percent_discount'] / 100 ) );
                     $amount += ($rec['chd_price'] - $rec['chd_com']) - ( $rec['chd_com'] * ( $rec['percent_discount'] / 100 ) );
                     $amount += ($rec['inf_price'] - $rec['inf_com']) - ( $rec['inf_com'] * ( $rec['percent_discount'] / 100 ) );
                  } else {
                     $amount += $rec['adt_price'] - ( $rec['adt_com'] * ( $rec['percent_discount'] / 100 ) );
                     $amount += $rec['chd_price'] - ( $rec['chd_com'] * ( $rec['percent_discount'] / 100 ) );
                     $amount += $rec['inf_price'] - ( $rec['inf_com'] * ( $rec['percent_discount'] / 100 ) );
                  }

               }
            }
            else {
               if ($rec['pid_private'] == '0') {
                  $amount += $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];
               } elseif ($rec['pid_private'] == '1') {
                  if ($isCounter || $isSafar360) {
                     $amount += ($rec['adt_price'] - $rec['adt_com']) + ($rec['chd_price'] - $rec['chd_com']) + ($rec['inf_price'] - $rec['inf_com']);
                  } else {
                     $amount += $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];
                  }
               }
            }
         }
         else {
            if ( $rec['IsInternal'] == '0' || $rec['api_id'] == '14') {

               $airlineModel = Load::getModel('airlineModel');
               $airlineForCom = $airlineModel->get(['abbreviation','foreignAirline','amadeusStatus'], true)->where('abbreviation', $rec['airline_iata'])->all();
               if (!isset($airlineForCom[0]['foreignAirline'])) {
                  $foreignAirline = null;
               }
               if ($airlineForCom[0]['foreignAirline'] == 'active' || $airlineForCom[0]['foreignAirline'] == null || empty($airlineForCom[0]['foreignAirline']) ) {
                  $foreignAirline = true;
               } else {
                  $foreignAirline = false;
               }

               if (!$foreignAirline) {
                  if ( $rec['pid_private'] == '0' ) {

                     if (isset($rec['adt_price']) && $rec['adt_price'] > 0) {
                        $amount += $rec['adt_price'] - ($rec['system_flight_commission'] * ($rec['percent_discount'] / 100));
                     }
                     if (isset($rec['chd_price']) && $rec['chd_price'] > 0) {
                        $amount += $rec['chd_price'] - ($rec['system_flight_commission'] * ($rec['percent_discount'] / 100));
                     }
                     if (isset($rec['inf_price']) && $rec['inf_price'] > 0) {
                        $amount += $rec['inf_price'] - ($rec['system_flight_commission'] * ($rec['percent_discount'] / 100));
                     }

                  }
                  elseif ( $rec['pid_private'] == '1' ) {

                     if ($isCounter || $isSafar360) {
                        $amount += ($rec['adt_price'] - $rec['adt_com']) - ( $rec['adt_com'] * ( $rec['percent_discount'] / 100 ) );
                        $amount += ($rec['chd_price'] - $rec['chd_com']) - ( $rec['chd_com'] * ( $rec['percent_discount'] / 100 ) );
                        $amount += ($rec['inf_price'] - $rec['inf_com']) - ( $rec['inf_com'] * ( $rec['percent_discount'] / 100 ) );
                     } else {
                        $amount += $rec['adt_price'] - ( $rec['adt_com'] * ( $rec['percent_discount'] / 100 ) );
                        $amount += $rec['chd_price'] - ( $rec['chd_com'] * ( $rec['percent_discount'] / 100 ) );
                        $amount += $rec['inf_price'] - ( $rec['inf_com'] * ( $rec['percent_discount'] / 100 ) );
                     }
                  }
               }
               else {

                  $everyAmount = $rec['api_commission'] + $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];






                  if ( $rec['price_change'] > 0 && $rec['price_change_type'] == 'percent' ) {

                     if($rec['IsInternal'] == '1' &&  $rec['api_id'] == '14'){
                        $everyAmountFake = $rec['api_commission'] + $rec['adt_fare'] + $rec['chd_fare'] + $rec['inf_fare'];
                     }
                     else{
                        $everyAmountFake = $rec['api_commission'] + $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];

                     }

                     $ChangeAmount    = $everyAmountFake * ( $rec['price_change'] / 100 );



                     $everyAmount     += $ChangeAmount;

                     $amount          += $everyAmount - ( ( $ChangeAmount * $rec['percent_discount'] ) / 100 );


                  }
                  else if ( $rec['price_change'] > 0 && $rec['price_change_type'] == 'cost' ) {
                     $ChangeAmount = $rec['price_change'];
                     $everyAmount  += $ChangeAmount;
                     $amount       += $everyAmount - ( ( $ChangeAmount * $rec['percent_discount'] ) / 100 );
                  }
                  else {
                     $amount += $everyAmount;
                  }
               }
            }
         }
      }
      else {


         $everyAmount = $rec['api_commission'] + $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];

         if ( $rec['price_change'] > 0 && $rec['price_change_type'] == 'cost' ) {
            $everyAmount  += $rec['irantech_commission'];
            $ChangeAmount = $rec['price_change'];
            $everyAmount  += $ChangeAmount;
            if ( $rec['passenger_age'] == 'Adt' || $rec['passenger_age'] == 'Chd' ) {
               $amount += $everyAmount - ( ( $ChangeAmount * $rec['percent_discount'] ) / 100 );
            } else if ( $rec['passenger_age'] == 'Inf' ) {
               $amount += $everyAmount;
            }
         }
         elseif ( $rec['price_change'] > 0 && $rec['price_change_type'] == 'percent' ) {
            $everyAmountFake = $rec['api_commission'] + $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];
            $ChangeAmount    = $everyAmountFake * ( $rec['price_change'] / 100 );

            $everyAmount += $ChangeAmount;
            $everyAmount += $rec['irantech_commission'];


            if ( $rec['passenger_age'] == 'Adt' || $rec['passenger_age'] == 'Chd' ) {
               $amount += $everyAmount - ( ( $ChangeAmount * $rec['percent_discount'] ) / 100 );
            } else if ( $rec['passenger_age'] == 'Inf' ) {
               $amount += $everyAmount;
            }
         } else {
            if ( $rec['passenger_age'] == 'Adt' || $rec['passenger_age'] == 'Chd' ) {
               $ChangeAmount = 0;
               $everyAmount  += $rec['irantech_commission'];
               $amount       += $everyAmount - ( ( $ChangeAmount * $rec['percent_discount'] ) / 100 );
            } else if ( $rec['passenger_age'] == 'Inf' ) {
               $everyAmount += $rec['irantech_commission'];
               $amount      += $everyAmount;
            }
         }
      }

      return round( $amount );
   }
    #endregion

    #region CalculatePriceTicketOnePerson
    // When there is no fare
    public static function calculateFareForOnePersonCustomer( $price ) {
        $percentPublic       = self::percentPublic();
        $agency_commission   = round( ( $price - ( $price * ( 4573 / 100000 ) ) ) * ( $percentPublic ) );
        $supplier_commission = $price - $agency_commission;

        return $supplier_commission;
    }
    #endregion

    #region LongTimeFlightMinutes

    public static function CalculatePriceTicketOnePerson( $RequestNumber, $nationalCode, $FlagPriceChange = 'yes' ) {

        //yes means nesesary calculate  price changes
        $Model = Load::library( 'Model' );

        $Sql = "SELECT *  FROM book_local_tb WHERE (request_number='{$RequestNumber}' OR factor_number='{$RequestNumber}') AND (passenger_national_code='{$nationalCode}' OR passportNumber='{$nationalCode}')";

        $rec = $Model->load( $Sql );

        $amount      = 0;
        $everyAmount = '0';

        if ( strtolower( $rec['flight_type'] == 'system' ) ) {

           if ($rec['IsInternal'] == '1') {
               if ($rec['percent_discount'] > 0) {
                   $checkPrivate = ($rec['pid_private'] == '1') ? 'private' : 'public';

                   if ($checkPrivate == 'public') {

                       if (isset($rec['adt_price']) && $rec['adt_price'] != 0) {
                           $amount += $rec['adt_price'] - ($rec['system_flight_commission'] * ($rec['percent_discount'] / 100));
                       } else if (isset($rec['chd_price']) && $rec['chd_price'] != 0) {
                           $amount += $rec['chd_price'] - ($rec['system_flight_commission'] * ($rec['percent_discount'] / 100));
                       } else if (isset($rec['inf_price']) && $rec['inf_price'] != 0) {
                           $amount += $rec['inf_price'] - ($rec['system_flight_commission'] * ($rec['percent_discount'] / 100));
                       }
                   } elseif ($checkPrivate == 'private') {
                       $amount += $rec['adt_price'] - ($rec['adt_fare'] * ($rec['percent_discount'] / 100));
                       $amount += $rec['chd_price'] - ($rec['chd_fare'] * ($rec['percent_discount'] / 100));
                       $amount += $rec['inf_price'];
                   }
               } else {
                   $amount += $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];
               }
           }
           else {
               if ($rec['percent_discount'] > 0) {
                   $airlineModel = Load::getModel('airlineModel');
                   $airlineForCom = $airlineModel->get(['abbreviation','foreignAirline','amadeusStatus'], true)->where('abbreviation', $rec['airline_iata'])->all();
                   if (!isset($airlineForCom[0]['foreignAirline'])) {
                       $foreignAirline = null;
                   }
                   if ($airlineForCom[0]['foreignAirline'] == 'active' || $airlineForCom[0]['foreignAirline'] == null || empty($airlineForCom[0]['foreignAirline']) ) {
                       $foreignAirline = true;
                   } else {
                       $foreignAirline = false;
                   }

                   if (!$foreignAirline) {
                       if (isset($rec['adt_price']) && $rec['adt_price'] != 0) {
                           $rec['adt_price'] -= ($rec['system_flight_commission'] * ($rec['percent_discount'] / 100));
                       } else if (isset($rec['chd_price']) && $rec['chd_price'] != 0) {
                           $rec['chd_price'] -= ($rec['system_flight_commission'] * ($rec['percent_discount'] / 100));
                       } else if (isset($rec['inf_price']) && $rec['inf_price'] != 0) {
                           $rec['inf_price'] -= ($rec['system_flight_commission'] * ($rec['percent_discount'] / 100));
                       }
                   }

               }


               $everyAmount = $rec['api_commission'] + $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];

               if ($rec['price_change'] > 0 && $rec['price_change_type'] == 'percent') {
                   if($rec['IsInternal'] == '1' && $rec['api_id'] == '14'){
                       $everyAmountFake = $rec['api_commission'] + $rec['adt_fare'] + $rec['chd_fare'] + $rec['inf_fare'];
                   }else{

                       $everyAmountFake = $rec['api_commission'] + $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];
                   }
                   $ChangeAmount = $everyAmountFake * ($rec['price_change'] / 100);
                   $everyAmount += $ChangeAmount;
                   $amount += $everyAmount - (($ChangeAmount * $rec['percent_discount']) / 100);
               }
               else if ($rec['price_change'] > 0 && $rec['price_change_type'] == 'cost') {
                   $ChangeAmount = $rec['price_change'];
                   $everyAmount += $ChangeAmount;
                   $amount += $everyAmount - (($ChangeAmount * $rec['percent_discount']) / 100);
               }
               else {
                   $amount += $everyAmount;
               }
           }


        } else {
            $everyAmount = $rec['api_commission'] + $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];

            if ($rec['price_change'] > 0 && $rec['price_change_type'] == 'cost') {
                $everyAmount += $rec['irantech_commission'];
                $ChangeAmount = $rec['price_change'];
                $everyAmount += $ChangeAmount;
                if ($rec['passenger_age'] == 'Adt' || $rec['passenger_age'] == 'Chd') {
                    $amount += $everyAmount - (($ChangeAmount * $rec['percent_discount']) / 100);
                } else if ($rec['passenger_age'] == 'Inf') {
                    $amount += $everyAmount;
                }
            }
            elseif ($rec['price_change'] > 0 && $rec['price_change_type'] == 'percent') {
                $ChangeAmount = $everyAmount * ($rec['price_change'] / 100);
                $everyAmount += $ChangeAmount;
                $everyAmount += $rec['irantech_commission'];
                if ($rec['passenger_age'] == 'Adt' || $rec['passenger_age'] == 'Chd') {
                    $amount += $everyAmount - (($ChangeAmount * $rec['percent_discount']) / 100);
                } else if ($rec['passenger_age'] == 'Inf') {
                    $amount += $everyAmount;
                }
            }
            else {
                if ($rec['passenger_age'] == 'Adt' || $rec['passenger_age'] == 'Chd') {
                    $ChangeAmount = 0;
                    $everyAmount += $rec['irantech_commission'];
                    $amount += $everyAmount - (($ChangeAmount * $rec['percent_discount']) / 100);
                } else if ($rec['passenger_age'] == 'Inf') {
                    $everyAmount += $rec['irantech_commission'];
                    $amount += $everyAmount;
                }
            }
        }

        return round( $amount );
    }

    #endregion

    #region LongTimeFlightHours

    public static function LongTimeFlightMinutes( $param1, $param2 ) {
        $flight_route = new ModelBase();

        $sql = " SELECT   *  FROM flight_route_tb  WHERE Departure_Code='{$param1}' AND Arrival_Code='{$param2}'  ";

        $flight_route = $flight_route->load( $sql );

        if ( ! empty( $flight_route['TimeLongFlight'] ) ) {
            $explode_date = explode( ':', $flight_route['TimeLongFlight'] );

            $jmktime = dateTimeSetting::jmktime( $explode_date[0], $explode_date[1], $explode_date[2] );

            $Minutes_time = dateTimeSetting::jdate( "i", $jmktime, '', '', 'en' );

            return $Minutes_time;
        }
    }

    #endregion

    #region LongTimeFlightHours

    public static function LongTimeFlightHours( $param1, $param2 ) {
        $flight_route = new ModelBase();

        $sql = " SELECT   TimeLongFlight  FROM flight_route_tb  WHERE Departure_Code='{$param1}' AND Arrival_Code='{$param2}'  ";

        $flight_route = $flight_route->load( $sql );


        if ( ! empty( $flight_route['TimeLongFlight'] ) ) {
            $explode_date = explode( ':', $flight_route['TimeLongFlight'] );

            $jmktime = dateTimeSetting::jmktime( $explode_date[0], $explode_date[1], $explode_date[2] );

            $Data['Hour']    = dateTimeSetting::jdate( "H", $jmktime, '', '', 'en' );
            $Data['Minutes'] = dateTimeSetting::jdate( "i", $jmktime, '', '', 'en' );

            return $Data;
        } else {
            return functions::Xmlinformation( 'Unknown' );
        }
    }
    #endregion

    #region [convertDateFlight]


    /**
     * @param $param
     * @param string $mode
     * @return array|string
     */
    public static function convertDateFlight($param , $mode ='-') {
        $date_arrival = explode( 'T', $param );
        $gregorian_date  = explode( $mode, $date_arrival[0] );

        return dateTimeSetting::gregorian_to_jalali( $gregorian_date[0], $gregorian_date[1], $gregorian_date[2], '/' );
    }
    #endregion

    #region CalculateTotalPriceTicketCounter

    public static function InfoRoute( $Code ) {
        Load::autoload( 'ModelBase' );

        $ModelBase = new ModelBase();

        $Sql = " SELECT Departure_Code,Departure_City,Departure_CityEn FROM flight_route_tb WHERE Departure_Code='{$Code}'";

        return $ModelBase->load( $Sql );
    }
    #endregion


    #region country_code

    public static function TypeFlight( $RequestNumber ) {


        if ( TYPE_ADMIN == '1' ) {
            $Sql = "SELECT * FROM report_tb WHERE request_number='{$RequestNumber}'";
            Load::autoload( 'ModelBase' );
            $ModelBase = new ModelBase();
            $res       = $ModelBase->load( $Sql );
        } else {
            $Sql = "SELECT * FROM book_local_tb WHERE request_number='{$RequestNumber}'";
            Load::autoload( 'Model' );
            $Model = new Model();
            $res   = $Model->load( $Sql );
        }


        if ( $res['flight_type'] == 'charter' ) {
            return 'charter';

        } else if ( $res['flight_type'] == 'system' && $res['pid_private'] == '1' ) {
            return 'PrivateSystem';

        } else if ( $res['flight_type'] == 'system' && $res['pid_private'] == '0' ) {
            return 'PublicSystem';

        } else if ( $res['type_app'] == 'reservation' ) {
            return 'reservation';
        }

    }

    #endregion

    #region CalculateForOnePersonWithOutDiscount

    public static function country_code( $Code, $type ) {
        Load::autoload( 'ModelBase' );
        $ModelBase = new ModelBase();


        $Sql = "SELECT * FROM country_codes_tb WHERE code='{$Code}'";
        $res = $ModelBase->load( $Sql );


        if ( $type == 'fa' ) {
            return $res['titleFa'];
        } else if ( $type == 'en' ) {
            return $res['titleEn'];
        }


    }

    #endregion

    #region LogLoginAdmin

    public static function CalculateForOnePersonWithOutDiscount(
        $RequestNumber, $nationalCode, $FlagPriceChange = 'yes'
    ) {

        //yes means nesesary calculate  price changes
        Load::autoload( 'ModelBase' );
        $modelBase = new ModelBase();

        $Sql = "SELECT * FROM report_tb WHERE request_number='{$RequestNumber}' AND (passenger_national_code='{$nationalCode}' OR passportNumber='{$nationalCode}')";

        $rec = $modelBase->load( $Sql );


        $amount = 0;
        //در هر رکورد فقط یکی از قیمت ها با توجه به سن مقدار دارد و دوتای دیگر صفر هستند
        if ( strtolower( $rec['flight_type'] ) == 'system' ) {
            $amount = $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];
        } else {
            $everyAmount = $rec['api_commission'] + $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];

            //تغییرات قیمت فقط برای چارتری
            if ( $rec['flight_type'] == 'charter' ) {
                if ( $rec['price_change'] > 0 && $rec['price_change_type'] == 'percent' ) {
                    $everyAmount += $everyAmount * ( $rec['price_change'] / 100 );
                    $amount      = $everyAmount;
                } elseif ( $rec['price_change'] > 0 && $rec['price_change_type'] == 'cost' ) {
                    $everyAmount += $rec['price_change'];
                    $amount      = $everyAmount;
                } else {
                    $amount = $everyAmount;
                }
            } else {
                $amount = $everyAmount;
            }

        }

        return round( $amount );
    }
    #endregion

    #region CalculateChargeAdminAgency

    public static function CalculateBonusAmount( $score ) {

        if ( $score > 0 ) {
            return ceil( ( $score * 1000 ) );

        } else {
            return '0';

        }


    }

    #endregion

    #region CalculateChargeAdminAgency

    public static function CalculateChargeAdminAgency( $ClientID ) {
        $time         = time() - ( 600 );
        $admin        = Load::controller( 'admin' );
        $sql_charge   = "SELECT sum(Price) AS total_charge FROM transaction_tb WHERE Status='1'";
        $charge       = $admin->ConectDbClient( $sql_charge, $ClientID, "Select", "", "", "" );
        $total_charge = $charge['total_charge'];

        $sql_buy   = "SELECT SUM(Price) AS total_buy FROM transaction_tb WHERE Status='2' AND" . " ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')) ";
        $buy       = $admin->ConectDbClient( $sql_buy, $ClientID, "Select", "", "", "" );
        $total_buy = $buy['total_buy'];

        $TotalCharge = $total_charge - $total_buy;

        return $TotalCharge;
    }

    #endregion

    #region encryptPassword

    public static function encryptPassword( $password ) {
        return hash( 'sha512', 'sd45sv#FEgfe@%&*4RG656Sssd5' . $password . '4sF7s85fEW' );
    }
    #endregion

    #region CalculatePriceApi

    public static function CalculatePriceApi(
        $ClientId, $Price, $FlightType, $TypTicket, $Airline, $ISLogin, $MemberId = null
    ) {
        $FlightType = ( strtolower( $FlightType ) == 'system' ) ? 'system' : 'charter';

        $Price = self::convert_toman_rial( $Price, $FlightType );
        if ( $ISLogin && ! empty( $MemberId ) ) {
            $UserInfo  = functions::infoMember( $MemberId, $ClientId );
            $CounterId = $UserInfo['fk_counter_type_id'];
        } else {
            $CounterId = '5';
        }
        $checkPrivate = functions::checkConfigPid( $Airline );


        $CalculatePriceChange = self::getAmountChangePrice( $CounterId, $Airline, 'local' );

        if ( ! empty( $CalculatePriceChange ) && $FlightType == 'charter' ) {
            if ( $CalculatePriceChange['changeType'] == 'cost' ) {
                $Price += $CalculatePriceChange['price'];
            } else {
                $Price += $Price * ( $CalculatePriceChange['price'] / 100 );
            }
        }
        if ( $ISLogin ) {

            $TypeService = self::TypeService( $FlightType, 'Local', $TypTicket, $checkPrivate, $Airline );

            $Discount = self::ServiceDiscount( $CounterId, $TypeService );

            if ( $Discount['off_percent'] > 0 ) {
                $Price = round( $Price - ( ( $Price * $Discount['off_percent'] ) / 100 ) );

            }

            return $Price;

        } else {
            return $Price;
        }


    }
    #endregion

    #region convert_toman_rial

    public static function convert_toman_rial( $price, $type = null ) {
        return $price * 10;
    }
    #endregion
    #region convert_rial_toman

    public static function convert_rial_toman( $price, $type = null ) {
        return $price / 10;
    }
    #endregion
    #region NameCityApi

    public static function getAmountChangePrice( $counterId, $airline, $locality ) {
        /** @var priceChanges $PriceChangesController */
        $PriceChangesController = Load::controller( 'priceChanges' );
        return $PriceChangesController->getChangePriceByCounterAndAirline( $counterId, $airline, $locality );
    }
    #endregion

    #region checkRegisterGuest

    //todo:Check why typeTicket is used in this function, while CheckPrivate exists
    public static function TypeService( $FlightType, $TypeZone, $TypeTicket, $checkPrivate = null, $airline = null ) {
        $TypeService = '';


        if ($FlightType == 'charter') {
            if ($TypeTicket == 'public' && $TypeZone == 'Local') {
                $TypeService = 'PublicLocalCharter';
            } elseif ($TypeTicket == 'public' && $TypeZone == 'Portal') {
                $TypeService = 'PublicPortalCharter';
            } elseif ($TypeTicket == 'private' && $TypeZone == 'Local') {
                $TypeService = 'PrivateLocalCharter';
            } elseif ($TypeTicket == 'private' && $TypeZone == 'Portal') {
                $TypeService = 'PrivatePortalCharter';
            }
        } elseif ($FlightType == 'system') {
            if ($checkPrivate == 'public' && $TypeZone == 'Local') {
                $TypeService = 'PublicLocalSystem';
            } elseif ($checkPrivate == 'private' && $TypeZone == 'Local') {
                $TypeService = 'PrivateLocalSystem';
            } elseif ($checkPrivate == 'public' && $TypeZone == 'Portal') {
                $TypeService = 'PublicPortalSystem';
            } elseif ($checkPrivate == 'private' && $TypeZone == 'Portal') {
                $TypeService = 'PrivatePortalSystem';
            }
        }

        return $TypeService;
    }
    #endregion

    #region type_passengers

    public static function ServiceDiscount( $CounterId, $TitleServiceDiscount ) {
        /** @var servicesDiscount $ServiceDiscount */
        $ServiceDiscount = Load::controller( 'servicesDiscount' );
        return $ServiceDiscount->getDiscountByCounterAndService( $CounterId, $TitleServiceDiscount );
    }
    #endregion

    #region type_title

    public static function NameCityApi( $param ) {

        $select_airport = new ModelBase();

        $sql = " SELECT DISTINCT  Departure_City FROM flight_route_tb WHERE Departure_Code='{$param}'  ";


        $arival_city = $select_airport->load( $sql );

        return $arival_city['Departure_City'];
    }
    #endregion

    #region ShowError

    public static function checkRegisterGuest( $Email, $Pass, $Mobile, $ClientId ) {
        $admin            = Load::controller( 'admin' );
        $sqlTypeCounter   = "SELECT * FROM members_tb WHERE email='{$Email}' AND password='{$Pass}' AND mobile='{$Mobile}'";
        $InfoMembersGuest = $admin->ConectDbClient( $sqlTypeCounter, $ClientId, "Select" );


        if ( ! empty( $InfoMembersGuest ) ) {
            return true;
        } else {
            return false;
        }
    }
    #endregionTrain


    #region ShowErrorTrain

    public static function type_passengers( $birthday ) {

        $date_two    = date( "Y-m-d", strtotime( "-2 year" ) );
        $date_twelve = date( "Y-m-d", strtotime( "-12 year" ) );
        if ( strcmp( $birthday, $date_two ) > 0 ) {
            return "Inf";
        } elseif ( strcmp( $birthday, $date_two ) <= 0 && strcmp( $birthday, $date_twelve ) > 0 ) {
            return "Chd";
        } else {
            return "Adt";
        }
    }
    #endregion

    #region NameCity

    public static function type_title( $title, $type ) {

        if ( $type == "Adt" ) {
            if ( $title == 'Male' ) {
                return 'MR';
            } else if ( $title == 'Female' ) {
                return 'MS';
            }
        } else if ( $type == "Chd" || $type == "Inf" ) {
            if ( $title == 'Male' ) {
                return 'MSTR';
            } else if ( $title == 'Female' ) {
                return 'MISS';
            }
        }
    }
    #endregion

    #region NameCityForeign

    public static function ShowError( $message ) {

        switch ( $message ) {
            case "AdultCountIsInvalid":
                return functions::Xmlinformation( 'AdultCountIsInvalid' );
                break;
            case "LowCapacity":
                return functions::Xmlinformation( 'LowCapacity' );
                break;
            case "SessionIDTerminated":
                return functions::Xmlinformation( 'SessionIDTerminated' );
                break;
            case "ProviderDown":
                return functions::Xmlinformation( 'ProviderDown' );
                break;
            case "ProviderTimeOut":
                return functions::Xmlinformation( 'ProviderTimeOut' );
                break;
            case "Error":
                return functions::Xmlinformation( 'Error' );
                break;
            case "UnSuccessful":
                return functions::Xmlinformation( 'UnSuccessful' );
                break;

            case "FlightIsNotInTheList":
                return functions::Xmlinformation( 'FlightIsNotInTheList' );
                break;

            case "NewRequestError":
                return functions::Xmlinformation( 'AdultCountIsInvalid' );
                break;

            case "ErrorInEditRequest":
                return functions::Xmlinformation( 'ErrorInEditRequest' );
                break;

            case "FlightIsFull":
                return functions::Xmlinformation( 'FlightIsFull' );
                break;

            case "HttpError":
                return functions::Xmlinformation( 'HttpError' );
                break;

            case "NoCapacity":
                return functions::Xmlinformation( 'NoCapacity' );
                break;

            case "DuplicatePassengerName":
                return functions::Xmlinformation( 'DuplicatePassengerName' );
                break;

            case "PersianFirstNameAndLastNameIsRequired":
                return functions::Xmlinformation( 'PersianFirstNameAndLastNameIsRequired' );
                break;

            case "PersianFirstNameOrLastNameIsNonPersian":
                return functions::Xmlinformation( 'PersianFirstNameOrLastNameIsNonPersian' );
                break;

            case "EnglishFirstNameOrLastNameIsNonEnglish":
                return functions::Xmlinformation( 'EnglishFirstNameOrLastNameIsNonEnglish' );
                break;

            case "EnglishFirstNameAndLastNameIsRequired":
                return functions::Xmlinformation( 'EnglishFirstNameAndLastNameIsRequired' );
                break;

            case "DateOfBirthIsRequired":
                return functions::Xmlinformation( 'DateOfBirthIsRequired' );
                break;

            case "DateOfBirthIsInvalid":
                return functions::Xmlinformation( 'DateOfBirthIsInvalid' );
                break;

            case "ChildAgeIsBiggerThan12":
                return functions::Xmlinformation( 'ChildAgeIsBiggerThan12' );
                break;

            case "InfantAgeIsBiggerThan2":
                return functions::Xmlinformation( 'InfantAgeIsBiggerThan2' );
                break;

            case "NationalCodeIsRequired":
                return functions::Xmlinformation( 'NationalCodeIsRequired' );
                break;

            case "PassportNumberIsRequired":
                return functions::Xmlinformation( 'PassportNumberIsRequired' );
                break;

            case "PassportExpiryDateIsInvalid":
                return functions::Xmlinformation( 'PassportExpiryDateIsInvalid' );
                break;

            case "InvalidPassportNumber":
                return functions::Xmlinformation( 'InvalidPassportNumber' );
                break;

            case "InvalidPassportExpiryDate":
                return functions::Xmlinformation( 'InvalidPassportExpiryDate' );
                break;

            case "InvalidNationalCode":
                return functions::Xmlinformation( 'InvalidNationalCode' );
                break;

            case "NameHasSpace":
                return functions::Xmlinformation( 'NameHasSpace' );
                break;

            case "NameIsInvalid":
                return functions::Xmlinformation( 'NameIsInvalid' );
                break;

            case "InvalidDateOfBirth":
                return functions::Xmlinformation( 'InvalidDateOfBirth' );
                break;

            case "InvalidMobileNumber":
                return functions::Xmlinformation( 'InvalidMobileNumber' );
                break;

            case "InvalidEmail":
                return functions::Xmlinformation( 'InvalidEmail' );
                break;

            case "InvalidPassengerName":
                return functions::Xmlinformation( 'InvalidPassengerName' );
                break;

            case "TryLater":
                returnfunctions::Xmlinformation( 'TryLater' );
                break;

            case "PIDStoped":
                return functions::Xmlinformation( 'PIDStoped' );
                break;

            case "ServerError":
                return functions::Xmlinformation( 'ServerError' );
                break;

            case "PriceChanged":
                return functions::Xmlinformation( 'PriceChanged' );
                break;

            case "UnableIssueTicket":
                return functions::Xmlinformation( 'UnableIssueTicket' );
                break;

            case "RequestNumberTerminated":
                return functions::Xmlinformation( 'RequestNumberTerminated' );
                break;
            case "Passport ID Is Incorrect":
                return functions::Xmlinformation( 'PassportIDIsIncorrect' );
                break;
            case "TimeExpired":
                return functions::Xmlinformation( 'TimeExpired' );
                break;
            case "Repetitive Passenger In This Flight ":
                return functions::Xmlinformation( 'RepetitivePassengerInThisFlight' );
                break;
            case '10122':
                return functions::Xmlinformation( 'InvalidSubmissionDate' );
                break;
            case '10131':
                return functions::Xmlinformation( 'InvalidRequestSubmitted' );
                break;
            case '10201':
                return functions::Xmlinformation( 'ContactyourBackupForSystemError' );
                break;
            case '-203':
                return functions::Xmlinformation( 'InvalidDte' );
                break;
            case '-2':
                return functions::Xmlinformation( 'ErrorSubmittingRequest' );
                break;
            case '-202':
                return functions::Xmlinformation( 'InvalidOriginOrDestination' );
                break;
            case '10150':
                return functions::Xmlinformation( 'InvalidBirthDate' );
                break;
            case '1':
                return functions::Xmlinformation( 'TicketPricesHaveChangedByAirline' );
                break;
            case '10207':
                return functions::Xmlinformation( 'TheTicketInQuestionCannotBeBooked' );
                break;
            case '10202':
                return functions::Xmlinformation( 'TheDesiredFlightCapacityIsNotFilledOrTheFlightIsNotAvailable' );
                break;
            case '10142':
                return functions::Xmlinformation( 'ContactUnsupportedReservation' );
                break;
            case '10226':
                return functions::Xmlinformation( 'TheTimeOrFlightDateYouSelectedHasChanged' );
                break;
            case '10167':
                return functions::Xmlinformation( 'YourpassengersInformationIsAlready' );
                break;
            case '10216':
                return functions::Xmlinformation( 'TheFlightCapacityIsFilled' );
                break;
            case '10151':
                return functions::Xmlinformation( 'TheTateOfBirthOrTypeOfpassengerIsIncorrect' );
                break;
            case '10152':
                return functions::Xmlinformation( 'WrongPassengerNameOrSurname' );
                break;
            case '10155':
                return functions::Xmlinformation( 'WrongNationalTravelerCode' );
                break;
            case '10170':
                return functions::Xmlinformation( 'PassportIDIsIncorrect' );
                break;
            case '10107':
                return functions::Xmlinformation( 'TheEmailyouEnteredisnotvalid' );
                break;
            case '-3':
                return functions::Xmlinformation( 'ErrorSubmittingRequest' );
                break;
            case '10171':
                return functions::Xmlinformation( 'ThePassportExpirationDateIsIncorrect' );
                break;
            case '-305':
                return functions::Xmlinformation( 'FlightNotFound' );
                break;
            case '-402':
                return functions::Xmlinformation( 'TheSecurityCodeEnteredIsIncorrect' );
                break;
            case '-403':
                return functions::Xmlinformation( 'TheEmailYouEnteredIsNotValid' );
                break;
            case '-404':
                return functions::Xmlinformation( 'TheEnteredMobileNumberIsInvalid' );
                break;
            case '-405':
                return functions::Xmlinformation( 'TheNumberOfpassengersIsInvalid' );
                break;
            case '-408':
                return functions::Xmlinformation( 'YourRequestHasExpired' );
                break;
            case '-409':
                return functions::Xmlinformation( 'TheDesiredFlightDateHasChanged' );
                break;
            case '-410':
                return functions::Xmlinformation( 'TheDesiredFlightTimeHasChanged' );
                break;
            case '-411':
                return functions::Xmlinformation( 'TheSecurityCodeEnteredIsIncorrect' );
                break;
            case '-412':
                return functions::Xmlinformation( 'TypePassengersIsInvalid' );
                break;
            case '-413':
                return functions::Xmlinformation( 'TypePassengersIsInvalid' );
                break;
            case '-414':
                return functions::Xmlinformation( 'LatinFullNamePassengerIsInvalid' );
                break;
            case '-415':
                return functions::Xmlinformation( 'PersianFullNamePassengerIsInvalid' );
                break;
            case '-416':
                return functions::Xmlinformation( 'GenderPassengersIsInvalid' );
                break;
            case '-417':
                return functions::Xmlinformation( 'WrongNationalTravelerCode' );
                break;
            case '-418':
                return functions::Xmlinformation( 'WrongNationalTravelerCode' );
                break;
            case '-419':
                return functions::Xmlinformation( 'NationalityPassengersIsInvalid' );
                break;
            case '-420':
                return functions::Xmlinformation( 'ThePassportExpirationDateIsIncorrect' );
                break;
            case '-421':
                return functions::Xmlinformation( 'BirthAdultPassengersEnteredNotCorrect' );
                break;
            case '-422':
                return functions::Xmlinformation( 'BirthChildPassengersEnteredNotCorrect' );
                break;
            case '-423':
                return functions::Xmlinformation( 'BirthInfantPassengersEnteredNotCorrect' );
                break;
            case '-424':
                return functions::Xmlinformation( 'BirthEnteredNotCorrect' );
                break;
            case '-458':
                return functions::Xmlinformation( 'TheSecurityCodeEnteredIsIncorrect' );
                break;
            case '-777':
                return functions::Xmlinformation( 'ChangePriceFlight' );
                break;
            case '10157':
                return functions::Xmlinformation( 'Invalidemail' );
                break;
            case 'ERROR111':
                return functions::Xmlinformation( 'ErrorSystemFlight' );
                break;
            case '10000777':
                return functions::Xmlinformation( 'reloadAirline' );
                break;
            case '909090':
                return functions::Xmlinformation( 'ChangePriceFlight' );
                break;
            case '-506':
                return functions::Xmlinformation( 'NotSuccessBuy' );
                break;
            case '10175':
                return functions::Xmlinformation( 'WrongNationalTravelerCode' );
                break;
                case '10175':
                return functions::Xmlinformation( 'WrongNationalTravelerCode' );
                break;
            default:
                return functions::Xmlinformation( 'ErrorSystemFlightGds' );
        }
    }
    #endregion

    #region ShowHotelError

    public static function ShowHotelError( $message ) {

        switch ( $message ) {
            case "Bk-406":
            case "HotelReserve-406":
                return functions::Xmlinformation( 'RequestDoneBefore' );
                break;
            case "BK-001":
            case "HotelReserve-001":
                return functions::Xmlinformation( 'RequestNumberIsRequired' );
                break;
            case "BK-002":
            case "HotelReserve-002":
                return functions::Xmlinformation( 'PriceSessionIdIsRequired' );
                break;
            case "Book-005":
                return functions::Xmlinformation( 'RoomsIsRequired' );
                break;
            case "Bk-400":
            case "HotelReserve-400":
                return functions::Xmlinformation( 'InvalidRequest' );
                break;
            case "BK-410":
                return functions::Xmlinformation( 'providerError' );
                break;
            case "BK-420":
                return functions::Xmlinformation( 'ReserveRoomCapacity' );
                break;

            case "BK-421":
                return functions::Xmlinformation( 'ReserveRoomWithoutRate' );
                break;

            case "BK-422":
                return functions::Xmlinformation( 'RatePlanNotExists' );
                break;

            case "BK-423":
                return functions::Xmlinformation( 'PropertyNotExists' );
                break;

            case "BK-424":
                return functions::Xmlinformation( 'RoomTypeNotExists' );
                break;

            case "Reserve-0013":
                return functions::Xmlinformation( 'RequestNumberIncorrectOrExpired' );
                break;

            case "Auth001":
                return functions::Xmlinformation( 'UsernameOrPasswordIsNotValid' );
                break;

            case "Auth002":
                return functions::Xmlinformation( 'Unauthenticated' );
                break;

            case "Source001":
                return functions::Xmlinformation( 'UnexpectedError' );
                break;

            case "Err10001":
            case "Reserve-408":
                return functions::Xmlinformation( 'RequestTimeout' );
                break;

            case "Err10002":
                return functions::Xmlinformation( 'WrongRequestParams' );
                break;

            case "Err10003":
                return functions::Xmlinformation( 'ReserveError' );
                break;

            case "Err404":
                return functions::Xmlinformation( 'NotFound' );
                break;

            case "Err0121001":
            case "Err0122002":
                return functions::Xmlinformation( 'InvalidFareSourceCode' );
                break;

            case "Err0121002":
                return functions::Xmlinformation( 'NotAvailableRoom' );
                break;

            case "Err0122005":
                return functions::Xmlinformation( 'NotCompatiblePassengerCount' );
                break;

            case "Err0122006":
                return functions::Xmlinformation( 'InvalidPassengerType' );
                break;

            case "Err0122007":
                return functions::Xmlinformation( 'PleaseenterPhoneNumber' );
                break;

            case "Err0122008":
                return functions::Xmlinformation( 'ForceHotelRooms' );
                break;

            case "Err0122009":
                return functions::Xmlinformation( 'ForcePassenger' );
                break;

            case "Err0122010":
                return functions::Xmlinformation( 'ForcePassengerName' );
                break;

            case "Err0122011":
                return functions::Xmlinformation( 'PriceChanged' );
                break;

            case "Err0122013":
                return functions::Xmlinformation( 'HotelRoomsSoldOut' );
                break;

            case "Err0122014":
                return functions::Xmlinformation( 'InvalidPassengerName' );
                break;

            case "Err0121004":
                return functions::Xmlinformation( 'CheckRate' );
                break;
            case "BK-425":
                return functions::Xmlinformation( 'RejectedRoom' );
                break;
            case "BK-426":
                return functions::Xmlinformation( 'NotEnoughCredit' );
                break;
            default:
                return functions::Xmlinformation( 'ErrorSystemHotelsGds' );
        }
    }
    #endregion

    #region InfoFlight

    public static function ShowErrorTrain( $code ) {

        switch ( $code ) {
            case 401:
                return 'توکن استفاده از وب سرویس های فروش منقضی شده است ';
                break;
            case 405:
                return 'دسترسی شما به این وب سرویس مجاز نیست ';
                break;
            case 504:
                return 'زمان استفاده شما از سیستم به پایان رسیده است';
                break;
            case 408:
                return 'کلید دسترسی برای کد فروشنده ارسالی مجاز نمی باشد';
                break;
            case 409:
                return 'کلید دسترسی شما برای آی پی شما مجاز نمی باشد';
                break;
            default:
                return 'مشکل غیر منتظره رخداده است';
        }
    }
    #endregion

    #region NameCity

    //TODO: after use CityInternal  deleted
    public static function NameCity( $param ) {

        $modelBase = Load::library( 'ModelBase' );

        $sql = " SELECT DISTINCT  Departure_City,Departure_CityEn FROM flight_route_tb WHERE Departure_Code='{$param}'  ";


        $arrival_city = $modelBase->load( $sql );

        return $arrival_city['Departure_City'];
    }
    #endregion

    #region CityInternal

    public static function CityInternal( $param ) {
        $modelBase = Load::library( 'ModelBase' );
        $sql       = " SELECT DISTINCT  Departure_City,Departure_CityEn, Departure_City as Departure_CityFa FROM flight_route_tb WHERE Departure_Code='{$param}'  ";

        return $modelBase->load( $sql );
    }
    #endregion
    #region CityForeign
    public static function CityForeign( $param ) {
        $modelBase = Load::library( 'ModelBase' );
        $sql       = " SELECT  * FROM flight_portal_tb WHERE DepartureCode='{$param}'";

        return $modelBase->load( $sql );
    }
    #endregion
    #region Calculate discount API

    public static function NameCityForeign( $param ) {
//		$param = ( $param == 'IST' ) ? 'ISL' : $param;
        $param = ( $param == 'THR' ) ? 'IKA' : $param;

        $select_airport = Load::library( 'ModelBase' );

        $sql = " SELECT * FROM flight_portal_tb WHERE DepartureCode='{$param}'  ";

        return $select_airport->load( $sql );

    }
    #endregion

    #region Call Method Minimum Price in Date

    public static function InfoFlight( $requestNumber ) {

        Load::autoload( 'ModelBase' );

        $ModelBase = new ModelBase();

        $SqlFlight = "SELECT * , COUNT(id) as Count_id  FROM report_tb WHERE request_number='{$requestNumber}'";

        $ResultFlight = $ModelBase->load( $SqlFlight );


        return $ResultFlight;

    }
    #endregion

    #region Show Minimum Price in Date

    public static function TotalPrice( $RequestNumber, $FlagPriceChange = 'yes', $calculat = null ) {
        //yes means nesesary calculate  price changes
        $model = Load::model( 'book_local' );
        $rec   = $model->getWithCategory( $RequestNumber );

        $amount = 0;
        foreach ( $rec as $each ) {

            //در هر رکورد فقط یکی از قیمت ها با توجه به سن مقدار دارد و دوتای دیگر صفر هستند
            if ( $each['flight_type'] == 'system' ) {
                $amount += $each['adt_price'] + $each['chd_price'] + $each['inf_price'];
            } else {
                $amount += $each['api_commission'] + $each['adt_price'] + $each['chd_price'] + $each['inf_price'];

                if ( $FlagPriceChange == "yes" ) {
                    //تغییرات قیمت فقط برای چارتری
                    if ( $each['flight_type'] == 'charter' ) {
                        if ( $each['price_change'] > 0 && $each['price_change_type'] == 'increase' ) {
                            $amount += $each['price_change'];
                        } elseif ( $each['price_change'] > 0 && $each['price_change_type'] == 'decrease' ) {
                            $amount -= $each['price_change'];
                        }
                    }
                }
            }
        }

        return $amount;
    }
    #endregion

    #region Minimum Price

    public static function CalculateDiscountForBankAPI( $RequestNumber, $ClientId, $FlagPriceChange = 'yes' ) {
        //yes means nesesary calculate  price changes
        $model = Load::model( 'book_local' );
        $rec   = $model->getWithCategory( $RequestNumber );


        $memberId = $rec[0]['member_id'];
        $user     = functions::infoMember( $memberId, $ClientId );
        $Counter  = functions::infoCounterType( $user['fk_counter_type_id'] );

        $isInternal = ( $rec[0]['isInternal'] == '1' ) ? 'internal' : 'external';

        if ( $user['is_member'] == '1' ) {
            $IsLogin = true;
        } else {
            $IsLogin = false;
        }


        $amount = 0;
        foreach ( $rec as $each ) {
            //در هر رکورد فقط یکی از قیمت ها با توجه به سن مقدار دارد و دوتای دیگر صفر هستند
            if ( $each['flight_type'] == 'system' ) {
                $checkConfigPid = functions::checkConfigPid( $each['airline_iata'], $isInternal, $each['flight_type'],$each['api_id']);
                if ( $IsLogin ) {
                    if ( $Counter['discount_system_private'] > 0 && $checkConfigPid == 'private' && $each['flight_type'] == "system" ) {
                        $amount += ( $each['adt_price'] - ( ( $each['adt_price'] * $Counter['discount_system_private'] ) / 100 ) ) + ( $each['chd_price'] - ( ( $each['chd_price'] * $Counter['discount_system_private'] ) / 100 ) ) + $each['inf_price'];

                    } else if ( $Counter['discount_system_public'] > 0 && $checkConfigPid == 'public' && $each['flight_type'] == "system" ) {
                        $amount += ( $each['adt_price'] - ( ( $each['adt_price'] * $Counter['discount_system_public'] ) / 100 ) ) + ( $each['chd_price'] - ( ( $each['chd_price'] * $Counter['discount_system_public'] ) / 100 ) ) + $each['inf_price'];
                    } else {
                        $amount += $each['adt_price'] + $each['chd_price'] + $each['inf_price'];
                    }
                } else {
                    $amount += $each['adt_price'] + $each['chd_price'] + $each['inf_price'];
                }
                //                $amount += $each['adt_price'] + $each['chd_price'] + $each['inf_price'];
            } else {
                //                $amount += $each['api_commission'] + $each['adt_price'] + $each['chd_price'] + $each['inf_price'];
                $everyAmount = $each['api_commission'] + $each['adt_price'] + $each['chd_price'] + $each['inf_price'];

                if ( $FlagPriceChange == "yes" ) {
                    //تغییرات قیمت فقط برای چارتری
                    if ( $each['flight_type'] == 'charter' ) {

                        //$amount += $each['api_commission'] + $each['adt_price'] + $each['chd_price'] + $each['inf_price'] ;

                        if ( $each['price_change'] > 0 && $each['price_change_type'] == 'increase' ) {
                            if ( $IsLogin ) {
                                $everyAmount += $each['price_change'];
                                if ( $each['passenger_age'] == 'Adt' || $each['passenger_age'] == 'Chd' ) {
                                    $amount += $everyAmount - ( ( $everyAmount * $Counter['discount_charter'] ) / 100 );

                                } else if ( $each['passenger_age'] == 'Inf' ) {
                                    $amount += $everyAmount;
                                }
                            } else {

                                $amount += $everyAmount + $each['price_change'];
                            }
                            //                            $amount += $each['price_change'];
                        } elseif ( $each['price_change'] > 0 && $each['price_change_type'] == 'decrease' ) {
                            //                            $amount -= $each['price_change'];
                            if ( $IsLogin ) {
                                $everyAmount -= $each['price_change'];
                                if ( $each['passenger_age'] == 'Adt' || $each['passenger_age'] == 'Chd' ) {
                                    $amount += $everyAmount - ( ( $everyAmount * $Counter['discount_charter'] ) / 100 );

                                } else if ( $each['passenger_age'] == 'Inf' ) {
                                    $amount += $everyAmount;
                                }
                            } else {

                                $amount += $everyAmount - $each['price_change'];
                            }
                        } else {
                            if ( $IsLogin ) {

                                if ( $each['passenger_age'] == 'Adt' || $each['passenger_age'] == 'Chd' ) {

                                    $amount += $everyAmount - ( ( $everyAmount * $Counter['discount_charter'] ) / 100 );
                                } else if ( $each['passenger_age'] == 'Inf' ) {
                                    $amount += $everyAmount;
                                }

                            } else {
                                $amount += $everyAmount;
                            }
                        }
                    }
                } else {
                    if ( $IsLogin ) {

                        if ( $each['passenger_age'] == 'Adt' || $each['passenger_age'] == 'Chd' ) {
                            $amount += $everyAmount - ( ( $everyAmount * $Counter['discount_charter'] ) / 100 );
                        } else if ( $each['passenger_age'] == 'Inf' ) {
                            $amount += $everyAmount;
                        }
                    } else {
                        $amount += $everyAmount;
                    }
                }
            }
        }

        return round( $amount );
    }
    #endregion

    #region list airline

    public static function ShowContentMinimumPrice(
        $Departure_Code, $Arrival_Code, $dateRequest, $adult, $child, $infant, $typeSelect = 'Next'
    ) {
        $dateArray = explode( '-', $dateRequest );

        if ( $dateArray[0] > 1450 ) {
            $DateTodayInt = mktime( '0', '0', '0', $dateArray[1], $dateArray[2], $dateArray[0] );

            $CurrentDate        = date( "Y-m-d", time() );
            $CurrentDateExplode = explode( '-', $CurrentDate );

            $CurrentDateInt = mktime( '0', '0', '0', $CurrentDateExplode[1], $CurrentDateExplode[2], $CurrentDateExplode[0] );
            if ( $CurrentDateInt == $DateTodayInt ) {
                $MktTimeStart = ( mktime( '0', '0', '0', $CurrentDateExplode[1], $CurrentDateExplode[2], $CurrentDateExplode[0] ) );
                $MktTimeEnd   = ( mktime( '0', '0', '0', $dateArray[1], $dateArray[2], $dateArray[0] ) + ( 5 * 24 * 60 * 60 ) );
            } else {
                if ( $typeSelect == 'Next' ) {
                    $MktTimeStart = ( mktime( '0', '0', '0', $dateArray[1], $dateArray[2], $dateArray[0] ) - ( 1 * 24 * 60 * 60 ) );
                    $MktTimeEnd   = ( mktime( '0', '0', '0', $dateArray[1], $dateArray[2], $dateArray[0] ) + ( 4 * 24 * 60 * 60 ) );
                } else {
                    $MktTimeStart = ( mktime( '0', '0', '0', $dateArray[1], $dateArray[2], $dateArray[0] ) - ( 5 * 24 * 60 * 60 ) );
                    $MktTimeEnd   = ( mktime( '0', '0', '0', $dateArray[1], $dateArray[2], $dateArray[0] ) );
                }

            }
        } else {
            if ( ! empty( $dateArray ) ) {
                $DateTodayInt = dateTimeSetting::jmktime( '0', '0', '0', $dateArray[1], $dateArray[2], $dateArray[0] );
            }

            $CurrentDate        = dateTimeSetting::jdate( "Y-m-d", time() );
            $CurrentDateExplode = explode( '-', $CurrentDate );

            $CurrentDateInt = dateTimeSetting::jmktime( '0', '0', '0', $CurrentDateExplode[1], $CurrentDateExplode[2], $CurrentDateExplode[0] );
            if ( $CurrentDateInt == $DateTodayInt ) {
                $MktTimeStart = ( dateTimeSetting::jmktime( '0', '0', '0', $CurrentDateExplode[1], $CurrentDateExplode[2], $CurrentDateExplode[0] ) );
                $MktTimeEnd   = ( dateTimeSetting::jmktime( '0', '0', '0', $dateArray[1], $dateArray[2], $dateArray[0] ) + ( 5 * 24 * 60 * 60 ) );
            } else {
                if ( $typeSelect == 'Next' ) {
                    $MktTimeStart = ( dateTimeSetting::jmktime( '0', '0', '0', $dateArray[1], $dateArray[2], $dateArray[0] ) - ( 1 * 24 * 60 * 60 ) );
                    $MktTimeEnd   = ( dateTimeSetting::jmktime( '0', '0', '0', $dateArray[1], $dateArray[2], $dateArray[0] ) + ( 4 * 24 * 60 * 60 ) );
                } else {
                    $MktTimeStart = ( dateTimeSetting::jmktime( '0', '0', '0', $dateArray[1], $dateArray[2], $dateArray[0] ) - ( 5 * 24 * 60 * 60 ) );
                    $MktTimeEnd   = ( dateTimeSetting::jmktime( '0', '0', '0', $dateArray[1], $dateArray[2], $dateArray[0] ) );
                }
            }
        }


        $DateCalculatedStart = dateTimeSetting::jdate( "Y-m-d", $MktTimeStart, '', '', 'en' );
        $DateCalculatedEnd   = dateTimeSetting::jdate( "Y-m-d", $MktTimeEnd, '', '', 'en' );


        $MinimumPrice = self::MinimumPriceInDate( $Departure_Code, $Arrival_Code, $DateCalculatedStart, $DateCalculatedEnd );

        $ResultApiNew = array();

        if ( empty( $MinimumPrice['CalendarRoute'] ) ) {
            $MinimumPrice['CalendarRoute'] = array();
        }
        foreach ( $MinimumPrice['CalendarRoute'] as $Api ) :

            $keyDate                  = str_replace( '/', '-', $Api['PersianDepartureDate'] );
            $ResultApiNew[ $keyDate ] = $Api;

        endforeach;

        $PersianDepartureDate      = $DateCalculatedEnd;
        $PersianDepartureDateFirst = $DateCalculatedStart;


        $i           = 1;
        $Root        = ROOT_ADDRESS;
        $Origin      = $Departure_Code;
        $Destination = $Arrival_Code;
        $Adult       = $adult;
        $Child       = $child;
        $Infant      = $infant;

        ob_start();
        ?>

      <a href="javascript:void(0)" class="carouseller__left">
        <i class="zmdi zmdi-chevron-left "
           onclick="LowestPriceFlight('<?php echo $PersianDepartureDate ?>' ,'<?php echo $Departure_Code ?>','<?php echo $Arrival_Code ?>','<?php echo $adult ?>','<?php echo $child ?>','<?php echo $infant ?>','Next'); return false"></i>
      </a>
      <div class="carouseller__wrap">
        <div class="carouseller__list">
            <?php

            while ( $DateCalculatedStart < $DateCalculatedEnd ) {

                $ex    = explode( '-', $DateCalculatedStart );
                $ex[2] = ( $ex[2] > 9 ) ? $ex[2] : str_replace( '0', '', $ex[2] );
                $ex[1] = str_replace( '0', '', $ex[1] );

                $DateCalculatedStart    = $ex[0] . '-' . $ex[1] . '-' . $ex[2];
                $DateCalculatedStartInt = dateTimeSetting::jmktime( '0', '0', '0', $ex[1], $ex[2], $ex[0] );

                if ( ! empty( $ResultApiNew[ $DateCalculatedStart ] ) ) {
                    $prices   = self::array_column( $ResultApiNew, 'MinPrice' );
                    $minPrice = min( $prices );
                    $Class    = ( $ResultApiNew[ $DateCalculatedStart ]['MinPrice'] == $minPrice ) ? 'site-bg-main-color' : '';
                    ?>
                  <div class="quickTicksBox car__by5 <?php echo $Class ?>">
                    <a clear="quickTicksLink"
                       href="<?php echo $Root ?>/local/1/<?php echo $Origin ?>-<?php echo $Destination ?>/<?php echo $DateCalculatedStart ?>/Y/<?php echo $Adult ?>-<?php echo $Child ?>-<?php echo $Infant ?>/">
                            <span class="cheaperTicketPrice site-bg-main-color site-bg-color-dock-border-right-b site-bg-color-dock-border-top ">
                               <p>
                                <?php echo number_format( $ResultApiNew[ $DateCalculatedStart ]['MinPrice'] * 10 ) ?> <i> ریال</i>
                               </p>
                              </span>
                      <span class="cheaperTicketDate">
                                <p><?php echo dateTimeSetting::jdate( "l", dateTimeSetting::jmktime( '0', '0', '0', $ex[1], $ex[2], $ex[0] ) ) ?></p>
                              </span>
                      <span class="cheaperTicketDate">
                                 <p class="font15"><?php echo $DateCalculatedStart ?></p>
                              </span>
                    </a>
                  </div>
                <?php } else { ?>
                  <div class="quickTicksBox car__by5">
                          <span clear="quickTicksLink" href="" onclick="return false;">
                             <span
                               class="cheaperTicketPrice site-bg-main-color site-bg-color-dock-border-right-b site-bg-color-dock-border-top">
                               <p>
                                    <i>موجود نیست</i>
                               </p>
                              </span>
                              <span class="cheaperTicketDate">
                                 <p><?php echo dateTimeSetting::jdate( "l", dateTimeSetting::jmktime( '0', '0', '0', $ex[1], $ex[2], $ex[0] ) ) ?></p>
                              </span>
                              <span class="cheaperTicketDate">
                                <p class="font15"><?php echo $DateCalculatedStart ?></p>
                              </span>
                           </span>
                  </div>
                    <?php
                }

                $DateCalculatedStart = dateTimeSetting::jdate( "Y-m-d", $MktTimeStart + ( $i ++ * 24 * 60 * 60 ), "", "", "en" );

            }
            ?>
        </div>
      </div>
      <a href="javascript:void(0)" class="carouseller__right">
        <i class="zmdi zmdi-chevron-right"
           onclick="LowestPriceFlight('<?php echo $PersianDepartureDateFirst ?>','<?php echo $Departure_Code ?>','<?php echo $Arrival_Code ?>','<?php echo $adult ?>','<?php echo $child ?>','<?php echo $infant ?>','Perv'); return false"></i>
      </a>
        <?php

        return $PrintTicket = ob_get_clean();
    }
    #endregion

    #region name airline

    public static function MinimumPriceInDate( $Departure_Code, $Arrival_Code, $dateStart, $dateEnd ) {
        $url       = "http://api.hiholiday.ir/V4/Flight/CalendarRoute/c4463bb2-b13c-46f1-97b9-863a8e7e3a67/{$Departure_Code}/{$Arrival_Code}/{$dateStart}/{$dateEnd}";
        $dataEmpty = array();


        $data = self::curlExecution_Get( $url, $dataEmpty );


        return $data;
    }
    #endregion

    #region name getAirlineNameById

    public static function curlExecution_Get( $url, $data ) {
        /**
         * This function execute curl with a url & datas
         *
         * @param $url  string
         * @param $data an associative array of elements
         *
         * @return jason decoded output
         * @author SaeedAlizadeh
         */

        $handle = curl_init( $url );

        curl_setopt( $handle, CURLOPT_HTTPGET, true );
        curl_setopt( $handle, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $handle, CURLOPT_HTTPGET, $data );

        $result = curl_exec( $handle );

        return json_decode( $result, true );
    }
    #endregion

    #region FeeCancelFlight

    public static function array_column( array $input, $columnKey, $indexKey = null ) {
        if ( function_exists( 'array_column' ) ) {
            return array_column( $input, $columnKey, $indexKey );
        }
        $array = array();
        foreach ( $input as $value ) {
            if ( ! array_key_exists( $columnKey, $value ) ) {
                return false;
            }
            if ( is_null( $indexKey ) ) {
                $array[] = $value[ $columnKey ];
            } else {
                if ( ! array_key_exists( $indexKey, $value ) ) {
                    return false;
                }
                if ( ! is_scalar( $value[ $indexKey ] ) ) {
                    return false;
                }
                $array[ $value[ $indexKey ] ] = $value[ $columnKey ];
            }
        }

        return $array;
    }

    #endregion

    #region generateHashCode

    public static function MinimumPriceCalculate( $data = array() ) {
        $dataNew = array();
        foreach ( $data['CalendarRoute'] as $Val ) {
            $dataNew[] = $Val['MinPrice'];
        }

        return min( $dataNew );

    }
    #endregion

    #region getDateTime

    public static function AirlineList() {
        Load::autoload( 'ModelBase' );

        $ModelBase = new ModelBase();

        $SqlAirLine = "SELECT * FROM airline_tb WHERE active ='on' AND del='no'";

        $ResultAirLine = $ModelBase->select( $SqlAirLine );


        return $ResultAirLine;

    }
    #endregion

    #region getAirline

    public static function AirlineName( $param ) {


        $ModelBase = Load::library( 'ModelBase' );

        $SqlAirLineName = "SELECT * FROM airline_tb WHERE abbreviation='{$param}'";

        $ResultAirLineName = $ModelBase->load( $SqlAirLineName );

        $nameFieldAirline = ( SOFTWARE_LANG == 'fa' ) ? 'name_fa' : 'name';

        return $ResultAirLineName[ self::ChangeIndexNameByLanguage( SOFTWARE_LANG, $nameFieldAirline ) ];

    }
    #endregion

    #region getAirlineNameById

    public static function getAirlineNameById( $id ) {
        Load::autoload( 'ModelBase' );
        $ModelBase         = new ModelBase();
        $SqlAirLineName    = "SELECT * FROM airline_tb WHERE id = '{$id}' ";
        $ResultAirLineName = $ModelBase->load( $SqlAirLineName );

        return $ResultAirLineName['name_fa'];
    }
    #endregion

    #region generateHashCode

    public static function generateHashCode() {
        $chars = "abcdefghijkmnopqrstuvwxyz023456789";
        srand( (double) microtime() * 1000000 );
        $i    = 0;
        $pass = '';

        while ( $i <= 32 ) {
            $num  = rand() % 33;
            $tmp  = substr( $chars, $num, 1 );
            $pass = $pass . $tmp;
            $i ++;
        }

        return $pass;
    }
    #endregion

    #region joinStringVariable

    public static function getDateTime() {
        return date( "Y-m-d  H:i:s" );
    }
    #endregion

    #region CodeCityDep

    public static function MinPriceForAirline( $Airline, $ListFlights = array() ) {
        $i = 0;

        if ( empty( $ListFlights ) ) {
            $ListFlights = array();
        }
        foreach ( $ListFlights as $List ) {
            if ( $Airline == $List['Airline'] ) {
                $ListAirline['price'][ $i ]      = $List['AdtPrice'];
                $ListAirline['FlightType'][ $i ] = $List['FlightType_li'];
                $i ++;
            }
        }


        $data['price']      = min( $ListAirline['price'] );
        $data['FlightType'] = $ListAirline['FlightType'];

        return $data;
    }
    #endregion

    #region NameCityDep

    public static function joinStringVariable( $string, $variable ) {
        return $string . $variable;
    }
    #endregion

    #region SelectArrival

    public static function NameCityDep() {
        $ArrName    = array();
        $arrayCitys = self::CodeCityDep();
        foreach ( $arrayCitys as $city ) {
            $ArrName[ $city['Departure_Code'] ] = $city['Departure_City'];
        }

        return $ArrName;
    }
    #endregion

    #region getAirlinePhoto

    public static function CodeCityDep() {
        Load::autoload( 'Model' );
        $Model     = new Model();
        $sql       = "SELECT DISTINCTROW Departure_Code, Departure_City, Departure_CityEn FROM flight_route_tb WHERE Local_portal ='0' ORDER BY priorityDeparture=0,priorityDeparture ASC LIMIT 9";
        $res       = $Model->select( $sql );
        $arrayName = array();
        $i         = 0;
        foreach ( $res as $city ) {
            $arrayName[ $i ]['Departure_Code'] = $city['Departure_Code'];
            $arrayName[ $i ]['Departure_City'] = $city['Departure_City'];
            $i ++;
        }

        return $arrayName;
    }
    #endregion

    #region classTimeLOCAL

    public static function SelectArrival( $origin ) {
        Load::autoload( 'Model' );
        $Model = new Model();
        $sql   = " SELECT * FROM flight_route_tb WHERE Departure_Code='{$origin}'";

        $res        = $Model->select( $sql );
        $ArrayCodes = array();
        $codeCitys  = self::CodeCityDep();
        foreach ( $codeCitys as $code ) {
            $ArrayCodes[] = $code['Departure_Code'];
        }
        $ArrayCity = array();
        foreach ( $res as $dep ) {


            if ( in_array( $dep['Arrival_Code'], $ArrayCodes ) ) {
                $ArrayCity[] = $dep;
            }
        }

        return array_reverse( $ArrayCity );
    }
    #endregion

    #region classTime

    public static function getAirlinePhoto( $iata ) {
        $airline = Load::model( 'airline' );
        $rec     = $airline->getByIata( $iata );

        return ROOT_ADDRESS_WITHOUT_LANG . "/pic/airline/" . $rec['photo'];
    }
    #endregion

    #region getAirlines

    /**
     * this function divides time into four parts: early, morning, afternoon, night
     *
     * @param string $time in 24 hours format
     *
     * @return early for (0-8) or morning for (8-12) or afternoon for (12-18) or night for (18-24)
     * @author Naime Barati
     */
    public static function classTimeLOCAL( $time,$echo=true ) {

        if ( substr( $time, 0, 1 ) == '0' ) {
            $hour = substr( $time, 1, 1 );
        } else {
            $hour = substr( $time, 0, 2 );
        }
        $result = '';
        if ( $hour >= 0 && $hour < 8 ) {
            $result = 'early';
        } elseif ( $hour >= 8 && $hour < 12 ) {
            $result = 'morning';
        } elseif ( $hour >= 12 && $hour < 18 ) {
            $result = 'afternoon';
        } elseif ( $hour >= 18 && $hour < 24 ) {
            $result = 'night';
        }

        if(!$echo) {
            return $result;
        }
        echo $result;

    }
    #endregion

    #region array_column

    public static function classTime( $time ) {
        if ( $time < 8 ) {
            echo 'early';
        } elseif ( $time < 12 ) {
            echo 'morning';
        } elseif ( $time < 18 ) {
            echo 'afternoon';
        } elseif ( $time < 24 ) {
            echo 'night';
        }
    }
    #endregion

    #region AllClients

    public static function AllClients() {
        Load::autoload( 'ModelBase' );
        $ModelBase = new ModelBase();

        $sql = " SELECT * FROM clients_tb WHERE  id > '1' ORDER BY id DESC";

        $Clients = $ModelBase->select( $sql );

        return $Clients;
    }
    #endregion

    #region [log]

    public static function format_hour_arrival( $param1, $param2, $param3 ) {
        $flight_route = new ModelBase();

        $sql          = " SELECT  *  FROM flight_route_tb  WHERE Departure_Code='{$param1}' AND Arrival_Code='{$param2}'";
        $flight_route = $flight_route->load( $sql );

        if ( ! empty( $flight_route['TimeLongFlight'] ) ) {

            $explode_date = explode( ':', $flight_route['TimeLongFlight'] );
            $jmktime      = dateTimeSetting::jmktime( $explode_date[0], $explode_date[1], 0 );
            $ArrivalTime  = self::getTimeArrival( $explode_date[0], $explode_date[1], $param3 );

        }

        return $ArrivalTime;
    }
    #endregion

    #region format_hour

    public static function getTimeArrival( $HourLongFlight, $MinutesLongFlight, $TimeFlight ) {

        if ( $HourLongFlight > 00 ) {
            $cal1 = $HourLongFlight * 60;
        } else {
            $cal1 = 0;
        }

        if ( $MinutesLongFlight > 00 ) {
            $cal2 = $MinutesLongFlight;
        } else {
            $cal2 = 0;
        }

        $calTotal    = $cal1 + $cal2;
        $time        = strtotime( self::format_hour( $TimeFlight ) );
        $ArrivalTime = date( "H:i", strtotime( '+' . $calTotal . ' minutes', $time ) );

        return $ArrivalTime;
    }
    #endregion

    #region format_hour_arrival

    public static function format_hour( $num ) {

        return date( "H:i", strtotime( $num ) );

    }
    #endregion

    #region getTimeArrival

    public static function Date_arrival( $origin, $destination, $timeSelected, $dateSelected ) {
        $flight_route = new ModelBase();

        $sql = " SELECT   TimeLongFlight  FROM flight_route_tb  WHERE Departure_Code='{$origin}' AND Arrival_Code='{$destination}'  ";

        $flight_route = $flight_route->load( $sql );


        if ( ! empty( $flight_route['TimeLongFlight'] ) ) {

            $explode_date = explode( ':', $flight_route['TimeLongFlight'] );

            if ( $explode_date[0] > 00 ) {
                $cal1 = $explode_date[0] * 60;
            } else {
                $cal1 = 0;
            }

            if ( $explode_date[1] > 00 ) {
                $cal2 = $explode_date[1];
            } else {
                $cal2 = 0;
            }

            $calTotal = $cal1 + $cal2;
            $time     = self::format_hour( $timeSelected ) . ':00';


            $date_selected_explode = explode('T', $dateSelected);

            $ArrivalDate = date( "Y/m/d ", strtotime( "+" . $calTotal . " minutes " . $date_selected_explode[0] . "" . $time ) ) ;

            $gr_explode = explode( '/', $ArrivalDate );

            return (SOFTWARE_LANG !='fa')  ? $ArrivalDate :  dateTimeSetting::gregorian_to_jalali( $gr_explode[0], $gr_explode[1], $gr_explode[2], '/' );

        } else {
            return functions::Xmlinformation( 'Unknown' );
        }
    }
    #endregion

    #region TypeServiceHotel

    public static function TypeServiceHotel( $typeApplication, $isExternal = null, $webservice_type = '' ) {
        if ( $typeApplication == 'api' || $typeApplication == 'api_app' ) {
            if ( $webservice_type == 'private' ) {
                return 'PrivateLocalHotel';
            }

            return 'PublicLocalHotel';
        } elseif ( $typeApplication == 'reservation' || $typeApplication == 'reservation_app' ) {
            if ( isset( $isExternal ) && $isExternal == 'yes' ) {
                return 'PrivatePortalHotel';
            } else {
                return 'PrivateLocalHotel';
            }
        } elseif ( $typeApplication == 'externalApi' ) {
            if ( $webservice_type == 'private' ) {
                return 'PrivatePortalHotel';
            }

            return 'PublicPortalHotel';
        }
    }
    #endregion

    #region ServiceDiscount

    public static function getTypeServiceTour( $typeApplication, $idTour = null ) {
        if ( $typeApplication == 'reservation' ) {
            $Model = Load::library( 'Model' );
            $sql   = "
                SELECT
                    destination_country_id
                FROM
                    reservation_tour_rout_tb
                WHERE
                    fk_tour_id = '{$idTour}'
                    AND tour_title = 'dept'
                    AND destination_country_id != '1'
                    AND is_del = 'no'
            ";
            $tour  = $Model->select( $sql );
            if ( ! empty( $tour ) ) {
                return 'PrivatePortalTour';
            } else {
                return 'PrivateLocalTour';
            }

        } else {
            return '';
        }
    }
    #endregion

    #region getAmountChangePrice

    public static function getCounterTypeId( $id ) {
        Load::autoload( 'Model' );
        $model          = new Model();
        $sql_book_hotel = "SELECT fk_counter_type_id FROM members_tb WHERE id='{$id}' ";
        $Hotel          = $model->Load( $sql_book_hotel );

        return $Hotel['fk_counter_type_id'];

    }
    #endregion

    #region TypeService

    public static function getServicesDiscount( $id ) {
        Load::autoload( 'Model' );
        $model          = new Model();
        $sql_book_hotel = "SELECT fk_counter_type_id FROM members_tb WHERE id='{$id}' ";
        $Hotel          = $model->Load( $sql_book_hotel );

        return $Hotel['fk_counter_type_id'];

    }
    #endregion

    #region TypeServiceHotel

    public static function getCounterName( $id ) {
        Load::autoload( 'Model' );
        $model          = new Model();
        $sql_book_hotel = "SELECT name FROM counter_type_tb WHERE id='{$id}' ";
        $Hotel          = $model->Load( $sql_book_hotel );

        return $Hotel['name'];

    }
    #endregion

    #region getTypeServiceTour

    public static function generateRandomCode( $length = 6 ) {
        $str        = "";
        $characters = array_merge( range( 'A', 'Z' ), range( 'a', 'z' ), range( '0', '9' ) );
        $max        = count( $characters ) - 1;
        for ( $i = 0; $i < $length; $i ++ ) {
            $rand = mt_rand( 0, $max );
            $str  .= $characters[ $rand ];
        }

        return $str;
    }
    #endregion

    #region [getCounterTypeId]

    public static function calcDiscountCodeByFactor( $amount, $factorNumber ) {
        Load::autoload( 'Model' );
        $model = new Model();

        $query  = "SELECT DC.amount FROM discount_codes_used_tb AS DCU INNER JOIN discount_codes_tb AS DC ON DCU.discountCode = DC.code
                  WHERE DCU.factorNumber = '{$factorNumber}' AND DCU.status = 'success'";
        $result = $model->load( $query );

        if ( ! empty( $result ) ) {
            return ( $amount - $result['amount'] );
        } else {
            return $amount;
        }
    }
    #endregion

    #region [getCounterTypeId]

    public static function getOnlineMemberCredit() {
        /** @var members $members */
        $members = Load::controller( 'members' );
        $result  = $members->getMemberCredit();

        return $result;
    }
    #endregion


    #region [getCounterName]

    public static function popZomorod() {
        if ( Session::IsLogin() ) {
            setcookie( 'popup', true, time() + 86400, '/' );
        }

        if ( $_COOKIE['popup'] ) {
            $CookieCalculated = "SuccessCookie";
        } else {
            $CookieCalculated = "NoCookie";
        }

        return $CookieCalculated;
    }
    #endregion

    #region generateRandomCode: generate random code of capital and small characters and numbers
    public static function getHotelPriceChange( $city, $hotelStar, $counterId, $date, $typeApplication ) {

        $Model = Load::library( 'Model' );

        $date = str_replace( "-", "", $date );
        $date = str_replace( "/", "", $date );
        $y    = substr( $date, 0, 4 );
        $m    = substr( $date, 4, 2 );
        $d    = substr( $date, 6, 2 );
        $date = $y . "/" . $m . "/" . $d;

        try {
            $query  = ( "CALL sp_price_hotel_change_tb(:city,:hotelStar,:counterId,:date,:typeApplication)" );

            $params = array(
                ':city'            => $city,
                ':hotelStar'       => $hotelStar,
                ':counterId'       => $counterId,
                ':date'            => $date,
                ':typeApplication' => $typeApplication
            );
			$result = $Model->runSP( $query, $params );

			return $result;

		} catch ( PDOException $ex ) {
			return false;
		}
	}
    #endregion


    public static function calculateHotelPrice($price_changes,$service_discount = 0, $price = 0,$only_calculated = false)
    {

        $base_price = $price;

        $result = array();
        $result['discount'] = $service_discount;
        $result['base_price'] = $base_price;
        $discount_amount = 0;
        $price_change_amount = 0;
        if(isset($result['discount']['off_percent']) && $result['discount']['off_percent'] > 0){
            $discount_amount = ($base_price * ($result['discount']['off_percent'] / 100));
        }
        if($price_changes != false && isset($price_changes['price']) && $price_changes['price'] > 0) {
            $amount = $price_changes['price'];
            $price_type = $price_changes['price_type'];
            $change_type = $price_changes['change_type'];
            if ($price_type == 'cost') {
                if ($change_type == 'increase') {
                    $price_change_amount = $amount;
                }
//                if ($change_type == 'decrease') {
//                    $price_change_amount = $base_price - $amount;
//                }
            }
            if ($price_type == 'percent') {
                if ($change_type == 'increase') {
                    $price_change_amount = (($base_price * ($amount / 100)));
                }
//                if ($change_type == 'decrease') {
//                    $price_change_amount = (-1 * ($base_price * $amount / 100));
//                }
            }
        }

        $result['discount_amount'] = $discount_amount;
        $result['change_amount'] = $price_change_amount;
        $result['price_changes'] = $price_changes;
        $result['calculated_price'] = (($base_price + $price_change_amount) - $discount_amount);
        $result['price_with_increase_change'] = (($base_price + $price_change_amount));
        if($only_calculated){
            return $result['calculated_price'];
        }
        return $result;
    }

    #region calcDiscountCodeByFactor: calculate discount code amount by factor number and if it exists

   public static function calculateHotelPrice1($price_changes,$service_discount = 0, $price = 0,$only_calculated = false)
    {

        $base_price = $price;
       
        $result = array();
        $result['discount'] = $service_discount;
        $result['discount_amount'] = 0;
        $result['base_price'] = $base_price;
        $discount_amount = 0;
        $price_change_amount = 0;
        $addOnPrice = 0;
        if($price_changes != false && isset($price_changes['price']) && $price_changes['price'] > 0) {
            $amount = $price_changes['price'];
            $price_type = $price_changes['price_type'];
            $change_type = $price_changes['change_type'];
            if ($price_type == 'cost') {
                $addOnPrice = $amount;
            }
            if ($price_type == 'percent') {
                if ($change_type == 'increase') {
                    $addOnPrice = (($base_price * ($amount / 100)));
                }
            }
        }
        if(isset($result['discount']['off_percent']) && $result['discount']['off_percent'] > 0) {
            if($addOnPrice == 0 ) {
                $discount_amount = ($base_price * ($result['discount']['off_percent'] / 100));
            }else{

                $discount_amount =   round(( $addOnPrice * $result['discount']['off_percent'] ) / 100 ) ;
                $before_discount = $base_price + $addOnPrice  ;
                $total = (($base_price + $addOnPrice) - $discount_amount) ;
                $discount = (($before_discount / $total )- 1 ) * 100 ;
                $result['discount']['off_percent'] =  round($discount, 2, PHP_ROUND_HALF_DOWN);
            }
        }
        $result['discount_amount'] = $discount_amount;
        $result['change_amount'] = $addOnPrice;
        $result['price_changes'] = $price_changes;
        $result['calculated_price'] = (($base_price + $addOnPrice) - $discount_amount);
        $result['price_with_increase_change'] = (($base_price + $addOnPrice));
        if($only_calculated){
            return $result['calculated_price'];
        }
        return $result;
    }

    public static function getBusTicketPriceChanges( $param ) {
        $date = str_replace( "-", "", $param['date'] );
        $date = str_replace( "/", "", $date );
        $y    = substr( $date, 0, 4 );
        $m    = substr( $date, 4, 2 );
        $d    = substr( $date, 6, 2 );
        $date = $y . "/" . $m . "/" . $d;

        try {
            $Model  = Load::library( 'Model' );
            $query  = ( "CALL sp_bus_ticket_price_changes_tb(:originCity,:destinationCity,:companyBus,:counterId,:date)" );
            $params = array(
                ':originCity'      => $param['originCity'],
                ':destinationCity' => $param['destinationCity'],
                ':companyBus'      => $param['companyId'],
                ':counterId'       => $param['counterId'],
                ':date'            => $date
            );
            $result = $Model->runSP( $query, $params );
            if ( ! empty( $result ) && $param['price'] != 0 && $result['change_type'] == 'increase' && $result['price_type'] == 'cost' ) {
                $returnPrice = $param['price'] + $result['price'];
            } elseif ( ! empty( $result ) && $param['price'] != 0 && $result['change_type'] == 'decrease' && $result['price_type'] == 'cost' ) {
                $returnPrice = $param['price'] - $result['price'];
            } elseif ( ! empty( $result ) && $param['price'] != 0 && $result['change_type'] == 'increase' && $result['price_type'] == 'percent' ) {
                $returnPrice = ( $param['price'] * $result['price'] / 100 ) + $param['price'];
            } elseif ( ! empty( $result ) && $param['price'] != 0 && $result['change_type'] == 'decrease' && $result['price_type'] == 'percent' ) {
                $returnPrice = ( $param['price'] * $result['price'] / 100 ) - $param['price'];
            } else {
                $returnPrice = $param['price'];
            }

            return [
                'price'        => $returnPrice,
                'price_change' => $result['price'],
                'price_type'   => $result['price_type'],
                'change_type'  => $result['change_type']
            ];
        } catch ( PDOException $ex ) {
            return false;
        }
    }
    #endregion

    #region cancelingRules

    public static function cancelingRules( $Param ) {
        ob_start();

        $Fee = self::FeeCancelFlight( $Param['Airline'], $Param['CabinType'] );


        if ( strtolower( $Param['FlightType'] ) == 'system' ) {
            $Param['FlightType'] = 'system';
        } else {
            $Param['FlightType'] = 'charter';
        }
        ?>
      <div class="pop-up-h site-bg-main-color">
        <span> <?php echo functions::Xmlinformation( 'CabinTypeDetails' ) ?>:<?php echo $Param['CabinType'] ?></span>
      </div>
      <div class="price-Content site-border-main-color">
        <p id="AlertPanelHTC"></p>

        <div class="tblprice">
          <div>
            <div class="tdpricelabel"><?php echo functions::Xmlinformation( 'Priceadult' ) ?> :</div>
            <div class="tdprice">

                <?php
                $SubFlightType = strtolower( $Param['FlightType'] ) == 'system' ? 'system' : 'charter';
                //
                $SubPriceCalculate  = functions::setPriceChanges( $Param['Airline'], $SubFlightType, $Param['AdtPrice'], $Param['AdtFare'], 'Local', strtolower( $Param['FlightType'] ) == 'system' ? '' : 'public' );
                $SubPriceCalculated = explode( ':', $SubPriceCalculate );

                if ( Session::IsLogin() ) {
                    if ( $SubPriceCalculated[2] == 'YES' ) {
                        ?>
                      <i class="text-decoration-line"><?php echo number_format( $SubPriceCalculated[1] ) ?></i>
                      <i class="bg-price-box "><?php echo number_format( $SubPriceCalculated[0] ); ?></i>ریال
                        <?php
                    } else {
                        ?>
                      <i class="bg-price-box "><?php echo number_format( $SubPriceCalculated[1] ) ?></i>ریال<?php
                    }
                    ?>
                <?php } else { ?>
                  <i><?php echo number_format( $SubPriceCalculated[1] ) . ' ' . functions::Xmlinformation( 'Rial' ) ?></i>
                <?php } ?>
            </div>
            <!-- </tr>
                    <tr> -->
            <div class="tdpricelabel"><?php echo functions::Xmlinformation( 'Pricechild' ) ?> :</div>
            <div class="tdprice">

                <?php
                if ( ! empty( $Param['ChdPrice'] ) ) {
                    $SubFlightType = strtolower( $Param['FlightType'] ) == 'system' ? 'system' : 'charter';
                    //
                    $SubPriceCalculate  = functions::setPriceChanges( $Param['Airline'], $SubFlightType, $Param['ChdPrice'], $Param['ChdFare'], 'Local', strtolower( $Param['FlightType'] ) == 'system' ? '' : 'public' );
                    $SubPriceCalculated = explode( ':', $SubPriceCalculate );

                    if ( Session::IsLogin() ) {
                        if ( ( $Param['SourceId'] == '1' || $Param['SourceId'] == '11' ) ) {
                            $OriginPriceWithOutDiscount = $SubPriceCalculated[1] - ceil( ( ( $SubPriceCalculated[1] * 11768 ) / 100000 ) );
                            if ( $SubPriceCalculated[2] == 'YES' ) {
                                $PriceAfterDiscount = $SubPriceCalculated[0] - ceil( ( ( $SubPriceCalculated[0] * 11768 ) / 100000 ) );
                                ?>
                              <i class="text-decoration-line"><?php echo number_format( round( $OriginPriceWithOutDiscount, - 1 ) ) ?></i>
                              <i class="bg-price-box site-bg-main-color"><?php echo number_format( round( $PriceAfterDiscount, - 1 ) ); ?></i><?php echo functions::Xmlinformation( 'Rial' ) ?>
                                <?php
                            } else {
                                ?>
                              <i class="bg-price-box site-bg-main-color"><?php echo number_format( round( $OriginPriceWithOutDiscount,
                                    - 1 ) ) ?></i><?php echo functions::Xmlinformation( 'Rial' ) ?><?php
                            }
                        } else {
                            if ( $SubPriceCalculated[2] == 'YES' ) {
                                ?>
                              <i class="text-decoration-line"><?php echo number_format( $SubPriceCalculated[1] ) ?></i>
                              <i class="bg-price-box site-bg-main-color"><?php echo number_format( $SubPriceCalculated[0] ); ?></i><?php echo functions::Xmlinformation( 'Rial' ) ?>
                                <?php
                            } else {
                                ?>
                              <i class="bg-price-box site-bg-main-color"><?php echo number_format( $SubPriceCalculated[1] ) ?></i><?php echo functions::Xmlinformation( 'Rial' ) ?><?php
                            }
                        }

                        ?>
                    <?php } else { ?>
                      <i><?php

                          if ( ( $Param['SourceId'] == '1' || $Param['SourceId'] == '11' ) ) {
                              $OriginPriceWithOutDiscount = $Param['ChdPrice'] - ceil( ( ( $Param['ChdPrice'] * 11768 ) / 100000 ) );
                              echo number_format( round( $OriginPriceWithOutDiscount, - 1 ) );
                          } else {
                              echo number_format( $Param['ChdPrice'] );
                          }
                          ?><?php echo functions::Xmlinformation( 'Rial' ) ?></i>
                        <?php
                    }
                } else {
                    ?><i><?php echo functions::Xmlinformation( 'PreInvoiceStep' ) ?></i><?php
                }
                ?>
            </div>
            <!--   </tr>
                      <tr> -->
            <div class="tdpricelabel"> <?php echo functions::Xmlinformation( 'Pricebaby' ) ?>:</div>
            <div class="tdprice">

                <?php
                $PriceInfant = $Param['InfPrice'] - ceil( ( $Param['InfPrice'] * 75586 ) / 100000 );
                if ( functions::checkConfigPid( $Param['Airline'], 'internal', strtolower( $Param['FlightType'] ) ) == 'public' ) {

                    if ( strtolower( $Param['FlightType'] ) == 'system' ) {

                        if ( ( $Param['SourceId'] == '1' || $Param['SourceId'] == '11' ) ) {


                            ?>
                          <i><?php echo number_format( round( $PriceInfant, - 1 ) ) ?></i> <?php echo functions::Xmlinformation( 'Rial' ) ?>
                            <?php
                        } else {
                            ?>

                          <i><?php echo number_format( $Param['InfPrice'] ) ?></i> <?php echo functions::Xmlinformation( 'Rial' ) ?>
                            <?php
                        }
                    } else {
                        echo functions::Xmlinformation( 'PreInvoiceStep' );
                    }
                } else {
                    if ( strtolower( $Param['FlightType'] ) == 'system' ) {

                        if ( ( $Param['SourceId'] == '1' || $Param['SourceId'] == '11' ) ) {


                            ?>
                          <i><?php echo number_format( round( $PriceInfant, - 1 ) ) ?></i> <?php echo functions::Xmlinformation( 'Rial' ) ?>
                            <?php
                        } else {
                            ?>

                          <i><?php echo number_format( $Param['InfPrice'] ) ?></i> <?php echo functions::Xmlinformation( 'Rial' ) ?>
                            <?php
                        }
                    } else {
                        echo functions::Xmlinformation( 'PreInvoiceStep' );
                    }
                }
                ?>
            </div>
          </div>
        </div>


      </div>

        <?php if ( ! empty( $Fee ) && strtolower( $Param['FlightType'] ) == 'system' ) { ?>
        <div class="cancel-policy">

          <div class="cancel-policy-inner">
            <div class="cancel-policy-item">
              <span class="cancel-policy-item-text"><?php echo functions::Xmlinformation( 'Fromthetimeticketissueuntilnoondaysbeforeflight' ) ?></span>
              <span
                class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric( $Fee['ThreeDaysBefore'] ) ?
                      $Fee['ThreeDaysBefore'] . ' ' . functions::Xmlinformation( 'PenaltyPercent' ) : $Fee['ThreeDaysBefore']; ?> </span>
            </div>
            <div class="cancel-policy-item">
              <span class="cancel-policy-item-text"><?php echo functions::Xmlinformation( 'Fromnoondaysbeforeflightnoondaybeforeflight' ) ?></span>
              <span
                class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric( $Fee['OneDaysBefore'] ) ?
                      $Fee['OneDaysBefore'] . ' ' . functions::Xmlinformation( 'PenaltyPercent' ) : $Fee['OneDaysBefore']; ?> </span>
            </div>
            <div class="cancel-policy-item">
              <span class="cancel-policy-item-text"><?php echo functions::Xmlinformation( 'Fromnoondaybeforeflighthoursbeforeflight' ) ?></span>
              <span
                class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric( $Fee['ThreeHoursBefore'] ) ?
                      $Fee['ThreeHoursBefore'] . ' ' . functions::Xmlinformation( 'PenaltyPercent' ) : $Fee['ThreeHoursBefore']; ?> </span>
            </div>
            <div class="cancel-policy-item">
              <span class="cancel-policy-item-text"><?php echo functions::Xmlinformation( 'Fromhoursbeforeflighttominutesbeforeflight' ) ?></span>
              <span
                class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric( $Fee['ThirtyMinutesAgo'] ) ?
                      $Fee['ThirtyMinutesAgo'] . ' ' . functions::Xmlinformation( 'PenaltyPercent' ) : $Fee['ThirtyMinutesAgo']; ?> </span>
            </div>
            <div class="cancel-policy-item">
              <span class="cancel-policy-item-text"><?php echo functions::Xmlinformation( 'Minutesbeforetheflight' ) ?></span>
              <span
                class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric( $Fee['OfThirtyMinutesAgoToNext'] ) ?
                      $Fee['OfThirtyMinutesAgoToNext'] . ' ' . functions::Xmlinformation( 'PenaltyPercent' ) : $Fee['OfThirtyMinutesAgoToNext']; ?> </span>
            </div>
          </div>
        </div>
        <?php } else if ( empty( $Fee ) && strtolower( $Param['FlightType'] ) == 'system' ) { ?>
        <div class="cancel-policy cancel-policy-charter">
          <span class=""><?php echo functions::Xmlinformation( 'Contactbackupunitinformationaboutamountconsignmentfines' ) ?></span>
        </div>
        <?php } else { ?>
        <div class="cancel-policy cancel-policy-charter">
          <span class=""><?php echo functions::Xmlinformation( 'ThecharterflightscharterunderstandingCivilAviationOrganization' ) ?></span>
        </div>
            <?php
        }

        return $PrintTicket = ob_get_clean();
    }
    #endregion

    #region popZomorod

    public static function FeeCancelFlight( $AirlineCode, $CabinType ) {
        Load::autoload( 'ModelBase' );

        $ModelBase = new ModelBase();

        $SqlFee = "SELECT * FROM cancellation_fee_settings_tb WHERE AirlineIata='{$AirlineCode}' AND TypeClass='{$CabinType}'";

        $ResultFee = $ModelBase->load( $SqlFee );

        return $ResultFee;
    }
    #endregion

    #region [Hotel price change (markup)]

    /**
     * @param $airline
     * @param $FlightType
     * @param $Price
     * @param $fare
     * @param $TypeZone
     * @param $TypeTicket
     *
     * @param null $SourceId
     * @return int
     */
    public static function setPriceChanges( $airline, $FlightType, $Price, $fare, $TypeZone, $TypeTicket = null, $SourceId = null ) {

        $FlightType    = strtolower( $FlightType );
        $IsLogin       = Session::IsLogin();
        $counterTypeId = ( $IsLogin ) ? Session::getCounterTypeId() : '5';
        $isInternal    = ( $TypeZone == 'Local' ) ? 'internal' : 'external';
        $checkPrivate  = ( functions::checkConfigPid( $airline, $isInternal, $FlightType,$SourceId) );


        $CalculatePriceChange = self::getAmountChangePrice( $counterTypeId, $airline, ( ( $TypeZone == 'Local' ) ? 'local' : 'international' ) );
        $TypeService          = self::TypeService( $FlightType, $TypeZone, $TypeTicket, $checkPrivate, $airline );
        $Discount             = self::ServiceDiscount( $counterTypeId, $TypeService );

        $AddOnPrice = '0';
        $arraySourceIncreasePriceFlightSystem = functions::sourceIncreasePriceFlightSystem();
        if (!empty($CalculatePriceChange) &&  ($FlightType == 'charter' || ($TypeZone == 'Portal') || in_array($SourceId,$arraySourceIncreasePriceFlightSystem)) && $Price > 0) {
            if ( $CalculatePriceChange['changeType'] == 'cost' ) {
                $AddOnPrice = $CalculatePriceChange['price'];
            } elseif ( $CalculatePriceChange['changeType'] == 'percent' ) {
                $AddOnPrice = (( $Price * $CalculatePriceChange['price']) / 100 );
            }
            $Price += $AddOnPrice;


        }
        if ( $FlightType == 'charter' ) {
            $TypeService;
            $itCommission       = '0';
            $iranTechCommission = Load::controller('irantechCommission');
            $itCommission       += $iranTechCommission->getFlightCommission( $TypeService, $SourceId );
            $Price              += $itCommission;
        }

        $PriceWithChanges = $Price;
        if ( $Discount['off_percent'] > 0 ) {
            if ( ( GDS_SWITCH == 'Local' || strpos( GDS_SWITCH, 'SearchEngine' ) !== false || GDS_SWITCH == 'app' || GDS_SWITCH == 'international' || GDS_SWITCH == 'user_ajax.php' ) || $IsLogin ) {
                //                $Price = $Price - (($Price * $Discount['off_percent']) / 100);

                if ( !empty($CalculatePriceChange) &&  ($FlightType == 'charter' || ($TypeZone == 'Portal') || in_array($SourceId,$arraySourceIncreasePriceFlightSystem)) ) {
                    $calculate_discount = round(( $AddOnPrice * $Discount['off_percent'] ) / 100 ) ;
                    $Price = (intval($Price) - intval($calculate_discount));
                } else if ( $checkPrivate == 'public' && $FlightType == 'system' && !in_array($SourceId,$arraySourceIncreasePriceFlightSystem)) {
                    $Price = $Price - ( $fare * ( $Discount['off_percent'] / 200 ) );
                } else if ( $checkPrivate == 'private' && $FlightType == 'system' && !in_array($SourceId,$arraySourceIncreasePriceFlightSystem)) {
                    $Price = $Price - ( $fare * ( $Discount['off_percent'] / 100 ) );
                }
            }
        }




        $HaveDiscount = ( ( $Discount['off_percent'] > 0 && ( $Price != $PriceWithChanges )
            && ( ( GDS_SWITCH == 'Local' || GDS_SWITCH == 'international' || GDS_SWITCH == 'user_ajax.php' )
                || $IsLogin ) ) ? 'YES' : 'No' );

        return round( $Price ) . ':' . round( $PriceWithChanges ) . ':' . $HaveDiscount;
    }
    #endregion

    #region [getBusTicketPriceChanges (markup)]

    public static function counterTypeId( $id ) {
        if ( ! empty( $id ) ) {
            $counterTypeId = $id;
        } else {
            $counterTypeId = '5';
        }

        return $counterTypeId;
    }
    #endregion

    #region [getPointClub]

    public static function DetectDirection( $FactorNumber, $RequestNumber ) {
        Load::autoload( 'ModelBase' );
        $ModelBase = new ModelBase();

        $QueryDetectDirection  = "SELECT id, factor_number, request_number, direction,type_app,IsInternal  FROM report_tb WHERE factor_number='{$FactorNumber}' GROUP BY request_number";
        $ResultDetectDirection = $ModelBase->select( $QueryDetectDirection );

        if($ResultDetectDirection[0]['direction'] == 'multi_destination'){
            return 'چند مسیره';

        }else if ( $ResultDetectDirection[0]['direction'] == 'TwoWay' ) {

            if ( $ResultDetectDirection[0]['request_number'] == $RequestNumber && $ResultDetectDirection[0]['IsInternal'] == '1' ) {
                return 'دو طرفه- داخلی';
            }

            return 'دوطرفه-خارجی';

        } else {
            if ( count( $ResultDetectDirection ) > 1 ) {
                foreach ( $ResultDetectDirection as $res ) {
                    if ( $res['request_number'] == $RequestNumber && $res['direction'] == 'dept' ) {
                        return 'دوطرفه-رفت';
                    }
                    if ( $res['request_number'] == $RequestNumber && $res['direction'] == 'return' ) {
                        return 'دوطرفه-برگشت';
                    }
                }
            } else {
                if ( $ResultDetectDirection[0]['request_number'] == $RequestNumber && $ResultDetectDirection[0]['IsInternal'] == '1' ) {
                    return 'یک طرفه';
                } elseif ( $ResultDetectDirection[0]['request_number'] == $RequestNumber && $ResultDetectDirection[0]['IsInternal'] == '0' ) {
                    return 'یک طرفه- خارجی';
                }

            }
        }


    }
    #endregion

    #region NewFormatDate

    public static function NewFormatDate( $param, $type = null ) {
        $param        = str_replace( '/', '-', $param );
        $explode_date = explode( '-', $param );

        if ( $explode_date[0] > 1450 ) {
            $jmktime = mktime( 0, 0, 0, $explode_date[1], $explode_date[2], $explode_date[0] );
        } else {
            $jmktime = dateTimeSetting::jmktime( 0, 0, 0, $explode_date[1], $explode_date[2], $explode_date[0] );
        }


        if ( SOFTWARE_LANG != 'fa' ) {
            $data['date_now'] = date( " j F Y", $jmktime );
            $data['date_jf']  = date( "j F", $jmktime );
            if ( empty( $type ) ) {
                $data['DateJalaliRequest'] = date( "Y-m-d", $jmktime );
            } else if ( $type == 'TwoWay' ) {
                $data['DateJalaliRequestReturn'] = date( "Y-m-d", $jmktime );
            }
            $data['day'] = date( "l", $jmktime );

        } else {
            $data['date_now'] = dateTimeSetting::jdate( " j F Y", $jmktime );
            $data['date_jf']  = dateTimeSetting::jdate( "j F", $jmktime );
            if ( empty( $type ) ) {
                $data['DateJalaliRequest'] = dateTimeSetting::jdate( "Y-m-d", $jmktime, '', '', 'en' );
            } else if ( $type == 'TwoWay' ) {
                $data['DateJalaliRequestReturn'] = dateTimeSetting::jdate( "Y-m-d", $jmktime, '', '', 'en' );
            }
            $data['day'] = dateTimeSetting::jdate( "l", $jmktime );
        }

        return $data;
    }
    #endregion

    #region EntertainmentPriceChange
    public static function setEntertainmentPriceChanges( $price ) {
        if ( $price > 0 ) {
            $UserId   = Session::getUserId();
            $UserInfo = functions::infoMember( $UserId );
            if ( ! empty( $UserInfo ) ) {
                $counterID = $UserInfo['fk_counter_type_id'];
            } else {
                $counterID = '5';
            }

            $insurancePriceChanges = Load::controller( 'insurancePriceChanges' );
            $priceChanges          = $insurancePriceChanges->getByCounter( $counterID );

            if ( ! empty( $priceChanges ) ) {
                if ( $priceChanges['changeType'] == 'cost' ) {
                    $price += $priceChanges['price'];
                } else {
                    $price += $price * ( $priceChanges['price'] / 100 );
                }
            }
        }

        return round( $price );
    }
    #endregion

    #region DetectDirection

    public static function setInsurancePriceChanges( $price ) {
        if ( $price > 0 ) {
            $UserId   = Session::getUserId();
            $UserInfo = functions::infoMember( $UserId );
            if ( ! empty( $UserInfo ) ) {
                $counterID = $UserInfo['fk_counter_type_id'];
            } else {
                $counterID = '5';
            }

            $insurancePriceChanges = Load::controller( 'insurancePriceChanges' );
            $priceChanges          = $insurancePriceChanges->getByCounter( $counterID );

            if ( ! empty( $priceChanges ) ) {
                if ( $priceChanges['changeType'] == 'cost' ) {
                    $price += $priceChanges['price'];
                } else {
                    $price += $price * ( $priceChanges['price'] / 100 );
                }
            }
        }

        return round( $price );
    }

    #endregion

    #region NewFormatDate

    public static function setGashtPriceChanges( $price ) {
        if ( $price > 0 ) {
            $UserId   = Session::getUserId();
            $UserInfo = functions::infoMember( $UserId );
            if ( ! empty( $UserInfo ) ) {
                $counterID = $UserInfo['fk_counter_type_id'];
            } else {
                $counterID = '5';
            }

            $insurancePriceChanges = Load::controller( 'gashtPriceChanges' );
            $priceChanges          = $insurancePriceChanges->getByCounter( $counterID );

            if ( ! empty( $priceChanges ) ) {
                if ( $priceChanges['changeType'] == 'cost' ) {
                    $price += $priceChanges['price'];
                } else {
                    $price += $price * ( $priceChanges['price'] / 100 );
                }
            }
        }

        return round( $price );
    }
    #endregion

    #region setInsurancePriceChanges

    public static function privateCharterFlights() {

        //source_id of sources which has private charter flights
        $sources = array( '8' );

        return $sources;

    }

    #endregion
    #region setGashtPriceChanges

    public static function privateSourceIdForeign() {

        //source_id of sources which has private charter flights
        $sources = array( '1' );

        return $sources;

    }

    #endregion

    #region privateCharterFlights

    public static function ClientIdCharterPrivateFlight() {

        //source_id of sources which has private charter flights
        $sources = array( '131' );

        return $sources;

    }

    #endregion
    #region privateSourceIdForeign

    public static function set_date_payment( $date = '' ) {
        $date_orginal_exploded = explode( ' ', $date );

        $date_miladi_exp = explode( '-', $date_orginal_exploded[0] );
        $date_new = dateTimeSetting::gregorian_to_jalali( $date_miladi_exp[0], $date_miladi_exp[1], $date_miladi_exp[2], '-' );

        return $date_new . ( $date_orginal_exploded[1] != '' ? ' (' . $date_orginal_exploded[1] . ') ' : '' );
    }

    #endregion

    #region ClientIdCharterPrivateFlight

    public static function total_price( $RequestNumber ) {
        Load::autoload( 'apiLocal' );
        $apiLocal = new apiLocal();

        list( $amount, $fare ) = $apiLocal->get_total_ticket_price( $RequestNumber, 'yes' );

        return $amount;
    }

    #endregion

    #region info_flight_directions

    public static function info_flight_directions( $request_number ) {



        if ( TYPE_ADMIN == '1' ) {
            $admin = Load::controller('admin');
            $ModelBase = Load::library( 'ModelBase' );
            $sql       = "SELECT R.*, "
                . " (SELECT COUNT(id) FROM report_tb WHERE request_number = R.request_number) AS CountTicket "
                . " FROM report_tb R WHERE "
                . " (R.factor_number='{$request_number}' OR R.request_number='{$request_number}') "
                . " AND (((R.factor_number OR R.request_number) > 0) OR ((R.factor_number OR R.request_number) <>'')) "
                . " GROUP BY R.direction ";
            $result    = $ModelBase->select( $sql );

       

               $info_cancel_sql = " SELECT 
                          cancel.NationalCode,
                            detail.*
                         FROM cancel_ticket_details_tb AS detail
                         INNER JOIN cancel_ticket_tb AS cancel ON cancel.idDetail = detail.id
                         WHERE detail.FactorNumber='{$request_number}' OR detail.RequestNumber='{$request_number}'  ";
            $info_cancel_detail= $admin->ConectDbClient( $info_cancel_sql, $result[0]['client_id'], "SelectAll", "", "", "" );

            $result['info_detail_cancel'] =   $info_cancel_detail ;

        } else {
            $Model  = Load::library( 'Model' );
            $sql    = "SELECT B.*, "
                . " (SELECT COUNT(id) FROM book_local_tb WHERE request_number = B.request_number) AS CountTicket "
                . " FROM book_local_tb B  WHERE "
                . " (B.factor_number='{$request_number}' OR B.request_number='{$request_number}') "
                . " AND (((B.factor_number OR B.request_number) > 0) OR ((B.factor_number OR B.request_number) <>'')) "
                . " GROUP BY B.direction ";
            $result = $Model->select( $sql );

            $info_cancel_sql = " SELECT 
                          cancel.NationalCode,
                            detail.*
                         FROM cancel_ticket_details_tb AS detail
                         INNER JOIN cancel_ticket_tb AS cancel ON cancel.idDetail = detail.id
                         WHERE detail.FactorNumber='{$request_number}' OR detail.RequestNumber='{$request_number}'  ";

            $result['info_detail_cancel'] =   $Model->select( $info_cancel_sql );
        }

        return $result;
    }


    #region info_flight_directions

    public static function info_exclusive_tour_directions( $request_number ) {



        if ( TYPE_ADMIN == '1' ) {
            $ModelBase = Load::library( 'ModelBase' );
            $sql       = "SELECT R.*, "
                . " (SELECT COUNT(id) FROM report_exclusive_tour_tb WHERE request_number = R.request_number) AS CountTicket "
                . " FROM report_exclusive_tour_tb R WHERE "
                . " (R.factor_number='{$request_number}' OR R.request_number='{$request_number}') "
                . " AND (((R.factor_number OR R.request_number) > 0) OR ((R.factor_number OR R.request_number) <>'')) ";
            $result    = $ModelBase->select( $sql );



        } else {
            $Model  = Load::library( 'Model' );
            $sql    = "SELECT B.*, "
                . " (SELECT COUNT(id) FROM book_exclusive_tour_tb WHERE request_number = B.request_number) AS CountTicket "
                . " FROM book_exclusive_tour_tb B  WHERE "
                . " (B.factor_number='{$request_number}' OR B.request_number='{$request_number}') "
                . " AND (((B.factor_number OR B.request_number) > 0) OR ((B.factor_number OR B.request_number) <>'')) ";
            $result = $Model->select( $sql );
        }

        return $result;
    }



    public static function info_cip_directions( $request_number ) {

        if ( TYPE_ADMIN == '1' ) {
            $ModelBase = Load::library( 'ModelBase' );
            $sql       = "SELECT R.*, "
                . " (SELECT COUNT(id) FROM report_cip_tb WHERE request_number = R.request_number) AS CountTicket "
                . " FROM report_cip_tb R WHERE "
                . " (R.factor_number='{$request_number}' OR R.request_number='{$request_number}') "
                . " AND (((R.factor_number OR R.request_number) > 0) OR ((R.factor_number OR R.request_number) <>'')) ";
            $result    = $ModelBase->select( $sql );



        } else {
            $Model  = Load::library( 'Model' );
            $sql    = "SELECT B.*, "
                . " (SELECT COUNT(id) FROM book_cip_tb WHERE request_number = B.request_number) AS CountTicket "
                . " FROM book_cip_tb B  WHERE "
                . " (B.factor_number='{$request_number}' OR B.request_number='{$request_number}') "
                . " AND (((B.factor_number OR B.request_number) > 0) OR ((B.factor_number OR B.request_number) <>'')) ";
            $result = $Model->select( $sql );
        }

        return $result;
    }

    #endregion

    #region info_train_directions

    public static function info_train_directions( $request_number, $groupBy ) {
        if ( TYPE_ADMIN == '1' ) {
            $Model = Load::library( 'ModelBase' );
            $sql   = "SELECT B.*, "
                . " (SELECT COUNT(id) FROM report_train_tb WHERE requestNumber = B.requestNumber) AS CountTicket "
                . " FROM book_train_tb AS  B  WHERE "
                . " (B.factor_number='{$request_number}' OR B.requestNumber='{$request_number}') "
                . " AND (((B.factor_number OR B.requestNumber) > 0) OR ((B.factor_number OR B.requestNumber) <>'')) ";
            if ( $groupBy == 'yes' ) {
                $sql .= " GROUP BY B.Route_Type ";
            }
        } else {
            $Model = Load::library( 'Model' );
            $sql   = "SELECT B.*, "
                . " (SELECT COUNT(id) FROM book_train_tb WHERE requestNumber = B.requestNumber) AS CountTicket "
                . " FROM book_train_tb AS  B  WHERE "
                . " (B.factor_number='{$request_number}' OR B.requestNumber='{$request_number}') "
                . " AND (((B.factor_number OR B.requestNumber) > 0) OR ((B.factor_number OR B.requestNumber) <>'')) ";
            if ( $groupBy == 'yes' ) {
                $sql .= " GROUP BY B.Route_Type ";
            }

        }
        $result = $Model->select( $sql );

        return $result;
    }

    #endregion

    #region info_bus _directions

    public static function info_bus_directions( $request_number ) {
        if ( TYPE_ADMIN == '1' ) {
            $admin = Load::controller('admin');
            $Model = Load::library( 'ModelBase' );
            $sql   = "SELECT B.*, "
                . " (SELECT COUNT(id) FROM report_bus_tb WHERE order_code = B.order_code) AS CountTicket "
                . " FROM report_bus_tb AS  B  WHERE "
                . " (B.passenger_factor_num='{$request_number}' OR B.order_code='{$request_number}') "
                . " AND (((B.passenger_factor_num OR B.order_code) > 0) OR ((B.passenger_factor_num OR B.order_code) <>'')) ";
            $result  = $Model->select( $sql );
            echo $info_cancel_sql = " SELECT 
                          cancel.NationalCode,
                            detail.*
                         FROM cancel_ticket_details_tb AS detail
                         INNER JOIN cancel_ticket_tb AS cancel ON cancel.idDetail = detail.id
                         WHERE detail.FactorNumber='{$request_number}' OR detail.RequestNumber='{$request_number}'  ";
            $info_cancel_detail= $admin->ConectDbClient( $info_cancel_sql, $result[0]['client_id'], "SelectAll", "", "", "" );

            $result['info_detail_cancel'] =   $info_cancel_detail ;

        } else {
            $Model = Load::library( 'Model' );
            $sql   = "SELECT B.*, "
                . " (SELECT COUNT(id) FROM book_bus_tb WHERE order_code = B.order_code) AS CountTicket "
                . " FROM book_bus_tb AS  B  WHERE "
                . " (B.passenger_factor_num='{$request_number}' OR B.order_code='{$request_number}') "
                . " AND (((B.passenger_factor_num OR B.order_code) > 0) OR ((B.passenger_factor_num OR B.order_code) <>'')) ";
            $result = $Model->select( $sql );
            $info_cancel_sql = " SELECT
                          cancel.NationalCode,
                            detail.*
                         FROM cancel_ticket_details_tb AS detail
                         INNER JOIN cancel_ticket_tb AS cancel ON cancel.idDetail = detail.id
                         WHERE detail.FactorNumber='{$request_number}' OR detail.RequestNumber='{$request_number}'  ";

            $result['info_detail_cancel'] =   $Model->select( $info_cancel_sql );
        }
     
        return $result ;
    }

    #endregion

    #region info_insurance_directions

    public static function info_insurance_directions( $request_number ) {
        if ( TYPE_ADMIN == '1' ) {
            $admin = Load::controller('admin');
            $Model = Load::library( 'ModelBase' );
            $sql   = "SELECT B.*, "
                . " (SELECT COUNT(id) FROM report_insurance_tb WHERE factor_number = B.factor_number) AS CountTicket "
                . " FROM report_insurance_tb AS  B  WHERE "
                . "  B.factor_number='{$request_number}'";

            $result = $Model->select( $sql );
            echo $info_cancel_sql = " SELECT 
                          cancel.NationalCode,
                            detail.*
                         FROM cancel_ticket_details_tb AS detail
                         INNER JOIN cancel_ticket_tb AS cancel ON cancel.idDetail = detail.id
                         WHERE detail.FactorNumber='{$request_number}' OR detail.RequestNumber='{$request_number}'  ";

            $info_cancel_detail= $admin->ConectDbClient( $info_cancel_sql, $result[0]['client_id'], "SelectAll", "", "", "" );

            $result['info_detail_cancel'] =   $info_cancel_detail ;

        } else {
            $Model = Load::library( 'Model' );
            $sql   = "SELECT B.*, "
                . " (SELECT COUNT(id) FROM book_insurance_tb WHERE factor_number = B.factor_number) AS CountTicket "
                . " FROM book_insurance_tb AS  B  WHERE "
                . " (B.factor_number='{$request_number}') ";

            $result = $Model->select( $sql );
            $info_cancel_sql = " SELECT 
                          cancel.NationalCode,
                            detail.*
                         FROM cancel_ticket_details_tb AS detail
                         INNER JOIN cancel_ticket_tb AS cancel ON cancel.idDetail = detail.id
                         WHERE detail.FactorNumber='{$request_number}' OR detail.RequestNumber='{$request_number}'  ";

            $result['info_detail_cancel'] =   $Model->select( $info_cancel_sql );
        }

        return $result ;
    }

    #endregion
    #region info_hotel_directions

    public static function info_hotel_directions( $request_number ) {
        if ( TYPE_ADMIN == '1' ) {
            $admin = Load::controller('admin');
            $Model = Load::library( 'ModelBase' );
            $sql   = "SELECT B.*, "
                . " (SELECT COUNT(id) FROM report_hotel_tb WHERE factor_number = B.factor_number) AS CountTicket "
                . " FROM report_hotel_tb AS  B  WHERE "
                . "  B.factor_number='{$request_number}'";

            $result = $Model->select( $sql );
            echo $info_cancel_sql = " SELECT 
                          cancel.NationalCode,
                            detail.*
                         FROM cancel_ticket_details_tb AS detail
                         INNER JOIN cancel_ticket_tb AS cancel ON cancel.idDetail = detail.id
                         WHERE detail.FactorNumber='{$request_number}' OR detail.RequestNumber='{$request_number}'  ";

            $info_cancel_detail= $admin->ConectDbClient( $info_cancel_sql, $result[0]['client_id'], "SelectAll", "", "", "" );

            $result['info_detail_cancel'] =   $info_cancel_detail ;

        } else {
            $Model = Load::library( 'Model' );
            $sql   = "SELECT B.*, "
                . " (SELECT COUNT(id) FROM book_hotel_local_tb WHERE factor_number = B.factor_number) AS CountTicket "
                . " FROM book_hotel_local_tb AS  B  WHERE "
                . " (B.factor_number='{$request_number}') ";

            $result = $Model->select( $sql );
            $info_cancel_sql = " SELECT 
                          cancel.NationalCode,
                            detail.*
                         FROM cancel_ticket_details_tb AS detail
                         INNER JOIN cancel_ticket_tb AS cancel ON cancel.idDetail = detail.id
                         WHERE detail.FactorNumber='{$request_number}' OR detail.RequestNumber='{$request_number}'  ";

            $result['info_detail_cancel'] =   $Model->select( $info_cancel_sql );
        }

        return $result ;
    }

    #endregion


    #region total_price

    public static function emailTemplateOld( $emailContent, $pdfButton = '' ) {

        $AgencyName = CLIENT_NAME;
        $Address    = CLIENT_ADDRESS;
        $Phone      = CLIENT_PHONE;
        $LogoUser   = ROOT_ADDRESS_WITHOUT_LANG . "/pic/" . LOGO_AGENCY;

        $template
            = '
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
	<head>
		<!-- NAME: 1 COLUMN -->
		<!--[if gte mso 15]>
		<xml>
			<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
			</o:OfficeDocumentSettings>
		</xml>
		<![endif]-->
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
    <style type="text/css">
		p{
			margin:10px 0;
			padding:0;
		}
		table{
			border-collapse:collapse;
		}
		h1,h2,h3,h4,h5,h6{
			display:block;
			margin:0;
			padding:0;
		}
		img,a img{
			border:0;
			height:auto;
			outline:none;
			text-decoration:none;
		}
		body,#bodyTable,#bodyCell{
			height:100%;
			margin:0;
			padding:0;
			width:100%;
		}
		.mcnPreviewText{
			display:none !important;
		}
		#outlook a{
			padding:0;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		table{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		.ReadMsgBody{
			width:100%;
		}
		.ExternalClass{
			width:100%;
		}
		p,a,li,td,blockquote{
			mso-line-height-rule:exactly;
		}
		a[href^=tel],a[href^=sms]{
			color:inherit;
			cursor:default;
			text-decoration:none;
		}
		p,a,li,td,body,table,blockquote{
			-ms-text-size-adjust:100%;
			-webkit-text-size-adjust:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
			line-height:100%;
		}
		a[x-apple-data-detectors]{
			color:inherit !important;
			text-decoration:none !important;
			font-size:inherit !important;
			font-family:inherit !important;
			font-weight:inherit !important;
			line-height:inherit !important;
		}
		#bodyCell{
			padding:10px;
			border-top:1px solid ;
		}
		.templateContainer{
			max-width:600px !important;
			border:0;
		}
		a.mcnButton{
			display:block;
		}
		.mcnImage,.mcnRetinaImage{
			vertical-align:bottom;
		}
		.mcnTextContent img{
			height:auto !important;
		}
		.mcnDividerBlock{
			table-layout:fixed !important;
		}
	/*
	@tab Page
	@section Background Style
	@tip Set the background color and top border for your email. You may want to choose colors that match your company\'s branding.
	*/
		body,#bodyTable{
			/*@editable*/background-color:#fcfffc;
		}
	/*
	@tab Page
	@section Background Style
	@tip Set the background color and top border for your email. You may want to choose colors that match your company\'s branding.
	*/
		#bodyCell{
			/*@editable*/border-top:1px solid ;
		}
	/*
	@tab Page
	@section Email Border
	@tip Set the border for your email.
	*/
		.templateContainer{
			/*@editable*/border:0;
		}
	/*
	@tab Page
	@section Heading 1
	@tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
	@style heading 1
	*/
		h1{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:26px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@section Heading 2
	@tip Set the styling for all second-level headings in your emails.
	@style heading 2
	*/
		h2{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:22px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@section Heading 3
	@tip Set the styling for all third-level headings in your emails.
	@style heading 3
	*/
		h3{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:20px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@section Heading 4
	@tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
	@style heading 4
	*/
		h4{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:18px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Preheader
	@section Preheader Style
	@tip Set the background color and borders for your email\'s preheader area.
	*/
		#templatePreheader{
			/*@editable*/background-color:#00b0b4;
			/*@editable*/background-image:none;
			/*@editable*/background-repeat:no-repeat;
			/*@editable*/background-position:center;
			/*@editable*/background-size:cover;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:28px;
			/*@editable*/padding-bottom:28px;
		}
	/*
	@tab Preheader
	@section Preheader Text
	@tip Set the styling for your email\'s preheader text. Choose a size and color that is easy to read.
	*/
		#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
			/*@editable*/color:#000000;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:18px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Preheader
	@section Preheader Link
	@tip Set the styling for your email\'s preheader links. Choose a color that helps them stand out from your text.
	*/
		#templatePreheader .mcnTextContent a,#templatePreheader .mcnTextContent p a{
			/*@editable*/color:#656565;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Header
	@section Header Style
	@tip Set the background color and borders for your email\'s header area.
	*/
		#templateHeader{
			/*@editable*/background-color:#00b0b4;
			/*@editable*/background-image:none;
			/*@editable*/background-repeat:no-repeat;
			/*@editable*/background-position:center;
			/*@editable*/background-size:cover;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:9px;
			/*@editable*/padding-bottom:0;
		}
	/*
	@tab Header
	@section Header Text
	@tip Set the styling for your email\'s header text. Choose a size and color that is easy to read.
	*/
		#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:16px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Header
	@section Header Link
	@tip Set the styling for your email\'s header links. Choose a color that helps them stand out from your text.
	*/
		#templateHeader .mcnTextContent a,#templateHeader .mcnTextContent p a{
			/*@editable*/color:#2BAADF;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Body
	@section Body Style
	@tip Set the background color and borders for your email\'s body area.
	*/
		#templateBody{
			/*@editable*/background-color:#00b0b4;
			/*@editable*/background-image:none;
			/*@editable*/background-repeat:no-repeat;
			/*@editable*/background-position:center;
			/*@editable*/background-size:cover;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:2px solid #EAEAEA;
			/*@editable*/padding-top:0;
			/*@editable*/padding-bottom:9px;
		}
	/*
	@tab Body
	@section Body Text
	@tip Set the styling for your email\'s body text. Choose a size and color that is easy to read.
	*/
		#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:16px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Body
	@section Body Link
	@tip Set the styling for your email\'s body links. Choose a color that helps them stand out from your text.
	*/
		#templateBody .mcnTextContent a,#templateBody .mcnTextContent p a{
			/*@editable*/color:#2BAADF;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Footer
	@section Footer Style
	@tip Set the background color and borders for your email\'s footer area.
	*/
		#templateFooter{
			/*@editable*/background-color:#2d445a;
			/*@editable*/background-image:none;
			/*@editable*/background-repeat:no-repeat;
			/*@editable*/background-position:center;
			/*@editable*/background-size:cover;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:9px;
			/*@editable*/padding-bottom:9px;
		}
	/*
	@tab Footer
	@section Footer Text
	@tip Set the styling for your email\'s footer text. Choose a size and color that is easy to read.
	*/
		#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
			/*@editable*/color:#ffffff;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:12px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:center;
		}
	/*
	@tab Footer
	@section Footer Link
	@tip Set the styling for your email\'s footer links. Choose a color that helps them stand out from your text.
	*/
		#templateFooter .mcnTextContent a,#templateFooter .mcnTextContent p a{
			/*@editable*/color:#656565;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	@media only screen and (min-width:768px){
		.templateContainer{
			width:600px !important;
		}

}	@media only screen and (max-width: 480px){
		body,table,td,p,a,li,blockquote{
			-webkit-text-size-adjust:none !important;
		}

}	@media only screen and (max-width: 480px){
		body{
			width:100% !important;
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		#bodyCell{
			padding-top:10px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnRetinaImage{
			max-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImage{
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{
			max-width:100% !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnBoxedTextContentContainer{
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupContent{
			padding:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
			padding-top:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
			padding-top:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardBottomImageContent{
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockInner{
			padding-top:0 !important;
			padding-bottom:0 !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockOuter{
			padding-top:9px !important;
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnTextContent,.mcnBoxedTextContentColumn{
			padding-right:18px !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
			padding-right:18px !important;
			padding-bottom:0 !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcpreview-image-uploader{
			display:none !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 1
	@tip Make the first-level headings larger in size for better readability on small screens.
	*/
		h1{
			/*@editable*/font-size:22px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 2
	@tip Make the second-level headings larger in size for better readability on small screens.
	*/
		h2{
			/*@editable*/font-size:20px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 3
	@tip Make the third-level headings larger in size for better readability on small screens.
	*/
		h3{
			/*@editable*/font-size:18px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 4
	@tip Make the fourth-level headings larger in size for better readability on small screens.
	*/
		h4{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Boxed Text
	@tip Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
		.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Preheader Visibility
	@tip Set the visibility of the email\'s preheader on small screens. You can hide it to save space.
	*/
		#templatePreheader{
			/*@editable*/display:block !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Preheader Text
	@tip Make the preheader text larger in size for better readability on small screens.
	*/
		#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Header Text
	@tip Make the header text larger in size for better readability on small screens.
	*/
		#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Body Text
	@tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
		#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Footer Text
	@tip Make the footer content text larger in size for better readability on small screens.
	*/
		#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:150% !important;
		}

}</style></head>
    <body>
		<!--*|IF:MC_PREVIEW_TEXT|*-->
		<!--[if !gte mso 9]><!----><span class="mcnPreviewText" style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;">*|MC_PREVIEW_TEXT|*</span><!--<![endif]-->
		<!--*|END:IF|*-->
        <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td align="center" valign="top" id="bodyCell">
                        <!-- BEGIN TEMPLATE // -->
						<!--[if (gte mso 9)|(IE)]>
						<table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
						<tr>
						<td align="center" valign="top" width="600" style="width:600px;">
						<![endif]-->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                            <tr>
                                <td valign="top" id="templatePreheader"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0;">
                                
                                <img align="right" alt="" src="'
            . $LogoUser
            . '" width="75" style="max-width:75px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                <p style="font-family: tahoma;font-size: 16px;color: #204a5f;font-weight: bold;text-align: right;">'
            . $AgencyName
            . '</p>
                            
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table class="mcnDividerBlock" style="min-width:100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                <table class="mcnDividerContent" style="min-width: 100%;border-top: 2px solid #EAEAEA;" width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateHeader"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:0px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 0px; padding-left: 0px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                
                                    
                                        <img align="center" alt="" src="https://gallery.mailchimp.com/641434b60f9790677f1aea12c/images/fbbc560f-5315-4cc9-8beb-94ae38f7261d.jpg" width="600" style="max-width:1500px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnRetinaImage">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateBody"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnBoxedTextBlock" style="min-width:100%;">
    <!--[if gte mso 9]>
	<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
	<![endif]-->
	<tbody class="mcnBoxedTextBlockOuter">
        <tr>
            <td valign="top" class="mcnBoxedTextBlockInner">
            
				<!--[if gte mso 9]>
				<td align="center" valign="top" ">
				<![endif]-->
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnBoxedTextContentContainer">
                    <tbody><tr>
                        
                        <td style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:18px;">
                        
                            <table border="0" cellspacing="0" class="mcnTextContentContainer" width="100%" style="min-width: 100% !important;background-color: #00B0B4;border: 2px solid #FFFFFF;">
                                <tbody>
                                    '
            . $emailContent
            . '
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody></table>
				<!--[if gte mso 9]>
				</td>
				<![endif]-->
    
				<!--[if gte mso 9]>
                </tr>
                </table>
				<![endif]-->
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
    <tbody class="mcnButtonBlockOuter">
        <tr>
            <td style="padding-top:0; padding-right:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonContentContainer" style="border-collapse: separate !important;">
                    <tbody>
                        '
            . $pdfButton
            . '
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateFooter"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 10px 18px 25px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top: 2px solid #EEEEEE;">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	<!--[if mso]>
				<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
				<tr>
				<![endif]-->
			 
				<!--[if mso]>
				<td valign="top" width="600" style="width:600px;">
				<![endif]-->
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <table border="0" cellpadding="0" cellspacing="0" class="m_-2679729263370124627mcnTextBlock" style="min-width:100%;border-collapse:collapse" width="100%">
	<tbody class="m_-2679729263370124627mcnTextBlockOuter">
		<tr>
			<td class="m_-2679729263370124627mcnTextBlockInner" style="padding-top:9px" valign="top">
			<table align="left" border="0" cellpadding="0" cellspacing="0" class="m_-2679729263370124627mcnTextContentContainer" style="max-width:100%;min-width:100%;border-collapse:collapse" width="100%">
				<tbody>
					<tr>
						<td class="m_-2679729263370124627mcnTextContent" style="padding-top:0;padding-right:18px;padding-bottom:9px;padding-left:18px;color:#ffffff;font-family:Helvetica;font-size:12px;line-height:150%;text-align:center" valign="top">
						<div style="text-align:right"><span style="color:#FFFFFF"><span class="im"><span style="font-size:12px"><strong><span style="font-family:tahoma,verdana,segoe,sans-serif">آدرس : '
            . $Address
            . '</span></strong></span></span></span></div>

						<div style="clear:both;text-align:right"><span style="color:#FFFFFF"><span class="im"><span style="font-size:12px"><strong><span style="font-family:tahoma,verdana,segoe,sans-serif">تلفن : '
            . $Phone
            . '</span></strong></span></span></span></div>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
	</tbody>
</table>

                        </td>
                    </tr>
                </tbody></table>
				<!--[if mso]>
				</td>
				<![endif]-->
    
				<!--[if mso]>
				</tr>
				</table>
				<![endif]-->
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                        </table>
						<!--[if (gte mso 9)|(IE)]>
						</td>
						</tr>
						</table>
						<![endif]-->
                        <!-- // END TEMPLATE -->
                    </td>
                </tr>
            </table>
    </body>
</html>
        ';

        return $template;

    }

    #endregion

    #region info_flight_directions

    public static function emailTemplate( $param ) {

        $template
            = '
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
        <!-- NAME: SELL PRODUCTS -->
        <!--[if gte mso 15]>
        <xml>
            <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
        <![endif]-->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>'.$param['pdf'][0]['button_title'].'</title>
        
    <style type="text/css">
        a{
            text-decoration:none !important;
        }
        p{
			margin:10px 0;
			padding:0;
		}table{
			border-collapse:collapse;
		}h1,h2,h3,h4,h5,h6{
			display:block;
			margin:0;
			padding:0;
		}img,a img{
			border:0;
			height:auto;
			outline:none;
			text-decoration:none;
		}body,#bodyTable,#bodyCell{
			height:100%;
			margin:0;
			padding:0;
			width:100%;
		}.mcnPreviewText{
			display:none !important;
		}#outlook a{
			padding:0;
		}img{
			-ms-interpolation-mode:bicubic;
		}table{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}.ReadMsgBody{
			width:100%;
		}.ExternalClass{
			width:100%;
		}p,a,li,td,blockquote{
			mso-line-height-rule:exactly;
		}a[href^=tel],a[href^=sms]{
			color:inherit;
			cursor:default;
			text-decoration:none;
		}p,a,li,td,body,table,blockquote{
			-ms-text-size-adjust:100%;
			-webkit-text-size-adjust:100%;
		}.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
			line-height:100%;
		}a[x-apple-data-detectors]{
			color:inherit !important;
			text-decoration:none !important;
			font-size:inherit !important;
			font-family:inherit !important;
			font-weight:inherit !important;
			line-height:inherit !important;
		}.templateContainer{
			max-width:600px !important;
		}a.mcnButton{
			display:block;
		}.mcnImage,.mcnRetinaImage{
			vertical-align:bottom;
		}.mcnTextContent{
			word-break:normal;
		}.mcnTextContent img{
			height:auto !important;
		}.mcnDividerBlock{
			table-layout:fixed !important;
		}h1{
			/*@editable*/color:#222222;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:40px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:150%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:center;
		}h2{
			/*@editable*/color:#222222;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:34px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:150%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}h3{
			/*@editable*/color:#444444;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:22px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:150%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}h4{
			/*@editable*/color:#949494;
			/*@editable*/font-family:Georgia;
			/*@editable*/font-size:20px;
			/*@editable*/font-style:italic;
			/*@editable*/font-weight:normal;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}#templateHeader{
			/*@editable*/background-color:#e9e9e9;
			/*@editable*/background-image:none;
			/*@editable*/background-repeat:no-repeat;
			/*@editable*/background-position:center;
			/*@editable*/background-size:cover;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:0px;
			/*@editable*/padding-bottom:0px;
		}.headerContainer{
			/*@editable*/background-color:transparent;
			/*@editable*/background-image:none;
			/*@editable*/background-repeat:no-repeat;
			/*@editable*/background-position:center;
			/*@editable*/background-size:cover;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:0;
			/*@editable*/padding-bottom:0;
		}.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
			/*@editable*/color:#757575;
			/*@editable*/font-family:Tahoma, Verdana, Segoe, sans-serif;
			/*@editable*/font-size:16px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:center;
		}.headerContainer .mcnTextContent a,.headerContainer .mcnTextContent p a{
			/*@editable*/color:#007C89;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}#templateBody{
			/*@editable*/background-color:#f5f5f5;
			/*@editable*/background-image:none;
			/*@editable*/background-repeat:no-repeat;
			/*@editable*/background-position:center;
			/*@editable*/background-size:cover;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:0px;
			/*@editable*/padding-bottom:0px;
		}.bodyContainer{
			/*@editable*/background-color:#ffffff;
			/*@editable*/background-image:none;
			/*@editable*/background-repeat:no-repeat;
			/*@editable*/background-position:center;
			/*@editable*/background-size:cover;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:0;
			/*@editable*/padding-bottom:0;
		}.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
			/*@editable*/color:#757575;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:16px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}.bodyContainer .mcnTextContent a,.bodyContainer .mcnTextContent p a{
			/*@editable*/color:#007C89;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}#templateFooter{
			/*@editable*/background-color:#333333;
			/*@editable*/background-image:none;
			/*@editable*/background-repeat:no-repeat;
			/*@editable*/background-position:center;
			/*@editable*/background-size:cover;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:15px;
			/*@editable*/padding-bottom:15px;
		}.footerContainer{
			/*@editable*/background-color:transparent;
			/*@editable*/background-image:none;
			/*@editable*/background-repeat:no-repeat;
			/*@editable*/background-position:center;
			/*@editable*/background-size:cover;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:0;
			/*@editable*/padding-bottom:0;
		}.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
			/*@editable*/color:#FFFFFF;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:12px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:center;
		}.footerContainer .mcnTextContent a,.footerContainer .mcnTextContent p a{
			/*@editable*/color:#FFFFFF;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}@media only screen and (min-width:768px){
		.templateContainer{
			width:600px !important;
        }
}@media only screen and (max-width: 480px){
		body,table,td,p,a,li,blockquote{
			-webkit-text-size-adjust:none !important;
		}
}@media only screen and (max-width: 480px){
		body{
			width:100% !important;
			min-width:100% !important;
		}
}@media only screen and (max-width: 480px){
		.mcnRetinaImage{
			max-width:100% !important;
		}
}@media only screen and (max-width: 480px){
		.mcnImage{
			width:100% !important;
		}
}@media only screen and (max-width: 480px){
		.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{
			max-width:100% !important;
			width:100% !important;
		}
}@media only screen and (max-width: 480px){
		.mcnBoxedTextContentContainer{
			min-width:100% !important;
		}
}@media only screen and (max-width: 480px){
		.mcnImageGroupContent{
			padding:9px !important;
		}
}@media only screen and (max-width: 480px){
		.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
			padding-top:9px !important;
		}
}@media only screen and (max-width: 480px){
		.mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
			padding-top:18px !important;
		}
}@media only screen and (max-width: 480px){
		.mcnImageCardBottomImageContent{
			padding-bottom:9px !important;
		}
}@media only screen and (max-width: 480px){
		.mcnImageGroupBlockInner{
			padding-top:0 !important;
			padding-bottom:0 !important;
		}
}@media only screen and (max-width: 480px){
		.mcnImageGroupBlockOuter{
			padding-top:9px !important;
			padding-bottom:9px !important;
		}
}@media only screen and (max-width: 480px){
		.mcnTextContent,.mcnBoxedTextContentColumn{
			padding-right:18px !important;
			padding-left:18px !important;
		}
}@media only screen and (max-width: 480px){
		.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
			padding-right:18px !important;
			padding-bottom:0 !important;
			padding-left:18px !important;
		}
}@media only screen and (max-width: 480px){
		.mcpreview-image-uploader{
			display:none !important;
			width:100% !important;
		}

}@media only screen and (max-width: 480px){
		h1{
			/*@editable*/font-size:30px !important;
			/*@editable*/line-height:125% !important;
		}
}@media only screen and (max-width: 480px){
		h2{
			/*@editable*/font-size:26px !important;
			/*@editable*/line-height:125% !important;
		}
}@media only screen and (max-width: 480px){
		h3{
			/*@editable*/font-size:20px !important;
			/*@editable*/line-height:150% !important;
        }
}@media only screen and (max-width: 480px){
		h4{
			/*@editable*/font-size:18px !important;
			/*@editable*/line-height:150% !important;
		}
}@media only screen and (max-width: 480px){
		.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:150% !important;
		}
}@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Header Text
	@tip Make the header text larger in size for better readability on small screens.
	*/
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:150% !important;
		}
}@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Body Text
	@tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
		.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:150% !important;
		}
}@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Footer Text
	@tip Make the footer content text larger in size for better readability on small screens.
	*/
    .footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:150% !important;
		}
}</style></head>
    <body>
        <!--*|IF:MC_PREVIEW_TEXT|*-->
        <!--[if !gte mso 9]><!----><span class="mcnPreviewText" style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;">'.CLIENT_MAIN_DOMAIN.' - '. CLIENT_PHONE .'</span><!--<![endif]-->
        <!--*|END:IF|*-->
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td align="center" valign="top" id="bodyCell">
                        <!-- BEGIN TEMPLATE // -->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td align="center" valign="top" id="templateHeader" data-template-container>
                                    <!--[if (gte mso 9)|(IE)]>
                                    <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                                    <tr>
                                    <td align="center" valign="top" width="600" style="width:600px;">
                                    <![endif]-->
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                        <tr>
                                            <td valign="top" class="headerContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCaptionBlock">
    <tbody class="mcnCaptionBlockOuter">
        <tr>
            <td class="mcnCaptionBlockInner" valign="top" style="padding:9px;">
            

<table border="0" cellpadding="0" cellspacing="0" class="mcnCaptionLeftContentOuter" width="100%">
    <tbody><tr>
        <td valign="top" class="mcnCaptionLeftContentInner" style="padding:18px 0px 9px 0px ;">
            <table align="right" border="0" cellpadding="0" cellspacing="0" class="mcnCaptionLeftImageContentContainer" height="80" width="264">
                <tbody><tr>
                    <td class="mcnCaptionLeftImageContent" align="right" valign="middle">
                        <a href="http://' . CLIENT_MAIN_DOMAIN . '/">
                            <img alt="" src="' . ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . LOGO_AGENCY . '" width="200" style="max-width:200px;max-height:200px;" class="mcnImage">
                        </a>
                    </td>
                </tr>
            </tbody></table>
            <table class="mcnCaptionLeftTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="264" height="80px">
                <tbody><tr>
        <td valign="middle" class="mcnCaptionLeftContentInner">

            <table class="mcnCaptionLeftTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="264" >
                <tbody><tr>
                    <td valign="top" class="mcnTextContent" style="text-align: left;">
					<img alt="" src="'.ROOT_ADDRESS_WITHOUT_LANG.'/view/client/assets/images/emails/telephone.png'.'" width="25" style="max-width:25px;" class="mcnImage">
                        <a href="tel: ' . CLIENT_PHONE . '" target="_blank">' . CLIENT_PHONE . '</a>
                    </td>
                </tr>
            </tbody></table>
        </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>


            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCodeBlock">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner">
                <div class="mcnTextContent"><span style="background:white;display:block;width:100%;padding-top:50px;margin-bottom:-5px"></span></div>
            </td>
        </tr>
    </tbody>
</table></td>
                                        </tr>
                                    </table>
                                    <!--[if (gte mso 9)|(IE)]>
                                    </td>
                                    </tr>
                                    </table>
                                    <![endif]-->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top" id="templateBody" data-template-container>
                                    <!--[if (gte mso 9)|(IE)]>
                                    <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                                    <tr>
                                    <td align="center" valign="top" width="600" style="width:600px;">
                                    <![endif]-->
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                        <tr>
                                            <td valign="top" class="bodyContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                        <img align="center" alt="" src="'.ROOT_ADDRESS_WITHOUT_LANG.'/view/client/assets/images/emails/flat-image.jpg'.'" width="459" style="max-width: 459px; padding-bottom: 0px; vertical-align: bottom; display: inline !important; border-radius: 0%;" class="mcnImage">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	<!--[if mso]>
				<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
				<tr>
				<![endif]-->
			 
				<!--[if mso]>
				<td valign="top" width="600" style="width:600px;">
				<![endif]-->
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; font-family: Tahoma, Verdana, Segoe, sans-serif; line-height: 200%;">
                        
                            <h3 style="text-align: center;">
                                <span style="font-family:tahoma,verdana,segoe,sans-serif;font-weight:normal">' . $param['title'] . '</span>
                            </h3>

                            <div style="direction: rtl; text-align: right;"><br>
                            <br>
                            <span style="font-family:tahoma,verdana,segoe,sans-serif">' . $param['body'] . '</div>

                        </td>
                    </tr>
                </tbody></table>
				<!--[if mso]>
				</td>
				<![endif]-->
    
				<!--[if mso]>
				</tr>
				</table>
				<![endif]-->
            </td>
        </tr>
    </tbody>
</table>';

        if ( isset( $param['pdf'] ) && ! empty( $param['pdf'] ) ) {

            foreach ( $param['pdf'] as $key=>$pdf ) {
                $template
                    .= '
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
                        <tbody class="mcnButtonBlockOuter">
                            <tr>
                                <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
                                    <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border: 0px none;border-radius: 6px;background-color: #009FC7;padding-bottom:3px;margin-bottom:25px;">
                                        <tbody>
                                            <tr>
                                                <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 18px;  padding: 13px 25px;">
                                                    <a class="mcnButton " title="'
                    . $pdf['button_title']
                    . '" href="'
                    . $param['pdf'][0]['url']
                    . '" target="_blank" style="font-weight: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">'
                    . $pdf['button_title']
                    . '</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>';
            }

        }


        $template
            .= '
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
                        <tbody class="mcnButtonBlockOuter">
                            <tr>
				                <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
                                    <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border: 0px none;border-radius: 6px;background-color: #009FC7;padding-bottom:3px;margin-bottom:25px;">
                                        <tbody>
                                            <tr>
                                                <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 18px;  padding: 13px 25px;">
                                                    <a class="mcnButton " href="http://' . CLIENT_MAIN_DOMAIN . '/" target="_blank" style="font-weight: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">صفحه اصلی سایت</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>';

        $template .= '
</td>
                                        </tr>
                                    </table>
                                    <!--[if (gte mso 9)|(IE)]>
                                    </td>
                                    </tr>
                                    </table>
                                    <![endif]-->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top" id="templateFooter" data-template-container>
                                    <!--[if (gte mso 9)|(IE)]>
                                    <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                                    <tr>
                                    <td align="center" valign="top" width="600" style="width:600px;">
                                    <![endif]-->
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                        <tr>
                                            <td valign="top" class="footerContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	<!--[if mso]>
				<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
				<tr>
				<![endif]-->
			 
				<!--[if mso]>
				<td valign="top" width="600" style="width:600px;">
				<![endif]-->
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody>
                    <tr>
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                            <div style="direction: rtl;margin-top:5px;">
							<span style="font-family:tahoma,verdana,segoe,sans-serif;font-size:16px;"><a href="http://' . CLIENT_MAIN_DOMAIN . '/"> ' . CLIENT_NAME . ' </a></span>
							<br>
							<br>
							<br>
							<span style="font-family:tahoma,verdana,segoe,sans-serif">آدرس : ' . CLIENT_ADDRESS . '</span>
							<br>
							<br>
							<span style="font-family:tahoma,verdana,segoe,sans-serif;display:block;">شماره تماس : <i style="font-style: normal;direction:ltr;display:inline-block">' . CLIENT_PHONE . '</i></span>
							</div>
                        </td>
                    </tr>
                    </tbody>
                </table>
				<!--[if mso]>
				</td>
				<![endif]-->
    
				<!--[if mso]>
				</tr>
				</table>
				<![endif]-->
            </td>
        </tr>
    </tbody>
</table></td>
                                        </tr>
                                    </table>
                                    <!--[if (gte mso 9)|(IE)]>
                                    </td>
                                    </tr>
                                    </table>
                                    <![endif]-->
                                </td>
                            </tr>
                        </table>
                        <!-- // END TEMPLATE -->
                    </td>
                </tr>
            </table>
        </center>
    </body>
    
</html>';

        return $template;
    }

    #endreegion

    #region info_flight_client

    public static function InfoAirline( $iata ) {
        /** @var airline_tb $airline */
        $airline = Load::model( 'airline' );
        return $airline->getByIata( $iata );
    }

    #endregion

    #region emailTemplate


    /**
     * @param $Date
     * @param $Type
     * @return false|string|string[]
     */
    public static function DateFormatType($Date, $Type ) {
        $DateParam = str_replace( '/', '-', $Date );
        if ( $Type == 'Jalali' ) {
            $DateJalali = functions::FormatDateJalali( $DateParam );
            $DateFormat = dateTimeSetting::jdate( "dF", $DateJalali );

        } else {
            $DateParam  = date_create( $DateParam );
            $DateFormat = date_format( $DateParam, "jM" );
        }

        return $DateFormat;
    }

    public static function FormatDateJalali( $param ) {
        str_replace( '/', '-', $param );
        $explode_date = explode( '-', $param );

        if ( $explode_date[0] > 1450 ) {
            $jmktime = mktime( 0, 0, 0, $explode_date[1], $explode_date[2], $explode_date[0] );
        } else {
            $jmktime = dateTimeSetting::jmktime( 0, 0, 0, $explode_date[1], $explode_date[2], $explode_date[0] );
        }

        return $jmktime;
    }

    #endregion

    #region InfoAirline

    public static function ConvertNumberToAlphabet( $str, $type = null ) {
        $Number    = array( '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', );
        $Letter    = array(
            functions::Xmlinformation( 'One' ),
            functions::Xmlinformation( 'Two' ),
            functions::Xmlinformation( 'Three' ),
            functions::Xmlinformation( 'Four' ),
            functions::Xmlinformation( 'Five' ),
            functions::Xmlinformation( 'Six' ),
            functions::Xmlinformation( 'Seven' ),
            functions::Xmlinformation( 'Eight' ),
            functions::Xmlinformation( 'Nine' ),
            functions::Xmlinformation( 'Zero' ),
        );
        if ( SOFTWARE_LANG == 'fa' ) {
            $LetterApp = array( 'اول', 'دوم', 'سوم', 'چهارم', 'پنجم', 'ششم', 'هفتم', 'هشتم', 'نهم', 'صفر', );
        }else if( SOFTWARE_LANG == 'ar' ) {
            $LetterApp = array( 'أولاً', 'ثانية', 'ثالث', 'الرابعة', 'الخامس', 'السادس', 'السابع', 'ثامن', 'تاسع', 'صفر', );
        }else{
            $LetterApp = array( 'first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth', 'ninth', 'zero', );
        }

        if ( $type == 'App' ) {
            return str_replace( $Number, $LetterApp, $str );
        } else {
            return str_replace( $Number, $Letter, $str );
        }
    }

    #endregion


    #region FormatDateJalali

    public static function calculatePriceForAdmin( $RequestNumber ) {
        $Flights = self::info_flight_client( $RequestNumber );

        $PriceTotal = 0;
        foreach ( $Flights as $flight ) {
            if ( $flight['adt_fare'] > 0 ) {
                if ( $flight['api_id'] == 10 || ( $flight['flight_type'] == 'system' && $flight['api_id'] != 10 ) ) {
                    $Price = $flight['supplier_commission'];
                } elseif ( $flight['flight_type'] == 'charter' && $flight['api_id'] != 10 ) {
                    $Price = $flight['supplier_commission'] + $flight['irantech_commission'];
                }
            } else {
                if ( $flight['flight_type'] == 'charter' && $flight['api_id'] != 10 ) {
                    $Price = $flight['supplier_commission'] + $flight['irantech_commission'];
                } elseif ( $flight['flight_type'] == 'system' && $flight['api_id'] != 10 ) {
                    $Price = ( $flight['adt_price'] + $flight['chd_price'] + $flight['inf_price'] ) - ( ( $flight['adt_price'] + $flight['chd_price'] + $flight['inf_price'] ) * ( 4573 / 100000 ) );
                } elseif ( $flight['api_id'] == 10 ) {
                    $Price = ( $flight['adt_price'] + $flight['chd_price'] + $flight['inf_price'] );
                }
            }


            $PriceTotal += $Price;
        }

        return round( $PriceTotal );


    }

    #endregion

    #region DateFormatType

    public static function info_flight_client( $request_number ) {
        if ( TYPE_ADMIN == '1' ) {
            $ModelBase = Load::library( 'ModelBase' );
            $sql       = "SELECT *, "
                . " (SELECT COUNT(id) FROM report_tb WHERE factor_number='{$request_number}' OR request_number='{$request_number}') AS CountId "
                . " FROM report_tb  WHERE (factor_number='{$request_number}' OR request_number='{$request_number}') "
                . " AND (((factor_number OR request_number) > 0) OR ((factor_number OR request_number) <>''))  ";
            $result    = $ModelBase->select( $sql );
        } else {
            $Model  = Load::library( 'Model' );
            $sql    = "SELECT *, "
                . " (SELECT COUNT(id) FROM book_local_tb WHERE factor_number='{$request_number}' OR request_number='{$request_number}') AS CountId "
                . " FROM book_local_tb  WHERE (factor_number='{$request_number}' OR request_number='{$request_number}') "
                . " AND (((factor_number OR request_number) > 0) OR ((factor_number OR request_number) <>''))";
            $result = $Model->select( $sql );
        }

        return $result;
    }


    #region DateFormatType

    public static function info_exclusive_tour_client( $request_number ) {
        if ( TYPE_ADMIN == '1' ) {
            $ModelBase = Load::library( 'ModelBase' );
            $sql       = "SELECT *, "
                . " (SELECT COUNT(id) FROM report_exclusive_tour_tb WHERE factor_number='{$request_number}' OR request_number='{$request_number}') AS CountId "
                . " FROM report_exclusive_tour_tb  WHERE (factor_number='{$request_number}' OR request_number='{$request_number}') "
                . " AND (((factor_number OR request_number) > 0) OR ((factor_number OR request_number) <>''))  ";
            $result    = $ModelBase->select( $sql );
        } else {
            $Model  = Load::library( 'Model' );
            $sql    = "SELECT *, "
                . " (SELECT COUNT(id) FROM book_exclusive_tour_tb WHERE factor_number='{$request_number}' OR request_number='{$request_number}') AS CountId "
                . " FROM book_exclusive_tour_tb  WHERE (factor_number='{$request_number}' OR request_number='{$request_number}') "
                . " AND (((factor_number OR request_number) > 0) OR ((factor_number OR request_number) <>''))";
            $result = $Model->select( $sql );
        }

        return $result;
    }

    #endregion


    #region GetInfoEuropcar

    public static function GetInfoEuropcar( $factorNumber ) {
        $factorNumber = trim( $factorNumber );

        if ( TYPE_ADMIN == '1' ) {
            $ModelBase = Load::library( 'ModelBase' );

            $sql    = "select *," . " (SELECT COUNT(id) FROM report_europcar_tb WHERE factor_number='$factorNumber') AS CountId " . " from report_europcar_tb  where factor_number='$factorNumber'  ";
            $result = $ModelBase->load( $sql );
        } else {
            Load::autoload( 'Model' );
            $Model = new Model();

            $sql    = "select *,"
                . " (SELECT COUNT(id) FROM book_europcar_local_tb WHERE factor_number='$factorNumber') AS CountId "
                . " from book_europcar_local_tb  where factor_number='$factorNumber' ";
            $result = $Model->load( $sql );
        }

        return $result;

    }

    #endregion


    #region calculatePriceForAdmin

    public static function GetInfoTour( $factorNumber , $is_api=false ) {
        $factorNumber = trim( $factorNumber );
      
        if ( TYPE_ADMIN == '1' || $is_api ) {
         
            $ModelBase = Load::library( 'ModelBase' );

            $sql    = "select *," . " (SELECT COUNT(id) FROM report_tour_tb WHERE factor_number='{$factorNumber}') AS CountId "
                . " from report_tour_tb  where factor_number='{$factorNumber}'  ";
            $result = $ModelBase->load( $sql );
        } else {
            Load::autoload( 'Model' );
            $Model = new Model();

             $sql    = "select *,"
                . " (SELECT COUNT(id) FROM book_tour_local_tb WHERE factor_number='{$factorNumber}') AS CountId "
                . " from book_tour_local_tb  where factor_number='{$factorNumber}' ";

            $result = $Model->load( $sql );
        }


        return $result;

    }

    #endregion


    #region GetInfoEuropcar

    public static function GetInfoTrain( $requestNumber ) {

        if ( TYPE_ADMIN == '1' ) {
            $ModelBase = Load::library( 'ModelBase' );

            $sql    = "select *," . " (SELECT COUNT(id) FROM report_train_tb WHERE requestNumber='{$requestNumber}' or factor_number='{$requestNumber}') AS CountId " . " from report_train_tb  where requestNumber='{$requestNumber}' or factor_number='{$requestNumber}'";
            $result = $ModelBase->select( $sql );
        } else {
            Load::autoload( 'Model' );
            $Model = new Model();

            $sql    = "select *," . " (SELECT COUNT(id) FROM book_train_tb WHERE requestNumber='{$requestNumber}' or factor_number='{$requestNumber}') AS CountId " . " from book_train_tb  where requestNumber='{$requestNumber} ' or factor_number='{$requestNumber}'";
            $result = $Model->select( $sql );
        }

        return $result;

    }

    #endregion


    #region GetInfoTour

    public static function GetInfoTourPassengers( $factorNumber ) {
        $factorNumber = trim( $factorNumber );

        if ( TYPE_ADMIN == '1' ) {
            $ModelBase = Load::library( 'ModelBase' );

            $sql    = "select *," . " (SELECT COUNT(id) FROM report_tour_tb WHERE factor_number='$factorNumber') AS CountId " . " from report_tour_tb  where factor_number='$factorNumber'  ";
            $result = $ModelBase->select( $sql );
        } else {
            Load::autoload( 'Model' );
            $Model = new Model();

            $sql    = "select *," . " (SELECT COUNT(id) FROM book_tour_local_tb WHERE factor_number='$factorNumber') AS CountId " . " from book_tour_local_tb  where factor_number='$factorNumber' ";
            $result = $Model->select( $sql );
        }

        return $result;

    }
    #endregion


    #region GetInfoTour

    public static function GetInfoEuropcarByTempReserveNumber( $tempReserveNumber ) {
        $tempReserveNumber = trim( $tempReserveNumber );

        if ( TYPE_ADMIN == '1' ) {
            $ModelBase = Load::library( 'ModelBase' );

            $sql    = "select *,"
                . " (SELECT COUNT(id) FROM report_europcar_tb WHERE temp_reserve_number='$tempReserveNumber') AS CountId "
                . " from report_europcar_tb  where temp_reserve_number='$tempReserveNumber'  ";
            $result = $ModelBase->load( $sql );
        } else {
            Load::autoload( 'Model' );
            $Model = new Model();

            $sql    = "select *,"
                . " (SELECT COUNT(id) FROM book_europcar_local_tb WHERE temp_reserve_number='$tempReserveNumber') AS CountId "
                . " from book_europcar_local_tb  where temp_reserve_number='$tempReserveNumber' ";
            $result = $Model->load( $sql );
        }

        return $result;

    }
    #endregion

    #region GetInfoTourPassengers

    public static function InfoBank() {

        $Model      = Load::library( 'Model' );
        $isCurrency = Session::getCurrency();
        //		if ( $isCurrency > 0 ) {
        //
        //			$sql = "SELECT * FROM bank_tb WHERE enable = '1' AND is_currency = '1' LIMIT 0,1";
        //			$res = $Model->select( $sql );
        //
        //		} else {
        //
        $sql = "SELECT * FROM bank_tb WHERE enable = '1' /*AND is_currency = '0'*/ GROUP BY bank_dir ORDER BY id";
        return $Model->select( $sql );

        //		}

    }
    #endregion


    #region GetInfoEuropcarByTempReserveNumber

    public static function infoDetailsForeign( $RequestNumber ) {
        $ModelBase    = Load::library( 'ModelBase' );
        $SqlDetail    = "SELECT * FROM report_routes_tb WHERE RequestNumber='{$RequestNumber}' ";
        $resultDetail = $ModelBase->select( $SqlDetail );

        return $resultDetail;
    }

    #endregion

    #region InfoBank

    public static function getListCityLocal() {
        $ModelBase = Load::library( 'ModelBase' );
        $Sql       = "SELECT * FROM hotel_cities_tb";
        $result    = $ModelBase->select( $Sql );

        return $result;
    }

    #endregion


    #region infoDetailsForeign

    public static function leaguePoints( $point ) {
        if ( $point <= 200 ) {
            return $point * 100;
        } elseif ( $point <= 500 ) {
            return $point * 150;
        } elseif ( $point <= 1000 ) {
            return $point * 200;
        } elseif ( $point <= 1500 ) {
            return $point * 300;
        } elseif ( $point <= 2000 ) {
            return $point * 350;
        } else {
            return $point * 500;
        }
    }

    #endregion


    #region getListCityLocal

    public static function cityIataList() {
        $Model = Load::library( 'Model' );

        $query  = " SELECT DISTINCT(Departure_Code) AS city_iata, Departure_City AS city_name FROM flight_route_tb WHERE local_portal = '0' ORDER BY priorityDeparture";
        $result = $Model->select( $query );

        return $result;
    }

    #endregion

    #region leaguePoints

    public static function setBankToBookByService( $serviceType, $bankDir, $factor_number ) {
        if ( is_array( $serviceType ) ) {
            //no matter witch value, because both are the same service group
            $service = reset( $serviceType );
        } else {
            $service = $serviceType;
        }

        $serviceController = Load::controller( 'services' );
        $serviceInfo       = $serviceController->getServiceByTitle( $service );

        switch ( $serviceInfo['groupService'] ) {
            case 'Flight':
                $controller = Load::controller( 'parvazBookingLocal' );
                $controller->setPortBankForReservationTicket( $bankDir, $factor_number );
                $controller->sendUserToBankForReservationTicket( $factor_number );
                break;

            case 'Hotel':
                $controller = Load::controller( 'BookingHotelLocal' );
                $controller->setPortBankForHotel( $bankDir, $factor_number );
                $controller->sendUserToBankForHotel( $factor_number );
                break;

            case 'Insurance':
                $controller = Load::controller( 'bookingInsurance' );
                $controller->setPortBankInsurance( $bankDir, $factor_number );
                $controller->sendUserToBankForInsurance( $factor_number );
                break;

            case 'Europcar':
                $controller = Load::controller( 'BookingEuropcarLocal' );
                $controller->setPortBankForCar( $bankDir, $factor_number );
                $controller->sendUserToBankForCar( $factor_number );
                break;

            /*case 'GashtTransfer':
                break;

            case 'Tour':
                break;

            */

            case 'Visa':
                $controller = Load::controller( 'BookingVisa' );
                $controller->setPortBankVisa( $bankDir, $factor_number );
                $controller->sendUserToBankForVisa( $factor_number );
                break;
        }

    }

    #endregion


    #region TotalPriceCancelTicketSystem

    public static function TotalPriceCancelTicketSystem( $InfoTicketsCancel ) {

        $amount = 0;
        $fare   = 0;

        foreach ( $InfoTicketsCancel as $each ) {

            //در هر رکورد فقط یکی از قیمت ها با توجه به سن مقدار دارد و دوتای دیگر صفر هستند
            if ( strtolower( $each['flight_type'] ) == 'system' ) {
                $amount += $each['adt_price'] + $each['chd_price'] + $each['inf_price'];
                if ( $each['adt_fare'] > 0 || $each['chd_fare'] > 0 || $each['inf_fare'] > 0 ) {
                    $fare += $each['adt_fare'] + $each['chd_fare'] + $each['inf_fare'];
                } else {
                    $fare = 0;
                }

            } else {
                $everyAmount = $each['api_commission'] + $each['adt_price'] + $each['chd_price'] + $each['inf_price'];

                if ( $each['price_change'] > 0 && $each['price_change_type'] == 'percent' ) {
                    $ChangeAmount = $everyAmount * ( $each['price_change'] / 100 );
                    $everyAmount  += $ChangeAmount;
                    if ( $each['passenger_age'] == 'Adt' || $each['passenger_age'] == 'Chd' ) {
                        $amount += $everyAmount - ( ( $ChangeAmount * $each['percent_discount'] ) / 100 );
                    } else if ( $each['passenger_age'] == 'Inf' ) {
                        $amount += $everyAmount;
                    }
                } else {
                    if ( $each['passenger_age'] == 'Adt' || $each['passenger_age'] == 'Chd' ) {
                        $ChangeAmount = 0;
                        $amount       += $everyAmount - ( ( $ChangeAmount * $each['percent_discount'] ) / 100 );
                    } else if ( $each['passenger_age'] == 'Inf' ) {
                        $amount += $everyAmount;
                    }
                }
                $fare = 0;
            }
        }

        return array( round( $amount ), $fare );

    }

    #endregion


        #region TotalPriceNetTicketCharter

    public static function TotalPriceNetTicketCharter( $InfoTicketsCancel ) {

        $amount = 0;

        foreach ( $InfoTicketsCancel as $each ) {

            //در هر رکورد فقط یکی از قیمت ها با توجه به سن مقدار دارد و دوتای دیگر صفر هستند
            if ( strtolower( $each['flight_type'] ) == 'charter' ) {

                $amount += $each['adt_price'] + $each['chd_price'] + $each['inf_price'];

            }
        }

        return round( $amount );

    }

    #endregion
    #region CalculatePenaltyPriceCancel

    /**
     * @param $Price
     * @param $fare
     * @param $InfoCancel
     *
     * @return float|int
     */
    public static function CalculatePenaltyPriceCancel( $Price, $fare, $InfoCancel ) {

        
        if ( $fare <= 0 ) {
            /** @var TYPE_NAME $fare */
            $fare = $Price - ( ( $Price * 4573 ) / 100000 );
        }

        $percentPublic = self::percentPublic();
        if ( $InfoCancel['pid_private'] == '0' ) {
            $PricePenalty = $Price - ( ( $fare ) * ( $InfoCancel['PercentIndemnity'] / 100 ) ) - ( $fare * ( $percentPublic ) );
        } else {
            $PricePenalty = $Price - ( $fare * ( $InfoCancel['PercentIndemnity'] / 100 ) );
        }

        return $PricePenalty;
    }

    #endregion

    #region CalculatePenaltyPriceCancelCharter
    public static function CalculatePenaltyPriceCancelCharter($Price, $InfoCancel) {
       /* if ( $InfoCancel['pid_private'] == '0' ) {
            return 0;
        }*/


        return ($Price - ($Price * (intval($InfoCancel['PercentIndemnity']) / 100 )));

    }
    #endregion

    #region setBankToBookByService

    public static function SourceIdPublic() {
        return array( '11', '13', '8' );

    }

    #endregion

    #region numberFormat

    public static function numberFormat( $num ,$currency_code = null ) {
//		$isINT = filter_var( $num, FILTER_VALIDATE_INT );

        return (Session::getCurrency() > 0 || $currency_code > 0) ? number_format($num,2) : number_format($num);

        //return ((is_numeric($num) && !empty($isINT)) ? number_format($num) : number_format($num, 2));
//		return ( ( ( is_numeric( $num ) && ! empty( $isINT ) ) || strspn( $num, "0", strpos( $num, "." ) + 1 ) ) ? number_format( $num ) : number_format( $num, 2 ) );
    }

    #endregion

    #region InfoRouteApp

    public static function InfoRouteApp( $Param, $Type ) {
        Load::autoload( 'ModelBase' );

        $ModelBase = new ModelBase();

        if ( $Type == 'Local' ) {
            $Sql
                = " SELECT Departure_Code,Departure_City,Departure_CityEn FROM flight_route_tb WHERE local_portal='0' AND (Departure_Code='{$Param}' OR Departure_Code LIKE '%{$Param}%' OR Departure_City LIKE '%{$Param}%' OR Departure_CityEn LIKE '%{$Param}%') GROUP BY  Departure_Code";
        } else {
            $Sql
                = " SELECT * FROM flight_portal_tb WHERE DepartureCode='{$Param}' OR DepartureCode LIKE '%{$Param}%' OR AirportFa LIKE '%{$Param}%'OR AirportEn LIKE '%{$Param}%' OR DepartureCityFa LIKE '%{$Param}%' OR DepartureCityEn LIKE '%{$Param}%' OR CountryFa  LIKE '%{$Param}%' OR CountryEn  LIKE '%{$Param}%' GROUP BY  DepartureCode";
        }

        $result = $ModelBase->select( $Sql );
        if ( $Type == 'Foreign' ) {
            foreach ( $result as $res ) {
                $ForeignResult['DepartureCode']   = $res['DepartureCode'];
                $ForeignResult['DepartureCityFa'] = $res['DepartureCityFa'] . '-' . $res['AirportFa'] . '-(' . $res['DepartureCode'] . ')';

                $resultFinalForeign[] = $ForeignResult;
            }

            $result = $resultFinalForeign;
        }

        return $result;
    }

    #endregion

    #region numberFormat: number_format a number by its type (int or float)

    public static function array_filter_by_value( $my_array, $index, $value ) {
        $new_array = array();
        if ( is_array( $my_array ) && count( $my_array ) > 0 ) {
            foreach ( array_keys( $my_array ) as $key ) {
                $temp[ $key ] = $my_array[ $key ][ $index ];

                if ( $temp[ $key ] == $value ) {
                    $new_array[ $key ] = $my_array[ $key ];
                }
            }
        }

        return $new_array;
    }
    #endregion


    #region InfoRouteApp

    public static function OtherFormatDate( $param, $type = null ) {

        if (empty($param)) {
            return "";
        }

        $explode_date = explode( '-', $param );

        if ( $explode_date[0] > 1450 ) {
            $jmktime = mktime( '0', '0', '0', $explode_date[1], $explode_date['2'], $explode_date[0] );
        } else {
            $jmktime = dateTimeSetting::jmktime( 0, 0, 0, $explode_date[1], $explode_date[2], $explode_date[0] );
        }


        $Date['NowDay'] = dateTimeSetting::jdate( " j F Y", $jmktime );
        if ( empty( $type ) ) {
            $Date['DepartureDate'] = dateTimeSetting::jdate( "Y-m-d", $jmktime, '', '', 'en' );
        } else if ( $type == 'TwoWay' ) {
            $Date['ReturnDate'] = dateTimeSetting::jdate( "Y-m-d", $jmktime, '', '', 'en' );
        }
        $Date['LetterDay'] = dateTimeSetting::jdate( "l", $jmktime );

        return $Date;
    }

    #endregion

    #region array_filter_by_value

    public static function AirPlaneType( $param ) {

        $air_plan = new ModelBase();

        $sql = " SELECT   name_fa  FROM airplan_type  WHERE name_en='{$param}'  ";


        $type = $air_plan->load( $sql );

        return ! empty( $type['name_fa'] ) ? $type['name_fa'] : $param;
    }

    #endregion

    #region DateJalali

    public static function CalculatePriceDetailApp( $UniqCode ) {
        $model   = Load::model( 'temporary_local' );
        $records = $model->get( $UniqCode );
        foreach ( $records as $direction => $rec ) {
            $Data['PriceChange'][ $direction ]     = $rec['PriceChange'];
            $Data['PriceChangeType'][ $direction ] = $rec['PriceChangeType'];


            $AdtPriceByChange = self::setPriceChanges( $rec['Airline_IATA'], $rec['FlightType'], $rec['AdtPrice'], $rec['AdtFare'], ( $rec['IsInternalFlight'] == '1' ) ? 'Local' : 'Portal',
                strtolower( $rec['FlightType'] ) == 'system' ? '' : 'public' );
            $ChdPriceByChange = self::setPriceChanges( $rec['Airline_IATA'], $rec['FlightType'], $rec['ChdPrice'], $rec['ChdFare'], ( $rec['IsInternalFlight'] == '1' ) ? 'Local' : 'Portal',
                strtolower( $rec['FlightType'] ) == 'system' ? '' : 'public' );
            $InfPriceByChange = self::setPriceChanges( $rec['Airline_IATA'], $rec['FlightType'], $rec['InfPrice'], $rec['InfFare'], ( $rec['IsInternalFlight'] == '1' ) ? 'Local' : 'Portal',
                strtolower( $rec['FlightType'] ) == 'system' ? '' : 'public' );


            $AdtPriceByChangeExploded = explode( ':', $AdtPriceByChange );
            $ChdPriceByChangeExploded = explode( ':', $ChdPriceByChange );
            $InfPriceByChangeExploded = explode( ':', $InfPriceByChange );

            //            $InfoCurrencyAdult = functions::CurrencyCalculate($AdtPriceByChangeExploded[1],$rec['CurrencyCode']);
            //            $InfoCurrencyChild = functions::CurrencyCalculate($ChdPriceByChangeExploded[1],$rec['CurrencyCode']);
            //            $InfoCurrencyInfant = functions::CurrencyCalculate($InfPriceByChangeExploded[1],$rec['CurrencyCode']);


            $Data['AdtPrice'][ $direction ]     = ( strtolower( $AdtPriceByChangeExploded[2] ) == 'yes' ) ? $AdtPriceByChangeExploded[0] :
                $AdtPriceByChangeExploded[1];//$InfoCurrencyAdult['AmountCurrency'];
            $Data['ChdPrice'][ $direction ]     = ( strtolower( $ChdPriceByChangeExploded[2] ) == 'yes' ) ? $ChdPriceByChangeExploded[0] :
                $ChdPriceByChangeExploded[1];//$InfoCurrencyAdult['AmountCurrency'];// $InfoCurrencyChild['AmountCurrency'];
            $Data['InfPrice'][ $direction ]     = ( strtolower( $InfPriceByChangeExploded[2] ) == 'yes' ) ? $InfPriceByChangeExploded[0] :
                $InfPriceByChangeExploded[1];//$InfoCurrencyInfant['AmountCurrency'];
            $Data['AdtPriceType'][ $direction ] = 'ریال';//$InfoCurrencyAdult['TypeCurrency'];

            //            $InfoCurrencyAdultByChange = functions::CurrencyCalculate($AdtPriceByChangeExploded[0],$rec['CurrencyCode']);
            //            $InfoCurrencyChildByChange = functions::CurrencyCalculate($ChdPriceByChangeExploded[0],$rec['CurrencyCode']);
            //
            //            $Data['AdtPriceByChange'][$direction] = $InfoCurrencyAdultByChange['AmountCurrency'];
            //            $Data['ChdPriceByChange'][$direction] = $InfoCurrencyChildByChange['AmountCurrency'];
            //            $Data['InfPriceByChange'][$direction] = $Data['InfPrice'][$direction];

            $Data['TotalPrice'] += ( $rec['Adt_qty'] * $Data['AdtPrice'][ $direction ] ) + ( $rec['Chd_qty'] * $Data['ChdPrice'][ $direction ] ) + ( $rec['Inf_qty']
                    * $Data['InfPrice'][ $direction ] );
            //$DataInfo[]=$Data;
        }

        return $Data;
    }

    #endregion

    #region AirPlaneType

    public static function cancelingRulesApp( $Airline, $CabinType ) {

        $Fee = self::FeeCancelFlight( $Airline, $CabinType );

        return $Fee;

    }

    #endregion

    #region CalculatePriceDetailApp

    public static function getVisaServiceType() {
        //امکان این هست که روزی وب سرویس ویزا اضافه گردد
        // پس این پیشبینی شد که سرویس های آن اضافه شوند
        return 'PrivateVisa';
    }

    #endregion


    #region cancelingRulesApp

    public static function getTrainServiceType() {
        //امکان این هست که روزی وب سرویس قطار اضافه گردد
        // پس این پیشبینی شد که سرویس های آن اضافه شوند
        return 'PrivateTrain';
    }

    #endregion


    #region getVisaServiceType

    /**
     * @param $jsonData
     *
     * @return bool|mixed|string
     */
    public static function clearJsonHiddenCharacters( $jsonData ) {
        // This will remove unwanted characters.
        // Check http://www.php.net/chr for details
        for ( $i = 0; $i <= 31; ++ $i ) {
            $jsonData = str_replace( chr( $i ), "", $jsonData );
        }

        $jsonData = str_replace( chr( 127 ), "", $jsonData );
        $jsonData = str_replace('﻿','',$jsonData);
     
        // This is the most common part
        // Some file begins with 'efbbbf' to mark the beginning of the file. (binary level)
        // here we detect it and we remove it, basically it's the first 3 characters
        if ( 0 === strpos( bin2hex( $jsonData ), 'efbbbf' ) ) {
            $jsonData = substr( $jsonData, 3 );
        }
        $jsonData = mb_convert_encoding($jsonData, 'UTF-8', 'UTF-8');

        return $jsonData;
    }

    #endregion


    #region getVisaServiceType

    public static function DateNext( $param, $day = null ) {
        $explode = explode( '-', $param );

        if ( $explode[0] > 1450 ) {
            $jmktime = mktime( '0', '0', '0', $explode[1], $explode['2'], $explode[0] );
        } else {
            $jmktime = dateTimeSetting::jmktime( 0, 0, 0, $explode[1], $explode[2], $explode[0] );
        }

        if ( isset( $day ) && $day != '' ) {
            $timestamp = $day * 24 * 60 * 60;
            if ( $explode[0] > 1450 ) {
                return strftime("%Y-%m-%d", $jmktime + $timestamp);
            }
            return dateTimeSetting::jstrftime( "%Y-%m-%d", $jmktime + $timestamp, '', '', 'en' );
        } else {
            if ( $explode[0] > 1450 ) {
                return strftime("%Y-%m-%d", $jmktime + (24 * 60 * 60));
            }
            return dateTimeSetting::jstrftime("%Y-%m-%d", $jmktime + (24 * 60 * 60), '', '', 'en');
        }

    }

    #endregion

    #region clearJsonHiddenCharacters

    public static function DatePrev( $param, $day = null ) {
        $explode = explode( '-', $param );
        if ( $explode[0] > 1450 ) {
            $jmktime = mktime( '0', '0', '0', $explode[1], $explode['2'], $explode[0] );
        } else {
            $jmktime = dateTimeSetting::jmktime( 0, 0, 0, $explode[1], $explode[2], $explode[0] );
        }

        $timestamp = ( 24 * 60 * 60 );
        if ( isset( $day ) && $day != '' ) {
            $timestamp = $day * 24 * 60 * 60;
        }
        if ( isset( $day ) && $day != '' ) {
            $timestamp = $day * 24 * 60 * 60;
            if ( $explode[0] > 1450 ) {
                return strftime("%Y-%m-%d", $jmktime - $timestamp);
            }
            return dateTimeSetting::jstrftime( "%Y-%m-%d", $jmktime - $timestamp, '', '', 'en' );
        } else {
            if ( $explode[0] > 1450 ) {
                return strftime("%Y-%m-%d", $jmktime - (24 * 60 * 60));
            }
            return dateTimeSetting::jstrftime("%Y-%m-%d", $jmktime - (24 * 60 * 60), '', '', 'en');
        }


    }
    #endregion


    #region DateNext
    //todo: exist in resultLocal controller, please delete this function  in resultLocal
    public static function indate( $param ) {
        $time_now = time();
        $explode_time = explode( '-', $param );
        if ( $explode_time[0] > 1450 ) {
            $jmk_time = mktime( 0, 0, 0, $explode_time[1], $explode_time[2], $explode_time[0] );
        } else {
            $jmk_time = dateTimeSetting::jmktime( 0, 0, 0, $explode_time[1], $explode_time[2], $explode_time[0] );
        }

        if ($jmk_time > $time_now) {
            return true;
        } else {
            return false;
        }
    }

    #endregion

    #region DatePrev

    public static function convertJalaliDateToGregInt( $param ,$mode='-') {
        $explode_jalali_date = explode( $mode, $param );
        
        $date    = dateTimeSetting::jalali_to_gregorian( $explode_jalali_date[0], $explode_jalali_date[1], $explode_jalali_date[2] );
        return mktime( 0, 0, 0, $date[1], $date[2], $date[0] );

    }

    #endregion

    #region titleHeadGds

    public static function titleHeadGds() {
        switch ( GDS_SWITCH ) {
            case 'loginUser':
                $title = functions::Xmlinformation( 'LoginToProfile' );
                break;
            case 'registerUser':
                $title = functions::Xmlinformation( 'SetAccount' );
                break;
            case 'UserTracking':
                $title = functions::Xmlinformation( 'TrackOrder' );
                break;
        }

        return $title;
    }

    #endregion

    #region isReserveByStopTime

    public static function isReserveByStopTime( $exitHour, $stopTimeReserve, $startDate ) {
        if ( strpos( $startDate, "-" ) ) {
            $startDate = str_replace( "-", "", $startDate );
        }
        $dateNow     = dateTimeSetting::jdate( "Ymd", '', '', '', 'en' );
        $timeHour    = date( "H" );
        $timeMinutes = date( "i" );
        $timeNow     = ( $timeHour * 60 ) + $timeMinutes;

        $expExitHour   = explode( ":", $exitHour );
        $exitTime      = ( $expExitHour[0] * 60 ) + $expExitHour[1];
        $timeOnRequest = ( $stopTimeReserve * 60 ) + $timeNow;

        if ( $stopTimeReserve < 0 && $stopTimeReserve > 25 ) {
            $stopTimeReserve = 24;
        }
        //$result = $startDate . ' - ' . $dateNow . ' - ' . $exitTime . ' - ' . $timeOnRequest . '<hr>';
        if ( ( $startDate == $dateNow && $exitTime > $timeOnRequest ) || ( $startDate > $dateNow ) ) {
            return true;
        } else {
            return false;
        }


    }
    #endregion


    #region titleHeadGds

    public static function Os() {
        $os_array = array(
            '/windows nt 10/i'      => 'Windows 10',
            '/windows nt 6.3/i'     => 'Windows 8.1',
            '/windows nt 6.2/i'     => 'Windows 8',
            '/windows nt 6.1/i'     => 'Windows 7',
            '/windows nt 6.0/i'     => 'Windows Vista',
            '/windows nt 5.2/i'     => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     => 'Windows XP',
            '/windows xp/i'         => 'Windows XP',
            '/windows nt 5.0/i'     => 'Windows 2000',
            '/windows me/i'         => 'Windows ME',
            '/win98/i'              => 'Windows 98',
            '/win95/i'              => 'Windows 95',
            '/win16/i'              => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i'        => 'Mac OS 9',
            '/linux/i'              => 'Linux',
            '/ubuntu/i'             => 'Ubuntu',
            '/iphone/i'             => 'iPhone',
            '/ipod/i'               => 'iPod',
            '/ipad/i'               => 'iPad',
            '/android/i'            => 'Android',
            '/blackberry/i'         => 'BlackBerry',
            '/webos/i'              => 'Mobile',
        );

        return $os_array;
    }
    #endregion


    #region isReserveByStopTime

    public static function getAgencyRate( $agencyId ) {
        $Model      = new Model();
        $sql        = " SELECT * FROM sniper_rate_tb WHERE page = 'agency'  AND fk_id_page = '{$agencyId}' ";
        $resultRate = $Model->load( $sql );

        return $resultRate;
    }
    #endregion


    #region OS

    public static function getServicesAgency() {
        $ModelBase      = new ModelBase();
        $services       = array();
        $query
            = "SELECT
                      services_group.Title, services_group.MainService
                  FROM
                      client_auth_tb AS AUTH
                      INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                      INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                      INNER JOIN services_group_tb AS services_group ON services_group.id = SERVICE.ServiceGroupId
                  WHERE
                     AUTH.ClientId = '" . CLIENT_ID . "' AND AUTH.IsActive='Active'
                  GROUP BY
	                SERVICE.ServiceGroupId
                  ORDER BY
                    SERVICE.id
                  ";
        $resultServices = $ModelBase->select( $query );
        foreach ( $resultServices as $val ) {
            $services[ strtolower( $val['MainService'] ) ] = $val['Title'];
        }
        return $services;
    }
    #endregion


    #region getAgencyRate

    public static function getTourCancellationRules( $tourCode ) {
        $Model  = new Model();
        $sql    = " SELECT cancellation_rules FROM reservation_tour_tb WHERE tour_code = '{$tourCode}' ";
        $result = $Model->load( $sql );

        return $result['cancellation_rules'];
    }
    #endregion


    #region getServicesAgency

    public static function getValueFields( $tableName, $fields, $conditions ) {
        $Model  = new Model();
        $sql    = " SELECT {$fields} FROM {$tableName} WHERE {$conditions} ";
        $result = $Model->load( $sql );

        return $result;
    }
    #endregion


    #region getTourCancellationRules

    public static function getValueFieldsFromBase( $tableName, $fields, $conditions ) {
        $ModelBase = new ModelBase();
        $sql       = " SELECT {$fields} FROM {$tableName} WHERE {$conditions} ";
        $result    = $ModelBase->load( $sql );

        return $result;
    }
    #endregion


    #region getValueFields

    public static function GetInfoGasht( $factorNumber ) {
        $factorNumber = trim( $factorNumber );

        if ( TYPE_ADMIN == '1' ) {
            $ModelBase = Load::library( 'ModelBase' );

            $sql    = "select *,"
                . " (SELECT COUNT(id) FROM report_gasht_tb WHERE passenger_factor_num='$factorNumber') AS CountId "
                . " from report_gasht_tb  where passenger_factor_num='$factorNumber'  ";
            $result = $ModelBase->load( $sql );
        } else {
            Load::autoload( 'Model' );
            $Model = new Model();

            $sql    = "select *,"
                . " (SELECT COUNT(id) FROM book_gasht_local_tb WHERE passenger_factor_num='$factorNumber') AS CountId "
                . " from book_gasht_local_tb  where passenger_factor_num='$factorNumber' ";
            $result = $Model->load( $sql );
        }

        return $result;

    }
    #endregion

    #region getValueFieldsFromBase

    static function CallAPI( $token, $chatId, $text, $method, $https = false, $data = false ) {
        $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatId&parse_mode=HTML&text=$text";

        $curl = curl_init();

        switch ( $method ) {
            case "POST":
                curl_setopt( $curl, CURLOPT_POST, 1 );

                if ( $data ) {
                    curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );
                }
                break;
            case "PUT":
                curl_setopt( $curl, CURLOPT_PUT, 1 );
                break;
            default:
                if ( $data ) {
                    $url = sprintf( "%s?%s", $url, http_build_query( $data ) );
                }
        }


        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl, CURLOPT_URL, $url );
        curl_setopt( $curl, CURLOPT_CERTINFO, $https );

        return $result = curl_exec( $curl );
    }
    #endregion


    #region GetInfoGaasht

    public static function getCompanyBusPhoto( $nameCompany ) {
        $ModelBase = Load::library( 'ModelBase' );
        $sql
            = "
        SELECT
            baseCompany.logo AS logo
        FROM
            base_company_bus_tb AS baseCompany
            LEFT JOIN company_bus_tb AS company ON baseCompany.id = company.id_base_company
        WHERE
            baseCompany.type_vehicle = 'bus'
            AND (company.name_fa LIKE '%{$nameCompany}%' OR baseCompany.name_fa LIKE '%{$nameCompany}%')
            AND baseCompany.is_del = 'no'
            AND company.is_del = 'no'
        GROUP BY
	        baseCompany.logo
        ";
        $result    = $ModelBase->load( $sql );
        if ( ! empty( $result ) && $result['logo'] != '' ) {
            return ROOT_ADDRESS_WITHOUT_LANG . "/pic/companyBusImages/" . $result['logo'];
        } else {
            return ROOT_ADDRESS_WITHOUT_LANG . "/pic/companyBusImages/no-photo.png";
        }
    }
    #endregion


    #region  author NorBaghaei

    #region SendDataInTelegram

    public static function getAllCompanyBus() {
        $ModelBase = Load::library( 'ModelBase' );
        $sql
            = "
        SELECT
            id,
            name_fa
        FROM
            base_company_bus_tb
        WHERE
            is_del = 'no' UNION
        SELECT
            baseCompany.id AS id,
            company.name_fa AS name_fa
        FROM
            base_company_bus_tb AS baseCompany
            LEFT JOIN company_bus_tb AS company ON baseCompany.id = company.id_base_company
        WHERE
            baseCompany.type_vehicle = 'bus'
            AND baseCompany.is_del = 'no'
            AND company.is_del = 'no'
        ";
        $result    = $ModelBase->select( $sql );

        return $result;
    }
    #endregion

    #region getCompanyBusPhoto

    public static function getIdBaseCompanyBus( $nameCompany ) {
        $ModelBase = Load::library( 'ModelBase' );
        $sql
            = "
        SELECT
            baseCompany.id AS id
        FROM
            base_company_bus_tb AS baseCompany
            LEFT JOIN company_bus_tb AS company ON baseCompany.id = company.id_base_company
        WHERE
            baseCompany.type_vehicle = 'bus'
            AND (company.name_fa LIKE '%{$nameCompany}%' OR baseCompany.name_fa LIKE '%{$nameCompany}%')
            AND baseCompany.is_del = 'no'
            AND company.is_del = 'no'
        GROUP BY
	        baseCompany.id
        ";
        $result    = $ModelBase->load( $sql );

        return $result;
    }
    #endregion

    #region getAllCompanyBus

    public static function getCompanyTrainById( $code ) {
        $ModelBase = Load::library( 'ModelBase' );
        $sql
            = "SELECT name_fa FROM base_company_bus_tb
                WHERE type_vehicle = 'train' AND code_company_raja = '{$code}' AND is_del = 'no' ";
        $result    = $ModelBase->load( $sql );

        return $result['name_fa'];
    }
    #endregion

    #region getIdBaseCompanyBus

    public static function getIdCompanyTrain( $param ) {
        $ModelBase = Load::library( 'ModelBase' );
        $sql
            = "SELECT id FROM base_company_bus_tb
                WHERE type_vehicle = 'train' AND name_fa = '{$param}' AND is_del = 'no' ";
        $result    = $ModelBase->load( $sql );

        return $result['id'];
    }
    #endregion

    #region getCompanyTrainById

    public static function getIdCompanyTrainByCode( $code ) {
        $ModelBase = Load::library( 'ModelBase' );
        $sql
            = "SELECT id FROM base_company_bus_tb
                WHERE type_vehicle = 'train' AND code_company_raja = '{$code}' AND is_del = 'no' ";
        $result    = $ModelBase->load( $sql );

        return $result['id'];
    }
    #endregion


    public static function getCompanyTrainPhoto( $code, $capacity = null ) {
        $ModelBase = Load::library( 'ModelBase' );
        $sql
            = "SELECT logo FROM base_company_bus_tb
                WHERE type_vehicle = 'train' AND (code_company_raja = '{$code}' OR  name_fa='{$code}') AND is_del = 'no' ";
        $result    = $ModelBase->load( $sql );
        if ( ! empty( $result ) && $result['logo'] != '' ) {
            if ( $code == '31' && $capacity == '4' ) {
                $result['logo'] = 'arg.png';
            }
            
            return ROOT_ADDRESS_WITHOUT_LANG . "/pic/companyBusImages/" . $result['logo'];
        } else {
            return ROOT_ADDRESS_WITHOUT_LANG . "/pic/companyBusImages/no-photo-train.png";
        }
    }
    #endregion
    public static function pdfGetCompanyTrainPhoto( $code, $capacity = null ) {
        $ModelBase = Load::library( 'ModelBase' );
        $sql
            = "SELECT logo FROM base_company_bus_tb
                WHERE type_vehicle = 'train' AND (code_company_raja = '{$code}' OR  name_fa='{$code}') AND is_del = 'no' ";
        $result    = $ModelBase->load( $sql );
        if ( ! empty( $result ) && $result['logo'] != '' ) {
            if ( $code == '31' && $capacity == '4' ) {
                $result['logo'] = 'arg.png';
            }

            return  "/pic/companyBusImages/" . $result['logo'];

        } else {
            return "/pic/companyBusImages/no-photo-train.png";
        }
    }

    #region getIdCompanyTrainByCode

    public static function getAllCompanyTrain() {
        $ModelBase = Load::library( 'ModelBase' );
        $sql
            = "SELECT
                  name_fa AS name_company,
                  logo AS logo_company,
                  code_company_raja AS code_company
                FROM base_company_bus_tb WHERE type_vehicle = 'train' AND is_del = 'no' GROUP BY name_company";
        $result    = $ModelBase->select( $sql );

        return $result;
    }
    #endregion


    #region getCompanyTrainPhoto

    public static function setBusPriceChanges( $price ) {
        if ( $price > 0 ) {
            $UserId   = Session::getUserId();
            $UserInfo = functions::infoMember( $UserId );
            if ( ! empty( $UserInfo ) ) {
                $counterID = $UserInfo['fk_counter_type_id'];
            } else {
                $counterID = '5';
            }

            $busPriceChanges = Load::controller( 'busPriceChanges' );
            $priceChanges    = $busPriceChanges->getByCounter( $counterID );

            if ( ! empty( $priceChanges ) ) {
                if ( $priceChanges['changeType'] == 'cost' ) {
                    $price += $priceChanges['price'];
                } else {
                    $price += $price * ( $priceChanges['price'] / 100 );
                }
            }
        }

        return round( $price );
    }
    #endregion

    #region getAllCompanyTrain

    public static function createJson( $param ) {
        return json_encode( $param );
    }
    #endregion

    #region setBusPriceChanges

    public static function privateSystemSource7() {

        $route = array( "THR", "SRY" );

        return $route;

    }
    #endregion


    #region AirlineSystemPrivate7

    public static function AirlineSystemPrivate7() {

        $airline = array( "Varesh" );

        return $airline;

    }
    #endregion


    #region getXmlinformation

    public static function ReplaceString( $search, $replace, $string ) {

        return str_replace( $search, $replace, $string );

    }
    #endregion

    //region StrReplaceInXml

    public static function TemporaryServicecode( $servicecode, $field ) {

        Load::autoload( 'Model' );

        $Model = new Model();

        $sql = "SELECT {$field} FROM Temporary_bus_tb WHERE ServiceCode='{$servicecode}'";

        $information = $Model->select( $sql );

        return $information[0][0];

    }
    //endregion


    //region privateSystemSource7

    public static function CountTicketInPage() {
        return 50;
    }
    //endregion

    //region AirlineSystemPrivate7

    public static function interrupt() {
        $interrupt = array( 'NoInterrupt', 'OneInterrupt', 'TwoInterrupt', );

        return $interrupt;
    }
    //endregion


    //region ReplaceString()

    public static function flightType() {
        $flightType = array( 'system', 'charter' );

        return $flightType;
    }

    //endregion


    //region TemporaryServicecode()

    public static function seatClass() {
        $seatClass = array( 'economy', 'business' );

        return $seatClass;
    }

    //endregion


    //region CountTicketInPage for Foreign Ticket

    public static function airlinesCode() {
        $airlinesCode = self::getAirlines();
        $codeAirlines = array();
        foreach ( $airlinesCode as $code ) {
            $codeAirlines[] = $code['abbreviation'];
        }

        return $codeAirlines;
    }

    //endregion

    public static function getAirlines() {
        $airline = Load::model( 'airline' );

        return $airline->getAllSort();
    }

    public static function time() {
        $time = array( 'early', 'morning', 'afternoon', 'night' );

        return $time;
    }

    public static function SourceIdPrivate() {
        $sourceIdArray = array( '1', '12' );

        return $sourceIdArray;
    }

    public static function MarkupForSourceId() {
        $sourceIdArray = array( '5', );

        return $sourceIdArray;
    }

    public static function CalculateArrivalTime( $LongTime, $TimeFlight ) {
        $explode_date = explode( ':', $LongTime );
        $jmktime      = dateTimeSetting::jmktime( $explode_date[0], $explode_date[1], $explode_date[2] );

        $hour_long    = dateTimeSetting::jdate( "H", $jmktime );
        $Minutes_long = dateTimeSetting::jdate( "i", $jmktime );

        if ( $explode_date[0] > 00 ) {
            $cal1 = $explode_date[0] * 60;
        } else {
            $cal1 = 0;
        }

        if ( $explode_date[1] > 00 ) {
            $cal2 = $explode_date[1];
        } else {
            $cal2 = 0;
        }

        $calTotal    = $cal1 + $cal2;
        $time        = strtotime( self::format_hour( $TimeFlight ) );
        $ArrivalTime = date( "H:i", strtotime( '+' . $calTotal . ' minutes', $time ) );

        $Time['time']    = $ArrivalTime;
        $Time['Hour']    = $hour_long;
        $Time['Minutes'] = $Minutes_long;
        
        return $Time;
    }

    public static function CommissionFlightSystemPublic( $requestNumber ) {
        $percentPublic      = self::percentPublic();
        $Flight             = self::info_flight_client( $requestNumber );
        $agencyCommission   = 0;
        $supplierCommission = 0;
        foreach ( $Flight as $item ) {

            if ( $item['adt_fare'] > 0 ) {
                if ( $item['passenger_age'] == 'Adt' ) {
                    $agencyCommission   += $item['agency_commission'];
                    $supplierCommission += $item['supplier_commission'];
                } elseif ( $item['passenger_age'] == 'Chd' ) {
                    $agencyCommission   += $item['agency_commission'];
                    $supplierCommission += $item['supplier_commission'];
                } elseif ( $item['passenger_age'] == 'Inf' ) {
                    $agencyCommission   += $item['agency_commission'];
                    $supplierCommission += $item['supplier_commission'];
                }
            } else {
                if ( $item['passenger_age'] == 'Adt' ) {
                    $agencyCommission   += round( ( $item['adt_price'] - ( $item['adt_price'] * ( 4573 / 100000 ) ) ) * ( $percentPublic ) );
                    $supplierCommission += round( ( $item['adt_price'] - ( $item['adt_price'] * ( 4573 / 100000 ) ) ) );
                } elseif ( $item['passenger_age'] == 'Chd' ) {
                    $agencyCommission   += round( ( $item['chd_price'] - ( $item['chd_price'] * ( 4573 / 100000 ) ) ) * ( $percentPublic ) );
                    $supplierCommission += round( ( $item['chd_price'] - ( $item['chd_price'] * ( 4573 / 100000 ) ) ) );
                } elseif ( $item['passenger_age'] == 'Inf' ) {
                    $agencyCommission   += round( ( $item['inf_price'] - ( $item['inf_price'] * ( 4573 / 100000 ) ) ) * ( $percentPublic ) );
                    $supplierCommission += round( ( $item['inf_price'] - ( $item['inf_price'] * ( 4573 / 100000 ) ) ) );
                }
            }

        }


        $data['agencyCommission']   = $agencyCommission;
        $data['supplierCommission'] = $supplierCommission;

        return $data;
    }

    public static function info_train_client( $request_number ) {
        if ( TYPE_ADMIN == '1' ) {
            $ModelBase = Load::library( 'ModelBase' );
            $sql       = "SELECT *, "
                . " (SELECT COUNT(id) FROM report_train_tb WHERE factor_number='{$request_number}' OR ServiceCode='{$request_number}') AS CountId "
                . " FROM report_train_tb  WHERE (factor_number='{$request_number}' OR ServiceCode='{$request_number}') "
                . " AND (((factor_number OR ServiceCode) > 0) OR ((factor_number OR ServiceCode) <>''))  ";
            $result    = $ModelBase->select( $sql );
        } else {
            $Model  = Load::library( 'Model' );
            $sql    = "SELECT *, "
                . " (SELECT COUNT(id) FROM book_train_tb WHERE factor_number='{$request_number}' OR ServiceCode='{$request_number}') AS CountId "
                . " FROM book_train_tb  WHERE (factor_number='{$request_number}' OR ServiceCode='{$request_number}') "
                . " AND (((factor_number OR ServiceCode) > 0) OR ((factor_number OR ServiceCode) <>''))";
            $result = $Model->select( $sql );
        }

        return $result;
    }

    public static function ShowMessageError( $requestNumber, $clientId ) {
        $admin          = Load::controller( 'admin' );
        $SqlCounterType = "SELECT * FROM log_flight_tb WHERE request_number='{$requestNumber}' AND message !=''";
        $message        = '';
        if ( TYPE_ADMIN == '1' ):
            $CounterType = $admin->ConectDbClient( $SqlCounterType, $clientId, "Select", "", "", "" );
            $errorLog    = Load::controller( 'LogError' );
            $messageFa   = $errorLog->ErrorShow( $CounterType['messageCode'] );
            $message     = $messageFa . '---' . $CounterType['message'];
        else:
            $Model       = Load::library( 'Model' );
            $CounterType = $Model->load( $SqlCounterType );
            $message     = $CounterType['messageFa'];
        endif;


        return $message;
    }

    #region CalculateArrivalTime

    public static function dateFormatSpecialMiladi( $date, $type ) {
        return date_format( date_create( str_replace( '/', '-', $date ) ), $type );
    }

    #endregion

    public static function dateFormatSpecialJalali( $date, $type ) {
        return dateTimeSetting::jdate( $type, self::FormatDateJalali( str_replace( '/', '-', $date ) ), '', '', 'en' );
    }

    public static function dateFormatSpecialJalaliWithoutZeroDay( $date, $type ) {
         $date_selected = dateTimeSetting::jdate( $type, self::FormatDateJalali( str_replace( '/', '-', $date ) ), '', '', 'en' );
        $date_selected = explode('/',$date_selected);

        $year = isset($date_selected[2]) ? $date_selected[2] : '';
        $mounth = isset($date_selected[1]) ? $date_selected[1] : '';
        $day = isset($date_selected[0]) ? ($date_selected[0] > 9 ? $date_selected[0] : str_replace('0','',$date_selected[0])) :'' ;

        return $day.$mounth.$year;

    }

    public static function findTicket( $RequestNumber ) {

        $Model = Load::library( 'Model' );
        $sql   = " SELECT * FROM book_local_tb WHERE request_number='{$RequestNumber}' ";
        $rec   = $Model->load( $sql );

        return $rec;
    }

    #region info_train_client

    public static function checkIncreasePrice( $newPrice, $OldPrice, $type, $currencyCode, $flightType, $direction ) {
       
        $direction           = ( $direction == 'dept' ) ? self::Xmlinformation( 'routewent' ) : self::Xmlinformation( 'Wayback' );
        $changePrice         = intval( $newPrice ) - intval( $OldPrice );
        $changePriceCurrency = self::CurrencyCalculate( $changePrice, $currencyCode );

        $changePriceFinal = number_format( abs( $changePriceCurrency['AmountCurrency'] ) ) . ' ' . $changePriceCurrency['TypeCurrency'];

        switch ( $type ) {
            case 'Adt':
                if ( $changePrice > 0 ) {
                    $message = self::StrReplaceInXml( [ '@@changePrice@@' => $changePriceFinal, '@@direction@@' => $direction ],
                        'increasePriceAdultChange' );//self::Xmlinformation('increasePriceAdultChange');

                    return $message;
                } elseif ( $changePrice < 0 ) {
                    $message = self::StrReplaceInXml( [ '@@changePrice@@' => $changePriceFinal, '@@direction@@' => $direction ],
                        'decreasePriceAdultChange' );// self::Xmlinformation('decreasePriceAdultChange');

                    return $message;
                }
                break;
            case 'Chd':
                if ( $changePrice > 0 ) {
                    $message = self::StrReplaceInXml( [ '@@changePrice@@' => $changePriceFinal, '@@direction@@' => $direction ],
                        'increasePriceChildChange' );// self::Xmlinformation('increasePriceChildChange');

                    return $message;
                } elseif ( $changePrice < 0 ) {
                    $message = self::StrReplaceInXml( [ '@@changePrice@@' => $changePriceFinal, '@@direction@@' => $direction ],
                        'decreasePriceChildChange' );//self::Xmlinformation('decreasePriceChildChange');

                    return $message;
                }
                break;
            case 'Inf':
                if ( $changePrice > 0 ) {
                    $message = self::StrReplaceInXml( [ '@@changePrice@@' => $changePriceFinal, '@@direction@@' => $direction ],
                        'increasePriceInfantChange' );//self::Xmlinformation('increasePriceInfantChange');

                    return $message;
                } elseif ( $changePrice < 0 ) {
                    $message = self::StrReplaceInXml( [ '@@changePrice@@' => $changePriceFinal, '@@direction@@' => $direction ],
                        'decreasePriceInfantChange' );//self::Xmlinformation('decreasePriceInfantChange');

                    return $message;
                }
                break;
            default:
                return '';
                break;
        }

    }

    #endregion


    #region ShowMessageError

    public static function CurrencyCalculate( $Price, $CurrencyCode = null, $CurrencyEquivalent = null ,$title_currency = null) {


        self::insertLog('CurrencyCalculate Input Params => ' . json_encode([
                'Price' => $Price,
                'CurrencyCode' => $CurrencyCode,
                'CurrencyEquivalent' => $CurrencyEquivalent,
                'title_currency' => $title_currency
            ]), 'CurrencyCalculate');

        $SessionCurrency = '';
        if ( $CurrencyCode > '0' ) {
            $SessionCurrency = $CurrencyCode;
        } elseif ( empty( $CurrencyCode ) ) {
            $SessionCurrency = Session::getCurrency();
        }

        self::insertLog('SessionCurrency => ' . json_encode($SessionCurrency), 'CurrencyCalculate');

        $info_currency = array();
        if ( $CurrencyEquivalent != null ) {
            $EquivalentAmount = $CurrencyEquivalent;
        } else {
            $info_currency = self::infoCurrencyBySessionCode($SessionCurrency);
            $EquivalentAmount = isset($info_currency['EqAmount']) ? $info_currency['EqAmount'] :  0;
        }

        self::insertLog('Currency Info => ' . json_encode([
                'info_currency' => $info_currency,
                'EquivalentAmount' => $EquivalentAmount
            ]), 'CurrencyCalculate');

        $Amount     = ( $SessionCurrency > 0 && ISCURRENCY == '1' && ! empty( $EquivalentAmount ) ) ? ( $Price / $EquivalentAmount ) : $Price;
        if (SOFTWARE_LANG == 'fa') {
            $TypeAmount = ($SessionCurrency > 0 && ISCURRENCY == '1' && !empty($info_currency)) ? $info_currency['CurrencyTitle'] : (($title_currency != null) ? $title_currency : functions::Xmlinformation('Rial')->__toString());
        }else {
            $TypeAmount = ($SessionCurrency > 0 && ISCURRENCY == '1' && !empty($info_currency)) ? $info_currency['CurrencyTitleEn'] : (($title_currency != null) ? $title_currency : functions::Xmlinformation('Rial')->__toString());
        }

        $CurrencyCalculate['AmountCurrency'] =  $Amount;
        $CurrencyCalculate['TypeCurrency']   = $TypeAmount;

        self::insertLog('CurrencyCalculate Result => ' . json_encode($CurrencyCalculate), 'CurrencyCalculate');

        return $CurrencyCalculate;
    }


    #endregion
    #region CurrencyToRial
    public static function CurrencyToRial( $Price, $CurrencyCode = null, $CurrencyEquivalent = null, $title_currency = null) {
        $SessionCurrency = '';
        if ($CurrencyCode > '0') {
            $SessionCurrency = $CurrencyCode;
        } elseif (empty($CurrencyCode)) {
            $SessionCurrency = Session::getCurrency();
        }
        $info_currency = array();
        if ($CurrencyEquivalent != null) {
            $EquivalentAmount = $CurrencyEquivalent;
        } else {
            $info_currency = self::infoCurrencyBySessionCode($SessionCurrency);
            $EquivalentAmount = isset($info_currency['EqAmount']) ? $info_currency['EqAmount'] : 0;
        }
        $Amount     = ($SessionCurrency > 0 && ISCURRENCY == '1' && !empty($EquivalentAmount)) ? ($Price * $EquivalentAmount) : $Price;
        $TypeAmount = (($SessionCurrency > 0 && ISCURRENCY == '1' && !empty($info_currency))
            ? functions::Xmlinformation('Rial')->__toString()
            : (($title_currency != null) ? $title_currency : 'Unknown'));
        $CurrencyConvert['AmountRial']   = $Amount;
        $CurrencyConvert['TypeCurrency'] = $TypeAmount;
        return $CurrencyConvert;
    }
    #endregion

    #region CalculateCurrencyPrice

    public static function CalculateCurrencyPrice( $params ) {

        $amount = $params['price'];
        $currency_type = $params['currency_type'] ;
        $currencyEquivalentModel = Load::getModel('currencyEquivalentModel');
        $currencyModel = Load::getModel('currencyModel');
        $resultCurrencyEquivalent = $currencyEquivalentModel->get()->where('CurrencyCode', $currency_type)->find();
        $currency = $currencyModel->get()->where('IsEnable', 'Enable')->where('CurrencyCode', $currency_type)->find();

        $CurrencyCalculate['AmountCurrency'] =  $resultCurrencyEquivalent['EqAmount'] * $amount;
        $CurrencyCalculate['TypeCurrency']   = $currency['CurrencyTitleEn'];

        return $CurrencyCalculate;


    }

    #endregion

    #region TicketPriceCurrency
    /**
     * @param $price
     * @param $equivalentCurrency
     * @return float|int
     */
    public static function ticketPriceCurrency($price, $equivalentCurrency) {

        return ($price/$equivalentCurrency);
    }
    #endregion


    /**
     * @param $SessionCurrency
     * @return array|bool|mixed|string
     */
    public static function infoCurrencyBySessionCode($SessionCurrency) {
        /** @var currencyEquivalent $Currency */
        $Currency     = Load::controller( 'currencyEquivalent' );
        return  $Currency->InfoCurrency( $SessionCurrency );
    }

    public static function checkExistChangePrice( $arrayBook, $arrayTemprory ) {

       
        if ( isset( $arrayBook['dept'] ) ) {
            foreach ( $arrayBook['dept'] as $key => $dept ) {
                if($dept['api_id'] == '17' && $dept['IsInternal'] == "1" && $dept['flight_type'] == "system") {
                    $changeCheck['dept']['Adt'] = false;
                    $changeCheck['dept']['Chd'] = false;
                    $changeCheck['dept']['Inf'] = false;
                }
                else {
                    if ( isset( $dept['adt_price'] ) && $dept['adt_price'] > 0 && ( $dept['adt_price'] ) != $arrayTemprory['dept']['AdtPrice'] ) {
                        $changeCheck['dept']['Adt'] = true;
                    }
                    if ( isset( $dept['chd_price'] ) && $dept['chd_price'] > 0 && ( $dept['chd_price'] ) != $arrayTemprory['dept']['ChdPrice'] ) {
                        $changeCheck['dept']['Chd'] = true;
                    }
                    if ( isset( $dept['inf_price'] ) && $dept['inf_price'] > 0 && ( $dept['inf_price'] ) != $arrayTemprory['dept']['InfPrice'] ) {
                        $changeCheck['dept']['Inf'] = true;
                    }
                }

            }
        }

        if ( isset( $arrayBook['return'] ) ) {
            foreach ( $arrayBook['return'] as $key => $return ) {
                if($return['api_id'] == '17' && $return['IsInternal'] == "1" && $return['flight_type'] == "system") {
                    $changeCheck['return']['Adt'] = false;
                    $changeCheck['return']['Chd'] = false;
                    $changeCheck['return']['Inf'] = false;
                }else{
                    if ( isset( $return['adt_price'] ) && $return['adt_price'] > 0  && ( $return['adt_price'] ) != $arrayTemprory['return']['AdtPrice'] ) {
                        $changeCheck['return']['Adt'] = true;
                    }

                    if ( isset( $return['chd_price'] ) && $return['chd_price'] > 0 && ( $return['chd_price'] ) != $arrayTemprory['return']['ChdPrice'] ) {
                        $changeCheck['return']['Chd'] = true;
                    }

                    if ( isset( $return['inf_price'] ) && $return['inf_price'] > 0 && ( $return['inf_price'] ) != $arrayTemprory['return']['InfPrice'] ) {
                        $changeCheck['return']['Inf'] = true;
                    }
                }

            }
        }

        if ( isset( $arrayBook['TwoWay'] ) ) {
            foreach ( $arrayBook['TwoWay'] as $key => $twoWay ) {
                if($twoWay['api_id'] == '17' && $twoWay['IsInternal'] == "1" && $twoWay['flight_type'] == "system") {
                    $changeCheck['TwoWay']['Adt'] = false;
                    $changeCheck['TwoWay']['Chd'] = false;
                    $changeCheck['TwoWay']['Inf'] = false;
                }
                else{
                    if ( isset( $twoWay['adt_price'] ) && ( $twoWay['adt_price'] ) != $arrayTemprory['TwoWay']['AdtPrice'] ) {
                        $changeCheck['TwoWay']['Adt'] = true;
                    }

                    if ( isset( $twoWay['chd_price'] ) && ( $twoWay['chd_price'] ) != $arrayTemprory['TwoWay']['ChdPrice'] ) {
                        $changeCheck['TwoWay']['Chd'] = true;
                    }

                    if ( isset( $twoWay['inf_price'] ) && ( $twoWay['inf_price'] ) != $arrayTemprory['TwoWay']['InfPrice'] ) {
                        $changeCheck['TwoWay']['Inf'] = true;
                    }
                }

            }
        }

        if ( isset( $changeCheck['dept'] ) && ( $changeCheck['dept']['Adt'] || $changeCheck['dept']['Chd'] || $changeCheck['dept']['Inf'] ) ) {
            $changeCheckFinal = true;
        } elseif ( isset( $changeCheck['return'] ) && ( $changeCheck['return']['Adt'] || $changeCheck['dept']['Chd'] || $changeCheck['return']['Inf'] ) ) {
            $changeCheckFinal = true;
        } elseif ( isset( $changeCheck['TwoWay'] ) && ( $changeCheck['TwoWay']['Adt'] || $changeCheck['TwoWay']['Chd'] || $changeCheck['TwoWay']['Inf'] ) ) {
            $changeCheckFinal = true;
        }

        return $changeCheckFinal;
    }

    public static function CalculatePriceOnePersonApp( $RequestNumber, $nationalCode ) {

        //yes means nesesary calculate  price changes
        $modelBase = Load::library( 'ModelBase' );

        $Sql
            = "SELECT * FROM report_tb WHERE (request_number='{$RequestNumber}' OR factor_number='{$RequestNumber}') AND (passenger_national_code='{$nationalCode}' OR passportNumber='{$nationalCode}')";

        $result = $modelBase->select( $Sql );


        $amount = 0;

        foreach ( $result as $key => $rec ) {
            if ( strtolower( $rec['flight_type'] ) == 'system' ) {
                if ( $rec['IsInternal'] == '1' || $rec['api_id'] != '10' ) {
                    $checkPrivate = ( $rec['pid_private'] == '1' ) ? 'private' : 'public';
                    if ( $rec['percent_discount'] > 0 ) {
                        if ( $checkPrivate == 'public' ) {
                            $amount += $rec['adt_price'] - ( ( $rec['adt_fare'] * ( $rec['percent_discount'] / 100 ) ) / 2 );
                            $amount += $rec['chd_price'] - ( ( $rec['chd_fare'] * ( $rec['percent_discount'] / 100 ) ) / 2 );
                            $amount += $rec['inf_price'];
                        } elseif ( $checkPrivate == 'private' ) {
                            $amount += $rec['adt_price'] - ( $rec['adt_fare'] * ( $rec['percent_discount'] / 100 ) );
                            $amount += $rec['chd_price'] - ( $rec['chd_fare'] * ( $rec['percent_discount'] / 100 ) );
                            $amount += $rec['inf_price'];
                        }
                    } else {
                        $amount += $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];
                    }
                } else {
                    if ( $rec['IsInternal'] == '0' ) {
                        $everyAmount = $rec['api_commission'] + $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];

                        if ( $rec['price_change'] > 0 && $rec['price_change_type'] == 'percent' ) {
                            $everyAmountFake = $rec['api_commission'] + $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];
                            $ChangeAmount    = $everyAmountFake * ( $rec['price_change'] / 100 );
                            $everyAmount     += $ChangeAmount;
                            $amount          += $everyAmount - ( ( $ChangeAmount * $rec['percent_discount'] ) / 100 );
                        } else if ( $rec['price_change'] > 0 && $rec['price_change_type'] == 'cost' ) {
                            $ChangeAmount = $rec['price_change'];
                            $everyAmount  += $ChangeAmount;
                            $amount       += $everyAmount - ( ( $ChangeAmount * $rec['percent_discount'] ) / 100 );
                        } else {
                            $amount += $everyAmount;
                        }
                    }
                }
            } else {
                $everyAmount = $rec['api_commission'] + $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];

                if ( $rec['price_change'] > 0 && $rec['price_change_type'] == 'cost' ) {
                    $everyAmount  += $rec['irantech_commission'];
                    $ChangeAmount = $rec['price_change'];
                    $everyAmount  += $ChangeAmount;
                    if ( $rec['passenger_age'] == 'Adt' || $rec['passenger_age'] == 'Chd' ) {
                        $amount += $everyAmount - ( ( $ChangeAmount * $rec['percent_discount'] ) / 100 );
                    } else if ( $rec['passenger_age'] == 'Inf' ) {
                        $amount += $everyAmount;
                    }
                } elseif ( $rec['price_change'] > 0 && $rec['price_change_type'] == 'percent' ) {
                    $ChangeAmount = $everyAmount * ( $rec['price_change'] / 100 );
                    $everyAmount  += $ChangeAmount;
                    $everyAmount  += $rec['irantech_commission'];
                    if ( $rec['passenger_age'] == 'Adt' || $rec['passenger_age'] == 'Chd' ) {
                        $amount += $everyAmount - ( ( $ChangeAmount * $rec['percent_discount'] ) / 100 );
                    } else if ( $rec['passenger_age'] == 'Inf' ) {
                        $amount += $everyAmount;
                    }
                } else {
                    if ( $rec['passenger_age'] == 'Adt' || $rec['passenger_age'] == 'Chd' ) {
                        $ChangeAmount = 0;
                        $amount       += $everyAmount - ( ( $ChangeAmount * $rec['percent_discount'] ) / 100 );
                    } else if ( $rec['passenger_age'] == 'Inf' ) {
                        $amount += $everyAmount;
                    }
                }
            }
        }


        return round( $amount );
    }

    #region ConvertDateByLanguage


    /**
     * @param $CorrectLanguage
     * @param $date
     * @param string $mod
     * @param string $DateType
     * @param bool $FromMiladi
     * @return array|string
     */
    public static function ConvertDateByLanguage($CorrectLanguage, $date, $mod = '-', $DateType = 'Jalali', $FromMiladi = false ) {
        if ( $CorrectLanguage == 'fa' ) {
            if ( $FromMiladi == true ) {
                return self::ConvertToJalali( $date, $mod );
            } else {
                return $date;
            }
        } else {
            if ( $DateType == 'Jalali' ) {
                return self::ConvertToMiladi( $date, $mod );
            } elseif ( $DateType == 'Miladi' ) {
                return str_replace('-',$mod,$date);
            }
        }
    }
    #endregion

    public static function printDateIntByLanguage( $format, $dateint, $language = 'fa' ) {

        return ( $language == 'fa' ) ? dateTimeSetting::jdate( $format, $dateint, '', '', 'en' ) : date( $format, $dateint );
    }

    #region ConvertToJalali
    /**
     * @param $param
     * @param string $mod
     * @return array|string
     */
    public static function ConvertToJalali($param, $mod = '-' ) {
        $gdata = str_replace( array( '-', '/' ), '', $param );

        $y = substr( $gdata, 0, 4 );
        $m = substr( $gdata, 4, 2 );
        $d = substr( $gdata, 6, 2 );

        return dateTimeSetting::gregorian_to_jalali( $y, $m, $d, $mod );
    }

    #endregion

    public static function ConvertToMiladi( $param, $mod = '-' ) {
        $jdata = str_replace( array( '-', '/' ), '', $param );

        $y = substr( $jdata, 0, 4 );
        $m = substr( $jdata, 4, 2 );
        $d = substr( $jdata, 6, 2 );

        return dateTimeSetting::jalali_to_gregorian( $y, $m, $d, $mod );
    }


    #region CalculateDiscountOnePerson

    public static function accessToClientInsertMemberApi() {
        $client = array( 'turino' => '141', 'hijimbo' => '4', );

        return $client;
    }
    #endregion

    #region ConvertDateByLanguage

    public static function numalpha( $num ) {
        $one        = array( 'صفر', 'یک', 'دو', 'سه', 'چهار', 'پنج', 'شش', 'هفت', 'هشت', 'نه' );
        $ten        = array( '', 'ده', 'بیست', 'سی', 'چهل', 'پنجاه', 'شصت', 'هفتاد', 'هشتاد', 'نود' );
        $hundred    = array( '', 'یکصد', 'دویست', 'سیصد', 'چهارصد', 'پانصد', 'ششصد', 'هفتصد', 'هشتصد', 'نهصد' );
        $exceptions = array( '', 'یازده', 'دوازده', 'سیزده', 'چهارده', 'پانزده', 'شانزده', 'هفده', 'هجده', 'نوزده' );
        $units      = array( '', 'هزار', 'میلیون', 'میلیارد' );
        $separator  = ' و ';

        if ( strlen( $num ) > count( $units ) * 3 ) {
            return 'عدد واردشده بیشتر از حداکثر محدوده مجاز است';
        }

        $num     = (string) (float) $num;
        $num_len = strlen( $num );
        $result  = '';

        for ( $i = $num_len - 1; $i >= 0; $i -= 3 ) {
            $i_one     = (int) isset( $num[ $i ] ) ? $num[ $i ] : - 1;
            $i_ten     = (int) isset( $num[ $i - 1 ] ) ? $num[ $i - 1 ] : - 1;
            $i_hundred = (int) isset( $num[ $i - 2 ] ) ? $num[ $i - 2 ] : - 1;

            $isset_one     = false;
            $isset_ten     = false;
            $isset_hundred = false;

            $letters = '';

            // zero
            if ( $i_one == 0 && $i_ten < 0 && $i_hundred < 0 ) {
                $letters = $one[ $i_one ];
            }

            // one
            if ( ( $i >= 0 ) && $i_one > 0 && $i_ten != 1 && isset( $one[ $i_one ] ) ) {
                $letters   = $one[ $i_one ];
                $isset_one = true;
            }

            // ten
            if ( ( $i - 1 >= 0 ) && $i_ten > 0 && isset( $ten[ $i_ten ] ) ) {
                if ( $isset_one ) {
                    $letters = $separator . $letters;
                }

                if ( $i_one == 0 ) {
                    $letters = $ten[ $i_ten ];
                } elseif ( $i_ten == 1 && $i_one > 0 ) {
                    $letters = $exceptions[ $i_one ];
                } else {
                    $letters = $ten[ $i_ten ] . $letters;
                }

                $isset_ten = true;
            }

            // hundred
            if ( ( $i - 2 >= 0 ) && $i_hundred > 0 && isset( $hundred[ $i_hundred ] ) ) {
                if ( $isset_ten || $isset_one ) {
                    $letters = $separator . $letters;
                }

                $letters       = $hundred[ $i_hundred ] . $letters;
                $isset_hundred = true;
            }

            if ( $i_one < 1 && $i_ten < 1 && $i_hundred < 1 ) {
                $letters = '';
            } else {
                $letters .= ' ' . $units[ ( $num_len - $i - 1 ) / 3 ];
            }

            if ( ! empty( $letters ) && $i >= 3 ) {
                $letters = $separator . $letters;
            }

            $result = $letters . $result;
        }

        return $result;
    }
    #endregion ConvertDateByLanguage


    //region accessToClientInsertMemberApi

    public static function ConvertArrayByLanguage( $String ) {
        $ArrayInstead = array(
            "flight"        => self::Xmlinformation( 'Flight' ),
            "hotel"         => self::Xmlinformation( 'Hotel' ),
            "insurance"     => self::Xmlinformation( 'Insurance' ),
            "gashttransfer" => self::Xmlinformation( 'PatrolTransfer' ),
            "europcar"      => self::Xmlinformation( 'Carrental' ),
            "tour"          => self::Xmlinformation( 'Tour' ),
            "visa"          => self::Xmlinformation( 'Visa' ),
            "bus"           => self::Xmlinformation( 'Bus' ),
            "train"         => self::Xmlinformation( 'Train' ),
            "entertainment" => self::Xmlinformation( 'Entertainment' ),
            "package"       => self::Xmlinformation( 'Package' ),
        );
        foreach ( $ArrayInstead AS $key => $value ) {
            if ( $key == $String ) {
                return $value;
            }
        }
    }

    //endregion

     public  function ConvertByLanguage( $String ) {

      switch ($String) {
          case "flight" :
            $value = self::Xmlinformation( 'Flight' )->__toString() ;
          break ;
          case "hotel" :
              $value = self::Xmlinformation( 'Hotel' )->__toString() ;
              break ;
          case "insurance" :
              $value = self::Xmlinformation( 'Insurance' )->__toString() ;
              break ;
          case "gashttransfer" :
              $value = self::Xmlinformation( 'PatrolTransfer' )->__toString() ;
              break ;
          case "europcar" :
               $value = self::Xmlinformation( 'Carrental' )->__toString() ;
              break ;
          case "visa" :
            $value = self::Xmlinformation( 'Visa' )->__toString() ;
            break ;
          case "bus" :
              $value = self::Xmlinformation( 'Bus' )->__toString() ;
              break ;
          case "train" :
              $value = self::Xmlinformation( 'train' )->__toString() ;
              break ;
          case "entertainment" :
              $value = self::Xmlinformation( 'Entertainment' )->__toString() ;
              break ;
          default:
            $value = '' ;
      }

      return $value;
    }
    public static function registerClub( $data ) {
        $url = "https://www.iran-tech.com/old/v10/fa/admin/cronjob/insertDataToClubOfGds.php";

        $data = json_encode( $data );

        $result = self::curlExecution( $url, $data );

        self::insertLog( 'LogInsertUserClub=>' . json_encode( $result ), 'LogInsertUserClub' );
    }

	#region ConvertArrayByLanguage

	public static function curlExecution( $url, $data, $flag = null ) {

		/**
		 * This function execute curl with a url & datas
		 *
		 * @param $url  string
		 * @param $data array   an associative array of elements
		 *
		 * @return array    json decoded output
		 * @author Naime Barati
		 */
		$handle = curl_init( $url );
		curl_setopt( $handle, CURLOPT_POST, true );
		curl_setopt( $handle, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $handle, CURLOPT_SSL_VERIFYHOST, 0 );
		curl_setopt( $handle, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt( $handle, CURLOPT_POSTFIELDS, $data );
		if ( isset( $flag['auth_user'] ) && isset( $flag['auth_pass'] ) ) {
			curl_setopt( $handle, CURLOPT_USERPWD, $flag['auth_user'] . ":" . $flag['auth_pass'] );
		}
		if ( $flag == 'yes' || $flag == 'json' ) {
			curl_setopt( $handle, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json' ) );
		} else if ( $flag == 'balance' || $flag == 'form' ) {
			curl_setopt( $handle, CURLOPT_HTTPHEADER, array( 'Content-Type: application/x-www-form-urlencoded' ) );
		} elseif ( is_array( $flag ) ) {
			//			$headers = array_($flag,'Content-Type: application/json');
			curl_setopt( $handle, CURLOPT_HTTPHEADER, $flag );
		}

		$result  = curl_exec( $handle );


        self::insertLog( 'response curlExecution: ' . $url.'=>'. $data.'=>'.$result, 'check_final_log' );
		$dataStr = is_array( $data ) ? json_encode( $data, 256 | 64 ) : $data;
		if(strpos($url,'yekpay') !== false){
			self::insertLog( 'DOMAIN: '. CLIENT_MAIN_DOMAIN . ' url : ' . $url . ' request curlExecution: ' . $dataStr . ' Headers: ' . json_encode( $flag, 256 | 64 ), 'yekpay_log' );
			self::insertLog( 'response curlExecution: ' . $result, 'yekpay_log' );
		}
    if(strpos($url,'sepehr.shaparak.ir') !== false){
			self::insertLog( 'DOMAIN: '. CLIENT_MAIN_DOMAIN . ' url : ' . $url . ' request curlExecution: ' . $dataStr . ' Headers: ' . json_encode( $flag, 256 | 64 ), 'saderat_log' );
			self::insertLog( 'response curlExecution: ' . $result, 'saderat_log' );
			self::insertLog( 'response curlError: ' . json_encode( curl_error($handle), 256 | 64 ), 'saderat_log' );
		}
		if(strpos($url,'shaparak') !== false){
			self::insertLog( 'DOMAIN: '. CLIENT_MAIN_DOMAIN . ' url : ' . $url . ' request curlExecution: ' . $dataStr . ' Headers: ' . json_encode( $flag, 256 | 64 ), 'shaparak_log' );
			self::insertLog( 'response curlExecution: ' . $result, 'shaparak_log' );
		}
        if(strpos($url,'Train') !== false){
			self::insertLog( 'DOMAIN: '. CLIENT_MAIN_DOMAIN . ' url : ' . $url . ' request curlExecution: ' . $dataStr . ' Headers: ' . json_encode( $flag, 256 | 64 ), 'train_log' );
			self::insertLog( 'response curlExecution: ' . $result, 'train_log' );
		}
		if(strpos($url,'Hotels') !== false){
			self::insertLog( 'url : ' . $url . ' request curlExecution: ' . $dataStr . ' Headers: ' . json_encode( $flag, 256 | 64 ), 'hotels_log' );
			self::insertLog( 'response curlExecution: ' . $result, 'hotels_log' );
        }
//		self::insertLog( 'url : ' . $url . ' request curlExecution: ' . $dataStr . ' Headers: ' . json_encode( $flag, 256 | 64 ), '000curlExecution' );
//		self::insertLog( 'response curlExecution: ' . $result, '000curlExecution' );
//        $result = self::clearJsonHiddenCharacters($result);

//       echo json_encode($result);
//       die;
   
        return json_decode( $result, true );
    }
    #endregion insertLog

    public static function insertLog( $message, $fileName, $isMicroTime = null ) {
        if ( isset( $isMicroTime ) && $isMicroTime == 'yes' ) {
            $messages = date( 'Y/m/d H:i:s' ) . " microtime => " .  round(microtime(true) * 1000) . "   " . $message . " \n";
        } else {
            $messages = date( 'Y/m/d H:i:s' ) . "   " . $message . " \n";
        }
        error_log( $messages, 3, LOGS_DIR . $fileName . '.txt' );
    }

    public static function registerBuyInClub( $data ) {

        $url = "https://www.iran-tech.com/old/v10/fa/admin/cronjob/insertDataToClubOfGds.php";

        $dataInfo['method']     = 'InsertPointUser';
        $dataInfo['Domain']     = CLIENT_MAIN_DOMAIN;
        $dataInfo['cardNumber'] = $data['cardNumber'];
        $dataInfo['dataPoint']  = $data['point'];


        $dataInfo = json_encode( $dataInfo );
        self::insertLog( 'LogInsertUserClub=>' . $dataInfo, 'LogDataPoint' );
        $result = self::curlExecution( $url, $dataInfo, 'yes' );

        self::insertLog( 'LogInsertUserClub=>' . json_encode( $result ), 'LogInsertBuyClub' );
    }

    public static function UpdateMemberInClub( $dataInfo ) {
        $url = "https://www.iran-tech.com/old/v10/fa/admin/cronjob/insertDataToClubOfGds.php";

        $dataInfo['method'] = 'UpdateMemberInClub';
        $dataInfo['Domain'] = CLIENT_MAIN_DOMAIN;
        $dataInfo           = json_encode( $dataInfo );

        return self::curlExecution( $url, $dataInfo, 'yes' );
    }


    public static function findLastArray( $array ) {
        $keys    = array_keys( $array );
        $lastKey = $keys[ count( $keys ) - 1 ];

        return $array[ $lastKey ];

    }

    public static function baggageTitle($arrayTicket, $route, $type = null)
    {
        $baggage= '0';
        if (empty($type)) {
            if ($arrayTicket['SourceId'] == '10' || $arrayTicket['SourceId'] == '1' || $arrayTicket['SourceId']=='14') {
                return (empty($route['Baggage']) ? self::Xmlinformation('NoBaggage') : (($route['Baggage'][0]['Code'] == 'Piece') ? self::StrReplaceInXml([
                    '@@numberPiece@@' => $route['Baggage'][0]['allowanceAmount'],
                    '@@amountPiece@@' => $route['Baggage'][0]['Charge'],
                ], 'AmountBaggage') : $route['Baggage'][0]['Charge'] . self::Xmlinformation("Kg")->__toString()));
            }

            if(!empty($route['Baggage'][0]['Charge'])){
                $baggage =  $route['Baggage'][0]['Charge'] ;
            }else{
                if($arrayTicket['IsInternal']=='0' && $route['departure']['departure_code'] == 'IKA' && $arrayTicket['SourceId'] == '8'){
                    $baggage = '20';
                }elseif($arrayTicket['IsInternal']=='1'){
                    $baggage = '30';
                }
            }


            return  (($baggage !='0') ?  self::StrReplaceInXml(['@@numberPiece@@' => '1', '@@amountPiece@@' => $baggage], 'AmountBaggage'): self::Xmlinformation('NoBaggage')->__toString());
        } else {

            if ($arrayTicket['api_id'] == '10' || $arrayTicket['api_id'] == '1' || $arrayTicket['api_id']=='14') {
                return (empty($route['Baggage']) ? 'No Load' :
                    (($route['BaggageType'] == 'Piece') ? $route['AllowanceAmount'] . ' pack, each pack ' . $route['Baggage'] . ' kg' : $route['Baggage'] . self::Xmlinformation("Kg")->__toString()));
            }


            if((empty($route['Baggage']) && $arrayTicket['IsInternal']=='0' && ($arrayTicket['origin_airport_iata'] == 'IKA') && $arrayTicket['api_id']=='8')){
                $baggage = '20 Kg';
            }elseif((empty($route['Baggage']) && $arrayTicket['IsInternal']=='0')){

                $baggage = 'Contact   support' ;
            }else{
              if(!empty($route['Baggage'])){
                  $baggage = $route['Baggage'] . ' kg' ;
              }else{
                  $baggage = (($arrayTicket['SeatClass'] == 'B' || $arrayTicket['SeatClass'] == 'C') ? '40' : '30').' Kg';
              }
            }

            return  $baggage ;

        }
    }

    public static function notAllowedAccessToPage() {

        return array(
            TRAIN_TICKET,
            ConstPrintTicket,
            ConstPrintHotel,
            ConstPrintEuropcar,
            ConstPrintTourReservation,
            ConstPrintHotelReservationAhuan,
            ConstPrintHotelReservationZarvan,

        );
    }

    /***bahrami**/
    public static function LinkShortener( $link ) {
        $shortener = Load::controller( 'shortener' );

        return $shortener->urlToShortCode( $link );
    }

    public static function LinkExtender( $shotLink ) {
        $shortener = Load::controller( 'shortener' );

        return $shortener->shortCodeToUrl( $shotLink );
    }

    public static function RandNumeric( $length ) {
        $chars = "1234567890";
        $clen  = strlen( $chars ) - 1;
        $id    = '';

        for ( $i = 0; $i < $length; $i ++ ) {
            $id .= $chars[ mt_rand( 0, $clen ) ];
        }

        return $id;
    }

    public static function RandString( $length ) {
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen( $characters );
        $randomString     = '';
        for ( $i = 0; $i < $length; $i ++ ) {
            $randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
        }

        return $randomString;
    }

    /***end bahrami**/


    #region textNumber
    public static function textNumber( $number ) {
        $numbers = array(
            ''  => '',
            '1' => 'First',
            '2' => 'Second',
            '3' => 'Third',
            '4' => 'Fourth',
            '5' => 'Fifth',
            '6' => 'Sixth',
            '7' => 'Seventh',
            '8' => 'Eighth',
            '9' => 'Ninth',
        );

        $textNumber = functions::Xmlinformation( $numbers[ $number ] );

        //
        //		switch ( $number ) {
        //			case '1':
        //				$textNumber = functions::Xmlinformation( 'First' );
        //				break;
        //			case '2':
        //				$textNumber = functions::Xmlinformation( 'Second' );
        //				break;
        //			case '3':
        //				$textNumber = functions::Xmlinformation( 'Third' );
        //				break;
        //			case '4':
        //				$textNumber = functions::Xmlinformation( 'Fourth' );
        //				break;
        //			case '5':
        //				$textNumber = functions::Xmlinformation( 'Fifth' );
        //				break;
        //			case '6':
        //				$textNumber = functions::Xmlinformation( 'Sixth' );
        //				break;
        //			case '7':
        //				$textNumber = functions::Xmlinformation( 'Seventh' );
        //				break;
        //			case '8':
        //				$textNumber = functions::Xmlinformation( 'Eighth' );
        //				break;
        //			case '9':
        //				$textNumber = functions::Xmlinformation( 'ninth' );
        //				break;
        //			default:
        //				$textNumber = '';
        //				break;
        //		}
        return $textNumber;

    }
    #endregion

    #region nameDay
    public static function nameDay( $date ) {
        $explode_date = explode( '-', $date );
        $jmktime      = dateTimeSetting::jmktime( '0', '0', '0', $explode_date[1], $explode_date['2'], $explode_date[0] );

        return dateTimeSetting::jdate( "l", $jmktime );
    }
    #endregion

    #region saveQrCodeTrain
    public static function saveQrCodeTrain( $imageData, $name ) {
        $data = base64_decode( $imageData );
        $path = PIC_ROOT . "qrcode/" . $name . ".png";

        file_put_contents( $path, $data );
    }
    #endregion


    #region jdate
    public static function showDate( $format, $crationDateInt ) {
        return dateTimeSetting::jdate( $format, $crationDateInt );
    }
    #endregion


    #region checkParamsInput

    public static function checkParamsInput( $string ) {

        $string = str_replace( "'", "''", $string );
        $string = str_replace( array( "\n", "'", "‘", "’", "'", "“", "”", "„", "?", '"', '(', ')', '<', '>' ), array(
            "",
            "\’",
            "\’",
            "\’",
            "\’",
            "\"",
            "\"",
            "\"",
            "\"",
            "\"",
            '\"',
            '\"',
            '\"',
            '\"',
        ), $string );
        $string = stripslashes( $string );
        $string = escapeshellcmd( $string );
        $string = stripslashes( $string );
        $string = htmlspecialchars( $string );
        $string = addslashes( $string );
        $string = strip_tags( $string );

        return $string;
    }
    #endregion


    #region numberOfRoomsExternalHotelSearch
    public static function numberOfRoomsExternalHotelSearch( $rooms ) {
       
        $return   = array( 'rooms' => [], 'adultCount' => 0, 'childrenCount' => 0, 'countRoom' => 0 );
        $expRooms = explode( "R:", trim( $rooms ) );


        $count = 0;
        foreach ( $expRooms as $room ) {
            if ( $room != '' ) {
                $expRoom = explode( "-", $room );

                $return['rooms'][ $count ]['AdultCount']    = (int) $expRoom[0];
                $return['rooms'][ $count ]['ChildrenCount'] = (int) $expRoom[1];
                $return['rooms'][ $count ]['ChildrenAge']   = array();

                $return['adultCount']    += (int) $expRoom[0];
                $return['childrenCount'] += (int) $expRoom[1];

                if ( (int) $expRoom[1] > 0 ) {
                    $age = explode( ",", $expRoom[2] );
                    for ( $i = 0; $i <= count( $age ); $i ++ ) {

                        if ( isset( $age[ $i ] ) && $age[ $i ] != '' ) {
                            $return['rooms'][ $count ]['ChildrenAge'][ $i ] = (int) $age[ $i ];
                        }
                    }
                }

                $count ++;
            }
        }

        $return['countRoom'] = count( $return['rooms'] );

        return $return;
    }
    #endregion

    #region numberOfRoomsExternalHotelRequested
    public static function numberOfRoomsExternalHotelRequested( $rooms ) {
        $arrayRooms = array();
        foreach ( $rooms as $numberRoom => $room ) {
            for ( $adultCount = 0; $adultCount < $room['AdultCount']; $adultCount ++ ) {
                $arrayRooms[ $numberRoom ][ $adultCount ]['PassengerAge'] = 30;
                $arrayRooms[ $numberRoom ][ $adultCount ]['Gender']       = false;
            }

            for ( $childrenCount = 0; $childrenCount < $room['ChildrenCount']; $childrenCount ++ ) {
                $arrayRooms[ $numberRoom ][ $adultCount ]['PassengerAge'] = $room['ChildrenAge'][ $childrenCount ];
                $arrayRooms[ $numberRoom ][ $adultCount ]['Gender']       = false;
                $adultCount ++;
            }

        }

        return $arrayRooms;
    }
    #endregion

    #region DateJalali
    public static function DateFunctionWithLanguage( $param, $date ) {
        if ( SOFTWARE_LANG == 'fa' ) {
            $result = dateTimeSetting::jdate( $param, $date, '', '', 'en' );
        } else {
            $result = date( "$param", $date );

        }

        return $result;
    }
    #endregion

    #region DateJalali
    public static function CalenderMonthName( $m ) {
        $result = dateTimeSetting::monthName( $m );

        return $result;
    }
    #endregion

    #region DataIranTechGetWay
    /**
     * @param $ClientId
     *
     * @return bool
     */
    public static function CheckGetWayIranTech( $ClientId ) {
        $admin              = Load::controller( 'admin' );
        $dataGetWayIranTech = self::DataIranTechGetWay();
        $implode_gate_way = "'" . implode("','", $dataGetWayIranTech) . "'";


        $sql          = "SELECT * FROM bank_tb WHERE param1 IN ({$implode_gate_way}) AND enable='1'";
        $BankIranTech = $admin->ConectDbClient( $sql, $ClientId, "Select", "", "", "" );

        /** @var TYPE_NAME $ClientId */
        if (/*($ClientId=='4')||*/
        empty( $BankIranTech ) ) {
            return false;
        }

        return true;
    }
    #endregion

    #region CheckGetWayIranTech

    public static function DataIranTechGetWay() {
        $modelBase = Load::library( 'ModelBase' );
        $Sql       = "SELECT * FROM setting_bank_irantech WHERE is_enable='1'";
        $bank_lists = $modelBase->select( $Sql );

        $bank_params=[];
        foreach ($bank_lists as $bank_list) {
            $bank_params[] = $bank_list['userName'];
        }

        return $bank_params ;
    }

    #endregion


    public static function dataKeyIranTechGetWay() {
        //return '379918';
        return '5b8c0bc6-7f26-11ea-b1af-000c295eb8fc';
    }

    public static function allDataKeyIranTechGetWay() {
        //return '379918';
        return [ '5b8c0bc6-7f26-11ea-b1af-000c295eb8fc', '379918' ];
    }


    #region arabicToPersian
    public static function arabicToPersian( $string ) {
        $characters = array(
            'ك'  => 'ک',
            'دِ' => 'د',
            'بِ' => 'ب',
            'زِ' => 'ز',
            'ذِ' => 'ذ',
            'شِ' => 'ش',
            'سِ' => 'س',
            'ى'  => 'ی',
            'ي'  => 'ی',
            '١'  => '۱',
            '٢'  => '۲',
            '٣'  => '۳',
            '٤'  => '۴',
            '٥'  => '۵',
            '٦'  => '۶',
            '٧'  => '۷',
            '٨'  => '۸',
            '٩'  => '۹',
            '٠'  => '۰',
        );

        return str_replace( array_keys( $characters ), array_values( $characters ), $string );
    }
    #endregion


    //region percentPublic
    public static function percentPublic() {
        return ( 4 / 100 );
        //(25 / 1000);// to tarikh 25 tir 99 bargasht dade shod
    }
    //endregion

    //region ChangeIndexNameByLanguage
    public static function ChangeIndexNameByLanguage( $lang, $variable, $insteadVariable = '' ) {
        return ( ( $lang == 'fa' || $lang == '' ) ? ( $insteadVariable == '' ? $variable : $variable . $insteadVariable ) : $variable . '_en' );
    }

    //endregion
    public static function goToBankPasargadIranTech( $clientName = null ) {
        /** @var agency $agency*/
        $agency = Load::controller( 'agency' );
        $agencyInfo       = $agency->AgencyInfoByIdMember( $_POST['idMemberLoginToAdmin'] );
        require_once( LIBRARY_DIR . "bank/pasargad/RSAProcessor.class.php" );

        define( 'MERCHANT_CODE_AJAX', 379918 );
        define( 'TERMINAL_CODE_AJAX', 384790 );
        define( 'KEYPRIVATE_CODE_AJAX',
            '<RSAKeyValue><Modulus>vVYGdEx9XSxOY0+35rMTxdch/+6G9HdKHOGUsludVupUJjmM2fsA9FX33ds4yjh6TRk9JPEdA9H3kKRRYUUH4IAKviPxKUG5UW70E17otFUB3UEewQxDfPV+4EKgGguKUV6uO+tc7rhJ9ORoKh7qrYJcRG8srhPdAy3N5HmbK0E=</Modulus><Exponent>AQAB</Exponent><P>3Mnuzg8uEQj3upXCNzY2TWvw3b17aq1vZfKssq3auJyrtlE/VCqqZeKcncDDcHnz2SqmNCKtLjOtRWla9cHlnw==</P><Q>24f7Oz/03Rw424zn/D6bUAjBdskpY2t+PU+i3/rl68oqoZ7SZfu/d9ECKHPbw8NxbLaaSdcD1TwCUU/evWCDHw==</Q><DP>VTQMVzLeeS53w2aFs57VJ92O71NvLETP54zV/oI/FN1JGquR/94TMgxYmjxIb8BwTQ87YoU7RcglhtLYilyQSw==</DP><DQ>XBWD+mxvZ7gI2X8XaCVSvJWPoSXsKHnUcB9RcKYrf2ZDz5txIbohrD6Nqy4+BrWahEFsIoEAaJdNWZIpGkK7fQ==</DQ><InverseQ>UEuvirKmbzv+cuyXTtRxTPXcqQ/UvhghhGcbxl0dwcFZsjswCUZRfErAy5OrH+CW7dzfZxYz3LCsaA2qv6qcDw==</InverseQ><D>XbpHSa1P5h730yv0ku0VnbvJJgQzpLOk6bU2QjEeK5em/qFAu+wI5evk31wVue3JhX84CKCfx3NaxazCaI+evMdMFRv2F4Gqc7RBvnl3TcWlyZkEF/8iXH7OYqXpocVwCAgnfYWNQqlfANTEmUFhdMAT+biekC5goJ/K6FuGDm0=</D></RSAKeyValue>' );

        $timeStamp       = date( "Y/m/d H:i:s" );
        $invoiceDate     = date( "Y/m/d H:i:s" ); //تاريخ فاكتور
        $processor       = new RSAProcessor( KEYPRIVATE_CODE_AJAX, RSAKeyType::XMLString );
        $merchantCode    = MERCHANT_CODE_AJAX; // كد پذيرنده--
        $terminalCode    = TERMINAL_CODE_AJAX; // كد ترمينال--
        $continueAddress = ( isset( $_POST['factorNumber'] ) && ! empty( $_POST['factorNumber'] ) ) ?
            '&factorNumber=' . $_POST['factorNumber'] . '&idMember=' . $_POST['idMemberLoginToAdmin'] . '&type=creditAgency' : '';
        $redirectAddress = ROOT_ADDRESS_WITHOUT_LANG . '/itadmin/ticket/accountChargeReturnBank&bank=pasargad' . $continueAddress; //addres bargasht
        //         $redirectAddress = 'http://hihyper.ir/bank/returnBank.php?bank=pasargad&Usedid='.CLIENT_ID;
        $redirectAddress = str_replace( "\\", "/", $redirectAddress );
        $invoiceNumber   = ( isset( $_POST['factorNumber'] ) && ! empty( $_POST['factorNumber'] ) ) ? $_POST['factorNumber'] : 'charge' . mktime(); //شماره فاكتور
        //		$timeStamp       = $timeStamp;
        //		$invoiceDate     = $invoiceDate; //تاريخ فاكتور
        $action = "1003";  // 1003 : براي درخواست خريد --
        $amount = $_POST['amount'];
        $data   = "#" . $merchantCode . "#" . $terminalCode . "#" . $invoiceNumber . "#" . $invoiceDate . "#" . $amount . "#" . $redirectAddress . "#" . $action . "#" . $timeStamp . "#";
        $data   = sha1( $data, true );
        $data   = $processor->sign( $data ); // امضاي ديجيتال --
        $result = base64_encode( $data ); // base64_encode --

        //        echo 'SuccessAmountPayment##@@'.'<form  method="post" action="https://pep.shaparak.ir/gateway.aspx"--> id="payment">
        echo 'SuccessAmountPayment##@@' . '<form  method="post" action="https://indobare.com/developer/pasargardRedirectBank.php" id="payment">
            <input type="hidden" name="invoiceNumber" value="' . $invoiceNumber . '" />
            <input type="hidden" name="invoiceDate" value="' . $invoiceDate . '" />
            <input type="hidden" name="amount" value="' . $amount . '" />
            <input type="hidden" name="terminalCode" value="' . $terminalCode . '" />
            <input type="hidden" name="merchantCode" value="' . $merchantCode . '" />
            <input type="hidden" name="redirectAddress" value="' . $redirectAddress . '" />
            <input type="hidden" name="timeStamp" value="' . $timeStamp . '" />
            <input type="hidden" name="action" value="' . $action . '" />
            <input type="hidden" name="sign" value="' . $result . '" />
            <input type="hidden" name="nameAgency" value="' . $clientName . '" />
            <input type="submit" id="Send">
        </form>';

    }



    /*Accountant Functions Added by Ali Qorbani*/
    /**
     * @param string $data
     * @param null   $status
     * @param bool   $echo
     *
     * @return string
     */
    public static function Json( $data = '', $status = null, $echo = false ) {
        $status = $status ? (int) $status : 200;
        http_response_code( $status );
        //		header( 'Content-type: application/json; charset=utf-8' );
        $json = json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_BIGINT_AS_STRING );
        if ( $echo ) {
            echo $json;
            die();
        }

        return $json;
    }

    /**
     * @param string $data
     * @param string $message
     * @param int    $status
     * @param bool   $echo
     *
     * @return string
     */
    public static function JsonError( $data = '', $message = 'Error', $status = 400, $echo = false ) {
        $data = array( 'type' => 'error', 'success' => false, 'message' => $message, $data );

        return self::Json( $data, $status, $echo );
    }

    /**
     * @param string $data
     * @param string $message
     * @param int    $status
     * @param bool   $echo
     *
     * @return string
     */
    public static function JsonSuccess( $data = '', $message = 'Success', $status = 200, $echo = false ) {
        $data = array( 'type' => 'success', 'success' => true, 'message' => $message, $data );

        return self::Json( $data, $status, $echo );
    }

    /**
     * @param null $request_number
     *
     * @return bool|string
     */
    public static function accountantRequestInsertData( $request_number = null ) {
        if ( ! $request_number ) {
            self::insertLog( 'No Request number', 'log_s360_to_accountant' );

            return self::JsonError( [ 'No Request Number' ] );
        }

        /** @var ModelBase $modelBase */
        $modelBase = Load::library( 'ModelBase' );
        $cid       = CLIENT_ID;
        $sql       = "SELECT * FROM clients_tb WHERE id={$cid}";
        $client    = $modelBase->load( $sql );
        $pin       = $client['PinAllowAccountant'];
        if ( ! $pin ) {
            return false;
        }

        $json_data  = self::accountantApiGenerateJson( $request_number, $pin );
        $array_data = json_decode( $json_data, true );
        if ( ! $array_data['successfull'] ) {
            self::insertLog( 'No Request number', 'log_s360_to_accountant' );

            return self::JsonError( 'unsuccessful', 'Request not complete' );
        }

        self::insertLog( $json_data, 'log_s360_to_accountant' );

        /*todo: update url when its online */
        $url = 'http://192.168.1.100/parvaz_at/accountantApi/index.php';

        /** @var agency_tb $agency */
        $agency        = Load::model( "agency" );
        $primaryAgency = $agency->getPrimaryAgency();
        $agencyId      = $primaryAgency['id'];


        $price = self::accountantGetTicketTotalPrice( $request_number );

        //		self::accountantApiRequestInsertBrokerData($agencyId, $price, 'decrease', 'بابت بلیت فروخته شده');
        $request = self::curlExecution( $url, $json_data );
        self::insertLog( $json_data, 'log_accountant_to_360' );

        return json_encode( $request );


    }

    /**
     * @param null $request_number
     *
     * @return bool|array
     */
    public static function accountantGetAllPassengersData( $request_number = null ) {
        if ( ! $request_number ) {
            return false;
        }
        /** @var Model $Model */
        $Model   = Load::library( 'Model' );
        $sql     = " SELECT * FROM book_local_tb WHERE request_number='{$request_number}' ";
        $records = $Model->select( $sql );

        return $records;
    }

    /**
     * @param string $flight_type
     *
     * @return string
     */
    public static function accountantSetVehicle( $flight_type = '' ) {
        if ( $flight_type == 'system' ) {
            return 'هواپیمایی - سیستمی';
        }
        if ( $flight_type == 'charter' || $flight_type = 'charterPrivate' ) {
            return 'هواپیمایی - چارتری';
        }

        return $flight_type;
    }

    /**
     * @param null $request_number
     *
     * @return bool|float
     */
    public static function accountantGetTicketTotalPrice( $request_number = null ) {
        if ( ! $request_number ) {
            return false;
        }

        return self::CalculateDiscount( $request_number );
    }

    /**
     * @param null   $member_id
     * @param string $index
     *
     * @return bool
     */
    public static function accountantGetMemberData( $member_id = null, $index = '' ) {
        if ( $member_id ) {
            return false;
        }

        $sql = "SELECT * FROM members_tb WHERE id='{$member_id}'";
        /** @var Model $model */
        $model = Load::library( 'Model' );
        $data  = $model->load( $sql );

        return ! empty( $data[ $index ] ) ? $data[ $index ] : $data;
    }

    /**
     * @param null $client_id
     *
     * @return bool
     */
    public static function accountantApiGetClientData( $client_id = null ) {
        if ( ! $client_id ) {
            $client_id = CLIENT_ID;
        }
        $modelBase = Load::library( 'ModelBase' );
        $sql       = "SELECT * FROM clients_tb WHERE id='{$client_id}'";
        $client    = $modelBase->load( $sql );
        if ( $client ) {
            return $client;
        }

        return false;
    }

    /**
     * @param null $pin
     * @param null $client_id
     *
     * @return bool
     */
    public static function accountantApiCheckAccess( $pin = null, $client_id = null ) {
        /** @var ModelBase $modelBase */
        if ( ! $pin ) {
            return false;
        }
        $client_id = $client_id ?: CLIENT_ID;
        $client    = self::accountantApiGetClientData( $client_id );
        $clientPin = $client['PinAllowAccountant'];
        if ( ! $clientPin || $pin != $clientPin ) {
            return false;
        }

        return true;
    }

    public static function getAgencyByUserId( $user_id = null ) {
        if ( ! $user_id ) {
            return false;
        }
        /** @var members_tb $memberModel */
        /** @var agency_tb $agencyModel */
        $memberModel = Load::model( 'members' );
        $agencyModel = Load::model( 'agency' );
        $member      = $memberModel->get( $user_id );
        $agencyId    = $member['fk_agency_id'];
        if ( $agencyId ) {
            return $agencyModel->get( $agencyId );
        }

        return false;
    }

    /**
     * @param null   $agency_id
     * @param int    $amount
     * @param string $action
     * @param string $comment
     *
     * @return string
     */
    public static function accountantApiGenerateBrokerJson(
        $agency_id = null, $amount = 0, $action = 'increase', $comment = ''
    ) {
        /** @var Model $Model */
        /** @var agency_tb $agencyModel */

        Load::library( 'Model' );
        Session::init();
        $userId                 = Session::getUserId();
        $client                 = self::accountantApiGetClientData( CLIENT_ID );
        $return['system_owner'] = $client['PinAllowAccountant'];
        $agencyModel            = Load::model( 'agency' );
        if ( $agency_id ) {
            $agency = $agencyModel->get( $agency_id );
        } else {
            /** @var agency $agencyController */
            $agencyController = Load::controller( 'agency' );
            $agency           = $agencyController->AgencyInfoByIdMember( $userId );
            //			$agency = self::getAgencyByUserId($userId);
        }
        if ( $agency['id'] == $agencyModel->getPrimaryAgency()['id'] ) {
            if ( $action == 'increase' ) {
                $action = 'decrease';
            } else {
                $action = 'increase';
            }
        }
        $return['request'] = array(
            'action'            => $action,
            'comment'           => $comment,
            'broker'            => [ 'cellphone' => $agency['mobile'], 'isColleague' => $agency['isColleague'] ],
            'amount'            => $amount,
            'payment_unit'      => 'rial',
            'payment_bank_name' => 'تنخواه حساب اینترنتی',
        );

        return self::Json( $return );

    }

    /**
     * @param null   $agency_id
     * @param int    $amount
     * @param string $action
     * @param string $comment
     *
     * @return bool|string
     * @internal param null $client_id
     */
    public static function accountantApiRequestInsertBrokerData(
        $agency_id = null, $amount = 0, $action = 'increase', $comment = ''
    ) {
//		$json = self::accountantApiGenerateBrokerJson( $agency_id, $amount, $action, $comment );
//		self::insertLog( $json, 'log_s360_to_accountant_broker' );
//		/*todo: update url when its online */
//		$url = 'http://192.168.1.100/parvaz_at/accountantApi/broker-accountant.php';
//
//		$request = self::Json( self::curlExecution( $url, $json ) );
//		self::insertLog( $request, 'log_accountant_broker_to_s360' );
//
//		return self::Json( $request );
    }

    public static function accountantApiRequestInsertBrokerBothData(
        $agency_id = null, $amount = 0, $comment = '', $request_type = 'system_owner'
    ) {


//		/** @var agency_tb $agencyModel */
//		$agencyModel = Load::model( 'agency' );
//
//		$primary = $agencyModel->getPrimaryAgency();
//		$one     = $two = '';
//
//		switch ( $request_type ) {
//			case 'owner':
//				$one = self::accountantApiRequestInsertBrokerData( $primary['id'], $amount, 'increase', $comment );
//				break;
//			case 'colleague_owner':
//				$one = self::accountantApiRequestInsertBrokerData( $agency_id, $amount, 'decrease', $comment );
//				break;
//			case 'colleague_fast' :
//				$one = self::accountantApiRequestInsertBrokerData( $agency_id, $amount, 'decrease', $comment );
//				$two = self::accountantApiRequestInsertBrokerData( $primary['id'], $amount, 'increase', $comment );
//				break;
//			default :

//		}


//		return self::Json( [ json_decode( $one ), json_decode( $two ) ] );
    }

    /**
     * @param null $request_number
     *
     * @return array|bool
     */
    public static function getBrokerByRequest( $request_number = null ) {
//		if ( ! $request_number ) {
//			return false;
//		}
//		/** @var Model $model */
//		$model = Load::library( 'Model' );
//		$sql   = "SELECT * FROM book_local_tb WHERE request_number = '{$request_number}';";
//		if ( TYPE_ADMIN == '1' ) {
//			/** @var ModelBase $model */
//			$model = Load::library( 'ModelBase' );
//			$sql   = "SELECT * FROM report_tb WHERE request_number = '{$request_number}';";
//		}
//		$res    = $model->load( $sql );
//		$broker = array();
//
//		if ( $res['pid_private'] == 1 ) {
//			$broker['name'] = $res['airline_name'];
//		}
//
//		if ( $res['pid_private'] != 1 ) {
//			$broker['name'] = 'ایران تکنولوژی';
//		}
//
//		return $broker;


    }

    /**
     * @param null $request_number
     * @param null $pin
     *
     * @return bool|string
     */
    public static function accountantApiGenerateJson( $request_number = null, $pin = null ) {
//		if ( ! $request_number || ! $pin ) {
//			return false;
//		}
//		$successfull         = false;
//		$results             = self::accountantGetAllPassengersData( $request_number );
//		$customer            = $passengers = $tours = $payment = $requests = array();
//		$supplier_commission = $all_total = $agency_commission = $adt_count = $chd_count = $inf_count = 0;
//		foreach ( $results as $data ) {
//			if ( $data['successfull'] == 'book' ) {
//				$successfull = true;
//			}
//
//			$supplier_commission += $data['supplier_commission'];
//			$edit_time           = explode( ' ', $data['last_edit'] );
//			$adt_count           += $data['adt_qty'];
//			$chd_count           += $data['chd_qty'];
//			$inf_count           += $data['inf_qty'];
//			$fare_index          = strtolower( $data['passenger_age'] . '_fare' );
//			$tax_index           = strtolower( $data['passenger_age'] . '_tax' );
//			$total_index         = strtolower( $data['passenger_age'] . '_price' );
//			$all_total           += $data[ $total_index ];
//			$passengers[]        = array(
//				'name'          => $data['passenger_name_en'],
//				'surname'       => $data['passenger_family_en'],
//				'name_fa'       => $data['passenger_name'] . ' ' . $data['passenger_family'],
//				'passport'      => $data['passportNumber'],
//				'national_code' => $data['passenger_national_code'],
//				'age'           => strtoupper( str_replace( 'Adt', 'ADL', $data['passenger_age'] ) ),
//				'sex'           => str_replace( [ 'Female', 'Male' ], [
//					'MRS',
//					'MR',
//				], $data['passenger_gender'] ),
//				'relation'      => "اقوام",
//				'pnr'           => $data['pnr'],
//				'tiket_number'  => $data['eticket_number'],
//				'fare'          => (int) $data[ $fare_index ],
//				'total'         => (int) $data[ $total_index ],
//				'airport_tax'   => (int) $data[ $tax_index ],
//
//			);
//
//			$customer = array(
//				'cellphone'    => ! empty( $data['member_mobile'] ) ? $data['member_mobile'] : self::accountantGetMemberData( $data['member_id'], 'mobile' ),
//				'name'         => ! empty( $data['member_name'] ) ? $data['member_name'] : self::accountantGetMemberData( $data['member_id'], 'name' ),
//				'english_name' => $data['passenger_name_en'],
//				'surname'      => $data['passenger_family_en']
//			);
//
//			$tours = array(
//				'service_type'   => 5,
//				'adult_count'    => $adt_count,
//				'child_count'    => $chd_count,
//				'infant_count'   => $inf_count,
//				'airport_name'   => '',
//				'vehicle'        => self::accountantSetVehicle( $data['flight_type'] ),
//				'voucher_number' => $data['request_number'],
//				'flight_code'    => $data['flight_number'],
//				'airline'        => $data['airline_iata'],
//				'origin'         => [ ( $data['IsInternal'] ) ? "IRN" : "", $data['origin_airport_iata'] ],
//				'destination'    => [ ( $data['IsInternal'] ) ? "IRN" : "", $data['desti_airport_iata'] ],
//				'register'       => [ $edit_time[0], substr( $edit_time[1], 0, - 3 ) ],
//				'departure'      => [ $data['date_flight'], substr( $data['time_flight'], 0, - 3 ) ],
//			);
//
//			$agent_id = $data['agency_id'];
//			/** @var agency_tb $agencyModel */
//			$agencyModel = Load::model( 'agency' );
//			if ( $agent_id > 0 ) {
//				$agency = $agencyModel->get( $agent_id );
//			} else {
//				$agency = $agencyModel->getPrimaryAgency();
//			}
//			$agent = array(
//				'cellphone' => $agency['mobile'],
//				'email'     => $agency['email'],
//				'name'      => $agency['name_fa'],
//				'type'      => $agency_type = $agency['isColleague'] ? 3 : 4,
//				'name_en'   => $agency['name_en'],
//			);
//
//			$tours['agent'] = $agent;
//
//			$tours['broker'] = self::getBrokerByRequest( $request_number );
//			/*todo : get email of Counter (user) also this user must be added to accountant database */
//			/** @var members_tb $member */
//			$member    = Load::model( 'members' );
//			$getMember = $member->get( $data['member_id'] );
//
//			$tours['member'] = array( 'email' => $getMember['email'] );
//			$payment_date    = explode( ' ', $data['payment_date'] );
//			$date            = ( $payment_date[0] ) ?: date( 'Y-m-d', time() );
//			$time            = ( $payment_date[1] ) ?: date( 'H:i:s', time() );
//			$payment         = array(
//				'all_total'             => $all_total,
//				'amount'                => self::accountantGetTicketTotalPrice( $request_number ),
//				'supplier_amount'       => $supplier_commission,
//				/*todo : we use payment amount as 'rial' for all local tickets */
//				'unit'                  => 'rial',
//				'type'                  => $data['payment_type'],
//				'bank_transaction_code' => $data['tracking_code_bank'],
//				'bank_name'             => $data['name_bank_port'],
//				/**todo: must get bank name*/
//				/*'account_number'        => '001187541',
//				// todo account number must be dynamic refer to Mr Alizadeh
//				*/
//				'date'                  => $date,
//				'time'                  => $time,
//				'completed'             => true
//				/**todo : change to false if needs accountant to accept it */
//			);
//
//		}
//
//		$passengers[0]['agency_commission'] = $all_total - self::accountantGetTicketTotalPrice( $request_number );
//		$requests['customer']               = $customer;
//		$requests['passengers']             = $passengers;
//		$requests['tours']                  = $tours;
//		$requests['payment']                = $payment;
//
//		return self::Json( [
//			'successfull'  => $successfull, /*todo: get system owner by unique hash code */
//			'system_owner' => $pin,
//			'requests'     => $requests,
//		] );
    }

    /**
     * @param $requestNumber
     *
     * @return bool
     */
    public static function checkPrivateFlight( $requestNumber ) {
        /** @var airline $airlineController */
        $airlineController        = Load::controller( 'airline' );
        $infoTicket               = self::findTicket( $requestNumber );
        $infoTicket['info']       = 'charter724';
        $infoTicket['airline']    = $infoTicket['airline_iata'];
        $infoTicket['flightType'] = $infoTicket['flight_type'];

        return ( $infoTicket['pid_private'] == '1' && $airlineController->checkSourceAirline( $infoTicket ) );
    }

    /**
     * @param null $status
     *
     * @return string
     */
    public static function showPersianTicketStatus( $status = null ) {
        switch ( $status ) {
            case 'book':
                $str = 'رزرو قطعی';
                break;
            case 'bank':
                $str = 'اتصال به درگاه';
                break;
            case 'error' :
                $str = 'خطا';
                break;
            case 'credit' :
                $str = 'اعتباری';
                break;
            case 'prereserve':
                $str = 'پیش رزرو';
                break;
            case 'nothing':
                $str = 'نامشخص';
                break;
            default :
                $str = 'نامشخص';
                break;
        }

        return $str;
    }

    #region UniqueCode

    public static function getChargeCharter724( $userName ) {
//        $url       = "http://safar360.com/Core/V-1/Flight/getCredit/" . $userName;
        $url       = "http://safar360.chartertech.ir/Core/V-1/Flight/getCredit/" . $userName;
        $JsonArray = array();
        return  self::curlExecution( $url, $JsonArray, 'yes' );
    }

    #endregion

    public static function compareCreditInCharter724( $username, $requestNumber ) {

        $smsController = Load::controller( 'smsServices' );

        $amountBuy     = self::CalculateDiscount( $requestNumber );

        $compareCredit = self::getChargeCharter724( $username );


        $charge_provider = intval( $compareCredit['data']['child_charge'] ) ;
       Load::controller('infoCreditCharter724')->setRecordeCreditCharter724($charge_provider) ;

        $amount_client = intval( $amountBuy ) ;
        if ( ( $charge_provider - $amount_client ) < 200000000 ) {
          $charge_provider = number_format($charge_provider/10);
          $amount_client =  number_format($amount_client/10);
            $objSms = $smsController->initService( '1' );
            if ( $objSms ) {
                $sms       = "{$charge_provider}  ومبلغ خرید مشتری {$amount_client} است";
                $cellArray = array(
                    'abasi2' => '09057078341',
                    'alami' => '09155909722',
                );

                if ($objSms) {
                    $smsController->smsByPattern('mvkkl0yeqvgs5yc', $cellArray, array('credit' => $charge_provider,'amount'=> $amount_client));

                }


            }
        }
    }


    public static function compareDateTrain( $moveDate, $exitDate ) {
        if ( str_replace( '-', '', $moveDate ) != str_replace( '-', '', $exitDate ) ) {
            return $exitDate;
        }

        return $moveDate;
    }


    public static function compareTimeTrainForShowList( $timeMove, $moveDate, $exitDate ) {

        if ( date( 'Ymd', time() ) == str_replace( '-', '', $moveDate ) || date( 'Ymd', time() ) == str_replace( '-', '', $exitDate ) ) {
            $time     = time();
            $timeMove = substr(str_replace( ':', '', $timeMove ),0,4);

            $timeNow = dateTimeSetting::jdate( 'Hi', $time, '', '', 'en' );

            if ( $timeMove >= $timeNow ) {
                return true;
            }

            return false;
        }

        return true;

    }


    #region timeNow
    public static function timeNow() {
        return dateTimeSetting::jdate( "Y-m-d", time(), '', '', 'en' );
    }
    public static function daysAgo($days) {
        return dateTimeSetting::jdate(
            "Y-m-d",
            strtotime("-{$days} days"),
            '',
            '',
            'en'
        );
    }

    #endregion

    #region isLocalServer
    /**
     * helper function to check if it is local server or not
     *
     * @return bool
     */
    public static function isLocalServer() {
        return ( strpos( $_SERVER["HTTP_HOST"], '192.168.1.100' ) !== false ) ? true : false;
    }
    #endregion

    #region isTestServer
    /**
     * helper function to check if it is Test server or not
     *
     * @return bool
     */
    public static function isTestServer( $host = '' ) {
        $servers = array( 'online.1011.ir', 'agency.1011.ir', 'test.1011.ir', '192.168.1.100','online.miss24.ir','ababil24.ir');
        $res     = false;
        if ( ! empty( $host ) ) {
            if ( is_array( $host ) ) {
                foreach ( $host as $item ) {
                    array_push( $servers, $item );
                }
            }
            if ( is_string( $host ) ) {
                array_push( $servers, $host );
            }
        }
        foreach ( $servers as $server ) {
            if ( ( strpos( $_SERVER["HTTP_HOST"], 's360online' ) === false ) && ( strpos( $_SERVER["HTTP_HOST"], $server ) !== false ) ) {
                $res = true;
            }
        }

        return $res;
    }

    #endregion

    public static function displayErrorLog( $host = '' ) {
        if ( self::isTestServer( $host ) ) {
            error_reporting( 0 );
            error_reporting( E_ALL | E_STRICT );
            @ini_set( 'display_errors', 1 );
            @ini_set( 'display_errors', 'on' );
        }
    }

    #region checkHistoryRequestUser

    /**
     * @param $userId
     * @param $ip
     * @param $Model
     *
     * @return mixed
     */
    public static function checkHistoryRequestUser() {
        $userId = Session::getUserId();
        $ip     = $_SERVER['REMOTE_ADDR'];

        $Model                       = Load::library( 'Model' );
        $checkCountChangePasswordSql = "SELECT * FROM check_change_password_tb WHERE ip='{$ip}'";
        $checkCountRepeat            = $Model->load( $checkCountChangePasswordSql );
        return $checkCountRepeat;
    }
    #endregion

    /**
     * @param $dataCheck
     * @param $userId
     * @param $Model
     */
    public static function insertCheckRequest() {
        $Model                                   = Load::library( 'Model' );
        $dataCheck['ip']                         = $_SERVER['REMOTE_ADDR'];
        $dataCheck['user_id']                    = ( Session::getUserId() > 0 ) ? Session::getUserId() : '';
        $dataCheck['count']                      = 1;
        $dataCheck['creation_date_int']          = time();
        $dataCheck['allow_time_change_password'] = time();
        $Model->setTable( 'check_change_password_tb' );
        $Model->insertLocal( $dataCheck );
    }

    /**
     * @param $checkCountRepeat
     * @param $dataCheck
     * @param $userId
     * @param $Model
     */
    public static function updateCheckRequest( $checkCountRepeat ) {
        $userId                                  = Session::getUserId();
        $Model                                   = Load::library( 'Model' );
        $dataCheck['count']                      = $checkCountRepeat['count'] + 1;
        $dataCheck['allow_time_change_password'] = time();
        $condition                               = "id='{$checkCountRepeat['id']}' AND  ip='{$_SERVER['REMOTE_ADDR']}'";
        $Model->setTable( 'check_change_password_tb' );
        $Model->update( $dataCheck, $condition );
    }

    #region ImageResulution
    public static function getExtensionImage( $str ) {
        $i = strrpos( $str, "." );
        if ( ! $i ) {
            return "";
        }
        $l   = strlen( $str ) - $i;
        $ext = substr( $str, $i + 1, $l );

        return $ext;
    }


    public static function getNameImage( $str ) {
        $i = strrpos( $str, "." );
        if ( ! $i ) {
            return "";
        }
        $l    = strlen( $str ) - $i;
        $name = substr( $str, 0, $i );

        return $name;
    }


    public static function ResolutionChanger( $NameFile, $Resolutions ) {
        if ( $NameFile != '' && $Resolutions != '' ) {
            if ( file_exists( ROOT_ADDRESS_WITHOUT_LANG . "/pic/resolutions/" . getNameImage( $NameFile ) . "x$Resolutions." . getExtensionImage( $NameFile ) ) ) {
                return ROOT_ADDRESS_WITHOUT_LANG . "/pic/resolutions/" . getNameImage( $NameFile ) . "x$Resolutions." . getExtensionImage( $NameFile );
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    #endregion

    #region
    public static function infoInsurance( $code ) {


        if ( TYPE_ADMIN == '1' ) {
            $ModelBase     = Load::library( 'ModelBase' );
            $sql           = "SELECT * FROM report_insurance_tb WHERE pnr='{$code}'";
            $insuranceInfo = $ModelBase->load( $sql );
        } else {
            $Model         = Load::library( 'Model' );
            $sql           = "SELECT * FROM book_insurance_tb WHERE pnr='{$code}'";
            $insuranceInfo = $Model->load( $sql );
        }

        return $insuranceInfo;
    }
    #endregion


    #region checkCookie
    public static function checkSessionString( $httpRefer, $session ) {
        if ( strpos( $httpRefer, $session ) !== false ) {

            return true;
        }

        return false;
    }

    #endregion


    #region dateDiff
    public static function dateDiff( $startDate, $endDate ) {
        $date1 = date_create( $startDate );
        $date2 = date_create( $endDate );
        $diff  = date_diff( $date1, $date2 );

        return $diff->format( '%d' );
    }
    #endregion

    #region generateFactorNumber
    public static function generateFactorNumber() {
        $factorNumber = substr( time(), 0, 3 ) . mt_rand( 0000, 9999 ) . substr( time(), 7, 10 );

        return $factorNumber;
    }
    #endregion

    #region DateWithName
    public static function DateWithName( $param, $type = null ) {
        $param        = str_replace( '/', '-', $param );
        $explode_date = explode( '-', $param );
        if ( $explode_date[0] > 1450 && SOFTWARE_LANG == 'fa' ) {
            $DateName      = date( " l , j F Y", strtotime( $param ) );
        } else {
            if ( SOFTWARE_LANG != 'fa' && $explode_date[0] > 1450 ) {
                //                $dateGregorian = self::ConvertToMiladi($param);
                $DateName = date( " l , j F Y", strtotime( $param ) );
            } else {
                $jmktime  = dateTimeSetting::jmktime( 0, 0, 0, $explode_date[1], $explode_date[2], $explode_date[0] );
                $DateName = dateTimeSetting::jdate( "l, j F Y", $jmktime );
            }
        }

        return $DateName;
    }
    #endregion

    #region getAirport
    public static function getAirport( $param ) {
        $ModelDb       = Load::library( 'Model' );
        $continueQuery = '';
        if ( $param[0] == 'dept' ) {
            $continueQuery = " WHERE  local_portal='0' GROUP BY  Departure_Code   ORDER BY  priorityDeparture=0,priorityDeparture DESC ";
        } elseif ( $param[0] == 'arrival' ) {
            $continueQuery = "WHERE Departure_Code='{$param[1]}' AND local_portal='0' ORDER BY  priorityArrival=0,priorityArrival DESC";
        }

        $sql = " SELECT   *  FROM flight_route_tb  $continueQuery";

        $cities                            = $ModelDb->select( $sql, 'assoc' );
        $indexByLnaguage['Departure_City'] = ( SOFTWARE_LANG == 'fa' ) ? 'Departure_City' : 'Departure_CityEn';
        $indexByLnaguage['Arrival_City']   = ( SOFTWARE_LANG == 'fa' ) ? 'Arrival_City' : 'Arrival_CityEn';
        $result                            = array();
        foreach ( $cities as $key => $city ) {
            $result[ $key ]                             = $city;
            $result[ $key ]['Departure_CityByLanguage'] = $city[ $indexByLnaguage['Departure_City'] ];
            $result[ $key ]['Arrival_CityByLanguage']   = $city[ $indexByLnaguage['Arrival_City'] ];
        }

        return ( json_encode( $result ) );
    }

    #endregion

    #region ConvertToJalaliOfDateGregorian
    public static function ConvertToJalaliOfDateGregorian( $date, $typeShow = ' H:i:s Y-m-d ' ) {

        return dateTimeSetting::jdate( $typeShow, strtotime( $date ), '', '', 'en' );

    }
    #endregion
    #region
    public static function limitWords( $text = '', $count = 100 ) {
        $text   = self::strip_html_tags( $text );
        $text   = str_replace( "  ", " ", $text );
        $string = explode( " ", $text );
        $trimed = '';
        for ( $wordCounter = 0; $wordCounter <= $count; $wordCounter ++ ) {
            $trimed .= $string[ $wordCounter ];
            if ( $wordCounter < $count ) {
                $trimed .= " ";
            } else {
                $trimed .= "...";
            }
        }
        $trimed = trim( $trimed );

        return $trimed;
    }
    #endregion

    #region [configData]
    public static function configDataRoute( $data ) {


        // for multiway routes
        if(is_array($data))
        {
            $i=0;
            while($data['departure'][$i]){
                $dataFinal['info_city'][] = array(
                    'Origin'=> $data['departure'][$i],
                    'Destination'=> $data['arrival'][$i],
                    'DepartureDate'=> $data['departuredate'][$i],
                );

                $i++ ;
            }
            $dataFinal['origin']=  $data['departure'][0];
            $dataFinal['destination']= $data['arrival'][0];
            $dataFinal['DepartureDate'] = $data['departuredate'][0];
            $dataFinal['isInternal'] = false;
            $dataFinal['MultiWay']    = 'multi_destination';
            $dataFinal['typeSearch']  = 'international';
            $dataFinal['arrivalDate'] = '';
            $dataFinal['adult']  = $data['adult'];
            $dataFinal['child']  = $data['child'];
            $dataFinal['infant'] = $data['infant'];
            $dataFinal['totalPerson'] = $dataFinal['adult'] + $dataFinal['child'] + $dataFinal['infant'];
        }
        else{
            $explodeData      = explode( '/', $data );

            $afterExplodeData = array();

            foreach ( $explodeData as $key => $DataSingle ) {
                $afterExplodeData[ $key ] = functions::checkParamsInput( $DataSingle );
            }

            $dataRoute = array();
            if(isset($explodeData[5])){
                $placeExplode = explode( '-', $explodeData[5] );
                $dataFinal['origin']        = $placeExplode[0];
                $dataFinal['destination']   = $placeExplode[1];
            }

            if(isset($explodeData[6])){
                $dateExplode  = explode( '&', $explodeData[6] );
                $dataFinal['departureDate'] = $dateExplode[0];
                $dataFinal['departure_date_en'] = functions::forceDateSearchToMiladi($dateExplode[0]);
                $dataFinal['arrivalDate']   = ! empty( $dateExplode[1] ) ? $dateExplode[1] : '';
                $dataFinal['arrival_date_en']   = ! empty( $dateExplode[1] ) ? functions::forceDateSearchToMiladi($dateExplode[1]) : '';


            }
            $dataFinal['typeSearch']    = ! empty( $explodeData[3] ) ? $explodeData[3] : '';

            if ( $dataFinal['typeSearch'] == 'searchPackage' ) {
                $roomsPerson         = explode( '&', $explodeData[8] );
                $dataFinal['adult']  = 0;
                $dataFinal['child']  = 0;
                $dataFinal['infant'] = 0;
                $roomxx              = array();
                $dataFinal['Rooms']  = array();
                $personExplode       = array();
                foreach ( $roomsPerson as $keyRoom => $room ) {
                    $personExplode      = explode( '-', $room );
                    $dataFinal['adult'] += $personExplode[0];

                    if ( $personExplode[1] > 0 ) {
                        $typePassenger       = self::type_passengers( date( 'Y-m-d', strtotime( '-' . $personExplode[2] . ' years' ) ) );
                        $dataFinal['child']  += ( $typePassenger == 'Chd' ) ? $personExplode[1] : 0;
                        $dataFinal['infant'] += ( $typePassenger == 'Inf' ) ? $personExplode[1] : 0;

                    } else {
                        $dataFinal['child']  += 0;
                        $dataFinal['infant'] += 0;
                    }

                    $roomsPeople[ $keyRoom ]['adult'] = $personExplode[0];
                    $roomsPeople[ $keyRoom ]['child'] = $personExplode[1];
                    $ageChild                         = explode( ',', $personExplode[2] );

                    foreach ( $ageChild as $keyChild => $child ) {
                        if ( $child > 0 ) {
                            $roomsPeople[ $keyRoom ]['ageChild'][ $keyRoom ][] = $child;
                        } else {
                            $roomsPeople[ $keyRoom ]['ageChild'][ $keyRoom ][] = '';
                        }

                    }
                }
                $dataFinal['Rooms'] = $roomsPeople;

//                $dataFinal['privateSearch'] = true;

            } else {
                $personExplode       = explode( '-', isset( $explodeData[8] ) ? $explodeData[8] : (isset($explodeData[7]) ? $explodeData[7] :'1-0-0') );
                $dataFinal['adult']  = ! empty( $personExplode[0] ) ? $personExplode[0] : '1';
                $dataFinal['child']  = ! empty( $personExplode[1] ) ? $personExplode[1] : '0';
                $dataFinal['infant'] = ! empty( $personExplode[2] ) ? $personExplode[2] : '0';
            }
            $dataFinal['MultiWay']    = ( ! empty( $dataFinal['arrivalDate'] ) ) ? 'TwoWay' : 'OneWay';
            $dataFinal['totalPerson'] = $dataFinal['adult'] + $dataFinal['child'] + $dataFinal['infant'];

            // Parse classFlight (economy, business, premium) from URL for search-flight and international
            // Only set if it exists in URL - no default value
            if(($dataFinal['typeSearch'] == 'search-flight' || $dataFinal['typeSearch'] == 'international') && isset( $explodeData[9] ) && !empty( $explodeData[9] )) {
                $dataFinal['classFlight'] = $explodeData[9];
            }

            if($dataFinal['typeSearch'] == 'international')
            {
                $dataFinal['isInternal'] = false;
            }else{
                // For search-flight or international, check explodeData[10] for isInternal, otherwise use explodeData[9]
                $internalIndex = ($dataFinal['typeSearch'] == 'search-flight' || $dataFinal['typeSearch'] == 'international') ? 10 : 9;
                if ( isset( $explodeData[$internalIndex] ) && $explodeData[$internalIndex] != "" ) {
                    if ( $explodeData[$internalIndex] == '1' ) {
                        $dataFinal['isInternal'] = true;
                    } elseif ( $explodeData[$internalIndex] == '0' ) {
                        $dataFinal['isInternal'] = false;
                    }
                }else{
                    $dataFinal['isInternal'] = true;
                }
            }
        }

        return $dataFinal;

    }
    #endregion

    #region ExternalRomsHotelForSearch
    public static function ExternalRomsHotelForSearch( $rooms = array() ) {
        $searchParams = array();
        foreach ( $rooms as $key => $room ) {
            $childCount = $adultCount = 0;
            $age        = array();
            foreach ( $room as $passenger ) {

                if ( $passenger['PassengerAge'] != 0 ) {
                    $age[] = $passenger['PassengerAge'];
                }

                if ( $passenger['PassengerAge'] > 12 ) {
                    $adultCount ++;
                } else {
                    $childCount ++;
                }
            }
            $searchParams['roomsArray'][] = array( 'Adults' => $adultCount, 'Children' => $childCount, 'Ages' => $age );
        }

        return $searchParams;
    }

    #endregion

    public static function searchBusCities( $params ) {
        $ModelBase = Load::library( 'ModelBase' );

        $clientSql = " SELECT * FROM bus_route_tb WHERE iataCode !=''
                        AND
                        (name_fa LIKE '%{$params['searchingValue']}%'
                        OR name_en LIKE '%{$params['searchingValue']}%'
                        OR iataCode LIKE '%{$params['searchingValue']}%'
                        OR code LIKE '%{$params['searchingValue']}%')
                        ";

        return $ModelBase->select( $clientSql );
    }

    public static function getRoute( $iataCode ) {

        $ModelBase = Load::library( 'ModelBase' );
        $sql       = " SELECT * FROM bus_route_tb WHERE  iataCode = '{$iataCode}'";
        $route     = $ModelBase->load( $sql );

        return $route;
    }

    public static function getRoutes() {
        $ModelBase = Load::library( 'ModelBase' );
        $sql       = " SELECT * FROM bus_route_tb WHERE  iataCode != ''";
        $route     = $ModelBase->select( $sql );

        return $route;
    }

    public static function changeCurrencyName( $title ) {
        switch ( $title ) {

            case "دلار":
                $tagName = 'Dollar';
                break;
            case "دلار استرالیا":
                $tagName = 'AustralianDollar';
                break;
            case "دلار کانادا":
                $tagName = 'CanadianDollar';
                break;
            case "یورو":
            case "EURO":
                $tagName = 'Euro';
                break;
            case "کرون سوئد":
                $tagName = 'SwedishKrona';
                break;
            case "پوند":
                $tagName = 'Pound';
                break;
            case "فرانک":
                $tagName = 'Frank';
                break;
            case "روبل روسیه":
                $tagName = 'RussianRuble';
                break;
            case "پزوی مکزیک":
                $tagName = 'MexicanPeso';
                break;
            case "لیره ترکیه":
                $tagName = 'TurkishLira';
                break;
            case "یوان چین":
                $tagName = 'ChineseYuan';
                break;
            case "ین ژاپن":
                $tagName = 'Yen';
                break;
            case "دینار":
                $tagName = 'Dinar';
                break;
            case "درهم":
                $tagName = 'Derham';
                break;
            case "دانگ ویتنام":
                $tagName = 'DongVietnam';
                break;
            case "پوند انگلیس":
                $tagName = 'BritishPound';
                break;

        }

        return self::Xmlinformation( $tagName )->__toString();
//        return $tagName;
    }

    public static function changeFieldNameByLanguage( $field ) {
        if ( SOFTWARE_LANG === 'fa' ) {
            return $field . 'Fa';
        }

        return $field . 'En';
    }

    public static function priceHotel( $factorNumber ) {
        $Model            = Load::library( 'Model' );
        $sql              = " SELECT total_Price FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}'";
        $resultPriceHotel = $Model->load( $sql );

        return $resultPriceHotel['total_Price'];

    }

    public static function CreditCustomer() {
        $Model = Load::library( 'Model' );

        if ( Session::IsLogin() ) {

            Load::autoload( 'Model' );
            $creditModel = new Model();
            $SqlMember   = "SELECT * FROM members_tb WHERE id='{$_SESSION["userId"]}'";

            $member = $Model->load( $SqlMember );

            $agencyID = $member['fk_agency_id'];

            $sql_charge   = "SELECT sum(credit) AS total_charge FROM credit_detail_tb WHERE type='increase' AND fk_agency_id='{$agencyID}'";
            $charge       = $creditModel->load( $sql_charge );
            $total_charge = $charge['total_charge'];

            $sql_buy   = "SELECT sum(credit) AS total_buy FROM credit_detail_tb WHERE type='decrease' AND fk_agency_id='{$agencyID}'";
            $buy       = $creditModel->load( $sql_buy );
            $total_buy = $buy['total_buy'];

            $total_transaction = $total_charge - $total_buy;

            return $total_transaction;
        }
    }

    public static function returnJson( $data, $statusCode = 200 ) {
        http_response_code( $statusCode );
        $data               = (array) $data;
        $data['StatusCode'] = $statusCode;

        return json_encode( $data, 256 | 64 );

    }

    public static function returnJsonResult($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    }

    public static function vehicleTypeClassName( $vehicleName ) {
        switch ( $vehicleName ) {

            case 'قطار':
                $className = 'ul-last-li-airline-img-train';
                break;
            case 'کشتی':
                $className = 'ul-last-li-airline-img-ship';
                break;
            case 'اتوبوس':
                $className = 'ul-last-li-airline-img-bus';
                break;
            case 'ون':
            case 'شخصی':
            case 'سواری':
                $className = 'ul-last-li-airline-img-car';
                break;
            case 'هواپیما':
            default:
                $className = 'ul-last-li-airline-img-plane';
                break;


        }

        return $className;
    }

    public static function getPercentage( $total, $refunded ) {
        if ( $total > 0 ) {
            $result = ( ( $total - $refunded ) / $total ) * 100;

            return $result;
        }

        return 0;
    }

    //TODO: please use function getGroupListServicesClient in services controller
    public static function listServiceClient() {

        $ModelBase = Load::library( 'ModelBase' );

        $clientId = CLIENT_ID;
        $sql      = "SELECT servicesGroup.* FROM services_group_tb AS servicesGroup "
            . " INNER JOIN client_services_tb AS clientService ON clientService.ServiceGroupId= servicesGroup.id"
            . " INNER JOIN client_auth_tb AS clientAuth ON clientAuth.ServiceId = clientService.id"
            . " WHERE clientAuth.ClientId='{$clientId}' GROUP BY servicesGroup.id ORDER BY servicesGroup.id";

        return $ModelBase->select( $sql );

    }

    public static function checkExistSubAgency() {
        return ( SUB_AGENCY_ID != '' && SUB_AGENCY_ID > 0 ) ? true : false;
    }

    public static function redirectAgency() {
        header( 'Location: agencyProfile' );
    }

    public static function redirectOutAgency() {
        session_destroy();
        header( 'Location: loginAgency' );
    }

    public static function redirectOut($url = ''){
        Session::init();
        Session::delete('refer_url');

        if($url){
            Session::delete('refer_url');
            header("Location: {$url}");
        }
        if (in_array(CLIENT_ID , self::newLogin())){
            header('Location: authenticate');
        }else{
            header('Location: loginUser');
        }


    }

    public static function titleStatusCancel( $status ) {
        $translateStatus = "";
        switch ( $status ) {
            case 'Nothing':
                $translateStatus = functions::Xmlinformation( 'Unknown' );
                break;
            case 'RequestMember':
                $translateStatus = functions::Xmlinformation( 'UserRequest' );
                break;
            case 'SetCancelClient':
            case  'SetFailedIndemnity':
                $translateStatus = functions::Xmlinformation( 'Rejectrequest' );
                break;
            case 'RequestClient':
            case  'SetIndemnity':
            case 'ConfirmClient':
                $translateStatus = functions::Xmlinformation( 'InvestigatingRequest' );
                break;
            case 'ConfirmCancel':
                $translateStatus = functions::Xmlinformation( 'AcceptRequest' );
                break;
            case 'close':
                $translateStatus = functions::Xmlinformation( 'closeTicket' );
                break;
            default :
                $translateStatus = functions::Xmlinformation( 'Unknown' );
        }

        return $translateStatus->__toString();
    }

    public static function svgIcon( $icon, $size, $echo = true ) {
        $arr = self::_svgIconsArray();
        if ( array_key_exists( $icon, $arr ) ) {
            $repl = sprintf( '<svg class="svg-icon" width="%d" height="%d" aria-hidden="true" role="img" focusable="false" ', $size, $size );
            $svg  = preg_replace( '/^<svg /', $repl, trim( $arr[ $icon ] ) ); // Add extra attributes to SVG code.
            $svg  = preg_replace( "/([\n\t]+)/", ' ', $svg ); // Remove newlines & tabs.
            $svg  = preg_replace( '/>\s*</', '><', $svg );    // Remove whitespace between SVG tags.
            if ( $echo ) {
                echo $svg;

                return null;
            }

            return $svg;
        }

        return null;
    }

    public static function _svgIconsArray() {
        $icons = array();
        $icons['radio_circle']
            = '<svg width="20px" height="20px" viewBox="0 0 20 20"><circle class="site-svg-path-color" cx="10" cy="10" r="9"></circle><path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner site-svg-path-color"></path><path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer site-svg-path-color"></path></svg>';

        return $icons;
    }

    public static function translateReasonCredit( $reason ) {
        switch ( $reason ) {
            case 'buy':
                return self::Xmlinformation( 'Buy' )->__toString();
                break;
            case 'deposit':
                return self::Xmlinformation( 'Depositamount' )->__toString();
                break;
            case 'harvest':
                return self::Xmlinformation( 'DecreaseCharge' )->__toString();
                break;
            case 'Refund':
                return self::Xmlinformation( 'OsafarRefund' )->__toString();
                break;
            case 'settle':
                return self::Xmlinformation( 'settleCredit' )->__toString();
                break;
            default:
                return null;
        }
    }

    public static function forceDateSearchToJalali( $date ) {
        $dateExplode = explode( '-', $date );
        if ( $dateExplode[0] > 1450 ) {

            return self::ConvertToJalali( $date );
        }

        return $date;
    }

    public static function forceDateSearchToMiladi( $date ) {
        $dateExplode = explode( '-', $date );
        if ( $dateExplode[0] < 1450 ) {

            return self::ConvertToMiladi( $date );
        }

        return $date;
    }
    /*todo: this function must be complete in feature
	@author: Ali Qorbani
	*/

    public static function generateCorrectLink( $link = '', $variables = array(), $pattern = '' ) {
        $explodedLink    = explode( '/', $link );
        $explodedPattern = explode( '/', $pattern );

        foreach ( $variables as $key => $value ) {
            if ( strpos( $pattern, $key ) !== false ) {
                foreach ( $explodedPattern as $reg ) {

                }
            }
        }
    }

    //TODO: remove later
    public static function checkClientConfigurationAccess( $configuration_title = null, $clientId = null ) {

        if ( ! $configuration_title ) {
            return false;
        }
        if ( ! $clientId ) {
            $clientId = CLIENT_ID;
        }
        /** @var configurations $configurations */
        $configurations = Load::controller( 'configurations' );

        return $configurations->checkClientConfigurationByTitle( $configuration_title, $clientId );
    }

    public static function getConfigContentByTitle( $configuration_title, $clientId = null, $is_active = true ) {

        $clientId  = ( $clientId ) ? $clientId : CLIENT_ID;
        $is_active = (int) $is_active;
       

        $access    = self::checkClientConfigurationAccess( $configuration_title, $clientId );

        if ( ! $access ) {
            return array();
        }
        /** @var configurations $configurations */
        $configurations = Load::controller( 'configurations' );
        $configuration  = $configurations->getConfigurationByTitle( $configuration_title );

        /** @var admin $admin */
        $admin    = Load::controller( 'admin' );
        $sql      = "SELECT * FROM configuration_content_tb WHERE configuration_id='{$configuration['id']}' AND is_active='{$is_active}' ORDER BY id DESC ;";


        $contents = $admin->ConectDbClient( $sql, $clientId, 'SelectAll', '', '', '' );

        $result   = array();
        foreach ( $contents as $content ) {
            $content['content'] = base64_decode( $content['content'] );
            if ( $content['content_type'] == 'image' ) {
                $content['content'] = '<a target="_blank" href="' . $content['content'] . '"><img class="img-fluid" src="' . ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . $content['image'] . '" /></a>';
            }
            $result[] = $content;
        }

        return $result;
    }

    public static function validateLink( $link = 'test' ) {
        $parseUrl = parse_url( trim( $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ) );
        $host     = isset( $parseUrl['host'] ) ? $parseUrl['host'] : null;
        $explode  = explode( '/', $parseUrl['path'], 2 );
        $base     = $host ? $host : array_shift( $explode );
        $baseUrl  = trim( $base );
        //		$link  = "home";
        // Test with one by one
        /*$link  = "/home";
		$link  = "xrepeater.com";
		$link  = "www.xrepeater.com";
		$link  = "http://www.xrepeater.com";
		$link  = "https://www.xrepeater.com";
		$link  = "https://xrepeater.com/services";
		$link  = "xrepeater.dev/home/test";
		$link  = "home/test";*/

        $regularExpression = "((https?|ftp)\:\/\/)?"; // SCHEME Check
        $regularExpression .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass Check
        $regularExpression .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP Check
        $regularExpression .= "(\:[0-9]{2,5})?"; // Port Check
        $regularExpression .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path Check
        $regularExpression .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query String Check
        $regularExpression .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor Check
        $final_url         = '';
        if ( preg_match( "/^$regularExpression$/i", $link ) ) {
            if ( preg_match( "@^http|https://@i", $link ) ) {
                $final_url = preg_replace( "@(http://)+@i", 'http://', $link );
                // return "*** - ***Match : ".$final_url;
            } else {
                $final_url = 'http://' . $link;
                // return "*** / ***Match : ".$final_url;
            }
        } else {
            if ( substr( $link, 0, 1 ) === '/' ) {
                // return "*** / ***Not Match :".$final_url."<br>".$baseUrl.$link;
                $final_url = $baseUrl . $link;
            } else {

                $final_url = $baseUrl . "/" . $final_url;
            }

        }

        if ( ! preg_match( "@^http|https://@i", $final_url ) ) {
            $final_url = 'http://' . $final_url;
        }

        return $final_url;

    }

    public static function redirect( $url = '', $code = 300 ){
        //		$url = self::validateLink( $url );
        http_response_code( $code );
        header( 'Location: ' . $url );
    }

    public static function showConfigurationContents( $configuration_title, $before = '', $after = '', $before_item = '', $after_item = '',$echo=true ) {

        $contents = self::getConfigContentByTitle( $configuration_title );

        $result   = $before;
        if ( ! ( $contents ) ) {
            echo '';

            return null;
        }
        foreach ( $contents as $content ) {
            $result .= $before_item . $content['content'] . $after_item;
        }
        $result .= $after;
        if($echo){

            echo $result;
            return null;
        }
        return $result;
    }

    public static function getMarketPlaceOptions( $clientID ) {
        $admin    = Load::controller( 'admin' );
        $clientID = filter_var( $clientID, FILTER_VALIDATE_INT );

        $query = "SELECT * FROM market_place_tb ";

        return $admin->ConectDbClient( $query, $clientID, 'SelectAll', '', '', '' );
    }

    public static function getMarketPlaceOptionByKey( $param ) {
      
        $admin    = Load::controller( 'admin' );
        $clientID = filter_var( $param['clientID'], FILTER_VALIDATE_INT );

        $queryStatus = "SELECT * FROM market_place_tb AS market_place WHERE market_place.key = '{$param['key']}'";

        return $admin->ConectDbClient( $queryStatus, $clientID, 'Select', '', '', '' );
    }

    public static function marketPlaceOptionChangeStatus( $param ) {
        $admin    = Load::controller( 'admin' );
        $clientID = filter_var( $param['clientID'], FILTER_VALIDATE_INT );

        $queryStatus  = "SELECT value FROM market_place_tb WHERE id = '{$param['id']}'";
        $resultStatus = $admin->ConectDbClient( $queryStatus, $clientID, 'Select', '', '', '' );

        if ( $resultStatus['value'] == 'available' ) {
            $data['value'] = 'disabled';
        } else {
            $data['value'] = 'available';
        }


        $result = $admin->ConectDbClient( '', $clientID, 'Update', $data, 'market_place_tb', "id = '{$param['id']}'" );

        if ( $result ) {
            $output['result_status']  = 'success';
            $output['result_message'] = 'وضعیت ویزا با موفقیت تغییر یافت';
        } else {
            $output['result_status']  = 'error';
            $output['result_message'] = 'خطا در تغییر وضعیت ویزا';
        }

        return $output;
    }

    /**
     * @param array  $fields
     * @param array  $conditions
     * @param string $table
     * @param bool   $single
     *
     * @return array|bool|mixed
     */
    public static function _selectFromTb( $fields = array(), $conditions = array(), $table = '', $single = false ) {
        if ( ! $table ) {
            return false;
        }
        $cond = '';
        $keys = ( $fields && is_array( $fields ) ) ? '`' . implode( '`,`', $fields ) . '`' : '*';
        if ( $conditions && is_array( $conditions ) ) {
            $where = array();
            foreach ( $conditions as $column => $value ) {
                $where[] = "{$column}='{$value}'";
            }
            if ( $where ) {
                $cond = implode( ' AND ', $where );
                $cond = " WHERE {$cond}";
            }
        }
        $sql = "SELECT {$keys} FROM {$table}{$cond}";
        /** @var Model $model */
        $model = Load::library( 'Model' );
        if ( TYPE_ADMIN ) {
            /** @var ModelBase $model */
            $model = Load::library( 'ModelBase' );

        }

        return ( $single ) ? $model->load( $sql, 'assoc' ) : $model->select( $sql, 'assoc' );
    }


    public static function getDetailsForExteranlBank( $factor_number = null, $service_type = null ) {

        $response = array(
            'firstName'  => 'TestName',
            'lastName'   => 'TestFamily',
            'mobile'     => '09108632746',
            'email'      => 'info@iran-tech.com',
            'city'       => 'Tehran',
            'country'    => 'IRAN',
            'address'    => 'تهران ایران',
            'postalCode' => sprintf( '%05d', mt_rand( 10000, 99999 ) ),
            'currency'   => Session::getCurrency(),
        );
        $Model    = Load::library( 'Model' );
        if ( TYPE_ADMIN ) {
            $Model = Load::library( 'ModelBase' );
        }
        switch ( $service_type ) {
            case 'PublicLocalHotel' :
            case 'PublicPortalHotel' :
            case 'PrivatePortalHotel' :
            case 'PrivateLocalHotel' :
                $table      = TYPE_ADMIN ? 'report_hotel_tb' : 'book_hotel_local_tb';
                $conditions = array( 'factor_number' => $factor_number );
                //				$detail                = self::_selectFromTb( [], $conditions, $table, true );
                $detail                = $Model->setTable( $table )->get()->where( $conditions )->find();
                $member                = self::infoMember( $detail['member_id'] );
                $repsonse['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
                $repsonse['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
                $repsonse['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
                $repsonse['email']     = $member['email'] ? $member['email'] : $response['email'];
                $repsonse['city']      = $detail['city_name'] ? $detail['city_name'] : $response['city'];
                $repsonse['address']   = $detail['hotel_address'] ? $detail['hotel_address'] : $response['address'];

                break;
            case 'AmadeusSystem' :
            case 'PublicLocalCharter':
            case 'PublicPortalCharter':
            case 'PublicLocalSystem':
            case 'PublicPortalSystem':
            case 'PrivateLocalSystem':
            case 'PrivatePortalMahanSystem':
            case 'PrivateLocalCharter':
            case 'PrivatePortalCharter':
                $table      = TYPE_ADMIN ? 'report_tb' : 'book_local_tb';
                $conditions = array( 'factor_number' => $factor_number );
                //                $detail                = self::_selectFromTb( [], $conditions, $table, true );
                $detail                = $Model->setTable( $table )->get()->where( $conditions )->find();
                $member                = self::infoMember( $detail['member_id'] );
                $repsonse['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
                $repsonse['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
                $repsonse['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
                $repsonse['email']     = $member['email'] ? $member['email'] : $response['email'];
                $repsonse['city']      = $detail['desti_city'] ? $detail['desti_city'] : $response['city'];

                break;
            case 'PublicPortalInsurance' :
            case 'PrivateLocalInsurance' :
                $table      = TYPE_ADMIN ? 'report_insurance_tb' : 'book_insurance_tb';
                $conditions = array( 'factor_number' => $factor_number );
                //				$detail     = self::_selectFromTb( [], $conditions, $table, true );
                $detail = $Model->setTable( $table )->get()->where( $conditions )->find();
                $member = self::infoMember( $detail['member_id'] );

                $repsonse['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
                $repsonse['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
                $repsonse['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
                $repsonse['email']     = $member['email'] ? $member['email'] : $response['email'];

                break;
            case 'PublicLocalTour':
            case 'PublicPortalTour':
            case 'PrivateLocalTour':
            case 'PrivatePortalTour':
                $table      = TYPE_ADMIN ? 'report_tour_tb' : 'book_tour_local_tb';
                $conditions = array( 'factor_number' => $factor_number );
                //				$detail     = self::_selectFromTb( [], $conditions, $table, true );
                $detail = $Model->setTable( $table )->get()->where( $conditions )->find();
                $member = self::infoMember( $detail['member_id'] );


                $repsonse['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
                $repsonse['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
                $repsonse['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
                $repsonse['email']     = $member['email'] ? $member['email'] : $response['email'];

                break;
            case 'LocalEuropcar':
            case 'PortalEuropcar':
                $table      = TYPE_ADMIN ? 'report_europcar_tb' : 'book_europcar_local_tb';
                $conditions = array( 'factor_number' => $factor_number );
                //				$detail     = self::_selectFromTb( [], $conditions, $table, true );
                $detail = $Model->setTable( $table )->get()->where( $conditions )->find();
                $member = self::infoMember( $detail['member_id'] );

                $repsonse['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
                $repsonse['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
                $repsonse['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
                $repsonse['email']     = $member['email'] ? $member['email'] : $response['email'];

                break;
            case 'PrivateVisa' :
            case 'PublicVisa' :
                $table      = TYPE_ADMIN ? 'report_visa_tb' : 'book_visa_tb';
                $conditions = array( 'factor_number' => $factor_number );
                //				$detail     = self::_selectFromTb( [], $conditions, $table, true );
                $detail = $Model->setTable( $table )->get()->where( $conditions )->find();
                $member = self::infoMember( $detail['member_id'] );

                $repsonse['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
                $repsonse['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
                $repsonse['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
                $repsonse['email']     = $member['email'] ? $member['email'] : $response['email'];

                break;
            case 'Train' :
            case 'privateTrain' :
                $table      = TYPE_ADMIN ? 'report_train_tb' : 'book_train_tb';
                $conditions = array( 'factor_number' => $factor_number );
                //				$detail     = self::_selectFromTb( [], $conditions, $table, true );
                $detail = $Model->setTable( $table )->get()->where( $conditions )->find();
                $member = self::infoMember( $detail['member_id'] );

                $repsonse['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
                $repsonse['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
                $repsonse['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
                $repsonse['email']     = $member['email'] ? $member['email'] : $response['email'];

                break;
            case 'LocalTransfer':
            case 'LocalGasht':
                $table      = TYPE_ADMIN ? 'report_gasht_tb' : 'book_gasht_tb';
                $conditions = array( 'factor_number' => $factor_number );
                //				$detail     = self::_selectFromTb( [], $conditions, $table, true );
                $detail = $Model->setTable( $table )->get()->where( $conditions )->find();
                $member = self::infoMember( $detail['member_id'] );

                $repsonse['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
                $repsonse['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
                $repsonse['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
                $repsonse['email']     = $member['email'] ? $member['email'] : $response['email'];

                break;
            case 'PublicBus' :
            case 'PrivateBus' :
                $table      = TYPE_ADMIN ? 'report_bus_tb' : 'book_bus_tb';
                $conditions = array( 'factor_number' => $factor_number );
                //				$detail     = self::_selectFromTb( [], $conditions, $table, true );
                $detail = $Model->setTable( $table )->get()->where( $conditions )->find();
                $member = self::infoMember( $detail['member_id'] );

                $repsonse['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
                $repsonse['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
                $repsonse['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
                $repsonse['email']     = $member['email'] ? $member['email'] : $response['email'];

                break;
            case 'privateEntertainment' :
                $table      = TYPE_ADMIN ? 'report_entertainment_tb' : 'book_entertainment_tb';
                $conditions = array( 'factor_number' => $factor_number );
                //				$detail     = self::_selectFromTb( [], $conditions, $table, true );
                $detail = $Model->setTable( $table )->get()->where( $conditions )->find();
                $member = self::infoMember( $detail['member_id'] );

                $repsonse['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
                $repsonse['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
                $repsonse['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
                $repsonse['email']     = $member['email'] ? $member['email'] : $response['email'];

                break;
            default :
                $response = $response;

                break;
        }

        return $response;
    }


    /**
     * @param null $data
     * @param int  $statusCode
     * @param      $Message
     *
     * @return bool|mixed|string
     */
    public static function withSuccess( $data = null, $statusCode = 200, $Message='' ) {
        http_response_code( $statusCode );
        $return = array( 'status' => 'success', 'code' => $statusCode, 'message' => $Message, 'data' => $data );

        return self::toJson( $return );
    }

    /**
     * @param null $data
     * @param int  $statusCode
     * @param      $Message
     *
     * @return bool|mixed|string
     */
    public static function withError( $data = null, $statusCode = 400, $Message='' ) {
        http_response_code( $statusCode );
        $return = array( 'status' => 'error', 'code' => $statusCode, 'message' => $Message, 'data' => $data );

        return self::toJson( $return );
    }

    /**
     * @param $data
     *
     * @return bool|mixed|string
     */
    public static function toJson( $data ) {
        return self::clearJsonHiddenCharacters( json_encode( $data, 256 | 64 | 8 | 4 | 2 | 1 ) );
    }

    /**
     * @param $data
     *
     * @return bool
     */
    public static function isJson( $data ) {
        if(!is_string($data)){
            return false;
        }
        json_decode($data);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * @param array $input
     * todo : this function will override over the null and predefined request (GET,POST)
     */
    public static function nullableValues( $input ) {

    }


    public static function TitleSource( $sourceId ) {
        switch ( $sourceId ) {
            case '1':
                return 'سرور5';
                break;
            case '11':
                return 'سرور10';
                break;
            case '8':
                return 'سرور7';
                break;
            case '13':
                return 'سرور13';
                break;
            case '10':
                return 'سرور9';
                break;
        }
    }

    /**
     * @param $file_name
     *
     * @return array
     */
    public static function separateFiles( $file_name ) {
        $file_indexes = array(
            'name',
            'type',
            'tmp_name',
            'error',
            'size',
        );
        $file         = array();
        for ( $j = 0; $j < count( $_FILES[ $file_name ]['name'] ); $j ++ ) {
            foreach ( $file_indexes as $index ) {
                $file[ $j ][ $index ] = $_FILES[ $file_name ][ $index ][ $j ];
            }
        }

        return $file;
    }

    public static function countInterrupt($count_interrupt) {

        switch ($count_interrupt) {
            case '1':
                return 'no_interrupt';
                break;
            case '2':
                return 'one_interrupt';
                break;
            case '3':
                return 'two_interrupt';
                break;
            default:
                return 'no_interrupt';
                break;
        }
    }
    public static function countInterruptTitle($count_interrupt,$data_translate=array()) {

        switch ($count_interrupt) {
            case '1':
                return $data_translate['one_interrupt'];
                break;
            case '2':
                return $data_translate['two_interrupt'];
                break;
            default:
                return $data_translate['no_interrupt'];
                break;
        }
    }

    public static function duration_time_source($source_id,$duration,$data_text_translate) {

        if(in_array($source_id,['10','14','15','17','21','43'])){
           
            //0:00:00:00

            if($source_id=='17'){
                $duration = strlen($duration)==10 ? $duration : '0:'.$duration ;
            }
            self::insertLog($duration,'1_check_duration');
            $day_time = substr($duration, 0, 1);

            $hours = substr($duration, 2, 2);

            $minuets = substr($duration, 5, 2);



            $hours = ($hours > '00' ? ($hours > '09' ? $hours : str_replace('0', '', $hours)) : '0') . ' ' . $data_text_translate['hour_text']
                . ' ' ;
            $minuets = ($minuets > '00') ?  $minuets. ' ' . $data_text_translate['minutes_text'] : '';
            return   (($day_time > '0') ? $day_time . $data_text_translate['day_text'] .' '.$data_text_translate['and_text'] : '') . (($hours > '0') ? $hours  : '') . ' ' . $minuets ;
        }
        return null;
    }
    public static function new_duration_time_source($source_id,$duration,$data_text_translate) {
        if(in_array($source_id,['10','14','15','17'])){
          //0:00:00:00
            if($source_id=='17'){
                $duration = strlen($duration)==10 ? $duration : '0:'.$duration ;
            }
            self::insertLog($duration,'1_check_duration');
            $day_time = substr($duration, 0, 1);
            $hours = substr($duration, 2, 2);
            $minuets = substr($duration, 5, 2);
            $hours = ($hours > '00' ? ($hours > '09' ? $hours : str_replace('0', '', $hours)) : '0')  ;


            $minuets = ($minuets > '00') ? $minuets  : '';

            if($hours == '0' && $minuets == '') {
                return null;
            }

            return   (($day_time > '0') ? $day_time . $data_text_translate['day_text'] .' '.$data_text_translate['and_text'] : '') .  $hours   . ':' . $minuets ;
        }
        return null;
    }

    public static function airPortForSourceSeven()
    {
        return array(
            'IKA','MHD','KIH','AWZ','IFN','SYZ','BND','TBZ','GSM','ABD','AZD','SDG','KSH',
            'SRY','IIL','OMH','ZAH','PGU','RAS','IST','NJF','DXB','BGW','MCT','TBS','SHJ',
            'ESB','EVN','AYT','SAW','MOW','DME','VKO','SVO','BUS','GYD','ALA','KBL','ADB',
            'DNZ','CAN','ISU','EBL','LHR','BKK','PVG','KZN','DLM','BEY','FRA','DEL','PEK',
            'MIL','ROM','HKT','DAM','BOM','MZR','CGN','GZP','TAS','HAM','LHE','DYU','KIK',
            'KWI','DOH','KDH','OHS','KER','LRR');
           }

    public static function displayRoomName( $room_name = '', $number = '',$age_type = 'Adt',$is_external = false,$is_single = false ) {
        if($is_single){
            return self::StrReplaceInXml(['@@room_name@@' => $room_name],'HotelSingleRoomDisplayName');
        }
        if ( ! $is_external ) {
            return self::StrReplaceInXml( [
                '@@number@@'    => self::ConvertNthNumber( $number ),
                '@@room_name@@' => $room_name
            ], 'HotelRoomDisplayName' );

        }
        return self::StrReplaceInXml(array(
            '@@number@@'=>self::ConvertNthNumber( $number ),
            '@@room_name@@' => $room_name,
            '@@age_type@@'  => self::Xmlinformation($age_type),
        ),'HotelExternalRoomDisplayName');

    }


    #region DateAddDay
    /*todo: we have to work with $type param mo than simple, for example we pass jalali and we want value be as gregorian or reverse  */
    public static function DateAddDay( $param, $days = 1,$format = 'Y-m-d',$type = 'jalali') {
        $param        = str_replace( '/', '-', $param );
        $explode_date = explode( '-', $param );
        if ( $explode_date[0] < 2000 && SOFTWARE_LANG == 'fa' && $type == 'jalali' ) {
            $current_date   = self::ConvertToMiladi( $param );
            $timestamp = strtotime("+{$days} day", strtotime($current_date));
            $result = dateTimeSetting::jdate( $format , $timestamp );
            return $result;
        }
        $current_date = $param;
        return date($format , strtotime("+{$days} day", strtotime($current_date)));
    }
    #endregion

    public static function ConvertNthNumber( $number = 1) {
        $numbers = array(
            1 => 'First',
            2 => 'Second',
            3 => 'Third',
            4 => 'Fourth',
            5 => 'Fifth',
            6 => 'Sixth',
            7 => 'Seventh',
            8 => 'Eighth',
            9 => 'ninth'
        );
        return isset($numbers[$number]) ? self::Xmlinformation($numbers[$number]) : '';
    }

    public static function currentUrl() {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    }

    public static function registerUserUrl() {
        $current_url = self::currentUrl();
        $register_url = ROOT_ADDRESS.'/registerUser';
        $gds_switches = array(
            'detailHotel',
            'roomHotelLocal',
            'searchFlight',
            'resultTrainApi',
            'buses',
            'international'
        );
        if(in_array(GDS_SWITCH,$gds_switches)){
            return "{$register_url}?redirect_url={$current_url}";
        }
        return "{$register_url}";
    }

    public static function gdsPageCurrency() {

        return array('searchFlight','international','searchHotel','resultExternalHotel','buses','resultTrainApi','searchPackage',
            'resultInsurance','resultTourLocal','resultVisa','resultGasht');
    }

    //region [gdsForceCurrencyPage]

    /**
     * @return array
     */
    public static function gdsForceCurrencyPage() {
        return array('pdf', 'iframe');
    }
    //endregion

    //region [calculateSpecialDiscount]

    /**
     * @param $type
     * @param $amount_discount
     * @param $total_price
     * @return false|float
     */
    public static function calculateSpecialDiscount($type, $amount_discount, $total_price) {
        if($type=='cash') {
            return $amount_discount ;
        }
        return round($total_price * ($amount_discount/100));
    }
    //endregion

    //region [exitCode]
    public static function exitCode() {
//        if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//            session_start();
//            echo json_encode([$_SESSION ]);
//            die();
//        }
//        die();
    }
    //endregion

    public static function notexitCode() {
        if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
            session_start();
            echo json_encode([$_SESSION ]);

        }

    }

    //region [uniqueMultiArray]

    /**
     * @param $array
     * @param $key
     * @return array
     */
    public static  function uniqueMultiArray($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();
        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }
    //endregion

    //region [getDifferDate]

    /**
     * @param string $first_date
     * @param string $differ_string
     * @param string $type
     * @param string $format
     * @return false|string|string[]
     */
    public static function getDifferDate($first_date = '', $differ_string = '', $type = 'gregorian', $format = 'Y-m-d')
    {
        $first_timestamp = (!empty($first_date) ? strtotime($first_date) : time());
        $differ_timestamp = (!empty($differ_string) ? strtotime($differ_string,$first_timestamp) : time());

        if($type == 'jalali'){
            return dateTimeSetting::jdate($format,$differ_timestamp,'','','en');
        }

        return date($format,$differ_timestamp);
    }
    //endregion

    //region [titleFlightTypeKidding]

    /**
     * @param $flight_type
     * @return string
     */
    public static function titleFlightTypeKidding($flight_type)
    {
        if($flight_type=="charter"){
            return self::Xmlinformation('charterKiddingType')->__toString();
        }
        return self::Xmlinformation('systemKiddingType')->__toString() ;
    }
    //endregion

    //region [sourceIncreasePriceFlightSystem]

    /**
     * @return array
     */
    public static function sourceIncreasePriceFlightSystem()
    {
        return array('14');
    }
    //endregion

    //region [ShowPriceTicket]

    /**
     * @param $type
     * @param $price
     * @param $SourceId
     * @return float|int
     */
    public static function ShowPriceTicket($type, $price, $SourceId) {
        switch ($SourceId) {
            case '13':
                if ($type == 'charter') {
                    return (self::convert_toman_rial(($price + 1500)));
                } elseif ($type == 'system') {
                    return self::convert_toman_rial($price);
                }
                break;
            case '10':
            case '15':
            case '17':
            case '18':
            case '19':
            case '20':
            case '21':
            case '22':
            case '43':
                return $price;
                break;
            /*case '1':
            case '11':
            case '8':
            case '12':
            case '14':
            case '16':
            case '5':*/
            default:
                return (self::convert_toman_rial($price));
                break;

        }
    }
    //endregion

    //region [getTypeZone]

    /**
     * @param $zone
     * @return string
     * @author alizade
     * @date 8/25/2022
     * @time 4:21 PM
     */
    public static function getTypeZone($zone)
    {
        return ($zone=='1') ? 'Local' : 'Portal';
    }
    //endregion

    //region [redirectTo404InAdmin]
    /**
     * @author alizade
     * @date 8/25/2022
     * @time 4:20 PM
     */
    public static function redirectTo404InAdmin()
    {
        header("Location: " . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . "/404.tpl");
    }
    //endregion


    //region [clientsForDisplaySourceName]
    /**
     * @return array
     * @author alizade
     * @date 8/25/2022
     * @time 4:26 PM
     */
    public static function clientsForDisplaySourceName(){
        return array('227');
    }
    //endregion

    #region persianMessageFlightError
    public static function persianMessageFlightError($message_code)
    {

        switch ($message_code) {
            case "Passport ID Is Incorrect":
                return "شماره پاسپورت صحیح نمی باشد";
                break;
            case "Credit  problem  ticket price":
                return "اعتبار پید شما در منبع کافی نمی باشد";
                break;
            case "Fligt capacity error (210)":
                return "در این لحظه ظرفیت نرخ مورد نظر شما بیشتر از ظرفیت موجود است،لطفا از نرخ های دیگر خریداری نمائید";
                break;
            case "Fligt capacity error (163)":
                return "در این لحظه ظرفیت نرخ مورد نظر شما بیشتر از ظرفیت موجود است،لطفا از نرخ های دیگر خریداری نمائید";
                break;
            case "Repetitive Passenger In This Flight ":
                return "نام مسافر در پرواز تکراري ست و مسافري با همين مشخصات در اين پرواز وجود دارد";
                break;
            case "Passport ID Is Incorrect":
                return "شماره پاسپورت صحیح نمی باشد";
                break;
            case "TimeExpired":
                return "زمان رزرو شما منقضی شده است لطفا مراحل رزرو را از ابتدا انجام دهید";
                break;
            case "Repetitive Passenger In This Flight ":
                return "نام مسافر در پرواز تکراری ست و مسافری با همین مشخصات در این پرواز وجود دارد";
                break;
            case '10122':
                return 'تاریخ ارسالی نامعتیر است';
                break;
            case '10131':
                return 'درخواست ارسالی نا معتیر است';
                break;
            case '10201':
                return 'خطای سیستمی با پشتیبان خود تماس بگیرید';
                break;
            case '-203':
                return 'تاریخ نا معتبر است';
                break;
            case '-2':
                return 'خطا در ارسال درخواست';
                break;
            case '-202':
                return 'مبدا یا مقصد نا معتبر است';
                break;
            case '10150':
                return 'تاریخ تولد نا معتبر است';
                break;
            case '1':
                return 'قیمت بلیط توسط ایرلاین تغییر کرده است';
                break;
            case '10207':
                return 'بلیط مورد نظر امکان رزور ندارد،مجددا سعی کنید و در صورت تکرار با پشتیبان خود تماس بگیرید';
                break;
            case '10202':
                return 'ظرفیت پرواز مورد نظر پر شده،یا پرواز مورد نظر موجود نمی باشد';
                break;
            case '10142':
                return 'رزرو تایید نشده با پشتیبان تماس بگیرید';
                break;
            case '10226':
                return 'ساعت و یا تاریخ پروازی که انتخاب کرده اید تغییر کرده است';
                break;
            case '10167':
                return 'اطلاعات مسافران شما ،قبلا در پرواز ثبت شده و تکراری می باشد ';
                break;
            case '10216':
                return 'ظرفیت پرواز پر شده است';
                break;
            case '10151':
                return 'تاریخ تولد یا نوع مسافر اشتباه میباشد	';
                break;
            case '10152':
                return 'نام  یا نام خانوادگی مسافر اشتباه است 	';
                break;
            case '10155':
                return 'کد ملی مسافر اشتباه است';
                break;
            case '10170':
                return 'شماره پاسپورت مسافر اشتباه است';
                break;
            case '10107':
                return 'ایمیل وارد شده معتبر نیست';
                break;
            case '-3':
                return 'خطا در ارسال درخواست،لطفا مجددا اقدام نمائید و در صورت تکرار با پشتیبان خود تماس بگیرید';
                break;
            case '10171':
                return 'تاریخ انقضای پاسپورت اشتباه است';
                break;
            case '-305':
                return 'پرواز یافت نشد لطفا مجددا اقدام نمائید و در صورت تکرار با پشتیبان خود تماس حاصل نمائید';
                break;
            case '-402':
                return 'اطلاعات وارد شده معتبر نمی باشد';
                break;
            case '-403':
                return 'ایمیل وارد شده معتبر نمی باشد';
                break;
            case '-404':
                return 'شماره همراه وارد شده معتبر نمی باشد';
                break;
            case '-405':
                return 'تعداد مسافرین معتبر نمی باشد';
                break;
            case '-408':
                return 'درخواست شما منقضی شده است ،لطفا مجددا اقدام نمائید';
                break;
            case '-409':
                return 'تاریخ پرواز مورد نظر تغییر کرده است';
                break;
            case '-410':
                return 'زمان پرواز مورد نظر تغییر کرده است';
                break;
            case '-411':
                return 'کد امنیتی وارد شده اشتباه است';
                break;
            case '-412':
                return ' نوع مسافر فقط باید(بزرگسال،کودک،نوزاد) باشد';
                break;
            case '-413':
                return ' نوع مسافر فقط باید(بزرگسال،کودک،نوزاد) باشد';
                break;
            case '-414':
                return 'نام یا نام خانوادگی لاتین معتبر نمی باشد';
                break;
            case '-415':
                return 'نام یا نام خانوادگی فارسی معتبر نمی باشد';
                break;
            case '-416':
                return 'جنسیت مسافر معتبر نمی باشد';
                break;
            case '-417':
                return 'کد ملی مسافر معتبر نمی باشد';
                break;
            case '-418':
                return 'کد ملی معتبر نمی باشد';
                break;
            case '-419':
                return 'ملیت مسافر معتبر نیست';
                break;
            case '-420':
                return 'تاریخ اعتبار پاسپورت مسافر معتبر نیست';
                break;
            case '-421':
                return 'تاریخ تولد مسافر بزرگسال معتبر نیست';
                break;
            case '-422':
                return 'تاریخ تولد مسافر کودک معتبر نیست';
                break;
            case '-423':
                return 'تاریخ تولد مسافر نوزاد معتبر نیست';
                break;
            case '-424':
                return 'تاریخ تولد مسافر  معتبر نیست';
                break;
            case '-430':
                return 'قیمت ایرلاین تغییر کرده است';
                break;
            case '-458':
                return 'کد امنیتی وارد شده اشتباه است';
                break;
            case '-777':
                return 'قیمت پرواز مورد نظر تغییر کرده است';
                break;
            case '10225':
                return 'اعتبار کافی نیست';
                break;
            case '10253':
                return 'منبع نا مشخص';
                break;
            case '10157':
                return 'ایمیل وارد شده اشتباه است';
                break;
            case '10168':
                return 'شماره ملی یا شماره پاسپورت مسافر قبلا ثبت شده است';
                break;
            case '10000777':
                return 'کمبود اعتبار پید';
                break;
            case '909090':
                return 'قیمت پرواز مورد نظر تغییر کرده است';
                break;
            case 'ERROR111':
                return 'در حال حاضر پرواز مورد نظر شما،برای رزرو با مشکل مواجه شده است،لطفا مجددا اقدام نمائید و در صورت تکرار با پشتیبان خود تماس حاصل نمائید';
                break;
            case '-506':
                return 'خرید نا موفق است';
                break;
            case '10175':
                return 'کد ملی معتیر نمی باشد';
                break;
            case 'Err0111006':
                return 'اعتبار کافی نیست';
                break;
            case 'Err0107020':
            case 'Err0107010':
            case 'Err0107012':
            case 'Err0107040':
                return 'اطلاعات پاسپورت صحیح نمی باشد';
                break;
            case 'Err0107011':
                return 'تاریخ انقضای پاسپورت صحیح نمی باشد';
                break;
            case 'Err0107045':
                return 'تاریخ صدور پاسپورت صحیح نمی باشد';
                break;
            case 'Err0107051':
            case 'Err0107065':
                return 'شماره پاسپورت مورد نظر در پرواز دیگری استفاده شده است(پرواز قبلا خریداری شده است)';
                break;
            default:
                return "به این خطای تامین کننده در سفر360 کدی تخصیص داده نشده ، لطفا جهت پیگیری و حل موضوع این مورد را به همراه شماره واچر تسک نمایید";
                break;
        }
    }
    #endregion

    public static function showFlightSourceName($api_id) {
        switch ($api_id){
            case '5' : return 'سرور4';
            case '1' : return 'سرور5';
            case '8' : return 'سرور7';
            case '12' : return 'سرور12';
            case '10' : return 'سرور9';
            case '11' : return 'سرور10';
            case '13' : return 'سرور13';
            case '14' : return 'سرور14';
            default : return $api_id;
        }
    }



    public static function uploadPic($data_upload) {
        /** @var application $application */
        $application = Load::Config( 'application' );
        $application->pathFile($data_upload['path_upload']);
        $success = $application->UploadFile("pic", $data_upload['file_name'], "");
        $explode_name_pic = explode(':', $success);
        if ($explode_name_pic[0] == 'done') {
            $info_file = $explode_name_pic[1];
            if(isset($data_upload['path_old_pic']) && !empty($data_upload['path_old_pic'])){
                unlink($data_upload['path_old_pic']);
            }
        } else {
            $info_file = '';
        }
        return $info_file;

    }


    public static function getAllUserCurrencies($asJson = true) {
        /** @var currencyEquivalent $currency_controller */
        $currency_controller = Load::controller('currencyEquivalent');
        $currencies = [];
        $all_currencies = $currency_controller->currencyModel()->get()->all();
        $equals = $currency_controller->currencyEquivalentModel()->get()->where('IsEnable',1)->all();
        foreach ($equals as $equal) {
            foreach ($all_currencies as $currency) {
                if($currency['CurrencyCode'] == $equal['CurrencyCode']){
                    $currency['EquivalentToRial'] = $equal['EqAmount'];
                    $currencies[$currency['CurrencyShortName']] = $currency;
                }
            }
        }
        return ($asJson)? self::withSuccess($currencies) : $currencies;
    }


    public static function convertResultOneDimensionalArray($data,$index) {
        $array = array();
        foreach ($data as $key=>$item) {
            $array[] = $item[$index] ;
        }
        return $array ;
    }

    public static function slugify($string, $divider = '-') {

        return str_replace([
            "%20",
            "2%",
            "20%",
            " ",
            "--",
            "---",
            "-–-",
            "/",
            ":",
            "«",
            "»",
            "	",
            "	",
            "--",
            "“",
            "”",
            "&",
            "`",
            "#",
            "'",
            '"',
            '+',
            '/[\x{200B}-\x{200D}\x{FEFF}]/u',
            ')',
            '%'],'-',$string);

    }

    public static function searchableText($string) {
        return str_replace([
            '/',
            '-',
            ' ',
            '*',
            '.',
            ',',
            '@',
            '#',
            '=',
        ],'%',$string);
    }

    public static function datesTour() {
        $dates = array();
        $year_select = functions::DateFunctionWithLanguage('Y',strtotime('today'));
        $month_select = functions::DateFunctionWithLanguage('m',strtotime('today'));

        $month_select_counter = $month_select ;
        $nextYearShowCheck = 0 ;

        for($i=0; $i < 3;  $i++){
            $time =(time()+($i*24*60*60*30));

            if(SOFTWARE_LANG == 'fa'){
                $dates[$i]['value'] =  dateTimeSetting::jdate('Y-m-01',$time,'','', 'en');

                $dates[$i]['text'] =  dateTimeSetting::jdate( " F Y", $time,'','', 'en' );
            }
            else{

                if($month_select_counter > 12) {
                    $thisyear =strtotime('today')+(60 * 60 * 24 * 365);
                    $nextYearShowCheck= $nextYearShowCheck+1;
                }else{
                    $thisyear =strtotime('today');
                }

                if($nextYearShowCheck == 0) {
                    $thisMonth = $month_select_counter;
                }else{
                    $thisMonth = $nextYearShowCheck;
                }
                $thisMonthEdited= sprintf( "%02d", $thisMonth );
                $year_select = functions::DateFunctionWithLanguage('Y',$thisyear) ;
                $CalenderMonthName = date("F", mktime(0, 0, 0, $thisMonth, 10)) ;
                $dates[$i]['value'] = $year_select.'-'.$thisMonthEdited.'-01';

                $dates[$i]['text'] = $CalenderMonthName .  '-' . $year_select;
                $month_select_counter = $month_select_counter+1 ; 
            }

        }

        return $dates ;
    }


    public static function excludeGdsSwitch() {
        return array('mag','blog','page','news','roomHotelLocal');
    }


    public static function randomString($count) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < $count; $i++) {
            $randstring = $characters[rand(0, strlen($characters))];
        }
        return $randstring;
    }

    public static function getOsUser() {

        $agent    = $_SERVER['HTTP_USER_AGENT'];
        $os_array = self::Os();
        $os_platform = '';
        foreach ($os_array as $regex => $value){
            if ( preg_match( $regex, $agent ) ) {
                $os_platform = $value;
            }
        }
            return $os_platform;

    }

    public static function SetTimeLimit() {
        $time = strtotime('10:00');
        return $new_time = date("H:i", strtotime('+' . ((1 - 1) * 90) . ' minutes', $time));

    }

    public static function createEmoji($src) {
            $replaced = preg_replace("/\\\\u([0-9A-F]{1,4})/i", "&#x$1;", $src);
            $result = mb_convert_encoding($replaced, "UTF-16", "HTML-ENTITIES");
            $result = mb_convert_encoding($result, 'utf-8', 'utf-16');
            return $result;

    }

    public static function createPwaSession() {
        $session = Load::library('Session');
        $session->add('layout', 'pwa');
    }

    public static function removePwaSession() {
        unset($_SESSION['layout']);
    }

    public static function isMobile() {
        /** @var $mobile_detect mobileDetect */
        $mobile_detect = Load::controller('mobileDetect');
        return $mobile_detect->isMobile();
    }

    public static function setPwaSession() {
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        /**
         * It will create session, If GDS_SWITCH = App.tpl(pwa)
         */
        if (GDS_SWITCH == 'app') {

            self::createPwaSession();

        }
        /**
         * It will create session, If on "android" apk file
         */
      /*  elseif (isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
            self::createPwaSession();
        } */
        elseif (GDS_SWITCH == 'mainPage') {
            self::removePwaSession();

        } elseif (self::isMobile()) {

            /**
             * It will create session, If $referer = App.tpl(pwa)
             */
            if (preg_match('/app[^\/]+(?=\/$|$)|\/app/', $referer)) {
                self::createPwaSession();
            } /**
             * It will remove session, If $referer = CLIENT_MAIN_DOMAIN
             */
            elseif (parse_url($referer)['host'] == CLIENT_MAIN_DOMAIN) {
//                self::removePwaSession();
            }
        } else {
            /**
             * Desktop does   need "pwa"
             */


//            $this->removePwaSession();
        }

    }


    public static function convertNumberOFPersianToLatin($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }
    public static function dashesToCamelCase($string, $capitalizeFirstCharacter = false)
    {

        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }

    public static function checkNationalCode($code) {
        if (!preg_match('/^[0-9]{10}$/', $code))
            return false;
        for ($i = 0; $i < 10; $i++)
            if (preg_match('/^' . $i . '{10}$/', $code))
                return false;
        for ($i = 0, $sum = 0; $i < 9; $i++)
            $sum += ((10 - $i) * intval(substr($code, $i, 1)));
        $ret = $sum % 11;
        $parity = intval(substr($code, 9, 1));
        if (($ret < 2 && $ret == $parity) || ($ret >= 2 && $ret == 11 - $parity))
            return true;
        return false;
    }
    public static function arrayFilterByValue($my_array, $index, $value)
    {
        $new_array = array();
        if (is_array($my_array) && count($my_array) > 0) {
            foreach (array_keys($my_array) as $key) {
                $temp[$key] = $my_array[$key][$index];

                if ($temp[$key] == $value) {
                    $new_array[$key] = $my_array[$key];
                }
            }
        }
        return array_values($new_array);
    }

    public static function getAllowSourceEmpty() {
//        '14',
        return ['15'];
    }

    public static function selfPhoneCustomers() {
        return array(
          '164'
        );
    }
    public static function disableServiceBank($service) {
        $data_client =  [] ;
/*  'PublicLocalHotel' ,
             'PublicPortalHotel' ,
             'PrivatePortalHotel' ,
             'PrivateLocalHotel' ,*/
        $services_hotel = [

        ];


        return !(in_array(CLIENT_ID, $data_client) && in_array($service, $services_hotel));
    }
    public static function validateMobileOrEmail($inputValue) {
        $mobileRegex = '/^[0-9]{11}$/';
        $emailRegex = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

        // Check if the input matches either the mobile regex or email regex
        return preg_match($mobileRegex, $inputValue) || preg_match($emailRegex, $inputValue);
    }

    /*public static function autoLogin($email, $password) {
        $controller = Load::controller('members');
        $controller->memberLogin( $email, $password, 0, 0, 0 );
    }*/

    public static function isMobileOrEmail($entry) {
        if (preg_match('/^[0-9]{11}$/', $entry)) {
            return 'mobile';
        } else if (filter_var($entry, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }
        return false;
    }




    public static function SaveImages($moduleName = '', $itemName = '', $imageName = null) {


        $moduleImagesFolder = $moduleName . $itemName;
        $imagePath = $moduleImagesFolder . "/". $imageName;
        $moduleImagesUrl    = "{$moduleName}{$itemName}";
        if (!is_dir($moduleImagesFolder)) {
            mkdir($moduleImagesFolder, 0777, true);
        }
        if (!is_dir($moduleImagesFolder . DIRECTORY_SEPARATOR . 'medium')) {
            mkdir($moduleImagesFolder . DIRECTORY_SEPARATOR . 'medium', 0777, true);
        }
        if (!is_dir($moduleImagesFolder . DIRECTORY_SEPARATOR . 'thumb')) {
            mkdir($moduleImagesFolder . DIRECTORY_SEPARATOR . 'thumb', 0777, true);
        }
        if (file_exists($imagePath)) {
            $imageSource = $moduleImagesFolder . '/' . $imageName;
            if (!file_exists("$moduleImagesFolder/medium/{$imageName}")) {
                self::GenerateThumbnail($imageSource, "{$moduleImagesFolder}/medium/{$imageName}", 300);
            }
            if (!file_exists("$moduleImagesFolder/thumb/{$imageName}")) {
                self::GenerateThumbnail($imageSource, "{$moduleImagesFolder}/thumb/{$imageName}", 150);
            }

            return [
                "full"      => "$moduleImagesUrl/{$imageName}",
                "thumbnail" => "{$moduleImagesUrl}/thumb/$imageName",
                "medium"    => "{$moduleImagesUrl}/medium/$imageName",
            ];
        }

    }

    public static function GenerateThumbnail($url = '', $destination = '', $width = 150, $height = true) {

        $image = ImageCreateFromString(file_get_contents($url));
        if (!$image) {
            return;
        }

        // calculate resized ratio
        // Note: if $height is set to TRUE then we automatically calculate the height based on the ratio
        $height = $height === true ? (ImageSY($image) * $width / ImageSX($image)) : $height;
        // create image
 
        $resized_image = imagecreatetruecolor($width, $height);
        $transparent_color = imagecolorallocatealpha($resized_image, 255, 255, 255, 127);
        imagefill($resized_image, 0, 0, $transparent_color);
        imagecolortransparent ($resized_image, $transparent_color = null);
        imagesavealpha($resized_image, true);

        ImageCopyResampled($resized_image, $image, 0, 0, 0, 0, $width, $height, ImageSX($image), ImageSY($image));
        // save image
        if (ImageJPEG($resized_image, $destination, 100)) {
            return;
        }
    }

    public static function DeleteImages($folder, $inputName) {
            $path = PIC_ROOT.$folder."/".$inputName;
            $pathThumb = PIC_ROOT.$folder."/thumb/".$inputName;
            $pathMedium = PIC_ROOT.$folder."/medium/".$inputName;
           if (file_exists($path)) {
               unlink($path);
           }
        if (file_exists($pathThumb)) {
            unlink($pathThumb);
        }
        if (file_exists($pathMedium)) {
            unlink($pathMedium);
        }

    }

    public static function vehicleEnName($fa_name) {
        switch ($fa_name){
            case 'هواپیما':
                return 'plane';
            case 'کشتی':
                return 'ship';
            case 'قطار':
                return 'train';
            case 'اتوبوس':
                return 'bus';
        }
    }

    public static function returnableServices() {
        return array('Flight', 'Train', 'Bus', 'Tour','Package');
    }
    public static function getGrsCharge($param) {
        $detailHotel   = Load::controller( 'detailHotel' );
        return $detailHotel->getProfile($param);
    }
    public static function calculatePercentage($price, $percentage) {
        $result = $price * ($percentage / 100);
        return $result;
    }

    public static function isShamsiDate($date) {
        // Check if the date is in Shamsi format (yyyy/mm/dd)
        if (preg_match("/^(\d{4})\/(\d{2})\/(\d{2})$/", $date, $matches)) {
            $year = intval($matches[1]);
            $month = intval($matches[2]);
            $day = intval($matches[3]);

            // Check if the date is a valid Shamsi date
            if ($year >= 1300 && $year <= 1500 && $month >= 1 && $month <= 12 && $day >= 1 && $day <= 31) {
                return true;
            }
        }

// Check if the date is in Miladi format (yyyy-mm-dd)
        if (preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $date, $matches)) {
            $year = intval($matches[1]);
            $month = intval($matches[2]);
            $day = intval($matches[3]);

            // Check if the date is a valid Miladi date
            if ($year >= 1900 && $year <= 2100 && $month >= 1 && $month <= 12 && $day >= 1 && $day <= 31) {
                return false;
            }
        }

// Invalid date format or outside the supported ranges
        return null;
    }


    public static function expectCheckLimitPrice() {

        return ['166' , '338' , '330' , '186' , '297'];
    }

    public static function calculateWithRial() {
        return ['10','15','17','18','19' ,'20' , '21', '22', '43'];
    }

    public static function nowTimeStamp() {
        return time();
    }

    public static function getServiceDiscountGroupTitle($service) {

        switch ($service) {
            case "PublicLocalCharter":
            case "PrivateLocalCharter":
            case "PublicLocalSystem":
            case "PrivateLocalSystem":
                return 'پرواز داخلی';

            case "PublicPortalCharter":
            case "PublicPortalSystem":
            case "PrivatePortalSystem":
            case "PrivatePortalCharter":
                return 'پرواز خارجی';

            case  "PublicLocalHotel":
            case  "PrivateLocalHotel":
                return 'هتل داخلی';

            case "PublicPortalHotel":
            case "PrivatePortalHotel":
                return 'هتل خارجی';

            case "PublicPortalInsurance":
            case "PrivateLocalInsurance":
                return 'بیمه';

            case "PublicBus":
            case "PrivateBus":
                return 'اتوبوس';

            case "PrivateVisa":
            case "PublicVisa" :
                return 'ویزا';

            case 'PrivateLocalTour':
                return 'تور داخلی';

            case 'PrivatePortalTour':
                return 'تور خارجی';

            case 'Train':
                return "قطار";

            case 'privateTrain':
                return 'قطار ویژه';

            case 'LocalGasht':
                return "گشت";

            case 'LocalTransfer':
                return 'ترانسفر';

            case  'privateEntertainment':
                return 'تفریحات';

            case 'package':
                return 'پرواز +هتل';

            default:
                return null;

        }
    }

    public static function substrDataSmarty($param,$start,$end) {
            return  substr($param,$start,$end);
    }

    public static function getCodeMember($params) {
        $max_card_number = (!empty($params['MaxCardNo']) ? $params['MaxCardNo'] : 0) ;
        if ($max_card_number == 0) {
            $card_number = CLIENT_PRE_CARD_NO . "00000001";
        } else {
            $dynamic_section = substr($max_card_number, 8, 8) + 1;
            $zero_section = '';
            for ($j = strlen($dynamic_section); $j < 8; $j++) {
                $zero_section .= '0';
            }
            $card_number = CLIENT_PRE_CARD_NO . $zero_section . $dynamic_section;
        }

        return $card_number;

    }

    public static function newLogin() {
        $staticIds =  ['4'  ,'166' , '315' , '317' , '180','186' ,'318' , '320' , '321' , '322' , '323' , '324' , '325' , '327', '328' , '330' , '331' , '296' , '271' , '332' , '333' , '334' , '335' , '336' , '337' , '338' , '339' , '340' , '341' , '342',
            '343', '344', '345', '346', '347', '348', '349', '350' , '294' , '233' , '352' , '353' , '354' , '356' , '357', '359', '360', '361', '362', '363',  '364', '365', '366' , '367' ,  '369' , '370', '140' ,'280','372','373' , '127','374','377','378','379','383','400' ,'401','402','403','404','292'
            ,'387' , '388' , '389' , '390', '392'  ,'395' , '405','406','407','408','409','410','411','412','413','415','416','417','418','419','420','421','422','423','517','519' , '217'];

        $dbIds = self::getClientIds();

        // ادغام + حذف تکراری‌ها
        return array_values(
            array_unique(
                array_merge($staticIds, $dbIds)
            )
        );

    }

    public static function hasAgencyLogin() {
        return ['338'  ,'271' , '366' , '127'];
    }
    public static function dateNowMiladi($mode='') {
        return date('Y'.$mode.'m'.$mode.'d',time());
    }
    
    public static function isEnableSetting($title) {

        $reservationSetting = Load::controller('reservationSetting');
        $result = $reservationSetting->getReservationSettingByTitle($title);
        return $result['enable'] ;
    }


    public static function getLastDateJalaliOfNextMonth() {
        $from_date = DateTimeSetting::jdate("Y-m-d",time(),'','','en');
        $explode_date = explode('-',$from_date);

        $day = ($explode_date[1] < 6) ? 31 : (($explode_date[1]==12) ? 29 : 30);
        $jmkTime =  dateTimeSetting::jmktime( 0, 0, 0, $explode_date[1],$day, $explode_date[0] );
        $time_end_month = $jmkTime + (24*60*60*$day) ;

        return dateTimeSetting::jdate("Y-m-d",$time_end_month,'','','en');
    }

    public static function isSuspend() {
        return ['44'];
    }

    public static function isDemo() {
        return ['322' , '323' , '155' , '160' ,   '283' , '149' , '155' , '161' , '162'];
    }

    public static function hasVoteSmsAccess() {
        return [248 , 4];
    }

    public static function getIataMinPriceParto()
    {
        return [/*'IKA','THR','MHD','KIH','AWZ','BND','TBZ','GSM','IST','NJF','DXB','BGW','MCT','TBS','SHJ','ESB','DOH'*/] ;
    }

    public static function checkIsCounter() {
        $member = Load::controller( 'members' );
        return $member->isCounter();
    }

    public static function switchAlphabet($englishString){
      if(!self::checkFarsiAlphabet($englishString)) {
          return self::convertToPersian($englishString);
      }
      return $englishString ; 
    }
    public static function checkFarsiAlphabet($str){
        $farsiUnicodeRanges = array(
            '/[\x{0600}-\x{06FF}]/u', // Arabic
            '/[\x{0750}-\x{077F}]/u', // Arabic Supplement
            '/[\x{08A0}-\x{08FF}]/u', // Arabic Extended-A
            '/[\x{FB50}-\x{FDFF}]/u', // Arabic Presentation Forms-A
            '/[\x{FE70}-\x{FEFF}]/u', // Arabic Presentation Forms-B
        );

        foreach ($farsiUnicodeRanges as $range) {
            if (preg_match($range, $str)) {
                return true; // Farsi characters found
            }
        }

        return false; // No Farsi characters found
    }

    public static function convertToPersian($englishString) {
        $englishChars = range('a', 'z');

        $farsiChars = array(
            106 => 'ت'  , 105 => 'ه' ,  118 => 'ر'  , 104 => 'ا' , 107 => 'ن'  , 108 => 'م'  , 97 => 'ش' , 110 => 'د' , 119 => 'ص' , 116 => 'ف' ,
            97 => 'ش' , 100 => 'ی' , 99 => 'ز'  , 102 => 'ب' , 216 => 'ر' , 115 => 'س', 44 => 'و', 103 => 'ل', 39 => 'گ', 59 => 'ک', 114 => 'ق',
            121 => 'غ', 117 => 'ع', 120 => 'ط', 122 => 'ظ', 113 => 'ض', 67 => 'ژ', 98 => 'ذ', 111 => 'خ', 112 => 'ح', 93 => 'چ', 91 => 'ج' 
        );



        $persianString = '';

        // Convert each character
        for ($i = 0; $i < strlen($englishString); $i++) {
            $char = $englishString[$i];
            $ascii = ord($char);
           
            if (in_array($char, $englishChars)) {
                $persianString .= $farsiChars[$ascii];
            } else {
                $persianString .= $char;
            }
        }

        return $persianString;
    }

    public static function sanitize_input($input) {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }

    public static function existDoubtfulCharacter($parameters) {
      
        $array_special_char = ["{","}",";","\n","--","'", "‘", "’", "'", "“", "”", "„" , '"', "(", ")", "<", ">","</","/>","alert","+","sleep","from","script"] ;
        

        if(empty($parameters)){
            $parameters = [];
        }

        $final_parameters = [];

        foreach ($parameters as $key => $value) {
            if(is_array($value)){
                foreach ($value as $key_array=>$val){
                    $final_parameters[] = $val;
                }
            }else{
                $final_parameters[$key] = $value;
            }
        }



        foreach ($final_parameters as $key => $value) {

            foreach ($array_special_char as $char) {

                if (strpos($value, $char) !== false) {
                    return true ;
                }

                if (strpos($key, $char) !== false) {
                    return true ;
                }
            }
            // Sanitize each parameter value
            $sanitized_value = self::sanitize_input($value);

            // Compare sanitized value with original value
            if ($sanitized_value !== strval($value)) {
                // If they are different, potential XSS attack detected
                return true ;
            }
        }
        
        
        return false ;
    }

    public static function redirectToNewTransactions() {

        header("Location: " . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . "/new-transaction-user");
    }

    public static function redirectToNewUrl() {
        $called_url     = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
     
        $redirect_controller  = Load::controller( 'redirect' );
        $redirect = $redirect_controller->getRedirectByOldUrl($called_url) ;
        if(isset($redirect) && !empty($redirect['url_new'])) {
            header("Location: " .$redirect['url_new']);
            exit;
        }
        return true;
    }
    public static function redirectTo410() {
        $called_url     = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $redirect_controller  = Load::controller( 'redirect' );

        $redirect = $redirect_controller->getRedirectBy410Url($called_url) ;


        if(isset($redirect) && !empty($redirect['url_old'])) {
            header("HTTP/1.1 410 Gone");
            include_once './410.shtml';
            exit();
        }
        return true;
    }


    public static function urlTo($path) {
        return ROOT_ADDRESS. '/' . $path;
    }


    public static function urlWithDate($url) {
      switch($url) {
          case 'resultExternalHotel' :
              $country = SEARCH_COUNTRY;
              $city = SEARCH_CITY;
              $firstURL = urldecode($_SERVER['REQUEST_URI']);
              $arrUrlFirst = explode('/', $firstURL);
              if(count($arrUrlFirst) <= 6 && isset($country) && isset($city)){
                  $today = dateTimeSetting::jtoday();
                  $tomorrow = dateTimeSetting::tomorrow();
                  $called_url     = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]/$today/$tomorrow/1/1-0-0";

                  header("Location: " .$called_url);
                  exit;
              }
            break ;
          case 'searchHotel' :

              $firstURL = urldecode($_SERVER['QUERY_STRING']);
              $arrUrlFirst = explode('/', $firstURL);
              $parsedGetUrl = explode('&', $arrUrlFirst[count($arrUrlFirst) - 1]);

              if(count($parsedGetUrl) <= 3 && isset($parsedGetUrl[2]) ){
                  $arrUrlCity = explode('=', $parsedGetUrl[2]);

                  if($arrUrlCity[0] == 'city' && isset($arrUrlCity[1]) && !empty($arrUrlCity[1])) {
                      $today = dateTimeSetting::jtoday();
                      $requested_url = str_replace( "&amp;", "&" , $_SERVER[REQUEST_URI]);
                      $called_url     = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$requested_url&startDate=$today&nights=1&rooms=R:1-0-0";
                      header("Location: " .$called_url);
                  }
              }
              break ;
      }
    }
    public static function setCorrectName($url) {

      switch($url) {
          case 'roomHotelLocal' :
              $firstURL = urldecode($_SERVER['REQUEST_URI']);
              $arrUrlFirst = explode('/', $firstURL);
              $type_application = TYPE_APPLICATION ; 
              if($type_application != 'reservation'){
                  include_once './404.html';
                  exit();
              }
              if(count($arrUrlFirst) >= 6){
                  $hotel_controller = Load::controller( 'reservationHotel' );
                  $hotel = $hotel_controller->getHotelById(['id' => $arrUrlFirst[5]]);
                  $name_en = $hotel['name_en'] ;
                  $name_en = str_replace(' ' , '_' , $name_en);
                  if($name_en) {

                      if($arrUrlFirst[6] != $name_en) {
                          unset($arrUrlFirst[6]);

                          $request_url = implode('/', $arrUrlFirst);
                          $called_url     = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$request_url/$name_en";

                          if($_SERVER['REMOTE_ADDR']=='84.241.4.20'){
                             
                              if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                  // Not a POST request
                                  // Generate a form to POST the data to the new URL
                                  echo '<form id="redirectForm" method="POST" action="' . htmlspecialchars($called_url) . '">';
                                  $request_data = [
                                      'startDate'  => $_POST['startDateForHotelLocal'] ,
                                      'nights'      => $_POST['nights']
                                  ];
                                  // Add POST data as hidden fields if needed
                                  foreach ($request_data as $key => $value) {
                                      echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
                                  }

                                  echo '</form>';
                                  echo '<script>document.getElementById("redirectForm").submit();</script>';
                                  exit();
                              }

                          }
                          header("HTTP/1.1 301 Moved Permanently");
                          header("Location: " .$called_url);
                          exit();
                      }
                  }
              }
            break ;
          case 'resultTourLocal' :
              $firstURL = urldecode($_SERVER['REQUEST_URI']);
              $arrUrlFirst = explode('/', $firstURL);
              $tour_type = SEARCH_TOUR_TYPE ;
              if($tour_type != 'all' && (!$tour_type || !is_numeric($tour_type)) ){
                  $arrUrlFirst[7] = 'all' ;
                  $request_url = implode('/', $arrUrlFirst);
                  $called_url     = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$request_url";
                  header("Location: " .$called_url);
                  exit();
              }

            break ;
      }
    }
    
    
    public static function redirectWithLang(){
        $firstURL = urldecode($_SERVER['REQUEST_URI']);
        if(strpos($firstURL, '/fa/') == false){

            $address = ROOT_ADDRESS   ;
            $firstURL =  str_replace('/gds' , '' , $firstURL);
          
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $address . $firstURL);
            exit();
        }
    }

    public static function isDateShamsi($date) {
             // Assume the date format is YYYY-MM-DD
            $parts = explode('-', $date);
            if (count($parts) != 3) {
                return false; // Invalid date format
            }

            $year = intval($parts[0]);

            // If the year is more than 1300, assume it's a Shamsi date
            if ($year > 1300 && $year < 1500) {
                return true; // Shamsi date
            } else {
                return false; // Miladi date
            }
     }

    public static function checkNoIndex() {

        $client_list = ['327' , '333'];
        $url_list = [
           'search-flight' ,
           'international' ,
           'searchHotel'  ,
           'detailHotel' ,
           'resultExternalHotel',
            'roomHotelLocal',
           'buses',
           'detailTour',
           'resultInsurance',
            'mag' ,
            'news'
        ];
        $date = '';
        if(in_array(CLIENT_ID , $client_list) && in_array(GDS_SWITCH , $url_list)) {
          
          if(GDS_SWITCH == 'search-flight') {
            $date = SEARCH_DEPT_DATE;
            if($date != 'SEARCH_DEPT_DATE' && $date != '') {
                return true ;
            }else{
                return false;
            }
          }
          else if(GDS_SWITCH == 'international') {
              $date = SEARCH_DEPT_DATE;
              if($date != 'SEARCH_DEPT_DATE' && $date != '') {
                  return true ;
              }else{
                  return false;
              }
          }
          else if(GDS_SWITCH == 'searchHotel') {

              if($date != 'SEARCH_START_DATE' && ($date != '' || (isset($_GET['startDate']) && $_GET['startDate'] != ''))) {
                  return true ;
              }else{
                  return false;
              }
          }
          else if(GDS_SWITCH == 'resultExternalHotel') {
              $date = SEARCH_START_DATE;

              if($date != 'SEARCH_START_DATE' && $date != '') {
                  return true ;
              }else{
                  return false;
              }
          }
            else if(GDS_SWITCH == 'roomHotelLocal') {
                $date = START_DATE;
                if($date != 'START_DATE'  && $date != '') {
                    return true ;
                }else{
                    return false;
                }
            }
          else if(GDS_SWITCH == 'buses') {
              $date = SEARCH_DATE_MOVE;
              if($date != 'SEARCH_DATE_MOVE'  && $date != '') {
                  return true ;
              }else{
                  return false;
              }
          }
          else if(GDS_SWITCH == 'detailHotel') {
              $date = REQUEST_NUMBER;

              if($date != 'REQUEST_NUMBER'  && $date != '') {
                  return true ;
              }else{
                  return false;
              }
          }
          else if(GDS_SWITCH == 'mag' || GDS_SWITCH == 'news') {
              $page = $_GET['page'];

              if($page != '') {
                  return true ;
              }else{
                  return false;
              }
          }
          return true ;
        }
        return false;
    }
   public static function getMemberCreditPayment($trackingCodeBank ,$totalPrice ) {
        $Model = Load::library('Model');
        $credit = 0;
        $result = 0;
        if ($trackingCodeBank != ''){
            $credit_query = " SELECT * FROM  members_credit_tb  WHERE bankTrackingCode='{$trackingCodeBank}' LIMIT 1";
        $res_credit = $Model->load($credit_query);
//         var_dump($res_credit['amount']);
        $result = $totalPrice - $res_credit['amount'];
        $credit = $res_credit['amount'];
        }
        return array( $credit ,  $result );
    }

    public static function hasAccessMarketPlace($type , $item) {
        $user_role_controller =  Load::controller( 'userRole' );
        $reservation_hotel_controller =  Load::controller( 'reservationHotel' );
        $is_admin =  $reservation_hotel_controller->isHotelAdmin(['hotel_id' => $item]) ;
        
        if($is_admin || Session::getCounterTypeId() == 1) {
          return [
            'has_access' => true ,
              'type'       => 'admin'
          ];
        }
        $params = [
          'type'    => $type ,
          'item_id' => $item
        ];
        $user_has_role =  $user_role_controller->hasAccessItem($params) ;
        if($user_has_role) {
            foreach($user_has_role as $role) {
              $role_list[] = $role['role'];
            }
            return [
                'has_access' => true ,
                'type'       => $role_list
            ];
        }

        return [
            'has_access' => false ,
            'type'       => ''
        ];
    }

    public static function getClientIds(){

        Load::autoload( 'ModelBase' );
        $ModelBase = new ModelBase();

        $sql = " SELECT id FROM clients_tb WHERE  id > 517 ORDER BY id DESC";

        $clientIds = $ModelBase->select( $sql );


        return array_column($clientIds, 'id');
    }


    #region generateRandomCode: generate random code of capital and small characters and numbers
    public static function getMarketHotelPriceChange( $hotel_id, $counterId, $date, $typeApplication ) {

        $model =  Load::getModel('changeHotelPriceModel');

        $date = str_replace( "-", "", $date );
        $date = str_replace( "/", "", $date );
        $y    = substr( $date, 0, 4 );
        $m    = substr( $date, 4, 2 );
        $d    = substr( $date, 6, 2 );
        $date = $y . "/" . $m . "/" . $d;

        return $model->get()
            ->where('reservation_hotel_id' , $hotel_id)
            ->where('counter_id' , $counterId)
            ->where('type_application' , $typeApplication)
            ->where('start_date' , $date , '<=')
            ->where('end_date' , $date , '>=')
            ->where('is_del' , 'no')->find();
    }
    #endregion
    public static function marketServiceDiscount( $CounterId, $TitleServiceDiscount , $market_id ) {
        /** @var servicesDiscount $ServiceDiscount */

        $ServiceDiscount = Load::controller( 'servicesDiscount' );
        return $ServiceDiscount->getDiscountByServiceAndMarketIdAndCounterId( $TitleServiceDiscount, $CounterId , $market_id );
    }

 /**
 * Gets current domain and creates a mini slug (uppercase first few letters)
 * 
 * @param int $length Number of characters to include in mini slug (default: 4)
 * @return string The mini slug in uppercase
 */
public static function getCurrentDomainMiniSlug($length = 4) {
    // Get current domain from server variables
    $domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '');
    // Remove port number if present (e.g., localhost:8080)
    $domain = preg_replace('/:\d+$/', '', $domain);
    // Remove www. prefix if present
    $domain = preg_replace('/^www\./', '', $domain);
    // Get the main part of the domain (before TLD)
    $domainParts = explode('.', $domain);
    $mainDomain = $domainParts[0];
    // Get the first $length characters and convert to uppercase
    $miniSlug = strtoupper(substr($mainDomain, 0, $length));
    return $miniSlug;
}
	public static function getApiClient() {
      	return ['386'] ;
    }

    public function ChangeDateForTransactions($date_of,$to_date){
       if (!empty($date_of) && !empty($to_date)) {
            $StartDateExplode = explode('-', $date_of);
            $StartPostDate = dateTimeSetting::jalali_to_gregorian($StartDateExplode[0], $StartDateExplode[1], $StartDateExplode[2], '-');

            $EndDateExplode = explode('-', $to_date);
            $EndPostDate = dateTimeSetting::jalali_to_gregorian($EndDateExplode[0], $EndDateExplode[1], $EndDateExplode[2], '-');

             $start_date=$StartPostDate . ' 00:00:00';
             $end_date=$EndPostDate . ' 23:59:59';
        }
       else {//miladi
             $date = dateTimeSetting::jdate("Y-m-d", time());
             $start_date=$date . ' 00:00:00';
             $end_date=$date . ' 23:59:59';
      }
       return array($start_date,$end_date);
    }






    public function getDayFromDate($date) {
        // استخراج روز از تاریخ
        $dateParts = explode('-', $date);
        return (int)$dateParts[2];
    }

    public function getMonthFromDate($date) {
        // استخراج ماه از تاریخ
        $dateParts = explode('-', $date);
        return (int)$dateParts[1];
    }

    public function getYearFromDate($date) {
        // استخراج سال از تاریخ
        $dateParts = explode('-', $date);
        return (int)$dateParts[0];
    }
    public function getPersianMonthName($month) {
        $persianMonths = [
            1 => 'فروردین', 2 => 'اردیبهشت', 3 => 'خرداد',
            4 => 'تیر', 5 => 'مرداد', 6 => 'شهریور',
            7 => 'مهر', 8 => 'آبان', 9 => 'آذر',
            10 => 'دی', 11 => 'بهمن', 12 => 'اسفند'
        ];
        return $persianMonths[$month];
    }

    public function getEnglishMonthName($month) {
        $englishMonths = [
            1 => 'January', 2 => 'February', 3 => 'March',
            4 => 'April', 5 => 'May', 6 => 'June',
            7 => 'July', 8 => 'August', 9 => 'September',
            10 => 'October', 11 => 'November', 12 => 'December'
        ];
        return $englishMonths[$month];
    }

    public function getCurrentYear() {
        return (int)date('Y');
    }

    public function isSafar360() {
        return CLIENT_ID == '166';
    }

}
