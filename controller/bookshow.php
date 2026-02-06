<?php


class bookshow extends clientAuth
{

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
    protected $dbCustomer ;
    protected $dbBase ;
    public $transactions;

    public function __construct()
    {

        parent::__construct();
        $this->dbCustomer = new Model();
        $this->dbBase = new ModelBase();

        $this->transactions = $this->getModel('transactionsModel');

    }
    /**
     * @return bookLocalModel|bool
     */
    protected function bookLocalModel()
    {
        return Load::getModel('bookLocalModel');
    }
    /**
     * @return reportModel|bool
     */
    protected function reportModel()
    {
        //
        return Load::getModel('reportModel');
    }

    /**
     * @return agency|bool
     */
    protected function agencyController()
    {
        //
        return Load::controller('agency');
    }
    public function createExcelFile($param)
    {

        $_POST = $param;
        $resultBook = $this->listBookLocal();
        $bookshowTest = $this->getController('bookshowTest');
        $transactions = $bookshowTest->getTransactionsByDateRange($param['date_of'],$param['to_date']);

        if (!empty($resultBook)) {

            if (TYPE_ADMIN == 1) {
                $TitleComAgency='کم آژانس';
                $TitleShareAgency='سود آژانس';
                $TitleBuyFromIt='فروش به آژانس';
                $TitleMarkCounter='مارک کان';
                $TitleMarkAgency='مارک آژ';
                $TitlePayment='آژانس/مس';
                $TitleComAgencyProvider='کم چارتری';
            }
            else {
                $TitleComAgency='کمیسیون';
                $TitleShareAgency='سود شما';
                $TitleBuyFromIt='خرید از سفر360';
                $TitleMarkCounter='مارک کانتر';
                $TitleMarkAgency='مارک آژانس';
                $TitlePayment='فروش';
                $TitleComAgencyProvider='کمیسیون چارتری';
            }

            // برای نام گذاری سطر اول فایل اکسل //
            $firstRowColumnsHeading = ['تاریخ خرید', 'شماره فاکتور', 'نوع پرواز', 'مبدا - مقصد', 'ایرلاین', 'شناسه نرخی', 'شماره بلیط' , 'pnr' ,'شماره پرواز', 'ساعت پرواز',
                'تاریخ پرواز','شماره موبایل خریدار','نام مسافر', 'درصد تخفیف خریدار', 'آژانس همکار (نام خریدار)', 'یک طرفه / دو طرفه',
                'وضعیت', 'خرید از طریق' , 'total' , 'fare' , $TitleComAgency , $TitleComAgencyProvider , $TitleBuyFromIt , $TitleMarkAgency , $TitleMarkCounter , $TitlePayment , $TitleShareAgency];

            if (TYPE_ADMIN == '1') {

                $idx = array_search('fare', $firstRowColumnsHeading);
                array_splice($firstRowColumnsHeading, $idx + 1, 0, [
                    'خرید از پروایدر',
                    'it com'
                ]);

                $idx2 = array_search($TitleBuyFromIt, $firstRowColumnsHeading);
                array_splice($firstRowColumnsHeading, $idx2 + 1, 0, [
                    'سهم ما'
                ]);
            }


            $firstRowWidth = [20, 20, 20, 30, 10, 10, 15 , 10 , 10, 10, 15, 20, 20, 10, 15, 10, 15 , 10 , 10 , 10 , 10 , 10 , 10 , 10 , 10 , 10 , 10];

            if (TYPE_ADMIN == '1') {
                $firstRowWidth = array_merge($firstRowWidth, [10, 10, 10]);
            }


            $dataRows = [];
            foreach ($resultBook as $k => $book) {

                if ($book['successfull'] != 'book') {
                    continue;
                }


                $creation_date_int = (!empty($book['creation_date_int'])) ? dateTimeSetting::jdate('Y-m-d (H:i:s)', $book['creation_date_int']) : '';

                if ($book['flight_type'] == 'charter') {
                    $type_charter =($book['pid_private'] == '1') ? "چارتر(چارتری اختصاصی)" : "چارتر(چارتری اشتراکی)";
                    $flight_type = $type_charter;
                }
                elseif ($book['flight_type'] == 'system' && $book['pid_private'] == '1') {
                    $flight_type = 'سیستمی (پید اختصاصی)';
                }
                elseif ($book['flight_type'] == 'system' && $book['pid_private'] == '0') {
                    $flight_type = 'سیستمی (پید اشتراکی)';
                }
                elseif ($book['flight_type'] == 'charterPrivate') {
                    $flight_type = 'چارتری (چارتر اختصاصی)';
                }
                else {
                    $flight_type = 'نامشخص';
                }


                if (!empty($book['origin_city']) && !empty($book['desti_city'])) {
                    $city = $book['origin_city'] . ' ( ' . $book['origin_airport_iata'] . ' ) ';
                    $city .= ' - ' . $book['desti_city'] . ' ( ' . $book['desti_airport_iata'] . ' ) ';
                }
                else {
                    $cityNameOrigin = functions::NameCityForeign($book['origin_airport_iata']);
                    $cityNameDestination = functions::NameCityForeign($book['desti_airport_iata']);
                    $city = $cityNameOrigin['DepartureCityFa'] . ' ( ' . $book['origin_airport_iata'] . ' ) ';
                    $city .= ' - ' . $cityNameDestination['DepartureCityFa'] . ' ( ' . $book['desti_airport_iata'] . ' ) ';
                }


                if (!empty($book['airline_name'])) {
                    $airline_name = $book['airline_name'];
                } else {
                    $airline = functions::InfoAirline($book['airline_iata']);
                    $airline_name = $airline['name_fa'];
                }


                $infoMember = functions::infoMember($book['member_id'], $book['client_id']);
                $member_percent = '';
                if ($infoMember['is_member'] == '1') {
                    $member_percent = $book['percent_discount'] ;
                }


                $agency_id = (!empty($book['agency_id']) && $book['agency_id'] > 0) ? 'آژانس ' . $book['agency_name'] : '';

                $time_flight = $this->format_hour($book['time_flight']);
                $date_flight = $this->DateJalali($book['date_flight']);

                $agency_commission = '';
                if ($book['flight_type'] == 'charter' || $book['flight_type'] == 'system') {
                    $agency_commission = $book['agency_commission'];
                }

                $DetectDirection = functions::DetectDirection($book['factor_number'], $book['request_number']);

                if ($book['type_app'] == 'Web' || $book['type_app'] == 'Application') {

                    if ($book['request_cancel'] == 'confirm') {
                        $successfull = 'کنسل شده';
                    } else  {
                        $successfull = 'رزرو قطعی';
                    }


                }
                else {

                    if ($book['request_cancel'] == 'confirm') {
                        $successfull = 'کنسل شده';
                    } else  {
                        $successfull = 'رزرو قطعی';
                    }

                }


                $type_app = '';
                if ($book['type_app'] == 'Web') {
                    $type_app = 'وب سایت';
                } elseif ($book['type_app'] == 'Application') {
                    $type_app = 'اپلیکیشن';
                } elseif ($book['type_app'] == 'reservation') {
                    $type_app = 'بلیط رزرواسیون';
                }

                if ( $book['flight_type'] != 'charterPrivate' ) {
                    $DataFlightTotal = number_format($book['provider_adt_price'] + $book['provider_chd_price'] + $book['provider_inf_price']);
                    $DataFlightFare = $book['flight_type'] == 'system' ? number_format($book['adt_fare_sum'] + $book['chd_fare_sum'] + $book['inf_fare_sum']) : '_';
                }
                else {
                    $DataFlightTotal = '_';
                    $DataFlightFare = '_';
                }


                $TitleDetectDirection=functions::DetectDirection( $book['factor_number'], $book['request_number'] );
                $ArrInfoAgancyShare=array();

                $pricetotal         = 0;
                $charter_price      = 0;

                $PassengerPayment=0;
                if ( $book['flight_type'] != 'charterPrivate' ) {
                    if ( $book['flight_type'] == 'charter' ||  $book['api_id'] == '14' ) {
                        if ( $book['percent_discount'] > 0 ) {
                            $PassengerPayment=functions::CalculateDiscount( $book['request_number'], 'yes' );
                            $DataFlightPassengerPayData = number_format( ($PassengerPayment + $book['sum_amount_added']) );
                            if(TYPE_ADMIN != 1){
                                $DataFlightPassengerPayData .= "<hr style='margin:3px'><span style='text-decoration: line-through;'>";
                                $DataFlightPassengerPayData .= number_format( $book['agency_commission'] + $book['supplier_commission'] + $book['irantech_commission'] )
                                    . '</span>';
                            }

                            if ( $book['request_cancel'] != 'confirm' && ( $book['successfull'] == 'book' || $book['successfull'] == 'private_reserve' ) ) {
                                $pricetotal    = ( $book['agency_commission'] + $book['supplier_commission'] + $book['irantech_commission'] ) + $pricetotal;
                                $charter_price = $book['agency_commission'] + $book['supplier_commission'] + $book['irantech_commission'] + $charter_price;
                            }
                        } else {
                            $PassengerPayment=functions::CalculateDiscount( $book['request_number'], 'yes' );
                            $DataFlightPassengerPayData = number_format(($PassengerPayment + $book['sum_amount_added']));

                            if ( $book['request_cancel'] != 'confirm' && ( $book['successfull'] == 'book' || $book['successfull'] == 'private_reserve' ) ) {
                                $pricetotal    = ( $book['agency_commission'] + $book['irantech_commission'] + $book['supplier_commission'] ) + $pricetotal;
                                $charter_price = $book['agency_commission'] + $book['irantech_commission'] + $book['supplier_commission'] + $charter_price;
                            }
                        }
                    }
                    elseif ( $book['flight_type'] == 'system' ) {
                        if ( $book['percent_discount'] > 0 ) {
                            $PassengerPayment=functions::CalculateDiscount( $book['request_number'], 'No' );
                            $DataFlightPassengerPayData = number_format(($PassengerPayment + $book['sum_amount_added']));
                            if(TYPE_ADMIN != 1){
                                $DataFlightPassengerPayData .= "<hr style='margin:3px'> <span style='text-decoration: line-through;'>";
                                $DataFlightPassengerPayData .= $book['adt_price'] + $book['chd_price'] + $book['inf_price'] . '</span>';
                            }
                            if ( $book['request_cancel'] != 'confirm' && ( $book['successfull'] == 'book' || $book['successfull'] == 'private_reserve' ) ) {
                                $pricetotal = ( $book['adt_price'] + $book['chd_price'] + $book['inf_price'] ) + $pricetotal;
                                if ( $book['pid_private'] == '1' ) {
                                    $prsystem_price += ( $book['adt_price'] + $book['chd_price'] + $book['inf_price'] );
                                } else {
                                    $pubsystem_price += ( $book['adt_price'] + $book['chd_price'] + $book['inf_price'] );
                                }
                            }

                        } else {
                            if ( $book['IsInternal'] == '0' ) {
                                $PassengerPayment=functions::CalculateDiscount( $book['request_number'], 'No' );
                                $DataFlightPassengerPayData = number_format( ($PassengerPayment + $book['sum_amount_added']) );
                            } else {
                                $PassengerPayment=$book['adt_price'] + $book['chd_price'] + $book['inf_price'] ;
                                $DataFlightPassengerPayData = number_format(($PassengerPayment + $book['sum_amount_added']));
                            }
                            if ( $book['request_cancel'] != 'confirm' && ( $book['successfull'] == 'book' || $book['successfull'] == 'private_reserve' ) ) {
                                $pricetotal = ( $book['adt_price'] + $book['chd_price'] + $book['inf_price'] ) + $pricetotal;
                                if ( $book['pid_private'] == '1' ) {
                                    $prsystem_price += ( $book['adt_price'] + $book['chd_price'] + $book['inf_price'] );
                                } else {
                                    $pubsystem_price += ( $book['adt_price'] + $book['chd_price'] + $book['inf_price'] );
                                }
                            }
                        }

                    }
                }
                else {
                    $InfoTicketReservation = $this->getInfoTicketReservation( $book['request_number'] );
                    if (TYPE_ADMIN != 1 && $InfoTicketReservation['totalPriceWithoutDiscount'] != 0 ) {
                        $DataFlightPassengerPayData = "<span style='text-decoration: line-through;'>" . number_format( $InfoTicketReservation['totalPriceWithoutDiscount'], 0, ".", "," ) . "</span><hr style='margin:3px'>";
                    }
                    $PassengerPayment=$InfoTicketReservation['totalPrice'];
                    $DataFlightPassengerPayData .= number_format( $PassengerPayment, 0, ".", "," );
                    $pricetotal                 = ( $InfoTicketReservation['totalPrice'] ) + $pricetotal;
                }

                if ( $book['flight_type'] != 'charterPrivate' ) {
                    //Ardalani1404
                    if($TitleDetectDirection!='دوطرفه-برگشت') {
                        $BuyFromIt=$transactions[$book['factor_number']];//خرید از سفر30
                        $DataFlightTotalFree = number_format($BuyFromIt);
                        if ($book['request_cancel'] != 'confirm' && ($book['successfull'] == 'book' || $book['successfull'] == 'private_reserve')) {
                            if ( TYPE_ADMIN == 1) { //محاسبه اعتبار فعلی مشتری
                                $DataFlightTotalFree.=$bookshowTest->CalculateCurrentCredit($book['client_id'],$book['factor_number'],$BuyFromIt);
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

                if ( $book['flight_type'] == 'charter' || $book['flight_type'] == 'system' ) {
                    if($TitleDetectDirection=='دوطرفه-برگشت'){//تو ردیف رفت محاسبه میشه
                        $ArrInfoAgancyShare[$book['factor_number']]['SellingReturnPassengerTickets']=$PassengerPayment;
                        $DataFlightAgencyShare ='-';
                        $DataFlightitAgencyCommission ='-';
                    }
                    else {

                        if($TitleDetectDirection=='دوطرفه-رفت'){//تو ردیف رفت باید حساب برگشت رو هم کنیم
                            $agencyShare = $book['successfull'] == 'book' ? ($PassengerPayment+ $ArrInfoAgancyShare[$book['factor_number']]['SellingReturnPassengerTickets'] + $book['sum_amount_added'])- $BuyFromIt : 0;
                        }else{
                            $agencyShare = $book['successfull'] == 'book' ? ($PassengerPayment + $book['sum_amount_added']) - $BuyFromIt : 0;
                        }


                        $DataFlightAgencyShare =number_format($agencyShare);
                        $DataFlightitAgencyCommission =number_format($book['sum_system_flight_commission']);
                        if ($book['request_cancel'] != 'confirm' && ($book['successfull'] == 'book' || $book['successfull'] == 'private_reserve')) {
                            $priceAgency += $agencyShare;
                        }
                    }

                }
                else {
                    $DataFlightAgencyShare = '-';
                    $DataFlightitAgencyCommission = '-';
                }

                $DataFlightitAgencyCommissionProvider = number_format($book['sum_adt_com'] + $book['sum_chd_com'] + $book['sum_inf_com']);

                if (
                    ($book['flight_type'] == 'system' && $book['IsInternal'] == '1') ||
                    ($book['flight_type'] == 'system' && $book['IsInternal'] == '0' && $book['foreign_airline'] == '0')
                ) {
                    $DataFlightPassengerPayData1 = " _ ";
                } else {
                    $DataFlightPassengerPayData1 = number_format($book['agency_commission']);
                }

                $DataFlightPassengerPayData2 = number_format($book['sum_amount_added']);

                if ( TYPE_ADMIN == 1 ) {

                    if (
                        ($book['flight_type'] == 'system' && $book['IsInternal'] == '1') ||
                        ($book['flight_type'] == 'system' && $book['IsInternal'] == '0' && $book['foreign_airline'] == '0')
                    ) {
                        $DataFlightProvider = number_format(($book['provider_adt_price'] + $book['provider_chd_price'] + $book['provider_inf_price']) - ($book['sum_system_flight_commission']));
                    }
                    else {
                        $DataFlightProvider = number_format(($book['provider_adt_price'] + $book['provider_chd_price'] + $book['provider_inf_price']));
                    }

                    $DataFlightitCom = 0;

                    $DataFlightIranTechCommission = "";
                    if ( $book['flight_type'] != 'charterPrivate' ) {

                        $DataFlightIranTechCommission =number_format($book['irantech_commission']);
                    } else {
                        $DataFlightIranTechCommission = '---';
                    }
                }
                


                $dataRows[$k]['creation_date_int'] = $creation_date_int;
                $dataRows[$k]['factor_number'] = $book['factor_number'] . ' ';
                $dataRows[$k]['flight_type'] = $flight_type;
                $dataRows[$k]['city'] = $city;
                $dataRows[$k]['airline_name'] = $airline_name;
                $dataRows[$k]['cabin_type'] = $book['cabin_type'];
                $dataRows[$k]['eticket_number'] = $book['eticket_number']. ' ';
                $dataRows[$k]['pnr'] = $book['pnr']. ' ';
                $dataRows[$k]['flight_number'] = $book['flight_number'];
                $dataRows[$k]['time_flight'] = $time_flight;
                $dataRows[$k]['date_flight'] = $date_flight;
                $dataRows[$k]['member_mobile'] = $book['member_mobile'];

                $passenger_name  = $book['passenger_name'] ? $book['passenger_name'] : $book['passenger_name_en'];
                $passenger_family =  $book['passenger_family'] ?  $book['passenger_family'] :  $book['passenger_family_en'];
                $dataRows[$k]['passenger_name'] = $passenger_name . '  '. $passenger_family;

                $dataRows[$k]['member_percent'] = $member_percent;
                $dataRows[$k]['agency_id'] = $agency_id . ' (' . $book['member_name'] . ')';
                $dataRows[$k]['DetectDirection'] = $DetectDirection;
                $dataRows[$k]['successfull'] = $successfull;
                $dataRows[$k]['type_app'] = $type_app;
                $dataRows[$k]['total'] = $DataFlightTotal;
                $dataRows[$k]['fare'] = $DataFlightFare;
                if (TYPE_ADMIN == '1') {
                    $dataRows[$k]['buy_provider'] = $DataFlightProvider;
                    $dataRows[$k]['it_com'] = $DataFlightitCom;
                }
                $dataRows[$k]['agency_com'] = $DataFlightitAgencyCommission;
                $dataRows[$k]['agency_com_provider'] = $DataFlightitAgencyCommissionProvider;
                $dataRows[$k]['total_free'] = $DataFlightTotalFree;
                if (TYPE_ADMIN == '1') {
                    $dataRows[$k]['our_share'] = $DataFlightIranTechCommission;
                }
                $dataRows[$k]['mark_agency'] = $DataFlightPassengerPayData1;
                $dataRows[$k]['mark_counter'] = $DataFlightPassengerPayData2;
                $dataRows[$k]['agency_sale'] = $DataFlightPassengerPayData;
                $dataRows[$k]['agency_share'] = $DataFlightAgencyShare;
            }


            $objCreateExcelFile = Load::controller('createExcelFile');
            $resultExcel = $objCreateExcelFile->create($dataRows, $firstRowColumnsHeading , $firstRowWidth);
            if ($resultExcel['message'] == 'success') {
                return 'success|' . $resultExcel['fileName'];
            } else {
                return 'error|متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید';
            }


        } else {
            return 'error|اطلاعاتی برای ساخت فایل اکسسل وجود ندارد.';
        }


    }


    public function listBookLocal()
    {
        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);

        if (TYPE_ADMIN == '1') {
            $ModelBase = Load::library('ModelBase');

            $sql = "SELECT rep.*, cli.AgencyName AS NameAgency, cli.Domain AS DomainAgency, "
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
                . " FROM report_tb as rep"
                . " LEFT JOIN clients_tb AS cli ON cli.id =rep.client_id WHERE  1=1 ";


            /*    if (empty($_POST['cancel']) || ($_POST['cancel'] == 'No')) {
                    $sql .= " AND request_cancel <> 'confirm'";
                }*/
            if (Session::CheckAgencyPartnerLoginToAdmin()) {
                $sql .= " AND agency_id='{$_SESSION['AgencyId']}' ";

                if (!empty($_POST['CounterId'])) {
                    if ($_POST['CounterId'] != "all") {
                        $sql .= " AND member_id ='{$_POST['CounterId']}'";
                    }
                }
            }
            if(!empty($_POST['member_id'])){
                $sql.=' AND member_id='.$_POST['member_id'].' ';
            }

            if(!empty($_POST['agency_id'])){
                $sql.=' AND agency_id='.$_POST['agency_id'].' ';
            }


            if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {

                $date_of = explode('-', $_POST['date_of']);
                $date_to = explode('-', $_POST['to_date']);
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
                $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
            } else {

                $sql .= "AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";

            }

            if (!empty($_POST['successfull'])) {
                if ($_POST['successfull'] == 'all') {

                    $sql .= " AND (successfull ='nothing' OR successfull ='book' OR successfull ='private_reserve' OR successfull ='credit' OR successfull ='bank' OR successfull ='prereserve' ) ";
                } else if ($_POST['successfull'] == 'book') {
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
            if (!empty($_POST['pnr'])) {
                $sql .= " AND pnr ='{$_POST['pnr']}'";
            }
            if (!empty($_POST['request_number'])) {
                $sql .= " AND request_number ='{$_POST['request_number']}'";
            }

            if (!empty($_POST['factor_number'])) {
                $sql .= " AND factor_number ='{$_POST['factor_number']}'";
            }
            if (!empty($_POST['client_id'])) {
                if ($_POST['client_id'] != "all") {
                    $sql .= " AND client_id ='{$_POST['client_id']}'";
                }
            }


            if (!empty($_POST['passenger_name'])) {
                $trimPassengerName =trim($_POST['passenger_name']) ;
                $sql .= " AND (passenger_name LIKE '%{$trimPassengerName}%' OR passenger_family LIKE '%{$trimPassengerName}%')";
            }


            if (!empty($_POST['passenger_national_code'])) {
                $sql .= " AND (passenger_national_code ='{$_POST['passenger_national_code']}')";
            }


            if (!empty($_POST['member_name'])) {
                $sql .= " AND member_name LIKE '%{$_POST['member_name']}%'";
            }
            if (!empty($_POST['payment_type'])) {
                if ($_POST['payment_type'] == 'all') {
                    $sql .= " AND (payment_type != '' OR payment_type != 'nothing')";
                } elseif ($_POST['payment_type'] == 'credit') {
                    $sql .= " AND (payment_type = 'credit' OR payment_type = 'member_credit')";
                } else {
                    $sql .= " AND payment_type ='{$_POST['payment_type']}'";
                }
            }

            if (!empty($_POST['eticket_number'])) {
                $sql .= " AND (eticket_number ='{$_POST['eticket_number']}')";
            }
            if (!empty($_POST['AirlineIata'])) {
                $sql .= " AND (airline_iata ='{$_POST['AirlineIata']}')";
            }


            if (!empty($_POST['DateFlight'])) {
                $xpl = explode('-', $_POST['DateFlight']);

                $FinalDate = dateTimeSetting::jalali_to_gregorian($xpl[0], $xpl[1], $xpl[2], '-');

                $sql .= " AND date_flight Like'%{$FinalDate}%'";
            }
            if (!empty($_POST['IsAgency'])) {
                if ($_POST['IsAgency'] == 'agency') {
                    $sql .= " AND agency_id <> '0' AND agency_id <> '5'";
                } else if ($_POST['IsAgency'] == 'Ponline') {
                    $sql .= " AND agency_id = '0' OR agency_id = '5'";
                }
            }
            if(isset($_POST['report_for_excel']) && $_POST['report_for_excel'] == true){
                $sql .= " GROUP BY rep.id ";
            }else{
                $sql .= " GROUP BY rep.request_number ";
            }

            $sql .= "ORDER BY rep.creation_date_int DESC, rep.id DESC  ";




            $BookShow = $ModelBase->select($sql);

        } else {
            $Model = Load::library('Model');
            $sql = "SELECT *,'" . CLIENT_DOMAIN . "' AS DomainAgency,creation_date_int,request_number,factor_number,type_app,pid_private,origin_city,"
                ."desti_city,origin_airport_iata,desti_airport_iata,airline_name,cabin_type,airline_iata,"
                ."time_flight,date_flight,api_id,flight_number,agency_commission,adt_price,chd_price,inf_price,successfull,flight_type,"
                ."passenger_name,passenger_family,IsInternal,"
                ."SUM( api_commission ) AS api_commission,"
                ."SUM( agency_commission ) AS agency_commission,"
                ."SUM( supplier_commission ) AS supplier_commission,"
                ."SUM( irantech_commission ) AS irantech_commission,"
                ."SUM( adt_price ) AS adt_price,"
                ."SUM( chd_price ) AS chd_price,"
                ."SUM( inf_price ) AS inf_price,"
                ."SUM( adt_fare ) AS adt_fare_sum,"
                ."SUM( chd_fare ) AS chd_fare_sum,"
                ."SUM( inf_fare ) AS inf_fare_sum,"
                //			    ."(SELECT (SUM(adt_qty) AS adt_qty_f + SUM(chd_qty) AS chd_qty_f + SUM(inf_qty) AS inf_qty_f) as passenger_count WHERE request_number = "
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

            if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {

                $date_of = explode('-', $_POST['date_of']);
                $date_to = explode('-', $_POST['to_date']);
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
                $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
            } else {
                $sql .= "AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";

            }
            if(!empty($_POST['member_id'])){
                $sql.=' AND member_id='.$_POST['member_id'].' ';
            }

            if(!empty($_POST['agency_id'])){
                $sql.=' AND agency_id='.$_POST['agency_id'].' ';
            }

            if (!empty($_POST['successfull'])) {
                if ($_POST['successfull'] == 'all') {

                    $sql .= " AND (successfull ='nothing' OR successfull ='book' OR successfull ='credit' OR successfull ='bank' ) ";
                } else if ($_POST['successfull'] == 'book') {
                    $sql .= " AND successfull ='{$_POST['successfull']}'";
                } else {
                    $sql .= " AND (successfull ='nothing' OR successfull ='credit' OR successfull ='bank' ) ";
                }
            }


            if (!empty($_POST['flight_type'])) {

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

            if (!empty($_POST['pnr'])) {
                $sql .= " AND pnr ='{$_POST['pnr']}'";
            }

            if (!empty($_POST['request_number'])) {
                $sql .= " AND request_number ='{$_POST['request_number']}'";
            }

            if (!empty($_POST['factor_number'])) {
                $sql .= " AND factor_number ='{$_POST['factor_number']}'";
            }
            if (!empty($_POST['passenger_name'])) {
                $trimPassengerName =trim($_POST['passenger_name']) ;
                $sql .= " AND (passenger_name LIKE '%{$trimPassengerName}%' OR passenger_family LIKE '%{$trimPassengerName}%')";
            }


            if (!empty($_POST['passenger_national_code'])) {
                $sql .= " AND (passenger_national_code ='{$_POST['passenger_national_code']}')";
            }


            if (!empty($_POST['member_name'])) {
                $sql .= " AND member_name LIKE '%{$_POST['member_name']}%'";
            }

            if (!empty($_POST['payment_type'])) {
                if ($_POST['payment_type'] == 'all') {
                    $sql .= " AND (payment_type != '' OR payment_type != 'nothing')";
                } elseif ($_POST['payment_type'] == 'credit') {
                    $sql .= " AND (payment_type = 'credit' OR payment_type = 'member_credit')";
                } else {
                    $sql .= " AND payment_type ='{$_POST['payment_type']}'";
                }
            }

            if (!empty($_POST['AirlineIata'])) {
                $sql .= " AND (airline_iata ='{$_POST['AirlineIata']}')";
            }


            if (!empty($_POST['DateFlight'])) {
                $xpl = explode('-', $_POST['DateFlight']);

                $FinalDate = dateTimeSetting::jalali_to_gregorian($xpl[0], $xpl[1], $xpl[2], '-');

                $sql .= " AND date_flight ='{$FinalDate}'";
            }

            if (!empty($_POST['IsAgency'])) {

                if ($_POST['IsAgency'] == 'agency') {
                    $sql .= " AND agency_id <> '0'";
                } else if ($_POST['IsAgency'] == 'Ponline') {
                    $sql .= " AND agency_id = '0'";
                }
            }


            if (CLIENT_ID == 79 && CLIENT_DOMAIN != 'online.26401000.ir') {
                $agencyQuery = "SELECT id FROM agency_tb WHERE domain='" . CLIENT_DOMAIN . "'";
                $AgencyResult = $Model->load($agencyQuery);
                if (!empty($AgencyResult)) {
                    $sql .= " AND agency_id={$AgencyResult['id']}";
                }
            }
            if(isset($_POST['report_for_excel']) && $_POST['report_for_excel'] == true){
                $sql .= " GROUP BY id ";
            }else{
                $sql .= " GROUP BY request_number ";
            }
            $sql .= "  ORDER BY creation_date_int DESC, id DESC ";



            $BookShow = $Model->select($sql);
        }


        $this->CountTicket = count($BookShow);

        return $BookShow;


    }

    public function format_hour($num)
    {

        $time = date("H:i", strtotime($num));

        return $time;
    }

    public function DateJalali($param)
    {
        $split = explode(' ', $param);
        $explode_date = explode('-', $split[0]);
        $date_now = dateTimeSetting::gregorian_to_jalali($explode_date[0], $explode_date[1], $explode_date[2], '/');

        return isset($split[1]) ? $split[1] . ' ' . $date_now : $date_now;
    }

    public function getInfoTicketReservation($requestNumber)
    {
        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $sql = " SELECT *
                 FROM report_tb
                 WHERE request_number='{$requestNumber}'
                 ORDER BY passenger_age";
            $Book = $ModelBase->select($sql);

        } else {

            $Model = Load::library('Model');
            $sql = " SELECT *
                 FROM book_local_tb 
                 WHERE request_number='{$requestNumber}'
                 ORDER BY passenger_age";
            $Book = $Model->select($sql);

        }

        $totalPrice = 0;
        $totalPriceWithoutDiscount = 0;
        foreach ($Book as $val) {
            $namePrice = strtolower($val['passenger_age']) . '_price';
            $nameDiscountPrice = 'discount_' . strtolower($val['passenger_age']) . '_price';
            $totalPriceWithoutDiscount += $val[$namePrice];
            $totalPrice += $val[$nameDiscountPrice];
        }

        if ($Book[0]['percent_discount'] > 0) {
            $result['totalPriceWithoutDiscount'] = $totalPriceWithoutDiscount;
            $result['totalPrice'] = $totalPrice;
        } else {
            $result['totalPriceWithoutDiscount'] = 0;
            $result['totalPrice'] = $totalPriceWithoutDiscount;
        }

        $result['infoTicket'] = $Book;

        return $result;
    }

    public function insert($info)
    {

        Load::autoload('Model');
        $Model = new Model();
        $data ['price'] = $info['price'];
        $data['comment'] = $info['comment'];
        $data['status'] = '1';

        $Model->setTable('transaction_tb');
        $result = $Model->insertLocal($data);

        $this->transactions->insertTransaction($data);

        if ($result) {
            echo 'success : َشارژحساب شما افزایش یافت ';
        } else {
            echo 'error : خطا درشارژحساب';
        }
    }

    public function showedit($request_number)
    {

        if (isset($request_number) && !empty($request_number)) {

            if (TYPE_ADMIN == '1') {
                $ModelBase = Load::autoload('ModelBase');
                $ModelBase = new ModelBase();
                $edit_query = " SELECT * FROM  report_tb  WHERE request_number='{$request_number}'";
                $res_edit = $ModelBase->select($edit_query);
            } else {
                $Model = Load::autoload('Model');
                $Model = new Model();
                $edit_query = " SELECT * FROM  book_local_tb  WHERE request_number='{$request_number}'";
                $res_edit = $Model->select($edit_query);
            }

            if (!empty($res_edit)) {
                $this->edit = $res_edit;
            } else {
                header("Location: " . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . "/404.tpl");
                exit();
            }
        } else {
            header("Location: " . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . "/404.tpl");
            exit();
        }
    }

    public function info_flight($request_number, $Email)
    {

        if (TYPE_ADMIN == '1') {
            $ModelBase = Load::autoload('ModelBase');
            $ModelBase = new ModelBase();

            if (!empty($request_number)) {
                $edit_query = "SELECT * , "
                    . " (SELECT count(id)   FROM  report_tb WHERE request_number='{$request_number}' AND passenger_age='Adt') AS adt_count, "
                    . " (SELECT count(id)  FROM  report_tb WHERE request_number='{$request_number}' AND passenger_age='Chd') AS chd_count , "
                    . " (SELECT count(id)  FROM  report_tb WHERE request_number='{$request_number}' AND passenger_age='Inf') AS inf_count, "
                    . " (SELECT count(id) FROM report_tb WHERE request_number='{$request_number}' AND flight_type='charter') AS charter_count,"
                    . " (SELECT count(id) FROM report_tb WHERE request_number='{$request_number}' AND flight_type='system' AND pid_private='0') AS pubSystem_count,"
                    . " (SELECT count(id) FROM report_tb WHERE request_number='{$request_number}' AND flight_type='system' AND pid_private='1') AS prSystem_count"
                    . "  FROM  report_tb  WHERE request_number='{$request_number}'";
                $res_edit = $ModelBase->load($edit_query);
            }


            if (!empty($request_number)) {
                $cancel_query = "SELECT  * , "
                    . " (SELECT count(id)   FROM  report_tb WHERE request_number='{$request_number}' AND passenger_age='Adt' AND request_cancel='confirm') AS adt_count, "
                    . " (SELECT count(id)  FROM  report_tb WHERE request_number='{$request_number}' AND passenger_age='Chd' AND request_cancel='confirm') AS chd_count , "
                    . " (SELECT count(id)  FROM  report_tb WHERE request_number='{$request_number}' AND passenger_age='Inf' AND request_cancel='confirm') AS inf_count "
                    . "  FROM  report_tb  WHERE request_number='{$request_number}' AND request_cancel='confirm'";
                $res_cancel = $ModelBase->load($cancel_query);
            }

        } else {
            $Model = Load::autoload('Model');
            $Model = new Model();


            if (!empty($request_number)) {
                $edit_query = "SELECT * , "
                    . " (SELECT count(id)   FROM  book_local_tb WHERE request_number='{$request_number}' AND (request_number> 0 || request_number<>'') AND passenger_age='Adt' ) AS adt_count, "
                    . " (SELECT count(id)  FROM  book_local_tb WHERE request_number='{$request_number}' AND (request_number> 0 || request_number<>'') AND passenger_age='Chd' ) AS chd_count , "
                    . " (SELECT count(id)  FROM  book_local_tb WHERE request_number='{$request_number}' AND (request_number> 0 || request_number<>'') AND passenger_age='Inf' ) AS inf_count"
                    . "  FROM  book_local_tb  WHERE request_number='{$request_number}' ";
                $res_edit = $Model->load($edit_query);
            }

            if (!empty($request_number)) {
                $cancel_query = "SELECT * , "
                    . " (SELECT count(id)   FROM  book_local_tb WHERE request_number='{$request_number}' AND passenger_age='Adt' AND request_cancel='confirm') AS adt_count, "
                    . " (SELECT count(id)  FROM  book_local_tb WHERE request_number='{$request_number}' AND passenger_age='Chd' AND request_cancel='confirm') AS chd_count , "
                    . " (SELECT count(id)  FROM  book_local_tb WHERE request_number='{$request_number}' AND passenger_age='Inf' AND request_cancel='confirm') AS inf_count "
                    . "  FROM  book_local_tb  WHERE request_number='{$request_number}' AND request_cancel='confirm'";
                $res_cancel = $Model->load($cancel_query);
            }


        }

        $this->countTotal = $res_edit['adt_count'] + $res_edit['chd_count'] + $res_edit['inf_count'];
        $this->adt_qty = $res_edit['adt_count'];
        $this->chd_qty = $res_edit['chd_count'];
        $this->inf_qty = $res_edit['inf_count'];
        $this->charter_qty = $res_edit['charter_count'];
        $this->pubSystem_qty = $res_edit['pubSystem_count'];
        $this->prSystem_qty = $res_edit['prSystem_count'];
        if (!empty($res_edit)) {
//                $this->list = $res_edit;
            if ($res_cancel['adt_count'] > 0 || $res_cancel['chd_count'] > 0 || $res_cancel['inf_count'] > 0) {
                return '<span class=" fa fa-user" style="margin-left: 5px;">' . $res_edit['adt_count'] . '</span><span class=" fa fa-child" style="margin-left: 5px;">' . $res_edit['chd_count'] . '</span><span class=" fa fa-child">' . $res_edit['inf_count'] . '</span>'
                    . '<br/><span class=" fa fa-user" style="margin-left: 5px; color: red">' . $res_cancel['adt_count'] . '</span><span class=" fa fa-child" style="margin-left: 5px; color: red">' . $res_cancel['chd_count'] . '</span><span class=" fa fa-child " style="color: red">' . $res_cancel['inf_count'] . '</span>';
            } else {
                return '<span class=" fa fa-user" style="margin-left: 5px;">' . $res_edit['adt_count'] . '</span><span class=" fa fa-child" style="margin-left: 5px;">' . $res_edit['chd_count'] . '</span><span class=" fa fa-child">' . $res_edit['inf_count'] . '</span>';
            }
        }
    }

    public function type_airplan($name)
    {
        $resultLocal = Load::controller('resultLocal');

        return $resultLocal->AirPlaneType($name);
    }

    public function list_hamkar()
    {
        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT * FROM clients_tb ORDER BY id DESC";

        $client = $ModelBase->select($sql);

        return $client;
    }

    public function listCounter($AgencyId)
    {


        $Model = Load::library('Model');

        $sql = " SELECT * FROM members_tb WHERE fk_agency_id='{$AgencyId}' ORDER BY id DESC";


        $counters = $Model->select($sql);

        return $counters;
    }

    public function type_user($id)
    {

        $Model = Load::autoload('Model');


        $sql = " SELECT * FROM members_tb WHERE id='{$id}' ";
        $user = $Model->load($sql);


        if ($user['is_member'] == '1') {
            return 'کاربر: ' . $user['name'] . ' ' . $user['family'];
        } else {
            return 'کاربر میهمان به مشخصات: ' . $user['mobile'] . ' (' . $user['email'] . ') ';
        }
    }

    public function ShowAddressClient($param)
    {

        $ModelBase = Load::library('ModelBase');


        $sql = "SELECT * FROM clients_tb WHERE id='{$param}'";
        $Client = $ModelBase->load($sql);

        return $Client['Domain'];
    }

    public function info_flight_client($request_number)
    {

        if (TYPE_ADMIN == '1') {
            Load::autoload('ModelBase');
            $ModelBase = new ModelBase();

            $sql = "select *,"
                . " (SELECT COUNT(id) FROM report_tb WHERE request_number='{$request_number}') AS CountId "
                . " from report_tb  where (factor_number='{$request_number}' OR request_number='{$request_number}') AND (((factor_number OR request_number) > 0) OR ((factor_number OR request_number) <>''))  ";
            $result = $ModelBase->select($sql);
        } else {
            Load::autoload('Model');
            $Model = new Model();

            $sql = "select *,"
                . " (SELECT COUNT(id) FROM book_local_tb WHERE request_number='{$request_number}') AS CountId "
                . " from book_local_tb  where (factor_number='{$request_number}' OR request_number='{$request_number}') AND (((factor_number OR request_number) > 0) OR ((factor_number OR request_number) <>''))";
            $result = $Model->select($sql);
        }

//       echo '<pre>'. print_r($result,true).'</pre>';
        $this->count = count($result);

        return $result;
    }

    public function info_flight_directions($factorNumber) {

        return $this->bookLocalModel()->getInfoFlightByFactorNumberWithGroupByDirection($factorNumber);
    }

    public function set_date_reserve($date)
    {
        $date_orginal_exploded = explode(' ', $date);

        $date_miladi_exp = explode('-', $date_orginal_exploded[0]);

        return dateTimeSetting::gregorian_to_jalali($date_miladi_exp[0], $date_miladi_exp[1], $date_miladi_exp[2], '-');
    }

    public function private_supplier_comision($RequestNumber){

        Load::autoload('apiLocal');
        $apiLocal = new apiLocal();

        list($amount, $fare) = $apiLocal->get_total_ticket_price($RequestNumber, 'no');

        return $amount - $this->private_agency_comision($RequestNumber);
    }

    public function private_agency_comision($RequestNumber)
    {
        $apiLocal =   $ModelBase = Load::library('apiLocal');

        list($amount, $fare) = $apiLocal->get_total_ticket_price($RequestNumber, 'no');

        return $amount * ((5) / 100);
    }

    public function ticket_sell_in_time()
    {

        if (TYPE_ADMIN == '1') {
            $ModelBase = Load::library('ModelBase');

            $sqlCharter = " SELECT COUNT(request_number) AS CountTicketCharter FROM report_tb WHERE successfull='book' AND flight_type='charter'";

            $sqlSystem = " SELECT COUNT(request_number) AS CountTicketSystem FROM report_tb WHERE successfull='book' AND flight_type='system' AND pid_private='0'";

            $sqlSystemPrivate = " SELECT COUNT(request_number) AS CountTicketSystemPrivate FROM report_tb WHERE (successfull='private_reserve' OR successfull='book') AND flight_type='system' AND pid_private='1'";

            $sqlTotal = " SELECT COUNT(request_number) AS CountTicketTotal FROM report_tb WHERE (successfull='private_reserve' OR successfull='book') ";

            $countTotalCharter = $ModelBase->load($sqlCharter);
            $countTotalSystem = $ModelBase->load($sqlSystem);
            $countTotalSystemPrivate = $ModelBase->load($sqlSystemPrivate);
            $countTotal = $ModelBase->load($sqlTotal);

            $this->countTotalCharter = $countTotalCharter['CountTicketCharter'] * 10;
            $this->countTotalSystem = $countTotalSystem['CountTicketSystem'] * 10;
            $this->countTotalSystemPrivate = $countTotalSystemPrivate['CountTicketSystemPrivate'] * 10;
            $this->countTotal = $countTotal['CountTicketTotal'] * 10;
        } else {
            Load::autoload('Model');

            $Model = new Model();

            $sqlCharter = " SELECT COUNT( request_number) AS CountTicketCharter FROM book_local_tb WHERE successfull='book' AND flight_type='charter'";
            $sqlSystem = " SELECT COUNT( request_number) AS CountTicketSystem FROM book_local_tb WHERE successfull='book' AND flight_type='system' AND pid_private='0'";
            $sqlSystemPrivate = " SELECT COUNT( request_number) AS CountTicketSystemPrivate FROM book_local_tb WHERE successfull='book' AND flight_type='system' AND pid_private='1'";
            $sqlToatal = " SELECT COUNT( request_number) AS CountTicketToal  FROM book_local_tb WHERE successfull='book' ";

            $countTotalCharter = $Model->load($sqlCharter);
            $countTotalSystem = $Model->load($sqlSystem);
            $countTotalSystemPrivate = $Model->load($sqlSystemPrivate);
            $countTotal = $Model->load($sqlToatal);

            $this->countTotalCharter = $countTotalCharter['CountTicketCharter'];
            $this->countTotalSystem = $countTotalSystem['CountTicketSystem'];
            $this->countTotalSystemPrivate = $countTotalSystemPrivate['CountTicketSystemPrivate'];
            $this->countTotal = $countTotal['CountTicketToal'];
        }
    }

    public function profit_sell_in_time()
    {

        if (TYPE_ADMIN == '1') {
            Load::autoload('ModelBase');

            $ModelBase = new ModelBase();

            $sql = "SELECT id, request_number,"
                . " SUM(api_commission) AS api_commission,"
                . " SUM(agency_commission) AS agency_commission ,"
                . " SUM(supplier_commission) AS supplier_commission ,"
                . " SUM(irantech_commission) AS irantech_commission,"
                . " SUM(adt_price) AS adt_price,"
                . " SUM(chd_price) AS chd_price ,"
                . " SUM(inf_price) AS inf_price "
                . " FROM report_tb"
                . " WHERE successfull='book' AND request_cancel <> 'confirm'  GROUP BY request_number ORDER BY creation_date_int DESC  ";

            $res = $ModelBase->select($sql);

            $amount = 0;

            foreach ($res as $each) {

                if ($each['flight_type'] == "charter") {
                    $amount += $each['agency_commission'] + $each['irantech_commission'] + $each['supplier_commission'];
                } else if ($each['flight_type'] == "system") {
                    $amount += $each['adt_price'] + $each['chd_price'] + $each['inf_price'];
                }
            }

//die();

            return number_format($amount);
        } else {
            Load::autoload('Model');

            $Model = new Model();

            $sql = "SELECT id, request_number,"
                . " SUM(api_commission) AS api_commission,"
                . " SUM(agency_commission) AS agency_commission ,"
                . " SUM(supplier_commission) AS supplier_commission ,"
                . " SUM(irantech_commission) AS irantech_commission,"
                . " SUM(adt_price) AS adt_price,"
                . " SUM(chd_price) AS chd_price ,"
                . " SUM(inf_price) AS inf_price "
                . "FROM book_local_tb "
                . " WHERE successfull='book' AND request_cancel <> 'confirm' "
                . "GROUP BY request_number ORDER BY creation_date_int DESC ";

            $res = $Model->select($sql);

            $amount = 0;

            foreach ($res as $each) {


                if ($each['flight_type'] == "charter") {
                    $amount += $each['agency_commission'] + $each['irantech_commission'] + $each['supplier_commission'];
                } else if ($each['flight_type'] == "system") {
                    $amount += $each['adt_price'] + $each['chd_price'] + $each['inf_price'];
                }
            }


            return number_format($amount);
        }
    }

    public function profit_agency_and_it()
    {

        if (TYPE_ADMIN == '1') {

            Load::autoload('ModelBase');

            $ModelBase = new ModelBase();

            $sql = " SELECT  SUM(irantech_commission) AS irantech_commission  FROM report_tb WHERE  successfull='book' AND request_cancel <> 'confirm'     GROUP BY request_number ";

            $res = $ModelBase->select($sql);
            $amount = 0;
            foreach ($res as $each) {

                $amount += $each['irantech_commission'];
            }


            return number_format($amount);
        } else {
            Load::autoload('Model');
            $Model = new Model();
            Load::autoload('apiLocal');
            $apiLocal = new apiLocal();

            $sql = "SELECT  SUM(agency_commission) AS agency_commission FROM book_local_tb WHERE successfull='book' AND  request_cancel <> 'confirm'  AND flight_type='system'";
            $res = $Model->load($sql);

            $profitSystem = $res['agency_commission'];


            $sqlCharter = "SELECT SUM(agency_commission) AS agency_commission FROM book_local_tb WHERE successfull='book' AND request_cancel <> 'confirm' AND flight_type='charter' ";
            $resCharter = $Model->load($sqlCharter);
            $profitCharter = $resCharter['agency_commission'];


//                die();
            $amount = $profitSystem + $profitCharter;

            return number_format($amount);
        }
    }

    public function five_last_sell()
    {

        if (TYPE_ADMIN == '1') {
            Load::autoload('ModelBase');

            $ModelBase = new ModelBase();

            $sql = " SELECT  request_number ,origin_city,desti_city,flight_number FROM report_tb WHERE successfull='book' GROUP BY request_number  ORDER BY creation_date_int  DESC LIMIT 0,5";

            $res = $ModelBase->select($sql);
        } else {
            Load::autoload('Model');

            $Model = new Model();

            $sql = " SELECT * FROM book_local_tb WHERE successfull='book' GROUP BY request_number  ORDER BY creation_date_int DESC  LIMIT 0,5";

            $res = $Model->select($sql);
        }

        return $res;
    }

    public function five_last_cancel()
    {

        Load::autoload('Model');
        $Model = new Model();
        $sql = "SELECT cancel.*, book.origin_city,book.desti_city,book.flight_number,book.request_number
                FROM cancel_ticket_details_tb AS cancel
                LEFT JOIN book_local_tb AS book ON book.request_number = cancel.RequestNumber
                WHERE cancel.Status='RequestMember' ORDER BY  cancel.id DESC LIMIT 0,5   ";

        $resultCancel = $Model->select($sql);

        if (!empty($resultCancel)) {
            return $resultCancel;

        } else {
            return 'empty';
        }

    }

    public function copmarDate($date, $time)
    {
        $DateOneMonth = time() - (30 * 24 * 60 * 60);

        if (strpos($date, 'T') !== false) {
            $date = explode('T', $date);
            $dateFlight = $date[0];
            $TimeFlight = date("H:i", strtotime($time));

            $date_expl = explode('-', $dateFlight);
            $time_expl = explode(':', $TimeFlight);

            $Flight_Time = mktime($time_expl[0], $time_expl[1], 0, $date_expl[1], $date_expl[2], $date_expl[0]);

        } else {
            $dateFlight = $date;
            $TimeFlight = date("H:i", strtotime($time));

            $date_expl = explode('-', $dateFlight);
            $time_expl = explode(':', $TimeFlight);

            $Flight_Time = mktime($time_expl[0], $time_expl[1], 0, $date_expl[1], $date_expl[2], $date_expl[0]);

        }

        if ($Flight_Time > $DateOneMonth) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function TrackingInfo($param)
    {

        $_POST = $param;
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $sql = " SELECT * FROM book_local_tb WHERE  
            (request_number = '{$_POST['request_number']}' OR pnr = '{$_POST['request_number']}' OR factor_number = '{$_POST['request_number']}') 
            AND (request_number > 0 OR request_number<>'')";

        $res = $Model->load($sql);

        if ($res['successfull'] == 'book') {
            $status = functions::Xmlinformation("Definitivereservation");
        } else if ($res['successfull'] == 'prereserve') {
            $status = functions::Xmlinformation("Prereservation");
        } else if ($res['successfull'] == 'bank') {
            $status = functions::Xmlinformation("NavigateToPort");
        } else if ($res['successfull'] == 'nothing') {
            $status = functions::Xmlinformation("Unknow");
        }elseif ($res['successfull'] == 'processing') {
            $status = functions::Xmlinformation('processingPrintFlight');
        }elseif ($res['successfull'] == 'pending') {
            $status = functions::Xmlinformation('pendingPrintFlight');
        }

        if ($res['request_cancel'] == 'none') {
            $class = ' btn btn-warning fa fa-times';
        } else if ($res['request_cancel'] == 'request_user' || $res['request_cancel'] == 'request_admin') {
            $class = ' btn btn-warning fa fa-refresh';
        } else if ($res['request_cancel'] == 'confirm') {
            $class = 'btn btn-success fa fa-check';
        }

        if ($res['request_cancel'] == 'request_user' || $res['request_cancel'] == 'request_admin') {
            $title = functions::Xmlinformation("RequestBeingReviewed");
        } else if ($res['request_cancel'] == 'confirm') {
            $title = functions::Xmlinformation("CancellationRequestAccepted");
        }

        $href = ROOT_ADDRESS . "/eticketLocal&num={$res['request_number']}";
        if ($res['IsInternal'] == '1') {
            $href2 = ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=parvazBookingLocal&id={$res['request_number']}";
        } else {
            $href2 = ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=ticketForeign&id={$res['request_number']}";
        }
        if ($res['successfull'] == 'book') {

            $op = "  <a href='{$href2}' class='btn btn-info fa fa-file-pdf-o margin-10'  target='_blank' title='" . functions::Xmlinformation("ViewPDFTickets") . "'></a>";
            $op .= '<a title="' . functions::Xmlinformation("ViewDetails") . '" onclick="ModalUserList(' . "'flight'" . ',' . "'" . $res['request_number'] . "'" . '); return false;"  class="btn btn-primary fa fa-eye"></a>';

        }

        if ($res['type_app'] != 'reservation' && $res['successfull'] == 'book' && Session::IsLogin()){

            $op .= '<a id="cancelbyuser"  title="' . functions::Xmlinformation("CancelFlight") . '" onclick="ModalCancelUser(' . "'flight'" . ',' . "'" . $res['request_number'] . "'" . '); return false;"  class="btn btn-danger fa fa-times"></a>';
        }

        $result = "" ;
        if (!empty($res)) {
            $CancellationFeeSettingController = Load::controller('cancellationFeeSetting');
            $CalculateIndemnity = $CancellationFeeSettingController->CalculateIndemnity($res['request_number']);

            $resBooks = $Model->select($sql);
            list($totalPrice, $fare) = functions::TotalPriceCancelTicketSystem($resBooks);
            if (is_numeric($CalculateIndemnity)) {
                $dataResultBook['PercentIndemnity'] = $CalculateIndemnity ;
                $dataResultBook['pid_private'] = $res['pid_private'] ;
                $PricePenalty = functions::CalculatePenaltyPriceCancel($totalPrice, $fare, $dataResultBook);
                $CalculateIndemnityFinal = $CalculateIndemnity . ' ' . functions::Xmlinformation("Percentagepenalty");
            } else {
                $CalculateIndemnityFinal = '--';
                $PricePenalty = '--';
            }

            $typeFlight = (strtolower($res['flight_type']) == 'system') ? 'سیستمی' : 'چارتری';


            $this->request_number = $res['request_number'];

            $result = '
                  <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title">
                        <i class="icon-table"></i><h3>' . functions::Xmlinformation("Yourpurchase") . ' ' . functions::Xmlinformation("On") . ' ' . functions::Xmlinformation("Numberreservation") . '' . $res['request_number'] . ' <br/> ' . functions::Xmlinformation("Indate") . ' ' . dateTimeSetting::jdate('Y-m-d H:i:s', $res['creation_date_int']) . '</h3>
                    </div>
                    
            <table class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>' . functions::Xmlinformation("Origin") . '<br/>' . functions::Xmlinformation("Destination") . '</th>
                        <th>' . functions::Xmlinformation("RunTime") . '<br/>' . functions::Xmlinformation("Date") . '</th>
                        <th>' . functions::Xmlinformation("PnrCode") . '</th>
                        <th>' . functions::Xmlinformation("Namepassenger") . '</th>
                        <th>' . functions::Xmlinformation("Airline") . '<br/>' . functions::Xmlinformation("Typeflight") . '</th>
                        <th>' . functions::Xmlinformation("Numflight") . '<br/>' . functions::Xmlinformation("WithRateID") . '</th>
                        <th>' . functions::Xmlinformation("Percentagepenalty") . '</th>
                        <th>' . functions::Xmlinformation("Amount") . '<br/>' . functions::Xmlinformation("RefundAmount") . '</th>
                        <th>' . functions::Xmlinformation("Status") . '</th>
                        <th>' . functions::Xmlinformation("Action") . '</th>
                    </tr>
                </thead>
                <tbody>
            ';
            $name  = $res['passenger_name'] ? $res['passenger_name'] : $res['passenger_name_en'];
            $family  = $res['passenger_family'] ? $res['passenger_family'] : $res['passenger_family_en'];
            $result .= '<td>' . $res['origin_city'] . '<br/>' . $res['desti_city'] . '</td><td>' . $this->DateJalali($res['date_flight']) . ' <br/>' . $this->format_hour($res['time_flight']) . '</td><td>' . $res['pnr'] . '</td><td>' . $name . ' ' . $family . '</td><td>' . $res['airline_name'] . '<br/>' . $typeFlight . '</td><td>' . $res['flight_number'] . '<br/>' . $res['cabin_type'] . '</td><td>' . number_format(round($CalculateIndemnityFinal)) . '</td><td>' . number_format($totalPrice) . ' ' . functions::Xmlinformation("Rial") . '<br/>' . number_format(round($PricePenalty)) . ' ' . functions::Xmlinformation("Rial") . '</td><td>' . $status . '</td><td>' . $op . '</td>';
            $result .= '</table>';

        }

        return $result;

    }

    public function redirectOut()
    {

        header('Location: loginUser');
    }

    public function total_price($RequestNumber)
    {
        Load::autoload('apiLocal');
        $Model = new apiLocal();

        list($amount,$fare) = $Model->get_total_ticket_price($RequestNumber, 'yes');

        return array($amount,$fare);
    }

    public function agency_com($req_number)
    {
        if (TYPE_ADMIN == '1') {
            Load::autoload('ModelBase');
            $ModelBase = new ModelBase();

            $sql = " SELECT SUM(agency_commission) AS agency_commission FROM report_tb WHERE request_number='{$req_number}'";
            $res = $ModelBase->load($sql);
        } else {
            Load::autoload('Model');
            $Model = new Modele();
        }

        return $res['agency_commission'];
    }

    public function namebank($bank_dir = null, $client_id)
    {

        if ($bank_dir != null && !empty($bank_dir)) {
            if (!empty($client_id)) {
                $admin = Load::controller('admin');

                $sql = " SELECT * FROM bank_tb WHERE bank_dir='{$bank_dir}'";

                $Bank = $admin->ConectDbClient($sql, $client_id, "Select", "", "", "");

                return $Bank['title'];
            }
        } else {
            return 'ندارد';
        }
    }

    public function numberPortBnak($bank_dir = null, $client_id)
    {

        if ($bank_dir != null && !empty($bank_dir)) {
            if (!empty($client_id)) {
                $admin = Load::controller('admin');

                $sql = " SELECT * FROM bank_tb WHERE bank_dir='{$bank_dir}'";
                $Bank = $admin->ConectDbClient($sql, $client_id, "Select", "", "", "");

                return $Bank['param1'];
            }
        } else {
            return 'ندارد';
        }
    }

    public function nameAgency($client_id)
    {


        if (!empty($client_id)) {

            Load::autoload('ModelBase');
            $ModelBase = new ModelBase();

            $sql = " SELECT * FROM clients_tb WHERE id='{$client_id}'";
            $res = $ModelBase->load($sql);

            return $res['AgencyName'];
        } else {
            return 'ندارد';
        }
    }

    public function changeFlagBuyPrivate($param)
    {
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();
        $data['is_done_private'] = '2';

        $Condition = " request_number='{$param['RequestNumber']}'";
        $ModelBase->setTable('report_tb');
        $res = $ModelBase->update($data, $Condition);

        if ($res) {
            return "success";
        } else {
            return "error";
        }
    }

    public function changeFlagBuyPublicSystem($param)
    {
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();
        $data['public_stsyem_status'] = '1';

        $Condition = " request_number='{$param['RequestNumber']}'";
        $ModelBase->setTable('report_tb');
        $res = $ModelBase->update($data, $Condition);

        if ($res) {
            return "success";
        } else {
            return "error";
        }
    }

    public function changeFlagBuyPrivateToPublic($param)
    {


        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();
        $data['is_done_private'] = '0';

        $Condition = " request_number='{$param['RequestNumber']}'";
        $ModelBase->setTable('report_tb');
        $res = $ModelBase->update($data, $Condition);

        if ($res) {
            return "success";
        } else {
            return "error";
        }
    }

    public function done_private($RequestNumber)
    {

        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $sql = " SELECT * FROM report_tb WHERE request_number ='{$RequestNumber}'";

        $result = $ModelBase->load($sql);

        if (!empty($result)) {

            $data['is_done_private'] = '1';

            $ModelBase->setTable('report_tb');

            $Condition = " request_number ='{$RequestNumber}'";

            $ResUpdate = $ModelBase->update($data, $Condition);

            if ($ResUpdate) {
                return " success : درخواست شما با موفقیت ثبت شد";
            } else {
                return " error : درخواست شما با خطا مواجه شده ،لطفا مجددا انجام دهید";
            }

        } else {

            return "error : درخواست نامعتبر است،سوابقی پیدا نشد";
        }

    }

    public function ShowLogBuyTicket()
    {
        $BookShow = array();

        $ModelBase = Load::library('ModelBase');
        $Model = Load::library('Model');

        $jdate = dateTimeSetting::jdate("Y/m/d", time());
        $ex = explode("/", $jdate);
        for ($i = 11; $i >= 0; $i--) {
            $Timenow = dateTimeSetting::jmktime(0, 0, 0, $ex[1], $ex[2], $ex[0]) - (($i) * (24 * 60 * 60));

            $CalculateTimeUnix = dateTimeSetting::jmktime(23, 59, 59, $ex[1], $ex[2], $ex[0]);
            $TimeCalc = $CalculateTimeUnix - (($i) * (24 * 60 * 60));
            if (TYPE_ADMIN == '1') {

                $sql = " SELECT COUNT(request_number) AS reqNumber FROM report_tb WHERE (successfull='book' OR successfull='private_reserve') AND creation_date_int >= $Timenow AND creation_date_int < $TimeCalc ";
                $BookShow[] = $ModelBase->load($sql);

            } else {
                $sql = " SELECT COUNT(request_number) AS reqNumber FROM book_local_tb WHERE successfull='book' AND creation_date_int >= $Timenow AND creation_date_int < $TimeCalc ";
                $BookShow[] = $Model->load($sql);
            }

        }

        return $BookShow;
    }

    public function createPdfContent($param, $cash)
    {

        $resultLocal = Load::controller('resultLocal');

        if (TYPE_ADMIN == '1') {
            $ModelBase = Load::library('ModelBase');
            $sql = "select * from report_tb where (request_number='{$param}' OR factor_number='{$param}') AND (successfull='book' OR successfull='private_reserve')";
            $info_ticket = $ModelBase->select($sql);
        } else {
            $book_local_model = Load::model('book_local');
            $info_ticket = $book_local_model->getTicketInfo($param);
        }

        $gender = '';
        $genderEn = '';
        $airplan = '';

        $PrintTicket = '';

        if (!empty($info_ticket)) {


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

            foreach ($info_ticket as $info) {
                if ($info['passenger_age'] == "Adt") {
                    $infoAge = 'Adult';
                } else if ($info['passenger_age'] == 'Chd') {
                    $infoAge = 'Child';
                } else if ($info['passenger_age'] == 'Inf') {
                    $infoAge = 'Infant';
                }
                if ($info['passenger_gender'] == 'Male') {
                    $gender = ' آقای';
                    $genderEn = 'Mr';
                } else if ($info['passenger_gender'] == 'Female') {
                    $gender = ' خانم';
                    $genderEn = 'Ms';
                }

                if ($info['flight_type'] == '' || $info['flight_type'] == 'charter') {
                    $flight_type = 'Charter';
                } else if ($info['flight_type'] == 'system') {
                    $flight_type = 'schedule';
                }

                if ($info['seat_class'] == 'C') {
                    $seat_class = 'business';
                } else {
                    $seat_class = 'Economics';
                }

                $Price = '0';
                if (functions::TypeUser($info['member_id']) == 'Ponline') {
                    $Price = functions::CalculateDiscountOnePerson($info['request_number'], ($info['passenger_national_code'] == '0000000000' || $info['passenger_national_code'] == '' ? $info['passportNumber'] : $info['passenger_national_code']), 'yes');
                } else if (functions::TypeUser($info['member_id']) == 'Counter') {
                    $Price = functions::CalculateForOnePersonWithOutDiscount($info['request_number'], ($info['passenger_national_code'] == '0000000000' || $info['passenger_national_code'] == '' ? $info['passportNumber'] : $info['passenger_national_code']), 'yes');

                }

                $Price += $info['amount_added'];
                $LogoAgency = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_LOGO;
                $StampAgency = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_STAMP;
                $picAirline = functions::getAirlinePhoto($info['airline_iata']);
                $airlineName = functions::InfoAirline($info['airline_iata']);;
                $airplan = 'http://online.indobare.com/gds/view/client/assets/images/air-return.png';
                $depEn = functions::InfoRoute($info['origin_airport_iata']);
                $DestEn = functions::InfoRoute($info['desti_airport_iata']);
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
                         <td width="30%"  style="width: 30%; text-align: center; padding-bottom: 5px; " valign="bottom">
                         
                         <table>
                             <tr>
                                 <td >
                                 <img src="' . $LogoAgency . '" style="float:left;width: 100px">
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
                $PrintTicket .= '<span>' . functions::country_code(($info['passportCountry'] != 'IRN' && $info['passportCountry'] != '' ? $info['passportCountry'] : 'IRN'), 'en') . '</span> ';
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


                $PrintTicket .= !empty($info['pnr']) ? '<span style="font-size: 11px;  color:#006cb5;">PNR</span>' : '';
                $PrintTicket .= '<span style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> ';
                $PrintTicket .= '<span>' . !empty($info['pnr']) ? $info['pnr'] : '' . '</span> ';
                $PrintTicket .= '</td>
                                                        </tr>
                                                        <tr style="border-bottom: 1px solid #CCC">
                                                           <td width="220"  align="left"   height="50" style="padding-left: 5px">';



                $PrintTicket .= '<span style="font-size: 11px;  color:#006cb5;">Price</span> ';
                $PrintTicket .= '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> ';
                if ($cash == 'no') {

                    $PrintTicket .= '<span style="float: right ; position: relative; right: 0;">Cash</span> ';

                }else{
                    $PrintTicket .= '<span>' . number_format($Price) . ' IRR</span> ';
                }
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
                $PrintTicket .= $resultLocal->format_hour_arrival($info['origin_airport_iata'], $info['desti_airport_iata'], $info['time_flight']);

                $PrintTicket .= '</td>
                                                                            <td width="50" align="center" valign="middle">
                                                                                -
                                                                            </td>
                                                                            <td width="200" height="70" align="center" valign="middle" style="font-size: 25px">';
                $PrintTicket .= $resultLocal->format_hour($info['time_flight']);
                $PrintTicket .= '</td>
                                                                             </tr>
                                                                             <tr>
                                                                                <td colspan="3" height="70" align="center" valign="middle" style="font-size: 25px">';

                $PrintTicket .= functions::convertDateFlight($info['date_flight']);
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
                                                              
                                                              
                                                              ';


                $check_client_configuration = functions::checkClientConfigurationAccess('show_flight_pdf_date', CLIENT_ID);
                if ($check_client_configuration) {


                    $PrintTicket .= '<tr><td>
                                                                   <table width="450" cellpadding="0" cellspacing="0" class="page" border="0">
                                                                        <tr >
                                                                   
                                                                            <td width="50%" align="center" valign="middle" style="font-size: 20px;border-top: 1px solid #CCC;"> <span style="font-size: 11px;  color:#006cb5;">Submited At</span> : ' . functions::printDateIntByLanguage("Y-m-d (H:i)", $info['creation_date_int'], "en") . ' </td>
                                                                         </tr>
                                                                    </table>
                                                                 </td>
                                                              </tr>';

                }




                $PrintTicket.='</table>
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
                $PrintTicket .= !empty($info['eticket_number']) ? '<span style="float: left; font-size: 11px;  color:#006cb5 ;text-align: left">FLIGHT NO</span>' : '';;
                $PrintTicket .= '<span style="float: right ;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> ';
                $PrintTicket .= '<span style="float: right;">' . !empty($info['eticket_number']) ? $info['eticket_number'] : '' . '</span>';
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
                                    </ul>
                                
                                </td>
                           
                            </tr>
                   
                    </table>
                </div>';



                $PrintTicket.='
                <div style="margin: 550px 950px 0px 100px ; width: 90%">';
                if($StampAgency != ROOT_ADDRESS_WITHOUT_LANG.'/pic/'){
                    $PrintTicket.='<img src="'.$StampAgency.'" height="100" style="max-width: 230px;">';}
                $PrintTicket.='</div>
                <hr style="margin: 30px 100px 0px 100px ; width: 90%"/>
               
                <table width="100%" align="center" style="margin: 30px 100px 50px 100px ; font-size: 20px"  scellpadding="0" cellspacing="0"  >
                
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
                $PrintTicket .=
                    '
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

    public function TicketHistoryCounter($id)
    {
        $Model = Load::library('Model');

//		$Sql = "SELECT * FROM book_local_tb WHERE successfull='book'  AND request_cancel <> 'confirm' AND member_id='{$id}' GROUP BY request_number ORDER BY  creation_date_int DESC";


        $sql="SELECT
                ( SELECT count( id ) FROM book_local_tb WHERE successfull = 'book' AND request_cancel <> 'confirm' AND member_id = '{$id}' ) AS book_local,
                ( SELECT count( id ) FROM book_bus_tb WHERE STATUS = 'book' AND request_cancel <> 'confirm' AND member_id = '{$id}' ) AS book_bus,
                ( SELECT count( id ) FROM book_entertainment_tb WHERE successfull = 'book' AND request_cancel <> 'confirm' AND member_id = '{$id}' ) AS book_entertainment,
                ( SELECT count( id ) FROM book_hotel_local_tb WHERE STATUS = 'book' AND member_id = '{$id}' ) AS book_hotel_local,
                ( SELECT count( id ) FROM book_insurance_tb WHERE STATUS = 'book' AND member_id = '{$id}' ) AS book_insurance,
                ( SELECT count( id ) FROM book_tour_local_tb WHERE STATUS = 'book' AND cancel_status <> 'SuccessfullyCancel' AND member_id = '{$id}' ) AS book_tour_local,
                ( SELECT count( id ) FROM book_train_tb WHERE successfull = 'book' AND request_cancel <> 'confirm' AND member_id = '{$id}' ) AS book_train,
                ( SELECT count( id ) FROM book_visa_tb WHERE STATUS = 'book' AND member_id = '{$id}' ) AS book_visa,
                (
            SELECT
                SUM( book_local + book_bus + book_entertainment + book_hotel_local + book_insurance + book_tour_local + book_train + book_visa )) AS sumAll";

        $rec = $Model->select($sql);

        $this->CountTicketCounter = count($rec);

        return $rec;
    }

    #endregion

    public function PassengerTicketHistory($Code, $AgencyId = null)
    {
        $Model = Load::library('Model');

        $Sql = "SELECT * FROM book_local_tb WHERE successfull='book'  AND (passenger_national_code='{$Code}' OR passportNumber='{$Code}')  ";

        if (empty($AgencyId)) {
            $AgencyId = Session::getAgencyId();
            $Sql .= "AND agency_id='{$AgencyId}'";
        } else {
            $Sql .= "AND agency_id='{$AgencyId}'";
        }

        $Sql .= "GROUP BY request_number ORDER BY  creation_date_int ASC";
        $rec = $Model->select($Sql);

        $this->CountTicketCounter = count($rec);

        return $rec;
    }

    public function preReserveBuy($Param)
    {
        $admin = Load::controller('admin');
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $SqlReport = "SELECT * FROM report_tb WHERE request_number='{$Param['RequestNumber']}'";
        $ResultReport = $ModelBase->select($SqlReport);

        $SqlBook = "SELECT * FROM book_local_tb WHERE request_number='{$Param['RequestNumber']}'";
        $ResultBook = $admin->ConectDbClient($SqlBook, $Param['ClientID'], "SelectAll", "", "", "");

        if (!empty($ResultReport) && !empty($ResultBook)) {

            //update book_local_tb
            $data['successfull'] = 'prereserve';
            $resultUpdateBook = $admin->ConectDbClient("", $Param['ClientID'], "Update", $data, "book_local_tb", "request_number='{$Param['RequestNumber']}'");

            //update report_tb
            $ConditionUpdateReport = "request_number='{$Param['RequestNumber']}'";
            $ModelBase->setTable('report_tb');
            $resultUpdateReport = $ModelBase->update($data, $ConditionUpdateReport);

            //delete counter credit if exists
            $admin->ConectDbClient("", $Param['ClientID'], "Delete", '', "credit_detail_tb", "requestNumber='{$Param['RequestNumber']}' AND type='decrease'");

            //delete transaction
            $SqlMultiWay = "SELECT COUNT(DISTINCT direction) AS multiway FROM book_local_tb WHERE factor_number='{$Param['FactorNumber']}'";
            $ResultMultiWay = $admin->ConectDbClient($SqlMultiWay, $Param['ClientID'], "Select", "", "", "");
            if ($ResultMultiWay['multiway'] == 1) {
                $Transaction['PaymentStatus'] = 'pending' ;
                $deleteTransaction = $admin->ConectDbClient("", $Param['ClientID'], "Update", $Transaction, "transaction_tb", "FactorNumber='{$Param['FactorNumber']}'");

                //for admin panel , transaction table
                $condition = "FactorNumber='{$Param['FactorNumber']}'";
                $Transaction['ClientID'] = $Param['ClientID'];
                $this->transactions->updateTransaction($Transaction, $condition);



            } else {
                $SqlDept = "SELECT  *, 
                SUM(adt_price+chd_price+inf_price) AS totalPrice,
                SUM(api_commission) AS totalApiCommission,
                (SELECT COUNT(id) FROM book_local_tb WHERE factor_number = '{$Param['FactorNumber']}' AND direction = 'dept') AS count_id
                FROM book_local_tb WHERE factor_number = '{$Param['FactorNumber']}' AND direction = 'dept'";
                $ResultDept = $admin->ConectDbClient($SqlDept, $Param['ClientID'], "Select", "", "", "");

                $isInternal = ($ResultDept['isInternal'] == '1') ? 'internal' : 'external';
                $check_private = functions::checkConfigPid($ResultDept['airline_iata'], $isInternal, $ResultDept['flight_type'],$ResultDept['api_id'], $Param['ClientID']);
                if (($check_private == 'public') || ($check_private == 'private' && $ResultDept['flight_type'] == 'charter')) {

                    if ($ResultDept['flight_type'] == 'system') {
                        $Price = $ResultDept['totalPrice'] - (functions::percentPublic() * $ResultDept['totalPrice']);
                    } else {
                        $Price = $ResultDept['totalPrice'] + $ResultDept['totalApiCommission'];
                    }

                } else {
                    $Price = 0;
                }

                if ($ResultDept['flight_type'] == 'system') {
                    if ($check_private == 'public') {
                        $type = ' سیستمی پید اشتراکی ';
                    } else {
                        $type = ' سیستمی پید اختصاصی ';
                    }
                } else {
                    $type = ' چارتری ';
                }

                $data['Price'] = $Price;
                $data['Comment'] = "خرید" . " " . $ResultDept['count_id'] . " عدد بلیط هواپیما از" . " " . $ResultDept['origin_city'] . " به" . " " . $ResultDept['desti_city'] . " به شماره رزرو " . $ResultDept['request_number'] . $type;
                $deleteTransaction = $admin->ConectDbClient("", $Param['ClientID'], "Update", $data, "transaction_tb", "FactorNumber='{$Param['FactorNumber']}'");

                //for admin panel , transaction table
                $condition = "FactorNumber='{$Param['FactorNumber']}'";
                $data['ClientID'] = $Param['ClientID'];
                $this->transactions->updateTransaction($data, $condition);
            }

            if ($resultUpdateReport && $resultUpdateBook && $deleteTransaction) {
                return 'success : عملیات با موفقیت انجام شد';

            } else if (!$resultUpdateReport && $resultUpdateBook && $deleteTransaction) {
                return 'error: خطا در آپدیت جدول مادر';
            } else if ($resultUpdateReport && !$resultUpdateBook && $deleteTransaction) {
                return 'error: خطا در آپدیت جدول مشتری';
            } else if ($resultUpdateReport && $resultUpdateBook && !$deleteTransaction) {
                return 'error: خطا در حذف تراکنش مشتری';
            } else if (!$resultUpdateReport && !$resultUpdateBook && !$deleteTransaction) {
                return 'error: خطا سه بخشی';
            }

        } else {
            return 'error : درخواست شما معتبر نمی باشد';
        }

    }

    public function CountTypeTicketCharter()
    {
        $ModelBase = Load::library('ModelBase');

        $jdate = dateTimeSetting::jdate("Y/m/d", time());
        $ex = explode("/", $jdate);

        for ($i = 11; $i >= 0; $i--) {
            $Timenow = dateTimeSetting::jmktime(0, 0, 0, $ex[1], $ex[2], $ex[0]) - (($i) * (24 * 60 * 60));
            $CalculateTimeUnix = dateTimeSetting::jmktime(23, 59, 59, $ex[1], $ex[2], $ex[0]);
            $TimeCalc = $CalculateTimeUnix - (($i) * (24 * 60 * 60));

            $Sql = "SELECT COUNT(request_number) AS CountCharter , creation_date_int FROM report_tb WHERE (successfull='book' OR successfull='private_reserve') AND flight_type = 'charter'  AND  creation_date_int >= $Timenow AND creation_date_int < $TimeCalc";
            $Log[] = $ModelBase->load($Sql);

        }

        return $Log;

//        echo Load::plog($Log);
    }

    public function CountTypeTicketSystemPublic()
    {
        $ModelBase = Load::library('ModelBase');

        $jdate = dateTimeSetting::jdate("Y/m/d", time());
        $ex = explode("/", $jdate);

        for ($i = 11; $i >= 0; $i--) {
            $Timenow = dateTimeSetting::jmktime(0, 0, 0, $ex[1], $ex[2], $ex[0]) - (($i) * (24 * 60 * 60));
            $CalculateTimeUnix = dateTimeSetting::jmktime(23, 59, 59, $ex[1], $ex[2], $ex[0]);
            $TimeCalc = $CalculateTimeUnix - (($i) * (24 * 60 * 60));

            $Sql = "SELECT COUNT(request_number) AS CountPublicSystem FROM report_tb WHERE (successfull='book' OR successfull='private_reserve') AND flight_type = 'system' AND pid_private='0' AND  creation_date_int >= $Timenow AND creation_date_int < $TimeCalc";
            $Log[] = $ModelBase->load($Sql);
        }

        return $Log;
    }

    public function CountTypeTicketSystemPrivate()
    {
        $ModelBase = Load::library('ModelBase');

        $jdate = dateTimeSetting::jdate("Y/m/d", time());
        $ex = explode("/", $jdate);

        for ($i = 11; $i >= 0; $i--) {
            $Timenow = dateTimeSetting::jmktime(0, 0, 0, $ex[1], $ex[2], $ex[0]) - (($i) * (24 * 60 * 60));
            $CalculateTimeUnix = dateTimeSetting::jmktime(23, 59, 59, $ex[1], $ex[2], $ex[0]);
            $TimeCalc = $CalculateTimeUnix - (($i) * (24 * 60 * 60));


            $Sql = "SELECT COUNT(request_number) AS CountPrivateSystem FROM report_tb WHERE (successfull='book' OR successfull='private_reserve') AND flight_type = 'system' AND pid_private='1' AND  creation_date_int >= $Timenow AND creation_date_int < $TimeCalc";
            $Log[] = $ModelBase->load($Sql);

        }

        return $Log;
    }

    public function ShowInfoTicketForInsertPnr($RequestNumber, $ClientId)
    {

        $admin = Load::controller('admin');

        $Sql = "SELECT * FROM book_local_tb WHERE request_number = '{$RequestNumber}'";

        $TicketInfo = $admin->ConectDbClient($Sql, $ClientId, "SelectAll", "", "", "");

        return $TicketInfo;

    }
    public function UpdatePassengerInfo($data)
    {
        $admin     = Load::controller('admin');
        $ModelBase = Load::library('ModelBase');

        $report    = '';
        $bookLocal = '';

        // پیدا کردن رکورد پرواز در دیتابیس مادر
        $SQL    = "SELECT * FROM report_tb WHERE request_number='{$data['RequestNumber']}'";
        $Client = $ModelBase->load($SQL);

        error_log(
            'try UpdatePassengerInfo at: ' . date('Y/m/d H:i:s') .
            " data => " . json_encode($data, true) . " \n",
            3,
            LOGS_DIR . 'UpdatePassengerInfo.txt'
        );

        if (!empty($Client)) {
            // تاریخ و ساعت ورودی کاربر
            $flightDate = $data['flight_date'];
            $flightTime = trim($data['flight_time']);

            // چک تاریخ معتبر
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $flightDate)) {
                echo 'Error : فرمت تاریخ پرواز صحیح نیست (yyyy-mm-dd)';
                return;
            }
            list($y, $m, $d) = explode('-', $flightDate);
            if (!checkdate(intval($m), intval($d), intval($y))) {
                echo 'Error : تاریخ پرواز نامعتبر است';
                return;
            }
            // چک ساعت معتبر
            if (!preg_match('/^(2[0-3]|[01]?[0-9]):([0-5][0-9])$/', $flightTime)) {
                echo 'Error : فرمت ساعت پرواز صحیح نیست (HH:ii)';
                return;
            }

            // تشخیص فرمت ذخیره‌سازی در دیتابیس
            $dbDate = $Client['date_flight'];

            if (strpos($dbDate, 'T') !== false) {
                // دیتابیس تاریخ + ساعت می‌خواد
                $finalDate = $flightDate . 'T' . $flightTime . ':00';
            } else {
                // دیتابیس فقط تاریخ داره
                $finalDate = $flightDate;
            }

            // داده نهایی
            $data['flight_date'] = $finalDate;
            $data['flight_time'] = $flightTime. ':00';

            foreach ($data['passengerNameFa'] as $i => $result) {
                $dataPassenger = [];

                // نام و نام خانوادگی فارسی
                $dataPassenger['passenger_name']   = $data['passengerNameFa'][$i];
                $dataPassenger['passenger_family'] = $data['passengerFamilyFa'][$i];

                // نام و نام خانوادگی انگلیسی
                $dataPassenger['passenger_name_en']   = $data['passengerNameEn'][$i];
                $dataPassenger['passenger_family_en'] = $data['passengerFamilyEn'][$i];

                // اطلاعات پرواز
                $dataPassenger['airline_iata']   = $data['airline_iata'];
                $dataPassenger['airline_name']   = $data['airline_name'];
                $dataPassenger['time_flight']    = $data['flight_time']; // همون‌جوری که هست ذخیره شه
                $dataPassenger['date_flight']    = $data['flight_date']; // تاریخ پرواز

                $ClientID = $data['ClientID'];

                // شرط آپدیت
                $passenger_national_code = $data['nationalCode'][$i];
                $Condition = "request_number='{$data['RequestNumber']}' 
                      AND (passportNumber='{$passenger_national_code}' 
                      OR passenger_national_code='{$passenger_national_code}')";
                $Condition2=$Condition." AND client_id='{$ClientID}' ";

                // دیتابیس مادر
                $ModelBase->setTable('report_tb');
                $report = $ModelBase->update($dataPassenger,$Condition2);

                // دیتابیس مشتری
                $bookLocal = $admin->ConectDbClient("", $ClientID, "Update", $dataPassenger, "book_local_tb", $Condition);
            }

            if ($report && $bookLocal) {
                echo 'Success : اطلاعات مسافران با موفقیت ویرایش شد';
            } else {
                echo 'Error : خطا در ویرایش اطلاعات';
            }
        } else {
            echo 'Error : پروازی با این RequestNumber یافت نشد';
        }
    }


    public function InsertPnrToDB($data)
    {

        $admin = Load::controller('admin');
        $ModelBase = Load::library('ModelBase');

        $report = '';
        $bookLocal = '';
        $SQl = "SELECT * FROM report_tb WHERE request_Number='{$data['RequestNumber']}'";
        $Client = $ModelBase->load($SQl);

        error_log('try show result method PnrOfAdmin in : ' . date('Y/m/d H:i:s') . '  array eqaul in => : ' . json_encode($data, true) . " \n", 3, LOGS_DIR . 'PnrOfAdmin.txt');


        if (!empty($Client)) {
            foreach ($data['nationalCode'] as $i => $result) {
                $dataPnr['pnr'] = $data['pnr'];
                if (!empty($data['airline_iata'])) {
                    $dataPnr['airline_iata'] = $data['airline_iata'];
                }

                if (!empty($data['airline_name'])) {
                    $dataPnr['airline_name'] = $data['airline_name'];
                }

                if (!empty($data['flight_number'])) {
                    $dataPnr['flight_number'] = $data['flight_number'];
                }
                if (!empty($data['seat_class'])) {
                    $dataPnr['seat_class'] = $data['seat_class'];
                }

                if (!empty($data['time_flight'])) {
                    $dataPnr['time_flight'] = $data['time_flight'];
                }
                $dataPnr['eticket_number'] = $data['eTicketNumber'][$i];
                $dataPnr['private_m4'] = '3';
                $ClientID = $data['ClientID'];

                $passenger_national_code = $result;

                $Condition = "request_number='{$data['RequestNumber']}' AND (passportNumber='{$passenger_national_code}' OR passenger_national_code='{$passenger_national_code}')";

                $ModelBase->setTable('report_tb');
                $report = $ModelBase->update($dataPnr, $Condition);

                $bookLocal = $admin->ConectDbClient("", $ClientID, "Update", $dataPnr, "book_local_tb", $Condition);


            }

            if ($report && $bookLocal) {
                $this->FlightConvertToBook($data);
                echo 'Success : عملیات با موفقیت انجام شد';
            } else {
                echo 'Error : خطا در انجام عملیات';
            }
        } else {
            echo 'خطا در ثبت اطلاعات';
        }


    }


    public function ShowHotelInfoInsertPnr($RequestNumber, $ClientId)
    {

        $admin = Load::controller('admin');

        $Sql = "SELECT * FROM book_hotel_local_tb WHERE request_number = '{$RequestNumber}'";

        return $admin->ConectDbClient($Sql, $ClientId, "SelectAll", "", "", "");


    }

    public function ShowPendingHotelByFactorNumber($factor_number, $ClientId)
    {

        $admin = Load::controller('admin');

        $Sql = "SELECT * FROM book_hotel_local_tb WHERE factor_number = '{$factor_number} AND status = 'pending'";

        return $admin->ConectDbClient($Sql, $ClientId, "SelectAll", "", "", "");


    }

    public function FlightConvertToBook($data)
    {

        $admin = Load::controller('admin');
        $ModelBase = Load::library('ModelBase');

        $report = '';
        $bookLocal = '';
        $SQl = "SELECT * FROM report_tb WHERE request_number='{$data['RequestNumber']}'";
        $Flight = $ModelBase->load($SQl);


        error_log('try show result method PnrOfAdmin in : ' . date('Y/m/d H:i:s') . '  array eqaul in => : ' . json_encode($data, true) . " \n", 3, LOGS_DIR . 'PnrOfAdmin.txt');


        if (!empty($Flight)) {
            foreach ($data['nationalCode'] as $i => $result) {
                $ClientID = $data['ClientID'];
                $dataToBook['payment_type'] = ($Flight['successfull'] == 'bank') ? 'cash' : 'credit';
                $dataToBook['successfull'] = 'book';
                $passenger_national_code = $result;

                $Condition = "request_number='{$data['RequestNumber']}' AND (passportNumber='{$passenger_national_code}' OR passenger_national_code='{$passenger_national_code}')";
                $bookLocal = $admin->ConectDbClient("", $ClientID, "Update", $dataToBook, "book_local_tb", $Condition);

                $dataToBook['successfull'] = ($Flight['pid_private'] == '1') ? 'private_reserve' : 'book';
                $ModelBase->setTable('report_tb');
                $report = $ModelBase->update($dataToBook, $Condition);

            }

            if ($report && $bookLocal) {

                $dataTransaction['PaymentStatus'] = 'success';
                $Condition = "FactorNumber='{$Flight['factor_number']}' ";
                $admin->ConectDbClient("", $ClientID, "Update", $dataTransaction, "transaction_tb", $Condition);

                //for admin panel , transaction table
                $dataTransaction['clientID'] = $ClientID;
                $this->transactions->updateTransaction($dataTransaction, $Condition);

                echo 'Success : عملیات با موفقیت انجام شد';
            } else {
                echo 'Error : خطا در انجام عملیات';
            }
        } else {
            echo 'خطا در ثبت اطلاعات';
        }


    }





    public function ListRTRD()
    {
        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $admin = Load::controller('admin');
        if (TYPE_ADMIN == '1') {
            $ModelBase = Load::library('ModelBase');

            $sql = "SELECT rep.*,cli.AgencyName AS NameAgency"
                . " FROM report_tb as rep"
                . " LEFT JOIN clients_tb AS cli ON cli.id =rep.client_id WHERE (successfull='book' OR  successfull='private_reserve')"
                . " AND flight_type <> 'charterPrivate'";


            if (Session::CheckAgencyPartnerLoginToAdmin()) {
                $sql .= " AND agency_id='{$_SESSION['AgencyId']}' ";

                if (!empty($_POST['CounterId'])) {
                    if ($_POST['CounterId'] != "all") {
                        $sql .= " AND member_id ='{$_POST['CounterId']}'";
                    }
                }
            }


            if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {

                $date_of = explode('-', $_POST['date_of']);
                $date_to = explode('-', $_POST['to_date']);
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
                $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
            } else {

                $sql .= " AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";

            }

            if (!empty($_POST['successfull'])) {
                if ($_POST['successfull'] == 'all') {

                    $sql .= " AND (successfull ='book' OR successfull ='private_reserve')";
                } else if ($_POST['successfull'] == 'book') {
                    $sql .= " AND (successfull ='{$_POST['successfull']}' OR successfull='private_reserve')";
                } else {
                    $sql .= " AND (successfull ='nothing' OR successfull ='credit' OR successfull ='bank' OR successfull ='prereserve' ) ";
                }
            }


            if (!empty($_POST['flight_type'])) {

                if ($_POST['flight_type'] == 'all') {
                    $sql .= " AND (flight_type ='system' OR flight_type ='charter' OR flight_type ='charterPrivate')";
                } else if ($_POST['flight_type'] == 'charterSourceFour') {
                    $sql .= " AND flight_type ='charter' AND api_id='5'";
                } else if ($_POST['flight_type'] == 'charterSourceSeven') {
                    $sql .= " AND flight_type ='charter' AND api_id='8'";
                } else if ($_POST['flight_type'] == 'SystemSourceFour') {
                    $sql .= " AND flight_type ='system' AND api_id='5'";
                } else if ($_POST['flight_type'] == 'SystemSourceFive') {
                    $sql .= " AND flight_type ='system' AND api_id='1'";
                } else if ($_POST['flight_type'] == 'SystemSourceTen') {
                    $sql .= " AND flight_type ='system' AND api_id='11'";
                } else if ($_POST['flight_type'] == 'SystemSourceForeignNine') {
                    $sql .= " AND flight_type ='system' AND api_id='10' AND IsInternal='0'";
                }
            }

            if (!empty($_POST['request_number'])) {
                $sql .= " AND request_number ='{$_POST['request_number']}'";
            }
            if (!empty($_POST['client_id'])) {
                if ($_POST['client_id'] != "all") {
                    $sql .= " AND client_id ='{$_POST['client_id']}'";
                }
            }


            if (!empty($_POST['passenger_name'])) {
                $sql .= " AND (passenger_name LIKE '%{$_POST['passenger_name']}%' OR passenger_family LIKE '%{$_POST['passenger_name']}%')";
            }


            if (!empty($_POST['passenger_national_code'])) {
                $sql .= " AND (passenger_national_code ='{$_POST['passenger_national_code']}')";
            }


            if (!empty($_POST['member_name'])) {
                $sql .= " AND member_name LIKE '%{$_POST['member_name']}%'";
            }
            if (!empty($_POST['payment_type'])) {
                if ($_POST['payment_type'] == 'all') {
                    $sql .= " AND (payment_type != '' OR payment_type != 'nothing')";
                } elseif ($_POST['payment_type'] == 'credit') {
                    $sql .= " AND (payment_type = 'credit' OR payment_type = 'member_credit')";
                } else {
                    $sql .= " AND payment_type ='{$_POST['payment_type']}'";
                }
            }

            if (!empty($_POST['eticket_number'])) {
                $sql .= " AND (eticket_number ='{$_POST['eticket_number']}')";
            }
            if (!empty($_POST['AirlineIata'])) {
                $sql .= " AND (airline_iata ='{$_POST['AirlineIata']}')";
            }


            if (!empty($_POST['DateFlight'])) {
                $xpl = explode('-', $_POST['DateFlight']);

                $FinalDate = dateTimeSetting::jalali_to_gregorian($xpl[0], $xpl[1], $xpl[2], '-');

                $sql .= " AND date_flight Like'%{$FinalDate}%'";
            }

            $sql .= " ORDER BY rep.creation_date_int DESC, rep.id DESC  ";

            $BookShow = $ModelBase->select($sql);

            foreach ($BookShow as $key => $Cancel) {
                $requestNumberCancel = $Cancel['request_number'];

                $SqlCancel = "SELECT RequestNumber AS RequestNumberCancel FROM cancel_ticket_details_tb WHERE RequestNumber='{$requestNumberCancel}' AND (Status <> 'RequestMember' && Status<>'SetCancelClient')";
                $CancelClient = $admin->ConectDbClient($SqlCancel, $Cancel['client_id'], "Select", "", "", "");

                if (!empty($CancelClient)) {
                    $BookShow[$key]['cancel'] = $CancelClient['RequestNumberCancel'];

                } else {
                    $BookShow[$key]['cancel'] = '';
                }

            }

        } else {
            $Model = Load::library('Model');
            $sql = "SELECT *"
                . " FROM book_local_tb WHERE  (successfull='book' OR  successfull='private_reserve')"
                . " AND flight_type <> 'charterPrivate'";

            if (Session::CheckAgencyPartnerLoginToAdmin()) {

                $sql .= " AND agency_id='{$_SESSION['AgencyId']}' ";

                if (!empty($_POST['CounterId'])) {
                    if ($_POST['CounterId'] != "all") {
                        $sql .= " AND member_id ='{$_POST['CounterId']}'";
                    }
                }
            }

            if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {

                $date_of = explode('-', $_POST['date_of']);
                $date_to = explode('-', $_POST['to_date']);
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
                $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
            } else {
                $sql .= "AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";

            }

            if (!empty($_POST['flight_type'])) {

                if ($_POST['flight_type'] == 'all') {
                    $sql .= " AND (flight_type ='system' OR flight_type ='charter' OR flight_type ='charterPrivate')";
                } else if ($_POST['flight_type'] == 'charterSourceFour') {
                    $sql .= " AND flight_type ='charter' AND api_id='5'";
                } else if ($_POST['flight_type'] == 'charterSourceSeven') {
                    $sql .= " AND flight_type ='charter' AND api_id='8'";
                } else if ($_POST['flight_type'] == 'SystemSourceFour') {
                    $sql .= " AND flight_type ='system' AND api_id='5'";
                } else if ($_POST['flight_type'] == 'SystemSourceFive') {
                    $sql .= " AND flight_type ='system' AND api_id='1'";
                } else if ($_POST['flight_type'] == 'SystemSourceTen') {
                    $sql .= " AND flight_type ='system' AND api_id='11'";
                } else if ($_POST['flight_type'] == 'SystemSourceForeignNine') {
                    $sql .= " AND flight_type ='system' AND api_id='10' AND IsInternal='0'";
                }
            }

            if (!empty($_POST['request_number'])) {
                $sql .= " AND request_number ='{$_POST['request_number']}'";
            }


            if (!empty($_POST['passenger_name'])) {
                $sql .= " AND (passenger_name LIKE '%{$_POST['passenger_name']}%' OR passenger_family LIKE '%{$_POST['passenger_name']}%')";
            }


            if (!empty($_POST['passenger_national_code'])) {
                $sql .= " AND (passenger_national_code ='{$_POST['passenger_national_code']}')";
            }


            if (!empty($_POST['member_name'])) {
                $sql .= " AND member_name LIKE '%{$_POST['member_name']}%'";
            }

            if (!empty($_POST['payment_type'])) {
                if ($_POST['payment_type'] == 'all') {
                    $sql .= " AND (payment_type != '' OR payment_type != 'nothing')";
                } elseif ($_POST['payment_type'] == 'credit') {
                    $sql .= " AND (payment_type = 'credit' OR payment_type = 'member_credit')";
                } else {
                    $sql .= " AND payment_type ='{$_POST['payment_type']}'";
                }
            }

            if (!empty($_POST['AirlineIata'])) {
                $sql .= " AND (airline_iata ='{$_POST['AirlineIata']}')";
            }


            if (!empty($_POST['DateFlight'])) {
                $xpl = explode('-', $_POST['DateFlight']);

                $FinalDate = dateTimeSetting::jalali_to_gregorian($xpl[0], $xpl[1], $xpl[2], '-');

                $sql .= " AND date_flight ='{$FinalDate}'";
            }

            $sql .= " ORDER BY creation_date_int DESC, id DESC ";


            $BookShow = $Model->select($sql);

            foreach ($BookShow as $key => $Cancel) {
                $requestNumberCancel = $Cancel['request_number'];

                $SqlCancel = "SELECT RequestNumber AS RequestNumberCancel FROM cancel_ticket_details_tb WHERE RequestNumber='{$requestNumberCancel}' AND (Status <> 'RequestMember' && Status<>'SetCancelClient')";
                $CancelClient = $Model->load($SqlCancel);

                if (!empty($CancelClient)) {
                    $BookShow[$key]['cancel'] = $CancelClient['RequestNumberCancel'];

                } else {
                    $BookShow[$key]['cancel'] = '';
                }

            }
        }


        $this->CountTicket = count($BookShow);

        return $BookShow;
    }


    #region listSourceShare
    public function listSourceShare()
    {
        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);

        $ModelBase = Load::library('ModelBase');
        $admin = Load::controller('admin');

        $sql = "SELECT rep.*, cli.AgencyName AS NameAgency, "
            . " (SELECT COUNT(id) FROM report_tb WHERE factor_number = rep.factor_number) AS eachBookCount"
            . " FROM report_tb as rep"
            . " LEFT JOIN clients_tb AS cli ON cli.id =rep.client_id WHERE (successfull='book' OR  successfull='private_reserve')";

        if (Session::CheckAgencyPartnerLoginToAdmin()) {
            $sql .= " AND agency_id='{$_SESSION['AgencyId']}' ";

            if (!empty($_POST['CounterId'])) {
                if ($_POST['CounterId'] != "all") {
                    $sql .= " AND member_id ='{$_POST['CounterId']}'";
                }
            }
        }

        if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {

            $date_of = explode('-', $_POST['date_of']);
            $date_to = explode('-', $_POST['to_date']);
            $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
            $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        } else {
            $sql .= " AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";
        }

        if (!empty($_POST['request_number'])) {
            $sql .= " AND request_number ='{$_POST['request_number']}'";
        }

        if (!empty($_POST['client_id'])) {
            if ($_POST['client_id'] != "all") {
                $sql .= " AND client_id ='{$_POST['client_id']}'";
            }
        }

        if (!empty($_POST['passenger_name'])) {
            $sql .= " AND (passenger_name LIKE '%{$_POST['passenger_name']}%' OR passenger_family LIKE '%{$_POST['passenger_name']}%')";
        }

        if (!empty($_POST['passenger_national_code'])) {
            $sql .= " AND (passenger_national_code ='{$_POST['passenger_national_code']}')";
        }


        if (!empty($_POST['member_name'])) {
            $sql .= " AND member_name LIKE '%{$_POST['member_name']}%'";
        }

        if (!empty($_POST['payment_type'])) {
            if ($_POST['payment_type'] == 'all') {
                $sql .= " AND (payment_type != '' OR payment_type != 'nothing')";
            } elseif ($_POST['payment_type'] == 'credit') {
                $sql .= " AND (payment_type = 'credit' OR payment_type = 'member_credit')";
            } else {
                $sql .= " AND payment_type ='{$_POST['payment_type']}'";
            }
        }

        if (!empty($_POST['eticket_number'])) {
            $sql .= " AND (eticket_number ='{$_POST['eticket_number']}')";
        }

        if (!empty($_POST['AirlineIata'])) {
            $sql .= " AND (airline_iata ='{$_POST['AirlineIata']}')";
        }

        if (!empty($_POST['DateFlight'])) {
            $xpl = explode('-', $_POST['DateFlight']);

            $FinalDate = dateTimeSetting::jalali_to_gregorian($xpl[0], $xpl[1], $xpl[2], '-');

            $sql .= " AND date_flight Like'%{$FinalDate}%'";
        }

        $sql .= " ORDER BY rep.creation_date_int DESC, rep.id DESC  ";
        $BookShow = $ModelBase->select($sql);

        foreach ($BookShow as $key => $rec) {
            $query = "SELECT credit FROM credit_detail_tb WHERE requestNumber='{$rec['request_number']}'";
            $result = $admin->ConectDbClient($query, $rec['client_id'], "Select", "", "", "");

            if (!empty($result)) {
                $BookShow[$key]['subCredit'] = $result['credit'];

            } else {
                $BookShow[$key]['subCredit'] = 0;
            }

            $queryTrans = "SELECT Price FROM transaction_tb WHERE FactorNumber='{$rec['factor_number']}'";
            $resultTrans = $admin->ConectDbClient($queryTrans, $rec['client_id'], "Select", "", "", "");

            if (!empty($resultTrans)) {
                $BookShow[$key]['credit'] = $resultTrans['Price'] / $rec['eachBookCount'];

            } else {
                $BookShow[$key]['credit'] = 0;
            }
        }

        $this->CountTicket = count($BookShow);

        return $BookShow;
    }

    #endregion


    public function infoBookByFactorNumber($factorNumber)
    {
        $Model = Load::library('Model');

        $Sql = "SELECT * FROM book_local_tb WHERE  factor_number='{$factorNumber}'";

        return $Model->select($Sql);


    }

    public function ListAllBuyClient($lastTimeUpdate = null)
    {
        $Model = Load::library('Model');
        $sql = "SELECT * FROM transaction_tb 
                WHERE 
                    PaymentStatus='success' 
                    AND  Reason NOT IN ('charge','price_cancel','indemnity_cancel','increase','decrease','indemnity_edit_ticket','diff_price')";
        if (!empty($lastTimeUpdate)) {
            $sql .= " AND creationDateInt >'{$lastTimeUpdate['creationDateInt']}'";
        }

        $resultTransaction = $Model->select($sql);


        if (!empty($resultTransaction)) {

            $this->userId = Session::getUserId();
            $infoUser = functions::infoMember($this->userId);
            $this->counterTypeId = $infoUser['fk_counter_type_id'];

            foreach ($resultTransaction as $keyResult => $valueTransaction) {

                if ($valueTransaction['Reason'] == 'buy_hotel' || $valueTransaction['Reason'] == 'buy_foreign_hotel' || $valueTransaction['Reason'] == 'buy_reservation_hotel') {
                    $resultHotel = $this->hotelBuy($valueTransaction['FactorNumber']);
                    if (!empty($resultHotel)) {
                        $result[$keyResult] = $resultHotel;
                    }
                } elseif ($valueTransaction['Reason'] == 'buy' || $valueTransaction['Reason'] == 'buy_reservation_ticket') {
                    $resultFlight = $this->ticketBuy($valueTransaction['FactorNumber']);
                    if (!empty($resultFlight)) {
                        $result[$keyResult] = $resultFlight;
                    }
                } elseif ($valueTransaction['Reason'] == 'buy_insurance') {
                    $insurance = $this->insuranceBuy($valueTransaction['FactorNumber']);
                    if (!empty($insurance)) {
                        $result[$keyResult] = $insurance;
                    }
                } elseif ($valueTransaction['Reason'] == 'buy_reservation_tour') {
                    $reservation_tour = $this->tourBuy($valueTransaction['FactorNumber']);
                    if (!empty($reservation_tour)) {
                        $result[$keyResult] = $reservation_tour;
                    }
                } elseif ($valueTransaction['Reason'] == 'buy_reservation_visa') {
                    $visa = $this->visaBuy($valueTransaction['FactorNumber']);
                    if (!empty($visa)) {
                        $result[$keyResult] = $visa;
                    }
                } elseif ($valueTransaction['Reason'] == 'buy_gasht_transfer') {
                    $resultGasht = $this->gashtBuy($valueTransaction['FactorNumber']);
                    if (!empty($resultGasht)) {
                        $result[] = $resultGasht;
                    }
                } elseif ($valueTransaction['Reason'] == 'buy_bus') {
                    $resBus = $this->BusBuy($valueTransaction['FactorNumber']);
                    if (!empty($resBus)) {
                        $result[$keyResult] = $resBus;
                    }
                } elseif ($valueTransaction['Reason'] == 'buy_train') {
                    $resTrain = $this->trainBuy($valueTransaction['FactorNumber']);
                    if (!empty($resTrain)) {
                        $result[$keyResult] = $resTrain;
                    }
                }
            }

            $resultFinal = array();
            if (isset($result)) {
                foreach ($result as $key => $res) {
                    if (!empty($res)) {
                        $resultFinal[] = $res;
                    }

                }
            }
            functions::insertLog('Result Is =>' . json_encode($resultFinal), 'ClubResultPoint');

            return $resultFinal;
        }

        return null;
    }



    #region listIncreasePriceCounter
    public function listIncreasePriceCounterFLight()
    {

        $Model = Load::library('Model');
        $sql = "SELECT * , COUNT(request_number) AS Count_request_number FROM book_local_tb
                WHERE amount_added <> ''
                AND  amount_added > 0
                AND successfull='book'   ";

        if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {
            $date_of = explode('-', $_POST['date_of']);
            $date_to = explode('-', $_POST['to_date']);
            $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
            $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
        }
        if (!empty($_POST['RequestNumber'])) {
            $sql .= " AND request_number ='{$_POST['RequestNumber']}'";
        }
        if (!empty($_POST['factorNumber'])) {
            $sql .= " AND factor_number ='{$_POST['factorNumber']}'";
        }
        $sql .="GROUP BY request_number  ORDER BY  creation_date_int DESC";
        return $Model->select($sql) ;
    }
    #endregion


    #region listUncompletedBookList
    public function listUncompletedBookList()
    {
        /** @var admin $admin */
        $admin = Load::controller('admin');
        $clients = functions::clients();
        $results = [];
        foreach ($clients as $client) {
            $clientId = $client['id'];
            $sqlTickets = "SELECT transactionTb.FactorNumber, bookLocal.* FROM transaction_tb AS transactionTb 
                           LEFT JOIN book_local_tb AS bookLocal ON bookLocal.factor_number = transactionTb.FactorNumber WHERE 
                            transactionTb.PaymentStatus= 'success' AND bookLocal.successfull <> 'book' ORDER BY bookLocal.successfull DESC";

            $tickets = $admin->ConectDbClient($sqlTickets, $clientId,'SelectAll');
            foreach ($tickets as $ticket) {
                $ticket['NameOfAgency'] = $client['AgencyName'];
                array_push($results, $ticket);
            }
        }

        return $results;
    }
    #endregion


    public function totalPriceWithDiscountPsr($Params)
    {
        $amount = 0;
        if (strtolower($Params['flight_type']) == 'system') {
            if ($Params['IsInternal'] == '1' || $Params['api_id'] != '10') {
                if ($Params['percent_discount'] > 0) {
                    if ($Params['pid_private'] == '0') {
                        $amount = $Params['priceTotal'] - ($Params['fare'] * ($Params['percent_discount'] / 200));
                    } elseif ($Params['pid_private'] == '1') {
                        $amount = $Params['priceTotal'] - ($Params['fare'] * ($Params['percent_discount'] / 100));
                    }
                } else {
                    $amount = $Params['priceTotal'];
                }
            } else {
                if ($Params['IsInternal'] == '0') {
                    if ($Params['price_change'] > 0 && $Params['price_change_type'] == 'percent') {
                        $ChangeAmount = $Params['priceTotal'] * ($Params['price_change'] / 100);
                        $amount = $Params['priceTotal'] - (($ChangeAmount * $Params['percent_discount']) / 100);
                    } else if ($Params['price_change'] > 0 && $Params['price_change_type'] == 'cost') {
                        $ChangeAmount = $Params['price_change'];
                        $amount = $Params['priceTotal'] - (($ChangeAmount * $Params['percent_discount']) / 100);
                    } else {
                        $amount = $Params['priceTotal'];
                    }
                }
            }
        } else {
            if ($Params['price_change'] > 0 && $Params['price_change_type'] == 'cost') {
                $ChangeAmount = $Params['price_change'];
                $amount = $Params['priceTotal'] - (($ChangeAmount * $Params['percent_discount']) / 100);
            } elseif ($Params['price_change'] > 0 && $Params['price_change_type'] == 'percent') {
                $ChangeAmount = $Params['priceTotal'] * ($Params['price_change'] / 100);

                if ($Params['passenger_age'] == 'Adt' || $Params['passenger_age'] == 'Chd') {
                    $amount = $Params['priceTotal'] - (($ChangeAmount * $Params['percent_discount']) / 100);
                } else if ($Params['passenger_age'] == 'Inf') {
                    $amount = $Params['priceTotal'];
                }
            } else {
                if ($Params['passenger_age'] == 'Adt' || $Params['passenger_age'] == 'Chd') {
                    $amount = $Params['priceTotal'] - (($Params['priceTotal'] * $Params['percent_discount']) / 100);
                } else if ($Params['passenger_age'] == 'Inf') {
                    $amount = $Params['priceTotal'];
                }
            }
        }

        return round($amount) ;
    }


    public function reportHistoryBuyAgency($type)
    {
        $agencyId = Session::getAgencyId();

        if($agencyId > 0)
        {
            switch ($type){
                case 'flight':
                    return $this->reportFlightAgency($agencyId);
                    break;
                case 'hotel':
                    return $this->reportHotelAgency($agencyId);
                    break;
                case 'insurance':
                    return $this->reportInsuranceAgency($agencyId);
                    break;
                case 'gashttransfer':
                    return $this->reportGashtAgency($agencyId);
                    break;

                case 'tour';
                    return $this->reportTourAgency($agencyId);
                    break;

                case 'visa';
                    return $this->reportVisaAgency($agencyId);
                    break;

                case 'bus';
                    return $this->reportBusAgency($agencyId);
                    break;

                case 'train':
                    return $this->reportTrainAgency($agencyId);
                    break;

                case 'entertainment':
                    return $this->reportEntertainmentAgency($agencyId);
                    break;



            }
        }
    }


    /**
     * @param $agencyId
     * @return false|string
     * @throws Exception
     */
    public function reportFlightAgency($agencyId){
        $resultFlightAgency = $this->bookLocalModel()->get()->where('agency_id',$agencyId)->groupBy('request_number')->orderBy('creation_date_int')->all() ;
        $info_agency = $this->agencyController()->infoAgency($agencyId);

        $dataFlightAgency = array();

        foreach ($resultFlightAgency as $key => $item) {

            $price_main = functions::CalculateDiscount($item['request_number'], 'yes');
            $price = ($info_agency['type_payment']== 'currency' && SOFTWARE_LANG !="fa") ? functions::ticketPriceCurrency($price_main ,$item['currency_equivalent']) : $price_main ;
            $addressTicket = ROOT_ADDRESS . '/pdf&target=parvazBookingLocal&id=' . $item['request_number'];
            $dataFlightAgency[$key]['passengerName'] = $item['passenger_name'].' '.$item['passenger_family'];;
            $dataFlightAgency[$key]['originOrDestination'] = $item['origin_city'] . '<br/><hr/>' . $item['desti_city'];
            $dataFlightAgency[$key]['requestNumberAndFactorNumber'] = $item['request_number'] . '<br/><hr/>' . $item['factor_number'];
            $dataFlightAgency[$key]['pnrAndETicketNumber'] = $item['pnr'] . '<br/><hr/>' . $item['eticket_number'];
            $dataFlightAgency[$key]['price'] = functions::numberFormat($price,$info_agency['type_currency']);
            $dataFlightAgency[$key]['dateBuy'] = dateTimeSetting::jdate('Y-m-d H:i:s', $item['creation_date_int'], '', '', 'en');
            if ($item['successfull'] == 'nothing') {
                $dataFlightAgency[$key]['linkPdfTicket'] = '<a class="btn btn-secondary" href="javascript:">'.functions::Xmlinformation('Unknow').'</a>';
            }
            elseif ($item['successfull'] == 'error') {
                if($item['flight_type']=='system'){
                    $dataFlightAgency[$key]['linkPdfTicket'] = '<a class="btn btn-danger" href="javascript:">'.functions::Xmlinformation('ErrorPayment').'</a>';
                }elseif($item['flight_type']=='charter'){
                    $dataFlightAgency[$key]['linkPdfTicket'] = '<a class="btn btn-danger" href="javascript:">'.functions::Xmlinformation('ErrorPayment').'</a>';
                }elseif($item['flight_type']=='charterPrivate'){
                    $dataFlightAgency[$key]['linkPdfTicket'] = '<a class="btn btn-danger" href="javascript:">'.functions::Xmlinformation('errorCharterPrivate').'</a>';
                }
            }
            elseif ($item['successfull'] == 'prereserve') {
                $dataFlightAgency[$key]['linkPdfTicket'] = '<a class="btn btn-warning" href="javascript:">'.functions::Xmlinformation('Prereservation').'</a>';
            }
            elseif ($item['successfull'] == 'bank') {
                $dataFlightAgency[$key]['linkPdfTicket'] = '<a class="btn btn-primary" href="javascript:">'.functions::Xmlinformation('RedirectPayment').'</a>';
            }
            elseif ($item['successfull'] == 'book') {
                if ($item['request_cancel'] == 'confirm') {
                    $dataFlightAgency[$key]['linkPdfTicket'] = '<a class="btn btn-danger" href="javascript:">'.functions::Xmlinformation('Refunded').'</a>';
                }else {
                    $dataFlightAgency[$key]['linkPdfTicket'] = '<a class="btn btn-success" href="' . $addressTicket . '">'.functions::Xmlinformation('ViewTickets').'</a>';
                }
            }
            elseif ($item['successfull'] == 'processing') {
                $dataFlightAgency[$key]['linkPdfTicket'] = '<a class="btn btn-info" href="javascript:">'.functions::Xmlinformation('processingPrintFlight').'</a>';
            }
            elseif ($item['successfull'] == 'pending') {
                $dataFlightAgency[$key]['linkPdfTicket'] = '<a class="btn btn-info" href="javascript:">'.functions::Xmlinformation('pendingPrintFlight').'</a>';
            }
            elseif ($item['successfull'] == 'credit') {
                $dataFlightAgency[$key]['linkPdfTicket'] = '<a class="btn btn-info" href="javascript:">'.functions::Xmlinformation('Credit').'</a>';
            }
        }

        return json_encode(array("data" => $dataFlightAgency));
    }

    /**
     * @param $agencyId
     * @return false|string
     */
    public function reportHotelAgency($agencyId)
    {
        $controllerHotel = Load::controller('BookingHotelNew');
        $resultHotelAgency = $controllerHotel->getReportHotelAgency($agencyId);
        $dataHotelAgency= array();
//        echo json_encode($resultHotelAgency); die();

        foreach ($resultHotelAgency as $key => $item) {
            $addressTicket = ROOT_ADDRESS . '/pdf?target=BookingHotelNew&id='.$item['factor_number'];
            $dataHotelAgency[$key]['passengerName'] = $item['passenger_name'].' '.$item['passenger_family'];
            $dataHotelAgency[$key]['hotelName'] = $item['hotel_name'] ;
            $dataHotelAgency[$key]['requestNumberAndFactorNumber'] = $item['request_number'] . '<br/><hr/>' . $item['factor_number'];
            $dataHotelAgency[$key]['voucherNumber'] = $item['voucher_number'] . '<br/><hr/>' . $item['eticket_number'];
            $dataHotelAgency[$key]['price'] = number_format($item['total_price']);
            $dataHotelAgency[$key]['dateBuy'] = dateTimeSetting::jdate('Y-m-d H:i:s', $item['creation_date_int'], '', '', 'en');
            if ($item['status'] == 'BookedSuccessfully') {
                if ($item['request_cancel'] == 'confirm') {
                    $dataHotelAgency[$key]['linkPdfTicket'] = '<a class="btn btn-danger" href="javascript:">'.functions::Xmlinformation('Refunded').'</a>';
                }else {
                    $dataHotelAgency[$key]['linkPdfTicket'] = '<a class="btn btn-success" href="' . $addressTicket . '">مشاهده واچر</a>';
                }
            }
            elseif ($item['status'] == 'bank') {
                $dataHotelAgency[$key]['linkPdfTicket'] = '<a class="btn btn-primary" href="javascript:">'.functions::Xmlinformation('RedirectPayment').'</a>';
            }
            elseif ($item['status'] == 'PreReserve') {
                $dataHotelAgency[$key]['linkPdfTicket'] = '<a class="btn btn-warning" href="javascript:">'.functions::Xmlinformation('Prereservation').'</a>';
            }
            elseif ($item['status'] == 'OnRequest') {
                $dataHotelAgency[$key]['linkPdfTicket'] = '<a class="btn btn-warning" href="javascript:">'.functions::Xmlinformation('OnRequestedHotel').'</a>';
            }
            elseif ($item['status'] == 'Cancelled') {
                $dataHotelAgency[$key]['linkPdfTicket'] = '<a class="btn btn-danger" href="javascript:">'.functions::Xmlinformation('Refunded').'</a>';
            }
            elseif ($item['status'] == 'pending') {
                $dataHotelAgency[$key]['linkPdfTicket'] = '<a class="btn btn-info" href="javascript:">'.functions::Xmlinformation('pendingPrintFlight').'</a>';
            }
            elseif ($item['status'] == 'Requested') {
                $dataHotelAgency[$key]['linkPdfTicket'] = '<a class="btn btn-warning" href="javascript:">'.functions::Xmlinformation('PrepaidData').'<br>'.functions::Xmlinformation('WaitingForAccepted').'</a>';
            }
            elseif ($item['status'] == 'RequestRejected') {
                $dataHotelAgency[$key]['linkPdfTicket'] = '<a class="btn btn-danger" href="javascript:">'.functions::Xmlinformation('ManagerDisapproval').'</a>';
            }
            elseif ($item['status'] == 'RequestAccepted') {
                $dataHotelAgency[$key]['linkPdfTicket'] = '<a class="btn btn-success" href="javascript:">'.functions::Xmlinformation('ContinuePay').'</a>';
            }
            else {
                $dataHotelAgency[$key]['linkPdfTicket'] = '<a class="btn btn-secondary" href="javascript:">'.functions::Xmlinformation('Unknow').'</a>';
            }
        }

        return json_encode(array("data" => $dataHotelAgency));
    }

    /**
     * @param $agencyId
     * @return false|string
     */
    public function reportInsuranceAgency($agencyId)
    {
        $controllerInsurance = Load::controller('insurance');
        $resultInsuranceAgency = $controllerInsurance->getReportInsuranceAgency($agencyId);
        $dataInsuranceAgency= array();
//        echo json_encode($resultInsuranceAgency); die();

        foreach ($resultInsuranceAgency as $key => $item) {
            $addressTicket = ROOT_ADDRESS . '/pdf&target=samanInsurance&id='.$item['factor_number'];
            $price =  $controllerInsurance->getTotalPriceByFactorNumber( $item['factor_number']);
            $dataInsuranceAgency[$key]['passengerName'] = $item['passenger_name'].' '.$item['passenger_family'];
            $dataInsuranceAgency[$key]['destination'] = $item['destination'] ;
            $dataInsuranceAgency[$key]['namePlane'] = $item['caption'];
            $dataInsuranceAgency[$key]['factorNumber'] = $item['factor_number'];
            $dataInsuranceAgency[$key]['SourceName'] = $item['source_name_fa'] ;
            $dataInsuranceAgency[$key]['price'] = number_format($price['totalPrice']);
            $dataInsuranceAgency[$key]['dateBuy'] = dateTimeSetting::jdate('Y-m-d H:i:s', $item['creation_date_int'], '', '', 'en');
            if ($item['status'] == 'book') {
                $dataInsuranceAgency[$key]['linkPdfTicket'] = '<a class="btn btn-success" onclick="modalListInsuranceProfile(null , ' . $item['factor_number'] . ')">جزییات</a>';
            }
            elseif ($item['status'] == 'bank') {
                $dataInsuranceAgency[$key]['linkPdfTicket'] = '<a class="btn btn-primary" href="javascript:">'.functions::Xmlinformation('RedirectPayment').'</a>';
            }
            elseif ($item['status'] == 'prereserve') {
                $dataInsuranceAgency[$key]['linkPdfTicket'] = '<a class="btn btn-warning" href="javascript:">'.functions::Xmlinformation('Prereservation').'</a>';
            }
            elseif ($item['status'] == 'cancel') {
                $dataInsuranceAgency[$key]['linkPdfTicket'] = '<a class="btn btn-danger" href="javascript:">'.functions::Xmlinformation('Refunded').'</a>';
            }
            else {
                $dataInsuranceAgency[$key]['linkPdfTicket'] = '<a class="btn btn-secondary" href="javascript:">'.functions::Xmlinformation('Unknow').'</a>';
            }
        }
        return json_encode(array("data" => $dataInsuranceAgency));
    }


    /**
     * @param $agencyId
     * @return false|string
     */
    public function reportGashtAgency($agencyId)
    {
        $controllerGasht = Load::controller('bookingGasht');
        $resultGashtAgency = $controllerGasht->getReportGashtAgency($agencyId);
        $dataGashtAgency= array();

        foreach ($resultGashtAgency as $key => $item) {
            $addressTicket = ROOT_ADDRESS . '/pdf&target=bookingGasht&id='.$item['passenger_factor_num'];

            $dataGashtAgency[$key]['passengerName'] = $item['passenger_name'].' '.$item['passenger_family'];
            $dataGashtAgency[$key]['cityName'] = $item['passenger_serviceCityName'] ;
            $dataGashtAgency[$key]['requestType'] = ($item['passenger_serviceRequestType'] == 0) ? 'گشت' : 'ترانسفر';
            $dataGashtAgency[$key]['factorNumber'] = $item['passenger_factor_num'];
            $dataGashtAgency[$key]['serviceName'] = $item['passenger_serviceName'] ;
            $dataGashtAgency[$key]['price'] = number_format($item['passenger_servicePriceAfterOff']);
            $dataGashtAgency[$key]['dateBuy'] = dateTimeSetting::jdate('Y-m-d H:i:s', $item['creation_date_int'], '', '', 'en');
            $dataGashtAgency[$key]['linkPdfTicket'] = '<a class="btn btn-info" href="' . $addressTicket . '">مشاهده بلیط</a>';

        }

        return json_encode(array("data" => $dataGashtAgency));
    }

    /**
     * @param $agencyId
     * @return false|string
     */
    public function reportTourAgency($agencyId)
    {
        $controllerTour = Load::controller('BookingTourLocal');
        $resultTourAgency = $controllerTour->getReportTourAgency($agencyId);
        $dataTourAgency= array();

        foreach ($resultTourAgency as $key => $item) {
            $addressTicket = ROOT_ADDRESS . '/pdf&target=BookingTourLocal&id='.$item['factor_number'];
            $dataTourAgency[$key]['passengerName'] = $item['passenger_name'].' '.$item['passenger_family'];
            $dataTourAgency[$key]['tourName'] = $item['tour_name'] ;
            $dataTourAgency[$key]['DateDepartureOrReturned'] = $item['tour_start_date'] .'<br/><hr/>'.$item['tour_end_date'];
            $dataTourAgency[$key]['factorNumber'] = $item['factor_number'];
//            $dataTourAgency[$key]['countDayAndCount'] = $item['tour_day']. '<br/><hr/>'.$item['tour_night'];
            $dataTourAgency[$key]['priceTotal'] = number_format($item['tour_total_price']);
            $dataTourAgency[$key]['pricePayment'] = number_format($item['tour_payments_price']);
            $dataTourAgency[$key]['dateBuy'] = dateTimeSetting::jdate('Y-m-d H:i:s', $item['creation_date_int'], '', '', 'en');

            $is_request=false;
            $tour_reservation_controller=Load::controller('reservationTour');
            $tourDetail=$tour_reservation_controller->infoTourById($item['tour_id']);
            if($tourDetail['is_request'] =='1') {
                $is_request=true;
            }

            if ($is_request && $item['status'] == 'Requested') {
                $dataTourAgency[$key]['linkPdfTicket'] = '<a class="btn btn-warning" href="javascript:">'.functions::Xmlinformation('Requested').'</a>';
            }
            elseif  ($is_request && $item['status'] == 'RequestRejected') {
                $dataTourAgency[$key]['linkPdfTicket'] = '<a class="btn btn-danger" href="javascript:">'.functions::Xmlinformation('RequestRejected').'</a>';
            }
            elseif  ($is_request && $item['status'] == 'RequestAccepted') {
                $dataTourAgency[$key]['linkPdfTicket'] = '<a class="btn btn-success" href="javascript:">'.functions::Xmlinformation('RequestAccepted').'</a>';
            }
            elseif ($item['status'] == 'BookedSuccessfully') {
                $dataTourAgency[$key]['linkPdfTicket'] = '<a class="btn btn-success" href="' . $addressTicket . '">مشاهده بلیط</a>';
            }
            elseif ($item['status'] == 'TemporaryReservation') {
                $dataTourAgency[$key]['linkPdfTicket'] = '<a class="btn btn-warning" href="javascript:">'.functions::Xmlinformation('Temporaryreservation').' '.functions::Xmlinformation('Paymentprebookingamount').'</a>';
            }
            elseif ($item['status'] == 'PreReserve') {
                $dataTourAgency[$key]['linkPdfTicket'] = '<a class="btn btn-warning" href="javascript:">'.functions::Xmlinformation('Temporaryreservation').' '.functions::Xmlinformation('Paymentprebookingamount').'</a>';
            }
            elseif ($item['status'] == 'TemporaryPreReserve') {
                $dataTourAgency[$key]['linkPdfTicket'] = '<a class="btn btn-warning" href="javascript:">'.functions::Xmlinformation('Temporaryprebooking').'</a>';
            }
            elseif ($item['status'] == 'bank') {
                $dataTourAgency[$key]['linkPdfTicket'] = '<a class="btn btn-primary" href="javascript:">'.functions::Xmlinformation('RedirectPayment').'</a>';
            }
            elseif ($item['status'] == 'CancellationRequest') {
                $dataTourAgency[$key]['linkPdfTicket'] = '<a class="btn btn-danger" href="javascript:">'.functions::Xmlinformation('Cancelrequestpassenger').'</a>';
            }
            elseif ($item['status'] == 'Cancellation') {
                $dataTourAgency[$key]['linkPdfTicket'] = '<a class="btn btn-danger" href="javascript:">'.functions::Xmlinformation('Cancellation').'</a>';
            }
            else {
                $dataTourAgency[$key]['linkPdfTicket'] = '<a class="btn btn-secondary" href="javascript:">'.functions::Xmlinformation('Unknow').'</a>';
            }

        }

        return json_encode(array("data" => $dataTourAgency));
    }

    /**
     * @param $agencyId
     * @return false|string
     */
    public function reportVisaAgency($agencyId)
    {
        $controllerVisa = Load::controller('visa');
        $resultVisaAgency = $controllerVisa->getReportVisaAgency($agencyId);

        $dataVisaAgency= array();
        foreach ($resultVisaAgency as $key => $item) {

            $dataVisaAgency[$key]['passengerName'] = $item['passenger_name'].' '.$item['passenger_family']; ;
            $dataVisaAgency[$key]['arrival'] = $item['visa_destination'];
            $dataVisaAgency[$key]['factorNumber'] = $item['factor_number'];
            $dataVisaAgency[$key]['visaTitle'] = $item['visa_title'];
            $dataVisaAgency[$key]['priceTotal'] = number_format($item['visa_main_cost']);
            $dataVisaAgency[$key]['pricePayment'] = number_format($item['visa_prepayment_cost']);
            $dataVisaAgency[$key]['dateBuy'] = dateTimeSetting::jdate('Y-m-d H:i:s', $item['creation_date_int'], '', '', 'en');
            if ($item['status'] == 'prereserve') {
                $dataVisaAgency[$key]['linkPdfTicket'] = '<a class="btn btn-warning" href="javascript:">'.functions::Xmlinformation('Prereservation').'</a>';
            } elseif ($item['status'] == 'bank') {
                $dataVisaAgency[$key]['linkPdfTicket'] = '<a class="btn btn-primary" href="javascript:">'.functions::Xmlinformation('RedirectPayment').'</a>';
            } elseif ($item['status'] == 'book') {
                $dataVisaAgency[$key]['linkPdfTicket'] = '<a class="btn btn-success" onclick="modalListForVisaDetails(null , ' . $item['factor_number'] . ')">جزییات</a>';
            } elseif ($item['status'] == 'cancel') {
                $dataVisaAgency[$key]['linkPdfTicket'] = '<a class="btn btn-danger" href="javascript:">'.functions::Xmlinformation('Refunded').'</a>';
            } else {
                $dataVisaAgency[$key]['linkPdfTicket'] = '<a class="btn btn-secondary" href="javascript:">'.functions::Xmlinformation('Unknow').'</a>';
            }
        }

        return json_encode(array("data" => $dataVisaAgency));
    }

    /**
     * @param $agencyId
     * @return false|string
     */
    public function reportBusAgency($agencyId)
    {
        $controllerBook = Load::controller('bookingBusTicket');
        $resultBusAgency = $controllerBook->getReportBusAgency($agencyId);

        $dataBusAgency= array();
        foreach ($resultBusAgency as $key => $item) {
            $addressTicket = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingBusShow&id=' . $item['passenger_factor_num'];
            $dataBusAgency[$key]['passengerName'] = $item['passenger_name'].' '.$item['passenger_family'];
            $dataBusAgency[$key]['originOrDestination'] = $item['OriginName'] . '<br/><hr/>' . $item['DestinationCity'];
            $dataBusAgency[$key]['factorNumber'] = $item['passenger_factor_num'];
            $dataBusAgency[$key]['moveDateAndTime'] = $item['DateMove']. ' ' . $item['TimeMove'];;
            $dataBusAgency[$key]['eTicketNumberAndChairs'] = $item['pnr'] . '<br/><hr/>' . $item['PassengerChairs'];
            $dataBusAgency[$key]['price'] = number_format($item['total_price']);
            $dataBusAgency[$key]['dateBuy'] = dateTimeSetting::jdate('Y-m-d H:i:s', $item['creation_date_int'], '', '', 'en');

            if ($item['status'] == 'book') {
                if ($item['request_cancel'] == 'confirm') {
                    $dataBusAgency[$key]['linkPdfTicket'] = '<a class="btn btn-danger" href="javascript:">'.functions::Xmlinformation('Refunded').'</a>';
                }else {
                    $dataBusAgency[$key]['linkPdfTicket'] = '<a class="btn btn-success" href="' . $addressTicket . '">مشاهده بلیط</a>';
                }
            }
            elseif ($item['status'] == 'temporaryReservation') {
                $dataBusAgency[$key]['linkPdfTicket'] = '<a class="btn btn-warning" href="javascript:">'.functions::Xmlinformation('Temporaryreservation').'</a>';
            }
            elseif ($item['status'] == 'prereserve') {
                $dataBusAgency[$key]['linkPdfTicket'] = '<a class="btn btn-warning" href="javascript:">'.functions::Xmlinformation('Prereservation').'</a>';
            }
            elseif ($item['status'] == 'bank') {
                $dataBusAgency[$key]['linkPdfTicket'] = '<a class="btn btn-primary" href="javascript:">'.functions::Xmlinformation('NotPaid').'</a>';
            }
            elseif ($item['status'] == 'cancel') {
                $dataBusAgency[$key]['linkPdfTicket'] = '<a class="btn btn-danger" href="javascript:">'.functions::Xmlinformation('Refunded').'</a>';
            }
            elseif ($item['status'] == 'nothing') {
                $dataBusAgency[$key]['linkPdfTicket'] = '<a class="btn btn-secondary" href="javascript:">'.functions::Xmlinformation('Unknow').'</a>';
            }
            else {
                $dataBusAgency[$key]['linkPdfTicket'] = '<a class="btn btn-secondary" href="javascript:">'.functions::Xmlinformation('Unknow').'</a>';
            }

        }

        return json_encode(array("data" => $dataBusAgency));
    }

    /**
     * @param $agencyId
     * @return false|string
     */
    public function reportTrainAgency($agencyId)
    {
        $bookingTrain = Load::controller('bookingTrain');
        $resultTrainAgency = $bookingTrain->getReportTrainAgency($agencyId);


        $dataTrainAgency = array();

        foreach ($resultTrainAgency as $key => $item) {

            $price =$bookingTrain->TotalPriceByFactorNumber($item['factor_number']);
            $addressTicket = ROOT_ADDRESS . '/pdf&target=trainBooking&id=' . $item['requestNumber'];
            $dataTrainAgency[$key]['passengerName'] = $item['passenger_name'].' '.$item['passenger_family'];
            $dataTrainAgency[$key]['originOrDestination'] = $item['Departure_City'] . '<br/><hr/>' . $item['Arrival_City'];
            $dataTrainAgency[$key]['requestNumberAndFactorNumber'] = $item['requestNumber'] . '<br/><hr/>' . $item['factor_number'];
            $dataTrainAgency[$key]['ticketNumberAndSecurityNumber'] = $item['TicketNumber'] . '<br/><hr/>' . $item['SecurityNumber'];
            $dataTrainAgency[$key]['price'] = number_format($price);
            $dataTrainAgency[$key]['dateBuy'] = dateTimeSetting::jdate('Y-m-d H:i:s', $item['creation_date_int'], '', '', 'en');
            $dataTrainAgency[$key]['linkPdfTicket'] = '<a class="btn btn-info" href="' . $addressTicket . '">مشاهده بلیط</a>';

        }
        return json_encode(array("data" => $dataTrainAgency));
    }


    /**
     * @param $agencyId
     * @return false|string
     */
    public function reportEntertainmentAgency($agencyId)
    {
        $controllerEntertainment = Load::controller('entertainment');
        $resultEntertainmentAgency = $controllerEntertainment->getReportEntertainmentAgency($agencyId);

        $dataEntertainmentAgency= array();
        foreach ($resultEntertainmentAgency as $key => $item) {
            $addressTicket = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=entertainment&id=' . $item['factor_number'];
            $dataEntertainmentAgency[$key]['passengerName'] = $item['passenger_name'] . ' ' . $item['passenger_family'];
            $dataEntertainmentAgency[$key]['entertainmentTitleName'] = $item['EntertainmentTitle'];
            $dataEntertainmentAgency[$key]['countPeople'] = $item['CountPeople'];
            $dataEntertainmentAgency[$key]['requestNumberAndFactorNumber'] = $item['factor_number'] . '<br/><hr/>' . $item['requestNumber'];
            $dataEntertainmentAgency[$key]['priceTotal'] = number_format($item['price']);
            $dataEntertainmentAgency[$key]['dateBuy'] = dateTimeSetting::jdate('Y-m-d H:i:s', $item['creation_date_int'], '', '', 'en');

            if ($item['successfull'] == 'book') {
                $dataEntertainmentAgency[$key]['linkPdfTicket'] = '<a class="btn btn-success" href="' . $addressTicket . '">مشاهده بلیط</a>';
            } elseif ($item['successfull'] == 'temporaryReservation') {
                $dataEntertainmentAgency[$key]['linkPdfTicket'] = '<a class="btn btn-warning" href="javascript:">'.functions::Xmlinformation('Temporaryreservation').'</a>';
            } elseif ($item['successfull'] == 'TemporaryPreReserve') {
                $dataEntertainmentAgency[$key]['linkPdfTicket'] = '<a class="btn btn-warning" href="javascript:">'.functions::Xmlinformation('Prereservation').'</a>';
            } elseif ($item['successfull'] == 'prereserve') {
                $dataEntertainmentAgency[$key]['linkPdfTicket'] = '<a class="btn btn-warning" href="javascript:">'.functions::Xmlinformation('Prereservation').'</a>';
            } elseif ($item['successfull'] == 'Requested') {
                $dataEntertainmentAgency[$key]['linkPdfTicket'] = '<a class="btn btn-warning" href="javascript:">'.functions::Xmlinformation('Requested').'</a>';
            } elseif ($item['successfull'] == 'bank') {
                $dataEntertainmentAgency[$key]['linkPdfTicket'] = '<a class="btn btn-primary" href="javascript:">'.functions::Xmlinformation('NotPaid').'</a>';
            } elseif ($item['successfull'] == 'cancel') {
                $dataEntertainmentAgency[$key]['linkPdfTicket'] = '<a class="btn btn-danger" href="javascript:">'.functions::Xmlinformation('Refunded').'</a>';
            } elseif ($item['successfull'] == 'nothing') {
                $dataEntertainmentAgency[$key]['linkPdfTicket'] = '<a class="btn btn-secondary" href="javascript:">'.functions::Xmlinformation('Unknow').'</a>';
            }else {
                $dataEntertainmentAgency[$key]['linkPdfTicket'] = '<a class="btn btn-secondary" href="javascript:">'.functions::Xmlinformation('Unknow').'</a>';
            }
        }
        return json_encode(array("data" => $dataEntertainmentAgency));
    }

    public function getListBuyFlightToday($date) {

        $date_current = strtotime($date);
        $date_current_previous = strtotime($date )- (24*60*60);
        $today_buy_lists = $this->reportModel()->get(['request_number'])
            ->where('creation_date_int',$date_current,'<=')
            ->where('creation_date_int',$date_current_previous,'>')
            ->where('successfull','book')
            ->where('pid_private','0')->groupBy('request_number')->all();
        $total_amount = 0 ;
        foreach ($today_buy_lists as $today_buy_list) {
            list($amount,$fare) = $this->getMainAmountTicket($today_buy_list['request_number']) ;
            $total_amount = (intval($total_amount) + intval($amount) );
        }

        return $total_amount ;
    }

    #region get_total_ticket_price

    public function getMainAmountTicket($request_number)
    {
        $flights = $this->reportModel()->get()->where('request_number',$request_number)->all();
        $amount = 0;
        $fare = 0;
        foreach ($flights as $each) {
            //در هر رکورد فقط یکی از قیمت ها با توجه به سن مقدار دارد و دوتای دیگر صفر هستند
            if ($each['flight_type'] == 'system') {
                $amount += $each['adt_price'] + $each['chd_price'] + $each['inf_price'];
                $fare += $each['adt_fare'] + $each['chd_fare'] + $each['inf_fare'];
            } else {
                $amount += $each['adt_price'] + $each['chd_price'] + $each['inf_price'];

                $fare = '0';
            }
        }
        return array($amount,$fare);
    }

#endregion

    public  function btnErrorFlight($data_flight){
        $status_admin = (TYPE_ADMIN=='1') ? true : false ;
        $client_id = ($status_admin) ? $data_flight['client_id'] : CLIENT_ID ;
        $data_error = $this->getController('logErrorFlights')->getErrorMessage($data_flight['request_number'],$client_id);

        $classes =  in_array($data_error['messageCode'],$this->getCodeSpecialError()) ? 'colorSpecialError' : '';
        $text_btn = $this->titleBtnError($data_error,$data_flight);
        $content_btn = $data_error['text_message'];

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
            }elseif(in_array($data_error['messageCode'],$this->errorCodePassport())){
                if($data_error['messageCode']=='Err0107011' || $data_error['messageCode']=='-420'){
                    return 'خطای انقضاء پاسپورت';
                }else{
                    return 'خطای پاسپورت';
                }
            }else{
                return ($data_flight=='charter') ? 'خطای چارتر کننده':'خطای ایرلاین';
            }
        }else{
            return ($data_flight=='charter') ? 'خطای چارتر کننده':'خطای ایرلاین';
        }
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
            'Err0107065',
            '-506',
            '-411',
            '-420',
            '-418',
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

    public function changeFlagToPending($param){

        functions::insertLog('first changeFlagToPending==>' . json_encode($param, 256), 'changeFlagToPending');

        $condition = "factor_number='{$param['factor_number']}' AND successfull = 'processing'" ;
        $data_update_flight['successfull'] = 'pending';
        $this->getModel('bookLocalModel')->update($data_update_flight,$condition);
        functions::insertLog('after bookLocalModel==>' . json_encode($param, 256), 'changeFlagToPending');

        $this->getModel('reportModel')->update($data_update_flight,$condition);
        functions::insertLog('after reportModel==>' . json_encode($param, 256), 'changeFlagToPending');

        return functions::withSuccess('',200,'it is done');
    }


    public function changePriceOnChange($params) {

        $book_report_model = $this->getModel('reportModel');
        $book_local_model = $this->getModel('bookLocalModel');

        $dataUpdate = [
            'amount_added' => $params['data_new_price'],
        ];
        $result_report = $book_report_model->updateWithBind($dataUpdate, ['request_number' => $params['data_request_number']]);
        $result_local = $book_local_model->updateWithBind($dataUpdate, ['request_number' => $params['data_request_number']]);
        $date = dateTimeSetting::jdate("Y-m-d", time());
        if ( $result_report && $result_local) {
            $data_new_price = [
                'request_number' => $params['data_request_number'],
                'old_price' => $params['data_old_price'],
                'new_price' => $params['data_new_price'],
                'date_change' => time(),
            ];
            $insert = $this->getModel('changePriceModel')->insertWithBind($data_new_price);
        }

        if ($insert) {
            return functions::withSuccess('', 200, 'تغییر قیمت  با موفقیت انجام شد');
        }
        return " error : درخواست شما با خطا مواجه شده ،لطفا مجددا انجام دهید";

    }

    public function getListChange($requestId) {
        $ChangeList = $this->getModel('changePriceModel')->get()->where('request_number', $requestId)->orderBy('id' , 'DESC');
        $result = $ChangeList->all();
        return $result;
    }

    public function createExcelForRavisFlight($param)
    {
        $_POST = $param;
        $resultBook = $this->listBookLocal();
        if (!empty($resultBook)) {
            // برای نام گذاری سطر اول فایل اکسل //
            $firstRowColumnsHeading = ['شماره خرید', 'مبلغ(ریال)', 'زمان تراکنش', 'رسید دیجیتال', 'کد طرف حساب'];
            $firstRowWidth = [25, 25, 25, 25, 25];
            $data_excel = [];
            $Index=1;

            foreach ( $resultBook as $key=>$book) {
                //code ravis agency
                $resultRavis= $this->getModel('agencyModel')
                    ->get(['ravis_code'])
                    ->where('id' , $book['agency_id'])
                    ->find();

                $total_price = !empty($book['total_price']) ? number_format($book['total_price']) : 0;
                //$tracking_code = !empty($book['tracking_code_bank']) ? $book['tracking_code_bank'] : '';
                $ravis_code = !empty($resultRavis['ravis_code']) ? $resultRavis['ravis_code'] : '';

                //$data_excel[$key]['number_column'] = $Index;
                $data_excel[$key]['factor_number'] = " " . $book['factor_number'];
                $data_excel[$key]['total_price'] = $total_price;
                $data_excel[$key]['creation_date'] = dateTimeSetting::jdate( 'Y/m/d H:i:s', $book['creation_date_int'] );
                $data_excel[$key]['tracking_code_bank'] = " " . $book['factor_number'];
                $data_excel[$key]['ravis_code'] = $ravis_code;
                $Index++;
            }
            //var_dump($data_excel);die();
            /** @var createExcelFile $objCreateExcelFile */
            $objCreateExcelFile = Load::controller('createExcelFile');
            $resultExcel = $objCreateExcelFile->create($data_excel, $firstRowColumnsHeading,$firstRowWidth,'فیش درگاه بانک - پرواز');

            if ($resultExcel['message'] == 'success') {
                return 'success|' . $resultExcel['fileName'];
            } else {
                return 'error|متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید';
            }
        } else {
            return 'error|اطلاعاتی برای ساخت فایل اکسسل وجود ندارد.';
        }
    }
    public function createExcelForRavisHotel($param)
    {
        $_POST = $param;
        $_POST['status'] = 'book';
        $BookHotelController = Load::controller( 'bookhotelshow' );
        $ListBookHotelLocal = $BookHotelController->listBookHotelLocal();

        if (!empty($ListBookHotelLocal)) {
            // برای نام گذاری سطر اول فایل اکسل //
            $firstRowColumnsHeading = ['شماره خرید', 'مبلغ(ریال)', 'زمان تراکنش', 'رسید دیجیتال', 'کد طرف حساب'];
            $firstRowWidth = [25, 25, 25, 25, 25];
            $data_excel = [];
            $Index=1;
            foreach ($ListBookHotelLocal as $key=>$book) {
                //code ravis agency
                $resultRavis= $this->getModel('agencyModel')
                    ->get(['ravis_code'])
                    ->where('id' , $book['agency_id'])
                    ->find();

                $total_price = !empty($book['total_price']) ? number_format($book['total_price']) : 0;
                //$tracking_code = !empty($book['tracking_code_bank']) ? $book['tracking_code_bank'] : '';
                $ravis_code = !empty($resultRavis['ravis_code']) ? $resultRavis['ravis_code'] : '';

                //$data_excel[$key]['number_column'] = $Index;
                $data_excel[$key]['factor_number'] = " " . $book['factor_number'];
                $data_excel[$key]['total_price'] = $total_price;
                $data_excel[$key]['creation_date'] = dateTimeSetting::jdate( 'Y/m/d H:i:s', $book['creation_date_int'] );
                $data_excel[$key]['tracking_code_bank'] =" " . $book['factor_number'];
                $data_excel[$key]['ravis_code'] = $ravis_code;
                $Index++;
            }

            /** @var createExcelFile $objCreateExcelFile */
            $objCreateExcelFile = Load::controller('createExcelFile');
            $resultExcel = $objCreateExcelFile->create($data_excel, $firstRowColumnsHeading,$firstRowWidth,'فیش درگاه بانک - هتل');

            if ($resultExcel['message'] == 'success') {
                return 'success|' . $resultExcel['fileName'];
            } else {
                return 'error|متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید';
            }
        } else {
            return 'error|اطلاعاتی برای ساخت فایل اکسسل وجود ندارد.';
        }
    }
}
