<?php


class infoPages extends positions
{


    private $pages_info_model;
    private $pages_info_table;
    private $page_info_positions_model;
    private $page_info_positions_table;
    private $switch_model;
    private $switch_table;

    public function __construct() {
        parent::__construct();
        $this->pages_info_model = $this->getModel('pagesInfoModel');
        $this->pages_info_table = $this->pages_info_model->getTable();
        $this->page_info_positions_model = $this->getModel('pageInfoPositionsModel');
        $this->page_info_positions_table = $this->page_info_positions_model->getTable();
        $this->switch_model = $this->getModel('gdsSwitchModel');
        $this->switch_table = $this->switch_model->getTable();
    }

    public function getInfoPagByGdsSwitch($gds_switch) {
        //search for Flight Insurance or ... and get name of each Route.
     
        $service_indexes = $this->serviceIndexes();

        if ((isset($service_indexes['origin']['index']) || isset($service_indexes['destination']['index'])) && ($service_indexes['origin']['index'] || $service_indexes['destination']['index'])) {
            $find_service_route = $this->getInfoPagePositionByRoute($service_indexes);
            $page_info = $this->getInfoPageById($find_service_route['page_id']);

            if (!$page_info) {

                $page_info = $this->getInfoPageBySwitch($gds_switch, false);

                if (!$page_info) {
                    $page_info = $this->getInfoPageBySwitch('mainPage');

                    $page_info['title'] = $service_indexes['title'] . ' | ' . $page_info['title'];
                    $page_info['name'] = $service_indexes['title'] ?: $page_info['title'];
                    $page_info['heading'] = $service_indexes['heading'] ?: $service_indexes['title'];
                    $page_info['switch']= [];
                    $page_info['switch']['gds_switch'] = $service_indexes['switch'];

                }
            }
            return $page_info;
        }

        return $this->getInfoPageBySwitch($gds_switch);


    }

    /**
     * @param array $defined_data
     * @return mixed
     */
    public function getInfoPagePositionByRoute(array $defined_data) {
        $Model = Load::library('Model');
        $sql = "
                SELECT
                    page_info_positions_tb.* 
                FROM
                    page_info_positions_tb 
                inner join pages_info_tb on pages_info_tb.id = page_info_positions_tb.page_id
                WHERE";

        if (isset($defined_data['origin']['index']) && $defined_data['origin']['index']) {
            $sql .= "(
                    CASE
                            
                        WHEN ( SELECT count( id ) FROM page_info_positions_tb WHERE service = '" . $defined_data['service'] . "' AND origin like '" . $defined_data['origin']['index'] . "' )
                            THEN
                                origin like '" . $defined_data['origin']['index'] . "' 
                            ELSE
                                origin = 'all' 
                            END 
                    ) AND";
        }

        $sql .= " service = '" . $defined_data['service'] . "'";

        if (isset($defined_data['destination']['index']) && $defined_data['destination']['index']) {
            $sql .= "AND (
                        CASE
                                
                            WHEN ( SELECT count( id ) FROM page_info_positions_tb WHERE service = '" . $defined_data['service'] . "' AND destination = '" . $defined_data['destination']['index'] . "' ) 
                                THEN
                                    destination = '" . $defined_data['destination']['index'] . "' 
                                ELSE 
                                    destination = 'all' 
                        END)
                        
