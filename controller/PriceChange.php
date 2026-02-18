<?php

class PriceChange {

    public $id = '';
    public $list;
    public $edit;

    public function __construct() {
        
    }

    public function PriceChangeList() {
        Load::autoload('Model');
        $Model = new Model();

        $sql = " SELECT * FROM  price_changes_tb ORDER BY id DESC";

        $price_changes = $Model->select($sql);

        return $price_changes;
    }

    public function airlineList() {
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $sql = " SELECT * FROM airline_tb ORDER BY id ASC";

        $airline = $ModelBase->select($sql);

        return $airline;
    }

    public function UpdateStatus($id) {
        Load::autoload('Model');
        $model = new Model();

        $sql = " SELECT * FROM price_changes_tb WHERE id='{$id}'";

        $price_change = $model->load($sql);

        if (!empty($price_change)) {

            if ($price_change['is_enable'] = 'yes') {
                $data['is_enable'] = 'no';
            } else {
                $data['is_enable'] = 'yes';
            }

            $condition = "id='{$id}'";
            $model->setTable('price_changes_tb');
            $res = $model->update($data, $condition);

            if ($res) {
                return 'success : وضعیت  تغییرات با موفقیت ویرایش شد';
            } else {
                return 'error : خطا در ویرایش وضعیت  تغییرات';
            }
        } else {
            return 'error : خطا درشناسایی تغییرات قیمت';
        }
    }

    public function InsertChangePrice($info) {

        Load::autoload('Model');
        $Model = new Model();

        $today_date = dateTimeSetting::jdate('Y-m-d', time());
        $today_explode = explode('-', $today_date);
        $today_mk = dateTimeSetting::jmktime('0', '0', '0', $today_explode[1], $today_explode[2], $today_explode[0]);

        $start_date = str_replace('-', '/', $info['start_date']);
        $start_explode = explode('/', $start_date);
        $start_mk = dateTimeSetting::jmktime('0', '0', '0', $start_explode[1], $start_explode[2], $start_explode[0]);

        $end_date = str_replace('-', '/', $info['end_date']);

        if($start_mk >= $today_mk) {
            if ($info['abbreviation'] == 'all') {
                $sql = " SELECT * FROM  price_changes_tb WHERE  "
                    . "( (('{$start_date}' between `start_date` AND `end_date`) OR  ('{$end_date}' between `start_date` AND `end_date`)) "
                    . " OR ((`start_date` between '{$start_date}' AND '{$end_date}') AND  (`end_date` between '{$start_date}' AND '{$end_date}')) )"
                    . " AND is_enable='yes' AND is_del='no' ";
                $price_changes = $Model->load($sql);


                if (empty($price_changes)) {
                    if ($info['start_date'] <= $info['end_date']) {

                        $data['airline_iata'] = 'allAirline';
                        $data['airline_name'] = 'همه ایرلاین ها';
                        $data['price'] = $info['price'];
                        $data['change_type'] = $info['change_type'];
                        $data['start_date'] = str_replace('-', '/', $info['start_date']) . ' ' . dateTimeSetting::jdate('H:i:s', time(), '', '', 'en');
                        $data['end_date'] = str_replace('-', '/', $info['end_date']) . ' ' . '23:59:59';
                        $data['is_del'] = 'no';
                        $data['is_enable'] = 'yes';


                        $Model->setTable('price_changes_tb');
                        $res = $Model->insertLocal($data);

                        if ($res) {
                            return 'success :  تغییرات با موفقیت انجام شد';
                        } else {
                            return 'error : خطا در  تغییرات';
                        }
                    } else {
                        return 'error : تاریخ شروع از تاریخ پایان نمیتواند بزرگتر باشد';
                    }
                } else {
                    return 'error : برای اعمال تغییر قیمت در همه ایرلاین ها باید تمامی تغییرات فعال در این بازه زمانی حذف شوند';
                }
            } else {
                $info_airline = explode('-', $info['abbreviation']);

                $sqltime = " SELECT * FROM  price_changes_tb WHERE (airline_iata='{$info_airline[0]}' OR airline_iata='allAirline' ) AND "
                    . "( (('{$start_date}' between `start_date` AND `end_date`) OR  ('{$end_date}' between `start_date` AND `end_date`)) "
                    . " OR ((`start_date` between '{$start_date}' AND '{$end_date}') AND  (`end_date` between '{$start_date}' AND '{$end_date}')) )"
                    . " AND is_enable='yes' AND is_del='no' ";


                $price_changes_time = $Model->load($sqltime);

                if (empty($price_changes_time)) {
                    if ($info['start_date'] <= $info['end_date']) {

                        $data['airline_iata'] = $info_airline[0];
                        $data['airline_name'] = $info_airline[1];
                        $data['price'] = $info['price'];
                        $data['change_type'] = $info['change_type'];
                        $data['start_date'] = str_replace('-', '/', $info['start_date']) . ' ' . dateTimeSetting::jdate('H:i:s', time(), '', '', 'en');
                        $data['end_date'] = str_replace('-', '/', $info['end_date']) . ' ' . '23:59:59';
                        $data['is_del'] = 'no';
                        $data['is_enable'] = 'yes';


                        $Model->setTable('price_changes_tb');
                        $res = $Model->insertLocal($data);

                        if ($res) {
                            return 'success :  تغییرات با موفقیت انجام شد';
                        } else {
                            return 'error : خطا در  تغییرات';
                        }
                    } else {
                        return 'error : تاریخ شروع از تاریخ پایان نمیتواند بزرگتر باشد';
                    }
                } else {
                    return 'error : در این بازه زمانی قبلا تغییر قیمت(برای همه ایرلاین ها و یا ایرلاین مورد نظر شما) اعمال شده است';
                }
            }
        } else{
            return 'error : بازه زمانی انتخاب شده صحیح نمی باشد، لطفا بازه زمانی صحیحی را انتخاب نمایید';
        }
    }

    public function DeletePriceChange($id) {

        Load::autoload('Model');
        $model = new Model();

        $data['is_del'] = 'yes';
        $data['is_enable'] = 'no';

        $condition = "id='{$id}'";
        $model->setTable('price_changes_tb');
        $res = $model->update($data, $condition);

        if ($res) {
            return 'success : حذف تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در حذف تغییرات';
        }
    }




}

?>
