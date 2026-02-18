<?php




class bankList extends clientAuth
{

    public $listBank;
    public $edit;
    public $ClientId;

    /**
     * if form was send  "get data-> upload logo -> insert DB"
     */
    public function __construct()
    {
        parent::__construct();

        if (isset($_GET['id'])) {
            $this->ClientId = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        }
    }

    public function index()
    {


        if (!empty($this->ClientId)) {

            $admin = Load::controller('admin');

            $sql = " SELECT * FROM bank_tb";
            $Bank = $admin->ConectDbClient($sql, $this->ClientId, "SelectAll", "", "", "");

            return $Bank;
        } else {
            $bank_model = Load::model('bankList');

            if(Session::getAgencyId())
            {
                $Condition = "enable='1'" ;
            }else{
                $Condition ='';
            }

            $listBank = $bank_model->getAll($Condition);

            return $listBank;
        }
    }

    public function bankActive($param)
    {
//        error_reporting(1);
//        error_reporting(E_ALL | E_STRICT);
//        @ini_set('display_errors', 1);
//        @ini_set('display_errors', 'on');


        $checkIranTechBank = functions::CheckGetWayIranTech($param['ClientId']);
        $DataIranTechGetWay = functions::DataIranTechGetWay();

            if (!empty($param['ClientId'])) {
                $admin = Load::controller('admin');

                $sql = " SELECT * FROM bank_tb WHERE id='{$param['id']}'";
                $Bank = $admin->ConectDbClient($sql, $param['ClientId'], "Select", "", "", "");





                if ($Bank['enable'] == '1') {
                    $DataBank['enable'] = "0";
                } else {
                    $DataBank['enable'] = "1";
                }
                $BankActive = $admin->ConectDbClient("", $param['ClientId'], "Update", $DataBank, "bank_tb", "id='{$param['id']}'");

                if ($BankActive) {
                    return 'success : تغیر وضعیت بانک  با موفقیت انجام  شد';
                } else {
                    return 'error : خطا در تغیر وضعیت  بانک';
                }
            } else {
                Load::autoload('Model');

                $model = new Model();

                $bank_model = Load::model('bankList');

                $rec = $bank_model->get($param['id']);

                if ($rec['enable'] == '1') {
                    $data['enable'] = "0";
                } else {
                    $data['enable'] = "1";
                }

                $model->setTable('bank_tb');
                $res = $model->update($data, "id='{$rec['id']}'");

                if ($res) {
                    return 'success : وضعیت بانک با موفقیت تغییر یافت';
                } else {
                    return 'error : خطا در تغییر وضعیت بانک';
                }
            }

    }

    public function InsertInfoBank($data)
    {
        $bankinfo = explode('-', $data['title']);
        $data['bank_dir'] = $bankinfo[0];
        $data['title'] = $bankinfo[1];
        $data['title_en'] = $bankinfo[2];

        $arrayDataMain = array($data['param1'],$data['param2'],$data['param3']);
        $dataGatWayIranTech = functions::DataIranTechGetWay();

        $arrayDiff = array_diff($arrayDataMain,$dataGatWayIranTech);

        if (!empty($data['ClientId'])) {

            if (is_numeric(intval($data['ClientId'])) && $data['ClientId'] > 1) {
                $admin = Load::controller('admin');
                $ClientId = $data['ClientId'];
                 $data['enable'] = '1' ;
                 $data['creation_date_int'] = time();
                 unset($data['ClientId']);
                $BankInsert = $admin->ConectDbClient("", $ClientId, "Insert", $data, "bank_tb", "");
                if ($BankInsert) {
                    return 'success : بانک با موفقیت ثبت شد';
                } else {
                    return 'error : خطا در ثبت بانک';
                }
            } else {
                return 'ProblemID : فرم از صفحه ای نا معتبر ارسال شده است';
            }
        } else {
            $bankList = Load::model('bankList');
            return $bankList->insertBank($data);
        }
    }

    public function UpdateInfoBank($data)
    {
        $bankinfo = explode('-', $data['title']);

        $data['bank_dir'] = $bankinfo[0];
        $data['title'] = $bankinfo[1];
        $data['title_en'] = $bankinfo[2];
        
        if (!empty($data['ClientId'])) {
            $admin = Load::controller('admin');
            $ClientId = $data['ClientId'];
            $id = $data['bankId'];

            unset($data['ClientId']);
            unset($data['bankId']);
            $sql = "SELECT * FROM bank_tb WHERE id='{$id}'";
            $Bank = $admin->ConectDbClient($sql, $ClientId, "Select", "", "", "");
            if (!empty($Bank)) {
                $data['last_edit_int'] = time();
                $BankUpdate = $admin->ConectDbClient("", $ClientId, "Update", $data, "bank_tb", "id='{$id}'");

                if ($BankUpdate) {
                    return 'success : بانک با موفقیت ویرایش شد';
                } else {
                    return 'error : خطا در ویرایش بانک';
                }
            } else {
                return 'error : خطا در شناسایی بانک';
            }
        }
        else {
            $bankList = Load::model('bankList');

            return $bankList->updateBank($data);
        }
    }

    public function showedit($id, $ClientId = NULL)
    {
        if (!empty($ClientId)) {
            $admin = Load::controller('admin');
            $sql = " SELECT * FROM bank_tb WHERE id='{$id}'";
            $Bank = $admin->ConectDbClient($sql, $ClientId, "Select", "", "", "");
            $this->edit = $Bank;
        } else {
            $Model = Load::autoload('Model');
            $Model = new Model();
            if (isset($id) && !empty($id)) {
                $edit_query = " SELECT * FROM  bank_tb  WHERE id='{$id}'";
                $res_edit = $Model->load($edit_query);
                if (!empty($res_edit)) {
                    $this->edit = $res_edit;
                } else {
                    header("Location: " . ROOT_ADDRESS . "bankList" . !empty($ClientId)) ? $ClientId : '';
                }
            } else {
                header("Location: " . ROOT_ADDRESS . "bankList" . !empty($ClientId)) ? $ClientId : '';
            }
        }
    }

    public function bank360()
    {
        $modelBase = Load::library('ModelBase');
        $Sql = "SELECT * FROM setting_bank_irantech ";
        $data = $modelBase->select($Sql);

        return $data;
    }

    /**
     * @param $param
     */
    public function bank360Active($param)
    {

        $modelBase = Load::library('ModelBase');
        $admin = Load::controller('admin');

            $dataBankSecond['is_enable'] = '1';
            $conditionSecond = "userName='{$param['username']}'";
            $modelBase->setTable('setting_bank_irantech');
            $updateBankSecond = $modelBase->update($dataBankSecond,$conditionSecond);


        if($updateBankSecond)
        {

            return "success:عملیات انجام شد،لطفا بررسی شود";

        }

        return "error:خطا در به روز رسانی تنظیمات درگاه سفر 360 بخش نهایی";

    }

    public function getListActiveBank() {
        return $this->getModel('bankListModel')->get()->where('enable',1)->orderBy('bank_dir')->all();
    }

}
