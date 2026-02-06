<?php
//require CONFIG_DIR . 'config.php';
//require './config/bootstrap.php';
//require LIBRARY_DIR . 'Jalali.php';

class serviceTelegram
{


    public $services = array();
    public $success = "success";
    public $error = "error";
    public $model;


    public function updateTelegram($input)
    {
        $Model = Load::library('Model');

        $dataActive['status'] = 1;
        $dataDeactive['status'] = 0;
        $Model->setTable("robot_list_ticket_tb");


        $input = isset($input['listads']) ? $input['listads'] : [];
        $list = [];

        foreach ($input as $key => $value) {

            $list[] = explode("-", $value);
        }

        if (count($input) > 0) {
            $condition = "FkRobotId='1'";

            $Model->update($dataDeactive, $condition);

            foreach ($list as $key => $value) {

                $condition = " DepartureCode='{$value[0]}' AND ArrivalCode='{$value[1]}'";

                $Model->update($dataActive, $condition);

            }
        }


        return json_encode(array("infoItem" => $input, "size" => count($input)));


    }

    public function changeonlineTelegram($input)
    {
        Load::autoload('Model');
        $Model = new Model();
        $data['status'] = $input['statusitem'];
        $condition = " id='{$input["value"]}'";

        $Model->setTable("robot_list_ticket_tb");

        $Model->update($data, $condition);

        return json_encode(array("infoItem" => $input, "size" => count($input)));


    }

    public function createonlineTelegram($input)
    {
        $Model = Load::library('Model');
        $sql = "SELECT * FROM robot_list_ticket_tb WHERE DepartureCode='" . $_POST['origin'] . "' AND ArrivalCode='" . $_POST['destination'] . "'";

        if (count($Model->select($sql)) != "0") {

            return json_encode(array("infoItem" => $input, "filter" => "3"));

        } else if ($_POST['origin'] != "0" AND $_POST['destination'] != "0") {

            $data = array(
                "DepartureCode" => $_POST['origin'],
                "ArrivalCode" => $_POST['destination'],
                "FkRobotId" => '1',
                "status" => '1'
            );
            $Model->setTable("robot_list_ticket_tb");
            $Model->insertLocal($data);
            return json_encode(array("infoItem" => $input, "filter" => "1"));
        } else if (count($Model->select($sql)) == "0") {

            return json_encode(array("infoItem" => $input, "filter" => "2"));

        }

    }


    public function sendInformationData($input)
    {
        Load::autoload('Model');
        $this->model = new Model();
        $item = "";

        $sql = "SELECT * FROM robot_tb WHERE id='1'";


        $result = $this->model->select($sql, "assoc");
        $result = $result[0];

        $query = "SELECT * FROM robot_list_ticket_tb WHERE status='1'";
        $query = $this->model->select($query, "assoc");

        $data = [
            'chat_id' => "-" . $result['chat_id'],
            'title' => "<b>   " . $result['title'] . "   </b>",
            'brand' => "<b> " . $result['brand'] . "  </b>"
        ];


        $date = date("Y-m-d", time());
        $date = explode("-", $date);
        $t = dateTimeSetting::gregorian_to_jalali($date[0], $date[1], $date[2]);
        $t = $t[0] . "-" . $t[1] . "-" . $t[2];

        foreach ($query as $key => $value) {

            $url = "api.hiholiday.ir/V4/Flight/CalendarRoute/c4463bb2-b13c-46f1-97b9-863a8e7e3a67/" . $value['DepartureCode'] . "/" . $value['ArrivalCode'] . "/" . $t . "/" . $t;

            $total = functions::curlExecution_Get($url, array());
            if ($total['message'] != "NoData") {

                $total = $total['CalendarRoute'][0];
                $price = " " . ($total['MinPrice'] * 10) . " ریال";
                $link = ROOT_ADDRESS_WITHOUT_LANG . "/local/1/" . $value['DepartureCode'] . "-" . $value['ArrivalCode'] . "/" . $t . "/Y/1-0-0/";
                $value['ArrivalCode'] = functions::NameCity($value['ArrivalCode']);
                $value['DepartureCode'] = functions::NameCity($value['DepartureCode']);
                $item .= "<b> پرواز  " . $value['DepartureCode'] . " - " . $value['ArrivalCode'] . $price . "  </b> <a href='" . $link . "'> مشاهده </a> " . urlencode(PHP_EOL);

            }
        }


        $text = $data['title'] . urlencode(PHP_EOL) . $item . $data['brand'];

        $result = functions::CallAPI($result['api_token'], $data["chat_id"], $text, "GET", true);

        $result = json_decode($result, true);

        $item = count($result['result']) != 0 ? $message = array("Data" => array("Status" => $this->success, "Result" => "true")) : $message = array("Data" => array("Status" => $this->success, "Result" => "false"));

        if ($item['infoItem']["Data"]["Result"] == "true") {
            return json_encode(array("infoItem" => $item, "resultStatus" => true));
        } else {
            return json_encode(array("infoItem" => $item, "resultStatus" => false));
        }

    }

