<?php
/**
 * Created by PhpStorm.
 * User: Fani
 * Date: 10/1/2018
 * Time: 5:39 PM
 */

ini_set('default_socket_timeout', 1200);
/**
 * Class samanInsurance
 * @property samanInsurance $samanInsurance
 */
class samanInsurance extends insuranceAbstract {

    #region variables
    private $apiLink;
    private $apiData;
    private $apiSoap;
    #endregion

    #region init
    /**
     * This function initializes webservice requirements
     * @author Naime Barati
     */
    public function init($sourceInfo){

        $this->username = $sourceInfo['Username'];
        $this->password = $sourceInfo['Password'];
        $this->sourceID = $sourceInfo['SourceId'];
        $this->sourceType = $sourceInfo['SourceName'];
        $this->sourceTitle = $sourceInfo['Title'];
        $this->publicPrivate = ($sourceInfo['Username'] == 'WS1@IrantechnologyNoyanCoreWS' ? 'public' : 'private');

        $this->apiLink = 'https://samanws.travis.ir/travisservice.asmx?wsdl';

//        $this->username = 'WS1@IrantechnologyNoyanCoreWS';
//        $this->password = 'Te@cn@0607!!';


        ini_set("default_socket_timeout", 15);
        $this->apiSoap = new SoapClient($this->apiLink);

    }
    #endregion

    #region getInsuranceList
    public function getInsuranceList($input){

        if (!file_exists(LOGS_DIR . 'insurance')) {
            mkdir(LOGS_DIR . 'insurance', 0777, true);
        }
        $j = 0;
        $output = array();
        foreach ($input['birthDate'] as $birthDate){
//           echo  $ConvertedBirthDate =functions::ConvertDateByLanguage(SOFTWARE_LANG,$birthDate,'-','Jalali',false);

            if($input['countryID'] != '1' ) {
                $gregorianBirthDate = functions::ConvertToMiladi($birthDate);
            }else{
                $gregorianBirthDate = $birthDate;
            }



            $this->apiData = array(
                'username' => $this->username,
                'password' => $this->password,
                'countryCode' => $input['countryID'],
                'sourceCountryCode' => $input['originCountryID'],
                'birthDate' =>  $gregorianBirthDate.'T00:00:00',
                'durationOfStay' => $input['duration']
            );

            try{


                $result = $this->convertToArray($this->apiSoap->getPlansWithDetail($this->apiData));




//                functions::insertLog('getPlansWithDetail Req' . json_encode($this->apiData), 'log_insurance_reserve');
//                functions::insertLog('getPlansWithDetail Res' . json_encode($result,256|64), 'log_insurance_reserve');
                functions::insertLog('getPlansWithDetail Request => ' . json_encode($this->apiData), 'insurance/getPlansWithDetail_log');
                functions::insertLog('getPlansWithDetail Result => ' . json_encode($result,256|64), 'insurance/getPlansWithDetail_log');
//            echo '<pre>'.print_r($result,true).'</pre>';

                if (isset($result['getPlansWithDetailResult']['TISPlanInfo']) && $result['getPlansWithDetailResult']['TISPlanInfo']) {

                    //just one output
                    if (isset($result['getPlansWithDetailResult']['TISPlanInfo']['errorCode']) && $result['getPlansWithDetailResult']['TISPlanInfo']['errorCode'] == '-1') {
                        $resultData = array($result['getPlansWithDetailResult']['TISPlanInfo']);
                    } else { //more than one output
                        $resultData = $result['getPlansWithDetailResult']['TISPlanInfo'];
                    }

                    $i = 0;
                    foreach ($resultData as $each){

                        $priceInput = array(
                            'countryID' => $input['countryID'],
                            'zoneCode' => $each['code'],
                            'duration' => $input['duration'],
                            'birthDate' => $birthDate
                        );

                        $resultPrice = $this->getInsurancePrice($priceInput);

                        if(!empty($resultPrice) && $resultPrice['totalPrice'] > 0){

                            $output[$i]['passengers'][$j]['type'] = functions::type_passengers($gregorianBirthDate);
                            $output[$i]['passengers'][$j]['price'] = $resultPrice['totalPrice'];

                            $output[$i]['source_type'] = $this->sourceType;
                            $output[$i]['source_title'] = $this->sourceTitle;
                            $output[$i]['plan_zone_code'] = $each['code'];
                            $output[$i]['plan_fa_title'] = $each['title'];
                            $output[$i]['plan_en_title'] = $each['titleEnglish'];
                            $output[$i]['covers'] = $each['covers']['TISPlanCoversInfo'];

                            $i++;
                        }
                    }
                }

                $j++;
            }catch(Exception $e)
            {
//                echo Load::plog($e->getMessage());
            }

        }


        if(!empty($output)){
            return $output;
        }


        return false;
    }
    #endregion

