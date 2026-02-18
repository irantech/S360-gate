<?php

/**
 * Class busTicketPriceChanges
 * @property busTicketPriceChanges $busTicketPriceChanges
 */

class busTicketPriceChanges {

    public $id;
    public $list;
    public $edit;

    public function __construct()
    {

    }

    public function setBusTicketPriceChanges($info) {

        $Model = Load::library('Model');
        $start_date = str_replace('-', '/', $info['start_date']);
        $end_date = str_replace('-', '/', $info['end_date']);

        $sql = " SELECT 
                    counter_id 
                 FROM  
                    bus_ticket_price_changes_tb 
                 WHERE 
                    ((`start_date` between '{$start_date}' AND '{$end_date}' ) OR (`end_date` between '{$start_date}' AND '{$end_date}'))
                    AND origin_city='{$info['origin_city']}' AND destination_city='{$info['destination_city']}'
                    AND company_bus='{$info['company_bus']}' AND is_del='no'  ";
        $price_changes = $Model->select($sql, 'assoc');
        foreach ($price_changes as $val){
            $arrayPriceChanges[] = $val['counter_id'];
        }
        if ($info['start_date'] <= $info['end_date']) {
            $res = [];
            for ($i = 0; $i <= $info['countCounter']; $i++){
                if (isset($info['price' . $i]) && $info['price' . $i] > 0
                    && (empty($arrayPriceChanges) || (!empty($arrayPriceChanges) && !in_array($info['counter_id' . $i], $arrayPriceChanges)))){

                    $data['creation_date'] = dateTimeSetting::jdate('Y/m/d','','','','en');
                    $data['origin_city'] = $info['origin_city'];
                    $data['destination_city'] = $info['destination_city'];
                    $data['company_bus'] = $info['company_bus'];
                    $data['start_date'] =str_replace('-', '/', $info['start_date']);
                    $data['end_date'] = str_replace('-', '/', $info['end_date']) ;
                    $data['change_type'] = $info['change_type'];
                    $data['is_del'] = 'no';
                    $data['price'] = $info['price' . $i];
                    $data['price_type'] = $info['price_type' . $i];
                    $data['counter_id'] = $info['counter_id' . $i];

                    $Model->setTable('bus_ticket_price_changes_tb');
                    $res[] = $Model->insertLocal($data);
                }
                $data = [];
            }

            if ((empty($res)) || (!empty($res) && in_array('0', $res))) {
                return 'error : خطا در  تغییرات';
            } else {
                return 'success :  تغییرات با موفقیت انجام شد';
            }

        } else {
            return 'error : تاریخ شروع از تاریخ پایان نمیتواند بزرگتر باشد';
        }

    }

    public function listBusTicketPriceChanges() {

        $Model = Load::library('Model');

        $sql = " SELECT * FROM bus_ticket_price_changes_tb ORDER BY id DESC";
        $price_changes = $Model->select($sql);

        return $price_changes;
    }

    public function getNameCity($iataCode) {

        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT * FROM  bus_route_tb WHERE Departure_City_IataCode = '{$iataCode}' OR Arrival_City_IataCode = '{$iataCode}' ";
        $result = $ModelBase->load($sql);
        if ($result['Departure_City_IataCode'] == $iataCode) {
            return $result['Departure_City'];
        } else {
            return $result['Arrival_City'];
        }

    }

    public function listBaseCompanyBus($typeVehicle = null) {

        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT * FROM  base_company_bus_tb WHERE is_del = 'no' ";
        if (isset($typeVehicle) && $typeVehicle != '') {
            $sql .= "  AND type_vehicle = '{$typeVehicle}' ";
        }
        return $ModelBase->select($sql);

    }

    public function getNameBaseCompany($id) {

        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT * FROM  base_company_bus_tb WHERE id = '{$id}' AND is_del = 'no' ";
        $result = $ModelBase->load($sql);
        return $result['name_fa'];

    }

    public function getBusCompany($id) {

        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT * FROM  base_company_bus_tb WHERE id = '{$id}' AND is_del = 'no' ";
        $result = $ModelBase->load($sql);
        return $result;

    }

    public function deleteBusTicketPriceChanges($id) {

        $Model = Load::library('Model');

        $data['is_del'] = 'yes';
        $condition = " id = '{$id}' ";
        $Model->setTable('bus_ticket_price_changes_tb');
        $res = $Model->update($data, $condition);

        if ($res) {
            return 'success : حذف تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در حذف تغییرات';
        }

    }


    public function listCompanyBus($id) {

        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT * FROM company_bus_tb WHERE is_del = 'no' AND id_base_company = '{$id}' ";
        $result = $ModelBase->select($sql);
        return $result;

    }


}

?>
