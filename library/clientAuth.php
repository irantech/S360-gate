<?php
/**
 * Class clientAuth
 * @property clientAuth $clientAuth
 */
class clientAuth extends baseController {

    public $sourceId;
    public $arrayAuth = array();

    public  function __construct() {


    }

    #region adminAccess
    public function adminAccess($typeAccess) {

        $typeAccess = filter_var($typeAccess, FILTER_SANITIZE_STRING);

        Load::autoload('ModelBase');
        $model = new ModelBase();
        $query = "SELECT * FROM client_admin_access_tb WHERE ClientId = '".CLIENT_ID."' AND TypeAccess = '{$typeAccess}'";
        return $model->load($query);
    }
    #endregion

    #region ticketFlightAuth
    public function ticketFlightAuth($ClientID = null) {
        $ClientID = !empty($ClientID) ? $ClientID : CLIENT_ID ;
        Load::autoload('ModelBase');
        $model = new ModelBase();
        $query = "SELECT AUTH.Username, AUTH.Password, AUTH.ApiUrl, AUTH.ApiKey, SOURCE.SourceName, SERVICE.Service 
                  FROM client_auth_tb AS AUTH 
                  INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                  INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                  WHERE AUTH.ClientId = '{$ClientID}' AND SERVICE.Service = 'TicketFlightLocal' AND AUTH.IsActive='Active' ";

        $result = $model->load($query);
        return $result;
    }

    public function exclusiveTourAuth($ClientID = null) {
        $ClientID = !empty($ClientID) ? $ClientID : CLIENT_ID ;
        Load::autoload('ModelBase');
        $model = new ModelBase();
        $query = "SELECT AUTH.Username, AUTH.Password, AUTH.ApiUrl, AUTH.ApiKey, SOURCE.SourceName, SERVICE.Service 
                  FROM client_auth_tb AS AUTH 
                  INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                  INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                  WHERE AUTH.ClientId = '{$ClientID}' AND SERVICE.Service = 'exclusiveTour' AND AUTH.IsActive='Active' ";

        $result = $model->load($query);
        return $result;
    }
    #endregion
    
    #region insurancePortalAuth
    public function insurancePortalAuth($insurance = null) {

        if($insurance != null) {
            $insurance = filter_var($insurance, FILTER_SANITIZE_STRING);
        }

        Load::autoload('ModelBase');
        $model = new ModelBase();
        $query = "SELECT AUTH.Username, AUTH.Password, AUTH.ApiUrl, AUTH.ApiKey, SOURCE.id AS SourceId, SOURCE.SourceName, SOURCE.Title 
                  FROM client_auth_tb AS AUTH 
                  INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                  INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                  WHERE AUTH.ClientId = '".CLIENT_ID."' AND SERVICE.Service = 'InsurancePortal' 
                  AND AUTH.IsActive = 'Active' ";

        if($insurance != null){
            $query .= " AND SOURCE.SourceName = '{$insurance}' ";
            return $model->load($query);
        }

        return $model->select($query);
    }
    #endregion


    #region reservationHotelAuth
    public function reservationHotelAuth() {

        Load::autoload('ModelBase');
        $model = new ModelBase();
        $query = "SELECT AUTH.id, AUTH.Username, SOURCE.id as SourceId
                  FROM client_auth_tb AS AUTH 
                  INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                  INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                  WHERE AUTH.ClientId = '".CLIENT_ID."' AND SERVICE.Service = 'HotelReserveLocal' AND AUTH.IsActive='Active' ";
        $result = $model->load($query);
        if (!empty($result)){
            $this->sourceId = $result['SourceId'];
            return 'True';
        }else {
            return 'False';
        }

    }
    #endregion


    #region apiHotelAuth
    public function apiHotelAuth() {
        Load::autoload('ModelBase');
        $model = new ModelBase();
        $query = "SELECT AUTH.id, AUTH.Username,AUTH.Password, SOURCE.id as SourceId
                  FROM client_auth_tb AS AUTH 
                  INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                  INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                  WHERE AUTH.ClientId = '".CLIENT_ID."' AND (SERVICE.Service = 'HotelLocal' OR SERVICE.Service = 'HotelPortal') AND AUTH.IsActive='Active' ";
        $result = $model->load($query);

        if (!empty($result)){
            $this->sourceId = $result['SourceId'];
            $this->arrayAuth = $result;
            return 'True';
        }else {
            return 'False';
        }

    }
    #endregion

    #region apiExternalHotelAuth
    public function apiExternalHotelAuth() {

        Load::autoload('ModelBase');
        $model = new ModelBase();
        $query = "SELECT AUTH.id, AUTH.Username, SOURCE.id as SourceId
                  FROM client_auth_tb AS AUTH 
                  INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                  INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                  WHERE AUTH.ClientId = '".CLIENT_ID."' AND SERVICE.Service = 'HotelPortal' AND AUTH.IsActive='Active' ";
        $result = $model->load($query);
        if (!empty($result)){
            $this->sourceId = $result['SourceId'];
            return [
                'isAccess' => true,
                'username' => $result['Username']
            ];
        }else {
            return [
                'isAccess' => false,
                'username' => ''
            ];
        }

    }
    #endregion

    #region ticketFlightAuth
    public function ticketReservationFlightAuth() {

        Load::autoload('ModelBase');
        $model = new ModelBase();
        $query = "SELECT AUTH.Username, AUTH.Password, AUTH.ApiUrl, AUTH.ApiKey, SOURCE.SourceName, SERVICE.Service, SOURCE.id as SourceId
                  FROM client_auth_tb AS AUTH 
                  INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                  INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                  WHERE AUTH.ClientId = '".CLIENT_ID."' AND SERVICE.Service = 'TicketFlightReserveLocal' AND AUTH.IsActive='Active' ";
        $result = $model->load($query);
        $this->sourceId = $result['SourceId'];

        return $result;
    }
    #endregion



