<?php
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
/**
 * Class insurance
 * @property insurance $insurance
 */
class insurance extends clientAuth {


    #region getSourceInfo
    /**
     * This function initializes base information of specified insurance webservice
     * @param $insuranceSource string: one of insurance webservices can be pasargad or saman
     * @return object instance of specified insurance webservice informations
     */
    public function getSourceInfo($insuranceSource) {

        $clientAuth = Load::library('clientAuth');
        $sourceInfo = $clientAuth->insurancePortalAuth($insuranceSource);

        $insuranceObj = Load::library($insuranceSource . 'Insurance');
        $insuranceObj->init($sourceInfo);

        return $insuranceObj;

    }
    #endregion

    public function markupData($counter_id) {
        $data= $this->getController('insurancePriceChanges')
        ->getByCounter($counter_id);
        return [
            'is_percentage'=> $data['changeType'] == 'percent',
            'value'=>$data['price'],
        ];
    }


    public function calculatePrice($price, $markup_data, $discount_data)
    {

        if ($markup_data['value'] > 0) {


            if ($discount_data['value'] > 0) {
                if ($markup_data['is_percentage']) {
                    $increase_markup_value = (($price * $markup_data['value']) / 100);
                    $discount_price=(($increase_markup_value * $discount_data['value']) / 100);
                    return $price + ($increase_markup_value - $discount_price);
                }

                $increase_markup_value = $markup_data['value'];

                return $price + ($increase_markup_value - (($increase_markup_value * $discount_data['value']) / 100));
                // 10000 + (((10000 * 5)/100) - ((200 *2)/100)) ===> افزایش قیمت درصدی

                //// 10000 + (((10000 +500) - ((500 *2)/100)) ===>افزایش قیمت ریالی
            }
            if ($markup_data['is_percentage']) {
                $increase_markup_value = (($price * $markup_data['value']) / 100);

                return $price + $increase_markup_value;
            }
            $increase_markup_value = $markup_data['value'];

            return $price + $increase_markup_value;

        }
        return $price;
    }

    public function priceCalculateInformation()
    {
        $counter_id=$this->getController('counterType')->getCounterType();
        $markup_data=$this->markupData($counter_id);
        $discount_data=$this->discountData($counter_id,$markup_data);
        return [
            'markup_data'=>$markup_data,
            'discount_data'=>$discount_data
        ];
    }

    #region searchResult
    public function searchResult() {
        $clientAuth = Load::library('clientAuth');
        $sourceInfo = $clientAuth->insurancePortalAuth();

        $birthDate = unserialize(INSURANCE_BIRTH_DATE);

//            var_dump($birthDate);
//            die;

        $i = 0;
        $counter_id=$this->getController('counterType')->getCounterType();
        $markup_data=$this->markupData($counter_id);
        $discount_data=$this->discountData($counter_id,$markup_data);


        $output = [
            'data'=>[],
            'markup_data'=>$markup_data,
            'discount_data'=>$discount_data
        ];



        foreach ($sourceInfo as $eachSource){

            $insuranceObj = Load::library($eachSource['SourceName'] . 'Insurance');
            $insuranceObj->init($eachSource);
            $country = $this->getWebServiceCountryByIata(INSURANCE_DESTINATION, $eachSource['SourceId']);
            $originCountry = '' ;
            if(!empty(INSURANCE_ORIGIN)) {
            $originCountry = $this->getWebServiceCountryByIata(INSURANCE_ORIGIN, $eachSource['SourceId']);
            }

            if($country['api_code']) {
                $input = array(
                    'countryID' => $country['api_code'],
                    'originCountryID' => $originCountry['api_code'],
                    'duration' => INSURANCE_NUM_DAY,
                    'birthDate' => $birthDate
                );

                $result = $insuranceObj->getInsuranceList($input);

                if (!empty($result)) {
                    foreach ($result as $key => $item) {

                        $output['data'][$i++] = $item;

                    }
                }
            }

        }


        return $output;

    }
    #endregion

