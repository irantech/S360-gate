<?php
/**
 * Created by PhpStorm.
 * User: Fani
 * Date: 9/30/2018
 * Time: 2:02 PM
 */


interface insuranceInterface {

    #region init
    public function init($sourceInfo);
    #endregion

    #region getInsuranceList
    public function getInsuranceList($input);
    #endregion

    #region getInsurancePrice
    public function getInsurancePrice($input);
    #endregion

    #region preReserveInsurance
    public function preReserveInsurance($input);
    #endregion

    #region confirmReserveInsurance
    public function confirmReserveInsurance($input);
    #endregion

    #region getInsurancePDF
    public function getInsurancePDF($insuranceCode);
    #endregion

    #region getCredit
    public function getCredit();
    #endregion

    #region getVisaType
    public function getVisaType($visa);
    #endregion

    #region getGender
    public function getGender($gender);
    #endregion

    #region calculateAgencyCommission
    public function calculateAgencyCommission($input);
    #endregion

}