<?php

/**
 * Class BookingTourLocal
 * @property BookingTourLocal $BookingTourLocal
 */
class BookingTourLocal extends clientAuth
{
    public $okBook = '';
    public $type_application = '';
    public $error = '';
    public $errorMessage = '';
    public $factorNumber = '';
    public $tourInfo = '';
    public $status = '';
    public $tracking_code_bank = '';
    public $payment_date = '';


    public function __construct()
    {

    }

    public function setPortBankForTour($bankDir, $factorNumber , $paymentStatus = null)
    {
        $initialValues = array(
            'bank_dir' => $bankDir,
            'serviceTitle' => $_POST['serviceType']
        );
	
	    /** @var bankList_tb $bankModel */
	    $bankModel = Load::model('bankList');
        $bankInfo  = $bankModel->getByBankDir($initialValues);

        $data['name_bank_port'] = $bankDir;
        $data['number_bank_port'] = $bankInfo['param1'];
        $data['payment_status'] = $paymentStatus;

        $Model = Load::library('Model');
        $Model->setTable('book_tour_local_tb');

        $condition = " factor_number='{$factorNumber}'";
        $res = $Model->update($data, $condition);
        if ($res) {
            $ModelBase = Load::library('ModelBase');
            $ModelBase->setTable('report_tour_tb');
            $ModelBase->update($data, $condition);
        }
    }

    public function sendUserToBankForTour($factorNumber , $paymentStatus = null)
    {
        if($paymentStatus == 'fullPayment') {
            $data = array(
                'status' => "PreReserve"
            );
        }else{
            $data = array(
                'status' => "bank"
            );
        }


        $condition = " factor_number ='{$factorNumber}' ";
        Load::autoload('Model');
        $Model = new Model();

        $Model->setTable('book_tour_local_tb');
        $Model->update($data, $condition);

        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $ModelBase->setTable('report_tour_tb');
        $ModelBase->update($data, $condition);
    }

    public function updateBank($codRahgiri, $factorNumber)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $infoBook = functions::GetInfoTour($factorNumber);

        if (empty($infoBook['payment_status'])) {

            $data = array(
                'tracking_code_bank' => "" . $codRahgiri . "",
                'payment_date' => Date('Y-m-d H:i:s')
            );

        } elseif ($infoBook['payment_status'] = 'prePayment') {

            $data = array(
                'tracking_code_bank' => "" . $infoBook['tracking_code_bank'] . '|' . $codRahgiri . "",
                'payment_date' => $infoBook['payment_date'] . '|' . Date('Y-m-d H:i:s')
            );
        }

        $condition = " factor_number='" . $factorNumber . "' AND (status = 'bank' OR status = 'PreReserve')";
        $Model->setTable('book_tour_local_tb');
        $Model->update($data, $condition);

        $ModelBase->setTable('report_tour_tb');
        $ModelBase->update($data, $condition);


