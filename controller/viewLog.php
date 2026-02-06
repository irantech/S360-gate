<?php

class viewLog
{

    public function __construct()
    {

    }


    public function showLog()
    {
        $Model = Load::library('Model');

        $jdate = dateTimeSetting::jdate("Y/m/d", time());
        $ex = explode("/", $jdate);
        for ($i = 11; $i >= 0; $i--) {
            $Timenow = dateTimeSetting::jmktime(0, 0, 0, $ex[1], $ex[2], $ex[0]) - (($i) * (24 * 60 * 60));

            $CalculateTimeUnix = dateTimeSetting::jmktime(23, 59, 59, $ex[1], $ex[2], $ex[0]);

            $TimeCalc = $CalculateTimeUnix - (($i) * (24 * 60 * 60));

//            echo 'timeNow='.dateTimeSetting::jdate("Y/m/d H:i:s", $Timenow);
//            echo '<br />';
//            echo 'TimeCalc='.dateTimeSetting::jdate("Y/m/d H:i:s", $TimeCalc);
//            echo '<br />';

            $Sql = "SELECT COUNT(*) AS CountView FROM log_view_tb WHERE creation_date_int >= $Timenow AND creation_date_int < $TimeCalc";
            $Log[] = $Model->load($Sql);
        }

        return $Log;

    }
}