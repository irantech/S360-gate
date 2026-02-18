<?php


class gdsSwitches extends clientAuth
{

    protected $model = '';

    public function __construct() {
        parent::__construct();
        $this->model = $this->getModel('gdsSwitchModel');
    }


    public function getListGdsSwitches() {
        return $this->model->get()->all();
    }

    public function addGdsSwitch($params) {

        $data_add_gds_switch['title'] = $params['title'];
        $data_add_gds_switch['gds_switch'] = $params['gds_switch'];
        $data_add_gds_switch['creation_date_int'] = time();

        $result_add_gds_switch = $this->model->insertWithBind($data_add_gds_switch);

        if ($result_add_gds_switch) {
            return functions::withSuccess('', 200, 'افزودن بخش جدید با موفقیت انجام شد');
        }

        return functions::withError('', 400, 'خطا در افزودن بخش جدید');
    }

    public function editGdsSwitch($params) {

        $check_exist_gds_switch = $this->getGdsSwitchById($params['gds_switch_id']);
        if ($check_exist_gds_switch) {
            $data_add_gds_switch['title'] = $params['title'];
            $data_add_gds_switch['gds_switch'] = $params['gds_switch'];
            $data_add_gds_switch['creation_date_int'] = time();

            $condition = "'id'='{$params['gds_switch_id']}'";

            $result_add_gds_switch = $this->model->updateWithBind($data_add_gds_switch, $condition);

            if ($result_add_gds_switch) {
                return functions::withSuccess('', 200, 'ویرایش بخش جدید با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش بخش جدید');
        }
        return functions::withError('', 400, 'خطا در ویرایش بخش جدید');
    }

    public function getGdsSwitchById($id) {
        return $this->model->get()->where('id', $id)->find();
    }
}