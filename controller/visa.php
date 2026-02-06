<?php

/**
 * Class visa
 *
 * @property visa $visa
 */

//if(  $_SERVER['REMOTE_ADDR']=='93.118.161.174'  ) {
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
//}
class visa extends clientAuth {

    protected $faqs_model;
    protected $docs_model;
    protected $step_model;
    public $list;

    public function __construct() {
        parent::__construct();
        $this->faqs_model = $this->getModel('visaFaqsModel');
        $this->docs_model = $this->getModel('visaDocsModel');
        $this->step_model = $this->getModel('visaStepModel');
    }

    public function changeNameUpload($fileName) {
        $ext = explode(".", $fileName);
        $fileName = date("sB")."-" . rand(10, 10000);
        $ext = strtolower($ext[count($ext)-1]);
        $fileName = $fileName.".".$ext;
        return $fileName;
    }

    #region visaList
    public function visaList() {
        return $this->getModel('visaModel')->get()->where('isDell','no')->all();
    }

    public function visaListWithTypeWithCountry() {
        $Model = Load::library( 'Model' );

        $query = "SELECT visa.*,
                    visaType.title as visaTypeName,
                    visaType.id as visaTypeID,
                    country.name as countryName,
                    country.name_en as countryName_en,
                    country.id as country_id
                    FROM visa_tb as visa
                    LEFT JOIN visa_type_detail_tb as visaTypeDetail ON visa.id = visaTypeDetail.visa_id
                    LEFT JOIN visa_type_tb as visaType ON visaType.id = visaTypeDetail.visa_type_id
                    LEFT JOIN reservation_country_tb as country ON visa.countryCode=country.abbreviation
                    WHERE visa.isDell = 'no' AND visa.validate = 'granted'
                    group by visa.id
                    ORDER BY 
                    CASE WHEN visa.priority IS NULL THEN 1 ELSE 0 END,
                    visa.priority ASC,
                    visa.id DESC";

        return $Model->select( $query );
    }

    public function visaFaqWithById($id){
        if(empty($id)) return false;

        $Model = Load::library( 'Model' );
        $query = "SELECT * FROM visa_faq_tb WHERE visa_id={$id}";

        return $Model->select( $query );
    }

    #endregion

    #region visaOptions
    public function visaOptions( $clientID ) {
        return functions::getMarketPlaceOptions( $clientID );
    }
    #endregion

    #region visaList
    public function deleteVisaStatus( $params ) {
        $Model = Load::library( 'Model' );
        if ( $params['status'] === 'yes' ) {
            $status = 'yes';
        } elseif ( $params['status'] === 'no' ) {
            $status = 'no';
        }
        $data['isDell'] = $status;
        $Model->setTable( 'visa_tb' );
        $result = $Model->update( $data, "id = '{$params['id']}'" );


        if ( $result ) {
            $output['status']  = 'success';
            $output['message'] = 'وضعیت ویزا با موفقیت تغییر یافت';
        } else {
            $output['status']  = 'error';
            $output['message'] = 'خطا در تغییر وضعیت ویزا';
        }

        return json_encode( $output, true );
    }
    #endregion


    #region changeVisaTypeMoreDetail
    public function changeVisaTypeMoreDetail( $params ) {
        $Model = Load::library( 'Model' );

        $data['type_id']    = $params['visaType_id'];
        $data['country_id'] = $params['country_id'];
        $data['url']        = $params['value'];

        $query
            = "SELECT * FROM visa_type_more_detail_tb
                WHERE type_id='{$data['type_id']}' AND country_id='{$data['country_id']}'
                 ";
        $resultSelect = $Model->load( $query );
        $Model->setTable( 'visa_type_more_detail_tb' );
        if ( empty( $resultSelect ) ) {


            $result = $Model->insertLocal( $data );

        } else {

            $result = $Model->update( $data, "id = '{$resultSelect['id']}'" );
        }

        if ( $result ) {
            $output['status']  = 'success';
            $output['message'] = 'وضعیت ویزا با موفقیت تغییر یافت';
        } else {
            $output['status']  = 'error';
            $output['message'] = 'خطا در تغییر وضعیت ویزا';
        }

        return json_encode( $output, true );
    }


    public function getVisaTypeMoreDetail( $params ) {
        $Model     = Load::library( 'Model' );
        $condition = '';
        if ( isset( $params['country_id'] ) && $params['country_id'] != '' ) {
            $condition .= " AND country_id= '" . $params['country_id'] . "'";
        }
        if ( isset( $params['type_id'] ) && $params['type_id'] != '' ) {
            $condition .= " AND type_id= '" . $params['type_id'] . "'";
        }

        $query="SELECT * FROM visa_type_more_detail_tb
                WHERE 1=1
                {$condition} ";

        return $Model->load( $query );
    }
    #endregion


    #region agencyVisaList
    public function agencyVisaList( $agency_id = null ) {
        $Model = Load::library( 'Model' );

        if ( isset( $agency_id ) && $agency_id != '' ) {
            $agency_id = " AND visa.agency_id = '" . $agency_id . "'";
        }

        $query="SELECT visa.*,
                    visaType.title as visaTypeName,
                    country.name as countryName,
                    country.name_en as countryName_en ,
                    category.title as category_title
                    FROM visa_tb as visa
                    LEFT JOIN visa_type_detail_tb as visaTypeDetail ON visa.id = visaTypeDetail.visa_id
                    LEFT JOIN visa_type_tb as visaType ON visaType.id = visaTypeDetail.visa_type_id
                    LEFT JOIN reservation_country_tb as country ON visa.countryCode=country.abbreviation AND country.is_del = 'no'
                    LEFT JOIN visa_category_tb as category ON visa.category_id = category.id
                    WHERE visa.isDell = 'no'
                    $agency_id
                    Group BY visa.id
                    ORDER BY visa.id desc";
        return $Model->select( $query );
    }
    #endregion