    public function discountData($counter_id,$markup_data) {
        return [
            'value'=>functions::ServiceDiscount($counter_id,'PublicPortalInsurance')['off_percent'],
            'can_discount'=> $markup_data['value'] > 0
        ];

    }
    /**
     * @param $markup_value
     * @param $off_percent
     * @return float
     */
    /*public function calculateDiscountedMarkup($markup_data, $discount_value){
        if ($markup_data['is_percentage']) {
            return $markup_data['value']+($markup_data['value'] * ( $discount_value / 100 ));
        }
        return $price + $markup_data['value'];
//        return round($markup_value - (($markup_value * $off_percent) / 100));
    }*/

    public function calculateMarkupPrice($price, $markup_data){
        if ($markup_data['is_percentage']) {
            return $price+($price * ( $markup_data['value'] / 100 ));
        }
        return $price + $markup_data['value'];
    }


    #region getPlanPrice
    public function getPlanPrice($insuranceSource, $countryIata, $zoneCode, $duration, $birthday) {

        $insuranceObj = $this->getSourceInfo($insuranceSource);
        $country = $this->getWebServiceCountryByIata($countryIata, $insuranceObj->sourceID);

        $data = array(
            'countryID' => $country['api_code'],
            'zoneCode' => $zoneCode,
            'duration' => $duration,
            'birthDate' => $birthday
        );


       return $insuranceObj->getInsurancePrice($data);
    }
    #endregion

    #region preReservePlan
    public function preReservePlan($factorNumber) {

        $successFlag = [];
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $queryBook = "SELECT * FROM book_insurance_tb WHERE factor_number = '{$factorNumber}'";
        $resultBook = $Model->select($queryBook);

        $insuranceObj = $this->getSourceInfo($resultBook[0]['source_name']);
        $country = $this->getWebServiceCountryByIata($resultBook[0]['destination_iata'], $insuranceObj->sourceID);
        $originCountry = $this->getWebServiceCountryByIata($resultBook[0]['origin_iata'], $insuranceObj->sourceID);

        foreach ($resultBook as $each) {

            // bana be darkhast aghaye afshar az tarikh 4 azar 1403 shomare erali be bime shomare agency bashe na khardar
            $data = array(
                'factorNumber' => $factorNumber,
                'nationalCode' => isset($each['passenger_national_code'])&& !empty($each['passenger_national_code']) ? $each['passenger_national_code'] : $each['passport_number']  ,
                'isIranian' => isset($each['passenger_national_code']) && !empty($each['passenger_national_code']) ? 1 : 0,
                'firstName' => $each['passenger_name'],
                'lastName' => $each['passenger_family'],
                'latinFirstName' => $each['passenger_name_en'],
                'latinLastName' => $each['passenger_family_en'],
                'birthDate' => $each['passenger_birth_date'],
                'gregorianBirthDate' => $each['passenger_birth_date_en'],
                'passportNo' => $each['passport_number'],
                'gender' => $insuranceObj->getGender($each['passenger_gender']),
                'mobile' => CLIENT_MOBILE,
                'email' => $each['email_buyer'],
                'countryID' => $country['api_code'],
                'originCountryID' => $originCountry['api_code'],
                'zoneCode' => $each['zone_code'],
                'visaType' => $insuranceObj->getVisaType($each['visa_type']),
                'duration' => $each['duration']
            );
            $result = $insuranceObj->preReserveInsurance($data);


            if($result['status']){

                $successFlag['status'] = "TRUE" ;

                $dataUpdate['pnr'] = $result['insuranceCode'];
                $dataUpdate['status'] = 'prereserve';
                $Condition = "factor_number='{$factorNumber}' AND passenger_national_code='{$each['passenger_national_code']}'";
                $Model->setTable('book_insurance_tb');
                $resultUpdate = $Model->update($dataUpdate, $Condition);

                if($resultUpdate){
                    $ModelBase->setTable('report_insurance_tb');
                    $ModelBase->update($dataUpdate, $Condition);
                }

                if(functions::checkClientConfigurationAccess('insurance_private_port') && isset($result['redirectUrl'])){
                    $successFlag['redirectUrl'] = $result['redirectUrl'];
                }


            }else{
                $successFlag['status'] = 'FALSE';


            }

        }

        return json_encode($successFlag);

    }
    #endregion

