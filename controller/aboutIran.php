<?php
//if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}
class aboutIran extends clientAuth {

    private $parvazUrl;
    private $tunnel ;
    public function __construct() {
        $this->tunnel = tunnel_url;
        parent::__construct();
        if (strpos($_SERVER['HTTP_HOST'], '192.168.') === false) {
            if ( SOFTWARE_LANG == 'fa' ) {
                $this->parvazUrl = 'https://www.iran-tech.com/old/v10/fa/admin/city/';

            }else{
                $this->parvazUrl = 'https://s360.iran-tech.com/gds/aboutIran/';
            }

        } else{
            if ( SOFTWARE_LANG == 'en' ) {
                $this->parvazUrl = 'http://192.168.1.100/1011/gds/aboutIran/';
            }elseif (SOFTWARE_LANG == 'ar') {
                $this->parvazUrl = 'http://192.168.1.100/1011/gds/aboutIran/';
            }else {
                $this->parvazUrl = 'http://192.168.1.100/parvaz_persian/fa/admin/city/';
            }
        }

    }

    function my_substr($text, $start = 0, $end) {
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
    public function GetCity() {
        $url = $this->parvazUrl.'gds_list_city.php';
        return $this->getResult($url) ;
    }

    public function getAboutIran($id) {
        $url = $this->parvazUrl.'gds_city_info.php?id='.$id;
        return $this->getResult($url) ;
    }

    public function getAncient($id) {
        $url = $this->parvazUrl.'gds_list_ancient.php?id='.$id;
        return $this->getResult($url) ;
    }

    public function getAncientInfo($id) {
        $url = $this->parvazUrl.'gds_ancient_info.php?id='.$id;
        return $this->getResult($url) ;
    }
    private function getResult($iran_tech_url) {

        if (strpos($_SERVER['HTTP_HOST'], '192.168.') === false) {
            return functions::curlExecution($iran_tech_url , '');
        }else{
            $data['safar360_url'] = $iran_tech_url ;
            return functions::curlExecution($this->tunnel ,json_encode($data));
        }
    }
}