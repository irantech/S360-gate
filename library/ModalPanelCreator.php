<?php
require '../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'application.php';
spl_autoload_register(array('Load', 'autoload'));

class ModalPanelCreator
{

    #region variable
    public $Controller;
    public $Param;
    public $Param2;
    public $Param3;
    #endregion

    #region __construct
    public function __construct()
    {
        $this->Controller = filter_var($_POST['Controller'], FILTER_SANITIZE_STRING);
        $Method = filter_var($_POST['Method'], FILTER_SANITIZE_STRING);
        $this->Param = isset($_POST['Param']) ? filter_var($_POST['Param'], FILTER_SANITIZE_STRING) : '';
        $this->Param2 = isset($_POST['Param2']) ? filter_var($_POST['Param2'], FILTER_SANITIZE_STRING) : '';
        $this->Param3 = isset($_POST['Param3']) ? filter_var($_POST['Param3'], FILTER_SANITIZE_STRING) : '';

        self::$Method();
    }
    #endregion

    #region ticketReserveInfo
    public function ticketReserveInfo()
    {
        $user = Load::controller($this->Controller);
        $Tickets = functions::info_flight_client($this->Param);
        $footer = '';

        ob_start();

        foreach ($Tickets as $key => $view) {
            if ($key < 1) {

                if ($view['successfull'] == 'book' && $view['request_cancel'] != 'confirm') {
                    $footer .= '<a target="_blank" href="' . ROOT_ADDRESS . '/eticketLocal&num=' . $view['request_number'] . '" class="btn hide-icon"><i class="fa fa-print"></i><span>پرینت</span></a>';
                    $footer .= '<a target="_blank" href="' . ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=parvazBookingLocal&id=' . $view['request_number'] . '" class="btn hide-icon"><i class="fa fa-file-pdf-o"></i><span>فایل PDF</span></a>';
                    $footer .= '<a target="_blank" href="' . ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=boxCheck&id=' . $view['request_number'] . '" class="btn hide-icon"><i class="fa fa-dollar"></i><span>قبض صندوق</span></a>';
                }
                if ($view['successfull'] == 'book' && $user->copmarDate($view['date_flight'], $view['time_flight']) == 'true') {
                    $footer .= '<a href="javascript:;" onclick="cancelingTicket(\''.$view['request_number'].'\'); return false;" class="btn hide-icon"><i class="fa fa-ban"></i><span>درخواست کنسلی</span></a>';
                }

                ?>
                <div class="row marb20">
                    <div class="col-md-12 text-center text-bold txtRed">
                        <span>مشخصات پرواز</span>
                    </div>
                </div>

                <div class="row marb10">
                    <div class="col-md-4 ">
                        <span>تاریخ <?php echo $view['payment_type'] == 'cash' ? 'پرداخت' : 'خرید'; ?> : </span>
                        <span dir="rtl"><?php echo !empty($view['payment_date']) ? functions::set_date_payment($view['payment_date']) : 'پرداخت نشده' ?></span>
                    </div>
                    <div class="col-md-4 ">
                        <span>تاریخ رزرو بلیط : </span>
                        <span dir="rtl"><?php echo $user->set_date_reserve($view['creation_date']) ?></span></div>
                    <div class="col-md-4 ">
                        <span>شماره واچر :</span>
                        <span><?php echo $view['request_number'] ?></span>
                    </div>
                </div>
                <div class="row marb10">
                    <div class="col-md-4 ">
                        <span>مبدا / مقصد: </span><span><?php echo $view['origin_city'] ?>
                            / <?php echo $view['desti_city'] ?></span>
                    </div>
                    <div class="col-md-4 ">
                        <span>تعداد :</span><span><?php echo $view['CountId']; ?></span>
                    </div>
                    <div class="col-md-4 "><span>تاریخ  و ساعت پرواز:</span>
                        <span> <?php echo $user->format_hour($view['time_flight']) . ' ' . $user->DateJalali($view['date_flight']) ?></span>
                    </div>
                </div>
                <div class="row marb10">
                    <div class="col-md-4 ">
                        <span>نام ایرلاین :</span>
                        <span><?php echo $view['airline_name'] ?></span>
                    </div>
                    <div class="col-md-4 ">
                        <span>کلاس پرواز: </span>
                        <span><?php echo $view['seat_class'] == 'C' ? 'بیزینس' : 'اکونومی' ?> </span>
                    </div>
                    <div class="col-md-4 "><span>نوع پروازی: </span>
                        <span><?php echo $view['flight_type'] == 'system' ? "سیستمی" : "چارتری" ?> </span>
                    </div>
                </div>
                <div class="row marb10">
                    <div class="col-md-4 ">
                        <span>شماره پرواز:</span><span><?php echo $view['flight_number'] ?> </span>
                    </div>
                    <div class="col-md-4 ">
                        <span dir="rtl">شماره pnr :</span><span><?php echo $view['pnr']; ?></span>
                    </div>
                    <div class="col-md-4 "><span>مبلغ :</span>
                        <span> <?php
                            if ($view['percent_discount'] > 0) {
                                echo '<span style="text-decoration: line-through;">' . number_format($user->total_price($view['request_number'])) . '</span>,'
                                    . ' ' . '<span>' . number_format(functions::calcDiscountCodeByFactor(functions::CalculateDiscount($view['request_number']), $view['factor_number'])) . '</span>';
                            } else {
                                echo '<span>' . number_format(functions::calcDiscountCodeByFactor($user->total_price($view['request_number']), $view['factor_number'])) . '</span>';
                            } ?> ریال
                        </span>
                    </div>
                </div>

                <hr />

                <div class="row marb20">
                    <div class="col-md-12 text-center text-bold txtRed">
                        <span>مشخصات مسافرین</span>
                    </div>
                </div>
            <?php } ?>

            <div class="row marb20">
                <div class="col-md-3 ">
                    <span>نام و نام خانوادگی :</span>
                    <span><?php echo $view['passenger_name'] . ' ' . $view['passenger_family'] ?></span>
                </div>
                <div class="col-md-3 ">
                    <span>شماره ملی/پاسپورت:</span>
                    <span><?php echo ($view['passenger_national_code'] != '0000000000') ? $view['passenger_national_code'] : $view['passportNumber'] ?></span>
                </div>
                <div class="col-md-3 ">
                    <span dir="rtl">تاریخ تولد: </span>
                    <span><?php echo (!empty($view['passenger_birthday'])) ? $view['passenger_birthday'] : $view['passenger_birthday_en'] ?></span>
                </div>
                <div class="col-md-3 ">
                    <span dir="rtl">شماره بلیط: </span>
                    <span><?php echo $view['eticket_number']; ?></span>
                </div>
            </div>

            <?php
        }

        $output['result_body'] = ob_get_clean();
        $output['result_header'] = 'مشاهده خرید به شماره رزرو ' . $this->Param;
        $output['result_footer'] = $footer;

        echo json_encode($output);

    }
    #endregion