    public function createRobot($input)
    {
        $url = "https://api.telegram.org/bot" . trim($input['token']) . "/getupdates";
        $result = functions::curlExecution_Get($url);

        functions::insertLog('dataGetUpdate=>' . json_encode($result), 'logInsertBot');

        $Model = Load::library('Model');

        $Model->setTable("robot_tb");

//        $condinaation="id='25'";
//        $Model->delete($condinaation);

        $sql = "SELECT * FROM robot_tb ";


        if (!isset($result["result"][0]["channel_post"])) {
            $chat_name = trim($result["result"][0]["message"]["chat"]["title"]);
            $chat_id = trim(str_replace("-", " ", trim($result["result"][0]["message"]["chat"]["id"])));
        } else {
            $chat_name = trim($result["result"][0]["channel_post"]["chat"]["title"]);
            $chat_id = trim(str_replace("-", " ", trim($result["result"][0]["channel_post"]["chat"]["id"])));
        }


        $input_chat_name = trim($input['name']);


        $o = $Model->select($sql, "assoc");

        if (empty($result["result"])) {
            return json_encode(array("infoItem" => $input, "result" => $result, "resultStatus" => "1", "chat_id" => $chat_id, "o" => $o, "chat_name" => $chat_name, "input_name" => $input_chat_name, "chat_id", $chat_id));
        } else if ($chat_name != $input_chat_name) {
            return json_encode(array("infoItem" => $input, "result" => $result, "resultStatus" => "2", "chat_id" => $chat_id, "o" => $o, "chat_name" => $chat_name, "input_name" => $input_chat_name, "chat_id", $chat_id));
        } else if ($chat_name == $input_chat_name) {

            foreach ($o as $value) {
                if ($value['api_token'] == trim($input['token'])) {

                    $y = $value['api_token'];
                    return json_encode(array("infoItem" => $input, "result" => $result, "resultStatus" => "4", "chat_id" => $chat_id, "o" => $o, "y" => $y, "chat_name" => $chat_name, "input_name" => $input_chat_name, "chat_id", $chat_id));

                }
            }

            $data = array(
                "robotid" => "",
                "username" => $chat_name,
                "chat_id" => $chat_id,
                "api_token" => trim($input['token']),
                "title" => $input['title'],
                "brand" => $input['brand'],
                "status" => "1"
            );

            $Model->insertLocal($data);


            return json_encode(array("infoItem" => $input, "result" => $result, "resultStatus" => "3", "chat_id" => $chat_id, "o" => $o, "chat_name" => $chat_name, "input_name" => $input_chat_name, "chat_id", $chat_id));


        }


    }


