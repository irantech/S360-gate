<?php

class memberGroups
{
    public $resultSelectForEdit;

    #region cunstruct
    public function __construct()
    {

    }
    #endregion

    #region ListAll: list of all groups
    public function ListAll()
    {
        $Model = Load::library('Model');

        $sqlSelect = "SELECT * FROM sms_groups_tb";
        return $Model->select($sqlSelect);
    }
    #endregion

    #region getGroupByID: one specified record of groups
    public function getGroupByID($param)
    {
        $Model = Load::library('Model');

        $param = filter_var($param, FILTER_VALIDATE_INT);

        $sqlSelect = "SELECT * FROM sms_groups_tb WHERE id='{$param}'";
        return $Model->load($sqlSelect);
    }
    #endregion

    #region groupsAdd: add a group
    public function groupsAdd($param)
    {
        $Model = Load::library('Model');

        $data['title'] = filter_var($param['title'], FILTER_SANITIZE_STRING);
        $data['creationDateInt'] = time();

        $Model->setTable('sms_groups_tb');
        $resultInsert = $Model->insertLocal($data);

        if ($resultInsert) {
            $output['result_status'] = 'success';
            $output['result_message'] = 'افزودن گروه با موفقیت انجام شد';
        } else {
            $output['result_status'] = 'error';
            $output['result_message'] = 'خطا در فرایند افزودن گروه';
        }

        return $output;
    }
    #endregion

    #region groupsEdit: edit a group
    public function groupsEdit($param)
    {
        $param['id'] = filter_var($param['id'], FILTER_VALIDATE_INT);

        $Model = Load::library('Model');

        $sqlExist = "SELECT id AS existID FROM sms_groups_tb WHERE id = '{$param['id']}'";
        $resultSelect = $Model->load($sqlExist);

        if(!empty($resultSelect['existID'])) {

            $data['title'] = filter_var($param['title'], FILTER_SANITIZE_STRING);
            $data['lastEditInt'] = time();

            $Condition = "id='{$param['id']}'";
            $Model->setTable('sms_groups_tb');
            $resultInsert = $Model->update($data, $Condition);

            if ($resultInsert) {
                $output['result_status'] = 'success';
                $output['result_message'] = 'ویرایش گروه با موفقیت انجام شد';
            } else {
                $output['result_status'] = 'error';
                $output['result_message'] = 'خطا در فرایند ویرایش گروه';
            }

        } else{
            $output['result_status'] = 'error';
            $output['result_message'] = 'خطا در ویرایش گروه، گروه مورد نظر یافت نشد';
        }

        return $output;
    }
    #endregion

    #region getGroupMembers: return members of a specified group
    public function getGroupMembers($groupID)
    {
        $groupID = filter_var($groupID, FILTER_VALIDATE_INT);

        $Model = Load::library('Model');

        $sqlSelect = "SELECT M.* FROM members_tb M INNER JOIN members_groups_tb MG ON M.id = MG.memberID WHERE MG.groupID = '{$groupID}'";
        return $Model->select($sqlSelect);
    }
    #endregion

    #region getNotInGroupMembers: return members Who are not in a specified group
    public function getNotInGroupMembers($groupID)
    {
        $groupID = filter_var($groupID, FILTER_VALIDATE_INT);

        $Model = Load::library('Model');

        $sqlSelect = "SELECT * FROM members_tb WHERE is_member = '1' AND id NOT IN(SELECT memberID FROM members_groups_tb WHERE groupID = '{$groupID}')";
        return $Model->select($sqlSelect);
    }
    #endregion

    #region setMmembersGroup: set members to a specified group
    public function setMmembersGroup($param)
    {
        $groupID = filter_var($param['id'], FILTER_VALIDATE_INT);

        $Model = Load::library('Model');
        $Model->setTable('members_groups_tb');
        $sqlSelect = "SELECT memberID FROM members_groups_tb WHERE groupID = '{$groupID}'";
        $resultSelect = $Model->select($sqlSelect);

        //first remove records which is not in post
        foreach ($resultSelect as $item){
            if(empty($param['groupChanges']) || (!empty($param['groupChanges']) && !in_array($item['memberID'], $param['groupChanges']))){
                $condition = "memberID = '{$item['memberID']}' AND groupID = '{$groupID}'";
                $Model->delete($condition);
            }
        }

        //now add new records which added in psot
        if(!empty($param['groupChanges'])) {
            foreach ($param['groupChanges'] as $item) {
                echo array_search($item, $resultSelect);

                if (!empty($item)) {

                    $flag = true;
                    foreach ($resultSelect as $exist){
                        if($item == $exist['memberID']){
                            $flag = false;
                        }
                    }

                    if($flag) {
                        $data['memberID'] = filter_var($item, FILTER_VALIDATE_INT);
                        $data['groupID'] = $groupID;
                        $data['creationDateInt'] = time();
                        $Model->insertLocal($data);
                    }
                }

            }
        }

        $output['result_status'] = 'success';
        $output['result_message'] = 'تغییرات با موفقیت انجام شد';

        return $output;
    }
    #endregion
}