    ##region visaDetailData
    public function visaDetailData( $params ) {
        $Model=Load::library('Model');

        $query="SELECT visa.*,
                    visaType.title AS visaTypeName,
                    country.name AS countryName,
                    expiration.expired_at AS expired_at,
                    country.name_en AS countryName_en,
                    country.id_continent AS country_id
                    FROM visa_tb AS visa
                    LEFT JOIN visa_type_tb AS visaType ON visa.visaTypeID=visaType.id
                    LEFT JOIN reservation_country_tb AS country ON visa.countryCode=country.abbreviation
                    LEFT JOIN visa_expiration_tb AS expiration ON expiration.visa_id=visa.id

                    WHERE visa.isDell = 'no'
                    AND visa.agency_id = '" . Session::getUserId() . "'
                    AND visa.id = '" . $params['id'] . "'
                    ";
        $result = $Model->load( $query );

        if ( $result !== false ) {
            if ( SOFTWARE_LANG === 'fa' && ! empty( $result['expired_at'] ) ) {
                $result['correctExpired_at'] = $result['expired_at'];
                $date_orginal_exploded       = explode( ' ', $result['expired_at'] );
                $date_miladi_exp             = explode( '-', $date_orginal_exploded[0] );

                $result['expired_at'] = dateTimeSetting::gregorian_to_jalali( $date_miladi_exp[0], $date_miladi_exp[1], $date_miladi_exp[2], '/' ) . ' ' . $date_orginal_exploded[1];
            } else {
                if ( empty( $result['expired_at'] ) ) {
                    $result['expired_at'] = $result['correctExpired_at'] = '-';
                }
            }
            $currency                   = Load::controller( 'currency' );
            $currencyInfo               = $currency->ShowInfo( $result['currencyType'] );
            $result['currencyTypeName'] = $currencyInfo['CurrencyTitle'];
            $output['status']           = 'success';
            $output['data']['visa']     = $result;
            if ( isset( $params['fullData'] ) && $params['fullData'] ) {
                $queryTypes              = "SELECT * FROM visa_type_tb";
                $resultTypes             = $Model->select( $queryTypes );
                $output['data']['types'] = $resultTypes;
            }
        } else {
            $output['status']  = 'error';
            $output['message'] = 'خطا در دریافت ویزا';
        }

        return json_encode( $output, true );
    }
    #endregion

    #region getVisaByID
    public function getVisaByID( $id ) {
        $reservation_visa = Load::controller( 'resultReservationVisa' );
        $Model = Load::library( 'Model' );
        $id    = filter_var( $id, FILTER_VALIDATE_INT );

//        $query = "SELECT V.*, VT.title AS visaTypeTitle FROM  visa_tb V LEFT JOIN visa_type_tb VT ON V.visaTypeID = VT.id WHERE V.id = '{$id}'";
        $query = "
    SELECT 
        V.*, 
        VT.title AS visaTypeTitle, 
        RC.pic 
    FROM visa_tb V
    LEFT JOIN visa_type_tb VT ON V.visaTypeID = VT.id
    LEFT JOIN reservation_country_tb RC ON V.countryCode = RC.abbreviation
    WHERE V.id = '{$id}'
";

        $result = $Model->load( $query );

        $discountedPrice = $reservation_visa->calcDiscountedPrice($result['mainCost']);
        $result['priceWithDiscount'] = $discountedPrice['price'];

        return $result;
    }
    #endregion

    #region getVisaByID
    public function getVisaByFactorNumber( $factor_number ) {

        $Model         = Load::library( 'Model' );
        $factor_number = filter_var( $factor_number, FILTER_SANITIZE_NUMBER_INT );

        $query
            = "SELECT VB.*,VB.id as book_visa_id,V.*, VT.title,VB.custom_file_fields as main_custom_file_fields FROM book_visa_tb as VB
                INNER JOIN visa_tb V ON V.id = VB.visa_id 
                LEFT JOIN visa_type_tb VT ON V.visaTypeID = VT.id 
        
                
                WHERE VB.factor_number = '{$factor_number}'";


        return $Model->select( $query );
    }
    #endregion

    public function getBookRecordById( $id ) {

        $Model         = Load::library( 'Model' );
        $id = filter_var( $id, FILTER_SANITIZE_NUMBER_INT );

        $query
            = "SELECT VB.*,V.*, VT.title,VB.custom_file_fields as main_custom_file_fields FROM book_visa_tb as VB
                INNER JOIN visa_tb V ON V.id = VB.visa_id 
                LEFT JOIN visa_type_tb VT ON V.visaTypeID = VT.id 
        
                
                WHERE VB.id = '{$id}'";


        return $Model->select( $query );
    }

    public function updateBookRecord( $id,$data ) {

        $Model= Load::library( 'Model' );
        $id = filter_var( $id, FILTER_SANITIZE_NUMBER_INT );

        $booked_visa=$this->getBookRecordById($id);
        if($booked_visa){

            $Model->setTable( 'book_visa_tb' );
            return $Model->update( $data, "id = '{$id}'" );
        }
        return $booked_visa;

    }


    #region visaActivate: activate - deactivate a specified visa
    public function visaActivate( $param ) {
        $Model       = Load::library( 'Model' );
        $param['id'] = filter_var( $param['id'], FILTER_VALIDATE_INT );

        $queryStatus  = "SELECT isActive FROM visa_tb WHERE id = '{$param['id']}'";
        $resultStatus = $Model->load( $queryStatus );

        if ( $resultStatus['isActive'] == 'yes' ) {
            $data['isActive'] = 'no';
        } else {
            $data['isActive'] = 'yes';
        }

        $Model->setTable( 'visa_tb' );
        $result = $Model->update( $data, "id = '{$param['id']}'" );

        if ( $result ) {
            $output['result_status']  = 'success';
            $output['result_message'] = 'وضعیت ویزا با موفقیت تغییر یافت';
        } else {
            $output['result_status']  = 'error';
            $output['result_message'] = 'خطا در تغییر وضعیت ویزا';
        }

        return $output;
    }


    public function visaValidate( $param ) {
        $Model       = Load::library( 'Model' );
        $param['id'] = filter_var( $param['id'], FILTER_VALIDATE_INT );

        $queryStatus  = "SELECT validate FROM visa_tb WHERE id = '{$param['id']}'";
        $resultStatus = $Model->load( $queryStatus );

        if ( $resultStatus['validate'] == 'granted' ) {
            $data['validate'] = 'denied';
        } else {
            $data['validate'] = 'granted';
        }

        $Model->setTable( 'visa_tb' );
        $result = $Model->update( $data, "id = '{$param['id']}'" );

        if ( $result ) {
            $output['result_status']  = 'success';
            $output['result_message'] = 'وضعیت ویزا با موفقیت تغییر یافت';
        } else {
            $output['result_status']  = 'error';
            $output['result_message'] = 'خطا در تغییر وضعیت ویزا';
        }

        return $output;
    }

