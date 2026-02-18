<?php

class reagentPoint extends clientAuth
{
    #region cunstruct
    public function __construct()
    {
        parent::__construct();
    }
    #endregion

    #region ListAll: list of all reagent codes
    public function ListAll()
    {

        Load::autoload('Model');

        $Model = new Model();
	    $sql = " SELECT * FROM reagent_point_tb ORDER BY id DESC";

        return $Model->select($sql);
    }
    #endregion

    #region insertReagentPoint: insert new point and disable all previous points
    public function InsertReagentPoint($param)
    {
        Load::autoload('Model');
        $Model = new Model();

        $data['amount'] = $param['Amount'];
        $data['isActive'] = 'yes';
        $data['creationDateInt'] = time();

        $Model->setTable('reagent_point_tb');
        $res =  $Model->insertLocal($data);
        if($res)
        {
            $dataUpdate['isActive'] = 'no' ;
            $dataUpdate['lastEditInt'] = time() ;
            $condition = "creationDateInt != '{$data['creationDateInt']}' AND isActive = 'yes'";
            $Model->setTable('reagent_point_tb');
            $Model->update($dataUpdate, $condition);

            echo ' success : امتیاز معرف با موفقیت ثبت شد';
        }else{
            echo ' error : خطا در ثبت امتیاز معرف';
        }
    }
    #endregion

    #region getreagentPoint:
    public function GetReagentPoint()
    {
        Load::autoload('Model');
        $Model = new Model();

        $sql = " SELECT * FROM reagent_point_tb WHERE isActive = 'yes'";
        $result = $Model->load($sql);

        if(!empty($result))
        {
            return $result['amount'];
        } else {
            return 0;
        }
    }
    #endregion

    #region checkReagentCode: check if the given reagent code exist or not
    public function checkReagentCode($reagentCode)
    {
        $members = Load::model('members');
        $result = $members->getByReagentCode($reagentCode);

        if($result == 0){
            $output['result_status'] = 'error';
            $output['result_message'] = 'متاسفانه کد معرف نام مورد نظر نامعتبر است';
        } else{
            $output['result_status'] = 'success';
            $output['result_message'] = 'کد معرف مورد نظر متعلق به ' . $result['name'] . ' ' . $result['family'] . ' می باشد';
        }

        return $output;
    }
    #endregion

}