    #region getInsurancePrice
    public function getInsurancePrice($input){
//        $birthDate =functions::ConvertDateByLanguage(SOFTWARE_LANG,$input['birthDate'],'-','Miladi',true);
       if($input['countryID'] != '1') {
           $birthDate = functions::ConvertToMiladi($input['birthDate']);
       }else{
           $birthDate = $input['birthDate'];
       }

        $this->apiData = array(
            'username' => $this->username,
            'password' => $this->password,
            'countryCode' => $input['countryID'],
            'birthDate' => $birthDate . 'T00:00:00',
            'durationOfStay' => $input['duration'],
            'planCode' => $input['zoneCode'],
        );
        $result = $this->convertToArray($this->apiSoap->getPriceInquiry($this->apiData));
//        functions::insertLog('getPriceInquiry Req' . json_encode($this->apiData), 'log_insurance_soap');
//        functions::insertLog('getPriceInquiry Res' . json_encode($result,256|64), 'log_insurance_soap');
        functions::insertLog('getPriceInquiry Request => ' . json_encode($this->apiData), 'insurance/getPriceInquiry_log');
        functions::insertLog('getPriceInquiry Result => ' . json_encode($result,256|64), 'insurance/getPriceInquiry_log');
        if ($result['getPriceInquiryResult']){

            $output = array(
                'basePrice' => $result['getPriceInquiryResult']['priceGross'],
                'taxPrice' => $result['getPriceInquiryResult']['priceTax'] + $result['getPriceInquiryResult']['priceAvarez'],
                'totalPrice' => $result['getPriceInquiryResult']['priceTotal'],
                'commission' => 0
            );

            return $output;
        }

        return false;
    }
    #endregion

