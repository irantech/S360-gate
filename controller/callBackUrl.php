<?php

class callBackUrl extends clientAuth {

    private  $callBackUrlModel ;
    private $called_url;
    private $payload ;

    public function __construct() {
        parent::__construct();

        $this->callBackUrlModel =  $this->getModel('callBackUrlModel') ;
    }

    public function setUrlList($params) {

        $check_repeated =  $this->callBackUrlModel->get()->where('type' , $params['type'])->find();
        if($check_repeated) {
            return functions::withError(null, 400 , 'اطلاعات قبلا در سیستم ثبت شده است.');
        }

        $data = [
          'type'  => $params['type'] ,
          'url'  => $params['url'] ,
          'active'  => 1
        ];
        $insert = $this->callBackUrlModel->insertWithBind($data) ;
        if ($insert) {
            return functions::returnJsonResult(true, 'اطلاعات با موفقیت در سیستم به ثبت رسید', $insert);
        }

        return functions::withError(null, 500 , 'خطا در ثبت اطلاعات در سیستم.');
    }

    public function updateUrlList($params) {

        $data = [
            'type'  => $params['type'] ,
            'url'  => $params['url']
        ];

        $insert = $this->callBackUrlModel->updateWithBind($data , ['id' => $params['id']]) ;
        if ($insert) {
            return functions::returnJsonResult(true,'با موفقیت ویرایش شد', $insert);
        }

        return functions::withError(null, 301 , 'خطا در ویرایش اطلاعات.');
    }

    public function activeUrlList($params) {
        $call_back_url = $this->getCallBackUrl($params['id'] , true) ;
     
        if($call_back_url['active'] == 0) {
            $data = [
                'active'  => 1
            ];
        }else{
            $data = [
                'active'  => 0
            ];
        }


        $update = $this->callBackUrlModel->updateWithBind($data , ['id' => $call_back_url['id']]) ;
        if ($update) {
            return functions::returnJsonResult(true, 'با موفقیت ویرایش شد', []);
        }

        return functions::withError(null, 500 , 'خطا در ویرایش اطلاعات.');
    }

    public function getCallBackUrl($callBackUrlId , $trashed = false) {
        $result =  $this->callBackUrlModel->get()->where('id' , $callBackUrlId);
        if(!$trashed) {
            $result = $result->where('active' ,  1);
        }
        return $result->find();
    }

    public function getCallBackUrlList() {
        return $this->callBackUrlModel->get()->all();
    }

    private function setApiUrl($type) {
        $call_url = $this->callBackUrlModel->get()->where('type' , $type)->where('active' , 1)->find();
        $this->called_url = $call_url['url'] ;
    }

    public function sendRegisteredUser($data , $type) {

        $this->setApiUrl('register_user');

        $this->payload = [
            'irantech_id'      => $data['id']  ,
            'type'          => $type ,
            'name'      => $data['name']  ,
            'family'    => $data['family'] ,
            'name_en'    => $data['name_en'] ,
            'family_en'    => $data['family_en'] ,
            'national_code'    => $data['national_code'] ,
            'passport_country_code'    => $data['passport_country_code'] ,
            'mobile'    => $data['mobile'] ,
            'telephone'    => $data['telephone'] ,
            'user_name'    => $data['user_name'] ,
            'email'    => $data['email'] ,
            'gender'    => $data['gender'] ,
            'birthday'    => $data['birthday'] ,
            'birthday_en'    => $data['birthday_en'] ,
            'passport_number'    => $data['passport_number'] ,
            'address'    => $data['address'] ,
            'marriage'    => $data['marriage']
        ];
        $this->sendData('register_user') ;
    }


