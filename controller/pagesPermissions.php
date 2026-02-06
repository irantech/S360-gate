<?php
class pagesPermissions extends clientAuth{
    public function __construct() {
        parent::__construct();
    }

    public function savePage()
    {
        // دریافت ورودی به‌صورت JSON
        $input = json_decode(file_get_contents('php://input'), true);
        $id_member = isset($input['id_member']) ? ($input['id_member']) : '0';
        $id_page   = isset($input['id_page']) ? ($input['id_page']) : '0';
        $can_insert  = isset($input['can_insert']) ? ($input['can_insert']) : '0';
        $can_update  = isset($input['can_update']) ? ($input['can_update']) : '0';
        $can_delete  = isset($input['can_delete']) ? ($input['can_delete']) : '0';

        if ( $id_member == '0' || $id_page == '0') {
            functions::JsonError('کانتر و آدرس صفحه الزامی است');
            return;
        }

        $data = [
            'id_member' => $id_member,
            'id_page'   => $id_page,
            'can_insert' => (string)$can_insert,
            'can_update'   => (string)$can_update,
            'can_delete' => (string)$can_delete,
            'dell' => '0'
        ];
        $res = $this->getModel('pagesPermissionsModel')->insertWithBind($data);
        if ($res)
            functions::JsonSuccess('ثبت با موفقیت انجام شد');
        else
            functions::JsonError('خطا در ثبت رکورد');
    }
    public function deletePage($params) {
        $isPagesPermissions= $this->getModel('pagesPermissionsModel')->get()->where('id', $params['id'])->find();

        if ($isPagesPermissions) {
            $result = $this->getModel('pagesPermissionsModel')->get()
                ->updateWithBind([
                    'dell' => '1'
                ], [
                    'id' => $params['id']
                ]);
            return functions::JsonSuccess($result, 'رکورد مورد نظر حذف شد');
        }
        return functions::JsonError($isPagesPermissions, 'خطا در حذف ', 200);
    }
    // ✅ دریافت همه صفحات برای جدول
    public function getAllPages($idMember)
    {
        $pages = $this->getModel('pagesPermissionsModel')
            ->get()
            ->where('dell', '1', '!=')
            ->where('id_member', $idMember)
            ->all();
        return $pages;
    }
}