    #region apiEuropcarAuth
    public function apiEuropcarAuth() {

        Load::autoload('ModelBase');
        $model = new ModelBase();
        $query = "SELECT AUTH.id, AUTH.Username, SOURCE.id as SourceId
                  FROM client_auth_tb AS AUTH 
                  INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                  INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                  WHERE AUTH.ClientId = '".CLIENT_ID."' AND SERVICE.Service = 'EuropcarLocal' AND AUTH.IsActive='Active' ";
        $result = $model->load($query);
        if (!empty($result)){
            $this->sourceId = $result['SourceId'];
            return 'True';
        }else {
            return 'False';
        }

    }
    #endregion


    #region reservationTourAuth
    public function reservationTourAuth() {

        Load::autoload('ModelBase');
        $model = new ModelBase();
        $query = "SELECT AUTH.id, AUTH.Username, SOURCE.id as SourceId
                  FROM client_auth_tb AS AUTH 
                  INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                  INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                  WHERE AUTH.ClientId = '".CLIENT_ID."' AND SERVICE.Service = 'TourReservation' AND AUTH.IsActive='Active' ";
        $result = $model->load($query);
        if (!empty($result)){
            $this->sourceId = $result['SourceId'];
            return 'True';
        }else {
            return 'False';
        }

    }
    #endregion


    #region reservationVisaAuth
    public function reservationVisaAuth()
    {
        $ModelBase = Load::library('ModelBase');
        $query = "SELECT AUTH.id, AUTH.Username
                  FROM client_auth_tb AS AUTH 
                  INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                  INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                  WHERE AUTH.ClientId = '".CLIENT_ID."' AND SERVICE.Service = 'VisaReservation' AND AUTH.IsActive='Active' ";
        $result = $ModelBase->load($query);
        if (!empty($result)){
            return 'True';
        }else {
            return 'False';
        }
    }
    #endregion


    #region gashtAndTransferAuth
    public function gashtAndTransferAuth()
    {
        $ModelBase = Load::library('ModelBase');
        $query = "SELECT AUTH.id, AUTH.Username
                  FROM client_auth_tb AS AUTH 
                  INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                  INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                  WHERE AUTH.ClientId = '".CLIENT_ID."' AND SERVICE.Service = 'Gasht' AND AUTH.IsActive='Active' ";
        $result = $ModelBase->load($query);
        if (!empty($result)){
            return 'True';
        }else {
            return 'False';
        }
    }
    #endregion

    #region busAuth
    public function busAuth($client_id=CLIENT_ID)
    {
        $ModelBase = Load::library('ModelBase');
        $query = "SELECT AUTH.id, AUTH.Username, SOURCE.id as SourceId
                  FROM client_auth_tb AS AUTH 
                  INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                  INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                  WHERE AUTH.ClientId = '".$client_id."' AND SERVICE.Service = 'TicketBus' AND AUTH.IsActive='Active' ";


        $result = $ModelBase->load($query);
        if (!empty($result)){
            $this->sourceId = $result['SourceId'];
            return [
                'isAccess' => true,
                'username' => $result['Username']
            ];
        }else {
            return [
                'isAccess' => false,
                'username' => ''
            ];
        }
    }

    public function reservationBusAuth($client_id=CLIENT_ID)
    {
        return $this->getController('busPanel')->hasAccessToBusReservation();
    }

    #endregion

    #region TrainAuth
    public function TrainAuth()
    {
        $ModelBase = Load::library('ModelBase');
         $query = "SELECT AUTH.id, AUTH.Username
                  FROM client_auth_tb AS AUTH 
                  INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                  INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                  WHERE AUTH.ClientId = '".CLIENT_ID."' AND SERVICE.Service = 'TicketTrain' AND AUTH.IsActive='Active' ";
        return  $ModelBase->load($query);

    }
    #endregion


    public function getAccessServiceClient() {


                /** @var clientAuthModel $client_model */
//        $client_model=$this->getModel('clientAuthModel');
//        $services=$client_model->getAccessServiceClient();
//        return $client_model->addPackageToServices($services);
        return $this->getModel('clientAuthModel')->getAccessServiceClient();
    }
    public function findAccessServiceClient($MainService) {
        /** @var clientAuthModel $client_model */
        return $this->getModel('clientAuthModel')->getAccessServiceClient(null,$MainService)[0];
    }

    public function getAccessAccounting() {
        return $this->getModel('clientsModel')->get()->where('id',CLIENT_ID)->find();
    }

    public function getAccessApiTour($user_name,$password) {
        return $this->getModel('clientAuthModel')->get()->where('Username',$user_name)->where('Password',$password)->find();
    }

    public function getAccessTourWebService() {
        $ModelBase = Load::library('ModelBase');
        $query = "SELECT AUTH.id, AUTH.Username,AUTH.Password,AUTH.clientId
                  FROM client_auth_tb AS AUTH 
                  INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                  INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                  WHERE AUTH.ClientId = '".CLIENT_ID."' AND SERVICE.Service = 'TourApi' AND AUTH.IsActive='Active' ";
        return  $ModelBase->load($query);
    }

    public function getClientAuthFlightInfo() {
        $client = $this->getModel('clientAuthModel')
            ->get(['Username'], true)
            ->where('ServiceId', 1)
            ->where('ClientId', CLIENT_ID)
            ->all();
        return $client[0]['Username'];
    }
}