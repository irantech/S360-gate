<?php

class organizationLevel
{
    #region cunstruct
    public function __construct()
    {

    }
    #endregion

    #region ListAll: list of all organizations
    public function ListAll()
    {
        $Model = Load::library('Model');

        $query = "SELECT O.*, (SELECT COUNT(id) FROM discount_codes_tb WHERE organizationID = O.id) AS usedCount "
               . " FROM organizational_level_tb AS O WHERE O.isDell = 'no'";
        return $Model->select($query);
    }
    #endregion

    #region getOrganizationByID: get one specified record of organization by id
    public function getOrganizationByID($param)
    {
        $Model = Load::library('Model');

        $param = filter_var($param, FILTER_VALIDATE_INT);

        $query = "SELECT * FROM organizational_level_tb WHERE id='{$param}'";
        return $Model->load($query);
    }
    #endregion

    #region organizationAdd: add an organization
    public function organizationAdd($param)
    {
        $Model = Load::library('Model');

        $data['title'] = filter_var($param['title'], FILTER_SANITIZE_STRING);
        $data['isDell'] = 'no';
        $data['creationDateInt'] = time();

        $Model->setTable('organizational_level_tb');
        $resultInsert = $Model->insertLocal($data);

        if ($resultInsert) {
            $output['result_status'] = 'success';
            $output['result_message'] = 'افزودن سطح سازمانی با موفقیت انجام شد';
        } else {
            $output['result_status'] = 'error';
            $output['result_message'] = 'خطا در فرایند افزودن سطح سازمانی';
        }

        return $output;
    }
    #endregion

    #region organizationEdit: edit an organization
    public function organizationEdit($param)
    {
        $param['id'] = filter_var($param['id'], FILTER_VALIDATE_INT);

        $Model = Load::library('Model');

        $sqlExist = "SELECT id AS existID FROM organizational_level_tb WHERE id = '{$param['id']}'";
        $resultSelect = $Model->load($sqlExist);

        if(!empty($resultSelect['existID'])) {

            $data['title'] = filter_var($param['title'], FILTER_SANITIZE_STRING);
            $data['lastEditInt'] = time();

            $Condition = "id='{$param['id']}'";
            $Model->setTable('organizational_level_tb');
            $resultInsert = $Model->update($data, $Condition);

            if ($resultInsert) {
                $output['result_status'] = 'success';
                $output['result_message'] = 'ویرایش سطح سازمانی با موفقیت انجام شد';
            } else {
                $output['result_status'] = 'error';
                $output['result_message'] = 'خطا در فرایند ویرایش سطح سازمانی';
            }

        } else{
            $output['result_status'] = 'error';
            $output['result_message'] = 'خطا در ویرایش سطح سازمانی، سطح سازمانی مورد نظر یافت نشد';
        }

        return $output;
    }
    #endregion

    #region organizationDelete: delete a specified record
    public function organizationDelete($id)
    {
        $Model = Load::library('Model');
        $id = filter_var($id, FILTER_VALIDATE_INT);

        $query = "SELECT COUNT(id) AS usedCount FROM discount_codes_tb WHERE organizationID = '{$id}'";
        $result = $Model->load($query);

        if($result['usedCount'] == 0){

            $data['isDell'] = 'yes';
            $data['lastEditInt'] = time();
            $condition = "id = '{$id}'";

            $Model->setTable('organizational_level_tb');
            $Model->update($data, $condition);

            return 'success: حذف سطح سازمانی با موفقیت انجام شد';
        } else{
            return 'error: خطا در حذف سطح سازمانی، سطح سازمانی مورد نظر  در کد تخفیفی استفاده شده است';
        }

    }
    #endregion
}