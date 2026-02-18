<?php


class manageTelegram
{

    public function listTicket()
    {
        $select_ticket = Load::library('Model');

        $sql = " SELECT  *  FROM robot_list_ticket_tb WHERE status='1'";

        $result = $select_ticket->select($sql,"assoc");

       return $result;


    }
    public function listTicketALL()
    {
        $select_ticket = Load::library('Model');

        $sql = " SELECT  *  FROM robot_list_ticket_tb ";

        $result = $select_ticket->select($sql,"assoc");

        return $result;


    }

    public  function listRobotALL()
    {

        $select_ticket = Load::library('Model');

        $sql = " SELECT  *  FROM robot_tb ";

        $result = $select_ticket->select($sql,"assoc");

        return $result;

    }


    public function insertRouteRobot($params)
    {
        $Model = Load::library('Model');


        $sql = "SELECT * FROM robot_list_ticket_tb WHERE DepartureCode='{$params['origin']}' AND ArrivalCode='{$params['destination']}'";
        $existRoute = $Model->load($sql);

        if(empty($existRoute))
        {
            $data['DepartureCode'] = $params['origin'];
            $data['ArrivalCode'] = $params['destination'];
            $data['status'] = '1';

            $Model->setTable('robot_list_ticket_tb');
            $resultInsert = $Model->insertLocal($data);

            if($resultInsert)
            {
                $dataMessage['status'] = 'success';
                $dataMessage['message'] = 'مسیر با موفقیت ثبت شد';

                return json_encode($dataMessage);
            }

            $dataMessage['status'] = 'error';
            $dataMessage['message'] = 'خطا در ثبت مسیر';

            return json_encode($dataMessage);

        }
        $dataMessage['status'] = 'error';
        $dataMessage['message'] = 'مسیر قبلا ثبت شده است';

        return json_encode($dataMessage);

    }






}