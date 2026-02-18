<?php
/**
 * Class Session
 * @property Session $Session
 */

class Session extends baseController
{

    public static function init()
    {

        @session_start();
    }

    public static function IsLogin()
    {

       self::init();
        if (isset($_SESSION["Login"]) && $_SESSION['Login'] == 'success') {

            return true;
        } else {
         
            return false;
        }
    }

    public static function LoginDo($fullname, $id, $cardNo = NULL, $type = 'counter')
    {

       self::init();
        $_SESSION["Login"] = "success";
        $_SESSION["nameUser"] = $fullname;
        if ($type == 'counter') {
            $_SESSION["userId"] = $id;
        } elseif ($type == 'agency') {
            $_SESSION["AgencyId"] = $id;
        }

        $_SESSION["typeUser"] = $type; // counter or agency
        $_SESSION["cardNo"] = $cardNo; // for club
        $_SESSION['LastLogin'] = time();
    }

    public static function getNameUser()
    {

        self::init();
        return $_SESSION["nameUser"];
    }

    public static function getCardNumber()
    {

       self::init();
        return $_SESSION["cardNo"];
    }

    //public static function getFamilyUser(){Session::init(); return $_SESSION["familyUser"];}
    public static function getUserId()
    {

       self::init();
       return isset($_SESSION["userId"]) ? $_SESSION["userId"] : '';
    }


    public static function getAgencyId()
    {

       self::init();
        return isset($_SESSION["AgencyId"]) ? $_SESSION["AgencyId"] : '';
    }

    public static function getRelId()
    {
       self::init();
        return isset($_SESSION["rel_id"]) ? $_SESSION["rel_id"] : '';
    }

    public static function getRecId()
    {
       self::init();
        return isset($_SESSION["rec_id"]) ? $_SESSION["rec_id"] : '';
    }

    public static function getComId()
    {
       self::init();
        return isset($_SESSION["com_id"]) ? $_SESSION["com_id"] : '';
    }

    public static function getPriceId()
    {
       self::init();
        return isset($_SESSION["price_id"]) ? $_SESSION["price_id"] : '';
    }

    public static function getAddress()
    {
       self::init();
        return isset($_SESSION["address"]) ? $_SESSION["address"] : '';
    }

    public static function getCF()
    {
       self::init();
        return isset($_SESSION["CF"]) ? $_SESSION["CF"] : '';
    }

    public static function getTypeUser()
    {
       self::init();
        if (isset($_SESSION["typeUser"])) {
            return $_SESSION["typeUser"];
        } else {
            return false;
        }
    }

    public static function Logout()
    {
       self::init();
       session_destroy();
    }

    public static function setDetailSession($rel_id, $rec_id, $com_id, $price_id, $address, $CF)
    {
       self::init();
        $_SESSION["rel_id"] = $rel_id;
        $_SESSION["rec_id"] = $rec_id;
        $_SESSION["com_id"] = $com_id;
        $_SESSION["price_id"] = $price_id;
        $_SESSION["address"] = $address;
        $_SESSION["CF"] = $CF;
    }

    /*     * ***admin***** */

    public static function adminIsLogin()
    {
       self::init();
        if (isset($_SESSION["adminLogin"])) {
            return true;
        } else {
            return false;
        }
    }

    public static function CheckAgencyPartnerLoginToAdmin()
    {
       self::init();
        if (isset($_SESSION["AgencyPartner"])) {
            return true;
        } else {
            return false;
        }
    }

    public static function adminLoginDo()
    {

       self::init();
        $_SESSION["adminLogin"] = "successful";
        $_SESSION["popUp"] = "successful";
    }
    public static function popup()
    {
        self::init();
        return $_SESSION["popUp"] ;
    }

    public static function AgencyPartnerLoginToAdmin()
    {
       self::init();
        $_SESSION["AgencyPartner"] = "AgencyHasLogin";
    }
    public static function getAgencyPartnerLoginToAdmin()
    {
        self::init();
        return $_SESSION["AgencyPartner"] ;
    }
    public static function setCurrency($CodeCurrency = null)
    {
       self::init();

        if (SOFTWARE_LANG != 'fa') {
            if (!empty($CodeCurrency) && $CodeCurrency > 0) {
                    $_SESSION["CurrencyUnit"] = $CodeCurrency;
            } else {
                $_SESSION["CurrencyUnit"] = 0;
            }
        } else {
            unset($_SESSION["CurrencyUnit"]);
        }
    }

    public static function getCurrency()
    {
        self::init();
        return ((isset($_SESSION["CurrencyUnit"]) && SOFTWARE_LANG !='fa') || (in_array(GDS_SWITCH,functions::gdsForceCurrencyPage()))) ? $_SESSION["CurrencyUnit"] : 0;
    }