    #region hotelReserveInfo
    public function hotelReserveInfo()
    {
        $user = Load::controller($this->Controller);
        $Hotel = $user->info_hotel_client($this->Param);
        $footer = '';

        ob_start();

        foreach ($Hotel as $key => $view) {
            if ($key < 1) {

                if ($view['status'] == 'BookedSuccessfully') {
                    $footer .= '<a target="_blank" href="' . ROOT_ADDRESS . '/ehotelLocal&num=' . $view['factor_number'] . '" class="btn hide-icon"><i class="fa fa-print"></i><span>پرینت</span></a>';
                    $footer .= '<a target="_blank" href="' . ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=BookingHotelLocal&id=' . $view['factor_number'] . '" class="btn hide-icon"><i class="fa fa-file-pdf-o"></i><span>فایل PDF فارسی</span></a>';
                    $footer .= '<a target="_blank" href="' . ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookhotelshow&id=' . $view['factor_number'] . '" class="btn hide-icon"><i class="fa fa-file-pdf-o"></i><span>فایل PDF انگلیسی</span></a>';
                }
                if ($view['type_application'] == 'reservation' && $user->checkForEdit($view['status'], $view['start_date']) == 'true') {
                    $footer .= '<a target="_blank" href="' . ROOT_ADDRESS . '/editReserveHotel&id=' . $view['factor_number'] . '" class="btn hide-icon"><i class="fa fa-edit"></i><span>ویرایش رزرو</span></a>';
                }

                ?>
                <div class="row marb20">
                    <div class="col-md-12 text-center text-bold txtRed">
                        <span>مشخصات <?php echo $view['hotel_name'] ?></span>
                    </div>
                </div>

                <div class="row marb20">
                    <div class="col-md-3 ">
                        <span>شهر: </span>
                        <span><?php echo $view['city_name'] ?></span>
                    </div>
                    <div class="col-md-3 ">
                        <span>هتل: </span>
                        <span><?php echo $view['hotel_name'] ?></span>
                    </div>
                    <div class="col-md-3 ">
                        <span>مدت اقامت: </span>
                        <span><?php echo $view['number_night'] ?></span>
                    </div>
                    <div class="col-md-3 ">
                        <span>مبلغ: </span>
                        <span><?php echo number_format(functions::calcDiscountCodeByFactor($view['total_price'], $this->Param)) ?>
                            ریال</span>
                    </div>
                </div>

                <div class="row marb20">
                    <div class="col-md-3 ">
                        <span>تاریخ رزرو هتل: </span>
                        <span dir="rtl"><?php echo $user->set_date_reserve($view['payment_date']) ?></span>
                    </div>
                    <div class="col-md-3 ">
                        <span>تاریخ ورود: </span>
                        <span dir="rtl"><?php echo $view['start_date'] ?></span>
                    </div>
                    <div class="col-md-3 ">
                        <span>تاریخ خروج: </span>
                        <span dir="rtl"><?php echo $view['end_date'] ?></span>
                    </div>
                </div>

                <?php if (isset($view['passenger_name']) && $view['passenger_name'] != '') { ?>
                    <div class="row marb20">
                        <div class="col-md-12 text-center text-bold txtRed">
                            <span>مشخصات مسافران</span>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="row marb20">
                        <div class="col-md-12 text-center text-bold txtRed">
                            <span>سرگروه اتاق: <?php echo $view['passenger_leader_room_fullName'] ?></span>
                        </div>
                    </div>
                <?php } ?>

            <?php } ?>

            <?php if (isset($view['passenger_name']) && $view['passenger_name'] != '') { ?>
                <div class="row marb20">
                    <div class="col-md-3">
                        <span>اتاق: </span><span><?php echo $view['room_name'] ?></span>
                    </div>
                    <div class="col-md-3">
                        <span>نام و نام خانوادگی: </span><span><?php echo $view['passenger_name'] . ' ' . $view['passenger_family'] ?></span>
                    </div>
                    <div class="col-md-3">
                        <span>شماره ملی/پاسپورت: </span><span><?php echo (!empty($view['passenger_national_code'])) ? $view['passenger_national_code'] : $view['passportNumber'] ?></span>
                    </div>
                    <div class="col-md-3">
                        <span>تاریخ تولد: </span><span
                                dir="rtl"><?php echo (!empty($view['passenger_birthday'])) ? $view['passenger_birthday'] : $view['passenger_birthday_en'] ?></span>
                    </div>
                </div>
            <?php } else { ?>
                <div class="row marb20">
                    <div class="col-md-12">
                        <span>اتاق: </span><span><?php echo $view['room_name'] ?></span>
                    </div>
                </div>
            <?php } ?>

        <?php } ?>

        <?php if ($Hotel[0]['type_application'] == 'reservation' && $Hotel[0]['origin'] != '') { ?>
        <div class="row marb20">
            <div class="col-md-12 text-center text-bold txtRed">
                <span>اطلاعات سفر</span>
            </div>
        </div>

        <div class="row marb20">
            <div class="col-md-6">
                <span>مبدا: </span><span></span>
            </div>
            <div class="col-md-6">
                <span>مقصد: </span><span><?php echo $Hotel[0]['origin'] ?></span>
            </div>
        </div>

        <div class="row marb20">
            <div class="col-md-3"><span>نام وسیله حمل و نقل: </span><span><?php echo $Hotel[0]['airline_went'] ?></span>
            </div>
            <div class="col-md-3"><span>شماره پرواز : </span><span><?php echo $Hotel[0]['flight_number_went'] ?></span>
            </div>
            <div class="col-md-3"><span>ساعت حرکت : </span><span><?php echo $Hotel[0]['hour_went'] ?></span></div>
            <div class="col-md-3"><span>تاریخ رفت : </span><span><?php echo $Hotel[0]['flight_date_went'] ?></span>
            </div>
        </div>

        <div class="row marb20">
            <div class="col-md-3"><span>نام وسیله حمل و نقل: </span><?php echo $Hotel[0]['airline_back'] ?><span></span>
            </div>
            <div class="col-md-3"><span>شماره پرواز : </span><span><?php echo $Hotel[0]['flight_number_back'] ?></span>
            </div>
            <div class="col-md-3"><span>ساعت برگشت : </span><span><?php echo $Hotel[0]['hour_back'] ?></span></div>
            <div class="col-md-3"><span>تاریخ برگشت : </span><span><?php echo $Hotel[0]['flight_date_back'] ?></span>
            </div>
        </div>
    <?php } ?>

        <?php if ($Hotel[0]['type_application'] == 'reservation' && $user->showOneDayTour == 'True') { ?>
        <div class="row marb20">
            <div class="col-md-12 text-center text-bold txtRed">
                <span>مشخصات تور یک روزه</span>
            </div>
        </div>

        <?php foreach ($user->listOneDayTour as $val) { ?>
            <div class="row marb20">
                <div class="col-md-6">
                    <span>عنوان: </span><span><?php echo $val['title'] ?></span>
                </div>
                <div class="col-md-6">
                    <span>قیمت: </span><span><?php echo number_format($val['price']) ?> ریال</span>
                </div>
            </div>
        <?php }
    }

        $output['result_body'] = ob_get_clean();
        $output['result_header'] = 'مشاهده خرید به شماره رزرو ' . $this->Param;
        $output['result_footer'] = $footer;

        echo json_encode($output);

    }
    #endregion