                       ";
        }
        $sql .= " And (pages_info_tb.deleted_at IS NULL) ";
       
        return $Model->load($sql);
    }

    public function getInfoPageById($id) {

        $page = $this->pages_info_model
            ->get()
            ->where('id', $id)
            ->where('deleted_at', null, 'IS')
            ->where('language', SOFTWARE_LANG)
            ->find(false);

        if ($page) {
            return $this->pagesIndexes([$page])[0];
        }
    }

    public function pagesIndexes($pages) {

        $result = [];
        foreach ($pages as $key => $page) {
            $result[$key] = $page;
            if ($page['switch_id'] > 0) {
                $result[$key]['switch'] = $this->getSwitchById($page['switch_id']);
            } else {
                $result[$key]['service'] = $this->getService($page['id']);
            }
            $meta_tags = json_decode($page['meta_tags'], true);
            $meta_tags_array = [];
            foreach ($meta_tags as $meta_tag) {
                if (isset($meta_tag['name']) && $meta_tag['name'] == 'description') {
                    $result[$key]['description'] = $meta_tag['content'];
                } else {
                    $meta_tags_array[] = $meta_tag;
                }
            }
            $result[$key]['meta_tags'] = $meta_tags_array;
            $result[$key]['all_meta_tags'] = $meta_tags;
            $result[$key]['name'] = !empty($page['name']) ? $page['name'] : $page['title'];

            $result[$key]['heading'] = !empty($page['heading']) ? $page['heading'] : $result[$key]['name'];

        }
        return $result;
    }

    public function getSwitchById($id) {
        return $this->switch_model->get()
            ->where('id', $id)
            ->find();
    }

    public function getService($page_id) {
       
        $service = $this->page_info_positions_model->get()
            ->where('page_id', $page_id)
            ->find();

        $cities = ['origin', 'destination'];
        foreach ($cities as $item) {

            if ($service[$item] && $service[$item] != 'all') {
                $service[$item . '_name'] = $this->listAllPositions($service['service'])[$service[$item]]['name'];
            } else {
                $service[$item . '_name'] = $item == 'destination' ? 'همه ی مقاصد' : 'همه ی مبداء ها';
            }
        }
        return $service;
    }

    public function getInfoPageBySwitch($switch_name, $has_main_page = true) {


        $switch = $this->getSwitchByName($switch_name, $has_main_page);


        if ($switch) {

            $page = $this->pages_info_model
                ->get()
                ->where('switch_id', $switch['id'])
                ->where('deleted_at', null, 'IS')
                ->where('language', SOFTWARE_LANG)
                ->find(false);


            if (!$page && $has_main_page) {
                $page = $this->pages_info_model
                    ->get()
                    ->where('switch_id', 1)
                    ->where('deleted_at', null, 'IS')
                ->where('language', SOFTWARE_LANG)
                    ->find(false);
            }
          
            if ($page) {
                return $this->pagesIndexes([$page])[0];
            }
            return false;
        }

        return false;
    }

    public function getSwitchByName($switch_name, $has_main_page = true) {
        $switch = $this->switch_model->get()
            ->where('gds_switch', $switch_name)
            ->find();

        if (!$switch && $has_main_page) {

            $switch = $this->switch_model->get()
                ->where('gds_switch', 'mainPage')
                ->find();
        }

        if ($switch) {
            return $switch;
        }
        return false;
    }

    public function getPages($service = null) {

        if ($_SERVER['REMOTE_ADDR'] == '192.168.1.14') {

            return $this->pages_info_model->get()
                ->join($this->page_info_positions_table, 'page_id', 'id')
                ->where($this->page_info_positions_table . '.service', $service)
                ->where($this->pages_info_table . '.deleted_at', null, 'IS')
                ->groupBy($this->pages_info_table . '.id')
                ->all(false);
        } else {
            return $this->pages_info_model->get()
                ->all(false);
        }
    }

    public function getMainPages() {
        $result = $this->pages_info_model->get()
            ->where('type', 'main')
            ->where('deleted_at', null, 'IS')
            ->all(false);
        return $this->pagesIndexes($result);
    }

    public function getServicePages() {
        $result = $this->pages_info_model->get()
            ->where('deleted_at', null, 'IS')
            ->where('type', 'service')
            ->all(false);
        return $this->pagesIndexes($result);
    }

    public function newPageInformation($params) {
        $added_metas = '';
        $switch_id = 0;
        $type = 'service';
        if(!$params['heading']){
            $params['heading'] = $params['title'];
        }
        if ($params['page_type'] === 'main_page') {
            $is_duplicated_page_info_switch = $this->isDuplicatePageInfoSwitch($params['switch']);
            if ($is_duplicated_page_info_switch)
                return functions::JsonError(false, 'برای این صفحه عنوان دیگری وجود دارد', 200);

            $switch_id = $params['switch'];
            $type = 'main';
        } else {
            $is_duplicated_page_info_service = $this->isDuplicatePageInfoService([
                'service' => $params['service'],
                'origin' => $params['origin_position'],
                'destination' => $params['destination_position'],
            ]);

            if ($is_duplicated_page_info_service)
                return functions::JsonError(false, 'برای این صفحه عنوان دیگری وجود دارد', 200);

        }

        $description = [
            'name' => 'description',
            'content' => filter_var($params['description'], FILTER_SANITIZE_STRING)
        ];


        if ($params['AddedMeta']) {
            $added_metas = json_encode(array_merge($params['AddedMeta'], [$description]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }


        $data = [
            'title' => filter_var($params['title'], FILTER_SANITIZE_STRING),
            'heading' => filter_var($params['heading'], FILTER_SANITIZE_STRING),
            'language' => filter_var($params['language'], FILTER_SANITIZE_STRING),
            'type' => $type,
            'switch_id' => $switch_id,
            'meta_tags' => $added_metas,
        ];
        $insert_result = $this->pages_info_model->insertWithBind($data);

        $this->page_info_positions_model->delete([
            'page_id' => $insert_result
        ]);

        if($params['service'] == 'Hotel') {
            $origin = $this->getModel('externalHotelCityModel')->get()
                ->where('country_code', null, 'IS NOT')
                ->openParentheses()
                ->where('country_code',  $params['origin_position'] , 'like')
                ->orWhere('country_name_en', $params['origin_position'] , 'like')
                ->orWhere('country_name_fa',  $params['origin_position'] , 'like')
                ->orWhere('city_name_en',  $params['origin_position'] , 'like')
                ->orWhere('city_name_fa',  $params['origin_position'] , 'like')
                ->closeParentheses()
                ->find();
            if($origin) {
                $params['service'] = 'ExternalHotel';
            }
        }

        if ($params['page_type'] === 'main_services') {
            $this->page_info_positions_model->insertWithBind([
                'page_id' => $insert_result,
                'service' => $params['service'],
                'origin' => $params['origin_position'],
                'destination' => $params['destination_position'],
            ]);
        }

        return functions::JsonSuccess($insert_result, 'ثبت شد', 200);

    }

    public function isDuplicatePageInfoSwitch($switch_id, $page_id = null) {
        $page = $this->pages_info_model->get()
            ->where('switch_id', $switch_id)
            ->where('deleted_at', null, 'IS');
        if ($page_id) {
            $page = $page->where('id', $page_id, '!=');
        }
        $page = $page->find();
        if ($page)
            return true;
        return false;
    }

    public function isDuplicatePageInfoService($service, $page_id = null) {
        $page = $this->pages_info_model->get()
            ->join($this->page_info_positions_table, 'page_id', 'id')
            ->where($this->page_info_positions_table . '.service', $service['service']);
        if (isset($service['origin']) && $service['origin']) {
            $page = $page->where($this->page_info_positions_table . '.origin', $service['origin']);
        }
        if (isset($service['destination']) && $service['destination']) {
            $page = $page->where($this->page_info_positions_table . '.destination', $service['destination']);
        }

        $page = $page->where($this->pages_info_table . '.deleted_at', null, 'IS');
        if ($page_id) {
            $page = $page->where($this->pages_info_table . '.id', $page_id, '!=');
        }
        $page = $page->find();
        if ($page)
            return true;
        return false;
    }

    public function updatePageInformation($params) {
        $added_metas = '';
        $switch_id = 0;
        $type = 'service';
        if(!$params['heading']){
            $params['heading'] = $params['title'];
        }
        if ($params['page_type'] === 'main_page') {
            $is_duplicated_page_info_switch = $this->isDuplicatePageInfoSwitch($params['switch'], $params['id']);
            if ($is_duplicated_page_info_switch)
                return functions::JsonError(false, 'برای این صفحه عنوان دیگری وجود دارد', 200);

            $switch_id = $params['switch'];
            $type = 'main';
        } else {
            $is_duplicated_page_info_service = $this->isDuplicatePageInfoService([
                'service' => $params['service'],
                'origin' => $params['origin_position'],
                'destination' => $params['destination_position'],
            ], $params['id']);

            if ($is_duplicated_page_info_service)
                return functions::JsonError(false, 'برای این صفحه عنوان دیگری وجود دارد', 200);

        }


        $description = [
            'name' => 'description',
            'content' => filter_var($params['description'], FILTER_SANITIZE_STRING)
        ];


        if ($params['AddedMeta']) {
            $added_metas = json_encode(array_merge($params['AddedMeta'], [$description]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }


        $data = [
            'title' => filter_var($params['title'], FILTER_SANITIZE_STRING),
            'heading' => filter_var($params['heading'], FILTER_SANITIZE_STRING),
            'language' => filter_var($params['language'], FILTER_SANITIZE_STRING),
            'type' => $type,
            'switch_id' => $switch_id,
            'meta_tags' => $added_metas,
        ];
        $insert_result = $this->pages_info_model->updateWithBind($data, ['id' => $params['id']]);

        $this->page_info_positions_model->delete([
            'page_id' => $params['id']
        ]);
        if($params['service'] == 'Hotel') {
            $origin = $this->getModel('externalHotelCityModel')->get()
                ->where('country_code', null, 'IS NOT')
                ->openParentheses()
                ->where('country_code',  $params['origin_position'] , 'like')
                ->orWhere('country_name_en', $params['origin_position'] , 'like')
                ->orWhere('country_name_fa',  $params['origin_position'] , 'like')
                ->orWhere('city_name_en',  $params['origin_position'] , 'like')
                ->orWhere('city_name_fa',  $params['origin_position'] , 'like')
                ->closeParentheses()
                ->find();
           if($origin) {
               $params['service'] = 'ExternalHotel';
           }
        }
        if ($params['page_type'] === 'main_services') {
            $this->page_info_positions_model->insertWithBind([
                'page_id' => $params['id'],
                'service' => $params['service'],
                'origin' => $params['origin_position'],
                'destination' => $params['destination_position'],
            ]);
        }
        return functions::JsonSuccess($insert_result, 'ویرایش شد', 200);
    }

    public function getGdsSwitches() {
        return $switches = $this->switch_model->get()->all();
    }

    public function removePage($params) {
        $result = $this->pages_info_model->softDelete([
            'id' => $params['id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, ' حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف', 200);

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

    public function uploadRobotsFile() {
        $path =  'view/' . FRONT_TEMPLATE_NAME . '/project_files/';
        $ext = explode(".", $_FILES['robots_file']['name']);
        $_FILES['robots_file']['name'] = 'robots';

        $ext = strtolower($ext[count($ext)-1]);

        $_FILES['robots_file']['name'] = $_FILES['robots_file']['name'].".".$ext;
        $final_file = $path . $_FILES['robots_file']['name'];

        // بررسی حجم فایل (مثلاً حداکثر ۱۰ مگابایت)
        $max_file_size = 10 * 1024 * 1024;  // ۱۰ مگابایت

        if ($_FILES['robots_file']['size'] > $max_file_size) {
            return self::returnJson(false, 'حجم فایل از حد مجاز بیشتر است. لطفاً یک فایل کوچک‌تر انتخاب کنید.');
        }

        if (in_array($ext, array('txt'))) {
            // بررسی وجود دایرکتوری
            if (!is_dir($path)) {
                mkdir($path, 0777, true); // دایرکتوری رو بساز
            }

            $result_upload = move_uploaded_file($_FILES['robots_file']['tmp_name'], $final_file);


            if (!$result_upload) {
                $error_message = error_get_last();
                return self::returnJson(false, 'آپلود نشد. خطا: ' . $error_message['message']);
            } else {
                return self::returnJson(true, 'آپلود با موفقیت انجام شد');
            }

        } else {
            return self::returnJson(false, 'خطا در آپلود فایل ، لطفا پسوند فایل را بررسی نمایید');
        }
    }
}