<?php


class BookingReservationTicket
{

    public $factor_number = '';
    public $payment_date = '';
    public $okTicket = '';
    public $type_application = '';
    public $errorMessage = '';


    public function __construct(){}

    public function updateBank($codRahgiri, $factorNumber)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $data = array(
            'tracking_code_bank' => "" . $codRahgiri . "",
            'payment_date' => Date('Y-m-d H:i:s')
        );

        $condition = " factor_number='" . $factorNumber . "' AND successfull = 'bank' ";
        $Model->setTable('book_local_tb');
        $Model->update($data, $condition);

        $ModelBase->setTable('report_tb');
        $ModelBase->update($data, $condition);

        $d['PaymentStatus'] = 'success';
        $d['BankTrackingCode'] = ($codRahgiri != 'member_credit' ? $codRahgiri : '');
        $condition = " FactorNumber='" . $factorNumber . "' ";
        $Model->setTable('transaction_tb');
        $Model->update($d, $condition);

    }

    public function TicketBook($factorNumber, $paymentType)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $parvazBookingLocal = Load::controller('parvazBookingLocal');
        $smsController = Load::controller('smsServices');

        $factorNumber = trim($factorNumber);
        $this->factor_number = $factorNumber;

        $ticket = functions::GetInfoReservationTicket($factorNumber);

        if ($ticket['member_id']){
            $user_type = functions::getCounterTypeId($ticket['member_id']); /// for user_type
        }else {
            $user_type = '5';
        }
        $resReduceCapacity = $this->reduceCapacity($factorNumber, $ticket['member_id'], $user_type); /// reduce capacity
        if ($resReduceCapacity){

            $data['successfull'] = 'book';
            $data['payment_date'] = date('Y-m-d H:i:s');
            $data['payment_type'] = $paymentType;
            $data['pnr'] = 'RESTE'.rand(000,999);
            $data['eticket_number'] = rand(000000,999999);
            $data['creation_date_int'] = time();
            if($paymentType == 'member_credit'){
                $data['tracking_code_bank'] = '';
            }

            $condition = " factor_number='{$factorNumber}'";
            $Model->setTable('book_local_tb');
            $res = $Model->update($data, $condition);

            if ($res) {

                $ModelBase->setTable('report_tb');
                $ModelBase->update($data, $condition);

                $this->okTicket = true;
                $this->payment_date = $data['payment_date'];

                //email
                $parvazBookingLocal->emailTicketSelf($ticket['request_number']);

                //sms
                $objSms = $smsController->initService('0');
                if($objSms) {
                    //to member
                    $messageVariables = array(
                        'sms_name' => $ticket['member_name'],
                        'sms_service' => 'بلیط',
                        'sms_factor_number' => $ticket['request_number'],
                        'sms_cost' => $ticket['total_price'],
                        'sms_airline' => $ticket['airline_name'],
                        'sms_origin' => $ticket['origin_city'],
                        'sms_destination' => $ticket['desti_city'],
                        'sms_flight_number' => $ticket['flight_number'],
                        'sms_flight_date' => dateTimeSetting::jdate("Y-F-d", functions::ConvertToDateJalaliInt($ticket['date_flight'])),
                        'sms_flight_time' => $ticket['time_flight'],
                        'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=BookingReservationTicket&id=" . $ticket['request_number'],
                        'sms_agency' => CLIENT_NAME,
                        'sms_agency_mobile' => CLIENT_MOBILE,
                        'sms_agency_phone' => CLIENT_PHONE,
                        'sms_agency_email' => CLIENT_EMAIL,
                        'sms_agency_address' => CLIENT_ADDRESS,
                        'sms_site_url' => CLIENT_MAIN_DOMAIN
                    );
                    $smsArray = array(
                        'smsMessage' => $smsController->getUsableMessage('afterTicketReserve', $messageVariables),
                        'cellNumber' => $ticket['member_mobile'],
                        'smsMessageTitle' => 'afterTicketReserve',
                        'memberID' => (!empty($ticket['member_id']) ? $ticket['member_id'] : ''),
                        'receiverName' => $messageVariables['sms_name'],
                    );
                    $smsController->sendSMS($smsArray);

                    //to manager
                    $smsArray = array(
                        'smsMessage' => $smsController->getUsableMessage('afterReserveToManager', $messageVariables),
                        'cellNumber' => CLIENT_MOBILE,
                        'smsMessageTitle' => 'afterReserveToManager',
                        'memberID' => (!empty($ticket['member_id']) ? $ticket['member_id'] : ''),
                        'receiverName' => 'مدیر سایت',
                    );
                    $smsController->sendSMS($smsArray);

                    //to first passenger
                    $messageVariables['sms_name'] = $ticket['passenger_name'] . ' ' . $ticket['passenger_family'];
                    $smsArray = array(
                        'smsMessage' => $smsController->getUsableMessage('afterTicketReserve', $messageVariables),
                        'cellNumber' => $ticket['mobile_buyer'],
                        'smsMessageTitle' => 'afterTicketReserve',
                        'memberID' => (!empty($ticket['member_id']) ? $ticket['member_id'] : ''),
                        'receiverName' => $messageVariables['sms_name'],
                    );
                    $smsController->sendSMS($smsArray);
                }
            }

        }else {
            $this->okTicket = false;
            $this->errorMessage = 'مشکلی در فرآیند رزرو پیش آمده است. لطفا برای پیگیری رزرو خود با پشتیبانی تماس بگیرید.';
        }

    }

    public function delete_transaction_current($factorNumber)
    {
        if(!$this->checkBookStatus($factorNumber))
        {
            $Model = Load::library('Model');
            $data['PaymentStatus'] = 'pending';
            $condition = "FactorNumber = '{$factorNumber}' AND FactorNumber !=''";
            $Model->setTable('transaction_tb');
            $Model->update($data, $condition);
        }
    }

    public function checkBookStatus($factorNumber)
    {
        $Model = Load::library('Model');

        $query = "SELECT successfull FROM book_local_tb WHERE factor_number = '{$factorNumber}' OR request_number = '{$factorNumber}'";
        $result = $Model->load($query);

        return $result['successfull'] == 'book' ? true : false;
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

    public function reduceCapacity($factorNumber, $memberId, $user_type)
    {

        $Model = Load::library('Model');

        $sql = " SELECT fk_id_ticket, SUM(adt_qty) as ADL, SUM(chd_qty) as CHD, SUM(inf_qty) as INF, passenger_age
                  FROM book_local_tb 
                  WHERE factor_number ='{$factorNumber}' AND
                   member_id='{$memberId}' AND 
                   (successfull='prereserve' OR successfull='bank')
                  GROUP BY direction, passenger_age ";
        $result = $Model->select($sql);
        if (!empty($result)){
            $capacity = "";
            foreach ($result as $val){

                $sqlTicket = "SELECT remaining_capacity, fly_full_capacity, age FROM reservation_ticket_tb WHERE id='{$val['fk_id_ticket']}' ";
                $resultTicket = $Model->load($sqlTicket);

                $date['fly_full_capacity'] = $resultTicket['fly_full_capacity'] + $val[$resultTicket['age']];
                $date['remaining_capacity'] = $resultTicket['remaining_capacity'] - $val[$resultTicket['age']];

                $Condition = " id='{$val['fk_id_ticket']}' ";
                $Model->setTable("reservation_ticket_tb");
                $res = $Model->update($date, $Condition);

                if ($res){
                    $capacity .= 'true|';
                }else{
                    $capacity .= 'false|';
                }

            }

            $expCapacity = explode("|", $capacity);
            if (in_array("false", $expCapacity)){
                return false;
            }else {
                return true;
            }

        }else {
            return false;

        }


    }


    public function createPdfContent($param, $cash)
    {


        $bookshow = Load::controller('bookshow');
        $resultBook = $bookshow->getInfoTicketReservation($param);
        $info_ticket = $resultBook['infoTicket'];

        $gender = '';
        $genderEn = '';
        $airplan = '';
        $PrintTicket = '';

        if (!empty($info_ticket)) {
            if($info_ticket[0]['isInternal']=='1'){
                return  $this->InternalTicket($info_ticket);
            }
            return  $this->ExternalTicket($info_ticket);

        }
             return '<div style = "text-align:center ; fon-size:20px ;font-family: Yekan;" > اطلاعات مورد نظر موجود نمی باشد </div > ';




    }


    public function InternalTicket($info_ticket) {
        $Model = Load::library('Model');
        $resultLocal = Load::controller('resultLocal');
        $PrintTicket ='';
        $gender = '';
        $genderEn = '';
        $airplan = '';
        $resultReservationTicket = Load::controller('resultReservationTicket');
        $typeReservation = $resultReservationTicket->getTypeVehicleByTicketId($info_ticket[0]['fk_id_ticket']);

        $PrintTicket .= ' <!DOCTYPE html>
<html>
    <head>
        <title>مشاهده فایل pdf </title>
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
                    background-color: #FFF;
                    border-radius: 5px;
                    z-index: 100000000;
                    width: 200px;
                    padding: 5px;
                    margin-right: 20px;
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
                    border-collapse: collapse;
                }
                
                table.solidBorder, .solidBorder th, .solidBorder td {
                    border: 1px solid #CCC;
                }
        </style>

    </head>
    <body>';


        foreach ($info_ticket as $info) {


            $namePrice = strtolower($info['passenger_age']) . '_price';
            $nameDiscountPrice = 'discount_' . strtolower($info['passenger_age']) . '_price';
            if ($info[$nameDiscountPrice] > 0){
                $totalPrice = $info[$nameDiscountPrice];
            } else {
                $totalPrice = $info[$namePrice];
            }

            $sql_reservation_ticket = " SELECT 
                                            F.time, T.cost_two_way, T.cost_two_way_print,
                                            T.cost_one_way, T.cost_one_way_print, T.age, T.comition_ticket
                                         FROM 
                                            reservation_ticket_tb T INNER JOIN reservation_fly_tb F ON T.fly_code=F.id
                                         WHERE T.id='{$info['fk_id_ticket']}' ";
            $ticket = $Model->load($sql_reservation_ticket);
            $time = explode(":", $ticket['time']);

            if ($info['passenger_age'] == "Adt") {
                $infoAge = 'بزرگسال';
            } else if ($info['passenger_age'] == 'Chd') {
                $infoAge = 'کودک';
            } else if ($info['passenger_age'] == 'Inf') {
                $infoAge = 'نوزاد';
            }
            if ($info['passenger_gender'] == 'Male') {
                $gender = ' آقای';
                $genderEn = 'Mr';
            } else if ($info['passenger_gender'] == 'Female') {
                $gender = ' خانم';
                $genderEn = 'Ms';
            }


            $logoAgency = ROOT_ADDRESS_WITHOUT_LANG.'/pic/'. CLIENT_LOGO;

            if ($info['type_app'] == 'reservation'){

                if ($info['flight_type'] == '' || $info['flight_type'] == 'charter'|| $info['flight_type'] == 'charterPrivate') {
                    $flight_type = 'چارتری';
                } else if ($info['flight_type'] == 'system') {
                    $flight_type = 'سیستمی';
                } else {
                    $flight_type = '';
                }

                if ($info['seat_class'] == 'C') {
                    $seat_class = 'بیزینس';
                } else {
                    $seat_class = 'اکونومی';
                }

                $picAirline = functions::getAirlinePhoto($info['airline_iata']);
                $Fee = functions::FeeCancelFlight($info['airline_iata'], $info['cabin_type']);
                $airplan = '<img src="http://online.indobare.com/gds/view/client/assets/images/air.png"  style="float:right; max-height:30px;" />';
                $cabinType = '(' . $info['cabin_type'] . ')';
                $title = 'شماره پرواز';
                $taeed = 'تأیید شده';

                $origin_city = $info['origin_city'];
                $desti_city = $info['desti_city'];

            } elseif ($info['type_app'] == 'reservationBus'){

                $flight_type = 'گردش شهری';
                $seat_class = 'کلاس معمولی';
                $cabinType = '';
                $Fee = '';
                $picAirline = ROOT_ADDRESS_WITHOUT_LANG . "/pic/0507026091542721022.jpg";
                $airplan = '';
                $title = 'نام تور';
                $taeed = '';
                $origin_city = 'ساعت حرکت';
                $desti_city = 'ساعت برگشت';

            } else {

                $flight_type = '';
                $seat_class = '';
                $cabinType = '';
                $Fee = '';
                $picAirline = '';
                $airplan = '';
                $title = '';
                $taeed = '';
                $origin_city = '';
                $desti_city = '';

            }


            $PrintTicket .= ' 
                <table width="100%" align="center" style="margin: 100px ; border: 1px solid #CCC;" cellpadding="0" cellspacing="0" class="page">
                    <tr>
                        <td style="width: 30%">
                                 
                          <img src="' . $logoAgency . '" style="float:right; width: 150px">
                                 
                        </td>
                         <td style="width: 70% ;" >
                                <table style="" cellpadding="0" cellspacing="0" class="page" >
                                     <tr style="width: 100%">
                                          <td style="width: 100%; color: #FFF; " colspan="2">
                                              sdfsdfsdfasddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd
                                              asdsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                                              asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                                              asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                                              asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                                              asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                                          </td>
                                     </tr>
                                     <tr style="width: 100%;  ">
                                        <td  style="border: 1px solid #CCC; font-size: 25px; font-weight: bolder; padding: 10px ; border-left: none;" width="50%">';
            $PrintTicket .= '<span style="float:right;">' . $gender . ' ' . $info['passenger_name'] . ' ' . $info['passenger_family'] . '</span>';

            $PrintTicket .= '</td> 

                                     <td width="50%" style=" border: 1px solid #CCC; font-size: 25px;  font-weight: bolder; padding: 10px ; text-align: left; border-right: none;">';
            $PrintTicket .= '<span style="float:left;text-align: left">' . '(' . $genderEn . ')' . $info['passenger_name_en'] . ' ' . $info['passenger_family_en'] . '</span>';

            $PrintTicket .= '</td>
                                         
                                          
                                     </tr>
                                </table>
                                         
                         </td>
                    </tr>
                    <tr>
                    
                           <td style="width: 30%;  border: 1px solid #CCC;" align="center">
                                  <table style="width: 100%" cellpadding="0" cellspacing="0" class="page" >
                                     <tr style="border-bottom: 1px solid #CCC">
                                          <td width="280px" align="center" style="border-bottom: 1px solid #CCC">
                                                <img src="' . $picAirline . '" style="float:right; width: 10%; height: auto;">
                                           </td>
                                     </tr>
                                         <tr>
                                            <td>
                                                   <table style="width: 100%" cellpadding="0" cellspacing="0" class="page" >
                                                    <tr style="">
                                                            <td width="140"  align="right" style="padding: 5px; border-bottom: 1px solid #CCC " >';

            $PrintTicket .= '<span style="float: right;font-size: 11px;  color:#006cb5 position: relative; right: 0;">';
            $PrintTicket .= $title;
            $PrintTicket .= '</span> ';
            $PrintTicket .= '<span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> ';
            $PrintTicket .= '<span style="float: left ; position: relative; left: 0;">' . $info['flight_number'];
            '.</span> ';
            $PrintTicket .= '</td>
                                                                   
                                                            </td>
                                                              <td width="140" align="center" style="padding: 5px; border-right: 1px solid #CCC;  border-bottom: 1px solid #CCC">';
            $PrintTicket .= '<span style="float: right;">' . $seat_class . '</span>';
            $PrintTicket .= '<span style="float: left;">' . $cabinType . '</span>';
            $PrintTicket .= '</td>
                                                    </tr>
                                                    <tr>
                                                         <td colspan="2" align="right" style="padding: 5px ; border-bottom: 1px solid #CCC" width="280">
                                                         ';
            $PrintTicket .= !empty($info['eticket_number']) ? '<span style="float: right; font-size: 11px;  color:#006cb5 ;text-align: right">شماره بلیط</span>' : '';
            $PrintTicket .= '<span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> ';
            $PrintTicket .= '<span style="float: left;">' . !empty($info['eticket_number']) ? $info['eticket_number'] : '' . '</span>';
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
                             
                             <td style="width: 70%; border: 1px solid #CCC; border-right:none ; border-top:none; vertical-align: top">
                                   
                                     <table style="width: 100%;border:1px solid #CCC" cellpadding="0" cellspacing="0" class="page"  valign="top">
                                         <tr style="height:450px">
                                                <td  style="border-left: 1px solid #CCC;" width="450" height="250">
                                                   <table style="width: 100%;" cellpadding="0" cellspacing="0" class="page" border="0">
                                                       <tr>
                                                           <td  width="" style="border-bottom:1px solid #CCC">
                                                             <table style="width: 100%; font-size: 20px" cellpadding="0" cellspacing ="0" class="page" border="0">
                                                                 <tr>
                                                                    <td width="200" height="70" align="center" valign="middle" style="font-size: 25px">';
            $PrintTicket .= $origin_city;
            $PrintTicket .= '</td>
                                                                    <td width="50" align="center" valign="middle">   
                                                                    ' . $airplan . '
                                                                    </td>
                                                                    <td width="200" align="center" valign="middle" style="font-size: 25px">';
            $PrintTicket .= $desti_city;

            $PrintTicket .= '</td>
                                                                 </tr>
                                                                 <tr>
                                                                    <td width="200" height="70" align="center" valign="middle" style="font-size: 25px">';
            $PrintTicket .= $resultLocal->format_hour($info['time_flight']);
            $PrintTicket .= '</td>
                                                                    <td width="50" align="center" valign="middle"> 
                                                                     -
                                                                    </td>
                                                                    <td width="200" align="center" valign="middle">';
            $PrintTicket .= $resultLocal->getTimeArrival($time[0], $time[1], $info['time_flight']);

            $PrintTicket .= '</td>
                                                                 </tr>
                                                                 <tr>
                                                                    <td colspan="3" height="70" align="center" valign="middle" style="font-size: 25px">';

            //$PrintTicket .= $resultLocal->Date_arrival_private($time[0], $time[1], $info['time_flight'], $info['date_flight']);
            $PrintTicket .= $bookshow->DateJalali($info['date_flight']);
            $PrintTicket .= '</td>
                                                                 </tr>
                                                              </table>
                                                           </td>
                                                       </tr>
                                                       <tr>
                                                         <td>
                                                            <table width="450" cellpadding="0" cellspacing="0" class="page" border="0">
                                                              <tr>
                                                               <td width="50%" height="40" align="center" valign="middle" style="border-left: 1px solid #CCC;">';

            $PrintTicket .= $flight_type;
            $PrintTicket .= '</td>
                                                                <td width="50%" align="center" valign="middle" style="font-size: 20px;">' . $taeed . '</td>
                                                              </tr>
                                                            </table>
                                                          </td>  
                                                        </tr>
                                                     </table>
                                                </td>
                                              
                                               <td width="220" height="100%" >
                                                   <table style="width: 100%" cellpadding="0" cellspacing="0" class="page" >
                                                     <tr style="border-bottom: 1px solid #CCC">
                                                           <td width="160"  align="right" style="padding: 5px; border-bottom: 1px solid #CCC "  height="50" >';

            $PrintTicket .= '<span style="float: left;font-size: 11px;  color:#006cb5 ; text-align: left">ملیت</span> ';
            $PrintTicket .= '<span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> ';
            $PrintTicket .= '<span style="float: left ; position: relative; left: 0;">' . functions::country_code(($info['passportCountry'] != 'IRN' && $info['passportCountry'] != '' ? $info['passportCountry'] : 'IRN'), 'fa') . '</span> ';
            $PrintTicket .= '</td>
                                                        </tr> 
                                                    <tr style="border-bottom: 1px solid #CCC">
                                                           <td width="160"  align="right" style="padding: 5px; border-bottom: 1px solid #CCC "  height="50" >';

            $PrintTicket .= '<span style="float: left;font-size: 11px;  color:#006cb5 ; text-align: left">رده سنی</span> ';
            $PrintTicket .= '<span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> ';
            $PrintTicket .= '<span style="float: left ; position: relative; left: 0;">' . $infoAge . '</span> ';
            $PrintTicket .= '</td>
                                                        </tr> 
                                                       <tr style="border-bottom: 1px solid #CCC" height="50">
                                                           <td width="160"  align="right" style="padding: 5px; border-bottom: 1px solid #CCC "  height="50" >';

            $PrintTicket .= '<span style="float: right;font-size: 11px;  color:#006cb5;">شماره رزرو</span> ';
            $PrintTicket .= '<span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> ';
            $PrintTicket .= '<span style="float: left ; position: relative; left: 0;">' . $info['factor_number'] . '</span> ';
            $PrintTicket .= '</td>
                                                        </tr> 
                                                        <tr style="border-bottom: 1px solid #CCC">
                                                           <td width="160"  align="right" style="padding: 5px; border-bottom: 1px solid #CCC;"  height="50" >';


            $PrintTicket .= '<span>' . !empty($info['pnr']) ? $info['pnr'] : '' . '</span> ';
            $PrintTicket .= '<span style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> ';
            $PrintTicket .= !empty($info['pnr']) ? '<span style="font-size: 11px;  color:#006cb5;">PNR</span>' : '';
            $PrintTicket .= '</td>
                                                        </tr>
                                                        <tr style="border-bottom: 1px solid #CCC">
                                                           <td width="160"  align="right"   height="50" style="padding-right: 5px">';

            $PrintTicket .= '<span style="float: right;font-size: 11px;  color:#006cb5; margin-right10px: ">قیمت</span> ';
            $PrintTicket .= '<span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> ';
            if ($cash == 'no') {
                $PrintTicket .= '<span style="float: left ; position: relative; left: 0;">Cash</span> ';

            } else {
                $PrintTicket .= '<span style="float: left ; position: relative; left: 0;">' . number_format($totalPrice) . '</span> ';
            }
            $PrintTicket .= '</td>
                                                        </tr>
                                                        
                                                  </table>
                                              </td>
                                         </tr>
                                     </table>

                            </td>
                    </tr>

                </table>
                <div class="divborder" style="margin: 100px ;">
                <div style="font-size: 19px ; color: #006cb5; margin-top: -20px" class="divborderPoint">  به نکات زیر توجه نمایید: </div>
                <table width="100%" align="center"  cellpadding="0" cellspacing="0" >
                    <tr>
                        <td > </td>
                    </tr>
                    
                    <tr>
                        <td style="padding-bottom: 20px">
                            <ul>';
            if ($info['type_app'] == 'reservation') {
                $PrintTicket .= '
                        <li> حداکثر بار مجاز برابر با 20کیلو گرم می باشد </li>
                        <li> در هنگام سوار شدن حتما مدرک شناسایی(کارت ملی) همراه خود داشته باشید </li>
                        <li> حتما 2 ساعت قبل از پرواز در فرودگاه حاضر باشید </li>
                        <li> در صورت کنسلی پرواز توسط ایرلاین، مسافر و یا تاخیر بیش از 2 ساعت خواهشمند است نسبت به مهر نمودن بلیط در فرودگاه و یا دریافت رسید اقدام نمایید </li >
                        <li> ارائه کارت شناسایی عکس دار و معتبر جهت پذیرش بلیط و سوار شدن به هواپیما </li>
                        <li> ترمینال 1 : کیش‌ایر، زاگرس </li>
                        <li> ترمینال 2 : ایران ایر، ایر تور، آتا، قشم ایر، معراج، نفت(کارون) </li>
                        <li> ترمینال 4 : ماهان، کاسپین، آسمان، اترک، تابان، سپهران </li>
                        <li> درصورتی که بلیط شما به هر دلیلی با مشکل مواجه شد لطفا با شماره تلفن های آژانس که در انتهای بلیط نمایش داده شده تماس حاصل فرمائید </li >
                    ';
            } elseif ($info['type_app'] == 'reservationBus'){
                $PrintTicket .= '
                        <li>قوانین و شرایط مربوط به بلیط کاغذی (خرید حضوری از ترمینال مسافربری) شامل بلیط های اینترنتی نیز می شود و از این لحاظ هیچ تفاوتی بین بلیط اینترنتی و کاغذی وجود ندارد</li>
                        <br/>
                        <li>تمام بخش های عمليات خريد بليط در  گروه خدماتی جوی  مشمول قوانين جاری تجارت الکترونيک در کشور بوده و هرگونه تخلف تحت پيگرد قانوني قرار خواهد گرفت</li>
                        <br/>
                        <li>جزئیات بلیط های اتوبوس نمایش داده‌شده در سامانه اعم از قیمت، نوع اتوبوس، ساعت و تاریخ حرکت توسط شرکت‌های مسافربری تعریف می‌شود و سامانه گروه خدماتی جوی تنها آن‌ها را جهت خرید ارائه می‌کند؛ بنابراین مسئولیت هرگونه مغایرت احتمالی بر عهده شرکت مسافربری مربوطه است</li>
                        <br/>
                        <li>قیمت بلیط ‌های ارائه‌ شده در سایت کاملا معتبر و به‌روز بوده و توسط شرکت‌های مسافربری ثبت می‌گردد</li>
                        <br/>
                        <li>قیمت بلیط های اتوبوس در سامانه گروه خدماتی جوی توسط شرکت های مسافربری تعیین می شوند و به همین دلیل قیمت بلیط اتوبوس در سامانه گروه خدماتی جوی با قیمت مصوب بلیط اتوبوس در خرید های حضوری تفاوتی نداشته و سامانه نیز هیچ مبلغ اضافی از مسافر دریافت نمی‌کند. علت اختلاف با قیمت مصوب، اعمال تخفیف از طرف شرکت های مسافربری بوده و هرگونه اختلاف قیمتی بالا تر از قیمت های مصوب، تخلف شرکت مسافربری محسوب شده و پیگرد قانونی دارد</li>
                    ';
            }
            $PrintTicket .= '</ul >
                        </td>
                       
                    </tr>
                   
                </table>
                </div>';

            if ($info['type_app'] == 'reservation') {
                $PrintTicket .= '
                        <div class="divborder" style="margin: 100px;">
                            <div style="font-size: 19px ; color: #006cb5; margin-top: -20px" class="divborderPoint">  جدول جرائم کنسلی: </div>
                            <table width="100%" align="center"  cellpadding="5" cellspacing="0" style="margin: 10px;"  >
                               <tr>
                                    <td class="cancellationPolicy-title" colspan="6">قوانين كنسلی پروازهای چارتری بر اساس تفاهم چارتر كننده و سازمان هواپيمايی كشوری می باشد</td>
                                </tr> 
                            </table>
                        </div>';

            } elseif ($info['type_app'] == 'reservationBus') {
                $PrintTicket .= '
                        <div class="divborder" style="margin: 100px;">
                            <div style="font-size: 19px ; color: #006cb5; margin-top: -20px" class="divborderPoint">  جدول جرائم کنسلی: </div>
                            <table width="100%" align="center"  cellpadding="5" cellspacing="0" style="margin: 10px;"  >
                               <tr>
                                    <td class="cancellationPolicy-title" colspan="6">در صورت ابطال برنامه تور، جهت جایگزینی برنامه و یا عودت مبلغ (در صورت فورس ماژور) لطفا با پشتیبانی گروه خدماتی جوی تماس بگیرید.</td>
                                </tr> 
                            </table>
                        </div>';
            }

            $PrintTicket .= ' 
                        <hr  style = "margin: 430px 100px 0px 100px ; width: 90%" />
                <table width = "100%" align = "center" style = "margin: 100px 100px 50px 100px ; font-size: 20px"  scellpadding = "0" cellspacing = "0" >
                
                    <tr >
                        <td >
                        وب سایت :                               ';
            $PrintTicket .= CLIENT_MAIN_DOMAIN;
            $PrintTicket .=
                '
                        </td >
                        <td > تلفن پشتیبانی :';
            $PrintTicket .= CLIENT_PHONE;
            $PrintTicket .= '

                        </td >
                    </tr >
                    <tr >
                    <td colspan = "2" >
                            آدرس :                           ';
            $PrintTicket .= CLIENT_ADDRESS;
            $PrintTicket .= '
                        </td >
                    </tr >
                
                </table >
                
                <div style = "clear:both" ></div >
        <div style = " page-break-before: right;" ></div >
                        ';
        }
        $PrintTicket .= ' </body >
</html > ' ;

        return $PrintTicket;
    }

    public function ExternalTicket($info_ticket){

        $Model = Load::library('Model');
        $resultLocal = Load::controller('resultLocal');
        $logoAgency = ROOT_ADDRESS_WITHOUT_LANG.'/pic/'. CLIENT_LOGO;
        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>ticket PDF Flight</title>
            <style type="text/css">
                /
                /
                tr td {
                / / border: 1 px solid #000;
                / /
                }

                .divborder {
                    border: 1px solid #CCC;
                }

                .divborderPoint {
                    border: 1px solid #CCC;
                    border-radius: 5px;
                    z-index: 10000000000000;
                    width: 350px;
                    padding: 10px;
                    margin-left: 20px;
                    color: #006cb5 !important;
                / / float: left;
                    margin-right: 480px;
                    background-color: #FFFFFF;
                }

                .page td {
                    padding: 0;
                    margin: 0;
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

                table {
                    font-family: Yekan !important;
                }

                .element:last-child {
                    page-break-after: auto;
                }

                .textRed{
                    color:#ee384e
                }
            </style>
        </head>
        <body>

        <?php

        foreach ($info_ticket as $info) {
            $Airport_origin = functions::NameCityForeign($info['origin_airport_iata']);
            $Airport_destination = functions::NameCityForeign($info['desti_airport_iata']);
            $namePrice = strtolower($info['passenger_age']) . '_price';
            $nameDiscountPrice = 'discount_' . strtolower($info['passenger_age']) . '_price';
            if ($info[$nameDiscountPrice] > 0){
                $totalPrice = $info[$nameDiscountPrice];
            } else {
                $totalPrice = $info[$namePrice];
            }
            ?>
            <table width="100%" align="center" style="margin: 10px 100px " cellpadding="0" cellspacing="0"
                   class="page">

                <tr>
                    <td style="padding: 5px;">
                        <img src="<?php echo $logoAgency; ?>" style="max-width: 150px">
                    </td>
                </tr>
                <tr style="background-color: #CCC; ">
                    <td style="padding: 5px;" colspan="2" align="left">
                        Electronic Ticket
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px;" align="left" width="80%">
                        <?php echo $info['passenger_name_en'] . ' ' . $info['passenger_family_en'] ?>
                    </td>
                    <td style="padding: 5px;" align="left" width="20%">
                        Traveller:
                    </td>

                </tr>


                    <tr>
                        <td style="padding: 5px;" align="left" width="80%">
                            <?php echo $info['eticket_number']; ?>
                        </td>
                        <td style="padding: 5px;" align="left" width="20%">
                            E-TicketNumber:
                        </td>
                    </tr>




                <tr>
                    <td style="padding: 5px;" align="left" width="80%">
                        <?php echo date('Y M d', strtotime($info['creation_date'])); ?>
                    </td>
                    <td style="padding: 5px;" align="left" width="20%">
                        Date Of issue:
                    </td>

                </tr>

                <tr>
                    <td style="padding: 5px;" align="left" width="80%">

                        <?php
                                $price = functions::CurrencyCalculate($totalPrice );
                               echo  $price['AmountCurrency'];
                                $title_currency = $price['TypeCurrency'];

                                 echo   (($title_currency =="") ? 'IRR' : $title_currency);
                        ?>
                    </td>
                    <td style="padding: 5px;" align="left" width="20%">
                        Price:
                    </td>

                </tr>


            </table>

            <table width="100%" align="left" style="margin: 10px 100px " cellpadding="0" cellspacing="0"
                   class="page">
                <tr style="background-color: #CCC; ">
                    <td style="padding: 5px;" colspan="5" align="left">
                        flight Details
                    </td>
                </tr>

                <?php $detail = $info ;

                ?>

                    <tr>
                        <td style="padding: 5px;" align="left">
                            <table align="left" width="100%">
                                <tr>
                                    <td>
                                        <?php echo $Airport_origin['DepartureCityEn'] . ' ' . 'To' . ' ' . $Airport_destination['DepartureCityEn'] . ' ' . 'on' . ' ' . date('Y M d', strtotime($info['date_flight'])) ; ?>
                                    </td>
                                </tr>
                            </table>

                            <table align="left" width="100%">
                                <tr>


                                    <td style="padding: 5px;" width="20%">

                                    </td>
                                    <td style="padding: 5px;" width="20%">
                                        <?php
                                        echo 'Cabin/Class:' . ' ' . $detail['cabin_type'] . '/' . (($detail['seat_class'] == 'B' || $detail['seat_class'] == 'C') ? 'Business' : 'Economy');
                                        ?>
                                    </td>
                                    <td style="padding: 5px;" width="20%">
                                        <?php
                                        echo 'FlightNumber:' . ' ' . $detail['flight_number'] ;
                                        ?>
                                    </td>

                                    <td style="padding: 5px;" width="25%" align="left">
                                        <?php
                                        echo 'Airline:' . ' ' .  functions::InfoAirline($detail['airline_iata'])['name_en'] . '(' . $detail['airline_iata'] . ')';
                                        ?>
                                    </td>
                                    <td style="padding: 5px;" width="10%" align="left">
                                        <img src="<?php
                                        echo functions::getAirlinePhoto($detail['airline_iata']);
                                        ?>"
                                             style="width: 50px ; height: 30px; border: 1px solid #ccccff; border-radius:3mm / 3mm">
                                    </td>

                                </tr>
                            </table>

                            <table align="left" width="100%" style="border-bottom: 1px solid #ccccff">
                                <tr>

                                    <td style="padding: 5px;" width="15%" align="left">
                                        <?php
                                        echo 'Time:' . ' ' . $detail['time_flight'];
                                        ?>
                                    </td>
                                    <td style="padding: 5px;" width="15%" align="left">
                                        <?php
                                        echo 'Date:' . ' ' . date('Y M d', strtotime($detail['date_flight']));
                                        ?>
                                    </td>
                                    <td style="padding: 5px;" width="<?php echo $info['api_id']=='16' ? '50%' : '70%'?>" align="left">
                                        <?php

                                        echo 'Departure:' . ' ' . $Airport_origin['AirportEn'] . '(' . $detail['origin_airport_iata'] . ',' . $Airport_origin['DepartureCityEn'] . ',' . $Airport_origin['CountryEn'] . ')';
                                        ?>
                                    </td>


                                </tr>
                                <tr>

                                    <td style="padding: 5px;" width="<?php echo $info['api_id']=='16' ? '15%' : '25%'?>" align="left">
                                        <?php
                                        //echo 'Time:' . ' ' . $detail['time_flight'];
                                        ?>
                                    </td>
                                    <td style="padding: 5px;" width="<?php echo $info['api_id']=='16' ? '15%' : '25%'?>" align="left">
                                        <?php
//                                        echo  !empty($detail['date_flight']) ? 'Date:' . ' ' .  date('Y M d', strtotime($detail['date_flight'])) : '';
                                        ?>
                                    </td>
                                    <td style="padding: 5px;" width="50%" align="left">
                                        <?php
                                        echo 'Arrival:' . ' ' . $Airport_destination['AirportEn'] . '(' . $detail['desti_airport_iata'] . ',' . $Airport_destination['DepartureCityEn'] . ',' . $Airport_destination['CountryEn'] . ')';
                                        ?>
                                    </td>


                                </tr>
                            </table>

                        </td>


                    </tr>

            </table>
            <table width="100%" align="center" style="margin: 10px 100px;"
                   cellpadding="0" cellspacing="0" class="page">

                <tr style="background-color: #CCC; ">
                    <td style="padding: 5px;" align="left">
                        Fare Conditions
                    </td>
                </tr>
                <tr style=" ">
                    <td style="padding: 5px;" align="left">

                        <p>-Cancellation charges shall be as per airline rules. Service charge is applicable for issue, change, refund.</p>
                        <br/>
                        <p>-Date change charges as applicable.</p>
                        <br/>
                        <p>E-Ticket Notice</p>
                        <br/>
                        <p>Carriage and other service provided by the carrier are subject to terms & conditions of carriage. These conditions may be obtained from the
                            respective carrier.</p>
                        <br/>
                        <p>check-in Time</p>
                        <br/>
                        <p>We Recommend the following minimum check-in time:- Domestic - 2 hour prior to departure. All other destinations (i---ding USA) -4 hours prior to
                            departure.</p>
                        <br/>
                        <p>Passport/Visa/Health</p>
                        <br/>
                        <p>Please ensure that you have all the required travel documents for your entire journey i.e., valid Passport & necessary visas, and that you have had the
                            recommended inoculations for your destination(s).
                            Insurance</p>
                        <br/>
                        <p>We strongly recommend that you avail travel insurance for the antire journey.</p>
                        <br/>
                        <p>Online check  in mandatory</p>
                        <br/>
                        <p>UKraine International Airlines require you to do a mandatory online Check-in up to 24 hours prior to departure. UKrain International
                            Airlines can charge 60 EUR or more passenger for not carrying an online boarding pass to the check-in counter. Please contact us 24
                            hours prior to departure with a copy of the passport to complete online check-in. We will take no responsibility if the UKraine International
                            Airlines check-in counter denies boarding or charges any additional fee for not carrying an online boarding pass. Please contact us for your
                            boarding pass.</p>
                        <br/>
                    </td>
                </tr>


            </table>

            <table width="100%" align="center" style="margin: 10px 100px ;border:1px solid #6c6c6c  "
                   cellpadding="0" cellspacing="0" class="page">

                <tr style=" ">
                    <td style="padding: 5px;" align="right">
                        <p>کاربر گرامی لطفا به نکات زیر توجه فرمائید:</p>
                        <br/>
                        <p>این سیستم امکان تهیه بلیط هواپیما در تمام دنیا را برای مسافران محترم فراهم نموده است؛
                            اعتبار بلیط صادره را تضمین نموده و از سوی دیگر بررسی صحت مدارک لازمه سفر جهت ورود به
                            کشور مقصد و یا نقطه میانی (ترانزیت)از قبیل دارا بودن دو طرفه ،واچر هتل انواع ویزا و سایر
                            مدارک و فرم های مورد نیاز و محدودیت های گمرکی ،ارزی و ... به عمده مسافر می باشد</p>
                        <br/>
                        <p>انقضا پاسپورت شما بایستی 180 روز از تاریخ برگشت اعتبار داشته باشد</p>
                        <br/>
                        <p>در صورتی که پرواز شما از ایرلاین اوکراینی  باشد،برای استفاده از این بلیط باید 24 ساعت قبل از پرواز از طریق وب سایت ایرلاین مذکور اقدام به
                            دریافت کارت پرواز خود نموده و برگه پرینت شده را حتما همراه خود داشته باشید</p>
                        <br/>
                        <p>لطفا 48 ساعت قبل از سفر حتما هماهنگی های لازم را با این شرکت به عمل آورید ،در غیر این
                            صورت ایرلاین مربوطه 60 یورو ،هزینه کارت پرواز را از شما دریافت خواهد کرد</p>


                    </td>
                </tr>




            </table>



            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <div class="element"></div>
            <div class="element"></div>

            <?php

        }?>

        </body>
        </html>
        <?php
        return $PrintTicket = ob_get_clean();
    }


    public function getRequestNumberTicket($factorNumber)
    {

        if (TYPE_ADMIN == '1') {

            Load::autoload('ModelBase');
            $ModelBase = new ModelBase();
            $sql = " SELECT *
                 FROM report_tb
                 WHERE factor_number='{$factorNumber}'
                 GROUP BY request_number";
            $Book = $ModelBase->select($sql);

        } else {

            Load::autoload('Model');
            $Model = new Model();
            $sql = " SELECT *
                 FROM book_local_tb 
                 WHERE factor_number='{$factorNumber}'
                 GROUP BY request_number
                 ";
            $Book = $Model->select($sql);
        }

        foreach ($Book as $k=>$val){
            $result[$k]['ticket_info'] = $val;
            $result[$k]['request_number'] = $val['request_number'];
            if ($val['direction']=='dept'){
                $result[$k]['direction'] = 'رفت';
            }else {
                $result[$k]['direction'] = 'برگشت';
            }

        }

        return $result;

    }


}