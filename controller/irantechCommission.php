<?php

class irantechCommission {

    public $list = array();     //array that include list of discounts
    public $ClientId;

    public function __construct()
    {
        if (isset($_GET['id'])) {
            $this->ClientId = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        }
    }

    #region update
    /**
     * update commission changes
     * @param associatice array of inputs for update
     * @return success or error
     */
    public function update($input) {

        $this->ClientId = filter_var($input['clientID'], FILTER_VALIDATE_INT);

        if (!empty($this->ClientId)) {
            $admin = Load::controller('admin');

            $sql = "SELECT * FROM irantech_commission_tb WHERE service_id = '{$input['serviceID']}' AND source_id = '{$input['sourceID']}'";
            $record = $admin->ConectDbClient($sql, $this->ClientId, "Select", "", "", "");

            if($record['id'] > 0) {

                $data['amount'] = $input['commission'];
                $res = $admin->ConectDbClient("", $this->ClientId, "Update", $data, "irantech_commission_tb", "service_id = '{$input['serviceID']}' AND source_id = '{$input['sourceID']}'");

            } else{

                $data['amount'] = $input['commission'];
                $data['service_id'] = $input['serviceID'];
                $data['source_id'] = $input['sourceID'];
                $data['creation_date'] = date('Y-m-d H:i:s');
                $res = $admin->ConectDbClient("", $this->ClientId, "Insert", $data, "irantech_commission_tb", "");

            }
        }

        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در تغییرات';
        }

    }
    #endregion

    #region get all commission changes records
    /**
     * get all commission changes
     * @return associative array by services
     */
    public function getAll() {

        if (!empty($this->ClientId)) {

            $admin = Load::controller('admin');

            $sql = " SELECT * FROM irantech_commission_tb";
            $result = $admin->ConectDbClient($sql, $this->ClientId, "SelectAll", "", "", "");
            foreach ($result as $record){

                $service = $record['service_id'];
                $source = $record['source_id'];
                $this->list[$service][$source] = $record;

            }
        }
        
    }
    #endregion

    #region getFlightCommission
    public function getEntertainmentCommission($serviceType, $trustSourceID, $clientID = null)
    {
        $ModelBase = Load::library('ModelBase');


        $queryService = "SELECT id FROM services_tb WHERE TitleEn = '{$serviceType}'";
        $resultService = $ModelBase->load($queryService);

        $querySource = "SELECT id FROM client_source_tb WHERE SourceName = '{$trustSourceID}'";
        $resultSource = $ModelBase->load($querySource);

        $query = "SELECT COALESCE((SELECT amount FROM irantech_commission_tb WHERE service_id = '{$resultService['id']}' AND source_id = '{$resultSource['id']}'), 0) AS Commission";

        if($clientID != null){

            $admin = Load::controller('admin');
            $result = $admin->ConectDbClient($query, $clientID, 'Select', '', '', '');

        } else {

            $Model = Load::library('Model');
            $result = $Model->load($query);

        }

        return $result['Commission'];
    }
    #endregion


    #region getFlightCommission
    public function getFlightCommission($serviceType, $trustSourceID, $clientID = null)
    {
        $ModelBase = Load::library('ModelBase');


        $queryService = "SELECT id FROM services_tb WHERE TitleEn = '{$serviceType}'";
        $resultService = $ModelBase->load($queryService);

        $querySource = "SELECT id FROM flight_source_tb WHERE TrustSourceId = '{$trustSourceID}'";
        $resultSource = $ModelBase->load($querySource);

        $query = "SELECT COALESCE((SELECT amount FROM irantech_commission_tb WHERE service_id = '{$resultService['id']}' AND source_id = '{$resultSource['id']}'), 0) AS Commission";

        if($clientID != null){

            $admin = Load::controller('admin');
            $result = $admin->ConectDbClient($query, $clientID, 'Select', '', '', '');

        } else {

            $Model = Load::library('Model');
            $result = $Model->load($query);

        }

        return $result['Commission'];
    }
    #endregion

    #region getServiceCommission
    public function getServiceCommission($serviceID, $sourceID)
    {
        $Model = Load::library('Model');

        $query = "SELECT COALESCE((SELECT amount FROM irantech_commission_tb WHERE service_id = '{$serviceID}' AND source_id = '{$sourceID}'), 0) AS Commission";
        $result = $Model->load($query);

        return $result['Commission'];
    }
    #endregion






    #region getCommission
    public function getCommission($serviceType, $serviceId, $clientID = null)
    {

        $ModelBase = Load::library('ModelBase');

        $queryService = "SELECT id FROM services_tb WHERE TitleEn = '{$serviceType}'";
        $resultService = $ModelBase->load($queryService);

        $query = "SELECT COALESCE((SELECT amount FROM irantech_commission_tb WHERE service_id = '{$resultService['id']}' AND source_id = '{$serviceId}'), 0) AS Commission";
        if($clientID != null){

            $admin = Load::controller('admin');
            $result = $admin->ConectDbClient($query, $clientID, 'Select', '', '', '');

        } else {


            $Model = Load::library('Model');

            $result = $Model->load($query);

        }
        return $result['Commission'];
    }
    #endregion


}

?>