    public function visaOptionByKey( $param ) {
        return functions::getMarketPlaceOptionByKey( $param );
    }

    public function visaOptionChangeStatus( $param ) {
        $admin    = Load::controller( 'admin' );
        $clientID = filter_var( $param['clientID'], FILTER_VALIDATE_INT );

        $queryStatus  = "SELECT value FROM visa_options_tb WHERE id = '{$param['id']}'";
        $resultStatus = $admin->ConectDbClient( $queryStatus, $clientID, 'Select', '', '', '' );

        if ( $resultStatus['value'] == 'available' ) {
            $data['value'] = 'disabled';
        } else {
            $data['value'] = 'available';
        }


        $result = $admin->ConectDbClient( '', $clientID, 'Update', $data, 'visa_options_tb', "id = '{$param['id']}'" );

        if ( $result ) {
            $output['result_status']  = 'success';
            $output['result_message'] = 'وضعیت ویزا با موفقیت تغییر یافت';
        } else {
            $output['result_status']  = 'error';
            $output['result_message'] = 'خطا در تغییر وضعیت ویزا';
        }

        return $output;
    }

    public function visaAdminReviewChange( $param ) {
        $Model       = Load::library( 'Model' );
        $param['id'] = filter_var( $param['id'], FILTER_VALIDATE_INT );

        $queryStatus  = "SELECT adminReview FROM visa_tb WHERE id = '{$param['id']}'";
        $resultStatus = $Model->load( $queryStatus );

        $data['adminReview'] = $param['value'];


        $Model->setTable( 'visa_tb' );
        $result = $Model->update( $data, "id = '{$param['id']}'" );

        if ( $result ) {
            $output['result_status']  = 'success';
            $output['result_message'] = 'یادداشت ویزا با موفقیت تغییر یافت';
        } else {
            $output['result_status']  = 'error';
            $output['result_message'] = 'خطا در تغییر یادداشت ویزا';
        }

        return $output;
    }

    #endregion

    public function visaExpirationDiff( $visa ) {
        $Model       = Load::library( 'Model' );
        $param['id'] = filter_var( $visa, FILTER_VALIDATE_INT );

        $queryStatus  = "SELECT * FROM visa_tb WHERE id = '{$param['id']}'";
        $resultStatus = $Model->load( $queryStatus );


        if ( ! empty( $resultStatus['id'] ) ) {
            $queryExpirationStatus  = "SELECT * FROM visa_expiration_tb WHERE visa_id = '{$param['id']}'";
            $resultExpirationStatus = $Model->load( $queryExpirationStatus );

            if ( ! empty( $resultExpirationStatus['id'] ) ) {

                // Declare and define two dates
                $date1 = strtotime( $resultExpirationStatus['expired_at'] );
                $date2 = time();

                if ( $date2 < $date1 ) {
                    // Formulate the Difference between two dates
                    $diff = abs( $date2 - $date1 );


                    // To get the year divide the resultant date into
                    // total seconds in a year (365*60*60*24)
                    $years = floor( $diff / ( 365 * 60 * 60 * 24 ) );


                    // To get the month, subtract it with years and
                    // divide the resultant date into
                    // total seconds in a month (30*60*60*24)
                    $months = floor( ( $diff - $years * 365 * 60 * 60 * 24 ) / ( 30 * 60 * 60 * 24 ) );


                    // To get the day, subtract it with years and
                    // months and divide the resultant date into
                    // total seconds in a days (60*60*24)
                    $days = floor( ( $diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 ) / ( 60 * 60 * 24 ) );


                    // To get the hour, subtract it with years,
                    // months & seconds and divide the resultant
                    // date into total seconds in a hours (60*60)
                    $hours = floor( ( $diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 ) / ( 60 * 60 ) );


                    // To get the minutes, subtract it with years,
                    // months, seconds and hours and divide the
                    // resultant date into total seconds i.e. 60
                    $minutes = floor( ( $diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 ) / 60 );


                    // To get the minutes, subtract it with years,
                    // months, seconds, hours and minutes
                    $seconds = floor( ( $diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60 ) );


                    $yearsText   = ( $years == '0' ? null : $years . ' سال ' );
                    $monthsText  = ( $months == '0' ? null : $months . ' ماه ' );
                    $daysText    = ( $days == '0' ? null : $days . ' روز ' );
                    $hoursText   = ( $hours == '0' ? null : $hours . ' ساعت ' );
                    $minutesText = ( $minutes == '0' ? null : $minutes . ' دقیقه ' );

                    $fullText = $yearsText . $monthsText . $daysText . $hoursText . $minutesText;


                    $output['result_status']                   = 'success';
                    $output['result_message']['remainingTile'] = ( $fullText === null ? 'بدون پلن' : $fullText );
                    $output['result_message']['expired_at']    = $resultExpirationStatus['expired_at'];

                    $date_orginal_exploded = explode( ' ', $resultExpirationStatus['expired_at'] );
                    $date_miladi_exp       = explode( '-', $date_orginal_exploded[0] );
                    $expired_at            = dateTimeSetting::gregorian_to_jalali( $date_miladi_exp[0], $date_miladi_exp[1], $date_miladi_exp[2], '-' ) . ' ' . $date_orginal_exploded[1];

                    $output['result_message']['expired_at_fa'] = $expired_at;
                } else {
                    $output['result_status']                   = 'error';
                    $output['result_message']['remainingTile'] = 'منقضی شده';
                    $output['result_message']['expired_at']    = $resultExpirationStatus['expired_at'];

                    $date_orginal_exploded = explode( ' ', $resultExpirationStatus['expired_at'] );
                    $date_miladi_exp       = explode( '-', $date_orginal_exploded[0] );
                    $expired_at            = dateTimeSetting::gregorian_to_jalali( $date_miladi_exp[0], $date_miladi_exp[1], $date_miladi_exp[2], '-' ) . ' ' . $date_orginal_exploded[1];

                    $output['result_message']['expired_at_fa'] = $expired_at;
                }
            } else {
                if ( $resultStatus['agency_id'] == '0' ) {
                    $output['result_status']                   = 'success';
                    $output['result_message']['remainingTile'] = 'همیشه';
                    $output['result_message']['expired_at']    = 'همیشه';
                } else {
                    $output['result_status']                   = 'error';
                    $output['result_message']['remainingTile'] = 'پلن یافت نشد';
                }

            }
        } else {
            $output['result_status']  = 'error';
            $output['result_message'] = 'ویزا یافت نشد';
        }

        return $output;
    }

