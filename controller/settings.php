<?php
/**
 * Class settings
 * @property settings $settings
 */
class settings
{

    #region isEditor
    public function isShowLoginPopup($id = null)
    {
        $Model = Load::library('Model');
        $sql = " SELECT * FROM reservation_is_editor_tb WHERE type = 'loginPopup' ";
        if (isset($id) && $id != '') {
            $sql .= " AND id='{$id}' ";
        }

        $res = $Model->select($sql);

        return $res;

    }
    #endregion

    #region isEditorActive
    public function isShowLoginPopupActive($id)
    {
        $Model = Load::library('Model');

        $sql = " SELECT enable FROM reservation_is_editor_tb WHERE type = 'loginPopup' AND id='{$id}'";
        $result = $Model->load($sql);

        if ($result['enable'] == '1') {
            $data['enable'] = '0';
        } else {
            $data['enable'] = '1';
        }
        $condition = "id='{$id}' ";
        $Model->setTable("reservation_is_editor_tb");
        $res = $Model->update($data, $condition);

        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در  تغییرات';
        }

    }
    #endregion

}