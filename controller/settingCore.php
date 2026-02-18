<?php
/**
 * Class settingCore
 * @property settingCore $settingCore
 */

class settingCore
{
    public $apiAddress;
    public function __construct(){
        if ((isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], '192.168.1.100') !== false) || (isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], 'online.1011.ir') !== false) || (isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], '1011.ir') !== false) || (isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], 'localhost') !== false)) {//local
//            $this->apiAddress = functions::UrlSource();
            $this->apiAddress = 'http://safar360.com/CoreTestDeveloper';
        } else {
            $this->apiAddress = 'http://safar360.com/Core';
        }
    }

    public function ListAgency()
    {
        $dataSend['Method'] = 'listAgency' ;
        $data = json_encode($dataSend);
        $url =$this->apiAddress. "/baseFile/agency/";
        return functions::curlExecution($url,$data,'yes');
    }
    public function ListAllAgency()
    {
        $dataSend['Method'] = 'listAllAgency' ;
        $data = json_encode($dataSend);
        $url =$this->apiAddress. "/baseFile/agency/";
        return(functions::curlExecution($url,$data,'yes'));
    }

    public function ListServer()
    {
        $dataSend['Method'] = 'listServer' ;
        $data = json_encode($dataSend);
        $url = $this->apiAddress."/baseFile/source/";
        return functions::curlExecution($url,$data,'yes');
    }

    public function listUserAgency()
    {
        $dataSend['Method'] = 'listSourceAgency' ;
        $data = json_encode($dataSend);

        $url = $this->apiAddress."/baseFile/sourceUser/";

        return functions::curlExecution($url,$data,'yes');
    }

    public function listAgencyById($id)
    {
        $dataSend['Method'] = 'listAgencyById' ;
        $dataSend['id'] = $id ;
        $data = json_encode($dataSend);

        $url = $this->apiAddress."/baseFile/agency/";

        return functions::curlExecution($url,$data,'yes');
    }
    public function listAgencyByName($name)
    {
        $dataSend['Method'] = 'listAgencyByName' ;
        $dataSend['name'] = $name ;
        $data = json_encode($dataSend);

        $url = $this->apiAddress."/baseFile/agency/";

        return functions::curlExecution($url,$data,'yes');
    }

    public function getInfoAgencySource($agencyId)
    {
        $dataSend['Method'] = 'getInfoAgencySource' ;
        $dataSend['agencyId'] = $agencyId ;
        $data = json_encode($dataSend);
        $url = $this->apiAddress."/baseFile/sourceUser/";
        return functions::curlExecution($url,$data,'yes');
    }

    public function getInfoAgencySourceByUserName($username)
    {
        $dataSend['Method'] = 'getInfoAgencySourceByUserName' ;
        $dataSend['username'] = $username ;
        $data = json_encode($dataSend);
        $url = $this->apiAddress."/baseFile/sourceUser/";
        return functions::curlExecution($url,$data,'yes');
    }

    public function infoSourceAgency($agencyId,$SourceId)
    {
        $dataSend['Method'] = 'infoSourceAgency' ;
        $dataSend['agencyId'] = $agencyId ;
        $dataSend['sourceId'] = $SourceId ;

        $data = json_encode($dataSend);

        $url = $this->apiAddress."/baseFile/sourceUser/";

        return functions::curlExecution($url,$data,'yes');
    }


    public function getAllSourceCore() {
        $dataSend['Method'] = 'allSource' ;

        $data = json_encode($dataSend);

        $url = $this->apiAddress."/baseFile/source/";

        return functions::curlExecution($url,$data,'yes');
    }


    public function insertPidNira($params) {
        $dataSend = $params ;
        $dataSend['Method'] = 'insertAirlineNira' ;

        $data = json_encode($dataSend);

        $url = $this->apiAddress."/baseFile/sourceUser/";

        $result_pid = functions::curlExecution($url,$data,'yes') ;
        return functions::withSuccess($result_pid,200,'اطلاعات با موفقیت دریافت شد');
    }

    public function listAirlineNira($params) {
        $dataSend = $params ;
        $dataSend['Method'] = 'listAirlineNira' ;

        $data = json_encode($dataSend);

        $url = $this->apiAddress."/baseFile/sourceUser/";

       return functions::curlExecution($url,$data,'yes') ;

    }

    public function changeStatusPidAgency($params) {
        $dataSend = $params ;
        $dataSend['Method'] = 'changeStatusPidAgency' ;

        $data = json_encode($dataSend);

        $url = $this->apiAddress."/baseFile/sourceUser/";

        $result_change =  functions::curlExecution($url,$data,'yes') ;

        return functions::withSuccess($result_change,200,'اطلاعات با موفقیت دریافت شد');

    }
    public function insertSubAgencyCore($data) {
        $url = $this->apiAddress . "/baseFile/agency/";
        $data['Method'] = 'insertSubAgency';
        $resultInsertSubAgencyCore = functions::curlExecution( $url, json_encode($data), 'yes' );
        return $resultInsertSubAgencyCore;
    }

    public function editSubAgencyCore($data) {
        $url = $this->apiAddress . "/baseFile/agency/";
        $data['Method'] = 'editSubAgency';
        $resultEditSubAgencyCore = functions::curlExecution( $url, json_encode($data), 'yes' );
        return $resultEditSubAgencyCore;
    }

    public function deleteSubAgencyCore($data) {
        $url = $this->apiAddress . "/baseFile/agency/";
        $data['Method'] = 'deleteSubAgency';
        $resultDeleteSubAgencyCore = functions::curlExecution( $url, json_encode($data), 'yes' );
        return $resultDeleteSubAgencyCore;
    }
    public function SourceStatusCore($SourceId,$isActive)
    {
        $dataSend['Method'] = 'SourceStatusCore' ;
        $dataSend['SourceId'] = $SourceId ;
        $dataSend['isActive'] = $isActive ;
        $data = json_encode($dataSend);
        $url =$this->apiAddress. "/baseFile/agency/";
        return functions::curlExecution($url,$data,'yes');
    }
    public function saveSourceCore($data,$SourceId)
    {
        $dataSend = [
            'Method' => 'saveSourceCore',
            'Data' => $data,
            'SourceId' => $SourceId
        ];
        $data = json_encode($dataSend);
        $url =$this->apiAddress. "/baseFile/agency/";
        return functions::curlExecution($url,$data,'yes');
    }
    public function insertAjency($data)
    {
        $url = $this->apiAddress . "/baseFile/agency/";
        $data['Method'] = 'InsertAgency';
        $resultInsertSubAgencyCore = functions::curlExecution( $url, json_encode($data), 'yes' );
        return $resultInsertSubAgencyCore;
    }

}