    public static function setDefaultCurrency() {
        self::init();
        if(ISCURRENCY=='1' && SOFTWARE_LANG !=='fa')
        {
            if(self::IsLogin()){
                $info_user = functions::infoAgencyByMemberId(self::getUserId());

                if ($info_user['fk_counter_type_id'] == '5') {
                    /** @var currencyEquivalent $CurrencyEquivalent */
                    $CurrencyEquivalent = Load::controller('currencyEquivalent');
                    $ResultCurrencyDefault = $CurrencyEquivalent->CurrencyDefault();
                    $CurrencyUnit = $ResultCurrencyDefault['CurrencyCode'];
                    $_SESSION["CurrencyUnit"] = $CurrencyUnit;
                } else {
                 
                    if ($info_user['type_payment'] == 'currency') {
                        $_SESSION["CurrencyUnit"] = $info_user['type_currency'];
                    } else {
                        $_SESSION["CurrencyUnit"] = 0;
                    }
                }
            }else{
               
                /** @var currencyEquivalent $CurrencyEquivalent */
                $CurrencyEquivalent = Load::controller('currencyEquivalent');
                $ResultCurrencyDefault = $CurrencyEquivalent->CurrencyDefault();
                $CurrencyUnit = $ResultCurrencyDefault['CurrencyCode'];

                $_SESSION["CurrencyUnit"] = $CurrencyUnit;
            }
        }else{
            $_SESSION["CurrencyUnit"] = 0;
        }


    }

    public static function getDefaultCurrency() {
        if(defined('SOFTWARE_LANG'))
        {
            if( SOFTWARE_LANG !='fa' || (in_array(GDS_SWITCH,functions::gdsForceCurrencyPage()))){
                self::setDefaultCurrency();
            }
        }
    }

    public static function setOrganization($organizationLevelID)
    {
        self::init();
        $_SESSION['organization'] = $organizationLevelID;
    }

    public static function getOrganization()
    {
        self::init();
        return isset($_SESSION["organization"]) ? $_SESSION["organization"] : '0';
    }

    public static function LastLogin()
    {
        self::init();
        return $_SESSION['LastLogin'];
    }


    public static function setCounterTypeId($counterTypeId){
        self::init();
        $_SESSION["counterTypeId"] = $counterTypeId;
    }

    public static function getCounterTypeId(){

       self::init();


        if (isset($_SESSION["counterTypeId"])){
            return $_SESSION["counterTypeId"];
        }
        return null;
    }


    public static function LoginDoByCookie()
    {
        setcookie('Login', "success", time() + (12 * 30 * 24 * 60 * 60), '/', NULL, 0);
        setcookie('nameUser', self::getNameUser(), time() + (12 * 30 * 24 * 60 * 60), '/', NULL, 0);
        setcookie('userId', self::getUserId(), time() + (12 * 30 * 24 * 60 * 60), '/', NULL, 0);
        setcookie('typeUser', self::getTypeUser(), time() + (12 * 30 * 24 * 60 * 60), '/', NULL, 0);
        setcookie('LastLogin', time(), time() + (12 * 30 * 24 * 60 * 60), '/', NULL, 0);
        setcookie('cardNo', self::getCardNumber(), time() + (12 * 30 * 24 * 60 * 60), '/', NULL, 0);

    }

    public static function setInfoCounterAdmin($id)
    {  self::init();
        $_SESSION['memberIdCounterInAdmin'] = $id ;
    }

    public static function getInfoCounterAdmin()
    {
        return $_SESSION['memberIdCounterInAdmin'];
    }

    public static function setSessionHistoryPassenger($typeRowPassengers, $idPassenger)
    {
        self::init();
        $_SESSION['passengerHistory'][$typeRowPassengers] = $idPassenger;
        $_SESSION['timePassengerHistory'] = time();
    }

    public static function getSessionHistoryPassenger()
    {
        return $_SESSION['passengerHistory'];
    }

    public static function getTimePassengerHistory()
    {
        return $_SESSION['timePassengerHistory'];
    }

    #region setCookieTemplate
    public static function setSessionTemplate($session)
    {
        self::init();
        if (!empty($session)) {
            $_SESSION['templateCookie'] = $session;
        } else {
            unset($_SESSION['templateCookie']);
        }

    }
    #endregion

    #region getSessionTemplate
    public static function getSessionTemplate()
    {
        return $_SESSION['templateCookie'];
    }
    #endregion

    public static function add( $index , $val) {
        self::init();
        $_SESSION[$index] = $val;
    }

	public static function delete( $index = '' ) {
		$_SESSION[$index] = '';
		unset($_SESSION[$index]);
		return null;
	}
	
	public static function setReferUrl( $url = '' ) {
		if($url){
			self::init();
			$_SESSION['refer_url'] = $url;
			return null;
		}
//		if($_SERVER['HTTP_REFERER'] != ''){
//			$_SESSION['refer_url'] = $_SERVER['HTTP_REFERER'];
//			return null;
//		}
		unset($_SESSION['refer_url']);
		return null;
	}


    public static function setSessionSelectLayout($type='web')
    {
//        self::init();

        $_SESSION['layout'] = $type;

	}

    public static function setSubAgencyId($agency_id) {
         self::init();
          $_SESSION["AgencyId"] = $agency_id;
    }

}


