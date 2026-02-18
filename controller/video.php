<?php
//if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}
class video extends clientAuth {
    /**
     * @var string
     */
    private $videoTb , $page_limit;
    /**
     * @var string
     */
    private $photoUrl;
    public function __construct() {
    parent::__construct();
    $this->videoTb = 'video_tb';
    $this->page_limit = 6;
    }
    /**
     * @param array $videoList
     * @return array
     */
    public function addVideoIndexes(array $videoList) {
        $result = [];

        foreach ($videoList as $key => $video) {

            $result[$key] = $video;
            $time_date = functions::ConvertToDateJalaliInt($video['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['tiny_text'] = strip_tags(substr_replace($video['description'], "...", 250));
            $result[$key]['is_active'] = "{$video['is_active']}";
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
    public function insertVideo($params) {
        $dataVideo = [
            'title' => $params['title'],
            'iframe_code' => $params['iframe_code'],
            'description' => $params['description'],
            'language' => $params['language'],
            'is_active' => true,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
        $insert = $this->getModel('videoModel')->insertWithBind($dataVideo);
        if ($insert) {
            return self::returnJson(true, 'افزودن ویدئو با موفقیت انجام شد');
        }
        return self::returnJson(false, 'خطا در ثبت ویدئو جدید.', null, 500);

    }

    public function listVideo($data_main_page = []) {

        $result = [];
        $videoList = $this->getModel('videoModel')->get();
        $video_table = $videoList->getTable();
        if (!isset($data_main_page['limit']) || empty($data_main_page['limit'])) {
            $data_main_page['limit'] = 10;
        }
        if ($data_main_page['is_active'] ) {
            $videoList->where($video_table . '.is_active', 1);
            $videoList->where($video_table . '.language', SOFTWARE_LANG);
        }
        $listVideo = $videoList->all();
        $result = $this->addVideoIndexes($listVideo);
        return $result;
    }

    public function findVideoById($id) {
        return $this->getModel('videoModel')->get()->where('id', $id)->find();
    }

    public function updateStatusVideo($data_update) {

        $check_exist_video = $this->findVideoById($data_update['id']);
        if ($check_exist_video) {
            $data_update_status['is_active'] = ($check_exist_video['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_video['id']}'";
            $result_update_video = $this->getModel('videoModel')->updateWithBind($data_update_status,$condition_update_status);

            if ($result_update_video) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت ویدئو  با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت ویدئو ');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');

    }

    public function deleteVideo($params) {
        $result = $this->getModel('videoModel')->softDelete([
            'id' => $params['id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'ویدئو حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف', 200);
    }
    public function getVideo($id) {
        $video_model = $this->getModel('videoModel');
        $video_table = $video_model->getTable();
        $video = $video_model
            ->get(
                [
                    $video_table . '.*',
                ], true
            )
            ->where($video_table . '.id', $id)
            ->where($video_table . '.id', $id)
            ->find(false);
        return $this->addVideoIndexes([$video])[0];
    }

    public function updateVideo($params) {
        /** @var videoModel $video_model */
        $video_model = $this->getModel('videoModel');
        $data = [
            'title' => $params['title'],
            'iframe_code' => $params['iframe_code'],
            'language' => $params['language'],
            'description' => $params['description'],
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];

        $update = $video_model->updateWithBind($data, ['id' => $params['id']]);

        if ($update) {
            return self::returnJson(true, 'ویرایش ویدئو با موفقیت انجام شد');
        }

    }








}