<?php

class invoice extends clientAuth {

    public $model;
    public $temporary_model;

    public $price;


    public function __construct() {
        parent::__construct();

        $this->model = $this->getModel('invoiceModel');
        $this->temporary_model = $this->getModel('temporaryInvoiceModel');
    }

    public function setInvoice($params) {

        $hotel_invoice_model = $this->getModel('hotelInvoiceModel') ;

        if(!$params['factor_number_list']) {
            return functions::withError([],400 ,  'هیچ خریدی برای ثبت فاکتورانتخاب نشده است.');
        }

        $book_hotel = $this->getController('BookingHotelLocal');
        $reservation_hotel = $this->getController('reservationHotel');
        $public_function = $this->getController('reservationPublicFunctions');

        $book_hotel_list = $book_hotel->getBookHotelByFactorNumber($params['factor_number_list']) ;

        $hotel = $reservation_hotel->getHotelById(['id'=>$book_hotel_list[0]['hotel_id']]);

        $agency = $public_function->getAgency($hotel['user_id']) ;
        $amount = 0 ;
        foreach ( $book_hotel_list as $book ) {
            $amount += $book['total_price'];
        }
       
        do {

            $code = $this->generateRandomCode();
            $code_params = [
                'type'          => 'tracking_code',
                'code'          => $code
            ];

        } while ($this->isCodeUnique($code_params)); // Repeat until a unique code is found

        $dataInsert = [
            'user_id'           =>  Session::getUserId() ,
            'agency_id'         => $agency['agency_id'] ,
            'tracking_code'     => $code,
            'from_company'      => $params['from_company'],
            'to_company'        => $params['to_company'],
            'origin_account'    => $params['origin_account'],
            'destination_account' => $params['destination_account'],
            'account_holder'    => $params['account_holder'],
            'amount'            => $amount,
            'hotel_id'          => $book_hotel_list[0]['hotel_id'],
            'description'       => $params['description'],
            'status'            => 'waiting',
        ];


        $insert = $this->model->insertWithBind($dataInsert);

        if ($insert) {

            foreach ($book_hotel_list as $book) {
                $hotel_params = [
                    'invoice_id'        => $insert,
                    'book_id'          => $book['factor_number']
                ];

                $hotel_invoice_model->insert($hotel_params);
            }

            return functions::withSuccess($dataInsert , 200 , 'اطلاعات با موفقیت در سیستم به ثبت رسید');
        }

        return functions::withError([],400 ,  'خطا در ثبت اطلاعات در سیستم.');
    }

    public function createInvoiceWithPreview($params) {

        $hotel_invoice_model = $this->getModel('hotelInvoiceModel') ;
        $temporary_invoice_model = $this->getModel('temporaryInvoiceModel');
        $temporary_hotel_invoice_model = $this->getModel('temporaryHotelInvoiceModel');

        if(!$params['preview_factor_number']) {
            return functions::withError([],400 ,  'هیچ خریدی برای ثبت فاکتورانتخاب نشده است.');
        }

        $temporary_invoice = $temporary_invoice_model->get()->where('tracking_code' , $params['preview_factor_number'])->find();

        $temporary_hotel_invoice = $temporary_hotel_invoice_model->get()->where('invoice_id' , $temporary_invoice['id'])->all();

        $dataInsert = [
            'user_id'           => $temporary_invoice['user_id'] ,
            'agency_id'         => $temporary_invoice['agency_id'] ,
            'tracking_code'     => $temporary_invoice['tracking_code'],
            'amount'            => $temporary_invoice['amount'],
            'hotel_id'          => $temporary_invoice['hotel_id'],
            'status'            => 'waiting',
        ];

        $insert = $this->model->insertWithBind($dataInsert);

        if ($insert) {

            foreach ($temporary_hotel_invoice as $book) {
                $hotel_params = [
                    'invoice_id'       => $insert,
                    'book_id'          => $book['book_id']
                ];

                $hotel_invoice_model->insert($hotel_params);
            }

            return functions::withSuccess($dataInsert , 200 , 'اطلاعات با موفقیت در سیستم به ثبت رسید');
        }

        return functions::withError([],400 ,  'خطا در ثبت اطلاعات در سیستم.');
    }

