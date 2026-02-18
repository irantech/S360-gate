<?php


class memberReportBuy
{



    public function createExcelFile($param)
    {

        $_POST = $param;
        $memberId = $_POST['memberId'];
        $resultBook = $this->getMemberReportBuy($memberId, 'yes');
        if (!empty($resultBook)) {

            // برای نام گذاری سطر اول فایل اکسل //
            $firstRowColumnsHeading = ['ردیف', 'تاریخ و ساعت خرید', 'نوع خرید',
                'شماره فاکتور', 'آژانس همکار', 'قیمت کل', 'نرم افزار', 'وضعیت'];

            $objCreateExcelFile = Load::controller('createExcelFile');
            $resultExcel = $objCreateExcelFile->create($resultBook, $firstRowColumnsHeading);
            if ($resultExcel['message'] == 'success'){
                return 'success|' . $resultExcel['fileName'];
            } else {
                return 'error|متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید';
            }


        } else {
            return 'error|اطلاعاتی برای ساخت فایل اکسسل وجود ندارد.';
        }


    }


    public function getMemberReportBuy($memberId, $reportForExcel = null)
    {

        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);


        if (TYPE_ADMIN == '1') {

            $tableNameHotel = 'report_hotel_tb';
            $tableNameTicket = 'report_tb';
            $tableNameEuropcar = 'report_europcar_tb';
            $tableNameInsurance = 'report_insurance_tb';
            $tableNameVisa = 'report_visa_tb';
            $tableNameGasht = 'report_gasht_tb';
            $tableNameTour = 'report_tour_tb';

        } else {

            $tableNameHotel = 'book_hotel_local_tb';
            $tableNameTicket = 'book_local_tb';
            $tableNameEuropcar = 'book_europcar_local_tb';
            $tableNameInsurance = 'book_insurance_tb';
            $tableNameVisa = 'book_visa_tb';
            $tableNameGasht = 'book_gasht_local_tb';
            $tableNameTour = 'book_tour_local_tb';

        }

        $conditions = '';
        if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {

            $date_of = explode('-', $_POST['date_of']);
            $date_to = explode('-', $_POST['to_date']);
            $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
            $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            $conditions .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }else {
            $conditions .= "AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";
        }


