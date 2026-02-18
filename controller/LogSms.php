<?php

class LogSms
{
    public $ResultSelectForEdit;

    public function __construct()
    {

    }


    #region ListLogSms
    public function ListLogSms()
    {
        $ModelBase = Load::library('ModelBase');

        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);

        if (TYPE_ADMIN == '1') {
            $queryLog = "SELECT Log.*,Clients.AgencyName FROM log_sms_tb AS Log
                          LEFT JOIN clients_tb AS Clients ON Clients.id=Log.ClientId WHERE 1=1 ";


            if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {

                $date_of = explode('-', $_POST['date_of']);
                $date_to = explode('-', $_POST['to_date']);
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
                $queryLog .= "  AND Log.CreationDateInt >= '{$date_of_int}' AND Log.CreationDateInt  <= '{$date_to_int}'";
            } else {
                $queryLog .= "  AND Log.CreationDateInt >= '{$date_now_int_start}' AND Log.CreationDateInt <= '{$date_now_int_end}'";
            }

            if ($_POST['ClientId']) {
                $queryLog .= " AND Log.ClientId = '{$_POST['ClientId']}'";
            }
            if ($_POST['Mobile']) {
                $queryLog .= " AND Log.Mobile = '{$_POST['Mobile']}'";
            }


            $queryLog .= "ORDER BY Log.CreationDateInt DESC";

        } else {
            $ClientId = CLIENT_ID;
            $queryLog = "SELECT * FROM log_sms_tb AS Log WHERE ClientId='{$ClientId}'";


            if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {

                $date_of = explode('-', $_POST['date_of']);
                $date_to = explode('-', $_POST['to_date']);
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
                $queryLog .= "  AND Log.CreationDateInt >= '{$date_of_int}' AND Log.CreationDateInt  <= '{$date_to_int}'";
            } else {
                $queryLog .= "  AND Log.CreationDateInt >= '{$date_now_int_start}' AND Log.CreationDateInt <= '{$date_now_int_end}'";
            }

            if ($_POST['Mobile']) {
                $queryLog .= " AND Mobile = '{$_POST['Mobile']}'";
            }


            $queryLog .= "ORDER BY CreationDateInt DESC";
        }
        $resultLog = $ModelBase->select($queryLog);

        return $resultLog;
    }
    #endregion

    #region viewLog
    public function viewLog($id, $ClientId)
    {
        $ModelBase = Load::library('ModelBase');
        echo $queryLog = "SELECT Content FROM log_sms_tb  WHERE id='{$id}' AND ClientId='{$ClientId}'";
        $resultLog = $ModelBase->Load($queryLog);
        return $resultLog;
    }
    #endregion
}