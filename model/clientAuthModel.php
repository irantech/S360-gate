<?php


class clientAuthModel extends ModelBase {
    protected $table = 'client_auth_tb';
    protected $pk = 'id';

    public function getAccessServiceClient($clientId = null,$MainService=null) {

        $clientId = empty($clientId) ? CLIENT_ID : $clientId ;
        $searchByMainService='';
        if($MainService){
            $searchByMainService="AND services_group.MainService = '{$MainService}'";
        }

        $sql = "SELECT 
                      services_group.Title,
                      services_group.id,
                      services_group.MainService,
                      services_order.order_number
                  FROM 
                      {$this->table} AS AUTH 
                      INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                      INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                      INNER JOIN services_group_tb AS services_group ON services_group.id = SERVICE.ServiceGroupId 
                      LEFT JOIN search_service_order_tb AS services_order ON services_order.service_group_id = SERVICE.ServiceGroupId AND services_order.client_id = '{$clientId}'
                  WHERE 
                     AUTH.ClientId = '{$clientId}' 
                    AND AUTH.IsActive='Active'
                  {$searchByMainService}
                  GROUP BY
	                SERVICE.ServiceGroupId
                  ORDER BY 
                    services_order.order_number IS NULL , services_order.order_number";



        return parent::select($sql);
    }
    public function sortArrayByOrderNumber($array) {
        usort($array, function($a, $b) {
            if ($a['order_number'] == $b['order_number']) {
                // If order numbers are equal, compare by 'id'
                return $a['id'] - $b['id'];
            } else {
                // Sort by 'order_number'
                return $a['order_number'] - $b['order_number'];
            }
        });
        return $array;
    }

    public function addPackageToServices($services) {
        $has_flight=false;
        $has_hotel=false;
        foreach ($services as $service) {
            if($service['MainService']==='Flight')
                $has_flight=true;
            if($service['MainService']==='Hotel')
                $has_hotel=true;
        }
        if($has_flight && $has_hotel)
            $services[]=[
                'Title'=>'پرواز + هتل',
                'MainService'=>'Package',
                'order_number'=>'2'
            ];

        return $this->sortArrayByOrderNumber($services);
    }
    public function checkAccessServiceClient($clientId, $service) {
        $sql = "SELECT 
                      services_group.Title,
                      services_group.id,
                      services_group.MainService,
                      services_order.order_number
                  FROM 
                      {$this->table} AS AUTH 
                      INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                      INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                      INNER JOIN services_group_tb AS services_group ON services_group.id = SERVICE.ServiceGroupId 
                      LEFT JOIN search_service_order_tb AS services_order ON services_order.service_group_id = SERVICE.ServiceGroupId AND services_order.client_id = '{$clientId}'
                  WHERE 
                     AUTH.ClientId = '{$clientId}' AND SERVICE.Service = '{$service}' AND AUTH.IsActive='Active'
                  GROUP BY
	                SERVICE.ServiceGroupId
                  ORDER BY 
                    SERVICE.id";

        return parent::select($sql);
    }

}