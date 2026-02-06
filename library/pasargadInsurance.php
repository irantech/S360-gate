<?php
/**
 * Created by PhpStorm.
 * User: Fani
 * Date: 9/30/2018
 * Time: 2:19 PM
 */


class pasargadInsurance extends insuranceAbstract {

    #region variables
    private $apiLink;
    private $apiData;
    private $apiToken;
    #endregion

    #region init
    /**
     * This function initializes required parameters and authenticates webservice
     * @author Naime Barati
     */
    public function init($sourceInfo){

        $this->username = $sourceInfo['Username'];
        $this->password = $sourceInfo['Password'];
        $this->sourceID = $sourceInfo['SourceId'];
        $this->sourceType = $sourceInfo['SourceName'];
        $this->sourceTitle = $sourceInfo['Title'];
        $this->publicPrivate = ($sourceInfo['Username'] == 'afshar@iran-tech.com' ? 'public' : 'private');

        $this->apiLink = 'http://www.travelinsure.ir/api/v1.1/authenticate';
        $this->apiData = array(
            'webservice_username' => $this->username,
            'password' => $this->password
        );
        $result = $this->curlExecutionPost($this->apiLink, $this->apiData);

        if (!empty($result)) {
            $this->apiToken = $result['token'];
        }
    }
    #endregion

    #region getInsuranceList
    public function getInsuranceList($input){

        $this->apiLink = 'http://www.travelinsure.ir/api/v1.1/getplan?token=' . $this->apiToken;
        $this->apiData = array(
            'country_id' => $input['countryID']
        );
        $result = $this->curlExecutionPost($this->apiLink, $this->apiData);

        if ($result['success']) {

            $i = 0;
            $output = array();
            foreach ($result['data'] as $each){

                $j = 0;
                foreach ($input['birthDate'] as $birthDate){

                    $priceInput = array(
                        'countryID' => $input['countryID'],
                        'zoneCode' => $each['zone_code'],
                        'duration' => $input['duration'],
                        'birthDate' => $birthDate
                    );
                    $resultPrice = $this->getInsurancePrice($priceInput);

                    if(!empty($resultPrice) && $resultPrice['totalPrice'] > 0){

                        $output[$i]['passengers'][$j]['type'] = functions::type_passengers(functions::ConvertToMiladi($birthDate));
                        $output[$i]['passengers'][$j]['price'] = $resultPrice['totalPrice'];

                        $j++;
                    }

                }

                if($output[$i]['passengers'][0]['price'] > 0){

                    $output[$i]['source_type'] = $this->sourceType;
                    $output[$i]['source_title'] = $this->sourceTitle;
                    $output[$i]['plan_zone_code'] = $each['zone_code'];
                    $output[$i]['plan_fa_title'] = $each['fa_name'];
                    $output[$i]['plan_en_title'] = $each['en_name'];

                    $i++;
                }

            }

            return $output;
        }

        return $result['error_item']['message'];
    }
    #endregion

    #region getInsurancePrice
    public function getInsurancePrice($input){

        $birthDate = str_replace('-', '/', functions::ConvertToMiladi($input['birthDate']));

        $this->apiLink = 'http://www.travelinsure.ir/api/v1.1/getprice?token=' . $this->apiToken;
        $this->apiData = array(
            'country_id' => $input['countryID'],
            'zone_code' => $input['zoneCode'],
            'duration' => $input['duration'],
            'birthday' => $birthDate
        );
        $result = $this->curlExecutionPost($this->apiLink, $this->apiData);

        if ($result['success']) {

            $output = array(
                'basePrice' => $result['data']['base_price'],
                'taxPrice' => $result['data']['tax'],
                'totalPrice' => $result['data']['base_price'] + $result['data']['tax'],
                'commission' => $result['data']['commission']
            );

            return $output;
        }

        return $result['error_item']['message'];
    }
    #endregion

    #region preReserveInsurance
    public function preReserveInsurance($input){

        $return['status'] = true;
        $return['insuranceCode'] = '';

        return $return;
    }
    #endregion

    #region confirmReserveInsurance
    public function confirmReserveInsurance($input){

        $birthDate = str_replace('-', '/', $input['gregorianBirthDate']);

        $this->apiLink = 'http://www.travelinsure.ir/api/v1.1/issuance?token=' . $this->apiToken;
        $this->apiData = array(
            'country_id' => $input['countryID'],
            'zone_code' => $input['zoneCode'],
            'duration' => $input['duration'],
            'birthday' => $birthDate,
            'name' => $input['latinFirstName'],
            'lastname' => $input['latinLastName'],
            'visa_type' => $input['visaType'],
            'sex' => $input['gender'],
            'passport_no' => $input['passportNo'],
            'uniq_id' => rand(1000, 9999) . time(),
            'describe' => ''
        );
        $result = $this->curlExecutionPost($this->apiLink, $this->apiData);

        functions::insertLog('request with factor number ' . $input['factorNumber'] . ' : ' . json_encode($this->apiData), 'log_insurance_reserve');
        functions::insertLog('response with factor number ' . $input['factorNumber'] . ' : ' . json_encode($result), 'log_insurance_reserve');

        if($result['success']){

            $output = array(
                'status' => true,
                'insuranceCode' => $result['data']['ins_code']
            );

        } else{
            $output = array(
                'status' => false,
                'errorMessage' => $result['error_item']['message']
            );
        }

        return $output;
    }
    #endregion

    #region getInsurancePDF
    public function getInsurancePDF($insuranceCode){

        $this->apiLink = 'http://www.travelinsure.ir/api/v1.1/getinsurancepdf?token=' . $this->apiToken;
        $this->apiData = array(
            'ins_code' => $insuranceCode
        );
        $result = $this->curlExecutionPost($this->apiLink, $this->apiData);

        if($result['success']){
            return $result['data']['file_address'];
        }

        return $result['error_item']['message'];
    }
    #endregion

    #region getCredit
    public function getCredit(){

        $output = array(
            'status' => false,
            'errorMessage' => 'نیازی به پیش رزرو ندارد'
        );

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
        return ($input['commission'] * 0.8);
    }
    #endregion

}