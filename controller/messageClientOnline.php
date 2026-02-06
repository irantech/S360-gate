<?php
/**
 * Created by PhpStorm.
 * User: AbbasPC
 * Date: 5/2/2019
 * Time: 2:35 PM
 */

class messageClientOnline
{


    public function __construct()
    {

    }


    #region ListMessage
    public function ListMessage()
    {

        $Model = Load::library('Model');

        $SalMessage = "SELECT * FROM message_client_online_tb";

        $ResultMessage = $Model->select($SalMessage);

        return $ResultMessage;

    }
    #enfregion
    #regionInsertMessage
    public function insertMessage($Data)
    {

        $Model = Load::library('Model');

        $Model->setTable('message_client_online_tb');

        $config = Load::Config('application');
        $config->pathFile('MessageClient/');
        $success = $config->UploadFile("pic", "image", "");
        $explode_name_pic = explode(':', $success);
        if ($explode_name_pic[0] == "done") {

            $Data['image'] = $explode_name_pic[1];
        }
        $Data['creationDateInt'] = time();
        $res = $Model->InsertLocal($Data);


        if ($res) {
            $Message['Message'] = "پیام با موفقیت ارسال شد";
            $Message['Status'] = "Success";
        } else {
            $Message['Message'] = "خطا در ارسال پیام";
            $Message['Status'] = "Error";
        }

        return json_encode($Message);

    }

    #endRegion
    #region DeleteMessage
    public function DeleteMessage($id)
    {

        $Model = Load::library('Model');

        $SalMessage = "SELECT * FROM message_client_online_tb WHERE  id={$id}";

        $ResultMessage = $Model->load($SalMessage);

        if (!empty($ResultMessage)) {
            $Model->setTable('message_client_online_tb');

            $Condition = "id={$id}";
            $Model->delete($Condition);

            $Message['Message'] = "پیام با موفقیت حذف شد";
            $Message['Status'] = "Success";

        } else {
            $Message['Message'] = "درخواست شما معتبر نیست";
            $Message['Status'] = "Error";
        }

        return $Message;

    }
    #enfregion

}