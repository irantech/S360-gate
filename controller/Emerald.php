<?php

class Emerald
{
    protected $table = 'counter_details_tb';

    #region __construct
    public function __construct()
    {
        $this->userId = Session::getUserId();
    }
    #endregion
#region __getProfile
    public function getProfile($id = '')
    {
        $Model = Load::library('Model');
        if ($id != '') {
            $this->userId = $id;
        }
        $sql = "SELECT * FROM counter_details_tb WHERE idmember='{$this->userId}'";
        $result = $Model->load($sql);
        return ($result);
    }
#endregion
#region __SumRequestAll
    public function SumRequestAll($id = '')
    {
        $resultAllvalue = 0;
        $Model = Load::library('Model');
        if ($id != '') {
            $this->userId = $id;
        }
        $sql = "SELECT value AS SumValue FROM request_transaction_tb WHERE idmember='{$this->userId}' AND status='Progress'";
        $result = $Model->load($sql);
        $resultAllvalue = $resultAllvalue + $result['SumValue'];
        return ($resultAllvalue);
    }
#endregion
#region __sumRequestVerified
    public function sumRequestVerified($id = '')
    {
        $resultAll = 0;
        $Model = Load::library('Model');
        if ($id != '') {
            $this->userId = $id;
        }
        $sql = "SELECT SUM(value) AS SumValue FROM request_transaction_tb WHERE idmember='{$this->userId}' AND status='Success'";
        $result = $Model->load($sql);
        $resultAll += $result['SumValue'];
        return ($resultAll);
    }
#endregion
#region __UpdateUserDetail
    public function UpdateUserDetail($data)
    {

        $edit = '';
        $detail['name_hesab'] = functions::checkParamsInput($data['name']);
        $detail['sheba'] =  functions::checkParamsInput($data['sheba']);
        $detail['bank_hesab'] =  functions::checkParamsInput($data['bankHesab']);
        $detail['idmember'] =  functions::checkParamsInput($data['userid']);
        $result_status = '';
        $Model = Load::library('Model');
        $Model->setTable('counter_details_tb');
        $profile = $this->getProfile($detail['idmember']);
        $edit = $profile['sheba'];
        if ($data['memberType'] == 'mother') {
            if ($edit == '') {
                $config = Load::Config('application');
                $success = $config->UploadFile("pic", "picture", "200000");
                $explod_name_pic = explode(':', $success);

                if ($explod_name_pic[0] == "done") {
                    $detail['picture'] = $explod_name_pic[1];
                }
                if (!empty($detail['picture'])) {
                    $result = $Model->insertLocal($detail);
                    if ($result) {
                        $result_status = 'success:' . functions::Xmlinformation("AccountInformationRegistered");
                    } else {
                        $result_status = 'error:' . functions::Xmlinformation("Errorrecordinginformation");
                    }
                } else {
                    $result_status = 'error:' . functions::Xmlinformation("PleaseSendStaffImageCorrectFormat");
                }

            } else {
                if (empty($_FILES['picture'])) {
                    $sql = "SELECT * FROM counter_details_tb WHERE idmember= '{$detail['idmember']}'";
                    $result = $Model->load($sql);
                    $success = "done:" . $result['picture'];
                    $explod_name_pic = explode(':', $success);
                    $detail['picture'] = $explod_name_pic[1];
                } else {
                    $config = Load::Config('application');
                    $success = $config->UploadFile("pic", "picture", "200000");
                    $explod_name_pic = explode(':', $success);
                    if ($explod_name_pic[0] == "done") {
                        $detail['picture'] = $explod_name_pic[1];
                    }

                }

                if (!empty($detail['picture'])) {
                    $condition = 'idmember=' . $detail['idmember'] . '';
                    $result = $Model->Update($detail, $condition);
                    if ($result) {
                        $result_status = 'success:' . functions::Xmlinformation("AccountInformationRegistered");
                    } else {
                        $result_status = 'error:' . functions::Xmlinformation("Errorrecordinginformation");
                    }
                } else {
                    $result_status = 'error:' . functions::Xmlinformation("PleaseSendStaffImageCorrectFormat");
                }

            }
        } else {
            if ($edit == '') {

                $result = $Model->insertLocal($detail);
                if ($result) {
                    $result_status = 'success:اطلاعات حساب شما ثبت شد';
                } else {
                    $result_status = 'error:خطا در ثبت اطلاعات';
                }


            } else {

                $condition = 'idmember=' . $detail['idmember'] . '';
                $result = $Model->Update($detail, $condition);
                if ($result) {
                    $result_status = 'success:' . functions::Xmlinformation("AccountInformationRegistered");

                } else {
                    $result_status = 'error:' . functions::Xmlinformation("Errorrecordinginformation");
                }
            }

        }

        return $result_status;
    }
#endregion
#region __RequestZomorod
    public function RequestZomorod($data)
    {
        $detail['status'] = 'Progress';
        $detail['system'] = 'Safar360';
        $detail['value'] = $data['payRial'];
        $detail['idmember'] = $data['userid'];
        $detail['idagency'] = $data['agencyId'];
        $Functions = Load::library('functions');
        $detail['date'] = dateTimeSetting::jtoday();
        $Model = Load::library('Model');
        $Model->setTable('request_transaction_tb');
        $result = $Model->insertLocal($detail);
        if ($result) {
            $result_status = 'success';
        }
        return $result_status;
    }
#endregion
#region __getAllRequest
    public function getAllRequest($id = '')
    {

        $Model = Load::library('Model');
        if ($id != '') {
            $this->userId = $id;
        }
        $sql = "SELECT * FROM request_transaction_tb WHERE idmember='{$this->userId}'";
        $result = $Model->select($sql);
        return $result;
    }
#endregion
#region __listAllTransaction
    public function listAllTransaction()
    {
        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT * FROM clients_tb WHERE id >'1'";
        $res = $ModelBase->select($sql);
        $admin = Load::controller('admin');
        foreach ($res as $each) {

            if ($each['id'] > '1') {

                $sql = "SELECT TDetails.name_hesab,TDetails.sheba,TDetails.bank_hesab,TDetails.idmember as idUser,TRequest.value,TRequest.date,TRequest.id,TMember.name,TMember.family"
                    . " FROM counter_details_tb AS TDetails "
                    . " RIGHT JOIN request_transaction_tb AS TRequest ON TDetails.idmember = TRequest.idmember"
                    . " RIGHT JOIN members_tb AS TMember ON TDetails.idmember = TMember.id"
                    . " WHERE TRequest.status='Progress'"
                    . "GROUP BY TRequest.id";
                $RequestClient = $admin->ConectDbClient($sql, $each['id'], "SelectAll", "", "", "");

                foreach ($RequestClient as $key => $TransictianRequest) {
                    $TransictianRequest['AgencyName'] = $each['AgencyName'];
                    $TransictianRequest['ClientId'] = $each['id'];
                    $ListRequestClient[] = $TransictianRequest;
                }
            }
        }

        return $ListRequestClient;
    }
#endregion
#region __listAllSuccessTransaction
    public function listAllSuccessTransaction()
    {
        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT * FROM clients_tb WHERE id >'1'";
        $res = $ModelBase->select($sql);
        $admin = Load::controller('admin');
        foreach ($res as $each) {

            if ($each['id'] > '1') {

                $sql = "SELECT TDetails.name_hesab,TDetails.sheba,TDetails.bank_hesab,TDetails.idmember as idUser,TRequest.value,TRequest.date,TRequest.id,TMember.name,TMember.family"
                    . " FROM counter_details_tb AS TDetails "
                    . " RIGHT JOIN request_transaction_tb AS TRequest ON TDetails.idmember = TRequest.idmember"
                    . " RIGHT JOIN members_tb AS TMember ON TDetails.idmember = TMember.id"
                    . " WHERE TRequest.status='Success'"
                    . "GROUP BY TRequest.id";
                $SuccessClient = $admin->ConectDbClient($sql, $each['id'], "SelectAll", "", "", "");

                foreach ($SuccessClient as $key => $TransictianSuccess) {
                    $TransictianSuccess['AgencyName'] = $each['AgencyName'];
                    $TransictianSuccess['ClientId'] = $each['id'];
                    $ListSuccessClient[] = $TransictianSuccess;
                }
            }
        }

        return $ListSuccessClient;
    }
#endregion
#region __VerifyRequestZomorod
    public function VerifyRequestZomorod($data)
    {


        $admin = Load::controller('admin');
        $dataRequest['status'] = 'Success';
        $dataRequest['paydate'] = dateTimeSetting::jtoday();


        $Condition = "id='{$data['id']}'";


        $res = $admin->ConectDbClient("", $data['idclient'], "Update", $dataRequest, "request_transaction_tb", $Condition);
        if ($res) {
            return 'success : تایید پرداخت با موفقیت انجام شد';
        } else {
            return 'error : خطا در تایید پرداخت';
        }
    }
#endregion
#region __ShowListRequest
    public function ShowListRequest($iduser, $idclient)
    {
        $admin = Load::controller('admin');
        $sql = "SELECT TRequest.value,TRequest.date,TRequest.id,TMember.name,TMember.family,TRequest.status"
            . " FROM request_transaction_tb AS TRequest "
            . " RIGHT JOIN members_tb AS TMember ON TRequest.idmember = TMember.id"
            . " WHERE TRequest.idmember='{$iduser}'";
        $ListRequest = $admin->ConectDbClient($sql, $idclient, "SelectAll", "", "", "");


        return $ListRequest;
    }
#endregion
#region __ShowNameCounter
    public function ShowNameCounter($idUser, $idClient)
    {
        $admin = Load::controller('admin');
        $sql = "SELECT name,family"
            . " FROM members_tb"
            . " WHERE id=$idUser";
        $NameCounter = $admin->ConectDbClient($sql, $idClient, "Select", "", "", "");


        return $NameCounter;
    }
#endregion
}

?>