    public function visaAddExpiration( $param ) {

        $objMember     = Load::controller( 'members' );
        $counterCredit = $objMember->getCredit();


        $monthNumber = $param['visaExpiration'];

        switch ( $monthNumber ) {
            case "1":
                $price = '2000000';
                break;
            case "2":
                $price = '3700000';
                break;
            case "3":
                $price = '5500000';
                break;
        }

        if ( $counterCredit > $price ) {

            $objMember->decreaseCounterCredit( $price, $param['visa_id'], [
                'monthNumber' => $param['visaExpiration'],
                'member_id'   => Session::getUserId(),
                'visa_id'     => $param['visa_id'],
                'visa_title'  => $param['visa_title'],
            ], 'visaExpiration', 'no' );

            $comment           = "خرید پلن " . $param['visaExpiration'] . " ماهه برای ویزای " . $param['visa_title'] . ' (' . $param['visa_id'] . ') ';
            $objTransaction    = Load::controller( 'transaction' );
            $reduceTransaction = $objTransaction->decreaseSuccessCredit( $price, $param['visa_id'], $comment, 'buy_visa_plan' );

            if ( $reduceTransaction ) {
                $created_at         = date( 'Y-m-d H:i:s', time() );
                $dateTime           = '+' . $monthNumber . ' month';
                $expired_at         = date( "Y-m-d H:i:s", strtotime( $dateTime ) );
                $Model              = Load::library( 'Model' );
                $data['visa_id']    = $param['visa_id'];
                $data['created_at'] = $created_at;
                $data['expired_at'] = $expired_at;

                $Model->setTable( 'visa_expiration_tb' );
                $resultInsert = $Model->insertLocal( $data );
            } else {
                return 'error:' . functions::Xmlinformation( 'ErrorDecreaseCredit' );
            }


        }
        if ( $resultInsert ) {
            $output['status']  = 'success';
            $output['message'] = 'افزودن ویزا با موفقیت انجام شد';
        } else {
            $output['status']  = 'error';
            $output['message'] = 'خطا در فرایند افزودن ویزا';
        }

        return $output;
    }
    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        $return = json_encode([
            'success' => $success,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return $return;
    }

    #region visaAdd: add a visa
    public function visaAdd( $param ) {


        //        return functions::TypeUser(Session::getUserId());
        if ( $param['pageType'] == 'client' ) {
            $agency_id = Session::getUserId();
        } else {
            $agency_id = '0';
        }
        if ( $this->visaOptionByKey( [
                'clientID' => $param['clientID'],
                'key'      => 'apiDetail',
            ] )['value'] == 'disabled' ) {
            $redirectUrlCheck = 0;
        } else {
            $redirectUrlCheck = 1;
        }


        $Model = Load::library( 'Model' );
        for ( $i = 0; $i <= $param['visaCount'] - 1; $i ++ ) {
            if ( $agency_id == '0' ) {
                $data['validate'] = 'granted';
            }

            if(isset($param['visaCategory'][ $i ])) {
                $visa_category = $param['visaCategory'][ $i ] ;
            }else {
                $visa_category = 1 ;
            }

            $data['title']              = filter_var( $param['title'][ $i ], FILTER_SANITIZE_STRING );
            $data['countryCode']        = filter_var( $param['countryCode'], FILTER_SANITIZE_STRING );
            $data['agency_id']          = $agency_id;
//            $data['visaTypeID']         = filter_var( $param['visaTypeID'][ $i ], FILTER_VALIDATE_INT );
            $data['mainCost']           = filter_var( $param['mainCost'][ $i ], FILTER_SANITIZE_NUMBER_INT );
            $data['prePaymentCost']     = filter_var( $param['prePaymentCost'][ $i ], FILTER_SANITIZE_NUMBER_INT );
            if( $visa_category == 1 || $visa_category == 2 ){
                $data['deadline']           = filter_var( $param['deadline'][ $i ], FILTER_SANITIZE_STRING );
                $data['validityDuration']   = filter_var( $param['validityDuration'][ $i ], FILTER_SANITIZE_STRING );
//                $data['allowedUseNo']       = filter_var( $param['allowedUseNo'][ $i ], FILTER_SANITIZE_STRING );
            }
            $data['currencyType']       = filter_var( $param['currencyType'][ $i ], FILTER_VALIDATE_INT );
            $data['OnlinePayment']      = ( isset( $param['OnlinePayment'] ) ? 'yes' : 'no' );
            $data['documents']          = ( isset( $param['documents'][ $i ] ) ? $param['documents'] : null );
            $data['custom_file_fields'] = ( isset( $param['custom_file_fields'][ $i ] ) ? json_encode( $param['custom_file_fields'], 256|64 ) : null );
            $data['descriptions']       = ( isset( $param['descriptions'] ) ? $param['descriptions'] : null );
            $data['price_table']       = ( isset( $param['price_table'] ) ? $param['price_table'] : null );;
//            $data['maximumNation']       = ( isset( $param['maximumNation'] ) ? $param['maximumNation'] : null );;

//            $data['descriptions']              = filter_var( $param['descriptions'], FILTER_SANITIZE_STRING );
            $data['redirectUrlCheck']   = $redirectUrlCheck;

            $data['isDell']          = 'no';
            $data['creationDateInt'] = time();
            $data['category_id']      = $visa_category;
            $data['cover_image'] = $param['cover_image'];
            $config = Load::Config('application');
            $path = "visa/";
            $config->pathFile($path);
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['name'] != "" && $data['cover_image'] == '') {
                $_FILES['cover_image']['name'] = self::changeNameUpload($_FILES['cover_image']['name']);

                $feature_upload = $config->UploadFile("pic", "cover_image", "5120000");
                $explode_name_pic = explode(':', $feature_upload);

                if ($explode_name_pic[0] == 'done') {
                    $feature_image = $path . $explode_name_pic[1];
                    $data['cover_image'] = $feature_image;
                }
            }


            $Model->setTable( 'visa_tb' );


            $resultInsert = $Model->insertWithBind( $data );
            $this->updateVisaDetail($param['VisaData'],$resultInsert);

            if ( $resultInsert ) {
                if ( isset( $param['visa_statuses'] ) && is_array( $param['visa_statuses'] ) ) {

                    $Model->setTable( 'visa_status_rel_tb' );
                    $Model->delete( "visa_id='{$resultInsert}'" );

                    foreach ( $param['visa_statuses'][ $i ] as $status ) {

                        $relation_insert = $Model->insertWithBind( [ 'visa_id' => $resultInsert, 'status_id' => $status ] );
                    }
                }

                if ( $agency_id === '0' ) {
                    goto finalStep;
                }
                $sqlExist                          = "SELECT id AS lastID FROM visa_tb ORDER BY id DESC";
                $resultSelect                      = $Model->load( $sqlExist );
                $paramExpiration['visa_id']        = $resultSelect['lastID'];
                $paramExpiration['visa_title']     = $param['title'][ $i ];
                $paramExpiration['visaExpiration'] = $param['visaExpiration'][ $i ];
                $paramExpiration['member_id']      = Session::getUserId();
                if ( $param['visaExpiration'][ $i ] > 0 ) {

                    $visaAddExpiration = $this->visaAddExpiration( $paramExpiration );
                    if ( $visaAddExpiration['status'] !== 'success' ) {
                        return [
                            'result_status'  => 'error',
                            'result_message' => 'error in visaAddExpiration insert'
                        ];
                    }
                }
            } else {
                return [
                    'result_status'  => 'error',
                    'result_message' => 'error in visa insert'
                ];
            }

        }


        finalStep:

        return [
            'result_status'  => 'success',
            'result_message' => 'ویزا با موفقیت ایجاد شد'
        ];
    }
    #endregion

