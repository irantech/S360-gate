<?php

//error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
require CONFIG_DIR . 'config.php';
require './config/bootstrap.php';
require LIBRARY_DIR . 'Jalali.php';
//error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
// @ini_set('display_errors', 1);
// @ini_set('display_errors', 'on');


class userListApi
{


    public $success = "success";
    public $error = "error";
    public $model;

    public function __construct()
    {

    }


    public function listUser($content, $hash)
    {

        if ($content == $hash) {
            Load::autoload('Model');

            $this->model = new Model();

            $sql = "SELECT name,family,mobile,telephone,email,password,gender,birthday,address,marriage,is_member FROM members_tb";

            $result = $this->model->select($sql, "assoc");

            $message = array("Data" => array("Status" => $this->success, "Result" => $result));

            echo json_encode($message);

        } else {
            $message = array("Data" => array("Status" => $this->error, "Result" => "not found api"));
            echo json_encode($message);
        }

    }

    function test()
    {

        $item = "";


        Load::autoload('Model');

        $this->model = new Model();


        $sql = "SELECT * FROM robot_tb WHERE id='1'";


        $result = $this->model->select($sql, "assoc");
        $result = $result[0];

        $query = "SELECT * FROM robot_list_ticket_tb WHERE FkRobotId='1' AND status='1'";
        $query = $this->model->select($query, "assoc");

        $data = [
            'chat_id' => "-" . $result['chat_id'],
            'title' => "<b> لیست پرواز های   </b>",
            'brand' => "<b> ایران تکنولوژی </b>"
        ];


        $date = date("Y-m-d", time());
        $date = explode("-", $date);
        $t = gregorian_to_jalali($date[0], $date[1], $date[2]);
        $t = $t[0] . "-" . $t[1] . "-" . $t[2];

        foreach ($query as $key => $value) {

            $url = "api.hiholiday.ir/V4/Flight/CalendarRoute/c4463bb2-b13c-46f1-97b9-863a8e7e3a67/" . $value['DepartureCode'] . "/" . $value['ArrivalCode'] . "/" . $t . "/" . $t;

            $total = functions::curlExecution_Get($url, array());

            if (($total['MinPrice'] * 10) != 0) {
                $total = $total['CalendarRoute'][0];
                $price = " " . ($total['MinPrice'] * 10) . " ریال";
                $link = "http://online.starsafar.ir/gds/local/1/" . $value['DepartureCode'] . "-" . $value['ArrivalCode'] . "/" . $t . "/Y/1-0-0/";
                $value['ArrivalCode'] = functions::NameCity($value['ArrivalCode']);
                $value['DepartureCode'] = functions::NameCity($value['DepartureCode']);
                $item .= "<b> پرواز  " . $value['DepartureCode'] . " - " . $value['ArrivalCode'] . $price . "  </b> <a href='" . $link . "'> مشاهده </a> " . urlencode(PHP_EOL);

            }
        }


        $text = $data['title'] . urlencode(PHP_EOL) . $item . $data['brand'];

        $result = functions::CallAPI($result['api_token'], $data["chat_id"], $text, "GET", true);

        $result = json_decode($result, true);

        $item = count($result['result']) != 0 ? $message = array("Data" => array("Status" => $this->success, "Result" => "true")) : $message = array("Data" => array("Status" => $this->success, "Result" => "false"));

        echo json_encode($item);
    }
//    Api Table Member_Tb
    public function ListUserDb()
    {
        $this->model = Load::library('Model');
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if (!empty($data)) {
            if ($data['mobile'] != '') {
                $sql = "SELECT name,family,mobile FROM members_tb WHERE mobile ='{$data['mobile']}' AND is_member='1'";
                $result = $this->model->select($sql);
                   }
                   elseif ($data['email'] != ''){
                $sql = "SELECT name,family,mobile FROM members_tb WHERE email ='{$data['email']}' AND is_member='1'";
                $result = $this->model->select($sql);
                   }
        }else
            {
            $sql = "SELECT name,family,mobile FROM members_tb WHERE is_member='1'";
            $result = $this->model->select($sql);
        }

        if ($result == null){
            echo "کاربری با این مشخصات وجود ندارد";
        }else{
            echo json_encode($result);

        }

    }
    }
$UserList = new userListApi();
$UserList->ListUserDb();