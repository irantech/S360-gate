<?php

class orderServicesKind extends clientAuth
{
    /**
     * @var string
     */
    protected $table = 'order_services_kind_tb';
    private $kindOrderServicesTb,$page_limit;
    /**
     * @var string
     */

    public function __construct() {
        parent::__construct();
        $this->page_limit = 6;
        $this->kindOrderServicesTb = 'order_services_kind_tb';
    }
    public function addKindIndexes(array $kindList) {
        $result = [];

        foreach ($kindList as $key => $kind) {

            $result[$key] = $kind;
            $time_date = functions::ConvertToDateJalaliInt($kind['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['is_active'] = "{$kind['is_active']}";
        }

        return $result;
    }
    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


    }
    public function insertKindOrderServices($params) {
        $dataKind = [
            'titleFa' => $params['titleFa'],
            'titleEn' => $params['titleEn'],
            'is_active' => true,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];

        $insert = $this->getModel('orderServicesKindModel')->insertWithBind($dataKind);
        if ($insert) {
            return self::returnJson(true, 'افزودن نوع درخواست خدمات با موفقیت انجام شد');
        }

        return self::returnJson(false, 'خطا در ثبت نوع درخواست خدمات جدید.', null, 500);

    }
    public function getAllServicesKind() {
        return $this->getModel( 'orderServicesKindModel' )->get( [
            'id',
            'titleEn',
            'titleFa'
        ] )->where( 'is_active', '1' )->all();
    }
    public function listKindOrderServices() {

     $kindList = $this->getModel('orderServicesKindModel')->get();
     $kind_table = $kindList->getTable();
     $listKind = $kindList->all();
     $result = $this->addKindIndexes($listKind);
        return $result;
    }
    public function findKindOrderById($id) {
       return $this->getModel('orderServicesKindModel')->get()->where('id' , $id)->find();
    }
    public function getKindServices($id) {
        $kind_model = $this->getModel('orderServicesKindModel');
        $kind_table = $kind_model->getTable();
        $kind_order = $kind_model->get([$kind_table.'.*'], true)->where($kind_table . '.id' , $id)->find(false);
        return $this->addKindIndexes([$kind_order])[0];
    }
    public function updateServicesKind($params) {
        /** @var galleryBannerModel $kind_model */
        $kind_model = $this->getModel('orderServicesKindModel');
        $dataUpdate =[];

        $data = [
            'titleFa' => $params['titleFa'],
            'titleEn' => $params['titleEn'],
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $result = array_merge($dataUpdate,$data);

        $update = $kind_model->updateWithBind($result, ['id' => $params['id']]);

        if ($update) {
            return functions::withSuccess('', 200, 'ویرایش نوع خدمات تور  با موفقیت انجام شد');
        }
    }
    public function updateStatusKind($dataStatus){
        $check_exist_kind = $this->findKindOrderById($dataStatus['id']);
        if ($check_exist_kind) {
            $data_update_status['is_active'] = ($check_exist_kind['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_kind['id']}'";
            $result_update_kind = $this->getModel('orderServicesKindModel')->updateWithBind($data_update_status,$condition_update_status);

            if ($result_update_kind) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت  با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت ');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }
    public function deleteOrderServicesKindItem($deleteData) {
        $check_exist_kind_item = $this->findKindOrderById($deleteData['id']);
        if ($check_exist_kind_item) {
            $result = $this->getModel('orderServicesKindModel')->delete("id='{$deleteData['id']}'");
            return functions::withSuccess('', 200, 'حذف با موفقیت انجام شد');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');

    }

}