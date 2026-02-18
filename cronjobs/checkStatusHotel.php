<?php


class checkStatusHotel extends clientAuth
{

    private $address_api;

    public function __construct() {

        parent::__construct();

       $this->address_api = 'http://safar360.com/Core/V-1/Hotel/getFinalStatusHotel/';
       // $this->address_api = 'http://safar360.com/CoreTestDeveloper/V-1/Hotel/getFinalStatusHotel/';
        $this->updateStatusHotel();
    }


    public function updateStatusHotel() {


       $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);

        $list_pending_hotels = $this->getModel('reportHotelModel')->get()->where('creation_date_int',$date_now_int_start,'>=')->where('creation_date_int',$date_now_int_end,'<=')->where('status', 'OnRequest')
            ->groupBy('request_number')->all();


        functions::insertLog('after fetch   data ===>'.json_encode($list_pending_hotels,256),'checkStatusHotel');


        foreach ($list_pending_hotels as $hotel) {

            if($hotel['source_id'] =='17'){
                functions::insertLog('after condiotion 17 ===>'.json_encode($hotel,256),'checkStatusHotel');
                $searchParams['request_number'] = $hotel['request_number'];

                $info_status = self::getHotelFinalStatus( $searchParams ) ;

                functions::insertLog('after condiotion 17 ===>'.json_encode($info_status,256),'checkStatusHotel');

                if (!empty($info_status['Result']) && $info_status['Result']['reserve_status'] == 'Reserve') {

                    $data['status'] = 'BookedSuccessfully';
                    $data['pnr'] = $info_status['Result']['PNR'];

                    $condition = " request_number = '{$info_status['RequestNumber']}' ";

                    $this->getController('admin')->ConectDbClient('', $hotel['client_id'], "Update", $data, "book_hotel_local_tb", $condition);


                    $this->getModel('reportHotelModel')->update($data, $condition);

                    $this->sendSmsToClient($hotel);

                }elseif(!empty($info_status['Result']) && $info_status['Result']['reserve_status'] == 'OnRequest'){
                    $data['status'] = 'OnRequest';
                    $condition = " request_number = '{$hotel['request_number']}' ";
                    $this->getController('admin')->ConectDbClient('', $hotel['client_id'], "Update", $data, "book_hotel_local_tb", $condition);
                    $this->getModel('reportModel')->update($data, $condition);
                }elseif(!empty($info_status['Result']) && $info_status['Result']['reserve_status'] == 'Error'){

                    $data['status'] = 'NoReserve';
                    $condition = " request_number = '{$hotel['request_number']}' ";
                    $this->getController('admin')->ConectDbClient('', $hotel['client_id'], "Update", $data, "book_hotel_local_tb", $condition);
                    $this->getModel('reportHotelModel')->update($data, $condition);
                }
            }


        }

    }


    public function getHotelFinalStatus( $param ) {

            $url                         ='http://safar360.com/CoreTestDeveloper/V-1/Hotels/getFinalStatusHotel/';
            $dataSearch['RequestNumber'] = $param['request_number'];
            $resultStatus = functions::curlExecution( $url, json_encode( $dataSearch ), $this->header );

            return $resultStatus ;

    }

    private function sendSmsToClient($hotelReserves) {
        //sms to clien

        $smsController =$this->getcontroller('smsServices') ;
        $objSms = $smsController->initService('0',$hotelReserves['client_id']);

        if ($objSms) {
            if (!empty($hotelReserves['member_mobile'])) {
                $mobile = $hotelReserves['member_mobile'];
                $name = $hotelReserves['member_name'];
            } else {
                $mobile = $hotelReserves['passenger_leader_room'];
                $name = $hotelReserves['passenger_leader_room_fullName'];
            }

            $messageVariables = array(
                'sms_name' => $name,
                'sms_service' => 'هتل',
                'sms_factor_number' => $hotelReserves['factor_number'],
                'sms_cost' => $hotelReserves['total_price'],
                'sms_destination' => $hotelReserves['city_name'],
                'sms_hotel_name' => $hotelReserves['hotel_name'],
                'sms_hotel_in' => $hotelReserves['start_date'],
                'sms_hotel_out' => $hotelReserves['end_date'],
                'sms_hotel_night' => $hotelReserves['number_night'],
                'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=BookingHotelNew&id=" . $hotelReserves['factor_number'],
                'sms_agency' => CLIENT_NAME,
                'sms_agency_mobile' => CLIENT_MOBILE,
                'sms_agency_phone' => CLIENT_PHONE,
                'sms_agency_email' => CLIENT_EMAIL,
                'sms_agency_address' => CLIENT_ADDRESS,
            );

            $smsArray = array(
                'smsMessage' => $smsController->getUsableMessage('afterHotelReserve', $messageVariables),
                'cellNumber' => $mobile,
                'smsMessageTitle' => 'afterHotelReserve',
                'memberID' => (!empty($hotelReserves['member_id']) ? $hotelReserves['member_id'] : ''),
                'receiverName' => $messageVariables['sms_name'],
            );

            $smsController->sendSMS($smsArray);

            // to manager
            $smsArray = array(
                'smsMessage' => $smsController->getUsableMessage('afterHotelReserveToManager', $messageVariables),
                'cellNumber' => '09353834714',//CLIENT_MOBILE,
                'smsMessageTitle' => 'afterHotelReserve',
                'memberID' => (!empty($Hotel['member_id']) ? $Hotel['member_id'] : ''),
                'receiverName' => $messageVariables['sms_name'],
            );

            $smsController->sendSMS($smsArray);
        }

    }

}


new checkStatusHotel();