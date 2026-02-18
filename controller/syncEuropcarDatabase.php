<?php

class syncEuropcarDatabase extends syncServiceDatabase
{

    protected function setTable() {
        $this->model = $this->getModel('reportEuropcarModel');
        $this->table = $this->model->getTable();
        $this->time_field = 'creation_date_int';
        $this->request_number_field = 'main_reserve_number';
    }
}