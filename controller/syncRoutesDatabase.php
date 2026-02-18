<?php

class syncRoutesDatabase extends syncServiceDatabase
{

    protected function setTable() {
        $this->model = $this->getModel('reportRoutesModel');
        $this->table = $this->model->getTable();
        $this->request_number_field = 'RequestNumber';
        $this->time_field = 'RequestNumber';
        $this->default_init_time = '14020409000000000000000';
    }
}