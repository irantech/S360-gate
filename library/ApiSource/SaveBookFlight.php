<?php

require '../../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));

class SaveBookFlight
{

    public function __construct()
    {
        $content = json_decode(file_get_contents('php://input'), true);


        $this->SaveRecordBook($content['passengers'],$content['username'],$content['factor_number'],$content['tracking_code_bank']);

    }

    public function SaveRecordBook($content,$username,$FactorNumber,$TrackingCodeBank)
    {

        $admin = Load::controller('admin');

        Load::autoload('ModelBase');

        $ModelBase = new ModelBase();

        $SqlClient = " SELECT * FROM clients_tb WHERE UserNameApi='{$username}'";

        $result = $ModelBase->load($SqlClient);


        if(!empty($result))
        {
            $flag = false;

            foreach ($content as $key => $value)
            {

                $res = $admin->ConectDbClient('', $result['id'], "Insert", $value, "book_local_tb", "");

                if($res)
                {
                    $flag = true ;

                }

            }

            if($flag)
            {
                $this->UpdateSuccessTransaction($FactorNumber,$TrackingCodeBank);
                echo true ;
            }
        }else{
            echo 'کاربر مورد نظر موجود نمی باشد';
        }



    }


    public function UpdateSuccessTransaction($Factor_number,$TrackingCodeBank)
    {
        $admin = Load::controller('admin');


        $Condition =  "FactorNumber = '{$Factor_number}'";

        $data['PaymentStatus'] = 'success';
        $data['BankTrackingCode'] = $TrackingCodeBank;
        $data['PriceDate'] = date("Y-m-d H:i:s");

        $admin->ConectDbClient('', CLIENT_ID, "Update", $data, "transaction_tb", $Condition);

    }
}


new SaveBookFlight();