    public function sendBookedData($data , $type) {
        $this->setApiUrl('book');
        $passengers = [] ; 
        if($type == 'flight') {
            foreach($data as $passenger) {
                $passengers[] = [
                    'passenger_gender' => $passenger['passenger_gender'],
                    'passenger_name' => $passenger['passenger_name'],
                    'passenger_name_en' => $passenger['passenger_name_en'],
                    'passenger_family' => $passenger['passenger_family'],
                    'passenger_family_en' => $passenger['passenger_family_en'],
                    'passenger_birthday' => $passenger['passenger_birthday'],
                    'passenger_birthday_en' => $passenger['passenger_birthday_en'],
                    'passenger_national_code' => $passenger['passenger_national_code'],
                    'passportCountry' => $passenger['passportCountry'],
                    'passportNumber' => $passenger['passportNumber'],
                    'passportExpire' => $passenger['passportExpire'],
                    'passenger_age' => $passenger['passenger_age'],
                    'irantech_id' => $passenger['member_id']
                ];
            }
            $this->payload = [
                'type'      => $type  ,
                'airline_iata'      => $data[0]['airline_iata']  ,
                'airline_name'    => $data[0]['airline_name'] ,
                'origin_city'    => $data[0]['origin_city'] ,
                'destination_city'    => $data[0]['desti_city'] ,
                'origin_airport_iata'    => $data[0]['origin_airport_iata'] ,
                'destination_airport_iata'    => $data[0]['desti_airport_iata'] ,
                'cabin_type'    => $data[0]['cabin_type'] ,
                'aircraft_name'    => $data[0]['aircraft_name'] ,
                'date_flight'    => $data[0]['date_flight'] ,
                'time_flight'    => $data[0]['time_flight'] ,
                'flight_type'    => $data[0]['flight_type'] ,
                'adult_price'    => $data[0]['adt_price'] ,
                'child_price'    => $data[0]['chd_price'] ,
                'infant_price'    => $data[0]['inf_price'] ,
                'total_price'    => $data[0]['flight_number'] ,
                'flight_number'    => $data[0]['flight_number'],
                'pnr'    => $data[0]['pnr'],
                'ticket_number'    => $data[0]['eticket_number'],
                'factor_number'    => $data[0]['factor_number'],
                'name_bank_port'    => $data[0]['name_bank_port'],
                'number_bank_port'    => $data[0]['number_bank_port'],
                'tracking_code_bank'    => $data[0]['tracking_code_bank'],
                'payment_date'     => $data[0]['payment_date'],
                'buyer_name'     => $data[0]['member_name'],
                'buyer_mobile'     => $data[0]['mobile_buyer'],
                'direction'     => $data[0]['direction'],
                'adult_fare'     => $data[0]['adt_fare'],
                'price_change'     => $data[0]['price_change'],
                'price_change_type'     => $data[0]['price_change_type'],
                'passenger_list'   => $passengers
            ];
        }else if($type == 'hotel'){

            $passengers = [];
            foreach($data as $passenger) {
                $passengers[] = [
                    'passenger_gender' => $passenger['passenger_gender'],
                    'passenger_name' => $passenger['passenger_name'],
                    'passenger_name_en' => $passenger['passenger_name_en'],
                    'passenger_family' => $passenger['passenger_family'],
                    'passenger_family_en' => $passenger['passenger_family_en'],
                    'passenger_birthday' => $passenger['passenger_birthday'],
                    'passenger_birthday_en' => $passenger['passenger_birthday_en'],
                    'passenger_national_code' => $passenger['passenger_national_code'],
                    'passportCountry' => $passenger['passportCountry'],
                    'passportNumber' => $passenger['passportNumber'],
                    'passportExpire' => $passenger['passportExpire'],
                    'passenger_age' => $passenger['passenger_age'],
                    'irantech_id' => $passenger['member_id']
                ];
            }

            $this->payload = [
                'type'      => $type  ,
                'city_name'      => $data[0]['city_name']  ,
                'hotel_name'    => $data[0]['hotel_name'] ,
                'hotel_name_en'    => $data[0]['hotel_name_en'] ,
                'hotel_address'    => $data[0]['hotel_address'] ,
                'hotel_address_en'    => $data[0]['hotel_address_en'] ,
                'hotel_telephone_number'    => $data[0]['hotel_telNumber'] ,
                'hotel_star_code'    => $data[0]['hotel_starCode'] ,
                'hotel_entry_hour'    => $data[0]['hotel_entry_hour'] ,
                'hotel_leave_hour'    => $data[0]['hotel_leave_hour'] ,
                'hotel_rules'    => $data[0]['hotel_rules'] ,
                'room_name'    => $data[0]['room_name'] ,
                'room_name_en'    => $data[0]['room_name_en'] ,
                'room_count'    => $data[0]['room_count'] ,
                'time_entering_room'    => $data[0]['time_entering_room'] ,
                'extra_bed_count'    => $data[0]['extra_bed_count'] ,
                'extra_bed_price'    => $data[0]['extra_bed_price'],
                'child_count'    => $data[0]['child_count'],
                'child_price'    => $data[0]['child_price'],
                'bed_type'    => $data[0]['bed_type'],
                'start_date'    => $data[0]['start_date'],
                'end_date'    => $data[0]['end_date'],
                'number_night'    => $data[0]['number_night'],
                'price_current'    => $data[0]['number_night'],
                'voucher_number'    => $data[0]['voucher_number'],
                'factor_number'    => $data[0]['factor_number'],
                'total_price_api'    => $data[0]['total_price_api'],
                'total_price'    => $data[0]['total_price'],
                'name_bank_port'    => $data[0]['name_bank_port'],
                'number_bank_port'    => $data[0]['number_bank_port'],
                'tracking_code_bank'    => $data[0]['tracking_code_bank'],
                'payment_date'      => $data[0]['payment_date'],
                'buyer_name'     => $data[0]['member_name'],
                'buyer_mobile'     => $data[0]['mobile_buyer'],
                'price_change'     => $data[0]['price_change'],
                'price_change_type'     => $data[0]['price_change_type'],
                'passenger_list'   => $passengers
            ];
        }else if($type == 'bus'){
            if(is_array($data)) {
                $passengers = [];
                foreach($data as $passenger) {
                    $passengers[] = [
                        'passenger_gender' => $passenger['passenger_gender'],
                        'passenger_name' => $passenger['passenger_name'],
                        'passenger_name_en' => $passenger['passenger_name_en'],
                        'passenger_family' => $passenger['passenger_family'],
                        'passenger_family_en' => $passenger['passenger_family_en'],
                        'passenger_birthday' => $passenger['passenger_birthday'],
                        'passenger_birthday_en' => $passenger['passenger_birthday_en'],
                        'passenger_national_code' => $passenger['passenger_national_code'],
                        'passportCountry' => $passenger['passportCountry'],
                        'passportNumber' => $passenger['passportNumber'],
                        'passportExpire' => $passenger['passportExpire'],
                        'passenger_age' => $passenger['passenger_age'],
                        'irantech_id' => $passenger['member_id']
                    ];
                }
                $this->payload = [
                    'type'      => $type  ,
                    'CompanyName'      => $data[0]['CompanyName']  ,
                    'TimeMove'    => $data[0]['TimeMove'] ,
                    'OriginName'    => $data[0]['OriginName'] ,
                    'DestinationName'    => $data[0]['DestinationName'] ,
                    'DestinationTerminal'    => $data[0]['DestinationTerminal'] ,
                    'CarType'    => $data[0]['CarType'] ,
                    'CountChairs'    => $data[0]['CountChairs'] ,
                    'CountFreeChairs'    => $data[0]['CountFreeChairs'] ,
                    'OriginTerminal'    => $data[0]['OriginTerminal'] ,
                    'total_price'    => $data[0]['total_price'] ,
                    'price_api'    => $data[0]['price_api'] ,
                    'BaseCompany'    => $data[0]['BaseCompany'] ,
                    'DateMove'    => $data[0]['DateMove'] ,
                    'pnr'    => $data[0]['pnr'] ,
                    'factor_number'    => $data[0]['passenger_factor_num'],
                    'name_bank_port'    => $data[0]['name_bank_port'],
                    'number_bank_port'    => $data[0]['number_bank_port'],
                    'tracking_code_bank'    => $data[0]['tracking_code_bank'],
                    'payment_date'    => $data[0]['payment_date'],
                    'buyer_name'     => $data[0]['member_name'],
                    'buyer_mobile'     => $data[0]['mobile_buyer'],
                    'passenger_list'   => $passengers
                ];

            }

        }else if($type == 'insurance'){
            if(is_array($data)) {
                $passengers = [];
                foreach($data as $passenger) {
                    $passengers[] = [
                        'passenger_gender' => $passenger['passenger_gender'],
                        'passenger_name' => $passenger['passenger_name'],
                        'passenger_name_en' => $passenger['passenger_name_en'],
                        'passenger_family' => $passenger['passenger_family'],
                        'passenger_family_en' => $passenger['passenger_family_en'],
                        'passenger_birthday' => $passenger['passenger_birthday'],
                        'passenger_birthday_en' => $passenger['passenger_birthday_en'],
                        'passenger_national_code' => $passenger['passenger_national_code'],
                        'passportCountry' => $passenger['passportCountry'],
                        'passportNumber' => $passenger['passportNumber'],
                        'passportExpire' => $passenger['passportExpire'],
                        'passenger_age' => $passenger['passenger_age'],
                        'pnr' => $passenger['pnr'],
                        'irantech_id' => $passenger['member_id']
                    ];
                }
                $this->payload = [
                    'type'              => $type  ,
                    'visa_type'         => $data[0]['visa_type']  ,
                    'destination'       => $data[0]['destination'] ,
                    'destination_iata'  => $data[0]['destination_iata'] ,
                    'duration'          => $data[0]['duration'] ,
                    'factor_number'     => $data[0]['passenger_factor_num'],
                    'name_bank_port'    => $data[0]['name_bank_port'],
                    'number_bank_port'  => $data[0]['number_bank_port'],
                    'tracking_code_bank'=> $data[0]['tracking_code_bank'],
                    'payment_date'      => $data[0]['payment_date'],
                    'buyer_name'        => $data[0]['member_name'],
                    'buyer_mobile'      => $data[0]['mobile_buyer'],
                    'base_price'        => $data[0]['base_price'],
                    'paid_price'        => $data[0]['paid_price'],
                    'price_change'      => $data[0]['price_change'],
                    'price_change_type'     => $data[0]['price_change_type'],
                    'passenger_list'    => $passengers
                ];
            }

        }

        $this->sendData('book') ;
    }

    private function sendData($type) {
//        $file_path = 'callBack/'.CLIENT_ID .'/'.$type ;
        if($this->called_url && $this->payload) {
            $data = json_encode($this->payload) ;
            $result = functions::curlExecution($this->called_url, $data, 'yes');
            functions::insertLog('request url: '.$this->called_url, 'callBack_' .$type);
            functions::insertLog('request data: '.$data, 'callBack_' .$type);
            functions::insertLog('response data: '.json_encode($result), 'callBack_' .$type);
        }

    }
}