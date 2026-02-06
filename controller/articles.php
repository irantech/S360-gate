<?php
//if(  $_SERVER['REMOTE_ADDR']=='93.118.161.174'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}

class articles extends positions
{
    public $listAll, $listAccess, $noPhotoUrl, $articlesBaseUrl;
    private $articlesTb, $flightLocalRouteTb, $hotelCitiesTb, $services;
    /**
     * @var string
     */
    public $page_limit;
    /**
     * @var string
     */
    private $photoUrl;

    public function __construct() {




        parent::__construct();
        $this->articlesTb = 'articles_tb';
        $this->page_limit = 6;
        $this->flightLocalRouteTb = 'flight_route_tb';
        $this->hotelCitiesTb = 'hotel_cities_tb';
        $this->services = Load::controller('services');
//        $this->noPhotoUrl = 'project_files/'. SOFTWARE_LANG .'/images/no-photo.png';
        $this->noPhotoUrl = 'project_files/images/no-photo.png';
        $this->photoUrl = ROOT_ADDRESS_WITHOUT_LANG . '/pic/articles/';
        //$this->noPhotoUrl = 'no-photo.jpg';

        $this->setSection(GDS_SWITCH);



    }



    public function infoSiteMap($table) {
        $model = $this->getModel('articleModel');
        $table = $model->getTable();
        $result = $model
            ->get([
                $table . '.*',
            ], true);
        $result = $result
            ->where($table . '.deleted_at', null, 'IS');
//        $result = $result
//            ->where($table . '.language', SOFTWARE_LANG);
        $result = $result->groupBy($table . '.id')->orderBy($table . '.id');
        $result = $result->all(false);
        $data_add_gds_mag['loc'] = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/mag';
        $data_add_gds_mag['priority'] = '0.5';
        $data_add_gds_mag['lastmodJalali'] = dateTimeSetting::jdate("Y-m-d",time(),'','','en');
        $data_add_gds_mag['lastmod'] = functions::ConvertToMiladi($data_add_gds_mag['lastmodJalali'], '-');
        $mag_link[] = $data_add_gds_mag;
        $data_add_gds_news['loc'] = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/news';
        $data_add_gds_news['priority'] = '0.5';
        $data_add_gds_news['lastmodJalali'] = dateTimeSetting::jdate("Y-m-d",time(),'','','en');
        $data_add_gds_news['lastmod'] = functions::ConvertToMiladi($data_add_gds_news['lastmodJalali'], '-');
        $news_link[] = $data_add_gds_news;

        foreach ($result as $key => $item) {
            $url = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . $item['language'] . '/' . $item['section'] .'/'.$item['slug'];
            $result_sitemap['loc'] = $url;
            $result_sitemap['priority'] = '0.5';
            $result_sitemap['lastmodJalali'] = functions::ConvertToJalali($item['updated_at'], '/');
            $result_sitemap['lastmod'] = functions::ConvertToMiladi($result_sitemap['lastmodJalali'], '-');
            $result_sitemap_final[] = $result_sitemap;
        }

        return [$mag_link , $news_link , $result_sitemap_final];
    }

    public function setSection($section) {
        $this->articlesBaseUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/';
    }
    public function changeNameUpload($fileName) {
        $ext = explode(".", $fileName);
        $fileName = date("sB")."-" . rand(10, 10000);
        $ext = strtolower($ext[count($ext)-1]);
        $fileName = $fileName.".".$ext;
        return $fileName;
    }

    public function storeCategory($params) {

        $categories_model = $this->getModel('articleCategoriesModel');
        $title = $params['title'];
        $language = $params['language'];
        $slug = functions::slugify($params['title']);
        $parent_id = 0;
        if (isset($params['parent_id']) && $params['parent_id'] != '') {
            $parent_id = $params['parent_id'];
        }
        if (isset($params['slug']) && $params['slug'] != '') {
            $slug = functions::slugify($params['slug']);
        }

        $exist = $categories_model->get('id')
            ->where('deleted_at', null, 'IS')
            ->openParentheses()
            ->where('title', $title)
            ->orWhere('slug', $slug)
            ->closeParentheses()
            ->find();

        if (!$exist) {

            $dataInsert = [
                'title' => $title,
                'language' => $language,
                'slug' => $slug,
                'parent_id' => $parent_id,
            ];
            if (isset($_FILES['image'])) {
                /** @var application $config */
                $config = Load::Config('application');
                $path = "articles/";
                $config->pathFile($path);
                $_FILES['image']['name'] = self::changeNameUpload($_FILES['image']['name']);
                $feature_upload = $config->UploadFile("pic", "image", "5120000");
                $explode_name_pic = explode(':', $feature_upload);
                if ($explode_name_pic[0] == 'done') {
                    $feature_image = $path . $explode_name_pic[1];
                    $dataInsert['image'] = $feature_image;
                }
            }


            $insert_data = $categories_model
                ->insertWithBind($dataInsert);
            if ($insert_data) {
                return functions::JsonSuccess($insert_data, 'دسته بندی با موفقیت ایجاد شد');
            }
            return functions::JsonError($insert_data, 'خطا در ایجاد دسته بندی', 200);
        }
        return functions::JsonError(false, 'این دسته بندی از قبل ایجاد شده است', 200);
    }

    public function getCategories($category_id = 0) {

        $article_model = $this->getModel('articleModel');
        $article_table = $article_model->getTable();
        $categories = $this->getModel('articleCategoriesModel')->get();
        if ($category_id != 'all') {
            $categories = $categories->where('parent_id', $category_id);
        }
        $categories = $categories->where('deleted_at', null, 'IS')
            ->all();
        foreach ($categories as $key => $category) {

            $articles = [] ;
            $category_id = '"' . $category['id'] . '"' ;

            $articles = $article_model
                ->get([
                    $article_table . '.*'
                ], true)
                ->where('section', 'mag')
                ->where($article_table . '.categories', "%$category_id%", 'like')
                ->all(false);

            $categories[$key]['articles'] = $this->addArticleIndexes($articles) ;
            $categories[$key]['article_count'] = count($articles) ;
        }
//        var_dump($categories);
        return $categories;
    }
    public function getCategoriesMain($data_main_page = []) {

        $article_model = $this->getModel('articleModel');
        $article_table = $article_model->getTable();
        $categories = $this->getModel('articleCategoriesModel')->get();

        $category_limit = 6 ;
        $mag_limit = 6  ;
        $section = 'mag' ;

        if (isset($data_main_page['limit']) || !empty($data_main_page['limit'])) {
            $category_limit = $data_main_page['limit'] ;
        }
        if (isset($data_main_page['article_limit']) || !empty($data_main_page['article_limit'])) {
            $mag_limit = $data_main_page['article_limit'] ;
        }
        if (isset($data_main_page['article_limit']) || !empty($data_main_page['article_limit'])) {
            $article_limit = $data_main_page['article_limit'] ;
        }
        if (isset($data_main_page['section']) || !empty($data_main_page['section'])) {
            $section = $data_main_page['section'] ;
        }
        if (isset($data_main_page['parent_id']) || !empty($data_main_page['parent_id'])) {
            $categories = $categories->where('parent_id', $data_main_page['parent_id']);
        }else{
            $categories = $categories->where('parent_id', '0');
        }

        $categories = $categories->where('deleted_at', null, 'IS')
            ->orderBy('orders' , 'ASC')
            ->orderBy('id' , 'DESC')
            ->all(false);

        $result = $this->addCategoryIndexes($section ,$categories);

        foreach ($categories as $key => $category){
            $articles = [] ;
            $category_id = '"' . $category['id'] . '"' ;

            $articles = $article_model
                ->get([
                    $article_table . '.*'
                ], true)
                ->where('section', $section)
                ->where($article_table . '.state_site', '1')
                ->where($article_table . '.categories', "%$category_id%", 'like')
                ->where('deleted_at', null, 'IS')
                ->limit(0 ,$mag_limit )->all(false);

            $result[$key]['articles'] = $this->addArticleIndexes($articles) ;
            $result[$key]['article_count'] = count($articles) ;
        }

        $last_result = [];
        $category_count = 0 ;
        foreach ($result as $key => $category){
            if($category['article_count'] > 0 && $category_count <= $category_limit) {
                $last_result[] = $category;
                $category_count ++;
            }
        }

        return $last_result;
    }

