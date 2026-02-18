<?php

class syncFlightDatabase extends syncServiceDatabase
{

    protected function setTable() {
        $this->model = $this->getModel('reportModel');
        $this->table = $this->model->getTable();
        $this->time_field = 'creation_date_int';
        $this->request_number_field = 'request_number';
    }

    protected function defaultValue($field, $value) {
        if ($field === 'price_change_type' && $value === '') {
            return 'none';
        }
        return $value;
    }
}