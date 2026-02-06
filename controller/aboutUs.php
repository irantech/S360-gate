<?php
//if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}
class aboutUs extends clientAuth {
    public function getData($lang = 'fa') {

        if ($lang) {
            $result =  $this->getModel('aboutUsModel')->get()
                ->where('page_type','about_us')
                ->where('language',$lang)
                ->find();
        } else {
            $result = $this->getModel('aboutUsModel')->get()
                ->where('page_type','about_us')
                ->find();
        }
        return $result;

    }

    public function infoSiteMap($table) {
        $model = $this->getModel('aboutUsModel');
        $table = $model->getTable();
        $result = $model
            ->get([
                $table . '.*',
            ], true);
        $result = $result->all(false);
        $site_home['loc'] = SERVER_HTTP . CLIENT_DOMAIN;
        $site_home['priority'] = '1.0';
        $site_home['lastmodJalali'] = dateTimeSetting::jdate("Y-m-d",time(),'','','en');
        $site_home['lastmod'] = functions::ConvertToMiladi($site_home['lastmodJalali'], '-');
        $home_link[] = $site_home;
//        var_dump($home_link);
//        die;
        foreach ($result as $key => $item) {
            $result_sitemap['loc'] = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/aboutUs';
            $result_sitemap['priority'] = '0.5';
            $result_sitemap['lastmodJalali'] = functions::ConvertToJalali($item['updated_at'], '/');
            $result_sitemap['lastmod'] = functions::ConvertToMiladi($result_sitemap['lastmodJalali'], '-');

            $result_sitemap_final[] = $result_sitemap;
        }

        return [$home_link,$result_sitemap_final];
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


    public function changeNameUpload($fileName) {
        $ext = explode(".", $fileName);
        $fileName = date("sB")."-" . rand(10, 10000);
        $ext = strtolower($ext[count($ext)-1]);
        $fileName = $fileName.".".$ext;
        return $fileName;
    }
    public function update($params) {

        $about_us=$this->getModel('aboutUsModel');
        $media = [];
        foreach ($params['socialLinks'] as $key => $record) {
            if ($record['link']!='' && $record['social_media']!='') {
                $media[$key] = $record;
            }
        }

        $update_data=[
            'summary'=>$params['summary'],
            'title'=>$params['title'],
            'language'=>$params['lang'],
            'video_link'=>$params['video_link'],
            'body'=>$params['body'],
            'about_title_customer_club'=>$params['about_title_customer_club'],
            'about_customer_club'=>$params['about_customer_club'],
            'updated_at'=>date('Y-m-d H:i:s', time()),
//            'social_links'=>json_encode($media, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            'social_links'=>json_encode($params['socialLinks'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        ];
        $last_about_us=$this->getData($params['lang']);

        if (!empty($_FILES['banner_file'])) {


            if($last_about_us['banner_file'] != ''){
                $path = PIC_ROOT . 'aboutUs/'.$last_about_us['banner_file'];
                unlink($path);
            }
            $config = Load::Config('application');
            $config->pathFile( 'aboutUs/' );
            $_FILES['banner_file']['name'] = self::changeNameUpload($_FILES['banner_file']['name']);
            $success = $config->UploadFile("pic", "banner_file", "");
            $file_name = explode(':', $success);
            $update_data['banner_file']=$file_name[1];
        }



        if(!$last_about_us){
            $update_data['page_type']='about_us';
            return $about_us->insertWithBind($update_data);
        }
//        $this->getController('siteMap')->createSitemap();
         return $about_us->updateWithBind($update_data,['page_type' => 'about_us']);

    }
    public function findAboutById($id) {
        return $this->getModel('aboutUsModel')->get()->where('id', $id)->find();
    }
    public function deleteImageAbout($data_delete) {
        $about_model = $this->getModel('aboutUsModel');
        $check_exist_about = $this->findAboutById($data_delete['id']);
        if ($check_exist_about) {
            if($check_exist_about['banner_file'] != ''){
                $path = PIC_ROOT . 'aboutUs/'.$check_exist_about['banner_file'];
                unlink($path);
                $data = [
                    'banner_file' => ''
                ];
                $update = $about_model->updateWithBind($data, ['id' => $data_delete['id']]);
                if ($update) {
                    return functions::withSuccess('', 200, 'حذف تصویر  با موفقیت انجام شد');
                }
            }
        }

    }


}