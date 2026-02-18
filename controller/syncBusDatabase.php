<?php

class syncBusDatabase extends syncServiceDatabase
{

    protected function setTable() {
        $this->model = $this->getModel('reportBusModel');
        $this->table = $this->model->getTable();
        $this->time_field = 'creation_date_int';
        $this->request_number_field = 'order_code';
    }
}