    public function searchCategory($params) {
        $categories = $this->getModel('articleCategoriesModel')->get();
        $parent = $params['parent_id'];
        $title = $params['title'];

        $categories = $categories->where('parent_id', $parent);


        $categories = $categories
            ->where('title', '%' . functions::searchableText($title) . '%', 'like');


        return $categories->where('deleted_at', null, 'IS')
            ->all();
    }

    public function updateCategory($params) {

                $category_id = $params['$category_id'];
                $title = $params['update_title'];
                $language = $params['update_language'];
                $slug = functions::slugify($params['update_title']);
                if (isset($params['update_slug']) && $params['update_slug'] != '') {
                    $slug = functions::slugify($params['update_slug']);
                }
                $article_cat_model = $this->getModel('articleCategoriesModel');
                $check_slug = $article_cat_model->get()->where('slug', $slug)->where('language' , $params['language'])->where('id', $category_id, '!=')->where('deleted_at', null, 'IS')->find();
               if (!$check_slug) {
                   $update_data = [
                       'title' => $title,
                       'language' => $language,
                       'slug' => $slug,
                   ];

                   if (isset($_FILES['update_image'])) {
                       /** @var application $config */
                       $config = Load::Config('application');
                       $path = "articles/";
                       $config->pathFile($path);
                       $_FILES['update_image']['name'] = self::changeNameUpload($_FILES['update_image']['name']);
                       $feature_upload = $config->UploadFile("pic", "update_image", "5120000");
                       $explode_name_pic = explode(':', $feature_upload);
                       if ($explode_name_pic[0] == 'done') {
                           $feature_image = $path . $explode_name_pic[1];
                           $update_data['image'] = $feature_image;
                       }
                   }

                   $update_result = $this->getModel('articleCategoriesModel')->get()
                       ->updateWithBind($update_data, [
                           'id' => $params['category_id']
                       ]);
                   if ($update_result) {
                       return functions::JsonSuccess($update_result, 'دسته بندی با موفقیت ویرایش شد');
                   }

                   return functions::JsonError($update_result, 'خطا در ویرایش دسته بندی', 200);
               }else {
                   return functions::JsonError(false, 'این دسته بندی از قبل ایجاد شده است', 200);

               }

//        return functions::JsonError(false, 'خطا در یافتن دسته بندی', 200);
    }

    public function getCategory($section, $id) {
        if (is_array($id)) {
            $id = filter_var($id['id'], FILTER_SANITIZE_NUMBER_INT);
        } else {
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        }

        $category = $this->getModel('articleCategoriesModel')->get()
            ->where('id', $id)
            ->find(false);

        if (isset($category['id']) && !empty($category['id']) && $category['parent_id'] != '0') {
            $category['parent'] = $this->getCategory($section, $category['parent_id']);
        }

        return $this->addCategoryIndexes($section, [$category])[0];
    }

    public function addCategoryIndexes($section, array $categories) {
        $result = [];
        foreach ($categories as $key => $category) {
            $result[$key] = $category;
            $result[$key]['image'] = $this->featuredImageUrl($category['image']);
            $result[$key]['link'] = "{$this->articlesBaseUrl}{$section}/category/{$category['slug']}";
        }
        return $result;
    }

    public function featuredImageUrl($feature_image) {
        $url = (!empty($feature_image)) ? $this->photoUrl . $feature_image : $this->noPhotoUrl;
        return str_replace('articles/articles', 'articles', $url);
    }

    /**
     * @param $params
     * @return bool
     */
    public function isCategoryUnique($params) {
        $count = $this->getModel('articleCategoriesModel')->get()
            ->where('title', $params['update_title'])
            ->where('id', $params['category_id'], '!=')
            ->where('slug', $params['update_slug']);

        if (isset($params['update_parent_id']) && $params['update_parent_id'] != '') {
            $count = $count->where('parent_id', $params['update_parent_id']);
        }


        $count = $count->find();
        if ($count) {
            return false;
        }
        return true;
    }

    public function getAdminCategory($id) {
        if (is_array($id)) {
            $id = $id['id'];
        }

        $category = $this->getModel('articleCategoriesModel')->get()
            ->where('id', $id)
            ->find(false);

        if ($category['parent_id'] != '0') {
            $category['parent'] = $this->getAdminCategory($category['parent_id']);
        }

        return $this->addCategoryIndexes('mag', [$category])[0];
    }

