<?php

require '../../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));

class UpdateReportAndBook
{

    public function __construct()
    {

        $content = json_decode(file_get_contents('php://input'), true);

        $this->Update($content);

    }


    public function Update($content)
    {

   
        $admin = Load::controller('admin');
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $report='';
        $bookLocal='';
        $SQl = "SELECT * FROM report_tb WHERE request_Number='{$content[0]['RequestNumber']}'";
        $Client = $ModelBase->load($SQl);

        error_log('try show result method contentM5 in : ' . date('Y/m/d H:i:s') . '  array eqaul in => : ' . json_encode($content, true) . " \n", 3, LOGS_DIR . 'ContentFrom5.txt');

        if(!empty($Client))
        {
            foreach ($content as $result) {
                $data['pnr'] = $result['pnr'];
                $data['eticket_number'] = $result['eTicketNumber'];
                $passenger_national_code = trim($result['national_code']);
                $passportNumber = trim($result['pasportNumber']);
                $request_number = $result['RequestNumber'];
                if($Client['successfull']=='credit')
                {
                    $data['successfull'] ='private_reserve' ;
                }

                $ConditionPlus = (empty($passenger_national_code) || $passenger_national_code=='0000000000')  ? "passportNumber='{$passportNumber}'" : "passenger_national_code='{$passenger_national_code}'";

                $Condition = "request_number='{$request_number}' AND {$ConditionPlus}";

                $ModelBase->setTable('report_tb');
                $report = $ModelBase->update($data, $Condition);
                if($Client['successfull']=='credit')
                {
                    $data['successfull'] ='book' ;
                }
                $bookLocal = $admin->ConectDbClient("", $Client['client_id'], "Update", $data, "book_local_tb", $Condition);


            }

            if ($report && $bookLocal) {
                echo 'Success';
            } else {
                echo 'Error';
            }
        }else{
            echo 'CodeNotExist';
        }


    }

}

new UpdateReportAndBook();