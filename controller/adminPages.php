<?php
class adminPages extends clientAuth{
    public function __construct() {
        parent::__construct();
    }

    public function savePage()
    {
        // دریافت ورودی به‌صورت JSON
        $input = json_decode(file_get_contents('php://input'), true);

        $id      = isset($input['id']) ? intval($input['id']) : 0;
        $title   = isset($input['title']) ? trim($input['title']) : '';
        $address = isset($input['address']) ? trim($input['address']) : '';

        if ($title == '' || $address == '') {
            functions::JsonError('عنوان و آدرس صفحه الزامی است');
            return;
        }

        $data = [
            'title' => $title,
            'address'   => $address,
        ];
        if ($id > 0) {
            // 🔹 ویرایش رکورد
            $res = $this->getModel('adminPagesModel')
                ->updateWithBind($data, [
                    'id' => $id
                ]);
            if ($res)
                functions::JsonSuccess('ویرایش با موفقیت انجام شد');
            else
                functions::JsonError('خطا در ویرایش رکورد');
        } else {
            // 🔹 درج رکورد جدید
            $data['dell'] = 0;
            $res = $this->getModel('adminPagesModel')->insertWithBind($data);
            if ($res)
                functions::JsonSuccess('ثبت با موفقیت انجام شد');
            else
                functions::JsonError('خطا در ثبت رکورد');
        }
    }
    public function getPageById()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = isset($input['id']) ? intval($input['id']) : 0;
        if ($id <= 0) {
            functions::JsonError('شناسه نامعتبر است');
            return;
        }

        $page = $this->getModel('adminPagesModel')
            ->get()
            ->where('dell', '1', '!=')
            ->where('id', $id)
            ->find();
        return $page;
    }
    public function deletePage($params) {
        $isAdminPages = $this->getModel('adminPagesModel')->get()->where('id', $params['id'])->find();

        if ($isAdminPages) {
            $result = $this->getModel('adminPagesModel')->get()
                ->updateWithBind([
                    'dell' => '1'
                ], [
                    'id' => $params['id']
                ]);
            return functions::JsonSuccess($result, 'رکورد مورد نظر حذف شد');
        }
        return functions::JsonError($isAdminPages, 'خطا در حذف ', 200);
    }
    public function getAllPages()
    {
        $pages = $this->getModel('adminPagesModel')
            ->get()
            ->where('dell', '1', '!=')
            ->orderBy('title', 'ASC')
            ->all();
        return $pages;
    }
}
