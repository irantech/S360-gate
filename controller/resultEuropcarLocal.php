<?php

class resultEuropcarLocal extends apiEuropcarLocal
{
    public $IsLogin;
    public $minPrice;
    public $maxPrice;
    public $countCar;
    public $getCarDateTime;
    public $getCarTime;
    public $getCarDate;
    public $returnCarDateTime;
    public $returnCarTime;
    public $returnCarDate;
    public $day;
    public $error;
    public $errorMessage;
    public $listStation;
    public $listThings;
    public $infoCars;
    public $listCarRentalReservation;
    public $sourceStationName;
    public $destStationName;
    public $listThingsById;
    public $isThingsById;
    public $countThings;
    public $allThingsId;
    public $counterId;
    public $serviceDiscountLocal = array();

    public function __construct()
    {
        parent::curl_init();

        $this->IsLogin = Session::IsLogin();
        if ($this->IsLogin){
            $this->counterId = functions::getCounterTypeId($_SESSION['userId']);
            $this->serviceDiscountLocal = functions::ServiceDiscount($this->counterId, 'LocalEuropcar');
            //$this->serviceDiscountPortal = functions::ServiceDiscount($this->counterId, 'PortalEuropcar');
            if (!empty($this->serviceDiscountLocal)){
                $this->serviceDiscountLocal['off_percent'] = round($this->serviceDiscountLocal['off_percent']);
            }
        }

    }

    #region setDiscount
    public function setDiscount($price)
    {
        $price = $price - (($price * $this->serviceDiscountLocal['off_percent']) / 100);
        return $price;
    }
    #endregion

    #region getDay
    public function getDay($getCarDateTime, $returnCarDateTime)
    {
        $expGetCarDateTime = explode("T", $getCarDateTime);
        $expReturnCarDateTime = explode("T", $returnCarDateTime);

        $this->getCarDate = $expGetCarDateTime[0];
        $this->returnCarDate = $expReturnCarDateTime[0];

        $getCarDateMiladi = functions::ConvertToMiladi($expGetCarDateTime[0]);
        $returnCarDateMiladi = functions::ConvertToMiladi($expReturnCarDateTime[0]);
        $start = strtotime($getCarDateMiladi);
        $end = strtotime($returnCarDateMiladi);
        $this->day = ceil(abs($end - $start) / 86400);

        $this->getCarTime = $expGetCarDateTime[1];
        $this->returnCarTime = $expReturnCarDateTime[1];

    }
    #endregion

    #region jsonDecodeThing
    public function jsonDecodeThing($thing)
    {
        $thingInfo = json_decode($thing, true);
        return $thingInfo;
    }
    #endregion

    #region getListTime
    public function getListTime()
    {
        $option = '';
        for ($hours = 0; $hours < 24; $hours++)
        {
            for ($mins = 0; $mins < 60; $mins += 30)
            {
                $value = str_pad($hours, 2, '0', STR_PAD_LEFT) . ':' . str_pad($mins, 2, '0', STR_PAD_LEFT) . ':00';
                $option .= '<option value="' . $value . '">' . $value . '</option>';
            }
        }
        return $option;
    }
    #endregion

    #region getStation
    public function getStation($sourceStationId, $destStationId)
    {
        $result = parent::getStationApi();

        if ($result['message']=='Successful'){

            $this->listStation = $result;
            foreach ($result['GetStationsResult']['Station'] as $val){
                if ($sourceStationId == $val['Id']){
                    $this->sourceStationName = $val['Name'];
                }
                if ($destStationId == $val['Id']){
                    $this->destStationName = $val['Name'];
                }
            }

        } else {
            $this->error = 'true';
            $this->errorMessage = $result['message'];
        }
    }
    #endregion


