<?php

class syncGashtDatabase extends syncServiceDatabase
{

    protected function setTable() {
        $this->model = $this->getModel('reportGashtModel');
        $this->table = $this->model->getTable();
        $this->time_field = 'creation_date_int';
        $this->request_number_field = 'passenger_factor_num';
    }
}