        $sql = "
            SELECT
                'hotel' As applicationTitle,
                id AS id,
                creation_date_int,
                member_name AS memberName,
                agency_name AS agencyName,
                factor_number AS factorNumber,
                request_number AS requestNumber,
                type_application AS typeApplication,
                payment_date AS paymentDate,
                payment_type AS paymentType,
                tracking_code_bank AS trackingCodeBank,
                total_price AS totalPrice,
                status AS statusBook,
                '' AS flightType,
                '' AS percentDiscount,
                '' As agencyCommission,
                '' AS supplierCommission,
                '' AS irantechCommission,
                '' AS adtPrice,
                '' AS chdPrice,
                '' AS infPrice,
                '' AS totalPriceA,
                '' AS totalPaymentPriceA
            FROM
                {$tableNameHotel}
            WHERE
                member_id = '{$memberId}'
                {$conditions}
            GROUP BY 
                factorNumber
            UNION
            SELECT
                'ticket' As applicationTitle,
                id AS id,
                creation_date_int,
                member_name AS memberName,
                agency_name AS agencyName,
                factor_number AS factorNumber,
                request_number AS requestNumber,
                type_app AS typeApplication,
                payment_date AS paymentDate,
                payment_type AS paymentType,
                tracking_code_bank AS trackingCodeBank,
                total_price AS totalPrice,
                successfull AS statusBook,
                flight_type AS flightType,
                percent_discount AS percentDiscount,
                agency_commission AS agencyCommission,
                supplier_commission AS supplierCommission,
                irantech_commission AS irantechCommission,
                adt_price AS adtPrice,
                chd_price AS chdPrice,
                inf_price AS infPrice,
                '' AS totalPriceA,
                '' AS totalPaymentPriceA
            FROM
                {$tableNameTicket} 
            WHERE
                member_id = '{$memberId}' 
                {$conditions}
            GROUP BY
                factorNumber
            UNION
            SELECT
                'europcar' As applicationTitle,
                id AS id,
                creation_date_int,
                member_name AS memberName,
                agency_name AS agencyName,
                factor_number AS factorNumber,
                '' AS requestNumber,
                '' AS typeApplication,
                payment_date AS paymentDate,
                payment_type AS paymentType,
                tracking_code_bank AS trackingCodeBank,
                total_price AS totalPrice,
                status AS statusBook,
                '' AS flightType,
                '' AS percentDiscount,
                '' As agencyCommission,
                '' AS supplierCommission,
                '' AS irantechCommission,
                '' AS adtPrice,
                '' AS chdPrice,
                '' AS infPrice,
                '' AS totalPriceA,
                '' AS totalPaymentPriceA
            FROM
                {$tableNameEuropcar}
            WHERE
                member_id = '{$memberId}'
                {$conditions}
            GROUP BY 
                factorNumber
            UNION
            SELECT
                'insurance' As applicationTitle,
                id AS id,
                creation_date_int,
                member_name AS memberName,
                '' AS agencyName,
                factor_number AS factorNumber,
                '' AS requestNumber,
                '' AS typeApplication,
                payment_date AS paymentDate,
                payment_type AS paymentType,
                tracking_code_bank AS trackingCodeBank,
                FLOOR(
                    IF(price_change_type = 'none',
                       SUM(base_price + tax), 
                       IF(
                            price_change_type = 'cost',
                            SUM(base_price + tax + price_change),
                            SUM(base_price + tax +((base_price + tax) * price_change / 100))
                       )
                    )
                  ) AS totalPrice,
                status AS statusBook,
                '' AS flightType,
                '' AS percentDiscount,
                '' As agencyCommission,
                '' AS supplierCommission,
                '' AS irantechCommission,
                '' AS adtPrice,
                '' AS chdPrice,
                '' AS infPrice,
                '' AS totalPriceA,
                '' AS totalPaymentPriceA
            FROM
                {$tableNameInsurance}
            WHERE
                member_id = '{$memberId}'
                {$conditions}
            GROUP BY 
                factorNumber
            UNION
            SELECT
                'visa' As applicationTitle,
                id AS id,
                creation_date_int,
                member_name AS memberName,
                agency_name AS agencyName,
                factor_number AS factorNumber,
                '' AS requestNumber,
                '' AS typeApplication,
                payment_date AS paymentDate,
                payment_type AS paymentType,
                tracking_code_bank AS trackingCodeBank,
                SUM(visa_main_cost) AS totalPrice,
                status AS statusBook,
                '' AS flightType,
                '' AS percentDiscount,
                '' As agencyCommission,
                '' AS supplierCommission,
                '' AS irantechCommission,
                '' AS adtPrice,
                '' AS chdPrice,
                '' AS infPrice,
                '' AS totalPriceA,
                '' AS totalPaymentPriceA
            FROM
                {$tableNameVisa}
            WHERE
                member_id = '{$memberId}'
                {$conditions}
            GROUP BY 
                factorNumber
            UNION
            SELECT
                'gasht' As applicationTitle,
                id AS id,
                creation_date_int,
                member_name AS memberName,
                agency_name AS agencyName,
                passenger_factor_num AS factorNumber,
                '' AS requestNumber,
                '' AS typeApplication,
                payment_date AS paymentDate,
                payment_type AS paymentType,
                tracking_code_bank AS trackingCodeBank,
                passenger_servicePriceAfterOff AS totalPrice,
                status AS statusBook,
                '' AS flightType,
                '' AS percentDiscount,
                '' As agencyCommission,
                '' AS supplierCommission,
                '' AS irantechCommission,
                '' AS adtPrice,
                '' AS chdPrice,
                '' AS infPrice,
                '' AS totalPriceA,
                '' AS totalPaymentPriceA
            FROM
                {$tableNameGasht}
            WHERE
                member_id = '{$memberId}'
                {$conditions}
            GROUP BY 
                factorNumber
            UNION
            SELECT
                'tour' As applicationTitle,
                id AS id,
                creation_date_int,
                member_name AS memberName,
                agency_name AS agencyName,
                factor_number AS factorNumber,
                '' AS requestNumber,
                '' AS typeApplication,
                payment_date AS paymentDate,
                payment_type AS paymentType,
                tracking_code_bank AS trackingCodeBank,
                tour_total_price AS totalPrice,
                status AS statusBook,
                '' AS flightType,
                '' AS percentDiscount,
                '' As agencyCommission,
                '' AS supplierCommission,
                '' AS irantechCommission,
                '' AS adtPrice,
                '' AS chdPrice,
                '' AS infPrice,
                tour_total_price_a AS totalPriceA,
                tour_payments_price_a AS totalPaymentPriceA
            FROM
                {$tableNameTour}
            WHERE
                member_id = '{$memberId}'
                {$conditions}
            GROUP BY 
                factorNumber
            ";
        $sql .= " ORDER BY creation_date_int DESC ";


