<?php

class syncHotelDatabase extends syncServiceDatabase
{

    protected function setTable() {
        $this->model = $this->getModel('reportHotelModel');
        $this->table = $this->model->getTable();
        $this->time_field = 'creation_date_int';
        $this->request_number_field = 'request_number';
    }
}