    public function sendDataRobot($input)
    {
        Load::autoload('Model');
        $Model = new Model();
        $item = "";
        $sql = "SELECT * FROM robot_tb WHERE id='" . $input['id'] . "'";
        $result = $Model->select($sql, "assoc");

        $information = $result[0];

        $query = "SELECT * FROM robot_list_ticket_tb WHERE status='1'";
        $resultRoute = $Model->select($query, "assoc");

        $data = [
            'chat_id' => "-" . $information['chat_id'],
            'title' => "<b>   " . $information['title'] . "   </b>",
            'brand' => "<b> " . $information['brand'] . "  </b>"
        ];


        $date = dateTimeSetting::jdate("Y-m-d", time(),'','','en');
        foreach ($resultRoute as $key => $value) {
            $resultFlight = $this->search($value) ;
            if (!empty($resultFlight)) {
                $price = " " . ($resultFlight) . " ریال";
                $link = ROOT_ADDRESS_WITHOUT_LANG . "/local/1/" . $value['DepartureCode'] . "-" . $value['ArrivalCode'] . "/" . $date . "/Y/1-0-0/";
                $value['ArrivalCode'] = functions::NameCity($value['ArrivalCode']);
                $value['DepartureCode'] = functions::NameCity($value['DepartureCode']);
                $item .= "<b> پرواز  " . $value['DepartureCode'] . " - " . $value['ArrivalCode'] . $price . "  </b> <a href='" . $link . "'> رزرو </a> " . urlencode(PHP_EOL);

            }
        }


        $text = $data['title'] . urlencode(PHP_EOL) . $item . $data['brand'];

        $result = functions::CallAPI($information['api_token'], $data["chat_id"], $text, "GET", true);

        $result = json_decode($result, true);

        $item = count($result['result']) != 0 ? $message = array("Data" => array("Status" => $this->success, "Result" => "true")) : $message = array("Data" => array("Status" => $this->success, "Result" => "false"));
//
//        if($item['infoItem']["Data"]["Result"]=="true")
//        {
//            return  json_encode(array("infoItem" => $item,"resultStatus"=>true,"chat_id"=>$information['chat_id'],"token"=>$information['api_token'],"result"=>$information));
//        }
//        else
//        {
//            return  json_encode(array("infoItem" => $item,"resultStatus"=>false,"chat_id"=>$information['chat_id'],"token"=>$information['api_token'],"result"=>$information));
//        }
        if ($item["Data"]["Result"] == "true") {
            return json_encode(array("infoItem" => $item, "status" => true, "r" => $result));
        } else {
            return json_encode(array("infoItem" => $item, "status" => false, "r" => $result));
        }


    }

    private function search($dataSearch)
    {
//        $url = "http://safar360.com/Core/Flight/flightFifteenDay";
        $url = "http://safar360.com/Core/Flight/flightFifteenDay";
        $dataInfoFlight['Origin'] = $dataSearch['DepartureCode'];
        $dataInfoFlight['Destination'] = $dataSearch['ArrivalCode'];

        $data = json_encode($dataInfoFlight);
        $resultSendData = functions::curlExecution($url, $data, 'yes');

        if ($resultSendData['Result'] == 'true' && !empty($resultSendData['Data'])) {

            foreach ($resultSendData['Data'] as $key => $dataFlight) {

                if (date("Y-m-d", time()+(24*60*60)) == $dataFlight['date_flight']) {
                    echo $dataFlight['price_final'] ;
                    $flightType = ($dataFlight['DisplayLable'] == 'سیستمی') ? 'system' : 'charter';
                    $isPrivate = (functions::checkConfigPid($dataFlight['IATA_code'],'internal',$flightType) == 'private') ? 'private' : 'public';
                    $priceCalculated = functions::setPriceChanges($dataFlight['IATA_code'], $flightType, $dataFlight['price_final'], 'Local', $isPrivate);
                    $priceCalculated = explode(':', $priceCalculated);
                    $PriceWithDiscount = functions::CurrencyCalculate($priceCalculated[1]);

                }
            }
            return  $PriceWithDiscount['AmountCurrency'];

        }
    }

    public function checkUser($input)
    {

        Load::autoload('Model');
        $Model = new Model();

        $sql = "SELECT * FROM robot_tb WHERE id='" . $input['item'] . "'";
        $result = $Model->select($sql, "assoc");
        $information = $result[0];
        $url = "https://api.telegram.org/bot" . $information['api_token'] . "/getChatMember?chat_id=-" . $information['chat_id'] . "&user_id=" . $input['mobile'];

        $curl = functions::curlExecution_Get($url);


        if (count($curl['result']) != 0) {
            return json_encode(array("infoItem" => $input["item"], "curl" => $curl, "status" => true));

        } else {
            return json_encode(array("infoItem" => $input["item"], "curl" => $curl, "status" => false));
        }


    }

    public function removeRobot($input)
    {

        Load::autoload('Model');
        $Model = new Model();
        $Model->setTable("robot_tb");
        $condinaation = $input["id"];
        $Model->delete($condinaation);
        return json_encode(array("information" => $input, "status" => true));

    }

    public function curlExecution($url, $data, $options = null)
    {
        $url = str_replace(" ", '', $url);
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($handle, CURLOPT_ENCODING, 'gzip');
        if (!empty($options)) {
            curl_setopt($handle, CURLOPT_HTTPHEADER, $options);
        }

        $result = curl_exec($handle);
        return json_decode($result, true);
    }


}