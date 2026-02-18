<?php
error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
/**
 * Class ManageTicket
 * @property ManageTicket $ManageTicket
 */
abstract class ManageTicket
{

    public function GetResultTicket($param,$Type)
    {
        $ApiLocal = new apiLocal();
        $Origin ="";
        $Destination="";


        if($param['foreign']=='Local')
        {
            if($Type=='OneWay')
            {
                $Origin = $param['origin'];
                $Destination = $param['destination'];
                $DateFlightDept = $param['dept_date'];
                $DateFlightReturn = '';
            }elseif($Type=='TwoWay'){
                $Origin = $param['destination'];
                $Destination = $param['origin'];
                $DateFlightDept = $param['return_date'];
                $DateFlightReturn = '';
            }

        }else{
            $Origin = $param['origin'];
            $Destination = $param['destination'];
            $DateFlightDept = $param['dept_date'];
            if($Type=='OneWay') {
                $DateFlightReturn = '';
            }else{
                $DateFlightReturn = $param['return_date'];
            }
        }

        $Result = $ApiLocal->getTicket($param['adult'], $param['child'], $param['infant'], $param['classf'], $Origin, $Destination, $DateFlightDept, $param['foreign'],'','',$DateFlightReturn);
        if($param['foreign'] !='Local')
        {
            $unique = json_decode($Result,true);
            $fileDirect = LOGS_DIR . 'cashFlight/' . $unique['UniqueCode'] . '.txt';
            $strJsonFileContents = file_get_contents($fileDirect);
            $strJsonFileContents = json_decode($strJsonFileContents, true);
            $ResultTicket = $strJsonFileContents ;
        }else{
            $ResultTicket = $Result ;
        }
        return $ResultTicket;
    }


    abstract public function ProcessTicket($Param);
    abstract public function ShowUiTicket($Param);




}
