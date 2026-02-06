<?php

class syncDatabase extends baseController
{

    public function __construct() {

    }

    public function fetchService($service, $param) {

        $service_class = $this->getServiceClass($service);



        if ($result=$service_class->fetch($param)) {
            return $result;
        }
    }

    /**
     * @param $service
     * @return syncFlightDatabase
     */
    public function getServiceClass($service) {
        $class_name = 'sync' . ucfirst($service) . 'Database';
        /** @var syncFlightDatabase $service_class */
        return $this->getController($class_name,$service);
    }

    public function syncService($service, $items) {


        $service_class = $this->getServiceClass($service);


        $non_synced = $service_class->getNonSynced($items);

        echo json_encode($non_synced);
        die();

        if ($non_synced) {
//            return $service_class->sync($non_synced);
        }
        return $service.'already synced on sync';
    }
}