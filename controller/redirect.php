<?php
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
class redirect extends clientAuth
{
    /**
     * @var string
     */
    protected $table = 'redirect_tb';
    private $voteTb, $voteQuestionTb, $page_limit;

    public function __construct() {
        parent::__construct();
        $this->page_limit = 6;
        $this->redirectTb = 'redirect_tb';
    }

    public function getBaseUrl($url) {
        // Check if "resultExternalHotel" exists in the URL
        if (strpos($url, 'resultExternalHotel') !== false) {
            // Use a regular expression to match the base part of the URL
            preg_match('#(https://[^/]+/gds/fa/resultExternalHotel/[^/]+/[^/]+/?)#', $url, $matches);
            // Return the matched base URL
            if (!empty($matches[1])) {
                return $matches[1];
            }
        }
        // If "resultExternalHotel" is not found, return the original URL or handle as needed
        return $url;
    }


    public function insertRedirect($params) {

        $old_url=$params['url_old'];
        if($params['typeRedirect']==='canonical'){
            $old_url=$this->getBaseUrl($params['url_old']);
        }
        $dataInsertRedirect = [
            'type' => $params['typeRedirect'],
            'title' => $params['title'],
            'url_old' => $old_url,
            'url_new' => $params['url_new'],
            'created_at' => date('Y-m-d H:i:s', time()),
            'is_active' => 1,
        ];

        $insert = $this->getModel('redirectModel')->insertWithBind($dataInsertRedirect);

        if ($insert) {
            return self::returnJson(true, 'افزودن لینک با موفقیت انجام شد');
        }
        return self::returnJson(false, 'خطا در ثبت لینک جدید.', null, 500);
    }

    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        $return = json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return $return;
    }

    public function listRedirect() {
        $result = [];
        $redirect_model = $this->getModel('redirectModel')->get()->where('deleted_at', null, 'IS');
        $redirect_table = $redirect_model->getTable();
        $redirect_model->orderBy($redirect_table . '.id', 'DESC');
        $listRedirect = $redirect_model->all(false);
        $result = $this->addRedirectIndexes($listRedirect);
        return $result;
    }

    public function addRedirectIndexes(array $redirectList) {
        $result = [];
        foreach ($redirectList as $key => $item) {
            $result[$key] = $item;
            $time_date = functions::ConvertToDateJalaliInt($item['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['is_active'] = "{$item['is_active']}";
            $result[$key]['title'] = "{$item['title']}";

        }
        return $result;
    }

    public function getRedirect($id) {
        $redirect_model = $this->getModel('redirectModel');
        $redirect_table = $redirect_model->getTable();
        $redirect = $redirect_model->get([
            $redirect_table . '.*',
        ], true)
            ->where($redirect_table . '.id', $id)
            ->where('deleted_at', null, 'IS')
            ->find(false);
        return $this->addRedirectIndexes([$redirect])[0];
    }

    public function getRedirectBy410Url($old_url) {
        $redirect_model = $this->getModel('redirectModel');
        $redirect_table = $redirect_model->getTable();
        $redirect = $redirect_model->get([
            $redirect_table . '.*',
        ], true)
            ->where($redirect_table . '.url_old', $old_url)
            ->where('type', '410')
            ->where('deleted_at', null, 'IS')
            ->find(false);
        return $this->addRedirectIndexes([$redirect])[0];
    }

    public function findRedirectById($id) {
        return $this->getModel('redirectModel')->get()->where('id', $id)->where('deleted_at', null, 'IS')->find();
    }

    public function updateRedirect($params) {

        /** @var redirectModel $redirect_model */
        $redirect_model = $this->getModel('redirectModel');
        $dataUpload = [
            'type' => $params['typeRedirect'],
            'title' => $params['title'],
            'url_old' => $params['url_old'],
            'url_new' => $params['url_new'],
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $update = $redirect_model->updateWithBind($dataUpload, ['id' => $params['id']]);

        if ($update) {
            return self::returnJson(true, 'ویرایش لینک با موفقیت انجام شد');

        }

    }

    public function deleteRedirect($params) {
        $result = $this->getModel('redirectModel')->softDelete([
            'id' => $params['id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'لینک حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف', 200);
    }

    public function checkDataUrl($currentUrl = null) {

        if (!isset($currentUrl)) {
            $currentUrl = $this->currentUrl();
        }
        /** @var redirect $redirect_controller */
        $redirect_controller = $this->getController('redirect');
        return $redirect_controller->getRedirectByOldUrl($currentUrl, 'canonical');
    }

    /**
     * @var string
     */

    protected function currentUrl() {
        return (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    public function getRedirectByOldUrl($old_url, $type = 'redirect') {
        $redirect_model = $this->getModel('redirectModel');
        $redirect_table = $redirect_model->getTable();
        $old_url_with_slash = rtrim($old_url, '/') . '/';
        $old_url_without_slash = rtrim($old_url, '/');
        $redirect = $redirect_model->get([
            $redirect_table . '.*',
        ], true)
            ->where('type', $type)
            ->openParentheses()
            ->where($redirect_table . '.url_old', $old_url_without_slash)
            ->orWhere($redirect_table . '.url_old', $old_url_with_slash)
            ->closeParentheses()
            ->where('deleted_at', null, 'IS')
            ->find(false);
        
        return $this->addRedirectIndexes([$redirect])[0];
    }

}