    #region preReserveInsurance
    public function preReserveInsurance($input){

        $data['nationalCode'] = $input['nationalCode'];
        $data['isIrannian'] = $input['isIranian'] == 1 ? true : false ;
        $data['firstName'] = $input['firstName'] ?$input['firstName'] :  $input['latinFirstName'];
        $data['lastName'] = $input['lastName'] ?  $input['lastName'] : $input['latinLastName'];
        $data['latinFirstName'] = $input['latinFirstName'];
        $data['latinLastName'] = $input['latinLastName'];
        $data['birthDate'] = $input['gregorianBirthDate'] . 'T00:00:00';
        $data['persianBirthDate'] = $input['birthDate'];
        $data['passportNo'] = $input['passportNo'];
        $data['mobile'] = $input['mobile'];
        $data['email'] = $input['email'];
        $data['gender'] = $input['gender'];
        $data['countryCode'] = $input['countryID'];
        $data['destinationCountryCode'] = $input['countryID'];
        $data['originCountryCode'] = $input['originCountryID'];
        $data['durationOfStay'] = $input['duration'];
        $data['travelKind'] = $input['visaType'];
        $data['planCode'] = $input['zoneCode'];
        $data['redire'] = $input['zoneCode'];

        $this->apiData = array(
            'username' => $this->username,
            'password' => $this->password,
            'insuranceData' => $data
        );
        if($input['countryID'] != '1' && $input['isIranian'] == '1') {
            $result = $this->convertToArray($this->apiSoap->registerInsurance($this->apiData));
           
            if (strval($result['registerInsuranceResult']['errorCode']) == '-1') {
                $return['status'] = true;
                $return['insuranceCode'] = $result['registerInsuranceResult']['bimehNo'];
                if(isset($result['registerInsuranceResult']['RedirectUrl'])) {
                    $return['redirectUrl'] = $result['registerInsuranceResult']['RedirectUrl'];
                }
            } else{
                $return['status'] = false;
            }
            functions::insertLog('registerInsurance Response => '.json_encode($result['registerInsuranceResult']['errorText'],256|64),'insurance/registerInsurance_log');
        }
        else{
        
            $result = $this->convertToArray($this->apiSoap->registerInsuranceIO($this->apiData));
     
            if (strval($result['registerInsuranceIOResult']['errorCode']) == '-1') {
                $return['status'] = true;

                $return['insuranceCode'] = $result['registerInsuranceIOResult']['bimehNo'];
                if(isset($result['registerInsuranceIOResult']['RedirectUrl'])) {
                    $return['redirectUrl'] = $result['registerInsuranceIOResult']['RedirectUrl'];
                }

            } else{
                $return['status'] = false;
            }
            functions::insertLog('registerInsurance Response => '.json_encode($result['registerInsuranceIOResult']['errorText'],256|64),'insurance/registerInsurance_log');

        }
//        functions::insertLog('registerInsurance Req' . json_encode($this->apiData), 'log_insurance_prereserve');
//        functions::insertLog('registerInsurance Res' . json_encode($result), 'log_insurance_prereserve');
//        functions::insertLog('registerInsurance Res' . $result['registerInsuranceResult']['errorText'], 'log_insurance_prereserve');
//        functions::insertLog('request with factor number ' . $input['factorNumber'] . ' : ' . json_encode($this->apiData), 'log_insurance_prereserve');
//        functions::insertLog('response with factor number ' . $input['factorNumber'] . ' : ' . json_encode($result,256|64), 'log_insurance_prereserve');
        functions::insertLog('registerInsurance Request => '.json_encode($this->apiData,256|64),'insurance/registerInsurance_log');
        functions::insertLog('registerInsurance Response => '.json_encode($result,256|64),'insurance/registerInsurance_log');



        return $return;
    }
    #endregion
    #region getCountries
    public function getCountries(){
     
        $this->apiData = array(
            'username' => $this->username,
            'password' => $this->password
        );
        $result = $this->convertToArray($this->apiSoap->getCountries($this->apiData));
//        functions::insertLog('registerInsurance Req' . json_encode($this->apiData), 'log_insurance_prereserve');
//        functions::insertLog('registerInsurance Res' . json_encode($result), 'log_insurance_prereserve');
//        functions::insertLog('registerInsurance Res' . $result['registerInsuranceResult']['errorText'], 'log_insurance_prereserve');
//        functions::insertLog('request with factor number ' . $input['factorNumber'] . ' : ' . json_encode($this->apiData), 'log_insurance_prereserve');
//        functions::insertLog('response with factor number ' . $input['factorNumber'] . ' : ' . json_encode($result,256|64), 'log_insurance_prereserve');
//        functions::insertLog('registerInsurance Request => '.json_encode($this->apiData,256|64),'insurance/registerInsurance_log');
//        functions::insertLog('registerInsurance Response => '.json_encode($result,256|64),'insurance/registerInsurance_log');
//        functions::insertLog('registerInsurance Response => '.json_encode($result['registerInsuranceResult']['errorText'],256|64),'insurance/registerInsurance_log');
        if (strval($result['registerInsuranceResult']['errorCode']) == '-1') {
            $return['status'] = true;
            $return['insuranceCode'] = $result['registerInsuranceResult']['bimehNo'];
            if(isset($result['registerInsuranceResult']['RedirectUrl'])) {
                $return['redirectUrl'] = $result['registerInsuranceResult']['RedirectUrl'];
            }
        } else{
            $return['status'] = false;
        }

        return $return;
    }
    #endregion

