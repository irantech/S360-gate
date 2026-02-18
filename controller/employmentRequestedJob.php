<?php

class employmentRequestedJob extends clientAuth
{

    private $employmentRequestedJob;

    public function __construct()
    {
        parent::__construct();
        $this->employmentRequestedJob = 'employment_requested_job_tb';
    }

    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
    /**
     * @param $requested_job_id
     * @return array|bool|mixed|string
     */


    public function insertJob($params) {
        $dataInsert = [
            'title' => $params['title'],
            'is_active' => true,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
        $insert = $this->getModel('employmentRequestedJobModel')->insertWithBind($dataInsert);
        if ($insert) {
            return self::returnJson(true, 'افزودن شغل درخواستی با موفقیت انجام شد');
        }
        return self::returnJson(false, 'خطا در ثبت شغل درخواستی جدید.', null, 500);
    }
    public function listRequestedJobs($data_main_page = []) {
        $result = [];
        $requested_job_list = $this->getModel('employmentRequestedJobModel')->get();
        $requested_job_table = $requested_job_list->getTable();
        if (!isset($data_main_page['limit']) || empty($data_main_page['limit'])) {
            $data_main_page['limit'] = 10;
        }
        if ($data_main_page['is_active'] ) {
            $requested_job_list->where($requested_job_table . '.is_active', 1);
        }
        $requested_job_list->orderBy('id' ,'DESC')->limit(0,$data_main_page['limit']);
        return $requested_job_list->all();
    }

    public function findJobById($id) {
        return $this->getModel('employmentRequestedJobModel')->get()->where('id' ,$id)->find();
    }

    public function deleteJob($data_update) {
        $check_exist_job = $this->findJobById($data_update['id']);
        if ($check_exist_job) {
            $result_update_job = $this->getModel('employmentRequestedJobModel')->delete("id='{$data_update['id']}'");
            if ($result_update_job) {
                return functions::withSuccess('', 200, 'حذف شغل با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در حذف');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }

    public function getRequestedJob($id) {
        $job_model = $this->getModel('employmentRequestedJobModel');
        $job_table = $job_model->getTable();
        $job_requested = $job_model
            ->get(
                [
                    $job_table . '.*',
                ], true
            )
            ->where($job_table . '.id', $id)
            ->find(false);
        return $job_requested;
    }
    public function updateRequestedJob($params) {
        /** @var requestJobModel $requested_job_model */
        $requested_job_model = $this->getModel('employmentRequestedJobModel');
        $data = [
            'title' => $params['title'],
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $update = $requested_job_model->updateWithBind($data, ['id' => $params['id']]);
        if ($update) {
            return functions::withSuccess('', 200, 'ویرایش شغل  با موفقیت انجام شد');
        }

    }
}
