<?php

class syncTrainDatabase extends syncServiceDatabase
{

    protected function setTable() {
        $this->model = $this->getModel('reportTrainModel');
        $this->table = $this->model->getTable();
        $this->time_field = 'creation_date_int';
        $this->request_number_field = 'requestNumber';
    }
}