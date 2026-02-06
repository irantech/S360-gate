<?php
/**
 * Created by PhpStorm.
 * User: AbbasPC
 * Date: 3/4/2019
 * Time: 11:56 AM
 */

/**
 * Class cashResultSearchFlight
 * @property cashResultSearchFlight $cashResultSearchFlight
 */
class cashResultSearchFlight
{

    public function __construct()
    {

    }

    public function ProgressCashFlight($Origin, $Destination, $DateFlight, $Code, $DataResultSearch)
    {

        error_log('ProgressCashFlight time start : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');
        $ModelBase = Load::library('ModelBase');

        $DateFlightExplode = explode('-', $DateFlight);
        $DateFlightInt = dateTimeSetting::jmktime('0', '0', '0', $DateFlightExplode[1], $DateFlightExplode[2], $DateFlightExplode[0]);


        $SqlCash = " SELECT * FROM log_search_cash_tb WHERE Origin='{$Origin}' AND Destination='{$Destination}'  ORDER BY id DESC LIMIT 1";
        $ResultSqlCash = $ModelBase->load($SqlCash);

        $TimeIndicator =  (60 * 30);
        $TimeNow = time();


        if ((!empty($ResultSqlCash) && ($TimeNow - $ResultSqlCash['DateSearchInt']) > $TimeIndicator) || empty($ResultSqlCash)) {
            $data['Code'] = $Code;
            $data['Origin'] = $Origin;
            $data['Destination'] = $Destination;
            $data['DateSearchInt'] = time();
            $data['DateSearch'] = dateTimeSetting::jdate("Y-m-d H:i:s", time(),'','','en');
            $data['DateFlightInt'] = $DateFlightInt;
            $data['DateFlight'] = $DateFlight;

            $ModelBase->setTable('log_search_cash_tb');
            $ResultSearchCash = $ModelBase->insertLocal($data);

            if ($ResultSearchCash) {

                $dataContent['SearchId'] = $ModelBase->getLastId();
                $dataContent['ContentSearch'] = $DataResultSearch;


                $ModelBase->setTable('log_content_cash_tb');
                $ModelBase->insertLocal($dataContent);
            }
        }
        error_log('ProgressCashFlight time End : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');
    }
}