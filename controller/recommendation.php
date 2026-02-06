<?php

//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

class recommendation extends clientAuth
{
    public $noPhotoUrl , $recommendationBaseUrl;
    private $recommendationTb, $visaTypes, $countryCodes;
    /**
     * @var string
     */
    private $page_limit;
        /**

         * @var string
         */
    private $photoUrl;

    public function __construct() {
        parent::__construct();
        $this->recommendationTb = 'recommendation_tb';
        $this->page_limit = 6;
        $this->visaTypes = Load::controller('visaType');
        $this->countryCodes = Load::controller('country');
        $this->noPhotoUrl = 'project_files/images/no-photo.png';
        $this->photoUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/';
        $this->recommendationBaseUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/recommendation' . '/';

    }
    public function my_substr($text, $start = 0, $end) {
        if (empty($text))
            return '';

        if (strlen($text) > $end) {
            $endText = '...';
        } else {
            $endText = '';
        }
        $out = mb_strcut($text, $start, $end, "UTF-8");

        $text = '' . $out . '' . $endText . '';

        return $text;
    }
    /**
     * @param array $recommendationList
     * @return array
     */
    public function addRecommendationIndexes(array $recommendationList) {
        $result = [];

        foreach ($recommendationList as $key => $recommendation) {

            $result[$key] = $recommendation;
            $time_date = functions::ConvertToDateJalaliInt($recommendation['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['avatar_image'] = $this->featuredImageUrl($recommendation['avatar_image']);
            $result[$key]['continent'] = $this->countryCodes->getContinentByCountryId($recommendation['country_id']);
            $result[$key]['country'] = $this->countryCodes->getCountry($recommendation['country_id']);
            $result[$key]['visa_type'] = $this->visaTypes->getVisaTypeByID($recommendation['visa_type_id']);
            $result[$key]['tiny_text'] = strip_tags(substr_replace($recommendation['content'], "...", 250));
            $result[$key]['link'] = "{$this->recommendationBaseUrl}{$recommendation['id']}";

        }

        return $result;
    }

    public function storeRecommendation($params) {


        /** @var recommendationModel $Model */
        $recommendation_model = $this->getModel('recommendationModel');

        $user_data = $this->getUserData($params);
        if (Session::adminIsLogin()) {
            $is_visible=1;
        } else {
            $is_visible=0;
        }
        $recommendation['user_id'] = $user_data['user_id'];
        $recommendation['fullName'] = $user_data['fullName'];
        $recommendation['profession'] = $params['profession'];
        $recommendation['content'] = $params['content'];
        $recommendation['video_link'] = $params['video_link'];
        $recommendation['country_id'] = $params['country'];
        $recommendation['visa_type_id'] = $params['visa_type'];
        $recommendation['language'] = $params['language'];
        $recommendation['is_visible'] = $is_visible;
        $recommendation['created_at'] = date('Y-m-d H:i:s', time());
        $recommendation['updated_at'] = date('Y-m-d H:i:s', time());

        if (isset($_FILES['feature_image'])) {
            /** @var application $config */
            $config = Load::Config('application');
            $path = "recommendation/";
            $config->pathFile($path);
            $avatar_image_upload = $config->UploadFile("pic", "feature_image", "");
            $explode_name_pic = explode(':', $avatar_image_upload);
            if ($explode_name_pic[0] == 'done') {
                $feature_image = $path . $explode_name_pic[1];
                $recommendation['avatar_image'] = $feature_image;
            }
        }
        $insert = $recommendation_model->insertWithBind($recommendation);
        if ($insert) {
            return self::returnJson(true, 'این نطر با موفقیت در سیستم به ثبت رسید');
        }

        return self::returnJson(false, 'خطا در ثبت اطلاعات در سیستم.', null, 500);

    }


    public function updateRecommendation($params) {

        /** @var application $config */
        /** @var recommendationModel $recommendation_model */
        $recommendation_model = $this->getModel('recommendationModel');
        $user_data = $this->getUserData($params);

        $recommendation = $recommendation_model->get()
            ->where('id', $params['recommendation_id'])
            ->find();

        $dataUpdate = [
            'user_id'       => $user_data['user_id'],
            'language'      => $params['language'],
            'fullName'       => $user_data['fullName'],
            'profession'    => $params['profession'],
            'video_link'    => $params['video_link'],
            'content'       => $params['content'],
            'country_id'    => $params['country'],
            'language'      => $params['language'],
            'visa_type_id'  => $params['visa_type'],
            'updated_at'    => date('Y-m-d H:i:s', time()),
        ];

        if (isset($_FILES['feature_image'])) {
            /** @var application $config */
            $config = Load::Config('application');
            $path = "recommendation/";
            $config->pathFile($path);
            $feature_upload = $config->UploadFile("pic", "feature_image", "");
            $explode_name_pic = explode(':', $feature_upload);
            if ($explode_name_pic[0] == 'done') {
                $feature_image = $path . $explode_name_pic[1];
                $dataUpdate['avatar_image'] = $feature_image;
            }
        }

        $update = $recommendation_model->updateWithBind($dataUpdate, ['id' => $params['recommendation_id']]);

        if ($update) {
            return self::returnJson(true, 'نظر با موفقیت در سیستم بروزرسانی شد');
        }

        return self::returnJson(false, 'خطا در ثبت اطلاعات در سیستم.', null, 500);
    }


    public function getRecommendations( $country_id = null, $visa_type_id = null, $page = null , $visible = true , $data_main_page = [], $get_all = null){

        $recommendation_model = $this->getModel('recommendationModel');
        $recommendation_count_model = $this->getModel('recommendationModel');
        $recommendation_table = $recommendation_model->getTable();

        $recommendation_count = $recommendation_count_model
            ->get([
                'count(' . $recommendation_table . '.id) as count',
            ], true);


        $recommendations = $recommendation_model
            ->get([
                $recommendation_table . '.*',
            ], true);

        if (!$get_all) {
            $recommendations = $recommendations
                ->where($recommendation_table . '.language', SOFTWARE_LANG);
        }


        $recommendations = $recommendations
            ->where($recommendation_table . '.deleted_at', null, 'IS');
        $recommendation_count = $recommendation_count
            ->where($recommendation_table . '.deleted_at', null, 'IS');

        if($visible) {
            $recommendations = $recommendations
                ->where($recommendation_table . '.is_visible', '1');
            $recommendation_count = $recommendation_count
                ->where($recommendation_table . '.is_visible', '1');
        }


        if ($visa_type_id) {
            $recommendations = $recommendations->where($recommendation_table . '.visa_type_id', "%$visa_type_id%", 'like');
            $recommendation_count = $recommendation_count->where($recommendation_table . '.visa_type_id', "%$visa_type_id%", 'like');
        }
        if ($data_main_page['is_visible'] ) {
            $recommendations = $recommendations
                ->where($recommendation_table . '.is_visible', '1');
            $recommendation_count = $recommendation_count
                ->where($recommendation_table . '.is_visible', '1');
        }
        $recommendations = $recommendations->groupBy($recommendation_table . '.id')->orderBy($recommendation_table . '.id');


            if (isset($data_main_page['limit']) || !empty($data_main_page['limit'])){
                $recommendations = $recommendations
                    ->limit(0,$data_main_page['limit']);
            }


        $count = $recommendation_count->find();

        $result['items_count'] = $count['count'];
        $result['per_page'] = $this->page_limit;
        $result['count'] = ceil($count['count'] / $this->page_limit);
        $result['current_page'] = ROOT_ADDRESS . '/recommendation?page=' . $page;

        for ($x = 0; $x < $result['count']; $x++) {
            $count = ($x + 1);
            $result['links'][] = [
                'index' => $count,
                'link' => ROOT_ADDRESS . '/recommendation?page=' . $count
            ];
        }
        if ($page) {
            $offset = ($page - 1) * $this->page_limit;
            $recommendations = $recommendations->limit($offset, $this->page_limit);
        }
//        if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//            $recommendations = $recommendations->toSqlDie();
//        }

        $recommendations = $recommendations->all(false);


        $result['data'] = $this->addRecommendationIndexes($recommendations);

//        var_dump(count($result['data']));
//        var_dump($result);
        return $result;
    }

    public function getRecommendation($id) {
        $recommendation_model = $this->getModel('recommendationModel');
        $recommendation_table = $recommendation_model->getTable();

        $recommendation = $recommendation_model
            ->get(
                [
                    $recommendation_table . '.*',
                ], true
            )
            ->where($recommendation_table . '.id', $id)
            ->find(false);

        return $this->addRecommendationIndexes([$recommendation])[0];
    }

    public function DeleteRecommendation($params) {
        $result = $this->getModel('recommendationModel')->softDelete([
            'id' => $params['recommendation_id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'این نظر حذف شد');
        }
        return functions::JsonError($result, 'خطا در نظر', 200);
    }

    // user who add or edit recommendation
    private function getUserData($params) {
        if (Session::IsLogin()) {
            Load::library('Session');
            $user_id = Session::getUserId();
            $user_info = functions::infoMember($user_id);
            $data['user_id'] = $user_id;
            $data['fullName'] = $user_info['name'] . ' ' . $user_info['family'];
        } else {
            $data['user_id'] = 0;
            if (Session::adminIsLogin()) {
                $data['fullName'] = $params['fullName'];
            }
        }
        return $data;
    }

    public function featuredImageUrl($feature_image) {
        $url = (!empty($feature_image)) ? $this->photoUrl . $feature_image : $this->noPhotoUrl;
        return str_replace('recommendations', 'recommendations', $url);
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

    public function getContinentList() {
        return $this->countryCodes->continentsList();
    }

    public function getCountryListByContinentId($param){
        return $this->countryCodes->countriesOfContinent($param);
    }

    public function getVisaTypeList() {
        return $this->visaTypes->allVisaTypeList();
    }

    public function recommendationSelectedToggle($param) {
        $recommendation_id = $param['recommendation_id'];
        $recommendation_model = $this->getModel('recommendationModel');
        $recommendation = $recommendation_model->get()->where('id', $recommendation_id)->find(false);

        $select_status = 1;
        $final_massage = 'این نظر نمایش داده میشود';
        if ($recommendation['is_visible'] == '1') {
            $select_status = 0;
            $final_massage = 'این نظر از لیست نظرات حذف شد.';
        }
        $update_result = $recommendation_model->updateWithBind([
            'is_visible' => $select_status
        ], [
            'id' => $recommendation_id
        ]);
        if ($update_result) {
            return functions::JsonSuccess($select_status, [
                'message' => $final_massage,
                'data' => $select_status
            ], 200);
        }
        return functions::JsonError($update_result, [
            'message' => 'خطا در ویرایش نظر',
            'data' => $select_status
        ], 200);
    }

    public function getRecommendationsPosition($data_search) {


        $recommendation_model = $this->getModel('recommendationModel');
        $recommendation_table = $recommendation_model->getTable();

        if (!isset($data_search['limit']) || empty($data_search['limit'])) {
            $data_search['limit'] = 10;
        }

        $recommendations = $recommendation_model->get()
            ->where($recommendation_table . '.deleted_at', null, 'IS')
            ->where($recommendation_table . '.is_visible', '1');

        $recommendations = $recommendations->orderBy($recommendation_table . '.created_at');


        $recommendations = $recommendations->limit(0, $data_search['limit'])->all(false);


        return $this->addRecommendationIndexes($recommendations);

    }

}