    #region insuranceReserveInfo
    public function insuranceReserveInfo()
    {
        $user = Load::controller($this->Controller);
        $records = $user->info_insurance_client($this->Param);

        ob_start();

        foreach ($records as $key => $view) {
            if ($key < 1) {
                ?>

                <div class="row marb20">
                    <div class="col-md-12 text-center text-bold txtRed">
                        <span>مشخصات بیمه نامه <?php echo $view['source_name_fa']; ?></span>
                    </div>
                </div>

                <div class="row marb20">
                    <div class="col-md-4 ">
                        <span>تاریخ <?php echo $view['payment_type'] == 'cash' ? 'پرداخت' : 'خرید'; ?> : </span>
                        <span dir="ltr"><?php echo $view['payment_date'] != '0000-00-00 00:00:00' ? functions::set_date_payment($view['payment_date']) : 'پرداخت نشده'; ?></span>
                    </div>
                    <div class="col-md-4 ">
                        <span dir="rtl">تاریخ رزرو بیمه نامه : </span>
                        <span style=''><?php echo $user->set_date_reserve(substr($view['creation_date'], 0, 10)) ?></span>
                    </div>
                    <div class="col-md-4 ">
                        <span>مقصد: </span>
                        <span><?php echo $view['destination'] ?></span>
                    </div>
                </div>
                <div class="row marb20">
                    <div class="col-md-4 ">
                        <span>تعداد :</span>
                        <span style=''><?php echo $user->count; ?></span>
                    </div>
                    <div class="col-md-4 ">
                        <span>مدت سفر:</span>
                        <span> <?php echo $view['duration'] ?> روز</span></div>
                    <div class="col-md-4 ">
                        <span>مبلغ :</span>
                        <span> <?php echo number_format(functions::calcDiscountCodeByFactor($user->total_price_insurance($view['factor_number']), $view['factor_number'])) ?>
                            ریال</span>
                    </div>
                </div>

                <hr />

                <div class="row marb20">
                    <div class="col-md-12 text-center text-bold txtRed">
                        <span>مشخصات مسافرین</span>
                    </div>
                </div>
            <?php } ?>

            <div class="row marb20">
                <div class="col-md-3 ">
                    <span>نام و نام خانوادگی: </span>
                    <span><?php echo $view['passenger_name'] . ' ' . $view['passenger_family'] ?></span>
                </div>
                <div class="col-md-3 ">
                    <span>پاسپورت: </span>
                    <span><?php echo $view['passport_number'] ?></span>
                </div>
                <div class="col-md-3 ">
                    <span>تاریخ تولد: </span>
                    <span dir="rtl"><?php echo (!empty($view['passenger_birth_date'])) ? $view['passenger_birth_date'] : $view['passenger_birth_date_en'] ?></span>
                </div>
                <div class="col-md-3 ">
                    <span>دریافت بیمه نامه: </span>
                    <span>
                    <?php if ($view['status'] == 'book') { ?>
                        <a href="<?php echo $user->get_insurance_pdf($view['source_name'], $view['pnr']) ?>"
                           target="_blank"><i class="fa fa-print"></i></a>
                    <?php } else {
                        echo 'ـــــ';
                    } ?>
                    </span>
                </div>
            </div>

            <?php
        }

        $output['result_body'] = ob_get_clean();
        $output['result_header'] = 'مشاهده خرید به شماره فاکتور ' . $this->Param;
        $output['result_footer'] = '';

        echo json_encode($output);

    }
    #endregion

