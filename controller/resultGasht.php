<?php
/**
 * Class resultGasht
 * @property resultGasht $resultGasht
 */

class resultGasht extends apiGashtTransfer {
    public $error;
    public $errorMessage;

    #region __construct()
    public function __construct()
    {
        parent::__construct();
      echo $this->encryptingData();
    }
    #endregion

    #region getGashtResult
    public function getGashtResult()
    {
        $resultInfoSourcesApi = parent::AccessApiGasht();

        if ($resultInfoSourcesApi == 'True') {
            if (defined('GASHT_TYPE')) {

                $filters['GroupType'] = GASHT_TYPE;
                $result = parent::getServiceListByFilter(CITY_CODE, $filters);

            } elseif (VEHICLE_TYPE != '0' || WELCOME_TYPE != '0' || TRANSFER_PLACE != '0') {

                $filters['WelcomeType'] = WELCOME_TYPE;
                $filters['VehicleType'] = VEHICLE_TYPE;
                $filters['TransferPlace'] = TRANSFER_PLACE;
                $result = parent::getServiceListByFilter(CITY_CODE, $filters);

            } else {

                $result = parent::getServiceList(CITY_CODE);
            }



            foreach ($result as $item) {

                if(!empty($item['data']))
                {
                    $resultFinal[] = $item;
                }
            }

            return !empty($resultFinal) ? $resultFinal : $result;
        }
        $this->error = "true";
        $this->errorMessage = functions::Xmlinformation("Noaccesstihspage");

    }
    #endregion

    #region saveSelectedGasht
    public function saveSelectedGasht($input){

        $data['serviceid']      = $input['ServiceID'];
        $data['servicename']    = $input['ServiceName'];
        $data['servicecomment'] = $input['ServiceComment'];
        $data['price']          = $input['Price'];
        $data['discount']       = $input['Discount'];
        $data['priceafteroff']  = $input['PriceAfterOff'];
        $data['requestdate']    = $input['REQUEST_DATE'];
        $data['cityname']       = $input['cityName'];
        $data['request_Type']   = $input['request_Type'] ;
        $data['encryptData']=$input['encryptData'] ;
        $data['CurrencyCode']=$input['CurrencyCode'] ;
        $data['serviceuniqueid']=$input['serviceuniqueid'] ;


        $Model = Load::library('Model');
        $Model->setTable('temporary_gasht_tb');
        $result = $Model->insertLocal($data);
        if ($result){
          return 1;
        }
    }
    #endregion
    
    #region getCitiesFromDB
    public function getCitiesFromDB(){

        $ModelBase = Load::library('ModelBase');
        $query = "SELECT * FROM gashtotransfer_cities_tb  ORDER BY city_name";
        return $ModelBase->select($query);

    }
    #endregion
#region createFactorNumber
    public function createFactorNumber()
    {
        $factor_number = substr(time(), 0, 4) . mt_rand(000, 999) . substr(time(), 6, 10);
        return $factor_number;
    }
    #endregion

    public function getDiscount($service){
        if($service==0){
            $serviceType='LocalGasht';
        }else{
            $serviceType='LocalTransfer';
        }
        $UserId = Session::getUserId();
        $UserInfo = functions::infoMember($UserId);
        if (!empty($UserInfo)) {
            $counterID = $UserInfo['fk_counter_type_id'];
        } else {
            $counterID = '5';
        }
        Load::autoload('Model');
        $Model = new Model();

$query = "SELECT off_percent FROM services_discount_tb WHERE counter_id = '{$counterID}' AND service_title = '{$serviceType}'";
        $discount= $Model->load($query);
        return $discount[0];
    }

}