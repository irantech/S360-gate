<?php
/**
 * Created by PhpStorm.
 * User: Fani
 * Date: 9/30/2018
 * Time: 12:44 PM
 */


abstract class smsServicesAbstract {

    #region variables
    public $smsUserName = '';
    public $smsPassword = '';
    public $smsNumber = '';
    public $soapClient = '';
    #endregion
    
    #region init
    abstract function init($input);
    #endregion

    #region smsSend
    abstract function smsSend($input);
    #endregion

    #region smsErrorMessage
    abstract function smsErrorMessage($errorCode);
    #endregion

    #region smsDeliveryCheck
    abstract function smsDeliveryCheck($successCode);
    #endregion

    #region smsDeliveryMessage
    abstract function smsDeliveryMessage($deliveryCode);
    #endregion

    #region smsGetCredit
    abstract function smsGetCredit();
    #endregion

}