    #region getCarRentalReservation
    public function getCarRentalReservation($sourceStationId, $destStationId, $getCarDate, $getCarTime, $returnCarDate, $returnCarTime, $priceType)
    {
        // Access api europcar
        $resultInfoSourcesApi = parent::AccessApiEuropcar();
        if ($resultInfoSourcesApi == 'True') {

            $SDate = str_replace("-", "", $getCarDate);
            $dateNow = dateTimeSetting::jdate("Ymd",'','','','en');
            $dateMiladi = date('Ymd');
            $dateMiladiTomorrow = date('Ymd', strtotime($dateMiladi . " + 2 day"));
            $dateTomorrow = dateTimeSetting::gregorian_to_jalali(substr($dateMiladiTomorrow,0,4), substr($dateMiladiTomorrow,4,2), substr($dateMiladiTomorrow,6,2));
            $dateTomorrow = implode('', $dateTomorrow);
            if (trim($SDate) >= trim($dateNow) && trim($SDate) < trim($dateTomorrow)) {
                $this->error = "true";
                $this->errorMessage = functions::Xmlinformation("Therenorentalcaravailabletodaytomorrow");
            } else if (trim($SDate) >= trim($dateTomorrow)){
                $this->error = "false";
            } else {
                $this->error = "true";

                $this->errorMessage =  functions::Xmlinformation("Therenorentalcarthisdate");
            }

            $getCarDateTime = functions::ConvertToMiladi($getCarDate) . 'T' . $getCarTime;
            $returnCarDateTime = functions::ConvertToMiladi($returnCarDate) . 'T' . $returnCarTime;

            $result = parent::getCarRentalReservationApi($sourceStationId, $destStationId, $getCarDateTime, $returnCarDateTime, $priceType);

            if ($result['message']=='Successful'){

                $this->listCarRentalReservation = $result;

                $arrayPrice = array();
                foreach ($result['CarRentalReservationResult']['Cars']['CarDaysPrice'] as $val){
                    $arrayPrice[] = $val['Car']['PriceEachDayRial'];
                }
                $this->minPrice = min($arrayPrice);
                $this->maxPrice = max($arrayPrice);
                $this->countCar = count($result['CarRentalReservationResult']['Cars']['CarDaysPrice']['Car']['PriceEachDayRial']);

            } else {
                $this->error = 'true';
                $this->errorMessage = $result['message'];
            }

        } else {
            $this->error = "true";
            $this->errorMessage = functions::Xmlinformation("Noaccesstihspage");
        }



    }
    #endregion


    #region convertDateForEuropcar
    public function urlImageCar($image)
    {
        return "http://webs.europcar.ir" . substr($image,1);
    }
    #endregion



    #region getCarsById
    public function getCarsById($carId)
    {
        $result = parent::getCarsById($carId);
        if ($result['message']=='Successful'){

            $this->infoCars = $result['GetCarsByIdResult'];

        } else {
            $this->error = 'true';
            $this->errorMessage = $result['message'];
        }
    }
    #endregion

    #region getThings
    public function getThings($sourceStationId = null, $destStationId = null)
    {
        $result = parent::getThings();
        if ($result['message']=='Successful'){

            $this->listThings = $result;

            $allThingsId = '';
            foreach ($result['GetThingsResult']['Thing'] as $k=>$val){

                if ($sourceStationId != '' && $val['StationStatusId']==$sourceStationId){
                    $this->isThingsById['source'] = 'true';
                    $this->listThingsById['source'][$k] = $val;
                    $allThingsId .=  $val['Id'] . '/';
                }
                if ($destStationId != '' && ($destStationId != $sourceStationId) && $val['StationStatusId']==$destStationId){
                    $this->isThingsById['dest'] = 'true';
                    $this->listThingsById['dest'][$k] = $val;
                    $allThingsId .=  $val['Id'] . '/';
                }
            }

            $this->countThings = count($result['GetThingsResult']['Thing']);
            $this->allThingsId = $allThingsId;

        } else {
            $this->error = 'true';
            $this->errorMessage = $result['message'];
        }
    }
    #endregion

    #region urlImageThings
    public function urlImageThings($things)
    {
        switch ($things){
            case 'صندلی نوزاد':
                $url = 'assets/images/europcar/CSI.jpg';
                break;
            case 'مودم 3G':
                $url = 'assets/images/europcar/Modem.jpg';
                break;
            case 'زنجیر چرخ':
                $url = 'assets/images/europcar/Chains.jpg';
                break;
            case 'باربند':
                $url = 'assets/images/europcar/RoofBox.jpg';
                break;
            case 'صندلی کودک':
                $url = 'assets/images/europcar/CSB.jpg';
                break;
            case 'رهیاب':
                $url = 'assets/images/europcar/NAV.jpg';
                break;
            case 'صندلی بچه':
                $url = 'assets/images/europcar/CSI.jpg';
                break;
            case 'راننده آشنا به زبان انگلیسی':
                $url = 'assets/images/europcar/ADD.jpg';
                break;
            default:
                $url = '';
                break;

        }
        return $url;
    }
    #endregion


    #region createFactorNumber
    public function createFactorNumber()
    {
        $factor_number = substr(time(), 0, 4) . mt_rand(000, 999) . substr(time(), 6, 10);
        return $factor_number;
    }
    #endregion


}