    #region confirmReservePlan
    public function confirmReservePlan($record) {

        $insuranceObj = $this->getSourceInfo($record['source_name']);
        $country = $this->getWebServiceCountryByIata($record['destination_iata'], $insuranceObj->sourceID);

        $data = array(
            'factorNumber' => $record['factor_number'],
            'nationalCode' => $record['passenger_national_code'],
            'firstName' => $record['passenger_name'],
            'lastName' => $record['passenger_family'],
            'latinFirstName' => $record['passenger_name_en'],
            'latinLastName' => $record['passenger_family_en'],
            'birthDate' => $record['passenger_birth_date'],
            'gregorianBirthDate' => $record['passenger_birth_date_en'],
            'passportNo' => $record['passport_number'],
            'gender' => $insuranceObj->getGender($record['passenger_gender']),
            'mobile' => $record['mobile_buyer'],
            'email' => $record['email_buyer'],
            'countryID' => $country['api_code'],
            'zoneCode' => $record['zone_code'],
            'visaType' => $insuranceObj->getVisaType($record['visa_type']),
            'duration' => $record['duration'],
            'insuranceCode' => $record['pnr']
        );

        $result = $insuranceObj->confirmReserveInsurance($data);
        return $result;

    }
    #endregion

    #region getReservePdf
    public function getReservePdf($insuranceSource, $insuranceCode) {

        $insuranceObj = $this->getSourceInfo($insuranceSource);

        return $insuranceObj->getInsurancePDF($insuranceCode);

    }
    #endregion

    #region getWebServiceCountryByIata
    public function getWebServiceCountryByIata($countryIata, $insuranceSourceID) {

        $ModelBase = Load::library('ModelBase');
        $sql_query ="SELECT * FROM insurance_country_tb WHERE abbr = '{$countryIata}' AND source_id = '{$insuranceSourceID}'";
        return $ModelBase->load($sql_query);

    }
    #endregion

    #region getAllCountry
    public function getAllCountry(){

        return $this->getController('insuranceCountry')->AllCountryInsurance();

    }
    #endregion

    #region getInsuranceName
    public function getInsuranceName($insuranceSource) {

        $ModelBase = Load::library('ModelBase');
        $query = "SELECT Title FROM client_source_tb WHERE SourceName = '{$insuranceSource}'";
        $api = $ModelBase->load($query);
        return $api['Title'];

    }
    #endregion

    #region saveSelectedPlan
    public function saveSelectedPlan($input){

        $insuranceObj = $this->getSourceInfo($input['insurance_api']);
        $country = $this->getWebServiceCountryByIata($input['destination'], $insuranceObj->sourceID);
        $origin_country = $this->getWebServiceCountryByIata($input['origin'], $insuranceObj->sourceID);

        $data['uniq_id'] = functions::generateHashCode();
        $data['insurance_zonecode'] = $input['zone_code'];
        $data['destination'] = $country['persian_name'];
        $data['origin'] = $origin_country['persian_name'];
        $data['destinationIata'] = $input['destination'];
        $data['originIata'] = $input['origin'];
        $data['insurance_type'] = $input['type'];
        $data['insurance_price'] = $input['price'];
        $data['insurance_caption'] = $input['title'];
        $data['num_day'] = $input['num_day'];
        $data['member_count'] = $input['member'];
        $data['CurrencyCode'] = $input['CurrencyCode'];

        $birth_array = unserialize($input['birth_dates']);
        foreach($birth_array as $key => $birth){
            $i = $key + 1;
            $data['birth_date_'.$i] = $birth;
        }

        $data['register_date'] = date('Y-m-d H:i:s');
        $data['insurance_api'] = $input['insurance_api'];

        $Model = Load::library('Model');
        $Model->setTable('temporary_insurance_tb');
        $result = $Model->insertLocal($data);

        if($result){
            echo $data['uniq_id'];
        }

    }
    #endregion

    #region serviceTypeCheck
    public function serviceTypeCheck($insuranceSource)
    {
        $insuranceObj = $this->getSourceInfo($insuranceSource);

        if ($insuranceObj->publicPrivate == 'public') {
            return 'PublicPortalInsurance';
        } elseif ($insuranceObj->publicPrivate == 'private') {
            return 'PrivateLocalInsurance';
        }

    }
    #endregion

    #region getAgencyCommission
    public function getAgencyCommission($insuranceSource, $base, $commission) {

        $insuranceObj = $this->getSourceInfo($insuranceSource);
        $data = array(
            'basePrice' => $base,
            'commission' => $commission
        );
        return $insuranceObj->calculateAgencyCommission($data);

    }
    #endregion