    #region confirmReserveInsurance
    public function confirmReserveInsurance($input){

//        functions::insertLog('confirmInsurance Input ' . json_encode($input), 'log_insurance_reserve');
        functions::insertLog('confirmInsurance Input => ' . json_encode($input), 'insurance/confirmInsurance_log');
//        $input['insuranceCode'] = '1401/160-160/241/90470112';
        $this->apiData = array(
            'username' => $this->username,
            'password' => $this->password,
            'bimehNo' => $input['insuranceCode']
        );

        $result = $this->convertToArray($this->apiSoap->confirmInsurance($this->apiData));
//        functions::insertLog('confirmInsurance Req' . json_encode($this->apiData), 'log_insurance_reserve');
//        functions::insertLog('confirmInsurance Res' . json_encode($result,256|64), 'log_insurance_reserve');
        functions::insertLog('confirmInsurance Request => ' . json_encode($this->apiData), 'insurance/confirmInsurance_log');
        functions::insertLog('confirmInsurance Result => ' . json_encode($result,256|64), 'insurance/confirmInsurance_log');
//        functions::insertLog('request with factor number ' . $input['factorNumber'] . ' : ' . json_encode($this->apiData), 'log_insurance_reserve');
//        functions::insertLog('response with factor number ' . $input['factorNumber'] . ' : ' . json_encode($result,256|64), 'log_insurance_reserve');

        if ($result['confirmInsuranceResult']['errorCode'] == -1) {

            $output = array(
                'status' => true,
                'insuranceCode' => $result['confirmInsuranceResult']['bimehNo']
            );

        } else {
            $output = array(
                'status' => false,
                'errorMessage' => $result['confirmInsuranceResult']['errorText']
            );
        }

        return $output;
    }
    #endregion

    #region getInsurancePDF
    public function getInsurancePDF($insuranceCode){
    
//        return ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=samanInsurance&id=' . $insuranceCode;
        $this->username = 'WS1@IrantechnologyNoyanCoreWS';
        $this->password = 'Te@cn@0607!!';

        $this->apiLink = 'https://samanws.travis.ir/travisservice.asmx?wsdl';

//        $this->username = 'WS1@IrantechnologyNoyanCoreWS';
//        $this->password = 'Te@cn@0607!!';

        functions::insertLog('insurance result => '  . $insuranceCode,'insurance/pdf_log');
        ini_set("default_socket_timeout", 15);
        $this->apiSoap = new SoapClient($this->apiLink);




        $clientAuthModel = Load::library('clientAuth');
        $accessesClientInsurance = $clientAuthModel->insurancePortalAuth(str_replace('Insurance','',$_GET['target']))[0];
        $this->apiData = array(
            'username' => $accessesClientInsurance['Username'],
            'password' => $accessesClientInsurance['Password'],
            'serialNo' => $insuranceCode
        );


        functions::insertLog('accesses result => '  . json_encode($accessesClientInsurance),'insurance/pdf_log');

        $pdf_url=$this->convertToArray($this->apiSoap->getInsurancePrintInfo($this->apiData))['getInsurancePrintInfoResult']['pdfPolicy'];

        functions::insertLog('pdf url result => '  . $pdf_url,'insurance/pdf_log');

        return $pdf_url;
        header("Location: $pdf_url");
        exit();
//        $result = $this->convertToArray($this->apiSoap->getInsurancePrintInfo($this->apiData));
//
//
//        if ($result['getInsurancePrintInfoResult']['errorCode'] == -1) {
//            return $result['getInsurancePrintInfoResult']['pdfPolicy'];
//        }
//
//        return $result['getInsurancePrintInfoResult']['errorText'];
    }
    #endregion

