<?php

class hotelVoucherAhuan
{
    public $payment_date = '';
    public $okHotel = '';
    public $type_application = '';
    public $hotel_id = '';
    public $room_id = '';
    public $start_date = '';
    public $end_date = '';
    public $hotelId = '';
    public $room_count = array();
    public $errorMessage = '';

    public function __construct()
    {

    }

    public function set_time_payment($date)
    {

        $date_orginal_exploded = explode(' ', $date);
        return $date_orginal_exploded[1];
    }

    public function set_date_reserve($date)
    {
        $date_orginal_exploded = explode(' ', $date);
        $date_miladi_exp = explode('-', $date_orginal_exploded[0]);
        return dateTimeSetting::gregorian_to_jalali($date_miladi_exp[0], $date_miladi_exp[1], $date_miladi_exp[2], '/');
    }

    public function formatTime($time)
    {
        $time1 = substr($time, '0', '2');
        $time2 = substr($time, '2', '4');
        $subject = array('H', 'M');
        $time2 = str_replace($subject, ':', $time2);
        return $time1 . $time2;
    }

    public function format_hour($num)
    {
        $time = date("H:i", strtotime($num));
        return $time;
    }

    public function createPdfContent($factorNumber)
    {
        $objResult = Load::controller('resultHotelLocal');
        $info_hotel = $objResult->getHotelDataNew($factorNumber);

        $printBoxCheck = '';
        $printBoxCheck .= ' <!DOCTYPE html>
                <html>
                    <head>
                        <meta charset="UTF-8">
                        <title>مشاهده فایل pdf هتل</title>
                    </head>
                    
                    <style type="text/css">
                        @font-face{
                            font-family:persian-number;
                            font-style:normal;
                            font-weight:bold;
                            src:url("../view/client/assets/fonts/iranyekanwebbold(fanum).eot");
                            src:url("../view/client/assets/fonts/iranyekanwebbold(fanum).eot?#iefix") format("embedded-opentype"),
                            url("../view/client/assets/fonts/woff2/iranyekanwebbold(fanum).woff2") format("woff2"),
                            url("../view/client/assets/fonts/iranyekanwebbold(fanum).woff") format("woff"),
                            url("../view/client/assets/fonts/iranyekanwebbold(fanum).ttf") format("truetype")
                        }
                        @font-face{
                            font-family:persian-number;
                            font-style:normal;
                            font-weight:300;
                            src:url("../view/client/assets/fonts/iranyekan/number/eot/iranyekanweblight(fanum).eot");
                            src:url("../view/client/assets/fonts/iranyekan/number/eot/iranyekanweblight(fanum).eot?#iefix") format("embedded-opentype"),
                            url("../view/client/assets/fonts/iranyekan/number/woff2/iranyekanweblight(fanum).woff2") format("woff2"),
                            url("../view/client/assets/fonts/iranyekanweblight(fanum).woff") format("woff"),
                            url("../view/client/assets/fonts/iranyekanweblight(fanum).ttf") format("truetype")
                        }
                        @font-face{
                            font-family:persian-number;
                            font-style:normal;
                            font-weight:normal;
                            src:url("../view/client/assets/fonts/iranyekanwebregular(fanum).eot");
                            src:url("../view/client/assets/fonts/iranyekanwebregular(fanum).eot?#iefix") format("embedded-opentype"),
                            url("../view/client/assets/fonts/iranyekanwebregular(fanum).woff2") format("woff2"),
                            url("../view/client/assets/fonts/iranyekanwebregular(fanum).woff") format("woff"),
                            url("../view/client/assets/fonts/iranyekanwebregular(fanum).ttf") format("truetype")
                        }
                        @font-face{
                            font-family:iranyekan;
                            font-style:normal;
                            font-weight:bold;
                            src:url("../view/client/assets/fonts/iranyekanwebbold.eot");
                            src:url("../view/client/assets/fonts/iranyekanwebbold.eot?#iefix") format("embedded-opentype"),
                            url("../view/client/assets/fonts/iranyekanwebbold.woff2") format("woff2"),
                            url("../view/client/assets/fonts/iranyekanwebbold.woff") format("woff"),
                            url("../view/client/assets/fonts/iranyekanwebbold.ttf") format("truetype")
                        }
                        @font-face{
                            font-family:iranyekan;
                            font-style:normal;
                            font-weight:300;
                            src:url("../view/client/assets/fonts/iranyekanweblight.eot");
                            src:url("../view/client/assets/fonts/iranyekanweblight.eot?#iefix") format("embedded-opentype"),
                            url("../view/client/assets/fonts/iranyekanweblight.woff2") format("woff2"),
                            url("../view/client/assets/fonts/iranyekanweblight.woff") format("woff"),
                            url("../view/client/assets/fonts/iranyekanweblight.ttf") format("truetype")
                        }
                        @font-face{
                            font-family:iranyekan;
                            font-style:normal;
                            font-weight:normal;
                            src:url("../view/client/assets/fonts/iranyekanwebregular.eot");
                            src:url("../view/client/assets/fonts/iranyekanwebregular.eot?#iefix") format("embedded-opentype"),
                            url("../view/client/assets/fonts/iranyekanwebregular.woff2") format("woff2"),
                            url("../view/client/assets/fonts/iranyekanwebregular.woff") format("woff"),
                            url("../view/client/assets/fonts/iranyekanwebregular.ttf") format("truetype")
                        }
                        
                        body {
                            font-family:iranyekan , persian-number;
                        }
                    </style>
                    
                    <body>';
        $printBoxCheck .= '<div style="margin:30px auto 0;background-color: #fff;line-height: 20px;">
                                <div style="margin:30px auto 0;background-color: #fff;">';

        if (!empty($info_hotel)) {

            if ($info_hotel[0]['hotel_id'] == '2'){

                $cityName = 'بابلسر';
                $title = 'هتل آپارتمان آهوان - شماره2 ';

            } else if ($info_hotel[0]['hotel_id'] == '1'){

                $cityName = 'چابکسر';
                $title = 'هتل آپارتمان آهوان - 4 ستاره';
            }



            $printBoxCheck .= '<div class="main">
            <div style="top: 0;width: 100%;display: block;padding: 0;margin: 5px 5px;height: auto !important;">
                ';

            $printBoxCheck .= '
                <table style="width: 100%;
                                display: table;
                                height: 100px !important;
                                font-weight: bold;
                                margin-top: 12px;
                                height: 80px;
                                font-family: IRANSansBold, IRANSansNumber;">
                    <tr>
                        <td style="text-align: right;width: 25%;padding-right: 20px;">
                            <img src="' . FRONT_CURRENT_THEME . 'project_files/images/logoAhuan.png" title="آهوان" alt="آهوان" border="0" height="80px" whith="45px">
                        </td>
                        
                        <td style="text-align: center;width: 50%;font-size: 25px;line-height: 30px;">
                            <table style="
                                text-align: center;
                                width: 100%;
                                display: table;
                                direction: rtl;">
                                <tr style="height: 33px;">
                                    <td>' . $title. ' - ' . $cityName . '</td>                           
                                </tr>
                                <tr style="height: 33px;">
                                    <td>برگه رزرواسیون (هتل واچر)</td>
                                </tr>
                                <tr style="height: 33px;">
                                </tr>
                            </table>
                        </td>
                        <td style="text-align: left;width: 25%;">
                            <table style="
                                text-align: right;
                                width: 100%;
                                display: table;">
                                <tr>
                                    <td>شماره واچر: </td>                           
                                    <td style="text-align: left;font-family:iranyekan , persian-number;">' . $info_hotel[0]['factor_number'] . '</td>                           
                                </tr>
                                <tr>
                                    <td>تاریخ صدور: </td>
                                    <td style="text-align: left;font-family:iranyekan , persian-number;">';
                                $printBoxCheck .= functions::set_date_payment($info_hotel[0]['payment_date']);
                                $printBoxCheck .= '
                                    </td>
                                </tr>
                            </table>
                        <td>
                            
                        </td>
                    </tr>
                </table>
                <br>
            ';

            $printBoxCheck .= '
            <div class="container">

            <table style="border-collapse: collapse;text-align: right;width: 99%;font-size: 15px;line-height: 25px;" border="1">
                <tr>
                    <td colspan="4">';
            $printBoxCheck .='
                        <span style="width: 50%;float: right;">  خواهشمند است اتاقهای ذیل در اختیار خانم/آقای/شرکت</span>
                        <span style="font-family: IRANSansBold, IRANSansNumber;
                            font-weight: bold;width: 33.333333%;float: right;"> '. $info_hotel[0]['passenger_leader_room_fullName']. ' </span>
                        <span style="width: 16.666667%;float: right;">قرار گیرد.</span>';
            $printBoxCheck .='
                    </td>
                </tr>
                <tr>
                    <td width="25%"><span>تلفن منزل: </span><span>------------</span></td>
                    <td width="25%"><span>نمابر: </span><span>------------</span></td>
                    <td width="25%"><span>موبایل: </span><span>'.$info_hotel[0]['passenger_leader_room'].'</span></td>
                    <td width="25%"><span>تلفن محل کار: </span><span>------------</span></td>
                </tr>
                <tr>
                    <td width="25%"><span>نوع مسافر: </span><span>مسافرآنلاین</span></td>
                    <td width="25%"><span>شماره شناسایی: </span><span>------------</span></td>
                    <td width="25%"><span>شماره عضویت: </span><span>------------</span></td>
                    <td width="25%"><span>تعداد شب رایگان: </span><span>0</span></td>
                </tr>
                <tr>
                    <td width="25%"><span>تاریخ ورود: </span><span>'.$info_hotel[0]['start_date'].'</span></td>
                    <td width="25%"><span>تاریخ خروج: </span><span>'.$info_hotel[0]['end_date'].'</span></td>
                    <td width="25%"><span>تعداد شب: </span><span>'.$info_hotel[0]['number_night'].'</span></td>
                    <td width="25%"><span>تعداد کل نفرات: </span><span>'.$objResult->countHotel.'</span></td>
                </tr>
                <tr>
                    <td colspan="2"><span>آدرس: </span><span>------------------------------</span></td>
                    <td colspan="4"><span>ایمیل: </span><span>-----------------------------</span></td>
                </tr>
            </table>
            <br>
            <div style="clear: both;"></div>
            ';

            $printBoxCheck .= '
            <table style="text-align: center;width: 99%;display: table;
                    font-size: 15px;line-height: 30px;padding: 0 10px;
                    font-family: IRANSansBold, IRANSansNumber;font-weight: bold;">
                <tr><td>
                (ساعت تحویل واحد از ساعت (2) بعدازظهر به بعد و ساعت تخلیه اتاق در ساعت (10) صبح می باشد.)
                </td></tr>
            </table>
            <div style="clear: both;"></div>
            ';

            $printBoxCheck .= '
            <table style="border-collapse: collapse;width: 99%;font-size: 15px;text-align: center;border: 1px solid;line-height: 25px;">';

            $printBoxCheck .= '
                <tr style="font-family: IRANSansLight, IRANSansNumber;
                        color: #000;
                        font-weight: normal;
                        padding: 3px 0 0;
                        text-align: right;">
                    <td style="width: 20%;border-left: 1px solid;">شرایط اقساط</td>
                    <td style="width: 18%;border-left: none;text-align: right;">پیش قسط:</td>
                    <td style="width: 8%;border-left: none;text-align: right;">ریال</td>
                    <td style="width: 18%;border-left: none;text-align: right;">الباقی اقساط:</td>
                    <td style="width: 10%;border-left: none;text-align: right;">ریال</td>
                    <td style="width: 18%;border-left: none;text-align: right;">هزینه کارمزد:</td>
                    <td style="width: 8%;border-left: 1px solid;text-align: right;">ریال</td>
                </tr>
                ';


            $printBoxCheck .= '
                <tr style="font-family: IRANSansBold, IRANSansNumber;
                        color: #000;
                        font-weight: bold;
                        padding: 3px 0 0;
                        border: 1px solid;
                        text-align: center;">
                    <td style="width: 20%;border-left: 1px solid;">نوع واحد</td>
                    <td style="width: 18%;border-left: 1px solid;">نوع اتاق</td>
                    <td style="width: 14%;border-left: 1px solid;">شماره اتاق</td>
                    <td style="width: 8%;border-left: 1px solid;">تعداد واحد</td>
                    <td style="width: 8%;border-left: 1px solid;">تعداد شب</td>
                    <td style="width: 16%;border-left: 1px solid;font-size: 12px;">فی (هرشب) با احتساب مالیات بر ارزش افزوده (ریال)</td>
                    <td style="width: 16%;border-left: 1px solid;">مبلغ (ریال)</td>
                </tr>
                ';

                $rooms = $objResult->getInfoRoomHotelForPrint($info_hotel[0]['factor_number']);

                foreach ($rooms['room'] as $item){

                    $night = $item['number_night'];
                    $expRoomName = explode("-", $item['room_name']);
                    $flatType = $expRoomName[1];
                    $roomName = $expRoomName[0];

                    $printBoxCheck .= '
                    <tr style="border: 1px solid;">
                        <td style="border-left: 1px solid;">'.$roomName.'</td>
                        <td style="border-left: 1px solid;">'.$flatType.'</td>
                        <td style="border: 1px solid;"></td>
                        <td style="border: 1px solid;">'.$item['room_count'].'</td>
                        <td style="border: 1px solid;">'.$item['number_night'].'</td>
                        <td style="border: 1px solid;">'.number_format($item['price_current']).'</td>
                        <td style="border: 1px solid;">'.number_format($item['room_price']).'</td>
                    </tr>';

                    /*foreach ($item['bed'] as $bed){

                        $expRoomName = explode("-", $bed['room_name']);
                        $roomName = $expRoomName[0];

                        $printBoxCheck .= '
                        <tr style="border: 1px solid;">
                            <td style="border: 1px solid;">'.$roomName.'</td>
                            <td style="border: 1px solid;">'.$bed['flat_type'].'</td>
                            <td style="border: 1px solid;"></td>
                            <td style="border: 1px solid;">'.$bed['room_count'].'</td>
                            <td style="border: 1px solid;">'.$bed['number_night'].'</td>
                            <td style="border: 1px solid;">'.number_format($bed['price_current']).'</td>
                            <td style="border: 1px solid;">'.number_format($bed['room_price']).'</td>
                        </tr>';
                    }*/

                }

            $printBoxCheck .= '
                <tr style="font-family: IRANSansBold, IRANSansNumber;
                        color: #000;
                        font-weight: bold;
                        padding: 3px 0 0;
                        border: none;
                        text-align: center;">
                    <td style="width: 20%;border: none;"></td>
                    <td style="width: 18%;border: none;"></td>
                    <td style="width: 14%;border: none;"></td>
                    <td style="width: 8%;border: none;"></td>
                    <td style="width: 8%;border: none;"></td>
                    <td style="width: 16%;border: none;"></td>
                    <td style="width: 16%;border: none"></td>
                </tr>
                ';

            $printBoxCheck .= '
                <tr style="font-family: IRANSansBold, IRANSansNumber;
                        color: #000;
                        font-weight: bold;
                        padding: 3px 0 0;
                        border: 1px solid;
                        text-align: center;">
                    <td style="width: 20%;border-left: 1px solid;">تعداد تخت اضافی</td>
                    <td style="width: 18%;border-left: 1px solid;">'.$rooms['count_EXT'].' عدد</td>
                    <td style="width: 14%;border-left: 1px solid;">........</td>
                    <td style="width: 8%;border-left: 1px solid;">........</td>
                    <td style="width: 8%;border-left: 1px solid;">';
            if ($rooms['count_EXT'] > 0){
                $printBoxCheck .= $night;
            }
            $printBoxCheck .= '</td>
                    <td style="width: 16%;border-left: 1px solid;font-size: 12px;"></td>
                    <td style="width: 16%;border-left: 1px solid;">'.number_format($rooms['price_EXT']).'</td>
                </tr>
                ';

            $printBoxCheck .= '
                <tr style="font-family: IRANSansBold, IRANSansNumber;
                        color: #000;
                        font-weight: bold;
                        padding: 3px 0 0;
                        border: 1px solid;
                        text-align: center;">
                    <td style="width: 20%;border-left: 1px solid;">تعداد وسیله خواب زمینی</td>
                    <td style="width: 18%;border-left: 1px solid;">........ عدد</td>
                    <td style="width: 14%;border-left: 1px solid;">........</td>
                    <td style="width: 8%;border-left: 1px solid;">........</td>
                    <td style="width: 8%;border-left: 1px solid;">........</td>
                    <td style="width: 16%;border-left: 1px solid;font-size: 12px;"></td>
                    <td style="width: 16%;border-left: 1px solid;">........</td>
                </tr>
                ';

            $printBoxCheck .= '
                <tr style="font-family: IRANSansBold, IRANSansNumber;
                        color: #000;
                        font-weight: bold;
                        padding: 3px 0 0;
                        border: 1px solid;
                        text-align: center;">
                    <td style="width: 20%;border-left: 1px solid;">تعداد کودک زیر 6 سال</td>
                    <td style="width: 18%;border-left: 1px solid;">'.$rooms['count_ECHD'].' نفر</td>
                    <td style="width: 14%;border-left: 1px solid;">........</td>
                    <td style="width: 8%;border-left: 1px solid;">........</td>
                    <td style="width: 8%;border-left: 1px solid;">';
            if ($rooms['count_EXT'] > 0){
                $printBoxCheck .= $night;
            }
            $printBoxCheck .= '</td>
                    <td style="width: 16%;border-left: 1px solid;font-size: 12px;"></td>
                    <td style="width: 16%;border-left: 1px solid;">'.number_format($rooms['price_ECHD']).'</td>
                </tr>
                ';

        $printBoxCheck .= '
                <tr style="border: 1px solid;">
                    <td colspan="5"></td>
                    <td style="text-align: center;padding: 0 10px;font-size: 16px;font-weight: bold;">
                        <p>جمع کل:</p>
                    </td>
                    <td style="text-align: center;padding: 0 10px;font-size: 16px;font-weight: bold;">
                        <p>'.number_format($rooms['total_price']).'</p>
                    </td>
                </tr>

                <tr style="border: 1px solid;">
                    <td colspan="7" style="text-align: center;padding: 0 10px;">
                        <p>توضیحات:
                            ----------------------------------------------------------------------------------------------
                        </p>
                    </td>
                </tr>

                <tr style="border: 1px solid;">
                    <td colspan="7">
                    <p style="text-align: center;
                        padding: 0 10px;
                        font-size: 15px;
                        font-weight: bold;
                        font-family: IRANSansBold, IRANSansNumber;">اقامت بیشتر تا ساعت (2) بعدازظهر (50) درصد هزینه یک شب و بیشتر از ساعت (2) بعدازظهر هزینه کامل یک شب دریافت میگردد.</p>
                    </td>
                </tr>

            </table>
            <div style="clear: both;"></div>
            <br>
            ';




            $printBoxCheck .= '
            <table style="text-align: center;width: 99%;display: table;
                    font-size: 15px;line-height: 30px;
                    font-family: IRANSansBold, IRANSansNumber;font-weight: bold;">
                <tr>
                    <td colspan="4" style="font-weight: bold;text-align: right;font-size: 16px;">مشخصات مهمانان: (تحویل کارت ملی و شناسنامه تمامی میهمانان به هتل الزامی است.)</td>
                </tr>
            </table>
            <div style="clear: both;"></div>
            ';

            $printBoxCheck .= '
            <table style="width: 99%;
                        font-family: IRANSansLight, IRANSansNumber;
                        font-size: 14px;
                        border-collapse: collapse;
                        text-align: right;
                        line-height: 25px;
                        " border="1">
                <tr>
                    <td width="25%" style="font-weight: bold;text-align: right;font-size: 16px;">نام و نام خانوادگی</td>
                    <td width="25%" style="font-weight: bold;text-align: right;font-size: 16px;">سن</td>
                    <td width="25%" style="font-weight: bold;text-align: right;font-size: 16px;">نام و نام خانوادگی</td>
                    <td width="25%" style="font-weight: bold;text-align: right;font-size: 16px;">سن</td>
                </tr>
                
                ';
            $number = 1;
            foreach ($info_hotel as $item) {

                if ($item['passenger_birthday'] != ''){
                    $age = $objResult->getAgeFa($item['passenger_birthday']);
                } else {
                    $age = $objResult->getAgeEn($item['passenger_birthday']);
                }

                if ($number%2!=0){
                    $printBoxCheck .= '
                                    <tr>';
                }
                $printBoxCheck .= '
                                   <td width="25%">'.$number .' ' .$item['passenger_name'] .' '. $item['passenger_family'] .'</td>
                                   <td width="25%">';
                $printBoxCheck .= $age;
                if ($age <= 6){$printBoxCheck .= ' (اطفال زیر 6 سال) '; }
                $printBoxCheck .= '</td>
                                ';
                if ($number%2!=0){
                    $printBoxCheck .= '
                                    </tr>';
                }
                $number++;

            }
            $printBoxCheck .= '
            </table>
                ';

            /*$printBoxCheck .= '
            <table style="text-align: center;width: 99%;font-family: IRANSansLight, IRANSansNumber;font-size: 15px;line-height: 30px;">
                <tr>
                    <td width="50%" style="font-weight: bold;text-align: right;font-size: 16px;">مشخصات مهمانان:</td>
                    <td width="50%" style="font-weight: bold;text-align: right;font-size: 16px;">(تحویل کارت ملی و شناسنامه تمامی میهمانان به هتل الزامی است)</td>
                </tr>
                <tr>
                    <td width="50%">';

                    $printBoxCheck .= '
                        <table style="border-collapse: collapse;text-align: right;top: 0;line-height: 25px;" border="1" width="770">
                            <tr>
                                <td colspan="2" style="font-weight: bold;text-align: center;">نام و نام خانوادگی</td>
                            </tr>';
                            $number = 1;
                            foreach ($info_hotel as $item) {

                                if ($item['passenger_birthday'] != ''){
                                    $age = $objResult->getAgeFa($item['passenger_birthday']);
                                } else {
                                    $age = $objResult->getAgeEn($item['passenger_birthday']);
                                }

                                if ($age > 6){
                                    if ($number%2!=0){
                                        $printBoxCheck .= '
                                        <tr>';
                                    }
                                    $printBoxCheck .= '
                                        <td  width="50%">'.$number .' ' .$item['passenger_name'] .' '. $item['passenger_family'] .'</td>';
                                    if ($number%2!=0){
                                        $printBoxCheck .= '
                                        </tr>';
                                    }
                                    $number++;
                                }

                            }
                            $printBoxCheck .= '
                        </table>';

            $printBoxCheck .= '
                    <td width="50%">';

                    $printBoxCheck .= '
                            <table style="border-collapse: collapse;text-align: right;;font-size: 15px;top: 0;" border="1" width="770">
                                <tr>
                                    <td width="70%" style="font-weight: bold;
                                        text-align: right;">نام و نام خانوادگی اطفال زیر 6 سال</td>
                                    <td width="30%" style="font-weight: bold;
                                        text-align: right;">تاریخ تولد</td>
                                </tr>';
                                $number = 1;
                                foreach ($info_hotel as $item) {

                                    if ($item['passenger_birthday'] != ''){
                                        $age = $objResult->getAgeFa($item['passenger_birthday']);
                                    } else {
                                        $age = $objResult->getAgeEn($item['passenger_birthday']);
                                    }

                                    if ($age <= 6){

                                        $printBoxCheck .= '
                                                    <tr>
                                                        <td width="70%">'.$number .'. ' .$item['passenger_name'] .' '. $item['passenger_family'] .'</td>
                                                        <td width="30%">'.$item['passenger_birthday'].'</td>
                                                    </tr>
                                                    ';
                                        $number++;
                                    }

                                }
                    $printBoxCheck .= '
                            </table>
                        ';

            $printBoxCheck .= '
                    </td>

                </tr>
            </table>
            <br>
            ';*/

            $printBoxCheck .= '
            <div class="row">
                <div style="font-family: IRANSansLight, IRANSansNumber;
                        font-size: 15px;
                        display: inline-block;
                        width: 99%;
                        line-height: 25px;
                        margin: 8px 0 2px 0;">
                    <span style="font-size: 15px;
                        font-weight: bold;
                        width: 100%;
                        display: block;
                        text-align: right;font-family: IRANSansBold, IRANSansNumber;font-weight: bold;font-size: 16px;">شرایط انصراف و هزینه ابطال: </span>
                    <span type="width: 100%;display: block;text-align: justify;">چنانچه میهمانان محترم بعد از انجام رزرواسیون و صدور هتل واچر، اعلام ابطال و یا هر تغییری را نمایند شرایط انصراف منوط به حضور شخص میهمان درمحل شرکت مسافرتی آهوان با در دست داشتن اصل برگه رزرواسیون هتل در تهران و یا ارسال درخواست کتبی و ذکر شماره حساب بانکی جهت استرداد به شرح جدول زیر صورت می گیرد.</span>
                </div>
            </div>
                
            <table style="border-collapse: collapse;text-align: right;width: 99%;font-size: 15px;line-height: 30px;" border="1">
                <tr>
                    <td style="font-weight: bold;
                        text-align: right;">ردیف</td>
                    <td style="font-weight: bold;
                        text-align: right;">زمان اعلام تغییرات (بدون احتساب روزهای تعطیل)</td>
                    <td style="font-weight: bold;
                        text-align: right;">میزان هزینه ابطال</td>
                </tr>
                <tr>
                    <td style="text-align: right;font-family: IRANSansLight, IRANSansNumber;">1</td>
                    <td style="text-align: right;">تا ساعت 10 صبح (7) روز قبل از تاریخ عزیمت</td>
                    <td style="text-align: right;">10 درصد هزینه یک شب</td>
                </tr>
                <tr>
                    <td style="text-align: right;font-family: IRANSansLight, IRANSansNumber;">2</td>
                    <td style="text-align: right;">از ساعت 10 صبح (7) روز قبل از تاریخ عزیمت تا ساعت 10 صبح (2) روز قبل از تاریخ عزیمت</td>
                    <td style="text-align: right;">50 درصد هزینه یک شب</td>
                </tr>
                <tr>
                    <td style="text-align: right;font-family: IRANSansLight, IRANSansNumber;">3</td>
                    <td style="text-align: right;">از ساعت 10 صبح (2) روز قبل از تاریخ عزیمت تا روز ورود و یا پس از آن</td>
                    <td style="text-align: right;">100 درصد هزینه یک شب</td>
                </tr>
                <tr>
                    <td style="text-align: right;font-family: IRANSansLight, IRANSansNumber;">4</td>
                    <td style="text-align: right;" colspan="3">میهمانان محترم که در هتل اقامت داشته و به دلایلی اقامت خود را کاهش دهند، فقط مشمول جریمه یک شب خواهند شد.</td>
                </tr>
                <tr>
                    <td style="text-align: right;font-family: IRANSansLight, IRANSansNumber;">5</td>
                    <td style="text-align: right;" colspan="3">
                        در صورت انصراف اتاق رزرو شده برای ایام ویژه تعطیلات نوروز (از 27 اسفند تا 15 فروردین) تا دوهفته قبل از تاریخ استفاده از هتل شامل هزینه یک شب از تعداد اتاقهای رزرو شده کسر می گردد و کمتر از دو هفته قبل از تاریخ استفاده از هتل شامل صد در صد هزینه کل اتاقهای رزرو شده بوده و
                        <i style="text-align: center;
                            line-height: 25px;
                            font-family: IRANSansBold, IRANSansNumber;
                            font-weight: bold;
                            font-size: 16px;">هیچگونه وجهی به میهمان محترم مسترد نمی گردد.</i>
                    </td>
                </tr>
            </table>
            <br>
            ';

            $printBoxCheck .= '
            <div class="row">
                <div style="font-family: IRANSansLight, IRANSansNumber;
                        font-size: 15px;
                        display: inline-block;
                        width: 99%;
                        line-height: 25px;
                        margin: 8px 0 2px 0;">
                    <span style="width: 100%;display: block;">
                        اینجانب
                        <i style="padding: 4px;
                        font-family: IRANSansBold, IRANSansNumber;
                        font-weight: bold;
                        font-size: 16px;">'.$info_hotel[0]['passenger_leader_room_fullName'].'</i>
                        از طرف خود و همراهان کلیه شرایط مندرج در برگ رزرواسیون را مطالعه نموده و پذیرفته ام و حق هر گونه ادعایی بر علیه شرکت مسافرتی آهوان و هتل آهوان '.$cityName.' خارج از مفاد مندرج در برگ رزرواسیون را برای خود و همراهان سلب می نمایم.
                    </span>
                </div>
            </div>
            ';
            if ($objResult->counterTypeId == '5'){

                if ($info_hotel[0]['hotel_id'] == '2'){//بابلسر

                    $printBoxCheck .= '
                    <table style="border-collapse: collapse;text-align: center;width: 99%;border: 1px solid;font-size: 15px;">
                        <tr>
                            <td style="border: none;" dir="ltr">آدرس دفتر مرکزی شرکت آهوان:  تهران، میدان آرژانتین، ساختمان بانک تجارت، طبقه اول </td>
                            <td rowspan="4" style="border-right: 1px solid;">
                                <img style="
                                    -webkit-transition: .3s;
                                    -moz-transition: .3s;
                                    transition: .3s;
                                    width: 25%;
                                    height: 20%;
                                    margin: 0 auto;"
                                src="' . FRONT_CURRENT_THEME . 'project_files/images/babolsar.jpg"/>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: none;">
                                تلفن:
                                <i>021-88712928</i>,
                                <i>021-88106455-6</i>,
                                <i>021-41889</i>
                                و فکس:
                                <i>021-88700353</i>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: none;" dir="ltr"> آدرس هتل: بابلسر، منطقه نخست وزیری خیابان طالقانی، روبروی پارک شورا، نبش کوچه طالقانی (9) </td>
                        </tr>
                        <tr>
                            <td style="border: none;">
                            تلفن:
                                <i>011-35331990-8</i>
                                و فکس:
                                <i>011-35338948</i>
                             </td>
                        </tr>
                    </table>
                    ';

                    $printBoxCheck .= '<br>';

                } else if ($info_hotel[0]['hotel_id'] == '1'){//چابکسر

                    $printBoxCheck .= '
                    <table style="border-collapse: collapse;text-align: center;width: 99%;border: 1px solid;font-size: 15px;">
                        <tr>
                            <td style="border: none;" dir="ltr"> آدرس دفتر مرکزی شرکت آهوان:  تهران، میدان آرژانتین، ساختمان بانک تجارت، طبقه اول </td>
                            <td rowspan="5" style="border-right: 1px solid;">
                                <img style="
                                    -webkit-transition: .3s;
                                    -moz-transition: .3s;
                                    transition: .3s;
                                    width: 25%;
                                    height: 20%;
                                    margin: 0 auto;"
                                src="' . FRONT_CURRENT_THEME . 'project_files/images/chaboksar.jpg"/>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: none;">
                             تلفن:
                                <i>021-88712928</i>,
                                <i>021-88106455-6</i>,
                                <i>021-41889</i>
                                و فکس:
                                <i>021-88700353</i>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: none;" dir="ltr"> آدرس هتل تفریحی و ساحلی آهوان: (مسیر چالوس - رامسر، کیلومتر 7 جاده چابکسر به رودسر) </td>
                        </tr>
                        <tr>
                            <td style="border: none;" dir="ltr"> و یا (مسیر رشت - رودسر - کیلومتر 8 جاده کلاچای به چابکسر) </td>
                        </tr>
                        <tr>
                            <td style="border: none;">
                            تلفن:
                                <i>013-42657011-25</i>
                                و فکس:
                                <i>013-42657006-7</i>
                            </td>
                        </tr>
                    </table>
                    ';

                    $printBoxCheck .= '<br>';
                }

            } else {

                if ($info_hotel[0]['hotel_id'] == '2'){//بابلسر

                    $printBoxCheck .= '
                    <table style="border-collapse: collapse;text-align: center;width: 99%;border: 1px solid;font-size: 15px;">
                        <tr>
                            <td style="border: none;width: 35%;text-align: right;" dir="ltr">
                                <span style="display: block;line-height: 22px;">نام و نام خانوادگی صادر کننده:</span>
                            </td>
                            <td rowspan="4" style="border: 1px solid;">
                                <img style="
                                    -webkit-transition: .3s;
                                    -moz-transition: .3s;
                                    transition: .3s;
                                    width: 30%;
                                    height: 18%;
                                    margin: 0 auto;"
                                src="' . FRONT_CURRENT_THEME . 'project_files/images/babolsar.jpg"/>
                            </td>
                            <td style="border: none;width: 35%;text-align: right;" dir="ltr">نام و نام خانوادگی مهمان:</td>
                        </tr>
                        <tr>
                            <td style="border: none;width: 35%;border-bottom: 1px solid;text-align: right;" dir="ltr">امضا:</td>
                            <td style="border: none;width: 35%;border-bottom: 1px solid;text-align: right;" dir="ltr">امضا:</td>
                        </tr>
                        <tr>
                            <td style="border: none;width: 35%;text-align: right;" dir="ltr">نام و نام خانوادگی تایید کننده:</td>
                            <td style="border: none;width: 35%;text-align: right;" dir="ltr">نام و نام خانوادگی صندق دار:</td>
                        </tr>
                        <tr>
                            <td style="border: none;width: 35%;border-bottom: 1px solid;text-align: right;" dir="ltr">امضا:</td>
                            <td style="border: none;width: 35%;border-bottom: 1px solid;text-align: right;" dir="ltr">امضا:</td>
                        </tr>
                    </table>
                    ';


                    $printBoxCheck .= '
                    <table style="text-align: center;width: 100%;display: table;
                                font-size: 15px;line-height: 25px;padding: 0 10px;
                                font-family: IRANSansBold, IRANSansNumber;">
                        <tr>
                            <td>آدرس دفتر مرکزی شرکت آهوان:  تهران، میدان آرژانتین، ساختمان بانک تجارت، طبقه اول تلفن:
                                <i>021-88712928</i>,
                                <i>021-88106455-6</i>,
                                <i>021-41889</i>
                                و فکس:
                                <i>88700353-021</i>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                آدرس هتل: بابلسر، منطقه نخست وزیری خیابان طالقانی، روبروی پارک شورا، نبش کوچه طالقانی (9) تلفن:
                                <i>011-35331990-8</i>
                                و فکس:
                                <i>011-35338948</i>
                            </td>
                        </tr>
                    </table>
                    <div style="clear: both;"></div>
                    ';

            $printBoxCheck .= '<br>';

                } else if ($info_hotel[0]['hotel_id'] == '1'){//چابکسر


                    $printBoxCheck .= '
                    <table style="border-collapse: collapse;text-align: center;width: 99%;border: 1px solid;font-size: 15px;">
                        <tr>
                            <td style="border: none;width: 35%;text-align: right;" dir="ltr">
                                <span style="display: block;line-height: 22px;">نام و نام خانوادگی صادر کننده:</span>
                            </td>
                            <td rowspan="4" style="border: 1px solid;">
                                <img style="
                                    -webkit-transition: .3s;
                                    -moz-transition: .3s;
                                    transition: .3s;
                                    width: 30%;
                                    height: 18%;
                                    margin: 0 auto;"
                                src="' . FRONT_CURRENT_THEME . 'project_files/images/chaboksar.jpg"/>
                            </td>
                            <td style="border: none;width: 35%;text-align: right;" dir="ltr">نام و نام خانوادگی مهمان:</td>
                        </tr>
                        <tr>
                            <td style="border: none;width: 35%;border-bottom: 1px solid;text-align: right;" dir="ltr">امضا:</td>
                            <td style="border: none;width: 35%;border-bottom: 1px solid;text-align: right;" dir="ltr">امضا:</td>
                        </tr>
                        <tr>
                            <td style="border: none;width: 35%;text-align: right;" dir="ltr">نام و نام خانوادگی تایید کننده:</td>
                            <td style="border: none;width: 35%;text-align: right;" dir="ltr">نام و نام خانوادگی صندق دار:</td>
                        </tr>
                        <tr>
                            <td style="border: none;width: 35%;border-bottom: 1px solid;text-align: right;" dir="ltr">امضا:</td>
                            <td style="border: none;width: 35%;border-bottom: 1px solid;text-align: right;" dir="ltr">امضا:</td>
                        </tr>
                    </table>
                    ';


                    $printBoxCheck .= '
                    <table style="text-align: center;width: 100%;display: table;
                                    font-size: 15px;line-height: 25px;padding: 0 10px;
                                    font-family: IRANSansBold, IRANSansNumber;">
                        <tr>
                            <td>
                            آدرس دفتر مرکزی شرکت آهوان:  تهران، میدان آرژانتین، ساختمان بانک تجارت، طبقه اول
                             تلفن:
                            <i>021-88712928</i>,
                            <i>021-88106455-6</i>,
                            <i>-02141889</i>
                            و فکس:
                            <i>021-88700353</i>
                        </td>
                        </tr>
                        <tr>
                            <td>
                            آدرس هتل تفریحی و ساحلی آهوان: (مسیر چالوس - رامسر، کیلومتر 7 جاده چابکسر به رودسر)
                            تلفن:
                            <i>013-42657011-25</i>
                            و فکس:
                            <i>013-42657006-7</i>
                        </td>
                        </tr>
                        <tr>
                            <td>
                            (مسیر رشت - رودسر - کیلومتر 8 جاده کلاچای به چابکسر)
                            </td>
                        </tr>
                    </table>
                    <div style="clear: both;"></div>
                    ';
            $printBoxCheck .= '<br>';
                }


            }
            $printBoxCheck .= '
                        </div>
            
            </div>
            </div>';
            $printBoxCheck .= '';
            



        } else {
            $printBoxCheck .= '<div style="text-align:center ; fon-size:20px ;font-family: Yekan;">اطلاعات مورد نظر موجود نمی باشد</div>';
        }




        $printBoxCheck .= '</div>';
        $printBoxCheck .= '</div>';
        $printBoxCheck .= ' </div>
                                </body>
                </html> ';


        return $printBoxCheck;
    }


}