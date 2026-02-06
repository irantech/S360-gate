<?php
/**
 * Created by PhpStorm.
 * User: AbbasPC
 * Date: 11/12/2019
 * Time: 9:43 AM
 */
error_reporting(1);
error_reporting(E_ALL | E_STRICT);
@ini_set('display_errors', 1);
@ini_set('display_errors', 'on');
class registerApi
{

    private $content;
    private $adminController;

    public function __construct()
    {

        header("Content-type: application/json;");

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && (strpos($_SERVER['CONTENT_TYPE'], 'application/json')) !== false) {
            $this->content = json_decode(file_get_contents('php://input'), true);


            $this->adminController = Load::controller('admin');
            $data['client'] = $this->content['userName'];

            $clientAccess = functions::accessToClientInsertMemberApi();

            if (array_key_exists($data['client'], $clientAccess)) {
                $clientId = $clientAccess[$data['client']];
                $this->content['clientId'] = $clientId;

                $params = $this->content;
                echo $this->registerUser($params);
            } else {
                $resultJsonArray = array(
                    'Result' => array(
                        'RequestStatus' => 'Error',
                        'MessageEn' => 'userNameIsInvalid',
                        'MessageFa' => 'شناسه کاربری نا معتبر است',
                        'MessageCode' => 'Error150',
                    ),
                );
                return json_encode($resultJsonArray);
            }
        } else {
            $resultJsonArray = array(
                'Result' => array(
                    'RequestStatus' => 'Error',
                    'MessageEn' => 'NotValidTypeRequest',
                    'MessageFa' => 'نوع درخواست نا معتبر است',
                    'MessageCode' => 'Error100',
                ),
            );
            return json_encode($resultJsonArray);
        }

    }


    public function registerUser($param)
    {

        if (!empty($param['mobile']) && !empty($param['email']) && !empty($param['name']) && !empty($param['family'])) {
            $existMember = $this->getByEmail($param['email'], $param['clientId']);
            if ($existMember) {
                $cardNo = $this->generateCardNo($param['clientId']);
                //do not repeat reagent code
                do {
                    $reagentCode = functions::generateRandomCode(10);
                    $resultRepeat = $this->getByReagentCode($reagentCode, $param['clientId']);
                } while ($resultRepeat != 0 && is_array($resultRepeat));

                $data['password'] = functions::encryptPassword($param['mobile']);
                $data['email'] = strtolower($param['email']);
                $data['name'] = $param['name'];
                $data['family'] = $param['family'];
                $data['mobile'] = $param['mobile'];
                $data['TypeOs'] = 'Api';
                $data['fk_counter_type_id'] = '5';
                $data['fk_agency_id'] = '0';
                $data['is_member'] = '1';
                $data['card_number'] = $cardNo;
                $data['reagent_code'] = $reagentCode;

                $resultInsert = $this->adminController->ConectDbClient('', $param['clientId'], 'Insert', $data, 'members_tb', '');

                if ($resultInsert) {
                    $resultJsonArray = array(
                        'Result' => array(
                            'RequestStatus' => 'Success',
                            'Messageen' => 'UserRegistrationSuccessful ',
                            'MessageFa' => 'ثبت نام با موفقیت انجام شد',
                            'MessageCode' => 'Success200',
                        ),
                    );
                } else {
                    $resultJsonArray = array(
                        'Result' => array(
                            'RequestStatus' => 'Error',
                            'MessageEn' => 'ErrorInRegister',
                            'MessageFa' => 'خطا در فرآیند ثبت نام',
                            'MessageCode' => 'Error100',
                        ),
                    );
                }
            } else {
                $resultJsonArray = array(
                    'Result' => array(
                        'RequestStatus' => 'Error',
                        'MessageEn' => 'userAlreadyExist',
                        'MessageFa' => 'کاربر مورد نظر قبلا در سیستم ثبت نام شده است',
                        'MessageCode' => 'Error120',
                    ),
                );
            }
        } else {
            $resultJsonArray = array(
                'RequestStatus' => 'Error',
                'MessageEn' => 'InfoDataIsInvalid',
                'MessageFa' => 'مقادیر ارسال شده نامعتبر است',
                'MessageCode' => 'Error160',
            );
        }
        return json_encode($resultJsonArray);
    }

    private function getByEmail($email, $clientId)
    {


        $sql = "select * from members_tb where email='{$email}'";

        $result = $this->adminController->ConectDbClient($sql, $clientId, "Select");
        if (!empty($result)) {
            return false;
        } else {
            return true;
        }
    }

    private function generateCardNo($clientId)
    {


        $sql = "SELECT MAX(card_number) AS MaxCardNo FROM members_tb";

        $result = $this->adminController->ConectDbClient($sql, $clientId, "Select");
        if (!empty($result)) {
            $maxCardNo = $result['MaxCardNo'];
        } else {
            $maxCardNo = 0;
        }

        if ($maxCardNo == 0) {
            $card_number = CLIENT_PRE_CARD_NO . "00000001";
        } else {
            $dynamic_section = substr($maxCardNo, 8, 8) + 1;
            $zero_section = '';
            for ($j = strlen($dynamic_section); $j < 8; $j++) {
                $zero_section .= '0';
            }
            $card_number = CLIENT_PRE_CARD_NO . $zero_section . $dynamic_section;
        }

        return $card_number;


    }

    private function getByReagentCode($reagentCode, $clientId)
    {
        $sql = "select * from members_tb where reagent_code = {$reagentCode}";
        $result = $this->adminController->ConectDbClient($sql, $clientId, "Select");
        if (!empty($result)) {
            return $result;
        } else {
            return 0;
        }
    }
}

new registerApi();