    #region createPdfContent
    public function createPdfContent($insuranceCode){
        return $this->getInsurancePDF($insuranceCode);

        /** @var insurance $insurance */
        $insurance = Load::controller('insurance');
        $insuranceObj = $insurance->getSourceInfo('saman');


      

        $this->apiData = array(
            'username' => $insuranceObj->username,
            'password' => $insuranceObj->password,
            'serialNo' => $insuranceCode
        );
        $get_insurance = $insuranceObj->apiSoap->getInsurance($this->apiData);
        functions::insertLog('getInsurance request => '.json_encode($this->apiData,256|64),'insurance/getInsurance_log');
        functions::insertLog('getInsurance result => '.json_encode($get_insurance,256|64),'insurance/getInsurance_log');
        $result = $this->convertToArray($get_insurance);



//        $result_print = $this->convertToArray($this->apiSoap->getInsurancePrintInfo($this->apiData));
        functions::insertLog('this is request print pdf insurance ==>'.json_encode($this->apiData,256|64).'  && result is ===>'. json_encode($result),'log_insurance_print_pdf_insurance');

//        $sqlBook = "SELECT * FROM book_insurance_tb WHERE ";
        if ( TYPE_ADMIN == '1' ) {
            $ModelBase     = Load::library( 'ModelBase' );
            $sql           = "SELECT * FROM report_insurance_tb WHERE pnr='{$insuranceCode}'";
            $insuranceBook = $ModelBase->load( $sql );
        } else {
            $Model         = Load::library( 'Model' );
            $sql           = "SELECT * FROM book_insurance_tb WHERE pnr='{$insuranceCode}'";
            $insuranceBook = $Model->load( $sql );
        }
//        todo : we have to remove this function from functions.php after check code
//        $insuranceBook = functions::infoInsurance($insuranceCode);
         $changePrice = (($insuranceBook['price_change_type'] == 'percent' ? ($insuranceBook['base_price'] + $insuranceBook['tax']) * ($insuranceBook['price_change'] / 100) : $insuranceBook['price_change']));


        $pdfContent = '';
        if ($result['getInsuranceResult']['errorCode'] == -1) {
            $data = $result['getInsuranceResult'];

            $standard_code=$data['country']['standardCode'];

            $this->apiData = array(
                'username' => $insuranceObj->username,
                'password' => $insuranceObj->password,
                'countryStandardCode' => $standard_code
            );
            $get_country = $insuranceObj->apiSoap->getCountryByStandardCode($this->apiData);

            $country_result = $this->convertToArray($get_country);


            switch ($data['plan']['code']){
                case '1':
                case '8':
                    $email = 'Claims@eurocross.me';
                    $phone = '00420234622768';
                    break;
                case '34':
                    $email = 'saman@mideast-assistance.com';
                    $phone = '+961 (4) 548356';
                    break;
                default:
                    $email = '';
                    $phone = '';
                    break;
            }

            $pdfContent .= '
<!DOCTYPE html>
<html>
    <head>
        <title>بیمه نامه ' . $insuranceCode . '</title>
        <style type="text/css">
            table{
                margin: 10px 100px;
                font: normal 14px/25px Tahoma;
            }
            .page {
                border-collapse: collapse;
                border: 1px solid #555;
            }
            .page td, .page th{
               padding:5px;
               margin:0;
               border-left: 1px solid #555;
               text-align: center;
               vertical-align: top;
            }
            .page td:first-child, .page th:first-child{
                border-left: none;
            }
            .page th{
                font-weight: normal;
                border-bottom: 1px solid #555;
            }
            p{
                font: bold 15px/25px Tahoma;
            }
            .title{
                font: bold 18px/30px Tahoma;
            }
            .borderTop{
                border-top: 1px solid #555;
            }
            .padd li{
                padding-left: 30px;
                padding-right: 30px;
            }
            .rtl{
                direction: rtl;
            }
            .ltr{
                direction: ltr;
            }
            .pageBreak{page-break-before: always;}
        </style>
    </head>
    <body>';

            $pdfContent .= '
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="ltr">
                <tr>
                    <td width="50%" align="left">Policy Serial: '.$data['bimehNo'].'</td>
                    <td width="50%" align="right">شماره سریال بیمه نامه: '.$data['bimehNo'].'</td>
                </tr>
            </table>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="ltr">
                <tr>
                    <td width="33%" align="left"><img src="' . ROOT_ADDRESS_WITHOUT_LANG . '/view/client/assets/images/samanInsuranceEn.png" width="100" height="100" /></td>
                    <td width="34%" align="center" class="title">Saman Travel Insurance</td>
                    <td width="33%" align="right"><img src="' . ROOT_ADDRESS_WITHOUT_LANG . '/view/client/assets/images/samanInsurance.png" width="100" height="100" /></td>
                </tr>
            </table>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page ltr">
                <tr>
                    <td width="34%">Policy No: '.$data['policyNo'].'</td>
                    <td width="33%">Date of Issue: '.substr($data['issueDate'], 0, 10).'</td>
                    <td width="33%">Agency Code: '.$data['agentCode'].'</td>
                </tr>
            </table>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page ltr">
                <tr>
                    <td width="25%">First Name: '.$insuranceBook['passenger_name_en'].'</td>
                    <td width="25%">Surname: '.$insuranceBook['passenger_family_en'].'</td>
                    <td width="25%">Passport No: '.$data['passportNo'].'</td>
                    <td width="25%">DOB: '.substr($data['customer']['birthDate'], 0, 10).'</td>
                </tr>
            </table>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page ltr">
                <tr>
                    <td width="34%">Zone: '.$country_result['getCountryByStandardCodeResult']['zoneTitleEnglish'].'</td>
                    <td width="33%">Duration of Cover: '.$data['durationOfStay'].' days ('. ($data['travelKind'] == '1' ? 'Single' : 'Multi') .' Entry)</td>
                    <td width="33%">Plan Type: '.$data['plan']['titleEnglish'].'</td>
                </tr>
            </table>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page ltr">
                <tr>
                    <th width="50%">Premium</th>
                    <th width="50%">Signature</th>
                </tr>
                <tr>
                    <td width="50%" align="left">
                        <ul>
                            <li>Premium: '.number_format($data['price']['priceGross']).' Rls.</li>
                            <li>Discounts: '.number_format($data['price']['priceDiscount']).' Rls.</li>
                            <li>VAT: '.number_format(($data['price']['priceAvarez'] + $data['price']['priceTax']+$changePrice)).' Rls.</li>
                            <li>Total: '.number_format($data['price']['priceTotal']+$changePrice ).' Rls.</li>
                        </ul>
                    </td>
                    <td width="50%"></td>
                </tr>
            </table>
            
            <p style="height: 15px;"></p>
            
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page ltr">
                <tr>
                    <th colspan="4">
                        <p>شماره مرکز پاسخگوئی 24 ساعته کمک رسان / Assistance Provider 24 hours Call Center</p>
                        <p>در کلیه شرایط اعلام بروز خسارت حداکثر ظرف مدت 10 روز (240 ساعت) به شرکت کمک رسان الزامی می باشد.</p>
                    </th>
                </tr>
                <tr>
                    <td width="15%">Email</td>
                    <td width="35%"><b>' . $email . '</b></td>
                    <td width="15%">Call Center</td>
                    <td width="35%"><b>' . $phone . '</b></td>
                </tr>
            </table>
            
            <p></p>
            
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page rtl">
                <tr>
                    <td width="50%" align="right">کلیه شرایط و ضوابط پوشش های مندرج در این بیمه نامه بر اساس شرایط عمومی پیوست می باشد. مطالعه دفترچه شرایط عمومی به منظور اطلاع از این موارد الزامیست. بر اساس مقررات دفترچه شرایط عمومی بیمه نامه مسافرتی سامان می بایست توسط عامل فروش به همراه این بیمه نامه به شما تحویل شود. شما همچنین می توانید نسخه الکترونیکی شرایط عمومی بیمه نامه مسافرتی سامان را با مراجعه به سایت دریافت کنید www.si24.ir</td>
                    <td width="50%" align="left">The terms and conditions of this policy are according to the insurance policy general conditions. Please read the general conditions of your policy. According to the regulations, the general conditions booklet should be given to you by your agent. You could also download the electronic version of general conditions from www.si24.ir</td>
                </tr>
                <tr>
                    <td width="50%" align="right" class="borderTop">تاریخ شروع بیمه نامه از زمان خروج بیمه شده از مرز های قانونی کشور ایران بوده و نهایت مدت اعتبار آن در خارج از کشور 92 روز متوالی می باشد. در صورت عدم دریافت ویزا تا 6ماه پس از صدور می توانید صرفا با مراجعه به واحد صادر کننده نسبت به فسخ بیمه نامه اقدام نمایید.</td>
                    <td width="50%" align="left" class="borderTop">The policy will be started from the date of official exit from Iran, and its maximum validity is 92 consecutive days.</td>
                </tr>
                <tr>
                    <td width="50%" align="right" class="borderTop">در صورت نیاز به فوریت های پزشکی و سایر خدمات تحت پوشش، بیمه شده و یا همراه وی موظف است با مراکز پاسخگوئی کمک رسان تماس حاصل نموده و اطلاعات زیر را اعلام نماید:
                        <ul class="padd" style="direction: rtl !important;">
                            <li>نام بیمه شده، شماره بیمه نامه و شماره تلفن تماس</li>
                            <li>نوع کمک مورد درخواست و یا مشکلی که با آن مواجه است</li>
                            <li>در صورتی که بیمه شده به هر دلیل موفق به برقراری تماس یا دریافت خدمات از شرکت کمک رسان نگردد، می بایست کلیه مدارک مربوطه به پرونده خود را دریافت نموده و به منظور رسیدگی به دفتر مرکزی شرکت بیمه سامان در تهران (کشور ایران) به نشانی ذیل ارائه نماید</li>
                        </ul>
                    </td>
                    <td width="50%" align="left" class="borderTop">In case of medical emergency, and need for any covered services, the insured or one of his/her companies shall call or send email to "Assistance Provider" and declare the following information:
                        <ul class="padd">
                            <li>Insured’s name, policy number (indicated above), telephone number and contact details</li>
                            <li>Brief description of the problem encountered, and the kind of assistance required.</li>
                            <li>If the insured is not able to contact or get services from assistance provider, he/she should collect all relevant documents and present them to the head office of Saman Insurance Company in Tehran, Iran (below-mentioned address) for any further verification.</li>
                        </ul>
                    </td>
                </tr>
            </table>
            
            <p style="text-align: center; margin: 10px 100px;">THE VALIDITY OF THIS POLICY COULD BE CONTROLED THROUGH THE OFFICIAL TRAVEL INSURANCE PORTAL OF SAMAN INSURANE COMPANY WITH THE FOLLOWING ADDRESS:  www.travis.ir/customers</p>
            <p style="text-align: center; margin: 10px 100px;">کنترل اعتبار این بیمه نامه از طریق سایت رسمی صدور بیمه نامه مسافرتی سامان به نشانی زیر امکان پذیر می باشد <br /> www.travis.ir/customers</p>
            
            <p style="text-align: center; margin: 20px 250px; border: 1px solid #555;">This insurance policy is issued electronically and does not require seals <br /> این بیمه نامه به صورت الکترونیکی صادر می شود و نیازی به مهر ندارد</p>
            
            <div class="pageBreak"></div>
            
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page ltr">
                <tr>
                    <th width="34%" align="left">Covers</th>
                    <th width="33%">سقف تعهدات به یورو</th>
                    <th width="33%" align="right">پوشش ها</th>
                </tr>
            ';

            foreach ($data['plan']['covers']['TISPlanCoversInfo'] as $cover){
                $pdfContent .= '
                    <tr>
                        <td width="34%" align="left" class="borderTop">'.$cover['coverTitleEnglish'].'</td>
                        <td width="33%" class="borderTop">'.$cover['planCoverLimit'].'</td>
                        <td width="33%" align="right" class="borderTop">'.$cover['coverTitle'].'</td>
                    </tr>
                
                ';
            }

            $pdfContent .= '
            </table>

            <p style="text-align: left; margin: 10px 100px;">This policy is subject to the following terms and conditions and attached provisions. It covers the expenses of the insured in the countries outside Iran.</p>
            <p style="text-align: right; margin: 10px 100px;">این بیمه نامه بر اساس شرایط و مقررات پیوست صادره گردیده و هزینه های بیمه شده را که در خارج از کشور به وقوع پیوسته است، جبران می نماید</p>
            
            <p style="text-align: center; margin: 10px 100px;">Saman Insurance Co. address:  123 Khaled Eslamboli Ave. 15138 13119 Tehran, Iran Tel: +98 (21) 8943  Fax: +98 (21) 88700204 Email: travel@samaninsurance.ir</p>
            <p style="text-align: center; margin: 10px 100px;">نشانی شرکت بیمه سامان: تهران – خیابان خالد اسلامبولی (وزراء) شماره 123 تلفن: 8943  نمابر: 88700204</p>
            ';

            return $pdfContent;
        }

        return $result['getInsuranceResult']['errorText'];
    }
    #endregion

