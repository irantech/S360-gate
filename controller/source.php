<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of source
 *
 * @author barati
 */
class source 
{
    private $ModelBase;
    
    public function __construct() 
    {
        $this->ModelBase = Load::library('ModelBase');
    }

    public function getServicesSrouces()
    {
        $query = "SELECT SOURCE.*, SERVICE.id AS ServiceId, SERVICE.TitleFa AS ServiceTitle FROM client_source_tb SOURCE INNER JOIN client_services_tb CS ON SOURCE.ServiceId = CS.id " .
                 "INNER JOIN services_group_tb SG ON CS.ServiceGroupId = SG.id INNER JOIN services_tb SERVICE ON SERVICE.ServiceGroupId = SG.id " .
                 "WHERE SG.MainService != 'Flight' ORDER BY SOURCE.ServiceId, SOURCE.Title";
        return $this->ModelBase->select($query);
    }
    
    public function getFlightSources()
    {
        $query = "SELECT SERVICE.*, FS.id AS SourceId, FS.Title AS SourceName FROM services_tb SERVICE INNER JOIN services_group_tb SG ON SERVICE.ServiceGroupId = SG.id " .
                 "INNER JOIN flight_source_service_tb FSS ON SERVICE.id = FSS.serviceId INNER JOIN flight_source_tb FS ON FSS.flightSourceId = FS.id " .
                 "WHERE SG.MainService = 'Flight' ORDER BY SERVICE.id, SourceId ";
        return $this->ModelBase->select($query);
    }

    public function getFlightTrustSource()
    {
        $query = "SELECT * FROM flight_source_tb";
        return $this->ModelBase->select($query);
    }

    public function hasFlightSourceService($service, $source)
    {
        $query = "SELECT * FROM flight_source_service_tb WHERE serviceId = '{$service}' AND flightSourceId = '$source'";
        $result = $this->ModelBase->load($query);

        if(!empty($result)){
            return true;
        }

        return false;
    }

    public function changeFlightSourceStatus($data)
    {
        $query = "SELECT * FROM flight_source_service_tb WHERE serviceId = '{$data['service']}' AND flightSourceId = '{$data['source']}'";
        $result = $this->ModelBase->load($query);

        $this->ModelBase->setTable('flight_source_service_tb');

        if(!empty($result)){
            $res = $this->ModelBase->delete("serviceId = '{$data['service']}' AND flightSourceId = '{$data['source']}'");
        } else{

            $dataSource['serviceId'] = $data['service'];
            $dataSource['flightSourceId'] = $data['source'];
            $dataSource['creationDateInt'] = time();

            $res = $this->ModelBase->insertLocal($dataSource);
        }

        if ($res) {
            return 'success : وضعیت منبع پرواز با موفقیت تغییر یافت';
        } else {
            return 'error : خطا در تغییر وضعیت منبع پرواز';
        }
    }

    #region getFlightSourceByTrustID
    public function getFlightSourceByTrustID($trustID)
    {
        $query = "SELECT * FROM flight_source_tb WHERE TrustSourceId = '{$trustID}'";
        return $this->ModelBase->load($query);
    }
    #endregion
}
