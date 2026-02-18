<?php
require '../config/bootstrap.php';
require CONFIG_DIR . 'configBase.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));

class sendBirthdaySms
{
    #region variables
    private $ModelBase;
    private $admin;
    private $smsServices;
    #endregion

    #region construct
    public function __construct()
    {
        $this->errorLog('cronjob started');

        $this->ModelBase = Load::library('ModelBase');
        $this->admin = Load::controller('admin');
        $this->smsServices = Load::controller('smsServices');

        $this->birthdaySMS();

        $this->errorLog('cronjob ended');
    }
    #endregion

    #region errorLog
    public function errorLog($content)
    {
        error_log(date('Y/m/d H:i:s') . ' ' . $content . " \n", 3, LOGS_DIR . 'log_sendBirthdaySms.txt');
    }
    #endregion

    #region getAllClients
    public function getAllClients()
    {
        $sqlClients ="SELECT * FROM clients_tb WHERE id != '1' AND id != '4'";
        return $this->ModelBase->select($sqlClients);
    }
    #endregion

    #region birthdaySMS
    public function birthdaySMS()
    {
        $clients = $this->getAllClients();
        foreach ($clients as $eachClient){

            $objSms = $this->smsServices->initService('0', $eachClient['id']);
            if($objSms) {

                $this->errorLog($eachClient['AgencyName'] . ' has sms panel');
                $sqlMessage = "SELECT id FROM sms_message_tb WHERE isActive = 'yes' AND smsUsage='birthday'";
                $resultMessage = $this->admin->ConectDbClient($sqlMessage, $eachClient['id'], 'Select', '', '', '');

                if(!empty($resultMessage)) {

                    $this->errorLog($eachClient['AgencyName'] . ' activated birthday sms');
                    $birthday = dateTimeSetting::jdate("m-d",time(),'','','en');

                    $sqlMembers = "SELECT * FROM members_tb WHERE is_member = '1' AND SUBSTRING(birthday,6,5) = '{$birthday}'";
                    $resultMembers = $this->admin->ConectDbClient($sqlMembers, $eachClient['id'], 'SelectAll', '', '', '');

                    $sqlSameID = "SELECT COALESCE((SELECT MAX(sameID) + 1 FROM sms_reports_tb), 1) AS sameID";
                    $resultSameID = $this->admin->ConectDbClient($sqlSameID, $eachClient['id'], 'Select', '', '', '');

                    foreach ($resultMembers as $eachMember){

                        $messageVariables = array(
                            'sms_name' => $eachMember['name'] . ' ' . $eachMember['family'],
                            'sms_username' => $eachMember['email'],
                            'sms_reagent_code' => $eachMember['reagent_code'],
                            'sms_agency' => $eachClient['AgencyName'],
                            'sms_agency_mobile' => $eachClient['Mobile'],
                            'sms_agency_phone' => $eachClient['Phone'],
                            'sms_agency_email' => $eachClient['Email'],
                            'sms_agency_address' => $eachClient['Address'],
                        );
                        $smsArray = array(
                            'smsMessage' => $this->smsServices->getUsableMessage('birthday', $messageVariables),
                            'cellNumber' => $eachMember['mobile'],
                            'smsMessageTitle' => 'birthday',
                            'memberID' => $eachMember['id'],
                            'receiverName' => $messageVariables['sms_name'],
                            'sameID' => $resultSameID['sameID'],
                        );
                        $this->smsServices->sendSMS($smsArray);
                        $this->errorLog('sms birthday to ' . $eachMember['name'] . ' ' . $eachMember['family'] . ' birthday: ' . $eachMember['birthday']);

                    }
                }
            }
        }
    }
    #endregion
}

//declare class
new sendBirthdaySms();