    #region getTotalPriceByFactorNumber
    public function getTotalPriceByFactorNumber($factorNumber) {

        $Model = Load::library('Model');

        $sql_query ="SELECT 
                            SUM(paid_price) AS totalPrice,
                            SUM(base_price+tax) AS totalPriceIncreased,
                            SUM(agency_commission) AS totalAgencyCommission,
                            SUM(irantech_commission) AS irantech_commission
                    FROM book_insurance_tb WHERE factor_number = '{$factorNumber}' ";


        return $Model->load($sql_query);
    }
    #endregion

    #region checkApiCredit
    public function checkApiCredit($insuranceSource)
    {
        $insuranceObj = $this->getSourceInfo($insuranceSource);
        $result = $insuranceObj->getCredit();

        if($result['status'] && $result['credit'] < 10000000)
        {
            $smsController = Load::controller('smsServices');
            if($insuranceObj->publicPrivate == 'private')
            {
                //sms to site manager
                $objSms = $smsController->initService('0');
                if($objSms) {
                    $sms = "مدیریت محترم آژانس" . " " . CLIENT_NAME . PHP_EOL . " شارژ حساب کاربری شما در پنل " . $insuranceObj->sourceTitle . " به کمتر از 10,000,000 ریال رسیده است";
                    $smsArray = array(
                        'smsMessage' => $sms,
                        'cellNumber' => CLIENT_MOBILE
                    );
                    $smsController->sendSMS($smsArray);
                }

            } else{
                //sms to Mr afraze
                $objSms = $smsController->initService('1');
                if($objSms) {
                    $sms = "میزان شارژ در حساب کاربری " . $insuranceObj->sourceTitle . " به کمتر از 10,000,000 ریال رسیده است";
                    $smsArray = array(
                        'smsMessage' => $sms,
                        'cellNumber' => '09057078341'
                    );
                    $smsController->sendSMS($smsArray);
                }
            }
        }
    }
    #endregion

    #region setPriceChanges
    public static function setPriceChanges($Price) {
        $IsLogin = Session::IsLogin();
        $counterTypeId = ($IsLogin) ? Session::getCounterTypeId() : '5';
        $Discount=functions::ServiceDiscount($counterTypeId,'PublicPortalInsurance');
        if ($Discount['off_percent'] > 0) {

            $Price = round(($Price * $Discount['off_percent'] / 100));
        }else{
            $Price = 0;

        }

        return $Price;

    }
    #endregion

    #region getReportInsuranceAgency
    public function getReportInsuranceAgency($agencyId)
    {
	    /** @var bookInsuranceModel $bookInsuranceModel */
	    $bookInsuranceModel = Load::getModel('bookInsuranceModel');
        return $bookInsuranceModel->getReportInsuranceAgency($agencyId);
    }
    #endRegion

    /**
     * @throws Exception
     */
    public function getInsuranceRoutes($params)
    {

        $insurance_routes=$this->getModel('insuranceCountryModel')
            ->get();

        $insurance_routes=$insurance_routes->where('abbr','','!=');

        if ($params['value']) {
            $insurance_routes=$insurance_routes->where('abbr','%'.$params['value'].'%','like');
            $insurance_routes=$insurance_routes->orwhere('persian_name','%'.$params['value'].'%','like');
        }

        $insurance_routes=$insurance_routes->groupBy('abbr');
        $insurance_routes=$insurance_routes->orderBy('persian_name','asc');



        $limit = '20';
        if ($params['limit']) {
            $limit = $params['limit'];
        }
        $insurance_routes=$insurance_routes->limit(0, $limit);

        $insurance_routes=$insurance_routes->all();



        return $insurance_routes;
    }

    public function ReserveByBankSamanInsurance($params)
    {

        $Model = Load::library('Model');
        $queryBook = "SELECT * FROM book_insurance_tb WHERE factor_number = '{$params['factorNumber']}'";
        $book = $Model->select($queryBook);

        if (!empty($book[0]) && $book[0]['status'] != "book" && $book[0]['source_name'] == 'saman') {

            header("Location:". $params['redirectUrl']);
        }
    }
}