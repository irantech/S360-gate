<?php

//if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}
class specialPages extends positions
{
    protected $special_pages_model;
    /**
     * @var string
     */
    private $noPhotoUrl;
    /**
     * @var string
     */
    private $photoUrl , $services;
    /**
     * @var string[]
     */
    private $files;
    /**
     * @var airportModel|bool|FlightPortalModel|flightRouteCustomerModel|flightRouteModel|mixed|Model|ModelBase|reservationTourTourtypeModel
     */
    private $special_page_gallery_model;

    public function __construct() {
        parent::__construct();
        $this->special_pages_model = $this->getModel('specialPagesModel');
        $this->special_page_gallery_model = $this->getModel('specialPageGalleryModel');
        $this->noPhotoUrl = 'project_files/images/no-photo.png';
        $this->photoUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/special_pages/';
        $this->files = ['attach_files', 'gallery_files'];
        $this->services = Load::controller('services');

    }

    public function infoSiteMap($table) {
        $model = $this->getModel('specialPagesModel');
        $table = $model->getTable();
        $result = $model
            ->get([
                $table . '.*',
            ], true);
        $result = $result
            ->where($table . '.deleted_at', null, 'IS');
//        $result = $result
//            ->where($table . '.language', SOFTWARE_LANG);
        $result = $result->groupBy($table . '.slug')->orderBy($table . '.id');
        $result = $result->all(false);

        foreach ($result as $key => $item) {
            $url = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . $item['language'] . '/page/'.$item['slug'];
            $data_sitemap['loc'] = $url;
            $data_sitemap['priority'] = '0.1';
            $data_sitemap['lastmodJalali'] = functions::ConvertToJalali($item['updated_at'], '/');
            $data_sitemap['lastmod'] = functions::ConvertToMiladi($data_sitemap['lastmodJalali'], '-');
            $result_sitemap_final[] = $data_sitemap;
        }

        return [$result_sitemap_final];
    }

