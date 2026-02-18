<?php

class settingAccessUserClientList
{
    #region variables
    public $ShowEdit;
    #endregion

    #region __construct
    public function __construct()
    {

    }
    #endregion


    #region ListAccessUserClient
    public function ListAccessUserClient($ClientId)
    {
        $ClientId = filter_var($ClientId, FILTER_VALIDATE_INT);

        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        if (!empty($ClientId)) {
            $Sql = "SELECT AUTH.id AS id,AUTH.ClientId AS ClientId ,AUTH.Username, AUTH.Password, AUTH.ApiUrl, AUTH.ApiKey,AUTH.IsActive, SOURCE.SourceName, SERVICE.Service,
                      SERVICE.Title AS TitleService,SERVICE.id AS ServiceId,SERVICEGROUP.Title AS ServiceGroupTitle ,SOURCE.SourceName AS TitleSource,SOURCE.id AS SourceId
                      FROM client_auth_tb AS AUTH 
                      INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                      INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                      INNER JOIN services_group_tb AS SERVICEGROUP ON SERVICE.ServiceGroupId = SERVICEGROUP.id
                      WHERE AUTH.ClientId = '{$ClientId}'";

            $Result = $ModelBase->select($Sql);
            return $Result;

        } else {
            header("Location: " . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . "/404.tpl");
        }

    }
    #endregion

    #region AccessActive
    public function AccessActive($param)
    {
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $SqlClientAuth = "SELECT id,IsActive FROM client_auth_tb WHERE id='{$param['id']}' AND ClientId='{$param['ClientId']}' AND 
                           ServiceId='{$param['ServiceId']}' AND SourceId='{$param['SourceId']}'";

        $ResultClientAuth = $ModelBase->load($SqlClientAuth);

        if (!empty($ResultClientAuth)) {
            if ($ResultClientAuth['IsActive'] == 'Active') {
                $data['IsActive'] = 'InActive';
            } else {
                $data['IsActive'] = 'Active';
            }

            $Condition = "id='{$param['id']}' AND ClientId='{$param['ClientId']}' AND ServiceId='{$param['ServiceId']}' AND SourceId='{$param['SourceId']}'";
            $ModelBase->setTable('client_auth_tb');
            $UpdateResult = $ModelBase->update($data, $Condition);

            if ($UpdateResult) {
                return "success: وضعیت دسترسی با موفقیت تغییر کرد";
            } else {

            }

        } else {
            return "error: خطا در تغییر وضعیت دسترسی";
        }

    }
    #endregion

    #region list Service
    public function ServiceList($param=null)
    {
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();


        $SqlServiceList = "SELECT * FROM client_services_tb";
        $ServiceListResult = $ModelBase->select($SqlServiceList);

        return $ServiceListResult;

    }
    #endregion

    #region list source
    public function SourceList($param)
    {
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $SqlSourceList = "SELECT * FROM client_source_tb WHERE ServiceId='{$param['ValueSource']}'";
        $SourceListResult = $ModelBase->select($SqlSourceList);

        $option = '';
        foreach ($SourceListResult as $Source) {
            $option .= '<option value="' . $Source['id'] . '">' . $Source['Title'] . '</option>';
        }

        return $option;
    }
    #endregion

    #region insertAccessNew

    public function insertAccessNew($param)
    {
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $data['ClientId'] = $param['ClientId'];
        $data['ServiceId'] = $param['ServiceId'];
        $data['SourceId'] = $param['SourceId'];
        $data['Username'] = $param['Username'];
        $data['Password'] = $param['Password'];
        $data['ApiUrl'] = $param['ApiUrl'];
        $data['ApiKey'] = $param['ApiKey'];
        $data['IsActive'] = 'Active';
        $data['CreationDateInt'] = time();


        $ModelBase->setTable('client_auth_tb');
        $ResultInsertClientAuth = $ModelBase->insertLocal($data);

        if ($ResultInsertClientAuth) {
            return 'success : دسترسی با موفقیت افزوده شد';
        } else {
            return 'error : خطا در افزودن دسترسی';
        }
    }
    #endregion

    #region ShowAccess
    public function ShowAccess($id, $ClientId)
    {
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $id = filter_var($id, FILTER_VALIDATE_INT);
        $ClientId = filter_var($ClientId, FILTER_VALIDATE_INT);

        $SqlClientAuth = "SELECT * FROM client_auth_tb WHERE id='{$id}' AND ClientId='{$ClientId}'";

        $ResultClientAuth = $ModelBase->load($SqlClientAuth);

        $this->ShowEdit = $ResultClientAuth;

    }
    #endregion

    #region SourceEdit
    public function SourceEdit($serviceId)
    {
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $SqlSourceList = "SELECT * FROM client_source_tb WHERE ServiceId='{$serviceId}'";
        $SourceListResult = $ModelBase->select($SqlSourceList);

        return $SourceListResult;

    }
    #endregion


    #region insertAccessNew

    public function EditAccessNew($param)
    {
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $id = $param['id'];
        $ClientId = $param['ClientId'];
        $data['ServiceId'] = $param['ServiceId'];
        $data['SourceId'] = $param['SourceId'];
        $data['Username'] = $param['Username'];
        $data['Password'] = $param['Password'];
        $data['ApiUrl'] = $param['ApiUrl'];
        $data['ApiKey'] = $param['ApiKey'];
        $data['LastEditInt'] = time();


        $ModelBase->setTable('client_auth_tb');
        $Condition = "id='{$id}' AND ClientId='{$ClientId}' ";
        $ResultEditClientAuth = $ModelBase->update($data,$Condition);

        if ($ResultEditClientAuth) {
            return 'success : دسترسی با موفقیت ویرایش شد';
        } else {
            return 'error : خطا در افزودن دسترسی';
        }
    }
    #endregion

