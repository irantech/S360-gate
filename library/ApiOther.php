<?php
require '../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
require LIBRARY_DIR . 'Jalali.php';
require CONFIG_DIR . 'application.php';
spl_autoload_register(array('Load', 'autoload'));

class ApiOther
{

    public $user;
    public $pass;
    public $request_number;

    public function __construct()
    {


        $this->user = $_POST['user'];
        $this->pass = $_POST['password'];
        $this->request_number = $_POST['request_number'];
        if ($this->user == "abazar_afshar" && $this->pass == 'il@veU') {
            $this->myFunction($this->request_number);
        } else {
            echo 'شما مجاز به ورود نیستید،لطفا صفحه را ترک کنید';
        }
    }

    public function myFunction($request_number)
    {
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();


         $Sql = " SELECT * FROM report_tb WHERE request_number='{$request_number}'";
        $result = $ModelBase->select($Sql);



        $passengers = array();
        foreach ($result as $key => $res) {

            if (!empty($res['passenger_birthday'])) {

                $explode_br_fa = explode('-', $res['passenger_birthday']);
                $date_miladi = dateTimeSetting::jalali_to_gregorian($explode_br_fa[0], $explode_br_fa[1], $explode_br_fa[2], '-');
            }

            $passengers['passengers'][$key]['index'] = $key;
            $passengers['passengers'][$key]['type'] = $res['passenger_age'];
            $passengers['passengers'][$key]['gender'] = $res['passenger_gender'] == 'Male' ? 'Male' : 'Female';
            $passengers['passengers'][$key]['PersianGender'] = $res['passenger_gender'] == 'Male' ? 'آقا' : 'خانم';
            $passengers['passengers'][$key]['accompanied_by_infant'] = false;
            $passengers['passengers'][$key]['prefix'] = $res['passenger_gender'] == 'Male' ? 'Mr' : 'Mrs';
            $passengers['passengers'][$key]['given_name'] = $res['passenger_name_en'];
            $passengers['passengers'][$key]['surname'] = $res['passenger_family_en'];
            $passengers['passengers'][$key]['persian_given_name'] = $res['passenger_name'];
            $passengers['passengers'][$key]['persian_surname'] = $res['passenger_family'];
            $passengers['passengers'][$key]['birthdate'] = !empty($res['passenger_birthday']) ?  $date_miladi : $res['passenger_birthday_en'] ;
            $passengers['passengers'][$key]['telephone'] = !empty($res['mobile_buyer']) ? $res['mobile_buyer'] : '09021300120';
            $passengers['passengers'][$key]['email'] = !empty($res['email_buyer']) ? $res['email_buyer'] : 'info@iran-tech.com';
            $passengers['passengers'][$key]['nationality'] = !empty($res['passenger_birthday_en']) ? $res['passportCountry'] : 'IRN';
            $passengers['passengers'][$key]['national_id'] = !empty($res['passenger_birthday_en']) ? '' : $res['passenger_national_code'];
            $passengers['passengers'][$key]['passport']['id'] = $res['passportNumber'];
            $passengers['passengers'][$key]['passport']['expire_date'] = $res['passportExpire'];
            $passengers['passengers'][$key]['passport']['doc_issue_country'] = !empty($res['passenger_birthday_en']) ? $res['passportCountry'] : 'IRN';
            $passengers['passengers'][$key]['request_number'] = $res['request_number'];
            $passengers['passengers'][$key]['PersianBirthday'] = !empty($res['passenger_birthday_en']) ? $res['passenger_birthday_en'] : $res['passenger_birthday'];

        }

        echo json_encode($passengers);
    }
}

/**
 * این کلاس چون از طریق جاوا اسکریپت فراخوانی میشود
 * همین جا صدا زده شده
 * لطفا پاک نشود
 */
new ApiOther();
?>