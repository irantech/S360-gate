<?php

require '../config/bootstrap.php';
require CONFIG_DIR . 'configBase.php';
require LIBRARY_DIR . 'Load.php';
require LIBRARY_DIR . 'functions.php';
spl_autoload_register(array('Load', 'autoload'));

class serviceVoteSms 
{

    protected $flight='flight';
    protected $hotel='hotel';
    protected $bus='bus';
    protected $train='train';
    protected $tour='tour';
    protected $targetController;
    protected $targetTable;
    protected $targetField;
    protected $successTitle;
    protected $endDateService;
    protected $factorNumber;
    protected $dateFormat;

    private $ModelBase;
    private $yesterday;
    private $admin;
    private $smsServices;
    protected $serviceName;

    public function __construct() {



        $this->ModelBase = Load::library('ModelBase');
        $this->admin = Load::controller('admin');
        $this->smsServices = Load::controller('smsServices');
        


        $this->serviceVoteSms();


    }

    public function initialize($serviceName) {
        $this->serviceName=$serviceName;
        $this->getTargetClasses($serviceName);
    }

    private function getTargetClasses($serviceName) {
        $timestampYesterday = strtotime('-1 day');
        try {
            switch ($serviceName) {
                case $this->flight:
                    $this->serviceName= 'پرواز';
                    $this->targetTable='book_local_tb';
                    $this->targetField='successfull';
                    $this->successTitle='book';
                    $this->endDateService='date_flight';
                    $this->factorNumber='factor_number';
                    $this->yesterday=date('Y-m-d' , $timestampYesterday);
                    break;
                case $this->hotel:
                    $this->serviceName= 'هتل';
                    $this->targetTable='book_hotel_local_tb';
                    $this->targetField='status';
                    $this->successTitle='BookedSuccessfully';
                    $this->endDateService='end_date';
                    $this->factorNumber='factor_number';
                    $this->yesterday= dateTimeSetting::jdate("Y-m-d", $timestampYesterday, '', '', 'en');;
                    break;
                case $this->bus:
                    $this->serviceName= 'اتوبوس';
                    $this->targetTable='book_bus_tb';
                    $this->targetField='status';
                    $this->successTitle='book';
                    $this->endDateService='DateMove';
                    $this->factorNumber='passenger_factor_num';
                    $this->yesterday= dateTimeSetting::jdate("Y-m-d", $timestampYesterday, '', '', 'en');;
                    break;
                case $this->train:
                    $this->serviceName= 'قطار';
                    $this->targetTable='book_train_tb';
                    $this->targetField='successfull';
                    $this->successTitle='book';
                    $this->endDateService='ExitDate';
                    $this->factorNumber='factor_number';
                    $this->yesterday= date('Y-m-d' , $timestampYesterday);
                    break;
                case $this->tour:
                    $this->serviceName= 'تور';
                    $this->targetTable='book_tour_local_tb';
                    $this->targetField='status';
                    $this->successTitle='BookedSuccessfully';
                    $this->endDateService='tour_end_date';
                    $this->factorNumber='factor_number';
                    $this->yesterday= dateTimeSetting::jdate("Y/m/d", $timestampYesterday, '', '', 'en');
                    break;
            }
        }catch (Exception $e){

        }

    }

    private function serviceVoteSms() {
      
        $configuration_list = [
            [
                'access_name'    => 'flight_vote_sms',
                'service_name'   => 'flight'
            ],
            [
                'access_name'    => 'hotel_vote_sms',
                'service_name'   => 'hotel'
            ],
            [
                'access_name'    => 'bus_vote_sms',
                'service_name'   => 'bus'
            ],
            [
                'access_name'    => 'train_vote_sms',
                'service_name'   => 'train'
            ],
            [
                'access_name'    => 'tour_vote_sms',
                'service_name'   => 'tour'
            ]
        ];
        $client_list = functions::hasVoteSmsAccess()   ;

        if(count($client_list) > 0) {
            $client_list = $this->getClients($client_list);

            foreach ($client_list as $key => $client) {
               
                $objSms = $this->smsServices->initService('0', $client['id']);
                if($objSms){
                    $sqlMessage = "SELECT * FROM sms_message_tb WHERE isActive = 'yes' AND smsUsage='serviceVote'";
                    $resultMessage = $this->admin->ConectDbClient($sqlMessage, $client['id'], 'Select', '', '', '');
                    
                    if(!empty($resultMessage)) {
                        foreach ($configuration_list as $counter => $access) {
                            
                            if (functions::checkClientConfigurationAccess($access['access_name'], $client['id'])) {
                                $this->initialize($access['service_name']);

                                $sqlBook = "SELECT * FROM {$this->targetTable} WHERE {$this->targetField} = '{$this->successTitle}' AND {$this->endDateService} = '{$this->yesterday}' GROUP By {$this->factorNumber}";

                                $resultBook = $this->admin->ConectDbClient($sqlBook, $client['id'], 'SelectAll', '', '', '');

                                foreach ($resultBook as $book){
                               
                                    $passenger_name  = ($book['passenger_name'] ? $book['passenger_name'] : $book['passenger_name_en']) . ' ' . ($book['passenger_family'] ? $book['passenger_family'] : $book['passenger_family_en']);
                                    $messageVariables = array(
                                        'sms_name'      => $passenger_name,
                                        'sms_service'    => $this->serviceName ,
                                        'sms_agency'    => $client['AgencyName'] ,
                                        'sms_site_url'     => 'https://' .$client['MainDomain']. '/gds/fa/vote',
                                    );

                                    $smsArray = array(
                                        'smsMessage' => $this->smsServices->getUsableMessage('serviceVote', $messageVariables),
                                        'cellNumber' => $book['member_mobile'],
                                        'smsMessageTitle' => 'service vote sms',
                                        'memberID' => $book['member_id'],
                                        'receiverName' => $messageVariables['sms_name'],
                                    );
                                   
                                    $this->smsServices->sendSMS($smsArray);
                                    $this->errorLog('sms service to ' . $passenger_name . ' for ' . $this->serviceName .'  on ' . $this->yesterday);

                                }
                            }
                        }
                    }
                }

            }
        }

    }

    #region errorLog
    public function errorLog($content)
    {
        error_log(date('Y/m/d H:i:s') . ' ' . $content . " \n", 3, LOGS_DIR . 'log_voteServiceSms.txt');
    }
    #endregion

    public function getClients($client_list)
    {

        $client_list = join(",",$client_list);
        $sqlClients ="SELECT * FROM clients_tb WHERE id in ($client_list)";

        return $this->ModelBase->select($sqlClients);
    }
}

new serviceVoteSms();