    #region canceledTicketInfo
    public function canceledTicketInfo()
    {
        $user = Load::controller($this->Controller);
        $InfoCancelTicket = $user->ShowInfoModalTicketCancel($this->Param, $this->Param2);

        ob_start();

        ?>

        <div class="row marb20">
            <div class="col-md-12 text-center text-bold txtRed">
                <span>لیست مسافرین</span>
            </div>
        </div>

        <?php
        foreach ($InfoCancelTicket as $i => $info) {

            if ($i < 1) {
                ?>
                <input type="hidden" value="<?php echo $info['factor_number'] ?>" name="FactorNumber" id="FactorNumber" />
                <input type="hidden" value="<?php echo $info['member_id'] ?>" name="MemberId" id="MemberId" />
                <?php
            }
            ?>
            <div class="row marb20">
                <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                    <span>نام و نام خانوادگی: </span>
                    <?php
                    switch ($info['passenger_age']) {
                        case 'Adt':
                            $type = 'بزرگسال';
                            break;

                        case 'Chd':
                            $type = 'کودک';
                            break;

                        case 'Inf':
                            $type = 'نوزاد';
                            break;
                    }
                    ?>
                    <span><?php echo $info['passenger_name'] . ' ' . $info['passenger_family'] . ' (' . $type . ')'; ?></span>
                </div>
                <div class="col-md-3  col-lg-3 col-sm-12 col-xs-12">
                    <span>شماره ملی/پاسپورت: </span><span><?php echo ($info['passenger_national_code'] != '0000000000') ? $info['passenger_national_code'] : $info['passportNumber'] ?></span>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12 ">
                    <span>تاریخ تولد: </span>
                    <span><?php echo (!empty($info['passenger_birthday'])) ? $info['passenger_birthday'] : $info['passenger_birthday_en'] ?></span>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <span>وضعیت: </span>
                    <?php
                    switch ($info['Status']) {
                        case 'RequestMember' :
                            echo !empty($info['NationalCode']) ? 'درخواست کاربر' : '';
                            break;
                        case 'SetCancelClient' :
                            echo !empty($info['NationalCode']) ? 'رد درخواست ' : '';
                            break;
                        case 'RequestClient' :
                            echo !empty($info['NationalCode']) ? 'در حال بررسی ' : '';
                            break;
                        case 'SetIndemnity' :
                            echo !empty($info['NationalCode']) ? 'در حال بررسی ' : '';
                            break;
                        case 'SetFailedIndemnity' :
                            echo !empty($info['NationalCode']) ? 'رد درخواست ' : '';
                            break;
                        case 'ConfirmClient' :
                            echo !empty($info['NationalCode']) ? 'در حال بررسی' : '';
                            break;
                        case 'ConfirmCancel' :
                            echo !empty($info['NationalCode']) ? 'تایید درخواست' : '';
                            break;
                    }
                    ?>
                </div>
            </div>

            <?php

            /*switch ($info['Status']) {
                        case 'RequestMember' :
                            echo !empty($info['NationalCode']) ? 'btn btn-primary' : '';
                            break;
                        case 'SetCancelClient' :
                            echo !empty($info['NationalCode']) ? 'btn btn-danger' : '';
                            break;
                        case 'RequestClient' :
                            echo !empty($info['NationalCode']) ? 'btn btn-warning' : '';
                            break;
                        case 'SetIndemnity' :
                            echo !empty($info['NationalCode']) ? 'btn btn-warning' : '';
                            break;
                        case 'SetFailedIndemnity' :
                            echo !empty($info['NationalCode']) ? 'btn btn-danger' : '';
                            break;
                        case 'ConfirmClient' :
                            echo !empty($info['NationalCode']) ? 'btn btn-warning' : '';
                            break;
                        case 'ConfirmCancel' :
                            echo !empty($info['NationalCode']) ? 'btn btn-success' : '';
                            break;
                    }*/

        }
        ?>

        <div class="row marb20">
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                شماره درخواست خرید:<?php echo $info['RequestNumber']; ?>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                <span style="float: right">تاریخ درخواست کنسلی :</span> <?php echo dateTimeSetting::jdate('Y-m-d (H:i:s)', $info['DateRequestMemberInt']); ?>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                تاریخ تایید /رد درخواست :<?php
                if ($info['DateSetCancelInt'] != '0' || $info['DateConfirmCancelInt'] != '0' || $info['DateSetFailedIndemnityInt'] != '0') {
                    if ($info['Status'] == 'SetCancelClient') {
                        echo dateTimeSetting::jdate('Y-m-d (H:i:s)', $info['DateSetCancelInt']);
                    } else if ($info['Status'] == 'ConfirmCancel') {
                        echo dateTimeSetting::jdate('Y-m-d (H:i:s)', $info['DateConfirmCancelInt']);
                    } else if ($info['Status'] == 'SetFailedIndemnity') {
                        echo dateTimeSetting::jdate('Y-m-d (H:i:s)', $info['DateConfirmCancelInt']);
                    } else {
                        echo ' -----';
                    }
                } else {
                    echo ' -----';
                }
                ?>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                درصد جریمه:<?php
                if ($info['Status'] == 'ConfirmCancel') {
                    echo $info['PercentIndemnity'] . '%';
                } else {
                    echo ' -----';
                }
                ?>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                مبلغ استرداد:<?php
                if ($info['Status'] == 'ConfirmCancel') {
                    echo number_format($info['PriceIndemnity']) . 'ریال';
                } else {
                    echo ' -----';
                }
                ?>
            </div>

            <?php if ($info['Status'] == "SetCancelClient"): ?>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    توضیحات:<?php
                    if (!empty($InfoCancelTicket[0]['DescriptionClient'])) {
                        ?>
                        <span><?php echo $InfoCancelTicket[0]['DescriptionClient']; ?></span>
                        <?php
                    } else {
                        ?>
                        <span>-------</span>
                        <?php
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if (functions::TypeUser(CLIENT_ID) == 'Ponline') {
            ?>
            <div class="row marb20">
                <div class="col-md-3 col-lg-4 col-sm-12 col-xs-12">شماره کارت اعلام
                 شده:<span><?php echo $InfoCancelTicket[0]['CardNumber'] ?></span></div>
                <div class="col-md-3 col-lg-4 col-sm-12 col-xs-12">نام صاحب
                حساب:<span><?php echo $InfoCancelTicket[0]['AccountOwner'] ?></span></div>
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">نام بانک مرتبط با
                کارت:<span><?php echo $InfoCancelTicket[0]['NameBank'] ?></span></div>
            </div>
        <?php }

        $output['result_body'] = ob_get_clean();
        $output['result_header'] = 'مشاهده درخواست کنسلی رزرو به شماره ' . $this->Param;
        $output['result_footer'] = '';

        echo json_encode($output);

    }
    #endregion

    #region cancelingTicketByUser
    public function cancelingTicketByUser()
    {
        $user = Load::controller($this->Controller);
        $InfoCancelTicket = $user->InfoModalTicketCancel($this->Param);

        ob_start();

        ?>

        <div class="row marb20">
            <div class="col-md-12 text-center text-bold txtRed">
                <span>لطفا مسافر مورد نظر را انتخاب کنید</span>
            </div>
        </div>

        <?php
        foreach ($InfoCancelTicket as $i => $info) {
            if ($i < 1) {
                ?>
                <input type="hidden" value="<?php echo $info['factor_number'] ?>" name="FactorNumber" id="FactorNumber" />
                <input type="hidden" value="<?php echo $info['member_id'] ?>" name="MemberId" id="MemberId" />
                <?php
            }
            ?>
            <div class="row marb20">
                <div class="col-md-4 col-sm-12">
                    <span>
                        <input class="SelectUser" type="checkbox" name="SelectUser[]" id="SelectUser"
                            value="<?php echo ($info['passenger_national_code'] != '0000000000') ? $info['passenger_national_code'] . '-' . $info['passenger_age'] : $info['passportNumber'] . '-' . $info['passenger_age'] ?>"
                            <?php echo (!empty($info['Status']) && !empty($info['NationalCode']) && $info['Status'] != 'SetCancelClient') ? 'disabled ="disabled"' : ''; ?> />
                    </span>
                    <?php
                    switch ($info['passenger_age']) {
                        case 'Adt':
                            $type = 'بزرگسال';
                            break;

                        case 'Chd':
                            $type = 'کودک';
                            break;

                        case 'Inf':
                            $type = 'نوزاد';
                            break;
                    }
                    ?>
                    <span><?php echo $info['passenger_name'] . ' ' . $info['passenger_family'] . ' (' . $type . ')'; ?></span>
                </div>
                <div class="col-md-3 col-sm-12">
                    <span>شماره ملی/پاسپورت:</span>
                    <span><?php echo ($info['passenger_national_code'] != '0000000000') ? $info['passenger_national_code'] : $info['passportNumber'] ?></span>
                </div>
                <div class="col-md-2 col-sm-12">
                    <span>تاریخ تولد: </span>
                    <span dir="rtl"><?php echo (!empty($info['passenger_birthday'])) ? $info['passenger_birthday'] : $info['passenger_birthday_en'] ?></span>
                </div>

                <div class="col-md-3 col-sm-12">
                    <?php
                    if (!empty($info['Status']) && !empty($info['NationalCode']) && $info['Status'] != 'nothing') {
                        if ($info['Status'] == 'SetCancelClient') {
                            ?>
                            <span class="btn btn-danger"> درخواست رد شده است</span>
                            <?php
                        } else {
                            ?>
                            <span class="btn btn-warning">قبلا اقدام شده است</span>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>

        <?php if (functions::TypeUser(CLIENT_ID) == 'Ponline') { ?>

            <hr />

            <div class="row marb20">
                <div class="col-md-12 text-center text-bold txtRed">
                    <span>لطفا اطلاعات خود را بابت برگشت پول به حسابتان وارد نمائید</span>
                </div>
            </div>

            <div class="row marb20">
                <div class="col-md-4 col-sm-12">
                    <label>شماره کارت بانکی</label>
                    <input class="form-control " type="text" id="CardNumber" name="CardNumber">
                </div>
                <div class="col-md-4 col-sm-12">
                    <label>نام صاحب حساب</label>
                    <input class="form-control" type="text" id="AccountOwner" name="AccountOwner">
                </div>
                <div class="col-md-4 col-sm-12">
                    <label>نام بانک کارت</label>
                    <input class="form-control " type="text" id="NameBank" name="NameBank">
                </div>
            </div>
        <?php } ?>

        <hr />

        <div class="row marb20">
            <div class="col-md-12 text-center text-bold txtRed">
                <span>لطفا گزینه های مد نظر خود را انتخاب نمائید</span>
            </div>
        </div>

        <div class="row marb20">
            <div class="col-md-3 col-sm-12">
                <select class="form-control" name="ReasonUser" onchange="SelectReason(this)" id="ReasonUser">
                    <option value=""> دلیل کنسلی را انتخاب کنید...</option>
                    <option value="PersonalReason">کنسلی به دلایل شخصی</option>
                    <option value="DelayTwoHours">تاخیر بیش از 2 ساعت</option>
                    <option value="CancelByAirline">لغو پررواز توسط ایرلاین</option>
                </select>
            </div>
            <div class="col-md-5 col-sm-12 mart10">
                <input type="checkbox" id="PercentNoMatter" name="PercentNoMatter" />   برای من درصد جریمه اهمیتی ندارد ،لطفا سریعا کنسل گردد
            </div>
            <div class="col-md-4 col-sm-12 mart10">
                <input type="checkbox" id="Ruls" name="Ruls">  اینجانب
                <a href="<?php echo URL_RULS ?>" style="margin-top: 5px">قوانین</a> را مطالعه کرده ام و اعتراضی ندارم
            </div>
            <div class="col-md-12">
                <div class="DescriptionReason showContentTextModal" style="display : none"></div>
            </div>
        </div>

        <?php

        $output['result_body'] = ob_get_clean();
        $output['result_header'] = 'کنسل کردن خرید به شماره رزرو ' . $this->Param;
        $output['result_footer'] = '<button type="button" class="btn hide-icon" onclick="selectUserToCancel(\'' . $this->Param . '\')"><i class="fa fa-check"></i><span>ارسال اطلاعات</span></button>';

        echo json_encode($output);

    }
    #endregion

}
/**
 * این کلاس چون از طریق جاوا اسکریپت فراخوانی میشود
 * همین جا صدا زده شده
 * لطفا پاک نشود
 */
new ModalPanelCreator();
?>