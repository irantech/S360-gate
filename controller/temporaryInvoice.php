<?php

class temporaryInvoice extends clientAuth {

    public $temporary_model;

    public $price;
    
    public function __construct() {
        parent::__construct();
        $this->temporary_model = $this->getModel('temporaryInvoiceModel');
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
            $dataInsert['pdf_url'] = ROOT_ADDRESS . '/pdf&target=temporaryInvoice&id='.$code.'&cash=true' ;
            return functions::withSuccess($dataInsert , 200 , 'اطلاعات با موفقیت در سیستم به ثبت رسید');
        }

        return functions::withError([],400 ,  'خطا در ثبت اطلاعات در سیستم.');
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
            $tableName = 'temporary_invoice_tb';


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

    public function isCodeUnique($params) {
        return $this->temporary_model->get(['*'])->where($params['type'] , $params['code'] )->find() ;
    }
    public function generateRandomCode() {
        $part1 = rand(1000, 9999);   // Random 4-digit number
        $part2 = rand(10000, 99999); // Random 5-digit number
        return $part1 . '-' . $part2; // Combine with hyphen
    }
    public function generateRandom4DigitCode() {
        return rand(1000, 9999);
    }
    public function getBookDetailInvoice($params) {
        $agency_controller = $this->getController('agency') ;
        $invoice_data = $this->temporary_model->get(['*' ,
            'reservation_hotel_tb.`name` as hotel_name' ,
            'book_hotel_local_tb.room_name as room_name',
            'book_hotel_local_tb.passenger_name' ,'book_hotel_local_tb.passenger_family' ,
            'book_hotel_local_tb.start_date' , 'book_hotel_local_tb.end_date' ,
            'book_hotel_local_tb.factor_number as reserve_number'  ,
            'book_hotel_local_tb.creation_date_int as created_date' ,
            'book_hotel_local_tb.total_price as hotel_price',
            'book_hotel_local_tb.price_current',
            'book_hotel_local_tb.number_night',
            'book_hotel_local_tb.agency_id as buyer_number' ,
            'book_hotel_local_tb.room_bord_price as room_board_price',
            'book_hotel_local_tb.room_online_price as room_online_price',
            'book_hotel_local_tb.pnr as pnr',
            'book_hotel_local_tb.room_count as room_count'
        ])
            ->join('reservation_hotel_tb' , 'id' , 'hotel_id')
            ->join('temporary_hotel_invoice_tb' , 'invoice_id' , 'id')
            ->join('temporary_hotel_invoice_tb' , 'factor_number' , 'book_id' , 'inner' , 'book_hotel_local_tb')
            ->where('temporary_invoice_tb.tracking_code' , $params['invoice_id'])
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
            $result['book_list'][$key]['hotel_amount']    = $invoice['hotel_price'] ;
            $result['book_list'][$key]['room_name']    = $invoice['room_name'] ;
            $result['book_list'][$key]['passenger_name']    = $invoice['passenger_name'] . ' ' . $invoice['passenger_family'];
            $result['book_list'][$key]['start_date']    = $invoice['start_date'] ;
            $result['book_list'][$key]['end_date']    = $invoice['end_date'] ;
            $result['book_list'][$key]['number_night']    = $invoice['number_night'] ;
            $result['book_list'][$key]['price_current']    = $invoice['price_current'] ;
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
}