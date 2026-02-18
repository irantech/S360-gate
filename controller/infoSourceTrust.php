<?php


class infoSourceTrust
{
    
    public function __construct()
    {
        
    }

    #region curlExecution

    public function curl($url, $username,$password)
    {
        /**
         * This function execute curl with a url & datas
         * @param $url string
         * @param $data an associative array of elements
         * @return json decoded output
         */
        $data = array();
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            'user:'.$username,
            'password:'.$password
        ));
        $result = curl_exec($handle);
        return json_decode($result, true);
    }

    #endregion

    #region ListSourceTrust
    public function ListSourceTrust()
    {
        $ModelBase = Load::library('ModelBase');

          $sql = "SELECT SourceTrust.*,ClientCostumer.AgencyName FROM info_agency_trust_tb AS SourceTrust
                LEFT JOIN clients_tb AS  ClientCostumer ON ClientCostumer.id=SourceTrust.client_id";
        
        $result = $ModelBase->select($sql);

        return $result;
    }
    #endregion
    #region InsertInfoSourceTrust
    public function InsertInfoSourceTrust($data)
    {
        $modelBase = Load::library('ModelBase');

        $modelBase->setTable('info_agency_trust_tb');

        $data['creation_date_int'] = time();
        $res = $modelBase->insertLocal($data);

        if($res){
            return 'success:اطلاعات با موفیقت ثبت شد';
        }else{
            return 'error:اطلاعات با موفیقت ثبت شد';
        }
    }
    #endregion

    #region InfoPid
    public function InfoPid($ClientID)
    {
        $ModelBase = Load::library('ModelBase');

            $sql = "SELECT * FROM info_agency_trust_tb WHERE client_id='{$ClientID}'";
            $Result = $ModelBase->load($sql) ;

            if(!empty($Result))
            {
                $url = "https://safarbooking.com/api/agent/source_list";
                $ResultCurl = $this->curl($url,$Result['username'],$Result['password']);

                if($ResultCurl['err'][0]['code']=='10101')
                {
                    $ResultCurl['error'] = 'AUTH ERROR';
                }else{
                    $ResultCurl['error'] = '';
                }
            }else{
                $ResultCurl['error'] = 'NoPid';
            }



            return $ResultCurl;
    }
    #endregion


}