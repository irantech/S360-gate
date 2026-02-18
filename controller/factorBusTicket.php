<?php

//error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

/**
 * Class factorBusTicket
 * @property factorBusTicket $factorBusTicket
 */
class factorBusTicket extends apiBus
{
    public $error=false;
    public $IsLogin;
    public $counterId;
    public $serviceDiscount=array();
    public $bookBusTicket=array();


    public function __construct()
    {
        parent::__construct();
        $this->IsLogin = Session::IsLogin();

        if($this->IsLogin){

            $this->counterId=functions::getCounterTypeId($_SESSION['userId']);

        }else{
            $this->counterId='5';
        }
        $this->serviceDiscount['public']=functions::ServiceDiscount($this->counterId, 'PublicBus');
        $this->serviceDiscount['private']=functions::ServiceDiscount($this->counterId, 'PrivateBus');
    }

    public function registerPassengersBus($param)
    {

//        error_reporting(1);
//        error_reporting(E_ALL | E_STRICT);
//        @ini_set('display_errors', 1);
//        @ini_set('display_errors', 'on');

        $Model=Load::library('Model');
        $ModelBase=Load::library('ModelBase');

        $factorNumber=$param['factorNumber'];
        $idMember=$param['idMember'];


        /**@var $objBusTicket resultBusTicket */
        $objBusTicket=Load::controller('resultBusTicket');
        $dataDetailBusTicket=$objBusTicket->getDetailBusTicket($param);
        $requestNumber=$dataDetailBusTicket['detailBus']["requestNumber"];






        $dataInsertBook['SourceCode']=$dataDetailBusTicket['detailBus']['source_code'];
        $dataInsertBook['SourceName']=$dataDetailBusTicket['detailBus']['source_name'];
        $dataInsertBook['WebServiceType']=$dataDetailBusTicket['detailBus']['web_service_type'];
        $dataInsertBook['ServiceCode']=$dataDetailBusTicket['detailBus']['bus_code'];
        $dataInsertBook['AvailablePaymentMethods']=$dataDetailBusTicket['detailBus']['available_payment_methods'];
        $dataInsertBook['CompanyName']=$dataDetailBusTicket['detailBus']['company'];
        $dataInsertBook['TimeMove']=$dataDetailBusTicket['detailBus']['time_move'];
        $dataInsertBook['OriginCity']=$dataDetailBusTicket['detailBus']['origin_city'];
        $dataInsertBook['OriginName']=$dataDetailBusTicket['detailBus']['origin_name'];
        $dataInsertBook['OriginTerminal']=$dataDetailBusTicket['detailBus']['origin_terminal'];
        $dataInsertBook['DestinationCity']=$dataDetailBusTicket['detailBus']['destination_city'];
        $dataInsertBook['DestinationName']=$dataDetailBusTicket['detailBus']['destination_name'];
        $dataInsertBook['DestinationTerminal']=$dataDetailBusTicket['detailBus']['destination_terminal'];
        $dataInsertBook['CarType']=$dataDetailBusTicket['detailBus']['car_type'];
        $dataInsertBook['CountFreeChairs']=$dataDetailBusTicket['detailBus']['count_free_chairs'];
        $dataInsertBook['ServiceMessage']=$dataDetailBusTicket['detailBus']['description'];
        $dataInsertBook['BaseCompany']=$dataDetailBusTicket['detailBus']['company'];
        $dataInsertBook['DateMove']=$dataDetailBusTicket['detailBus']['date_move'];

        $sqlMember=" SELECT * FROM members_tb WHERE id='{$idMember}'";
        $user=$Model->load($sqlMember);
        if(!empty($user)){
            $dataInsertBook['member_id']=$idMember;
            $dataInsertBook['member_name']=$user['name'].' '.$user['family'];
            $dataInsertBook['member_mobile']=$user['mobile'];
            $dataInsertBook['member_phone']=$user['telephone'];
            $dataInsertBook['member_email']=$user['email'];
            $checkSubAgency =  functions::checkExistSubAgency() ;
            if ($user['fk_agency_id'] > 0 || $checkSubAgency) {
                $agencyId = ($checkSubAgency) ? SUB_AGENCY_ID : $user['fk_agency'];
                $sqlAgency=" SELECT * FROM agency_tb WHERE id='{$agencyId}'";
                $agency=$Model->load($sqlAgency);
                $dataInsertBook['agency_id']=$agency['id'];
                $dataInsertBook['agency_name']=$agency['name_fa'];
                $dataInsertBook['agency_accountant']=$agency['accountant'];
                $dataInsertBook['agency_manager']=$agency['manager'];
                $dataInsertBook['agency_mobile']=$agency['mobile'];
            }
        }

        if(ISCURRENCY && $param['CurrencyCode'] > 0){
            $Currency=Load::controller('currencyEquivalent');
            $InfoCurrency=$Currency->InfoCurrency($param['CurrencyCode']);
            $dataInsertBook['currency_code']=$param['CurrencyCode'];
            $dataInsertBook['currency_equivalent']=!empty($InfoCurrency) ? $InfoCurrency['EqAmount'] : '0';
        }

        $objClientAuth=Load::library('clientAuth');
        $objClientAuth->busAuth();
        $sourceId=$objClientAuth->sourceId;
        //$sourceId = '13';

        $serviceTitle=ucwords($dataDetailBusTicket['detailBus']['web_service_type']).'Bus';

//        $irantechCommission=Load::controller('irantechCommission');
//        $itCommission=$irantechCommission->getCommission($serviceTitle, $sourceId);

        $priceWithoutDiscount=$price=(round($dataDetailBusTicket['detailBus']['beforeDiscountPrice']));

        $itCommission=0;
        $company=functions::getIdBaseCompanyBus($dataDetailBusTicket['detailBus']['base_company']);
        $arrayParamPriceChanges['originCity']=$dataDetailBusTicket['detailBus']['origin_city_iata'];
        $arrayParamPriceChanges['destinationCity']=$dataDetailBusTicket['detailBus']['destination_city_iata'];
        $arrayParamPriceChanges['companyId']=(isset($company['id']) && $company['id']!='') ? $company['id'] : 0;
        $arrayParamPriceChanges['counterId']=$this->counterId;
        $arrayParamPriceChanges['date']=$dataDetailBusTicket['detailBus']['date_move'];
        $arrayParamPriceChanges['price']=$price;
        $resBusTicketPriceChanges=functions::getBusTicketPriceChanges($arrayParamPriceChanges);
        if($resBusTicketPriceChanges!=false){
            $priceWithoutDiscount=$price=$resBusTicketPriceChanges['price'];

            $dataInsertBook['agency_commission']=$resBusTicketPriceChanges['price_change'];
            $dataInsertBook['agency_commission_price_type']=$resBusTicketPriceChanges['price_type'];
            $dataInsertBook['type_of_price_change']=$resBusTicketPriceChanges['change_type'];
        }else{
            $dataInsertBook['agency_commission']=0;
            $dataInsertBook['agency_commission_price_type']='';
            $dataInsertBook['type_of_price_change']='';
        }

        //$priceWithoutDiscount = 0;
        $web_service_type=$dataDetailBusTicket['detailBus']['web_service_type'];

        if(!empty($this->serviceDiscount[$web_service_type]) && $this->serviceDiscount[$web_service_type]['off_percent'] > 0){
            $priceWithoutDiscount = $price;
            $price=$price-(($price*$this->serviceDiscount[$web_service_type]['off_percent'])/100);

//            $discountedPrice=$objBusTicket->setPriceChanges($price);
            $dataInsertBook['services_discount']=$this->serviceDiscount[$web_service_type]['off_percent'];
        }


        $dataInsertBook['price_api']=$param['countChairReserve']*$dataDetailBusTicket['detailBus']['price'];
        $dataInsertBook['total_price']=$param['countChairReserve']*$price;
        $dataInsertBook['OriginalPrice']=$param['countChairReserve']*$priceWithoutDiscount;

        $dataInsertBook['serviceTitle']=$serviceTitle;
        $dataInsertBook['irantech_commission']=$itCommission;
        $dataInsertBook['creation_date']=date('Y-m-d H:i:s');
        $dataInsertBook['creation_date_int']=time();
        $dataInsertBook['passenger_factor_num']=$factorNumber;

        if($param['countChairReserve'] > 1){
            $expChairNumberReserve=explode("-", $param['chairNumberReserve']);
        }else{
            $expChairNumberReserve[0]=$param['chairNumberReserve'];
        }
        $passenger_list = [] ;

        foreach ($expChairNumberReserve as $key => $chair){
            if($key != 0 ) {
                $counter = $key + 1;
                $passenger_list[$key]['gender'] = $param['gender'.$counter];
                $passenger_list[$key]['nationalCode'] = $param['NationalCode'.$counter];
                $passenger_list[$key]['passenger_name'] = $param['nameFa'.$counter];
                $passenger_list[$key]['passenger_family'] = $param['familyFa'.$counter];
                $passenger_list[$key]['passenger_birthday'] = $param['birthday'.$counter];
                $passenger_list[$key]['chair'] = $chair;
            }

        }

        $resultInsert=[];
        $sqlCheck="SELECT id 
                    FROM book_bus_tb 
                    WHERE 
                        passenger_factor_num = '{$factorNumber}'
                        AND member_id = '{$idMember}' ";
        $resultCheck=$Model->load($sqlCheck);

        if(empty($resultCheck)){
            // به تعداد صندلی انتخاب شده //
            $passengerCounter=0;


            foreach($expChairNumberReserve as $key => $chairNumber){

                $passenger_birthday = (isset($param['birthday'.($key+1)]) && $param['birthday'.($key+1)]!='') ? $param['birthday'.($key+1)] : $param['birthdayEn'.($key+1)];

                $dataPassengerPreReserve[$passengerCounter]= [
                    "firstName"=>$param['nameFa'.($key+1)],
                    "lastName"=>$param['familyFa'.($key+1)],
                    "birthDate"=>$param['birthday'.($key+1)],
                    "nationalIdentification"=>$param['NationalCode'.($key+1)],
                    "seatNumber"=>$chairNumber,
                    "birthDate"=> functions::ConvertToMiladi($passenger_birthday),
                    "gender"=>($param['gender'.($key+1)]==='Male' ? '1':'2'),
                    "travelerRefNumber"=>"11"
                ];


                $dataInsertBook['passenger_gender']=$param['gender'.($key+1)];
                $dataInsertBook['passenger_name']=$param['nameFa'.($key+1)];
                $dataInsertBook['passenger_family']=$param['familyFa'.($key+1)];
                $dataInsertBook['passenger_national_code']=$param['NationalCode'.($key+1)];
                $dataInsertBook['passenger_chairs']=$chairNumber;
                $dataInsertBook['passenger_number']=$param['countChairReserve'];
                $dataInsertBook['passenger_name_en']=$param['nameEn1'];
                $dataInsertBook['passenger_family_en']=$param['familyEn1'];
                $dataInsertBook['passenger_birthday']=(isset($param['birthday'.($key+1)]) && $param['birthday'.($key+1)]!='') ? $param['birthday'.($key+1)] : $param['birthdayEn'.($key+1)];
                $dataInsertBook['passportCountry']=$param['passportCountry1'];
                $dataInsertBook['passportNumber']=$param['passportNumber1'];
                $dataInsertBook['passportExpire']=$param['passportExpire1'];
                $dataInsertBook['passenger_mobile']=(isset($param['mobilePhone1']) ? $param['mobilePhone1'] :$dataInsertBook['member_mobile']);
                $dataInsertBook['passenger_email']=$param['email1'];
                $dataInsertBook['status']='temporaryReservation';
                $dataInsertBook['order_code']=$dataDetailBusTicket['detailBus']["requestNumber"];


                unset($dataInsertBook['client_id']);
                $Model->setTable('book_bus_tb');
                $resultInsert[]=$Model->insertLocal($dataInsertBook);

                $ModelBase->setTable('report_bus_tb');
                $dataInsertBook['client_id']=CLIENT_ID;
                $resultInsert[]=$ModelBase->insertLocal($dataInsertBook);

                $passengerCounter++;
            }

            $preReserveRequired=[
                "requestNumber"=>$dataDetailBusTicket['detailBus']["requestNumber"],
                "sourceCode"=>$dataDetailBusTicket['detailBus']["source_code"],
                "busCode"=>$dataDetailBusTicket['detailBus']["bus_code"],
                "price"=>$dataDetailBusTicket['detailBus']["price"],
                "passengers"=>$dataPassengerPreReserve,
                "telephone"=>[
                    "areaCityCode"=>"",
                    "countryAccessCode"=>"",
                    "phoneNumber"=>(isset($param['mobilePhone1']) ? $param['mobilePhone1'] :$dataInsertBook['member_mobile'])
                ],
                "contact"=>[
                    "name"=>$param['nameFa1'] . ' ' . $param['familyFa1'] ,
                    "email"=>(isset($param['email1']) ? $param['email1'] :$dataInsertBook['member_email'])
                ],
                "clientUserTelephone"=>[
                    "areaCityCode"=>"",
                    "countryAccessCode"=>"",
                    "phoneNumber"=>"09123493154"
                ],
                "clientUserEmail"=>"info@iran-tech.com"
            ];

            $executePreReserveParent=parent::busPreReserve($factorNumber,$preReserveRequired);

            $Model->setTable('book_bus_tb');
            $dataUpdateBook['ClientTraceNumber']=$executePreReserveParent['response']['data']['reserveRequestId'];
            $condition="order_code='".$dataDetailBusTicket['detailBus']["requestNumber"]."'";

            $resultInsert[]=$Model->update($dataUpdateBook,$condition);

            $ModelBase->setTable('report_bus_tb');
            $dataInsertBook['client_id']=CLIENT_ID;
            $resultInsert[]=$ModelBase->update($dataUpdateBook,$condition);

        }else{
            //$this->error = true;
        }

        $passengerController=Load::controller('passengers');
        if($this->isLogin){
            $passengerAddArray=array(
                'passengerName'=>$dataInsertBook['passenger_name'],
                'passengerNameEn'=>$dataInsertBook['passenger_name_en'],
                'passengerFamily'=>$dataInsertBook['passenger_family'],
                'passengerFamilyEn'=>$dataInsertBook['passenger_family_en'],
                'passengerGender'=>$dataInsertBook['passenger_gender'],
                'passengerBirthday'=>$dataInsertBook['passenger_birthday'],
                'passengerNationalCode'=>$dataInsertBook['passenger_national_code'],
                'passengerBirthdayEn'=>$dataInsertBook['passenger_birthday'],
                'passengerPassportCountry'=>$dataInsertBook['passportCountry'],
                'passengerPassportNumber'=>$dataInsertBook['passportNumber'],
                'passengerPassportExpire'=>$dataInsertBook['passportExpire'],
                'memberID'=>$idMember,
                'passengerNationality'=>''
            );
            $passengerController->insert($passengerAddArray);
        }

        $dataInsertBook['passenger_gender']=$param['gender1'];
        $dataInsertBook['passenger_name']=$param['nameFa1'];
        $dataInsertBook['passenger_family']=$param['familyFa1'];
        $dataInsertBook['passenger_national_code']=$param['NationalCode1'];
        $dataInsertBook['passenger_chairs']= $expChairNumberReserve[0];
        $dataInsertBook['passenger_birthday']=(isset($param['birthday1']) && $param['birthday1']!='') ? $param['birthday1'] : $param['birthdayEn1'];

        $this->bookBusTicket=$dataInsertBook;
        $this->bookBusTicket['detailBusTicket']=$dataDetailBusTicket['detailBus'];
        $this->bookBusTicket['detailBusTicket']['date']=$dataDetailBusTicket['date'];
        $this->bookBusTicket['countChairReserve']=$param['countChairReserve'];
        $this->bookBusTicket['chairNumberReserve']=$param['chairNumberReserve'];
        $this->bookBusTicket['chairNumberReserveArray']=$expChairNumberReserve;
        $this->bookBusTicket['passengerArray']=$passenger_list;
        $this->bookBusTicket['price_api']=$this->bookBusTicket['price_api'];
        $this->bookBusTicket['paymentPrice']=$this->bookBusTicket['total_price'];

    }

    public function CreditCustomer ()
    {
        $Model = Load::library ('Model');

        if ($this->IsLogin) {

            Load::autoload ('Model');
            $creditModel = new Model();
            $SqlMember = "SELECT * FROM members_tb WHERE id='{$_SESSION["userId"]}'";

            $member = $Model->load ($SqlMember);

            $agencyID = $member['fk_agency_id'];

            $sql_charge = "SELECT sum(credit) AS total_charge FROM credit_detail_tb WHERE type='increase' AND fk_agency_id='{$agencyID}'";
            $charge = $creditModel->load ($sql_charge);
            $total_charge = $charge['total_charge'];

            $sql_buy = "SELECT sum(credit) AS total_buy FROM credit_detail_tb WHERE type='decrease' AND fk_agency_id='{$agencyID}'";
            $buy = $creditModel->load ($sql_buy);
            $total_buy = $buy['total_buy'];

            $total_transaction = $total_charge - $total_buy;
            return $total_transaction;
        }
    }
}