    public function changeNameUpload($fileName) {
        $ext = explode(".", $fileName);
        $fileName = date("sB")."-" . rand(10, 10000);
        $ext = strtolower($ext[count($ext)-1]);
        $fileName = $fileName.".".$ext;
        return $fileName;
    }
    public function addSpecialPage($params) {

        $page_type = $params['page_type'];
        $attach_type = $params['attach_type'];
        $has_search_box = false;
        if (isset($params['has_search_box'])) {
            $has_search_box = true;
        }
        $positions = null;
        if (($page_type === 'attach' && $attach_type === 'search_box') || ($page_type === 'separate' && $has_search_box)) {
            $positions = $params['positions'];
        } elseif ($page_type === 'attach' && $attach_type === 'main_page') {
            $positions = 'MainPage';
        }
        $title = $params['title'];
        $slug = functions::slugify($params['title']);
        if (isset($params['slug']) && $params['slug'] != '') {
            $slug = functions::slugify($params['slug']);
        }
        $language = $params['language'];
        $check_slug = $this->special_pages_model->get()->where('slug' , $slug)->where('language' , $language)->find();
        if (!$check_slug) {
        $uploaded_files = [];
        $added_metas = '';


        $description = [
            'name' => 'description',
            'content' => filter_var($params['description'], FILTER_SANITIZE_STRING)
        ];

        if(!$params['heading']){
            $params['heading'] = $title;
        }


        if ($params['AddedMeta']) {
            $added_metas = json_encode(array_merge($params['AddedMeta'], [$description]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        $data = [
            'title' => $title,
            'heading' => $params['heading'],
            'slug' => $slug,
            'content' => $params['content'],
            'language' => $params['language'],
            'page_type' => $page_type,
            'attach_type' => $attach_type,
            'position' => $positions,
            'meta_tags' => $added_metas,
        ];

        $insert_data = $this->special_pages_model
            ->insertWithBind($data);


            if (isset($params['position']) && $params['position'] != '') {

                $this->storePositions('special_pages', $insert_data, $params['position']);

            }

        $attach_files = [];
        $main_file = [];
        $main_file['alt'] = $params['main_file_alt'];
        $config = Load::Config('application');
        $path = "special_pages/";
        $config->pathFile($path);
        foreach ($this->files as $file) {
            if (isset($_FILES[$file]) && $_FILES[$file] != "") {
                $separated_files = functions::separateFiles($file);
                foreach ($separated_files as $image_key => $separated_file) {
                    $separated_file['name'] = self::changeNameUpload($separated_file['name']);
                    $_FILES['file']='';
                    $_FILES['file'] = $separated_file;

                    if (isset($params['gallery_selected']) && strval($params['gallery_selected']) == strval($image_key)) {
                        $params['main_file_alt'] = $params['gallery_file_alts'][$image_key];

                        $main_file_upload = $config->UploadFile("pic", "file", "5120000");
                        $explode_name_pic = explode(':', $main_file_upload);

                        if ($explode_name_pic[0] == 'done') {
                            $feature_image = $path . $explode_name_pic[1];
                            $main_file=[
                                'src'=>$feature_image,
                                'alt'=>$params['main_file_alt']
                            ];

                        }

                    }else{
                        $success = $config->UploadFile("pic", "file", 500000);
                        $explode_name_pic = explode(':', $success);
                    }


                    if ($explode_name_pic[0] == "done") {

                        if ($file == 'attach_files') {
                            $attach_files[] = [
                                'src' => $explode_name_pic[1]
                            ];
                            continue;
                        }

                        $this->special_page_gallery_model->insertWithBind([
                            'page_id' => $insert_data,
                            'file' => $explode_name_pic[1],
                            'alt' => $params['gallery_file_alts'][$image_key],
                        ]);

                    }

                }
            }

        }

        if(isset($_FILES['main_file']) && $_FILES['main_file'] != "" && $main_file['src'] == '') {

            $feature_upload = $config->UploadFile("pic", "main_file", "");
            $explode_name_pic = explode(':', $feature_upload);

            if ($explode_name_pic[0] == 'done') {
                $feature_image = $path . $explode_name_pic[1];
                $main_file=[
                    'src'=>$feature_image,
                    'alt'=>$params['main_file_alt']
                ];

            }
        }

        $data['attach_files'] = $attach_files ? json_encode($attach_files, true) : null;



      if ($params['previous_gallery_selected']) {

            $check_exist = $this->special_page_gallery_model->get()
                ->where('id', $params['previous_gallery_selected'])
                ->find();
            if ($check_exist) {
                $main_file['src'] = $check_exist['file'];
                $main_file['alt'] = $check_exist['alt'];
            }


        }
        $data['main_file'] = $main_file ? json_encode($main_file, true) : null;


        $update_data = $this->special_pages_model
            ->updateWithBind($data, [
                'id' => $insert_data
            ]);

        return functions::JsonSuccess($update_data, 'اطلاعات با موفقیت ویرایش گردید');
        } else {
            return functions::withError('',200,'فیلد آدرس صفحه نمی تواند تکراری باشد!');
        }
    }

    public function getSpecialPages() {
        return $this->special_pages_model->get()->where('deleted_at', null, 'IS')->orderBy('id', 'DESC')->all(false);
    }

    public function removeSpecialPage($params) {

        $result = $this->special_pages_model->softDelete([
            'id' => $params['id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'صفحه ی ویژه ی مورد نظر حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف', 200);
    }

    public function getInfoMetaTag($params) {

        return $this->unSlugPage($params['slug']);
    }

    public function unSlugPage($slug) {
        $page = $this->special_pages_model
            ->get()
            ->where('slug', $slug)
            ->where('language', SOFTWARE_LANG)
            ->find();
        if ($page) {

            return $this->getPageIndexes([$page])[0];
        }

        return false;
    }

    public function getPageIndexes($pages) {


        $pages_result = [];
        foreach ($pages as $page_key => $page) {
            $pages_result[$page_key] = $page;

            $meta_tags = json_decode($page['meta_tags'], true);
            $meta_tags_array = [];
            $all_meta_tags_array = [];
            if ($meta_tags) {

                foreach ($meta_tags as $meta_tag) {
                    if (isset($meta_tag['name']) && $meta_tag['name'] == 'description') {
                        $pages_result[$page_key]['description'] = $meta_tag['content'];
                    } else {
                        $meta_tags_array[] = $meta_tag;
                    }
                    $all_meta_tags_array[] = $meta_tag;
                }
            }
            $pages_result[$page_key]['meta_tags'] = $meta_tags_array;
            $pages_result[$page_key]['all_meta_tags'] = $all_meta_tags_array;


            $main_file = json_decode($page['main_file'], true);

            if(isset($main_file) && !empty($main_file) && $main_file['src']){
                $pages_result[$page_key]['files']['main_file']['src'] = $this->imageUrl($main_file['src']);
                $pages_result[$page_key]['files']['main_file']['name'] = $main_file['src'];
                $pages_result[$page_key]['files']['main_file']['alt'] = $main_file['alt'];
                $pages_result[$page_key]['files']['main_file']['id'] = 1;
            }


            $attach_files = json_decode($page['attach_files'], true);
            $pages_result[$page_key]['array_attach_files'] = $attach_files ?: [];
            if ($attach_files) {
                foreach ($attach_files as $key => $uploaded_file) {
                    $pages_result[$page_key]['files']['attach_files'][$key]['src'] = $this->imageUrl($uploaded_file['src']);
                    $pages_result[$page_key]['files']['attach_files'][$key]['name'] = $uploaded_file['src'];
                    $pages_result[$page_key]['files']['attach_files'][$key]['id'] = $key;
                }
            }
            $pages_result[$page_key]['positions'] = $this->getPagesPosition($page['id'] );
            $pages_result[$page_key]['files']['gallery_files'] = $this->pageGallery($page['id'] , $main_file['src']);
            $pages_result[$page_key]['heading'] = !empty($page['heading'])? $page['heading']: $page['title'];


        }

        return $pages_result;
    }
    public function getPagesPosition($page_id) {
        return $this->getPositions('special_pages',$page_id);
    }
    public function imageUrl($image) {
        $url = (!empty($image)) ? $this->photoUrl . $image : $this->noPhotoUrl;
        return str_replace('special_pages/special_pages', 'special_pages', $url);
    }

    public function pageGallery($page_id , $main_file_src = null) {

        $data = $this->special_page_gallery_model->get()
            ->where('page_id', $page_id)
            ->all();

        $result = [];
        foreach ($data as $key => $item) {
                $result[] = [
                    'src' => SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/special_pages/' . $item['file'],
                    'alt' => $item['alt'] ?: 'gallery image ' . $key,
                    'id' => $item['id'],
                ];
        }
        return $result;
    }

    public function removeSpecialPageImage($params) {
        $id = $params['page_id'];
        $type = $params['type'];
        $src_name = $params['src_name'];
        if ($type == 'gallery_files') {

            $check_exist = $this->special_page_gallery_model->get()
                ->where('id', $id)
                ->find();

            if ($check_exist) {
                $this->special_page_gallery_model->delete([
                    'id' => $check_exist['id']
                ]);
                unlink(PIC_ROOT . 'special_pages/' . $check_exist['file']);
            }
            return functions::JsonSuccess(true, 'حذف شد');
        }
        $page = $this->special_pages_model->get()
            ->where('id', $id)
            ->find(false);


        $files = json_decode($page[$type], true);
        $new_files = [];

        foreach ($files as $file) {
            if ($file['src'] === $src_name) {
                unlink(PIC_ROOT . 'special_pages/' . $src_name);
            } else {
                $new_files[] = $file;
            }
        }

        $result = $this->special_pages_model->updateWithBind([
            $type => json_encode($new_files, 256)
        ], [
            'id' => $page['id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'تصویر مورد نظر حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف', 200);
    }

    public function editSpecialPage($params) {

        $page_id = $params['page_id'];
        $language = $params['language'];
        $page = $this->getPageById($page_id);
        $slug = $params['slug'];
//        var_dump($slug);
//        die;
        $check_slug = $this->special_pages_model->get()->where('slug' , $slug)->where('language' , $language)->where('id' , $page_id , '!=')->find();
        if (!$check_slug) {
        if ($page) {
            $page_type = $params['page_type'];
            $attach_type = $params['attach_type'];
            $has_search_box = false;
            if (isset($params['has_search_box'])) {
                $has_search_box = true;
            }


            $positions = null;
            if (($page_type === 'attach' && $attach_type === 'search_box') || ($page_type === 'separate' && $has_search_box)) {

                $positions = $params['positions'];


            } elseif ($page_type === 'attach' && $attach_type === 'main_page') {
                $positions = 'MainPage';
            }

            $title = $params['title'];
            $slug = functions::slugify($params['title']);
            if (isset($params['slug']) && $params['slug'] != '') {
                $slug = functions::slugify($params['slug']);
            }

            if (!isset($params['position'])) {
                $params['position'] = [
                    'Public' => [
                        '0'
                    ]
                ];
            }
            if (isset($params['position']) && $params['position'] != '') {
                $this->resetPositions('special_pages',$params['page_id'],$params['position']);
            }
            $uploaded_files = [];

            $added_metas = '';


            $description = [
                'name' => 'description',
                'content' => filter_var($params['description'], FILTER_SANITIZE_STRING)
            ];

            if(!$params['heading']){
                $params['heading'] = $title;
            }

            if ($params['AddedMeta']) {
                $added_metas = json_encode(array_merge($params['AddedMeta'], [$description]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }

            $data = [
                'title' => $title,
                'heading' => $params['heading'],
                'slug' => $slug,
                'content' => $params['content'],
                'language' => $params['language'],
                'page_type' => $page_type,
                'attach_type' => $attach_type,
                'position' => $positions,
                'meta_tags' => $added_metas,
            ];


            $attach_files = [];
            $main_file = json_decode($page['main_file'], true);
            $main_file['alt'] = $params['main_file_alt'];
            $added_main_file = [];
            $config = Load::Config('application');
            $path = "special_pages/";
            $config->pathFile($path);
            foreach ($this->files as $file) {
                if (isset($_FILES[$file]) && $_FILES[$file] != "") {

                    $separated_files = functions::separateFiles($file);
                    foreach ($separated_files as $image_key => $separated_file) {
                        $separated_file['name'] = self::changeNameUpload($separated_file['name']);
                        $_FILES['file']='';
                        $_FILES['file'] = $separated_file;

                        if (isset($params['gallery_selected']) && strval($params['gallery_selected']) == strval($image_key)) {
                            $params['main_file_alt'] = $params['gallery_file_alts'][$image_key];


                            $main_file_upload = $config->UploadFile("pic", "file", "5120000");
                            $explode_name_pic = explode(':', $main_file_upload);

                            if ($explode_name_pic[0] == 'done') {
                                $feature_image = $path . $explode_name_pic[1];
                                $added_main_file=$main_file=[
                                    'src'=>$feature_image,
                                    'alt'=>$params['main_file_alt']
                                ];

                            }

                        }else{
                            $success = $config->UploadFile("pic", "file", 500000);
                            $explode_name_pic = explode(':', $success);
                        }

                        if ($explode_name_pic[0] == "done") {

                            if ($file == 'attach_files') {

                                $attach_files[] = [
                                    'src' => $explode_name_pic[1]
                                ];
                                continue;
                            }

                           $this->special_page_gallery_model->insertWithBind([
                                'page_id' => $page['id'],
                                'file' => $explode_name_pic[1],
                                'alt' => $params['gallery_file_alts'][$image_key],
                            ]);

                        }

                    }
                }

            }

//            var_dump($params['attach_files']);
//            die;

                $data['attach_files'] = $attach_files ? json_encode($attach_files, true) : null;
            if ($params['previous_gallery_selected']) {
                $check_exist = $this->special_page_gallery_model->get()
                    ->where('id', $params['previous_gallery_selected'])
                    ->find();

                if ($check_exist) {
                    $main_file['src'] = $check_exist['file'];
                    $main_file['alt'] = $check_exist['alt'];
                }
            }





            if(isset($_FILES['main_file']) && $_FILES['main_file'] != "") {

                $feature_upload = $config->UploadFile("pic", "main_file", "5120000");
                $explode_name_pic = explode(':', $feature_upload);

                if ($explode_name_pic[0] == 'done') {
                    $feature_image = $path . $explode_name_pic[1];
                    $main_file=[
                        'src'=>$feature_image,
                        'alt'=>$params['main_file_alt']
                    ];

                }
            }



            $data['main_file'] = $main_file ? json_encode($main_file, true) : null;
            foreach ($this->files as $file) {
                foreach ($page['array_' . $file] as $key => $previous_files) {
                    $page['array_' . $file][$key]['alt'] = $params['previous_gallery_file_alts'][$key];
                }


                if ($page['array_' . $file]) {
                    $uploaded_files[$file] = array_merge($page['array_' . $file], $uploaded_files[$file]);
                }
            }
            if ($params['previous_gallery_file_alts']) {
                foreach ($params['previous_gallery_file_alts'] as $key => $alt) {
                    $this->special_page_gallery_model->updateWithBind([
                        'alt' => $alt
                    ], [
                        'id' => $key
                    ]);
                }
            }


            $update_data = $this->special_pages_model
                ->updateWithBind($data, [
                    'id' => $page['id']
                ]);
            $this->getController('siteMap')->createSitemap();
            return functions::JsonSuccess($update_data, 'اطلاعات با موفقیت ویرایش گردید');



        }
        return functions::JsonError(false, 'موردی یافت نشد', 200);
        } else {
            return functions::withError('',200,'فیلد آدرس صفحه نمی تواند تکراری باشد!');
        }
    }

    public function getPageById($id) {

        if(is_array($id)) {
            $result = $this->special_pages_model->get()
                ->whereIn('id', $id)
                ->all(false);

            return $this->getPageIndexes($result);
        }else {
            $result = $this->special_pages_model->get()
                ->where('id', $id)
                ->find(false);
            return $this->getPageIndexes([$result])[0];
        }
    }

    public function getLocation() {

        $services = $this->getAccessServiceClient();
        $list = [];
        foreach ($services as $service) {

//            if (in_array($service['MainService'], array('Europcar'))) {
//                continue;
//            }
            if ($service['id'] == 1) {
                $internal_flight = [
                    'id' => 0,
                    'MainService' => 'internalFlight',
                    'Title' => 'پرواز داخلی',
                    'order_number' => 1
                ];
                $external_flight = [
                    'id' => 0,
                    'MainService' => 'internationalFlight',
                    'Title' => 'پرواز خارجی',
                    'order_number' => 2
                ];
                $list['internalFlight'] = $internal_flight;
                $list['internationalFlight'] = $external_flight;
                continue;
            }
            $list[$service['MainService']] = $service;
        }
        
        return $list;
    }
    public function getServices() {

        $services = $this->getAccessServiceClient();
        $list = [];
        $list['internalFlight'] = [
            'Title' => 'بلیط داخلی',
            'id' => '',
            'MainService' => 'internalFlight',
            'order_number' => '1',
        ];
        $list['internationalFlight'] = [
            'Title' => 'بلیط خارجی',
            'id' => '',
            'MainService' => 'internationalFlight',
            'order_number' => '1',
        ];
        foreach ($services as $service) {
            if (in_array($service['MainService'], array('Entertainment', 'Europcar','Flight'))) {
                continue;
            }
            $list[$service['MainService']] = $service;
        }
        $list['Public'] = [
            'Title' => 'عمومی',
            'id' => '',
            'MainService' => 'Public',
            'order_number' => '50',
        ];
        return $list;
    }
    public function getPage($params) {


        $result = $this->special_pages_model->get();

        if (isset($params['page_type']) && $params['page_type'] != '') {
            $result = $result->whereIn('page_type', $params['page_type']);
        }
        if (isset($params['location']) && $params['location'] != '') {
            $result = $result->whereIn('position', $params['location']);
        }
        $result = $result->where('deleted_at', null, 'IS');
        $result = $result->all(false);
        return $this->getPageIndexes($result);

    }

    public function findPageById($id) {
        return $this->getModel('specialPagesModel')->get()->where('id', $id)->find();
    }

    public function deleteImageSpecial($data_delete) {

        $page_model = $this->getModel('specialPagesModel');
        $check_exist_page = $this->findPageById($data_delete['id']);
        if ($check_exist_page) {
            if($check_exist_page['main_file'] != ''){
                $data = [
                    'main_file' => ''
                ];
                $update = $page_model->updateWithBind($data, ['id' => $data_delete['id']]);
                if ($update) {
                    return functions::withSuccess('', 200, 'حذف تصویر  با موفقیت انجام شد');
                }
            }
        }

    }
    public function listAllPositions($serviceGroup = null) {

        if (!$serviceGroup) {
            return false;
        }
        if (isset($serviceGroup['service']) && $serviceGroup['service'] != '') {
            $serviceGroup = $serviceGroup['service'];
        }
        $allServiceGroup = $this->getServices();
        if (!in_array($serviceGroup, array_keys($allServiceGroup))) {
            return false;
        }
        $method = 'ListPosition' . $serviceGroup;

        return $this->$method();

    }
    public function searchHotel($params) {
        $hotel_cities = $this->getModel('hotelCitiesModel');
        $destinations = $hotel_cities->get()
            ->where('city_iata', null, 'IS NOT')
            ->openParentheses()
            ->where('city_name_en', "%" . $params['q'] . "%", 'like')
            ->orWhere('city_iata', "%" . $params['q'] . "%", 'like')
            ->orWhere('city_name', "%" . $params['q'] . "%", 'like')
            ->closeParentheses()
            ->all();


        $list = [];
        $list['results'][] = [
            'text' => 'عمومی',
            'id' => '*'
        ];
        foreach ($destinations as $destination) {
            $list['results'][] = [
                'text' => $destination['city_name'] . '(' . $destination['city_name_en'] . ')',
                'id' => $destination['city_code']
            ];
        }

        if (!$destinations) {
            $destinations = $this->getModel('externalHotelCityModel')->get()
                ->where('country_code', null, 'IS NOT')
                ->openParentheses()
                ->where('country_code', "%" . $params['q'] . "%", 'like')
                ->orWhere('country_name_en', "%" . $params['q'] . "%", 'like')
                ->orWhere('country_name_fa', "%" . $params['q'] . "%", 'like')
                ->orWhere('city_name_en', "%" . $params['q'] . "%", 'like')
                ->orWhere('city_name_fa', "%" . $params['q'] . "%", 'like')
                ->closeParentheses()
                ->all();


            foreach ($destinations as $destination) {
                $list['results'][] = [
                    'text' => $destination['country_name_en'] . '(' . $destination['city_name_en'] . ')',
                    'id' => $destination['city_name_en']
                ];
            }

        }


        $list['pagination'] = [
            'more' => false
        ];

        return json_encode($list, 256);
    }

    public function findPageByIdList($ids) {
        $result = $this->getModel('specialPagesModel')->get('*')->whereIn('id', $ids)->all();
        $result = $this->getPageIndexes($result);
        return $result;
    }

    public function listPageForSite() {
        $result = $this->getModel('specialPagesModel')->get('*')->where('deleted_at', null, 'IS')->where('language', SOFTWARE_LANG)->all();
        $result = $this->getPageIndexes($result);
        return $result;
    }
}