    public function getSubCategories($section, $category_id) {


        $categories = $this->getModel('articleCategoriesModel')
            ->get()
            ->where('parent_id', $category_id)
            ->where('deleted_at', null, 'IS')
            ->all(false);
        return $this->addCategoryIndexes($section, $categories);
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
            if (in_array($service['MainService'], array('Entertainment', 'Europcar'))) {
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

    public function ListPositionPublic() {
        return false;
    }

    public function InsertArticle($params) {

        /** @var articleModel $Model */
        $article_model = $this->getModel('articleModel');
        $article_gallery_model = $this->getModel('articleGalleryModel');

        $slug = functions::slugify($params['title']);

        if (isset($params['slug']) && $params['slug'] != '') {
            $slug = functions::slugify($params['slug']);
        }

        $dataInsert = '';
        $check_slug = $article_model->get()->where('slug', $slug)->where('language' , $params['language'])->where('deleted_at', null, 'IS')->find();
         if (!$check_slug) {
             $added_metas = '';


             $description = [
                 'name' => 'description',
                 'content' => filter_var($params['description'], FILTER_SANITIZE_STRING)
             ];

             if (!$params['heading']) {
                 $params['heading'] = $params['title'];
             }

             if ($params['AddedMeta']) {
                 $added_metas = json_encode(array_merge($params['AddedMeta'], [$description]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
             }

             $dataInsert = [
                 'language' => $params['language'],
                 'title' => $params['title'],
                 'heading' => $params['heading'],
                 'section' => $params['section'],
                 'slug' => $slug,
                 'content' => $params['content'],
                 'meta_tags' => $added_metas,
                 'categories' => json_encode($params['selected_category'], 256),
                 'updated_at' => date('Y-m-d H:i:s', time()),
                 'lead' => $params['lead'],
             ];
             $config = Load::Config('application');
             $path = "articles/";
             $config->pathFile($path);
             if (isset($_FILES['feature_image']) && $_FILES['feature_image'] != "" && $dataInsert['feature_image'] == '') {
                 $_FILES['feature_image']['name'] = self::changeNameUpload($_FILES['feature_image']['name']);

                 $feature_upload = $config->UploadFile("pic", "feature_image", "5120000");
                 $explode_name_pic = explode(':', $feature_upload);

                 if ($explode_name_pic[0] == 'done') {
                     $feature_image = $path . $explode_name_pic[1];
                     $dataInsert['feature_image'] = $feature_image;
                     $dataInsert['feature_alt_image'] = $params['feature_alt_image'];
                 }
             }


             if (isset($_FILES['gallery_files']) && $_FILES['gallery_files'] != "") {

                 $separated_files = functions::separateFiles('gallery_files');
                 foreach ($separated_files as $image_key => $separated_file) {
                     $_FILES['file'] = '';
                     $_FILES['file'] = $separated_file;

                     if ($params['gallery_selected'] && $params['gallery_selected'] == $image_key) {
                         $_FILES['feature_image'] = $separated_file;
                         $params['feature_alt_image'] = $params['gallery_file_alts'][$image_key];
                         $_FILES['feature_image']['name'] = self::changeNameUpload($_FILES['feature_image']['name']);
                         $feature_upload = $config->UploadFile("pic", "feature_image", "5120000");
                         $explode_name_pic = explode(':', $feature_upload);
                         if ($explode_name_pic[0] == 'done') {
                             $feature_image = $path . $explode_name_pic[1];
                             $dataInsert['feature_image'] = $feature_image;
                             $dataInsert['feature_alt_image'] = $params['feature_alt_image'];
                         }


                     }
                 }
             }


             $insert = $article_model->insertWithBind($dataInsert);
             if ($insert) {
                 if (isset($_FILES['gallery_files']) && $_FILES['gallery_files'] != "") {

                     $separated_files = functions::separateFiles('gallery_files');
                     foreach ($separated_files as $image_key => $separated_file) {
                         $_FILES['file'] = $separated_file;
                         if ($params['gallery_selected'] && $params['gallery_selected'] == $image_key) {
                             $success = $feature_upload;
                         } else {

                             $_FILES['file']['name'] = self::changeNameUpload($_FILES['file']['name']);
                             $success = $config->UploadFile("pic", "file", "5120000");
                         }

                         $explode_name_pic = explode(':', $success);
                         if ($explode_name_pic[0] == "done") {

                             $article_gallery_model->insertWithBind([
                                 'article_id' => $insert,
                                 'file' => $explode_name_pic[1],
                                 'alt' => $params['gallery_file_alts'][$image_key],
                             ]);
                         }

                     }
                 }

                 $article_positions_model = $this->getModel('articlePositionsModel');


                 if (isset($params['position']) && $params['position'] != '') {

                     $this->storePositions('article', $insert, $params['position']);

                 }

                 /*if($formData['show_on_result'] == '1'){
                     $Model->update(['show_on_result'=>0],"service_group = '{$formData['service_group']}' AND position='{$formData['position']}'");
                 }*/


                 return self::returnJson(true, 'مطلب با موفقیت در سیستم به ثبت رسید', $dataInsert);
             }

             return self::returnJson(false, 'خطا در ثبت اطلاعات در سیستم.', null, 500);
         }else{
             return functions::withError('',200,'آدرس صفحه تکراری می باشد!');
         }

    }

    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        $return = json_encode([
            'success' => $success,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return $return;
    }

    public function UpdateArticle($params) {
        /** @var application $config */
        /** @var articleModel $article_model */


        $article_gallery_model = $this->getModel('articleGalleryModel');
        $article_model = $this->getModel('articleModel');
        $article_positions_model = $this->getModel('articlePositionsModel');
        $article = $article_model->get()
            ->where('id', $params['article_id'])
            ->find();


        $article_positions_model->delete([
            'article_id' => $article['id']
        ]);

        if(!$params['heading']){
            $params['heading'] = $params['title'];
        }

        if (!isset($params['position'])) {
            $params['position'] = [
                'Public' => [
                    '0'
                ]
            ];
        }
        if (isset($params['position']) && $params['position'] != '') {
            $this->resetPositions('article',$params['article_id'],$params['position']);
        }


        $slug = functions::slugify($params['title']);
        if (isset($params['slug']) && $params['slug'] != '') {
            $slug = functions::slugify($params['slug']);
        }
        $check_slug = $article_model->get()->where('slug', $slug)->where('language' , $params['language'])->where('id', $params['article_id'], '!=')->where('deleted_at', null, 'IS')->find();
        if (!$check_slug) {
            $added_metas = '';


            $description = [
                'name' => 'description',
                'content' => filter_var($params['description'], FILTER_SANITIZE_STRING)
            ];


            if ($params['AddedMeta']) {
                $added_metas = json_encode(array_merge($params['AddedMeta'], [$description]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }


            $dataUpdate = [
                'language' => $params['language'],
                'title' => $params['title'],
                'heading' => $params['heading'],
                'slug' => $slug,
                'content' => $params['content'],
                'categories' => json_encode($params['selected_category'], 256),
                'updated_at' => date('Y-m-d H:i:s', time()),
                'meta_tags' => $added_metas,
                'feature_alt_image' => $params['feature_alt_image'],
                'lead' => $params['lead'],
            ];


            $config = Load::Config('application');
            $path = "articles/";
            $config->pathFile($path);

            if (isset($_FILES['gallery_files']) && $_FILES['gallery_files'] != "") {

                $separated_files = functions::separateFiles('gallery_files');
                foreach ($separated_files as $image_key => $separated_file) {
                    $_FILES['file'] = '';
                    $_FILES['file'] = $separated_file;

                    if ($params['gallery_selected'] && $params['gallery_selected'] == $image_key) {
                        $_FILES['feature_image'] = $separated_file;
                        $params['feature_alt_image'] = $params['gallery_file_alts'][$image_key];
                        $_FILES['feature_image']['name'] = self::changeNameUpload($_FILES['feature_image']['name']);
                        $feature_upload = $config->UploadFile("pic", "feature_image", "5120000");
                        $explode_name_pic = explode(':', $feature_upload);
                        if ($explode_name_pic[0] == 'done') {
                            $feature_image = $path . $explode_name_pic[1];
                            $dataUpdate['feature_image'] = $feature_image;
                            $dataUpdate['feature_alt_image'] = $params['feature_alt_image'];
                        }

                    } else {
                        $_FILES['file']['name'] = self::changeNameUpload($_FILES['file']['name']);
                        $success = $config->UploadFile("pic", "file", 5120000);
                        $explode_name_pic = explode(':', $success);
                    }


                    if ($explode_name_pic[0] == "done") {
                        $article_gallery_model->insertWithBind([
                            'article_id' => $params['article_id'],
                            'file' => $explode_name_pic[1],
                            'alt' => $params['gallery_file_alts'][$image_key],
                        ]);
                    }

                }
            }


            if (isset($_FILES['feature_image']) && $_FILES['feature_image'] != "" && $dataUpdate['feature_image'] == '') {
                $_FILES['feature_image']['name'] = self::changeNameUpload($_FILES['feature_image']['name']);
                $feature_upload = $config->UploadFile("pic", "feature_image", "5120000");
                $explode_name_pic = explode(':', $feature_upload);

                if ($explode_name_pic[0] == 'done') {
                    $feature_image = $path . $explode_name_pic[1];
                    $dataUpdate['feature_image'] = $feature_image;
                    $dataUpdate['feature_alt_image'] = $params['feature_alt_image'];
                }
            }


            if ($params['previous_gallery_selected']) {
                $check_exist = $article_gallery_model->get()
                    ->where('id', $params['previous_gallery_selected'])
                    ->find();
                if ($check_exist) {
                    $dataUpdate['feature_image'] = $check_exist['file'];
                    $dataUpdate['feature_alt_image'] = $check_exist['alt'];


                }

            }


            if ($params['previous_gallery_file_alts']) {
                foreach ($params['previous_gallery_file_alts'] as $key => $alt) {
                    $article_gallery_model->updateWithBind([
                        'alt' => $alt
                    ], [
                        'id' => $key
                    ]);
                }
            }

            $update = $article_model->updateWithBind($dataUpdate, ['id' => $params['article_id']]);



//                self::infoSiteMap($this->articlesTb);
//
//                return self::returnJson(true, 'مطلب با موفقیت در سیستم بروزرسانی شد', ['section' => $article['section']]);
//                $this->getController('siteMap')->createSitemap();

            $this->getController('siteMap')->createSitemap();

                return functions::JsonSuccess($dataUpdate, 'اطلاعات با موفقیت ویرایش گردید');


            return self::returnJson(false, 'خطا در ثبت اطلاعات در سیستم.', null, 500);
        }else {
            return functions::withError('',200,'آدرس صفحه تکراری می باشد!');
        }
    }

    public function getAdminArticles($section, $service_id = null, $category_id = null) {

        $article_model = $this->getModel('articleModel');
        $article_table = $article_model->getTable();
        $flight_route_customer_model = $this->getModel('flightRouteCustomerModel');
        $flight_route_customer_table = $flight_route_customer_model->getTable();
        $article_positions_model = $this->getModel('articlePositionsModel');
        $article_positions_table = $article_positions_model->getTable();


        $articles = $article_model
            ->get([
                $article_table . '.*',
            ], true)
            ->join($article_positions_table, 'article_id', 'id')
            ->where('section', $section);

        $articles = $articles
            ->where($article_table . '.deleted_at', null, 'IS');

        if ($category_id) {
            $articles = $articles->where($article_table . '.categories', "%$category_id%", 'like');
        }

        $articles = $articles->groupBy($article_table . '.id')->orderBy($article_table . '.id');
        $articles = $articles->all(false);

        return $this->addArticleIndexes($articles);
    }

    /**
     * @param array $articles
     * @return array
     */
    public function addArticleIndexes(array $articles) {

        $result = [];
        $comments_controller = $this->getController('comments');
        $rates_controller = $this->getController('masterRate');

        foreach ($articles as $key => $article) {

            $result[$key] = $article;
            unset($result[$key]['categories']);




            $result[$key]['positions'] = $this->getArticlePosition($article['id']);

            $time_date = functions::ConvertToDateJalaliInt($article['created_at']);
            $result[$key]['created_at_en'] = functions::DateWithName($article['created_at']);
            if(SOFTWARE_LANG == 'fa') {
                $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            }else{

                $result[$key]['created_at'] =  date( "Y-m-d", $time_date );
            }
            $result[$key]['created_time'] = $time_date;
            $result[$key]['image'] = $this->featuredImageUrl($article['feature_image']);

            $result[$key]['alt'] = $article['feature_alt_image'] ?: $article['title'];
            $result[$key]['gallery'] = $this->articleGallery($article['id']);

            $meta_tags = json_decode($article['meta_tags'], true);
            $meta_tags_array = [];
            $all_meta_tags_array = [];
            if ($meta_tags) {

                foreach ($meta_tags as $meta_tag) {
                    if (isset($meta_tag['name']) && $meta_tag['name'] == 'description') {
                        $result[$key]['description'] = $meta_tag['content'];
                    } else {
                        $meta_tags_array[] = $meta_tag;
                    }
                    $all_meta_tags_array[] = $meta_tag;
                }
            }
            $result[$key]['meta_tags'] = $meta_tags_array;
            $result[$key]['all_meta_tags'] = $all_meta_tags_array;


            if (isset($article['categories']) && $article['categories'] != '') {

                foreach (json_decode($article['categories']) as $cat_key => $category) {
                    if ($category) {

                        $result[$key]['categories'][$cat_key] = $this->getCategory($article['section'], $category);
                        $result[$key]['categories_array'][$cat_key] = $this->getOneCategory($article['section'], $category);
                    }
                }
            }


            $result[$key]['comments_count'] = $comments_controller->getCommentsCount($article['section'], $article['id']);
            $result[$key]['rates'] = $rates_controller->getRateAverage($article['section'], $article['id']);
            $result[$key]['tiny_text'] = empty($article['lead'])?strip_tags($article['content']):$article['lead'];
            $result[$key]['link'] = "{$this->articlesBaseUrl}{$article['section']}/{$article['slug']}";
            $result[$key]['heading'] = !empty($article['heading'])?$article['heading']:$article['title'];
            $result[$key]['lead'] = $article['lead'];
        }

        return $result;
    }

    /**
     * @param $article_id
     * @return array
     */
    public function getArticlePosition($article_id) {
        return $this->getPositions('article',$article_id);
    }


    public function getHotelCity($city) {
        $hotel_cities = $this->getModel('hotelCitiesModel');
        $destination = $hotel_cities->get()
            ->where('city_iata', $city)
            ->find();


        if (!$destination) {
            $destination = $this->getModel('externalHotelCityModel')->get()
                ->where('city_name_en', $city)
                ->find();


            return $destination['country_name_en'] . '(' . $destination['city_name_en'] . ')';

        }


        return $destination['city_name'] . '(' . $destination['city_name_en'] . ')';
    }

    //test

    public function ListPositionBus() {
        $sql = "SELECT * FROM bus_route_tb WHERE iataCode != '' ";
        $ModelBase = Load::library('ModelBase');
        $destinations = $ModelBase->select($sql);
        $list = [];
        foreach ($destinations as $destination) {
            $list[$destination['iataCode']] = ['name' => functions::arabicToPersian($destination['name_fa']), 'name_en' => $destination['name_en']];
        }

        return $list;
    }

    public function ListPositionInsurance() {
        $sql = "SELECT * FROM insurance_country_tb";
        $ModelBase = Load::library('ModelBase');
        $destinations = $ModelBase->select($sql);
        $list = [];
        foreach ($destinations as $destination) {
            $list[$destination['abbr']] = ['name' => functions::arabicToPersian($destination['persian_name']), 'name_en' => $destination['english_name']];
        }

        return $list;
    }

    public function ListPositionTrain() {
        $sql = "SELECT * FROM train_route_tb WHERE Code != '' ";
        $ModelBase = Load::library('ModelBase');
        $destinations = $ModelBase->select($sql);
        $list = [];
        foreach ($destinations as $destination) {
            $list[$destination['Code']] = ['name' => functions::arabicToPersian($destination['Name']), 'name_en' => $destination['EnglishName']];
        }

        return $list;
    }

    public function ListPositionGashtTransfer() {
        $sql = "SELECT * FROM gashtotransfer_cities_tb WHERE city_code != '' ";
        $ModelBase = Load::library('ModelBase');
        $destinations = $ModelBase->select($sql);
        $list = [];
        foreach ($destinations as $destination) {
            $list[$destination['city_code']] = ['name' => functions::arabicToPersian($destination['city_name']), 'name_en' => $destination['city_code']];
        }

        return $list;
    }

    public function ListPositionTour() {
        $sql = "SELECT * FROM reservation_city_tb  ";
        $Model = Load::library('Model');
        $destinations = $Model->select($sql);
        $list = [];
        foreach ($destinations as $destination) {
            $list[$destination['id']] = ['name' => functions::arabicToPersian($destination['name']), 'name_en' => $destination['name_en']];
        }

        return $list;
    }

    public function ListPositionVisa() {
        $destinations=$this->getModel( 'reservationCountryModel')
            ->get()
            ->where( 'abbreviation', '', '!=' )
            ->all();

        $list = [];
        foreach ($destinations as $destination) {
            $list[$destination['abbreviation']] = ['name' => functions::arabicToPersian($destination['name']), 'name_en' => $destination['name_en']];
        }

        $types=$this->getModel('visaTypeModel')->get()
            ->where('isDell','no')
            ->all();

        return [
            'countries'=>$list,
            'types'=>$types,
        ];
    }

    public function articleGallery($article_id) {
        $article_gallery_model = $this->getModel('articleGalleryModel');
        $model = $this->getModel('articleModel');
        $data = $article_gallery_model->get()
            ->where('article_id', $article_id)
            ->all();
        $article = $model->get()
            ->where('id', $article_id)
            ->find();

        $result = [];
        foreach ($data as $key => $item) {
            if($article['feature_image'] != $item['file']) {
                $result[] = [
                    'src' => SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/articles/' . $item['file'],
                    'alt' => $item['alt'] ?: 'gallery image ' . $key,
                    'id' => $item['id'],
                ];
            }

        }
        return $result;
    }

    public function getOneCategory($section, $id) {
        if (is_array($id)) {
            $id = $id['id'];
        }
        $category = $this->getModel('articleCategoriesModel')->get()
            ->where('id', $id)
            ->find(false);


        return $this->addCategoryIndexes($section, [$category])[0];

    }

    public function getArticles($section, $service_id = null, $category_id = null, $page = null , $order = null) {



        $article_model = $this->getModel('articleModel');
        $article_count_model = $this->getModel('articleModel');
        $article_table = $article_model->getTable();
        $flight_route_customer_model = $this->getModel('flightRouteCustomerModel');
        $flight_route_customer_table = $flight_route_customer_model->getTable();
        $article_positions_model = $this->getModel('articlePositionsModel');
        $article_positions_table = $article_positions_model->getTable();


        $article_count = $article_count_model
            ->get([
                'count(' . $article_table . '.id) as count',
            ], true)
            ->join($article_positions_table, 'article_id', 'id')
            ->where('language' , SOFTWARE_LANG)
            ->where('section', $section);


        $articles = $article_model
            ->get([
                $article_table . '.*',
            ], true)
            ->join($article_positions_table, 'article_id', 'id')
            ->where('section', $section)->where($article_table . '.state_site', '1');

        $articles = $articles
            ->where($article_table . '.deleted_at', null, 'IS');
        $article_count = $article_count
            ->where($article_table . '.deleted_at', null, 'IS');

        if ($category_id) {
            $articles = $articles->where($article_table . '.category_id', "%$category_id%", 'like');
            $article_count = $article_count->where($article_table . '.category_id', "%$category_id%", 'like');
        }

        $articles = $articles->where('language' , SOFTWARE_LANG);
        $articles = $articles->groupBy($article_table . '.id');
        if ($order) {
            $articles = $articles->orderBy($article_table . '.orders' ,$order)->orderBy($article_table . '.id' ,'DESC');
        }else {
            $articles = $articles->orderBy($article_table . '.id' , 'DESC');

        }





        $count = $article_count->find();

        $result['items_count'] = $count['count'];
        $result['per_page'] = $this->page_limit;
        $result['count'] = ceil($count['count'] / $this->page_limit);
        $result['current_page'] = ROOT_ADDRESS . '/' . $section . '?page=' . $page;

        for ($x = 0; $x < $result['count']; $x++) {
            $count = ($x + 1);
            $result['links'][] = [
                'index' => $count,
                'link' => ROOT_ADDRESS . '/' . $section . '?page=' . $count
            ];
        }



        if ($page) {
            $offset = ($page - 1) * $this->page_limit;
            $articles = $articles->limit($offset, $this->page_limit);
        }


        $articles = $articles->all(false);

        $result['data'] = $this->addArticleIndexes($articles);
        return $result;
    }

    public function reverseTree($tree, $counter = 0) {

        $first_item = $tree;
        unset($first_item['parent']);
        $result[$counter] = $first_item;


        if (is_array($tree['parent']) && !empty($tree['parent'])) {

//              array_push($result, $tree['parent']);
            $result[$counter + 1] = $this->reverseTree($tree['parent'], $counter + 1);
        }
        return $result;


//        $result = [];
//        $counter = 1;
//
//
//        $first_item = $tree;
//        $result[$counter]=$tree;
//        if (is_array($tree['parent']) && !empty($tree['parent'])) {
//            $data=$this->reverseTree($tree['parent'],$counter+1);
//
//            $result[$counter]=$data;
//        }
//        return $result;
//
//        return $result;//        return ($tree);
////        die();
//
//
//
//         $first_item = $tree;
//        unset($first_item['parent']);
//        if (!is_array($tree['parent']) || empty($tree['parent'])) {
//
//            array_push($result, $tree);
//        }
//
//          if (is_array($tree['parent']) && !empty($tree['parent'])) {
////              array_push($result, $tree['parent']);
//                  array_push($result, $this->reverseTree($tree['parent'],$result));
//        }
//     return $result;

//         if ($is_parent) {
//
// //            unset($tree['parent']);
//             $result = $tree;
//             if (is_array($tree['parent']) && !empty($tree['parent'])) {
//
// //                $result['child'] = $this->reverseTree($tree, true);
//
//             }
//
//         } else {
//             foreach ($tree as $key => $item) {
// //                $result[$counter]=$item;
//                 if (is_array($item['parent']) && !empty($item['parent'])) {
//
// //                $result[$counter]=$this->dddd($item['parent'],$item);
//                     $result[$counter] = $item['parent'];
//
//
//                     $result[$counter]['child'] = $this->reverseTree($item, true);
//
//
//                 }
//                 $counter++;
//             }
//         }
//
//         return $result;

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
                'type' => 'Hotel',
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
                    'type' => 'ExternalHotel',
                    'id' => $destination['city_name_en']
                ];
            }

        }


        $list['pagination'] = [
            'more' => false
        ];

        return json_encode($list, 256);
    }

    public function ListPositionHotel() {
        /** @var hotelCitiesModel $hotel_cities */
        $hotel_cities = Load::getModel('hotelCitiesModel');
        $destinations = $hotel_cities->get()->all();
        $list = [];
        foreach ($destinations as $destination) {
            $list[$destination['id']] = ['name' => $destination['city_name'], 'name_en' => $destination['city_name_en']];
        }

        return $list;
    }

    public function getPath($id, $tree, &$path = array()) {
        foreach ($tree as $item) {
            if ($item['CategoryId'] == $id) {
                array_push($path, $item['CategoryId']);
                return $path;
            }
            if (!empty($item['SubCategories'])) {
                array_push($path, $item['CategoryId']);
                if (getPath($id, $item['SubCategories'], $path) === false) {
                    array_pop($path);
                } else {
                    return $path;
                }

            }
        }
        return false;
    }


    public function GetArticleGalleryData($params) {
        $article_gallery_model = $this->getModel('articleGalleryModel');

        $data = $article_gallery_model->get()
            ->where('article_id', $params['article_id'])
            ->all();

        return $this->returnJson(true, true, $data);
    }

    public function RemoveSingleGallery($Param) {
        $article_gallery_model = $this->getModel('articleGalleryModel');

        $check_exist = $article_gallery_model->get()
            ->where('id', $Param['GalleryId'])
            ->find();

        if ($check_exist) {
            $article_gallery_model->delete([
                'id' => $check_exist['id']
            ]);
            unlink(PIC_ROOT . 'articles/' . $check_exist['file']);
        }

        return $this->returnJson(true, 'حذف شد', $check_exist['id']);
    }

    public function addToGallery($info) {
        $article_gallery_model = $this->getModel('articleGalleryModel');


        if (isset($_FILES['file']) && $_FILES['file'] != "") {
            $config = Load::Config('application');
            $config->pathFile('articles/');
            $_FILES['file']['name'] = self::changeNameUpload($_FILES['file']['name']);
            $success = $config->UploadFile("pic", "file", 5120000);
            $explode_name_pic = explode(':', $success);

            if ($explode_name_pic[0] == "done") {

                $check_exist = $article_gallery_model->get()
                    ->where('article_id', $info['id'])
                    ->where('file', $explode_name_pic[1])
                    ->find();

                if ($check_exist) {
                    $article_gallery_model->delete([
                        'id' => $check_exist['id']
                    ]);
                }
                $insert_result = $article_gallery_model->insertWithBind([
                    'article_id' => $info['id'],
                    'file' => $explode_name_pic[1],
                ]);
                if ($insert_result) {
                    return $this->returnJson(true, 'ثبت گالری با موفقیت انجام شد', $insert_result);
                }
                return $this->returnJson(false, 'خطا در فرایند ثبت گالری');
            }
        }
    }

    public function updateGallery($info) {
        $article_gallery_model = $this->getModel('articleGalleryModel');

        $image = $article_gallery_model
            ->get()
            ->where('id', $info['id'])
            ->find();
        if ($image) {
            $alt = filter_var($info['alt'], FILTER_SANITIZE_STRING);
            $update_result = $article_gallery_model->updateWithBind([
                'alt' => $alt
            ], [
                'id' => $image['id']
            ]);

            if ($update_result) {
                return $this->returnJson(true, 'ویرایش گالری با موفقیت انجام شد', $update_result);
            }
            return $this->returnJson(false, 'خطا در فرایند ویرایش گالری');
        }
    }

    public function controversialArticles($section, $service_id = null, $category_id = null) {

        $article_model = $this->getModel('articleModel');
        $comment_model = $this->getModel('commentModel');
        $article_table = $article_model->getTable();
        $comment_table = $comment_model->getTable();
        $flight_route_customer_model = $this->getModel('flightRouteCustomerModel');
        $flight_route_customer_table = $flight_route_customer_model->getTable();
        $article_positions_model = $this->getModel('articlePositionsModel');
        $article_positions_table = $article_positions_model->getTable();

        $articles = $article_model
            ->get([
                $article_table . '.*',
                'count(comments.id) as comments_count',
            ], true)
            ->join($article_positions_table, 'article_id', 'id');;

        if ($service_id == 'Flight') {
            $articles = $article_model
                ->get([
                    $article_table . '.*',
                    'count(comments.id) as comments_count',
                    $flight_route_customer_table . '.Arrival_City AS positionDisplay',
                    $flight_route_customer_table . '.Arrival_CityEn AS positionDisplayEn',
                ], true)
                ->join($flight_route_customer_table, 'Arrival_Code', 'position');
        }


        $articles = $articles
            ->joinAlias([$comment_table, 'comments'], 'item_id', 'id')
            ->where($article_table . '.deleted_at', null, 'IS')
            ->where($article_table . '.language', SOFTWARE_LANG)
            ->where($article_table . '.section', $section);
        if ($service_id) {
            $articles = $articles->where($article_positions_table . '.service', $service_id);
        }
        if ($category_id) {
            $articles = $articles->where($article_table . '.category_id', "%$category_id%", 'like');
        }

        $articles = $articles
            ->groupBy($article_table . '.id')
            ->orderBy('comments_count')
            ->limit(0, 4);


        $articles = $articles->all(false);
        return $this->addArticleIndexes($articles);
    }

    public function favoriteArticles($section, $service_id = null, $category_id = null , $order = null) {

        $article_model = $this->getModel('articleModel');
        $rate_model = $this->getModel('masterRateModel');
        $article_table = $article_model->getTable();
        $rate_table = $rate_model->getTable();
        $flight_route_customer_model = $this->getModel('flightRouteCustomerModel');
        $flight_route_customer_table = $flight_route_customer_model->getTable();
        $article_positions_model = $this->getModel('articlePositionsModel');
        $article_positions_table = $article_positions_model->getTable();

        $articles = $article_model
            ->get([
                $article_table . '.*',
                'avg(rates.value) as rate_average',
            ], true)
            ->join($article_positions_table, 'article_id', 'id');;

        if ($service_id == 'Flight') {
            $articles = $article_model
                ->get([
                    $article_table . '.*',
                    'avg(rates.value) as rate_average',
                    $flight_route_customer_table . '.Arrival_City AS positionDisplay',
                    $flight_route_customer_table . '.Arrival_CityEn AS positionDisplayEn',
                ], true)
                ->join($flight_route_customer_table, 'Arrival_Code', 'position');
        }


        $articles = $articles
            ->joinAlias([$rate_table, 'rates'], 'item_id', 'id')
            ->where($article_table . '.deleted_at', null, 'IS')
            ->where($article_table . '.language', SOFTWARE_LANG)
            ->where($article_table . '.section', $section)
            ->where($article_table . '.state_site', '1');

        if ($service_id) {
            $articles = $articles->where($article_positions_table . '.service', $service_id);
        }
        if ($category_id) {
            $articles = $articles->where($article_table . '.category_id', "%$category_id%", 'like');
        }

        $articles = $articles
            ->groupBy($article_table . '.id')
            ->orderBy('rate_average')
            ->limit(0, 10);


        $articles = $articles->all(false);
        return $this->addArticleIndexes($articles);
    }

    public function DeleteArticle($formData = []) {
        if (!isset($formData['id'])) {
            return self::returnJson(false, 'مطلب مورد نظر یافت نشد', null, 404);
        }

        $article_model = Load::getModel('articleModel');

        $delete = [
            'deleted_at' => date('Y-m-d H:i:s', time()),
        ];

        if ($article_model->updateWithBind($delete, "id='{$formData['id']}'")) {
            return self::returnJson(true, 'مطلب با موفقیت حذف شد');
        }

        return self::returnJson(false, 'خطا در حذف اطلاعات', null, 400);
    }

    public function ShowOnResult($formData = []) {
        if (!isset($formData['id'])) {
            return self::returnJson(false, 'مطلب مورد نظر یافت نشد', 404);
        }
        /** @var Model $Model */
        $Model = Load::library('Model');
        $Model->setTable($this->articlesTb);
        $remove = $Model->update(['show_on_result' => 0], "service_group='{$formData['serviceGroup']}' AND position='{$formData['position']}' AND id!='{$formData['id']}'");
        $add = $Model->update(['show_on_result' => 1], "id='{$formData['id']}'");
        if ($add && $remove) {
            return self::returnJson(true, 'مطلب با موفقیت بروزرسانی شد');
        }

        return self::returnJson(false, 'خطا در بروزرسانی اطلاعات', 400);
    }

    public function GetListArticles($serviceGroup = null, $position = null) {
        if (!$serviceGroup || !$position) {
            $this->returnJson(false, 'خطا در پارامترهای ارسالی', null, 400);
        }

        $article_model = $this->getModel('articleModel');
        $article_table = $article_model->getTable();
        $article_positions_model = $this->getModel('articlePositionsModel');
        $article_positions_table = $article_positions_model->getTable();


        $articles = $article_model->get([
            $article_table . '.*',
        ], true)
            ->joinAlias([$article_positions_table, 'position'], 'article_id', 'id', 'inner')
            ->where($article_table . '.deleted_at', null, 'IS')
            ->where($article_table . '.language', SOFTWARE_LANG)
            ->where('position.service', $serviceGroup)
            ->where('position.positions', "%$position%", 'like')
            ->all(false);


        if (count($articles) > 0) {
            return $this->returnJson(true, '', ['sticky' => $this->addArticleIndexes($articles)], 200);
        }

        return $this->returnJson(false);
    }

    public function SingleArticle($id, $serviceGroup) {
        $article = [];
        $sql = "SELECT {$this->articlesTb}.* FROM {$this->articlesTb} WHERE service_group='{$serviceGroup}' AND {$this->articlesTb}.deleted_at IS NULL AND {$this->articlesTb}.id = '{$id}';";
        /** @var Model $Model */
        $Model = Load::library('Model');
        $article = $Model->load($sql);
        $article['date'] = functions::ConvertToJalali($article['updated_at'], '/');

        switch ($serviceGroup) {
            case 'Flight' :
                $article['city'] = self::ListPositionFlight()[$article['position']]['name'];
                break;
            case 'internalFlight' :
                $article['city'] = self::ListPositionInternalFlight()[$article['position']]['name'];
                break;
            case 'internationalFlight' :
                $article['city'] = self::ListPositionInternationalFlight()[$article['position']]['name'];
                break;
            case 'Hotel' :
//                $article['city'] = 'awd';
                $article['city'] = self::ListPositionHotel()[$article['position']]['name'];
                break;
            case 'Bus' :
                $article['city'] = self::ListPositionBus()[$article['position']]['name'];
                break;
            case 'Insurance' :
                $article['city'] = self::ListPositionInsurance()[$article['position']]['name'];
                break;
            case 'Train' :
                $article['city'] = self::ListPositionTrain()[$article['position']]['name'];
                break;
            case 'GashtTransfer' :
                $article['city'] = self::ListPositionGashtTransfer()[$article['position']]['name'];
                break;
            case 'Tour' :
                $article['city'] = self::ListPositionTour()[$article['position']]['name'];
                break;
            case 'Visa' :
                $article['city'] = self::ListPositionVisa()[$article['position']]['name'];
                break;
        }
        $article['feature_image'] = $this->featuredImageUrl($article);

        return $article;
    }

    public function articleSelectedToggle($param) {
        $article_id = $param['article_id'];
        $article_model = $this->getModel('articleModel');
        $article = $article_model->get()->where('id', $article_id)->find(false);

        $select_status = 1;
        $final_massage = 'به مقالات ستاره دار اضافه شد';
        if ($article['selected'] == '1') {
            $select_status = 0;
            $final_massage = 'از مقالات ستاره دار حذف شد';
        }
        $update_result = $article_model->updateWithBind([
            'selected' => $select_status
        ], [
            'id' => $article_id
        ]);
        if ($update_result) {
            return functions::JsonSuccess($select_status, [
                'message' => $final_massage,
                'data' => $select_status
            ], 200);
        }
        return functions::JsonError($update_result, [
            'message' => 'خطا در ویرایش مقاله',
            'data' => $select_status
        ], 200);
    }
    public function articleStateMain($param) {
        $article_id = $param['article_id'];
        $article_model = $this->getModel('articleModel');
        $article = $article_model->get()->where('id', $article_id)->find(false);

        $select_status = 1;
        $final_massage = 'در سایت نمایش داده خواهد شد';
        if ($article['state_site'] == '1') {
            $select_status = 0;
            $final_massage = 'از این پس در سایت نمایش داده نخواهد شد';
        }
        $update_result = $article_model->updateWithBind([
            'state_site' => $select_status
        ], [
            'id' => $article_id
        ]);
        if ($update_result) {
            return functions::JsonSuccess($select_status, [
                'message' => $final_massage,
                'data' => $select_status
            ], 200);
        }
        return functions::JsonError($update_result, [
            'message' => 'خطا در تغییر وضعیت نمایش در سایت',
            'data' => $select_status
        ], 200);
    }

    public function RelatedArticles($article_id) {
        $target_article = $this->getArticle($article_id);

        $target_articles = [];
        if (isset($target_article['categories_array']) && $target_article['categories_array']) {


            foreach ($target_article['categories_array'] as $category) {
                $result = $this->getCategoryArticles([
                    'section' => $target_article['section'],
                    'category' => $category['id']
                ]);
                foreach ($result as $article) {
                    if (!in_array($article, $target_articles) && $article['id'] !== $target_article['id']) {
                        $target_articles[] = $article;
                    }
                }
            }
        }

        return $target_articles;
    }

    public function getArticle($id) {

        $article_model = $this->getModel('articleModel');
        $article_table = $article_model->getTable();

        $article = $article_model
            ->get(
                [
                    $article_table . '.*',
                ], true
            )
            ->where($article_table . '.id', $id)
//            ->where($article_table . '.language' , SOFTWARE_LANG)
            ->find(false);


        return $this->addArticleIndexes([$article])[0];
    }

    public function getCategoryArticles($params) {
        if (is_numeric($params['category'])) {
            $category_id = $params['category'];
        } else {
            $category_id = $this->unSlugCategory($params['category'])['id'];
        }
        if (isset($params['limit']) || empty($params['limit'])) {
            $params['limit'] = 10;
        }
        $article_model = $this->getModel('articleModel');
        $categories_model = $this->getModel('articleCategoriesModel');
        $categories_table = $categories_model->getTable();
        $article_table = $article_model->getTable();


        $articles = $article_model
            ->get([$article_table . '.*',], true)
            ->where($article_table . '.language', SOFTWARE_LANG)
            ->where($article_table . '.deleted_at', null, 'IS')
            ->where($article_table . '.section', $params['section']);

        if (is_array($params['category'])) {
            foreach ($params['category'] as $item) {

                $articles = $articles->where($article_table . '.categories', '%"' . $category_id . '"%', 'like');
            }
        } else {
            $articles = $articles->where($article_table . '.categories', '%"' . $category_id . '"%', 'like');
        }

        $articles = $articles->orderBy($article_table . '.updated_at');

        $articles = $articles->limit(0, $params['limit'])->all(false);

        return $this->addArticleIndexes($articles);
    }

    public function unSlugCategory($slug) {
        $categories_model = $this->getModel('articleCategoriesModel');
        return $categories_model
            ->get()
            ->where('slug', $slug)
            ->where('deleted_at', null, 'IS')
            ->find(false);
    }

    public function getSelectedArticles($section, $limit = 5, $offset = 0) {
        $article_model = $this->getModel('articleModel');
        $article_table = $article_model->getTable();

        $articles = $article_model
            ->get(
                [
                    $article_table . '.*',
                ], true
            )
            ->where($article_table . '.deleted_at', null, 'IS')
            ->where($article_table . '.section', $section)
            ->where($article_table . '.selected', '1')
            ->where($article_table . '.state_site', '1')
            ->where($article_table . '.language', SOFTWARE_LANG)
            ->orderBy($article_table . '.updated_at')
            ->limit($offset, $limit)
            ->all(false);

        $articles = $this->addArticleIndexes($articles);

        $result = [];
        if ($limit == 5) {
            foreach ($articles as $key => $article) {
                if ($key <= 1)
                    $result['first_items'][$key] = $article;
                if ($key == 2)
                    $result['center_item'] = $article;
                if ($key >= 3)
                    $result['second_items'][$key] = $article;
            }
        } else {
            $result = $articles;
        }

        return $result;
    }

    public function getCategoryArticle($section, $article) {
        $article_id = $this->getArticleId($section, $article);


        if ($article_id) {
            $article_model = $this->getModel('articleModel');
            $categories_model = $this->getModel('articleCategoriesModel');
            $categories_table = $categories_model->getTable();
            $article_table = $article_model->getTable();

            $article = $article_model
                ->get([$article_table . '.*',], true)
                ->where($article_table . '.section', $section)
                ->where($article_table . '.deleted_at', null, 'IS')
                ->where($article_table . '.id', $article_id)
                ->find(false);


            $comments_controller = $this->getController('comments');
            $article['comments'] = $comments_controller->getAllComments($section, $article['id']);


            return $this->addArticleIndexes([$article])[0];
        }
    }

    /**
     * @param $article
     * @return void
     */
    public function getArticleId($section, $article) {
        if (is_numeric($article)) {
            $article_id = $article;
        } else {
            $article_id = $this->unSlugArticle($section, $article)['id'];
        }

        return $article_id;
    }

    public function unSlugArticle($section, $slug) {
        $article_model = $this->getModel('articleModel');
        $article = $article_model
            ->get()
            ->where('slug', $slug)
            ->where('section', $section)
            ->where('deleted_at', null, 'IS')
            ->find(false);
        return $this->addArticleIndexes([$article])[0];
    }

    /**
     * @param $category
     * @return float|int|mixed|string
     */
    public function getCategoryId($category) {
        if (is_numeric($category)) {
            $category_id = $category;
        } else {
            $category_id = $this->unSlugCategory($category)['id'];
        }
        return $category_id;
    }


    public function getArticlesPosition($data_search) {


        $article_model = $this->getModel('articleModel');
        $article_table = $article_model->getTable();
        $article_positions_model = $this->getModel('positionsModel');



        if ( $data_search['service'] !== 'Public'){
            $positions = $article_positions_model->get()
                ->where('service', $data_search['service'])
                ->all() ;
            $article_ids = $this->getPassedArticleIds($positions, $data_search);
        }

        else{
            $positions = $article_positions_model->get('article_id')
                ->where('service', $data_search['service'])
                ->all() ;
            foreach ($positions as  $position){
                $article_ids[] = $position['article_id'];
            }

        }



        if (empty($data_search['limit'])) {
            $data_search['limit'] = 10;
        }

        $articles = $article_model->get()
            ->whereIn('id', $article_ids)
            ->where($article_table . '.deleted_at', null, 'IS')
            ->where($article_table . '.section', $data_search['section']);

        if ((isset($data_search['selected']) && $data_search['selected'] !== '')) {
            $articles = $articles->where($article_table . '.selected', '1');
        }
        $articles = $articles->orderBy($article_table . '.created_at');


        $articles = $articles->limit(0, $data_search['limit'])->all(false);


        return $this->addArticleIndexes($articles);

    }


    public function getInfoMetaTag($section, $params) {
        if($params['slug'] == 'category'){
            return $this->unSlugCategory($section);
        }
        return $this->unSlugArticle($section, $params['slug']);
    }

    public function getArticlesBySlug($params) {

        return $this->getModel('articleModel')->get()->where('slug', $params['slug'])->where('section', $params['section'])->find();
    }

    public function removeCategory($params) {
        $result = $this->getModel('articleCategoriesModel')->softDelete([
            'id' => $params['id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'دسته بندی مورد نظر حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف', 200);
    }

    /**
     * @param array $positions
     * @param $data_search
     * @return array
     */
    public function getPassedArticleIds(array $positions, $data_search) {
        $article_ids = [];
        foreach ($positions as $position) {
            $article_positions = json_decode($position['positions'], true);
            foreach ($article_positions as $article_position) {
                $first_position = $article_position;
                $second_position = null;
                if (strpos($article_position, ':') !== false) {
                    $exploded=explode(':', $article_position);
                    $first_position=$exploded[0];
                    $second_position=$exploded[1];
                }

                $is_valid_position = false;
                if (array_key_exists('origin', $data_search) && $data_search['origin'] !== '') {
                    $is_valid_position = $this->isValidPosition($data_search['origin'], $first_position, $second_position, $data_search['secondary']);
                }
                if (array_key_exists('destination', $data_search) && $data_search['destination'] !== '' && !$is_valid_position) {
                    $is_valid_position = $this->isValidPosition($data_search['destination'], $first_position, $second_position, $data_search['secondary']);
                }

                if ($is_valid_position && !in_array($position['article_id'], $article_ids)) {
                    $article_ids[] = (int) $position['article_id'];
                }
            }
        }
        return $article_ids;
    }

    private function isValidPosition($search_position, $first_position, $second_position, $secondary_position)
    {
        if (empty($second_position)) {
            return $search_position === $first_position || $first_position === 'all';
        }

        if ($second_position === 'all') {
            return $first_position === 'all' || $search_position === $first_position;
        }

        return ($search_position === $first_position || $first_position === 'all')
            && ($secondary_position === $second_position || $secondary_position === 'all');
    }
    public function getByPosition($data_search) {

        $ids=$this->getItemsByPosition('article',$data_search);
      
        $article_model = $this->getModel('articleModel');
        $article_table = $article_model->getTable();
        if (!isset($data_search['limit']) || empty($data_search['limit'])) {
            $data_search['limit'] = 30;
        }
        $articles=[];
        if($ids){
            $articles=$article_model->get()
                ->where('deleted_at', null, 'IS')
                ->where($article_table . '.state_site', '1')
                ->whereIn($article_table . '.id' , $ids)
                ->whereIn($article_table . '.language' , SOFTWARE_LANG)
                ->orderBy($article_table . '.orders' , 'ASC' )
                ->orderBy($article_table . '.id' , 'DESC' )
                ->limit(0,$data_search['limit'])
                ->all(false);
        }
        return  $this->addArticleIndexes($articles);
    }



    public function change_order($params){
        if (isset($params['data'])) {
            foreach ($params['data'] as $k => $v) {
                $categories_model = $this->getModel('articleCategoriesModel');
                $dataUpdate = [
                    'orders' => $v
                ];
                $check = $categories_model->updateWithBind($dataUpdate, ['id' => $k]);
            }
            return self::returnJson(true, 'درخواست شما با موفقیت انجام شد');
        }else {
            return self::returnJson(true, 'هیچ موردی انتخاب نشده یا تغییری اعمال نشده است');
        }
    }
    public function change_order_article($params){
        if (isset($params['data'])) {
            foreach ($params['data'] as $k => $v) {
                $categories_model = $this->getModel('articleModel');
                $dataUpdate = [
                    'orders' => $v
                ];
                $check = $categories_model->updateWithBind($dataUpdate, ['id' => $k]);
            }
            return self::returnJson(true, 'درخواست شما با موفقیت انجام شد');
        }else {
            return self::returnJson(true, 'هیچ موردی انتخاب نشده یا تغییری اعمال نشده است');
        }
    }





    public function deleteArticleImage($data_delete) {

        $check_exist_article =  $this->getModel('articleModel')->get()->where('id', $data_delete['id'])->find();
        if ($check_exist_article) {
            if($check_exist_article['feature_image'] != ''){
                $path = PIC_ROOT.$check_exist_article['feature_image'];
                unlink($path);
                $data = [
                    'feature_image' => ''
                ];
                $update = $this->getModel('articleModel')->updateWithBind($data, ['id' => $data_delete['id']]);
                if ($update) {
                    return functions::withSuccess('', 200, 'حذف تصویر  با موفقیت انجام شد');
                }
            }
        }

    }


    public function apiGetArticle($params) {
        $result = $this->getByPosition($params);
        return functions::withSuccess($result);
    }




}