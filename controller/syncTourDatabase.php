<?php

class syncTourDatabase extends syncServiceDatabase
{

    protected function setTable() {
        $this->model = $this->getModel('reportTourModel');
        $this->table = $this->model->getTable();
        $this->time_field = 'creation_date_int';
        $this->request_number_field = 'factor_number';
    }
    protected function defaultValue($field, $value) {
        if ($field === 'passenger_gender' && ($value === '' || $value===null)) {
            return 'Male';
        }
        return $value;
    }
}