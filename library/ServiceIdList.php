<?php

class ServiceIdList
{
    public $serviceId;
    public $encryptedData;
    public $userName;
    public $ServiceRequestDate;



    public function setServiceId($value)
    {
        $this->serviceId = $value;
    }

    public function getServiceId()
    {
        return $this->serviceId;
    }



    public function setEncryptedData($value)
    {
        $this->encryptedData = $value;
    }

    public function getEncryptedData()
    {
        return $this->encryptedData;
    }



    public function setUserName($value)
    {
        $this->userName = $value;
    }

    public function getUserName()
    {
        return $this->userName;
    }



    public function setServiceRequestDate($value)
    {
        $this->ServiceRequestDate = $value;
    }

    public function getServiceRequestDate()
    {
        return $this->ServiceRequestDate;
    }
}