<?php

class apiCodeExistModel extends Model
{
    public function __construct()
    {
        parent::__construct();

        $this->table = 'api_code_exists_tb';
        $this->pk = 'id';
    }

}