    public function setTemporaryInvoice($params) {

        $temporary_hotel_invoice_model = $this->getModel('temporaryHotelInvoiceModel') ;

        if(!$params['factor_number_list']) {
            return functions::withError([],400 ,  'هیچ خریدی برای ثبت فاکتورانتخاب نشده است.');
        }

        $book_hotel = $this->getController('BookingHotelLocal');
        $reservation_hotel = $this->getController('reservationHotel');
        $public_function = $this->getController('reservationPublicFunctions');

        $book_hotel_list = $book_hotel->getBookHotelByFactorNumber($params['factor_number_list']) ;

        $hotel = $reservation_hotel->getHotelById(['id'=>$book_hotel_list[0]['hotel_id']]);

        $agency = $public_function->getAgency($hotel['user_id']) ;
        $amount = 0 ;
        foreach ( $book_hotel_list as $book ) {
            $amount += $book['total_price'];
        }

        do {

            $code = $this->generateRandomCode();
            $code_params = [
                'type'          => 'tracking_code',
                'code'          => $code
            ];

        } while ($this->isCodeUnique($code_params)); // Repeat until a unique code is found

        $dataInsert = [
            'user_id'           =>  Session::getUserId() ,
            'agency_id'         => $agency['agency_id'] ,
            'tracking_code'     => $code,
            'amount'            => $amount,
            'hotel_id'          => $book_hotel_list[0]['hotel_id'],
        ];


        $insert = $this->temporary_model->insertWithBind($dataInsert);

        if ($insert) {

            foreach ($book_hotel_list as $book) {
                $hotel_params = [
                    'invoice_id'        => $insert,
                    'book_id'          => $book['factor_number']
                ];

                $temporary_hotel_invoice_model->insert($hotel_params);
            }

            return functions::withSuccess($dataInsert , 200 , 'اطلاعات با موفقیت در سیستم به ثبت رسید');
        }

        return functions::withError([],400 ,  'خطا در ثبت اطلاعات در سیستم.');
    }
    public function updateInvoiceStatus($params) {

        do {
            $code = $this->generateRandom4DigitCode();
            $code_params = [
                'type'          => 'factor_number',
                'code'          => $code ,

            ];
        } while ($this->isCodeUnique($code_params)); // Repeat until a unique code is found
        $data_update = [
            'from_company'      => $params['from_company'],
            'to_company'        => $params['to_company'],
            'origin_account'    => $params['origin_account'],
            'destination_account' => $params['destination_account'],
            'account_holder'    => $params['account_holder'],
            'description'       => $params['description'],
            'status' => 'payed'  ,
            'factor_number' => $code ,
            'payment_date'  => Date('Y-m-d H:i:s')
        ];

        $result = $this->model->updateWithBind($data_update , ['tracking_code'=>$params['tracking_code']]);
        if ($result) {
            return functions::JsonSuccess($result, 'با موفقیت ویرایش شد');
        }

        return functions::JsonError($result, 'خطا در ویرایش ', 200);
    }
    public function listBookHotelInvoice()
    {

        $book_hotel_model = $this->getModel('bookHotelLocalModel');
        $hotel_invoice_model = $this->getModel('hotelInvoiceModel');
        $book_controller = $this->getController('bookhotelshow');
      
        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);

        $book_list = $book_hotel_model->get(['*'])
            ->where('status' , 'BookedSuccessfully');

        if(!empty($intendedUser['agency_id'])){
            $book_list = $book_list->where('agency_id' , $intendedUser['agency_id']);
        }
        if(!empty($_POST['member_id'])){
            $book_list = $book_list->where('member_id' , $_POST['member_id']);
        }
        if(!empty($_POST['hotel_id'])){
            $book_list = $book_list->where('hotel_id' , $_POST['hotel_id']);
        }

        if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {

            $date_of = explode('-', $_POST['date_of']);
            $date_to = explode('-', $_POST['to_date']);
            $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
            $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            $book_list = $book_list->where('creation_date_int' , $date_of_int , '>=')
            ->where('creation_date_int' , $date_to_int , '<=');

        }else {
            $book_list = $book_list->where('creation_date_int' , $date_now_int_start , '>=')
                ->where('creation_date_int' , $date_now_int_end , '<=');
        }


        if (!empty($_POST['StartDate'])) {
            $book_list = $book_list->where('Start_date' , $_POST['StartDate']);

        }

        if (!empty($_POST['EndDate'])) {
            $book_list = $book_list->where('end_date' , $_POST['EndDate']);

        }

        $book_list = $book_list->groupBy('factor_number')->all();

        $dataRows = [];
        $this->totalPrice = 0;