        if (TYPE_ADMIN == '1') {
            $ModelBase = Load::library('ModelBase');
            $resultBook = $ModelBase->select($sql);
        } else {
            $Model = Load::library('Model');
            $resultBook = $Model->select($sql);
        }

        $dataRows = [];
        foreach ($resultBook as $k => $book) {
            $numberColumn = $k + 2;

            if ($book['paymentType'] == 'cash'){
                $paymentTypeFa = 'نقدی';
            } elseif ($book['paymentType'] == 'credit'){
                $paymentTypeFa = 'اعتباری';
            } else {
                $paymentTypeFa = '';
            }


            switch ($book['applicationTitle']){
                case 'hotel':

                    switch ($book['typeApplication']){
                        case 'reservation':
                            $applicationTitleFa = 'هتل رزرواسیون';
                            break;
                        case 'api':
                            $applicationTitleFa = 'هتل اشتراکی داخلی';
                            break;
                        case 'foreignApi':
                            $applicationTitleFa = 'هتل اشتراکی خارجی';
                            break;
                        case 'reservation_app':
                            $applicationTitleFa = 'هتل رزرواسیون (خرید از اَپلیکیشن)';
                            break;
                        case 'api_app':
                            $applicationTitleFa = 'هتل اشتراکی داخلی (خرید از اَپلیکیشن)';
                            break;
                        default:
                            $applicationTitleFa = '';
                            break;
                    }

                    switch ($book['statusBook']){
                        case 'BookedSuccessfully':
                            $statusBookFa = 'رزرو قطعی';
                            break;
                        case 'PreReserve':
                            $statusBookFa = 'پیش رزرو';
                            break;
                        case 'Cancelled':
                            $statusBookFa = 'لغو درخواست';
                            break;
                        case 'OnRequest':
                            $statusBookFa = 'منتظر تایید درخواست';
                            break;
                        default:
                            $statusBookFa = 'نامشخص';
                            break;
                    }

                    $totalPrice = $book['totalPrice'];
                    $creationDateInt = (!empty($book['paymentDate'])) ? functions::set_date_payment($book['paymentDate']) : '';

                    break;
                case 'ticket':
                    $applicationTitleFa = 'بلیط';

                    if ($book['flightType'] == 'charter') {
                        $applicationTitleFa .= ' - چارتری (چارتر اشتراکی)';
                    } elseif ($book['flightType'] == 'system' && $book['pid_private'] == '1') {
                        $applicationTitleFa .= ' - سیستمی (پید اختصاصی)';
                    } elseif ($book['flightType'] == 'system' && $book['pid_private'] == '0') {
                        $applicationTitleFa .= ' - سیستمی (پید اشتراکی)';
                    } elseif ($book['typeApplication'] == 'reservation') {
                        $applicationTitleFa .= ' - رزرواسیون';
                    }

                    if ($book['typeApplication'] == 'Web' || $book['typeApplication'] == 'Application') {

                        if ($book['statusBook'] == 'nothing') {
                            $statusBookFa = 'انصراف از خرید';
                        } elseif ($book['statusBook'] == 'error' && $book['flightType'] == 'charter') {
                            $statusBookFa = 'خطای چارتر کننده';
                        } elseif ($book['statusBook'] == 'error' && $book['flightType'] == 'system') {
                            $statusBookFa = 'خطای ایرلاین';
                        } elseif ($book['statusBook'] == 'prereserve') {
                            $statusBookFa = 'پیش رزرو';
                        } elseif ($book['statusBook'] == 'bank') {
                            $statusBookFa = 'هدایت به درگاه';
                        } elseif ($book['statusBook'] == 'credit') {
                            $statusBookFa = 'انتخاب گزینه اعتباری';
                        } elseif ($book['statusBook'] == 'book') {
                            $statusBookFa = 'رزرو قطعی';
                        }

                    } else {

                        if ($book['statusBook'] == 'book') {
                            $statusBookFa = 'رزرو قطعی';
                        } elseif ($book['statusBook'] == 'prereserve') {
                            $statusBookFa = 'پیش رزرو';
                        } elseif ($book['statusBook'] == 'bank' && $book['tracking_code_bank'] == '') {
                            $statusBookFa = 'پرداخت اینترنتی نا موفق';
                        } else {
                            $statusBookFa = 'نامشخص';
                        }

                    }

                    if ($book['flightType'] != 'charterPrivate') {
                        if ($book['flightType'] == 'charter') {
                            if ($book['percentDiscount'] > 0) {
                                $totalPrice = $book['agencyCommission'] + $book['supplierCommission'] + $book['irantechCommission'];
                            } else {
                                $totalPrice = functions::CalculateDiscount($book['requestNumber'], 'yes');
                            }
                        } elseif ($book['flightType'] == 'system') {
                            if ($book['percentDiscount'] > 0) {
                                $totalPrice = $book['adtPrice'] + $book['chdPrice'] + $book['infPrice'];
                            } else {
                                $totalPrice = $book['adtPrice'] + $book['chdPrice'] + $book['infPrice'];
                            }
                        }

                    } else {
                        $totalPrice = $book['totalPrice'];
                    }
                    $creationDateInt = (!empty($book['paymentDate'])) ? functions::set_date_payment($book['paymentDate']) : '';

                    break;
                case 'europcar':


                    $applicationTitleFa = 'رزرو اجاره خودرو';

                    switch ($book['statusBook']){
                        case 'BookedSuccessfully':
                            $statusBookFa = 'رزرو قطعی';
                            break;
                        case 'PreReserve':
                            $statusBookFa = 'پیش رزرو';
                            break;
                        case 'TemporaryReservation':
                            $statusBookFa = 'پیش رزرو (منتظر تایید یا عدم تایید سیستم یوروپ کار)';
                            break;
                        case 'Cancellation':
                            $statusBookFa = 'لغو درخواست';
                            break;
                        case 'CancelFromEuropcar':
                            $statusBookFa = 'لغو درخواست (لغو درخواست از طرف سیستم یوروپ کار)';
                            break;
                        case 'NoShow':
                            $statusBookFa = 'NoShow';
                            break;
                        default:
                            $statusBookFa = 'نامشخص';
                            break;
                    }

                    $totalPrice = $book['totalPrice'];
                    $creationDateInt = (!empty($book['paymentDate'])) ? functions::set_date_payment($book['paymentDate']) : '';


                    break;
                case 'insurance':

                    $applicationTitleFa = 'بیمه';

                    switch ($book['statusBook']){
                        case 'book':
                            $statusBookFa = 'رزرو قطعی';
                            break;
                        case 'prereserve':
                            $statusBookFa = 'پیش رزرو';
                            break;
                        case 'bank':
                            $statusBookFa = 'هدایت به درگاه';
                            break;
                        case 'nothing':
                            $statusBookFa = 'نامشخص';
                            break;
                        default:
                            $statusBookFa = 'نامشخص';
                            break;
                    }

                    $totalPrice = $book['totalPrice'];
                    $creationDateInt = dateTimeSetting::jdate('Y-m-d (H:i:s)', $book['creation_date_int']);

                    break;
                case 'visa':

                    $applicationTitleFa = 'ویزا';

                    switch ($book['statusBook']){
                        case 'book':
                            $statusBookFa = 'رزرو قطعی';
                            break;
                        case 'prereserve':
                            $statusBookFa = 'پیش رزرو';
                            break;
                        case 'bank':
                            $statusBookFa = 'هدایت به درگاه';
                            break;
                        case 'nothing':
                            $statusBookFa = 'نامشخص';
                            break;
                        default:
                            $statusBookFa = 'نامشخص';
                            break;
                    }

                    $totalPrice = $book['totalPrice'];
                    $creationDateInt = dateTimeSetting::jdate('Y-m-d (H:i:s)', $book['creation_date_int']);

                    break;
                case 'gasht':

                    $applicationTitleFa = 'گشت و ترانسفر';

                    switch ($book['statusBook']){
                        case 'book':
                            $statusBookFa = 'رزرو قطعی';
                            break;
                        case 'prereserve':
                            $statusBookFa = 'پیش رزرو';
                            break;
                        case 'bank':
                            $statusBookFa = 'هدایت به درگاه';
                            break;
                        case 'nothing':
                            $statusBookFa = 'نامشخص';
                            break;
                        default:
                            $statusBookFa = 'نامشخص';
                            break;
                    }

                    $totalPrice = $book['totalPrice'];
                    $creationDateInt = dateTimeSetting::jdate('Y-m-d (H:i:s)', $book['creation_date_int']);

                    break;
                case 'tour':

                    $applicationTitleFa = 'تور رزرواسیون';

                    if ($book['totalPriceA'] == 0 && $book['statusBook'] == 'BookedSuccessfully') {
                        $statusBookFa = 'رزرو قطعی';
                    } elseif ($book['totalPriceA'] > 0 && $book['totalPriceA'] == $book['totalPaymentPriceA'] && $book['statusBook'] == 'BookedSuccessfully'){
                        $statusBookFa = 'رزرو قطعی';
                    } elseif ($book['totalPriceA'] > 0 && $book['totalPriceA'] > $book['totalPaymentPriceA'] && $book['statusBook'] == 'BookedSuccessfully'){
                        $statusBookFa = 'رزرو قطعی  ( بدون پرداخت مبلغ ارزی)';
                    } elseif ($book['statusBook'] == 'PreReserve'){
                        $statusBookFa = 'پیش رزرو (تایید شده توسط کانتر)';
                    } elseif ($book['statusBook'] == 'TemporaryReservation'){
                        $statusBookFa = 'رزرو موقت (پرداخت مبلغ پیش رزرو)';
                    } elseif ($book['statusBook'] == 'TemporaryPreReserve'){
                        $statusBookFa = 'پیش رزرو موقت';
                    } elseif ($book['statusBook'] == 'bank' && $book['trackingCodeBank'] == ''){
                        $statusBookFa = 'پرداخت اینترنتی نا موفق';
                    } elseif ($book['statusBook'] == 'Cancellation'){
                        $statusBookFa = 'کنسلی';
                    } else {
                        $statusBookFa = 'نامشخص';
                    }

                    $totalPrice = $book['totalPrice'];
                    $creationDateInt =  functions::set_date_payment($book['payment_date']);

                    break;
                default:
                    $applicationTitleFa = '';
                    $statusBookFa = '';
                    $totalPrice = 0;
                    $creationDateInt = '';
                    break;
            }

            $dataRows[$k]['number_column'] = $numberColumn - 1;
            $dataRows[$k]['paymentDate'] = $creationDateInt;
            $dataRows[$k]['paymentTypeFa'] = $paymentTypeFa;
            $dataRows[$k]['factorNumber'] = $book['factorNumber'];
            $dataRows[$k]['agencyName'] = $book['agencyName'];
            $dataRows[$k]['totalPrice'] = $totalPrice;
            $dataRows[$k]['applicationTitleFa'] = $applicationTitleFa;
            $dataRows[$k]['statusBookFa'] = $statusBookFa;


            if (!isset($reportForExcel) || (isset($reportForExcel) && $reportForExcel == 'no')){

                $dataRows[$k]['id'] = $book['id'];
                $dataRows[$k]['applicationTitle'] = $book['applicationTitle'];
                $dataRows[$k]['memberName'] = $book['memberName'];
                $dataRows[$k]['requestNumber'] = $book['requestNumber'];
                $dataRows[$k]['typeApplication'] = $book['typeApplication'];
                $dataRows[$k]['trackingCodeBank'] = $book['trackingCodeBank'];
                $dataRows[$k]['statusBook'] = $book['statusBook'];
                $dataRows[$k]['paymentType'] = $book['paymentType'];

            }



        }

        return $dataRows;


    }

}