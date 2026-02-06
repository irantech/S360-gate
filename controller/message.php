<?php
/**
 * Created by PhpStorm.
 * User: SaeedPc
 * Date: 12/10/2017
 * Time: 4:09 PM
 */

/**
 * Class message
 * @property message $message
 */
class message
{

    public function __construct()
    {

    }

    public function MessageUserList()
    {

        Load::autoload('Model');

        $Model = new Model();

	    $SqlMessage = " SELECT * FROM message_tb WHERE is_del='0'";

        return $Model->select($SqlMessage);


    }

    public function seenMessage($id)
    {

        Load::autoload('Model');

        $Model = new Model();

        $Model->setTable('message_tb');

        $d['is_seen'] = '1';
        $d['seen_date_int'] = time();

        $Model->update($d, "id='{$id}'");

    }

    public function viewMessage($id)
    {
        Load::autoload('Model');

        $Model = new Model();

        $SqlMessage = " SELECT * FROM message_tb WHERE id='{$id}'";

        return $Model->load($SqlMessage);


    }

    public function CountUnreadMessage()
    {
        Load::autoload('Model');

        $Model = new Model();

        $SqlMessage = " SELECT COUNT(id) AS countMessage FROM message_tb WHERE is_seen='0' AND is_del='0'";

        $res = $Model->load($SqlMessage);
        return $res['countMessage'];
    }

    public function UnreadMessage()
    {
        Load::autoload('Model');

        $Model = new Model();

        $SqlMessage = " SELECT *  FROM message_tb WHERE is_seen='0' AND is_del='0' LIMIT 0,4";

        return $Model->select($SqlMessage);

    }

    public function messageListAllUser()
    {

        Load::autoload('ModelBase');

        $ModelBase = new ModelBase();

        $SqlClient = " SELECT * FROM message_admin_tb ";

        $results = $ModelBase->select($SqlClient);


        foreach ($results as $key=>$result) {

            $results[$key]['count'] = count(json_decode($result['clientIDs']));

        }
        return $results;
    }


    public function viewMessageAdmin($id)
    {
         Load::autoload('ModelBase');

         $ModelBase = new ModelBase();

        $sql = " SELECT * FROM message_admin_tb WHERE id='{$id}' ";

        $clientMessage = $ModelBase->load($sql);

        return $clientMessage;

    }

    public function delMessageUser($Param)
    {

	    /** @var admin $admin */
	    $admin = Load::controller('admin');

        $sql = " SELECT * FROM message_tb WHERE unique_code='{$Param['id']}' ";

        $clientMessage = $admin->ConectDbClient($sql, $Param['ClientID'], "Select", "", "", "");

        if (!empty($clientMessage)) {

            $d['is_del'] = '1';
            $d['del_date_int'] = time();

            $Condition = "unique_code='{$Param['id']}'";
            $resultUpdateMessage = $admin->ConectDbClient('', $Param['ClientID'], "Update", $d, "message_tb", $Condition);

            if ($resultUpdateMessage) {
                echo 'success : حذف پیام برای کاربر با موفقیت پایان یافت';
            } else {
                echo 'error : خطا در حذف پیام برای کاربر';

            }
        } else {
            echo 'error : خطا در شناسایی کاربر';
        }


    }

    public function sendMessage()
    {


        $data['title'] = $_POST['title'];
        $data['message'] = $_POST['message'];
        $data['is_seen'] = '0';
        $data['is_del'] = '0';
        $data['creation_date_int'] = time();
        $data['del_date_int'] = '0';
        $data['seen_date_int'] = '0';
        $data['unique_code'] = substr(time(), 0, 5) . mt_rand(000, 999);

	    /** @var admin $admin */
	    $admin = Load::controller('admin');


        $sendMessage= '' ;

        foreach ($_POST['ClientId'] as $client) {
            $sendMessage = $admin->ConectDbClient("", $client, "Insert", $data, "message_tb", "");
        }

        if ($sendMessage) {
            Load::autoload('ModelBase');
            $ModelBase = new ModelBase();
            $data['clientIDs'] = json_encode($_POST['ClientId']);

            $ModelBase->setTable('message_admin_tb');

            $ModelBase->insertLocal($data);
            echo 'success : ارسال پیام به  مشتری با موفقیت پایان یافت';
        } else {
            echo 'error : خطا در ارسال  پیام برای مشتری';

        }
    }


    public function ShowClientMessage($id)
    {
        Load::autoload('ModelBase');

        $ModelBase = new ModelBase();

        $SqlClient = " SELECT * FROM message_admin_tb WHERE id={$id} AND is_del='0'";

        $results = $ModelBase->load($SqlClient);

        return $results;
    }


    public function viewMessageByClient($clientId,$uniqueID)
    {
	    /** @var admin $admin */
	    $admin = Load::controller('admin');

           $sql = " SELECT * FROM message_tb WHERE unique_code='{$uniqueID}' ";
       $clientMessage = $admin->ConectDbClient($sql, $clientId, "Select", "", "", "");

       if($clientMessage['is_seen'] == 1)
       {
           return 'ok';
       }else if($clientMessage['is_seen'] == 0){
           return 'nok';
       }
       return 'nok';
    }

    public function delMessageByClient($clientId,$uniqueID)
    {
	    /** @var admin $admin */
	    $admin = Load::controller('admin');

        $sql = " SELECT * FROM message_tb WHERE unique_code='{$uniqueID}' ";
        $clientMessage = $admin->ConectDbClient($sql, $clientId, "Select", "", "", "");

        if($clientMessage['is_del'] == 1)
        {
            return 'ok';
        }else if($clientMessage['is_del'] == 0){
            return 'nok';
        }
	    return 'nok';
    }




}