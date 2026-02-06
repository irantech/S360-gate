<?php
/**
 * Created by PhpStorm.
 * User: Fani
 * Date: 9/30/2018
 * Time: 12:44 PM
 */


abstract class insuranceAbstract/* implements insuranceInterface*/ {

    #region variables
    public $username;
    public $password;
    public $sourceID;
    public $sourceType;
    public $sourceTitle;
    public $publicPrivate;
    #endregion
    
    #region init
    abstract function init($sourceInfo);
    #endregion

    #region getInsuranceList
    abstract function getInsuranceList($input);
    #endregion

    #region getInsurancePrice
    abstract function getInsurancePrice($input);
    #endregion

    #region preReserveInsurance
    abstract function preReserveInsurance($input);
    #endregion

    #region confirmReserveInsurance
    abstract function confirmReserveInsurance($input);
    #endregion

    #region getInsurancePDF
    abstract function getInsurancePDF($insuranceCode);
    #endregion

    #region getCredit
    abstract function getCredit();
    #endregion

    #region getVisaType
    abstract function getVisaType($visa);
    #endregion

    #region getGender
    abstract function getGender($gender);
    #endregion

    #region calculateAgencyCommission
    abstract function calculateAgencyCommission($input);
    #endregion

    #region curlExecutionPost
    /**
     * This function execute post curl with a url & array of data
     * @param $url string
     * @param $data an associative array of elements
     * @return jason decoded output
     * @author Naime Barati
     */
    public function curlExecutionPost($url, $data) {

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($handle);
        return json_decode($result, true);

    }
    #endregion

    #region curlExecutionGet
    /**
     * This function execute get curl with a url
     * @param $url string
     * @return jason decoded output
     * @author Naime Barati
     */
    public function curlExecutionGet($url) {

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($handle);
        return json_decode($result, true);

    }
    #endregion

}