    public function setJacketCustomerAccess($params) {
        $domain_parts = explode('.', $params['MainDomain']);
        $user_name = $domain_parts['0'] . '_jacket' ;
        $access_lists = array(
            ['service_id' => 1  , 'source_id' => 1 , 'userName' => $user_name , 'password' => ''] ,
            ['service_id' => 3  , 'source_id' => 6  , 'userName' => $user_name , 'password' => ''] ,
            ['service_id' => 5  , 'source_id' => 4  , 'userName' => 'WS1@IrantechnologyNoyanCoreWS' , 'password' => 'Te@cn@0607!!'] ,
            ['service_id' => 11  , 'source_id' => 13  , 'userName' => $user_name , 'password' => '']
        ) ;


        foreach ($access_lists as $service) {

            $data['ClientId'] = $params['id'];
            $data['ServiceId'] = $service['service_id'];
            $data['SourceId'] = $service['source_id'];
            $data['Password'] = $service['password'];
            $data['Username'] = $service['userName'] ;
            $data['IsActive'] = 'Active';
            $data['CreationDateInt'] = time();
            self::insertAccessNew($data);
        }

        return self::activateAgencyCore(['name' => $user_name]) ;
    }

    public  function  activateAgencyCore($data){

        if ( ( isset( $_SERVER["HTTP_HOST"] ) && strpos( $_SERVER["HTTP_HOST"], '192.168.1.100' ) !== false ) || ( isset( $_SERVER["HTTP_HOST"] ) && strpos( $_SERVER["HTTP_HOST"], 'online.1011.ir' ) !== false ) || ( isset( $_SERVER["HTTP_HOST"] ) && strpos( $_SERVER["HTTP_HOST"], '1011.ir' ) !== false ) || ( isset( $_SERVER["HTTP_HOST"] ) && strpos( $_SERVER["HTTP_HOST"], 'localhost' ) !== false ) ) {//local
            $apiAddress = '192.168.1.100/CoreTestDeveloper';
        } else {
//            $apiAddress = 'http://safar360.com/Core';
            $apiAddress = 'http://safar360.com/Core';
        }
        $data['Method'] = "InsertAgency" ;

        $data = json_encode( $data );

        $url = $apiAddress . "/baseFile/agency/";

        $resultSendData = functions::curlExecution( $url, $data, 'yes' );

        if($resultSendData['status'] == 'success') {
           return self::activateAgencySourceCore($resultSendData['agencyId']) ;
        }else {
            return false ;
        }

    }

    public function activateAgencySourceCore($agency_id){

        if ( ( isset( $_SERVER["HTTP_HOST"] ) && strpos( $_SERVER["HTTP_HOST"], '192.168.1.100' ) !== false ) || ( isset( $_SERVER["HTTP_HOST"] ) && strpos( $_SERVER["HTTP_HOST"], 'online.1011.ir' ) !== false ) || ( isset( $_SERVER["HTTP_HOST"] ) && strpos( $_SERVER["HTTP_HOST"], '1011.ir' ) !== false ) || ( isset( $_SERVER["HTTP_HOST"] ) && strpos( $_SERVER["HTTP_HOST"], 'localhost' ) !== false ) ) {//local
            $apiAddress = '192.168.1.100/CoreTestDeveloper';
        } else {
//            $apiAddress = 'http://safar360.com/Core';
            $apiAddress = 'http://safar360.com/Core';
        }

        $source_list = array(
            ['sourceId' => 13, 'userName' => 'irantechTest' , 'password' => ''  , 'token' => '$2y$10$pYzY6mhw7.06wBawQ6QYf.Ee7kwS3UPJYP6AxUtLFHcKJTDYJPQaK' , 'isActiveInternal' => 1 ,'isActiveExternal' => 0,  'webServiceType' =>  'public'  ] ,
            ['sourceId' => 10  , 'userName' => 'irantech' , 'password' => '286540'  , 'token' => '', 'isActiveInternal' => 1  ,'isActiveExternal' => 0 ,  'webServiceType' =>  'public'] ,
            ['sourceId' => 3  , 'userName' => 'charteryesmoj' , 'password' => '1qaSDF45rew'  , 'token' => '', 'isActiveInternal' => 0 ,'isActiveExternal' => 0  , 'webServiceType' =>  'public' ] ,
            ['sourceId' => 22  , 'userName' => 'abazar@iran-tech.com', 'password' => '730029'   , 'token' => 'e3cb9183-f120-eb11-9288-0050568f088f', 'isActiveInternal' => 1  ,'isActiveExternal' => 0  , 'webServiceType' =>  'public' ]
        ) ;
        foreach ($source_list as $source) {
            $data = $source ;
            $data['agencyId'] =  $agency_id ;
            $data['Method'] = "insertSourceAgency";

            $data = json_encode( $data );

            $url = $apiAddress . "/baseFile/sourceUser/";

             functions::curlExecution( $url, $data, 'yes' );
        }
        return true;

    }
}