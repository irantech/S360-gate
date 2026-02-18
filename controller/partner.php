<?php

//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

/**
 * Class partner
 * @property partner $partner
 */


class partner extends clientAuth
{

    public $list;

    public function __construct(){
            parent::__construct();
    }
	

    /**
     * @return bool|mixed|servicesModel
     */
    public function servicesModel()
    {
        return Load::getModel('servicesModel');
    }
    /**
     * @return bool|mixed|clientWhiteCommissionModel
     */
    public function clientWhiteCommissionModel()
    {
        return Load::getModel('clientWhiteCommissionModel');
    }

    /**
     * @return admin|bool|mixed|services
     */
    public function servicesController()
    {
        return Load::controller('services');
    }

    public function archivedClients()
    {
        $partner = Load::model('partner');
        return $partner->getAllArchived();
    }

    public function archive($param)
    {

        $partner = Load::model('partner');
        $result = $partner->archive($param['client_id']);

        return functions::JsonSuccess([],[
            'message' => $result['message'],
        ], $result['status']);
    }

    public function unarchive($param)
    {
        $partner = Load::model('partner');
        $result = $partner->unarchive($param['client_id']);
        return functions::JsonSuccess([],[
            'message' => $result['message'],
        ], $result['status']);

    }
    public function index()
    {

        $partner = Load::model('partner');

        return $partner->getAll();

    }

    /**
     * @param $id
     * @return mixed
     */
    public function infoClient($id)
    {
        return $this->getModel('clientsModel')->get()->where('id',$id)->find();
    }

    public function isIframeClient($id)
    {
        $infoClient = $this->infoClient($id);
        return $infoClient['isIframe'];
    }

    /**
     * @return array
     */
    public function allClients()
    {
        return $this->getModel('clientsModel')->get()->where('Type', '1', '>')->where('id', '1', '>')->all();
    }

    /**
     * @return array
     * @throws Exception
     */
    public function allClientsGroupByDbName()
    {
        return $this->getModel('clientsModel')->get()->where('Type', '1', '>')->where('id', '1', '>')->groupBy('DbName')->orderBy('id')->all();
    }

    /**
     * @param $client_id_parent
     * @return array
     */
    public function subClient($client_id_parent)
    {

        return $this->getModel('clientsModel')->get()->where('parent_id',$client_id_parent)->all();
    }
    /**
     * @return bool|mixed|servicesGroupModel
     */
    public function servicesGroupModel()
    {
        return Load::getModel('servicesGroupModel');
    }
    public function InsertClient($data)
    {

        $partner = Load::model('partner');

        return $partner->InsertClientModel($data);
    }


    public function UpdateClient($data)
    {

        $partner = Load::model('partner');

        return $partner->UpdateClientModel($data);
    }


    public function showedit($id){
        if (isset($id) && !empty($id)) {
            $client = $this->infoClient($id);
            if (!empty($client)) {
                $this->list = $client;
            } else {
               functions::redirectTo404InAdmin();
            }
        } else {
            functions::redirectTo404InAdmin();
        }
    }

    public function countBuy($client_id){
        $result_count_buy = $this->getController('reportFlight')->countBuySpecificClient($client_id);
        return $result_count_buy['count_buy_client'];

    }


    public function countPeople($id)
    {


        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $edit_query = " SELECT count(request_number) AS Countreq FROM  report_tb  WHERE client_id='{$id}' AND (successfull='book' OR successfull='private_reserve') ";
        $res_edit = $ModelBase->load($edit_query);

        if (!empty($res_edit)) {
            return $res_edit['Countreq'];

        }
    }

    public function historyLoginClients()
    {
        $clients = $this->index();

        $admin = Load::controller('admin');
        foreach ($clients as $key => $client) {

            $clientLog[] = $admin->lastLoginClient($client['id']);
            $clientLog[$key]['agencyName'] = $client['AgencyName'];
        }
        $ShowClientLog = array();
        foreach ($clientLog as $key => $row) {

            $ShowClientLog['creation_date_int'][$key] = $row['creation_date_int'];

        }

        array_multisort($ShowClientLog['creation_date_int'], SORT_DESC, $clientLog);


        return $clientLog;
    }