        $d['PaymentStatus'] = 'success';
        $d['BankTrackingCode'] = $codRahgiri;
        $condition = " FactorNumber='" . $factorNumber . "' ";
        $Model->setTable('transaction_tb');
        $Model->update($d, $condition);
    }

    public function delete_transaction_current($factorNumber)
    {
        if (!$this->checkBookStatus($factorNumber)) {
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

        $query = "SELECT status FROM book_tour_local_tb WHERE factor_number = '{$factorNumber}'";
        $result = $Model->load($query);

        return $result['status'] == 'BookedSuccessfully' ? true : false;
    }

    public function tourBook($factorNumber, $paymentType)
    {

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $bookTourLocalModel = Load::getModel( 'bookTourLocalModel' );

        $objTransaction = Load::controller('transaction');
        $smsController = Load::controller('smsServices');

        $factorNumber = trim($factorNumber);
        $this->factorNumber = $factorNumber;
        $Tour = $bookTourLocalModel
            ->get()
            ->where('factor_number',$this->factorNumber)
            ->groupBy('factor_number')
            ->find();

        $infoBook = functions::GetInfoTour($factorNumber);

        $this->tourInfo = $infoBook;

        if (empty($infoBook['payment_status'])) {

            $data['status'] = 'TemporaryReservation';
            $data['payment_status'] = 'prePayment';

            $this->status = 'TemporaryReservation';
            $this->tracking_code_bank = $infoBook['tracking_code_bank'];
            $this->payment_date = $infoBook['payment_date'];


        } elseif ($infoBook['payment_status'] == 'prePayment') {


            $prePaymentStatus= 'PreReserve';
            
            
            $data['status'] = $prePaymentStatus;

            $exp = explode("|", $infoBook['tracking_code_bank']);

            $exp_date = explode("|", $infoBook['payment_date']);
            $this->status = $prePaymentStatus;
            $this->tracking_code_bank = $exp[1];
            $this->payment_date = $exp_date[1];



            // reduceCapacity
            $this->reduceCapacity($factorNumber);

        }
        elseif ($infoBook['payment_status'] == 'fullPayment') {
            $this->status = 'BookedSuccessfully';
            $data['status'] = 'BookedSuccessfully';
            $this->reduceCapacity($factorNumber);

        }

        $data['payment_date'] = date('Y-m-d H:i:s');
        if ($paymentType == 'cash' && $infoBook['tracking_code_bank'] == 'member_credit') {
            $data['payment_type'] = 'member_credit';
            $data['tracking_code_bank'] = '';

            // Caution: آپدیت تراکنش به موفق
            $objTransaction->setCreditToSuccess($factorNumber, $infoBook['tracking_code_bank']);

        } else {
            $data['payment_type'] = $paymentType;
        }
        $data['creation_date_int'] = time();


        $condition = " factor_number='{$factorNumber}'";
        $Model->setTable('book_tour_local_tb');
        $res = $Model->update($data, $condition);

            if($infoBook['is_api'] && $infoBook['client_id_api'] > 0){
                $admin = Load::controller('admin');
                $admin->ConectDbClient('', $infoBook['client_id_api'], 'Update', $data, 'book_tour_local_tb', $condition);
            }

        if ($res) {

            $ModelBase->setTable('report_tour_tb');
            $res2 = $ModelBase->update($data, $condition);
            if ($res2) {

                $this->okBook = true;
                $this->payment_date = $data['payment_date'];

                $smsMember = '';
                $smsManager = '';
                if (empty($infoBook['payment_status']) || $infoBook['payment_status'] == 'prePayment') {

                    $smsMessageTitle = 'temporaryReservationTour';
                    //to member
                    $smsMember = " کانتر گرامی " . "{$infoBook['tour_agency_user_name']}" . " درخواست پیش رزرو تور " . $infoBook['tour_name'] . " منتظر بررسی و تایید نهایی شماست. ";
                    //to site manager
                    $smsManager = " مدیر گرامی " . CLIENT_NAME . " درخواست پیش رزرو تور " . $infoBook['tour_name'] . " با موفقیت ثبت شد. ";

                } elseif ($infoBook['payment_status'] = 'fullPayment') {

                    if(Session::IsLogin()){
                        $data_point = [
                            'service'=>'Tour',
                            'service_title'=>$Tour['serviceTitle'],
                            'factor_number'=>$this->factorNumber,
                            'base_company'=>'all',
                            'company'=>'all',
                            'counter_id'=> Session::getCounterTypeId(),
                            'price'=> $Tour['tour_total_price'],
                        ];


                        $this->getController('historyPointClub')->setPointMemberIntoTable($data_point);

                    }

                    $smsMessageTitle = 'bookedSuccessfullyTour';
                    //to member
                    $smsMember = " کانتر گرامی " . "{$infoBook['tour_agency_user_name']}" . " رزرو تور " . $infoBook['tour_name'] . " پرداخت و ثبت نهایی شد. ";
                    //to site manager
                    $smsManager = " مدیر گرامی " . CLIENT_NAME . " رزرو تور " . $infoBook['tour_name'] . " پرداخت و ثبت نهایی شد. ";
                }

                //sms to member
                $smsMember .= PHP_EOL . " شماره فاکتور: " . $factorNumber;
                $objSms = $smsController->initService('0');
                if ($objSms) {
                    $smsArray = array(
                        'smsMessage' => $smsMember,
                        'cellNumber' => $infoBook['tour_agency_user_mobile']
                    );
                    $smsController->sendSMS($smsArray);
                }


                //sms to site manager
                $smsManager .= PHP_EOL . " شماره فاکتور: " . $factorNumber;
                $objSms = $smsController->initService('1');
                if ($objSms) {
                    $smsArray = array(
                        'smsMessage' => $smsManager,
                        'cellNumber' => CLIENT_MOBILE
                    );
                    $smsController->sendSMS($smsArray);
                }


                //sms to buyer
                $objSms = $smsController->initService('0');
                if ($objSms) {
                    $mobile = $infoBook['member_mobile'];
                    $name = $infoBook['passenger_name'] . ' ' . $infoBook['passenger_family'];

                    $messageVariables = array(
                        'sms_name' => $name,
                        'sms_service' => 'تور',
                        'sms_factor_number' => $factorNumber,
                        'sms_cost' => $infoBook['total_price'],
                        'sms_tour_name' => $infoBook['tour_name'],
                        'sms_tour_night' => $infoBook['tour_night'],
                        'sms_tour_day' => $infoBook['tour_day'],
                        'sms_tour_cities' => $infoBook['tour_cities'],
                        'sms_tour_dept_date' => $infoBook['tour_start_date'],
                        'sms_tour_return_date' => $infoBook['tour_end_date'],
                        'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=BookingTourLocal&id=" . $factorNumber,
                        'sms_agency' => CLIENT_NAME,
                        'sms_agency_mobile' => CLIENT_MOBILE,
                        'sms_agency_phone' => CLIENT_PHONE,
                        'sms_agency_email' => CLIENT_EMAIL,
                        'sms_agency_address' => CLIENT_ADDRESS,
                    );
                    $smsArray = array(
                        'smsMessage' => $smsController->getUsableMessage($smsMessageTitle, $messageVariables),
                        'cellNumber' => $mobile,
                        'smsMessageTitle' => $smsMessageTitle,
                        'memberID' => (!empty($infoBook['member_id']) ? $infoBook['member_id'] : ''),
                        'receiverName' => $messageVariables['sms_name'],
                    );

                    $smsController->sendSMS($smsArray);

                }


                //send email
                $this->emailTourSelf($factorNumber);

            } else {
                $this->okBook = false;
                $this->error = true;
                $this->errorMessage = 'مشکل در فرآیند رزرو پیش آمده است. لطفا با پشتیبانی آژانس تماس بگیرید.';
            }

        } else {
            $this->okBook = false;
            $this->error = true;
            $this->errorMessage = 'مشکل در فرآیند رزرو پیش آمده است. لطفا با پشتیبانی آژانس تماس بگیرید.';
        }



    }

    public function reduceCapacity($factorNumber)
    {

        $Model = Load::library('Model');
        $sql = " SELECT tour_id, tour_night, tour_day, tour_package FROM book_tour_local_tb WHERE factor_number = '{$factorNumber}' ";
        $resultBook = $Model->load($sql);
        $tour_sql = " SELECT * FROM reservation_tour_package_tb WHERE fk_tour_id = '{$resultBook['tour_id']}' ";
        $resultTour = $Model->load($tour_sql);

        if (!empty($resultBook) && $resultBook['tour_night'] > 1) {
            $packages = json_decode($resultBook['tour_package'], true);

            $sqlUpdate = " UPDATE reservation_tour_package_tb SET ";
            if (isset($packages['infoRooms']['single_room']['count']) && $packages['infoRooms']['single_room']['count'] > 0) {
                $sqlUpdate .= " single_room_capacity = single_room_capacity - " . $packages['infoRooms']['single_room']['count'] . ", ";
            }
            if (isset($packages['infoRooms']['double_room']['count']) && $packages['infoRooms']['double_room']['count'] > 0) {
                $sqlUpdate .= " double_room_capacity = double_room_capacity - " . $packages['infoRooms']['double_room']['count'] . ", ";
            }
            if (isset($packages['infoRooms']['three_room']['count']) && $packages['infoRooms']['three_room']['count'] > 0) {
                $sqlUpdate .= " three_room_capacity = three_room_capacity - " . $packages['infoRooms']['three_room']['count'] . ", ";
            }
            if (isset($packages['infoRooms']['child_with_bed']['count']) && $packages['infoRooms']['child_with_bed']['count'] > 0) {
                $sqlUpdate .= " child_with_bed_capacity = child_with_bed_capacity - " . $packages['infoRooms']['child_with_bed']['count'] . ", ";
            }
            if (isset($packages['infoRooms']['infant_without_bed']['count']) && $packages['infoRooms']['infant_without_bed']['count'] > 0) {
                $sqlUpdate .= " infant_without_bed_capacity = infant_without_bed_capacity - " . $packages['infoRooms']['infant_without_bed']['count'] . ", ";
            }
            if (isset($packages['infoRooms']['infant_without_chair']['count']) && $packages['infoRooms']['infant_without_chair']['count'] > 0) {
                $sqlUpdate .= " infant_without_chair_capacity = infant_without_chair_capacity - " . $packages['infoRooms']['infant_without_chair']['count'] . ", ";
            }
            if ((isset($packages['infoRooms']['four_room']['count']) && $packages['infoRooms']['four_room']['count'] > 0) ||
                isset($packages['infoRooms']['five_room']['count']) && $packages['infoRooms']['five_room']['count'] > 0 ||
                isset($packages['infoRooms']['six_room']['count']) && $packages['infoRooms']['six_room']['count'] > 0) {
                $custom_rooms = json_decode($resultTour['custom_room'],true);
                foreach ($custom_rooms as $key => $single_room) {
                   if(isset($single_room['fourRoom'])  && $packages['infoRooms']['four_room']['count'] > 0) {
                       $custom_rooms[$key]['fourRoom']['capacity'] = $single_room['fourRoom']['capacity'] - $packages['infoRooms']['four_room']['count'];
                   }elseif (isset($single_room['fiveRoom']) && $packages['infoRooms']['five_room']['count'] > 0 ) {
                       $custom_rooms[$key]['fiveRoom']['capacity'] = $single_room['fiveRoom']['capacity'] - $packages['infoRooms']['five_room']['count'];
                   }elseif (isset($single_room['sixroom']) && $packages['infoRooms']['six_room']['count'] > 0) {
                       $custom_rooms[$key]['sixRoom']['capacity'] = $single_room['sixRoom']['capacity'] - $packages['infoRooms']['six_room']['count'];
                   }
                }
                $new_custom_room = json_encode($custom_rooms , 256) ;
                $sqlUpdate .= " custom_room = '" . $new_custom_room . "', ";
            }
            $sqlUpdate = substr($sqlUpdate, 0, -2);
            $sqlUpdate .= " WHERE fk_tour_id = '{$resultBook['tour_id']}' ";
          
            $Model->updateByQuery($sqlUpdate);

        }

    }

    public function emailTourSelf($factorNumber)
    {
        $infoBook = functions::GetInfoTour($factorNumber);
        if (!empty($infoBook) && !empty($infoBook['member_email'])) {

            /*$pdfUrl = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=BookingTourLocal&id=' . $factorNumber;

            $emailContent = '
            <tr>
                <td valign="top" class="mcnTextContent" style="padding: 18px;color: #000000;font-size: 14px;font-weight: normal;text-align: center;">
                    <h3 class="m_-2679729263370124627null" style="text-align:center;display:block;margin:0;padding:0;color:#000000;font-family:tahoma,verdana,segoe,sans-serif;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal">
رزرو تور 
                        <span style="color:#FFFFFF"><strong>' . $infoBook['tour_name'] . ' ' . $infoBook['tour_code'] . '</strong></span>
                    </h3>
                    <div style="margin-top: 20px;text-align:right;color:#FFFFFF; font-family:tahoma,verdana,segoe,sans-serif">
                    با سلام <br>
دوست عزیز؛ از اینکه خدمات ما را انتخاب نموده اید سپاسگزاریم <br>
                     لطفا جهت مشاهده و چاپ واچر رزرو تور بر روی دکمه چاپ واچر رزرو تور که در قسمت پایین قرار دارد کلیک نمایید 
                    </div>
                </td>
            </tr>
            ';

            $pdfButton = '
            <tr>
                <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 14px;">
                    <a class="mcnButton " title="چاپ واچر رزرو تور" href="' . $pdfUrl . '" target="_blank" style="background-color: #284861;padding: 15px;margin:5px 0;border-radius: 10px;font-weight: bold;letter-spacing: 0px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">چاپ واچر رزرو تور</a>
                </td>
            </tr>
            ';*/


            $emailBody = 'با سلام' . '<br>';
            $emailBody .= 'دوست عزیز؛ از اینکه خدمات ما را انتخاب نموده اید سپاسگزاریم' . '<br>';
            $emailBody .= 'لطفا جهت مشاهده و چاپ واچر رزرو تور بر روی دکمه چاپ واچر رزرو تور که در قسمت پایین قرار دارد کلیک نمایید' . '<br>';

            $param['title'] = $infoBook['tour_name'] . ' ' . $infoBook['tour_code'];
            $param['body'] = $emailBody;
            $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=BookingTourLocal&id=' . $factorNumber;
            $param['pdf'][0]['button_title'] = 'چاپ واچر رزرو تور';

            $to = $infoBook['member_email'];
            $subject = "رزرو تور";
            $message = functions::emailTemplate($param);
            $headers = "From: noreply@" . CLIENT_DOMAIN . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8";
            ini_set('SMTP', 'smtphost');
            ini_set('smtp_port', 25);

            mail($to, $subject, $message, $headers);
        }
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
        $printBoxCheck = '';
        $printBoxCheck .= ' <!DOCTYPE html>
                <html>
                    <head>
                        <meta charset="UTF-8">
                        <title>'.functions::Xmlinformation('ShowTourPdf').'</title>
                    </head>
                    <body>';

        $info = functions::GetInfoTour($factorNumber);
        /** @var resultTourLocal $resultTourLocal */
        $resultTourLocal=$this->getController('resultTourLocal');
        $resultTourLocal->getInfoTourByIdTour($info['tour_id']);
        /** @var reservationTour $reservationTour */
        $reservationTour=$this->getController('reservationTour');
        $packages=$reservationTour->infoTourPackageByIdTour($info['tour_id']);

        $array_package=[];
        $package = json_decode($info['tour_package'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


            $hotels = $reservationTour->infoTourHotelByIdPackage($package['id']);

            
            foreach ($hotels as $hotel_key => $hotel) {
                $hotel_information = $reservationTour->getHotelInformation($hotel['fk_hotel_id']);
                $tour_route_information = $reservationTour->infoTourRoutByIdPackage($package['id'], $hotel['fk_city_id']);

                $array_package['hotels'][$hotel_key] = $hotel_information;
                $array_package['hotels'][$hotel_key]['night'] = $tour_route_information[0]['night'];
                $array_package['hotels'][$hotel_key]['room_service'] = $tour_route_information[0]['room_service'];
            }



        $cities=[];
        if(SOFTWARE_LANG === 'fa'){
            $index_name='name';
            $index_name_tag='name_fa';
            $index_city='city_name';
        }else{
            $index_name=$index_name_tag='name_en';
            $index_city='city_name_en';


        }

        foreach($resultTourLocal->arrayTour['infoTourRout'] as $route)
        {
            $cities[] = $route[$index_name];
        }


        $infoAgency = functions::infoAgencyByMemberId($info['tour_agency_user_id']);
        if (!empty($info)) {
	        $LogoAgency = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_LOGO;
	        
	        $access_show_client_logo = functions::checkClientConfigurationAccess('show_agency_logo_in_tour_voucher',CLIENT_ID);

	        if($access_show_client_logo){
	        	$LogoAgency = ROOT_ADDRESS_WITHOUT_LANG . '/pic/agencyPartner/'.CLIENT_ID.'/logo/' . $infoAgency['logo'];
	        }

	        
	        
            $printBoxCheck .= '<div style="margin:30px auto 0;background-color: #fff;line-height: 24px;">
        
                                <div style="margin:30px auto 0;background-color: #fff;">
                
                    <div style="margin: 10px auto 0;">
                        
                        <div style="margin: 20px 0 0 0;width: 45%;display: inline-block;text-align: center;height: 67px;float: right;">
                            <span style="display: block;width: 100%;margin-bottom: 5px;">
                                <img src="' .$LogoAgency . '" style="max-height: 80px;">
                            </span>
                            <span style="display: block;width: 100%;">'.functions::Xmlinformation('ProvidedTourAgency').': ' . $info['tour_agency_name'] . '</span>
                        </div>
                        </div>';

            $printBoxCheck .= '
                    <div style="border: 1px solid #2E3231;margin: 5px 40px 5px 40px;">

                    <div class="row" style="padding: 8px;font-weight: bold;background-color: #0077db;margin: 0;color: #fff;">

                        <div style="width: 22%;position: relative;float: right;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                    <span>';

            if ($info['status'] == 'BookedSuccessfully'){
                $printBoxCheck .= functions::Xmlinformation('Definitivereservation');
            } elseif ($info['status'] == 'TemporaryReservation'){
                $printBoxCheck .= functions::Xmlinformation('Temporaryreservation');
            }

            $printBoxCheck .= '</span>
                        </div>

                        <div style="width: 22%;position: relative;float: right;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                    <span style="font-weight: bold;">'.functions::Xmlinformation('WachterNumber').' : </span><span>';
            $printBoxCheck .= $info['factor_number'];
            $printBoxCheck .= '</span>
                        </div>';

            $payDate = functions::set_date_payment($info['payment_date']);
            $payDate = explode(' ', $payDate);

            $printBoxCheck .= '
                        <div style="width: 22%;position: relative;float: right;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">'.functions::Xmlinformation('Buydate').' : </span><span>';
            $printBoxCheck .= $payDate[0];
            $printBoxCheck .= '</span>
                        </div>

                        <div style="width: 22%;position: relative;float: right;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">'.functions::Xmlinformation('Buytime').' : </span><span>';
            $printBoxCheck .= $payDate[1];
            $printBoxCheck .= '</span>
                        </div>

                    </div>';


            $printBoxCheck .= '
                    <div class="row" style="padding: 8px;margin: 0;">
                        <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                            <span style="font-weight: bold;">'.functions::Xmlinformation('Nametour').' : </span><span>';
            $printBoxCheck .= $info['tour_name'];
            $printBoxCheck .= '</span>
                        </div>

                        <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">'.functions::Xmlinformation('codeTour').' : </span><span>';
            $printBoxCheck .= $info['tour_code'];
            $printBoxCheck .= '</span>
                        </div>
                        
                        <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">'.functions::Xmlinformation('TotalPrice').' : </span><span>';
            $printBoxCheck .= number_format($info['total_price']);
            $printBoxCheck .= '</span>
                        </div>
                        
                        <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">'.functions::Xmlinformation('Pricepayment').' : </span><span>';

            $printBoxCheck .= ($info['status'] == 'BookedSuccessfully'?number_format($info['total_price']):number_format($info['tour_payments_price']));
            $printBoxCheck .= '</span>
                        </div>
                        
                    </div>';


            $printBoxCheck .= '
                    <div class="row" style="padding: 8px;margin: 0;">
                        
                        <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                            <span style="font-weight: bold;">'.functions::Xmlinformation('Origin').' : </span><span>';
            if(SOFTWARE_LANG === 'fa'){
                $printBoxCheck .= $resultTourLocal->arrayTour['infoTour']['country_name'] . ' - ' . $resultTourLocal->arrayTour['infoTour']['name'] . ' - ' . $info['tour_origin_region_name'];
            }else{
                $printBoxCheck .= $resultTourLocal->arrayTour['infoTour']['country_name_en'] . ' - ' . $resultTourLocal->arrayTour['infoTour']['name_en'] . ' - ' . $info['tour_origin_region_name'];
            }
            $printBoxCheck .= '</span>
                        </div>

                        <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                            <span style="font-weight: bold;">'.functions::Xmlinformation('ToursOfCity').' : </span><span>';
            $printBoxCheck .= join(", ",$cities);
            $printBoxCheck .= '</span>
                        </div>

                        <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">'.functions::Xmlinformation('Datetravelwent').' : </span><span>';
            $printBoxCheck .= $info['tour_start_date'];
            $printBoxCheck .= '</span>
                        </div>
                        
                        <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">'.functions::Xmlinformation('Datewentback').' : </span><span>';
            $printBoxCheck .= $info['tour_end_date'];
            $printBoxCheck .= '</span>
                        </div>
                        
                    </div>';

            $printBoxCheck .= '
                    <div class="row" style="padding: 8px;margin: 0;">
                        <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">';
            if ($info['tour_night'] != '0') {
                $printBoxCheck .= '<span style="font-weight: bold;">';
                $printBoxCheck .= $info['tour_night'];
                $printBoxCheck .= '</span>
                            <span style="font-weight: bold;"> '.functions::Xmlinformation('Night').' </span>';
            } else {
                $printBoxCheck .= '<span>';
                $printBoxCheck .= $info['tour_day'];
                $printBoxCheck .= '</span>
                            <span style="font-weight: bold;"> '.functions::Xmlinformation('Day').' </span>';
            }

            $printBoxCheck .= '</div>

                        <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">'.functions::Xmlinformation('Baggage').' : </span><span>';
            $printBoxCheck .= $info['tour_free'];
            $printBoxCheck .= '</span>
                            <span style="font-weight: bold;"> '.functions::Xmlinformation('Kilograms').' </span>
                        </div>
                        
                        <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">'.functions::Xmlinformation('Visa').' : </span><span>';
            if ($info['tour_visa'] == 'yes') {
                $printBoxCheck .= functions::Xmlinformation('Have');
            } else {
                $printBoxCheck .= functions::Xmlinformation('Donthave');
            }
            $printBoxCheck .= '</span>
                        </div>
                        
                        <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">'.functions::Xmlinformation('Insurance').' : </span><span>';
            if ($info['tour_insurance'] == 'yes') {
                $printBoxCheck .= functions::Xmlinformation('Have');
            } else {
                $printBoxCheck .= functions::Xmlinformation('Donthave');
            }
            $printBoxCheck .= '</span>
                        </div>
                        
                    </div>';


            $printBoxCheck .= '
                    <div class="row" style="padding: 8px;margin: 0;">
                    
                        <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;"> '.functions::Xmlinformation('Went').': ';
            if(SOFTWARE_LANG === 'fa'){
                $printBoxCheck .= $info['tour_type_vehicle_name_dept'];
            }else{
                $printBoxCheck .= functions::vehicleEnName($info['tour_type_vehicle_name_dept']);
            }
            $printBoxCheck .= ' </span><span>';
            $printBoxCheck .= $resultTourLocal->arrayTour['arrayTypeVehicle']['dept']['vehicle'][$index_name_tag];
            $printBoxCheck .= '</span>
                        </div>
                        
                        <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;"> '.functions::Xmlinformation('JustReturn').': ';
            if(SOFTWARE_LANG === 'fa'){
                $printBoxCheck .= $info['tour_type_vehicle_name_return'];
            }else{
                $printBoxCheck .= functions::vehicleEnName($info['tour_type_vehicle_name_return']);
            }
            $printBoxCheck .= ' </span><span>';
            $printBoxCheck .= $resultTourLocal->arrayTour['arrayTypeVehicle']['return']['vehicle'][$index_name_tag];
            $printBoxCheck .= '</span>
                        </div>
                        
                    </div>';


            $printBoxCheck .= '
            </div>';


            $printBoxCheck .= '
                    <div style="border: 1px solid #2E3231;margin: 5px 40px 5px 40px;">
                      <div class="row" style="padding: 8px;margin: 0;ont: inherit;vertical-align: baseline;background-color: #0077db;color:#fff">
                          <div class="col-md-12 modal-text-center modal-h"
                              style="text-align: center;font-size: 18px !important;width: 100%;font-weight: bold;">
                                        <span>'.functions::Xmlinformation('Package').'</span>
                          </div>
                      </div> ';

            $package = json_decode($info['tour_package'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            if ($info['tour_night'] == 0) {

                $printBoxCheck .= '
                   <div class="row" style="padding: 8px;margin: 0;">';

                $printBoxCheck .= '
                        <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">' . $package['adult_count_oneDayTour'] . ' '.functions::Xmlinformation('Adt').': </span>
                            <span>' . number_format($package['adult_price_oneDayTour']) . ' '.functions::Xmlinformation('Rial').'</span>
                        </div>
                            ';

                if ($package['child_count_oneDayTour'] > 0) {
                    $printBoxCheck .= '
                        <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">' . $package['child_count_oneDayTour'] . ' '.functions::Xmlinformation('Chd').': </span>
                            <span>' . number_format($package['child_price_oneDayTour']) . ' '.functions::Xmlinformation('Rial').'</span>
                        </div>
                            ';
                }

                if ($package['infant_count_oneDayTour'] > 0) {
                    $printBoxCheck .= '
                        <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">' . $package['infant_count_oneDayTour'] . ' '.functions::Xmlinformation('Inf').': </span>
                            <span>' . number_format($package['infant_price_oneDayTour']) . ' '.functions::Xmlinformation('Rial').'</span>
                        </div>
                            ';
                }

                $printBoxCheck .= '
                    </div>';

            } else {


                $printBoxCheck .= '
                   <div class="row" style="padding: 8px;margin: 0;">';




                foreach ($array_package['hotels'] as $hotel) {


                    $printBoxCheck .= '
                        <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">'.functions::Xmlinformation('Hotelstaycity').' ' . $hotel[$index_city] . '</span>
                            <span></span>
                        </div>
                            ';
                    $printBoxCheck .= '
                        <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">'.functions::Xmlinformation('Hotel').' : </span>
                            <span>' . $hotel[$index_name] . '</span>
                        </div>
                            ';
                    $printBoxCheck .= '
                        <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">'.functions::Xmlinformation('Service').' : </span>
                            <span>' . $hotel['room_service'] . '</span>
                        </div>
                            ';

                }




                $printBoxCheck .= '
                    </div>';

                $printBoxCheck .= '
                   <div class="row" style="padding: 8px;margin: 0;">';

                foreach ($package['infoRooms'] as $room) {
                    $printBoxCheck .= '
                                <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">' . $room['count'] . ' '.functions::Xmlinformation('RoomCount').' ' . $room['name_fa'][0] . ': </span>
                                    <span>' . number_format($room['total_price']) . ' '.functions::Xmlinformation('Rial').'</span>
                                    ';
                    if ($room['total_price_a'] > 0) {
                        $printBoxCheck .= '
                                     + <span>' . number_format($room['total_price_a']) . ' ' . $room['currency_type'] . '</span>';
                    }

                    $printBoxCheck .= '
                                </div>
                                    ';
                }

                $printBoxCheck .= '
                    </div>';

            }


            $printBoxCheck .= '</div>';

            $printBoxCheck .= '
                     </div> ';

            $printBoxCheck .= '
                    <div style="border: 1px solid #2E3231;margin: 5px 40px 5px 40px;">
                      <div class="row" style="padding: 8px;margin: 0;ont: inherit;vertical-align: baseline;background-color: #0077db;color:#fff;">
                          <div class="col-md-12 modal-text-center modal-h"
                              style="text-align: center;font-size: 18px !important;width: 100%;font-weight: bold;">
                                        <span>'.functions::Xmlinformation('Travelerprofile').'</span>
                          </div>
                      </div> ';

            $infoTourPassengers = functions::GetInfoTourPassengers($factorNumber);

            foreach ($infoTourPassengers as $passengers) {
                $printBoxCheck .= '
                   <div class="row" style="padding: 8px;margin: 0;">
                        <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('Namefamily').' : </span><span>';
                $printBoxCheck .= $passengers['passenger_name'] . ' ' . $passengers['passenger_family'];
                $printBoxCheck .= '<br>' . $passengers['passenger_name_en'] . ' ' . $passengers['passenger_family_en'];
                $printBoxCheck .= '</span>
                        </div>
                        ';

                $printBoxCheck .= '<div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">';
                if ($passengers['passenger_national_code'] != "") {
                    $printBoxCheck .= '<span style="font-weight: bold;">'.functions::Xmlinformation('Nationalnumber').':</span><span>';
                    $printBoxCheck .= $passengers['passenger_national_code'];
                    $printBoxCheck .= '</span>';
                }
                if ($passengers['passportNumber'] != "") {
                    $printBoxCheck .= '<br><span style="font-weight: bold;">'.functions::Xmlinformation('Numpassport').':</span><span>';
                    $printBoxCheck .= $passengers['passportNumber'];
                    $printBoxCheck .= '</span>';
                }
                $printBoxCheck .= '</div>
                        <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('DateOfBirth').': </span><span>';

                if ($passengers['passenger_birthday'] != "") {
                    $printBoxCheck .= $passengers['passenger_birthday'];
                } else {
                    $printBoxCheck .= $passengers['passenger_birthday_en'];
                }

                $printBoxCheck .= '</span>
                        </div>
                        
                    </div>';
            }


            $printBoxCheck .= '</div>';

            $printBoxCheck .= '
                     </div>
                 <br/>';

            $cancellationRules = functions::getTourCancellationRules($info['tour_code']);
            $printBoxCheck .= '
            
                    <h2 style="font-size: 14px;display: block;text-align: right;margin: 10px 40px 0px 40px;font-weight:bold">
                        <span> '.functions::Xmlinformation('PleaseFollowTheRules').':  </span>
                    </h2>
                    <div style="width: 93%;margin: 5px 40px 5px 40px;">';
            $printBoxCheck .= $cancellationRules;
            /* $printBoxCheck .='
                         <p style="padding-right: 8px;">.</p>
                         <p style="padding-right: 8px;">.</p>
                         <p style="padding-right: 8px;">.</p>
                         ';*/
            $printBoxCheck .= '
                    </div>
                    <div class="clear-both"></div>
                    <hr/>
            
                    <div style="width:100%; text-align : center ; ">
                        <div style="width: 45%; float:right ;margin: 0px 30px;text-align:right">
                            '.functions::Xmlinformation('Website').' : <div style="direction: ltr; display: inline-block;text-align:right">';
            $printBoxCheck .= CLIENT_MAIN_DOMAIN;
            $printBoxCheck .= '</div>
                    </div>
                    <div style="width: 45%; float:right ; margin: 0px 30px;text-align:right">
                        '.functions::Xmlinformation('Telephone').' : <div style="direction: ltr; display: inline-block;text-align:right">';
            $printBoxCheck .= CLIENT_PHONE;
            $printBoxCheck .= '</div>
                    </div>
                    <div style="width: 80%; float:right; margin: 0px 20px ;text-align:right;direction: rtl"> '.functions::Xmlinformation('Address').' : ';
            $printBoxCheck .= CLIENT_ADDRESS;
            $printBoxCheck .= '</div>
        
                    </div>
            
                    <div class="clear-both"></div>
            
                    </div>';


        } else {
            $printBoxCheck = '<div style="text-align:center ; fon-size:20px ;font-family: Yekan;">'.functions::Xmlinformation('DetailNotFound').'</div>';
        }

        $printBoxCheck .= ' </div>
                                </body>
                </html> ';


        return $printBoxCheck;
    }

    public function getReportTourAgency($agencyId)
    {
	    /** @var bookTourLocalModel $bookTourLocalModel */
	    $bookTourLocalModel = Load::getModel( 'bookTourLocalModel' );
        return $bookTourLocalModel->getReportTourAgency($agencyId);
    }

}