<?php
/**
 * Class services
 * @property services $services
 */
class services extends clientAuth
{
    public $modelBase;

    public function __construct()
    {
        parent::__construct();
        $this->modelBase = Load::library('ModelBase');
    }

    /**
     * @return bool|mixed|servicesGroupModel
     */
    public function servicesGroupModel()
    {
        return Load::getModel('servicesGroupModel');
    }

    /**
     * @return bool|mixed|servicesModel
     */
    public function servicesModel()
    {
        return Load::getModel('servicesModel');
    }

    /**
     * @return bool|mixed|clientService
     */
    public function clientServiceModel()
    {
        return Load::getModel('clientService');
    }

    /**
     * @return bool|mixed|clientAuthModel
     */
    public function clientAuthModel()
    {
        return Load::getModel('clientAuthModel');
    }

    public function getAllGroups()
    {
        return $this->getModel('servicesGroupModel')->get()->all();
    }

    public function getAllServices()
    {
        $query = "SELECT S.id, S.TitleEn, S.TitleFa, SG.Title AS groupTitle, SG.MainService AS groupService
                  FROM services_tb S INNER JOIN services_group_tb SG ON S.ServiceGroupId = SG.id
                  GROUP BY S.id";
        return $this->modelBase->select($query);
    }

    public function getServiceByTitle($serviceTitle)
    {
        $serviceTitle = filter_var($serviceTitle, FILTER_SANITIZE_STRING);

        $query = "SELECT S.TitleEn, S.TitleFa, SG.Title AS groupTitle, SG.MainService AS groupService
                  FROM services_tb S INNER JOIN services_group_tb SG ON S.ServiceGroupId = SG.id
                  WHERE S.TitleEn = '{$serviceTitle}'";
        return $this->modelBase->load($query);
    }

    public function getServicesOfAGroup($group)
    {
        $query = "SELECT S.id, S.TitleEn, S.TitleFa, SG.Title AS groupTitle, SG.MainService AS groupService
                  FROM services_tb S INNER JOIN services_group_tb SG ON S.ServiceGroupId = SG.id
                  WHERE SG.MainService = '{$group}'
                  GROUP BY S.id";
        return $this->modelBase->select($query);
    }

    public function getGroupListServicesClient($client_id) {

        $clientServicesTable= $this->clientServiceModel()->getTable();
        $clientAuthTable= $this->clientAuthModel()->getTable();

        return  $this->servicesGroupModel()->get()
            ->join($clientServicesTable,'ServiceGroupId','id','INNER')
        ->join($clientAuthTable,'ServiceId',"id",'INNER',$clientServicesTable)
        ->where("{$clientAuthTable}.ClientId",$client_id)->groupBy('id')->orderBy('id','ASC')->all();
    }

    public function servicesListClient($mainService)
    {
        $mainService = $mainService['type'];
        $servicesGroupTable= $this->servicesGroupModel()->getTable();
        $result_services_client = $this->servicesModel()->get()
            ->join($servicesGroupTable,'id','ServiceGroupId','INNER')
            ->where("{$servicesGroupTable}.MainService",$mainService)
            ->all();
        if(!$result_services_client){
            $messageError = functions::Xmlinformation('errorServicesClient');
            return functions::withError('',404,$messageError);
        }
        return functions::withSuccess($result_services_client,200,'');
    }


    public function getServicesByIdGroup($id) {

        return $this->getModel('servicesModel')->get()->where('ServiceGroupId',$id)->all();
    }
}