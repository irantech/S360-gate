<?php
require '../../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));

class LastLoginClientApi
{
    public function __construct()
    {
        $content = json_decode(file_get_contents('php://input'), true);


        $this->LastLogin($content);

    }

    public function LastLogin($content)
    {
        $admin = Load::controller('admin');
        $ModelBase = Load::library('ModelBase');

        $SqlClient = "SELECT * FROM clients_tb where id <> '1'";
        $results = $ModelBase->select($SqlClient);


        foreach ($results as $key=>$result):


             $sqlBook = " SELECT * FROM log_login_admin_tb ORDER BY id DESC LIMIT 0,1";
            $resultBook = $admin->ConectDbClient($sqlBook, $result['id'], "Select");
           
	    $data['ClientLog'][$key][]= !empty($resultBook) ? dateTimeSetting::jdate("Y-m-d H:i:s",$resultBook['creation_date_int'],"","","en") : 'تاکنون وارد پنل خود نشده است';
            $data['ClientLog'][$key]['ClientName']=functions::ClientName($result['id']);
            $data['ClientLog'][$key]['Domain']=$result['MainDomain'];

        endforeach;

        $message = array(
            "result" => array(
                "Status" => "success",
                "Code" => "1",
                "Message" => "شما با موفقیت وارد سیستم شدید",
                "data" => $data,
            )

        );
        echo json_encode($message, true);



    }


}

new  LastLoginClientApi();