    #region visaEdit: edit a visa
    public function visaEdit( $param ) {

    functions::insertLog('data: ' . json_encode($param) , '000shojaee');
        $param['id'] = filter_var( $param['id'], FILTER_VALIDATE_INT );

        $Model = Load::library( 'Model' );

        $sqlExist     = "SELECT id AS existID FROM visa_tb WHERE id = '{$param['id']}' AND isDell = 'no'";
        $resultSelect = $Model->load( $sqlExist );

        $visa_category = $param['visaCategory'];
        if ( ! empty( $resultSelect['existID'] ) ) {

            $data['title']              = filter_var( $param['title'], FILTER_SANITIZE_STRING );
            $data['countryCode']        = filter_var( $param['countryCode'], FILTER_SANITIZE_STRING );
//            $data['visaTypeID']         = filter_var( $param['visaTypeID'], FILTER_VALIDATE_INT );
            $data['mainCost']           = filter_var( $param['mainCost'], FILTER_SANITIZE_NUMBER_INT );
            $data['prePaymentCost']     = filter_var( $param['prePaymentCost'], FILTER_SANITIZE_NUMBER_INT );
            if( $visa_category == 1 || $visa_category == 2 ) {
                $data['deadline'] = filter_var($param['deadline'], FILTER_SANITIZE_STRING);
                $data['validityDuration'] = filter_var($param['validityDuration'], FILTER_SANITIZE_STRING);
//                $data['allowedUseNo'] = filter_var($param['allowedUseNo'], FILTER_SANITIZE_STRING);
            }
            $data['currencyType']       = filter_var( $param['currencyType'], FILTER_VALIDATE_INT );
            $data['OnlinePayment']      = ( isset( $param['OnlinePayment'] ) ? 'yes' : 'no' );
            $data['custom_file_fields'] = ( isset( $param['custom_file_fields'] ) ? json_encode( $param['custom_file_fields'], 256|64 ) : null );
            $data['documents']          = ( isset( $param['documents'] ) ? $param['documents'] : null );
//			$data['descriptions']       = ( isset( $param['descriptions'] ) ? $param['descriptions'] : null );
            $data['price_table']       = $param['price_table'];
//            $data['maximumNation']       = $param['maximumNation'];

//			            $data['visa_statuses'] = filter_var($param['visa_statuses'],FILTER_VALIDATE_INT);

            if ( isset( $param['adminReview'] ) ) {
                $data['adminReview'] = @$param['adminReview'];
            }
//            $data['descriptions']        = filter_var( $param['descriptions'], FILTER_SANITIZE_STRING );
            $data['descriptions']       = $param['descriptions'];



            $data['lastEditInt']  = time();

            $Condition = "id='{$param['id']}'";

            $data['cover_image'] = isset($param['old_cover_image']) ? $param['old_cover_image'] : '';

            $config = Load::Config('application');
            $path = "visa/";
            $config->pathFile($path);

// اگر فایل جدید ارسال شده
            if (!empty($_FILES['cover_image']['name'])) {

                $_FILES['cover_image']['name'] = self::changeNameUpload($_FILES['cover_image']['name']);
                $feature_upload = $config->UploadFile("pic", "cover_image", "5120000");
                $explode_name_pic = explode(':', $feature_upload);

                if ($explode_name_pic[0] == 'done') {
                    $data['cover_image'] = $path . $explode_name_pic[1];
                }
            }

            $Model->setTable( 'visa_tb' );
//            var_dump('aaaaa');
//            var_dump($data);
//            var_dump('bbbbb');
//            die;
            $this->updateVisaDetail($param['VisaData'],$param['id']);
            $resultInsert = $Model->updateWithBind( $data, [ 'id' => $param['id'] ] );

            if ( isset( $param['visa_statuses'] ) && is_array( $param['visa_statuses'] ) ) {
                $Model->setTable( 'visa_status_rel_tb' );
                $Model->delete( "visa_id='{$param['id']}'" );
                foreach ( $param['visa_statuses'] as $status ) {
                    $relation_insert = $Model->insertWithBind( [ 'visa_id' => $param['id'], 'status_id' => $status ] );
                }
            }
            if ( $resultInsert ) {
                $output['result_status']  = 'success';
                $output['result_message'] = 'ویرایش ویزا با موفقیت انجام شد';
            } else {
                $output['result_status']  = 'error';
                $output['result_message'] = 'خطا در فرایند ویرایش ویزا';
            }

        } else {
            $output['result_status']  = 'error';
            $output['result_message'] = 'خطا در ویرایش ویزا، ویزای مورد نظر یافت نشد';
        }

        return $output;
    }
    #endregion

