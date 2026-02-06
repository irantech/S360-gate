<?php


class pointClub extends clientAuth
{
    public function PointClubList()
    {

        Load::autoload('Model');

        $Model = new Model();
        $sql = " SELECT * FROM point_club_tb ORDER BY id DESC";

        return $Model->select($sql);

    }

    public function insertPointClub($param)
    {
        $Model = Load::library('Model');
        $sql = " SELECT 
                    counterTypeId 
                 FROM  
                    point_club_tb 
                 WHERE 
                    type_service='{$param['services']}'
                    AND base_company='{$param['base_company']}' 
                    AND company='{$param['company']}' 
                    AND is_enable = '1'  ";
        $check = $Model->select($sql, 'assoc');
        foreach ($check as $val){
            $arrayCheck[] = $val['counterTypeId'];
        }
        $res = [];
        for ($i = 0; $i <= $param['countCounter']; $i++){
            if (isset($param['price' . $i]) && $param['price' . $i] > 0
                && (empty($arrayCheck) || (!empty($arrayCheck) && !in_array($param['counter_id' . $i], $arrayCheck)))){

                $data['limitPrice'] = $param['limitPrice'];
                $data['limitPoint'] = $param['limitPoint'];
                $data['type_service'] = $param['services'];
                $data['base_company'] = isset($param['base_company']) ? $param['base_company'] : 'all';
                $data['company'] = (isset($param['company']) && $param['company'] != '') ? $param['company'] : 'all';
                $data['counterTypeId'] = $param['counter_id' . $i];
                $data['pointToPrice'] = $param['price' . $i];
                $data['is_enable'] = '1';
                $data['creation_date_int'] = time();

                $Model->setTable('point_club_tb');
                $res[] = $Model->insertLocal($data);

            }
            $data = [];
        }

        if ((empty($res)) || (!empty($res) && in_array('0', $res))) {
            return 'error : خطا در  تغییرات';
        } else {
            return 'success :  تغییرات با موفقیت انجام شد';
        }

    }


    public function deletePointClub($param)
    {
        $id = $param['id'];
        $Model = Load::library('Model');

        $sql = " SELECT * FROM point_club_tb WHERE id='{$id}'";
        $resQuery = $Model->load($sql);

        if (!empty($resQuery)) {
            $d['is_enable'] = '0';
            $d['disable_date_int'] = time();
            $Model->setTable('point_club_tb');
            $res = $Model->update($d, "id='{$id}'");

            if ($res) {
                echo ' success : امتیاز تخصیص داده شده با موفقیت حذف شد';
            } else {
                echo ' error : خطا در ثبت امتیاز';
            }

        } else {
            echo ' error : ارسال اطلاعات نا معتبر';
        }
    }


    public function pointClubEdit($param)
    {
        $Model = Load::library('Model');
        $data[$param['nameInput']] = $param['nameValue'];
        $Model->setTable('point_club_tb');
        $res = $Model->update($data, " id = '{$param['id']}' ");
        if ($res) {
            echo ' success : امتیاز با موفقیت تغییر داده شد.';
        } else {
            echo ' error : خطا در تغییر امتیاز.';
        }
    }

    public function getAllServices()
    {
        

        $ModelBase = Load::library('ModelBase');
        $clientId = CLIENT_ID;
        $sql = "SELECT 
              SOURCE.*, SERVICE.id AS IdService, SERVICE.TitleFa AS ServiceTitle ,SERVICE.TitleEn AS ServiceTitleEn,
              ( SELECT MainService FROM services_group_tb WHERE id = SERVICE.ServiceGroupId ) AS serviceGroup  
           FROM client_source_tb SOURCE 
           INNER JOIN services_tb SERVICE ON SERVICE.clientServiceId = SOURCE.ServiceId
           INNER JOIN client_auth_tb AS auth ON (auth.ServiceId = SOURCE.ServiceId AND auth.SourceId = SOURCE.id)
		   WHERE auth.IsActive = 'Active' AND auth.ClientId ='{$clientId}'
           ORDER BY SOURCE.ServiceId ";
        $result = $ModelBase->select($sql);
        return $result;
    }

    public function NameServicePoint($type_service)
    {

        $ModelBase = Load::library('ModelBase');

        $Sql = "SELECT
                    services.*,
                    services_group.Title AS TitleServicesGroup,
                    services_group.MainService AS MainServiceGroup
                FROM 
                    services_tb AS services
                    INNER JOIN services_group_tb AS services_group ON services.ServiceGroupId = services_group.id
                WHERE TitleEn='{$type_service}' ";

        $result = $ModelBase->load($Sql);

        return $result;
    }


    public function pricePointServiceCounter($counterId, $serviceTitle)
    {
        $Model = Load::library('Model');

        $sql = "SELECT * FROM point_club_tb WHERE type_service='{$serviceTitle}' AND counterTypeId='{$counterId}'";

        $resQuery = $Model->load($sql);
        return $resQuery['pointToPrice'];
    }

    public  function getPointClub( $service, $baseCompany, $company, $counterId ) {
        try {
            $query  = ( "CALL sp_point_club_tb(:service,:baseCompany,:company,:counterId)" );
            $params = array(
                ':service'     => $service,//service_title
                ':baseCompany' => $baseCompany,// id airline flight or company bus or train
                ':company'     => $company,//flight number or bus number or train number....
                ':counterId'   => $counterId,// counter's id in system
            );
            return  $this->getModel('pointClubModel')->runSP( $query, $params );

        }
        catch ( PDOException $ex ) {
            return false;
        }
    }




}