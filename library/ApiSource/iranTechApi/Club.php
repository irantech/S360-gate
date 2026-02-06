<?php
/**
 * Created by PhpStorm.
 * User: AbbasPC
 * Date: 1/5/2020
 * Time: 1:15 PM
 */

class club
{
    protected $content ;
    protected $adminController;

    public function __construct()
    {


        header("Content-type: application/json;");


        if ($_SERVER['REQUEST_METHOD'] == 'POST' && (strpos($_SERVER['CONTENT_TYPE'], 'application/json')) !== false) {

            $this->content = json_decode(file_get_contents('php://input'), true);

            $this->adminController = Load::controller('admin');
                $method = $this->content['method'];
                $params = $this->content;
                echo $this->$method($params);

        } else {
            $resultJsonArray = array(
                'Result' => array(
                    'RequestStatus' => 'Error',
                    'Message' => 'NotValidTypeRequest',
                    'MessageCode' => 'Error100',
                ),
            );
            echo  json_encode($resultJsonArray);
        }
    }


    public function insertCreditOfClub($param)
    {
        $members = Load::model('members');
        $membersController = Load::controller('members');
        $member = $membersController->findMemberByEmail($param['email']);

        $checkExist = $membersController->findMemberCredit($param['factorNumber'],'charge');

        if(!empty($member))
        {
        if(empty($checkExist)){
            $dataCredit['memberId'] = $member['id'];
            $dataCredit['amount'] = $param['price'];
            $dataCredit['state'] = 'charge';
            $dataCredit['reason'] = 'giftBuyTicket';
            $dataCredit['comment'] = 'اعتبار هدیه شده بابت امتیاز خرید به شماره فاکتور'.$param['factorNumber'];
            $dataCredit['factorNumber'] = $param['factorNumber'];
            $dataCredit['status'] = 'progress';
            $dataCredit['source'] = $param['source'];

            $resultMember = $members->membersCreditAdd($dataCredit);

            if($resultMember)
            {
                $infoCode = array(
                    'Status' => 'Success',
                    'Message' => 'اعتبار با موفقیت ثبت شد',
                    'MessageCode' => 'Success200',
                );

                return json_encode($infoCode);
            }

            $infoCode = array(
                'Status' => 'Error',
                'Message' => 'خطا در ثبت اعتبار',
                'MessageCode' => 'Error200',
            );

            return json_encode($infoCode);
        }

        $infoCode = array(
            'Status' => 'Error',
            'Message' => 'اعتبار قبلا ثبت شده است',
            'MessageCode' => 'Error201',
        );

        return json_encode($infoCode);
        }

        $infoCode = array(
            'Status' => 'Error',
            'Message' => 'کاربر موجود نمی باشد',
            'MessageCode' => 'Error201',
        );

        return json_encode($infoCode);
    }

}

new club();