    private function updateVisaDetail($visaData, $visa_id)
    {
        $Model = Load::library('Model');

        if (empty($visaData) || !is_array($visaData)) {
            return false;
        }

        // 1) حذف همه رکوردهای قبلی برای این visa_id
        $Model->setTable('visa_type_detail_tb');
        $Model->delete([
            'visa_id' => $visa_id
        ]);

        // 2) اینسرت مجدد از روی ورودی جدید
        foreach ($visaData as $item) {

            $visaTypeID    = isset($item['visaTypeID']) ? filter_var($item['visaTypeID'], FILTER_VALIDATE_INT) : '';
            $maximumNation = isset($item['maximumNation']) ? filter_var($item['maximumNation'], FILTER_SANITIZE_STRING) : '';
            $allowedUseNo  = isset($item['allowedUseNo']) ? $item['allowedUseNo'] : '';

            if (empty($visaTypeID)) {
                continue;
            }

            $Model->setTable('visa_type_detail_tb');
            $Model->insertWithBind([
                'visa_id'        => $visa_id,
                'visa_type_id'   => $visaTypeID,
                'maximum_nation' => $maximumNation,
                'allowed_use_no' => $allowedUseNo
            ]);
        }

        return true;
    }

    public function getActiveVisa(){
        $Model = Load::library('Model');
        $sql = "SELECT
        vt.id,
        vt.title,
        vt.countryCode,
        CASE
            WHEN vtt.id IS NOT NULL THEN vtt.id
            WHEN vtt.id IS NULL AND vt.visaTypeID IS NOT NULL THEN vt.visaTypeID
            ELSE NULL 
        END AS typeId
    FROM
        visa_tb vt
    LEFT JOIN
        visa_type_detail_tb vtdt ON vt.id = vtdt.visa_id
    LEFT JOIN
        visa_type_tb vtt ON vtt.id = vtdt.visa_type_id
    WHERE
        vt.validate = 'granted' AND vt.isActive = 'yes' AND vt.isDell = 'no'
    Group by vt.id
    ORDER BY
        CASE WHEN vt.priority IS NULL THEN 1 ELSE 0 END,
        vt.priority ASC,
        vt.id DESC;
            ";
        $result = $Model->select($sql);
        return $result;
    }

    public function getVisaDetail($visa_id)
    {

        $Model = Load::library( 'Model' );

        if (empty($visa_id)) {
            return false;
        }


        $visa_query = "SELECT
                        visa_type_detail_tb.id,
                        visa_type_detail_tb.visa_type_id,
                        visa_type_detail_tb.maximum_nation,
                        visa_type_detail_tb.allowed_use_no,
                        visa_type_tb.title
                    FROM visa_type_detail_tb
                             LEFT JOIN visa_type_tb
                                       ON visa_type_tb.id = visa_type_detail_tb.visa_type_id
                   where visa_type_detail_tb.visa_id = {$visa_id}";
        $visa_detail = $Model->loadAll( $visa_query );

        return $visa_detail;

    }

    public function getVisaDetailById($id)
    {
        $Model = Load::library( 'Model' );

        $Model->setTable('visa_type_detail_tb');
        if (empty($id)) {
            return false;
        }

        $visa_detail = $Model
            ->get(['id','visa_type_id','maximum_nation','allowed_use_no'])
            ->where([
                ['index' => 'id', 'value' => $id],
            ])
            ->all();


        return $visa_detail[0];
    }

    #region getReportVisaAgency
    public function getReportVisaAgency( $agency_id ) {

        return $this->getModel('bookVisaModel')->get()->where('agency_id', $agency_id )->groupBy('factor_number')->all();
    }

    #endregion
    public function getVisaStatuses( $id ) {

        $sql
            = "SELECT
	`status`.title AS StatusTitle,
	`status`.id AS StatusId
	FROM visa_tb as visa
	LEFT JOIN visa_status_rel_tb AS rel ON visa.id = rel.visa_id
	LEFT JOIN visa_request_status_tb AS `status` ON rel.status_id = `status`.id
WHERE
	visa.isDell = 'no'
	AND rel.visa_id = '{$id}'
	
ORDER BY
	visa.id DESC";

        $model    = Load::library( 'Model' );
        $result   = $model->select( $sql );
        $response = array();
        if ( is_array( $result ) ) {
            foreach ( $result as $item ) {
                $response[ $item['StatusId'] ] = $item['StatusTitle'];
            }
        }

        return $response;
    }



    public function updateCustomFileField($param)
    {

        $factor_number = $param['factor_number'];
        $field = $param['field'];
        $passenger = $param['passenger'];
        $file = $_FILES['file'];


        $config = Load::Config('application');
        $config->pathFile('visaPassengersFiles/');


        $visa = $this->getVisaByFactorNumber($factor_number);


        if ($visa) {

            $inputName = 'file';
            $success = $config->UploadFile("pic", $inputName, "2097152");
            $exp_name_pic = explode(':', $success);

            if ($exp_name_pic[0] == "done") {
                $uploaded_file_name = $exp_name_pic[1];



            } else {
                $uploaded_file_name = '';
            }

            if ($uploaded_file_name) {
                $custom_file_fields = json_decode($visa[$passenger]['main_custom_file_fields'], true);


//        $target_field=$custom_file_fields[$field];

                foreach ($custom_file_fields as $key=>$custom_file_field) {
                    if (key($custom_file_field) == $field) {
                        $target_key = $key;
                        break;
                    }
                }





                if (file_exists(PIC_ROOT.'visaPassengersFiles/'.$custom_file_fields[$target_key][$field])) {
                    unlink(PIC_ROOT.'visaPassengersFiles/'.$custom_file_fields[$target_key][$field]);
                }



                $custom_file_fields[$target_key][$field] = $uploaded_file_name;

                $new_data['custom_file_fields']=json_encode($custom_file_fields,256|64);


                $update_result=$this->updateBookRecord($visa[$passenger]['book_visa_id'],$new_data);

                if($update_result){
                    return true;
                }
                return false;
            }


        }
    }

