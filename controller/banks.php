<?php

class banks extends clientAuth
{
    public function __construct(){
        parent::__construct();
    }


    public function getBankList(){

        return $this->getModel('banksModel')->get(['id','title'],true)->all();
    }
}