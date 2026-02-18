<?php
//if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}


class siteMap extends clientAuth
{

    protected $model = '';

    public function __construct() {
        parent::__construct();
        $this->modelAccess = $this->getModel('gdsAccessAdminModel');
        $this->modelModule = $this->getModel('gdsModuleModel');
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

    public function createSitemap() {

        if(functions::checkClientConfigurationAccess('siteMap')) {

//       var_dump(CLIENT_ID);
//        $file =  'https://' . CLIENT_MAIN_DOMAIN . '/gds/view/' . FRONT_TEMPLATE_NAME . '/project_files/sitemap.xml';
        $file =  'view/' . FRONT_TEMPLATE_NAME . '/project_files/sitemap.xml';

        $current = file_get_contents($file);

        Load::autoload('Model');
        $Model = new Model();
        $list_module_client = $this->modelAccess->get()->where('client_id' , CLIENT_ID)->get()->all();

        foreach ($list_module_client as $key => $value) {
            $get_module_info = $this->modelModule->get()->where('id' , $value['gds_module_id'])->find();
            $resultModule['title'] = $get_module_info['title'];
            $resultModule['controller'] = $get_module_info['gds_controller'];
            $resultModule['table'] = $get_module_info['gds_table'];
            $resultModuleArray[] = $resultModule;

        }

        foreach ($resultModuleArray as $key => $value) {

            $res =  $this->getController($value['controller'])->infoSiteMap($value['table']);
            $result[] = $res;
        }

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:image=\"http://www.google.com/schemas/sitemap-image/1.1\">\n";

        foreach ($result as $k1 => $v1) {
            foreach ($v1 as $k2 => $v2) {
                foreach ($v2 as $k3 => $v3) {
                    $xml .= "\t<url>\n";
                    $xml .= "\t<loc>" . htmlspecialchars($v3['loc']) . "</loc>\n";
                    $xml .= "\t\t<priority>" . $v3['priority'] . "</priority>\n";
                    $xml .= "\t<lastmod>" . $v3['lastmod'] . "</lastmod>\n";
                    $xml .= "\t</url>\n";

                }
            }
        }
        $xml .= "</urlset>";
//        header("Content-type: text/xml");
//        echo $xml;

        $file_handle = fopen($file, 'w+') or die("خطا: سطح دسترسی برای ویرایش فایل در سرور تنظیم نیست!");
        if ($file_handle) {
        fwrite($file_handle, $xml);
            return self::returnJson(true, 'سایت مپ با موفقیت ایجاد شد');
        }else{
            return self::returnJson(false, 'خطا در ایجاد سایت مپ', null, 500);

        }
        }
       else{
           return self::returnJson(false, 'شما دسترسی ایجاد سایت مپ را ندارید، لطفا با پشتیبانی تماس بگیرید', null, 500);
       }



    }




}