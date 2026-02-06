<?php




class ApiBus extends clientAuth
{

    private $isTest=false;
    private $ClientData;

    public $transactions;
    public function __construct()
    {

        $this->transactions = $this->getModel('transactionsModel');
        require_once('requestResponse.php');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        header("Access-Control-Allow-Credentials: true");
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            // اگر مرورگر درخواست preflight فرستاد، یه پاسخ ساده بده و برو
            header("HTTP/1.1 200 OK");
            exit();
        }
        header("Content-type: application/json;");
        $return=[];
        /**
         * @return bool  --> Check 'REQUEST_METHOD' & 'CONTENT_TYPE'
         */
        if($this->checkRequestMethode()){
            /**
             * @return array[]|mixed  -> execute 'reachApiResourceUrl()' && 'executeMethode()'
             */

            $return=$this->prepareExecuteMethode();

        }else{
            $return=ProviderStatus([
                'client'=>false,
                'provider'=>false
            ], __METHOD__, 'BadRequestMethode');
        }
        /**
         * @param array $return --> $return {ProviderStatus} || $return {ResponseStatus}
         * @return array|array[]
         */


        $FinalReturn=$this->detectApiResponseAndGdsResponse($return);

        echo json_encode($FinalReturn,256);
    }

    #region [citiesOrigin]
    public function citiesOrigin()
    {
        try{

            $ModelBase=Load::library('ModelBase');
            $sql=" SELECT DISTINCTROW
                         Departure_City AS CityNamePersian,
                         Departure_City_En AS CityName,
                         Departure_City_IataCode AS IataCode
                     FROM 
                         bus_route_tb 
                     ORDER BY 
                         Departure_City ASC ";
            $dataResponse=$ModelBase->select($sql);

        }catch(Exception $e){
            $dataResponse['ErrorDetail']=[
                'Code'=>'EB-citiesOrigin-01',
                'Message'=>'System error',
                'MessagePersian'=>'خطای سیستمی'
            ];
        }


        return $dataResponse;
    }
    #endregion

    #region [citiesDestinations]
    public function citiesDestinations($dataRequest)
    {
        try{

            $ModelBase=Load::library('ModelBase');
            $sql=" SELECT DISTINCTROW 
                         Arrival_City AS CityNamePersian,
                         Arrival_City_En AS CityName,
                         Arrival_City_IataCode AS IataCode
                     FROM 
                         bus_route_tb 
                     WHERE 
                         Departure_City_IataCode = '{$dataRequest['OriginIataCode']}'
                     ORDER BY
                         priorityArrival = 0, 
                         priorityArrival ";
            $dataResponse=$ModelBase->select($sql);

        }catch(Exception $e){
            $dataResponse['ErrorDetail']=[
                'Code'=>'EB-citiesDestinations-01',
                'Message'=>'System error',
                'MessagePersian'=>'خطای سیستمی'
            ];
        }

        return $dataResponse;
    }
    #endregion

    #region [busSearch]
    public function busSearch($requestUrl, $dataRequest)
    {

        try{
            $data['userName']=$dataRequest['userName'];
            $data['date']=$dataRequest['date'];
            $data['route']=$dataRequest['route'];
            $data['passengerCount']='1';

            $checkValidate=[
                $dataRequest['date']=>[
                    'message'=>"['date']",
                ],
                $dataRequest['route']=>[
                    'message'=>"['route']",
                ],
                $data['route']['originCity']=>[
                    'message'=>"['route']['originCity']",
                ],
                $data['route']['destinationCity']=>[
                    'message'=>"['route']['destinationCity']",
                ],
            ];

            foreach($checkValidate as $key=>$item){
                $responseData=$this->fieldChecker($key, $item);
                if($responseData!==true){
                    return $responseData;
                }
            }


            /**
             * @param $dataRequest --> 'DestinationsIataCode' & 'OriginIataCode'
             * @return array
             */

            if(!empty($data['route'])){

                /**
                 * @param $data --> Requested data
                 * @return false|string
                 */
                $data=$this->busSearchRequiredData($data);
                $url=$requestUrl."BusSearch";
              
                $responseData=functions::curlExecution($url, $data, 'yes');
            }else{
                $responseData=ProviderStatus([
                    'client'=>false,
                    'provider'=>false
                ], __METHOD__, 'BadArgument');
            }

        }catch(Exception $e){
            $responseData=ProviderStatus([
                'client'=>false,
                'provider'=>false
            ], __METHOD__, 'NoResult');
        }

        return $responseData;
    }

    #endregion


    public function routeCities()
    {

        $response=functions::getRoutes();
        return $responseData=ProviderStatus([
            'client'=>true,
            'provider'=>true
        ], __METHOD__, $response);
    }


    #region [busDetail]
    public function busDetail($requestUrl, $dataRequest)
    {


        $checkValidate=[
            $dataRequest['requestNumber']=>[
                'message'=>"['requestNumber']"
            ],
            $dataRequest['busCode']=>[
                'message'=>"['busCode']"
            ],
            $dataRequest['sourceCode']=>[
                'message'=>"['sourceCode']"
            ]
        ];

        foreach($checkValidate as $key=>$item){
            $responseData=$this->fieldChecker($key, $item);
            if($responseData!==true){
                return $responseData;
            }
        }


        try{

            /**
             * @param $dataRequest --> 'DestinationsIataCode' & 'OriginIataCode'
             * @return array
             */
            if(!empty($dataRequest)){
                /**
                 * @param $data --> Requested data
                 * @return false|string
                 */
                $dataRequest=json_encode($dataRequest);

                /**
                 * @param $requestUrl
                 * @param $dataRequest
                 * @return mixed
                 */

                $responseData=$this->busDetailExecute($requestUrl, $dataRequest);

            }else{
                $responseData=ProviderStatus([
                    'client'=>false,
                    'provider'=>false
                ], __METHOD__, 'BadArgument');
            }
        }catch(Exception $e){
            $responseData=ProviderStatus([
                'client'=>false,
                'provider'=>false
            ], __METHOD__, 'NoResult');
        }

        return $responseData;
    }

    #endregion


    public function busPreReserve($requestUrl, $dataRequest){

        foreach ($dataRequest['passengers'] as $key=>$passenger) {
            $dataRequest['passengers'][$key]['birthDate'] = functions::ConvertToMiladi($passenger['birthDate']);
            if(!functions::checkNationalCode($passenger['nationalIdentification']))
            {
                return ProviderStatus([
                    'client'=>false,
                    'provider'=>true
                ], __METHOD__, [
                    'HttpHeader'=>'401',
                    'Persian'=>'کد ملی مسافر '.$key.' اشتباه است',
                    'English'=>'wrong national code passenger '.$key,
                ]);
            }
        }
        

        $dataRequest['clientUserTelephone']['areaCityCode']='';
        $dataRequest['clientUserTelephone']['countryAccessCode']='';
        $dataRequest['telephone']['areaCityCode']='';
        $dataRequest['telephone']['countryAccessCode']='';



        try{
            $resClient=$this->ClientData['id'];
            if(!empty($resClient)){
                $agencyID=$resClient['clientId'];

                $data=json_encode($dataRequest);


                /**
                 * @param $requestUrl
                 * @param $dataRequest
                 * @return mixed
                 */
                $responseDataBusDetail=$this->busDetailExecute($requestUrl, $data);
                



                $status_checker = isset($responseDataBusDetail['response']['successfulStatus']) ? $responseDataBusDetail['response']['successfulStatus']:$responseDataBusDetail['response']['SuccessfulStatus'];

                if(responseSuccessfulCheck($status_checker) || responseSuccessfulCheck($status_checker)){

                    /**
                     * @param $requestUrl
                     * @param $dataRequest
                     * @return array
                     */

                    $responseDataBusReserve = $this->busPreReserveExecute($requestUrl, $data);


                    $status_checker = isset($responseDataBusReserve['response']['successfulStatus']) ? $responseDataBusDetail['response']['successfulStatus']: $responseDataBusDetail['response']['SuccessfulStatus'];

                    if(responseSuccessfulCheck($status_checker) || responseSuccessfulCheck($status_checker)){
                        $admin=Load::controller('admin');

                        $factorNumber=functions::generateFactorNumber();

                        $price_api=$responseDataBusDetail['response']['data']['beforeDiscountPrice']*count($dataRequest['passengers']);
                        $price=$responseDataBusDetail['response']['data']['price']*count($dataRequest['passengers']);

                        $irantechCommission=Load::controller('irantechCommission');
                        $serviceTitle=ucwords($responseDataBusDetail['response']['data']['webServiceType']).'Bus';
                        $itCommission=$irantechCommission->getCommission($serviceTitle, '13');


                        $dataInsertBook['order_code']=$responseDataBusDetail['response']['requestNumber'];
                        $dataInsertBook['passenger_factor_num']=$factorNumber;
                        /* if($responseDataBusDetail['response']['data']['availablePaymentMethods']=='Credit'){
                             $dataInsertBook['status']='book';
                         }elseif($responseDataBusDetail['response']['data']['availablePaymentMethods']=='Online'){
                             $dataInsertBook['status']='prereserve';
                         }*/

                        $dataInsertBook['status']='prereserve';
                        $dataInsertBook['payment_date']=Date('Y-m-d H:i:s');
                        $dataInsertBook['payment_type']='credit';
                        $dataInsertBook['ServiceCode']=$responseDataBusDetail['response']['data']['busCode'];
                        $dataInsertBook['CompanyName']=$responseDataBusDetail['response']['data']['company'];
                        $dataInsertBook['TimeMove']=$responseDataBusDetail['response']['data']['timeMove'];
                        $dataInsertBook['OriginCity']=$responseDataBusDetail['response']['data']['originName'];
                        $dataInsertBook['OriginName']=$responseDataBusDetail['response']['data']['originName'];
                        $dataInsertBook['OriginTerminal']=$responseDataBusDetail['response']['data']['originTerminal'];
                        $dataInsertBook['DestinationCity']=$responseDataBusDetail['response']['data']['destinationName'];
                        $dataInsertBook['DestinationName']=$responseDataBusDetail['response']['data']['destinationName'];
                        $dataInsertBook['DestinationTerminal']=$responseDataBusDetail['response']['data']['destinationTerminal'];
                        $dataInsertBook['CarType']=$responseDataBusDetail['response']['data']['carType'];
                        $dataInsertBook['CountFreeChairs']=$responseDataBusDetail['response']['data']['countFreeChairs'];
                        $dataInsertBook['ServiceMessage']=$responseDataBusDetail['response']['data']['description'];
                        $dataInsertBook['price_api']=$price_api;
                        $dataInsertBook['total_price']=$price;
                        $dataInsertBook['BaseCompany']=$responseDataBusDetail['response']['data']['company'];
                        $dataInsertBook['DateMove']=$responseDataBusDetail['response']['data']['dateMove'];
                        $dataInsertBook['creation_date']=date('Y-m-d H:i:s');
                        $dataInsertBook['creation_date_int']=time();
                        $dataInsertBook['irantech_commission']=$itCommission;
                        $dataInsertBook['member_name']=$responseDataBusDetail['response']['data']['contact']['name'];
                        //                        $dataInsertBook['member_mobile']=$responseDataBusDetail['response']['data']['telephone']['phoneNumber'];
                        $dataInsertBook['member_mobile']='09129409530';
                        //                        $dataInsertBook['member_email']=$responseDataBusDetail['response']['data']['contact']['email'];
                        $dataInsertBook['member_email']='info@iran-tech.com';

                        foreach($responseDataBusDetail['response']['data']['passengers'] as $passenger){

                            $dataInsertBook['passenger_gender']=$passenger['gender'];
                            $dataInsertBook['passenger_name']=$passenger['firstName'];
                            $dataInsertBook['passenger_family']=$passenger['lastName'];
                            $dataInsertBook['passenger_national_code']=$passenger['nationalIdentification'];
                            $dataInsertBook['passenger_chairs']=$passenger['seatNumber'];

                            unset($dataInsertBook['client_id']);
                            $resultBook[]=$admin->ConectDbClient("", $agencyID, "Insert", $dataInsertBook, "book_bus_tb", "");
                            $ModelBase=Load::library('ModelBase');
                            $ModelBase->setTable("report_bus_tb");
                            $dataInsertBook['client_id']=$agencyID;
                            $resultBook[]=$ModelBase->insertLocal($dataInsertBook);

                        }



                        $responseData=$responseDataBusReserve;

                    }else{
                        $responseData=$responseDataBusReserve;
                    }


                }else{
                    $responseData=ProviderStatus([
                        'client'=>false,
                        'provider'=>false
                    ], __METHOD__, 'SourceReaderError');
                }


            }else{
                $responseData=ProviderStatus([
                    'client'=>false,
                    'provider'=>false
                ], __METHOD__, 'InvalidAuthentication');
            }


        }catch(Exception $e){
            $responseData=ProviderStatus([
                'client'=>false,
                'provider'=>false
            ], __METHOD__, 'BadArgument');
        }

        return $responseData;
    }

    public function busReserve($requestUrl, $dataRequest)
    {

        $resClient=$this->ClientData['id'];
        if(!empty($resClient)){
            $agencyID=$resClient['clientId'];
            $data=json_encode($dataRequest);

            /**
             *
             * @param $requestUrl *@param $dataRequest*@return array
             */
            $responseDataBusDetail=$this->busDetailExecute($requestUrl, $data);

            $status_checker = isset($responseDataBusDetail['response']['successfulStatus']) ? $responseDataBusDetail['response']['successfulStatus']: $responseDataBusDetail['response']['SuccessfulStatus'];
            if(responseSuccessfulCheck($status_checker)){

                $ModelBase=Load::library('ModelBase');
                $sqlFactorNumber=" SELECT DISTINCTROW 
                         passenger_factor_num AS factorNumber
                     FROM 
                         report_bus_tb 
                     WHERE 
                         order_code = '{$dataRequest['requestNumber']}' 
                     ORDER BY id DESC
                     ";
                $factorNumber=$ModelBase->load($sqlFactorNumber)['factorNumber'];


                $price=$responseDataBusDetail['response']['data']['price']*count($responseDataBusDetail['response']['data']['passengers']);

                $irantechCommission=Load::controller('irantechCommission');
                $serviceTitle=ucwords($responseDataBusDetail['response']['data']['webServiceType']).'Bus';
                $itCommission=$irantechCommission->getCommission($serviceTitle, '13');


                $comment=" رزرو اتوبوس "." ".$responseDataBusDetail['response']['data']['originCity']." - ".$responseDataBusDetail['response']['data']['destinationCity']." "."به شماره رزرو "." ".$factorNumber;
                $priceTransaction=0;
                if($responseDataBusDetail['response']['data']['availablePaymentMethods']==='Credit' && $responseDataBusDetail['response']['data']['webServiceType']!=='private'){
                    $priceTransaction=$price;
                }
                $reason='buy_bus';
                if(isset($itCommission) && $itCommission!=''){
                    $priceTransaction+=((int)$itCommission*count($responseDataBusDetail['response']['data']['passengers']));
                }


                //  اعتبارسنجی صاحب سیستم //
                $check=$this->checkCredit($priceTransaction, $agencyID);

                if($check['status']==='TRUE'){
                    // کاهش اعتبار موقت صاحب سیستم //


                    $admin=Load::controller('admin');
                    $sqlCheckTransaction="SELECT * FROM transaction_tb WHERE FactorNumber = '".$factorNumber."' ";
                    $CheckTransaction=$admin->ConectDbClient($sqlCheckTransaction, $resClient['clientId'], "Select");

                    if(empty($CheckTransaction)){
                        $reduceTransaction=$this->decreasePendingCredit($priceTransaction, $factorNumber, $comment, $reason, $agencyID);


                        if($reduceTransaction){

                            /**
                             * @param $requestUrl
                             * @param $dataRequest
                             * @return array
                             */

                            $responseDataBusReserve=$this->busReserveExecute($requestUrl, $data);

                            $status_checker = isset($responseDataBusReserve['response']['successfulStatus']) ? $responseDataBusReserve['response']['successfulStatus']: $responseDataBusReserve['response']['SuccessfulStatus'];
                            if(responseSuccessfulCheck($status_checker)){

                                // آپدیت تراکنش به موفق برای زمانیکه رزرو به صورت پرداخت اعتباری بوده//
                                if($responseDataBusDetail['response']['data']['availablePaymentMethods']==='Credit'){
                                    $this->setCreditToSuccess($factorNumber, $agencyID);
                                }


                                $Model=Load::library('Model');
                                $Model->setTable("book_bus_tb");
                                $dataReport['status']='book';
                                $condition="passenger_factor_num = '{$factorNumber}'";
                                $Model->update($dataReport, $condition);

                                $ModelBase->setTable("report_bus_tb");

                                $ModelBase->update($dataReport, $condition);


                                $responseData=$responseDataBusReserve;


                            }else{
                                $responseData=$responseDataBusReserve;
                            }
                        }
                    }else{
                        $responseData=ProviderStatus([
                            'client'=>false,
                            'provider'=>false
                        ], __METHOD__, 'ExpiredRequestNumber');
                    }
                }else{
                    $responseData=ProviderStatus([
                        'client'=>false,
                        'provider'=>false
                    ], __METHOD__, 'OutOfCredit');
                }


            }else{
                $responseData=ProviderStatus([
                    'client'=>false,
                    'provider'=>false
                ], __METHOD__, 'SourceReaderError');
            }
        }else{
            $responseData=ProviderStatus([
                'client'=>false,
                'provider'=>false
            ], __METHOD__, 'InvalidAuthentication');
        }
        return $responseData;
    }

    public function busRefundCheck($requestUrl, $dataRequest)
    {

        $checkValidate=[
            $dataRequest['requestNumber']=>[
                'message'=>"['requestNumber']"
            ],
            $dataRequest['reserveRequestId']=>[
                'message'=>"['reserveRequestId']"
            ],
            $dataRequest['sourceCode']=>[
                'message'=>"['sourceCode']"
            ]
        ];

        foreach($checkValidate as $key=>$item){
            $responseData=$this->fieldChecker($key, $item);
            if($responseData!==true){
                return $responseData;
            }
        }


        try{

            /**
             * @param $dataRequest --> 'DestinationsIataCode' & 'OriginIataCode'
             * @return array
             */
            if(!empty($dataRequest)){
                /**
                 * @param $data --> Requested data
                 * @return false|string
                 */
                $dataRequest=json_encode($dataRequest);

                /**
                 * @param $requestUrl
                 * @param $dataRequest
                 * @return mixed
                 */

                $responseData=$this->busRefundCheckExecute($requestUrl, $dataRequest);

            }else{
                $responseData=ProviderStatus([
                    'client'=>false,
                    'provider'=>false
                ], __METHOD__, 'BadArgument');
            }
        }catch(Exception $e){
            $responseData=ProviderStatus([
                'client'=>false,
                'provider'=>false
            ], __METHOD__, 'NoResult');
        }

        return $responseData;
    }

    public function insertInfoCancel($params)
    {
        $admin=Load::controller('admin');

        $sqlCheck="SELECT * FROM cancel_ticket_details_tb WHERE FactorNumber='".$params['FactorNumber']."' AND RequestNumber='".$params['RequestNumber']."'  ";
        $lastIdCheck=$admin->ConectDbClient($sqlCheck, $params['clientId'], 'Select', '', '', '');

        if(empty($lastIdCheck['id'])){
            $data['MemberId']=$params['MemberId'];
            $data['TypeCancel']=$params['TypeService'];
            $data['FactorNumber']=$params['FactorNumber'];
            $data['RequestNumber']=$params['RequestNumber'];
            $data['ReasonMember']='PersonalReason';
            $data['AccountOwner']=isset($params['AccountOwner']) ? $params['AccountOwner'] : '';
            $data['CardNumber']=isset($params['CardNumber']) ? $params['CardNumber'] : '';
            $data['NameBank']=isset($params['NameBank']) ? $params['NameBank'] : '';
            $data['isCreditPayment']=($params['payment_type']=='credit') ? '1' : '0';
            $data['PercentNoMatter']='Yes';
            $data['status']='RequestClient';
            $data['DateRequestMemberInt']=time();

            $result=$admin->ConectDbClient('', $params['clientId'], "Insert", $data, "cancel_ticket_details_tb", "");
            $sql="SELECT * FROM cancel_ticket_details_tb ORDER BY id DESC LIMIT 1";
            $lastId=$admin->ConectDbClient($sql, $params['clientId'], 'Select', '', '', '');
            $id=$lastId['id'];

            $dataTicket['IdDetail']=$id;
            $dataTicket['NationalCode']=$params['NationalCode'];
            $resultTicket=$admin->ConectDbClient('', $params['clientId'], "Insert", $dataTicket, "cancel_ticket_tb", "");
            return $resultTicket;
        }

        return false;
    }

    public function busRefund($requestUrl, $dataRequest)
    {

        $checkValidate=[
            $dataRequest['requestNumber']=>[
                'message'=>"['requestNumber']"
            ],
            $dataRequest['reserveRequestId']=>[
                'message'=>"['reserveRequestId']"
            ],
            $dataRequest['sourceCode']=>[
                'message'=>"['sourceCode']"
            ]
        ];
        $incommingData=$dataRequest;

        foreach($checkValidate as $key=>$item){
            $responseData=$this->fieldChecker($key, $item);
            if($responseData!==true){
                return $responseData;
            }
        }


        try{

            /**
             * @param $dataRequest --> 'DestinationsIataCode' & 'OriginIataCode'
             * @return array
             */
            if(!empty($dataRequest)){
                /**
                 * @param $data --> Requested data
                 * @return false|string
                 */
                $dataRequest=json_encode($dataRequest);

                /**
                 * @param $requestUrl
                 * @param $dataRequest
                 * @return mixed
                 */


                if(!empty($this->ClientData['id']['clientId'])){
                    $admin=Load::controller('admin');
                    $sql="SELECT * FROM book_bus_tb WHERE order_code='".$incommingData['requestNumber']."'";
                    $bookRecord=$admin->ConectDbClient($sql, $this->ClientData['id']['clientId'], 'Select', '', '', '');

                    $insertInfoCancel=$this->insertInfoCancel([
                        'MemberId'=>$bookRecord['member_id'],
                        'TypeService'=>'bus',
                        'FactorNumber'=>$bookRecord['passenger_factor_num'],
                        'RequestNumber'=>$bookRecord['order_code'],
                        'AccountOwner'=>$bookRecord['member_name'],
                        'payment_type'=>$bookRecord['payment_type'],
                        'NationalCode'=>$bookRecord['passenger_national_code'],
                        'CardNumber'=>'',
                        'NameBank'=>'',
                        'clientId'=>$this->ClientData['id']['clientId']
                    ]);

                    if($insertInfoCancel==true){
                        $responseData=$this->busRefundExecute($requestUrl, $dataRequest);
                    }else{
                        $responseData=ProviderStatus([
                            'client'=>false,
                            'provider'=>false
                        ], __METHOD__, 'RepetitiveRequest');
                    }

                }else{
                    $responseData=ProviderStatus([
                        'client'=>false,
                        'provider'=>false
                    ], __METHOD__, 'InvalidAuthentication');
                }
            }else{
                $responseData=ProviderStatus([
                    'client'=>false,
                    'provider'=>false
                ], __METHOD__, 'BadArgument');
            }
        }catch(Exception $e){
            $responseData=ProviderStatus([
                'client'=>false,
                'provider'=>false
            ], __METHOD__, 'NoResult');
        }

        return $responseData;
    }

    //    #region [busReserve]
    //    public function busReserve2($requestUrl, $dataRequest)
    //    {
    //        try{
    //            $resClient=$this->ClientData['id'];
    //            if(!empty($resClient)){
    //                $agencyID=$resClient['clientId'];
    //                $data=json_encode($dataRequest);
    //                /**
    //                 * @param $requestUrl
    //                 * @param $dataRequest
    //                 * @return mixed
    //                 */
    //                $responseDataBusDetail=$this->busDetailExecute($requestUrl, $data);
    //                if(responseSuccessfulCheck($responseDataBusDetail['response']['successfulStatus'])){
    //
    //                    $admin=Load::controller('admin');
    //
    //
    //                    /**
    //                     * @param $requestUrl
    //                     * @param $dataRequest
    //                     * @return array
    //                     */
    //                    $responseDataBusReserve=$this->busPreReserveExecute($requestUrl, $data);
    //                    if(responseSuccessfulCheck($responseDataBusReserve['response']['successfulStatus'])){
    //                        $responseData=$responseDataBusReserve;
    //                    }else{
    //                        $responseData=$responseDataBusReserve;
    //                    }
    //
    //
    //                    $factorNumber=substr(time(), 0, 3).mt_rand(0000, 9999).substr(time(), 7, 10);
    //                    $price=$responseDataBusDetail['response']['data']['price']*count($dataRequest['passengers']);
    //
    //                    $irantechCommission=Load::controller('irantechCommission');
    //                    $serviceTitle=ucwords($responseDataBusDetail['response']['data']['webServiceType']).'Bus';
    //                    $itCommission=$irantechCommission->getCommission($serviceTitle, '13');
    //
    //
    //                    $comment=" رزرو اتوبوس "." ".$responseDataBusDetail['response']['data']['originCity']." - ".$responseDataBusDetail['response']['data']['destinationCity']." "."به شماره رزرو "." ".$factorNumber;
    //                    $priceTransaction=0;
    //                    if($responseDataBusDetail['response']['data']['availablePaymentMethods']=='Credit' && $responseDataBusDetail['response']['data']['webServiceType']!='private'){
    //                        $priceTransaction=$price;
    //                    }
    //                    $reason='buy_bus';
    //                    if(isset($itCommission) && $itCommission!=''){
    //                        $priceTransaction+=((int)$itCommission*count($dataRequest['passengers']));
    //                    }
    //
    //                    //  اعتبارسنجی صاحب سیستم //
    //                    $check=$this->checkCredit($priceTransaction, $agencyID);
    //                    if($check['status']=='TRUE'){
    //                        // کاهش اعتبار موقت صاحب سیستم //
    //                        $reduceTransaction=$this->decreasePendingCredit($priceTransaction, $factorNumber, $comment, $reason, $agencyID);
    //
    //                        if($reduceTransaction){
    //
    //                            $data=json_encode($dataRequest);
    //                            /**
    //                             * @param $requestUrl
    //                             * @param $dataRequest
    //                             * @return array
    //                             */
    //                            $responseDataBusReserve=$this->busPreReserveExecute($requestUrl, $data);
    //
    //                            if(responseSuccessfulCheck($responseDataBusReserve['response']['successfulStatus'])){
    //
    //
    //                                // آپدیت تراکنش به موفق برای زمانیکه رزرو به صورت پرداخت اعتباری بوده//
    //                                if($responseDataBusDetail['response']['data']['availablePaymentMethods']=='Credit'){
    //                                    $this->setCreditToSuccess($factorNumber, $agencyID);
    //                                }
    //
    //                                $dataInsertBook['order_code']=$responseDataBusReserve['ID'];
    //                                $dataInsertBook['passenger_factor_num']=$factorNumber;
    //                                if($responseDataBusDetail['response']['data']['availablePaymentMethods']=='Credit'){
    //                                    $dataInsertBook['status']='book';
    //                                }elseif($responseDataBusDetail['response']['data']['availablePaymentMethods']=='Online'){
    //                                    $dataInsertBook['status']='prereserve';
    //                                }
    //                                $dataInsertBook['payment_date']=Date('Y-m-d H:i:s');
    //                                $dataInsertBook['payment_type']='credit';
    //                                $dataInsertBook['ServiceCode']=$responseDataBusDetail['response']['data']['busCode'];
    //                                $dataInsertBook['CompanyName']=$responseDataBusDetail['response']['data']['company'];
    //                                $dataInsertBook['TimeMove']=$responseDataBusDetail['response']['data']['timeMove'];
    //                                $dataInsertBook['OriginCity']='';
    //                                $dataInsertBook['OriginName']=$responseDataBusDetail['response']['data']['originName'];
    //                                $dataInsertBook['OriginTerminal']=$responseDataBusDetail['response']['data']['originTerminal'];
    //                                $dataInsertBook['DestinationCity']='';
    //                                $dataInsertBook['DestinationName']=$responseDataBusDetail['response']['data']['destinationName'];
    //                                $dataInsertBook['DestinationTerminal']=$responseDataBusDetail['response']['data']['destinationTerminal'];
    //                                $dataInsertBook['CarType']=$responseDataBusDetail['response']['data']['carType'];
    //                                $dataInsertBook['CountFreeChairs']=$responseDataBusDetail['response']['data']['countFreeChairs'];
    //                                $dataInsertBook['ServiceMessage']=$responseDataBusDetail['response']['data']['description'];
    //                                $dataInsertBook['price_api']=$price;
    //                                $dataInsertBook['total_price']=$price;
    //                                $dataInsertBook['BaseCompany']=$responseDataBusDetail['response']['data']['company'];
    //                                $dataInsertBook['DateMove']=$responseDataBusDetail['response']['data']['dateMove'];
    //                                $dataInsertBook['creation_date']=date('Y-m-d H:i:s');
    //                                $dataInsertBook['creation_date_int']=time();
    //                                $dataInsertBook['irantech_commission']=$itCommission;
    //                                $dataInsertBook['member_name']=$dataRequest['Contact']['name'];
    //                                $dataInsertBook['member_mobile']=$dataRequest['Contact']['mobilePhone'];
    //                                $dataInsertBook['member_email']=$dataRequest['Contact']['email'];
    //
    //                                foreach($dataRequest['Passengers'] as $passenger){
    //
    //                                    $dataInsertBook['passenger_gender']=$passenger['Gender'];
    //                                    $dataInsertBook['passenger_name']=$passenger['FirstName'];
    //                                    $dataInsertBook['passenger_family']=$passenger['LastName'];
    //                                    $dataInsertBook['passenger_national_code']=$passenger['NationalCode'];
    //                                    $dataInsertBook['passenger_chairs']=$passenger['SeatNumber'];
    //
    //                                    unset($dataInsertBook['client_id']);
    //                                    $resultBook[]=$admin->ConectDbClient("", $agencyID, "Insert", $dataInsertBook, "book_bus_tb", "");
    //
    //                                    $ModelBase->setTable("report_bus_tb");
    //                                    $dataInsertBook['client_id']=$agencyID;
    //                                    $resultBook[]=$ModelBase->insertLocal($dataInsertBook);
    //
    //                                }
    //                                if(in_array("0", $resultBook)){
    //
    //                                    $responseData['ErrorDetail']=[
    //                                        'Code'=>'EB-busReserve-06',
    //                                        'Message'=>'ERROR ON RESERVE',
    //                                        'MessagePersian'=>'خطایی در ثبت اطلاعات شما پیش آمده است.'
    //                                    ];
    //
    //                                }else{
    //                                    $responseData=[
    //                                        'Status'=>'success',
    //                                        'ReserveNumber'=>$factorNumber,
    //                                        'FullPaymentAmount'=>$price,
    //                                        'PaymentEndpoint'=>$responseDataBusReserve['PaymentEndpoint']
    //                                    ];
    //                                }
    //
    //
    //                            }else{
    //                                $responseData=$responseDataBusReserve;
    //                            }
    //                        }else{
    //                            $responseData['ErrorDetail']=[
    //                                'Code'=>'EB-busReserve-04',
    //                                'Message'=>'ERROR ON RESERVE',
    //                                'MessagePersian'=>'همکار گرامی، در کسر اعتبرا شما مشکلی به وجود آمده است.'
    //                            ];
    //                        }
    //
    //                    }else{
    //                        $responseData['ErrorDetail']=[
    //                            'Code'=>'EB-busReserve-03',
    //                            'Message'=>'ERROR ON RESERVE',
    //                            'MessagePersian'=>'همکار گرامی، اعتبار شما به پایان رسیده است'
    //                        ];
    //                    }
    //
    //                    //                    }else{
    //                    //                        $responseData['ErrorDetail']=[
    //                    //                            'Code'=>'EB-busReserve-033',
    //                    //                            'Message'=>'ERROR ON RESERVE',
    //                    //                            'MessagePersian'=>'همکار گرامی، در محیط تست امکان خرید اتوبوس فقط در مسیرهای تست گفته شده وجود دارد.'
    //                    //                        ];
    //                    //                    }
    //
    //
    //                }else{
    //                    $responseData['ErrorDetail']=[
    //                        'Code'=>$responseDataBusDetail['response']['data']['ErrorDetail']['Code'],
    //                        'Message'=>$responseDataBusDetail['response']['data']['ErrorDetail']['Message'],
    //                        'MessagePersian'=>$responseDataBusDetail['response']['data']['ErrorDetail']['MessagePersian']
    //                    ];
    //                }
    //
    //
    //            }else{
    //                $responseData['ErrorDetail']=[
    //                    'Code'=>'EB-busReserve-02',
    //                    'Message'=>'Not Valid userName Or Password',
    //                    'MessagePersian'=>''
    //                ];
    //            }
    //
    //
    //        }catch(Exception $e){
    //            $responseData['ErrorDetail']=[
    //                'Code'=>'EB-busReserve-01',
    //                'Message'=>'System error',
    //                'MessagePersian'=>'خطای سیستمی'
    //            ];
    //        }
    //
    //        return $responseData;
    //    }
    //    #endregion


    #region [inquireBusTicket]
    public function inquireBusTicket($requestUrl, $dataRequest)
    {
        try{

            $ModelBase=Load::library('ModelBase');
            $Sql="SELECT order_code, pnr, ClientTraceNumber, client_id FROM report_bus_tb WHERE passenger_factor_num = '{$dataRequest['ReserveNumber']}' ";
            $resultReport=$ModelBase->load($Sql);
            if(!empty($resultReport) && $resultReport['order_code']!=''){

                $dataRequest['ID']=$resultReport['order_code'];
                $data=json_encode($dataRequest);
                $url=$requestUrl."InquireBusTicket";
                $dataResponse=functions::curlExecution($url, $data, 'yes');

                functions::insertLog('request url: '.$url, 'busApi');
                functions::insertLog('request data: '.$data, 'busApi');
                functions::insertLog('response data: '.json_encode($dataResponse), 'busApi');

                if(!isset($dataResponse['ErrorDetail']['Code']) && ($dataResponse['Status']=='Issued' || $dataResponse['Status']=='Refunded')){

                    // آپدیت تراکنش به موفق برای زمانیکه رزرو به صورت پرداخت آنلاین بوده//
                    if($dataResponse['Status']=='Issued'){
                        $this->setCreditToSuccess($dataRequest['ReserveNumber'], $resultReport['client_id']);
                    }

                    $userName=filter_var($dataRequest['userName'], FILTER_SANITIZE_STRING);
                    $key=filter_var($dataRequest['password'], FILTER_SANITIZE_STRING);
                    $Sql="SELECT clientId FROM client_user_api WHERE userName='{$userName}' AND keyTabdol='{$key}'";
                    $resClient=$ModelBase->load($Sql);
                    if(!empty($resClient)){
                        $agencyID=$resClient['clientId'];

                        if($dataResponse['Status']=='Issued'){
                            $dataUpdateBook['status']='book';
                        }elseif($dataResponse['Status']=='Refunded'){
                            $dataUpdateBook['status']='cancel';
                        }
                        $dataUpdateBook['pnr']=$dataResponse['TicketNumber'];
                        $dataUpdateBook['ClientTraceNumber']=isset($dataResponse['ClientTraceNumber']) ? $dataResponse['ClientTraceNumber'] : '';

                        $admin=Load::controller('admin');
                        $condition=" passenger_factor_num = '{$dataRequest['ReserveNumber']}'";
                        $admin->ConectDbClient('', $agencyID, 'Update', $dataUpdateBook, 'book_bus_tb', $condition);

                        $ModelBase->setTable('report_bus_tb');
                        $ModelBase->update($dataUpdateBook, $condition);
                    }
                }

            }else{
                $dataResponse['ErrorDetail']=[
                    'Code'=>'EB-inquireBusTicket-02',
                    'Message'=>'There is no information about Ticket No.',
                    'MessagePersian'=>''
                ];
            }

        }catch(Exception $e){
            $dataResponse['ErrorDetail']=[
                'Code'=>'EB-inquireBusTicket-01',
                'Message'=>'System error',
                'MessagePersian'=>'خطای سیستمی'
            ];
        }

        return $dataResponse;
    }
    #endregion

    #region [cancellationBusTicket]
    public function cancellationBusTicket($requestUrl, $dataRequest)
    {
        try{

            $ModelBase=Load::library('ModelBase');

            $sql=" SELECT id FROM report_cancel_buy_tb WHERE factor_number = '{$dataRequest['ReserveNumber']}' ";
            $check=$ModelBase->load($sql);
            if(empty($check)){

                $Sql=" SELECT order_code, pnr, ClientTraceNumber, member_name, price_api FROM report_bus_tb WHERE passenger_factor_num = '{$dataRequest['ReserveNumber']}' ";
                $resultReport=$ModelBase->load($Sql);
                if(!empty($resultReport) && $resultReport['order_code']!=''){

                    $dataRequest['ID']=$resultReport['order_code'];
                    $dataRequest['PassengerName']=$resultReport['member_name'];
                    $dataRequest['CardNumber']=$dataRequest['CardNumber'];
                    $dataRequest['TicketPrice']=$resultReport['price_api'];
                    $data=json_encode($dataRequest);
                    $url=$requestUrl."CancellationBusTicket";
                    $resultCancellationBusTicket=functions::curlExecution($url, $data, 'yes');

                    functions::insertLog('request url: '.$url, 'busApi');
                    functions::insertLog('request data: '.$data, 'busApi');
                    functions::insertLog('response data: '.json_encode($resultCancellationBusTicket), 'busApi');

                    if(!isset($resultCancellationBusTicket['ErrorDetail']['Code']) && $resultCancellationBusTicket['Status']=='Refunded'){

                        $userName=filter_var($dataRequest['userName'], FILTER_SANITIZE_STRING);
                        $key=filter_var($dataRequest['password'], FILTER_SANITIZE_STRING);
                        $Sql="SELECT clientId FROM client_user_api WHERE userName='{$userName}' AND keyTabdol='{$key}'";
                        $resClient=$ModelBase->load($Sql);
                        if(!empty($resClient)){
                            $agencyID=$resClient['clientId'];
                            $admin=Load::controller('admin');

                            // update book and report table
                            $dataUpdateBook['status']='cancel';
                            $condition=" passenger_factor_num = '{$dataRequest['ReserveNumber']}'";
                            $resultUpdate[]=$admin->ConectDbClient('', $agencyID, 'Update', $dataUpdateBook, 'book_bus_tb', $condition);
                            $ModelBase->setTable('report_bus_tb');
                            $resultUpdate[]=$ModelBase->update($dataUpdateBook, $condition);

                            // insert transaction table
                            $comment='کنسلی بلیط اتوبوس (وب سرویس سفر360) به شماره فاکتور: '.$dataRequest['ReserveNumber'];
                            $resultUpdate[]=$this->increaseCredit($resultCancellationBusTicket['RefundAmount'], $dataRequest['ReserveNumber'], $comment, $agencyID);

                            // insert cancel table
                            $dataInsertCancel['client_id']=CLIENT_ID;
                            $dataInsertCancel['id_member']='';
                            $dataInsertCancel['type_application']='bus';
                            $dataInsertCancel['factor_number']=$dataRequest['ReserveNumber'];;
                            $dataInsertCancel['account_owner']=$resultReport['member_name'];
                            $dataInsertCancel['card_number']=$dataRequest['CardNumber'];
                            $dataInsertCancel['name_bank']='';
                            $dataInsertCancel['comment_user']='';
                            $dataInsertCancel['request_date']=dateTimeSetting::jdate('Y-m-d', '', '', '', 'en');
                            $dataInsertCancel['request_time']=date('H:m:s');
                            $dataInsertCancel['creation_date_int']=time();
                            $dataInsertCancel['cancel_percent']='10';
                            $dataInsertCancel['cancel_price']=$resultCancellationBusTicket['TicketPrice']-$resultCancellationBusTicket['RefundAmount'];
                            $dataInsertCancel['comment_admin']='';
                            $dataInsertCancel['confirm_date']=dateTimeSetting::jdate('Y-m-d', '', '', '', 'en');
                            $dataInsertCancel['confirm_time']=date('H:m:s');
                            $dataInsertCancel['status']='confirm_admin';

                            $resultUpdate[]=$admin->ConectDbClient('', $agencyID, 'Insert', $dataInsertCancel, 'cancel_buy_tb', '');
                            $ModelBase->setTable('report_cancel_buy_tb');
                            $resultUpdate[]=$ModelBase->insertLocal($dataInsertCancel);

                            if(!in_array("0", $resultUpdate)){
                                $dataResponse=[
                                    'ReserveNumber'=>$dataRequest['ReserveNumber'],
                                    'TicketPrice'=>$resultCancellationBusTicket['TicketPrice'],
                                    'RefundAmount'=>$resultCancellationBusTicket['RefundAmount'],
                                    'Status'=>$resultCancellationBusTicket['Status']
                                ];
                            }else{
                                $dataResponse['ErrorDetail']=[
                                    'Code'=>'EB-cancellationBusTicket-04',
                                    'Message'=>'There was an error registering the information. Please contact support.',
                                    'MessagePersian'=>''
                                ];
                            }


                        }

                    }else{
                        $dataResponse['ErrorDetail']=[
                            'Code'=>$resultCancellationBusTicket['ErrorDetail']['Code'],
                            'Message'=>$resultCancellationBusTicket['ErrorDetail']['Message'],
                            'MessagePersian'=>$resultCancellationBusTicket['ErrorDetail']['MessagePersian']
                        ];
                    }

                }else{
                    $dataResponse['ErrorDetail']=[
                        'Code'=>'EB-cancellationBusTicket-03',
                        'Message'=>'The requested ticket was already refunded.',
                        'MessagePersian'=>''
                    ];
                }

            }else{
                $dataResponse['ErrorDetail']=[
                    'Code'=>'EB-cancellationBusTicket-02',
                    'Message'=>'There is no information about Ticket No.',
                    'MessagePersian'=>''
                ];
            }

        }catch(Exception $e){
            $dataResponse['ErrorDetail']=[
                'Code'=>'EB-cancellationBusTicket-01',
                'Message'=>'System error',
                'MessagePersian'=>'خطای سیستمی'
            ];
        }

        return $dataResponse;
    }
    #endregion


    #region [checkCredit]
    public function checkCredit($amountToCheck, $clientId)
    {
        $admin=Load::controller('admin');
        //600: pending records under 10 minutes are included
        $time=time()-(600);

        $query="SELECT"." COALESCE((SELECT SUM(Price) FROM transaction_tb WHERE Status='1'), 0) as `credit`, "." COALESCE((SELECT SUM(Price) FROM transaction_tb WHERE Status='2' AND"." ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')) ), 0) as `debit` ";
        $result=$admin->ConectDbClient($query, $clientId, 'Select', '', '', '');
        $currentCredit=$result['credit']-$result['debit'];
        $remainingCredit=$currentCredit-$amountToCheck;
        if($currentCredit >= 0){
            if($amountToCheck > $currentCredit){
                $result['status']='FALSE';
                $result['credit']=$remainingCredit;
            }else{
                $result['status']='TRUE';
                $result['credit']=$remainingCredit;
            }
        }else{
            $result['status']='FALSE';
            $result['credit']=$remainingCredit;
        }

        return $result;
    }
    #endregion

    #region [decreasePendingCredit]
    public function decreasePendingCredit($amount, $factorNumber, $comment, $reason, $clientId)
    {
        $admin=Load::controller('admin');
        $data['Price']=$amount;
        $data['FactorNumber']=$factorNumber;
        $data['Comment']=$comment;
        $data['Reason']=$reason;
        $data['Status']='2';
        $data['PaymentStatus']='pending';
        $data['creationDateInt']=time();
        $data['BankTrackingCode']='کسر موقت';
        $result = $admin->ConectDbClient('', $clientId, "Insert", $data, "transaction_tb", "");
        $data['clientID'] = $clientId;
        $this->transactions->insertTransaction($data);
        return $result;
    }
    #endregion

    #region [setCreditToSuccess]
    public function setCreditToSuccess($factorNumber, $clientId)
    {
        $admin=Load::controller('admin');
        $data['PaymentStatus']='success';
        $data['PriceDate']=date("Y-m-d H:i:s");
        $data['BankTrackingCode']='';
        $condition="FactorNumber = '{$factorNumber}'";
        $result = $admin->ConectDbClient('', $clientId, 'Update', $data, 'transaction_tb', $condition);
        $data['clientID'] = $clientId;
        $this->transactions->updateTransaction($data, $condition);
        return $result;
    }
    #endregion


    #region [increaseCredit]
    public function increaseCredit($amount, $factorNumber, $comment, $clientId)
    {
        $admin=Load::controller('admin');
        $data['Price']=$amount;
        $data['FactorNumber']=$factorNumber;
        $data['Comment']=$comment;
        $data['Reason']='increase';
        $data['Status']='2';
        $data['PaymentStatus']='success';
        $data['creationDateInt']=time();
        $data['BankTrackingCode']='';
        $result = $admin->ConectDbClient('', $clientId, "Insert", $data, "transaction_tb", "");
        $data['clientID'] = $clientId;
        $this->transactions->insertTransaction($data);
        return $result;
    }
    #endregion

    /**
     * @return bool
     */
    public function checkRequestMethode()
    {
        return $_SERVER['REQUEST_METHOD']=='POST' && (strpos($_SERVER['CONTENT_TYPE'], 'application/json')!==false);
    }

    /**
     * @param $dataRequest
     * @param array $data
     * @return array
     */
    public function getRoutesByCodeIata($code)
    {
        $ModelBase=Load::library('ModelBase');
        $sql=" SELECT * 
                     FROM 
                         bus_route_tb 
                     WHERE 
                         iataCode = '{$code}'
                     ";
        return $ModelBase->load($sql);

    }

    /**
     * @param $data
     * @return false|string
     */
    public function busSearchRequiredData($data)
    {
        $requestData=[
            "userName"=>$data['userName'],
            "date"=>$data['date'],
            "route"=>[
                [
                    "originCityId"=>$data['route']['originCity'],
                    "destinationCityId"=>$data['route']['destinationCity']
                ]
            ],
            "passengerCount"=>$data['passengerCount']
        ];
        $data=json_encode($requestData);
        return $data;
    }

    /**
     * @param array $return
     * @return array|array[]
     */
    public function detectApiResponseAndGdsResponse(array $return)
    {

        if((isset($return['response']['data']) && is_array($return['response']['data'])) || ((isset($return['response']['Error'])))){
            $FinalReturn=$return;
        }else{
            $successfull = isset($return['response']['successfulStatus']) ? $return['response']['successfulStatus'] : $return['response']['SuccessfulStatus'] ;
            $FinalReturn = ResponseStatus($return, __METHOD__, @$return['response']['requestNumber'], $successfull , $return['response']['information']);
        }

        SetResponseCode($this->getResponseHttpCode($FinalReturn));
        return $FinalReturn;
    }

    /**
     * @param $HTTP
     * @return mixed
     */
    public function getResponseHttpCode($HTTP)
    {

        return  (isset($HTTP['response']['successfulStatus']) ? $HTTP['response']['successfulStatus']['HTTP'] : $HTTP['response']['SuccessfulStatus']['HTTP']);
    }

    /**
     * @param $userName
     * @param $key
     * @return array
     */
    public function getUserClientId($ModelBase, $userName, $key)
    {
        $Sql="SELECT clientId FROM client_user_api WHERE userName='{$userName}' AND keyTabdol='{$key}'";
        return $ModelBase->load($Sql);
    }

    /**
     * @param $clientId
     * @param $ModelBase
     * @return mixed
     */
    public function getClientUserName($clientId, $ModelBase)
    {
         $SqlClientAuth="SELECT Username FROM client_auth_tb WHERE ClientId='{$clientId}' AND SourceId='13' AND serviceId='11'";
        $responsiveClientAuth = $ModelBase->load($SqlClientAuth);
        return $responsiveClientAuth['Username'] ;
    }

    /**
     * @param $methodName
     * @param $dataRequestArray
     * @param $responsiveClientAuth
     * @param $requestUrl
     * @return mixed
     */
    public function callRequestedMethode($methodName, $dataRequestArray, $responsiveClientAuth, $requestUrl)
    {

        if($methodName =='citiesOrigin'){
            $return=$this->$methodName();

        }elseif($methodName =='citiesDestinations'){
            $return=$this->$methodName($dataRequestArray);

        }elseif($methodName =='routeCities'){
            $return=$this->$methodName();

        }else{
            $return=$this->$methodName($requestUrl, $dataRequestArray);
        }
        return $return;
    }

    /**
     * @param $dataRequestArray
     * @param $string
     * @param $requestUrl
     * @return array[]|mixed
     */
    public function executeMethode($dataRequestArray, $string, $requestUrl)
    {
        
        if(isset($dataRequestArray['userName']) && isset($dataRequestArray['password'])){

            $userName=filter_var($dataRequestArray['userName'], FILTER_SANITIZE_STRING);
            $key=filter_var($dataRequestArray['password'], FILTER_SANITIZE_STRING);
            $ModelBase=Load::library('ModelBase');
            /**
             * @param $userName
             * @param $key
             * @return $resClient['clientId']
             */

            $resClient=$this->getUserClientId($ModelBase, $userName, $key);

            $this->ClientData['id']       = $resClient;
            $this->ClientData['userName'] = $dataRequestArray['userName'];
            unset($dataRequestArray['userName']);
            if(!empty($resClient) && $resClient['clientId']=='299'){
                /**
                 * @param $clientId
                 * @param $ModelBase
                 * @return $responsiveClientAuth['Username']
                 */
                $responsiveClientAuth=$this->getClientUserName($resClient['clientId'], $ModelBase);

                if(!empty($responsiveClientAuth)){

                    $methodName=lcfirst($string);

                        /**
                         * @param $methodName
                         * @param $dataRequestArray --> $dataRequestArray['UserName'] && $dataRequestArray['password'] && ...
                         * @param $responsiveClientAuth --> getClientUserName
                         * @param $requestUrl
                         * @return $this->$methodName($requestUrl, $dataRequestArray)
                         */
                        $dataRequestArray['userName']=$responsiveClientAuth;
                        $return=$this->callRequestedMethode($methodName, $dataRequestArray, $responsiveClientAuth, $requestUrl);


                }else{
                    $return=ProviderStatus([
                        'client'=>false,
                        'provider'=>false
                    ], __METHOD__, 'NoAccessWebservice');
                }


            }else{
                $return=ProviderStatus([
                    'client'=>false,
                    'provider'=>false
                ], __METHOD__, 'InvalidAuth');
            }


        }else{
            $return=ProviderStatus([
                'client'=>false,
                'provider'=>false
            ], __METHOD__, 'BadArgumentUserNamePassword');
        }
        return $return;
    }

    /**
     * @param $arrayUrl
     * @return string
     */
    public function reachApiResourceUrl($arrayUrl)
    {
        return 'http://safar360.com/CoreTest/V-1/Bus/';
    }

    /**
     * @return array[]|mixed
     */
    public function prepareExecuteMethode()
    {

        $dataRequest=file_get_contents('php://input');
        $url=$_SERVER['REQUEST_URI'];
        $arrayUrl=explode('/', $url);
        /**
         * @param $arrayUrl
         * @return string  --> 'CoreTest/Bus/' || 'CoreTestDeveloper/V-1/Bus/'
         */
        $requestUrl=$this->reachApiResourceUrl($arrayUrl[2]);

        if(!empty($requestUrl)){

            $dataRequestArray=json_decode($dataRequest, true);

            /**
             * @param $dataRequestArray --> input data
             * @param $string --> methode name --> 'busSearch'
             * @param $requestUrl --> api address 'CoreTestDeveloper/V-1/Bus/1'
             * @return array[]|mixed --> final data
             */
            $return=$this->executeMethode($dataRequestArray, $arrayUrl[3], $requestUrl);
        }
        return $return;
    }

    /**
     * @param $requestUrl
     * @param $dataRequest
     * @return mixed
     */
    public function busDetailExecute($requestUrl, $dataRequest)
    {
        $url=$requestUrl."BusDetail";
        return functions::curlExecution($url, $dataRequest, 'yes');
    }

    public function busRefundCheckExecute($requestUrl, $dataRequest)
    {
        $url=$requestUrl."BusRefundCheck";
        return functions::curlExecution($url, $dataRequest, 'yes');
    }

    public function busRefundExecute($requestUrl, $dataRequest)
    {
        $url=$requestUrl."BusRefund";
        return functions::curlExecution($url, $dataRequest, 'yes');
    }

    /**
     * @param $requestUrl
     * @param $dataRequest
     * @return array
     */
    public function busPreReserveExecute($requestUrl, $dataRequest)
    {

        $url=$requestUrl."BusPreReserve";
        return functions::curlExecution($url, $dataRequest, 'yes');
    }

    /**
     * @param $requestUrl
     * @param $dataRequest
     * @return array
     */
    public function busReserveExecute($requestUrl, $dataRequest)
    {

        $url=$requestUrl."BusReserve";

        return functions::curlExecution($url, $dataRequest, 'yes');
    }

    /**
     * @param $data ,$errorCode
     * @return array
     */
    public function fieldChecker($data, $requirement)
    {


        if(isset($data) && $data!=''){
            $responseData=true;

        }else{

            $responseData=ProviderStatus([
                'client'=>false,
                'provider'=>false
            ], __METHOD__, [
                'HttpHeader'=>'500',
                'Persian'=>''.$requirement['message'].' مورد نیاز است ',
                'English'=>$requirement['message']." missing  ",
            ]);
        }

        return $responseData;
    }
}

new ApiBus();