<?php

class smsNotification extends baseController
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->getModel('smsNotificationModel');
    }

    /**
     * @param $name
     * @param $service
     * @return mixed
     */
    public function getNotification($name, $service)
    {
        return $this->model->get()->where('name', $name)->where('service', $service)->find();
    }
}