        $this->price = 0;
        $this->priceForMa = 0;
        $type_application = 'هتل رزرواسیون';
        $status = 'رزرو قطعی';
        foreach ($book_list as $k => $book) {
            $has_invoice = $hotel_invoice_model->get('*')->where('book_id' , $book['factor_number'])->find();
            $numberColumn = $k + 2;

            $expPaymentDate = [];
            if (!empty($book['payment_date'])){

                $paymentDate = functions::set_date_payment($book['payment_date']);

                $expPaymentDate = explode(" ", $paymentDate);

            }

            if (!empty($book['member_name'])){
                $memberName = $book['member_name'];
            } else {
                $memberName = $book['passenger_leader_room_fullName'];
            }



            $this->totalPrice = 0;
            $room = $book_controller->InformationOfEachReservation($book['factor_number']);

            $this->totalPrice += $room['totalPrice'];
            $this->price += $room['price'];

            if($book['type_application'] == 'externalApi' || ($book['type_application'] == 'api' && substr($book['hotel_id'], 0,2) == '17')){
                $this->totalPrice = $room['totalPrice'];
                $this->price = $room['price'];
            }
            $this->priceForMa += $room['priceForMa'];
            $agencyCommission = '';
            if ($book['agency_commission_price_type'] == 'cost') {
                $agencyCommission =  number_format($room['agencyCommission'] * $room['nights']);
            }
            if ($book['agency_commission_price_type'] == 'percent'){
//                $agencyCommission = $room['agencyCommission'] . ' % ';
                $agencyCommission = number_format( $room['onlinePrice'] * $room['agencyCommission'] / 100);

                $agencyCommission .= ' - <small class="badge badge-xs badge-inverse"> '.$room['agencyCommission'].'% </small>';
            }

//            $agencyCommission .= '<code style="display:none">'.json_encode(array('book'=>$book,'room'=>$room),256|64).'</code>';


            $dataRows[$k]['number_column'] = $numberColumn - 1;
            $dataRows[$k]['hotel_id'] = $book['hotel_id'];
            $dataRows[$k]['request_from'] = $book['request_from'];
            $dataRows[$k]['factor_number'] = $book['factor_number'] . ' ';
            $dataRows[$k]['request_number'] = $book['request_number'];

            $dataRows[$k]['member_name'] = $memberName;
            $dataRows[$k]['member_mobile'] = $book['member_mobile'];
            $dataRows[$k]['payment_date'] = $expPaymentDate[0];
            $dataRows[$k]['payment_time'] = $expPaymentDate[1];
            $dataRows[$k]['city_name'] = $book['city_name'];
            $dataRows[$k]['hotel_name'] = $book['hotel_name'];
            $dataRows[$k]['start_date'] = $book['start_date'];
            $dataRows[$k]['end_date'] = $book['end_date'];
            $dataRows[$k]['number_night'] = $book['number_night'];
            $dataRows[$k]['room_count'] = $room['roomCount'];
            $dataRows[$k]['room_excel'] = str_replace("&nbsp;", "", $room['room']);
            $dataRows[$k]['total_price_api'] =$book['total_price_api'];
            $dataRows[$k]['total_price'] = $this->totalPrice;

            $dataRows[$k]['agency_commission'] = 0;
            $dataRows[$k]['price'] = 0;
            $dataRows[$k]['onlinePrice'] = 0;
            if ($book['type_application'] == 'api' || $book['type_application'] == 'api_app' || $book['type_application'] == 'externalApi'){
                $dataRows[$k]['agency_commission'] = $agencyCommission;
                $dataRows[$k]['price'] = $room['price'];
                $dataRows[$k]['onlinePrice'] = $room['onlinePrice'];
            }

            $dataRows[$k]['type_application_fa'] = $type_application;
            $dataRows[$k]['manual_book'] = $book['manual_book'];
            $dataRows[$k]['status_fa'] = $status;
            $dataRows[$k]['status'] = $book['status'];
            $dataRows[$k]['has_invoice'] = $has_invoice;

        }


