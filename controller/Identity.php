<?php

class Identity {

    public $listBank;
    public $info;
    public $ClientId;

    /**
     * if form was send  "get data-> upload logo -> insert DB"
     */
    public function __construct() {
        
    }

    public function InfoShow($client_id) {

        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $sql = " SELECT * FROM client_api_tb WHERE client_id='{$client_id}'";

        $res = $ModelBase->load($sql);
        $this->info = $res;
    }

    public function IdentityInsert($info) {

        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $sql = " SELECT * FROM clients_tb WHERE id='{$info['client_id']}'";
        $res = $ModelBase->load($sql);


        $sqlApi = " SELECT * FROM client_api_tb WHERE client_id='{$info['client_id']}'";
        $resApi = $ModelBase->load($sqlApi);

        if (!empty($res)) {
            if (empty($resApi)) {

                $data['client_id'] = $info['client_id'];
                $data['username'] = $info['username'];
                $data['password'] = $info['password'];
                $data['tabadol_key'] = $info['tabadol_key'];
                $data['api_id'] = '1';
                $data['creation_date_int'] = time();


                $ModelBase->setTable('client_api_tb');
                $resuinsert = $ModelBase->insertLocal($data);

                if ($resuinsert) {
                    echo 'success : اطلاعات با موفقیت ثبت شد';
                } else {
                    echo 'error : خطا در ثبت اطلاعات';
                }
            } else {

                $d['username'] = $info['username'];
                $d['password'] = $info['password'];
                $d['tabadol_key'] = $info['tabadol_key'];
                $d['last_edit_int'] = time();

                $ModelBase->setTable('client_api_tb');
                $resupdate = $ModelBase->update($d, "client_id='{$info['client_id']}'");
                if ($resupdate) {
                    echo 'success : اطلاعات با موفقیت ویرایش شد';
                } else {
                    echo 'error : خطا در ثبت اطلاعات';
                }
            }
        } else {
            echo 'error : خطا در  شناسایی کاربر';
        }
    }

    public function IdentityUpdate($param) {
        
    }

}

?>