    #region getCredit
    public function getCredit(){

        $this->apiData = array(
            'username' => $this->username,
            'password' => $this->password
        );
        $result = $this->convertToArray($this->apiSoap->getCredit($this->apiData));
        functions::insertLog('getCredit Request => ' . json_encode($this->apiData), 'insurance/getCredit_log');
        functions::insertLog('getCredit Result => ' . json_encode($result,256|64), 'insurance/getCredit_log');
//        functions::insertLog('getCredit Req' . json_encode($this->apiData), 'log_insurance_reserve');
//        functions::insertLog('getCredit Res' . json_encode($result,256|64), 'log_insurance_reserve');
        if ($result['getCreditResult']['errorCode'] == -1) {

            $output = array(
                'status' => true,
                'credit' => $result['getCreditResult']['availableCredit']
            );

        } else {
            $output = array(
                'status' => false,
                'errorMessage' => $result['getCreditResult']['errorText']
            );
        }

        return $output;

    }
    #endregion

    #region getVisaType
    /**
     * This function returns type of visa for webservice
     * @param $visa string: single or multiple
     * @return string: 1 for single or 2 for multiple
     * @author Naime Barati
     */
    public function getVisaType($visa){
        return ($visa == 'single' ? '1' : '2');
    }
    #endregion

    #region getGender
    /**
     * This function returns type of gender for webservice
     * @param $gender string: Male or Female
     * @return string: 1 for Male or 2 for Female
     * @author Naime Barati
     */
    public function getGender($gender){
        return ($gender == 'Male' ? '1' : '2');
    }
    #endregion

    #region calculateAgencyCommission
    public function calculateAgencyCommission($input){
        return ($input['basePrice'] * 0.2);
    }
    #endregion

    #region convertToArray
    /**
     * This function convert object type to array
     * @param $object input
     * @return array output
     * @author Naime Barati
     */
    public function convertToArray($object){

        return json_decode(json_encode($object), true);

    }
    #endregion

}