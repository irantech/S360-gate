<?php

class frontPanel
{
    #region parameters
    public $page = '';
    #endregion


    #region __construct
    public function __construct()
    {
        if(defined('PANEL_FILE')) {

            if(Session::IsLogin() || PANEL_FILE == 'login' || PANEL_FILE == 'register') {
                if (file_exists(FRONT_CURRENT_PANEL . '/' . PANEL_FILE . '.tpl')) {

                    $this->page = '../' . FOLDER_PANEL . '/' . PANEL_FILE;

                } else {

                    $this->page = '../' . FOLDER_PANEL . '/404';

                }
            } else{
                header('Location: ' . ROOT_ADDRESS_WITHOUT_LANG . '/' . PANEL_DIR . '/login');
                exit();
            }

        } else{

            if(Session::IsLogin()) {
                $this->page = '../' . FOLDER_PANEL . '/dashboard';
            } else{
                $this->page = '../' . FOLDER_PANEL . '/login';
            }

        }

        if (!empty($this->page) || GDS_SWITCH == 'view') {
            $this->page .= '.tpl';
        } else {
            header('location: ' . ROOT_ADDRESS_WITHOUT_LANG . '/404.shtml');
        }
    }
    #endregion

    #region fixColData
    public function fixColData()
    {
        switch (PANEL_FILE){
            case 'login':
                $pageTitle = 'ورود به پنل';
                $pageImage = '6.jpg';
                break;

            case 'user/profile':
            case 'user/passwordChange':
                $pageTitle = 'پروفایل';
                $pageImage = '6.jpg';
                break;

            case 'user/passengers':
            case 'user/passengerAdd':
            case 'user/passengerEdit':
                $pageTitle = 'مسافران';
                $pageImage = '6.jpg';
                break;

            case 'reserves/ticket':
            case 'reserves/hotel':
            case 'reserves/insurance':
                $pageTitle = 'رزروها';
                $pageImage = '6.jpg';
                break;

            case 'reserves/canceledTicket':
                $pageTitle = 'کنسلی';
                $pageImage = '6.jpg';
                break;

            case 'ewallet/credits':
            case 'ewallet/creditAdd':
            case 'ewallet/returnBank':
                $pageTitle = 'کیف پول';
                $pageImage = '6.jpg';
                break;

            default:
                $pageTitle = '';
                $pageImage = '6.jpg';
                break;
        }

        return array('pageTitle' => $pageTitle, 'pageImage' => $pageImage);
    }
    #endregion


    public function changePassword($info)
    {
        $old_pass = md5($info['old_pass']);
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $sql = "SELECT * FROM login_tb WHERE client_id='{$info['client_id']}'";
        $client = $ModelBase->load($sql);
        if (!empty($client)) {
            $sqlCheckPass = "SELECT * FROM login_tb WHERE password='{$old_pass}'";
            $clientCheckPass = $ModelBase->load($sqlCheckPass);
            if (!empty($clientCheckPass)) {
                $data['password'] = md5($info['new_pass']);
                $ModelBase->setTable('login_tb');
                $res = $ModelBase->update($data, "client_id='{$info['client_id']}'");
                if ($res) {
                    return 'success : رمز عبور شما با موفقیت تغییر یافت';
                } else {
                    return 'error : خطا در ثبت اطلاعات';
                }
            } else {
                return 'error: رمز عبور قدیم اشتباه است';
            }
        } else {

            return 'error: خطا در شناسایی کاربر';
        }
    }


    #region access
    public function Access()
    {

        if (defined('ADMIN_MODULE_FOLDER')) {

            Load::autoload('clientAuth');
            $clientAuth = new clientAuth();
            $access = true;
            switch (ADMIN_MODULE_FOLDER) {
                case 'ticket':
                    if (!$clientAuth->adminAccess('TicketApi')) {
                        $access = false;
                    }
                    break;

                case 'hotel':
                    if (!$clientAuth->adminAccess('HotelApi')) {
                        $access = false;
                    }
                    break;

                case 'reservation':
                    if (!$clientAuth->adminAccess('TicketReserve') && !$clientAuth->adminAccess('HotelReserve')) {
                        $access = false;
                    }
                    break;

                case 'insurance':
                    if (!$clientAuth->adminAccess('InsuranceApi')) {
                        $access = false;
                    }
                    break;

                case 'at':
                    if (!$clientAuth->adminAccess('At')) {
                        $access = false;
                    }
                    break;

            }
        } else {
            $access = true;
        }


        if ($access) {
            return true;
        } else {
            return false;
        }
    }
    #endregion

}

?>
