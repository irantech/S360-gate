<?php
/**
 * Created by PhpStorm.
 * User: Fani
 * Date: 7/4/2018
 * Time: 12:25 PM
 */


class gashtPriceChanges {

    #region varibles
    public $list = array();
    #endregion

    #region __construct
    public function __construct() {

    }
    #endregion

    #region getAll: get current record for price changes
    public function getAll() {

        $Model = Load::library('Model');
        $query = "SELECT * FROM gasht_price_changes_tb";
        $result = $Model->select($query);
        foreach ($result as $record){

            $counter = $record['counter_id'];
            $this->list[$counter] = $record;

        }

    }
    #endregion

    #region update
    /**
     * update insurance price changes
     * @param associatice array of inputs for update
     * @return success or error
     */
    public function update($input) {

        $Model = Load::library('Model');
        $Model->setTable('gasht_price_changes_tb');

        $record = $this->getByCounter($input['counterID']);

        if($record['id'] > 0) {

            $data['price'] = $input['price'];
            $data['changeType'] = $input['changeType'];
            $data['last_edit_int'] = time();
            $condition = " counter_id = '{$input['counterID']}' ";
            $res = $Model->update($data, $condition);

        } else{

            $data['price'] = $input['price'];
            $data['changeType'] = $input['changeType'];
            $data['counter_id'] = $input['counterID'];
            $data['creation_date_int'] = time();
            $res = $Model->insertLocal($data);

        }

        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در تغییرات';
        }

    }
    #endregion

    #region getByCounter: get one record of insurance price changes by counter_id
    /**
     * @param $couter_id int
     * @return get one record of insurance price changes by counter_id
     */
    public function getByCounter($CounterType) {

        $Model = Load::library('Model');
        $query = "SELECT * FROM gasht_price_changes_tb WHERE counter_id = '{$CounterType}'";
        return $Model->load($query);

    }
    #endregion

}