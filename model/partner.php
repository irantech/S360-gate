<?php

class partner_tb extends ModelBase
{
    protected $setting;

    protected $userPassCustomer;
    protected $table = 'clients_tb';
    protected $pk = 'id';

    public function __construct() {
        parent::__construct();
        $this->setting = new settingCore();
        $this->userPassCustomer = new userPassCustomers();
    }

    public function getAll()
    {

        $sql = "select partner.*,login.token from $this->table AS partner
                LEFT JOIN login_tb AS login On login.client_id = partner.id
               WHERE partner.id > 1 AND partner.archived_at IS NULL  ORDER BY 
                                                                         login.last_login desc
                                                                         /*partner.DbName desc,
                                                                         partner.$this->pk desc*/";


        $result = parent::select($sql);


        return $result;
    }
    public function getAllArchived()
    {

        $sql = "select partner.*,login.token from $this->table AS partner
                LEFT JOIN login_tb AS login On login.client_id = partner.id
               WHERE partner.id > 1 AND partner.archived_at IS NOT NULL  ORDER BY partner.$this->pk ASC";


        $result = parent::select($sql);


        return $result;
    }



    public function InsertAccessUserClient($clientId, $username)
    {
        $clientId = (int)$clientId;

        $sqlAuth = "
        SELECT ServiceId, SourceId, Password, ApiUrl, ApiKey, CreationDateInt , Username , IsActive
        FROM client_auth_tb
        WHERE ClientId = 166
    ";

        $authResults = parent::select($sqlAuth);

        if (empty($authResults)) {
            return false;
        }

        parent::setTable("client_auth_tb");

        $uniqueAuth = [];

        foreach ($authResults as $authResult) {
            $key = $authResult['ServiceId'] . '-' . $authResult['SourceId'];

            if (!isset($uniqueAuth[$key])) {
                $uniqueAuth[$key] = $authResult;
            }
        }

        foreach ($uniqueAuth as $authResult) {

            $check = parent::select("
            SELECT id
            FROM client_auth_tb
            WHERE ClientId = {$clientId}
              AND ServiceId = {$authResult['ServiceId']}
              AND SourceId = {$authResult['SourceId']}
        ");

            if (empty($check)) {
                $data = [
                    'ClientId' => $clientId,
                    'ServiceId' => $authResult['ServiceId'],
                    'SourceId' => $authResult['SourceId'],
                    'Username' => $authResult['SourceId'] == 4 ? $authResult['Username'] : $username,
                    'Password' => $authResult['Password'],
                    'ApiUrl' => $authResult['ApiUrl'],
                    'ApiKey' => $authResult['ApiKey'],
                    'isActive' => 'InActive',
                    'CreationDateInt' => $authResult['CreationDateInt'],
                ];

                parent::insertLocal($data);
            }
        }

        $dataInsertAgency = [
            'name' => $username,
            'Method' => 'InsertAgency',
        ];

        $dataInsertAgencySource = [
            'Method' => 'insertSourceAgency',
        ];

        $this->setting->insertAjency($dataInsertAgency);
        return true;
    }
    public function insertSourceAgency($agencyId , $name)
    {
        try {
            $agencyIdByName = $this->setting->listAgencyByName($name);
            $sources = $this->setting->getInfoAgencySource($agencyId);
            if (empty($sources)) {
                return false;
            }
            $url = $this->setting->apiAddress . "/baseFile/sourceUser/";

            foreach ($sources as $index => $sourceItem) {

                $dataToInsert = [
                    'Method' => 'insertSourceAgency' ,
                    'sourceId' => $sourceItem['SourceTbId'] ,
                    'agencyId' => $agencyIdByName['id'],
                    'userName' =>$sourceItem['userName'] ,
                    'password' => $sourceItem['password'] ,
                    'token' => $sourceItem['token'],
                    'isActiveInternal' => $sourceItem['isActiveInternal'],
                    'isActiveExternal' => $sourceItem['isActiveExternal'],
                    'webServiceType' => 'public',
                    'creationDate' => date('Y-m-d'),
                    'creationTime' => date('H:i:s'),
                    'creationDateInt' => time(),
                ];
                $jsonData = json_encode($dataToInsert);
                 functions::curlExecution($url, $jsonData, 'yes');



            }

        } catch (Exception $e) {
            error_log("Error in insertSourceAgency: " . $e->getMessage());
            return false;
        }
    }

    public function  insertUserPassCustomer($params)
    {
        $this->userPassCustomer->insertCustomer($params);
    }


    public function InsertClientModel($Info)
    {


        $data['AgencyName'] = $Info['AgencyName'];
        $data['Domain'] = $Info['Domain'];
        $data['DbName'] = 'safar360_'.$Info['ThemeDir'];
//        $data['DbUser'] = 'safar360_OnRes';
        $data['DbUser'] = 'safar360';
//        $data['DbPass'] = 'Safar@360#';
        $data['DbPass'] = 'GW@!pvGOZ$h9Mk[JdoU';
        $data['ThemeDir'] = $Info['ThemeDir'];
        $data['Email'] = $Info['Email'];
        $data['Manager'] = $Info['Manager'];
        $data['Mobile'] = $Info['Mobile'];
        $data['Phone'] = $Info['Phone'];
        $data['Address'] = $Info['Address'];
        $data['AddressEn'] = $Info['AddressEn'];
        $data['Title'] = $Info['Title'];
        $data['hash_id_whmcs'] = !empty($Info['id_whmcs']) ? md5($Info['id_whmcs']) : '';
        $data['Description'] = $Info['Description'];
        $data['UrlRuls'] = $Info['UrlRuls'];
        $data['MainDomain'] = $Info['MainDomain'];
        $data['default_language'] = $Info['default_language'];
        $data['diamondAccess'] = $Info['diamondAccess'];
        $data['AllowSendSms'] = $Info['AllowSendSms'];
        $data['UsernameSms'] = $Info['UsernameSms'];
        $data['PasswordSms'] = $Info['PasswordSms'];
        $data['Type'] = '2';
//        $data['UserNameApi'] = $Info['UserNameApi'];
        $data['GoogleMapLatitude'] = $Info['GoogleMapLatitude'];
        $data['GoogleMapLongitude'] = $Info['GoogleMapLongitude'];
        $data['IsEnableClub'] = $Info['IsEnableClub'];
        $data['IsEnableTicketHTC'] = $Info['IsEnableTicketHTC'];
//        $data['UserIdApi'] = $Info['UserIdApi'];
        $data['ClubPreCardNo'] = $Info['ClubPreCardNo'];
//        $data['IsEnableTelOrder'] = $Info['IsEnableTelOrder'];
//        $data['IsEnableSmsOrder'] = $Info['IsEnableSmsOrder'];
        $data['AboutMe'] = $Info['AboutMe'];
        $data['DefaultDb'] = $Info['DefaultDb'];
        $data['PinAllowAccountant'] = $Info['PinAllowAccountant'];
        $data['AdditionalData'] = json_encode($Info['AdditionalData'], 256 | 64);
        $data['isIframe'] = $Info['isIframe'];


        //
        $data['new_login'] = 1;
        $data['ravis_code'] = !empty($Info['ravis_code']) ? $Info['ravis_code'] :'';

        $config = Load::Config('application');
        $success = $config->UploadFile("pic", "Logo", "");

        $explod_name_pic = explode(':', $success);

        if(!empty($_FILES['Stamp'])){
            $successStamp = $config->UploadFile("pic", "Stamp", "");
            $explod_name_Stamp = explode(':', $successStamp);
            if($explod_name_Stamp[0] == 'done'){
                $data['Stamp'] = $explod_name_Stamp[1];
            }
        }
        $explod_name_pic[0] = "done";
        if ($explod_name_pic[0] == "done") {

            $data['Logo'] = $explod_name_pic[1];
            $result = parent::insertLocal($data);
            $last_id = parent::getLastId();
            if ($result) {
                $domain = $Info['MainDomain']; // iran.ir
                $username = explode('.', $domain)[0];
                $d['client_id'] = $last_id;
                $d['password'] = functions::encryptPassword($Info['password']);
                $d['token'] = functions::encryptPassword($d['client_id']);
                $d['username'] = $Info['Email'];
                $d['is_enable'] = '1';

                parent::setTable("login_tb");
                parent::insertLocal($d);
                $this->InsertAccessUserClient($last_id , $username);
                $this->insertSourceAgency(52 ,  $username );
                $dataUserPass = [
                    'title' => $Info['AgencyName'],
                    'domain' => $Info['Domain'],
                    'user_name' => $Info['Email'],
                    'password' => $Info['password'],
                    'link' => 'http://' . $Info['Domain'],
                ];
                $this->insertUserPassCustomer($dataUserPass);

                return "success : مشتری جدید با موفقیت ثبت شد";
            } else {
                return "error : خطا در ثبت مشتری";
            }
        } else {
            return "error : خطا در ثبت لوگوی مشتری";
        }
    }


    public function UpdateClientModel($Info)
    {
        $result = parent::load("select * from $this->table where $this->pk = '{$Info['client_id']}'");

        $id = $result['id'];

        if (!empty($result)) {
            $data['AgencyName'] = !empty($Info['AgencyName']) ? $Info['AgencyName'] :$result['AgencyName'];
            $data['Domain'] = !empty($Info['Domain']) ? $Info['Domain'] : $result['Domain'];
            $data['DbName'] = !empty($Info['DbName']) ? $Info['DbName'] : $result['DbName'];
            $data['ThemeDir'] = !empty($Info['ThemeDir']) ? $Info['ThemeDir'] : $result['ThemeDir'];
            $data['Email'] = !empty($Info['Email']) ? $Info['Email'] : $result['Email'];
            $data['Manager'] =!empty($Info['Manager']) ? $Info['Manager'] : $result['Manager'];
            $data['Mobile'] = !empty($Info['Mobile']) ? $Info['Mobile'] : $result['Mobile'];
            $data['Phone'] = !empty($Info['Phone']) ? $Info['Phone'] : $result['Phone'];
            $data['Address'] = !empty($Info['Address']) ? $Info['Address'] :$result['Address'];
            $data['AddressEn'] = !empty($Info['AddressEn']) ? $Info['AddressEn'] :$result['AddressEn'];
            $data['GoogleMapLatitude'] =!empty($Info['GoogleMapLatitude']) ? $Info['GoogleMapLatitude'] :$result['GoogleMapLatitude'];
            $data['GoogleMapLongitude'] = !empty($Info['GoogleMapLongitude']) ? $Info['GoogleMapLongitude'] :$result['GoogleMapLongitude'];
            $data['Title'] = !empty($Info['Title']) ? $Info['Title'] :$result['Title'];
            if(!empty($Info['id_whmcs'])) $data['hash_id_whmcs']=md5($Info['id_whmcs']);
            $data['Description'] = !empty($Info['Description']) ? $Info['Description'] :$result['Description'];
            $data['UrlRuls'] = !empty($Info['UrlRuls']) ? $Info['UrlRuls'] :$result['UrlRuls'];
            $data['MainDomain'] = !empty($Info['MainDomain']) ? $Info['MainDomain'] :$result['MainDomain'];
            $data['AllowSendSms'] = !empty($Info['AllowSendSms']) ? $Info['AllowSendSms'] :$result['AllowSendSms'];
            $data['UsernameSms'] = !empty($Info['UsernameSms']) ? $Info['UsernameSms'] : $result['UsernameSms'];
            $data['PasswordSms'] = !empty($Info['PasswordSms']) ? $Info['PasswordSms'] : $result['PasswordSms'];
            $data['IsCurrency'] = !empty($Info['IsCurrency']) ? $Info['IsCurrency'] : $result['IsCurrency'];
            $data['diamondAccess'] = !empty($Info['diamondAccess']) ? $Info['diamondAccess'] :'0';
            $data['IsEnableClub'] = !empty($Info['IsEnableClub']) ? $Info['IsEnableClub'] :'0';
            $data['IsEnableTicketHTC'] = !empty($Info['IsEnableTicketHTC']) ? $Info['IsEnableTicketHTC'] :$result['IsEnableTicketHTC'];
            $data['ClubPreCardNo'] = !empty($Info['ClubPreCardNo']) ? $Info['ClubPreCardNo'] :$result['ClubPreCardNo'];
            /*$data['IsEnableTelOrder'] = !empty($Info['IsEnableTelOrder']) ? $Info['IsEnableTelOrder'] :$result['IsEnableTelOrder'];
            $data['IsEnableSmsOrder'] = !empty($Info['IsEnableSmsOrder']) ? $Info['IsEnableSmsOrder'] :$result['IsEnableSmsOrder'];*/
            $data['AboutMe'] = !empty($Info['AboutMe']) ? $Info['AboutMe'] :$result['AboutMe'];
            $data['PinAllowAccountant']  = !empty($Info['PinAllowAccountant']) ? $Info['PinAllowAccountant'] : $result['PinAllowAccountant'];
            $data['AdditionalData'] = json_encode($Info['AdditionalData'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            $data['new_login'] = !empty($Info['new_login']) ? $Info['new_login'] :'0';
            $data['isIframe'] = $Info['isIframe'];



            if(!empty($Info['DefaultDb']))
            {
                $defaultDb = ($Info['DefaultDb']=='yes') ? '1' :'0';
            }else{
                $defaultDb= $result['DefaultDb'];
            }

            $data['DefaultDb']  = $defaultDb;

            if (empty($_FILES['Logo'])) {

                $success = "done:" . $result['Logo'];
                $explod_name_pic = explode(':', $success);
            } else {
                $config = Load::Config('application');
                $success = $config->UploadFile("pic", "Logo", "");
                $explod_name_pic = explode(':', $success);

            }


            if(!empty($_FILES['Stamp'])){
                $config = Load::Config('application');
                $successStamp = $config->UploadFile("pic", "Stamp", "");
                $explod_name_Stamp = explode(':', $successStamp);
                if($explod_name_Stamp[0] == 'done'){
                    $data['Stamp'] = $explod_name_Stamp[1];
                }
            }

            if ($explod_name_pic[0] == "done") {
                $data['Logo'] = $explod_name_pic[1];


                $res_update = parent::update($data, "id='{$id}'");
                if ($res_update) {

                    echo 'success : اطلاعات  با موفقیت ویرایش شد';
                } else {
                    echo 'error : خطا در ویرایش اطلاعات ';
                }
            }else{
                echo "error : خطا در ویرایش  لوگو ";
            }
        } else {

            echo "error : اطلاعات مورد نظر وجود ندارد،با وب مستر خود تماس بگیرید";
        }
    }

    public function archive($Info)
    {
        $result = parent::load("select * from $this->table where $this->pk = '{$Info}'");

        $id = $result['id'];
        if(!empty($result)){
            $data['archived_at'] = date('Y-m-d H:i:s');
        }
        $res_update = parent::update($data, "id='{$id}'");
        if ($res_update) {

            return ['message'=>'success : مشتری با موفقیت آرشیو شد','status'=>200];
        } else {
            return ['message' => 'error : خطا در آرشیو مشتری ', 'status' => 500];
        }
    }

    public function unarchive($Info)
    {
        $result = parent::load("select * from $this->table where $this->pk = '{$Info}'");
        $Model = Load::library('ModelBase');
        $id = $result['id'];
        $sqlUpdate = " UPDATE clients_tb SET ";
        if(!empty($result)){
            $sqlUpdate .= " archived_at = NULL  ";

//            $update_data = array(
//                'archived_at'  => NULL,
//            );
        }

        $sqlUpdate .= " WHERE id = '{$id}' ";
        $res_update = $Model->updateByQuery($sqlUpdate);

        if ($res_update) {

            return ['message'=>'success : آرشیو مشتری با موفقیت لغو شد','status'=>200];
        } else {
            return ['message' => 'error : خطا در لغو آرشیو مشتری ', 'status' => 500];
        }
    }
    public function getClient($info) {

        $sql = "select partner.* from $this->table AS partner
            
                WHERE  partner.id > 1 AND 
                       partner.MainDomain = '{$info['domain']}' ORDER BY partner.$this->pk ASC";
        $result = parent::select($sql);


        return $result;
    }




}