    /**
     * @param $client_id
     * @return array
     */
    public function getGroupListServicesClient($client_id)
    {
        return $this->servicesController()->getGroupListServicesClient($client_id);
    }

    /**
     * @param $type
     * @return bool|mixed|string
     */
    public function getServicesClients($type)
    {
        return $this->servicesController()->servicesListClient($type);
    }

    /**
     * @param $data
     * @return bool|mixed|string
     */
    public function insertCommissionClient($data)
    {
        $commissionExist = $this->clientWhiteCommissionModel()->get()->where('client_id', $data['client_id'])->
        where('client_id_parent', $data['client_id_parent'])->
        where('type', $data['type'])->
        where('detail_type', $data['detail_type'])->find();

        if (!$commissionExist || ($commissionExist && !empty($commissionExist['deleted_at']))){
           $resultInsertCommissionClient =  $this->clientWhiteCommissionModel()->insertWithBind($data);

           if(!$resultInsertCommissionClient)
           {
               return functions::withError('', 400, 'خطا در تعریف کمیسیون');
           }
            return functions::withSuccess('',200,'کمیسیون با موفقیت تنظیم شد');
        }

        return functions::withError('', 400, 'امکان تعریف کمیسیون تکراری وجود ندارد');
    }

    /**
     * @param $client_id
     * @return array
     * @throws Exception
     */
    public function listClientCommission($client_id)
    {
        $clientTable = $this->getModel('clientsModel')->getTable();
        $servicesGroupTable= $this->servicesGroupModel()->getTable();
        $servicesTable= $this->servicesModel()->getTable();


        return $this->clientWhiteCommissionModel()->get(["*", "{$clientTable}.AgencyName","{$servicesGroupTable}.title"
        ,"{$servicesTable}.TitleFa"])
            ->join($clientTable, 'id', 'client_id', 'LEFT')
            ->join($servicesGroupTable, 'MainService', 'type', 'LEFT')
            ->join($servicesTable, 'TitleEn', 'detail_type', 'LEFT')
            ->where('client_id_parent', $client_id)
            ->all(true);
    }




    /**
     * @return mixed
     * @throws Exception
     */
    public function getInfoTransaction() {
        $clients = $this->allClientsGroupByDbName();
        $total_remaining_credit_clients = 0 ;
        $charge_today = 0 ;
        $buy_to_day = array();
        foreach ($clients as $client) {

            $info_transaction =$this->getController('transaction')->allTransactionOneClient($client['id']);

            foreach ($info_transaction as $key =>$transaction_day) {
                $charge_today[$key] = ($charge_today + $transaction_day['charge_today']) ;
                $total_remaining_credit_clients[$key] =($total_remaining_credit_clients + ($info_transaction['remaining']));
                $buy_to_day[$key] = $this->getController('bookshow')->getListBuyFlightToday($key);
            }
        }

        $data['total_remaining_credit_clients'] = $total_remaining_credit_clients ;
        $data['charge_today_credit_clients'] = $charge_today ;
        $data['buy_to_day'] = $buy_to_day;
        return $data ;
    }

    public function getPartnerWhiteLabel() {
        return $this->getModel('clientsModel')->getPartnerWhiteLabel();
    }

    public function ListClientActive()
    {
        // گرفتن لیست آژانس‌ها از کنترلر settingCore
        $ListAllAgencyCore = Load::controller('settingCore')->ListAllAgency();

        // استخراج فقط فیلد name
        $agencyNames = [];
        foreach ($ListAllAgencyCore as $agency) {
            $agencyNames[] = $agency['name'];
        }

        // کوئری با whereIn
        $List = $this->getModel('clientsModel')
            ->get(['id', 'clients_tb.AgencyName', 'clients_tb.MainDomain', 'CAU.Username'])
            ->joinSimple(
                ['client_auth_tb', 'CAU'],
                'CAU.ClientId',
                'clients_tb.id',
                'LEFT'
            )
            ->where('clients_tb.archived_at', null, 'IS')
            ->whereIn('CAU.Username', $agencyNames)
            ->groupBy('clients_tb.id')
            ->orderBy('clients_tb.AgencyName', 'ASC')
            ->all();
        return $List;
    }
}

