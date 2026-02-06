<?php

class bookshowTest extends clientAuth {
    public $id = '';
    public $list;
    public $edit;
    public $countTotal;
    public $countTotalCharter;
    public $countTotalSystem;
    public $countTotalSystemPrivate;
    public $request_number;
    public $adt_qty;
    public $chd_qty;
    public $inf_qty;
    public $CountTicket;
    public $CountTicketCounter;
    public $charter_qty;
    public $pubSystem_qty;
    public $prSystem_qty;
    public $userId;
    public $counterTypeId;

    public $transactions;
    private $ArrChargeUserPrice=array();
    private $colorTrByStatusCreditBlak='';
    private $colorTrByStatusCreditPurple='';
    public $transactionsClass;
    public function __construct() {
        parent::__construct();
        $this->transactions = $this->getModel('transactionsModel');
        $this->transactionsClass = new transactions();
    }
    //Ardalani1404
    public function getTransactionsByDateRange($date_of,$to_date,$pnr,$factor_number,$request_number,$passenger_name) {

        if($pnr=='' && $factor_number=='' && $request_number=='' && $passenger_name==''){
            $ReturnDate=functions::ChangeDateForTransactions($date_of,$to_date);
        }
        else{//3ماه قبل را واکشی کند
            // امروز میلادی
            $todayGregorian = date('Y-m-d');
             // 3 ماه قبل (میلادی)
            $threeMonthAgoGregorian = date('Y-m-d', strtotime('-3 months'));
            // تبدیل به شمسی
            $todayJalali = dateTimeSetting::jdate('Y-m-d', strtotime($todayGregorian));
            $threeMonthAgoJalali = dateTimeSetting::jdate('Y-m-d', strtotime($threeMonthAgoGregorian));

            $ReturnDate=functions::ChangeDateForTransactions($threeMonthAgoJalali,$todayJalali);
        }

       $transactions = $this->transactions->get(['Price', 'FactorNumber'])
            ->where('Status','2')
            ->where('PaymentStatus','success')
            ->openParentheses()
            ->where('PriceDate', $ReturnDate[0], '>=')
            ->where('PriceDate', $ReturnDate[1], '<=')
            ->closeParentheses()
           ->all();
        $priceByFactor = [];
        foreach ($transactions as $t) {
            $priceByFactor[$t['FactorNumber']] = $t['Price'];
        }
        return $priceByFactor;
    }

    public function createExcelFile( $param ) {

        $_POST      = $param;
        $resultBook = $this->listBookLocal();

        if ( ! empty( $resultBook ) ) {


            // برای نام گذاری سطر اول فایل اکسل //
            $firstRowColumnsHeading = [
                'ردیف',
                'تاریخ خرید',
                'واچر',
                'شماره فاکتور',
                'پید',
                'مبدا - مقصد',
                'ایرلاین',
                'شناسه نرخی',
                'شماره پرواز',
                'ساعت پرواز',
                'تاریخ پرواز',
                'نام خریدار',
                'درصد تخفیف خریدار',
                'آژانس همکار',
                'سهم آژانس',
                'total fare',
                'قیمت بدون تخفیف',
                'قیمت',
                'یک طرفه / دو طرفه',
                'وضعیت',
                'خرید از نرم افزار'
            ];
            /*if (TYPE_ADMIN == '1') {
                array_push($firstRowColumnsHeading, 'سهم ما', 'سود api');
            }*/


            $dataRows = [];
            foreach ( $resultBook as $k => $book ) {

                $numberColumn = $k + 2;

                $creation_date_int = ( ! empty( $book['creation_date_int'] ) ) ? dateTimeSetting::jdate( 'Y-m-d (H:i:s)', $book['creation_date_int'] ) : '';

                if ( $book['flight_type'] == 'charter' ) {
                    $type_charter =($book['pid_private'] == '1') ? "چارتر(چارتری اختصاصی)" : "چارتر(چارتری اشتراکی)";
                    $flight_type = $type_charter;
                } elseif ( $book['flight_type'] == 'system' && $book['pid_private'] == '1' ) {
                    $flight_type = 'سیستمی (پید اختصاصی)';
                } elseif ( $book['flight_type'] == 'system' && $book['pid_private'] == '0' ) {
                    $flight_type = 'سیستمی (پید اشتراکی)';
                } elseif ( $book['flight_type'] == 'charterPrivate' ) {
                    $flight_type = 'چارتری (چارتر اختصاصی)';
                } else {
                    $flight_type = 'نامشخص';
                }


                if ( ! empty( $book['origin_city'] ) && ! empty( $book['desti_city'] ) ) {
                    $city = $book['origin_city'] . ' ( ' . $book['origin_airport_iata'] . ' ) ';
                    $city .= ' - ' . $book['desti_city'] . ' ( ' . $book['desti_airport_iata'] . ' ) ';
                } else {
                    $cityNameOrigin      = functions::NameCityForeign( $book['origin_airport_iata'] );
                    $cityNameDestination = functions::NameCityForeign( $book['desti_airport_iata'] );
                    $city                = $cityNameOrigin['DepartureCityFa'] . ' ( ' . $book['origin_airport_iata'] . ' ) ';
                    $city                .= ' - ' . $cityNameDestination['DepartureCityFa'] . ' ( ' . $book['desti_airport_iata'] . ' ) ';
                }


                if ( ! empty( $book['airline_name'] ) ) {
                    $airline_name = $book['airline_name'];
                } else {
                    $airline      = functions::InfoAirline( $book['airline_iata'] );
                    $airline_name = $airline['name_fa'];
                }


                $infoMember     = functions::infoMember( $book['member_id'], $book['client_id'] );
                $member_percent = '';
                if ( $infoMember['is_member'] == '1' ) {
                    $member_percent = ( $infoMember['fk_counter_type_id'] == '5' ) ? 'مسافر ' : 'کانتر ' . $book['percent_discount'] . ' %ای  ';
                }


                $agency_id = ( ! empty( $book['agency_id'] ) && $book['agency_id'] > 0 ) ? 'آژانس ' . $book['agency_name'] : '';

                $time_flight = $this->format_hour( $book['time_flight'] );
                $date_flight = $this->DateJalali( $book['date_flight'] );

                $agency_commission = '';
                if ( $book['flight_type'] == 'charter' || $book['flight_type'] == 'system' ) {
                    $agency_commission = $book['agency_commission'];
                }

                $supplier_commission = '';
                if ( $book['flight_type'] != 'charterPrivate' ) {
                    if ( TYPE_ADMIN == 1 ) {
                        $supplier_commission = '( ';
                        $supplier_commission .= $book['adt_price'] + $book['chd_price'] + $book['inf_price'];
                        $supplier_commission .= ' ) ';
                        $supplier_commission .= functions::calculatePriceForAdmin( $book['request_number'] );
                    } else {
                        $supplier_commission = $book['supplier_commission'];
                    }

                }


                $totalPriceWithoutDiscount = '';
                $totalPrice                = '';
                if ( $book['flight_type'] != 'charterPrivate' ) {

                    if ( $book['flight_type'] == 'charter' || $book['api_id'] =='14') {


                        if ( $book['percent_discount'] > 0 ) {
                            $totalPriceWithoutDiscount = functions::CalculateDiscount( $book['request_number'], 'yes' );
                            $totalPrice                = $book['agency_commission'] + $book['supplier_commission'] + $book['irantech_commission'];
                        } else {
                            $totalPrice = functions::CalculateDiscount( $book['request_number'], 'yes' );
                        }

                    } elseif ( $book['flight_type'] == 'system' ) {

                        if ( $book['percent_discount'] > 0 || $book['api_id']=='14') {
                            $totalPriceWithoutDiscount = functions::CalculateDiscount( $book['request_number'], 'No' );
                            $totalPrice                = $book['adt_price'] + $book['chd_price'] + $book['inf_price'];
                        } else {
                            $totalPrice = $book['adt_price'] + $book['chd_price'] + $book['inf_price'];
                        }

                    }

                } else {

                    $InfoTicketReservation = $this->getInfoTicketReservation( $book['request_number'] );
                    if ( $InfoTicketReservation['totalPriceWithoutDiscount'] > 0 ) {
                        $totalPriceWithoutDiscount = $InfoTicketReservation['totalPriceWithoutDiscount'];
                    }
                    $totalPrice = $InfoTicketReservation['totalPrice'];

                }

                /*switch ($book['api_id']){
                    case '1':
                        $api_name = 'سرور5';
                        break;
                    case '5':
                        $api_name = 'سرور4';
                        break;
                    case '12':
                        $api_name = 'سرور12';
                        break;
                    case '13':
                        $api_name = 'سرور7';
                        break;
                    case '10':
                        $api_name = 'سرور9';
                        break;
                    case '11':
                        $api_name = 'سرور10';
                        break;
                    default :
                        $api_name = '';
                        break;
                }*/

                $DetectDirection = functions::DetectDirection( $book['factor_number'], $book['request_number'] );

                $successfull = '';
                if ( $book['type_app'] == 'Web' || $book['type_app'] == 'Application' ) {

                    if ( $book['successfull'] == 'nothing' ) {
                        $successfull = 'انصراف از خرید';
                    } elseif ( $book['successfull'] == 'error' && $book['flight_type'] == 'charter' ) {
                        $successfull = 'خطای چارتر کننده';
                    } elseif ( $book['successfull'] == 'error' && $book['flight_type'] == 'system' ) {
                        $successfull = 'خطای ایرلاین';
                    } elseif ( $book['successfull'] == 'prereserve' ) {
                        $successfull = 'پیش رزرو';
                    } elseif ( $book['successfull'] == 'bank' ) {
                        $successfull = 'هدایت به درگاه';
                    } elseif ( $book['successfull'] == 'credit' ) {
                        $successfull = 'انتخاب گزینه اعتباری';
                    } elseif ( $book['successfull'] == 'book' ) {
                        $successfull = 'رزرو قطعی';
                    } elseif ( $book['successfull'] == 'process' ) {
                        $successfull = 'در  حال پردازش';
                    } elseif ( $book['successfull'] == 'pending' ) {
                        $successfull = 'در  حال صدور';
                    }
                } else {

                    if ( $book['successfull'] == 'book' ) {
                        $successfull = 'رزرو قطعی';
                    } elseif ( $book['successfull'] == 'prereserve' ) {
                        $successfull = 'پیش رزرو';
                    } elseif ( $book['successfull'] == '' ) {
                        $successfull = 'نامشخص';
                    } elseif ( $book['successfull'] == 'bank' ) {
                        $successfull = 'هدایت به درگاه';
                    } elseif ( $book['successfull'] == 'process' ) {
                        $successfull = 'در  حال پردازش';
                    }elseif ( $book['successfull'] == 'pending' ) {
                        $successfull = 'در  حال صدور';
                    } else {
                        $successfull = 'نامشخص';
                    }

                }


                $type_app = '';
                if ( $book['type_app'] == 'Web' ) {
                    $type_app = 'وب سایت';
                } elseif ( $book['type_app'] == 'Application' ) {
                    $type_app = 'اپلیکیشن';
                } elseif ( $book['type_app'] == 'reservation' ) {
                    $type_app = 'بلیط رزرواسیون';
                }

                // ایجاد آرایه ای از اطلاعات بلیط (هر چیزی که میخواهیم در فایل اکسل قرار دهیم) برای ساخت فایل اکسل //
                $dataRows[ $k ]['number_column']             = $numberColumn - 1;
                $dataRows[ $k ]['creation_date_int']         = $creation_date_int;
                $dataRows[ $k ]['request_number']            = $book['request_number'];
                $dataRows[ $k ]['factor_number']             = $book['factor_number'];
                $dataRows[ $k ]['flight_type']               = $flight_type;
                $dataRows[ $k ]['city']                      = $city;
                $dataRows[ $k ]['airline_name']              = $airline_name;
                $dataRows[ $k ]['cabin_type']                = $book['cabin_type'];
                $dataRows[ $k ]['flight_number']             = $book['flight_number'];
                $dataRows[ $k ]['time_flight']               = $time_flight;
                $dataRows[ $k ]['date_flight']               = $date_flight;
                $dataRows[ $k ]['member_name']               = $book['member_name'];
                $dataRows[ $k ]['member_percent']            = $member_percent;
                $dataRows[ $k ]['agency_id']                 = $agency_id;
                $dataRows[ $k ]['agency_commission']         = $agency_commission;
                $dataRows[ $k ]['supplier_commission']       = $supplier_commission;
                $dataRows[ $k ]['totalPrice']                = $totalPrice;
                $dataRows[ $k ]['totalPriceWithoutDiscount'] = $totalPriceWithoutDiscount;
                $dataRows[ $k ]['DetectDirection']           = $DetectDirection;
                $dataRows[ $k ]['successfull']               = $successfull;
                $dataRows[ $k ]['type_app']                  = $type_app;

                /*if (TYPE_ADMIN == '1' && $book['flight_type'] != 'charterPrivate') {

                    $dataRows[$k]['irantech_commission'] = $book['irantech_commission'];
                    $dataRows[$k]['api_commission'] = $book['api_commission'];

                } else if (TYPE_ADMIN == '1') {

                    $dataRows[$k]['irantech_commission'] = '';
                    $dataRows[$k]['api_commission'] = '';
                }*/


            }


            $objCreateExcelFile = Load::controller( 'createExcelFile' );
            $resultExcel        = $objCreateExcelFile->create( $dataRows, $firstRowColumnsHeading );
            if ( $resultExcel['message'] == 'success' ) {
                return 'success|' . $resultExcel['fileName'];
            } else {
                return 'error|متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید';
            }


        } else {
            return 'error|اطلاعاتی برای ساخت فایل اکسسل وجود ندارد.';
        }


    }


    public function listBookLocal( $intendedUser = null ) {

        $date               = dateTimeSetting::jdate( "Y-m-d", time() );
        $date_now_explode   = explode( '-', $date );
        $date_now_int_start = dateTimeSetting::jmktime( 0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0] );
        $date_now_int_end   = dateTimeSetting::jmktime( 23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0] );


        if ( TYPE_ADMIN == '1' ) {
            $ModelBase = Load::library( 'ModelBase' );

            $sql = "SELECT rep.*, cli.AgencyName AS NameAgency, cli.Domain AS DomainAgency, "
                . " SUM(api_commission) AS api_commission," . " SUM(agency_commission) AS agency_commission ,"
                . " SUM(supplier_commission) AS supplier_commission ,"
                . " SUM(irantech_commission) AS irantech_commission,"
                . " SUM(adt_price) AS adt_price,"
                . " SUM(chd_price) AS chd_price ,"
                . " SUM(inf_price) AS inf_price, "
                . " SUM(adt_fare) AS adt_fare_sum,"
                . " SUM(chd_fare) AS chd_fare_sum,"
                . " SUM(inf_fare) AS inf_fare_sum, "
                . " SUM(adt_qty) AS adt_qty_f,"
                . " SUM(chd_qty) AS chd_qty_f,"
                . " SUM(inf_qty) AS inf_qty_f, "
                . " SUM(provider_adt_price) AS provider_adt_price,"
                . " SUM(provider_chd_price) AS provider_chd_price,"
                . " SUM(provider_inf_price) AS provider_inf_price, "
                . " SUM(adt_com) AS sum_adt_com,"
                . " SUM(chd_com) AS sum_chd_com,"
                . " SUM(inf_com) AS sum_inf_com, "
                . " SUM(amount_added) AS sum_amount_added, "
                . " SUM(system_flight_commission) AS sum_system_flight_commission "
                . " FROM report_tb as rep"
                . " LEFT JOIN clients_tb AS cli ON cli.id = rep.client_id WHERE 1=1 ";


            /*    if (empty($_POST['cancel']) || ($_POST['cancel'] == 'No')) {
                    $sql .= " AND request_cancel <> 'confirm'";
                }*/


            if ( Session::CheckAgencyPartnerLoginToAdmin() ) {
                $sql .= " AND agency_id='{$_SESSION['AgencyId']}' ";

                if ( ! empty( $_POST['CounterId'] ) ) {
                    if ( $_POST['CounterId'] != "all" ) {
                        $sql .= " AND member_id ='{$_POST['CounterId']}'";
                    }
                }
            }
            if ( ! empty( $intendedUser['member_id'] ) ) {
                $sql .= ' AND member_id=' . $intendedUser['member_id'] . ' ';
            }
            if ( ! empty( $intendedUser['agency_id'] ) ) {
                $sql .= ' AND agency_id=' . $intendedUser['agency_id'] . ' ';
            }
            if(!empty($_POST['member_id'])){
                $sql.=' AND member_id='.$_POST['member_id'].' ';
            }
            if(!empty($_POST['agency_id'])){
                $sql.=' AND agency_id='.$_POST['agency_id'].' ';
            }
            if (  empty( $_POST['request_number'] ) && empty( $_POST['factor_number'] ) && empty( $_POST['pnr'] ) ) {
                if ( ! empty( $_POST['date_of'] ) && ! empty( $_POST['to_date'] ) ) {

                    $date_of     = explode( '-', $_POST['date_of'] );
                    $date_to     = explode( '-', $_POST['to_date'] );
                    $date_of_int = dateTimeSetting::jmktime( 0, 0, 0, $date_of[1], $date_of[2], $date_of[0] );
                    $date_to_int = dateTimeSetting::jmktime( 23, 59, 59, $date_to[1], $date_to[2], $date_to[0] );
                    $sql         .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
                }
                else {

                    $sql .= "AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";

                }
            }
            if ( ! empty( $_POST['successfull'] ) ) {
                if ( $_POST['successfull'] == 'all' ) {

                    $sql .= " AND (successfull ='nothing' OR successfull ='book' OR successfull ='private_reserve' OR successfull ='credit' OR successfull ='bank' OR successfull ='prereserve' ) ";
                } else if ( $_POST['successfull'] == 'book' ) {
                    $sql .= " AND (successfull ='{$_POST['successfull']}' OR successfull='private_reserve')";
                } else {
                    $sql .= " AND (successfull ='nothing' OR successfull ='credit' OR successfull ='bank' OR successfull ='prereserve' ) ";
                }
            }
            if ( ! empty( $_POST['flight_type'] ) ) {

                if ( $_POST['flight_type'] == 'all' ) {
                    $sql .= " AND (flight_type ='system' OR flight_type ='charter' OR flight_type ='charterPrivate')";
                } else if ( $_POST['flight_type'] == 'charterSourceSeven' ) {
                    $sql .= " AND flight_type ='charter' AND api_id='8'";
                } else if ( $_POST['flight_type'] == 'SystemSourceFive' ) {
                    $sql .= " AND flight_type ='system' AND api_id='1'";
                } else if ( $_POST['flight_type'] == 'SystemSourceForeignNine' ) {
                    $sql .= " AND flight_type ='system' AND api_id='10' ";
                } else if ( $_POST['flight_type'] == 'SystemSourceSeven' ) {
                    $sql .= " AND flight_type ='system' AND api_id='8' ";
                } else if ( $_POST['flight_type'] == 'charterSourceNine' ) {
                    $sql .= " AND flight_type ='charter' AND api_id='10' ";
                }else if ( $_POST['flight_type'] == 'systemSourceFourteen' ) {
                    $sql .= " AND flight_type ='system' AND api_id='14' ";
                } else if ( $_POST['flight_type'] == 'charterSourceFourteen' ) {
                    $sql .= " AND flight_type ='charter' AND api_id='14' ";
                } else if ( $_POST['flight_type'] == 'systemSourceFifteen' ) {
                    $sql .= " AND flight_type ='system' AND api_id='15' ";
                } else if ( $_POST['flight_type'] == 'charterSourceFifteen' ) {
                    $sql .= " AND flight_type ='charter' AND api_id='15' ";
                }else if ( $_POST['flight_type'] == 'systemSourceSixteen' ) {
                    $sql .= " AND flight_type ='system' AND api_id='16' ";
                } else if ( $_POST['flight_type'] == 'charterSourceSixteen' ) {
                    $sql .= " AND flight_type ='charter' AND api_id='16' ";
                }
            }
            if ( ! empty( $_POST['pnr'] ) ) {
                $sql .= " AND pnr ='{$_POST['pnr']}'";
            }
            if ( ! empty( $_POST['request_number'] ) ) {
                $sql .= " AND request_number ='{$_POST['request_number']}'";
            }
            if ( ! empty( $_POST['factor_number'] ) ) {
                $sql .= " AND factor_number ='{$_POST['factor_number']}'";
            }
            if ( ! empty( $_POST['client_id'] ) ) {
                if ( $_POST['client_id'] != "all" ) {
                    $sql .= " AND client_id ='{$_POST['client_id']}'";
                }
            }
            if ( ! empty( $_POST['passenger_name'] ) ) {
                $trimPassengerName = trim( $_POST['passenger_name'] );
                $sql               .= " AND (passenger_name LIKE '%{$trimPassengerName}%' OR passenger_family LIKE '%{$trimPassengerName}%')";
            }
            if ( ! empty( $_POST['passenger_national_code'] ) ) {
                $sql .= " AND (passenger_national_code ='{$_POST['passenger_national_code']}')";
            }
            if ( ! empty( $_POST['member_name'] ) ) {
                $sql .= " AND member_name LIKE '%{$_POST['member_name']}%'";
            }
            if ( ! empty( $_POST['payment_type'] ) ) {
                if ( $_POST['payment_type'] == 'all' ) {
                    $sql .= " AND (payment_type != '' OR payment_type != 'nothing')";
                } elseif ( $_POST['payment_type'] == 'credit' ) {
                    $sql .= " AND (payment_type = 'credit' OR payment_type = 'member_credit')";
                } else {
                    $sql .= " AND payment_type ='{$_POST['payment_type']}'";
                }
            }
            if ( ! empty( $_POST['eticket_number'] ) ) {
                $sql .= " AND (eticket_number ='{$_POST['eticket_number']}')";
            }
            if ( ! empty( $_POST['AirlineIata'] ) ) {
                $sql .= " AND (airline_iata ='{$_POST['AirlineIata']}')";
            }
            if ( ! empty( $_POST['DateFlight'] ) ) {
                $xpl = explode( '-', $_POST['DateFlight'] );

                $FinalDate = dateTimeSetting::jalali_to_gregorian( $xpl[0], $xpl[1], $xpl[2], '-' );

                $sql .= " AND date_flight Like'%{$FinalDate}%'";
            }
            if ( ! empty( $_POST['IsAgency'] ) ) {
                if ( $_POST['IsAgency'] == 'agency' ) {
                    $sql .= " AND agency_id <> '0' AND agency_id <> '5'";
                } else if ( $_POST['IsAgency'] == 'Ponline' ) {
                    $sql .= " AND agency_id = '0' OR agency_id = '5'";
                }
            }
            $sql      .= "GROUP BY rep.request_number ORDER BY rep.creation_date_int DESC, rep.id DESC  ";
            $BookShow = $ModelBase->select( $sql );
            $this->CountTicket = count( $BookShow );
        } else {


            $Model = Load::library( 'Model' );
            $sql   = "SELECT *, '" . CLIENT_DOMAIN . "' AS DomainAgency, "
                . " SUM(api_commission) AS api_commission,"
                . " SUM(agency_commission) AS agency_commission ,"
                . " SUM(supplier_commission) AS supplier_commission ,"
                . " SUM(irantech_commission) AS irantech_commission,"
                . " SUM(adt_price) AS adt_price,"
                . " SUM(chd_price) AS chd_price ,"
                . " SUM(inf_price) AS inf_price, "
                . " SUM(adt_fare) AS adt_fare_sum,"
                . " SUM(chd_fare) AS chd_fare_sum,"
                . " SUM(inf_fare) AS inf_fare_sum, "
                . " SUM(adt_qty) AS adt_qty_f,"
                . " SUM(chd_qty) AS chd_qty_f,"
                . " SUM(inf_qty) AS inf_qty_f, "
                . " SUM(provider_adt_price) AS provider_adt_price,"
                . " SUM(provider_chd_price) AS provider_chd_price,"
                . " SUM(provider_inf_price) AS provider_inf_price, "
                . " SUM(adt_com) AS sum_adt_com,"
                . " SUM(chd_com) AS sum_chd_com,"
                . " SUM(inf_com) AS sum_inf_com, "
                . " SUM(amount_added) AS sum_amount_added, "
                . " SUM(system_flight_commission) AS sum_system_flight_commission "
                . " FROM book_local_tb WHERE 1=1 ";

            if ( ! empty( $intendedUser['member_id'] ) ) {
                $sql .= ' AND member_id=' . $intendedUser['member_id'] . ' ';
            }

            if ( ! empty( $intendedUser['agency_id'] ) ) {
                $sql .= ' AND agency_id=' . $intendedUser['agency_id'] . ' ';
            }
            if(!empty($_POST['member_id'])){
                $sql.=' AND member_id='.$_POST['member_id'].' ';
            }

            if(!empty($_POST['agency_id'])){
                $sql.=' AND agency_id='.$_POST['agency_id'].' ';
            }
            if (  empty( $_POST['request_number'] ) && empty( $_POST['factor_number'] ) && empty( $_POST['pnr'] ) ) {
                if ( ! empty( $_POST['date_of'] ) && ! empty( $_POST['to_date'] ) ) {

                    $date_of     = explode( '-', $_POST['date_of'] );
                    $date_to     = explode( '-', $_POST['to_date'] );
                    $date_of_int = dateTimeSetting::jmktime( 0, 0, 0, $date_of[1], $date_of[2], $date_of[0] );
                    $date_to_int = dateTimeSetting::jmktime( 23, 59, 59, $date_to[1], $date_to[2], $date_to[0] );
                    $sql         .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
                }
                else {

                    $sql .= "AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";

                }
            }
            if ( ! empty( $_POST['successfull'] ) ) {
                if ( $_POST['successfull'] == 'all' ) {

                    $sql .= " AND (successfull ='nothing' OR successfull ='book' OR successfull ='credit' OR successfull ='bank' ) ";
                } else if ( $_POST['successfull'] == 'book' ) {
                    $sql .= " AND successfull ='{$_POST['successfull']}'";
                } else {
                    $sql .= " AND (successfull ='nothing' OR successfull ='credit' OR successfull ='bank' ) ";
                }
            }
            if ( ! empty( $_POST['flight_type'] ) ) {

                if ( $_POST['flight_type'] == 'all' ) {
                    $sql .= " AND (flight_type ='system' OR flight_type ='charter')";
                }elseif($_POST['flight_type'] == 'charter_private') {
                    $sql .= " AND flight_type ='charter' AND pid_private='1'";
                }elseif($_POST['flight_type'] == 'system_private') {
                    $sql .= " AND flight_type ='system' AND pid_private='1'";
                }else{
                    $sql .= " AND flight_type ='{$_POST['flight_type']}' AND pid_private='0'";
                }
            }
            if ( ! empty( $_POST['pnr'] ) ) {
                $sql .= " AND pnr ='{$_POST['pnr']}'";
            }
            if ( ! empty( $_POST['request_number'] ) ) {
                $sql .= " AND request_number ='{$_POST['request_number']}'";
            }
            if ( ! empty( $_POST['factor_number'] ) ) {
                $sql .= " AND factor_number ='{$_POST['factor_number']}'";
            }
            if ( ! empty( $_POST['passenger_name'] ) ) {
                $trimPassengerName = trim( $_POST['passenger_name'] );
                $sql               .= " AND (passenger_name LIKE '%{$trimPassengerName}%' OR passenger_family LIKE '%{$trimPassengerName}%')";
            }
            if ( ! empty( $_POST['passenger_national_code'] ) ) {
                $sql .= " AND (passenger_national_code ='{$_POST['passenger_national_code']}')";
            }
            if ( ! empty( $_POST['member_name'] ) ) {
                $sql .= " AND member_name LIKE '%{$_POST['member_name']}%'";
            }
            if ( ! empty( $_POST['payment_type'] ) ) {
                if ( $_POST['payment_type'] == 'all' ) {
                    $sql .= " AND (payment_type != '' OR payment_type != 'nothing')";
                } elseif ( $_POST['payment_type'] == 'credit' ) {
                    $sql .= " AND (payment_type = 'credit' OR payment_type = 'member_credit')";
                } else {
                    $sql .= " AND payment_type ='{$_POST['payment_type']}'";
                }
            }
            if ( ! empty( $_POST['AirlineIata'] ) ) {
                $sql .= " AND (airline_iata ='{$_POST['AirlineIata']}')";
            }
            if ( ! empty( $_POST['DateFlight'] ) ) {
                $xpl = explode( '-', $_POST['DateFlight'] );

                $FinalDate = dateTimeSetting::jalali_to_gregorian( $xpl[0], $xpl[1], $xpl[2], '-' );

                $sql .= " AND date_flight ='{$FinalDate}'";
            }
            if ( ! empty( $_POST['IsAgency'] ) ) {

                if ( $_POST['IsAgency'] == 'agency' ) {
                    $sql .= " AND agency_id <> '0'";
                } else if ( $_POST['IsAgency'] == 'Ponline' ) {
                    $sql .= " AND agency_id = '0'";
                }
            }


            $get_session_sub_manage = Session::getAgencyPartnerLoginToAdmin();

            if(Session::CheckAgencyPartnerLoginToAdmin() && $get_session_sub_manage=='AgencyHasLogin'){
                $check_access = $this->getController('manageMenuAdmin')->getAccessServiceCounter(Session::getInfoCounterAdmin());

                if($check_access){
                    $sql .= " AND serviceTitle IN ({$check_access})  ";


                }
                if(!empty($_POST['CounterId'])){
                    $sql.=' AND member_id='.$_POST['CounterId'].' ';
                }


            }
            $sql .= "  GROUP BY request_number ORDER BY creation_date_int DESC,id DESC ";


            /** @var partner $client_controller */
            $client_controller = Load::controller('partner');
            $sub_clients = $client_controller->subClient(CLIENT_ID) ;
            $book_sub_client = array();
            $BookShow = array();
            $admin = Load::controller( 'admin' );

            if(!isset($_POST['sub_client_id']) || empty($_POST['sub_client_id'])) {

                $BookShow = $Model->select($sql);

                foreach ($BookShow as $key=>$item) {
                    $BookShow[$key]['NameAgency'] = CLIENT_NAME ;
                    $BookShow[$key]['sub_agency'] = false ;
                }
                $this->CountTicket = count( $BookShow );
            }


            if(isset($_POST['sub_client_id']) && !empty($_POST['sub_client_id'])){
                $info_client_selected =$client_controller->infoClient($_POST['sub_client_id']);
                $book_sub_clients =  $admin->ConectDbClient( $sql, $_POST['sub_client_id'], "SelectAll", "", "", "" );
                foreach ($book_sub_clients as $key=>$book_sub_client ){
                    $BookShow [$key] = $book_sub_client ;
                    $BookShow [$key]['NameAgency'] = $info_client_selected['AgencyName'] ;
                    $BookShow [$key]['sub_agency'] = true ;
                }
                $this->CountTicket = count( $BookShow );
            }else{
                if(!empty($sub_clients)){
                    foreach ($sub_clients as $sub_client) {
                        $book_sub_clients =  $admin->ConectDbClient( $sql, $sub_client['id'], "SelectAll", "", "", "" );
                        foreach ($book_sub_clients as $key=>$book_sub_client ){
                            $BookShow [($this->CountTicket + $key)] = $book_sub_client ;
                            $BookShow [($this->CountTicket + $key)]['NameAgency'] = $sub_client['AgencyName'] ;
                            $BookShow [($this->CountTicket + $key)]['sub_agency'] = true ;
                        }
                        $this->CountTicket += count($book_sub_clients);
                    }
                }
            }


        }
        $final_book = array();
        foreach ($BookShow as $key_book=>$book){
            $final_book[$key_book]['creation_date_int'] = $book['creation_date_int'];
        }


        array_multisort($final_book['creation_date_int'],SORT_DESC,$BookShow );

//        echo json_encode($BookShow,256); die();

        return $BookShow;


    }
    public function listBookLocalWebService( $intendedUser = null ) {

        $date               = dateTimeSetting::jdate( "Y-m-d", time() );
        $date_now_explode   = explode( '-', $date );
        $date_now_int_start = dateTimeSetting::jmktime( 0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0] );
        $date_now_int_end   = dateTimeSetting::jmktime( 23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0] );

        if ( TYPE_ADMIN == '1' ) {
            $ModelBase = Load::library( 'ModelBase' );

            $sql = "SELECT rep.*, cli.AgencyName AS NameAgency, cli.Domain AS DomainAgency, "
                . " SUM(api_commission) AS api_commission," . " SUM(agency_commission) AS agency_commission ,"
                . " SUM(supplier_commission) AS supplier_commission ,"
                . " SUM(irantech_commission) AS irantech_commission,"
                . " SUM(adt_price) AS adt_price,"
                . " SUM(chd_price) AS chd_price ,"
                . " SUM(inf_price) AS inf_price, "
                . " SUM(adt_fare) AS adt_fare_sum,"
                . " SUM(chd_fare) AS chd_fare_sum,"
                . " SUM(inf_fare) AS inf_fare_sum, "
                . " SUM(adt_qty) AS adt_qty_f,"
                . " SUM(chd_qty) AS chd_qty_f,"
                . " SUM(inf_qty) AS inf_qty_f, "
                . " SUM(provider_adt_price) AS provider_adt_price,"
                . " SUM(provider_chd_price) AS provider_chd_price,"
                . " SUM(provider_inf_price) AS provider_inf_price, "
                . " SUM(adt_com) AS sum_adt_com,"
                . " SUM(chd_com) AS sum_chd_com,"
                . " SUM(inf_com) AS sum_inf_com, "
                . " SUM(amount_added) AS sum_amount_added, "
                . " SUM(system_flight_commission) AS sum_system_flight_commission "
                . " FROM report_tb as rep"
                . " LEFT JOIN clients_tb AS cli ON cli.id = rep.client_id WHERE 1=1 ";


            /*    if (empty($_POST['cancel']) || ($_POST['cancel'] == 'No')) {
                    $sql .= " AND request_cancel <> 'confirm'";
                }*/


            if ( Session::CheckAgencyPartnerLoginToAdmin() ) {
                $sql .= " AND agency_id='{$_SESSION['AgencyId']}' ";

                if ( ! empty( $_POST['CounterId'] ) ) {
                    if ( $_POST['CounterId'] != "all" ) {
                        $sql .= " AND member_id ='{$_POST['CounterId']}'";
                    }
                }
            }

            if ( ! empty( $intendedUser['member_id'] ) ) {
                $sql .= ' AND member_id=' . $intendedUser['member_id'] . ' ';
            }

            if ( ! empty( $intendedUser['agency_id'] ) ) {
                $sql .= ' AND agency_id=' . $intendedUser['agency_id'] . ' ';
            }

            if(!empty($_POST['member_id'])){
                $sql.=' AND member_id='.$_POST['member_id'].' ';
            }

            if(!empty($_POST['agency_id'])){
                $sql.=' AND agency_id='.$_POST['agency_id'].' ';
            }

            if ( ! empty( $_POST['date_of'] ) && ! empty( $_POST['to_date'] ) ) {

                $date_of     = explode( '-', $_POST['date_of'] );
                $date_to     = explode( '-', $_POST['to_date'] );
                $date_of_int = dateTimeSetting::jmktime( 0, 0, 0, $date_of[1], $date_of[2], $date_of[0] );
                $date_to_int = dateTimeSetting::jmktime( 23, 59, 59, $date_to[1], $date_to[2], $date_to[0] );
                $sql         .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
            } else {

                $sql .= "AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";

            }

            if ( ! empty( $_POST['successfull'] ) ) {
                if ( $_POST['successfull'] == 'all' ) {

                    $sql .= " AND (successfull ='nothing' OR successfull ='book' OR successfull ='private_reserve' OR successfull ='credit' OR successfull ='bank' OR successfull ='prereserve' ) ";
                } else if ( $_POST['successfull'] == 'book' ) {
                    $sql .= " AND (successfull ='{$_POST['successfull']}' OR successfull='private_reserve')";
                } else {
                    $sql .= " AND (successfull ='nothing' OR successfull ='credit' OR successfull ='bank' OR successfull ='prereserve' ) ";
                }
            }


            if ( ! empty( $_POST['flight_type'] ) ) {

                if ( $_POST['flight_type'] == 'all' ) {
                    $sql .= " AND (flight_type ='system' OR flight_type ='charter' OR flight_type ='charterPrivate')";
                } else if ( $_POST['flight_type'] == 'charterSourceSeven' ) {
                    $sql .= " AND flight_type ='charter' AND api_id='8'";
                } else if ( $_POST['flight_type'] == 'SystemSourceFive' ) {
                    $sql .= " AND flight_type ='system' AND api_id='1'";
                } else if ( $_POST['flight_type'] == 'SystemSourceForeignNine' ) {
                    $sql .= " AND flight_type ='system' AND api_id='10' ";
                } else if ( $_POST['flight_type'] == 'SystemSourceSeven' ) {
                    $sql .= " AND flight_type ='system' AND api_id='8' ";
                } else if ( $_POST['flight_type'] == 'charterSourceNine' ) {
                    $sql .= " AND flight_type ='charter' AND api_id='10' ";
                }else if ( $_POST['flight_type'] == 'systemSourceFourteen' ) {
                    $sql .= " AND flight_type ='system' AND api_id='14' ";
                } else if ( $_POST['flight_type'] == 'charterSourceFourteen' ) {
                    $sql .= " AND flight_type ='charter' AND api_id='14' ";
                } else if ( $_POST['flight_type'] == 'systemSourceFifteen' ) {
                    $sql .= " AND flight_type ='system' AND api_id='15' ";
                } else if ( $_POST['flight_type'] == 'charterSourceFifteen' ) {
                    $sql .= " AND flight_type ='charter' AND api_id='15' ";
                }else if ( $_POST['flight_type'] == 'systemSourceSixteen' ) {
                    $sql .= " AND flight_type ='system' AND api_id='16' ";
                } else if ( $_POST['flight_type'] == 'charterSourceSixteen' ) {
                    $sql .= " AND flight_type ='charter' AND api_id='16' ";
                }
            }
            if ( ! empty( $_POST['pnr'] ) ) {
                $sql .= " AND pnr ='{$_POST['pnr']}'";
            }
            if ( ! empty( $_POST['request_number'] ) ) {
                $sql .= " AND request_number ='{$_POST['request_number']}'";
            }

            if ( ! empty( $_POST['factor_number'] ) ) {
                $sql .= " AND factor_number ='{$_POST['factor_number']}'";
            }

            $sql .= " AND client_id ='299'";



            if ( ! empty( $_POST['passenger_name'] ) ) {
                $trimPassengerName = trim( $_POST['passenger_name'] );
                $sql               .= " AND (passenger_name LIKE '%{$trimPassengerName}%' OR passenger_family LIKE '%{$trimPassengerName}%')";
            }


            if ( ! empty( $_POST['passenger_national_code'] ) ) {
                $sql .= " AND (passenger_national_code ='{$_POST['passenger_national_code']}')";
            }


            if ( ! empty( $_POST['member_name'] ) ) {
                $sql .= " AND member_name LIKE '%{$_POST['member_name']}%'";
            }
            if ( ! empty( $_POST['payment_type'] ) ) {
                if ( $_POST['payment_type'] == 'all' ) {
                    $sql .= " AND (payment_type != '' OR payment_type != 'nothing')";
                } elseif ( $_POST['payment_type'] == 'credit' ) {
                    $sql .= " AND (payment_type = 'credit' OR payment_type = 'member_credit')";
                } else {
                    $sql .= " AND payment_type ='{$_POST['payment_type']}'";
                }
            }

            if ( ! empty( $_POST['eticket_number'] ) ) {
                $sql .= " AND (eticket_number ='{$_POST['eticket_number']}')";
            }
            if ( ! empty( $_POST['AirlineIata'] ) ) {
                $sql .= " AND (airline_iata ='{$_POST['AirlineIata']}')";
            }


            if ( ! empty( $_POST['DateFlight'] ) ) {
                $xpl = explode( '-', $_POST['DateFlight'] );

                $FinalDate = dateTimeSetting::jalali_to_gregorian( $xpl[0], $xpl[1], $xpl[2], '-' );

                $sql .= " AND date_flight Like'%{$FinalDate}%'";
            }
            if ( ! empty( $_POST['IsAgency'] ) ) {
                if ( $_POST['IsAgency'] == 'agency' ) {
                    $sql .= " AND agency_id <> '0' AND agency_id <> '5'";
                } else if ( $_POST['IsAgency'] == 'Ponline' ) {
                    $sql .= " AND agency_id = '0' OR agency_id = '5'";
                }
            }
            $sql      .= "GROUP BY rep.request_number ORDER BY rep.creation_date_int DESC, rep.id DESC  ";
            $BookShow = $ModelBase->select( $sql );
            $this->CountTicket = count( $BookShow );
        } else {


            $Model = Load::library( 'Model' );
            $sql   = "SELECT *, '" . CLIENT_DOMAIN . "' AS DomainAgency, "
                . " SUM(api_commission) AS api_commission,"
                . " SUM(agency_commission) AS agency_commission ,"
                . " SUM(supplier_commission) AS supplier_commission ,"
                . " SUM(irantech_commission) AS irantech_commission,"
                . " SUM(adt_price) AS adt_price,"
                . " SUM(chd_price) AS chd_price ,"
                . " SUM(inf_price) AS inf_price, "
                . " SUM(adt_fare) AS adt_fare_sum,"
                . " SUM(chd_fare) AS chd_fare_sum,"
                . " SUM(inf_fare) AS inf_fare_sum, "
                . " SUM(adt_qty) AS adt_qty_f,"
                . " SUM(chd_qty) AS chd_qty_f,"
                . " SUM(inf_qty) AS inf_qty_f, "
                . " SUM(provider_adt_price) AS provider_adt_price,"
                . " SUM(provider_chd_price) AS provider_chd_price,"
                . " SUM(provider_inf_price) AS provider_inf_price, "
                . " SUM(adt_com) AS sum_adt_com,"
                . " SUM(chd_com) AS sum_chd_com,"
                . " SUM(inf_com) AS sum_inf_com, "
                . " SUM(amount_added) AS sum_amount_added, "
                . " SUM(system_flight_commission) AS sum_system_flight_commission "
                . " FROM book_local_tb WHERE 1=1 ";

            if ( ! empty( $intendedUser['member_id'] ) ) {
                $sql .= ' AND member_id=' . $intendedUser['member_id'] . ' ';
            }

            if ( ! empty( $intendedUser['agency_id'] ) ) {
                $sql .= ' AND agency_id=' . $intendedUser['agency_id'] . ' ';
            }
            if(!empty($_POST['member_id'])){
                $sql.=' AND member_id='.$_POST['member_id'].' ';
            }

            if(!empty($_POST['agency_id'])){
                $sql.=' AND agency_id='.$_POST['agency_id'].' ';
            }
            if ( ! empty( $_POST['date_of'] ) && ! empty( $_POST['to_date'] ) ) {

                $date_of     = explode( '-', $_POST['date_of'] );
                $date_to     = explode( '-', $_POST['to_date'] );
                $date_of_int = dateTimeSetting::jmktime( 0, 0, 0, $date_of[1], $date_of[2], $date_of[0] );
                $date_to_int = dateTimeSetting::jmktime( 23, 59, 59, $date_to[1], $date_to[2], $date_to[0] );
                $sql         .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
            } else {
                $sql .= "AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";

            }

            if ( ! empty( $_POST['successfull'] ) ) {
                if ( $_POST['successfull'] == 'all' ) {

                    $sql .= " AND (successfull ='nothing' OR successfull ='book' OR successfull ='credit' OR successfull ='bank' ) ";
                } else if ( $_POST['successfull'] == 'book' ) {
                    $sql .= " AND successfull ='{$_POST['successfull']}'";
                } else {
                    $sql .= " AND (successfull ='nothing' OR successfull ='credit' OR successfull ='bank' ) ";
                }
            }


            if ( ! empty( $_POST['flight_type'] ) ) {

                if ( $_POST['flight_type'] == 'all' ) {
                    $sql .= " AND (flight_type ='system' OR flight_type ='charter')";
                }elseif($_POST['flight_type'] == 'charter_private') {
                    $sql .= " AND flight_type ='charter' AND pid_private='1'";
                }elseif($_POST['flight_type'] == 'system_private') {
                    $sql .= " AND flight_type ='system' AND pid_private='1'";
                }else{
                    $sql .= " AND flight_type ='{$_POST['flight_type']}' AND pid_private='0'";
                }
            }

            if ( ! empty( $_POST['pnr'] ) ) {
                $sql .= " AND pnr ='{$_POST['pnr']}'";
            }

            if ( ! empty( $_POST['request_number'] ) ) {
                $sql .= " AND request_number ='{$_POST['request_number']}'";
            }

            if ( ! empty( $_POST['factor_number'] ) ) {
                $sql .= " AND factor_number ='{$_POST['factor_number']}'";
            }
            if ( ! empty( $_POST['passenger_name'] ) ) {
                $trimPassengerName = trim( $_POST['passenger_name'] );
                $sql               .= " AND (passenger_name LIKE '%{$trimPassengerName}%' OR passenger_family LIKE '%{$trimPassengerName}%')";
            }


            if ( ! empty( $_POST['passenger_national_code'] ) ) {
                $sql .= " AND (passenger_national_code ='{$_POST['passenger_national_code']}')";
            }


            if ( ! empty( $_POST['member_name'] ) ) {
                $sql .= " AND member_name LIKE '%{$_POST['member_name']}%'";
            }

            if ( ! empty( $_POST['payment_type'] ) ) {
                if ( $_POST['payment_type'] == 'all' ) {
                    $sql .= " AND (payment_type != '' OR payment_type != 'nothing')";
                } elseif ( $_POST['payment_type'] == 'credit' ) {
                    $sql .= " AND (payment_type = 'credit' OR payment_type = 'member_credit')";
                } else {
                    $sql .= " AND payment_type ='{$_POST['payment_type']}'";
                }
            }

            if ( ! empty( $_POST['AirlineIata'] ) ) {
                $sql .= " AND (airline_iata ='{$_POST['AirlineIata']}')";
            }


            if ( ! empty( $_POST['DateFlight'] ) ) {
                $xpl = explode( '-', $_POST['DateFlight'] );

                $FinalDate = dateTimeSetting::jalali_to_gregorian( $xpl[0], $xpl[1], $xpl[2], '-' );

                $sql .= " AND date_flight ='{$FinalDate}'";
            }

            if ( ! empty( $_POST['IsAgency'] ) ) {

                if ( $_POST['IsAgency'] == 'agency' ) {
                    $sql .= " AND agency_id <> '0'";
                } else if ( $_POST['IsAgency'] == 'Ponline' ) {
                    $sql .= " AND agency_id = '0'";
                }
            }


            $get_session_sub_manage = Session::getAgencyPartnerLoginToAdmin();

            if(Session::CheckAgencyPartnerLoginToAdmin() && $get_session_sub_manage=='AgencyHasLogin'){
                $check_access = $this->getController('manageMenuAdmin')->getAccessServiceCounter(Session::getInfoCounterAdmin());

                if($check_access){
                    $sql .= " AND serviceTitle IN ({$check_access})  ";


                }
                if(!empty($_POST['CounterId'])){
                    $sql.=' AND member_id='.$_POST['CounterId'].' ';
                }


            }
            $sql .= "  GROUP BY request_number ORDER BY creation_date_int DESC ";



            /** @var partner $client_controller */
            $client_controller = Load::controller('partner');
            $sub_clients = $client_controller->subClient(CLIENT_ID) ;
            $book_sub_client = array();
            $BookShow = array();
            $admin = Load::controller( 'admin' );

            if(!isset($_POST['sub_client_id']) || empty($_POST['sub_client_id'])) {

                $BookShow = $Model->select($sql);

                foreach ($BookShow as $key=>$item) {
                    $BookShow[$key]['NameAgency'] = CLIENT_NAME ;
                    $BookShow[$key]['sub_agency'] = false ;
                }
                $this->CountTicket = count( $BookShow );
            }


            if(isset($_POST['sub_client_id']) && !empty($_POST['sub_client_id'])){
                $info_client_selected =$client_controller->infoClient($_POST['sub_client_id']);
                $book_sub_clients =  $admin->ConectDbClient( $sql, $_POST['sub_client_id'], "SelectAll", "", "", "" );
                foreach ($book_sub_clients as $key=>$book_sub_client ){
                    $BookShow [$key] = $book_sub_client ;
                    $BookShow [$key]['NameAgency'] = $info_client_selected['AgencyName'] ;
                    $BookShow [$key]['sub_agency'] = true ;
                }
                $this->CountTicket = count( $BookShow );
            }else{
                if(!empty($sub_clients)){
                    foreach ($sub_clients as $sub_client) {
                        $book_sub_clients =  $admin->ConectDbClient( $sql, $sub_client['id'], "SelectAll", "", "", "" );
                        foreach ($book_sub_clients as $key=>$book_sub_client ){
                            $BookShow [($this->CountTicket + $key)] = $book_sub_client ;
                            $BookShow [($this->CountTicket + $key)]['NameAgency'] = $sub_client['AgencyName'] ;
                            $BookShow [($this->CountTicket + $key)]['sub_agency'] = true ;
                        }
                        $this->CountTicket += count($book_sub_clients);
                    }
                }
            }


        }
        $final_book = array();
        foreach ($BookShow as $key_book=>$book){
            $final_book[$key_book]['creation_date_int'] = $book['creation_date_int'];
        }


        array_multisort($final_book['creation_date_int'],SORT_DESC,$BookShow );

//        echo json_encode($BookShow,256); die();

        return $BookShow;


    }
    public function format_hour( $num ) {
        return date( "H:i", strtotime( $num ) );
    }

    public function DateJalali( $param ) {
        $split        = explode( ' ', $param );
        $explode_date = explode( '-', $split[0] );
        $date_now     = dateTimeSetting::gregorian_to_jalali( $explode_date[0], $explode_date[1], $explode_date[2], '/' );

        return isset( $split[1] ) ? $split[1] . ' ' . $date_now : $date_now;
    }

    public function getInfoTicketReservation( $requestNumber ) {
        if ( TYPE_ADMIN == '1' ) {

            $ModelBase = Load::library( 'ModelBase' );
            $sql       = " SELECT *
                 FROM report_tb
                 WHERE request_number='{$requestNumber}'
                 ORDER BY passenger_age";
            $Book      = $ModelBase->select( $sql );

        } else {

            $Model = Load::library( 'Model' );
            $sql   = " SELECT *
                 FROM book_local_tb
                 WHERE request_number='{$requestNumber}'
                 ORDER BY passenger_age";
            $Book  = $Model->select( $sql );

        }

        $totalPrice                = 0;
        $totalPriceWithoutDiscount = 0;
        foreach ( $Book as $val ) {
            $namePrice                 = strtolower( $val['passenger_age'] ) . '_price';
            $nameDiscountPrice         = 'discount_' . strtolower( $val['passenger_age'] ) . '_price';
            $totalPriceWithoutDiscount += $val[ $namePrice ];
            $totalPrice                += $val[ $nameDiscountPrice ];
        }

        if ( $Book[0]['percent_discount'] > 0 ) {
            $result['totalPriceWithoutDiscount'] = $totalPriceWithoutDiscount;
            $result['totalPrice']                = $totalPrice;
        } else {
            $result['totalPriceWithoutDiscount'] = 0;
            $result['totalPrice']                = $totalPriceWithoutDiscount;
        }

        $result['infoTicket'] = $Book;

        return $result;
    }

    public function insert( $info ) {

        Load::autoload( 'Model' );
        $Model           = new Model();
        $data ['price']  = $info['price'];
        $data['comment'] = $info['comment'];
        $data['status']  = '1';

        $Model->setTable( 'transaction_tb' );
        $result = $Model->insertLocal( $data );

        $this->transactions->insertTransaction($data);
        if ( $result ) {
            echo 'success : َشارژحساب شما افزایش یافت ';
        } else {
            echo 'error : خطا درشارژحساب';
        }
    }

    public function showedit( $request_number ) {

        if ( isset( $request_number ) && ! empty( $request_number ) ) {

            if ( TYPE_ADMIN == '1' ) {
                $ModelBase  = Load::library( 'ModelBase' );
                $edit_query = " SELECT * FROM  report_tb  WHERE request_number='{$request_number}'";
                $res_edit   = $ModelBase->select( $edit_query );
            } else {
                $Model      = Load::library( 'Model' );
                $edit_query = " SELECT * FROM  book_local_tb  WHERE request_number='{$request_number}'";
                $res_edit   = $Model->select( $edit_query );
            }

            if ( ! empty( $res_edit ) ) {
                $this->edit = $res_edit;
            } else {
                header( "Location: " . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . "/404.tpl" );
                exit();
            }
        } else {
            header( "Location: " . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . "/404.tpl" );
            exit();
        }
    }

    public function info_flight( $request_number, $Email ) {

        if ( TYPE_ADMIN == '1' ) {
            $ModelBase = Load::library( 'ModelBase' );

            if ( ! empty( $request_number ) ) {
                $edit_query = "SELECT * , " . " (SELECT count(id)   FROM  report_tb WHERE request_number='{$request_number}' AND passenger_age='Adt') AS adt_count, " . " (SELECT count(id)  FROM  report_tb WHERE request_number='{$request_number}' AND passenger_age='Chd') AS chd_count , " . " (SELECT count(id)  FROM  report_tb WHERE request_number='{$request_number}' AND passenger_age='Inf') AS inf_count, " . " (SELECT count(id) FROM report_tb WHERE request_number='{$request_number}' AND flight_type='charter') AS charter_count," . " (SELECT count(id) FROM report_tb WHERE request_number='{$request_number}' AND flight_type='system' AND pid_private='0') AS pubSystem_count," . " (SELECT count(id) FROM report_tb WHERE request_number='{$request_number}' AND flight_type='system' AND pid_private='1') AS prSystem_count" . "  FROM  report_tb  WHERE request_number='{$request_number}'";
                $res_edit   = $ModelBase->load( $edit_query );
            }


            if ( ! empty( $request_number ) ) {
                $cancel_query = "SELECT  * , " . " (SELECT count(id)   FROM  report_tb WHERE request_number='{$request_number}' AND passenger_age='Adt' AND request_cancel='confirm') AS adt_count, " . " (SELECT count(id)  FROM  report_tb WHERE request_number='{$request_number}' AND passenger_age='Chd' AND request_cancel='confirm') AS chd_count , " . " (SELECT count(id)  FROM  report_tb WHERE request_number='{$request_number}' AND passenger_age='Inf' AND request_cancel='confirm') AS inf_count " . "  FROM  report_tb  WHERE request_number='{$request_number}' AND request_cancel='confirm'";
                $res_cancel   = $ModelBase->load( $cancel_query );
            }

        } else {
            $Model = Load::library( 'Model' );


            if ( ! empty( $request_number ) ) {
                $edit_query = "SELECT * , " . " (SELECT count(id)   FROM  book_local_tb WHERE request_number='{$request_number}' AND (request_number> 0 || request_number<>'') AND passenger_age='Adt' ) AS adt_count, " . " (SELECT count(id)  FROM  book_local_tb WHERE request_number='{$request_number}' AND (request_number> 0 || request_number<>'') AND passenger_age='Chd' ) AS chd_count , " . " (SELECT count(id)  FROM  book_local_tb WHERE request_number='{$request_number}' AND (request_number> 0 || request_number<>'') AND passenger_age='Inf' ) AS inf_count" . "  FROM  book_local_tb  WHERE request_number='{$request_number}' ";
                $res_edit   = $Model->load( $edit_query );
            }

            if ( ! empty( $request_number ) ) {
                $cancel_query = "SELECT * , " . " (SELECT count(id)   FROM  book_local_tb WHERE request_number='{$request_number}' AND passenger_age='Adt' AND request_cancel='confirm') AS adt_count, " . " (SELECT count(id)  FROM  book_local_tb WHERE request_number='{$request_number}' AND passenger_age='Chd' AND request_cancel='confirm') AS chd_count , " . " (SELECT count(id)  FROM  book_local_tb WHERE request_number='{$request_number}' AND passenger_age='Inf' AND request_cancel='confirm') AS inf_count " . "  FROM  book_local_tb  WHERE request_number='{$request_number}' AND request_cancel='confirm'";
                $res_cancel   = $Model->load( $cancel_query );
            }


        }

        $this->countTotal    = $res_edit['adt_count'] + $res_edit['chd_count'] + $res_edit['inf_count'];
        $this->adt_qty       = $res_edit['adt_count'];
        $this->chd_qty       = $res_edit['chd_count'];
        $this->inf_qty       = $res_edit['inf_count'];
        $this->charter_qty   = $res_edit['charter_count'];
        $this->pubSystem_qty = $res_edit['pubSystem_count'];
        $this->prSystem_qty  = $res_edit['prSystem_count'];
        if ( ! empty( $res_edit ) ) {
            //                $this->list = $res_edit;
            if ( $res_cancel['adt_count'] > 0 || $res_cancel['chd_count'] > 0 || $res_cancel['inf_count'] > 0 ) {
                return '<span class=" fa fa-user" style="margin-left: 5px;">' . $res_edit['adt_count'] . '</span><span class=" fa fa-child" style="margin-left: 5px;">' . $res_edit['chd_count'] . '</span><span class=" fa fa-child">' . $res_edit['inf_count'] . '</span>' . '<br/><span class=" fa fa-user" style="margin-left: 5px; color: red">' . $res_cancel['adt_count'] . '</span><span class=" fa fa-child" style="margin-left: 5px; color: red">' . $res_cancel['chd_count'] . '</span><span class=" fa fa-child " style="color: red">' . $res_cancel['inf_count'] . '</span>';
            } else {
                return '<span class=" fa fa-user" style="margin-left: 5px;">' . $res_edit['adt_count'] . '</span><span class=" fa fa-child" style="margin-left: 5px;">' . $res_edit['chd_count'] . '</span><span class=" fa fa-child">' . $res_edit['inf_count'] . '</span>';
            }
        }
    }

    public function type_airplan( $name ) {
        $resultLocal = Load::controller( 'resultLocal' );

        return $resultLocal->AirPlaneType( $name );
    }

    public function list_hamkar() {
        return $this->getController('partner')->allClients();
    }

    public function listCounter( $AgencyId ) {


        $Model = Load::library( 'Model' );

        $sql = " SELECT * FROM members_tb WHERE fk_agency_id='{$AgencyId}'  AND (is_member =1) ORDER BY id DESC";

        return $Model->select( $sql );

    }

    public function type_user( $id ) {

        $Model = Load::autoload( 'Model' );


        $sql  = " SELECT * FROM members_tb WHERE id='{$id}' ";
        $user = $Model->load( $sql );


        if ( $user['is_member'] == '1' ) {
            return 'کاربر: ' . $user['name'] . ' ' . $user['family'];
        } else {
            return 'کاربر میهمان به مشخصات: ' . $user['mobile'] . ' (' . $user['email'] . ') ';
        }
    }

    public function ShowAddressClient( $param ) {

        $ModelBase = Load::library( 'ModelBase' );


        $sql    = "SELECT * FROM clients_tb WHERE id='{$param}'";
        $Client = $ModelBase->load( $sql );

        return $Client['Domain'];
    }

    public function info_flight_client( $request_number ) {

        if ( TYPE_ADMIN == '1' ) {
            Load::autoload( 'ModelBase' );
            $ModelBase = new ModelBase();

            $sql    = "select *," . " (SELECT COUNT(id) FROM report_tb WHERE request_number='{$request_number}') AS CountId " . " from report_tb  where (factor_number='{$request_number}' OR request_number='{$request_number}') AND (((factor_number OR request_number) > 0) OR ((factor_number OR request_number) <>''))  ";
            $result = $ModelBase->select( $sql );
        } else {
            Load::autoload( 'Model' );
            $Model = new Model();

            $sql    = "select *," . " (SELECT COUNT(id) FROM book_local_tb WHERE request_number='{$request_number}') AS CountId " . " from book_local_tb  where (factor_number='{$request_number}' OR request_number='{$request_number}') AND (((factor_number OR request_number) > 0) OR ((factor_number OR request_number) <>''))";
            $result = $Model->select( $sql );
        }

        //       echo '<pre>'. print_r($result,true).'</pre>';
        $this->count = count( $result );

        return $result;
    }

    public function info_flight_directions( $request_number ) {
        if ( TYPE_ADMIN == '1' ) {
            Load::autoload( 'ModelBase' );
            $ModelBase = new ModelBase();

            $sql    = "SELECT R.*, " . " (SELECT COUNT(id) FROM report_tb WHERE request_number = R.request_number) AS CountTicket " . " FROM report_tb R WHERE " . " (R.factor_number='{$request_number}' OR R.request_number='{$request_number}') " . " AND (((R.factor_number OR R.request_number) > 0) OR ((R.factor_number OR R.request_number) <>'')) " . " GROUP BY R.direction ";
            $result = $ModelBase->select( $sql );
        } else {
            Load::autoload( 'Model' );
            $Model = new Model();

            $sql    = "SELECT B.*, " . " (SELECT COUNT(id) FROM book_local_tb WHERE request_number = B.request_number) AS CountTicket " . " FROM book_local_tb B  WHERE " . " (B.factor_number='{$request_number}' OR B.request_number='{$request_number}') " . " AND (((B.factor_number OR B.request_number) > 0) OR ((B.factor_number OR B.request_number) <>'')) " . " GROUP BY B.direction ";
            $result = $Model->select( $sql );
        }

        return $result;
    }

    public function set_date_reserve( $date ) {
        $date_orginal_exploded = explode( ' ', $date );

        $date_miladi_exp = explode( '-', $date_orginal_exploded[0] );

        return dateTimeSetting::gregorian_to_jalali( $date_miladi_exp[0], $date_miladi_exp[1], $date_miladi_exp[2], '-' );
    }

    public function private_supplier_comision( $RequestNumber ) {

        Load::autoload( 'apiLocal' );
        $apiLocal = new apiLocal();

        list( $amount, $fare ) = $apiLocal->get_total_ticket_price( $RequestNumber, 'no' );

        return $amount - $this->private_agency_comision( $RequestNumber );
    }

    public function private_agency_comision( $RequestNumber ) {

        Load::autoload( 'apiLocal' );
        $apiLocal = new apiLocal();

        list($amount, $fare) = $apiLocal->get_total_ticket_price( $RequestNumber, 'no' );

        return $amount * ( ( 5 ) / 100 );
    }

    public function ticket_sell_in_time() {

        if ( TYPE_ADMIN == '1' ) {
            Load::autoload( 'ModelBase' );

            $ModelBase = new ModelBase();

            $sqlCharter = " SELECT COUNT(request_number) AS CountTicketCharter FROM report_tb WHERE successfull='book' AND flight_type='charter'";

            $sqlSystem = " SELECT COUNT(request_number) AS CountTicketSystem FROM report_tb WHERE successfull='book' AND flight_type='system' AND pid_private='0'";

            $sqlSystemPrivate = " SELECT COUNT(request_number) AS CountTicketSystemPrivate FROM report_tb WHERE (successfull='private_reserve' OR successfull='book') AND flight_type='system' AND pid_private='1'";

            $sqlTotal = " SELECT COUNT(request_number) AS CountTicketTotal FROM report_tb WHERE (successfull='private_reserve' OR successfull='book') ";

            $countTotalCharter       = $ModelBase->load( $sqlCharter );
            $countTotalSystem        = $ModelBase->load( $sqlSystem );
            $countTotalSystemPrivate = $ModelBase->load( $sqlSystemPrivate );
            $countTotal              = $ModelBase->load( $sqlTotal );

            $this->countTotalCharter       = $countTotalCharter['CountTicketCharter'] * 10;
            $this->countTotalSystem        = $countTotalSystem['CountTicketSystem'] * 10;
            $this->countTotalSystemPrivate = $countTotalSystemPrivate['CountTicketSystemPrivate'] * 10;
            $this->countTotal              = $countTotal['CountTicketTotal'] * 10;
        } else {
            Load::autoload( 'Model' );

            $Model = new Model();

            $sqlCharter       = " SELECT COUNT(DISTINCT request_number) AS CountTicketCharter FROM book_local_tb WHERE successfull='book' AND flight_type='charter'";
            $sqlSystem        = " SELECT COUNT(DISTINCT request_number) AS CountTicketSystem FROM book_local_tb WHERE successfull='book' AND flight_type='system' AND pid_private='0'";
            $sqlSystemPrivate = " SELECT COUNT(DISTINCT request_number) AS CountTicketSystemPrivate FROM book_local_tb WHERE successfull='book' AND flight_type='system' AND pid_private='1'";
            $sqlToatal        = " SELECT COUNT(DISTINCT request_number) AS CountTicketToal  FROM book_local_tb WHERE successfull='book' ";

            $countTotalCharter       = $Model->load( $sqlCharter );
            $countTotalSystem        = $Model->load( $sqlSystem );
            $countTotalSystemPrivate = $Model->load( $sqlSystemPrivate );
            $countTotal              = $Model->load( $sqlToatal );

            $this->countTotalCharter       = $countTotalCharter['CountTicketCharter'];
            $this->countTotalSystem        = $countTotalSystem['CountTicketSystem'];
            $this->countTotalSystemPrivate = $countTotalSystemPrivate['CountTicketSystemPrivate'];
            $this->countTotal              = $countTotal['CountTicketToal'];
        }
    }

    public function profit_sell_in_time() {

        if ( TYPE_ADMIN == '1' ) {
            Load::autoload( 'ModelBase' );

            $ModelBase = new ModelBase();

            $sql = "SELECT * ," . " SUM(api_commission) AS api_commission," . " SUM(agency_commission) AS agency_commission ," . " SUM(supplier_commission) AS supplier_commission ," . " SUM(irantech_commission) AS irantech_commission," . " SUM(adt_price) AS adt_price," . " SUM(chd_price) AS chd_price ," . " SUM(inf_price) AS inf_price " . " FROM report_tb" . " WHERE successfull='book' AND request_cancel <> 'confirm'  GROUP BY request_number ORDER BY creation_date_int DESC  ";

            $res = $ModelBase->select( $sql );

            $amount = 0;

            foreach ( $res as $each ) {

                if ( $each['flight_type'] == "charter" ) {
                    $amount += $each['agency_commission'] + $each['irantech_commission'] + $each['supplier_commission'];
                } else if ( $each['flight_type'] == "system" ) {
                    $amount += $each['adt_price'] + $each['chd_price'] + $each['inf_price'];
                }
            }

            //die();

            return number_format( $amount );
        } else {
            Load::autoload( 'Model' );

            $Model = new Model();

            $sql = "SELECT * ," . " SUM(api_commission) AS api_commission," . " SUM(agency_commission) AS agency_commission ," . " SUM(supplier_commission) AS supplier_commission ," . " SUM(irantech_commission) AS irantech_commission," . " SUM(adt_price) AS adt_price," . " SUM(chd_price) AS chd_price ," . " SUM(inf_price) AS inf_price " . "FROM book_local_tb " . " WHERE successfull='book' AND request_cancel <> 'confirm' " . "GROUP BY request_number ORDER BY creation_date_int DESC ";

            $res = $Model->select( $sql );

            $amount = 0;

            foreach ( $res as $each ) {


                if ( $each['flight_type'] == "charter" ) {
                    $amount += $each['agency_commission'] + $each['irantech_commission'] + $each['supplier_commission'];
                } else if ( $each['flight_type'] == "system" ) {
                    $amount += $each['adt_price'] + $each['chd_price'] + $each['inf_price'];
                }
            }


            return number_format( $amount );
        }
    }

    public function profit_agency_and_it() {

        if ( TYPE_ADMIN == '1' ) {

            Load::autoload( 'ModelBase' );

            $ModelBase = new ModelBase();

            $sql = " SELECT  SUM(irantech_commission) AS irantech_commission  FROM report_tb WHERE  successfull='book' AND request_cancel <> 'confirm'     GROUP BY request_number ";

            $res    = $ModelBase->select( $sql );
            $amount = 0;
            foreach ( $res as $each ) {

                $amount += $each['irantech_commission'];
            }


            return number_format( $amount );
        } else {
            Load::autoload( 'Model' );
            $Model = new Model();
            Load::autoload( 'apiLocal' );
            $apiLocal = new apiLocal();

            $sql = "SELECT  SUM(agency_commission) AS agency_commission FROM book_local_tb WHERE successfull='book' AND  request_cancel <> 'confirm'  AND flight_type='system'";
            $res = $Model->load( $sql );

            $profitSystem = $res['agency_commission'];


            $sqlCharter    = "SELECT SUM(agency_commission) AS agency_commission FROM book_local_tb WHERE successfull='book' AND request_cancel <> 'confirm' AND flight_type='charter' ";
            $resCharter    = $Model->load( $sqlCharter );
            $profitCharter = $resCharter['agency_commission'];


            //                die();
            $amount = $profitSystem + $profitCharter;

            return number_format( $amount );
        }
    }

    public function five_last_sell() {

        if ( TYPE_ADMIN == '1' ) {
            Load::autoload( 'ModelBase' );

            $ModelBase = new ModelBase();

            $sql = " SELECT  request_number ,origin_city,desti_city,flight_number FROM report_tb WHERE successfull='book' GROUP BY request_number  ORDER BY creation_date_int  DESC LIMIT 0,5";

            $res = $ModelBase->select( $sql );
        } else {
            Load::autoload( 'Model' );

            $Model = new Model();

            $sql = " SELECT * FROM book_local_tb WHERE successfull='book' GROUP BY request_number  ORDER BY creation_date_int DESC  LIMIT 0,5";

            $res = $Model->select( $sql );
        }

        return $res;
    }

    public function five_last_cancel() {

        Load::autoload( 'Model' );
        $Model = new Model();
        $sql   = "SELECT cancel.*, book.origin_city,book.desti_city,book.flight_number,book.request_number
                FROM cancel_ticket_details_tb AS cancel
                LEFT JOIN book_local_tb AS book ON book.request_number = cancel.RequestNumber
                WHERE cancel.Status='RequestMember' ORDER BY  cancel.id DESC LIMIT 0,5   ";

        $resultCancel = $Model->select( $sql );

        if ( ! empty( $resultCancel ) ) {
            return $resultCancel;

        } else {
            return 'empty';
        }

    }

    public function copmarDate( $date, $time ) {
        $DateOneMonth = time() - ( 30 * 24 * 60 * 60 );

        if ( strpos( $date, 'T' ) !== false ) {
            $date       = explode( 'T', $date );
            $dateFlight = $date[0];
            $TimeFlight = date( "H:i", strtotime( $time ) );

            $date_expl = explode( '-', $dateFlight );
            $time_expl = explode( ':', $TimeFlight );

            $Flight_Time = mktime( $time_expl[0], $time_expl[1], 0, $date_expl[1], $date_expl[2], $date_expl[0] );

        } else {
            $dateFlight = $date;
            $TimeFlight = date( "H:i", strtotime( $time ) );

            $date_expl = explode( '-', $dateFlight );
            $time_expl = explode( ':', $TimeFlight );

            $Flight_Time = mktime( $time_expl[0], $time_expl[1], 0, $date_expl[1], $date_expl[2], $date_expl[0] );

        }

        if ( $Flight_Time > $DateOneMonth ) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function TrackingInfo( $param ) {
        $_POST     = $param;
        $Model     = Load::library( 'Model' );
        $ModelBase = Load::library( 'ModelBase' );
        $sql       = " SELECT * FROM book_local_tb WHERE
            (request_number = '{$_POST['request_number']}' OR pnr = '{$_POST['request_number']}' OR factor_number = '{$_POST['request_number']}')
            AND (request_number > 0 OR request_number<>'')";
        $res       = $Model->load( $sql );

        if ( $res['successfull'] == 'book' ) {
            $status = functions::Xmlinformation( "Definitivereservation" );
        } else if ( $res['successfull'] == 'prereserve' ) {
            $status = functions::Xmlinformation( "Prereservation" );
        } else if ( $res['successfull'] == 'bank' ) {
            $status = functions::Xmlinformation( "NavigateToPort" );
        } else if ( $res['successfull'] == 'nothing' ) {
            $status = functions::Xmlinformation( "Unknow" );
        }

        if ( $res['request_cancel'] == 'none' ) {
            $class = ' btn btn-warning fa fa-times';
        } else if ( $res['request_cancel'] == 'request_user' || $res['request_cancel'] == 'request_admin' ) {
            $class = ' btn btn-warning fa fa-refresh';
        } else if ( $res['request_cancel'] == 'confirm' ) {
            $class = 'btn btn-success fa fa-check';
        }

        if ( $res['request_cancel'] == 'request_user' || $res['request_cancel'] == 'request_admin' ) {
            $title = functions::Xmlinformation( "RequestBeingReviewed" );
        } else if ( $res['request_cancel'] == 'confirm' ) {
            $title = functions::Xmlinformation( "CancellationRequestAccepted" );
        }

        $href = ROOT_ADDRESS . "/eticketLocal&num={$res['request_number']}";
        if ( $res['IsInternal'] == '1' ) {
            $href2 = ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=parvazBookingLocal&id={$res['request_number']}";
        } else {
            $href2 = ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=ticketForeign&id={$res['request_number']}";
        }


        $op = "  <a href='{$href2}' class='btn btn-info fa fa-file-pdf-o margin-10'  target='_blank' title='" . functions::Xmlinformation( "ViewPDFTickets" ) . "'></a>";

        if ( $res['type_app'] != 'reservation' && ( $res['successfull'] == 'book' || $res['successfull'] == 'book' ) /*&& ($this->copmarDate($res['date_flight'], $res['time_flight']) == 'true')*/ ) {
            $op .= '<a id="cancelbyuser"  title="' . functions::Xmlinformation( "CancelFlight" ) . '" onclick="ModalCancelUser(' . "'flight'" . ',' . "'" . $res['request_number'] . "'" . '); return false;"  class="btn btn-danger fa fa-times"></a>';
        }


        if ( ! empty( $res ) ) {
            $CancellationFeeSettingController = Load::controller( 'cancellationFeeSetting' );
            $CalculateIndemnity               = $CancellationFeeSettingController->CalculateIndemnity( $res['request_number'] );

            $totalPrice = functions::CalculateDiscount( $res['request_number'], 'yes' );
            if ( is_numeric( $CalculateIndemnity ) ) {
                $PricePenalty            = functions::CalculatePenaltyPriceCancel( $totalPrice, $fare, $CalculateIndemnity, $res['api_id'] );
                $CalculateIndemnityFinal = $CalculateIndemnity . ' ' . functions::Xmlinformation( "Percentagepenalty" );
            } else {
                $CalculateIndemnityFinal = '--';
                $PricePenalty            = '--';
            }

            $typeFlight = ( strtolower( $res['flight_type'] ) == 'system' ) ? 'سیستمی' : 'چارتری';


            $this->request_number = $res['request_number'];

            $result = '
                  <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title">
                        <i class="icon-table"></i><h3>' . functions::Xmlinformation( "Yourpurchase" ) . ' ' . functions::Xmlinformation( "On" ) . ' ' . functions::Xmlinformation( "Numberreservation" ) . '' . $res['request_number'] . ' <br/> ' . functions::Xmlinformation( "Indate" ) . ' ' . dateTimeSetting::jdate( 'Y-m-d H:i:s', $res['creation_date_int'] ) . '</h3>
                    </div>
                    
            <table class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>' . functions::Xmlinformation( "Origin" ) . '<br/>' . functions::Xmlinformation( "Destination" ) . '</th>
                        <th>' . functions::Xmlinformation( "RunTime" ) . '<br/>' . functions::Xmlinformation( "Date" ) . '</th>
                        <th>' . functions::Xmlinformation( "PnrCode" ) . '</th>
                        <th>' . functions::Xmlinformation( "Namepassenger" ) . '</th>
                        <th>' . functions::Xmlinformation( "Airline" ) . '<br/>' . functions::Xmlinformation( "Typeflight" ) . '</th>
                        <th>' . functions::Xmlinformation( "Numflight" ) . '<br/>' . functions::Xmlinformation( "WithRateID" ) . '</th>
                        <th>' . functions::Xmlinformation( "Percentagepenalty" ) . '</th>
                        <th>' . functions::Xmlinformation( "Amount" ) . '<br/>' . functions::Xmlinformation( "RefundAmount" ) . '</th>
                        <th>' . functions::Xmlinformation( "Status" ) . '</th>
                        <th>' . functions::Xmlinformation( "Action" ) . '</th>
                    </tr>
                </thead>
                <tbody>
            ';
            $result .= '<td>' . $res['origin_city'] . '<br/>' . $res['desti_city'] . '</td><td>' . $this->DateJalali( $res['date_flight'] ) . ' <br/>' . $this->format_hour( $res['time_flight'] ) . '</td><td>' . $res['pnr'] . '</td><td>' . $res['passenger_name'] . ' ' . $res['passenger_family'] . '</td><td>' . $res['airline_name'] . '<br/>' . $typeFlight . '</td><td>' . $res['flight_number'] . '<br/>' . $res['cabin_type'] . '</td><td>' . number_format( round( $CalculateIndemnityFinal ) ) . '</td><td>' . number_format( $totalPrice ) . ' ' . functions::Xmlinformation( "Rial" ) . '<br/>' . number_format( round( $PricePenalty ) ) . ' ' . functions::Xmlinformation( "Rial" ) . '</td><td>' . $status . '</td><td>' . $op . '</td>';
            $result .= '</table>';

            return $result;
        }

    }

    public function redirectOut() {

        header( 'Location: loginUser' );
    }

    public function total_price( $RequestNumber ) {
        Load::autoload( 'apiLocal' );
        $Model = new apiLocal();

        list( $amount, $fare ) = $Model->get_total_ticket_price( $RequestNumber, 'yes' );

        return array( $amount, $fare );
    }

    public function agency_com( $req_number ) {
        if ( TYPE_ADMIN == '1' ) {
            Load::autoload( 'ModelBase' );
            $ModelBase = new ModelBase();

            $sql = " SELECT SUM(agency_commission) AS agency_commission FROM report_tb WHERE request_number='{$req_number}'";
            $res = $ModelBase->load( $sql );
        } else {
            Load::autoload( 'Model' );
            $Model = new Modele();
        }

        return $res['agency_commission'];
    }

    public function namebank( $bank_dir = null, $client_id ) {

        if ( $bank_dir != null && ! empty( $bank_dir ) ) {
            if ( ! empty( $client_id ) ) {
                $admin = Load::controller( 'admin' );

                $sql = " SELECT * FROM bank_tb WHERE bank_dir='{$bank_dir}'";

                $Bank = $admin->ConectDbClient( $sql, $client_id, "Select", "", "", "" );

                return $Bank['title'];
            }
        } else {
            return 'ندارد';
        }
    }

    public function numberPortBnak( $bank_dir = null, $client_id ) {

        if ( $bank_dir != null && ! empty( $bank_dir ) ) {
            if ( ! empty( $client_id ) ) {
                $admin = Load::controller( 'admin' );

                $sql  = " SELECT * FROM bank_tb WHERE bank_dir='{$bank_dir}'";
                $Bank = $admin->ConectDbClient( $sql, $client_id, "Select", "", "", "" );

                return $Bank['param1'];
            }
        } else {
            return 'ندارد';
        }
    }

    public function nameAgency( $client_id ) {


        if ( ! empty( $client_id ) ) {

            Load::autoload( 'ModelBase' );
            $ModelBase = new ModelBase();

            $sql = " SELECT * FROM clients_tb WHERE id='{$client_id}'";
            $res = $ModelBase->load( $sql );

            return $res['AgencyName'];
        } else {
            return 'ندارد';
        }
    }

    public function changeFlagBuyPrivate( $param ) {
        Load::autoload( 'ModelBase' );
        $ModelBase               = new ModelBase();
        $data['is_done_private'] = '2';

        $Condition = " request_number='{$param['RequestNumber']}'";
        $ModelBase->setTable( 'report_tb' );
        $res = $ModelBase->update( $data, $Condition );

        if ( $res ) {
            return "success";
        } else {
            return "error";
        }
    }

    public function changeFlagBuyPublicSystem( $param ) {
        Load::autoload( 'ModelBase' );
        $ModelBase                    = new ModelBase();
        $data['public_stsyem_status'] = '1';

        $Condition = " request_number='{$param['RequestNumber']}'";
        $ModelBase->setTable( 'report_tb' );
        $res = $ModelBase->update( $data, $Condition );

        if ( $res ) {
            return "success";
        } else {
            return "error";
        }
    }

    public function changeFlagBuyPrivateToPublic( $param ) {


        Load::autoload( 'ModelBase' );
        $ModelBase               = new ModelBase();
        $data['is_done_private'] = '0';

        $Condition = " request_number='{$param['RequestNumber']}'";
        $ModelBase->setTable( 'report_tb' );
        $res = $ModelBase->update( $data, $Condition );

        if ( $res ) {
            return "success";
        } else {
            return "error";
        }
    }

    public function done_private( $RequestNumber ) {

        Load::autoload( 'ModelBase' );
        $ModelBase = new ModelBase();

        $sql = " SELECT * FROM report_tb WHERE request_number ='{$RequestNumber}'";

        $result = $ModelBase->load( $sql );

        if ( ! empty( $result ) ) {

            $data['is_done_private'] = '1';

            $ModelBase->setTable( 'report_tb' );

            $Condition = " request_number ='{$RequestNumber}'";

            $ResUpdate = $ModelBase->update( $data, $Condition );

            if ( $ResUpdate ) {
                return " success : درخواست شما با موفقیت ثبت شد";
            } else {
                return " error : درخواست شما با خطا مواجه شده ،لطفا مجددا انجام دهید";
            }

        } else {

            return "error : درخواست نامعتبر است،سوابقی پیدا نشد";
        }

    }

    public function ShowLogBuyTicket() {
        $BookShow = array();

        $ModelBase = Load::library( 'ModelBase' );
        $Model     = Load::library( 'Model' );

        $jdate = dateTimeSetting::jdate( "Y/m/d", time() );
        $ex    = explode( "/", $jdate );
        for ( $i = 11; $i >= 0; $i -- ) {
            $Timenow = dateTimeSetting::jmktime( 0, 0, 0, $ex[1], $ex[2], $ex[0] ) - ( ( $i ) * ( 24 * 60 * 60 ) );

            $CalculateTimeUnix = dateTimeSetting::jmktime( 23, 59, 59, $ex[1], $ex[2], $ex[0] );
            $TimeCalc          = $CalculateTimeUnix - ( ( $i ) * ( 24 * 60 * 60 ) );
            if ( TYPE_ADMIN == '1' ) {

                $sql        = " SELECT COUNT(request_number) AS reqNumber FROM report_tb WHERE (successfull='book' OR successfull='private_reserve') AND creation_date_int >= $Timenow AND creation_date_int < $TimeCalc ";
                $BookShow[] = $ModelBase->load( $sql );

            } else {
                $sql        = " SELECT COUNT(request_number) AS reqNumber FROM book_local_tb WHERE successfull='book' AND creation_date_int >= $Timenow AND creation_date_int < $TimeCalc ";
                $BookShow[] = $Model->load( $sql );
            }

        }

        return $BookShow;
    }

    public function createPdfContent( $param ) {

        $resultLocal = Load::controller( 'resultLocal' );

        if ( TYPE_ADMIN == '1' ) {
            $ModelBase   = Load::library( 'ModelBase' );
            $sql         = "select * from report_tb where request_number='{$param}' AND (successfull='book' OR successfull='private_reserve')";
            $info_ticket = $ModelBase->select( $sql );
        } else {
            $book_local_model = Load::model( 'book_local' );
            $info_ticket      = $book_local_model->getTicketInfo( $param );
        }

        $gender   = '';
        $genderEn = '';
        $airplan  = '';

        $PrintTicket = '';

        if ( ! empty( $info_ticket ) ) {


            $PrintTicket .= ' <!DOCTYPE html>
<html>
    <head>
        <title>ticket PDF Flight</title>
        <style type="text/css">
//                tr td{
//                border: 1px solid #000;
//                 }

                .divborder
                {
                    border: 1px solid #CCC;
                }
                
                 .divborderPoint
                {
                    border: 1px solid #CCC;
                    border-radius: 5px;
                    z-index: 10000000000000;
                    width: 350px;
                    padding: 10px;
                    margin-left: 20px;
                    color: #006cb5 !important;
//                    float: left;
                       margin-right: 480px;
                    background-color: #FFFFFF;
                }

                .page td {
                   padding:0; margin:0;
                }

                .page {
                   border-collapse: collapse;
                }
                
                @font-face {
                    font-family: "Yekan";
                    font-style: normal;
                    font-weight: normal;
                    src: url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.woff?#iefix") format("embedded-opentype"),
                    url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.woff") format("woff"),
                    url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.ttf") format("truetype");
                    
                }

             
                table{
                    font-family:Yekan !important;
                }
                .element:last-child {page-break-after:auto;}
        </style>

    </head>
    <body>';

            foreach ( $info_ticket as $info ) {
                if ( $info['passenger_age'] == "Adt" ) {
                    $infoAge = 'Adult';
                } else if ( $info['passenger_age'] == 'Chd' ) {
                    $infoAge = 'Child';
                } else if ( $info['passenger_age'] == 'Inf' ) {
                    $infoAge = 'Infant';
                }
                if ( $info['passenger_gender'] == 'Male' ) {
                    $gender   = ' آقای';
                    $genderEn = 'Mr';
                } else if ( $info['passenger_gender'] == 'Female' ) {
                    $gender   = ' خانم';
                    $genderEn = 'Ms';
                }

                if ( $info['flight_type'] == '' || $info['flight_type'] == 'charter' ) {
                    $flight_type = 'Charter';
                } else if ( $info['flight_type'] == 'system' ) {
                    $flight_type = 'schedule';
                }

                if ( $info['seat_class'] == 'C' ) {
                    $seat_class = 'business';
                } else {
                    $seat_class = 'Economics';
                }

                $Price = '0';
                if ( functions::TypeUser( $info['member_id'] ) == 'Ponline' ) {
                    $Price = functions::CalculateDiscountOnePerson( $info['request_number'], ( $info['passenger_national_code'] == '0000000000' || $info['passenger_national_code'] == '' ? $info['passportNumber'] : $info['passenger_national_code'] ), 'yes' );
                } else if ( functions::TypeUser( $info['member_id'] ) == 'Counter' ) {
                    $Price = functions::CalculateForOnePersonWithOutDiscount( $info['request_number'], ( $info['passenger_national_code'] == '0000000000' || $info['passenger_national_code'] == '' ? $info['passportNumber'] : $info['passenger_national_code'] ), 'yes' );

                }
                $LogoAgency  = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_LOGO;
                $picAirline  = functions::getAirlinePhoto( $info['airline_iata'] );
                $airlineName = functions::InfoAirline( $info['airline_iata'] );;
                $airplan     = 'http://online.indobare.com/gds/view/client/assets/images/air-return.png';
                $depEn       = functions::InfoRoute( $info['origin_airport_iata'] );
                $DestEn      = functions::InfoRoute( $info['desti_airport_iata'] );
                $PrintTicket .= '
                <table width="100%" align="center" style="margin: 100px ; border: 1px solid #CCC;" cellpadding="0" cellspacing="0" class="page">
                    <tr>
                        <td width="70%">
                                <table style="" cellpadding="0" cellspacing="0" class="page" >
                                     <tr style="width: 100%">
                                          <td style="width: 100%; color: #FFF; ">
                                              sdfsdfsdfasddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd
                                              asdsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                                              asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                                              asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                                              asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                                              asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                                          </td>
                                     </tr>
                                     <tr>
                                     <td width="100%" style=" border: 1px solid #CCC; font-size: 25px;  font-weight: bolder; padding: 10px ; text-align: left;">';
                $PrintTicket .= '<span style="float:left;text-align: left">' . '(' . $genderEn . ')' . $info['passenger_name_en'] . ' ' . $info['passenger_family_en'] . '</span>';

                $PrintTicket .= '</td>
                                     
                                     </tr>
                                </table>
                        </td>
                         <td width="30%" style="text-align: left">
                         
                         <table>
                             <tr>
                                 <td>
                                 <img src="' . $LogoAgency . '" style="float:left;width: 100px">
                                </td>
                                <td>
                                 ' . CLIENT_NAME . '
                                </td>
                            </tr>
                        </table>
                         
                         </td>
                    </tr>
                    <tr>
                    
                           <td width="70%" style="border: 1px solid #CCC; border-top:none;" align="center" valign="top" >
                                 <table style="width: 100%;border:1px solid #CCC" cellpadding="0" cellspacing="0" class="page"  valign="top">
                                         <tr style="height:450px">
                                                     <td width="220" height="100%" style="border-left: 1px solid #CCC;">
                                                         <table style="width: 100%" cellpadding="0" cellspacing="0" class="page" >
                                                             <tr style="border-bottom: 1px solid #CCC">
                                                               <td width="220"  align="left" style="padding: 5px; border-bottom: 1px solid #CCC "  height="50" >';
                $PrintTicket .= '<span style="font-size: 11px;  color:#006cb5 ; ">Nationality</span> ';
                $PrintTicket .= '<span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> ';
                $PrintTicket .= '<span>' . functions::country_code( ( $info['passportCountry'] != 'IRN' && $info['passportCountry'] != '' ? $info['passportCountry'] : 'IRN' ), 'en' ) . '</span> ';
                $PrintTicket .= '</td>
                                                            </tr>
                                                             <tr style="border-bottom: 1px solid #CCC">
                                                               <td width="220"  align="left" style="padding: 5px; border-bottom: 1px solid #CCC "  height="50" >';
                $PrintTicket .= '<span style="font-size: 11px;  color:#006cb5 ; ">AGES</span> ';
                $PrintTicket .= '<span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> ';
                $PrintTicket .= '<span>' . $infoAge . '</span> ';
                $PrintTicket .= '</td>
                                                            </tr>
                                                       <tr style="border-bottom: 1px solid #CCC" height="50">
                                                           <td width="220"  align="left" style="padding: 5px; border-bottom: 1px solid #CCC "  height="50" >';
                $PrintTicket .= '<span style="font-size: 11px;  color:#006cb5;">VOUCHER</span> ';
                $PrintTicket .= '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> ';
                $PrintTicket .= '<span>' . $info['request_number'] . '</span> ';
                $PrintTicket .= '</td>
                                                        </tr>
                                                        <tr style="border-bottom: 1px solid #CCC">
                                                           <td width="220"  align="left" style="padding: 5px; border-bottom: 1px solid #CCC;"  height="50" >';


                $PrintTicket .= ! empty( $info['pnr'] ) ? '<span style="font-size: 11px;  color:#006cb5;">PNR</span>' : '';
                $PrintTicket .= '<span style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> ';
                $PrintTicket .= '<span>' . ! empty( $info['pnr'] ) ? $info['pnr'] : '' . '</span> ';
                $PrintTicket .= '</td>
                                                        </tr>
                                                        <tr style="border-bottom: 1px solid #CCC">
                                                           <td width="220"  align="left"   height="50" style="padding-left: 5px">';

                $PrintTicket .= '<span>' . number_format( $Price ) . ' IRR</span> ';
                $PrintTicket .= '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> ';
                $PrintTicket .= '<span style="font-size: 11px;  color:#006cb5;">Price</span> ';
                $PrintTicket .= '</td>
                                                        </tr>
                                                        
                                                  </table>
                                                     </td>
                                                     <td width="450" height="220">
                                                            <table style="width: 100%" cellpadding="0" cellspacing="0" class="page" >
                                                                <tr>
                                                                        <td>
                                                                            <table style="width: 100%; font-size: 20px" cellpadding="0" cellspacing ="0" class="page" border="0">
                                                                                <tr>
                                                                            <td width="200" align="center" valign="middle" style="font-size: 25px">';
                $PrintTicket .= $DestEn['Departure_CityEn'];

                $PrintTicket .= '</td>
                                                                            <td width="50" align="center" valign="middle">
                                                                             <img src="' . $airplan . '"  style="float:right; max-height:30px;" />
                                                                            <td width="200" height="70" align="center" valign="middle" style="font-size: 25px">';
                $PrintTicket .= $depEn['Departure_CityEn'];
                $PrintTicket .= '</td>
                                                                            </td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td width="200" align="center" valign="middle">';
                $PrintTicket .= $resultLocal->format_hour_arrival( $info['origin_airport_iata'], $info['desti_airport_iata'], $info['time_flight'] );

                $PrintTicket .= '</td>
                                                                            <td width="50" align="center" valign="middle">
                                                                                -
                                                                            </td>
                                                                            <td width="200" height="70" align="center" valign="middle" style="font-size: 25px">';
                $PrintTicket .= $resultLocal->format_hour( $info['time_flight'] );
                $PrintTicket .= '</td>
                                                                             </tr>
                                                                             <tr>
                                                                                <td colspan="3" height="70" align="center" valign="middle" style="font-size: 25px">';

                $PrintTicket .= functions::convertDateFlight( $info['date_flight'] );
                $PrintTicket .= '</td>
                                                                              </tr>
                                                                         </table>
                                                                  </td>
                                                                 </tr>
                                                                
                                                              <tr>
                                                                <td>
                                                                   <table width="450" cellpadding="0" cellspacing="0" class="page" border="0">
                                                                        <tr >
                                                                           <td width="50%" height="40" align="center" valign="middle" style="border-left: 1px solid #CCC; border-top: 1px solid #CCC;">';

                $PrintTicket .= $flight_type;
                $PrintTicket .= '</td>
                                                                            <td width="50%" align="center" valign="middle" style="font-size: 20px;border-top: 1px solid #CCC;">OK</td>
                                                                         </tr>
                                                                    </table>
                                                                 </td>
                                                              </tr>
                                                            </table>
                                                     </td>
                                                </tr>
                                                </table>
                           </td>
                             
                                        <td width="30%" style="border: 1px solid #CCC; border-right:none ;" >
                                   
                                           <table style="width: 100%" cellpadding="0" cellspacing="0" class="page" >
                                             <tr style="border-bottom: 1px solid #CCC">
                                                  <td width="280px" align="center" style="border-bottom: 1px solid #CCC">
                                                        <img src="' . $picAirline . '" style="float:right; width: 100px">
                                                        ' . $airlineName['name_en'] . '
                                                   </td>
                                             </tr>
                                                     <tr>
                                                        <td>
                                                               <table style="width: 100%" cellpadding="0" cellspacing="0" class="page" >
                                                                <tr style="">
                                                                        <td width="140"  align="left" style="padding: 5px; border-bottom: 1px solid #CCC " >';

                $PrintTicket .= '<span style="float: left;font-size: 11px;  color:#006cb5;">FLIGHT</span> ';
                $PrintTicket .= '<span style="float: right ; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> ';
                $PrintTicket .= '<span style="float: right ; ">' . $info['flight_number'] . '</span> ';
                $PrintTicket .= '</td>
                                                                        
                                                                        </td>
                                                                          <td width="140" align="center" style="padding: 5px; border-right: 1px solid #CCC;  border-bottom: 1px solid #CCC; font-size: 15px">';
                $PrintTicket .= '<span style="float: right;">' . $seat_class . '</span>';
                $PrintTicket .= '<span style="float: left;">' . '(' . $info['cabin_type'] . ' )' . '</span>';
                $PrintTicket .= '</td>
                                                                </tr>
                                                                <tr>
                                                                     <td colspan="2" align="left" style="padding: 5px ; border-bottom: 1px solid #CCC" width="280">
                                                                                ';
                $PrintTicket .= ! empty( $info['eticket_number'] ) ? '<span style="float: left; font-size: 11px;  color:#006cb5 ;text-align: left">FLIGHT NO</span>' : '';;
                $PrintTicket .= '<span style="float: right ;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> ';
                $PrintTicket .= '<span style="float: right;">' . ! empty( $info['eticket_number'] ) ? $info['eticket_number'] : '' . '</span>';
                $PrintTicket .= '</td>
                                                                </tr>
                                                                <tr>
                                                                     <td colspan="2" align="center" style="padding: 10px" width="280">
                                                                         <img src="http://online.indobare.com/gds/library/barcode/barcode_creator.php?barcode=' . $info['eticket_number'] . '" style="max-width: 100px; min-height: 50px">
                                                                     </td>
                                                                </tr>
                                                               </table>
                                                               
                                                        </td>
                                                 </tr>
                                            </table>
                                         </td>
                    </tr>

                </table>
                <div class="divborder" style="margin: 100px;">
                <div style="font-size: 19px; margin-top:-20px; text-align: left" class="divborderPoint">  Pay attention to the following points: </div>
               <div style="clear: left"></div>
                    <table width="100%" align="center"  cellpadding="0" cellspacing="0">
                        <tr>
                            <td > </td>
                        </tr>
                        
                            <tr>
                                <td style="padding-bottom: 20px; padding-left: 5px" align="left">
                                    <ul style="text-align: left">
                                        <li>Maximum allowable load is 20 kg</li>
                                        <li>Be sure to have your national identification card on the ride</li>
                                        <li>Be sure to stay 2 hours before the flight at the airport</li>
                                        <li>In case of flight consignment by airline, passenger or delay of more than 2 hours, please apply for air ticket stamp or receipt.</li>
                                        <li>Provide a valid and authentic photo card to accept tickets and board the aircraft</li>
                                        <li>Terminal 1: KishAir, Zagros</li>
                                        <li>Terminal 2: Iran Air, Air Tour, Ata, Qeshm Air, Meraj, Naft(Karon)</li>
                                        <li>Terminal 4: Mahan, Caspian, Aseman, Atrak, Taban, Sepehran</li>
                                        <li>If there is a problem with your ticket for any reason, please call the agency phone numbers at the end of the ticket.</li>
                                      
                                    </ul>
                                
                                </td>
                           
                            </tr>
                   
                    </table>
                </div>
               <hr  style="margin: 530px 100px 0px 100px ; width: 90%" />
                <table width="100%" align="center" style="margin: 100px 100px 50px 100px ; font-size: 20px"  scellpadding="0" cellspacing="0"  >
                
                    <tr>
                        <td align="left">SUPPORT AND TELEGRAM :';
                $PrintTicket .= CLIENT_MOBILE;
                $PrintTicket .= '

                </td>
                         <td align="left">TELEPHONE :';
                $PrintTicket .= CLIENT_PHONE;
                $PrintTicket .= '
                        
                        </td>
                        <td align="left">
                    SITE :   ';
                $PrintTicket .= CLIENT_MAIN_DOMAIN;
                $PrintTicket .= '
                        </td>
                    </tr>
                    <tr>
                    <td colspan="2" align="left" style="direction: ltr">
                    ADDRESS :    ';
                $PrintTicket .= CLIENT_ADDRESS_EN;
                $PrintTicket .= ' </td>
                    </tr>
                
                </table>
                
                <div style="clear:both"></div>
        <div class = "element"></div>
                ';
            }
            $PrintTicket .= ' </body>
</html> ';
        } else {
            $PrintTicket = '<div style="text-align:center ; font-size:20px ;font-family: Yekan;">No INFORMATION </div>';
        }

        return $PrintTicket;
    }

    #region PassengerTicketHistory

    public function TicketHistoryCounter( $id ) {
        $Model = Load::library( 'Model' );

        $Sql = "SELECT * FROM book_local_tb WHERE successfull='book'  AND request_cancel <> 'confirm' AND member_id='{$id}' GROUP BY request_number ORDER BY  creation_date_int DESC";

        $rec = $Model->select( $Sql );

        $this->CountTicketCounter = count( $rec );

        return $rec;
    }

    #endregion

    public function PassengerTicketHistory( $Code, $AgencyId = null ) {
        $Model = Load::library( 'Model' );

        $Sql = "SELECT * FROM book_local_tb WHERE successfull='book'  AND (passenger_national_code='{$Code}' OR passportNumber='{$Code}')  ";

        if ( empty( $AgencyId ) ) {
            $AgencyId = Session::getAgencyId();
            $Sql      .= "AND agency_id='{$AgencyId}'";
        } else {
            $Sql .= "AND agency_id='{$AgencyId}'";
        }

        $Sql .= "GROUP BY request_number ORDER BY  creation_date_int ASC";
        $rec = $Model->select( $Sql );

        $this->CountTicketCounter = count( $rec );

        return $rec;
    }

    public function preReserveBuy( $Param ) {
        $admin = Load::controller( 'admin' );
        Load::autoload( 'ModelBase' );
        $ModelBase = new ModelBase();

        $SqlReport    = "SELECT * FROM report_tb WHERE request_number='{$Param['RequestNumber']}'";
        $ResultReport = $ModelBase->select( $SqlReport );

        $SqlBook    = "SELECT * FROM book_local_tb WHERE request_number='{$Param['RequestNumber']}'";
        $ResultBook = $admin->ConectDbClient( $SqlBook, $Param['ClientID'], "SelectAll", "", "", "" );

        if ( ! empty( $ResultReport ) && ! empty( $ResultBook ) ) {

            //update book_local_tb
            $data['successfull'] = 'prereserve';
            $resultUpdateBook    = $admin->ConectDbClient( "", $Param['ClientID'], "Update", $data, "book_local_tb", "request_number='{$Param['RequestNumber']}'" );

            //update report_tb
            $ConditionUpdateReport = "request_number='{$Param['RequestNumber']}'";
            $ModelBase->setTable( 'report_tb' );
            $resultUpdateReport = $ModelBase->update( $data, $ConditionUpdateReport );

            //delete counter credit if exists
            $admin->ConectDbClient( "", $Param['ClientID'], "Delete", '', "credit_detail_tb", "requestNumber='{$Param['RequestNumber']}' AND type='decrease'" );

            //delete transaction
            $SqlMultiWay    = "SELECT COUNT(DISTINCT direction) AS multiway FROM book_local_tb WHERE factor_number='{$Param['FactorNumber']}'";
            $ResultMultiWay = $admin->ConectDbClient( $SqlMultiWay, $Param['ClientID'], "Select", "", "", "" );
            if ( $ResultMultiWay['multiway'] == 1 ) {
                $deleteTransaction = $admin->ConectDbClient( "", $Param['ClientID'], "Delete", '', "transaction_tb", "FactorNumber='{$Param['FactorNumber']}'" );
                $this->transactions->deleteTransaction("FactorNumber='{$Param['FactorNumber']}' AND clientID='{$Param['ClientID']}'");
            } else {
                $SqlDept    = "SELECT  *,
                SUM(adt_price+chd_price+inf_price) AS totalPrice,
                SUM(api_commission) AS totalApiCommission,
                (SELECT COUNT(id) FROM book_local_tb WHERE factor_number = '{$Param['FactorNumber']}' AND direction = 'dept') AS count_id
                FROM book_local_tb WHERE factor_number = '{$Param['FactorNumber']}' AND direction = 'dept'";
                $ResultDept = $admin->ConectDbClient( $SqlDept, $Param['ClientID'], "Select", "", "", "" );

                $isInternal    = ( $ResultDept['isInternal'] == '1' ) ? 'internal' : 'external';
                $check_private = functions::checkConfigPid( $ResultDept['airline_iata'], $isInternal, $ResultDept['flight_type'],$ResultDept['api_id'], $Param['ClientID'] );
                if ( ( $check_private == 'public' ) || ( $check_private == 'private' && $ResultDept['flight_type'] == 'charter' ) ) {

                    if ( $ResultDept['flight_type'] == 'system' ) {
                        $Price = $ResultDept['totalPrice'] - ( ( 27 / 1000 ) * $ResultDept['totalPrice'] );
                    } else {
                        $Price = $ResultDept['totalPrice'] + $ResultDept['totalApiCommission'];
                    }

                } else {
                    $Price = 0;
                }

                if ( $ResultDept['flight_type'] == 'system' ) {
                    if ( $check_private == 'public' ) {
                        $type = ' سیستمی پید اشتراکی ';
                    } else {
                        $type = ' سیستمی پید اختصاصی ';
                    }
                } else {
                    $type = ' چارتری ';
                }

                $data['Price']     = $Price;
                $data['Comment']   = "خرید" . " " . $ResultDept['count_id'] . " عدد بلیط هواپیما از" . " " . $ResultDept['origin_city'] . " به" . " " . $ResultDept['desti_city'] . " به شماره رزرو " . $ResultDept['request_number'] . $type;
                $deleteTransaction = $admin->ConectDbClient( "", $Param['ClientID'], "Update", $data, "transaction_tb", "FactorNumber='{$Param['FactorNumber']}'" );

                $data['ClientID'] = $Param['ClientID'];
                $this->transactions->updateTransaction($data,"FactorNumber='{$Param['FactorNumber']}'");
            }

            if ( $resultUpdateReport && $resultUpdateBook && $deleteTransaction ) {
                return 'success : عملیات با موفقیت انجام شد';

            } else if ( ! $resultUpdateReport && $resultUpdateBook && $deleteTransaction ) {
                return 'error: خطا در آپدیت جدول مادر';
            } else if ( $resultUpdateReport && ! $resultUpdateBook && $deleteTransaction ) {
                return 'error: خطا در آپدیت جدول مشتری';
            } else if ( $resultUpdateReport && $resultUpdateBook && ! $deleteTransaction ) {
                return 'error: خطا در حذف تراکنش مشتری';
            } else if ( ! $resultUpdateReport && ! $resultUpdateBook && ! $deleteTransaction ) {
                return 'error: خطا سه بخشی';
            }

        } else {
            return 'error : درخواست شما معتبر نمی باشد';
        }

    }

    public function CountTypeTicketCharter() {
        $ModelBase = Load::library( 'ModelBase' );

        $jdate = dateTimeSetting::jdate( "Y/m/d", time() );
        $ex    = explode( "/", $jdate );

        for ( $i = 11; $i >= 0; $i -- ) {
            $Timenow           = dateTimeSetting::jmktime( 0, 0, 0, $ex[1], $ex[2], $ex[0] ) - ( ( $i ) * ( 24 * 60 * 60 ) );
            $CalculateTimeUnix = dateTimeSetting::jmktime( 23, 59, 59, $ex[1], $ex[2], $ex[0] );
            $TimeCalc          = $CalculateTimeUnix - ( ( $i ) * ( 24 * 60 * 60 ) );

            $Sql   = "SELECT COUNT(request_number) AS CountCharter , creation_date_int FROM report_tb WHERE (successfull='book' OR successfull='private_reserve') AND flight_type = 'charter'  AND  creation_date_int >= $Timenow AND creation_date_int < $TimeCalc";
            $Log[] = $ModelBase->load( $Sql );

        }

        return $Log;

        //        echo Load::plog($Log);
    }

    public function CountTypeTicketSystemPublic() {
        $ModelBase = Load::library( 'ModelBase' );

        $jdate = dateTimeSetting::jdate( "Y/m/d", time() );
        $ex    = explode( "/", $jdate );

        for ( $i = 11; $i >= 0; $i -- ) {
            $Timenow           = dateTimeSetting::jmktime( 0, 0, 0, $ex[1], $ex[2], $ex[0] ) - ( ( $i ) * ( 24 * 60 * 60 ) );
            $CalculateTimeUnix = dateTimeSetting::jmktime( 23, 59, 59, $ex[1], $ex[2], $ex[0] );
            $TimeCalc          = $CalculateTimeUnix - ( ( $i ) * ( 24 * 60 * 60 ) );

            $Sql   = "SELECT COUNT(request_number) AS CountPublicSystem FROM report_tb WHERE (successfull='book' OR successfull='private_reserve') AND flight_type = 'system' AND pid_private='0' AND  creation_date_int >= $Timenow AND creation_date_int < $TimeCalc";
            $Log[] = $ModelBase->load( $Sql );
        }

        return $Log;
    }

    public function CountTypeTicketSystemPrivate() {
        $ModelBase = Load::library( 'ModelBase' );

        $jdate = dateTimeSetting::jdate( "Y/m/d", time() );
        $ex    = explode( "/", $jdate );

        for ( $i = 11; $i >= 0; $i -- ) {
            $Timenow           = dateTimeSetting::jmktime( 0, 0, 0, $ex[1], $ex[2], $ex[0] ) - ( ( $i ) * ( 24 * 60 * 60 ) );
            $CalculateTimeUnix = dateTimeSetting::jmktime( 23, 59, 59, $ex[1], $ex[2], $ex[0] );
            $TimeCalc          = $CalculateTimeUnix - ( ( $i ) * ( 24 * 60 * 60 ) );


            $Sql   = "SELECT COUNT(request_number) AS CountPrivateSystem FROM report_tb WHERE (successfull='book' OR successfull='private_reserve') AND flight_type = 'system' AND pid_private='1' AND  creation_date_int >= $Timenow AND creation_date_int < $TimeCalc";
            $Log[] = $ModelBase->load( $Sql );

        }

        return $Log;
    }

    public function ShowInfoTicketForInsertPnr( $RequestNumber, $ClientId ) {

        $admin = Load::controller( 'admin' );

        $Sql = "SELECT * FROM book_local_tb WHERE request_number = '{$RequestNumber}'";

        $TicketInfo = $admin->ConectDbClient( $Sql, $ClientId, "SelectAll", "", "", "" );

        return $TicketInfo;

    }

    public function InsertPnrToDB( $data ) {

        $admin     = Load::controller( 'admin' );
        $ModelBase = Load::library( 'ModelBase' );

        $report    = '';
        $bookLocal = '';
        $SQl       = "SELECT * FROM report_tb WHERE request_Number='{$data['RequestNumber']}'";
        $Client    = $ModelBase->load( $SQl );

        error_log( 'try show result method PnrOfAdmin in : ' . date( 'Y/m/d H:i:s' ) . '  array eqaul in => : ' . json_encode( $data, true ) . " \n", 3, LOGS_DIR . 'PnrOfAdmin.txt' );


        if ( ! empty( $Client ) ) {
            foreach ( $data['nationalCode'] as $i => $result ) {
                $dataPnr['pnr'] = $data['pnr'];
                if ( ! empty( $data['airline_iata'] ) ) {
                    $dataPnr['airline_iata'] = $data['airline_iata'];
                }

                if ( ! empty( $data['airline_name'] ) ) {
                    $dataPnr['airline_name'] = $data['airline_name'];
                }

                if ( ! empty( $data['flight_number'] ) ) {
                    $dataPnr['flight_number'] = $data['flight_number'];
                }
                if ( ! empty( $data['seat_class'] ) ) {
                    $dataPnr['seat_class'] = $data['seat_class'];
                }

                if ( ! empty( $data['time_flight'] ) ) {
                    $dataPnr['time_flight'] = $data['time_flight'];

                }
                $dataPnr['eticket_number'] = $data['eTicketNumber'][ $i ];
                $ClientID                  = $data['ClientID'];

                $passenger_national_code = $result;

                $Condition = "request_number='{$data['RequestNumber']}' AND (passportNumber='{$passenger_national_code}' OR passenger_national_code='{$passenger_national_code}')";

                $ModelBase->setTable( 'report_tb' );
                $report = $ModelBase->update( $dataPnr, $Condition );

                $bookLocal = $admin->ConectDbClient( "", $ClientID, "Update", $dataPnr, "book_local_tb", $Condition );


            }

            if ( $report && $bookLocal ) {
                echo 'Success : عملیات با موفقیت انجام شد';
            } else {
                echo 'Error : خطا در انجام عملیات';
            }
        } else {
            echo 'خطا در ثبت اطلاعات';
        }


    }

    public function FlightConvertToBook( $data ) {

        $admin     = Load::controller( 'admin' );
        $ModelBase = Load::library( 'ModelBase' );

        $report    = '';
        $bookLocal = '';
        $SQl       = "SELECT * FROM report_tb WHERE request_Number='{$data['RequestNumber']}'";
        $Flight    = $ModelBase->load( $SQl );


        error_log( 'try show result method PnrOfAdmin in : ' . date( 'Y/m/d H:i:s' ) . '  array eqaul in => : ' . json_encode( $data, true ) . " \n", 3, LOGS_DIR . 'PnrOfAdmin.txt' );


        if ( ! empty( $Flight ) ) {
            foreach ( $data['nationalCode'] as $i => $result ) {
                $dataToBook['pnr']            = $data['pnr'];
                $dataToBook['eticket_number'] = $data['eTicketNumber'][ $i ];
                $ClientID                     = $data['ClientID'];
                $dataToBook['payment_type']   = ( $Flight['successfull'] == 'bank' ) ? 'cash' : 'credit';
                $dataToBook['successfull']    = 'book';
                $passenger_national_code      = $result;

                $Condition = "request_number='{$data['RequestNumber']}' AND (passportNumber='{$passenger_national_code}' OR passenger_national_code='{$passenger_national_code}')";
                $bookLocal = $admin->ConectDbClient( "", $ClientID, "Update", $dataToBook, "book_local_tb", $Condition );

                $dataToBook['successfull'] = ( $Flight['pid_private'] == '1' ) ? 'private_reserve' : 'book';
                $ModelBase->setTable( 'report_tb' );
                $report = $ModelBase->update( $dataToBook, $Condition );

            }

            if ( $report && $bookLocal ) {

                $dataTransaction['PaymentStatus'] = 'success';
                $Condition                        = "FactorNumber='{$Flight['factor_number']}' ";
                $admin->ConectDbClient( "", $ClientID, "Update", $dataTransaction, "transaction_tb", $Condition );

                $dataTransaction['ClientID'] = $ClientID;
                $this->transactions->updateTransaction($dataTransaction,$Condition);

                echo 'Success : عملیات با موفقیت انجام شد';
            } else {
                echo 'Error : خطا در انجام عملیات';
            }
        } else {
            echo 'خطا در ثبت اطلاعات';
        }


    }

    public function ListRTRD() {
        $date               = dateTimeSetting::jdate( "Y-m-d", time() );
        $date_now_explode   = explode( '-', $date );
        $date_now_int_start = dateTimeSetting::jmktime( 0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0] );
        $date_now_int_end   = dateTimeSetting::jmktime( 23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0] );
        $admin              = Load::controller( 'admin' );
        if ( TYPE_ADMIN == '1' ) {
            $ModelBase = Load::library( 'ModelBase' );

            $sql = "SELECT rep.*,cli.AgencyName AS NameAgency" . " FROM report_tb as rep" . " LEFT JOIN clients_tb AS cli ON cli.id =rep.client_id WHERE (successfull='book' OR  successfull='private_reserve')" . " AND flight_type <> 'charterPrivate'";


            if ( Session::CheckAgencyPartnerLoginToAdmin() ) {
                $sql .= " AND agency_id='{$_SESSION['AgencyId']}' ";

                if ( ! empty( $_POST['CounterId'] ) ) {
                    if ( $_POST['CounterId'] != "all" ) {
                        $sql .= " AND member_id ='{$_POST['CounterId']}'";
                    }
                }

            }


            if ( ! empty( $_POST['date_of'] ) && ! empty( $_POST['to_date'] ) ) {

                $date_of     = explode( '-', $_POST['date_of'] );
                $date_to     = explode( '-', $_POST['to_date'] );
                $date_of_int = dateTimeSetting::jmktime( 0, 0, 0, $date_of[1], $date_of[2], $date_of[0] );
                $date_to_int = dateTimeSetting::jmktime( 23, 59, 59, $date_to[1], $date_to[2], $date_to[0] );
                $sql         .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
            } else {

                $sql .= " AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";

            }

            if ( ! empty( $_POST['successfull'] ) ) {
                if ( $_POST['successfull'] == 'all' ) {

                    $sql .= " AND (successfull ='book' OR successfull ='private_reserve')";
                } else if ( $_POST['successfull'] == 'book' ) {
                    $sql .= " AND (successfull ='{$_POST['successfull']}' OR successfull='private_reserve')";
                } else {
                    $sql .= " AND (successfull ='nothing' OR successfull ='credit' OR successfull ='bank' OR successfull ='prereserve' ) ";
                }
            }


            if ( ! empty( $_POST['flight_type'] ) ) {

                if ( $_POST['flight_type'] == 'all' ) {
                    $sql .= " AND (flight_type ='system' OR flight_type ='charter' OR flight_type ='charterPrivate')";
                } else if ( $_POST['flight_type'] == 'charterSourceFour' ) {
                    $sql .= " AND flight_type ='charter' AND api_id='5'";
                } else if ( $_POST['flight_type'] == 'charterSourceSeven' ) {
                    $sql .= " AND flight_type ='charter' AND api_id='8'";
                } else if ( $_POST['flight_type'] == 'SystemSourceFour' ) {
                    $sql .= " AND flight_type ='system' AND api_id='5'";
                } else if ( $_POST['flight_type'] == 'SystemSourceFive' ) {
                    $sql .= " AND flight_type ='system' AND api_id='1'";
                } else if ( $_POST['flight_type'] == 'SystemSourceTen' ) {
                    $sql .= " AND flight_type ='system' AND api_id='11'";
                } else if ( $_POST['flight_type'] == 'SystemSourceForeignNine' ) {
                    $sql .= " AND flight_type ='system' AND api_id='10' AND IsInternal='0'";
                }
            }

            if ( ! empty( $_POST['request_number'] ) ) {
                $sql .= " AND request_number ='{$_POST['request_number']}'";
            }
            if ( ! empty( $_POST['client_id'] ) ) {
                if ( $_POST['client_id'] != "all" ) {
                    $sql .= " AND client_id ='{$_POST['client_id']}'";
                }
            }


            if ( ! empty( $_POST['passenger_name'] ) ) {
                $sql .= " AND (passenger_name LIKE '%{$_POST['passenger_name']}%' OR passenger_family LIKE '%{$_POST['passenger_name']}%')";
            }


            if ( ! empty( $_POST['passenger_national_code'] ) ) {
                $sql .= " AND (passenger_national_code ='{$_POST['passenger_national_code']}')";
            }


            if ( ! empty( $_POST['member_name'] ) ) {
                $sql .= " AND member_name LIKE '%{$_POST['member_name']}%'";
            }
            if ( ! empty( $_POST['payment_type'] ) ) {
                if ( $_POST['payment_type'] == 'all' ) {
                    $sql .= " AND (payment_type != '' OR payment_type != 'nothing')";
                } elseif ( $_POST['payment_type'] == 'credit' ) {
                    $sql .= " AND (payment_type = 'credit' OR payment_type = 'member_credit')";
                } else {
                    $sql .= " AND payment_type ='{$_POST['payment_type']}'";
                }
            }

            if ( ! empty( $_POST['eticket_number'] ) ) {
                $sql .= " AND (eticket_number ='{$_POST['eticket_number']}')";
            }
            if ( ! empty( $_POST['AirlineIata'] ) ) {
                $sql .= " AND (airline_iata ='{$_POST['AirlineIata']}')";
            }


            if ( ! empty( $_POST['DateFlight'] ) ) {
                $xpl = explode( '-', $_POST['DateFlight'] );

                $FinalDate = dateTimeSetting::jalali_to_gregorian( $xpl[0], $xpl[1], $xpl[2], '-' );

                $sql .= " AND date_flight Like'%{$FinalDate}%'";
            }

            $sql .= " ORDER BY rep.creation_date_int DESC, rep.id DESC  ";

            $BookShow = $ModelBase->select( $sql );

            foreach ( $BookShow as $key => $Cancel ) {
                $requestNumberCancel = $Cancel['request_number'];

                $SqlCancel    = "SELECT RequestNumber AS RequestNumberCancel FROM cancel_ticket_details_tb WHERE RequestNumber='{$requestNumberCancel}' AND (Status <> 'RequestMember' && Status<>'SetCancelClient')";
                $CancelClient = $admin->ConectDbClient( $SqlCancel, $Cancel['client_id'], "Select", "", "", "" );

                if ( ! empty( $CancelClient ) ) {
                    $BookShow[ $key ]['cancel'] = $CancelClient['RequestNumberCancel'];

                } else {
                    $BookShow[ $key ]['cancel'] = '';
                }

            }

        } else {
            $Model = Load::library( 'Model' );
            $sql   = "SELECT *" . " FROM book_local_tb WHERE  (successfull='book' OR  successfull='private_reserve')" . " AND flight_type <> 'charterPrivate'";

            if ( Session::CheckAgencyPartnerLoginToAdmin() ) {

                $sql .= " AND agency_id='{$_SESSION['AgencyId']}' ";

                if ( ! empty( $_POST['CounterId'] ) ) {
                    if ( $_POST['CounterId'] != "all" ) {
                        $sql .= " AND member_id ='{$_POST['CounterId']}'";
                    }
                }
            }

            if ( ! empty( $_POST['date_of'] ) && ! empty( $_POST['to_date'] ) ) {

                $date_of     = explode( '-', $_POST['date_of'] );
                $date_to     = explode( '-', $_POST['to_date'] );
                $date_of_int = dateTimeSetting::jmktime( 0, 0, 0, $date_of[1], $date_of[2], $date_of[0] );
                $date_to_int = dateTimeSetting::jmktime( 23, 59, 59, $date_to[1], $date_to[2], $date_to[0] );
                $sql         .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
            } else {
                $sql .= "AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";

            }

            if ( ! empty( $_POST['flight_type'] ) ) {

                if ( $_POST['flight_type'] == 'all' ) {
                    $sql .= " AND (flight_type ='system' OR flight_type ='charter' OR flight_type ='charterPrivate')";
                } else if ( $_POST['flight_type'] == 'charterSourceFour' ) {
                    $sql .= " AND flight_type ='charter' AND api_id='5'";
                } else if ( $_POST['flight_type'] == 'charterSourceSeven' ) {
                    $sql .= " AND flight_type ='charter' AND api_id='8'";
                } else if ( $_POST['flight_type'] == 'SystemSourceFour' ) {
                    $sql .= " AND flight_type ='system' AND api_id='5'";
                } else if ( $_POST['flight_type'] == 'SystemSourceFive' ) {
                    $sql .= " AND flight_type ='system' AND api_id='1'";
                } else if ( $_POST['flight_type'] == 'SystemSourceTen' ) {
                    $sql .= " AND flight_type ='system' AND api_id='11'";
                } else if ( $_POST['flight_type'] == 'SystemSourceForeignNine' ) {
                    $sql .= " AND flight_type ='system' AND api_id='10' AND IsInternal='0'";
                }
            }

            if ( ! empty( $_POST['request_number'] ) ) {
                $sql .= " AND request_number ='{$_POST['request_number']}'";
            }


            if ( ! empty( $_POST['passenger_name'] ) ) {
                $sql .= " AND (passenger_name LIKE '%{$_POST['passenger_name']}%' OR passenger_family LIKE '%{$_POST['passenger_name']}%')";
            }


            if ( ! empty( $_POST['passenger_national_code'] ) ) {
                $sql .= " AND (passenger_national_code ='{$_POST['passenger_national_code']}')";
            }


            if ( ! empty( $_POST['member_name'] ) ) {
                $sql .= " AND member_name LIKE '%{$_POST['member_name']}%'";
            }

            if ( ! empty( $_POST['payment_type'] ) ) {
                if ( $_POST['payment_type'] == 'all' ) {
                    $sql .= " AND (payment_type != '' OR payment_type != 'nothing')";
                } elseif ( $_POST['payment_type'] == 'credit' ) {
                    $sql .= " AND (payment_type = 'credit' OR payment_type = 'member_credit')";
                } else {
                    $sql .= " AND payment_type ='{$_POST['payment_type']}'";
                }
            }

            if ( ! empty( $_POST['AirlineIata'] ) ) {
                $sql .= " AND (airline_iata ='{$_POST['AirlineIata']}')";
            }


            if ( ! empty( $_POST['DateFlight'] ) ) {
                $xpl = explode( '-', $_POST['DateFlight'] );

                $FinalDate = dateTimeSetting::jalali_to_gregorian( $xpl[0], $xpl[1], $xpl[2], '-' );

                $sql .= " AND date_flight ='{$FinalDate}'";
            }

            if ( Session::CheckAgencyPartnerLoginToAdmin() ) {
                $sql .= " AND agency_id='{$_SESSION['AgencyId']}' ";

                if ( ! empty( $_POST['CounterId'] ) ) {
                    if ( $_POST['CounterId'] != "all" ) {
                        $sql .= " AND member_id ='{$_POST['CounterId']}'";
                    }
                }
            }

            $sql .= " ORDER BY creation_date_int DESC, id DESC ";


            $BookShow = $Model->select( $sql );

            foreach ( $BookShow as $key => $Cancel ) {
                $requestNumberCancel = $Cancel['request_number'];

                $SqlCancel    = "SELECT RequestNumber AS RequestNumberCancel FROM cancel_ticket_details_tb WHERE RequestNumber='{$requestNumberCancel}' AND (Status <> 'RequestMember' && Status<>'SetCancelClient')";
                $CancelClient = $Model->load( $SqlCancel );

                if ( ! empty( $CancelClient ) ) {
                    $BookShow[ $key ]['cancel'] = $CancelClient['RequestNumberCancel'];

                } else {
                    $BookShow[ $key ]['cancel'] = '';
                }

            }
        }


        $this->CountTicket = count( $BookShow );

        return $BookShow;
    }


    #region listSourceShare
    public function listSourceShare() {
        $date               = dateTimeSetting::jdate( "Y-m-d", time() );
        $date_now_explode   = explode( '-', $date );
        $date_now_int_start = dateTimeSetting::jmktime( 0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0] );
        $date_now_int_end   = dateTimeSetting::jmktime( 23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0] );

        $ModelBase = Load::library( 'ModelBase' );
        $admin     = Load::controller( 'admin' );

        $sql = "SELECT rep.*, cli.AgencyName AS NameAgency, " . " (SELECT COUNT(id) FROM report_tb WHERE factor_number = rep.factor_number) AS eachBookCount" . " FROM report_tb as rep" . " LEFT JOIN clients_tb AS cli ON cli.id =rep.client_id WHERE (successfull='book' OR  successfull='private_reserve')";

        if ( Session::CheckAgencyPartnerLoginToAdmin() ) {
            $sql .= " AND agency_id='{$_SESSION['AgencyId']}' ";

            if ( ! empty( $_POST['CounterId'] ) ) {
                if ( $_POST['CounterId'] != "all" ) {
                    $sql .= " AND member_id ='{$_POST['CounterId']}'";
                }
            }
        }

        if ( ! empty( $_POST['date_of'] ) && ! empty( $_POST['to_date'] ) ) {

            $date_of     = explode( '-', $_POST['date_of'] );
            $date_to     = explode( '-', $_POST['to_date'] );
            $date_of_int = dateTimeSetting::jmktime( 0, 0, 0, $date_of[1], $date_of[2], $date_of[0] );
            $date_to_int = dateTimeSetting::jmktime( 23, 59, 59, $date_to[1], $date_to[2], $date_to[0] );
            $sql         .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        } else {
            $sql .= " AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";
        }

        if ( ! empty( $_POST['request_number'] ) ) {
            $sql .= " AND request_number ='{$_POST['request_number']}'";
        }

        if ( ! empty( $_POST['client_id'] ) ) {
            if ( $_POST['client_id'] != "all" ) {
                $sql .= " AND client_id ='{$_POST['client_id']}'";
            }
        }

        if ( ! empty( $_POST['passenger_name'] ) ) {
            $sql .= " AND (passenger_name LIKE '%{$_POST['passenger_name']}%' OR passenger_family LIKE '%{$_POST['passenger_name']}%')";
        }

        if ( ! empty( $_POST['passenger_national_code'] ) ) {
            $sql .= " AND (passenger_national_code ='{$_POST['passenger_national_code']}')";
        }


        if ( ! empty( $_POST['member_name'] ) ) {
            $sql .= " AND member_name LIKE '%{$_POST['member_name']}%'";
        }

        if ( ! empty( $_POST['payment_type'] ) ) {
            if ( $_POST['payment_type'] == 'all' ) {
                $sql .= " AND (payment_type != '' OR payment_type != 'nothing')";
            } elseif ( $_POST['payment_type'] == 'credit' ) {
                $sql .= " AND (payment_type = 'credit' OR payment_type = 'member_credit')";
            } else {
                $sql .= " AND payment_type ='{$_POST['payment_type']}'";
            }
        }

        if ( ! empty( $_POST['eticket_number'] ) ) {
            $sql .= " AND (eticket_number ='{$_POST['eticket_number']}')";
        }

        if ( ! empty( $_POST['AirlineIata'] ) ) {
            $sql .= " AND (airline_iata ='{$_POST['AirlineIata']}')";
        }

        if ( ! empty( $_POST['DateFlight'] ) ) {
            $xpl = explode( '-', $_POST['DateFlight'] );

            $FinalDate = dateTimeSetting::jalali_to_gregorian( $xpl[0], $xpl[1], $xpl[2], '-' );

            $sql .= " AND date_flight Like'%{$FinalDate}%'";
        }

        $sql      .= " ORDER BY rep.creation_date_int DESC, rep.id DESC  ";
        $BookShow = $ModelBase->select( $sql );

        foreach ( $BookShow as $key => $rec ) {
            $query  = "SELECT credit FROM credit_detail_tb WHERE requestNumber='{$rec['request_number']}'";
            $result = $admin->ConectDbClient( $query, $rec['client_id'], "Select", "", "", "" );

            if ( ! empty( $result ) ) {
                $BookShow[ $key ]['subCredit'] = $result['credit'];

            } else {
                $BookShow[ $key ]['subCredit'] = 0;
            }

            $queryTrans  = "SELECT Price FROM transaction_tb WHERE FactorNumber='{$rec['factor_number']}'";
            $resultTrans = $admin->ConectDbClient( $queryTrans, $rec['client_id'], "Select", "", "", "" );

            if ( ! empty( $resultTrans ) ) {
                $BookShow[ $key ]['credit'] = $resultTrans['Price'] / $rec['eachBookCount'];

            } else {
                $BookShow[ $key ]['credit'] = 0;
            }
        }

        $this->CountTicket = count( $BookShow );

        return $BookShow;
    }

    #endregion


    public function infoBookByFactorNumber( $factorNumber ) {
        $Model = Load::library( 'Model' );

        $Sql = "SELECT * FROM book_local_tb WHERE  factor_number='{$factorNumber}'";

        $ResultBookFlight = $Model->select( $Sql );

        return $ResultBookFlight;


    }

    public function ListAllBuyClient( $lastTimeUpdate = null ) {
        $Model = Load::library( 'Model' );
        $sql   = "SELECT * FROM transaction_tb
                WHERE
                    PaymentStatus='success'
                    AND  Reason NOT IN ('charge','price_cancel','indemnity_cancel','increase','decrease','indemnity_edit_ticket','diff_price')";
        if ( ! empty( $lastTimeUpdate ) ) {
            $sql .= " AND creationDateInt >'{$lastTimeUpdate['creationDateInt']}'";
        }

        $resultTransaction = $Model->select( $sql );


        if ( ! empty( $resultTransaction ) ) {

            $this->userId        = Session::getUserId();
            $infoUser            = functions::infoMember( $this->userId );
            $this->counterTypeId = $infoUser['fk_counter_type_id'];

            foreach ( $resultTransaction as $keyResult => $valueTransaction ) {

                if ( $valueTransaction['Reason'] == 'buy_hotel' || $valueTransaction['Reason'] == 'buy_foreign_hotel' || $valueTransaction['Reason'] == 'buy_reservation_hotel' ) {
                    $resultHotel = $this->hotelBuy( $valueTransaction['FactorNumber'] );
                    if ( ! empty( $resultHotel ) ) {
                        $result[ $keyResult ] = $resultHotel;
                    }
                } elseif ( $valueTransaction['Reason'] == 'buy' || $valueTransaction['Reason'] == 'buy_reservation_ticket' ) {
                    $resultFlight = $this->ticketBuy( $valueTransaction['FactorNumber'] );
                    if ( ! empty( $resultFlight ) ) {
                        $result[ $keyResult ] = $resultFlight;
                    }
                } elseif ( $valueTransaction['Reason'] == 'buy_insurance' ) {
                    $insurance = $this->insuranceBuy( $valueTransaction['FactorNumber'] );
                    if ( ! empty( $insurance ) ) {
                        $result[ $keyResult ] = $insurance;
                    }
                } elseif ( $valueTransaction['Reason'] == 'buy_reservation_tour' ) {
                    $reservation_tour = $this->tourBuy( $valueTransaction['FactorNumber'] );
                    if ( ! empty( $reservation_tour ) ) {
                        $result[ $keyResult ] = $reservation_tour;
                    }
                } elseif ( $valueTransaction['Reason'] == 'buy_reservation_visa' ) {
                    $visa = $this->visaBuy( $valueTransaction['FactorNumber'] );
                    if ( ! empty( $visa ) ) {
                        $result[ $keyResult ] = $visa;
                    }
                } elseif ( $valueTransaction['Reason'] == 'buy_gasht_transfer' ) {
                    $resultGasht = $this->gashtBuy( $valueTransaction['FactorNumber'] );
                    if ( ! empty( $resultGasht ) ) {
                        $result[] = $resultGasht;
                    }
                } elseif ( $valueTransaction['Reason'] == 'buy_bus' ) {
                    $resBus = $this->BusBuy( $valueTransaction['FactorNumber'] );
                    if ( ! empty( $resBus ) ) {
                        $result[ $keyResult ] = $resBus;
                    }
                } elseif ( $valueTransaction['Reason'] == 'buy_train' ) {
                    $resTrain = $this->trainBuy( $valueTransaction['FactorNumber'] );
                    if ( ! empty( $resTrain ) ) {
                        $result[ $keyResult ] = $resTrain;
                    }
                }
            }

            $resultFinal = array();
            if ( isset( $result ) ) {
                foreach ( $result as $key => $res ) {
                    if ( ! empty( $res ) ) {
                        $resultFinal[] = $res;
                    }

                }
            }
            functions::insertLog( 'Result Is =>' . json_encode( $resultFinal ), 'ClubResultPoint' );

            return $resultFinal;
        }

        return null;
    }

    public function hotelBuy( $factorNumber ) {
        $Model   = Load::library( 'Model' );
        $dataNow = dateTimeSetting::jdate( "Y-m-d", time() + ( 60 * 60 * 24 ), '', '', 'en' );
        $sql     = "SELECT  book.serviceTitle,book.creation_date_int,members.card_number,book.total_price FROM book_hotel_local_tb AS book
                LEFT JOIN members_tb AS members ON members.id = book.member_id
                WHERE book.status='BookedSuccessfully' AND book.member_id ='{$this->userId}' AND book.factor_number='{$factorNumber}' AND (book.start_date < '{$dataNow}' )
                ";
        $result  = $Model->load( $sql );
        if ( ! empty( $result ) ) {

            $params['counterId']   = $this->counterTypeId;
            $params['company']     = 'all';
            $params['baseCompany'] = 'all';
            $params['service']     = $result['serviceTitle'];
            $params['price']       = $result['total_price'];

            $data['price']         = $params['price'];
            $data['giftPrice']     = functions::CalculatePricePoint( $params );
            $data['point']         = functions::CalculatePoint( $params );
            $data['service_title'] = 'hotel';
            $data['factorNumber']  = $factorNumber;
            $data['creationDate']  = dateTimeSetting::jdate( 'Y/m/d', $result['creation_date_int'], '', '', 'en' );

            if ( $data['point'] > 0 ) {
                return $data;
            }
        }
    }

    public function ticketBuy( $factorNumber ) {

        $Model   = Load::library( 'Model' );
        $dataNow = date( "Y-m-d", ( time() + ( 60 * 60 * 24 ) ) );
        $sql     = "SELECT  book.serviceTitle,book.creation_date_int,members.card_number FROM book_local_tb AS book
                LEFT JOIN members_tb AS members ON members.id = book.member_id
                WHERE successfull='book' AND  book.member_id ='{$this->userId}' AND book.factor_number='{$factorNumber}' AND book.date_flight < '{$dataNow}'
                ";


        $result = $Model->load( $sql );
        if ( ! empty( $result ) ) {

            $airline               = functions::InfoAirline( $result['airline_iata'] );
            $params['counterId']   = $this->counterTypeId;
            $params['baseCompany'] = $airline['id'];
            $params['company']     = $result['flight_number'];
            $params['service']     = $result['serviceTitle'];
            $params['price']       = functions::CalculateDiscount( $factorNumber );

            $data['price']         = $params['price'];
            $data['giftPrice']     = functions::CalculatePricePoint( $params );
            $data['point']         = functions::CalculatePoint( $params );
            $data['service_title'] = 'flight';
            $data['factorNumber']  = $factorNumber;
            $data['creationDate']  = dateTimeSetting::jdate( 'Y/m/d', $result['creation_date_int'], '', '', 'en' );


            if ( $data['point'] > 0 ) {
                return $data;
            }

        }

    }

    public function insuranceBuy( $factorNumber ) {
        $Model   = Load::library( 'Model' );
        $dataNow = time() + ( 60 * 60 * 24 * 30 );
        $sql     = "SELECT  book.serviceTitle,book.creation_date_int,members.card_number,book.base_price,book.tax
                FROM book_insurance_tb AS book
                LEFT JOIN members_tb AS members ON members.id = book.member_id
                WHERE book.status='book' AND book.member_id ='{$this->userId}' AND book.factor_number='{$factorNumber}'
                  AND (book.creation_date_int < '{$dataNow}' )
                ";
        $result  = $Model->load( $sql );
        if ( ! empty( $result ) ) {
            $params['counterId']   = $this->counterTypeId;
            $params['baseCompany'] = 'all';
            $params['company']     = 'all';
            $params['service']     = $result['serviceTitle'];
            $params['price']       = ( $result['base_price'] + $result['tax'] );

            $data['price']         = $params['price'];
            $data['giftPrice']     = functions::CalculatePricePoint( $params );
            $data['point']         = functions::CalculatePoint( $params );
            $data['service_title'] = 'insurance';
            $data['factorNumber']  = $factorNumber;
            $data['creationDate']  = dateTimeSetting::jdate( 'Y/m/d', $result['creation_date_int'], '', '', 'en' );

            if ( $data['point'] > 0 ) {
                return $data;
            }
        }
    }

    public function tourBuy( $factorNumber ) {
        $Model   = Load::library( 'Model' );
        $dataNow = dateTimeSetting::jdate( "Y-m-d", time() + ( 60 * 60 * 24 ), '', '', 'en' );
        $sql     = "SELECT  book.serviceTitle,book.creation_date_int,members.card_number,book.tour_total_price FROM book_tour_local_tb AS book
                LEFT JOIN members_tb AS members ON members.id = book.member_id
                WHERE book.status='BookedSuccessfully' AND book.member_id ='{$this->userId}' AND book.factor_number='{$factorNumber}' AND (book.tour_start_date < '{$dataNow}' )
                ";
        $result  = $Model->load( $sql );
        if ( ! empty( $result ) ) {

            $params['counterId']   = $this->counterTypeId;
            $params['baseCompany'] = 'all';
            $params['company']     = 'all';
            $params['service']     = $result['serviceTitle'];
            $params['price']       = $result['tour_total_price'];

            $data['price']         = $params['price'];
            $data['giftPrice']     = functions::CalculatePricePoint( $params );
            $data['point']         = functions::CalculatePoint( $params );
            $data['service_title'] = 'tour';
            $data['factorNumber']  = $factorNumber;
            $data['creationDate']  = dateTimeSetting::jdate( 'Y/m/d', $result['creation_date_int'], '', '', 'en' );

            if ( $data['point'] > 0 ) {
                return $data;
            }
        }
    }

    public function visaBuy( $factorNumber ) {
        $Model   = Load::library( 'Model' );
        $dataNow = time() + ( 60 * 60 * 24 * 30 );
        $sql     = "SELECT  book.serviceTitle,book.creation_date_int,members.card_number,book.total_price
                FROM book_visa_tb AS book
                LEFT JOIN members_tb AS members ON members.id = book.member_id
                WHERE book.status='book' AND book.member_id ='{$this->userId}' AND book.factor_number='{$factorNumber}'
                  AND book.creation_date_int < '{$dataNow}'
                ";
        $result  = $Model->load( $sql );
        if ( ! empty( $result ) ) {

            $params['counterId']   = $this->counterTypeId;
            $params['baseCompany'] = 'all';
            $params['company']     = 'all';
            $params['service']     = $result['serviceTitle'];
            $params['price']       = $result['total_price'];

            $data['price']         = $params['price'];
            $data['giftPrice']     = functions::CalculatePricePoint( $params );
            $data['point']         = functions::CalculatePoint( $params );
            $data['service_title'] = 'visa';
            $data['factorNumber']  = $factorNumber;
            $data['creationDate']  = dateTimeSetting::jdate( 'Y/m/d', $result['creation_date_int'], '', '', 'en' );

            if ( $data['point'] > 0 ) {
                return $data;
            }
        }
    }

    public function gashtBuy( $factorNumber ) {
        $Model   = Load::library( 'Model' );
        $dataNow = dateTimeSetting::jdate( "Y-m-d", time() + ( 60 * 60 * 24 ), '', '', 'en' );
        $sql     = "SELECT  book.creation_date_int,members.card_number,
                        SUM(book.passenger_servicePriceAfterOff + book.tax) AS totalPrice
                FROM book_gasht_local_tb AS book
                LEFT JOIN members_tb AS members ON members.id = book.member_id
                WHERE book.status='book' AND book.member_id ='{$this->userId}' AND book.passenger_factor_num='{$factorNumber}'
                  AND book.passenger_serviceRequestDate < '{$dataNow}'
                ";
        $result  = $Model->load( $sql );
        if ( ! empty( $result ) ) {

            $params['counterId']   = $this->counterTypeId;
            $params['baseCompany'] = 'all';
            $params['company']     = 'all';
            $params['service']     = 'LocalGasht';
            $params['price']       = $result['totalPrice'];

            $data['price']         = $params['price'];
            $data['giftPrice']     = functions::CalculatePricePoint( $params );
            $data['point']         = functions::CalculatePoint( $params );
            $data['service_title'] = 'gasht';
            $data['factorNumber']  = $factorNumber;
            $data['creationDate']  = dateTimeSetting::jdate( 'Y/m/d', $result['creation_date_int'], '', '', 'en' );

            if ( $data['point'] > 0 ) {
                return $data;
            }
        }
    }

    public function BusBuy( $factorNumber ) {
        $Model   = Load::library( 'Model' );
        $dataNow = dateTimeSetting::jdate( "Y-m-d", time() + ( 60 * 60 * 24 ), '', '', 'en' );
        $sql     = "SELECT  book.BaseCompany,book.CompanyName,book.serviceTitle,book.creation_date_int,members.card_number,book.total_price
                FROM book_bus_tb AS book
                LEFT JOIN members_tb AS members ON members.id = book.member_id
                WHERE book.status='book' AND book.member_id ='{$this->userId}' AND book.passenger_factor_num='{$factorNumber}'
                  AND book.DateMove < '{$dataNow}'
                ";
        $result  = $Model->load( $sql );
        if ( ! empty( $result ) ) {

            if ( $result['BaseCompany'] != '' ) {
                $baseCompany = functions::getIdBaseCompanyBus( $result['BaseCompany'] );
            } else {
                $baseCompany = functions::getIdBaseCompanyBus( $result['CompanyName'] );
            }

            $params['counterId']   = $this->counterTypeId;
            $params['baseCompany'] = $baseCompany['id'];
            $params['company']     = 'all';
            $params['service']     = $result['serviceTitle'];
            $params['price']       = $result['total_price'];

            $data['price']         = $params['price'];
            $data['giftPrice']     = functions::CalculatePricePoint( $params );
            $data['point']         = functions::CalculatePoint( $params );
            $data['service_title'] = 'bus';
            $data['factorNumber']  = $factorNumber;
            $data['creationDate']  = dateTimeSetting::jdate( 'Y/m/d', $result['creation_date_int'], '', '', 'en' );

            if ( $data['point'] > 0 ) {
                return $data;
            }
        }
    }

    public function trainBuy( $factorNumber ) {
        $Model   = Load::library( 'Model' );
        $dataNow = date( "Y-m-d", time() + ( 60 * 60 * 24 ) );
        $sql     = "SELECT  book.CompanyName,book.TrainNumber,book.creation_date_int,members.card_number
                FROM book_train_tb AS book
                LEFT JOIN members_tb AS members ON members.id = book.member_id
                WHERE book.successfull='book' AND book.member_id ='{$this->userId}' AND book.factor_number='{$factorNumber}'
                  AND book.ExitDate < '{$dataNow}'
                ";
        $result  = $Model->load( $sql );
        if ( ! empty( $result ) ) {

            $objTrain   = Load::controller( 'trainBooking' );
            $totalPrice = $objTrain->TotalPriceByFactorNumber( $factorNumber );

            if ( $result['CompanyName'] != '' ) {
                $baseCompany = functions::getIdCompanyTrain( $result['CompanyName'] );
            } else {
                $baseCompany = 'all';
            }

            $params['counterId']   = $this->counterTypeId;
            $params['baseCompany'] = $baseCompany;
            $params['company']     = $result['TrainNumber'];
            $params['service']     = 'Train';
            $params['price']       = $totalPrice;

            $data['price']         = $totalPrice;
            $data['giftPrice']     = functions::CalculatePricePoint( $params );
            $data['point']         = functions::CalculatePoint( $params );
            $data['service_title'] = 'train';
            $data['factorNumber']  = $factorNumber;
            $data['creationDate']  = dateTimeSetting::jdate( 'Y/m/d', $result['creation_date_int'], '', '', 'en' );

            if ( $data['point'] > 0 ) {
                return $data;
            }
        }
    }


    #region listIncreasePriceCounter
    public function listIncreasePriceCounterFLight() {
        $Model = Load::library( 'Model' );
        $sql   = "SELECT * FROM book_local_tb WHERE amount_added <> '' AND  amount_added > 0 AND successfull='book'  GROUP BY request_number  ORDER BY  creation_date_int DESC ";

        return $Model->select( $sql );
    }
    #endregion


    #region listUncompletedBookList
    public function listUncompletedBookList() {
        /** @var admin $admin */
        $admin   = Load::controller( 'admin' );
        $clients = functions::clients();
        $results = [];
        foreach ( $clients as $client ) {
            $clientId   = $client['id'];
            $sqlTickets = "SELECT transactionTb.FactorNumber, bookLocal.* FROM transaction_tb AS transactionTb
                           LEFT JOIN book_local_tb AS bookLocal ON bookLocal.factor_number = transactionTb.FactorNumber WHERE
                            transactionTb.PaymentStatus= 'success' AND bookLocal.successfull <> 'book' ORDER BY bookLocal.successfull DESC";

            $tickets = $admin->ConectDbClient( $sqlTickets, $clientId, 'SelectAll' );
            foreach ( $tickets as $ticket ) {
                $ticket['NameOfAgency'] = $client['AgencyName'];
                array_push( $results, $ticket );
            }
        }

        return $results;
    }
    #


    #region MainTicketHistory

    public function MainFlightTicketHistory( $param ) {
        $ArrInfoAgancyShare=array();
        if ( ! empty( $param['member_id'] ) ) {
            $intendedUser  = [
                "member_id" => $param['member_id'],
                "agency_id" => @$param['agency_id']
            ];

            $ListBookLocal = $this->listBookLocal( $intendedUser );
        } else {

            $ListBookLocal = $this->listBookLocal($param);
        }

        $transactions = $this->getTransactionsByDateRange($param['date_of'],$param['to_date'],$param['pnr'],$param['factor_number'],$param['request_number'],$param['passenger_name']);//list Transactions
        $adt_qty            = 0;
        $chd_qty            = 0;
        $inf_qty            = 0;
        $priceAgency        = 0;
        $priceMe            = 0;
        $pricetotal         = 0;
        $prsystem_price     = 0;
        $pubsystem_price    = 0;
        $charter_price      = 0;
        $pricesupplier      = 0;
        $totalQty           = 0;
        $CreditTotal        = 0;
        $charter_qty_type   = 0;
        $prSystem_qty_type  = 0;
        $pubSystem_qty_type = 0;
        $GetWayIranTech     = functions::DataIranTechGetWay();
        $FlightData         = [];
        $CountTicket        = '1';
        $RowCountTicket     = $this->CountTicket;
        foreach ( $ListBookLocal as $key => $flightBook ) {
            $transactionLink          = ROOT_ADDRESS_WITHOUT_LANG . '/itadmin/transactionUser&id=' . $flightBook['client_id'];
            $DataFlightInfoMember     = functions::infoMember( $flightBook['member_id'], $flightBook['client_id'] );
            $DataFlightInfoCommission = functions::CommissionFlightSystemPublic( $flightBook['request_number'] );

            if ( ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                $totalQty = ( $flightBook['adt_qty_f'] + $flightBook['chd_qty_f'] + $flightBook['inf_qty_f'] ) + $totalQty;
            }

            $DataFlightType = dateTimeSetting::jdate( 'Y-m-d (H:i:s)', $flightBook['creation_date_int'] ) . "<hr style='margin:3px'><span class='FontBold'>" . $flightBook['request_number'] . "</span> <hr style='margin:3px'><span class='FontBold'> " . $flightBook['factor_number'] . "</span> <hr style='margin:3px'>";
            if ( $flightBook['flight_type'] == "charter" ) {
                $DataFlightType .= "چارتری <hr style='margin:3px'> چارتر" . ( $flightBook['pid_private'] == '1' ? "اختصاصی" : "اشتراکی" );
            } elseif ( $flightBook['flight_type'] == "system" ) {
                $DataFlightType .= "سیستمی <hr style='margin:3px'>" . ( $flightBook['pid_private'] == '1' ? "پیداختصاصی" : "پید اشتراکی" );
            } elseif ( $flightBook['flight_type'] == "charterPrivate" ) {
                $DataFlightType .= "چارتری <hr style='margin:3px'> رزرواسیون اختصاصی";
            } else {
                $DataFlightType .= "نامشخص";
            }

            if (TYPE_ADMIN == '1') {


                if ( $flightBook['type_app'] == 'Web' || $flightBook['type_app'] == 'Application' || $flightBook['type_app'] == 'Api' ) {

                    $DataFlightType .= '<hr style="margin:3px">';

                    $DataFlightType .= '<a href="' . $transactionLink . '" data-toggle="tooltip" data-placement="top"
                                               data-original-title="مشاهده تراکنش ها"
                                               target="_blank">' . $flightBook['NameAgency'] . '</a><br/>
                                            <hr style="margin:3px">';

                    if ( $flightBook['api_id'] == '1' ) {
                        $DataFlightType .= "سرور5";
                    } elseif ( $flightBook['api_id'] == '5' ) {
                        $DataFlightType .= " سرور 4";
                    } elseif ( $flightBook['api_id'] == '14' ) {
                        $DataFlightType .= " سرور 14";
                    }elseif ( $flightBook['api_id'] == '15' ) {
                        $DataFlightType .= " سرور 15";
                    }elseif ( $flightBook['api_id'] == '16' ) {
                        $DataFlightType .= "سرور 16";
                    } elseif ( $flightBook['api_id'] == '17' ) {
                        $DataFlightType .= "سرور 17";
                    } elseif ( $flightBook['api_id'] == '12' ) {
                        $DataFlightType .= "سرور 12";
                    } elseif ( $flightBook['api_id'] == '13' ) {
                        $DataFlightType .= " سرور 13";
                    } elseif ( $flightBook['api_id'] == '8' ) {
                        $DataFlightType .= "سرور 7";
                    } elseif ( $flightBook['api_id'] == '10' ) {
                        $DataFlightType .= " سرور 9";
                    } elseif ( $flightBook['api_id'] == '11' ) {
                        $DataFlightType .= "سرور 10";
                    }elseif ( $flightBook['api_id'] == '18' ) {
                        $DataFlightType .= "سرور 18";
                    }elseif ( $flightBook['api_id'] == '19' ) {
                        $DataFlightType .= "سرور 19";
                    }elseif ( $flightBook['api_id'] == '20' ) {
                        $DataFlightType .= " سپهر";
                    }elseif ( $flightBook['api_id'] == '21' ) {
                        $DataFlightType .= " چارتر118";
                    }elseif ( $flightBook['api_id'] == '43' ) {
                        $DataFlightType .= " سیتی نت";
                    }

                }
                else {
                    $DataFlightType .= '<a href="' . $transactionLink . '" data-toggle="tooltip" data-placement="top"
                                           data-original-title="مشاهده تراکنش ها"
                                           target="_blank">' . $flightBook['NameAgency'] . '</a>';
                }
                $DataFlightType .= " - ";
                $DataFlightType .=functions::DetectDirection( $flightBook['factor_number'], $flightBook['request_number'] );
            }



            if ( $flightBook['origin_city'] != '' && $flightBook['desti_city'] != '' ) {
                $DataFlightInformation = $flightBook['origin_city'] . "(" . $flightBook['origin_airport_iata'] . ") <hr style='margin:3px'>" . $flightBook['desti_city'] . "(" . $flightBook['desti_airport_iata'] . ")";
            } else {
                $DataFlightCityNameOrigin      = functions::NameCityForeign( $flightBook['origin_airport_iata'] );
                $DataFlightCityNameDestination = functions::NameCityForeign( $flightBook['desti_airport_iata'] );
                $DataFlightInformation         = $DataFlightCityNameOrigin['DepartureCityFa'] . "(" . $flightBook['origin_airport_iata'] . ") <hr style='margin:3px'>" . $DataFlightCityNameDestination['DepartureCityFa'] . "(" . $flightBook['desti_airport_iata'] . ")";
            }
            $DataFlightInformation .= "<hr style='margin:3px'>";
            if ( $flightBook['airline_name'] != "" ) {
                $DataFlightInformation .= $flightBook['airline_name'];
            } else {
                $DataFlightAirlineName = functions::InfoAirline( $flightBook['airline_iata'] );
                $DataFlightInformation .= $DataFlightAirlineName['name_fa'];
            }
            $DataFlightInformation .= "(" . $flightBook['cabin_type'] . ") - " . $flightBook['flight_number'] . " <hr style='margin:3px'> " . $this->DateJalali( $flightBook['date_flight'] ) . " (" . $this->format_hour( $flightBook['time_flight'] ) . ")" ;


            if ( $DataFlightInfoMember['is_member'] == '0' ) {
                //                $DataFlightCounterType=" کاربر مهمان <hr style='margin:3px'>".$flightBook['email_buyer'];
                $DataFlightCounterType = " کاربر مهمان ";
            } else {
                $DataFlightCounterType = $flightBook['member_name'] . "<hr style='margin:3px'> کاربراصلی";
            }
            $DataFlightCounterType .= "<hr style='margin:3px'>" . $this->info_flight( $flightBook['request_number'], $flightBook['member_email'] );

            if ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) {
                $adt_qty            = ( $this->adt_qty ) + $adt_qty;
                $chd_qty            = ( $this->chd_qty ) + $chd_qty;
                $inf_qty            = ( $this->inf_qty ) + $inf_qty;
                $charter_qty_type   = ( ( $this->charter_qty ) + $charter_qty_type );
                $prSystem_qty_type  = ( ( $this->prSystem_qty ) + $prSystem_qty_type );
                $pubSystem_qty_type = ( ( $this->pubSystem_qty ) + $pubSystem_qty_type );
            }
            $DataFlightCounterType .= "<hr style='margin:3px'>";
            if ( $DataFlightInfoMember['is_member'] == '1' ) {
                $DataFlightCounterType .= ( @$flightBook['fk_counter_type_id'] == '5' ? "مسافر" : "کانتر" );
                $DataFlightCounterType .= $flightBook['percent_discount'] . " %ای";
            }
            if ( $flightBook['agency_id'] > '0' ) {
                $DataFlightCounterType .= "<hr style='margin:3px'>" . $flightBook['agency_name'];
            }
            $DataFlightCounterType .= "<hr style='margin:3px'><span class='font11'>" . $flightBook['passenger_name_en'] . " " . $flightBook['passenger_family_en'] . "</span>";

            if ( TYPE_ADMIN == '1' ) {

                $DataFlightCounterType .= '<hr style="margin:3px">' . $flightBook['remote_addr'] . '<hr style="margin:3px">';
                if ( $flightBook['type_app'] == 'Web' ) {
                    $DataFlightCounterType .= 'وب سایت';
                } elseif ( $flightBook['type_app'] == 'Application' ) {
                    $DataFlightCounterType .= 'اپلیکیشن';
                } elseif ( $flightBook['type_app'] == 'Api' ) {
                    $DataFlightCounterType .= 'Api';
                }


            }
            else {

                if ( $flightBook['successfull'] != 'nothing' ) {


                    if ( $flightBook['type_app'] == 'Web' ) {
                        $DataFlightCounterType .= 'وب سایت';
                    } elseif ( $flightBook['type_app'] == 'Application' ) {
                        $DataFlightCounterType .= 'اپلیکیشن';
                    } elseif ( $flightBook['type_app'] == 'Api' ) {
                        $DataFlightCounterType .= 'Api';
                    }

                }

            }

            $TitleDetectDirection=functions::DetectDirection( $flightBook['factor_number'], $flightBook['request_number'] );
            $BuyFromIt=0;
            $this->colorTrByStatusCreditBlak='';
            $this->colorTrByStatusCreditPurple='';

            if ( $flightBook['flight_type'] != 'charterPrivate' ) {
                /*if ( TYPE_ADMIN == '1' ) {
                    $DataFlightTotalFree = '(' . number_format( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] ) . ')';
                    $DataFlightTotalFree .= "<br/>";
                    if ( $flightBook['adt_fare_sum'] > '0' ) {
                        $DataFlightTotalFree .= ( number_format( $flightBook['adt_fare_sum'] + $flightBook['chd_fare_sum'] + $flightBook['inf_fare_sum'] ) );
                    } else {
                        $DataFlightTotalFree .= ( number_format( $DataFlightInfoCommission['supplierCommission'] ) );
                    }
                    if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                        $pricesupplier = $flightBook['supplier_commission'] + $flightBook['irantech_commission'] + $pricesupplier;
                    }
                } else {
                    if ( ( $flightBook['api_id'] == '11' || $flightBook['api_id'] == '13' || $flightBook['api_id'] == '8' ) && $flightBook['flight_type'] == 'system' && $flightBook['pid_private'] == '0' ) {
                        $DataFlightTotalFree = '(' . number_format( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] ) . ')';
                        $DataFlightTotalFree .= "<br/>";
                        if ( $flightBook['adt_fare_sum'] > '0' ) {
                            $DataFlightTotalFree .= ( number_format( $flightBook['adt_fare_sum'] + $flightBook['chd_fare_sum'] + $flightBook['inf_fare_sum'] ) );
                        } else {
                            $DataFlightTotalFree .= ( number_format( $DataFlightInfoCommission['supplierCommission'] ) );
                        }
                    } else {
                        $DataFlightTotalFree = ( number_format( $flightBook['supplier_commission'] ) );
                    }
                    if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                        $pricesupplier +=  $flightBook['supplier_commission'] ;
                    }
                }*/
                //Ardalani1404
                if($TitleDetectDirection!='دوطرفه-برگشت') {
                    $BuyFromIt=$transactions[$flightBook['factor_number']];//خرید از سفر30
                    $DataFlightTotalFree = number_format($BuyFromIt);
                    if ($flightBook['request_cancel'] != 'confirm' && ($flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve')) {
                        if ( TYPE_ADMIN == 1 && strpos($flightBook['serviceTitle'], 'Public') === 0) { //محاسبه اعتبار فعلی مشتری
                            $DataFlightTotalFree.=$this->CalculateCurrentCredit($flightBook['client_id'],$flightBook['factor_number'],$BuyFromIt);
                        }
                        $pricesupplier += $BuyFromIt;
                    }
                }
                else{
                    $DataFlightTotalFree ='0';
                }

            }
            else {
                $DataFlightTotalFree = "0";
            }

            if ( $flightBook['flight_type'] != 'charterPrivate' ) {
                $DataFlightTotal = number_format($flightBook['provider_adt_price'] + $flightBook['provider_chd_price'] + $flightBook['provider_inf_price']);
                $DataFlightFare = $flightBook['flight_type'] == 'system' ? number_format($flightBook['adt_fare_sum'] + $flightBook['chd_fare_sum'] + $flightBook['inf_fare_sum']) : '_';
            }
            else {
                $DataFlightTotal = '_';
                $DataFlightFare = '_';
            }


            if (
                ($flightBook['flight_type'] == 'system' && $flightBook['IsInternal'] == '1') ||
                ($flightBook['flight_type'] == 'system' && $flightBook['IsInternal'] == '0' && $flightBook['foreign_airline'] == '0')
            ) {
                $DataFlightProvider = number_format(($flightBook['provider_adt_price'] + $flightBook['provider_chd_price'] + $flightBook['provider_inf_price']) - ($flightBook['sum_system_flight_commission']));
            } else {
                $DataFlightProvider = number_format(($flightBook['provider_adt_price'] + $flightBook['provider_chd_price'] + $flightBook['provider_inf_price']));
            }

            $DataFlightitCom = 0;

            if ( TYPE_ADMIN == 1 ) {
                $DataFlightIranTechCommission = "";
                if ( $flightBook['flight_type'] != 'charterPrivate' ) {
                    $ClssirantechCommission = 'text-inverse';
                    if($flightBook['irantech_commission'] > 0){
                        $ClssirantechCommission = 'text-success';
                    }elseif($flightBook['irantech_commission'] < 0){
                        $ClssirantechCommission = 'text-danger';
                    }
                    $DataFlightIranTechCommission ='<span class="'.$ClssirantechCommission.' rounded-xl py-1 px-3 text-white d-inline-block" style="direction:ltr">'.number_format($flightBook['irantech_commission']).'</span>';
                    if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                        $priceMe += $flightBook['irantech_commission'] ;
                    }
                } else {
                    $DataFlightIranTechCommission = '---';
                }
            }

            $PassengerPayment=0;
            if ( $flightBook['flight_type'] != 'charterPrivate' ) {
                if ( $flightBook['flight_type'] == 'charter' ||  $flightBook['api_id'] == '14' ) {
                    if ( $flightBook['percent_discount'] > 0 ) {
                        $PassengerPayment=functions::CalculateDiscount( $flightBook['request_number'], 'yes' );
                        $DataFlightPassengerPayData = number_format( ($PassengerPayment + $flightBook['sum_amount_added']) );
                        if(TYPE_ADMIN != 1){
                            $DataFlightPassengerPayData .= "<hr style='margin:3px'><span style='text-decoration: line-through;'>";
                            $DataFlightPassengerPayData .= number_format( $flightBook['agency_commission'] + $flightBook['supplier_commission'] + $flightBook['irantech_commission'] )
                                . '</span>';
                        }

                        if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                            $pricetotal    = ( $flightBook['agency_commission'] + $flightBook['supplier_commission'] + $flightBook['irantech_commission'] ) + $pricetotal;
                            $charter_price = $flightBook['agency_commission'] + $flightBook['supplier_commission'] + $flightBook['irantech_commission'] + $charter_price;
                        }
                    } else {
                        $PassengerPayment=functions::CalculateDiscount( $flightBook['request_number'], 'yes' );
                        $DataFlightPassengerPayData = number_format(($PassengerPayment + $flightBook['sum_amount_added']));

                        if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                            $pricetotal    = ( $flightBook['agency_commission'] + $flightBook['irantech_commission'] + $flightBook['supplier_commission'] ) + $pricetotal;
                            $charter_price = $flightBook['agency_commission'] + $flightBook['irantech_commission'] + $flightBook['supplier_commission'] + $charter_price;
                        }
                    }
                }
                elseif ( $flightBook['flight_type'] == 'system' ) {
                    if ( $flightBook['percent_discount'] > 0 ) {
                        $PassengerPayment=functions::CalculateDiscount( $flightBook['request_number'], 'No' );
                        $DataFlightPassengerPayData = number_format(($PassengerPayment + $flightBook['sum_amount_added']));
                        if(TYPE_ADMIN != 1){
                            $DataFlightPassengerPayData .= "<hr style='margin:3px'> <span style='text-decoration: line-through;'>";
                            $DataFlightPassengerPayData .= $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] . '</span>';
                        }
                        if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                            $pricetotal = ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] ) + $pricetotal;
                            if ( $flightBook['pid_private'] == '1' ) {
                                $prsystem_price += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                            } else {
                                $pubsystem_price += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                            }
                        }

                    } else {
                        if ( $flightBook['IsInternal'] == '0' ) {
                            $PassengerPayment=functions::CalculateDiscount( $flightBook['request_number'], 'No' );
                            $DataFlightPassengerPayData = number_format( ($PassengerPayment + $flightBook['sum_amount_added']) );
                        } else {
                            $PassengerPayment=$flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] ;
                            $DataFlightPassengerPayData = number_format(($PassengerPayment + $flightBook['sum_amount_added']));
                        }
                        if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                            $pricetotal = ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] ) + $pricetotal;
                            if ( $flightBook['pid_private'] == '1' ) {
                                $prsystem_price += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                            } else {
                                $pubsystem_price += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                            }
                        }
                    }

                }
            }
            else {
                $InfoTicketReservation = $this->getInfoTicketReservation( $flightBook['request_number'] );
                if (TYPE_ADMIN != 1 && $InfoTicketReservation['totalPriceWithoutDiscount'] != 0 ) {
                    $DataFlightPassengerPayData = "<span style='text-decoration: line-through;'>" . number_format( $InfoTicketReservation['totalPriceWithoutDiscount'], 0, ".", "," ) . "</span><hr style='margin:3px'>";
                }
                $PassengerPayment=$InfoTicketReservation['totalPrice'];
                $DataFlightPassengerPayData .= number_format( $PassengerPayment, 0, ".", "," );
                $pricetotal                 = ( $InfoTicketReservation['totalPrice'] ) + $pricetotal;
            }

            if (
                ($flightBook['flight_type'] == 'system' && $flightBook['IsInternal'] == '1') ||
                ($flightBook['flight_type'] == 'system' && $flightBook['IsInternal'] == '0' && $flightBook['foreign_airline'] == '0')
            ) {
                $DataFlightPassengerPayData1 = " _ ";
            } else {
                $DataFlightPassengerPayData1 = number_format($flightBook['agency_commission']);
            }

            $DataFlightPassengerPayData2 = number_format($flightBook['sum_amount_added']);







            if ( $flightBook['flight_type'] == 'charter' || $flightBook['flight_type'] == 'system' ) {
                if($TitleDetectDirection=='دوطرفه-برگشت'){//تو ردیف رفت محاسبه میشه
                    $ArrInfoAgancyShare[$flightBook['factor_number']]['SellingReturnPassengerTickets']=$PassengerPayment;
                    $DataFlightAgencyShare ='--- <br>';
                    $DataFlightitAgencyCommission ='---';
                }
                else {

                    if($TitleDetectDirection=='دوطرفه-رفت'){//تو ردیف رفت باید حساب برگشت رو هم کنیم
                        $agencyShare = $flightBook['successfull'] == 'book' ? ($PassengerPayment+ $ArrInfoAgancyShare[$flightBook['factor_number']]['SellingReturnPassengerTickets'] + $flightBook['sum_amount_added'])- $BuyFromIt : 0;
                    }else{
                        $agencyShare = $flightBook['successfull'] == 'book' ? ($PassengerPayment + $flightBook['sum_amount_added']) - $BuyFromIt : 0;
                    }
                    $ClssShare = 'text-inverse';
                    if($agencyShare > 0){
                        $ClssShare = 'text-success';
                    }
                    elseif($agencyShare < 0){
                        $ClssShare = 'text-danger';
                    }

                    $ClssShare2 = 'text-inverse';
                    if($flightBook['sum_system_flight_commission'] > 0){
                        $ClssShare2 = 'text-success';
                    }
                    elseif($flightBook['sum_system_flight_commission'] < 0){
                        $ClssShare2 = 'text-danger';
                    }

                    $DataFlightAgencyShare ='<span class="'.$ClssShare.' font-bold rounded-xl py-1 px-3 text-white d-inline-block" style="direction:ltr; margin:3px;">'.number_format($agencyShare).'</span> <br>';//پرداخت مسافر - خرید از ما
                    $DataFlightitAgencyCommission ='<span class="'.$ClssShare2.' font-bold rounded-xl py-1 px-3 text-white d-inline-block" style="direction:ltr; margin:3px;">'.number_format($flightBook['sum_system_flight_commission']).'</span> <br>';//پرداخت مسافر - خرید از ما
                    if ($flightBook['request_cancel'] != 'confirm' && ($flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve')) {
                        $priceAgency += $agencyShare;
                    }
                }

            }
            else {
                $DataFlightAgencyShare = '--- <br>';
                $DataFlightitAgencyCommission = '---';
            }

            $DataFlightitAgencyCommissionProvider = number_format($flightBook['sum_adt_com'] + $flightBook['sum_chd_com'] + $flightBook['sum_inf_com']);

            if ( $flightBook['type_app'] == 'Web' || $flightBook['type_app'] == 'Application' || $flightBook['type_app'] == 'Api' ) {
                if ( $flightBook['successfull'] == 'nothing' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;"
                                               class="btn btn-default cursor-default popoverBox  popover-default"
                                               data-toggle="popover" title="انصراف از خرید" data-placement="right"
                                               data-content="مسافر از تایید نهایی استفاده نکرده است"> انصراف از
                                                خرید </a>';
                } elseif ( $flightBook['successfull'] == 'error') {
                    $DataFlightAgencyShare .= $this->btnErrorFlight($flightBook);
                } elseif ( $flightBook['successfull'] == 'prereserve' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-warning cursor-default">
                                                پیش رزرو </a>';
                } elseif ( $flightBook['successfull'] == 'bank' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;"
                                               class="btn btn-primary cursor-default popoverBox  popover-primary"
                                               data-toggle="popover" title="هدایت به درگاه" data-placement="right"
                                               data-content="مسافر به درگاه بانکی منتقل شده است و سیستم در انتظار بازگشت از بانک است ،این خرید فقط در صورتی که بانک به سیستم کد تایید پرداخت را بدهد تکمیل میشود">
                                                هدایت به درگاه </a>';
                } elseif ( $flightBook['successfull'] == 'credit' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-default cursor-default ">
                                                انتخاب گزینه اعتباری </a>';
                } elseif ( $flightBook['successfull'] == 'processing' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-primary cursor-primary ">در حال پردازش</a>';
                }elseif ( $flightBook['successfull'] == 'pending' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-print cursor-warning ">در حال صدور</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1' && $flightBook['api_id'] == '1' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اختصاصی سرور 5</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['private_m4'] == '1' && $flightBook['IsInternal'] == '0' && $flightBook['api_id'] == '10' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو
                                                اختصاصی سرور 9</a>';
                } elseif ( $flightBook['successfull'] == 'book' && $flightBook['private_m4'] == '1' && $flightBook['IsInternal'] == '0' && $flightBook['api_id'] == '10' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو سرور 9</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['private_m4'] == '1' && $flightBook['IsInternal'] == '1' && $flightBook['api_id'] == '5' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو
                                                اختصاصی سرور 4</a>';
                } elseif ( $flightBook['successfull'] == 'book' && $flightBook['api_id'] == '11' && TYPE_ADMIN == '1' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-info cursor-default">
                                                اشتراکی سرور 10</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['api_id'] == '14' && TYPE_ADMIN == '1' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-info cursor-default">
                                                اختصاصی سرور 14</a>';
                }elseif (($flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve') && $flightBook['api_id'] == '15' && TYPE_ADMIN == '1' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-info cursor-default">
                                                 رزور قطعی سرور 15</a>';
                }elseif ( ($flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve') && $flightBook['api_id'] == '16' && TYPE_ADMIN == '1' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-info cursor-default">
                                                 رزرو قطعی سرور 16</a>';
                }elseif ( ($flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve') && $flightBook['api_id'] == '17' && TYPE_ADMIN == '1' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-info cursor-default">
                                                 رزرو قطعی سرور 17</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1' && $flightBook['api_id'] == '12' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اختصاصی سرور 12</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1' && $flightBook['api_id'] == '18' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اختصاصی سرور 18</a>';
                }elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1' && $flightBook['api_id'] == '20' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اختصاصی سرور چارتر118</a>';
                }elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1' && $flightBook['api_id'] == '21' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اختصاصی سرور 20</a>';
                }elseif ( $flightBook['successfull'] == 'book' && $flightBook['pid_private'] == '0' && $flightBook['api_id'] == '13' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اشتراکی سرور 13</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1' && $flightBook['IsInternal'] == '1' && $flightBook['api_id'] == '13' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو
                                                اختصاصی سرور 13</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1'  && $flightBook['api_id'] == '8' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو
                                                اختصاصی سرور 7</a>';
                }elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1' && $flightBook['IsInternal'] == '1' && $flightBook['api_id'] == '19' ) {
                    $DataFlightAgencyShare .= '<a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو
                                                اختصاصی سرور 19</a>';
                } elseif ( $flightBook['successfull'] == 'book' ) {
                    if ( $flightBook['request_cancel'] == 'confirm' ) {
                        $DataFlightAgencyShare .= '<a class="btn btn-danger cursor-default" onclick="return false;">کنسل شده</a>';
                    } else {
                        $DataFlightAgencyShare .= '<a class="btn btn-success cursor-default" onclick="return false;"> رزرو قطعی <p style="margin: 0; font-family: arial; cursor: text;user-select: text;"> ' . $flightBook['pnr'] . '</p></a> ';
                    }
                }
                if(TYPE_ADMIN !='1')
                {
                    $client_id = CLIENT_ID ;
                    //&& ($flightBook['pid_private']=='1' || in_array($client_id,functions::clientsForDisplaySourceName()))
                    if ( $flightBook['api_id'] == '14' && ($flightBook['pid_private']=='1') ) {
                        $DataFlightAgencyShare .= "<hr style='margin:3px'> رزرو از منبع پرتو";
                    } elseif ($flightBook['api_id'] == '8' && ($flightBook['pid_private']=='1') ) {
                        $DataFlightAgencyShare .= "<hr style='margin:3px'> رزرو از منبع چارتر724";
                    }
                }
                if ( $flightBook['private_m4'] == '1' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                    if ( $flightBook['pid_private'] == '1' && $flightBook['successfull'] == 'private_reserve' ) {
                        $DataFlightAgencyShare .= '<hr style="margin:3px">
                                                <a id="Jump2Step' . $flightBook['request_number'] . '"
                                                   onclick="changeFlagBuyPrivate(' . $flightBook['request_number'] . ')"
                                                   href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearch?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-shopping-cart"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="برای ادامه خرید از سرور 5 کلیک نمائید"
                                                       id="i_Jump2Step' . $flightBook['request_number'] . '"></i></a>';
                    } elseif ( $flightBook['is_done_private'] == '2' && $flightBook['pid_private'] == '1' && $flightBook['successfull'] == 'private_reserve' ) {
                        $DataFlightAgencyShare .= '<hr style="margin:3px">
                                                <a id="nextChangeFlag"
                                                   onclick="changeFlagBuyPrivate(' . $flightBook['request_number'] . ')"
                                                   href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearch?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-refresh"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="در حال رزرو"></i></a>';
                    }
                    if ( $flightBook['pid_private'] == '1' && $flightBook['private_m4'] == '1' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) && ( TYPE_ADMIN == '1' ) ) {
                        $DataFlightAgencyShare .= '<a id="Jump2StepSourceFour' . $flightBook['request_number'] . '"
                                                   onclick="changeFlagBuyPrivateToPublic(' . $flightBook['request_number'] . ')"
                                                   href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearchSourceFour?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-search"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="برای ادامه خرید از سرور 10 کلیک نمائید"
                                                       id="Jump2StepSourceFour' . $flightBook['request_number'] . '"></i></a>
                                                <a id="Jump2StepSourceFour' . $flightBook['request_number'] . '"
                                                   onclick="changeFlagBuyPrivateToPublic(' . $flightBook['request_number'] . ')"
                                                   href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearchSourceFour?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '&SourceId=8"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-search"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="برای ادامه خرید از سرور 7 کلیک نمائید"
                                                       id="Jump2StepSourceFour' . $flightBook['request_number'] . '"></i></a>';
                    }
                }
                if ( $flightBook['pnr'] == '' && $flightBook['successfull'] == 'book' && TYPE_ADMIN == '1' && $flightBook['api_id'] == '10' ) {
                    $DataFlightAgencyShare .= '<hr style="margin:3px"/><a id="Jump2StepSourceFour' . $flightBook['request_number'] . '"
                                               onclick="changeFlagBuyPrivateToPublic(' . $flightBook['request_number'] . ')"
                                               href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatSearchSourceNine?RequestNumber=' . $flightBook['request_number'] . '&TypeLevel=Final"
                                               target="_blank">
                                                <i class="fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-amazon"
                                                   data-toggle="tooltip" data-placement="right" title=""
                                                   data-original-title="برای ادامه خرید از سرور 9 کلیک نمائید"
                                                   id="Jump2StepSourceFour' . $flightBook['request_number'] . '"></i></a>';
                }
                if ( $flightBook['pnr'] == '' && $flightBook['successfull'] == 'book' && TYPE_ADMIN == '1' ) {
                    if ( $flightBook['api_id'] == '11' ) {
                        $DataFlightAgencyShare .= '<hr style="margin:3px"/><a id="Jump2StepSourceFour' . $flightBook['request_number'] . '"
                                               onclick="changeFlagBuySystemPublic(' . $flightBook['request_number'] . ')"
                                                   href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearch?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '&Type=M10"
                                               target="_blank">
                                                <i class="fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-shopping-cart"
                                                   data-toggle="tooltip" data-placement="right" title=""
                                                   data-original-title="برای ادامه خرید از سرور 10 کلیک نمائید"
                                                   id="i_Jump2StepPublic' . $flightBook['request_number'] . '"></i></a>';
                    } elseif ( $flightBook['public_system_status'] == '2' && $flightBook['successfull'] == 'book' ) {
                        $DataFlightAgencyShare .= '<hr style="margin:3px">
                                                    <a id="nextChangeFlag"
                                                       onclick="changeFlagBuyPrivate(' . $flightBook['request_number'] . ')"
                                                       href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearch?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '"
                                                       target="_blank">
                                                        <i class="fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-refresh"
                                                           data-toggle="tooltip" data-placement="right" title=""
                                                           data-original-title="در حال رزرو"></i></a>';
                    }

                    if ( $flightBook['api_id'] == '11' && $flightBook['pnr'] == '' && ( $flightBook['successfull'] == 'book' ) && ( TYPE_ADMIN == '1' ) ) {
                        $DataFlightAgencyShare .= '<a id="Jump2StepPublic' . $flightBook['request_number'] . '"
                                                       onclick="changeFlagBuyPrivateToPublic(' . $flightBook['request_number'] . ')"
                                                       href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearchSourceFour?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '"
                                                       target="_blank">
                                                        <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-search"
                                                           data-toggle="tooltip" data-placement="right" title=""
                                                           data-original-title="برای ادامه خرید از سرور 10 کلیک نمائید"
                                                           id="i_Jump2StepPublic' . $flightBook['request_number'] . '"></i></a>';
                    }

                }

                $flightBook['sub_agency'] ? $DataFlightAgencyShare .= ' <hr style="margin:3px"> آژانس همکار:'.$flightBook['NameAgency'] .'<hr style="margin:3px">' : '';
            }
            else {

                if ( $flightBook['successfull'] == 'book' ) {
                    if ( $flightBook['request_cancel'] == 'confirm' ) {
                        $DataFlightCondition = '<a class="btn btn-danger cursor-default" onclick="return false;">کنسل شده</a>';
                    } else {
                        $DataFlightAgencyShare .= '<a class="btn btn-success cursor-default" onclick="return false;"> رزرو قطعی <p style="margin: 0;cursor: text;user-select: text;"> ' . $flightBook['pnr'] . '</p></a> ';

                    }
                } elseif ( $flightBook['successfull'] == 'prereserve' ) {
                    $DataFlightAgencyShare .= '<a class="btn btn-warning cursor-default" onclick="return false;">پیش رزرو</a>';
                } elseif ( $flightBook['successfull'] == '' ) {
                    $DataFlightAgencyShare .= '<a class="btn btn-danger cursor-default" onclick="return false;">نامشخص</a>';
                } elseif ( $flightBook['successfull'] == 'bank' ) {
                    $DataFlightAgencyShare .= '<a class="btn btn-danger cursor-default" onclick="return false;">هدایت به درگاه</a>';
                } else {
                    $DataFlightAgencyShare .= '<a class="btn btn-danger cursor-default" onclick="return false;">نامشخص</a>';
                }
                $DataFlightAgencyShare .= '<hr style="margin:3px">بلیط رزرواسیون';
            }

            if ( TYPE_ADMIN == '1' ) {
                if ( $flightBook['type_app'] == 'Web' || $flightBook['type_app'] == 'Application' || $flightBook['type_app'] == 'Api' ) {
                    if ( $flightBook['successfull'] != 'nothing' ) {
                        $DataFlightAgencyShare .= '<div class="btn-group m-r-10" style="margin-top:3px">
                                                    <button aria-expanded="false" data-toggle="dropdown"
                                                            class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                            type="button"> عملیات <span class="caret"></span></button>
                                                    <ul role="menu" class="dropdown-menu animated flipInY mainTicketHistory-operation">
                                                        <li>
                                                            <div class="pull-left">
                                                                <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] != 'nothing' ) {
                            $DataFlightAgencyShare .= '<a onclick="ModalShowBookForFlight(' . "'" . $flightBook['request_number'] . "'" . ');return false" data-toggle="modal" data-target="#ModalPublic"> <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="مشاهده خرید"></i> </a>';
                        }
                        $DataFlightAgencyShare .= '</div>

                        <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                            $DataFlightAgencyShare .= "<a href='" . SERVER_HTTP . $flightBook['DomainAgency'] . "/gds/pdf&target=boxCheck&id=" . $flightBook['request_number'] . "'
                                                                           target='_blank'>
                                                                            <i class='fcbtn btn btn-outline btn-warning btn-1c  tooltip-warning fa fa-money'
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title=' قبض صندوق'></i></a>";
                        }
                        $DataFlightAgencyShare .= '</div>

                        <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                            $DataFlightAgencyShare .= "<a href='" . SERVER_HTTP . $flightBook['DomainAgency'] . "/gds/pdf&target=boxCheckCostumer&id=" . $flightBook['request_number'] . "'
                                                                           target='_blank'>
                                                                            <i class='fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-money '
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title=' قبض صندوق به تفکیک مشتریان'></i></a>";
                        }
                        $DataFlightAgencyShare .= '</div>';
                        if ( $flightBook['IsInternal'] == '1' ) {
                            $DataFlightAgencyShare .= "<div class='pull-left margin-10'>";
                            if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                                if($flightBook['direction']=='TwoWay' && $flightBook['api_id']=='14'){
                                    $DataFlightAgencyShare .= "<a href='" . SERVER_HTTP . $flightBook['DomainAgency'] . "/gds/pdf&target=TicketTwoWay&id=" . $flightBook['request_number'] . "'
                                                                           target='_blank'>
                                                                            <i class='fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o '
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title='بلیط پارسی'></i></a>";
                                }else{
                                    $DataFlightAgencyShare .= "<a href='" . SERVER_HTTP . $flightBook['DomainAgency'] . "/gds/pdf&target=parvazBookingLocal&id=" . $flightBook['request_number'] . "&lang=fa'
                                                                           target='_blank'>
                                                                            <i class='fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o '
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title='بلیط پارسی'></i></a>";
                                }

                            }
                            $DataFlightAgencyShare .= '</div>';
                        }

                        $DataFlightAgencyShare .= '<div class="pull-left margin-10">';
                        if ( $flightBook['IsInternal'] == '1' ) {
                            if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                                $DataFlightAgencyShare .= "<a href='" . SERVER_HTTP . $flightBook['DomainAgency'] . "/gds/pdf&target=parvazBookingLocal&id=" . $flightBook['request_number'] . "&lang=en'
                                                                           target='_blank' title='دانلود بلیط(pdf)'>
                                                                            <i class='fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-file-pdf-o'
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title=' بلیط انگلیسی '></i></a>";
                            }
                        } else {
                            if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                                $DataFlightAgencyShare .= "<a href='" . SERVER_HTTP . $flightBook['DomainAgency'] . "/gds/pdf&target=ticketForeign&id=" . $flightBook['request_number'] . "'
                                                                           target='_blank' title='دانلود بلیط(pdf)'>
                                                                            <i class='fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-file-pdf-o'
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title='چاپ بلیط'></i></a>";
                            }
                        }
                        $DataFlightAgencyShare .= '</div><div class="pull-left margin-10">';
                        if ( $flightBook['IsInternal'] == '1' && ($flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' )) ) {
                            $DataFlightAgencyShare .= "<a href='" . SERVER_HTTP . $flightBook['DomainAgency'] . "/gds/pdf&target=parvazBookingLocal&id=" . $flightBook['request_number'] . "&cash=no'
                                                                           target='_blank'>
                                                                            <i class='fcbtn btn btn-outline btn-default btn-1c tooltip-default fa fa-ticket '
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title=' بلیط بدون قیمت '></i>
                                                                               </a>
                                                                               ";
                        }
                        $DataFlightAgencyShare .= '</div>
                                            <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                            $DataFlightAgencyShare .= ' <a 
                                                       onclick="ModalCancelFlightAdmin(' . "'" . $flightBook['request_number'] . "'" .  ",'" ."flight'"  . '); return false ;"
                                                       target="_blank"
                                                       data-toggle="modal"
                                                       data-target="#ModalPublic"
                                                       >
                                                        <i class="fcbtn btn btn-outline btn-danger btn-1c tooltip-danger mdi mdi-close"
                                                           data-toggle="tooltip"
                                                           data-placement="top"
                                                           title=""
                                                           data-original-title="استرداد"
                                                           >
                                                        </i>
                                                    </a>';
                        }
                        $DataFlightAgencyShare .= '</div>';

                        if ( ($flightBook['successfull'] == 'bank' || $flightBook['successfull'] == 'credit'|| $flightBook['successfull'] == 'pending' || $flightBook['successfull'] == 'processing') && TYPE_ADMIN == '1') {
                            $DataFlightAgencyShare .= "<div class='pull-left margin-10'><a onclick='DonePreReserve(" . '"' . $flightBook['request_number'] . '"' . "," . '"' . $flightBook['factor_number'] . '"' . "," . '"' . $flightBook['client_id'] . '"' . "); return false ;'
                                                                           id='sendSms" . $flightBook['request_number'] . "' target='_blank'>
                                                                            <i class='fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-times'
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title='برای پیش رزرو کردن بلیط کلیک نمائید'></i></a></div>";
                        }
                        //                        if( ($flightBook['pid_private'] == '1' || $flightBook['api_id'] == '11' || $flightBook['api_id'] == '8' ) && ($flightBook['successfull'] == 'private_reserve' || $flightBook['successfull'] == 'book') && TYPE_ADMIN == '1'){
                        if ( TYPE_ADMIN == '1' ) {
                            $DataFlightAgencyShare .= "<div class='pull-left margin-10'><a onclick='insertPnr(" . '"' . $flightBook['request_number'] . '"' . "," . '"' . $flightBook['client_id'] . '"' . "); return false ;'
                                                   id='sendSms" . $flightBook['request_number'] . "' target='_blank' data-toggle='modal' data-target='#ModalPublic'>
                                                    <i class='fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-book'
                                                       data-toggle='tooltip'
                                                       data-placement='top' title=''
                                                       data-original-title='برای قطعی کردن و وارد کردن pnr کلیک کنید'></i></a></div>";
                        }

                        if(TYPE_ADMIN == '1' && $BuyFromIt == 0 && $flightBook['request_cancel'] != 'confirm' &&
                            ($flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve') &&
                            (strpos($flightBook['serviceTitle'], 'Public') === 0 && $flightBook['pid_private'] == '0' ) &&
                            $TitleDetectDirection!='دوطرفه-برگشت'
                        ) {
                            $DataFlightAgencyShare .= '<div class="pull-left margin-10">
                                 <button data-factor-number="' . $flightBook['factor_number'] . '" data-service="flight"
                                        style="margin: 5px auto;" class="set-transaction fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-book"
                                       data-toggle="tooltip" data-placement="top" title="ثبت تراکنش"
                                       data-original-title="ثبت تراکنش">
                                </button></div>';
                        }
                        $DataFlightAgencyShare .= '<div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'credit' && TYPE_ADMIN == '1' ) ) {

                            $DataFlightAgencyShare .= ' <a onclick="ModalSendSms(' . "'" . $flightBook['request_number'] . "'" . ');return false"
                                                       id="sendSms' . $flightBook['request_number'] . '"
                                                       target="_blank"
                                                       data-toggle="modal"
                                                       data-target="#ModalPublic">
                                                        <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-envelope-o"
                                                           data-toggle="tooltip"
                                                           data-placement="top"
                                                           title=""
                                                           data-original-title="برای ارسال پیام کلیک کنید"></i>
                                                    </a>';
                        }


                        $DataFlightAgencyShare .= '</div>';



                        if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && ( TYPE_ADMIN == '1' || CLIENT_ID == '23' ) ) ) {
                            $DataFlightAgencyShare .= "<div class='pull-left margin-10'><a onclick='ModalSendInteractiveSms(" . '"' . $flightBook['factor_number'] . '"' . "); return false ;'
                                                                           id='sendSms" . $flightBook['request_number'] . "' target='_blank' data-toggle='modal' data-target='#ModalPublic'>
                                                                            <i class='fcbtn btn btn-outline btn-warning btn-1c  tooltip-warning fa fa-share'
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title='برای ارسال مجدد کد ترانسفر کلیک کنید'></i></a></div>";
                        }

                        if(TYPE_ADMIN == '1' &&
                            ($flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve')
                        ) {
                            $DataFlightAgencyShare .= "<div class='pull-left margin-10'>
                                                        <a onclick='editInfoPassenger(" . '"' . $flightBook['request_number'] . '"' . "," . '"' . $flightBook['client_id'] . '"' . "); return false ;'
                                                           id='editPassenger{$flightBook['request_number']}'
                                                           target='_blank'
                                                           data-toggle='modal' data-target='#ModalPublic'>
                                                           <i class='fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-user-edit'
                                                                   data-toggle='tooltip'
                                                                   data-placement='top' title=''
                                                                   data-original-title='ویرایش اطلاعات مسافران'></i>
                                                        </a>
                                                    </div>";
                        }
                        $DataFlightAgencyShare .= "</div> </li> </ul> </div> <hr style='margin:3px'>";

                    }
                }
                else {
                    if ( $flightBook['successfull'] != 'nothing') {
                        $DataFlightAgencyShare .= '<div class="btn-group m-r-10" style="margin-top:3px">

                                                <button aria-expanded="false" data-toggle="dropdown"
                                                        class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                        type="button"> عملیات <span class="caret"></span></button>

                                                <ul role="menu" class="dropdown-menu animated flipInY mainTicketHistory-operation">
                                                    <li>
                                                        <div class="pull-left">

                                                            <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] != 'nothing' ) {
                            $DataFlightAgencyShare .= '<a onclick="ModalShowBookForFlight(' . "'" . $flightBook['request_number'] . "'" . ');return false"
                                                                       data-toggle="modal"
                                                                       data-target="#ModalPublic">
                                                                        <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                                           data-toggle="tooltip"
                                                                           data-placement="top" title=""
                                                                           data-original-title="مشاهده خرید"></i>
                                                                    </a>';
                        }
                        $DataFlightAgencyShare .= '</div><div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' ) {
                            $DataFlightAgencyShare .= '<a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/pdf&target=BookingReservationTicket&id=' . $flightBook['request_number'] . '"
                                                                       target="_blank">
                                                                        <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                                           data-toggle="tooltip"
                                                                           data-placement="top" title=""
                                                                           data-original-title=" بلیط پارسی "></i>
                                                                    </a>';
                        }
                        $DataFlightAgencyShare .= '</div> </div> </li> </ul> </div> <hr style="margin:3px">';
                    }
                }
            }
            else {
                if ( $flightBook['successfull'] != 'nothing' ) {
                    if ( $flightBook['type_app'] == 'Web' || $flightBook['type_app'] == 'Application' ) {
                        $DataFlightAgencyShare .= ' <div class="btn-group m-r-10" style="margin-top:3px">
    
                                                        <button aria-expanded="false" data-toggle="dropdown"
                                                                class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                                type="button"> عملیات <span class="caret"></span></button>
    
                                                        <ul role="menu" class="dropdown-menu animated flipInY mainTicketHistory-operation">
                                                            <li>
                                                                <div class="pull-left">
                                                                    <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] != 'nothing' ) {

                            $DataFlightAgencyShare .= '<a onclick="ModalShowBook(' . "'" . $flightBook['request_number'] . "'" . ');return false"
                                                                           data-toggle="modal"
                                                                           data-target="#ModalPublic">
                                                                            <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                                               data-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title=""
                                                                               data-original-title="مشاهده خرید"></i>
                                                                        </a>';
                        }
                        $DataFlightAgencyShare .= ' </div>

                                                                <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                            $DataFlightAgencyShare .= ' <a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/pdf&target=boxCheck&id=' . $flightBook['request_number'] . '"
                                                                           target="_blank">
                                                                            <i class="fcbtn btn btn-outline btn-warning btn-1c  tooltip-warning fa fa-money "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title=""
                                                                               data-original-title=" قبض صندوق"></i>
                                                                        </a>';
                        }
                        $DataFlightAgencyShare .= ' </div>
 
 

                                                                <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                            $DataFlightAgencyShare .= ' <a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/pdf&target=boxCheckCostumer&id=' . $flightBook['request_number'] . '"
                                                                           target="_blank">
                                                                            <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-money "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title=""
                                                                               data-original-title=" قبض صندوق به تفکیک مشتریان"></i>
                                                                        </a>';
                        }
                        $DataFlightAgencyShare .= ' </div>

                                                                ';
                        if ( $flightBook['successfull'] == 'book' && CLIENT_ID == 271 ) {
                            $DataFlightAgencyShare .= '<div class="pull-left margin-10">';


                            $DataFlightAgencyShare .= ' <a onclick="ModalUploadProof(' . "'" . $flightBook['request_number'] . "'" .  ",'" ."Flight'"  . ');return false"
                                                       id="uploadProof' . $flightBook['request_number'] . '"
                                                       target="_blank"
                                                       data-toggle="modal"
                                                       data-target="#ModalPublic">
                                                        <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-upload"
                                                           data-toggle="tooltip"
                                                           data-placement="top"
                                                           title=""
                                                           data-original-title="آپلود فاکتور"></i>
                                                    </a>';
                            $DataFlightAgencyShare .= '</div>';
                        }

                        if ( ( $flightBook['IsInternal'] == '1' && $flightBook['successfull'] == 'book' ) || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                            $DataFlightAgencyShare .= '<div class="pull-left margin-10"> <a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/pdf&target=parvazBookingLocal&id=' . $flightBook['request_number'] . '&lang=fa"
                                                                           target="_blank">
                                                                            <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title=""
                                                                               data-original-title=" بلیط پارسی "></i>
                                                                        </a></div>';
                        }




                        $DataFlightAgencyShare .= ' <div class="pull-left margin-10">';
                        if ( $flightBook['IsInternal'] == '1' ) {
                            if ( ( $flightBook['IsInternal'] == '1' && $flightBook['successfull'] == 'book' ) || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                                $DataFlightAgencyShare .= ' <a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/pdf&target=parvazBookingLocal&id=' . $flightBook['request_number'] . '&lang=en"
                                                                               target="_blank">
                                                                                <i class="fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-file-pdf-o"
                                                                                   data-toggle="tooltip"
                                                                                   data-placement="top"
                                                                                   title=""
                                                                                   data-original-title=" بلیط انگلیسی "></i>
                                                                            </a>';
                            }
                        } else {
                            if ( ( $flightBook['successfull'] == 'book' ) || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {

                                $DataFlightAgencyShare .= ' <a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/pdf&target=ticketForeign&id=' . $flightBook['request_number'] . '"
                                                                               target="_blank">
                                                                                <i class="fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-file-pdf-o"
                                                                                   data-toggle="tooltip"
                                                                                   data-placement="top"
                                                                                   title=""
                                                                                   data-original-title=" بلیط انگلیسی "></i>
                                                                            </a>';
                            }
                        }

                        $DataFlightAgencyShare .= ' </div>';

                        $DataFlightAgencyShare .= ' <div class="pull-left margin-10">';
                        if ( $flightBook['IsInternal'] == '1' ) {
                            if ( ( $flightBook['IsInternal'] == '1' && $flightBook['successfull'] == 'book' ) || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                                $DataFlightAgencyShare .= "<a href='" . SERVER_HTTP . $flightBook['DomainAgency'] . "/gds/pdf&target=bookshow&id=" . $flightBook['request_number'] . "&cash=no'
                                                                           target='_blank'>
                                                                            <i class='fcbtn btn btn-outline btn-success btn-1c tooltip-success fa fa-ticket '
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title=' بلیط انگلیسی بدون قیمت '></i></a>";
                            }
                        } else {
                            if ( ( $flightBook['successfull'] == 'book' ) || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                                $DataFlightAgencyShare .= "<a href='" . SERVER_HTTP . $flightBook['DomainAgency'] . "/gds/pdf&target=ticketForeign&id=" . $flightBook['request_number'] . "&cash=no'
                                                                           target='_blank'>
                                                                            <i class='fcbtn btn btn-outline btn-success btn-1c tooltip-success fa fa-ticket '
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title=' بلیط انگلیسی بدون قیمت '></i></a>";
                            }
                        }

                        $DataFlightAgencyShare .= ' </div>';

                        $DataFlightAgencyShare .= '<div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                            $DataFlightAgencyShare .= ' <a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/pdf&target=parvazBookingLocal&id=' . $flightBook['request_number'] . '&cash=no"
                                                       target="_blank">
                                                        <i class="fcbtn btn btn-outline btn-default btn-1c tooltip-default fa fa-ticket "
                                                           data-toggle="tooltip"
                                                           data-placement="top"
                                                           title=""
                                                           data-original-title=" بلیط بدون قیمت "></i>
                                                    </a>';
                        }
                        $DataFlightAgencyShare .= ' </div>

                                                                <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                            $DataFlightAgencyShare .= ' <a 
                                                       onclick="ModalCancelFlightAdmin(' . "'" . $flightBook['request_number'] . "'" .  ",'" ."flight'"  . '); return false ;"
                                                       target="_blank"
                                                       data-toggle="modal"
                                                       data-target="#ModalPublic"
                                                       >
                                                        <i class="fcbtn btn btn-outline btn-danger btn-1c tooltip-danger mdi mdi-close"
                                                           data-toggle="tooltip"
                                                           data-placement="top"
                                                           title=""
                                                           data-original-title="استرداد"
                                                           ></i>
                                                    </a>';
                        }
                        $DataFlightAgencyShare .= ' </div>

                                                                <div class="pull-left margin-10">';
                        if ( TYPE_ADMIN == '1' ) {
                            $DataFlightAgencyShare .= ' <a onclick="ModalSendSms(' . "'" . $flightBook['request_number'] . "'" . ');return false"
                                                       id="SmsSend' . $flightBook['request_number'] . '"
                                                       data-toggle="modal"
                                                       data-target="#ModalPublic">
                                                        <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-envelope-o"
                                                           data-toggle="tooltip"
                                                           data-placement="top"
                                                           title=""
                                                           data-original-title="برای ارسال پیام کلیک کنید"></i>
                                                    </a>';
                        }

                        if ( $flightBook['successfull'] == 'book' ){
                            $DataFlightAgencyShare .= '<a id="SendEmail' . $flightBook['request_number'] . '"
                                                                       onclick="ModalSenEmailForOther(' . "'" . $flightBook['request_number'] . "'" . ( $flightBook['client_id'] != '' ? ",'" . $flightBook['client_id'] . "'" : "" ) . ');return false"
                                                                       data-toggle="modal" data-target="#ModalPublic">
                                                                        <i class="fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-envelope"
                                                                           data-toggle="tooltip" data-placement="top"
                                                                           title=""
                                                                           data-original-title="برای ارسال ایمیل کلیک کنید"></i>
                                                                    </a>
                                                                </div></div>';
                        }


                        $DataFlightAgencyShare .= "<hr style='margin:3px'>";

                        functions::DetectDirection( $flightBook['factor_number'], $flightBook['request_number'] );


                    }
                    else {
                        $DataFlightAgencyShare = '<div class="btn-group m-r-10" style="margin-top:3px">

                                                    <button aria-expanded="false" data-toggle="dropdown"
                                                            class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                            type="button"> عملیات <span class="caret"></span></button>

                                                    <ul role="menu" class="dropdown-menu animated flipInY mainTicketHistory-operation">
                                                        <li>
                                                            <div class="pull-left">

                                                                <div class="pull-left margin-10">';

                        if ( $flightBook['successfull'] !== 'nothing' && $flightBook['successfull'] !== 'error' ) {
                            $DataFlightAgencyShare .= '<a onclick="ModalShowBook(' . "'" . $flightBook['request_number'] . "'" . ');return false"
                                                                           data-toggle="modal"
                                                                           data-target="#ModalPublic">
                                                                            <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title="مشاهده خرید"></i>
                                                                        </a>';
                        }
                        $DataFlightAgencyShare .= '</div> <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' ) {
                            $DataFlightAgencyShare .= '<a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/eReservationTicket&num=' . $flightBook['request_number'] . '"
                                                                           target="_blank"
                                                                           title="مشاهده اطلاعات خرید">
                                                                            <i class="fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-print "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title="مشاهده اطلاعات خرید"></i>
                                                                        </a>';
                        }
                        $DataFlightAgencyShare .= '</div> <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' ) {
                            $DataFlightAgencyShare .= '<a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/pdf&target=BookingReservationTicket&id=' . $flightBook['request_number'] . '"
                                                                           target="_blank">
                                                                            <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title=" بلیط پارسی "></i>
                                                                        </a>';
                        }
                        $DataFlightAgencyShare .= '</div> <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                            $DataFlightAgencyShare .= '<a onclick="ModalCancelAdmin(' . "'flight'," . "'" . $flightBook['request_number'] . "'" . ');return false"
                                                                       target="_blank"  data-toggle="modal"
                                                                       data-target="#ModalPublic">
                                                                        <i class="fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-times "
                                                                           data-toggle="tooltip"
                                                                           data-placement="top" title=""
                                                                           data-original-title=" ثبت درخواست کنسلی پرواز"></i>
                                                                    </a>';
                        }
                        $DataFlightAgencyShare .= '</div> </div> </li> </ul> </div>';


                    }

                    $DataFlightAgencyShare .= '</div> </div> </li> </ul> </div> <hr style="margin:3px">';
                }
            }

            if ( $flightBook['payment_type'] == 'cash' || $flightBook['payment_type'] == 'member_credit' ) {
                if ( $flightBook['payment_type'] == 'cash' ) {
                    $DataFlightAgencyShare .= 'نقدی';
                }
                else {
                    $DataFlightAgencyShare .= 'اعتباری';
                }
                if ( $flightBook['number_bank_port'] == '379918' ) {
                    if ( $flightBook['flight_type'] == 'charter' && $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                        $CashTotalMe += ( $flightBook['agency_commission'] + $flightBook['irantech_commission'] + $flightBook['supplier_commission'] );
                    } elseif ( $flightBook['flight_type'] == 'system' && $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                        $CashTotalMe += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                    }
                } else {
                    if ( $flightBook['flight_type'] == 'charter' && $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                        $CashTotalMe += ( $flightBook['agency_commission'] + $flightBook['irantech_commission'] + $flightBook['supplier_commission'] );
                    } elseif ( $flightBook['flight_type'] == 'system' && $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                        $CashTotalMe += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                    }
                }
            }
            elseif ( $flightBook['payment_type'] == 'credit' ) {
                $DataFlightAgencyShare .= 'اعتباری';
                if ( $flightBook['flight_type'] == 'charter' && $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                    $CreditTotal += ( $flightBook['agency_commission'] + $flightBook['irantech_commission'] + $flightBook['supplier_commission'] );
                } elseif ( $flightBook['flight_type'] == 'system' && $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                    $CreditTotal += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                }

            }
            elseif ( $flightBook['payment_type'] == 'nothing' ) {
                $DataFlightAgencyShare .= 'نا مشخص';
            }
            if ( $flightBook['name_bank_port'] != '' ) {
                if (in_array($flightBook['number_bank_port'],$GetWayIranTech) || $flightBook['number_bank_port'] == '5b8c0bc6-7f26-11ea-b1af-000c295eb8fc' || $flightBook['number_bank_port'] == '379918' ) {
                    $DataFlightAgencyShare .= "درگاه سفر360";
                } else {
                    $DataFlightAgencyShare .= " - درگاه خودش";
                }
            }


            if ( $key >= $param['RowCounter'] ) {
                $FlightDataNewest = 'new';
            } else {
                $FlightDataNewest = 'data';
            }

            if (TYPE_ADMIN == 1) {
                $TitleAgencyShare='<br> سود آژانس <br> وضعیت <br> pnr';
                $TitleBuyFromIt='فروش به آژانس';
                $TitlePayment='آژانس/مس';
                $TitleMarkCounter='مارک کان';
                $TitleMarkAgency='مارک آژ';
                $TitleComAgency='کم آژانس';
                $TitleComAgencyProvider='کم چارتری';
                $TitleNameAgency='نام <br> آژانس';
            }
            else {
                $TitleAgencyShare='<br> سود شما <br> وضعیت <br> pnr';
                $TitleBuyFromIt='<span> خرید از سفر360 </span>';
                $TitlePayment='فروش';
                $TitleMarkCounter='مارک کانتر';
                $TitleMarkAgency='مارک آژانس';
                $TitleComAgency='کمیسیون';
                $TitleComAgencyProvider='کمیسیون چارتری';
                $TitleNameAgency='عملیات';
            }

            $ColorTr='';
            if($flightBook['request_cancel'] != 'confirm' &&
                ($flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve') &&
                strpos($flightBook['serviceTitle'], 'Public') === 0 &&
                $TitleDetectDirection!='دوطرفه-برگشت'
            ){//رزرو قطعی از مدل اشتراکی باشد
                if($this->colorTrByStatusCreditBlak=='Yes'){//اعتبار مشتری منفی هست
                    $ColorTr='#444343';//مشکی
                }
                else if($this->colorTrByStatusCreditPurple=='Yes'){//یعنی اعبار بعد خرید کم نشده
                   $ColorTr='#b0a7dd';//بنفش
               }
               else if($BuyFromIt==0){//رکورد تراکنش مالی ندارد
                    $ColorTr='#f7c2c2';//قرمز
                }
            }


            $FlightData[ $FlightDataNewest ][ $key ]["رنگ"]                                                 = $ColorTr;
            $FlightData[ $FlightDataNewest ][ $key ]["ردیف"]                                                = $CountTicket ++;
            $FlightData[ $FlightDataNewest ][ $key ]["تاریخ خرید<br/>واچر<br/>بلیط<br/>پید"]                = $DataFlightType;
            $FlightData[ $FlightDataNewest ][ $key ]["اطلاعات پرواز"]                                        = $DataFlightInformation;
            $FlightData[ $FlightDataNewest ][ $key ]["نام خریدار <br/> نوع کاربر<br/>تعداد<br/>نوع کانتر <br/> نام مسافر"]  = $DataFlightCounterType;
            $FlightData[ $FlightDataNewest ][ $key ]["total"]                        = $DataFlightTotal;
            $FlightData[ $FlightDataNewest ][ $key ]["fare"]                        = $DataFlightFare;
            ( TYPE_ADMIN == '1' ? $FlightData[ $FlightDataNewest ][ $key ]["خرید از پرووایدر"]                        = $DataFlightProvider : "" );
            ( TYPE_ADMIN == '1' ? $FlightData[ $FlightDataNewest ][ $key ]["it com"]                        = $DataFlightitCom : "" );
            $FlightData[ $FlightDataNewest ][ $key ][$TitleComAgency]                        = $DataFlightitAgencyCommission;
            $FlightData[ $FlightDataNewest ][ $key ][$TitleComAgencyProvider]                        = $DataFlightitAgencyCommissionProvider;
            $FlightData[ $FlightDataNewest ][ $key ][$TitleBuyFromIt]                                       = $DataFlightTotalFree;
            ( TYPE_ADMIN == '1' ? $FlightData[ $FlightDataNewest ][ $key ]["سهم ما"]                        = $DataFlightIranTechCommission : "" );
            $FlightData[ $FlightDataNewest ][ $key ][$TitleMarkAgency]                                         = $DataFlightPassengerPayData1;
            $FlightData[ $FlightDataNewest ][ $key ][$TitleMarkCounter]                                         = $DataFlightPassengerPayData2 ;
            $FlightData[ $FlightDataNewest ][ $key ][$TitlePayment]                                         = $DataFlightPassengerPayData;
            $FlightData[ $FlightDataNewest ][ $key ][$TitleAgencyShare]                                     = $DataFlightAgencyShare;


//            $DataFlightType               = '';
//            $DataFlightInformation        = '';
//            $DataFlightCounterType        = '';
//            $DataFlightTotal        = '';
//            $DataFlightFare        = '';
//            $DataFlightProvider        = '';
//            $DataFlightitCom        = '';
//            $DataFlightIranTechCommission = '';
//            $DataFlightPassengerPayData1        = '';
//            $DataFlightPassengerPayData2        = '';
//            $DataFlightPassengerPayData   = '';
//            $DataFlightAgencyShare        = '';
        }

        $FooterData0 = '<th colspan="2"></th>';
        $FooterData0 .= '<th colspan="2"> 
                              <span class=" fa fa-user" style="margin-left: 5px;">' . $adt_qty . '</span>
                              <span class=" fa fa-child" style="margin-left: 5px;">' . $chd_qty . '</span>
                              <span class=" fa fa-child">' . $inf_qty . '</span> =>
                              <span>' . number_format($adt_qty+$chd_qty+$inf_qty) . '</span> نفر 
                        </th>';
        $FooterData0 .= '<th>' . number_format($pricesupplier) . '</th>';
        if (TYPE_ADMIN == 1) {
            $FooterData0 .= '<th>' . number_format($priceMe) . '</th>';
        }
        $FooterData0 .= '<th>' . number_format($pricetotal) . '</th>';
        $FooterData0 .= '<th>' . number_format($priceAgency) . '</th>';
        $FooterData0 .= '<th colspan="2"></th>';
        $FlightData['footer'][0] = $FooterData0;

        $FooterData1 = '<th colspan="4"></th>';
        $FooterData1 .= '<th>'.$TitleBuyFromIt.'</th>';
        if (TYPE_ADMIN == 1) {
            $FooterData1 .= '<th>سهم ما</th>';
        }
        $FooterData1 .= '<th>'.$TitlePayment.'</th>';
        $FooterData1 .= '<th>'.$TitleAgencyShare.'</th>';
        $FooterData1 .= '<th colspan="2"></th>';
        $FlightData['footer'][1] = $FooterData1;


        return ( empty( $FlightData ) ? null : $FlightData );
    }

    public function MainFlightTicketHistoryWebService( $param ) {
        //        $ListBookLocal=$this->listBookLocal();

        if ( ! empty( $param['member_id'] ) ) {
            $intendedUser  = [
                "member_id" => $param['member_id'],
                "agency_id" => @$param['agency_id']
            ];

            $ListBookLocal = $this->listBookLocalWebService( $intendedUser );
        } else {

            $ListBookLocal = $this->listBookLocalWebService($param);
        }


        $adt_qty            = 0;
        $chd_qty            = 0;
        $inf_qty            = 0;
        $priceAgency        = 0;
        $priceMe            = 0;
        $pricetotal         = 0;
        $prsystem_price     = 0;
        $pubsystem_price    = 0;
        $charter_price      = 0;
        $pricesupplier      = 0;
        $totalQty           = 0;
        $CreditTotal        = 0;
        $charter_qty_type   = 0;
        $prSystem_qty_type  = 0;
        $pubSystem_qty_type = 0;
        $GetWayIranTech     = functions::DataIranTechGetWay();
        $FlightData         = [];
        $CountTicket        = '1';
        $RowCountTicket     = $this->CountTicket;
        foreach ( $ListBookLocal as $key => $flightBook ) {
            $transactionLink          = ROOT_ADDRESS_WITHOUT_LANG . '/itadmin/transactionUser&id=' . $flightBook['client_id'];
            $DataFlightInfoMember     = functions::infoMember( $flightBook['member_id'], $flightBook['client_id'] );
            $DataFlightInfoCommission = functions::CommissionFlightSystemPublic( $flightBook['request_number'] );

            if ( ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                $totalQty = ( $flightBook['adt_qty_f'] + $flightBook['chd_qty_f'] + $flightBook['inf_qty_f'] ) + $totalQty;
            }

            $DataFlightType = dateTimeSetting::jdate( 'Y-m-d (H:i:s)', $flightBook['creation_date_int'] ) . "<hr style='margin:3px'> " . $flightBook['request_number'] . " <hr style='margin:3px'> " . $flightBook['factor_number'] . " <hr style='margin:3px'>";
            if ( $flightBook['flight_type'] == "charter" ) {
                $DataFlightType .= "چارتری <hr style='margin:3px'> چارتر" . ( $flightBook['pid_private'] == '1' ? "اختصاصی" : "اشتراکی" );
            } elseif ( $flightBook['flight_type'] == "system" ) {
                $DataFlightType .= "سیستمی <hr style='margin:3px'>" . ( $flightBook['pid_private'] == '1' ? "پیداختصاصی" : "پید اشتراکی" );
            } elseif ( $flightBook['flight_type'] == "charterPrivate" ) {
                $DataFlightType .= "چارتری <hr style='margin:3px'> رزرواسیون اختصاصی";
            } else {
                $DataFlightType .= "نامشخص";
            }
            if ( $flightBook['origin_city'] != '' && $flightBook['desti_city'] != '' ) {
                $DataFlightInformation = $flightBook['origin_city'] . "(" . $flightBook['origin_airport_iata'] . ")<br/>" . $flightBook['desti_city'] . "(" . $flightBook['desti_airport_iata'] . ")";
            } else {
                $DataFlightCityNameOrigin      = functions::NameCityForeign( $flightBook['origin_airport_iata'] );
                $DataFlightCityNameDestination = functions::NameCityForeign( $flightBook['desti_airport_iata'] );
                $DataFlightInformation         = $DataFlightCityNameOrigin['DepartureCityFa'] . "(" . $flightBook['origin_airport_iata'] . ") <br/> " . $DataFlightCityNameDestination['DepartureCityFa'] . "(" . $flightBook['desti_airport_iata'] . ")";
            }
            $DataFlightInformation .= "<hr style='margin:3px'>";
            if ( $flightBook['airline_name'] != "" ) {
                $DataFlightInformation .= $flightBook['airline_name'];
            } else {
                $DataFlightAirlineName = functions::InfoAirline( $flightBook['airline_iata'] );
                $DataFlightInformation .= $DataFlightAirlineName['name_fa'];
            }
            $DataFlightInformation .= "(" . $flightBook['cabin_type'] . ") <hr style='margin:3px'>" . $flightBook['flight_number'] . " <hr style='margin:3px'> " . $this->format_hour( $flightBook['time_flight'] ) . " <hr style='margin:3px'>" . $this->DateJalali( $flightBook['date_flight'] );


            if ( $DataFlightInfoMember['is_member'] == '0' ) {
                //                $DataFlightCounterType=" کاربر مهمان <hr style='margin:3px'>".$flightBook['email_buyer'];
                $DataFlightCounterType = " کاربر مهمان ";
            } else {
                $DataFlightCounterType = $flightBook['member_name'] . "<hr style='margin:3px'> کاربراصلی";
            }
            $DataFlightCounterType .= "<hr style='margin:3px'>" . $this->info_flight( $flightBook['request_number'], $flightBook['member_email'] );

            if ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) {
                $adt_qty            = ( $this->adt_qty ) + $adt_qty;
                $chd_qty            = ( $this->chd_qty ) + $chd_qty;
                $inf_qty            = ( $this->inf_qty ) + $inf_qty;
                $charter_qty_type   = ( ( $this->charter_qty ) + $charter_qty_type );
                $prSystem_qty_type  = ( ( $this->prSystem_qty ) + $prSystem_qty_type );
                $pubSystem_qty_type = ( ( $this->pubSystem_qty ) + $pubSystem_qty_type );
            }
            $DataFlightCounterType .= "<hr style='margin:3px'>";
            if ( $DataFlightInfoMember['is_member'] == '1' ) {
                $DataFlightCounterType .= ( @$flightBook['fk_counter_type_id'] == '5' ? "مسافر" : "کانتر" );
                $DataFlightCounterType .= $flightBook['percent_discount'] . " %ای";
            }
            if ( $flightBook['agency_id'] > '0' ) {
                $DataFlightCounterType .= "<hr style='margin:3px'>آژانس " . $flightBook['agency_name'];
            }
            if ( $flightBook['flight_type'] == 'charter' || $flightBook['flight_type'] == 'system' ) {
                if ( ( $flightBook['api_id'] == '11' || $flightBook['api_id'] == '13' || $flightBook['api_id'] == '8' ) && ( $flightBook['flight_type'] == 'system' ) && $flightBook['pid_private'] == '0' ) {
                    $DataFlightAgencyShare = ( $flightBook['adt_fare_sum'] > 0 ) ? number_format( $flightBook['agency_commission'] ) : number_format( $DataFlightInfoCommission['agencyCommission'] );
                } else {
                    $DataFlightAgencyShare = number_format( $flightBook['agency_commission'] );
                }
                if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                    $priceAgency +=  $flightBook['agency_commission'] ;
                }
            } else {
                $DataFlightAgencyShare = '---';
            }
            if ( $flightBook['flight_type'] != 'charterPrivate' ) {
                if ( TYPE_ADMIN == '1' ) {
                    $DataFlightTotalFree = '(' . number_format( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] ) . ')';
                    $DataFlightTotalFree .= "<br/>";
                    if ( $flightBook['adt_fare_sum'] > '0' ) {
                        $DataFlightTotalFree .= ( number_format( $flightBook['adt_fare_sum'] + $flightBook['chd_fare_sum'] + $flightBook['inf_fare_sum'] ) );
                    } else {
                        $DataFlightTotalFree .= ( number_format( $DataFlightInfoCommission['supplierCommission'] ) );
                    }
                    if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                        $pricesupplier = $flightBook['supplier_commission'] + $flightBook['irantech_commission'] + $pricesupplier;
                    }
                } else {
                    if ( ( $flightBook['api_id'] == '11' || $flightBook['api_id'] == '13' || $flightBook['api_id'] == '8' ) && $flightBook['flight_type'] == 'system' && $flightBook['pid_private'] == '0' ) {
                        $DataFlightTotalFree = '(' . number_format( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] ) . ')';
                        $DataFlightTotalFree .= "<br/>";
                        if ( $flightBook['adt_fare_sum'] > '0' ) {
                            $DataFlightTotalFree .= ( number_format( $flightBook['adt_fare_sum'] + $flightBook['chd_fare_sum'] + $flightBook['inf_fare_sum'] ) );
                        } else {
                            $DataFlightTotalFree .= ( number_format( $DataFlightInfoCommission['supplierCommission'] ) );
                        }
                    } else {
                        $DataFlightTotalFree = ( number_format( $flightBook['supplier_commission'] ) );
                    }
                    if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                        $pricesupplier +=  $flightBook['supplier_commission'] ;
                    }
                }
            } else {
                $DataFlightTotalFree = "---";
            }

            if ( TYPE_ADMIN == 1 ) {
                $DataFlightIranTechCommission = "";
                if ( $flightBook['flight_type'] != 'charterPrivate' ) {
                    $DataFlightIranTechCommission .= number_format( $flightBook['irantech_commission'] );
                    if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                        $priceMe += $flightBook['irantech_commission'] ;
                    }
                } else {
                    $DataFlightIranTechCommission = '---';
                }
            }

            if ( $flightBook['flight_type'] != 'charterPrivate' ) {
                if ( $flightBook['flight_type'] == 'charter' ||  $flightBook['api_id'] == '14' ) {
                    if ( $flightBook['percent_discount'] > 0 ) {
                        $DataFlightPassengerPayData = number_format( functions::CalculateDiscount( $flightBook['request_number'], 'yes' ) );
                        $DataFlightPassengerPayData .= "<hr style='margin:3px'><span style='text-decoration: line-through;'>";
                        $DataFlightPassengerPayData .= number_format( $flightBook['agency_commission'] + $flightBook['supplier_commission'] + $flightBook['irantech_commission'] )
                            . '</span>';
                        if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                            $pricetotal    = ( $flightBook['agency_commission'] + $flightBook['supplier_commission'] + $flightBook['irantech_commission'] ) + $pricetotal;
                            $charter_price = $flightBook['agency_commission'] + $flightBook['supplier_commission'] + $flightBook['irantech_commission'] + $charter_price;
                        }
                    } else {
                        $DataFlightPassengerPayData = number_format(functions::CalculateDiscount( $flightBook['request_number'], 'yes' ));
                        if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                            $pricetotal    = ( $flightBook['agency_commission'] + $flightBook['irantech_commission'] + $flightBook['supplier_commission'] ) + $pricetotal;
                            $charter_price = $flightBook['agency_commission'] + $flightBook['irantech_commission'] + $flightBook['supplier_commission'] + $charter_price;
                        }
                    }
                } elseif ( $flightBook['flight_type'] == 'system' ) {
                    if ( $flightBook['percent_discount'] > 0 ) {
                        $DataFlightPassengerPayData = functions::CalculateDiscount( $flightBook['request_number'], 'No' );
                        $DataFlightPassengerPayData .= "<hr style='margin:3px'> <span style='text-decoration: line-through;'>";
                        $DataFlightPassengerPayData .= $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] . '</span>';
                        if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                            $pricetotal = ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] ) + $pricetotal;
                            if ( $flightBook['pid_private'] == '1' ) {
                                $prsystem_price += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                            } else {
                                $pubsystem_price += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                            }
                        }

                    } else {
                        if ( $flightBook['IsInternal'] == '0' ) {
                            $DataFlightPassengerPayData = number_format( functions::CalculateDiscount( $flightBook['request_number'], 'No' ) );
                        } else {
                            $DataFlightPassengerPayData = number_format( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                        }
                        if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                            $pricetotal = ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] ) + $pricetotal;
                            if ( $flightBook['pid_private'] == '1' ) {
                                $prsystem_price += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                            } else {
                                $pubsystem_price += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                            }
                        }
                    }

                }
            } else {
                $InfoTicketReservation = $this->getInfoTicketReservation( $flightBook['request_number'] );
                if ( $InfoTicketReservation['totalPriceWithoutDiscount'] != 0 ) {
                    $DataFlightPassengerPayData = "<span style='text-decoration: line-through;'>" . number_format( $InfoTicketReservation['totalPriceWithoutDiscount'], 0, ".", "," ) . "</span><hr style='margin:3px'>";
                }
                $DataFlightPassengerPayData .= number_format( $InfoTicketReservation['totalPrice'], 0, ".", "," );
                $pricetotal                 = ( $InfoTicketReservation['totalPrice'] ) + $pricetotal;
            }
            $DataFlightPassengerPayData .= "<hr style='margin:3px'><span class='font11'>" . $flightBook['passenger_name'] . " " . $flightBook['passenger_family'] . "</span>";


            if ( TYPE_ADMIN == '1' ) {
                //                $DataFlightActionBtn="<td style='direction: ltr;'>";
                if ( $flightBook['type_app'] == 'Web' || $flightBook['type_app'] == 'Application' || $flightBook['type_app'] == 'Api' ) {

                    if ( $flightBook['successfull'] != 'nothing' ) {
                        $DataFlightActionBtn = '<div class="btn-group m-r-10">
                                                    <button aria-expanded="false" data-toggle="dropdown"
                                                            class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                            type="button"> عملیات <span class="caret"></span></button>
                                                    <ul role="menu" class="dropdown-menu animated flipInY mainTicketHistory-operation">
                                                        <li>
                                                            <div class="pull-left">
                                                                <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] != 'nothing' ) {
                            $DataFlightActionBtn .= '<a onclick="ModalShowBookForFlight(' . "'" . $flightBook['request_number'] . "'" . ');return false" data-toggle="modal" data-target="#ModalPublic"> <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="مشاهده خرید"></i> </a>';
                        }
                        $DataFlightActionBtn .= '</div>

                        <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                            $DataFlightActionBtn .= "<a href='" . SERVER_HTTP . $flightBook['DomainAgency'] . "/gds/pdf&target=boxCheck&id=" . $flightBook['request_number'] . "'
                                                                           target='_blank'>
                                                                            <i class='fcbtn btn btn-outline btn-warning btn-1c  tooltip-warning fa fa-money'
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title=' قبض صندوق'></i></a>";
                        }
                        $DataFlightActionBtn .= '</div>

                        <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                            $DataFlightActionBtn .= "<a href='" . SERVER_HTTP . $flightBook['DomainAgency'] . "/gds/pdf&target=boxCheckCostumer&id=" . $flightBook['request_number'] . "'
                                                                           target='_blank'>
                                                                            <i class='fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-money '
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title=' قبض صندوق به تفکیک مشتریان'></i></a>";
                        }
                        $DataFlightActionBtn .= '</div>';
                        if ( $flightBook['IsInternal'] == '1' ) {
                            $DataFlightActionBtn .= "<div class='pull-left margin-10'>";
                            if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                                $DataFlightActionBtn .= "<a href='" . SERVER_HTTP . $flightBook['DomainAgency'] . "/gds/pdf&target=parvazBookingLocal&id=" . $flightBook['request_number'] . "&lang=fa'
                                                                           target='_blank'>
                                                                            <i class='fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o '
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title='بلیط پارسی'></i></a>";
                            }
                            $DataFlightActionBtn .= '</div>';
                        }

                        $DataFlightActionBtn .= '<div class="pull-left margin-10">';
                        if ( $flightBook['IsInternal'] == '1' ) {
                            if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                                $DataFlightActionBtn .= "<a href='" . SERVER_HTTP . $flightBook['DomainAgency'] . "/gds/pdf&target=parvazBookingLocal&id=" . $flightBook['request_number'] . "&lang=en'
                                                                           target='_blank' title='دانلود بلیط(pdf)'>
                                                                            <i class='fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-file-pdf-o'
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title=' بلیط انگلیسی '></i></a>";
                            }
                        } else {
                            if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                                $DataFlightActionBtn .= "<a href='" . SERVER_HTTP . $flightBook['DomainAgency'] . "/gds/pdf&target=ticketForeign&id=" . $flightBook['request_number'] . "'
                                                                           target='_blank' title='دانلود بلیط(pdf)'>
                                                                            <i class='fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-file-pdf-o'
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title='چاپ بلیط'></i></a>";
                            }
                        }
                        $DataFlightActionBtn .= '</div><div class="pull-left margin-10">';
                        if ( $flightBook['IsInternal'] == '1' && ($flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' )) ) {
                            $DataFlightActionBtn .= "<a href='" . SERVER_HTTP . $flightBook['DomainAgency'] . "/gds/pdf&target=parvazBookingLocal&id=" . $flightBook['request_number'] . "&cash=no'
                                                                           target='_blank'>
                                                                            <i class='fcbtn btn btn-outline btn-default btn-1c tooltip-default fa fa-ticket '
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title=' بلیط بدون قیمت '></i>";
                        }
                        $DataFlightActionBtn .= '</div>';

                        if ( ($flightBook['successfull'] == 'bank' || $flightBook['successfull'] == 'credit' || $flightBook['successfull'] == 'pending' || $flightBook['successfull'] == 'processing') && TYPE_ADMIN == '1') {
                            $DataFlightActionBtn .= "<div class='pull-left margin-10'><a onclick='DonePreReserve(" . '"' . $flightBook['request_number'] . '"' . "," . '"' . $flightBook['factor_number'] . '"' . "," . '"' . $flightBook['client_id'] . '"' . "); return false ;'
                                                                           id='sendSms" . $flightBook['request_number'] . "' target='_blank'>
                                                                            <i class='fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-times'
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title='برای پیش رزرو کردن بلیط کلیک نمائید'></i></a></div>";
                        }
                        //                        if( ($flightBook['pid_private'] == '1' || $flightBook['api_id'] == '11' || $flightBook['api_id'] == '8' ) && ($flightBook['successfull'] == 'private_reserve' || $flightBook['successfull'] == 'book') && TYPE_ADMIN == '1'){
                        if ( TYPE_ADMIN == '1' ) {
                            $DataFlightActionBtn .= "<div class='pull-left margin-10'><a onclick='insertPnr(" . '"' . $flightBook['request_number'] . '"' . "," . '"' . $flightBook['client_id'] . '"' . "); return false ;'
                                                                           id='sendSms" . $flightBook['request_number'] . "' target='_blank' data-toggle='modal' data-target='#ModalPublic'>
                                                                            <i class='fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-book'
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title='برای قطعی کردن و وارد کردن pnr کلیک کنید'></i></a></div>";
                        }
                        /*if($flightBook['successfull'] == 'book' || ($flightBook['successfull'] == 'credit' &&  TYPE_ADMIN == '1')){
                            $DataFlightActionBtn.="<div class='pull-left margin-10'><a onclick='FlightConvertToBook(".'"'.$flightBook['request_number'].'"'.",".'"'.$flightBook['client_id'].'"'."); return false ;'
                                                                           id='sendSms".$flightBook['request_number']."' target='_blank' data-toggle='modal' data-target='#ModalPublic'>
                                                                            <i class='fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-book'
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title='برا قطعی کردن بلیط کلیک نمائید'></i></a></div>";
                        }*/
                        $DataFlightActionBtn .= '<div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'credit' && TYPE_ADMIN == '1' ) ) {

                            $DataFlightActionBtn .= ' <a onclick="ModalSendSms(' . "'" . $flightBook['request_number'] . "'" . ');return false"
                                                       id="sendSms' . $flightBook['request_number'] . '"
                                                       target="_blank"
                                                       data-toggle="modal"
                                                       data-target="#ModalPublic">
                                                        <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-envelope-o"
                                                           data-toggle="tooltip"
                                                           data-placement="top"
                                                           title=""
                                                           data-original-title="برای ارسال پیام کلیک کنید"></i>
                                                    </a>';
                        }
                        $DataFlightActionBtn .= '</div>';



                        if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && ( TYPE_ADMIN == '1' || CLIENT_ID == '23' ) ) ) {
                            $DataFlightActionBtn .= "<div class='pull-left margin-10'><a onclick='ModalSendInteractiveSms(" . '"' . $flightBook['factor_number'] . '"' . "); return false ;'
                                                                           id='sendSms" . $flightBook['request_number'] . "' target='_blank' data-toggle='modal' data-target='#ModalPublic'>
                                                                            <i class='fcbtn btn btn-outline btn-warning btn-1c  tooltip-warning fa fa-share'
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title='برای ارسال مجدد کد ترانسفر کلیک کنید'></i></a></div>";
                        }
                        $DataFlightActionBtn .= "</div> </li> </ul> </div> <hr style='margin:3px'>";

                    }
                    $DataFlightActionBtn .= '<a href="' . $transactionLink . '" data-toggle="tooltip" data-placement="top"
                                               data-original-title="مشاهده تراکنش ها"
                                               target="_blank">' . $flightBook['NameAgency'] . '</a><br/>
                                            <hr style="margin:3px">';
                    if ( $flightBook['payment_type'] == 'cash' || $flightBook['payment_type'] == 'member_credit' ) {
                        if ( $flightBook['payment_type'] == 'cash' ) {
                            $DataFlightActionBtn .= 'نقدی';
                        } else {
                            $DataFlightActionBtn .= 'اعتباری';
                        }
                        if ( $flightBook['number_bank_port'] == '379918' ) {
                            if ( $flightBook['flight_type'] == 'charter' && $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                                $CashTotalMe += ( $flightBook['agency_commission'] + $flightBook['irantech_commission'] + $flightBook['supplier_commission'] );
                            } elseif ( $flightBook['flight_type'] == 'system' && $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                                $CashTotalMe += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                            }
                        } else {
                            if ( $flightBook['flight_type'] == 'charter' && $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                                $CashTotalMe += ( $flightBook['agency_commission'] + $flightBook['irantech_commission'] + $flightBook['supplier_commission'] );
                            } elseif ( $flightBook['flight_type'] == 'system' && $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                                $CashTotalMe += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                            }
                        }
                    } elseif ( $flightBook['payment_type'] == 'credit' ) {
                        $DataFlightActionBtn .= 'اعتباری';
                        if ( $flightBook['flight_type'] == 'charter' && $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                            $CreditTotal += ( $flightBook['agency_commission'] + $flightBook['irantech_commission'] + $flightBook['supplier_commission'] );
                        } elseif ( $flightBook['flight_type'] == 'system' && $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                            $CreditTotal += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                        }

                    } elseif ( $flightBook['payment_type'] == 'nothing' ) {
                        $DataFlightActionBtn .= 'نا مشخص';
                    }
                    if ( $flightBook['name_bank_port'] != '' ) {
                        $DataFlightActionBtn .= "<br> <hr style='margin:3px'>";
                        if ( $flightBook['number_bank_port'] == $GetWayIranTech['userName'] || $flightBook['number_bank_port'] == '5b8c0bc6-7f26-11ea-b1af-000c295eb8fc' || $flightBook['number_bank_port'] == '379918' ) {
                            $DataFlightActionBtn .= "درگاه سفر360";
                        } else {
                            $DataFlightActionBtn .= " درگاه خودش";
                        }
                    }
                    if ( $flightBook['api_id'] == '1' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور5";
                    } elseif ( $flightBook['api_id'] == '5' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 4";
                    } elseif ( $flightBook['api_id'] == '14' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 14";
                    }elseif ( $flightBook['api_id'] == '15' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 15";
                    }elseif ( $flightBook['api_id'] == '16' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 16";
                    } elseif ( $flightBook['api_id'] == '17' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 17";
                    } elseif ( $flightBook['api_id'] == '12' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 12";
                    } elseif ( $flightBook['api_id'] == '13' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 13";
                    } elseif ( $flightBook['api_id'] == '8' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 7";
                    } elseif ( $flightBook['api_id'] == '10' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 9";
                    } elseif ( $flightBook['api_id'] == '11' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 10";
                    }elseif ( $flightBook['api_id'] == '18' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 18";
                    }elseif ( $flightBook['api_id'] == '19' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 19";
                    }

                } else {
                    if ( $flightBook['successfull'] != 'nothing') {
                        $DataFlightActionBtn = '<div class="btn-group m-r-10">

                                                <button aria-expanded="false" data-toggle="dropdown"
                                                        class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                        type="button"> عملیات <span class="caret"></span></button>

                                                <ul role="menu" class="dropdown-menu animated flipInY mainTicketHistory-operation">
                                                    <li>
                                                        <div class="pull-left">

                                                            <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] != 'nothing' ) {
                            $DataFlightActionBtn .= '<a onclick="ModalShowBookForFlight(' . "'" . $flightBook['request_number'] . "'" . ');return false"
                                                                       data-toggle="modal"
                                                                       data-target="#ModalPublic">
                                                                        <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                                           data-toggle="tooltip"
                                                                           data-placement="top" title=""
                                                                           data-original-title="مشاهده خرید"></i>
                                                                    </a>';
                        }
                        $DataFlightActionBtn .= '</div><div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' ) {
                            $DataFlightActionBtn .= '<a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/pdf&target=BookingReservationTicket&id=' . $flightBook['request_number'] . '"
                                                                       target="_blank">
                                                                        <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                                           data-toggle="tooltip"
                                                                           data-placement="top" title=""
                                                                           data-original-title=" بلیط پارسی "></i>
                                                                    </a>';
                        }
                        $DataFlightActionBtn .= '</div> </div> </li> </ul> </div> <hr style="margin:3px">';
                    }
                    $DataFlightActionBtn .= '<a href="' . $transactionLink . '" data-toggle="tooltip" data-placement="top"
                                           data-original-title="مشاهده تراکنش ها"
                                           target="_blank">' . $flightBook['NameAgency'] . '</a>';
                }
                $DataFlightActionBtn .= "<hr style='margin:3px'>";
                $DataFlightActionBtn .= functions::DetectDirection( $flightBook['factor_number'], $flightBook['request_number'] );
            } else {

                if ( $flightBook['successfull'] != 'nothing' ) {
                    if ( $flightBook['type_app'] == 'Web' || $flightBook['type_app'] == 'Application' ) {
                        $DataFlightActionBtn = ' <div class="btn-group m-r-10">
    
                                                        <button aria-expanded="false" data-toggle="dropdown"
                                                                class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                                type="button"> عملیات <span class="caret"></span></button>
    
                                                        <ul role="menu" class="dropdown-menu animated flipInY mainTicketHistory-operation">
                                                            <li>
                                                                <div class="pull-left">
                                                                    <div class="pull-left margin-10">';
                        //                        echo $DataFlightActionBtn; die();
                        if ( $flightBook['successfull'] != 'nothing' ) {

                            $DataFlightActionBtn .= '<a onclick="ModalShowBook(' . "'" . $flightBook['request_number'] . "'" . ');return false"
                                                                           data-toggle="modal"
                                                                           data-target="#ModalPublic">
                                                                            <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                                               data-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title=""
                                                                               data-original-title="مشاهده خرید"></i>
                                                                        </a>';
                        }
                        $DataFlightActionBtn .= ' </div>

                                                                <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                            $DataFlightActionBtn .= ' <a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/pdf&target=boxCheck&id=' . $flightBook['request_number'] . '"
                                                                           target="_blank">
                                                                            <i class="fcbtn btn btn-outline btn-warning btn-1c  tooltip-warning fa fa-money "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title=""
                                                                               data-original-title=" قبض صندوق"></i>
                                                                        </a>';
                        }
                        $DataFlightActionBtn .= ' </div>
 
 

                                                                <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                            $DataFlightActionBtn .= ' <a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/pdf&target=boxCheckCostumer&id=' . $flightBook['request_number'] . '"
                                                                           target="_blank">
                                                                            <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-money "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title=""
                                                                               data-original-title=" قبض صندوق به تفکیک مشتریان"></i>
                                                                        </a>';
                        }
                        $DataFlightActionBtn .= ' </div>

                                                                ';
                        if ( $flightBook['successfull'] == 'book' && CLIENT_ID == 271 ) {
                            $DataFlightActionBtn .= '<div class="pull-left margin-10">';

                            $DataFlightActionBtn .= ' <a onclick="ModalUploadProof(' . "'" . $flightBook['request_number'] . "'" .  ",'" ."Flight'"  . ');return false"
                                                       id="uploadProof' . $flightBook['request_number'] . '"
                                                       target="_blank"
                                                       data-toggle="modal"
                                                       data-target="#ModalPublic">
                                                        <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-upload"
                                                           data-toggle="tooltip"
                                                           data-placement="top"
                                                           title=""
                                                           data-original-title="آپلود فاکتور"></i>
                                                    </a>';
                            $DataFlightActionBtn .= '</div>';
                        }

                        if ( ( $flightBook['IsInternal'] == '1' && $flightBook['successfull'] == 'book' ) || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                            $DataFlightActionBtn .= '<div class="pull-left margin-10"> <a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/pdf&target=parvazBookingLocal&id=' . $flightBook['request_number'] . '&lang=fa"
                                                                           target="_blank">
                                                                            <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title=""
                                                                               data-original-title=" بلیط پارسی "></i>
                                                                        </a></div>';
                        }




                        $DataFlightActionBtn .= ' <div class="pull-left margin-10">';
                        if ( $flightBook['IsInternal'] == '1' ) {
                            if ( ( $flightBook['IsInternal'] == '1' && $flightBook['successfull'] == 'book' ) || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                                $DataFlightActionBtn .= ' <a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/pdf&target=parvazBookingLocal&id=' . $flightBook['factor_number'] . '&lang=en"
                                                                               target="_blank">
                                                                                <i class="fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-file-pdf-o"
                                                                                   data-toggle="tooltip"
                                                                                   data-placement="top"
                                                                                   title=""
                                                                                   data-original-title=" بلیط انگلیسی "></i>
                                                                            </a>';
                            }
                        } else {
                            if ( ( $flightBook['successfull'] == 'book' ) || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {

                                $DataFlightActionBtn .= ' <a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/pdf&target=ticketForeign&id=' . $flightBook['request_number'] . '"
                                                                               target="_blank">
                                                                                <i class="fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-file-pdf-o"
                                                                                   data-toggle="tooltip"
                                                                                   data-placement="top"
                                                                                   title=""
                                                                                   data-original-title=" بلیط انگلیسی "></i>
                                                                            </a>';
                            }
                        }

                        $DataFlightActionBtn .= ' </div>';

                        $DataFlightActionBtn .= ' <div class="pull-left margin-10">';
                        if ( $flightBook['IsInternal'] == '1' ) {
                            if ( ( $flightBook['IsInternal'] == '1' && $flightBook['successfull'] == 'book' ) || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                                $DataFlightActionBtn .= "<a href='" . SERVER_HTTP . $flightBook['DomainAgency'] . "/gds/pdf&target=bookshow&id=" . $flightBook['request_number'] . "&cash=no'
                                                                           target='_blank'>
                                                                            <i class='fcbtn btn btn-outline btn-success btn-1c tooltip-success fa fa-ticket '
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title=' بلیط انگلیسی بدون قیمت '></i></a>";
                            }
                        } else {
                            if ( ( $flightBook['successfull'] == 'book' ) || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                                $DataFlightActionBtn .= "<a href='" . SERVER_HTTP . $flightBook['DomainAgency'] . "/gds/pdf&target=ticketForeign&id=" . $flightBook['request_number'] . "&cash=no'
                                                                           target='_blank'>
                                                                            <i class='fcbtn btn btn-outline btn-success btn-1c tooltip-success fa fa-ticket '
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title=' بلیط انگلیسی بدون قیمت '></i></a>";
                            }
                        }

                        $DataFlightActionBtn .= ' </div>';

                        $DataFlightActionBtn .= '<div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                            $DataFlightActionBtn .= ' <a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/pdf&target=parvazBookingLocal&id=' . $flightBook['request_number'] . '&cash=no"
                                                       target="_blank">
                                                        <i class="fcbtn btn btn-outline btn-default btn-1c tooltip-default fa fa-ticket "
                                                           data-toggle="tooltip"
                                                           data-placement="top"
                                                           title=""
                                                           data-original-title=" بلیط بدون قیمت "></i>
                                                    </a>';
                        }
                        $DataFlightActionBtn .= ' </div>

                                                                <div class="pull-left margin-10">';
                        if ( TYPE_ADMIN == '1' ) {
                            $DataFlightActionBtn .= ' <a onclick="ModalSendSms(' . "'" . $flightBook['request_number'] . "'" . ');return false"
                                                       id="SmsSend' . $flightBook['request_number'] . '"
                                                       data-toggle="modal"
                                                       data-target="#ModalPublic">
                                                        <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-envelope-o"
                                                           data-toggle="tooltip"
                                                           data-placement="top"
                                                           title=""
                                                           data-original-title="برای ارسال پیام کلیک کنید"></i>
                                                    </a>';
                        }

                        if ( $flightBook['successfull'] == 'book' ){
                            $DataFlightActionBtn .= '<a id="SendEmail' . $flightBook['request_number'] . '"
                                                                       onclick="ModalSenEmailForOther(' . "'" . $flightBook['request_number'] . "'" . ( $flightBook['client_id'] != '' ? ",'" . $flightBook['client_id'] . "'" : "" ) . ');return false"
                                                                       data-toggle="modal" data-target="#ModalPublic">
                                                                        <i class="fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-envelope"
                                                                           data-toggle="tooltip" data-placement="top"
                                                                           title=""
                                                                           data-original-title="برای ارسال ایمیل کلیک کنید"></i>
                                                                    </a>
                                                                </div></div>';
                        }


                        $DataFlightActionBtn .= "<hr style='margin:3px'>";

                        functions::DetectDirection( $flightBook['factor_number'], $flightBook['request_number'] );


                    } else {
                        $DataFlightActionBtn = '<div class="btn-group m-r-10">

                                                    <button aria-expanded="false" data-toggle="dropdown"
                                                            class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                            type="button"> عملیات <span class="caret"></span></button>

                                                    <ul role="menu" class="dropdown-menu animated flipInY mainTicketHistory-operation">
                                                        <li>
                                                            <div class="pull-left">

                                                                <div class="pull-left margin-10">';

                        if ( $flightBook['successfull'] !== 'nothing' && $flightBook['successfull'] !== 'error' ) {
                            $DataFlightActionBtn .= '<a onclick="ModalShowBook(' . "'" . $flightBook['request_number'] . "'" . ');return false"
                                                                           data-toggle="modal"
                                                                           data-target="#ModalPublic">
                                                                            <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title="مشاهده خرید"></i>
                                                                        </a>';
                        }
                        $DataFlightActionBtn .= '</div> <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' ) {
                            $DataFlightActionBtn .= '<a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/eReservationTicket&num=' . $flightBook['request_number'] . '"
                                                                           target="_blank"
                                                                           title="مشاهده اطلاعات خرید">
                                                                            <i class="fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-print "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title="مشاهده اطلاعات خرید"></i>
                                                                        </a>';
                        }
                        $DataFlightActionBtn .= '</div> <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' ) {
                            $DataFlightActionBtn .= '<a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/pdf&target=BookingReservationTicket&id=' . $flightBook['request_number'] . '"
                                                                           target="_blank">
                                                                            <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title=" بلیط پارسی "></i>
                                                                        </a>';
                        }
                        $DataFlightActionBtn .= '</div> <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] == 'book' || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                            $DataFlightActionBtn .= '<a onclick="ModalCancelAdmin(' . "'flight'," . "'" . $flightBook['request_number'] . "'" . ');return false"
                                                                       target="_blank"  data-toggle="modal"
                                                                       data-target="#ModalPublic">
                                                                        <i class="fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-times "
                                                                           data-toggle="tooltip"
                                                                           data-placement="top" title=""
                                                                           data-original-title=" ثبت درخواست کنسلی پرواز"></i>
                                                                    </a>';
                        }
                        $DataFlightActionBtn .= '</div> </div> </li> </ul> </div>';


                    }



                }

            }



            if ( $flightBook['type_app'] == 'Web' || $flightBook['type_app'] == 'Application' || $flightBook['type_app'] == 'Api' ) {
                if ( $flightBook['successfull'] == 'nothing' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;"
                                               class="btn btn-default cursor-default popoverBox  popover-default"
                                               data-toggle="popover" title="انصراف از خرید" data-placement="right"
                                               data-content="مسافر از تایید نهایی استفاده نکرده است"> انصراف از
                                                خرید </a>';
                } elseif ( $flightBook['successfull'] == 'error') {
                    $DataFlightCondition = $this->btnErrorFlight($flightBook);
                } elseif ( $flightBook['successfull'] == 'prereserve' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-warning cursor-default">
                                                پیش رزرو </a>';
                } elseif ( $flightBook['successfull'] == 'bank' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;"
                                               class="btn btn-primary cursor-default popoverBox  popover-primary"
                                               data-toggle="popover" title="هدایت به درگاه" data-placement="right"
                                               data-content="مسافر به درگاه بانکی منتقل شده است و سیستم در انتظار بازگشت از بانک است ،این خرید فقط در صورتی که بانک به سیستم کد تایید پرداخت را بدهد تکمیل میشود">
                                                هدایت به درگاه </a>';
                } elseif ( $flightBook['successfull'] == 'credit' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-default cursor-default ">
                                                انتخاب گزینه اعتباری </a>';
                } elseif ( $flightBook['successfull'] == 'processing' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-primary cursor-primary ">در حال پردازش</a>';
                }elseif ( $flightBook['successfull'] == 'pending' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-print cursor-warning ">در حال صدور</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1' && $flightBook['api_id'] == '1' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اختصاصی سرور 5</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['private_m4'] == '1' && $flightBook['IsInternal'] == '0' && $flightBook['api_id'] == '10' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو
                                                اختصاصی سرور 9</a>';
                } elseif ( $flightBook['successfull'] == 'book' && $flightBook['private_m4'] == '1' && $flightBook['IsInternal'] == '0' && $flightBook['api_id'] == '10' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو سرور 9</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['private_m4'] == '1' && $flightBook['IsInternal'] == '1' && $flightBook['api_id'] == '5' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو
                                                اختصاصی سرور 4</a>';
                } elseif ( $flightBook['successfull'] == 'book' && $flightBook['api_id'] == '11' && TYPE_ADMIN == '1' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default">
                                                اشتراکی سرور 10</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['api_id'] == '14' && TYPE_ADMIN == '1' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default">
                                                اختصاصی سرور 14</a>';
                }elseif (($flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve') && $flightBook['api_id'] == '15' && TYPE_ADMIN == '1' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default">
                                                 رزور قطعی سرور 15</a>';
                }elseif ( ($flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve') && $flightBook['api_id'] == '16' && TYPE_ADMIN == '1' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default">
                                                 رزرو قطعی سرور 16</a>';
                }elseif ( ($flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve') && $flightBook['api_id'] == '17' && TYPE_ADMIN == '1' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default">
                                                 رزرو قطعی سرور 17</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1' && $flightBook['api_id'] == '12' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اختصاصی سرور 12</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1' && $flightBook['api_id'] == '18' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اختصاصی سرور 18</a>';
                }elseif ( $flightBook['successfull'] == 'book' && $flightBook['pid_private'] == '0' && $flightBook['api_id'] == '13' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اشتراکی سرور 13</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1' && $flightBook['IsInternal'] == '1' && $flightBook['api_id'] == '13' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو
                                                اختصاصی سرور 13</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1'  && $flightBook['api_id'] == '8' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو
                                                اختصاصی سرور 7</a>';
                }elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1' && $flightBook['IsInternal'] == '1' && $flightBook['api_id'] == '19' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو
                                                اختصاصی سرور 19</a>';
                } elseif ( $flightBook['successfull'] == 'book' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-success cursor-default">رزرو قطعی</a>';
                }
                if(TYPE_ADMIN !='1')
                {
                    $client_id = CLIENT_ID ;
                    //&& ($flightBook['pid_private']=='1' || in_array($client_id,functions::clientsForDisplaySourceName()))
                    if ( $flightBook['api_id'] == '14' && ($flightBook['pid_private']=='1') ) {
                        $DataFlightCondition .= "<hr style='margin:3px'> رزرو از منبع پرتو";
                    } elseif ($flightBook['api_id'] == '8' && ($flightBook['pid_private']=='1') ) {
                        $DataFlightCondition .= "<hr style='margin:3px'> رزرو از منبع چارتر724";
                    }
                }
                if ( $flightBook['private_m4'] == '1' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                    if ( $flightBook['pid_private'] == '1' && $flightBook['successfull'] == 'private_reserve' ) {
                        $DataFlightCondition .= '<hr style="margin:3px">
                                                <a id="Jump2Step' . $flightBook['request_number'] . '"
                                                   onclick="changeFlagBuyPrivate(' . $flightBook['request_number'] . ')"
                                                   href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearch?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-shopping-cart"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="برای ادامه خرید از سرور 5 کلیک نمائید"
                                                       id="i_Jump2Step' . $flightBook['request_number'] . '"></i></a>';
                    } elseif ( $flightBook['is_done_private'] == '2' && $flightBook['pid_private'] == '1' && $flightBook['successfull'] == 'private_reserve' ) {
                        $DataFlightCondition .= '<hr style="margin:3px">
                                                <a id="nextChangeFlag"
                                                   onclick="changeFlagBuyPrivate(' . $flightBook['request_number'] . ')"
                                                   href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearch?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-refresh"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="در حال رزرو"></i></a>';
                    }
                    if ( $flightBook['pid_private'] == '1' && $flightBook['private_m4'] == '1' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) && ( TYPE_ADMIN == '1' ) ) {
                        $DataFlightCondition .= '<a id="Jump2StepSourceFour' . $flightBook['request_number'] . '"
                                                   onclick="changeFlagBuyPrivateToPublic(' . $flightBook['request_number'] . ')"
                                                   href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearchSourceFour?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-search"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="برای ادامه خرید از سرور 10 کلیک نمائید"
                                                       id="Jump2StepSourceFour' . $flightBook['request_number'] . '"></i></a>
                                                <a id="Jump2StepSourceFour' . $flightBook['request_number'] . '"
                                                   onclick="changeFlagBuyPrivateToPublic(' . $flightBook['request_number'] . ')"
                                                   href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearchSourceFour?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '&SourceId=8"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-search"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="برای ادامه خرید از سرور 7 کلیک نمائید"
                                                       id="Jump2StepSourceFour' . $flightBook['request_number'] . '"></i></a>';
                    }
                }
                if ( $flightBook['pnr'] == '' && $flightBook['successfull'] == 'book' && TYPE_ADMIN == '1' && $flightBook['api_id'] == '10' ) {
                    $DataFlightCondition .= '<hr style="margin:3px"/><a id="Jump2StepSourceFour' . $flightBook['request_number'] . '"
                                               onclick="changeFlagBuyPrivateToPublic(' . $flightBook['request_number'] . ')"
                                               href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatSearchSourceNine?RequestNumber=' . $flightBook['request_number'] . '&TypeLevel=Final"
                                               target="_blank">
                                                <i class="fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-amazon"
                                                   data-toggle="tooltip" data-placement="right" title=""
                                                   data-original-title="برای ادامه خرید از سرور 9 کلیک نمائید"
                                                   id="Jump2StepSourceFour' . $flightBook['request_number'] . '"></i></a>';
                }
                if ( $flightBook['pnr'] == '' && $flightBook['successfull'] == 'book' && TYPE_ADMIN == '1' ) {
                    if ( $flightBook['api_id'] == '11' ) {
                        $DataFlightCondition .= '<hr style="margin:3px"/><a id="Jump2StepSourceFour' . $flightBook['request_number'] . '"
                                               onclick="changeFlagBuySystemPublic(' . $flightBook['request_number'] . ')"
                                                   href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearch?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '&Type=M10"
                                               target="_blank">
                                                <i class="fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-shopping-cart"
                                                   data-toggle="tooltip" data-placement="right" title=""
                                                   data-original-title="برای ادامه خرید از سرور 10 کلیک نمائید"
                                                   id="i_Jump2StepPublic' . $flightBook['request_number'] . '"></i></a>';
                    } elseif ( $flightBook['public_system_status'] == '2' && $flightBook['successfull'] == 'book' ) {
                        $DataFlightCondition .= '<hr style="margin:3px">
                                                    <a id="nextChangeFlag"
                                                       onclick="changeFlagBuyPrivate(' . $flightBook['request_number'] . ')"
                                                       href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearch?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '"
                                                       target="_blank">
                                                        <i class="fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-refresh"
                                                           data-toggle="tooltip" data-placement="right" title=""
                                                           data-original-title="در حال رزرو"></i></a>';
                    }

                    if ( $flightBook['api_id'] == '11' && $flightBook['pnr'] == '' && ( $flightBook['successfull'] == 'book' ) && ( TYPE_ADMIN == '1' ) ) {
                        $DataFlightCondition .= '<a id="Jump2StepPublic' . $flightBook['request_number'] . '"
                                                       onclick="changeFlagBuyPrivateToPublic(' . $flightBook['request_number'] . ')"
                                                       href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearchSourceFour?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '"
                                                       target="_blank">
                                                        <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-search"
                                                           data-toggle="tooltip" data-placement="right" title=""
                                                           data-original-title="برای ادامه خرید از سرور 10 کلیک نمائید"
                                                           id="i_Jump2StepPublic' . $flightBook['request_number'] . '"></i></a>';
                    }

                }

                if ( $flightBook['pnr'] != '' ) {
                    $DataFlightCondition .= '<hr style="margin:3px"> <span style="">' . $flightBook['pnr'] . '</span>';
                }
                $DataFlightCondition .= '<hr style="margin:3px">' . $flightBook['remote_addr'] . '<hr style="margin:3px">';
                if ( $flightBook['type_app'] == 'Web' ) {
                    $DataFlightCondition .= 'وب سایت';
                } elseif ( $flightBook['type_app'] == 'Application' ) {
                    $DataFlightCondition .= 'اپلیکیشن';
                } elseif ( $flightBook['type_app'] == 'Api' ) {
                    $DataFlightCondition .= 'Api';
                }

                $flightBook['sub_agency'] ? $DataFlightCondition .= ' <hr style="margin:3px"> آژانس همکار:'.$flightBook['NameAgency'] .'<hr style="margin:3px">' : '';
            } else {

                if ( $flightBook['successfull'] == 'book' ) {
                    $DataFlightCondition = '<a class="btn btn-success cursor-default" onclick="return false;"> رزرو قطعی</a>';
                } elseif ( $flightBook['successfull'] == 'prereserve' ) {
                    $DataFlightCondition = '<a class="btn btn-warning cursor-default" onclick="return false;">پیش رزرو</a>';
                } elseif ( $flightBook['successfull'] == '' ) {
                    $DataFlightCondition = '<a class="btn btn-danger cursor-default" onclick="return false;">نامشخص</a>';
                } elseif ( $flightBook['successfull'] == 'bank' ) {
                    $DataFlightCondition = '<a class="btn btn-danger cursor-default" onclick="return false;">هدایت به درگاه</a>';
                } else {
                    $DataFlightCondition = '<a class="btn btn-danger cursor-default" onclick="return false;">نامشخص</a>';
                }
                $DataFlightCondition .= '<hr style="margin:3px">بلیط رزرواسیون';
            }


            if ( $key >= $param['RowCounter'] ) {
                $FlightDataNewest = 'new';
            } else {
                $FlightDataNewest = 'data';
            }


            $FlightData[ $FlightDataNewest ][ $key ]["ردیف"]                                               = $CountTicket ++;
            $FlightData[ $FlightDataNewest ][ $key ]["تاریخ خرید<br/>واچر<br/>بلیط<br/>پید"]               = $DataFlightType;
            $FlightData[ $FlightDataNewest ][ $key ]["اطلاعات پرواز"]                                      = $DataFlightInformation;
            $FlightData[ $FlightDataNewest ][ $key ]["نام خریدار <br/> نوع کاربر<br/>تعداد<br/>نوع کانتر"] = $DataFlightCounterType;
            $FlightData[ $FlightDataNewest ][ $key ]["سهم آژانس"]                                          = $DataFlightAgencyShare;
            $FlightData[ $FlightDataNewest ][ $key ]["Total<br/>Fare"]                                     = $DataFlightTotalFree;
            ( TYPE_ADMIN == '1' ? $FlightData[ $FlightDataNewest ][ $key ]["سهم ما"] = $DataFlightIranTechCommission : "" );
            $FlightData[ $FlightDataNewest ][ $key ]["پرداخت مسافر<br/>نام مسافر"] = $DataFlightPassengerPayData;
            ( TYPE_ADMIN == '1'  ? $FlightData[ $FlightDataNewest ][ $key ]["نام <br> آژانس"] = $DataFlightActionBtn : $FlightData[ $FlightDataNewest ][ $key ]["عملیات"] = $DataFlightActionBtn );
            $FlightData[ $FlightDataNewest ][ $key ]["وضعیت"] = $DataFlightCondition;


            $DataFlightType               = '';
            $DataFlightInformation        = '';
            $DataFlightCounterType        = '';
            $DataFlightAgencyShare        = '';
            $DataFlightTotalFree          = '';
            $DataFlightIranTechCommission = '';
            $DataFlightPassengerPayData   = '';
            $DataFlightActionBtn          = '';
            $DataFlightCondition          = '';
        }
        $FooterData0 = '<th colspan="4"></th><th colspan="">(' . number_format($priceAgency) . ')ريال</th>' . '<th colspan="">(' . number_format($pricesupplier) . ')ريال</th>' . ( TYPE_ADMIN == 1 ? '<th colspan="">(' . number_format($priceMe) . ')ريال</th><th colspan="">(' . @$price_api . ')ريال</th>' : '' ) . '<th colspan="1">(' . number_format( $pricetotal ) . ')ريال</th>
                            <th></th>';


        $FlightData['footer'][0] = $FooterData0;

        $FooterData1             = '<th colspan="10">جمع کل(' . $totalQty . ')نفر</th>';
        $FlightData['footer'][1] = $FooterData1;

        return ( empty( $FlightData ) ? null : $FlightData );
    }

    public function MainHotelHistory( $param ) {
        $transactions = $this->getTransactionsByDateRange($param['date_of'],$param['to_date'],$param['pnr'],$param['factor_number'],$param['request_number'],$param['passenger_name']);//list Transactions
        $TotalDataPrice=0;
        $TotalAgencyShare=0;

        /** @var bookhotelshow $BookHotelController */
        $BookHotelController = Load::controller( 'bookhotelshow' );
        $resultHotelLocalController =Load::controller('resultHotelLocal');

        if ( ! empty( $param['member_id'] ) ) {
            $intendedUser       = [
                "member_id" => $param['member_id'],
                "agency_id" => @$param['agency_id']
            ];

            $ListBookHotelLocal = $BookHotelController->listBookHotelLocal( null, $intendedUser );
        } else {
            $ListBookHotelLocal = $BookHotelController->listBookHotelLocal();
        }

        foreach ( $ListBookHotelLocal as $key => $hotel ) {
            $transactionLink= ROOT_ADDRESS_WITHOUT_LANG . '/itadmin/transactionUser&id=' . $hotel['client_id'];
            $FActorNumberFor=rtrim($hotel['factor_number']);
            if ( TYPE_ADMIN == '1' ) {
                $addressClient = $BookHotelController->ShowAddressClient( $hotel['client_id'] );
            } else {
                $addressClient = $BookHotelController->ShowAddressClient( CLIENT_ID );
            }
            $infoMember = functions::infoMember( $hotel['member_id'], $hotel['client_id'] );

            $DataCityHotel = $hotel['city_name'] . '
                                <hr style="margin:3px">' . $hotel['hotel_name'].'
                                <hr style="margin:3px">' . $hotel['service_type'];
            if ( $hotel['payment_date'] != '' ) {
                $DataEnterInformation = $hotel['payment_date'] . '<hr style="margin:3px">';
            }
            if ( $hotel['payment_time'] != '' ) {
                $DataEnterInformation .= $hotel['payment_time'] . '<hr style="margin:3px">';
            }
            $DataEnterInformation .= $hotel['member_name'];
            if ( $hotel['services_discount'] != '' && $infoMember['is_member'] == '1' ) {
                $DataEnterInformation .= "<hr style='margin:3px'>";
                if ( $infoMember['fk_counter_type_id'] == '5' ) {
                    $DataEnterInformation .= 'مسافر';
                } else {
                    $DataEnterInformation .= 'کانتر';
                }
                $DataEnterInformation .= '<code>'. floatval($hotel['services_discount']).'%</code> ای';
            }
            $DataExitInformation = $hotel['start_date'];
            $DataExitInformation .= '<hr style="margin:3px">';
            $DataExitInformation .= $hotel['end_date'];
            $DataExitInformation .= '<hr style="margin:3px">';
            $DataExitInformation .= $hotel['number_night'] . ' شب';

            $DataFactorInformation = $hotel['type_application_fa'];
            $DataFactorInformation .= '<hr style="margin:3px">';
            $DataFactorInformation .= '<span class="FontBold">'.$hotel['factor_number'].'</span>';
            $DataFactorInformation .= '<hr style="margin:3px">';
            $DataFactorInformation .= '<span class="FontBold">'.$hotel['request_number'].'</span>';
            $DataFactorInformation .= '<hr style="margin:3px">';
            $DataFactorInformation .= '<span class="FontBold">'.$hotel['pnr'].'</span>';

            $DataRoomInformation = '<div class="button-box">
                                    <button type="button" class="btn btn-default btn-outline"
                                            title="" data-toggle="popover"
                                            data-placement="top" data-content="' . $hotel['room'] . '"
                                            data-original-title="اتاق های رزرو شده">' . $hotel['room_count'] . ' باب اتاق</button>
                                </div>';
            $BuyFromIt=0;
            $this->colorTrByStatusCreditBlak='';
            $this->colorTrByStatusCreditPurple='';

            if ( $hotel['type_application'] == 'api' || $hotel['type_application'] == 'api_app' || $hotel['type_application'] == 'externalApi' ) {
                $DataAgencyCommission = $hotel['agency_commission'];

                //$DataPrice            = number_format( $hotel['total_price_api']);
                $BuyFromIt = isset($transactions[$FActorNumberFor]) ? $transactions[$FActorNumberFor] : 0;
                $DataPrice=number_format($BuyFromIt);
                if ( TYPE_ADMIN == '1' ) {
                    $DataIranTechCommission = number_format( $hotel['irantech_commission'] );
                }
            }else if($hotel['type_application'] == 'reservation' ){

                $hotelDetail =  $resultHotelLocalController->getHotelInfoById($hotel['hotel_id']);
                if($hotelDetail['user_id']) {
                    //$DataPrice  = number_format( $hotel['total_price_api']);
                    $BuyFromIt = isset($transactions[$FActorNumberFor]) ? $transactions[$FActorNumberFor] : 0;
                    $DataPrice=number_format($BuyFromIt);

                }else{
                    $DataPrice            = '0';
                }
                $DataAgencyCommission = '-----';
                if ( TYPE_ADMIN == '1' ) {
                    $DataIranTechCommission = '-----';
                }
            } else {
                $DataAgencyCommission = '-----';
                $DataPrice            = '0';
                if ( TYPE_ADMIN == '1' ) {
                    $DataIranTechCommission = '-----';
                }

            }

            if ( TYPE_ADMIN == 1 && $hotel['status'] == 'BookedSuccessfully' && $hotel['service_type']=='اشتراکی') { //محاسبه اعتبار فعلی مشتری
                $DataPrice.=$this->CalculateCurrentCredit($hotel['client_id'],$FActorNumberFor,$BuyFromIt);
            }
            if ($hotel['status'] == 'BookedSuccessfully'){
                $TotalDataPrice+=$BuyFromIt;
            }

            $DataAllPrice='';
            if(floatval($hotel['services_discount']) > 0 && TYPE_ADMIN != '1'){
                $price_with_change = $this->getController('BookingHotelNew')->getPriceWithChange($hotel['factor_number']);
                $DataAllPrice = '<span style="text-decoration: line-through;">'.  number_format($price_with_change) .'</span><br/>';
            }
            $DataAllPrice .=  number_format( $hotel['total_price']);
            $DataAllPriceFor = $hotel['total_price'];



            $linkView = "ehotelLocal";
            $linkPDF  = "BookingHotelLocal";

            if ( CLIENT_NAME == 'آهوان' ) {
                $linkView = "ehotelAhuan";
                $linkPDF  = "hotelVoucherAhuan";
            } elseif ( CLIENT_NAME == 'زروان مهر آریا' ) {
                $linkView = "ehotelZarvan";
                $linkPDF  = "BookingHotelLocal";
            } else {
                $linkView = "ehotelLocal";
                $linkPDF  = "BookingHotelNew";
            }
            $DataAction = '<div class="btn-group m-r-10">

                                    <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button">  عملیات <span class="caret"></span></button>

                                    <ul role="menu" class="dropdown-menu animated flipInY mainTicketHistory-operation">
                                        <li>
                                            <div class="pull-left">';
            if ( $hotel['type_application'] == 'reservation' ) {
                $BookHotelController->getEditHotelBookingReport( $hotel['factor_number'] );
                if ( $BookHotelController->editHotelBooking == 'True' ) {
                    $DataAction .= '<div class="pull-left margin-10">
                                                            <a onclick="ModalShowEditBookHotel(' . "'" . $hotel['factor_number'] . "'" . ');return false" data-toggle="modal" data-target="#ModalPublic">
                                                                <i style="margin: 5px auto;"  class="fcbtn btn btn-success btn-outline btn-1c fa fa-list"
                                                                   data-toggle="tooltip" data-placement="top" title=""
                                                                   data-original-title="مشاهده ویرایش رزرو"></i>
                                                            </a>
                                                        </div>';
                }
                if ( $hotel['status'] == 'BookedSuccessfully' ) {
                    $DataAction .= '<div class="pull-left margin-10">
                                                            <a onclick="allowEditingHotel(' . "'" . $hotel['factor_number'] . "'" . ',' . "'" . $hotel['member_id'] . "'" . ');return false" title="ویرایش رزرو">
                                                                <i style="margin: 5px auto;" class="fcbtn btn btn-warning btn-outline btn-1c tooltip-warning fa fa-check"
                                                                   data-toggle="tooltip" data-placement="top" title="" data-original-title="برگرداندن اعتبار و ظرفیت برای امکان ویرایش رزرو">
                                                                </i>
                                                            </a>
                                                        </div>';
                }
            }
            $DataAction .= '<div class="pull-left margin-10">
                                                    <a onclick="ModalShowBookForHotel('."'" . $hotel['factor_number']."'".');return false" data-toggle="modal" data-target="#ModalPublic">
                                                        <i style="margin: 5px auto;"  class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="مشاهده خرید"></i>
                                                    </a>
                                                </div>';


            $DataAction .= '<div class="pull-left margin-10">';
            if ( $hotel['status'] == 'BookedSuccessfully' ) {
                $DataAction .= '<a href="' . SERVER_HTTP . $addressClient . '/gds/' . $linkView . '&num=' . $hotel['factor_number'] . '"
                                                           target="_blank"
                                                           title="مشاهده اطلاعات خرید" >
                                                            <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-danger btn-1c tooltip-danger fa fa-print "
                                                               data-toggle="tooltip" data-placement="top" title=""
                                                               data-original-title="مشاهده اطلاعات خرید"></i>
                                                        </a>';
                $DataAction .= '</div><div class="pull-left margin-10">';
            }
            if ( $hotel['status'] == 'BookedSuccessfully' ) {
                $DataAction .= '<a href="' . SERVER_HTTP . $addressClient . '/gds/pdf&target=' . $linkPDF . '&id=' . $hotel['factor_number'] . '"
                                                       target="_blank">
                                                        <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title=" رزرو هتل پارسی "></i>
                                                    </a>';
                $DataAction .= '</div><div class="pull-left margin-10">';
                $DataAction .= '
                <a onclick="ModalCancelHotelAdmin(' . "'" . $hotel['factor_number'] . "'" .  ",'" ."hotel'"  . '); return false ;"
                   target="_blank"
                   data-toggle="modal"
                   data-target="#ModalPublic"
                   >
                    <i class="fcbtn btn btn-outline btn-danger btn-1c tooltip-danger mdi mdi-close"
                       data-toggle="tooltip"
                       data-placement="top"
                       title=""
                       data-original-title="استرداد"
                       >
                    </i>
                </a>
                ';
                $DataAction .= '</div><div class="pull-left margin-10">';
            }

            if ( $hotel['status'] == 'BookedSuccessfully' ) {
                $DataAction .= '<a href="' . SERVER_HTTP . $addressClient . '/gds/pdf&lang=en&target=bookhotelshow&id=' . $hotel['factor_number'] . '"
                                   target="_blank">
                                    <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-file-pdf-o"
                                       data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title=" رزرو هتل انگلیسی "></i>
                                </a>';
                $DataAction .= '</div><div class="pull-left margin-10">';
            }
            if ( $hotel['status'] == 'BookedSuccessfully' &&  ( CLIENT_ID == 317 ) ) {
                $DataAction .= '<a href="' . SERVER_HTTP . $addressClient . '/gds/pdf&lang=en&target=bookNewhotelshow&id=' . $hotel['factor_number'] . '"
                                   target="_blank">
                                    <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-file-pdf-o"
                                       data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title=" بلیط انگلیسی هتل "></i>
                                </a>';
                $DataAction .= '</div><div class="pull-left margin-10">';
            }
            if ( $hotel['status'] == 'BookedSuccessfully' && CLIENT_ID == 271 ) {

                $DataAction .= ' <a onclick="ModalUploadProof(' . "'" . $hotel['factor_number'] . "'" .  ",'" ."Hotel'"  . ');return false" data-toggle="modal" data-target="#ModalPublic">
                                    <i style="margin: 5px auto;"  class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-upload"
                                       data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="آپلود فاکتور"></i>
                                </a>';
                $DataAction .= '</div><div class="pull-left margin-10">';
            }
            if ( in_array($hotel['status'], ['BookedSuccessfully','Cancelled','bank','credit','NoReserve']) && TYPE_ADMIN == '1') {
                $DataAction .= '<button data-factor-number="' . $hotel['factor_number'] . '" style="margin: 5px auto;" class="hotel-change-status fcbtn btn btn-outline btn-warning btn-1c tooltip-warning fa fa-undo"
                                       data-toggle="tooltip" data-placement="top" title="تغییر وضعیت به پیش رزرو"
                                       data-original-title="تغییر وضعیت به پیش رزرو">
                                </button>';
            }

            if (($hotel['status'] == 'bank' &&  TYPE_ADMIN == '1') || ($hotel['status'] == 'credit' &&  TYPE_ADMIN == '1') ) {
                $DataAction .= "<a onclick='insertHotelPnr(" . '"' . $hotel['request_number'] . '"' . "," . '"' . $hotel['client_id'] . '"' . "); return false ;'
                                                                           id='sendSms" . $hotel['request_number'] . "' target='_blank' data-toggle='modal' data-target='#ModalPublic'>
                                                                            <i class='fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-book'
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title='برای قطعی کردن و وارد کردن pnr کلیک کنید'></i></a>";
            }
            if (TYPE_ADMIN == '1' && $BuyFromIt == 0 && $hotel['status'] == 'BookedSuccessfully' && $hotel['service_type']=='اشتراکی') {
                $DataAction .= '<button data-factor-number="' . $hotel['factor_number'] . '" data-service="hotel"
                                        style="margin: 5px auto;" class="set-transaction fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-book"
                                       data-toggle="tooltip" data-placement="top" title="ثبت تراکنش"
                                       data-original-title="ثبت تراکنش">
                                </button>';
                $DataAction .= '</div><div class="pull-left margin-10">';
            }
            $DataAction .= '</div></div></li></ul></div>';

            if ( TYPE_ADMIN == '1' ) {
                $DataAction .= "<hr style='margin:3px'>".
                    '<a href="' . $transactionLink . '" data-toggle="tooltip" data-placement="top" data-original-title="آژانس مادر-مشاهده تراکنش ها"  target="_blank">'.functions::ClientName( $hotel['client_id'] ).'</a>';
                if ( $hotel['agency_name'] != '' ) {
                    $DataAction .= "<hr style='margin:3px'>
                                    <span title='آژانس زیر مجموعه' data-toggle='tooltip' class='agency-name'>".$hotel['agency_name'].'</span>';
                }

            }
            if ($hotel['status'] == 'Requested') {
                $DataActivity = ' <a class="btn btn-warning cursor-default" onclick="return false;" onclick="return false;">درخواست شده(پیش پرداخت)</a>';
            }
            elseif  ($hotel['status'] == 'RequestRejected') {
                $DataActivity = ' <a class="btn btn-success cursor-default" onclick="return false;"> درخواست رد شده</a>';
            }
            elseif  ($hotel['status'] == 'RequestAccepted') {
                $DataActivity = ' <a class="btn btn-success cursor-default" onclick="return false;"> درخواست تایید شده</a>';
            }
            elseif ( $hotel['status'] == 'BookedSuccessfully' ) {
                $DataActivity = '<a class="btn btn-success cursor-default" onclick="return false;"> رزرو قطعی</a>';
            } elseif ( $hotel['status'] == 'PreReserve' ) {
                $DataActivity = '<a class="btn btn-warning cursor-default" onclick="return false;">پیش رزرو</a>';
            } elseif ( $hotel['status'] == '' ) {
                $DataActivity = '<a class="btn btn-danger cursor-default" onclick="return false;">نامشخص</a>';
            } elseif ( $hotel['status'] == 'bank' ) {
                $DataActivity = '<a class="btn btn-primary cursor-default" onclick="return false;">هدایت به درگاه</a>';
            } elseif ( $hotel['status'] == 'Cancelled' && $hotel['admin_checked'] == 0 ) {
                $DataActivity = '<a class="btn btn-danger cursor-default" onclick="return false;">لغو درخواست</a>';
            } elseif ( $hotel['status'] == 'Cancelled' && $hotel['admin_checked'] == 1 ) {
                $DataActivity = '<a class="btn btn-danger cursor-default" onclick="return false;">کنسل شده</a>';
            } elseif ( $hotel['status'] == 'OnRequest' ) {
                $DataActivity = '<a class="btn btn-danger cursor-default" onclick="return false;">هتل استعلامی</a>';
            } elseif ( $hotel['status'] == 'pending' ) {
                $DataActivity = '<a class="btn btn-print cursor-warning" onclick="return false;">در حال صدور</a>';

            }else {

                $DataActivity = $this->btnErrorHotel($hotel);
            }

            if($hotel['manual_book'] == '1' && TYPE_ADMIN == '1'){
//                $DataActivity .= '<button class="btn btn-warning btn-1c btn-force-reserve" data-request_number="'.$hotel['factor_number'].'" data-type="'.TYPE_ADMIN .'" data-manual="'.$hotel['manual_book'].'" data-toggle="tooltip" title="تایید رزرو در سرور core"><i class="fa fa-Xmark"></i></button>';
                $DataActivity .= '<button class="btn btn-warning btn-1c btn-cancel-force-reserve" data-factor_number="'.$hotel['factor_number'].'" data-type="'.TYPE_ADMIN .'" data-manual="'.$hotel['manual_book'].'" data-toggle="tooltip" title="کنسل رزرو در سرور core"><i class="fa fa-times"></i></button>';

                $DataActivity .= "<a onclick='changePendingHotel(" . '"' . $hotel['factor_number'] . '"' . "," . '"' . $hotel['client_id'] . '"' . "); return false ;'
                                                            target='_blank' data-toggle='modal' data-target='#ModalPublic'>
                                                            <i class='fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-check'
                                                               data-toggle='tooltip'
                                                               data-placement='top' title=''
                                                               data-original-title='تایید رزرو در سرور core'></i></a>";
            }

            $final_agency_commission = '';
            $agencyShare = $DataAllPriceFor - $BuyFromIt;
            $ClssShare = 'bg-inverse';
            if($agencyShare > 0){
                $ClssShare = 'bg-success';
            }elseif($agencyShare < 0){
                $ClssShare = 'bg-danger';
            }
            $final_agency_commission .= '<span class="'.$ClssShare.' rounded-xl py-1 px-3 text-white d-inline-block" style="direction:ltr">'. number_format($agencyShare).'</span>';
            if ( $hotel['status'] == 'BookedSuccessfully' ){
                $TotalAgencyShare+=$agencyShare;
            }

            if (TYPE_ADMIN == 1) {
                $TitleAgencyShare='سود آژانس';
                $TitleBuyFromIt='خرید از ما';
                $TitlePayment='فروش آژانس <br> به مسافر';
                $TitleNameAgency='نام آژانس';
            }
            else {
                $TitleAgencyShare='سود شما';
                $TitleBuyFromIt='<span> خرید از <br>  سفر360 </span>';
                $TitlePayment=' فروش به مسافر<br/><del>تخفیف</del>';
                $TitleNameAgency='عملیات';
            }
            $ColorTr='';
            if($hotel['status'] == 'BookedSuccessfully' && $hotel['service_type']=='اشتراکی'){//رزرو قطعی از مدل اشتراکی باشد
                if($this->colorTrByStatusCreditBlak=='Yes'){//اعتبار مشتری منفی هست
                    $ColorTr='#444343';//مشکی
                }
                else if($this->colorTrByStatusCreditPurple=='Yes'){//یعنی اعبار بعد خرید کم نشده
                    $ColorTr='#b0a7dd';//بنفش
                }
                else if($BuyFromIt==0){//رکورد تراکنش مالی ندارد
                    $ColorTr='#f7c2c2';//قرمز
                }
            }

            $HotelData['data'][ $key ]["رنگ"]                                     = $ColorTr;
            $HotelData['data'][ $key ]["ردیف"]                                     = $key + 1;
            $HotelData['data'][ $key ][" شهر<br/>هتل"]                             = $DataCityHotel;
            $HotelData['data'][ $key ][" تاریخ خرید<br> ساعت خرید<br>نام خریدار"]  = $DataEnterInformation;
            $HotelData['data'][ $key ]["ورود<br>خروج<br> مدت اقامت"]               = $DataExitInformation;
            $HotelData['data'][ $key ]["شماره فاکتور"]                             = $DataFactorInformation.$DataRoomInformation;
            $HotelData['data'][ $key ][$TitleBuyFromIt]                            = $DataPrice;
            if(TYPE_ADMIN == 1){
                $HotelData['data'][ $key ]["سهم ما"]                               = $DataIranTechCommission;
            }
            $HotelData['data'][ $key ][$TitlePayment]                              = $DataAllPrice;
            $HotelData['data'][ $key ][$TitleAgencyShare]                          = $final_agency_commission;
            $HotelData['data'][ $key ][$TitleNameAgency]                           = $DataAction;
            $HotelData['data'][ $key ]["وضعیت"]                                    = $DataActivity;

            unset( $DataCityHotel, $DataEnterInformation, $DataExitInformation, $DataFactorInformation, $DataRoomInformation, $DataAgencyCommission, $DataPrice, $DataIranTechCommission, $DataAllPrice, $DataAction, $DataActivity );
        }

        $FooterData0  = '<th colspan="5"></th>';
        $FooterData0 .= '<th>' . number_format($TotalDataPrice) . '</th>';
        if (TYPE_ADMIN == '1') {
            $FooterData0 .= '<th>' . number_format($BookHotelController->priceForMa) . '</th>';
        }
        $FooterData0 .= '<th>' . number_format($BookHotelController->totalPrice) . '</th>';
        $FooterData0 .= '<th>' . number_format($TotalAgencyShare) . '</th>';
        $FooterData0 .= '<th colspan="2"></th>';
        $HotelData['footer'][0] = $FooterData0;

        $FooterData1  = '<th colspan="5"></th>';
        $FooterData1 .= '<th>'.$TitleBuyFromIt.'</th>';
        if (TYPE_ADMIN == '1') {
            $FooterData0 .= '<th>سهم ما</th>';
        }
        $FooterData1 .= '<th>'.$TitlePayment.'</th>';
        $FooterData1 .= '<th>'.$TitleAgencyShare.'</th>';
        $FooterData1 .= '<th colspan="2"></th>';
        $HotelData['footer'][1] = $FooterData1;

        return $HotelData;
    }
    public function MainHotelHistoryWebService( $param ) {

        /** @var bookhotelshow $BookHotelController */
        $BookHotelController = Load::controller( 'bookhotelshow' );

        if ( ! empty( $param['member_id'] ) ) {
            $intendedUser       = [
                "member_id" => $param['member_id'],
                "agency_id" => @$param['agency_id']
            ];

            $ListBookHotelLocal = $BookHotelController->listBookHotelLocalWebService( null, $intendedUser );
        } else {
            $ListBookHotelLocal = $BookHotelController->listBookHotelLocalWebService();
        }

        foreach ( $ListBookHotelLocal as $key => $hotel ) {

            if ( TYPE_ADMIN == '1' ) {
                $addressClient = $BookHotelController->ShowAddressClient( $hotel['client_id'] );
            } else {
                $addressClient = $BookHotelController->ShowAddressClient( CLIENT_ID );
            }
            $infoMember = functions::infoMember( $hotel['member_id'], $hotel['client_id'] );

            $DataCityHotel = $hotel['city_name'] . '
                                <hr style="margin:3px">' . $hotel['hotel_name'];
            if ( $hotel['payment_date'] != '' ) {
                $DataEnterInformation = $hotel['payment_date'] . '<hr style="margin:3px">';
            }
            if ( $hotel['payment_time'] != '' ) {
                $DataEnterInformation .= $hotel['payment_time'] . '<hr style="margin:3px">';
            }
            $DataEnterInformation .= $hotel['member_name'];
            if ( $hotel['services_discount'] != '' && $infoMember['is_member'] == '1' ) {
                $DataEnterInformation .= "<hr style='margin:3px'>";
                if ( $infoMember['fk_counter_type_id'] == '5' ) {
                    $DataEnterInformation .= 'مسافر';
                } else {
                    $DataEnterInformation .= 'کانتر';
                }
                $DataEnterInformation .= '<code>'. floatval($hotel['services_discount']).'%</code> ای';
            }
            $DataExitInformation = $hotel['start_date'];
            $DataExitInformation .= '<hr style="margin:3px">';
            $DataExitInformation .= $hotel['end_date'];
            $DataExitInformation .= '<hr style="margin:3px">';
            $DataExitInformation .= $hotel['number_night'] . ' شب';


            $DataFactorInformation = $hotel['type_application_fa'];
            $DataFactorInformation .= '<hr style="margin:3px">';
            $DataFactorInformation .= '<code>'.$hotel['factor_number'].'</code>';
            $DataFactorInformation .= '<hr style="margin:3px">';
            $DataFactorInformation .= '<kbd>'.$hotel['request_number'].'</kbd>';
//			$DataFactorInformation .= '<pre style="width: 100px">'.json_encode($hotel,256|64).'</pre>';


            $DataRoomInformation = '<div class="button-box">
                                    <button type="button" class="btn btn-default btn-outline"
                                            title="" data-toggle="popover"
                                            data-placement="top" data-content="' . $hotel['room'] . '"
                                            data-original-title="اتاق های رزرو شده">' . $hotel['room_count'] . '</button>
                                </div>';

            if ( $hotel['type_application'] == 'api' || $hotel['type_application'] == 'api_app' || $hotel['type_application'] == 'externalApi' ) {
                $DataAgencyCommission = $hotel['agency_commission'];

                $DataPrice            = number_format( $hotel['total_price_api']);
                if ( TYPE_ADMIN == '1' ) {
                    $DataIranTechCommission = number_format( $hotel['irantech_commission'] );
                }
            } else {
                $DataAgencyCommission = '-----';
                $DataPrice            = '-----';
                if ( TYPE_ADMIN == '1' ) {
                    $DataIranTechCommission = '-----';
                }

            }


            $DataAllPrice='';
            if(floatval($hotel['services_discount']) > 0){
                $price_with_change = $this->getController('BookingHotelNew')->getPriceWithChange($hotel['factor_number']);

                $DataAllPrice = '<span style="text-decoration: line-through;">'.  number_format($price_with_change) .'</span><br/>';
            }
            $DataAllPrice .=  number_format( $hotel['total_price']);

            $DataAllPriceFor = number_format( $hotel['total_price'] );

            $linkView = "ehotelLocal";
            $linkPDF  = "BookingHotelLocal";

            if ( CLIENT_NAME == 'آهوان' ) {
                $linkView = "ehotelAhuan";
                $linkPDF  = "hotelVoucherAhuan";
            } elseif ( CLIENT_NAME == 'زروان مهر آریا' ) {
                $linkView = "ehotelZarvan";
                $linkPDF  = "BookingHotelLocal";
            } else {
                $linkView = "ehotelLocal";
                $linkPDF  = "BookingHotelNew";
            }
            $DataAction = '<div class="btn-group m-r-10">

                                    <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button">  عملیات <span class="caret"></span></button>

                                    <ul role="menu" class="dropdown-menu animated flipInY mainTicketHistory-operation">
                                        <li>
                                            <div class="pull-left">';
            if ( $hotel['type_application'] == 'reservation' ) {
                $BookHotelController->getEditHotelBookingReport( $hotel['factor_number'] );
                if ( $BookHotelController->editHotelBooking == 'True' ) {
                    $DataAction .= '<div class="pull-left margin-10">
                                                            <a onclick="ModalShowEditBookHotel(' . "'" . $hotel['factor_number'] . "'" . ');return false" data-toggle="modal" data-target="#ModalPublic">
                                                                <i style="margin: 5px auto;"  class="fcbtn btn btn-success btn-outline btn-1c fa fa-list"
                                                                   data-toggle="tooltip" data-placement="top" title=""
                                                                   data-original-title="مشاهده ویرایش رزرو"></i>
                                                            </a>
                                                        </div>';
                }
                if ( $hotel['status'] == 'BookedSuccessfully' ) {
                    $DataAction .= '<div class="pull-left margin-10">
                                                            <a onclick="allowEditingHotel(' . "'" . $hotel['factor_number'] . "'" . ',' . "'" . $hotel['member_id'] . "'" . ');return false" title="ویرایش رزرو">
                                                                <i style="margin: 5px auto;" class="fcbtn btn btn-warning btn-outline btn-1c tooltip-warning fa fa-check"
                                                                   data-toggle="tooltip" data-placement="top" title="" data-original-title="برگرداندن اعتبار و ظرفیت برای امکان ویرایش رزرو">
                                                                </i>
                                                            </a>
                                                        </div>';
                }
            }
            $DataAction .= '<div class="pull-left margin-10">
                                                    <a onclick="ModalShowBookForHotel('."'" . $hotel['factor_number']."'".');return false" data-toggle="modal" data-target="#ModalPublic">
                                                        <i style="margin: 5px auto;"  class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="مشاهده خرید"></i>
                                                    </a>
                                                </div>';


            $DataAction .= '<div class="pull-left margin-10">';
            if ( $hotel['status'] == 'BookedSuccessfully' ) {
                $DataAction .= '<a href="' . SERVER_HTTP . $addressClient . '/gds/' . $linkView . '&num=' . $hotel['factor_number'] . '"
                                                           target="_blank"
                                                           title="مشاهده اطلاعات خرید" >
                                                            <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-danger btn-1c tooltip-danger fa fa-print "
                                                               data-toggle="tooltip" data-placement="top" title=""
                                                               data-original-title="مشاهده اطلاعات خرید"></i>
                                                        </a>';
                $DataAction .= '</div><div class="pull-left margin-10">';
            }
            if ( $hotel['status'] == 'BookedSuccessfully' ) {
                $DataAction .= '<a href="' . SERVER_HTTP . $addressClient . '/gds/pdf&target=' . $linkPDF . '&id=' . $hotel['factor_number'] . '"
                                                       target="_blank">
                                                        <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title=" رزرو هتل پارسی "></i>
                                                    </a>';
                $DataAction .= '</div><div class="pull-left margin-10">';
                $DataAction .= '
                <a 
                                                       onclick="ModalCancelHotelAdmin(' . "'" . $hotel['factor_number'] . "'" .  ",'" ."hotel'"  . '); return false ;"
                                                       target="_blank"
                                                       data-toggle="modal"
                                                       data-target="#ModalPublic"
                                                       >
                                                        <i class="fcbtn btn btn-outline btn-danger btn-1c tooltip-danger mdi mdi-close"
                                                           data-toggle="tooltip"
                                                           data-placement="top"
                                                           title=""
                                                           data-original-title="استرداد"
                                                           >
                                                        </i>
                                                    </a>
                ';
                $DataAction .= '</div><div class="pull-left margin-10">';
            }

            if ( $hotel['status'] == 'BookedSuccessfully' ) {
                $DataAction .= '<a href="' . SERVER_HTTP . $addressClient . '/gds/pdf&lang=en&target=bookhotelshow&id=' . $hotel['factor_number'] . '"
                                                       target="_blank">
                                                        <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-file-pdf-o"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title=" رزرو هتل انگلیسی "></i>
                                                    </a>';
                $DataAction .= '</div><div class="pull-left margin-10">';
            }
            if ( $hotel['status'] == 'BookedSuccessfully' && CLIENT_ID == 271 ) {

                $DataAction .= ' <a onclick="ModalUploadProof(' . "'" . $hotel['factor_number'] . "'" .  ",'" ."Hotel'"  . ');return false" data-toggle="modal" data-target="#ModalPublic">
                                    <i style="margin: 5px auto;"  class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-upload"
                                       data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="آپلود فاکتور"></i>
                                </a>';
                $DataAction .= '</div><div class="pull-left margin-10">';
            }
            if ( in_array($hotel['status'], ['BookedSuccessfully','Cancelled','bank','credit','NoReserve']) && TYPE_ADMIN == '1') {
                $DataAction .= '<button data-factor-number="' . $hotel['factor_number'] . '" style="margin: 5px auto;" class="hotel-change-status fcbtn btn btn-outline btn-warning btn-1c tooltip-warning fa fa-undo"
                                                           data-toggle="tooltip" data-placement="top" title="تغییر وضعیت به پیش رزرو"
                                                           data-original-title="تغییر وضعیت به پیش رزرو">
                                                    </button>';
            }

            if ($hotel['status'] == 'bank' &&  TYPE_ADMIN == '1' ) {
                $DataAction .= "<a onclick='insertHotelPnr(" . '"' . $hotel['request_number'] . '"' . "," . '"' . $hotel['client_id'] . '"' . "); return false ;'
                                                                           id='sendSms" . $hotel['request_number'] . "' target='_blank' data-toggle='modal' data-target='#ModalPublic'>
                                                                            <i class='fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-book'
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title='برای قطعی کردن و وارد کردن pnr کلیک کنید'></i></a>";
            }
            $DataAction .= '</div></div></li></ul></div>';

            if ( TYPE_ADMIN == '1' ) {
                $DataAction .= "<hr style='margin:3px'><span title='آژانس مادر' data-toggle='tooltip' class='client-name'>" .
                    functions::ClientName( $hotel['client_id'] ) .
                    "</span>";

                if ( $hotel['agency_name'] != '' ) {
                    $DataAction .= "<hr style='margin:3px'><span title='آژانس زیر مجموعه' data-toggle='tooltip' class='agency-name'>" .
                        $hotel['agency_name'] .
                        "</span>";
                }

            }

            if ( $hotel['status'] == 'BookedSuccessfully' ) {
                $DataActivity = '<a class="btn btn-success cursor-default" onclick="return false;"> رزرو قطعی</a>';
            } elseif ( $hotel['status'] == 'PreReserve' ) {
                $DataActivity = '<a class="btn btn-warning cursor-default" onclick="return false;">پیش رزرو</a>';
            } elseif ( $hotel['status'] == '' ) {
                $DataActivity = '<a class="btn btn-danger cursor-default" onclick="return false;">نامشخص</a>';
            } elseif ( $hotel['status'] == 'bank' ) {
                $DataActivity = '<a class="btn btn-primary cursor-default" onclick="return false;">هدایت به درگاه</a>';
            } elseif ( $hotel['status'] == 'Cancelled' && $hotel['admin_checked'] == 0 ) {
                $DataActivity = '<a class="btn btn-danger cursor-default" onclick="return false;">لغو درخواست</a>';
            } elseif ( $hotel['status'] == 'Cancelled' && $hotel['admin_checked'] == 1 ) {
                $DataActivity = '<a class="btn btn-danger cursor-default" onclick="return false;">کنسل شده</a>';
            } elseif ( $hotel['status'] == 'OnRequest' ) {
                $DataActivity = '<a class="btn btn-danger cursor-default" onclick="return false;">هتل استعلامی</a>';
            } else {
                $DataActivity = $this->btnErrorHotel($hotel);
            }

            if($hotel['manual_book'] == '1' && TYPE_ADMIN == '1'){
//                $DataActivity .= '<button class="btn btn-warning btn-1c btn-force-reserve" data-request_number="'.$hotel['factor_number'].'" data-type="'.TYPE_ADMIN .'" data-manual="'.$hotel['manual_book'].'" data-toggle="tooltip" title="تایید رزرو در سرور core"><i class="fa fa-Xmark"></i></button>';
                $DataActivity .= '<button class="btn btn-warning btn-1c btn-cancel-force-reserve" data-factor_number="'.$hotel['factor_number'].'" data-type="'.TYPE_ADMIN .'" data-manual="'.$hotel['manual_book'].'" data-toggle="tooltip" title="کنسل رزرو در سرور core"><i class="fa fa-times"></i></button>';

                $DataActivity .= "<a onclick='changePendingHotel(" . '"' . $hotel['factor_number'] . '"' . "," . '"' . $hotel['client_id'] . '"' . "); return false ;'
                                                            target='_blank' data-toggle='modal' data-target='#ModalPublic'>
                                                            <i class='fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-check'
                                                               data-toggle='tooltip'
                                                               data-placement='top' title=''
                                                               data-original-title='تایید رزرو در سرور core'></i></a>";
            }
            $this_commission = str_replace(',','',$DataAllPriceFor) - str_replace(',','',$DataPrice);
            $bg_class = 'bg-inverse';
            $final_agency_commission = '';
            if($this_commission > 0){
                $bg_class = 'bg-success';
//                $final_agency_commission .= '<code title="افزایش قیمت" data-toggle="tooltip" class="text-sm">'.$DataAgencyCommission.'</code><br>';
            }elseif($this_commission < 0){
                $bg_class = 'bg-danger';
            }

            $final_agency_commission .= '<span class="'.$bg_class.' rounded-xl py-1 px-3 text-white d-inline-block" style="direction:ltr">'. number_format($this_commission).'</span>';

            $HotelData['data'][ $key ]["ردیف"]                                     = $key + 1;
            $HotelData['data'][ $key ][" شهر<br/>هتل"]                             = $DataCityHotel;
            $HotelData['data'][ $key ][" تاریخ خرید<br> ساعت خرید<br>نام خریدار"]  = $DataEnterInformation;
            $HotelData['data'][ $key ][" تاریخ ورود<br> تاریخ خروج<br> مدت اقامت"] = $DataExitInformation;
            $HotelData['data'][ $key ]["شماره فاکتور"]                             = $DataFactorInformation;
            $HotelData['data'][ $key ]["اتاق"]                                     = $DataRoomInformation;
            $HotelData['data'][ $key ]["سهم آژانس"]                                = $final_agency_commission;
            $HotelData['data'][ $key ]["سهم کارگزار"]                              = $DataPrice;
            if(TYPE_ADMIN == 1){
                $HotelData['data'][ $key ]["سهم ما"]                                   = $DataIranTechCommission;
            }
            $HotelData['data'][ $key ]["قیمت کل"]                                  = $DataAllPrice;
            $HotelData['data'][ $key ]["عملیات"]                                   = $DataAction;
            $HotelData['data'][ $key ]["وضعیت"]                                    = $DataActivity;

            unset( $DataCityHotel, $DataEnterInformation, $DataExitInformation, $DataFactorInformation, $DataRoomInformation, $DataAgencyCommission, $DataPrice, $DataIranTechCommission, $DataAllPrice, $DataAction, $DataActivity );
        }


        $FooterData0 = '<th colspan="5"></th>
                                <th colspan=""></th>
                                <th colspan=""></th>
                                <th colspan="">(' . number_format( $BookHotelController->price ) . ') ريال</th>' . ( TYPE_ADMIN == '1' ? '<th colspan="">(' . number_format( $BookHotelController->priceForMa ) . ')ريال</th>' : '' ) . '<th colspan="">(' . number_format( $BookHotelController->totalPrice ) . ')ريال</th><th colspan="2"></th>';


        $HotelData['footer'][0] = $FooterData0;


        return $HotelData;
    }

    public function MainInsuranceHistory( $param ) {
        $transactions = $this->getTransactionsByDateRange($param['date_of'],$param['to_date'],$param['pnr'],$param['factor_number'],$param['request_number'],$param['passenger_name']);//list Transactions
        $TotalBuyFromIt=0;
        $TotalAgencyShare=0;
        $BookInsuranceController = Load::controller( 'bookingInsurance' );

        if ( ! empty( $param['member_id'] ) ) {
            $intendedUser      = [
                "member_id" => $param['member_id'],
                "agency_id" => @$param['agency_id']
            ];
            $ListBookInsurance = $BookInsuranceController->bookList( null, $intendedUser );
        } else {
            $ListBookInsurance = $BookInsuranceController->bookList();
        }

        foreach ( $ListBookInsurance as $key => $insurance ) {
            $this->colorTrByStatusCreditBlak='';
            $this->colorTrByStatusCreditPurple='';
            $transactionLink = ROOT_ADDRESS_WITHOUT_LANG . '/itadmin/transactionUser&id=' . $insurance['client_id'];
            $FActorNumberFor=rtrim($insurance['factor_number']);
            $DataPnr         = '<span dir="ltr"> ' . $insurance['creation_date_int'] . ' </span> <br />' . $insurance['pnr'].'<br />' . $insurance['passenger_name'] . ' ' . $insurance['passenger_family'];
            $DataDestination = $insurance['destination'] . '<br/><span class="FontBold" > '. $insurance['factor_number'].'</span><br/>' . $insurance['source_name_fa'] . '<br/> '.$insurance['caption'];
            if ( $insurance['is_member'] == '0' ) {
                $DataUserType = " کاربر مهمان <hr style='margin:3px'>" . $insurance['member_email'];
            } else {

                $DataUserType = $insurance['member_name'] . " <hr style='margin:3px'> کاربر اصلی";
            }
            $DataUserType .= '<hr style="margin:3px">
                                <span class=" fa fa-user" style="margin-left: 5px;">' . $insurance['adt_count'] . '</span>
                                <span class=" fa fa-child" style="margin-left: 5px;">' . $insurance['chd_count'] . '</span>
                                <span class=" fa fa-child" style="margin-left: 5px;">' . $insurance['inf_count'] . '</span>
                                <hr style="margin:3px">';
            if ( $insurance['is_member'] == '1' ) {
                if ( $insurance['fk_counter_type_id'] == '5' ) {
                    $DataUserType .= 'مسافر';
                } else {
                    $DataUserType .= 'کانتر';
                }
            }
            //$DataAgencyCommission = number_format( $insurance['agency_commission'] );

            if ( TYPE_ADMIN == '1' ) {
                $DataIranCommission = number_format( $insurance['irantech_commission'] );
            }
            $PassengerPayment=$insurance['totalPriceIncreased'];
            $DataUser = number_format( $PassengerPayment );
            $DataAgency = 'نامشخص' ;
            $BuyFromIt = isset($transactions[$FActorNumberFor]) ? $transactions[$FActorNumberFor] : 0;
            if ( $insurance['status'] != 'nothing' ) {

                $DataAgency = '<div class="btn-group m-r-10">


                                    <ul role="menu" class="animated flipInY mainTicketHistory-operation" style="list-style: none; padding: 0;">
                                        <li><a onclick="ModalShowBookForInsurance(' . "'" . $insurance['factor_number'] . "'" . ');return false" data-toggle="modal" data-target="#ModalPublic">
                                                <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                   data-toggle="tooltip" data-placement="top" title="" data-original-title="مشاهده خرید"></i>
                                            </a></li>';
                if(TYPE_ADMIN == '1' && $BuyFromIt == 0 && strpos($insurance['serviceTitle'], 'Public') === 0 && $insurance['status'] == 'book'){
                    $DataAgency .= ' <li>
                                                            <button data-factor-number="' . $insurance['factor_number'] . '" data-service="insurance"
                                        style="margin: 5px auto;" class="set-transaction fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-book"
                                       data-toggle="tooltip" data-placement="top" title="ثبت تراکنش"
                                       data-original-title="ثبت تراکنش">
                                </button></li>';
                }
                if($insurance['status'] == 'book' && CLIENT_ID == 271 ) {
                    $DataAgency .= ' <li>
                                                             <a onclick="ModalUploadProof(' . "'" . $insurance['factor_number'] . "'" .  ",'" ."Insurance'"  . ');return false" data-toggle="modal" data-target="#ModalPublic">
                                            <i style="margin: 5px auto;"  class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-upload"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="آپلود فاکتور"></i>
                                        </a></li>';
                }
                $DataAgency .= '</ul>';

                if ( TYPE_ADMIN == '1' ) {
                    $DataAgency .= '<hr style="margin:3px">
                                    <a href="' . $transactionLink . '" data-toggle="tooltip" data-placement="top" data-original-title="مشاهده تراکنش ها" target="_blank">' .  $insurance['NameAgency'] . '</a>';
                }
                $DataAgency .= "<hr style='margin:3px'>";
                if ( $insurance['payment_type'] == 'cash' ) {
                    $DataAgency .= "نقدی";
                } elseif ( $insurance['payment_type'] == 'credit' || $insurance['payment_type'] == 'member_credit' ) {
                    $DataAgency .= "اعتباری";
                }
                if ( TYPE_ADMIN == '1' && $insurance['payment_type'] == 'cash' ) {
                    $DataAgency .= "<hr style='margin:3px'>" . $insurance['numberPortBank'];
                }
                $DataAgency .= "</div>";
            }
            if ( TYPE_ADMIN == '1'  ) {

                if(strpos($insurance['serviceTitle'], 'Public') === 0) {
                    $DataAgency .= "<hr style='margin:3px'>اشتراکی" ;
                }else{
                    $DataAgency .= "<hr style='margin:3px'>اختصاصی";
                }

            }
            if ( $insurance['status'] == 'nothing' ) {
                $DataStatus = '<a href="#" onclick="return false;" class="btn btn-danger cursor-default"> نا مشخص </a>';
            } elseif ( $insurance['status'] == 'prereserve' ) {
                $DataStatus = '<a href="#" onclick="return false;" class="btn btn-warning cursor-default"> پیش رزرو </a>';
            } elseif ( $insurance['status'] == 'bank' ) {
                $DataStatus = '<a href="#" onclick="return false;" class="btn btn-primary cursor-default"> هدایت به درگاه </a>';
            } elseif ( $insurance['status'] == 'book' ) {
                $DataStatus = '<a href="#" onclick="return false;" class="btn btn-success cursor-default"> رزرو قطعی </a>';
            }

            if ( TYPE_ADMIN == '1' ) {
                $DataStatus .= "<hr style='margin:3px'>" . $insurance['remote_addr'];
            }

            $DataStatus .= "<hr style='margin:3px'>";
            if ( $insurance['reference_application'] == 'gds' ) {
                $DataStatus .= "gds";
            } elseif ( $insurance['reference_application'] == 'at' ) {
                $DataStatus .= "اتوماسیون";
            } elseif ( $insurance['reference_application'] == 'safar360' ) {
                $DataStatus .= "سفر360";
            }
            $DataBuyFromIt='';
            $BuyFromIt = isset($transactions[$FActorNumberFor]) ? $transactions[$FActorNumberFor] : 0;
            $DataBuyFromIt=number_format($BuyFromIt);
            if ( TYPE_ADMIN == 1 && $insurance['status'] == 'book' && strpos($insurance['serviceTitle'], 'Public') === 0 ) { //محاسبه اعتبار فعلی مشتری
                $DataBuyFromIt.=$this->CalculateCurrentCredit($insurance['client_id'],$FActorNumberFor,$BuyFromIt);
            }

            $agencyShare = $PassengerPayment - $BuyFromIt;
            $ClssShare = 'bg-inverse';
            if($agencyShare > 0){
                $ClssShare = 'bg-success';
            }elseif($agencyShare < 0){
                $ClssShare = 'bg-danger';
            }
            $DataAgencyShare= '<span class="'.$ClssShare.' rounded-xl py-1 px-3 text-white d-inline-block" style="direction:ltr">'. number_format($agencyShare).'</span>';
            if ($insurance['status'] == 'book'){
                $TotalBuyFromIt+=$BuyFromIt;
                $TotalAgencyShare+=$agencyShare;
            }

            if (TYPE_ADMIN == 1) {
                $TitleAgencyShare='سود آژانس';
                $TitleBuyFromIt='خرید از ما';
                $TitlePayment='فروش آژانس <br> به مسافر';
                $TitleNameAgency='نام آژانس';
            }
            else {
                $TitleAgencyShare='سود شما';
                $TitleBuyFromIt='<span> خرید از <br>  سفر360 </span>';
                $TitlePayment=' فروش به مسافر';
                $TitleNameAgency='عملیات';
            }

            $ColorTr='';
            if(strpos($insurance['serviceTitle'], 'Public') === 0 && $insurance['status'] == 'book'){//رزرو قطعی از مدل اشتراکی باشد

                if($this->colorTrByStatusCreditBlak=='Yes'){//اعتبار مشتری منفی هست
                    $ColorTr='#444343';//مشکی
                }
                else if($this->colorTrByStatusCreditPurple=='Yes'){//یعنی اعبار بعد خرید کم نشده
                    $ColorTr='#b0a7dd';//بنفش
                }
                else if($BuyFromIt==0){//رکورد تراکنش مالی ندارد
                    $ColorTr='#f7c2c2';//قرمز
                }
            }


            $DataTable['data'][ $key ]["رنگ"]                                                  = $ColorTr;
            $DataTable['data'][ $key ]["ردیف"]                                                 = $key + 1;
            $DataTable['data'][ $key ]["تاریخ خرید<br />شماره بیمه <br/> نام مسافر"]           = $DataPnr;
            $DataTable['data'][ $key ]["مقصد <br /> شماره فاکتور <br /> نوع بیمه<br />عنوان بیمه"]= $DataDestination;
            $DataTable['data'][ $key ]["نام خریدار<br /> نوع کاربر<br />تعداد<br />نوع کانتر"] = $DataUserType;
            $DataTable['data'][ $key ][$TitleBuyFromIt]                                        = $DataBuyFromIt;
            ( TYPE_ADMIN == '1' ? $DataTable['data'][ $key ][" سهم ما"] = $DataIranCommission : "" );
            $DataTable['data'][ $key ][$TitlePayment]                                           = $DataUser;
            $DataTable['data'][ $key ][$TitleAgencyShare]                                       = $DataAgencyShare;   //$DataAgencyCommission;
            $DataTable['data'][ $key ][$TitleNameAgency]                                        = $DataAgency;
            $DataTable['data'][ $key ]["وضعیت"]                                                 = $DataStatus;

        }

        $FooterData0  = '<th colspan="3"></th>';
        $FooterData0  .= '<th>';
        if ( TYPE_ADMIN == 1 ) {
            $Adl=$BookInsuranceController->adt_qty;
            $Chd=$BookInsuranceController->chd_qty;
            $Inf=$BookInsuranceController->inf_qty;
            $FooterData0  .= '
                                                  <span class=" fa fa-user" style="margin-left: 5px;">' . $Adl . '</span>
                                                  <span class=" fa fa-child" style="margin-left: 5px;">' . $Chd . '</span>
                                                  <span class=" fa fa-child" style="margin-left: 5px;">' . $Inf . '</span>
                                                  =>'.($Adl+$Chd+$Inf);
        }
        $FooterData0  .= '</th>';
        $FooterData0 .= '<th>' . number_format($TotalBuyFromIt) . '</th>';
        if (TYPE_ADMIN == 1) {
            $FooterData0 .= '<th>' . number_format($BookInsuranceController->totalOurCommission) . '</th>';
        }
        $FooterData0 .= '<th>' . number_format($BookInsuranceController->totalCost) . '</th>';
        $FooterData0 .= '<th>' . number_format($TotalAgencyShare) . '</th>';
        $FooterData0  .= '<th colspan="2"></th>';
        $DataTable['footer'][0] = $FooterData0;


        $FooterData1  = '<th colspan="4"></th>';
        $FooterData1 .= '<th>' . $TitleBuyFromIt . '</th>';
        if (TYPE_ADMIN == 1) {
            $FooterData1 .= '<th>سهم ما</th>';
        }
        $FooterData1 .= '<th>' . $TitlePayment . '</th>';
        $FooterData1 .= '<th>' . $TitleAgencyShare . '</th>';
        $FooterData1  .= '<th colspan="2"></th>';
        $DataTable['footer'][1] = $FooterData1;

        return $DataTable;
    }

    public function MainVisaHistory( $param ) {

        $BookVisaController = Load::controller( 'bookingVisa' );
        $ListBookVisa       = $BookVisaController->bookList();

        if ( ! empty( $param['member_id'] ) ) {
            $intendedUser = [
                "member_id" => $param['member_id'],
                "agency_id" => @$param['agency_id']
            ];
            $ListBookVisa = $BookVisaController->bookList( null, $intendedUser );
        } else {
            $ListBookVisa = $BookVisaController->bookList();
        }

        foreach ( $ListBookVisa as $key => $visa ) {

            $DataFactor = '<span dir="ltr"> ' . $visa['creation_date_int'] . ' </span> <br />' . $visa['factor_number'];
            $DataType   = $visa['visa_destination'] . '<br/>' . $visa['visa_type'];
            $DataTitle  = $visa['visa_title'];
            if ( $visa['is_member'] == '0' ) {
                $DataCounter = " کاربر مهمان <hr style='margin:3px'>" . $visa['member_email'];

            } else {
                $DataCounter = $visa['member_name'] . " <hr style='margin:3px'> کاربر اصلی";
            }
            $DataCounter .= '<hr style="margin:3px"><span class=" fa fa-user" style="margin-left: 5px;">' . $visa['adt_count'] . '</span>
                                <span class=" fa fa-child" style="margin-left: 5px;">' . $visa['chd_count'] . '</span>
                                <span class=" fa fa-child" style="margin-left: 5px;">' . $visa['inf_count'] . '</span>
                                <hr style="margin:3px">';
            if ( $visa['is_member'] == '1' ) {
                if ( $visa['fk_counter_type_id'] == '5' ) {
                    $DataCounter .= 'مسافر';
                } else {
                    $DataCounter .= 'کانتر';
                }
            }

            $DataAgencyPart = number_format( $visa['agency_commission'] );

            if ( TYPE_ADMIN == '1' ) {
                $DataIranCommission = number_format( $visa['irantech_commission'] );
            }

            if ( $visa['totalPrice'] != $visa['totalPayment'] ) {
                '<span style="text-decoration: line-through;">' . number_format( $visa['totalPrice'] ) . '</span> <br/>';
            }
            $DataPayment = number_format( $visa['totalPayment'] ) . '<br/>' . number_format( $visa['totalPrePayment'] );

            $DataVisaStatuses = '';

            if(is_array($visa['visa_statuses']) && $visa['status'] == 'book'){
                $DataVisaStatuses .= '
				<select class="change_visa_book_request_status form-control" data-visa=\''.json_encode($visa,256|64).'\'>
										<option value="">تعیین نشده</option>';
                foreach($visa['visa_statuses'] as $status_key => $status){
                    $selected = ($visa['visa_request_status']['id'] == $status_key) ? 'selected="selected"': '';

                    $DataVisaStatuses .= '<option data-selected="'.$visa['visa_request_status_id'].'" value="'.$status_key.'" '.$selected.'>'.$status.'</option>';
                }
                $DataVisaStatuses .= '</select>';
                ;
            }else{
                $DataVisaStatuses .= '----';
            }

            if ( $visa['status'] != 'nothing' ) {
                $DataAction = '<div class="btn-group m-r-10">

                                    <ul role="menu" class="animated flipInY mainTicketHistory-operation" style="list-style: none; padding: 0;">
                                        <li><a onclick="ModalShowBookForVisa(' . "'" . $visa['factor_number'] . "'" . ');return false" data-toggle="modal" data-target="#ModalPublic">
                                                <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                   data-toggle="tooltip" data-placement="top" title="" data-original-title="مشاهده خرید"></i>
                                            </a> </li>
                                    </ul>';


                if ( TYPE_ADMIN == '1' ) {
                    $DataAction .= "<hr style='margin:3px'>" . $visa['NameAgency'];
                }
                $DataAction .= "<hr style='margin:3px'>";
                if ( $visa['payment_type'] == 'cash' ) {
                    $DataAction .= "نقدی";
                } elseif ( $visa['payment_type'] == 'credit' || $visa['payment_type'] == 'member_credit' ) {
                    $DataAction .= "اعتباری";
                }
                if ( TYPE_ADMIN == '1' && $visa['payment_type'] == 'cash' && ( ($visa['status'] == 'book') || $visa['status'] == 'cancel') ) {
                    $DataAction .= "<hr style='margin:3px'>" . $visa['numberPortBank'];
                }

                if ( json_decode($visa['passengers_file'],true) ) {
                    $DataAction .= "<hr style='margin:3px'>";
                    $arrayFile  = json_decode( $visa['passengers_file'] );

                    $DataAction .= '<div class="btn-group m-r-10">
                                            <button aria-expanded="false" data-toggle="dropdown"
                                                    class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                    type="button">  دانلود مدارک <span class="caret"></span>
                                            </button>
                                            <ul role="menu" class="dropdown-menu animated flipInY mainTicketHistory-operation">
                                                <li>
                                                    <div class="pull-left">';
                    foreach ( $arrayFile as $k => $file ) {
                        $DataAction .= '<div class="pull-left margin-10">
                                        <a href="' . ROOT_ADDRESS_WITHOUT_LANG . '/pic/visaPassengersFiles/' . $file . '" target="_blank">
                                            <i style="margin: 5px auto;"  class="fcbtn btn btn-success btn-outline btn-1c fa fa-download"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="دانلود فایل ' . ( $k + 1 ) . '"></i>
                                        </a>
                                    </div>';
                    }
                    $DataAction .= '</div>
                                                </li>
                                            </ul>
                                        </div>';
                }
                $DataAction .= '</div>';
            }

            if ( $visa['status'] == 'nothing' ) {
                $DataStatus = '<a href="#" onclick="return false;" class="btn btn-danger cursor-default"> نا مشخص </a>';
            } elseif ( $visa['status'] == 'prereserve' ) {
                $DataStatus = '<a href="#" onclick="return false;" class="btn btn-warning cursor-default"> پیش رزرو </a>';
            } elseif ( $visa['status'] == 'bank' ) {
                $DataStatus = '<a href="#" onclick="return false;" class="btn btn-primary cursor-default"> هدایت به درگاه </a>';
            } elseif ( $visa['status'] == 'book' ) {
                $DataStatus = '<a href="#" onclick="return false;" class="btn btn-success cursor-default"> رزرو قطعی </a>';
            }

            if ( TYPE_ADMIN == '1' ) {
                $DataStatus .= "<hr style='margin:3px'>" . $visa['remote_addr'];
            }
            $DataTable['data'][ $key ]["ردیف"]                                                = $key + 1;
            $DataTable['data'][ $key ]["تاریخ خرید<br />شماره فاکتور"]                        = $DataFactor;
            $DataTable['data'][ $key ]["مقصد<br />نوع ویزا"]                                  = $DataType;
            $DataTable['data'][ $key ]["عنوان ویزا"]                                          = $DataTitle;
            $DataTable['data'][ $key ]["نام خریدار<br />نوع کاربر<br />تعداد<br />نوع کانتر"] = $DataCounter;
            $DataTable['data'][ $key ]["سهم آژانس"]                                           = $DataAgencyPart;
            ( TYPE_ADMIN == '1' ? $DataTable['data'][ $key ][" سهم ما"] = $DataIranCommission : "" );
            $DataTable['data'][ $key ]["مبلغ کل<br />مبلغ پرداختی"] = $DataPayment;
            $DataTable['data'][ $key ]["تعیین وضعیت"]                    = $DataVisaStatuses;
            $DataTable['data'][ $key ]["عملیات"]                    = $DataAction;
            $DataTable['data'][ $key ]["وضعیت"]                     = $DataStatus;


        }


        $FooterData0  = '<th colspan="5"></th>';
        $FooterData0 .= '<th>(' . $BookVisaController->totalAgencyCommission . ') ريال</th>';

        if (TYPE_ADMIN == 1) {
            $FooterData0 .= '<th>(' . $BookVisaController->totalOurCommission . ') ريال</th>';
        }

        $FooterData0 .= '<th colspan="3">(' . $BookVisaController->totalCost . ') ريال</th>';

        if (TYPE_ADMIN == 1) {
            $FooterData0 .= '<th colspan="2"></th>';
        } else {
            $FooterData0 .= '<th colspan="4"></th>';
        }

        $DataTable['footer'][0] = $FooterData0;
        if ( TYPE_ADMIN == 1 ) {
            $FooterData1            = '<th colspan="4">جمع بزرگسال(' . $BookVisaController->adt_qty . ')نفر</th>' . '<th colspan="4">جمع کودک(' . $BookVisaController->chd_qty . ')نفر</th>' . '<th colspan="3">جمع نوزاد(' . $BookVisaController->inf_qty . ')نفر</th>';
            $DataTable['footer'][1] = $FooterData1;
        }


        return $DataTable;
    }

    public function MainGashtHistory( $param ) {

        $BookGashtController = Load::controller( 'bookingGasht' );
        $ListBookGasht       = $BookGashtController->bookList();

        if ( ! empty( $param['member_id'] ) ) {
            $intendedUser  = [
                "member_id" => $param['member_id'],
                "agency_id" => @$param['agency_id']
            ];
            $ListBookGasht = $BookGashtController->bookList( null, $intendedUser );
        } else {
            $ListBookGasht = $BookGashtController->bookList();
        }

        foreach ( $ListBookGasht as $key => $gasht ) {
            $DataDate        = '<span dir="ltr">
                                    ' . $gasht['creation_date_int'] . '
                                </span>
                                    <br/>' . $gasht['passenger_serviceId'];
            $DataFactor      = $gasht['passenger_serviceCityName'] . '
                                    <br/>' . $gasht['passenger_serviceRequestType_fa'] . '
                                    <br/>' . $gasht['passenger_factor_num'];
            $DataServiceName = $gasht['passenger_serviceName'];

            if ( $gasht['is_member'] == '0' ) {
                $DataCounterType = 'کاربر مهمان' . " <hr style='margin:3px'>" . $gasht['member_email'];
            } else {

                $DataCounterType = $gasht['member_name'] . "<hr style='margin:3px'>
                    کاربر اصلی";
            }
            $DataCounterType .= '<hr style="margin:3px">
                                    ' . $gasht['passenger_number'];

            $DataAgencyPart = number_format( $gasht['agency_commission'] );
            if ( TYPE_ADMIN == '1' ) {
                $DataIranPart = number_format( $gasht['irantech_commission'] );

            }
            $DataPassenger = number_format( $gasht['passenger_servicePriceAfterOff'] ) . '<br/><span class="font11">' . $gasht['passenger_name'] . ' ' . $gasht['passenger_family'] . '</span>';

            if ( TYPE_ADMIN == '1' ) {
                $DataAgencyName = $gasht['agency_name'];
            }


            if ( $gasht['status'] != 'nothing' ) {
                $DataAction = '<div class="btn-group m-r-10">
                                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button">  عملیات <span class="caret"></span></button>

                                            <ul role="menu" class="dropdown-menu animated flipInY mainTicketHistory-operation">
                                                <li>
                                                    <div class="pull-left margin-10">
                                                    <a onclick="ModalShowBookForGasht(' . "'" . $gasht['passenger_factor_num'] . "'" . ');return false"
                                                       data-toggle="modal" data-target="#ModalPublic">
                                                        <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="مشاهده خرید"></i>
                                                    </a>
                                             </div>
                                                    <div class="pull-left margin-10">';
                if ( $gasht['status'] == 'book' ) {
                    $DataAction .= ' <a href="' . ROOT_ADDRESS . '/pdf&target=bookingGasht&id=' . $gasht['passenger_factor_num'] . '"
                                                               target="_blank"
                                                               title="مشاهده اطلاعات خرید" >
                                                                <i class="fcbtn btn btn-outline btn-danger btn-1c tooltip-danger fa fa-print "
                                                               
                                                                   data-toggle="tooltip" data-placement="top" title=""
                                                                   data-original-title="مشاهده اطلاعات خرید"></i>
                                                            </a>';
                }
                $DataAction .= "</div> </li> </ul> <hr style='margin:3px'>";
                if ( $gasht['payment_type'] == 'cash' ) {
                    $DataAction .= 'نقدی';
                } elseif ( $gasht['payment_type'] == 'credit' || $gasht['payment_type'] == 'member_credit' ) {
                    $DataAction .= 'اعتباری';

                }
                if ( TYPE_ADMIN == '1' && $gasht['payment_type'] == 'cash' ) {
                    $DataAction .= "<hr style='margin:3px'>" . $gasht['numberPortBank'];
                }
                $DataAction .= "</div>";
            }
            if ( $gasht['status'] == 'nothing' ) {

                $DataStatus = '<a href="#" onclick="return false;" class="btn btn-danger cursor-default"> نا
                                            مشخص </a>';
            } elseif ( $gasht['status'] == 'prereserve' ) {
                $DataStatus = '<a href="#" onclick="return false;" class="btn btn-warning cursor-default"> پیش
                                            رزرو </a>';
            } elseif ( $gasht['status'] == 'bank' ) {
                $DataStatus = '<a href="#" onclick="return false;" class="btn btn-primary cursor-default">
                                            هدایت به درگاه </a>';
            } elseif ( $gasht['status'] == 'book' ) {
                $DataStatus = '  <a href="#" onclick="return false;" class="btn btn-success cursor-default"> رزرو
                                            قطعی </a>';
            }
            if ( TYPE_ADMIN == '1' ) {
                $DataStatus .= '<hr style="margin:3px">
                                        ' . $gasht['remote_addr'];
            }
            $DataTable['data'][ $key ]["ردیف"]                                              = $key + 1;
            $DataTable['data'][ $key ]["تاریخ خرید<br/>شماره گشت یا ترانسفر"]               = $DataDate;
            $DataTable['data'][ $key ]["شهر گشت یا ترانسفر<br/>نوع سرویس<br/>شماره فاکتور"] = $DataFactor;
            $DataTable['data'][ $key ]["عنوان گشت یا ترانسفر"]                              = $DataServiceName;
            $DataTable['data'][ $key ]["نام خریدار<br/> نوع کاربر<br/>تعداد<br/>نوع کانتر"] = $DataCounterType;
            $DataTable['data'][ $key ]["سهم آژانس"]                                         = $DataAgencyPart;
            ( TYPE_ADMIN == '1' ? $DataTable['data'][ $key ][" سهم ما"] = $DataIranPart : "" );
            $DataTable['data'][ $key ]["مبلغ<br/>نام مسافر"] = $DataPassenger;
            ( TYPE_ADMIN == '1' ? $DataTable['data'][ $key ]["نام آژانس"] = $DataAgencyName : "" );
            $DataTable['data'][ $key ]["عملیات"] = $DataAction;
            $DataTable['data'][ $key ]["وضعیت"]  = $DataStatus;

        }


        $FooterData0 = '<th colspan="5"></th>'
            . '<th>(' . $BookGashtController->totalAgencyCommission . ')ريال</th>'
            . (TYPE_ADMIN == 1 ? '<th>(' . $BookGashtController->totalOurCommission . ')ريال</th>' : '')
            . '<th colspan="3">(' . $BookGashtController->totalCost . ')ريال</th>';
        $FooterData0 .= (TYPE_ADMIN == 1 ? '<th colspan="2"></th>' : '<th colspan="4"></th>');
        $DataTable['footer'][0] = $FooterData0;


        return $DataTable;
    }

    public function MainTourHistory( $param ) {

        $BookTourController  = Load::controller( 'bookTourShow' );
        $BookHotelController = Load::controller( 'bookhotelshow' );
        $tourReservationController=$this->getController('reservationTour');
        $ListBookTour        = $BookTourController->listBookTourLocal();

        if ( ! empty( $param['member_id'] ) ) {
            $intendedUser = [
                "member_id" => $param['member_id'],
                "agency_id" => @$param['agency_id']
            ];
            $ListBookTour = $BookTourController->listBookTourLocal( null, $intendedUser );
        } else {
            $ListBookTour = $BookTourController->listBookTourLocal();
        }



        foreach ( $ListBookTour as $key => $tour ) {
            $tourDetail=$tourReservationController->infoTourById($tour['tour_id']);
            $isRequest=false;
            if($tourDetail['is_request'] =='1')
                $isRequest=true;

            if ( TYPE_ADMIN == '1' ) {
                $addressClient = $BookHotelController::ShowAddressClient( $tour['client_id'] );
            } else {
                $addressClient = $BookHotelController::ShowAddressClient( CLIENT_ID );
            }
            $DataTourName = $tour['tour_name'] . '<hr style="margin:3px">' . $tour['tour_code'];
            if ( $tour['tour_discount'] != '' ) {
                $DataTourName .= '<hr style="margin:3px">';
                $DataTourName .= ( @$tour['tour_counter_id'] == '5' ? "مسافر" : "کانتر" );
                $DataTourName .= $tour['tour_discount'] . " %ای";
            }
            /*if( $tour['tour_discount'] != ''){
                $DataTourName.='<hr style="margin:3px">'.$tour['tour_discount'];
                if($tour['tour_discount_type'] == 'price'){
                    $DataTourName.='ریال';
                }else{
                    $DataTourName.='%';
                }
            }*/
            $DataDate = $tour['tour_start_date'] . '
                                <hr style="margin:3px">' . $tour['tour_end_date'];


            $DateDay = $tour['tour_night'] ;


            if ( $tour['payment_date'] != '' ) {
                $DataFactor = $tour['payment_date'] . '
                                <hr style="margin:3px">' . $tour['payment_time'];
            }
            $DataFactor .= '<hr style="margin:3px">' . $tour['factor_number'];


            if ( $tour['tour_discount'] == '' ) {
                $DataAllPrice = number_format( $tour['changed_tour_total_price'], 0, '.', ',');
            } else {
                $DataAllPrice =  '<span class="strikePrice" style="text-decoration: line-through;margin-left: 7px;">
                                                            <b class="pice-tour">' . number_format( $tour['changed_tour_origin_price'], 0, '.', ',' ) . '</b>
                                                        </span>' . number_format( $tour['tour_total_price'], 0, '.', ',' );
            }


            /*if( $tour['price'] != ''){
                $DataAllPrice.='<hr style="margin:3px">
                                    <span style="text-decoration: line-through;">'.($tour['tour_origin_price'] != 0)?number_format($tour['tour_total_price'],0,'.',','):number_format($tour['price'],0,'.',',').'</span>';

            }*/
            if ( $tour['status'] == 'BookedSuccessfully') {
                $DataAllPrice .= '<hr style="margin:3px">' . number_format($tour['total_price'], 0, '.', ',') . '
                <hr style="margin:3px">' . number_format($tour['cancellation_price'], 0, '.', ',');
            }else{
                $DataAllPrice .= '<hr style="margin:3px">' . number_format($tour['tour_payments_price'], 0, '.', ',') . '
                <hr style="margin:3px">' . number_format($tour['cancellation_price'], 0, '.', ',');
            }
            $DataAllPriceArzi = number_format( $tour['tour_total_price_a'], 0, '.', ',' ) . ' ' . $tour['currency_title_fa'] . '<hr style="margin:3px">' . number_format( $tour['tour_payments_price_a'], 0, '.', ',' ) . ' ' . $tour['currency_title_fa'];

            if ( $tour['tour_total_price_a'] > 0 && $tour['tour_total_price_a'] > $tour['tour_payments_price_a'] ) {
                $DataAllPriceArzi .= '<hr style="margin:3px">
                                    <div class="pull-left margin-10">
                                        <a onclick="setTourPaymentsPriceA(' . "'" . $tour['factor_number'] . "'" . ',' . "'" . $tour['tour_total_price_a'] . "'" . ');return false" title="پرداخت مبلغ ارزی">
                                            <i style="margin: 5px auto;" class="fcbtn btn btn-warning btn-outline btn-1c tooltip-warning fa fa-check"
                                               data-toggle="tooltip" data-placement="top" title="" data-original-title="تایید پرداخت مبلغ ارزی تور">
                                            </i>
                                        </a>
                                    </div>';
            }

            $DataAction = '<div class="btn-group m-r-10">

                                    <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button">  عملیات <span class="caret"></span></button>

                                    <ul role="menu" class="dropdown-menu animated flipInY mainTicketHistory-operation">
                                        <li>
                                            <div class="pull-left">

                                                <div class="pull-left margin-10">
                                                    <a onclick="ModalShowBookForTour(' . "'" . $tour['factor_number'] . "'" . ');return false" data-toggle="modal" data-target="#ModalPublic">
                                                        <i style="margin: 5px auto;"  class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="مشاهده خرید"></i>
                                                    </a>
                                                </div>';

            if ( $tour['status'] == 'BookedSuccessfully' || $tour['status'] == 'PreReserve' ) {
                $DataAction .= '<div class="pull-left margin-10">
                                                    <a href="' . ROOT_ADDRESS_WITHOUT_LANG . '/eTourReservation&num=' . $tour['factor_number'] . '"
                                                       target="_blank"
                                                       title="مشاهده اطلاعات خرید" >
                                                        <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-danger btn-1c tooltip-danger fa fa-print "
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="مشاهده اطلاعات خرید"></i>
                                                    </a>
                                                </div>

                                                <div class="pull-left margin-10">
                                                    <a href="' . ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=BookingTourLocal&id=' . $tour['factor_number'] . '"
                                                       target="_blank">
                                                        <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title=" رزرو تور پارسی "></i>
                                                    </a>
                                                </div>';
            }

            $DataAction .= '</div></li></ul></div>';

            if ( TYPE_ADMIN == '1' ) {
                $DataAction .= "<hr style='margin:3px'>";
                if ( $tour['agency_name'] != '' ) {
                    $DataAction .= $tour['agency_name'];
                } else {

                    $DataAction .= functions::ClientName( $tour['client_id'] );
                }
            }

            $DataAction .= "<hr style='margin:3px'>
                                " . $tour['member_name'];
            if ($isRequest && $tour['status'] == 'Requested') {
                $DataStatus = ' <a class="btn btn-success cursor-default" onclick="return false;">(در انتظار تایید)درخواست شده</a>';
            }
            elseif  ($isRequest && $tour['status'] == 'RequestRejected') {
                $DataStatus = ' <a class="btn btn-success cursor-default" onclick="return false;"> درخواست رد شده</a>';
            }
            elseif  ($isRequest && $tour['status'] == 'RequestAccepted') {
                $DataStatus = ' <a class="btn btn-success cursor-default" onclick="return false;"> درخواست تایید شده</a>';
            }
            elseif ( $tour['tour_total_price_a'] == 0 && $tour['status'] == 'BookedSuccessfully' ) {
                $DataStatus = ' <a class="btn btn-success cursor-default" onclick="return false;"> رزرو قطعی</a>';
            } elseif ( $tour['tour_total_price_a'] > 0 && $tour['tour_total_price_a'] == $tour['tour_payments_price_a'] && $tour['status'] == 'BookedSuccessfully' ) {
                $DataStatus = '<a class="btn btn-success cursor-default" onclick="return false;"> رزرو قطعی</a>';
            } elseif ( $tour['tour_total_price_a'] > 0 && $tour['tour_total_price_a'] > $tour['tour_payments_price_a'] && $tour['status'] == 'BookedSuccessfully' ) {
                $DataStatus = '<a class="btn btn-success cursor-default" onclick="return false;"> رزرو قطعی  ( بدون پرداخت مبلغ ارزی)</a>';
            } elseif ( $tour['status'] == 'TemporaryReservation' ) {
                $DataStatus = '<a class="btn btn-warning cursor-default" onclick="return false;">پیش رزرو (تایید شده توسط کانتر)</a>';
            } elseif ( $tour['status'] == 'PreReserve' ) {
                $DataStatus = '<a class="btn btn-primary cursor-default" onclick="return false;">رزرو موقت (پرداخت مبلغ پیش رزرو)</a>';
            } elseif ( $tour['status'] == 'TemporaryPreReserve' ) {
                $DataStatus = '<a class="btn btn-warning cursor-default" onclick="return false;">پیش رزرو موقت</a>';
            } elseif ( $tour['status'] == '' ) {
                $DataStatus = '<a class="btn btn-danger cursor-default" onclick="return false;">نامشخص</a>';
            } elseif ( $tour['status'] == 'bank' ) {
                $DataStatus = '<a class="btn btn-primary cursor-default" onclick="return false;">هدایت به درگاه</a>';
            } elseif ( $tour['status'] == 'Cancellation' ) {
                $DataStatus = '<a class="btn btn-danger cursor-default" onclick="return false;">کنسلی</a>
                                    <hr style="margin:3px">
                                    ' . $tour['cancellation_comment'];
            } else {
                $DataStatus = '<a class="btn btn-danger cursor-default" onclick="return false;">نامشخص</a>';
            }

            if ( $tour['cancel_status'] == 'CancellationR==uest' ) {
                $DataStatus .= '<hr style="margin:3px">
                                    <a class="btn btn-danger cursor-default" onclick="return false;">درخواست کنسلی از طرف مسافر</a>';
            } elseif ( $tour['cancel_status'] == 'ConfirmCancellationR==uest' ) {
                $DataStatus .= '<hr style="margin:3px">
                                    <a class="btn btn-danger cursor-default" onclick="return false;">تایید درخواست کنسلی از طرف کارگزار</a>';
            }

            $DataTable['data'][ $key ]["ردیف"]                                       = $key + 1;
            $DataTable['data'][ $key ]["نام تور<br/>کد تور"]                          = $DataTourName;
            $DataTable['data'][ $key ]["تاریخ رفت<br/>تاریخ برگشت"]                  = $DataDate;
            $DataTable['data'][ $key ]["چند شب / چند روز"]                           = $DateDay;
            $DataTable['data'][ $key ][" تاریخ خرید<br> ساعت خرید<br/>شماره فاکتور"] = $DataFactor;
            $DataTable['data'][ $key ]["قیمت کل<br>مبلغ پرداختی<br> جریمه کنسلی"]    = $DataAllPrice;
            $DataTable['data'][ $key ]["قیمت کل ارزی<br>مبلغ پرداختی ارزی"]          = $DataAllPriceArzi;
            $DataTable['data'][ $key ]["عملیات"]                                     = $DataAction;
            $DataTable['data'][ $key ]["وضعیت"]                                      = $DataStatus;
            $DataTourName                                                            = '';
            $DataDate                                                                = '';
            $DateDay                                                                 = '';
            $DataFactor                                                              = '';
            $DataAllPrice                                                            = '';
            $DataAllPriceArzi                                                        = '';
            $DataAction                                                              = '';
            $DataStatus                                                              = '';
        }


        $FooterData0 = '<th colspan="5"></th>
                            <th colspan="2">قیمت کل(' . number_format($BookTourController->totalPrice) . ')ريال</th>
                            <th colspan="2">مبلغ پرداختی(' . number_format($BookTourController->payment_price) . ')ريال</th>';

        $DataTable['footer'][0] = $FooterData0;

        return $DataTable;
    }
    public function MainExclusiveTourHistory( $param ) {


        $oldErrorLevel = error_reporting();
        error_reporting(E_ERROR | E_PARSE);

        if ( ! empty( $param['member_id'] ) ) {
            $intendedUser = [
                "member_id" => $param['member_id'],
                "agency_id" => @$param['agency_id']
            ];
            $ListBookExclusiveTour = $this->listBookExclusiveTourLocal( null, $intendedUser );
        } else {
            $ListBookExclusiveTour = $this->listBookExclusiveTourLocal();
        }


        if (empty($ListBookExclusiveTour)) {
            return [
                "footer" => [
                    "<th colspan=\"5\"></th><th>(0) ریال</th><th>(0) ریال</th><th colspan=\"3\">(0) ریال</th><th colspan=\"2\"></th>",
                    "<th colspan=\"4\">جمع بزرگسال(0)نفر</th><th colspan=\"4\">جمع کودک(0)نفر</th><th colspan=\"3\">جمع نوزاد(0)نفر</th>"
                ]
            ];
        }

        $transactions = $this->getTransactionsByDateRange($param['date_of'],$param['to_date'],$param['pnr'],$param['factor_number'],$param['request_number'],$param['passenger_name']);//list Transactions
        $adt_qty            = 0;
        $chd_qty            = 0;
        $inf_qty            = 0;
        $priceAgency        = 0;
        $priceMe            = 0;
        $pricetotal         = 0;
        $prsystem_price     = 0;
        $pubsystem_price    = 0;
        $charter_price      = 0;
        $pricesupplier      = 0;
        $totalQty           = 0;
        $CreditTotal        = 0;
        $charter_qty_type   = 0;
        $prSystem_qty_type  = 0;
        $pubSystem_qty_type = 0;
        $GetWayIranTech     = functions::DataIranTechGetWay();
        $FlightData         = [];
        $CountTicket        = '1';
        $RowCountTicket     = $this->CountTicket;
        foreach ( $ListBookExclusiveTour as $key => $flightBook ) {
            if($flightBook == null){
                continue;
            }
            $transactionLink          = ROOT_ADDRESS_WITHOUT_LANG . '/itadmin/transactionUser&id=' . $flightBook['client_id'];

            $DataFlightInfoMember     = functions::infoMember( $flightBook['member_id'], $flightBook['client_id'] );
            $DataFlightInfoCommission = functions::CommissionFlightSystemPublic( $flightBook['request_number'] );

            if ( ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                $totalQty = ( $flightBook['adt_qty_f'] + $flightBook['chd_qty_f'] + $flightBook['inf_qty_f'] ) + $totalQty;
            }

            $DataFlightType = dateTimeSetting::jdate( 'Y-m-d (H:i:s)', $flightBook['creation_date_int'] ) . "<hr style='margin:3px'><span class='FontBold'>" . $flightBook['request_number'] . "</span> <hr style='margin:3px'><span class='FontBold'> " . $flightBook['factor_number'] . "</span> <hr style='margin:3px'>";
//====================================Flight Information ==================
            if ( $flightBook['origin_city'] != '' && $flightBook['desti_city'] != '' ) {
                $DataFlightInformation  = $flightBook['origin_city'];
                $DataFlightInformation .= "<br/>";
                $DataFlightInformation .= $flightBook['desti_city'];

            }
            $DataFlightInformation .= "<hr style='margin:3px'>";
            if ( $flightBook['airline_name'] != "" ) {
                $DataFlightInformation .= $flightBook['airline_name']. " - " . $flightBook['ret_airline_name'];
            }
            $DataFlightInformation .= "<hr style='margin:3px'>";
            $DataFlightInformation .= $flightBook['flight_number']. " - " . $flightBook['ret_flight_number'];
            $DataFlightInformation .= "<hr style='margin:3px'>";

            $DataFlightInformation .=
                $flightBook['time_flight']
                . " - " .
                $flightBook['ret_time_flight'];

            $DataFlightInformation .= "<hr style='margin:3px'>";

            $DataFlightInformation .=
                $flightBook['date_flight']
                . " - " .
                $flightBook['ret_date_flight'];
//====================================Flight Information ==================
//====================================Hotel Information ===================

            $roomInfo = json_decode($flightBook['room_info'], true);
            $adults   = array_sum(array_column($roomInfo, 'Adults'));
            $children = array_sum(array_column($roomInfo, 'Children'));
            $DataHotelInformation = $flightBook['hotel_name'];
            $DataHotelInformation .= "<hr style='margin:3px'>";
            $DataHotelInformation .= '<span class=" fa fa-user" style="margin-left: 5px;">' . $adults . '</span><span class=" fa fa-child" style="margin-left: 5px;">' . $children . '</span>';
            $DataHotelInformation .= "<hr style='margin:3px'>";

            $DataHotelInformation .=
                $flightBook['date_flight']
                . " - " .
                $flightBook['ret_date_flight'];
//====================================Hotel Information ===================



            if ( $DataFlightInfoMember['is_member'] == '0' ) {
                //                $DataFlightCounterType=" کاربر مهمان <hr style='margin:3px'>".$flightBook['email_buyer'];
                $DataFlightCounterType = " کاربر مهمان ";
            } else {
                $DataFlightCounterType = $flightBook['member_name'] . "<hr style='margin:3px'> کاربراصلی";
            }
            $DataFlightCounterType .= "<hr style='margin:3px'>" . $this->info_flight( $flightBook['request_number'], $flightBook['member_email'] );

            if ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) {
                $adt_qty            = ( $this->adt_qty ) + $adt_qty;
                $chd_qty            = ( $this->chd_qty ) + $chd_qty;
                $inf_qty            = ( $this->inf_qty ) + $inf_qty;
                $charter_qty_type   = ( ( $this->charter_qty ) + $charter_qty_type );
                $prSystem_qty_type  = ( ( $this->prSystem_qty ) + $prSystem_qty_type );
                $pubSystem_qty_type = ( ( $this->pubSystem_qty ) + $pubSystem_qty_type );
            }
            $DataFlightCounterType .= "<hr style='margin:3px'>";
            if ( $DataFlightInfoMember['is_member'] == '1' ) {
                $DataFlightCounterType .= ( @$flightBook['fk_counter_type_id'] == '5' ? "مسافر" : "کانتر" );
                $DataFlightCounterType .= $flightBook['percent_discount'] . " %ای";
            }
            if ( $flightBook['agency_id'] > '0' ) {
                $DataFlightCounterType .= "<hr style='margin:3px'>آژانس " . $flightBook['agency_name'];
            }

            $TitleDetectDirection=functions::DetectDirection( $flightBook['factor_number'], $flightBook['request_number'] );
            $BuyFromIt=0;
            $this->colorTrByStatusCreditBlak='';
            $this->colorTrByStatusCreditPurple='';
            if ( $flightBook['flight_type'] != 'charterPrivate' ) {
                /*if ( TYPE_ADMIN == '1' ) {
                    $DataFlightTotalFree = '(' . number_format( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] ) . ')';
                    $DataFlightTotalFree .= "<br/>";
                    if ( $flightBook['adt_fare_sum'] > '0' ) {
                        $DataFlightTotalFree .= ( number_format( $flightBook['adt_fare_sum'] + $flightBook['chd_fare_sum'] + $flightBook['inf_fare_sum'] ) );
                    } else {
                        $DataFlightTotalFree .= ( number_format( $DataFlightInfoCommission['supplierCommission'] ) );
                    }
                    if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                        $pricesupplier = $flightBook['supplier_commission'] + $flightBook['irantech_commission'] + $pricesupplier;
                    }
                } else {
                    if ( ( $flightBook['api_id'] == '11' || $flightBook['api_id'] == '13' || $flightBook['api_id'] == '8' ) && $flightBook['flight_type'] == 'system' && $flightBook['pid_private'] == '0' ) {
                        $DataFlightTotalFree = '(' . number_format( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] ) . ')';
                        $DataFlightTotalFree .= "<br/>";
                        if ( $flightBook['adt_fare_sum'] > '0' ) {
                            $DataFlightTotalFree .= ( number_format( $flightBook['adt_fare_sum'] + $flightBook['chd_fare_sum'] + $flightBook['inf_fare_sum'] ) );
                        } else {
                            $DataFlightTotalFree .= ( number_format( $DataFlightInfoCommission['supplierCommission'] ) );
                        }
                    } else {
                        $DataFlightTotalFree = ( number_format( $flightBook['supplier_commission'] ) );
                    }
                    if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                        $pricesupplier +=  $flightBook['supplier_commission'] ;
                    }
                }*/
                //Ardalani1404
                if($TitleDetectDirection!='دوطرفه-برگشت') {
                    $DataFlightTotalFree = number_format($flightBook['total_price']);

                }
                else{
                    $DataFlightTotalFree ='0';
                }

            } else {
                $DataFlightTotalFree = "0";
            }

            if ( TYPE_ADMIN == 1 ) {
                $DataFlightIranTechCommission = "";
                if ( $flightBook['flight_type'] != 'charterPrivate' ) {
                    $DataFlightIranTechCommission .= number_format( $flightBook['irantech_commission'] );
                    if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                        $priceMe += $flightBook['irantech_commission'] ;
                    }
                } else {
                    $DataFlightIranTechCommission = '---';
                }
            }

            $PassengerPayment = 0;
            if ( $flightBook['flight_type'] != 'charterPrivate' ) {
                if ( $flightBook['flight_type'] == 'charter' ||  $flightBook['api_id'] == '14' ) {
                    if ( $flightBook['percent_discount'] > 0 ) {
                        $PassengerPayment=functions::CalculateDiscount( $flightBook['request_number'], 'yes' );
                        $DataFlightPassengerPayData = number_format( $PassengerPayment );
                        if(TYPE_ADMIN != 1){
                            $DataFlightPassengerPayData .= "<hr style='margin:3px'><span style='text-decoration: line-through;'>";
                            $DataFlightPassengerPayData .= number_format( $flightBook['agency_commission'] + $flightBook['supplier_commission'] + $flightBook['irantech_commission'] )
                                . '</span>';
                        }

                        if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                            $pricetotal    = ( $flightBook['agency_commission'] + $flightBook['supplier_commission'] + $flightBook['irantech_commission'] ) + $pricetotal;
                            $charter_price = $flightBook['agency_commission'] + $flightBook['supplier_commission'] + $flightBook['irantech_commission'] + $charter_price;
                        }
                    } else {
                        $PassengerPayment=functions::CalculateDiscount( $flightBook['request_number'], 'yes' );
                        $DataFlightPassengerPayData = number_format($PassengerPayment);

                        if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                            $pricetotal    = ( $flightBook['agency_commission'] + $flightBook['irantech_commission'] + $flightBook['supplier_commission'] ) + $pricetotal;
                            $charter_price = $flightBook['agency_commission'] + $flightBook['irantech_commission'] + $flightBook['supplier_commission'] + $charter_price;
                        }
                    }
                }
                elseif ( $flightBook['flight_type'] == 'system' ) {
                    if ( $flightBook['percent_discount'] > 0 ) {
                        $PassengerPayment=functions::CalculateDiscount( $flightBook['request_number'], 'No' );
                        $DataFlightPassengerPayData = number_format($PassengerPayment);
                        if(TYPE_ADMIN != 1){
                            $DataFlightPassengerPayData .= "<hr style='margin:3px'> <span style='text-decoration: line-through;'>";
                            $DataFlightPassengerPayData .= $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] . '</span>';
                        }
                        if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                            $pricetotal = ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] ) + $pricetotal;
                            if ( $flightBook['pid_private'] == '1' ) {
                                $prsystem_price += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                            } else {
                                $pubsystem_price += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                            }
                        }

                    } else {
                        if ( $flightBook['IsInternal'] == '0' ) {
                            $PassengerPayment=functions::CalculateDiscount( $flightBook['request_number'], 'No' );
                            $DataFlightPassengerPayData = number_format( $PassengerPayment );
                        } else {
                            $PassengerPayment=$flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] ;
                            $DataFlightPassengerPayData = number_format($PassengerPayment);
                        }
                        if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                            $pricetotal = ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] ) + $pricetotal;
                            if ( $flightBook['pid_private'] == '1' ) {
                                $prsystem_price += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                            } else {
                                $pubsystem_price += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                            }
                        }
                    }

                }
            }
            else {
                $InfoTicketReservation = $this->getInfoTicketReservation( $flightBook['request_number'] );
                if (TYPE_ADMIN != 1 && $InfoTicketReservation['totalPriceWithoutDiscount'] != 0 ) {
                    $DataFlightPassengerPayData = "<span style='text-decoration: line-through;'>" . number_format( $InfoTicketReservation['totalPriceWithoutDiscount'], 0, ".", "," ) . "</span><hr style='margin:3px'>";
                }
                $PassengerPayment=$InfoTicketReservation['totalPrice'];
                $DataFlightPassengerPayData .= number_format( $PassengerPayment, 0, ".", "," );
                $pricetotal                 = ( $InfoTicketReservation['totalPrice'] ) + $pricetotal;
            }
            $DataFlightPassengerPayData .= "<hr style='margin:3px'><span class='font11'>" . $flightBook['passenger_name_en'] . " " . $flightBook['passenger_family_en'] . "</span>";

            if ( $flightBook['flight_type'] == 'charter' || $flightBook['flight_type'] == 'system' ) {
                /* if ( ( $flightBook['api_id'] == '11' || $flightBook['api_id'] == '13' || $flightBook['api_id'] == '8' ) && ( $flightBook['flight_type'] == 'system' ) && $flightBook['pid_private'] == '0' ) {
                     $DataFlightAgencyShare = ( $flightBook['adt_fare_sum'] > 0 ) ? number_format( $flightBook['agency_commission'] ) : number_format( $DataFlightInfoCommission['agencyCommission'] );
                 } else {
                     $DataFlightAgencyShare = number_format( $flightBook['agency_commission'] );
                 }
                 if ( $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                     $priceAgency +=  $flightBook['agency_commission'] ;
                 }*/
                if($TitleDetectDirection=='دوطرفه-برگشت'){//تو ردیف رفت محاسبه میشه
                    $ArrInfoAgancyShare[$flightBook['factor_number']]['SellingReturnPassengerTickets']=$PassengerPayment;
                    $DataFlightAgencyShare ='---';
                }else {
                    if($TitleDetectDirection=='دوطرفه-رفت'){//تو ردیف رفت باید حساب برگشت رو هم کنیم
                        $agencyShare = ($PassengerPayment+ $ArrInfoAgancyShare[$flightBook['factor_number']]['SellingReturnPassengerTickets'])- $BuyFromIt;
                    }else{
                        $agencyShare = $PassengerPayment - $BuyFromIt;
                    }
                    $ClssShare = 'bg-inverse';
                    if($agencyShare > 0){
                        $ClssShare = 'bg-success';
                    }elseif($agencyShare < 0){
                        $ClssShare = 'bg-danger';
                    }
                    $DataFlightAgencyShare ='<span class="'.$ClssShare.' rounded-xl py-1 px-3 text-white d-inline-block" style="direction:ltr">'.number_format($agencyShare).'</span>';//پرداخت مسافر - خرید از ما
                    if ($flightBook['request_cancel'] != 'confirm' && ($flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve')) {
                        $priceAgency += $agencyShare;
                    }
                }

            } else {
                $DataFlightAgencyShare = '---';
            }

            if ( TYPE_ADMIN == '1' ) {
                //                $DataFlightActionBtn="<td style='direction: ltr;'>";
                if ( $flightBook['type_app'] == 'Web' || $flightBook['type_app'] == 'Application' || $flightBook['type_app'] == 'Api' ) {

                    if ( $flightBook['successfull'] != 'nothing' ) {
                        $DataFlightActionBtn = '<div class="btn-group m-r-10">
                                                    <button aria-expanded="false" data-toggle="dropdown"
                                                            class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                            type="button"> عملیات <span class="caret"></span></button>
                                                    <ul role="menu" class="dropdown-menu animated flipInY mainTicketHistory-operation">
                                                        <li>
                                                            <div class="pull-left">
                                                                <div class="pull-left margin-10">';
                        if ( $flightBook['successfull'] != 'nothing' ) {
                            $DataFlightActionBtn .= '<a onclick="ModalShowBookForExclusiveTour(' . "'" . $flightBook['request_number'] . "'" . ');return false" data-toggle="modal" data-target="#ModalPublic"> <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="مشاهده خرید"></i> </a>';
                        }
                        $DataFlightActionBtn .= '</div>

                        <div class="pull-left margin-10">';
                        $DataFlightActionBtn .= '</div>
                        <div class="pull-left margin-10">';
                        $DataFlightActionBtn .= '</div>';
                        $DataFlightActionBtn .= "<div class='pull-left margin-10'>";
                        if ( $flightBook['successfull'] == 'book' ) {
                            $DataFlightActionBtn .= '<a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/pdf&target=BookingReservationTicket&id=' . $flightBook['request_number'] . '"
                                                                           target="_blank">
                                                                            <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title=" بلیط پارسی "></i>
                                                                        </a>';
                        }
                        $DataFlightActionBtn .= '</div>';


                        $DataFlightActionBtn .= '<div class="pull-left margin-10">';
                        $DataFlightActionBtn .= '</div><div class="pull-left margin-10">';
                        $DataFlightActionBtn .= '</div>
                                            <div class="pull-left margin-10">';
                        $DataFlightActionBtn .= '</div>';

                        //                        if( ($flightBook['pid_private'] == '1' || $flightBook['api_id'] == '11' || $flightBook['api_id'] == '8' ) && ($flightBook['successfull'] == 'private_reserve' || $flightBook['successfull'] == 'book') && TYPE_ADMIN == '1'){
                        /*if($flightBook['successfull'] == 'book' || ($flightBook['successfull'] == 'credit' &&  TYPE_ADMIN == '1')){
                            $DataFlightActionBtn.="<div class='pull-left margin-10'><a onclick='FlightConvertToBook(".'"'.$flightBook['request_number'].'"'.",".'"'.$flightBook['client_id'].'"'."); return false ;'
                                                                           id='sendSms".$flightBook['request_number']."' target='_blank' data-toggle='modal' data-target='#ModalPublic'>
                                                                            <i class='fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-book'
                                                                               data-toggle='tooltip'
                                                                               data-placement='top' title=''
                                                                               data-original-title='برا قطعی کردن بلیط کلیک نمائید'></i></a></div>";
                        }*/
                        $DataFlightActionBtn .= '<div class="pull-left margin-10">';

                        $DataFlightActionBtn .= '</div>';

                        $DataFlightActionBtn .= "</div> </li> </ul> </div> <hr style='margin:3px'>";

                    }
                    $DataFlightActionBtn .= '<a href="' . $transactionLink . '" data-toggle="tooltip" data-placement="top"
                                               data-original-title="مشاهده تراکنش ها"
                                               target="_blank">' . $flightBook['NameAgency'] . '</a><br/>
                                            <hr style="margin:3px">';
                    if ( $flightBook['payment_type'] == 'cash' || $flightBook['payment_type'] == 'member_credit' ) {
                        if ( $flightBook['payment_type'] == 'cash' ) {
                            $DataFlightActionBtn .= 'نقدی';
                        } else {
                            $DataFlightActionBtn .= 'اعتباری';
                        }
                        if ( $flightBook['number_bank_port'] == '379918' ) {
                            if ( $flightBook['flight_type'] == 'charter' && $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                                $CashTotalMe += ( $flightBook['agency_commission'] + $flightBook['irantech_commission'] + $flightBook['supplier_commission'] );
                            } elseif ( $flightBook['flight_type'] == 'system' && $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                                $CashTotalMe += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                            }
                        } else {
                            if ( $flightBook['flight_type'] == 'charter' && $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                                $CashTotalMe += ( $flightBook['agency_commission'] + $flightBook['irantech_commission'] + $flightBook['supplier_commission'] );
                            } elseif ( $flightBook['flight_type'] == 'system' && $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                                $CashTotalMe += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                            }
                        }
                    } elseif ( $flightBook['payment_type'] == 'credit' ) {
                        $DataFlightActionBtn .= 'اعتباری';
                        if ( $flightBook['flight_type'] == 'charter' && $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                            $CreditTotal += ( $flightBook['agency_commission'] + $flightBook['irantech_commission'] + $flightBook['supplier_commission'] );
                        } elseif ( $flightBook['flight_type'] == 'system' && $flightBook['request_cancel'] != 'confirm' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                            $CreditTotal += ( $flightBook['adt_price'] + $flightBook['chd_price'] + $flightBook['inf_price'] );
                        }

                    } elseif ( $flightBook['payment_type'] == 'nothing' ) {
                        $DataFlightActionBtn .= 'نا مشخص';
                    }
                    if ( $flightBook['name_bank_port'] != '' ) {
                        $DataFlightActionBtn .= "<br> <hr style='margin:3px'>";
                        if (in_array($flightBook['number_bank_port'],$GetWayIranTech) || $flightBook['number_bank_port'] == '5b8c0bc6-7f26-11ea-b1af-000c295eb8fc' || $flightBook['number_bank_port'] == '379918' ) {
                            $DataFlightActionBtn .= "درگاه سفر360";
                        } else {
                            $DataFlightActionBtn .= " درگاه خودش";
                        }
                    }
                    if ( $flightBook['api_id'] == '1' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور5";
                    } elseif ( $flightBook['api_id'] == '5' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 4";
                    } elseif ( $flightBook['api_id'] == '14' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 14";
                    }elseif ( $flightBook['api_id'] == '15' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 15";
                    }elseif ( $flightBook['api_id'] == '16' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 16";
                    } elseif ( $flightBook['api_id'] == '17' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 17";
                    } elseif ( $flightBook['api_id'] == '12' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 12";
                    } elseif ( $flightBook['api_id'] == '13' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 13";
                    } elseif ( $flightBook['api_id'] == '8' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 7";
                    } elseif ( $flightBook['api_id'] == '10' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 9";
                    } elseif ( $flightBook['api_id'] == '11' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 10";
                    }elseif ( $flightBook['api_id'] == '18' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 18";
                    }elseif ( $flightBook['api_id'] == '19' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سرور 19";
                    }elseif ( $flightBook['api_id'] == '20' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سپهر";
                    }elseif ( $flightBook['api_id'] == '21' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> چارتر118";
                    }elseif ( $flightBook['api_id'] == '43' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'> سیتی نت";
                    }elseif ( $flightBook['api_id'] == '44' ) {
                        $DataFlightActionBtn .= "<hr style='margin:3px'>تور سپهر";
                    }

                }
                $DataFlightActionBtn .= "<hr style='margin:3px'>";

            } else {

                if ( $flightBook['successfull'] != 'nothing' ) {
                    if ( $flightBook['type_app'] == 'Web' || $flightBook['type_app'] == 'Application' ) {
                        $DataFlightActionBtn = ' <div class="btn-group m-r-10">
    
                                                        <button aria-expanded="false" data-toggle="dropdown"
                                                                class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                                type="button"> عملیات <span class="caret"></span></button>
    
                                                        <ul role="menu" class="dropdown-menu animated flipInY mainTicketHistory-operation">
                                                            <li>
                                                                <div class="pull-left">
                                                                    <div class="pull-left margin-10">';
                        //                        echo $DataFlightActionBtn; die();
                        if ( $flightBook['successfull'] != 'nothing' ) {

                            $DataFlightActionBtn .= '<a onclick="ModalShowBookForExclusiveTour(' . "'" . $flightBook['request_number'] . "'" . ');return false"
                                                                           data-toggle="modal"
                                                                           data-target="#ModalPublic">
                                                                            <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                                               data-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title=""
                                                                               data-original-title="مشاهده خرید"></i>
                                                                        </a>';
                        }
                        $DataFlightActionBtn .= ' </div>

                                                                ';


                        if ( ( $flightBook['IsInternal'] == '1' && $flightBook['successfull'] == 'book' ) || ( $flightBook['successfull'] == 'private_reserve' && TYPE_ADMIN == '1' ) ) {
                            $DataFlightActionBtn .= '<div class="pull-left margin-10"> <a href="' . SERVER_HTTP . $flightBook['DomainAgency'] . '/gds/pdf&target=parvazBookingLocal&id=' . $flightBook['request_number'] . '&lang=fa"
                                                                           target="_blank">
                                                                            <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title=""
                                                                               data-original-title=" بلیط پارسی "></i>
                                                                        </a></div>';
                        }



                        $DataFlightActionBtn .= '<div class="pull-left margin-10">';



                    }
                }

            }
            if ( $flightBook['type_app'] == 'Web' || $flightBook['type_app'] == 'Application' || $flightBook['type_app'] == 'Api' ) {
                if ( $flightBook['successfull'] == 'nothing' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;"
                                               class="btn btn-default cursor-default popoverBox  popover-default"
                                               data-toggle="popover" title="انصراف از خرید" data-placement="right"
                                               data-content="مسافر از تایید نهایی استفاده نکرده است"> انصراف از
                                                خرید </a>';
                } elseif ( $flightBook['successfull'] == 'error') {
                    $DataFlightCondition = $this->btnErrorFlight($flightBook);
                } elseif ( $flightBook['successfull'] == 'lock' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-warning cursor-default">
                                                پیش رزرو </a>';
                } elseif ( $flightBook['successfull'] == 'bank' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;"
                                               class="btn btn-primary cursor-default popoverBox  popover-primary"
                                               data-toggle="popover" title="هدایت به درگاه" data-placement="right"
                                               data-content="مسافر به درگاه بانکی منتقل شده است و سیستم در انتظار بازگشت از بانک است ،این خرید فقط در صورتی که بانک به سیستم کد تایید پرداخت را بدهد تکمیل میشود">
                                                هدایت به درگاه </a>';
                } elseif ( $flightBook['successfull'] == 'credit' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-default cursor-default ">
                                                انتخاب گزینه اعتباری </a>';
                } elseif ( $flightBook['successfull'] == 'processing' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-primary cursor-primary ">در حال پردازش</a>';
                }elseif ( $flightBook['successfull'] == 'pending' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-print cursor-warning ">در حال صدور</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1' && $flightBook['api_id'] == '1' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اختصاصی سرور 5</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['private_m4'] == '1' && $flightBook['IsInternal'] == '0' && $flightBook['api_id'] == '10' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو
                                                اختصاصی سرور 9</a>';
                } elseif ( $flightBook['successfull'] == 'book' && $flightBook['private_m4'] == '1' && $flightBook['IsInternal'] == '0' && $flightBook['api_id'] == '10' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو سرور 9</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['private_m4'] == '1' && $flightBook['IsInternal'] == '1' && $flightBook['api_id'] == '5' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو
                                                اختصاصی سرور 4</a>';
                } elseif ( $flightBook['successfull'] == 'book' && $flightBook['api_id'] == '11' && TYPE_ADMIN == '1' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default">
                                                اشتراکی سرور 10</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['api_id'] == '14' && TYPE_ADMIN == '1' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default">
                                                اختصاصی سرور 14</a>';
                }elseif (($flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve') && $flightBook['api_id'] == '15' && TYPE_ADMIN == '1' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default">
                                                 رزور قطعی سرور 15</a>';
                }elseif ( ($flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve') && $flightBook['api_id'] == '16' && TYPE_ADMIN == '1' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default">
                                                 رزرو قطعی سرور 16</a>';
                }elseif ( ($flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve') && $flightBook['api_id'] == '17' && TYPE_ADMIN == '1' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default">
                                                 رزرو قطعی سرور 17</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1' && $flightBook['api_id'] == '12' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اختصاصی سرور 12</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1' && $flightBook['api_id'] == '18' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اختصاصی سرور 18</a>';
                }elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1' && $flightBook['api_id'] == '20' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اختصاصی سرور چارتر118</a>';
                }elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1' && $flightBook['api_id'] == '21' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اختصاصی سرور 20</a>';
                }elseif ( $flightBook['successfull'] == 'book' && $flightBook['pid_private'] == '0' && $flightBook['api_id'] == '13' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اشتراکی سرور 13</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1' && $flightBook['IsInternal'] == '1' && $flightBook['api_id'] == '13' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو
                                                اختصاصی سرور 13</a>';
                } elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1'  && $flightBook['api_id'] == '8' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو
                                                اختصاصی سرور 7</a>';
                }elseif ( $flightBook['successfull'] == 'private_reserve' && $flightBook['pid_private'] == '1' && $flightBook['IsInternal'] == '1' && $flightBook['api_id'] == '19' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو
                                                اختصاصی سرور 19</a>';
                } elseif ( $flightBook['successfull'] == 'book' ) {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-success cursor-default">رزرو قطعی</a>';
                }else {
                    $DataFlightCondition = '<a href="#" onclick="return false;" class="btn btn-warning cursor-default">نامشخص</a>';
                }
                if(TYPE_ADMIN !='1')
                {
                    $client_id = CLIENT_ID ;
                    //&& ($flightBook['pid_private']=='1' || in_array($client_id,functions::clientsForDisplaySourceName()))
                    if ( $flightBook['api_id'] == '14' && ($flightBook['pid_private']=='1') ) {
                        $DataFlightCondition .= "<hr style='margin:3px'> رزرو از منبع پرتو";
                    } elseif ($flightBook['api_id'] == '8' && ($flightBook['pid_private']=='1') ) {
                        $DataFlightCondition .= "<hr style='margin:3px'> رزرو از منبع چارتر724";
                    }
                }
                if ( $flightBook['private_m4'] == '1' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) ) {
                    if ( $flightBook['pid_private'] == '1' && $flightBook['successfull'] == 'private_reserve' ) {
                        $DataFlightCondition .= '<hr style="margin:3px">
                                                <a id="Jump2Step' . $flightBook['request_number'] . '"
                                                   onclick="changeFlagBuyPrivate(' . $flightBook['request_number'] . ')"
                                                   href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearch?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-shopping-cart"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="برای ادامه خرید از سرور 5 کلیک نمائید"
                                                       id="i_Jump2Step' . $flightBook['request_number'] . '"></i></a>';
                    } elseif ( $flightBook['is_done_private'] == '2' && $flightBook['pid_private'] == '1' && $flightBook['successfull'] == 'private_reserve' ) {
                        $DataFlightCondition .= '<hr style="margin:3px">
                                                <a id="nextChangeFlag"
                                                   onclick="changeFlagBuyPrivate(' . $flightBook['request_number'] . ')"
                                                   href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearch?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-refresh"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="در حال رزرو"></i></a>';
                    }
                    if ( $flightBook['pid_private'] == '1' && $flightBook['private_m4'] == '1' && ( $flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve' ) && ( TYPE_ADMIN == '1' ) ) {
                        $DataFlightCondition .= '<a id="Jump2StepSourceFour' . $flightBook['request_number'] . '"
                                                   onclick="changeFlagBuyPrivateToPublic(' . $flightBook['request_number'] . ')"
                                                   href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearchSourceFour?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-search"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="برای ادامه خرید از سرور 10 کلیک نمائید"
                                                       id="Jump2StepSourceFour' . $flightBook['request_number'] . '"></i></a>
                                                <a id="Jump2StepSourceFour' . $flightBook['request_number'] . '"
                                                   onclick="changeFlagBuyPrivateToPublic(' . $flightBook['request_number'] . ')"
                                                   href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearchSourceFour?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '&SourceId=8"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-search"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="برای ادامه خرید از سرور 7 کلیک نمائید"
                                                       id="Jump2StepSourceFour' . $flightBook['request_number'] . '"></i></a>';
                    }
                }
                if ( $flightBook['provider_ref'] == '' && $flightBook['successfull'] == 'book' && TYPE_ADMIN == '1' && $flightBook['api_id'] == '10' ) {
                    $DataFlightCondition .= '<hr style="margin:3px"/><a id="Jump2StepSourceFour' . $flightBook['request_number'] . '"
                                               onclick="changeFlagBuyPrivateToPublic(' . $flightBook['request_number'] . ')"
                                               href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatSearchSourceNine?RequestNumber=' . $flightBook['request_number'] . '&TypeLevel=Final"
                                               target="_blank">
                                                <i class="fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-amazon"
                                                   data-toggle="tooltip" data-placement="right" title=""
                                                   data-original-title="برای ادامه خرید از سرور 9 کلیک نمائید"
                                                   id="Jump2StepSourceFour' . $flightBook['request_number'] . '"></i></a>';
                }
                if ( $flightBook['provider_ref'] == '' && $flightBook['successfull'] == 'book' && TYPE_ADMIN == '1' ) {
                    if ( $flightBook['api_id'] == '11' ) {
                        $DataFlightCondition .= '<hr style="margin:3px"/><a id="Jump2StepSourceFour' . $flightBook['request_number'] . '"
                                               onclick="changeFlagBuySystemPublic(' . $flightBook['request_number'] . ')"
                                                   href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearch?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '&Type=M10"
                                               target="_blank">
                                                <i class="fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-shopping-cart"
                                                   data-toggle="tooltip" data-placement="right" title=""
                                                   data-original-title="برای ادامه خرید از سرور 10 کلیک نمائید"
                                                   id="i_Jump2StepPublic' . $flightBook['request_number'] . '"></i></a>';
                    } elseif ( $flightBook['public_system_status'] == '2' && $flightBook['successfull'] == 'book' ) {
                        $DataFlightCondition .= '<hr style="margin:3px">
                                                    <a id="nextChangeFlag"
                                                       onclick="changeFlagBuyPrivate(' . $flightBook['request_number'] . ')"
                                                       href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearch?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '"
                                                       target="_blank">
                                                        <i class="fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-refresh"
                                                           data-toggle="tooltip" data-placement="right" title=""
                                                           data-original-title="در حال رزرو"></i></a>';
                    }

                    if ( $flightBook['api_id'] == '11' && $flightBook['provider_ref'] == '' && ( $flightBook['successfull'] == 'book' ) && ( TYPE_ADMIN == '1' ) ) {
                        $DataFlightCondition .= '<a id="Jump2StepPublic' . $flightBook['request_number'] . '"
                                                       onclick="changeFlagBuyPrivateToPublic(' . $flightBook['request_number'] . ')"
                                                       href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . '/ticket/repeatStepSearchSourceFour?ClientID=' . $flightBook['client_id'] . '&OriginIata=' . $flightBook['origin_airport_iata'] . '&DestinationIata=' . $flightBook['desti_airport_iata'] . '&DateFlight=' . functions::DateJalali( $flightBook['date_flight'] ) . '&RequestNumber=' . $flightBook['request_number'] . '&CabinType=' . $flightBook['cabin_type'] . '&FlightNumber=' . $flightBook['flight_number'] . '&AirLinIata=' . $flightBook['airline_iata'] . '"
                                                       target="_blank">
                                                        <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-search"
                                                           data-toggle="tooltip" data-placement="right" title=""
                                                           data-original-title="برای ادامه خرید از سرور 10 کلیک نمائید"
                                                           id="i_Jump2StepPublic' . $flightBook['request_number'] . '"></i></a>';
                    }

                }

                if ( $flightBook['provider_ref'] != '' ) {
                    $DataFlightCondition .= '<hr style="margin:3px">' . $flightBook['provider_ref'];
                }
                $DataFlightCondition .= '<hr style="margin:3px">' . $flightBook['remote_addr'] . '<hr style="margin:3px">';
                if ( $flightBook['type_app'] == 'Web' ) {
                    $DataFlightCondition .= 'وب سایت';
                } elseif ( $flightBook['type_app'] == 'Application' ) {
                    $DataFlightCondition .= 'اپلیکیشن';
                } elseif ( $flightBook['type_app'] == 'Api' ) {
                    $DataFlightCondition .= 'Api';
                }

                $flightBook['sub_agency'] ? $DataFlightCondition .= ' <hr style="margin:3px"> آژانس همکار:'.$flightBook['NameAgency'] .'<hr style="margin:3px">' : '';
            }
            if ( $key >= $param['RowCounter'] ) {
                $FlightDataNewest = 'new';
            } else {
                $FlightDataNewest = 'data';
            }

            if (TYPE_ADMIN == 1) {
                $TitleAgencyShare='سود آژانس';
                $TitleBuyFromIt='خرید از ما';
                $TitlePayment='فروش آژانس <br> به مسافر';
                $TitleNameAgency='نام آژانس';
            }
            else {
                $TitleAgencyShare='سود شما';
                $TitleBuyFromIt='<span> خرید از <br>  سفر360 </span>';
                $TitlePayment=' فروش به مسافر<br/><del>تخفیف</del>';
                $TitleNameAgency='عملیات';
            }

            $ColorTr='';
            if($flightBook['request_cancel'] != 'confirm' &&
                ($flightBook['successfull'] == 'book' || $flightBook['successfull'] == 'private_reserve') &&
                strpos($flightBook['serviceTitle'], 'Public') === 0 &&
                $TitleDetectDirection!='دوطرفه-برگشت'
            ){//رزرو قطعی از مدل اشتراکی باشد
                if($this->colorTrByStatusCreditBlak=='Yes'){//اعتبار مشتری منفی هست
                    $ColorTr='#444343';//مشکی
                }
                else if($this->colorTrByStatusCreditPurple=='Yes'){//یعنی اعبار بعد خرید کم نشده
                    $ColorTr='#b0a7dd';//بنفش
                }
                else if($BuyFromIt==0){//رکورد تراکنش مالی ندارد
                    $ColorTr='#f7c2c2';//قرمز
                }
            }
            $entertainmentHtml = '';
            if (!empty($flightBook['entertainment_data_json'])) {
                $entData = json_decode($flightBook['entertainment_data_json'], true);
                if (is_array($entData)) {
                    foreach ($entData as $ent) {
                        $title = isset($ent['tourTitle']) ? $ent['tourTitle'] : 'تفریح';
                        $price = isset($ent['final_price']) ? number_format($ent['final_price']) : 0;

                        $entertainmentHtml .= "{$title} <span style='color:#2d6a4f'>( {$price} )</span><br>";
                    }
                }
            }
            if ($entertainmentHtml === '') {
                $entertainmentHtml = '<span style="color:#888">بدون تفریح</span>';
            }


            $FlightData[ $FlightDataNewest ][ $key ]["رنگ"]                                                 = $ColorTr;
            $FlightData[ $FlightDataNewest ][ $key ]["ردیف"]                                                = $CountTicket ++;
            $FlightData[ $FlightDataNewest ][ $key ]["تاریخ خرید<br/>واچر<br/>بلیط<br/>"]                = $DataFlightType;
            $FlightData[ $FlightDataNewest ][ $key ]["اطلاعات پرواز"]                                        = $DataFlightInformation;
            $FlightData[ $FlightDataNewest ][ $key ]["اطلاعات هتل"]                                        = $DataHotelInformation;
            $FlightData[$FlightDataNewest][$key]["تفریحات"] = $entertainmentHtml;
            $FlightData[ $FlightDataNewest ][ $key ]["نام خریدار <br/> نوع کاربر<br/>تعداد<br/>نوع کانتر"]  = $DataFlightCounterType;
            $FlightData[ $FlightDataNewest ][ $key ][$TitlePayment]                                         = $DataFlightTotalFree;
            $FlightData[ $FlightDataNewest ][ $key ][$TitleNameAgency]                                      = $DataFlightActionBtn;
            $FlightData[ $FlightDataNewest ][ $key ]["وضعیت"]                                               = $DataFlightCondition;


            $DataFlightType               = '';
            $DataFlightInformation        = '';
            $DataFlightCounterType        = '';
            $DataFlightAgencyShare        = '';
            $DataFlightTotalFree          = '';
            $DataFlightPassengerPayData   = '';
            $DataFlightActionBtn          = '';
            $DataFlightCondition          = '';
        }



        return ( empty( $FlightData ) ? null : $FlightData );


    }
    public function listBookExclusiveTourLocal( $intendedUser = null ) {
        $date               = dateTimeSetting::jdate( "Y-m-d", time() );
        $date_now_explode   = explode( '-', $date );
        $date_now_int_start = dateTimeSetting::jmktime( 0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0] );
        $date_now_int_end   = dateTimeSetting::jmktime( 23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0] );


        if ( TYPE_ADMIN == '1' ) {
            $ModelBase = Load::library( 'ModelBase' );

            $sql = "SELECT rep.*, cli.AgencyName AS NameAgency, cli.Domain AS DomainAgency, "
                . " SUM(adt_qty) AS adt_qty_f,"
                . " SUM(chd_qty) AS chd_qty_f"
                . " FROM report_exclusive_tour_tb as rep"
                . " LEFT JOIN clients_tb AS cli ON cli.id = rep.client_id WHERE 1=1 ";


            /*    if (empty($_POST['cancel']) || ($_POST['cancel'] == 'No')) {
                    $sql .= " AND request_cancel <> 'confirm'";
                }*/


            if ( Session::CheckAgencyPartnerLoginToAdmin() ) {
                $sql .= " AND agency_id='{$_SESSION['AgencyId']}' ";

                if ( ! empty( $_POST['CounterId'] ) ) {
                    if ( $_POST['CounterId'] != "all" ) {
                        $sql .= " AND member_id ='{$_POST['CounterId']}'";
                    }
                }
            }

            if ( ! empty( $intendedUser['member_id'] ) ) {
                $sql .= ' AND member_id=' . $intendedUser['member_id'] . ' ';
            }

            if ( ! empty( $intendedUser['agency_id'] ) ) {
                $sql .= ' AND agency_id=' . $intendedUser['agency_id'] . ' ';
            }

            if(!empty($_POST['member_id'])){
                $sql.=' AND member_id='.$_POST['member_id'].' ';
            }

            if(!empty($_POST['agency_id'])){
                $sql.=' AND agency_id='.$_POST['agency_id'].' ';
            }

            if ( ! empty( $_POST['date_of'] ) && ! empty( $_POST['to_date'] ) ) {

                $date_of     = explode( '-', $_POST['date_of'] );
                $date_to     = explode( '-', $_POST['to_date'] );
                $date_of_int = dateTimeSetting::jmktime( 0, 0, 0, $date_of[1], $date_of[2], $date_of[0] );
                $date_to_int = dateTimeSetting::jmktime( 23, 59, 59, $date_to[1], $date_to[2], $date_to[0] );
                $sql         .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
            } else {

                $sql .= "AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";

            }

            if ( ! empty( $_POST['successfull'] ) ) {
                if ( $_POST['successfull'] == 'all' ) {

                    $sql .= " AND (successfull ='nothing' OR successfull ='book' OR successfull ='private_reserve' OR successfull ='credit' OR successfull ='bank' OR successfull ='prereserve' ) ";
                } else if ( $_POST['successfull'] == 'book' ) {
                    $sql .= " AND (successfull ='{$_POST['successfull']}' OR successfull='private_reserve')";
                } else {
                    $sql .= " AND (successfull ='nothing' OR successfull ='credit' OR successfull ='bank' OR successfull ='prereserve' ) ";
                }
            }

            if ( ! empty( $_POST['pnr'] ) ) {
                $sql .= " AND provider_ref ='{$_POST['pnr']}'";
            }
            if ( ! empty( $_POST['request_number'] ) ) {
                $sql .= " AND request_number ='{$_POST['request_number']}'";
            }

            if ( ! empty( $_POST['factor_number'] ) ) {
                $sql .= " AND factor_number ='{$_POST['factor_number']}'";
            }
            if ( ! empty( $_POST['client_id'] ) ) {
                if ( $_POST['client_id'] != "all" ) {
                    $sql .= " AND client_id ='{$_POST['client_id']}'";
                }
            }


            if ( ! empty( $_POST['passenger_name'] ) ) {
                $trimPassengerName = trim( $_POST['passenger_name'] );
                $sql               .= " AND (passenger_name LIKE '%{$trimPassengerName}%' OR passenger_family LIKE '%{$trimPassengerName}%')";
            }


            /*            if ( ! empty( $_POST['passenger_national_code'] ) ) {
                            $sql .= " AND (passenger_national_code ='{$_POST['passenger_national_code']}')";
                        }*/


            /*            if ( ! empty( $_POST['member_name'] ) ) {
                            $sql .= " AND member_name LIKE '%{$_POST['member_name']}%'";
                        }*/

            if ( ! empty( $_POST['payment_type'] ) ) {
                if ( $_POST['payment_type'] == 'all' ) {
                    $sql .= " AND (payment_type != '' OR payment_type != 'nothing')";
                } elseif ( $_POST['payment_type'] == 'credit' ) {
                    $sql .= " AND (payment_type = 'credit' OR payment_type = 'member_credit')";
                } else {
                    $sql .= " AND payment_type ='{$_POST['payment_type']}'";
                }
            }

            /*            if ( ! empty( $_POST['eticket_number'] ) ) {
                            $sql .= " AND (eticket_number ='{$_POST['eticket_number']}')";
                        }*/
            /*            if ( ! empty( $_POST['AirlineIata'] ) ) {
                            $sql .= " AND (airline_iata ='{$_POST['AirlineIata']}')";
                        }*/


            if ( ! empty( $_POST['DateFlight'] ) ) {
                $xpl = explode( '-', $_POST['DateFlight'] );

                $FinalDate = dateTimeSetting::jalali_to_gregorian( $xpl[0], $xpl[1], $xpl[2], '-' );

                $sql .= " AND date_flight Like'%{$FinalDate}%'";
            }
            if ( ! empty( $_POST['IsAgency'] ) ) {
                if ( $_POST['IsAgency'] == 'agency' ) {
                    $sql .= " AND agency_id <> '0' AND agency_id <> '5'";
                } else if ( $_POST['IsAgency'] == 'Ponline' ) {
                    $sql .= " AND agency_id = '0' OR agency_id = '5'";
                }
            }
            $sql      .= "GROUP BY rep.request_number ORDER BY rep.creation_date_int DESC, rep.id DESC  ";
            $BookShow = $ModelBase->select( $sql );
            $this->CountTicket = count( $BookShow );
        }else {
            $Model = Load::library( 'Model' );
            $sql   = "SELECT *, '" . CLIENT_DOMAIN . "' AS DomainAgency, "
                . " SUM(adt_qty) AS adt_qty_f,"
                . " SUM(chd_qty) AS chd_qty_f"
                . " FROM book_exclusive_tour_tb WHERE 1=1 ";

            if ( ! empty( $intendedUser['member_id'] ) ) {
                $sql .= ' AND member_id=' . $intendedUser['member_id'] . ' ';
            }

            if ( ! empty( $intendedUser['agency_id'] ) ) {
                $sql .= ' AND agency_id=' . $intendedUser['agency_id'] . ' ';
            }
            if(!empty($_POST['member_id'])){
                $sql.=' AND member_id='.$_POST['member_id'].' ';
            }

            if(!empty($_POST['agency_id'])){
                $sql.=' AND agency_id='.$_POST['agency_id'].' ';
            }
            if ( ! empty( $_POST['date_of'] ) && ! empty( $_POST['to_date'] ) ) {

                $date_of     = explode( '-', $_POST['date_of'] );
                $date_to     = explode( '-', $_POST['to_date'] );
                $date_of_int = dateTimeSetting::jmktime( 0, 0, 0, $date_of[1], $date_of[2], $date_of[0] );
                $date_to_int = dateTimeSetting::jmktime( 23, 59, 59, $date_to[1], $date_to[2], $date_to[0] );
                $sql         .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
            } else {
                $sql .= "AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";
            }

            if ( ! empty( $_POST['successfull'] ) ) {
                if ( $_POST['successfull'] == 'all' ) {

                    $sql .= " AND (successfull ='nothing' OR successfull ='book' OR successfull ='credit' OR successfull ='bank' ) ";
                } else if ( $_POST['successfull'] == 'book' ) {
                    $sql .= " AND successfull ='{$_POST['successfull']}'";
                } else {
                    $sql .= " AND (successfull ='nothing' OR successfull ='credit' OR successfull ='bank' ) ";
                }
            }


            /*            if ( ! empty( $_POST['flight_type'] ) ) {

                            if ( $_POST['flight_type'] == 'all' ) {
                                $sql .= " AND (flight_type ='system' OR flight_type ='charter')";
                            }elseif($_POST['flight_type'] == 'charter_private') {
                                $sql .= " AND flight_type ='charter' AND pid_private='1'";
                            }elseif($_POST['flight_type'] == 'system_private') {
                                $sql .= " AND flight_type ='system' AND pid_private='1'";
                            }else{
                                $sql .= " AND flight_type ='{$_POST['flight_type']}' AND pid_private='0'";
                            }
                        }*/

            if ( ! empty( $_POST['pnr'] ) ) {
                $sql .= " AND provider_ref ='{$_POST['pnr']}'";
            }

            if ( ! empty( $_POST['request_number'] ) ) {
                $sql .= " AND request_number ='{$_POST['request_number']}'";
            }

            if ( ! empty( $_POST['factor_number'] ) ) {
                $sql .= " AND factor_number ='{$_POST['factor_number']}'";
            }
            if ( ! empty( $_POST['passenger_name'] ) ) {
                $trimPassengerName = trim( $_POST['passenger_name'] );
                $sql               .= " AND (passenger_name LIKE '%{$trimPassengerName}%' OR passenger_family LIKE '%{$trimPassengerName}%')";
            }



            if ( ! empty( $_POST['member_name'] ) ) {
                $sql .= " AND member_name LIKE '%{$_POST['member_name']}%'";
            }

            if ( ! empty( $_POST['payment_type'] ) ) {
                if ( $_POST['payment_type'] == 'all' ) {
                    $sql .= " AND (payment_type != '' OR payment_type != 'nothing')";
                } elseif ( $_POST['payment_type'] == 'credit' ) {
                    $sql .= " AND (payment_type = 'credit' OR payment_type = 'member_credit')";
                } else {
                    $sql .= " AND payment_type ='{$_POST['payment_type']}'";
                }
            }

            if ( ! empty( $_POST['AirlineIata'] ) ) {
                $sql .= " AND (airline_iata ='{$_POST['AirlineIata']}')";
            }


            if ( ! empty( $_POST['DateFlight'] ) ) {
                $xpl = explode( '-', $_POST['DateFlight'] );

                $FinalDate = dateTimeSetting::jalali_to_gregorian( $xpl[0], $xpl[1], $xpl[2], '-' );

                $sql .= " AND date_flight ='{$FinalDate}'";
            }

            if ( ! empty( $_POST['IsAgency'] ) ) {

                if ( $_POST['IsAgency'] == 'agency' ) {
                    $sql .= " AND agency_id <> '0'";
                } else if ( $_POST['IsAgency'] == 'Ponline' ) {
                    $sql .= " AND agency_id = '0'";
                }
            }


            $get_session_sub_manage = Session::getAgencyPartnerLoginToAdmin();

            /*            if(Session::CheckAgencyPartnerLoginToAdmin() && $get_session_sub_manage=='AgencyHasLogin'){
                            $check_access = $this->getController('manageMenuAdmin')->getAccessServiceCounter(Session::getInfoCounterAdmin());

                            if($check_access){
                                $sql .= " AND serviceTitle IN ({$check_access})  ";


                            }
                            if(!empty($_POST['CounterId'])){
                                $sql.=' AND member_id='.$_POST['CounterId'].' ';
                            }


                        }*/
            $sql .= "  GROUP BY request_number ORDER BY creation_date_int DESC,id DESC ";


            /** @var partner $client_controller */
            $client_controller = Load::controller('partner');
            $sub_clients = $client_controller->subClient(CLIENT_ID) ;
            $book_sub_client = array();
            $BookShow = array();
            $admin = Load::controller( 'admin' );

            if(!isset($_POST['sub_client_id']) || empty($_POST['sub_client_id'])) {

                $BookShow = $Model->select($sql);

                foreach ($BookShow as $key=>$item) {
                    $BookShow[$key]['NameAgency'] = CLIENT_NAME ;
                    $BookShow[$key]['sub_agency'] = false ;
                }
                $this->CountTicket = count( $BookShow );
            }


            if(isset($_POST['sub_client_id']) && !empty($_POST['sub_client_id'])){
                $info_client_selected =$client_controller->infoClient($_POST['sub_client_id']);
                $book_sub_clients =  $admin->ConectDbClient( $sql, $_POST['sub_client_id'], "SelectAll", "", "", "" );
                foreach ($book_sub_clients as $key=>$book_sub_client ){
                    $BookShow [$key] = $book_sub_client ;
                    $BookShow [$key]['NameAgency'] = $info_client_selected['AgencyName'] ;
                    $BookShow [$key]['sub_agency'] = true ;
                }
                $this->CountTicket = count( $BookShow );
            }else{
                if(!empty($sub_clients)){
                    foreach ($sub_clients as $sub_client) {
                        $book_sub_clients =  $admin->ConectDbClient( $sql, $sub_client['id'], "SelectAll", "", "", "" );
                        foreach ($book_sub_clients as $key=>$book_sub_client ){
                            $BookShow [($this->CountTicket + $key)] = $book_sub_client ;
                            $BookShow [($this->CountTicket + $key)]['NameAgency'] = $sub_client['AgencyName'] ;
                            $BookShow [($this->CountTicket + $key)]['sub_agency'] = true ;
                        }
                        $this->CountTicket += count($book_sub_clients);
                    }
                }
            }


        }
        $final_book = array();
        foreach ($BookShow as $key_book=>$book){
            $final_book[$key_book]['creation_date_int'] = $book['creation_date_int'];
        }


        array_multisort($final_book['creation_date_int'],SORT_DESC,$BookShow );

//        echo json_encode($BookShow,256); die();

        return $BookShow;
    }

    public function MainBusHistory( $param ) {
        $transactions = $this->getTransactionsByDateRange($param['date_of'],$param['to_date'],$param['pnr'],$param['factor_number'],$param['request_number'],$param['passenger_name']);//list Transactions
        $TotalBuyFromIt=0;
        $TotalAgencyShare=0;

        $BookBusController = Load::controller( 'bookingBusShow' );
        if ( ! empty( $param['member_id'] ) ) {
            $intendedUser = [
                "member_id" => $param['member_id'],
                "agency_id" => @$param['agency_id']
            ];
            $ListBookBus  = $BookBusController->listBookBusTicket( null, $intendedUser );
        } else {
            $ListBookBus = $BookBusController->listBookBusTicket();
        }

        foreach ( $ListBookBus as $key => $bus ) {
            $this->colorTrByStatusCreditBlak='';
            $this->colorTrByStatusCreditPurple='';
            $transactionLink= ROOT_ADDRESS_WITHOUT_LANG . '/itadmin/transactionUser&id=' . $bus['client_id'];
            $FActorNumberFor=rtrim($bus['FactorNumber']);

            if ( $bus['Status'] == 'book' && $bus['seen_at'] == null ) {
                $Condition_bus_tb = " id='{$bus['Id']}'";
                if ( TYPE_ADMIN == '1' ) {
                    $ModelBase = Load::library( 'ModelBase' );
                    $ModelBase->setTable( 'report_bus_tb' );
                    $updateSeenAt['seen_at'] = date( 'Y-m-d H:i:s' );
                    $res                     = $ModelBase->update( $updateSeenAt, $Condition_bus_tb );
                } else {
                    $Model = Load::library( 'Model' );
                    $Model->setTable( 'book_bus_tb' );
                    $updateSeenAt['seen_at'] = date( 'Y-m-d H:i:s' );
                    $res                     = $Model->update( $updateSeenAt, $Condition_bus_tb );
                }
            }

            $infoClient = functions::infoClient( $bus['client_id'] );
            $infoMember = functions::infoMember( $bus['MemberId'], $bus['ClientId'] );
            if ( $bus['PaymentDate'] != '' ) {
                $DataCounter = $bus['PaymentDate'] . ' ' . $bus['PaymentTime'] . '<hr style="margin:3px">';
            }
            $DataCounter .= $bus['MemberName'] . "<hr style='margin:3px'>";
            if ( $infoMember['fk_counter_type_id'] == '5' ) {
                $DataCounter .= "مسافر";
            } else {
                $DataCounter .= "کانتر";
            }
            if ( $bus['ServicesDiscount'] != '' && $infoMember['is_member'] == '1' ) {
                $DataCounter .= $bus['ServicesDiscount'] . " %ای";
            }
            $DataDestination        = $bus['OriginName'] . '<hr style="margin:3px">' . $bus['DestinationCity'].'<hr style="margin:3px">'.$bus['PassengerName'] . '<hr style="margin:3px">' . $bus['PassengerMobile'];
            $DataMoveOnTime         = $bus['DateMove'] . '<hr style="margin:3px">' . $bus['TimeMove'];
            $DataBus                = $bus['BaseCompany'] . '<hr style="margin:3px">' . $bus['CarType'];
            $DataSeat               = '<span class="FontBold" >'.$bus['FactorNumber'] . '</span><hr style="margin:3px">' . $bus['pnr'] . '<hr style="margin:3px">' . $bus['PassengerChairs']. '<hr style="margin:3px">' .$bus['passenger_number'];
            $DataIrantechCommission = number_format( $bus['IrantechCommission'], '0', '.', ',' ) . '<hr style="margin:3px">' . number_format( $bus['priceForMa'], '0', '.', ',' );
            $DataTotalPrice         = number_format( $bus['totalPrice'], '0', '.', ',' );

            $BuyFromIt = isset($transactions[$FActorNumberFor]) ? $transactions[$FActorNumberFor] : 0;
            $DataBuyFromIt=number_format($BuyFromIt);
            if ( TYPE_ADMIN == 1 && $bus['Status'] == 'book' && $bus['service_type']=='اشتراکی') { //محاسبه اعتبار فعلی مشتری
                $DataBuyFromIt.=$this->CalculateCurrentCredit($bus['client_id'],$FActorNumberFor,$BuyFromIt);
            }
            $agencyShare=$bus['total_price']-$BuyFromIt;
            $ClssShare = 'bg-inverse';
            if($agencyShare > 0){
                $ClssShare = 'bg-success';
            }elseif($agencyShare < 0){
                $ClssShare = 'bg-danger';
            }
            $DataAgencyCommission= '<span class="'.$ClssShare.' rounded-xl py-1 px-3 text-white d-inline-block" style="direction:ltr">'. number_format($agencyShare).'</span>';
            if ($bus['Status'] == 'book'){
                $TotalBuyFromIt +=$BuyFromIt;
                $TotalAgencyShare +=$agencyShare;
            }


            if ( TYPE_ADMIN == '1' ) {
                $addressClient = $BookBusController->ShowAddressClient( $bus['ClientId'] );
            } else {
                $addressClient = $BookBusController->ShowAddressClient( CLIENT_ID );
            }
            if ( $bus['Status'] != 'nothing' ) {
                $DataAction = '<div class="btn-group m-r-10">
                                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button">  عملیات <span class="caret"></span></button>

                                            <ul role="menu" class="dropdown-menu animated flipInY mainTicketHistory-operation-bus">
                                                <li>
                                                    <div class="pull-left margin-10">
                                                        <a onclick="ModalShowBookForBus(' . "'" . $bus['FactorNumber'] . "'" . ');return false"
                                                           data-toggle="modal" data-target="#ModalPublic">
                                                            <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                               data-toggle="tooltip" data-placement="top" title=""
                                                               data-original-title="مشاهده خرید"></i>
                                                        </a>
                                                    </div>';
                if ( $bus['Status'] == 'book' ) {
                    $DataAction .= '<div class="pull-left margin-10">
                                        <a href="' . ROOT_ADDRESS_WITHOUT_LANG . '/eBusTicket&num=' . $bus['FactorNumber'] . '"
                                           target="_blank"
                                           title="مشاهده اطلاعات خرید" >
                                            <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-danger btn-1c tooltip-danger fa fa-print"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="مشاهده اطلاعات خرید"></i>
                                        </a>
                                    </div>
                                    <div class="pull-left margin-10">
                                     <a href="' . ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=busBoxCheck&id=' . $bus['FactorNumber'] . '"
                                           target="_blank"
                                           title="قبض صندوق" >
                                            <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-warning btn-1c  tooltip-warning fa fa-money"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="قبض صندوق"></i>
                                        </a>
                                    </div>
                                     <div class="pull-left margin-10">
                                        <a href="' . ROOT_ADDRESS_WITHOUT_LANG. '/pdf&target=bookingBusShow&id=' . $bus['FactorNumber'] . '"
                                           target="_blank"
                                           title="مشاهده اطلاعات خرید" >
                                            <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="مشاهده اطلاعات خرید"></i>
                                        </a>
                                    </div>
                                    <div class="pull-left margin-10">
                                        <a href="' . ROOT_ADDRESS_WITHOUT_LANG. '/pdf&target=bookingBusShow&id=' . $bus['FactorNumber'] . '&cash=no"
                                           target="_blank"
                                           title="بلیط بدون قیمت" >
                                            <i class="fcbtn btn btn-outline btn-default btn-1c tooltip-default fa fa-ticket"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="بلیط بدون قیمت"></i>
                                        </a>
                                    </div>
                                    <div class="pull-left margin-10">
                                        <a href="' . ROOT_ADDRESS_WITHOUT_LANG. '/pdf&target=bookingBusForeign&id=' . $bus['FactorNumber'] . '"
                                           target="_blank"
                                           title="بلیط خارجی" >
                                            <i class="fcbtn btn btn-outline btn-success btn-1c tooltip-default fa fa-file-pdf-o"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="بلیط خارجی"></i>
                                        </a>
                                    </div>
                                    <div class="pull-left margin-10">
                                        <a 
                                           title="استرداد" 
                                           onclick="ModalCancelFlightAdmin(' . "'" . $bus['OrderCode'] . "'" .  ",'" ."bus'"  . '); return false ;"
                                           target="_blank"
                                           data-toggle="modal"
                                           data-target="#ModalPublic"
                                           >
                                            <i class="fcbtn btn btn-outline btn-danger btn-1c tooltip-danger mdi mdi-close"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="استرداد"></i>
                                        </a>
                                    </div>  
                                    ';
                    if(TYPE_ADMIN == '1'  && $BuyFromIt == 0 && $bus['Status'] == 'book' && $bus['service_type']=='اشتراکی'){
                        $DataAction .= '  <div class="pull-left margin-10">
                                            <button data-factor-number="' . $FActorNumberFor . '" data-service="bus"
                                        style="margin: 5px auto;" class="set-transaction fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-book"
                                       data-toggle="tooltip" data-placement="top" title="ثبت تراکنش"
                                       data-original-title="ثبت تراکنش">
                                </button></div>';
                    }
                }
                if ( $bus['Status'] == 'book'  && CLIENT_ID == 271) {

                    $DataAction .= '<div class="pull-left margin-10">
                                       <a onclick="ModalUploadProof(' . "'" . $bus['OrderCode'] . "'" .  ",'" ."Bus'"  . ');return false" data-toggle="modal" data-target="#ModalPublic">
                                            <i style="margin: 5px auto;"  class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-upload"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="آپلود فاکتور"></i>
                                        </a>
                                    </div>';
                }
                if ( TYPE_ADMIN == '1' && ( $bus['Status'] == 'temporaryReservation' || $bus['Status'] == 'prereserve' || $bus['Status'] == 'book' ) ) {
                    /*$DataAction.='<div class="pull-left margin-10">
                                                            <a onclick="checkInquireBusTicket('."'".$bus['FactorNumber']."'".');return false"
                                                               data-toggle="modal" data-target="#ModalPublic">
                                                                <i class="fcbtn btn btn-warning btn-outline btn-1c tooltip-warning fa fa-check"
                                                                   data-toggle="tooltip" data-placement="top" title=""
                                                                   data-original-title="پیگیری رزرو از وب سرویس"></i>
                                                            </a>
                                                        </div>';*/
                }
                $DataAction .= "</li>
                                </ul>
                                <hr style='margin:3px'>";
                if ( $bus['payment_type'] == 'cash' ) {
                    $DataAction .= "نقدی";
                } elseif ( $bus['payment_type'] == 'credit' || $bus['payment_type'] == 'member_credit' ) {
                    $DataAction .= "اعتباری";
                }
                if ( TYPE_ADMIN == '1' && $bus['payment_type'] == 'cash' ) {
                    $DataAction .= "<hr style='margin:3px'>
                                                                " . $bus['numberPortBank'];
                }
                $DataAction .="<hr style='margin:3px'>".$bus['service_type'];
                if ( TYPE_ADMIN == '1' ) {
                    $DataAction .= "<hr style='margin:3px'>
                                                " . $bus['SourceName'];
                    $DataAction .= '<hr style="margin:3px">
                                   <a href="' . $transactionLink . '" data-toggle="tooltip" data-placement="top" data-original-title="مشاهده تراکنش ها" target="_blank">' . $bus['AgencyName'] . '</a>';
                }
                $DataAction .= "</div>";
            }

            if ( $bus['Status'] == 'book' ) {
                $DataStatus = '<a class="btn btn-success cursor-default" onclick="return false;"> ' . $bus['StatusFa'] . '</a>';
            } elseif ( $bus['Status'] == 'temporaryReservation' ) {
                $DataStatus = '<a class="btn btn-warning cursor-default" onclick="return false;">' . $bus['StatusFa'] . '</a>';
            } elseif ( $bus['Status'] == 'prereserve' ) {
                $DataStatus = '<a class="btn btn-warning cursor-default" onclick="return false;">' . $bus['StatusFa'] . '</a>';

            } elseif ( $bus['Status'] == 'bank' && $bus['tracking_code_bank'] == '' ) {
                $DataStatus = '<a class="btn btn-primary cursor-default popoverBox  popover-primary" onclick="return false;">' . $bus['StatusFa'] . '</a>';

            } elseif ( $bus['Status'] == 'cancel' ) {
                $DataStatus = '<a class="btn btn-danger cursor-default" onclick="return false;">' . $bus['StatusFa'] . '</a>';

            } else {
                $DataStatus = '<a class="btn btn-danger cursor-default" onclick="return false;">' . $bus['StatusFa'] . '</a>';

            }
            if ( TYPE_ADMIN == '1' && $bus['Status'] == 'temporaryReservation' && $bus['SourceCode'] === '9' ) {
                $DataStatus .= '<br/>
                                        <br/>
                                        <a href="https://api.payaneha.com/payment.ashx?PayanehaOrderCode=' . $bus['OrderCode'] . '"
                                                class="btn btn-success cursor-default" target="_blank">پرداخت از طریق درگاه پایانه ها</a>';
            }

            if (TYPE_ADMIN == 1) {
                $TitleAgencyShare='سود آژانس';
                $TitleBuyFromIt='خرید از ما';
                $TitlePayment='فروش آژانس <br> به مسافر';
                $TitleNameAgency='نام آژانس';
            }
            else {
                $TitleAgencyShare='سود شما';
                $TitleBuyFromIt='<span> خرید از <br>  سفر360 </span>';
                $TitlePayment=' فروش به مسافر';
                $TitleNameAgency='عملیات';
            }

            $ColorTr='';
            if($bus['Status'] == 'book' && $bus['service_type']=='اشتراکی'){//رزرو قطعی از مدل اشتراکی باشد
                if($this->colorTrByStatusCreditBlak=='Yes'){//اعتبار مشتری منفی هست
                    $ColorTr='#444343';//مشکی
                }
                else if($this->colorTrByStatusCreditPurple=='Yes'){//یعنی اعبار بعد خرید کم نشده
                    $ColorTr='#b0a7dd';//بنفش
                }
                else if($BuyFromIt==0){//رکورد تراکنش مالی ندارد
                    $ColorTr='#f7c2c2';//قرمز
                }
            }


            $DataTable['data'][ $key ]["رنگ"]                                             = $ColorTr;
            $DataTable['data'][ $key ]["ردیف"]                                            = $bus['NumberColumn'];
            $DataTable['data'][ $key ][" تاریخ و ساعت خرید<br/>نام خریدار<br/>نوع کانتر"] = $DataCounter;
            $DataTable['data'][ $key ]["مبدا<br>مقصد <br> نام مسافر<br/>شماره موبایل"]    = $DataDestination;
            $DataTable['data'][ $key ]["تاریخ حرکت<br/>ساعت حرکت"]                        = $DataMoveOnTime;
            $DataTable['data'][ $key ]["شرکت مسافربری<br/>اتوبوس"]                        = $DataBus;
            $DataTable['data'][ $key ]["شماره فاکتور<br>شماره بلیط<br/>شماره صندلی</br>تعداد صندلی"]      = $DataSeat;
            $DataTable['data'][ $key ][$TitleBuyFromIt]                                   = $DataBuyFromIt;
            ( TYPE_ADMIN == '1' ? $DataTable['data'][ $key ]["سهم ما"] = $DataIrantechCommission : "" );
            $DataTable['data'][ $key ][$TitlePayment]                                     = $DataTotalPrice;
            $DataTable['data'][ $key ][$TitleAgencyShare]                                 = $DataAgencyCommission;
            $DataTable['data'][ $key ][$TitleNameAgency]                                  = $DataAction;
            $DataTable['data'][ $key ]["وضعیت"]                                           = $DataStatus;
        }

        $FooterData0 = '<th colspan="6"></th>';
        $FooterData0 .= '<th>' . number_format($TotalBuyFromIt) . '</th>';
        if ( TYPE_ADMIN == '1' ) {
            $FooterData0 .= '<th>' . number_format($BookBusController->irantechCommission) . '</th>';
        }
        $FooterData0 .= '<th>' . number_format($BookBusController->totalPrice) . '</th>';
        $FooterData0 .= '<th>' . number_format($TotalAgencyShare) . '</th>';
        $FooterData0 .= '<th colspan="2"></th>';
        $DataTable['footer'][0] = $FooterData0;

        $FooterData1 = '<th colspan="6"></th>';
        $FooterData1 .='<th>' . $TitleBuyFromIt . '</th>';
        if ( TYPE_ADMIN == '1' ) {
            $FooterData1 .= '<th>سهم ما</th>';
        }
        $FooterData1 .= '<th>' . $TitlePayment . '</th>';
        $FooterData1 .= '<th>' . $TitleAgencyShare . '</th>';
        $FooterData1 .= '<th colspan="2"></th>';
        $DataTable['footer'][1] = $FooterData1;

        return $DataTable;
    }
    public function MainBusHistoryWebService( $param ) {


        $BookBusController = Load::controller( 'bookingBusShow' );
        if ( ! empty( $param['member_id'] ) ) {
            $intendedUser = [
                "member_id" => $param['member_id'],
                "agency_id" => @$param['agency_id']
            ];
            $ListBookBus  = $BookBusController->listBookBusTicketWebService( null, $intendedUser );
        } else {
            $ListBookBus = $BookBusController->listBookBusTicketWebService();
        }

        foreach ( $ListBookBus as $key => $bus ) {

            if ( $bus['Status'] == 'book' && $bus['seen_at'] == null ) {


                $Condition_bus_tb = " id='{$bus['Id']}'";

                if ( TYPE_ADMIN == '1' ) {

                    $ModelBase = Load::library( 'ModelBase' );
                    $ModelBase->setTable( 'report_bus_tb' );
                    $updateSeenAt['seen_at'] = date( 'Y-m-d H:i:s' );
                    $res                     = $ModelBase->update( $updateSeenAt, $Condition_bus_tb );
                } else {
                    $Model = Load::library( 'Model' );
                    $Model->setTable( 'book_bus_tb' );
                    $updateSeenAt['seen_at'] = date( 'Y-m-d H:i:s' );
                    $res                     = $Model->update( $updateSeenAt, $Condition_bus_tb );
                }
            }


            $infoClient = functions::infoClient( $bus['client_id'] );
            $infoMember = functions::infoMember( $bus['MemberId'], $bus['ClientId'] );
            if ( $bus['PaymentDate'] != '' ) {
                $DataCounter = $bus['PaymentDate'] . ' ' . $bus['PaymentTime'] . '<hr style="margin:3px">';
            }
            $DataCounter .= $bus['MemberName'] . "<hr style='margin:3px'>";
            if ( $infoMember['fk_counter_type_id'] == '5' ) {
                $DataCounter .= "مسافر";
            } else {
                $DataCounter .= "کانتر";
            }
            if ( $bus['ServicesDiscount'] != '' && $infoMember['is_member'] == '1' ) {
                $DataCounter .= $bus['ServicesDiscount'] . " %ای";
            }
            $DataDestination        = $bus['OriginName'] . '<hr style="margin:3px">' . $bus['DestinationCity'];
            $DataMoveOnTime         = $bus['DateMove'] . '<hr style="margin:3px">' . $bus['TimeMove'];
            $DataBus                = $bus['BaseCompany'] . '<hr style="margin:3px">' . $bus['CarType'];
            $DataSeat               = $bus['FactorNumber'] . '<hr style="margin:3px">' . $bus['pnr'] . '<hr style="margin:3px">' . $bus['PassengerChairs'];
            $DataNumberInfo         = $bus['PassengerName'] . '<hr style="margin:3px">' . $bus['PassengerMobile'];
//			$DataAgencyCommission   = $bus['AgencyCommission'];
            $DataAgencyCommission   = number_format($bus['total_price']-$bus['price_api']);
            $DataIrantechCommission = number_format( $bus['IrantechCommission'], '0', '.', ',' ) . '<hr style="margin:3px">' . number_format( $bus['priceForMa'], '0', '.', ',' );
            $DataTotalPrice         = number_format( $bus['totalPrice'], '0', '.', ',' );

            if ( TYPE_ADMIN == '1' ) {
                $addressClient = $BookBusController->ShowAddressClient( $bus['ClientId'] );
            } else {
                $addressClient = $BookBusController->ShowAddressClient( CLIENT_ID );
            }
            if ( $bus['Status'] != 'nothing' ) {
                $DataAction = '<div class="btn-group m-r-10">
                                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button">  عملیات <span class="caret"></span></button>

                                            <ul role="menu" class="dropdown-menu animated flipInY mainTicketHistory-operation-bus">
                                                <li>
                                                    <div class="pull-left margin-10">
                                                        <a onclick="ModalShowBookForBus(' . "'" . $bus['FactorNumber'] . "'" . ');return false"
                                                           data-toggle="modal" data-target="#ModalPublic">
                                                            <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                               data-toggle="tooltip" data-placement="top" title=""
                                                               data-original-title="مشاهده خرید"></i>
                                                        </a>
                                                    </div>';
                if ( $bus['Status'] == 'book' ) {
                    $DataAction .= '<div class="pull-left margin-10">
                                        <a href="' . ROOT_ADDRESS_WITHOUT_LANG . '/eBusTicket&num=' . $bus['FactorNumber'] . '"
                                           target="_blank"
                                           title="مشاهده اطلاعات خرید" >
                                            <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-danger btn-1c tooltip-danger fa fa-print"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="مشاهده اطلاعات خرید"></i>
                                        </a>
                                    </div>
                                    <div class="pull-left margin-10">
                                     <a href="' . ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=busBoxCheck&id=' . $bus['FactorNumber'] . '"
                                           target="_blank"
                                           title="قبض صندوق" >
                                            <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-warning btn-1c  tooltip-warning fa fa-money"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="قبض صندوق"></i>
                                        </a>
                                    </div>
                                     <div class="pull-left margin-10">
                                        <a href="' . ROOT_ADDRESS_WITHOUT_LANG. '/pdf&target=bookingBusShow&id=' . $bus['FactorNumber'] . '"
                                           target="_blank"
                                           title="مشاهده اطلاعات خرید" >
                                            <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="مشاهده اطلاعات خرید"></i>
                                        </a>
                                    </div>
                                    <div class="pull-left margin-10">
                                        <a href="' . ROOT_ADDRESS_WITHOUT_LANG. '/pdf&target=bookingBusShow&id=' . $bus['FactorNumber'] . '&cash=no"
                                           target="_blank"
                                           title="بلیط بدون قیمت" >
                                            <i class="fcbtn btn btn-outline btn-default btn-1c tooltip-default fa fa-ticket"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="بلیط بدون قیمت"></i>
                                        </a>
                                    </div>
                                    <div class="pull-left margin-10">
                                        <a href="' . ROOT_ADDRESS_WITHOUT_LANG. '/pdf&target=bookingBusForeign&id=' . $bus['FactorNumber'] . '"
                                           target="_blank"
                                           title="بلیط خارجی" >
                                            <i class="fcbtn btn btn-outline btn-success btn-1c tooltip-default fa fa-file-pdf-o"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="بلیط خارجی"></i>
                                        </a>
                                    </div>
                                    <div class="pull-left margin-10">
                                        <a 
                                           title="استرداد" 
                                           onclick="ModalCancelFlightAdmin(' . "'" . $bus['OrderCode'] . "'" .  ",'" ."bus'"  . '); return false ;"
                                           target="_blank"
                                           data-toggle="modal"
                                           data-target="#ModalPublic"
                                           >
                                            <i class="fcbtn btn btn-outline btn-danger btn-1c tooltip-danger mdi mdi-close"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="استرداد"></i>
                                        </a>
                                    </div>                                    
                                    ';
                }
                if ( $bus['Status'] == 'book'  && CLIENT_ID == 271) {

                    $DataAction .= '<div class="pull-left margin-10">
                                       <a onclick="ModalUploadProof(' . "'" . $bus['OrderCode'] . "'" .  ",'" ."Bus'"  . ');return false" data-toggle="modal" data-target="#ModalPublic">
                                            <i style="margin: 5px auto;"  class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-upload"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="آپلود فاکتور"></i>
                                        </a>
                                    </div>';
                }
                if ( TYPE_ADMIN == '1' && ( $bus['Status'] == 'temporaryReservation' || $bus['Status'] == 'prereserve' || $bus['Status'] == 'book' ) ) {
                    /*$DataAction.='<div class="pull-left margin-10">
                                                            <a onclick="checkInquireBusTicket('."'".$bus['FactorNumber']."'".');return false"
                                                               data-toggle="modal" data-target="#ModalPublic">
                                                                <i class="fcbtn btn btn-warning btn-outline btn-1c tooltip-warning fa fa-check"
                                                                   data-toggle="tooltip" data-placement="top" title=""
                                                                   data-original-title="پیگیری رزرو از وب سرویس"></i>
                                                            </a>
                                                        </div>';*/
                }
                $DataAction .= "</li>
                                            </ul>

                                            <hr style='margin:3px'>";

                if ( $bus['payment_type'] == 'cash' ) {
                    $DataAction .= "نقدی";
                } elseif ( $bus['payment_type'] == 'credit' || $bus['payment_type'] == 'member_credit' ) {
                    $DataAction .= "اعتباری";
                }
                if ( TYPE_ADMIN == '1' && $bus['payment_type'] == 'cash' ) {
                    $DataAction .= "<hr style='margin:3px'>
                                                " . $bus['numberPortBank'];
                }
                if ( TYPE_ADMIN == '1' ) {
                    $DataAction .= "<hr style='margin:3px'>
                                                " . $bus['SourceName'];
                    $DataAction .= "<hr style='margin:3px'>
                                                " . $bus['AgencyName'];
                }
                $DataAction .= "</div>";
            }

            if ( $bus['Status'] == 'book' ) {
                $DataStatus = '<a class="btn btn-success cursor-default" onclick="return false;"> ' . $bus['StatusFa'] . '</a>';
            } elseif ( $bus['Status'] == 'temporaryReservation' ) {
                $DataStatus = '<a class="btn btn-warning cursor-default" onclick="return false;">' . $bus['StatusFa'] . '</a>';
            } elseif ( $bus['Status'] == 'prereserve' ) {
                $DataStatus = '<a class="btn btn-warning cursor-default" onclick="return false;">' . $bus['StatusFa'] . '</a>';

            } elseif ( $bus['Status'] == 'bank' && $bus['tracking_code_bank'] == '' ) {
                $DataStatus = '<a class="btn btn-primary cursor-default popoverBox  popover-primary" onclick="return false;">' . $bus['StatusFa'] . '</a>';

            } elseif ( $bus['Status'] == 'cancel' ) {
                $DataStatus = '<a class="btn btn-danger cursor-default" onclick="return false;">' . $bus['StatusFa'] . '</a>';

            } else {
                $DataStatus = '<a class="btn btn-danger cursor-default" onclick="return false;">' . $bus['StatusFa'] . '</a>';

            }
            if ( TYPE_ADMIN == '1' && $bus['Status'] == 'temporaryReservation' && $bus['SourceCode'] === '9' ) {
                $DataStatus .= '<br/>
                                        <br/>
                                        <a href="https://api.payaneha.com/payment.ashx?PayanehaOrderCode=' . $bus['OrderCode'] . '"
                                                class="btn btn-success cursor-default" target="_blank">پرداخت از طریق درگاه پایانه ها</a>';
            }
            $DataTable['data'][ $key ]["ردیف"]                                            = $bus['NumberColumn'];
            $DataTable['data'][ $key ][" تاریخ و ساعت خرید<br/>نام خریدار<br/>نوع کانتر"] = $DataCounter;
            $DataTable['data'][ $key ]["مبدا<br>مقصد"]                                    = $DataDestination;
            $DataTable['data'][ $key ]["تاریخ حرکت<br/>ساعت حرکت"]                        = $DataMoveOnTime;
            $DataTable['data'][ $key ]["شرکت مسافربری<br/>اتوبوس"]                        = $DataBus;
            $DataTable['data'][ $key ]["شماره فاکتور<br>شماره بلیط<br/>شماره صندلی"]      = $DataSeat;
            $DataTable['data'][ $key ]["نام مسافر<br/>شماره موبایل"]                      = $DataNumberInfo;
            $DataTable['data'][ $key ]["سهم آژانس"]                                       = $DataAgencyCommission;
            ( TYPE_ADMIN == '1' ? $DataTable['data'][ $key ]["+ apiسود<br/> سهم ما"] = $DataIrantechCommission : "" );
            $DataTable['data'][ $key ]["مبلغ"]   = $DataTotalPrice;
            $DataTable['data'][ $key ]["عملیات"] = $DataAction;
            $DataTable['data'][ $key ]["وضعیت"]  = $DataStatus;
        }

        $FooterData0 = '<th colspan="7"></th>
                                <th>';
        if ( $BookBusController->agencyCommissionCost != '' ) {
            $FooterData0 .= $BookBusController->agencyCommissionCost . ' ريال
                                        <br>';
        }
        if ( $BookBusController->agencyCommissionPercent != '' ) {
            $FooterData0 .= $BookBusController->agencyCommissionPercent . ' %';

        }


        $FooterData0 .= '</th>';
        if ( TYPE_ADMIN == '1' ) {

            $FooterData0 .= '<th>
                                        (' . $BookBusController->irantechCommission . ')ريال
                                        <hr>(' . $BookBusController->priceForMa . ')ريال
                                    </th>';

        }
        $FooterData0            .= '<th>(' . $BookBusController->totalPrice . ')ريال</th>
                                <th></th>
                                <th></th>';
        $DataTable['footer'][0] = $FooterData0;


        return $DataTable;
    }
    public function MainTrainHistory( $param ) {
        /** @var trainBooking $BookTrainController */
        $BookTrainController = Load::controller( 'trainBooking' );
        if ( ! empty( $param['member_id'] ) ) {
            $intendedUser  = [
                "member_id" => $param['member_id'],
                "agency_id" => @$param['agency_id']
            ];
            $ListBookTrain = $BookTrainController->bookList( null, $intendedUser );
        } else {
            $ListBookTrain = $BookTrainController->bookList();
        }


        $DataSuccessPrice = 0;
        $count_passenger = 0 ;
        //        echo print_r($ListBookTrain);
        foreach ( $ListBookTrain as $key => $train ) {
            if ( $train['successfull'] == 'book' ){
                $count_passenger += ($train['AdultCount'] +$train['ChildCount']+$train['InfantCount']);
            }


            $DataDestination = $train['Departure_City'] . '<hr style="margin:3px"/>' . $train['Arrival_City'];
            $DataArrival     = $train['Arrival_City'];
            $DataRouteType   = ( $train['Route_Type'] == '1' ? "رفت" : "برگشت" );
            $DataExitTime    = $train['MoveDate'] . '<hr style="margin:3px"/>' . $train['ExitTime'] . '<hr style="margin:3px"/>' . $train['TimeOfArrival'];
            $DataTrainNumber = $train['TrainNumber'] . '<hr style="margin:3px"/>' . $train['WagonName'] . '<hr style="margin:3px"/>' . ( $train['is_specific'] == 'yes' ? "سهمیه ای" : "عادی" );
            $DataFactor      = $train['creation_date_int'] . '<hr style="margin:3px">
                                        ' . $train['factor_number'] . '<hr style="margin:3px"/>' . $train['requestNumber'];

//            if ( $train['successfull'] == 'book' && $train['TicketNumber'] > 0 ) {
//
//
//                $DataPrice = functions::numberformat( $BookTrainController->TotalPriceByTicketNumberAdmin( $train['requestNumber'], $train['successfull'] ) ) . ' ریال';
//
//
//            } else {
//                $DataPrice = functions::numberformat( $BookTrainController->TotalPriceByTicketNumberAdmin( $train['requestNumber'], 'no' ) );
//            }

            $DataPrice = $train['dataTotalPrice'] . ' ریال';

            $DataAgency = $clientName = '';
            if ( TYPE_ADMIN == '1' ) {
                $clientName = $train['NameAgency'];
            }
            $DataAgency .= ( $clientName != '' ? $clientName . "<hr style='margin:3px'>" : '' ) . ( $train['member_name'] != ' ' ? $train['member_name'] : "کاربر مهمان" );


            $DataAgency .= '<hr style="margin:3px">
                                <span class=" fa fa-user" style="margin-left: 5px;">' . $train['AdultCount'] . '</span>
                                <span class=" fa fa-child" style="margin-left: 5px;">' . $train['ChildCount'] . '</span>
                                <span class=" fa fa-child" style="margin-left: 5px;">' . $train['InfantCount'] . '</span>';
            $DataAgency .= "<hr style='margin:3px'>" . $DataPrice;


            $DataAction = '<div class="btn-group m-r-10">
                                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button">  عملیات <span class="caret"></span></button>
                                            <ul role="menu" class="dropdown-menu animated flipInY mainTicketHistory-operation">
                                                <li>
                                                    <div class="pull-left">

                                                        <div class="pull-left margin-10">
                                                            <a onclick="ModalShowBookForTrain(' . "'" . $train['requestNumber'] . "'" . ');return false" data-toggle="modal" data-target="#ModalPublic">
                                                                <i style="margin: 5px auto;"  class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                                   data-toggle="tooltip" data-placement="top" title=""
                                                                   data-original-title="مشاهده خرید"></i>
                                                            </a>
                                                        </div>

                                                        <div class="pull-left margin-10">';
            //            if(TYPE_ADMIN == '1'){
            //                $url= $train['DomainAgency'];
            //            }else{
            //                $url= CLIENT_DOMAIN;
            //            }
            $url = CLIENT_DOMAIN;
            if ( ( $train['successfull'] == 'bank' || $train['successfull'] == 'nothing' ) && TYPE_ADMIN == '1' ) {
                $DataAction .= '<a href="#" onclick="getInfoTicketTrain(' . "'" . $train['requestNumber'] . "'" . ');return false" >
                   <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-check "
                                                                   data-toggle="tooltip"
                                                                   data-placement="top" title=""
                                                                   data-original-title="تیکت کردن"></i>
                                                            </a>';
            }

            if ( $train['successfull'] == 'book' ) {
                $DataAction .= '<a href="' . ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=trainBooking&id=' . $train['requestNumber'] . '"
                                                                               target="_blank">
                                                                <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                                   data-toggle="tooltip"
                                                                   data-placement="top" title=""
                                                                   data-original-title="بلیط پارسی"></i>
                                                            </a>';
            }
            $DataAction .= '</div>
</div>
</li>
</ul>
</div>';

            $DataAction .= "<hr style='margin:3px'>" . $DataRouteType;

            $DataAction .= '<hr style="margin:3px">' . $train['passenger_name'] . ' ' . $train['passenger_family'];


            if ( $train['successfull'] == 'book' ) {
                if ( $train['payment_type'] == 'cash' ) {
                    $DataPayType = "نقدی";
                } elseif ( $train['payment_type'] == 'credit' ) {
                    $DataPayType = "اعتباری";
                }
                $DataPayType .= "<hr style='margin:3px'>";
                if ( $train['payment_type'] != 'credit' ) {

                    if ( in_array( $train['number_bank_port'], functions::allDataKeyIranTechGetWay() ) ) {
                        $DataPayType .= "درگاه سفر360";
                    } else {
                        $DataPayType .= "درگاه خودش";
                    }
                }
            } else {
                $DataPayType = '-';
            }

            if ( $train['successfull'] == 'book' ) {
                $DataSuccessPrice = $DataSuccessPrice + $BookTrainController->TotalPriceByTicketNumberAdmin( $train['TicketNumber'], $train['successfull'] );
//                $DataSuccessPrice = $DataSuccessPrice + $train['dataTotalPrice'];
                $DataStatus       = '<a class="btn btn-success cursor-default" onclick="return false;"> رزرو قطعی</a>';

            } elseif ( $train['successfull'] == 'prereserve' ) {
                $DataStatus = '<a class="btn btn-primary cursor-default" onclick="return false;">پیش رزرو</a>';
            } elseif ( $train['successfull'] == 'bank' ) {
                $DataStatus = '<a class="btn btn-warning cursor-default" onclick="return false;">هدایت به درگاه</a>';
            } elseif ( $train['successfull'] == 'nothing' || $train['successfull'] == '' ) {
                $DataStatus = '<a class="btn btn-info cursor-default" onclick="return false;">انصراف از خرید</a>';
            } elseif ( $train['successfull'] == 'credit' ) {
                $DataStatus = '<a class="btn btn-default cursor-default" onclick="return false;">انتخاب گزینه اعتباری</a>';
            } elseif ( $train['successfull'] == 'error' ) {
                $DataStatus = '<a class="btn btn-danger cursor-default" onclick="return false;">خطای وب سرویس</a>';
            }

            $DataTable['data'][ $key ]["ردیف"]            = $key + 1;
            $DataTable['data'][ $key ]["مبدا </br> مقصد"] = $DataDestination;
            //                $DataTable['data'][$key]["مقصد"]=$DataArrival;
            //                $DataTable['data'][$key]["نوع مسیر"]=$DataRouteType;
            //                $DataTable['data'][$key]["تاریخ حرکت "]=$DataMoveDate;
            $DataTable['data'][ $key ]["تاریخ حرکت <br/> ساعت رسیدن <br/>ساعت حرکت"]    = $DataExitTime;
            $DataTable['data'][ $key ]["شماره قطار <br/>نام قطار<br/>نوع قطار"]         = $DataTrainNumber;
            $DataTable['data'][ $key ][" تاریخ خرید <br/>شماره واچر<br/>شماره فاکتور"]  = $DataFactor;
            $DataTable['data'][ $key ]["نام آژانس <br/> خریدار <br/> تعداد <br/> مبلغ"] = $DataAgency;
            //                $DataTable['data'][$key][" مبلغ "]=$DataPrice;
            $DataTable['data'][ $key ]["نوع پرداخت"]                               = $DataPayType;
            $DataTable['data'][ $key ]["عملیات <br/> نوع مسیر <br/> اولین مسافر "] = $DataAction;
            $DataTable['data'][ $key ]["وضعیت"]                                    = $DataStatus;


        }


        $FooterData0 = '<th colspan="4"></th>
                            <th colspan="4">(' . number_format( $DataSuccessPrice ) . ')ريال</th>';
        $FooterData0 .='<th>'. $count_passenger .' نفر'.'</th>';

        $DataTable['footer'][0] = $FooterData0;

        return $DataTable;
    }

    public function MainEntertainmentHistory( $param ) {

        $BookEntertainmentController = Load::controller( 'entertainment' );
        $ListBookEntertainment       = $BookEntertainmentController->bookList();
        if ( ! empty( $param['member_id'] ) ) {
            $intendedUser          = [
                "member_id" => $param['member_id'],
                "agency_id" => @$param['agency_id']
            ];
            $ListBookEntertainment = $BookEntertainmentController->bookList( null, $intendedUser );
        } else {
            $ListBookEntertainment = $BookEntertainmentController->bookList();
        }

        $DataSuccessPrice = 0;
        foreach ( $ListBookEntertainment as $key => $Entertainment ) {


            $EntertainmentName = $Entertainment['EntertainmentTitle'].'<br/>'.$Entertainment['EntertainmentCountry'].'/'.$Entertainment['EntertainmentCity'];
            $DataAgencyName    = '';
            if ( TYPE_ADMIN == '1' ) {
                if ( $Entertainment['agency_name'] != '' ) {
                    $DataAgencyName = $Entertainment['agency_name'];
                } else {
                    $DataAgencyName = functions::ClientName( $Entertainment['client_id'] );


                }
                if ( empty( $DataAgencyName ) ) {
                    $DataAgencyName = 'کاربر مهمان';
                }
            }
            $DataBuyer      = ( $Entertainment['member_name'] != ' ' ? $Entertainment['member_name'] : "کاربر مهمان" );
            $DataBuyer      .= '<hr style="margin:3px"/>' . $Entertainment['passenger_national_code'];
            $DataBuyer      .= '<hr style="margin:3px"/>' . functions::Xmlinformation( $Entertainment['passenger_gender'] );
            $DataBuyer      .= '<hr style="margin:3px"/>' . $Entertainment['email_buyer'];
            $DataCounter    = '<span class=" fa fa-user" style="margin-left: 5px;">' . $Entertainment['CountPeople'] . '</span>';
            $DataCounter    .= '<hr style="margin:3px"/>' . $Entertainment['passenger_reserve_date'];
            $DataTotalPrice = number_format( $Entertainment['DiscountPrice'] );


            $DataFactor = $Entertainment['creation_date_int'] . '<hr style="margin:3px">' . ( TYPE_ADMIN == '1' ? '<a href="' . ROOT_ADDRESS_WITHOUT_LANG . '/itadmin/transactionUser" target="_blank" >' . $Entertainment['factor_number'] . '</a>' : $Entertainment['factor_number'] ) . '<hr style="margin:3px"/>' . $Entertainment['requestNumber'];


            if ( $Entertainment['successfull'] == 'book' ) {
                if ( $Entertainment['payment_type'] == 'cash' ) {
                    $DataPayType = "نقدی";
                } elseif ( $Entertainment['payment_type'] == 'credit' ) {
                    $DataPayType = "اعتباری";
                }
                $DataPayType .= "<hr style='margin:3px'>";
                if ( in_array( $Entertainment['number_bank_port'], functions::allDataKeyIranTechGetWay() ) ) {
                    $DataPayType .= "درگاه سفر360";
                } else {
                    $DataPayType .= "درگاه خودش";
                }
            } else {
                $DataPayType = '-';
            }
            $DataIranPart = number_format( $Entertainment['irantech_commission'] );

            if ( $Entertainment['successfull'] == 'book' ) {
                $DataSuccessPrice = $DataSuccessPrice + $Entertainment['DiscountPrice'];
                $DataStatus       = '<a class="btn btn-success cursor-default" onclick="return false;"> رزرو قطعی</a>';

            } elseif ( $Entertainment['successfull'] == 'prereserve' || $Entertainment['successfull'] == 'TemporaryPreReserve' ) {
                $DataStatus = '<a class="btn btn-warning cursor-default" onclick="return false;">پیش رزرو</a>';
            } elseif ( $Entertainment['successfull'] == 'bank' ) {
                $DataStatus = '<a class="btn btn-warning cursor-default" onclick="return false;">هدایت به درگاه</a>';
            } elseif ( $Entertainment['successfull'] == 'Requested' ) {
                $DataStatus = '<a class="btn btn-warning cursor-default" onclick="return false;">درخواست شده(در حال بررسی)</a>';
            }elseif ( $Entertainment['successfull'] == 'RequestRejected' ) {
                $DataStatus = '<a class="btn btn-danger cursor-default" onclick="return false;">درخواست رد شده</a>';
            }elseif ( $Entertainment['successfull'] == 'RequestAccepted' ) {
                $DataStatus = '<a class="btn btn-success cursor-default" onclick="return false;">درخواست پذیرفته شده</a>';
            } elseif ( $Entertainment['successfull'] == 'nothing' || $Entertainment['successfull'] == '' ) {
                $DataStatus = '<a class="btn btn-danger cursor-default" onclick="return false;">نامشخص</a>';
            }

            $DataShowModal = '<a class="btn btn-primary" target="_blank" href="' . ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=entertainment&id=' . $Entertainment['factor_number'] . '">مشاهده <span class="fa fa-eye"></span></a>';


            $DataAction = '<div class="btn-group m-r-10">
                                    <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button">  عملیات <span class="caret"></span></button>
                                    <ul role="menu" class="dropdown-menu animated flipInY mainTicketHistory-operation">
                                        <li>
                                            <div class="pull-left">

                                                <div class="pull-left margin-10">
                                                    <a onclick="ModalShowBookForEntertainment(' . "'" . $Entertainment['factor_number'] . "'" . ');return false" data-toggle="modal" data-target="#ModalPublic">
                                                        <i style="margin: 5px auto;"  class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="مشاهده خرید"></i>
                                                    </a>
                                                </div>';

            $DataAction .= '</div></li></ul></div>';

            if ( TYPE_ADMIN == '1' ) {
                $DataAction .= "<hr style='margin:3px'>";
                if ( $Entertainment['agency_name'] != '' ) {
                    $DataAction .= $Entertainment['agency_name'];
                } else {

                    $DataAction .= functions::ClientName( $Entertainment['client_id'] );
                }
            }
            $DataAction .= "<hr style='margin:3px'>
                                " . $Entertainment['member_name'];


            $DataTable['data'][ $key ]["ردیف"]                                          = $key + 1;
            $DataTable['data'][ $key ]["نام تفریح <br/>  مقصد"]                                     = $EntertainmentName;
            $DataTable['data'][ $key ]["خریدار </br> کد ملی   </br> جنسیت <br/> ایمیل"] = $DataBuyer;
            $DataTable['data'][ $key ]["تعداد نفرات  <br/> تاریخ درخواستی"]             = $DataCounter;
            $DataTable['data'][ $key ]["مبلغ"]                                          = $DataTotalPrice;
            ( TYPE_ADMIN == '1' ? $DataTable['data'][ $key ][" سهم ما"] = $DataIranPart : "" );
            ( TYPE_ADMIN == '1' ? $DataTable['data'][ $key ]["نام آژانس"] = $DataAgencyName : "" );
            $DataTable['data'][ $key ][" تاریخ خرید <br/>شماره واچر<br/>شماره فاکتور"] = $DataFactor;
            $DataTable['data'][ $key ]["نوع پرداخت"]                                   = $DataPayType;
            $DataTable['data'][ $key ]["عملیات"]                                   = $DataAction;
            $DataTable['data'][ $key ]["مشاهده"]                                       = $DataShowModal;
            $DataTable['data'][ $key ]["وضعیت"]                                        = $DataStatus;


        }


        $FooterData0 = '<th colspan="5"></th>
                            <th colspan="4">(' . number_format( $DataSuccessPrice ) . ')ريال</th>';

        $DataTable['footer'][0] = $FooterData0;

        return $DataTable;
    }

    public function MainTicketHistory( $param ) {

        if ( $param['target'] == 'flight' ) {
            parse_str( $param['filter'], $param );
            $_POST     = $param;
            $DataTable = $this->MainFlightTicketHistory( $param );
        } elseif ( $param['target'] == 'hotel' ) {
            parse_str( $param['filter'], $param );
            $_POST     = $param;

            $DataTable = $this->MainHotelHistory( $param );
        } elseif ( $param['target'] == 'insurance' ) {
            parse_str( $param['filter'], $param );
            $_POST     = $param;
            $DataTable = $this->MainInsuranceHistory( $param );
        } elseif ( $param['target'] == 'visa' ) {
            parse_str( $param['filter'], $param );
            $_POST     = $param;
            $DataTable = $this->MainVisaHistory( $param );
        } elseif ( $param['target'] == 'gasht' ) {
            parse_str( $param['filter'], $param );
            $_POST     = $param;
            $DataTable = $this->MainGashtHistory( $param );
        } elseif ( $param['target'] == 'tour' ) {
            parse_str( $param['filter'], $param );
            $_POST     = $param;
            $DataTable = $this->MainTourHistory( $param );
        } elseif ( $param['target'] == 'bus' ) {
            parse_str( $param['filter'], $param );
            $_POST     = $param;
            $DataTable = $this->MainBusHistory( $param );
        } elseif ( $param['target'] == 'train' ) {
            parse_str( $param['filter'], $param );
            $_POST     = $param;
            $DataTable = $this->MainTrainHistory( $param );
        } elseif ( $param['target'] == 'entertainment' ) {
            parse_str( $param['filter'], $param );
            $_POST     = $param;
            $DataTable = $this->MainEntertainmentHistory( $param );
        } elseif( $param['target'] == 'exclusive_tour' ){
            parse_str( $param['filter'], $param );
            $_POST     = $param;
            $DataTable = $this->MainExclusiveTourHistory( $param );
        }

        return json_encode( $DataTable );
    }
    #endregion

    public function historyTestWebService( $param ) {
        if ( $param['target'] == 'flight' ) {
            parse_str( $param['filter'], $param );
            $_POST     = $param;
            $DataTable = $this->MainFlightTicketHistoryWebService( $param );
        } elseif ( $param['target'] == 'hotel' ) {
            parse_str( $param['filter'], $param );
            $_POST     = $param;

            $DataTable = $this->MainHotelHistoryWebService( $param );
        } elseif ( $param['target'] == 'bus' ) {
            parse_str( $param['filter'], $param );
            $_POST     = $param;
            $DataTable = $this->MainBusHistoryWebService( $param );
        }
        return json_encode( $DataTable );
    }
    public function subAgency () {
        /** @var partner $partner_controller */
        $partner_controller = Load::controller('partner');
        return $partner_controller->subClient(CLIENT_ID);
    }

    private function btnErrorFlight($data_flight){
        $status_admin = (TYPE_ADMIN=='1') ? true : false ;
        $client_id = ($status_admin) ? $data_flight['client_id'] : CLIENT_ID ;
        $data_error = $this->getController('logErrorFlights')->getErrorMessage($data_flight['request_number'],$client_id);


        $classes =  in_array($data_error['messageCode'],$this->getCodeSpecialError()) ? 'colorSpecialError' : '';
        $text_btn = $this->titleBtnError($data_error,$data_flight);


        if(($data_error['messageCode']=='-506' || $data_error['messageCode']=='Err0111006') && !$status_admin && $data_flight['pid_private'] =='0'){
            $content_btn = 'خطای پروایدر';
        }else{
            $content_btn = $data_error['text_message'];
        }


        return  '<a href="#" onclick="return false;" class="btn btn-danger '. $classes .' cursor-default popoverBox  popover-danger"
                                               data-toggle="popover" title="'.$text_btn.'" data-placement="right"
                                               data-content="'. $content_btn .'">'. $text_btn .'</a>';


    }

    private function titleBtnError($data_error, $data_flight){
        if(in_array($data_error['messageCode'],$this->getCodeSpecialError())){

            if(($data_error['messageCode']=='Err0111006' && $data_flight['pid_private'] =='1' && $data_flight['api_id'] == '14') || ($data_error['messageCode']=='-506' && $data_flight['pid_private'] =='1')){
                return  ' اعتبار کافی نیست';
            }elseif($data_error['messageCode']=='-411') {
                return ' خطای کد امنیتی';
            }elseif($data_error['messageCode']=='-404'){
                return  'خطای شماره همراه';
            }elseif($data_error['messageCode']=='-418'){
                return  'خطای کد ملی';
            }elseif($data_error['messageCode']=='ERROR113'){
                return  'خطای تکرار درخواست';
            }elseif($data_error['messageCode']=='Err0107038'){
                return  'خطای ملیت مسافر';
            }elseif(in_array($data_error['messageCode'],$this->errorCodePassport())){
                if($data_error['messageCode']=='Err0107011' || $data_error['messageCode']=='-420'){
                    return 'خطای انقضاء پاسپورت';
                }else{
                    return 'خطای پاسپورت';
                }
            }
            else{
                return ($data_flight=='charter') ? 'خطای چارتر کننده':'خطای ایرلاین';
            }
        }else{
            return ($data_flight=='charter') ? 'خطای چارتر کننده':'خطای ایرلاین';
        }
    }


    private function btnErrorHotel($data_hotel){

        $status_admin = (TYPE_ADMIN=='1') ? true : false ;
        $client_id = ($status_admin) ? $data_hotel['client_id'] : CLIENT_ID ;
        $data_error = $this->getController('logErrorsHotels')->getErrorMessage($data_hotel['request_number'] , $data_hotel['factor_number'],$client_id);

        if($data_error) {
            $classes =  in_array($data_error['messageCode'],$this->getHotelCodeSpecialError()) ? 'colorSpecialError' : '';
            $text_btn = $this->titleBtnHotelError($data_error,$data_hotel);
            if(!$status_admin && ($data_error['messageCode'] == 'BK-426' || $data_error['messageCode'] == 'Err0111006') ) {
                $content_btn = 'خطا';
            }else{
                $content_btn = $data_error['text_message'];
            }


            return  '<a href="#" onclick="return false;" class="btn btn-danger '. $classes .' cursor-default popoverBox  popover-danger"
                                               data-toggle="popover" title="'.$text_btn.'" data-placement="right"
                                               data-content="'. $content_btn .'">'. $text_btn .'</a>';
        }else {
            return '<a class="btn btn-danger cursor-default" onclick="return false;">خطا</a>';

        }



    }

    private function titleBtnHotelError($data_error, $data_flight){
        if(in_array($data_error['messageCode'],$this->getHotelCodeSpecialError())){

            if($data_error['messageCode']=='Err0111006' ||  $data_error['messageCode']=='BK-426' ){
                return  ' اعتبار کافی نیست';
            }elseif($data_error['messageCode']=='Bk-406' || $data_error['messageCode']=='HotelReserve-406' ) {
                return ' خطای درخواست تکراری';
            }elseif($data_error['messageCode']=='Bk-400' || $data_error['messageCode']=='HotelReserve-400'){
                return  'خطای درخواست اشتباه';
            }elseif($data_error['messageCode']=='ERROR113'){
                return  'خطای تکرار درخواست';
            }else{
                return 'خطای پروایدر';
            }
        }else{
            return 'خطای پروایدر';
        }
    }

    private function getHotelCodeSpecialError(){
        return array(
            'Bk-406'
        );
    }

    private function getCodeSpecialError(){
        return array(
            'Err0111006',
            'Err0107020',
            'Err0107010',
            'Err0107011',
            'Err0107012',
            'Err0107040',
            'Err0107045',
            'Err0107051',
            'Err0107065',
            '-506',
            '-411',
            '-420',
            '-418',
            '-404',
            'ERROR113',
            'Err0107038',
            '-414'
        );
    }


    private function errorCodePassport(){
        return array(
            'Err0107020',
            'Err0107009',
            'Err0107010',
            'Err0107011',
            'Err0107012',
            'Err0107040',
            'Err0107045',
            'Err0107051',
            'Err0107065',
            '-420',
        );

    }

    public function getAgencyClient() {
        return  $this->getController('agency')->getAgencies();
    }


    public function CalculateCurrentCredit($client_id,$FActorNumberFor,$BuyFromIt){
        $this->ArrChargeUserPrice[$client_id] =$this->transactionsClass->getLastTransactionBalanceStatus($client_id,$FActorNumberFor);
        $beforeCredit = $this->ArrChargeUserPrice[$client_id];  // اعتبار قبل از خرید
        $this->ArrChargeUserPrice[$client_id] = $beforeCredit-$BuyFromIt;  // اعتبار بعد از خرید

        $Data = '';

        $Data= '<div style="display: flex; flex-direction: column;">
                   <span class="bg-primary rounded py-2 px-3 text-white d-inline-block mb-2 text-center">
                       <div style="font-size: 12px;">اعتبار قبل خرید</div>
                       <div style="font-size: 16px; font-weight: bold; direction: ltr;">' . number_format($beforeCredit) . '</div>
                   </span>
                   <span class="bg-success rounded py-2 px-3 text-white d-inline-block text-center">
                       <div style="font-size: 12px;">اعتبار بعد خرید</div>
                       <div style="font-size: 16px; font-weight: bold; direction: ltr;">' . number_format($this->ArrChargeUserPrice[$client_id]) . '</div>
                   </span>
               </div>';
        if($beforeCredit<=0 || $this->ArrChargeUserPrice[$client_id]<0)
            $this->colorTrByStatusCreditBlak='Yes';
        if($beforeCredit==$this->ArrChargeUserPrice[$client_id] && $beforeCredit!=0 && $this->ArrChargeUserPrice[$client_id]!=0)
            $this->colorTrByStatusCreditPurple='Yes';

        return $Data;
    }

}
