<?php
/**
 * Created by PhpStorm.
 * User: AbbasPC
 * Date: 3/17/2019
 * Time: 1:59 PM
 */

class RequestTicketOffline
{

    public function __construct()
    {
        
    }


    public function RequestTicketOffline($Param)
    {

        $Model = Load::library('Model');
        $InfoFlight = json_decode($Param['InfoFlight'],true);

        $data['fullName'] = $Param['fullName'];
        $data['mobile'] = $Param['mobile'];
        $data['flightNumber'] = $InfoFlight['FlightNo'];
        $data['airlineIata'] = $InfoFlight['Airline'];
        $InfoAirline = functions::InfoAirline($data['airlineIata']);
        $data['origin'] = functions::NameCity($InfoFlight['Origin']);
        $data['destination'] = functions::NameCity($InfoFlight['Destination']);
        $data['flightTime'] = $InfoFlight['DepartureTime'];
        $data['flightDate'] = $InfoFlight['DepartureDate'];
        $data['cabinType'] = $InfoFlight['CabinType'];
        $data['creationDateInt'] = time();

        $Model->SetTable('request_ticket_offline_tb');

        $res = $Model->insertLocal($data);

        if($res)
        {
            $Message['messageRequest'] = 'درخواست شما با موفقیت ارسال شد';
            $Message['messageStatus'] = 'Success';


            $smsController = Load::controller('smsServices');
            $objSms = $smsController->initService('0');
            if($objSms) {
                $sms = "یک درخواست رزرو به شرح زیر ارسال شده است".PHP_EOL."نام مسافر:". $data['fullName'] . PHP_EOL."شماره تلفن مسافر:".$data['mobile'].PHP_EOL."پرواز {$data['origin']} به {$data['destination']}".PHP_EOL." هواپیمایی  {$InfoAirline['name_fa']}".PHP_EOL." به شماره پرواز {$data['flightNumber']}".PHP_EOL." و شناسه نرخی{$data['cabinType']} ".PHP_EOL."  تاریخ پرواز{$data['flightDate']}".PHP_EOL." ،ساعت پرواز {$data['flightTime']}".PHP_EOL;
                $smsArray = array(
                    'smsMessage' => $sms,
                    'cellNumber' => CLIENT_MOBILE
                );
                $smsController->sendSMS($smsArray);
            }


        }else{
            $Message['messageRequest'] = 'خطا در ثبت درخواست';
            $Message['messageStatus'] = 'Error';
        }

        return functions::clearJsonHiddenCharacters(json_encode($Message));

        
    }

}