<?php

class syncVisaDatabase extends syncServiceDatabase
{
    protected function setTable() {
        $this->model = $this->getModel('reportVisaModel');
        $this->table = $this->model->getTable();
        $this->time_field = 'creation_date_int';
        $this->request_number_field = 'factor_number';
    }
}