    public function updateVisaFiles($param)
    {

        $factor_number = $param['factor_number'];
        $passenger = $param['passenger'];
        $file = $_FILES['file'];


        $config = Load::Config('application');
        $config->pathFile('visaPassengersFiles/');


        $visa = $this->getVisaByFactorNumber($factor_number);


        if ($visa) {

            $inputName = 'file';
            $success = $config->UploadFile("pic", $inputName, "2097152");
            $exp_name_pic = explode(':', $success);

            if ($exp_name_pic[0] == "done") {
                $uploaded_file_name = $exp_name_pic[1];



            } else {
                $uploaded_file_name = '';
            }

            if ($uploaded_file_name) {





                if (file_exists(PIC_ROOT.'visaPassengersFiles/'.$visa[$passenger]['visa_files'])) {
                    unlink(PIC_ROOT.'visaPassengersFiles/'.$visa[$passenger]['visa_files']);
                }



                $visa[$passenger]['visa_files'] = $uploaded_file_name;

                $new_data['visa_files']=$visa[$passenger]['visa_files'];


                $update_result=$this->updateBookRecord($visa[$passenger]['book_visa_id'],$new_data);

                if($update_result){
                    return true;
                }
                return false;
            }


        }
    }

    public function continentsHaveVisa($params=[]) {

        $searchTerm = isset($params['value']) ? $params['value'] : '';

        $continents= $this->getController('continentCodes')->getListContinents();
        $result=[];
        $country_model=$this->getModel('reservationCountryModel');
        $visa_model=$this->getModel('visaModel');
        $visa_table=$visa_model->getTable();
        $country_table=$country_model->getTable();
        foreach ($continents as $continent) {
            $visa_check=$visa_model->get('COUNT('.$visa_table.'.id) as existence',true)
                ->join($country_table,'abbreviation','countryCode','INNER')
                ->where($visa_table.'.isActive','yes')
                ->where($visa_table.'.isDell','no');

            $visa_check=$visa_check->where($visa_table.'.isDell','no')
                ->where($country_table.'.id_continent',$continent['id'])
                ->find();
//            var_dump($continent['titleFa']);
//            die();
            if ($visa_check['existence']) {
                if (empty($searchTerm) || mb_stripos($continent['titleFa'], $searchTerm, 0, 'UTF-8') !== false) {
                    $result[] = $continent;
                }
            }

        }
        return $result;

    }
    public function countriesHaveVisaByContinentId($continent_id) {


        $visa_results = $this->getModel('visaModel')->get(['countryCode'])->where('isActive','yes')->where('isDell','no')->groupBy('countryCode')->all();

        $array_country_code =functions::convertResultOneDimensionalArray($visa_results,'countryCode');

        $countries = $this->getController('reservationCountry')->countriesOfContinent(['continent_id'=>$continent_id]);

        $countries_with_visa = array();

        foreach ($countries as $key=>$country){

            if(isset($country['abbreviation'])) {
                $country['code'] = $country['abbreviation'] ;
            }

            if (in_array($country['code'], $array_country_code)) {
                $countries_with_visa[$key]['code']     = $country['abbreviation'] ? $country['abbreviation']  : $country['code'];
                $countries_with_visa[$key]['title']    = $country['name'] ? $country['name']:$country['titleFa'];
                $countries_with_visa[$key]['title_en'] = $country['name_en'] ? $country['name_en'] :$country['titleEn'];
            }
        }

        return $countries_with_visa;
    }

    public function visaTypesByCountryId($params) {

//        todo convert this sql to orm
        /** @var ModelBase $ModelBase */


        $request = [];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }

        $correctDate = date( 'Y-m-d H:i:s' );
        $value='';
        if($params['value']){
            $value = " AND (visaType.title LIKE '%{$params['value']}%')";

        }
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
".$value."
	
	GROUP BY visaType.id


";