        return $dataRows;

    }

    public function getHotelInvoiceData($params) {
        $user_controller = $this->getController('members') ;
        $invoice_data = $this->model->get(['*' , 'count(reservation_hotel_tb.id) as book_count'])
            ->join('reservation_hotel_tb' , 'id' , 'hotel_id')
            ->join('hotel_invoice_tb' , 'invoice_id' , 'id')
            ->join('hotel_invoice_tb' , 'factor_number' , 'book_id' , 'inner' , 'book_hotel_local_tb')
            ->where('invoice_tb.hotel_id' , $params['hotel_id'])  ;
        if($params['status']) {
            $invoice_data = $invoice_data->where('invoice_tb.status' , $params['status'])  ;
        }
        if($params['tracing_code']) {
            $invoice_data = $invoice_data->where('invoice_tb.tracking_code' , $params['tracing_code'])  ;
        }
        $invoice_data = $invoice_data->groupBy('invoice_tb.id')
            ->all();
        $result = [];
        foreach ($invoice_data as $key => $invoice) {
            $result[$key]['id']             = $invoice['id'] ;
            $result[$key]['user']           = $user_controller->findUser($invoice['user_id'])['user_name'] ;
            $result[$key]['factor_number']  = $invoice['factor_number'] ;
            $result[$key]['tracking_code']  = $invoice['tracking_code'] ;
            $time_date = functions::ConvertToDateJalaliInt($invoice['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("Y/m/d", $time_date);;
            $result[$key]['book_count']     = $invoice['book_count'] ;
            $result[$key]['amount']         = number_format($invoice['amount']) ;
            $result[$key]['status_main']    = $invoice['status'] ;
            $result[$key]['status_color']         = $this->getInvoiceStatusColor($invoice['status']) ;
            $result[$key]['status']         = $this->getInvoiceStatus($invoice['status']) ;
        }

        return functions::toJson($result)  ;
    }

    public function getInvoiceExcelData($params) {
        $invoice_data = $this->model->get(['*' , ' reservation_hotel_tb.`name` as hotel_name' , 'book_hotel_local_tb.room_name as room_name',
	'book_hotel_local_tb.passenger_name' ,'book_hotel_local_tb.passenger_family' ,
	'book_hotel_local_tb.start_date' , 'book_hotel_local_tb.end_date' ,
	'book_hotel_local_tb.factor_number as reserve_number'  ,'book_hotel_local_tb.creation_date_int as created_date' ,
            'book_hotel_local_tb.total_price as hotel_price'])
            ->join('reservation_hotel_tb' , 'id' , 'hotel_id')
            ->join('hotel_invoice_tb' , 'invoice_id' , 'id')
            ->join('hotel_invoice_tb' , 'factor_number' , 'book_id' , 'inner' , 'book_hotel_local_tb')
            ->where('invoice_tb.tracking_code' , $params['invoice_id'])
            ->all();

        $result = [];
        $number_column = 1 ;
        foreach ($invoice_data as $key => $invoice) {
            $result[$key]['number_column']             = $number_column;
            $result[$key]['hotel_name']    = $invoice['hotel_name'] ;
            $result[$key]['created_date']     = dateTimeSetting::jdate( 'Y-m-d (H:i:s)', $invoice['created_date'] )  ;
            $result[$key]['reserve_number']    = $invoice['reserve_number'] ;
            $result[$key]['hotel_amount']    = $invoice['hotel_price'] ;
            $result[$key]['room_name']    = $invoice['room_name'] ;
            $result[$key]['passenger_name']    = $invoice['passenger_name'] . ' ' . $invoice['passenger_family'];
            $result[$key]['start_date']    = $invoice['start_date'] ;
            $result[$key]['end_date']    = $invoice['end_date'] ;
            $result[$key]['factor_number']  = $invoice['factor_number'] ;
            $time_date = functions::ConvertToDateJalaliInt($invoice['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("Y/m/d h:m:s", $time_date);
            $result[$key]['status']         = $this->getInvoiceStatus($invoice['status']) ;

            ++$number_column;
        }

        return $result ;
    }
    public function getBookDetailInvoice($params) {

        $agency_controller = $this->getController('agency') ;
        $invoice_data = $this->model->get(['*' , ' reservation_hotel_tb.`name` as hotel_name' , 'book_hotel_local_tb.room_name as room_name',
            'book_hotel_local_tb.passenger_name' ,'book_hotel_local_tb.passenger_family' ,
            'book_hotel_local_tb.start_date' , 'book_hotel_local_tb.end_date' ,
            'book_hotel_local_tb.factor_number as reserve_number'  ,
            'book_hotel_local_tb.creation_date_int as created_date' ,
            'book_hotel_local_tb.total_price as hotel_price',
            'book_hotel_local_tb.price_current',
            'book_hotel_local_tb.number_night',
            'book_hotel_local_tb.agency_id as buyer_number',
            'book_hotel_local_tb.room_bord_price as room_board_price',
            'book_hotel_local_tb.room_online_price as room_online_price',
            'book_hotel_local_tb.pnr as pnr',
            'book_hotel_local_tb.room_count as room_count'
        ])
            ->join('reservation_hotel_tb' , 'id' , 'hotel_id')
            ->join('hotel_invoice_tb' , 'invoice_id' , 'id')
            ->join('hotel_invoice_tb' , 'factor_number' , 'book_id' , 'inner' , 'book_hotel_local_tb')
            ->where('invoice_tb.tracking_code' , $params['invoice_id'])
            ->all();

        $result = [];
//        $time_date = functions::ConvertToDateJalaliInt();

        $result['factor_data'] = [
            'factor_number'     =>   $invoice_data[0]['factor_number'] ,
            'tracking_code'     =>   $invoice_data[0]['tracking_code'] ,
            'created_at'        =>   functions::convertToJalali($invoice_data[0]['created_at']),
            'hotel_name'        =>   $invoice_data[0]['hotel_name']
        ];

        $buyer = $agency_controller->getAgency($invoice_data[0]['buyer_number']);

        $result['buyer'] = [
            'name'           =>  $buyer['name_fa'] ,
            'postal_code'    =>  $buyer['postal_code'] ,
            'national_code'  =>  $buyer['agency_national_code'],
            'staff_number'   =>  $buyer['staff_number'],
            'phone'          =>  $buyer['phone'],
            'address'        =>  $buyer['address_fa'],
        ];
        $agency = $agency_controller->getAgency($invoice_data[0]['agency_id']);
        $result['agency'] = [
            'name'           =>   $agency['name_fa'] ,
            'postal_code'    =>   $agency['postal_code'] ,
            'national_code'  =>  $agency['agency_national_code'],
            'staff_number'   =>   $agency['staff_number'],
            'phone'          =>   $agency['phone'],
            'address'        =>   $agency['address_fa'],
        ];


        $number_column = 1 ;
        $total_price =  0 ;
        $hotel_price =  0 ;
        $total_discount =  0 ;

        foreach ($invoice_data as $key => $invoice) {
            $discount  = $invoice['room_board_price'] - $invoice['room_online_price'] ;
            $result['book_list'][$key]['number_column']             = $number_column;
            $result['book_list'][$key]['created_date']     = dateTimeSetting::jdate( 'Y-m-d (H:i:s)', $invoice['created_date'] )  ;
            $result['book_list'][$key]['reserve_number']    = $invoice['reserve_number'] ;
            $result['book_list'][$key]['pnr']    = $invoice['pnr'] ;
            $result['book_list'][$key]['hotel_amount']    = $invoice['hotel_price'] ;
            $result['book_list'][$key]['room_name']    = $invoice['room_name'] ;
            $result['book_list'][$key]['passenger_name']    = $invoice['passenger_name'] . ' ' . $invoice['passenger_family'];
            $result['book_list'][$key]['start_date']    = $invoice['start_date'] ;
            $result['book_list'][$key]['end_date']    = $invoice['end_date'] ;
            $result['book_list'][$key]['number_night']    = $invoice['number_night'] ;
            $result['book_list'][$key]['each_price']    = $invoice['room_board_price'] ;
            $result['book_list'][$key]['total_price']    = $invoice['room_board_price'] *  $invoice['room_count'];
            $result['book_list'][$key]['hotel_price']    = $invoice['hotel_price'] ;
            $result['book_list'][$key]['discount']       =  $discount ;
            $total_price += ($invoice['room_board_price'] *  $invoice['room_count']) ;
            $hotel_price += $invoice['hotel_price'] ;
            $total_discount += $discount ;
            ++$number_column;
        }

        $result['price']         = [
            'total_price'     => $total_price ,
            'hotel_price'     => $hotel_price ,
            'total_discount'     => $total_discount ,
        ]   ;

        return $result ;
    }
    public function getInvoiceStatus($status) {
        switch ($status) {
            case 'payed':
                return 'پرداخت شده';
            case 'waiting':
                return 'در حال بررسی';
        }
    }
    public function getInvoiceStatusColor($status) {
        switch ($status) {
            case 'payed':
                return 'green';
            case 'waiting':
                return 'red';
        }
    }
    public function createPdfContent($factorNumber , $detail = false)
    {

        $printBoxCheck = '';
        if(!$detail)  {

            $printBoxCheck .= ' <!DOCTYPE html>
                <html dir="rtl" lang="fa">
                    <head>
                    <style>
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        th, td {
                            border: 1px solid black;
                            padding: 8px;
                            text-align: left;
                        }
                           .one-eighth {
                                width: 12.5%;
                                background-color: #b3b3b3; /* Light grey background */
                                text-align : right
                            }
                            .three-eighths {
                                width: 37.5%;
                                text-align : right
                            }
                            .one-ninth {
                                width: 11.11%;
                              text-align : right
                            }
                            .other {
                                width: auto; /* This will take the remaining space */
                                 text-align : center;
                            }
                               .flex-cell {
                                    display: flex;
                                    justify-content: space-between; 
                                    align-items: center;
                                }
                                .flex-item {
                                    width: 48%; /* Allow some margin for spacing */
                                }
                    </style>
                        <meta charset="UTF-8">
                        <title>'.functions::Xmlinformation('ViewHotelPDF').'</title>
                    </head>
                    
                    <body>';


            $Model = Load::library('Model');
            $tableName = 'invoice_tb';


            $sql = "SELECT * FROM $tableName  WHERE factor_number='{$factorNumber}' ";

            $info_hotel = $Model->load($sql);

            if (!empty($info_hotel)) {
                $printBoxCheck .= '<div style="margin:30px auto 0;background-color: #fff;line-height: 24px;">
        
                                <div style="margin:30px auto 0;background-color: #fff;">
                
                    <div style="margin: 10px auto 0;">
                        <div>
                            ';
                $printBoxCheck .= '
                  <div >
                      <div style="display:none">saaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaassaasas</div>
                      <table style="border: 3px solid #2E3231;margin: 5px 40px 5px 40px; ">  
                    
                      <tr >
                        <td class="other" rowspan="2"  colspan="2" style="font-size:15px; font-weight:bold">رسید پرداخت هتلاتو</td>
                        <td class="one-ninth" style="background-color: #f0f0f0 ; border-right: none;">
                        پیرو شماره فاکتور
                   </td>
           <td class="one-ninth" >
                       
                    ';

                $printBoxCheck .= $info_hotel['factor_number'];
                $printBoxCheck .= '          </td>
                      </tr>
                      <tr> 
                      
                        <td class="one-ninth flex-cell" style="background-color: #f0f0f0 ; border-left: none;"> ﺗﺎرﯾﺦ وارﯾﺰ';
                $printBoxCheck .= '            </td>
             <td class="one-ninth" >
                      
                    ';

                $time_date = functions::ConvertToJalali($info_hotel['payment_date']);

                $printBoxCheck .=  $time_date;
                $printBoxCheck .= '          </td>
                      </tr>
                      <tr>
                        <td class="one-eighth">وارﯾﺰ از</td>
                        <td class="three-eighths" >';
                $printBoxCheck .= $info_hotel['from_company'];
                $printBoxCheck .='</td>
                        <td class="one-eighth">ﺣﺴﺎب ﻣﺒﺪا</td>
                        <td class="three-eighths">';
                $printBoxCheck .= $info_hotel['origin_account'];
                $printBoxCheck .='</td>

                      </tr>
                      
                      <tr>
                        <td class="one-eighth"  >وارﯾﺰ ﺑﻪ</td>
                        <td class="three-eighths" >';
                $printBoxCheck .= $info_hotel['to_company'];
                $printBoxCheck .='</td>
                        <td class="one-eighth" >ﺣﺴﺎب ﻣﻘﺼﺪ</td>
                        <td class="three-eighths">';
                $printBoxCheck .= $info_hotel['destination_account'];
                $printBoxCheck .='</td>
                      </tr>
                      <tr>
                        <td class="one-eighth">نام صاحب حساب</td>
                        <td colspan="3" style="text-align:right">';
                $printBoxCheck .= $info_hotel['account_holder'];
                $printBoxCheck .='</td>
               
                      </tr>
                 
                    
                    </table>
                        <table style="border: 3px solid #2E3231;margin: 5px 40px 5px 40px;">
                           <tr>
                        <td class="one-eighth">مبلغ فاکتور (ریال)</td>
                        <td class="three-eighths">';
                $printBoxCheck .= number_format($info_hotel['amount']);
                $printBoxCheck .='</td>
                        <td class="one-eighth">شماره پیگیری</td>
                        <td class="three-eighths">';
                $printBoxCheck .= $info_hotel['tracking_code'];
                $printBoxCheck .='</td>
                      </tr>
                      <tr>
                        <td class="one-eighth">توضیحات</td>
                        <td colspan="3">';
                $printBoxCheck .= $info_hotel['description'];
                $printBoxCheck .='</td>
               
                      </tr>
                        
                        </table>
                        </div>
                  
                    ';
                $printBoxCheck .= '</div></div></div></div>
                            ';

            } else {
                $printBoxCheck = '<div style="text-align:center ; fon-size:20px ;font-family: Yekan;">'.functions::Xmlinformation('DetailNotFound').'</div>';
            }

            $printBoxCheck .= ' 
                                </body>
                </html> ';
        }
        else{

            $printBoxCheck .= ' <!DOCTYPE html>
                <html dir="rtl" lang="fa">
                    <head>
                    <style>
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        th, td {
                            border: 1px solid black;
                            padding: 8px;
                          
                        }
                       .div {
                    
                        float: left;
                       
                    }
                     .div1 , .div3 {
                        width: 40%; /* Adjust width as necessary */
                        float: left;
                        margin : 0 0 0 30px ;
                        text-align : left;
                    }
                     .div2 {
                        width: 53%; /* Adjust width as necessary */
                         text-align : left;
                    }
                    .div3 {
                        width: 37%; /* Adjust width as necessary */
                         text-align : left;
                    }
                    .div4 {
                        width: 59%; /* Adjust width as necessary */
                         text-align : left;
                    }
                    .clearfix {
                        clear: both;
                    }
                    .div7, .div8, .div9 {
                        width: 28%; /* Adjust width as necessary to ensure all fit in one line */
                        float: left;
                        padding: 10px;
                        margin-right: 2%; /* Space between divs */
                      text-align : right;
                    }
                    .div9 {
                        margin-right: 0; /* No margin on the last div */
                    }
                     .div10, .div20 {
            
            float: left;
            padding: 10px;
            border: 1px solid #000;
            box-sizing: border-box;
        }
        .div20{
            width: 10%; /* Adjust width as necessary */
        }
        .div10{
            width: 82%; /* Adjust width as necessary */
        }
        .clearfix {
            clear: both;
        }
         .content {
            display: inline-block;
            width: 30%; /* Adjust width to distribute space */
            text-align: center; /* Center text inside each block */
        }
      .nested-table td {
            width: 33.33%; /* Ensures equal width for each data element */
            border: none; /* Remove inner borders if desired */
            padding: 10px; /* Remove padding for cleaner layout */
            text-align: right !important; /* Center align text inside nested cells */
        }
                    </style>
                        <meta charset="UTF-8">
                        <title>'.functions::Xmlinformation('ViewHotelPDF').'</title>
                    </head>
                    
                    <body>';


            $result_book = $this->getBookDetailInvoice(['invoice_id' => $factorNumber]);

            if (count($result_book['book_list']) > 0 ) {
                $printBoxCheck .= '<div style="background-color: #fff;line-height: 24px;">
        
                                <div style="background-color: #fff;">
                
                    <div >
                        <div>
                            ';
                $printBoxCheck .= '
                  <div >
                       
                         <div class="div div3">تاریخ:
                          ';

                $printBoxCheck .= $result_book['factor_data']['created_at'];
                $printBoxCheck .='</div>
                        <div class="div div4">صورت حساب فروش خدمات</div>
                        <div class="clearfix"></div> <!-- Clears the float -->
                        
                        <div class="div div1">شماره فاکتور:
                          ';
                $printBoxCheck .= $result_book['factor_data']['factor_number'];
                $printBoxCheck .='
                        </div>
                       
                        <div class="div div2">  ';
                $printBoxCheck .= $result_book['factor_data']['hotel_name'];
                $printBoxCheck .='</div>
                        <div class="clearfix"></div> <!-- Clears the float -->
                        
                        <div class="div div1">شماره پیگیری:
                         ';
                $printBoxCheck .= $result_book['factor_data']['tracking_code'];
                $printBoxCheck .='
                </div>
                        <div class="div div2"></div>
                        <div class="clearfix"></div> <!-- Clears the float -->
           
                        <table style="border: 3px solid #2E3231;margin: 20px 35px 20px 35px;">
                            <tr>
                                <td style="width:10%;  text-align: center;">
                                فروشنده    
                                </td>
                                <td  style="width:90%">
                                    <table class="nested-table"  style="width:100%">
                                        <tr style="padding : 10px">
                                            <td style="width:auto">شماره اقتصادی/شماره ملی:
                                              ';
                $printBoxCheck .= $result_book['agency']['national_code'];
                $printBoxCheck .='</td>
                                            <td style="width:auto">شناسه ملی:
                                             ';
                $printBoxCheck .= $result_book['agency']['staff_number'];
                $printBoxCheck .='
                                            </td>
                                            <td style="width:auto">نام:
                                            ';
                $printBoxCheck .= $result_book['agency']['name'];
                $printBoxCheck .='
                                            </td>
                                        </tr>   
                                        <tr style="padding : 10px">
                                            <td style="width:auto">شهر:
                                              
                                            </td>
                                            <td style="width:auto">کدپستی:
                                               ';
                $printBoxCheck .= $result_book['agency']['postal_code'];
                $printBoxCheck .='
                </td>
                                            <td style="width:auto">تلفن:
                                             ';
                $printBoxCheck .= $result_book['agency']['phone'];
                $printBoxCheck .='
                                            </td>
                                        </tr>
                                         <tr style="padding : 10px">
                                            <td colspan="3">آدرس:
                                             ';
                $printBoxCheck .= $result_book['agency']['address'];
                $printBoxCheck .='</td>
                                           
                                        
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                       
                         <table style="border: 3px solid #2E3231;margin: 20px 35px 20px 35px;">
                            <tr>
                                <td style="width:10%;  text-align: center;">
                                خریدار    
                                </td>
                                <td >
                                    <table class="nested-table">
                                       <tr>
                                            <td style="width:auto">شماره اقتصادی/شماره ملی:
                                             ';
                $printBoxCheck .= $result_book['buyer']['national_code'];
                $printBoxCheck .='</td>
                                            <td style="width:auto">شناسه ملی:
                                              ';
                $printBoxCheck .= $result_book['buyer']['staff_number'];
                $printBoxCheck .='</td>
                                            <td style="width:auto">نام:
                                              ';
                $printBoxCheck .= $result_book['buyer']['name'];
                $printBoxCheck .='</td>
                                        </tr>   
                                        <tr>
                                            <td style="width:auto">شهر:</td>
                                            <td style="width:auto">کدپستی:
                                             ';
                $printBoxCheck .= $result_book['buyer']['postal_code'];
                $printBoxCheck .='</td>
                                            <td style="width:auto">تلفن:
                                             ';
                $printBoxCheck .= $result_book['buyer']['telephone'];
                $printBoxCheck .='</td>
                                        </tr>
                                         <tr>
                                            <td colspan="3">آدرس:
                                             ';
                $printBoxCheck .= $result_book['buyer']['address'];
                $printBoxCheck .='</td>
                                           
                                        
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                     
                        
                          <table style="border: 3px solid #2E3231;margin: 20px 35px 20px 35px;">
                           <tr>
                                <th>ردﯾﻒ</th>
                                <th>شناسه رزرو هتل</th>
                                <th>نام مسافر</th>
                                <th>بابت</th>
                                <th>تاریخ ورود</th>
                                <th>تاریخ خروج</th>
                
                                <th>مدت اقامت <br> (شب)</th>
                                <th>قیمت واحد <br> (ریال)</th>
                                <th>مبلغ کل <br> (ریال)</th>
                                <th>مبلغ تخفیف <br> (ریال)</th>
                                <th>مبلغ کل پس از کسر تخفیف <br> (ریال)</th>
                            </tr>
                             ';
                foreach ($result_book['book_list'] as $key => $book) {
                    
                $printBoxCheck .='
                            <tr>
                                <td>
                                 ';
                    $printBoxCheck .= ++$key;
                    $printBoxCheck .='
                                </td>
                                <td>
                                  ';
                    $printBoxCheck .= $book['pnr'];
                    $printBoxCheck .='
                                </td>
                                <td>
                                     ';
                    $printBoxCheck .= $book['passenger_name'];
                    $printBoxCheck .='
                                </td>
                                <td>
                                  ';
                    $printBoxCheck .= $book['room_name'];
                    $printBoxCheck .='
                                </td>
                                <td>  ';
                    $printBoxCheck .= $book['start_date'];
                    $printBoxCheck .='
                                </td>
                                <td>
                                 ';
                    $printBoxCheck .= $book['end_date'];
                    $printBoxCheck .='
                    </td>
                                <td> ';
                    $printBoxCheck .= $book['number_night'];
                    $printBoxCheck .='</td>
                               
                                <td> ';
                    $printBoxCheck .= number_format($book['each_price']);
                    $printBoxCheck .=' </td>
                                <td>';
                    $printBoxCheck .= number_format($book['total_price']);
                    $printBoxCheck .='</td>
                                <td>';
                    $printBoxCheck .= number_format($book['discount']);
                    $printBoxCheck .='</td>
                                <td>';
                    $printBoxCheck .= number_format($book['hotel_price']);
                    $printBoxCheck .='</td>
                            </tr>
                               ';


                    }
                    $printBoxCheck .= CLIENT_MOBILE;
                    $printBoxCheck .='
                             <tr>
                                <td colspan="8"> مجموع</td>
                                <td>';
                $printBoxCheck .= number_format($result_book['price']['total_price']);
                $printBoxCheck .='</td>
                                <td>';
                $printBoxCheck .= number_format($result_book['price']['total_discount']);
                $printBoxCheck .=' <br> (ریال)</td>
                                <td>';
                $printBoxCheck .= number_format($result_book['price']['hotel_price']);
                $printBoxCheck .='</td>
                                
                            </tr>
                        </table>
                  
                    ';
                $printBoxCheck .= '</div></div></div></div>
                            ';

            } else {
                $printBoxCheck = '<div style="text-align:center ; fon-size:20px ;font-family: Yekan;">'.functions::Xmlinformation('DetailNotFound').'</div>';
            }

            $printBoxCheck .= ' 
                                </body>
                </html> ';
        }


        return $printBoxCheck;
    }

    public function createExcelFile($param){

        $_POST = $param;
        $resultBook = $this->getInvoiceExcelData(['invoice_id' => $param['invoice_id']]);
        if (!empty($resultBook)) {

            // برای نام گذاری سطر اول فایل اکسل //
            $firstRowColumnsHeading = [
                'ردیف',
                'هتل',
                'تاریخ ثبت رزرو',
                'شماره رزرو',
                'مبلغ',
                'بابت',
                'نام مسافر',
                'تاریخ ورود',
                'تاریخ خروج',
                'شماره فاکتور داخلی',
                'تاریخ تسویه',
                'وضعیت مالی',
            ];


            $firstRowWidth = [10, 30, 20, 20, 15, 15, 15, 15,10, 15,15, 15, 10];

            /** @var createExcelFile $objCreateExcelFile */
            $objCreateExcelFile = Load::controller('createExcelFile');
            $resultExcel        = $objCreateExcelFile->create($resultBook, $firstRowColumnsHeading , $firstRowWidth);

            if ($resultExcel['message'] == 'success'){
                $data = [
                    'excel_file' => $resultExcel['fileName']
                ];
                return functions::toJson($data);
            } else {
                return functions::withError([] ,400 , 'متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید' );
            }


        } else {
            return functions::withError([] ,400 , 'متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید' );
        }

    }

    public function isCodeUnique($params) {
        return $this->model->get(['*'])->where($params['type'] , $params['code'] )->find() ;
    }
    public function generateRandomCode() {
        $part1 = rand(1000, 9999);   // Random 4-digit number
        $part2 = rand(10000, 99999); // Random 5-digit number
        return $part1 . '-' . $part2; // Combine with hyphen
    }
    public function generateRandom4DigitCode() {
        return rand(1000, 9999);
    }

    public function getAllInvoiceData() {

        if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {

          $start_date =functions::convertToMiladi($_POST['date_of']);
          $end_date = functions::convertToMiladi($_POST['to_date']);
        }else{
            $date1 = dateTimeSetting::jdate("Y-m-d", strtotime('-7 day') , '' , '' , 'en');
            $date2 = dateTimeSetting::jdate("Y-m-d", strtotime('+1 day'), '' , '' , 'en');

            $start_date = functions::convertToMiladi($date1);
            $end_date = functions::convertToMiladi($date2);

        }

        $user_controller = $this->getController('members') ;
        $invoice_data = $this->model->get(['*' , 'count(reservation_hotel_tb.id) as book_count' ,
            'members_tb.user_name as userName'  ,'CONCAT(members_tb.name, " " ,members_tb.family ) as full_name'
            , 'reservation_hotel_tb.name as hotel_name'])
            ->join('reservation_hotel_tb' , 'id' , 'hotel_id')
            ->join('hotel_invoice_tb' , 'invoice_id' , 'id')
            ->join('hotel_invoice_tb' , 'factor_number' , 'book_id' , 'inner' , 'book_hotel_local_tb')
            ->join('reservation_hotel_tb' , 'id' , 'user_id' , 'inner' , 'members_tb')
            ->where('created_at' , $start_date ,  '>=')
            ->where('created_at' , $end_date, '<=');
            if($_POST['tracking_code']) {
                $invoice_data = $invoice_data->where('tracking_code' , $_POST['tracking_code']) ;
            }
            if($_POST['status']) {
                $invoice_data = $invoice_data->where('invoice_tb.status' , $_POST['status']) ;
            }
        $invoice_data = $invoice_data->groupBy('invoice_tb.id')
            ->orderBy("invoice_tb.status = 'waiting'")
            ->all();

        $result = [];
        foreach ($invoice_data as $key => $invoice) {
            $result[$key]['id']             = $invoice['id'] ;
            $result[$key]['user']           = $user_controller->findUser($invoice['user_id'])['user_name'] ;
            $result[$key]['factor_number']  = $invoice['factor_number'] ;
            $result[$key]['tracking_code']  = $invoice['tracking_code'] ;
            $time_date = functions::ConvertToDateJalaliInt($invoice['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("Y/m/d h:m:s", $time_date);
            $result[$key]['payment_date'] = '';
            if($invoice['payment_date']) {
                $time_date = functions::ConvertToDateJalaliInt($invoice['payment_date']);
                $result[$key]['payment_date'] = dateTimeSetting::jdate("Y/m/d h:m:s", $time_date);
            }

            $result[$key]['book_count']     = $invoice['book_count'] ;
            $result[$key]['amount']         = $invoice['amount'] ;
            $result[$key]['hotel_name']         = $invoice['hotel_name'] ;
            $result[$key]['full_name']         = $invoice['full_name'] ;
            $result[$key]['from_company']         = $invoice['from_company'] ;
            $result[$key]['to_company']         = $invoice['to_company'] ;
            $result[$key]['origin_account']         = $invoice['origin_account'] ;
            $result[$key]['destination_account']         = $invoice['destination_account'] ;
            $result[$key]['account_holder']         = $invoice['account_holder'] ;
            $result[$key]['status']         = $invoice['status'] ;
        }

        return $result ;
    }

    public function getBookInvoice($book_id) {
        return $this->model->get('*')->join('hotel_invoice_tb' , 'invoice_id' , 'id')
            ->where('hotel_invoice_tb.book_id'  , $book_id)->find() ;

    }
}