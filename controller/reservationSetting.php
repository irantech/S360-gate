<?php

class reservationSetting extends clientAuth {

    public $reservationSettingModel ;
    public function __construct() {
        $this->reservationSettingModel = $this->getModel('reservationSettingModel');
        parent::__construct();
    }

    public function getReservationSetting() {
        return $this->reservationSettingModel->getAll();
    }

    public function getReservationSettingByTitle($title) {

        return $this->reservationSettingModel->getByTitle($title);
    }
    public function getReservationSettingByTitleService($title , $service) {
        return $this->reservationSettingModel->getByTitleService($title , $service);
    }

    public function enable() {
        return $this->reservationSettingModel->enableSetting();
    }

    public function changeEnable($id) {
        return $this->reservationSettingModel->changeEnable($id);
    }

}