        return $Model->select( $clientSql );
    }

    #region visaCategoryList
    public function visaCategoryList($param) {
        $visaModel = $this->getModel('visaModel') ;
        $visa = $visaModel->get()
            ->where('category_id' , $param['category_id'])
            ->where('isDell' , 'no');
        if(isset($param['limit']) && !empty($param['limit'])){
            $visa = $visa->limit(0 , $param['limit']);
        }
        return $visa->all();
    }
    #endregion

    public function getVisaListByCategoryId($param){

        $result = [];
        $visa_model = $this->getModel('visaModel');
        $visa_category_model = $this->getModel('visaCategoryModel');
        $reservation_country_model = $this->getModel('reservationCountryModel');
        $visa_type_model = $this->getModel('visaTypeModel');
        $visa_tb = $visa_model->getTable();
        $visa_category_tb = $visa_category_model->getTable();
        $reservation_country_tb = $reservation_country_model->getTable();
        $visa_type_tb = $visa_type_model->getTable();
        $Model = Load::library('Model');
        $correctDate=date('Y-m-d H:i:s');

        $querySearch = "SELECT V.countryCode, country.name , country.name_en FROM visa_tb V " .
            "LEFT JOIN visa_expiration_tb as Expiration ON Expiration.visa_id=V.id " .
            "LEFT JOIN reservation_country_tb as country ON country.abbreviation=V.countryCode " .
            "WHERE  
                       CASE
		
                                WHEN V.agency_id = '0' THEN
                                1 ELSE Expiration.expired_at 
                            END >
                        CASE
                                
                                WHEN V.agency_id = '0' THEN
                                0 ELSE '{$correctDate}' 
                            END 
                       AND V.isActive = 
                        CASE WHEN V.agency_id = '0' THEN V.isActive  ELSE 'yes' END
                        AND V.isDell = 'no'
                        AND V.validate = 'granted'
                        AND V.category_id = '{$param['category_id']}'
                        AND V.countryCode is not null 
                        AND V.visaTypeId is not null 
                        GROUP BY V.countryCode ";

        $visa_list = $Model->select($querySearch);


        foreach ($visa_list as $visa) {

            $querySearchVisa = "SELECT V.*, country.name , country.name_en , visaType.title as type_title , 
                            category.title as category_title
                FROM visa_tb V " .
                "LEFT JOIN visa_expiration_tb as Expiration ON Expiration.visa_id=V.id " .
                "LEFT JOIN reservation_country_tb as country ON country.abbreviation=V.countryCode " .
                "LEFT JOIN visa_type_tb as visaType ON visaType.id=V.visaTypeID " .
                "LEFT JOIN visa_category_tb as category ON country.id=V.category_id " .
                "WHERE  
                       CASE
		
                                WHEN V.agency_id = '0' THEN
                                1 ELSE Expiration.expired_at 
                            END >
                        CASE
                                
                                WHEN V.agency_id = '0' THEN
                                0 ELSE '{$correctDate}' 
                            END 
                       AND V.isActive = 
                        CASE WHEN V.agency_id = '0' THEN V.isActive  ELSE 'yes' END
                        AND V.isDell = 'no'
                        AND V.validate = 'granted'
                        AND visaType.isDell = 'no'
                        AND V.category_id = '{$param['category_id']}'
                        AND V.countryCode = '{$visa['countryCode']}'
                        AND V.countryCode is not null 
                        AND V.visaTypeId is not null 
                        GROUP BY V.visaTypeID ";

            $visa_type_list = $Model->select($querySearchVisa);

            $result[] = [
                'country_code'  => $visa['countryCode'] ,
                'country_name'  => $visa['name'] ,
                'country_name_en'  => $visa['name_en'] ,
                'visa_list'     => $visa_type_list
            ];

        }
        return $result ;
    }


    //  faq visa


    public function addVisaFaq($params) {
        $insert_data = $this->faqs_model
            ->insertWithBind([
                'question' => $params['question'],
                'answer' => $params['answer'],
                'visa_id' => $params['visa_id'],
            ]);

        if ($insert_data) {
            return functions::JsonSuccess($params['visa_id'], 'اطلاعات سوالات متداول با موفقیت ثبت گردید');
        }
        return functions::JsonError($insert_data, 'خطا در ثبت اطلاعات سوالات متداول', 200);

    }

    public function editVisaFaq($params) {

        $faq = $this->faqs_model->get()->where('id', $params['faq_id'])->find();

        if ($faq) {
            $update_data = $this->faqs_model->get()
                ->updateWithBind([
                    'question' => $params['question'],
                    'answer' => $params['answer'],
                    'visa_id' => $params['visa_id'],
                ], [
                    'id' => $params['faq_id']
                ]);




            return functions::JsonSuccess($params['visa_id'], 'اپرسش و پاسخ شما با موفقیت در سیستم بروزرسانی شد');


        }
        return functions::JsonError( 'موردی یافت نشد', 404);

    }

    public function getFaqs($id) {
//        return $this->faqs_model->get()->all();
        if(empty($id)) return false;
        $sql
            = "SELECT visa_faq.* , visa_faq.id as visa_faq_id , visa.title as title
                FROM visa_faq_tb as visa_faq
                LEFT JOIN visa_tb as visa ON visa_faq.visa_id = visa.id
                WHERE
                visa.isDell = 'no' AND visa_faq.visa_id={$id}";

        $model    = Load::library( 'Model' );
        $result   = $model->select( $sql );
        return $result;

    }

    public function getFaq($id) {
        return $this->faqs_model->get()->where('id', $id)->find();

    }

    public function removeFaq($params) {
        $result = $this->faqs_model->delete([
            'id' => $params['id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'سوالات متداول مورد نظر حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف سوالات متداول', 500);
    }

    // -------------------------------------------------------------------------Docs--------------------------------------------------------------------

    public function UpdateDocs($data)
    {
        $flag = 0;
        foreach ($data["AdditionalData"] as $k => $v) {
            if ($v['title'] == '' || $v['body'] == '' || $v['icon'] == '') {
                $flag = 1;
            }
        }
        if ($flag != 1) {
            if ($data['docs_id']) {

            $res  = $this->docs_model->updateWithBind(
                ['AdditionalData' =>  json_encode($data['AdditionalData'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                'note' => $data['note'],
            ] , ['id' => $data['docs_id']]);

                return functions::JsonSuccess([], 'با موفقیت ویرایش شد');
            }
            else {
                $this->docs_model->insertWithBind(
            ['AdditionalData' =>  json_encode($data['AdditionalData'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                'note' => $data['note'],
                'visa_id' => $data['visa_id']
            ]
                );
                return functions::JsonSuccess([], 'با موفقیت ویرایش شد');

            }
        }else{
            return functions::JsonError('لطفا تمام فیلد ها را وارد نمایید');
        }



        return functions::JsonError([], 'خطا در ویرایش اطلاعات', 500);

    }



    public function DocsAdditionalData($visa_id)
    {

        return $this->docs_model->get()->where('visa_id', $visa_id)->find();

    }








    // -------------------------------------------------------------------------Step--------------------------------------------------------------------

    public function UpdateStep($data)
    {
        $flag = 0;
        foreach ($data["AdditionalData"] as $k => $v) {
            if ($v['title'] == '' || $v['body'] == '' || $v['icon'] == '') {
                $flag = 1;
            }
        }
        if ($flag != 1) {
            if ($data['step_id']) {

                $this->step_model->updateWithBind(
                    ['AdditionalData' =>  json_encode($data['AdditionalData'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                        'note' => $data['note'],
                    ] , ['id' => $data['step_id']]);

                return functions::JsonSuccess([], 'با موفقیت ویرایش شد');
            }
            else {
                $this->step_model->insertWithBind(
                    ['AdditionalData' =>  json_encode($data['AdditionalData'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                        'note' => $data['note'],
                        'visa_id' => $data['visa_id']
                    ]
                );
                return functions::JsonSuccess([], 'با موفقیت ویرایش شد');

            }
        }else{
            return functions::JsonError('لطفا تمام فیلد ها را وارد نمایید');
        }



        return functions::JsonError([], 'خطا در ویرایش اطلاعات', 500);

    }



    public function StepAdditionalData($visa_id)
    {

        return $this->step_model->get()->where('visa_id', $visa_id)->find();

    }
    public function changePriority($params){
        $Model = Load::library( 'Model' );
        $visa_id = $params['visa_id'];
        $value = $params['value'];
        $data = [
            'priority' => $value
        ];
        $Model->setTable( 'visa_tb' );
        $resultInsert = $Model->updateWithBind( $data, [ 'id' => $visa_id ] );


        if($resultInsert){
            return 'successful';
        }
        return 'failed';
    }





}
